# 🚀 Quick Start: Deploy ke Railway & Vercel

## ⚡ Langkah Cepat (5 Menit)

### 1. Deploy Backend ke Railway (3 menit)

```bash
# 1. Login ke Railway
# Kunjungi railway.app dan login dengan GitHub

# 2. Buat Project Baru
# - Klik "New Project"
# - Pilih "Deploy from GitHub repo"
# - Pilih repository ini

# 3. Tambah Database
# - Klik "+ New" → "Database" → "Add MySQL"
# - Tunggu sampai siap

# 4. Set Environment Variables
# Di Railway Dashboard → Variables, tambahkan:
APP_KEY=base64:YOUR_KEY_HERE
APP_URL=https://your-app.railway.app
DB_HOST=${{MySQL.MYSQLHOST}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

# 5. Deploy
# Railway akan otomatis deploy dari GitHub
```

### 2. Setup Frontend (2 menit)

**Opsi A: Laravel Full-Stack (Tetap di Railway)**
- Laravel sudah full-stack, tidak perlu Vercel
- Semua sudah di Railway

**Opsi B: Pisahkan Frontend (Next.js di Vercel)**
```bash
# 1. Buat Next.js project
npx create-next-app@latest nurani-frontend

# 2. Setup API
# Copy file dari TUTORIAL_DEPLOY_RAILWAY_VERCEL.md

# 3. Deploy ke Vercel
cd nurani-frontend
vercel
```

---

## 📋 Checklist Minimal

### Railway (Backend)
- [ ] Project dibuat
- [ ] Database MySQL ditambahkan
- [ ] Environment variables di-set
- [ ] Deploy berhasil
- [ ] URL backend didapat

### Vercel (Frontend - Opsional)
- [ ] Next.js project dibuat
- [ ] API client dikonfigurasi
- [ ] Environment variables di-set
- [ ] Deploy berhasil

---

## 🔑 Environment Variables Penting

### Railway
```env
APP_KEY=base64:...
APP_URL=https://your-app.railway.app
DB_HOST=${{MySQL.MYSQLHOST}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

### Vercel (jika pakai Next.js)
```env
NEXT_PUBLIC_API_URL=https://your-app.railway.app
```

---

## ⚠️ Catatan Penting

1. **Laravel adalah Full-Stack**
   - Blade templates sudah include frontend
   - Tidak perlu pisahkan kecuali mau pakai React/Vue

2. **Vercel untuk Laravel**
   - Vercel support PHP tapi terbatas
   - Railway lebih cocok untuk Laravel

3. **Rekomendasi**
   - **Opsi 1**: Deploy semua ke Railway (paling mudah)
   - **Opsi 2**: Backend Railway + Frontend Next.js Vercel (jika mau modern stack)

---

## 🆘 Troubleshooting Cepat

**Error: Database connection failed**
→ Check environment variables di Railway

**Error: 500 Internal Server Error**
→ Check logs di Railway dashboard

**Error: CORS**
→ Setup CORS di `config/cors.php`

**Error: Storage not found**
→ Jalankan `php artisan storage:link` di Railway

---

## 📚 Dokumentasi Lengkap

Lihat `TUTORIAL_DEPLOY_RAILWAY_VERCEL.md` untuk tutorial detail.

