@echo off
title FIX FOTO PROFIL - PASTI MUNCUL FINAL
color 0A

echo.
echo ============================================
echo FIX FOTO PROFIL - PASTI MUNCUL FINAL
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

echo [1/10] Membuat folder Helpers...
if not exist "%XAMPP_PATH%\htdocs\nurani\app\Helpers" (
    mkdir "%XAMPP_PATH%\htdocs\nurani\app\Helpers" >nul 2>&1
    echo [OK] Folder Helpers dibuat
) else (
    echo [OK] Folder Helpers sudah ada
)
echo.

echo [2/10] Memperbarui PhotoHelper...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
    pause
    exit /b 1
)
echo.

echo [3/10] Memperbarui Controller...
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

echo [4/10] Memperbarui View Profile...
powershell -Command "Get-ChildItem '%CD%\resources\views' -Recurse -Filter '*profile*.blade.php' | ForEach-Object { $dest = $_.FullName.Replace('%CD%', '%XAMPP_PATH%\htdocs\nurani'); $destDir = Split-Path $dest; if (-not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }; Copy-Item $_.FullName $dest -Force }" >nul 2>&1
echo [OK] View profile diperbarui
echo.

echo [5/10] Memperbarui Dashboard Guru...
if exist "%CD%\resources\views\guru\dashboard.blade.php" (
    copy "%CD%\resources\views\guru\dashboard.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\dashboard.blade.php" /Y >nul 2>&1
    echo [OK] Dashboard Guru diperbarui
)
echo.

echo [6/10] Memperbarui Sidebar...
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] TU sidebar diperbarui
)

if exist "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\kepala-sekolah-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Kepala Sekolah sidebar diperbarui
)
echo.

echo [7/10] Update composer autoload...
cd /d "%XAMPP_PATH%\htdocs\nurani"
composer dump-autoload >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo [OK] Composer autoload updated
) else (
    echo [WARNING] Composer autoload mungkin gagal, cek manual
)
echo.

echo [8/10] Memastikan folder storage dan public...
if not exist "storage\app\public\profiles" (
    mkdir "storage\app\public\profiles" >nul 2>&1
    mkdir "storage\app\public\profiles\guru" >nul 2>&1
    mkdir "storage\app\public\profiles\tu" >nul 2>&1
    mkdir "storage\app\public\profiles\kepala_sekolah" >nul 2>&1
    echo [OK] Folder storage/profiles dibuat
) else (
    echo [OK] Folder storage/profiles sudah ada
)

if not exist "public\image\profiles" (
    mkdir "public\image\profiles" >nul 2>&1
    echo [OK] Folder public/image/profiles dibuat
) else (
    echo [OK] Folder public/image/profiles sudah ada
)

REM Juga buat folder lama untuk kompatibilitas
if not exist "storage\app\public\guru\foto" (
    mkdir "storage\app\public\guru\foto" >nul 2>&1
    echo [OK] Folder storage/guru/foto dibuat (kompatibilitas)
)

if not exist "storage\app\public\photos" (
    mkdir "storage\app\public\photos" >nul 2>&1
    echo [OK] Folder storage/photos dibuat (kompatibilitas)
)
echo.

echo [9/10] Memastikan storage symlink...
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

echo [10/10] Clear cache Laravel...
php artisan view:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
cd /d "%~dp0"
echo [OK] Cache di-clear
echo.

echo ============================================
echo VERIFIKASI:
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" (
    echo [OK] PhotoHelper.php ada
) else (
    echo [ERROR] PhotoHelper.php TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\storage" (
    echo [OK] Storage symlink ada
) else (
    echo [WARNING] Storage symlink TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\storage\app\public\profiles" (
    echo [OK] Folder profiles ada
) else (
    echo [WARNING] Folder profiles TIDAK ADA!
)

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
echo JIKA MASIH TIDAK MUNCUL:
echo 1. Cek console browser (F12) untuk error
echo 2. Cek file foto ada di storage/app/public/profiles/
echo 3. Cek storage symlink: public/storage harus link ke storage/app/public
echo 4. Clear cache browser: Ctrl + Shift + Delete
echo.
pause

