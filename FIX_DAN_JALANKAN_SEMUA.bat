@echo off
chcp 65001 >nul
echo ========================================
echo   FIX & JALANKAN SEMUA - LENGKAP
echo ========================================
echo.
echo [INFO] Script ini akan:
echo   1. Fix tablespace error
echo   2. Hapus database lama
echo   3. Buat database baru
echo   4. Jalankan migrations (membuat semua tabel)
echo   5. Tambah data guru
echo   6. Verifikasi hasil
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [INFO] Menjalankan proses lengkap...
echo.

php fix_dan_jalankan_semua.php

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   BERHASIL - SEMUA SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Database sudah dibuat!
    echo [SUKSES] Semua tabel sudah dibuat!
    echo [SUKSES] Data guru sudah ditambahkan!
    echo [INFO] Buka phpMyAdmin → database 'nurani'
    echo [INFO] Test login di aplikasi
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
