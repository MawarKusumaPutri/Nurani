# Script PowerShell untuk deploy otomatis ke Railway
# Setiap kali ada perubahan, jalankan script ini dengan: .\deploy.ps1

Write-Host "🚀 Starting deployment to Railway..." -ForegroundColor Green

# 1. Add all changes
Write-Host "📦 Adding changes to git..." -ForegroundColor Yellow
git add .

# 2. Commit changes
Write-Host "💾 Committing changes..." -ForegroundColor Yellow
$commitMessage = Read-Host "Enter commit message"
git commit -m "$commitMessage"

# 3. Push to repository
Write-Host "⬆️ Pushing to repository..." -ForegroundColor Yellow
git push

Write-Host "✅ Changes pushed! Railway will auto-deploy if connected to GitHub." -ForegroundColor Green
Write-Host "🔄 Check Railway dashboard for deployment status." -ForegroundColor Cyan

# Optional: Deploy directly using Railway CLI
$deployCli = Read-Host "Deploy directly using Railway CLI? (y/n)"
if ($deployCli -eq "y") {
    Write-Host "🚂 Deploying via Railway CLI..." -ForegroundColor Yellow
    railway up
}

Write-Host "✨ Done!" -ForegroundColor Green
