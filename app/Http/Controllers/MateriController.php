<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityTracker;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // Get mata pelajaran yang dipilih
        $selectedMataPelajaran = $request->get('mata_pelajaran');
        $mataPelajaranList = $guru->mataPelajaranAktif;
        
        // Jika tidak ada mata pelajaran yang dipilih dan tidak ada di mataPelajaranAktif,
        // ambil dari materi yang sudah ada
        if (!$selectedMataPelajaran) {
            if ($mataPelajaranList->count() > 0) {
                // Gunakan mata pelajaran pertama dari list aktif
                $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
            } else {
                // Jika tidak ada di mataPelajaranAktif, ambil dari materi yang sudah dibuat
                $existingMataPelajaran = $guru->materi()
                    ->select('mata_pelajaran')
                    ->distinct()
                    ->pluck('mata_pelajaran');
                
                if ($existingMataPelajaran->count() > 0) {
                    $selectedMataPelajaran = $existingMataPelajaran->first();
                }
            }
        }

        $query = $guru->materi();
        
        // Filter by mata pelajaran if selected
        if ($selectedMataPelajaran) {
            $query->where('mata_pelajaran', $selectedMataPelajaran);
        }
        // Jika tidak ada mata pelajaran yang dipilih, tampilkan SEMUA materi
        // (tidak perlu filter)

        // Filter by kelas if selected
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhere('topik', 'like', '%' . $request->topik . '%');
            });
        }

        // Filter by topik
        if ($request->filled('topik')) {
            $query->where('topik', 'like', '%' . $request->topik . '%');
        }

        $materi = $query->orderBy('created_at', 'desc')->paginate(10);

        // Pass filter values to view
        $selectedKelas = $request->get('kelas');
        $selectedTopik = $request->get('topik');
        $selectedSearch = $request->get('search');

        return view('guru.materi.index', compact('guru', 'materi', 'mataPelajaranList', 'selectedMataPelajaran', 'selectedKelas', 'selectedTopik', 'selectedSearch'));
    }

    public function create()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $mataPelajaranList = $guru->mataPelajaranAktif;

        return view('guru.materi.create', compact('guru', 'mataPelajaranList'));
    }

    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kelas' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'jumlah_pertemuan' => 'required|integer|min:1|max:50',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov|max:10240',
            'konten' => 'nullable|string',
            'link_video' => 'nullable|url'
        ]);

        $data = [
            'guru_id' => $guru->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'topik' => $request->topik,
            'jumlah_pertemuan' => $request->jumlah_pertemuan,
            'pertemuan_selesai' => [],
            'konten' => $request->konten,
            'link_video' => $request->link_video,
            'is_published' => $request->has('is_published')
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materi', $fileName, 'public');
            
            $data['file_path'] = $filePath;
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
        }

        if ($data['is_published']) {
            $data['tanggal_publish'] = now();
        }

        $materi = Materi::create($data);

        // Track activity
        ActivityTracker::trackActivity($guru, 'create_materi', 'Membuat materi baru: ' . $materi->judul, [
            'materi_id' => $materi->id,
            'judul' => $materi->judul,
            'kelas' => $materi->kelas,
            'mata_pelajaran' => $materi->mata_pelajaran,
            'topik' => $materi->topik
        ]);

        // Redirect dengan mata_pelajaran yang sama agar materi baru langsung muncul
        return redirect()->route('guru.materi.index', ['mata_pelajaran' => $materi->mata_pelajaran])->with('success', 'Materi berhasil ditambahkan');
    }

    public function show(Materi $materi)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $materi->guru_id !== $guru->id) {
            return redirect()->route('guru.materi.index')->with('error', 'Materi tidak ditemukan');
        }

        return view('guru.materi.show', compact('materi'));
    }

    public function edit(Materi $materi)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $materi->guru_id !== $guru->id) {
            return redirect()->route('guru.materi.index')->with('error', 'Materi tidak ditemukan');
        }

        return view('guru.materi.edit', compact('materi'));
    }

    public function update(Request $request, Materi $materi)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $materi->guru_id !== $guru->id) {
            return redirect()->route('guru.materi.index')->with('error', 'Materi tidak ditemukan');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kelas' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov|max:10240',
            'konten' => 'nullable|string',
            'link_video' => 'nullable|url'
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kelas' => $request->kelas,
            'topik' => $request->topik,
            'konten' => $request->konten,
            'link_video' => $request->link_video,
            'is_published' => $request->has('is_published')
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($materi->file_path && Storage::exists($materi->file_path)) {
                Storage::delete($materi->file_path);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materi', $fileName, 'public');
            
            $data['file_path'] = $filePath;
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
        }
        // Handle file deletion (if user clicked "Hapus File" button)
        elseif ($request->input('delete_file') == '1') {
            // Delete old file from storage
            if ($materi->file_path && Storage::exists($materi->file_path)) {
                Storage::delete($materi->file_path);
            }
            
            // Remove file info from database
            $data['file_path'] = null;
            $data['file_type'] = null;
            $data['file_size'] = null;
        }

        if ($data['is_published'] && !$materi->is_published) {
            $data['tanggal_publish'] = now();
        }

        $materi->update($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui');
    }

    public function destroy(Materi $materi)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $materi->guru_id !== $guru->id) {
            return redirect()->route('guru.materi.index')->with('error', 'Materi tidak ditemukan');
        }

        // Delete file if exists
        if ($materi->file_path && Storage::exists($materi->file_path)) {
            Storage::delete($materi->file_path);
        }

        $materi->delete();

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus');
    }

    public function search(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // Get mata pelajaran yang dipilih
        $selectedMataPelajaran = $request->get('mata_pelajaran');
        $mataPelajaranList = $guru->mataPelajaranAktif;
        
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        $query = $guru->materi();
        
        // Filter by mata pelajaran if selected
        if ($selectedMataPelajaran) {
            $query->where('mata_pelajaran', $selectedMataPelajaran);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhere('topik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('topik')) {
            $query->where('topik', 'like', '%' . $request->topik . '%');
        }

        $materi = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('guru.materi.index', compact('guru', 'materi', 'mataPelajaranList', 'selectedMataPelajaran'));
    }

    /**
     * Toggle status pertemuan
     */
    public function togglePertemuan(Request $request, Materi $materi)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $materi->guru_id !== $guru->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'nomor_pertemuan' => 'required|integer|min:1'
        ]);

        $nomorPertemuan = $request->nomor_pertemuan;
        
        // Validate nomor pertemuan tidak melebihi jumlah pertemuan
        if ($nomorPertemuan > $materi->jumlah_pertemuan) {
            return response()->json(['error' => 'Nomor pertemuan tidak valid'], 400);
        }

        $materi->togglePertemuan($nomorPertemuan);

        return response()->json([
            'success' => true,
            'pertemuan_selesai' => $materi->pertemuan_selesai,
            'jumlah_selesai' => $materi->jumlah_selesai,
            'jumlah_belum_selesai' => $materi->jumlah_belum_selesai,
            'persentase_selesai' => $materi->persentase_selesai
        ]);
    }

    /**
     * Update semua pertemuan sekaligus (batch update)
     */
    public function updatePertemuan(Request $request, Materi $materi)
    {
        // Quick authorization check without extra query
        if ($materi->guru_id !== Auth::user()->guru->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'pertemuan_selesai' => 'required|array'
        ]);

        $pertemuanSelesai = $request->pertemuan_selesai;
        
        // Simple validation - just check max value
        $maxPertemuan = max($pertemuanSelesai);
        if ($maxPertemuan > $materi->jumlah_pertemuan) {
            return response()->json(['error' => 'Nomor pertemuan tidak valid'], 400);
        }

        // Update pertemuan_selesai
        $materi->pertemuan_selesai = $pertemuanSelesai;
        $materi->save();

        // Return minimal response for faster processing
        return response()->json([
            'success' => true
        ]);
    }
}
