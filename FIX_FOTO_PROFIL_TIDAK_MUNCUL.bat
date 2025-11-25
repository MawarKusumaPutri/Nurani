@echo off
title FIX FOTO PROFIL TIDAK MUNCUL
color 0A

echo.
echo ============================================
echo FIX FOTO PROFIL TIDAK MUNCUL
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

echo [1/8] Memperbarui view TU profile...
if exist "%CD%\resources\views\tu\profile\index.blade.php" (
    copy "%CD%\resources\views\tu\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\tu\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] View TU profile diperbarui
) else (
    echo [ERROR] View TU profile tidak ditemukan!
)
echo.

echo [2/8] Memperbarui PhotoHelper...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [3/8] Memastikan storage symlink...
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

echo [4/8] Verifikasi folder dan file...
echo.
echo Foto di folder storage/app/public/profiles/tu/:
if exist "storage\app\public\profiles\tu" (
    echo [OK] Folder tu ada
    for %%f in ("storage\app\public\profiles\tu\*.*") do (
        echo   - %%~nxf
        goto :found_tu
    )
    :found_tu
) else (
    echo [WARNING] Folder tu belum ada
)

echo.
echo Foto di folder storage/app/public/profiles/guru/:
if exist "storage\app\public\profiles\guru" (
    echo [OK] Folder guru ada
    for %%f in ("storage\app\public\profiles\guru\*.*") do (
        echo   - %%~nxf
        goto :found_guru
    )
    :found_guru
) else (
    echo [WARNING] Folder guru belum ada
)

echo.
echo Foto di folder storage/app/public/profiles/kepala_sekolah/:
if exist "storage\app\public\profiles\kepala_sekolah" (
    echo [OK] Folder kepala_sekolah ada
    for %%f in ("storage\app\public\profiles\kepala_sekolah\*.*") do (
        echo   - %%~nxf
        goto :found_ks
    )
    :found_ks
) else (
    echo [WARNING] Folder kepala_sekolah belum ada
)
echo.

echo [5/8] Verifikasi symlink...
if exist "public\storage\profiles" (
    echo [OK] public/storage/profiles ada
    if exist "public\storage\profiles\tu" (
        echo [OK] public/storage/profiles/tu ada
    )
    if exist "public\storage\profiles\guru" (
        echo [OK] public/storage/profiles/guru ada
    )
    if exist "public\storage\profiles\kepala_sekolah" (
        echo [OK] public/storage/profiles/kepala_sekolah ada
    )
) else (
    echo [WARNING] public/storage/profiles tidak ada
)
echo.

echo [6/8] Update composer autoload...
composer dump-autoload >nul 2>&1
echo [OK] Composer autoload updated
echo.

echo [7/8] Clear cache...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
echo [OK] Cache di-clear
echo.

echo [8/8] Test akses foto...
echo.
echo Test URL untuk foto:
for %%f in ("storage\app\public\profiles\tu\*.*") do (
    echo   http://localhost/nurani/public/storage/profiles/tu/%%~nxf
    echo   Buka URL ini di browser untuk test apakah foto bisa diakses
    goto :test_done
)
:test_done
echo.

echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. View TU profile diperbarui dengan logic yang lebih robust
echo 2. PhotoHelper diperbarui
echo 3. Storage symlink dibuat ulang
echo 4. Verifikasi folder dan file
echo 5. Clear cache Laravel
echo.
echo ============================================
echo LANGKAH SELANJUTNYA:
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. CEK PATH DI DATABASE:
echo    - Buka phpMyAdmin: http://localhost/phpmyadmin
echo    - Database: nurani
echo    - Tabel: users
echo    - Cari user yang login (role = 'tu')
echo    - Lihat kolom: photo
echo    - Path harus: profiles/tu/[nama-file]
echo    - Contoh: profiles/tu/1234567890_abc123_foto.jpg
echo.
echo 3. JIKA PATH SALAH, UPDATE DI DATABASE:
echo    - Contoh: UPDATE users SET photo = 'profiles/tu/[nama-file]' WHERE id = [id_user] AND role = 'tu';
echo    - Ganti [nama-file] dengan nama file yang ada di folder
echo    - Ganti [id_user] dengan ID user yang login
echo.
echo 4. TEST AKSES FOTO LANGSUNG:
echo    - Buka: http://localhost/nurani/public/storage/profiles/tu/[nama-file]
echo    - Jika foto muncul = symlink benar
echo    - Jika tidak muncul = masalah symlink atau permission
echo.
echo 5. HARD REFRESH: Ctrl + F5
echo.
echo 6. CEK CONSOLE BROWSER (F12):
echo    - Tab "Console" → lihat error
echo    - Tab "Network" → filter "Images" → lihat request foto
echo    - Status code harus 200
echo    - Jika 404 = path salah
echo    - Jika 403 = masalah permission atau symlink
echo.
pause

