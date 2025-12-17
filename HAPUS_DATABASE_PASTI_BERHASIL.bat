@echo off
chcp 65001 >nul
echo ========================================
echo   HAPUS DATABASE PASTI BERHASIL
echo ========================================
echo.
echo [INFO] Script ini akan:
echo   1. Stop MySQL di XAMPP
echo   2. Hapus folder database secara manual
echo   3. Start MySQL lagi
echo   4. Buat database baru
echo   5. Jalankan migrations
echo   6. Masukkan data guru
echo.
echo [PERINGATAN] Database 'nurani' akan dihapus!
echo [INFO] Pastikan tidak ada data penting yang akan hilang!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [1/6] Menghentikan MySQL...
echo [INFO] Silakan stop MySQL di XAMPP Control Panel secara manual
echo [INFO] Klik "Stop" pada MySQL di XAMPP Control Panel
echo.
pause

echo.
echo [2/6] Mencari dan menghapus folder database...
echo.

REM Cari path MySQL data directory
set MYSQL_DATA_PATH=
if exist "D:\Praktikum DWBI\xampp\mysql\data\nurani" (
    set MYSQL_DATA_PATH=D:\Praktikum DWBI\xampp\mysql\data\nurani
    echo [INFO] Folder ditemukan: D:\Praktikum DWBI\xampp\mysql\data\nurani
) else if exist "C:\xampp\mysql\data\nurani" (
    set MYSQL_DATA_PATH=C:\xampp\mysql\data\nurani
    echo [INFO] Folder ditemukan: C:\xampp\mysql\data\nurani
) else if exist "D:\xampp\mysql\data\nurani" (
    set MYSQL_DATA_PATH=D:\xampp\mysql\data\nurani
    echo [INFO] Folder ditemukan: D:\xampp\mysql\data\nurani
) else (
    echo [WARNING] Folder database tidak ditemukan di lokasi standar
    echo [INFO] Jalankan: php cek_lokasi_database.php untuk cek lokasi
    echo [INFO] Atau cek manual di XAMPP Control Panel - MySQL Config - my.ini
    echo [INFO] Cari baris 'datadir' untuk melihat lokasi data
    echo [INFO] Folder mungkin sudah terhapus atau di lokasi lain
    echo [INFO] Lanjut ke langkah berikutnya...
    goto :create_db
)

if defined MYSQL_DATA_PATH (
    echo [INFO] Menghapus folder: %MYSQL_DATA_PATH%
    rmdir /s /q "%MYSQL_DATA_PATH%" 2>nul
    if exist "%MYSQL_DATA_PATH%" (
        echo [ERROR] Gagal menghapus folder!
        echo [INFO] Hapus manual: %MYSQL_DATA_PATH%
        echo [INFO] Setelah itu, lanjut ke langkah berikutnya
        pause
    ) else (
        echo [SUKSES] Folder database dihapus!
    )
)

:create_db
echo.
echo [3/6] Menunggu MySQL start...
echo [INFO] Silakan start MySQL di XAMPP Control Panel
echo [INFO] Klik "Start" pada MySQL di XAMPP Control Panel
echo.
pause

echo.
echo [4/6] Membuat database baru...
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); try { $pdo->exec('CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); echo '[SUKSES] Database dibuat!\n'; } catch(Exception $e) { if (strpos($e->getMessage(), 'exists') !== false) { echo '[INFO] Database sudah ada, lanjut...\n'; } else { echo '[ERROR] ' . $e->getMessage() . '\n'; exit(1); } }"

if %errorlevel% neq 0 (
    echo [ERROR] Gagal membuat database!
    echo [INFO] Coba buat manual di phpMyAdmin
    pause
    exit /b
)

echo.
echo [5/6] Menjalankan migrations...
php artisan migrate --force

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Migrations gagal!
    echo [INFO] Cek error di atas
    pause
    exit /b
)

echo.
echo [6/6] Menambahkan data guru...
php artisan db:seed --class=UserSeeder

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
    echo [ERROR] Seeder gagal!
    echo [INFO] Cek error di atas
    echo.
)

pause
