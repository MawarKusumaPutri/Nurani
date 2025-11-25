@echo off
title PERBAIKAN TOTAL - PASTI BERFUNGSI
color 0A

echo.
echo ============================================
echo PERBAIKAN TOTAL - PASTI BERFUNGSI
echo ============================================
echo.
echo Script ini akan MEMVERIFIKASI dan MEMPERBAIKI
echo semua masalah secara otomatis.
echo.
pause

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo [ERROR] File artisan tidak ditemukan!
    echo Lokasi saat ini: %CD%
    pause
    exit /b 1
)

REM Cari lokasi XAMPP
set "XAMPP_PATH="
if exist "D:\Praktikum DWBI\xampp\htdocs" set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if exist "C:\xampp\htdocs" set "XAMPP_PATH=C:\xampp"
if exist "D:\xampp\htdocs" set "XAMPP_PATH=D:\xampp"
if exist "E:\xampp\htdocs" set "XAMPP_PATH=E:\xampp"

if "%XAMPP_PATH%"=="" (
    echo [ERROR] Folder htdocs tidak ditemukan!
    echo.
    echo Saya mencari di:
    echo - D:\Praktikum DWBI\xampp\htdocs
    echo - C:\xampp\htdocs
    echo - D:\xampp\htdocs
    echo - E:\xampp\htdocs
    echo.
    echo Jika XAMPP ada di lokasi lain, salin manual:
    echo 1. Buka: %CD%
    echo 2. Copy seluruh folder (Ctrl + C)
    echo 3. Paste ke: [lokasi-xampp]\htdocs\
    echo 4. Rename menjadi: nurani
    pause
    exit /b 1
)

echo [OK] XAMPP ditemukan di: %XAMPP_PATH%
echo.

echo ============================================
echo LANGKAH 1: MENYALIN PROJECT KE HTDOCS
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [INFO] Menghapus folder lama...
    rmdir /s /q "%XAMPP_PATH%\htdocs\nurani" 2>nul
    timeout /t 2 >nul
)

echo [INFO] Menyalin project dari: %CD%
echo [INFO] Menyalin ke: %XAMPP_PATH%\htdocs\nurani
echo [INFO] Mohon tunggu, proses ini memakan waktu...
echo.

robocopy "%CD%" "%XAMPP_PATH%\htdocs\nurani" /E /COPYALL /R:1 /W:1 /NP /NFL /NDL

echo.
echo [INFO] Verifikasi penyalinan...
if exist "%XAMPP_PATH%\htdocs\nurani\public\index.php" (
    echo [OK] Project berhasil disalin!
    echo [OK] File index.php ditemukan: %XAMPP_PATH%\htdocs\nurani\public\index.php
) else (
    echo [ERROR] Gagal menyalin project!
    echo.
    echo SALIN MANUAL:
    echo 1. Buka: %CD%
    echo 2. Copy seluruh folder (Ctrl + C)
    echo 3. Paste ke: %XAMPP_PATH%\htdocs\
    echo 4. Rename menjadi: nurani
    echo.
    echo Setelah itu, jalankan script ini lagi.
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
echo.

echo ============================================
echo LANGKAH 2: MEMASTIKAN FILE .HTACCESS ADA
echo ============================================
echo.

if not exist "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" (
    echo [INFO] File .htaccess tidak ada, membuat baru...
    if exist "%CD%\public\.htaccess" (
        copy "%CD%\public\.htaccess" "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" >nul 2>&1
    )
    if not exist "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" (
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
        ) > "%XAMPP_PATH%\htdocs\nurani\public\.htaccess"
    )
)
echo [OK] File .htaccess sudah ada.
echo.

echo ============================================
echo LANGKAH 3: MENGAKTIFKAN MOD_REWRITE
echo ============================================
echo.

set "HTTPD_CONF=%XAMPP_PATH%\apache\conf\httpd.conf"
if exist "%HTTPD_CONF%" (
    echo [INFO] Mengaktifkan mod_rewrite...
    powershell -ExecutionPolicy Bypass -Command "$file = '%HTTPD_CONF%'; $content = Get-Content $file -Raw; if ($content -match '#LoadModule rewrite_module') { $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline; Write-Host '[OK] mod_rewrite diaktifkan.' } else { Write-Host '[OK] mod_rewrite sudah aktif.' }"
) else (
    echo [ERROR] File httpd.conf tidak ditemukan!
)
echo.

echo ============================================
echo LANGKAH 4: MEMASTIKAN ALLOWOVERRIDE ALL
echo ============================================
echo.

if exist "%HTTPD_CONF%" (
    echo [INFO] Memastikan AllowOverride All...
    powershell -ExecutionPolicy Bypass -Command "$file = '%HTTPD_CONF%'; $content = Get-Content $file -Raw; if ($content -notmatch 'AllowOverride All') { $content = $content -replace '(AllowOverride\s+)(None|All)', '$1All'; Set-Content $file -Value $content -NoNewline; Write-Host '[OK] AllowOverride All diaktifkan.' } else { Write-Host '[OK] AllowOverride All sudah aktif.' }"
)
echo.

echo ============================================
echo LANGKAH 5: MEMBUAT VIRTUALHOST UNTUK LOCALHOST
echo ============================================
echo.

set "VHOSTS_FILE=%XAMPP_PATH%\apache\conf\extra\httpd-vhosts.conf"
if exist "%VHOSTS_FILE%" (
    echo [INFO] Membuat VirtualHost untuk localhost...
    set "VHOST_PATH=%XAMPP_PATH:\=/%"
    powershell -ExecutionPolicy Bypass -Command "$file = '%VHOSTS_FILE%'; $vhostPath = '%VHOST_PATH%'; $vhost = \"`n# VirtualHost untuk localhost/nurani`n<VirtualHost *:80>`n    ServerName localhost`n    DocumentRoot `\"$vhostPath/htdocs`\"`n    <Directory `\"$vhostPath/htdocs`\">`n        Options Indexes FollowSymLinks`n        AllowOverride All`n        Require all granted`n    </Directory>`n</VirtualHost>`n\"; $content = Get-Content $file -Raw; if ($content -notmatch 'VirtualHost.*localhost') { Add-Content $file -Value $vhost; Write-Host '[OK] VirtualHost untuk localhost dibuat.' } else { Write-Host '[OK] VirtualHost untuk localhost sudah ada.' }"
) else (
    echo [WARNING] File httpd-vhosts.conf tidak ditemukan!
)
echo.

echo ============================================
echo LANGKAH 6: MEMASTIKAN INCLUDE HTTPD-VHOSTS.CONF
echo ============================================
echo.

if exist "%HTTPD_CONF%" (
    echo [INFO] Memastikan Include httpd-vhosts.conf...
    powershell -ExecutionPolicy Bypass -Command "$file = '%HTTPD_CONF%'; $content = Get-Content $file -Raw; if ($content -notmatch 'Include.*httpd-vhosts.conf') { $content = $content -replace '#Include conf/extra/httpd-vhosts.conf', 'Include conf/extra/httpd-vhosts.conf'; Set-Content $file -Value $content -NoNewline; Write-Host '[OK] Include httpd-vhosts.conf diaktifkan.' } else { Write-Host '[OK] Include httpd-vhosts.conf sudah aktif.' }"
)
echo.

echo ============================================
echo LANGKAH 7: UPDATE .ENV
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani\.env" (
    echo [INFO] Update .env...
    powershell -ExecutionPolicy Bypass -Command "$envFile = '%XAMPP_PATH%\htdocs\nurani\.env'; $content = Get-Content $envFile -Raw; $content = $content -replace 'APP_URL=.*', 'APP_URL=http://localhost/nurani/public'; Set-Content $envFile -Value $content -NoNewline; Write-Host '[OK] .env diupdate.'"
    
    cd /d "%XAMPP_PATH%\htdocs\nurani"
    echo [INFO] Clear cache Laravel...
    php artisan config:clear >nul 2>&1
    php artisan cache:clear >nul 2>&1
    php artisan route:clear >nul 2>&1
    php artisan view:clear >nul 2>&1
    cd /d "%~dp0"
    echo [OK] Cache Laravel di-clear.
) else (
    echo [WARNING] File .env tidak ditemukan!
)
echo.

echo ============================================
echo VERIFIKASI FINAL
echo ============================================
echo.

echo [VERIFIKASI] Cek file penting...
if exist "%XAMPP_PATH%\htdocs\nurani\public\index.php" (
    echo [OK] index.php ada
) else (
    echo [ERROR] index.php TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" (
    echo [OK] .htaccess ada
) else (
    echo [ERROR] .htaccess TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\artisan" (
    echo [OK] artisan ada
) else (
    echo [ERROR] artisan TIDAK ADA!
)

if exist "%XAMPP_PATH%\htdocs\nurani\vendor" (
    echo [OK] vendor ada
) else (
    echo [WARNING] vendor tidak ada - jalankan: composer install
)

tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running
) else (
    echo [WARNING] Apache tidak running!
)
echo.

echo ============================================
echo SELESAI! PERBAIKAN TOTAL SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR (PENTING!):
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Klik STOP pada Apache
echo 3. TUNGGU 10 DETIK
echo 4. Klik START pada Apache
echo 5. Pastikan status Running (hijau)
echo.
echo Setelah itu, test dengan:
echo.
echo http://localhost/nurani/public
echo.
echo ============================================
echo TIPS:
echo ============================================
echo.
echo Jika masih "Not Found", coba:
echo.
echo 1. Pastikan Apache RUNNING
echo 2. Restart Apache lagi
echo 3. Cek file: %XAMPP_PATH%\htdocs\nurani\public\index.php
echo 4. Cek file: %XAMPP_PATH%\htdocs\nurani\public\.htaccess
echo 5. Buka: http://localhost/nurani/public/index.php
echo.
pause

