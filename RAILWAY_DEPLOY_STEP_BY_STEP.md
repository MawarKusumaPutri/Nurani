# 🚀 Panduan Deploy Laravel ke Railway - Step by Step

## 📋 Persiapan Awal

### 1. Pastikan Project Siap

#### A. Cek File yang Diperlukan
Pastikan file-file ini ada di project:
- ✅ `composer.json` (sudah ada)
- ✅ `package.json` (sudah ada)
- ✅ `.env.example` (untuk reference)
- ✅ `artisan` (Laravel command)
- ✅ `public/index.php` (entry point)

#### B. Update `.env.example` untuk Production
Pastikan `.env.example` memiliki semua variables yang diperlukan:
```env
APP_NAME="TMS NURANI"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stderr
LOG_LEVEL=error
```

#### C. Pastikan Project di GitHub
```bash
# Cek apakah sudah di GitHub
git remote -v

# Jika belum, buat repository di GitHub dulu, lalu:
git init
git add .
git commit -m "Initial commit for Railway deployment"
git branch -M main
git remote add origin https://github.com/username/nurani.git
git push -u origin main
```

---

## 🎯 Langkah 1: Buat Akun Railway

### Step 1.1: Kunjungi Railway
1. Buka browser
2. Kunjungi: **https://railway.app**
3. Klik tombol **"Start a New Project"** atau **"Login"**

### Step 1.2: Sign Up
1. Klik **"Login with GitHub"** (Recommended)
   - Atau pilih **"Login with Google"** / **"Login with Email"**
2. Authorize Railway untuk akses GitHub
3. Verifikasi email jika diperlukan

### Step 1.3: Dashboard Railway
Setelah login, Anda akan masuk ke **Railway Dashboard**

---

## 🎯 Langkah 2: Buat Project Baru

### Step 2.1: New Project
1. Di Railway Dashboard, klik **"+ New Project"**
2. Pilih **"Deploy from GitHub repo"**
   - Atau pilih **"Empty Project"** jika ingin setup manual

### Step 2.2: Connect GitHub (jika pilih GitHub)
1. Jika pertama kali, klik **"Configure GitHub App"**
2. Pilih repository yang akan di-deploy: **`nurani`**
3. Klik **"Deploy Now"**
4. Railway akan otomatis:
   - ✅ Clone repository
   - ✅ Detect Laravel
   - ✅ Setup PHP environment
   - ✅ Start build process

### Step 2.3: Tunggu Build
- Build pertama kali: **3-5 menit**
- Railway akan otomatis:
  - Install Composer dependencies
  - Install NPM dependencies
  - Build assets (Vite)
  - Setup environment

---

## 🎯 Langkah 3: Setup Database MySQL

### Step 3.1: Tambahkan Database
1. Di project dashboard, klik **"+ New"**
2. Pilih **"Database"**
3. Pilih **"Add MySQL"**
   - Atau **"Add PostgreSQL"** (jika prefer PostgreSQL)

### Step 3.2: Database Settings
- **Name**: `nurani-db` (atau nama lain)
- Railway otomatis setup:
  - Host
  - Port
  - Database name
  - Username
  - Password

### Step 3.3: Copy Connection Info
1. Klik database yang baru dibuat
2. Klik tab **"Variables"**
3. **Copy semua connection variables**:
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`
   - `MYSQL_URL` (connection string lengkap)

---

## 🎯 Langkah 4: Setup Environment Variables

### Step 4.1: Buka Service Settings
1. Di project dashboard, klik **service** (web service Laravel)
2. Klik tab **"Variables"**

### Step 4.2: Tambahkan Variables

Klik **"+ New Variable"** dan tambahkan satu per satu:

#### A. App Variables
```
APP_NAME=TMS NURANI
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app
```

#### B. Database Variables (dari database yang dibuat)
```
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

**Atau gunakan connection string:**
```
DATABASE_URL=${MYSQL_URL}
```

#### C. App Key (Generate)
1. Klik **"Generate"** di Railway
2. Atau generate manual:
   ```bash
   php artisan key:generate --show
   ```
3. Copy dan paste ke:
   ```
   APP_KEY=base64:...
   ```

#### D. Cache & Session
```
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

#### E. Logging
```
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

#### F. Mail (jika menggunakan email)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@nurani.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 4.3: Save Variables
- Railway otomatis save
- Service akan **auto-restart** dengan variables baru

---

## 🎯 Langkah 5: Konfigurasi Build & Start Commands

### Step 5.1: Buka Service Settings
1. Klik service (web service)
2. Klik tab **"Settings"**
3. Scroll ke **"Deploy"** section

### Step 5.2: Build Command
Railway biasanya auto-detect, tapi pastikan:

```bash
composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan storage:link && php artisan migrate --force && npm install && npm run build
```

**Penjelasan:**
- `composer install`: Install PHP dependencies
- `--no-dev`: Skip dev dependencies (production)
- `--optimize-autoloader`: Optimize autoloader
- `php artisan key:generate`: Generate APP_KEY
- `php artisan storage:link`: Link storage untuk file uploads
- `php artisan migrate`: Run database migrations
- `npm install`: Install NPM dependencies
- `npm run build`: Build assets (Vite)

### Step 5.3: Start Command
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

**Penjelasan:**
- `--host=0.0.0.0`: Listen di semua interfaces
- `--port=$PORT`: Gunakan port dari Railway (otomatis)

### Step 5.4: Save Settings
- Klik **"Save"** atau **"Deploy"**

---

## 🎯 Langkah 6: Run Database Migrations

### Step 6.1: Via Railway Shell
1. Di service dashboard, klik tab **"Deployments"**
2. Klik deployment terbaru
3. Klik **"View Logs"**
4. Cek apakah migrations sudah jalan (dari build command)

### Step 6.2: Manual Migration (jika perlu)
1. Klik tab **"Shell"** di service
2. Run command:
   ```bash
   php artisan migrate --force
   ```

### Step 6.3: Seed Database (opsional)
```bash
php artisan db:seed --force
```

---

## 🎯 Langkah 7: Setup Storage (File Uploads)

### Problem:
Railway menggunakan **ephemeral filesystem** (file hilang saat restart)

### Solution Options:

#### Option 1: External Storage (Recommended)
**Gunakan AWS S3 atau Cloudinary:**

1. **Setup S3:**
   ```bash
   composer require league/flysystem-aws-s3-v3
   ```

2. Update `config/filesystems.php`:
   ```php
   's3' => [
       'driver' => 's3',
       'key' => env('AWS_ACCESS_KEY_ID'),
       'secret' => env('AWS_SECRET_ACCESS_KEY'),
       'region' => env('AWS_DEFAULT_REGION'),
       'bucket' => env('AWS_BUCKET'),
   ],
   ```

3. Tambahkan variables di Railway:
   ```
   AWS_ACCESS_KEY_ID=your-key
   AWS_SECRET_ACCESS_KEY=your-secret
   AWS_DEFAULT_REGION=ap-southeast-1
   AWS_BUCKET=your-bucket
   FILESYSTEM_DISK=s3
   ```

#### Option 2: Database Storage (untuk small files)
- Simpan file sebagai BLOB di database
- Tidak recommended untuk large files

#### Option 3: Temporary (untuk testing)
- Gunakan `storage/app/public` untuk testing
- **Note**: File akan hilang saat restart

---

## 🎯 Langkah 8: Deploy & Test

### Step 8.1: Trigger Deploy
1. Klik **"Deploy"** di service
2. Atau push ke GitHub (auto-deploy)

### Step 8.2: Monitor Build
1. Klik tab **"Deployments"**
2. Klik deployment terbaru
3. Klik **"View Logs"**
4. Monitor progress:
   - ✅ Installing dependencies
   - ✅ Building assets
   - ✅ Running migrations
   - ✅ Starting server

### Step 8.3: Get URL
1. Setelah deploy selesai, klik tab **"Settings"**
2. Scroll ke **"Domains"**
3. Copy **Railway URL**: `https://your-app.railway.app`
4. Atau klik **"Generate Domain"** untuk custom domain

### Step 8.4: Test Aplikasi
1. Buka URL di browser
2. Test:
   - ✅ Homepage load
   - ✅ Login berfungsi
   - ✅ Dashboard load
   - ✅ Database connection OK
   - ✅ File upload (jika sudah setup storage)

---

## 🎯 Langkah 9: Setup Custom Domain (Opsional)

### Step 9.1: Add Domain
1. Di service **Settings** → **Domains**
2. Klik **"Custom Domain"**
3. Masukkan domain: `nurani.yourdomain.com`

### Step 9.2: Setup DNS
1. Railway akan berikan **CNAME record**
2. Setup di domain provider:
   - **Type**: CNAME
   - **Name**: `nurani` (atau `@` untuk root)
   - **Value**: `your-app.railway.app`

### Step 9.3: Wait for SSL
- Railway otomatis setup SSL (Let's Encrypt)
- Tunggu 5-10 menit
- Test di browser: `https://nurani.yourdomain.com`

---

## 🎯 Langkah 10: Setup Queue Worker (Jika Perlu)

### Step 10.1: Create Background Worker
1. Di project, klik **"+ New"**
2. Pilih **"Background Worker"**
3. Connect ke repository yang sama

### Step 10.2: Configure Worker
- **Start Command**: `php artisan queue:work --sleep=3 --tries=3`
- **Environment Variables**: Copy dari web service

### Step 10.3: Update Queue Connection
Di environment variables web service:
```
QUEUE_CONNECTION=database
```

---

## 🎯 Langkah 11: Setup Cron Jobs (Jika Perlu)

### Step 11.1: Create Cron Service
1. Di project, klik **"+ New"**
2. Pilih **"Cron Job"**

### Step 11.2: Configure Cron
- **Schedule**: `*/5 * * * *` (setiap 5 menit)
- **Command**: `php artisan schedule:run`

---

## 📋 Checklist Deploy

- [ ] Project sudah di GitHub
- [ ] Akun Railway sudah dibuat
- [ ] Project sudah dibuat di Railway
- [ ] Database MySQL sudah dibuat
- [ ] Environment variables sudah di-set
- [ ] Build command sudah benar
- [ ] Start command sudah benar
- [ ] Migrations sudah jalan
- [ ] Storage sudah di-setup (S3/Cloudinary)
- [ ] Deploy berhasil
- [ ] Aplikasi bisa diakses
- [ ] Login berfungsi
- [ ] Database connection OK
- [ ] Custom domain sudah di-setup (opsional)

---

## 🐛 Troubleshooting

### Error: Build Failed
**Solusi:**
1. Cek logs di Railway Dashboard
2. Pastikan `composer.json` valid
3. Pastikan PHP version compatible (8.2+)
4. Pastikan semua dependencies terinstall

### Error: Database Connection Failed
**Solusi:**
1. Cek database variables sudah benar
2. Pastikan database sudah running
3. Cek connection string format
4. Test connection via Shell:
   ```bash
   php artisan tinker
   DB::connection()->getPdo();
   ```

### Error: 500 Internal Server Error
**Solusi:**
1. Cek logs di Railway Dashboard
2. Pastikan `APP_KEY` sudah di-generate
3. Pastikan semua environment variables sudah di-set
4. Cek `APP_DEBUG=true` untuk detail error

### Error: File Upload Tidak Bekerja
**Solusi:**
1. Setup external storage (S3/Cloudinary)
2. Atau gunakan database untuk small files
3. Pastikan `storage:link` sudah dijalankan

### Error: Slow First Request
**Solusi:**
- Normal untuk free tier (cold start)
- Upgrade ke paid plan untuk always-on
- Atau setup uptime monitoring

---

## 💡 Tips & Best Practices

1. **Environment Variables:**
   - Jangan commit `.env` ke GitHub
   - Gunakan Railway Variables untuk secrets
   - Gunakan `${VAR}` untuk reference variables lain

2. **Database:**
   - Backup database secara berkala
   - Gunakan connection pooling untuk performance
   - Monitor database usage

3. **Storage:**
   - Gunakan external storage (S3) untuk production
   - Jangan simpan file di filesystem Railway
   - Setup CDN untuk static assets

4. **Performance:**
   - Enable caching (Redis/Memcached)
   - Optimize database queries
   - Use CDN for assets

5. **Security:**
   - Set `APP_DEBUG=false` di production
   - Use HTTPS (Railway auto-setup)
   - Keep dependencies updated

---

## 🎉 Next Steps

Setelah deploy berhasil:

1. ✅ Test semua fitur
2. ✅ Setup monitoring
3. ✅ Setup backup database
4. ✅ Setup custom domain
5. ✅ Optimize performance
6. ✅ Setup CI/CD (auto-deploy)

---

## 📚 Resources

- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- Laravel Deployment: https://laravel.com/docs/deployment

---

**Selamat! Aplikasi Laravel Anda sudah di-deploy ke Railway! 🚀**

