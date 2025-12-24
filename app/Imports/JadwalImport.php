<?php

namespace App\Imports;

use App\Models\Jadwal;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class JadwalImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $semester;
    protected $tahunAjaran;
    protected $createdBy;
    protected $successCount = 0;
    protected $errorCount = 0;
    protected $errors = [];

    public function __construct($semester, $tahunAjaran, $createdBy)
    {
        $this->semester = $semester;
        $this->tahunAjaran = $tahunAjaran;
        $this->createdBy = $createdBy;
    }

    public function model(array $row)
    {
        try {
            // Skip jika row kosong
            if (empty($row['mata_pelajaran']) || empty($row['guru']) || empty($row['kelas'])) {
                return null;
            }

            // Cari guru berdasarkan nama
            $guru = Guru::whereHas('user', function($query) use ($row) {
                $query->where('name', 'LIKE', '%' . trim($row['guru']) . '%');
            })->first();

            if (!$guru) {
                $this->errorCount++;
                $this->errors[] = "Baris " . ($this->successCount + $this->errorCount + 1) . ": Guru '{$row['guru']}' tidak ditemukan";
                Log::warning("Guru tidak ditemukan: " . $row['guru']);
                return null;
            }

            // Validasi hari
            $hariValid = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            $hari = strtolower(trim($row['hari']));
            if (!in_array($hari, $hariValid)) {
                $this->errorCount++;
                $this->errors[] = "Baris " . ($this->successCount + $this->errorCount + 1) . ": Hari '{$row['hari']}' tidak valid";
                return null;
            }

            // Parse waktu
            $jamMulai = $this->parseTime($row['jam_mulai']);
            $jamSelesai = $this->parseTime($row['jam_selesai']);

            if (!$jamMulai || !$jamSelesai) {
                $this->errorCount++;
                $this->errors[] = "Baris " . ($this->successCount + $this->errorCount + 1) . ": Format waktu tidak valid";
                return null;
            }

            $this->successCount++;

            return new Jadwal([
                'mata_pelajaran' => strtolower(str_replace(' ', '_', trim($row['mata_pelajaran']))),
                'guru_id' => $guru->id,
                'kelas' => trim($row['kelas']),
                'hari' => $hari,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'semester' => $this->semester,
                'tahun_ajaran' => $this->tahunAjaran,
                'ruang' => $row['ruang'] ?? 'Ruang ' . trim($row['kelas']),
                'status' => 'aktif',
                'is_berulang' => true,
                'created_by' => $this->createdBy,
            ]);

        } catch (\Exception $e) {
            $this->errorCount++;
            $this->errors[] = "Baris " . ($this->successCount + $this->errorCount + 1) . ": " . $e->getMessage();
            Log::error("Error importing jadwal: " . $e->getMessage());
            return null;
        }
    }

    protected function parseTime($time)
    {
        try {
            // Jika sudah format HH:MM:SS
            if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
                return $time;
            }

            // Jika format HH:MM
            if (preg_match('/^\d{2}:\d{2}$/', $time)) {
                return $time . ':00';
            }

            // Jika format H:MM atau HH:M
            if (preg_match('/^\d{1,2}:\d{1,2}$/', $time)) {
                $parts = explode(':', $time);
                return sprintf('%02d:%02d:00', $parts[0], $parts[1]);
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'mata_pelajaran' => 'required|string',
            'guru' => 'required|string',
            'kelas' => 'required',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ];
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
