@echo off
chcp 65001 >nul
title Cek dan Setup Ngrok.exe
color 0B

echo.
echo ========================================
echo   CEK DAN SETUP NGROK.EXE
echo ========================================
echo.

:: Check if ngrok.exe exists in current directory
if exist "ngrok.exe" (
    echo ✅ Ngrok.exe ditemukan di folder ini
    echo    Lokasi: %CD%\ngrok.exe
    echo.
    goto :ngrok_found
)

echo ❌ Ngrok.exe tidak ditemukan di folder ini
echo    Lokasi yang dicek: %CD%
echo.

:: Try to find ngrok in PATH
where ngrok >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    where ngrok
    echo.
    echo ✅ Ngrok ditemukan di PATH
    echo.
    set /p USE_PATH="Gunakan ngrok dari PATH? (Y/N): "
    if /i "%USE_PATH%"=="Y" (
        set NGROK_PATH=ngrok
        goto :ngrok_found
    )
)

echo ========================================
echo   SOLUSI
echo ========================================
echo.
echo ⚠️  Ngrok.exe tidak ditemukan!
echo.
echo CARA 1: Download Ngrok.exe
echo    1. Buka browser, kunjungi: https://ngrok.com/download
echo    2. Download untuk Windows
echo    3. Extract ngrok.exe
echo    4. Copy ngrok.exe ke folder ini:
echo       %CD%
echo.
echo CARA 2: Pakai Script Setup
echo    Double-click: SETUP_NGROK_LENGKAP.bat
echo    Script akan membantu download dan setup ngrok
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
    echo ✅ Ngrok.exe ditemukan!
    goto :ngrok_found
) else (
    echo ❌ Ngrok.exe masih belum ditemukan di folder ini.
    echo    Pastikan ngrok.exe ada di: %CD%
    echo.
    echo Lokasi yang dicek: %CD%
    pause
    exit /b 1
)

:ngrok_found
echo ========================================
echo   SETUP AUTHTOKEN
echo ========================================
echo.
echo ⚠️  PERLU TINDAKAN:
echo    1. Buka browser, login ke: https://dashboard.ngrok.com
echo    2. Klik "Your Authtoken" atau "Get Started"
echo    3. Copy authtoken Anda
echo.
echo Membuka dashboard ngrok...
start https://dashboard.ngrok.com
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
    echo.
) else (
    echo ❌ Gagal mengkonfigurasi authtoken!
    echo.
    echo ⚠️  KEMUNGKINAN PENYEBAB:
    echo    1. Authtoken salah
    echo    2. Ngrok.exe tidak bisa dijalankan
    echo    3. Permission error
    echo.
    echo COBA MANUAL:
    echo    Di PowerShell, ketik:
    echo    %NGROK_PATH% config add-authtoken %AUTHTOKEN%
    echo.
    pause
    exit /b 1
)

echo ========================================
echo   VERIFIKASI
echo ========================================
echo.
echo [INFO] Mengecek konfigurasi...
%NGROK_PATH% config check >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo ✅ Konfigurasi ngrok valid!
    echo.
    echo ========================================
    echo   ✅ SETUP SELESAI!
    echo ========================================
    echo.
    echo Authtoken sudah dikonfigurasi dengan benar.
    echo.
    echo Langkah selanjutnya:
    echo    1. Jalankan ngrok: %NGROK_PATH% http 80
    echo    2. Atau pakai script: CEK_DAN_RESTART_NGROK.bat
    echo.
) else (
    echo ⚠️  Konfigurasi mungkin tidak valid
    echo    Tapi authtoken sudah disimpan
    echo.
)

echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

