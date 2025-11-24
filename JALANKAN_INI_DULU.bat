@echo off
title CEK MASALAH - nuranitms.test
color 0E

cls
echo.
echo ============================================
echo    CEK MASALAH - nuranitms.test
echo ============================================
echo.
echo Script ini akan mengecek semua konfigurasi
echo dan menunjukkan masalah yang ada.
echo.
echo Tekan tombol apapun untuk mulai...
pause >nul

call "%~dp0CEK_DAN_PERBAIKI_SEMUA_MASALAH.bat"

echo.
echo ============================================
echo    CEK SELESAI!
echo ============================================
echo.
echo Jika ada [ERROR], perbaiki sesuai SOLUSI
echo yang ditampilkan di atas.
echo.
echo Setelah semua [OK]:
echo 1. Jalankan: FIX_NURANITMS.bat
echo 2. RESTART Apache
echo 3. RESTART KOMPUTER
echo 4. Test: https://nuranitms.test
echo.
pause

