# 🔧 Troubleshooting: Login Masih Lambat

## ⚠️ MASALAH

Login masih stuck di "Memproses..." meskipun sudah banyak perbaikan.

## 🔍 DIAGNOSA MASALAH

### Step 1: Cek Apakah Masalahnya di Login atau Dashboard

**Test 1: Akses Dashboard Langsung**
1. Buka browser baru (Incognito/Private)
2. Login dulu dengan cara lain (jika bisa)
3. Copy URL dashboard: `http://localhost/nurani/public/guru/dashboard`
4. Buka URL tersebut langsung

**Jika dashboard lambat:**
→ Masalahnya di **Dashboard Controller**, bukan Login!

**Jika dashboard cepat:**
→ Masalahnya di **Login Process**

---

### Step 2: Cek Logs

**Buka terminal dan jalankan:**
```bash
cd D:\Praktikum DWBI\xampp\htdocs\nurani
tail -f storage/logs/laravel.log
```

**Lalu login di browser** dan lihat apa yang muncul di logs.

**Jika ada error atau query yang lambat:**
→ Itu penyebabnya!

---

### Step 3: Cek Browser Console

1. Buka Developer Tools (F12)
2. Buka tab **Network**
3. Login
4. Lihat request mana yang lambat

**Jika `/login` request lambat:**
→ Masalahnya di backend login

**Jika `/guru/dashboard` request lambat:**
→ Masalahnya di dashboard controller

---

## ✅ SOLUSI CEPAT

### Solusi 1: Disable Semua Operasi Background (PALING CEPAT)

Edit `app/Http/Controllers/AuthController.php`, cari method `login()`, dan **HAPUS** semua `register_shutdown_function`:

```php
if ($user && Hash::check($credentials['password'], $user->password)) {
    $remember = $request->has('remember') && $request->remember == '1';
    Auth::login($user, $remember);
    
    $userRole = $user->role;
    $redirectUrl = match($userRole) {
        'guru' => route('guru.dashboard'),
        'tu' => route('tu.dashboard'),
        'kepala_sekolah' => route('kepala_sekolah.dashboard'),
        default => route('guru.dashboard')
    };
    
    // LANGSUNG REDIRECT - TIDAK ADA OPERASI LAIN
    return redirect($redirectUrl);
}
```

**Hapus semua bagian `register_shutdown_function`!**

---

### Solusi 2: Clear Semua Cache (WAJIB!)

```bash
cd D:\Praktikum DWBI\xampp\htdocs\nurani
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

---

### Solusi 3: Restart Apache & MySQL

1. **XAMPP Control Panel**
2. **Stop** Apache dan MySQL
3. **Tunggu 5 detik**
4. **Start** MySQL dulu
5. **Tunggu 3 detik**
6. **Start** Apache

---

### Solusi 4: Cek Session Driver

**Buka file `.env` dan pastikan:**
```env
SESSION_DRIVER=file
```

**JANGAN gunakan `database`** karena lebih lambat!

**Setelah ubah, clear cache:**
```bash
php artisan config:clear
```

---

### Solusi 5: Disable ActivityTracker Sementara

Edit `app/Http/Controllers/AuthController.php`, **HAPUS** atau **COMMENT** semua bagian ActivityTracker:

```php
// DISABLE SEMENTARA - HAPUS INI
// if ($role === 'guru') {
//     $guru = Guru::where('user_id', $user->id)->first();
//     if ($guru) {
//         ActivityTracker::trackLogin($guru, $request);
//     }
// }
```

---

## 🎯 SOLUSI PALING CEPAT (RECOMMENDED)

**Lakukan semua langkah ini secara berurutan:**

1. **Edit AuthController** - Hapus semua `register_shutdown_function`
2. **Clear cache** - `php artisan optimize:clear`
3. **Restart Apache & MySQL**
4. **Clear browser cache** - Ctrl + Shift + Delete
5. **Test login**

---

## 📊 TESTING

### Test 1: Login Response Time

**Buka browser console (F12) → Network tab:**
- Login
- Lihat waktu response untuk `/login`
- **Harus < 500ms**

### Test 2: Dashboard Load Time

**Setelah login berhasil:**
- Lihat waktu response untuk `/guru/dashboard`
- **Harus < 2 detik**

### Test 3: Query Performance

**Enable query logging:**
```php
// Di awal method login()
DB::enableQueryLog();

// Di akhir method login()
dd(DB::getQueryLog());
```

**Cek apakah ada query yang lambat (> 100ms)**

---

## 🐛 JIKA MASIH LAMBAT

### Cek 1: Database Index

**Pastikan tabel `users` punya index:**
```sql
-- Di phpMyAdmin, jalankan:
ALTER TABLE users ADD INDEX idx_email_role (email, role);
```

### Cek 2: PHP Memory Limit

**Buka `php.ini` (di XAMPP):**
```ini
memory_limit = 256M
```

**Restart Apache**

### Cek 3: Apache Timeout

**Buka `httpd.conf` (di XAMPP):**
```apache
Timeout 300
```

**Restart Apache**

---

## ✅ CHECKLIST FINAL

- [ ] Hapus semua `register_shutdown_function` dari login
- [ ] Clear semua cache Laravel
- [ ] Restart Apache & MySQL
- [ ] Clear browser cache
- [ ] Cek session driver = `file`
- [ ] Test login
- [ ] Cek logs untuk error
- [ ] Cek browser console untuk request lambat

---

## 📞 JIKA MASIH TIDAK BERHASIL

**Kirim informasi ini:**
1. Screenshot browser console (Network tab)
2. Screenshot logs (`storage/logs/laravel.log`)
3. Waktu response untuk `/login` request
4. Waktu response untuk `/guru/dashboard` request

---

**Selamat troubleshooting! 🚀**

