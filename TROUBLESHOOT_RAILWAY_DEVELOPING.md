# Troubleshooting Railway "Developing" Status

## 🔍 Kenapa Status Masih "Developing"?

Railway menampilkan status "developing" ketika:
1. ✅ Build sedang berjalan
2. ✅ Deployment sedang dalam proses
3. ❌ Ada error saat startup
4. ❌ Environment variables belum lengkap

---

## ✅ Cara Mengecek dan Memperbaiki

### 1. **Cek Logs di Railway**

Di Railway dashboard:
1. Klik service **"web"**
2. Klik tab **"Deployments"**
3. Klik deployment yang paling baru
4. Lihat **"Build Logs"** dan **"Deploy Logs"**

**Yang harus dicari:**
- ❌ Error message (merah)
- ⚠️ Warning (kuning)
- ✅ "Server started" atau "Laravel development server started"

---

### 2. **Pastikan Environment Variables Sudah Lengkap**

Di Railway dashboard → Service "web" → **Settings** → **Variables**

**Wajib ada:**
```
APP_NAME=TMS Nurani
APP_ENV=production
APP_KEY=base64:... (generate dengan php artisan key:generate)
APP_DEBUG=false
APP_URL=https://web-production-50f9.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

**Cara set:**
1. Klik **"+ New Variable"**
2. Masukkan nama dan value
3. Klik **"Add"**
4. Klik **"Deploy"** untuk restart

---

### 3. **Trigger Redeploy**

Jika build sudah selesai tapi masih "developing":

**Cara 1: Via Railway Dashboard**
1. Klik service **"web"**
2. Klik **"Settings"**
3. Scroll ke bawah
4. Klik **"Redeploy"** atau **"Restart"**

**Cara 2: Via Git Push**
```bash
git add .
git commit -m "Trigger redeploy"
git push origin main
```

---

### 4. **Cek Database Connection**

Pastikan MySQL service sudah connect ke web service:

1. Di Railway dashboard, klik service **"MySQL"**
2. Klik tab **"Connect"**
3. Copy semua variable (MYSQL_HOST, MYSQL_PORT, dll)
4. Paste ke service **"web"** → **Variables**

**Format yang benar:**
```
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
```

---

### 5. **Fix Common Errors**

#### Error: "APP_KEY not set"
```bash
# Di local terminal
php artisan key:generate --show

# Copy output (base64:...)
# Paste ke Railway Variables → APP_KEY
```

#### Error: "Storage link failed"
Sudah di-handle di `railway.json` build command:
```json
"buildCommand": "composer install --no-dev --optimize-autoloader && php artisan storage:link && npm install && npm run build"
```

#### Error: "Migration failed"
Script `migrate-and-seed-safe.php` sudah handle ini otomatis.

---

### 6. **Verifikasi Deployment Berhasil**

Setelah redeploy, cek:

1. **Status berubah dari "developing" ke "active"** ✅
2. **URL bisa diakses**: https://web-production-50f9.up.railway.app
3. **Halaman login muncul** (bukan error 500)
4. **Bisa login** dengan akun TU/Guru

---

## 🚀 Quick Fix (Langkah Cepat)

Jika masih stuck di "developing":

### **Opsi 1: Restart Service**
1. Railway Dashboard → Service "web"
2. Settings → Scroll bawah
3. Klik **"Restart"**
4. Tunggu 2-3 menit

### **Opsi 2: Redeploy**
1. Railway Dashboard → Service "web"
2. Deployments → Klik deployment terbaru
3. Klik **"Redeploy"**
4. Tunggu build selesai

### **Opsi 3: Force Push**
```bash
# Di terminal local
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
git add .
git commit -m "Force redeploy"
git push origin main --force
```

---

## 📊 Status yang Normal

Setelah deploy berhasil:

```
✅ Build: Success (hijau)
✅ Deploy: Active (hijau)
✅ Health Check: Passing
✅ URL: Accessible
```

---

## 🔧 Debug Mode

Jika masih bermasalah, aktifkan debug:

1. Railway → Variables
2. Set `APP_DEBUG=true`
3. Redeploy
4. Buka URL
5. Lihat error message detail
6. **JANGAN LUPA** set kembali `APP_DEBUG=false` setelah selesai!

---

## 📞 Cek Logs Real-time

Di Railway dashboard:
1. Klik service "web"
2. Klik tab **"Logs"**
3. Lihat log real-time
4. Cari error message

**Yang harus ada di logs:**
```
Laravel development server started on http://0.0.0.0:$PORT
```

---

## ⏱️ Berapa Lama Deploy?

Normal deployment time:
- **Build**: 2-5 menit
- **Deploy**: 30 detik - 1 menit
- **Total**: 3-6 menit

Jika lebih dari 10 menit, ada masalah!

---

## 💡 Tips

1. **Selalu cek Logs** - 90% masalah bisa dilihat di logs
2. **Environment Variables** - Pastikan semua variable sudah benar
3. **Database Connection** - Gunakan `${{MySQL.VARIABLE}}` format
4. **Patience** - Tunggu build selesai sebelum redeploy lagi

---

## 🆘 Jika Masih Gagal

Coba langkah ini:

1. **Delete deployment** yang error
2. **Redeploy** dari scratch
3. **Cek logs** dengan teliti
4. **Screenshot error** dan tanyakan ke saya

---

Semoga berhasil! 🎉
