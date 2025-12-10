<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\MateriPembelajaran;
use Illuminate\Support\Facades\Auth;

class MateriPembelajaranController extends Controller
{
    public function edit(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $mataPelajaran = $request->get('mata_pelajaran');
        if (!$mataPelajaran) {
            $mataPelajaranList = $guru->mataPelajaranAktif;
            if ($mataPelajaranList->count() > 0) {
                $mataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
            } else {
                return redirect()->route('guru.dashboard')->with('error', 'Mata pelajaran tidak ditemukan');
            }
        }

        $materiPembelajaran = MateriPembelajaran::where('guru_id', $guru->id)
            ->where('mata_pelajaran', $mataPelajaran)
            ->first();

        // Jika belum ada, buat default dengan konten baru
        if (!$materiPembelajaran) {
            $materiPembelajaran = new MateriPembelajaran();
            $materiPembelajaran->guru_id = $guru->id;
            $materiPembelajaran->mata_pelajaran = $mataPelajaran;
            
            // Set default values untuk field baru
            $materiPembelajaran->identitas_sekolah_program = "Nama Sekolah : Mts Nurul Aiman\n\nMata Pelajaran : {$mataPelajaran}\n\nKelas : IX\n\nAlokasi Waktu : 12 x 40 menit per unit\n\nJumlah Pertemuan : 6 pertemuan per unit\n\nTahun Ajaran : 2025-2026";
            $materiPembelajaran->kompetensi_inti_capaian = "";
            $materiPembelajaran->unit_pembelajaran = "";
            $materiPembelajaran->pendekatan_pembelajaran = "";
            $materiPembelajaran->model_pembelajaran = "";
            $materiPembelajaran->kegiatan_pembelajaran = "";
            $materiPembelajaran->penilaian = "";
            $materiPembelajaran->sarana_prasarana = "";
        }

        $mataPelajaranList = $guru->mataPelajaranAktif;

        return view('guru.materi-pembelajaran.edit', compact('guru', 'materiPembelajaran', 'mataPelajaran', 'mataPelajaranList'));
    }

    public function update(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'mata_pelajaran' => 'required|string',
            'identitas_sekolah_program' => 'nullable|string',
            'kompetensi_inti_capaian' => 'nullable|string',
            'unit_pembelajaran' => 'nullable|string',
            'pendekatan_pembelajaran' => 'nullable|string',
            'model_pembelajaran' => 'nullable|string',
            'kegiatan_pembelajaran' => 'nullable|string',
            'penilaian' => 'nullable|string',
            'sarana_prasarana' => 'nullable|string',
        ]);

        $materiPembelajaran = MateriPembelajaran::updateOrCreate(
            [
                'guru_id' => $guru->id,
                'mata_pelajaran' => $request->mata_pelajaran,
            ],
            [
                'identitas_sekolah_program' => $request->identitas_sekolah_program,
                'kompetensi_inti_capaian' => $request->kompetensi_inti_capaian,
                'unit_pembelajaran' => $request->unit_pembelajaran,
                'pendekatan_pembelajaran' => $request->pendekatan_pembelajaran,
                'model_pembelajaran' => $request->model_pembelajaran,
                'kegiatan_pembelajaran' => $request->kegiatan_pembelajaran,
                'penilaian' => $request->penilaian,
                'sarana_prasarana' => $request->sarana_prasarana,
            ]
        );

        return redirect()->route('guru.dashboard', ['mata_pelajaran' => $request->mata_pelajaran])
            ->with('success', 'Materi pembelajaran berhasil diperbarui');
    }
}
