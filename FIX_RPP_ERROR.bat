@echo off
chcp 65001 >nul
cls
echo ========================================
echo FIX ERROR TABEL RPP
echo ========================================
echo.
echo Script ini akan membuat tabel RPP di database
echo.
pause

cd /d "%~dp0"

echo.
echo [1/2] Menjalankan script PHP untuk membuat tabel...
echo.
php fix_rpp_direct.php

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo SUKSES!
    echo ========================================
    echo.
    echo Tabel RPP sudah dibuat.
    echo Silakan refresh halaman RPP di browser.
    echo.
) else (
    echo.
    echo ========================================
    echo ERROR!
    echo ========================================
    echo.
    echo Gagal membuat tabel. Cek error di atas.
    echo.
    echo Alternatif: Buka phpMyAdmin dan jalankan
    echo file CREATE_RPP_TABLE.sql secara manual.
    echo.
)

pause
