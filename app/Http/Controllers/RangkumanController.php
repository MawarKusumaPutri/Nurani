<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Rangkuman;
use Illuminate\Support\Facades\Auth;

class RangkumanController extends Controller
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
        
        if (!$selectedMataPelajaran && $mataPelajaranList->count() > 0) {
            $selectedMataPelajaran = $mataPelajaranList->first()->mata_pelajaran;
        }

        $query = $guru->rangkuman();
        if ($selectedMataPelajaran) {
            $query->where('mata_pelajaran', $selectedMataPelajaran);
        }

        $rangkuman = $query->orderBy('tanggal_pertemuan', 'desc')->paginate(10);

        return view('guru.rangkuman.index', compact('guru', 'rangkuman', 'mataPelajaranList', 'selectedMataPelajaran'));
    }

    public function create()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        return view('guru.rangkuman.create', compact('guru'));
    }

    public function store(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $request->validate([
            'kelas' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'tanggal_pertemuan' => 'required|date',
            'materi_yang_diajarkan' => 'required|string',
            'capaian_pembelajaran' => 'required|string',
            'catatan_tambahan' => 'nullable|string'
        ]);

        Rangkuman::create([
            'guru_id' => $guru->id,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'tanggal_pertemuan' => $request->tanggal_pertemuan,
            'materi_yang_diajarkan' => $request->materi_yang_diajarkan,
            'capaian_pembelajaran' => $request->capaian_pembelajaran,
            'catatan_tambahan' => $request->catatan_tambahan,
            'is_complete' => $request->has('is_complete'),
            'tanggal_selesai' => $request->has('is_complete') ? now() : null
        ]);

        return redirect()->route('guru.rangkuman.index')->with('success', 'Rangkuman berhasil dibuat');
    }

    public function show(Rangkuman $rangkuman)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $rangkuman->guru_id !== $guru->id) {
            return redirect()->route('guru.rangkuman.index')->with('error', 'Rangkuman tidak ditemukan');
        }

        return view('guru.rangkuman.show', compact('rangkuman'));
    }

    public function edit(Rangkuman $rangkuman)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $rangkuman->guru_id !== $guru->id) {
            return redirect()->route('guru.rangkuman.index')->with('error', 'Rangkuman tidak ditemukan');
        }

        return view('guru.rangkuman.edit', compact('rangkuman'));
    }

    public function update(Request $request, Rangkuman $rangkuman)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $rangkuman->guru_id !== $guru->id) {
            return redirect()->route('guru.rangkuman.index')->with('error', 'Rangkuman tidak ditemukan');
        }

        $request->validate([
            'kelas' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:255',
            'tanggal_pertemuan' => 'required|date',
            'materi_yang_diajarkan' => 'required|string',
            'capaian_pembelajaran' => 'required|string',
            'catatan_tambahan' => 'nullable|string'
        ]);

        $rangkuman->update([
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'tanggal_pertemuan' => $request->tanggal_pertemuan,
            'materi_yang_diajarkan' => $request->materi_yang_diajarkan,
            'capaian_pembelajaran' => $request->capaian_pembelajaran,
            'catatan_tambahan' => $request->catatan_tambahan,
            'is_complete' => $request->has('is_complete'),
            'tanggal_selesai' => $request->has('is_complete') ? now() : null
        ]);

        return redirect()->route('guru.rangkuman.index')->with('success', 'Rangkuman berhasil diperbarui');
    }

    public function destroy(Rangkuman $rangkuman)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru || $rangkuman->guru_id !== $guru->id) {
            return redirect()->route('guru.rangkuman.index')->with('error', 'Rangkuman tidak ditemukan');
        }

        $rangkuman->delete();

        return redirect()->route('guru.rangkuman.index')->with('success', 'Rangkuman berhasil dihapus');
    }
}
