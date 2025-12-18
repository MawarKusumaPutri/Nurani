<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KegiatanKesiswaan;
use Illuminate\Support\Facades\Storage;

class KegiatanKesiswaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        
        // Get user data based on role
        if ($role === 'tu') {
            return view('kegiatan-kesiswaan.index', compact('role'));
        } elseif ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.index', compact('guru', 'role'));
        }
        
        return redirect()->route('login');
    }
    
    // RENCANA KEGIATAN
    public function rencana()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'tu') {
            $rencanas = KegiatanKesiswaan::where('status', 'rencana')
                ->where('created_by', $user->id)
                ->orderBy('tanggal_mulai', 'desc')
                ->paginate(10);
            return view('kegiatan-kesiswaan.rencana.index', compact('rencanas', 'role'));
        } elseif ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            $rencanas = KegiatanKesiswaan::where('status', 'rencana')
                ->orderBy('tanggal_mulai', 'desc')
                ->paginate(10);
            return view('kegiatan-kesiswaan.rencana.index', compact('rencanas', 'guru', 'role'));
        }
        
        return redirect()->route('login');
    }
    
    public function rencanaCreate()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'tu') {
            return view('kegiatan-kesiswaan.rencana.create', compact('role'));
        } elseif ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.rencana.create', compact('guru', 'role'));
        }
        
        return redirect()->route('login');
    }
    
    public function rencanaStore(Request $request)
    {
        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'anggaran' => 'nullable|numeric|min:0',
            'peserta' => 'nullable|string',
            'catatan' => 'nullable|string',
            'dokumen_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);
        
        $data = $request->all();
        $data['status'] = 'rencana';
        $data['created_by'] = Auth::id();
        
        if ($request->hasFile('dokumen_lampiran')) {
            $data['dokumen_lampiran'] = $request->file('dokumen_lampiran')->store('kegiatan-kesiswaan', 'public');
        }
        
        KegiatanKesiswaan::create($data);
        
        $route = match(Auth::user()->role) {
            'tu' => 'tu.kegiatan-kesiswaan.rencana.index',
            'guru' => 'guru.kegiatan-kesiswaan.rencana.index',
            default => 'login'
        };
        
        return redirect()->route($route)->with('success', 'Rencana kegiatan berhasil dibuat');
    }
    
    public function rencanaShow($id)
    {
        $user = Auth::user();
        $role = $user->role;
        $rencana = KegiatanKesiswaan::findOrFail($id);
        
        if ($role === 'tu') {
            return view('kegiatan-kesiswaan.rencana.show', compact('rencana', 'role'));
        } elseif ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.rencana.show', compact('rencana', 'guru', 'role'));
        }
        
        return redirect()->route('login');
    }
    
    public function rencanaEdit($id)
    {
        $user = Auth::user();
        $role = $user->role;
        $rencana = KegiatanKesiswaan::findOrFail($id);
        
        // Check if user can edit
        if ($role === 'tu' && $rencana->created_by !== $user->id) {
            return redirect()->route('tu.kegiatan-kesiswaan.rencana.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit rencana ini.');
        }
        
        if ($role === 'tu') {
            return view('kegiatan-kesiswaan.rencana.edit', compact('rencana', 'role'));
        } elseif ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.rencana.edit', compact('rencana', 'guru', 'role'));
        }
        
        return redirect()->route('login');
    }
    
    public function rencanaUpdate(Request $request, $id)
    {
        $rencana = KegiatanKesiswaan::findOrFail($id);
        
        // Check if user can update
        if (Auth::user()->role === 'tu' && $rencana->created_by !== Auth::id()) {
            return redirect()->route('tu.kegiatan-kesiswaan.rencana.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengupdate rencana ini.');
        }
        
        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'anggaran' => 'nullable|numeric|min:0',
            'peserta' => 'nullable|string',
            'catatan' => 'nullable|string',
            'dokumen_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('dokumen_lampiran')) {
            // Delete old file
            if ($rencana->dokumen_lampiran) {
                Storage::disk('public')->delete($rencana->dokumen_lampiran);
            }
            $data['dokumen_lampiran'] = $request->file('dokumen_lampiran')->store('kegiatan-kesiswaan', 'public');
        }
        
        $rencana->update($data);
        
        $route = match(Auth::user()->role) {
            'tu' => 'tu.kegiatan-kesiswaan.rencana.index',
            'guru' => 'guru.kegiatan-kesiswaan.rencana.index',
            default => 'login'
        };
        
        return redirect()->route($route)->with('success', 'Rencana kegiatan berhasil diperbarui');
    }
    
    public function rencanaDestroy($id)
    {
        $rencana = KegiatanKesiswaan::findOrFail($id);
        
        // Check if user can delete
        if (Auth::user()->role === 'tu' && $rencana->created_by !== Auth::id()) {
            return redirect()->route('tu.kegiatan-kesiswaan.rencana.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus rencana ini.');
        }
        
        // Delete file if exists
        if ($rencana->dokumen_lampiran) {
            Storage::disk('public')->delete($rencana->dokumen_lampiran);
        }
        
        $rencana->delete();
        
        $route = match(Auth::user()->role) {
            'tu' => 'tu.kegiatan-kesiswaan.rencana.index',
            'guru' => 'guru.kegiatan-kesiswaan.rencana.index',
            default => 'login'
        };
        
        return redirect()->route($route)->with('success', 'Rencana kegiatan berhasil dihapus');
    }
    
    // MONITORING PELAKSANAAN
    public function monitoring()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'tu') {
            $kegiatans = KegiatanKesiswaan::whereIn('status', ['sedang_berlangsung', 'rencana'])
                ->orderBy('tanggal_mulai', 'asc')
                ->paginate(10);
            return view('kegiatan-kesiswaan.monitoring.index', compact('kegiatans', 'role'));
        } elseif ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            $kegiatans = KegiatanKesiswaan::whereIn('status', ['sedang_berlangsung', 'rencana'])
                ->orderBy('tanggal_mulai', 'asc')
                ->paginate(10);
            return view('kegiatan-kesiswaan.monitoring.index', compact('kegiatans', 'guru', 'role'));
        
        return redirect()->route('login');
    }
    
    public function monitoringUpdateStatus(Request $request, $id)
    {
        $kegiatan = KegiatanKesiswaan::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:rencana,sedang_berlangsung,selesai,dibatalkan',
        ]);
        
        $kegiatan->update(['status' => $request->status]);
        
        $route = match(Auth::user()->role) {
            'tu' => 'tu.kegiatan-kesiswaan.monitoring.index',
            'guru' => 'guru.kegiatan-kesiswaan.monitoring.index',
            default => 'login'
        };
        
        return redirect()->route($route)->with('success', 'Status kegiatan berhasil diperbarui');
    }
    
    // LAPORAN KEGIATAN
    public function laporan()
    {
        $user = Auth::user();
        $role = $user->role;
        
        if ($role === 'tu') {
            $laporans = KegiatanKesiswaan::where('status', 'selesai')
                ->orderBy('tanggal_selesai', 'desc')
                ->paginate(10);
            return view('kegiatan-kesiswaan.laporan.index', compact('laporans', 'role'));
        } elseif ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            $laporans = KegiatanKesiswaan::where('status', 'selesai')
                ->orderBy('tanggal_selesai', 'desc')
                ->paginate(10);
            return view('kegiatan-kesiswaan.laporan.index', compact('laporans', 'guru', 'role'));
        }
        
        return redirect()->route('login');
    }
    
    public function laporanShow($id)
    {
        $user = Auth::user();
        $role = $user->role;
        $laporan = KegiatanKesiswaan::findOrFail($id);
        
        if ($role === 'tu') {
            return view('kegiatan-kesiswaan.laporan.show', compact('laporan', 'role'));
        } elseif ($role === 'guru') {
            $guru = \App\Models\Guru::where('user_id', $user->id)->first();
            return view('kegiatan-kesiswaan.laporan.show', compact('laporan', 'guru', 'role'));
        }
        
        return redirect()->route('login');
    }
    
    public function laporanUpdate(Request $request, $id)
    {
        $laporan = KegiatanKesiswaan::findOrFail($id);
        
        $request->validate([
            'hasil_kegiatan' => 'nullable|string',
            'evaluasi' => 'nullable|string',
        ]);
        
        $laporan->update([
            'hasil_kegiatan' => $request->hasil_kegiatan,
            'evaluasi' => $request->evaluasi,
        ]);
        
        $route = match(Auth::user()->role) {
            'tu' => 'tu.kegiatan-kesiswaan.laporan.index',
            'guru' => 'guru.kegiatan-kesiswaan.laporan.index',
            default => 'login'
        };
        
        return redirect()->route($route)->with('success', 'Laporan kegiatan berhasil diperbarui');
    }
}
