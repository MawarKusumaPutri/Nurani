@echo off
chcp 65001 >nul
echo ========================================
echo   MASUKKAN DATA GURU KE DATABASE
echo ========================================
echo.
echo [INFO] Script ini akan memasukkan data guru dari LOGIN_CREDENTIALS.md
echo.
echo [INFO] Data yang akan dimasukkan:
echo   - 13 guru dengan email dan password yang benar
echo   - Password sesuai LOGIN_CREDENTIALS.md
echo   - Nama lengkap yang benar
echo   - Mata pelajaran yang benar
echo.
echo [PERINGATAN] Pastikan migrations sudah dijalankan dulu!
echo [INFO] Jika tabel belum ada, jalankan migrations dulu:
echo   php artisan migrate --force
echo.
echo [INFO] Pastikan MySQL sudah berjalan di XAMPP!
echo.
pause

cd /d "D:\Praktikum DWBI\xampp\htdocs\nurani"

echo.
echo [INFO] Memasukkan data guru ke database...
echo.

php artisan db:seed --class=UserSeeder

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo   BERHASIL - DATA GURU DIMASUKKAN!
    echo ========================================
    echo.
    echo [SUKSES] Data guru sudah dimasukkan ke database!
    echo.
    echo [INFO] 13 guru sudah ditambahkan:
    echo   1. Nurhadi, S.Pd - mundarinurhadi@gmail.com
    echo   2. Keysa Anjani - keysa8406@gmail.com
    echo   3. Fadli - fadliziyad123@gmail.com
    echo   4. Siti Mundari, S.Ag - sitimundari54@gmail.com
    echo   5. Lola Nurlaela, S.Pd.I. - lola.nurlaela@mtssnuraiman.sch.id
    echo   6. Desi Nurfalah - desinurfalah24@gmail.com
    echo   7. M. Rizmal Maulana - rizmalmaulana25@gmail.com
    echo   8. Hamzah Najmudin - zahnajmudin10@gmail.com
    echo   9. Sopyan - sopyanikhsananda@gmail.com
    echo   10. Syifa Restu R - syifarestu81@gmail.com
    echo   11. Weni Azmi - wenibustamin27@gmail.com
    echo   12. Tintin Martini - tintinmartini184@gmail.com
    echo   13. Mawar - mawarkusuma694@gmail.com
    echo.
    echo [INFO] Password sesuai LOGIN_CREDENTIALS.md
    echo [INFO] Test login di: http://localhost/nurani/public/
    echo.
) else (
    echo.
    echo ========================================
    echo   ERROR TERJADI!
    echo ========================================
    echo.
    echo [ERROR] Gagal memasukkan data guru!
    echo.
    echo [INFO] Kemungkinan penyebab:
    echo   1. Tabel belum ada - Jalankan migrations dulu:
    echo      php artisan migrate --force
    echo.
    echo   2. Error tablespace - Fix di phpMyAdmin:
    echo      - Buka http://localhost/phpmyadmin
    echo      - Tab SQL - Jalankan:
    echo        DROP DATABASE IF EXISTS nurani;
    echo        CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    echo      - Setelah itu, jalankan migrations dan script ini lagi
    echo.
    echo   3. Database belum ada - Buat database dulu di phpMyAdmin
    echo.
)

pause
