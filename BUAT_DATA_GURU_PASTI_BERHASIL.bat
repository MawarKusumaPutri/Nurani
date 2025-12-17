@echo off
echo ========================================
echo   BUAT DATA GURU - PASTI BERHASIL
echo ========================================
echo.
echo [PERINGATAN] Script ini akan:
echo 1. Hapus database 'nurani' (via SQL)
echo 2. Buat database 'nurani' baru
echo 3. Jalankan migrations
echo 4. Buat data guru
echo.
echo [INFO] Password default: password123
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [1/5] Memeriksa koneksi MySQL...
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); echo '[SUKSES] MySQL sudah berjalan!\n';" 2>nul

if %errorlevel% neq 0 (
    echo [ERROR] MySQL belum berjalan!
    echo [INSTRUKSI] Silakan start MySQL di XAMPP Control Panel!
    pause
    exit /b
)
echo.

echo [2/5] Menghapus database 'nurani'...
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); try { $pdo->exec('DROP DATABASE nurani'); echo '[SUKSES] Database dihapus!\n'; } catch(Exception $e) { echo '[INFO] ' . $e->getMessage() . '\n'; }" 2>nul
echo.

echo [3/5] Membuat database 'nurani' baru...
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); try { $pdo->exec('CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); echo '[SUKSES] Database dibuat!\n'; } catch(Exception $e) { if (strpos($e->getMessage(), 'exists') !== false) { echo '[INFO] Database sudah ada.\n'; } else { echo '[ERROR] ' . $e->getMessage() . '\n'; exit(1); } }" 2>nul

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Gagal membuat database!
    echo [INFO] Coba buat manual di phpMyAdmin:
    echo 1. Buka http://localhost/phpmyadmin
    echo 2. Tab SQL - Jalankan: DROP DATABASE IF EXISTS nurani; CREATE DATABASE nurani...
    pause
    exit /b
)
echo.

echo [4/5] Menjalankan migrations...
php artisan migrate --force

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Migrations gagal!
    echo [INFO] Cek error di atas
    echo.
    echo [SOLUSI] Hapus database manual di phpMyAdmin:
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
    echo [INFO] Email guru yang bisa login:
    echo 1. syifarestu81@gmail.com (Syifa Restu R)
    echo 2. keysa8406@gmail.com (Keysa Anjani)
    echo 3. desinurfalah24@gmail.com (Desi Nurfalah)
    echo 4. sopyanikhsananda@gmail.com (Sopyan)
    echo 5. wenibustamin27@gmail.com (Weni Azmi)
    echo 6. tintinmartini184@gmail.com (Tintin Martini)
    echo 7. fadliziyad123@gmail.com (Fadli)
    echo 8. sitimundari54@gmail.com (Siti Mundari)
    echo 9. mundarinurhadi@gmail.com (Nurhadi)
    echo 10. zahnajmudin10@gmail.com (Hamzah Najmudin)
    echo 11. rizmalmaulana25@gmail.com (Rizmal)
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
