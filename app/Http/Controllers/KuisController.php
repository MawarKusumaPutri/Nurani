<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Kuis;
use Illuminate\Support\Facades\Auth;

class KuisController extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $kuis = $guru->kuis()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('guru.kuis.index', compact('guru', 'kuis'));
    }

    public function create()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        return view('guru.kuis.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'tipe_kuis' => 'required|in:pilihan_ganda,video',
            'durasi' => 'required|integer|min:5|max:180',
            'video_url' => 'required_if:tipe_kuis,video|nullable|url',
            'video_soal' => 'required_if:tipe_kuis,video|nullable|string',
            'soal' => 'required_if:tipe_kuis,pilihan_ganda|nullable|array|min:1',
            'soal.*.pertanyaan' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.pilihan_a' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.pilihan_b' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.pilihan_c' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.pilihan_d' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.jawaban_benar' => 'required_if:tipe_kuis,pilihan_ganda|nullable|in:A,B,C,D'
        ]);

        // Prepare data based on quiz type
        $kuisData = [
            'guru_id' => $guru->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'tipe_kuis' => $request->tipe_kuis,
            'durasi_menit' => $request->durasi,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(7), // Default 7 hari
            'is_active' => true
        ];

        if ($request->tipe_kuis === 'video') {
            // Handle video quiz
            $kuisData['video_url'] = $request->video_url;
            $kuisData['video_soal'] = $request->video_soal;
            $kuisData['soal'] = null; // No multiple choice questions for video quiz
        } else {
            // Handle multiple choice quiz
            $soalFormatted = [];
            if ($request->soal) {
                foreach ($request->soal as $index => $soal) {
                    $soalFormatted[] = [
                        'nomor' => $index + 1,
                        'pertanyaan' => $soal['pertanyaan'],
                        'pilihan' => [
                            'A' => $soal['pilihan_a'],
                            'B' => $soal['pilihan_b'],
                            'C' => $soal['pilihan_c'],
                            'D' => $soal['pilihan_d']
                        ],
                        'jawaban_benar' => $soal['jawaban_benar']
                    ];
                }
            }
            $kuisData['soal'] = json_encode($soalFormatted);
            $kuisData['video_url'] = null;
            $kuisData['video_soal'] = null;
        }

        Kuis::create($kuisData);

        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil dibuat');
    }

    public function show(Kuis $kuis)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $kuis->guru_id !== $guru->id) {
            return redirect()->route('guru.kuis.index')->with('error', 'Kuis tidak ditemukan');
        }

        return view('guru.kuis.show', compact('kuis'));
    }

    public function edit(Kuis $kuis)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $kuis->guru_id !== $guru->id) {
            return redirect()->route('guru.kuis.index')->with('error', 'Kuis tidak ditemukan');
        }

        return view('guru.kuis.edit', compact('kuis'));
    }

    public function update(Request $request, Kuis $kuis)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $kuis->guru_id !== $guru->id) {
            return redirect()->route('guru.kuis.index')->with('error', 'Kuis tidak ditemukan');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'tipe_kuis' => 'required|in:pilihan_ganda,video',
            'durasi' => 'required|integer|min:5|max:180',
            'video_url' => 'required_if:tipe_kuis,video|nullable|url',
            'video_soal' => 'required_if:tipe_kuis,video|nullable|string',
            'soal' => 'required_if:tipe_kuis,pilihan_ganda|nullable|array|min:1',
            'soal.*.pertanyaan' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.pilihan_a' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.pilihan_b' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.pilihan_c' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.pilihan_d' => 'required_if:tipe_kuis,pilihan_ganda|nullable|string',
            'soal.*.jawaban_benar' => 'required_if:tipe_kuis,pilihan_ganda|nullable|in:A,B,C,D'
        ]);

        // Prepare data based on quiz type
        $kuisData = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'tipe_kuis' => $request->tipe_kuis,
            'durasi_menit' => $request->durasi
        ];

        if ($request->tipe_kuis === 'video') {
            // Handle video quiz
            $kuisData['video_url'] = $request->video_url;
            $kuisData['video_soal'] = $request->video_soal;
            $kuisData['soal'] = json_encode([]); // Empty array for video quiz
        } else {
            // Handle multiple choice quiz
            $soalFormatted = [];
            if ($request->soal) {
                foreach ($request->soal as $index => $soal) {
                    $soalFormatted[] = [
                        'nomor' => $index + 1,
                        'pertanyaan' => $soal['pertanyaan'],
                        'pilihan' => [
                            'A' => $soal['pilihan_a'],
                            'B' => $soal['pilihan_b'],
                            'C' => $soal['pilihan_c'],
                            'D' => $soal['pilihan_d']
                        ],
                        'jawaban_benar' => $soal['jawaban_benar']
                    ];
                }
            }
            $kuisData['soal'] = json_encode($soalFormatted);
            $kuisData['video_url'] = null;
            $kuisData['video_soal'] = null;
        }

        $kuis->update($kuisData);

        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil diperbarui');
    }

    public function destroy(Kuis $kuis)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $kuis->guru_id !== $guru->id) {
            return redirect()->route('guru.kuis.index')->with('error', 'Kuis tidak ditemukan');
        }

        $kuis->delete();

        return redirect()->route('guru.kuis.index')->with('success', 'Kuis berhasil dihapus');
    }
}
