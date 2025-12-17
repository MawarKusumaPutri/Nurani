# ✅ Solusi Error: "Can't create database 'nurani'; database exists"

## 🎯 MASALAH

**Error:** `#1007 - Can't create database 'nurani'; database exists`

**Penyebab:** Database `nurani` sudah ada, jadi tidak bisa dibuat lagi.

---

## ✅ SOLUSI: Hapus Database Dulu, Baru Buat Baru

### Langkah 1: Hapus Database di phpMyAdmin

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik tab "SQL"** di bagian atas (tidak perlu pilih database dulu)
3. **Copy dan paste SQL berikut:**

```sql
DROP DATABASE IF EXISTS nurani;
```

4. **Klik "Go"** untuk menjalankan

### Langkah 2: Buat Database Baru

**Masih di tab SQL yang sama, copy dan paste SQL berikut:**

```sql
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Atau gunakan SQL lengkap (hapus dan buat sekaligus):**

```sql
DROP DATABASE IF EXISTS nurani;
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

5. **Klik "Go"** untuk menjalankan

### Langkah 3: Jalankan Migrations

**Setelah database dibuat, buka PowerShell:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

### Langkah 4: Masukkan Data Guru

**Setelah migrations selesai, jalankan seeder:**

```powershell
php artisan db:seed --class=UserSeeder
```

**Atau double-click:** `MASUKKAN_DATA_GURU.bat`

---

## 📋 CARA LEBIH MUDAH: Gunakan File SQL

1. **Buka file:** `HAPUS_DAN_BUAT_DATABASE_BARU.sql`
2. **Copy semua isinya**
3. **Paste di phpMyAdmin SQL tab**
4. **Klik "Go"**

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

## ✅ SETELAH DATABASE DIBUAT

1. **Jalankan migrations** untuk membuat tabel
2. **Jalankan seeder** untuk memasukkan data guru
3. **Cek di phpMyAdmin** apakah tabel dan data sudah ada
4. **Test login** di aplikasi

---

## 🎯 REKOMENDASI

**Gunakan SQL lengkap untuk hapus dan buat sekaligus:**

```sql
DROP DATABASE IF EXISTS nurani;
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Setelah itu, jalankan migrations dan seeder!**

---

**Ikuti langkah di atas untuk mengatasi error! 🚀**
