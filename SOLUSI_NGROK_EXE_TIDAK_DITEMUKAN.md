# 🔧 Solusi: ngrok.exe Tidak Ditemukan

## ❌ ERROR YANG ANDA ALAMI

**Error:** `The term '.\ngrok.exe' is not recognized as the name of a cmdlet, function, script file, or operable program.`

**Ini berarti:**
- ❌ `ngrok.exe` tidak ditemukan di folder saat ini
- ❌ Bukan masalah dengan token!
- ❌ Masalah dengan lokasi file `ngrok.exe`

---

## ✅ SOLUSI

**Ada beberapa cara untuk memperbaiki:**

1. **Cara 1: Cek Apakah ngrok.exe Ada di Folder** (Cek dulu!)
2. **Cara 2: Gunakan ngrok Tanpa .exe** (Jika ngrok di PATH)
3. **Cara 3: Gunakan Path Lengkap** (Jika ngrok ada di tempat lain)

---

## 🔍 CARA 1: CEK APAKAH NGROK.EXE ADA DI FOLDER

### Langkah 1: Cek File di Folder

**Di PowerShell, ketik:**
```powershell
dir ngrok.exe
```

**Atau:**
```powershell
ls ngrok.exe
```

**Tekan Enter**

**Jika muncul file `ngrok.exe` → file ada ✅**
**Jika error "cannot find" → file tidak ada ❌**

---

### Langkah 2: Jika File Tidak Ada

**Cara download ngrok.exe:**
1. Buka browser, kunjungi: `https://ngrok.com/download`
2. Download untuk Windows
3. Extract `ngrok.exe`
4. Copy `ngrok.exe` ke folder: `D:\Praktikum DWBI\xampp\htdocs\nurani`

---

## 🔧 CARA 2: GUNAKAN NGROK TANPA .EXE

### Jika Ngrok di PATH

**Coba tanpa `.\` dan tanpa `.exe`:**

```powershell
ngrok config add-authtoken YOUR_AUTHTOKEN
```

**Ganti `YOUR_AUTHTOKEN` dengan authtoken Anda!**

**Contoh:**
```powershell
ngrok config add-authtoken 36F0bAqVSSogatRt93a8T8AUUP5_kRGuqDiJqiYR8esm71aH
```

**Tekan Enter**

---

## 📁 CARA 3: GUNAKAN PATH LENGKAP

### Jika Ngrok Ada di Tempat Lain

**Cari lokasi ngrok.exe:**
```powershell
where ngrok
```

**Atau:**
```powershell
where.exe ngrok.exe
```

**Tekan Enter**

**Jika ditemukan, akan muncul path seperti:**
```
C:\Users\[USERNAME]\AppData\Local\Microsoft\WindowsApps\ngrok.exe
```

**Gunakan path lengkap:**
```powershell
"C:\Users\[USERNAME]\AppData\Local\Microsoft\WindowsApps\ngrok.exe" config add-authtoken YOUR_AUTHTOKEN
```

**Ganti `[USERNAME]` dengan username Anda!**

---

## 🎯 CARA 4: PAKAI SCRIPT OTOMATIS (PALING MUDAH!)

**Double-click:** `GANTI_ACCOUNT_NGROK.bat`

**Script akan:**
- Cek apakah `ngrok.exe` ada
- Jika tidak ada, akan memberikan instruksi
- Jika ada, akan setup authtoken otomatis

---

## 📋 LANGKAH CEPAT (REKOMENDASI)

### Langkah 1: Cek Apakah ngrok.exe Ada

**Di PowerShell:**
```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
dir ngrok.exe
```

**Jika file ada → lanjut ke Langkah 2**
**Jika file tidak ada → download ngrok.exe dulu**

---

### Langkah 2: Coba Tanpa .exe

**Jika ngrok di PATH, coba:**
```powershell
ngrok config add-authtoken 36F0bAqVSSogatRt93a8T8AUUP5_kRGuqDiJqiYR8esm71aH
```

**Tekan Enter**

---

### Langkah 3: Jika Masih Error, Cari Lokasi Ngrok

**Cari lokasi ngrok:**
```powershell
where ngrok
```

**Gunakan path lengkap yang muncul!**

---

## ⚠️ TROUBLESHOOTING

### Problem 1: File ngrok.exe Tidak Ada

**Solusi:**
- Download ngrok.exe dari: `https://ngrok.com/download`
- Extract dan copy ke folder project
- Atau jalankan: `SETUP_NGROK_LENGKAP.bat`

---

### Problem 2: Ngrok Tidak di PATH

**Solusi:**
- Gunakan path lengkap
- Atau copy ngrok.exe ke folder project
- Atau tambahkan ngrok ke PATH

---

### Problem 3: Permission Error

**Error:** "Access denied"

**Solusi:**
- Jalankan PowerShell sebagai Administrator
- Atau gunakan Command Prompt sebagai Administrator

---

## ✅ RINGKASAN

**Error:** `.\ngrok.exe is not recognized`

**Penyebab:**
- ❌ `ngrok.exe` tidak ditemukan di folder saat ini
- ❌ Bukan masalah dengan token!

**Solusi:**
1. ✅ **Cek apakah ngrok.exe ada:** `dir ngrok.exe`
2. ✅ **Coba tanpa .exe:** `ngrok config add-authtoken YOUR_AUTHTOKEN`
3. ✅ **Cari lokasi ngrok:** `where ngrok`
4. ✅ **Gunakan path lengkap** jika ditemukan
5. ✅ **Pakai script otomatis:** `GANTI_ACCOUNT_NGROK.bat`

**Langkah:**
1. Cek: `dir ngrok.exe` di folder project
2. Jika tidak ada → download/copy ngrok.exe
3. Coba: `ngrok config add-authtoken YOUR_AUTHTOKEN` (tanpa .\ dan .exe)
4. Jika masih error → cari: `where ngrok` dan gunakan path lengkap

**Selesai!** ✅

---

**Intinya: Error bukan karena token, tapi karena ngrok.exe tidak ditemukan! Cek apakah file ngrok.exe ada di folder, atau gunakan `ngrok` tanpa `.\` dan `.exe`!** 🎯

