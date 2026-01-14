# 💻 BUKU PANDUAN TEKNIS: FITUR GURU (DENGAN KODE)
## TMS NURANI - MTs Nurul Aiman

---

## 📖 DAFTAR ISI

1. [Arsitektur Sistem Guru](#arsitektur-sistem-guru)
2. [Database Structure](#database-structure)
3. [Authentication & Login](#authentication--login)
4. [Dashboard Guru](#dashboard-guru)
5. [Fitur RPP](#fitur-rpp)
6. [Fitur Materi Pembelajaran](#fitur-materi-pembelajaran)
7. [Fitur Kuis](#fitur-kuis)
8. [Fitur Presensi](#fitur-presensi)
9. [Fitur Evaluasi](#fitur-evaluasi)
10. [Routing & Middleware](#routing--middleware)

---

## 1. ARSITEKTUR SISTEM GURU

### 1.1 Flow Diagram

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│   Routes    │ (routes/web.php)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Middleware  │ (auth, role:guru)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Controller  │ (GuruController, RppController, dll)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│   Model     │ (User, Guru, Rpp, dll)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│  Database   │ (MySQL)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│    View     │ (Blade Templates)
└─────────────┘
```

### 1.2 Folder Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── GuruController.php
│   │   ├── RppController.php
│   │   ├── MateriController.php
│   │   ├── KuisController.php
│   │   └── PresensiController.php
│   └── Middleware/
│       └── CheckRole.php
├── Models/
│   ├── User.php
│   ├── Guru.php
│   ├── Rpp.php
│   ├── MateriPembelajaran.php
│   ├── Kuis.php
│   └── Presensi.php

resources/views/guru/
├── dashboard.blade.php
├── rpp/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── materi/
├── kuis/
└── presensi/

routes/
└── web.php
```

---

## 2. DATABASE STRUCTURE

### 2.1 Tabel `users`

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('guru', 'tu', 'kepala_sekolah') NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 2.2 Tabel `gurus`

```sql
CREATE TABLE gurus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    nip VARCHAR(255) NULL,
    mata_pelajaran VARCHAR(255) NULL,
    foto VARCHAR(255) NULL,
    kontak VARCHAR(255) NULL,
    biodata TEXT NULL,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 2.3 Tabel `rpps`

```sql
CREATE TABLE rpps (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    guru_id BIGINT UNSIGNED NOT NULL,
    judul VARCHAR(255) NOT NULL,
    mata_pelajaran VARCHAR(255) NOT NULL,
    kelas VARCHAR(50) NOT NULL,
    semester VARCHAR(50) NOT NULL,
    pertemuan_ke INT NOT NULL,
    alokasi_waktu INT NOT NULL,
    sekolah VARCHAR(255) NULL,
    tahun_pelajaran VARCHAR(50) NULL,
    ki_1 TEXT NULL,
    ki_2 TEXT NULL,
    ki_3 TEXT NULL,
    ki_4 TEXT NULL,
    kd_pengetahuan TEXT NULL,
    kd_keterampilan TEXT NULL,
    indikator_pencapaian_kompetensi TEXT NULL,
    tujuan_pembelajaran TEXT NULL,
    materi_pembelajaran TEXT NULL,
    metode_pembelajaran TEXT NULL,
    kegiatan_pendahuluan TEXT NULL,
    kegiatan_inti TEXT NULL,
    kegiatan_penutup TEXT NULL,
    media_pembelajaran TEXT NULL,
    sumber_belajar TEXT NULL,
    teknik_penilaian TEXT NULL,
    bentuk_instrumen TEXT NULL,
    rubrik_penilaian TEXT NULL,
    kriteria_ketuntasan TEXT NULL,
    nama_kepala_sekolah VARCHAR(255) NULL,
    nip_kepala_sekolah VARCHAR(255) NULL,
    ttd_kepala_sekolah VARCHAR(255) NULL,
    ttd_guru VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (guru_id) REFERENCES gurus(id) ON DELETE CASCADE
);
```

---

## 3. AUTHENTICATION & LOGIN

### 3.1 Model User

**File:** `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi One-to-One ke Guru
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    /**
     * Helper method untuk cek role
     */
    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isTU()
    {
        return $this->role === 'tu';
    }

    public function isKepalaSekolah()
    {
        return $this->role === 'kepala_sekolah';
    }
}
```

### 3.2 Model Guru

**File:** `app/Models/Guru.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'mata_pelajaran',
        'foto',
        'kontak',
        'biodata',
        'status',
    ];

    /**
     * Relasi One-to-One ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi One-to-Many ke RPP
     */
    public function rpps()
    {
        return $this->hasMany(Rpp::class);
    }

    /**
     * Get mata pelajaran as array
     */
    public function getMataPelajaranListAttribute()
    {
        return explode(',', $this->mata_pelajaran);
    }
}
```

### 3.3 AuthController - Login

**File:** `app/Http/Controllers/AuthController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;

class AuthController extends Controller
{
    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:guru,tu,kepala_sekolah',
        ]);

        // 2. Siapkan credentials
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ];

        // 3. Attempt login
        if (Auth::attempt($credentials, $request->remember)) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            $user = Auth::user();

            // 4. Redirect berdasarkan role
            if ($user->isGuru()) {
                // Cek apakah data guru ada
                $guru = Guru::where('user_id', $user->id)->first();
                
                if (!$guru) {
                    Auth::logout();
                    return back()->with('error', 'Data guru tidak ditemukan');
                }

                // Ambil mata pelajaran pertama (default)
                $mataPelajaranList = explode(',', $guru->mata_pelajaran);
                $defaultMataPelajaran = trim($mataPelajaranList[0]);

                return redirect()->route('guru.dashboard', [
                    'mata_pelajaran' => $defaultMataPelajaran
                ]);
            }

            // Role lainnya...
            if ($user->isTU()) {
                return redirect()->route('tu.dashboard');
            }

            if ($user->isKepalaSekolah()) {
                return redirect()->route('kepala-sekolah.dashboard');
            }
        }

        // Login gagal
        return back()->with('error', 'Email atau password salah');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
```

---

## 4. DASHBOARD GURU

### 4.1 GuruController - Dashboard

**File:** `app/Http/Controllers/GuruController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\MateriPembelajaran;

class GuruController extends Controller
{
    /**
     * Tampilkan dashboard guru
     */
    public function dashboard(Request $request)
    {
        // 1. Ambil data guru yang sedang login
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')
                ->with('error', 'Data guru tidak ditemukan');
        }

        // 2. Ambil daftar mata pelajaran yang diajar
        $mataPelajaranList = collect(explode(',', $guru->mata_pelajaran))
            ->map(function($mp) {
                return (object)['mata_pelajaran' => trim($mp)];
            });

        // 3. Ambil mata pelajaran yang dipilih (dari query string)
        $selectedMataPelajaran = $request->query('mata_pelajaran');
        
        // Jika tidak ada yang dipilih, ambil yang pertama
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        // 4. Ambil materi pembelajaran untuk mata pelajaran yang dipilih
        $materiPembelajaran = MateriPembelajaran::where('guru_id', $guru->id)
            ->where('mata_pelajaran', $selectedMataPelajaran)
            ->first();

        // 5. Return view dengan data
        return view('guru.dashboard', [
            'guru' => $guru,
            'mataPelajaranList' => $mataPelajaranList,
            'selectedMataPelajaran' => $selectedMataPelajaran,
            'materiPembelajaran' => $materiPembelajaran,
        ]);
    }
}
```

### 4.2 View Dashboard

**File:** `resources/views/guru/dashboard.blade.php`

```blade
@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        @include('partials.guru-sidebar')

        {{-- Main Content --}}
        <div class="col-md-9 col-lg-10 p-4">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Selamat Datang, {{ $guru->user->name }}!</h2>
                    <p class="text-muted mb-0">Kelola materi pembelajaran dan aktivitas mengajar Anda</p>
                </div>
                
                {{-- Dropdown Mata Pelajaran --}}
                @if($mataPelajaranList->count() > 1)
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown">
                            <i class="fas fa-book me-2"></i>{{ $selectedMataPelajaran ?? 'Pilih Mata Pelajaran' }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach($mataPelajaranList as $mp)
                                <li>
                                    <a class="dropdown-item {{ $selectedMataPelajaran == $mp->mata_pelajaran ? 'active' : '' }}" 
                                       href="{{ route('guru.dashboard', ['mata_pelajaran' => $mp->mata_pelajaran]) }}">
                                        <i class="fas fa-book me-2"></i>{{ $mp->mata_pelajaran }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Materi Pembelajaran Card --}}
            <div class="card content-card mb-4">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-book-open me-2 text-primary"></i>
                            Materi Pembelajaran - {{ $selectedMataPelajaran ?? 'Mata Pelajaran' }}
                        </h5>
                        <a href="{{ route('guru.materi-pembelajaran.edit', ['mata_pelajaran' => $selectedMataPelajaran]) }}" 
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-2"></i>Edit Materi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($materiPembelajaran)
                        {{-- Tampilkan materi --}}
                        <div class="mb-4">
                            <h6 class="text-primary">A. IDENTITAS SEKOLAH DAN PROGRAM</h6>
                            <p>{{ $materiPembelajaran->identitas_sekolah_program ?? 'Belum ada data' }}</p>
                        </div>
                        {{-- ... section lainnya --}}
                    @else
                        <p class="text-muted">Belum ada materi. Silakan klik "Edit Materi" untuk menambahkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

---

## 5. FITUR RPP

### 5.1 Model RPP

**File:** `app/Models/Rpp.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rpp extends Model
{
    protected $fillable = [
        'guru_id',
        'judul',
        'mata_pelajaran',
        'kelas',
        'semester',
        'pertemuan_ke',
        'alokasi_waktu',
        'sekolah',
        'tahun_pelajaran',
        'ki_1',
        'ki_2',
        'ki_3',
        'ki_4',
        'kd_pengetahuan',
        'kd_keterampilan',
        'indikator_pencapaian_kompetensi',
        'tujuan_pembelajaran',
        'materi_pembelajaran',
        'materi_pembelajaran_reguler',
        'materi_pembelajaran_pengayaan',
        'materi_pembelajaran_remedial',
        'metode_pembelajaran',
        'kegiatan_pendahuluan',
        'kegiatan_inti',
        'kegiatan_penutup',
        'media_pembelajaran',
        'sumber_belajar',
        'teknik_penilaian',
        'bentuk_instrumen',
        'rubrik_penilaian',
        'kriteria_ketuntasan',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'ttd_kepala_sekolah',
        'ttd_guru',
        'nama_kantor',
        'kota_kabupaten',
        'alamat_lengkap',
    ];

    /**
     * Relasi ke Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
```

### 5.2 RppController - Create

**File:** `app/Http/Controllers/RppController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Rpp;

class RppController extends Controller
{
    /**
     * Tampilkan form create RPP
     */
    public function create(Request $request)
    {
        // 1. Ambil data guru
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')
                ->with('error', 'Data guru tidak ditemukan');
        }

        // 2. Ambil parameter dari URL
        $mataPelajaran = $request->query('mata_pelajaran');
        $pertemuanKe = $request->query('pertemuan_ke', 1);

        // 3. Return view
        return view('guru.rpp.create', [
            'guru' => $guru,
            'mataPelajaran' => $mataPelajaran,
            'pertemuanKe' => $pertemuanKe,
        ]);
    }

    /**
     * Simpan RPP baru
     */
    public function store(Request $request)
    {
        // 1. Ambil data guru
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')
                ->with('error', 'Data guru tidak ditemukan');
        }

        // 2. Validasi input
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
            'nama_kepala_sekolah' => 'required|string|max:255',
            'nip_kepala_sekolah' => 'required|string|max:255',
            'ttd_kepala_sekolah' => 'nullable|image|max:2048',
            'ttd_guru' => 'nullable|image|max:2048',
            'nama_kantor' => 'nullable|string|max:255',
            'kota_kabupaten' => 'nullable|string|max:255',
            'alamat_lengkap' => 'nullable|string',
        ]);

        // 3. Cek apakah RPP untuk pertemuan ini sudah ada
        $existingRpp = Rpp::where('guru_id', $guru->id)
            ->where('mata_pelajaran', $validated['mata_pelajaran'])
            ->where('pertemuan_ke', $validated['pertemuan_ke'])
            ->first();

        if ($existingRpp) {
            return redirect()->back()
                ->with('error', 'RPP untuk Pertemuan ' . $validated['pertemuan_ke'] . ' sudah ada. Silakan edit RPP yang sudah ada.')
                ->withInput();
        }

        // 4. Tambahkan guru_id
        $validated['guru_id'] = $guru->id;

        // 5. Handle file uploads
        if ($request->hasFile('ttd_kepala_sekolah')) {
            $validated['ttd_kepala_sekolah'] = $request->file('ttd_kepala_sekolah')
                ->store('signatures/kepala_sekolah', 'public');
        }

        if ($request->hasFile('ttd_guru')) {
            $validated['ttd_guru'] = $request->file('ttd_guru')
                ->store('signatures/guru', 'public');
        }

        // 6. Simpan RPP
        $rpp = Rpp::create($validated);

        // 7. Redirect dengan pesan sukses
        return redirect()->route('guru.dashboard', [
                'mata_pelajaran' => $validated['mata_pelajaran']
            ])
            ->with('success', 'RPP Pertemuan ' . $validated['pertemuan_ke'] . ' berhasil dibuat!');
    }
}
```

### 5.3 View Create RPP

**File:** `resources/views/guru/rpp/create.blade.php`

```blade
@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Buat RPP Baru</h2>

    {{-- Loading Overlay --}}
    <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
        <div class="text-center text-white">
            <i class="fas fa-spinner fa-spin fa-3x mb-3"></i>
            <h4>Menyimpan RPP...</h4>
        </div>
    </div>

    <form action="{{ route('guru.rpp.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- A. IDENTITAS --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">A. IDENTITAS</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Judul RPP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" 
                               value="{{ old('judul', 'RPP ' . $mataPelajaran . ' Pertemuan ' . $pertemuanKe) }}" 
                               required>
                        @error('judul')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="mata_pelajaran" 
                               value="{{ $mataPelajaran }}" readonly required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kelas <span class="text-danger">*</span></label>
                        <select class="form-control" name="kelas" required>
                            <option value="">Pilih Kelas</option>
                            <option value="VII">Kelas 7</option>
                            <option value="VIII">Kelas 8</option>
                            <option value="IX">Kelas 9</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Semester <span class="text-danger">*</span></label>
                        <select class="form-control" name="semester" required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pertemuan Ke- <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="pertemuan_ke" 
                               value="{{ $pertemuanKe }}" min="1" max="16" readonly required>
                    </div>
                </div>
            </div>
        </div>

        {{-- B. KOMPETENSI INTI --}}
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">B. KOMPETENSI INTI</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">KI 1 (Spiritual)</label>
                    <textarea class="form-control" name="ki_1" rows="3">{{ old('ki_1') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">KI 2 (Sosial)</label>
                    <textarea class="form-control" name="ki_2" rows="3">{{ old('ki_2') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">KI 3 (Pengetahuan)</label>
                    <textarea class="form-control" name="ki_3" rows="3">{{ old('ki_3') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">KI 4 (Keterampilan)</label>
                    <textarea class="form-control" name="ki_4" rows="3">{{ old('ki_4') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ... Section lainnya (KD, Materi, Kegiatan, Penilaian) --}}

        {{-- I. PENGESAHAN --}}
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">I. PENGESAHAN</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_kepala_sekolah" 
                               value="{{ old('nama_kepala_sekolah', 'Maman Suparman') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIP Kepala Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nip_kepala_sekolah" 
                               value="{{ old('nip_kepala_sekolah', '123123123') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Upload TTD Kepala Sekolah</label>
                        <input type="file" class="form-control" name="ttd_kepala_sekolah" 
                               accept="image/*" onchange="previewSignature(this, 'preview_ttd_kepsek')">
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                        <div id="preview_ttd_kepsek" class="mt-2"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Upload TTD Guru</label>
                        <input type="file" class="form-control" name="ttd_guru" 
                               accept="image/*" onchange="previewSignature(this, 'preview_ttd_guru')">
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                        <div id="preview_ttd_guru" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="text-end mb-4">
            <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save me-2"></i>Simpan RPP
            </button>
        </div>
    </form>
</div>

<script>
// Preview signature image
function previewSignature(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" 
                     style="max-width: 100%; max-height: 150px; object-fit: contain;">
                <p class="text-success mb-0 small mt-2">
                    <i class="fas fa-check-circle me-1"></i>Gambar berhasil dipilih
                </p>
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Handle form submission
document.querySelector('form').addEventListener('submit', function(e) {
    // Show loading overlay
    document.getElementById('loadingOverlay').style.display = 'flex';
    
    // Disable submit button
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
});
</script>
@endsection
```

---

## 6. FITUR MATERI PEMBELAJARAN

### 6.1 Model MateriPembelajaran

**File:** `app/Models/MateriPembelajaran.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriPembelajaran extends Model
{
    protected $table = 'materi_pembelajaran';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran',
        'identitas_sekolah_program',
        'kompetensi_inti_capaian',
        'unit_pembelajaran',
        'pendekatan_pembelajaran',
        'model_pembelajaran',
        'kegiatan_pembelajaran',
        'penilaian',
        'sarana_prasarana',
    ];

    /**
     * Relasi ke Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
```

### 6.2 MateriController - Edit & Update

**File:** `app/Http/Controllers/MateriPembelajaranController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\MateriPembelajaran;

class MateriPembelajaranController extends Controller
{
    /**
     * Tampilkan form edit materi
     */
    public function edit(Request $request)
    {
        // 1. Ambil data guru
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')
                ->with('error', 'Data guru tidak ditemukan');
        }

        // 2. Ambil mata pelajaran dari query string
        $mataPelajaran = $request->query('mata_pelajaran');

        // 3. Ambil materi pembelajaran (atau buat baru jika belum ada)
        $materi = MateriPembelajaran::firstOrNew([
            'guru_id' => $guru->id,
            'mata_pelajaran' => $mataPelajaran,
        ]);

        // 4. Return view
        return view('guru.materi-pembelajaran.edit', [
            'guru' => $guru,
            'mataPelajaran' => $mataPelajaran,
            'materi' => $materi,
        ]);
    }

    /**
     * Update materi pembelajaran
     */
    public function update(Request $request)
    {
        // 1. Ambil data guru
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')
                ->with('error', 'Data guru tidak ditemukan');
        }

        // 2. Validasi input
        $validated = $request->validate([
            'mata_pelajaran' => 'required|string|max:255',
            'identitas_sekolah_program' => 'nullable|string',
            'kompetensi_inti_capaian' => 'nullable|string',
            'unit_pembelajaran' => 'nullable|string',
            'pendekatan_pembelajaran' => 'nullable|string',
            'model_pembelajaran' => 'nullable|string',
            'kegiatan_pembelajaran' => 'nullable|string',
            'penilaian' => 'nullable|string',
            'sarana_prasarana' => 'nullable|string',
        ]);

        // 3. Update or Create materi
        $materi = MateriPembelajaran::updateOrCreate(
            [
                'guru_id' => $guru->id,
                'mata_pelajaran' => $validated['mata_pelajaran'],
            ],
            $validated
        );

        // 4. Redirect dengan pesan sukses
        return redirect()->route('guru.dashboard', [
                'mata_pelajaran' => $validated['mata_pelajaran']
            ])
            ->with('success', 'Materi pembelajaran berhasil disimpan!');
    }
}
```

---

## 7. ROUTING & MIDDLEWARE

### 7.1 Routes untuk Guru

**File:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\RppController;
use App\Http\Controllers\MateriPembelajaranController;

// ===== PUBLIC ROUTES =====
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== GURU ROUTES =====
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [GuruController::class, 'dashboard'])
            ->name('dashboard');
        
        // RPP
        Route::get('/rpp', [RppController::class, 'index'])
            ->name('rpp');
        Route::get('/rpp/create', [RppController::class, 'create'])
            ->name('rpp.create');
        Route::post('/rpp', [RppController::class, 'store'])
            ->name('rpp.store');
        Route::get('/rpp/{id}/edit', [RppController::class, 'edit'])
            ->name('rpp.edit');
        Route::put('/rpp/{id}', [RppController::class, 'update'])
            ->name('rpp.update');
        Route::delete('/rpp/{id}', [RppController::class, 'destroy'])
            ->name('rpp.destroy');
        
        // Materi Pembelajaran
        Route::get('/materi-pembelajaran/edit', [MateriPembelajaranController::class, 'edit'])
            ->name('materi-pembelajaran.edit');
        Route::post('/materi-pembelajaran', [MateriPembelajaranController::class, 'update'])
            ->name('materi-pembelajaran.update');
        
        // ... route lainnya (kuis, presensi, evaluasi)
    });
```

### 7.2 Middleware CheckRole

**File:** `app/Http/Middleware/CheckRole.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // 2. Cek apakah role user sesuai
        if (Auth::user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        // 3. Lanjutkan request
        return $next($request);
    }
}
```

### 7.3 Register Middleware

**File:** `bootstrap/app.php` (Laravel 11)

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware alias
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

---

## 📝 KESIMPULAN

Sistem Guru di TMS NURANI menggunakan arsitektur **MVC (Model-View-Controller)** dengan:

1. **Model** - Representasi data (User, Guru, Rpp, dll)
2. **View** - Tampilan (Blade templates)
3. **Controller** - Logic bisnis (GuruController, RppController, dll)
4. **Middleware** - Proteksi akses berdasarkan role
5. **Routes** - URL mapping

**Flow Request:**
```
Browser → Route → Middleware → Controller → Model → Database
                                    ↓
                                  View → Browser
```

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
