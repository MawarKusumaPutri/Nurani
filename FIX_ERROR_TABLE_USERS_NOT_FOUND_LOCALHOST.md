# 🔧 Fix Error: Table 'nurani.users' doesn't exist (Localhost)

## ❌ MASALAH

**Error yang muncul:**
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'nurani.users' doesn't exist
```

**Artinya:**
- Tabel `users` belum ada di database lokal (XAMPP)
- Migrations belum dijalankan di localhost
- Perlu jalankan migrations untuk membuat semua tabel

---

## ✅ SOLUSI: Jalankan Migrations di Localhost

### Langkah 1: Pastikan MySQL Berjalan

1. **Buka XAMPP Control Panel**
2. **Start MySQL** (klik "Start" di baris MySQL)
3. **Pastikan status "Running"** (hijau)

---

### Langkah 2: Pastikan Database Ada

**Buka phpMyAdmin:**
1. Buka browser → `http://localhost/phpmyadmin`
2. **Cek apakah database `nurani` ada**
3. **Jika belum ada**, buat database:
   - Klik "New" di sidebar kiri
   - Nama database: `nurani`
   - Collation: `utf8mb4_unicode_ci`
   - Klik "Create"

---

### Langkah 3: Jalankan Migrations

**Buka PowerShell/Command Prompt di folder project:**

```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate
```

**Atau jika ada error, gunakan `--force`:**
```powershell
php artisan migrate --force
```

**Tunggu sampai migrations selesai!**

**Output yang diharapkan:**
```
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table
Migrating: 2025_10_17_150326_add_role_to_users_table
Migrated:  2025_10_17_150326_add_role_to_users_table
...
```

---

### Langkah 4: Verifikasi Tabel Terbuat

**Buka phpMyAdmin:**
1. Pilih database `nurani`
2. **Cek apakah tabel `users` ada**
3. **Cek apakah kolom `role` ada** di tabel `users`

---

## 📋 CHECKLIST

### ✅ Langkah 1: Setup Database
- [ ] MySQL berjalan di XAMPP
- [ ] Database `nurani` ada
- [ ] Database `nurani` dipilih

### ✅ Langkah 2: Jalankan Migrations
- [ ] Buka terminal di folder project
- [ ] Jalankan `php artisan migrate`
- [ ] Migrations selesai tanpa error

### ✅ Langkah 3: Verifikasi
- [ ] Tabel `users` ada di database
- [ ] Kolom `role` ada di tabel `users`
- [ ] Test login di browser

---

## 🆘 JIKA ADA ERROR

### Error: "SQLSTATE[HY000] [1049] Unknown database 'nurani'"
**Solusi:**
- Buat database `nurani` di phpMyAdmin
- Atau edit `.env` untuk ubah nama database

### Error: "SQLSTATE[HY000] [2002] Connection refused"
**Solusi:**
- Pastikan MySQL berjalan di XAMPP
- Cek port MySQL (default: 3306)
- Cek `.env` file untuk konfigurasi database

### Error: "Migration table not found"
**Solusi:**
- Normal, migrations akan membuat tabel sendiri
- Lanjutkan dengan `php artisan migrate`

### Error: "Table already exists"
**Solusi:**
- Gunakan `php artisan migrate:fresh` (HATI-HATI: akan hapus semua data!)
- Atau `php artisan migrate:refresh` (akan rollback dan migrate lagi)

---

## 💡 TIPS

1. **Jangan jalankan `migrate:fresh`** jika sudah ada data penting
2. **Backup database** sebelum migrate jika perlu
3. **Cek `.env` file** untuk konfigurasi database yang benar

---

## 🎯 SETELAH MIGRATIONS SELESAI

1. **Refresh browser** (F5)
2. **Coba login lagi**
3. **Jika login berhasil** = SELESAI! ✅

---

**Jalankan migrations di localhost untuk membuat tabel `users`! 🚀**
