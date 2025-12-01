@echo off
chcp 65001 >nul
title Copy Ngrok.exe ke Folder Project
color 0B

echo.
echo ========================================
echo   COPY NGROK.EXE KE FOLDER PROJECT
echo ========================================
echo.

set "SOURCE_PATH=C:\Users\asus\AppData\Local\Programs\Python\Python313\Scripts\ngrok.exe"
set "TARGET_PATH=%~dp0ngrok.exe"
set "TARGET_DIR=%~dp0"

echo Lokasi ngrok.exe saat ini:
echo %SOURCE_PATH%
echo.
echo Akan di-copy ke:
echo %TARGET_DIR%
echo.

:: Check if source file exists
if exist "%SOURCE_PATH%" (
    echo ✅ File ngrok.exe ditemukan di lokasi lama
    echo.
) else (
    echo ❌ File ngrok.exe tidak ditemukan di lokasi lama!
    echo    Lokasi yang dicek: %SOURCE_PATH%
    echo.
    echo ⚠️  PERLU TINDAKAN:
    echo    1. Cek apakah path benar
    echo    2. Atau cari file ngrok.exe di komputer Anda
    echo.
    set /p MANUAL_PATH="Masukkan path lengkap ngrok.exe (atau tekan Enter untuk batal): "
    if "%MANUAL_PATH%"=="" (
        echo Setup dibatalkan.
        pause
        exit /b 0
    )
    set "SOURCE_PATH=%MANUAL_PATH%"
    
    if not exist "%SOURCE_PATH%" (
        echo ❌ File tidak ditemukan di: %SOURCE_PATH%
        pause
        exit /b 1
    )
)

:: Check if target file already exists
if exist "%TARGET_PATH%" (
    echo ⚠️  File ngrok.exe sudah ada di folder project!
    echo    Lokasi: %TARGET_PATH%
    echo.
    set /p OVERWRITE="Overwrite file yang sudah ada? (Y/N): "
    if /i not "%OVERWRITE%"=="Y" (
        echo Setup dibatalkan.
        pause
        exit /b 0
    )
    echo [INFO] Menghapus file lama...
    del "%TARGET_PATH%" >nul 2>&1
)

echo [INFO] Menyalin ngrok.exe...
copy "%SOURCE_PATH%" "%TARGET_PATH%" >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo ✅ File berhasil di-copy!
    echo.
    echo Lokasi baru: %TARGET_PATH%
    echo.
) else (
    echo ❌ Gagal menyalin file!
    echo.
    echo ⚠️  KEMUNGKINAN PENYEBAB:
    echo    1. Permission error
    echo    2. File sedang digunakan
    echo    3. Path tidak valid
    echo.
    echo COBA MANUAL:
    echo    1. Buka File Explorer
    echo    2. Navigasi ke: %SOURCE_PATH%
    echo    3. Copy file ngrok.exe
    echo    4. Paste ke: %TARGET_DIR%
    echo.
    pause
    exit /b 1
)

:: Verify
if exist "%TARGET_PATH%" (
    echo ========================================
    echo   VERIFIKASI
    echo ========================================
    echo.
    echo ✅ File ngrok.exe berhasil di-copy!
    echo    Lokasi: %TARGET_PATH%
    echo.
    echo File size:
    dir "%TARGET_PATH%" | find "ngrok.exe"
    echo.
    echo ========================================
    echo   LANGKAH SELANJUTNYA
    echo ========================================
    echo.
    echo Sekarang Anda bisa:
    echo    1. Pakai: .\ngrok.exe config add-authtoken YOUR_AUTHTOKEN
    echo    2. Atau: .\ngrok.exe http 80
    echo    3. Atau pakai script: CEK_DAN_RESTART_NGROK.bat
    echo.
) else (
    echo ❌ File tidak ditemukan setelah copy!
    echo    Mungkin ada masalah dengan permission.
    pause
    exit /b 1
)

echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

