@echo off
chcp 65001 >nul
echo ========================================
echo   BUAT DATA GURU - LENGKAP
echo ========================================
echo.
echo [PERINGATAN] Script ini akan:
echo   1. Hapus database 'nurani' (jika ada)
echo   2. Buat database 'nurani' baru
echo   3. Jalankan migrations (membuat tabel)
echo   4. Buat data guru
echo.
echo [INFO] Jika ada error tablespace, ikuti instruksi di bawah
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [1/4] Menghapus database lama...
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); try { $pdo->exec('DROP DATABASE IF EXISTS nurani'); echo '[SUKSES] Database dihapus!\n'; } catch(Exception $e) { echo '[INFO] ' . $e->getMessage() . '\n'; }"

if %errorlevel% neq 0 (
    echo.
    echo [WARNING] Gagal hapus database via PHP
    echo [INFO] Hapus manual di phpMyAdmin:
    echo   1. Buka http://localhost/phpmyadmin
    echo   2. Tab SQL - Jalankan: DROP DATABASE IF EXISTS nurani;
    echo   3. Setelah itu, jalankan script ini lagi
    pause
    exit /b
)

echo.
echo [2/4] Membuat database baru...
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); try { $pdo->exec('CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); echo '[SUKSES] Database dibuat!\n'; } catch(Exception $e) { if (strpos($e->getMessage(), 'exists') !== false) { echo '[INFO] Database sudah ada.\n'; } else { echo '[ERROR] ' . $e->getMessage() . '\n'; exit(1); } }"

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Gagal membuat database!
    pause
    exit /b
)

echo.
echo [3/4] Menjalankan migrations (membuat tabel)...
php artisan migrate --force

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
    pause
    exit /b
)

echo.
echo [4/4] Membuat data guru...
php artisan db:seed --class=UserSeeder

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Data guru sudah dibuat!
    echo.
    echo [INFO] Email guru yang bisa login:
    echo   - syifarestu81@gmail.com (Syifa Restu R)
    echo   - keysa8406@gmail.com (Keysa Anjani)
    echo   - desinurfalah24@gmail.com (Desi Nurfalah)
    echo   - sopyanikhsananda@gmail.com (Sopyan)
    echo   - wenibustamin27@gmail.com (Weni Azmi)
    echo   - tintinmartini184@gmail.com (Tintin Martini)
    echo   - fadliziyad123@gmail.com (Fadli)
    echo   - sitimundari54@gmail.com (Siti Mundari)
    echo   - mundarinurhadi@gmail.com (Nurhadi)
    echo   - zahnajmudin10@gmail.com (Hamzah Najmudin)
    echo   - rizmalmaulana25@gmail.com (Rizmal)
    echo.
    echo [INFO] Password default: password123
    echo [INFO] Test login di: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo [ERROR] Seeder gagal!
    echo [INFO] Cek error di atas
    echo.
)

pause
