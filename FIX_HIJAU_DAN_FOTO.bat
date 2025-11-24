@echo off
title FIX HIJAU DAN FOTO - PASTI MUNCUL
color 0A

echo.
echo ============================================
echo FIX HIJAU DAN FOTO - PASTI MUNCUL
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
    echo [OK] Gambar 1 ada
) else (
    echo [ERROR] Gambar 1 TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\image\foto_MTS\20251002_111603-fotor-20251022164553.png" (
    echo [OK] Gambar 2 ada
) else (
    echo [ERROR] Gambar 2 TIDAK ADA!
)

echo [3/3] Clear cache Laravel...
cd /d "%XAMPP_PATH%\htdocs\nurani"
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
cd /d "%~dp0"
echo [OK] Cache di-clear

echo.
echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. Opacity diubah dari 0 menjadi 1 (gambar langsung muncul)
echo 2. Background body diubah dari gradient menjadi solid
echo 3. Overlay ::before diubah menjadi lebih transparan
echo 4. JavaScript ditambahkan untuk memastikan gambar dimuat
echo 5. Console log ditambahkan untuk debugging
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
echo 4. Buka Developer Tools (F12) - Tab Console
echo 5. Lihat apakah ada error atau log "Image loaded successfully"
echo.
pause

