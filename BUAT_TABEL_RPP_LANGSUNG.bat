@echo off
echo ========================================
echo MEMBUAT TABEL RPP SECARA OTOMATIS
echo ========================================
echo.
cd /d "%~dp0"
echo Direktori: %CD%
echo.
echo Menjalankan script PHP untuk membuat tabel RPP...
echo.
php create_rpp_table_direct.php
echo.
echo ========================================
echo Selesai!
echo ========================================
echo.
echo Jika berhasil, refresh halaman RPP di browser (Ctrl+F5)
echo.
pause
