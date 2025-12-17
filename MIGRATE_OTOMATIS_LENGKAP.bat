@echo off
chcp 65001 >nul
echo ========================================
echo   MIGRASI OTOMATIS - LENGKAP
echo ========================================
echo.
echo [PERINGATAN] Script ini akan:
echo   1. Hapus database 'nurani' (jika ada)
echo   2. Buat database 'nurani' baru
echo   3. Jalankan migrations
echo   4. Buat data guru
echo.
echo [INFO] Jika ada error tablespace, script akan memberikan
echo        instruksi untuk fix manual di phpMyAdmin
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [INFO] Menjalankan migrasi otomatis...
echo.

REM Coba jalankan script otomatis
php fix_tablespace_dan_migrate.php

if %errorlevel% neq 0 (
    echo.
    echo ========================================
    echo   ERROR TABLESPACE TERDETEKSI!
    echo ========================================
    echo.
    echo [INFO] Ada error tablespace yang perlu di-fix manual
    echo [INFO] Ikuti langkah berikut:
    echo.
    echo LANGKAH 1: Fix di phpMyAdmin
    echo   1. Buka http://localhost/phpmyadmin
    echo   2. Klik tab "SQL" di bagian atas
    echo   3. Copy dan paste SQL berikut:
    echo.
    echo      DROP DATABASE IF EXISTS nurani;
    echo      CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    echo.
    echo   4. Klik "Go" untuk menjalankan
    echo.
    echo LANGKAH 2: Setelah fix di phpMyAdmin, jalankan script ini lagi
    echo   (Double-click file ini lagi)
    echo.
    echo ATAU jalankan manual di terminal:
    echo   php artisan migrate --force
    echo   php artisan db:seed --class=UserSeeder
    echo.
    pause
    exit /b
)

echo.
echo ========================================
echo   MIGRASI BERHASIL!
echo ========================================
echo.
echo [SUKSES] Semua langkah selesai!
echo [INFO] Email guru sudah bisa digunakan untuk login
echo [INFO] Test login di: http://localhost/nurani/public/
echo.
pause
