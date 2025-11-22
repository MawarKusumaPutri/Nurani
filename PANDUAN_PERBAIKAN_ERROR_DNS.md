# 🚨 PERBAIKAN ERROR: DNS_PROBE_FINISHED_NXDOMAIN

Error `DNS_PROBE_FINISHED_NXDOMAIN` berarti domain `nurani.test` tidak dikenali. 

**Ikuti langkah-langkah berikut dengan TELITI:**

---

## ⚡ LANGKAH CEPAT (5 MENIT)

### ✅ LANGKAH 1: Jalankan Script Cek Konfigurasi

**Double-click file:** `CEK_KONFIGURASI_APACHE.bat`

Script ini akan mengecek:
- Apache running atau tidak
- File hosts sudah benar atau belum
- VirtualHost sudah dibuat atau belum
- Project sudah di htdocs atau belum

**Catat semua [ERROR] yang muncul!**

---

### ✅ LANGKAH 2: Perbaiki File Hosts (PALING PENTING!)

#### Cara 1: Menggunakan Script (Mudah)

**Double-click file:** `PERBAIKAN_URGEN_DNS_ERROR.bat`

Script ini akan:
- Flush DNS cache
- Membuka file hosts untuk diedit
- Memandu Anda step-by-step

#### Cara 2: Manual (Jika script tidak bekerja)

**2.1 Buka Notepad sebagai Administrator:**
1. Tekan **Windows + R**
2. Ketik: `notepad`
3. Tekan **Ctrl + Shift + Enter** (run as admin)
4. Klik **Yes**

**2.2 Buka File Hosts:**
1. Di Notepad: **File → Open**
2. Navigasi ke: `C:\Windows\System32\drivers\etc\`
3. Di dropdown "File type", pilih **"All Files (*.*)"**
4. Pilih file **`hosts`**
5. Klik **Open**

**2.3 Tambahkan Domain:**
Scroll ke bagian paling bawah, tambahkan:
```
127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

**2.4 Simpan:**
- Tekan **Ctrl + S**
- Jika error "Access Denied", pastikan Notepad dibuka sebagai Admin

**2.5 Flush DNS:**
Buka CMD sebagai admin, jalankan:
```cmd
ipconfig /flushdns
```

---

### ✅ LANGKAH 3: Cek VirtualHost Apache

**3.1 Buka httpd-vhosts.conf:**
1. XAMPP Control Panel → Config (Apache) → httpd-vhosts.conf

**3.2 Cek VirtualHost:**
Pastikan ada konfigurasi ini di akhir file:
```apache
<VirtualHost *:80>
    ServerName nurani.test
    ServerAlias www.nurani.test
    DocumentRoot "C:/xampp/htdocs/nurani/public"
    
    <Directory "C:/xampp/htdocs/nurani/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Jika TIDAK ADA, copy-paste dari file:** `COPY_PASTE_VIRTUALHOST.txt`

**3.3 Simpan:** Ctrl + S

---

### ✅ LANGKAH 4: Aktifkan VirtualHost

**4.1 Buka httpd.conf:**
1. XAMPP Control Panel → Config (Apache) → httpd.conf

**4.2 Cari baris:**
Tekan **Ctrl + F**, cari: `Include conf/extra/httpd-vhosts.conf`

**4.3 Pastikan TIDAK ada tanda `#`:**
```apache
Include conf/extra/httpd-vhosts.conf    ← BENAR
#Include conf/extra/httpd-vhosts.conf   ← SALAH (hapus tanda #)
```

**4.4 Simpan:** Ctrl + S

---

### ✅ LANGKAH 5: Restart Apache

1. XAMPP Control Panel
2. Klik **Stop** pada Apache
3. Tunggu 3 detik
4. Klik **Start** pada Apache
5. Pastikan status **Running** (hijau)

---

### ✅ LANGKAH 6: Test Lagi

1. **Tutup semua tab browser**
2. Buka browser **baru** (atau **Incognito mode**)
3. Ketik: `http://nurani.test`
4. Tekan Enter

---

## 🔍 TROUBLESHOOTING LANJUTAN

### Masalah: File hosts tidak bisa disave

**Solusi:**
1. Pastikan Notepad dibuka sebagai Administrator
2. Tutup semua program lain
3. Coba save lagi
4. Jika masih error, restart komputer

### Masalah: Setelah semua langkah masih error

**Solusi:**
1. **Restart komputer** (sering menyelesaikan masalah DNS)
2. Setelah restart, test lagi: `http://nurani.test`

### Masalah: Apache tidak bisa start

**Solusi:**
1. Cek port 80 terpakai:
   - Buka CMD sebagai admin
   - Jalankan: `netstat -ano | findstr :80`
2. Jika ada proses lain, hentikan di Task Manager
3. Atau ubah port Apache di httpd.conf: `Listen 8080`

### Masalah: Project tidak ditemukan

**Solusi:**
1. Pastikan project sudah di: `C:\xampp\htdocs\nurani\`
2. Jika belum, salin dari: `D:\Capstone\nurani` ke `C:\xampp\htdocs\`
3. Pastikan folder `public` ada

---

## ✅ CHECKLIST FINAL

Sebelum test lagi, pastikan:

- [ ] Apache **Running** di XAMPP
- [ ] File hosts sudah ada `127.0.0.1    nurani.test`
- [ ] DNS sudah di-flush (`ipconfig /flushdns`)
- [ ] VirtualHost sudah dibuat
- [ ] VirtualHost sudah diaktifkan
- [ ] Apache sudah di-restart
- [ ] Browser sudah ditutup dan dibuka lagi

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah semua langkah:
- ✅ Browser bisa akses `http://nurani.test`
- ✅ Tidak ada error DNS
- ✅ Website Laravel muncul

---

## 🆘 MASIH ERROR?

Jika masih error:

1. **Jalankan:** `CEK_KONFIGURASI_APACHE.bat` untuk cek masalah
2. **Restart komputer** (sering menyelesaikan masalah)
3. **Cek error log:** `C:\xampp\apache\logs\error.log`

---

**Ikuti langkah-langkah di atas dengan teliti!**

