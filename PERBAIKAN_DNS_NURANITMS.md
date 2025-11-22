# 🔧 PERBAIKAN: DNS_PROBE_FINISHED_NXDOMAIN untuk nuranitms.test

Error ini berarti domain `nuranitms.test` tidak dikenali. Mari kita perbaiki!

---

## ⚡ SOLUSI CEPAT

### 🔴 LANGKAH 1: Update File Hosts (PENTING!)

1. **Tekan Windows + R**
2. **Ketik:** `notepad`
3. **Tekan Ctrl + Shift + Enter** (run as admin)
4. **Klik Yes**

5. **File → Open**
6. **Navigasi ke:** `C:\Windows\System32\drivers\etc\`
7. **Di dropdown "File type", pilih "All Files (*.*)"**
8. **Pilih file `hosts`**
9. **Klik Open**

10. **Hapus semua baris yang terkait nurani** (jika ada):
    ```
    127.0.0.1    nurani.test
    127.0.0.1    www.nurani.test
    127.0.0.1    nuraniTMS.test
    127.0.0.1    www.nuraniTMS.test
    127.0.0.1    nuranitms.test
    127.0.0.1    www.nuranitms.test
    ```

11. **Tambahkan di akhir file (semua variasi):**
    ```
    127.0.0.1    nuraniTMS.test
    127.0.0.1    www.nuraniTMS.test
    127.0.0.1    nuranitms.test
    127.0.0.1    www.nuranitms.test
    ```

12. **Simpan:** Ctrl + S

13. **Flush DNS:**
    - Buka CMD sebagai admin
    - Jalankan: `ipconfig /flushdns`
    - Anda akan melihat: `Successfully flushed the DNS Resolver Cache.`

---

### 🔴 LANGKAH 2: Update VirtualHost (Mendukung Semua Variasi)

1. **Buka:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

2. **Hapus semua VirtualHost lama** untuk nurani (jika ada)

3. **Copy-paste konfigurasi berikut di akhir file:**

```apache
# VirtualHost HTTP (redirect ke HTTPS)
<VirtualHost *:80>
    ServerName nuraniTMS.test
    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test
    DocumentRoot "C:/xampp/htdocs/nurani/public"
    
    # Redirect semua request ke HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>

# VirtualHost HTTPS
<VirtualHost *:443>
    ServerName nuraniTMS.test
    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test
    DocumentRoot "C:/xampp/htdocs/nurani/public"
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile "C:/xampp/apache/conf/ssl/nuraniTMS.crt"
    SSLCertificateKeyFile "C:/xampp/apache/conf/ssl/nuraniTMS.key"
    
    # SSL Protocol Configuration
    SSLProtocol all -SSLv2 -SSLv3
    SSLCipherSuite HIGH:!aNULL:!MD5
    
    <Directory "C:/xampp/htdocs/nurani/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog "C:/xampp/apache/logs/nuraniTMS_ssl_error.log"
    CustomLog "C:/xampp/apache/logs/nuraniTMS_ssl_access.log" common
</VirtualHost>
```

4. **Simpan:** Ctrl + S

---

### 🔴 LANGKAH 3: Pastikan Certificate Sudah Dibuat

**Jika certificate belum ada, jalankan:**

**Double-click:** `SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat`

**Saat diminta Common Name, isi:** `nuraniTMS.test`

**Pastikan file ada di:**
- `C:\xampp\apache\conf\ssl\nuraniTMS.crt`
- `C:\xampp\apache\conf\ssl\nuraniTMS.key`

---

### 🔴 LANGKAH 4: Pastikan mod_ssl Aktif

1. **Buka:** `C:\xampp\apache\conf\httpd.conf`

2. **Cari:** `#LoadModule ssl_module modules/mod_ssl.so`

3. **Hapus tanda `#`:**
   ```apache
   LoadModule ssl_module modules/mod_ssl.so
   ```

4. **Cari:** `#Include conf/extra/httpd-ssl.conf`

5. **Hapus tanda `#`:**
   ```apache
   Include conf/extra/httpd-ssl.conf
   ```

6. **Simpan:** Ctrl + S

---

### 🔴 LANGKAH 5: Update .env

1. **Buka file:** `.env`

2. **Pastikan:**
   ```env
   APP_URL=https://nuraniTMS.test
   SESSION_SECURE_COOKIE=true
   ```

3. **Simpan:** Ctrl + S

---

### 🔴 LANGKAH 6: Clear Cache

Jalankan di Command Prompt:

```cmd
cd C:\xampp\htdocs\nurani
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**ATAU** double-click: `setup-apache.bat`

---

### 🔴 LANGKAH 7: Restart Apache (PENTING!)

1. **XAMPP Control Panel**
2. **Stop Apache** (tunggu sampai status berubah)
3. **Tunggu 3-5 detik**
4. **Start Apache**
5. **Pastikan status Running** (hijau)

---

### 🔴 LANGKAH 8: Test

1. **Tutup semua tab browser**

2. **Buka browser baru** (atau gunakan **Incognito/Private mode**)

3. **Test dengan berbagai variasi:**
   - `https://nuraniTMS.test`
   - `https://nuranitms.test`
   - `http://nuraniTMS.test` (harus redirect ke HTTPS)
   - `http://nuranitms.test` (harus redirect ke HTTPS)

4. **Peringatan keamanan akan muncul** (normal untuk self-signed certificate):
   - Klik **"Advanced"** atau **"Advanced settings"**
   - Klik **"Proceed to nuraniTMS.test (unsafe)"** atau **"Continue to nuraniTMS.test"**

**Hasil yang diharapkan:**
- ✅ Website TMS NURANI muncul (seperti di foto 2)
- ✅ Header hijau dengan logo
- ✅ Background gambar gedung sekolah
- ✅ Teks "MENCIPTAKAN MASA DEPAN"
- ✅ Tombol LOGIN di kanan atas

---

## 🔍 TROUBLESHOOTING

### ❌ Masalah: Masih "DNS_PROBE_FINISHED_NXDOMAIN"

**Solusi:**
1. Pastikan file hosts sudah diupdate dengan benar
2. Pastikan semua variasi domain sudah ditambahkan
3. Flush DNS lagi: `ipconfig /flushdns`
4. Restart browser atau gunakan Incognito mode
5. **Restart komputer** (sering menyelesaikan masalah DNS)

### ❌ Masalah: "This site can't be reached"

**Solusi:**
1. Pastikan Apache running di XAMPP Control Panel
2. Cek error log: `C:\xampp\apache\logs\error.log`
3. Pastikan VirtualHost sudah benar
4. Restart Apache

### ❌ Masalah: "ERR_SSL_PROTOCOL_ERROR"

**Solusi:**
1. Pastikan certificate sudah dibuat
2. Pastikan path certificate benar di VirtualHost
3. Restart Apache

### ❌ Masalah: Website muncul tapi tidak lengkap

**Solusi:**
1. Clear cache browser (Ctrl + Shift + Delete)
2. Clear cache Laravel:
   ```cmd
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```
3. Pastikan `APP_URL` di `.env` sudah benar

---

## ✅ CHECKLIST FINAL

Sebelum test lagi, pastikan:

- [ ] File hosts sudah diupdate dengan **semua variasi** domain
- [ ] DNS sudah di-flush (`ipconfig /flushdns`)
- [ ] VirtualHost sudah dibuat dengan **ServerAlias** untuk semua variasi
- [ ] Certificate sudah dibuat (`nuraniTMS.crt` dan `nuraniTMS.key`)
- [ ] mod_ssl aktif
- [ ] `APP_URL` di `.env` sudah `https://nuraniTMS.test`
- [ ] Cache sudah di-clear
- [ ] Apache sudah di-restart
- [ ] Browser sudah ditutup dan dibuka lagi

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah semua langkah:

✅ `https://nuraniTMS.test` bisa diakses  
✅ `https://nuranitms.test` bisa diakses (huruf kecil)  
✅ Website TMS NURANI muncul lengkap (seperti foto 2)  
✅ Header hijau dengan logo dan tombol LOGIN  
✅ Background gambar gedung sekolah  
✅ Semua elemen website muncul dengan benar  

---

## 🆘 MASIH ERROR?

Jika masih error:

1. **Restart komputer** (sering menyelesaikan masalah DNS)
2. **Cek error log:** `C:\xampp\apache\logs\error.log`
3. **Pastikan semua langkah sudah dilakukan dengan benar**
4. **Test dengan Incognito mode** untuk menghindari cache browser

---

**Ikuti langkah-langkah di atas dengan teliti, terutama Langkah 1, 2, dan 7!**

