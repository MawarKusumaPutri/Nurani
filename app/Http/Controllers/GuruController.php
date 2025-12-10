<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\Notification;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'jadwalMendatang'
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
                // Delete old photo if exists
                if ($guru->foto) {
                    // Hapus foto lama dari berbagai kemungkinan lokasi
                    PhotoHelper::deletePhoto($guru->foto);
                    // Coba hapus dengan berbagai format path lama
                    $oldFilename = basename($guru->foto);
                    if ($oldFilename && $oldFilename !== $guru->foto) {
                        PhotoHelper::deletePhoto('profiles/guru/' . $oldFilename);
                        PhotoHelper::deletePhoto('guru/foto/' . $oldFilename);
                        PhotoHelper::deletePhoto('photos/' . $oldFilename);
                    }
                }
                
                $file = $request->file('foto');
                
                // OTOMATIS SIMPAN dengan path yang benar
                // Prioritas 1: simpan di storage/app/public/profiles/guru/
                $fotoPath = PhotoHelper::savePhoto($file, 'profiles/guru', true);
                
                if ($fotoPath) {
                    // Verifikasi file benar-benar tersimpan SEBELUM menyimpan ke database
                    $fileExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPath);
                    $fullPath = storage_path('app/public/' . $fotoPath);
                    $fileExistsOnDisk = file_exists($fullPath);
                    
                    \Log::info('Photo upload attempt for guru', [
                        'guru_id' => $guru->id,
                        'foto_path' => $fotoPath,
                        'file_exists_storage' => $fileExists,
                        'file_exists_disk' => $fileExistsOnDisk,
                        'full_path' => $fullPath
                    ]);
                    
                    // Hanya simpan ke database jika file benar-benar ada
                    if ($fileExists || $fileExistsOnDisk) {
                        $guru->foto = $fotoPath;
                        \Log::info('Photo path saved to database for guru', [
                            'guru_id' => $guru->id,
                            'foto_path' => $fotoPath
                        ]);
                    } else {
                        \Log::error('Photo file not found after upload for guru', [
                            'guru_id' => $guru->id,
                            'foto_path' => $fotoPath,
                            'full_path' => $fullPath
                        ]);
                        return back()->withErrors(['foto' => 'Foto berhasil diupload tapi file tidak ditemukan. Silakan coba lagi.'])->withInput();
                    }
                } else {
                    // Fallback: simpan di public/image/profiles
                    $fotoPath = PhotoHelper::savePhoto($file, 'image/profiles', false);
                    if ($fotoPath) {
                        // Path: image/profiles/[nama-file]
                        $guru->foto = $fotoPath;
                    } else {
                        return back()->withErrors(['foto' => 'Gagal menyimpan foto. Silakan coba lagi.'])->withInput();
                    }
                }
            } catch (\Exception $e) {
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
}
