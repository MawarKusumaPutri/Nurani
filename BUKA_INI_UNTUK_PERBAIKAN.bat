@echo off
title PERBAIKAN TOTAL - localhost/nurani/public
color 0B

cls
echo.
echo ============================================
echo    PERBAIKAN TOTAL OTOMATIS
echo    Memperbaiki localhost/nurani/public
echo ============================================
echo.
echo Script ini akan:
echo - Menyalin project ke htdocs otomatis
echo - Memverifikasi semua file penting
echo - Memperbaiki masalah otomatis
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

call "%~dp0PERBAIKAN_TOTAL_OTOMATIS.bat"

echo.
echo ============================================
echo    PERBAIKAN SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR:
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Pastikan Apache RUNNING (hijau)
echo 3. Jika tidak running, klik START
echo 4. Buka browser
echo 5. Ketik: http://localhost/nurani/public
echo 6. Tekan Enter
echo.
echo Website Laravel akan muncul!
echo.
pause

