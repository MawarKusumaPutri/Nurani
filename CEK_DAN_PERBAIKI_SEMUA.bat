@echo off
echo ============================================
echo CEK DAN PERBAIKI SEMUA KONFIGURASI
echo ============================================
echo.

echo [CEK 1] Apache Status...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running.
) else (
    echo [ERROR] Apache TIDAK running!
    echo Silakan start Apache di XAMPP Control Panel.
    echo.
    pause
    exit /b 1
)
echo.

echo [CEK 2] mod_ssl...
findstr /C:"LoadModule ssl_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_ssl aktif.
) else (
    echo [ERROR] mod_ssl TIDAK aktif!
    echo Jalankan: PERBAIKAN_LENGKAP_OTOMATIS.bat
)
echo.

echo [CEK 3] Certificate...
if exist "C:\xampp\apache\conf\ssl\nuraniTMS.crt" (
    echo [OK] Certificate ditemukan.
) else (
    echo [ERROR] Certificate TIDAK ditemukan!
    echo Jalankan: SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat
)
echo.

echo [CEK 4] VirtualHost HTTPS...
findstr /C:"VirtualHost *:443" C:\xampp\apache\conf\extra\httpd-vhosts.conf | findstr /i "nurani" >nul
if %errorlevel% equ 0 (
    echo [OK] VirtualHost HTTPS ditemukan.
) else (
    echo [ERROR] VirtualHost HTTPS TIDAK ditemukan!
    echo Copy-paste dari: KONFIGURASI_VIRTUALHOST_LENGKAP.txt
)
echo.

echo [CEK 5] File hosts...
findstr /i "nuranitms.test" C:\Windows\System32\drivers\etc\hosts >nul
if %errorlevel% equ 0 (
    echo [OK] Domain ditemukan di file hosts.
) else (
    echo [ERROR] Domain TIDAK ditemukan di file hosts!
    echo Update file hosts dengan: COPY_PASTE_HOSTS_LENGKAP.txt
)
echo.

echo [CEK 6] Port 443...
netstat -ano | findstr :443 >nul
if %errorlevel% equ 0 (
    echo [OK] Port 443 sedang digunakan (Apache listen).
) else (
    echo [WARNING] Port 443 tidak terdeteksi.
    echo Pastikan VirtualHost HTTPS sudah benar dan Apache sudah di-restart.
)
echo.

echo ============================================
echo RINGKASAN:
echo ============================================
echo.
echo Jika ada [ERROR], perbaiki sesuai instruksi di atas.
echo.
echo Langkah selanjutnya:
echo 1. Perbaiki semua [ERROR]
echo 2. RESTART Apache di XAMPP Control Panel
echo 3. Flush DNS: ipconfig /flushdns
echo 4. Test: https://nuranitms.test
echo.
pause

