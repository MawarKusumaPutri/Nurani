@echo off
chcp 65001 >nul
title Jalankan Ngrok di Terminal - Lihat URL Langsung
color 0B

echo.
echo ========================================
echo   JALANKAN NGROK DI TERMINAL
echo   (Lihat URL Langsung)
echo ========================================
echo.

:: Check if ngrok.exe exists
if exist "ngrok.exe" (
    set NGROK_PATH=ngrok.exe
    goto :ngrok_found
)

where ngrok >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    set NGROK_PATH=ngrok
    goto :ngrok_found
)

echo ❌ Ngrok tidak ditemukan!
echo.
echo Jalankan: SETUP_NGROK_LENGKAP.bat dulu
pause
exit /b 1

:ngrok_found
echo ✅ Ngrok ditemukan
echo.

:: Check if ngrok is already running
tasklist /FI "IMAGENAME eq ngrok.exe" 2>NUL | find /I /N "ngrok.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ⚠️  Ngrok sudah berjalan!
    echo.
    set /p RESTART="Hentikan dan restart ngrok? (Y/N): "
    if /i "%RESTART%"=="Y" (
        echo [INFO] Menghentikan ngrok yang sedang berjalan...
        taskkill /F /IM ngrok.exe >nul 2>&1
        timeout /t 2 >nul
        echo ✅ Ngrok dihentikan
        echo.
    ) else (
        echo Setup dibatalkan.
        echo Ngrok sudah berjalan, gunakan URL yang sudah ada.
        pause
        exit /b 0
    )
)

:: Check Apache
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
    
    :: Check again
    tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
    if "%ERRORLEVEL%" NEQ "0" (
        echo ❌ Apache masih tidak berjalan!
        echo    Pastikan Apache Running di XAMPP.
        pause
        exit /b 1
    )
)

echo ✅ Apache sudah berjalan (Running)
echo.

echo ========================================
echo   MENJALANKAN NGROK DI TERMINAL
echo ========================================
echo.
echo ⚠️  PENTING:
echo    - Akan membuka terminal baru
echo    - Di terminal akan muncul output ngrok
echo    - Cari baris "Forwarding" → ada URL seperti:
echo      https://abc-def-123.ngrok-free.app
echo    - CATAT URL tersebut!
echo    - Jangan tutup terminal!
echo.
echo ========================================
echo   CARA MENDAPATKAN URL:
echo ========================================
echo.
echo 1. Lihat terminal yang baru terbuka
echo 2. Cari baris "Forwarding"
echo 3. Copy URL dari baris "Forwarding" (bagian kiri, sebelum ->)
echo 4. Contoh: https://abc-def-123.ngrok-free.app
echo 5. Tambahkan /nurani/public di AKHIR
echo 6. Test di browser: https://URL_NGROK_ANDA/nurani/public
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menjalankan ngrok...
pause >nul

echo.
echo [INFO] Menjalankan ngrok di terminal...
echo.

:: Start ngrok in new terminal window
start "Ngrok - Lihat URL di Terminal Ini!" cmd /k "%NGROK_PATH% http 80"

echo.
echo ========================================
echo   ✅ NGROK SUDAH BERJALAN!
echo ========================================
echo.
echo 1. Lihat terminal yang baru terbuka
echo 2. Cari baris "Forwarding"
echo 3. Copy URL dari baris "Forwarding"
echo 4. Tambahkan /nurani/public
echo 5. Test di browser
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

