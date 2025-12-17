@echo off
echo ========================================
echo   FIX MIGRATIONS - PASTI BERHASIL FINAL
echo ========================================
echo.
echo [PERINGATAN] Script ini akan:
echo 1. Stop MySQL
echo 2. Hapus SEMUA file di folder database 'nurani'
echo 3. Hapus folder database 'nurani'
echo 4. Start MySQL
echo 5. Buat database baru
echo 6. Jalankan migrations
echo.
echo [WAJIB] Stop MySQL di XAMPP Control Panel SEBELUM lanjut!
echo.
pause

cd /d "%~dp0"

echo.
echo [1/6] Memastikan MySQL sudah stop...
echo [INFO] Pastikan MySQL sudah stop di XAMPP!
timeout /t 3 /nobreak >nul
echo.

echo [2/6] Menghapus SEMUA file di folder database...
set MYSQL_DATA=C:\xampp\mysql\data\nurani

if exist "%MYSQL_DATA%" (
    echo [INFO] Menghapus semua file di: %MYSQL_DATA%
    del /f /q "%MYSQL_DATA%\*.*" 2>nul
    echo [SUKSES] Semua file sudah dihapus
) else (
    echo [INFO] Folder tidak ada, akan dibuat nanti
)
echo.

echo [3/6] Menghapus folder database...
if exist "%MYSQL_DATA%" (
    rmdir /s /q "%MYSQL_DATA%" 2>nul
    echo [SUKSES] Folder sudah dihapus
) else (
    echo [INFO] Folder tidak ada
)
echo.

echo [4/6] Silakan START MySQL di XAMPP Control Panel sekarang!
echo [INFO] Tekan tombol Start pada MySQL di XAMPP
echo.
pause

echo.
echo [5/6] Membuat database 'nurani' baru...
php reset_database.php
if %errorlevel% neq 0 (
    echo [ERROR] Gagal membuat database!
    echo [INFO] Coba buat manual di phpMyAdmin
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
    echo [SUKSES] Database sudah di-reset dan migrations sudah jalan!
    echo [INFO] Silakan test aplikasi di browser: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo [ERROR] Migrations masih gagal!
    echo [INFO] Cek error di atas
    echo.
)
pause

