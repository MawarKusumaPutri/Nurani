# ⚡ Quick Start - Setup Apache XAMPP

Panduan cepat untuk setup Laravel dengan Apache (5 menit).

---

## 🚀 Langkah Cepat

### 1️⃣ Salin Project ke htdocs
```
Dari: D:\Capstone\nurani
Ke:   C:\xampp\htdocs\nurani
```

### 2️⃣ Buat VirtualHost

**File:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

Tambahkan di akhir file:
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

**File:** `C:\xampp\apache\conf\httpd.conf`

Pastikan baris ini **TIDAK** ada tanda `#`:
```apache
Include conf/extra/httpd-vhosts.conf
```

### 4️⃣ Edit File Hosts

**File:** `C:\Windows\System32\drivers\etc\hosts`

Tambahkan:
```
127.0.0.1    nurani.test
127.0.0.1    www.nurani.test
```

**Cara buka:**
- Tekan `Win + R`
- Ketik: `notepad`
- Tekan `Ctrl + Shift + Enter` (run as admin)
- File → Open → `C:\Windows\System32\drivers\etc\hosts`

### 5️⃣ Update .env

**File:** `.env`

Ubah:
```env
APP_URL=http://nurani.test
```

### 6️⃣ Clear Cache

Jalankan di Command Prompt:
```cmd
cd C:\xampp\htdocs\nurani
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**ATAU** double-click file: `setup-apache.bat`

### 7️⃣ Restart Apache

Di XAMPP Control Panel:
- Stop Apache
- Start Apache

### 8️⃣ Test

Buka browser: **http://nurani.test**

---

## ✅ Checklist

- [ ] Project di `C:\xampp\htdocs\nurani\`
- [ ] VirtualHost dibuat
- [ ] VirtualHost diaktifkan di httpd.conf
- [ ] File hosts diupdate
- [ ] APP_URL di .env diupdate
- [ ] Cache di-clear
- [ ] Apache di-restart
- [ ] Test di browser

---

## 🔧 Troubleshooting Cepat

| Error | Solusi |
|-------|--------|
| Can't reach | Apache tidak running, restart Apache |
| 403 Forbidden | Cek path di VirtualHost, pastikan ke folder `public` |
| 404 Not Found | Cek DocumentRoot, pastikan ke `public` |
| Domain tidak dikenali | Flush DNS: `ipconfig /flushdns` |
| 500 Error | Cek `storage/logs/laravel.log` |

---

## 📖 Panduan Lengkap

Lihat file: **PANDUAN_SETUP_APACHE_XAMPP.md**

---

**Selamat! 🎉**

