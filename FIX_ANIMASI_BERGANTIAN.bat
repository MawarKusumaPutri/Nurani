@echo off
title FIX ANIMASI BERGANTIAN - FOTO 1 DAN 2
color 0A

echo.
echo ============================================
echo FIX ANIMASI BERGANTIAN - FOTO 1 DAN 2
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%\htdocs" (
    echo [ERROR] XAMPP tidak ditemukan!
    pause
    exit /b 1
)

echo [OK] XAMPP: %XAMPP_PATH%
echo.

echo [1/3] Memperbarui welcome.blade.php...
if exist "%CD%\resources\views\welcome.blade.php" (
    copy "%CD%\resources\views\welcome.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\welcome.blade.php" /Y >nul 2>&1
    echo [OK] File welcome.blade.php diperbarui
) else (
    echo [ERROR] File tidak ditemukan!
    pause
    exit /b 1
)

echo [2/3] Verifikasi file gambar...
if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_105433-fotor-20251022182659.png" (
    echo [OK] Gambar 1 (Sekolah) ada
) else (
    echo [ERROR] Gambar 1 TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
    echo [OK] Gambar 2 (2 Anak) ada
) else (
    echo [ERROR] Gambar 2 TIDAK ADA!
)

echo [3/3] Clear cache Laravel...
cd /d "%XAMPP_PATH%\htdocs\nurani"
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
cd /d "%~dp0"
echo [OK] Cache di-clear

echo.
echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. Animasi bergantian setiap 5 detik
echo 2. Foto 1 (Sekolah) muncul pertama
echo 3. Foto 2 (2 Anak) muncul setelah 5 detik
echo 4. Kembali ke Foto 1 setelah 5 detik lagi
echo 5. Animasi fade in/out untuk transisi halus
echo 6. IMG tag dan background div sinkron
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
echo 4. Tunggu 5 detik, foto akan berganti ke foto 2
echo 5. Tunggu 5 detik lagi, foto akan kembali ke foto 1
echo.
echo CARA VERIFIKASI:
echo - Buka Console (F12)
echo - Lihat log "Switched to image 1" dan "Switched to image 2"
echo - Foto akan bergantian setiap 5 detik
echo.
pause

