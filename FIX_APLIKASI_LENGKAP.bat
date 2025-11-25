@echo off
echo ========================================
echo   PERBAIKAN APLIKASI LENGKAP
echo ========================================
echo.

cd /d "%~dp0"

echo [1/5] Memastikan konfigurasi session dan cache menggunakan file...
REM Update .env jika perlu
if exist .env (
    powershell -Command "(Get-Content .env) -replace 'SESSION_DRIVER=database', 'SESSION_DRIVER=file' | Set-Content .env"
    powershell -Command "if ((Get-Content .env) -match 'CACHE_STORE') { (Get-Content .env) -replace 'CACHE_STORE=database', 'CACHE_STORE=file' | Set-Content .env } else { Add-Content .env \"`nCACHE_STORE=file\" }"
    echo [SUKSES] Konfigurasi .env sudah diperbarui
) else (
    echo [WARNING] File .env tidak ditemukan
)
echo.

echo [2/5] Membersihkan cache Laravel...
php artisan config:clear 2>nul
if %errorlevel% equ 0 (
    echo [SUKSES] Config cache cleared
) else (
    echo [INFO] Config cache clear (mungkin ada error karena MySQL belum jalan, tapi tidak masalah)
)
php artisan route:clear 2>nul
php artisan view:clear 2>nul
echo.

echo [3/5] Memeriksa status MySQL...
REM Cek apakah MySQL berjalan
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); echo '[SUKSES] MySQL sudah berjalan!\n'; } catch(Exception $e) { echo '[ERROR] MySQL belum berjalan!\n'; }" 2>nul
if %errorlevel% neq 0 (
    echo [WARNING] MySQL belum berjalan!
    echo.
    echo [INFO] Menjalankan script untuk start MySQL...
    call START_MYSQL_XAMPP.bat
    echo.
    echo [INSTRUKSI] Setelah MySQL berjalan, jalankan script ini lagi atau refresh browser
    pause
    exit /b
)
echo.

echo [4/5] Memastikan folder storage memiliki permission yang benar...
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\framework\views" mkdir "storage\framework\views"
echo [SUKSES] Folder storage sudah siap
echo.

echo [5/5] Finalisasi...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo [SUKSES] Semua cache sudah dibersihkan
echo.

echo ========================================
echo   PERBAIKAN SELESAI!
echo ========================================
echo.
echo [LANGKAH SELANJUTNYA]
echo 1. Pastikan MySQL berjalan di XAMPP Control Panel
echo 2. Buka browser dan akses: http://localhost/nurani/public/
echo 3. Aplikasi seharusnya sudah muncul dengan normal
echo.
pause

