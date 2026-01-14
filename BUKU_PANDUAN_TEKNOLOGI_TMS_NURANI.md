# 📚 BUKU PANDUAN: TEKNOLOGI TMS NURANI
## Penjelasan Lengkap Framework, Bahasa, dan Arsitektur

---

## 📖 DAFTAR ISI

1. [Pengenalan Teknologi](#pengenalan-teknologi)
2. [Backend: Laravel 11 (PHP Framework)](#backend-laravel-11)
3. [Frontend: Blade + HTML + CSS + JavaScript](#frontend)
4. [Database: MySQL](#database-mysql)
5. [Arsitektur: MVC (Model-View-Controller)](#arsitektur-mvc)
6. [Cara Kerja Sistem Secara Keseluruhan](#cara-kerja-sistem)
7. [Contoh Implementasi di TMS NURANI](#contoh-implementasi)

---

## 1. PENGENALAN TEKNOLOGI

### 1.1 Apa itu TMS NURANI?

**TMS NURANI** adalah sistem manajemen sekolah berbasis web yang dibangun dengan teknologi modern.

### 1.2 Stack Teknologi yang Digunakan

```
┌─────────────────────────────────────────┐
│         TEKNOLOGI TMS NURANI            │
├─────────────────────────────────────────┤
│  Backend:    Laravel 11 (PHP)           │
│  Frontend:   Blade + HTML + CSS + JS    │
│  Database:   MySQL                      │
│  Arsitektur: MVC                        │
│  Server:     Apache (XAMPP)             │
└─────────────────────────────────────────┘
```

---

## 2. BACKEND: LARAVEL 11 (PHP FRAMEWORK)

### 2.1 Apa itu Backend?

**Backend** adalah bagian sistem yang **tidak terlihat** oleh user, tapi **menjalankan semua proses**.

**Analogi Sederhana:**
```
Restoran:
├── Frontend = Ruang makan (yang dilihat customer)
└── Backend  = Dapur (tempat masak, tidak terlihat customer)
```

**Tugas Backend:**
- ✅ Memproses data dari user
- ✅ Berkomunikasi dengan database
- ✅ Menjalankan logika bisnis
- ✅ Mengatur keamanan (login, authorization)
- ✅ Validasi input

---

### 2.2 Apa itu Laravel?

**Laravel** adalah **framework PHP** yang memudahkan pembuatan website.

#### **Framework vs Tanpa Framework**

**Tanpa Framework (PHP Murni):**
```php
// Koneksi database manual
$conn = mysqli_connect("localhost", "root", "", "nurani");

// Query manual
$query = "SELECT * FROM siswas WHERE kelas = 'VII'";
$result = mysqli_query($conn, $query);

// Loop manual
while($row = mysqli_fetch_assoc($result)) {
    echo $row['nama_lengkap'];
}

// Close connection
mysqli_close($conn);
```

**Dengan Framework (Laravel):**
```php
// Langsung pakai Model (sudah auto-connect)
$siswas = Siswa::where('kelas', 'VII')->get();

// Loop dengan Eloquent
foreach($siswas as $siswa) {
    echo $siswa->nama_lengkap;
}
```

**Lebih mudah, lebih aman, lebih cepat!**

---

### 2.3 Kenapa Pakai Laravel?

#### **A. MVC Architecture (Terstruktur)**

Laravel menggunakan pola **MVC** yang memisahkan kode:

```
┌─────────────────────────────────────┐
│  Model (app/Models/)                │
│  • Representasi tabel database      │
│  • Query data                       │
│  • Relasi antar tabel               │
├─────────────────────────────────────┤
│  View (resources/views/)            │
│  • Tampilan HTML                    │
│  • Yang dilihat user                │
├─────────────────────────────────────┤
│  Controller (app/Http/Controllers/) │
│  • Otak sistem                      │
│  • Proses logic                     │
│  • Hubungkan Model & View           │
└─────────────────────────────────────┘
```

**Contoh di TMS NURANI:**

**Model** (`app/Models/Siswa.php`):
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Nama tabel (otomatis: siswas)
    protected $table = 'siswas';
    
    // Field yang bisa diisi
    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'kelas',
        'status',
    ];
    
    // Scope untuk filter siswa aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
```

**Controller** (`app/Http/Controllers/SiswaController.php`):
```php
<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // Tampilkan daftar siswa
    public function index()
    {
        // Ambil data dari Model
        $siswas = Siswa::aktif()->get();
        
        // Kirim ke View
        return view('tu.siswa.index', [
            'siswas' => $siswas
        ]);
    }
    
    // Simpan siswa baru
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nisn' => 'required|unique:siswas',
            'nama_lengkap' => 'required',
            'kelas' => 'required',
        ]);
        
        // Simpan ke database
        Siswa::create($validated);
        
        // Redirect dengan pesan
        return redirect()->route('tu.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }
}
```

**View** (`resources/views/tu/siswa/index.blade.php`):
```blade
<h1>Daftar Siswa</h1>

<table class="table">
    <thead>
        <tr>
            <th>NISN</th>
            <th>Nama</th>
            <th>Kelas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswas as $siswa)
            <tr>
                <td>{{ $siswa->nisn }}</td>
                <td>{{ $siswa->nama_lengkap }}</td>
                <td>{{ $siswa->kelas }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
```

---

#### **B. Eloquent ORM (Query Database Mudah)**

**ORM** = Object-Relational Mapping

**Mengubah tabel database jadi object PHP.**

**Contoh Query:**

```php
// 1. Ambil semua data
$siswas = Siswa::all();

// 2. Filter by kelas
$siswas = Siswa::where('kelas', 'VII')->get();

// 3. Filter multiple
$siswas = Siswa::where('kelas', 'VII')
               ->where('status', 'aktif')
               ->get();

// 4. Search
$siswas = Siswa::where('nama_lengkap', 'like', '%Ahmad%')->get();

// 5. Order by
$siswas = Siswa::orderBy('nama_lengkap', 'asc')->get();

// 6. Pagination
$siswas = Siswa::paginate(20);

// 7. Count
$total = Siswa::count();

// 8. Average
$rataRata = Siswa::avg('nilai');

// 9. Relasi
$rpp = Rpp::with('guru.user')->find(1);
echo $rpp->guru->user->name; // Nama guru
```

---

#### **C. Routing (Atur URL)**

**File:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;

// Route GET (Tampilkan halaman)
Route::get('/siswa', [SiswaController::class, 'index'])
    ->name('tu.siswa.index');

// Route POST (Submit form)
Route::post('/siswa', [SiswaController::class, 'store'])
    ->name('tu.siswa.store');

// Route dengan parameter
Route::get('/siswa/{id}', [SiswaController::class, 'show'])
    ->name('tu.siswa.show');

// Route dengan middleware (proteksi)
Route::middleware(['auth', 'role:tu'])->group(function () {
    Route::resource('siswa', SiswaController::class);
});
```

**Penjelasan:**
- `Route::get()` → HTTP GET (untuk tampilkan halaman)
- `Route::post()` → HTTP POST (untuk submit form)
- `->name()` → Nama route (untuk generate URL)
- `->middleware()` → Proteksi akses

---

#### **D. Middleware (Proteksi Akses)**

**Middleware** = Penjaga pintu yang cek hak akses.

**File:** `app/Http/Middleware/CheckRole.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Cek apakah role user sesuai
        if (Auth::user()->role !== $role) {
            abort(403, 'Akses ditolak');
        }
        
        // Lanjutkan request
        return $next($request);
    }
}
```

**Cara Pakai:**
```php
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/rpp', [RppController::class, 'index']);
});
```

**Artinya:**
- Harus login dulu (`auth`)
- Role harus `guru` (`role:guru`)
- Kalau tidak, tidak bisa akses!

---

#### **E. Validation (Validasi Input)**

```php
public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'nisn' => 'required|unique:siswas,nisn',
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|email',
        'tanggal_lahir' => 'required|date',
        'foto' => 'nullable|image|max:2048',
    ]);
    
    // Jika validasi gagal, otomatis redirect back dengan error
    // Jika sukses, lanjut ke sini
    
    Siswa::create($validated);
}
```

**Aturan Validasi:**
- `required` → Harus diisi
- `unique:siswas,nisn` → Harus unik di tabel siswas kolom nisn
- `string` → Harus tipe string
- `max:255` → Maksimal 255 karakter
- `email` → Harus format email
- `date` → Harus format tanggal
- `image` → Harus file gambar
- `max:2048` → Maksimal 2MB (2048 KB)

---

### 2.4 Versi Laravel yang Digunakan

**Laravel 11** (Rilis Maret 2024)

**Fitur Baru:**
- ✅ Struktur folder lebih sederhana
- ✅ Performa lebih cepat
- ✅ Middleware lebih mudah
- ✅ Support PHP 8.2+
- ✅ Eloquent lebih powerful

---

## 3. FRONTEND: BLADE + HTML + CSS + JAVASCRIPT

### 3.1 Apa itu Frontend?

**Frontend** adalah bagian sistem yang **dilihat dan digunakan** oleh user.

**Analogi:**
```
Restoran:
├── Frontend = Ruang makan, menu, kasir (yang dilihat customer)
└── Backend  = Dapur (tidak terlihat)
```

---

### 3.2 Blade Template Engine

**Blade** adalah template engine bawaan Laravel.

#### **Keuntungan Blade:**

✅ **Syntax Lebih Sederhana**

**PHP Biasa:**
```php
<?php if($siswas->count() > 0): ?>
    <p>Ada <?php echo $siswas->count(); ?> siswa</p>
<?php else: ?>
    <p>Tidak ada siswa</p>
<?php endif; ?>
```

**Blade:**
```blade
@if($siswas->count() > 0)
    <p>Ada {{ $siswas->count() }} siswa</p>
@else
    <p>Tidak ada siswa</p>
@endif
```

---

✅ **Extends Layout (DRY - Don't Repeat Yourself)**

**Layout Master** (`resources/views/layouts/guru.blade.php`):
```blade
<!DOCTYPE html>
<html>
<head>
    <title>TMS NURANI - @yield('title')</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    {{-- Sidebar --}}
    @include('partials.guru-sidebar')
    
    {{-- Main Content --}}
    <div class="content">
        @yield('content')
    </div>
    
    <script src="/js/app.js"></script>
</body>
</html>
```

**Halaman Dashboard** (`resources/views/guru/dashboard.blade.php`):
```blade
@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')
    <h1>Selamat Datang, {{ $guru->user->name }}!</h1>
    
    <div class="stats">
        <p>Total RPP: {{ $rpps->count() }}</p>
    </div>
@endsection
```

**Hasil:** Layout tidak perlu ditulis ulang di setiap halaman!

---

✅ **Auto-Escape XSS (Keamanan)**

```blade
{{-- Auto-escape (aman dari XSS) --}}
<p>{{ $siswa->nama_lengkap }}</p>

{{-- Raw HTML (hati-hati!) --}}
<p>{!! $content !!}</p>
```

---

#### **Directive Blade yang Sering Dipakai:**

```blade
{{-- 1. Tampilkan variabel --}}
{{ $siswa->nama_lengkap }}

{{-- 2. Conditional --}}
@if($siswa->status == 'aktif')
    <span class="badge bg-success">Aktif</span>
@else
    <span class="badge bg-secondary">Nonaktif</span>
@endif

{{-- 3. Loop --}}
@foreach($siswas as $siswa)
    <tr>
        <td>{{ $siswa->nisn }}</td>
        <td>{{ $siswa->nama_lengkap }}</td>
    </tr>
@endforeach

{{-- 4. Loop dengan kondisi kosong --}}
@forelse($siswas as $siswa)
    <p>{{ $siswa->nama_lengkap }}</p>
@empty
    <p>Tidak ada data siswa</p>
@endforelse

{{-- 5. CSRF Token (wajib di form POST) --}}
<form method="POST">
    @csrf
    <input type="text" name="nama">
</form>

{{-- 6. Error validation --}}
@error('nisn')
    <div class="text-danger">{{ $message }}</div>
@enderror

{{-- 7. Session message --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
```

---

### 3.3 HTML5

**HTML** = HyperText Markup Language (Bahasa markup untuk struktur halaman)

**Contoh HTML di TMS NURANI:**

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMS NURANI</title>
</head>
<body>
    {{-- Form Input --}}
    <form action="{{ route('tu.siswa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- Input Text --}}
        <div class="mb-3">
            <label class="form-label">NISN</label>
            <input type="text" class="form-control" name="nisn" required>
        </div>
        
        {{-- Select Dropdown --}}
        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select class="form-control" name="kelas" required>
                <option value="">Pilih Kelas</option>
                <option value="VII">Kelas 7</option>
                <option value="VIII">Kelas 8</option>
                <option value="IX">Kelas 9</option>
            </select>
        </div>
        
        {{-- File Upload --}}
        <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" class="form-control" name="foto" accept="image/*">
        </div>
        
        {{-- Button --}}
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    
    {{-- Table --}}
    <table class="table">
        <thead>
            <tr>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $siswa)
                <tr>
                    <td>{{ $siswa->nisn }}</td>
                    <td>{{ $siswa->nama_lengkap }}</td>
                    <td>{{ $siswa->kelas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
```

---

### 3.4 CSS (Bootstrap 5)

**CSS** = Cascading Style Sheets (Bahasa untuk styling)

**Bootstrap** = Framework CSS yang sudah jadi, tinggal pakai class.

#### **Kenapa Pakai Bootstrap?**

**Tanpa Bootstrap:**
```css
/* Harus tulis CSS manual */
.button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.button:hover {
    background-color: #0056b3;
}
```

**Dengan Bootstrap:**
```html
<!-- Tinggal pakai class -->
<button class="btn btn-primary">Simpan</button>
```

**Lebih cepat, lebih konsisten!**

---

#### **Contoh Bootstrap di TMS NURANI:**

```html
{{-- Grid System (Layout) --}}
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa</h5>
                    <h2>150</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Guru</h5>
                    <h2>25</h2>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Buttons --}}
<button class="btn btn-primary">Simpan</button>
<button class="btn btn-success">Tambah</button>
<button class="btn btn-danger">Hapus</button>
<button class="btn btn-warning">Edit</button>

{{-- Alerts --}}
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> Berhasil!
</div>
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i> Error!
</div>

{{-- Table --}}
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>NISN</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>12345</td>
            <td>Ahmad</td>
        </tr>
    </tbody>
</table>

{{-- Badge --}}
<span class="badge bg-success">Aktif</span>
<span class="badge bg-secondary">Nonaktif</span>

{{-- Modal --}}
<div class="modal fade" id="importModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="file" class="form-control">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</div>
```

---

### 3.5 JavaScript

**JavaScript** = Bahasa pemrograman untuk interaksi di browser.

#### **Contoh JavaScript di TMS NURANI:**

**1. Form Submission dengan Loading**
```javascript
document.querySelector('form').addEventListener('submit', function(e) {
    // Disable button
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
```

**2. Preview Image Sebelum Upload**
```javascript
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" 
                     style="max-width: 200px; max-height: 200px;">
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
```

**3. Select All Checkbox**
```javascript
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="rpp_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
```

**4. Konfirmasi Hapus**
```javascript
function confirmDelete(nama) {
    return confirm(`Yakin ingin menghapus siswa ${nama}?`);
}
```

---

#### **Library JavaScript yang Digunakan:**

**1. Chart.js (Untuk Grafik)**
```javascript
const ctx = document.getElementById('chartNilai').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Kelas 7', 'Kelas 8', 'Kelas 9'],
        datasets: [{
            label: 'Rata-rata Nilai',
            data: [85, 78, 92],
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
```

**2. FullCalendar.js (Untuk Kalender)**
```javascript
const calendarEl = document.getElementById('calendar');
const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: @json($events),
    dateClick: function(info) {
        alert('Tanggal: ' + info.dateStr);
    }
});
calendar.render();
```

---

## 4. DATABASE: MYSQL

### 4.1 Apa itu Database?

**Database** = Tempat penyimpanan data yang terstruktur.

**Analogi:** Database seperti **lemari arsip** yang terorganisir.

---

### 4.2 Struktur Database TMS NURANI

```
Database: nurani
│
├── users (Login semua user)
│   ├── id (Primary Key)
│   ├── name
│   ├── email (Unique)
│   ├── password (Hashed)
│   ├── role (guru/tu/kepala_sekolah)
│   ├── created_at
│   └── updated_at
│
├── gurus (Data detail guru)
│   ├── id (Primary Key)
│   ├── user_id (Foreign Key → users.id)
│   ├── nip
│   ├── mata_pelajaran
│   ├── foto
│   ├── kontak
│   ├── biodata
│   ├── status
│   ├── created_at
│   └── updated_at
│
├── siswas (Data siswa)
│   ├── id (Primary Key)
│   ├── nisn (Unique)
│   ├── nama_lengkap
│   ├── kelas
│   ├── status
│   ├── created_at
│   └── updated_at
│
├── rpps (Data RPP)
│   ├── id (Primary Key)
│   ├── guru_id (Foreign Key → gurus.id)
│   ├── judul
│   ├── mata_pelajaran
│   ├── pertemuan_ke
│   ├── status_approval
│   ├── created_at
│   └── updated_at
│
└── ... (tabel lainnya)
```

---

### 4.3 Relasi Antar Tabel

```
┌──────────┐         ┌──────────┐
│  users   │ 1     1 │  gurus   │
│          │◄────────│          │
│ id (PK)  │         │ user_id  │
└──────────┘         └────┬─────┘
                          │
                          │ 1
                          │
                          │ N
                     ┌────▼─────┐
                     │   rpps   │
                     │          │
                     │ guru_id  │
                     └──────────┘
```

**Penjelasan:**
- **One-to-One:** 1 User → 1 Guru
- **One-to-Many:** 1 Guru → Banyak RPP

---

### 4.4 Contoh Query

**SQL Biasa:**
```sql
SELECT rpps.*, users.name as nama_guru
FROM rpps
JOIN gurus ON rpps.guru_id = gurus.id
JOIN users ON gurus.user_id = users.id
WHERE rpps.status_approval = 'pending';
```

**Laravel Eloquent:**
```php
$rpps = Rpp::with('guru.user')
    ->where('status_approval', 'pending')
    ->get();

foreach($rpps as $rpp) {
    echo $rpp->guru->user->name; // Nama guru
}
```

**Lebih mudah dan readable!**

---

## 5. ARSITEKTUR: MVC (MODEL-VIEW-CONTROLLER)

### 5.1 Apa itu MVC?

**MVC** = Pola desain yang memisahkan aplikasi jadi 3 komponen.

```
┌─────────────────────────────────────────┐
│              USER (Browser)             │
└──────────────┬──────────────────────────┘
               │ HTTP Request
               ▼
┌─────────────────────────────────────────┐
│           CONTROLLER                    │
│  • Terima request                       │
│  • Proses logic                         │
│  • Panggil Model                        │
│  • Return View                          │
└──────┬─────────────────────┬────────────┘
       │                     │
       ▼                     ▼
┌─────────────┐       ┌─────────────┐
│   MODEL     │       │    VIEW     │
│  • Query DB │       │  • Tampilan │
│  • Logic    │       │  • HTML     │
│  • Data     │       │  • CSS/JS   │
└─────────────┘       └─────────────┘
```

---

### 5.2 Contoh Flow MVC

**Skenario:** User ingin lihat daftar siswa

#### **1. User Akses URL**
```
Browser → GET http://localhost/tu/siswa
```

#### **2. Routing**
```php
// routes/web.php
Route::get('/siswa', [SiswaController::class, 'index'])
    ->name('tu.siswa.index');
```

#### **3. Controller**
```php
// app/Http/Controllers/SiswaController.php
public function index()
{
    // Panggil Model
    $siswas = Siswa::all();
    
    // Return View
    return view('tu.siswa.index', ['siswas' => $siswas]);
}
```

#### **4. Model**
```php
// app/Models/Siswa.php
class Siswa extends Model
{
    // Eloquent otomatis query: SELECT * FROM siswas
}
```

#### **5. View**
```blade
{{-- resources/views/tu/siswa/index.blade.php --}}
<table>
    @foreach($siswas as $siswa)
        <tr>
            <td>{{ $siswa->nisn }}</td>
            <td>{{ $siswa->nama_lengkap }}</td>
        </tr>
    @endforeach
</table>
```

#### **6. Response**
```
Controller → View → HTML → Browser
```

---

### 5.3 Keuntungan MVC

✅ **Separation of Concerns**
- Model ngurus database
- View ngurus tampilan
- Controller ngurus logic

✅ **Mudah Maintenance**
- Ubah tampilan? Edit View aja
- Ubah logic? Edit Controller aja
- Ubah struktur data? Edit Model aja

✅ **Reusable**
- Model bisa dipanggil dari banyak Controller
- View bisa dipanggil dari banyak Controller

✅ **Testable**
- Bisa test Model, Controller, View secara terpisah

---

## 6. CARA KERJA SISTEM SECARA KESELURUHAN

### 6.1 Request-Response Cycle

```
1. User buka browser
   ↓
2. Ketik URL: http://localhost/guru/rpp/create
   ↓
3. Browser kirim HTTP Request ke Server
   ↓
4. Apache (XAMPP) terima request
   ↓
5. Laravel routing cek URL
   ↓
6. Middleware cek: Sudah login? Role = guru?
   ↓
7. RppController@create dijalankan
   ↓
8. Controller ambil data dari Model (Guru)
   ↓
9. Model query database MySQL
   ↓
10. Database return data
    ↓
11. Controller kirim data ke View (Blade)
    ↓
12. Blade render HTML
    ↓
13. HTML + CSS + JS dikirim ke Browser
    ↓
14. Browser tampilkan halaman
```

---

### 6.2 Teknologi di Setiap Layer

```
┌─────────────────────────────────────────┐
│         BROWSER (Client)                │
│  • HTML5 (Struktur)                     │
│  • CSS + Bootstrap (Styling)            │
│  • JavaScript (Interaksi)               │
└──────────────┬──────────────────────────┘
               │ HTTP Request/Response
               ▼
┌─────────────────────────────────────────┐
│      WEB SERVER (Apache - XAMPP)        │
│  • Terima request                       │
│  • Forward ke Laravel                   │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      LARAVEL FRAMEWORK (PHP)            │
│  • Routing (web.php)                    │
│  • Middleware (auth, role)              │
│  • Controller (Logic)                   │
│  • Model (Eloquent ORM)                 │
│  • View (Blade Template)                │
└──────────────┬──────────────────────────┘
               │ SQL Query
               ▼
┌─────────────────────────────────────────┐
│      DATABASE (MySQL)                   │
│  • Simpan data                          │
│  • Return data                          │
└─────────────────────────────────────────┘
```

---

## 7. CONTOH IMPLEMENTASI DI TMS NURANI

### 7.1 Fitur Tambah Siswa (Full Stack)

#### **A. Database (MySQL)**
```sql
CREATE TABLE siswas (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nisn VARCHAR(255) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### **B. Model (Laravel)**
```php
// app/Models/Siswa.php
class Siswa extends Model
{
    protected $fillable = ['nisn', 'nama_lengkap', 'kelas'];
}
```

#### **C. Controller (Laravel)**
```php
// app/Http/Controllers/SiswaController.php
public function store(Request $request)
{
    $validated = $request->validate([
        'nisn' => 'required|unique:siswas',
        'nama_lengkap' => 'required',
        'kelas' => 'required',
    ]);
    
    Siswa::create($validated);
    
    return redirect()->route('tu.siswa.index')
        ->with('success', 'Siswa berhasil ditambahkan!');
}
```

#### **D. View (Blade + HTML + Bootstrap)**
```blade
{{-- resources/views/tu/siswa/create.blade.php --}}
<form action="{{ route('tu.siswa.store') }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label class="form-label">NISN</label>
        <input type="text" class="form-control" name="nisn" required>
        @error('nisn')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama_lengkap" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Kelas</label>
        <select class="form-control" name="kelas" required>
            <option value="">Pilih Kelas</option>
            <option value="VII">Kelas 7</option>
            <option value="VIII">Kelas 8</option>
            <option value="IX">Kelas 9</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
```

#### **E. JavaScript (Interaksi)**
```javascript
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = document.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
```

---

## 📝 KESIMPULAN

**TMS NURANI menggunakan:**

| Komponen | Teknologi | Fungsi |
|----------|-----------|--------|
| **Backend** | Laravel 11 (PHP) | Logic, Database, Security |
| **Frontend** | Blade + HTML + CSS + JS | Tampilan & Interaksi |
| **Database** | MySQL | Penyimpanan Data |
| **Arsitektur** | MVC | Struktur Kode Terorganisir |

**Semua teknologi ini bekerja sama untuk membuat sistem yang:**
- ✅ **Aman** (Authentication, Authorization, Validation)
- ✅ **Cepat** (Eloquent ORM, Caching)
- ✅ **Mudah Maintenance** (MVC, Clean Code)
- ✅ **Scalable** (Bisa dikembangkan lebih besar)

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
