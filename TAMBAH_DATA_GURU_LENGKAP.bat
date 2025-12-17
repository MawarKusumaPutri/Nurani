@echo off
chcp 65001 >nul
echo ========================================
echo   TAMBAH DATA GURU LENGKAP
echo ========================================
echo.
echo [INFO] Script ini akan:
echo   1. Fix tablespace error (jika ada)
echo   2. Jalankan migrations (membuat tabel)
echo   3. Tambah data guru dengan password yang benar
echo.
echo [INFO] Data guru akan diupdate dengan:
echo   - Password dari LOGIN_CREDENTIALS.md
echo   - Nama lengkap yang benar
echo   - Mata pelajaran yang benar
echo   - Guru baru: Lola Nurlaela dan Mawar
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [INFO] Menjalankan proses...
echo.

REM Cek apakah tabel sudah ada
php -r "$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=nurani', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); try { $result = $pdo->query('SHOW TABLES LIKE \"users\"'); if ($result->rowCount() > 0) { echo '[INFO] Tabel sudah ada, langsung jalankan seeder...\n'; exit(0); } else { echo '[INFO] Tabel belum ada, jalankan migrations dulu...\n'; exit(1); } } catch(Exception $e) { echo '[INFO] Database belum ada atau error: ' . $e->getMessage() . '\n'; exit(1); }" 2>nul

if %errorlevel% equ 0 (
    echo [INFO] Tabel sudah ada, langsung update data guru...
    echo.
    php artisan db:seed --class=UserSeeder
    if %errorlevel% equ 0 (
        echo.
        echo ========================================
        echo   BERHASIL!
        echo ========================================
        echo.
        echo [SUKSES] Data guru sudah diupdate!
        echo [INFO] Password sudah diupdate sesuai LOGIN_CREDENTIALS.md
        echo [INFO] Guru baru sudah ditambahkan (Lola Nurlaela dan Mawar)
        echo.
        echo [INFO] Test login dengan password baru:
        echo   - mundarinurhadi@gmail.com / Nurhadi2024!
        echo   - keysa8406@gmail.com / Keysha2024!
        echo   - syifarestu81@gmail.com / SyifaRestu2024!
        echo.
    ) else (
        echo.
        echo [ERROR] Seeder gagal!
        echo [INFO] Cek error di atas
        echo.
    )
) else (
    echo [INFO] Tabel belum ada, perlu jalankan migrations dulu...
    echo.
    echo [WARNING] Jika ada error tablespace, ikuti langkah berikut:
    echo   1. Buka http://localhost/phpmyadmin
    echo   2. Tab SQL - Jalankan:
    echo      DROP DATABASE IF EXISTS nurani;
    echo      CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    echo   3. Setelah itu, jalankan script ini lagi
    echo.
    echo [INFO] Mencoba jalankan migrations...
    echo.
    php artisan migrate --force
    
    if %errorlevel% equ 0 (
        echo.
        echo [SUKSES] Migrations selesai!
        echo [INFO] Sekarang menambahkan data guru...
        echo.
        php artisan db:seed --class=UserSeeder
        
        if %errorlevel% equ 0 (
            echo.
            echo ========================================
            echo   BERHASIL!
            echo ========================================
            echo.
            echo [SUKSES] Tabel sudah dibuat!
            echo [SUKSES] Data guru sudah ditambahkan!
            echo [INFO] Password sudah diupdate sesuai LOGIN_CREDENTIALS.md
            echo [INFO] Guru baru sudah ditambahkan (Lola Nurlaela dan Mawar)
            echo.
        ) else (
            echo.
            echo [ERROR] Seeder gagal!
            echo [INFO] Cek error di atas
            echo.
        )
    ) else (
        echo.
        echo [ERROR] Migrations gagal karena error tablespace!
        echo [INFO] Ikuti instruksi di atas untuk fix manual di phpMyAdmin
        echo.
    )
)

pause
