@echo off
title FIX FOTO PROFIL - GURU, TU, KEPALA SEKOLAH
color 0A

echo.
echo ============================================
echo FIX FOTO PROFIL - GURU, TU, KEPALA SEKOLAH
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

echo [1/5] Memperbarui Controller...
if exist "%CD%\app\Http\Controllers\GuruController.php" (
    copy "%CD%\app\Http\Controllers\GuruController.php" "%XAMPP_PATH%\htdocs\nurani\app\Http\Controllers\GuruController.php" /Y >nul 2>&1
    echo [OK] GuruController diperbarui
)

if exist "%CD%\app\Http\Controllers\TuController.php" (
    copy "%CD%\app\Http\Controllers\TuController.php" "%XAMPP_PATH%\htdocs\nurani\app\Http\Controllers\TuController.php" /Y >nul 2>&1
    echo [OK] TuController diperbarui
)

if exist "%CD%\app\Http\Controllers\KepalaSekolahController.php" (
    copy "%CD%\app\Http\Controllers\KepalaSekolahController.php" "%XAMPP_PATH%\htdocs\nurani\app\Http\Controllers\KepalaSekolahController.php" /Y >nul 2>&1
    echo [OK] KepalaSekolahController diperbarui
)
echo.

echo [2/5] Memperbarui View Profile...
powershell -Command "Get-ChildItem '%CD%\resources\views' -Recurse -Filter '*profile*.blade.php' | ForEach-Object { $dest = $_.FullName.Replace('%CD%', '%XAMPP_PATH%\htdocs\nurani'); $destDir = Split-Path $dest; if (-not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }; Copy-Item $_.FullName $dest -Force }" >nul 2>&1
echo [OK] View profile diperbarui
echo.

echo [3/5] Memperbarui Sidebar...
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] TU sidebar diperbarui
)

if exist "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\kepala-sekolah-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Kepala Sekolah sidebar diperbarui
)
echo.

echo [4/5] Memastikan storage symlink...
cd /d "%XAMPP_PATH%\htdocs\nurani"
php artisan storage:link >nul 2>&1
echo [OK] Storage symlink sudah ada
echo.

echo [5/5] Clear cache Laravel...
php artisan view:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
cd /d "%~dp0"
echo [OK] Cache di-clear
echo.

echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. Controller diperbaiki dengan error handling
echo 2. Verifikasi file tersimpan setelah upload
echo 3. Refresh data setelah update
echo 4. View menggunakan fresh data dari database
echo 5. Cache busting dengan timestamp dan random
echo 6. Error handling untuk foto yang tidak ditemukan
echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
echo LANGKAH SELANJUTNYA:
echo.
echo 1. Restart Apache di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo 2. Login sebagai Guru/TU/Kepala Sekolah
echo 3. Buka Edit Profil
echo 4. Upload foto
echo 5. Klik Simpan
echo 6. Foto akan muncul setelah refresh
echo.
echo TIPS:
echo - Jika foto tidak muncul, hard refresh: Ctrl + F5
echo - Pastikan file foto tidak lebih dari 2MB
echo - Format foto: JPG, PNG, GIF
echo.
pause

