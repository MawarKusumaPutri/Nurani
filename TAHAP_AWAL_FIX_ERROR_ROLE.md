# 🎯 Tahap Awal: Fix Error Column 'role' Not Found

## 📋 Urutan Langkah dari Awal

### ✅ TAHAP 1: Fix Tablespace Error di Lokal (Opsional)

**Hanya jika perlu test lokal dulu:**

1. **Buka phpMyAdmin:**
   - http://localhost/phpmyadmin
   - Pilih database `nurani`
   - Tab "SQL"

2. **Jalankan SQL:**
   ```sql
   DROP TABLE IF EXISTS migrations;
   ```

3. **Klik "Go"**

4. **Jalankan migration lokal (jika perlu test):**
   ```bash
   php artisan migrate --force
   ```

**⚠️ CATATAN:** Ini hanya untuk test lokal. Untuk Railway, migrations harus di Railway Shell!

---

### ✅ TAHAP 2: Jalankan Migrations di Railway Shell (PENTING!)

**Ini yang paling penting untuk fix error di Railway:**

1. **Buka Railway Dashboard:**
   - Login ke [railway.app](https://railway.app)
   - Pilih project **"TMS Nurani"**

2. **Buka Shell:**
   - Klik service **"web"** (yang hijau/online)
   - Klik tab **"Shell"**

3. **Jalankan Command (Satu Per Satu):**

```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
```

```bash
# Langsung jalankan migrations (tidak perlu migrate:status)
php artisan migrate --force
```

**Pastikan semua migrations berhasil!**

---

### ✅ TAHAP 3: Verifikasi Migrations Berhasil

**Setelah migrations selesai:**

```bash
# Cek status migrations
php artisan migrate:status
```

**Harus menunjukkan semua migrations sudah dijalankan.**

---

### ✅ TAHAP 4: Verifikasi Kolom Role Sudah Ada

```bash
php artisan tinker
```

Di dalam tinker:
```php
Schema::hasColumn('users', 'role');
```

**Jika return `true`**, berarti kolom `role` sudah ada! ✅

Ketik `exit` untuk keluar.

---

### ✅ TAHAP 5: Test Aplikasi di Browser

1. **Refresh browser** (Ctrl + F5)
2. **Test fitur forgot-password lagi**
3. **Error seharusnya hilang!**

---

### ✅ TAHAP 6: Set APP_DEBUG=false (Setelah Fix)

**Di Railway Variables:**
1. Klik service "web" → tab "Variables"
2. Edit `APP_DEBUG`:
   ```
   APP_DEBUG=false
   ```
3. Save

---

## 📋 Checklist Lengkap

Ikuti urutan ini:

- [ ] **TAHAP 1**: Fix tablespace error di lokal (opsional, hanya jika perlu test lokal)
- [ ] **TAHAP 2**: Jalankan migrations di Railway Shell (PENTING!)
- [ ] **TAHAP 3**: Verifikasi migrations berhasil
- [ ] **TAHAP 4**: Verifikasi kolom `role` sudah ada
- [ ] **TAHAP 5**: Test aplikasi di browser
- [ ] **TAHAP 6**: Set APP_DEBUG=false

---

## 🎯 Yang Paling Penting

**TAHAP 2 adalah yang paling penting!**
- Migrations untuk Railway harus di Railway Shell
- Bukan di terminal lokal
- Setelah migrations selesai, kolom `role` akan ada
- Error akan hilang

---

## 💡 Tips

1. **Skip TAHAP 1** jika tidak perlu test lokal
2. **Fokus ke TAHAP 2** - ini yang fix error di Railway
3. **Monitor output migrations** - pastikan tidak ada error
4. **Setelah migrations selesai** - refresh browser dan test

---

**Mulai dari TAHAP 2: Jalankan migrations di Railway Shell! 🚀**

