<?php

namespace App\Imports;

use App\Models\Jadwal;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class JadwalImport implements ToModel, WithHeadingRow
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
            // Ambil data dengan berbagai kemungkinan nama kolom
            $mataPelajaran = $this->getColumnValue($row, ['mata_pelajaran', 'mapel', 'pelajaran', 'subject']);
            $namaGuru = $this->getColumnValue($row, ['guru', 'nama_guru', 'teacher', 'pengajar']);
            $kelas = $this->getColumnValue($row, ['kelas', 'class', 'tingkat']);
            $hari = $this->getColumnValue($row, ['hari', 'day']);
            $jamMulai = $this->getColumnValue($row, ['jam_mulai', 'waktu_mulai', 'start_time', 'mulai']);
            $jamSelesai = $this->getColumnValue($row, ['jam_selesai', 'waktu_selesai', 'end_time', 'selesai']);
            $ruang = $this->getColumnValue($row, ['ruang', 'room', 'kelas_ruang']);

            // Skip jika data penting kosong
            if (empty($mataPelajaran) || empty($namaGuru) || empty($kelas)) {
                return null;
            }

            // Cari guru dengan pencarian fleksibel
            $guru = $this->findGuru($namaGuru);

            if (!$guru) {
                $this->errorCount++;
                $this->errors[] = "Baris " . ($this->successCount + $this->errorCount + 1) . ": Guru '{$namaGuru}' tidak ditemukan";
                Log::warning("Guru tidak ditemukan: " . $namaGuru);
                return null;
            }

            // Validasi dan normalisasi hari
            $hari = $this->normalizeHari($hari);
            if (!$hari) {
                $this->errorCount++;
                $this->errors[] = "Baris " . ($this->successCount + $this->errorCount + 1) . ": Hari tidak valid";
                return null;
            }

            // Parse waktu dengan berbagai format
            $jamMulai = $this->parseTime($jamMulai);
            $jamSelesai = $this->parseTime($jamSelesai);

            if (!$jamMulai || !$jamSelesai) {
                $this->errorCount++;
                $this->errors[] = "Baris " . ($this->successCount + $this->errorCount + 1) . ": Format waktu tidak valid";
                return null;
            }

            // Normalisasi mata pelajaran
            $mataPelajaran = $this->normalizeMataPelajaran($mataPelajaran);

            $this->successCount++;

            return new Jadwal([
                'mata_pelajaran' => $mataPelajaran,
                'guru_id' => $guru->id,
                'kelas' => trim($kelas),
                'hari' => $hari,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'semester' => $this->semester,
                'tahun_ajaran' => $this->tahunAjaran,
                'ruang' => $ruang ?: 'Ruang ' . trim($kelas),
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

    protected function getColumnValue($row, $possibleNames)
    {
        foreach ($possibleNames as $name) {
            if (isset($row[$name]) && !empty($row[$name])) {
                return $row[$name];
            }
        }
        return null;
    }

    protected function findGuru($namaGuru)
    {
        $namaGuru = trim($namaGuru);
        
        // Cari exact match dulu
        $guru = Guru::whereHas('user', function($query) use ($namaGuru) {
            $query->where('name', $namaGuru);
        })->first();

        if ($guru) return $guru;

        // Cari dengan LIKE
        $guru = Guru::whereHas('user', function($query) use ($namaGuru) {
            $query->where('name', 'LIKE', '%' . $namaGuru . '%');
        })->first();

        if ($guru) return $guru;

        // Cari tanpa gelar
        $namaTanpaGelar = preg_replace('/,?\s*(S\.Pd|A\.K\.S|M\.Pd|S\.Ag|S\.Pd\.I)/i', '', $namaGuru);
        $guru = Guru::whereHas('user', function($query) use ($namaTanpaGelar) {
            $query->where('name', 'LIKE', '%' . $namaTanpaGelar . '%');
        })->first();

        return $guru;
    }

    protected function normalizeHari($hari)
    {
        $hari = strtolower(trim($hari));
        
        $hariMap = [
            'senin' => 'senin', 'sen' => 'senin', 'monday' => 'senin',
            'selasa' => 'selasa', 'sel' => 'selasa', 'tuesday' => 'selasa',
            'rabu' => 'rabu', 'rab' => 'rabu', 'wednesday' => 'rabu',
            'kamis' => 'kamis', 'kam' => 'kamis', 'thursday' => 'kamis',
            'jumat' => 'jumat', 'jum' => 'jumat', 'friday' => 'jumat',
            'sabtu' => 'sabtu', 'sab' => 'sabtu', 'saturday' => 'sabtu',
        ];

        return $hariMap[$hari] ?? null;
    }

    protected function normalizeMataPelajaran($mapel)
    {
        $mapel = strtolower(trim($mapel));
        $mapel = str_replace([' ', '.'], '_', $mapel);
        return $mapel;
    }

    protected function parseTime($time)
    {
        try {
            $time = trim($time);
            
            // Jika sudah format HH:MM:SS
            if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
                return $time;
            }

            // Jika format HH:MM
            if (preg_match('/^\d{1,2}:\d{2}$/', $time)) {
                $parts = explode(':', $time);
                return sprintf('%02d:%02d:00', $parts[0], $parts[1]);
            }

            // Jika format HH.MM (dengan titik)
            if (preg_match('/^\d{1,2}\.\d{2}$/', $time)) {
                $parts = explode('.', $time);
                return sprintf('%02d:%02d:00', $parts[0], $parts[1]);
            }

            // Jika format HHMM (tanpa separator)
            if (preg_match('/^\d{3,4}$/', $time)) {
                $time = str_pad($time, 4, '0', STR_PAD_LEFT);
                $hours = substr($time, 0, 2);
                $minutes = substr($time, 2, 2);
                return sprintf('%02d:%02d:00', $hours, $minutes);
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
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
