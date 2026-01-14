# 🚀 CHEAT SHEET: Sistem Multi-Role Laravel

## 📋 Quick Reference

### 1️⃣ Cek Role User (di Controller)
```php
use Illuminate\Support\Facades\Auth;

// Cara 1: Langsung cek role
if (Auth::user()->role === 'guru') {
    // Logic untuk guru
}

// Cara 2: Pakai helper method
if (Auth::user()->isGuru()) {
    // Logic untuk guru
}

// Cara 3: Get role
$role = Auth::user()->role;
```

### 2️⃣ Proteksi Route dengan Middleware
```php
// Single role
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard']);
});

// Multiple roles
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        if (Auth::user()->isGuru() || Auth::user()->isTU()) {
            return view('profile');
        }
        abort(403);
    });
});
```

### 3️⃣ Redirect Berdasarkan Role
```php
public function login(Request $request)
{
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        return match($user->role) {
            'guru' => redirect()->route('guru.dashboard'),
            'tu' => redirect()->route('tu.dashboard'),
            'kepala_sekolah' => redirect()->route('kepala-sekolah.dashboard'),
            default => redirect('/'),
        };
    }
}
```

### 4️⃣ Tampilkan Konten Berdasarkan Role (di Blade)
```blade
@auth
    @if(Auth::user()->isGuru())
        <p>Selamat datang, Guru!</p>
    @elseif(Auth::user()->isTU())
        <p>Selamat datang, Tenaga Usaha!</p>
    @elseif(Auth::user()->isKepalaSekolah())
        <p>Selamat datang, Kepala Sekolah!</p>
    @endif
@endauth
```

### 5️⃣ Get Data Relasi (User → Guru)
```php
// Di Controller
$user = Auth::user();
$guru = $user->guru; // Otomatis ambil data dari tabel gurus

// Cek apakah data guru ada
if (!$guru) {
    return redirect()->back()->with('error', 'Data guru tidak ditemukan');
}

// Akses data guru
echo $guru->nip;
echo $guru->mata_pelajaran;
```

### 6️⃣ Create User dengan Role
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Create user guru
$user = User::create([
    'name' => 'Desi Nurfalah',
    'email' => 'desinurfalah24@gmail.com',
    'password' => Hash::make('password123'),
    'role' => 'guru',
]);

// Create data guru
$user->guru()->create([
    'nip' => 'G013',
    'mata_pelajaran' => 'Bahasa Indonesia',
    'status' => 'aktif',
]);
```

### 7️⃣ Validasi Role di Request
```php
$request->validate([
    'email' => 'required|email',
    'password' => 'required|min:8',
    'role' => 'required|in:guru,tu,kepala_sekolah',
]);
```

### 8️⃣ Logout
```php
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/');
}
```

---

## 🔧 Command Artisan Berguna

```bash
# Buat migration
php artisan make:migration create_users_table

# Buat model dengan migration
php artisan make:model Guru -m

# Buat controller
php artisan make:controller GuruController

# Buat middleware
php artisan make:middleware CheckRole

# Buat seeder
php artisan make:seeder UserSeeder

# Jalankan migration
php artisan migrate

# Jalankan seeder
php artisan db:seed --class=UserSeeder

# Reset database dan seed ulang
php artisan migrate:fresh --seed

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 🎯 Struktur Folder Recommended

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── GuruController.php
│   │   ├── TUController.php
│   │   └── KepalaSekolahController.php
│   └── Middleware/
│       └── CheckRole.php
├── Models/
│   ├── User.php
│   └── Guru.php

database/
├── migrations/
│   ├── xxxx_create_users_table.php
│   └── xxxx_create_gurus_table.php
└── seeders/
    ├── UserSeeder.php
    └── GuruSeeder.php

resources/views/
├── auth/
│   └── login.blade.php
├── guru/
│   └── dashboard.blade.php
├── tu/
│   └── dashboard.blade.php
└── kepala-sekolah/
    └── dashboard.blade.php

routes/
└── web.php
```

---

## ⚠️ Common Mistakes & Solutions

### ❌ Mistake 1: Lupa Hash Password
```php
// SALAH
User::create([
    'password' => 'password123', // Plain text!
]);

// BENAR
User::create([
    'password' => Hash::make('password123'),
]);
```

### ❌ Mistake 2: Field Name Tidak Match
```php
// Controller expect 'nama_kepala_sekolah'
$validated = $request->validate([
    'nama_kepala_sekolah' => 'required',
]);

// Tapi form pakai 'kepala_sekolah_nama'
<input name="kepala_sekolah_nama"> <!-- SALAH! -->

// BENAR
<input name="nama_kepala_sekolah">
```

### ❌ Mistake 3: Lupa CSRF Token
```html
<!-- SALAH -->
<form method="POST" action="/login">
    <input name="email">
    <button>Login</button>
</form>

<!-- BENAR -->
<form method="POST" action="/login">
    @csrf
    <input name="email">
    <button>Login</button>
</form>
```

### ❌ Mistake 4: Route Tidak Pakai Middleware
```php
// SALAH - Siapa saja bisa akses
Route::get('/guru/dashboard', [GuruController::class, 'dashboard']);

// BENAR - Hanya guru yang bisa akses
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard']);
});
```

---

## 💡 Pro Tips

1. **Gunakan Route Names**
   ```php
   // GOOD
   return redirect()->route('guru.dashboard');
   
   // AVOID
   return redirect('/guru/dashboard');
   ```

2. **Gunakan Form Request untuk Validasi Kompleks**
   ```bash
   php artisan make:request StoreRppRequest
   ```

3. **Gunakan Policy untuk Authorization**
   ```bash
   php artisan make:policy RppPolicy --model=Rpp
   ```

4. **Gunakan Accessor & Mutator di Model**
   ```php
   // Accessor - format data saat diambil
   public function getFullNameAttribute()
   {
       return "{$this->name} ({$this->role})";
   }
   
   // Usage: $user->full_name
   ```

5. **Gunakan Scope untuk Query Berulang**
   ```php
   // Di Model User
   public function scopeGuru($query)
   {
       return $query->where('role', 'guru');
   }
   
   // Usage: User::guru()->get();
   ```

---

## 📞 Troubleshooting Quick Guide

| Error | Penyebab | Solusi |
|-------|----------|--------|
| 419 Page Expired | CSRF token expired | Refresh halaman, tambah `@csrf` di form |
| 403 Forbidden | Role tidak sesuai | Cek middleware dan role user |
| 404 Not Found | Route tidak ada | Cek `routes/web.php` dan `php artisan route:list` |
| 500 Server Error | PHP/Laravel error | Cek `storage/logs/laravel.log` |
| Blank Page | JavaScript error atau PHP fatal error | Buka Developer Console (F12) |
| Data guru tidak ditemukan | Relasi user-guru tidak ada | Jalankan `GuruSeeder` |

---

**Last Updated:** 14 Januari 2026
