@echo off
title FIX ERROR 403 FORBIDDEN - FOTO PROFIL
color 0A

echo.
echo ============================================
echo FIX ERROR 403 FORBIDDEN - FOTO PROFIL
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

echo [1/8] Memperbarui PhotoHelper...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [2/8] Hapus storage symlink lama...
if exist "public\storage" (
    rmdir /s /q "public\storage" >nul 2>&1
    echo [OK] Storage symlink lama dihapus
)
echo.

echo [3/8] Buat storage symlink baru...
php artisan storage:link >nul 2>&1
if exist "public\storage" (
    echo [OK] Storage symlink berhasil dibuat
) else (
    echo [ERROR] Storage symlink gagal dibuat!
    echo         Coba buat manual dengan: php artisan storage:link
)
echo.

echo [4/8] Verifikasi symlink...
if exist "public\storage\profiles" (
    echo [OK] public/storage/profiles ada
) else (
    echo [WARNING] public/storage/profiles tidak ada
)

if exist "public\storage\photos" (
    echo [OK] public/storage/photos ada (format lama)
) else (
    echo [INFO] public/storage/photos tidak ada (normal jika tidak ada foto lama)
)

if exist "public\storage\guru" (
    echo [OK] public/storage/guru ada (format lama)
) else (
    echo [INFO] public/storage/guru tidak ada (normal jika tidak ada foto lama)
)
echo.

echo [5/8] Set permission folder storage...
icacls "storage\app\public" /grant Everyone:F /T >nul 2>&1
icacls "storage\app\public\profiles" /grant Everyone:F /T >nul 2>&1
icacls "public\storage" /grant Everyone:F /T >nul 2>&1
echo [OK] Permission folder di-set
echo.

echo [6/8] Verifikasi folder dan file...
echo.
echo Foto di folder storage/app/public/profiles/guru/:
if exist "storage\app\public\profiles\guru" (
    for %%f in ("storage\app\public\profiles\guru\*.*") do (
        echo   - %%~nxf
        goto :found_guru
    )
    :found_guru
) else (
    echo   [TIDAK ADA] Folder belum ada
)

echo.
echo Foto di folder storage/app/public/profiles/tu/:
if exist "storage\app\public\profiles\tu" (
    for %%f in ("storage\app\public\profiles\tu\*.*") do (
        echo   - %%~nxf
        goto :found_tu
    )
    :found_tu
) else (
    echo   [TIDAK ADA] Folder belum ada
)

echo.
echo Foto di folder storage/app/public/photos/ (format lama):
if exist "storage\app\public\photos" (
    for %%f in ("storage\app\public\photos\*.*") do (
        echo   - %%~nxf
        goto :found_photos
    )
    :found_photos
) else (
    echo   [TIDAK ADA] Folder belum ada
)
echo.

echo [7/8] Update composer autoload...
composer dump-autoload >nul 2>&1
echo [OK] Composer autoload updated
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
echo 1. PhotoHelper diperbaiki untuk handle path lama (photos/)
echo 2. Storage symlink dibuat ulang
echo 3. Permission folder di-set
echo 4. Verifikasi folder dan file
echo 5. Clear cache Laravel
echo.
echo ============================================
echo LANGKAH SELANJUTNYA:
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. TEST AKSES FOTO LANGSUNG:
echo    - Buka: http://localhost/nurani/public/storage/photos/[nama-file]
echo    - Atau: http://localhost/nurani/public/storage/profiles/guru/[nama-file]
echo    - Jika foto muncul = symlink benar
echo    - Jika 403 Forbidden = masalah permission atau symlink
echo.
echo 3. CEK PATH DI DATABASE:
echo    - Buka phpMyAdmin
echo    - Database: nurani
echo    - Tabel: gurus (kolom: foto) atau users (kolom: photo)
echo    - Path harus sesuai dengan nama file di folder
echo.
echo 4. JIKA MASIH 403 FORBIDDEN:
echo    - Cek permission folder: storage/app/public/
echo    - Pastikan folder bisa diakses
echo    - Cek .htaccess di public/storage/
echo.
echo 5. HARD REFRESH: Ctrl + F5
echo.
pause

