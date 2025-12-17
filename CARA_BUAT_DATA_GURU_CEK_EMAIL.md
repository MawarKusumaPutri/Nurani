# ✅ Cara Buat Data Guru dan Cek Email Berfungsi

## 🎯 TUJUAN

**Membuat data guru di database dan memastikan email bisa digunakan untuk login.**

---

## ✅ CARA TERMUDAH: Via phpMyAdmin SQL

### Langkah 1: Hapus Database Lama

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik tab "SQL"** di bagian atas (tidak perlu pilih database dulu)
3. **Copy dan paste SQL berikut:**

```sql
DROP DATABASE IF EXISTS nurani;
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. **Klik "Go"** untuk menjalankan SQL

### Langkah 2: Jalankan Migrations

**Buka PowerShell:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

**Tunggu sampai migrations selesai!**

### Langkah 3: Buat Data Guru

**Masih di PowerShell yang sama:**

```powershell
php artisan db:seed --class=UserSeeder
```

**Tunggu sampai seeder selesai!**

### Langkah 4: Cek Data Guru

**Jalankan script cek:**

```powershell
php cek_data_guru.php
```

**Atau cek manual di phpMyAdmin:**
1. Buka phpMyAdmin → database "nurani"
2. Klik tabel "users"
3. Cek apakah ada data guru dengan email yang benar

---

## ✅ CARA ALTERNATIF: Menggunakan Script

1. **Pastikan MySQL sudah berjalan di XAMPP**
2. **Double-click file:** `BUAT_DATA_GURU_PASTI_BERHASIL.bat`
3. **Script akan otomatis melakukan semua langkah**

---

## 📋 EMAIL GURU YANG AKAN DIBUAT

**Berikut email guru yang akan dibuat:**

1. `syifarestu81@gmail.com` - Syifa Restu R (TU & Seni Budaya)
2. `keysa8406@gmail.com` - Keysa Anjani (Bahasa Inggris)
3. `desinurfalah24@gmail.com` - Desi Nurfalah (Bahasa Indonesia)
4. `sopyanikhsananda@gmail.com` - Sopyan (PKN)
5. `wenibustamin27@gmail.com` - Weni Azmi (Tahsin)
6. `tintinmartini184@gmail.com` - Tintin Martini (BTQ)
7. `fadliziyad123@gmail.com` - Fadli (Bahasa Arab)
8. `sitimundari54@gmail.com` - Siti Mundari (IPA, Prakarya)
9. `mundarinurhadi@gmail.com` - Nurhadi (Matematika)
10. `zahnajmudin10@gmail.com` - Hamzah Najmudin (PJOK, IPS)
11. `rizmalmaulana25@gmail.com` - Rizmal (QH, FIQIH)

**Password default:** `password123`

---

## ✅ CEK APAKAH EMAIL SUDAH BERFUNGSI

### Cara 1: Cek di Database

**Jalankan script:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php cek_data_guru.php
```

**Script akan menampilkan:**
- Jumlah guru di database
- Daftar email guru yang ada

### Cara 2: Cek di phpMyAdmin

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik database "nurani"** di sidebar kiri
3. **Klik tabel "users"**
4. **Cek apakah ada data dengan email guru**

### Cara 3: Test Login

1. **Buka aplikasi** → `http://localhost/nurani/public/`
2. **Klik "LOGIN"** → Pilih role "GURU"
3. **Masukkan:**
   - Email: (salah satu email guru, misalnya `syifarestu81@gmail.com`)
   - Password: `password123`
4. **Klik "Login"**
5. **Jika berhasil masuk ke dashboard** = Email sudah berfungsi! ✅

---

## 🆘 JIKA EMAIL BELUM BERFUNGSI

### Masalah: "Tabel users belum ada"

**Solusi:**
- Jalankan migrations: `php artisan migrate --force`

### Masalah: "Data guru belum ada"

**Solusi:**
- Jalankan seeder: `php artisan db:seed --class=UserSeeder`

### Masalah: "Login gagal"

**Solusi:**
- Cek email dan password di database
- Pastikan role = 'guru'
- Cek apakah password sudah di-hash dengan benar

---

## 📋 CHECKLIST

### ✅ Buat Data:
- [ ] Hapus database lama (via phpMyAdmin SQL)
- [ ] Buat database baru
- [ ] Jalankan migrations
- [ ] Jalankan seeder
- [ ] Cek data guru sudah ada

### ✅ Test Login:
- [ ] Buka aplikasi → `http://localhost/nurani/public/`
- [ ] Test login dengan email guru
- [ ] Pastikan bisa masuk ke dashboard
- [ ] Pastikan redirect ke dashboard sesuai role

---

## 💡 TIPS

1. **Gunakan script otomatis** - Paling mudah dan cepat
2. **Cek data dengan script** - `php cek_data_guru.php`
3. **Test login setelah data dibuat** - Pastikan email berfungsi
4. **Password default:** `password123` - Guru bisa ubah sendiri

---

## 🎯 REKOMENDASI

**Gunakan script `BUAT_DATA_GURU_PASTI_BERHASIL.bat` untuk membuat data guru!**

**Setelah data dibuat, test login untuk memastikan email berfungsi!**

---

**Jalankan script untuk membuat data guru, lalu test login! 🚀**
