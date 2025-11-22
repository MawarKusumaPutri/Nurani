# 🔧 SOLUSI ERROR: DNS_PROBE_FINISHED_NXDOMAIN

Error ini berarti domain `nurani.test` tidak dikenali oleh sistem. Ikuti langkah-langkah berikut:

---

## ✅ LANGKAH PERBAIKAN (URUT!)

### 🔴 LANGKAH 1: PASTIKAN APACHE BERJALAN

1. Buka **XAMPP Control Panel**
2. Pastikan **Apache** statusnya **Running** (hijau)
3. Jika tidak, klik **Start** pada Apache
4. Tunggu sampai status berubah menjadi **Running**

**⚠️ PENTING:** Apache HARUS running sebelum lanjut ke langkah berikutnya!

---

### 🔴 LANGKAH 2: CEK DAN PERBAIKI FILE HOSTS

#### 2.1 Buka File Hosts sebagai Administrator

**Cara Termudah:**
1. Tekan **Windows + R**
2. Ketik: `notepad`
3. Tekan **Ctrl + Shift + Enter** (ini akan run as admin)
4. Klik **Yes** jika muncul UAC prompt

**Cara Alternatif:**
1. Klik **Start Menu**
2. Ketik: `notepad`
3. **Klik kanan** pada Notepad
4. Pilih **"Run as administrator"**
5. Klik **Yes**

#### 2.2 Buka File Hosts

1. Di Notepad, klik **File → Open**
2. Navigasi ke: `C:\Windows\System32\drivers\etc\`
3. Di dropdown **"File type"** (bawah kanan), pilih **"All Files (*.*)"**
4. Pilih file **`hosts`** (tanpa ekstensi, biasanya tidak terlihat)
5. Klik **Open**

#### 2.3 Cek dan Tambahkan Domain

**Scroll ke bagian paling bawah file.**

**Pastikan ada 2 baris ini (TANPA tanda # di depan):**
```
127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

**Jika TIDAK ADA, tambahkan di akhir file:**
```
127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

**⚠️ PENTING:**
- Pastikan ada **spasi** antara `127.0.0.1` dan `nurani.test`
- Jangan ada tanda `#` di depan kedua baris
- Jangan ada spasi di awal baris

**Contoh yang BENAR:**
```
127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

**Contoh yang SALAH:**
```
#127.0.0.1    nurani.test    ← Ada tanda #
 127.0.0.1    nurani.test    ← Ada spasi di awal
127.0.0.1nurani.test         ← Tidak ada spasi
```

#### 2.4 Simpan File

1. Tekan **Ctrl + S** untuk save
2. Jika muncul error "Access Denied":
   - Pastikan Notepad dibuka sebagai Administrator
   - Tutup Notepad, buka lagi sebagai Administrator

---

### 🔴 LANGKAH 3: FLUSH DNS CACHE (PENTING!)

1. Tekan **Windows + R**
2. Ketik: `cmd`
3. Tekan **Ctrl + Shift + Enter** (run as admin)
4. Klik **Yes** jika muncul UAC prompt
5. Di Command Prompt, ketik:
   ```cmd
   ipconfig /flushdns
   ```
6. Tekan **Enter**
7. Anda akan melihat: `Successfully flushed the DNS Resolver Cache.`
8. Tutup Command Prompt

**⚠️ PENTING:** Langkah ini WAJIB dilakukan setelah mengubah file hosts!

---

### 🔴 LANGKAH 4: CEK VIRTUALHOST APACHE

#### 4.1 Buka File httpd-vhosts.conf

1. Buka **XAMPP Control Panel**
2. Klik **Config** pada Apache
3. Pilih **httpd-vhosts.conf**

**Lokasi file:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

#### 4.2 Cek VirtualHost

**Scroll ke bagian bawah file.**

**Pastikan ada konfigurasi ini:**
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

**Jika TIDAK ADA, tambahkan di akhir file.**

**⚠️ PENTING:**
- Pastikan path menggunakan forward slash (`/`) bukan backslash (`\`)
- Pastikan path mengarah ke folder `public`
- Pastikan path absolute (lengkap dengan drive `C:/`)

#### 4.3 Simpan File

- Tekan **Ctrl + S** untuk save

---

### 🔴 LANGKAH 5: AKTIFKAN VIRTUALHOST

#### 5.1 Buka File httpd.conf

1. Di **XAMPP Control Panel**, klik **Config** pada Apache
2. Pilih **httpd.conf**

**Lokasi file:** `C:\xampp\apache\conf\httpd.conf`

#### 5.2 Cek Include VirtualHost

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

#### 5.3 Simpan File

- Tekan **Ctrl + S** untuk save

---

### 🔴 LANGKAH 6: RESTART APACHE

1. Di **XAMPP Control Panel**
2. Klik **Stop** pada Apache (tunggu sampai status berubah)
3. Tunggu 3-5 detik
4. Klik **Start** pada Apache
5. Pastikan status berubah menjadi **Running** (hijau)

**⚠️ PENTING:** Restart Apache WAJIB dilakukan setelah mengubah konfigurasi!

---

### 🔴 LANGKAH 7: CEK PROJECT SUDAH DI HTDOCS

#### 7.1 Verifikasi Folder

Pastikan project sudah ada di:
```
C:\xampp\htdocs\nurani\
```

#### 7.2 Verifikasi Folder Public

Pastikan folder `public` ada di:
```
C:\xampp\htdocs\nurani\public\
```

#### 7.3 Verifikasi File index.php

Pastikan file `index.php` ada di:
```
C:\xampp\htdocs\nurani\public\index.php
```

**Jika project belum di htdocs:**
1. Salin folder `nurani` dari `D:\Capstone\` ke `C:\xampp\htdocs\`
2. Pastikan struktur folder benar

---

### 🔴 LANGKAH 8: TEST LAGI

1. **Tutup semua tab browser** yang terbuka
2. Buka browser **baru** (atau gunakan **Incognito/Private mode**)
3. Ketik di address bar: `http://nurani.test`
4. Tekan **Enter**

**Jika masih error, lanjut ke langkah berikutnya.**

---

### 🔴 LANGKAH 9: CEK ERROR LOG APACHE

1. Buka file: `C:\xampp\apache\logs\error.log`
2. Scroll ke bagian paling bawah
3. Cari error terakhir
4. Baca pesan errornya

**Error umum:**
- `DocumentRoot must be a directory` → Path salah
- `Cannot load module` → Module tidak ditemukan
- `Address already in use` → Port 80 terpakai

---

### 🔴 LANGKAH 10: TEST DENGAN LOCALHOST DULU

Sebelum test dengan domain, test dulu dengan localhost:

1. Buka browser
2. Ketik: `http://localhost/nurani/public`
3. Tekan Enter

**Jika ini berhasil:**
- Artinya Apache dan project sudah benar
- Masalahnya di VirtualHost atau file hosts

**Jika ini TIDAK berhasil:**
- Artinya project belum di htdocs atau path salah
- Perbaiki dulu masalah ini

---

## 🔍 TROUBLESHOOTING TAMBAHAN

### Masalah: File hosts tidak bisa disave

**Solusi:**
1. Pastikan Notepad dibuka sebagai Administrator
2. Tutup semua program yang mungkin membuka file hosts
3. Coba save lagi

### Masalah: Setelah flush DNS masih error

**Solusi:**
1. Restart komputer (cara paling ampuh)
2. Atau restart Windows Explorer:
   - Tekan `Ctrl + Shift + Esc` (Task Manager)
   - Cari "Windows Explorer"
   - Klik kanan → Restart

### Masalah: Apache tidak bisa start

**Solusi:**
1. Cek port 80 terpakai:
   ```cmd
   netstat -ano | findstr :80
   ```
2. Jika ada proses lain, hentikan atau ubah port Apache
3. Cek error log: `C:\xampp\apache\logs\error.log`

### Masalah: VirtualHost tidak bekerja

**Solusi:**
1. Pastikan mod_rewrite aktif:
   - Buka `httpd.conf`
   - Cari: `LoadModule rewrite_module modules/mod_rewrite.so`
   - Pastikan tidak ada tanda `#`
2. Restart Apache

---

## ✅ CHECKLIST FINAL

Sebelum test lagi, pastikan semua sudah dilakukan:

- [ ] Apache **Running** di XAMPP Control Panel
- [ ] File hosts sudah diupdate dengan `127.0.0.1    nurani.test`
- [ ] DNS cache sudah di-flush (`ipconfig /flushdns`)
- [ ] VirtualHost sudah dibuat di `httpd-vhosts.conf`
- [ ] VirtualHost sudah diaktifkan di `httpd.conf`
- [ ] Apache sudah di-restart
- [ ] Project sudah di `C:\xampp\htdocs\nurani\`
- [ ] Folder `public` ada di `C:\xampp\htdocs\nurani\public\`
- [ ] Browser sudah ditutup dan dibuka lagi (atau Incognito mode)

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah semua langkah selesai:

✅ Browser bisa akses `http://nurani.test`  
✅ Tidak ada error DNS_PROBE_FINISHED_NXDOMAIN  
✅ Website Laravel muncul dengan benar  

---

## 🆘 MASIH ERROR?

Jika masih error setelah semua langkah:

1. **Restart komputer** (sering menyelesaikan masalah DNS)
2. **Cek error log Apache:** `C:\xampp\apache\logs\error.log`
3. **Cek error log Laravel:** `C:\xampp\htdocs\nurani\storage\logs\laravel.log`
4. **Test dengan localhost dulu:** `http://localhost/nurani/public`

---

**Ikuti langkah-langkah di atas dengan teliti, terutama Langkah 2, 3, dan 6!**

