@echo off
chcp 65001 >nul
cls
echo ========================================
echo MEMBUAT TABEL RPP SECARA OTOMATIS
echo ========================================
echo.
cd /d "%~dp0"
echo Direktori: %CD%
echo.
echo [1/3] Mencoba metode Migration...
echo.
php artisan migrate --path=database/migrations/2025_12_10_000000_create_rpp_table.php --force
echo.
echo [2/3] Mencoba metode Direct SQL...
echo.
php create_rpp_table_direct.php
echo.
echo [3/3] Verifikasi...
echo.
php -r "try { $pdo = new PDO('mysql:host=localhost;dbname=nurani', 'root', ''); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $result = $pdo->query('SHOW TABLES LIKE \'rpp\''); if ($result->rowCount() > 0) { echo 'SUCCESS: Tabel RPP sudah ada di database!\n'; } else { echo 'WARNING: Tabel RPP belum ada. Coba metode manual.\n'; } } catch (Exception $e) { echo 'ERROR: ' . $e->getMessage() . '\n'; }"
echo.
echo ========================================
echo Selesai!
echo ========================================
echo.
echo Jika berhasil, refresh halaman RPP di browser (Ctrl+F5)
echo Atau buka: http://localhost/nurani/public/guru/rpp
echo.
pause
