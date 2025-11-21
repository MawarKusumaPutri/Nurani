<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuis;
use App\Models\Guru;

class ValidVideoKuisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find Siti Mundari's guru record
        $guru = Guru::whereHas('user', function($query) {
            $query->where('email', 'sitimundari54@gmail.com');
        })->first();

        if (!$guru) {
            $this->command->error('Guru Siti Mundari not found');
            return;
        }

        // Valid YouTube video URLs for testing
        $validVideos = [
            [
                'judul' => 'Kuis Video IPA - Sistem Pencernaan Manusia',
                'deskripsi' => 'Tonton video tentang sistem pencernaan manusia dan jawab pertanyaan yang diberikan',
                'kelas' => 'VIII',
                'mata_pelajaran' => 'IPA',
                'tipe_kuis' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=M7lc1UVf-VE', // Educational video
                'video_title' => 'Pembelajaran Sistem Pencernaan Manusia',
                'video_thumbnail' => 'https://img.youtube.com/vi/M7lc1UVf-VE/mqdefault.jpg',
                'video_soal' => 'Setelah menonton video tentang sistem pencernaan manusia, jawablah pertanyaan berikut:

1. Sebutkan organ-organ yang terlibat dalam sistem pencernaan manusia!
2. Jelaskan fungsi dari setiap organ pencernaan yang disebutkan!
3. Apa yang terjadi pada makanan di dalam lambung?
4. Mengapa usus halus memiliki struktur yang berlipat-lipat?
5. Bagaimana proses penyerapan nutrisi terjadi di usus halus?

Jawablah pertanyaan di atas dengan lengkap dan jelas berdasarkan video yang telah Anda tonton.',
                'durasi_menit' => 45,
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(7),
                'is_active' => true
            ],
            [
                'judul' => 'Kuis Video IPA - Sistem Pernapasan',
                'deskripsi' => 'Video pembelajaran tentang sistem pernapasan manusia',
                'kelas' => 'VIII',
                'mata_pelajaran' => 'IPA',
                'tipe_kuis' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw', // Another valid video
                'video_title' => 'Sistem Pernapasan Manusia',
                'video_thumbnail' => 'https://img.youtube.com/vi/jNQXAC9IVRw/mqdefault.jpg',
                'video_soal' => 'Berdasarkan video yang telah Anda tonton, jelaskan proses pernapasan manusia!',
                'durasi_menit' => 30,
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(7),
                'is_active' => true
            ]
        ];

        foreach ($validVideos as $videoData) {
            $videoData['guru_id'] = $guru->id;
            $videoData['soal'] = json_encode([]); // Empty array for video quizzes
            
            Kuis::updateOrCreate(
                [
                    'guru_id' => $guru->id,
                    'judul' => $videoData['judul']
                ],
                $videoData
            );
        }

        $this->command->info('Valid video quizzes created successfully!');
    }
}