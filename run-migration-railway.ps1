# Script untuk menjalankan migration di Railway
# Jalankan dengan: .\run-migration-railway.ps1

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "MENJALANKAN MIGRATION DI RAILWAY" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Cek apakah Railway CLI sudah terinstall
$railwayExists = Get-Command railway -ErrorAction SilentlyContinue

if (-not $railwayExists) {
    Write-Host "❌ Railway CLI belum terinstall!" -ForegroundColor Red
    Write-Host "Install dengan: npm install -g @railway/cli" -ForegroundColor Yellow
    exit 1
}

Write-Host "✅ Railway CLI ditemukan" -ForegroundColor Green
Write-Host ""

# Informasi login
Write-Host "🔐 Pastikan Anda sudah login ke Railway..." -ForegroundColor Yellow
Write-Host "Jika belum, jalankan: railway login" -ForegroundColor Gray
Write-Host ""

# Informasi link project
Write-Host "🔗 Pastikan Anda sudah link ke project Railway..." -ForegroundColor Yellow
Write-Host "Jika belum, jalankan: railway link" -ForegroundColor Gray
Write-Host ""

# Jalankan migration
Write-Host "🚀 Menjalankan migration..." -ForegroundColor Cyan
railway run php artisan migrate --force

Write-Host ""
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "✅ MIGRATION SELESAI!" -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Silakan refresh halaman dan coba lagi." -ForegroundColor Yellow
