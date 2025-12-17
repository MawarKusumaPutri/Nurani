# ✅ Cara Agar User Langsung Masuk ke Dashboard Masing-Masing

## 🎯 TUJUAN

**Setelah login, user langsung masuk ke dashboard sesuai role:**
- ✅ **Guru** → Dashboard Guru (`/guru/dashboard`)
- ✅ **Tenaga Usaha (TU)** → Dashboard TU (`/tu/dashboard`)
- ✅ **Kepala Sekolah** → Dashboard Kepala Sekolah (`/kepala-sekolah/dashboard`)

---

## ✅ YANG SUDAH ADA

### 1. Redirect Logic di AuthController

**File:** `app/Http/Controllers/AuthController.php` (baris 48-55)

**Kode redirect sudah benar:**
```php
$userRole = $user->role;
$redirectUrl = match($userRole) {
    'guru' => route('guru.dashboard'),
    'tu' => route('tu.dashboard'),
    'kepala_sekolah' => route('kepala_sekolah.dashboard'),
    default => route('guru.dashboard')
};
```

### 2. Route Dashboard Sudah Ada

**File:** `routes/web.php`

**Route yang sudah ada:**
- ✅ `guru.dashboard` → `/guru/dashboard`
- ✅ `tu.dashboard` → `/tu/dashboard`
- ✅ `kepala_sekolah.dashboard` → `/kepala-sekolah/dashboard`

---

## 🔍 CEK APAKAH SUDAH BEKERJA

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

## 🆘 JIKA TIDAK REDIRECT KE DASHBOARD

### Masalah 1: Error "Table 'users' doesn't exist"

**Solusi:**
- Jalankan migrations di localhost atau Railway
- Pastikan tabel `users` sudah ada

### Masalah 2: Error "Route not found"

**Solusi:**
- Cek apakah route sudah benar di `routes/web.php`
- Clear route cache: `php artisan route:clear`

### Masalah 3: Redirect ke halaman lain

**Solusi:**
- Cek apakah ada middleware yang mengubah redirect
- Cek apakah ada session yang mengubah redirect

---

## 📋 CHECKLIST

### ✅ Untuk Localhost:
- [ ] Migrations sudah jalan (`php artisan migrate --force`)
- [ ] Tabel `users` sudah ada
- [ ] User sudah terdaftar di database
- [ ] Test login dengan role yang berbeda
- [ ] Pastikan redirect ke dashboard sesuai role

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

---

## 🎯 KESIMPULAN

**Sistem redirect sudah benar!**

**Yang perlu dilakukan:**
1. ✅ Pastikan migrations sudah jalan
2. ✅ Pastikan user sudah terdaftar di database
3. ✅ Test login dengan role yang berbeda
4. ✅ Pastikan redirect ke dashboard sesuai role

**Jika masih tidak redirect, cek:**
- Apakah user sudah terdaftar?
- Apakah role user sudah benar di database?
- Apakah ada error di browser console?

---

**Sistem redirect sudah benar! Test login untuk memastikan bekerja! 🚀**
