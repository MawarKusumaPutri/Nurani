@echo off
title FIX nuranitms.test - PASTI BERFUNGSI
color 0A

echo.
echo ============================================
echo FIX nuranitms.test - PASTI BERFUNGSI
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [1] Membuat folder ssl...
if not exist "C:\xampp\apache\conf\ssl" mkdir "C:\xampp\apache\conf\ssl"
echo [OK]
echo.

echo [2] Membuat certificate...
cd /d "C:\xampp\apache\conf\ssl"
if not exist "nuraniTMS.key" (
    openssl genrsa -out nuraniTMS.key 2048 >nul 2>&1
)
if not exist "nuraniTMS.crt" (
    openssl req -new -x509 -key nuraniTMS.key -out nuraniTMS.crt -days 365 -subj "/C=ID/ST=Jakarta/L=Jakarta/O=MTs/CN=nuraniTMS.test" >nul 2>&1
    if not exist "nuraniTMS.crt" (
        echo. | openssl req -new -key nuraniTMS.key -out nuraniTMS.csr -subj "/C=ID/ST=Jakarta/L=Jakarta/O=MTs/CN=nuraniTMS.test" >nul 2>&1
        openssl x509 -req -days 365 -in nuraniTMS.csr -signkey nuraniTMS.key -out nuraniTMS.crt >nul 2>&1
    )
)
cd /d "%~dp0"
echo [OK]
echo.

echo [3] Mengaktifkan mod_ssl...
powershell -Command "(Get-Content 'C:\xampp\apache\conf\httpd.conf') -replace '#LoadModule ssl_module', 'LoadModule ssl_module' | Set-Content 'C:\xampp\apache\conf\httpd.conf'"
powershell -Command "(Get-Content 'C:\xampp\apache\conf\httpd.conf') -replace '#Include conf/extra/httpd-ssl.conf', 'Include conf/extra/httpd-ssl.conf' | Set-Content 'C:\xampp\apache\conf\httpd.conf'"
powershell -Command "(Get-Content 'C:\xampp\apache\conf\httpd.conf') -replace '#LoadModule rewrite_module', 'LoadModule rewrite_module' | Set-Content 'C:\xampp\apache\conf\httpd.conf'"
echo [OK]
echo.

echo [4] Membuat VirtualHost...
(
echo.
echo # VirtualHost untuk nuranitms.test
echo ^<VirtualHost *:80^>
echo     ServerName nuraniTMS.test
echo     ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test
echo     DocumentRoot "C:/xampp/htdocs/nurani/public"
echo     RewriteEngine On
echo     RewriteCond %%{HTTPS} off
echo     RewriteRule ^^(.*^)$ https://%%{HTTP_HOST}%%{REQUEST_URI} [L,R=301]
echo ^</VirtualHost^>
echo.
echo ^<VirtualHost *:443^>
echo     ServerName nuraniTMS.test
echo     ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test
echo     DocumentRoot "C:/xampp/htdocs/nurani/public"
echo     SSLEngine on
echo     SSLCertificateFile "C:/xampp/apache/conf/ssl/nuraniTMS.crt"
echo     SSLCertificateKeyFile "C:/xampp/apache/conf/ssl/nuraniTMS.key"
echo     SSLProtocol all -SSLv2 -SSLv3
echo     SSLCipherSuite HIGH:!aNULL:!MD5
echo     ^<Directory "C:/xampp/htdocs/nurani/public"^>
echo         Options Indexes FollowSymLinks
echo         AllowOverride All
echo         Require all granted
echo     ^</Directory^>
echo ^</VirtualHost^>
) >> "C:\xampp\apache\conf\extra\httpd-vhosts.conf"
echo [OK]
echo.

echo [5] Update file hosts...
(
echo 127.0.0.1    nuraniTMS.test
echo 127.0.0.1    www.nuraniTMS.test
echo 127.0.0.1    nuranitms.test
echo 127.0.0.1    www.nuranitms.test
) >> "C:\Windows\System32\drivers\etc\hosts"
echo [OK]
echo.

echo [6] Flush DNS...
ipconfig /flushdns >nul 2>&1
echo [OK]
echo.

echo [7] Update .env...
if exist ".env" (
    powershell -Command "(Get-Content '.env') -replace 'APP_URL=.*', 'APP_URL=https://nuraniTMS.test' | Set-Content '.env'"
    findstr /C:"SESSION_SECURE_COOKIE" .env >nul || echo SESSION_SECURE_COOKIE=true >> .env
)
echo [OK]
echo.

echo [8] Clear cache...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
echo [OK]
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR:
echo 1. Buka XAMPP Control Panel
echo 2. STOP Apache
echo 3. TUNGGU 10 DETIK
echo 4. START Apache
echo 5. Buka browser: https://nuranitms.test
echo.
pause

