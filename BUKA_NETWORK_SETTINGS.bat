@echo off
chcp 65001 >nul
title Buka Network Settings - Langsung ke Tempatnya!
color 0C

echo.
echo ========================================
echo   BUKA NETWORK SETTINGS - LANGSUNG!
echo ========================================
echo.
echo Script ini akan membuka Network Connections
echo langsung ke bagian yang perlu diklik!
echo.
echo Tekan tombol apapun untuk membuka...
pause >nul

echo.
echo [INFO] Membuka Network Connections...
echo.

start "" "ncpa.cpl"

echo.
echo ========================================
echo   JENDELA NETWORK CONNECTIONS SUDAH DIBUKA!
echo ========================================
echo.
echo LANGKAH SELANJUTNYA (URUTAN KLIK):
echo.
echo 1. Di jendela "Network Connections" yang baru terbuka:
echo    → Cari "Wi-Fi" (ada ikon sinyal WiFi)
echo.
echo 2. Klik KANAN pada "Wi-Fi"
echo    → Akan muncul menu pop-up
echo.
echo 3. Di menu pop-up, pilih "Properties"
echo    → Akan muncul jendela "Wi-Fi Properties"
echo.
echo 4. Di jendela "Wi-Fi Properties":
echo    → Tab "Networking" (biasanya sudah terbuka)
echo    → Scroll ke bawah daftar item
echo    → Cari "Internet Protocol Version 4 (TCP/IPv4)"
echo    → Klik 2 KALI pada item tersebut
echo    → Akan muncul jendela baru
echo.
echo 5. Di jendela "Internet Protocol Version 4 Properties":
echo    → Pilih "Use the following IP address" (bukan "Obtain automatically")
echo    → Isi 3 kolom:
echo       - IP address: 192.168.1.13 (contoh)
echo       - Subnet mask: 255.255.255.0
echo       - Default gateway: 192.168.1.1
echo    → Klik "OK"
echo.
echo 6. Klik "OK" lagi di jendela "Wi-Fi Properties"
echo.
echo ========================================
echo   CATATAN:
echo ========================================
echo.
echo ⚠️ Jika tidak ketemu "Network Connections":
echo    - Pastikan jendela sudah terbuka
echo    - Atau tekan Windows + R, ketik: ncpa.cpl
echo.
echo 💡 IP address Anda: 192.168.1.13
echo    (dari info yang terlihat di Settings)
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

