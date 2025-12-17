# ✅ Solusi Tablespace Error - FINAL

## 🎯 MASALAH

**Error yang terus muncul:**
- `Tablespace for table 'migrations' exists`
- `Error dropping database (can't rmdir '.\nurani', errno: 41 "Directory not empty")`
- `Can't create database 'nurani'; database exists`

**Penyebab:** File tablespace masih ada di filesystem meskipun database sudah di-drop via SQL.

---

## ✅ SOLUSI FINAL: Hapus Folder Database Secara Manual

### Cara 1: Manual (Paling Pasti)

#### Langkah 1: Stop MySQL
1. **Buka XAMPP Control Panel**
2. **Klik "Stop" pada MySQL**
3. **Tunggu sampai MySQL benar-benar berhenti**

#### Langkah 2: Hapus Folder Database
1. **Buka File Explorer**
2. **Navigasi ke salah satu lokasi:**
   - `C:\xampp\mysql\data\nurani`
   - `D:\xampp\mysql\data\nurani`
3. **Hapus folder `nurani`** (klik kanan → Delete)

#### Langkah 3: Start MySQL
1. **Buka XAMPP Control Panel**
2. **Klik "Start" pada MySQL**

#### Langkah 4: Buat Database Baru
**Buka phpMyAdmin** → Tab SQL:

```sql
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Langkah 5: Jalankan Migrations
```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

#### Langkah 6: Masukkan Data Guru
```powershell
php artisan db:seed --class=UserSeeder
```

---

### Cara 2: Gunakan Script (Lebih Mudah)

**Double-click:** `HAPUS_DATABASE_PASTI_BERHASIL.bat`

**Script akan memandu Anda step-by-step.**

---

## 🔍 CARA CEK LOKASI FOLDER DATABASE

**Jika tidak tahu lokasi folder database:**

1. **Buka XAMPP Control Panel**
2. **Klik "Config" pada MySQL**
3. **Pilih "my.ini"**
4. **Cari baris `datadir`**
5. **Lokasi folder database ada di sana**

**Atau cek di lokasi standar:**
- `C:\xampp\mysql\data\`
- `D:\xampp\mysql\data\`

---

## ⚠️ PERINGATAN

**Sebelum menghapus folder database:**
- ✅ Pastikan MySQL sudah STOP
- ✅ Pastikan tidak ada data penting
- ✅ Atau sudah di-backup

**Jika MySQL masih berjalan, folder mungkin tidak bisa dihapus!**

---

## ✅ SETELAH SELESAI

1. **Refresh phpMyAdmin** (F5)
2. **Klik database "nurani"** → semua tabel sudah dibuat
3. **Klik tabel "users"** → 13 guru sudah ada
4. **Test login** di aplikasi

---

## 🎯 REKOMENDASI

**Gunakan cara manual (Cara 1) untuk hasil yang paling pasti!**

**Atau gunakan script `HAPUS_DATABASE_PASTI_BERHASIL.bat` untuk lebih mudah!**

---

**Ikuti langkah di atas untuk mengatasi error tablespace! 🚀**
