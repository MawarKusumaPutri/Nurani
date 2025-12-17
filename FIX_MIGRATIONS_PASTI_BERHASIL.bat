@echo off
echo ========================================
echo   FIX MIGRATIONS - PASTI BERHASIL
echo ========================================
echo.
echo [INFO] Script ini akan:
echo 1. Cek apakah database 'nurani' ada
echo 2. Hapus database 'nurani' jika ada
echo 3. Buat database 'nurani' baru
echo 4. Jalankan migrations
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [1/4] Memeriksa koneksi MySQL...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); echo '[SUKSES] MySQL sudah berjalan!\n'; } catch(Exception $e) { echo '[ERROR] MySQL belum berjalan! Silakan start MySQL di XAMPP!\n'; exit(1); }"

if %errorlevel% neq 0 (
    echo.
    echo [INSTRUKSI] Silakan start MySQL di XAMPP Control Panel terlebih dahulu!
    pause
    exit /b
)
echo.

echo [2/4] Menghapus database 'nurani' jika ada...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $pdo->exec('DROP DATABASE IF EXISTS nurani'); echo '[SUKSES] Database sudah dihapus (jika ada)!\n'; } catch(Exception $e) { echo '[INFO] ' . $e->getMessage() . '\n'; }"
echo.

echo [3/4] Membuat database 'nurani' baru...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $pdo->exec('CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); echo '[SUKSES] Database sudah dibuat!\n'; } catch(Exception $e) { echo '[ERROR] ' . $e->getMessage() . '\n'; exit(1); }"

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Gagal membuat database!
    echo [INFO] Coba buat manual di phpMyAdmin:
    echo 1. Buka http://localhost/phpmyadmin
    echo 2. Klik "New" di sidebar
    echo 3. Database name: nurani
    echo 4. Collation: utf8mb4_unicode_ci
    echo 5. Klik "Create"
    echo.
    pause
    exit /b
)
echo.

echo [4/4] Menjalankan migrations...
php artisan migrate --force

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Database sudah dibuat dan migrations sudah jalan!
    echo [INFO] Silakan test aplikasi di browser: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo [ERROR] Migrations masih gagal!
    echo [INFO] Cek error di atas
    echo.
)
pause
