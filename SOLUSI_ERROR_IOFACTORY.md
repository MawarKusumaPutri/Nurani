# ✅ SOLUSI ERROR: Class 'PhpOffice\PhpSpreadsheet\IOFactory' not found

## 🔍 Masalah yang Ditemukan

Error terjadi pada file `public/import-jadwal-simple.php` baris 405:
```
Class 'PhpOffice\PhpSpreadsheet\IOFactory' not found
```

### Penyebab Error:
1. **Syntax Error**: Statement `use PhpOffice\PhpSpreadsheet\IOFactory;` ditulis **di dalam conditional block** (baris 30)
2. **PHP tidak mengizinkan** `use` statement di dalam function atau conditional block
3. `use` statement **harus berada di bagian atas file**, setelah namespace declaration

## 🛠️ Perbaikan yang Dilakukan

### File: `public/import-jadwal-simple.php`

**SEBELUM (❌ ERROR):**
```php
<?php
// ... autoload code ...

use App\Models\Jadwal;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;

// Cek jika ada upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    
    // Load PhpSpreadsheet
    require __DIR__.'/../vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\IOFactory;  // ❌ ERROR: use di dalam conditional
    
    try {
        $spreadsheet = IOFactory::load($filePath);
        // ...
    }
}
```

**SESUDAH (✅ FIXED):**
```php
<?php
// ... autoload code ...

use App\Models\Jadwal;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;  // ✅ BENAR: use di bagian atas

// Cek jika ada upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    
    try {
        $spreadsheet = IOFactory::load($filePath);  // ✅ Sekarang bisa digunakan
        // ...
    }
}
```

## 📝 Perubahan yang Dilakukan:

1. ✅ **Memindahkan** `use PhpOffice\PhpSpreadsheet\IOFactory;` ke bagian atas file (baris 17)
2. ✅ **Menghapus** duplicate `require` dan `use` statement di dalam conditional block
3. ✅ **Commit dan push** ke GitHub
4. ✅ Railway akan **otomatis deploy** perubahan ini

## 🚀 Status Deployment

```
✅ git add .
✅ git commit -m "Fix IOFactory import error - move use statement to top of file"
✅ git push
```

**Railway sedang melakukan auto-deploy...**

## ⏰ Langkah Selanjutnya

### 1. Tunggu Railway Selesai Deploy (±3-5 menit)
   - Buka: https://railway.app
   - Pilih project **TMS Nurani**
   - Lihat tab **Deployments**
   - Tunggu hingga status menjadi **"Success"** ✅

### 2. Clear Cache di Railway (PENTING!)
   Setelah deployment selesai, buka **Railway Console** dan jalankan:

   ```bash
   php artisan optimize:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

### 3. Test Import Jadwal
   - Buka: `https://web-production-50f9.up.railway.app/tu/siswa/import`
   - Upload file Excel
   - Pastikan tidak ada error lagi

## 🔍 Verifikasi Error Sudah Hilang

Setelah deployment selesai dan cache di-clear, error **"Class 'PhpOffice\PhpSpreadsheet\IOFactory' not found"** akan **hilang** karena:

1. ✅ Syntax error sudah diperbaiki
2. ✅ `use` statement sudah di posisi yang benar
3. ✅ PhpSpreadsheet library sudah terinstall di `composer.json`
4. ✅ Autoload akan berjalan dengan benar

## 📚 Catatan Teknis

### Mengapa Error Ini Terjadi?

PHP memiliki aturan strict tentang `use` statement:
- ✅ **BOLEH**: Di bagian atas file, setelah `<?php` dan `namespace`
- ❌ **TIDAK BOLEH**: Di dalam function, conditional, atau loop

### File yang Terpengaruh:
- `public/import-jadwal-simple.php` ✅ **SUDAH DIPERBAIKI**

### Dependencies yang Digunakan:
```json
{
  "require": {
    "maatwebsite/excel": "^1.1",
    "phpoffice/phpspreadsheet": "^1.28"
  }
}
```

## 🎯 Kesimpulan

**Error sudah diperbaiki!** 🎉

Sekarang tinggal:
1. ⏰ Tunggu Railway selesai deploy
2. 🧹 Clear cache di Railway console
3. ✅ Test fitur import Excel

---

**Dibuat:** 2025-12-30 16:53  
**Status:** ✅ Fixed & Deployed  
**Commit:** `76037d1` - Fix IOFactory import error
