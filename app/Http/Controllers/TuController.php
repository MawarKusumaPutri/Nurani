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
use App\Models\Jadwal;
use App\Models\Event;
use App\Models\Arsip;
use App\Models\Surat;
use App\Models\PresensiSiswa;
use App\Helpers\PhotoHelper;
use Carbon\Carbon;
// Excel classes will be loaded dynamically when needed


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
    public function guruIndex(Request $request)
    {
        // Get filter parameters from request
        $mataPelajaran = $request->get('mata_pelajaran', '');
        $status = $request->get('status', '');
        $search = $request->get('search', '');
        
        // Base query
        $query = Guru::with('user');
        
        // Apply mata pelajaran filter
        if (!empty($mataPelajaran)) {
            $query->where('mata_pelajaran', 'like', '%' . $mataPelajaran . '%');
        }
        
        // Apply status filter
        if (!empty($status)) {
            $query->where('status', $status);
        }
        
        // Apply search filter (nama atau NIP)
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Order and paginate
        $gurus = $query->orderBy('nip')->paginate(20)->withQueryString();
        
        // Get unique mata pelajaran for filter dropdown
        $mataPelajaranList = Guru::whereNotNull('mata_pelajaran')
            ->where('mata_pelajaran', '!=', '')
            ->where('mata_pelajaran', '!=', 'Belum ditentukan')
            ->distinct()
            ->pluck('mata_pelajaran')
            ->flatMap(function($mp) {
                // Handle comma-separated mata pelajaran
                return explode(', ', $mp);
            })
            ->map(function($mp) {
                return trim($mp);
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();
        
        return view('tu.guru.index', compact('gurus', 'mataPelajaranList', 'mataPelajaran', 'status', 'search'));
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
        $guru = Guru::with('user')->findOrFail($id);
        
        $request->validate([
            'nip' => 'required|string|max:255|unique:gurus,nip,' . $id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'password' => 'nullable|string|min:6',
            'mata_pelajaran' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,tidak_aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Prepare user data
        $userData = [
            'name' => $request->nama,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        
        // Update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        
        // Update user
        $guru->user->update($userData);
        
        // Handle foto upload
        $fotoPath = $guru->foto; // Keep existing foto
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            // Store new foto
            $fotoPath = $request->file('foto')->store('guru/foto', 'public');
        }
        
        // Update guru
        $guru->update([
            'nip' => $request->nip,
            'mata_pelajaran' => $request->mata_pelajaran ?? 'Belum ditentukan',
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);
        
        return redirect()->route('tu.guru.index')->with('success', 'Data guru berhasil diperbarui');
    }
    
    public function guruDestroy($id)
    {
        try {
            $guru = Guru::findOrFail($id);
            $user = $guru->user;
            $namaGuru = $user->name;
            
            // Delete guru (will cascade delete user if foreign key is set)
            $guru->delete();
            
            // Also delete user if not cascade
            if ($user) {
                $user->delete();
            }
            
            return redirect()->route('tu.guru.index')->with('success', 'Data guru ' . $namaGuru . ' berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting guru: ' . $e->getMessage());
            return redirect()->route('tu.guru.index')->with('error', 'Gagal menghapus data guru: ' . $e->getMessage());
        }
    }
    
    // Data Siswa Management
    public function siswaIndex(Request $request)
    {
        // Get filter parameters from request
        $kelasFilter = $request->get('kelas', '');
        $statusFilter = $request->get('status', '');
        $search = $request->get('search', '');
        
        // Helper function to build query with filters
        $buildQuery = function($kelas) use ($statusFilter, $search) {
            $query = Siswa::where('kelas', $kelas);
            
            // Apply status filter
            if (!empty($statusFilter)) {
                $query->where('status', $statusFilter);
            }
            
            // Apply search filter (nama atau NIS)
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('nis', 'like', '%' . $search . '%');
                });
            }
            
            return $query->orderBy('nama')->get();
        };
        
        // Get students grouped by class with filters
        // If kelas filter is set, only show that class, otherwise show all
        if (!empty($kelasFilter)) {
            // Show only selected class
            $siswaKelas7 = ($kelasFilter == '7') ? $buildQuery('7') : collect();
            $siswaKelas8 = ($kelasFilter == '8') ? $buildQuery('8') : collect();
            $siswaKelas9 = ($kelasFilter == '9') ? $buildQuery('9') : collect();
        } else {
            // Show all classes
            $siswaKelas7 = $buildQuery('7');
            $siswaKelas8 = $buildQuery('8');
            $siswaKelas9 = $buildQuery('9');
        }
        
        return view('tu.siswa.index', compact('siswaKelas7', 'siswaKelas8', 'siswaKelas9', 'kelasFilter', 'statusFilter', 'search'));
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
            'status' => 'required|string|in:aktif,tidak_aktif,lulus',
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
            'status' => 'required|string|in:aktif,tidak_aktif,lulus',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
        ]);
        
        $siswa->update($request->all());
        
        return redirect()->route('tu.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function siswaDestroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $nama = $siswa->nama;
            
            // Delete related presensi records if any
            $siswa->presensi()->delete();
            
            // Delete the student
            $siswa->delete();
            
            return redirect()->route('tu.siswa.index')->with('success', "Data siswa {$nama} berhasil dihapus");
        } catch (\Exception $e) {
            return redirect()->route('tu.siswa.index')->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }
    
    // Data Alumni Management
    public function alumniIndex(Request $request)
    {
        // Get filter parameters from request
        $tahunLulus = $request->get('tahun_lulus', '');
        $search = $request->get('search', '');
        
        // Base query - Alumni adalah siswa dengan status 'lulus' atau 'tidak_aktif'
        $query = Siswa::whereIn('status', ['lulus', 'tidak_aktif']);
        
        // Apply tahun lulus filter (jika ada kolom tahun_lulus)
        if (!empty($tahunLulus)) {
            $query->where('tahun_lulus', $tahunLulus);
        }
        
        // Apply search filter (nama atau NIS)
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }
        
        // Order and paginate
        $alumni = $query->orderBy('nama')->paginate(20)->withQueryString();
        
        return view('tu.alumni.index', compact('alumni', 'tahunLulus', 'search'));
    }
    
    public function downloadTemplate()
    {
        $filename = 'template_data_siswa.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['NIS', 'Nama', 'Kelas', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'Status']);
            
            // Sample data
            fputcsv($file, ['10120', 'Ahmad Fauzi', '7', 'Laki-laki', 'Jakarta', '2010-05-15', 'Jl. Merdeka No. 10', 'aktif']);
            fputcsv($file, ['10121', 'Siti Nurhaliza', '7', 'Perempuan', 'Bandung', '2010-06-20', 'Jl. Sudirman No. 15', 'aktif']);
            fputcsv($file, ['', '', '', '', '', '', '', '']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $file = $request->file('excel_file');
            $extension = $file->getClientOriginalExtension();
            
            $imported = 0;
            $errors = [];
            
            if ($extension === 'csv') {
                // Handle CSV file
                $handle = fopen($file->getRealPath(), 'r');
                $header = fgetcsv($handle); // Skip header row
                
                while (($row = fgetcsv($handle)) !== false) {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }
                    
                    try {
                        // Validate required fields
                        if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
                            $errors[] = "Baris dengan NIS '{$row[0]}' - Data tidak lengkap";
                            continue;
                        }
                        
                        // Check if NIS already exists
                        if (Siswa::where('nis', $row[0])->exists()) {
                            $errors[] = "NIS '{$row[0]}' sudah ada di database";
                            continue;
                        }
                        
                        // Create siswa
                        Siswa::create([
                            'nis' => $row[0],
                            'nama' => $row[1],
                            'kelas' => $row[2],
                            'jenis_kelamin' => $row[3] ?? 'Laki-laki',
                            'tempat_lahir' => $row[4] ?? null,
                            'tanggal_lahir' => !empty($row[5]) ? $row[5] : null,
                            'alamat' => $row[6] ?? null,
                            'status' => $row[7] ?? 'aktif',
                        ]);
                        
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Baris dengan NIS '{$row[0]}' - " . $e->getMessage();
                    }
                }
                
                fclose($handle);
            } else {
                // For XLSX/XLS, we need PhpSpreadsheet
                return redirect()->route('tu.siswa.index')
                    ->with('error', 'Format Excel (.xlsx/.xls) belum didukung. Silakan gunakan format CSV atau convert ke CSV terlebih dahulu.');
            }
            
            // Prepare success message
            $message = "Berhasil mengimport {$imported} data siswa.";
            if (count($errors) > 0) {
                $message .= " Terdapat " . count($errors) . " error: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= " dan " . (count($errors) - 3) . " error lainnya.";
                }
            }
            
            return redirect()->route('tu.siswa.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('tu.siswa.index')
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
    
    public function importPaste(Request $request)
    {
        $request->validate([
            'paste_data' => 'required|string',
        ]);

        try {
            $pasteData = $request->paste_data;
            
            // Split by newline
            $lines = explode("\n", $pasteData);
            
            $imported = 0;
            $errors = [];
            $firstLine = true;
            
            foreach ($lines as $lineNum => $line) {
                // Skip empty lines
                $line = trim($line);
                if (empty($line)) {
                    continue;
                }
                
                // Skip header (first line)
                if ($firstLine) {
                    $firstLine = false;
                    continue;
                }
                
                // Split by tab (Excel default) or multiple spaces
                $row = preg_split('/\t+/', $line);
                
                // If no tabs found, try splitting by multiple spaces
                if (count($row) == 1) {
                    $row = preg_split('/\s{2,}/', $line);
                }
                
                try {
                    // Validate required fields
                    if (count($row) < 3 || empty($row[0]) || empty($row[1]) || empty($row[2])) {
                        $errors[] = "Baris " . ($lineNum + 1) . " - Data tidak lengkap";
                        continue;
                    }
                    
                    // Clean data
                    $nis = trim($row[0]);
                    $nama = trim($row[1]);
                    $kelas = trim($row[2]);
                    
                    // Check if NIS already exists
                    if (Siswa::where('nis', $nis)->exists()) {
                        $errors[] = "NIS '{$nis}' sudah ada di database";
                        continue;
                    }
                    
                    // Create siswa
                    Siswa::create([
                        'nis' => $nis,
                        'nama' => $nama,
                        'kelas' => $kelas,
                        'jenis_kelamin' => isset($row[3]) ? trim($row[3]) : 'Laki-laki',
                        'tempat_lahir' => isset($row[4]) ? trim($row[4]) : null,
                        'tanggal_lahir' => isset($row[5]) && !empty(trim($row[5])) ? trim($row[5]) : null,
                        'alamat' => isset($row[6]) ? trim($row[6]) : null,
                        'status' => isset($row[7]) ? trim($row[7]) : 'aktif',
                    ]);
                    
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($lineNum + 1) . " - " . $e->getMessage();
                }
            }
            
            // Prepare success message
            $message = "Berhasil mengimport {$imported} data siswa dari copy-paste.";
            if (count($errors) > 0) {
                $message .= " Terdapat " . count($errors) . " error: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= " dan " . (count($errors) - 3) . " error lainnya.";
                }
            }
            
            return redirect()->route('tu.siswa.index')->with('success', $message);
            
        } catch (\Exception $e) {
            return redirect()->route('tu.siswa.index')
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
    
    // Presensi Management
    public function presensiIndex(Request $request)
    {
        // Get all presensi with guru info - using pagination
        $query = \App\Models\Presensi::with('guru.user')
            ->orderByRaw("CASE WHEN status_verifikasi = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');
        
        // Paginate the results
        $allPresensi = $query->paginate(50)->withQueryString();
        
        // Get all presensi for statistics (without pagination)
        $presensiList = \App\Models\Presensi::with('guru.user')
            ->orderByRaw("CASE WHEN status_verifikasi = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Separate by jenis for backward compatibility (if needed for tabs) - use presensiList for statistics
        $presensiHadir = $presensiList->where('jenis', 'hadir');
        $presensiIzin = $presensiList->where('jenis', 'izin');
        $presensiSakit = $presensiList->where('jenis', 'sakit');
        
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
        
        // Count pending for each type (for badges) - use presensiList
        $pendingHadir = $presensiHadir->where('status_verifikasi', 'pending')->count();
        $pendingIzin = $presensiIzin->where('status_verifikasi', 'pending')->count();
        $pendingSakit = $presensiSakit->where('status_verifikasi', 'pending')->count();
        $totalPending = $presensiList->where('status_verifikasi', 'pending')->count();
        
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
    
    // Presensi Siswa Management
    public function presensiSiswaIndex(Request $request)
    {
        $selectedKelas = $request->get('kelas', '');
        $selectedTanggal = $request->get('tanggal', '');
        $selectedStatus = $request->get('status', '');
        $selectedGuru = $request->get('guru', '');
        $searchNama = $request->get('search', '');

        // Get all gurus from database
        $gurus = Guru::with('user')
            ->orderBy('nip')
            ->get();

        // Base query
        $query = PresensiSiswa::with(['siswa', 'guru.user'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($selectedKelas && $selectedKelas !== '') {
            // Ensure kelas is treated as string for comparison
            $kelasFilter = (string) $selectedKelas;
            $query->whereHas('siswa', function($q) use ($kelasFilter) {
                $q->where('kelas', $kelasFilter);
            });
        }

        if ($selectedTanggal && $selectedTanggal !== '') {
            $query->whereDate('tanggal', $selectedTanggal);
        }

        if ($selectedStatus && $selectedStatus !== '') {
            $query->where('status', $selectedStatus);
        }

        if ($selectedGuru && $selectedGuru !== '') {
            $query->where('guru_id', $selectedGuru);
        }

        if ($searchNama && $searchNama !== '') {
            $query->whereHas('siswa', function($q) use ($searchNama) {
                $q->where('nama', 'like', '%' . $searchNama . '%')
                  ->orWhere('nis', 'like', '%' . $searchNama . '%');
            });
        }

        $presensiSiswa = $query->paginate(50)->withQueryString();

        // Get statistics - apply same filters
        $statsQuery = PresensiSiswa::query();
        if ($selectedKelas && $selectedKelas !== '') {
            $kelasFilter = (string) $selectedKelas;
            $statsQuery->whereHas('siswa', function($q) use ($kelasFilter) {
                $q->where('kelas', $kelasFilter);
            });
        }
        if ($selectedTanggal && $selectedTanggal !== '') {
            $statsQuery->whereDate('tanggal', $selectedTanggal);
        }
        if ($selectedStatus && $selectedStatus !== '') {
            $statsQuery->where('status', $selectedStatus);
        }
        if ($selectedGuru && $selectedGuru !== '') {
            $statsQuery->where('guru_id', $selectedGuru);
        }
        
        $totalPresensi = $statsQuery->count();
        $presensiHadir = (clone $statsQuery)->where('status', 'hadir')->count();
        $presensiSakit = (clone $statsQuery)->where('status', 'sakit')->count();
        $presensiIzin = (clone $statsQuery)->where('status', 'izin')->count();
        $presensiAlfa = (clone $statsQuery)->where('status', 'alfa')->count();

        // Get presensi by kelas
        $presensiByKelas = [
            '7' => PresensiSiswa::whereHas('siswa', function($q) {
                $q->where('kelas', '7');
            })->count(),
            '8' => PresensiSiswa::whereHas('siswa', function($q) {
                $q->where('kelas', '8');
            })->count(),
            '9' => PresensiSiswa::whereHas('siswa', function($q) {
                $q->where('kelas', '9');
            })->count(),
        ];

        return view('tu.presensi-siswa.index', compact(
            'presensiSiswa',
            'selectedKelas',
            'selectedTanggal',
            'selectedStatus',
            'selectedGuru',
            'searchNama',
            'gurus',
            'totalPresensi',
            'presensiHadir',
            'presensiSakit',
            'presensiIzin',
            'presensiAlfa',
            'presensiByKelas'
        ));
    }

    public function presensiSiswaRekap(Request $request)
    {
        $selectedKelas = $request->get('kelas', '');
        $selectedBulan = $request->get('bulan', Carbon::now()->format('Y-m'));
        $selectedSiswa = $request->get('siswa_id', '');

        $bulan = Carbon::parse($selectedBulan . '-01');
        $startDate = $bulan->startOfMonth()->format('Y-m-d');
        $endDate = $bulan->endOfMonth()->format('Y-m-d');

        // Base query
        $query = PresensiSiswa::with(['siswa', 'guru.user'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($selectedKelas && $selectedKelas !== '') {
            // Ensure kelas is treated as string for comparison
            $kelasFilter = (string) $selectedKelas;
            $query->whereHas('siswa', function($q) use ($kelasFilter) {
                $q->where('kelas', $kelasFilter);
            });
        }

        if ($selectedSiswa) {
            $query->where('siswa_id', $selectedSiswa);
        }

        $presensiSiswa = $query->get();

        // Group by siswa for rekap
        $rekapBySiswa = $presensiSiswa->groupBy('siswa_id')->map(function($presensi) {
            $siswa = $presensi->first()->siswa;
            return [
                'siswa' => $siswa,
                'total' => $presensi->count(),
                'hadir' => $presensi->where('status', 'hadir')->count(),
                'sakit' => $presensi->where('status', 'sakit')->count(),
                'izin' => $presensi->where('status', 'izin')->count(),
                'alfa' => $presensi->where('status', 'alfa')->count(),
                'presensi' => $presensi,
            ];
        });

        // Get all siswa for filter
        $siswas = Siswa::when($selectedKelas && $selectedKelas !== '', function($q) use ($selectedKelas) {
            $kelasFilter = (string) $selectedKelas;
            $q->where('kelas', $kelasFilter);
        })->orderBy('nama')->get();

        return view('tu.presensi-siswa.rekap', compact(
            'rekapBySiswa',
            'selectedKelas',
            'selectedBulan',
            'selectedSiswa',
            'siswas',
            'bulan'
        ));
    }

    public function presensiSiswaExport(Request $request)
    {
        $selectedKelas = $request->get('kelas', '');
        $selectedBulan = $request->get('bulan', Carbon::now()->format('Y-m'));
        $type = $request->get('type', 'bulanan'); // bulanan, kelas, siswa

        $bulan = Carbon::parse($selectedBulan . '-01');
        $startDate = $bulan->startOfMonth()->format('Y-m-d');
        $endDate = $bulan->endOfMonth()->format('Y-m-d');

        // Base query
        $query = PresensiSiswa::with(['siswa', 'guru.user'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($selectedKelas) {
            $query->whereHas('siswa', function($q) use ($selectedKelas) {
                $q->where('kelas', $selectedKelas);
            });
        }

        $presensiSiswa = $query->get();

        // Generate CSV content
        $filename = 'rekap_presensi_siswa_' . $selectedBulan . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($presensiSiswa) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['NIS', 'Nama Siswa', 'Kelas', 'Tanggal', 'Status', 'Keterangan', 'Guru', 'Waktu Input']);
            
            // Data
            foreach ($presensiSiswa as $presensi) {
                fputcsv($file, [
                    $presensi->siswa->nis,
                    $presensi->siswa->nama,
                    $presensi->siswa->kelas,
                    $presensi->tanggal->format('d/m/Y'),
                    $presensi->status_label,
                    $presensi->keterangan ?? '-',
                    $presensi->guru->user->name,
                    $presensi->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
        $jadwals = Jadwal::with(['guru.user'])
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->paginate(50);
        
        // Log untuk debugging
        \Log::info('Jadwal Index - Total jadwals: ' . $jadwals->total());
        
        return view('tu.jadwal.index', compact('jadwals'));
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
    
    public function getMataPelajaranByGuru($guruId)
    {
        try {
            $guru = Guru::findOrFail($guruId);
            
            $mataPelajaranList = [];
            
            if ($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan') {
                $subjects = explode(', ', $guru->mata_pelajaran);
                foreach ($subjects as $subject) {
                    $mataPelajaranList[] = trim($subject);
                }
            }
            
            // Juga cek dari tabel guru_mata_pelajaran jika ada
            $guruMataPelajaran = \App\Models\GuruMataPelajaran::where('guru_id', $guruId)
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();
            
            foreach ($guruMataPelajaran as $gmp) {
                if (!in_array($gmp->mata_pelajaran, $mataPelajaranList)) {
                    $mataPelajaranList[] = $gmp->mata_pelajaran;
                }
            }
            
            return response()->json([
                'success' => true,
                'mata_pelajaran' => array_values(array_unique($mataPelajaranList))
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan',
                'mata_pelajaran' => []
            ], 404);
        }
    }
    
    public function jadwalStore(Request $request)
    {
        // Log request data for debugging
        \Log::info('Jadwal Store Request:', $request->all());

        $validated = $request->validate([
            'mata_pelajaran' => 'required|string',
            'guru' => 'required|string',
            'kelas' => 'required|string',
            'hari' => 'required|string',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'status' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'is_berulang' => 'nullable',
            'is_lab' => 'nullable',
            'is_lapangan' => 'nullable'
        ]);

        // Generate ruang berdasarkan kelas, is_lab, dan is_lapangan
        if ($request->has('is_lab')) {
            $ruang = 'Lab ' . ucfirst($request->mata_pelajaran);
        } elseif ($request->has('is_lapangan')) {
            $ruang = 'Lapangan';
        } else {
            $ruang = 'Ruang ' . $request->kelas;
        }

        try {
            // Simpan data jadwal ke database
            $jadwal = Jadwal::create([
            'mata_pelajaran' => $request->mata_pelajaran,
            'guru_id' => $request->guru,
            'kelas' => $request->kelas,
            'hari' => $request->hari,
                'tanggal' => $request->tanggal ?? null,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'status' => $request->status ?? 'aktif',
                'keterangan' => $request->keterangan ?? null,
                'is_berulang' => $request->has('is_berulang') ? true : false,
                'is_lab' => $request->has('is_lab') ? true : false,
                'is_lapangan' => $request->has('is_lapangan') ? true : false,
                'ruang' => $ruang,
                'created_by' => Auth::id()
            ]);

            if (!$jadwal) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan jadwal. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            \Log::error('Error saving jadwal: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan jadwal: ' . $e->getMessage());
        }

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
    
    public function jadwalEdit($id)
    {
        $jadwal = Jadwal::with(['guru.user'])->findOrFail($id);
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
        
        return view('tu.jadwal.edit', compact('jadwal', 'gurus', 'mataPelajaranList'));
    }
    
    public function jadwalUpdate(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        
        // Log request data for debugging
        \Log::info('Jadwal Update Request:', $request->all());

        $validated = $request->validate([
            'mata_pelajaran' => 'required|string',
            'guru' => 'required|string',
            'kelas' => 'required|string',
            'hari' => 'required|string',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'status' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'is_berulang' => 'nullable',
            'is_lab' => 'nullable',
            'is_lapangan' => 'nullable'
        ]);

        // Generate ruang berdasarkan kelas, is_lab, dan is_lapangan
        if ($request->has('is_lab')) {
            $ruang = 'Lab ' . ucfirst($request->mata_pelajaran);
        } elseif ($request->has('is_lapangan')) {
            $ruang = 'Lapangan';
        } else {
            $ruang = 'Ruang ' . $request->kelas;
        }

        try {
            // Update data jadwal
            $jadwal->update([
                'mata_pelajaran' => $request->mata_pelajaran,
                'guru_id' => $request->guru,
                'kelas' => $request->kelas,
                'hari' => $request->hari,
                'tanggal' => $request->tanggal ?? null,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'status' => $request->status ?? 'aktif',
                'keterangan' => $request->keterangan ?? null,
                'is_berulang' => $request->has('is_berulang') ? true : false,
                'is_lab' => $request->has('is_lab') ? true : false,
                'is_lapangan' => $request->has('is_lapangan') ? true : false,
                'ruang' => $ruang,
            ]);

            if (!$jadwal->wasChanged()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Tidak ada perubahan data.');
            }
        } catch (\Exception $e) {
            \Log::error('Error updating jadwal: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui jadwal: ' . $e->getMessage());
        }

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
            "Jadwal {$mataPelajaranText} untuk kelas " . strtoupper($request->kelas) . " berhasil diperbarui!"
        );
    }
    
    public function jadwalDestroy($id)
    {
        try {
            $jadwal = Jadwal::findOrFail($id);
            $mataPelajaranText = $jadwal->mata_pelajaran_nama;
            $kelas = $jadwal->kelas;
            
            $jadwal->delete();
            
            return redirect()->route('tu.jadwal.index')->with('success', 
                "Jadwal {$mataPelajaranText} untuk kelas " . strtoupper($kelas) . " berhasil dihapus!"
            );
        } catch (\Exception $e) {
            \Log::error('Error deleting jadwal: ' . $e->getMessage());
            return redirect()->route('tu.jadwal.index')->with('error', 
                'Terjadi kesalahan saat menghapus jadwal: ' . $e->getMessage()
            );
        }
    }
    
    /**
     * Download template Excel untuk import jadwal
     */
    public function jadwalDownloadTemplate()
    {
        // Check if Excel package is available
        if (!class_exists('Maatwebsite\Excel\Facades\Excel')) {
            return redirect()->route('tu.jadwal.index')
                ->with('error', 'Fitur import Excel sedang dalam maintenance. Silakan gunakan input manual.');
        }
        
        // Check if export class exists
        $exportFile = app_path('Exports/JadwalTemplateExport.php');
        if (!file_exists($exportFile)) {
            return redirect()->route('tu.jadwal.index')
                ->with('error', 'Template Excel sedang dalam proses instalasi. Silakan coba lagi nanti.');
        }
        
        try {
            $excelClass = \Maatwebsite\Excel\Facades\Excel::class;
            $templateClass = \App\Exports\JadwalTemplateExport::class;
            
            return $excelClass::download(new $templateClass, 'template_jadwal_pelajaran.xlsx');
        } catch (\Exception $e) {
            \Log::error('Error downloading template: ' . $e->getMessage());
            return redirect()->route('tu.jadwal.index')
                ->with('error', 'Gagal mendownload template. Silakan hubungi administrator.');
        }
    }
    
    /**
     * Import jadwal dari file Excel
     */
    public function jadwalImportExcel(Request $request)
    {
        // Check if Excel package is available
        if (!class_exists('Maatwebsite\Excel\Facades\Excel')) {
            return redirect()->route('tu.jadwal.index')
                ->with('error', 'Fitur import Excel sedang dalam maintenance. Silakan gunakan input manual.');
        }
        
        // Check if import class exists
        $importFile = app_path('Imports/JadwalImport.php');
        if (!file_exists($importFile)) {
            return redirect()->route('tu.jadwal.index')
                ->with('error', 'Fitur import sedang dalam proses instalasi. Silakan coba lagi nanti.');
        }
        
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048',
            'semester' => 'nullable|string',
            'tahun_ajaran' => 'nullable|string',
        ]);

        try {
            $semester = $request->semester ?? '1';
            $tahunAjaran = $request->tahun_ajaran ?? '2025/2026';
            
            $importClass = \App\Imports\JadwalImport::class;
            $excelClass = \Maatwebsite\Excel\Facades\Excel::class;
            
            $import = new $importClass(Auth::id(), $semester, $tahunAjaran);
            $excelClass::import($import, $request->file('excel_file'));
            
            // Count imported jadwal
            $imported = Jadwal::where('created_by', Auth::id())
                ->where('created_at', '>=', now()->subMinutes(1))
                ->count();
            
            return redirect()->route('tu.jadwal.index')
                ->with('success', "Berhasil mengimport {$imported} jadwal pelajaran!");
        } catch (\Exception $e) {
            \Log::error('Error importing jadwal: ' . $e->getMessage());
            return redirect()->route('tu.jadwal.index')
                ->with('error', 'Gagal mengimport jadwal: ' . $e->getMessage());
        }
    }
    
    /**
     * Export jadwal ke Excel
     */
    public function jadwalExport(Request $request)
    {
        $kelas = $request->get('kelas', '');
        $hari = $request->get('hari', '');
        
        $query = Jadwal::with(['guru.user'])
            ->orderBy('hari')
            ->orderBy('jam_mulai');
        
        if ($kelas) {
            $query->where('kelas', $kelas);
        }
        
        if ($hari) {
            $query->where('hari', $hari);
        }
        
        $jadwals = $query->get();
        
        // Generate CSV content
        $filename = 'jadwal_pelajaran_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($jadwals) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Mata Pelajaran', 'Nama Guru', 'Kelas', 'Hari', 'Waktu', 'Ruang', 'Status', 'Keterangan']);
            
            // Data
            foreach ($jadwals as $jadwal) {
                fputcsv($file, [
                    $jadwal->mata_pelajaran_nama,
                    $jadwal->guru->user->name ?? 'N/A',
                    $jadwal->kelas,
                    $jadwal->hari_nama,
                    date('H:i', strtotime($jadwal->jam_mulai)) . ' - ' . date('H:i', strtotime($jadwal->jam_selesai)),
                    $jadwal->ruang ?? 'Ruang ' . $jadwal->kelas,
                    ucfirst($jadwal->status),
                    $jadwal->keterangan ?? '',
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    // Kalender Management
    public function kalenderIndex()
    {
        // Get current year
        $currentYear = now()->year;
        $nextYear = $currentYear + 1;
        
        // DISABLED: Generate hari libur nasional dan internasional
        // Fokus hanya pada event yang dibuat oleh sekolah
        // $events = $this->generateHolidayEvents($currentYear);
        
        // DISABLED: Add events for next year (for December navigation)
        // $events = array_merge($events, $this->generateHolidayEvents($nextYear));
        
        // Initialize empty events array
        $events = [];
        
        // Get custom events from database
        // Ambil SEMUA event yang relevan (public atau milik user yang login)
        // Tidak ada filter tahun - ambil semua event untuk memastikan tidak ada yang terlewat
        $prevYear = $currentYear - 1; // Definisikan $prevYear untuk logging
        
        // Ambil semua event tanpa filter apapun - pastikan semua event ditampilkan
        $dbEvents = Event::where(function($query) {
                // Tampilkan event public ATAU event milik user yang login
                $query->where('is_public', true)
                      ->orWhere('created_by', Auth::id());
            })
            ->orderBy('tanggal_mulai', 'asc')
            ->get();
        
        // Pastikan semua event diambil - tidak ada filter kategori atau tahun
        // Semua kategori event harus ditampilkan: ujian, akademik, libur, rapat, pelatihan, kegiatan, pengumuman, lainnya
        
        // Log semua event yang ditemukan
        \Log::info('=== CALENDAR EVENTS DEBUG ===');
        \Log::info('Current Year: ' . $currentYear);
        \Log::info('Next Year: ' . $nextYear);
        \Log::info('Previous Year: ' . $prevYear);
        \Log::info('Total Events Found: ' . $dbEvents->count());
        \Log::info('Auth User ID: ' . Auth::id());
        
        // Get events for current month (for "Daftar Event Bulan Ini")
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $eventsThisMonth = Event::where(function($query) {
                $query->where('is_public', true)
                      ->orWhere('created_by', Auth::id());
            })
            ->whereYear('tanggal_mulai', $currentYear)
            ->whereMonth('tanggal_mulai', $currentMonth)
            ->orderBy('tanggal_mulai', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->get();
        
        // Log untuk debugging
        \Log::info('Events found in database: ' . $dbEvents->count());
        foreach ($dbEvents as $event) {
            \Log::info('Event: ' . $event->judul_event . ' - Kategori: ' . $event->kategori_event . ' - Tanggal: ' . $event->tanggal_mulai . ' - Warna: ' . ($event->warna ?? 'NULL') . ' - is_public: ' . ($event->is_public ? 'true' : 'false'));
        }
        
        // Convert database events to calendar format
        // Pastikan SEMUA event ditampilkan tanpa exception
        foreach ($dbEvents as $dbEvent) {
            try {
                // Gunakan warna yang sudah dipilih user saat membuat event
                // Jika tidak ada warna, baru gunakan default berdasarkan kategori
                // CATATAN: Libur nasional/internasional dari generateHolidayEvents sudah menggunakan #2E7D32
                // dan tidak akan di-override di sini karena mereka memiliki ID >= 1000
                $defaultColorMap = [
                    'libur' => '#ffc107',      // Kuning untuk libur custom (bukan nasional/internasional)
                    'ujian' => '#dc3545',      // Merah untuk ujian
                    'akademik' => '#007bff',   // Biru untuk akademik
                    'rapat' => '#17a2b8',      // Cyan untuk rapat
                    'pelatihan' => '#9c27b0',  // Ungu untuk pelatihan
                    'kegiatan' => '#fd7e14',   // Orange untuk kegiatan
                    'pengumuman' => '#D2B48C', // Cokelat muda untuk pengumuman
                    'lainnya' => '#6c757d',    // Abu-abu untuk lainnya
                ];
                
                // SELALU gunakan warna berdasarkan kategori untuk memastikan konsistensi
                // Ini memastikan event yang sudah ada juga menggunakan warna yang benar sesuai kategori
                $kategoriLower = strtolower($dbEvent->kategori_event ?? 'lainnya');
                $eventWarna = $defaultColorMap[$kategoriLower] ?? '#6c757d';
                
                // Log untuk debugging
                \Log::info('Event warna - Kategori: ' . $kategoriLower . ' - Warna yang digunakan: ' . $eventWarna . ' - Warna di DB: ' . ($dbEvent->warna ?? 'NULL'));
                
                // Pastikan format tanggal benar
                $tanggalMulai = $dbEvent->tanggal_mulai instanceof \Carbon\Carbon 
                    ? $dbEvent->tanggal_mulai->format('Y-m-d')
                    : date('Y-m-d', strtotime($dbEvent->tanggal_mulai));
                
                $tanggalSelesai = null;
                if ($dbEvent->tanggal_selesai) {
                    $tanggalSelesai = $dbEvent->tanggal_selesai instanceof \Carbon\Carbon
                        ? $dbEvent->tanggal_selesai->format('Y-m-d')
                        : date('Y-m-d', strtotime($dbEvent->tanggal_selesai));
                }
                
                // Pastikan semua field ada dan valid
                $events[] = [
                    'id' => $dbEvent->id ?? 0,
                    'judul' => $dbEvent->judul_event ?? 'Event',
                    'tanggal' => $tanggalMulai,
                    'tanggal_selesai' => $tanggalSelesai,
                    'kategori' => ucfirst($dbEvent->kategori_event ?? 'lainnya'),
                    'warna' => $eventWarna, // Gunakan warna yang dipilih user saat membuat event
                    'deskripsi' => $dbEvent->deskripsi ?? null,
                    'lokasi' => $dbEvent->lokasi ?? null,
                    'waktu_mulai' => $dbEvent->waktu_mulai ? $dbEvent->waktu_mulai : null,
                    'waktu_selesai' => $dbEvent->waktu_selesai ? $dbEvent->waktu_selesai : null,
                    'is_all_day' => $dbEvent->is_all_day ?? false,
                    'penanggung_jawab' => $dbEvent->penanggung_jawab ?? null,
                ];
                
                // Log setiap event yang ditambahkan
                \Log::info('Event added to calendar: ' . ($dbEvent->judul_event ?? 'Unknown') . ' - Kategori: ' . ($dbEvent->kategori_event ?? 'Unknown') . ' - Tanggal: ' . $tanggalMulai . ' - Warna: ' . $eventWarna);
            } catch (\Exception $e) {
                // Jika ada error pada event tertentu, log dan lanjutkan ke event berikutnya
                \Log::error('Error processing event ID ' . ($dbEvent->id ?? 'unknown') . ': ' . $e->getMessage());
                continue;
            }
        }
        
        // Log total events yang akan dikirim ke view
        \Log::info('Total events to display: ' . count($events));
        \Log::info('Holiday events: ' . (count($events) - $dbEvents->count()));
        \Log::info('Database events: ' . $dbEvents->count());
        
        return view('tu.kalender.index', compact('events', 'eventsThisMonth'));
    }
    
    /**
     * Generate holiday events for a given year
     */
    private function generateHolidayEvents($year)
    {
        $events = [];
        
        // Fixed date holidays - Libur Nasional Indonesia & Internasional
        $fixedHolidays = [
            // ========== JANUARI ==========
            ['tanggal' => "$year-01-01", 'judul' => 'Tahun Baru Masehi', 'kategori' => 'Libur'],
            
            // ========== FEBRUARI ==========
            ['tanggal' => "$year-02-14", 'judul' => 'Valentine Day', 'kategori' => 'Libur'],
            
            // ========== MARET ==========
            ['tanggal' => "$year-03-17", 'judul' => 'Hari Raya Nyepi (Tahun Baru Saka)', 'kategori' => 'Libur'],
            ['tanggal' => "$year-03-08", 'judul' => 'Hari Perempuan Internasional', 'kategori' => 'Libur'],
            
            // ========== APRIL ==========
            ['tanggal' => "$year-04-21", 'judul' => 'Hari Kartini', 'kategori' => 'Libur'],
            ['tanggal' => "$year-04-22", 'judul' => 'Hari Bumi Internasional', 'kategori' => 'Libur'],
            ['tanggal' => "$year-04-25", 'judul' => 'Hari Otonomi Daerah', 'kategori' => 'Libur'],
            
            // ========== MEI ==========
            ['tanggal' => "$year-05-01", 'judul' => 'Hari Buruh Internasional', 'kategori' => 'Libur'],
            ['tanggal' => "$year-05-02", 'judul' => 'Hari Pendidikan Nasional', 'kategori' => 'Libur'],
            ['tanggal' => "$year-05-20", 'judul' => 'Hari Kebangkitan Nasional', 'kategori' => 'Libur'],
            
            // ========== JUNI ==========
            ['tanggal' => "$year-06-01", 'judul' => 'Hari Lahir Pancasila & Hari Anak Internasional', 'kategori' => 'Libur'],
            ['tanggal' => "$year-06-05", 'judul' => 'Hari Lingkungan Hidup Sedunia', 'kategori' => 'Libur'],
            ['tanggal' => "$year-06-26", 'judul' => 'Hari Anti Narkoba Internasional', 'kategori' => 'Libur'],
            
            // ========== JULI ==========
            ['tanggal' => "$year-07-17", 'judul' => 'Hari Anak Nasional', 'kategori' => 'Libur'],
            ['tanggal' => "$year-07-04", 'judul' => 'Hari Kemerdekaan Amerika', 'kategori' => 'Libur'],
            
            // ========== AGUSTUS ==========
            ['tanggal' => "$year-08-17", 'judul' => 'Hari Kemerdekaan Republik Indonesia', 'kategori' => 'Libur'],
            ['tanggal' => "$year-08-14", 'judul' => 'Hari Pramuka', 'kategori' => 'Libur'],
            
            // ========== SEPTEMBER ==========
            ['tanggal' => "$year-09-09", 'judul' => 'Hari Olahraga Nasional', 'kategori' => 'Libur'],
            ['tanggal' => "$year-09-21", 'judul' => 'Hari Perdamaian Internasional', 'kategori' => 'Libur'],
            
            // ========== OKTOBER ==========
            ['tanggal' => "$year-10-01", 'judul' => 'Hari Kesaktian Pancasila', 'kategori' => 'Libur'],
            ['tanggal' => "$year-10-02", 'judul' => 'Hari Batik Nasional', 'kategori' => 'Libur'],
            ['tanggal' => "$year-10-05", 'judul' => 'Hari Guru Sedunia', 'kategori' => 'Libur'],
            ['tanggal' => "$year-10-28", 'judul' => 'Hari Sumpah Pemuda', 'kategori' => 'Libur'],
            
            // ========== NOVEMBER ==========
            ['tanggal' => "$year-11-10", 'judul' => 'Hari Pahlawan', 'kategori' => 'Libur'],
            ['tanggal' => "$year-11-11", 'judul' => 'Hari Pahlawan Internasional', 'kategori' => 'Libur'],
            ['tanggal' => "$year-11-25", 'judul' => 'Hari Guru Nasional', 'kategori' => 'Libur'],
            
            // ========== DESEMBER ==========
            ['tanggal' => "$year-12-10", 'judul' => 'Hari Hak Asasi Manusia', 'kategori' => 'Libur'],
            ['tanggal' => "$year-12-22", 'judul' => 'Hari Ibu', 'kategori' => 'Libur'],
            ['tanggal' => "$year-12-24", 'judul' => 'Malam Natal', 'kategori' => 'Libur'],
            ['tanggal' => "$year-12-25", 'judul' => 'Hari Natal', 'kategori' => 'Libur'],
            ['tanggal' => "$year-12-26", 'judul' => 'Libur Natal', 'kategori' => 'Libur'],
            ['tanggal' => "$year-12-31", 'judul' => 'Malam Tahun Baru', 'kategori' => 'Libur'],
        ];
        
        // Add Chinese New Year (Imlek) - approximate dates
        $imlekDates = $this->getChineseNewYear($year);
        if ($imlekDates) {
            $fixedHolidays = array_merge($fixedHolidays, $imlekDates);
        }
        
        // Add Waisak (Buddha) - approximate dates
        $waisakDates = $this->getWaisak($year);
        if ($waisakDates) {
            $fixedHolidays = array_merge($fixedHolidays, $waisakDates);
        }
        
        // Calculate Islamic holidays (approximate, as they follow lunar calendar)
        // These dates are approximate for 2024-2025
        $islamicHolidays = $this->getIslamicHolidays($year);
        
        // Combine all holidays
        $allHolidays = array_merge($fixedHolidays, $islamicHolidays);
        
        // Color mapping based on category
        $colorMap = [
            'Libur' => '#2E7D32',      // Hijau tua untuk libur nasional/internasional
            'Ujian' => '#dc3545',      // Merah untuk ujian
            'Akademik' => '#007bff',   // Biru untuk akademik
            'Rapat' => '#17a2b8',      // Cyan untuk rapat
            'Pelatihan' => '#ffc107',  // Kuning untuk pelatihan
            'Kegiatan' => '#fd7e14',   // Orange untuk kegiatan
            'Pengumuman' => '#17a2b8', // Cyan untuk pengumuman
        ];
        
        // Convert to events format
        foreach ($allHolidays as $index => $holiday) {
            $events[] = [
                'id' => $index + 1000, // Use high ID to avoid conflict with custom events
                'judul' => $holiday['judul'],
                'tanggal' => $holiday['tanggal'],
                'kategori' => $holiday['kategori'],
                'warna' => $colorMap[$holiday['kategori']] ?? '#6c757d' // Default abu-abu
            ];
        }
        
        return $events;
    }
    
    /**
     * Get Islamic holidays (approximate dates)
     */
    private function getIslamicHolidays($year)
    {
        $holidays = [];
        
        // Approximate dates for Islamic holidays (these vary each year)
        // For 2024-2025, these are approximate
        if ($year == 2024) {
            $holidays = [
                ['tanggal' => "$year-03-11", 'judul' => 'Hari Raya Idul Fitri', 'kategori' => 'Libur'],
                ['tanggal' => "$year-03-12", 'judul' => 'Hari Raya Idul Fitri', 'kategori' => 'Libur'],
                ['tanggal' => "$year-06-16", 'judul' => 'Hari Raya Idul Adha', 'kategori' => 'Libur'],
                ['tanggal' => "$year-07-07", 'judul' => 'Tahun Baru Islam', 'kategori' => 'Libur'],
                ['tanggal' => "$year-09-15", 'judul' => 'Maulid Nabi Muhammad SAW', 'kategori' => 'Libur'],
                ['tanggal' => "$year-03-10", 'judul' => 'Isra Miraj', 'kategori' => 'Libur'],
            ];
        } elseif ($year == 2025) {
            $holidays = [
                ['tanggal' => "$year-03-01", 'judul' => 'Hari Raya Idul Fitri', 'kategori' => 'Libur'],
                ['tanggal' => "$year-03-02", 'judul' => 'Hari Raya Idul Fitri', 'kategori' => 'Libur'],
                ['tanggal' => "$year-06-06", 'judul' => 'Hari Raya Idul Adha', 'kategori' => 'Libur'],
                ['tanggal' => "$year-06-27", 'judul' => 'Tahun Baru Islam', 'kategori' => 'Libur'],
                ['tanggal' => "$year-09-05", 'judul' => 'Maulid Nabi Muhammad SAW', 'kategori' => 'Libur'],
                ['tanggal' => "$year-02-28", 'judul' => 'Isra Miraj', 'kategori' => 'Libur'],
            ];
        } else {
            // Default approximate dates for other years
            $holidays = [
                ['tanggal' => "$year-03-10", 'judul' => 'Hari Raya Idul Fitri', 'kategori' => 'Libur'],
                ['tanggal' => "$year-03-11", 'judul' => 'Hari Raya Idul Fitri', 'kategori' => 'Libur'],
                ['tanggal' => "$year-06-16", 'judul' => 'Hari Raya Idul Adha', 'kategori' => 'Libur'],
                ['tanggal' => "$year-07-07", 'judul' => 'Tahun Baru Islam', 'kategori' => 'Libur'],
                ['tanggal' => "$year-09-15", 'judul' => 'Maulid Nabi Muhammad SAW', 'kategori' => 'Libur'],
            ];
        }
        
        return $holidays;
    }
    
    /**
     * Get Chinese New Year (Imlek) dates - approximate
     */
    private function getChineseNewYear($year)
    {
        // Approximate dates for Chinese New Year (varies each year)
        $imlekDates = [
            2024 => ['tanggal' => '2024-02-10', 'judul' => 'Hari Raya Imlek (Tahun Baru Cina)', 'kategori' => 'Libur'],
            2025 => ['tanggal' => '2025-01-29', 'judul' => 'Hari Raya Imlek (Tahun Baru Cina)', 'kategori' => 'Libur'],
            2026 => ['tanggal' => '2026-02-17', 'judul' => 'Hari Raya Imlek (Tahun Baru Cina)', 'kategori' => 'Libur'],
        ];
        
        if (isset($imlekDates[$year])) {
            return [$imlekDates[$year]];
        }
        
        // Default approximate date (late January to mid February)
        return [['tanggal' => "$year-02-01", 'judul' => 'Hari Raya Imlek (Tahun Baru Cina)', 'kategori' => 'Libur']];
    }
    
    /**
     * Get Waisak (Buddha) dates - approximate
     */
    private function getWaisak($year)
    {
        // Approximate dates for Waisak (varies each year, usually in May)
        $waisakDates = [
            2024 => ['tanggal' => '2024-05-23', 'judul' => 'Hari Raya Waisak', 'kategori' => 'Libur'],
            2025 => ['tanggal' => '2025-05-12', 'judul' => 'Hari Raya Waisak', 'kategori' => 'Libur'],
            2026 => ['tanggal' => '2026-05-01', 'judul' => 'Hari Raya Waisak', 'kategori' => 'Libur'],
        ];
        
        if (isset($waisakDates[$year])) {
            return [$waisakDates[$year]];
        }
        
        // Default approximate date (usually in May)
        return [['tanggal' => "$year-05-15", 'judul' => 'Hari Raya Waisak', 'kategori' => 'Libur']];
    }
    
    public function kalenderCreate(Request $request)
    {
        // Jika ada parameter kategori, kirim ke view
        $kategori = $request->get('kategori', '');
        
        // Get all users untuk dropdown penanggung jawab
        // Note: users table tidak punya kolom 'status', jadi tidak perlu filter status
        $users = User::whereIn('role', ['tu', 'guru', 'kepala_sekolah'])
            ->orderBy('role')
            ->orderBy('name')
            ->get();
        
        return view('tu.kalender.create', compact('kategori', 'users'));
    }
    
    public function kalenderStore(Request $request)
    {
        $request->validate([
            'judul_event' => 'required|string|max:255',
            'kategori_event' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'warna' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', // max 5MB
            'is_all_day' => 'nullable|boolean',
            'is_public' => 'nullable|boolean',
            'is_important' => 'nullable|boolean',
            'is_recurring' => 'nullable|boolean'
        ]);

        try {
            // Log request data untuk debugging
            \Log::info('Creating event with data:', [
                'judul_event' => $request->judul_event,
                'kategori_event' => $request->kategori_event,
                'tanggal_mulai' => $request->tanggal_mulai,
                'warna' => $request->warna,
                'is_public' => $request->input('is_public', 0),
            ]);
            
            // Tentukan warna berdasarkan kategori jika tidak ada
            $colorMap = [
                'libur' => '#ffc107',      // Kuning untuk libur
                'ujian' => '#dc3545',      // Merah untuk ujian
                'akademik' => '#007bff',   // Biru untuk akademik
                'rapat' => '#17a2b8',      // Cyan untuk rapat
                'pelatihan' => '#9c27b0',  // Ungu untuk pelatihan
                'kegiatan' => '#fd7e14',   // Orange untuk kegiatan
                'pengumuman' => '#D2B48C', // Cokelat muda untuk pengumuman
                'lainnya' => '#6c757d',    // Abu-abu untuk lainnya
            ];
            
            $warnaEvent = $request->warna;
            if (empty($warnaEvent) || $warnaEvent == '#6c757d' || $warnaEvent == null) {
                $warnaEvent = $colorMap[strtolower($request->kategori_event)] ?? '#6c757d';
            }
            
            // Handle foto upload
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/events', $filename);
                $fotoPath = 'events/' . $filename;
            }
            
            // Simpan data event ke database
            $event = Event::create([
            'judul_event' => $request->judul_event,
            'kategori_event' => $request->kategori_event,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal_mulai,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'penanggung_jawab' => $request->penanggung_jawab,
                'warna' => $warnaEvent, // Gunakan warna yang sudah ditentukan
                'foto' => $fotoPath,
                'is_all_day' => $request->input('is_all_day', 0) == 1,
                'is_public' => $request->input('is_public', 0) == 1,
                'is_important' => $request->input('is_important', 0) == 1,
                'is_recurring' => $request->input('is_recurring', 0) == 1,
                'created_by' => Auth::id()
            ]);

            \Log::info('Event created successfully:', [
                'id' => $event->id,
                'judul_event' => $event->judul_event,
                'kategori_event' => $event->kategori_event,
                'tanggal_mulai' => $event->tanggal_mulai,
                'warna' => $event->warna,
                'is_public' => $event->is_public,
            ]);

            if (!$event) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan event. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            \Log::error('Error saving event: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan event: ' . $e->getMessage());
        }

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

        $successMessage = "Event '{$request->judul_event}' berhasil ditambahkan ke kategori {$kategoriText}!";
        if ($request->hasFile('foto')) {
            $successMessage .= " Foto event berhasil di-upload.";
        }

        // Semua event yang dibuat akan muncul di halaman pengumuman
        // Redirect ke halaman pengumuman untuk semua kategori
        return redirect()->route('tu.pengumuman.index')->with('success', $successMessage);
    }
    
    public function kalenderFotoDownload($id)
    {
        $event = Event::findOrFail($id);
        
        if (!$event->foto) {
            abort(404, 'Foto tidak ditemukan');
        }
        
        $filePath = storage_path('app/public/' . $event->foto);
        
        if (!file_exists($filePath)) {
            abort(404, 'File foto tidak ditemukan');
        }
        
        $fileName = 'foto_event_' . $event->id . '_' . basename($event->foto);
        
        return response()->download($filePath, $fileName);
    }
    
    public function kalenderShow($id)
    {
        try {
            $event = Event::findOrFail($id);
            return view('tu.kalender.show', compact('event'));
        } catch (\Exception $e) {
            return redirect()->route('tu.kalender.list')
                ->with('error', 'Event tidak ditemukan.');
        }
    }
    
    public function kalenderEdit($id)
    {
        try {
            $event = Event::findOrFail($id);
            
            // Pastikan user hanya bisa edit event miliknya atau event public
            if ($event->created_by != Auth::id() && !$event->is_public) {
                return redirect()->route('tu.kalender.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengedit event ini.');
            }
            
            return view('tu.kalender.edit', compact('event'));
        } catch (\Exception $e) {
            \Log::error('Error loading event for edit: ' . $e->getMessage());
            return redirect()->route('tu.kalender.index')
                ->with('error', 'Event tidak ditemukan.');
        }
    }
    
    public function kalenderUpdate(Request $request, $id)
    {
        $request->validate([
            'judul_event' => 'required|string|max:255',
            'kategori_event' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->waktu_mulai && $value <= $request->waktu_mulai) {
                        $fail('Waktu selesai harus setelah waktu mulai.');
                    }
                }
            ],
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'warna' => 'nullable|string',
            'is_all_day' => 'nullable|boolean',
            'is_public' => 'nullable|boolean',
            'is_important' => 'nullable|boolean',
            'is_recurring' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10240', // max 10MB
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus: JPEG, JPG, PNG, atau GIF.',
            'foto.max' => 'Ukuran foto maksimal 10MB.',
        ]);

        try {
            $event = Event::findOrFail($id);
            
            // Pastikan user hanya bisa update event miliknya atau event public
            if ($event->created_by != Auth::id() && !$event->is_public) {
                return redirect()->route('tu.kalender.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengupdate event ini.');
            }
            
            // Tentukan warna berdasarkan kategori jika tidak ada
            $colorMap = [
                'libur' => '#ffc107',
                'ujian' => '#dc3545',
                'akademik' => '#007bff',
                'rapat' => '#17a2b8',
                'pelatihan' => '#9c27b0',
                'kegiatan' => '#fd7e14',
                'pengumuman' => '#D2B48C',
                'lainnya' => '#6c757d',
            ];
            
            $warnaEvent = $request->warna;
            if (empty($warnaEvent) || $warnaEvent == '#6c757d' || $warnaEvent == null) {
                $warnaEvent = $colorMap[strtolower($request->kategori_event)] ?? '#6c757d';
            }
            
            // Handle foto upload
            $fotoPath = $event->foto; // Keep existing foto
            $fotoUploaded = false;
            
            if ($request->hasFile('foto')) {
                \Log::info('=== START FOTO UPLOAD ===');
                \Log::info('Event ID: ' . $event->id);
                \Log::info('Event Judul: ' . $event->judul_event);
                
                $file = $request->file('foto');
                \Log::info('File original name: ' . $file->getClientOriginalName());
                \Log::info('File size: ' . $file->getSize() . ' bytes');
                \Log::info('File mime type: ' . $file->getMimeType());
                
                try {
                    // Delete old foto if exists
                    if ($event->foto && \Storage::disk('public')->exists($event->foto)) {
                        \Log::info('Deleting old foto: ' . $event->foto);
                        \Storage::disk('public')->delete($event->foto);
                    }
                    
                    // Upload new foto
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    \Log::info('New filename: ' . $filename);
                    
                    // Store file
                    $stored = $file->storeAs('events', $filename, 'public');
                    \Log::info('File stored at: ' . $stored);
                    
                    $fotoPath = 'events/' . $filename;
                    $fotoUploaded = true;
                    
                    \Log::info('✅ Foto uploaded successfully!');
                    \Log::info('Foto path to save in DB: ' . $fotoPath);
                    
                    // Verify file exists
                    $fullPath = storage_path('app/public/' . $fotoPath);
                    if (file_exists($fullPath)) {
                        \Log::info('✅ File verified exists at: ' . $fullPath);
                    } else {
                        \Log::error('❌ File NOT found at: ' . $fullPath);
                    }
                } catch (\Exception $e) {
                    \Log::error('❌ Error uploading foto: ' . $e->getMessage());
                    \Log::error('Stack trace: ' . $e->getTraceAsString());
                    throw $e;
                }
            } else {
                \Log::info('No new foto uploaded for event ID: ' . $event->id);
            }
            
            $event->update([
                'judul_event' => $request->judul_event,
                'kategori_event' => $request->kategori_event,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'deskripsi' => $request->deskripsi,
                'lokasi' => $request->lokasi,
                'penanggung_jawab' => $request->penanggung_jawab,
                'warna' => $warnaEvent,
                'is_all_day' => $request->input('is_all_day', 0) == 1,
                'is_public' => $request->input('is_public', 0) == 1,
                'is_important' => $request->input('is_important', 0) == 1,
                'is_recurring' => $request->input('is_recurring', 0) == 1,
                'foto' => $fotoPath,
            ]);
            
            // Refresh model to get latest data from database
            $event->refresh();
            
            \Log::info('=== EVENT UPDATED IN DATABASE ===');
            \Log::info('Event ID: ' . $event->id);
            \Log::info('Foto in DB: ' . ($event->foto ?? 'NULL'));
            \Log::info('Foto uploaded flag: ' . ($fotoUploaded ? 'YES' : 'NO'));
            
            if ($event->foto) {
                $fullPath = storage_path('app/public/' . $event->foto);
                \Log::info('Full path: ' . $fullPath);
                \Log::info('File exists: ' . (file_exists($fullPath) ? 'YES' : 'NO'));
            }

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

            $successMessage = "Event '{$request->judul_event}' berhasil diperbarui!";
            if ($request->hasFile('foto')) {
                $successMessage = "✅ Foto event berhasil ditambahkan! Event '{$request->judul_event}' telah diperbarui.";
            }

            return redirect()->route('tu.kalender.show', $event->id)->with('success', $successMessage);
        } catch (\Exception $e) {
            \Log::error('Error updating event: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Pesan error yang lebih user-friendly
            $errorMessage = 'Terjadi kesalahan saat memperbarui event.';
            
            // Cek apakah error terkait upload foto
            if ($request->hasFile('foto')) {
                $errorMessage = 'Gagal mengupload foto. Pastikan:
                    • File adalah gambar (JPEG, PNG, GIF)
                    • Ukuran maksimal 10MB
                    • Directory storage dapat ditulis
                    Detail error: ' . $e->getMessage();
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }
    
    public function kalenderDestroy($id)
    {
        try {
            $event = Event::findOrFail($id);
            
            // Pastikan user hanya bisa delete event miliknya atau event public
            if ($event->created_by != Auth::id() && !$event->is_public) {
                return redirect()->route('tu.kalender.list')
                    ->with('error', 'Anda tidak memiliki akses untuk menghapus event ini.');
            }
            
            $judulEvent = $event->judul_event;
            $event->delete();

            return redirect()->route('tu.kalender.list')->with('success', 
                "Event '{$judulEvent}' berhasil dihapus!"
            );
        } catch (\Exception $e) {
            \Log::error('Error deleting event: ' . $e->getMessage());
            return redirect()->route('tu.kalender.list')->with('error', 
                'Terjadi kesalahan saat menghapus event: ' . $e->getMessage()
            );
        }
    }
    
    public function kalenderList()
    {
        try {
            // Ambil semua event yang bisa diakses user (public atau milik user) - dengan pagination
            $events = Event::where(function($query) {
                $query->where('is_public', true)
                      ->orWhere('created_by', Auth::id());
            })
            ->with('creator')
            ->orderBy('tanggal_mulai', 'desc')
            ->orderBy('waktu_mulai', 'asc')
            ->paginate(50)->withQueryString();
            
            return view('tu.kalender.list', compact('events'));
        } catch (\Exception $e) {
            \Log::error('Error loading event list: ' . $e->getMessage());
            return redirect()->route('tu.kalender.index')
                ->with('error', 'Terjadi kesalahan saat memuat daftar event.');
        }
    }
    
    // Arsip Management
    public function arsipIndex()
    {
        try {
            // Ambil semua arsip yang bisa diakses user (public atau milik user) - dengan pagination
            $arsips = Arsip::where(function($query) {
                    $query->where('is_public', true)
                          ->orWhere('created_by', Auth::id());
                })
                ->with('creator')
                ->orderBy('created_at', 'desc')
                ->paginate(50)->withQueryString();
            
            \Log::info('Arsip loaded:', [
                'count' => $arsips->total(),
                'user_id' => Auth::id()
            ]);
            
            return view('tu.arsip.index', compact('arsips'));
        } catch (\Exception $e) {
            \Log::error('Error loading arsip: ' . $e->getMessage());
            return view('tu.arsip.index', ['arsips' => collect()]);
        }
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
            'is_public' => $request->input('is_public', 0) == 1,
            'is_important' => $request->input('is_important', 0) == 1,
            'created_by' => Auth::id()
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

        try {
            // Simpan ke database
            $arsip = Arsip::create($arsipData);
            
            \Log::info('Arsip created successfully:', [
                'id' => $arsip->id,
                'judul_dokumen' => $arsip->judul_dokumen,
                'kategori' => $arsip->kategori,
                'file_dokumen' => $arsip->file_dokumen,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saving arsip: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan dokumen: ' . $e->getMessage());
        }

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
            "Dokumen '{$request->judul_dokumen}' berhasil disimpan ke kategori {$kategoriText}!"
        );
    }
    
    public function arsipEdit($id)
    {
        try {
            $arsip = Arsip::findOrFail($id);
            
            // Pastikan user hanya bisa edit arsip miliknya atau arsip public
            if ($arsip->created_by != Auth::id() && !$arsip->is_public) {
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengedit dokumen ini.');
            }
            
            return view('tu.arsip.edit', compact('arsip'));
        } catch (\Exception $e) {
            \Log::error('Error loading arsip for edit: ' . $e->getMessage());
            return redirect()->route('tu.arsip.index')
                ->with('error', 'Dokumen tidak ditemukan.');
        }
    }
    
    public function arsipUpdate(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|string',
            'judul_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_dokumen' => 'nullable|date',
            'pembuat' => 'required|string|max:255',
            'prioritas' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,txt|max:51200',
            'is_public' => 'nullable|boolean',
            'is_important' => 'nullable|boolean'
        ]);

        try {
            $arsip = Arsip::findOrFail($id);
            
            // Pastikan user hanya bisa update arsip miliknya atau arsip public
            if ($arsip->created_by != Auth::id() && !$arsip->is_public) {
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengupdate dokumen ini.');
            }
            
            $arsipData = [
                'kategori' => $request->kategori,
                'judul_dokumen' => $request->judul_dokumen,
                'deskripsi' => $request->deskripsi,
                'tanggal_dokumen' => $request->tanggal_dokumen ?? $arsip->tanggal_dokumen,
                'pembuat' => $request->pembuat,
                'prioritas' => $request->prioritas ?? 'sedang',
                'is_public' => $request->input('is_public', 0) == 1,
                'is_important' => $request->input('is_important', 0) == 1,
            ];
            
            // Handle file upload jika ada file baru
            if ($request->hasFile('file_dokumen')) {
                // Hapus file lama jika ada
                if ($arsip->file_dokumen && Storage::exists('public/arsip/' . $arsip->file_dokumen)) {
                    Storage::delete('public/arsip/' . $arsip->file_dokumen);
                }
                
                $file = $request->file('file_dokumen');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/arsip', $filename);
                $arsipData['file_dokumen'] = $filename;
                $arsipData['ukuran_file'] = $file->getSize();
                $arsipData['tipe_file'] = $file->getClientOriginalExtension();
            }
            
            $arsip->update($arsipData);
            
            \Log::info('Arsip updated successfully:', [
                'id' => $arsip->id,
                'judul_dokumen' => $arsip->judul_dokumen,
                'kategori' => $arsip->kategori,
            ]);
            
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
                "Dokumen '{$request->judul_dokumen}' berhasil diperbarui!"
            );
        } catch (\Exception $e) {
            \Log::error('Error updating arsip: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui dokumen: ' . $e->getMessage());
        }
    }
    
    public function arsipView($id)
    {
        try {
            $arsip = Arsip::findOrFail($id);
            
            // Pastikan user hanya bisa view arsip yang bisa diakses
            if ($arsip->created_by != Auth::id() && !$arsip->is_public) {
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'Anda tidak memiliki akses untuk melihat dokumen ini.');
            }
            
            // Cek apakah file ada
            if (!$arsip->file_dokumen) {
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'File dokumen tidak ditemukan.');
            }
            
            // Gunakan Storage facade untuk mendapatkan path file
            $storagePath = 'public/arsip/' . $arsip->file_dokumen;
            
            // Cek apakah file ada di storage
            if (!Storage::exists($storagePath)) {
                \Log::error('File not found in storage: ' . $storagePath);
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'File tidak ditemukan di server.');
            }
            
            // Ambil path lengkap file
            $filePath = Storage::path($storagePath);
            
            // Ambil mime type file
            $mimeType = Storage::mimeType($storagePath);
            
            // Return file untuk ditampilkan di browser
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $arsip->file_dokumen . '"',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error viewing arsip: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('tu.arsip.index')
                ->with('error', 'Terjadi kesalahan saat melihat dokumen: ' . $e->getMessage());
        }
    }
    
    public function arsipDownload($id)
    {
        try {
            $arsip = Arsip::findOrFail($id);
            
            // Pastikan user hanya bisa download arsip yang bisa diakses
            if ($arsip->created_by != Auth::id() && !$arsip->is_public) {
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengunduh dokumen ini.');
            }
            
            // Cek apakah file ada
            if (!$arsip->file_dokumen) {
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'File dokumen tidak ditemukan.');
            }
            
            // Gunakan Storage facade untuk mendapatkan path file
            $storagePath = 'public/arsip/' . $arsip->file_dokumen;
            
            // Cek apakah file ada di storage
            if (!Storage::exists($storagePath)) {
                \Log::error('File not found in storage: ' . $storagePath);
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'File tidak ditemukan di server.');
            }
            
            // Ambil path lengkap file
            $filePath = Storage::path($storagePath);
            
            // Ambil extension file untuk menentukan nama file download
            $extension = $arsip->tipe_file ?? pathinfo($arsip->file_dokumen, PATHINFO_EXTENSION);
            
            // Buat nama file download yang bersih
            $downloadName = $arsip->judul_dokumen;
            // Clean nama file dari karakter yang tidak valid untuk nama file
            $downloadName = preg_replace('/[^a-zA-Z0-9\s._-]/', '', $downloadName);
            $downloadName = str_replace(' ', '_', $downloadName);
            $downloadName = $downloadName . '.' . $extension;
            
            return response()->download($filePath, $downloadName, [
                'Content-Type' => Storage::mimeType($storagePath),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error downloading arsip: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('tu.arsip.index')
                ->with('error', 'Terjadi kesalahan saat mengunduh dokumen: ' . $e->getMessage());
        }
    }
    
    public function arsipDestroy($id)
    {
        try {
            $arsip = Arsip::findOrFail($id);
            
            // Pastikan user hanya bisa delete arsip miliknya atau arsip public
            if ($arsip->created_by != Auth::id() && !$arsip->is_public) {
                return redirect()->route('tu.arsip.index')
                    ->with('error', 'Anda tidak memiliki akses untuk menghapus dokumen ini.');
            }
            
            // Hapus file dari storage
            if ($arsip->file_dokumen && Storage::exists('public/arsip/' . $arsip->file_dokumen)) {
                Storage::delete('public/arsip/' . $arsip->file_dokumen);
            }
            
            $judulDokumen = $arsip->judul_dokumen;
            $arsip->delete();

            return redirect()->route('tu.arsip.index')->with('success', 
                "Dokumen '{$judulDokumen}' berhasil dihapus!"
            );
        } catch (\Exception $e) {
            \Log::error('Error deleting arsip: ' . $e->getMessage());
            return redirect()->route('tu.arsip.index')->with('error', 
                'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()
            );
        }
    }
    
    // Surat Management
    public function suratIndex(Request $request)
    {
        try {
            $query = Surat::where(function($q) {
                    $q->where('created_by', Auth::id())
                      ->orWhere('arsipkan', true);
                })
                ->with('creator');
            
            // Filter berdasarkan jenis (yayasan/sekolah) dari submenu
            if ($request->filled('jenis')) {
                $jenis = $request->jenis;
                if (in_array($jenis, ['yayasan', 'sekolah'])) {
                    $query->where('sumber_surat', $jenis);
                }
            }
            
            // Filter berdasarkan tipe surat (masuk/keluar)
            if ($request->filled('tipe_surat')) {
                $query->where('tipe_surat', $request->tipe_surat);
            }
            
            // Filter berdasarkan jenis surat
            if ($request->filled('jenis_surat')) {
                $query->where('jenis_surat', $request->jenis_surat);
            }
            
            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            // Filter berdasarkan pencarian (nomor surat atau perihal)
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nomor_surat', 'like', "%{$search}%")
                      ->orWhere('perihal', 'like', "%{$search}%");
                });
            }
            
            $surats = $query->orderBy('tanggal_surat', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(50)->withQueryString();
            
            \Log::info('Surats fetched:', ['count' => $surats->total()]);
            
            // Pass jenis parameter to view
            $jenis = $request->get('jenis', 'sekolah');
            
            return view('tu.surat.index', compact('surats', 'jenis'));
        } catch (\Exception $e) {
            \Log::error('Error fetching surats: ' . $e->getMessage());
            // Create empty paginator using constructor instead of make()
            $surats = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]),
                0,
                50,
                1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            $jenis = $request->get('jenis', 'sekolah');
            return view('tu.surat.index', compact('surats', 'jenis'));
        }
    }
    
    public function suratCreate(Request $request)
    {
        $jenis = $request->get('jenis', 'sekolah');
        return view('tu.surat.create', compact('jenis'));
    }
    
    public function suratShow($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            
            // Pastikan user hanya bisa melihat surat yang bisa diakses
            if ($surat->created_by != Auth::id() && !$surat->arsipkan) {
                return redirect()->route('tu.surat.index')
                    ->with('error', 'Anda tidak memiliki akses untuk melihat surat ini.');
            }
            
            return view('tu.surat.show', compact('surat'));
        } catch (\Exception $e) {
            \Log::error('Error loading surat for view: ' . $e->getMessage());
            return redirect()->route('tu.surat.index')
                ->with('error', 'Surat tidak ditemukan.');
        }
    }
    
    public function suratEdit($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            
            // Pastikan user hanya bisa edit surat miliknya
            if ($surat->created_by != Auth::id()) {
                return redirect()->route('tu.surat.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengedit surat ini.');
            }
            
            return view('tu.surat.edit', compact('surat'));
        } catch (\Exception $e) {
            \Log::error('Error loading surat for edit: ' . $e->getMessage());
            return redirect()->route('tu.surat.index')
                ->with('error', 'Surat tidak ditemukan.');
        }
    }
    
    public function suratUpdate(Request $request, $id)
    {
        $request->validate([
            'tipe_surat' => 'required|in:masuk,keluar',
            'jenis_surat' => 'required|string',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'penerima' => 'required_if:tipe_surat,keluar|nullable|string',
            'penerima_lainnya' => 'required_if:penerima,lainnya|nullable|string|max:255',
            'pengirim' => 'required_if:tipe_surat,masuk|nullable|string',
            'pengirim_lainnya' => 'required_if:pengirim,lainnya|nullable|string|max:255',
            'isi_surat' => 'required|string',
            'pembuat_surat' => 'required|string',
            'jabatan_pembuat' => 'nullable|string|max:255',
            'prioritas' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'arsipkan' => 'nullable|boolean'
        ]);

        try {
            $surat = Surat::findOrFail($id);
            
            // Pastikan user hanya bisa update surat miliknya
            if ($surat->created_by != Auth::id()) {
                return redirect()->route('tu.surat.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengupdate surat ini.');
            }
            
            $suratData = [
                'tipe_surat' => $request->tipe_surat,
                'jenis_surat' => $request->jenis_surat,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'perihal' => $request->perihal,
                'penerima' => $request->tipe_surat === 'keluar' ? $request->penerima : 'Tenaga Usaha',
                'penerima_lainnya' => $request->tipe_surat === 'keluar' && $request->penerima === 'lainnya' ? $request->penerima_lainnya : null,
                'pengirim' => $request->tipe_surat === 'masuk' ? ($request->pengirim === 'lainnya' ? $request->pengirim_lainnya : $request->pengirim) : null,
                'isi_surat' => $request->isi_surat,
                'pembuat_surat' => $request->pembuat_surat,
                'jabatan_pembuat' => $request->jabatan_pembuat ?? 'Tenaga Usaha',
                'prioritas' => $request->prioritas ?? 'biasa',
                'arsipkan' => $request->input('arsipkan', 0) == 1,
            ];
            
            // Handle file upload jika ada file baru
            if ($request->hasFile('lampiran')) {
                // Hapus file lama jika ada
                if ($surat->lampiran && Storage::exists('public/surat/' . $surat->lampiran)) {
                    Storage::delete('public/surat/' . $surat->lampiran);
                }
                
                $file = $request->file('lampiran');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/surat', $filename);
                $suratData['lampiran'] = $filename;
            }
            
            $surat->update($suratData);
            
            // Refresh model untuk mendapatkan data terbaru
            $surat->refresh();
            
            \Log::info('Surat updated successfully:', [
                'id' => $surat->id,
                'nomor_surat' => $surat->nomor_surat,
                'jenis_surat' => $surat->jenis_surat,
                'lampiran' => $surat->lampiran,
            ]);

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

            return redirect()->route('tu.surat.show', $surat->id)->with('success', 
                "{$jenisText} '{$request->nomor_surat}' berhasil diperbarui!"
            );
        } catch (\Exception $e) {
            \Log::error('Error updating surat: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui surat: ' . $e->getMessage());
        }
    }
    
    public function suratViewLampiran($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            
            // Pastikan user hanya bisa melihat surat yang bisa diakses
            if ($surat->created_by != Auth::id() && !$surat->arsipkan) {
                return redirect()->route('tu.surat.index')
                    ->with('error', 'Anda tidak memiliki akses untuk melihat lampiran surat ini.');
            }
            
            // Cek apakah file ada
            if (!$surat->lampiran) {
                return redirect()->route('tu.surat.show', $surat->id)
                    ->with('error', 'File lampiran tidak ditemukan.');
            }
            
            // Gunakan Storage facade untuk mendapatkan path file
            $storagePath = 'public/surat/' . $surat->lampiran;
            
            // Cek apakah file ada di storage
            if (!Storage::exists($storagePath)) {
                \Log::error('File not found in storage: ' . $storagePath);
                return redirect()->route('tu.surat.show', $surat->id)
                    ->with('error', 'File tidak ditemukan di server.');
            }
            
            // Ambil path lengkap file
            $filePath = Storage::path($storagePath);
            
            // Ambil mime type file
            $mimeType = Storage::mimeType($storagePath);
            
            // Return file untuk ditampilkan di browser dengan header untuk mencegah cache
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $surat->lampiran . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error viewing surat lampiran: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('tu.surat.show', $id)
                ->with('error', 'Terjadi kesalahan saat melihat lampiran: ' . $e->getMessage());
        }
    }
    
    public function suratDownloadLampiran($id)
    {
        try {
            $surat = Surat::findOrFail($id);
            
            // Pastikan user hanya bisa download surat yang bisa diakses
            if ($surat->created_by != Auth::id() && !$surat->arsipkan) {
                return redirect()->route('tu.surat.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengunduh lampiran surat ini.');
            }
            
            // Cek apakah file ada
            if (!$surat->lampiran) {
                return redirect()->route('tu.surat.show', $surat->id)
                    ->with('error', 'File lampiran tidak ditemukan.');
            }
            
            // Gunakan Storage facade untuk mendapatkan path file
            $storagePath = 'public/surat/' . $surat->lampiran;
            
            // Cek apakah file ada di storage
            if (!Storage::exists($storagePath)) {
                \Log::error('File not found in storage: ' . $storagePath);
                return redirect()->route('tu.surat.show', $surat->id)
                    ->with('error', 'File tidak ditemukan di server.');
            }
            
            // Ambil path lengkap file
            $filePath = Storage::path($storagePath);
            
            // Ambil extension file untuk menentukan nama file download
            $extension = pathinfo($surat->lampiran, PATHINFO_EXTENSION);
            
            // Buat nama file download yang bersih
            $downloadName = $surat->nomor_surat . '_lampiran';
            // Clean nama file dari karakter yang tidak valid untuk nama file
            $downloadName = preg_replace('/[^a-zA-Z0-9\s._-]/', '', $downloadName);
            $downloadName = str_replace(' ', '_', $downloadName);
            $downloadName = $downloadName . '.' . $extension;
            
            return response()->download($filePath, $downloadName, [
                'Content-Type' => Storage::mimeType($storagePath),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error downloading surat lampiran: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('tu.surat.show', $id)
                ->with('error', 'Terjadi kesalahan saat mengunduh lampiran: ' . $e->getMessage());
        }
    }
    
    // Surat Management
    public function suratSend(Request $request)
    {
        $request->validate([
            'tipe_surat' => 'required|in:masuk,keluar',
            'sumber_surat' => 'required|in:yayasan,sekolah',
            'jenis_surat' => 'required|string',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'penerima' => 'required_if:tipe_surat,keluar|nullable|string',
            'penerima_lainnya' => 'required_if:penerima,lainnya|nullable|string|max:255',
            'pengirim' => 'required_if:tipe_surat,masuk|nullable|string',
            'pengirim_lainnya' => 'required_if:pengirim,lainnya|nullable|string|max:255',
            'isi_surat' => 'required|string',
            'pembuat_surat' => 'required|string',
            'jabatan_pembuat' => 'nullable|string|max:255',
            'prioritas' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'arsipkan' => 'nullable|boolean'
        ]);

        try {
            // Simpan data surat
        $suratData = [
            'tipe_surat' => $request->tipe_surat,
            'sumber_surat' => $request->sumber_surat,
            'jenis_surat' => $request->jenis_surat,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal' => $request->perihal,
            'penerima' => $request->tipe_surat === 'keluar' ? $request->penerima : 'Tenaga Usaha',
            'penerima_lainnya' => $request->tipe_surat === 'keluar' && $request->penerima === 'lainnya' ? $request->penerima_lainnya : null,
            'pengirim' => $request->tipe_surat === 'masuk' ? ($request->pengirim === 'lainnya' ? $request->pengirim_lainnya : $request->pengirim) : null,
            'isi_surat' => $request->isi_surat,
            'pembuat_surat' => $request->pembuat_surat,
            'jabatan_pembuat' => $request->jabatan_pembuat ?? 'Tenaga Usaha',
            'prioritas' => $request->prioritas ?? 'biasa',
                'cc_email' => false, // Default false, tidak lagi digunakan
                'arsipkan' => $request->input('arsipkan', 0) == 1,
                'status' => 'draft', // Default status saat pertama kali disimpan
            'created_by' => Auth::id(),
        ];

        // Handle file upload jika ada
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat', $filename);
            $suratData['lampiran'] = $filename;
        }

            // Simpan ke database
            $surat = Surat::create($suratData);
            
            \Log::info('Surat created successfully:', [
                'id' => $surat->id,
                'nomor_surat' => $surat->nomor_surat,
                'jenis_surat' => $surat->jenis_surat,
            ]);
            
            // Kirim notifikasi ke penerima
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
            
            // Notifikasi untuk Kepala Sekolah
            if ($request->penerima == 'kepala_sekolah') {
                $kepalaSekolah = User::where('role', 'kepala_sekolah')->first();
                if ($kepalaSekolah) {
                    Notification::create([
                        'user_id' => $kepalaSekolah->id,
                        'type' => 'surat_baru',
                        'title' => $jenisText . ' Baru',
                        'message' => "Anda menerima {$jenisText} dengan nomor {$surat->nomor_surat} - {$surat->perihal}",
                        'data' => [
                            'surat_id' => $surat->id,
                            'nomor_surat' => $surat->nomor_surat,
                            'jenis_surat' => $surat->jenis_surat,
                            'perihal' => $surat->perihal,
                            'pembuat' => $surat->pembuat_surat,
                            'tanggal_surat' => $surat->tanggal_surat->format('Y-m-d'),
                        ]
                    ]);
                }
            }
            
            // Notifikasi untuk Semua Guru
            if ($request->penerima == 'guru') {
                $gurus = Guru::with('user')->get();
                foreach ($gurus as $guru) {
                    if ($guru->user) {
                        Notification::create([
                            'user_id' => $guru->user->id,
                            'type' => 'surat_baru',
                            'title' => $jenisText . ' Baru',
                            'message' => "Anda menerima {$jenisText} dengan nomor {$surat->nomor_surat} - {$surat->perihal}",
                            'data' => [
                                'surat_id' => $surat->id,
                                'nomor_surat' => $surat->nomor_surat,
                                'jenis_surat' => $surat->jenis_surat,
                                'perihal' => $surat->perihal,
                                'pembuat' => $surat->pembuat_surat,
                                'tanggal_surat' => $surat->tanggal_surat->format('Y-m-d'),
                            ]
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error creating surat: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan surat: ' . $e->getMessage());
        }

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
            "{$jenisText} '{$request->nomor_surat}' berhasil disimpan dan notifikasi telah dikirim ke {$penerimaText}!"
        );
    }
    
    // Pengumuman Management
    public function pengumumanIndex()
    {
        try {
            // Ambil SEMUA event yang terdaftar di kalender (semua kategori)
            // Tidak ada filter kategori - semua event akan ditampilkan: pengumuman, kegiatan, ujian, libur, rapat, pelatihan, akademik, lainnya
            $pengumumanEvents = Event::where(function($query) {
                    $query->where('is_public', true)
                          ->orWhere('created_by', Auth::id());
                })
                ->with('creator')
                ->orderBy('tanggal_mulai', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
            
            \Log::info('=== PENGUMUMAN EVENTS LOADED (ALL CATEGORIES) ===');
            \Log::info('Total events found: ' . $pengumumanEvents->count());
            \Log::info('Auth User ID: ' . Auth::id());
            
            // Log setiap event dengan detail lengkap
            foreach ($pengumumanEvents as $event) {
                \Log::info('Event ID: ' . $event->id . 
                    ' - Judul: ' . $event->judul_event . 
                    ' - Kategori: ' . $event->kategori_event . 
                    ' - Tanggal: ' . $event->tanggal_mulai . 
                    ' - is_public: ' . ($event->is_public ? 'true' : 'false') .
                    ' - created_by: ' . $event->created_by);
            }
            
            return view('tu.pengumuman.index', compact('pengumumanEvents'));
        } catch (\Exception $e) {
            \Log::error('Error loading pengumuman: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return view('tu.pengumuman.index', ['pengumumanEvents' => collect()]);
        }
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
        
        // Handle photo upload - OTOMATIS: path akan disimpan dengan benar
        if ($request->hasFile('photo')) {
            try {
                $file = $request->file('photo');
                
                // Validasi file sebelum upload
                if (!$file || !$file->isValid()) {
                    $errorMsg = $file ? 'File foto tidak valid. Error code: ' . $file->getError() : 'File foto tidak ditemukan.';
                    \Log::error('File invalid: ' . $errorMsg);
                    return back()->withErrors(['photo' => $errorMsg])->withInput();
                }
                
                // Cek ukuran file (max 2MB)
                if ($file->getSize() > 2048 * 1024) {
                    return back()->withErrors(['photo' => 'Ukuran file terlalu besar. Maksimal 2MB.'])->withInput();
                }
                
                // Cek tipe file
                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                $fileMime = $file->getMimeType();
                if (!in_array($fileMime, $allowedMimes)) {
                    return back()->withErrors(['photo' => 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF. Format yang diupload: ' . $fileMime])->withInput();
                }
                
                // Pastikan storage link ada
                $storageLink = public_path('storage');
                if (!file_exists($storageLink) || !is_link($storageLink)) {
                    try {
                        \Artisan::call('storage:link');
                        \Log::info('Storage link created successfully');
                    } catch (\Exception $e) {
                        \Log::warning('Gagal membuat storage link: ' . $e->getMessage());
                    }
                }
                
                // Pastikan folder storage ada
                $storagePath = storage_path('app/public/profiles/tu');
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
                    return back()->withErrors(['photo' => 'Folder storage tidak dapat diakses. Silakan hubungi administrator.'])->withInput();
                }
                
                // Delete old photo if exists
                if ($user->photo) {
                    try {
                        // Hapus foto lama dari berbagai kemungkinan lokasi
                        PhotoHelper::deletePhoto($user->photo);
                        // Coba hapus dengan berbagai format path lama
                        $oldFilename = basename($user->photo);
                        if ($oldFilename && $oldFilename !== $user->photo) {
                            PhotoHelper::deletePhoto('profiles/tu/' . $oldFilename);
                            PhotoHelper::deletePhoto('photos/' . $oldFilename);
                            PhotoHelper::deletePhoto('guru/foto/' . $oldFilename);
                        }
                    } catch (\Exception $e) {
                        // Log error tapi lanjutkan proses upload
                        \Log::warning('Gagal menghapus foto lama: ' . $e->getMessage());
                    }
                }
                
                // OTOMATIS SIMPAN dengan path yang benar
                // Prioritas 1: simpan di storage/app/public/profiles/tu/
                $photoPath = PhotoHelper::savePhoto($file, 'profiles/tu', true);
                
                if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                    // Path sudah benar: profiles/tu/[nama-file]
                    // Langsung simpan ke database tanpa perlu edit manual
                    $user->photo = $photoPath;
                    \Log::info('Foto TU berhasil disimpan: ' . $photoPath);
                } else {
                    // Fallback: simpan di public/image/profiles
                    $photoPath = PhotoHelper::savePhoto($file, 'image/profiles', false);
                    if ($photoPath && file_exists(public_path($photoPath))) {
                        // Path: image/profiles/[nama-file]
                        $user->photo = $photoPath;
                        \Log::info('Foto TU berhasil disimpan (fallback): ' . $photoPath);
                    } else {
                        // Log error untuk debugging
                        \Log::error('Gagal menyimpan foto TU: File valid tapi savePhoto mengembalikan null atau file tidak ada');
                        \Log::error('File info: ' . json_encode([
                            'name' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime' => $file->getMimeType(),
                            'error' => $file->getError(),
                            'storage_path' => $storagePath,
                            'storage_exists' => file_exists($storagePath),
                            'storage_writable' => is_writable($storagePath)
                        ]));
                        return back()->withErrors(['photo' => 'Gagal menyimpan foto. Pastikan folder storage memiliki permission yang benar dan storage link sudah dibuat.'])->withInput();
                    }
                }
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Re-throw validation exception agar ditangani oleh Laravel
                throw $e;
            } catch (\Exception $e) {
                // Log error lengkap untuk debugging
                \Log::error('Error upload foto TU: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
                \Log::error('File: ' . (isset($file) && $file ? $file->getClientOriginalName() : 'null'));
                
                // Error message yang lebih user-friendly
                $errorMessage = 'Gagal mengupload foto. ';
                if (strpos($e->getMessage(), 'writable') !== false || strpos($e->getMessage(), 'permission') !== false) {
                    $errorMessage .= 'Folder storage tidak memiliki permission yang cukup. Silakan hubungi administrator.';
                } elseif (strpos($e->getMessage(), 'not found') !== false || strpos($e->getMessage(), 'tidak ditemukan') !== false) {
                    $errorMessage .= 'File tidak ditemukan setelah upload. Silakan coba lagi.';
                } else {
                    $errorMessage .= $e->getMessage();
                }
                
                return back()->withErrors(['photo' => $errorMessage])->withInput();
            }
        }
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        // Get fresh user data from database to ensure photo is loaded
        $freshUser = User::find($user->id);
        
        // Refresh user data in session to update photo immediately
        Auth::login($freshUser);
        
        // Clear all caches to ensure fresh data
        try {
            \Artisan::call('view:clear');
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
        } catch (\Exception $e) {
            // Ignore cache errors
        }
        
        return redirect()->route('tu.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
