# 🚨 SOLUSI: Railway Tidak Deploy

## ❌ MASALAH: Railway Tidak Auto-Deploy

Jika Railway tidak otomatis deploy setelah push ke GitHub, ada 2 solusi:

---

## ✅ SOLUSI 1: Aktifkan Auto-Deploy

### **Langkah-langkah:**

1. **Buka Railway Dashboard:** https://railway.app
2. **Login** dan pilih project "TMS Nurani"
3. **Klik service "web"**
4. **Klik tab "Settings"**
5. **Scroll ke bagian "Source"** atau "GitHub"
6. **Cari toggle "Auto Deploy" atau "Watch for Changes"**
7. **Aktifkan (ON)**
8. **Save/Apply**

### **Jika tidak ada toggle Auto-Deploy:**

1. Di Settings → Source
2. Klik "Disconnect" GitHub
3. Klik "Connect" GitHub lagi
4. Pilih repository: MawarKusumaPutri/Nurani
5. Pilih branch: master
6. Pastikan "Auto-deploy" atau "Watch for changes" aktif
7. Save

---

## ✅ SOLUSI 2: Manual Deploy (CEPAT!)

Jika auto-deploy tidak bisa diaktifkan, deploy manual:

### **Cara Manual Deploy:**

1. **Buka Railway Dashboard**
2. **Pilih project "TMS Nurani"**
3. **Klik service "web"**
4. **Klik tab "Deployments"**
5. **Klik tombol "Deploy"** atau **"Redeploy"** (biasanya di kanan atas)
6. **Tunggu proses deploy** (5-15 menit)
7. **Lihat status sampai "Deployment successful"** ✅

### **Atau via Command:**

Di Railway Dashboard → Service → Settings → Deploy Trigger:
- Copy webhook URL
- Atau klik "Deploy" button

---

## ✅ SOLUSI 3: Deploy via Railway CLI

Jika punya Railway CLI:

```bash
railway up
```

Atau:

```bash
railway redeploy
```

---

## 🎯 SETELAH DEPLOY SELESAI:

1. **Hard refresh browser** (Ctrl + Shift + R) - 3 kali
2. **Buka website Railway**
3. **Login sebagai TU**
4. **Klik menu "Jadwal"**
5. **Klik "Import Excel"**
6. **Lihat dropdown semester** - sekarang ada "Seluruhnya" ✅
7. **Upload Excel**
8. **Klik "Import Jadwal"**
9. **Data akan muncul!** 🎉

---

## 📊 CARA CEK DEPLOY BERHASIL:

### **Cek 1: Lihat Deployment History**
- Railway Dashboard → Deployments
- Deployment terakhir harus: "Add: Script import jadwal alternatif..."
- Status: "Deployment successful" ✅

### **Cek 2: Lihat di Website**
- Buka website Railway
- Hard refresh (Ctrl + Shift + R)
- Klik "Import Excel"
- Dropdown semester ada "Seluruhnya"? ✅

### **Cek 3: Test Import**
- Upload file Excel
- Klik "Import Jadwal"
- Lihat apakah data muncul di tabel

---

## ⚠️ TROUBLESHOOTING:

### **Problem: Tidak ada tombol "Deploy"**
**Solusi:**
- Cek di tab "Settings" → Deploy
- Atau klik 3 titik (⋮) di deployment → Redeploy

### **Problem: Deploy failed**
**Solusi:**
- Klik deployment yang failed
- Lihat logs untuk error
- Screenshot dan kirim ke developer

### **Problem: Deploy stuck di "Building"**
**Solusi:**
- Tunggu 15-20 menit
- Jika masih stuck, cancel dan deploy ulang

---

## 🚀 LANGKAH CEPAT (RINGKASAN):

1. **Buka Railway Dashboard**
2. **Klik "Deploy" atau "Redeploy"**
3. **Tunggu 5-15 menit**
4. **Hard refresh browser**
5. **Test import Excel**

---

**Setelah deploy, fitur import Excel akan langsung berfungsi!** 🎉
