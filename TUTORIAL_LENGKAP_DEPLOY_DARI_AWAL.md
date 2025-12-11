# 📚 Tutorial Lengkap Deploy Laravel: Backend Railway & Frontend Vercel
## Dari Awal Sampai Berhasil Deploy

---

## 📋 DAFTAR ISI

1. [Persiapan Awal](#1-persiapan-awal)
2. [Persiapan Repository GitHub](#2-persiapan-repository-github)
3. [Deploy Backend Laravel ke Railway](#3-deploy-backend-laravel-ke-railway)
4. [Setup Database di Railway](#4-setup-database-di-railway)
5. [Konfigurasi Environment Variables](#5-konfigurasi-environment-variables)
6. [Setup Build & Deploy di Railway](#6-setup-build--deploy-di-railway)
7. [Run Migrations](#7-run-migrations)
8. [Setup Frontend (Opsi A: Tetap Laravel Full-Stack)](#8-setup-frontend-opsi-a-tetap-laravel-full-stack)
9. [Setup Frontend (Opsi B: Pisahkan dengan Next.js)](#9-setup-frontend-opsi-b-pisahkan-dengan-nextjs)
10. [Testing & Verifikasi](#10-testing--verifikasi)
11. [Troubleshooting](#11-troubleshooting)

---

## 1. PERSIAPAN AWAL

### 1.1 Software yang Diperlukan

Pastikan sudah install:
- ✅ **Git** - [Download Git](https://git-scm.com/downloads)
- ✅ **Composer** - [Download Composer](https://getcomposer.org/download/)
- ✅ **Node.js & NPM** - [Download Node.js](https://nodejs.org/)
- ✅ **Text Editor** (VS Code, Sublime, dll)
- ✅ **Akun GitHub** - [Sign up GitHub](https://github.com/signup)
- ✅ **Akun Railway** - [Sign up Railway](https://railway.app)
- ✅ **Akun Vercel** - [Sign up Vercel](https://vercel.com/signup)

### 1.2 Verifikasi Install

Buka Terminal/Command Prompt dan cek:

```bash
# Cek Git
git --version
# Output: git version 2.x.x

# Cek Composer
composer --version
# Output: Composer version 2.x.x

# Cek Node.js
node --version
# Output: v18.x.x atau v20.x.x

# Cek NPM
npm --version
# Output: 9.x.x atau 10.x.x
```

Jika ada yang belum terinstall, install dulu sebelum lanjut.

---

## 2. PERSIAPAN REPOSITORY GITHUB

### 2.1 Buat Repository di GitHub

1. **Login ke GitHub**
   - Buka [github.com](https://github.com)
   - Login dengan akun Anda

2. **Buat Repository Baru**
   - Klik tombol **"+"** di kanan atas
   - Pilih **"New repository"**
   - Isi:
     - **Repository name**: `nurani-tms` (atau nama lain)
     - **Description**: "Nurani TMS - Laravel Application"
     - **Visibility**: Pilih **Public** atau **Private**
     - **JANGAN** centang "Add a README file"
     - **JANGAN** centang "Add .gitignore"
     - **JANGAN** centang "Choose a license"
   - Klik **"Create repository"**

3. **Copy URL Repository**
   - Setelah repository dibuat, copy URL-nya
   - Contoh: `https://github.com/username/nurani-tms.git`

### 2.2 Push Project ke GitHub

Buka Terminal/Command Prompt di folder project Anda:

```bash
# 1. Masuk ke folder project
cd D:\Praktikum DWBI\xampp\htdocs\nurani

# 2. Cek status Git
git status

# 3. Jika belum ada Git, inisialisasi
git init

# 4. Tambahkan semua file
git add .

# 5. Buat commit pertama
git commit -m "Initial commit - Prepare for deployment"

# 6. Tambahkan remote repository
git remote add origin https://github.com/username/nurani-tms.git
# Ganti username dengan username GitHub Anda

# 7. Push ke GitHub
git branch -M main
git push -u origin main
```

**Jika ada error "fatal: not a git repository":**
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/username/nurani-tms.git
git branch -M main
git push -u origin main
```

**Jika diminta login GitHub:**
- Gunakan Personal Access Token (bukan password)
- Cara buat: GitHub → Settings → Developer settings → Personal access tokens → Generate new token
- Beri permission: `repo` (full control)

### 2.3 Buat File .gitignore (Jika Belum Ada)

Buat file `.gitignore` di root project:

```gitignore
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.idea
/.vscode
```

**Commit .gitignore:**
```bash
git add .gitignore
git commit -m "Add .gitignore"
git push
```

---

## 3. DEPLOY BACKEND LARAVEL KE RAILWAY

### 3.1 Buat Akun Railway

1. **Kunjungi Railway**
   - Buka [railway.app](https://railway.app)
   - Klik **"Start a New Project"** atau **"Login"**

2. **Sign Up dengan GitHub**
   - Pilih **"Login with GitHub"**
   - Authorize Railway untuk akses GitHub
   - Tunggu sampai redirect ke dashboard

3. **Verifikasi Email** (jika diminta)
   - Cek email Anda
   - Klik link verifikasi

### 3.2 Buat Project Baru di Railway

1. **Klik "New Project"**
   - Di dashboard Railway, klik tombol **"+ New Project"**

2. **Pilih "Deploy from GitHub repo"**
   - Pilih opsi **"Deploy from GitHub repo"**
   - Railway akan menampilkan list repository GitHub Anda

3. **Pilih Repository**
   - Cari dan pilih repository `nurani-tms` (atau nama repository Anda)
   - Klik repository tersebut

4. **Tunggu Railway Detect**
   - Railway akan otomatis detect bahwa ini adalah Laravel project
   - Tunggu sampai muncul "Detected: Laravel" atau "Detected: PHP"

5. **Railway Akan Otomatis Deploy**
   - Railway akan mulai build project
   - Tunggu sampai build selesai (bisa 2-5 menit)
   - **JANGAN PANIK** jika ada error di tahap ini, kita akan fix nanti

### 3.3 Dapatkan URL Backend

1. **Buka Settings**
   - Setelah deploy, klik tab **"Settings"**

2. **Generate Domain**
   - Scroll ke bagian **"Domains"**
   - Klik **"Generate Domain"**
   - Railway akan generate URL seperti: `nurani-tms-production.up.railway.app`
   - **Copy URL ini**, kita akan pakai nanti

---

## 4. SETUP DATABASE DI RAILWAY

### 4.1 Tambah Database MySQL

1. **Klik "+ New"**
   - Di dashboard Railway project Anda
   - Klik tombol **"+ New"**

2. **Pilih "Database"**
   - Pilih **"Database"** dari dropdown
   - Pilih **"Add MySQL"**

3. **Tunggu Database Siap**
   - Railway akan membuat database MySQL
   - Tunggu sampai status menjadi **"Active"** (biasanya 1-2 menit)

4. **Buka Database Settings**
   - Klik database yang baru dibuat
   - Buka tab **"Variables"**

5. **Copy Database Credentials**
   - Railway akan memberikan variables:
     - `MYSQLHOST`
     - `MYSQLPORT`
     - `MYSQLDATABASE`
     - `MYSQLUSER`
     - `MYSQLPASSWORD`
   - **JANGAN copy manual**, kita akan pakai reference variable

---

## 5. KONFIGURASI ENVIRONMENT VARIABLES

### 5.1 Buka Variables di Railway

1. **Kembali ke Service Laravel**
   - Klik service Laravel (bukan database)
   - Buka tab **"Variables"**

2. **Tambah Environment Variables**

Klik **"+ New Variable"** dan tambahkan satu per satu:

#### Variable 1: APP_NAME
```
Name: APP_NAME
Value: Nurani TMS
```

#### Variable 2: APP_ENV
```
Name: APP_ENV
Value: production
```

#### Variable 3: APP_KEY
**PENTING:** Generate APP_KEY dulu di local:

```bash
# Di terminal local, jalankan:
php artisan key:generate --show
```

Copy output yang muncul (contoh: `base64:xxxxxxxxxxxxx`), lalu:

```
Name: APP_KEY
Value: base64:xxxxxxxxxxxxx (paste yang tadi)
```

#### Variable 4: APP_DEBUG
```
Name: APP_DEBUG
Value: false
```

#### Variable 5: APP_URL
```
Name: APP_URL
Value: https://nurani-tms-production.up.railway.app
(Ganti dengan URL Railway Anda)
```

#### Variable 6: DB_CONNECTION
```
Name: DB_CONNECTION
Value: mysql
```

#### Variable 7: DB_HOST
```
Name: DB_HOST
Value: ${{MySQL.MYSQLHOST}}
(Catatan: MySQL adalah nama service database Anda, jika berbeda ganti)
```

#### Variable 8: DB_PORT
```
Name: DB_PORT
Value: ${{MySQL.MYSQLPORT}}
```

#### Variable 9: DB_DATABASE
```
Name: DB_DATABASE
Value: ${{MySQL.MYSQLDATABASE}}
```

#### Variable 10: DB_USERNAME
```
Name: DB_USERNAME
Value: ${{MySQL.MYSQLUSER}}
```

#### Variable 11: DB_PASSWORD
```
Name: DB_PASSWORD
Value: ${{MySQL.MYSQLPASSWORD}}
```

#### Variable 12: FILESYSTEM_DISK
```
Name: FILESYSTEM_DISK
Value: public
```

#### Variable 13: SESSION_DRIVER
```
Name: SESSION_DRIVER
Value: database
```

#### Variable 14: SESSION_LIFETIME
```
Name: SESSION_LIFETIME
Value: 120
```

### 5.2 Cek Nama Service Database

**PENTING:** Jika nama service database bukan "MySQL", ganti di variables:

1. **Lihat Nama Service Database**
   - Di dashboard Railway, lihat nama service database
   - Contoh: "Postgres", "MySQL Database", dll

2. **Ganti Reference Variable**
   - Jika nama service adalah "Postgres", gunakan: `${{Postgres.MYSQLHOST}}`
   - Jika nama service adalah "MySQL Database", gunakan: `${{MySQL Database.MYSQLHOST}}`
   - Atau lihat di tab "Variables" database, ada contoh reference variable

---

## 6. SETUP BUILD & DEPLOY DI RAILWAY

### 6.1 Buka Settings

1. **Klik Service Laravel**
   - Klik service Laravel di dashboard

2. **Buka Tab "Settings"**
   - Scroll ke bagian **"Build & Deploy"**

### 6.2 Setup Build Command

Di bagian **"Build Command"**, paste:

```bash
composer install --optimize-autoloader --no-dev && npm install && npm run build && php artisan key:generate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### 6.3 Setup Start Command

Di bagian **"Start Command"**, paste:

```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

### 6.4 Setup Healthcheck (Opsional)

Di bagian **"Healthcheck Path"**, isi:

```
/
```

### 6.5 Save Settings

- Klik **"Save"** atau **"Update"**
- Railway akan otomatis redeploy dengan settings baru

---

## 7. RUN MIGRATIONS

### 7.1 Via Railway Dashboard

1. **Buka Deployments**
   - Klik tab **"Deployments"**
   - Klik deployment terbaru

2. **Buka Logs**
   - Scroll ke bagian bawah
   - Lihat logs deployment

3. **Run Migration Command**
   - Di bagian **"Command"** atau **"Terminal"**
   - Jalankan:
   ```bash
   php artisan migrate --force
   ```

### 7.2 Via Railway CLI (Alternatif)

1. **Install Railway CLI**
   ```bash
   npm install -g @railway/cli
   ```

2. **Login**
   ```bash
   railway login
   ```

3. **Link Project**
   ```bash
   railway link
   ```

4. **Run Migration**
   ```bash
   railway run php artisan migrate --force
   ```

### 7.3 Verifikasi Migration

Setelah migration selesai, cek di logs:
- Harus ada pesan: "Migration table created successfully"
- Atau: "Migrated: xxxx_xx_xx_xxxxxx_create_xxx_table"

---

## 8. SETUP FRONTEND (OPSI A: TETAP LARAVEL FULL-STACK)

### 8.1 Catatan Penting

**Laravel sudah full-stack!** Artinya:
- ✅ Frontend sudah ada (Blade templates)
- ✅ Backend sudah ada (Laravel API)
- ✅ Tidak perlu pisahkan
- ✅ Semua sudah di Railway

### 8.2 Setup Storage Link

1. **Via Railway CLI**
   ```bash
   railway run php artisan storage:link
   ```

2. **Atau Tambahkan di Build Command**
   Edit build command menjadi:
   ```bash
   composer install --optimize-autoloader --no-dev && npm install && npm run build && php artisan key:generate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```

### 8.3 Setup CORS (Jika Perlu)

Jika nanti ada frontend terpisah, edit `config/cors.php`:

```php
'allowed_origins' => [
    'https://your-frontend.vercel.app',
    env('FRONTEND_URL', 'http://localhost:3000'),
],
```

### 8.4 Selesai!

**Frontend sudah bisa diakses di URL Railway Anda!**
- Contoh: `https://nurani-tms-production.up.railway.app`
- Buka di browser dan test

---

## 9. SETUP FRONTEND (OPSI B: PISAHKAN DENGAN NEXT.JS)

**CATATAN:** Opsi ini hanya jika Anda benar-benar ingin memisahkan frontend.

### 9.1 Buat Next.js Project

1. **Buat Project Baru**
   ```bash
   npx create-next-app@latest nurani-frontend
   cd nurani-frontend
   ```

2. **Pilih Options**
   - TypeScript? **No** (atau Yes jika mau)
   - ESLint? **Yes**
   - Tailwind CSS? **Yes**
   - App Router? **Yes**
   - src/ directory? **No**
   - Import alias? **No**

### 9.2 Install Dependencies

```bash
npm install axios
npm install @tanstack/react-query
```

### 9.3 Buat API Client

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

### 9.4 Setup Environment Variables

Buat file `.env.local`:

```env
NEXT_PUBLIC_API_URL=https://your-backend.railway.app
```

### 9.5 Deploy ke Vercel

1. **Install Vercel CLI**
   ```bash
   npm i -g vercel
   ```

2. **Login**
   ```bash
   vercel login
   ```

3. **Deploy**
   ```bash
   vercel
   ```

4. **Atau Via GitHub**
   - Push project ke GitHub
   - Login ke [vercel.com](https://vercel.com)
   - Import project dari GitHub
   - Set environment variable: `NEXT_PUBLIC_API_URL`
   - Deploy

### 9.6 Setup CORS di Backend

Edit `config/cors.php` di Laravel:

```php
'allowed_origins' => [
    'https://your-frontend.vercel.app',
],
```

Redeploy backend di Railway.

---

## 10. TESTING & VERIFIKASI

### 10.1 Test Backend

1. **Buka URL Railway**
   - Contoh: `https://nurani-tms-production.up.railway.app`
   - Harus muncul halaman Laravel

2. **Test API** (jika ada)
   ```bash
   curl https://your-backend.railway.app/api/health
   ```

3. **Test Database Connection**
   - Login ke aplikasi
   - Coba akses fitur yang butuh database
   - Harus berfungsi normal

### 10.2 Test Frontend

1. **Jika Opsi A (Laravel Full-Stack)**
   - Buka URL Railway
   - Test semua fitur
   - Pastikan semua berfungsi

2. **Jika Opsi B (Next.js di Vercel)**
   - Buka URL Vercel
   - Test koneksi ke backend
   - Pastikan API calls berhasil

### 10.3 Checklist Testing

- [ ] Halaman utama bisa diakses
- [ ] Login berfungsi
- [ ] Database connection berhasil
- [ ] File upload berfungsi (jika ada)
- [ ] Semua fitur utama berfungsi
- [ ] Tidak ada error di console

---

## 11. TROUBLESHOOTING

### 11.1 Error: Database Connection Failed

**Penyebab:** Environment variables database salah

**Solusi:**
1. Cek variables di Railway
2. Pastikan reference variable benar: `${{MySQL.MYSQLHOST}}`
3. Pastikan nama service database sesuai
4. Redeploy

### 11.2 Error: 500 Internal Server Error

**Penyebab:** APP_KEY belum di-set atau salah

**Solusi:**
1. Generate APP_KEY baru:
   ```bash
   php artisan key:generate --show
   ```
2. Update variable `APP_KEY` di Railway
3. Redeploy

### 11.3 Error: Storage Not Found

**Penyebab:** Storage link belum dibuat

**Solusi:**
```bash
railway run php artisan storage:link
```

Atau tambahkan di build command:
```bash
php artisan storage:link
```

### 11.4 Error: Migration Failed

**Penyebab:** Database belum siap atau connection error

**Solusi:**
1. Pastikan database sudah Active
2. Cek environment variables database
3. Run migration lagi:
   ```bash
   railway run php artisan migrate --force
   ```

### 11.5 Error: Build Failed

**Penyebab:** Dependencies error atau build command salah

**Solusi:**
1. Cek logs di Railway
2. Pastikan build command benar
3. Pastikan `composer.json` dan `package.json` ada
4. Coba build manual di local:
   ```bash
   composer install --no-dev
   npm install
   npm run build
   ```

### 11.6 Error: CORS

**Penyebab:** Frontend dan backend berbeda domain

**Solusi:**
1. Edit `config/cors.php`
2. Tambahkan frontend URL ke `allowed_origins`
3. Redeploy backend

### 11.7 Error: Page Not Found (404)

**Penyebab:** Route tidak ter-cache atau .htaccess masalah

**Solusi:**
1. Clear cache:
   ```bash
   railway run php artisan route:clear
   railway run php artisan config:clear
   ```
2. Rebuild cache:
   ```bash
   railway run php artisan route:cache
   railway run php artisan config:cache
   ```

---

## 📝 CHECKLIST FINAL

### Backend (Railway)
- [ ] Project dibuat di Railway
- [ ] Database MySQL ditambahkan
- [ ] Environment variables di-set semua
- [ ] Build command dikonfigurasi
- [ ] Start command dikonfigurasi
- [ ] Migrations dijalankan
- [ ] Storage link dibuat
- [ ] URL backend didapat
- [ ] Testing berhasil

### Frontend
- [ ] **Opsi A:** Laravel full-stack sudah di Railway ✅
- [ ] **Opsi B:** Next.js project dibuat dan deploy ke Vercel
- [ ] Environment variables di-set
- [ ] CORS dikonfigurasi
- [ ] Testing berhasil

---

## 🎉 SELESAI!

Jika semua checklist sudah ✅, berarti deployment berhasil!

**URL Backend:** `https://your-app.railway.app`
**URL Frontend (Opsi B):** `https://your-app.vercel.app`

---

## 📞 BUTUH BANTUAN?

Jika masih ada masalah:
1. Cek logs di Railway dashboard
2. Cek browser console (F12)
3. Cek network tab untuk API calls
4. Baca error message dengan teliti
5. Google error message + "Railway" atau "Laravel"

**Good luck! 🚀**

