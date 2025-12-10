@echo off
chcp 65001 >nul
echo ========================================
echo FIX TABEL RPP - JALANKAN MIGRATION
echo ========================================
echo.

cd /d "%~dp0"

echo [1/3] Menjalankan migration untuk tabel RPP...
php artisan migrate --path=database/migrations/2025_12_10_000000_create_rpp_table.php --force
if %errorlevel% neq 0 (
    echo.
    echo ERROR: Migration gagal!
    echo.
    echo [2/3] Mencoba alternatif: Membuat tabel langsung via SQL...
    echo.
    echo Silakan buka phpMyAdmin dan jalankan file CREATE_RPP_TABLE.sql
    echo atau copy-paste SQL dari file tersebut.
    echo.
    pause
    exit /b 1
)

echo.
echo [2/3] Migration berhasil!
echo.
echo [3/3] Memverifikasi tabel...
php artisan tinker --execute="echo Schema::hasTable('rpp') ? 'SUKSES: Tabel rpp sudah ada!' : 'ERROR: Tabel rpp belum ada!';"

echo.
echo ========================================
echo Selesai!
echo ========================================
echo.
echo Jika masih error, jalankan file CREATE_RPP_TABLE.sql di phpMyAdmin
echo.
pause
