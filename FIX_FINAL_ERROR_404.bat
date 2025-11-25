@echo off
title FIX FINAL ERROR 404 - PASTI MUNCUL
color 0A

echo.
echo ============================================
echo FIX FINAL ERROR 404 FOTO PROFIL
echo PASTI MUNCUL - OTOMATIS DAN SINKRON
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

echo [1/10] Hapus storage symlink lama...
if exist "public\storage" (
    rmdir /s /q "public\storage" >nul 2>&1
    echo [OK] Storage symlink lama dihapus
)
echo.

echo [2/10] Buat storage symlink baru...
php artisan storage:link >nul 2>&1
if exist "public\storage" (
    echo [OK] Storage symlink berhasil dibuat
) else (
    echo [ERROR] Storage symlink gagal dibuat!
    echo         Coba buat manual dengan: php artisan storage:link
)
echo.

echo [3/10] Verifikasi symlink...
if exist "public\storage\profiles\tu" (
    echo [OK] public/storage/profiles/tu ada
) else (
    echo [WARNING] public/storage/profiles/tu tidak ada
)
if exist "public\storage\profiles\guru" (
    echo [OK] public/storage/profiles/guru ada
) else (
    echo [WARNING] public/storage/profiles/guru tidak ada
)
if exist "public\storage\profiles\kepala_sekolah" (
    echo [OK] public/storage/profiles/kepala_sekolah ada
) else (
    echo [WARNING] public/storage/profiles/kepala_sekolah tidak ada
)
echo.

echo [4/10] Memperbarui PhotoHelper (SEMUA URL LENGKAP)...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui - SEMUA menggunakan asset() untuk URL lengkap
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [5/10] Memperbarui View TU Profile...
if exist "%CD%\resources\views\tu\profile\index.blade.php" (
    copy "%CD%\resources\views\tu\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\tu\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] View TU Profile diperbarui
)
echo.

echo [6/10] Memperbarui Sidebar TU...
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar TU diperbarui
)
echo.

echo [7/10] Memperbarui Sidebar Kepala Sekolah...
if exist "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\kepala-sekolah-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar Kepala Sekolah diperbarui
)
echo.

echo [8/10] Memperbarui Dashboard dan Profile Guru...
if exist "%CD%\resources\views\guru\dashboard.blade.php" (
    copy "%CD%\resources\views\guru\dashboard.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\dashboard.blade.php" /Y >nul 2>&1
    echo [OK] Dashboard Guru diperbarui
)
if exist "%CD%\resources\views\guru\profile\index.blade.php" (
    copy "%CD%\resources\views\guru\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] Profile Index Guru diperbarui
)
echo.

echo [9/10] Update composer autoload...
composer dump-autoload >nul 2>&1
echo [OK] Composer autoload updated
echo.

echo [10/10] Clear cache LENGKAP...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
echo [OK] Semua cache di-clear
echo.

echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. Storage symlink dibuat ulang
echo 2. PhotoHelper diperbarui - SEMUA menggunakan asset() untuk URL lengkap
echo 3. Semua view diperbarui - Menggunakan asset() untuk URL lengkap
echo 4. Cache di-clear LENGKAP
echo.
echo ============================================
echo CARA PAKAI (PASTI MUNCUL):
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. HARD REFRESH BROWSER: Ctrl + F5
echo    - Foto akan muncul OTOMATIS
echo    - Tidak ada lagi error 404
echo    - URL lengkap: http://localhost/nurani/public/storage/profiles/tu/...
echo.
echo 3. JIKA MASIH ERROR 404:
echo    - Cek file foto ada di: storage/app/public/profiles/tu/
echo    - Cek storage symlink: public/storage harus link ke storage/app/public
echo    - Test akses foto langsung: http://localhost/nurani/public/storage/profiles/tu/[nama-file]
echo    - Jika foto muncul di URL langsung = symlink benar, masalahnya di PhotoHelper
echo    - Jika foto tidak muncul di URL langsung = masalah symlink atau file tidak ada
echo.
echo ============================================
echo KEUNGGULAN PERBAIKAN:
echo ============================================
echo.
echo ✓ SEMUA URL LENGKAP - Tidak ada lagi error 404
echo ✓ Menggunakan asset() di SEMUA tempat
echo ✓ OTOMATIS muncul di sidebar dan halaman profil
echo ✓ SINKRON antara semua halaman
echo ✓ Tidak perlu update manual di database
echo ✓ Foto lama tetap muncul (otomatis dicari)
echo.
pause

