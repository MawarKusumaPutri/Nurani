<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Guru;
use App\Services\ActivityTracker;
use App\Mail\LoginNotification;
use App\Mail\LogoutNotification;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Debug: Log request data
        \Log::info('Login attempt:', [
            'email' => $request->email,
            'role' => $request->role,
            'has_password' => !empty($request->password),
            'all_data' => $request->all()
        ]);
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|in:guru,tu,kepala_sekolah'
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;

        // Cari user berdasarkan email dan role yang spesifik
        $user = User::where('email', $credentials['email'])
                   ->where('role', $role)
                   ->first();

        \Log::info('User search result:', [
            'user_found' => $user ? true : false,
            'user_name' => $user ? $user->name : null,
            'user_role' => $user ? $user->role : null
        ]);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            \Log::info('Login successful for user:', ['name' => $user->name, 'email' => $user->email]);
            Auth::login($user);
            
            // Track guru login activity
            if ($role === 'guru') {
                $guru = Guru::where('user_id', $user->id)->first();
                if ($guru) {
                    ActivityTracker::trackLogin($guru, $request);
                }
            }
            
            // Kirim notifikasi email login - SINKRON OTOMATIS
            // Email notifikasi dikirim ke email yang sama dengan email yang digunakan untuk login
            // Contoh: Login dengan mawarkusuma694@gmail.com → Notifikasi masuk ke mawarkusuma694@gmail.com
            try {
                // Pastikan email dikirim secara synchronous (langsung, bukan queue)
                Mail::to($user->email)->send(new LoginNotification($user, $request->ip(), $request->userAgent()));
                
                \Log::info('✅ Login notification email sent successfully:', [
                    'email' => $user->email,
                    'name' => $user->name,
                    'role' => $user->role,
                    'mail_driver' => config('mail.default'),
                    'mail_host' => config('mail.mailers.smtp.host'),
                    'timestamp' => now()->toDateTimeString()
                ]);
            } catch (\Exception $e) {
                \Log::error('❌ Failed to send login notification email:', [
                    'email' => $user->email,
                    'name' => $user->name,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'mail_driver' => config('mail.default'),
                    'mail_host' => config('mail.mailers.smtp.host'),
                    'timestamp' => now()->toDateTimeString()
                ]);
                
                // Log error juga ke console untuk debugging
                \Log::channel('single')->error('Email notification failed', [
                    'user' => $user->email,
                    'error' => $e->getMessage()
                ]);
            }
            
            // Redirect berdasarkan role
            switch ($role) {
                case 'guru':
                    return redirect()->route('guru.dashboard');
                case 'tu':
                    return redirect()->route('tu.dashboard');
                case 'kepala_sekolah':
                    return redirect()->route('kepala_sekolah.dashboard');
                default:
                    return redirect()->route('guru.dashboard');
            }
        } else {
            \Log::info('Login failed:', [
                'user_found' => $user ? true : false,
                'password_check' => $user ? Hash::check($credentials['password'], $user->password) : false
            ]);
        }

        $roleText = match($role) {
            'guru' => 'guru',
            'tu' => 'tenaga usaha',
            'kepala_sekolah' => 'kepala sekolah',
            default => 'pengguna'
        };

        return back()->withErrors([
            'email' => 'Email atau password tidak valid. Pastikan Anda adalah ' . $roleText . ' yang terdaftar.',
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
            
            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('welcome')->with('success', 'Anda telah berhasil logout.');
        } catch (\Exception $e) {
            // If logout fails, just redirect to welcome page
            return redirect()->route('welcome');
        }
    }
}
