<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
