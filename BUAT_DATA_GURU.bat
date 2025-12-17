@echo off
echo ========================================
echo   BUAT DATA GURU UNTUK LOGIN
echo ========================================
echo.
echo [INFO] Script ini akan:
echo 1. Jalankan migrations (jika belum)
echo 2. Jalankan seeder untuk membuat data guru
echo.
echo [INFO] Password default untuk semua guru: password123
echo [INFO] Guru bisa ubah password sendiri setelah login
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [1/2] Menjalankan migrations...
php artisan migrate --force

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Migrations gagal!
    echo [INFO] Cek error di atas
    pause
    exit /b
)
echo.

echo [2/2] Membuat data guru...
php artisan db:seed --class=UserSeeder

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   SELESAI!
    echo ========================================
    echo.
    echo [SUKSES] Data guru sudah dibuat!
    echo.
    echo [INFO] Data guru yang dibuat:
    echo 1. Syifa Restu R - syifarestu81@gmail.com (TU & Seni Budaya)
    echo 2. Keysa Anjani - keysa8406@gmail.com (Bahasa Inggris)
    echo 3. Desi Nurfalah - desinurfalah24@gmail.com (Bahasa Indonesia)
    echo 4. Sopyan - sopyanikhsananda@gmail.com (PKN)
    echo 5. Weni Azmi - wenibustamin27@gmail.com (Tahsin)
    echo 6. Tintin Martini - tintinmartini184@gmail.com (BTQ)
    echo 7. Fadli - fadliziyad123@gmail.com (Bahasa Arab)
    echo 8. Siti Mundari - sitimundari54@gmail.com (IPA, Prakarya)
    echo 9. Nurhadi - mundarinurhadi@gmail.com (Matematika)
    echo 10. Hamzah Najmudin - zahnajmudin10@gmail.com (PJOK, IPS)
    echo 11. Rizmal - rizmalmaulana25@gmail.com (QH, FIQIH)
    echo.
    echo [INFO] Password default: password123
    echo [INFO] Guru bisa ubah password sendiri setelah login
    echo.
    echo [INFO] Silakan test login di: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo [ERROR] Seeder gagal!
    echo [INFO] Cek error di atas
    echo.
)
pause
