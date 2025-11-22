@echo off
echo ============================================
echo PEMBUATAN SELF-SIGNED CERTIFICATE SSL
echo Domain: nuraniTMS.test
echo ============================================
echo.

REM Cek apakah OpenSSL tersedia
where openssl >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: OpenSSL tidak ditemukan!
    echo Pastikan XAMPP sudah terinstall dengan lengkap.
    pause
    exit /b 1
)

echo [OK] OpenSSL ditemukan.
echo.

REM Buat folder ssl jika belum ada
if not exist "C:\xampp\apache\conf\ssl" (
    echo Membuat folder ssl...
    mkdir "C:\xampp\apache\conf\ssl"
    echo [OK] Folder ssl dibuat.
    echo.
)

REM Navigate ke folder ssl
cd /d "C:\xampp\apache\conf\ssl"

echo [1/4] Membuat private key (nuraniTMS.key)...
openssl genrsa -out nuraniTMS.key 2048
if %errorlevel% neq 0 (
    echo ERROR: Gagal membuat private key!
    pause
    exit /b 1
)
echo [OK] Private key berhasil dibuat.
echo.

echo [2/4] Membuat Certificate Signing Request (nuraniTMS.csr)...
echo.
echo ============================================
echo ISI INFORMASI BERIKUT:
echo ============================================
echo Country Name: ID
echo State: Jakarta
echo City: Jakarta
echo Organization: MTs Nurul Aiman
echo Organizational Unit: IT Department
echo Common Name: nuraniTMS.test    ← PENTING!
echo Email: admin@nuraniTMS.test
echo.
echo Untuk "A challenge password" dan "An optional company name",
echo tekan Enter saja (kosongkan).
echo ============================================
echo.
pause

openssl req -new -key nuraniTMS.key -out nuraniTMS.csr
if %errorlevel% neq 0 (
    echo ERROR: Gagal membuat CSR!
    pause
    exit /b 1
)
echo [OK] CSR berhasil dibuat.
echo.

echo [3/4] Membuat self-signed certificate (nuraniTMS.crt)...
openssl x509 -req -days 365 -in nuraniTMS.csr -signkey nuraniTMS.key -out nuraniTMS.crt
if %errorlevel% neq 0 (
    echo ERROR: Gagal membuat certificate!
    pause
    exit /b 1
)
echo [OK] Certificate berhasil dibuat.
echo.

echo [4/4] Verifikasi file...
if exist "nuraniTMS.key" (
    echo [OK] nuraniTMS.key ditemukan
) else (
    echo [ERROR] nuraniTMS.key tidak ditemukan!
)

if exist "nuraniTMS.crt" (
    echo [OK] nuraniTMS.crt ditemukan
) else (
    echo [ERROR] nuraniTMS.crt tidak ditemukan!
)

echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
echo File certificate sudah dibuat di:
echo C:\xampp\apache\conf\ssl\
echo.
echo File yang dibuat:
echo - nuraniTMS.key (Private Key)
echo - nuraniTMS.csr (Certificate Signing Request)
echo - nuraniTMS.crt (Certificate)
echo.
echo Langkah selanjutnya:
echo 1. Aktifkan mod_ssl di httpd.conf
echo 2. Update VirtualHost untuk HTTPS
echo 3. Update file hosts Windows
echo 4. Update .env: APP_URL=https://nuraniTMS.test
echo 5. Restart Apache
echo.
echo Lihat file: SOLUSI_LENGKAP_NURANITMS.md
echo.
pause

