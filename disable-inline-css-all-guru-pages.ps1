# Script untuk menonaktifkan CSS inline yang menimpa CSS global
# di SEMUA file blade guru yang memiliki "position: relative !important"

$guruViewsPath = "d:\Praktikum DWBI\xampp\htdocs\nurani\resources\views\guru"
$updatedCount = 0
$skippedCount = 0
$errorCount = 0

# Pattern yang akan dicari dan dikomentari
$startPattern = "/* Layout - sama seperti presensi"
$endPattern = "/* OVERRIDE MOBILE CSS UNTUK DESKTOP - ULTRA AGGRESSIVE */"

# Cari semua file blade di folder guru
$files = Get-ChildItem -Path $guruViewsPath -Recurse -Filter "*.blade.php"

foreach ($file in $files) {
    try {
        $content = Get-Content $file.FullName -Raw -Encoding UTF8
        
        # Cek apakah file memiliki pattern yang bermasalah
        if ($content -match "position: relative !important;" -and 
            $content -match "@include\('partials\.guru-fixed-layout'\)" -and
            $content -match [regex]::Escape($startPattern)) {
            
            # Cek apakah sudah dikomentari
            if ($content -match "/\*\s*Layout CSS - DISABLED") {
                Write-Host "Sudah dikomentari: $($file.Name)" -ForegroundColor Gray
                $skippedCount++
                continue
            }
            
            # Komentari CSS inline yang bermasalah
            $newContent = $content -replace [regex]::Escape($startPattern), "/* Layout CSS - DISABLED - Menggunakan CSS Global dari guru-fixed-layout.blade.php */`r`n        /*`r`n        $startPattern"
            
            # Tambahkan penutup komentar sebelum OVERRIDE MOBILE CSS
            $newContent = $newContent -replace [regex]::Escape($endPattern), "*/`r`n        `r`n        /* OVERRIDE MOBILE CSS UNTUK DESKTOP - DISABLED */`r`n        /*`r`n        $endPattern"
            
            # Tambahkan penutup komentar di akhir media query
            $newContent = $newContent -replace "(\s+)\}\s+\}\s+</style>", "`$1        }`r`n        }`r`n        */`r`n    </style>"
            
            # Simpan file
            Set-Content -Path $file.FullName -Value $newContent -Encoding UTF8 -NoNewline
            Write-Host "Updated: $($file.Name)" -ForegroundColor Green
            $updatedCount++
        } else {
            $skippedCount++
        }
    } catch {
        Write-Host "Error processing $($file.Name): $_" -ForegroundColor Red
        $errorCount++
    }
}

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "SUMMARY" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Updated: $updatedCount files" -ForegroundColor Green
Write-Host "Skipped: $skippedCount files" -ForegroundColor Yellow
Write-Host "Errors: $errorCount files" -ForegroundColor Red
Write-Host "========================================`n" -ForegroundColor Cyan
