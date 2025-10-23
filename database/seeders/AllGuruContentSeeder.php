<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\Rangkuman;
use App\Models\Guru;

class AllGuruContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all gurus
        $gurus = Guru::all();

        foreach ($gurus as $guru) {
            $mataPelajaran = explode(', ', $guru->mata_pelajaran);
            
            foreach ($mataPelajaran as $mp) {
                $mp = trim($mp);
                
                // Create content based on subject
                $this->createContentForSubject($guru, $mp);
            }
        }
    }

    private function createContentForSubject($guru, $mataPelajaran)
    {
        // Create kuis based on subject
        $this->createKuisForSubject($guru, $mataPelajaran);
        
        // Create materi based on subject
        $this->createMateriForSubject($guru, $mataPelajaran);
        
        // Create rangkuman based on subject
        $this->createRangkumanForSubject($guru, $mataPelajaran);
    }

    private function createKuisForSubject($guru, $mataPelajaran)
    {
        // Generate random dates within the last 3 months
        $randomDaysAgo = rand(1, 90);
        $tanggalMulai = now()->subDays($randomDaysAgo);
        $tanggalSelesai = $tanggalMulai->copy()->addDays(rand(3, 14));
        
        switch ($mataPelajaran) {
            case 'Matematika':
                $this->createMatematikaKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Bahasa Inggris':
                $this->createBahasaInggrisKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Bahasa Arab':
                $this->createBahasaArabKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'IPA':
                $this->createIPAKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Prakarya':
                $this->createPrakaryaKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Basa Sunda':
                $this->createBasaSundaKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'SKI':
                $this->createSKIKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Akidah Akhlak':
                $this->createAkidahAkhlakKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Bahasa Indonesia':
                $this->createBahasaIndonesiaKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Fiqih':
                $this->createFiqihKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Al-Qur\'an Hadist':
                $this->createAlQuranHadistKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Penjaskes':
                $this->createPenjaskesKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'IPS':
                $this->createIPSKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'PKN':
                $this->createPKNKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Seni Budaya':
                $this->createSeniBudayaKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
            case 'Tahsin':
                $this->createTahsinKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai);
                break;
        }
    }

    private function createMatematikaKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai)
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
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
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

        // Esai - Geometri
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Esai Geometri Bangun Datar',
            'deskripsi' => 'Kuis esai tentang geometri bangun datar',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'esai',
            'durasi_menit' => 45,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'is_active' => true,
            'soal' => json_encode([]),
            'esai_soal' => 'Hitunglah luas dan keliling persegi panjang dengan panjang 8 cm dan lebar 5 cm! Jelaskan langkah-langkah perhitungannya.',
            'esai_petunjuk' => 'Jawablah dengan langkah-langkah yang jelas dan sistematis.'
        ]);
    }

    private function createBahasaInggrisKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai)
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
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
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
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'What is the past tense of "eat"?',
                    'pilihan' => [
                        'A' => 'eated',
                        'B' => 'ate',
                        'C' => 'eaten',
                        'D' => 'eating'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ])
        ]);

        // Esai - Writing
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Esai Writing - My Daily Activities',
            'deskripsi' => 'Kuis esai tentang menulis aktivitas harian',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'esai',
            'durasi_menit' => 40,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'is_active' => true,
            'soal' => json_encode([]),
            'esai_soal' => 'Write a short paragraph about your daily activities. Use simple present tense and include at least 5 activities.',
            'esai_petunjuk' => 'Write in English with correct grammar and spelling. Minimum 5 sentences.'
        ]);
    }

    private function createBahasaArabKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai)
    {
        // Pilihan Ganda - Kosakata
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Kosakata Bahasa Arab',
            'deskripsi' => 'Kuis tentang kosakata dasar bahasa Arab',
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tipe_kuis' => 'pilihan_ganda',
            'durasi_menit' => 20,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'is_active' => true,
            'soal' => json_encode([
                [
                    'nomor' => 1,
                    'pertanyaan' => 'Apa arti dari kata "كتاب" dalam bahasa Indonesia?',
                    'pilihan' => [
                        'A' => 'Pena',
                        'B' => 'Buku',
                        'C' => 'Kertas',
                        'D' => 'Meja'
                    ],
                    'jawaban_benar' => 'B'
                ],
                [
                    'nomor' => 2,
                    'pertanyaan' => 'Kata "مدرسة" berarti...',
                    'pilihan' => [
                        'A' => 'Rumah',
                        'B' => 'Sekolah',
                        'C' => 'Masjid',
                        'D' => 'Kantor'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ])
        ]);
    }

    private function createIPAKuis($guru, $mataPelajaran, $tanggalMulai, $tanggalSelesai)
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
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
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
                ]
            ])
        ]);
    }

    private function createPrakaryaKuis($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Kerajinan
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
                ]
            ])
        ]);
    }

    private function createBasaSundaKuis($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Kosakata
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
                ]
            ])
        ]);
    }

    private function createSKIKuis($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Sejarah Islam
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Sejarah Kebudayaan Islam',
            'deskripsi' => 'Kuis tentang sejarah kebudayaan Islam',
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
                    'pertanyaan' => 'Nabi Muhammad SAW dilahirkan di kota...',
                    'pilihan' => [
                        'A' => 'Madinah',
                        'B' => 'Mekah',
                        'C' => 'Yatsrib',
                        'D' => 'Thaif'
                    ],
                    'jawaban_benar' => 'B'
                ]
            ])
        ]);
    }

    private function createAkidahAkhlakKuis($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Akidah
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Akidah Islam',
            'deskripsi' => 'Kuis tentang akidah dalam Islam',
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
                    'pertanyaan' => 'Rukun Iman yang pertama adalah...',
                    'pilihan' => [
                        'A' => 'Beriman kepada Allah',
                        'B' => 'Beriman kepada Malaikat',
                        'C' => 'Beriman kepada Rasul',
                        'D' => 'Beriman kepada Kitab'
                    ],
                    'jawaban_benar' => 'A'
                ]
            ])
        ]);
    }

    private function createBahasaIndonesiaKuis($guru, $mataPelajaran)
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

    private function createFiqihKuis($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Fiqih
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Fiqih Ibadah',
            'deskripsi' => 'Kuis tentang fiqih ibadah',
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
                    'pertanyaan' => 'Rukun shalat yang pertama adalah...',
                    'pilihan' => [
                        'A' => 'Takbiratul Ihram',
                        'B' => 'Ruku',
                        'C' => 'Sujud',
                        'D' => 'Duduk'
                    ],
                    'jawaban_benar' => 'A'
                ]
            ])
        ]);
    }

    private function createAlQuranHadistKuis($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Al-Qur'an
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Al-Qur\'an dan Hadist',
            'deskripsi' => 'Kuis tentang Al-Qur\'an dan Hadist',
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
                    'pertanyaan' => 'Al-Qur\'an diturunkan kepada Nabi Muhammad SAW selama...',
                    'pilihan' => [
                        'A' => '20 tahun',
                        'B' => '22 tahun',
                        'C' => '23 tahun',
                        'D' => '25 tahun'
                    ],
                    'jawaban_benar' => 'C'
                ]
            ])
        ]);
    }

    private function createPenjaskesKuis($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Olahraga
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Olahraga dan Kesehatan',
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

    private function createIPSKuis($guru, $mataPelajaran)
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

    private function createPKNKuis($guru, $mataPelajaran)
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

    private function createSeniBudayaKuis($guru, $mataPelajaran)
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

    private function createTahsinKuis($guru, $mataPelajaran)
    {
        // Pilihan Ganda - Tajwid
        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Tajwid Al-Qur\'an',
            'deskripsi' => 'Kuis tentang tajwid dalam membaca Al-Qur\'an',
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
                    'pertanyaan' => 'Hukum bacaan "Al" dalam "Al-Qur\'an" adalah...',
                    'pilihan' => [
                        'A' => 'Qamariyah',
                        'B' => 'Syamsiyah',
                        'C' => 'Idgham',
                        'D' => 'Ikhfa'
                    ],
                    'jawaban_benar' => 'A'
                ]
            ])
        ]);
    }

    private function createMateriForSubject($guru, $mataPelajaran)
    {
        // Generate random dates for materi
        $randomDaysAgo = rand(1, 60);
        $tanggalPublish = now()->subDays($randomDaysAgo);
        
        // Create sample materi for each subject
        Materi::create([
            'guru_id' => $guru->id,
            'judul' => 'Pengantar ' . $mataPelajaran,
            'deskripsi' => 'Materi pengantar untuk mata pelajaran ' . $mataPelajaran,
            'kelas' => 'VIII',
            'topik' => 'Pengantar ' . $mataPelajaran,
            'is_published' => true,
            'tanggal_publish' => $tanggalPublish,
            'konten' => 'Ini adalah materi pengantar untuk ' . $mataPelajaran . '. Silakan pelajari dengan baik.'
        ]);
    }

    private function createRangkumanForSubject($guru, $mataPelajaran)
    {
        // Generate random dates for rangkuman
        $randomDaysAgo = rand(1, 45);
        $tanggalPertemuan = now()->subDays($randomDaysAgo);
        $tanggalSelesai = $tanggalPertemuan->copy()->addHours(rand(1, 3));
        
        // Create sample rangkuman for each subject
        Rangkuman::create([
            'guru_id' => $guru->id,
            'kelas' => 'VIII',
            'mata_pelajaran' => $mataPelajaran,
            'tanggal_pertemuan' => $tanggalPertemuan,
            'materi_yang_diajarkan' => 'Materi pengantar ' . $mataPelajaran . ' telah diajarkan dengan baik. Siswa aktif mengikuti pembelajaran dan bertanya tentang materi yang diajarkan.',
            'capaian_pembelajaran' => 'Siswa dapat memahami konsep dasar ' . $mataPelajaran . ' dan mampu mengaplikasikannya dalam kehidupan sehari-hari.',
            'catatan_tambahan' => 'Siswa menunjukkan antusiasme yang baik dalam pembelajaran. Evaluasi dilakukan melalui tanya jawab dan latihan soal.',
            'is_complete' => true,
            'tanggal_selesai' => $tanggalSelesai
        ]);
    }
}