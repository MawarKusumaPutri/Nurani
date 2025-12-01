@echo off
chcp 65001 >nul
title Setup IP Address - OTOMATIS (Run as Admin)
color 0B

:: This script will request admin rights automatically
>nul 2>&1 "%SYSTEMROOT%\system32\cacls.exe" "%SYSTEMROOT%\system32\config\system"

if '%errorlevel%' NEQ '0' (
    echo.
    echo ========================================
    echo   MEMINTA HAK ADMINISTRATOR...
    echo ========================================
    echo.
    echo Script akan meminta hak administrator.
    echo Klik "Yes" jika muncul pop-up UAC.
    echo.
    goto UACPrompt
) else ( goto gotAdmin )

:UACPrompt
    echo Set UAC = CreateObject^("Shell.Application"^) > "%temp%\getadmin.vbs"
    echo UAC.ShellExecute "%~s0", "", "", "runas", 1 >> "%temp%\getadmin.vbs"
    "%temp%\getadmin.vbs"
    del "%temp%\getadmin.vbs"
    exit /B

:gotAdmin
    if exist "%temp%\getadmin.vbs" ( del "%temp%\getadmin.vbs" )
    pushd "%CD%"
    CD /D "%~dp0"

echo.
echo ========================================
echo   SETUP IP ADDRESS - FULL OTOMATIS!
echo ========================================
echo.
echo ✅ Hak administrator sudah didapat!
echo.
echo Script akan otomatis setup static IP...
echo TIDAK PERLU KLIK MANUAL SAMA SEKALI!
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo [STEP 1] Mencari informasi network...
echo.

:: Get adapter name (Wi-Fi)
set ADAPTER_NAME=
for /f "tokens=*" %%a in ('netsh interface show interface ^| findstr /i "Wi-Fi"') do (
    set ADAPTER_LINE=%%a
    for /f "tokens=3*" %%b in ("%%a") do set ADAPTER_NAME=%%b %%c
    set ADAPTER_NAME=!ADAPTER_NAME: =!
    if not "!ADAPTER_NAME!"=="" goto :found_adapter
)

:: If Wi-Fi not found, try to find any connected adapter
for /f "tokens=*" %%a in ('netsh interface show interface ^| findstr /i "Connected"') do (
    set ADAPTER_LINE=%%a
    for /f "tokens=3*" %%b in ("%%a") do set ADAPTER_NAME=%%b %%c
    set ADAPTER_NAME=!ADAPTER_NAME: =!
    if not "!ADAPTER_NAME!"=="" goto :found_adapter
)

echo [ERROR] Adapter tidak ditemukan!
pause
exit /b 1

:found_adapter
echo [INFO] Adapter ditemukan: %ADAPTER_NAME%

:: Get current IP configuration
set CURRENT_IP=
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4 Address"') do (
    set CURRENT_IP=%%a
    set CURRENT_IP=!CURRENT_IP: =!
    if not "!CURRENT_IP!"=="" goto :found_ip
)

:found_ip
if "%CURRENT_IP%"=="" (
    echo [ERROR] IP address tidak ditemukan!
    pause
    exit /b 1
)
echo [INFO] IP Address saat ini: %CURRENT_IP%

:: Get Subnet Mask
set SUBNET_MASK=
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "Subnet Mask"') do (
    set SUBNET_MASK=%%a
    set SUBNET_MASK=!SUBNET_MASK: =!
    if not "!SUBNET_MASK!"=="" goto :found_mask
)
:found_mask
if "%SUBNET_MASK%"=="" set SUBNET_MASK=255.255.255.0
echo [INFO] Subnet Mask: %SUBNET_MASK%

:: Get Default Gateway
set GATEWAY=
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "Default Gateway"') do (
    set GATEWAY=%%a
    set GATEWAY=!GATEWAY: =!
    if not "!GATEWAY!"=="" if not "!GATEWAY!"=="-" goto :found_gateway
)
:found_gateway
if "%GATEWAY%"=="" (
    :: Try to guess gateway from IP (usually .1)
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
netsh interface ip set address name="%ADAPTER_NAME%" static %CURRENT_IP% %SUBNET_MASK% %GATEWAY%

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
    echo   SELESAI! TIDAK PERLU SETTING LAGI!
    echo ========================================
    echo.
) else (
    echo.
    echo ========================================
    echo   ❌ GAGAL! Ada masalah saat setup.
    echo ========================================
    echo.
    echo Coba jalankan script ini lagi.
    echo.
)

echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

