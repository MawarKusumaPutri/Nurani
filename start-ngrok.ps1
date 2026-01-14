# Script untuk menjalankan ngrok
# Jalankan di terminal TERPISAH setelah server Laravel berjalan

Write-Host "🌐 Starting ngrok tunnel..." -ForegroundColor Green
Write-Host ""
Write-Host "⚠️  Pastikan Laravel server sudah berjalan di http://127.0.0.1:8000" -ForegroundColor Yellow
Write-Host ""

# Tunggu 2 detik
Start-Sleep -Seconds 2

# Jalankan ngrok
Write-Host "🚀 Connecting to ngrok..." -ForegroundColor Cyan
ngrok http 8000

# Jika ngrok tidak ditemukan
if ($LASTEXITCODE -ne 0) {
    Write-Host ""
    Write-Host "❌ Ngrok tidak ditemukan!" -ForegroundColor Red
    Write-Host ""
    Write-Host "📥 Install ngrok terlebih dahulu:" -ForegroundColor Yellow
    Write-Host "1. Download dari: https://ngrok.com/download" -ForegroundColor White
    Write-Host "2. Extract file zip" -ForegroundColor White
    Write-Host "3. Jalankan: ngrok http 8000" -ForegroundColor White
    Write-Host ""
}
