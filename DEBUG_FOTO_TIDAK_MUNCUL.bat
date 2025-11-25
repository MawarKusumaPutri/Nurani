@echo off
title DEBUG FOTO TIDAK MUNCUL
color 0A

echo.
echo ============================================
echo DEBUG FOTO TIDAK MUNCUL
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

echo [1/6] Cek folder storage/app/public/profiles/...
echo.
if exist "storage\app\public\profiles\guru" (
    echo [OK] Folder guru ada
    dir /b "storage\app\public\profiles\guru" 2>nul | findstr /V "^$" >nul
    if %ERRORLEVEL% EQU 0 (
        echo [OK] Ada file di folder guru:
        dir /b "storage\app\public\profiles\guru"
    ) else (
        echo [WARNING] Folder guru kosong
    )
) else (
    echo [ERROR] Folder guru TIDAK ADA
)

if exist "storage\app\public\profiles\tu" (
    echo [OK] Folder tu ada
    dir /b "storage\app\public\profiles\tu" 2>nul | findstr /V "^$" >nul
    if %ERRORLEVEL% EQU 0 (
        echo [OK] Ada file di folder tu:
        dir /b "storage\app\public\profiles\tu"
    ) else (
        echo [WARNING] Folder tu kosong
    )
) else (
    echo [WARNING] Folder tu belum ada
)

if exist "storage\app\public\profiles\kepala_sekolah" (
    echo [OK] Folder kepala_sekolah ada
    dir /b "storage\app\public\profiles\kepala_sekolah" 2>nul | findstr /V "^$" >nul
    if %ERRORLEVEL% EQU 0 (
        echo [OK] Ada file di folder kepala_sekolah:
        dir /b "storage\app\public\profiles\kepala_sekolah"
    ) else (
        echo [WARNING] Folder kepala_sekolah kosong
    )
) else (
    echo [WARNING] Folder kepala_sekolah belum ada
)
echo.

echo [2/6] Cek storage symlink...
if exist "public\storage" (
    echo [OK] Storage symlink ada
    echo       Path: public\storage\
) else (
    echo [ERROR] Storage symlink TIDAK ADA!
    echo         Akan dibuat sekarang...
    php artisan storage:link >nul 2>&1
    if exist "public\storage" (
        echo [OK] Storage symlink berhasil dibuat
    ) else (
        echo [ERROR] Storage symlink gagal dibuat
    )
)
echo.

echo [3/6] Test akses foto via URL...
echo.
echo Test URL untuk foto guru:
for %%f in ("storage\app\public\profiles\guru\*.*") do (
    set "filename=%%~nxf"
    echo   http://localhost/nurani/public/storage/profiles/guru/%%~nxf
    goto :found_guru
)
:found_guru
echo.

echo [4/6] Cek PhotoHelper...
if exist "app\Helpers\PhotoHelper.php" (
    echo [OK] PhotoHelper.php ada
) else (
    echo [ERROR] PhotoHelper.php TIDAK ADA!
)
echo.

echo [5/6] Test PhotoHelper dengan tinker...
php artisan tinker --execute="
use App\Helpers\PhotoHelper;
use Illuminate\Support\Facades\Storage;

echo '=== TEST PHOTOHELPER ===' . PHP_EOL;
echo PHP_EOL;

// Test path yang mungkin ada
\$testPaths = [
    'profiles/guru',
    'profiles/tu',
    'profiles/kepala_sekolah',
    'guru/foto',
    'photos'
];

foreach (\$testPaths as \$testPath) {
    echo 'Test path: ' . \$testPath . PHP_EOL;
    if (Storage::disk('public')->exists(\$testPath)) {
        echo '  [OK] Path exists' . PHP_EOL;
        \$files = Storage::disk('public')->files(\$testPath);
        echo '  Files: ' . count(\$files) . PHP_EOL;
        if (count(\$files) > 0) {
            \$firstFile = \$files[0];
            echo '  First file: ' . \$firstFile . PHP_EOL;
            \$url = PhotoHelper::getPhotoUrl(\$firstFile);
            echo '  URL: ' . (\$url ?: 'NULL') . PHP_EOL;
        }
    } else {
        echo '  [TIDAK ADA] Path tidak exists' . PHP_EOL;
    }
    echo PHP_EOL;
}
"
echo.

echo [6/6] Clear cache...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
echo [OK] Cache di-clear
echo.

echo ============================================
echo KESIMPULAN:
echo ============================================
echo.
echo 1. Cek apakah foto ada di folder storage/app/public/profiles/
echo 2. Cek apakah storage symlink ada di public/storage
echo 3. Test akses foto via URL di browser
echo 4. Cek console browser (F12) untuk error
echo 5. Hard refresh: Ctrl + F5
echo.
pause

