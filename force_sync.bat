@echo off
echo ========================================
echo FORCE SYNC - Memastikan Sinkronisasi
echo ========================================
echo.

cd /d "D:\Capstone\nurani"

echo [1/6] Clearing semua cache...
call php artisan optimize:clear
echo.

echo [2/6] Clearing view cache...
call php artisan view:clear
echo.

echo [3/6] Clearing application cache...
call php artisan cache:clear
echo.

echo [4/6] Clearing config cache...
call php artisan config:clear
echo.

echo [5/6] Clearing route cache...
call php artisan route:clear
echo.

echo [6/6] Rebuilding cache...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache
echo.

echo ========================================
echo SINKRONISASI SELESAI!
echo ========================================
echo.
echo Langkah selanjutnya:
echo 1. Clear browser cache (Ctrl+Shift+Delete)
echo 2. Hard refresh browser (Ctrl+F5)
echo 3. Restart Apache/XAMPP jika perlu
echo.
echo File yang sudah tersinkron:
echo - app/Http/Controllers/GuruController.php
echo - app/Models/Guru.php
echo - resources/views/guru/dashboard.blade.php
echo - resources/views/guru/jadwal/index.blade.php
echo - 18 file view guru lainnya
echo.
pause

