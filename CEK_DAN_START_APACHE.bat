@echo off
title CEK DAN START APACHE
color 0A

echo.
echo ============================================
echo CEK DAN START APACHE
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%" (
    echo [ERROR] XAMPP tidak ditemukan di: %XAMPP_PATH%
    echo.
    echo Cari XAMPP di lokasi lain...
    if exist "C:\xampp" (
        set "XAMPP_PATH=C:\xampp"
        echo [OK] XAMPP ditemukan di: %XAMPP_PATH%
    ) else (
        echo [ERROR] XAMPP tidak ditemukan!
        echo         Pastikan XAMPP sudah terinstall.
        pause
        exit /b 1
    )
)

echo [1/5] Cek lokasi XAMPP...
echo [OK] XAMPP ditemukan di: %XAMPP_PATH%
echo.

echo [2/5] Cek status Apache...
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] Apache sedang berjalan
    echo.
    echo Apache sudah berjalan, tidak perlu start lagi.
    echo.
    echo Test akses:
    echo - Buka: http://localhost/nurani/public/
    echo - Atau: http://localhost/nurani/public/kepala-sekolah/profile/edit
    echo.
    pause
    exit /b 0
) else (
    echo [WARNING] Apache TIDAK berjalan
    echo.
)

echo [3/5] Start Apache...
echo.
echo Mencoba start Apache...
echo.

REM Coba start Apache via XAMPP Control Panel
if exist "%XAMPP_PATH%\apache_start.bat" (
    echo [INFO] Menggunakan apache_start.bat...
    start "" "%XAMPP_PATH%\apache_start.bat"
    timeout /t 5 /nobreak >nul
) else if exist "%XAMPP_PATH%\apache\bin\httpd.exe" (
    echo [INFO] Menggunakan httpd.exe langsung...
    cd /d "%XAMPP_PATH%\apache\bin"
    start "" httpd.exe
    timeout /t 5 /nobreak >nul
) else (
    echo [ERROR] File Apache tidak ditemukan!
    echo.
    echo SOLUSI MANUAL:
    echo 1. Buka XAMPP Control Panel
    echo 2. Klik START pada Apache
    echo 3. Tunggu sampai status berubah menjadi "Running" (hijau)
    echo 4. Test akses: http://localhost/nurani/public/
    echo.
    pause
    exit /b 1
)

echo [4/5] Tunggu Apache start (10 detik)...
timeout /t 10 /nobreak >nul

echo [5/5] Verifikasi Apache berjalan...
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] Apache berhasil di-start!
    echo.
    echo Apache sekarang berjalan.
    echo.
    echo Test akses:
    echo - Buka: http://localhost/nurani/public/
    echo - Atau: http://localhost/nurani/public/kepala-sekolah/profile/edit
    echo.
) else (
    echo [ERROR] Apache gagal di-start!
    echo.
    echo SOLUSI MANUAL:
    echo 1. Buka XAMPP Control Panel
    echo 2. Klik START pada Apache
    echo 3. Jika ada error, lihat log di:
    echo    %XAMPP_PATH%\apache\logs\error.log
    echo 4. Pastikan port 80 tidak digunakan aplikasi lain
    echo 5. Test akses: http://localhost/nurani/public/
    echo.
)

echo ============================================
echo LANGKAH SELANJUTNYA:
echo ============================================
echo.
echo 1. Test akses di browser:
echo    - http://localhost/nurani/public/
echo    - http://localhost/nurani/public/kepala-sekolah/profile/edit
echo.
echo 2. Jika masih error "Unable to connect":
echo    - Buka XAMPP Control Panel
echo    - Pastikan Apache status "Running" (hijau)
echo    - Jika merah, klik START
echo    - Cek log error di: %XAMPP_PATH%\apache\logs\error.log
echo.
echo 3. Jika port 80 sudah digunakan:
echo    - Tutup aplikasi yang menggunakan port 80
echo    - Atau ubah port Apache di: %XAMPP_PATH%\apache\conf\httpd.conf
echo    - Cari: Listen 80
echo    - Ubah menjadi: Listen 8080
echo    - Restart Apache
echo    - Akses: http://localhost:8080/nurani/public/
echo.
pause

