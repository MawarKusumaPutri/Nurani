@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion
title Cek Semua - Apakah Sudah Bisa Dipakai?
color 0E

echo.
echo ========================================
echo   CEK: APAKAH SUDAH BISA DIPAKAI?
echo ========================================
echo.
echo Script ini akan mengecek semua yang diperlukan
echo agar aplikasi bisa diakses dari device lain.
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo ========================================
echo   CEK 1: STATIC IP ADDRESS
echo ========================================
echo.

set CURRENT_IP=
set IP_FOUND=0

for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4 Address"') do (
    set CURRENT_IP=%%a
    set CURRENT_IP=!CURRENT_IP: =!
    if not "!CURRENT_IP!"=="" (
        set IP_FOUND=1
        goto :found_ip
    )
)

:found_ip
if "%IP_FOUND%"=="0" (
    echo ❌ IP Address tidak ditemukan!
    echo    → Pastikan WiFi/Ethernet terhubung
    set IP_STATUS=FAIL
) else (
    echo ✅ IP Address: %CURRENT_IP%
    echo ✅ IP address ditemukan
    echo ⚠️  Catatan: Static IP perlu disetup agar tidak berubah
    echo    → Jika belum, jalankan: SETUP_IP_OTOMATIS_ADMIN.bat
    set IP_STATUS=OK
)

echo.
echo ========================================
echo   CEK 2: FIREWALL
echo ========================================
echo.

set FIREWALL_OK=0

:: Check for port 80 rule (multiple methods)
netsh advfirewall firewall show rule name="XAMPP Apache HTTP" >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✅ Firewall: Port 80 sudah diizinkan
    set FIREWALL_OK=1
    set FIREWALL_STATUS=OK
) else (
    :: Check for Apache HTTP Server rule
    netsh advfirewall firewall show rule name="Apache HTTP Server" >nul 2>&1
    if %ERRORLEVEL% EQU 0 (
        echo ✅ Firewall: Apache sudah diizinkan
        set FIREWALL_OK=1
        set FIREWALL_STATUS=OK
    ) else (
        :: Check if port 80 is open in any rule
        netsh advfirewall firewall show rule dir=in | findstr /i "80.*TCP.*Allow" >nul 2>&1
        if %ERRORLEVEL% EQU 0 (
            echo ✅ Firewall: Port 80 sudah diizinkan (ada rule lain)
            set FIREWALL_OK=1
            set FIREWALL_STATUS=OK
        ) else (
            echo ⚠️  Firewall: Port 80 mungkin belum diizinkan
            echo    → Untuk memastikan, jalankan: SETUP_FIREWALL_OTOMATIS.bat
            echo    → Atau klik kanan → Run as administrator
            set FIREWALL_OK=0
            set FIREWALL_STATUS=WARNING
        )
    )
)

:: FIREWALL_STATUS already set above

echo.
echo ========================================
echo   CEK 3: APACHE XAMPP
echo ========================================
echo.

set APACHE_OK=0

tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✅ Apache: Berjalan (Running)
    set APACHE_OK=1
    set APACHE_STATUS=OK
) else (
    echo ❌ Apache: Tidak berjalan
    echo    → Buka XAMPP Control Panel
    echo    → Klik "Start" pada Apache
    echo    → Pastikan status menjadi "Running" (hijau)
    set APACHE_OK=0
    set APACHE_STATUS=FAIL
)

echo.
echo ========================================
echo   CEK 4: WIFI
echo ========================================
echo.

echo ⚠️ WiFi: Perlu dicek manual
echo    → Pastikan semua device dalam WiFi yang sama
echo    → Nama WiFi harus sama di semua device

echo.
echo ========================================
echo   HASIL CEK LENGKAP
echo ========================================
echo.

set ALL_OK=1

:: Check IP
if "%IP_STATUS%"=="FAIL" (
    echo ❌ IP Address: Tidak ditemukan
    set ALL_OK=0
) else (
    echo ✅ IP Address: %CURRENT_IP%
)

:: Check Firewall
if "%FIREWALL_STATUS%"=="FAIL" (
    echo ❌ Firewall: Belum disetup
    set ALL_OK=0
) else if "%FIREWALL_STATUS%"=="WARNING" (
    echo ⚠️  Firewall: Perlu dicek (jalankan SETUP_FIREWALL_OTOMATIS.bat untuk memastikan)
    set ALL_OK=0
) else (
    echo ✅ Firewall: Port 80 sudah diizinkan
)

:: Check Apache
if "%APACHE_STATUS%"=="FAIL" (
    echo ❌ Apache: Tidak berjalan
    set ALL_OK=0
) else (
    echo ✅ Apache: Berjalan (Running)
)

:: Check WiFi (manual)
echo ⚠️  WiFi: Perlu dicek manual (pastikan semua device dalam WiFi yang sama)

echo.
if "%ALL_OK%"=="1" (
    if "%CURRENT_IP%"=="" (
        echo ========================================
        echo   ⚠️ HAMPIR SIAP, TAPI IP TIDAK DITEMUKAN
        echo ========================================
        echo.
        echo Firewall dan Apache sudah OK!
        echo Tapi IP address tidak ditemukan.
        echo.
        echo Solusi:
        echo   1. Pastikan WiFi/Ethernet terhubung
        echo   2. Jalankan: SETUP_IP_OTOMATIS_ADMIN.bat
        echo   3. Cek lagi dengan script ini
        echo.
    ) else (
        echo ========================================
        echo   ✅ SEMUA SUDAH SIAP!
        echo ========================================
        echo.
        echo Aplikasi sudah bisa diakses dari device lain!
        echo.
        echo URL untuk akses:
        echo   http://%CURRENT_IP%/nurani/public
        echo.
        echo Pastikan device lain dalam WiFi yang sama!
        echo.
        echo ========================================
        echo   CARA TEST:
        echo ========================================
        echo.
        echo 1. Dari smartphone/laptop lain:
        echo    - Pastikan WiFi sama dengan laptop ini
        echo    - Buka browser
        echo    - Ketik: http://%CURRENT_IP%/nurani/public
        echo    - Tekan Enter
        echo.
        echo 2. Jika website muncul → BERHASIL! ✅
        echo    Jika error → Lihat troubleshooting di bawah
        echo.
    )
) else (
    echo ========================================
    echo   ⚠️ MASIH ADA YANG PERLU DISETUP
    echo ========================================
    echo.
    echo Perbaiki yang masih ❌ (merah) di atas.
    echo.
    echo ========================================
    echo   SOLUSI CEPAT:
    echo ========================================
    echo.
    if "%IP_STATUS%"=="FAIL" (
        echo 1. Setup Static IP:
        echo    → Double-click: SETUP_IP_OTOMATIS_ADMIN.bat
        echo    → Klik "Yes" jika muncul pop-up
        echo.
    )
    if "%FIREWALL_STATUS%"=="FAIL" (
        echo 2. Setup Firewall:
        echo    → Double-click: SETUP_FIREWALL_OTOMATIS.bat
        echo    → Klik "Yes" jika muncul pop-up
        echo.
    )
    if "%FIREWALL_STATUS%"=="WARNING" (
        echo 2. Setup Firewall (disarankan):
        echo    → Double-click: SETUP_FIREWALL_OTOMATIS.bat
        echo    → Klik "Yes" jika muncul pop-up
        echo    → Ini akan memastikan port 80 benar-benar diizinkan
        echo.
    )
    if "%APACHE_STATUS%"=="FAIL" (
        echo 3. Start Apache:
        echo    → Buka XAMPP Control Panel
        echo    → Klik "Start" pada Apache
        echo    → Pastikan status "Running" (hijau)
        echo.
    )
    echo Setelah semua ✅, jalankan script ini lagi untuk cek ulang.
    echo.
)

echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

