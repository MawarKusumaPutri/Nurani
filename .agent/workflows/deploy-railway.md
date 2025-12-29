---
description: Deploy dan Clear Cache di Railway
---

# Deploy dan Clear Cache di Railway

## 🚀 Setup Auto-Deploy (Sekali Setup)

### Cara 1: Melalui Railway Dashboard (RECOMMENDED)
1. Buka Railway Dashboard: https://railway.app
2. Pilih project **TMS Nurani**
3. Klik service **"web"**
4. Klik tab **"Settings"**
5. Di bagian **"Source"** atau **"Deploy"**:
   - Pastikan repository GitHub sudah terkoneksi
   - Pilih branch: `main` atau `master`
   - **Aktifkan "Auto Deploy"** atau **"Deploy on Push"**
6. Klik **"Save"**

**Setelah setup ini, setiap kali Anda push ke GitHub, Railway akan otomatis:**
- Build aplikasi
- Clear cache
- Deploy versi terbaru

### Cara 2: Deploy Manual Cepat
Gunakan script PowerShell yang sudah disediakan:
```powershell
.\deploy.ps1
```

Script ini akan:
1. Add semua perubahan ke git
2. Commit dengan pesan yang Anda masukkan
3. Push ke GitHub
4. Railway akan auto-deploy (jika sudah setup)

---

## 🔧 Clear Cache Manual (Jika Diperlukan)

Jika perubahan tidak muncul setelah deploy, jalankan command berikut di Railway console:

### 1. Clear Route Cache
```bash
php artisan route:clear
php artisan route:cache
```

### 2. Clear Config Cache
```bash
php artisan config:clear
php artisan config:cache
```

### 3. Clear View Cache
```bash
php artisan view:clear
```

### 4. Create Storage Link
Pastikan storage link sudah dibuat:
```bash
php artisan storage:link
```

### 5. Optimize Application
```bash
php artisan optimize:clear
php artisan optimize
```

### 6. Verify Routes
Cek apakah route sudah terdaftar:
```bash
php artisan route:list --name=rpp.cetak
```

---

## 📝 Workflow Deploy Harian

### Setiap Kali Ada Perubahan Kode:

**Opsi A: Menggunakan Script (Paling Mudah)**
```powershell
.\deploy.ps1
```

**Opsi B: Manual Git Commands**
```bash
git add .
git commit -m "Deskripsi perubahan"
git push
```

**Railway akan otomatis:**
1. ✅ Detect perubahan
2. ✅ Build aplikasi
3. ✅ Run migrations (jika ada)
4. ✅ Clear cache
5. ✅ Deploy ke production

---

## ⚠️ Catatan Penting

- **Auto-deploy hanya bekerja jika Railway terkoneksi dengan GitHub**
- Setiap kali ada perubahan route, **WAJIB** clear route cache
- Setiap kali ada perubahan config, **WAJIB** clear config cache
- Pastikan file `.env` di Railway sudah benar
- Pastikan `APP_ENV=production` di Railway
- Cek deployment status di Railway Dashboard > Deployments tab

---

## 🔍 Troubleshooting

**Jika perubahan tidak muncul:**
1. Cek Railway Dashboard > Deployments - pastikan build sukses
2. Clear cache manual via Railway console
3. Restart service di Railway
4. Cek logs di Railway untuk error

**Jika auto-deploy tidak jalan:**
1. Pastikan GitHub repository terkoneksi
2. Pastikan "Auto Deploy" aktif di Settings
3. Cek apakah ada webhook di GitHub repository settings

