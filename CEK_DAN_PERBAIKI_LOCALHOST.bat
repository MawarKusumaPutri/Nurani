@echo off
title CEK DAN PERBAIKI LOCALHOST
color 0E

echo.
echo ============================================
echo CEK DAN PERBAIKI LOCALHOST
echo ============================================
echo.

echo [CEK 1] Apache Status...
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

echo [CEK 2] Folder htdocs...
if exist "C:\xampp\htdocs" (
    echo [OK] Folder htdocs ditemukan.
) else (
    echo [ERROR] Folder htdocs TIDAK ditemukan!
    echo Pastikan XAMPP sudah terinstall.
    pause
    exit /b 1
)
echo.

echo [CEK 3] Folder project...
if exist "C:\xampp\htdocs\nurani" (
    echo [OK] Folder project ditemukan.
) else (
    echo [ERROR] Folder project TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan SALIN_PROJECT_KE_HTDOCS.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [CEK 4] Folder public...
if exist "C:\xampp\htdocs\nurani\public" (
    echo [OK] Folder public ditemukan.
) else (
    echo [ERROR] Folder public TIDAK ditemukan!
    echo.
    echo SOLUSI: Pastikan project Laravel lengkap.
    echo Jalankan SALIN_PROJECT_KE_HTDOCS.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [CEK 5] File index.php...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] File index.php ditemukan.
) else (
    echo [ERROR] File index.php TIDAK ditemukan!
    echo.
    echo SOLUSI: Pastikan project Laravel lengkap.
    echo Jalankan SALIN_PROJECT_KE_HTDOCS.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [CEK 6] File .htaccess...
if exist "C:\xampp\htdocs\nurani\public\.htaccess" (
    echo [OK] File .htaccess ditemukan.
) else (
    echo [WARNING] File .htaccess TIDAK ditemukan!
    echo.
    echo SOLUSI: File .htaccess akan dibuat otomatis.
    echo.
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

echo [CEK 7] File artisan...
if exist "C:\xampp\htdocs\nurani\artisan" (
    echo [OK] File artisan ditemukan.
) else (
    echo [ERROR] File artisan TIDAK ditemukan!
    echo.
    echo SOLUSI: Pastikan project Laravel lengkap.
    echo Jalankan SALIN_PROJECT_KE_HTDOCS.bat
    echo.
    pause
)
echo.

echo [CEK 8] mod_rewrite...
findstr /C:"LoadModule rewrite_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_rewrite aktif.
) else (
    echo [WARNING] mod_rewrite TIDAK aktif!
    echo.
    echo SOLUSI: Aktifkan mod_rewrite di httpd.conf
    echo.
)
echo.

echo ============================================
echo RINGKASAN:
echo ============================================
echo.
echo Jika ada [ERROR], perbaiki sesuai SOLUSI di atas.
echo.
echo Setelah semua [OK]:
echo 1. Pastikan Apache running
echo 2. Test: http://localhost/nurani/public
echo.
echo Jika masih error "Not Found":
echo 1. Jalankan: SALIN_PROJECT_KE_HTDOCS.bat
echo 2. Pastikan project lengkap
echo 3. Test lagi
echo.
pause

