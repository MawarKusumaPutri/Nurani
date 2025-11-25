@echo off
title DEBUG DAN FIX ERROR 404 FOTO PROFIL
color 0A

echo.
echo ============================================
echo DEBUG DAN FIX ERROR 404 FOTO PROFIL
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

echo [1/9] Cek file foto di folder...
echo.
if exist "storage\app\public\profiles\tu" (
    echo [OK] Folder storage/app/public/profiles/tu ada
    echo File yang ada:
    for %%f in ("storage\app\public\profiles\tu\*.*") do (
        echo   - %%~nxf
        goto :found_tu
    )
    :found_tu
) else (
    echo [ERROR] Folder storage/app/public/profiles/tu tidak ada!
)
echo.

echo [2/9] Cek storage symlink...
if exist "public\storage" (
    echo [OK] public/storage ada
    if exist "public\storage\profiles\tu" (
        echo [OK] public/storage/profiles/tu ada
        echo File di symlink:
        for %%f in ("public\storage\profiles\tu\*.*") do (
            echo   - %%~nxf
            goto :found_symlink
        )
        :found_symlink
    ) else (
        echo [ERROR] public/storage/profiles/tu tidak ada!
    )
) else (
    echo [ERROR] public/storage tidak ada!
)
echo.

echo [3/9] Hapus storage symlink lama...
if exist "public\storage" (
    rmdir /s /q "public\storage" >nul 2>&1
    echo [OK] Storage symlink lama dihapus
)
echo.

echo [4/9] Buat storage symlink baru...
php artisan storage:link >nul 2>&1
if exist "public\storage" (
    echo [OK] Storage symlink berhasil dibuat
) else (
    echo [ERROR] Storage symlink gagal dibuat!
)
echo.

echo [5/9] Verifikasi symlink...
if exist "public\storage\profiles\tu" (
    echo [OK] public/storage/profiles/tu ada setelah symlink
) else (
    echo [WARNING] public/storage/profiles/tu tidak ada setelah symlink
)
echo.

echo [6/9] Memperbarui PhotoHelper (URL LENGKAP)...
if exist "%CD%\app\Helpers\PhotoHelper.php" (
    copy "%CD%\app\Helpers\PhotoHelper.php" "%XAMPP_PATH%\htdocs\nurani\app\Helpers\PhotoHelper.php" /Y >nul 2>&1
    echo [OK] PhotoHelper diperbarui
) else (
    echo [ERROR] PhotoHelper.php tidak ditemukan!
)
echo.

echo [7/9] Memperbarui semua view (URL LENGKAP)...
if exist "%CD%\resources\views\tu\profile\index.blade.php" (
    copy "%CD%\resources\views\tu\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\tu\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] View TU Profile diperbarui
)
if exist "%CD%\resources\views\partials\tu-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\tu-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\tu-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar TU diperbarui
)
if exist "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" (
    copy "%CD%\resources\views\partials\kepala-sekolah-sidebar.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\partials\kepala-sekolah-sidebar.blade.php" /Y >nul 2>&1
    echo [OK] Sidebar Kepala Sekolah diperbarui
)
if exist "%CD%\resources\views\guru\dashboard.blade.php" (
    copy "%CD%\resources\views\guru\dashboard.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\dashboard.blade.php" /Y >nul 2>&1
    echo [OK] Dashboard Guru diperbarui
)
if exist "%CD%\resources\views\guru\profile\index.blade.php" (
    copy "%CD%\resources\views\guru\profile\index.blade.php" "%XAMPP_PATH%\htdocs\nurani\resources\views\guru\profile\index.blade.php" /Y >nul 2>&1
    echo [OK] Profile Index Guru diperbarui
)
echo.

echo [8/9] Update composer autoload...
composer dump-autoload >nul 2>&1
echo [OK] Composer autoload updated
echo.

echo [9/9] Clear cache LENGKAP...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
echo [OK] Semua cache di-clear
echo.

echo ============================================
echo TEST URL FOTO:
echo ============================================
echo.
echo Test akses foto langsung di browser:
for %%f in ("storage\app\public\profiles\tu\*.*") do (
    echo   http://localhost/nurani/public/storage/profiles/tu/%%~nxf
    echo   Buka URL ini di browser untuk test apakah foto bisa diakses
    echo   Jika foto muncul = symlink benar
    echo   Jika error 404 = masalah symlink atau file tidak ada
    goto :test_done
)
:test_done
echo.

echo ============================================
echo PERBAIKAN YANG DILAKUKAN:
echo ============================================
echo.
echo 1. Cek file foto di folder
echo 2. Cek storage symlink
echo 3. Hapus storage symlink lama
echo 4. Buat storage symlink baru
echo 5. Verifikasi symlink
echo 6. Memperbarui PhotoHelper (URL LENGKAP)
echo 7. Memperbarui semua view (URL LENGKAP)
echo 8. Update composer autoload
echo 9. Clear cache LENGKAP
echo.
echo ============================================
echo LANGKAH SELANJUTNYA:
echo ============================================
echo.
echo 1. RESTART APACHE di XAMPP (STOP - TUNGGU 10 DETIK - START)
echo.
echo 2. TEST AKSES FOTO LANGSUNG:
echo    - Buka URL yang ditampilkan di atas di browser
echo    - Jika foto muncul = symlink benar, lanjut ke langkah 3
echo    - Jika error 404 = masalah symlink, cek langkah 4
echo.
echo 3. HARD REFRESH BROWSER: Ctrl + F5
echo    - Foto akan muncul OTOMATIS
echo.
echo 4. JIKA MASIH ERROR 404:
echo    - Cek file foto ada di: storage/app/public/profiles/tu/
echo    - Cek storage symlink: public/storage harus link ke storage/app/public
echo    - Jalankan lagi: php artisan storage:link
echo    - Restart Apache lagi
echo.
pause

