<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanKesiswaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        
        // Get user data based on role
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.index', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('kegiatan-kesiswaan.index', compact('role'));
        } elseif ($role === 'tu') {
            return view('kegiatan-kesiswaan.index', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function rencana()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.rencana', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('kegiatan-kesiswaan.rencana', compact('role'));
        } elseif ($role === 'tu') {
            return view('kegiatan-kesiswaan.rencana', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function monitoring()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.monitoring', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('kegiatan-kesiswaan.monitoring', compact('role'));
        } elseif ($role === 'tu') {
            return view('kegiatan-kesiswaan.monitoring', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function laporan()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.laporan', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('kegiatan-kesiswaan.laporan', compact('role'));
        } elseif ($role === 'tu') {
            return view('kegiatan-kesiswaan.laporan', compact('role'));
        }
        
        return redirect()->route('login');
    }
}

