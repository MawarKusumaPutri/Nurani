# ✅ Cara Migrasi Otomatis - Mengurangi Error

## 🎯 TUJUAN

**Menjalankan migrations secara otomatis dengan penanganan error yang lebih baik, terutama untuk error tablespace.**

---

## ✅ CARA TERMUDAH: Script Otomatis

### Langkah 1: Jalankan Script

**Double-click file:** `FIX_DAN_MIGRATE_OTOMATIS.bat`

**Script akan otomatis:**
1. ✅ Cek koneksi MySQL
2. ✅ Fix tablespace error (jika bisa)
3. ✅ Hapus database lama
4. ✅ Buat database baru
5. ✅ Jalankan migrations
6. ✅ Buat data guru
7. ✅ Verifikasi hasil

---

## ⚠️ JIKA MASIH ADA ERROR TABLESPACE

### Solusi: Fix Manual di phpMyAdmin (Sekali Saja)

**Jika script masih error karena tablespace, ikuti langkah ini:**

#### Langkah 1: Buka phpMyAdmin

1. **Buka browser** → `http://localhost/phpmyadmin`
2. **Klik tab "SQL"** di bagian atas (tidak perlu pilih database dulu)

#### Langkah 2: Jalankan SQL

**Copy dan paste SQL berikut:**

```sql
DROP DATABASE IF EXISTS nurani;
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. **Klik "Go"** untuk menjalankan

#### Langkah 3: Jalankan Script Lagi

**Setelah fix di phpMyAdmin, jalankan script lagi:**

- **Double-click:** `FIX_DAN_MIGRATE_OTOMATIS.bat`

**Atau jalankan manual di terminal:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
php artisan db:seed --class=UserSeeder
```

---

## 📋 FILE YANG TERSEDIA

### 1. `FIX_DAN_MIGRATE_OTOMATIS.bat`
- **Fungsi:** Script utama untuk migrasi otomatis
- **Cara pakai:** Double-click file ini
- **Fitur:** Auto-fix tablespace, drop/create database, migrate, seed

### 2. `fix_tablespace_dan_migrate.php`
- **Fungsi:** Script PHP untuk migrasi otomatis
- **Cara pakai:** Dijalankan oleh `.bat` file
- **Fitur:** Handle error tablespace, retry logic

### 3. `fix_tablespace_lengkap.sql`
- **Fungsi:** SQL untuk fix manual di phpMyAdmin
- **Cara pakai:** Copy-paste di phpMyAdmin SQL tab
- **Fitur:** Drop dan create database dengan benar

### 4. `migrate_otomatis.php`
- **Fungsi:** Script migrasi otomatis (versi sebelumnya)
- **Cara pakai:** Dijalankan oleh `.bat` file
- **Fitur:** Basic migration automation

---

## ✅ CEK HASIL

### Cara 1: Cek dengan Script

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php cek_data_guru.php
```

### Cara 2: Cek di phpMyAdmin

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik database "nurani"** di sidebar kiri
3. **Klik tabel "users"**
4. **Cek apakah ada data guru**

### Cara 3: Test Login

1. **Buka aplikasi** → `http://localhost/nurani/public/`
2. **Klik "LOGIN"** → Pilih role "GURU"
3. **Masukkan:**
   - Email: `syifarestu81@gmail.com`
   - Password: `password123`
4. **Klik "Login"**
5. **Jika berhasil masuk ke dashboard** = Email sudah berfungsi! ✅

---

## 🆘 TROUBLESHOOTING

### Error: "Tablespace for table 'migrations' exists"

**Solusi:**
1. Jalankan SQL di phpMyAdmin (lihat "Solusi: Fix Manual" di atas)
2. Setelah itu, jalankan script lagi

### Error: "Error dropping database (can't rmdir)"

**Solusi:**
1. Stop MySQL di XAMPP Control Panel
2. Start MySQL lagi
3. Jalankan script lagi

### Error: "Table 'users' doesn't exist"

**Solusi:**
- Migrations belum jalan
- Jalankan: `php artisan migrate --force`

### Error: "Data guru belum ada"

**Solusi:**
- Seeder belum jalan
- Jalankan: `php artisan db:seed --class=UserSeeder`

---

## 📋 CHECKLIST

### ✅ Setup:
- [ ] MySQL sudah berjalan di XAMPP
- [ ] Script `FIX_DAN_MIGRATE_OTOMATIS.bat` sudah ada
- [ ] File `fix_tablespace_dan_migrate.php` sudah ada

### ✅ Jalankan:
- [ ] Double-click `FIX_DAN_MIGRATE_OTOMATIS.bat`
- [ ] Jika error tablespace, fix manual di phpMyAdmin
- [ ] Jalankan script lagi setelah fix

### ✅ Verifikasi:
- [ ] Cek data guru dengan `php cek_data_guru.php`
- [ ] Test login dengan email guru
- [ ] Pastikan bisa masuk ke dashboard

---

## 💡 TIPS

1. **Gunakan script otomatis** - Paling mudah dan cepat
2. **Jika error tablespace** - Fix manual di phpMyAdmin sekali, lalu script otomatis bisa jalan
3. **Cek hasil dengan script** - `php cek_data_guru.php`
4. **Test login setelah data dibuat** - Pastikan email berfungsi

---

## 🎯 REKOMENDASI

**Gunakan `FIX_DAN_MIGRATE_OTOMATIS.bat` untuk migrasi otomatis!**

**Jika masih error tablespace, fix manual di phpMyAdmin sekali, lalu script otomatis bisa jalan!**

---

**Jalankan script untuk migrasi otomatis! 🚀**
