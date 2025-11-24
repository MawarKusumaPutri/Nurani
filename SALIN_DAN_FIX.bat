@echo off
title SALIN PROJECT DAN FIX - PASTI BERFUNGSI
color 0A

echo.
echo ============================================
echo SALIN PROJECT DAN FIX - PASTI BERFUNGSI
echo ============================================
echo.
echo Script ini akan:
echo 1. Menyalin project ke htdocs
echo 2. Memastikan semua file ada
echo 3. Memperbaiki konfigurasi
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
echo [OK] Lokasi project: %CD%
echo.

echo ============================================
echo MENYALIN PROJECT KE HTDOCS
echo ============================================
echo.

if exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [INFO] Menghapus folder lama...
    rmdir /s /q "%XAMPP_PATH%\htdocs\nurani" 2>nul
    timeout /t 3 >nul
)

echo [INFO] Menyalin project...
echo [INFO] Dari: %CD%
echo [INFO] Ke: %XAMPP_PATH%\htdocs\nurani
echo [INFO] Mohon tunggu, proses ini memakan waktu...
echo.

robocopy "%CD%" "%XAMPP_PATH%\htdocs\nurani" /E /COPYALL /R:3 /W:2 /NP /NFL /NDL

echo.
echo [INFO] Verifikasi penyalinan...
timeout /t 2 >nul

if exist "%XAMPP_PATH%\htdocs\nurani\public\index.php" (
    echo [OK] Project berhasil disalin!
    echo [OK] File index.php ditemukan!
) else (
    echo [ERROR] Gagal menyalin project!
    echo.
    echo SALIN MANUAL (PENTING!):
    echo.
    echo 1. Buka Windows Explorer
    echo 2. Buka folder: %CD%
    echo 3. Tekan Ctrl + A (pilih semua)
    echo 4. Tekan Ctrl + C (copy)
    echo 5. Buka folder: %XAMPP_PATH%\htdocs
    echo 6. Tekan Ctrl + V (paste)
    echo 7. Rename folder menjadi: nurani
    echo.
    echo Setelah itu, jalankan script ini lagi.
    pause
    exit /b 1
)

if exist "%XAMPP_PATH%\htdocs\nurani\artisan" (
    echo [OK] File artisan ditemukan!
) else (
    echo [ERROR] File artisan TIDAK ditemukan!
    pause
    exit /b 1
)

if exist "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" (
    echo [OK] File .htaccess ditemukan!
) else (
    echo [WARNING] File .htaccess tidak ada, membuat baru...
    if exist "%CD%\public\.htaccess" (
        copy "%CD%\public\.htaccess" "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" >nul 2>&1
    )
    if exist "%XAMPP_PATH%\htdocs\nurani\public\.htaccess" (
        echo [OK] File .htaccess dibuat!
    ) else (
        echo [ERROR] Gagal membuat .htaccess!
    )
)
echo.

echo ============================================
echo MEMPERBAIKI KONFIGURASI APACHE
echo ============================================
echo.

set "HTTPD_CONF=%XAMPP_PATH%\apache\conf\httpd.conf"
if exist "%HTTPD_CONF%" (
    echo [INFO] Mengaktifkan mod_rewrite...
    powershell -ExecutionPolicy Bypass -Command "$file = '%HTTPD_CONF%'; $content = Get-Content $file -Raw; if ($content -match '#LoadModule rewrite_module') { $content = $content -replace '#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so'; Set-Content $file -Value $content -NoNewline; Write-Host '[OK] mod_rewrite diaktifkan.' } else { Write-Host '[OK] mod_rewrite sudah aktif.' }"
    
    echo [INFO] Memastikan Include httpd-vhosts.conf...
    powershell -ExecutionPolicy Bypass -Command "$file = '%HTTPD_CONF%'; $content = Get-Content $file -Raw; if ($content -notmatch 'Include.*httpd-vhosts.conf' -or $content -match '#Include.*httpd-vhosts.conf') { $content = $content -replace '#Include conf/extra/httpd-vhosts.conf', 'Include conf/extra/httpd-vhosts.conf'; Set-Content $file -Value $content -NoNewline; Write-Host '[OK] Include httpd-vhosts.conf diaktifkan.' } else { Write-Host '[OK] Include httpd-vhosts.conf sudah aktif.' }"
) else (
    echo [ERROR] File httpd.conf tidak ditemukan!
)
echo.

echo ============================================
echo UPDATE .ENV
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

echo.
echo [INFO] Lokasi project: %XAMPP_PATH%\htdocs\nurani
echo [INFO] Lokasi public: %XAMPP_PATH%\htdocs\nurani\public
echo [INFO] File index.php: %XAMPP_PATH%\htdocs\nurani\public\index.php
echo.

tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running
) else (
    echo [WARNING] Apache tidak running!
    echo Silakan start Apache di XAMPP Control Panel.
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR (PENTING!):
echo.
echo 1. Buka XAMPP Control Panel
echo 2. Klik STOP pada Apache
echo 3. TUNGGU 10 DETIK (PENTING!)
echo 4. Klik START pada Apache
echo 5. Pastikan status Running (hijau)
echo.
echo Setelah itu, test dengan:
echo.
echo http://localhost/nurani/public
echo.
echo ============================================
echo JIKA MASIH "NOT FOUND":
echo ============================================
echo.
echo 1. Pastikan file ada di:
echo    %XAMPP_PATH%\htdocs\nurani\public\index.php
echo.
echo 2. Coba akses langsung:
echo    http://localhost/nurani/public/index.php
echo.
echo 3. Restart Apache lagi
echo.
echo 4. Cek error log:
echo    %XAMPP_PATH%\apache\logs\error.log
echo.
pause
