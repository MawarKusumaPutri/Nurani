<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $materi = $guru->materi()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('guru.materi.index', compact('guru', 'materi'));
    }

    public function create()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        return view('guru.materi.create', compact('guru'));
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
            'topik' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov|max:10240',
            'konten' => 'nullable|string',
            'link_video' => 'nullable|url'
        ]);

        $data = [
            'guru_id' => $guru->id,
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

        Materi::create($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan');
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

        $query = $guru->materi();

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

        return view('guru.materi.index', compact('guru', 'materi'));
    }
}
