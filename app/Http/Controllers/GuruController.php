<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\Notification;
use App\Models\Jadwal;
use App\Models\MateriPembelajaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use App\Helpers\PhotoHelper;
use Carbon\Carbon;

class GuruController extends Controller
{
    public function dashboard(Request $request)
    {
        // OPTIMIZED: Eager load user relation untuk menghindari N+1 query
        $guru = Guru::with('user')->where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }
        
        // HAPUS refresh() - tidak perlu, akan memperlambat

        // Get mata pelajaran yang dipilih (default: pertama)
        $selectedMataPelajaran = $request->get('mata_pelajaran');        
        // Parse mata pelajaran from guru record - OPTIMIZED
        $mataPelajaranList = $guru->mataPelajaranAktif;
        
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        // OPTIMIZED: Gunakan single query dengan select untuk menghitung statistik
        $materiBaseQuery = $guru->materi();
        if ($selectedMataPelajaran) {
            $materiBaseQuery->where('mata_pelajaran', $selectedMataPelajaran);
        }
        
        // OPTIMIZED: Hitung total dan published dalam satu query
        $materiStats = (clone $materiBaseQuery)->selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN is_published = 1 THEN 1 ELSE 0 END) as published
        ')->first();
        
        $totalMateri = $materiStats->total ?? 0;
        $materiPublished = $materiStats->published ?? 0;
        
        // OPTIMIZED: Materi terbaru - gunakan query yang sudah ada
        $materiTerbaru = (clone $materiBaseQuery)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // OPTIMIZED: Kuis query
        $kuisBaseQuery = $guru->kuis();
        if ($selectedMataPelajaran) {
            $kuisBaseQuery->where('mata_pelajaran', $selectedMataPelajaran);
        }
        
        $totalKuis = (clone $kuisBaseQuery)->count();
            
        // OPTIMIZED: Kuis aktif
        $kuisAktif = (clone $kuisBaseQuery)
            ->where('is_active', true)
            ->where('tanggal_selesai', '>', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(3)
            ->get();
        
        // Get recent notifications - OPTIMIZED
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Count unread notifications - OPTIMIZED (single query)
        $unreadNotifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        // OPTIMIZED: Get jadwal mengajar hari ini - single query dengan select yang efisien
        $today = now()->format('Y-m-d');
        $hariIni = strtolower(now()->format('l'));
        $hariMap = [
            'sunday' => 'minggu', 'monday' => 'senin', 'tuesday' => 'selasa',
            'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu'
        ];
        $hariIni = $hariMap[$hariIni] ?? 'senin';
        
        $jadwalHariIni = Jadwal::where('guru_id', $guru->id)
            ->where('status', 'aktif')
            ->where(function($query) use ($today, $hariIni) {
                $query->where('tanggal', $today)
                      ->orWhere(function($q) use ($hariIni) {
                          $q->where('hari', $hariIni)->where('is_berulang', true);
                      });
            })
            ->orderBy('jam_mulai')
            ->get();
        
        $totalJadwalHariIni = $jadwalHariIni->count();

        // OPTIMIZED: Get jadwal mengajar minggu ini - limit query
        $startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = now()->endOfWeek()->format('Y-m-d');
        
        $jadwalMingguIni = Jadwal::where('guru_id', $guru->id)
            ->where('status', 'aktif')
            ->where(function($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
                      ->orWhere('is_berulang', true);
            })
            ->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")
            ->orderBy('jam_mulai')
            ->limit(5)
            ->get();

        // OPTIMIZED: Get jadwal mengajar mendatang - simplified query
        $todayCarbon = Carbon::today();
        $endDate = $todayCarbon->copy()->addDays(7);
        
        $jadwalMendatang = Jadwal::where('guru_id', $guru->id)
            ->where('status', 'aktif')
            ->where(function($query) use ($todayCarbon, $endDate) {
                $query->where('is_berulang', true)
                      ->orWhere(function($q) use ($todayCarbon, $endDate) {
                          $q->where('is_berulang', false)
                            ->whereBetween('tanggal', [$todayCarbon->format('Y-m-d'), $endDate->format('Y-m-d')]);
                      });
            })
            ->orderByRaw("CASE LOWER(hari) 
                WHEN 'senin' THEN 1 WHEN 'selasa' THEN 2 WHEN 'rabu' THEN 3 
                WHEN 'kamis' THEN 4 WHEN 'jumat' THEN 5 WHEN 'sabtu' THEN 6 
                WHEN 'minggu' THEN 7 ELSE 8 END")
            ->orderBy('jam_mulai', 'asc')
            ->limit(10)
            ->get();

        // Get materi pembelajaran untuk mata pelajaran yang dipilih
        $materiPembelajaran = null;
        if ($selectedMataPelajaran) {
            try {
                // Query materi pembelajaran
                $materiPembelajaran = MateriPembelajaran::where('guru_id', $guru->id)
                    ->where('mata_pelajaran', $selectedMataPelajaran)
                    ->first();
            } catch (\Illuminate\Database\QueryException $e) {
                // Jika error karena tabel tidak ada, buat tabel dan coba lagi
                if (strpos($e->getMessage(), "doesn't exist") !== false || 
                    strpos($e->getMessage(), "Base table or view not found") !== false ||
                    strpos($e->getMessage(), "1146") !== false) {
                    try {
                        $this->createMateriPembelajaranTable();
                        // Coba query lagi setelah tabel dibuat
                        $materiPembelajaran = MateriPembelajaran::where('guru_id', $guru->id)
                            ->where('mata_pelajaran', $selectedMataPelajaran)
                            ->first();
                    } catch (\Exception $e2) {
                        // Jika masih error, set null saja (tidak akan crash aplikasi)
                        $materiPembelajaran = null;
                    }
                } else {
                    // Error lain, set null
                    $materiPembelajaran = null;
                }
            } catch (\Exception $e) {
                // Error lain, set null
                $materiPembelajaran = null;
            }
        }

        return view('guru.dashboard', compact(
            'guru',
            'mataPelajaranList',
            'selectedMataPelajaran',
            'totalMateri',
            'materiPublished',
            'totalKuis',
            'materiTerbaru',
            'kuisAktif',
            'notifications',
            'unreadNotifications',
            'jadwalHariIni',
            'totalJadwalHariIni',
            'jadwalMingguIni',
            'jadwalMendatang',
            'materiPembelajaran'
        ));
    }

    public function jadwalIndex(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }
        
        $today = Carbon::today();
        $hariMap = [
            'Monday' => 'senin',
            'Tuesday' => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday' => 'kamis',
            'Friday' => 'jumat',
            'Saturday' => 'sabtu',
            'Sunday' => 'minggu'
        ];
        
        // Get filter
        $filter = $request->get('filter', 'semua'); // semua, hari_ini, minggu_ini, bulan_ini
        
        $query = Jadwal::where('guru_id', $guru->id)
            ->where('status', 'aktif');
        
        if ($filter == 'hari_ini') {
            $hariIni = $hariMap[$today->format('l')] ?? 'senin';
            $query->where(function($q) use ($today, $hariIni) {
                $q->where(function($subQ) use ($hariIni) {
                    $subQ->where('is_berulang', true)->where('hari', $hariIni);
                })
                ->orWhere(function($subQ) use ($today) {
                    $subQ->where('is_berulang', false)->whereDate('tanggal', $today);
                });
            });
        } elseif ($filter == 'minggu_ini') {
            $startOfWeek = $today->copy()->startOfWeek();
            $endOfWeek = $today->copy()->endOfWeek();
            $query->where(function($q) use ($startOfWeek, $endOfWeek) {
                $q->where('is_berulang', true)
                  ->orWhere(function($subQ) use ($startOfWeek, $endOfWeek) {
                      $subQ->where('is_berulang', false)
                           ->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
                  });
            });
        } elseif ($filter == 'bulan_ini') {
            $startOfMonth = $today->copy()->startOfMonth();
            $endOfMonth = $today->copy()->endOfMonth();
            $query->where(function($q) use ($startOfMonth, $endOfMonth) {
                $q->where('is_berulang', true)
                  ->orWhere(function($subQ) use ($startOfMonth, $endOfMonth) {
                      $subQ->where('is_berulang', false)
                           ->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
                  });
            });
        }
        
        $jadwals = $query->orderByRaw("CASE hari 
                WHEN 'senin' THEN 1 
                WHEN 'selasa' THEN 2 
                WHEN 'rabu' THEN 3 
                WHEN 'kamis' THEN 4 
                WHEN 'jumat' THEN 5 
                WHEN 'sabtu' THEN 6 
                WHEN 'minggu' THEN 7 
                ELSE 8 END")
            ->orderBy('jam_mulai', 'asc')
            ->paginate(20);
        
        return view('guru.jadwal.index', compact('guru', 'jadwals', 'filter'));
    }

    public function profil()
    {
        // Redirect to new profile index route for backward compatibility
        return redirect()->route('guru.profile.index');
    }

    public function profileIndex()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // Refresh data untuk memastikan data terbaru
        $guru->refresh();
        $guru->load('user');

        return view('guru.profile.index', compact('guru'));
    }

    public function profileEdit()
    {
        try {
            $guru = Guru::where('user_id', Auth::id())->first();
            
            if (!$guru) {
                return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan');
            }

            // Refresh data untuk memastikan data terbaru
            $guru->refresh();
            $guru->load('user');

            return view('guru.profile.edit', compact('guru'));
        } catch (\Exception $e) {
            \Log::error('Error in profileEdit: ' . $e->getMessage());
            return redirect()->route('guru.dashboard')->with('error', 'Terjadi kesalahan saat memuat halaman edit profil: ' . $e->getMessage());
        }
    }

    public function updateProfil(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'nip' => 'required|string|max:255',
                'mata_pelajaran' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'biodata' => 'nullable|string',
                'kontak' => 'nullable|string|max:255',
                'keahlian' => 'nullable|string'
            ], [
                'nama.required' => 'Nama lengkap wajib diisi.',
                'nip.required' => 'NIP wajib diisi.',
                'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
                'foto.image' => 'File yang diupload harus berupa gambar.',
                'foto.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
                'foto.max' => 'Ukuran gambar maksimal 2MB.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        // Update data user
        $guru->user->update([
            'name' => $request->nama
        ]);

        // Handle foto upload - FLEKSIBEL: bisa simpan di mana saja
        if ($request->hasFile('foto')) {
            try {
                $file = $request->file('foto');
                
                // Validasi file sebelum upload
                if (!$file || !$file->isValid()) {
                    $errorMsg = $file ? 'File foto tidak valid. Error code: ' . $file->getError() : 'File foto tidak ditemukan.';
                    \Log::error('File invalid for guru: ' . $errorMsg);
                    return back()->withErrors(['foto' => $errorMsg])->withInput();
                }
                
                // Cek ukuran file (max 2MB)
                if ($file->getSize() > 2048 * 1024) {
                    return back()->withErrors(['foto' => 'Ukuran file terlalu besar. Maksimal 2MB.'])->withInput();
                }
                
                // Cek tipe file
                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                $fileMime = $file->getMimeType();
                if (!in_array($fileMime, $allowedMimes)) {
                    return back()->withErrors(['foto' => 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF. Format yang diupload: ' . $fileMime])->withInput();
                }
                
                // Pastikan storage link ada
                $storageLink = public_path('storage');
                if (!file_exists($storageLink) || !is_link($storageLink)) {
                    try {
                        \Artisan::call('storage:link');
                        \Log::info('Storage link created successfully for guru');
                    } catch (\Exception $e) {
                        \Log::warning('Gagal membuat storage link: ' . $e->getMessage());
                    }
                }
                
                // Pastikan folder storage ada
                $storagePath = storage_path('app/public/profiles/guru');
                if (!file_exists($storagePath)) {
                    if (!mkdir($storagePath, 0755, true)) {
                        \Log::error('Gagal membuat folder: ' . $storagePath);
                        // Coba dengan permission yang lebih tinggi
                        @mkdir($storagePath, 0777, true);
                    }
                }
                
                // Verifikasi folder ada dan writable
                if (!file_exists($storagePath) || !is_writable($storagePath)) {
                    \Log::error('Folder tidak ada atau tidak writable: ' . $storagePath);
                    return back()->withErrors(['foto' => 'Folder storage tidak dapat diakses. Silakan hubungi administrator.'])->withInput();
                }
                
                // Delete old photo if exists
                if ($guru->foto) {
                    try {
                        // Hapus foto lama dari berbagai kemungkinan lokasi
                        PhotoHelper::deletePhoto($guru->foto);
                        // Coba hapus dengan berbagai format path lama
                        $oldFilename = basename($guru->foto);
                        if ($oldFilename && $oldFilename !== $guru->foto) {
                            PhotoHelper::deletePhoto('profiles/guru/' . $oldFilename);
                            PhotoHelper::deletePhoto('guru/foto/' . $oldFilename);
                            PhotoHelper::deletePhoto('photos/' . $oldFilename);
                        }
                    } catch (\Exception $e) {
                        // Log error tapi lanjutkan proses upload
                        \Log::warning('Gagal menghapus foto lama: ' . $e->getMessage());
                    }
                }
                
                // OTOMATIS SIMPAN dengan path yang benar
                // Prioritas 1: simpan di storage/app/public/profiles/guru/
                $fotoPath = PhotoHelper::savePhoto($file, 'profiles/guru', true);
                
                if ($fotoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPath)) {
                    // Path sudah benar: profiles/guru/[nama-file]
                    $guru->foto = $fotoPath;
                    \Log::info('Foto guru berhasil disimpan: ' . $fotoPath);
                } else {
                    // Fallback: simpan di public/image/profiles
                    $fotoPath = PhotoHelper::savePhoto($file, 'image/profiles', false);
                    if ($fotoPath && file_exists(public_path($fotoPath))) {
                        // Path: image/profiles/[nama-file]
                        $guru->foto = $fotoPath;
                        \Log::info('Foto guru berhasil disimpan (fallback): ' . $fotoPath);
                    } else {
                        // Log error untuk debugging
                        \Log::error('Gagal menyimpan foto guru: File valid tapi savePhoto mengembalikan null atau file tidak ada');
                        \Log::error('File info: ' . json_encode([
                            'name' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime' => $file->getMimeType(),
                            'error' => $file->getError(),
                            'storage_path' => $storagePath,
                            'storage_exists' => file_exists($storagePath),
                            'storage_writable' => is_writable($storagePath)
                        ]));
                        return back()->withErrors(['foto' => 'Gagal menyimpan foto. Pastikan folder storage memiliki permission yang benar dan storage link sudah dibuat.'])->withInput();
                    }
                }
            } catch (\Exception $e) {
                // Log error lengkap untuk debugging
                \Log::error('Error upload foto guru: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
                \Log::error('File: ' . (isset($file) && $file ? $file->getClientOriginalName() : 'null'));
                return back()->withErrors(['foto' => 'Terjadi kesalahan saat mengupload foto: ' . $e->getMessage()])->withInput();
            }
        }

        // Update data guru
        $updateData = [
            'nip' => $request->nip,
            'mata_pelajaran' => $request->mata_pelajaran,
            'biodata' => $request->biodata,
            'kontak' => $request->kontak,
            'keahlian' => $request->keahlian
        ];
        
        // Add foto to update data if it was uploaded
        if ($request->hasFile('foto') && !empty($guru->foto)) {
            $updateData['foto'] = $guru->foto;
        }
        
        $guru->update($updateData);
        
        // Refresh data guru untuk memastikan data terbaru
        $guru->refresh();
        $guru->load('user');
        
        // Verifikasi foto tersimpan dengan benar
        if ($guru->foto) {
            $photoExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($guru->foto);
            $photoFullPath = storage_path('app/public/' . $guru->foto);
            $photoFileExists = file_exists($photoFullPath);
            
            \Log::info('Photo verification after update', [
                'guru_id' => $guru->id,
                'foto_path' => $guru->foto,
                'storage_exists' => $photoExists,
                'file_exists' => $photoFileExists,
                'full_path' => $photoFullPath
            ]);
        }
        
        // Refresh guru data to ensure latest photo is loaded
        $guru->refresh();
        
        // Clear all caches to ensure fresh data
        try {
            \Artisan::call('view:clear');
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
        } catch (\Exception $e) {
            // Ignore cache errors
        }

        return redirect()->route('guru.profile.index')->with('success', 'Profil berhasil diperbarui');
    }

    public function storeMateri(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe_materi' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'video_url' => 'nullable|url',
            'video_title' => 'nullable|string',
            'video_thumbnail' => 'nullable|string',
            'video_duration' => 'nullable|string'
        ]);

        $materiData = [
            'guru_id' => $guru->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe_materi' => $request->tipe_materi,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas' => $request->kelas,
            'is_active' => true
        ];

        // Add video data if it's a YouTube video
        if ($request->tipe_materi === 'video_youtube') {
            $materiData['video_url'] = $request->video_url;
            $materiData['video_title'] = $request->video_title;
            $materiData['video_thumbnail'] = $request->video_thumbnail;
            $materiData['video_duration'] = $request->video_duration;
        }

        // Create materi using the Materi model
        \App\Models\Materi::create($materiData);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Create materi_pembelajaran table if it doesn't exist
     */
    private function createMateriPembelajaranTable()
    {
        try {
            // Cek dulu apakah tabel sudah ada dengan PDO langsung (lebih reliable)
            $pdo = DB::connection()->getPdo();
            $result = $pdo->query("SHOW TABLES LIKE 'materi_pembelajaran'");
            if ($result->rowCount() > 0) {
                return; // Tabel sudah ada
            }
        } catch (\Exception $e) {
            // Ignore error, lanjutkan membuat tabel
        }
        
        try {
            // Gunakan PDO langsung untuk membuat tabel (lebih reliable)
            $pdo = DB::connection()->getPdo();
            $sql = "CREATE TABLE IF NOT EXISTS `materi_pembelajaran` (
              `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
              `guru_id` bigint(20) UNSIGNED NOT NULL,
              `mata_pelajaran` varchar(255) NOT NULL,
              `identitas_mata_pelajaran` text DEFAULT NULL,
              `profil_sejarah` text DEFAULT NULL,
              `relevansi` text DEFAULT NULL,
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `materi_pembelajaran_guru_id_mata_pelajaran_unique` (`guru_id`, `mata_pelajaran`),
              KEY `materi_pembelajaran_guru_id_foreign` (`guru_id`),
              CONSTRAINT `materi_pembelajaran_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $pdo->exec($sql);
        } catch (\Exception $e) {
            // Jika masih gagal, log error
            \Log::error('Failed to create materi_pembelajaran table: ' . $e->getMessage());
            // Jangan throw, biarkan aplikasi tetap berjalan
        }
    }
}
