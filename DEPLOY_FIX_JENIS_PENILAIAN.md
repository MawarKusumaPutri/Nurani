# Cara Deploy Fix untuk Error jenis_penilaian

## Masalah
Error: "Field 'jenis_penilaian' doesn't have a default value"

## Solusi yang Sudah Diterapkan
File `app/Http/Controllers/EvaluasiGuruController.php` sudah diperbaiki dengan:
1. Menambahkan field `jenis_penilaian` secara eksplisit
2. Menggunakan `DB::table()->insert()` untuk memastikan semua field terisi
3. Validasi ketat untuk memastikan `jenis_penilaian` selalu ada

## Langkah Deploy ke Railway

### 1. Commit Perubahan
```bash
git add app/Http/Controllers/EvaluasiGuruController.php
git commit -m "Fix: Tambahkan field jenis_penilaian pada lembarStore method"
```

### 2. Push ke Repository
```bash
git push origin master
```

### 3. Railway Akan Auto-Deploy
Railway akan otomatis mendeteksi perubahan dan melakukan deploy ulang.

### 4. Tunggu Deploy Selesai
- Buka dashboard Railway
- Cek status deploy di tab "Deployments"
- Tunggu sampai status "Active"

### 5. Clear Cache (Opsional)
Jika masih error setelah deploy, clear cache:
- Buka Railway Shell
- Jalankan: `php artisan cache:clear`
- Jalankan: `php artisan config:clear`

## Verifikasi
Setelah deploy selesai, coba lagi membuat lembar penilaian. Error seharusnya sudah tidak muncul.
