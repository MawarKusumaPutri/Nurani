# 🚀 Quick Start: Deploy Laravel ke Railway

## ⚡ Langkah Cepat (5 Menit)

### 1️⃣ Persiapan (1 menit)
```bash
# Pastikan project di GitHub
git add .
git commit -m "Prepare for Railway"
git push
```

### 2️⃣ Buat Akun Railway (1 menit)
1. Buka: **https://railway.app**
2. Klik **"Start a New Project"**
3. Login dengan **GitHub**

### 3️⃣ Deploy Project (2 menit)
1. Klik **"+ New Project"**
2. Pilih **"Deploy from GitHub repo"**
3. Pilih repository **`nurani`**
4. Klik **"Deploy Now"**
5. Railway otomatis detect Laravel ✅

### 4️⃣ Setup Database (1 menit)
1. Klik **"+ New"** → **"Database"** → **"Add MySQL"**
2. Railway otomatis setup connection ✅

### 5️⃣ Setup Environment Variables
Railway otomatis set:
- ✅ Database connection
- ✅ APP_KEY (auto-generate)

**Tambahkan manual:**
```
APP_NAME=TMS NURANI
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app
```

### 6️⃣ Deploy & Test
1. Tunggu build selesai (3-5 menit)
2. Dapatkan URL: `https://your-app.railway.app`
3. Test aplikasi ✅

---

## 📝 Checklist Minimal

- [ ] Project di GitHub
- [ ] Akun Railway dibuat
- [ ] Project deployed
- [ ] Database dibuat
- [ ] Environment variables di-set
- [ ] Deploy berhasil
- [ ] Aplikasi bisa diakses

---

## 🎯 Detail Lengkap

Lihat file: **`RAILWAY_DEPLOY_STEP_BY_STEP.md`** untuk panduan lengkap!

---

**Selesai! Aplikasi sudah online di Railway! 🎉**

