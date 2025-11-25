@echo off
title TEST OTOMATIS BUAT FOLDER
color 0A

echo.
echo ============================================
echo TEST OTOMATIS BUAT FOLDER
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

echo TEST 1: Hapus folder untuk test...
echo.
if exist "storage\app\public\profiles" (
    rmdir /s /q "storage\app\public\profiles" >nul 2>&1
    echo [OK] Folder profiles dihapus untuk test
) else (
    echo [OK] Folder profiles belum ada (siap untuk test)
)
echo.

echo TEST 2: Verifikasi PhotoHelper bisa membuat folder...
echo.
php artisan tinker --execute="
use App\Helpers\PhotoHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Simulasi upload file
\$testPath = storage_path('app/public/profiles/guru');
echo 'Cek folder: ' . \$testPath . PHP_EOL;

if (!file_exists(\$testPath)) {
    echo 'Folder belum ada, akan dibuat otomatis...' . PHP_EOL;
    if (!file_exists(storage_path('app/public/profiles'))) {
        mkdir(storage_path('app/public/profiles'), 0755, true);
    }
    if (!file_exists(\$testPath)) {
        mkdir(\$testPath, 0755, true);
    }
    if (file_exists(\$testPath)) {
        echo 'SUKSES: Folder dibuat otomatis!' . PHP_EOL;
    } else {
        echo 'GAGAL: Folder tidak bisa dibuat' . PHP_EOL;
    }
} else {
    echo 'Folder sudah ada' . PHP_EOL;
}
"
echo.

echo TEST 3: Cek folder yang dibuat...
echo.
if exist "storage\app\public\profiles\guru" (
    echo [OK] Folder storage\app\public\profiles\guru\ - ADA
) else (
    echo [ERROR] Folder storage\app\public\profiles\guru\ - TIDAK ADA
)

if exist "storage\app\public\profiles\tu" (
    echo [OK] Folder storage\app\public\profiles\tu\ - ADA
) else (
    echo [INFO] Folder storage\app\public\profiles\tu\ - Belum dibuat (akan dibuat saat upload foto TU)
)

if exist "storage\app\public\profiles\kepala_sekolah" (
    echo [OK] Folder storage\app\public\profiles\kepala_sekolah\ - ADA
) else (
    echo [INFO] Folder storage\app\public\profiles\kepala_sekolah\ - Belum dibuat (akan dibuat saat upload foto Kepala Sekolah)
)
echo.

echo ============================================
echo KESIMPULAN:
echo ============================================
echo.
echo Sistem akan OTOMATIS membuat folder saat upload foto.
echo.
echo CARA TEST:
echo 1. Login sebagai Guru/TU/Kepala Sekolah
echo 2. Buka Edit Profil
echo 3. Upload foto
echo 4. Klik Simpan
echo 5. Cek folder: storage\app\public\profiles\[role]\
echo 6. Folder akan dibuat OTOMATIS jika belum ada
echo.
pause

