# 🚀 Panduan Lengkap: Setup Ngrok (Akses Tanpa WiFi Sama)

## 🎯 TUJUAN

Membuat aplikasi Laravel bisa diakses dari internet tanpa perlu WiFi yang sama menggunakan **Ngrok** (GRATIS).

---

## 📋 LANGKAH 1: DAFTAR NGROK

1. **Buka browser**, kunjungi: **https://ngrok.com**
2. **Klik "Sign up"** atau "Get started for free"
3. **Daftar akun** (bisa pakai email atau GitHub)
4. **Verifikasi email** (jika perlu)
5. **Login** ke dashboard ngrok
6. **Dapat authtoken** (akan muncul di dashboard)

---

## 📥 LANGKAH 2: DOWNLOAD NGROK

1. **Di dashboard ngrok**, klik **"Download"**
2. **Pilih "Windows"**
3. **Download file** `ngrok.zip`
4. **Extract file** `ngrok.exe`
5. **Simpan** `ngrok.exe` di folder project:
   ```
   D:\Praktikum DWBI\xampp\htdocs\nurani\ngrok.exe
   ```

---

## 🔑 LANGKAH 3: SETUP AUTHTOKEN

1. **Buka Command Prompt**
2. **Navigate ke folder ngrok:**
   ```cmd
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```
3. **Setup authtoken:**
   ```cmd
   ngrok config add-authtoken [AUTHTOKEN_ANDA]
   ```
   (Ganti `[AUTHTOKEN_ANDA]` dengan authtoken dari dashboard ngrok)

4. **Selesai!** Authtoken sudah tersimpan

---

## 🚀 LANGKAH 4: JALANKAN NGROK

### Cara 1: Pakai Script Otomatis

1. **Double-click:** `SETUP_NGROK_GRATIS.bat`
2. **Script akan otomatis:**
   - Cek ngrok sudah terinstall
   - Cek Apache running
   - Jalankan ngrok
3. **Lihat jendela ngrok** yang baru terbuka
4. **Catat URL** yang muncul (contoh: `https://abc123.ngrok.io`)

### Cara 2: Manual

1. **Buka Command Prompt**
2. **Navigate ke folder project:**
   ```cmd
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```
3. **Jalankan ngrok:**
   ```cmd
   ngrok http 80
   ```
   Atau jika pakai path khusus:
   ```cmd
   ngrok http localhost/nurani/public
   ```
4. **Akan muncul jendela ngrok** dengan URL

---

## 📱 LANGKAH 5: AKSES DARI DEVICE LAIN

### Dari Smartphone (Pakai Data/Internet):

1. **Pastikan smartphone terhubung ke internet** (data atau WiFi)
2. **Buka browser** (Chrome, Safari, dll)
3. **Ketik URL ngrok** yang muncul di jendela ngrok:
   ```
   https://abc123.ngrok.io/nurani/public
   ```
   (Ganti `abc123.ngrok.io` dengan URL ngrok Anda)
4. **Tekan Enter**
5. **Website akan muncul!** ✅

### Dari Laptop Lain (Pakai Internet):

1. **Pastikan laptop terhubung ke internet**
2. **Buka browser**
3. **Ketik URL ngrok:**
   ```
   https://abc123.ngrok.io/nurani/public
   ```
4. **Tekan Enter**
5. **Website akan muncul!** ✅

---

## ⚠️ CATATAN PENTING

### 1. URL Ngrok Berubah
- **Gratis:** URL berubah setiap restart ngrok
- **Berbayar:** URL tetap (pakai custom domain)

### 2. Ngrok Harus Selalu Running
- **Jika ngrok mati**, URL tidak bisa diakses
- **Jangan tutup jendela ngrok** saat pakai

### 3. Untuk Production
- **Ngrok gratis** hanya untuk testing
- **Untuk production**, gunakan hosting online

---

## 🔧 TROUBLESHOOTING

### ❌ Error: "ngrok: command not found"

**Solusi:**
- Pastikan `ngrok.exe` ada di folder project
- Atau tambahkan ngrok ke PATH Windows

### ❌ Error: "authtoken required"

**Solusi:**
- Setup authtoken dulu (Langkah 3)
- Atau jalankan: `ngrok config add-authtoken [TOKEN]`

### ❌ Error: "port 80 already in use"

**Solusi:**
- Pastikan Apache running di XAMPP
- Atau gunakan port lain: `ngrok http 8080`

### ❌ URL Tidak Bisa Diakses

**Solusi:**
- Pastikan ngrok masih running
- Pastikan Apache running
- Cek URL ngrok di jendela ngrok (mungkin sudah berubah)

---

## 💡 TIPS

### 1. Simpan URL Ngrok
- Setelah ngrok running, **catat URL** yang muncul
- **Simpan di notes/phone**
- Akan berguna untuk akses dari device lain

### 2. Bookmark URL
- Setelah berhasil akses, **bookmark URL** di browser
- Akan memudahkan akses berikutnya

### 3. Pakai Custom Domain (Berbayar)
- Jika pakai plan berbayar, bisa pakai custom domain
- URL tidak akan berubah

---

## 🎯 RINGKASAN

```
1. Daftar ngrok → https://ngrok.com
2. Download ngrok.exe
3. Setup authtoken
4. Jalankan ngrok → SETUP_NGROK_GRATIS.bat
5. Catat URL ngrok
6. Akses dari device lain → https://[URL_NGROK]/nurani/public
```

---

## ✅ KEUNTUNGAN NGROK

- ✅ **GRATIS** untuk testing
- ✅ Tidak perlu WiFi sama
- ✅ Bisa diakses dari internet
- ✅ Mudah setup
- ✅ Cocok untuk testing/demo

---

**Dengan ngrok, aplikasi bisa diakses dari mana saja tanpa perlu WiFi yang sama!** 🎯

