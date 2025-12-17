@echo off
chcp 65001 >nul
echo ========================================
echo   CARI LOKASI MYSQL DATA DIRECTORY
echo ========================================
echo.
echo [INFO] Script ini akan mencari lokasi folder database MySQL
echo [INFO] Folder database 'nurani' biasanya ada di: mysql\data\nurani
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
php cari_lokasi_mysql_data.php

echo.
pause
