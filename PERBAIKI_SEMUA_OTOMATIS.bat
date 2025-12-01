@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion
title Perbaiki Semua Otomatis - Hapus Tanda Merah!
color 0A

echo.
echo ========================================
echo   PERBAIKI SEMUA OTOMATIS
echo ========================================
echo.
echo Script ini akan otomatis memperbaiki semua
echo yang masih ❌ (merah) di CEK_SEMUA_SEKALIGUS.bat
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo ========================================
echo   LANGKAH 1: CEK STATUS SAAT INI
echo ========================================
echo.

call "CEK_SEMUA_SEKALIGUS.bat"

echo.
echo ========================================
echo   LANGKAH 2: PERBAIKI YANG MASIH ❌
echo ========================================
echo.

:: Check IP
set CURRENT_IP=
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4 Address"') do (
    set CURRENT_IP=%%a
    set CURRENT_IP=!CURRENT_IP: =!
    if not "!CURRENT_IP!"=="" goto :found_ip_check
)

:found_ip_check
if "%CURRENT_IP%"=="" (
    echo [PERBAIKI] IP Address tidak ditemukan...
    echo → Setup Static IP...
    call "SETUP_IP_OTOMATIS_ADMIN.bat"
    echo.
) else (
    echo ✅ IP Address: %CURRENT_IP% (sudah OK)
)

:: Check Firewall
netsh advfirewall firewall show rule name="XAMPP Apache HTTP" >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    netsh advfirewall firewall show rule name="Apache HTTP Server" >nul 2>&1
    if %ERRORLEVEL% NEQ 0 (
        echo [PERBAIKI] Firewall belum disetup...
        echo → Setup Firewall...
        call "SETUP_FIREWALL_OTOMATIS.bat"
        echo.
    ) else (
        echo ✅ Firewall sudah OK
    )
) else (
    echo ✅ Firewall sudah OK
)

:: Check Apache
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%" NEQ "0" (
    echo [PERBAIKI] Apache tidak berjalan...
    echo.
    echo ⚠️  PERLU TINDAKAN MANUAL:
    echo    1. Buka XAMPP Control Panel
    echo    2. Klik "Start" pada Apache
    echo    3. Pastikan status "Running" (hijau)
    echo.
    echo Tekan tombol apapun setelah Apache Running...
    pause >nul
) else (
    echo ✅ Apache sudah berjalan
)

echo.
echo ========================================
echo   LANGKAH 3: CEK ULANG
echo ========================================
echo.

call "CEK_SEMUA_SEKALIGUS.bat"

echo.
echo ========================================
echo   SELESAI!
echo ========================================
echo.
echo Jika masih ada ❌, ikuti solusi yang ditampilkan.
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

