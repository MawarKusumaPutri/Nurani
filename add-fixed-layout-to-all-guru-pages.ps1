# Script untuk menambahkan @include('partials.guru-fixed-layout') ke semua file blade guru
# yang belum memilikinya

$guruViewsPath = "d:\Praktikum DWBI\xampp\htdocs\nurani\resources\views\guru"
$includeStatement = "@include('partials.guru-fixed-layout')"

# Daftar file yang akan diupdate
$files = @(
    "dashboard.blade.php",
    "jadwal\index.blade.php",
    "kuis\create.blade.php",
    "kuis\edit.blade.php",
    "kuis\index.blade.php",
    "kuis\show.blade.php",
    "materi\create.blade.php",
    "materi\edit.blade.php",
    "materi\index.blade.php",
    "materi\show.blade.php",
    "materi-pembelajaran\edit.blade.php",
    "presensi-siswa\index.blade.php",
    "profil.blade.php",
    "profile\index.blade.php",
    "rangkuman\create.blade.php",
    "rangkuman\edit.blade.php",
    "rangkuman\index.blade.php",
    "rpp\create.blade.php",
    "rpp\edit.blade.php",
    "rpp\show.blade.php",
    "evaluasi\index.blade.php",
    "evaluasi\lembar\create.blade.php",
    "evaluasi\lembar\edit.blade.php",
    "evaluasi\lembar\index.blade.php",
    "evaluasi\lembar\show.blade.php",
    "evaluasi\nilai\create.blade.php",
    "evaluasi\nilai\edit.blade.php",
    "evaluasi\nilai\index.blade.php",
    "evaluasi\nilai\show.blade.php",
    "evaluasi\rekap\index.blade.php",
    "evaluasi\rekap\show.blade.php",
    "evaluasi\rubrik\create.blade.php",
    "evaluasi\rubrik\edit.blade.php",
    "evaluasi\rubrik\index.blade.php",
    "evaluasi\rubrik\show.blade.php"
)

$updatedCount = 0
$skippedCount = 0
$errorCount = 0

foreach ($file in $files) {
    $filePath = Join-Path $guruViewsPath $file
    
    if (-not (Test-Path $filePath)) {
        Write-Host "File tidak ditemukan: $file" -ForegroundColor Yellow
        $skippedCount++
        continue
    }
    
    try {
        $content = Get-Content $filePath -Raw -Encoding UTF8
        
        # Cek apakah sudah ada include
        if ($content -match [regex]::Escape($includeStatement)) {
            Write-Host "Sudah ada include: $file" -ForegroundColor Gray
            $skippedCount++
            continue
        }
        
        # Cari posisi sebelum </head>
        if ($content -match '(.*?)(\s*</head>)(.*)') {
            # Cek apakah ada @include('partials.guru-dynamic-ui')
            if ($content -match "@include\('partials\.guru-dynamic-ui'\)") {
                # Tambahkan sebelum guru-dynamic-ui
                $newContent = $content -replace "(@include\('partials\.guru-dynamic-ui'\))", "$includeStatement`r`n    `$1"
            } else {
                # Tambahkan sebelum </head>
                $newContent = $content -replace '(</head>)', "    $includeStatement`r`n`$1"
            }
            
            # Simpan file
            Set-Content -Path $filePath -Value $newContent -Encoding UTF8 -NoNewline
            Write-Host "Updated: $file" -ForegroundColor Green
            $updatedCount++
        } else {
            Write-Host "Tidak menemukan tag </head>: $file" -ForegroundColor Yellow
            $skippedCount++
        }
    } catch {
        Write-Host "Error processing $file : $_" -ForegroundColor Red
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
