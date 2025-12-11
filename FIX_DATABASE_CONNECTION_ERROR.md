# 🔧 Fix Error: Database Connection Refused

## ❌ Error yang Terjadi

```
SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it
Connection: mysql
```

**Penyebab:** MySQL server tidak berjalan atau konfigurasi database salah.

---

## ✅ SOLUSI 1: Nyalakan MySQL di XAMPP (Paling Umum)

### Langkah-langkah:

1. **Buka XAMPP Control Panel**
   - Cari "XAMPP Control Panel" di Start Menu
   - Atau buka dari folder XAMPP

2. **Start MySQL Service**
   - Di XAMPP Control Panel, cari **MySQL**
   - Klik tombol **"Start"** (harus berubah jadi "Stop")
   - Status harus berubah menjadi **"Running"** (hijau)

3. **Verifikasi MySQL Berjalan**
   - Pastikan ada tanda centang hijau di sebelah MySQL
   - Port harus menunjukkan **3306**

4. **Refresh Browser**
   - Buka kembali halaman yang error
   - Error harus sudah hilang

---

## ✅ SOLUSI 2: Cek Konfigurasi Database di .env

### Langkah-langkah:

1. **Buka file `.env`** di root project
   - Path: `D:\Praktikum DWBI\xampp\htdocs\nurani\.env`

2. **Cek dan Pastikan Konfigurasi Database:**

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nurani
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   **Penjelasan:**
   - `DB_HOST=127.0.0.1` atau `localhost` (untuk XAMPP)
   - `DB_PORT=3306` (port default MySQL)
   - `DB_DATABASE=nurani` (nama database Anda, sesuaikan)
   - `DB_USERNAME=root` (default XAMPP)
   - `DB_PASSWORD=` (kosong untuk XAMPP default)

3. **Jika Ada Perubahan, Clear Cache:**

   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

---

## ✅ SOLUSI 3: Cek Database Apakah Sudah Ada

### Langkah-langkah:

1. **Buka phpMyAdmin**
   - Buka browser
   - Ketik: `http://localhost/phpmyadmin`
   - Login (biasanya username: `root`, password: kosong)

2. **Cek Database**
   - Di sidebar kiri, cek apakah database `nurani` sudah ada
   - Jika belum ada, buat database baru:
     - Klik "New" di sidebar
     - Nama database: `nurani`
     - Collation: `utf8mb4_unicode_ci`
     - Klik "Create"

3. **Cek Tabel**
   - Klik database `nurani`
   - Pastikan tabel-tabel sudah ada (users, dll)
   - Jika belum ada, jalankan migration:
     ```bash
     php artisan migrate
     ```

---

## ✅ SOLUSI 4: Cek Port MySQL

### Jika Port 3306 Sudah Dipakai:

1. **Cek Port di XAMPP**
   - Buka XAMPP Control Panel
   - Klik "Config" di sebelah MySQL
   - Pilih "my.ini"
   - Cari `port=3306`
   - Jika berbeda, catat port-nya

2. **Update .env**
   ```env
   DB_PORT=3306  # Ganti dengan port yang benar
   ```

3. **Clear Cache**
   ```bash
   php artisan config:clear
   ```

---

## ✅ SOLUSI 5: Restart XAMPP Services

### Jika Masih Error:

1. **Stop Semua Services**
   - Di XAMPP Control Panel
   - Klik "Stop" untuk Apache dan MySQL

2. **Tunggu 5 Detik**

3. **Start Kembali**
   - Start MySQL dulu
   - Lalu start Apache

4. **Test Koneksi**
   - Buka `http://localhost/nurani/public/forgot-password`
   - Error harus sudah hilang

---

## 🔍 TROUBLESHOOTING LANJUTAN

### Error: "Port 3306 already in use"

**Solusi:**
1. Buka Task Manager (Ctrl + Shift + Esc)
2. Cari proses "mysqld.exe" atau "MySQL"
3. End process
4. Start MySQL di XAMPP lagi

### Error: "Access denied for user 'root'@'localhost'"

**Solusi:**
1. Buka phpMyAdmin
2. Cek user `root` dan password-nya
3. Update `.env` dengan password yang benar:
   ```env
   DB_PASSWORD=password_anda
   ```

### Error: "Unknown database 'nurani'"

**Solusi:**
1. Buat database di phpMyAdmin
2. Atau update nama database di `.env` sesuai yang ada

---

## 📋 CHECKLIST PERBAIKAN

Ikuti checklist ini secara berurutan:

- [ ] **1. MySQL Service Running**
  - [ ] Buka XAMPP Control Panel
  - [ ] MySQL status = "Running" (hijau)
  - [ ] Port = 3306

- [ ] **2. Konfigurasi .env Benar**
  - [ ] `DB_HOST=127.0.0.1` atau `localhost`
  - [ ] `DB_PORT=3306`
  - [ ] `DB_DATABASE=nurani` (sesuai database Anda)
  - [ ] `DB_USERNAME=root`
  - [ ] `DB_PASSWORD=` (kosong atau sesuai)

- [ ] **3. Database Sudah Ada**
  - [ ] Buka phpMyAdmin
  - [ ] Database `nurani` ada
  - [ ] Tabel-tabel sudah ada (jika belum, jalankan `php artisan migrate`)

- [ ] **4. Clear Cache**
  - [ ] Jalankan `php artisan config:clear`
  - [ ] Jalankan `php artisan cache:clear`

- [ ] **5. Test Koneksi**
  - [ ] Refresh browser
  - [ ] Error harus sudah hilang

---

## 🚀 QUICK FIX (Coba Ini Dulu!)

**Jika terburu-buru, coba langkah cepat ini:**

1. **Buka XAMPP Control Panel**
2. **Klik "Start" di MySQL** (jika belum running)
3. **Tunggu sampai status hijau**
4. **Refresh browser**

**90% kasus error ini karena MySQL tidak running!**

---

## 📞 Jika Masih Error

Jika semua langkah di atas sudah dicoba tapi masih error:

1. **Cek Error Log**
   - Buka `storage/logs/laravel.log`
   - Cari error terbaru
   - Baca detail errornya

2. **Test Koneksi Manual**
   - Buka Command Prompt
   - Jalankan:
     ```bash
     mysql -u root -h 127.0.0.1 -P 3306
     ```
   - Jika bisa connect, berarti MySQL OK
   - Jika tidak bisa, berarti MySQL belum running

3. **Cek Firewall**
   - Pastikan Windows Firewall tidak memblokir MySQL
   - Atau matikan sementara untuk test

---

## ✅ SETELAN .env YANG BENAR UNTUK XAMPP

```env
APP_NAME="Nurani TMS"
APP_ENV=local
APP_KEY=base64:... (harus sudah di-generate)
APP_DEBUG=true
APP_URL=http://localhost/nurani/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nurani
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

---

**Selamat! Error harusnya sudah teratasi! 🎉**

Jika masih ada masalah, kirim screenshot error terbaru atau detail error dari `storage/logs/laravel.log`.

