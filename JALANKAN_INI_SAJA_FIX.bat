@echo off
title FIX NOT FOUND - PASTI BERFUNGSI
color 0A

cls
echo.
echo ============================================
echo    FIX NOT FOUND - PASTI BERFUNGSI
echo ============================================
echo.
echo Script ini akan:
echo 1. Menyalin project ke htdocs
echo 2. Memverifikasi semua file
echo 3. Memperbaiki masalah otomatis
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

call "%~dp0FIX_PASTI_BERFUNGSI.bat"

echo.
echo ============================================
echo    SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR:
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Pastikan Apache RUNNING (hijau)
echo 3. Jika tidak, klik START
echo 4. Buka browser
echo 5. Ketik: http://localhost/nurani/public
echo 6. Tekan Enter
echo.
echo Website akan muncul!
echo.
pause

