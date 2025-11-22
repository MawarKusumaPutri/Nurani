# 🚀 LANGKAH SETUP APACHE XAMPP - LENGKAP & DETAIL

Panduan step-by-step untuk mengubah `http://127.0.0.1:8000` menjadi `http://nurani.test` tanpa port.

---

## 📋 PERSIAPAN

### ✅ Pastikan XAMPP Terinstall dan Berjalan

1. Buka **XAMPP Control Panel**
2. Pastikan **Apache** dan **MySQL** statusnya **Running** (hijau)
3. Jika belum running, klik **Start** pada Apache dan MySQL

---

## 📁 LANGKAH 1: SALIN PROJECT KE HTDOCS

### 1.1 Buka Folder XAMPP

Buka folder: `C:\xampp\htdocs\`

### 1.2 Salin Project

**Dari:** `D:\Capstone\nurani`  
**Ke:** `C:\xampp\htdocs\nurani`

**Cara:**
- Buka `D:\Capstone\nurani`
- Copy seluruh folder (Ctrl + C)
- Paste ke `C:\xampp\htdocs\` (Ctrl + V)

**Hasil struktur:**
```
C:\xampp\htdocs\
  └── nurani\
      ├── app\
      ├── bootstrap\
      ├── config\
      ├── database\
      ├── public\          ← PASTIKAN folder ini ada!
      ├── resources\
      ├── routes\
      ├── storage\
      ├── vendor\
      └── ...
```

### 1.3 Verifikasi

Pastikan folder `public` ada di:
```
C:\xampp\htdocs\nurani\public\
```

---

## ⚙️ LANGKAH 2: BUAT VIRTUALHOST APACHE

### 2.1 Buka File httpd-vhosts.conf

1. Buka **XAMPP Control Panel**
2. Klik **Config** pada Apache
3. Pilih **httpd-vhosts.conf**

**File akan terbuka di text editor.**

**Lokasi file:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

### 2.2 Tambahkan Konfigurasi VirtualHost

**Scroll ke bagian bawah file**, lalu **tambahkan** konfigurasi berikut:

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
    
    ErrorLog "C:/xampp/apache/logs/nurani_error.log"
    CustomLog "C:/xampp/apache/logs/nurani_access.log" common
</VirtualHost>
```

**⚠️ PENTING:**
- Copy **PERSIS** seperti di atas
- Pastikan path menggunakan **forward slash** (`/`) bukan backslash (`\`)
- Pastikan path mengarah ke folder **`public`**, bukan root project

### 2.3 Simpan File

- Tekan **Ctrl + S** untuk save
- Tutup text editor

---

## 🔧 LANGKAH 3: AKTIFKAN VIRTUALHOST

### 3.1 Buka File httpd.conf

1. Di **XAMPP Control Panel**, klik **Config** pada Apache
2. Pilih **httpd.conf**

**Lokasi file:** `C:\xampp\apache\conf\httpd.conf`

### 3.2 Cari dan Aktifkan Include VirtualHost

Tekan **Ctrl + F** dan cari:
```
Include conf/extra/httpd-vhosts.conf
```

**Pastikan baris ini TIDAK ada tanda `#` di depannya!**

**✅ BENAR:**
```apache
Include conf/extra/httpd-vhosts.conf
```

**❌ SALAH:**
```apache
#Include conf/extra/httpd-vhosts.conf
```

Jika ada tanda `#`, **hapus tanda `#` tersebut**.

### 3.3 Simpan File

- Tekan **Ctrl + S** untuk save
- Tutup text editor

---

## 🌐 LANGKAH 4: EDIT FILE HOSTS WINDOWS

### 4.1 Buka Notepad sebagai Administrator

**Cara 1 (Paling Mudah):**
1. Tekan **Windows + R**
2. Ketik: `notepad`
3. Tekan **Ctrl + Shift + Enter** (untuk run as admin)
4. Klik **Yes** jika muncul UAC prompt

**Cara 2:**
1. Klik **Start Menu**
2. Ketik: `notepad`
3. **Klik kanan** pada Notepad
4. Pilih **Run as administrator**
5. Klik **Yes** jika muncul UAC prompt

### 4.2 Buka File Hosts

1. Di Notepad, klik **File → Open**
2. Navigasi ke: `C:\Windows\System32\drivers\etc\`
3. Di dropdown **"File type"**, pilih **"All Files (*.*)"**
4. Pilih file **`hosts`** (tanpa ekstensi)
5. Klik **Open**

### 4.3 Tambahkan Domain

**Scroll ke bagian bawah file**, lalu **tambahkan 2 baris berikut:**

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

**⚠️ PENTING:**
- Pastikan ada **spasi** antara `127.0.0.1` dan `nurani.test`
- Jangan ada tanda `#` di depan kedua baris tersebut

### 4.4 Simpan File

1. Tekan **Ctrl + S** untuk save
2. Jika muncul error "Access Denied", pastikan Notepad dibuka sebagai Administrator

### 4.5 Flush DNS Cache

1. Tekan **Windows + R**
2. Ketik: `cmd`
3. Tekan **Ctrl + Shift + Enter** (run as admin)
4. Ketik perintah berikut dan tekan Enter:
   ```cmd
   ipconfig /flushdns
   ```
5. Anda akan melihat: `Successfully flushed the DNS Resolver Cache.`
6. Tutup Command Prompt

---

## 🔄 LANGKAH 5: RESTART APACHE

1. Buka **XAMPP Control Panel**
2. Klik **Stop** pada Apache (tunggu sampai status berubah)
3. Klik **Start** pada Apache
4. Pastikan status berubah menjadi **Running** (hijau)

---

## ⚙️ LANGKAH 6: UPDATE FILE .ENV

### 6.1 Buka File .env

Buka file: `C:\xampp\htdocs\nurani\.env`

### 6.2 Ubah APP_URL

**Cari baris:**
```env
APP_URL=http://127.0.0.1:8000
```

**Ubah menjadi:**
```env
APP_URL=http://nurani.test
```

**Atau jika tidak ada, tambahkan baris:**
```env
APP_URL=http://nurani.test
```

### 6.3 Simpan File

- Tekan **Ctrl + S** untuk save

---

## 🧹 LANGKAH 7: CLEAR CACHE LARAVEL

### 7.1 Buka Command Prompt

1. Tekan **Windows + R**
2. Ketik: `cmd`
3. Tekan Enter

### 7.2 Navigate ke Folder Project

Ketik perintah berikut (satu per satu, tekan Enter setelah setiap baris):

```cmd
cd C:\xampp\htdocs\nurani
```

### 7.3 Clear Cache

Jalankan perintah berikut (satu per satu):

```cmd
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**ATAU** gunakan file `setup-apache.bat` yang sudah disediakan:
- Double-click file `setup-apache.bat` di folder project

---

## ✅ LANGKAH 8: TEST

### 8.1 Buka Browser

Buka browser favorit Anda (Chrome, Firefox, Edge, dll)

### 8.2 Akses Domain

Ketik di address bar:
```
http://nurani.test
```

Tekan **Enter**

### 8.3 Hasil yang Diharapkan

✅ Website Laravel muncul tanpa error  
✅ Tidak perlu mengetik port `:8000`  
✅ URL tetap `http://nurani.test` saat navigasi  
✅ Semua fitur bekerja normal  

---

## 🔧 TROUBLESHOOTING

### ❌ Error: "This site can't be reached" atau "ERR_CONNECTION_REFUSED"

**Penyebab:** Apache tidak berjalan atau VirtualHost belum diaktifkan

**Solusi:**
1. Pastikan Apache **Running** di XAMPP Control Panel
2. Cek file `httpd.conf`, pastikan baris ini **TIDAK** ada tanda `#`:
   ```apache
   Include conf/extra/httpd-vhosts.conf
   ```
3. Restart Apache

---

### ❌ Error: "403 Forbidden" atau "Access Denied"

**Penyebab:** Permission folder atau konfigurasi Directory salah

**Solusi:**
1. Cek VirtualHost, pastikan path benar:
   ```apache
   DocumentRoot "C:/xampp/htdocs/nurani/public"
   ```
2. Pastikan menggunakan forward slash (`/`) bukan backslash (`\`)
3. Pastikan folder `public` ada di lokasi tersebut
4. Restart Apache

---

### ❌ Error: "404 Not Found"

**Penyebab:** DocumentRoot salah atau mod_rewrite tidak aktif

**Solusi:**
1. Pastikan DocumentRoot mengarah ke folder `public`:
   ```apache
   DocumentRoot "C:/xampp/htdocs/nurani/public"
   ```
2. Cek mod_rewrite aktif di `httpd.conf`:
   ```apache
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
3. Pastikan file `.htaccess` ada di folder `public`
4. Restart Apache

---

### ❌ Domain Tidak Dikenali (Masih ke Halaman Default XAMPP)

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
3. Restart browser atau gunakan **Incognito/Private mode**

---

### ❌ Error: "500 Internal Server Error"

**Penyebab:** Error di Laravel atau permission storage

**Solusi:**
1. Cek file log Laravel: `C:\xampp\htdocs\nurani\storage\logs\laravel.log`
2. Pastikan permission folder `storage` dan `bootstrap/cache` bisa ditulis
3. Jalankan:
   ```cmd
   php artisan config:clear
   php artisan cache:clear
   ```

---

### ❌ CSS/JS Tidak Muncul (404 untuk Assets)

**Penyebab:** Path assets salah atau belum di-compile

**Solusi:**
1. Pastikan `APP_URL` di `.env` sudah benar:
   ```env
   APP_URL=http://nurani.test
   ```
2. Clear cache:
   ```cmd
   php artisan config:clear
   php artisan view:clear
   ```
3. Compile assets (jika menggunakan Vite):
   ```cmd
   npm run build
   ```

---

## 📝 CHECKLIST FINAL

Sebelum testing, pastikan semua sudah dilakukan:

- [ ] Project sudah di `C:\xampp\htdocs\nurani\`
- [ ] VirtualHost sudah dibuat di `httpd-vhosts.conf`
- [ ] VirtualHost sudah diaktifkan di `httpd.conf`
- [ ] Domain sudah ditambahkan di file `hosts` Windows
- [ ] DNS cache sudah di-flush (`ipconfig /flushdns`)
- [ ] `APP_URL` di `.env` sudah diupdate ke `http://nurani.test`
- [ ] Cache Laravel sudah di-clear
- [ ] Apache sudah di-restart
- [ ] MySQL berjalan (jika menggunakan database)

---

## 🎯 HASIL AKHIR

Setelah semua langkah selesai:

✅ Website bisa diakses di: **http://nurani.test**  
✅ Tidak perlu menjalankan `php artisan serve`  
✅ URL tetap konsisten tanpa port  
✅ Semua fitur Laravel bekerja normal  

---

## 💡 TIPS

1. **Multiple Projects:** Anda bisa membuat beberapa VirtualHost untuk project berbeda
2. **Backup:** Selalu backup file konfigurasi sebelum mengubah
3. **Error Log:** Jika ada masalah, cek error log Apache: `C:\xampp\apache\logs\error.log`

---

**Selamat! Project Laravel Anda sekarang berjalan dengan Apache XAMPP! 🎉**

