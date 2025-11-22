@echo off
echo ============================================
echo SETUP LARAVEL APACHE - CLEAR CACHE
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [1/4] Clearing configuration cache...
php artisan config:clear
if %errorlevel% neq 0 (
    echo ERROR: Gagal clear config cache!
    pause
    exit /b 1
)

echo [2/4] Clearing application cache...
php artisan cache:clear
if %errorlevel% neq 0 (
    echo ERROR: Gagal clear application cache!
    pause
    exit /b 1
)

echo [3/4] Clearing route cache...
php artisan route:clear
if %errorlevel% neq 0 (
    echo ERROR: Gagal clear route cache!
    pause
    exit /b 1
)

echo [4/4] Clearing view cache...
php artisan view:clear
if %errorlevel% neq 0 (
    echo ERROR: Gagal clear view cache!
    pause
    exit /b 1
)

echo.
echo ============================================
echo SUKSES! Cache sudah di-clear.
echo ============================================
echo.
echo Langkah selanjutnya:
echo 1. Pastikan Apache sudah di-restart di XAMPP
echo 2. Buka browser dan akses domain Anda
echo.
pause

