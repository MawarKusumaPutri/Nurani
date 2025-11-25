@echo off
title PERBAIKAN FINAL - nuranitms.test
color 0A

cls
echo.
echo ============================================
echo    PERBAIKAN FINAL - nuranitms.test
echo ============================================
echo.
echo Script ini akan:
echo - Membuat certificate SSL otomatis
echo - Mengaktifkan mod_ssl otomatis
echo - Membuat VirtualHost HTTPS otomatis
echo - Update file hosts otomatis
echo - Update .env otomatis
echo - Clear cache otomatis
echo.
echo TIDAK PERLU SETTING MANUAL!
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

call "%~dp0PERBAIKAN_FINAL_100_PERSEN.bat"

echo.
echo ============================================
echo    SELESAI!
echo ============================================
echo.
echo LANGKAH TERAKHIR:
echo.
echo 1. Buka XAMPP Control Panel
echo 2. STOP Apache
echo 3. TUNGGU 10 DETIK
echo 4. START Apache
echo 5. TUNGGU 5 DETIK
echo.
echo Setelah itu:
echo 1. Tutup semua tab browser
echo 2. Buka browser baru (Ctrl+Shift+N untuk Incognito)
echo 3. Ketik: https://nuranitms.test
echo 4. Klik "Advanced" - "Proceed to site"
echo.
echo Website TMS NURANI akan muncul!
echo.
pause

