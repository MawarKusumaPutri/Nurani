@echo off
echo ========================================
echo MEMBUAT TABEL MATERI PEMBELAJARAN
echo ========================================
echo.
cd /d "%~dp0"
php CREATE_MATERI_PEMBELAJARAN_TABLE.php
echo.
echo ========================================
echo SELESAI
echo ========================================
pause
