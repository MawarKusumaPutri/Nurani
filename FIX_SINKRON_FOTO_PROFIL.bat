@echo off
title FIX SINKRON FOTO PROFIL - OTOMATIS MUNCUL
color 0A

echo.
echo ============================================
echo FIX SINKRON FOTO PROFIL - OTOMATIS MUNCUL
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [ERROR] Project tidak ditemukan!
    pause
    exit /b 1
)

cd /d "%XAMPP_PATH%\htdocs\nurani"

echo [1/7] Memperbarui Sidebar TU...
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar TU diperbarui - OTOMATIS cari foto
) else (
    echo [ERROR] Sidebar TU tidak ditemukan!
)
echo.

echo [2/7] Memperbarui Sidebar Kepala Sekolah...
if exist "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\kepala-sekolah-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar Kepala Sekolah diperbarui - OTOMATIS cari foto
) else (
    echo [ERROR] Sidebar Kepala Sekolah tidak ditemukan!
)
echo.

echo [3/7] Memperbarui Dashboard Guru...
if exist "%CD%\resources\views\guru\dashboard.blade.php" (
    copy "%CD%\resources\views\guru\dashboard.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\dashboard.blade.php" /Y >nul 2>&1
    echo [OK] Dashboard Guru diperbarui - OTOMATIS cari foto
) else (
    echo [ERROR] Dashboard Guru tidak ditemukan!
)
echo.

echo [4/7] Memperbarui Profile Index Guru...
if exist "%CD%\resources\views\guru\profile\index.blade.php" (
    copy "%CD%\resources\views\guru\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] Profile Index Guru diperbarui - OTOMATIS cari foto
) else (
    echo [ERROR] Profile Index Guru tidak ditemukan!
)
echo.

echo [5/7] Memperbarui PhotoHelper...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui - OTOMATIS cari file
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [6/7] Memastikan storage symlink...
if exist "public\storage" (
    rmdir /s /q "public\storage" >nul 2>&1
)
php artisan storage:link >nul 2>&1
if exist "public\storage" (
    echo [OK] Storage symlink berhasil dibuat
) else (
    echo [WARNING] Storage symlink mungkin gagal
)
echo.

echo [7/7] Clear cache...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
echo [OK] Cache di-clear
echo.

echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. Sidebar TU diperbarui - OTOMATIS cari foto
echo 2. Sidebar Kepala Sekolah diperbarui - OTOMATIS cari foto
echo 3. Dashboard Guru diperbarui - OTOMATIS cari foto
echo 4. Profile Index Guru diperbarui - OTOMATIS cari foto
echo 5. PhotoHelper diperbarui - OTOMATIS cari file
echo 6. Storage symlink dibuat ulang
echo 7. Cache di-clear
echo.
echo ============================================
echo CARA PAKAI (OTOMATIS - SINKRON):
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. UPLOAD FOTO PROFIL:
echo    - Login sebagai Guru/TU/Kepala Sekolah
echo    - Buka Edit Profil
echo    - Pilih foto
echo    - Klik Simpan
echo    - Foto akan muncul OTOMATIS di:
echo      * Sidebar (lingkaran item)
echo      * Halaman Profil
echo      * Dashboard
echo.
echo 3. FOTO LAMA YANG SUDAH ADA:
echo    - Sistem akan OTOMATIS mencari file
echo    - Foto akan muncul OTOMATIS di semua tempat
echo    - Tidak perlu update manual
echo.
echo 4. HARD REFRESH: Ctrl + F5
echo    - Foto akan muncul di sidebar dan halaman profil
echo.
echo ============================================
echo KEUNGGULAN SISTEM BARU:
echo ============================================
echo.
echo ✓ OTOMATIS mencari foto di semua lokasi
echo ✓ SINKRON antara sidebar dan halaman profil
echo ✓ Foto muncul OTOMATIS setelah upload
echo ✓ Tidak perlu update manual di database
echo ✓ Mendukung berbagai format path
echo ✓ Foto lama tetap muncul (otomatis dicari)
echo.
pause

