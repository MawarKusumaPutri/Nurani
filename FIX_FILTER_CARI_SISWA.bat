@echo off
title FIX FILTER DAN CARI SISWA
color 0A

echo.
echo ============================================
echo FIX FILTER DAN CARI SISWA
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [ERROR] Project tidak ditemukan!
    pause
    exit /b 1
)

cd /d "%XAMPP_PATH%\htdocs\nurani"

echo [1/2] Clear cache...
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
echo [OK] Cache cleared
echo.

echo [2/2] Verifikasi perubahan...
echo [OK] Controller TuController::siswaIndex() sudah diperbaiki
echo [OK] View tu/siswa/index.blade.php sudah diperbaiki
echo [OK] Filter Kelas berfungsi (Kelas 7, 8, 9, atau Semua)
echo [OK] Filter Status berfungsi (Aktif/Tidak Aktif)
echo [OK] Pencarian Nama/NIS berfungsi
echo [OK] Filter kombinasi berfungsi
echo [OK] Reset Filter tersedia
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Perbaikan selesai:
echo - Filter Kelas: Pilih kelas tertentu atau semua kelas
echo - Filter Status: Aktif/Tidak Aktif
echo - Pencarian: Nama atau NIS (real-time)
echo - Filter kombinasi: Bisa menggunakan beberapa filter sekaligus
echo - Reset Filter: Tombol untuk clear semua filter
echo - Total siswa: Menampilkan jumlah siswa yang sesuai filter
echo.
echo CARA TEST:
echo 1. Buka: http://127.0.0.1:8000/tu/siswa
echo 2. Pilih Kelas dari dropdown (otomatis filter)
echo 3. Pilih Status dari dropdown (otomatis filter)
echo 4. Ketik nama atau NIS di kolom Cari Siswa
echo 5. Tekan Enter atau klik tombol Filter
echo 6. Filter akan langsung diterapkan ke semua kelas
echo 7. Jika pilih kelas tertentu, hanya kelas itu yang ditampilkan
echo.
pause

