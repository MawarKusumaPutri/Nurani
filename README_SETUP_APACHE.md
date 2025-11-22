# 🚀 SETUP APACHE XAMPP - RINGKASAN CEPAT

Mengubah `http://127.0.0.1:8000` menjadi `http://nurani.test` tanpa port.

---

## ⚡ LANGKAH CEPAT (5 MENIT)

### 1️⃣ Salin Project
```
Dari: D:\Capstone\nurani
Ke:   C:\xampp\htdocs\nurani
```

### 2️⃣ Copy VirtualHost

**Buka:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

**Paste di akhir file:**
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

### 3️⃣ Aktifkan VirtualHost

**Buka:** `C:\xampp\apache\conf\httpd.conf`

**Pastikan baris ini TIDAK ada tanda `#`:**
```apache
Include conf/extra/httpd-vhosts.conf
```

### 4️⃣ Edit File Hosts

**Buka sebagai Admin:** `C:\Windows\System32\drivers\etc\hosts`

**Tambahkan di akhir:**
```
127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

**Flush DNS:**
```cmd
ipconfig /flushdns
```

### 5️⃣ Update .env

**File:** `C:\xampp\htdocs\nurani\.env`

**Ubah:**
```env
APP_URL=http://nurani.test
```

### 6️⃣ Clear Cache

Jalankan `setup-apache.bat` atau:
```cmd
cd C:\xampp\htdocs\nurani
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 7️⃣ Restart Apache

Di XAMPP Control Panel → Stop → Start

### 8️⃣ Test

Buka browser: **http://nurani.test**

---

## 📁 FILE YANG SUDAH DISEDIAKAN

1. **KONFIGURASI_VIRTUALHOST_APACHE.txt** - Copy-paste VirtualHost
2. **KONFIGURASI_FILE_HOSTS.txt** - Copy-paste file hosts
3. **LANGKAH_SETUP_APACHE_LENGKAP.md** - Panduan detail lengkap
4. **setup-apache.bat** - Script clear cache otomatis

---

## 🔧 TROUBLESHOOTING CEPAT

| Masalah | Solusi |
|---------|--------|
| Can't reach | Restart Apache |
| 403 Forbidden | Cek path di VirtualHost (harus ke `public`) |
| 404 Not Found | Cek DocumentRoot, pastikan ke `public` |
| Domain tidak dikenali | `ipconfig /flushdns` |
| 500 Error | Cek `storage/logs/laravel.log` |

---

## 📖 PANDUAN LENGKAP

Lihat: **LANGKAH_SETUP_APACHE_LENGKAP.md**

---

**Selamat! 🎉**

