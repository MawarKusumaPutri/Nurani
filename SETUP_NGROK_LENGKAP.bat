@echo off
chcp 65001 >nul
title Setup Ngrok Lengkap - WiFi Beda (GRATIS!)
color 0B

echo.
echo ========================================
echo   SETUP NGROK - WIFI TIDAK BISA SAMA
echo ========================================
echo.
echo Solusi untuk WiFi berbeda (marina345)
echo Device lain bisa akses via internet!
echo.
echo ✅ GRATIS untuk testing
echo ✅ Tidak perlu WiFi sama
echo ✅ Device lain pakai internet mereka sendiri
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo ========================================
echo   LANGKAH 1: CEK NGROK
echo ========================================
echo.

:: Check if ngrok.exe exists in current directory
if exist "ngrok.exe" (
    set NGROK_PATH=ngrok.exe
    echo ✅ Ngrok ditemukan di folder ini
    goto :ngrok_found
)

:: Try to find ngrok in PATH
where ngrok >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    set NGROK_PATH=ngrok
    echo ✅ Ngrok ditemukan di PATH
    goto :ngrok_found
)

:: Ngrok not found
echo ❌ Ngrok belum terinstall
echo.
echo ========================================
echo   CARA INSTALL NGROK (GRATIS):
echo ========================================
echo.
echo 1. Buka browser, kunjungi: https://ngrok.com
echo 2. Klik "Sign up" (gratis)
echo 3. Daftar dengan email
echo 4. Login ke dashboard
echo 5. Klik "Download" → Pilih "Windows"
echo 6. Download ngrok.zip
echo 7. Extract ngrok.exe
echo 8. Simpan ngrok.exe di folder ini:
echo    %CD%
echo.
echo Atau:
echo 1. Download ngrok.exe
echo 2. Copy ke folder ini: %CD%
echo 3. Jalankan script ini lagi
echo.
set /p CONTINUE="Sudah download ngrok.exe? (Y/N): "
if /i not "%CONTINUE%"=="Y" (
    echo.
    echo Setup dibatalkan.
    echo Download ngrok.exe dulu, lalu jalankan script ini lagi.
    pause
    exit /b 0
)

:: Check again after user confirmation
if exist "ngrok.exe" (
    set NGROK_PATH=ngrok.exe
    echo ✅ Ngrok ditemukan!
    goto :ngrok_found
) else (
    echo ❌ Ngrok masih belum ditemukan di folder ini.
    echo    Pastikan ngrok.exe ada di: %CD%
    pause
    exit /b 1
)

:ngrok_found
echo.
echo ========================================
echo   LANGKAH 2: CEK AUTHTOKEN
echo ========================================
echo.

:: Check if authtoken is configured
%NGROK_PATH% config check >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✅ Authtoken sudah dikonfigurasi
    goto :authtoken_ready
) else (
    echo ❌ Authtoken belum dikonfigurasi
    echo.
    echo ========================================
    echo   CARA DAPATKAN AUTHTOKEN:
    echo ========================================
    echo.
    echo 1. Buka browser, login ke: https://dashboard.ngrok.com
    echo 2. Klik "Your Authtoken" atau "Get Started"
    echo 3. Copy authtoken Anda (contoh: 2abc123...)
    echo 4. Paste di bawah ini
    echo.
    set /p AUTHTOKEN="Masukkan authtoken ngrok Anda: "
    
    if "%AUTHTOKEN%"=="" (
        echo ❌ Authtoken tidak boleh kosong!
        pause
        exit /b 1
    )
    
    echo.
    echo [INFO] Mengkonfigurasi authtoken...
    %NGROK_PATH% config add-authtoken %AUTHTOKEN% >nul 2>&1
    
    if %ERRORLEVEL% EQU 0 (
        echo ✅ Authtoken berhasil dikonfigurasi!
        goto :authtoken_ready
    ) else (
        echo ❌ Gagal mengkonfigurasi authtoken!
        echo    Pastikan authtoken benar.
        pause
        exit /b 1
    )
)

:authtoken_ready
echo.
echo ========================================
echo   LANGKAH 3: CEK APACHE
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
echo ========================================
echo   LANGKAH 4: JALANKAN NGROK
echo ========================================
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
    ) else (
        echo Setup dibatalkan.
        echo Ngrok sudah berjalan, gunakan URL yang sudah ada.
        pause
        exit /b 0
    )
)

echo [INFO] Menjalankan ngrok...
echo.
echo ⚠️  CATATAN:
echo    - Ngrok akan expose port 80 ke internet
echo    - Akan muncul jendela ngrok baru
echo    - Cari baris "Forwarding" → ada URL seperti:
echo      https://abc123.ngrok.io
echo    - URL LENGKAP untuk akses aplikasi:
echo      https://abc123.ngrok.io/nurani/public
echo    - URL ini bisa diakses dari mana saja!
echo    - Jangan tutup jendela ngrok saat device lain akses
echo.
echo ========================================
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
echo 1. Lihat jendela ngrok yang baru terbuka
echo 2. Cari baris "Forwarding" → ada URL seperti:
echo    https://abc123.ngrok.io
echo 3. CATAT URL tersebut!
echo.
echo ⚠️  PENTING: URL di atas adalah URL ngrok saja
echo    Untuk akses aplikasi, tambahkan: /nurani/public
echo    Contoh: https://abc123.ngrok.io/nurani/public
echo.
echo ========================================
echo   CARA AKSES DARI DEVICE LAIN:
echo ========================================
echo.
echo Dari smartphone/laptop lain:
echo   1. Pastikan device terhubung ke internet
echo      (WiFi/data mereka sendiri, TIDAK perlu WiFi sama!)
echo   2. Buka browser
echo   3. Ketik URL ngrok + /nurani/public
echo      Contoh: https://abc123.ngrok.io/nurani/public
echo   4. Tekan Enter
echo   5. Website akan muncul! ✅
echo.
echo ========================================
echo   CONTOH URL LENGKAP:
echo ========================================
echo.
echo Jika URL ngrok: https://abc123.ngrok.io
echo Maka akses: https://abc123.ngrok.io/nurani/public
echo.
echo ========================================
echo   CATATAN PENTING:
echo ========================================
echo.
echo ⚠️  URL ngrok akan berubah setiap restart
echo    (kecuali pakai plan berbayar)
echo.
echo ⚠️  JANGAN TUTUP jendela ngrok saat device lain akses
echo    Jika ngrok mati, URL tidak bisa diakses
echo.
echo ⚠️  Semua device harus terhubung ke internet
echo    - Laptop ini: WiFi marina345 (terhubung internet)
echo    - Device lain: WiFi/data mereka sendiri (terhubung internet)
echo    - TIDAK perlu WiFi sama!
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

