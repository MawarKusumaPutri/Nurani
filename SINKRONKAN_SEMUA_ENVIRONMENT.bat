@echo off
echo ========================================
echo   SINKRONKASI SEMUA ENVIRONMENT
echo ========================================
echo.

cd /d "%~dp0"

echo [1/6] Membersihkan semua cache Laravel...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
echo [SUKSES] Semua cache sudah dibersihkan
echo.

echo [2/6] Memastikan storage symlink sudah ada...
if not exist "public\storage" (
    php artisan storage:link
    echo [SUKSES] Storage symlink dibuat
) else (
    echo [INFO] Storage symlink sudah ada
)
echo.

echo [3/6] Memastikan folder storage memiliki permission yang benar...
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\logs" mkdir "storage\logs"
echo [SUKSES] Folder storage sudah siap
echo.

echo [4/6] Memeriksa konfigurasi .env...
if exist .env (
    echo [INFO] File .env ditemukan
    findstr /C:"APP_URL" .env >nul
    if %errorlevel% equ 0 (
        echo [INFO] APP_URL sudah dikonfigurasi
    ) else (
        echo [WARNING] APP_URL belum dikonfigurasi, menambahkan...
        echo. >> .env
        echo APP_URL=http://localhost/nurani/public >> .env
        echo [SUKSES] APP_URL ditambahkan
    )
) else (
    echo [ERROR] File .env tidak ditemukan!
    echo [INFO] Membuat file .env dari .env.example...
    if exist .env.example (
        copy .env.example .env
        echo [SUKSES] File .env dibuat
    ) else (
        echo [ERROR] File .env.example juga tidak ditemukan!
    )
)
echo.

echo [5/6] Memastikan konfigurasi session dan cache menggunakan file...
if exist .env (
    powershell -Command "(Get-Content .env) -replace 'SESSION_DRIVER=database', 'SESSION_DRIVER=file' | Set-Content .env"
    powershell -Command "if ((Get-Content .env) -match 'CACHE_STORE') { (Get-Content .env) -replace 'CACHE_STORE=database', 'CACHE_STORE=file' | Set-Content .env } else { Add-Content .env \"`nCACHE_STORE=file\" }"
    echo [SUKSES] Konfigurasi session dan cache sudah diperbarui
)
echo.

echo [6/6] Finalisasi dan optimasi...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo [SUKSES] Semua cache sudah dibersihkan lagi
echo.

echo ========================================
echo   SINKRONISASI SELESAI!
echo ========================================
echo.
echo [CATATAN PENTING]
echo 1. Kedua URL berikut sekarang menggunakan codebase yang sama:
echo    - http://127.0.0.1:8000 (Laravel dev server)
echo    - http://localhost/nurani/public/ (XAMPP/Apache)
echo.
echo 2. Semua perubahan akan otomatis tersinkron karena menggunakan:
echo    - File yang sama
echo    - Database yang sama
echo    - Cache yang sudah dibersihkan
echo.
echo 3. Jika masih ada masalah, pastikan:
echo    - MySQL berjalan di XAMPP
echo    - Apache berjalan di XAMPP (untuk localhost/nurani/public)
echo    - Laravel dev server berjalan (untuk 127.0.0.1:8000)
echo.
pause

