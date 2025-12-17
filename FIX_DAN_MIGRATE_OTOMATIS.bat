@echo off
chcp 65001 >nul
echo ========================================
echo   FIX TABLESPACE & MIGRASI OTOMATIS
echo ========================================
echo.
echo [INFO] Script ini akan otomatis:
echo   1. Fix tablespace error
echo   2. Hapus database lama
echo   3. Buat database baru
echo   4. Jalankan migrations
echo   5. Buat data guru
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [INFO] Menjalankan script fix dan migrasi...
echo.

php fix_tablespace_dan_migrate.php

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   BERHASIL!
    echo ========================================
    echo.
    echo [SUKSES] Semua langkah selesai!
    echo [INFO] Email guru sudah bisa digunakan untuk login
    echo.
) else (
    echo.
    echo ========================================
    echo   GAGAL!
    echo ========================================
    echo.
    echo [ERROR] Ada error selama proses
    echo [INFO] Ikuti instruksi di atas untuk solusi manual
    echo.
)

pause
