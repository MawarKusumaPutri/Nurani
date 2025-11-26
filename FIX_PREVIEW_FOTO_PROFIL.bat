@echo off
echo ========================================
echo FIX PREVIEW FOTO PROFIL GURU
echo ========================================
echo.

cd /d "D:\Capstone\nurani"

echo [1/3] Clearing view cache...
call php artisan view:clear
echo.

echo [2/3] Clearing application cache...
call php artisan cache:clear
echo.

echo [3/3] Rebuilding view cache...
call php artisan view:cache
echo.

echo ========================================
echo PERBAIKAN SELESAI!
echo ========================================
echo.
echo Fitur yang sudah diperbaiki:
echo - Preview foto profil sekarang muncul saat memilih file
echo - Validasi ukuran file (maksimal 2MB)
echo - Validasi format file (JPG, PNG, GIF)
echo - Checkmark indicator muncul saat foto dipilih
echo - Foto yang sudah ada ditampilkan dengan benar
echo.
echo Langkah selanjutnya:
echo 1. Clear browser cache (Ctrl+Shift+Delete)
echo 2. Hard refresh browser (Ctrl+F5)
echo 3. Buka halaman Edit Profil Guru
echo 4. Klik "Browse" dan pilih foto
echo 5. Preview foto akan muncul otomatis!
echo.
pause

