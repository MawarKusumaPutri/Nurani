@echo off
echo ============================================
echo PERBAIKAN LENGKAP OTOMATIS
echo Domain: nuranitms.test / nuraniTMS.test
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [1/10] Cek Apache running...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running.
) else (
    echo [ERROR] Apache TIDAK running!
    echo.
    echo Silakan start Apache di XAMPP Control Panel terlebih dahulu.
    echo.
    pause
    exit /b 1
)
echo.

echo [2/10] Cek mod_ssl...
findstr /C:"LoadModule ssl_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% neq 0 (
    echo [FIX] Mengaktifkan mod_ssl...
    powershell -Command "(Get-Content 'C:\xampp\apache\conf\httpd.conf') -replace '#LoadModule ssl_module modules/mod_ssl.so', 'LoadModule ssl_module modules/mod_ssl.so' | Set-Content 'C:\xampp\apache\conf\httpd.conf'"
    echo [OK] mod_ssl sudah diaktifkan.
) else (
    echo [OK] mod_ssl sudah aktif.
)
echo.

echo [3/10] Cek httpd-ssl.conf...
findstr /C:"Include conf/extra/httpd-ssl.conf" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% neq 0 (
    echo [FIX] Mengaktifkan httpd-ssl.conf...
    powershell -Command "(Get-Content 'C:\xampp\apache\conf\httpd.conf') -replace '#Include conf/extra/httpd-ssl.conf', 'Include conf/extra/httpd-ssl.conf' | Set-Content 'C:\xampp\apache\conf\httpd.conf'"
    echo [OK] httpd-ssl.conf sudah diaktifkan.
) else (
    echo [OK] httpd-ssl.conf sudah aktif.
)
echo.

echo [4/10] Cek mod_rewrite...
findstr /C:"LoadModule rewrite_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% neq 0 (
    echo [FIX] Mengaktifkan mod_rewrite...
    powershell -Command "(Get-Content 'C:\xampp\apache\conf\httpd.conf') -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so' | Set-Content 'C:\xampp\apache\conf\httpd.conf'"
    echo [OK] mod_rewrite sudah diaktifkan.
) else (
    echo [OK] mod_rewrite sudah aktif.
)
echo.

echo [5/10] Cek folder ssl...
if not exist "C:\xampp\apache\conf\ssl" (
    echo [FIX] Membuat folder ssl...
    mkdir "C:\xampp\apache\conf\ssl"
    echo [OK] Folder ssl dibuat.
) else (
    echo [OK] Folder ssl ditemukan.
)
echo.

echo [6/10] Cek certificate...
if not exist "C:\xampp\apache\conf\ssl\nuraniTMS.crt" (
    echo [ERROR] Certificate tidak ditemukan!
    echo.
    echo Jalankan: SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat
    echo.
    pause
) else (
    echo [OK] Certificate ditemukan.
)
echo.

echo [7/10] Cek VirtualHost HTTPS...
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf | findstr /i "nurani" >nul
if %errorlevel% neq 0 (
    echo [WARNING] VirtualHost HTTPS tidak ditemukan!
    echo.
    echo Silakan copy-paste dari: KONFIGURASI_VIRTUALHOST_LENGKAP.txt
    echo ke: C:\xampp\apache\conf\extra\httpd-vhosts.conf
    echo.
    pause
) else (
    echo [OK] VirtualHost HTTPS ditemukan.
)
echo.

echo [8/10] Cek file hosts...
findstr /i "nuranitms.test" C:\Windows\System32\drivers\etc\hosts >nul
if %errorlevel% neq 0 (
    echo [WARNING] Domain nuranitms.test tidak ditemukan di file hosts!
    echo.
    echo Silakan update file hosts dengan:
    echo 127.0.0.1    nuraniTMS.test
    echo 127.0.0.1    www.nuraniTMS.test
    echo 127.0.0.1    nuranitms.test
    echo 127.0.0.1    www.nuranitms.test
    echo.
    echo Lihat: COPY_PASTE_HOSTS_LENGKAP.txt
    echo.
    pause
) else (
    echo [OK] Domain ditemukan di file hosts.
)
echo.

echo [9/10] Update .env...
if exist ".env" (
    findstr /C:"APP_URL=https://nuraniTMS.test" .env >nul
    if %errorlevel% neq 0 (
        echo [FIX] Mengupdate APP_URL...
        powershell -Command "(Get-Content '.env') -replace 'APP_URL=http://nurani.test', 'APP_URL=https://nuraniTMS.test' | Set-Content '.env'"
        powershell -Command "(Get-Content '.env') -replace 'APP_URL=https://nurani.test', 'APP_URL=https://nuraniTMS.test' | Set-Content '.env'"
        powershell -Command "(Get-Content '.env') -replace 'APP_URL=http://127.0.0.1:8000', 'APP_URL=https://nuraniTMS.test' | Set-Content '.env'"
        echo [OK] APP_URL sudah diupdate.
    ) else (
        echo [OK] APP_URL sudah benar.
    )
    
    findstr /C:"SESSION_SECURE_COOKIE" .env >nul
    if %errorlevel% neq 0 (
        echo [FIX] Menambahkan SESSION_SECURE_COOKIE...
        echo. >> .env
        echo SESSION_SECURE_COOKIE=true >> .env
        echo [OK] SESSION_SECURE_COOKIE ditambahkan.
    ) else (
        powershell -Command "(Get-Content '.env') -replace 'SESSION_SECURE_COOKIE=false', 'SESSION_SECURE_COOKIE=true' | Set-Content '.env'"
        echo [OK] SESSION_SECURE_COOKIE sudah benar.
    )
) else (
    echo [ERROR] File .env tidak ditemukan!
)
echo.

echo [10/10] Clearing cache...
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
echo 1. Update file hosts (jika belum) - lihat COPY_PASTE_HOSTS_LENGKAP.txt
echo 2. Update VirtualHost (jika belum) - lihat KONFIGURASI_VIRTUALHOST_LENGKAP.txt
echo 3. Buat certificate (jika belum) - jalankan SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat
echo 4. RESTART Apache di XAMPP Control Panel
echo 5. Flush DNS: ipconfig /flushdns
echo 6. Test: https://nuranitms.test
echo.
echo Jika masih error, RESTART KOMPUTER!
echo.
pause

