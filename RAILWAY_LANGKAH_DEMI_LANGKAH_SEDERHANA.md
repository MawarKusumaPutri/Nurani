# 🎯 Panduan Railway - Langkah Demi Langkah Sederhana

## 📍 Anda Sekarang Di: Railway Dashboard

Saya lihat Anda sudah punya project **"enchanting-blessing"**. Mari kita lanjutkan!

---

## 🎯 LANGKAH 1: Buka Project yang Sudah Dibuat

### Di Dashboard Railway:
1. **Klik** project card **"enchanting-blessing"** (yang ada tulisan "1 service")
2. Anda akan masuk ke **Project Dashboard**

---

## 🎯 LANGKAH 2: Cek Service yang Ada

### Di Project Dashboard:
Anda akan lihat:
- **Service "Nurani"** (atau nama lain)
- Status: **"Build failed"** (merah) atau **"Deploying"** (kuning) atau **"Active"** (hijau)

### Jika Status "Build failed":
1. **Klik** service "Nurani" (yang merah)
2. Klik tab **"Deployments"** (di atas)
3. Klik deployment yang **failed** (yang merah)
4. Klik **"View Logs"**
5. **Copy error message** yang muncul
6. Kirimkan error message ke saya untuk diperbaiki

---

## 🎯 LANGKAH 3: Setup Database (PENTING!)

### Di Project Dashboard:
1. Klik tombol **"+ New"** (di kanan atas, warna ungu)
2. Pilih **"Database"**
3. Pilih **"Add MySQL"**
4. Tunggu database dibuat (1-2 menit)
5. Database akan muncul di project dashboard

---

## 🎯 LANGKAH 4: Setup Environment Variables

### A. Buka Service Settings:
1. **Klik** service "Nurani" (yang ada di project)
2. Klik tab **"Variables"** (di atas)

### B. Tambahkan Variables:
Klik **"+ New Variable"** dan tambahkan satu per satu:

#### 1. App Name:
```
Name: APP_NAME
Value: TMS NURANI
```

#### 2. App Environment:
```
Name: APP_ENV
Value: production
```

#### 3. App Debug:
```
Name: APP_DEBUG
Value: false
```

#### 4. App URL:
```
Name: APP_URL
Value: https://your-app.railway.app
```
*(Ganti dengan URL yang muncul di Railway)*

#### 5. App Key:
```
Name: APP_KEY
Value: (klik "Generate" di Railway, atau generate manual)
```

#### 6. Database Connection (SETELAH database dibuat):
```
Name: DB_CONNECTION
Value: mysql
```

```
Name: DB_HOST
Value: ${MYSQLHOST}
```

```
Name: DB_PORT
Value: ${MYSQLPORT}
```

```
Name: DB_DATABASE
Value: ${MYSQLDATABASE}
```

```
Name: DB_USERNAME
Value: ${MYSQLUSER}
```

```
Name: DB_PASSWORD
Value: ${MYSQLPASSWORD}
```

---

## 🎯 LANGKAH 5: Perbaiki Build Command

### Di Service Settings:
1. Klik tab **"Settings"** (di atas)
2. Scroll ke bagian **"Deploy"**
3. Cari **"Build Command"**
4. Ganti dengan ini:

```bash
composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan storage:link && npm install && npm run build
```

5. Cari **"Start Command"**
6. Pastikan isinya:

```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

7. Klik **"Save"** atau **"Deploy"**

---

## 🎯 LANGKAH 6: Re-deploy

### Setelah semua setup:
1. Klik tombol **"Deploy"** (di service)
2. Atau klik **"Redeploy"** (jika ada)
3. Tunggu build selesai (3-5 menit)
4. Monitor di tab **"Deployments"** → **"View Logs"**

---

## 🎯 LANGKAH 7: Run Migrations

### Setelah deploy berhasil:
1. Klik tab **"Shell"** (di service)
2. Ketik command:

```bash
php artisan migrate --force
```

3. Tekan Enter
4. Tunggu migrations selesai

---

## 🎯 LANGKAH 8: Dapatkan URL

### Setelah semua selesai:
1. Klik tab **"Settings"** (di service)
2. Scroll ke bagian **"Domains"**
3. Copy **Railway URL**: `https://your-app.railway.app`
4. Buka di browser
5. Test aplikasi ✅

---

## 📋 Checklist Sederhana

Ikuti urutan ini:

- [ ] **Langkah 1**: Klik project "enchanting-blessing"
- [ ] **Langkah 2**: Cek service "Nurani" (status apa?)
- [ ] **Langkah 3**: Buat database MySQL
- [ ] **Langkah 4**: Setup environment variables
- [ ] **Langkah 5**: Perbaiki build command
- [ ] **Langkah 6**: Re-deploy
- [ ] **Langkah 7**: Run migrations
- [ ] **Langkah 8**: Test aplikasi

---

## 🆘 Jika Masih Bingung

### Tanyakan:
1. **Status service sekarang apa?** (Build failed / Deploying / Active)
2. **Sudah buat database belum?**
3. **Error message apa yang muncul?** (jika ada)

---

## 💡 Tips

1. **Jangan panik** - Railway auto-detect Laravel, jadi sebagian besar otomatis
2. **Cek logs** - Selalu cek logs untuk tahu error apa
3. **Satu per satu** - Setup satu hal dulu, baru lanjut ke berikutnya
4. **Test lokal** - Pastikan aplikasi jalan di localhost dulu

---

**Mulai dari Langkah 1: Klik project "enchanting-blessing" dulu!** 🚀

