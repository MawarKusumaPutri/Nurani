# 🎯 Cara Mendapatkan URL Ngrok Lengkap

## 📋 **URL YANG ANDA INGINKAN**

```
https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/
```

**URL ini terdiri dari 2 bagian:**
1. **URL Ngrok:** `https://dorothy-fuzziest-goggly.ngrok-free.dev`
2. **Path Aplikasi:** `/nurani/public/`

---

## ✅ **LANGKAH-LANGKAH MENDAPATKAN URL**

### **LANGKAH 1: Pastikan Apache Running**

**PENTING:** Apache harus running sebelum menjalankan ngrok!

1. **Buka XAMPP Control Panel**
   - Cari "XAMPP Control Panel" di Start Menu
   - Atau buka: `D:\Praktikum DWBI\xampp\xampp-control.exe`

2. **Start Apache**
   - Klik **Start** pada **Apache**
   - Pastikan status **Running (hijau)** ✅

---

### **LANGKAH 2: Jalankan Ngrok**

**Ada 2 cara:**

#### **Cara A: Pakai Script (Paling Mudah) ✅**

```
Double-click: SETUP_NGROK_LENGKAP.bat
```

Script akan:
- Cek ngrok.exe ✅
- Cek authtoken ✅
- Cek Apache ✅
- Jalankan ngrok otomatis ✅

#### **Cara B: Manual di Terminal**

1. **Buka PowerShell atau Command Prompt**
   - Tekan `Windows + R`
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
   Atau jika ngrok.exe ada di folder:
   ```bash
   .\ngrok.exe\ngrok.exe http 80
   ```

4. **Tekan Enter**

---

### **LANGKAH 3: Lihat Output Ngrok**

**Setelah ngrok running, akan muncul output seperti:**

```
ngrok

Session Status                online
Account                       Your Account
Version                       3.x.x
Region                        [Region]
Latency                       [Latency]
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://dorothy-fuzziest-goggly.ngrok-free.dev -> http://localhost:80

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

**Yang penting adalah baris "Forwarding":**
```
Forwarding    https://dorothy-fuzziest-goggly.ngrok-free.dev -> http://localhost:80
```

**URL ngrok Anda:** `https://dorothy-fuzziest-goggly.ngrok-free.dev`
- ⚠️ **PENTING:** URL ini akan berbeda setiap kali restart ngrok!
- ⚠️ **PENTING:** Copy URL yang BENAR-BENAR muncul di jendela ngrok Anda!

---

### **LANGKAH 4: Copy URL dari Baris "Forwarding"**

**Cara copy:**

1. **Lihat jendela ngrok** (bukan script!)
2. **Cari baris "Forwarding"**
3. **Select/highlight URL** (bagian kiri, sebelum `->`)
   - Contoh: `https://dorothy-fuzziest-goggly.ngrok-free.dev`
4. **Copy:**
   - Tekan `Ctrl + C`
   - Atau klik kanan → Copy

**⚠️ PENTING:**
- Copy **hanya bagian kiri** (sebelum `->`)
- Jangan copy `http://localhost:80`
- Copy URL yang BENAR-BENAR muncul di jendela ngrok Anda!

---

### **LANGKAH 5: Tambahkan `/nurani/public/` di Akhir**

**URL yang sudah di-copy:**
```
https://dorothy-fuzziest-goggly.ngrok-free.dev
```

**Tambahkan `/nurani/public/` di akhir:**
```
https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/
```

**Cara:**
1. Paste URL yang sudah di-copy: `https://dorothy-fuzziest-goggly.ngrok-free.dev`
2. Tambahkan `/nurani/public/` di akhir
3. Hasil akhir: `https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/`

---

### **LANGKAH 6: Test di Browser**

**Buka browser:**
1. Ketik atau paste URL lengkap di address bar:
   ```
   https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/
   ```
   (Ganti `dorothy-fuzziest-goggly.ngrok-free.dev` dengan URL ngrok Anda yang benar!)

2. Tekan Enter

3. **Hasil:**
   - ✅ Website muncul (halaman login atau dashboard) → **Berhasil!** ✅
   - ❌ Error `ERR_NGROK_3200` → ngrok mati atau URL salah
   - ❌ Halaman "Visit Site" → klik "Visit Site" atau "Continue"

---

## 📋 **CONTOH LENGKAP**

### **Dari Jendela Ngrok:**

```
Forwarding    https://dorothy-fuzziest-goggly.ngrok-free.dev -> http://localhost:80
```

### **URL yang Di-copy:**

```
https://dorothy-fuzziest-goggly.ngrok-free.dev
```

### **URL Lengkap untuk Akses:**

```
https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/
```

---

## ⚠️ **CATATAN PENTING**

### **1. URL Ngrok Berubah Setiap Restart**

**⚠️ PENTING:**
- URL ngrok **berubah setiap kali restart** ngrok
- Contoh:
  - URL pertama: `https://dorothy-fuzziest-goggly.ngrok-free.dev`
  - Setelah restart: `https://abc-def-123.ngrok-free.app` (berbeda!)

**Solusi:**
- ✅ **Jangan tutup jendela ngrok** (biarkan running)
- ✅ Jika ngrok di-restart, **dapat URL baru** dari baris "Forwarding"
- ✅ **Update URL** di device lain jika sudah di-share

---

### **2. Jangan Tutup Jendela Ngrok**

**⚠️ PENTING:**
- Jendela ngrok **harus tetap terbuka**
- Jika ditutup, tunnel akan mati
- URL tidak bisa diakses
- Error `ERR_NGROK_3200` akan muncul

**Solusi:**
- ✅ **Minimize jendela** (jangan tutup)
- ✅ Atau jalankan ngrok di background (jika perlu)

---

### **3. Pastikan Apache Running**

**⚠️ PENTING:**
- Apache (XAMPP) **harus berjalan** di komputer host
- Jika Apache mati, ngrok akan error
- Pastikan Apache **hijau** di XAMPP Control Panel

**Cara cek:**
1. Buka XAMPP Control Panel
2. Pastikan Apache **hijau** (running)
3. Jika merah, klik **Start**

---

### **4. Halaman "Visit Site" dari Ngrok**

**Jika muncul halaman "Visit Site":**
- Ini normal untuk akun Ngrok Free
- Klik tombol **"Visit Site"** atau **"Continue"**
- Website akan muncul setelah itu

**Cara skip (opsional):**
- Upgrade ke akun Ngrok berbayar
- Atau tetap klik "Visit Site" setiap kali

---

## 🎯 **RINGKASAN LANGKAH**

1. ✅ **Start Apache** di XAMPP (harus hijau)
2. ✅ **Jalankan ngrok:** `ngrok http 80` (atau pakai `SETUP_NGROK_LENGKAP.bat`)
3. ✅ **Lihat jendela ngrok**, cari baris **"Forwarding"**
4. ✅ **Copy URL** dari baris "Forwarding" (bagian kiri, sebelum `->`)
5. ✅ **Tambahkan `/nurani/public/`** di akhir URL
6. ✅ **Test di browser:** `https://URL_NGROK_ANDA/nurani/public/`

---

## 🚀 **CARA CEPAT (Rekomendasi)**

### **Langkah 1: Jalankan Script**
```
Double-click: SETUP_NGROK_LENGKAP.bat
```

### **Langkah 2: Lihat Jendela Ngrok**
- Akan muncul jendela ngrok baru
- Cari baris **"Forwarding"**

### **Langkah 3: Copy URL**
- Copy URL dari baris "Forwarding"
- Contoh: `https://dorothy-fuzziest-goggly.ngrok-free.dev`

### **Langkah 4: Tambahkan Path**
- Tambahkan `/nurani/public/` di akhir
- Hasil: `https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/`

### **Langkah 5: Test**
- Buka browser
- Ketik URL lengkap
- Tekan Enter
- Website muncul! ✅

---

## 📱 **CARA SHARE KE DEVICE LAIN**

**Setelah dapat URL lengkap:**

1. **Copy URL lengkap:**
   ```
   https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/
   ```

2. **Kirim ke device lain:**
   - WhatsApp
   - Email
   - Chat
   - Atau cara lain

3. **Device lain buka di browser:**
   - Buka browser
   - Paste URL
   - Tekan Enter
   - Website muncul! ✅

---

## 🔍 **TROUBLESHOOTING**

### **Error: Ngrok Tidak Bisa Dijalankan**

**Solusi:**
1. Pastikan `ngrok.exe` ada di folder project
2. Atau jalankan: `SETUP_NGROK_LENGKAP.bat`
3. Cek authtoken sudah setup

---

### **Error: Authtoken Required**

**Solusi:**
1. Setup authtoken: `ngrok config add-authtoken YOUR_AUTHTOKEN`
2. Dapat authtoken dari: https://dashboard.ngrok.com
3. Atau pakai script: `SETUP_NGROK_LENGKAP.bat`

---

### **Error: ERR_NGROK_3200**

**Penyebab:** Ngrok offline atau URL salah

**Solusi:**
1. Cek ngrok masih running? (jendela masih terbuka)
2. Pastikan menggunakan URL yang benar dari baris "Forwarding"
3. Restart ngrok jika perlu

---

### **URL Tidak Bisa Diakses**

**Cek:**
1. ✅ Ngrok masih running? (jendela masih terbuka)
2. ✅ Apache masih running? (hijau di XAMPP)
3. ✅ URL sudah benar? (bukan contoh, copy dari jendela ngrok)
4. ✅ Path sudah benar? (`/nurani/public/`)

---

## ✅ **KESIMPULAN**

**Cara mendapatkan URL:**
```
https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/
```

**Langkah:**
1. ✅ Start Apache
2. ✅ Jalankan ngrok (`ngrok http 80`)
3. ✅ Copy URL dari baris "Forwarding"
4. ✅ Tambahkan `/nurani/public/` di akhir
5. ✅ Test di browser

**PENTING:**
- ✅ URL ngrok berubah setiap restart
- ✅ Jangan tutup jendela ngrok
- ✅ Pastikan Apache tetap running
- ✅ Gunakan URL yang benar (bukan contoh)

---

**Intinya: Jalankan ngrok, copy URL dari "Forwarding", tambahkan `/nurani/public/`, selesai!** 🎯

