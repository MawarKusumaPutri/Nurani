# ✅ Cara Mencari Shell di Railway Dashboard

## 🎯 LOKASI SHELL DI RAILWAY

### Cara 1: Via Service (Paling Mudah)

1. **Buka Railway Dashboard** → `https://railway.app`
2. **Klik project "TMS Nurani"** (di sidebar kiri atau di halaman utama)
3. **Klik service "web"** (bukan MySQL, tapi service web)
4. **Di bagian atas, cari tab "Shell"** (ada di samping tab "Logs", "Settings", dll)
5. **Klik tab "Shell"**
6. **Shell akan terbuka di bagian bawah atau di tab baru**

---

### Cara 2: Via Tab Service (Shell TIDAK Ada di Menu Tiga Titik!)

**⚠️ PENTING: Shell TIDAK ada di menu tiga titik deployment!**

**Shell ada di tab service "web" di bagian atas:**

1. **Lihat ke bagian ATAS halaman** (di atas tab "Deployments")
2. **Anda akan melihat tab-tab:** "Architecture", "Observability", "Logs", "Settings"
3. **Klik tab "Observability"** atau **"Settings"**
4. **Di dalam tab tersebut, cari tab "Shell"** atau scroll ke bawah untuk menemukan Shell
5. **Atau langsung cari tab "Shell"** di bagian atas (mungkin tersembunyi atau perlu scroll)

---

## 📋 LOKASI TAB SHELL

**Tab "Shell" biasanya ada di:**
- Di bagian atas service "web" (bersama tab "Logs", "Settings", "Observability")
- Atau di menu "..." pada deployment

**Jika tidak terlihat:**
- Pastikan Anda klik service "web" (bukan MySQL)
- Pastikan Anda sudah login ke Railway
- Refresh halaman (F5)

---

## ✅ SETELAH SHELL TERBUKA

**Setelah Shell terbuka, jalankan:**

```bash
php artisan migrate --force
php artisan db:seed --class=UserSeeder
```

**Tunggu sampai selesai, lalu test login di Railway!**

---

## 🎯 LOKASI SPESIFIK UNTUK ANDA - ⚠️ SHELL TIDAK ADA DI MENU TIGA TITIK!

**Berdasarkan tampilan Railway Dashboard Anda:**

### ❌ Yang SALAH (Yang Sudah Anda Coba):
- Menu tiga titik pada deployment hanya menampilkan: "View logs", "Restart", "Redeploy", "Remove"
- **Shell TIDAK ada di menu tersebut!**

### ✅ Yang BENAR - Cari di Tab Bagian Atas:

**Lihat ke bagian ATAS halaman (di atas tab "Deployments"):**

1. **Anda akan melihat tab-tab utama:**
   - "Architecture" (yang sedang aktif)
   - "Observability" ← **COBA KLIK INI!**
   - "Logs"
   - "Settings" ← **ATAU COBA INI!**

2. **Klik tab "Observability"** atau **"Settings"**

3. **Di dalam tab tersebut:**
   - Scroll ke bawah
   - Atau cari tab "Shell" di bagian dalam
   - Shell biasanya muncul sebagai terminal/console di bagian bawah halaman

### 📍 Alternatif: Cek Tab "Logs"

**Klik tab "Logs" di bagian atas:**
- Di sana mungkin ada opsi untuk membuka Shell
- Atau Shell ada di bagian bawah halaman Logs

---

## 🎯 REKOMENDASI

**Karena Shell TIDAK ada di menu tiga titik deployment:**

1. **Klik tab "Observability"** di bagian atas service "web"
2. **Scroll ke bawah** di halaman Observability
3. **Cari terminal/console/Shell** di bagian bawah
4. **Atau klik tab "Settings"** dan cari opsi Shell di sana

---

**Klik ikon tiga titik "..." di sebelah kanan deployment untuk membuka Shell! 🚀**
