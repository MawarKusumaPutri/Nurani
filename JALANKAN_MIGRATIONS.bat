@echo off
chcp 65001 >nul
echo ========================================
echo   JALANKAN MIGRATIONS LENGKAP
echo   BUAT SEMUA TABEL DI PHPMYADMIN
echo ========================================
echo.
echo [INFO] Script ini akan:
echo   1. Fix tablespace error
echo   2. Hapus database lama
echo   3. Buat database baru
echo   4. Jalankan SEMUA migrations (membuat semua tabel)
echo   5. Verifikasi semua tabel sudah dibuat
echo.
echo [INFO] Setelah selesai, refresh phpMyAdmin untuk melihat tabel-tabel!
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [INFO] Menjalankan migrations lengkap...
echo.

php jalankan_migrations_lengkap.php

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   BERHASIL - TABEL SUDAH DIBUAT!
    echo ========================================
    echo.
    echo [SUKSES] Semua migrations sudah dijalankan!
    echo [SUKSES] Semua tabel sudah dibuat di database!
    echo [INFO] Buka phpMyAdmin → database 'nurani'
    echo [INFO] Refresh halaman untuk melihat tabel-tabel
    echo.
    echo [INFO] Setelah ini, jalankan seeder untuk menambahkan data:
    echo   php artisan db:seed --class=UserSeeder
    echo   ATAU double-click: TAMBAH_DATA_GURU_LENGKAP.bat
    echo.
) else (
    echo.
    echo ========================================
    echo   ERROR TERJADI!
    echo ========================================
    echo.
    echo [ERROR] Ada error selama proses
    echo [INFO] Ikuti instruksi di atas untuk solusi manual
    echo.
    echo [SOLUSI] Jika masih error tablespace:
    echo   1. Buka http://localhost/phpmyadmin
    echo   2. Tab SQL - Jalankan:
    echo      DROP DATABASE IF EXISTS nurani;
    echo      CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    echo   3. Setelah itu, jalankan script ini lagi
    echo.
)

pause
