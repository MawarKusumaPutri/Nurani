@echo off
chcp 65001 >nul
title Cek IP dan Setup Otomatis - SUPER MUDAH!
color 0B

echo.
echo ========================================
echo   CEK IP DAN SETUP OTOMATIS - SUPER MUDAH!
echo ========================================
echo.
echo Script ini akan:
echo   1. Menampilkan IP address saat ini
echo   2. Menampilkan semua info yang diperlukan
echo   3. Membantu setup static IP (jika mau)
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo ========================================
echo   INFORMASI IP ADDRESS SAAT INI
echo ========================================
echo.

ipconfig | findstr /i /c:"adapter" /c:"Adapter" /c:"IPv4" /c:"Subnet" /c:"Gateway"

echo.
echo ========================================
echo   YANG PERLU DICATAT:
echo ========================================
echo.

for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4 Address"') do (
    set IP=%%a
    set IP=!IP: =!
    echo ✅ IP Address: !IP!
)

for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "Subnet Mask"') do (
    set MASK=%%a
    set MASK=!MASK: =!
    echo ✅ Subnet Mask: !MASK!
)

for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "Default Gateway"') do (
    set GATEWAY=%%a
    set GATEWAY=!GATEWAY: =!
    echo ✅ Gateway: !GATEWAY!
)

echo.
echo ========================================
echo   URL UNTUK AKSES DARI DEVICE LAIN:
echo ========================================
echo.
if defined IP (
    echo   http://%IP%/nurani/public
) else (
    echo   [IP Address tidak ditemukan]
)
echo.

echo ========================================
echo   PILIHAN:
echo ========================================
echo.
echo [1] Setup Static IP (agar IP tidak berubah)
echo [2] Hanya tampilkan info (tidak setup)
echo [3] Buka panduan lengkap
echo.
set /p PILIHAN="Pilihan Anda (1-3): "

if "%PILIHAN%"=="1" (
    echo.
    echo Membuka setup static IP...
    call SETUP_STATIC_IP_MUDAH.bat
) else if "%PILIHAN%"=="2" (
    echo.
    echo Info sudah ditampilkan di atas.
    echo.
    echo Tekan tombol apapun untuk menutup...
    pause >nul
) else if "%PILIHAN%"=="3" (
    echo.
    echo Membuka panduan lengkap...
    start "" "CARA_MUDAH_SETUP_IP_ADDRESS.md"
    echo.
    echo Panduan sudah dibuka di Notepad.
    echo.
    echo Tekan tombol apapun untuk menutup...
    pause >nul
) else (
    echo.
    echo Pilihan tidak valid.
    pause
)

