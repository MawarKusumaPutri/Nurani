# 🌐 Cara Menjalankan TMS Nurani dengan Ngrok

## 📋 Prasyarat
- PHP sudah terinstall
- Ngrok sudah terinstall (download dari https://ngrok.com/download)
- Composer sudah terinstall

---

## 🚀 Cara Menjalankan (MUDAH)

### **Opsi 1: Menggunakan Script Otomatis (RECOMMENDED)**

#### Terminal 1 - Laravel Server:
```powershell
.\start-server.ps1
```

#### Terminal 2 - Ngrok Tunnel:
```powershell
.\start-ngrok.ps1
```

### **Opsi 2: Manual**

#### Terminal 1 - Laravel Server:
```powershell
# Clear cache
php artisan optimize:clear

# Jalankan server
php artisan serve --host=127.0.0.1 --port=8000
```

#### Terminal 2 - Ngrok Tunnel:
```powershell
ngrok http 8000
```

---

## 📱 Cara Akses

1. **Setelah ngrok berjalan**, Anda akan melihat output seperti ini:
   ```
   Forwarding  https://abc123.ngrok-free.dev -> http://127.0.0.1:8000
   ```

2. **Copy URL ngrok** (contoh: `https://abc123.ngrok-free.dev`)

3. **Akses di browser**:
   - URL: `https://abc123.ngrok-free.dev/nurani/public/`
   - Atau: `https://abc123.ngrok-free.dev` (jika sudah setup public path)

4. **Jika muncul halaman "Visit Site"** dari ngrok:
   - Klik tombol **"Visit Site"**
   - Halaman akan terbuka

---

## ⚠️ Troubleshooting

### Masalah: Halaman Blank Putih

**Solusi 1: Clear Cache**
```powershell
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
```

**Solusi 2: Cek Error Log**
```powershell
# Lihat error terbaru
Get-Content storage\logs\laravel.log -Tail 50
```

**Solusi 3: Enable Debug Mode**
1. Buka file `.env`
2. Ubah `APP_DEBUG=false` menjadi `APP_DEBUG=true`
3. Refresh browser
4. Lihat error yang muncul

**Solusi 4: Cek PHP Error**
```powershell
# Test apakah PHP berjalan dengan baik
php -v
php artisan --version
```

### Masalah: Ngrok "ERR_NGROK_108"

**Solusi:**
1. Pastikan Laravel server berjalan di port 8000
2. Restart ngrok
3. Jika masih error, coba port lain:
   ```powershell
   # Terminal 1
   php artisan serve --port=8080
   
   # Terminal 2
   ngrok http 8080
   ```

### Masalah: "Data guru tidak ditemukan"

**Solusi:**
1. Login dengan akun yang benar (lihat `LOGIN_CREDENTIALS.md`)
2. Pastikan database sudah di-seed:
   ```powershell
   php artisan db:seed
   ```

---

## 🔒 Keamanan

⚠️ **PENTING**: Jangan gunakan ngrok untuk production!
- Ngrok hanya untuk development/testing
- URL ngrok berubah setiap kali restart (kecuali pakai akun berbayar)
- Untuk production, gunakan Railway atau hosting lainnya

---

## 📞 Bantuan

Jika masih ada masalah:
1. Cek apakah Laravel server berjalan: http://127.0.0.1:8000
2. Cek apakah ngrok terhubung: http://127.0.0.1:4040 (ngrok dashboard)
3. Lihat error log di `storage/logs/laravel.log`
4. Pastikan `.env` sudah benar

---

## 🎯 Quick Commands

```powershell
# Stop semua server
# Tekan Ctrl+C di kedua terminal

# Restart server
# Terminal 1: Ctrl+C, lalu jalankan lagi start-server.ps1
# Terminal 2: Ctrl+C, lalu jalankan lagi start-ngrok.ps1

# Clear cache
php artisan optimize:clear

# Lihat routes
php artisan route:list

# Lihat logs
Get-Content storage\logs\laravel.log -Tail 50
```
