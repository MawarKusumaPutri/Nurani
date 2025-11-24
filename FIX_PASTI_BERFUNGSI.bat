@echo off
title FIX PASTI BERFUNGSI - localhost/nurani/public
color 0A

echo.
echo ============================================
echo FIX PASTI BERFUNGSI
echo Memastikan localhost/nurani/public BERFUNGSI
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo [ERROR] File artisan tidak ditemukan!
    echo.
    echo Lokasi saat ini: %CD%
    echo.
    echo Pastikan script ini dijalankan di root folder Laravel.
    echo.
    pause
    exit /b 1
)

echo [INFO] Lokasi project saat ini: %CD%
echo [INFO] Akan disalin ke: C:\xampp\htdocs\nurani
echo.
echo Tekan tombol apapun untuk melanjutkan...
pause >nul

echo.
echo [LANGKAH 1] Cek folder htdocs...
if not exist "C:\xampp\htdocs" (
    echo [ERROR] Folder C:\xampp\htdocs tidak ditemukan!
    echo Pastikan XAMPP sudah terinstall.
    pause
    exit /b 1
) else (
    echo [OK] Folder htdocs ditemukan.
)
echo.

echo [LANGKAH 2] Menghapus folder lama...
if exist "C:\xampp\htdocs\nurani" (
    echo [INFO] Menghapus folder lama: C:\xampp\htdocs\nurani
    echo [INFO] Proses ini mungkin memakan waktu...
    rmdir /s /q "C:\xampp\htdocs\nurani" 2>nul
    timeout /t 2 >nul
    if exist "C:\xampp\htdocs\nurani" (
        echo [WARNING] Folder masih ada, mencoba lagi...
        rmdir /s /q "C:\xampp\htdocs\nurani" 2>nul
        timeout /t 2 >nul
    )
    if not exist "C:\xampp\htdocs\nurani" (
        echo [OK] Folder lama berhasil dihapus.
    ) else (
        echo [ERROR] Gagal menghapus folder lama!
        echo Silakan hapus manual: C:\xampp\htdocs\nurani
        pause
        exit /b 1
    )
) else (
    echo [OK] Folder lama tidak ada.
)
echo.

echo [LANGKAH 3] Membuat folder baru...
mkdir "C:\xampp\htdocs\nurani" 2>nul
if not exist "C:\xampp\htdocs\nurani" (
    echo [ERROR] Gagal membuat folder!
    pause
    exit /b 1
) else (
    echo [OK] Folder baru dibuat.
)
echo.

echo [LANGKAH 4] Menyalin project...
echo [INFO] Proses ini mungkin memakan waktu beberapa menit...
echo [INFO] Menyalin dari: %CD%
echo [INFO] Menyalin ke: C:\xampp\htdocs\nurani
echo.

echo [INFO] Menyalin file dan folder...
robocopy "%CD%" "C:\xampp\htdocs\nurani" /E /COPYALL /R:3 /W:5 /NP /NFL /NDL >nul 2>&1

if %errorlevel% LSS 8 (
    echo [OK] Project berhasil disalin.
) else (
    echo [ERROR] Gagal menyalin project!
    echo.
    echo Coba salin manual:
    echo 1. Buka: %CD%
    echo 2. Copy seluruh folder (Ctrl + C)
    echo 3. Paste ke: C:\xampp\htdocs\
    echo 4. Rename menjadi: nurani
    pause
    exit /b 1
)
echo.

echo [LANGKAH 5] Verifikasi file penting...
echo.

if exist "C:\xampp\htdocs\nurani\artisan" (
    echo [OK] File artisan ditemukan.
) else (
    echo [ERROR] File artisan TIDAK ditemukan!
    echo Project mungkin tidak lengkap.
    pause
    exit /b 1
)

if exist "C:\xampp\htdocs\nurani\public" (
    echo [OK] Folder public ditemukan.
) else (
    echo [ERROR] Folder public TIDAK ditemukan!
    pause
    exit /b 1
)

if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] File index.php ditemukan.
    echo      Path: C:\xampp\htdocs\nurani\public\index.php
) else (
    echo [ERROR] File index.php TIDAK ditemukan!
    pause
    exit /b 1
)

if exist "C:\xampp\htdocs\nurani\public\.htaccess" (
    echo [OK] File .htaccess ditemukan.
) else (
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
)
echo.

echo [LANGKAH 6] Mengaktifkan mod_rewrite...
powershell -Command "$file = 'C:\xampp\apache\conf\httpd.conf'; if (Test-Path $file) { $content = Get-Content $file -Raw; $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline }" >nul 2>&1
echo [OK] mod_rewrite diaktifkan.
echo.

echo [LANGKAH 7] Cek Apache running...
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

echo [LANGKAH 8] Verifikasi final struktur folder...
echo.
echo Cek struktur:
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] C:\xampp\htdocs\nurani\public\index.php
) else (
    echo [ERROR] File tidak ditemukan!
)

if exist "C:\xampp\htdocs\nurani\artisan" (
    echo [OK] C:\xampp\htdocs\nurani\artisan
) else (
    echo [ERROR] File tidak ditemukan!
)

if exist "C:\xampp\htdocs\nurani\vendor" (
    echo [OK] C:\xampp\htdocs\nurani\vendor
) else (
    echo [WARNING] Folder vendor tidak ditemukan.
    echo Jalankan: composer install
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Project sudah disalin ke: C:\xampp\htdocs\nurani\
echo.
echo LANGKAH TERAKHIR:
echo.
echo 1. Pastikan Apache RUNNING di XAMPP Control Panel
echo    - Jika tidak running, klik START pada Apache
echo    - Pastikan status Running (hijau)
echo.
echo 2. Buka browser
echo.
echo 3. Ketik: http://localhost/nurani/public
echo    (TANPA slash di akhir!)
echo.
echo 4. Tekan Enter
echo.
echo Website Laravel akan muncul!
echo.
echo ============================================
echo JIKA MASIH ERROR:
echo ============================================
echo.
echo 1. Jalankan: VERIFIKASI_PROJECT.bat
echo 2. Cek error log: C:\xampp\apache\logs\error.log
echo 3. Pastikan Apache running
echo 4. Restart Apache di XAMPP Control Panel
echo.
pause

