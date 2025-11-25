@echo off
title TEST LOCALHOST
color 0B

echo.
echo ============================================
echo TEST LOCALHOST - nurani/public
echo ============================================
echo.

echo [TEST 1] Cek folder project...
if exist "C:\xampp\htdocs\nurani" (
    echo [OK] Folder project ditemukan.
) else (
    echo [ERROR] Folder project TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan FIX_PASTI_BERFUNGSI.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [TEST 2] Cek folder public...
if exist "C:\xampp\htdocs\nurani\public" (
    echo [OK] Folder public ditemukan.
) else (
    echo [ERROR] Folder public TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan FIX_PASTI_BERFUNGSI.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [TEST 3] Cek file index.php...
if exist "C:\xampp\htdocs\nurani\public\index.php" (
    echo [OK] File index.php ditemukan.
    echo.
    echo Path lengkap:
    echo C:\xampp\htdocs\nurani\public\index.php
) else (
    echo [ERROR] File index.php TIDAK ditemukan!
    echo.
    echo SOLUSI: Jalankan FIX_PASTI_BERFUNGSI.bat
    echo.
    pause
    exit /b 1
)
echo.

echo [TEST 4] Cek Apache running...
tasklist | find /i "httpd.exe" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache sedang running.
) else (
    echo [ERROR] Apache TIDAK running!
    echo.
    echo SOLUSI: Start Apache di XAMPP Control Panel!
    echo.
    pause
    exit /b 1
)
echo.

echo [TEST 5] Test akses file...
powershell -Command "Test-Path 'C:\xampp\htdocs\nurani\public\index.php'" >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] File bisa diakses.
) else (
    echo [ERROR] File tidak bisa diakses!
    echo.
    echo SOLUSI: Cek permission folder
    echo.
    pause
)
echo.

echo ============================================
echo HASIL TEST:
echo ============================================
echo.
echo Jika semua [OK], test dengan browser:
echo http://localhost/nurani/public
echo.
echo Jika ada [ERROR], jalankan:
echo FIX_PASTI_BERFUNGSI.bat
echo.
pause

