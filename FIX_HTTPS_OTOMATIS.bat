@echo off
echo ============================================
echo PERBAIKAN OTOMATIS HTTPS
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [1/6] Cek Apache running...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% neq 0 (
    echo [WARNING] Apache tidak running!
    echo Silakan start Apache di XAMPP Control Panel terlebih dahulu.
    echo.
    pause
)

echo [2/6] Cek mod_ssl...
findstr /C:"LoadModule ssl_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% neq 0 (
    echo [FIX] Mengaktifkan mod_ssl...
    REM Backup httpd.conf
    copy "C:\xampp\apache\conf\httpd.conf" "C:\xampp\apache\conf\httpd.conf.backup" >nul
    
    REM Aktifkan mod_ssl (menggunakan PowerShell untuk replace)
    powershell -Command "(Get-Content 'C:\xampp\apache\conf\httpd.conf') -replace '#LoadModule ssl_module modules/mod_ssl.so', 'LoadModule ssl_module modules/mod_ssl.so' | Set-Content 'C:\xampp\apache\conf\httpd.conf'"
    powershell -Command "(Get-Content 'C:\xampp\apache\conf\httpd.conf') -replace '#Include conf/extra/httpd-ssl.conf', 'Include conf/extra/httpd-ssl.conf' | Set-Content 'C:\xampp\apache\conf\httpd.conf'"
    echo [OK] mod_ssl sudah diaktifkan.
) else (
    echo [OK] mod_ssl sudah aktif.
)
echo.

echo [3/6] Cek certificate...
if not exist "C:\xampp\apache\conf\ssl\nurani.crt" (
    echo [ERROR] Certificate tidak ditemukan!
    echo.
    echo Jalankan: SCRIPT_BUAT_CERTIFICATE.bat
    echo.
    pause
    exit /b 1
) else (
    echo [OK] Certificate ditemukan.
)
echo.

echo [4/6] Cek VirtualHost HTTPS...
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf >nul
if %errorlevel% neq 0 (
    echo [WARNING] VirtualHost HTTPS tidak ditemukan!
    echo.
    echo Silakan copy-paste dari: KONFIGURASI_VIRTUALHOST_HTTPS.txt
    echo ke: C:\xampp\apache\conf\extra\httpd-vhosts.conf
    echo.
    pause
) else (
    echo [OK] VirtualHost HTTPS ditemukan.
)
echo.

echo [5/6] Update .env...
findstr /C:"APP_URL=https://nurani.test" .env >nul
if %errorlevel% neq 0 (
    echo [FIX] Mengupdate APP_URL ke https://...
    powershell -Command "(Get-Content '.env') -replace 'APP_URL=http://nurani.test', 'APP_URL=https://nurani.test' | Set-Content '.env'"
    powershell -Command "(Get-Content '.env') -replace 'APP_URL=http://127.0.0.1:8000', 'APP_URL=https://nurani.test' | Set-Content '.env'"
    echo [OK] APP_URL sudah diupdate.
) else (
    echo [OK] APP_URL sudah benar.
)
echo.

echo [6/6] Clearing cache...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo [OK] Cache sudah di-clear.
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Langkah selanjutnya:
echo 1. Pastikan certificate sudah dibuat (jika belum, jalankan SCRIPT_BUAT_CERTIFICATE.bat)
echo 2. Pastikan VirtualHost HTTPS sudah dibuat (jika belum, copy dari KONFIGURASI_VIRTUALHOST_HTTPS.txt)
echo 3. RESTART Apache di XAMPP Control Panel
echo 4. Test: https://nurani.test
echo.
pause

