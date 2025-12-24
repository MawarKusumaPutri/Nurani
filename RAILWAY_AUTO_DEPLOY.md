# Railway Auto-Deploy Configuration

Railway akan otomatis deploy setiap kali ada push ke branch master di GitHub.

## Cara Memastikan Auto-Deploy Aktif:

1. **Buka Railway Dashboard:** https://railway.app
2. **Pilih Project:** TMS Nurani
3. **Klik Service:** web
4. **Klik Tab:** Settings
5. **Scroll ke:** Source
6. **Pastikan:**
   - ✅ Connected to GitHub
   - ✅ Repository: MawarKusumaPutri/Nurani
   - ✅ Branch: master
   - ✅ Auto-deploy: ON (enabled)

## Jika Auto-Deploy Tidak Aktif:

### **Cara Mengaktifkan:**

1. Di Railway Dashboard → Service → Settings
2. Cari bagian "Source" atau "GitHub"
3. Klik "Configure" atau "Edit"
4. Pastikan toggle "Auto-deploy" atau "Watch for changes" dalam posisi **ON**
5. Save

## Cara Kerja Auto-Deploy:

```
Git Push → GitHub → Railway Detect → Auto Build → Auto Deploy
```

**Timeline:**
- Push ke GitHub: 1-2 detik
- Railway detect: 10-30 detik
- Build: 3-10 menit
- Deploy: 1-2 menit
- **Total: 5-15 menit**

## Cara Cek Status Deploy:

1. Buka Railway Dashboard
2. Klik tab "Deployments"
3. Lihat deployment terbaru:
   - 🟡 **"Building"** → Sedang build
   - 🟡 **"Deploying"** → Sedang deploy
   - 🟢 **"Deployment successful"** → Sudah selesai ✅
   - 🔴 **"Failed"** → Ada error ❌

## Troubleshooting:

### **Problem: Railway tidak auto-deploy**

**Solusi:**
1. Cek koneksi GitHub di Railway Settings
2. Pastikan branch yang dipilih benar (master)
3. Reconnect GitHub jika perlu
4. Manual trigger deploy sekali untuk test

### **Problem: Deploy terlalu lama**

**Penyebab:**
- Composer install banyak package
- Build process kompleks
- Railway server sibuk

**Solusi:**
- Tunggu saja (normal 5-15 menit)
- Tidak bisa dipercepat

## Status Saat Ini:

**Deployment Terakhir:**
- Commit: "Add: Opsi Seluruhnya di dropdown semester..."
- Time: ~5 menit yang lalu
- Status: Cek di Railway Dashboard

**Jika sudah "Deployment successful":**
1. Hard refresh browser (Ctrl + Shift + R)
2. Test fitur import Excel
3. Dropdown semester sekarang ada "Seluruhnya"

---

**Railway seharusnya sudah auto-deploy.** Cek di Dashboard untuk memastikan!
