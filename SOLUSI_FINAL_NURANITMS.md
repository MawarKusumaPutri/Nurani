# 🚨 SOLUSI FINAL: Perbaiki nuranitms.test Agar Berfungsi

Panduan lengkap untuk memperbaiki masalah "We can't connect to the server at nuranitms.test".

---

## ⚡ LANGKAH CEPAT (Ikuti Urut!)

### 🔴 LANGKAH 1: Jalankan Script Perbaikan Otomatis

**Double-click:** `PERBAIKAN_LENGKAP_OTOMATIS.bat`

Script ini akan:
- ✅ Cek Apache running
- ✅ Aktifkan mod_ssl otomatis
- ✅ Aktifkan mod_rewrite otomatis
- ✅ Cek certificate
- ✅ Cek VirtualHost
- ✅ Update .env
- ✅ Clear cache

**Catat semua [ERROR] atau [WARNING] yang muncul!**

---

### 🔴 LANGKAH 2: Buat Certificate (Jika Belum Ada)

**Jika certificate belum ada, jalankan:**

**Double-click:** `SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat`

**Saat diminta informasi:**
```
Country Name: ID
State: Jakarta
City: Jakarta
Organization: MTs Nurul Aiman
Organizational Unit: IT Department
Common Name: nuraniTMS.test    ← PENTING!
Email: admin@nuraniTMS.test
```

**Untuk "A challenge password" dan "An optional company name", tekan Enter saja.**

**Pastikan file dibuat di:**
- `C:\xampp\apache\conf\ssl\nuraniTMS.crt`
- `C:\xampp\apache\conf\ssl\nuraniTMS.key`

---

### 🔴 LANGKAH 3: Update File Hosts (PENTING!)

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

11. **Tambahkan di akhir file:**
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

---

### 🔴 LANGKAH 4: Update VirtualHost (PENTING!)

1. **Buka:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

2. **Hapus semua VirtualHost lama** untuk nurani (jika ada)

3. **Buka file:** `KONFIGURASI_VIRTUALHOST_LENGKAP.txt`

4. **Copy seluruh isinya**

5. **Paste di akhir file** `httpd-vhosts.conf`

6. **Simpan:** Ctrl + S

**Pastikan konfigurasi ini ada:**
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
    SSLCertificateKeyFile "C:\xampp\apache\conf\ssl\nuraniTMS.key"
    
    SSLProtocol all -SSLv2 -SSLv3
    SSLCipherSuite HIGH:!aNULL:!MD5
    
    <Directory "C:/xampp/htdocs/nurani/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

---

### 🔴 LANGKAH 5: Pastikan mod_ssl Aktif

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

### 🔴 LANGKAH 6: RESTART APACHE (SANGAT PENTING!)

1. **Buka XAMPP Control Panel**

2. **Klik Stop pada Apache** (tunggu sampai status benar-benar berubah)

3. **Tunggu 5-10 detik** (penting untuk memastikan Apache benar-benar stop)

4. **Klik Start pada Apache**

5. **Tunggu sampai status berubah menjadi Running** (hijau)

6. **Pastikan tidak ada error** di XAMPP Control Panel

**⚠️ PENTING:** Restart Apache WAJIB dilakukan setelah mengubah konfigurasi!

---

### 🔴 LANGKAH 7: Cek Error Log (Jika Masih Error)

Jika masih error setelah restart, cek error log:

1. **Buka:** `C:\xampp\apache\logs\error.log`

2. **Scroll ke bagian paling bawah**

3. **Cari error terakhir**

**Error umum dan solusinya:**

#### Error: "SSLCertificateFile: file does not exist"
**Solusi:** Pastikan path certificate benar:
```apache
SSLCertificateFile "C:/xampp/apache/conf/ssl/nuraniTMS.crt"
SSLCertificateKeyFile "C:/xampp/apache/conf/ssl/nuraniTMS.key"
```

#### Error: "mod_ssl is not available"
**Solusi:** Pastikan mod_ssl aktif di httpd.conf

#### Error: "Address already in use"
**Solusi:** Port 443 terpakai, cek dengan:
```cmd
netstat -ano | findstr :443
```

---

### 🔴 LANGKAH 8: Test

1. **Tutup semua tab browser**

2. **Buka browser baru** (atau gunakan **Incognito/Private mode**)

3. **Test dengan berbagai variasi:**
   - `https://nuranitms.test`
   - `https://nuraniTMS.test`
   - `http://nuranitms.test` (harus redirect ke HTTPS)

4. **Peringatan keamanan akan muncul** (normal untuk self-signed certificate):
   - Klik **"Advanced"** atau **"Advanced settings"**
   - Klik **"Proceed to nuranitms.test (unsafe)"** atau **"Continue to nuranitms.test"**

**Hasil yang diharapkan:**
- ✅ Website TMS NURANI muncul
- ✅ Header hijau dengan logo
- ✅ Background gambar gedung sekolah
- ✅ Teks "MENCIPTAKAN MASA DEPAN"
- ✅ Tombol LOGIN di kanan atas

---

## 🔍 TROUBLESHOOTING LANJUTAN

### ❌ Masalah: "We can't connect to the server"

**Penyebab:** Apache tidak running atau VirtualHost salah

**Solusi:**
1. Pastikan Apache **Running** di XAMPP Control Panel
2. Cek error log: `C:\xampp\apache\logs\error.log`
3. Pastikan VirtualHost sudah benar
4. Restart Apache

### ❌ Masalah: Port 443 tidak listen

**Solusi:**
1. Cek port 443:
   ```cmd
   netstat -ano | findstr :443
   ```
2. Jika tidak ada, VirtualHost HTTPS belum benar
3. Pastikan mod_ssl aktif
4. Restart Apache

### ❌ Masalah: Certificate error

**Solusi:**
1. Pastikan certificate sudah dibuat
2. Pastikan path di VirtualHost benar
3. Pastikan file ada di: `C:\xampp\apache\conf\ssl\`

### ❌ Masalah: HTTP tidak redirect ke HTTPS

**Solusi:**
1. Pastikan mod_rewrite aktif
2. Pastikan konfigurasi redirect di VirtualHost HTTP benar
3. Restart Apache

---

## ✅ CHECKLIST FINAL

Sebelum test lagi, pastikan:

- [ ] Apache **Running** di XAMPP Control Panel
- [ ] mod_ssl **aktif** di httpd.conf
- [ ] mod_rewrite **aktif** di httpd.conf
- [ ] Certificate sudah dibuat (`nuraniTMS.crt` dan `nuraniTMS.key`)
- [ ] VirtualHost HTTPS sudah dibuat dengan **ServerAlias** untuk semua variasi
- [ ] File hosts sudah diupdate dengan **semua variasi** domain
- [ ] DNS sudah di-flush (`ipconfig /flushdns`)
- [ ] `APP_URL` di `.env` sudah `https://nuraniTMS.test`
- [ ] `SESSION_SECURE_COOKIE=true` di `.env`
- [ ] Cache sudah di-clear
- [ ] Apache sudah di-restart (setelah semua perubahan)

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah semua langkah:

✅ `https://nuranitms.test` bisa diakses  
✅ `https://nuraniTMS.test` bisa diakses  
✅ Website TMS NURANI muncul lengkap  
✅ Header hijau dengan logo dan tombol LOGIN  
✅ Background gambar gedung sekolah  
✅ Semua elemen website muncul dengan benar  

---

## 🆘 MASIH ERROR?

Jika masih error setelah semua langkah:

1. **RESTART KOMPUTER** (sering menyelesaikan masalah)
2. **Cek error log:** `C:\xampp\apache\logs\error.log`
3. **Cek error log Laravel:** `storage\logs\laravel.log`
4. **Pastikan semua langkah sudah dilakukan dengan benar**
5. **Test dengan browser lain** (Chrome, Firefox, Edge)

---

## 💡 TIPS PENTING

1. **Selalu restart Apache** setelah mengubah konfigurasi
2. **Gunakan Incognito mode** untuk test (menghindari cache browser)
3. **Flush DNS** setelah mengubah file hosts
4. **Cek error log** jika ada masalah
5. **Restart komputer** jika masalah DNS persist

---

**Ikuti langkah-langkah di atas dengan teliti, terutama Langkah 1, 3, 4, dan 6!**

