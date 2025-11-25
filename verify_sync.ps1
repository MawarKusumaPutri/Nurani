# Script Verifikasi Sinkronisasi Perubahan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Verifikasi Sinkronisasi Perubahan" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$basePath = "D:\Capstone\nurani"

# 1. Verifikasi File Controller
Write-Host "[1/6] Memverifikasi Controller..." -ForegroundColor Yellow
$controllerFile = Join-Path $basePath "app\Http\Controllers\GuruController.php"
if (Test-Path $controllerFile) {
    $content = Get-Content $controllerFile -Raw
    if ($content -match "jadwalHariIni|jadwalMingguIni|jadwalMendatang") {
        Write-Host "  ✓ GuruController.php - OK" -ForegroundColor Green
    } else {
        Write-Host "  ✗ GuruController.php - TIDAK DITEMUKAN" -ForegroundColor Red
    }
} else {
    Write-Host "  ✗ GuruController.php - FILE TIDAK ADA" -ForegroundColor Red
}

# 2. Verifikasi Model
Write-Host "[2/6] Memverifikasi Model..." -ForegroundColor Yellow
$modelFile = Join-Path $basePath "app\Models\Guru.php"
if (Test-Path $modelFile) {
    $content = Get-Content $modelFile -Raw
    if ($content -match "function jadwal\(\)") {
        Write-Host "  ✓ Guru.php - OK" -ForegroundColor Green
    } else {
        Write-Host "  ✗ Guru.php - TIDAK DITEMUKAN" -ForegroundColor Red
    }
} else {
    Write-Host "  ✗ Guru.php - FILE TIDAK ADA" -ForegroundColor Red
}

# 3. Verifikasi Route
Write-Host "[3/6] Memverifikasi Route..." -ForegroundColor Yellow
$routeFile = Join-Path $basePath "routes\web.php"
if (Test-Path $routeFile) {
    $content = Get-Content $routeFile -Raw
    if ($content -match "guru\.jadwal\.index|jadwalIndex") {
        Write-Host "  ✓ Route jadwal - OK" -ForegroundColor Green
    } else {
        Write-Host "  ✗ Route jadwal - TIDAK DITEMUKAN" -ForegroundColor Red
    }
} else {
    Write-Host "  ✗ web.php - FILE TIDAK ADA" -ForegroundColor Red
}

# 4. Verifikasi View Dashboard
Write-Host "[4/6] Memverifikasi View Dashboard..." -ForegroundColor Yellow
$dashboardFile = Join-Path $basePath "resources\views\guru\dashboard.blade.php"
if (Test-Path $dashboardFile) {
    $content = Get-Content $dashboardFile -Raw
    if ($content -match "Jadwal Mengajar|jadwalHariIni|jadwalMingguIni") {
        Write-Host "  ✓ dashboard.blade.php - OK" -ForegroundColor Green
    } else {
        Write-Host "  ✗ dashboard.blade.php - TIDAK DITEMUKAN" -ForegroundColor Red
    }
} else {
    Write-Host "  ✗ dashboard.blade.php - FILE TIDAK ADA" -ForegroundColor Red
}

# 5. Verifikasi View Jadwal Index
Write-Host "[5/6] Memverifikasi View Jadwal..." -ForegroundColor Yellow
$jadwalFile = Join-Path $basePath "resources\views\guru\jadwal\index.blade.php"
if (Test-Path $jadwalFile) {
    Write-Host "  ✓ jadwal/index.blade.php - OK" -ForegroundColor Green
} else {
    Write-Host "  ✗ jadwal/index.blade.php - FILE TIDAK ADA" -ForegroundColor Red
}

# 6. Verifikasi Link di Sidebar
Write-Host "[6/6] Memverifikasi Link Sidebar..." -ForegroundColor Yellow
$viewFiles = @(
    "resources\views\guru\presensi\index.blade.php",
    "resources\views\guru\materi\index.blade.php",
    "resources\views\guru\kuis\index.blade.php"
)

$allOk = $true
foreach ($file in $viewFiles) {
    $fullPath = Join-Path $basePath $file
    if (Test-Path $fullPath) {
        $content = Get-Content $fullPath -Raw
        if ($content -match "guru\.jadwal\.index|Jadwal Mengajar") {
            Write-Host "  ✓ $(Split-Path $file -Leaf) - OK" -ForegroundColor Green
        } else {
            Write-Host "  ✗ $(Split-Path $file -Leaf) - TIDAK DITEMUKAN" -ForegroundColor Red
            $allOk = $false
        }
    }
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
if ($allOk) {
    Write-Host "✓ SEMUA FILE SUDAH TERSINKRON!" -ForegroundColor Green
} else {
    Write-Host "✗ ADA FILE YANG BELUM TERSINKRON" -ForegroundColor Red
}
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
Write-Host "1. Clear cache: php artisan optimize:clear" -ForegroundColor White
Write-Host "2. Refresh browser dengan Ctrl+F5" -ForegroundColor White
Write-Host "3. Clear browser cache jika perlu" -ForegroundColor White
Write-Host ""

