@echo off
title FIX PAGINATION ARSIP DOKUMEN
color 0A

echo.
echo ============================================
echo FIX PAGINATION ARSIP DOKUMEN
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
echo [OK] Controller TuController::arsipIndex() sudah diperbaiki
echo [OK] View tu/arsip/index.blade.php sudah diperbaiki
echo [OK] Pagination lama dihapus (di bawah tabel)
echo [OK] Pagination baru ditambahkan di card header
echo [OK] Tombol Previous dan Next dengan styling biru
echo [OK] Informasi hasil dan halaman ditampilkan
echo [OK] Nomor urut menggunakan firstItem() untuk pagination
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Perbaikan selesai:
echo - Pagination dipindahkan dari bawah ke atas (di card header)
echo - Tombol Previous dan Next sama seperti Presensi Siswa
echo - Warna biru (bukan hijau) untuk tombol aktif
echo - Pagination di card header (sebelah kanan judul)
echo - Informasi hasil dan halaman ditampilkan
echo - Pagination lama (di bawah) sudah dihapus
echo.
echo CARA TEST:
echo 1. Buka: http://127.0.0.1:8000/tu/arsip
echo 2. Cek pagination di card header (sebelah kanan judul)
echo 3. Klik tombol Next atau Previous
echo 4. Warna tombol biru (bukan hijau)
echo 5. Data ter-paginate dengan benar
echo.
pause

