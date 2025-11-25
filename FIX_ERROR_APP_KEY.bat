@echo off
title FIX ERROR APP_KEY
color 0A

echo.
echo ============================================
echo FIX ERROR: No application encryption key
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [ERROR] Project tidak ditemukan!
    pause
    exit /b 1
)

cd /d "%XAMPP_PATH%\htdocs\nurani"

echo [1/4] Cek file .env...
if exist ".env" (
    echo [OK] File .env ada
) else (
    echo [ERROR] File .env tidak ada!
    echo [INFO] Mencoba copy dari .env.example...
    if exist ".env.example" (
        copy ".env.example" ".env" >nul
        echo [OK] File .env dibuat dari .env.example
    ) else (
        echo [ERROR] File .env.example juga tidak ada!
        echo         Buat file .env manual dengan APP_KEY
        pause
        exit /b 1
    )
)
echo.

echo [2/4] Cek APP_KEY di .env...
findstr /C:"APP_KEY=" ".env" >nul
if %ERRORLEVEL% EQU 0 (
    echo [INFO] APP_KEY ditemukan di .env
    findstr /C:"APP_KEY=base64:" ".env" >nul
    if %ERRORLEVEL% EQU 0 (
        echo [OK] APP_KEY sudah ada dan valid
        echo [INFO] Akan di-generate ulang untuk memastikan
    ) else (
        echo [WARNING] APP_KEY ada tapi mungkin kosong
        echo [INFO] Akan di-generate sekarang
    )
) else (
    echo [WARNING] APP_KEY tidak ditemukan di .env
    echo [INFO] Akan di-generate sekarang
)
echo.

echo [3/4] Generate APP_KEY...
php artisan key:generate
if %ERRORLEVEL% EQU 0 (
    echo [OK] APP_KEY berhasil di-generate
) else (
    echo [ERROR] Gagal generate APP_KEY!
    echo         Coba jalankan manual: php artisan key:generate
    pause
    exit /b 1
)
echo.

echo [4/4] Verifikasi APP_KEY...
findstr /C:"APP_KEY=base64:" ".env" >nul
if %ERRORLEVEL% EQU 0 (
    echo [OK] APP_KEY sudah ada dan valid di .env
) else (
    echo [WARNING] APP_KEY mungkin belum ter-generate dengan benar
    echo         Cek file .env manual
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo APP_KEY sudah di-generate.
echo Refresh browser dan coba lagi.
echo.
echo Jika masih error:
echo 1. Restart Apache
echo 2. Clear cache: php artisan config:clear
echo 3. Hard refresh browser (Ctrl + F5)
echo.
pause

