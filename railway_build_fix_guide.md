# 🔧 Fix Railway Build Failed

## 🐛 Masalah: Build Failed di Railway

Build gagal biasanya karena beberapa hal. Ikuti langkah-langkah berikut:

---

## 📋 Langkah 1: Cek Build Logs

### Di Railway Dashboard:
1. Klik service **"Nurani"**
2. Klik tab **"Deployments"**
3. Klik deployment yang **failed** (yang merah)
4. Klik **"View Logs"**
5. **Copy error message** yang muncul

**Error umum:**
- `composer install` failed
- `npm install` failed
- `php artisan` command failed
- Missing files
- Environment variables missing

---

## 📋 Langkah 2: Perbaiki Build Command

### Di Railway Dashboard:
1. Klik service **"Nurani"**
2. Klik tab **"Settings"**
3. Scroll ke **"Deploy"** section
4. Cek **"Build Command"**

### Build Command yang Benar:
```bash
composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan storage:link && php artisan migrate --force && npm install && npm run build
```

**Jika masih error, coba versi lebih sederhana:**
```bash
composer install --no-dev --optimize-autoloader && npm install && npm run build
```

**Lalu run migrations manual via Shell:**
```bash
php artisan migrate --force
```

---

## 📋 Langkah 3: Perbaiki Start Command

### Di Railway Settings:
**Start Command yang Benar:**
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

**Atau jika error, coba:**
```bash
php -S 0.0.0.0:$PORT -t public
```

---

## 📋 Langkah 4: Setup Environment Variables

### Variables Wajib:
1. Klik service **"Nurani"**
2. Klik tab **"Variables"**
3. Tambahkan variables berikut:

```
APP_NAME=TMS NURANI
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app
APP_KEY=base64:... (generate dengan: php artisan key:generate --show)
```

**Untuk Database (setelah buat database):**
```
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

---

## 📋 Langkah 5: Cek File yang Diperlukan

### Pastikan file-file ini ada di GitHub:
- ✅ `composer.json`
- ✅ `package.json`
- ✅ `artisan`
- ✅ `public/index.php`
- ✅ `bootstrap/app.php`
- ✅ `.env.example` (recommended)

### Pastikan file-file ini di `.gitignore`:
- ✅ `.env`
- ✅ `vendor/`
- ✅ `node_modules/`

---

## 📋 Langkah 6: Common Errors & Solutions

### Error 1: `composer install` failed
**Solusi:**
```bash
# Pastikan composer.json valid
composer validate

# Test install lokal
composer install --no-dev
```

### Error 2: `npm install` failed
**Solusi:**
```bash
# Pastikan package.json valid
npm install --dry-run

# Test build lokal
npm run build
```

### Error 3: `php artisan` command failed
**Solusi:**
- Pastikan `APP_KEY` sudah di-set
- Pastikan semua environment variables sudah di-set
- Cek PHP version (harus 8.2+)

### Error 4: Missing files
**Solusi:**
- Pastikan semua file sudah di-commit
- Pastikan `.gitignore` tidak exclude file penting
- Push ulang ke GitHub

### Error 5: Database connection failed
**Solusi:**
- Pastikan database sudah dibuat
- Pastikan database variables sudah di-set
- Test connection via Shell

---

## 📋 Langkah 7: Re-deploy

### Setelah perbaikan:
1. **Update code di GitHub** (jika ada perubahan)
2. Di Railway, klik **"Redeploy"**
3. Atau push ulang ke GitHub (auto-deploy)
4. Monitor build logs

---

## 📋 Langkah 8: Test Build Lokal

### Sebelum deploy, test build lokal:
```bash
# Install dependencies
composer install --no-dev --optimize-autoloader
npm install

# Build assets
npm run build

# Test artisan commands
php artisan --version
php artisan key:generate --show
```

Jika build lokal berhasil, deploy ke Railway seharusnya juga berhasil.

---

## 🎯 Quick Fix Checklist

- [ ] Cek build logs di Railway
- [ ] Copy error message
- [ ] Perbaiki build command
- [ ] Perbaiki start command
- [ ] Setup environment variables
- [ ] Pastikan semua file di GitHub
- [ ] Test build lokal
- [ ] Re-deploy

---

## 💡 Tips

1. **Build Command**: Mulai dengan yang sederhana, tambahkan command satu per satu
2. **Logs**: Selalu cek logs untuk error spesifik
3. **Environment Variables**: Set semua variables sebelum deploy
4. **Database**: Buat database dulu sebelum deploy
5. **Test Locally**: Test build lokal sebelum deploy

---

## 🆘 Masih Error?

Jika masih error setelah semua langkah:

1. **Copy error message** dari Railway logs
2. **Screenshot** error message
3. **Cek** apakah semua file sudah di GitHub
4. **Test** build lokal dulu
5. **Coba** build command yang lebih sederhana

---

**Need Help?**
- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- Laravel Docs: https://laravel.com/docs

