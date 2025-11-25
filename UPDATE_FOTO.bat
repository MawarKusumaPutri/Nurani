@echo off
title UPDATE FOTO - PERBAIKAN PATH GAMBAR
color 0A

echo.
echo ============================================
echo UPDATE FOTO - PERBAIKAN PATH GAMBAR
echo ============================================
echo.
echo Script ini akan:
echo 1. Memastikan file gambar ada di htdocs
echo 2. Memperbarui file welcome.blade.php di htdocs
echo.
pause

REM Cari lokasi XAMPP
set "XAMPP_PATH="
if exist "D:\Praktikum DWBI\xampp\htdocs" set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if exist "C:\xampp\htdocs" set "XAMPP_PATH=C:\xampp"
if exist "D:\xampp\htdocs" set "XAMPP_PATH=D:\xampp"
if exist "E:\xampp\htdocs" set "XAMPP_PATH=E:\xampp"

if "%XAMPP_PATH%"=="" (
    echo [ERROR] Folder htdocs tidak ditemukan!
    pause
    exit /b 1
)

echo [OK] XAMPP ditemukan di: %XAMPP_PATH%
echo.

echo ============================================
echo LANGKAH 1: MEMASTIKAN FILE GAMBAR ADA
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" (
    echo [OK] File gambar 1 ditemukan
) else (
    echo [WARNING] File gambar 1 tidak ditemukan, menyalin...
    if exist "%CD%\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" (
        if not exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS" mkdir "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS" >nul 2>&1
        copy "%CD%\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\" >nul 2>&1
        echo [OK] File gambar 1 berhasil disalin
    ) else (
        echo [ERROR] File gambar 1 tidak ditemukan di project!
    )
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
    echo [OK] File gambar 2 ditemukan
) else (
    echo [WARNING] File gambar 2 tidak ditemukan, menyalin...
    if exist "%CD%\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
        if not exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS" mkdir "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS" >nul 2>&1
        copy "%CD%\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\" >nul 2>&1
        echo [OK] File gambar 2 berhasil disalin
    ) else (
        echo [ERROR] File gambar 2 tidak ditemukan di project!
    )
)
echo.

echo ============================================
echo LANGKAH 2: MEMPERBARUI FILE WELCOME.BLADE.PHP
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" (
    echo [INFO] Memperbarui file welcome.blade.php di htdocs...
    copy "%CD%\resources\views\welcome.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" >nul 2>&1
    echo [OK] File welcome.blade.php berhasil diperbarui
) else (
    echo [WARNING] File welcome.blade.php tidak ditemukan di htdocs
    echo [INFO] Menyalin file welcome.blade.php...
    if not exist "%XAMPP_PATH%\htdocs\nurani\resources\views" mkdir "%XAMPP_PATH%\htdocs\nurani\resources\views" >nul 2>&1
    copy "%CD%\resources\views\welcome.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" >nul 2>&1
    echo [OK] File welcome.blade.php berhasil disalin
)
echo.

echo ============================================
echo LANGKAH 3: CLEAR CACHE LARAVEL
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani\artisan" (
    cd /d "%XAMPP_PATH%\htdocs\nurani"
    echo [INFO] Clear cache Laravel...
    php artisan view:clear >nul 2>&1
    php artisan config:clear >nul 2>&1
    php artisan cache:clear >nul 2>&1
    cd /d "%~dp0"
    echo [OK] Cache Laravel di-clear
) else (
    echo [WARNING] File artisan tidak ditemukan
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR:
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Restart Apache (STOP - TUNGGU 10 DETIK - START)
echo 3. Test dengan: http://localhost/nurani/public
echo.
echo Foto sekolah dan 2 anak sekarang akan muncul!
echo.
pause

