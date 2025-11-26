@echo off
echo ========================================
echo FIX FOTO PROFIL KEPALA SEKOLAH - FINAL
echo ========================================
echo.

cd /d "D:\Capstone\nurani"

echo [1/5] Clearing view cache...
call php artisan view:clear
echo.

echo [2/5] Clearing application cache...
call php artisan cache:clear
echo.

echo [3/5] Clearing config cache...
call php artisan config:clear
echo.

echo [4/5] Clearing route cache...
call php artisan route:clear
echo.

echo [5/5] Rebuilding view cache...
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
echo - Cache busting dengan timestamp
echo - Debug info jika foto tidak ditemukan
echo.
echo File yang sudah diperbaiki:
echo - resources/views/kepala_sekolah/profile/index.blade.php
echo - resources/views/kepala_sekolah/profile/edit.blade.php
echo - resources/views/partials/kepala-sekolah-sidebar.blade.php
echo - app/Http/Controllers/KepalaSekolahController.php
echo.
echo Langkah selanjutnya:
echo 1. Clear browser cache (Ctrl+Shift+Delete)
echo 2. Hard refresh browser (Ctrl+F5)
echo 3. Buka halaman Profil Saya
echo 4. Jika foto belum muncul, coba upload ulang foto
echo 5. Pastikan foto tersimpan di: storage/app/public/profiles/kepala_sekolah/
echo.
echo Troubleshooting:
echo - Jika foto masih tidak muncul, cek console browser (F12)
echo - Cek apakah path foto muncul di halaman (jika ada error)
echo - Pastikan folder storage/app/public/profiles/kepala_sekolah/ ada
echo - Pastikan symlink storage sudah dibuat: php artisan storage:link
echo.
pause

