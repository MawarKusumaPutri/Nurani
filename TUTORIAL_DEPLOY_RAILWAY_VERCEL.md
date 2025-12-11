# Tutorial Deploy Laravel: Backend di Railway & Frontend di Vercel

## 📋 Daftar Isi
1. [Persiapan](#persiapan)
2. [Deploy Backend Laravel ke Railway](#deploy-backend-laravel-ke-railway)
3. [Setup Frontend untuk Vercel](#setup-frontend-untuk-vercel)
4. [Konfigurasi Environment Variables](#konfigurasi-environment-variables)
5. [Testing & Troubleshooting](#testing--troubleshooting)

---

## 🚀 Persiapan

### 1. Persiapan Repository
```bash
# Pastikan semua perubahan sudah di-commit
git add .
git commit -m "Prepare for deployment"
git push origin main
```

### 2. Install Dependencies
```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies
npm install
npm run build
```

### 3. Setup Environment
Buat file `.env.production` untuk production:
```env
APP_NAME="Nurani TMS"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-backend.railway.app

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=your-railway-db-host
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your-railway-db-password

# Storage
FILESYSTEM_DISK=public

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Mail (gunakan Mailgun, SendGrid, atau SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@nurani.app
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🚂 Deploy Backend Laravel ke Railway

### Langkah 1: Buat Akun Railway
1. Kunjungi [railway.app](https://railway.app)
2. Sign up dengan GitHub
3. Verifikasi email

### Langkah 2: Buat Project Baru
1. Klik **"New Project"**
2. Pilih **"Deploy from GitHub repo"**
3. Pilih repository Anda
4. Railway akan otomatis detect Laravel

### Langkah 3: Setup Database MySQL
1. Di dashboard Railway, klik **"+ New"**
2. Pilih **"Database"** → **"Add MySQL"**
3. Tunggu sampai database siap
4. Copy connection details:
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

### Langkah 4: Konfigurasi Environment Variables
Di Railway dashboard, buka **"Variables"** tab dan tambahkan:

```env
APP_NAME="Nurani TMS"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-backend.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

FILESYSTEM_DISK=public
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@nurani.app
MAIL_FROM_NAME="${APP_NAME}"
```

### Langkah 5: Setup Build Command
Di Railway dashboard, buka **"Settings"** → **"Build & Deploy"**:

**Build Command:**
```bash
composer install --optimize-autoloader --no-dev && php artisan key:generate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**Start Command:**
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

### Langkah 6: Setup Nixpacks (Opsional)
Buat file `nixpacks.toml` di root project:

```toml
[phases.setup]
nixPkgs = ["php82", "composer", "nodejs-18_x", "npm"]

[phases.install]
cmds = [
  "composer install --optimize-autoloader --no-dev",
  "npm install",
  "npm run build"
]

[phases.build]
cmds = [
  "php artisan key:generate --force",
  "php artisan config:cache",
  "php artisan route:cache",
  "php artisan view:cache",
  "php artisan migrate --force"
]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"
```

### Langkah 7: Setup Storage Link
Buat file `railway.json` atau tambahkan di build command:

```bash
php artisan storage:link
```

### Langkah 8: Deploy
1. Railway akan otomatis deploy saat ada push ke GitHub
2. Atau klik **"Deploy"** manual
3. Tunggu sampai build selesai
4. Copy URL yang diberikan (contoh: `https://your-app.railway.app`)

### Langkah 9: Run Migrations
Setelah deploy, jalankan migration:

**Via Railway CLI:**
```bash
railway run php artisan migrate --force
```

**Atau via Railway Dashboard:**
1. Buka **"Deployments"**
2. Klik deployment terbaru
3. Buka **"Logs"**
4. Jalankan command: `php artisan migrate --force`

---

## 🎨 Setup Frontend untuk Vercel

### Opsi 1: Laravel Full-Stack di Vercel (Tidak Direkomendasikan)
Vercel tidak ideal untuk Laravel karena:
- Laravel memerlukan PHP runtime
- Vercel fokus pada serverless functions
- Blade templates perlu PHP

### Opsi 2: Memisahkan Frontend (Direkomendasikan)

#### A. Buat Frontend Baru dengan Next.js/React

**1. Buat Project Next.js:**
```bash
npx create-next-app@latest nurani-frontend
cd nurani-frontend
```

**2. Install Dependencies:**
```bash
npm install axios
npm install @tanstack/react-query
```

**3. Setup API Client:**
Buat file `lib/api.js`:

```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_URL || 'https://your-backend.railway.app',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true,
});

// Request interceptor
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export default api;
```

**4. Setup Environment Variables:**
Buat file `.env.local`:

```env
NEXT_PUBLIC_API_URL=https://your-backend.railway.app
```

**5. Deploy ke Vercel:**
```bash
# Install Vercel CLI
npm i -g vercel

# Login
vercel login

# Deploy
vercel

# Atau connect via GitHub
# 1. Kunjungi vercel.com
# 2. Import project dari GitHub
# 3. Set environment variables
# 4. Deploy
```

#### B. Atau Gunakan Laravel dengan Static Export (Alternatif)

**1. Install Laravel Breeze API:**
```bash
composer require laravel/breeze --dev
php artisan breeze:install api
```

**2. Setup CORS:**
File `config/cors.php`:
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['https://your-frontend.vercel.app'],
'allowed_origins_patterns' => [],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => true,
```

**3. Buat API Routes:**
File `routes/api.php`:
```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Tambahkan routes API lainnya
Route::prefix('guru')->middleware('auth:sanctum')->group(function () {
    // Routes untuk guru
});
```

---

## 🔧 Konfigurasi Environment Variables

### Backend (Railway)
```env
APP_URL=https://your-backend.railway.app
FRONTEND_URL=https://your-frontend.vercel.app
```

### Frontend (Vercel)
Di Vercel Dashboard → Settings → Environment Variables:

```env
NEXT_PUBLIC_API_URL=https://your-backend.railway.app
```

---

## 🧪 Testing & Troubleshooting

### Test Backend API
```bash
# Test health check
curl https://your-backend.railway.app/api/health

# Test dengan Postman/Insomnia
GET https://your-backend.railway.app/api/user
Headers: Authorization: Bearer YOUR_TOKEN
```

### Common Issues

**1. CORS Error:**
- Pastikan `config/cors.php` sudah dikonfigurasi
- Pastikan `allowed_origins` include frontend URL

**2. Database Connection Error:**
- Pastikan environment variables di Railway sudah benar
- Pastikan database sudah running

**3. Storage Link Error:**
- Jalankan `php artisan storage:link` di Railway
- Pastikan storage folder writable

**4. 500 Error:**
- Check logs di Railway dashboard
- Pastikan `APP_DEBUG=false` di production
- Check `.env` variables

**5. Frontend tidak bisa connect ke backend:**
- Pastikan `NEXT_PUBLIC_API_URL` sudah di-set
- Check CORS configuration
- Check network tab di browser console

---

## 📝 Checklist Deployment

### Backend (Railway)
- [ ] Database MySQL sudah dibuat
- [ ] Environment variables sudah di-set
- [ ] Build command sudah dikonfigurasi
- [ ] Start command sudah dikonfigurasi
- [ ] Migrations sudah dijalankan
- [ ] Storage link sudah dibuat
- [ ] CORS sudah dikonfigurasi
- [ ] API routes sudah dibuat
- [ ] Testing API berhasil

### Frontend (Vercel)
- [ ] Project sudah dibuat (Next.js/React)
- [ ] API client sudah dikonfigurasi
- [ ] Environment variables sudah di-set
- [ ] Deploy ke Vercel berhasil
- [ ] Testing koneksi ke backend berhasil

---

## 🔗 Resources

- [Railway Documentation](https://docs.railway.app)
- [Vercel Documentation](https://vercel.com/docs)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Next.js Documentation](https://nextjs.org/docs)

---

## 💡 Tips

1. **Gunakan Railway Pro** untuk production (lebih stabil)
2. **Setup monitoring** dengan Sentry atau Bugsnag
3. **Setup CI/CD** dengan GitHub Actions
4. **Backup database** secara berkala
5. **Monitor logs** secara rutin
6. **Setup domain custom** untuk production

---

## 🆘 Butuh Bantuan?

Jika ada masalah, check:
1. Railway logs
2. Vercel logs
3. Browser console
4. Network tab
5. Laravel logs (jika bisa diakses)

Good luck dengan deployment! 🚀

