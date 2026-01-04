# ⚠️ PENTING: JALANKAN MIGRATION DI RAILWAY!

## 🔴 **MASALAH:**

Tanda tangan dan nama Kepala Sekolah **TIDAK MUNCUL** di halaman Lihat RPP karena **kolom database belum ada!**

---

## ✅ **SOLUSI:**

Jalankan migration di Railway untuk menambahkan kolom baru ke tabel `rpps`.

---

## 📊 **Kolom yang Ditambahkan:**

```sql
ALTER TABLE rpps ADD COLUMN kepala_sekolah_nama VARCHAR(255) NULL;
ALTER TABLE rpps ADD COLUMN kepala_sekolah_nip VARCHAR(255) NULL;
ALTER TABLE rpps ADD COLUMN ttd_kepala_sekolah VARCHAR(255) NULL;
ALTER TABLE rpps ADD COLUMN ttd_guru VARCHAR(255) NULL;
```

---

## 🚀 **Cara Jalankan Migration di Railway:**

### **Opsi 1: Via Railway Dashboard (RECOMMENDED)**

1. **Buka Railway Dashboard:**
   - https://railway.app
   - Pilih project **Nurani**

2. **Buka Tab "Deployments":**
   - Tunggu deployment terbaru selesai
   - Status harus **"Success"** ✅

3. **Buka Terminal:**
   - Klik tab **"Settings"**
   - Scroll ke bawah
   - Klik **"Open Terminal"** atau **"Shell"**

4. **Jalankan Migration:**
   ```bash
   php artisan migrate
   ```

5. **Tunggu Output:**
   ```
   Migrating: 2025_12_31_084804_add_signature_fields_to_rpps_table
   Migrated:  2025_12_31_084804_add_signature_fields_to_rpps_table (XX.XXms)
   ```

6. **Selesai!** ✅

---

### **Opsi 2: Via Railway CLI**

```bash
# Install Railway CLI (jika belum)
npm install -g @railway/cli

# Login
railway login

# Link project
railway link

# Run migration
railway run php artisan migrate
```

---

### **Opsi 3: Tambahkan di deploy.sh**

Edit file `deploy.sh` di root project:

```bash
#!/bin/bash

# Pull latest code
git pull origin master

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Create storage link
php artisan storage:link

echo "Deployment complete!"
```

Lalu jalankan:
```bash
railway run bash deploy.sh
```

---

## 🔍 **Verifikasi Migration Berhasil:**

### **1. Cek via Railway Terminal:**
```bash
php artisan migrate:status
```

Output harus menunjukkan migration sudah **"Ran"**:
```
+------+-----------------------------------------------------------+-------+
| Ran? | Migration                                                 | Batch |
+------+-----------------------------------------------------------+-------+
| Yes  | 2025_12_31_084804_add_signature_fields_to_rpps_table      | X     |
+------+-----------------------------------------------------------+-------+
```

### **2. Cek via Database:**
```bash
php artisan tinker
```

Lalu jalankan:
```php
Schema::hasColumn('rpps', 'kepala_sekolah_nama')
// Output: true

Schema::hasColumn('rpps', 'ttd_kepala_sekolah')
// Output: true
```

---

## 📝 **Setelah Migration Berhasil:**

### **1. Test Upload Tanda Tangan:**

1. Login sebagai Guru
2. Edit RPP yang sudah ada
3. Isi:
   - **Nama Kepala Sekolah:** "Setiawan"
   - **NIP Kepala Sekolah:** "1234567"
   - **Upload TTD Kepala Sekolah**
   - **Upload TTD Guru**
4. Klik **"Update RPP"**
5. Buka **"Lihat RPP"**
6. Scroll ke bawah
7. **Tanda tangan HARUS MUNCUL!** ✅

---

## ⚠️ **Troubleshooting:**

### **Error: "SQLSTATE[42S01]: Base table or view already exists"**

**Solusi:** Kolom sudah ada, skip migration:
```bash
php artisan migrate:status
```

### **Error: "SQLSTATE[42000]: Syntax error"**

**Solusi:** Cek syntax migration file, lalu rollback dan migrate ulang:
```bash
php artisan migrate:rollback --step=1
php artisan migrate
```

### **Error: "Class 'Storage' not found"**

**Solusi:** Tambahkan use statement di controller:
```php
use Illuminate\Support\Facades\Storage;
```

### **Tanda Tangan Masih Tidak Muncul:**

**Cek:**
1. ✅ Migration sudah dijalankan?
2. ✅ Storage link sudah dibuat? (`php artisan storage:link`)
3. ✅ File upload berhasil? (cek di `storage/app/public/signatures/`)
4. ✅ Data tersimpan di database? (cek tabel `rpps`)

---

## 🎯 **Kesimpulan:**

**Migration HARUS dijalankan di Railway agar kolom database tersedia!**

Tanpa migration, data tanda tangan tidak bisa disimpan dan tidak akan muncul di halaman Lihat RPP.

**Setelah migration berhasil, test upload tanda tangan lagi!** ✅

---

**Dibuat:** 2025-12-31 15:47  
**Status:** ⚠️ URGENT - Migration Required  
**Commit:** `f430ab3` - Add migration for signature fields  
**Next:** Run `php artisan migrate` di Railway
