# 🔧 Fix Error: "No linked project found"

## ❌ MASALAH

**Error yang muncul:**
```
No linked project found.
Run railway link to connect to a project
```

**Artinya:**
- Project belum di-link ke Railway CLI
- Perlu jalankan `railway link` dulu sebelum `railway run`

---

## ✅ SOLUSI: Link Project Dulu

### Langkah 1: Pastikan di Folder Project yang Benar

**Jalankan di terminal:**

```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
```

**Verifikasi Anda di folder yang benar:**
```powershell
pwd
```

**Harus muncul:**
```
D:\Praktikum DWBI\xampp\htdocs\nurani
```

---

### Langkah 2: Link Project ke Railway

**Jalankan:**

```powershell
railway link
```

**Akan muncul opsi untuk dipilih:**

1. **Team** (jika ada):
   - Pilih team yang sesuai
   - Atau tekan Enter jika tidak ada

2. **Project:**
   - Akan muncul daftar project
   - Pilih **"TMS Nurani"** (gunakan arrow key, lalu Enter)

3. **Environment:**
   - Akan muncul daftar environment
   - Pilih **"production"** (gunakan arrow key, lalu Enter)

4. **Service:**
   - Akan muncul daftar service
   - Pilih **"web"** (gunakan arrow key, lalu Enter)

**Setelah link berhasil, akan muncul:**
```
✓ Linked to project TMS Nurani
```

---

### Langkah 3: Verifikasi Link Berhasil

**Cek apakah link berhasil:**

```powershell
railway status
```

**Atau:**

```powershell
railway whoami
```

**Jika muncul info project** = Link berhasil! ✅

---

### Langkah 4: Jalankan Migrations

**Setelah link berhasil, jalankan migrations:**

```powershell
railway run php artisan migrate --force
```

**Tunggu migrations selesai!**

---

## 📋 LANGKAH-LANGKAH LENGKAP

### Step 1: Pastikan di Folder Project
```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
```

### Step 2: Link Project
```powershell
railway link
```
- Pilih Team (jika ada)
- Pilih Project: "TMS Nurani"
- Pilih Environment: "production"
- Pilih Service: "web"

### Step 3: Verifikasi
```powershell
railway status
```

### Step 4: Jalankan Migrations
```powershell
railway run php artisan migrate --force
```

---

## 💡 TIPS

1. **Pastikan di folder project yang benar** sebelum `railway link`
2. **Gunakan arrow key** untuk pilih opsi saat `railway link`
3. **Tekan Enter** untuk konfirmasi pilihan
4. **Jangan skip langkah link** - ini wajib!

---

## 🆘 JIKA MASIH ERROR

### Error: "No projects found"
**Solusi:**
- Pastikan Anda login dengan akun yang benar
- Pastikan project "TMS Nurani" ada di Railway Dashboard

### Error: "Unauthorized"
**Solusi:**
```powershell
railway login --browserless
```
- Buka URL yang muncul di browser
- Login dan authorize

### Error: "Multiple projects found"
**Solusi:**
- Pilih project "TMS Nurani" dari daftar
- Gunakan arrow key untuk navigasi

---

**Jalankan `railway link` dulu sebelum `railway run`! 🚀**

