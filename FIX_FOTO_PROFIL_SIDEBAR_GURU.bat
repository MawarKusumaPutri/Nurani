@echo off
title FIX FOTO PROFIL SIDEBAR GURU
color 0A

echo.
echo ============================================
echo FIX FOTO PROFIL SIDEBAR GURU
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

echo [1/3] Clear cache...
php artisan view:clear
php artisan cache:clear
php artisan config:clear
echo [OK] Cache cleared
echo.

echo [2/3] Verifikasi storage symlink...
if exist "public\storage" (
    echo [OK] Storage symlink ada
) else (
    echo [WARNING] Storage symlink tidak ada
    echo [INFO] Membuat storage symlink...
    php artisan storage:link
)
echo.

echo [3/3] Verifikasi folder foto...
if exist "storage\app\public\profiles\guru" (
    echo [OK] Folder profiles/guru ada
) else (
    echo [INFO] Membuat folder profiles/guru...
    mkdir "storage\app\public\profiles\guru" 2>nul
    echo [OK] Folder dibuat
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Perbaikan selesai:
echo - Struktur HTML foto profil di sidebar sudah diperbaiki
echo - Menggunakan PhotoHelper untuk URL yang benar
echo - Foto akan muncul di lingkaran dengan benar
echo.
echo LANGKAH SELANJUTNYA:
echo 1. Hard refresh browser (Ctrl + F5)
echo 2. Cek foto profil di sidebar
echo 3. Jika masih tidak muncul, cek:
echo    - Foto sudah di-upload di halaman Edit Profil
echo    - File ada di: storage/app/public/profiles/guru/
echo    - Storage symlink ada di: public/storage
echo.
pause

