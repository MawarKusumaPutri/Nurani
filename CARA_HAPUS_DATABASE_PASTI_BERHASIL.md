# ✅ Cara Hapus Database PASTI BERHASIL

## 🎯 MASALAH

**Error yang muncul:**
- `Error dropping database (can't rmdir '.\nurani', errno: 41 "Directory not empty")`
- `Can't create database 'nurani'; database exists`
- `Tablespace for table 'migrations' exists`

**Penyebab:** File tablespace masih ada di filesystem, sehingga database tidak bisa dihapus via SQL.

---

## ✅ SOLUSI: Hapus Folder Database Secara Manual

### Langkah 1: Stop MySQL

1. **Buka XAMPP Control Panel**
2. **Klik "Stop" pada MySQL**
3. **Tunggu sampai MySQL benar-benar berhenti**

### Langkah 2: Hapus Folder Database

**Cari folder database di salah satu lokasi berikut:**

- `C:\xampp\mysql\data\nurani`
- `D:\xampp\mysql\data\nurani`

**Hapus folder `nurani` secara manual:**
1. Buka File Explorer
2. Navigasi ke lokasi di atas
3. Hapus folder `nurani` (klik kanan → Delete)

**Atau gunakan script:** `HAPUS_DATABASE_PASTI_BERHASIL.bat`

### Langkah 3: Start MySQL

1. **Buka XAMPP Control Panel**
2. **Klik "Start" pada MySQL**
3. **Tunggu sampai MySQL berjalan**

### Langkah 4: Buat Database Baru

**Buka phpMyAdmin** → `http://localhost/phpmyadmin`

**Tab SQL, jalankan:**

```sql
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Langkah 5: Jalankan Migrations

**Buka PowerShell:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

### Langkah 6: Masukkan Data Guru

```powershell
php artisan db:seed --class=UserSeeder
```

**Atau double-click:** `MASUKKAN_DATA_GURU.bat`

---

## 🎯 CARA LEBIH MUDAH: Gunakan Script

**Double-click file:** `HAPUS_DATABASE_PASTI_BERHASIL.bat`

**Script akan:**
1. ✅ Meminta Anda stop MySQL
2. ✅ Mencari dan menghapus folder database
3. ✅ Meminta Anda start MySQL
4. ✅ Membuat database baru
5. ✅ Menjalankan migrations
6. ✅ Menambahkan data guru

---

## ⚠️ PERINGATAN

**Sebelum menghapus database, pastikan:**
- ✅ Tidak ada data penting yang akan hilang
- ✅ Atau sudah di-backup sebelumnya

**Jika ada data penting, backup dulu:**
1. Di phpMyAdmin, klik database "nurani"
2. Klik tab "Export"
3. Klik "Go" untuk download backup

---

## 📋 LOKASI FOLDER DATABASE

**Folder database biasanya ada di:**
- `C:\xampp\mysql\data\nurani`
- `D:\xampp\mysql\data\nurani`
- Atau di lokasi XAMPP Anda

**Cara cek lokasi XAMPP:**
1. Buka XAMPP Control Panel
2. Klik "Config" pada MySQL
3. Cek file `my.ini` atau `my.cnf`
4. Cari `datadir` untuk melihat lokasi data

---

## ✅ SETELAH SELESAI

1. **Cek di phpMyAdmin** → database "nurani" → semua tabel sudah dibuat
2. **Cek tabel "users"** → 13 guru sudah ada
3. **Test login** di aplikasi dengan email dan password dari LOGIN_CREDENTIALS.md

---

## 🎯 REKOMENDASI

**Gunakan script `HAPUS_DATABASE_PASTI_BERHASIL.bat` untuk menghapus database dengan pasti!**

**Script akan memandu Anda step-by-step untuk menghapus database dan membuat yang baru!**

---

**Ikuti langkah di atas untuk mengatasi error tablespace! 🚀**
