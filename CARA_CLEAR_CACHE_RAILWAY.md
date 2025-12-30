# 🔧 CARA CLEAR BUILD CACHE DI RAILWAY

## 🎯 Tujuan
Menghapus build cache lama agar Railway install PhpSpreadsheet dengan benar.

---

## ⚠️ PENTING - WAJIB DILAKUKAN!

Setelah push commit terbaru, Anda **WAJIB** clear build cache di Railway Dashboard:

---

## 📋 LANGKAH-LANGKAH:

### **Step 1: Buka Railway Dashboard**
1. Buka browser
2. Go to: https://railway.app
3. Login dengan akun Anda
4. Pilih project "TMS Nurani"

### **Step 2: Buka Settings**
1. Klik service "web" (yang ada error)
2. Klik tab **"Settings"** di bagian atas

### **Step 3: Clear Build Cache**
1. Scroll ke bawah sampai bagian **"Danger Zone"**
2. Cari button **"Clear Build Cache"**
3. Klik button tersebut
4. Konfirmasi jika diminta

### **Step 4: Redeploy**
1. Setelah clear cache, klik tab **"Deployments"**
2. Klik button **"Redeploy"** atau **"Deploy Latest"**
3. Tunggu proses build (~5-10 menit)

---

## 🔍 VERIFIKASI BUILD BERHASIL:

### **Cek Build Logs:**
1. Klik deployment yang sedang berjalan
2. Klik "View logs"
3. Cari baris ini:

```
✅ Installing dependencies from lock file
✅ Package operations: X installs, Y updates, Z removals
✅ Installing phpoffice/phpspreadsheet (1.28.x)
✅ Generating optimized autoload files
✅ Build successful!
```

### **Jika Muncul Error:**
- Screenshot error message
- Share ke developer
- Jangan panic, ada solusi lain

---

## 🚀 SETELAH DEPLOYMENT BERHASIL:

### **Step 1: Hard Refresh Browser**
```
Windows: Ctrl + Shift + R
Mac: Cmd + Shift + R
```

### **Step 2: Test Import Excel**
1. Buka halaman Data Siswa
2. Klik "Import Excel"
3. Download template (.xlsx)
4. Upload file Excel
5. **Berhasil!** ✅

---

## ⚠️ TROUBLESHOOTING:

### **Error: "Class 'PhpOffice\PhpSpreadsheet\IOFactory' not found"**

**Penyebab:** Build cache belum di-clear

**Solusi:**
1. Clear build cache (ulangi Step 3)
2. Redeploy (ulangi Step 4)
3. Tunggu sampai selesai

### **Error: "Deployment failed during build process"**

**Penyebab:** Ada dependency conflict

**Solusi:**
1. Cek build logs
2. Screenshot error
3. Share ke developer

### **Error: "Memory limit exceeded"**

**Penyebab:** Railway kehabisan memory

**Solusi:**
1. Upgrade Railway plan (jika perlu)
2. Atau hubungi developer untuk optimasi

---

## 💡 TIPS:

### **1. Selalu Clear Cache Setelah Update Dependencies**
Jika menambah/update package di composer.json, selalu:
- Clear build cache
- Redeploy

### **2. Cek Build Logs**
Selalu cek build logs untuk memastikan package terinstall dengan benar.

### **3. Hard Refresh Browser**
Setelah deployment berhasil, selalu hard refresh browser.

---

## ✅ CHECKLIST:

- [ ] Push commit terbaru ke GitHub
- [ ] Buka Railway Dashboard
- [ ] Klik Settings
- [ ] Clear Build Cache
- [ ] Redeploy
- [ ] Tunggu build selesai (~10 menit)
- [ ] Cek build logs (pastikan PhpSpreadsheet terinstall)
- [ ] Hard refresh browser
- [ ] Test import Excel
- [ ] **Berhasil!** 🎉

---

## 🎉 SELESAI!

Setelah clear build cache dan redeploy, error **"Class 'PhpOffice\PhpSpreadsheet\IOFactory' not found"** akan hilang!

**PhpSpreadsheet akan terinstall dengan benar dan import Excel akan berfungsi!** 🚀✨
