# ✅ Cara Buat Database dari Awal - AMAN

## 🎯 TUJUAN

**Membuat database dari awal dengan aman, termasuk backup data lama jika ada.**

---

## ⚠️ APAKAH AMAN?

### ✅ **AMAN jika:**
- Database masih kosong atau tidak ada data penting
- Data yang ada hanya data testing/dummy
- Anda sudah siap kehilangan data yang ada
- Anda sudah backup data penting sebelumnya

### ⚠️ **TIDAK AMAN jika:**
- Ada data penting yang belum di-backup
- Ada data produksi yang aktif digunakan
- Ada data yang tidak bisa dibuat ulang

---

## ✅ CARA AMAN: Gunakan Script Backup Otomatis

### Langkah 1: Jalankan Script Backup & Buat Database Baru

**Double-click file:** `BACKUP_DAN_BUAT_DATABASE_BARU.bat`

**Script akan otomatis:**
1. ✅ Cek apakah ada data di database
2. ✅ Backup database lama (jika ada data) → disimpan di folder `backup/`
3. ✅ Hapus database lama
4. ✅ Buat database baru
5. ✅ Jalankan migrations (membuat semua tabel)
6. ✅ Tambah data guru

---

## 📋 APA YANG TERJADI?

### 1. **Backup Otomatis**
- Jika ada data, script akan membuat backup otomatis
- Backup disimpan di: `backup/nurani_backup_YYYY-MM-DD_HH-MM-SS.sql`
- File backup bisa digunakan untuk restore jika diperlukan

### 2. **Database Lama Dihapus**
- Semua tabel dan data di database lama akan dihapus
- File tablespace yang corrupt juga akan terhapus

### 3. **Database Baru Dibuat**
- Database baru dibuat dengan nama yang sama (`nurani`)
- Character set: `utf8mb4`
- Collation: `utf8mb4_unicode_ci`

### 4. **Migrations Dijalankan**
- Semua migrations dari folder `database/migrations` dijalankan
- Semua tabel dibuat dari awal

### 5. **Data Guru Ditambahkan**
- Data guru dari `UserSeeder` ditambahkan
- Password sesuai `LOGIN_CREDENTIALS.md`

---

## 🔄 RESTORE BACKUP (Jika Perlu)

### Jika perlu restore data lama:

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik tab "SQL"**
3. **Buka file backup** di folder `backup/`
4. **Copy isi file backup** dan paste di phpMyAdmin SQL tab
5. **Klik "Go"** untuk menjalankan

**Atau gunakan command line:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
mysql -u root -p nurani < backup/nurani_backup_YYYY-MM-DD_HH-MM-SS.sql
```

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

- **Double-click:** `BACKUP_DAN_BUAT_DATABASE_BARU.bat`

---

## 📋 CHECKLIST SEBELUM MEMBUAT DATABASE BARU

### ✅ Cek Data:
- [ ] Apakah ada data penting di database?
- [ ] Apakah data sudah di-backup?
- [ ] Apakah data bisa dibuat ulang?

### ✅ Backup:
- [ ] Script akan backup otomatis jika ada data
- [ ] File backup akan disimpan di folder `backup/`
- [ ] Catat lokasi file backup jika perlu restore

### ✅ Setelah Buat Database Baru:
- [ ] Cek di phpMyAdmin apakah tabel sudah dibuat
- [ ] Cek apakah data guru sudah ada
- [ ] Test login dengan email guru
- [ ] Pastikan aplikasi berfungsi normal

---

## 💡 TIPS

1. **Gunakan script backup otomatis** - Paling aman dan mudah
2. **Simpan file backup** - Jangan hapus file backup jika ada data penting
3. **Test setelah buat database baru** - Pastikan aplikasi berfungsi
4. **Jika error tablespace** - Fix manual di phpMyAdmin sekali, lalu script otomatis bisa jalan

---

## 🎯 REKOMENDASI

**Gunakan `BACKUP_DAN_BUAT_DATABASE_BARU.bat` untuk membuat database dari awal dengan aman!**

**Script akan otomatis backup data lama jika ada, jadi Anda tidak akan kehilangan data penting!**

---

## ❓ FAQ

### Q: Apakah data lama akan hilang?
**A:** Ya, data lama akan dihapus. Tapi script akan backup otomatis jika ada data.

### Q: Bagaimana cara restore backup?
**A:** Gunakan file backup di folder `backup/` dan import ke phpMyAdmin atau via command line.

### Q: Apakah aman untuk production?
**A:** TIDAK! Script ini hanya untuk development/testing. Jangan gunakan di production tanpa backup manual terlebih dahulu.

### Q: Bagaimana jika tidak ada data di database?
**A:** Script akan skip backup dan langsung buat database baru.

---

**Gunakan script backup otomatis untuk membuat database dari awal dengan aman! 🚀**
