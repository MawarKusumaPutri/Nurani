<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Display presensi form and history
     */
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // Check if already presensi today
        $todayPresensi = Presensi::where('guru_id', $guru->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        // Get presensi history (last 30 days)
        $presensiHistory = Presensi::where('guru_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();

        return view('guru.presensi.index', compact('guru', 'todayPresensi', 'presensiHistory'));
    }

    /**
     * Store new presensi
     */
    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $validated = $request->validate([
            'jenis' => 'required|in:hadir,sakit,izin',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required_if:jenis,hadir|required_if:jenis,sakit|nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i|after:jam_masuk',
            'keterangan' => 'required_if:jenis,izin|nullable|string|max:500',
<<<<<<< HEAD
            'tugas_kelas_7' => 'nullable|string|max:1000',
            'tugas_kelas_8' => 'nullable|string|max:1000',
            'tugas_kelas_9' => 'nullable|string|max:1000',
=======
            'tugas_kelas7' => 'nullable|string|max:500',
            'tugas_kelas8' => 'nullable|string|max:500',
            'tugas_kelas9' => 'nullable|string|max:500',
>>>>>>> de19a31 (memperbaiki presensi guru 2)
        ], [
            'jenis.required' => 'Jenis presensi harus dipilih',
            'jenis.in' => 'Jenis presensi tidak valid',
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Tanggal tidak valid',
            'jam_masuk.required_if' => 'Jam masuk harus diisi untuk presensi hadir dan sakit',
            'jam_masuk.date_format' => 'Format jam masuk tidak valid',
            'jam_keluar.after' => 'Jam keluar harus setelah jam masuk',
            'keterangan.required_if' => 'Keterangan harus diisi untuk izin',
            'keterangan.max' => 'Keterangan maksimal 500 karakter',
<<<<<<< HEAD
            'tugas_kelas_7.max' => 'Instruksi untuk kelas 7 maksimal 1000 karakter',
            'tugas_kelas_8.max' => 'Instruksi untuk kelas 8 maksimal 1000 karakter',
            'tugas_kelas_9.max' => 'Instruksi untuk kelas 9 maksimal 1000 karakter',
        ]);

        $tugasKelas7 = trim((string) $request->input('tugas_kelas_7'));
        $tugasKelas8 = trim((string) $request->input('tugas_kelas_8'));
        $tugasKelas9 = trim((string) $request->input('tugas_kelas_9'));

        if (in_array($request->jenis, ['sakit', 'izin'], true)) {
            if ($tugasKelas7 === '' && $tugasKelas8 === '' && $tugasKelas9 === '') {
                return redirect()->route('guru.presensi.index')
                    ->withInput()
                    ->withErrors([
                        'tugas_kelas_7' => 'Minimal isi satu instruksi tugas untuk kelas 7, 8, atau 9 saat guru tidak hadir.',
                    ]);
            }
        } else {
            $tugasKelas7 = $tugasKelas8 = $tugasKelas9 = null;
=======
            'tugas_kelas7.max' => 'Instruksi tugas kelas 7 maksimal 500 karakter',
            'tugas_kelas8.max' => 'Instruksi tugas kelas 8 maksimal 500 karakter',
            'tugas_kelas9.max' => 'Instruksi tugas kelas 9 maksimal 500 karakter',
        ]);

        // Pastikan guru yang sakit/izin memberikan tugas minimal untuk satu kelas
        if (in_array($request->jenis, ['sakit', 'izin'])) {
            $tugasFilled = collect([
                $request->tugas_kelas7,
                $request->tugas_kelas8,
                $request->tugas_kelas9,
            ])->filter(fn ($value) => !empty(trim((string) $value)))->count();

            if ($tugasFilled === 0) {
                return back()
                    ->withErrors([
                        'tugas_kelas7' => 'Guru wajib memberikan tugas minimal untuk satu kelas ketika memilih presensi sakit atau izin.'
                    ])
                    ->withInput();
            }
>>>>>>> de19a31 (memperbaiki presensi guru 2)
        }

        // Check if already presensi on this date
        $existingPresensi = Presensi::where('guru_id', $guru->id)
            ->whereDate('tanggal', $request->tanggal)
            ->first();

        if ($existingPresensi) {
            $jenisLama = ucfirst($existingPresensi->jenis);
            return redirect()->route('guru.presensi.index')
                ->with('error', "Anda sudah melakukan presensi untuk tanggal ini ({$request->tanggal}) sebagai {$jenisLama}. Setiap tanggal hanya bisa diisi sekali.");
        }

        // Create presensi
        Presensi::create([
            'guru_id' => $guru->id,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'jam_masuk' => ($request->jenis === 'hadir' || $request->jenis === 'sakit') ? $request->jam_masuk : null,
            'jam_keluar' => $request->jam_keluar ?? null,
            'keterangan' => $request->keterangan,
<<<<<<< HEAD
            'tugas_kelas_7' => $tugasKelas7 ?: null,
            'tugas_kelas_8' => $tugasKelas8 ?: null,
            'tugas_kelas_9' => $tugasKelas9 ?: null,
=======
            'tugas_kelas7' => $request->tugas_kelas7,
            'tugas_kelas8' => $request->tugas_kelas8,
            'tugas_kelas9' => $request->tugas_kelas9,
>>>>>>> de19a31 (memperbaiki presensi guru 2)
            'status_verifikasi' => 'pending',
        ]);

        $jenisText = ucfirst($request->jenis);
        return redirect()->route('guru.presensi.index')
            ->with('success', "Presensi {$jenisText} berhasil dikirim untuk tanggal {$request->tanggal}. Menunggu verifikasi dari TU.");
    }
}
