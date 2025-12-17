# ✅ Cara Fix Login di Railway

## 🎯 MASALAH

**Error di Railway:** "Email atau password tidak valid"
**Status di Local:** Login sudah berfungsi

**Penyebab:** Data guru belum ada di database Railway (migrations dan seeder belum berjalan).

---

## ✅ SOLUSI: Update Konfigurasi Railway

### Langkah 1: Update railway.json

**File `railway.json` sudah diupdate untuk menjalankan migrations dan seeder otomatis.**

**Isi file `railway.json`:**
```json
{
  "$schema": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "NIXPACKS",
    "buildCommand": "composer install --no-dev --optimize-autoloader && php artisan storage:link && npm install && npm run build"
  },
  "deploy": {
    "startCommand": "php database/migrate-and-seed-safe.php || true && php artisan serve --host=0.0.0.0 --port=$PORT",
    "restartPolicyType": "ON_FAILURE",
    "restartPolicyMaxRetries": 10
  }
}
```

### Langkah 2: Commit dan Push ke GitHub

**Buka PowerShell:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
git add railway.json database/migrate-and-seed-safe.php
git commit -m "Fix Railway: Add migrations and seeder to startCommand"
git push origin main
```

**Railway akan otomatis deploy ulang setelah push.**

---

## 🔄 ATAU: Jalankan Manual di Railway Shell

**Jika ingin jalankan manual tanpa deploy ulang:**

1. **Buka Railway Dashboard**
2. **Klik service Anda**
3. **Klik tab "Deployments"**
4. **Klik deployment terbaru**
5. **Klik "Shell"**
6. **Jalankan:**

```bash
php artisan migrate --force
php artisan db:seed --class=UserSeeder
```

---

## ✅ SETELAH DEPLOY ULANG

1. **Tunggu deploy selesai** (biasanya 2-5 menit)
2. **Cek Deploy Logs** di Railway untuk memastikan migrations dan seeder berjalan
3. **Test login** di Railway dengan:
   - Email: `mundarinurhadi@gmail.com`
   - Password: `Nurhadi2024!`

---

## 📋 CEK HASIL

### Cara 1: Cek Deploy Logs

1. **Buka Railway Dashboard**
2. **Klik service Anda**
3. **Klik tab "Deployments"**
4. **Klik deployment terbaru**
5. **Cek logs** - harus ada:
   - `[SUKSES] Migrations selesai!`
   - `[SUKSES] Seeder selesai! Data guru sudah dibuat!`
   - `Jumlah guru di database: 13`

### Cara 2: Test Login

1. **Buka aplikasi Railway** → URL Railway Anda
2. **Klik "LOGIN"** → Pilih role "GURU"
3. **Masukkan:**
   - Email: `mundarinurhadi@gmail.com`
   - Password: `Nurhadi2024!`
4. **Klik "Login"**
5. **Jika berhasil masuk** = Fix berhasil! ✅

---

## 🆘 TROUBLESHOOTING

### Error: "Table 'users' doesn't exist"

**Solusi:**
- Migrations belum jalan
- Cek Deploy Logs untuk error migrations
- Jalankan manual di Railway Shell: `php artisan migrate --force`

### Error: "Email atau password tidak valid"

**Solusi:**
- Seeder belum jalan
- Cek Deploy Logs untuk error seeder
- Jalankan manual di Railway Shell: `php artisan db:seed --class=UserSeeder`

### Error: "Database connection failed"

**Solusi:**
- Cek environment variables di Railway
- Pastikan `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sudah benar
- Pastikan database service sudah running di Railway

---

## 📋 CHECKLIST

### ✅ Update Konfigurasi:
- [ ] File `railway.json` sudah diupdate
- [ ] File `database/migrate-and-seed-safe.php` sudah dibuat
- [ ] Commit dan push ke GitHub

### ✅ Deploy:
- [ ] Railway otomatis deploy setelah push
- [ ] Cek Deploy Logs - migrations dan seeder berjalan
- [ ] Tidak ada error di logs

### ✅ Verifikasi:
- [ ] Test login di Railway
- [ ] Pastikan bisa masuk dengan email guru
- [ ] Pastikan redirect ke dashboard sesuai role

---

## 💡 TIPS

1. **Cek Deploy Logs** - Paling penting untuk debug
2. **Gunakan Railway Shell** - Untuk jalankan command manual jika perlu
3. **Test login setelah deploy** - Pastikan data guru sudah ada
4. **Monitor resource usage** - Pastikan Railway service tidak kehabisan resource

---

## 🎯 REKOMENDASI

**Setelah update `railway.json` dan push ke GitHub, Railway akan otomatis deploy dan menjalankan migrations + seeder!**

**Tunggu deploy selesai, lalu test login!**

---

**Update railway.json dan push ke GitHub untuk fix login di Railway! 🚀**

