@echo off
chcp 65001 >nul
title Cari IP Address untuk Akses dari Device Lain
color 0A

echo.
echo ========================================
echo   CARI IP ADDRESS UNTUK AKSES DARI DEVICE LAIN
echo ========================================
echo.
echo Script ini akan menampilkan IP Address komputer Anda
echo yang bisa digunakan untuk akses dari laptop/smartphone lain.
echo.
echo Tekan tombol apapun untuk melanjutkan...
pause >nul

echo.
echo [INFO] Mencari IP Address...
echo.
echo ========================================
echo   IP ADDRESS YANG DITEMUKAN:
echo ========================================
echo.

ipconfig | findstr /i /c:"IPv4" /c:"IPv4 Address"

echo.
echo ========================================
echo   CARA MENGGUNAKAN:
echo ========================================
echo.
echo 1. Catat IP Address di atas (contoh: 192.168.1.100)
echo.
echo 2. Dari device lain (laptop/smartphone), buka browser
echo    dan ketik:
echo.
echo    http://[IP_ADDRESS]/nurani/public
echo.
echo    Contoh: http://192.168.1.100/nurani/public
echo.
echo 3. Pastikan device lain terhubung ke WiFi yang sama!
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

