<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kuis;
use App\Models\Guru;

class KuisMataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all gurus
        $gurus = Guru::all();

        foreach ($gurus as $guru) {
            $mataPelajaran = explode(',', $guru->mata_pelajaran);
            
            foreach ($mataPelajaran as $mp) {
                $mp = trim($mp);
                
                // Create quizzes based on subject
                switch ($mp) {
                    case 'IPA':
                        $this->createIPAQuizzes($guru, $mp);
                        break;
                    case 'Prakarya':
                        $this->createPrakaryaQuizzes($guru, $mp);
                        break;
                    case 'Basa Sunda':
                        $this->createBasaSundaQuizzes($guru, $mp);
                        break;
                    case 'Matematika':
                        $this->createMatematikaQuizzes($guru, $mp);
                        break;
                    case 'Bahasa Indonesia':
                        $this->createBahasaIndonesiaQuizzes($guru, $mp);
                        break;
                    case 'Bahasa Inggris':
                        $this->createBahasaInggrisQuizzes($guru, $mp);
                        break;
                    case 'IPS':
                        $this->createIPSQuizzes($guru, $mp);
                        break;
                    case 'PKN':
                        $this->createPKNQuizzes($guru, $mp);
                        break;
                    case 'Seni Budaya':
                        $this->createSeniBudayaQuizzes($guru, $mp);
                        break;
                    case 'PJOK':
                        $this->createPJOKQuizzes($guru, $mp);
                        break;
                }
            }
        }
    }

    private function createIPAQuizzes($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Sistem Pernapasan
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Sistem Pernapasan Manusia',
            'deskripsi' => 'Kuis tentang sistem pernapasan manusia untuk kelas VIII',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 30,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Organ pernapasan utama pada manusia adalah...',
                    'pilihan' => [
                        'A' => 'Paru-paru',
                        'B' => 'Jantung',
                        'C' => 'Hati',
                        'D' => 'Ginjal'
                    ],
                    'jawaban_benar' => 'A'
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'Proses pertukaran oksigen dan karbon dioksida terjadi di...',
                    'pilihan' => [
                        'A' => 'Alveoli',
                        'B' => 'Bronkus',
                        'C' => 'Trakea',
                        'D' => 'Laring'
                    ],
                    'jawaban_benar' => 'A'
                ],
                [
                    'nomor' => 3,
                    'pertanyaan' => 'Diafragma berfungsi untuk...',
                    'pilihan' => [
                        'A' => 'Mengatur suhu tubuh',
                        'B' => 'Membantu proses pernapasan',
                        'C' => 'Menyaring udara',
                        'D' => 'Mengatur tekanan darah'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ])
        ]);

        // Esai - Sistem Pencernaan
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Esai Sistem Pencernaan Manusia',
            'deskripsi' => 'Kuis esai tentang sistem pencernaan manusia',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'esai',
            'durasi_menit' => 45,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([]),
            'esai_soal' => 'Jelaskan proses pencernaan makanan dari mulut hingga usus halus! Sebutkan enzim-enzim yang terlibat dan fungsinya masing-masing.',
            'esai_petunjuk' => 'Jawablah dengan lengkap dan terstruktur. Minimal 3 paragraf dengan penjelasan yang detail.'
        ]);
    }

    private function createPrakaryaQuizzes($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Kerajinan Tangan
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Kerajinan dari Bahan Alam',
            'deskripsi' => 'Kuis tentang kerajinan tangan dari bahan alam',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 25,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Bahan alam yang cocok untuk membuat kerajinan anyaman adalah...',
                    'pilihan' => [
                        'A' => 'Plastik',
                        'B' => 'Bambu',
                        'C' => 'Kaca',
                        'D' => 'Logam'
                    ],
                    'jawaban_benar' => 'B'
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'Teknik dasar dalam membuat kerajinan anyaman adalah...',
                    'pilihan' => [
                        'A' => 'Menggambar',
                        'B' => 'Menyilang',
                        'C' => 'Mengecat',
                        'D' => 'Mengukir'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ])
        ]);

        // Esai - Kreativitas Kerajinan
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Esai Kreativitas Kerajinan',
            'deskripsi' => 'Kuis esai tentang kreativitas dalam membuat kerajinan',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'esai',
            'durasi_menit' => 40,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([]),
            'esai_soal' => 'Buatlah rancangan kerajinan tangan dari bahan alam yang ada di sekitar rumah Anda. Jelaskan bahan yang digunakan, alat yang diperlukan, dan langkah-langkah pembuatannya!',
            'esai_petunjuk' => 'Gunakan imajinasi dan kreativitas Anda. Jelaskan dengan detail dan sistematis.'
        ]);
    }

    private function createBasaSundaQuizzes($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Kosakata Basa Sunda
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Kosakata Basa Sunda',
            'deskripsi' => 'Kuis tentang kosakata dasar bahasa Sunda',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 20,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Kata "batur" dalam bahasa Sunda berarti...',
                    'pilihan' => [
                        'A' => 'Teman',
                        'B' => 'Kakak',
                        'C' => 'Adik',
                        'D' => 'Orang tua'
                    ],
                    'jawaban_benar' => 'A'
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'Kata "sare" dalam bahasa Sunda berarti...',
                    'pilihan' => [
                        'A' => 'Makan',
                        'B' => 'Tidur',
                        'C' => 'Minum',
                        'D' => 'Bermain'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ])
        ]);

        // Esai - Dialog Basa Sunda
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Esai Dialog Basa Sunda',
            'deskripsi' => 'Kuis esai tentang dialog dalam bahasa Sunda',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'esai',
            'durasi_menit' => 35,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([]),
            'esai_soal' => 'Buatlah dialog singkat dalam bahasa Sunda antara dua orang yang sedang berkenalan. Gunakan kosakata yang sopan dan sesuai dengan budaya Sunda!',
            'esai_petunjuk' => 'Gunakan bahasa Sunda yang benar dan sopan. Minimal 4-5 kalimat untuk setiap orang.'
        ]);
    }

    private function createMatematikaQuizzes($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Aljabar
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Aljabar Dasar',
            'deskripsi' => 'Kuis tentang aljabar dasar untuk kelas VIII',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 30,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Nilai dari 2x + 3 jika x = 4 adalah...',
                    'pilihan' => [
                        'A' => '11',
                        'B' => '12',
                        'C' => '13',
                        'D' => '14'
                    ],
                    'jawaban_benar' => 'A'
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'Penyelesaian dari 3x - 5 = 7 adalah...',
                    'pilihan' => [
                        'A' => 'x = 2',
                        'B' => 'x = 3',
                        'C' => 'x = 4',
                        'D' => 'x = 5'
                    ],
                    'jawaban_benar' => 'C'
                ]
            ])
        ]);
    }

    private function createBahasaIndonesiaQuizzes($guru, $mataPelajaran)
    {
        // Esai - Puisi
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Esai Analisis Puisi',
            'deskripsi' => 'Kuis esai tentang analisis puisi',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'esai',
            'durasi_menit' => 50,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([]),
            'esai_soal' => 'Analisislah puisi "Aku" karya Chairil Anwar! Jelaskan tema, amanat, dan gaya bahasa yang digunakan dalam puisi tersebut.',
            'esai_petunjuk' => 'Berikan analisis yang mendalam dan terstruktur. Minimal 4 paragraf dengan penjelasan yang detail.'
        ]);
    }

    private function createBahasaInggrisQuizzes($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Grammar
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Grammar Bahasa Inggris',
            'deskripsi' => 'Kuis tentang grammar dasar bahasa Inggris',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 25,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Choose the correct form: "I _____ to school every day."',
                    'pilihan' => [
                        'A' => 'go',
                        'B' => 'goes',
                        'C' => 'going',
                        'D' => 'went'
                    ],
                    'jawaban_benar' => 'A'
                ]
            ])
        ]);
    }

    private function createIPSQuizzes($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Sejarah
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Sejarah Indonesia',
            'deskripsi' => 'Kuis tentang sejarah Indonesia',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 30,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Proklamasi Kemerdekaan Indonesia dilaksanakan pada tanggal...',
                    'pilihan' => [
                        'A' => '16 Agustus 1945',
                        'B' => '17 Agustus 1945',
                        'C' => '18 Agustus 1945',
                        'D' => '19 Agustus 1945'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ])
        ]);
    }

    private function createPKNQuizzes($guru, $mataPelajaran)
    {
        // Esai - Pancasila
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Esai Pancasila',
            'deskripsi' => 'Kuis esai tentang Pancasila',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'esai',
            'durasi_menit' => 45,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([]),
            'esai_soal' => 'Jelaskan makna dari sila pertama Pancasila "Ketuhanan Yang Maha Esa" dan berikan contoh penerapannya dalam kehidupan sehari-hari!',
            'esai_petunjuk' => 'Jawablah dengan pemahaman yang mendalam tentang nilai-nilai Pancasila.'
        ]);
    }

    private function createSeniBudayaQuizzes($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Seni Rupa
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Seni Rupa',
            'deskripsi' => 'Kuis tentang seni rupa',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 20,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Warna primer terdiri dari...',
                    'pilihan' => [
                        'A' => 'Merah, kuning, biru',
                        'B' => 'Merah, hijau, biru',
                        'C' => 'Kuning, hijau, ungu',
                        'D' => 'Merah, kuning, hijau'
                    ],
                    'jawaban_benar' => 'A'
                ]
            ])
        ]);
    }

    private function createPJOKQuizzes($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Olahraga
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Olahraga',
            'deskripsi' => 'Kuis tentang olahraga dan kesehatan',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 25,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Pemanasan sebelum olahraga bertujuan untuk...',
                    'pilihan' => [
                        'A' => 'Mencegah cedera',
                        'B' => 'Membuat lelah',
                        'C' => 'Mengurangi performa',
                        'D' => 'Membuat sakit'
                    ],
                    'jawaban_benar' => 'A'
                ]
            ])
        ]);
    }
}