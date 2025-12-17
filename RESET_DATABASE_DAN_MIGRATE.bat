@echo off
echo ========================================
echo   RESET DATABASE DAN MIGRATE
echo ========================================
echo.
echo [PERINGATAN] Script ini akan:
echo 1. Hapus database 'nurani' (SEMUA DATA AKAN HILANG!)
echo 2. Buat database 'nurani' baru
echo 3. Jalankan migrations
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "%~dp0"

echo.
echo [1/3] Menghapus database 'nurani'...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->exec('DROP DATABASE IF EXISTS nurani'); echo 'SUKSES: Database sudah dihapus!\n'; } catch(Exception $e) { echo 'INFO: ' . $e->getMessage() . '\n'; }"

echo.
echo [2/3] Membuat database 'nurani' baru...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->exec('CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); echo 'SUKSES: Database sudah dibuat!\n'; } catch(Exception $e) { echo 'ERROR: ' . $e->getMessage() . '\n'; }"

echo.
echo [3/3] Menjalankan migrations...
php artisan migrate --force

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Database sudah di-reset dan migrations sudah jalan!
    echo [INFO] Silakan test aplikasi di browser: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo [ERROR] Migrations gagal! Cek error di atas.
    echo.
)
pause

