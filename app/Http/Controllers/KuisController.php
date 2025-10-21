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
            'deskripsi' => 'required|string',
            'kelas' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'durasi_menit' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);

        Kuis::create([
            'guru_id' => $guru->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'soal' => [], // Akan diisi nanti
            'durasi_menit' => $request->durasi_menit,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_active' => true
        ]);

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
            'deskripsi' => 'required|string',
            'kelas' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'durasi_menit' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);

        $kuis->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'durasi_menit' => $request->durasi_menit,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

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
