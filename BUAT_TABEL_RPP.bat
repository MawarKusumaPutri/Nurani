@echo off
chcp 65001 >nul
echo ========================================
echo MEMBUAT TABEL RPP
echo ========================================
echo.

cd /d "%~dp0"

echo Menjalankan script PHP untuk membuat tabel RPP...
echo.

php create_rpp_table.php

echo.
echo ========================================
echo Selesai!
echo ========================================
echo.
echo Jika berhasil, refresh halaman RPP di browser.
echo.
pause
