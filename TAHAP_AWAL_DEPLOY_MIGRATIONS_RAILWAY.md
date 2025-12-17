# 🚀 TAHAP AWAL: Deploy Migrations ke Railway - Panduan Lengkap

## 📋 RINGKASAN SINGKAT

**Masalah:** Aplikasi error karena kolom `role` belum ada di database Railway.

**Solusi:** Jalankan migrations di Railway agar semua tabel dan kolom terbuat.

**Cara:** Tambahkan migrations ke Start Command (sementara), deploy, lalu kembalikan.

---

## ✅ TAHAP 1: Persiapan (SUDAH SELESAI!)

### 1.1 Edit railway.json
- ✅ **SUDAH DILAKUKAN** - File `railway.json` sudah di-edit
- Start command sudah berubah menjadi:
  ```json
  "startCommand": "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
  ```

### 1.2 Commit & Push
- ✅ **SUDAH DILAKUKAN** - Perubahan sudah di-commit dan push ke GitHub
- Railway akan otomatis detect perubahan dan auto-deploy

---

## ✅ TAHAP 2: Cek Railway Dashboard (LANGKAH INI!)

### 2.1 Buka Railway Dashboard
1. Buka browser → masuk ke [railway.app](https://railway.app)
2. Login ke akun Railway Anda
3. Pilih project **"TMS Nurani"**

### 2.2 Cek Service "web"
1. Di sidebar kiri, klik service **"web"** (yang hijau)
2. Pastikan status **"Online"** (hijau)

### 2.3 Cek Tab "Deployments"
1. Klik tab **"Deployments"** (di baris tab service "web")
2. **Tunggu deployment baru muncul** (akan otomatis trigger dari GitHub)
3. Deployment baru akan muncul dengan status **"Building"** atau **"Deploying"**

### 2.4 Cek Logs
1. **Klik deployment terbaru** (yang baru muncul)
2. Scroll ke bawah untuk lihat **logs**
3. Cari pesan seperti:
   ```
   Running migrations...
   Migrating: 2025_10_17_150326_add_role_to_users_table
   Migrated:  2025_10_17_150326_add_role_to_users_table
   ```
4. **Tunggu sampai migrations selesai** (semua migration berhasil)

---

## ✅ TAHAP 3: Verifikasi Migrations Berhasil

### 3.1 Cek Status Service
1. Di Railway Dashboard, pastikan service **"web"** status **"Online"** (hijau)
2. Jika masih merah, tunggu beberapa saat atau cek logs

### 3.2 Test Aplikasi
1. Klik service **"web"** → tab **"Settings"**
2. Scroll ke **"Domains"** → copy URL aplikasi
3. Buka URL di browser
4. **Coba login** ke aplikasi
5. **Jika login berhasil** = migrations berhasil! ✅

---

## ✅ TAHAP 4: Kembalikan Start Command (PENTING!)

### 4.1 Edit railway.json Lagi
**Setelah migrations berhasil**, kembalikan start command ke normal:

1. Buka file `railway.json` di Cursor
2. Edit start command menjadi:
   ```json
   "startCommand": "php artisan serve --host=0.0.0.0 --port=$PORT"
   ```
   (Hapus `php artisan migrate --force &&` dari awal)

### 4.2 Commit & Push Lagi
Di PowerShell terminal (yang sama seperti tadi):

```powershell
git add railway.json
git commit -m "Remove migrations from start command"
git push
```

### 4.3 Tunggu Deploy Lagi
- Railway akan auto-deploy lagi
- Service akan restart dengan start command normal
- **Selesai!** ✅

---

## 📊 FLOW DIAGRAM

```
1. Edit railway.json (tambah migrations ke start command)
   ↓
2. Commit & Push ke GitHub
   ↓
3. Railway auto-detect perubahan
   ↓
4. Railway auto-deploy
   ↓
5. Migrations jalan saat service start
   ↓
6. Cek logs - pastikan migrations berhasil
   ↓
7. Test aplikasi - coba login
   ↓
8. Edit railway.json lagi (hapus migrations dari start command)
   ↓
9. Commit & Push lagi
   ↓
10. Railway auto-deploy lagi
   ↓
11. SELESAI! ✅
```

---

## 🎯 CHECKLIST

### Tahap 1: Persiapan
- [x] Edit railway.json (SUDAH)
- [x] Commit & Push (SUDAH)

### Tahap 2: Cek Railway (LANGKAH INI!)
- [ ] Buka Railway Dashboard
- [ ] Klik service "web" → tab "Deployments"
- [ ] Cek deployment baru muncul
- [ ] Cek logs - pastikan migrations berhasil

### Tahap 3: Verifikasi
- [ ] Service "web" status "Online" (hijau)
- [ ] Test aplikasi - coba login
- [ ] Login berhasil = migrations berhasil! ✅

### Tahap 4: Kembalikan Start Command
- [ ] Edit railway.json (hapus migrations)
- [ ] Commit & Push lagi
- [ ] Tunggu deploy lagi
- [ ] SELESAI! ✅

---

## 💡 TIPS

1. **Jangan panik** jika deployment butuh waktu (biasanya 2-5 menit)
2. **Cek logs** untuk lihat progress migrations
3. **Tunggu sampai migrations selesai** sebelum test aplikasi
4. **Jangan lupa** kembalikan start command setelah migrations selesai

---

## 🆘 Jika Ada Masalah

### Deployment Gagal
- Cek logs di tab "Deployments"
- Cek error message
- Pastikan environment variables sudah benar

### Migrations Error
- Cek logs untuk lihat error detail
- Pastikan semua migration files sudah benar
- Pastikan database connection sudah benar

### Service Tidak Online
- Tunggu beberapa saat
- Cek logs untuk error
- Pastikan start command benar

---

**Langkah selanjutnya: Buka Railway Dashboard dan cek tab "Deployments"! 🚀**

