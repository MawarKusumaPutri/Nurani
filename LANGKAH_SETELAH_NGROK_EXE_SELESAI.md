# 🚀 Langkah Setelah ngrok.exe Selesai

## ✅ TAHAP YANG SUDAH SELESAI

Anda sudah:
- ✅ Download ngrok.exe
- ✅ Simpan di folder: `D:\Praktikum DWBI\xampp\htdocs\nurani\ngrok.exe`

---

## 🎯 LANGKAH SELANJUTNYA

Setelah ngrok.exe sudah di folder project, langkah selanjutnya:

1. ✅ **Setup Authtoken** (sekali saja)
2. ✅ **Jalankan Ngrok** (setiap kali pakai)
3. ✅ **Dapat URL Publik**
4. ✅ **Share URL ke Device Lain**

---

## 📋 LANGKAH 1: Setup Authtoken

**Authtoken Anda:**
```
36FAzX811PmFVMGBQN1EZILISVP_5fKbhCzV5Kzv8WYNfknui
```

### Cara 1: Pakai Script (Paling Mudah) ✅

1. **Double-click:** `SETUP_NGROK_LENGKAP.bat`
2. Script akan:
   - Cek ngrok.exe sudah ada ✅
   - Minta authtoken
3. **Paste authtoken:**
   ```
   36FAzX811PmFVMGBQN1EZILISVP_5fKbhCzV5Kzv8WYNfknui
   ```
4. Tekan Enter
5. Script akan setup authtoken otomatis
6. **Selesai!** Authtoken tersimpan

### Cara 2: Manual (Command Prompt)

1. Buka Command Prompt
2. Navigate ke folder project:
   ```cmd
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```
3. Setup authtoken:
   ```cmd
   ngrok config add-authtoken 36FAzX811PmFVMGBQN1EZILISVP_5fKbhCzV5Kzv8WYNfknui
   ```
4. Tekan Enter
5. **Selesai!** Authtoken tersimpan

---

## 🚀 LANGKAH 2: Jalankan Ngrok

**Setelah setup authtoken, jalankan ngrok:**

### Cara 1: Pakai Script (Paling Mudah) ✅

1. **Pastikan Apache Running** di XAMPP (hijau)
2. **Double-click:** `SETUP_NGROK_LENGKAP.bat`
3. Script akan:
   - Cek ngrok.exe ✅
   - Cek authtoken sudah setup ✅
   - Cek Apache running
   - Jalankan ngrok otomatis
4. **Akan muncul jendela ngrok baru**
5. **Catat URL** yang muncul (contoh: `https://abc123.ngrok.io`)
6. **Selesai!**

### Cara 2: Manual (Command Prompt)

1. **Pastikan Apache Running** di XAMPP (hijau)
2. Buka Command Prompt
3. Navigate ke folder project:
   ```cmd
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```
4. Jalankan ngrok:
   ```cmd
   ngrok http 80
   ```
5. **Akan muncul jendela ngrok**
6. **Catat URL** yang muncul
7. **Selesai!**

---

## 📱 LANGKAH 3: Dapat URL Publik

**Setelah ngrok running, dapat URL:**

1. **Lihat jendela ngrok** yang baru terbuka
2. **Cari baris "Forwarding"** → ada URL seperti:
   ```
   https://abc123.ngrok.io
   ```
3. **CATAT URL tersebut!**
4. **URL lengkap untuk akses:**
   ```
   https://abc123.ngrok.io/nurani/public
   ```
   (Ganti `abc123.ngrok.io` dengan URL ngrok Anda)

---

## 🌐 LANGKAH 4: Share URL ke Device Lain

**Setelah dapat URL, share ke device lain:**

1. **Copy URL lengkap:**
   ```
   https://abc123.ngrok.io/nurani/public
   ```
2. **Share ke device lain:**
   - WhatsApp
   - Email
   - Chat
   - dll
3. **Device lain akses:**
   - Buka browser
   - Ketik URL yang Anda share
   - Tekan Enter
   - **Website muncul!** ✅

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
- **TIDAK perlu WiFi sama!**

---

## 📋 RINGKASAN URUTAN LENGKAP

```
1. ngrok.exe sudah di folder ✅ (sudah selesai)
   ↓
2. Setup authtoken (pakai script) ✅
   ↓
3. Jalankan ngrok (pakai script) ✅
   ↓
4. Dapat URL publik ✅
   ↓
5. Share URL ke device lain ✅
   ↓
6. Device lain akses via internet ✅
```

---

## 🚀 LANGKAH CEPAT (Sekarang)

**Karena ngrok.exe sudah ada, langsung:**

1. ✅ **Double-click:** `SETUP_NGROK_LENGKAP.bat`
2. ✅ **Paste authtoken** saat diminta:
   ```
   36FAzX811PmFVMGBQN1EZILISVP_5fKbhCzV5Kzv8WYNfknui
   ```
3. ✅ Script akan:
   - Setup authtoken
   - Jalankan ngrok
4. ✅ **Catat URL** yang muncul
5. ✅ **Share URL** ke device lain
6. ✅ **Selesai!**

---

## 💡 TIPS

### 1. Simpan URL Ngrok
- Setelah ngrok running, **screenshot URL**
- **Share ke device lain** (WhatsApp, email, dll)
- Akan memudahkan akses

### 2. Bookmark di Device Lain
- Setelah berhasil akses, **bookmark URL** di browser device lain
- Akan memudahkan akses berikutnya

### 3. Jangan Tutup Ngrok
- **Jangan tutup jendela ngrok** saat device lain akses
- Jika ngrok mati, URL tidak bisa diakses

---

**Intinya: Double-click SETUP_NGROK_LENGKAP.bat, paste authtoken, lalu dapat URL!** 🎯

