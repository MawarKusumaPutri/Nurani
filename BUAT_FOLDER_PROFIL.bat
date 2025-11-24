@echo off
title BUAT FOLDER PROFIL - GURU, TU, KEPALA SEKOLAH
color 0A

echo.
echo ============================================
echo BUAT FOLDER PROFIL - GURU, TU, KEPALA SEKOLAH
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [ERROR] Project tidak ditemukan!
    pause
    exit /b 1
)

echo [OK] Project: %XAMPP_PATH%\htdocs\nurani
echo.

echo [1/6] Membuat folder storage/profiles...
cd /d "%XAMPP_PATH%\htdocs\nurani"

if not exist "storage\app\public\profiles" (
    mkdir "storage\app\public\profiles" >nul 2>&1
    echo [OK] Folder storage/app/public/profiles dibuat
) else (
    echo [OK] Folder storage/app/public/profiles sudah ada
)

if not exist "storage\app\public\profiles\guru" (
    mkdir "storage\app\public\profiles\guru" >nul 2>&1
    echo [OK] Folder storage/app/public/profiles/guru dibuat
) else (
    echo [OK] Folder storage/app/public/profiles/guru sudah ada
)

if not exist "storage\app\public\profiles\tu" (
    mkdir "storage\app\public\profiles\tu" >nul 2>&1
    echo [OK] Folder storage/app/public/profiles/tu dibuat
) else (
    echo [OK] Folder storage/app/public/profiles/tu sudah ada
)

if not exist "storage\app\public\profiles\kepala_sekolah" (
    mkdir "storage\app\public\profiles\kepala_sekolah" >nul 2>&1
    echo [OK] Folder storage/app/public/profiles/kepala_sekolah dibuat
) else (
    echo [OK] Folder storage/app/public/profiles/kepala_sekolah sudah ada
)
echo.

echo [2/6] Membuat folder public/image/profiles...
if not exist "public\image\profiles" (
    mkdir "public\image\profiles" >nul 2>&1
    echo [OK] Folder public/image/profiles dibuat
) else (
    echo [OK] Folder public/image/profiles sudah ada
)
echo.

echo [3/6] Membuat folder kompatibilitas (untuk foto lama)...
if not exist "storage\app\public\guru\foto" (
    mkdir "storage\app\public\guru\foto" >nul 2>&1
    echo [OK] Folder storage/app/public/guru/foto dibuat (kompatibilitas)
) else (
    echo [OK] Folder storage/app/public/guru/foto sudah ada
)

if not exist "storage\app\public\photos" (
    mkdir "storage\app\public\photos" >nul 2>&1
    echo [OK] Folder storage/app/public/photos dibuat (kompatibilitas)
) else (
    echo [OK] Folder storage/app/public/photos sudah ada
)
echo.

echo [4/6] Memastikan storage symlink...
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

echo [5/6] Verifikasi folder...
echo.
echo STRUKTUR FOLDER YANG DIBUAT:
echo.
echo 1. storage/app/public/profiles/
echo    - guru/          (untuk foto profil Guru)
echo    - tu/            (untuk foto profil Tenaga Usaha)
echo    - kepala_sekolah/ (untuk foto profil Kepala Sekolah)
echo.
echo 2. public/image/profiles/
echo    - (fallback jika storage gagal)
echo.
echo 3. storage/app/public/guru/foto/
echo    - (kompatibilitas untuk foto lama)
echo.
echo 4. storage/app/public/photos/
echo    - (kompatibilitas untuk foto lama)
echo.
echo [6/6] Clear cache...
php artisan view:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
cd /d "%~dp0"
echo [OK] Cache di-clear
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo LOKASI PENYIMPANAN FOTO:
echo.
echo GURU:
echo   - storage/app/public/profiles/guru/
echo   - Atau: public/image/profiles/ (fallback)
echo.
echo TENAGA USAHA (TU):
echo   - storage/app/public/profiles/tu/
echo   - Atau: public/image/profiles/ (fallback)
echo.
echo KEPALA SEKOLAH:
echo   - storage/app/public/profiles/kepala_sekolah/
echo   - Atau: public/image/profiles/ (fallback)
echo.
echo CATATAN:
echo - Folder akan dibuat OTOMATIS saat upload foto
echo - Tidak perlu membuat folder secara manual
echo - Sistem akan otomatis menyimpan foto di folder yang sesuai
echo.
pause

