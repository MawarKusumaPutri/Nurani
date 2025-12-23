<?php

namespace App\Imports;

use App\Models\Jadwal;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class JadwalImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $createdBy;
    protected $semester;
    protected $tahunAjaran;
    
    public function __construct($createdBy, $semester = null, $tahunAjaran = null)
    {
        $this->createdBy = $createdBy;
        $this->semester = $semester ?? '1';
        $this->tahunAjaran = $tahunAjaran ?? '2025/2026';
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            // Skip empty rows
            if (empty($row['mata_pelajaran']) || empty($row['nama_guru'])) {
                return null;
            }

            // Find guru by name
            $guru = Guru::whereHas('user', function($query) use ($row) {
                $query->where('name', 'LIKE', '%' . trim($row['nama_guru']) . '%');
            })->first();

            if (!$guru) {
                Log::warning('Guru not found: ' . $row['nama_guru']);
                return null;
            }

            // Parse hari (day of week)
            $hari = $this->parseHari($row['hari'] ?? '');
            if (!$hari) {
                Log::warning('Invalid hari: ' . ($row['hari'] ?? 'empty'));
                return null;
            }

            // Parse waktu (time)
            $waktu = $this->parseWaktu($row['waktu'] ?? '');
            if (!$waktu) {
                Log::warning('Invalid waktu: ' . ($row['waktu'] ?? 'empty'));
                return null;
            }

            // Parse kelas
            $kelas = $this->parseKelas($row['kelas'] ?? '');
            if (!$kelas) {
                Log::warning('Invalid kelas: ' . ($row['kelas'] ?? 'empty'));
                return null;
            }

            // Parse mata pelajaran
            $mataPelajaran = $this->parseMataPelajaran($row['mata_pelajaran'] ?? '');

            // Parse ruang
            $ruang = $row['ruang'] ?? null;
            $isLab = false;
            $isLapangan = false;

            if ($ruang) {
                $ruangLower = strtolower($ruang);
                if (strpos($ruangLower, 'lab') !== false) {
                    $isLab = true;
                } elseif (strpos($ruangLower, 'lapangan') !== false) {
                    $isLapangan = true;
                }
            }

            return new Jadwal([
                'mata_pelajaran' => $mataPelajaran,
                'guru_id' => $guru->id,
                'kelas' => $kelas,
                'hari' => $hari,
                'tanggal' => null,
                'jam_mulai' => $waktu['mulai'],
                'jam_selesai' => $waktu['selesai'],
                'semester' => $this->semester,
                'tahun_ajaran' => $this->tahunAjaran,
                'status' => 'aktif',
                'keterangan' => $row['keterangan'] ?? null,
                'is_berulang' => true,
                'is_lab' => $isLab,
                'is_lapangan' => $isLapangan,
                'ruang' => $ruang,
                'created_by' => $this->createdBy,
            ]);
        } catch (\Exception $e) {
            Log::error('Error importing jadwal row: ' . $e->getMessage(), ['row' => $row]);
            return null;
        }
    }

    /**
     * Parse hari from various formats
     */
    private function parseHari($hari)
    {
        $hariMap = [
            'senin' => 'senin',
            'selasa' => 'selasa',
            'rabu' => 'rabu',
            'kamis' => 'kamis',
            'jumat' => 'jumat',
            'sabtu' => 'sabtu',
            'minggu' => 'minggu',
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu',
        ];

        $hariLower = strtolower(trim($hari));
        return $hariMap[$hariLower] ?? null;
    }

    /**
     * Parse waktu from format "08:00 - 09:30" or "08:00-09:30"
     */
    private function parseWaktu($waktu)
    {
        // Remove spaces and split by dash
        $waktu = str_replace(' ', '', $waktu);
        $parts = preg_split('/[-–—]/', $waktu);

        if (count($parts) !== 2) {
            return null;
        }

        try {
            $mulai = Carbon::createFromFormat('H:i', trim($parts[0]))->format('H:i:s');
            $selesai = Carbon::createFromFormat('H:i', trim($parts[1]))->format('H:i:s');

            return [
                'mulai' => $mulai,
                'selesai' => $selesai,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parse kelas from various formats
     */
    private function parseKelas($kelas)
    {
        // Extract number and letter from formats like "7A", "7 A", "Kelas 7A", etc.
        $kelas = strtoupper(trim($kelas));
        $kelas = str_replace(['KELAS', 'CLASS'], '', $kelas);
        $kelas = trim($kelas);
        
        // Remove spaces between number and letter
        $kelas = preg_replace('/\s+/', '', $kelas);
        
        return $kelas;
    }

    /**
     * Parse mata pelajaran to match database format
     */
    private function parseMataPelajaran($mataPelajaran)
    {
        $mataPelajaran = strtolower(trim($mataPelajaran));
        
        $mapelMap = [
            'matematika' => 'matematika',
            'mtk' => 'matematika',
            'bahasa indonesia' => 'bahasa_indonesia',
            'b. indonesia' => 'bahasa_indonesia',
            'bahasa inggris' => 'bahasa_inggris',
            'b. inggris' => 'bahasa_inggris',
            'english' => 'bahasa_inggris',
            'ipa' => 'ipa',
            'sains' => 'ipa',
            'ips' => 'ips',
            'pendidikan agama' => 'pendidikan_agama',
            'agama' => 'pendidikan_agama',
            'pai' => 'pendidikan_agama',
            'pendidikan kewarganegaraan' => 'pendidikan_kewarganegaraan',
            'pkn' => 'pendidikan_kewarganegaraan',
            'ppkn' => 'pendidikan_kewarganegaraan',
            'pendidikan jasmani' => 'pendidikan_jasmani',
            'pjok' => 'pendidikan_jasmani',
            'penjas' => 'pendidikan_jasmani',
            'seni budaya' => 'seni_budaya',
            'seni' => 'seni_budaya',
            'teknologi informasi' => 'teknologi_informasi',
            'tik' => 'teknologi_informasi',
            'informatika' => 'teknologi_informasi',
        ];

        return $mapelMap[$mataPelajaran] ?? 'lainnya';
    }

    public function rules(): array
    {
        return [
            'mata_pelajaran' => 'required',
            'nama_guru' => 'required',
            'kelas' => 'required',
            'hari' => 'required',
            'waktu' => 'required',
        ];
    }
}
