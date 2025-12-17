# 🔧 Fix Error: MySQL Tablespace Error

## ❌ Error yang Terjadi

```
SQLSTATE[HY000]: General error: 1813 Tablespace for table 'nurani'.'migrations' exists. 
Please DISCARD the tablespace before IMPORT
```

**Penyebab:** Ada tablespace MySQL yang masih tersisa di database, biasanya terjadi setelah drop database atau restore database.

---

## ✅ Solusi 1: Fix Tablespace via SQL (TANPA DROP DATABASE)

### Via phpMyAdmin SQL:

1. **Buka phpMyAdmin** (http://localhost/phpmyadmin)
2. **Pilih database `nurani`**
3. **Klik tab "SQL"**
4. **Jalankan command berikut:**

```sql
-- 1. Cek apakah tabel migrations ada
SHOW TABLES LIKE 'migrations';

-- 2. Jika ada, drop dulu
DROP TABLE IF EXISTS migrations;

-- 3. Discard tablespace jika masih ada (skip jika error)
-- ALTER TABLE migrations DISCARD TABLESPACE;
```

5. **Jalankan migration lagi:**
   ```bash
   php artisan migrate --force
   ```

**⚠️ CATATAN:** Solusi ini TIDAK menghapus database, hanya fix tablespace yang bermasalah.

---

## ✅ Solusi 2: Hapus File Tablespace Manual (Jika Solusi 1 Gagal)

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

## ✅ Solusi 3: Gunakan migrate:reset (Alternatif)

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
   php artisan migrate:fresh --force
   ```

---

## ✅ Solusi 4: Gunakan migrate:reset (Alternatif)

Jika `migrate:fresh` masih error, coba:

```bash
# Reset migrations (rollback semua)
php artisan migrate:reset

# Jalankan migrations lagi
php artisan migrate --force
```

---

## 📋 Checklist

- [ ] **Coba Solusi 1** (Fix Tablespace via SQL) - TANPA DROP DATABASE
- [ ] Jika gagal, coba **Solusi 2** (Hapus File Tablespace Manual)
- [ ] Atau coba **Solusi 3** (migrate:reset)

---

## 💡 Tips

1. **Solusi 1 (Fix via SQL)** adalah yang termudah dan TIDAK menghapus database
2. **Backup database dulu** jika ada data penting (untuk jaga-jaga)
3. **Pastikan MySQL berjalan** sebelum jalankan migration
4. **Jika masih error**, coba restart MySQL di XAMPP

---

**Setelah fix, migration seharusnya berjalan dengan lancar! 🚀**
