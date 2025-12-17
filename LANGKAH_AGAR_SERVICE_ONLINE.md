# 🚀 Langkah-Langkah Agar Service Online di Railway

## ✅ Yang Sudah Diperbaiki

1. ✅ Build command sudah diperbaiki (hapus `key:generate`)
2. ✅ Migration order sudah diperbaiki (gurus & jadwal)
3. ✅ Perubahan sudah di-commit

---

## 📋 Langkah 1: Pastikan APP_KEY Ada di Railway Variables

### Di Railway Dashboard:
1. Klik service **"web"** (yang merah)
2. Klik tab **"Variables"**
3. **Cek apakah ada variable `APP_KEY`**

### Jika APP_KEY belum ada:
1. Generate APP_KEY lokal:
   ```bash
   php artisan key:generate --show
   ```
2. Copy output yang muncul (contoh: `base64:xxxxx...`)
3. Di Railway Variables, klik **"+ New Variable"**
4. Tambahkan:
   ```
   Name: APP_KEY
   Value: base64:xxxxx... (paste hasil generate)
   ```
5. Klik **"Save"**

---

## 📋 Langkah 2: Push ke GitHub

### Di Terminal/Command Prompt:
```bash
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
git push origin master
```

**Tunggu sampai push selesai** (biasanya 1-2 menit).

---

## 📋 Langkah 3: Monitor Deploy di Railway

### Setelah push ke GitHub:
1. Buka Railway Dashboard
2. Klik service **"web"**
3. Klik tab **"Deployments"**
4. **Monitor build progress:**
   - ✅ "Initialization" - berhasil
   - ✅ "Build > Build image" - harus berhasil (tidak error lagi)
   - ✅ "Deploy" - harus berhasil

**Tunggu 3-5 menit** sampai build selesai.

---

## 📋 Langkah 4: Jalankan Migrations di Railway

### Setelah build berhasil:
1. Klik service **"web"** → tab **"Shell"**
2. Jalankan command berikut **satu per satu**:

```bash
# Clear cache dulu
php artisan config:clear
php artisan cache:clear
```

```bash
# Cek status migrations
php artisan migrate:status
```

```bash
# Jalankan migrations
php artisan migrate --force
```

**Jika ada error**, copy error message dan kirimkan ke saya.

---

## 📋 Langkah 5: Verifikasi Service Online

### Setelah migrations selesai:
1. Klik service **"web"** → tab **"Details"**
2. **Cek status:**
   - ✅ Harus **"Active"** atau **"Online"** (hijau)
   - ❌ Jika masih **"Crashed"** (merah), cek Deploy Logs

3. **Test aplikasi:**
   - Klik URL di bagian "Domains"
   - Atau buka: `https://your-app.railway.app`
   - Harus bisa diakses!

---

## 🐛 Jika Masih Error

### Error 1: Build masih gagal
**Solusi:**
- Cek Build Logs untuk error spesifik
- Pastikan APP_KEY ada di Variables
- Pastikan semua dependencies terinstall

### Error 2: Migrations error
**Solusi:**
- Cek error message di Shell
- Pastikan database variables sudah benar
- Format: `${{MySQL.MYSQLHOST}}` (double curly braces)

### Error 3: Service masih crash
**Solusi:**
- Cek Deploy Logs untuk error terakhir
- Cek HTTP Logs untuk runtime errors
- Pastikan semua environment variables lengkap

---

## 📋 Checklist Final

Ikuti urutan ini:

- [ ] **Langkah 1**: Pastikan APP_KEY ada di Railway Variables
- [ ] **Langkah 2**: Push ke GitHub (`git push origin master`)
- [ ] **Langkah 3**: Monitor Deploy di Railway (tunggu build selesai)
- [ ] **Langkah 4**: Jalankan Migrations via Shell
- [ ] **Langkah 5**: Verifikasi Service Online (harus hijau!)
- [ ] **Test**: Buka URL aplikasi di browser

---

## 💡 Tips

1. **Jangan panik** jika build masih error
   - Cek Build Logs untuk error spesifik
   - Perbaiki satu per satu

2. **Monitor Logs**
   - Build Logs: untuk build errors
   - Deploy Logs: untuk startup errors
   - HTTP Logs: untuk runtime errors

3. **Pastikan Variables Lengkap**
   - APP_KEY (WAJIB!)
   - Database variables (WAJIB!)
   - APP_ENV, APP_DEBUG, dll

---

## 🎯 Urutan Prioritas

1. **PENTING:** Pastikan APP_KEY ada di Variables
2. **PENTING:** Push ke GitHub
3. **PENTING:** Tunggu build selesai
4. **PENTING:** Jalankan migrations
5. **Verifikasi:** Service harus hijau!

---

**Setelah semua langkah, service seharusnya ONLINE dan HIJAU! 🚀**

