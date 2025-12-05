# 🚀 Cara Menjalankan Website

Panduan lengkap cara menjalankan website Laravel ini.

---

## 📋 **CARA 1: Menggunakan XAMPP (Paling Mudah)**

### **Langkah 1: Pastikan XAMPP Berjalan**

1. **Buka XAMPP Control Panel**
   - Cari "XAMPP Control Panel" di Start Menu
   - Atau buka: `D:\Praktikum DWBI\xampp\xampp-control.exe`

2. **Start Apache dan MySQL**
   - Klik **Start** pada **Apache** (harus hijau)
   - Klik **Start** pada **MySQL** (harus hijau)
   - Pastikan status keduanya **Running** (hijau)

### **Langkah 2: Buka Website di Browser**

**Buka browser** (Chrome, Edge, Firefox, dll) dan ketik salah satu URL berikut:

#### **Opsi A: Menggunakan localhost**
```
http://localhost/nurani/public
```

#### **Opsi B: Menggunakan localhost dengan index.php**
```
http://localhost/nurani/public/index.php
```

### **Langkah 3: Website Siap Digunakan!**

✅ Website akan muncul di browser dan siap digunakan!

---

## 📋 **CARA 2: Menggunakan Laravel Development Server**

### **Langkah 1: Buka Terminal/PowerShell**

1. Tekan `Win + R`
2. Ketik: `powershell` atau `cmd`
3. Tekan Enter

### **Langkah 2: Masuk ke Folder Project**

```bash
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
```

### **Langkah 3: Jalankan Laravel Server**

```bash
php artisan serve
```

**Hasil yang muncul:**
```
Starting Laravel development server: http://127.0.0.1:8000
```

### **Langkah 4: Buka Website di Browser**

**Buka browser** dan ketik:
```
http://127.0.0.1:8000
```
atau
```
http://localhost:8000
```

### **Langkah 5: Website Siap Digunakan!**

✅ Website akan muncul di browser!

**Catatan:** Terminal/PowerShell harus tetap terbuka. Jika ditutup, server akan berhenti.

---

## 📋 **CARA 3: Menggunakan Ngrok (Untuk Akses dari Device Lain)**

Jika ingin mengakses website dari smartphone atau laptop lain, gunakan ngrok.

### **Langkah 1: Pastikan Apache Berjalan**

1. Buka XAMPP Control Panel
2. Pastikan **Apache** berjalan (hijau)

### **Langkah 2: Jalankan Ngrok**

**Opsi A: Jika menggunakan XAMPP (localhost)**
```bash
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
ngrok http 80
```

**Opsi B: Jika menggunakan Laravel Server**
```bash
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
ngrok http 8000
```

### **Langkah 3: Copy URL dari Ngrok**

Dari terminal ngrok, cari baris **"Forwarding"**:
```
Forwarding  https://abc-def-123.ngrok-free.dev -> http://localhost:80
```

**Copy URL:** `https://abc-def-123.ngrok-free.dev`

### **Langkah 4: Tambahkan `/nurani/public` di Akhir URL**

**URL lengkap:**
```
https://abc-def-123.ngrok-free.dev/nurani/public
```

### **Langkah 5: Buka di Browser (Device yang Sama)**

1. Buka browser
2. Ketik URL lengkap: `https://abc-def-123.ngrok-free.dev/nurani/public`
3. Tekan Enter
4. Jika muncul halaman "Visit Site", klik **"Visit Site"** atau **"Continue"**

### **Langkah 6: Share ke Device Lain**

1. **Copy URL lengkap:** `https://abc-def-123.ngrok-free.dev/nurani/public`
2. **Kirim ke device lain** (WhatsApp, Email, Chat, dll)
3. **Buka di browser device lain**
4. Website akan muncul!

**⚠️ PENTING:**
- Terminal ngrok **harus tetap terbuka**
- Apache **harus tetap berjalan**
- URL ngrok **berubah setiap restart** ngrok

---

## ✅ **RINGKASAN CEPAT**

### **Untuk Development Lokal (Cepat):**
```bash
# 1. Start Apache di XAMPP
# 2. Buka browser: http://localhost/nurani/public
```

### **Untuk Development dengan Laravel Server:**
```bash
# 1. Buka terminal
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan serve
# 2. Buka browser: http://localhost:8000
```

### **Untuk Akses dari Device Lain:**
```bash
# 1. Start Apache di XAMPP
# 2. Jalankan ngrok: ngrok http 80
# 3. Copy URL dari ngrok, tambahkan /nurani/public
# 4. Buka di browser: https://[URL_NGROK]/nurani/public
```

---

## 🔧 **TROUBLESHOOTING**

### **Error: "This site can't be reached"**
**Solusi:**
1. Pastikan Apache berjalan di XAMPP (hijau)
2. Restart Apache: Stop → Tunggu 5 detik → Start
3. Coba akses: `http://localhost/nurani/public`

### **Error: "404 Not Found"**
**Solusi:**
1. Pastikan path benar: `http://localhost/nurani/public`
2. Cek file ada di: `D:\Praktikum DWBI\xampp\htdocs\nurani\public\index.php`
3. Clear cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

### **Error: "500 Internal Server Error"**
**Solusi:**
1. Cek file `.env` ada dan benar
2. Clear cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```
3. Restart Apache

### **Ngrok Error: "ERR_NGROK_3200"**
**Solusi:**
1. Pastikan ngrok masih berjalan di terminal
2. Pastikan Apache berjalan
3. Restart ngrok: Tutup terminal → Buka lagi → Jalankan ngrok

---

## 📝 **CATATAN PENTING**

1. **XAMPP harus berjalan** untuk menggunakan Apache
2. **MySQL harus berjalan** jika menggunakan database
3. **Terminal harus tetap terbuka** jika menggunakan Laravel server atau ngrok
4. **URL ngrok berubah** setiap restart ngrok
5. **Clear cache** jika ada perubahan yang tidak muncul

---

## 🎯 **REKOMENDASI**

- **Untuk development lokal:** Gunakan **CARA 1** (XAMPP) - Paling mudah dan cepat
- **Untuk testing cepat:** Gunakan **CARA 2** (Laravel Server) - Tidak perlu XAMPP
- **Untuk akses dari device lain:** Gunakan **CARA 3** (Ngrok) - Untuk testing di smartphone

---

**Selamat menggunakan website! 🎉**

