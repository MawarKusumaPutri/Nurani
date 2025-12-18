<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliKelasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('wali-kelas.index', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('wali-kelas.index', compact('role'));
        } elseif ($role === 'tu') {
            return view('wali-kelas.index', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function rencana()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('wali-kelas.rencana', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('wali-kelas.rencana', compact('role'));
        } elseif ($role === 'tu') {
            return view('wali-kelas.rencana', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function monitoring()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('wali-kelas.monitoring', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('wali-kelas.monitoring', compact('role'));
        } elseif ($role === 'tu') {
            return view('wali-kelas.monitoring', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function laporan()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('wali-kelas.laporan', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('wali-kelas.laporan', compact('role'));
        } elseif ($role === 'tu') {
            return view('wali-kelas.laporan', compact('role'));
        }
        
        return redirect()->route('login');
    }
}

