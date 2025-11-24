@echo off
title SALIN PROJECT KE HTDOCS
color 0B

echo.
echo ============================================
echo SALIN PROJECT KE HTDOCS
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [INFO] Script ini akan menyalin project ke htdocs.
echo [INFO] Lokasi saat ini: %CD%
echo.
echo Dari: %CD%
echo Ke:   C:\xampp\htdocs\nurani
echo.
pause

echo.
echo [1/5] Cek folder htdocs...
if not exist "C:\xampp\htdocs" (
    echo [ERROR] Folder C:\xampp\htdocs tidak ditemukan!
    echo Pastikan XAMPP sudah terinstall.
    pause
    exit /b 1
) else (
    echo [OK] Folder htdocs ditemukan.
)
echo.

echo [2/5] Hapus folder lama (jika ada)...
if exist "C:\xampp\htdocs\nurani" (
    echo [WARNING] Folder C:\xampp\htdocs\nurani sudah ada.
    echo.
    set /p confirm="Hapus folder lama? (Y/N): "
    if /i "%confirm%"=="Y" (
        echo Menghapus folder lama...
        rmdir /s /q "C:\xampp\htdocs\nurani" 2>nul
        echo [OK] Folder lama dihapus.
    ) else (
        echo [INFO] Folder lama tidak dihapus.
    )
) else (
    echo [OK] Folder lama tidak ada.
)
echo.

echo [3/5] Menyalin project...
echo [INFO] Proses ini mungkin memakan waktu beberapa menit...
echo.

xcopy "%CD%\*" "C:\xampp\htdocs\nurani\" /E /I /H /Y /Q
if %errorlevel% equ 0 (
    echo [OK] Project berhasil disalin.
) else (
    echo [ERROR] Gagal menyalin project!
    echo.
    echo Coba salin manual:
    echo 1. Buka: %CD%
    echo 2. Copy seluruh folder
    echo 3. Paste ke: C:\xampp\htdocs\
    echo 4. Rename menjadi: nurani
    pause
    exit /b 1
)
echo.

echo [4/5] Verifikasi folder public...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] Folder public ditemukan.
) else (
    echo [ERROR] Folder public TIDAK ditemukan!
    echo Pastikan project Laravel lengkap.
    pause
    exit /b 1
)
echo.

echo [5/5] Verifikasi file penting...
if exist "C:\xampp\htdocs\nurani\artisan" (
    echo [OK] File artisan ditemukan.
) else (
    echo [ERROR] File artisan TIDAK ditemukan!
    pause
    exit /b 1
)

if exist "C:\xampp\htdocs\nurani\.env" (
    echo [OK] File .env ditemukan.
) else (
    echo [WARNING] File .env tidak ditemukan.
    echo Pastikan file .env sudah dibuat.
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Project sudah disalin ke: C:\xampp\htdocs\nurani\
echo.
echo Langkah selanjutnya:
echo 1. Pastikan Apache running di XAMPP
echo 2. Test: http://localhost/nurani/public
echo 3. Jika berhasil, lanjut setup HTTPS
echo.
pause

