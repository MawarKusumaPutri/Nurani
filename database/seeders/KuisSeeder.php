<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuis;
use App\Models\Guru;

class KuisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil guru Siti Mundari
        $guru = Guru::whereHas('user', function($query) {
            $query->where('email', 'siti.mundari@mtssnuraiman.sch.id');
        })->first();

        if (!$guru) {
            $this->command->info('Guru Siti Mundari tidak ditemukan. Pastikan UserSeeder sudah dijalankan.');
            return;
        }

        // Kuis IPA
        $kuisIPA = Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis IPA - Sistem Pencernaan Manusia',
            'deskripsi' => 'Kuis tentang sistem pencernaan manusia untuk kelas VIII',
            'kelas' => 'VIII',
            'mata_pelajaran' => 'IPA',
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Organ manakah yang berfungsi sebagai tempat penyerapan sari-sari makanan?',
                    'pilihan' => [
                        'A' => 'Lambung',
                        'B' => 'Usus halus',
                        'C' => 'Usus besar',
                        'D' => 'Hati'
                    ],
                    'jawaban_benar' => 'B'
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'Enzim apakah yang dihasilkan oleh lambung untuk mencerna protein?',
                    'pilihan' => [
                        'A' => 'Amilase',
                        'B' => 'Pepsin',
                        'C' => 'Lipase',
                        'D' => 'Tripsin'
                    ],
                    'jawaban_benar' => 'B'
                ],
                [
                    'nomor' => 3,
                    'pertanyaan' => 'Organ manakah yang menghasilkan empedu?',
                    'pilihan' => [
                        'A' => 'Pankreas',
                        'B' => 'Hati',
                        'C' => 'Lambung',
                        'D' => 'Usus halus'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ]),
            'durasi_menit' => 30,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true
        ]);

        // Kuis Prakarya
        $kuisPrakarya = Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Prakarya - Kerajinan dari Bahan Limbah',
            'deskripsi' => 'Kuis tentang kerajinan dari bahan limbah untuk kelas VII',
            'kelas' => 'VII',
            'mata_pelajaran' => 'Prakarya',
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Bahan limbah organik manakah yang dapat digunakan untuk membuat kerajinan?',
                    'pilihan' => [
                        'A' => 'Botol plastik',
                        'B' => 'Kulit jagung',
                        'C' => 'Kaleng bekas',
                        'D' => 'Kardus'
                    ],
                    'jawaban_benar' => 'B'
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'Teknik apakah yang digunakan untuk membuat kerajinan dari kulit jagung?',
                    'pilihan' => [
                        'A' => 'Teknik anyam',
                        'B' => 'Teknik tempel',
                        'C' => 'Teknik lipat',
                        'D' => 'Teknik jahit'
                    ],
                    'jawaban_benar' => 'A'
                ],
                [
                    'nomor' => 3,
                    'pertanyaan' => 'Apa keuntungan menggunakan bahan limbah untuk kerajinan?',
                    'pilihan' => [
                        'A' => 'Murah dan mudah didapat',
                        'B' => 'Mengurangi pencemaran lingkungan',
                        'C' => 'Meningkatkan kreativitas',
                        'D' => 'Semua benar'
                    ],
                    'jawaban_benar' => 'D'
                ]
            ]),
            'durasi_menit' => 25,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(5),
            'is_active' => true
        ]);

        // Kuis Basa Sunda
        $kuisBasaSunda = Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Basa Sunda - Kecap Tembung',
            'deskripsi' => 'Kuis tentang kecap tembung dalam bahasa Sunda untuk kelas IX',
            'kelas' => 'IX',
            'mata_pelajaran' => 'Basa Sunda',
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Naon hartina kecap "sarebu" dina basa Sunda?',
                    'pilihan' => [
                        'A' => 'Saribu',
                        'B' => 'Sarebu',
                        'C' => 'Sarebu',
                        'D' => 'Sarebu'
                    ],
                    'jawaban_benar' => 'A'
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'Kecap "ngalantung" hartina...',
                    'pilihan' => [
                        'A' => 'Ngalantung',
                        'B' => 'Ngalantung',
                        'C' => 'Ngalantung',
                        'D' => 'Ngalantung'
                    ],
                    'jawaban_benar' => 'A'
                ],
                [
                    'nomor' => 3,
                    'pertanyaan' => 'Tembung "ngalantung" kaasup kana golongan...',
                    'pilihan' => [
                        'A' => 'Kecap barang',
                        'B' => 'Kecap pagawéan',
                        'C' => 'Kecap sipat',
                        'D' => 'Kecap bilangan'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ]),
            'durasi_menit' => 20,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(3),
            'is_active' => true
        ]);

        $this->command->info('Kuis untuk Siti Mundari berhasil dibuat:');
        $this->command->info('- Kuis IPA: ' . $kuisIPA->judul);
        $this->command->info('- Kuis Prakarya: ' . $kuisPrakarya->judul);
        $this->command->info('- Kuis Basa Sunda: ' . $kuisBasaSunda->judul);
    }
}