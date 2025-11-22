@echo off
echo ============================================
echo PEMBUATAN SELF-SIGNED CERTIFICATE SSL
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

echo [1/4] Membuat private key (nurani.key)...
openssl genrsa -out nurani.key 2048
if %errorlevel% neq 0 (
    echo ERROR: Gagal membuat private key!
    pause
    exit /b 1
)
echo [OK] Private key berhasil dibuat.
echo.

echo [2/4] Membuat Certificate Signing Request (nurani.csr)...
echo.
echo ============================================
echo ISI INFORMASI BERIKUT:
echo ============================================
echo Country Name: ID
echo State: Jakarta
echo City: Jakarta
echo Organization: MTs Nurul Aiman
echo Organizational Unit: IT Department
echo Common Name: nurani.test
echo Email: admin@nurani.test
echo.
echo Untuk "A challenge password" dan "An optional company name",
echo tekan Enter saja (kosongkan).
echo ============================================
echo.
pause

openssl req -new -key nurani.key -out nurani.csr
if %errorlevel% neq 0 (
    echo ERROR: Gagal membuat CSR!
    pause
    exit /b 1
)
echo [OK] CSR berhasil dibuat.
echo.

echo [3/4] Membuat self-signed certificate (nurani.crt)...
openssl x509 -req -days 365 -in nurani.csr -signkey nurani.key -out nurani.crt
if %errorlevel% neq 0 (
    echo ERROR: Gagal membuat certificate!
    pause
    exit /b 1
)
echo [OK] Certificate berhasil dibuat.
echo.

echo [4/4] Verifikasi file...
if exist "nurani.key" (
    echo [OK] nurani.key ditemukan
) else (
    echo [ERROR] nurani.key tidak ditemukan!
)

if exist "nurani.crt" (
    echo [OK] nurani.crt ditemukan
) else (
    echo [ERROR] nurani.crt tidak ditemukan!
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
echo - nurani.key (Private Key)
echo - nurani.csr (Certificate Signing Request)
echo - nurani.crt (Certificate)
echo.
echo Langkah selanjutnya:
echo 1. Aktifkan mod_ssl di httpd.conf
echo 2. Update VirtualHost untuk HTTPS
echo 3. Update .env: APP_URL=https://nurani.test
echo 4. Restart Apache
echo.
echo Lihat file: PANDUAN_SETUP_HTTPS_XAMPP.md
echo.
pause

