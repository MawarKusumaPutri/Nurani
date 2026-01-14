# 💻 BUKU PANDUAN TEKNIS: FITUR TENAGA USAHA (DENGAN KODE)
## TMS NURANI - MTs Nurul Aiman

---

## 📖 DAFTAR ISI

1. [Arsitektur Sistem TU](#arsitektur-sistem-tu)
2. [Database Structure](#database-structure)
3. [Authentication & Login](#authentication--login)
4. [Dashboard TU](#dashboard-tu)
5. [Fitur Manajemen Siswa](#fitur-manajemen-siswa)
6. [Fitur Manajemen Guru](#fitur-manajemen-guru)
7. [Fitur Jadwal Pelajaran](#fitur-jadwal-pelajaran)
8. [Fitur Kalender Akademik](#fitur-kalender-akademik)
9. [Routing & Middleware](#routing--middleware)

---

## 1. ARSITEKTUR SISTEM TU

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
│ Middleware  │ (auth, role:tu)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Controller  │ (TUController, SiswaController, dll)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│   Model     │ (Siswa, Guru, Jadwal, Event)
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

---

## 2. DATABASE STRUCTURE

### 2.1 Tabel `siswas`

```sql
CREATE TABLE siswas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nisn VARCHAR(255) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(255) NOT NULL,
    tempat_lahir VARCHAR(255) NULL,
    tanggal_lahir DATE NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    agama VARCHAR(50) NULL,
    alamat TEXT NULL,
    no_hp VARCHAR(20) NULL,
    kelas VARCHAR(10) NOT NULL,
    tahun_masuk VARCHAR(10) NULL,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    nama_ayah VARCHAR(255) NULL,
    pekerjaan_ayah VARCHAR(255) NULL,
    nama_ibu VARCHAR(255) NULL,
    pekerjaan_ibu VARCHAR(255) NULL,
    no_hp_ortu VARCHAR(20) NULL,
    foto VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 2.2 Tabel `jadwals`

```sql
CREATE TABLE jadwals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kelas VARCHAR(10) NOT NULL,
    hari VARCHAR(20) NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    mata_pelajaran VARCHAR(255) NOT NULL,
    guru_id BIGINT UNSIGNED NOT NULL,
    ruangan VARCHAR(50) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (guru_id) REFERENCES gurus(id) ON DELETE CASCADE
);
```

### 2.3 Tabel `events`

```sql
CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    kategori VARCHAR(50) NULL,
    warna VARCHAR(20) NULL,
    foto VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## 3. AUTHENTICATION & LOGIN

### 3.1 Login untuk TU

**File:** `app/Http/Controllers/AuthController.php`

```php
public function login(Request $request)
{
    // Validasi
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required|in:guru,tu,kepala_sekolah',
    ]);

    // Credentials
    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
        'role' => $request->role,
    ];

    // Attempt login
    if (Auth::attempt($credentials, $request->remember)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Redirect untuk TU
        if ($user->role === 'tu') {
            return redirect()->route('tu.dashboard');
        }

        // ... role lainnya
    }

    return back()->with('error', 'Email atau password salah');
}
```

---

## 4. DASHBOARD TU

### 4.1 TUController - Dashboard

**File:** `app/Http/Controllers/TUController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Jadwal;

class TUController extends Controller
{
    /**
     * Tampilkan dashboard TU
     */
    public function dashboard()
    {
        // Hitung statistik
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $totalGuru = Guru::where('status', 'aktif')->count();
        $totalJadwal = Jadwal::count();

        // Siswa per kelas
        $siswaPerKelas = Siswa::where('status', 'aktif')
            ->selectRaw('kelas, COUNT(*) as total')
            ->groupBy('kelas')
            ->get();

        return view('tu.dashboard', [
            'totalSiswa' => $totalSiswa,
            'totalGuru' => $totalGuru,
            'totalJadwal' => $totalJadwal,
            'siswaPerKelas' => $siswaPerKelas,
        ]);
    }
}
```

---

## 5. FITUR MANAJEMEN SISWA

### 5.1 Model Siswa

**File:** `app/Models/Siswa.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_hp',
        'kelas',
        'tahun_masuk',
        'status',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'no_hp_ortu',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Scope untuk siswa aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk filter by kelas
     */
    public function scopeKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }
}
```

### 5.2 SiswaController - CRUD

**File:** `app/Http/Controllers/SiswaController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa
     */
    public function index(Request $request)
    {
        $query = Siswa::query();

        // Filter by kelas
        if ($request->has('kelas') && $request->kelas != '') {
            $query->where('kelas', $request->kelas);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nisn', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Paginate
        $siswas = $query->orderBy('nama_lengkap', 'asc')->paginate(20);

        return view('tu.siswa.index', [
            'siswas' => $siswas,
        ]);
    }

    /**
     * Tampilkan form create
     */
    public function create()
    {
        return view('tu.siswa.create');
    }

    /**
     * Simpan siswa baru
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nisn' => 'required|string|max:255|unique:siswas,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'kelas' => 'required|string|max:10',
            'tahun_masuk' => 'nullable|string|max:10',
            'status' => 'required|in:aktif,nonaktif',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'no_hp_ortu' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('siswa/foto', 'public');
        }

        // Simpan siswa
        $siswa = Siswa::create($validated);

        return redirect()->route('tu.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('tu.siswa.edit', ['siswa' => $siswa]);
    }

    /**
     * Update siswa
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        // Validasi (NISN unique kecuali untuk siswa ini)
        $validated = $request->validate([
            'nisn' => 'required|string|max:255|unique:siswas,nisn,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            // ... field lainnya sama seperti store
            'foto' => 'nullable|image|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $validated['foto'] = $request->file('foto')
                ->store('siswa/foto', 'public');
        }

        // Update siswa
        $siswa->update($validated);

        return redirect()->route('tu.siswa.index')
            ->with('success', 'Siswa berhasil diupdate!');
    }

    /**
     * Hapus siswa
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus foto jika ada
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        // Hapus siswa
        $siswa->delete();

        return redirect()->route('tu.siswa.index')
            ->with('success', 'Siswa berhasil dihapus!');
    }

    /**
     * Import siswa dari Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120',
        ]);

        try {
            // Import menggunakan Laravel Excel
            Excel::import(new SiswaImport, $request->file('file'));

            return redirect()->route('tu.siswa.index')
                ->with('success', 'Siswa berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Export siswa ke Excel
     */
    public function export()
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }
}
```

### 5.3 View Index Siswa

**File:** `resources/views/tu/siswa/index.blade.php`

```blade
@extends('layouts.tu')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Manajemen Siswa</h2>

    {{-- Filter & Search --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tu.siswa.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <select name="kelas" class="form-control">
                            <option value="">Semua Kelas</option>
                            <option value="VII" {{ request('kelas') == 'VII' ? 'selected' : '' }}>Kelas 7</option>
                            <option value="VIII" {{ request('kelas') == 'VIII' ? 'selected' : '' }}>Kelas 8</option>
                            <option value="IX" {{ request('kelas') == 'IX' ? 'selected' : '' }}>Kelas 9</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari NISN atau Nama..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-3">
        <a href="{{ route('tu.siswa.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Tambah Siswa
        </a>
        <a href="{{ route('tu.siswa.import') }}" class="btn btn-info">
            <i class="fas fa-file-import me-2"></i>Import Excel
        </a>
        <a href="{{ route('tu.siswa.export') }}" class="btn btn-warning">
            <i class="fas fa-file-export me-2"></i>Export Excel
        </a>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel Siswa --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                            <tr>
                                <td>{{ $siswas->firstItem() + $index }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama_lengkap }}</td>
                                <td>{{ $siswa->kelas }}</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>
                                    <span class="badge {{ $siswa->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($siswa->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('tu.siswa.edit', $siswa->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tu.siswa.destroy', $siswa->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data siswa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $siswas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
```

---

## 6. FITUR MANAJEMEN GURU

### 6.1 GuruController (untuk TU)

**File:** `app/Http/Controllers/TU/GuruController.php`

```php
<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Tampilkan daftar guru
     */
    public function index()
    {
        $gurus = Guru::with('user')->orderBy('created_at', 'desc')->get();
        return view('tu.guru.index', ['gurus' => $gurus]);
    }

    /**
     * Tampilkan form create
     */
    public function create()
    {
        return view('tu.guru.create');
    }

    /**
     * Simpan guru baru
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'biodata' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // 1. Buat user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru',
        ]);

        // 2. Handle file upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru/foto', 'public');
        }

        // 3. Buat guru
        $guru = Guru::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'kontak' => $validated['kontak'],
            'biodata' => $validated['biodata'],
            'foto' => $fotoPath,
            'status' => $validated['status'],
        ]);

        return redirect()->route('tu.guru.index')
            ->with('success', 'Guru berhasil ditambahkan!');
    }

    /**
     * Reset password guru
     */
    public function resetPassword(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Update password
        $guru->user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('tu.guru.index')
            ->with('success', 'Password guru berhasil direset!');
    }
}
```

---

## 7. FITUR JADWAL PELAJARAN

### 7.1 Model Jadwal

**File:** `app/Models/Jadwal.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'kelas',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'mata_pelajaran',
        'guru_id',
        'ruangan',
    ];

    /**
     * Relasi ke Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Scope untuk filter by kelas
     */
    public function scopeKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    /**
     * Scope untuk filter by hari
     */
    public function scopeHari($query, $hari)
    {
        return $query->where('hari', $hari);
    }
}
```

### 7.2 JadwalController

**File:** `app/Http/Controllers/JadwalController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Guru;

class JadwalController extends Controller
{
    /**
     * Tampilkan jadwal
     */
    public function index(Request $request)
    {
        $kelas = $request->query('kelas', 'VII');
        
        // Ambil jadwal per hari
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jadwalPerHari = [];

        foreach ($hariList as $hari) {
            $jadwalPerHari[$hari] = Jadwal::with('guru.user')
                ->where('kelas', $kelas)
                ->where('hari', $hari)
                ->orderBy('jam_mulai', 'asc')
                ->get();
        }

        return view('tu.jadwal.index', [
            'kelas' => $kelas,
            'jadwalPerHari' => $jadwalPerHari,
        ]);
    }

    /**
     * Simpan jadwal baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|string|max:10',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'mata_pelajaran' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
            'ruangan' => 'nullable|string|max:50',
        ]);

        Jadwal::create($validated);

        return redirect()->route('tu.jadwal.index', ['kelas' => $validated['kelas']])
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }
}
```

---

## 8. FITUR KALENDER AKADEMIK

### 8.1 Model Event

**File:** `app/Models/Event.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori',
        'warna',
        'foto',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
}
```

### 8.2 EventController

**File:** `app/Http/Controllers/EventController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Tampilkan kalender
     */
    public function index()
    {
        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->judul,
                'start' => $event->tanggal_mulai->format('Y-m-d'),
                'end' => $event->tanggal_selesai->format('Y-m-d'),
                'backgroundColor' => $event->warna ?? '#3788d8',
            ];
        });

        return view('tu.kalender.index', ['events' => $events]);
    }

    /**
     * Simpan event baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kategori' => 'nullable|string|max:50',
            'warna' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('events', 'public');
        }

        Event::create($validated);

        return redirect()->route('tu.kalender.index')
            ->with('success', 'Event berhasil ditambahkan!');
    }
}
```

---

## 9. ROUTING & MIDDLEWARE

### 9.1 Routes untuk TU

**File:** `routes/web.php`

```php
// ===== TENAGA USAHA ROUTES =====
Route::middleware(['auth', 'role:tu'])
    ->prefix('tu')
    ->name('tu.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [TUController::class, 'dashboard'])
            ->name('dashboard');
        
        // Manajemen Siswa
        Route::resource('siswa', SiswaController::class);
        Route::post('/siswa/import', [SiswaController::class, 'import'])
            ->name('siswa.import');
        Route::get('/siswa/export', [SiswaController::class, 'export'])
            ->name('siswa.export');
        
        // Manajemen Guru
        Route::resource('guru', 'TU\GuruController');
        Route::post('/guru/{id}/reset-password', ['TU\GuruController', 'resetPassword'])
            ->name('guru.reset-password');
        
        // Jadwal Pelajaran
        Route::resource('jadwal', JadwalController::class);
        
        // Kalender Akademik
        Route::resource('kalender', EventController::class);
        
        // Surat Menyurat
        Route::resource('surat', SuratController::class);
        
        // Pengumuman
        Route::resource('pengumuman', PengumumanController::class);
    });
```

---

## 📝 KESIMPULAN

Sistem Tenaga Usaha di TMS NURANI memiliki fitur:

1. **Manajemen Siswa** - CRUD siswa, import/export Excel
2. **Manajemen Guru** - CRUD guru, reset password
3. **Jadwal Pelajaran** - CRUD jadwal per kelas
4. **Kalender Akademik** - CRUD event kalender
5. **Surat Menyurat** - CRUD surat masuk/keluar
6. **Pengumuman** - CRUD pengumuman

**Pola yang Digunakan:**
- **Resource Controller** untuk CRUD standar
- **Scope** di Model untuk filter data
- **Validation** di Controller untuk keamanan
- **File Upload** dengan Storage facade
- **Pagination** untuk data banyak

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
