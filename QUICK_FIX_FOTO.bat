@echo off
title QUICK FIX FOTO - UPDATE & CLEAR CACHE
color 0A

echo.
echo ============================================
echo QUICK FIX FOTO - UPDATE & CLEAR CACHE
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%\htdocs" (
    echo [ERROR] XAMPP tidak ditemukan di: %XAMPP_PATH%
    pause
    exit /b 1
)

echo [OK] XAMPP: %XAMPP_PATH%
echo.

echo [1/3] Memperbarui welcome.blade.php...
if exist "%CD%\resources\views\welcome.blade.php" (
    copy "%CD%\resources\views\welcome.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" /Y >nul 2>&1
    echo [OK] File diperbarui
) else (
    echo [ERROR] File tidak ditemukan!
)

echo [2/3] Clear cache Laravel...
cd /d "%XAMPP_PATH%\htdocs\nurani"
php artisan view:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
cd /d "%~dp0"
echo [OK] Cache di-clear

echo [3/3] Verifikasi file gambar...
if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" (
    echo [OK] Gambar 1 ada
) else (
    echo [WARNING] Gambar 1 tidak ada
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
    echo [OK] Gambar 2 ada
) else (
    echo [WARNING] Gambar 2 tidak ada
)

echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
echo LANGKAH SELANJUTNYA:
echo.
echo 1. Restart Apache di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo 2. Buka: http://localhost/nurani/public
echo 3. Tekan: Ctrl + F5 (Hard Refresh)
echo.
pause

