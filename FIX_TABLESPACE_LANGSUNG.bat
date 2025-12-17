@echo off
echo ========================================
echo   FIX TABLESPACE ERROR - CARA LANGSUNG
echo ========================================
echo.

cd /d "%~dp0"

echo [INFO] Script ini akan:
echo 1. Stop MySQL (jika berjalan)
echo 2. Hapus file tablespace migrations
echo 3. Start MySQL lagi
echo 4. Jalankan migrations
echo.

pause

echo.
echo [1/4] Menghentikan MySQL...
net stop MySQL
if %errorlevel% neq 0 (
    echo [INFO] MySQL tidak berjalan atau sudah berhenti
)
timeout /t 2 /nobreak >nul
echo.

echo [2/4] Menghapus file tablespace migrations...
set MYSQL_DATA=C:\xampp\mysql\data\nurani
if exist "%MYSQL_DATA%\migrations.frm" (
    del /f "%MYSQL_DATA%\migrations.frm"
    echo [SUKSES] migrations.frm sudah dihapus
) else (
    echo [INFO] migrations.frm tidak ditemukan
)

if exist "%MYSQL_DATA%\migrations.ibd" (
    del /f "%MYSQL_DATA%\migrations.ibd"
    echo [SUKSES] migrations.ibd sudah dihapus
) else (
    echo [INFO] migrations.ibd tidak ditemukan
)
echo.

echo [3/4] Menjalankan MySQL lagi...
net start MySQL
if %errorlevel% neq 0 (
    echo [WARNING] Gagal start MySQL via net command
    echo [INFO] Silakan start MySQL manual di XAMPP Control Panel
    echo.
    pause
)
timeout /t 3 /nobreak >nul
echo.

echo [4/4] Menjalankan migrations...
php artisan migrate --force
if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   MIGRATIONS SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Semua tabel sudah dibuat!
    echo [INFO] Silakan test aplikasi di browser: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo [ERROR] Migrations masih gagal!
    echo [INFO] Coba cara alternatif di panduan
    echo.
)
pause

