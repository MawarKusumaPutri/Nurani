<?php
/**
 * SCRIPT IMPORT JADWAL ALTERNATIF
 * Cara pakai: Upload file ini ke public folder, lalu akses via browser
 * URL: http://localhost/nurani/public/import-jadwal-simple.php
 */

// Autoload Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Jadwal;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;

// Cek jika ada upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    
    $semester = $_POST['semester'] ?? '1';
    $tahunAjaran = $_POST['tahun_ajaran'] ?? '2025/2026';
    
    $file = $_FILES['excel_file'];
    $filePath = $file['tmp_name'];
    
    // Load PhpSpreadsheet
    require __DIR__.'/../vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\IOFactory;
    
    try {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        $successCount = 0;
        $errorCount = 0;
        $errors = [];
        
        // Skip header row
        array_shift($rows);
        
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 karena index 0 dan skip header
            
            // Skip empty rows
            if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
                continue;
            }
            
            $mataPelajaran = trim($row[0]);
            $namaGuru = trim($row[1]);
            $kelas = trim($row[2]);
            $hari = strtolower(trim($row[3]));
            $jamMulai = trim($row[4]);
            $jamSelesai = trim($row[5]);
            $ruang = trim($row[6] ?? '');
            
            // Cari guru
            $guru = Guru::whereHas('user', function($query) use ($namaGuru) {
                $query->where('name', 'LIKE', '%' . $namaGuru . '%');
            })->first();
            
            if (!$guru) {
                $errorCount++;
                $errors[] = "Baris $rowNumber: Guru '$namaGuru' tidak ditemukan";
                continue;
            }
            
            // Normalisasi hari
            $hariMap = [
                'senin' => 'senin', 'sen' => 'senin',
                'selasa' => 'selasa', 'sel' => 'selasa',
                'rabu' => 'rabu', 'rab' => 'rabu',
                'kamis' => 'kamis', 'kam' => 'kamis',
                'jumat' => 'jumat', 'jum' => 'jumat',
                'sabtu' => 'sabtu', 'sab' => 'sabtu',
            ];
            $hari = $hariMap[$hari] ?? null;
            
            if (!$hari) {
                $errorCount++;
                $errors[] = "Baris $rowNumber: Hari tidak valid";
                continue;
            }
            
            // Parse waktu
            if (!preg_match('/^\d{1,2}:\d{2}/', $jamMulai)) {
                $errorCount++;
                $errors[] = "Baris $rowNumber: Format jam mulai tidak valid";
                continue;
            }
            
            if (!preg_match('/^\d{1,2}:\d{2}/', $jamSelesai)) {
                $errorCount++;
                $errors[] = "Baris $rowNumber: Format jam selesai tidak valid";
                continue;
            }
            
            // Normalisasi mata pelajaran
            $mataPelajaran = strtolower(str_replace(' ', '_', $mataPelajaran));
            
            // Insert ke database
            try {
                Jadwal::create([
                    'mata_pelajaran' => $mataPelajaran,
                    'guru_id' => $guru->id,
                    'kelas' => $kelas,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai . ':00',
                    'jam_selesai' => $jamSelesai . ':00',
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                    'ruang' => $ruang ?: 'Ruang ' . $kelas,
                    'status' => 'aktif',
                    'is_berulang' => true,
                    'created_by' => 1, // Admin
                ]);
                
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                $errors[] = "Baris $rowNumber: " . $e->getMessage();
            }
        }
        
        $message = "✅ Berhasil import $successCount jadwal!";
        if ($errorCount > 0) {
            $message .= "<br>⚠️ $errorCount data gagal:<br>" . implode('<br>', array_slice($errors, 0, 10));
        }
        
    } catch (\Exception $e) {
        $message = "❌ Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Jadwal Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-file-import me-2"></i>
                            Import Jadwal Simple
                        </h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($message)): ?>
                            <div class="alert alert-<?= $errorCount > 0 ? 'warning' : 'success' ?> alert-dismissible fade show">
                                <?= $message ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Panduan:</h6>
                            <ol class="mb-0">
                                <li>File Excel harus punya header di baris 1</li>
                                <li>Kolom: mata_pelajaran | guru | kelas | hari | jam_mulai | jam_selesai | ruang</li>
                                <li>Nama guru harus mirip dengan database</li>
                                <li>Hari: senin, selasa, rabu, kamis, jumat, sabtu</li>
                                <li>Waktu: HH:MM (contoh: 07:00, 08:15)</li>
                            </ol>
                        </div>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Semester</label>
                                <select name="semester" class="form-select" required>
                                    <option value="all">Seluruhnya</option>
                                    <option value="1" selected>Semester 1</option>
                                    <option value="2">Semester 2</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran" class="form-control" 
                                       value="2025/2026" placeholder="2025/2026" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Upload File Excel</label>
                                <input type="file" name="excel_file" class="form-control" 
                                       accept=".xlsx,.xls" required>
                                <small class="text-muted">Format: .xlsx atau .xls</small>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-upload me-2"></i>
                                    Import Jadwal
                                </button>
                                <a href="/nurani/public/tu/jadwal" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Jadwal
                                </a>
                            </div>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Catatan:</h6>
                            <p class="mb-0">
                                Ini adalah script alternatif untuk import jadwal. 
                                Setelah Railway deploy selesai, gunakan fitur import di dashboard TU yang lebih lengkap.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
