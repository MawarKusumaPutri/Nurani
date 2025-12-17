# 🔧 Fix Error 500 di Railway

## ❌ Error yang Terjadi

```
500 SERVER ERROR
```

**Penyebab:** Biasanya karena:
1. **Migrations belum dijalankan** (database masih kosong)
2. **Error di code** yang muncul saat runtime
3. **Missing environment variables**
4. **Database connection issue**

---

## ✅ Solusi 1: Jalankan Migrations (PENTING!)

### Via Railway Shell:
1. Klik service **"web"** → tab **"Shell"**
2. Jalankan command berikut **satu per satu**:

```bash
# Clear cache dulu
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

```bash
# Cek status migrations
php artisan migrate:status
```

```bash
# Jalankan migrations
php artisan migrate --force
```

**Pastikan semua migrations berhasil!**

---

## ✅ Solusi 2: Enable Debug Mode untuk Lihat Error Detail

### Di Railway Variables:
1. Klik service **"web"** → tab **"Variables"**
2. Edit variable `APP_DEBUG`:
   ```
   APP_DEBUG=true
   ```
3. Save (Railway akan auto-restart)

**⚠️ PENTING:** Setelah fix, kembalikan ke `APP_DEBUG=false` untuk production!

### Setelah enable debug:
1. **Refresh browser** (Ctrl + F5)
2. **Cek error detail** yang muncul
3. **Copy error message lengkap**
4. **Perbaiki error** yang muncul

---

## ✅ Solusi 3: Cek HTTP Logs untuk Error Detail

### Di Railway Dashboard:
1. Klik service **"web"**
2. Klik tab **"Logs"** (di navigation bar atas)
3. Pilih **"HTTP Logs"**
4. **Scroll ke bawah** untuk melihat error terakhir
5. **Copy error message lengkap**

**Error yang mungkin muncul:**
- `SQLSTATE[42S02]: Base table or view not found`
- `Class not found`
- `Call to undefined function`
- `Route [xxx] not defined`

---

## ✅ Solusi 4: Test Database Connection

### Via Railway Shell:
```bash
php artisan tinker
```

Di dalam tinker, jalankan:
```php
DB::connection()->getPdo();
```

**Jika error:**
- Cek database variables di Railway
- Pastikan format: `${{MySQL.MYSQLHOST}}` (double curly braces)

---

## ✅ Solusi 5: Cek Environment Variables

### Pastikan semua variables ada:
Di Railway Variables, pastikan ada:

```
APP_KEY=base64:... (HARUS ADA!)
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
CACHE_DRIVER=file
SESSION_DRIVER=file
```

---

## 🐛 Troubleshooting Berdasarkan Error

### Error 1: `Base table or view not found`
**Penyebab:** Migrations belum dijalankan
**Solusi:**
```bash
php artisan migrate --force
```

### Error 2: `SQLSTATE[HY000] [2002] Connection refused`
**Penyebab:** Database connection gagal
**Solusi:**
- Cek database variables
- Pastikan format: `${{MySQL.MYSQLHOST}}`
- Test connection via Shell

### Error 3: `Class not found` atau `Call to undefined function`
**Penyebab:** Missing dependency atau autoloader issue
**Solusi:**
```bash
composer dump-autoload
composer install --no-dev --optimize-autoloader
```

### Error 4: `Route [xxx] not defined`
**Penyebab:** Route cache error
**Solusi:**
```bash
php artisan route:clear
php artisan route:cache
```

---

## 📋 Checklist Perbaikan

Ikuti urutan ini:

- [ ] **Langkah 1**: Jalankan migrations via Shell (PENTING!)
- [ ] **Langkah 2**: Enable APP_DEBUG=true untuk lihat error detail
- [ ] **Langkah 3**: Cek HTTP Logs untuk error spesifik
- [ ] **Langkah 4**: Test database connection
- [ ] **Langkah 5**: Cek environment variables lengkap
- [ ] **Langkah 6**: Refresh browser dan test lagi
- [ ] **Final**: Set APP_DEBUG=false setelah fix

---

## 💡 Tips

1. **Jalankan migrations dulu!**
   - Error 500 sering karena database kosong
   - Migrations harus dijalankan setelah deploy

2. **Enable debug sementara**
   - Lihat error detail untuk tahu masalahnya
   - Set kembali false setelah fix

3. **Monitor HTTP Logs**
   - Error detail ada di HTTP Logs
   - Bukan di Deploy Logs

---

## 🆘 Masih Error?

Jika masih error setelah semua langkah:

1. **Copy error message lengkap** dari HTTP Logs
2. **Screenshot** error message
3. **Cek** apakah migrations sudah berhasil
4. **Cek** apakah semua environment variables sudah benar

---

**Setelah jalankan migrations, error 500 seharusnya hilang! 🚀**

