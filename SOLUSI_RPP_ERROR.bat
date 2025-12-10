@echo off
chcp 65001 >nul
cls
echo ========================================
echo SOLUSI ERROR TABEL RPP
echo ========================================
echo.
echo Script ini akan membuat tabel RPP di database
echo dengan metode yang lebih sederhana dan aman.
echo.
pause

cd /d "%~dp0"

echo.
echo Menjalankan script...
echo.
php fix_rpp_simple.php

echo.
echo ========================================
if %errorlevel% equ 0 (
    echo SUKSES!
    echo ========================================
    echo.
    echo Tabel RPP sudah dibuat dengan sukses.
    echo.
    echo Langkah selanjutnya:
    echo 1. Refresh halaman RPP di browser (Ctrl+F5)
    echo 2. Atau tutup dan buka kembali browser
    echo.
) else (
    echo ERROR!
    echo ========================================
    echo.
    echo Gagal membuat tabel. Cek error di atas.
    echo.
    echo Alternatif:
    echo 1. Buka phpMyAdmin: http://localhost/phpmyadmin
    echo 2. Pilih database 'nurani'
    echo 3. Klik tab 'SQL'
    echo 4. Copy-paste isi file CREATE_RPP_TABLE.sql
    echo 5. Klik 'Go'
    echo.
)

pause
