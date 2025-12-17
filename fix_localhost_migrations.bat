@echo off
echo ========================================
echo   FIX LOCALHOST MIGRATIONS
echo ========================================
echo.

cd /d "%~dp0"

echo [1/3] Memeriksa MySQL...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); echo '[SUKSES] MySQL sudah berjalan!\n'; } catch(Exception $e) { echo '[ERROR] MySQL belum berjalan! Silakan start MySQL di XAMPP!\n'; exit(1); }"
if %errorlevel% neq 0 (
    echo.
    echo [INSTRUKSI] Silakan start MySQL di XAMPP Control Panel terlebih dahulu!
    pause
    exit /b
)
echo.

echo [2/3] Menghapus tabel migrations yang bermasalah...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=nurani', 'root', ''); $pdo->exec('DROP TABLE IF EXISTS migrations'); echo '[SUKSES] Tabel migrations sudah dihapus!\n'; } catch(Exception $e) { echo '[INFO] Tabel migrations tidak ada atau sudah dihapus.\n'; }"
echo.

echo [3/3] Menjalankan migrations...
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
    echo [ERROR] Migrations gagal! Cek error di atas.
    echo.
)
pause

