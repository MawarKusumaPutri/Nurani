<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KurikulumController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kurikulum.index', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('kurikulum.index', compact('role'));
        } elseif ($role === 'tu') {
            return view('kurikulum.index', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function rencana()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kurikulum.rencana', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('kurikulum.rencana', compact('role'));
        } elseif ($role === 'tu') {
            return view('kurikulum.rencana', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function monitoring()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kurikulum.monitoring', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('kurikulum.monitoring', compact('role'));
        } elseif ($role === 'tu') {
            return view('kurikulum.monitoring', compact('role'));
        }
        
        return redirect()->route('login');
    }
    
    public function laporan()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kurikulum.laporan', compact('guru', 'role'));
        } elseif ($role === 'kepala_sekolah') {
            return view('kurikulum.laporan', compact('role'));
        } elseif ($role === 'tu') {
            return view('kurikulum.laporan', compact('role'));
        }
        
        return redirect()->route('login');
    }
}

