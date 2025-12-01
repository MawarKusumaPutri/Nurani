@echo off
chcp 65001 >nul
title Setup Semua Sekaligus - FULL OTOMATIS!
color 0A

echo.
echo ========================================
echo   SETUP SEMUA SEKALIGUS - FULL OTOMATIS!
echo ========================================
echo.
echo Script ini akan otomatis setup:
echo   1. Static IP Address
echo   2. Firewall (Port 80)
echo   3. Cek Apache
echo.
echo TIDAK PERLU SETTING MANUAL!
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo ========================================
echo   LANGKAH 1: SETUP STATIC IP
echo ========================================
echo.

call "SETUP_IP_OTOMATIS_ADMIN.bat"

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ⚠️ Setup Static IP gagal atau dibatalkan.
    echo.
    set /p CONTINUE="Lanjut ke setup firewall? (Y/N): "
    if /i not "%CONTINUE%"=="Y" (
        echo Setup dibatalkan.
        pause
        exit /b 1
    )
)

echo.
echo ========================================
echo   LANGKAH 2: SETUP FIREWALL
echo ========================================
echo.

call "SETUP_FIREWALL_OTOMATIS.bat"

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ⚠️ Setup Firewall gagal atau dibatalkan.
    echo.
)

echo.
echo ========================================
echo   LANGKAH 3: CEK APACHE
echo ========================================
echo.

tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✅ Apache: Berjalan (Running)
) else (
    echo ❌ Apache: Tidak berjalan
    echo.
    echo ⚠️ PERLU TINDAKAN MANUAL:
    echo    1. Buka XAMPP Control Panel
    echo    2. Klik "Start" pada Apache
    echo    3. Pastikan status menjadi "Running" (hijau)
    echo.
)

echo.
echo ========================================
echo   LANGKAH 4: CEK SEMUA
echo ========================================
echo.

call "CEK_SEMUA_SEKALIGUS.bat"

echo.
echo ========================================
echo   SETUP SELESAI!
echo ========================================
echo.
echo Langkah selanjutnya:
echo   1. Pastikan Apache Running (jika belum)
echo   2. Pastikan device lain dalam WiFi yang sama
echo   3. Test dari device lain:
echo      http://[IP_ADDRESS]/nurani/public
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

