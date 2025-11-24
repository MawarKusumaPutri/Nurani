@echo off
title VERIFIKASI PROJECT
color 0E

echo.
echo ============================================
echo VERIFIKASI PROJECT
echo ============================================
echo.

echo [CEK 1] Folder htdocs...
if exist "C:\xampp\htdocs" (
    echo [OK] Folder htdocs ditemukan.
) else (
    echo [ERROR] Folder htdocs TIDAK ditemukan!
    echo Pastikan XAMPP sudah terinstall.
    pause
    exit /b 1
)
echo.

echo [CEK 2] Folder project...
if exist "C:\xampp\htdocs\nurani" (
    echo [OK] Folder project ditemukan: C:\xampp\htdocs\nurani
) else (
    echo [ERROR] Folder project TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan BUKA_INI_UNTUK_PERBAIKAN.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [CEK 3] Folder public...
if exist "C:\xampp\htdocs\nurani\public" (
    echo [OK] Folder public ditemukan.
) else (
    echo [ERROR] Folder public TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan BUKA_INI_UNTUK_PERBAIKAN.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [CEK 4] File index.php...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] File index.php ditemukan.
    echo.
    echo Path lengkap: C:\xampp\htdocs\nurani\public\index.php
) else (
    echo [ERROR] File index.php TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan BUKA_INI_UNTUK_PERBAIKAN.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [CEK 5] File .htaccess...
if exist "C:\xampp\htdocs\nurani\public\.htaccess" (
    echo [OK] File .htaccess ditemukan.
) else (
    echo [WARNING] File .htaccess tidak ditemukan.
    echo Akan dibuat otomatis...
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
    echo [OK] File .htaccess dibuat.
)
echo.

echo [CEK 6] File artisan...
if exist "C:\xampp\htdocs\nurani\artisan" (
    echo [OK] File artisan ditemukan.
) else (
    echo [ERROR] File artisan TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan BUKA_INI_UNTUK_PERBAIKAN.bat
    echo.
    pause
)
echo.

echo [CEK 7] Apache Status...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running.
) else (
    echo [ERROR] Apache TIDAK running!
    echo.
    echo SOLUSI: Start Apache di XAMPP Control Panel!
    echo.
    pause
)
echo.

echo [CEK 8] mod_rewrite...
findstr /C:"LoadModule rewrite_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_rewrite aktif.
) else (
    echo [WARNING] mod_rewrite TIDAK aktif.
    echo Mengaktifkan otomatis...
    powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline" >nul 2>&1
    echo [OK] mod_rewrite diaktifkan.
    echo [INFO] Restart Apache untuk menerapkan perubahan.
)
echo.

echo ============================================
echo RINGKASAN:
echo ============================================
echo.
echo Jika semua [OK], test dengan:
echo http://localhost/nurani/public
echo.
echo Jika ada [ERROR], jalankan:
echo BUKA_INI_UNTUK_PERBAIKAN.bat
echo.
pause

