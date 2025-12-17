@echo off
echo ========================================
echo   BUAT DATA GURU LANGSUNG
echo ========================================
echo.
echo [INFO] Script ini akan:
echo 1. Hapus database via SQL (jika perlu)
echo 2. Buat database baru
echo 3. Jalankan migrations
echo 4. Buat data guru
echo.
echo [INFO] Password default: password123
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [1/5] Memeriksa koneksi MySQL...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); echo '[SUKSES] MySQL sudah berjalan!\n'; } catch(Exception $e) { echo '[ERROR] MySQL belum berjalan!\n'; exit(1); }"

if %errorlevel% neq 0 (
    echo [INSTRUKSI] Silakan start MySQL di XAMPP!
    pause
    exit /b
)
echo.

echo [2/5] Menghapus database 'nurani' via SQL...
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); try { $pdo->exec('DROP DATABASE nurani'); echo '[SUKSES] Database dihapus!\n'; } catch(Exception $e) { echo '[INFO] Database tidak ada atau tidak bisa dihapus: ' . $e->getMessage() . '\n'; }"
echo.

echo [3/5] Membuat database 'nurani' baru...
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); try { $pdo->exec('CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); echo '[SUKSES] Database dibuat!\n'; } catch(Exception $e) { if (strpos($e->getMessage(), 'exists') !== false) { echo '[INFO] Database sudah ada.\n'; } else { echo '[ERROR] ' . $e->getMessage() . '\n'; exit(1); } }"
echo.

echo [4/5] Menjalankan migrations...
php artisan migrate --force

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Migrations gagal!
    echo [INFO] Coba hapus database manual di phpMyAdmin:
    echo 1. Buka http://localhost/phpmyadmin
    echo 2. Klik database 'nurani' - tab Operations - Drop database
    echo 3. Buat database baru
    echo 4. Jalankan script ini lagi
    pause
    exit /b
)
echo.

echo [5/5] Membuat data guru...
php artisan db:seed --class=UserSeeder

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Data guru sudah dibuat!
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
