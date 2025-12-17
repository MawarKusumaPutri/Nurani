# ✅ Cara Buat Data Guru - PASTI BERHASIL

## 🎯 TUJUAN

**Membuat data guru di database agar bisa login.**

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

### Langkah 3: Buat Data Guru

**Masih di PowerShell yang sama:**

```powershell
php artisan db:seed --class=UserSeeder
```

**Selesai! Data guru sudah dibuat!**

---

## ✅ CARA ALTERNATIF: Menggunakan Script

1. **Pastikan MySQL sudah berjalan di XAMPP**
2. **Double-click file:** `BUAT_DATA_GURU_LANGSUNG.bat`
3. **Script akan otomatis melakukan semua langkah**

---

## 📋 DATA GURU YANG AKAN DIBUAT

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

**Password default:** `password123`

---

## 🔐 PASSWORD DEFAULT

**Password default untuk semua guru:** `password123`

**Guru bisa ubah password sendiri setelah login!**

---

## 🆘 JIKA MASIH ERROR

### Error: "Database tidak bisa dihapus"

**Solusi:**
- Hapus manual via phpMyAdmin:
  1. Buka phpMyAdmin
  2. Klik database "nurani" → tab "Operations"
  3. Scroll ke bawah → "Drop the database (DROP)"
  4. Konfirmasi

### Error: "Migrations gagal"

**Solusi:**
- Pastikan database sudah dibuat
- Cek error message untuk detail

### Error: "Seeder gagal"

**Solusi:**
- Pastikan migrations sudah jalan
- Cek apakah tabel `users` dan `gurus` sudah ada

---

## 📋 CHECKLIST

### ✅ Langkah 1: Reset Database
- [ ] Buka phpMyAdmin → tab "SQL"
- [ ] Jalankan SQL: `DROP DATABASE IF EXISTS nurani; CREATE DATABASE nurani...`
- [ ] Database sudah dibuat

### ✅ Langkah 2: Migrations
- [ ] Jalankan: `php artisan migrate --force`
- [ ] Migrations selesai tanpa error

### ✅ Langkah 3: Buat Data Guru
- [ ] Jalankan: `php artisan db:seed --class=UserSeeder`
- [ ] Data guru sudah dibuat

### ✅ Langkah 4: Test Login
- [ ] Buka aplikasi → `http://localhost/nurani/public/`
- [ ] Test login dengan email guru
- [ ] Pastikan bisa masuk ke dashboard

---

## 💡 TIPS

1. **Gunakan Cara 1 (Via phpMyAdmin SQL)** - Paling cepat dan pasti bekerja
2. **Password default:** `password123` - Guru bisa ubah sendiri
3. **Test login setelah data dibuat** - Pastikan semua guru bisa login

---

## 🎯 REKOMENDASI

**Gunakan Cara 1 (Via phpMyAdmin SQL) dulu!**

**Ini paling cepat - hanya perlu 2 baris SQL, lalu migrations dan seeder!**

---

**Ikuti langkah-langkah di atas untuk membuat data guru! 🚀**
