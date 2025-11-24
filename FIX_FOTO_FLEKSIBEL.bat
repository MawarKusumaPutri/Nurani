@echo off
title FIX FOTO PROFIL FLEKSIBEL - BEBAS LOKASI
color 0A

echo.
echo ============================================
echo FIX FOTO PROFIL FLEKSIBEL - BEBAS LOKASI
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

echo [1/8] Memperbarui PhotoHelper...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    if not exist "%XAMPP_PATH%\htdocs\nurani\app\Helpers" (
        mkdir "%XAMPP_PATH%\htdocs\nurani\app\Helpers" >nul 2>&1
    )
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [2/8] Memperbarui Controller...
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

echo [3/8] Memperbarui View Profile...
powershell -Command "Get-ChildItem '%CD%\resources\views' -Recurse -Filter '*profile*.blade.php' | ForEach-Object { $dest = $_.FullName.Replace('%CD%', '%XAMPP_PATH%\htdocs\nurani'); $destDir = Split-Path $dest; if (-not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }; Copy-Item $_.FullName $dest -Force }" >nul 2>&1
echo [OK] View profile diperbarui
echo.

echo [4/8] Memperbarui Dashboard Guru...
if exist "%CD%\resources\views\guru\dashboard.blade.php" (
    copy "%CD%\resources\views\guru\dashboard.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\dashboard.blade.php" /Y >nul 2>&1
    echo [OK] Dashboard Guru diperbarui
)
echo.

echo [5/8] Memperbarui Sidebar...
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] TU sidebar diperbarui
)

if exist "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\kepala-sekolah-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Kepala Sekolah sidebar diperbarui
)
echo.

echo [6/8] Update composer autoload...
cd /d "%XAMPP_PATH%\htdocs\nurani"
composer dump-autoload >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo [OK] Composer autoload updated
) else (
    echo [WARNING] Composer autoload mungkin gagal, cek manual
)
echo.

echo [7/8] Memastikan folder profiles...
if not exist "storage\app\public\profiles" (
    mkdir "storage\app\public\profiles" >nul 2>&1
    mkdir "storage\app\public\profiles\guru" >nul 2>&1
    mkdir "storage\app\public\profiles\tu" >nul 2>&1
    mkdir "storage\app\public\profiles\kepala_sekolah" >nul 2>&1
    echo [OK] Folder profiles dibuat
) else (
    echo [OK] Folder profiles sudah ada
)

if not exist "public\image\profiles" (
    mkdir "public\image\profiles" >nul 2>&1
    echo [OK] Folder public/image/profiles dibuat
) else (
    echo [OK] Folder public/image/profiles sudah ada
)
echo.

echo [8/8] Clear cache Laravel...
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
echo 1. PhotoHelper dibuat - sistem fleksibel
echo 2. Controller menggunakan PhotoHelper
echo 3. View menggunakan PhotoHelper
echo 4. Foto bisa disimpan di:
echo    - storage/app/public/profiles/ (default)
echo    - public/image/profiles/ (fallback)
echo    - Lokasi lain (fleksibel)
echo 5. Foto bisa diambil dari:
echo    - Storage
echo    - Public directory
echo    - Path absolut
echo    - URL
echo.
echo ============================================
echo KEUNGGULAN SISTEM FLEKSIBEL:
echo ============================================
echo.
echo 1. TIDAK TERPAKU pada folder tertentu
echo 2. BISA menyimpan di mana saja
echo 3. OTOMATIS mendeteksi lokasi foto
echo 4. FLEKSIBEL untuk berbagai lokasi
echo 5. MUDAH untuk maintenance
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
echo 7. Foto akan muncul di semua halaman
echo.
echo CATATAN:
echo - Foto akan disimpan di: storage/app/public/profiles/
echo - Atau fallback ke: public/image/profiles/
echo - Sistem akan otomatis mencari foto di berbagai lokasi
echo - Tidak perlu khawatir tentang lokasi penyimpanan
echo.
pause

