@echo off
title FIX PATH DATABASE - PERBAIKI PATH FOTO
color 0A

echo.
echo ============================================
echo FIX PATH DATABASE - PERBAIKI PATH FOTO
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

echo [1/5] Cek foto di folder...
echo.
if exist "storage\app\public\profiles\guru" (
    echo [OK] Folder guru ada
    echo Foto yang ada:
    for %%f in ("storage\app\public\profiles\guru\*.*") do (
        echo   - %%~nxf
    )
) else (
    echo [WARNING] Folder guru belum ada
)
echo.

if exist "storage\app\public\profiles\tu" (
    echo [OK] Folder tu ada
    echo Foto yang ada:
    for %%f in ("storage\app\public\profiles\tu\*.*") do (
        echo   - %%~nxf
    )
) else (
    echo [WARNING] Folder tu belum ada
)
echo.

if exist "storage\app\public\profiles\kepala_sekolah" (
    echo [OK] Folder kepala_sekolah ada
    echo Foto yang ada:
    for %%f in ("storage\app\public\profiles\kepala_sekolah\*.*") do (
        echo   - %%~nxf
    )
) else (
    echo [WARNING] Folder kepala_sekolah belum ada
)
echo.

echo [2/5] Memperbarui PhotoHelper...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui
)
echo.

echo [3/5] Memastikan storage symlink...
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

echo [4/5] Update composer autoload...
composer dump-autoload >nul 2>&1
echo [OK] Composer autoload updated
echo.

echo [5/5] Clear cache...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
echo [OK] Cache di-clear
echo.

echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. PhotoHelper diperbaiki untuk membaca path dengan benar
echo 2. Storage symlink dibuat ulang
echo 3. Clear cache Laravel
echo.
echo ============================================
echo LANGKAH SELANJUTNYA:
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. CEK PATH DI DATABASE:
echo    - Buka phpMyAdmin
echo    - Database: nurani
echo    - Tabel: gurus (untuk Guru) atau users (untuk TU/Kepala Sekolah)
echo    - Kolom: foto (untuk Guru) atau photo (untuk TU/Kepala Sekolah)
echo    - Path harus: profiles/guru/[nama-file] atau profiles/tu/[nama-file]
echo.
echo 3. JIKA PATH SALAH, UPDATE DI DATABASE:
echo    - Contoh: UPDATE gurus SET foto = 'profiles/guru/[nama-file]' WHERE id = [id];
echo    - Ganti [nama-file] dengan nama file yang ada di folder
echo    - Ganti [id] dengan ID guru/user yang login
echo.
echo 4. TEST AKSES FOTO LANGSUNG:
echo    - Buka: http://localhost/nurani/public/storage/profiles/guru/[nama-file]
echo    - Jika foto muncul = symlink benar
echo    - Jika tidak muncul = masalah symlink
echo.
echo 5. HARD REFRESH: Ctrl + F5
echo.
pause

