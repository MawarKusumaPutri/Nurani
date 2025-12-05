# 🎯 Cara Mendapatkan URL dari Baris "Forwarding"

## 📋 **PENJELASAN**

**Foto 1:** Setup authtoken (belum ada URL)  
**Foto 2:** Ngrok sudah running (ada URL di baris "Forwarding")

**Perbedaan:**
- **Foto 1:** Hanya setup authtoken, belum menjalankan tunnel
- **Foto 2:** Sudah menjalankan tunnel, ada URL di baris "Forwarding"

---

## ✅ **LANGKAH-LANGKAH MENDAPATKAN URL**

### **LANGKAH 1: Setup Authtoken (Foto 1) ✅**

**Anda sudah melakukan ini:**
```bash
ngrok config add-authtoken 36HHZEp6RGSqOrCHGxD1BWnlvBX_6nvf59rtQPEp78R9Noo2w
```

**Hasil:** `Authtoken saved to configuration file` ✅

**Ini sudah benar!** Tapi ini hanya setup authtoken, belum menjalankan tunnel.

---

### **LANGKAH 2: Pastikan Apache Running**

**PENTING:** Apache harus running sebelum menjalankan ngrok!

1. **Buka XAMPP Control Panel**
   - Cari "XAMPP Control Panel" di Start Menu
   - Atau buka: `D:\Praktikum DWBI\xampp\xampp-control.exe`

2. **Start Apache**
   - Klik **Start** pada **Apache**
   - Pastikan status **Running (hijau)** ✅

---

### **LANGKAH 3: Jalankan Ngrok Tunnel**

**Setelah authtoken sudah setup (Foto 1), sekarang jalankan tunnel:**

**Di PowerShell yang sama (atau buka PowerShell baru):**

1. **Masuk ke folder project:**
   ```bash
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```

2. **Jalankan ngrok:**
   ```bash
   ngrok http 80
   ```
   Atau jika ngrok.exe ada di folder:
   ```bash
   .\ngrok.exe\ngrok.exe http 80
   ```

3. **Tekan Enter**

---

### **LANGKAH 4: Lihat Output Ngrok (Foto 2)**

**Setelah menjalankan `ngrok http 80`, akan muncul output seperti di Foto 2:**

```
ngrok

Session Status                online
Account                       putrikusuma2910@gmail.com (Plan: Free)
Version                       3.18.4
Region                        United States (us)
Latency                       322ms
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://dorothy-fuzziest-goggly.ngrok-free.dev -> http://localhost:80
```

**Yang penting adalah baris "Forwarding":**
```
Forwarding    https://dorothy-fuzziest-goggly.ngrok-free.dev -> http://localhost:80
```

**URL ngrok Anda:** `https://dorothy-fuzziest-goggly.ngrok-free.dev`

---

### **LANGKAH 5: Copy URL dari Baris "Forwarding"**

**Cara copy:**

1. **Lihat di terminal ngrok** (seperti di Foto 2)
2. **Cari baris "Forwarding"**
3. **Select/highlight URL** (bagian kiri, sebelum `->`)
   - Contoh: `https://dorothy-fuzziest-goggly.ngrok-free.dev`
4. **Copy:**
   - Tekan `Ctrl + C`
   - Atau klik kanan → Copy

**⚠️ PENTING:**
- Copy **hanya bagian kiri** (sebelum `->`)
- Jangan copy `http://localhost:80`
- Copy URL yang BENAR-BENAR muncul di terminal Anda!

---

### **LANGKAH 6: Tambahkan `/nurani/public/` di Akhir**

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

### **LANGKAH 7: Test di Browser**

**Buka browser:**
1. Ketik atau paste URL lengkap di address bar:
   ```
   https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/
   ```
   (Ganti dengan URL ngrok Anda yang benar!)

2. Tekan Enter

3. **Hasil:**
   - ✅ Website muncul (halaman login atau dashboard) → **Berhasil!** ✅
   - ❌ Error `ERR_NGROK_3200` → ngrok mati atau URL salah
   - ❌ Halaman "Visit Site" → klik "Visit Site" atau "Continue"

---

## 📋 **PERBANDINGAN FOTO 1 DAN FOTO 2**

### **Foto 1: Setup Authtoken**
```
ngrok config add-authtoken 36HHZEp6RGSqOrCHGxD1BWnlvBX_6nvf59rtQPEp78R9Noo2w
Authtoken saved to configuration file: C:\Users\asus\AppData\Local/ngrok/ngrok.yml
```

**Status:**
- ✅ Authtoken sudah setup
- ❌ Belum ada URL (karena belum menjalankan tunnel)

---

### **Foto 2: Ngrok Running**
```
Forwarding    https://dorothy-fuzziest-goggly.ngrok-free.dev -> http://localhost:80
```

**Status:**
- ✅ Authtoken sudah setup
- ✅ Tunnel sudah running
- ✅ Ada URL di baris "Forwarding"

---

## 🎯 **RINGKASAN LANGKAH**

1. ✅ **Setup authtoken** (Foto 1) - **Sudah dilakukan!**
2. ✅ **Start Apache** di XAMPP (harus hijau)
3. ✅ **Jalankan ngrok:** `ngrok http 80`
4. ✅ **Lihat baris "Forwarding"** (Foto 2)
5. ✅ **Copy URL** dari baris "Forwarding"
6. ✅ **Tambahkan `/nurani/public/`** di akhir
7. ✅ **Test di browser**

---

## ⚠️ **CATATAN PENTING**

### **1. URL Hanya Muncul Setelah Tunnel Running**

**⚠️ PENTING:**
- URL **hanya muncul** setelah menjalankan `ngrok http 80`
- Setup authtoken saja **tidak akan muncul URL**
- Harus jalankan tunnel dulu!

**Perbedaan:**
- **Foto 1:** Hanya setup authtoken → **Tidak ada URL**
- **Foto 2:** Sudah jalankan tunnel → **Ada URL di "Forwarding"**

---

### **2. Jangan Tutup Terminal Ngrok**

**⚠️ PENTING:**
- Terminal ngrok **harus tetap terbuka**
- Jika ditutup, tunnel akan mati
- URL tidak bisa diakses
- Error `ERR_NGROK_3200` akan muncul

**Solusi:**
- ✅ **Minimize terminal** (jangan tutup)
- ✅ Atau jalankan ngrok di background

---

### **3. URL Berubah Setiap Restart**

**⚠️ PENTING:**
- URL ngrok **berubah setiap kali restart** ngrok
- Jika ngrok di-restart, URL baru akan muncul
- **Harus copy URL baru** dari baris "Forwarding"

---

## 🚀 **CARA CEPAT**

### **Setelah Setup Authtoken (Foto 1):**

1. **Start Apache** di XAMPP (harus hijau)

2. **Jalankan ngrok:**
   ```bash
   ngrok http 80
   ```

3. **Lihat baris "Forwarding"** (seperti di Foto 2)

4. **Copy URL** dari baris "Forwarding"

5. **Tambahkan `/nurani/public/`** di akhir

6. **Test di browser**

---

## ✅ **KESIMPULAN**

**Pertanyaan:** "Cara mendapatkan link https yang ada di foto 2 bagaimana ya soalnya saya coba di foto 1 itu ndak ada"

**Jawaban:**
- **Foto 1:** Hanya setup authtoken, belum ada URL (normal!)
- **Foto 2:** Sudah jalankan tunnel, ada URL di baris "Forwarding"

**Langkah:**
1. ✅ Setup authtoken (Foto 1) - **Sudah dilakukan!**
2. ✅ Start Apache
3. ✅ Jalankan `ngrok http 80`
4. ✅ Lihat baris "Forwarding" (Foto 2)
5. ✅ Copy URL dari baris "Forwarding"
6. ✅ Tambahkan `/nurani/public/` di akhir

**PENTING:**
- URL **hanya muncul** setelah menjalankan tunnel
- Setup authtoken saja **tidak akan muncul URL**
- Harus jalankan `ngrok http 80` dulu!

---

**Intinya: Setelah setup authtoken (Foto 1), jalankan `ngrok http 80` untuk mendapatkan URL (Foto 2)!** 🎯

