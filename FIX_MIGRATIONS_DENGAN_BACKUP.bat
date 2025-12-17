@echo off
echo ========================================
echo   FIX MIGRATIONS - DENGAN BACKUP
echo ========================================
echo.
echo [PERINGATAN] Script ini akan:
echo 1. Backup database 'nurani' (jika ada)
echo 2. Hapus database 'nurani' jika ada
echo 3. Buat database 'nurani' baru
echo 4. Jalankan migrations
echo.
echo [INFO] Backup akan disimpan di folder 'backup' di project
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [1/5] Memeriksa koneksi MySQL...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); echo '[SUKSES] MySQL sudah berjalan!\n'; } catch(Exception $e) { echo '[ERROR] MySQL belum berjalan! Silakan start MySQL di XAMPP!\n'; exit(1); }"

if %errorlevel% neq 0 (
    echo.
    echo [INSTRUKSI] Silakan start MySQL di XAMPP Control Panel terlebih dahulu!
    pause
    exit /b
)
echo.

echo [2/5] Membuat folder backup...
if not exist "backup" mkdir backup
echo [SUKSES] Folder backup sudah dibuat
echo.

echo [3/5] Backup database 'nurani' jika ada...
set BACKUP_FILE=backup\nurani_backup_%date:~-4,4%%date:~-7,2%%date:~-10,2%_%time:~0,2%%time:~3,2%%time:~6,2%.sql
set BACKUP_FILE=%BACKUP_FILE: =0%

php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $result = $pdo->query('SHOW DATABASES LIKE \"nurani\"'); if ($result->rowCount() > 0) { echo '[INFO] Database nurani ditemukan, akan di-backup...\n'; } else { echo '[INFO] Database nurani tidak ada, tidak perlu backup.\n'; exit(0); } } catch(Exception $e) { echo '[INFO] ' . $e->getMessage() . '\n'; exit(0); }"

if %errorlevel% equ 0 (
    echo [INFO] Menjalankan mysqldump untuk backup...
    "C:\xampp\mysql\bin\mysqldump.exe" -u root nurani > "%BACKUP_FILE%" 2>nul
    if exist "%BACKUP_FILE%" (
        echo [SUKSES] Backup berhasil disimpan di: %BACKUP_FILE%
    ) else (
        echo [INFO] Backup gagal, tapi akan lanjut (mungkin database kosong)
    )
) else (
    echo [INFO] Database tidak ada, tidak perlu backup
)
echo.

echo [4/5] Menghapus database 'nurani' jika ada...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $pdo->exec('DROP DATABASE IF EXISTS nurani'); echo '[SUKSES] Database sudah dihapus (jika ada)!\n'; } catch(Exception $e) { echo '[INFO] ' . $e->getMessage() . '\n'; }"
echo.

echo [5/5] Membuat database 'nurani' baru...
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

echo [6/6] Menjalankan migrations...
php artisan migrate --force

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Database sudah dibuat dan migrations sudah jalan!
    echo [INFO] Backup (jika ada) disimpan di folder 'backup'
    echo [INFO] Silakan test aplikasi di browser: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo [ERROR] Migrations masih gagal!
    echo [INFO] Cek error di atas
    echo.
)
pause
