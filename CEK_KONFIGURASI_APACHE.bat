@echo off
echo ============================================
echo CEK KONFIGURASI APACHE
echo ============================================
echo.

echo [1/6] Cek Apache running...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running.
) else (
    echo [ERROR] Apache TIDAK running!
    echo Silakan start Apache di XAMPP Control Panel.
)
echo.

echo [2/6] Cek file hosts...
findstr /C:"nurani.test" C:\Windows\System32\drivers\etc\hosts >nul
if %errorlevel% equ 0 (
    echo [OK] Domain nurani.test ditemukan di file hosts.
) else (
    echo [ERROR] Domain nurani.test TIDAK ditemukan di file hosts!
    echo Silakan tambahkan: 127.0.0.1    nurani.test
)
echo.

echo [3/6] Cek VirtualHost...
findstr /C:"nurani.test" C:\xampp\apache\conf\extra\httpd-vhosts.conf >nul
if %errorlevel% equ 0 (
    echo [OK] VirtualHost nurani.test ditemukan.
) else (
    echo [ERROR] VirtualHost nurani.test TIDAK ditemukan!
    echo Silakan tambahkan VirtualHost di httpd-vhosts.conf.
)
echo.

echo [4/6] Cek VirtualHost diaktifkan...
findstr /C:"Include conf/extra/httpd-vhosts.conf" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] VirtualHost sudah diaktifkan di httpd.conf.
) else (
    echo [ERROR] VirtualHost BELUM diaktifkan di httpd.conf!
    echo Pastikan baris "Include conf/extra/httpd-vhosts.conf" tidak ada tanda #.
)
echo.

echo [5/6] Cek folder project...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] Project ditemukan di C:\xampp\htdocs\nurani\
) else (
    echo [ERROR] Project TIDAK ditemukan di C:\xampp\htdocs\nurani\
    echo Atau file index.php tidak ada di folder public.
)
echo.

echo [6/6] Cek mod_rewrite...
findstr /C:"LoadModule rewrite_module" C:\xampp\apache\conf\httpd.conf | findstr /V "#" >nul
if %errorlevel% equ 0 (
    echo [OK] mod_rewrite sudah aktif.
) else (
    echo [WARNING] mod_rewrite mungkin belum aktif.
    echo Cek di httpd.conf: LoadModule rewrite_module modules/mod_rewrite.so
)
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Jika ada [ERROR], perbaiki sesuai instruksi di atas.
echo.
pause

