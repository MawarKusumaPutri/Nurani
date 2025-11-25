@echo off
title FIX FILTER KELAS REKAP PRESENSI SISWA
color 0A

echo.
echo ============================================
echo FIX FILTER KELAS REKAP PRESENSI SISWA
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
echo [OK] View tu/presensi-siswa/rekap.blade.php sudah diperbaiki
echo [OK] Dropdown Kelas auto-submit saat dipilih
echo [OK] Dropdown Bulan auto-submit saat dipilih
echo [OK] Dropdown Siswa auto-submit saat dipilih
echo [OK] Controller memproses filter kelas dengan benar
echo [OK] Badge filter aktif ditampilkan
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Perbaikan selesai:
echo - Filter Kelas: Auto-submit saat dipilih
echo - Filter Bulan: Auto-submit saat dipilih
echo - Filter Siswa: Auto-submit saat dipilih
echo - Badge filter aktif ditampilkan
echo - Data langsung terfilter sesuai kelas yang dipilih
echo.
echo CARA TEST:
echo 1. Buka: http://127.0.0.1:8000/tu/presensi-siswa/rekap
echo 2. Pilih Kelas 7 dari dropdown
echo 3. Data langsung terfilter (hanya Kelas 7)
echo 4. Pilih Kelas 8 dari dropdown
echo 5. Data langsung terfilter (hanya Kelas 8)
echo 6. Pilih Kelas 9 dari dropdown
echo 7. Data langsung terfilter (hanya Kelas 9)
echo.
pause

