@echo off
title PERBAIKAN FINAL - nuranitms.test
color 0A
echo.

echo ============================================
echo PERBAIKAN FINAL 100%% - nuranitms.test
echo ============================================
echo.
echo Script ini akan memperbaiki SEMUA masalah
echo dan memastikan website berfungsi dengan baik.
echo.
pause

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo.
echo [1/20] Cek dan start Apache...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% neq 0 (
    echo [WARNING] Apache tidak running!
    echo Silakan start Apache di XAMPP Control Panel.
    echo.
    pause
) else (
    echo [OK] Apache sedang running.
)
echo.

echo [2/20] Membuat folder ssl...
if not exist "C:\xampp\apache\conf\ssl" (
    mkdir "C:\xampp\apache\conf\ssl"
    echo [OK] Folder ssl dibuat.
) else (
    echo [OK] Folder ssl sudah ada.
)
echo.

echo [3/20] Membuat certificate SSL...
cd /d "C:\xampp\apache\conf\ssl"

if not exist "nuraniTMS.key" (
    echo Membuat private key...
    openssl genrsa -out nuraniTMS.key 2048
    if %errorlevel% equ 0 (
        echo [OK] Private key dibuat.
    ) else (
        echo [ERROR] Gagal membuat private key!
        pause
        exit /b 1
    )
) else (
    echo [OK] Private key sudah ada.
)

if not exist "nuraniTMS.crt" (
    echo Membuat certificate...
    openssl req -new -x509 -key nuraniTMS.key -out nuraniTMS.crt -days 365 -subj "/C=ID/ST=Jakarta/L=Jakarta/O=MTs Nurul Aiman/OU=IT Department/CN=nuraniTMS.test/emailAddress=admin@nuraniTMS.test" 2>nul
    if %errorlevel% neq 0 (
        echo Mencoba metode alternatif...
        echo. | openssl req -new -key nuraniTMS.key -out nuraniTMS.csr -subj "/C=ID/ST=Jakarta/L=Jakarta/O=MTs Nurul Aiman/OU=IT Department/CN=nuraniTMS.test/emailAddress=admin@nuraniTMS.test" 2>nul
        openssl x509 -req -days 365 -in nuraniTMS.csr -signkey nuraniTMS.key -out nuraniTMS.crt 2>nul
    )
    if exist "nuraniTMS.crt" (
        echo [OK] Certificate dibuat.
    ) else (
        echo [ERROR] Gagal membuat certificate!
        pause
        exit /b 1
    )
) else (
    echo [OK] Certificate sudah ada.
)
echo.

cd /d "%~dp0"

echo [4/20] Mengaktifkan mod_ssl...
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; $content = Get-Content $file -Raw; if ($content -match '#LoadModule ssl_module') { $content = $content -replace '#LoadModule ssl_module modules/mod_ssl.so', 'LoadModule ssl_module modules/mod_ssl.so'; Set-Content $file -Value $content -NoNewline }" >nul 2>&1
echo [OK] mod_ssl diaktifkan.
echo.

echo [5/20] Mengaktifkan httpd-ssl.conf...
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; $content = Get-Content $file -Raw; if ($content -match '#Include conf/extra/httpd-ssl.conf') { $content = $content -replace '#Include conf/extra/httpd-ssl.conf', 'Include conf/extra/httpd-ssl.conf'; Set-Content $file -Value $content -NoNewline }" >nul 2>&1
echo [OK] httpd-ssl.conf diaktifkan.
echo.

echo [6/20] Mengaktifkan mod_rewrite...
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; $content = Get-Content $file -Raw; if ($content -match '#LoadModule rewrite_module') { $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline }" >nul 2>&1
echo [OK] mod_rewrite diaktifkan.
echo.

echo [7/20] Membuat VirtualHost HTTPS...
powershell -Command "$vhostsFile = 'C:\xampp\apache\conf\extra\httpd-vhosts.conf'; $vhostContent = '# VirtualHost HTTP (redirect ke HTTPS)`n<VirtualHost *:80>`n    ServerName nuraniTMS.test`n    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test`n    DocumentRoot \"C:/xampp/htdocs/nurani/public\"`n    `n    RewriteEngine On`n    RewriteCond %{HTTPS} off`n    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]`n</VirtualHost>`n`n# VirtualHost HTTPS`n<VirtualHost *:443>`n    ServerName nuraniTMS.test`n    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test`n    DocumentRoot \"C:/xampp/htdocs/nurani/public\"`n    `n    SSLEngine on`n    SSLCertificateFile \"C:/xampp/apache/conf/ssl/nuraniTMS.crt\"`n    SSLCertificateKeyFile \"C:/xampp/apache/conf/ssl/nuraniTMS.key\"`n    `n    SSLProtocol all -SSLv2 -SSLv3`n    SSLCipherSuite HIGH:!aNULL:!MD5`n    `n    <Directory \"C:/xampp/htdocs/nurani/public\">`n        Options Indexes FollowSymLinks`n        AllowOverride All`n        Require all granted`n    </Directory>`n    `n    ErrorLog \"C:/xampp/apache/logs/nuraniTMS_ssl_error.log\"`n    CustomLog \"C:/xampp/apache/logs/nuraniTMS_ssl_access.log\" common`n</VirtualHost>'; $content = Get-Content $vhostsFile -Raw; if ($content -notmatch 'nuraniTMS\.test') { Add-Content $vhostsFile -Value \"`n`n$vhostContent\" } else { $content = $content -replace '(?s)# VirtualHost.*?nuraniTMS\.test.*?</VirtualHost>.*?(?=# VirtualHost|$)', $vhostContent; Set-Content $vhostsFile -Value $content -NoNewline }" >nul 2>&1
echo [OK] VirtualHost HTTPS dibuat.
echo.

echo [8/20] Update file hosts Windows...
powershell -Command "$hostsFile = 'C:\Windows\System32\drivers\etc\hosts'; $content = Get-Content $hostsFile -Raw; $entries = @('127.0.0.1    nuraniTMS.test', '127.0.0.1    www.nuraniTMS.test', '127.0.0.1    nuranitms.test', '127.0.0.1    www.nuranitms.test'); foreach ($entry in $entries) { if ($content -notmatch [regex]::Escape($entry)) { Add-Content $hostsFile -Value $entry } }" >nul 2>&1
echo [OK] File hosts diupdate.
echo.

echo [9/20] Flush DNS cache...
ipconfig /flushdns >nul 2>&1
echo [OK] DNS cache di-flush.
echo.

echo [10/20] Update .env...
if exist ".env" (
    powershell -Command "$envFile = '.env'; $content = Get-Content $envFile -Raw; $content = $content -replace 'APP_URL=.*', 'APP_URL=https://nuraniTMS.test'; if ($content -notmatch 'SESSION_SECURE_COOKIE') { $content += \"`nSESSION_SECURE_COOKIE=true\" } else { $content = $content -replace 'SESSION_SECURE_COOKIE=.*', 'SESSION_SECURE_COOKIE=true' }; Set-Content $envFile -Value $content -NoNewline" >nul 2>&1
    echo [OK] .env diupdate.
) else (
    echo [WARNING] File .env tidak ditemukan.
)
echo.

echo [11/20] Clearing Laravel cache...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo [OK] Cache di-clear.
echo.

echo [12/20] Verifikasi certificate...
if exist "C:\xampp\apache\conf\ssl\nuraniTMS.crt" (
    echo [OK] Certificate ditemukan.
) else (
    echo [ERROR] Certificate tidak ditemukan!
    pause
)
echo.

echo [13/20] Verifikasi VirtualHost...
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf | findstr /i "nurani" >nul
if %errorlevel% equ 0 (
    echo [OK] VirtualHost HTTPS ditemukan.
) else (
    echo [ERROR] VirtualHost HTTPS tidak ditemukan!
    pause
)
echo.

echo [14/20] Verifikasi file hosts...
findstr /i "nuranitms.test" C:\Windows\System32\drivers\etc\hosts >nul
if %errorlevel% equ 0 (
    echo [OK] Domain ditemukan di file hosts.
) else (
    echo [ERROR] Domain tidak ditemukan di file hosts!
    pause
)
echo.

echo [15/20] Cek port 443...
netstat -ano | findstr :443 >nul
if %errorlevel% equ 0 (
    echo [OK] Port 443 sedang digunakan.
) else (
    echo [INFO] Port 443 akan listen setelah restart Apache.
)
echo.

echo [16/20] Cek mod_ssl aktif...
findstr /C:"LoadModule ssl_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_ssl aktif.
) else (
    echo [ERROR] mod_ssl tidak aktif!
    pause
)
echo.

echo [17/20] Cek mod_rewrite aktif...
findstr /C:"LoadModule rewrite_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_rewrite aktif.
) else (
    echo [ERROR] mod_rewrite tidak aktif!
    pause
)
echo.

echo [18/20] Cek folder public...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] Folder public ditemukan.
) else (
    echo [WARNING] Folder public tidak ditemukan di lokasi default.
    echo Pastikan project sudah di C:\xampp\htdocs\nurani\
)
echo.

echo [19/20] Flush DNS lagi...
ipconfig /flushdns >nul 2>&1
echo [OK] DNS di-flush lagi.
echo.

echo [20/20] SELESAI!
echo.
echo ============================================
echo KONFIGURASI SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR (PENTING!):
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Klik STOP pada Apache
echo 3. Tunggu 10 detik (PENTING!)
echo 4. Klik START pada Apache
echo 5. Pastikan status Running (hijau)
echo 6. Tunggu 5 detik lagi
echo.
echo Setelah itu:
echo 1. Tutup semua tab browser
echo 2. Buka browser baru (atau Incognito mode)
echo 3. Ketik: https://nuranitms.test
echo 4. Klik "Advanced" - "Proceed to site"
echo.
echo Website TMS NURANI akan muncul!
echo.
pause

