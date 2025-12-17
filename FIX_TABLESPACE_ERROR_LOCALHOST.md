# 🔧 Fix Tablespace Error di Localhost

## ❌ MASALAH

**Error yang muncul:**
```
SQLSTATE[HY000]: General error: 1813 Tablespace for table '`nurani`.`migrations`' exists. Please DISCARD the tablespace before IMPORT
```

**Artinya:**
- Tabel `migrations` memiliki masalah tablespace
- File tablespace masih ada tapi tabel tidak terdeteksi
- Perlu fix tablespace atau hapus tabel yang bermasalah

---

## ✅ SOLUSI: Fix Tablespace Error

### Langkah 1: Buka phpMyAdmin

1. **Buka browser** → `http://localhost/phpmyadmin`
2. **Pilih database `nurani`** di sidebar kiri

---

### Langkah 2: Hapus Tabel migrations yang Bermasalah

**Di phpMyAdmin:**

1. **Klik tab "SQL"** di bagian atas
2. **Jalankan query berikut:**
   ```sql
   DROP TABLE IF EXISTS migrations;
   ```
3. **Klik "Go"** atau tekan Enter

**Atau via terminal:**
```powershell
php artisan tinker
```
Lalu di tinker:
```php
DB::statement('DROP TABLE IF EXISTS migrations;');
exit
```

---

### Langkah 3: Hapus File Tablespace (Jika Perlu)

**Jika masih error, hapus file tablespace manual:**

1. **Stop MySQL** di XAMPP Control Panel
2. **Buka folder:** `C:\xampp\mysql\data\nurani\`
3. **Hapus file:**
   - `migrations.ibd` (jika ada)
   - `migrations.frm` (jika ada)
4. **Start MySQL** lagi di XAMPP

---

### Langkah 4: Jalankan Migrations Lagi

**Setelah fix tablespace, jalankan migrations:**

```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate
```

**Tunggu sampai migrations selesai!**

---

## 📋 CHECKLIST

### ✅ Langkah 1: Fix Tablespace
- [ ] Buka phpMyAdmin
- [ ] Pilih database `nurani`
- [ ] Jalankan `DROP TABLE IF EXISTS migrations;`

### ✅ Langkah 2: Hapus File Tablespace (Jika Perlu)
- [ ] Stop MySQL di XAMPP
- [ ] Hapus file `migrations.ibd` dan `migrations.frm`
- [ ] Start MySQL lagi

### ✅ Langkah 3: Jalankan Migrations
- [ ] Jalankan `php artisan migrate`
- [ ] Migrations selesai tanpa error
- [ ] Tabel `users` dan tabel lain terbuat

---

## 🆘 JIKA MASIH ERROR

### Error: "Table still exists"
**Solusi:**
- Cek di phpMyAdmin apakah tabel `migrations` masih ada
- Jika ada, hapus manual di phpMyAdmin
- Atau gunakan `DROP TABLE migrations;` di SQL tab

### Error: "File not found"
**Solusi:**
- File sudah terhapus, lanjutkan ke langkah 4
- Jalankan migrations

---

## 💡 TIPS

1. **Backup database** sebelum hapus tabel jika perlu
2. **Pastikan MySQL berjalan** sebelum jalankan migrations
3. **Cek `.env` file** untuk konfigurasi database yang benar

---

**Fix tablespace error dulu, lalu jalankan migrations! 🚀**
