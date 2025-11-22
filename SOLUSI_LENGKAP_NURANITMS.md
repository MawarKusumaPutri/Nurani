# 🚀 SOLUSI LENGKAP: Setup HTTPS untuk nuraniTMS.test

Panduan lengkap untuk setup domain `nuraniTMS.test` dengan HTTPS yang berfungsi.

---

## 📋 LANGKAH-LANGKAH (Ikuti Urut!)

### ✅ LANGKAH 1: Buat Certificate SSL

**Double-click:** `SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat`

**Saat diminta informasi, isi:**
```
Country Name: ID
State: Jakarta
City: Jakarta
Organization: MTs Nurul Aiman
Organizational Unit: IT Department
Common Name: nuraniTMS.test    ← PENTING! Harus sama persis
Email: admin@nuraniTMS.test
```

**Untuk "A challenge password" dan "An optional company name", tekan Enter saja.**

**Pastikan file dibuat di:**
- `C:\xampp\apache\conf\ssl\nuraniTMS.crt`
- `C:\xampp\apache\conf\ssl\nuraniTMS.key`

---

### ✅ LANGKAH 2: Aktifkan mod_ssl

1. **Buka:** `C:\xampp\apache\conf\httpd.conf`

2. **Cari baris (gunakan Ctrl + F):**
   ```apache
   #LoadModule ssl_module modules/mod_ssl.so
   ```

3. **Hapus tanda `#` di depan:**
   ```apache
   LoadModule ssl_module modules/mod_ssl.so
   ```

4. **Cari juga:**
   ```apache
   #Include conf/extra/httpd-ssl.conf
   ```

5. **Hapus tanda `#` di depan:**
   ```apache
   Include conf/extra/httpd-ssl.conf
   ```

6. **Simpan:** Ctrl + S

---

### ✅ LANGKAH 3: Buat VirtualHost HTTPS

1. **Buka:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

2. **Hapus semua VirtualHost lama** untuk nurani.test atau nuraniTMS.test (jika ada)

3. **Buka file:** `KONFIGURASI_VIRTUALHOST_HTTPS_NURANITMS.txt`

4. **Copy seluruh isinya**

5. **Paste di akhir file** `httpd-vhosts.conf`

6. **Simpan:** Ctrl + S

**Pastikan ada 2 VirtualHost:**
- VirtualHost HTTP (port 80) - redirect ke HTTPS
- VirtualHost HTTPS (port 443) - dengan SSL

---

### ✅ LANGKAH 4: Update File Hosts Windows

1. **Tekan Windows + R**
2. **Ketik:** `notepad`
3. **Tekan Ctrl + Shift + Enter** (run as admin)
4. **Klik Yes**

5. **File → Open**
6. **Navigasi ke:** `C:\Windows\System32\drivers\etc\`
7. **Di dropdown "File type", pilih "All Files (*.*)"**
8. **Pilih file `hosts`**
9. **Klik Open**

10. **Hapus baris lama** (jika ada):
    ```
    127.0.0.1    nurani.test
    127.0.0.1    www.nurani.test
    ```

11. **Scroll ke bagian bawah, tambahkan:**
    ```
    127.0.0.1    nuraniTMS.test
    127.0.0.1    www.nuraniTMS.test
    ```

12. **Simpan:** Ctrl + S

13. **Flush DNS:**
    - Buka CMD sebagai admin
    - Jalankan: `ipconfig /flushdns`

---

### ✅ LANGKAH 5: Update File .env

1. **Buka file:** `.env`

2. **Cari dan ubah:**
    ```env
    APP_URL=https://nuraniTMS.test
    ```

3. **Tambahkan juga:**
    ```env
    SESSION_SECURE_COOKIE=true
    ```

4. **Simpan:** Ctrl + S

---

### ✅ LANGKAH 6: Clear Cache Laravel

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

### ✅ LANGKAH 7: Restart Apache (PENTING!)

1. **XAMPP Control Panel**
2. **Stop Apache** (tunggu sampai status berubah)
3. **Tunggu 3-5 detik**
4. **Start Apache**
5. **Pastikan status Running** (hijau)

**⚠️ PENTING:** Restart Apache WAJIB dilakukan setelah mengubah konfigurasi!

---

### ✅ LANGKAH 8: Test

1. **Tutup semua tab browser**

2. **Buka browser baru** (atau gunakan **Incognito/Private mode**)

3. **Ketik:** `https://nuraniTMS.test`

4. **Tekan Enter**

**Hasil yang diharapkan:**
- Browser menampilkan peringatan keamanan (normal untuk self-signed certificate)
- Klik **"Advanced"** atau **"Advanced settings"**
- Klik **"Proceed to nuraniTMS.test (unsafe)"** atau **"Continue to nuraniTMS.test"**
- Website Laravel muncul

**Test redirect:**
- Ketik: `http://nuraniTMS.test`
- Harus otomatis redirect ke: `https://nuraniTMS.test`

---

## 🔍 TROUBLESHOOTING

### ❌ Masalah: "This site can't be reached"

**Solusi:**
1. Pastikan Apache running
2. Cek file hosts sudah diupdate
3. Flush DNS: `ipconfig /flushdns`
4. Restart browser

### ❌ Masalah: "ERR_SSL_PROTOCOL_ERROR"

**Solusi:**
1. Pastikan certificate sudah dibuat dengan nama `nuraniTMS.crt` dan `nuraniTMS.key`
2. Pastikan path di VirtualHost benar:
   ```apache
   SSLCertificateFile "C:/xampp/apache/conf/ssl/nuraniTMS.crt"
   SSLCertificateKeyFile "C:/xampp/apache/conf/ssl/nuraniTMS.key"
   ```
3. Restart Apache

### ❌ Masalah: HTTP tidak redirect ke HTTPS

**Solusi:**
1. Pastikan mod_rewrite aktif di httpd.conf
2. Pastikan konfigurasi redirect di VirtualHost HTTP benar
3. Restart Apache

### ❌ Masalah: Domain tidak dikenali

**Solusi:**
1. Pastikan file hosts sudah diupdate dengan `nuraniTMS.test`
2. Flush DNS: `ipconfig /flushdns`
3. Restart browser atau gunakan Incognito mode

---

## ✅ CHECKLIST FINAL

Sebelum test, pastikan:

- [ ] Certificate sudah dibuat (`nuraniTMS.crt` dan `nuraniTMS.key`)
- [ ] mod_ssl aktif di `httpd.conf`
- [ ] VirtualHost HTTPS sudah dibuat dengan domain `nuraniTMS.test`
- [ ] File hosts sudah diupdate dengan `nuraniTMS.test`
- [ ] DNS sudah di-flush (`ipconfig /flushdns`)
- [ ] `APP_URL` di `.env` sudah `https://nuraniTMS.test`
- [ ] `SESSION_SECURE_COOKIE=true` di `.env`
- [ ] Cache sudah di-clear
- [ ] Apache sudah di-restart

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah semua langkah:

✅ `https://nuraniTMS.test` bisa diakses  
✅ `http://nuraniTMS.test` otomatis redirect ke HTTPS  
✅ Koneksi terenkripsi dengan SSL/TLS  
✅ Website Laravel muncul dengan benar  
✅ Tidak ada tulisan "test" di domain  

---

## 🆘 MASIH ERROR?

Jika masih error:

1. **Cek error log:** `C:\xampp\apache\logs\error.log`
2. **Cek error log Laravel:** `storage\logs\laravel.log`
3. **Pastikan semua langkah sudah dilakukan dengan benar**
4. **Restart komputer** (sering menyelesaikan masalah DNS)

---

**Ikuti langkah-langkah di atas dengan teliti!**

