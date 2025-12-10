@echo off
echo ========================================
echo JALANKAN MIGRATION UNTUK TABEL RPP
echo ========================================
echo.
cd /d "%~dp0"
echo Mengubah direktori ke: %CD%
echo.
echo Menjalankan migration untuk tabel RPP...
echo.
php artisan migrate --path=database/migrations/2025_12_10_000000_create_rpp_table.php
echo.
echo ========================================
echo Selesai!
echo ========================================
echo.
echo Jika migration berhasil, refresh halaman RPP di browser.
echo Jika masih error, gunakan file KLIK_INI_BUAT_TABEL_RPP.bat
echo.
pause
