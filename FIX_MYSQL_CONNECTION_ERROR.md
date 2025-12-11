# 🔧 Fix: MySQL Connection Error - "Connection Refused"

## ❌ ERROR YANG TERJADI

```
SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it
Connection: mysql
```

**Penyebab:** MySQL server tidak berjalan atau tidak bisa diakses.

---

## ✅ SOLUSI CEPAT (2 MENIT)

### Step 1: Start MySQL di XAMPP

1. **Buka XAMPP Control Panel**
2. **Cari MySQL** di daftar modules
3. **Klik tombol "Start"** di sebelah MySQL
4. **Tunggu sampai status berubah menjadi "Running"** (hijau)
5. **Pastikan Port menunjukkan 3306**

### Step 2: Verifikasi MySQL Running

**Cek di XAMPP Control Panel:**
- MySQL harus menunjukkan **"Stop"** button (artinya running)
- Port harus menunjukkan **3306**
- Tidak ada error merah di log

### Step 3: Refresh Browser

1. **Refresh halaman login** (F5)
2. **Coba login lagi**

**Error harusnya sudah hilang!**

---

## 🐛 JIKA MYSQL TIDAK BISA START

### Masalah 1: Port 3306 Sudah Dipakai

**Solusi:**
1. **Buka Command Prompt sebagai Admin**
2. **Jalankan:**
   ```cmd
   netstat -ano | findstr :3306
   ```
3. **Cari PID yang menggunakan port 3306**
4. **Buka Task Manager** (Ctrl + Shift + Esc)
5. **End Task** proses tersebut
6. **Start MySQL lagi di XAMPP**

### Masalah 2: MySQL Service Crash

**Solusi:**
1. **Stop MySQL** di XAMPP
2. **Tunggu 10 detik**
3. **Start MySQL lagi**
4. **Jika masih error, restart komputer**

### Masalah 3: MySQL Data Corrupt

**Solusi:**
1. **Stop MySQL** di XAMPP
2. **Backup database** (jika penting):
   - Buka phpMyAdmin: `http://localhost/phpmyadmin`
   - Export database `nurani`
3. **Hapus file di:**
   ```
   D:\Praktikum DWBI\xampp\mysql\data\mysql\
   ```
   **HATI-HATI:** Hanya hapus file di folder `mysql`, jangan hapus database `nurani`!
4. **Start MySQL lagi**

---

## 🔍 VERIFIKASI KONFIGURASI DATABASE

### Cek File .env

**Buka file:**
```
D:\Praktikum DWBI\xampp\htdocs\nurani\.env
```

**Pastikan konfigurasi database benar:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nurani
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:**
- `DB_HOST=127.0.0.1` atau `localhost` (untuk XAMPP)
- `DB_PORT=3306` (port default MySQL)
- `DB_DATABASE=nurani` (sesuaikan dengan nama database Anda)
- `DB_USERNAME=root` (default XAMPP)
- `DB_PASSWORD=` (kosong untuk XAMPP default)

### Clear Cache Setelah Ubah .env

```bash
cd D:\Praktikum DWBI\xampp\htdocs\nurani
php artisan config:clear
php artisan cache:clear
```

---

## ✅ CHECKLIST PERBAIKAN

- [ ] MySQL running di XAMPP (status hijau)
- [ ] Port MySQL = 3306
- [ ] Konfigurasi `.env` benar
- [ ] Clear cache Laravel
- [ ] Refresh browser
- [ ] Test login

---

## 🚀 LANGKAH LENGKAP (Jika Masih Error)

### 1. Restart MySQL

1. **XAMPP Control Panel**
2. **Stop MySQL**
3. **Tunggu 5 detik**
4. **Start MySQL**
5. **Tunggu sampai status hijau**

### 2. Test Koneksi MySQL

**Buka browser:**
```
http://localhost/phpmyadmin
```

**Jika bisa buka phpMyAdmin:**
→ MySQL running dengan benar ✅

**Jika tidak bisa buka:**
→ MySQL tidak running ❌

### 3. Cek Database Ada

**Di phpMyAdmin:**
1. **Cek sidebar kiri**
2. **Pastikan database `nurani` ada**
3. **Jika belum ada, buat database baru:**
   - Klik "New"
   - Nama: `nurani`
   - Collation: `utf8mb4_unicode_ci`
   - Klik "Create"

### 4. Run Migrations

**Jika database kosong, jalankan migration:**
```bash
cd D:\Praktikum DWBI\xampp\htdocs\nurani
php artisan migrate
```

### 5. Clear Cache

```bash
php artisan optimize:clear
```

### 6. Test Login

**Buka:**
```
http://localhost/nurani/public/login
```

**Login harusnya berhasil!**

---

## 📞 JIKA MASIH ERROR

**Kirim informasi ini:**
1. Screenshot XAMPP Control Panel (tunjukkan status MySQL)
2. Screenshot error message lengkap
3. Isi file `.env` (bagian database saja)

---

**Selamat! Error harusnya sudah teratasi! 🎉**

