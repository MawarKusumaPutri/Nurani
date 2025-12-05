# 🚀 Cara Run Ngrok Seperti Sebelumnya

## ❌ **MASALAH ANDA**

**Dari screenshot:**
1. ✅ Authtoken sudah di-setup: `ngrok config add-authtoken 36059Qt06leILq7ZZuD7wWXFWey_6vFqWiQrdnE4n2AKDaZcK`
2. ❌ Tapi kemudian di-reset: `ngrok config reset` → **Authtoken dihapus!**

**Akibatnya:**
- Authtoken sudah tidak ada lagi
- Perlu setup authtoken lagi
- Lalu jalankan tunnel

---

## ✅ **LANGKAH-LANGKAH (3 LANGKAH)**

### **LANGKAH 1: Setup Authtoken Lagi**

**Karena authtoken sudah di-reset, perlu setup lagi:**

**Di PowerShell:**

1. **Masuk ke folder project:**
   ```bash
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```

2. **Setup authtoken:**
   ```bash
   ngrok config add-authtoken 36059Qt06leILq7ZZuD7wWXFWey_6vFqWiQrdnE4n2AKDaZcK
   ```
   (Gunakan authtoken yang sama atau authtoken baru dari dashboard.ngrok.com)

3. **Tekan Enter**

4. **Hasil yang diharapkan:**
   ```
   Authtoken saved to configuration file: C:\Users\asus\AppData\Local/ngrok/ngrok.yml
   ```

**⚠️ PENTING:**
- Jangan jalankan `ngrok config reset` lagi!
- Reset akan menghapus authtoken yang baru saja di-setup

---

### **LANGKAH 2: Start Apache**

**PENTING:** Apache harus running sebelum menjalankan ngrok!

1. **Buka XAMPP Control Panel**
   - Cari "XAMPP Control Panel" di Start Menu
   - Atau buka: `D:\Praktikum DWBI\xampp\xampp-control.exe`

2. **Start Apache**
   - Klik **Start** pada **Apache**
   - Pastikan status **Running (hijau)** ✅

---

### **LANGKAH 3: Jalankan Ngrok Tunnel**

**Setelah authtoken setup dan Apache running, jalankan tunnel:**

**Di PowerShell (yang sama atau buka baru):**

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

4. **Akan muncul output seperti:**
   ```
   ngrok
   
   Session Status                online
   Account                       Your Account
   Version                       3.x.x
   Region                        [Region]
   Latency                       [Latency]
   Web Interface                 http://127.0.0.1:4040
   Forwarding                    https://abc-def-123.ngrok-free.dev -> http://localhost:80
   ```

5. **Copy URL dari baris "Forwarding":**
   - Contoh: `https://abc-def-123.ngrok-free.dev`
   - Tambahkan `/nurani/public/` di akhir:
     ```
     https://abc-def-123.ngrok-free.dev/nurani/public/
     ```

---

## 🎯 **RINGKASAN LANGKAH**

1. ✅ **Setup authtoken lagi:** `ngrok config add-authtoken YOUR_AUTHTOKEN`
   - ⚠️ Jangan reset lagi!
   
2. ✅ **Start Apache** di XAMPP (harus hijau)

3. ✅ **Jalankan ngrok:** `ngrok http 80`

4. ✅ **Lihat baris "Forwarding"** → Copy URL

5. ✅ **Tambahkan `/nurani/public/`** di akhir

6. ✅ **Test di browser**

---

## ⚠️ **CATATAN PENTING**

### **1. Jangan Reset Authtoken Lagi!**

**⚠️ PENTING:**
- `ngrok config reset` akan **menghapus authtoken**
- Setelah reset, **harus setup authtoken lagi**
- **Jangan jalankan reset** jika authtoken sudah benar!

**Kapan perlu reset?**
- Hanya jika ingin **ganti account ngrok**
- Atau jika ada masalah dengan authtoken

**Jika authtoken sudah benar:**
- ✅ Langsung jalankan: `ngrok http 80`
- ❌ Jangan reset!

---

### **2. Authtoken Hanya Setup Sekali**

**Setelah authtoken di-setup:**
- ✅ Authtoken tersimpan di: `C:\Users\asus\AppData\Local/ngrok/ngrok.yml`
- ✅ Tidak perlu setup lagi setiap kali run ngrok
- ✅ Langsung jalankan: `ngrok http 80`

**Kecuali:**
- ❌ Jika di-reset → perlu setup lagi
- ❌ Jika ganti account → perlu setup authtoken baru

---

### **3. URL Hanya Muncul Setelah Tunnel Running**

**⚠️ PENTING:**
- Setup authtoken saja **tidak akan muncul URL**
- Harus jalankan `ngrok http 80` dulu
- URL muncul di baris "Forwarding"

**Perbedaan:**
- **Setup authtoken:** Tidak ada URL (normal!)
- **Jalankan tunnel:** Ada URL di "Forwarding"

---

## 🚀 **CARA CEPAT (Setelah Setup Authtoken)**

### **Setelah authtoken sudah di-setup:**

1. **Start Apache** (jika belum running)

2. **Jalankan ngrok:**
   ```bash
   ngrok http 80
   ```

3. **Lihat baris "Forwarding"** → Copy URL

4. **Tambahkan `/nurani/public/`** → Test di browser

**Selesai!** ✅

---

## 🔍 **TROUBLESHOOTING**

### **Error: "authtoken is required"**

**Penyebab:** Authtoken belum di-setup atau sudah di-reset

**Solusi:**
1. Setup authtoken: `ngrok config add-authtoken YOUR_AUTHTOKEN`
2. Dapat authtoken dari: https://dashboard.ngrok.com
3. Jangan reset lagi!

---

### **Error: "bind: address already in use"**

**Penyebab:** Port 80 sudah digunakan

**Solusi:**
1. Cek Apache running di XAMPP (harus hijau)
2. Jika tidak running → Start Apache
3. Jika masih error → Restart XAMPP

---

### **Tidak Ada URL di "Forwarding"**

**Penyebab:** Belum menjalankan tunnel

**Solusi:**
1. Pastikan sudah jalankan: `ngrok http 80`
2. Bukan hanya setup authtoken
3. URL hanya muncul setelah tunnel running

---

## ✅ **KESIMPULAN**

**Masalah:** "Cara gmn kyk sebelumnya bisa di run tuhh"

**Penyebab:**
- Authtoken sudah di-reset → perlu setup lagi

**Solusi:**
1. ✅ **Setup authtoken lagi:** `ngrok config add-authtoken YOUR_AUTHTOKEN`
   - ⚠️ Jangan reset lagi!
2. ✅ **Start Apache** (harus hijau)
3. ✅ **Jalankan ngrok:** `ngrok http 80`
4. ✅ **Lihat baris "Forwarding"** → Copy URL
5. ✅ **Tambahkan `/nurani/public/`** → Test

**PENTING:**
- ✅ Setup authtoken hanya sekali (kecuali di-reset)
- ✅ Setelah setup, langsung jalankan: `ngrok http 80`
- ❌ Jangan reset authtoken jika sudah benar!

---

**Intinya: Setup authtoken lagi (jangan reset!), lalu jalankan `ngrok http 80`!** 🎯

