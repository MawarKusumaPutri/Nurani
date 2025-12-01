@echo off
chcp 65001 >nul
title Setup Firewall - OTOMATIS!
color 0C

:: This script will request admin rights automatically
>nul 2>&1 "%SYSTEMROOT%\system32\cacls.exe" "%SYSTEMROOT%\system32\config\system"

if '%errorlevel%' NEQ '0' (
    echo.
    echo ========================================
    echo   MEMINTA HAK ADMINISTRATOR...
    echo ========================================
    echo.
    echo Script akan meminta hak administrator.
    echo Klik "Yes" jika muncul pop-up UAC.
    echo.
    goto UACPrompt
) else ( goto gotAdmin )

:UACPrompt
    echo Set UAC = CreateObject^("Shell.Application"^) > "%temp%\getadmin.vbs"
    echo UAC.ShellExecute "%~s0", "", "", "runas", 1 >> "%temp%\getadmin.vbs"
    "%temp%\getadmin.vbs"
    del "%temp%\getadmin.vbs"
    exit /B

:gotAdmin
    if exist "%temp%\getadmin.vbs" ( del "%temp%\getadmin.vbs" )
    pushd "%CD%"
    CD /D "%~dp0"

echo.
echo ========================================
echo   SETUP FIREWALL - OTOMATIS!
echo ========================================
echo.
echo ✅ Hak administrator sudah didapat!
echo.
echo Script ini akan otomatis:
echo   - Mengizinkan port 80 (HTTP) di firewall
echo   - Mengizinkan Apache/XAMPP
echo.
echo TIDAK PERLU SETTING MANUAL!
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo [STEP 1] Mengizinkan port 80 (HTTP)...
echo.

:: Add firewall rule for port 80
netsh advfirewall firewall add rule name="XAMPP Apache HTTP" dir=in action=allow protocol=TCP localport=80 >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo ✅ Port 80 sudah diizinkan!
) else (
    echo ⚠️ Port 80 mungkin sudah diizinkan sebelumnya.
)

echo.
echo [STEP 2] Mengizinkan Apache HTTP Server...
echo.

:: Try to find Apache path and add exception
set APACHE_PATH=
if exist "C:\xampp\apache\bin\httpd.exe" (
    set APACHE_PATH=C:\xampp\apache\bin\httpd.exe
) else if exist "D:\xampp\apache\bin\httpd.exe" (
    set APACHE_PATH=D:\xampp\apache\bin\httpd.exe
) else if exist "E:\xampp\apache\bin\httpd.exe" (
    set APACHE_PATH=E:\xampp\apache\bin\httpd.exe
)

if not "%APACHE_PATH%"=="" (
    netsh advfirewall firewall add rule name="Apache HTTP Server" dir=in action=allow program="%APACHE_PATH%" enable=yes >nul 2>&1
    echo ✅ Apache HTTP Server sudah diizinkan!
) else (
    echo ⚠️ Apache path tidak ditemukan, skip...
)

echo.
echo ========================================
echo   ✅ FIREWALL SUDAH DISETUP!
echo ========================================
echo.
echo Port 80 (HTTP) sudah diizinkan di firewall.
echo Sekarang aplikasi bisa diakses dari device lain!
echo.
echo ========================================
echo   LANGKAH SELANJUTNYA:
echo ========================================
echo.
echo 1. Pastikan Apache XAMPP berjalan (Running)
echo 2. Pastikan device lain dalam WiFi yang sama
echo 3. Coba akses dari device lain:
echo    http://[IP_ADDRESS]/nurani/public
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

