<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Rpp;
use App\Models\MateriPembelajaran;
use Illuminate\Support\Facades\Auth;

class RppController extends Controller
{
    /**
     * Tampilkan form untuk membuat RPP baru untuk pertemuan tertentu
     */
    public function create(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $mataPelajaran = $request->get('mata_pelajaran');
        $pertemuanKe = $request->get('pertemuan_ke', 1);

        // Ambil data materi pembelajaran untuk pre-fill
        $materiPembelajaran = null;
        if ($mataPelajaran) {
            $materiPembelajaran = MateriPembelajaran::where('guru_id', $guru->id)
                ->where('mata_pelajaran', $mataPelajaran)
                ->first();
        }

        return view('guru.rpp.create', compact('guru', 'mataPelajaran', 'pertemuanKe', 'materiPembelajaran'));
    }

    /**
     * Simpan RPP baru
     */
    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'semester' => 'required|string|max:50',
            'pertemuan_ke' => 'required|integer|min:1',
            'alokasi_waktu' => 'required|integer|min:1',
            'sekolah' => 'nullable|string|max:255',
            'tahun_pelajaran' => 'nullable|string|max:50',
            'ki_1' => 'nullable|string',
            'ki_2' => 'nullable|string',
            'ki_3' => 'nullable|string',
            'ki_4' => 'nullable|string',
            'kd_pengetahuan' => 'nullable|string',
            'kd_keterampilan' => 'nullable|string',
            'indikator_pencapaian_kompetensi' => 'nullable|string',
            'tujuan_pembelajaran' => 'nullable|string',
            'materi_pembelajaran' => 'nullable|string',
            'materi_pembelajaran_reguler' => 'nullable|string',
            'materi_pembelajaran_pengayaan' => 'nullable|string',
            'materi_pembelajaran_remedial' => 'nullable|string',
            'metode_pembelajaran' => 'nullable|string',
            'kegiatan_pendahuluan' => 'nullable|string',
            'kegiatan_inti' => 'nullable|string',
            'kegiatan_penutup' => 'nullable|string',
            'media_pembelajaran' => 'nullable|string',
            'sumber_belajar' => 'nullable|string',
            'teknik_penilaian' => 'nullable|string',
            'bentuk_instrumen' => 'nullable|string',
            'rubrik_penilaian' => 'nullable|string',
            'kriteria_ketuntasan' => 'nullable|string',
        ]);

        // Cek apakah RPP untuk pertemuan ini sudah ada
        $existingRpp = Rpp::where('guru_id', $guru->id)
            ->where('mata_pelajaran', $validated['mata_pelajaran'])
            ->where('pertemuan_ke', $validated['pertemuan_ke'])
            ->first();

        if ($existingRpp) {
            return redirect()->back()
                ->with('error', 'RPP untuk Pertemuan ' . $validated['pertemuan_ke'] . ' sudah ada. Silakan edit RPP yang sudah ada.')
                ->withInput();
        }

        // Tambahkan guru_id
        $validated['guru_id'] = $guru->id;
        $validated['mata_pelajaran_detail'] = $validated['mata_pelajaran'];
        $validated['kelas_detail'] = $validated['kelas'];
        $validated['semester_detail'] = $validated['semester'];

        // Simpan RPP
        $rpp = Rpp::create($validated);

        return redirect()->route('guru.dashboard', ['mata_pelajaran' => $validated['mata_pelajaran']])
            ->with('success', 'RPP Pertemuan ' . $validated['pertemuan_ke'] . ' berhasil dibuat!');
    }

    /**
     * Tampilkan form edit RPP
     */
    public function edit($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $rpp = Rpp::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        return view('guru.rpp.edit', compact('guru', 'rpp'));
    }

    /**
     * Update RPP
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $rpp = Rpp::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'semester' => 'required|string|max:50',
            'pertemuan_ke' => 'required|integer|min:1',
            'alokasi_waktu' => 'required|integer|min:1',
            'sekolah' => 'nullable|string|max:255',
            'tahun_pelajaran' => 'nullable|string|max:50',
            'ki_1' => 'nullable|string',
            'ki_2' => 'nullable|string',
            'ki_3' => 'nullable|string',
            'ki_4' => 'nullable|string',
            'kd_pengetahuan' => 'nullable|string',
            'kd_keterampilan' => 'nullable|string',
            'indikator_pencapaian_kompetensi' => 'nullable|string',
            'tujuan_pembelajaran' => 'nullable|string',
            'materi_pembelajaran' => 'nullable|string',
            'materi_pembelajaran_reguler' => 'nullable|string',
            'materi_pembelajaran_pengayaan' => 'nullable|string',
            'materi_pembelajaran_remedial' => 'nullable|string',
            'metode_pembelajaran' => 'nullable|string',
            'kegiatan_pendahuluan' => 'nullable|string',
            'kegiatan_inti' => 'nullable|string',
            'kegiatan_penutup' => 'nullable|string',
            'media_pembelajaran' => 'nullable|string',
            'sumber_belajar' => 'nullable|string',
            'teknik_penilaian' => 'nullable|string',
            'bentuk_instrumen' => 'nullable|string',
            'rubrik_penilaian' => 'nullable|string',
            'kriteria_ketuntasan' => 'nullable|string',
        ]);

        $validated['mata_pelajaran_detail'] = $validated['mata_pelajaran'];
        $validated['kelas_detail'] = $validated['kelas'];
        $validated['semester_detail'] = $validated['semester'];

        $rpp->update($validated);

        return redirect()->route('guru.dashboard', ['mata_pelajaran' => $validated['mata_pelajaran']])
            ->with('success', 'RPP Pertemuan ' . $validated['pertemuan_ke'] . ' berhasil diperbarui!');
    }

    /**
     * Hapus RPP
     */
    public function destroy($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $rpp = Rpp::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $mataPelajaran = $rpp->mata_pelajaran;
        $pertemuanKe = $rpp->pertemuan_ke;

        $rpp->delete();

        return redirect()->route('guru.dashboard', ['mata_pelajaran' => $mataPelajaran])
            ->with('success', 'RPP Pertemuan ' . $pertemuanKe . ' berhasil dihapus!');
    }

    /**
     * Tampilkan detail RPP
     */
    public function show($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $rpp = Rpp::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        return view('guru.rpp.show', compact('guru', 'rpp'));
    }

    /**
     * Tampilkan halaman cetak RPP
     */
    public function cetak($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $rpp = Rpp::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        return view('guru.rpp.cetak', compact('guru', 'rpp'));
    }
}
