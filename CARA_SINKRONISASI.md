# Cara Memastikan Sinkronisasi Berjalan dengan Baik

## ✅ Status: Semua File Sudah Tersimpan

Semua perubahan sudah tersimpan di folder `D:\Capstone\nurani`. Karena kedua environment menggunakan folder yang sama, perubahan sudah otomatis tersinkron.

## 🔧 Langkah-Langkah untuk Memastikan Sinkronisasi

### 1. Clear Laravel Cache
Jalankan di terminal/PowerShell:
```bash
cd D:\Capstone\nurani
php artisan optimize:clear
```

Atau jalankan file `sync_changes.bat` yang sudah dibuat.

### 2. Clear Browser Cache
- Tekan `Ctrl + Shift + Delete`
- Pilih "Cached images and files"
- Klik "Clear data"

### 3. Hard Refresh Browser
- Tekan `Ctrl + F5` atau `Ctrl + Shift + R`
- Ini akan memaksa browser memuat ulang semua file

### 4. Restart Server (Jika Perlu)

**Untuk http://127.0.0.1:8000:**
```bash
# Stop server (Ctrl+C)
# Start lagi
php artisan serve
```

**Untuk http://localhost/nurani/public/:**
- Restart Apache di XAMPP Control Panel

### 5. Verifikasi File

Pastikan file-file berikut ada dan berisi perubahan:

✅ `app/Http/Controllers/GuruController.php` - Ada 12 referensi jadwal
✅ `app/Models/Guru.php` - Ada method jadwal()
✅ `routes/web.php` - Ada route guru.jadwal.index
✅ `resources/views/guru/dashboard.blade.php` - Ada 10 referensi jadwal
✅ `resources/views/guru/jadwal/index.blade.php` - File ada
✅ 18 file view guru lainnya - Semua sudah ada link Jadwal Mengajar

## 📋 Checklist Sinkronisasi

- [x] Semua file sudah tersimpan
- [x] Route sudah terdaftar
- [x] Cache sudah di-clear
- [ ] Browser cache sudah di-clear (lakukan manual)
- [ ] Hard refresh browser (lakukan manual)

## 🚨 Jika Masih Belum Tersinkron

### Solusi 1: Clear Semua Cache
```bash
cd D:\Capstone\nurani
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Solusi 2: Cek Browser Console
1. Buka browser
2. Tekan `F12` untuk buka Developer Tools
3. Lihat tab "Console" untuk error
4. Lihat tab "Network" untuk cek file yang di-load

### Solusi 3: Cek File Langsung
Buka file `resources/views/guru/dashboard.blade.php` dan cari:
- "Jadwal Mengajar" (harus ada)
- "jadwalHariIni" (harus ada)
- "jadwalMingguIni" (harus ada)

### Solusi 4: Test Route
Buka browser dan akses:
- `http://127.0.0.1:8000/guru/jadwal` (harus bisa diakses)
- `http://localhost/nurani/public/guru/jadwal` (harus bisa diakses)

## 📝 Catatan Penting

1. **Kedua environment menggunakan folder yang sama**
   - `http://127.0.0.1:8000` → `D:\Capstone\nurani`
   - `http://localhost/nurani/public/` → `D:\Capstone\nurani`
   - Jadi perubahan otomatis tersinkron

2. **Yang perlu dilakukan manual:**
   - Clear browser cache
   - Hard refresh browser
   - Restart server jika perlu

3. **Jika masih ada masalah:**
   - Pastikan tidak ada file yang ter-lock
   - Pastikan permission file benar
   - Cek error log Laravel: `storage/logs/laravel.log`

## ✅ Verifikasi Akhir

Setelah melakukan langkah-langkah di atas, cek:

1. Dashboard guru harus menampilkan:
   - Card "Jadwal Hari Ini" di summary cards
   - Section "Jadwal Mengajar Hari Ini"
   - Section "Jadwal Mengajar Minggu Ini"
   - Section "Jadwal Mengajar Mendatang"

2. Sidebar harus menampilkan:
   - Link "Jadwal Mengajar" di semua halaman guru

3. Halaman jadwal harus bisa diakses:
   - `/guru/jadwal` harus bisa dibuka
   - Harus menampilkan jadwal yang dibuat oleh TU

## 🎯 Kesimpulan

Semua perubahan sudah tersimpan dan tersinkron. Yang perlu dilakukan adalah:
1. Clear cache Laravel ✅ (sudah dilakukan)
2. Clear browser cache (lakukan manual)
3. Hard refresh browser (lakukan manual)

Setelah itu, semua fitur akan muncul di kedua environment!

