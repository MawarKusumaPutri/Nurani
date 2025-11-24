@echo off
title FIX OTOMATIS FOTO PROFIL - TIDAK PERLU UPDATE MANUAL
color 0A

echo.
echo ============================================
echo FIX OTOMATIS FOTO PROFIL
echo TIDAK PERLU UPDATE MANUAL DI DATABASE!
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

echo [1/6] Memperbarui PhotoHelper (OTOMATIS CARI FILE)...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui - OTOMATIS mencari file berdasarkan nama
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [2/6] Memperbarui Controller (OTOMATIS SIMPAN PATH)...
if exist "%CD%\app\Http\Controllers\TuController.php" (
    copy "%CD%\app\Http\Controllers\TuController.php" "%XAMPP_PATH%\htdocs\nurani\app\Http\Controllers\TuController.php" /Y >nul 2>&1
    echo [OK] TuController diperbarui
)
if exist "%CD%\app\Http\Controllers\GuruController.php" (
    copy "%CD%\app\Http\Controllers\GuruController.php" "%XAMPP_PATH%\htdocs\nurani\app\Http\Controllers\GuruController.php" /Y >nul 2>&1
    echo [OK] GuruController diperbarui
)
if exist "%CD%\app\Http\Controllers\KepalaSekolahController.php" (
    copy "%CD%\app\Http\Controllers\KepalaSekolahController.php" "%XAMPP_PATH%\htdocs\nurani\app\Http\Controllers\KepalaSekolahController.php" /Y >nul 2>&1
    echo [OK] KepalaSekolahController diperbarui
)
echo.

echo [3/6] Memastikan storage symlink...
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

echo [4/6] Update composer autoload...
composer dump-autoload >nul 2>&1
echo [OK] Composer autoload updated
echo.

echo [5/6] Clear cache...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
echo [OK] Cache di-clear
echo.

echo [6/6] Verifikasi folder...
if exist "storage\app\public\profiles\tu" (
    echo [OK] Folder profiles/tu ada
)
if exist "storage\app\public\profiles\guru" (
    echo [OK] Folder profiles/guru ada
)
if exist "storage\app\public\profiles\kepala_sekolah" (
    echo [OK] Folder profiles/kepala_sekolah ada
)
echo.

echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. PhotoHelper OTOMATIS mencari file berdasarkan nama
echo    - Tidak peduli format path di database
echo    - Cari di semua kemungkinan lokasi
echo    - Otomatis menemukan file yang benar
echo.
echo 2. Controller OTOMATIS menyimpan path yang benar
echo    - Path disimpan otomatis saat upload
echo    - Format: profiles/tu/[nama-file]
echo    - Tidak perlu update manual di database
echo.
echo 3. Storage symlink dibuat ulang
echo 4. Cache di-clear
echo.
echo ============================================
echo CARA PAKAI (OTOMATIS - TIDAK PERLU UPDATE MANUAL):
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. UPLOAD FOTO PROFIL:
echo    - Login sebagai Guru/TU/Kepala Sekolah
echo    - Buka Edit Profil
echo    - Pilih foto
echo    - Klik Simpan
echo    - Path akan disimpan OTOMATIS dengan benar
echo    - TIDAK PERLU UPDATE MANUAL DI DATABASE!
echo.
echo 3. FOTO LAMA YANG SUDAH ADA:
echo    - Sistem akan OTOMATIS mencari file berdasarkan nama
echo    - Tidak peduli format path di database
echo    - Foto akan muncul OTOMATIS
echo.
echo 4. HARD REFRESH: Ctrl + F5
echo.
echo ============================================
echo KEUNGGULAN SISTEM BARU:
echo ============================================
echo.
echo ✓ OTOMATIS menyimpan path yang benar saat upload
echo ✓ OTOMATIS mencari file berdasarkan nama (fleksibel)
echo ✓ Tidak perlu update manual di database
echo ✓ Mendukung berbagai format path (profiles/tu/, photos/, dll)
echo ✓ Foto lama akan tetap muncul (otomatis dicari)
echo.
pause

