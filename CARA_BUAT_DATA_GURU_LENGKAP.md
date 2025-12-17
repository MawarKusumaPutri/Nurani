# ✅ Cara Buat Data Guru Lengkap (Dengan Reset Database)

## 🎯 TUJUAN

**Membuat data guru di database dengan reset database lengkap (fresh start).**

---

## ✅ CARA 1: Menggunakan Script Lengkap (RECOMMENDED!)

**Script ini akan reset database dan buat data guru dari awal:**

1. **Pastikan MySQL sudah berjalan di XAMPP** (Start MySQL di XAMPP Control Panel)
2. **Double-click file:** `BUAT_DATA_GURU_LENGKAP.bat`
3. **Script akan otomatis:**
   - Hapus database 'nurani' jika ada
   - Buat database 'nurani' baru
   - Jalankan migrations
   - Buat data guru dengan email dan password

**Atau jalankan manual:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
.\BUAT_DATA_GURU_LENGKAP.bat
```

---

## ✅ CARA 2: Menggunakan Script Simple (Jika Database Sudah Ada)

**Jika database sudah ada dan hanya perlu tambah data guru:**

1. **Pastikan MySQL sudah berjalan di XAMPP**
2. **Double-click file:** `BUAT_DATA_GURU.bat`
3. **Script akan otomatis:**
   - Jalankan migrations (jika belum)
   - Buat data guru

---

## ✅ CARA 3: Manual Step-by-Step

### Langkah 1: Pastikan Database Ada

**Jika belum ada, buat dulu:**

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik tab "SQL"**
3. **Jalankan SQL:**
   ```sql
   DROP DATABASE IF EXISTS nurani;
   CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

### Langkah 2: Jalankan Migrations

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

### Langkah 3: Jalankan Seeder

```powershell
php artisan db:seed --class=UserSeeder
```

---

## 📋 DATA GURU YANG AKAN DIBUAT

**Berikut data guru yang akan dibuat:**

1. **Syifa Restu R** - `syifarestu81@gmail.com` (TU & Seni Budaya)
2. **Keysa Anjani** - `keysa8406@gmail.com` (Bahasa Inggris)
3. **Desi Nurfalah** - `desinurfalah24@gmail.com` (Bahasa Indonesia)
4. **Sopyan** - `sopyanikhsananda@gmail.com` (PKN)
5. **Weni Azmi** - `wenibustamin27@gmail.com` (Tahsin)
6. **Tintin Martini** - `tintinmartini184@gmail.com` (BTQ)
7. **Fadli** - `fadliziyad123@gmail.com` (Bahasa Arab)
8. **Siti Mundari** - `sitimundari54@gmail.com` (IPA, Prakarya)
9. **Nurhadi** - `mundarinurhadi@gmail.com` (Matematika)
10. **Hamzah Najmudin** - `zahnajmudin10@gmail.com` (PJOK, IPS)
11. **Rizmal** - `rizmalmaulana25@gmail.com` (QH, FIQIH)

**Password default untuk semua guru:** `password123`

---

## 🔐 PASSWORD DEFAULT

**Password default:** `password123`

**Guru bisa ubah password sendiri setelah login:**
1. Login dengan password default
2. Buka menu Profile/Profil
3. Ubah password sesuai keinginan

---

## 🆘 JIKA MASIH ERROR

### Error: "MySQL belum berjalan"

**Solusi:**
- Buka XAMPP Control Panel
- Klik "Start" pada MySQL
- Tunggu sampai MySQL benar-benar start (hijau)

### Error: "Migrations gagal"

**Solusi:**
- Gunakan script lengkap yang akan reset database
- Atau cek error message untuk detail

### Error: "Seeder gagal"

**Solusi:**
- Pastikan migrations sudah jalan
- Cek apakah tabel `users` dan `gurus` sudah ada
- Cek error message untuk detail

---

## 📋 CHECKLIST

### ✅ Sebelum Buat Data:
- [ ] MySQL sudah berjalan di XAMPP
- [ ] Pilih script yang sesuai (lengkap atau simple)

### ✅ Buat Data:
- [ ] Jalankan script `BUAT_DATA_GURU_LENGKAP.bat` (untuk fresh start)
- [ ] Atau jalankan script `BUAT_DATA_GURU.bat` (jika database sudah ada)
- [ ] Tunggu sampai selesai

### ✅ Test Login:
- [ ] Buka aplikasi → `http://localhost/nurani/public/`
- [ ] Klik "LOGIN" → Pilih role "GURU"
- [ ] Test login dengan email dan password default
- [ ] Pastikan bisa masuk ke dashboard

---

## 💡 TIPS

1. **Gunakan script lengkap** - Untuk fresh start yang bersih
2. **Password default:** `password123` - Guru bisa ubah sendiri
3. **Test login setelah data dibuat** - Pastikan semua guru bisa login
4. **Jika ada guru yang tidak bisa login** - Cek email dan password di database

---

## 🎯 REKOMENDASI

**Gunakan Cara 1 (Script Lengkap) dulu!**

**Ini akan reset database dan buat semua data dari awal dengan bersih.**

**Setelah data dibuat, test login untuk memastikan semua guru bisa masuk!**

---

**Jalankan script `BUAT_DATA_GURU_LENGKAP.bat` untuk membuat data guru! 🚀**
