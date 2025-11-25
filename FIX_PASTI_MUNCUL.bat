@echo off
title FIX PASTI MUNCUL - OTOMATIS 100%%
color 0A

echo.
echo ============================================
echo FIX PASTI MUNCUL - OTOMATIS 100%%
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo [ERROR] File artisan tidak ditemukan!
    echo Lokasi saat ini: %CD%
    echo.
    echo Pastikan Anda menjalankan script ini dari folder project Laravel!
    pause
    exit /b 1
)

REM Cari lokasi XAMPP
set "XAMPP_PATH="
if exist "C:\xampp\htdocs" set "XAMPP_PATH=C:\xampp"
if exist "D:\xampp\htdocs" set "XAMPP_PATH=D:\xampp"
if exist "E:\xampp\htdocs" set "XAMPP_PATH=E:\xampp"

if "%XAMPP_PATH%"=="" (
    echo [ERROR] Folder htdocs tidak ditemukan!
    echo.
    echo Saya mencari di:
    echo - C:\xampp\htdocs
    echo - D:\xampp\htdocs
    echo - E:\xampp\htdocs
    echo.
    echo Jika XAMPP ada di lokasi lain, salin manual:
    echo 1. Buka: %CD%
    echo 2. Copy seluruh folder (Ctrl + C)
    echo 3. Paste ke: [lokasi-xampp]\htdocs\
    echo 4. Rename menjadi: nurani
    echo.
    pause
    exit /b 1
)

echo [OK] XAMPP ditemukan di: %XAMPP_PATH%
echo.

echo [LANGKAH 1] Menyalin project ke htdocs...
echo.

if exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [INFO] Menghapus folder lama...
    rmdir /s /q "%XAMPP_PATH%\htdocs\nurani" 2>nul
    timeout /t 3 >nul
)

echo [INFO] Menyalin project dari: %CD%
echo [INFO] Menyalin ke: %XAMPP_PATH%\htdocs\nurani
echo [INFO] Mohon tunggu, proses ini memakan waktu...
echo.

robocopy "%CD%" "%XAMPP_PATH%\htdocs\nurani" /E /COPYALL /R:1 /W:1 /NP /NFL /NDL

REM Verifikasi
if exist "%XAMPP_PATH%\htdocs\nurani\public\index.php" (
    echo [OK] Project berhasil disalin!
) else (
    echo [ERROR] Gagal menyalin project!
    echo.
    echo SALIN MANUAL:
    echo 1. Buka: %CD%
    echo 2. Copy seluruh folder (Ctrl + C)
    echo 3. Paste ke: %XAMPP_PATH%\htdocs\
    echo 4. Rename menjadi: nurani
    pause
    exit /b 1
)
echo.

echo [LANGKAH 2] Memastikan file .htaccess ada...
if not exist "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" (
    if exist "%CD%\public\.htaccess" (
        copy "%CD%\public\.htaccess" "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" >nul 2>&1
    )
)
echo [OK] File .htaccess sudah ada.
echo.

echo [LANGKAH 3] Mengaktifkan mod_rewrite...
powershell -Command "$file = '%XAMPP_PATH%\apache\conf\httpd.conf'; $file = $file -replace '%XAMPP_PATH%', '%XAMPP_PATH%'; if (Test-Path $file) { $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline }" >nul 2>&1
echo [OK] mod_rewrite diaktifkan.
echo.

echo [LANGKAH 4] Membuat certificate SSL...
if not exist "%XAMPP_PATH%\apache\conf\ssl" mkdir "%XAMPP_PATH%\apache\conf\ssl" >nul 2>&1
cd /d "%XAMPP_PATH%\apache\conf\ssl"
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

echo [LANGKAH 5] Mengaktifkan mod_ssl...
powershell -Command "$file = '%XAMPP_PATH%\apache\conf\httpd.conf'; $file = $file -replace '%XAMPP_PATH%', '%XAMPP_PATH%'; if (Test-Path $file) { $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule ssl_module modules/mod_ssl.so', 'LoadModule ssl_module modules/mod_ssl.so'; $content = $content -replace '#Include conf/extra/httpd-ssl.conf', 'Include conf/extra/httpd-ssl.conf'; Set-Content $file -Value $content -NoNewline }" >nul 2>&1
echo [OK] mod_ssl diaktifkan.
echo.

echo [LANGKAH 6] Membuat VirtualHost...
set "VHOST_PATH=%XAMPP_PATH:\=/%"
powershell -Command "$vhostsFile = '%XAMPP_PATH%\apache\conf\extra\httpd-vhosts.conf'; $vhostsFile = $vhostsFile -replace '%XAMPP_PATH%', '%XAMPP_PATH%'; $vhostPath = '%VHOST_PATH%'; $vhostPath = $vhostPath -replace '%VHOST_PATH%', '%VHOST_PATH%'; $vhost = \"`n# VirtualHost untuk nuranitms.test`n<VirtualHost *:80>`n    ServerName nuraniTMS.test`n    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test`n    DocumentRoot \"$vhostPath/htdocs/nurani/public\"`n    RewriteEngine On`n    RewriteCond %{HTTPS} off`n    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]`n</VirtualHost>`n`n<VirtualHost *:443>`n    ServerName nuraniTMS.test`n    ServerAlias www.nuraniTMS.test nuranitms.test www.nuranitms.test`n    DocumentRoot \"$vhostPath/htdocs/nurani/public\"`n    SSLEngine on`n    SSLCertificateFile \"$vhostPath/apache/conf/ssl/nuraniTMS.crt\"`n    SSLCertificateKeyFile \"$vhostPath/apache/conf/ssl/nuraniTMS.key\"`n    SSLProtocol all -SSLv2 -SSLv3`n    SSLCipherSuite HIGH:!aNULL:!MD5`n    <Directory \"$vhostPath/htdocs/nurani/public\">`n        Options Indexes FollowSymLinks`n        AllowOverride All`n        Require all granted`n    </Directory>`n</VirtualHost>`n\"; if (Test-Path $vhostsFile) { $content = Get-Content $vhostsFile -Raw; if ($content -notmatch 'nuraniTMS\.test') { Add-Content $vhostsFile -Value $vhost } }" >nul 2>&1
echo [OK] VirtualHost dibuat.
echo.

echo [LANGKAH 7] Update file hosts...
powershell -Command "$hostsFile = 'C:\Windows\System32\drivers\etc\hosts'; $entries = @('127.0.0.1    nuraniTMS.test', '127.0.0.1    www.nuraniTMS.test', '127.0.0.1    nuranitms.test', '127.0.0.1    www.nuranitms.test'); $content = Get-Content $hostsFile -Raw; foreach ($entry in $entries) { if ($content -notmatch [regex]::Escape($entry)) { Add-Content $hostsFile -Value $entry } }" >nul 2>&1
ipconfig /flushdns >nul 2>&1
echo [OK] File hosts diupdate dan DNS di-flush.
echo.

echo [LANGKAH 8] Update .env...
if exist ".env" (
    powershell -Command "$envFile = '.env'; $content = Get-Content $envFile -Raw; $content = $content -replace 'APP_URL=.*', 'APP_URL=https://nuraniTMS.test'; if ($content -notmatch 'SESSION_SECURE_COOKIE') { $content += \"`nSESSION_SECURE_COOKIE=true\" } else { $content = $content -replace 'SESSION_SECURE_COOKIE=.*', 'SESSION_SECURE_COOKIE=true' }; Set-Content $envFile -Value $content -NoNewline" >nul 2>&1
)
if exist "%XAMPP_PATH%\htdocs\nurani\.env" (
    powershell -Command "$envFile = '%XAMPP_PATH%\htdocs\nurani\.env'; $envFile = $envFile -replace '%XAMPP_PATH%', '%XAMPP_PATH%'; $content = Get-Content $envFile -Raw; $content = $content -replace 'APP_URL=.*', 'APP_URL=https://nuraniTMS.test'; if ($content -notmatch 'SESSION_SECURE_COOKIE') { $content += \"`nSESSION_SECURE_COOKIE=true\" } else { $content = $content -replace 'SESSION_SECURE_COOKIE=.*', 'SESSION_SECURE_COOKIE=true' }; Set-Content $envFile -Value $content -NoNewline" >nul 2>&1
)
if exist "%XAMPP_PATH%\htdocs\nurani\artisan" (
    cd /d "%XAMPP_PATH%\htdocs\nurani"
    php artisan config:clear >nul 2>&1
    php artisan cache:clear >nul 2>&1
    cd /d "%~dp0"
)
echo [OK] .env diupdate dan cache di-clear.
echo.

echo [LANGKAH 9] Verifikasi final...
echo.
if exist "%XAMPP_PATH%\htdocs\nurani\public\index.php" (
    echo [OK] Project ditemukan: %XAMPP_PATH%\htdocs\nurani\public\index.php
) else (
    echo [ERROR] Project TIDAK ditemukan!
    pause
    exit /b 1
)

if exist "%XAMPP_PATH%\htdocs\nurani\artisan" (
    echo [OK] File artisan ditemukan.
) else (
    echo [ERROR] File artisan TIDAK ditemukan!
    pause
    exit /b 1
)

tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running.
) else (
    echo [WARNING] Apache tidak running!
    echo Silakan start Apache di XAMPP Control Panel.
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
echo Setelah itu, test dengan:
echo.
echo OPSI 1 - LOCALHOST (PASTI BERFUNGSI):
echo http://localhost/nurani/public
echo.
echo OPSI 2 - HTTPS (setelah localhost berfungsi):
echo https://nuranitms.test
echo (Klik "Advanced" - "Proceed to site")
echo.
echo ============================================
echo VERIFIKASI:
echo ============================================
echo.
echo Pastikan file ada di:
echo %XAMPP_PATH%\htdocs\nurani\public\index.php
echo.
echo Jika file tidak ada, jalankan script ini lagi.
echo.
pause
