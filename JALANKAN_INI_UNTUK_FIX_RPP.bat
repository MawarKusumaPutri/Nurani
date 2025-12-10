@echo off
chcp 65001 >nul
title FIX ERROR TABEL RPP
color 0A
cls

echo.
echo ============================================================
echo           FIX ERROR TABEL RPP - SOLUSI LENGKAP
echo ============================================================
echo.
echo Script ini akan mencoba beberapa metode untuk membuat tabel RPP
echo.
pause

cd /d "%~dp0"

echo.
echo ============================================================
echo METODE 1: Menggunakan Script PHP Simple
echo ============================================================
echo.
php fix_rpp_simple.php

if %errorlevel% equ 0 (
    echo.
    echo ============================================================
    echo SUKSES! Tabel RPP sudah dibuat.
    echo ============================================================
    echo.
    echo Silakan refresh halaman RPP di browser (Ctrl+F5)
    echo.
    pause
    exit /b 0
)

echo.
echo ============================================================
echo METODE 1 GAGAL, Mencoba Metode 2: Migration
echo ============================================================
echo.
php artisan migrate --path=database/migrations/2025_12_10_000000_create_rpp_table.php --force

if %errorlevel% equ 0 (
    echo.
    echo ============================================================
    echo SUKSES! Tabel RPP sudah dibuat via Migration.
    echo ============================================================
    echo.
    echo Silakan refresh halaman RPP di browser (Ctrl+F5)
    echo.
    pause
    exit /b 0
)

echo.
echo ============================================================
echo METODE 2 GAGAL, Mencoba Metode 3: Direct SQL
echo ============================================================
echo.
php fix_rpp_direct.php

if %errorlevel% equ 0 (
    echo.
    echo ============================================================
    echo SUKSES! Tabel RPP sudah dibuat via Direct SQL.
    echo ============================================================
    echo.
    echo Silakan refresh halaman RPP di browser (Ctrl+F5)
    echo.
    pause
    exit /b 0
)

echo.
echo ============================================================
echo SEMUA METODE OTOMATIS GAGAL
echo ============================================================
echo.
echo Silakan buat tabel secara manual:
echo.
echo 1. Buka phpMyAdmin: http://localhost/phpmyadmin
echo 2. Pilih database 'nurani'
echo 3. Klik tab 'SQL'
echo 4. Buka file 'CREATE_RPP_TABLE.sql' di folder project
echo 5. Copy-paste semua isinya ke phpMyAdmin
echo 6. Klik tombol 'Go' atau 'Jalankan'
echo.
echo Atau jalankan file SQL langsung via command line:
echo    mysql -u root -p nurani ^< CREATE_RPP_TABLE.sql
echo.
pause
