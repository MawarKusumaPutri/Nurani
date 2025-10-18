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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        // Cari user berdasarkan email dengan role guru atau tenaga usaha
        $user = User::where('email', $credentials['email'])
                   ->whereIn('role', ['guru', 'tenaga_usaha'])
                   ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            
            // Redirect berdasarkan role
            if ($user->role === 'tenaga_usaha') {
                return redirect()->route('tu.dashboard');
            } else {
                return redirect()->route('guru.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid. Pastikan Anda adalah guru atau tenaga usaha yang terdaftar.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
