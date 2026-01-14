# 📚 PANDUAN LENGKAP FITUR KEPALA SEKOLAH (USER + KODE)
## TMS NURANI - MTs Nurul Aiman

> **Catatan:** File ini menggabungkan panduan pengguna dengan penjelasan kode teknis untuk setiap fitur Kepala Sekolah

---

## 📖 DAFTAR ISI

1. [Fitur Dashboard & Statistik](#fitur-dashboard--statistik)
2. [Fitur Monitoring Guru](#fitur-monitoring-guru)
3. [Fitur Monitoring Siswa](#fitur-monitoring-siswa)
4. [Fitur Approval RPP](#fitur-approval-rpp)
5. [Fitur Laporan Akademik](#fitur-laporan-akademik)
6. [Fitur Analytics](#fitur-analytics)

---

## 1. FITUR DASHBOARD & STATISTIK

### 📱 CARA PAKAI (Untuk Kepala Sekolah)

**Apa yang Ditampilkan di Dashboard:**
1. Total Siswa Aktif
2. Total Guru Aktif
3. Total RPP yang Dibuat
4. RPP Pending Approval
5. Rata-rata Nilai Siswa
6. Tingkat Kehadiran Siswa
7. Grafik Nilai per Kelas

**Cara Akses:**
- Login sebagai Kepala Sekolah
- Otomatis masuk ke Dashboard

---

### 💻 PENJELASAN KODE

#### **A. Controller - Dashboard**

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
        // 1. Hitung total siswa aktif
        $totalSiswa = Siswa::where('status', 'aktif')->count();

        // 2. Hitung total guru aktif
        $totalGuru = Guru::where('status', 'aktif')->count();

        // 3. Hitung total RPP
        $totalRpp = Rpp::count();

        // 4. Hitung RPP pending approval
        $rppPending = Rpp::where('status_approval', 'pending')->count();

        // 5. Hitung rata-rata nilai siswa
        $rataRataNilai = DB::table('nilai_siswas')
            ->avg('nilai');

        // 6. Hitung tingkat kehadiran
        $totalPresensi = DB::table('presensis')->count();
        $totalHadir = DB::table('presensis')
            ->where('status', 'H')
            ->count();
        $tingkatKehadiran = $totalPresensi > 0 
            ? ($totalHadir / $totalPresensi * 100) 
            : 0;

        // 7. Ambil data nilai per kelas untuk grafik
        $nilaiPerKelas = DB::table('nilai_siswas')
            ->join('siswas', 'nilai_siswas.siswa_id', '=', 'siswas.id')
            ->select('siswas.kelas', DB::raw('AVG(nilai_siswas.nilai) as rata_rata'))
            ->groupBy('siswas.kelas')
            ->get();

        // 8. Return view dengan semua data
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

**Penjelasan:**
- `Siswa::where('status', 'aktif')->count()` → Hitung jumlah siswa dengan status aktif
- `Rpp::count()` → Hitung total semua RPP
- `DB::table('nilai_siswas')->avg('nilai')` → Hitung rata-rata nilai dari tabel nilai_siswas
- `->join('siswas', ...)` → Gabungkan tabel nilai_siswas dengan siswas
- `->groupBy('siswas.kelas')` → Kelompokkan berdasarkan kelas
- `DB::raw('AVG(...) as rata_rata')` → Hitung rata-rata dengan alias 'rata_rata'
- `round($rataRataNilai, 2)` → Bulatkan ke 2 desimal

---

#### **B. View - Dashboard**

**File:** `resources/views/kepala-sekolah/dashboard.blade.php`

```blade
@extends('layouts.kepala-sekolah')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Kepala Sekolah</h2>

    {{-- Statistik Cards --}}
    <div class="row mb-4">
        {{-- Total Siswa --}}
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-white-50">Total Siswa</h6>
                    <h2 class="stat-number">{{ $totalSiswa }}</h2>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Total Guru --}}
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-white-50">Total Guru</h6>
                    <h2 class="stat-number">{{ $totalGuru }}</h2>
                    <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Total RPP --}}
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h6 class="text-white-50">Total RPP</h6>
                    <h2 class="stat-number">{{ $totalRpp }}</h2>
                    <i class="fas fa-book fa-3x opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- RPP Pending --}}
        <div class="col-md-3">
            <div class="card stat-card bg-warning">
                <div class="card-body">
                    <h6 class="text-white-50">RPP Pending</h6>
                    <h2 class="stat-number">{{ $rppPending }}</h2>
                    <i class="fas fa-clock fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Rata-rata Nilai Siswa</h5>
                    <h2 class="text-primary">{{ $rataRataNilai }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Tingkat Kehadiran</h5>
                    <h2 class="text-success">{{ $tingkatKehadiran }}%</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Nilai per Kelas --}}
    <div class="card">
        <div class="card-header">
            <h5>Grafik Nilai per Kelas</h5>
        </div>
        <div class="card-body">
            <canvas id="chartNilaiPerKelas"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartNilaiPerKelas').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($nilaiPerKelas->pluck('kelas')),
        datasets: [{
            label: 'Rata-rata Nilai',
            data: @json($nilaiPerKelas->pluck('rata_rata')),
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
</script>
@endsection
```

**Penjelasan:**
- `{{ $totalSiswa }}` → Tampilkan variabel dari controller
- `@json($nilaiPerKelas->pluck('kelas'))` → Convert data PHP ke JSON untuk JavaScript
- `->pluck('kelas')` → Ambil hanya kolom 'kelas' dari collection
- `Chart.js` → Library JavaScript untuk buat grafik
- `type: 'bar'` → Jenis grafik batang
- `beginAtZero: true` → Sumbu Y dimulai dari 0

---

## 2. FITUR MONITORING GURU

### 📱 CARA PAKAI (Untuk Kepala Sekolah)

**Apa yang Bisa Dilakukan:**
1. Lihat daftar semua guru
2. Lihat statistik kinerja guru (jumlah RPP, materi, kuis)
3. Lihat detail guru (profil, RPP yang dibuat, dll)

**Langkah-langkah:**
1. Klik menu "Monitoring Guru"
2. Lihat daftar guru dengan statistik
3. Klik nama guru untuk lihat detail

---

### 💻 PENJELASAN KODE

#### **A. Controller - Monitoring Guru**

**File:** `app/Http/Controllers/KepalaSekolah/MonitoringGuruController.php`

```php
<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Rpp;
use App\Models\Materi;
use App\Models\Kuis;
use Illuminate\Support\Facades\DB;

class MonitoringGuruController extends Controller
{
    /**
     * Tampilkan daftar guru dengan statistik
     */
    public function index()
    {
        // Ambil semua guru dengan relasi user
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
        // Ambil data guru dengan relasi user
        $guru = Guru::with('user')->findOrFail($id);

        // Ambil semua RPP guru ini
        $rpps = Rpp::where('guru_id', $id)->get();

        // Ambil semua materi guru ini
        $materis = Materi::where('guru_id', $id)->get();

        // Ambil semua kuis guru ini
        $kuis = Kuis::where('guru_id', $id)->get();

        // Hitung rata-rata nilai siswa dari kuis guru ini
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

**Penjelasan:**
- `Guru::with('user')` → Eager loading relasi user (ambil data user sekaligus)
- `->get()->map(function($guru) { ... })` → Transform setiap data guru
- `Rpp::where('guru_id', $guru->id)->count()` → Hitung jumlah RPP guru
- `findOrFail($id)` → Cari data atau throw 404 jika tidak ada
- `->join('kuis', ...)` → Join tabel nilai_siswas dengan kuis
- `->where('kuis.guru_id', $id)` → Filter berdasarkan guru_id di tabel kuis

---

#### **B. View - Index Monitoring Guru**

**File:** `resources/views/kepala-sekolah/monitoring/guru/index.blade.php`

```blade
@extends('layouts.kepala-sekolah')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Monitoring Guru</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Mata Pelajaran</th>
                    <th>Jumlah RPP</th>
                    <th>Jumlah Materi</th>
                    <th>Jumlah Kuis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gurus as $index => $guru)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $guru['nama'] }}</td>
                        <td>{{ $guru['nip'] }}</td>
                        <td>{{ $guru['mata_pelajaran'] }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $guru['jumlah_rpp'] }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $guru['jumlah_materi'] }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $guru['jumlah_kuis'] }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $guru['status'] == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($guru['status']) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('kepala-sekolah.monitoring.guru.show', $guru['id']) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
```

**Penjelasan:**
- `@foreach($gurus as $index => $guru)` → Loop semua data guru
- `{{ $index + 1 }}` → Nomor urut (dimulai dari 1)
- `{{ $guru['nama'] }}` → Akses array dengan key 'nama'
- `{{ $guru['status'] == 'aktif' ? 'bg-success' : 'bg-secondary' }}` → Ternary operator (if-else singkat)
- `{{ route('kepala-sekolah.monitoring.guru.show', $guru['id']) }}` → Generate URL dengan parameter ID

---

## 3. FITUR MONITORING SISWA

### 📱 CARA PAKAI (Untuk Kepala Sekolah)

**Apa yang Bisa Dilakukan:**
1. Lihat daftar semua siswa
2. Lihat rata-rata nilai dan tingkat kehadiran siswa
3. Lihat detail siswa (nilai per mapel, rekap presensi)

**Langkah-langkah:**
1. Klik menu "Monitoring Siswa"
2. Filter by kelas (opsional)
3. Klik nama siswa untuk lihat detail

---

### 💻 PENJELASAN KODE

#### **A. Controller - Monitoring Siswa**

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
            // Hitung rata-rata nilai
            $rataRataNilai = DB::table('nilai_siswas')
                ->where('siswa_id', $siswa->id)
                ->avg('nilai');

            // Hitung tingkat kehadiran
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

**Penjelasan:**
- `Siswa::all()` → Ambil semua data siswa
- `->map(function($siswa) { ... })` → Transform setiap siswa
- Hitung rata-rata nilai per siswa
- Hitung tingkat kehadiran: (hadir / total) * 100
- `->groupBy('kuis.mata_pelajaran')` → Kelompokkan berdasarkan mata pelajaran
- `->groupBy('status')` → Kelompokkan berdasarkan status presensi (H/S/I/A)

---

## 4. FITUR APPROVAL RPP

### 📱 CARA PAKAI (Untuk Kepala Sekolah)

**Apa yang Bisa Dilakukan:**
1. Lihat daftar RPP pending approval
2. Review RPP (baca isi RPP)
3. Approve RPP (setujui)
4. Reject RPP (tolak dengan alasan)
5. Bulk Approve (approve banyak sekaligus)

**Langkah-langkah Approve:**
1. Klik menu "Approval RPP"
2. Klik "Review" pada RPP yang ingin di-approve
3. Baca isi RPP
4. Klik "Approve" atau "Reject"
5. Isi catatan (opsional untuk approve, wajib untuk reject)
6. Konfirmasi

---

### 💻 PENJELASAN KODE

#### **A. Database - Tambahan Field di Tabel RPP**

```sql
ALTER TABLE rpps ADD COLUMN status_approval ENUM('pending', 'approved', 'rejected') DEFAULT 'pending';
ALTER TABLE rpps ADD COLUMN approved_by BIGINT NULL;
ALTER TABLE rpps ADD COLUMN approved_at TIMESTAMP NULL;
ALTER TABLE rpps ADD COLUMN catatan_approval TEXT NULL;
ALTER TABLE rpps ADD COLUMN rejection_reason TEXT NULL;
```

**Penjelasan:**
- `status_approval` → Status approval (pending/approved/rejected)
- `approved_by` → ID user yang approve/reject (Kepala Sekolah)
- `approved_at` → Waktu approve/reject
- `catatan_approval` → Catatan saat approve
- `rejection_reason` → Alasan reject

---

#### **B. Model - Update Model Rpp**

```php
protected $fillable = [
    // ... field lainnya
    'status_approval',
    'approved_by',
    'approved_at',
    'catatan_approval',
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

---

#### **C. Controller - Approval RPP**

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

**Penjelasan:**
- `Rpp::with('guru.user')` → Eager load relasi guru dan user
- `->where('status_approval', 'pending')` → Filter RPP yang pending
- `->limit(10)` → Ambil maksimal 10 data
- `Auth::id()` → ID user yang sedang login (Kepala Sekolah)
- `now()` → Waktu sekarang
- `Rpp::whereIn('id', $request->rpp_ids)` → Update banyak RPP sekaligus
- `count($request->rpp_ids)` → Hitung jumlah RPP yang di-approve

---

#### **D. View - Approval RPP**

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

        {{-- Approved & Rejected Tabs (similar structure) --}}
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

**Penjelasan:**
- `data-bs-toggle="tab"` → Bootstrap tab switcher
- `{{ $rppPending->count() }}` → Hitung jumlah RPP pending
- `<input type="checkbox" name="rpp_ids[]">` → Checkbox untuk bulk approve (array)
- `{{ $rpp->created_at->format('d M Y') }}` → Format tanggal (contoh: 14 Jan 2026)
- `document.querySelectorAll()` → Ambil semua element dengan selector
- `forEach()` → Loop semua checkbox
- `cb.checked = this.checked` → Set checked sama dengan checkbox "Select All"

---

## 5. FITUR LAPORAN AKADEMIK

### 📱 CARA PAKAI (Untuk Kepala Sekolah)

**Jenis Laporan:**
1. Laporan Nilai (per kelas, semester)
2. Laporan Presensi (per kelas, bulan)
3. Laporan Kinerja Guru

**Langkah-langkah:**
1. Klik menu "Laporan Akademik"
2. Pilih jenis laporan
3. Pilih filter (kelas, semester, bulan)
4. Klik "Tampilkan Laporan"
5. Klik "Export PDF" atau "Export Excel"

---

### 💻 PENJELASAN KODE

#### **A. Controller - Laporan**

**File:** `app/Http/Controllers/KepalaSekolah/LaporanController.php`

```php
<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; // barryvdh/laravel-dompdf

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

        // Query sama seperti laporanNilai
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

        // Generate PDF
        $pdf = PDF::loadView('kepala-sekolah.laporan.nilai-pdf', [
            'data' => $data,
            'kelas' => $kelas,
            'semester' => $semester,
        ]);

        return $pdf->download('laporan-nilai-' . $kelas . '.pdf');
    }
}
```

**Penjelasan:**
- `->groupBy('siswas.id', 'kuis.mata_pelajaran')` → Group by siswa dan mata pelajaran
- `DB::raw('AVG(...) as rata_rata')` → Hitung rata-rata dengan alias
- `PDF::loadView()` → Load view Blade untuk dijadikan PDF
- `->download()` → Download PDF dengan nama file tertentu

---

## 6. FITUR ANALYTICS

### 📱 CARA PAKAI (Untuk Kepala Sekolah)

**Grafik yang Tersedia:**
1. Grafik Nilai per Mata Pelajaran
2. Grafik Tren Nilai (Bulanan)
3. Grafik Kehadiran per Kelas
4. Grafik Kinerja Guru

**Langkah-langkah:**
1. Klik menu "Statistik & Analytics"
2. Lihat semua grafik
3. Klik "Export Report" untuk download

---

### 💻 PENJELASAN KODE

#### **A. Controller - Analytics**

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

**Penjelasan:**
- `DB::raw('MONTH(created_at) as bulan')` → Ambil bulan dari tanggal
- `DB::raw('SUM(CASE WHEN ... THEN 1 ELSE 0 END)')` → Conditional sum (hitung jika kondisi terpenuhi)
- `->map(function($item) { ... })` → Transform data setelah query
- `$item->persentase = ...` → Tambah property baru ke object

---

#### **B. View - Analytics dengan Chart.js**

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
</script>
@endsection
```

**Penjelasan:**
- `Chart.js` → Library JavaScript untuk visualisasi data
- `type: 'bar'` → Grafik batang
- `type: 'line'` → Grafik garis
- `@json($nilaiPerMapel->pluck('mata_pelajaran'))` → Convert PHP collection ke JSON array
- `->map(fn($b) => 'Bulan ' . $b)` → Transform data (tambahkan prefix "Bulan ")
- `tension: 0.4` → Kelengkungan garis (0 = lurus, 1 = sangat lengkung)

---

## 🔄 ROUTING LENGKAP KEPALA SEKOLAH

**File:** `routes/web.php`

```php
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
        
        // Analytics
        Route::get('/analytics', ['KepalaSekolah\AnalyticsController', 'index'])
            ->name('analytics.index');
    });
```

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
