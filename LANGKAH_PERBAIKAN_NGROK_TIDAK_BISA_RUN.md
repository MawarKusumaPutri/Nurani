# 🔧 Langkah-Langkah Perbaikan: Ngrok Tidak Bisa Run

## ❌ **MASALAH ANDA**

**"Sebelumnya bisa di run kok sekarang tidak bisa di run"**

**Kemungkinan penyebab:**
1. ❌ Ngrok sudah mati/tertutup
2. ❌ Apache tidak running
3. ❌ Authtoken error
4. ❌ Port 80 sudah digunakan
5. ❌ Ngrok.exe tidak ditemukan

---

## ✅ **LANGKAH-LANGKAH PERBAIKAN**

### **LANGKAH 1: Cek Apakah Ngrok Masih Running**

**Cara cek:**

**Opsi A: Cek di Task Manager**
1. Tekan `Ctrl + Shift + Esc` (buka Task Manager)
2. Cari "ngrok.exe" di daftar proses
3. Jika **tidak ada** → ngrok sudah mati (lanjut ke Langkah 2)
4. Jika **ada** → ngrok masih running (coba restart di Langkah 2)

**Opsi B: Cek di Taskbar**
1. Lihat di taskbar Windows
2. Cari jendela "Ngrok Tunnel - JANGAN TUTUP!"
3. Jika **tidak ada** → ngrok sudah mati (lanjut ke Langkah 2)
4. Jika **ada** tapi error → restart ngrok (Langkah 2)

---

### **LANGKAH 2: Hentikan Ngrok yang Lama (Jika Masih Running)**

**Jika ngrok masih running tapi error:**

**Cara 1: Pakai Task Manager**
1. Tekan `Ctrl + Shift + Esc`
2. Cari "ngrok.exe"
3. Klik kanan → "End task"

**Cara 2: Pakai Terminal**
1. Buka PowerShell atau Command Prompt
2. Ketik:
   ```bash
   taskkill /F /IM ngrok.exe
   ```
3. Tekan Enter

**Cara 3: Pakai Script**
```
Double-click: CEK_DAN_RESTART_NGROK.bat
```
Script akan otomatis hentikan ngrok yang lama.

---

### **LANGKAH 3: Cek Apache Running**

**PENTING:** Apache harus running sebelum menjalankan ngrok!

**Cara cek:**
1. Buka **XAMPP Control Panel**
   - Cari "XAMPP Control Panel" di Start Menu
   - Atau buka: `D:\Praktikum DWBI\xampp\xampp-control.exe`

2. **Cek status Apache:**
   - ✅ **Hijau (Running)** → Apache sudah running (lanjut ke Langkah 4)
   - ❌ **Merah (Stopped)** → Apache tidak running (Start dulu!)

**Jika Apache tidak running:**
1. Klik **Start** pada Apache
2. Tunggu sampai status **Running (hijau)**
3. Lanjut ke Langkah 4

---

### **LANGKAH 4: Cek Ngrok.exe Ada**

**Cara cek:**
1. Buka folder: `D:\Praktikum DWBI\xampp\htdocs\nurani`
2. Cari file `ngrok.exe` atau folder `ngrok.exe\`
3. Jika **tidak ada** → perlu download ngrok dulu (lihat di bawah)
4. Jika **ada** → lanjut ke Langkah 5

**Jika ngrok.exe tidak ada:**

**Cara download:**
1. Buka browser, kunjungi: https://ngrok.com
2. Klik "Sign up" (gratis) atau "Login"
3. Login ke dashboard
4. Klik "Download" → Pilih "Windows"
5. Download `ngrok.zip`
6. Extract `ngrok.exe`
7. Simpan di folder: `D:\Praktikum DWBI\xampp\htdocs\nurani\`
8. Atau simpan di folder: `D:\Praktikum DWBI\xampp\htdocs\nurani\ngrok.exe\`

---

### **LANGKAH 5: Cek Authtoken**

**Cara cek:**

**Opsi A: Pakai Script (Paling Mudah)**
```
Double-click: SETUP_NGROK_LENGKAP.bat
```
Script akan otomatis cek authtoken dan minta setup jika belum ada.

**Opsi B: Manual di Terminal**
1. Buka PowerShell
2. Masuk ke folder:
   ```bash
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```
3. Cek authtoken:
   ```bash
   ngrok config check
   ```
   Atau:
   ```bash
   .\ngrok.exe\ngrok.exe config check
   ```

**Jika muncul error "authtoken is required":**

**Setup authtoken:**
1. Buka browser, login ke: https://dashboard.ngrok.com
2. Klik "Your Authtoken" atau "Get Started"
3. Copy authtoken Anda
4. Di terminal, ketik:
   ```bash
   ngrok config add-authtoken YOUR_AUTHTOKEN
   ```
   Atau:
   ```bash
   .\ngrok.exe\ngrok.exe config add-authtoken YOUR_AUTHTOKEN
   ```
5. Tekan Enter

---

### **LANGKAH 6: Jalankan Ngrok**

**Setelah semua cek selesai, jalankan ngrok:**

**Cara 1: Pakai Script (Paling Mudah) ✅**
```
Double-click: SETUP_NGROK_LENGKAP.bat
```
Script akan:
- Cek ngrok.exe ✅
- Cek authtoken ✅
- Cek Apache ✅
- Jalankan ngrok otomatis ✅

**Cara 2: Pakai Script Restart**
```
Double-click: CEK_DAN_RESTART_NGROK.bat
```
Script akan:
- Hentikan ngrok lama ✅
- Cek Apache ✅
- Jalankan ngrok baru ✅

**Cara 3: Manual di Terminal**
1. Buka PowerShell
2. Masuk ke folder:
   ```bash
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```
3. Jalankan ngrok:
   ```bash
   ngrok http 80
   ```
   Atau:
   ```bash
   .\ngrok.exe\ngrok.exe http 80
   ```
4. Tekan Enter

---

### **LANGKAH 7: Cek Output Ngrok**

**Setelah ngrok running, akan muncul output seperti:**

```
ngrok

Session Status                online
Account                       Your Account
Version                       3.x.x
Region                        [Region]
Latency                       [Latency]
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://abc-def-123.ngrok-free.dev -> http://localhost:80

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

**Yang penting:**
- ✅ **Session Status: online** → ngrok berhasil running!
- ✅ **Baris "Forwarding"** → ada URL ngrok
- ✅ **Copy URL** dari baris "Forwarding" (bagian kiri, sebelum `->`)

**Jika muncul error:**
- ❌ "authtoken is required" → kembali ke Langkah 5
- ❌ "bind: address already in use" → port 80 sudah digunakan (cek Apache)
- ❌ "ngrok: command not found" → ngrok.exe tidak ditemukan (kembali ke Langkah 4)

---

### **LANGKAH 8: Dapat URL Ngrok**

**Setelah ngrok running:**

1. **Lihat jendela ngrok** (bukan script!)
2. **Cari baris "Forwarding"**
3. **Copy URL** dari baris "Forwarding"
   - Contoh: `https://abc-def-123.ngrok-free.dev`
   - **PENTING:** Copy URL yang BENAR-BENAR muncul di jendela ngrok, bukan contoh!

4. **Tambahkan `/nurani/public` di akhir:**
   ```
   https://abc-def-123.ngrok-free.dev/nurani/public
   ```
   (Ganti `abc-def-123.ngrok-free.dev` dengan URL ngrok Anda yang benar!)

---

### **LANGKAH 9: Test di Browser**

**Buka browser:**
1. Ketik URL lengkap di address bar:
   ```
   https://URL_NGROK_ANDA/nurani/public
   ```
   (Ganti `URL_NGROK_ANDA` dengan URL yang Anda copy!)

2. Tekan Enter

3. **Hasil:**
   - ✅ Website muncul → **Berhasil!** ✅
   - ❌ Error `ERR_NGROK_3200` → ngrok mati atau URL salah (kembali ke Langkah 1)
   - ❌ Error lain → cek troubleshooting di bawah

---

## 🔍 **TROUBLESHOOTING**

### **Problem 1: Ngrok Tidak Bisa Dijalankan**

**Error:** "ngrok: command not found"

**Solusi:**
1. Pastikan `ngrok.exe` ada di folder project
2. Atau jalankan dengan path lengkap: `.\ngrok.exe\ngrok.exe http 80`
3. Atau pakai script: `SETUP_NGROK_LENGKAP.bat`

---

### **Problem 2: Authtoken Error**

**Error:** "authtoken is required" atau "invalid authtoken"

**Solusi:**
1. Setup authtoken: `ngrok config add-authtoken YOUR_AUTHTOKEN`
2. Dapat authtoken dari: https://dashboard.ngrok.com
3. Atau pakai script: `SETUP_NGROK_LENGKAP.bat`

---

### **Problem 3: Port 80 Sudah Digunakan**

**Error:** "bind: address already in use"

**Solusi:**
1. Cek Apache running di XAMPP (harus hijau)
2. Jika tidak running → Start Apache
3. Jika masih error → Restart XAMPP
4. Atau hentikan proses lain yang pakai port 80

---

### **Problem 4: URL Tidak Bisa Diakses**

**Error:** `ERR_NGROK_3200` atau "The endpoint is offline"

**Solusi:**
1. ✅ Cek ngrok masih running? (jendela masih terbuka)
2. ✅ Cek Apache masih running? (hijau di XAMPP)
3. ✅ URL sudah benar? (bukan contoh, copy dari jendela ngrok)
4. ✅ Path sudah benar? (`/nurani/public`)

---

### **Problem 5: Ngrok Running Tapi Website Tidak Muncul**

**Cek:**
1. ✅ Apache running? (hijau di XAMPP)
2. ✅ URL lengkap benar? (`https://URL_NGROK/nurani/public`)
3. ✅ Test di browser device yang sama dulu
4. ✅ Clear cache browser (Ctrl + Shift + Delete)

---

## 📋 **CHECKLIST PERBAIKAN**

### ✅ **Yang Harus Dicek:**
- [ ] Ngrok masih running? (jendela masih terbuka)
- [ ] Apache masih running? (hijau di XAMPP)
- [ ] ngrok.exe ada di folder project?
- [ ] Authtoken sudah setup?
- [ ] URL yang digunakan benar? (bukan contoh)

### 🔧 **Yang Harus Dilakukan:**
- [ ] Hentikan ngrok lama (jika masih running)
- [ ] Start Apache (jika tidak running)
- [ ] Setup authtoken (jika belum)
- [ ] Jalankan ngrok lagi
- [ ] Dapat URL baru dari jendela ngrok
- [ ] Test URL baru di browser

---

## 🚀 **LANGKAH CEPAT (Rekomendasi)**

**Jika ingin cepat, pakai script:**

1. **Double-click:** `CEK_DAN_RESTART_NGROK.bat`
   - Script akan otomatis:
     - Hentikan ngrok lama ✅
     - Cek Apache ✅
     - Jalankan ngrok baru ✅

2. **Lihat jendela ngrok** yang baru terbuka

3. **Copy URL** dari baris "Forwarding"

4. **Tambahkan `/nurani/public`**

5. **Test di browser**

**Selesai!** ✅

---

## ✅ **KESIMPULAN**

**Masalah:** "Sebelumnya bisa di run kok sekarang tidak bisa di run"

**Penyebab umum:**
1. Ngrok sudah mati/tertutup
2. Apache tidak running
3. Authtoken error

**Solusi cepat:**
1. ✅ Hentikan ngrok lama
2. ✅ Start Apache (jika tidak running)
3. ✅ Jalankan ngrok lagi (`CEK_DAN_RESTART_NGROK.bat`)
4. ✅ Dapat URL baru dari jendela ngrok
5. ✅ Test di browser

**PENTING:**
- ✅ Jangan tutup jendela ngrok!
- ✅ Pastikan Apache tetap running!
- ✅ Gunakan URL yang benar (bukan contoh)!

---

**Intinya: Hentikan ngrok lama, pastikan Apache running, lalu jalankan ngrok lagi!** 🎯

