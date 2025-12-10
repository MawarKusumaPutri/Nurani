<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Rpp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class RppController extends Controller
{
    public function index(Request $request)
    {
        try {
            $guru = Guru::where('user_id', Auth::id())->first();
            
            if (!$guru) {
                return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
            }

            // Get mata pelajaran yang dipilih
            $selectedMataPelajaran = $request->get('mata_pelajaran');
            $mataPelajaranList = $guru->mataPelajaranAktif;
            
            if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
                $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
            }

            // Cek apakah tabel rpp ada
            $tableExists = false;
            $rpp = collect();
            $errorMessage = null;
            
            try {
                // Cek apakah tabel ada
                $tableExists = Schema::hasTable('rpp');
                
                if ($tableExists) {
                    try {
                        $query = $guru->rpp();
                        if ($selectedMataPelajaran) {
                            $query->where('mata_pelajaran', $selectedMataPelajaran);
                        }
                        $rpp = $query->orderBy('created_at', 'desc')->paginate(10);
                    } catch (\Illuminate\Database\QueryException $e) {
                        // Jika query gagal, tabel mungkin belum ada
                        if (str_contains($e->getMessage(), "doesn't exist") || str_contains($e->getMessage(), "Table") && str_contains($e->getMessage(), "rpp")) {
                            $tableExists = false;
                            $errorMessage = 'Tabel RPP belum ada di database. Silakan buka file CARA_BUAT_TABEL_RPP_MUDAH.txt atau akses http://localhost/nurani/public/BUAT_TABEL_RPP_OTOMATIS.php untuk membuat tabel secara otomatis.';
                        } else {
                            $errorMessage = 'Terjadi kesalahan saat memuat data RPP: ' . $e->getMessage();
                        }
                    }
                } else {
                    $errorMessage = 'Tabel RPP belum ada di database. Silakan buka file CARA_BUAT_TABEL_RPP_MUDAH.txt atau akses http://localhost/nurani/public/BUAT_TABEL_RPP_OTOMATIS.php untuk membuat tabel secara otomatis.';
                }
            } catch (\Illuminate\Database\QueryException $e) {
                if (str_contains($e->getMessage(), "doesn't exist") || (str_contains($e->getMessage(), "Table") && str_contains($e->getMessage(), "rpp"))) {
                    $tableExists = false;
                    $errorMessage = 'Tabel RPP belum ada di database. Silakan buka file CARA_BUAT_TABEL_RPP_MUDAH.txt atau akses http://localhost/nurani/public/BUAT_TABEL_RPP_OTOMATIS.php untuk membuat tabel secara otomatis.';
                } else {
                    $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
                }
            } catch (\Exception $e) {
                $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            }

            // Pastikan semua variabel ada
            $tableExists = $tableExists ?? false;
            $rpp = $rpp ?? collect();
            $errorMessage = $errorMessage ?? null;
            $selectedMataPelajaran = $selectedMataPelajaran ?? null;
            $mataPelajaranList = $mataPelajaranList ?? collect();

            return view('guru.rpp.index', compact('guru', 'rpp', 'mataPelajaranList', 'selectedMataPelajaran', 'tableExists', 'errorMessage'));
        } catch (\Exception $e) {
            // Jika ada error fatal, tetap tampilkan halaman dengan error
            $guru = Guru::where('user_id', Auth::id())->first();
            if (!$guru) {
                return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
            }
            
            return view('guru.rpp.index', [
                'guru' => $guru,
                'rpp' => collect(),
                'mataPelajaranList' => $guru->mataPelajaranAktif ?? collect(),
                'selectedMataPelajaran' => null,
                'tableExists' => false,
                'errorMessage' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $mataPelajaranList = $guru->mataPelajaranAktif;

        return view('guru.rpp.create', compact('guru', 'mataPelajaranList'));
    }

    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'pertemuan_ke' => 'required|integer|min:1',
            'alokasi_waktu' => 'required|integer|min:1',
        ]);

        $data = [
            'guru_id' => $guru->id,
            'judul' => $request->judul,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas' => $request->kelas,
            'semester' => $request->semester,
            'pertemuan_ke' => $request->pertemuan_ke,
            'alokasi_waktu' => $request->alokasi_waktu,
            // Identitas Pembelajaran
            'sekolah' => $request->sekolah,
            'mata_pelajaran_detail' => $request->mata_pelajaran_detail,
            'kelas_detail' => $request->kelas_detail,
            'semester_detail' => $request->semester_detail,
            'tahun_pelajaran' => $request->tahun_pelajaran,
            // Kompetensi Inti
            'ki_1' => $request->ki_1,
            'ki_2' => $request->ki_2,
            'ki_3' => $request->ki_3,
            'ki_4' => $request->ki_4,
            // KD & Indikator
            'kd_pengetahuan' => $request->kd_pengetahuan,
            'kd_keterampilan' => $request->kd_keterampilan,
            'indikator_pencapaian_kompetensi' => $request->indikator_pencapaian_kompetensi,
            // Tujuan Pembelajaran
            'tujuan_pembelajaran' => $request->tujuan_pembelajaran,
            // Materi Pembelajaran
            'materi_pembelajaran' => $request->materi_pembelajaran,
            'materi_pembelajaran_reguler' => $request->materi_pembelajaran_reguler,
            'materi_pembelajaran_pengayaan' => $request->materi_pembelajaran_pengayaan,
            'materi_pembelajaran_remedial' => $request->materi_pembelajaran_remedial,
            // Metode Pembelajaran
            'metode_pembelajaran' => $request->metode_pembelajaran,
            // Skenario Pembelajaran
            'kegiatan_pendahuluan' => $request->kegiatan_pendahuluan,
            'kegiatan_inti' => $request->kegiatan_inti,
            'kegiatan_penutup' => $request->kegiatan_penutup,
            // Media & Sumber Ajar
            'media_pembelajaran' => $request->media_pembelajaran,
            'sumber_belajar' => $request->sumber_belajar,
            // Instrumen Penilaian
            'teknik_penilaian' => $request->teknik_penilaian,
            'bentuk_instrumen' => $request->bentuk_instrumen,
            'rubrik_penilaian' => $request->rubrik_penilaian,
            'kriteria_ketuntasan' => $request->kriteria_ketuntasan,
        ];

        $rpp = Rpp::create($data);

        return redirect()->route('guru.rpp.index')
            ->with('success', 'RPP berhasil dibuat.');
    }

    public function show(Rpp $rpp)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $rpp->guru_id !== $guru->id) {
            return redirect()->route('guru.rpp.index')
                ->with('error', 'RPP tidak ditemukan atau Anda tidak memiliki akses.');
        }

        return view('guru.rpp.show', compact('guru', 'rpp'));
    }

    public function edit(Rpp $rpp)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $rpp->guru_id !== $guru->id) {
            return redirect()->route('guru.rpp.index')
                ->with('error', 'RPP tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $mataPelajaranList = $guru->mataPelajaranAktif;

        return view('guru.rpp.edit', compact('guru', 'rpp', 'mataPelajaranList'));
    }

    public function update(Request $request, Rpp $rpp)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $rpp->guru_id !== $guru->id) {
            return redirect()->route('guru.rpp.index')
                ->with('error', 'RPP tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'pertemuan_ke' => 'required|integer|min:1',
            'alokasi_waktu' => 'required|integer|min:1',
        ]);

        $rpp->update([
            'judul' => $request->judul,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas' => $request->kelas,
            'semester' => $request->semester,
            'pertemuan_ke' => $request->pertemuan_ke,
            'alokasi_waktu' => $request->alokasi_waktu,
            // Identitas Pembelajaran
            'sekolah' => $request->sekolah,
            'mata_pelajaran_detail' => $request->mata_pelajaran_detail,
            'kelas_detail' => $request->kelas_detail,
            'semester_detail' => $request->semester_detail,
            'tahun_pelajaran' => $request->tahun_pelajaran,
            // Kompetensi Inti
            'ki_1' => $request->ki_1,
            'ki_2' => $request->ki_2,
            'ki_3' => $request->ki_3,
            'ki_4' => $request->ki_4,
            // KD & Indikator
            'kd_pengetahuan' => $request->kd_pengetahuan,
            'kd_keterampilan' => $request->kd_keterampilan,
            'indikator_pencapaian_kompetensi' => $request->indikator_pencapaian_kompetensi,
            // Tujuan Pembelajaran
            'tujuan_pembelajaran' => $request->tujuan_pembelajaran,
            // Materi Pembelajaran
            'materi_pembelajaran' => $request->materi_pembelajaran,
            'materi_pembelajaran_reguler' => $request->materi_pembelajaran_reguler,
            'materi_pembelajaran_pengayaan' => $request->materi_pembelajaran_pengayaan,
            'materi_pembelajaran_remedial' => $request->materi_pembelajaran_remedial,
            // Metode Pembelajaran
            'metode_pembelajaran' => $request->metode_pembelajaran,
            // Skenario Pembelajaran
            'kegiatan_pendahuluan' => $request->kegiatan_pendahuluan,
            'kegiatan_inti' => $request->kegiatan_inti,
            'kegiatan_penutup' => $request->kegiatan_penutup,
            // Media & Sumber Ajar
            'media_pembelajaran' => $request->media_pembelajaran,
            'sumber_belajar' => $request->sumber_belajar,
            // Instrumen Penilaian
            'teknik_penilaian' => $request->teknik_penilaian,
            'bentuk_instrumen' => $request->bentuk_instrumen,
            'rubrik_penilaian' => $request->rubrik_penilaian,
            'kriteria_ketuntasan' => $request->kriteria_ketuntasan,
        ]);

        return redirect()->route('guru.rpp.index')
            ->with('success', 'RPP berhasil diperbarui.');
    }

    public function destroy(Rpp $rpp)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $rpp->guru_id !== $guru->id) {
            return redirect()->route('guru.rpp.index')
                ->with('error', 'RPP tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $rpp->delete();

        return redirect()->route('guru.rpp.index')
            ->with('success', 'RPP berhasil dihapus.');
    }
}
