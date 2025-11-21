<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\PresensiSiswa;
use Carbon\Carbon;

class PresensiSiswaController extends Controller
{
    /**
     * Display presensi siswa form
     */
    public function index(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $selectedKelas = $request->get('kelas', '7');
        $selectedTanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));

        // Get siswa by kelas
        $siswas = Siswa::where('kelas', $selectedKelas)
            ->orderBy('nama')
            ->get();

        // Get existing presensi for selected date
        $presensiHariIni = collect();
        if ($siswas->count() > 0) {
            $presensiHariIni = PresensiSiswa::where('guru_id', $guru->id)
                ->whereDate('tanggal', $selectedTanggal)
                ->whereHas('siswa', function($query) use ($selectedKelas) {
                    $query->where('kelas', $selectedKelas);
                })
                ->with('siswa')
                ->get()
                ->keyBy('siswa_id');
        }

        // Get presensi history (last 30 days)
        $presensiHistory = collect();
        if ($selectedKelas) {
            $presensiHistory = PresensiSiswa::where('guru_id', $guru->id)
                ->whereHas('siswa', function($query) use ($selectedKelas) {
                    $query->where('kelas', $selectedKelas);
                })
                ->with('siswa')
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        }

        return view('guru.presensi-siswa.index', compact(
            'guru', 
            'siswas', 
            'selectedKelas', 
            'selectedTanggal',
            'presensiHariIni',
            'presensiHistory'
        ));
    }

    /**
     * Store presensi siswa
     */
    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|exists:siswas,id',
            'status' => 'required|array',
            'status.*' => 'required|in:hadir,sakit,izin,alfa',
            'tanggal' => 'required|date',
            'kelas' => 'required|in:7,8,9',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string|max:500',
        ], [
            'siswa_id.required' => 'Pilih setidaknya satu siswa',
            'status.*.required' => 'Status presensi harus diisi untuk semua siswa',
            'status.*.in' => 'Status presensi tidak valid',
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'kelas.required' => 'Kelas harus dipilih',
        ]);

        $tanggal = $request->tanggal;
        $kelas = $request->kelas;
        $siswaIds = $request->siswa_id;
        $statuses = $request->status;
        $keterangans = $request->keterangan ?? [];

        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($siswaIds as $index => $siswaId) {
            // Check if presensi already exists for this siswa on this date
            $existingPresensi = PresensiSiswa::where('siswa_id', $siswaId)
                ->whereDate('tanggal', $tanggal)
                ->first();

            if ($existingPresensi) {
                // Update existing presensi
                $existingPresensi->update([
                    'status' => $statuses[$index] ?? 'hadir',
                    'keterangan' => $keterangans[$index] ?? null,
                    'guru_id' => $guru->id,
                ]);
                $successCount++;
            } else {
                // Create new presensi
                try {
                    PresensiSiswa::create([
                        'siswa_id' => $siswaId,
                        'guru_id' => $guru->id,
                        'tanggal' => $tanggal,
                        'status' => $statuses[$index] ?? 'hadir',
                        'keterangan' => $keterangans[$index] ?? null,
                    ]);
                    $successCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                    $siswa = Siswa::find($siswaId);
                    $errors[] = "Gagal menyimpan presensi untuk {$siswa->nama}: " . $e->getMessage();
                }
            }
        }

        if ($errorCount > 0) {
            return redirect()->route('guru.presensi-siswa.index', ['kelas' => $kelas, 'tanggal' => $tanggal])
                ->with('error', 'Beberapa presensi gagal disimpan: ' . implode(', ', $errors))
                ->with('success', "{$successCount} presensi berhasil disimpan");
        }

        return redirect()->route('guru.presensi-siswa.index', ['kelas' => $kelas, 'tanggal' => $tanggal])
            ->with('success', "Presensi {$successCount} siswa berhasil disimpan untuk tanggal " . Carbon::parse($tanggal)->format('d/m/Y'));
    }

    /**
     * Update presensi siswa
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $presensi = PresensiSiswa::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alfa',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $presensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Presensi siswa berhasil diperbarui');
    }

    /**
     * Delete presensi siswa
     */
    public function destroy($id)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $presensi = PresensiSiswa::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $presensi->delete();

        return redirect()->back()->with('success', 'Presensi siswa berhasil dihapus');
    }
}
