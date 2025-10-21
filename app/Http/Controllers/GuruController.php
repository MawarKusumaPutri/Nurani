<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\Rangkuman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function dashboard()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // Statistik dashboard
        $totalMateri = $guru->materi()->count();
        $materiPublished = $guru->materi()->where('is_published', true)->count();
        $totalKuis = $guru->kuis()->count();
        $totalRangkuman = $guru->rangkuman()->count();
        
        // Materi terbaru
        $materiTerbaru = $guru->materi()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Kuis aktif
        $kuisAktif = $guru->kuis()
            ->where('is_active', true)
            ->where('tanggal_selesai', '>', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(3)
            ->get();
            
        // Rangkuman bulan ini
        $rangkumanBulanIni = $guru->rangkuman()
            ->whereMonth('tanggal_pertemuan', now()->month)
            ->whereYear('tanggal_pertemuan', now()->year)
            ->count();

        return view('guru.dashboard', compact(
            'guru',
            'totalMateri',
            'materiPublished',
            'totalKuis',
            'totalRangkuman',
            'materiTerbaru',
            'kuisAktif',
            'rangkumanBulanIni'
        ));
    }

    public function profil()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        return view('guru.profil', compact('guru'));
    }

    public function updateProfil(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biodata' => 'nullable|string',
            'kontak' => 'nullable|string|max:255',
            'keahlian' => 'nullable|string'
        ]);

        // Update data user
        $guru->user->update([
            'name' => $request->nama
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::exists($guru->foto)) {
                Storage::delete($guru->foto);
            }
            
            $fotoPath = $request->file('foto')->store('guru/foto', 'public');
            $guru->foto = $fotoPath;
        }

        // Update data guru
        $guru->update([
            'nip' => $request->nip,
            'mata_pelajaran' => $request->mata_pelajaran,
            'biodata' => $request->biodata,
            'kontak' => $request->kontak,
            'keahlian' => $request->keahlian
        ]);

        return redirect()->route('guru.profil')->with('success', 'Profil berhasil diperbarui');
    }
}
