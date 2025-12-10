@echo off
chcp 65001 >nul
cls
echo ========================================
echo MEMBUAT TABEL RPP SECARA OTOMATIS
echo ========================================
echo.
cd /d "%~dp0"
echo Direktori: %CD%
echo.
echo Menjalankan script PHP...
echo.
php BUAT_RPP_SIMPLE.php
echo.
echo ========================================
echo Selesai!
echo ========================================
echo.
echo Jika berhasil, refresh halaman RPP di browser (Ctrl+F5)
echo Atau buka: http://localhost/nurani/public/guru/rpp
echo.
pause
