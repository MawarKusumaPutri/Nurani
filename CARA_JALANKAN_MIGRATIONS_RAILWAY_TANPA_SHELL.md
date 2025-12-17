# ✅ Cara Jalankan Migrations di Railway TANPA Shell

## 🎯 BAGUS: Anda TIDAK Perlu Shell!

**Konfigurasi Railway sudah otomatis menjalankan migrations dan seeder saat deploy!**

**File `railway.json` sudah dikonfigurasi untuk:**
- Menjalankan `database/migrate-and-seed-safe.php` otomatis saat deploy
- Script ini akan menjalankan migrations DAN seeder secara otomatis

---

## ✅ CARA 1: Trigger Redeploy (Paling Mudah!)

### Langkah 1: Klik Menu Tiga Titik pada Deployment

1. **Lihat deployment "Fix Railway: Add migrations and seeder t..."** (status: ACTIVE)
2. **Klik ikon tiga titik "..."** di sebelah kanan deployment
3. **Pilih "Redeploy"** dari dropdown menu
4. **Tunggu deploy selesai** (2-5 menit)

### Langkah 2: Cek Deploy Logs

1. **Setelah redeploy, klik "View logs"** pada deployment
2. **Atau klik tab "Deploy Logs"**
3. **Cek apakah ada:**
   - `[SUKSES] Migrations selesai!`
   - `[SUKSES] Seeder selesai! Data guru sudah dibuat!`
   - `Jumlah guru di database: 13`

### Langkah 3: Test Login

1. **Buka aplikasi Railway** → URL Railway Anda
2. **Klik "LOGIN"** → Pilih role "GURU"
3. **Masukkan:**
   - Email: `mundarinurhadi@gmail.com`
   - Password: `Nurhadi2024!`
4. **Klik "Login"**
5. **Jika berhasil masuk** = Berhasil! ✅

---

## ✅ CARA 2: Push Perubahan Baru ke GitHub

**Jika ingin trigger deploy ulang via GitHub:**

1. **Buka PowerShell:**
   ```powershell
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```

2. **Buat perubahan kecil (misalnya tambah comment di file):**
   ```powershell
   # Edit file apapun, atau buat file dummy
   echo "# Trigger deploy" >> .deploy-trigger
   ```

3. **Commit dan push:**
   ```powershell
   git add .
   git commit -m "Trigger Railway deploy"
   git push origin main
   ```

4. **Railway akan otomatis deploy** dan menjalankan migrations + seeder

---

## ✅ CARA 3: Gunakan Railway CLI (Jika Perlu Manual)

**Jika tetap ingin manual tanpa Shell:**

### Langkah 1: Install Railway CLI

```powershell
npm i -g @railway/cli
```

### Langkah 2: Login

```powershell
railway login
```

### Langkah 3: Link ke Project

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
railway link
```

**Pilih project "TMS Nurani" dan service "web"**

### Langkah 4: Jalankan Command

```powershell
railway run php artisan migrate --force
railway run php artisan db:seed --class=UserSeeder
```

---

## 📋 CEK HASIL

### Cek Deploy Logs

1. **Buka Railway Dashboard**
2. **Klik service "web"**
3. **Klik tab "Deployments"**
4. **Klik deployment terbaru**
5. **Klik tab "Deploy Logs"**
6. **Cek apakah ada:**
   - `[SUKSES] Migrations selesai!`
   - `[SUKSES] Seeder selesai! Data guru sudah dibuat!`
   - `Jumlah guru di database: 13`

### Test Login

1. **Buka aplikasi Railway** → URL Railway Anda
2. **Klik "LOGIN"** → Pilih role "GURU"
3. **Masukkan:**
   - Email: `mundarinurhadi@gmail.com`
   - Password: `Nurhadi2024!`
4. **Klik "Login"**
5. **Jika berhasil masuk** = Berhasil! ✅

---

## 🎯 REKOMENDASI

**Gunakan Cara 1 (Redeploy) - Paling mudah dan cepat!**

**Tinggal klik "Redeploy" dari menu tiga titik, tunggu deploy selesai, lalu test login!**

---

## ⚠️ CATATAN PENTING

**Migrations dan seeder sudah otomatis berjalan saat deploy!**

**Anda TIDAK perlu Shell - cukup trigger redeploy atau tunggu deploy berikutnya!**

---

**Klik "Redeploy" dari menu tiga titik untuk menjalankan migrations + seeder! 🚀**
