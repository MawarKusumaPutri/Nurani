<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\RubrikPenilaian;
use App\Models\LembarPenilaian;
use App\Models\NilaiFormatifSumatif;
use App\Models\RekapHasilBelajar;
use App\Models\Siswa;
use App\Models\Kuis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EvaluasiGuruController extends Controller
{
    /**
     * Index - Menampilkan halaman utama Evaluasi Guru
     */
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        return view('guru.evaluasi.index', compact('guru'));
    }

    /**
     * RUBRIK PENILAIAN
     */
    public function rubrikIndex(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $selectedMataPelajaran = $request->get('mata_pelajaran');
        $mataPelajaranList = $guru->mataPelajaranAktif;
        
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        $tableExists = Schema::hasTable('rubrik_penilaian');
        $rubrik = collect();
        
        // Jika tabel belum ada, coba buat secara otomatis
        if (!$tableExists) {
            try {
                $this->createEvaluasiTables();
                // Refresh schema cache
                Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
                $tableExists = Schema::hasTable('rubrik_penilaian');
            } catch (\Exception $e) {
                // Jika gagal membuat, tetap lanjutkan dengan pesan error
                \Log::error('Error creating rubrik_penilaian table: ' . $e->getMessage());
            }
        }
        
        if ($tableExists) {
            try {
                $query = RubrikPenilaian::where('guru_id', $guru->id);
                if ($selectedMataPelajaran) {
                    $query->where('mata_pelajaran', $selectedMataPelajaran);
                }
                $rubrik = $query->orderBy('created_at', 'desc')->paginate(10);
            } catch (\Exception $e) {
                // Handle error
            }
        }

        return view('guru.evaluasi.rubrik.index', compact('guru', 'rubrik', 'mataPelajaranList', 'selectedMataPelajaran', 'tableExists'));
    }

    public function rubrikCreate()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $mataPelajaranList = $guru->mataPelajaranAktif;
        
        return view('guru.evaluasi.rubrik.create', compact('guru', 'mataPelajaranList'));
    }

    public function rubrikStore(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_pelajaran' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'kriteria_penilaian' => 'nullable|string',
            'skala_nilai' => 'nullable|string',
            'indikator' => 'nullable|string',
        ]);

        $validated['guru_id'] = $guru->id;
        
        // Pastikan kriteria_penilaian selalu ada (default: empty array yang akan di-encode sebagai JSON)
        if (!isset($validated['kriteria_penilaian']) || empty($validated['kriteria_penilaian'])) {
            $validated['kriteria_penilaian'] = [];
        }
        
        RubrikPenilaian::create($validated);

        return redirect()->route('guru.evaluasi.rubrik.index')->with('success', 'Rubrik penilaian berhasil dibuat');
    }

    public function rubrikShow($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $rubrik = RubrikPenilaian::where('guru_id', $guru->id)->findOrFail($id);
        
        return view('guru.evaluasi.rubrik.show', compact('guru', 'rubrik'));
    }

    public function rubrikEdit($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $rubrik = RubrikPenilaian::where('guru_id', $guru->id)->findOrFail($id);
        $mataPelajaranList = $guru->mataPelajaranAktif;
        
        return view('guru.evaluasi.rubrik.edit', compact('guru', 'rubrik', 'mataPelajaranList'));
    }

    public function rubrikUpdate(Request $request, $id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $rubrik = RubrikPenilaian::where('guru_id', $guru->id)->findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_pelajaran' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'kriteria_penilaian' => 'nullable|string',
            'skala_nilai' => 'nullable|string',
            'indikator' => 'nullable|string',
        ]);

        // Pastikan kriteria_penilaian selalu ada (default: empty array yang akan di-encode sebagai JSON)
        if (!isset($validated['kriteria_penilaian']) || empty($validated['kriteria_penilaian'])) {
            $validated['kriteria_penilaian'] = [];
        }

        $rubrik->update($validated);

        return redirect()->route('guru.evaluasi.rubrik.index')->with('success', 'Rubrik penilaian berhasil diperbarui');
    }

    public function rubrikDestroy($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $rubrik = RubrikPenilaian::where('guru_id', $guru->id)->findOrFail($id);
        $rubrik->delete();

        return redirect()->route('guru.evaluasi.rubrik.index')->with('success', 'Rubrik penilaian berhasil dihapus');
    }

    /**
     * LEMBAR PENILAIAN (LP)
     */
    public function lembarIndex(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $selectedMataPelajaran = $request->get('mata_pelajaran');
        $mataPelajaranList = $guru->mataPelajaranAktif;
        
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        $tableExists = Schema::hasTable('lembar_penilaian');
        $lembar = collect();
        
        // Jika tabel belum ada, coba buat secara otomatis
        if (!$tableExists) {
            try {
                $this->createEvaluasiTables();
                $tableExists = Schema::hasTable('lembar_penilaian');
            } catch (\Exception $e) {
                // Jika gagal membuat, tetap lanjutkan dengan pesan error
            }
        }
        
        if ($tableExists) {
            try {
                $query = LembarPenilaian::where('guru_id', $guru->id)->with('siswa', 'rubrikPenilaian');
                if ($selectedMataPelajaran) {
                    $query->where('mata_pelajaran', $selectedMataPelajaran);
                }
                $lembar = $query->orderBy('tanggal_penilaian', 'desc')->paginate(10);
            } catch (\Exception $e) {
                // Handle error
            }
        }

        return view('guru.evaluasi.lembar.index', compact('guru', 'lembar', 'mataPelajaranList', 'selectedMataPelajaran', 'tableExists'));
    }

    public function lembarCreate()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $mataPelajaranList = $guru->mataPelajaranAktif;
        $siswaList = Siswa::orderBy('nama')->get();
        $rubrikList = RubrikPenilaian::where('guru_id', $guru->id)->orderBy('judul')->get();
        $kuisList = Kuis::where('guru_id', $guru->id)
            ->where('is_active', true)
            ->orderBy('judul')
            ->get();
        
        return view('guru.evaluasi.lembar.create', compact('guru', 'mataPelajaranList', 'siswaList', 'rubrikList', 'kuisList'));
    }

    public function lembarStore(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'rubrik_penilaian_id' => 'nullable|string',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_pelajaran' => 'nullable|string',
            'tanggal_penilaian' => 'required|date',
            'aspek_penilaian' => 'nullable|string',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
            'detail_nilai' => 'nullable|string',
        ]);

        // Handle kuis atau rubrik
        $rubrikPenilaianId = null;
        $jenisPenilaian = 'Harian'; // Default value
        
        if (!empty($validated['rubrik_penilaian_id'])) {
            if (strpos($validated['rubrik_penilaian_id'], 'kuis_') === 0) {
                // Ini adalah kuis, simpan sebagai null (atau bisa ditambahkan field kuis_id nanti)
                $rubrikPenilaianId = null;
                $jenisPenilaian = 'Kuis';
            } else {
                // Ini adalah rubrik, pastikan integer
                $rubrikPenilaianId = (int) $validated['rubrik_penilaian_id'];
                $jenisPenilaian = 'Rubrik';
            }
        }
        
        // Buat array data secara eksplisit untuk memastikan semua field terisi
        // Pastikan jenis_penilaian selalu ada dan tidak kosong
        if (empty($jenisPenilaian)) {
            $jenisPenilaian = 'Harian';
        }
        
        $data = [
            'guru_id' => (int) $guru->id,
            'siswa_id' => (int) $validated['siswa_id'],
            'rubrik_penilaian_id' => $rubrikPenilaianId,
            'mata_pelajaran' => trim($validated['mata_pelajaran']),
            'kelas' => trim($validated['kelas']),
            'semester' => trim($validated['semester']),
            'tahun_pelajaran' => !empty($validated['tahun_pelajaran']) ? trim($validated['tahun_pelajaran']) : null,
            'tanggal_penilaian' => $validated['tanggal_penilaian'],
            'jenis_penilaian' => trim($jenisPenilaian), // Pastikan selalu ada
            'aspek_penilaian' => !empty($validated['aspek_penilaian']) ? trim($validated['aspek_penilaian']) : null,
            'nilai' => !empty($validated['nilai']) ? (float) $validated['nilai'] : null,
            'catatan' => !empty($validated['catatan']) ? trim($validated['catatan']) : null,
            'detail_nilai' => !empty($validated['detail_nilai']) ? trim($validated['detail_nilai']) : null,
        ];
        
        // PASTIKAN jenis_penilaian SELALU ADA - Validasi ketat
        if (empty($jenisPenilaian) || trim($jenisPenilaian) === '' || is_null($jenisPenilaian)) {
            $jenisPenilaian = 'Harian';
        }
        $jenisPenilaian = trim($jenisPenilaian);
        
        // Pastikan jenis_penilaian di data array juga benar
        $data['jenis_penilaian'] = $jenisPenilaian;
        
        // Validasi final sebelum insert
        if (empty($data['jenis_penilaian']) || trim($data['jenis_penilaian']) === '') {
            $data['jenis_penilaian'] = 'Harian';
        }
        
        // Gunakan DB::table() langsung dengan semua field termasuk jenis_penilaian
        // Ini memastikan field jenis_penilaian SELALU disertakan dalam query INSERT
        $insertData = [
            'guru_id' => (int) $data['guru_id'],
            'siswa_id' => (int) $data['siswa_id'],
            'rubrik_penilaian_id' => $data['rubrik_penilaian_id'],
            'mata_pelajaran' => (string) $data['mata_pelajaran'],
            'kelas' => (string) $data['kelas'],
            'semester' => (string) $data['semester'],
            'tahun_pelajaran' => $data['tahun_pelajaran'],
            'tanggal_penilaian' => $data['tanggal_penilaian'],
            'jenis_penilaian' => (string) $data['jenis_penilaian'], // WAJIB ADA - TIDAK BOLEH KOSONG
            'aspek_penilaian' => $data['aspek_penilaian'],
            'nilai' => $data['nilai'],
            'catatan' => $data['catatan'],
            'detail_nilai' => $data['detail_nilai'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Final check - pastikan jenis_penilaian ada
        if (empty($insertData['jenis_penilaian'])) {
            $insertData['jenis_penilaian'] = 'Harian';
        }
        
        // Insert ke database
        DB::table('lembar_penilaian')->insert($insertData);

        return redirect()->route('guru.evaluasi.lembar.index')->with('success', 'Lembar penilaian berhasil dibuat');
    }

    public function lembarShow($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $lembar = LembarPenilaian::where('guru_id', $guru->id)->with('siswa', 'rubrikPenilaian')->findOrFail($id);
        
        return view('guru.evaluasi.lembar.show', compact('guru', 'lembar'));
    }

    public function lembarEdit($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $lembar = LembarPenilaian::where('guru_id', $guru->id)->findOrFail($id);
        $mataPelajaranList = $guru->mataPelajaranAktif;
        $siswaList = Siswa::orderBy('nama')->get();
        $rubrikList = RubrikPenilaian::where('guru_id', $guru->id)->orderBy('judul')->get();
        $kuisList = Kuis::where('guru_id', $guru->id)
            ->where('is_active', true)
            ->orderBy('judul')
            ->get();
        
        return view('guru.evaluasi.lembar.edit', compact('guru', 'lembar', 'mataPelajaranList', 'siswaList', 'rubrikList', 'kuisList'));
    }

    public function lembarUpdate(Request $request, $id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $lembar = LembarPenilaian::where('guru_id', $guru->id)->findOrFail($id);
        
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'rubrik_penilaian_id' => 'nullable|string',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_pelajaran' => 'nullable|string',
            'tanggal_penilaian' => 'required|date',
            'aspek_penilaian' => 'nullable|string',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
            'detail_nilai' => 'nullable|string',
        ]);

        // Handle kuis atau rubrik
        $rubrikPenilaianId = null;
        $jenisPenilaian = 'Harian'; // Default value
        
        if (!empty($validated['rubrik_penilaian_id'])) {
            if (strpos($validated['rubrik_penilaian_id'], 'kuis_') === 0) {
                // Ini adalah kuis, simpan sebagai null (atau bisa ditambahkan field kuis_id nanti)
                $rubrikPenilaianId = null;
                $jenisPenilaian = 'Kuis';
            } else {
                // Ini adalah rubrik, pastikan integer
                $rubrikPenilaianId = (int) $validated['rubrik_penilaian_id'];
                $jenisPenilaian = 'Rubrik';
            }
        }
        
        // Pastikan jenis_penilaian selalu ada dan tidak kosong
        if (empty($jenisPenilaian)) {
            $jenisPenilaian = 'Harian';
        }
        
        // Buat array data secara eksplisit untuk memastikan semua field terisi
        $data = [
            'siswa_id' => (int) $validated['siswa_id'],
            'rubrik_penilaian_id' => $rubrikPenilaianId,
            'mata_pelajaran' => trim($validated['mata_pelajaran']),
            'kelas' => trim($validated['kelas']),
            'semester' => trim($validated['semester']),
            'tahun_pelajaran' => !empty($validated['tahun_pelajaran']) ? trim($validated['tahun_pelajaran']) : null,
            'tanggal_penilaian' => $validated['tanggal_penilaian'],
            'jenis_penilaian' => trim($jenisPenilaian), // Pastikan selalu ada
            'aspek_penilaian' => !empty($validated['aspek_penilaian']) ? trim($validated['aspek_penilaian']) : null,
            'nilai' => !empty($validated['nilai']) ? (float) $validated['nilai'] : null,
            'catatan' => !empty($validated['catatan']) ? trim($validated['catatan']) : null,
            'detail_nilai' => !empty($validated['detail_nilai']) ? trim($validated['detail_nilai']) : null,
        ];
        
        // Pastikan jenis_penilaian tidak kosong sebelum update
        if (empty($data['jenis_penilaian'])) {
            $data['jenis_penilaian'] = 'Harian';
        }
        
        $lembar->update($data);

        return redirect()->route('guru.evaluasi.lembar.index')->with('success', 'Lembar penilaian berhasil diperbarui');
    }

    public function lembarDestroy($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $lembar = LembarPenilaian::where('guru_id', $guru->id)->findOrFail($id);
        $lembar->delete();

        return redirect()->route('guru.evaluasi.lembar.index')->with('success', 'Lembar penilaian berhasil dihapus');
    }

    /**
     * NILAI FORMATIF & SUMATIF
     */
    public function nilaiIndex(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $selectedMataPelajaran = $request->get('mata_pelajaran');
        $selectedKelas = $request->get('kelas');
        $mataPelajaranList = $guru->mataPelajaranAktif;
        
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        $tableExists = Schema::hasTable('nilai_formatif_sumatif');
        $nilai = collect();
        
        // Jika tabel belum ada, coba buat secara otomatis
        if (!$tableExists) {
            try {
                $this->createEvaluasiTables();
                $tableExists = Schema::hasTable('nilai_formatif_sumatif');
            } catch (\Exception $e) {
                // Jika gagal membuat, tetap lanjutkan dengan pesan error
            }
        }
        
        if ($tableExists) {
            try {
                $query = NilaiFormatifSumatif::where('guru_id', $guru->id)->with('siswa');
                if ($selectedMataPelajaran) {
                    $query->where('mata_pelajaran', $selectedMataPelajaran);
                }
                if ($selectedKelas) {
                    $query->where('kelas', $selectedKelas);
                }
                $nilai = $query->orderBy('created_at', 'desc')->paginate(10);
            } catch (\Exception $e) {
                // Handle error
            }
        }

        return view('guru.evaluasi.nilai.index', compact('guru', 'nilai', 'mataPelajaranList', 'selectedMataPelajaran', 'selectedKelas', 'tableExists'));
    }

    public function nilaiCreate()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $mataPelajaranList = $guru->mataPelajaranAktif;
        $siswaList = Siswa::orderBy('nama')->get();
        
        return view('guru.evaluasi.nilai.create', compact('guru', 'mataPelajaranList', 'siswaList'));
    }

    public function nilaiStore(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_pelajaran' => 'nullable|string|regex:/^\d{4}\/\d{4}$/',
            'formatif_1' => 'nullable|numeric|min:0|max:100',
            'tanggal_nilai_harian' => 'nullable|date',
            'formatif_2' => 'nullable|numeric|min:0|max:100',
            'tanggal_nilai_harian_2' => 'nullable|date',
            'formatif_3' => 'nullable|numeric|min:0|max:100',
            'tanggal_nilai_harian_3' => 'nullable|date',
            'formatif_4' => 'nullable|numeric|min:0|max:100',
            'tanggal_nilai_harian_4' => 'nullable|date',
            'sumatif_uts' => 'nullable|numeric|min:0|max:100',
            'tanggal_uts' => 'nullable|date',
            'sumatif_uas' => 'nullable|numeric|min:0|max:100',
            'tanggal_uas' => 'nullable|date',
            'predikat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Hitung rata-rata formatif
        $formatifValues = array_filter([
            $validated['formatif_1'] ?? null,
            $validated['formatif_2'] ?? null,
            $validated['formatif_3'] ?? null,
            $validated['formatif_4'] ?? null,
        ]);
        $validated['rata_formatif'] = count($formatifValues) > 0 ? array_sum($formatifValues) / count($formatifValues) : null;

        // Hitung rata-rata sumatif
        $sumatifValues = array_filter([
            $validated['sumatif_uts'] ?? null,
            $validated['sumatif_uas'] ?? null,
        ]);
        $validated['rata_sumatif'] = count($sumatifValues) > 0 ? array_sum($sumatifValues) / count($sumatifValues) : null;

        // Hitung nilai akhir (70% formatif + 30% sumatif)
        if ($validated['rata_formatif'] !== null && $validated['rata_sumatif'] !== null) {
            $validated['nilai_akhir'] = ($validated['rata_formatif'] * 0.7) + ($validated['rata_sumatif'] * 0.3);
        } elseif ($validated['rata_formatif'] !== null) {
            $validated['nilai_akhir'] = $validated['rata_formatif'];
        } elseif ($validated['rata_sumatif'] !== null) {
            $validated['nilai_akhir'] = $validated['rata_sumatif'];
        }

        // Tentukan predikat jika belum ada
        if (empty($validated['predikat'] ?? null) && $validated['nilai_akhir'] !== null) {
            if ($validated['nilai_akhir'] >= 85) {
                $validated['predikat'] = 'A';
            } elseif ($validated['nilai_akhir'] >= 70) {
                $validated['predikat'] = 'B';
            } elseif ($validated['nilai_akhir'] >= 55) {
                $validated['predikat'] = 'C';
            } else {
                $validated['predikat'] = 'D';
            }
        }

        $validated['guru_id'] = $guru->id;
        
        NilaiFormatifSumatif::create($validated);

        return redirect()->route('guru.evaluasi.nilai.index')->with('success', 'Nilai harian berhasil disimpan');
    }

    public function nilaiShow($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $nilai = NilaiFormatifSumatif::where('guru_id', $guru->id)->with('siswa')->findOrFail($id);
        
        return view('guru.evaluasi.nilai.show', compact('guru', 'nilai'));
    }

    public function nilaiEdit($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $nilai = NilaiFormatifSumatif::where('guru_id', $guru->id)->findOrFail($id);
        $mataPelajaranList = $guru->mataPelajaranAktif;
        $siswaList = Siswa::orderBy('nama')->get();
        
        return view('guru.evaluasi.nilai.edit', compact('guru', 'nilai', 'mataPelajaranList', 'siswaList'));
    }

    public function nilaiUpdate(Request $request, $id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $nilai = NilaiFormatifSumatif::where('guru_id', $guru->id)->findOrFail($id);
        
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_pelajaran' => 'nullable|string|regex:/^\d{4}\/\d{4}$/',
            'formatif_1' => 'nullable|numeric|min:0|max:100',
            'tanggal_nilai_harian' => 'nullable|date',
            'formatif_2' => 'nullable|numeric|min:0|max:100',
            'tanggal_nilai_harian_2' => 'nullable|date',
            'formatif_3' => 'nullable|numeric|min:0|max:100',
            'tanggal_nilai_harian_3' => 'nullable|date',
            'formatif_4' => 'nullable|numeric|min:0|max:100',
            'tanggal_nilai_harian_4' => 'nullable|date',
            'sumatif_uts' => 'nullable|numeric|min:0|max:100',
            'tanggal_uts' => 'nullable|date',
            'sumatif_uas' => 'nullable|numeric|min:0|max:100',
            'tanggal_uas' => 'nullable|date',
            'predikat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Hitung rata-rata formatif
        $formatifValues = array_filter([
            $validated['formatif_1'] ?? null,
            $validated['formatif_2'] ?? null,
            $validated['formatif_3'] ?? null,
            $validated['formatif_4'] ?? null,
        ]);
        $validated['rata_formatif'] = count($formatifValues) > 0 ? array_sum($formatifValues) / count($formatifValues) : null;

        // Hitung rata-rata sumatif
        $sumatifValues = array_filter([
            $validated['sumatif_uts'] ?? null,
            $validated['sumatif_uas'] ?? null,
        ]);
        $validated['rata_sumatif'] = count($sumatifValues) > 0 ? array_sum($sumatifValues) / count($sumatifValues) : null;

        // Hitung nilai akhir
        if ($validated['rata_formatif'] !== null && $validated['rata_sumatif'] !== null) {
            $validated['nilai_akhir'] = ($validated['rata_formatif'] * 0.7) + ($validated['rata_sumatif'] * 0.3);
        } elseif ($validated['rata_formatif'] !== null) {
            $validated['nilai_akhir'] = $validated['rata_formatif'];
        } elseif ($validated['rata_sumatif'] !== null) {
            $validated['nilai_akhir'] = $validated['rata_sumatif'];
        }

        // Tentukan predikat jika belum ada
        if (empty($validated['predikat'] ?? null) && $validated['nilai_akhir'] !== null) {
            if ($validated['nilai_akhir'] >= 85) {
                $validated['predikat'] = 'A';
            } elseif ($validated['nilai_akhir'] >= 70) {
                $validated['predikat'] = 'B';
            } elseif ($validated['nilai_akhir'] >= 55) {
                $validated['predikat'] = 'C';
            } else {
                $validated['predikat'] = 'D';
            }
        }

        $nilai->update($validated);

        return redirect()->route('guru.evaluasi.nilai.index')->with('success', 'Nilai harian berhasil diperbarui');
    }

    public function nilaiDestroy($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $nilai = NilaiFormatifSumatif::where('guru_id', $guru->id)->findOrFail($id);
        $nilai->delete();

        return redirect()->route('guru.evaluasi.nilai.index')->with('success', 'Nilai harian berhasil dihapus');
    }

    /**
     * REKAP HASIL BELAJAR
     */
    public function rekapIndex(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $selectedKelas = $request->get('kelas');
        $selectedSemester = $request->get('semester');
        $selectedSiswa = $request->get('siswa_id');

        $tableExists = Schema::hasTable('rekap_hasil_belajar');
        $rekap = collect();
        
        // Jika tabel belum ada, coba buat secara otomatis
        if (!$tableExists) {
            try {
                $this->createEvaluasiTables();
                $tableExists = Schema::hasTable('rekap_hasil_belajar');
            } catch (\Exception $e) {
                // Jika gagal membuat, tetap lanjutkan dengan pesan error
            }
        }
        
        if ($tableExists) {
            try {
                $query = RekapHasilBelajar::where('guru_id', $guru->id)->with('siswa');
                if ($selectedKelas) {
                    $query->where('kelas', $selectedKelas);
                }
                if ($selectedSemester) {
                    $query->where('semester', $selectedSemester);
                }
                if ($selectedSiswa) {
                    $query->where('siswa_id', $selectedSiswa);
                }
                $rekap = $query->orderBy('nilai_akhir', 'desc')->paginate(10);
            } catch (\Exception $e) {
                // Handle error
            }
        }

        $siswaList = Siswa::orderBy('nama')->get();
        $kelasList = Siswa::distinct()->pluck('kelas')->filter()->sort()->values();

        return view('guru.evaluasi.rekap.index', compact('guru', 'rekap', 'siswaList', 'kelasList', 'selectedKelas', 'selectedSemester', 'selectedSiswa', 'tableExists'));
    }

    public function rekapGenerate(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        $validated = $request->validate([
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_pelajaran' => 'nullable|string',
        ]);

        // Generate rekap dari nilai formatif sumatif
        $nilaiList = NilaiFormatifSumatif::where('guru_id', $guru->id)
            ->where('kelas', $validated['kelas'])
            ->where('semester', $validated['semester'])
            ->with('siswa')
            ->get();

        foreach ($nilaiList as $nilai) {
            RekapHasilBelajar::updateOrCreate(
                [
                    'guru_id' => $guru->id,
                    'siswa_id' => $nilai->siswa_id,
                    'kelas' => $nilai->kelas,
                    'semester' => $nilai->semester,
                    'mata_pelajaran' => $nilai->mata_pelajaran,
                ],
                [
                    'tahun_pelajaran' => $validated['tahun_pelajaran'] ?? $nilai->tahun_pelajaran,
                    'nilai_formatif' => $nilai->rata_formatif,
                    'nilai_sumatif' => $nilai->rata_sumatif,
                    'nilai_akhir' => $nilai->nilai_akhir,
                    'predikat' => $nilai->predikat,
                ]
            );
        }

        // Update rekap keseluruhan per siswa
        $siswaIds = $nilaiList->pluck('siswa_id')->unique();
        foreach ($siswaIds as $siswaId) {
            $rekapSiswa = RekapHasilBelajar::where('guru_id', $guru->id)
                ->where('siswa_id', $siswaId)
                ->where('kelas', $validated['kelas'])
                ->where('semester', $validated['semester'])
                ->get();

            $totalMapel = $rekapSiswa->count();
            $rataRata = $rekapSiswa->avg('nilai_akhir');
            $tuntas = $rekapSiswa->where('nilai_akhir', '>=', 70)->count();
            $tidakTuntas = $rekapSiswa->where('nilai_akhir', '<', 70)->count();

            foreach ($rekapSiswa as $rekap) {
                $rekap->update([
                    'total_mata_pelajaran' => $totalMapel,
                    'rata_rata_semua_mapel' => $rataRata,
                    'jumlah_mapel_tuntas' => $tuntas,
                    'jumlah_mapel_tidak_tuntas' => $tidakTuntas,
                ]);
            }
        }

        return redirect()->route('guru.evaluasi.rekap.index', [
            'kelas' => $validated['kelas'],
            'semester' => $validated['semester'],
        ])->with('success', 'Rekap hasil belajar berhasil digenerate');
    }

    public function rekapShow($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $rekap = RekapHasilBelajar::where('guru_id', $guru->id)->with('siswa')->findOrFail($id);
        
        return view('guru.evaluasi.rekap.show', compact('guru', 'rekap'));
    }

    /**
     * Helper method untuk membuat tabel evaluasi secara otomatis
     */
    /**
     * Membuat tabel Evaluasi secara otomatis
     */
    private function createEvaluasiTables()
    {
        try {
            $host = config('database.connections.mysql.host', 'localhost');
            $dbname = config('database.connections.mysql.database', 'nurani');
            $username = config('database.connections.mysql.username', 'root');
            $password = config('database.connections.mysql.password', '');
            
            $pdo = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // 1. Rubrik Penilaian
            if (!Schema::hasTable('rubrik_penilaian')) {
                $pdo->exec("CREATE TABLE `rubrik_penilaian` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `guru_id` bigint(20) UNSIGNED NOT NULL,
                  `judul` varchar(255) NOT NULL,
                  `mata_pelajaran` varchar(255) NOT NULL,
                  `kelas` varchar(255) NOT NULL,
                  `semester` varchar(255) NOT NULL,
                  `tahun_pelajaran` varchar(255) DEFAULT NULL,
                  `deskripsi` text DEFAULT NULL,
                  `kriteria_penilaian` text NOT NULL,
                  `skala_nilai` text DEFAULT NULL,
                  `indikator` text DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `rubrik_penilaian_guru_id_index` (`guru_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            }

            // 2. Lembar Penilaian
            if (!Schema::hasTable('lembar_penilaian')) {
                $pdo->exec("CREATE TABLE `lembar_penilaian` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `guru_id` bigint(20) UNSIGNED NOT NULL,
                  `siswa_id` bigint(20) UNSIGNED NOT NULL,
                  `rubrik_penilaian_id` bigint(20) UNSIGNED DEFAULT NULL,
                  `mata_pelajaran` varchar(255) NOT NULL,
                  `kelas` varchar(255) NOT NULL,
                  `semester` varchar(255) NOT NULL,
                  `tahun_pelajaran` varchar(255) DEFAULT NULL,
                  `tanggal_penilaian` date NOT NULL,
                  `jenis_penilaian` varchar(255) NOT NULL,
                  `aspek_penilaian` text DEFAULT NULL,
                  `nilai` decimal(5,2) DEFAULT NULL,
                  `catatan` text DEFAULT NULL,
                  `detail_nilai` text DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `lembar_penilaian_guru_id_index` (`guru_id`),
                  KEY `lembar_penilaian_siswa_id_index` (`siswa_id`),
                  KEY `lembar_penilaian_rubrik_penilaian_id_index` (`rubrik_penilaian_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            }

            // 3. Nilai Formatif Sumatif
            if (!Schema::hasTable('nilai_formatif_sumatif')) {
                $pdo->exec("CREATE TABLE `nilai_formatif_sumatif` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `guru_id` bigint(20) UNSIGNED NOT NULL,
                  `siswa_id` bigint(20) UNSIGNED NOT NULL,
                  `mata_pelajaran` varchar(255) NOT NULL,
                  `kelas` varchar(255) NOT NULL,
                  `semester` varchar(255) NOT NULL,
                  `tahun_pelajaran` varchar(255) DEFAULT NULL,
                  `formatif_1` decimal(5,2) DEFAULT NULL,
                  `tanggal_nilai_harian` date DEFAULT NULL,
                  `formatif_2` decimal(5,2) DEFAULT NULL,
                  `tanggal_nilai_harian_2` date DEFAULT NULL,
                  `formatif_3` decimal(5,2) DEFAULT NULL,
                  `tanggal_nilai_harian_3` date DEFAULT NULL,
                  `formatif_4` decimal(5,2) DEFAULT NULL,
                  `tanggal_nilai_harian_4` date DEFAULT NULL,
                  `rata_formatif` decimal(5,2) DEFAULT NULL,
                  `sumatif_uts` decimal(5,2) DEFAULT NULL,
                  `tanggal_uts` date DEFAULT NULL,
                  `sumatif_uas` decimal(5,2) DEFAULT NULL,
                  `tanggal_uas` date DEFAULT NULL,
                  `rata_sumatif` decimal(5,2) DEFAULT NULL,
                  `nilai_akhir` decimal(5,2) DEFAULT NULL,
                  `predikat` varchar(255) DEFAULT NULL,
                  `keterangan` text DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `nilai_formatif_sumatif_guru_id_index` (`guru_id`),
                  KEY `nilai_formatif_sumatif_siswa_id_index` (`siswa_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            }

            // 4. Rekap Hasil Belajar
            if (!Schema::hasTable('rekap_hasil_belajar')) {
                $pdo->exec("CREATE TABLE `rekap_hasil_belajar` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `guru_id` bigint(20) UNSIGNED NOT NULL,
                  `siswa_id` bigint(20) UNSIGNED NOT NULL,
                  `kelas` varchar(255) NOT NULL,
                  `semester` varchar(255) NOT NULL,
                  `tahun_pelajaran` varchar(255) DEFAULT NULL,
                  `mata_pelajaran` varchar(255) NOT NULL,
                  `nilai_formatif` decimal(5,2) DEFAULT NULL,
                  `nilai_sumatif` decimal(5,2) DEFAULT NULL,
                  `nilai_akhir` decimal(5,2) DEFAULT NULL,
                  `predikat` varchar(255) DEFAULT NULL,
                  `total_mata_pelajaran` int(11) DEFAULT 0,
                  `rata_rata_semua_mapel` decimal(5,2) DEFAULT NULL,
                  `jumlah_mapel_tuntas` int(11) DEFAULT 0,
                  `jumlah_mapel_tidak_tuntas` int(11) DEFAULT 0,
                  `catatan` text DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `rekap_hasil_belajar_guru_id_index` (`guru_id`),
                  KEY `rekap_hasil_belajar_siswa_id_index` (`siswa_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Error creating evaluasi tables: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get siswa by kelas (AJAX endpoint)
     */
    public function getSiswaByKelas(Request $request)
    {
        try {
            $kelas = $request->get('kelas');
            
            if (!$kelas) {
                return response()->json(['siswa' => []], 200);
            }
            
            $siswaList = Siswa::where('kelas', $kelas)
                ->orderBy('nama')
                ->get(['id', 'nama', 'kelas']);
            
            return response()->json(['siswa' => $siswaList], 200);
        } catch (\Exception $e) {
            Log::error('Error getting siswa by kelas: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data siswa', 'siswa' => []], 500);
        }
    }
}
