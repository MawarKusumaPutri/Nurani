@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion
title Apache Sudah Hijau - Langkah Selanjutnya
color 0A

echo.
echo ========================================
echo   APACHE SUDAH HIJAU - LANGKAH SELANJUTNYA
echo ========================================
echo.
echo ✅ Apache sudah Running (hijau)!
echo    Server web sudah siap.
echo.
echo Sekarang perlu setup agar bisa diakses
echo dari device lain.
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo ========================================
echo   LANGKAH 1: CEK IP ADDRESS
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
    echo    → Pastikan WiFi/Ethernet terhubung
    echo.
    pause
    exit /b 1
) else (
    echo ✅ IP Address Anda: %CURRENT_IP%
    echo.
    echo ⚠️  Catatan: IP ini bisa berubah jika reconnect WiFi
    echo    → Setup static IP agar tidak berubah
    echo.
)

echo ========================================
echo   LANGKAH 2: SETUP STATIC IP (DISARANKAN)
echo ========================================
echo.

set /p SETUP_IP="Setup static IP agar IP tidak berubah? (Y/N): "

if /i "%SETUP_IP%"=="Y" (
    echo.
    echo [INFO] Membuka setup static IP...
    call "SETUP_IP_OTOMATIS_ADMIN.bat"
    echo.
    echo [INFO] Setup static IP selesai!
    echo.
) else (
    echo.
    echo ⚠️  Static IP tidak disetup.
    echo    IP address bisa berubah setiap reconnect WiFi.
    echo    Jika IP berubah, URL untuk akses juga berubah.
    echo.
)

echo ========================================
echo   LANGKAH 3: SETUP FIREWALL (WAJIB!)
echo ========================================
echo.

echo ⚠️  Firewall perlu disetup agar device lain bisa akses!
echo.
set /p SETUP_FIREWALL="Setup firewall sekarang? (Y/N): "

if /i "%SETUP_FIREWALL%"=="Y" (
    echo.
    echo [INFO] Membuka setup firewall...
    call "SETUP_FIREWALL_OTOMATIS.bat"
    echo.
    echo [INFO] Setup firewall selesai!
    echo.
) else (
    echo.
    echo ⚠️  Firewall tidak disetup.
    echo    Device lain mungkin tidak bisa akses!
    echo    → Jalankan: SETUP_FIREWALL_OTOMATIS.bat nanti
    echo.
)

echo ========================================
echo   LANGKAH 4: CEK SEMUA
echo ========================================
echo.

echo [INFO] Mengecek semua konfigurasi...
call "CEK_SEMUA_SEKALIGUS.bat"

echo.
echo ========================================
echo   LANGKAH 5: TEST DARI DEVICE LAIN
echo ========================================
echo.

:: Get IP again after possible static IP setup
set CURRENT_IP=
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4 Address"') do (
    set CURRENT_IP=%%a
    set CURRENT_IP=!CURRENT_IP: =!
    if not "!CURRENT_IP!"=="" goto :found_ip_final
)
:found_ip_final

if "%CURRENT_IP%"=="" (
    echo ❌ IP Address tidak ditemukan!
    pause
    exit /b 1
)

echo ✅ Apache: Sudah Running (hijau)
echo ✅ IP Address: %CURRENT_IP%
echo.
echo ========================================
echo   URL UNTUK AKSES DARI DEVICE LAIN:
echo ========================================
echo.
echo   http://%CURRENT_IP%/nurani/public
echo.
echo ========================================
echo   CARA TEST:
echo ========================================
echo.
echo 1. Pastikan device lain dalam WiFi yang sama
echo 2. Buka browser di device lain
echo 3. Ketik: http://%CURRENT_IP%/nurani/public
echo 4. Tekan Enter
echo 5. Jika website muncul → BERHASIL! ✅
echo.
echo ========================================
echo   CATATAN PENTING:
echo ========================================
echo.
echo ✅ Apache sudah hijau = Server siap!
echo ⚠️  Pastikan firewall sudah disetup
echo ⚠️  Pastikan semua device dalam WiFi yang sama
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

