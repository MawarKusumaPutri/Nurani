@echo off
echo ========================================
echo   START MYSQL DI XAMPP
echo ========================================
echo.

REM Cek apakah XAMPP Control Panel ada
if exist "C:\xampp\xampp-control.exe" (
    echo [INFO] Membuka XAMPP Control Panel...
    start "" "C:\xampp\xampp-control.exe"
    echo.
    echo [SUKSES] XAMPP Control Panel dibuka!
    echo.
    echo [INSTRUKSI]
    echo 1. Di XAMPP Control Panel, klik tombol "Start" pada MySQL
    echo 2. Tunggu sampai status MySQL berubah menjadi "Running" (hijau)
    echo 3. Setelah itu, refresh browser Anda
    echo.
) else if exist "D:\xampp\xampp-control.exe" (
    echo [INFO] Membuka XAMPP Control Panel...
    start "" "D:\xampp\xampp-control.exe"
    echo.
    echo [SUKSES] XAMPP Control Panel dibuka!
    echo.
    echo [INSTRUKSI]
    echo 1. Di XAMPP Control Panel, klik tombol "Start" pada MySQL
    echo 2. Tunggu sampai status MySQL berubah menjadi "Running" (hijau)
    echo 3. Setelah itu, refresh browser Anda
    echo.
) else (
    echo [ERROR] XAMPP tidak ditemukan di lokasi standar!
    echo.
    echo [SOLUSI MANUAL]
    echo 1. Buka XAMPP Control Panel secara manual
    echo 2. Klik "Start" pada MySQL
    echo 3. Pastikan status MySQL menjadi "Running"
    echo.
)

REM Coba start MySQL via command line juga
if exist "C:\xampp\mysql\bin\mysqld.exe" (
    echo [INFO] Mencoba start MySQL via command line...
    cd /d "C:\xampp"
    call mysql_start.bat 2>nul
    if %errorlevel% equ 0 (
        echo [SUKSES] MySQL berhasil di-start!
    ) else (
        echo [INFO] Gunakan XAMPP Control Panel untuk start MySQL
    )
) else if exist "D:\xampp\mysql\bin\mysqld.exe" (
    echo [INFO] Mencoba start MySQL via command line...
    cd /d "D:\xampp"
    call mysql_start.bat 2>nul
    if %errorlevel% equ 0 (
        echo [SUKSES] MySQL berhasil di-start!
    ) else (
        echo [INFO] Gunakan XAMPP Control Panel untuk start MySQL
    )
)

echo.
echo ========================================
echo   SELESAI
echo ========================================
pause

