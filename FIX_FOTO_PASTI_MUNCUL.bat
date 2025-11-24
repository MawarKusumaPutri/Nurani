@echo off
title FIX FOTO PASTI MUNCUL - OTOMATIS
color 0A

echo.
echo ============================================
echo FIX FOTO PASTI MUNCUL - OTOMATIS
echo ============================================
echo.
echo Script ini akan:
echo 1. Memastikan file gambar ada di htdocs
echo 2. Memperbarui file welcome.blade.php di htdocs
echo 3. Clear cache Laravel
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

if not exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS" (
    echo [INFO] Membuat folder image/foto_MTS...
    mkdir "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS" >nul 2>&1
)

if exist "%CD%\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" (
    copy "%CD%\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\" >nul 2>&1
    echo [OK] File gambar 1 disalin
) else (
    echo [WARNING] File gambar 1 tidak ditemukan di project!
)

if exist "%CD%\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
    copy "%CD%\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\" >nul 2>&1
    echo [OK] File gambar 2 disalin
) else (
    echo [WARNING] File gambar 2 tidak ditemukan di project!
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" (
    echo [OK] File gambar 1 ada di htdocs
) else (
    echo [ERROR] File gambar 1 TIDAK ada di htdocs!
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
    echo [OK] File gambar 2 ada di htdocs
) else (
    echo [ERROR] File gambar 2 TIDAK ada di htdocs!
)
echo.

echo ============================================
echo LANGKAH 2: MEMPERBARUI FILE WELCOME.BLADE.PHP
echo ============================================
echo.

if exist "%CD%\resources\views\welcome.blade.php" (
    echo [INFO] Memperbarui file welcome.blade.php di htdocs...
    if not exist "%XAMPP_PATH%\htdocs\nurani\resources\views" mkdir "%XAMPP_PATH%\htdocs\nurani\resources\views" >nul 2>&1
    copy "%CD%\resources\views\welcome.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" /Y >nul 2>&1
    echo [OK] File welcome.blade.php berhasil diperbarui
) else (
    echo [ERROR] File welcome.blade.php tidak ditemukan di project!
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
    php artisan route:clear >nul 2>&1
    cd /d "%~dp0"
    echo [OK] Cache Laravel di-clear
) else (
    echo [WARNING] File artisan tidak ditemukan
)
echo.

echo ============================================
echo VERIFIKASI
echo ============================================
echo.

echo [VERIFIKASI] Cek file penting...
if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" (
    echo [OK] Gambar 1 ada
) else (
    echo [ERROR] Gambar 1 TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
    echo [OK] Gambar 2 ada
) else (
    echo [ERROR] Gambar 2 TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" (
    echo [OK] welcome.blade.php ada
) else (
    echo [ERROR] welcome.blade.php TIDAK ADA!
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
echo 3. Buka browser
echo 4. Ketik: http://localhost/nurani/public
echo 5. Hard refresh: Ctrl + F5 (PENTING!)
echo.
echo Foto sekolah dan 2 anak sekarang akan muncul!
echo.
pause

