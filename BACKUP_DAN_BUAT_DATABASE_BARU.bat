@echo off
chcp 65001 >nul
echo ========================================
echo   BACKUP & BUAT DATABASE BARU - AMAN
echo ========================================
echo.
echo [INFO] Script ini akan:
echo   1. Backup database lama (jika ada data)
echo   2. Hapus database lama
echo   3. Buat database baru
echo   4. Jalankan migrations (membuat semua tabel)
echo   5. Tambah data guru
echo.
echo [PERINGATAN] Database lama akan dihapus!
echo [INFO] Jika ada data penting, backup akan dibuat otomatis
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [INFO] Menjalankan backup dan buat database baru...
echo.

php backup_dan_buat_database_baru.php

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   BERHASIL - DATABASE BARU DIBUAT!
    echo ========================================
    echo.
    echo [SUKSES] Database baru sudah dibuat!
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
)

pause
