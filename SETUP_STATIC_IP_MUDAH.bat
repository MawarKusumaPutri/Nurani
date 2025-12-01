@echo off
chcp 65001 >nul
title Setup Static IP Address - MUDAH BANGET!
color 0A

echo.
echo ========================================
echo   SETUP STATIC IP ADDRESS - MUDAH BANGET!
echo ========================================
echo.
echo Script ini akan membantu Anda setup IP address
echo agar tidak berubah-ubah setiap kali reconnect WiFi.
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo [STEP 1] Mencari IP Address saat ini...
echo.
ipconfig | findstr /i /c:"IPv4" /c:"IPv4 Address"
echo.

set /p CURRENT_IP="Masukkan IP Address Anda saat ini (contoh: 192.168.1.13): "

if "%CURRENT_IP%"=="" (
    echo.
    echo [ERROR] IP Address tidak boleh kosong!
    pause
    exit /b 1
)

echo.
echo [STEP 2] Mencari Subnet Mask dan Gateway...
echo.
ipconfig | findstr /i /c:"Subnet Mask" /c:"Default Gateway"
echo.

set /p SUBNET_MASK="Masukkan Subnet Mask (biasanya 255.255.255.0): "
set /p GATEWAY="Masukkan Default Gateway (contoh: 192.168.1.1): "

if "%SUBNET_MASK%"=="" set SUBNET_MASK=255.255.255.0
if "%GATEWAY%"=="" (
    echo.
    echo [WARNING] Gateway kosong, akan menggunakan default...
    for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "Default Gateway"') do (
        set GATEWAY=%%a
        set GATEWAY=!GATEWAY: =!
    )
)

echo.
echo [STEP 3] Mencari nama adapter WiFi/Ethernet...
echo.
ipconfig | findstr /i /c:"adapter" /c:"Adapter"
echo.

set /p ADAPTER_NAME="Masukkan nama adapter (contoh: Wi-Fi atau Ethernet): "

if "%ADAPTER_NAME%"=="" (
    echo.
    echo [ERROR] Nama adapter tidak boleh kosong!
    pause
    exit /b 1
)

echo.
echo ========================================
echo   KONFIGURASI YANG AKAN DITERAPKAN:
echo ========================================
echo.
echo IP Address    : %CURRENT_IP%
echo Subnet Mask   : %SUBNET_MASK%
echo Gateway       : %GATEWAY%
echo Adapter       : %ADAPTER_NAME%
echo.
echo ========================================
echo.
set /p CONFIRM="Apakah konfigurasi di atas benar? (Y/N): "

if /i not "%CONFIRM%"=="Y" (
    echo.
    echo Setup dibatalkan.
    pause
    exit /b 0
)

echo.
echo [STEP 4] Menerapkan static IP address...
echo.
echo [INFO] Ini memerlukan hak Administrator...
echo.

netsh interface ip set address name="%ADAPTER_NAME%" static %CURRENT_IP% %SUBNET_MASK% %GATEWAY%

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo   ✅ BERHASIL! Static IP sudah diset!
    echo ========================================
    echo.
    echo IP Address Anda sekarang: %CURRENT_IP%
    echo IP ini TIDAK akan berubah lagi!
    echo.
    echo URL untuk akses dari device lain:
    echo   http://%CURRENT_IP%/nurani/public
    echo.
) else (
    echo.
    echo ========================================
    echo   ❌ GAGAL! Perlu hak Administrator
    echo ========================================
    echo.
    echo CARA ALTERNATIF (Manual):
    echo   1. Klik kanan ikon WiFi di taskbar
    echo   2. Open Network ^& Internet settings
    echo   3. Change adapter options
    echo   4. Klik kanan WiFi → Properties
    echo   5. Internet Protocol Version 4 (TCP/IPv4) → Properties
    echo   6. Use the following IP address
    echo   7. Isi:
    echo      - IP address: %CURRENT_IP%
    echo      - Subnet mask: %SUBNET_MASK%
    echo      - Default gateway: %GATEWAY%
    echo   8. OK → OK
    echo.
)

echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

