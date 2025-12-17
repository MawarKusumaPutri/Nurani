# ✅ Solusi Mudah: Redirect ke Dashboard Setelah Login

## 🎯 MASALAH

**Setelah login, user tidak langsung masuk ke dashboard sesuai role mereka.**

---

## ✅ SOLUSI YANG SUDAH DIPERBAIKI

### 1. Redirect Logic Sudah Diperbaiki

**File:** `app/Http/Controllers/AuthController.php` (baris 48-71)

**Kode redirect sudah diperbaiki:**
```php
$userRole = $user->role;
$redirectUrl = match($userRole) {
    'guru' => route('guru.dashboard'),
    'tu' => route('tu.dashboard'),
    'kepala_sekolah' => route('kepala_sekolah.dashboard'),
    default => route('guru.dashboard')
};

// Gunakan redirect()->intended() untuk fallback yang lebih baik
return redirect()->intended($redirectUrl);
```

### 2. Route Dashboard Sudah Ada

**File:** `routes/web.php`

- ✅ `guru.dashboard` → `/guru/dashboard`
- ✅ `tu.dashboard` → `/tu/dashboard`
- ✅ `kepala_sekolah.dashboard` → `/kepala-sekolah/dashboard`

---

## 🔍 CARA TEST

### Test Login:

1. **Buka website** di browser:
   - Localhost: `http://localhost/nurani/public/`
   - Railway: `web-production-50f9.up.railway.app`

2. **Klik tombol "LOGIN"** di header

3. **Masukkan:**
   - Email: (email yang sudah terdaftar)
   - Password: (password yang benar)
   - Role: Pilih salah satu (GURU, TENAGA USAHA, atau KEPALA SEKOLAH)

4. **Klik "Login"**

5. **Setelah login berhasil:**
   - ✅ **Jika role = GURU** → Harus redirect ke `/guru/dashboard`
   - ✅ **Jika role = TENAGA USAHA** → Harus redirect ke `/tu/dashboard`
   - ✅ **Jika role = KEPALA SEKOLAH** → Harus redirect ke `/kepala-sekolah/dashboard`

---

## 🆘 JIKA MASIH TIDAK REDIRECT

### Masalah 1: Error "Table 'users' doesn't exist"

**Solusi:**
```bash
# Jalankan migrations
php artisan migrate --force
```

### Masalah 2: Error "Route not found"

**Solusi:**
```bash
# Clear route cache
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### Masalah 3: Redirect ke halaman lain

**Solusi:**
1. **Cek apakah user sudah terdaftar** di database
2. **Cek apakah role user sudah benar** di database
3. **Cek browser console** (F12) untuk error JavaScript

### Masalah 4: Session tidak tersimpan

**Solusi:**
1. **Cek file `.env`** - pastikan `SESSION_DRIVER=file`
2. **Cek folder `storage/framework/sessions`** - pastikan bisa ditulis
3. **Clear session cache:**
   ```bash
   php artisan session:clear
   ```

---

## 📋 CHECKLIST

### ✅ Untuk Localhost:
- [ ] Migrations sudah jalan (`php artisan migrate --force`)
- [ ] Tabel `users` sudah ada
- [ ] User sudah terdaftar di database
- [ ] Role user sudah benar di database
- [ ] Test login dengan role GURU → harus ke `/guru/dashboard`
- [ ] Test login dengan role TENAGA USAHA → harus ke `/tu/dashboard`
- [ ] Test login dengan role KEPALA SEKOLAH → harus ke `/kepala-sekolah/dashboard`

### ✅ Untuk Railway:
- [ ] Migrations sudah jalan (cek Deploy Logs)
- [ ] Service "web" status "Online" (hijau)
- [ ] Test login dengan role yang berbeda
- [ ] Pastikan redirect ke dashboard sesuai role

---

## 💡 TIPS

1. **Pastikan user sudah terdaftar** di database dengan role yang benar
2. **Test dengan role yang berbeda** untuk memastikan redirect bekerja
3. **Cek browser console** (F12) untuk error JavaScript jika ada
4. **Clear cache** jika ada masalah dengan route atau config

---

## 🎯 KESIMPULAN

**Sistem redirect sudah diperbaiki dan siap digunakan!**

**Yang perlu dilakukan:**
1. ✅ Pastikan migrations sudah jalan
2. ✅ Pastikan user sudah terdaftar di database
3. ✅ Test login dengan role yang berbeda
4. ✅ Pastikan redirect ke dashboard sesuai role

**Jika masih tidak redirect:**
- Clear cache: `php artisan route:clear && php artisan config:clear && php artisan cache:clear`
- Cek apakah user sudah terdaftar dan role sudah benar
- Cek browser console untuk error

---

**Sistem redirect sudah diperbaiki! Test login untuk memastikan bekerja! 🚀**
