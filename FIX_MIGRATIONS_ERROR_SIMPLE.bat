@echo off
echo ========================================
echo   FIX MIGRATIONS ERROR - SIMPLE
echo ========================================
echo.
echo [INFO] Script ini akan:
echo 1. Stop MySQL (WAJIB dilakukan manual di XAMPP)
echo 2. Hapus file tablespace yang bermasalah
echo 3. Start MySQL (WAJIB dilakukan manual di XAMPP)
echo 4. Jalankan migrations
echo.
echo [WAJIB] Stop MySQL di XAMPP Control Panel SEBELUM lanjut!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [1/4] Memastikan MySQL sudah stop...
echo [INFO] Pastikan MySQL sudah stop di XAMPP!
timeout /t 3 /nobreak >nul
echo.

echo [2/4] Menghapus file tablespace yang bermasalah...
set MYSQL_DATA=C:\xampp\mysql\data\nurani

if exist "%MYSQL_DATA%\migrations.frm" (
    echo [INFO] Menghapus migrations.frm...
    del /f /q "%MYSQL_DATA%\migrations.frm" 2>nul
    echo [SUKSES] migrations.frm sudah dihapus
) else (
    echo [INFO] migrations.frm tidak ada
)

if exist "%MYSQL_DATA%\migrations.ibd" (
    echo [INFO] Menghapus migrations.ibd...
    del /f /q "%MYSQL_DATA%\migrations.ibd" 2>nul
    echo [SUKSES] migrations.ibd sudah dihapus
) else (
    echo [INFO] migrations.ibd tidak ada
)

echo.
echo [3/4] Silakan START MySQL di XAMPP Control Panel sekarang!
echo [INFO] Tekan tombol Start pada MySQL di XAMPP
echo.
pause

echo.
echo [4/4] Menjalankan migrations...
php artisan migrate --force

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Migrations sudah jalan!
    echo [INFO] Silakan test aplikasi di browser: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo [ERROR] Migrations masih gagal!
    echo [INFO] Cek error di atas
    echo.
    echo [SOLUSI ALTERNATIF] Coba hapus SEMUA file di folder:
    echo %MYSQL_DATA%
    echo.
    echo Lalu jalankan script ini lagi.
    echo.
)
pause
