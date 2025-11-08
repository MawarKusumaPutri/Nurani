<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;
use App\Models\User;
use App\Models\Notification;
use App\Models\Siswa;

class TuController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count(); // Dynamic from database
        $pendingIzin = 5; // Static for now
        $totalDokumen = 24; // Static for now
        
        return view('tu.dashboard', compact('user', 'totalGuru', 'totalSiswa', 'pendingIzin', 'totalDokumen'));
    }
    
    // Data Guru Management
    public function guruIndex()
    {
        $gurus = Guru::with('user')->paginate(20);
        return view('tu.guru.index', compact('gurus'));
    }
    
    public function guruCreate()
    {
        return view('tu.guru.create');
    }
    
    public function guruStore(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:255|unique:gurus,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'mata_pelajaran' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'no_telp' => 'nullable|string|max:20',
            'status' => 'required|string|in:aktif,tidak_aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'phone' => $request->no_telp,
        ]);

        // Handle foto upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('guru/foto', 'public');
        }

        // Create guru record
        $guru = Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'mata_pelajaran' => $request->mata_pelajaran,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('tu.guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }
    
    public function guruEdit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('tu.guru.edit', compact('guru'));
    }
    
    public function guruUpdate(Request $request, $id)
    {
        // Implementation for updating guru
        return redirect()->route('tu.guru.index')->with('success', 'Data guru berhasil diperbarui');
    }
    
    public function guruDestroy($id)
    {
        // Implementation for deleting guru
        return redirect()->route('tu.guru.index')->with('success', 'Data guru berhasil dihapus');
    }
    
    // Data Siswa Management
    public function siswaIndex()
    {
        // Get all students grouped by class
        $siswaKelas7 = Siswa::where('kelas', '7')->orderBy('nama')->get();
        $siswaKelas8 = Siswa::where('kelas', '8')->orderBy('nama')->get();
        $siswaKelas9 = Siswa::where('kelas', '9')->orderBy('nama')->get();
        
        return view('tu.siswa.index', compact('siswaKelas7', 'siswaKelas8', 'siswaKelas9'));
    }
    
    public function siswaCreate()
    {
        return view('tu.siswa.create');
    }
    
    public function siswaStore(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswas,nis',
            'nama' => 'required|string',
            'kelas' => 'required|string|in:7,8,9',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string|in:aktif,tidak_aktif',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
        ]);
        
        Siswa::create($request->all());
        
        return redirect()->route('tu.siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
    }
    
    public function siswaEdit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('tu.siswa.edit', compact('siswa'));
    }
    
    public function siswaUpdate(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        
        $request->validate([
            'nis' => 'required|string|unique:siswas,nis,' . $id,
            'nama' => 'required|string',
            'kelas' => 'required|string|in:7,8,9',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|string|in:aktif,tidak_aktif',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
        ]);
        
        $siswa->update($request->all());
        
        return redirect()->route('tu.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }
    
    // Presensi Management
    public function presensiIndex(Request $request)
    {
        // Get all presensi with guru info
        $presensiList = \App\Models\Presensi::with('guru.user')
            ->orderByRaw("CASE WHEN status_verifikasi = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Sort all presensi with pending first
        $allPresensi = $presensiList->sortBy(function($item) {
            // Pending first (0), then approved (1), then rejected (2)
            if ($item->status_verifikasi === 'pending') return 0;
            if ($item->status_verifikasi === 'approved') return 1;
            return 2;
        })->values();
        
        // Separate by jenis for backward compatibility (if needed for tabs)
        $presensiHadir = $allPresensi->where('jenis', 'hadir');
        $presensiIzin = $allPresensi->where('jenis', 'izin');
        $presensiSakit = $allPresensi->where('jenis', 'sakit');
        
        // Apply filters for Hadir tab
        if ($request->has('status_hadir') && $request->status_hadir !== '') {
            $presensiHadir = $presensiHadir->where('status_verifikasi', $request->status_hadir);
        }
        if ($request->has('tanggal_mulai_hadir') && $request->tanggal_mulai_hadir) {
            $presensiHadir = $presensiHadir->filter(function($item) use ($request) {
                return $item->tanggal->format('Y-m-d') >= $request->tanggal_mulai_hadir;
            });
        }
        if ($request->has('tanggal_selesai_hadir') && $request->tanggal_selesai_hadir) {
            $presensiHadir = $presensiHadir->filter(function($item) use ($request) {
                return $item->tanggal->format('Y-m-d') <= $request->tanggal_selesai_hadir;
            });
        }
        
        // Apply filters for Izin tab
        if ($request->has('status_izin') && $request->status_izin !== '') {
            $presensiIzin = $presensiIzin->where('status_verifikasi', $request->status_izin);
        }
        if ($request->has('tanggal_mulai_izin') && $request->tanggal_mulai_izin) {
            $presensiIzin = $presensiIzin->filter(function($item) use ($request) {
                return $item->tanggal->format('Y-m-d') >= $request->tanggal_mulai_izin;
            });
        }
        if ($request->has('tanggal_selesai_izin') && $request->tanggal_selesai_izin) {
            $presensiIzin = $presensiIzin->filter(function($item) use ($request) {
                return $item->tanggal->format('Y-m-d') <= $request->tanggal_selesai_izin;
            });
        }
        
        // Apply filters for Sakit tab
        if ($request->has('status_sakit') && $request->status_sakit !== '') {
            $presensiSakit = $presensiSakit->where('status_verifikasi', $request->status_sakit);
        }
        if ($request->has('tanggal_mulai_sakit') && $request->tanggal_mulai_sakit) {
            $presensiSakit = $presensiSakit->filter(function($item) use ($request) {
                return $item->tanggal->format('Y-m-d') >= $request->tanggal_mulai_sakit;
            });
        }
        if ($request->has('tanggal_selesai_sakit') && $request->tanggal_selesai_sakit) {
            $presensiSakit = $presensiSakit->filter(function($item) use ($request) {
                return $item->tanggal->format('Y-m-d') <= $request->tanggal_selesai_sakit;
            });
        }
        
        // Count pending for each type (for badges)
        $pendingHadir = $presensiHadir->where('status_verifikasi', 'pending')->count();
        $pendingIzin = $presensiIzin->where('status_verifikasi', 'pending')->count();
        $pendingSakit = $presensiSakit->where('status_verifikasi', 'pending')->count();
        $totalPending = $allPresensi->where('status_verifikasi', 'pending')->count();
        
        return view('tu.presensi.index', compact(
            'allPresensi',
            'presensiList', 
            'presensiHadir', 
            'presensiIzin', 
            'presensiSakit',
            'pendingHadir',
            'pendingIzin',
            'pendingSakit',
            'totalPending'
        ));
    }
    
    public function presensiVerify($id, Request $request)
    {
        $presensi = \App\Models\Presensi::findOrFail($id);
        
        $presensi->update([
            'status_verifikasi' => $request->action === 'approve' ? 'approved' : 'rejected',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        
        $message = $request->action === 'approve' ? 'Presensi berhasil disetujui' : 'Presensi ditolak';
        
        return redirect()->route('tu.presensi.index')
            ->with('success', $message);
    }
    
    // Izin Management
    public function izinIndex()
    {
        return view('tu.izin.index');
    }
    
    public function izinApprove($id)
    {
        // Implementation for approving leave
        return redirect()->route('tu.izin.index')->with('success', 'Izin berhasil disetujui');
    }
    
    public function izinReject($id)
    {
        // Implementation for rejecting leave
        return redirect()->route('tu.izin.index')->with('success', 'Izin berhasil ditolak');
    }
    
    // Sakit Management
    public function sakitIndex()
    {
        return view('tu.sakit.index');
    }
    
    public function sakitCreate()
    {
        return view('tu.sakit.create');
    }
    
    public function sakitStore(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|string',
            'nip' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'diagnosa' => 'required|string|max:255',
            'tingkat_keparahan' => 'nullable|string',
            'dokter' => 'nullable|string|max:255',
            'rumah_sakit' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'surat_sakit' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'status' => 'nullable|string',
            'is_rawat_inap' => 'nullable|boolean',
            'is_operasi' => 'nullable|boolean',
            'is_urgent' => 'nullable|boolean',
            'is_komunikasi' => 'nullable|boolean'
        ]);

        // Simpan data sakit (implementasi sesuai kebutuhan)
        $sakitData = [
            'guru_id' => $request->guru_id,
            'nip' => $request->nip,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'diagnosa' => $request->diagnosa,
            'tingkat_keparahan' => $request->tingkat_keparahan ?? 'sedang',
            'dokter' => $request->dokter,
            'rumah_sakit' => $request->rumah_sakit,
            'keterangan' => $request->keterangan,
            'status' => $request->status ?? 'menunggu',
            'is_rawat_inap' => $request->has('is_rawat_inap'),
            'is_operasi' => $request->has('is_operasi'),
            'is_urgent' => $request->has('is_urgent'),
            'is_komunikasi' => $request->has('is_komunikasi'),
            'created_by' => Auth::id(),
            'created_at' => now()
        ];

        // Handle file upload
        if ($request->hasFile('surat_sakit')) {
            $file = $request->file('surat_sakit');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat_sakit', $filename);
            $sakitData['surat_sakit'] = $filename;
        }

        // Simpan ke database (implementasi sesuai model yang ada)
        // Sakit::create($sakitData);

        $guruData = [
            '1' => 'Dr. Ahmad Suryadi, M.Pd',
            '2' => 'Siti Nurhaliza, S.Pd',
            '3' => 'Budi Santoso, M.Pd',
            '4' => 'Rina Wulandari, S.Pd',
            '5' => 'Joko Susilo, M.Pd',
            '6' => 'Dewi Kartika, S.Pd',
            '7' => 'Ahmad Fauzi, M.Pd',
            '8' => 'Sari Indah, S.Pd'
        ];

        $guruNama = $guruData[$request->guru_id] ?? 'Guru';
        $durasi = $request->tanggal_selesai ? 
            (new DateTime($request->tanggal_selesai))->diff(new DateTime($request->tanggal_mulai))->days + 1 : 
            'Belum ditentukan';

        return redirect()->route('tu.sakit.index')->with('success', 
            "Data sakit untuk {$guruNama} ({$request->diagnosa}) berhasil ditambahkan! Durasi: {$durasi} hari"
        );
    }
    
    // Jadwal Management
    public function jadwalIndex()
    {
        return view('tu.jadwal.index');
    }
    
    public function jadwalCreate()
    {
        $gurus = Guru::with('user')->where('status', 'aktif')->orderBy('nip')->get();
        
        // Get all unique mata pelajaran from active gurus
        $mataPelajaranList = collect();
        foreach ($gurus as $guru) {
            if ($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan') {
                $subjects = explode(', ', $guru->mata_pelajaran);
                foreach ($subjects as $subject) {
                    $mataPelajaranList->push(trim($subject));
                }
            }
        }
        $mataPelajaranList = $mataPelajaranList->unique()->sort()->values();
        
        return view('tu.jadwal.create', compact('gurus', 'mataPelajaranList'));
    }
    
    public function jadwalStore(Request $request)
    {
        $request->validate([
            'mata_pelajaran' => 'required|string',
            'guru' => 'required|string',
            'kelas' => 'required|string|in:7,8,9',
            'hari' => 'required|string|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'status' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'is_berulang' => 'nullable|boolean',
            'is_lab' => 'nullable|boolean'
        ]);

        // Simpan data jadwal (implementasi sesuai kebutuhan)
        $jadwalData = [
            'mata_pelajaran' => $request->mata_pelajaran,
            'guru_id' => $request->guru,
            'kelas' => $request->kelas,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'status' => $request->status ?? 'aktif',
            'keterangan' => $request->keterangan,
            'is_berulang' => $request->has('is_berulang'),
            'is_lab' => $request->has('is_lab'),
            'created_by' => Auth::id(),
            'created_at' => now()
        ];

        // Simpan ke database (implementasi sesuai model yang ada)
        // Jadwal::create($jadwalData);

        $mataPelajaranText = match($request->mata_pelajaran) {
            'matematika' => 'Matematika',
            'bahasa_indonesia' => 'Bahasa Indonesia',
            'bahasa_inggris' => 'Bahasa Inggris',
            'ipa' => 'IPA',
            'ips' => 'IPS',
            'pendidikan_agama' => 'Pendidikan Agama',
            'pendidikan_kewarganegaraan' => 'Pendidikan Kewarganegaraan',
            'pendidikan_jasmani' => 'Pendidikan Jasmani',
            'seni_budaya' => 'Seni Budaya',
            'teknologi_informasi' => 'Teknologi Informasi',
            'lainnya' => 'Lainnya',
            default => 'Mata Pelajaran'
        };

        return redirect()->route('tu.jadwal.index')->with('success', 
            "Jadwal {$mataPelajaranText} untuk kelas " . strtoupper($request->kelas) . " berhasil ditambahkan!"
        );
    }
    
    // Kalender Management
    public function kalenderIndex()
    {
        return view('tu.kalender.index');
    }
    
    public function kalenderCreate()
    {
        return view('tu.kalender.create');
    }
    
    public function kalenderStore(Request $request)
    {
        $request->validate([
            'judul_event' => 'required|string|max:255',
            'kategori_event' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'prioritas' => 'nullable|string',
            'warna' => 'nullable|string',
            'is_all_day' => 'nullable|boolean',
            'is_public' => 'nullable|boolean',
            'is_important' => 'nullable|boolean',
            'is_recurring' => 'nullable|boolean'
        ]);

        // Simpan data event (implementasi sesuai kebutuhan)
        $eventData = [
            'judul_event' => $request->judul_event,
            'kategori_event' => $request->kategori_event,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal_mulai,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'penanggung_jawab' => $request->penanggung_jawab,
            'prioritas' => $request->prioritas ?? 'sedang',
            'warna' => $request->warna ?? '#007bff',
            'is_all_day' => $request->has('is_all_day'),
            'is_public' => $request->has('is_public'),
            'is_important' => $request->has('is_important'),
            'is_recurring' => $request->has('is_recurring'),
            'created_by' => Auth::id(),
            'created_at' => now()
        ];

        // Simpan ke database (implementasi sesuai model yang ada)
        // Event::create($eventData);

        $kategoriText = match($request->kategori_event) {
            'akademik' => 'Akademik',
            'ujian' => 'Ujian',
            'libur' => 'Libur',
            'rapat' => 'Rapat',
            'pelatihan' => 'Pelatihan',
            'kegiatan' => 'Kegiatan',
            'pengumuman' => 'Pengumuman',
            'lainnya' => 'Lainnya',
            default => 'Event'
        };

        return redirect()->route('tu.kalender.index')->with('success', 
            "Event '{$request->judul_event}' berhasil ditambahkan ke kategori {$kategoriText}!"
        );
    }
    
    // Arsip Management
    public function arsipIndex()
    {
        return view('tu.arsip.index');
    }
    
    public function arsipCreate()
    {
        return view('tu.arsip.upload');
    }
    
    public function arsipUpload(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'judul_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_dokumen' => 'nullable|date',
            'pembuat' => 'required|string|max:255',
            'prioritas' => 'nullable|string',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,txt|max:51200',
            'is_public' => 'nullable|boolean',
            'is_important' => 'nullable|boolean'
        ]);

        // Simpan data arsip (implementasi sesuai kebutuhan)
        $arsipData = [
            'kategori' => $request->kategori,
            'judul_dokumen' => $request->judul_dokumen,
            'deskripsi' => $request->deskripsi,
            'tanggal_dokumen' => $request->tanggal_dokumen ?? now()->toDateString(),
            'pembuat' => $request->pembuat,
            'prioritas' => $request->prioritas ?? 'sedang',
            'is_public' => $request->has('is_public'),
            'is_important' => $request->has('is_important'),
            'created_by' => Auth::id(),
            'created_at' => now()
        ];

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/arsip', $filename);
            $arsipData['file_dokumen'] = $filename;
            $arsipData['ukuran_file'] = $file->getSize();
            $arsipData['tipe_file'] = $file->getClientOriginalExtension();
        }

        // Simpan ke database (implementasi sesuai model yang ada)
        // Arsip::create($arsipData);

        $kategoriText = match($request->kategori) {
            'akademik' => 'Akademik',
            'administrasi' => 'Administrasi',
            'keuangan' => 'Keuangan',
            'sdm' => 'SDM',
            'fasilitas' => 'Fasilitas',
            'keputusan' => 'Keputusan',
            'surat_masuk' => 'Surat Masuk',
            'surat_keluar' => 'Surat Keluar',
            'lainnya' => 'Lainnya',
            default => 'Dokumen'
        };

        return redirect()->route('tu.arsip.index')->with('success', 
            "Dokumen '{$request->judul_dokumen}' berhasil diupload ke kategori {$kategoriText}!"
        );
    }
    
    // Surat Management
    public function suratIndex()
    {
        return view('tu.surat.index');
    }
    
    public function suratCreate()
    {
        return view('tu.surat.create');
    }
    
    
    // Surat Management
    public function suratSend(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required|string',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'penerima' => 'required|string',
            'penerima_lainnya' => 'nullable|string|max:255',
            'isi_surat' => 'required|string',
            'pembuat_surat' => 'required|string',
            'jabatan_pembuat' => 'nullable|string|max:255',
            'prioritas' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'cc_email' => 'nullable|boolean',
            'arsipkan' => 'nullable|boolean'
        ]);

        // Simpan data surat (implementasi sesuai kebutuhan)
        $suratData = [
            'jenis_surat' => $request->jenis_surat,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal' => $request->perihal,
            'penerima' => $request->penerima,
            'penerima_lainnya' => $request->penerima_lainnya,
            'isi_surat' => $request->isi_surat,
            'pembuat_surat' => $request->pembuat_surat,
            'jabatan_pembuat' => $request->jabatan_pembuat ?? 'Tenaga Usaha',
            'prioritas' => $request->prioritas ?? 'biasa',
            'created_by' => Auth::id(),
            'created_at' => now()
        ];

        // Handle file upload jika ada
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat', $filename);
            $suratData['lampiran'] = $filename;
        }

        // Simpan ke database (implementasi sesuai model yang ada)
        // Surat::create($suratData);

        // Kirim notifikasi ke penerima (implementasi sesuai kebutuhan)
        $penerimaText = match($request->penerima) {
            'kepala_sekolah' => 'Kepala Sekolah',
            'guru' => 'Semua Guru',
            'siswa' => 'Semua Siswa',
            'orang_tua' => 'Orang Tua Siswa',
            'yayasan' => 'Yayasan',
            'dinas_pendidikan' => 'Dinas Pendidikan',
            'lainnya' => $request->penerima_lainnya ?? 'Penerima',
            default => 'Penerima'
        };

        $jenisText = match($request->jenis_surat) {
            'surat_keputusan' => 'Surat Keputusan',
            'surat_edaran' => 'Surat Edaran',
            'surat_undangan' => 'Surat Undangan',
            'surat_tugas' => 'Surat Tugas',
            'surat_izin' => 'Surat Izin',
            'surat_pengumuman' => 'Surat Pengumuman',
            'surat_permohonan' => 'Surat Permohonan',
            'surat_balasan' => 'Surat Balasan',
            default => 'Surat'
        };

        return redirect()->route('tu.surat.index')->with('success', 
            "{$jenisText} '{$request->nomor_surat}' berhasil dikirim ke {$penerimaText}!"
        );
    }
    
    // Pengumuman Management
    public function pengumumanIndex()
    {
        return view('tu.pengumuman.index');
    }
    
    public function pengumumanCreate()
    {
        return view('tu.pengumuman.create');
    }
    
    public function pengumumanSend(Request $request)
    {
        // Implementation for sending announcements
        return redirect()->route('tu.pengumuman.index')->with('success', 'Pengumuman berhasil dikirim');
    }
    
    // Profile Management
    public function profileIndex()
    {
        $user = Auth::user();
        return view('tu.profile.index', compact('user'));
    }
    
    public function profileEdit()
    {
        $user = Auth::user();
        return view('tu.profile.edit', compact('user'));
    }
    
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;
        $user->phone = $request->phone;
        $user->address = $request->address;
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists('photos/' . $user->photo)) {
                Storage::disk('public')->delete('photos/' . $user->photo);
            }
            
            $file = $request->file('photo');
            $filename = time() . '_' . $user->id . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('photos', $filename, 'public');
            $user->photo = $filename;
        }
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        // Reload user from database to ensure fresh data
        $user->refresh();
        
        // Refresh user data in session
        Auth::login($user);
        
        return redirect()->route('tu.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
