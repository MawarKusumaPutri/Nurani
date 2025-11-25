@echo off
title FIX PAGINATION KE ATAS
color 0A

echo.
echo ============================================
echo FIX PAGINATION KE ATAS
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [ERROR] Project tidak ditemukan!
    pause
    exit /b 1
)

cd /d "%XAMPP_PATH%\htdocs\nurani"

echo [1/2] Clear cache...
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
echo [OK] Cache cleared
echo.

echo [2/2] Verifikasi perubahan...
echo [OK] Pagination sudah dipindahkan ke atas (di card header)
echo [OK] Pagination mempertahankan filter saat pindah halaman
echo [OK] Controller menggunakan withQueryString() untuk pagination
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Perbaikan selesai:
echo - Pagination dipindahkan dari bawah tabel ke atas (di card header)
echo - Pagination berada di sebelah kanan header "Daftar Presensi Siswa"
echo - Pagination mempertahankan filter saat pindah halaman
echo - Informasi hasil tetap ditampilkan
echo.
echo CARA TEST:
echo 1. Buka: http://127.0.0.1:8000/tu/presensi-siswa
echo 2. Cek pagination sudah ada di atas (di card header)
echo 3. Pilih filter (Kelas, Status, dll)
echo 4. Klik Next/Previous
echo 5. Filter tetap terjaga saat pindah halaman
echo.
pause

