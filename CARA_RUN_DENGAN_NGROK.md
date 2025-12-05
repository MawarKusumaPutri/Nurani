# 🚀 Cara Run Website dengan Ngrok

Panduan lengkap cara menjalankan website menggunakan ngrok untuk akses dari device lain.

---

## 📋 **LANGKAH-LANGKAH**

### **Langkah 1: Pastikan Apache Berjalan**

1. **Buka XAMPP Control Panel**
   - Cari "XAMPP Control Panel" di Start Menu
   - Atau buka: `D:\Praktikum DWBI\xampp\xampp-control.exe`

2. **Start Apache**
   - Klik **Start** pada **Apache**
   - Pastikan status **Running** (hijau) ✅

**⚠️ PENTING:** Apache harus berjalan sebelum menjalankan ngrok!

---

### **Langkah 2: Jalankan Ngrok**

Ada **2 cara** untuk menjalankan ngrok:

#### **Cara A: Menggunakan Script (Paling Mudah) ✅**

1. **Double-click file:** `SETUP_NGROK_LENGKAP.bat`
   - File ini ada di folder project: `D:\Praktikum DWBI\xampp\htdocs\nurani\`
   
2. **Script akan otomatis:**
   - Cek ngrok.exe ✅
   - Cek authtoken sudah setup
   - Cek Apache running
   - Jalankan ngrok

3. **Akan muncul jendela baru** dengan output ngrok

#### **Cara B: Manual di Terminal**

1. **Buka PowerShell atau Command Prompt**
   - Tekan `Win + R`
   - Ketik: `powershell` atau `cmd`
   - Tekan Enter

2. **Masuk ke folder project:**
   ```bash
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```

3. **Jalankan ngrok:**
   ```bash
   ngrok http 80
   ```
   Atau jika ngrok.exe ada di folder project:
   ```bash
   .\ngrok.exe\ngrok.exe http 80
   ```

4. **Tekan Enter**

---

### **Langkah 3: Lihat Output Ngrok**

**Setelah ngrok berjalan, akan muncul output seperti ini:**

```
ngrok

Session Status                online
Account                       [Your Account]
Version                       3.x.x
Region                        [Region]
Latency                       [Latency]
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://abc-def-123.ngrok-free.dev -> http://localhost:80

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

**Yang penting adalah baris "Forwarding":**
```
Forwarding    https://abc-def-123.ngrok-free.dev -> http://localhost:80
```

**URL yang Anda butuhkan:**
```
https://abc-def-123.ngrok-free.dev
```

**⚠️ CATATAN:** 
- URL ngrok **berbeda setiap kali restart** ngrok
- **Jangan tutup terminal/jendela ngrok** - jika ditutup, tunnel akan mati

---

### **Langkah 4: Copy URL dari Ngrok**

**Dari baris "Forwarding", copy URL:**
```
https://abc-def-123.ngrok-free.dev
```

**Cara copy:**
1. Select/highlight URL: `https://abc-def-123.ngrok-free.dev`
2. Tekan `Ctrl + C` (atau klik kanan → Copy)

**⚠️ PENTING:** 
- Copy **hanya bagian kiri** (sebelum `->`)
- Jangan copy `http://localhost:80`

---

### **Langkah 5: Tambahkan `/nurani/public` di Akhir URL**

**URL yang sudah di-copy:**
```
https://abc-def-123.ngrok-free.dev
```

**Tambahkan `/nurani/public` di akhir:**
```
https://abc-def-123.ngrok-free.dev/nurani/public
```

**Cara:**
1. Paste URL yang sudah di-copy: `https://abc-def-123.ngrok-free.dev`
2. Tambahkan `/nurani/public` di akhir
3. Hasil akhir: `https://abc-def-123.ngrok-free.dev/nurani/public`

---

### **Langkah 6: Test di Browser (Device yang Sama)**

**Buka browser di komputer yang sama:**

1. Buka browser (Chrome, Edge, Firefox, dll)
2. Ketik atau paste URL lengkap:
   ```
   https://abc-def-123.ngrok-free.dev/nurani/public
   ```
3. Tekan Enter

**Hasil yang diharapkan:**
- ✅ Website muncul (halaman login atau dashboard)
- ✅ Tidak ada error `ERR_NGROK_3200`
- ✅ Aplikasi Laravel berfungsi normal

**Jika muncul halaman "Visit Site" dari Ngrok:**
- Klik tombol **"Visit Site"** atau **"Continue"**
- Website akan muncul setelah itu

---

### **Langkah 7: Share ke Device Lain (Smartphone/Laptop Lain)**

**Dari smartphone atau laptop lain:**

1. **Buka browser** (Chrome, Safari, Firefox, dll)

2. **Ketik atau paste URL lengkap:**
   ```
   https://abc-def-123.ngrok-free.dev/nurani/public
   ```
   **⚠️ PENTING:** 
   - Pastikan menggunakan URL yang **sama persis** dari terminal ngrok
   - Jangan pakai contoh URL atau URL lama
   - Pastikan sudah ditambahkan `/nurani/public` di akhir

3. **Tekan Enter atau Go**

4. **Jika muncul halaman "Visit Site" dari Ngrok:**
   - Klik tombol **"Visit Site"** atau **"Continue"**
   - Website akan muncul setelah itu

5. **Test fitur aplikasi:**
   - Login
   - Navigasi menu
   - Test fitur presensi
   - Test upload surat sakit (jika ada)

---

## ✅ **RINGKASAN LANGKAH**

1. ✅ **Start Apache** di XAMPP (harus hijau)
2. ✅ **Jalankan ngrok:** `ngrok http 80` (atau double-click `SETUP_NGROK_LENGKAP.bat`)
3. ✅ **Copy URL** dari baris "Forwarding"
4. ✅ **Tambahkan `/nurani/public`** di akhir URL
5. ✅ **Test di browser:** `https://[URL_NGROK]/nurani/public`
6. ✅ **Share URL** ke device lain

---

## 🎯 **CONTOH URL LENGKAP**

**Dari terminal ngrok:**
```
Forwarding    https://abc-def-123.ngrok-free.dev -> http://localhost:80
```

**URL untuk akses:**
```
https://abc-def-123.ngrok-free.dev/nurani/public
```

**Gunakan URL ini untuk:**
- ✅ Test di browser
- ✅ Share ke device lain
- ✅ Bookmark di browser

---

## ⚠️ **CATATAN PENTING**

### 1. URL Ngrok Berubah Setiap Restart

**⚠️ PENTING:**
- URL ngrok **berubah setiap kali restart** ngrok
- Jika ngrok di-restart, URL baru akan muncul
- **Selalu cek URL baru** dari baris "Forwarding" di terminal

**Contoh:**
- URL pertama: `https://abc-def-123.ngrok-free.dev`
- Setelah restart: `https://xyz-ghi-456.ngrok-free.app` (berbeda!)

**Solusi:**
- **Jangan tutup jendela terminal** yang menjalankan ngrok
- Jika ngrok di-restart, **update URL** di device lain

---

### 2. Jendela Terminal Harus Tetap Terbuka

**⚠️ PENTING:**
- Jendela terminal yang menjalankan ngrok **harus tetap terbuka**
- Jika ditutup, ngrok akan berhenti
- Jika ngrok berhenti, URL tidak akan bisa diakses

**Solusi:**
- **Minimize jendela** (jangan tutup)
- Atau jalankan ngrok di background (jika perlu)

---

### 3. Apache Harus Berjalan

**⚠️ PENTING:**
- Apache (XAMPP) **harus berjalan** di komputer host
- Jika Apache mati, ngrok akan error
- Pastikan Apache **hijau** di XAMPP Control Panel

**Cara cek:**
1. Buka XAMPP Control Panel
2. Pastikan Apache **hijau** (running)
3. Jika merah, klik **Start**

---

### 4. Halaman "Visit Site" dari Ngrok

**Jika muncul halaman "Visit Site":**
- Ini normal untuk akun Ngrok Free
- Klik tombol **"Visit Site"** atau **"Continue"**
- Website akan muncul setelah itu

**Cara skip (opsional):**
- Upgrade ke akun Ngrok berbayar
- Atau tetap klik "Visit Site" setiap kali

---

## 🚨 **TROUBLESHOOTING**

### Error: `ERR_NGROK_3200`

**Penyebab:** Ngrok offline atau URL salah

**Solusi:** 
1. Cek apakah ngrok masih berjalan di terminal
2. Pastikan menggunakan URL yang benar dari baris "Forwarding"
3. Restart ngrok jika perlu:
   - Tutup terminal ngrok
   - Jalankan lagi: `ngrok http 80`

---

### Error: `404 Not Found`

**Penyebab:** URL tidak lengkap (kurang `/nurani/public`)

**Solusi:** 
1. Pastikan URL lengkap: `https://[URL_NGROK]/nurani/public`
2. Jangan lupa tambahkan `/nurani/public` di akhir

---

### Error: Authtoken Required

**Penyebab:** Authtoken ngrok belum di-setup

**Solusi:**
1. Setup authtoken:
   ```bash
   ngrok config add-authtoken YOUR_AUTHTOKEN
   ```
2. Jalankan lagi: `ngrok http 80`

---

### Website Tidak Muncul di Device Lain

**Penyebab:** 
1. Ngrok tidak berjalan
2. Apache tidak berjalan
3. URL salah

**Solusi:**
1. Cek ngrok masih berjalan di terminal
2. Cek Apache hijau di XAMPP
3. Pastikan URL benar dan lengkap: `https://[URL_NGROK]/nurani/public`

---

### Ngrok Tidak Bisa Dijalankan

**Penyebab:** 
1. ngrok.exe tidak ditemukan
2. Path tidak benar

**Solusi:**
1. Cek file ada di: `D:\Praktikum DWBI\xampp\htdocs\nurani\ngrok.exe\ngrok.exe`
2. Atau jalankan dengan path lengkap:
   ```bash
   .\ngrok.exe\ngrok.exe http 80
   ```
3. Atau gunakan script: `SETUP_NGROK_LENGKAP.bat`

---

## 📱 **CARA SHARE URL KE DEVICE LAIN**

### Opsi 1: Copy-Paste Manual
1. Copy URL lengkap: `https://abc-def-123.ngrok-free.dev/nurani/public`
2. Kirim via WhatsApp, Email, atau chat
3. Device lain buka URL tersebut di browser

### Opsi 2: QR Code (Jika perlu)
1. Generate QR code dari URL: `https://abc-def-123.ngrok-free.dev/nurani/public`
2. Scan QR code dengan smartphone
3. Browser akan otomatis buka URL

### Opsi 3: Bookmark
1. Bookmark URL di browser
2. Share bookmark ke device lain

---

## 🎯 **CHECKLIST**

- [ ] Apache berjalan (hijau di XAMPP)
- [ ] Ngrok berjalan (ada baris "Forwarding" di terminal)
- [ ] URL sudah di-copy dari baris "Forwarding"
- [ ] URL sudah ditambahkan `/nurani/public` di akhir
- [ ] Test di browser (device yang sama) berhasil
- [ ] Test di device lain (smartphone/laptop) berhasil
- [ ] Jendela terminal tetap terbuka
- [ ] Apache tetap berjalan (hijau)

---

## 💡 **TIPS**

1. **Gunakan script otomatis:** Double-click `SETUP_NGROK_LENGKAP.bat` untuk kemudahan
2. **Bookmark URL:** Bookmark URL lengkap di browser untuk akses cepat
3. **Jangan tutup terminal:** Minimize saja, jangan tutup
4. **Cek Apache:** Pastikan Apache tetap hijau
5. **Update URL:** Jika ngrok di-restart, update URL di device lain

---

**Selamat menggunakan ngrok! 🎉**

**Intinya:**
1. Start Apache ✅
2. Jalankan `ngrok http 80` ✅
3. Copy URL dari "Forwarding" ✅
4. Tambahkan `/nurani/public` ✅
5. Buka di browser ✅

