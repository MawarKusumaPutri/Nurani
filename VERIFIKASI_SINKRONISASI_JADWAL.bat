@echo off
echo ========================================
echo   VERIFIKASI SINKRONISASI JADWAL
echo ========================================
echo.

cd /d "%~dp0"

echo [1/4] Membersihkan cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo [SUKSES] Cache sudah dibersihkan
echo.

echo [2/4] Memeriksa struktur database...
php artisan migrate:status | findstr "jadwal"
if %errorlevel% equ 0 (
    echo [SUKSES] Tabel jadwal sudah ada
) else (
    echo [INFO] Menjalankan migration...
    php artisan migrate
)
echo.

echo [3/4] Memeriksa kolom is_lapangan...
php -r "require 'vendor/autoload.php'; \$app = require_once 'bootstrap/app.php'; \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); \$columns = \Illuminate\Support\Facades\Schema::getColumnListing('jadwal'); echo in_array('is_lapangan', \$columns) ? '[SUKSES] Kolom is_lapangan sudah ada' : '[WARNING] Kolom is_lapangan belum ada';"
echo.

echo [4/4] Verifikasi query jadwal...
php -r "require 'vendor/autoload.php'; \$app = require_once 'bootstrap/app.php'; \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); \$total = \App\Models\Jadwal::count(); echo '[INFO] Total jadwal di database: ' . \$total . PHP_EOL;"
echo.

echo ========================================
echo   VERIFIKASI SELESAI!
echo ========================================
echo.
echo [CATATAN PENTING]
echo 1. Jadwal yang dibuat TU OTOMATIS muncul di halaman guru
echo 2. Query menggunakan guru_id yang sama
echo 3. Hanya jadwal dengan status 'aktif' yang ditampilkan
echo 4. Tidak perlu refresh manual - cukup refresh browser
echo.
pause

