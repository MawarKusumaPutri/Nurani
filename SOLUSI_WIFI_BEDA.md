# 🔧 Solusi: WiFi Tidak Bisa Sama (Device "marina345")

## 🎯 MASALAH ANDA

- WiFi device ini: **"marina345"**
- Device lain tidak bisa pakai WiFi yang sama
- Perlu solusi agar device lain bisa akses aplikasi

---

## ✅ SOLUSI: Pakai Internet (Tidak Perlu WiFi Sama)

Karena WiFi tidak bisa sama, **perlu akses via internet**. Ada 2 opsi:

### 🚀 OPSI 1: Ngrok (GRATIS - Untuk Testing)

**Cara kerja:**
- Aplikasi tetap di laptop ini
- Ngrok membuat "terowongan" ke internet
- Device lain akses via internet (pakai data/WiFi mereka sendiri)
- **Tidak perlu WiFi sama!**

**Keuntungan:**
- ✅ **GRATIS**
- ✅ Tidak perlu WiFi sama
- ✅ Device lain pakai internet mereka sendiri
- ✅ Mudah setup

**Kekurangan:**
- ⚠️ URL berubah setiap restart (kecuali berbayar)
- ⚠️ Untuk testing saja

---

### 🌐 OPSI 2: Hosting Online (Berbayar - Untuk Production)

**Cara kerja:**
- Upload aplikasi ke server hosting
- Server hosting bisa diakses dari internet
- Device lain akses via internet
- **Tidak perlu WiFi sama!**

**Keuntungan:**
- ✅ URL tetap (tidak berubah)
- ✅ Lebih stabil
- ✅ Cocok untuk production
- ✅ Tidak perlu WiFi sama

**Kekurangan:**
- ⚠️ Perlu biaya (Rp 10.000-50.000/bulan)
- ⚠️ Perlu setup dan upload

---

## 🎯 REKOMENDASI UNTUK ANDA

### Untuk Testing/Demo Sekarang:
**→ Pakai Ngrok (GRATIS)**

### Untuk Production Jangka Panjang:
**→ Deploy ke Hosting Online**

---

## 📋 LANGKAH SETUP NGROK (GRATIS)

### Langkah 1: Daftar Ngrok
1. Buka: **https://ngrok.com**
2. Klik **"Sign up"** (gratis)
3. Daftar dengan email
4. Login ke dashboard

### Langkah 2: Download Ngrok
1. Di dashboard, klik **"Download"**
2. Pilih **"Windows"**
3. Download `ngrok.zip`
4. Extract `ngrok.exe`
5. **Simpan di folder project ini:**
   ```
   D:\Praktikum DWBI\xampp\htdocs\nurani\ngrok.exe
   ```

### Langkah 3: Setup Authtoken
1. Di dashboard ngrok, **copy authtoken** Anda
2. Buka Command Prompt
3. Jalankan:
   ```cmd
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ngrok config add-authtoken [AUTHTOKEN_ANDA]
   ```
   (Ganti `[AUTHTOKEN_ANDA]` dengan authtoken dari dashboard)

### Langkah 4: Jalankan Ngrok
1. **Double-click:** `SETUP_NGROK_GRATIS.bat`
2. Script akan otomatis jalankan ngrok
3. **Catat URL** yang muncul (contoh: `https://abc123.ngrok.io`)

### Langkah 5: Akses dari Device Lain
1. **Device lain** (smartphone/laptop) harus **terhubung ke internet** (data/WiFi mereka sendiri)
2. Buka browser
3. Ketik:
   ```
   https://[URL_NGROK]/nurani/public
   ```
   Contoh: `https://abc123.ngrok.io/nurani/public`
4. **Website akan muncul!** ✅

---

## 🔍 CARA KERJA NGROK

```
Laptop Anda (WiFi: marina345)
    ↓
Ngrok (membuat terowongan ke internet)
    ↓
Internet
    ↓
Device Lain (WiFi/data mereka sendiri)
    ↓
Akses aplikasi ✅
```

**Tidak perlu WiFi sama!** Semua device cukup terhubung ke internet.

---

## 📱 CONTOH AKSES DARI DEVICE LAIN

### Dari Smartphone:
1. **Aktifkan data** atau **WiFi** (WiFi mereka sendiri, bukan marina345)
2. Buka browser
3. Ketik: `https://abc123.ngrok.io/nurani/public`
4. **Website muncul!** ✅

### Dari Laptop Lain:
1. **Terhubung ke internet** (WiFi/data mereka sendiri)
2. Buka browser
3. Ketik: `https://abc123.ngrok.io/nurani/public`
4. **Website muncul!** ✅

---

## ⚠️ CATATAN PENTING

### 1. Ngrok Harus Selalu Running
- **Jangan tutup jendela ngrok** saat device lain akses
- Jika ngrok mati, URL tidak bisa diakses

### 2. URL Berubah Setiap Restart
- **Gratis:** URL berubah setiap restart ngrok
- **Berbayar:** URL tetap (custom domain)

### 3. Semua Device Harus Terhubung Internet
- Laptop Anda: terhubung internet (WiFi marina345)
- Device lain: terhubung internet (WiFi/data mereka sendiri)
- **Tidak perlu WiFi sama!**

---

## 🚀 LANGKAH CEPAT (Pakai Script)

1. **Download ngrok.exe** → simpan di folder project
2. **Setup authtoken** (sekali saja)
3. **Double-click:** `SETUP_NGROK_GRATIS.bat`
4. **Catat URL ngrok**
5. **Share URL** ke device lain
6. **Device lain akses** via internet

---

## 💡 TIPS

### 1. Simpan URL Ngrok
- Setelah ngrok running, **screenshot URL**
- **Share ke device lain** (WhatsApp, email, dll)
- Akan memudahkan akses

### 2. Bookmark di Device Lain
- Setelah berhasil akses, **bookmark URL** di browser device lain
- Akan memudahkan akses berikutnya

### 3. Untuk Production
- Jika butuh URL tetap, pertimbangkan **hosting online**
- Atau upgrade ngrok ke plan berbayar

---

## ✅ RINGKASAN

**Masalah:** WiFi tidak bisa sama (marina345)

**Solusi:** Pakai Ngrok (gratis) atau Hosting Online (berbayar)

**Cara kerja:**
- Laptop Anda: terhubung internet (WiFi marina345)
- Ngrok: membuat terowongan ke internet
- Device lain: akses via internet (WiFi/data mereka sendiri)
- **Tidak perlu WiFi sama!**

---

**Dengan Ngrok, device lain bisa akses aplikasi tanpa perlu WiFi yang sama!** 🎯

