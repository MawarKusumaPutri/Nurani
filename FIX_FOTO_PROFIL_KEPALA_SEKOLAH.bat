@echo off
echo ========================================
echo FIX FOTO PROFIL KEPALA SEKOLAH
echo ========================================
echo.

cd /d "D:\Capstone\nurani"

echo [1/4] Clearing view cache...
call php artisan view:clear
echo.

echo [2/4] Clearing application cache...
call php artisan cache:clear
echo.

echo [3/4] Clearing config cache...
call php artisan config:clear
echo.

echo [4/4] Rebuilding view cache...
call php artisan view:cache
echo.

echo ========================================
echo PERBAIKAN SELESAI!
echo ========================================
echo.
echo Fitur yang sudah diperbaiki:
echo - Foto profil muncul di halaman Profil Saya
echo - Foto profil muncul di sidebar
echo - Preview foto muncul saat memilih file di Edit Profil
echo - Validasi ukuran file (maksimal 2MB)
echo - Validasi format file (JPG, PNG, GIF)
echo - Checkmark indicator muncul saat foto dipilih
echo - Fallback untuk mencari foto di berbagai lokasi
echo.
echo File yang sudah diperbaiki:
echo - resources/views/kepala_sekolah/profile/index.blade.php
echo - resources/views/kepala_sekolah/profile/edit.blade.php
echo - resources/views/partials/kepala-sekolah-sidebar.blade.php
echo.
echo Langkah selanjutnya:
echo 1. Clear browser cache (Ctrl+Shift+Delete)
echo 2. Hard refresh browser (Ctrl+F5)
echo 3. Buka halaman Profil Saya
echo 4. Foto profil akan muncul di sidebar dan di section "Foto Profil"
echo 5. Klik "Ganti Foto" untuk upload foto baru
echo 6. Preview foto akan muncul otomatis saat memilih file!
echo.
pause

