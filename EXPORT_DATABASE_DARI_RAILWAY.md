# ✅ Cara Export Database dari Railway

## 🎯 TUJUAN

**Export database dari Railway untuk dipulihkan ke localhost.**

---

## ✅ CARA 1: Via Railway Dashboard (Jika Ada Fitur Export)

### Langkah 1: Buka Railway Dashboard

1. **Buka Railway Dashboard** → [railway.app](https://railway.app)
2. **Login** ke akun Railway
3. **Pilih project "TMS Nurani"**
4. **Klik service "MySQL"** (database service)

### Langkah 2: Export Database

1. **Cari tombol "Export"** atau "Download" atau "Backup"**
2. **Klik tombol tersebut**
3. **Download file SQL backup**

**Jika tidak ada tombol export, gunakan Cara 2.**

---

## ✅ CARA 2: Via Railway CLI (RECOMMENDED!)

### Langkah 1: Install Railway CLI (Jika Belum)

```powershell
npm install -g @railway/cli
```

### Langkah 2: Login Railway CLI

```powershell
railway login
```

### Langkah 3: Link Project

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
railway link
```

**Pilih:**
- Project: TMS Nurani
- Environment: production
- Service: MySQL (database service)

### Langkah 4: Export Database

```powershell
railway run mysqldump -u ${{MySQL.MYSQLUSER}} -p${{MySQL.MYSQLPASSWORD}} -h ${{MySQL.MYSQLHOST}} -P ${{MySQL.MYSQLPORT}} ${{MySQL.MYSQLDATABASE}} > backup_railway.sql
```

**Atau gunakan command yang lebih sederhana:**

```powershell
railway run mysqldump nurani > backup_railway.sql
```

**File backup akan tersimpan di:** `D:\Praktikum DWBI\xampp\htdocs\nurani\backup_railway.sql`

---

## ✅ CARA 3: Via MySQL Client (Jika Railway CLI Error)

### Langkah 1: Dapatkan Connection String

1. **Railway Dashboard** → service "MySQL" → tab "Variables"
2. **Copy nilai berikut:**
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`
   - `MYSQLDATABASE`

### Langkah 2: Export via MySQL Client

**Buka PowerShell:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
```

**Export database (ganti dengan nilai dari Railway):**

```powershell
"C:\xampp\mysql\bin\mysqldump.exe" -u [MYSQLUSER] -p[MYSQLPASSWORD] -h [MYSQLHOST] -P [MYSQLPORT] [MYSQLDATABASE] > backup_railway.sql
```

**Contoh (ganti dengan nilai sebenarnya):**

```powershell
"C:\xampp\mysql\bin\mysqldump.exe" -u root -pmypassword -h mysql.railway.internal -P 3306 nurani > backup_railway.sql
```

---

## ✅ CARA 4: Import ke Localhost

### Langkah 1: Pastikan Database Local Sudah Ada

**Jika belum ada, buat dulu:**

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik "New"** → Database name: `nurani` → Collation: `utf8mb4_unicode_ci` → "Create"

### Langkah 2: Import Backup

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik database "nurani"** di sidebar kiri
3. **Klik tab "Import"** di bagian atas
4. **Klik "Choose File"** dan pilih file `backup_railway.sql`
5. **Klik "Go"** untuk import data

**Tunggu sampai import selesai!**

---

## 🆘 JIKA MASIH ERROR

### Error: "Railway CLI tidak bisa connect"

**Solusi:**
- Pastikan sudah login: `railway login`
- Pastikan sudah link: `railway link`
- Cek environment variables di Railway Dashboard

### Error: "File backup tidak bisa diimport"

**Solusi:**
- Pastikan file backup valid (format SQL)
- Cek ukuran file (jika terlalu besar, import via command line)
- Atau import via MySQL command line:

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
"C:\xampp\mysql\bin\mysql.exe" -u root nurani < backup_railway.sql
```

---

## 📋 CHECKLIST

### ✅ Export dari Railway:
- [ ] Login Railway Dashboard
- [ ] Cek service "MySQL" untuk data
- [ ] Export via Railway CLI atau MySQL client
- [ ] File backup tersimpan di project folder

### ✅ Import ke Localhost:
- [ ] Database 'nurani' sudah ada di localhost
- [ ] Import file backup via phpMyAdmin
- [ ] Atau import via MySQL command line
- [ ] Cek data sudah ter-import dengan benar

---

## 💡 TIPS

1. **Gunakan Cara 2 (Railway CLI)** - Paling mudah dan reliable
2. **Pastikan database local sudah ada** sebelum import
3. **Cek ukuran file backup** - jika terlalu besar, import via command line
4. **Backup dulu sebelum import** - untuk jaga-jaga

---

## 🎯 REKOMENDASI

**Gunakan Cara 2 (Railway CLI) untuk export!**

**Ini paling mudah dan pasti bekerja.**

**Setelah export, import ke localhost via phpMyAdmin!**

---

**Export dari Railway dulu! Data mungkin masih ada di sana! 🚀**
