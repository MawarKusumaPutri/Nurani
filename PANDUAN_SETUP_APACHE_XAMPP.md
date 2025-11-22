# 🚀 Panduan Setup Laravel dengan Apache XAMPP (Domain Lokal)

Panduan lengkap untuk menjalankan project Laravel menggunakan Apache XAMPP dengan domain lokal seperti `http://nurani.test` tanpa port.

---

## 📋 Daftar Isi

1. [Persiapan](#1-persiapan)
2. [Memindahkan Project ke htdocs](#2-memindahkan-project-ke-htdocs)
3. [Membuat VirtualHost Apache](#3-membuat-virtualhost-apache)
4. [Mengedit File Hosts Windows](#4-mengedit-file-hosts-windows)
5. [Konfigurasi .htaccess](#5-konfigurasi-htaccess)
6. [Mengatur Environment](#6-mengatur-environment)
7. [Testing dan Troubleshooting](#7-testing-dan-troubleshooting)

---

## 1. Persiapan

### ✅ Pastikan XAMPP Sudah Terinstall

1. Download dan install XAMPP dari: https://www.apachefriends.org/
2. Pastikan Apache dan MySQL berjalan di XAMPP Control Panel
3. Catat lokasi folder XAMPP (biasanya: `C:\xampp`)

### ✅ Pastikan Mod Apache Aktif

Mod-mod berikut harus aktif di Apache:
- `mod_rewrite`
- `mod_ssl` (opsional)

**Cara cek:**
1. Buka XAMPP Control Panel
2. Klik "Config" di Apache → "httpd.conf"
3. Cari dan pastikan tidak ada tanda `#` di depan:
   ```apache
   LoadModule rewrite_module modules/mod_rewrite.so
   ```

---

## 2. Memindahkan Project ke htdocs

### Langkah 1: Salin Project ke htdocs

1. Buka folder XAMPP (biasanya `C:\xampp`)
2. Buka folder `htdocs`
3. **Salin seluruh folder project Laravel** ke dalam `htdocs`

**Contoh struktur:**
```
C:\xampp\htdocs\
  └── nurani\          ← Folder project Laravel Anda
      ├── app\
      ├── bootstrap\
      ├── config\
      ├── database\
      ├── public\
      ├── resources\
      ├── routes\
      ├── storage\
      ├── vendor\
      └── ...
```

**⚠️ PENTING:** 
- Jangan pindahkan, **SALIN** saja agar backup tetap ada
- Atau jika ingin pindah, pastikan backup dulu

### Langkah 2: Verifikasi Struktur

Pastikan folder `public` ada di dalam project:
```
C:\xampp\htdocs\nurani\public\
```

---

## 3. Membuat VirtualHost Apache

### Langkah 1: Buka File httpd-vhosts.conf

1. Buka XAMPP Control Panel
2. Klik "Config" di Apache → "httpd-vhosts.conf"
3. File akan terbuka di text editor

**Lokasi file:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

### Langkah 2: Tambahkan VirtualHost

Tambahkan konfigurasi berikut di **akhir file** (setelah contoh yang ada):

```apache
# VirtualHost untuk Laravel Nurani
<VirtualHost *:80>
    ServerName nurani.test
    ServerAlias www.nurani.test
    DocumentRoot "C:/xampp/htdocs/nurani/public"
    
    <Directory "C:/xampp/htdocs/nurani/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # Error dan Access Log (opsional)
    ErrorLog "C:/xampp/apache/logs/nurani_error.log"
    CustomLog "C:/xampp/apache/logs/nurani_access.log" common
</VirtualHost>
```

**⚠️ CATATAN:**
- Ganti `nurani.test` dengan domain yang Anda inginkan (contoh: `rose-bakery.test`)
- Ganti `C:/xampp/htdocs/nurani/public` dengan path lengkap ke folder `public` project Anda
- Pastikan menggunakan **forward slash** (`/`) bukan backslash (`\`) di path
- Path harus **absolute** (lengkap dengan drive)

### Langkah 3: Aktifkan VirtualHost di httpd.conf

1. Buka file `httpd.conf` (Config → httpd.conf)
2. Cari baris berikut dan pastikan **tidak ada tanda `#`** di depannya:

```apache
# Virtual hosts
Include conf/extra/httpd-vhosts.conf
```

Jika ada tanda `#`, hapus tanda `#` tersebut.

### Langkah 4: Restart Apache

1. Di XAMPP Control Panel, klik "Stop" pada Apache
2. Tunggu beberapa detik
3. Klik "Start" pada Apache
4. Pastikan status berubah menjadi "Running" (hijau)

---

## 4. Mengedit File Hosts Windows

### Langkah 1: Buka File Hosts sebagai Administrator

1. Tekan `Windows + R`
2. Ketik: `notepad` dan tekan `Ctrl + Shift + Enter` (untuk run as admin)
   - Atau cari "Notepad" di Start Menu → Klik kanan → "Run as administrator"

### Langkah 2: Buka File Hosts

1. Di Notepad, klik **File → Open**
2. Navigasi ke: `C:\Windows\System32\drivers\etc\`
3. Di dropdown "File type", pilih **"All Files (*.*)"**
4. Pilih file **`hosts`** (tanpa ekstensi)
5. Klik "Open"

### Langkah 3: Tambahkan Domain

Tambahkan baris berikut di **akhir file**:

```
127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

**Contoh file hosts setelah ditambahkan:**
```
# Copyright (c) 1993-2009 Microsoft Corp.
#
# This is a sample HOSTS file used by Microsoft TCP/IP for Windows.
#
# This file contains the mappings of IP addresses to host names. Each
# entry should be kept on an individual line. The IP address should
# be placed in the first column followed by the corresponding host name.
# The IP address and the host name should be separated by at least one
# space.
#
# Additionally, comments (such as these) may be inserted on individual
# lines or following the machine name denoted by a '#' symbol.
#
# For example:
#
#      102.54.94.97     rhino.acme.com          # source server
#       38.25.63.10     x.acme.com              # x client host

# localhost name resolution is handled within DNS itself.
#	127.0.0.1       localhost
#	::1             localhost

127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

### Langkah 4: Simpan File

1. Klik **File → Save** (atau `Ctrl + S`)
2. Jika muncul error "Access Denied", pastikan Notepad dibuka sebagai Administrator

### Langkah 5: Flush DNS Cache (Opsional)

Buka Command Prompt sebagai Administrator dan jalankan:

```cmd
ipconfig /flushdns
```

---

## 5. Konfigurasi .htaccess

### Langkah 1: Verifikasi File .htaccess di public

Pastikan file `.htaccess` ada di folder `public`:
```
C:\xampp\htdocs\nurani\public\.htaccess
```

### Langkah 2: Pastikan Isi .htaccess Benar

File `.htaccess` di folder `public` harus berisi:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**✅ File ini sudah ada dan benar di project Anda!**

### Langkah 3: Buat .htaccess di Root (Opsional)

Jika ingin mengamankan root folder, buat file `.htaccess` di root project:

**Lokasi:** `C:\xampp\htdocs\nurani\.htaccess`

**Isi:**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**⚠️ CATATAN:** File ini opsional, karena VirtualHost sudah mengarah ke folder `public`.

---

## 6. Mengatur Environment

### Langkah 1: Buka File .env

Buka file `.env` di root project:
```
C:\xampp\htdocs\nurani\.env
```

### Langkah 2: Update APP_URL

Ubah `APP_URL` sesuai domain baru:

```env
APP_URL=http://nurani.test
```

**Sebelum:**
```env
APP_URL=http://127.0.0.1:8000
```

**Sesudah:**
```env
APP_URL=http://nurani.test
```

### Langkah 3: Verifikasi Konfigurasi Database

Pastikan konfigurasi database sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nurani
DB_USERNAME=root
DB_PASSWORD=
```

**⚠️ CATATAN:** 
- Pastikan MySQL berjalan di XAMPP
- Sesuaikan nama database, username, dan password sesuai setup Anda

### Langkah 4: Clear Cache (Penting!)

Buka Command Prompt di folder project dan jalankan:

```cmd
cd C:\xampp\htdocs\nurani
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 7. Testing dan Troubleshooting

### ✅ Testing

1. **Buka Browser** (Chrome, Firefox, dll)
2. **Ketik di address bar:** `http://nurani.test`
3. **Tekan Enter**

**Hasil yang diharapkan:**
- Website Laravel muncul tanpa error
- Tidak perlu mengetik port `:8000`
- URL tetap `http://nurani.test` saat navigasi

### 🔧 Troubleshooting

#### Error 1: "This site can't be reached" atau "ERR_CONNECTION_REFUSED"

**Penyebab:** Apache tidak berjalan atau VirtualHost belum diaktifkan

**Solusi:**
1. Pastikan Apache berjalan di XAMPP Control Panel
2. Cek file `httpd.conf`, pastikan baris ini tidak ada `#`:
   ```apache
   Include conf/extra/httpd-vhosts.conf
   ```
3. Restart Apache

#### Error 2: "403 Forbidden" atau "Access Denied"

**Penyebab:** Permission folder atau konfigurasi Directory salah

**Solusi:**
1. Cek VirtualHost, pastikan:
   ```apache
   <Directory "C:/xampp/htdocs/nurani/public">
       Options Indexes FollowSymLinks
       AllowOverride All
       Require all granted
   </Directory>
   ```
2. Pastikan path benar dan menggunakan forward slash (`/`)
3. Restart Apache

#### Error 3: "404 Not Found" atau "The requested URL was not found"

**Penyebab:** 
- DocumentRoot salah
- File .htaccess tidak bekerja
- mod_rewrite tidak aktif

**Solusi:**
1. Pastikan DocumentRoot mengarah ke folder `public`:
   ```apache
   DocumentRoot "C:/xampp/htdocs/nurani/public"
   ```
2. Cek mod_rewrite aktif di `httpd.conf`:
   ```apache
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
3. Pastikan `.htaccess` ada di folder `public`
4. Restart Apache

#### Error 4: Domain tidak dikenali (masih ke halaman default XAMPP)

**Penyebab:** File hosts belum diupdate atau DNS cache belum di-flush

**Solusi:**
1. Cek file hosts, pastikan ada:
   ```
   127.0.0.1    nurani.test
   ```
2. Flush DNS cache:
   ```cmd
   ipconfig /flushdns
   ```
3. Restart browser atau gunakan incognito/private mode

#### Error 5: "500 Internal Server Error"

**Penyebab:** Error di Laravel atau permission storage

**Solusi:**
1. Cek file log Laravel: `storage/logs/laravel.log`
2. Pastikan permission folder `storage` dan `bootstrap/cache` bisa ditulis:
   - Klik kanan folder → Properties → Security
   - Pastikan user memiliki "Modify" permission
3. Jalankan:
   ```cmd
   php artisan config:clear
   php artisan cache:clear
   ```

#### Error 6: CSS/JS tidak muncul (404 untuk assets)

**Penyebab:** Path assets salah atau belum di-compile

**Solusi:**
1. Compile assets:
   ```cmd
   npm run build
   ```
   atau
   ```cmd
   npm run dev
   ```
2. Pastikan `APP_URL` di `.env` sudah benar:
   ```env
   APP_URL=http://nurani.test
   ```
3. Clear cache:
   ```cmd
   php artisan config:clear
   php artisan view:clear
   ```

#### Error 7: Database connection error

**Penyebab:** MySQL tidak berjalan atau konfigurasi salah

**Solusi:**
1. Pastikan MySQL berjalan di XAMPP Control Panel
2. Cek konfigurasi di `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nurani
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Test koneksi dengan phpMyAdmin

---

## 📝 Checklist Final

Sebelum testing, pastikan semua sudah dilakukan:

- [ ] Project sudah disalin ke `C:\xampp\htdocs\nurani\`
- [ ] VirtualHost sudah dibuat di `httpd-vhosts.conf`
- [ ] VirtualHost sudah diaktifkan di `httpd.conf`
- [ ] Domain sudah ditambahkan di file `hosts` Windows
- [ ] DNS cache sudah di-flush (`ipconfig /flushdns`)
- [ ] `APP_URL` di `.env` sudah diupdate ke `http://nurani.test`
- [ ] Cache Laravel sudah di-clear
- [ ] Apache sudah di-restart
- [ ] MySQL berjalan (jika menggunakan database)

---

## 🎯 Hasil Akhir

Setelah semua langkah selesai, Anda bisa:

✅ Mengakses website di: `http://nurani.test`  
✅ Tidak perlu menjalankan `php artisan serve`  
✅ URL tetap konsisten tanpa port  
✅ Semua fitur Laravel bekerja normal  

---

## 💡 Tips Tambahan

1. **Multiple Projects:** Anda bisa membuat beberapa VirtualHost untuk project berbeda
2. **HTTPS:** Untuk setup HTTPS lokal, perlu konfigurasi SSL certificate tambahan
3. **Port Custom:** Jika port 80 terpakai, bisa gunakan port lain (misal: 8080)
4. **Backup:** Selalu backup file konfigurasi sebelum mengubah

---

## 📞 Bantuan

Jika masih ada masalah:

1. Cek error log Apache: `C:\xampp\apache\logs\error.log`
2. Cek error log Laravel: `storage/logs/laravel.log`
3. Pastikan semua langkah di atas sudah dilakukan dengan benar

---

**Selamat! Project Laravel Anda sekarang berjalan dengan Apache XAMPP! 🎉**

