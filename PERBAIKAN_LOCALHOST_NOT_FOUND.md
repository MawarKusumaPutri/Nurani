# 🔧 PERBAIKAN: localhost/nurani/public Not Found

Error "Not Found" berarti project belum ada di htdocs atau path salah.

---

## ⚡ SOLUSI CEPAT

### 🔴 LANGKAH 1: Salin Project ke htdocs

**Double-click:** `SALIN_PROJECT_KE_HTDOCS.bat`

Script ini akan:
- ✅ Menyalin project dari `D:\Capstone\nurani` ke `C:\xampp\htdocs\nurani`
- ✅ Memverifikasi folder public ada
- ✅ Memverifikasi file penting ada

**ATAU salin manual:**

1. **Buka:** `D:\Capstone\nurani`
2. **Copy seluruh folder** (Ctrl + C)
3. **Paste ke:** `C:\xampp\htdocs\` (Ctrl + V)
4. **Pastikan nama folder:** `nurani`

**Struktur yang benar:**
```
C:\xampp\htdocs\nurani\
  ├── app\
  ├── bootstrap\
  ├── config\
  ├── database\
  ├── public\          ← PASTIKAN folder ini ada!
  │   └── index.php   ← PASTIKAN file ini ada!
  ├── resources\
  ├── routes\
  ├── storage\
  ├── vendor\
  └── artisan
```

---

### 🔴 LANGKAH 2: Verifikasi Project

**Pastikan file penting ada:**

1. **Folder public:**
   ```
   C:\xampp\htdocs\nurani\public\index.php
   ```

2. **File artisan:**
   ```
   C:\xampp\htdocs\nurani\artisan
   ```

3. **File .env:**
   ```
   C:\xampp\htdocs\nurani\.env
   ```

**Jika file tidak ada, salin ulang project.**

---

### 🔴 LANGKAH 3: Test dengan localhost

1. **Pastikan Apache running** di XAMPP Control Panel
2. **Buka browser**
3. **Ketik:** `http://localhost/nurani/public`
4. **Tekan Enter**

**Hasil yang diharapkan:**
- ✅ Website Laravel muncul
- ✅ Tidak ada error "Not Found"

---

### 🔴 LANGKAH 4: Jika Masih Error "Not Found"

#### Masalah 1: Path Salah

**Cek path di browser:**
- ✅ BENAR: `http://localhost/nurani/public`
- ❌ SALAH: `http://localhost/nurani/public/` (dengan slash di akhir)
- ❌ SALAH: `http://localhost/nurani` (tanpa /public)

#### Masalah 2: Folder Tidak Ada

**Cek folder:**
1. Buka: `C:\xampp\htdocs\`
2. Pastikan folder `nurani` ada
3. Pastikan folder `public` ada di dalam `nurani`

#### Masalah 3: File index.php Tidak Ada

**Cek file:**
1. Buka: `C:\xampp\htdocs\nurani\public\`
2. Pastikan file `index.php` ada

#### Masalah 4: Apache Tidak Running

**Solusi:**
1. Buka XAMPP Control Panel
2. Klik **Start** pada Apache
3. Pastikan status **Running** (hijau)

#### Masalah 5: .htaccess Tidak Ada

**Cek file:**
1. Buka: `C:\xampp\htdocs\nurani\public\`
2. Pastikan file `.htaccess` ada

**Jika tidak ada, buat file `.htaccess` dengan isi:**

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

---

## ✅ CHECKLIST

Sebelum test, pastikan:

- [ ] Project sudah di `C:\xampp\htdocs\nurani\`
- [ ] Folder `public` ada di `C:\xampp\htdocs\nurani\public\`
- [ ] File `index.php` ada di `C:\xampp\htdocs\nurani\public\index.php`
- [ ] File `.htaccess` ada di `C:\xampp\htdocs\nurani\public\.htaccess`
- [ ] File `artisan` ada di `C:\xampp\htdocs\nurani\artisan`
- [ ] Apache **Running** di XAMPP Control Panel

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah semua langkah:

✅ `http://localhost/nurani/public` bisa diakses  
✅ Website Laravel muncul  
✅ Tidak ada error "Not Found"  

---

## 🆘 MASIH ERROR?

Jika masih error "Not Found":

1. **Cek folder:** `C:\xampp\htdocs\nurani\public\index.php` harus ada
2. **Cek Apache running** di XAMPP Control Panel
3. **Cek error log:** `C:\xampp\apache\logs\error.log`
4. **Test dengan:** `http://localhost/` (harus muncul halaman XAMPP)

---

**Ikuti langkah-langkah di atas dengan teliti, terutama Langkah 1!**

