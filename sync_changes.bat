@echo off
echo ========================================
echo Sinkronisasi Perubahan Laravel
echo ========================================
echo.

cd /d "D:\Capstone\nurani"

echo [1/5] Clearing configuration cache...
call php artisan config:clear
echo.

echo [2/5] Clearing application cache...
call php artisan cache:clear
echo.

echo [3/5] Clearing view cache...
call php artisan view:clear
echo.

echo [4/5] Clearing route cache...
call php artisan route:clear
echo.

echo [5/5] Clearing all caches...
call php artisan optimize:clear
echo.

echo ========================================
echo Sinkronisasi Selesai!
echo ========================================
echo.
echo Semua perubahan sudah tersinkron untuk:
echo - http://127.0.0.1:8000
echo - http://localhost/nurani/public/
echo.
echo Silakan refresh browser Anda dengan Ctrl+F5
echo.
pause

