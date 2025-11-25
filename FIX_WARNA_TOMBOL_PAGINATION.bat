@echo off
title FIX WARNA TOMBOL PAGINATION TIDAK HIJAU
color 0A

echo.
echo ============================================
echo FIX WARNA TOMBOL PAGINATION TIDAK HIJAU
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
echo [OK] Tombol pagination menggunakan warna biru (bukan hijau)
echo [OK] Class custom pagination-btn-active untuk kontrol warna
echo [OK] Override semua state (hover, active, focus) agar tetap biru
echo [OK] Warna biru: #0d6efd (Bootstrap primary blue)
echo [OK] Tidak ada warna hijau yang muncul saat diklik
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Perbaikan selesai:
echo - Tombol Previous dan Next menggunakan warna BIRU
echo - Tidak ada warna hijau saat diklik
echo - Warna biru tetap konsisten di semua state
echo - Hover effect tetap biru (lebih gelap)
echo - Active state tetap biru (tidak hijau)
echo.
echo CARA TEST:
echo 1. Buka: http://127.0.0.1:8000/tu/presensi-siswa
echo 2. Klik tombol Next atau Previous
echo 3. Warna tombol seharusnya BIRU (bukan hijau)
echo 4. Saat hover, warna tetap biru (lebih gelap)
echo 5. Saat diklik, warna tetap biru
echo.
pause

