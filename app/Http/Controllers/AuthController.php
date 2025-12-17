<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Guru;
use App\Services\ActivityTracker;
use App\Mail\LoginNotification;
use App\Mail\LogoutNotification;
use App\Mail\PasswordResetNotification;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // VALIDASI CEPAT - TIDAK ADA LOGGING
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|in:guru,tu,kepala_sekolah'
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;

        // Cari user - QUERY OPTIMIZED
        $user = User::where('email', $credentials['email'])
                   ->where('role', $role)
                   ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Handle remember me
            $remember = $request->has('remember') && $request->remember == '1';
            Auth::login($user, $remember);
            
            // Redirect berdasarkan role user yang SEBENARNYA dari database (bukan dari request)
            $userRole = $user->role;
            
            // Pastikan redirect URL sesuai dengan role
            $redirectUrl = match($userRole) {
                'guru' => route('guru.dashboard'),
                'tu' => route('tu.dashboard'),
                'kepala_sekolah' => route('kepala_sekolah.dashboard'),
                default => route('guru.dashboard')
            };
            
            // DISABLE SEMUA OPERASI BACKGROUND UNTUK MEMPERCEPAT LOGIN
            // Activity tracking dan email akan di-skip sementara
            
            // Jika request AJAX atau memiliki header X-Requested-With, return JSON
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl,
                    'message' => 'Login berhasil',
                    'role' => $userRole
                ]);
            }
            
            // LANGSUNG REDIRECT - TIDAK ADA OPERASI LAIN
            // Gunakan redirect()->intended() sebagai fallback jika ada intended URL
            return redirect()->intended($redirectUrl);
        } else {
            // DISABLE LOGGING UNTUK MEMPERCEPAT LOGIN
            // \Log::info('Login failed:', [
            //     'user_found' => $user ? true : false,
            //     'password_check' => $user ? Hash::check($credentials['password'], $user->password) : false
            // ]);
        }

        $roleText = match($role) {
            'guru' => 'guru',
            'tu' => 'tenaga usaha',
            'kepala_sekolah' => 'kepala sekolah',
            default => 'pengguna'
        };

        $errorMessage = 'Email atau password tidak valid. Pastikan Anda adalah ' . $roleText . ' yang terdaftar.';
        
        // Jika request AJAX atau memiliki header X-Requested-With, return JSON
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => false,
                'error' => $errorMessage
            ], 422);
        }

        return back()->withErrors([
            'email' => $errorMessage,
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Track guru logout activity before logout
            if ($user && $user->role === 'guru') {
                $guru = Guru::where('user_id', $user->id)->first();
                if ($guru) {
                    ActivityTracker::trackLogout($guru, $request);
                }
            }
            
            // Kirim notifikasi email logout - SINKRON OTOMATIS
            // Email notifikasi dikirim ke email yang sama dengan email yang digunakan untuk login
            if ($user) {
                try {
                    Mail::to($user->email)->send(new LogoutNotification($user, $request->ip()));
                    \Log::info('Logout notification email sent to:', [
                        'email' => $user->email,
                        'name' => $user->name,
                        'role' => $user->role
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to send logout notification email:', [
                        'email' => $user->email,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Check if user is authenticated before logout
            if (Auth::check()) {
                Auth::logout();
            }
            
            // Invalidate session (handle jika session sudah expired)
            try {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            } catch (\Exception $e) {
                // Jika session sudah expired, tidak perlu invalidate lagi
                \Log::info('Session already expired during logout');
            }
            
            // Redirect langsung ke welcome tanpa pesan
            return redirect()->route('welcome');
        } catch (\Exception $e) {
            // If logout fails, just redirect to welcome page
            \Log::error('Logout error: ' . $e->getMessage());
            return redirect()->route('welcome');
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:guru,tu,kepala_sekolah'
        ]);

        $user = User::where('email', $request->email)
                   ->where('role', $request->role)
                   ->first();

        if (!$user) {
            $roleText = match($request->role) {
                'guru' => 'guru',
                'tu' => 'tenaga usaha',
                'kepala_sekolah' => 'kepala sekolah',
                default => 'pengguna'
            };

            return back()->withErrors([
                'email' => 'Email tidak ditemukan untuk ' . $roleText . ' yang terdaftar.',
            ])->withInput();
        }

        // Generate reset token
        $token = Str::random(64);
        
        // Simpan token ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Generate reset URL
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);
        
        // Coba kirim email jika SMTP sudah dikonfigurasi (opsional, tidak menghalangi proses)
        $mailDriver = config('mail.default');
        $mailUsername = env('MAIL_USERNAME');
        
        if ($mailDriver !== 'log' && !empty($mailUsername)) {
            try {
                // Kirim email reset password - SINKRON OTOMATIS
                // Email dikirim ke email yang sama dengan email yang digunakan untuk request reset
                Mail::to($user->email)->send(new PasswordResetNotification($user, $resetUrl));
                
                \Log::info('✅ Password reset link sent successfully:', [
                    'email' => $user->email,
                    'name' => $user->name,
                    'role' => $user->role,
                    'mail_driver' => config('mail.default'),
                    'mail_host' => config('mail.mailers.smtp.host'),
                    'reset_url' => $resetUrl,
                    'timestamp' => now()->toDateTimeString()
                ]);
            } catch (\Exception $e) {
                \Log::error('❌ Failed to send password reset email (continuing anyway):', [
                    'email' => $user->email,
                    'name' => $user->name,
                    'error' => $e->getMessage(),
                    'mail_driver' => config('mail.default'),
                    'mail_host' => config('mail.mailers.smtp.host'),
                    'timestamp' => now()->toDateTimeString()
                ]);
                // Email gagal terkirim, tapi tetap lanjutkan ke halaman reset password
            }
        }
        
        // Langsung redirect ke halaman reset password - MEMPERMUDAH GURU
        // Tidak perlu menampilkan link, langsung ke form reset password
        return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email])
                         ->with('status', 'Silakan masukkan password baru Anda.');
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->email;
        
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Cek token valid
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.'])->withInput();
        }

        // Cek token cocok
        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.'])->withInput();
        }

        // Cek token belum kadaluarsa (60 menit)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset password sudah kadaluarsa. Silakan request ulang.'])->withInput();
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Hapus token
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            \Log::info('✅ Password reset successful:', [
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role,
                'timestamp' => now()->toDateTimeString()
            ]);

            // Redirect berdasarkan role untuk mempermudah
            $roleText = match($user->role) {
                'guru' => 'Guru',
                'tu' => 'Tenaga Usaha',
                'kepala_sekolah' => 'Kepala Sekolah',
                default => 'Pengguna'
            };

            return redirect()->route('login')
                         ->with('status', 'Password berhasil direset! Silakan login dengan password baru sebagai ' . $roleText . '.');
        }

        return back()->withErrors(['email' => 'User tidak ditemukan.'])->withInput();
    }

    /**
     * Get users by role for auto-fill
     */
    public function getUsersByRole(Request $request)
    {
        $role = $request->query('role');
        
        if (!$role || !in_array($role, ['guru', 'tu', 'kepala_sekolah'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid role'
            ], 400);
        }
        
        $users = User::where('role', $role)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
        
        return response()->json([
            'success' => true,
            'users' => $users,
            'count' => $users->count()
        ]);
    }
}
