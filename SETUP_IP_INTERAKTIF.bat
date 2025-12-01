@echo off
chcp 65001 >nul
title Setup IP Address - Interaktif & Mudah Dipahami
color 0A

echo.
echo ========================================
echo   SETUP IP ADDRESS - INTERAKTIF
echo ========================================
echo.
echo Script ini akan memandu Anda langkah demi langkah
echo dengan sangat jelas dan mudah dipahami!
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

echo.
echo ========================================
echo   LANGKAH 1: BUKA JENDELA NETWORK CONNECTIONS
echo ========================================
echo.
echo Saya akan membuka jendela "Network Connections" untuk Anda...
echo.
pause

start "" "ncpa.cpl"

echo.
echo ✅ Jendela "Network Connections" sudah dibuka!
echo.
echo ========================================
echo   LANGKAH 2: LIHAT JENDELA YANG TERBUKA
echo ========================================
echo.
echo Di jendela "Network Connections" yang baru terbuka:
echo.
echo 1. Lihat di bagian KIRI jendela
echo 2. Anda akan melihat:
echo    - Ikon 📶 (ikon sinyal WiFi)
echo    - Tulisan "Wi-Fi"
echo    - Di bawahnya ada "marina345"
echo    - Di bawahnya lagi ada "Intel(...)"
echo.
echo ========================================
echo   LANGKAH 3: KLIK KANAN PADA "Wi-Fi"
echo ========================================
echo.
echo YANG HARUS ANDA LAKUKAN:
echo.
echo 1. Cari tulisan "Wi-Fi" (ada ikon 📶 di depannya)
echo 2. Klik KANAN (tombol kanan mouse) pada "Wi-Fi"
echo    - Bisa klik pada tulisan "Wi-Fi"
echo    - Bisa klik pada ikon 📶 di sebelah kiri
echo 3. Akan muncul menu kecil dengan beberapa pilihan
echo.
echo ⚠️ PENTING: Harus klik KANAN, bukan kiri!
echo.
echo Tekan tombol apapun setelah selesai klik kanan...
pause

echo.
echo ========================================
echo   LANGKAH 4: PILIH "PROPERTIES"
echo ========================================
echo.
echo Di menu kecil yang muncul setelah klik kanan:
echo.
echo 1. Cari tulisan "Properties" di dalam menu
echo 2. Klik KIRI (tombol kiri mouse) pada "Properties"
echo 3. Jendela baru "Wi-Fi Properties" akan terbuka
echo.
echo Tekan tombol apapun setelah jendela "Wi-Fi Properties" terbuka...
pause

echo.
echo ========================================
echo   LANGKAH 5: KLIK 2X PADA "INTERNET PROTOCOL VERSION 4"
echo ========================================
echo.
echo Di jendela "Wi-Fi Properties" yang baru terbuka:
echo.
echo 1. Pastikan tab "Networking" terbuka (biasanya sudah)
echo 2. Scroll ke bawah (gulir mouse ke bawah)
echo 3. Cari item yang bertuliskan:
echo    "☑ Internet Protocol Version 4 (TCP/IPv4)"
echo 4. Klik 2 KALI (double-click) pada item tersebut
echo 5. Jendela baru akan terbuka
echo.
echo ⚠️ PENTING: Harus "Version 4", bukan "Version 6"!
echo.
echo Tekan tombol apapun setelah jendela baru terbuka...
pause

echo.
echo ========================================
echo   LANGKAH 6: PILIH "USE THE FOLLOWING IP ADDRESS"
echo ========================================
echo.
echo Di jendela "Internet Protocol Version 4 Properties":
echo.
echo 1. Ada 2 pilihan:
echo    ○ "Obtain an IP address automatically" (terpilih sekarang)
echo    ○ "Use the following IP address" ← PILIH INI!
echo.
echo 2. Klik pada "Use the following IP address"
echo 3. Setelah diklik, 3 kolom akan muncul dan bisa diisi
echo.
echo Tekan tombol apapun setelah pilih "Use the following IP address"...
pause

echo.
echo ========================================
echo   LANGKAH 7: ISI 3 KOLOM
echo ========================================
echo.
echo Sekarang isi 3 kolom yang muncul:
echo.
echo Kolom 1: IP address
echo   → Ketik: 192.168.1.13
echo   (Ganti dengan IP address Anda)
echo.
echo Kolom 2: Subnet mask
echo   → Ketik: 255.255.255.0
echo   (Biasanya ini)
echo.
echo Kolom 3: Default gateway
echo   → Ketik: 192.168.1.1
echo   (Biasanya ini)
echo.
echo Setelah selesai isi, klik "OK" → klik "OK" lagi
echo.
echo ========================================
echo   SELESAI!
echo ========================================
echo.
echo ✅ IP address Anda sekarang sudah static!
echo ✅ Tidak akan berubah lagi meski reconnect WiFi!
echo.
echo URL untuk akses dari device lain:
echo   http://192.168.1.13/nurani/public
echo   (Ganti dengan IP address Anda)
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

