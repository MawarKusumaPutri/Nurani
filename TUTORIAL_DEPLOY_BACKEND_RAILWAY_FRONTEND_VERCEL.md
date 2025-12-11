# 🚀 Tutorial Deploy: Backend Railway + Frontend Vercel

## 📋 DAFTAR ISI

1. [Pendahuluan](#1-pendahuluan)
2. [Arsitektur Deployment](#2-arsitektur-deployment)
3. [Persiapan Awal](#3-persiapan-awal)
4. [Deploy Backend Laravel ke Railway](#4-deploy-backend-laravel-ke-railway)
5. [Setup Database di Railway](#5-setup-database-di-railway)
6. [Konfigurasi Backend sebagai API](#6-konfigurasi-backend-sebagai-api)
7. [Deploy Frontend Next.js ke Vercel](#7-deploy-frontend-nextjs-ke-vercel)
8. [Setup CORS](#8-setup-cors)
9. [Testing](#9-testing)
10. [Troubleshooting](#10-troubleshooting)

---

## 1. PENDAHULUAN

### 1.1 Konsep Deployment

**Backend (Railway):**
- Laravel API
- Database MySQL
- File storage
- Authentication

**Frontend (Vercel):**
- Next.js application
- Static assets
- Client-side rendering
- API calls ke backend

### 1.2 Alur Request

```
User → Vercel (Frontend) → Railway (Backend API) → Database
```

---

## 2. ARSITEKTUR DEPLOYMENT

```
┌─────────────────┐
│   User Browser  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐      HTTP Request      ┌─────────────────┐
│  Vercel (Frontend) │ ────────────────────► │ Railway (Backend) │
│   Next.js App    │                        │  Laravel API     │
│   https://...    │ ◄──────────────────── │  https://...    │
│   vercel.app     │      JSON Response     │  railway.app    │
└─────────────────┘                        └────────┬────────┘
                                                   │
                                                   ▼
                                            ┌──────────────┐
                                            │   MySQL DB    │
                                            │   (Railway)   │
                                            └──────────────┘
```

---

## 3. PERSIAPAN AWAL

### 3.1 Software yang Diperlukan

- ✅ **Git** - [Download Git](https://git-scm.com/downloads)
- ✅ **Composer** - [Download Composer](https://getcomposer.org/download/)
- ✅ **Node.js & NPM** - [Download Node.js](https://nodejs.org/)
- ✅ **Text Editor** (VS Code)

### 3.2 Akun yang Diperlukan

- ✅ **GitHub** - [Sign up GitHub](https://github.com/signup)
- ✅ **Railway** - [Sign up Railway](https://railway.app)
- ✅ **Vercel** - [Sign up Vercel](https://vercel.com/signup)

### 3.3 Verifikasi Install

```bash
git --version
composer --version
node --version
npm --version
```

---

## 4. DEPLOY BACKEND LARAVEL KE RAILWAY

### 4.1 Persiapan Repository GitHub

1. **Buat Repository Baru di GitHub**
   - Login ke GitHub
   - Klik "New repository"
   - Nama: `nurani-backend` (atau sesuai keinginan)
   - Visibility: **Private** (disarankan)
   - Jangan centang "Initialize with README"

2. **Push Project ke GitHub**

   ```bash
   # Di folder project Laravel Anda
   git init
   git add .
   git commit -m "Initial commit: Laravel backend"
   git branch -M main
   git remote add origin https://github.com/username/nurani-backend.git
   git push -u origin main
   ```

### 4.2 Deploy ke Railway

1. **Login Railway dengan GitHub**
   - Buka [railway.app](https://railway.app)
   - Klik "Login with GitHub"
   - Authorize Railway

2. **Buat Project Baru**
   - Klik "New Project"
   - Pilih "Deploy from GitHub repo"
   - Pilih repository `nurani-backend`
   - Railway akan otomatis detect Laravel

3. **Tunggu Build Selesai**
   - Railway akan otomatis build
   - Tunggu sampai status "Deployed"
   - Catat URL yang diberikan (contoh: `https://nurani-backend-production.up.railway.app`)

### 4.3 Generate Domain

- Railway akan otomatis generate domain
- Atau bisa setup custom domain (opsional)
- Catat URL ini untuk nanti (Backend URL)

---

## 5. SETUP DATABASE DI RAILWAY

### 5.1 Tambah MySQL Database

1. **Di Railway Dashboard**
   - Klik "New" → "Database" → "Add MySQL"

2. **Tunggu Database Ready**
   - Status harus "Active"
   - Catat nama service (contoh: `MySQL`)

### 5.2 Link Database ke Backend

1. **Klik Service Backend**
2. **Klik "Variables" tab**
3. **Tambah Variable:**
   - Klik "New Variable"
   - Pilih "Reference" dari dropdown
   - Pilih service `MySQL`
   - Pilih variable yang diperlukan

---

## 6. KONFIGURASI BACKEND SEBAGAI API

### 6.1 Setup Environment Variables di Railway

Di Railway Dashboard → Backend Service → Variables, tambahkan:

#### 6.1.1 Basic Variables

```env
APP_NAME="Nurani TMS"
APP_ENV=production
APP_KEY=base64:... (generate dulu di local dengan: php artisan key:generate)
APP_DEBUG=false
APP_URL=https://your-backend.railway.app
```

#### 6.1.2 Database Variables (Gunakan Reference)

```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

#### 6.1.3 Storage & Session

```env
FILESYSTEM_DISK=public
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

#### 6.1.4 CORS (Untuk Frontend Vercel)

```env
FRONTEND_URL=https://your-frontend.vercel.app
```

**Total: 14 variables**

### 6.2 Generate APP_KEY

**Di Local:**
```bash
php artisan key:generate
```

Copy output `APP_KEY` dari `.env` ke Railway Variables.

### 6.3 Setup Build & Start Commands

Di Railway Dashboard → Backend Service → Settings:

**Build Command:**
```bash
composer install --optimize-autoloader --no-dev && npm install && npm run build && php artisan key:generate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**Start Command:**
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

**Healthcheck Path:**
```
/
```

### 6.4 Setup CORS di Laravel

Edit `config/cors.php`:

```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        env('FRONTEND_URL', 'http://localhost:3000'),
        'https://your-frontend.vercel.app',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
```

**Commit dan push perubahan:**
```bash
git add config/cors.php
git commit -m "Setup CORS for Vercel frontend"
git push
```

Railway akan otomatis redeploy.

### 6.5 Run Migrations

**Via Railway CLI:**
```bash
npm install -g @railway/cli
railway login
railway link
railway run php artisan migrate --force
```

**Atau via Railway Dashboard:**
- Klik service backend
- Klik "Deployments"
- Klik deployment terbaru
- Di terminal, jalankan: `php artisan migrate --force`

### 6.6 Setup Storage Link

```bash
railway run php artisan storage:link
```

---

## 7. DEPLOY FRONTEND NEXT.JS KE VERCEL

### 7.1 Buat Next.js Project

1. **Buat Folder Baru untuk Frontend**

   ```bash
   # Di luar folder Laravel
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

### 7.2 Install Dependencies

```bash
npm install axios
npm install @tanstack/react-query
```

### 7.3 Buat API Client

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
    // Ambil token dari localStorage atau cookie
    const token = typeof window !== 'undefined' ? localStorage.getItem('token') : null;
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
      // Unauthorized - redirect ke login
      if (typeof window !== 'undefined') {
        localStorage.removeItem('token');
        window.location.href = '/login';
      }
    }
    return Promise.reject(error);
  }
);

export default api;
```

### 7.4 Setup Environment Variables

Buat file `.env.local`:

```env
NEXT_PUBLIC_API_URL=https://your-backend.railway.app
```

**Jangan commit file ini!** Tambahkan ke `.gitignore`:

```gitignore
.env.local
.env*.local
```

### 7.5 Buat Halaman Contoh

Buat file `app/page.js`:

```javascript
'use client';

import { useEffect, useState } from 'react';
import api from '@/lib/api';

export default function Home() {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Contoh API call
    api.get('/api/health')
      .then((response) => {
        setData(response.data);
        setLoading(false);
      })
      .catch((error) => {
        console.error('Error:', error);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4">Nurani TMS Frontend</h1>
      <p>Backend URL: {process.env.NEXT_PUBLIC_API_URL}</p>
      {data && <pre>{JSON.stringify(data, null, 2)}</pre>}
    </div>
  );
}
```

### 7.6 Push ke GitHub

1. **Buat Repository Baru di GitHub**
   - Nama: `nurani-frontend`
   - Visibility: **Private**

2. **Push Project**

   ```bash
   git init
   git add .
   git commit -m "Initial commit: Next.js frontend"
   git branch -M main
   git remote add origin https://github.com/username/nurani-frontend.git
   git push -u origin main
   ```

### 7.7 Deploy ke Vercel

#### Opsi A: Via Vercel Dashboard (Recommended)

1. **Login ke Vercel**
   - Buka [vercel.com](https://vercel.com)
   - Login dengan GitHub

2. **Import Project**
   - Klik "Add New" → "Project"
   - Pilih repository `nurani-frontend`
   - Klik "Import"

3. **Configure Project**
   - Framework Preset: **Next.js** (otomatis terdeteksi)
   - Root Directory: `./` (default)
   - Build Command: `npm run build` (default)
   - Output Directory: `.next` (default)

4. **Environment Variables**
   - Klik "Environment Variables"
   - Tambahkan:
     ```
     NEXT_PUBLIC_API_URL = https://your-backend.railway.app
     ```
   - Klik "Save"

5. **Deploy**
   - Klik "Deploy"
   - Tunggu sampai selesai
   - Catat URL yang diberikan (contoh: `https://nurani-frontend.vercel.app`)

#### Opsi B: Via Vercel CLI

```bash
npm i -g vercel
vercel login
vercel
```

Ikuti instruksi di terminal.

### 7.8 Update CORS di Backend

Setelah dapat URL Vercel, update `config/cors.php` di Laravel:

```php
'allowed_origins' => [
    'https://your-frontend.vercel.app', // Ganti dengan URL Vercel Anda
    env('FRONTEND_URL', 'http://localhost:3000'),
],
```

Commit dan push:
```bash
git add config/cors.php
git commit -m "Update CORS with Vercel URL"
git push
```

Railway akan otomatis redeploy.

---

## 8. SETUP CORS

### 8.1 Pastikan CORS Sudah Benar

**Di Laravel (`config/cors.php`):**
```php
'allowed_origins' => [
    'https://your-frontend.vercel.app',
],
'supports_credentials' => true,
```

### 8.2 Test CORS

Buka browser console di frontend Vercel, jalankan:

```javascript
fetch('https://your-backend.railway.app/api/health', {
  credentials: 'include'
})
.then(r => r.json())
.then(console.log)
.catch(console.error);
```

Jika tidak ada error CORS, berarti sudah benar.

---

## 9. TESTING

### 9.1 Test Backend

1. **Buka URL Railway**
   - Contoh: `https://nurani-backend-production.up.railway.app`
   - Harus bisa diakses

2. **Test API Endpoint**
   ```bash
   curl https://your-backend.railway.app/api/health
   ```

3. **Test Database**
   - Login ke aplikasi (jika ada endpoint login)
   - Pastikan database terhubung

### 9.2 Test Frontend

1. **Buka URL Vercel**
   - Contoh: `https://nurani-frontend.vercel.app`
   - Harus muncul halaman Next.js

2. **Test API Connection**
   - Buka browser console (F12)
   - Cek apakah API calls berhasil
   - Tidak ada error CORS

3. **Test Fitur**
   - Login (jika ada)
   - Fetch data dari backend
   - Pastikan semua fitur berfungsi

### 9.3 Checklist Testing

- [ ] Backend bisa diakses
- [ ] Database terhubung
- [ ] Migrations berhasil
- [ ] Storage link dibuat
- [ ] Frontend bisa diakses
- [ ] API calls berhasil
- [ ] Tidak ada error CORS
- [ ] Authentication berfungsi (jika ada)
- [ ] File upload berfungsi (jika ada)

---

## 10. TROUBLESHOOTING

### 10.1 Error: CORS Policy

**Gejala:**
```
Access to fetch at '...' from origin '...' has been blocked by CORS policy
```

**Solusi:**
1. Pastikan `config/cors.php` sudah benar
2. Pastikan `FRONTEND_URL` di environment variables sudah benar
3. Clear cache: `php artisan config:clear`
4. Redeploy backend

### 10.2 Error: 500 Internal Server Error

**Gejala:** Backend return 500 error

**Solusi:**
1. Cek logs di Railway dashboard
2. Pastikan semua environment variables sudah benar
3. Pastikan `APP_KEY` sudah di-set
4. Pastikan database connection sudah benar

### 10.3 Error: Database Connection Failed

**Gejala:** Error saat koneksi ke database

**Solusi:**
1. Pastikan database service sudah "Active"
2. Pastikan semua database variables menggunakan Reference
3. Cek format reference: `${{MySQL.MYSQLHOST}}`
4. Redeploy backend

### 10.4 Error: Storage Link Not Found

**Gejala:** File upload tidak berfungsi

**Solusi:**
```bash
railway run php artisan storage:link
```

### 10.5 Error: Frontend Tidak Bisa Connect ke Backend

**Gejala:** Frontend tidak bisa fetch data

**Solusi:**
1. Pastikan `NEXT_PUBLIC_API_URL` di Vercel sudah benar
2. Pastikan backend URL bisa diakses
3. Cek CORS configuration
4. Cek browser console untuk error detail

### 10.6 Error: Build Failed di Railway

**Gejala:** Build gagal di Railway

**Solusi:**
1. Cek logs di Railway dashboard
2. Pastikan `composer.json` dan `package.json` sudah benar
3. Pastikan semua dependencies bisa diinstall
4. Cek PHP version compatibility

### 10.7 Error: Build Failed di Vercel

**Gejala:** Build gagal di Vercel

**Solusi:**
1. Cek logs di Vercel dashboard
2. Pastikan `package.json` sudah benar
3. Pastikan semua dependencies bisa diinstall
4. Cek Next.js version compatibility

---

## 📚 Referensi

- **Railway Docs:** [docs.railway.app](https://docs.railway.app)
- **Vercel Docs:** [vercel.com/docs](https://vercel.com/docs)
- **Laravel CORS:** [laravel.com/docs/cors](https://laravel.com/docs/cors)
- **Next.js Docs:** [nextjs.org/docs](https://nextjs.org/docs)

---

## ✅ Checklist Final

### Backend (Railway)
- [ ] Repository GitHub dibuat dan di-push
- [ ] Project Railway dibuat dan terhubung ke GitHub
- [ ] Database MySQL ditambahkan
- [ ] 14 environment variables di-set
- [ ] Build & Start commands dikonfigurasi
- [ ] CORS dikonfigurasi
- [ ] Migrations dijalankan
- [ ] Storage link dibuat
- [ ] Backend bisa diakses

### Frontend (Vercel)
- [ ] Next.js project dibuat
- [ ] API client dibuat
- [ ] Environment variables di-set
- [ ] Repository GitHub dibuat dan di-push
- [ ] Project Vercel dibuat dan terhubung ke GitHub
- [ ] Frontend di-deploy
- [ ] Frontend bisa diakses
- [ ] API connection berhasil

### Testing
- [ ] Backend API bisa diakses
- [ ] Frontend bisa diakses
- [ ] Tidak ada error CORS
- [ ] Semua fitur berfungsi

---

**Selamat! Deployment selesai! 🎉**

**Backend URL:** `https://your-backend.railway.app`
**Frontend URL:** `https://your-frontend.vercel.app`


