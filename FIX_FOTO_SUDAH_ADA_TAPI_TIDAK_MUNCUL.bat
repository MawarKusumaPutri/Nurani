@echo off
title FIX FOTO SUDAH ADA TAPI TIDAK MUNCUL
color 0A

echo.
echo ============================================
echo FIX FOTO SUDAH ADA TAPI TIDAK MUNCUL
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

echo [1/7] Cek foto di folder...
echo.
if exist "storage\app\public\profiles\guru" (
    echo [OK] Folder guru ada
    for %%f in ("storage\app\public\profiles\guru\*.*") do (
        echo   Foto: %%~nxf
        goto :found_guru
    )
    :found_guru
) else (
    echo [WARNING] Folder guru belum ada
)

if exist "storage\app\public\profiles\tu" (
    echo [OK] Folder tu ada
    for %%f in ("storage\app\public\profiles\tu\*.*") do (
        echo   Foto: %%~nxf
        goto :found_tu
    )
    :found_tu
) else (
    echo [WARNING] Folder tu belum ada
)

if exist "storage\app\public\profiles\kepala_sekolah" (
    echo [OK] Folder kepala_sekolah ada
    for %%f in ("storage\app\public\profiles\kepala_sekolah\*.*") do (
        echo   Foto: %%~nxf
        goto :found_ks
    )
    :found_ks
) else (
    echo [WARNING] Folder kepala_sekolah belum ada
)
echo.

echo [2/7] Memperbarui PhotoHelper...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [3/7] Memastikan storage symlink...
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

echo [4/7] Verifikasi symlink...
if exist "public\storage\profiles" (
    echo [OK] public\storage\profiles\ ada
    if exist "public\storage\profiles\guru" (
        echo [OK] public\storage\profiles\guru\ ada
    )
    if exist "public\storage\profiles\tu" (
        echo [OK] public\storage\profiles\tu\ ada
    )
    if exist "public\storage\profiles\kepala_sekolah" (
        echo [OK] public\storage\profiles\kepala_sekolah\ ada
    )
) else (
    echo [WARNING] public\storage\profiles\ tidak ada
)
echo.

echo [5/7] Test akses foto...
echo.
echo Test URL untuk foto:
for %%f in ("storage\app\public\profiles\guru\*.*") do (
    echo   http://localhost/nurani/public/storage/profiles/guru/%%~nxf
    echo   Buka URL ini di browser untuk test apakah foto bisa diakses
    goto :test_done
)
:test_done
echo.

echo [6/7] Update composer autoload...
composer dump-autoload >nul 2>&1
echo [OK] Composer autoload updated
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
echo 1. PhotoHelper diperbaiki untuk membaca path dengan benar
echo 2. Storage symlink dibuat ulang
echo 3. Verifikasi symlink berfungsi
echo 4. Clear cache Laravel
echo.
echo ============================================
echo LANGKAH SELANJUTNYA:
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo 2. Test akses foto langsung di browser:
echo    - Buka: http://localhost/nurani/public/storage/profiles/guru/[nama-file]
echo    - Jika foto muncul = symlink benar
echo    - Jika tidak muncul = masalah symlink
echo 3. Login dan buka Edit Profil
echo 4. HARD REFRESH: Ctrl + F5
echo 5. Foto akan muncul
echo.
echo JIKA MASIH TIDAK MUNCUL:
echo 1. Cek console browser (F12) → Tab "Console" → lihat error
echo 2. Cek console browser (F12) → Tab "Network" → filter "Images" → lihat request foto
echo 3. Cek path di database (phpMyAdmin):
echo    - Tabel: gurus (kolom: foto) atau users (kolom: photo)
echo    - Pastikan path sesuai dengan nama file di folder
echo 4. Test URL foto langsung di browser
echo.
pause

