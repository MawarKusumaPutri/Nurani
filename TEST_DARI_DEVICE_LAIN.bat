@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion
title Test dari Device Lain - Panduan Lengkap
color 0B

echo.
echo ========================================
echo   TEST DARI DEVICE LAIN - PANDUAN LENGKAP
echo ========================================
echo.
echo Script ini akan membantu Anda test
echo apakah aplikasi sudah bisa diakses dari device lain.
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
echo   LANGKAH 2: AMBIL IP ADDRESS
echo ========================================
echo.

set CURRENT_IP=
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4 Address"') do (
    set CURRENT_IP=%%a
    set CURRENT_IP=!CURRENT_IP: =!
    if not "!CURRENT_IP!"=="" goto :found_ip_display
)

:found_ip_display
if "%CURRENT_IP%"=="" (
    echo ❌ IP Address tidak ditemukan!
    echo.
    echo Solusi:
    echo   1. Pastikan WiFi/Ethernet terhubung
    echo   2. Jalankan: SETUP_IP_OTOMATIS_ADMIN.bat
    echo.
    pause
    exit /b 1
) else (
    echo ✅ IP Address Anda: %CURRENT_IP%
    echo.
)

echo ========================================
echo   LANGKAH 3: PASTIKAN APACHE RUNNING
echo ========================================
echo.

tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%" NEQ "0" (
    echo ❌ Apache tidak berjalan!
    echo.
    echo ⚠️  PERLU TINDAKAN:
    echo    1. Buka XAMPP Control Panel
    echo    2. Klik "Start" pada Apache
    echo    3. Pastikan status "Running" (hijau)
    echo.
    echo Tekan tombol apapun setelah Apache Running...
    pause >nul
) else (
    echo ✅ Apache sudah berjalan (Running)
    echo.
)

echo ========================================
echo   LANGKAH 4: PASTIKAN WIFI SAMA
echo ========================================
echo.

echo ⚠️  PERLU DICEK MANUAL:
echo.
echo Di Laptop Server ini:
echo   → WiFi: (lihat di taskbar)
echo.
echo Di Device Lain (Smartphone/Laptop):
echo   → Settings → Wi-Fi
echo   → Pastikan WiFi SAMA dengan laptop server
echo.
echo ⚠️  PENTING: Semua device harus dalam WiFi yang sama!
echo.
pause

echo.
echo ========================================
echo   LANGKAH 5: TEST DARI DEVICE LAIN
echo ========================================
echo.

echo URL untuk akses dari device lain:
echo.
echo   http://%CURRENT_IP%/nurani/public
echo.
echo ========================================
echo   CARA TEST:
echo ========================================
echo.
echo DARI SMARTPHONE:
echo   1. Pastikan WiFi sama dengan laptop server
echo   2. Buka browser (Chrome, Safari, dll)
echo   3. Ketik di address bar:
echo      http://%CURRENT_IP%/nurani/public
echo   4. Tekan Enter atau Go
echo   5. Jika website muncul → BERHASIL! ✅
echo.
echo DARI LAPTOP LAIN:
echo   1. Pastikan WiFi sama dengan laptop server
echo   2. Buka browser (Chrome, Firefox, Edge)
echo   3. Ketik di address bar:
echo      http://%CURRENT_IP%/nurani/public
echo   4. Tekan Enter
echo   5. Jika website muncul → BERHASIL! ✅
echo.
echo ========================================
echo   TROUBLESHOOTING:
echo ========================================
echo.
echo Jika error "This site can't be reached":
echo   → Pastikan Apache Running
echo   → Pastikan WiFi sama
echo   → Jalankan: SETUP_FIREWALL_OTOMATIS.bat
echo.
echo Jika error "Connection timeout":
echo   → Jalankan: SETUP_FIREWALL_OTOMATIS.bat
echo.
echo Jika error "403 Forbidden":
echo   → Restart Apache di XAMPP
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

