# 🔄 Panduan Sinkronisasi Environment

## 📋 Masalah

Aplikasi bisa diakses melalui dua URL berbeda:
- `http://127.0.0.1:8000` (Laravel development server - `php artisan serve`)
- `http://localhost/nurani/public/` (XAMPP/Apache)

Keduanya menggunakan **codebase yang sama**, tapi perlu disinkronkan agar tidak ada duplikasi perbaikan.

## ✅ Solusi yang Sudah Diterapkan

### 1. Helper URL Dinamis
Semua helper URL sekarang menggunakan `url()` yang **otomatis mendeteksi** base URL dari request saat ini:
- `url('storage/...')` - otomatis menggunakan base URL yang benar
- `route('...')` - otomatis menggunakan base URL yang benar
- `asset('...')` - otomatis menggunakan base URL yang benar

### 2. PhotoHelper
`PhotoHelper::getPhotoUrl()` sudah menggunakan `url()` yang dinamis, sehingga foto profil akan muncul di kedua environment.

### 3. Cache Management
Semua cache sudah dibersihkan dan dikonfigurasi untuk tidak bergantung pada APP_URL.

## 🚀 Cara Sinkronisasi

### Opsi 1: Menggunakan Script Otomatis (Disarankan)

1. Double-click file: `SINKRONKAN_SEMUA_ENVIRONMENT.bat`
2. Script akan otomatis:
   - Membersihkan semua cache
   - Memastikan storage symlink ada
   - Memeriksa konfigurasi .env
   - Memastikan folder storage siap

### Opsi 2: Manual

Jalankan perintah berikut di Command Prompt:

```cmd
cd D:\Praktikum DWBI\xampp\htdocs\nurani
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## 📝 Catatan Penting

### 1. File yang Sama
Kedua environment menggunakan **file yang sama** di:
```
D:\Praktikum DWBI\xampp\htdocs\nurani
```

### 2. Database yang Sama
Kedua environment menggunakan **database yang sama** (MySQL di XAMPP).

### 3. Perubahan Otomatis Tersinkron
Karena menggunakan file dan database yang sama, **semua perubahan otomatis tersinkron**:
- ✅ Perubahan kode
- ✅ Perubahan database
- ✅ Upload file (foto, dll)

### 4. Cache Perlu Dibersihkan
Jika ada perubahan konfigurasi, **wajib** clear cache:
```cmd
php artisan optimize:clear
```

## 🔧 Troubleshooting

### Masalah: Perubahan tidak muncul di salah satu environment

**Solusi:**
1. Clear cache di kedua environment:
   ```cmd
   php artisan optimize:clear
   ```
2. Refresh browser dengan hard refresh (Ctrl+F5)

### Masalah: Foto tidak muncul di salah satu environment

**Solusi:**
1. Pastikan storage symlink ada:
   ```cmd
   php artisan storage:link
   ```
2. Pastikan folder `storage/app/public` memiliki permission yang benar
3. Clear cache:
   ```cmd
   php artisan optimize:clear
   ```

### Masalah: URL tidak sesuai

**Solusi:**
1. Helper `url()` sudah otomatis mendeteksi base URL
2. Jika masih ada masalah, pastikan `.htaccess` di folder `public` sudah benar
3. Clear cache:
   ```cmd
   php artisan optimize:clear
   ```

## ✅ Checklist Sinkronisasi

Setelah melakukan perubahan, pastikan:

- [ ] Clear cache: `php artisan optimize:clear`
- [ ] Storage symlink ada: `php artisan storage:link`
- [ ] Test di `http://127.0.0.1:8000`
- [ ] Test di `http://localhost/nurani/public/`
- [ ] Foto profil muncul di kedua environment
- [ ] Fitur baru muncul di kedua environment

## 📌 Kesimpulan

**Kedua environment sudah otomatis tersinkron** karena:
1. ✅ Menggunakan file yang sama
2. ✅ Menggunakan database yang sama
3. ✅ Helper URL sudah dinamis
4. ✅ Cache sudah dikonfigurasi dengan benar

**Tidak perlu perbaikan dua kali!** Semua perubahan di satu environment akan otomatis muncul di environment lainnya setelah clear cache.

