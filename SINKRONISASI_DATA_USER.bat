@echo off
chcp 65001 >nul
title Sinkronisasi Data User - Guru, TU, Kepala Sekolah
color 0B

echo.
echo ========================================
echo   SINKRONISASI DATA USER
echo   Guru, TU, dan Kepala Sekolah
echo ========================================
echo.

cd /d "%~dp0"

echo [INFO] Menjalankan seeder untuk sinkronisasi data...
echo.

php artisan db:seed --class=UserSeeder
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ❌ Gagal menjalankan UserSeeder!
    echo    Pastikan database sudah dikonfigurasi dengan benar.
    pause
    exit /b 1
)

echo.
php artisan db:seed --class=GuruSeeder
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ❌ Gagal menjalankan GuruSeeder!
    echo    Pastikan database sudah dikonfigurasi dengan benar.
    pause
    exit /b 1
)

echo.
echo ========================================
echo   ✅ SINKRONISASI SELESAI!
echo ========================================
echo.
echo Data yang sudah disinkronkan:
echo   - Data Guru (dari UserSeeder dan GuruSeeder)
echo   - Data TU (Tenaga Usaha)
echo   - Data Kepala Sekolah
echo.
echo Semua data sudah tersinkron dengan database!
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

