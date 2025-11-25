@echo off
title UPDATE WELCOME DAN CLEAR CACHE
color 0A

echo.
echo ============================================
echo UPDATE WELCOME DAN CLEAR CACHE
echo ============================================
echo.
echo Script ini akan:
echo 1. Memperbarui file welcome.blade.php di htdocs
echo 2. Clear cache Laravel
echo 3. Verifikasi file gambar ada
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
echo LANGKAH 1: MEMPERBARUI WELCOME.BLADE.PHP
echo ============================================
echo.

if exist "%CD%\resources\views\welcome.blade.php" (
    echo [INFO] Memperbarui file welcome.blade.php di htdocs...
    if not exist "%XAMPP_PATH%\htdocs\nurani\resources\views" (
        mkdir "%XAMPP_PATH%\htdocs\nurani\resources\views" >nul 2>&1
    )
    copy "%CD%\resources\views\welcome.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" /Y >nul 2>&1
    if exist "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" (
        echo [OK] File welcome.blade.php berhasil diperbarui!
    ) else (
        echo [ERROR] Gagal memperbarui file welcome.blade.php!
    )
) else (
    echo [ERROR] File welcome.blade.php tidak ditemukan di project!
    echo Lokasi yang dicari: %CD%\resources\views\welcome.blade.php
)
echo.

echo ============================================
echo LANGKAH 2: VERIFIKASI FILE GAMBAR
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" (
    echo [OK] File gambar 1 ditemukan
) else (
    echo [WARNING] File gambar 1 tidak ditemukan
    echo Lokasi: %XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
    echo [OK] File gambar 2 ditemukan
) else (
    echo [WARNING] File gambar 2 tidak ditemukan
    echo Lokasi: %XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png
)
echo.

echo ============================================
echo LANGKAH 3: CLEAR CACHE LARAVEL
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani\artisan" (
    cd /d "%XAMPP_PATH%\htdocs\nurani"
    echo [INFO] Clear view cache...
    php artisan view:clear >nul 2>&1
    echo [INFO] Clear config cache...
    php artisan config:clear >nul 2>&1
    echo [INFO] Clear application cache...
    php artisan cache:clear >nul 2>&1
    echo [INFO] Clear route cache...
    php artisan route:clear >nul 2>&1
    echo [INFO] Optimize...
    php artisan optimize:clear >nul 2>&1
    cd /d "%~dp0"
    echo [OK] Semua cache Laravel di-clear!
) else (
    echo [WARNING] File artisan tidak ditemukan
    echo Lokasi yang dicari: %XAMPP_PATH%\htdocs\nurani\artisan
)
echo.

echo ============================================
echo LANGKAH 4: HAPUS CACHE BROWSER (OPSIONAL)
echo ============================================
echo.

echo [INFO] Untuk clear cache browser:
echo 1. Buka browser
echo 2. Tekan: Ctrl + Shift + Delete
echo 3. Pilih "Cached images and files"
echo 4. Klik "Clear data"
echo.
echo ATAU gunakan Hard Refresh: Ctrl + F5
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
echo 5. HARD REFRESH: Ctrl + F5 (PENTING!)
echo.
echo Jika masih tidak muncul:
echo - Cek console browser (F12) untuk error
echo - Pastikan file gambar benar-benar ada
echo - Coba akses langsung: http://localhost/nurani/public/image/foto_MTS/20251002_105433-fotor-20251022182659.png
echo.
pause

