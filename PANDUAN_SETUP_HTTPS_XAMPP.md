# 🔒 PANDUAN SETUP HTTPS UNTUK LARAVEL DI XAMPP

Panduan lengkap untuk setup HTTPS lokal menggunakan self-signed certificate di XAMPP.

---

## 📋 DAFTAR ISI

1. [Persiapan](#1-persiapan)
2. [Membuat Self-Signed Certificate](#2-membuat-self-signed-certificate)
3. [Konfigurasi Apache untuk HTTPS](#3-konfigurasi-apache-untuk-https)
4. [Update VirtualHost](#4-update-virtualhost)
5. [Konfigurasi Laravel untuk HTTPS](#5-konfigurasi-laravel-untuk-https)
6. [Update File Hosts](#6-update-file-hosts)
7. [Testing](#7-testing)
8. [Troubleshooting](#8-troubleshooting)

---

## 1. Persiapan

### ✅ Pastikan XAMPP Terinstall

1. Pastikan XAMPP sudah terinstall
2. Pastikan Apache dan MySQL berjalan
3. Catat lokasi XAMPP (biasanya: `C:\xampp`)

### ✅ Pastikan OpenSSL Tersedia

OpenSSL biasanya sudah termasuk di XAMPP. Untuk cek:

1. Buka Command Prompt
2. Jalankan: `openssl version`
3. Jika muncul versi, berarti OpenSSL sudah terinstall

---

## 2. Membuat Self-Signed Certificate

### Langkah 1: Buat Folder untuk Certificate

1. Buat folder: `C:\xampp\apache\conf\ssl`
2. Jika folder tidak ada, buat manual

### Langkah 2: Generate Private Key dan Certificate

Buka Command Prompt sebagai Administrator, lalu jalankan perintah berikut:

```cmd
cd C:\xampp\apache\conf\ssl
```

**Generate Private Key:**
```cmd
openssl genrsa -out nurani.key 2048
```

**Generate Certificate Signing Request (CSR):**
```cmd
openssl req -new -key nurani.key -out nurani.csr
```

**Saat diminta informasi, isi seperti ini:**
```
Country Name (2 letter code) [AU]: ID
State or Province Name (full name) [Some-State]: Jakarta
Locality Name (eg, city) []: Jakarta
Organization Name (eg, company) [Internet Widgits Pty Ltd]: MTs Nurul Aiman
Organizational Unit Name (eg, section) []: IT Department
Common Name (e.g. server FQDN or YOUR name) []: nurani.test
Email Address []: admin@nurani.test
```

**Untuk "A challenge password" dan "An optional company name", tekan Enter saja (kosongkan).**

**Generate Self-Signed Certificate:**
```cmd
openssl x509 -req -days 365 -in nurani.csr -signkey nurani.key -out nurani.crt
```

**Hasil:**
- `nurani.key` - Private key
- `nurani.csr` - Certificate Signing Request
- `nurani.crt` - Certificate

---

## 3. Konfigurasi Apache untuk HTTPS

### Langkah 1: Aktifkan mod_ssl

1. Buka: `C:\xampp\apache\conf\httpd.conf`
2. Cari baris: `#LoadModule ssl_module modules/mod_ssl.so`
3. **Hapus tanda `#`** di depan:
   ```apache
   LoadModule ssl_module modules/mod_ssl.so
   ```

### Langkah 2: Aktifkan Include SSL Config

Masih di file `httpd.conf`, cari baris:
```apache
#Include conf/extra/httpd-ssl.conf
```

**Hapus tanda `#`:**
```apache
Include conf/extra/httpd-ssl.conf
```

### Langkah 3: Simpan File

- Tekan **Ctrl + S** untuk save

---

## 4. Update VirtualHost

### Langkah 1: Buka httpd-vhosts.conf

1. Buka: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

### Langkah 2: Tambahkan VirtualHost HTTPS

**Tambahkan konfigurasi berikut di akhir file:**

```apache
# VirtualHost HTTP (redirect ke HTTPS)
<VirtualHost *:80>
    ServerName nurani.test
    ServerAlias www.nurani.test
    DocumentRoot "C:/xampp/htdocs/nurani/public"
    
    # Redirect semua request ke HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>

# VirtualHost HTTPS
<VirtualHost *:443>
    ServerName nurani.test
    ServerAlias www.nurani.test
    DocumentRoot "C:/xampp/htdocs/nurani/public"
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile "C:/xampp/apache/conf/ssl/nurani.crt"
    SSLCertificateKeyFile "C:/xampp/apache/conf/ssl/nurani.key"
    
    # SSL Protocol Configuration
    SSLProtocol all -SSLv2 -SSLv3
    SSLCipherSuite HIGH:!aNULL:!MD5
    
    <Directory "C:/xampp/htdocs/nurani/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog "C:/xampp/apache/logs/nurani_ssl_error.log"
    CustomLog "C:/xampp/apache/logs/nurani_ssl_access.log" common
</VirtualHost>
```

### Langkah 3: Simpan File

- Tekan **Ctrl + S** untuk save

---

## 5. Konfigurasi Laravel untuk HTTPS

### Langkah 1: Update File .env

Buka file `.env` di root project, ubah:

**Sebelum:**
```env
APP_URL=http://nurani.test
```

**Sesudah:**
```env
APP_URL=https://nurani.test
```

### Langkah 2: Force HTTPS di Laravel

Buka file: `app/Providers/AppServiceProvider.php`

Tambahkan kode berikut di method `boot()`:

```php
public function boot(): void
{
    // Force HTTPS jika bukan localhost
    if (env('APP_ENV') !== 'local' || env('FORCE_HTTPS', false)) {
        \URL::forceScheme('https');
    }
}
```

**ATAU** untuk selalu force HTTPS (termasuk local):

```php
public function boot(): void
{
    // Force HTTPS
    if (config('app.url') && str_starts_with(config('app.url'), 'https://')) {
        \URL::forceScheme('https');
    }
}
```

### Langkah 3: Update Middleware (Opsional)

Jika ingin force HTTPS di semua request, buat middleware:

**Buat file:** `app/Http/Middleware/ForceHttps.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->secure() && env('APP_ENV') !== 'local') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
```

**Register di:** `bootstrap/app.php`

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        \App\Http\Middleware\ForceHttps::class,
    ]);
})
```

### Langkah 4: Update .htaccess (Opsional)

Buka file: `public/.htaccess`

Tambahkan di bagian atas (setelah `RewriteEngine On`):

```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### Langkah 5: Clear Cache

Jalankan di Command Prompt:

```cmd
cd C:\xampp\htdocs\nurani
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 6. Update File Hosts

File hosts sudah benar, tidak perlu diubah. Tetap:

```
127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

---

## 7. Testing

### Langkah 1: Restart Apache

1. XAMPP Control Panel
2. **Stop** Apache
3. Tunggu 3 detik
4. **Start** Apache
5. Pastikan status **Running** (hijau)

### Langkah 2: Test HTTPS

1. Buka browser
2. Ketik: `https://nurani.test`
3. Tekan Enter

**⚠️ PERINGATAN KEAMANAN:**
- Browser akan menampilkan peringatan "Your connection is not private"
- Ini **NORMAL** untuk self-signed certificate
- Klik **"Advanced"** → **"Proceed to nurani.test (unsafe)"**

### Langkah 3: Test Redirect HTTP ke HTTPS

1. Ketik: `http://nurani.test`
2. Tekan Enter
3. Harus otomatis redirect ke `https://nurani.test`

---

## 8. Troubleshooting

### Error: "mod_ssl not found"

**Solusi:**
1. Pastikan mod_ssl aktif di `httpd.conf`
2. Cek file `mod_ssl.so` ada di `C:\xampp\apache\modules\`
3. Jika tidak ada, download XAMPP versi lengkap

### Error: "SSL certificate not found"

**Solusi:**
1. Pastikan file certificate ada di: `C:\xampp\apache\conf\ssl\`
2. Pastikan path di VirtualHost benar
3. Pastikan menggunakan forward slash (`/`) di path

### Error: "Connection refused" di HTTPS

**Solusi:**
1. Pastikan port 443 tidak terpakai:
   ```cmd
   netstat -ano | findstr :443
   ```
2. Jika terpakai, hentikan proses atau ubah port

### Browser tidak menerima certificate

**Solusi:**
1. Ini normal untuk self-signed certificate
2. Klik "Advanced" → "Proceed to site"
3. Atau install certificate ke browser (opsional)

### HTTP tidak redirect ke HTTPS

**Solusi:**
1. Pastikan mod_rewrite aktif
2. Pastikan konfigurasi redirect di VirtualHost benar
3. Clear cache browser

---

## ✅ Checklist Final

Sebelum testing, pastikan:

- [ ] Certificate sudah dibuat (`nurani.crt` dan `nurani.key`)
- [ ] mod_ssl sudah aktif di `httpd.conf`
- [ ] VirtualHost HTTPS sudah dibuat
- [ ] VirtualHost HTTP sudah redirect ke HTTPS
- [ ] `APP_URL` di `.env` sudah diupdate ke `https://nurani.test`
- [ ] Laravel sudah dikonfigurasi untuk HTTPS
- [ ] Cache sudah di-clear
- [ ] Apache sudah di-restart

---

## 🎯 Hasil Akhir

Setelah semua langkah selesai:

✅ Website bisa diakses di: **https://nurani.test**  
✅ HTTP otomatis redirect ke HTTPS  
✅ Koneksi terenkripsi dengan SSL/TLS  
✅ Semua fitur Laravel bekerja normal  

---

## 💡 Tips

1. **Self-signed certificate hanya untuk development lokal**
2. **Untuk production**, gunakan certificate dari Let's Encrypt atau provider SSL lainnya
3. **Browser akan selalu tampilkan peringatan** untuk self-signed certificate (ini normal)
4. **Jangan gunakan self-signed certificate di production**

---

**Selamat! Website Anda sekarang menggunakan HTTPS! 🔒**

