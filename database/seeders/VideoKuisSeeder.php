<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuis;
use App\Models\Guru;

class VideoKuisSeeder extends Seeder
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

        // Kuis Video IPA - Sistem Pencernaan
        $kuisVideoIPA = Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Video IPA - Sistem Pencernaan Manusia',
            'deskripsi' => 'Tonton video tentang sistem pencernaan manusia dan jawab pertanyaan yang diberikan',
            'kelas' => 'VIII',
            'mata_pelajaran' => 'IPA',
            'tipe_kuis' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=9QzC2OZt0-k', // Contoh video IPA
            'video_soal' => 'Setelah menonton video tentang sistem pencernaan manusia, jawablah pertanyaan berikut:

1. Sebutkan organ-organ yang terlibat dalam sistem pencernaan manusia!
2. Jelaskan fungsi dari setiap organ pencernaan yang disebutkan!
3. Apa yang terjadi pada makanan di dalam lambung?
4. Mengapa usus halus memiliki struktur yang berlipat-lipat?
5. Bagaimana proses penyerapan nutrisi terjadi di usus halus?

Jawablah pertanyaan di atas dengan lengkap dan jelas berdasarkan video yang telah Anda tonton.',
            'soal' => json_encode([]), // Empty array for video quiz
            'durasi_menit' => 45,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7),
            'is_active' => true
        ]);

        // Kuis Video Prakarya - Kerajinan dari Bahan Limbah
        $kuisVideoPrakarya = Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Video Prakarya - Kerajinan dari Bahan Limbah',
            'deskripsi' => 'Tonton video tutorial membuat kerajinan dari bahan limbah dan buat laporan',
            'kelas' => 'VII',
            'mata_pelajaran' => 'Prakarya',
            'tipe_kuis' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Contoh video prakarya
            'video_soal' => 'Berdasarkan video tutorial yang telah Anda tonton, lakukan hal berikut:

1. Pilih salah satu jenis kerajinan yang ditunjukkan dalam video
2. Siapkan bahan-bahan yang diperlukan
3. Buat kerajinan tersebut sesuai dengan tutorial
4. Dokumentasikan proses pembuatan dengan foto
5. Tuliskan langkah-langkah pembuatan yang telah Anda lakukan
6. Jelaskan kesulitan yang Anda hadapi dan cara mengatasinya
7. Evaluasi hasil kerajinan yang telah dibuat

Kirimkan foto proses dan hasil kerajinan beserta laporan tertulis.',
            'soal' => json_encode([]), // Empty array for video quiz
            'durasi_menit' => 60,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(10),
            'is_active' => true
        ]);

        // Kuis Video Basa Sunda - Budaya Sunda
        $kuisVideoBasaSunda = Kuis::create([
            'guru_id' => $guru->id,
            'judul' => 'Kuis Video Basa Sunda - Budaya dan Tradisi Sunda',
            'deskripsi' => 'Tonton video tentang budaya dan tradisi Sunda, kemudian jawab pertanyaan',
            'kelas' => 'IX',
            'mata_pelajaran' => 'Basa Sunda',
            'tipe_kuis' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw', // Contoh video budaya Sunda
            'video_soal' => 'Sanggeus nonton video ngeunaan budaya Sunda, jawabkeun patarosan di handap ieu:

1. Naon anu dimaksud ku "budaya Sunda" dina video éta?
2. Sebutkeun sababaraha tradisi Sunda anu dipidangkeun dina video!
3. Kumaha carana ngajaga budaya Sunda supaya tetep lestari?
4. Naon anu bisa dilakukeun ku generasi muda pikeun ngajaga warisan budaya Sunda?
5. Tuliskeun hiji paragraf ngeunaan pentingna ngajaga budaya Sunda dina basa Sunda!

Jawabkeun ku basa Sunda anu bener jeung jelas!',
            'soal' => json_encode([]), // Empty array for video quiz
            'durasi_menit' => 30,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(5),
            'is_active' => true
        ]);

        $this->command->info('Kuis Video untuk Siti Mundari berhasil dibuat:');
        $this->command->info('- Kuis Video IPA: ' . $kuisVideoIPA->judul);
        $this->command->info('- Kuis Video Prakarya: ' . $kuisVideoPrakarya->judul);
        $this->command->info('- Kuis Video Basa Sunda: ' . $kuisVideoBasaSunda->judul);
    }
}
