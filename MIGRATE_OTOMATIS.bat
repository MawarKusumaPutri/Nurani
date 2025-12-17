@echo off
chcp 65001 >nul
echo ========================================
echo   MIGRASI OTOMATIS - MENGURANGI ERROR
echo ========================================
echo.
echo [INFO] Script ini akan otomatis:
echo   1. Hapus database lama (jika ada)
echo   2. Buat database baru
echo   3. Jalankan migrations
echo   4. Buat data guru
echo   5. Verifikasi hasil
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [INFO] Menjalankan script migrasi otomatis...
echo.

php migrate_otomatis.php

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   MIGRASI BERHASIL!
    echo ========================================
    echo.
    echo [SUKSES] Semua langkah selesai!
    echo [INFO] Email guru sudah bisa digunakan untuk login
    echo [INFO] Test login di: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo ========================================
    echo   MIGRASI GAGAL!
    echo ========================================
    echo.
    echo [ERROR] Ada error selama proses migrasi
    echo [INFO] Cek error di atas untuk detail
    echo.
)

pause
