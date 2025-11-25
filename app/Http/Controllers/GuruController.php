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

class GuruController extends Controller
{
    public function dashboard(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }
        
        // Refresh guru data to ensure latest photo is loaded
        $guru->refresh();

        // Get mata pelajaran yang dipilih (default: pertama)
        $selectedMataPelajaran = $request->get('mata_pelajaran');        
        // Parse mata pelajaran from guru record
        $mataPelajaranList = collect();
        if ($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan') {
            $subjects = explode(', ', $guru->mata_pelajaran);
            foreach ($subjects as $subject) {
                $mataPelajaranList->push((object)[
                    'mata_pelajaran' => trim($subject)
                ]);
            }
        }
        
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        // Statistik dashboard berdasarkan mata pelajaran yang dipilih
        $query = $guru->materi();
        if ($selectedMataPelajaran) {
            $query->where('mata_pelajaran', $selectedMataPelajaran);
        }
        
        $totalMateri = $query->count();
        $materiPublished = $query->where('is_published', true)->count();
        
        $kuisQuery = $guru->kuis();
        if ($selectedMataPelajaran) {
            $kuisQuery->where('mata_pelajaran', $selectedMataPelajaran);
        }
        $totalKuis = $kuisQuery->count();
        
        // Materi terbaru berdasarkan mata pelajaran
        $materiTerbaru = $query
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Kuis aktif berdasarkan mata pelajaran
        $kuisAktif = $kuisQuery
            ->where('is_active', true)
            ->where('tanggal_selesai', '>', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(3)
            ->get();
        
        // Get recent notifications
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        // Get jadwal mengajar hari ini
        $today = now()->format('Y-m-d');
        $todayName = strtolower(now()->format('l'));
        $hariMap = [
            'sunday' => 'minggu',
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu'
        ];
        $hariIni = $hariMap[$todayName] ?? 'senin';
        
        // Get jadwal mengajar hari ini - OTOMATIS TER SINKRON dengan jadwal yang dibuat TU
        $jadwalHariIni = Jadwal::where('guru_id', $guru->id)
            ->where('status', 'aktif') // Hanya jadwal aktif
            ->where(function($query) use ($today, $hariIni) {
                $query->where(function($q) use ($today) {
                    $q->where('tanggal', $today);
                })->orWhere(function($q) use ($hariIni) {
                    $q->where('hari', $hariIni)
                      ->where('is_berulang', true);
                });
            })
            ->orderBy('jam_mulai')
            ->get();
        
        $totalJadwalHariIni = $jadwalHariIni->count();

        // Get jadwal mengajar minggu ini - OTOMATIS TER SINKRON dengan jadwal yang dibuat TU
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        $jadwalMingguIni = Jadwal::where('guru_id', $guru->id)
            ->where('status', 'aktif') // Hanya jadwal aktif
            ->where(function($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
                      ->orWhere('is_berulang', true);
            })
            ->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")
            ->orderBy('jam_mulai')
            ->limit(5)
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
            'jadwalMingguIni'
        ));
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

        return view('guru.profile.index', compact('guru'));
    }

    public function profileEdit()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        return view('guru.profile.edit', compact('guru'));
    }

    public function updateProfil(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biodata' => 'nullable|string',
            'kontak' => 'nullable|string|max:255',
            'keahlian' => 'nullable|string'
        ]);

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
                    // Path sudah benar: profiles/guru/[nama-file]
                    // Langsung simpan ke database tanpa perlu edit manual
                    $guru->foto = $fotoPath;
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
        if ($request->hasFile('foto')) {
            $updateData['foto'] = $guru->foto;
        }
        
        $guru->update($updateData);
        
        // Refresh guru data to ensure latest photo is loaded
        $guru->refresh();

        return redirect()->route('guru.profile.index')->with('success', 'Profil berhasil diperbarui');
    }

    public function jadwalIndex()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // Ambil semua jadwal untuk guru ini, termasuk yang dibuat oleh TU
        // Otomatis tersinkron karena menggunakan guru_id yang sama
        $jadwals = Jadwal::where('guru_id', $guru->id)
            ->where('status', 'aktif') // Hanya tampilkan jadwal aktif
            ->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('guru.jadwal.index', compact('guru', 'jadwals'));
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
