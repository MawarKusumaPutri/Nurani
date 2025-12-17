# 🔧 Fix Error: Tablespace Error di Database Lokal

## ❌ Error yang Terjadi

```
SQLSTATE[HY000]: General error: 1813 Tablespace for table '`nurani`.`migrations`' exists. 
Please DISCARD the tablespace before IMPORT
```

**Penyebab:** Ada tablespace MySQL yang masih tersisa di database lokal, biasanya terjadi setelah drop database atau restore database.

---

## ✅ Solusi 1: Fix via SQL (TANPA DROP DATABASE)

### Via phpMyAdmin:

1. **Buka phpMyAdmin** (http://localhost/phpmyadmin)
2. **Pilih database `nurani`**
3. **Klik tab "SQL"**
4. **Jalankan SQL berikut:**

```sql
DROP TABLE IF EXISTS migrations;
```

5. **Klik "Go"** untuk menjalankan

6. **Jalankan migration lagi di terminal:**
   ```bash
   php artisan migrate --force
   ```

---

## ✅ Solusi 2: Hapus File Tablespace Manual

### Langkah:

1. **Stop MySQL di XAMPP:**
   - Buka XAMPP Control Panel
   - Klik "Stop" pada MySQL

2. **Hapus file tablespace:**
   - Buka folder: `C:\xampp\mysql\data\nurani\`
   - Hapus file: `migrations.ibd` (jika ada)
   - Hapus file: `migrations.frm` (jika ada)

3. **Start MySQL lagi:**
   - Klik "Start" pada MySQL di XAMPP

4. **Jalankan migration:**
   ```bash
   php artisan migrate --force
   ```

---

## ⚠️ PENTING: Migrations untuk Railway

### Jangan jalankan migrations di lokal untuk Railway!

**Database lokal dan Railway berbeda:**
- ✅ Database lokal: untuk development/testing
- ✅ Database Railway: untuk production

**Migrations untuk Railway harus dijalankan di Railway Shell:**
1. Buka Railway Dashboard → service "web" → tab "Shell"
2. Jalankan: `php artisan migrate --force`
3. Bukan di terminal lokal!

---

## 📋 Checklist

- [ ] **Fix tablespace error di lokal** (jika perlu test lokal)
- [ ] **Jalankan migrations di Railway Shell** (untuk production)
- [ ] **Verifikasi kolom `role` sudah ada** di Railway

---

## 💡 Tips

1. **Fix tablespace di lokal** hanya jika perlu test lokal
2. **Migrations untuk Railway** harus di Railway Shell
3. **Database lokal dan Railway terpisah**

---

**Fix tablespace error di lokal, lalu jalankan migrations di Railway Shell! 🚀**

