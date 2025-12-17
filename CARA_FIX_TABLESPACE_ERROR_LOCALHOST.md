# 🔧 Cara Fix Tablespace Error di Localhost

## ❌ MASALAH

**Error yang muncul:**
```
SQLSTATE[HY000]: General error: 1813 Tablespace for table 'migrations' exists
```

**Artinya:**
- File tablespace (`.ibd` dan `.frm`) masih ada di folder data MySQL
- Tabel sudah dihapus tapi file masih ada
- Perlu hapus file manual atau DISCARD tablespace

---

## ✅ SOLUSI: Fix via phpMyAdmin

### Langkah 1: Buka phpMyAdmin

1. **Buka browser** → `http://localhost/phpmyadmin`
2. **Pilih database "nurani"** (di sidebar kiri)
3. **Klik tab "SQL"** (di bagian atas)

### Langkah 2: Jalankan Query

**Copy dan paste query ini di phpMyAdmin:**

```sql
-- Buat tabel temporary dulu
CREATE TABLE IF NOT EXISTS migrations_temp LIKE migrations;

-- DISCARD tablespace
ALTER TABLE migrations_temp DISCARD TABLESPACE;

-- Hapus tabel temporary
DROP TABLE IF EXISTS migrations_temp;

-- Hapus tabel migrations jika masih ada
DROP TABLE IF EXISTS migrations;
```

**Klik tombol "Go"**

### Langkah 3: Jalankan Migrations

**Buka PowerShell di folder project:**

```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

**Tunggu sampai migrations selesai!**

---

## ✅ ALTERNATIF: Hapus File Manual

**Jika cara di atas tidak bekerja:**

1. **Stop MySQL** di XAMPP Control Panel
2. **Buka folder data MySQL:**
   - Biasanya: `C:\xampp\mysql\data\nurani\`
3. **Hapus file:**
   - `migrations.frm`
   - `migrations.ibd`
4. **Start MySQL** lagi di XAMPP
5. **Jalankan migrations:**
   ```powershell
   php artisan migrate --force
   ```

---

## 📋 CHECKLIST

- [ ] Buka phpMyAdmin
- [ ] Pilih database "nurani"
- [ ] Klik tab "SQL"
- [ ] Jalankan query DISCARD tablespace
- [ ] Jalankan `php artisan migrate --force`
- [ ] Test aplikasi di browser

---

**Fix tablespace error dulu, lalu jalankan migrations! 🚀**

