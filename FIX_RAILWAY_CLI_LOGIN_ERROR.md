# 🔧 Fix Railway CLI Login Error

## ❌ MASALAH

**Error yang muncul:**
```
Unauthorized. Please log in with `railway login`
```

**Atau:**
```
Error logging in to CLI. Please try again with `--browserless`
```

**Artinya:**
- Login Railway CLI belum selesai
- Perlu menyelesaikan proses login di browser

---

## ✅ SOLUSI: Selesaikan Login di Browser

### Langkah 1: Buka URL Login di Browser

**Dari terminal, Anda sudah dapat URL:**
```
https://railway.com/cli-login?d=...
```

**Langkah:**
1. **Copy URL lengkap** dari terminal (yang muncul setelah `railway login --browserless`)
2. **Buka URL di browser** (Chrome, Firefox, dll)
3. **Login ke Railway** di browser
4. **Authorize CLI** jika diminta

---

### Langkah 2: Verifikasi Login Berhasil

**Setelah login di browser, kembali ke terminal:**

1. **Cek apakah login berhasil:**
   ```powershell
   railway whoami
   ```

2. **Jika muncul email/username Anda** = Login berhasil! ✅

3. **Jika masih error** = Ulangi langkah 1

---

### Langkah 3: Link Project

**Setelah login berhasil:**

```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
railway link
```

**Pilih:**
- Team (jika ada)
- Project: "TMS Nurani"
- Environment: "production"
- Service: "web"

---

### Langkah 4: Jalankan Migrations

**Setelah link berhasil:**

```powershell
railway run php artisan migrate --force
```

**Tunggu migrations selesai!**

---

## 🔄 ALTERNATIF: Login Ulang

**Jika masih error, coba login ulang:**

1. **Hapus token lama** (opsional):
   ```powershell
   railway logout
   ```

2. **Login lagi:**
   ```powershell
   railway login --browserless
   ```

3. **Buka URL yang muncul** di browser
4. **Login dan authorize**
5. **Kembali ke terminal** → cek `railway whoami`

---

## 📋 LANGKAH-LANGKAH LENGKAP

### Step 1: Selesaikan Login
1. Copy URL dari terminal (setelah `railway login --browserless`)
2. Buka URL di browser
3. Login ke Railway
4. Authorize CLI

### Step 2: Verifikasi
```powershell
railway whoami
```
- Jika muncul email = Login berhasil ✅

### Step 3: Link Project
```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
railway link
```

### Step 4: Jalankan Migrations
```powershell
railway run php artisan migrate --force
```

---

## 💡 TIPS

1. **Jangan tutup terminal** saat login di browser
2. **Tunggu sampai proses login selesai** di browser
3. **Cek `railway whoami`** untuk verifikasi login
4. **Jika masih error**, coba `railway logout` lalu login lagi

---

## 🆘 JIKA MASIH ERROR

**Coba cara alternatif:**

1. **Gunakan Personal Access Token:**
   - Railway Dashboard → Settings → Tokens
   - Create new token
   - Gunakan token untuk login

2. **Atau gunakan cara lain:**
   - Tambahkan migrations ke start command lagi (sementara)
   - Atau jalankan migrations via Railway Dashboard (jika ada fitur)

---

**Selesaikan login di browser dulu! Buka URL yang muncul di terminal! 🚀**

