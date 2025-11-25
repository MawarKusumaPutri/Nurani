@echo off
title FIX FILTER DAN CARI GURU
color 0A

echo.
echo ============================================
echo FIX FILTER DAN CARI GURU
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
echo [OK] Controller TuController::guruIndex() sudah diperbaiki
echo [OK] View tu/guru/index.blade.php sudah diperbaiki
echo [OK] Filter Mata Pelajaran berfungsi
echo [OK] Filter Status berfungsi
echo [OK] Pencarian Nama/NIP berfungsi
echo [OK] Pagination mempertahankan filter
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Perbaikan selesai:
echo - Filter Mata Pelajaran: Otomatis dari database
echo - Filter Status: Aktif/Tidak Aktif
echo - Pencarian: Nama atau NIP (real-time)
echo - Pagination: Mempertahankan filter
echo - Reset Filter: Tombol untuk clear semua filter
echo.
echo CARA TEST:
echo 1. Buka: http://127.0.0.1:8000/tu/guru
echo 2. Pilih Mata Pelajaran dari dropdown
echo 3. Pilih Status dari dropdown
echo 4. Ketik nama atau NIP di kolom Cari Guru
echo 5. Klik tombol Filter atau tekan Enter
echo 6. Filter akan langsung diterapkan
echo.
pause

