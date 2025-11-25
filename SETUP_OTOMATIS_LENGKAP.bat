@echo off
echo ============================================
echo SETUP OTOMATIS LENGKAP - TANPA SETTING MANUAL
echo Domain: nuranitms.test
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [INFO] Script ini akan melakukan semua konfigurasi otomatis.
echo [INFO] Tidak perlu setting manual apapun.
echo.
pause

echo.
echo [1/15] Cek Apache running...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% neq 0 (
    echo [WARNING] Apache tidak running!
    echo Silakan start Apache di XAMPP Control Panel terlebih dahulu.
    echo.
    pause
)
echo [OK] Apache status checked.
echo.

echo [2/15] Membuat folder ssl...
if not exist "C:\xampp\apache\conf\ssl" (
    mkdir "C:\xampp\apache\conf\ssl" >nul 2>&1
    echo [OK] Folder ssl dibuat.
) else (
    echo [OK] Folder ssl sudah ada.
)
echo.

echo [3/15] Membuat certificate otomatis...
cd /d "C:\xampp\apache\conf\ssl"

if not exist "nuraniTMS.key" (
    echo Membuat private key...
    openssl genrsa -out nuraniTMS.key 2048 >nul 2>&1
    if %errorlevel% equ 0 (
        echo [OK] Private key dibuat.
    ) else (
        echo [ERROR] Gagal membuat private key!
        pause
    )
) else (
    echo [OK] Private key sudah ada.
)

if not exist "nuraniTMS.crt" (
    echo Membuat certificate...
    openssl req -new -x509 -key nuraniTMS.key -out nuraniTMS.crt -days 365 -subj "/C=ID/ST=Jakarta/L=Jakarta/O=MTs Nurul Aiman/OU=IT Department/CN=nuraniTMS.test/emailAddress=admin@nuraniTMS.test" >nul 2>&1
    if %errorlevel% equ 0 (
        echo [OK] Certificate dibuat.
    ) else (
        echo [ERROR] Gagal membuat certificate!
        echo Mencoba metode alternatif...
        echo. | openssl req -new -key nuraniTMS.key -out nuraniTMS.csr -subj "/C=ID/ST=Jakarta/L=Jakarta/O=MTs Nurul Aiman/OU=IT Department/CN=nuraniTMS.test/emailAddress=admin@nuraniTMS.test" >nul 2>&1
        openssl x509 -req -days 365 -in nuraniTMS.csr -signkey nuraniTMS.key -out nuraniTMS.crt >nul 2>&1
        if %errorlevel% equ 0 (
            echo [OK] Certificate dibuat dengan metode alternatif.
        ) else (
            echo [ERROR] Gagal membuat certificate!
            pause
        )
    )
) else (
    echo [OK] Certificate sudah ada.
)
echo.

cd /d "%~dp0"

echo [4/15] Mengaktifkan mod_ssl di httpd.conf...
powershell -Command "$content = Get-Content 'C:\xampp\apache\conf\httpd.conf' -Raw; $content = $content -replace '#LoadModule ssl_module modules/mod_ssl.so', 'LoadModule ssl_module modules/mod_ssl.so'; Set-Content 'C:\xampp\apache\conf\httpd.conf' -Value $content -NoNewline" >nul 2>&1
echo [OK] mod_ssl diaktifkan.
echo.

echo [5/15] Mengaktifkan httpd-ssl.conf...
powershell -Command "$content = Get-Content 'C:\xampp\apache\conf\httpd.conf' -Raw; $content = $content -replace '#Include conf/extra/httpd-ssl.conf', 'Include conf/extra/httpd-ssl.conf'; Set-Content 'C:\xampp\apache\conf\httpd.conf' -Value $content -NoNewline" >nul 2>&1
echo [OK] httpd-ssl.conf diaktifkan.
echo.

echo [6/15] Mengaktifkan mod_rewrite...
powershell -Command "$content = Get-Content 'C:\xampp\apache\conf\httpd.conf' -Raw; $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content 'C:\xampp\apache\conf\httpd.conf' -Value $content -NoNewline" >nul 2>&1
echo [OK] mod_rewrite diaktifkan.
echo.

echo [7/15] Membuat VirtualHost HTTPS...
powershell -Command "$vhost = @'
# VirtualHost HTTP (redirect ke HTTPS)
<VirtualHost *:80>
    ServerName nuraniTMS.test
    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test
    DocumentRoot \"C:/xampp/htdocs/nurani/public\"
    
    RewriteEngine On
    RewriteCond %%{HTTPS} off
    RewriteRule ^(.*)$ https://%%{HTTP_HOST}%%{REQUEST_URI} [L,R=301]
</VirtualHost>

# VirtualHost HTTPS
<VirtualHost *:443>
    ServerName nuraniTMS.test
    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test
    DocumentRoot \"C:/xampp/htdocs/nurani/public\"
    
    SSLEngine on
    SSLCertificateFile \"C:/xampp/apache/conf/ssl/nuraniTMS.crt\"
    SSLCertificateKeyFile \"C:/xampp/apache/conf/ssl/nuraniTMS.key\"
    
    SSLProtocol all -SSLv2 -SSLv3
    SSLCipherSuite HIGH:!aNULL:!MD5
    
    <Directory \"C:/xampp/htdocs/nurani/public\">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog \"C:/xampp/apache/logs/nuraniTMS_ssl_error.log\"
    CustomLog \"C:/xampp/apache/logs/nuraniTMS_ssl_access.log\" common
</VirtualHost>
'@; $vhostsFile = 'C:\xampp\apache\conf\extra\httpd-vhosts.conf'; $content = Get-Content $vhostsFile -Raw; if ($content -notmatch 'nuraniTMS\.test') { Add-Content $vhostsFile -Value \"`n`n$vhost\" } else { $content = $content -replace '(?s)# VirtualHost.*?nuraniTMS\.test.*?</VirtualHost>', $vhost; Set-Content $vhostsFile -Value $content -NoNewline }" >nul 2>&1
echo [OK] VirtualHost HTTPS dibuat.
echo.

echo [8/15] Update file hosts Windows...
powershell -Command "$hostsFile = 'C:\Windows\System32\drivers\etc\hosts'; $content = Get-Content $hostsFile -Raw; $content = $content -replace '(?m)^127\.0\.0\.1\s+(nurani|nuranitms|nuraniTMS)\.test.*$', ''; $newEntries = @('127.0.0.1    nuraniTMS.test', '127.0.0.1    www.nuraniTMS.test', '127.0.0.1    nuranitms.test', '127.0.0.1    www.nuranitms.test'); $entriesToAdd = $newEntries | Where-Object { $content -notmatch [regex]::Escape($_) }; if ($entriesToAdd) { Add-Content $hostsFile -Value \"`n$($entriesToAdd -join \"`n\")\" }" >nul 2>&1
echo [OK] File hosts diupdate.
echo.

echo [9/15] Flush DNS cache...
ipconfig /flushdns >nul 2>&1
echo [OK] DNS cache di-flush.
echo.

echo [10/15] Update .env...
if exist ".env" (
    powershell -Command "$envFile = '.env'; $content = Get-Content $envFile -Raw; $content = $content -replace 'APP_URL=.*', 'APP_URL=https://nuraniTMS.test'; if ($content -notmatch 'SESSION_SECURE_COOKIE') { $content += \"`nSESSION_SECURE_COOKIE=true\" } else { $content = $content -replace 'SESSION_SECURE_COOKIE=.*', 'SESSION_SECURE_COOKIE=true' }; Set-Content $envFile -Value $content -NoNewline" >nul 2>&1
    echo [OK] .env diupdate.
) else (
    echo [WARNING] File .env tidak ditemukan.
)
echo.

echo [11/15] Clearing Laravel cache...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo [OK] Cache di-clear.
echo.

echo [12/15] Cek port 443...
netstat -ano | findstr :443 >nul
if %errorlevel% equ 0 (
    echo [OK] Port 443 sedang digunakan.
) else (
    echo [INFO] Port 443 belum listen (akan listen setelah restart Apache).
)
echo.

echo [13/15] Informasi restart Apache...
echo.
echo ============================================
echo PENTING: RESTART APACHE!
echo ============================================
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Klik STOP pada Apache
echo 3. Tunggu 5 detik
echo 4. Klik START pada Apache
echo 5. Pastikan status Running (hijau)
echo.
pause

echo.
echo [14/15] Verifikasi konfigurasi...
echo.
echo Certificate: 
if exist "C:\xampp\apache\conf\ssl\nuraniTMS.crt" (
    echo [OK] Certificate ditemukan
) else (
    echo [ERROR] Certificate tidak ditemukan!
)

echo VirtualHost:
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf | findstr /i "nurani" >nul
if %errorlevel% equ 0 (
    echo [OK] VirtualHost HTTPS ditemukan
) else (
    echo [ERROR] VirtualHost HTTPS tidak ditemukan!
)

echo File hosts:
findstr /i "nuranitms.test" C:\Windows\System32\drivers\etc\hosts >nul
if %errorlevel% equ 0 (
    echo [OK] Domain ditemukan di file hosts
) else (
    echo [ERROR] Domain tidak ditemukan di file hosts!
)
echo.

echo [15/15] SELESAI!
echo.
echo ============================================
echo KONFIGURASI OTOMATIS SELESAI!
echo ============================================
echo.
echo Langkah terakhir:
echo 1. RESTART Apache di XAMPP Control Panel (WAJIB!)
echo 2. Buka browser: https://nuranitms.test
echo 3. Klik "Advanced" - "Proceed to site" (untuk self-signed certificate)
echo.
echo Website TMS NURANI akan muncul!
echo.
pause

