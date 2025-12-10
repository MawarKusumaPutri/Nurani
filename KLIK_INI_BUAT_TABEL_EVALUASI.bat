@echo off
chcp 65001 >nul
cls
echo ========================================
echo MEMBUAT TABEL EVALUASI GURU SECARA OTOMATIS
echo ========================================
echo.
cd /d "%~dp0"
echo Direktori: %CD%
echo.
echo Menjalankan script PHP...
echo.
php BUAT_TABEL_EVALUASI_LANGSUNG.php
echo.
echo ========================================
echo Selesai!
echo ========================================
echo.
echo Jika berhasil, refresh halaman Rubrik Penilaian di browser (Ctrl+F5)
echo Atau buka: http://localhost/nurani/public/guru/evaluasi/rubrik
echo.
pause
