# Panduan Deploy Laravel ke Render

## Render: Frontend atau Backend?

**Jawaban: KEDUANYA!** ✅

Render mendukung:
- ✅ **Backend**: PHP (Laravel), Node.js, Python, Ruby, Go, dll
- ✅ **Frontend**: Static sites, React, Vue, Next.js, dll
- ✅ **Database**: PostgreSQL, MySQL, Redis
- ✅ **Background Workers**: Queue workers, cron jobs

**Untuk aplikasi Laravel Anda:**
- ✅ **Sangat Cocok** untuk deploy Laravel backend
- ✅ Support PHP 8.2+ (yang dibutuhkan Laravel 12)
- ✅ Auto-deploy dari GitHub
- ✅ Free tier available

---

## Langkah-langkah Deploy Laravel ke Render

### 1. Persiapan

#### A. Pastikan Project di GitHub
1. Buat repository di GitHub (jika belum)
2. Push semua code ke GitHub:
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/username/nurani.git
git push -u origin main
```

#### B. Siapkan Environment Variables
Buat file `.env.example` dengan semua variables yang diperlukan:
```
APP_NAME="TMS NURANI"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-app.onrender.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

# ... variables lainnya
```

---

### 2. Buat Database di Render

#### Langkah 1: Buat PostgreSQL Database (Recommended)
1. Login ke [render.com](https://render.com)
2. Klik **"New +"** → **"PostgreSQL"**
3. Isi form:
   - **Name**: `nurani-db`
   - **Database**: `nurani`
   - **User**: `nurani_user`
   - **Region**: Pilih terdekat (Singapore recommended)
   - **PostgreSQL Version**: 15 atau 16
   - **Plan**: **Free** (untuk testing)
4. Klik **"Create Database"**
5. Tunggu database dibuat (1-2 menit)
6. **Copy connection string** yang muncul

#### Atau: Buat MySQL Database
1. Klik **"New +"** → **"MySQL"**
2. Isi form sama seperti PostgreSQL
3. **Note**: MySQL di Render biasanya berbayar, PostgreSQL free

---

### 3. Deploy Laravel Application

#### Langkah 1: Buat Web Service
1. Di Render Dashboard, klik **"New +"** → **"Web Service"**
2. Connect GitHub repository:
   - Pilih **"Connect GitHub"**
   - Authorize Render
   - Pilih repository `nurani`
   - Klik **"Connect"**

#### Langkah 2: Konfigurasi Build & Deploy

**Basic Settings:**
- **Name**: `nurani-app` (atau nama lain)
- **Region**: Pilih terdekat (Singapore recommended)
- **Branch**: `main` (atau branch yang digunakan)
- **Root Directory**: `.` (root project)

**Build Command:**
```bash
composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan migrate --force && npm install && npm run build
```

**Start Command:**
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

**Environment Variables:**
Klik **"Add Environment Variable"** dan tambahkan:

```
APP_NAME=TMS NURANI
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.onrender.com
APP_KEY=base64:... (generate dengan: php artisan key:generate)

DB_CONNECTION=pgsql
DB_HOST=your-db-host.onrender.com
DB_PORT=5432
DB_DATABASE=nurani
DB_USERNAME=nurani_user
DB_PASSWORD=your-db-password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stderr
LOG_LEVEL=error
```

**Advanced Settings:**
- **Instance Type**: **Free** (untuk testing)
- **Auto-Deploy**: **Yes** (auto-deploy saat push ke GitHub)

#### Langkah 3: Deploy
1. Klik **"Create Web Service"**
2. Render akan otomatis:
   - Clone repository
   - Install dependencies (Composer + NPM)
   - Build assets (Vite)
   - Run migrations
   - Start application
3. Tunggu proses selesai (5-10 menit pertama kali)
4. Dapatkan URL: `https://your-app.onrender.com`

---

### 4. Konfigurasi Tambahan

#### A. Storage Link (untuk file uploads)
Tambahkan di **Build Command**:
```bash
composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan storage:link && php artisan migrate --force && npm install && npm run build
```

#### B. Queue Worker (jika menggunakan queue)
1. Buat **Background Worker**:
   - **New +** → **"Background Worker"**
   - Connect ke repository yang sama
   - **Start Command**: `php artisan queue:work --sleep=3 --tries=3`
   - Set environment variables yang sama

#### C. Scheduled Tasks (Cron Jobs)
1. Buat **Cron Job**:
   - **New +** → **"Cron Job"**
   - **Schedule**: `*/5 * * * *` (setiap 5 menit)
   - **Command**: `php artisan schedule:run`

---

### 5. Setup Database Connection

#### Untuk PostgreSQL:
1. Install PostgreSQL driver di `composer.json`:
```json
{
    "require": {
        "doctrine/dbal": "^3.0"
    }
}
```

2. Update `.env`:
```
DB_CONNECTION=pgsql
DB_HOST=your-db-host.onrender.com
DB_PORT=5432
DB_DATABASE=nurani
DB_USERNAME=nurani_user
DB_PASSWORD=your-db-password
```

3. Update `config/database.php` jika perlu:
```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
    'schema' => 'public',
    'sslmode' => 'prefer',
],
```

#### Untuk MySQL (jika pakai MySQL):
- Render MySQL biasanya berbayar
- Alternatif: Gunakan database eksternal (PlanetScale, Railway, dll)

---

### 6. File Storage

#### Problem:
Render menggunakan **ephemeral filesystem** (file hilang saat restart)

#### Solution:
1. **Gunakan External Storage** (Recommended):
   - AWS S3
   - DigitalOcean Spaces
   - Cloudinary (untuk images)

2. **Atau**: Gunakan database untuk small files

3. **Setup S3** (contoh):
```bash
composer require league/flysystem-aws-s3-v3
```

Update `config/filesystems.php`:
```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
],
```

---

### 7. Environment Variables Lengkap

Tambahkan semua variables yang diperlukan:

```bash
# App
APP_NAME=TMS NURANI
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://your-app.onrender.com

# Database
DB_CONNECTION=pgsql
DB_HOST=your-db-host.onrender.com
DB_PORT=5432
DB_DATABASE=nurani
DB_USERNAME=nurani_user
DB_PASSWORD=your-db-password

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Mail (jika menggunakan)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@nurani.com
MAIL_FROM_NAME="${APP_NAME}"

# Storage (jika menggunakan S3)
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=your-bucket
AWS_URL=https://your-bucket.s3.amazonaws.com

# Logging
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

---

### 8. Build Script Optimization

Buat file `render.yaml` di root project:

```yaml
services:
  - type: web
    name: nurani-app
    env: php
    buildCommand: composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan storage:link && php artisan migrate --force && npm install && npm run build
    startCommand: php artisan serve --host=0.0.0.0 --port=$PORT
    envVars:
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: LOG_CHANNEL
        value: stderr
```

---

### 9. Custom Domain (Opsional)

1. Di Render Dashboard → Service → **Settings** → **Custom Domains**
2. Tambahkan domain: `nurani.yourdomain.com`
3. Follow instruksi untuk setup DNS:
   - Tambahkan CNAME: `nurani` → `your-app.onrender.com`

---

### 10. Monitoring & Logs

1. **Logs**: Lihat di Render Dashboard → Service → **Logs**
2. **Metrics**: Lihat di **Metrics** tab
3. **Alerts**: Setup di **Alerts** (untuk paid plans)

---

## Troubleshooting

### Error: Build Failed
- Cek build logs di Render Dashboard
- Pastikan `composer.json` dan `package.json` valid
- Pastikan PHP version compatible (8.2+)

### Error: Database Connection Failed
- Cek database credentials
- Pastikan database sudah running
- Cek firewall/network settings

### Error: 500 Internal Server Error
- Cek logs di Render Dashboard
- Pastikan `APP_KEY` sudah di-generate
- Pastikan semua environment variables sudah di-set

### Error: File Upload Tidak Bekerja
- Render filesystem ephemeral
- Gunakan external storage (S3, dll)
- Atau simpan di database untuk small files

### Error: Slow First Request
- Normal untuk free tier (spin down setelah 15 menit idle)
- Upgrade ke paid plan untuk always-on
- Atau gunakan uptime monitoring untuk keep-alive

---

## Pricing

### Free Tier:
- ✅ Web Service: Free (dengan limitations)
- ✅ PostgreSQL: Free (90 days, lalu perlu upgrade)
- ✅ Static Sites: Free
- ⚠️ **Limitation**: Spin down setelah 15 menit idle

### Paid Plans:
- **Starter**: $7/month (always-on, no spin down)
- **Standard**: $25/month (better performance)
- **Pro**: $85/month (production-ready)

---

## Alternatif Render

### 1. Railway (railway.app)
- ✅ Free tier lebih generous
- ✅ Auto-deploy dari GitHub
- ✅ Support Laravel
- ✅ Database included

### 2. Fly.io (fly.io)
- ✅ Global edge deployment
- ✅ Free tier available
- ✅ Support Laravel

### 3. DigitalOcean App Platform
- ✅ Production-ready
- ✅ Auto-scaling
- ⚠️ Paid (mulai $5/month)

---

## Checklist Deploy

- [ ] Project sudah di GitHub
- [ ] Database sudah dibuat di Render
- [ ] Web Service sudah dibuat
- [ ] Environment variables sudah di-set
- [ ] Build command sudah benar
- [ ] Start command sudah benar
- [ ] Database migrations sudah jalan
- [ ] Storage link sudah dibuat (jika perlu)
- [ ] File storage sudah di-setup (S3 atau alternatif)
- [ ] Custom domain sudah di-setup (opsional)
- [ ] Testing di production URL

---

## Next Steps

1. ✅ Deploy ke Render
2. ✅ Test semua fitur
3. ✅ Setup monitoring
4. ✅ Setup backup database
5. ✅ Setup custom domain (opsional)
6. ✅ Optimize performance

---

**Need Help?**
- Render Docs: https://render.com/docs
- Render Support: support@render.com
- Laravel Deployment: https://laravel.com/docs/deployment

