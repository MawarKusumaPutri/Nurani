# 🔧 Fix Error: Service Crash Setelah Start (Hijau → Merah)

## ✅ Status Saat Ini
- ✅ Database MySQL: **Online** (hijau)
- ✅ Build: **Berhasil** (hijau)
- ❌ Web Service: **Crash dalam 1 detik** setelah start (merah)

**Masalah:** Service berhasil start (hijau), tapi langsung crash dalam 1 detik. Railway mencoba restart beberapa kali tapi tetap crash.

---

## 🔍 Langkah 1: Cek Logs untuk Error Spesifik (PENTING!)

### A. Cek Deploy Logs:
1. Klik service **"web"** (yang merah)
2. Klik tab **"Deployments"**
3. Klik deployment terbaru
4. Klik **"View Logs"** atau **"Deploy Logs"**
5. **Scroll ke paling bawah** untuk melihat error terakhir

### B. Cek HTTP Logs (PENTING!):
1. Klik service **"web"**
2. Klik tab **"Logs"** (di navigation bar atas)
3. Pilih **"HTTP Logs"** (bukan Deploy Logs)
4. Lihat error yang muncul saat aplikasi diakses

**Error yang Mungkin Muncul:**
- ❌ `SQLSTATE[HY000] [2002] Connection refused`
- ❌ `APP_KEY is not set`
- ❌ `Class not found: ...`
- ❌ `Call to undefined function`
- ❌ `500 Internal Server Error`
- ❌ `Route [xxx] not defined`

**📝 Copy error message lengkap** dari HTTP Logs!

---

## 🔧 Langkah 2: Enable Debug Mode Sementara

### Di Railway Variables:
1. Klik service **"web"** → tab **"Variables"**
2. Edit atau tambahkan:
   ```
   APP_DEBUG=true
   ```
3. Save (Railway akan auto-restart)

**⚠️ PENTING:** Setelah fix, kembalikan ke `APP_DEBUG=false` untuk production!

---

## 🔧 Langkah 3: Pastikan Start Command Sederhana

### Di Railway Settings:
1. Klik service **"web"** → tab **"Settings"**
2. Scroll ke **"Deploy"** → **"Start Command"**
3. Pastikan hanya:
   ```bash
   php artisan serve --host=0.0.0.0 --port=$PORT
   ```

**❌ JANGAN tambahkan:**
- ❌ `php artisan migrate` (jalankan manual via Shell)
- ❌ `php artisan config:cache` (bisa error jika config belum benar)
- ❌ `php artisan route:cache` (bisa error jika route belum benar)

---

## 🔧 Langkah 4: Pastikan Environment Variables Lengkap

### Buka Service Variables:
1. Klik service **"web"** → tab **"Variables"**
2. Pastikan semua variables berikut ada:

#### A. App Variables (WAJIB):
```
APP_NAME=TMS NURANI
APP_ENV=production
APP_DEBUG=true (sementara untuk debug)
APP_KEY=base64:... (HARUS ADA!)
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

#### C. Cache & Session (PENTING!):
```
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

**⚠️ JANGAN gunakan `database` untuk CACHE_DRIVER atau SESSION_DRIVER** karena bisa error jika tabel belum ada!

#### D. Logging:
```
LOG_CHANNEL=stderr
LOG_LEVEL=debug (sementara untuk debug)
```

### Generate APP_KEY (jika belum ada):
1. Klik tab **"Shell"**
2. Jalankan:
   ```bash
   php artisan key:generate --show
   ```
3. Copy output
4. Paste ke variable `APP_KEY` di Variables

---

## 🔧 Langkah 5: Test Database Connection

### Via Railway Shell:
1. Klik service **"web"** → tab **"Shell"**
2. Jalankan:
   ```bash
   php artisan tinker
   ```
3. Di dalam tinker:
   ```php
   DB::connection()->getPdo();
   ```
4. Jika berhasil, ketik `exit`

**Jika error:**
- Cek kembali environment variables database
- Pastikan format: `${{MySQL.MYSQLHOST}}` (double curly braces)

---

## 🔧 Langkah 6: Jalankan Migrations Manual

### Via Railway Shell:
```bash
# Clear cache dulu
php artisan config:clear
php artisan cache:clear

# Cek status migrations
php artisan migrate:status

# Jalankan migrations
php artisan migrate --force
```

**⚠️ JANGAN jalankan migrations di start command!**

---

## 🔧 Langkah 7: Test Health Check Endpoint

### Via Railway Shell:
```bash
curl http://localhost:$PORT/up
```

**Atau via browser:**
- Buka: `https://your-app.railway.app/up`
- Harus return: `{"status":"ok"}`

**Jika error:**
- Cek HTTP Logs untuk error detail
- Kemungkinan ada error di code atau config

---

## 🔧 Langkah 8: Clear Cache & Rebuild

### Via Railway Shell:
```bash
# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Rebuild autoload
composer dump-autoload
```

---

## 🔧 Langkah 9: Cek Storage Permissions

### Via Railway Shell:
```bash
# Pastikan storage link ada
php artisan storage:link

# Cek folder storage
ls -la storage/framework
```

**Jika folder tidak ada:**
```bash
mkdir -p storage/framework/sessions
mkdir -p storage/framework/cache
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/views
```

---

## 🐛 Troubleshooting Berdasarkan Error

### Error 1: `SQLSTATE[HY000] [2002] Connection refused`
**Penyebab:** Database connection gagal saat runtime
**Solusi:**
1. Cek environment variables database
2. Pastikan format: `${{MySQL.MYSQLHOST}}`
3. Test connection via Shell: `php artisan tinker` → `DB::connection()->getPdo();`

### Error 2: `APP_KEY is not set`
**Penyebab:** APP_KEY tidak ada atau kosong
**Solusi:**
1. Generate: `php artisan key:generate --show`
2. Copy dan paste ke Railway Variables

### Error 3: `Class not found` atau `Service provider not found`
**Penyebab:** Autoloader belum update atau missing dependency
**Solusi:**
```bash
composer dump-autoload
composer install --no-dev --optimize-autoloader
```

### Error 4: `500 Internal Server Error` di HTTP Logs
**Penyebab:** Error di code saat aplikasi diakses
**Solusi:**
1. Set `APP_DEBUG=true` untuk lihat error detail
2. Cek HTTP Logs untuk stack trace
3. Perbaiki error di code
4. Set kembali `APP_DEBUG=false`

### Error 5: `Route [xxx] not defined`
**Penyebab:** Route belum terdaftar atau cache route error
**Solusi:**
```bash
php artisan route:clear
php artisan route:cache
```

### Error 6: Service crash saat health check
**Penyebab:** Health check endpoint (`/up`) error
**Solusi:**
1. Cek apakah route `/up` ada di `routes/web.php` atau `bootstrap/app.php`
2. Test: `curl http://localhost:$PORT/up`
3. Jika error, cek HTTP Logs

---

## 📋 Checklist Perbaikan

Ikuti urutan ini:

- [ ] **Langkah 1**: Cek HTTP Logs untuk error spesifik
- [ ] **Langkah 2**: Enable APP_DEBUG=true sementara
- [ ] **Langkah 3**: Pastikan Start Command sederhana
- [ ] **Langkah 4**: Pastikan Environment Variables lengkap
- [ ] **Langkah 5**: Test Database Connection
- [ ] **Langkah 6**: Jalankan Migrations Manual
- [ ] **Langkah 7**: Test Health Check Endpoint
- [ ] **Langkah 8**: Clear Cache & Rebuild
- [ ] **Langkah 9**: Cek Storage Permissions
- [ ] **Verifikasi**: Service harus hijau dan tetap hijau
- [ ] **Final**: Set APP_DEBUG=false untuk production

---

## 💡 Tips Penting

1. **Jangan jalankan migrations di start command**
   - Migrations harus dijalankan manual via Shell
   - Atau gunakan separate migration service

2. **Gunakan CACHE_DRIVER=file dan SESSION_DRIVER=file**
   - Jangan gunakan `database` untuk driver ini
   - Bisa error jika tabel belum ada

3. **Monitor HTTP Logs, bukan hanya Deploy Logs**
   - Deploy Logs: untuk build errors
   - HTTP Logs: untuk runtime errors (ini yang penting!)

4. **Start Command harus sederhana**
   - Jangan tambahkan command yang bisa error
   - Test satu per satu jika perlu optimasi

5. **Enable APP_DEBUG sementara untuk debugging**
   - Lihat error detail di HTTP Logs
   - Set kembali false setelah fix

---

## 🆘 Masih Error?

Jika masih crash setelah semua langkah:

1. **Copy error message lengkap** dari **HTTP Logs** (bukan Deploy Logs!)
2. **Screenshot** error message
3. **Cek** apakah semua environment variables sudah benar
4. **Test** aplikasi lokal dulu untuk memastikan tidak ada error di code
5. **Cek** apakah ada error di `AppServiceProvider` atau service provider lain

---

## 📚 Referensi

- [Railway Documentation - Logs](https://docs.railway.app/develop/logs)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)

---

**Setelah semua langkah, service web seharusnya tetap hijau (Active) dan tidak crash lagi! 🚀**
