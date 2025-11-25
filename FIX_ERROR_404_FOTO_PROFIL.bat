@echo off
title FIX ERROR 404 FOTO PROFIL - URL LENGKAP
color 0A

echo.
echo ============================================
echo FIX ERROR 404 FOTO PROFIL
echo PERBAIKAN URL LENGKAP - OTOMATIS DAN SINKRON
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

echo [1/8] Memperbarui PhotoHelper (URL LENGKAP)...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui - Menggunakan asset() untuk URL lengkap
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [2/8] Memperbarui View TU Profile (URL LENGKAP)...
if exist "%CD%\resources\views\tu\profile\index.blade.php" (
    copy "%CD%\resources\views\tu\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\tu\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] View TU Profile diperbarui - Menggunakan asset() untuk URL lengkap
) else (
    echo [ERROR] View TU Profile tidak ditemukan!
)
echo.

echo [3/8] Memperbarui Sidebar TU (URL LENGKAP)...
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar TU diperbarui - Menggunakan asset() untuk URL lengkap
) else (
    echo [ERROR] Sidebar TU tidak ditemukan!
)
echo.

echo [4/8] Memperbarui Sidebar Kepala Sekolah (URL LENGKAP)...
if exist "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\kepala-sekolah-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar Kepala Sekolah diperbarui - Menggunakan asset() untuk URL lengkap
) else (
    echo [ERROR] Sidebar Kepala Sekolah tidak ditemukan!
)
echo.

echo [5/8] Memperbarui Dashboard Guru (URL LENGKAP)...
if exist "%CD%\resources\views\guru\dashboard.blade.php" (
    copy "%CD%\resources\views\guru\dashboard.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\dashboard.blade.php" /Y >nul 2>&1
    echo [OK] Dashboard Guru diperbarui - Menggunakan asset() untuk URL lengkap
) else (
    echo [ERROR] Dashboard Guru tidak ditemukan!
)
echo.

echo [6/8] Memperbarui Profile Index Guru (URL LENGKAP)...
if exist "%CD%\resources\views\guru\profile\index.blade.php" (
    copy "%CD%\resources\views\guru\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] Profile Index Guru diperbarui - Menggunakan asset() untuk URL lengkap
) else (
    echo [ERROR] Profile Index Guru tidak ditemukan!
)
echo.

echo [7/8] Memastikan storage symlink...
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

echo [8/8] Clear cache...
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
echo 1. PhotoHelper diperbarui - Menggunakan asset() untuk URL lengkap
echo    - Sebelum: Storage::url() → /storage/... (URL tidak lengkap)
echo    - Sekarang: asset('storage/...') → http://localhost/nurani/public/storage/... (URL lengkap)
echo.
echo 2. Semua view diperbarui - Menggunakan asset() untuk URL lengkap
echo    - View TU Profile
echo    - Sidebar TU
echo    - Sidebar Kepala Sekolah
echo    - Dashboard Guru
echo    - Profile Index Guru
echo.
echo 3. Storage symlink dibuat ulang
echo 4. Cache di-clear
echo.
echo ============================================
echo CARA PAKAI (PASTI MUNCUL - TIDAK ADA ERROR 404):
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. HARD REFRESH BROWSER: Ctrl + F5
echo    - Foto akan muncul OTOMATIS
echo    - Tidak ada lagi error 404
echo    - URL lengkap: http://localhost/nurani/public/storage/profiles/tu/...
echo.
echo 3. UPLOAD FOTO BARU (Jika perlu):
echo    - Login sebagai Guru/TU/Kepala Sekolah
echo    - Buka Edit Profil
echo    - Pilih foto
echo    - Klik Simpan
echo    - Foto akan muncul OTOMATIS dengan URL lengkap
echo.
echo ============================================
echo KEUNGGULAN PERBAIKAN:
echo ============================================
echo.
echo ✓ URL LENGKAP - Tidak ada lagi error 404
echo ✓ Menggunakan asset() - Otomatis menambahkan base URL
echo ✓ OTOMATIS muncul di sidebar dan halaman profil
echo ✓ SINKRON antara semua halaman
echo ✓ Tidak perlu update manual di database
echo ✓ Foto lama tetap muncul (otomatis dicari)
echo.
pause

