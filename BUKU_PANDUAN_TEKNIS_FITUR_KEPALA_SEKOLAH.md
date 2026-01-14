# 💻 BUKU PANDUAN TEKNIS: FITUR KEPALA SEKOLAH (DENGAN KODE)
## TMS NURANI - MTs Nurul Aiman

---

## 📖 DAFTAR ISI

1. [Arsitektur Sistem Kepala Sekolah](#arsitektur-sistem-kepala-sekolah)
2. [Dashboard & Statistik](#dashboard--statistik)
3. [Fitur Monitoring Guru](#fitur-monitoring-guru)
4. [Fitur Monitoring Siswa](#fitur-monitoring-siswa)
5. [Fitur Approval RPP](#fitur-approval-rpp)
6. [Fitur Laporan Akademik](#fitur-laporan-akademik)
7. [Fitur Analytics](#fitur-analytics)
8. [Routing & Middleware](#routing--middleware)

---

## 1. ARSITEKTUR SISTEM KEPALA SEKOLAH

### 1.1 Konsep Utama

Kepala Sekolah memiliki **hak akses VIEW ONLY** untuk hampir semua data, kecuali:
- ✅ **Approval RPP** (Create/Update approval status)
- ✅ **Rekomendasi** (Create rekomendasi untuk guru)

```
┌─────────────────────────────────┐
│   KEPALA SEKOLAH                │
├─────────────────────────────────┤
│                                 │
│  VIEW ONLY:                     │
│  • Data Guru                    │
│  • Data Siswa                   │
│  • Jadwal                       │
│  • Nilai                        │
│  • Presensi                     │
│                                 │
│  CAN MODIFY:                    │
│  • Approval RPP                 │
│  • Rekomendasi                  │
│                                 │
└─────────────────────────────────┘
```

---

## 2. DASHBOARD & STATISTIK

### 2.1 KepalaSekolahController - Dashboard

**File:** `app/Http/Controllers/KepalaSekolahController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Rpp;
use Illuminate\Support\Facades\DB;

class KepalaSekolahController extends Controller
{
    /**
     * Dashboard Kepala Sekolah
     */
    public function dashboard()
    {
        // Statistik Umum
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $totalGuru = Guru::where('status', 'aktif')->count();
        $totalRpp = Rpp::count();

        // RPP Pending Approval
        $rppPending = Rpp::where('status_approval', 'pending')->count();

        // Rata-rata Nilai Siswa
        $rataRataNilai = DB::table('nilai_siswas')
            ->avg('nilai');

        // Tingkat Kehadiran
        $tingkatKehadiran = DB::table('presensis')
            ->where('status', 'H')
            ->count() / DB::table('presensis')->count() * 100;

        // Grafik Nilai per Kelas
        $nilaiPerKelas = DB::table('nilai_siswas')
            ->join('siswas', 'nilai_siswas.siswa_id', '=', 'siswas.id')
            ->select('siswas.kelas', DB::raw('AVG(nilai_siswas.nilai) as rata_rata'))
            ->groupBy('siswas.kelas')
            ->get();

        return view('kepala-sekolah.dashboard', [
            'totalSiswa' => $totalSiswa,
            'totalGuru' => $totalGuru,
            'totalRpp' => $totalRpp,
            'rppPending' => $rppPending,
            'rataRataNilai' => round($rataRataNilai, 2),
            'tingkatKehadiran' => round($tingkatKehadiran, 2),
            'nilaiPerKelas' => $nilaiPerKelas,
        ]);
    }
}
```

---

## 3. FITUR MONITORING GURU

### 3.1 Monitoring Guru Controller

**File:** `app/Http/Controllers/KepalaSekolah/MonitoringGuruController.php`

```php
<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Rpp;
use App\Models\Materi;
use App\Models\Kuis;

class MonitoringGuruController extends Controller
{
    /**
     * Tampilkan daftar guru dengan statistik
     */
    public function index()
    {
        $gurus = Guru::with('user')->get()->map(function($guru) {
            return [
                'id' => $guru->id,
                'nama' => $guru->user->name,
                'nip' => $guru->nip,
                'mata_pelajaran' => $guru->mata_pelajaran,
                'jumlah_rpp' => Rpp::where('guru_id', $guru->id)->count(),
                'jumlah_materi' => Materi::where('guru_id', $guru->id)->count(),
                'jumlah_kuis' => Kuis::where('guru_id', $guru->id)->count(),
                'status' => $guru->status,
            ];
        });

        return view('kepala-sekolah.monitoring.guru.index', [
            'gurus' => $gurus,
        ]);
    }

    /**
     * Detail guru
     */
    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        // Statistik Guru
        $rpps = Rpp::where('guru_id', $id)->get();
        $materis = Materi::where('guru_id', $id)->get();
        $kuis = Kuis::where('guru_id', $id)->get();

        // Rata-rata nilai siswa dari guru ini
        $rataRataNilai = DB::table('nilai_siswas')
            ->join('kuis', 'nilai_siswas.kuis_id', '=', 'kuis.id')
            ->where('kuis.guru_id', $id)
            ->avg('nilai_siswas.nilai');

        return view('kepala-sekolah.monitoring.guru.show', [
            'guru' => $guru,
            'rpps' => $rpps,
            'materis' => $materis,
            'kuis' => $kuis,
            'rataRataNilai' => round($rataRataNilai, 2),
        ]);
    }
}
```

---

## 4. FITUR MONITORING SISWA

### 4.1 Monitoring Siswa Controller

**File:** `app/Http/Controllers/KepalaSekolah/MonitoringSiswaController.php`

```php
<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class MonitoringSiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa dengan statistik
     */
    public function index()
    {
        $siswas = Siswa::all()->map(function($siswa) {
            // Rata-rata nilai
            $rataRataNilai = DB::table('nilai_siswas')
                ->where('siswa_id', $siswa->id)
                ->avg('nilai');

            // Tingkat kehadiran
            $totalPresensi = DB::table('presensis')
                ->where('siswa_id', $siswa->id)
                ->count();
            
            $hadir = DB::table('presensis')
                ->where('siswa_id', $siswa->id)
                ->where('status', 'H')
                ->count();

            $tingkatKehadiran = $totalPresensi > 0 
                ? ($hadir / $totalPresensi * 100) 
                : 0;

            return [
                'id' => $siswa->id,
                'nisn' => $siswa->nisn,
                'nama_lengkap' => $siswa->nama_lengkap,
                'kelas' => $siswa->kelas,
                'rata_rata_nilai' => round($rataRataNilai, 2),
                'tingkat_kehadiran' => round($tingkatKehadiran, 2),
                'status' => $siswa->status,
            ];
        });

        return view('kepala-sekolah.monitoring.siswa.index', [
            'siswas' => $siswas,
        ]);
    }

    /**
     * Detail siswa
     */
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Nilai per Mata Pelajaran
        $nilaiPerMapel = DB::table('nilai_siswas')
            ->join('kuis', 'nilai_siswas.kuis_id', '=', 'kuis.id')
            ->where('nilai_siswas.siswa_id', $id)
            ->select('kuis.mata_pelajaran', DB::raw('AVG(nilai_siswas.nilai) as rata_rata'))
            ->groupBy('kuis.mata_pelajaran')
            ->get();

        // Rekap Presensi
        $rekapPresensi = DB::table('presensis')
            ->where('siswa_id', $id)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        return view('kepala-sekolah.monitoring.siswa.show', [
            'siswa' => $siswa,
            'nilaiPerMapel' => $nilaiPerMapel,
            'rekapPresensi' => $rekapPresensi,
        ]);
    }
}
```

---

## 5. FITUR APPROVAL RPP

### 5.1 Model Rpp dengan Status Approval

**File:** `app/Models/Rpp.php` (tambahkan field)

```php
protected $fillable = [
    // ... field lainnya
    'status_approval', // pending, approved, rejected
    'approved_by',
    'approved_at',
    'rejection_reason',
];

protected $casts = [
    'approved_at' => 'datetime',
];

/**
 * Relasi ke User (Kepala Sekolah yang approve)
 */
public function approvedBy()
{
    return $this->belongsTo(User::class, 'approved_by');
}
```

### 5.2 ApprovalRppController

**File:** `app/Http/Controllers/KepalaSekolah/ApprovalRppController.php`

```php
<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rpp;
use Illuminate\Support\Facades\Auth;

class ApprovalRppController extends Controller
{
    /**
     * Tampilkan daftar RPP pending
     */
    public function index()
    {
        $rppPending = Rpp::with('guru.user')
            ->where('status_approval', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $rppApproved = Rpp::with('guru.user')
            ->where('status_approval', 'approved')
            ->orderBy('approved_at', 'desc')
            ->limit(10)
            ->get();

        $rppRejected = Rpp::with('guru.user')
            ->where('status_approval', 'rejected')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('kepala-sekolah.approval.index', [
            'rppPending' => $rppPending,
            'rppApproved' => $rppApproved,
            'rppRejected' => $rppRejected,
        ]);
    }

    /**
     * Review RPP
     */
    public function show($id)
    {
        $rpp = Rpp::with('guru.user')->findOrFail($id);
        return view('kepala-sekolah.approval.show', ['rpp' => $rpp]);
    }

    /**
     * Approve RPP
     */
    public function approve(Request $request, $id)
    {
        $rpp = Rpp::findOrFail($id);

        $request->validate([
            'catatan' => 'nullable|string',
        ]);

        // Update status
        $rpp->update([
            'status_approval' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'catatan_approval' => $request->catatan,
        ]);

        // TODO: Kirim notifikasi ke guru

        return redirect()->route('kepala-sekolah.approval.index')
            ->with('success', 'RPP berhasil di-approve!');
    }

    /**
     * Reject RPP
     */
    public function reject(Request $request, $id)
    {
        $rpp = Rpp::findOrFail($id);

        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        // Update status
        $rpp->update([
            'status_approval' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // TODO: Kirim notifikasi ke guru

        return redirect()->route('kepala-sekolah.approval.index')
            ->with('success', 'RPP berhasil di-reject!');
    }

    /**
     * Bulk approve RPP
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'rpp_ids' => 'required|array',
            'rpp_ids.*' => 'exists:rpps,id',
        ]);

        // Update semua RPP yang dipilih
        Rpp::whereIn('id', $request->rpp_ids)
            ->update([
                'status_approval' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

        return redirect()->route('kepala-sekolah.approval.index')
            ->with('success', count($request->rpp_ids) . ' RPP berhasil di-approve!');
    }
}
```

### 5.3 View Approval RPP

**File:** `resources/views/kepala-sekolah/approval/index.blade.php`

```blade
@extends('layouts.kepala-sekolah')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Approval RPP</h2>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#pending">
                Pending <span class="badge bg-warning">{{ $rppPending->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#approved">
                Approved <span class="badge bg-success">{{ $rppApproved->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#rejected">
                Rejected <span class="badge bg-danger">{{ $rppRejected->count() }}</span>
            </a>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content">
        {{-- Pending Tab --}}
        <div class="tab-pane fade show active" id="pending">
            <form action="{{ route('kepala-sekolah.approval.bulk-approve') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Bulk Approve
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Guru</th>
                                <th>Mata Pelajaran</th>
                                <th>Pertemuan Ke-</th>
                                <th>Tanggal Submit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rppPending as $rpp)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="rpp_ids[]" value="{{ $rpp->id }}">
                                    </td>
                                    <td>{{ $rpp->guru->user->name }}</td>
                                    <td>{{ $rpp->mata_pelajaran }}</td>
                                    <td>{{ $rpp->pertemuan_ke }}</td>
                                    <td>{{ $rpp->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('kepala-sekolah.approval.show', $rpp->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        {{-- Approved Tab --}}
        <div class="tab-pane fade" id="approved">
            {{-- Similar table for approved RPP --}}
        </div>

        {{-- Rejected Tab --}}
        <div class="tab-pane fade" id="rejected">
            {{-- Similar table for rejected RPP --}}
        </div>
    </div>
</div>

<script>
// Select all checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="rpp_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>
@endsection
```

---

## 6. FITUR LAPORAN AKADEMIK

### 6.1 LaporanController

**File:** `app/Http/Controllers/KepalaSekolah/LaporanController.php`

```php
<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; // Menggunakan barryvdh/laravel-dompdf

class LaporanController extends Controller
{
    /**
     * Laporan Nilai
     */
    public function laporanNilai(Request $request)
    {
        $kelas = $request->query('kelas', 'VII');
        $semester = $request->query('semester', 'Ganjil');

        $data = DB::table('nilai_siswas')
            ->join('siswas', 'nilai_siswas.siswa_id', '=', 'siswas.id')
            ->join('kuis', 'nilai_siswas.kuis_id', '=', 'kuis.id')
            ->where('siswas.kelas', $kelas)
            ->select(
                'siswas.nama_lengkap',
                'kuis.mata_pelajaran',
                DB::raw('AVG(nilai_siswas.nilai) as rata_rata')
            )
            ->groupBy('siswas.id', 'kuis.mata_pelajaran')
            ->get();

        return view('kepala-sekolah.laporan.nilai', [
            'data' => $data,
            'kelas' => $kelas,
            'semester' => $semester,
        ]);
    }

    /**
     * Export Laporan Nilai ke PDF
     */
    public function exportNilaiPDF(Request $request)
    {
        $kelas = $request->query('kelas', 'VII');
        $semester = $request->query('semester', 'Ganjil');

        $data = // ... query sama seperti laporanNilai

        $pdf = PDF::loadView('kepala-sekolah.laporan.nilai-pdf', [
            'data' => $data,
            'kelas' => $kelas,
            'semester' => $semester,
        ]);

        return $pdf->download('laporan-nilai-' . $kelas . '.pdf');
    }

    /**
     * Laporan Kinerja Guru
     */
    public function laporanKinerjaGuru()
    {
        $data = Guru::with('user')->get()->map(function($guru) {
            return [
                'nama' => $guru->user->name,
                'mata_pelajaran' => $guru->mata_pelajaran,
                'jumlah_rpp' => Rpp::where('guru_id', $guru->id)->count(),
                'jumlah_materi' => Materi::where('guru_id', $guru->id)->count(),
                'jumlah_kuis' => Kuis::where('guru_id', $guru->id)->count(),
                'rata_rata_nilai_siswa' => DB::table('nilai_siswas')
                    ->join('kuis', 'nilai_siswas.kuis_id', '=', 'kuis.id')
                    ->where('kuis.guru_id', $guru->id)
                    ->avg('nilai_siswas.nilai'),
            ];
        });

        return view('kepala-sekolah.laporan.kinerja-guru', [
            'data' => $data,
        ]);
    }
}
```

---

## 7. FITUR ANALYTICS

### 7.1 AnalyticsController

**File:** `app/Http/Controllers/KepalaSekolah/AnalyticsController.php`

```php
<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Dashboard Analytics
     */
    public function index()
    {
        // Grafik Nilai per Mata Pelajaran
        $nilaiPerMapel = DB::table('nilai_siswas')
            ->join('kuis', 'nilai_siswas.kuis_id', '=', 'kuis.id')
            ->select('kuis.mata_pelajaran', DB::raw('AVG(nilai_siswas.nilai) as rata_rata'))
            ->groupBy('kuis.mata_pelajaran')
            ->get();

        // Grafik Tren Nilai (Bulanan)
        $trenNilai = DB::table('nilai_siswas')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('AVG(nilai) as rata_rata')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Grafik Kehadiran per Kelas
        $kehadiranPerKelas = DB::table('presensis')
            ->join('siswas', 'presensis.siswa_id', '=', 'siswas.id')
            ->select(
                'siswas.kelas',
                DB::raw('SUM(CASE WHEN presensis.status = "H" THEN 1 ELSE 0 END) as hadir'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('siswas.kelas')
            ->get()
            ->map(function($item) {
                $item->persentase = ($item->hadir / $item->total) * 100;
                return $item;
            });

        return view('kepala-sekolah.analytics.index', [
            'nilaiPerMapel' => $nilaiPerMapel,
            'trenNilai' => $trenNilai,
            'kehadiranPerKelas' => $kehadiranPerKelas,
        ]);
    }
}
```

### 7.2 View Analytics dengan Chart.js

**File:** `resources/views/kepala-sekolah/analytics/index.blade.php`

```blade
@extends('layouts.kepala-sekolah')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Statistik & Analytics</h2>

    <div class="row">
        {{-- Grafik Nilai per Mata Pelajaran --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Nilai per Mata Pelajaran</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartNilaiPerMapel"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Tren Nilai --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Tren Nilai (Bulanan)</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartTrenNilai"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Kehadiran per Kelas --}}
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Kehadiran per Kelas</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartKehadiranPerKelas"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Nilai per Mata Pelajaran
const ctxNilaiPerMapel = document.getElementById('chartNilaiPerMapel').getContext('2d');
new Chart(ctxNilaiPerMapel, {
    type: 'bar',
    data: {
        labels: @json($nilaiPerMapel->pluck('mata_pelajaran')),
        datasets: [{
            label: 'Rata-rata Nilai',
            data: @json($nilaiPerMapel->pluck('rata_rata')),
            backgroundColor: 'rgba(46, 125, 50, 0.6)',
            borderColor: 'rgba(46, 125, 50, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});

// Chart Tren Nilai
const ctxTrenNilai = document.getElementById('chartTrenNilai').getContext('2d');
new Chart(ctxTrenNilai, {
    type: 'line',
    data: {
        labels: @json($trenNilai->pluck('bulan')->map(fn($b) => 'Bulan ' . $b)),
        datasets: [{
            label: 'Rata-rata Nilai',
            data: @json($trenNilai->pluck('rata_rata')),
            borderColor: 'rgba(76, 175, 80, 1)',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            tension: 0.4
        }]
    }
});

// Chart Kehadiran per Kelas
const ctxKehadiranPerKelas = document.getElementById('chartKehadiranPerKelas').getContext('2d');
new Chart(ctxKehadiranPerKelas, {
    type: 'bar',
    data: {
        labels: @json($kehadiranPerKelas->pluck('kelas')),
        datasets: [{
            label: 'Persentase Kehadiran (%)',
            data: @json($kehadiranPerKelas->pluck('persentase')),
            backgroundColor: 'rgba(33, 150, 243, 0.6)',
            borderColor: 'rgba(33, 150, 243, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>
@endsection
```

---

## 8. ROUTING & MIDDLEWARE

### 8.1 Routes untuk Kepala Sekolah

**File:** `routes/web.php`

```php
// ===== KEPALA SEKOLAH ROUTES =====
Route::middleware(['auth', 'role:kepala_sekolah'])
    ->prefix('kepala-sekolah')
    ->name('kepala-sekolah.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [KepalaSekolahController::class, 'dashboard'])
            ->name('dashboard');
        
        // Monitoring Guru
        Route::get('/monitoring/guru', ['KepalaSekolah\MonitoringGuruController', 'index'])
            ->name('monitoring.guru.index');
        Route::get('/monitoring/guru/{id}', ['KepalaSekolah\MonitoringGuruController', 'show'])
            ->name('monitoring.guru.show');
        
        // Monitoring Siswa
        Route::get('/monitoring/siswa', ['KepalaSekolah\MonitoringSiswaController', 'index'])
            ->name('monitoring.siswa.index');
        Route::get('/monitoring/siswa/{id}', ['KepalaSekolah\MonitoringSiswaController', 'show'])
            ->name('monitoring.siswa.show');
        
        // Approval RPP
        Route::get('/approval', ['KepalaSekolah\ApprovalRppController', 'index'])
            ->name('approval.index');
        Route::get('/approval/{id}', ['KepalaSekolah\ApprovalRppController', 'show'])
            ->name('approval.show');
        Route::post('/approval/{id}/approve', ['KepalaSekolah\ApprovalRppController', 'approve'])
            ->name('approval.approve');
        Route::post('/approval/{id}/reject', ['KepalaSekolah\ApprovalRppController', 'reject'])
            ->name('approval.reject');
        Route::post('/approval/bulk-approve', ['KepalaSekolah\ApprovalRppController', 'bulkApprove'])
            ->name('approval.bulk-approve');
        
        // Laporan
        Route::get('/laporan/nilai', ['KepalaSekolah\LaporanController', 'laporanNilai'])
            ->name('laporan.nilai');
        Route::get('/laporan/nilai/pdf', ['KepalaSekolah\LaporanController', 'exportNilaiPDF'])
            ->name('laporan.nilai.pdf');
        Route::get('/laporan/kinerja-guru', ['KepalaSekolah\LaporanController', 'laporanKinerjaGuru'])
            ->name('laporan.kinerja-guru');
        
        // Analytics
        Route::get('/analytics', ['KepalaSekolah\AnalyticsController', 'index'])
            ->name('analytics.index');
    });
```

---

## 📝 KESIMPULAN

Sistem Kepala Sekolah di TMS NURANI fokus pada:

1. **Monitoring** - Lihat data guru dan siswa
2. **Approval** - Approve/reject RPP dari guru
3. **Laporan** - Generate laporan akademik
4. **Analytics** - Visualisasi data dengan grafik

**Teknologi yang Digunakan:**
- **Chart.js** untuk visualisasi grafik
- **Laravel PDF** untuk export laporan
- **Eloquent Relationships** untuk query data
- **DB Facade** untuk query kompleks

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
