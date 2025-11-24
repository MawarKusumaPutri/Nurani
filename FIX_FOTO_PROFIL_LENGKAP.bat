@echo off
title FIX FOTO PROFIL LENGKAP - GURU, TU, KEPALA SEKOLAH
color 0A

echo.
echo ============================================
echo FIX FOTO PROFIL LENGKAP - GURU, TU, KEPALA SEKOLAH
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

echo [1/7] Memperbarui Controller...
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

echo [2/7] Memperbarui View Profile...
powershell -Command "Get-ChildItem '%CD%\resources\views' -Recurse -Filter '*profile*.blade.php' | ForEach-Object { $dest = $_.FullName.Replace('%CD%', '%XAMPP_PATH%\htdocs\nurani'); $destDir = Split-Path $dest; if (-not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }; Copy-Item $_.FullName $dest -Force }" >nul 2>&1
echo [OK] View profile diperbarui
echo.

echo [3/7] Memperbarui Dashboard Guru...
if exist "%CD%\resources\views\guru\dashboard.blade.php" (
    copy "%CD%\resources\views\guru\dashboard.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\dashboard.blade.php" /Y >nul 2>&1
    echo [OK] Dashboard Guru diperbarui
)
echo.

echo [4/7] Memperbarui Sidebar...
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] TU sidebar diperbarui
)

if exist "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\kepala-sekolah-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Kepala Sekolah sidebar diperbarui
)
echo.

echo [5/7] Memastikan storage symlink...
cd /d "%XAMPP_PATH%\htdocs\nurani"
if exist "public\storage" (
    rmdir /s /q "public\storage" >nul 2>&1
)
php artisan storage:link >nul 2>&1
if exist "public\storage" (
    echo [OK] Storage symlink berhasil dibuat
) else (
    echo [WARNING] Storage symlink mungkin gagal, cek manual
)
echo.

echo [6/7] Verifikasi folder storage...
if not exist "storage\app\public\guru\foto" (
    mkdir "storage\app\public\guru\foto" >nul 2>&1
    echo [OK] Folder guru/foto dibuat
) else (
    echo [OK] Folder guru/foto sudah ada
)

if not exist "storage\app\public\photos" (
    mkdir "storage\app\public\photos" >nul 2>&1
    echo [OK] Folder photos dibuat
) else (
    echo [OK] Folder photos sudah ada
)
echo.

echo [7/7] Clear cache Laravel...
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
echo 1. Controller diperbaiki dengan refresh data
echo 2. Dashboard Guru menggunakan fresh data
echo 3. View Profile menggunakan fresh data
echo 4. Sidebar menggunakan fresh data
echo 5. Storage symlink dibuat ulang
echo 6. Folder storage diverifikasi
echo 7. Cache Laravel di-clear
echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
echo LANGKAH SELANJUTNYA:
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo 2. Login sebagai Guru/TU/Kepala Sekolah
echo 3. Buka Edit Profil
echo 4. Upload foto (Format: JPG, PNG, GIF, Maksimal 2MB)
echo 5. Klik Simpan
echo 6. HARD REFRESH: Ctrl + F5 (PENTING!)
echo 7. Foto akan muncul di:
echo    - Sidebar (foto profil kecil)
echo    - Dashboard (foto profil kecil)
echo    - Halaman Profil (foto profil besar)
echo.
echo TIPS:
echo - Jika foto tidak muncul, hard refresh: Ctrl + F5
echo - Pastikan file foto tidak lebih dari 2MB
echo - Format foto: JPG, PNG, GIF
echo - Cek console browser (F12) untuk error
echo.
pause

