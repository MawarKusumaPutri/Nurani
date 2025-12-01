@echo off
chcp 65001 >nul
title Setup Akses dari Device Lain
color 0B

echo.
echo ========================================
echo   SETUP AKSES DARI DEVICE LAIN
echo ========================================
echo.
echo Script ini akan membantu setup agar aplikasi bisa
echo diakses dari laptop/smartphone lain dalam jaringan yang sama.
echo.
echo Tekan tombol apapun untuk melanjutkan...
pause >nul

echo.
echo [STEP 1] Mencari IP Address...
echo.
ipconfig | findstr /i /c:"IPv4" /c:"IPv4 Address"
echo.

set /p IP_ADDRESS="Masukkan IP Address Anda (contoh: 192.168.1.100): "

if "%IP_ADDRESS%"=="" (
    echo.
    echo [ERROR] IP Address tidak boleh kosong!
    pause
    exit /b 1
)

echo.
echo [STEP 2] Update file .env...
echo.

set ENV_FILE="D:\Praktikum DWBI\xampp\htdocs\nurani\.env"

if not exist %ENV_FILE% (
    echo [ERROR] File .env tidak ditemukan!
    echo Lokasi: %ENV_FILE%
    pause
    exit /b 1
)

echo [INFO] Membuat backup .env...
copy %ENV_FILE% "%ENV_FILE%.backup" >nul

echo [INFO] Update APP_URL di .env...
powershell -Command "(Get-Content %ENV_FILE%) -replace 'APP_URL=http://localhost', 'APP_URL=http://%IP_ADDRESS%' | Set-Content %ENV_FILE%"
powershell -Command "(Get-Content %ENV_FILE%) -replace 'APP_URL=http://127.0.0.1', 'APP_URL=http://%IP_ADDRESS%' | Set-Content %ENV_FILE%"

echo [INFO] .env sudah diupdate!
echo.

echo [STEP 3] Clear cache Laravel...
echo.

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

if exist "artisan" (
    php artisan config:clear >nul 2>&1
    php artisan cache:clear >nul 2>&1
    echo [INFO] Cache sudah dibersihkan!
) else (
    echo [WARNING] File artisan tidak ditemukan, skip clear cache.
)

echo.
echo ========================================
echo   SETUP SELESAI!
echo ========================================
echo.
echo IP Address: %IP_ADDRESS%
echo.
echo URL untuk akses dari device lain:
echo   http://%IP_ADDRESS%/nurani/public
echo.
echo ========================================
echo   CATATAN PENTING:
echo ========================================
echo.
echo 1. Pastikan Apache XAMPP berjalan
echo 2. Pastikan firewall mengizinkan port 80
echo 3. Pastikan device lain dalam WiFi yang sama
echo 4. Backup .env tersimpan di: %ENV_FILE%.backup
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

