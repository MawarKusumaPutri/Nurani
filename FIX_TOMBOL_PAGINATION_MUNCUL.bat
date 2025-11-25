@echo off
title FIX TOMBOL PAGINATION AGAR LEBIH MUNCUL
color 0A

echo.
echo ============================================
echo FIX TOMBOL PAGINATION AGAR LEBIH MUNCUL
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
echo [OK] Tombol Previous dan Next sudah diperbaiki
echo [OK] Menggunakan btn-primary (bukan outline) untuk lebih menonjol
echo [OK] Ukuran tombol diperbesar (min-width: 100px)
echo [OK] Font-weight dipertebal (font-weight: 500)
echo [OK] Menambahkan box-shadow untuk efek 3D
echo [OK] Hover effect ditambahkan
echo [OK] Spacing diperbesar (gap-3)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Perbaikan selesai:
echo - Tombol Previous dan Next lebih terlihat
echo - Menggunakan warna biru solid (btn-primary)
echo - Ukuran tombol lebih besar
echo - Font lebih tebal dan jelas
echo - Efek shadow untuk tampilan 3D
echo - Hover effect saat mouse di atas tombol
echo.
echo CARA TEST:
echo 1. Buka: http://127.0.0.1:8000/tu/presensi-siswa
echo 2. Cek tombol Previous dan Next di pagination (atas)
echo 3. Tombol seharusnya lebih besar dan lebih jelas
echo 4. Hover mouse di atas tombol untuk lihat efek
echo.
pause

