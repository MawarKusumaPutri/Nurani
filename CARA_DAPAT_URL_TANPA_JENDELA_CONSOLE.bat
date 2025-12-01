@echo off
chcp 65001 >nul
title Cara Dapat URL Ngrok Tanpa Jendela Console
color 0B

echo.
echo ========================================
echo   CARA DAPAT URL NGROK
echo   (Tanpa Jendela Console)
echo ========================================
echo.

:: Check if ngrok is running
tasklist /FI "IMAGENAME eq ngrok.exe" 2>NUL | find /I /N "ngrok.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✅ Ngrok sedang berjalan
    echo.
    goto :show_web_interface
) else (
    echo ❌ Ngrok tidak berjalan!
    echo.
    echo ⚠️  PERLU TINDAKAN:
    echo    1. Jalankan ngrok dulu
    echo    2. Double-click: CEK_DAN_RESTART_NGROK.bat
    echo    3. Atau jalankan: ngrok http 80
    echo.
    pause
    exit /b 1
)

:show_web_interface
echo ========================================
echo   CARA 1: BUKA WEB INTERFACE NGROK
echo   (PALING MUDAH!)
echo ========================================
echo.
echo Ngrok memiliki web interface yang menampilkan URL!
echo.
echo LANGKAH:
echo 1. Buka browser (Chrome, Edge, Firefox)
echo 2. Ketik di address bar:
echo    http://127.0.0.1:4040
echo    Atau: http://localhost:4040
echo 3. Tekan Enter
echo.
echo Akan muncul halaman web ngrok!
echo.
echo Di halaman web, cari bagian "Forwarding"
echo Copy URL dari bagian "Forwarding"
echo.
echo ========================================
echo   MEMBUKA WEB INTERFACE...
echo ========================================
echo.
echo Membuka browser...
start http://127.0.0.1:4040
echo.
echo ✅ Browser sudah dibuka!
echo.
echo ========================================
echo   CARA MENDAPATKAN URL:
echo ========================================
echo.
echo Di halaman web ngrok yang baru terbuka:
echo 1. Cari bagian "Forwarding"
echo 2. Akan terlihat seperti:
echo    Forwarding
echo    https://abc-def-123.ngrok-free.app → http://localhost:80
echo.
echo 3. Copy URL (bagian kiri, sebelum →)
echo    Contoh: https://abc-def-123.ngrok-free.app
echo.
echo 4. Tambahkan /nurani/public di AKHIR
echo    Menjadi: https://abc-def-123.ngrok-free.app/nurani/public
echo.
echo 5. Test di browser!
echo.
echo ========================================
echo   CATATAN:
echo ========================================
echo.
echo ⚠️  Jika halaman web tidak muncul:
echo    - Pastikan ngrok masih running
echo    - Cek di Task Manager: cari "ngrok.exe"
echo    - Tunggu beberapa detik, lalu refresh (F5)
echo.
echo ⚠️  URL akan berubah setiap restart ngrok
echo    - Setiap kali restart, dapat URL baru
echo    - URL lama tidak bisa digunakan lagi
echo.
echo ========================================
echo.
echo Tekan tombol apapun untuk menutup...
pause >nul

