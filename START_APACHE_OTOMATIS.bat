@echo off
title START APACHE OTOMATIS
color 0A

echo.
echo ============================================
echo START APACHE OTOMATIS
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%" (
    echo [ERROR] XAMPP tidak ditemukan di: %XAMPP_PATH%
    echo.
    echo Mencari XAMPP di lokasi lain...
    if exist "C:\xampp" (
        set "XAMPP_PATH=C:\xampp"
        echo [OK] XAMPP ditemukan di: %XAMPP_PATH%
    ) else (
        echo [ERROR] XAMPP tidak ditemukan!
        echo.
        echo SOLUSI:
        echo 1. Pastikan XAMPP sudah terinstall
        echo 2. Atau update path di script ini
        echo.
        pause
        exit /b 1
    )
)

echo [1/4] Cek lokasi XAMPP...
echo [OK] XAMPP: %XAMPP_PATH%
echo.

echo [2/4] Cek status Apache...
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] Apache sudah berjalan!
    echo.
    echo Apache sudah running, tidak perlu start lagi.
    echo.
    echo Test akses:
    echo - http://localhost/nurani/public/
    echo - http://localhost/nurani/public/kepala-sekolah/profile/edit
    echo.
    pause
    exit /b 0
) else (
    echo [WARNING] Apache TIDAK berjalan
    echo.
)

echo [3/4] Start Apache...
echo.

REM Coba start via XAMPP Control Panel
if exist "%XAMPP_PATH%\xampp-control.exe" (
    echo [INFO] Membuka XAMPP Control Panel...
    start "" "%XAMPP_PATH%\xampp-control.exe"
    echo.
    echo [PENTING] XAMPP Control Panel sudah dibuka.
    echo.
    echo LANGKAH MANUAL:
    echo 1. Di XAMPP Control Panel, cari "Apache"
    echo 2. Klik tombol "Start" (hijau)
    echo 3. Tunggu sampai status berubah menjadi "Running" (hijau)
    echo 4. Jika ada error, klik "Logs" untuk melihat error
    echo.
    timeout /t 3 /nobreak >nul
) else (
    echo [WARNING] XAMPP Control Panel tidak ditemukan
    echo.
)

REM Coba start Apache langsung
if exist "%XAMPP_PATH%\apache\bin\httpd.exe" (
    echo [INFO] Mencoba start Apache langsung...
    cd /d "%XAMPP_PATH%\apache\bin"
    
    REM Cek apakah sudah ada instance yang berjalan
    tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
    if "%ERRORLEVEL%"=="0" (
        echo [OK] Apache sudah berjalan
    ) else (
        echo [INFO] Start Apache...
        start "" httpd.exe
        timeout /t 5 /nobreak >nul
        
        REM Verifikasi
        tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
        if "%ERRORLEVEL%"=="0" (
            echo [OK] Apache berhasil di-start!
        ) else (
            echo [WARNING] Apache mungkin belum start, tunggu beberapa detik...
            timeout /t 5 /nobreak >nul
            
            tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
            if "%ERRORLEVEL%"=="0" (
                echo [OK] Apache sekarang berjalan!
            ) else (
                echo [ERROR] Apache gagal di-start!
                echo.
                echo SOLUSI:
                echo 1. Buka XAMPP Control Panel
                echo 2. Klik START pada Apache
                echo 3. Jika ada error, lihat log di:
                echo    %XAMPP_PATH%\apache\logs\error.log
                echo.
            )
        )
    )
) else (
    echo [ERROR] File Apache tidak ditemukan!
    echo.
    echo SOLUSI:
    echo 1. Pastikan XAMPP sudah terinstall dengan benar
    echo 2. Cek lokasi XAMPP: %XAMPP_PATH%
    echo.
)

echo.
echo [4/4] Verifikasi akhir...
timeout /t 3 /nobreak >nul
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] Apache berjalan!
    echo.
    echo ============================================
    echo APACHE BERHASIL DI-START!
    echo ============================================
    echo.
    echo Test akses di browser:
    echo - http://localhost/nurani/public/
    echo - http://localhost/nurani/public/kepala-sekolah/profile/edit
    echo.
) else (
    echo [WARNING] Apache mungkin belum berjalan
    echo.
    echo ============================================
    echo LANGKAH MANUAL:
    echo ============================================
    echo.
    echo 1. Buka XAMPP Control Panel
    echo    Lokasi: %XAMPP_PATH%\xampp-control.exe
    echo.
    echo 2. Cari "Apache" di daftar
    echo.
    echo 3. Klik tombol "Start" (hijau)
    echo.
    echo 4. Tunggu sampai status berubah menjadi "Running" (hijau)
    echo.
    echo 5. Jika ada error:
    echo    - Klik "Logs" untuk melihat error
    echo    - Atau buka: %XAMPP_PATH%\apache\logs\error.log
    echo.
    echo 6. Test akses:
    echo    - http://localhost/nurani/public/
    echo    - http://localhost/nurani/public/kepala-sekolah/profile/edit
    echo.
)

echo ============================================
echo TIPS:
echo ============================================
echo.
echo Jika Apache tidak bisa start:
echo 1. Cek port 80 tidak digunakan aplikasi lain
echo 2. Cek firewall tidak memblokir Apache
echo 3. Cek log error: %XAMPP_PATH%\apache\logs\error.log
echo.
pause

