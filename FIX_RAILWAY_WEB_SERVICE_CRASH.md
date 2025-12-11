# 🔧 Fix Error: Web Service Crash di Railway (Database Sudah Nyambung)

## ✅ Status Saat Ini
- ✅ Database MySQL: **Online** (hijau)
- ❌ Web Service: **Crashed** (merah)

**Masalah:** Database sudah terhubung, tapi web service masih crash setelah start.

---

## 🔍 Langkah 1: Cek Deploy Logs untuk Error Spesifik

### Di Railway Dashboard:
1. Klik service **"web"** (yang merah)
2. Klik tab **"Deployments"**
3. Klik deployment terbaru yang **CRASHED**
4. Klik **"View Logs"** atau **"Deploy Logs"**
5. **Scroll ke bawah** untuk melihat error terakhir

### Error yang Mungkin Muncul:
- ❌ `Migration failed: ...`
- ❌ `SQLSTATE[42S02]: Base table or view not found`
- ❌ `APP_KEY is not set`
- ❌ `Storage link failed`
- ❌ `Class not found`
- ❌ `500 Internal Server Error`

**📝 Copy error message lengkap** dan simpan untuk referensi.

---

## 🔧 Langkah 2: Perbaiki Build & Start Command

### Buka Service Settings:
1. Klik service **"web"**
2. Klik tab **"Settings"**
3. Scroll ke bagian **"Deploy"**

### Build Command (Hapus Migrations):
```bash
composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan storage:link && npm install && npm run build
```

**⚠️ PENTING:** Jangan jalankan migrations di build command! Migrations harus dijalankan **setelah** aplikasi start atau via Shell.

### Start Command (Tanpa Migrations):
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

**Atau jika perlu optimasi:**
```bash
php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT
```

---

## 🔧 Langkah 3: Jalankan Migrations Manual (PENTING!)

### Via Railway Shell:
1. Klik service **"web"**
2. Klik tab **"Shell"**
3. Jalankan command berikut **satu per satu**:

```bash
# Clear cache dulu
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

```bash
# Cek status migrations
php artisan migrate:status
```

```bash
# Jalankan migrations
php artisan migrate --force
```

```bash
# Jika ada seeders (opsional)
php artisan db:seed --force
```

### Jika Migrations Error:
**Error: `Base table or view not found`**
- Solusi: Pastikan database sudah dibuat dan environment variables sudah benar

**Error: `SQLSTATE[42S02]`**
- Solusi: Cek apakah semua migrations file ada di `database/migrations/`

**Error: `Migration already exists`**
- Solusi: Reset migrations (hati-hati!):
  ```bash
  php artisan migrate:fresh --force
  ```

---

## 🔧 Langkah 4: Pastikan Environment Variables Lengkap

### Buka Service Variables:
1. Klik service **"web"**
2. Klik tab **"Variables"**
3. Pastikan semua variables berikut ada:

#### A. App Variables (WAJIB):
```
APP_NAME=TMS NURANI
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... (harus ada!)
APP_URL=https://your-app.railway.app
```

#### B. Database Variables (WAJIB):
```
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

#### C. Cache & Session:
```
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

#### D. Logging:
```
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

### Generate APP_KEY (jika belum ada):
1. Di Railway Shell, jalankan:
   ```bash
   php artisan key:generate --show
   ```
2. Copy output yang muncul
3. Paste ke variable `APP_KEY` di Railway Variables

---

## 🔧 Langkah 5: Pastikan Storage Link Sudah Dibuat

### Via Railway Shell:
```bash
php artisan storage:link
```

**Jika error "link already exists":**
- Tidak masalah, berarti sudah ada
- Lanjut ke langkah berikutnya

---

## 🔧 Langkah 6: Test Database Connection

### Via Railway Shell:
```bash
php artisan tinker
```

Di dalam tinker, jalankan:
```php
DB::connection()->getPdo();
```

**Jika berhasil:**
- Akan muncul info PDO connection
- Ketik `exit` untuk keluar

**Jika error:**
- Cek kembali environment variables database
- Pastikan format reference variable benar: `${{MySQL.MYSQLHOST}}`

---

## 🔧 Langkah 7: Clear Cache & Rebuild

### Via Railway Shell:
```bash
# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Rebuild cache (opsional, untuk production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔧 Langkah 8: Re-deploy

### Setelah semua perbaikan:
1. Klik tombol **"Deploy"** atau **"Redeploy"** di service
2. Atau push perubahan ke GitHub (jika auto-deploy aktif)
3. Monitor di tab **"Deployments"** → **"View Logs"**
4. Tunggu build selesai (3-5 menit)

---

## 🐛 Troubleshooting Berdasarkan Error

### Error 1: `APP_KEY is not set`
**Solusi:**
1. Generate APP_KEY: `php artisan key:generate --show`
2. Copy dan paste ke Railway Variables

### Error 2: `Migration failed`
**Solusi:**
1. Jalankan migrations manual via Shell
2. Cek error spesifik di logs
3. Perbaiki migration file jika perlu

### Error 3: `Storage link failed`
**Solusi:**
1. Jalankan: `php artisan storage:link`
2. Pastikan folder `storage/app/public` ada

### Error 4: `500 Internal Server Error`
**Solusi:**
1. Set `APP_DEBUG=true` sementara
2. Cek error detail di logs
3. Perbaiki error yang muncul
4. Set kembali `APP_DEBUG=false`

### Error 5: `Class not found` atau `Service provider not found`
**Solusi:**
1. Clear cache: `php artisan config:clear`
2. Rebuild: `composer dump-autoload`
3. Re-deploy

### Error 6: Service crash setelah beberapa detik
**Solusi:**
1. Cek **HTTP Logs** (bukan Deploy Logs)
2. Lihat error saat aplikasi diakses
3. Biasanya karena error di code atau missing dependencies

---

## 📋 Checklist Perbaikan

Ikuti urutan ini:

- [ ] **Langkah 1**: Cek Deploy Logs untuk error spesifik
- [ ] **Langkah 2**: Perbaiki Build & Start Command
- [ ] **Langkah 3**: Jalankan Migrations Manual via Shell
- [ ] **Langkah 4**: Pastikan Environment Variables Lengkap
- [ ] **Langkah 5**: Buat Storage Link
- [ ] **Langkah 6**: Test Database Connection
- [ ] **Langkah 7**: Clear Cache & Rebuild
- [ ] **Langkah 8**: Re-deploy
- [ ] **Verifikasi**: Cek status service (harus hijau/Active)

---

## 💡 Tips Tambahan

1. **Jangan jalankan migrations di build command**
   - Build command untuk install dependencies dan build assets
   - Migrations harus dijalankan setelah aplikasi ready

2. **Gunakan Shell untuk debugging**
   - Railway Shell sangat berguna untuk test command
   - Test satu per satu sebelum deploy

3. **Monitor Logs**
   - Deploy Logs: untuk build errors
   - HTTP Logs: untuk runtime errors
   - Deploy Logs: untuk startup errors

4. **Start Command yang Sederhana**
   - Mulai dengan command sederhana dulu
   - Tambahkan optimasi setelah aplikasi jalan

---

## 🆘 Masih Error?

Jika masih error setelah semua langkah:

1. **Copy error message lengkap** dari Deploy Logs
2. **Screenshot** error message
3. **Cek** apakah semua environment variables sudah benar
4. **Test** aplikasi lokal dulu untuk memastikan tidak ada error di code
5. **Cek** apakah semua dependencies sudah terinstall

---

## 📚 Referensi

- [Railway Documentation - Troubleshooting](https://docs.railway.app/troubleshooting)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)

---

**Setelah semua langkah, service web seharusnya berubah dari merah (Crashed) menjadi hijau (Active)! 🚀**
