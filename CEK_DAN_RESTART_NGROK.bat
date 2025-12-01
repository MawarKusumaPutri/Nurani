@echo off
chcp 65001 >nul
title Cek dan Restart Ngrok - Solusi Error ERR_NGROK_3200
color 0B

echo.
echo ========================================
echo   CEK DAN RESTART NGROK
echo   Solusi Error ERR_NGROK_3200
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

:: Check if ngrok is running
echo ========================================
echo   CEK STATUS NGROK
echo ========================================
echo.

tasklist /FI "IMAGENAME eq ngrok.exe" 2>NUL | find /I /N "ngrok.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✅ Ngrok sedang berjalan
    echo.
    echo ⚠️  CATATAN:
    echo    - Jika masih error, mungkin URL yang digunakan salah
    echo    - Pastikan URL bukan contoh (abc123.ngrok.io)
    echo    - URL asli muncul di jendela ngrok
    echo.
    set /p RESTART="Restart ngrok? (Y/N): "
    if /i not "%RESTART%"=="Y" (
        echo.
        echo ========================================
        echo   CARA DAPAT URL YANG BENAR:
        echo ========================================
        echo.
        echo ⚠️  PENTING: Jangan copy contoh di bawah ini!
        echo    Contoh hanya untuk penjelasan format.
        echo.
        echo LANGKAH:
        echo 1. Lihat jendela ngrok yang terbuka (bukan script ini!)
        echo 2. Cari baris "Forwarding" di jendela ngrok
        echo 3. Copy URL yang BENAR-BENAR muncul di baris "Forwarding"
        echo    (Bukan contoh di bawah ini!)
        echo.
        echo CONTOH FORMAT (hanya untuk penjelasan):
        echo    Di jendela ngrok akan muncul seperti:
        echo    Forwarding    https://xyz789.ngrok.io -^> http://localhost:80
        echo.
        echo    Yang harus di-copy: https://xyz789.ngrok.io
        echo    (Ganti xyz789.ngrok.io dengan URL asli dari jendela ngrok!)
        echo.
        echo    URL lengkap untuk akses:
        echo    https://xyz789.ngrok.io/nurani/public
        echo    (Ganti xyz789.ngrok.io dengan URL asli Anda!)
        echo.
        pause
        exit /b 0
    )
    
    echo.
    echo [INFO] Menghentikan ngrok yang sedang berjalan...
    taskkill /F /IM ngrok.exe >nul 2>&1
    timeout /t 2 >nul
    echo ✅ Ngrok dihentikan
    echo.
) else (
    echo ❌ Ngrok tidak berjalan!
    echo    Ini penyebab error ERR_NGROK_3200
    echo.
)

:: Check Apache
echo ========================================
echo   CEK APACHE
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

:: Restart ngrok
echo ========================================
echo   JALANKAN NGROK LAGI
echo ========================================
echo.

echo [INFO] Menjalankan ngrok...
echo.
echo ⚠️  PENTING:
echo    - Akan muncul jendela ngrok baru
echo    - Di jendela ngrok, cari baris "Forwarding"
echo    - Copy URL yang BENAR-BENAR muncul di baris "Forwarding"
echo    - Contoh format: https://xyz789.ngrok.io
echo      (Tapi jangan copy contoh ini! Copy dari jendela ngrok!)
echo    - URL lengkap: https://URL_ASLI_ANDA/nurani/public
echo    - Jangan tutup jendela ngrok!
echo.

:: Start ngrok in new window
start "Ngrok Tunnel - JANGAN TUTUP!" %NGROK_PATH% http 80

:: Wait a bit for ngrok to start
timeout /t 3 >nul

echo.
echo ========================================
echo   ✅ NGROK SUDAH BERJALAN!
echo ========================================
echo.
echo ⚠️  LANGKAH MENDAPATKAN URL YANG BENAR:
echo.
echo 1. Lihat jendela ngrok yang baru terbuka (bukan script ini!)
echo 2. Di jendela ngrok, cari baris "Forwarding"
echo 3. Di baris "Forwarding" akan ada URL seperti:
echo    Forwarding    https://abc-def-123.ngrok-free.app -^> http://localhost:80
echo.
echo 4. ⚠️  COPY URL YANG BENAR-BENAR MUNCUL DI JENDELA NGROK!
echo    (Bukan contoh xyz789.ngrok.io di atas!)
echo    (Bukan contoh abc123.ngrok.io!)
echo    PENTING: Copy hanya URL ngrok (TANPA /nurani/public)!
echo.
echo 5. URL yang Anda copy akan berbeda, contoh:
echo    https://abc-def-123.ngrok-free.app
echo    atau
echo    https://xyz-789-456.ngrok.io
echo    (Tergantung URL yang muncul di jendela ngrok Anda!)
echo    PENTING: URL di jendela ngrok TIDAK termasuk /nurani/public!
echo.
echo ========================================
echo   CARA PAKAI URL YANG BENAR:
echo ========================================
echo.
echo ❌ SALAH: Copy contoh dari script ini
echo    Contoh: https://xyz789.ngrok.io (SALAH!)
echo    Contoh: https://abc123.ngrok.io (SALAH!)
echo.
echo ✅ BENAR: Copy URL dari jendela ngrok (baris "Forwarding")
echo    Contoh: https://abc-def-123.ngrok-free.app (BENAR jika muncul di ngrok!)
echo    Contoh: https://xyz-789-456.ngrok.io (BENAR jika muncul di ngrok!)
echo.
echo ✅ URL lengkap untuk akses:
echo    https://URL_ASLI_DARI_NGROK/nurani/public
echo    (Ganti URL_ASLI_DARI_NGROK dengan URL yang Anda copy!)
echo.
echo ========================================
echo   LANGKAH SELANJUTNYA:
echo ========================================
echo.
echo 1. Copy URL dari baris "Forwarding" di jendela ngrok
echo 2. Tambahkan /nurani/public
echo 3. Test di browser: https://URL_NGROK_ANDA/nurani/public
echo 4. Jika berhasil, share ke device lain
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

