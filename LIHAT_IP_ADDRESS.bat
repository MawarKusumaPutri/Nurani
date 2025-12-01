@echo off
chcp 65001 >nul
title Lihat IP Address - Semua Device
color 0E

echo.
echo ========================================
echo   CARA MELIHAT IP ADDRESS DI SEMUA DEVICE
echo ========================================
echo.
echo Pilih device yang ingin Anda cek:
echo.
echo [1] Windows (Laptop/PC ini)
echo [2] Android (Smartphone/Tablet)
echo [3] iOS (iPhone/iPad)
echo [4] Mac (MacBook/iMac)
echo [5] Lihat semua
echo.
echo ========================================
echo.

set /p PILIHAN="Masukkan pilihan (1-5): "

if "%PILIHAN%"=="1" goto WINDOWS
if "%PILIHAN%"=="2" goto ANDROID
if "%PILIHAN%"=="3" goto IOS
if "%PILIHAN%"=="4" goto MAC
if "%PILIHAN%"=="5" goto SEMUA
goto END

:WINDOWS
echo.
echo ========================================
echo   IP ADDRESS WINDOWS (LAPTOP/PC INI)
echo ========================================
echo.
echo Mencari IP Address...
echo.
ipconfig | findstr /i /c:"IPv4" /c:"IPv4 Address"
echo.
echo ========================================
echo   CARA LAIN (GUI):
echo ========================================
echo.
echo 1. Windows + I (Settings)
echo 2. Network ^& Internet
echo 3. Wi-Fi atau Ethernet
echo 4. Klik nama koneksi
echo 5. Lihat "IPv4 address"
echo.
goto END

:ANDROID
echo.
echo ========================================
echo   IP ADDRESS ANDROID (SMARTPHONE/TABLET)
echo ========================================
echo.
echo CARA 1 (Settings):
echo   1. Settings (Pengaturan)
echo   2. Wi-Fi atau Network ^& Internet
echo   3. Klik nama WiFi yang terhubung
echo   4. Scroll ke bawah, cari "IP address"
echo.
echo CARA 2 (Aplikasi):
echo   - Download "Network Info II" atau "Fing"
echo   - Buka aplikasi
echo   - IP address akan langsung terlihat
echo.
echo LOKASI BERBEDA PER VERSI:
echo   - Android 10+: Settings → Network ^& Internet → Wi-Fi → (nama WiFi) → Advanced → IP address
echo   - Android 9: Settings → Wi-Fi → (nama WiFi) → IP address
echo   - Samsung: Settings → Connections → Wi-Fi → (nama WiFi) → Advanced → IP address
echo.
goto END

:IOS
echo.
echo ========================================
echo   IP ADDRESS iOS (IPHONE/IPAD)
echo ========================================
echo.
echo CARA 1 (Settings):
echo   1. Settings (Pengaturan)
echo   2. Wi-Fi
echo   3. Klik ikon "i" di sebelah nama WiFi
echo   4. Scroll ke bawah, cari "IP Address"
echo.
echo CARA 2 (Aplikasi):
echo   - Download "Network Analyzer" dari App Store
echo   - Buka aplikasi
echo   - IP address akan langsung terlihat
echo.
goto END

:MAC
echo.
echo ========================================
echo   IP ADDRESS MAC (MACBOOK/IMAC)
echo ========================================
echo.
echo CARA 1 (System Preferences):
echo   1. Apple Menu → System Preferences
echo   2. Network
echo   3. Wi-Fi atau Ethernet
echo   4. Advanced...
echo   5. Tab TCP/IP
echo   6. Lihat "IPv4 Address"
echo.
echo CARA 2 (Terminal):
echo   Buka Terminal, ketik: ifconfig ^| grep "inet "
echo.
goto END

:SEMUA
echo.
echo ========================================
echo   IP ADDRESS WINDOWS (LAPTOP/PC INI)
echo ========================================
echo.
ipconfig | findstr /i /c:"IPv4" /c:"IPv4 Address"
echo.
echo ========================================
echo   CATATAN PENTING:
echo ========================================
echo.
echo ⚠️ IP ADDRESS YANG DIGUNAKAN UNTUK AKSES
echo    ADALAH IP ADDRESS KOMPUTER SERVER
echo    (yang menjalankan XAMPP)!
echo.
echo ✅ IP Address di atas adalah IP komputer ini
echo    Gunakan IP ini untuk akses dari device lain
echo.
echo 📱 Untuk melihat IP device lain:
echo    - Android: Settings → Wi-Fi → (nama WiFi) → IP address
echo    - iOS: Settings → Wi-Fi → (i) → IP Address
echo    - Mac: System Preferences → Network → Advanced → TCP/IP
echo.
echo 🌐 URL untuk akses dari device lain:
echo    http://[IP_ADDRESS_KOMPUTER_INI]/nurani/public
echo.
goto END

:END
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

