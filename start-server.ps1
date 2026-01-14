# Script untuk menjalankan Laravel server dan ngrok
# Jalankan dengan: .\start-server.ps1

Write-Host "🚀 Starting TMS Nurani Server..." -ForegroundColor Green
Write-Host ""

# Clear cache dulu
Write-Host "📦 Clearing cache..." -ForegroundColor Yellow
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

Write-Host ""
Write-Host "✅ Cache cleared!" -ForegroundColor Green
Write-Host ""

# Tampilkan instruksi
Write-Host "📋 INSTRUKSI:" -ForegroundColor Cyan
Write-Host "1. Server Laravel akan berjalan di http://127.0.0.1:8000" -ForegroundColor White
Write-Host "2. Buka terminal BARU dan jalankan: ngrok http 8000" -ForegroundColor White
Write-Host "3. Copy URL ngrok yang muncul (contoh: https://xxx.ngrok-free.dev)" -ForegroundColor White
Write-Host "4. Akses URL ngrok tersebut di browser" -ForegroundColor White
Write-Host ""
Write-Host "⚠️  PENTING: Jangan tutup terminal ini!" -ForegroundColor Red
Write-Host ""

# Jalankan Laravel server
Write-Host "🌐 Starting Laravel server on http://127.0.0.1:8000..." -ForegroundColor Green
php artisan serve --host=127.0.0.1 --port=8000
