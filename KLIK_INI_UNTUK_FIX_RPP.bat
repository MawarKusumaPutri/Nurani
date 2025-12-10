@echo off
chcp 65001 >nul
title FIX ERROR TABEL RPP
color 0A
cls

echo.
echo ============================================================
echo           FIX ERROR TABEL RPP - KLIK INI
echo ============================================================
echo.
echo Script ini akan membuat tabel RPP di database.
echo Pastikan MySQL sudah running di XAMPP!
echo.
pause

cd /d "%~dp0"

echo.
echo Menjalankan script...
echo.
php BUAT_TABEL_RPP_SEKARANG.php

echo.
echo ============================================================
if %errorlevel% equ 0 (
    echo ✅ SUKSES!
    echo ============================================================
    echo.
    echo Tabel RPP sudah dibuat dengan sukses!
    echo.
    echo 📌 LANGKAH SELANJUTNYA:
    echo 1. Refresh halaman RPP di browser (Ctrl+F5)
    echo 2. Atau tutup dan buka kembali browser
    echo 3. Coba akses fitur RPP lagi
    echo.
) else (
    echo ❌ ERROR!
    echo ============================================================
    echo.
    echo Gagal membuat tabel. Cek error di atas.
    echo.
    echo 🔧 ALTERNATIF - VIA PHPMYADMIN:
    echo 1. Buka http://localhost/phpmyadmin
    echo 2. Pilih database 'nurani'
    echo 3. Klik tab 'SQL'
    echo 4. Copy-paste isi file CREATE_RPP_TABLE.sql
    echo 5. Klik 'Go'
    echo.
)

pause
