@echo off
chcp 65001 >nul
title Ganti Account Ngrok
color 0B

echo.
echo ========================================
echo   GANTI ACCOUNT NGROK
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
tasklist /FI "IMAGENAME eq ngrok.exe" 2>NUL | find /I /N "ngrok.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ⚠️  Ngrok sedang berjalan!
    echo.
    echo ⚠️  PERLU TINDAKAN:
    echo    1. Hentikan ngrok dulu (di terminal: Ctrl+C)
    echo    2. Atau di Task Manager: End task "ngrok.exe"
    echo.
    echo Tekan tombol apapun setelah ngrok dihentikan...
    pause >nul
    
    :: Check again
    tasklist /FI "IMAGENAME eq ngrok.exe" 2>NUL | find /I /N "ngrok.exe">NUL
    if "%ERRORLEVEL%"=="0" (
        echo ❌ Ngrok masih berjalan!
        echo    Pastikan ngrok sudah dihentikan.
        pause
        exit /b 1
    )
)

echo ✅ Ngrok sudah dihentikan
echo.

echo ========================================
echo   LANGKAH GANTI ACCOUNT NGROK
echo ========================================
echo.
echo ⚠️  PENTING:
echo    - Ini akan menghapus authtoken lama
echo    - Harus setup authtoken baru dari account baru
echo.
set /p CONFIRM="Yakin ingin ganti account? (Y/N): "
if /i not "%CONFIRM%"=="Y" (
    echo.
    echo Setup dibatalkan.
    pause
    exit /b 0
)

echo.
echo ========================================
echo   LANGKAH 1: RESET CONFIG NGROK
echo ========================================
echo.
echo [INFO] Menghapus authtoken lama...
%NGROK_PATH% config reset >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo ✅ Config ngrok sudah direset
    echo.
) else (
    echo ❌ Gagal reset config ngrok!
    pause
    exit /b 1
)

echo ========================================
echo   LANGKAH 2: DAPATKAN AUTHTOKEN BARU
echo ========================================
echo.
echo ⚠️  PERLU TINDAKAN:
echo    1. Buka browser, login ke: https://dashboard.ngrok.com
echo    2. Login dengan account BARU (atau daftar account baru)
echo    3. Klik "Your Authtoken" atau "Get Started"
echo    4. Copy authtoken baru (format: 2abc123...)
echo.
echo Membuka dashboard ngrok...
start https://dashboard.ngrok.com
echo.
echo Tekan tombol apapun setelah copy authtoken baru...
pause >nul

echo.
echo ========================================
echo   LANGKAH 3: SETUP AUTHTOKEN BARU
echo ========================================
echo.
set /p AUTHTOKEN="Masukkan authtoken baru dari account baru: "

if "%AUTHTOKEN%"=="" (
    echo ❌ Authtoken tidak boleh kosong!
    pause
    exit /b 1
)

echo.
echo [INFO] Mengkonfigurasi authtoken baru...
%NGROK_PATH% config add-authtoken %AUTHTOKEN% >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo ✅ Authtoken baru berhasil dikonfigurasi!
    echo.
) else (
    echo ❌ Gagal mengkonfigurasi authtoken!
    echo    Pastikan authtoken benar.
    pause
    exit /b 1
)

echo ========================================
echo   LANGKAH 4: VERIFIKASI ACCOUNT BARU
echo ========================================
echo.
echo [INFO] Menjalankan ngrok untuk verifikasi...
echo.
echo ⚠️  CATATAN:
echo    - Akan muncul output ngrok
echo    - Cek bagian "Account" → harus menampilkan account baru
echo    - Jika sudah benar, tekan Ctrl+C untuk stop
echo.
echo Tekan tombol apapun untuk menjalankan ngrok...
pause >nul

echo.
echo [INFO] Menjalankan ngrok...
start "Ngrok - Verifikasi Account" cmd /k "%NGROK_PATH% http 80"

echo.
echo ========================================
echo   ✅ SETUP SELESAI!
echo ========================================
echo.
echo 1. Lihat terminal yang baru terbuka
echo 2. Cek bagian "Account" → harus menampilkan account baru
echo 3. Jika sudah benar, tekan Ctrl+C untuk stop
echo 4. Jika account masih salah, jalankan script ini lagi
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

