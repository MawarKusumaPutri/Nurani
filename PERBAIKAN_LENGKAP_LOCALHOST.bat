@echo off
title PERBAIKAN LENGKAP - localhost/nurani/public
color 0A

echo.
echo ============================================
echo PERBAIKAN LENGKAP - localhost/nurani/public
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [LANGKAH 1] Cek dan salin project ke htdocs...
if not exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [INFO] Project belum di htdocs, menyalin...
    echo.
    
    if not exist "C:\xampp\htdocs" (
        echo [ERROR] Folder C:\xampp\htdocs tidak ditemukan!
        echo Pastikan XAMPP sudah terinstall.
        pause
        exit /b 1
    )
    
    if exist "C:\xampp\htdocs\nurani" (
        echo [WARNING] Folder C:\xampp\htdocs\nurani sudah ada.
        echo Menghapus folder lama...
        rmdir /s /q "C:\xampp\htdocs\nurani" 2>nul
    )
    
    echo Menyalin project...
    echo Dari: %CD%
    echo Ke:   C:\xampp\htdocs\nurani
    echo.
    echo [INFO] Proses ini mungkin memakan waktu beberapa menit...
    echo.
    
    xcopy "%CD%\*" "C:\xampp\htdocs\nurani\" /E /I /H /Y /Q
    if %errorlevel% equ 0 (
        echo [OK] Project berhasil disalin.
    ) else (
        echo [ERROR] Gagal menyalin project!
        echo.
        echo Coba salin manual:
        echo 1. Buka: %CD%
        echo 2. Copy seluruh folder
        echo 3. Paste ke: C:\xampp\htdocs\
        echo 4. Rename menjadi: nurani
        pause
        exit /b 1
    )
) else (
    echo [OK] Project sudah di htdocs.
)
echo.

echo [LANGKAH 2] Verifikasi folder public...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] Folder public dan index.php ditemukan.
) else (
    echo [ERROR] Folder public atau index.php TIDAK ditemukan!
    pause
    exit /b 1
)
echo.

echo [LANGKAH 3] Cek file .htaccess...
if not exist "C:\xampp\htdocs\nurani\public\.htaccess" (
    echo [WARNING] File .htaccess tidak ditemukan, membuat...
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
) else (
    echo [OK] File .htaccess sudah ada.
)
echo.

echo [LANGKAH 4] Mengaktifkan mod_rewrite...
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline" >nul 2>&1
echo [OK] mod_rewrite diaktifkan.
echo.

echo [LANGKAH 5] Cek Apache running...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% neq 0 (
    echo [WARNING] Apache tidak running!
    echo.
    echo SILAKAN START APACHE DI XAMPP CONTROL PANEL!
    echo.
    pause
) else (
    echo [OK] Apache sedang running.
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Langkah selanjutnya:
echo 1. Pastikan Apache running di XAMPP
echo 2. Test: http://localhost/nurani/public
echo.
echo Jika masih error "Not Found":
echo 1. Restart Apache di XAMPP Control Panel
echo 2. Cek error log: C:\xampp\apache\logs\error.log
echo.
pause

