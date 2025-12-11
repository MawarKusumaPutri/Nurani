# ✅ Checklist Deploy Step-by-Step

## 📋 Persiapan (5 menit)

- [ ] **Install Git** - [Download](https://git-scm.com/downloads)
- [ ] **Install Composer** - [Download](https://getcomposer.org/download/)
- [ ] **Install Node.js** - [Download](https://nodejs.org/)
- [ ] **Buat Akun GitHub** - [Sign up](https://github.com/signup)
- [ ] **Buat Akun Railway** - [Sign up](https://railway.app)
- [ ] **Buat Akun Vercel** (opsional) - [Sign up](https://vercel.com/signup)

**Verifikasi:**
```bash
git --version
composer --version
node --version
npm --version
```

---

## 🔧 Setup GitHub (10 menit)

### Step 1: Buat Repository
- [ ] Login ke GitHub
- [ ] Klik "+" → "New repository"
- [ ] Nama: `nurani-tms`
- [ ] Visibility: Public atau Private
- [ ] **JANGAN** centang README, .gitignore, license
- [ ] Klik "Create repository"
- [ ] Copy URL repository

### Step 2: Push Project ke GitHub
```bash
cd D:\Praktikum DWBI\xampp\htdocs\nurani
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/username/nurani-tms.git
git branch -M main
git push -u origin main
```

- [ ] Git init berhasil
- [ ] Git add berhasil
- [ ] Git commit berhasil
- [ ] Git remote ditambahkan
- [ ] Git push berhasil
- [ ] File muncul di GitHub

---

## 🚂 Deploy ke Railway (15 menit)

### Step 1: Login Railway
- [ ] Buka [railway.app](https://railway.app)
- [ ] Klik "Login with GitHub"
- [ ] Authorize Railway
- [ ] Verifikasi email (jika diminta)

### Step 2: Buat Project
- [ ] Klik "+ New Project"
- [ ] Pilih "Deploy from GitHub repo"
- [ ] Pilih repository `nurani-tms`
- [ ] Tunggu Railway detect Laravel
- [ ] Tunggu build selesai (2-5 menit)

### Step 3: Dapatkan URL
- [ ] Buka tab "Settings"
- [ ] Scroll ke "Domains"
- [ ] Klik "Generate Domain"
- [ ] Copy URL (contoh: `nurani-tms-production.up.railway.app`)

**URL Backend:** `https://____________________.railway.app`

---

## 🗄️ Setup Database (5 menit)

### Step 1: Tambah Database
- [ ] Klik "+ New"
- [ ] Pilih "Database" → "Add MySQL"
- [ ] Tunggu sampai status "Active" (1-2 menit)

### Step 2: Cek Database Variables
- [ ] Klik service database
- [ ] Buka tab "Variables"
- [ ] Catat nama service (contoh: "MySQL", "Postgres")

**Nama Service Database:** `____________________`

---

## ⚙️ Setup Environment Variables (10 menit)

### Buka Variables di Service Laravel
- [ ] Klik service Laravel (bukan database)
- [ ] Buka tab "Variables"

### Tambah Variables (Copy-paste satu per satu):

#### 1. APP_NAME
```
Name: APP_NAME
Value: Nurani TMS
```
- [ ] Ditambahkan

#### 2. APP_ENV
```
Name: APP_ENV
Value: production
```
- [ ] Ditambahkan

#### 3. APP_KEY
**Generate dulu di local:**
```bash
php artisan key:generate --show
```
**Copy output, lalu:**
```
Name: APP_KEY
Value: base64:xxxxxxxxxxxxx
```
- [ ] APP_KEY di-generate
- [ ] Ditambahkan

#### 4. APP_DEBUG
```
Name: APP_DEBUG
Value: false
```
- [ ] Ditambahkan

#### 5. APP_URL
```
Name: APP_URL
Value: https://nurani-tms-production.up.railway.app
(Ganti dengan URL Railway Anda)
```
- [ ] URL disesuaikan
- [ ] Ditambahkan

#### 6. DB_CONNECTION
```
Name: DB_CONNECTION
Value: mysql
```
- [ ] Ditambahkan

#### 7. DB_HOST
```
Name: DB_HOST
Value: ${{MySQL.MYSQLHOST}}
(Ganti "MySQL" dengan nama service database Anda)
```
- [ ] Nama service disesuaikan
- [ ] Ditambahkan

#### 8. DB_PORT
```
Name: DB_PORT
Value: ${{MySQL.MYSQLPORT}}
```
- [ ] Ditambahkan

#### 9. DB_DATABASE
```
Name: DB_DATABASE
Value: ${{MySQL.MYSQLDATABASE}}
```
- [ ] Ditambahkan

#### 10. DB_USERNAME
```
Name: DB_USERNAME
Value: ${{MySQL.MYSQLUSER}}
```
- [ ] Ditambahkan

#### 11. DB_PASSWORD
```
Name: DB_PASSWORD
Value: ${{MySQL.MYSQLPASSWORD}}
```
- [ ] Ditambahkan

#### 12. FILESYSTEM_DISK
```
Name: FILESYSTEM_DISK
Value: public
```
- [ ] Ditambahkan

#### 13. SESSION_DRIVER
```
Name: SESSION_DRIVER
Value: database
```
- [ ] Ditambahkan

#### 14. SESSION_LIFETIME
```
Name: SESSION_LIFETIME
Value: 120
```
- [ ] Ditambahkan

**Total Variables:** 14/14 ✅

---

## 🔨 Setup Build & Deploy (5 menit)

### Buka Settings
- [ ] Klik service Laravel
- [ ] Buka tab "Settings"
- [ ] Scroll ke "Build & Deploy"

### Build Command
Paste ini:
```bash
composer install --optimize-autoloader --no-dev && npm install && npm run build && php artisan key:generate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache
```
- [ ] Build command di-paste
- [ ] Disimpan

### Start Command
Paste ini:
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```
- [ ] Start command di-paste
- [ ] Disimpan

### Healthcheck
Isi dengan:
```
/
```
- [ ] Healthcheck di-set
- [ ] Disimpan

**Railway akan otomatis redeploy**

---

## 🗃️ Run Migrations (5 menit)

### Via Railway Dashboard
- [ ] Buka tab "Deployments"
- [ ] Klik deployment terbaru
- [ ] Buka terminal/logs
- [ ] Jalankan: `php artisan migrate --force`
- [ ] Cek output: "Migration table created successfully"

### Atau Via Railway CLI
```bash
npm install -g @railway/cli
railway login
railway link
railway run php artisan migrate --force
```
- [ ] Railway CLI terinstall
- [ ] Login berhasil
- [ ] Project ter-link
- [ ] Migration berhasil

---

## 🧪 Testing (10 menit)

### Test Backend
- [ ] Buka URL Railway di browser
- [ ] Halaman Laravel muncul
- [ ] Tidak ada error 500
- [ ] Tidak ada error database

### Test Database
- [ ] Coba login
- [ ] Login berhasil
- [ ] Data muncul (jika ada)

### Test Fitur
- [ ] Navigasi berfungsi
- [ ] Form bisa di-submit
- [ ] File upload berfungsi (jika ada)
- [ ] Tidak ada error di console (F12)

---

## ✅ FINAL CHECKLIST

### Backend (Railway)
- [ ] Project dibuat
- [ ] Database ditambahkan
- [ ] 14 environment variables di-set
- [ ] Build command dikonfigurasi
- [ ] Start command dikonfigurasi
- [ ] Migrations dijalankan
- [ ] Storage link dibuat
- [ ] URL didapat
- [ ] Testing berhasil

### Frontend
- [ ] **Opsi A:** Laravel full-stack sudah di Railway ✅
- [ ] **Opsi B:** Next.js dibuat dan deploy ke Vercel (opsional)

---

## 🎉 SELESAI!

**URL Backend:** `https://____________________.railway.app`

**Status:** 
- [ ] ✅ Berhasil
- [ ] ❌ Ada masalah (lihat Troubleshooting di tutorial lengkap)

---

## 📚 File Tutorial

- **Tutorial Lengkap:** `TUTORIAL_LENGKAP_DEPLOY_DARI_AWAL.md`
- **Quick Start:** `QUICK_START_DEPLOY.md`
- **Setup CORS:** `SETUP_CORS.md`

---

**Good luck! 🚀**

