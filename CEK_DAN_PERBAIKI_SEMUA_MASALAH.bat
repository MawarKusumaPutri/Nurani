@echo off
title CEK DAN PERBAIKI SEMUA MASALAH
color 0C

echo.
echo ============================================
echo CEK DAN PERBAIKI SEMUA MASALAH
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

echo [CEK 2] Project di htdocs...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] Project ditemukan di C:\xampp\htdocs\nurani\
) else (
    echo [ERROR] Project TIDAK ditemukan di C:\xampp\htdocs\nurani\
    echo.
    echo SOLUSI: Salin project ke C:\xampp\htdocs\nurani\
    echo.
    echo Dari: D:\Capstone\nurani
    echo Ke:   C:\xampp\htdocs\nurani
    echo.
    pause
)
echo.

echo [CEK 3] Certificate...
if exist "C:\xampp\apache\conf\ssl\nuraniTMS.crt" (
    echo [OK] Certificate ditemukan.
) else (
    echo [ERROR] Certificate TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan FIX_NURANITMS.bat
    echo.
    pause
)
echo.

echo [CEK 4] mod_ssl...
findstr /C:"LoadModule ssl_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_ssl aktif.
) else (
    echo [ERROR] mod_ssl TIDAK aktif!
    echo.
    echo SOLUSI: Buka C:\xampp\apache\conf\httpd.conf
    echo Hapus tanda # di depan: LoadModule ssl_module modules/mod_ssl.so
    echo.
    pause
)
echo.

echo [CEK 5] VirtualHost HTTPS...
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf | findstr /i "nurani" >nul
if %errorlevel% equ 0 (
    echo [OK] VirtualHost HTTPS ditemukan.
) else (
    echo [ERROR] VirtualHost HTTPS TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan FIX_NURANITMS.bat
    echo.
    pause
)
echo.

echo [CEK 6] File hosts...
findstr /i "nuranitms.test" C:\Windows\System32\drivers\etc\hosts >nul
if %errorlevel% equ 0 (
    echo [OK] Domain ditemukan di file hosts.
    echo.
    echo Isi file hosts terkait nurani:
    type C:\Windows\System32\drivers\etc\hosts | findstr /i "nurani"
) else (
    echo [ERROR] Domain TIDAK ditemukan di file hosts!
    echo.
    echo SOLUSI: Update file hosts dengan:
    echo 127.0.0.1    nuranitms.test
    echo.
    pause
)
echo.

echo [CEK 7] Port 443...
netstat -ano | findstr :443 >nul
if %errorlevel% equ 0 (
    echo [OK] Port 443 sedang digunakan.
) else (
    echo [WARNING] Port 443 tidak terdeteksi.
    echo Pastikan Apache sudah di-restart setelah konfigurasi.
)
echo.

echo [CEK 8] Error log Apache...
if exist "C:\xampp\apache\logs\error.log" (
    echo.
    echo 5 baris terakhir dari error.log:
    powershell -Command "Get-Content 'C:\xampp\apache\logs\error.log' -Tail 5"
) else (
    echo [INFO] Error log tidak ditemukan.
)
echo.

echo ============================================
echo RINGKASAN:
echo ============================================
echo.
echo Jika ada [ERROR], perbaiki sesuai SOLUSI di atas.
echo.
echo Setelah semua [OK]:
echo 1. RESTART Apache di XAMPP Control Panel
echo 2. RESTART KOMPUTER (sering menyelesaikan masalah)
echo 3. Test: https://nuranitms.test
echo.
pause

