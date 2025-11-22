@echo off
echo ============================================
echo CEK KONFIGURASI HTTPS
echo ============================================
echo.

echo [1/8] Cek Apache running...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running.
) else (
    echo [ERROR] Apache TIDAK running!
    echo Silakan start Apache di XAMPP Control Panel.
)
echo.

echo [2/8] Cek mod_ssl aktif...
findstr /C:"LoadModule ssl_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_ssl sudah aktif.
) else (
    echo [ERROR] mod_ssl BELUM aktif!
    echo Buka httpd.conf, hapus tanda # di depan: LoadModule ssl_module modules/mod_rewrite.so
)
echo.

echo [3/8] Cek httpd-ssl.conf diaktifkan...
findstr /C:"Include conf/extra/httpd-ssl.conf" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] httpd-ssl.conf sudah diaktifkan.
) else (
    echo [ERROR] httpd-ssl.conf BELUM diaktifkan!
    echo Buka httpd.conf, hapus tanda # di depan: Include conf/extra/httpd-ssl.conf
)
echo.

echo [4/8] Cek folder ssl...
if exist "C:\xampp\apache\conf\ssl" (
    echo [OK] Folder ssl ditemukan.
) else (
    echo [ERROR] Folder ssl TIDAK ditemukan!
    echo Jalankan: SCRIPT_BUAT_CERTIFICATE.bat
)
echo.

echo [5/8] Cek certificate (nurani.crt)...
if exist "C:\xampp\apache\conf\ssl\nurani.crt" (
    echo [OK] Certificate nurani.crt ditemukan.
) else (
    echo [ERROR] Certificate nurani.crt TIDAK ditemukan!
    echo Jalankan: SCRIPT_BUAT_CERTIFICATE.bat
)
echo.

echo [6/8] Cek private key (nurani.key)...
if exist "C:\xampp\apache\conf\ssl\nurani.key" (
    echo [OK] Private key nurani.key ditemukan.
) else (
    echo [ERROR] Private key nurani.key TIDAK ditemukan!
    echo Jalankan: SCRIPT_BUAT_CERTIFICATE.bat
)
echo.

echo [7/8] Cek VirtualHost HTTPS...
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf >nul
if %errorlevel% equ 0 (
    echo [OK] VirtualHost HTTPS ditemukan.
) else (
    echo [ERROR] VirtualHost HTTPS TIDAK ditemukan!
    echo Copy-paste dari: KONFIGURASI_VIRTUALHOST_HTTPS.txt
)
echo.

echo [8/8] Cek port 443...
netstat -ano | findstr :443 >nul
if %errorlevel% equ 0 (
    echo [OK] Port 443 sedang digunakan (Apache mungkin sudah listen).
) else (
    echo [WARNING] Port 443 tidak terdeteksi.
    echo Pastikan VirtualHost HTTPS sudah benar.
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Jika ada [ERROR], perbaiki sesuai instruksi di atas.
echo Setelah perbaikan, RESTART Apache!
echo.
pause

