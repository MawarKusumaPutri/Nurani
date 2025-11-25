@echo off
title FIX LENGKAP - nuranitms.test dengan Verifikasi
color 0A

echo.
echo ============================================
echo FIX LENGKAP - nuranitms.test
echo Dengan Verifikasi Setiap Langkah
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [VERIFIKASI 1] Cek Apache running...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% neq 0 (
    echo [ERROR] Apache TIDAK running!
    echo.
    echo SILAKAN START APACHE DI XAMPP CONTROL PANEL TERLEBIH DAHULU!
    echo.
    pause
    exit /b 1
) else (
    echo [OK] Apache sedang running.
)
echo.

echo [LANGKAH 1] Membuat folder ssl...
if not exist "C:\xampp\apache\conf\ssl" (
    mkdir "C:\xampp\apache\conf\ssl"
    echo [OK] Folder ssl dibuat.
) else (
    echo [OK] Folder ssl sudah ada.
)
echo.

echo [LANGKAH 2] Membuat certificate SSL...
cd /d "C:\xampp\apache\conf\ssl"

if not exist "nuraniTMS.key" (
    echo Membuat private key...
    openssl genrsa -out nuraniTMS.key 2048
    if %errorlevel% neq 0 (
        echo [ERROR] Gagal membuat private key!
        echo Pastikan OpenSSL tersedia di XAMPP.
        pause
        exit /b 1
    )
    echo [OK] Private key dibuat.
) else (
    echo [OK] Private key sudah ada.
)

if not exist "nuraniTMS.crt" (
    echo Membuat certificate...
    openssl req -new -x509 -key nuraniTMS.key -out nuraniTMS.crt -days 365 -subj "/C=ID/ST=Jakarta/L=Jakarta/O=MTs/CN=nuraniTMS.test" 2>nul
    if not exist "nuraniTMS.crt" (
        echo Mencoba metode alternatif...
        echo. | openssl req -new -key nuraniTMS.key -out nuraniTMS.csr -subj "/C=ID/ST=Jakarta/L=Jakarta/O=MTs/CN=nuraniTMS.test" 2>nul
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

echo [VERIFIKASI 2] Cek certificate...
if exist "nuraniTMS.crt" (
    echo [OK] Certificate ditemukan: C:\xampp\apache\conf\ssl\nuraniTMS.crt
) else (
    echo [ERROR] Certificate TIDAK ditemukan!
    pause
    exit /b 1
)
echo.

cd /d "%~dp0"

echo [LANGKAH 3] Mengaktifkan mod_ssl di httpd.conf...
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule ssl_module modules/mod_ssl.so', 'LoadModule ssl_module modules/mod_ssl.so'; Set-Content $file -Value $content -NoNewline" >nul 2>&1
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; $content = Get-Content $file -Raw; $content = $content -replace '#Include conf/extra/httpd-ssl.conf', 'Include conf/extra/httpd-ssl.conf'; Set-Content $file -Value $content -NoNewline" >nul 2>&1
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline" >nul 2>&1
echo [OK] mod_ssl, httpd-ssl.conf, dan mod_rewrite diaktifkan.
echo.

echo [VERIFIKASI 3] Cek mod_ssl aktif...
findstr /C:"LoadModule ssl_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_ssl sudah aktif di httpd.conf.
) else (
    echo [ERROR] mod_ssl TIDAK aktif!
    echo Silakan aktifkan manual di httpd.conf.
    pause
)
echo.

echo [LANGKAH 4] Membuat VirtualHost HTTPS...
REM Hapus VirtualHost lama jika ada
powershell -Command "$file = 'C:\xampp\apache\conf\extra\httpd-vhosts.conf'; $content = Get-Content $file -Raw; $content = $content -replace '(?s)# VirtualHost.*?nurani.*?</VirtualHost>', ''; $content = $content -replace '(?s)<VirtualHost.*?nurani.*?</VirtualHost>', ''; Set-Content $file -Value $content -NoNewline" >nul 2>&1

REM Tambahkan VirtualHost baru
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
echo [OK] VirtualHost HTTPS dibuat.
echo.

echo [VERIFIKASI 4] Cek VirtualHost...
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf | findstr /i "nurani" >nul
if %errorlevel% equ 0 (
    echo [OK] VirtualHost HTTPS ditemukan di httpd-vhosts.conf.
) else (
    echo [ERROR] VirtualHost HTTPS TIDAK ditemukan!
    pause
)
echo.

echo [LANGKAH 5] Update file hosts Windows...
REM Hapus entry lama jika ada
powershell -Command "$hostsFile = 'C:\Windows\System32\drivers\etc\hosts'; $content = Get-Content $hostsFile; $newContent = $content | Where-Object { $_ -notmatch 'nurani' }; Set-Content $hostsFile -Value $newContent" >nul 2>&1

REM Tambahkan entry baru
(
echo 127.0.0.1    nuraniTMS.test
echo 127.0.0.1    www.nuraniTMS.test
echo 127.0.0.1    nuranitms.test
echo 127.0.0.1    www.nuranitms.test
) >> "C:\Windows\System32\drivers\etc\hosts"
echo [OK] File hosts diupdate.
echo.

echo [VERIFIKASI 5] Cek file hosts...
findstr /i "nuranitms.test" C:\Windows\System32\drivers\etc\hosts >nul
if %errorlevel% equ 0 (
    echo [OK] Domain ditemukan di file hosts.
    type C:\Windows\System32\drivers\etc\hosts | findstr /i "nurani"
) else (
    echo [ERROR] Domain TIDAK ditemukan di file hosts!
    echo Silakan update manual: C:\Windows\System32\drivers\etc\hosts
    pause
)
echo.

echo [LANGKAH 6] Flush DNS cache...
ipconfig /flushdns
echo [OK] DNS cache di-flush.
echo.

echo [LANGKAH 7] Update .env...
if exist ".env" (
    powershell -Command "$envFile = '.env'; $content = Get-Content $envFile -Raw; $content = $content -replace 'APP_URL=.*', 'APP_URL=https://nuraniTMS.test'; if ($content -notmatch 'SESSION_SECURE_COOKIE') { $content += \"`nSESSION_SECURE_COOKIE=true\" } else { $content = $content -replace 'SESSION_SECURE_COOKIE=.*', 'SESSION_SECURE_COOKIE=true' }; Set-Content $envFile -Value $content -NoNewline" >nul 2>&1
    echo [OK] .env diupdate.
) else (
    echo [WARNING] File .env tidak ditemukan.
)
echo.

echo [LANGKAH 8] Clear cache Laravel...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo [OK] Cache di-clear.
echo.

echo [LANGKAH 9] Cek folder project...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] Project ditemukan di C:\xampp\htdocs\nurani\
) else (
    echo [WARNING] Project TIDAK ditemukan di C:\xampp\htdocs\nurani\
    echo.
    echo SALIN PROJECT KE: C:\xampp\htdocs\nurani\
    echo.
    pause
)
echo.

echo ============================================
echo KONFIGURASI SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR (SANGAT PENTING!):
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Klik STOP pada Apache
echo 3. TUNGGU 10 DETIK (PENTING!)
echo 4. Klik START pada Apache
echo 5. Pastikan status Running (hijau)
echo 6. TUNGGU 5 DETIK LAGI
echo.
echo Setelah itu:
echo 1. TUTUP SEMUA TAB BROWSER
echo 2. Buka browser baru (Ctrl+Shift+N untuk Incognito)
echo 3. Ketik: https://nuranitms.test
echo 4. Tekan Enter
echo 5. Klik "Advanced" - "Proceed to site"
echo.
echo ============================================
echo VERIFIKASI FINAL:
echo ============================================
echo.
echo Cek apakah semua sudah benar:
echo.
findstr /C:"LoadModule ssl_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul && echo [OK] mod_ssl aktif || echo [ERROR] mod_ssl tidak aktif
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf | findstr /i "nurani" >nul && echo [OK] VirtualHost HTTPS ada || echo [ERROR] VirtualHost HTTPS tidak ada
if exist "C:\xampp\apache\conf\ssl\nuraniTMS.crt" (echo [OK] Certificate ada) else (echo [ERROR] Certificate tidak ada)
findstr /i "nuranitms.test" C:\Windows\System32\drivers\etc\hosts >nul && echo [OK] File hosts sudah benar || echo [ERROR] File hosts belum benar
echo.
echo ============================================
echo.
pause

