# ✅ Cara Pulihkan Data Database yang Terhapus

## ❌ MASALAH

**Database `nurani` sudah dihapus dan sekarang kosong (No tables found).**

**Data yang sudah dibuat sebelumnya hilang.**

---

## ✅ SOLUSI: Pulihkan Data dari Railway (Jika Ada)

### Cara 1: Export Data dari Railway Database

**Jika data masih ada di Railway, kita bisa export dari sana:**

#### Langkah 1: Cek Data di Railway

1. **Buka Railway Dashboard** → [railway.app](https://railway.app)
2. **Pilih project "TMS Nurani"**
3. **Klik service "MySQL"** (database service)
4. **Klik tab "Data"** atau "Connect" untuk melihat data

#### Langkah 2: Export Database dari Railway

**Opsi A: Via Railway Dashboard (Jika Ada)**

1. **Railway Dashboard** → service "MySQL"
2. **Cari tombol "Export"** atau "Download" database
3. **Download file SQL backup**

**Opsi B: Via Railway CLI**

1. **Buka PowerShell:**
   ```powershell
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   railway link
   ```

2. **Export database:**
   ```powershell
   railway run mysqldump -u ${{MySQL.MYSQLUSER}} -p${{MySQL.MYSQLPASSWORD}} -h ${{MySQL.MYSQLHOST}} -P ${{MySQL.MYSQLPORT}} ${{MySQL.MYSQLDATABASE}} > backup_railway.sql
   ```

3. **Atau gunakan connection string dari Railway:**
   - Railway Dashboard → service "MySQL" → tab "Variables"
   - Copy connection string atau credentials
   - Export via MySQL client

#### Langkah 3: Import ke Localhost

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik database "nurani"** di sidebar kiri
3. **Klik tab "Import"** di bagian atas
4. **Klik "Choose File"** dan pilih file backup dari Railway
5. **Klik "Go"** untuk import data

---

### Cara 2: Restore dari Backup Manual (Jika Ada)

**Jika Anda punya backup manual sebelumnya:**

#### Langkah 1: Cari File Backup

**Cek di folder berikut:**
- Desktop
- Documents
- Folder project
- Atau folder backup lainnya

**File backup biasanya berformat:**
- `nurani_backup_*.sql`
- `backup_*.sql`
- `nurani_*.sql`

#### Langkah 2: Import Backup

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik database "nurani"** di sidebar kiri
3. **Klik tab "Import"** di bagian atas
4. **Klik "Choose File"** dan pilih file backup
5. **Klik "Go"** untuk import data

---

### Cara 3: Re-create Data Manual (Jika Tidak Ada Backup)

**Jika tidak ada backup sama sekali, data harus dibuat ulang:**

#### Langkah 1: Jalankan Migrations

**Ini akan membuat struktur tabel:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

#### Langkah 2: Buat Data Manual

**Setelah migrations selesai, buat data manual:**

1. **Buka aplikasi** → `http://localhost/nurani/public/`
2. **Buat user baru** via form registrasi atau admin panel
3. **Input data lain** yang diperlukan

---

## 🆘 JIKA TIDAK ADA BACKUP

### Opsi 1: Cek Railway Database

**Data mungkin masih ada di Railway:**

1. **Buka Railway Dashboard** → service "MySQL"
2. **Cek apakah ada data di database Railway**
3. **Jika ada, export dari Railway** (Cara 1)

### Opsi 2: Cek File Backup Lain

**Cek folder berikut untuk file backup:**
- `D:\Praktikum DWBI\xampp\htdocs\nurani\backup\`
- Desktop
- Documents
- Folder project lainnya

### Opsi 3: Re-create Data

**Jika benar-benar tidak ada backup:**
- Jalankan migrations untuk buat struktur tabel
- Buat data manual via aplikasi

---

## 📋 CHECKLIST

### ✅ Cek Backup:
- [ ] Cek Railway database (apakah ada data?)
- [ ] Cek folder backup di project
- [ ] Cek Desktop/Documents untuk file backup
- [ ] Cek folder lain yang mungkin ada backup

### ✅ Restore Data:
- [ ] Export dari Railway (jika ada data)
- [ ] Atau import dari backup manual
- [ ] Atau re-create data manual

---

## 💡 TIPS

1. **Cek Railway dulu** - Data mungkin masih ada di production
2. **Cek semua folder** - Backup mungkin tersimpan di tempat lain
3. **Jika tidak ada backup** - Data harus dibuat ulang manual
4. **Untuk ke depan** - Buat backup rutin sebelum hapus database

---

## 🎯 REKOMENDASI

**Langkah 1: Cek Railway Database**

**Data mungkin masih ada di Railway! Cek dulu sebelum membuat ulang.**

**Langkah 2: Jika Ada di Railway, Export dan Import ke Localhost**

**Langkah 3: Jika Tidak Ada, Re-create Data Manual**

---

**Cek Railway database dulu! Data mungkin masih ada di sana! 🚀**
