@echo off
echo ============================================
echo UPDATE SEMUA KONFIGURASI KE nuraniTMS.test
echo ============================================
echo.

REM Cek apakah di folder Laravel
if not exist "artisan" (
    echo ERROR: File artisan tidak ditemukan!
    echo Pastikan script ini dijalankan di root folder Laravel.
    pause
    exit /b 1
)

echo [1/5] Update .env...
if exist ".env" (
    echo Mengupdate APP_URL ke https://nuraniTMS.test...
    powershell -Command "(Get-Content '.env') -replace 'APP_URL=http://nurani.test', 'APP_URL=https://nuraniTMS.test' | Set-Content '.env'"
    powershell -Command "(Get-Content '.env') -replace 'APP_URL=https://nurani.test', 'APP_URL=https://nuraniTMS.test' | Set-Content '.env'"
    powershell -Command "(Get-Content '.env') -replace 'APP_URL=http://127.0.0.1:8000', 'APP_URL=https://nuraniTMS.test' | Set-Content '.env'"
    
    REM Tambahkan SESSION_SECURE_COOKIE jika belum ada
    findstr /C:"SESSION_SECURE_COOKIE" .env >nul
    if %errorlevel% neq 0 (
        echo Menambahkan SESSION_SECURE_COOKIE=true...
        echo. >> .env
        echo SESSION_SECURE_COOKIE=true >> .env
    ) else (
        powershell -Command "(Get-Content '.env') -replace 'SESSION_SECURE_COOKIE=false', 'SESSION_SECURE_COOKIE=true' | Set-Content '.env'"
    )
    
    echo [OK] .env sudah diupdate.
) else (
    echo [ERROR] File .env tidak ditemukan!
)
echo.

echo [2/5] Clearing cache...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo [OK] Cache sudah di-clear.
echo.

echo [3/5] Informasi file hosts...
echo.
echo ============================================
echo UPDATE FILE HOSTS WINDOWS:
echo ============================================
echo.
echo 1. Buka Notepad sebagai Administrator
echo 2. Buka: C:\Windows\System32\drivers\etc\hosts
echo 3. Hapus baris lama (jika ada):
echo    127.0.0.1    nurani.test
echo 4. Tambahkan di akhir:
echo    127.0.0.1    nuraniTMS.test
echo    127.0.0.1    www.nuraniTMS.test
echo 5. Simpan
echo 6. Jalankan: ipconfig /flushdns
echo.
echo Lihat file: COPY_PASTE_HOSTS_NURANITMS.txt
echo.
pause

echo.
echo [4/5] Informasi VirtualHost...
echo.
echo ============================================
echo UPDATE VIRTUALHOST APACHE:
echo ============================================
echo.
echo 1. Buka: C:\xampp\apache\conf\extra\httpd-vhosts.conf
echo 2. Hapus VirtualHost lama (jika ada)
echo 3. Copy-paste dari: KONFIGURASI_VIRTUALHOST_HTTPS_NURANITMS.txt
echo 4. Simpan
echo.
echo Lihat file: KONFIGURASI_VIRTUALHOST_HTTPS_NURANITMS.txt
echo.
pause

echo.
echo [5/5] Informasi Certificate...
echo.
echo ============================================
echo BUAT CERTIFICATE BARU:
echo ============================================
echo.
echo 1. Jalankan: SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat
echo 2. Saat diminta Common Name, isi: nuraniTMS.test
echo 3. Pastikan file dibuat:
echo    - C:\xampp\apache\conf\ssl\nuraniTMS.crt
echo    - C:\xampp\apache\conf\ssl\nuraniTMS.key
echo.
pause

echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Langkah selanjutnya:
echo 1. Buat certificate: SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat
echo 2. Update file hosts Windows
echo 3. Update VirtualHost Apache
echo 4. Aktifkan mod_ssl di httpd.conf (jika belum)
echo 5. RESTART Apache
echo 6. Test: https://nuraniTMS.test
echo.
echo Lihat panduan lengkap: SOLUSI_LENGKAP_NURANITMS.md
echo.
pause

