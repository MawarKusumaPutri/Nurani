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
    public function dashboard(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // Get mata pelajaran yang dipilih (default: pertama)
        $selectedMataPelajaran = $request->get('mata_pelajaran');        
        // Parse mata pelajaran from guru record
        $mataPelajaranList = collect();
        if ($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan') {
            $subjects = explode(', ', $guru->mata_pelajaran);
            foreach ($subjects as $subject) {
                $mataPelajaranList->push((object)[
                    'mata_pelajaran' => trim($subject)
                ]);
            }
        }
        
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        // Statistik dashboard berdasarkan mata pelajaran yang dipilih
        $query = $guru->materi();
        if ($selectedMataPelajaran) {
            $query->where('mata_pelajaran', $selectedMataPelajaran);
        }
        
        $totalMateri = $query->count();
        $materiPublished = $query->where('is_published', true)->count();
        
        $kuisQuery = $guru->kuis();
        if ($selectedMataPelajaran) {
            $kuisQuery->where('mata_pelajaran', $selectedMataPelajaran);
        }
        $totalKuis = $kuisQuery->count();
        
        $rangkumanQuery = $guru->rangkuman();
        if ($selectedMataPelajaran) {
            $rangkumanQuery->where('mata_pelajaran', $selectedMataPelajaran);
        }
        $totalRangkuman = $rangkumanQuery->count();
        
        // Materi terbaru berdasarkan mata pelajaran
        $materiTerbaru = $query
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Kuis aktif berdasarkan mata pelajaran
        $kuisAktif = $kuisQuery
            ->where('is_active', true)
            ->where('tanggal_selesai', '>', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(3)
            ->get();
            
        // Rangkuman bulan ini berdasarkan mata pelajaran
        $rangkumanBulanIni = $rangkumanQuery
            ->whereMonth('tanggal_pertemuan', now()->month)
            ->whereYear('tanggal_pertemuan', now()->year)
            ->count();

        return view('guru.dashboard', compact(
            'guru',
            'mataPelajaranList',
            'selectedMataPelajaran',
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
