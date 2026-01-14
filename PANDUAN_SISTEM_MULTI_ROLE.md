# 📚 PANDUAN LENGKAP: Membuat Sistem Multi-Role di Laravel

## 🎯 Tujuan Pembelajaran
Setelah membaca panduan ini, Anda akan memahami:
1. Konsep dasar sistem multi-role
2. Struktur database untuk multi-role
3. Authentication & Authorization
4. Routing berdasarkan role
5. Middleware untuk proteksi akses
6. Best practices dalam implementasi

---

## 📖 BAB 1: KONSEP DASAR SISTEM MULTI-ROLE

### 1.1 Apa itu Multi-Role System?

**Multi-Role System** adalah sistem yang memiliki **beberapa jenis pengguna** dengan **hak akses berbeda**.

**Contoh di TMS NURANI:**
- **Guru** → Bisa buat RPP, materi, kuis, presensi
- **Tenaga Usaha (TU)** → Bisa kelola data siswa, guru, jadwal
- **Kepala Sekolah** → Bisa lihat semua data, approve RPP

### 1.2 Komponen Utama

```
┌─────────────────────────────────────────────┐
│         SISTEM MULTI-ROLE                   │
├─────────────────────────────────────────────┤
│                                             │
│  1. DATABASE (Tabel users, gurus, dll)      │
│  2. AUTHENTICATION (Login/Logout)           │
│  3. AUTHORIZATION (Cek hak akses)           │
│  4. ROUTING (URL berbeda per role)          │
│  5. MIDDLEWARE (Proteksi akses)             │
│  6. VIEWS (Tampilan berbeda per role)       │
│                                             │
└─────────────────────────────────────────────┘
```

---

## 📖 BAB 2: STRUKTUR DATABASE

### 2.1 Tabel `users` (Tabel Utama untuk Login)

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

**Penjelasan:**
- `id` → ID unik untuk setiap user
- `name` → Nama lengkap user
- `email` → Email untuk login (harus unique)
- `password` → Password yang sudah di-hash
- `role` → Jenis user (guru/tu/kepala_sekolah)
- `remember_token` → Token untuk "Remember Me"

### 2.2 Tabel `gurus` (Data Detail Guru)

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

**Penjelasan:**
- `user_id` → Foreign key ke tabel `users`
- `nip` → Nomor Induk Pegawai
- `mata_pelajaran` → Mata pelajaran yang diajar
- Relasi: **1 user = 1 guru** (One-to-One)

### 2.3 Relasi Antar Tabel

```
┌──────────────┐         ┌──────────────┐
│    users     │         │    gurus     │
├──────────────┤         ├──────────────┤
│ id (PK)      │◄────────│ user_id (FK) │
│ name         │         │ nip          │
│ email        │         │ mata_pelajaran│
│ password     │         │ foto         │
│ role         │         │ ...          │
└──────────────┘         └──────────────┘
```

**Konsep Penting:**
- Tabel `users` → Untuk **login** (email, password, role)
- Tabel `gurus` → Untuk **data detail** guru (NIP, mata pelajaran, dll)
- **Kenapa dipisah?** Agar lebih fleksibel dan terstruktur

---

## 📖 BAB 3: AUTHENTICATION (Login/Logout)

### 3.1 Migration untuk Tabel Users

**File:** `database/migrations/xxxx_create_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['guru', 'tu', 'kepala_sekolah']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

### 3.2 Model User

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

    // Relasi ke Guru
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    // Helper method untuk cek role
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

### 3.3 Controller untuk Login

**File:** `app/Http/Controllers/AuthController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Guru;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:guru,tu,kepala_sekolah',
        ]);

        // Cek kredensial
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'guru':
                    // Cek apakah data guru ada
                    $guru = Guru::where('user_id', $user->id)->first();
                    if (!$guru) {
                        Auth::logout();
                        return back()->with('error', 'Data guru tidak ditemukan');
                    }
                    return redirect()->route('guru.dashboard');

                case 'tu':
                    return redirect()->route('tu.dashboard');

                case 'kepala_sekolah':
                    return redirect()->route('kepala-sekolah.dashboard');

                default:
                    Auth::logout();
                    return back()->with('error', 'Role tidak valid');
            }
        }

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

**Penjelasan Kode:**

1. **`Auth::attempt($credentials)`**
   - Cek apakah email, password, dan role cocok
   - Jika cocok, user akan login otomatis

2. **`$request->session()->regenerate()`**
   - Regenerate session ID untuk keamanan
   - Mencegah session fixation attack

3. **Switch berdasarkan role**
   - Redirect ke dashboard yang sesuai dengan role
   - Guru → `/guru/dashboard`
   - TU → `/tu/dashboard`
   - Kepala Sekolah → `/kepala-sekolah/dashboard`

---

## 📖 BAB 4: ROUTING BERDASARKAN ROLE

### 4.1 Struktur Route

**File:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TUController;
use App\Http\Controllers\KepalaSekolahController;

// ===== PUBLIC ROUTES =====
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== GURU ROUTES =====
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/rpp', [GuruController::class, 'rpp'])->name('rpp');
    Route::get('/materi', [GuruController::class, 'materi'])->name('materi');
    Route::get('/kuis', [GuruController::class, 'kuis'])->name('kuis');
    // ... route guru lainnya
});

// ===== TENAGA USAHA ROUTES =====
Route::middleware(['auth', 'role:tu'])->prefix('tu')->name('tu.')->group(function () {
    Route::get('/dashboard', [TUController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa', [TUController::class, 'siswa'])->name('siswa');
    Route::get('/guru', [TUController::class, 'guru'])->name('guru');
    Route::get('/jadwal', [TUController::class, 'jadwal'])->name('jadwal');
    // ... route TU lainnya
});

// ===== KEPALA SEKOLAH ROUTES =====
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
    Route::get('/dashboard', [KepalaSekolahController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporan', [KepalaSekolahController::class, 'laporan'])->name('laporan');
    Route::get('/evaluasi', [KepalaSekolahController::class, 'evaluasi'])->name('evaluasi');
    // ... route Kepala Sekolah lainnya
});
```

**Penjelasan:**

1. **`middleware(['auth', 'role:guru'])`**
   - `auth` → User harus login
   - `role:guru` → User harus punya role 'guru'

2. **`prefix('guru')`**
   - Semua route di grup ini akan punya prefix `/guru`
   - Contoh: `/guru/dashboard`, `/guru/rpp`

3. **`name('guru.')`**
   - Semua route name akan punya prefix `guru.`
   - Contoh: `guru.dashboard`, `guru.rpp`

---

## 📖 BAB 5: MIDDLEWARE UNTUK PROTEKSI AKSES

### 5.1 Buat Middleware Role

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
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah role user sesuai
        if (Auth::user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
```

### 5.2 Register Middleware

**File:** `bootstrap/app.php` (Laravel 11) atau `app/Http/Kernel.php` (Laravel 10)

**Laravel 11:**
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
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

**Laravel 10:**
```php
protected $middlewareAliases = [
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

---

## 📖 BAB 6: SEEDER UNTUK DATA AWAL

### 6.1 User Seeder

**File:** `database/seeders/UserSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Kepala Sekolah
        User::create([
            'name' => 'Maman Suparman, A.KS',
            'email' => 'mamansuparmanaks07@gmail.com',
            'password' => Hash::make('AdminKS@2024'),
            'role' => 'kepala_sekolah',
        ]);

        // Tenaga Usaha
        User::create([
            'name' => 'Tenaga Usaha',
            'email' => 'internal.nurulaiman@gmail.com',
            'password' => Hash::make('AdminTU@2024'),
            'role' => 'tu',
        ]);

        // Guru
        $gurus = [
            ['Nurhadi, S.Pd', 'mundarinurhadi@gmail.com', 'Nurhadi2024!'],
            ['Desi Nurfalah', 'desinurfalah24@gmail.com', 'DesyNurfalah2024!'],
            ['Mawar', 'mawarkusuma694@gmail.com', 'Mawar2024!'],
            // ... guru lainnya
        ];

        foreach ($gurus as $guru) {
            User::create([
                'name' => $guru[0],
                'email' => $guru[1],
                'password' => Hash::make($guru[2]),
                'role' => 'guru',
            ]);
        }
    }
}
```

### 6.2 Guru Seeder

**File:** `database/seeders/GuruSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruData = [
            ['mundarinurhadi@gmail.com', 'G001', 'Matematika'],
            ['desinurfalah24@gmail.com', 'G013', 'Bahasa Indonesia'],
            ['mawarkusuma694@gmail.com', 'G014', 'IPA'],
            // ... data guru lainnya
        ];

        foreach ($guruData as $data) {
            $user = User::where('email', $data[0])->first();
            
            if ($user) {
                Guru::create([
                    'user_id' => $user->id,
                    'nip' => $data[1],
                    'mata_pelajaran' => $data[2],
                    'status' => 'aktif',
                ]);
            }
        }
    }
}
```

---

## 📖 BAB 7: VIEWS BERDASARKAN ROLE

### 7.1 Struktur Folder Views

```
resources/views/
├── auth/
│   └── login.blade.php
├── guru/
│   ├── dashboard.blade.php
│   ├── rpp/
│   ├── materi/
│   └── kuis/
├── tu/
│   ├── dashboard.blade.php
│   ├── siswa/
│   ├── guru/
│   └── jadwal/
└── kepala-sekolah/
    ├── dashboard.blade.php
    ├── laporan/
    └── evaluasi/
```

### 7.2 Contoh View Login

**File:** `resources/views/auth/login.blade.php`

```html
<!DOCTYPE html>
<html>
<head>
    <title>Login - TMS NURANI</title>
</head>
<body>
    <h1>Login</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        
        <label>Role:</label>
        <select name="role" required>
            <option value="">Pilih Role</option>
            <option value="guru">Guru</option>
            <option value="tu">Tenaga Usaha</option>
            <option value="kepala_sekolah">Kepala Sekolah</option>
        </select>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>
            <input type="checkbox" name="remember"> Remember Me
        </label>

        <button type="submit">Login</button>
    </form>
</body>
</html>
```

---

## 📖 BAB 8: BEST PRACTICES

### 8.1 Keamanan

1. **Selalu hash password**
   ```php
   'password' => Hash::make($password)
   ```

2. **Gunakan middleware untuk proteksi**
   ```php
   Route::middleware(['auth', 'role:guru'])
   ```

3. **Validasi input**
   ```php
   $request->validate([
       'email' => 'required|email',
       'password' => 'required|min:8',
   ]);
   ```

4. **CSRF Protection**
   ```html
   <form method="POST">
       @csrf
       <!-- form fields -->
   </form>
   ```

### 8.2 Code Organization

1. **Pisahkan logic berdasarkan role**
   - GuruController untuk logic guru
   - TUController untuk logic TU
   - KepalaSekolahController untuk logic kepala sekolah

2. **Gunakan Model Relationship**
   ```php
   // Di Model User
   public function guru()
   {
       return $this->hasOne(Guru::class);
   }

   // Penggunaan
   $user = Auth::user();
   $guru = $user->guru; // Otomatis ambil data guru
   ```

3. **Gunakan Resource Controller**
   ```php
   Route::resource('siswa', SiswaController::class);
   // Otomatis generate: index, create, store, show, edit, update, destroy
   ```

---

## 📖 BAB 9: TROUBLESHOOTING UMUM

### 9.1 Error "Data guru tidak ditemukan"

**Penyebab:**
- User ada di tabel `users` tapi tidak ada di tabel `gurus`

**Solusi:**
```php
// Jalankan GuruSeeder
php artisan db:seed --class=GuruSeeder
```

### 9.2 Error 403 Forbidden

**Penyebab:**
- User login tapi role tidak sesuai

**Solusi:**
- Cek role user di database
- Pastikan middleware role sudah benar

### 9.3 Redirect Loop

**Penyebab:**
- Middleware redirect ke halaman yang juga butuh middleware

**Solusi:**
- Pastikan route login tidak pakai middleware `auth`

---

## 📖 BAB 10: CHECKLIST IMPLEMENTASI

### ✅ Database
- [ ] Migration untuk tabel `users`
- [ ] Migration untuk tabel `gurus`
- [ ] Seeder untuk data user
- [ ] Seeder untuk data guru

### ✅ Authentication
- [ ] AuthController dengan method login/logout
- [ ] Route untuk login/logout
- [ ] View login form

### ✅ Authorization
- [ ] Middleware CheckRole
- [ ] Register middleware di Kernel/app.php

### ✅ Routing
- [ ] Route group untuk guru
- [ ] Route group untuk TU
- [ ] Route group untuk kepala sekolah

### ✅ Controllers
- [ ] GuruController
- [ ] TUController
- [ ] KepalaSekolahController

### ✅ Views
- [ ] Dashboard guru
- [ ] Dashboard TU
- [ ] Dashboard kepala sekolah

---

## 🎓 KESIMPULAN

**Konsep Utama yang Harus Dipahami:**

1. **Separation of Concerns**
   - Tabel `users` untuk login
   - Tabel `gurus` untuk data detail
   - Controller terpisah per role

2. **Security First**
   - Hash password
   - Middleware untuk proteksi
   - CSRF token
   - Validasi input

3. **Clean Code**
   - Naming convention yang jelas
   - Komentar untuk code yang kompleks
   - Reusable components

4. **Scalability**
   - Mudah menambah role baru
   - Mudah menambah fitur per role
   - Terstruktur dan maintainable

---

## 📚 REFERENSI

- [Laravel Documentation - Authentication](https://laravel.com/docs/authentication)
- [Laravel Documentation - Authorization](https://laravel.com/docs/authorization)
- [Laravel Documentation - Middleware](https://laravel.com/docs/middleware)
- [Laravel Documentation - Routing](https://laravel.com/docs/routing)

---

**Dibuat oleh:** Antigravity AI Assistant  
**Tanggal:** 14 Januari 2026  
**Untuk:** TMS NURANI - MTs Nurul Aiman
