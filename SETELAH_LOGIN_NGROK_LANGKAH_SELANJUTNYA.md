# 📋 Setelah Login Ngrok - Langkah Selanjutnya

## 🎯 SETELAH LOGIN, LANGKAH YANG HARUS DILAKUKAN

Setelah login ke ngrok, ada beberapa langkah yang perlu dilakukan:

1. ✅ **Simpan Recovery Codes** (opsional, tapi disarankan)
2. ✅ **Cari Authtoken** (PENTING!)
3. ✅ **Download ngrok.exe**
4. ✅ **Setup Authtoken**
5. ✅ **Jalankan ngrok**

---

## 📝 LANGKAH 1: Simpan Recovery Codes (Opsional)

**Yang Anda lihat sekarang:**
- Halaman "Recovery codes" dengan 10 kode
- Checkbox "I've saved my recovery codes"
- Tombol "Copy to clipboard" dan "Download"
- Tombol "Finish"

**Apa yang harus dilakukan:**
1. **Klik "Copy to clipboard"** atau **"Download"** untuk simpan recovery codes
2. **Simpan di tempat aman** (notes, password manager, dll)
3. **Centang checkbox** "I've saved my recovery codes"
4. **Klik "Finish"** untuk lanjut

**⚠️ Catatan:**
- Recovery codes ini untuk recovery akun jika kehilangan akses MFA
- Bisa skip jika tidak pakai MFA, tapi disarankan simpan

---

## 🔑 LANGKAH 2: Cari Authtoken (PENTING!)

**Setelah klik "Finish", Anda akan masuk ke dashboard ngrok.**

**Cara dapat authtoken:**

### Cara 1: Dari Dashboard (Paling Mudah)
1. Di dashboard ngrok, cari menu **"Your Authtoken"** atau **"Get Started"**
2. Atau klik **"Setup"** → **"Your Authtoken"**
3. **Copy authtoken** Anda (terlihat seperti: `2abc123def456...`)

### Cara 2: Dari Menu
1. Klik menu **"Setup"** atau **"Configuration"**
2. Pilih **"Your Authtoken"**
3. **Copy authtoken** Anda

**Authtoken terlihat seperti:**
```
2abc123def456ghi789jkl012mno345pqr678stu901vwx234yz
```

**⚠️ PENTING:** Simpan authtoken ini! Akan dipakai untuk setup ngrok.

---

## 📥 LANGKAH 3: Download ngrok.exe

**Setelah dapat authtoken, download ngrok:**

### Cara 1: Dari Dashboard
1. Di dashboard ngrok, klik **"Download"** (biasanya di menu atas)
2. Pilih **"Windows"**
3. Download file `ngrok.zip`
4. Extract file `ngrok.exe`
5. **Simpan** `ngrok.exe` di folder project:
   ```
   D:\Praktikum DWBI\xampp\htdocs\nurani\ngrok.exe
   ```

### Cara 2: Dari Menu
1. Klik menu **"Download"** atau **"Get Started"**
2. Pilih **"Windows"**
3. Download `ngrok.zip`
4. Extract `ngrok.exe`
5. **Simpan** di folder project

**⚠️ Catatan:**
- Pastikan simpan di folder project yang benar
- File `ngrok.exe` harus ada di folder: `D:\Praktikum DWBI\xampp\htdocs\nurani\`

---

## ⚙️ LANGKAH 4: Setup Authtoken

**Setelah download ngrok.exe, setup authtoken:**

### Cara 1: Pakai Script (Paling Mudah)
1. **Double-click:** `SETUP_NGROK_LENGKAP.bat`
2. Script akan:
   - Cek ngrok.exe sudah ada
   - Minta authtoken
   - Setup authtoken otomatis
3. **Paste authtoken** dari langkah 2
4. Tekan Enter
5. **Selesai!** Authtoken tersimpan

### Cara 2: Manual (Command Prompt)
1. Buka Command Prompt
2. Navigate ke folder project:
   ```cmd
   cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
   ```
3. Setup authtoken:
   ```cmd
   ngrok config add-authtoken [AUTHTOKEN_ANDA]
   ```
   (Ganti `[AUTHTOKEN_ANDA]` dengan authtoken dari langkah 2)
4. Tekan Enter
5. **Selesai!** Authtoken tersimpan

---

## 🚀 LANGKAH 5: Jalankan Ngrok

**Setelah setup authtoken, jalankan ngrok:**

### Cara 1: Pakai Script (Paling Mudah)
1. **Pastikan Apache Running** di XAMPP (hijau)
2. **Double-click:** `SETUP_NGROK_LENGKAP.bat`
3. Script akan:
   - Cek ngrok.exe
   - Cek authtoken sudah setup
   - Cek Apache running
   - Jalankan ngrok otomatis
4. **Catat URL** yang muncul (contoh: `https://abc123.ngrok.io`)
5. **Selesai!**

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
5. **Catat URL** yang muncul
6. **Selesai!**

---

## 📋 RINGKASAN URUTAN

```
1. Login ngrok ✅ (sudah dilakukan)
   ↓
2. Simpan recovery codes (opsional)
   ↓
3. Cari authtoken di dashboard
   ↓
4. Download ngrok.exe
   ↓
5. Simpan ngrok.exe di folder project
   ↓
6. Setup authtoken (pakai script atau manual)
   ↓
7. Jalankan ngrok (pakai script atau manual)
   ↓
8. Dapat URL publik
   ↓
9. Share URL ke device lain
   ↓
10. Device lain akses via internet ✅
```

---

## 🎯 JAWABAN UNTUK PERTANYAAN ANDA

**Pertanyaan:**
> "Setelah saya login itu berarti saya download atau bagaimana??"

**Jawaban:**
1. ✅ **Setelah login** → klik "Finish" (jika di halaman recovery codes)
2. ✅ **Cari authtoken** di dashboard (PENTING!)
3. ✅ **Download ngrok.exe** dari dashboard
4. ✅ **Simpan ngrok.exe** di folder project
5. ✅ **Setup authtoken** (pakai script atau manual)
6. ✅ **Jalankan ngrok** (pakai script atau manual)

**Urutan:**
- Login → Cari Authtoken → Download → Setup → Jalankan

---

## 💡 TIPS

### 1. Simpan Authtoken
- Copy authtoken ke notes/phone
- Akan berguna jika perlu setup ulang
- Authtoken tidak berubah (kecuali reset)

### 2. Simpan Recovery Codes
- Simpan recovery codes di tempat aman
- Akan berguna jika kehilangan akses MFA

### 3. Pakai Script
- Script `SETUP_NGROK_LENGKAP.bat` akan memandu semua langkah
- Lebih mudah daripada manual

---

## ✅ LANGKAH SELANJUTNYA (Sekarang)

**Yang harus dilakukan sekarang:**

1. **Klik "Finish"** di halaman recovery codes (jika masih di sana)
2. **Cari authtoken** di dashboard ngrok
3. **Download ngrok.exe** dari dashboard
4. **Simpan ngrok.exe** di folder project
5. **Double-click:** `SETUP_NGROK_LENGKAP.bat`
6. **Paste authtoken** saat diminta
7. **Selesai!**

---

**Intinya: Setelah login → Cari Authtoken → Download → Setup → Jalankan!** 🎯

