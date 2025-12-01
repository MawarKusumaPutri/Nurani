@echo off
chcp 65001 >nul
title Setup Ngrok - Akses Tanpa WiFi Sama (GRATIS!)
color 0B

echo.
echo ========================================
echo   SETUP NGROK - AKSES TANPA WIFI SAMA
echo ========================================
echo.
echo Ngrok akan membuat aplikasi Anda bisa diakses
echo dari internet tanpa perlu WiFi yang sama!
echo.
echo ✅ GRATIS untuk testing
echo ✅ Tidak perlu WiFi sama
echo ✅ Bisa diakses dari mana saja
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo ========================================
echo   LANGKAH 1: CEK NGROK
echo ========================================
echo.

where ngrok >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✅ Ngrok sudah terinstall!
    goto :ngrok_ready
) else (
    echo ❌ Ngrok belum terinstall
    echo.
    echo ========================================
    echo   CARA INSTALL NGROK:
    echo ========================================
    echo.
    echo 1. Buka browser, kunjungi: https://ngrok.com
    echo 2. Daftar akun (gratis)
    echo 3. Download ngrok untuk Windows
    echo 4. Extract file ngrok.exe
    echo 5. Simpan di folder (contoh: C:\ngrok\)
    echo 6. Tambahkan ke PATH atau simpan di folder ini
    echo.
    echo Atau:
    echo 1. Download ngrok.exe
    echo 2. Simpan di folder project ini
    echo 3. Jalankan script ini lagi
    echo.
    set /p CONTINUE="Sudah install ngrok? (Y/N): "
    if /i not "%CONTINUE%"=="Y" (
        echo.
        echo Setup dibatalkan.
        echo Install ngrok dulu, lalu jalankan script ini lagi.
        pause
        exit /b 0
    )
)

:ngrok_ready
echo.
echo ========================================
echo   LANGKAH 2: CEK APACHE
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
)

echo.
echo ========================================
echo   LANGKAH 3: SETUP NGROK
echo ========================================
echo.

:: Check if ngrok.exe exists in current directory
if exist "ngrok.exe" (
    set NGROK_PATH=ngrok.exe
    echo ✅ Ngrok ditemukan di folder ini
) else (
    :: Try to find ngrok in PATH
    where ngrok >nul 2>&1
    if %ERRORLEVEL% EQU 0 (
        set NGROK_PATH=ngrok
        echo ✅ Ngrok ditemukan di PATH
    ) else (
        echo ❌ Ngrok tidak ditemukan!
        echo.
        echo Solusi:
        echo   1. Download ngrok.exe dari https://ngrok.com
        echo   2. Simpan di folder ini: %CD%
        echo   3. Jalankan script ini lagi
        echo.
        pause
        exit /b 1
    )
)

echo.
echo ========================================
echo   LANGKAH 4: JALANKAN NGROK
echo ========================================
echo.

echo [INFO] Menjalankan ngrok...
echo.
echo ⚠️  CATATAN:
echo    - Ngrok akan expose port 80 ke internet
echo    - Akan muncul URL publik (contoh: https://abc123.ngrok.io)
echo    - URL ini bisa diakses dari mana saja!
echo    - Tekan Ctrl+C untuk stop ngrok
echo.
echo ========================================
echo.

:: Check if ngrok is already running
tasklist /FI "IMAGENAME eq ngrok.exe" 2>NUL | find /I /N "ngrok.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ⚠️  Ngrok sudah berjalan!
    echo    Hentikan dulu, lalu jalankan script ini lagi.
    echo.
    pause
    exit /b 0
)

:: Start ngrok
start "Ngrok Tunnel" %NGROK_PATH% http 80

echo.
echo ========================================
echo   ✅ NGROK SUDAH BERJALAN!
echo ========================================
echo.
echo 1. Lihat jendela ngrok yang baru terbuka
echo 2. Cari baris "Forwarding" → ada URL seperti:
echo    https://abc123.ngrok.io
echo 3. URL tersebut bisa diakses dari mana saja!
echo.
echo ========================================
echo   CARA PAKAI:
echo ========================================
echo.
echo Dari device lain (smartphone/laptop):
echo   1. Buka browser
echo   2. Ketik URL ngrok (dari jendela ngrok)
echo   3. Tambahkan: /nurani/public
echo   4. Contoh: https://abc123.ngrok.io/nurani/public
echo   5. Tekan Enter
echo   6. Website akan muncul! ✅
echo.
echo ========================================
echo   CATATAN:
echo ========================================
echo.
echo ⚠️  URL ngrok akan berubah setiap restart
echo    (kecuali pakai plan berbayar)
echo.
echo ⚠️  Untuk stop ngrok:
echo    - Tutup jendela ngrok
echo    - Atau tekan Ctrl+C di jendela ngrok
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

