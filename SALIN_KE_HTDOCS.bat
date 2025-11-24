@echo off
title SALIN PROJECT KE HTDOCS
color 0A

echo.
echo ============================================
echo SALIN PROJECT KE HTDOCS
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo [ERROR] File artisan tidak ditemukan!
    echo Lokasi saat ini: %CD%
    echo.
    echo Pastikan Anda menjalankan script ini dari folder project Laravel!
    pause
    exit /b 1
)

REM Cari lokasi XAMPP
set "XAMPP_PATH="
if exist "C:\xampp\htdocs" set "XAMPP_PATH=C:\xampp"
if exist "D:\xampp\htdocs" set "XAMPP_PATH=D:\xampp"
if exist "E:\xampp\htdocs" set "XAMPP_PATH=E:\xampp"

if "%XAMPP_PATH%"=="" (
    echo [ERROR] Folder htdocs tidak ditemukan!
    echo.
    echo Saya mencari di:
    echo - C:\xampp\htdocs
    echo - D:\xampp\htdocs
    echo - E:\xampp\htdocs
    echo.
    echo Jika XAMPP ada di lokasi lain, salin manual:
    echo 1. Buka: %CD%
    echo 2. Copy seluruh isi folder (Ctrl + A, Ctrl + C)
    echo 3. Buka: [lokasi-xampp]\htdocs
    echo 4. Paste (Ctrl + V)
    echo 5. Rename folder menjadi: nurani
    echo.
    pause
    exit /b 1
)

echo [OK] XAMPP ditemukan di: %XAMPP_PATH%
echo [INFO] Lokasi project: %CD%
echo.

echo [INFO] Menghapus folder lama (jika ada)...
if exist "%XAMPP_PATH%\htdocs\nurani" (
    rmdir /s /q "%XAMPP_PATH%\htdocs\nurani" 2>nul
    timeout /t 2 >nul
)

echo.
echo [INFO] Menyalin project ke: %XAMPP_PATH%\htdocs\nurani
echo [INFO] Mohon tunggu, proses ini memakan waktu...
echo.

robocopy "%CD%" "%XAMPP_PATH%\htdocs\nurani" /E /COPYALL /R:1 /W:1 /NP /NFL /NDL

echo.
if exist "%XAMPP_PATH%\htdocs\nurani\public\index.php" (
    echo [OK] Project berhasil disalin!
    echo [OK] File ditemukan: %XAMPP_PATH%\htdocs\nurani\public\index.php
) else (
    echo [ERROR] Gagal menyalin project!
    echo.
    echo SALIN MANUAL:
    echo 1. Buka folder: %CD%
    echo 2. Copy seluruh isi folder (Ctrl + A, Ctrl + C)
    echo 3. Buka: %XAMPP_PATH%\htdocs
    echo 4. Paste (Ctrl + V)
    echo 5. Rename folder menjadi: nurani
    echo.
    pause
    exit /b 1
)

if exist "%XAMPP_PATH%\htdocs\nurani\artisan" (
    echo [OK] File artisan ditemukan.
) else (
    echo [WARNING] File artisan tidak ditemukan!
)

echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Project sudah ada di: %XAMPP_PATH%\htdocs\nurani
echo.
echo Sekarang jalankan: FIX_PASTI_MUNCUL.bat
echo untuk konfigurasi lengkap.
echo.
pause
