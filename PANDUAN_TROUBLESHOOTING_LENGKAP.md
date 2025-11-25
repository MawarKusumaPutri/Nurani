# 🔧 PANDUAN TROUBLESHOOTING LENGKAP

Panduan untuk memperbaiki masalah "We can't connect to the server at nuranitms.test".

---

## 🔍 LANGKAH 1: CEK MASALAH

**Jalankan:** `CEK_DAN_PERBAIKI_SEMUA_MASALAH.bat`

Script ini akan mengecek semua konfigurasi dan menunjukkan masalah yang ada.

**Catat semua [ERROR] yang muncul!**

---

## ✅ LANGKAH 2: PERBAIKI MASALAH YANG DITEMUKAN

### ❌ ERROR 1: Apache Tidak Running

**Gejala:** [ERROR] Apache TIDAK running!

**Solusi:**
1. Buka XAMPP Control Panel
2. Klik **Start** pada Apache
3. Pastikan status **Running** (hijau)
4. Jika tidak bisa start, cek error di XAMPP Control Panel

---

### ❌ ERROR 2: Project Tidak di htdocs

**Gejala:** [ERROR] Project TIDAK ditemukan di C:\xampp\htdocs\nurani\

**Solusi:**
1. **Salin project** ke htdocs:
   - **Dari:** `D:\Capstone\nurani`
   - **Ke:** `C:\xampp\htdocs\nurani`
2. Pastikan folder `public` ada di: `C:\xampp\htdocs\nurani\public\`
3. Pastikan file `index.php` ada di: `C:\xampp\htdocs\nurani\public\index.php`

**Cara salin:**
- Buka `D:\Capstone\nurani`
- Copy seluruh folder (Ctrl + C)
- Paste ke `C:\xampp\htdocs\` (Ctrl + V)
- Rename menjadi `nurani` jika perlu

---

### ❌ ERROR 3: Certificate Tidak Ditemukan

**Gejala:** [ERROR] Certificate TIDAK ditemukan!

**Solusi:**
1. Jalankan: `FIX_NURANITMS.bat`
2. Atau jalankan: `SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat`
3. Pastikan file ada di:
   - `C:\xampp\apache\conf\ssl\nuraniTMS.crt`
   - `C:\xampp\apache\conf\ssl\nuraniTMS.key`

---

### ❌ ERROR 4: mod_ssl Tidak Aktif

**Gejala:** [ERROR] mod_ssl TIDAK aktif!

**Solusi:**
1. Buka: `C:\xampp\apache\conf\httpd.conf`
2. Cari: `#LoadModule ssl_module modules/mod_ssl.so`
3. Hapus tanda `#` di depan:
   ```apache
   LoadModule ssl_module modules/mod_ssl.so
   ```
4. Cari juga: `#Include conf/extra/httpd-ssl.conf`
5. Hapus tanda `#`:
   ```apache
   Include conf/extra/httpd-ssl.conf
   ```
6. Simpan: Ctrl + S
7. Restart Apache

---

### ❌ ERROR 5: VirtualHost HTTPS Tidak Ditemukan

**Gejala:** [ERROR] VirtualHost HTTPS TIDAK ditemukan!

**Solusi:**
1. Buka: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Hapus semua VirtualHost lama untuk nurani (jika ada)
3. Tambahkan di akhir file:

```apache
# VirtualHost HTTP (redirect ke HTTPS)
<VirtualHost *:80>
    ServerName nuraniTMS.test
    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test
    DocumentRoot "C:/xampp/htdocs/nurani/public"
    
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>

# VirtualHost HTTPS
<VirtualHost *:443>
    ServerName nuraniTMS.test
    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test
    DocumentRoot "C:/xampp/htdocs/nurani/public"
    
    SSLEngine on
    SSLCertificateFile "C:/xampp/apache/conf/ssl/nuraniTMS.crt"
    SSLCertificateKeyFile "C:/xampp/apache/conf/ssl/nuraniTMS.key"
    
    SSLProtocol all -SSLv2 -SSLv3
    SSLCipherSuite HIGH:!aNULL:!MD5
    
    <Directory "C:/xampp/htdocs/nurani/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

4. Simpan: Ctrl + S
5. Restart Apache

---

### ❌ ERROR 6: Domain Tidak di File Hosts

**Gejala:** [ERROR] Domain TIDAK ditemukan di file hosts!

**Solusi:**
1. Tekan Windows + R → ketik `notepad` → Ctrl + Shift + Enter (run as admin)
2. File → Open → `C:\Windows\System32\drivers\etc\hosts`
3. Hapus semua baris yang terkait nurani (jika ada)
4. Tambahkan di akhir file:
   ```
   127.0.0.1    nuraniTMS.test
   127.0.0.1    www.nuraniTMS.test
   127.0.0.1    nuranitms.test
   127.0.0.1    www.nuranitms.test
   ```
5. Simpan: Ctrl + S
6. Flush DNS: Buka CMD sebagai admin → `ipconfig /flushdns`

---

## ✅ LANGKAH 3: RESTART APACHE

Setelah semua error diperbaiki:

1. **XAMPP Control Panel**
2. **Stop Apache** (tunggu sampai status benar-benar berubah)
3. **Tunggu 10 detik** (PENTING!)
4. **Start Apache**
5. **Pastikan status Running** (hijau)
6. **Tunggu 5 detik lagi**

---

## ✅ LANGKAH 4: RESTART KOMPUTER

**RESTART KOMPUTER** (sering menyelesaikan masalah DNS dan port)

Setelah restart:
1. Start Apache di XAMPP Control Panel
2. Test: `https://nuranitms.test`

---

## ✅ LANGKAH 5: CEK ERROR LOG APACHE

Jika masih error, cek error log:

1. Buka: `C:\xampp\apache\logs\error.log`
2. Scroll ke bagian paling bawah
3. Cari error terakhir

**Error umum:**

### "SSLCertificateFile: file does not exist"
**Solusi:** Pastikan path certificate benar di VirtualHost

### "mod_ssl is not available"
**Solusi:** Pastikan mod_ssl aktif di httpd.conf

### "Address already in use"
**Solusi:** Port 443 terpakai, restart komputer

---

## ✅ LANGKAH 6: TEST DENGAN LOCALHOST DULU

Sebelum test dengan domain, test dulu dengan localhost:

1. Buka browser
2. Ketik: `http://localhost/nurani/public`
3. Tekan Enter

**Jika ini BERHASIL:**
- ✅ Apache dan project sudah benar
- ❌ Masalahnya di VirtualHost atau file hosts

**Jika ini TIDAK BERHASIL:**
- ❌ Project belum di htdocs atau path salah
- ✅ Perbaiki dulu masalah ini

---

## ✅ LANGKAH 7: TEST DENGAN BROWSER LAIN

Test dengan:
- Chrome
- Firefox
- Edge
- Incognito/Private mode

---

## ✅ CHECKLIST FINAL

Sebelum test lagi, pastikan:

- [ ] Apache **Running** di XAMPP Control Panel
- [ ] Project sudah di `C:\xampp\htdocs\nurani\`
- [ ] Certificate sudah dibuat
- [ ] mod_ssl **aktif** di httpd.conf
- [ ] VirtualHost HTTPS sudah dibuat
- [ ] File hosts sudah diupdate
- [ ] DNS sudah di-flush
- [ ] Apache sudah di-restart
- [ ] **RESTART KOMPUTER** (jika masih error)

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah semua langkah:

✅ `https://nuranitms.test` bisa diakses  
✅ Website TMS NURANI muncul lengkap  
✅ Header hijau dengan logo  
✅ Background gambar siswa di kelas  
✅ Tombol LOGIN di kanan atas  

---

## 🆘 MASIH ERROR?

Jika masih error setelah semua langkah:

1. **RESTART KOMPUTER** (sering menyelesaikan masalah)
2. **Cek error log:** `C:\xampp\apache\logs\error.log`
3. **Test dengan localhost:** `http://localhost/nurani/public`
4. **Pastikan semua checklist sudah dilakukan**

---

**Ikuti langkah-langkah di atas dengan teliti!**

