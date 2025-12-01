# 🔄 Cara Ganti Account Ngrok

## ❓ PERTANYAAN ANDA

**"Klo ganti account bagaimana saya make akun?"**

---

## ✅ SOLUSI

**Ada 2 cara untuk ganti account ngrok:**

1. **Cara 1: Logout dan Login dengan Account Baru** (Rekomendasi!)
2. **Cara 2: Hapus Config dan Setup Ulang**

---

## 🔄 CARA 1: LOGOUT DAN LOGIN DENGAN ACCOUNT BARU

### Langkah 1: Hentikan Ngrok

**Jika ngrok sedang running:**
1. Di terminal, tekan `Ctrl + C` untuk stop ngrok
2. Atau di Task Manager, end task "ngrok.exe"

---

### Langkah 2: Logout dari Account Lama

**Buka terminal/PowerShell:**
1. Tekan `Windows + R`
2. Ketik: `powershell`
3. Tekan Enter

**Masuk ke folder project:**
```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
```

**Logout dari account lama:**
```powershell
.\ngrok.exe config reset
```

**Atau jika ngrok di PATH:**
```powershell
ngrok config reset
```

**Tekan Enter**

**Ini akan menghapus authtoken lama!**

---

### Langkah 3: Dapatkan Authtoken Baru

**Dari account ngrok yang baru:**

1. **Buka browser, login ke:** `https://dashboard.ngrok.com`
2. **Login dengan account baru** (atau daftar account baru)
3. **Klik "Your Authtoken"** atau "Get Started"
4. **Copy authtoken baru** (format: `2abc123def456...`)

---

### Langkah 4: Setup Authtoken Baru

**Di terminal, ketik:**
```powershell
.\ngrok.exe config add-authtoken YOUR_NEW_AUTHTOKEN
```

**Ganti `YOUR_NEW_AUTHTOKEN` dengan authtoken yang baru di-copy!**

**Contoh:**
```powershell
.\ngrok.exe config add-authtoken 2abc123def456ghi789jkl012mno345pqr678
```

**Tekan Enter**

**Jika berhasil, akan muncul:**
```
Authtoken saved to configuration file.
```

---

### Langkah 5: Verifikasi Account Baru

**Jalankan ngrok:**
```powershell
.\ngrok.exe http 80
```

**Tekan Enter**

**Di output akan terlihat account baru:**
```
Account                       your-new-email@gmail.com (Plan: Free)
```

**Jika account sudah benar, selesai!** ✅

---

## 🔄 CARA 2: HAPUS CONFIG DAN SETUP ULANG

### Langkah 1: Hentikan Ngrok

**Jika ngrok sedang running:**
1. Di terminal, tekan `Ctrl + C` untuk stop ngrok
2. Atau di Task Manager, end task "ngrok.exe"

---

### Langkah 2: Hapus File Config Ngrok

**File config ngrok ada di:**
```
C:\Users\[USERNAME]\AppData\Local\ngrok\ngrok.yml
```

**Atau:**
```
%LOCALAPPDATA%\ngrok\ngrok.yml
```

**Cara hapus:**
1. Tekan `Windows + R`
2. Ketik: `%LOCALAPPDATA%\ngrok`
3. Tekan Enter
4. Hapus file `ngrok.yml`

---

### Langkah 3: Dapatkan Authtoken Baru

**Dari account ngrok yang baru:**

1. **Buka browser, login ke:** `https://dashboard.ngrok.com`
2. **Login dengan account baru** (atau daftar account baru)
3. **Klik "Your Authtoken"** atau "Get Started"
4. **Copy authtoken baru**

---

### Langkah 4: Setup Authtoken Baru

**Di terminal, ketik:**
```powershell
.\ngrok.exe config add-authtoken YOUR_NEW_AUTHTOKEN
```

**Ganti `YOUR_NEW_AUTHTOKEN` dengan authtoken yang baru!**

**Tekan Enter**

---

### Langkah 5: Verifikasi Account Baru

**Jalankan ngrok:**
```powershell
.\ngrok.exe http 80
```

**Tekan Enter**

**Cek account di output!**

---

## 📋 LANGKAH CEPAT (REKOMENDASI)

### Langkah 1: Hentikan Ngrok

**Di terminal, tekan:** `Ctrl + C`

**Atau di Task Manager:** End task "ngrok.exe"

---

### Langkah 2: Reset Config Ngrok

**Buka PowerShell:**
1. Tekan `Windows + R`
2. Ketik: `powershell`
3. Tekan Enter

**Masuk ke folder:**
```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
```

**Reset config:**
```powershell
.\ngrok.exe config reset
```

**Tekan Enter**

---

### Langkah 3: Dapatkan Authtoken Baru

**Dari account baru:**
1. Buka: `https://dashboard.ngrok.com`
2. Login dengan account baru
3. Klik "Your Authtoken"
4. Copy authtoken baru

---

### Langkah 4: Setup Authtoken Baru

**Di terminal:**
```powershell
.\ngrok.exe config add-authtoken YOUR_NEW_AUTHTOKEN
```

**Ganti `YOUR_NEW_AUTHTOKEN` dengan authtoken baru!**

**Tekan Enter**

---

### Langkah 5: Test Ngrok

**Jalankan ngrok:**
```powershell
.\ngrok.exe http 80
```

**Tekan Enter**

**Cek account di output!**

---

## ⚠️ CATATAN PENTING

### 1. Authtoken Setiap Account Berbeda

**Setiap account ngrok memiliki authtoken yang berbeda:**
- Account lama: authtoken lama
- Account baru: authtoken baru
- **Harus setup authtoken baru setelah ganti account!**

---

### 2. URL Ngrok Akan Berubah

**Setelah ganti account:**
- URL ngrok akan berubah
- URL lama tidak bisa digunakan lagi
- **Harus dapat URL baru dari account baru!**

---

### 3. Plan Ngrok

**Ngrok memiliki beberapa plan:**
- **Free:** URL berubah setiap restart, terbatas
- **Paid:** URL tetap, lebih banyak fitur

**Setelah ganti account, plan akan mengikuti account baru!**

---

## ✅ RINGKASAN

**Pertanyaan:** "Klo ganti account bagaimana saya make akun?"

**Jawaban:**
1. ✅ **Hentikan ngrok** (jika running)
2. ✅ **Reset config ngrok:** `ngrok config reset`
3. ✅ **Dapatkan authtoken baru** dari account baru (dashboard.ngrok.com)
4. ✅ **Setup authtoken baru:** `ngrok config add-authtoken YOUR_NEW_AUTHTOKEN`
5. ✅ **Test ngrok:** `ngrok http 80`
6. ✅ **Cek account di output**

**Langkah:**
1. Hentikan ngrok
2. Reset config: `.\ngrok.exe config reset`
3. Login ke dashboard.ngrok.com dengan account baru
4. Copy authtoken baru
5. Setup: `.\ngrok.exe config add-authtoken YOUR_NEW_AUTHTOKEN`
6. Test: `.\ngrok.exe http 80`

**Selesai!** ✅

---

**Intinya: Reset config ngrok, lalu setup authtoken baru dari account baru!** 🎯

