# ⚡ QUICK START - Setup HTTPS (5 Menit)

Panduan cepat untuk setup HTTPS di Laravel dengan XAMPP.

---

## 🚀 LANGKAH CEPAT

### 1️⃣ Buat Certificate

**Double-click:** `SCRIPT_BUAT_CERTIFICATE.bat`

Ikuti instruksi di layar. Saat diminta informasi, isi:
- Country: `ID`
- State: `Jakarta`
- City: `Jakarta`
- Organization: `MTs Nurul Aiman`
- Common Name: `nurani.test`

---

### 2️⃣ Aktifkan mod_ssl

**Buka:** `C:\xampp\apache\conf\httpd.conf`

**Cari dan hapus tanda `#` di depan:**
```apache
LoadModule ssl_module modules/mod_ssl.so
Include conf/extra/httpd-ssl.conf
```

**Simpan:** Ctrl + S

---

### 3️⃣ Update VirtualHost

**Buka:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

**Hapus VirtualHost lama, copy-paste dari:** `KONFIGURASI_VIRTUALHOST_HTTPS.txt`

**Simpan:** Ctrl + S

---

### 4️⃣ Update .env

**Buka:** `.env`

**Ubah:**
```env
APP_URL=https://nurani.test
```

**Simpan:** Ctrl + S

---

### 5️⃣ Clear Cache

Jalankan:
```cmd
cd C:\xampp\htdocs\nurani
php artisan config:clear
php artisan cache:clear
```

**ATAU** double-click: `setup-apache.bat`

---

### 6️⃣ Restart Apache

XAMPP Control Panel → Stop → Start Apache

---

### 7️⃣ Test

Buka browser: **https://nurani.test**

**⚠️ Peringatan keamanan akan muncul (normal untuk self-signed certificate):**
- Klik **"Advanced"**
- Klik **"Proceed to nurani.test (unsafe)"**

---

## ✅ Checklist

- [ ] Certificate sudah dibuat
- [ ] mod_ssl aktif
- [ ] VirtualHost HTTPS sudah dibuat
- [ ] APP_URL sudah diupdate ke https://
- [ ] Cache sudah di-clear
- [ ] Apache sudah di-restart

---

## 🔧 Troubleshooting

| Masalah | Solusi |
|---------|--------|
| mod_ssl not found | Download XAMPP versi lengkap |
| Certificate error | Pastikan path certificate benar |
| HTTP tidak redirect | Cek mod_rewrite aktif |
| Browser warning | Normal untuk self-signed, klik "Advanced" → "Proceed" |

---

## 📖 Panduan Lengkap

Lihat: **PANDUAN_SETUP_HTTPS_XAMPP.md**

---

**Selamat! Website Anda sekarang menggunakan HTTPS! 🔒**

