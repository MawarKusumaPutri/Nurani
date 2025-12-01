@echo off
chcp 65001 >nul
title Setup IP Address - FULL OTOMATIS!
color 0A

:: Check if running as administrator
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo.
    echo ========================================
    echo   PERLU HAK ADMINISTRATOR!
    echo ========================================
    echo.
    echo Script ini perlu dijalankan sebagai Administrator.
    echo.
    echo CARA:
    echo   1. Klik kanan pada file ini
    echo   2. Pilih "Run as administrator"
    echo   3. Klik "Yes" jika muncul UAC
    echo.
    pause
    exit /b 1
)

echo.
echo ========================================
echo   SETUP IP ADDRESS - FULL OTOMATIS!
echo ========================================
echo.
echo Script ini akan otomatis:
echo   - Mencari IP address saat ini
echo   - Mencari Subnet Mask dan Gateway
echo   - Mencari nama adapter WiFi
echo   - Setup static IP address
echo.
echo TIDAK PERLU KLIK MANUAL SAMA SEKALI!
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo [STEP 1] Mencari informasi network...
echo.

:: Get adapter name (Wi-Fi)
for /f "tokens=*" %%a in ('netsh interface show interface ^| findstr /i "Wi-Fi"') do (
    set ADAPTER_LINE=%%a
)

:: Extract adapter name
for /f "tokens=3*" %%a in ("%ADAPTER_LINE%") do set ADAPTER_NAME=%%a %%b
set ADAPTER_NAME=%ADAPTER_NAME: =%

if "%ADAPTER_NAME%"=="" (
    echo [ERROR] Adapter Wi-Fi tidak ditemukan!
    echo Mencoba mencari adapter lain...
    for /f "tokens=*" %%a in ('netsh interface show interface ^| findstr /i "Connected"') do (
        set ADAPTER_LINE=%%a
        for /f "tokens=3*" %%b in ("%%a") do set ADAPTER_NAME=%%b %%c
        set ADAPTER_NAME=!ADAPTER_NAME: =!
        goto :found_adapter
    )
    echo [ERROR] Tidak ada adapter yang terhubung!
    pause
    exit /b 1
)

:found_adapter
echo [INFO] Adapter ditemukan: %ADAPTER_NAME%

:: Get current IP configuration
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4 Address"') do (
    set CURRENT_IP=%%a
    set CURRENT_IP=!CURRENT_IP: =!
    goto :found_ip
)

:found_ip
if "%CURRENT_IP%"=="" (
    echo [ERROR] IP address tidak ditemukan!
    pause
    exit /b 1
)

echo [INFO] IP Address saat ini: %CURRENT_IP%

:: Get Subnet Mask
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "Subnet Mask"') do (
    set SUBNET_MASK=%%a
    set SUBNET_MASK=!SUBNET_MASK: =!
    goto :found_mask
)

:found_mask
if "%SUBNET_MASK%"=="" set SUBNET_MASK=255.255.255.0
echo [INFO] Subnet Mask: %SUBNET_MASK%

:: Get Default Gateway
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "Default Gateway"') do (
    set GATEWAY=%%a
    set GATEWAY=!GATEWAY: =!
    if not "!GATEWAY!"=="" goto :found_gateway
)

:found_gateway
if "%GATEWAY%"=="" (
    echo [WARNING] Gateway tidak ditemukan, menggunakan default...
    :: Try to guess gateway from IP
    for /f "tokens=1,2,3 delims=." %%a in ("%CURRENT_IP%") do set GATEWAY=%%a.%%b.%%c.1
)
echo [INFO] Default Gateway: %GATEWAY%

echo.
echo ========================================
echo   KONFIGURASI YANG AKAN DITERAPKAN:
echo ========================================
echo.
echo Adapter      : %ADAPTER_NAME%
echo IP Address   : %CURRENT_IP%
echo Subnet Mask  : %SUBNET_MASK%
echo Gateway      : %GATEWAY%
echo.
echo ========================================
echo.
echo [STEP 2] Menerapkan static IP address...
echo.

:: Set static IP using netsh
netsh interface ip set address name="%ADAPTER_NAME%" static %CURRENT_IP% %SUBNET_MASK% %GATEWAY% >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo   ✅ BERHASIL! IP ADDRESS SUDAH STATIC!
    echo ========================================
    echo.
    echo IP Address Anda sekarang: %CURRENT_IP%
    echo IP ini TIDAK akan berubah lagi!
    echo.
    echo URL untuk akses dari device lain:
    echo   http://%CURRENT_IP%/nurani/public
    echo.
    echo ========================================
    echo   CATATAN:
    echo ========================================
    echo.
    echo ✅ Setup selesai! IP address sudah static.
    echo ✅ Tidak perlu setting manual lagi.
    echo ✅ IP akan tetap %CURRENT_IP% meski reconnect WiFi.
    echo.
) else (
    echo.
    echo ========================================
    echo   ❌ GAGAL! Ada masalah saat setup.
    echo ========================================
    echo.
    echo Mungkin adapter name tidak tepat.
    echo.
    echo Coba jalankan script ini lagi dengan:
    echo   - Run as administrator
    echo   - Pastikan WiFi terhubung
    echo.
)

echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

