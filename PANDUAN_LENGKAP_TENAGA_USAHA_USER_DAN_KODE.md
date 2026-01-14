# 📚 PANDUAN LENGKAP FITUR TENAGA USAHA (USER + KODE)
## TMS NURANI - MTs Nurul Aiman

> **Catatan:** File ini menggabungkan panduan pengguna dengan penjelasan kode teknis untuk setiap fitur Tenaga Usaha

---

## 📖 DAFTAR ISI

1. [Fitur Manajemen Siswa](#fitur-manajemen-siswa)
2. [Fitur Manajemen Guru](#fitur-manajemen-guru)
3. [Fitur Jadwal Pelajaran](#fitur-jadwal-pelajaran)
4. [Fitur Kalender Akademik](#fitur-kalender-akademik)
5. [Fitur Surat Menyurat](#fitur-surat-menyurat)

---

## 1. FITUR MANAJEMEN SISWA

### 📱 CARA PAKAI (Untuk Tenaga Usaha)

**Apa yang Bisa Dilakukan:**
1. Lihat daftar siswa
2. Tambah siswa baru
3. Edit data siswa
4. Hapus siswa
5. Import siswa dari Excel
6. Export siswa ke Excel

**Langkah-langkah Tambah Siswa:**
1. Klik menu "Siswa" di sidebar
2. Klik tombol "Tambah Siswa"
3. Isi form (NISN, Nama, Kelas, dll)
4. Upload foto (opsional)
5. Klik "Simpan Siswa"

---

### 💻 PENJELASAN KODE

#### **A. Database Structure**

```sql
CREATE TABLE siswas (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nisn VARCHAR(255) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(255) NOT NULL,
    tempat_lahir VARCHAR(255),
    tanggal_lahir DATE,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    agama VARCHAR(50),
    alamat TEXT,
    no_hp VARCHAR(20),
    kelas VARCHAR(10) NOT NULL,
    tahun_masuk VARCHAR(10),
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    nama_ayah VARCHAR(255),
    pekerjaan_ayah VARCHAR(255),
    nama_ibu VARCHAR(255),
    pekerjaan_ibu VARCHAR(255),
    no_hp_ortu VARCHAR(20),
    foto VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Penjelasan:**
- `nisn` → UNIQUE (tidak boleh duplikat)
- `jenis_kelamin` → ENUM (hanya bisa Laki-laki atau Perempuan)
- `status` → DEFAULT 'aktif' (otomatis aktif saat dibuat)
- `foto` → Path file foto siswa

---

#### **B. Model Siswa**

**File:** `app/Models/Siswa.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Field yang bisa diisi mass assignment
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

    // Cast tanggal_lahir ke tipe date
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Scope untuk filter siswa aktif
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

**Penjelasan:**
- `$fillable` → Field yang boleh diisi via `Siswa::create()`
- `$casts` → Convert tanggal_lahir dari string ke Carbon (object tanggal)
- `scopeAktif()` → Query scope untuk filter siswa aktif
  - Cara pakai: `Siswa::aktif()->get()`
- `scopeKelas()` → Query scope untuk filter by kelas
  - Cara pakai: `Siswa::kelas('VII')->get()`

---

#### **C. Controller - Index (Daftar Siswa)**

**File:** `app/Http/Controllers/SiswaController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa dengan filter & search
     */
    public function index(Request $request)
    {
        // 1. Mulai query
        $query = Siswa::query();

        // 2. Filter by kelas
        if ($request->has('kelas') && $request->kelas != '') {
            $query->where('kelas', $request->kelas);
        }

        // 3. Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 4. Search by NISN atau Nama
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nisn', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // 5. Paginate (20 data per halaman)
        $siswas = $query->orderBy('nama_lengkap', 'asc')->paginate(20);

        // 6. Return view
        return view('tu.siswa.index', [
            'siswas' => $siswas,
        ]);
    }
}
```

**Penjelasan:**
- `Siswa::query()` → Mulai query builder
- `$request->has('kelas')` → Cek apakah parameter 'kelas' ada di URL
- `$request->kelas != ''` → Cek apakah parameter tidak kosong
- `->where('kelas', $request->kelas)` → Filter berdasarkan kelas
- `->where(function($q) use ($search) { ... })` → Nested where (untuk OR)
- `'like', "%{$search}%"` → Pencarian partial (mengandung kata)
- `->orWhere()` → Kondisi OR (NISN ATAU Nama)
- `->orderBy('nama_lengkap', 'asc')` → Urutkan A-Z
- `->paginate(20)` → Pagination 20 data per halaman

---

#### **D. Controller - Store (Simpan Siswa Baru)**

```php
/**
 * Simpan siswa baru
 */
public function store(Request $request)
{
    // 1. Validasi input
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

    // 2. Handle file upload
    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')
            ->store('siswa/foto', 'public');
    }

    // 3. Simpan siswa
    $siswa = Siswa::create($validated);

    // 4. Redirect dengan pesan sukses
    return redirect()->route('tu.siswa.index')
        ->with('success', 'Siswa berhasil ditambahkan!');
}
```

**Penjelasan:**
- `'required'` → Field harus diisi
- `'nullable'` → Field boleh kosong
- `'unique:siswas,nisn'` → NISN harus unik di tabel siswas
- `'in:Laki-laki,Perempuan'` → Hanya boleh salah satu dari 2 nilai
- `'image|max:2048'` → File harus gambar, max 2MB (2048 KB)
- `$request->hasFile('foto')` → Cek apakah ada file yang diupload
- `->store('siswa/foto', 'public')` → Simpan ke `storage/app/public/siswa/foto/`
- `Siswa::create($validated)` → Simpan ke database
- `->with('success', '...')` → Set flash message

---

#### **E. Controller - Update (Edit Siswa)**

```php
/**
 * Update siswa
 */
public function update(Request $request, $id)
{
    // 1. Cari siswa
    $siswa = Siswa::findOrFail($id);

    // 2. Validasi (NISN unique kecuali untuk siswa ini)
    $validated = $request->validate([
        'nisn' => 'required|string|max:255|unique:siswas,nisn,' . $id,
        'nama_lengkap' => 'required|string|max:255',
        // ... field lainnya sama seperti store
        'foto' => 'nullable|image|max:2048',
    ]);

    // 3. Handle file upload
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $validated['foto'] = $request->file('foto')
            ->store('siswa/foto', 'public');
    }

    // 4. Update siswa
    $siswa->update($validated);

    // 5. Redirect dengan pesan sukses
    return redirect()->route('tu.siswa.index')
        ->with('success', 'Siswa berhasil diupdate!');
}
```

**Penjelasan:**
- `Siswa::findOrFail($id)` → Cari siswa atau throw 404
- `'unique:siswas,nisn,' . $id` → NISN harus unik, kecuali untuk siswa dengan ID ini
- `Storage::disk('public')->delete()` → Hapus file lama
- `$siswa->update($validated)` → Update data di database

---

#### **F. Controller - Destroy (Hapus Siswa)**

```php
/**
 * Hapus siswa
 */
public function destroy($id)
{
    // 1. Cari siswa
    $siswa = Siswa::findOrFail($id);

    // 2. Hapus foto jika ada
    if ($siswa->foto) {
        Storage::disk('public')->delete($siswa->foto);
    }

    // 3. Hapus siswa dari database
    $siswa->delete();

    // 4. Redirect dengan pesan sukses
    return redirect()->route('tu.siswa.index')
        ->with('success', 'Siswa berhasil dihapus!');
}
```

**Penjelasan:**
- `$siswa->delete()` → Hapus data dari database
- Hapus foto dulu sebelum hapus data siswa

---

#### **G. Controller - Import Excel**

```php
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

/**
 * Import siswa dari Excel
 */
public function import(Request $request)
{
    // 1. Validasi file
    $request->validate([
        'file' => 'required|mimes:xlsx,xls|max:5120',
    ]);

    try {
        // 2. Import menggunakan Laravel Excel
        Excel::import(new SiswaImport, $request->file('file'));

        // 3. Redirect dengan pesan sukses
        return redirect()->route('tu.siswa.index')
            ->with('success', 'Siswa berhasil diimport!');
    } catch (\Exception $e) {
        // 4. Jika error, redirect dengan pesan error
        return redirect()->back()
            ->with('error', 'Import gagal: ' . $e->getMessage());
    }
}
```

**Penjelasan:**
- `'mimes:xlsx,xls'` → File harus Excel
- `'max:5120'` → Max 5MB (5120 KB)
- `Excel::import()` → Import menggunakan package Laravel Excel
- `try-catch` → Tangkap error jika import gagal

---

#### **H. View - Index Siswa**

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
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fas fa-file-import me-2"></i>Import Excel
        </button>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
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

{{-- Modal Import --}}
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tu.siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Siswa dari Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Upload File Excel</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                        <small class="text-muted">Format: XLSX atau XLS (Max: 5MB)</small>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Download template Excel terlebih dahulu untuk format yang benar.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
```

**Penjelasan:**
- `{{ request('kelas') == 'VII' ? 'selected' : '' }}` → Set selected jika filter aktif
- `{{ request('search') }}` → Isi ulang search box
- `@forelse ... @empty ... @endforelse` → Loop dengan kondisi jika kosong
- `{{ $siswas->firstItem() + $index }}` → Nomor urut dengan pagination
- `@method('DELETE')` → Spoofing method DELETE (HTML form hanya support GET/POST)
- `onsubmit="return confirm('...')"` → Konfirmasi sebelum hapus
- `{{ $siswas->links() }}` → Tampilkan pagination links
- `data-bs-toggle="modal"` → Trigger modal Bootstrap
- `enctype="multipart/form-data"` → Wajib untuk file upload

---

## 2. FITUR MANAJEMEN GURU

### 📱 CARA PAKAI (Untuk Tenaga Usaha)

**Apa yang Bisa Dilakukan:**
1. Lihat daftar guru
2. Tambah guru baru (sekaligus buat akun login)
3. Edit data guru
4. Hapus guru
5. Reset password guru

**Langkah-langkah Tambah Guru:**
1. Klik menu "Guru" di sidebar
2. Klik tombol "Tambah Guru"
3. Isi form (Email, Password, NIP, Nama, Mata Pelajaran)
4. Klik "Simpan Guru"
5. Guru bisa langsung login dengan email & password yang dibuat

---

### 💻 PENJELASAN KODE

#### **A. Controller - Store Guru**

**File:** `app/Http/Controllers/TU/GuruController.php`

```php
<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Simpan guru baru
     */
    public function store(Request $request)
    {
        // 1. Validasi
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

        // 2. Buat user (untuk login)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru',
        ]);

        // 3. Handle file upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru/foto', 'public');
        }

        // 4. Buat guru (data detail)
        $guru = Guru::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'kontak' => $validated['kontak'],
            'biodata' => $validated['biodata'],
            'foto' => $fotoPath,
            'status' => $validated['status'],
        ]);

        // 5. Redirect dengan pesan sukses
        return redirect()->route('tu.guru.index')
            ->with('success', 'Guru berhasil ditambahkan! Email: ' . $validated['email']);
    }
}
```

**Penjelasan:**
- `'confirmed'` → Password harus sama dengan password_confirmation
- `Hash::make($password)` → Hash password dengan bcrypt
- `'role' => 'guru'` → Set role sebagai guru
- Buat 2 record: 1 di tabel `users`, 1 di tabel `gurus`
- `user_id` di tabel gurus → Foreign key ke tabel users

---

#### **B. Controller - Reset Password**

```php
/**
 * Reset password guru
 */
public function resetPassword(Request $request, $id)
{
    // 1. Cari guru
    $guru = Guru::findOrFail($id);
    
    // 2. Validasi password baru
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    // 3. Update password di tabel users
    $guru->user->update([
        'password' => Hash::make($request->password),
    ]);

    // 4. Redirect dengan pesan sukses
    return redirect()->route('tu.guru.index')
        ->with('success', 'Password guru berhasil direset!');
}
```

**Penjelasan:**
- `$guru->user` → Akses relasi user dari guru
- `->update()` → Update data user
- Password di-hash lagi sebelum disimpan

---

## 3. FITUR JADWAL PELAJARAN

### 📱 CARA PAKAI (Untuk Tenaga Usaha)

**Apa yang Bisa Dilakukan:**
1. Lihat jadwal per kelas
2. Tambah jadwal baru
3. Edit jadwal
4. Hapus jadwal
5. Print jadwal

**Langkah-langkah Tambah Jadwal:**
1. Klik menu "Jadwal Pelajaran"
2. Pilih kelas (VII, VIII, atau IX)
3. Klik "Tambah Jadwal"
4. Isi form (Hari, Jam, Mata Pelajaran, Guru, Ruangan)
5. Klik "Simpan Jadwal"

---

### 💻 PENJELASAN KODE

#### **A. Database Structure**

```sql
CREATE TABLE jadwals (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    kelas VARCHAR(10) NOT NULL,
    hari VARCHAR(20) NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    mata_pelajaran VARCHAR(255) NOT NULL,
    guru_id BIGINT NOT NULL,
    ruangan VARCHAR(50),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES gurus(id)
);
```

---

#### **B. Model Jadwal**

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

---

#### **C. Controller - Index Jadwal**

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
     * Tampilkan jadwal per kelas
     */
    public function index(Request $request)
    {
        // 1. Ambil kelas dari query string (default: VII)
        $kelas = $request->query('kelas', 'VII');
        
        // 2. Daftar hari
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        // 3. Ambil jadwal per hari
        $jadwalPerHari = [];
        foreach ($hariList as $hari) {
            $jadwalPerHari[$hari] = Jadwal::with('guru.user')
                ->where('kelas', $kelas)
                ->where('hari', $hari)
                ->orderBy('jam_mulai', 'asc')
                ->get();
        }

        // 4. Return view
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
        // Validasi
        $validated = $request->validate([
            'kelas' => 'required|string|max:10',
            'hari' => 'required|string|max:20',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'mata_pelajaran' => 'required|string|max:255',
            'guru_id' => 'required|exists:gurus,id',
            'ruangan' => 'nullable|string|max:50',
        ]);

        // Simpan
        Jadwal::create($validated);

        return redirect()->route('tu.jadwal.index', ['kelas' => $validated['kelas']])
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }
}
```

**Penjelasan:**
- `$jadwalPerHari[$hari]` → Array dengan key hari
- `Jadwal::with('guru.user')` → Eager load relasi guru dan user
- `'date_format:H:i'` → Format jam (contoh: 07:00)
- `'after:jam_mulai'` → jam_selesai harus setelah jam_mulai
- `'exists:gurus,id'` → guru_id harus ada di tabel gurus

---

## 4. FITUR KALENDER AKADEMIK

### 📱 CARA PAKAI (Untuk Tenaga Usaha)

**Apa yang Bisa Dilakukan:**
1. Lihat kalender dengan event
2. Tambah event baru (libur, ujian, kegiatan)
3. Edit event
4. Hapus event

**Langkah-langkah Tambah Event:**
1. Klik menu "Kalender Akademik"
2. Klik tanggal di kalender atau klik "Tambah Event"
3. Isi form (Judul, Deskripsi, Tanggal Mulai, Tanggal Selesai, Kategori)
4. Upload foto (opsional)
5. Klik "Simpan Event"

---

### 💻 PENJELASAN KODE

#### **A. Database Structure**

```sql
CREATE TABLE events (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    kategori VARCHAR(50),
    warna VARCHAR(20),
    foto VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

#### **B. Model Event**

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

    // Cast tanggal ke Carbon
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
}
```

---

#### **C. Controller - Event**

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
        // Transform data untuk FullCalendar.js
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

**Penjelasan:**
- `->map(function($event) { ... })` → Transform data untuk FullCalendar
- `->format('Y-m-d')` → Format tanggal (contoh: 2026-01-14)
- `$event->warna ?? '#3788d8'` → Null coalescing (jika null, pakai default)
- `'after_or_equal:tanggal_mulai'` → Tanggal selesai >= tanggal mulai

---

## 5. FITUR SURAT MENYURAT

### 📱 CARA PAKAI (Untuk Tenaga Usaha)

**Apa yang Bisa Dilakukan:**
1. Lihat daftar surat (masuk & keluar)
2. Buat surat baru
3. Edit surat
4. Hapus surat
5. Download file surat

**Langkah-langkah Buat Surat:**
1. Klik menu "Surat Menyurat"
2. Klik "Buat Surat"
3. Pilih jenis (Surat Masuk atau Surat Keluar)
4. Isi form (Nomor Surat, Tanggal, Perihal, Pengirim/Penerima, Isi)
5. Upload file surat (PDF/DOC)
6. Klik "Simpan Surat"

---

### 💻 PENJELASAN KODE

#### **A. Database Structure**

```sql
CREATE TABLE surats (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    jenis ENUM('masuk', 'keluar') NOT NULL,
    nomor_surat VARCHAR(255) NOT NULL,
    tanggal_surat DATE NOT NULL,
    perihal VARCHAR(255) NOT NULL,
    pengirim VARCHAR(255),
    penerima VARCHAR(255),
    isi_surat TEXT,
    file_surat VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

#### **B. Controller - Surat**

**File:** `app/Http/Controllers/SuratController.php`

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'jenis' => 'required|in:masuk,keluar',
        'nomor_surat' => 'required|string|max:255',
        'tanggal_surat' => 'required|date',
        'perihal' => 'required|string|max:255',
        'pengirim' => 'nullable|string|max:255',
        'penerima' => 'nullable|string|max:255',
        'isi_surat' => 'nullable|string',
        'file_surat' => 'nullable|mimes:pdf,doc,docx|max:5120',
    ]);

    if ($request->hasFile('file_surat')) {
        $validated['file_surat'] = $request->file('file_surat')
            ->store('surat', 'public');
    }

    Surat::create($validated);

    return redirect()->route('tu.surat.index')
        ->with('success', 'Surat berhasil dibuat!');
}
```

**Penjelasan:**
- `'mimes:pdf,doc,docx'` → File harus PDF atau Word
- `'max:5120'` → Max 5MB

---

## 🔄 ROUTING LENGKAP TENAGA USAHA

**File:** `routes/web.php`

```php
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
    });
```

**Penjelasan:**
- `Route::resource()` → Generate 7 routes (index, create, store, show, edit, update, destroy)

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
