<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'surat_sakit' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'tugas_kelas_7' => 'nullable|string|max:1000',
            'tugas_kelas_8' => 'nullable|string|max:1000',
            'tugas_kelas_9' => 'nullable|string|max:1000',
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
            'surat_sakit.file' => 'File surat sakit harus berupa file',
            'surat_sakit.mimes' => 'File surat sakit harus berformat PDF, PNG, atau JPG',
            'surat_sakit.max' => 'Ukuran file surat sakit maksimal 5MB',
            'tugas_kelas_7.max' => 'Instruksi untuk kelas 7 maksimal 1000 karakter',
            'tugas_kelas_8.max' => 'Instruksi untuk kelas 8 maksimal 1000 karakter',
            'tugas_kelas_9.max' => 'Instruksi untuk kelas 9 maksimal 1000 karakter',
        ]);

        // Pastikan guru yang sakit/izin memberikan tugas minimal untuk satu kelas
        $tugasKelas7 = trim((string) $request->input('tugas_kelas_7', ''));
        $tugasKelas8 = trim((string) $request->input('tugas_kelas_8', ''));
        $tugasKelas9 = trim((string) $request->input('tugas_kelas_9', ''));

        if (in_array($request->jenis, ['sakit', 'izin'], true)) {
            $tugasFilled = collect([$tugasKelas7, $tugasKelas8, $tugasKelas9])
                ->filter(fn ($value) => !empty($value))
                ->count();

            if ($tugasFilled === 0) {
                return redirect()->route('guru.presensi.index')
                    ->withInput()
                    ->withErrors([
                        'tugas_kelas_7' => 'Guru wajib memberikan tugas minimal untuk satu kelas ketika memilih presensi sakit atau izin.',
                    ]);
            }
        } else {
            // Jika hadir, set tugas menjadi null
            $tugasKelas7 = $tugasKelas8 = $tugasKelas9 = null;
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

        // Handle file upload surat sakit
        $suratSakitPath = null;
        if ($request->hasFile('surat_sakit')) {
            $file = $request->file('surat_sakit');
            $filename = time() . '_' . $guru->id . '_' . $file->getClientOriginalName();
            $suratSakitPath = $file->storeAs('public/presensi/surat_sakit', $filename);
            // Remove 'public/' prefix for database storage
            $suratSakitPath = str_replace('public/', '', $suratSakitPath);
        }

        // Create presensi
        Presensi::create([
            'guru_id' => $guru->id,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'jam_masuk' => ($request->jenis === 'hadir' || $request->jenis === 'sakit') ? $request->jam_masuk : null,
            'jam_keluar' => $request->jam_keluar ?? null,
            'keterangan' => $request->keterangan,
            'surat_sakit' => $suratSakitPath,
            'tugas_kelas_7' => $tugasKelas7 ?: null,
            'tugas_kelas_8' => $tugasKelas8 ?: null,
            'tugas_kelas_9' => $tugasKelas9 ?: null,
            'status_verifikasi' => 'pending',
        ]);

    
    $jenisText = ucfirst($request->jenis);
    return redirect()->route('guru.presensi.index', ['view' => 'riwayat'])
        ->with('success', "Presensi {$jenisText} berhasil dikirim untuk tanggal {$request->tanggal}. Menunggu verifikasi dari TU.");
    }
}
