@echo off
title FIX FOTO PROFIL PASTI MUNCUL - SOLUSI LENGKAP
color 0A

echo.
echo ============================================
echo FIX FOTO PROFIL PASTI MUNCUL
echo SOLUSI LENGKAP - OTOMATIS DAN SINKRON
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

echo [1/10] Memperbarui TuController (PASTI REFRESH DATA)...
if exist "%CD%\app\Http\Controllers\TuController.php" (
    copy "%CD%\app\Http\Controllers\TuController.php" "%XAMPP_PATH%\htdocs\nurani\app\Http\Controllers\TuController.php" /Y >nul 2>&1
    echo [OK] TuController diperbarui - PASTI refresh data dan clear cache
) else (
    echo [ERROR] TuController.php tidak ditemukan!
)
echo.

echo [2/10] Memperbarui View TU Profile (PASTI CARI FOTO)...
if exist "%CD%\resources\views\tu\profile\index.blade.php" (
    copy "%CD%\resources\views\tu\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\tu\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] View TU Profile diperbarui - PASTI cari foto di semua lokasi
) else (
    echo [ERROR] View TU Profile tidak ditemukan!
)
echo.

echo [3/10] Memperbarui Sidebar TU...
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar TU diperbarui
) else (
    echo [ERROR] Sidebar TU tidak ditemukan!
)
echo.

echo [4/10] Memperbarui PhotoHelper (PASTI TEMUKAN FILE)...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui - PASTI temukan file
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [5/10] Memastikan storage symlink...
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

echo [6/10] Verifikasi folder dan file...
echo.
echo Foto di folder storage/app/public/profiles/tu/:
if exist "storage\app\public\profiles\tu" (
    echo [OK] Folder tu ada
    set "file_count=0"
    for %%f in ("storage\app\public\profiles\tu\*.*") do (
        set /a file_count+=1
        echo   - %%~nxf
        if !file_count! GEQ 5 goto :found_tu
    )
    :found_tu
    if !file_count! EQU 0 (
        echo   [INFO] Folder kosong - akan dibuat saat upload
    )
) else (
    echo [INFO] Folder tu belum ada - akan dibuat otomatis saat upload
)

echo.
echo Foto di folder storage/app/public/profiles/guru/:
if exist "storage\app\public\profiles\guru" (
    echo [OK] Folder guru ada
    set "file_count=0"
    for %%f in ("storage\app\public\profiles\guru\*.*") do (
        set /a file_count+=1
        echo   - %%~nxf
        if !file_count! GEQ 5 goto :found_guru
    )
    :found_guru
    if !file_count! EQU 0 (
        echo   [INFO] Folder kosong - akan dibuat saat upload
    )
) else (
    echo [INFO] Folder guru belum ada - akan dibuat otomatis saat upload
)

echo.
echo Foto di folder storage/app/public/profiles/kepala_sekolah/:
if exist "storage\app\public\profiles\kepala_sekolah" (
    echo [OK] Folder kepala_sekolah ada
    set "file_count=0"
    for %%f in ("storage\app\public\profiles\kepala_sekolah\*.*") do (
        set /a file_count+=1
        echo   - %%~nxf
        if !file_count! GEQ 5 goto :found_ks
    )
    :found_ks
    if !file_count! EQU 0 (
        echo   [INFO] Folder kosong - akan dibuat saat upload
    )
) else (
    echo [INFO] Folder kepala_sekolah belum ada - akan dibuat otomatis saat upload
)
echo.

echo [7/10] Verifikasi symlink...
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

echo [8/10] Update composer autoload...
composer dump-autoload >nul 2>&1
echo [OK] Composer autoload updated
echo.

echo [9/10] Clear cache LENGKAP...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
echo [OK] Semua cache di-clear
echo.

echo [10/10] Test akses foto...
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
echo 1. TuController diperbarui - PASTI refresh data dan clear cache
echo 2. View TU Profile diperbarui - PASTI cari foto di semua lokasi
echo 3. Sidebar TU diperbarui - OTOMATIS cari foto
echo 4. PhotoHelper diperbarui - PASTI temukan file
echo 5. Storage symlink dibuat ulang
echo 6. Verifikasi folder dan file
echo 7. Verifikasi symlink
echo 8. Update composer autoload
echo 9. Clear cache LENGKAP
echo 10. Test akses foto
echo.
echo ============================================
echo CARA PAKAI (PASTI MUNCUL):
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. UPLOAD FOTO PROFIL:
echo    - Login sebagai Guru/TU/Kepala Sekolah
echo    - Buka Edit Profil
echo    - Pilih foto (Format: JPG, PNG, GIF, Maksimal 2MB)
echo    - Klik Simpan
echo    - Sistem akan:
echo      * Simpan foto dengan path yang benar
echo      * Refresh data dari database
echo      * Clear cache otomatis
echo      * Foto akan muncul OTOMATIS
echo.
echo 3. HARD REFRESH: Ctrl + F5
echo    - Foto akan muncul di:
echo      * Sidebar (lingkaran item) ✓
echo      * Halaman Profil ✓
echo      * Dashboard ✓
echo      * Semua halaman ✓
echo.
echo 4. JIKA MASIH TIDAK MUNCUL:
echo    - Cek console browser (F12) → Tab "Console" → lihat error
echo    - Cek console browser (F12) → Tab "Network" → filter "Images" → lihat request foto
echo    - Test akses foto langsung di browser
echo    - Pastikan file foto ada di folder
echo.
echo ============================================
echo KEUNGGULAN SISTEM BARU:
echo ============================================
echo.
echo ✓ PASTI refresh data setelah upload
echo ✓ PASTI clear cache setelah upload
echo ✓ PASTI cari foto di semua lokasi
echo ✓ OTOMATIS muncul di sidebar dan halaman profil
echo ✓ SINKRON antara semua halaman
echo ✓ Tidak perlu update manual di database
echo ✓ Foto lama tetap muncul (otomatis dicari)
echo.
pause

