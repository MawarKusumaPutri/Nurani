# ✅ Test Redirect ke Dashboard

## 🎯 CARA TEST YANG MUDAH

### Langkah 1: Pastikan Migrations Sudah Jalan

```bash
# Di PowerShell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

### Langkah 2: Clear Cache

```bash
# Clear semua cache
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### Langkah 3: Test Login

1. **Buka browser** → `http://localhost/nurani/public/`
2. **Klik "LOGIN"** di header
3. **Masukkan:**
   - Email: (email yang sudah terdaftar)
   - Password: (password yang benar)
   - Role: Pilih salah satu
4. **Klik "Login"**
5. **Setelah login:**
   - ✅ Harus langsung redirect ke dashboard sesuai role

---

## 🔍 CEK APAKAH REDIRECT BEKERJA

### Test dengan Role GURU:
- Login dengan role GURU
- Harus redirect ke: `/guru/dashboard`

### Test dengan Role TENAGA USAHA:
- Login dengan role TENAGA USAHA
- Harus redirect ke: `/tu/dashboard`

### Test dengan Role KEPALA SEKOLAH:
- Login dengan role KEPALA SEKOLAH
- Harus redirect ke: `/kepala-sekolah/dashboard`

---

## 🆘 JIKA TIDAK REDIRECT

### Cek 1: Apakah user sudah terdaftar?

**Buka phpMyAdmin:**
1. Buka `http://localhost/phpmyadmin`
2. Pilih database `nurani`
3. Klik tabel `users`
4. Cek apakah user sudah ada dengan role yang benar

### Cek 2: Apakah route sudah benar?

**Jalankan di PowerShell:**
```bash
php artisan route:list | findstr dashboard
```

**Harus muncul:**
- `guru.dashboard`
- `tu.dashboard`
- `kepala_sekolah.dashboard`

### Cek 3: Apakah ada error di browser?

1. **Buka browser console** (F12)
2. **Cek tab "Console"** untuk error JavaScript
3. **Cek tab "Network"** untuk error HTTP

---

## ✅ SETELAH TEST

**Jika redirect bekerja:**
- ✅ Sistem sudah benar!
- ✅ User akan langsung masuk ke dashboard sesuai role

**Jika masih tidak redirect:**
- Cek error di browser console
- Cek error di Laravel log: `storage/logs/laravel.log`
- Pastikan user sudah terdaftar dengan role yang benar

---

**Test login sekarang untuk memastikan redirect bekerja! 🚀**
