@echo off
title JELAS FOLDER PROFIL - STRUKTUR YANG BENAR
color 0A

echo.
echo ============================================
echo STRUKTUR FOLDER PROFIL - PENJELASAN JELAS
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

echo PENJELASAN STRUKTUR FOLDER:
echo.
echo ============================================
echo FOLDER YANG BENAR (LOKASI ASLI):
echo ============================================
echo.
echo storage\app\public\profiles\
echo   ├── guru\
echo   ├── tu\
echo   └── kepala_sekolah\
echo.
echo INI ADALAH FOLDER ASLI TEMPAT FOTO DISIMPAN
echo.

echo ============================================
echo FOLDER SYMLINK (LINK KE FOLDER ASLI):
echo ============================================
echo.
echo public\storage\
echo.
echo INI ADALAH SYMLINK (shortcut) yang mengarah ke:
echo   storage\app\public\
echo.
echo JADI: public\storage\profiles\ = storage\app\public\profiles\
echo.

echo ============================================
echo MEMBUAT FOLDER YANG BENAR:
echo ============================================
echo.

echo [1/4] Membuat folder storage/app/public/profiles/...
if not exist "storage\app\public\profiles" (
    mkdir "storage\app\public\profiles" >nul 2>&1
    echo [OK] Folder dibuat
) else (
    echo [OK] Folder sudah ada
)

if not exist "storage\app\public\profiles\guru" (
    mkdir "storage\app\public\profiles\guru" >nul 2>&1
    echo [OK] Folder guru dibuat
) else (
    echo [OK] Folder guru sudah ada
)

if not exist "storage\app\public\profiles\tu" (
    mkdir "storage\app\public\profiles\tu" >nul 2>&1
    echo [OK] Folder tu dibuat
) else (
    echo [OK] Folder tu sudah ada
)

if not exist "storage\app\public\profiles\kepala_sekolah" (
    mkdir "storage\app\public\profiles\kepala_sekolah" >nul 2>&1
    echo [OK] Folder kepala_sekolah dibuat
) else (
    echo [OK] Folder kepala_sekolah sudah ada
)
echo.

echo [2/4] Membuat folder fallback public/image/profiles/...
if not exist "public\image\profiles" (
    mkdir "public\image\profiles" >nul 2>&1
    echo [OK] Folder fallback dibuat
) else (
    echo [OK] Folder fallback sudah ada
)
echo.

echo [3/4] Membuat storage symlink...
if exist "public\storage" (
    rmdir /s /q "public\storage" >nul 2>&1
)
php artisan storage:link >nul 2>&1
if exist "public\storage" (
    echo [OK] Storage symlink berhasil dibuat
    echo       public\storage\ → storage\app\public\
) else (
    echo [WARNING] Storage symlink mungkin gagal
)
echo.

echo [4/4] Verifikasi struktur folder...
echo.
echo STRUKTUR FOLDER YANG DIBUAT:
echo.
echo 1. storage\app\public\profiles\
echo    ├── guru\
echo    ├── tu\
echo    └── kepala_sekolah\
echo.
echo 2. public\image\profiles\ (fallback)
echo.
echo 3. public\storage\ (symlink ke storage\app\public\)
echo.
echo ============================================
echo VERIFIKASI:
echo ============================================
echo.

if exist "storage\app\public\profiles\guru" (
    echo [OK] storage\app\public\profiles\guru\ - ADA
) else (
    echo [ERROR] storage\app\public\profiles\guru\ - TIDAK ADA!
)

if exist "storage\app\public\profiles\tu" (
    echo [OK] storage\app\public\profiles\tu\ - ADA
) else (
    echo [ERROR] storage\app\public\profiles\tu\ - TIDAK ADA!
)

if exist "storage\app\public\profiles\kepala_sekolah" (
    echo [OK] storage\app\public\profiles\kepala_sekolah\ - ADA
) else (
    echo [ERROR] storage\app\public\profiles\kepala_sekolah\ - TIDAK ADA!
)

if exist "public\storage" (
    echo [OK] public\storage\ - ADA (symlink)
) else (
    echo [WARNING] public\storage\ - TIDAK ADA (symlink belum dibuat)
)

echo.
echo ============================================
echo CATATAN PENTING:
echo ============================================
echo.
echo 1. FOLDER ASLI: storage\app\public\profiles\
echo    - Ini adalah folder ASLI tempat foto disimpan
echo    - Foto akan disimpan di sini
echo.
echo 2. FOLDER SYMLINK: public\storage\
echo    - Ini adalah SYMLINK (shortcut) ke storage\app\public\
echo    - JANGAN buat folder di sini secara manual!
echo    - Symlink akan dibuat otomatis oleh: php artisan storage:link
echo.
echo 3. AKSES FOTO VIA WEB:
echo    - URL: http://localhost/nurani/public/storage/profiles/guru/[foto]
echo    - Browser akan otomatis mengarah ke: storage/app/public/profiles/guru/[foto]
echo.
echo 4. TIDAK PERLU MEMBUAT FOLDER MANUAL:
echo    - Folder akan dibuat OTOMATIS saat upload foto
echo    - Script ini hanya untuk memastikan folder ada
echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
pause

