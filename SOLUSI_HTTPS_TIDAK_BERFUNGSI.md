# 🚨 SOLUSI: https://nurani.test Tidak Berfungsi

Panduan step-by-step untuk memperbaiki HTTPS yang tidak berfungsi.

---

## ⚡ LANGKAH CEPAT (Ikuti Urut!)

### 🔴 LANGKAH 1: Jalankan Script Cek

**Double-click:** `CEK_KONFIGURASI_HTTPS.bat`

Script akan mengecek semua konfigurasi. **Catat semua [ERROR] yang muncul!**

---

### 🔴 LANGKAH 2: Buat Certificate (Jika Belum Ada)

**Jika certificate belum ada, jalankan:**

**Double-click:** `SCRIPT_BUAT_CERTIFICATE.bat`

**Saat diminta informasi, isi:**
```
Country Name: ID
State: Jakarta
City: Jakarta
Organization: MTs Nurul Aiman
Organizational Unit: IT Department
Common Name: nurani.test    ← PENTING!
Email: admin@nurani.test
```

**Untuk "A challenge password" dan "An optional company name", tekan Enter saja.**

**Pastikan file dibuat di:**
- `C:\xampp\apache\conf\ssl\nurani.crt`
- `C:\xampp\apache\conf\ssl\nurani.key`

---

### 🔴 LANGKAH 3: Aktifkan mod_ssl

1. **Buka:** `C:\xampp\apache\conf\httpd.conf`

2. **Cari baris ini (gunakan Ctrl + F):**
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

### 🔴 LANGKAH 4: Buat VirtualHost HTTPS

1. **Buka:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

2. **Hapus semua VirtualHost lama untuk nurani.test** (jika ada)

3. **Buka file:** `KONFIGURASI_VIRTUALHOST_HTTPS.txt`

4. **Copy seluruh isinya**

5. **Paste di akhir file** `httpd-vhosts.conf`

6. **Simpan:** Ctrl + S

**Pastikan ada 2 VirtualHost:**
- VirtualHost untuk HTTP (port 80) - redirect ke HTTPS
- VirtualHost untuk HTTPS (port 443) - dengan SSL

---

### 🔴 LANGKAH 5: Update .env

1. **Buka file:** `.env`

2. **Cari baris:**
   ```env
   APP_URL=http://nurani.test
   ```
   atau
   ```env
   APP_URL=http://127.0.0.1:8000
   ```

3. **Ubah menjadi:**
   ```env
   APP_URL=https://nurani.test
   ```

4. **Tambahkan juga (jika belum ada):**
   ```env
   SESSION_SECURE_COOKIE=true
   ```

5. **Simpan:** Ctrl + S

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

1. **Buka XAMPP Control Panel**

2. **Klik Stop pada Apache** (tunggu sampai status berubah)

3. **Tunggu 3-5 detik**

4. **Klik Start pada Apache**

5. **Pastikan status Running** (hijau)

**⚠️ PENTING:** Restart Apache WAJIB dilakukan setelah mengubah konfigurasi!

---

### 🔴 LANGKAH 8: Test

1. **Tutup semua tab browser**

2. **Buka browser baru** (atau gunakan **Incognito/Private mode**)

3. **Ketik:** `https://nurani.test`

4. **Tekan Enter**

**Hasil yang diharapkan:**
- Browser menampilkan peringatan keamanan (normal untuk self-signed certificate)
- Klik **"Advanced"** atau **"Advanced settings"**
- Klik **"Proceed to nurani.test (unsafe)"** atau **"Continue to nurani.test"**
- Website Laravel muncul

---

## 🔍 TROUBLESHOOTING

### ❌ Masalah: "This site can't be reached" di HTTPS

**Penyebab:** Port 443 tidak listen atau VirtualHost salah

**Solusi:**
1. Cek error log: `C:\xampp\apache\logs\error.log`
2. Pastikan VirtualHost HTTPS sudah benar
3. Pastikan mod_ssl aktif
4. Restart Apache

### ❌ Masalah: "ERR_SSL_PROTOCOL_ERROR"

**Penyebab:** Certificate tidak valid atau path salah

**Solusi:**
1. Pastikan certificate sudah dibuat
2. Cek path di VirtualHost:
   ```apache
   SSLCertificateFile "C:/xampp/apache/conf/ssl/nurani.crt"
   SSLCertificateKeyFile "C:/xampp/apache/conf/ssl/nurani.key"
   ```
3. Pastikan menggunakan forward slash (`/`)
4. Restart Apache

### ❌ Masalah: HTTP tidak redirect ke HTTPS

**Penyebab:** mod_rewrite tidak aktif atau konfigurasi redirect salah

**Solusi:**
1. Cek mod_rewrite aktif di httpd.conf:
   ```apache
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
2. Pastikan konfigurasi redirect di VirtualHost HTTP benar
3. Restart Apache

### ❌ Masalah: Browser tidak menerima certificate

**Penyebab:** Normal untuk self-signed certificate

**Solusi:**
1. Ini **NORMAL** untuk self-signed certificate
2. Klik **"Advanced"** → **"Proceed to site"**
3. Browser akan menampilkan peringatan setiap kali (ini normal)

---

## ✅ CHECKLIST FINAL

Sebelum test lagi, pastikan:

- [ ] Certificate sudah dibuat (`nurani.crt` dan `nurani.key`)
- [ ] mod_ssl aktif di `httpd.conf`
- [ ] httpd-ssl.conf diaktifkan di `httpd.conf`
- [ ] VirtualHost HTTPS sudah dibuat
- [ ] Path certificate benar di VirtualHost
- [ ] `APP_URL` di `.env` sudah `https://nurani.test`
- [ ] `SESSION_SECURE_COOKIE=true` di `.env`
- [ ] Cache sudah di-clear
- [ ] Apache sudah di-restart

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah semua langkah:

✅ `https://nurani.test` bisa diakses  
✅ `http://nurani.test` otomatis redirect ke HTTPS  
✅ Koneksi terenkripsi dengan SSL/TLS  
✅ Website Laravel muncul dengan benar  

---

## 🆘 MASIH ERROR?

Jika masih error:

1. **Jalankan:** `CEK_KONFIGURASI_HTTPS.bat` untuk cek masalah
2. **Cek error log:** `C:\xampp\apache\logs\error.log`
3. **Restart komputer** (sering menyelesaikan masalah)
4. **Pastikan semua langkah sudah dilakukan dengan benar**

---

**Ikuti langkah-langkah di atas dengan teliti, terutama Langkah 3, 4, dan 7!**

