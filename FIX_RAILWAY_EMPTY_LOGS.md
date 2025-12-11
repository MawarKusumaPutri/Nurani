# 🔧 Fix: Logs Kosong di Railway

## ❌ Masalah: Tab "Logs" Kosong

Tab "Logs" di Railway menampilkan **"No logs in this time range"** padahal service sedang crash.

---

## 🔍 Kenapa Logs Kosong?

### Alasan 1: Service Crash Terlalu Cepat
Service crash dalam **1 detik** setelah start, sehingga tidak sempat generate logs ke `stderr`.

### Alasan 2: LOG_CHANNEL Tidak Benar
Railway hanya bisa capture logs jika `LOG_CHANNEL=stderr`. Jika menggunakan channel lain (seperti `single` atau `stack`), logs akan ditulis ke file, bukan ke `stderr`.

### Alasan 3: Logs Ada di Tempat Lain
Error sebenarnya ada di **Deploy Logs**, bukan di tab "Logs" ini.

---

## ✅ Solusi: Cek Deploy Logs (PENTING!)

### Langkah 1: Buka Deploy Logs
1. Klik service **"web"** (yang merah)
2. Klik tab **"Deployments"** (bukan "Logs")
3. Klik deployment terbaru yang **CRASHED**
4. Klik **"View Logs"** atau **"Deploy Logs"**
5. **Scroll ke paling bawah** untuk melihat error terakhir

**📝 Error yang menyebabkan crash ada di sini!**

---

## ✅ Solusi: Pastikan LOG_CHANNEL=stderr

### Di Railway Variables:
1. Klik service **"web"** → tab **"Variables"**
2. Pastikan ada variable:
   ```
   LOG_CHANNEL=stderr
   ```
3. Jika belum ada, tambahkan
4. Save (Railway akan auto-restart)

**⚠️ PENTING:** Railway hanya bisa capture logs dari `stderr`. Jika menggunakan channel lain, logs akan ditulis ke file yang tidak terlihat di Railway dashboard.

---

## ✅ Solusi: Set LOG_LEVEL=debug

### Di Railway Variables:
1. Edit atau tambahkan:
   ```
   LOG_LEVEL=debug
   ```
2. Save

**Catatan:** 
- `debug`: Menampilkan semua level logs (debug, info, warning, error)
- `error`: Hanya menampilkan error (bisa melewatkan warning penting)

---

## 📋 Checklist

- [ ] **Cek Deploy Logs** untuk melihat error spesifik
- [ ] **Set LOG_CHANNEL=stderr** di Variables
- [ ] **Set LOG_LEVEL=debug** di Variables
- [ ] **Set APP_DEBUG=true** sementara untuk debugging
- [ ] **Cek error message** di Deploy Logs

---

## 🔍 Perbedaan Logs di Railway

### 1. Tab "Logs" (HTTP Logs)
- **Untuk:** Logs saat aplikasi sudah running
- **Isi:** HTTP requests, application logs, errors saat runtime
- **Kosong jika:** Service crash sebelum sempat handle request

### 2. Deploy Logs
- **Untuk:** Logs saat build dan startup
- **Isi:** Build errors, startup errors, crash errors
- **PENTING:** Error yang menyebabkan crash ada di sini!

### 3. Build Logs
- **Untuk:** Logs saat build process
- **Isi:** Composer install, npm install, build errors

---

## 💡 Tips

1. **Selalu cek Deploy Logs dulu** jika service crash
2. **Set LOG_CHANNEL=stderr** untuk Railway
3. **Set APP_DEBUG=true** sementara untuk melihat error detail
4. **Monitor Deploy Logs** saat service restart

---

## 🆘 Masih Kosong?

Jika Deploy Logs juga kosong atau tidak jelas:

1. **Set APP_DEBUG=true** di Variables
2. **Tunggu service restart**
3. **Cek Deploy Logs lagi**
4. **Cek HTTP Logs** (jika service sempat start)
5. **Cek Shell** untuk test manual

---

**Error yang menyebabkan crash pasti ada di Deploy Logs! Cek di sana! 🔍**
