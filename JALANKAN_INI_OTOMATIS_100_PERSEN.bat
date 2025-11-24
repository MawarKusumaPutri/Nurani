@echo off
title SETUP OTOMATIS 100%% - TANPA SETTING MANUAL
color 0A

echo.
echo ============================================
echo SETUP OTOMATIS 100%% - TANPA SETTING MANUAL
echo ============================================
echo.
echo Script ini akan melakukan SEMUA konfigurasi
echo otomatis. TIDAK PERLU SETTING MANUAL APAPUN!
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo [ERROR] File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo.
echo [1/10] Menyalin project ke htdocs...
if not exist "C:\xampp\htdocs" (
    echo [ERROR] Folder htdocs tidak ditemukan!
    echo Pastikan XAMPP sudah terinstall.
    pause
    exit /b 1
)

if exist "C:\xampp\htdocs\nurani" (
    echo [INFO] Menghapus folder lama...
    rmdir /s /q "C:\xampp\htdocs\nurani" 2>nul
    timeout /t 2 >nul
)

echo [INFO] Menyalin project (mohon tunggu...)...
robocopy "%CD%" "C:\xampp\htdocs\nurani" /E /COPYALL /R:1 /W:1 /NP /NFL /NDL >nul 2>&1

if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] Project berhasil disalin.
) else (
    echo [ERROR] Gagal menyalin project!
    pause
    exit /b 1
)
echo.

echo [2/10] Membuat file .htaccess...
if not exist "C:\xampp\htdocs\nurani\public\.htaccess" (
    copy "%CD%\public\.htaccess" "C:\xampp\htdocs\nurani\public\.htaccess" >nul 2>&1
    if not exist "C:\xampp\htdocs\nurani\public\.htaccess" (
        (
            echo ^<IfModule mod_rewrite.c^>
            echo     ^<IfModule mod_negotiation.c^>
            echo         Options -MultiViews -Indexes
            echo     ^</IfModule^>
            echo.
            echo     RewriteEngine On
            echo.
            echo     # Handle Authorization Header
            echo     RewriteCond %%{HTTP:Authorization} .
            echo     RewriteRule .* - [E=HTTP_AUTHORIZATION:%%{HTTP:Authorization}]
            echo.
            echo     # Handle X-XSRF-Token Header
            echo     RewriteCond %%{HTTP:x-xsrf-token} .
            echo     RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%%{HTTP:X-XSRF-Token}]
            echo.
            echo     # Redirect Trailing Slashes If Not A Folder...
            echo     RewriteCond %%{REQUEST_FILENAME} !-d
            echo     RewriteCond %%{REQUEST_URI} ^(.+)/$
            echo     RewriteRule ^ %%1 [L,R=301]
            echo.
            echo     # Send Requests To Front Controller...
            echo     RewriteCond %%{REQUEST_FILENAME} !-d
            echo     RewriteCond %%{REQUEST_FILENAME} !-f
            echo     RewriteRule ^ index.php [L]
            echo ^</IfModule^>
        ) > "C:\xampp\htdocs\nurani\public\.htaccess"
    )
)
echo [OK] File .htaccess sudah ada.
echo.

echo [3/10] Mengaktifkan mod_rewrite...
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; if (Test-Path $file) { $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline }" >nul 2>&1
echo [OK] mod_rewrite diaktifkan.
echo.

echo [4/10] Membuat folder ssl...
if not exist "C:\xampp\apache\conf\ssl" mkdir "C:\xampp\apache\conf\ssl" >nul 2>&1
echo [OK] Folder ssl siap.
echo.

echo [5/10] Membuat certificate SSL...
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
echo [OK] Certificate siap.
echo.

echo [6/10] Mengaktifkan mod_ssl...
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; if (Test-Path $file) { $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule ssl_module modules/mod_ssl.so', 'LoadModule ssl_module modules/mod_ssl.so'; $content = $content -replace '#Include conf/extra/httpd-ssl.conf', 'Include conf/extra/httpd-ssl.conf'; Set-Content $file -Value $content -NoNewline }" >nul 2>&1
echo [OK] mod_ssl diaktifkan.
echo.

echo [7/10] Membuat VirtualHost HTTPS...
powershell -Command "$vhostsFile = 'C:\xampp\apache\conf\extra\httpd-vhosts.conf'; $vhost = \"`n# VirtualHost untuk nuranitms.test`n<VirtualHost *:80>`n    ServerName nuraniTMS.test`n    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test`n    DocumentRoot \"C:/xampp/htdocs/nurani/public\"`n    RewriteEngine On`n    RewriteCond %{HTTPS} off`n    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]`n</VirtualHost>`n`n<VirtualHost *:443>`n    ServerName nuraniTMS.test`n    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test`n    DocumentRoot \"C:/xampp/htdocs/nurani/public\"`n    SSLEngine on`n    SSLCertificateFile \"C:/xampp/apache/conf/ssl/nuraniTMS.crt\"`n    SSLCertificateKeyFile \"C:/xampp/apache/conf/ssl/nuraniTMS.key\"`n    SSLProtocol all -SSLv2 -SSLv3`n    SSLCipherSuite HIGH:!aNULL:!MD5`n    <Directory \"C:/xampp/htdocs/nurani/public\">`n        Options Indexes FollowSymLinks`n        AllowOverride All`n        Require all granted`n    </Directory>`n</VirtualHost>`n\"; if ((Get-Content $vhostsFile -Raw) -notmatch 'nuraniTMS\.test') { Add-Content $vhostsFile -Value $vhost }" >nul 2>&1
echo [OK] VirtualHost HTTPS dibuat.
echo.

echo [8/10] Update file hosts...
powershell -Command "$hostsFile = 'C:\Windows\System32\drivers\etc\hosts'; $entries = @('127.0.0.1    nuraniTMS.test', '127.0.0.1    www.nuraniTMS.test', '127.0.0.1    nuranitms.test', '127.0.0.1    www.nuranitms.test'); $content = Get-Content $hostsFile -Raw; foreach ($entry in $entries) { if ($content -notmatch [regex]::Escape($entry)) { Add-Content $hostsFile -Value $entry } }" >nul 2>&1
echo [OK] File hosts diupdate.
echo.

echo [9/10] Flush DNS dan update .env...
ipconfig /flushdns >nul 2>&1
if exist ".env" (
    powershell -Command "$envFile = '.env'; $content = Get-Content $envFile -Raw; $content = $content -replace 'APP_URL=.*', 'APP_URL=https://nuraniTMS.test'; if ($content -notmatch 'SESSION_SECURE_COOKIE') { $content += \"`nSESSION_SECURE_COOKIE=true\" } else { $content = $content -replace 'SESSION_SECURE_COOKIE=.*', 'SESSION_SECURE_COOKIE=true' }; Set-Content $envFile -Value $content -NoNewline" >nul 2>&1
    if exist "C:\xampp\htdocs\nurani\.env" (
        powershell -Command "$envFile = 'C:\xampp\htdocs\nurani\.env'; $content = Get-Content $envFile -Raw; $content = $content -replace 'APP_URL=.*', 'APP_URL=https://nuraniTMS.test'; if ($content -notmatch 'SESSION_SECURE_COOKIE') { $content += \"`nSESSION_SECURE_COOKIE=true\" } else { $content = $content -replace 'SESSION_SECURE_COOKIE=.*', 'SESSION_SECURE_COOKIE=true' }; Set-Content $envFile -Value $content -NoNewline" >nul 2>&1
    )
)
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
echo [OK] DNS di-flush dan cache di-clear.
echo.

echo [10/10] Verifikasi final...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] Project siap di: C:\xampp\htdocs\nurani\
) else (
    echo [ERROR] Project tidak ditemukan!
    pause
    exit /b 1
)
echo.

echo ============================================
echo SELESAI! SEMUA KONFIGURASI OTOMATIS!
echo ============================================
echo.
echo LANGKAH TERAKHIR (HANYA INI YANG MANUAL):
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Klik STOP pada Apache
echo 3. TUNGGU 5 DETIK
echo 4. Klik START pada Apache
echo 5. Pastikan status Running (hijau)
echo.
echo Setelah itu:
echo 1. Buka browser
echo 2. Ketik: https://nuranitms.test
echo 3. Tekan Enter
echo 4. Klik "Advanced" - "Proceed to site"
echo.
echo Website TMS NURANI akan muncul!
echo.
echo ============================================
echo ATAU TEST DENGAN LOCALHOST:
echo ============================================
echo.
echo 1. Buka browser
echo 2. Ketik: http://localhost/nurani/public
echo 3. Tekan Enter
echo.
echo Website Laravel akan muncul!
echo.
pause

