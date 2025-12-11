# 🚀 Cara Manual Deploy di Railway

## 📍 Lokasi Tombol Deploy

Di Railway, tombol deploy **TIDAK** ada di Settings. Berikut lokasinya:

---

## 🎯 CARA 1: Deploy dari Tab "Deployments" (Paling Mudah)

### Langkah-langkah:
1. **Klik service "Nurani"** (di Architecture view atau di sidebar kiri)
2. Klik tab **"Deployments"** (di atas, sebelah "Variables", "Metrics", "Settings")
3. Di bagian atas, ada tombol **"Deploy"** atau **"Redeploy"**
4. Klik tombol tersebut
5. Tunggu build selesai

---

## 🎯 CARA 2: Deploy dari Architecture View

### Langkah-langkah:
1. Klik tab **"Architecture"** (di navigation bar atas)
2. Klik service card **"Nurani"** (yang ada di canvas)
3. Akan muncul popup atau sidebar
4. Cari tombol **"Deploy"** atau **"Redeploy"**
5. Klik tombol tersebut

---

## 🎯 CARA 3: Deploy dari GitHub (Auto-Deploy)

### Jika sudah connect GitHub:
1. **Push perubahan ke GitHub** (sudah dilakukan)
2. Railway akan **otomatis detect** dan deploy
3. Tunggu 1-2 menit
4. Cek di tab **"Deployments"** untuk deployment baru

---

## 🎯 CARA 4: Force Redeploy via Settings

### Langkah-langkah:
1. Klik service **"Nurani"**
2. Klik tab **"Settings"**
3. Scroll ke bagian bawah
4. Cari section **"Deployment"** atau **"Service"**
5. Cari tombol **"Redeploy"** atau **"Restart"**
6. Atau cari **"Clear Build Cache"** lalu deploy ulang

---

## 🎯 CARA 5: Via Deployments Tab (Recommended)

### Langkah-langkah:
1. **Klik service "Nurani"** (di sidebar kiri atau Architecture view)
2. Pastikan Anda di halaman service (bukan project settings)
3. Klik tab **"Deployments"** (di atas)
4. Di bagian atas deployments list, ada:
   - Tombol **"Deploy"** (warna ungu)
   - Atau dropdown **"..."** (three dots) → **"Redeploy"**
5. Klik tombol tersebut
6. Tunggu build selesai

---

## 📋 Checklist: Pastikan Anda di Halaman yang Benar

### ✅ Yang Benar:
- URL mengandung: `/service/...` (bukan `/settings`)
- Ada tab: **"Deployments"**, **"Variables"**, **"Metrics"**, **"Settings"**
- Ada service name: **"Nurani"** di header

### ❌ Yang Salah:
- URL: `/project/.../settings` (ini project settings, bukan service settings)
- Tidak ada tab "Deployments"
- Hanya ada: "General", "Usage", "Environments", dll (ini project settings)

---

## 🎯 Jika Masih Tidak Ada Tombol Deploy

### Solusi 1: Cek Apakah Service Aktif
1. Klik tab **"Architecture"**
2. Lihat service "Nurani"
3. Jika status **"Stopped"**, klik service → **"Start"**

### Solusi 2: Deploy dari GitHub
1. Pastikan code sudah di-push ke GitHub
2. Railway akan auto-deploy
3. Tunggu 1-2 menit
4. Cek tab "Deployments"

### Solusi 3: Hapus dan Buat Ulang Service
1. Klik service "Nurani"
2. Tab "Settings"
3. Scroll ke bawah
4. Klik **"Delete Service"**
5. Buat service baru dari GitHub repo

---

## 💡 Tips

1. **Pastikan di Service Settings**, bukan Project Settings
2. **Tab "Deployments"** adalah tempat utama untuk deploy
3. **Auto-deploy** dari GitHub biasanya lebih mudah
4. **Refresh browser** jika tombol tidak muncul

---

## 🆘 Masih Bingung?

**Kirimkan screenshot:**
1. Screenshot halaman yang Anda lihat sekarang
2. Atau screenshot tab "Deployments"
3. Saya akan bantu cari tombol deploy-nya

---

**Coba Cara 1 dulu: Klik service "Nurani" → Tab "Deployments" → Cari tombol "Deploy"!** 🚀

