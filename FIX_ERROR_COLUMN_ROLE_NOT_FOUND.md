# 🔧 Fix Error: Column 'role' Not Found

## ❌ Error yang Terjadi

```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'role' in 'where clause'
```

**Query yang error:**
```sql
select * from users where email = 'mawarkusuma694@gmail.com' and role = guru limit 1
```

**Penyebab:** Kolom `role` belum ada di tabel `users` karena **migrations belum dijalankan** di Railway.

---

## ✅ Solusi: Jalankan Migrations di Railway

### Langkah-Langkah:

1. **Buka Railway Dashboard**
   - Login ke [railway.app](https://railway.app)
   - Pilih project **"TMS Nurani"**

2. **Buka Shell**
   - Klik service **"web"** (yang hijau/online)
   - Klik tab **"Shell"**

3. **Jalankan Command Berikut (Satu Per Satu):**

```bash
# Clear cache dulu
php artisan config:clear
php artisan cache:clear
```

```bash
# Cek status migrations
php artisan migrate:status
```

**Output akan menunjukkan migration mana yang belum dijalankan.**

```bash
# Jalankan migrations
php artisan migrate --force
```

**Pastikan semua migrations berhasil, termasuk:**
- ✅ `2025_10_17_150326_add_role_to_users_table` (add kolom role)

---

## ✅ Verifikasi Migrations Berhasil

### Setelah migrations selesai:

```bash
# Cek apakah kolom role sudah ada
php artisan tinker
```

Di dalam tinker, jalankan:
```php
Schema::hasColumn('users', 'role');
```

**Jika return `true`**, berarti kolom `role` sudah ada! ✅

Ketik `exit` untuk keluar dari tinker.

---

## 🔍 Cek Migration yang Harus Dijalankan

### Migration untuk kolom `role`:
- File: `2025_10_17_150326_add_role_to_users_table.php`
- Menambahkan kolom:
  - `role` (string, default: 'guru')
  - `nip` (string, nullable)
  - `phone` (string, nullable)
  - `address` (text, nullable)

---

## 🐛 Jika Migrations Error

### Error 1: `Migration already exists`
**Solusi:**
- Migration sudah pernah dijalankan tapi kolom belum ada
- Cek apakah tabel `users` sudah ada kolom `role`:
  ```bash
  php artisan tinker
  Schema::getColumnListing('users');
  ```

### Error 2: `Base table or view not found: users`
**Solusi:**
- Tabel `users` belum ada
- Jalankan semua migrations dari awal:
  ```bash
  php artisan migrate:fresh --force
  ```
  **⚠️ HATI-HATI:** Ini akan menghapus semua data!

### Error 3: `SQLSTATE[HY000] [2002] Connection refused`
**Solusi:**
- Database connection error
- Cek database variables di Railway
- Pastikan format: `${{MySQL.MYSQLHOST}}`

---

## 📋 Checklist Perbaikan

Ikuti urutan ini:

- [ ] **Langkah 1**: Buka Railway Shell
- [ ] **Langkah 2**: Clear cache
- [ ] **Langkah 3**: Cek status migrations
- [ ] **Langkah 4**: Jalankan migrations (`php artisan migrate --force`)
- [ ] **Langkah 5**: Verifikasi kolom `role` sudah ada
- [ ] **Langkah 6**: Refresh browser dan test lagi
- [ ] **Final**: Set APP_DEBUG=false setelah fix

---

## 💡 Tips

1. **Jalankan semua migrations**
   - Jangan hanya migration `role` saja
   - Jalankan semua: `php artisan migrate --force`

2. **Monitor output migrations**
   - Pastikan tidak ada error
   - Pastikan semua migrations berhasil

3. **Setelah migrations selesai**
   - Refresh browser
   - Test fitur forgot-password lagi
   - Error seharusnya hilang

---

## 🆘 Masih Error?

Jika masih error setelah migrations:

1. **Cek apakah kolom `role` sudah ada:**
   ```bash
   php artisan tinker
   Schema::getColumnListing('users');
   ```

2. **Jika kolom belum ada:**
   - Cek error message di migrations
   - Pastikan migration file ada di `database/migrations/`

3. **Jika kolom sudah ada tapi masih error:**
   - Clear cache lagi
   - Restart service di Railway

---

**Setelah jalankan migrations, kolom `role` akan ada dan error akan hilang! 🚀**

