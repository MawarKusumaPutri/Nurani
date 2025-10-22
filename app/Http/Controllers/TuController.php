<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\User;
use App\Models\Notification;

class TuController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics
        $totalGuru = Guru::count();
        $totalSiswa = 180; // Static for now
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
        // Implementation for creating new guru
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
        // Implementation for student data
        return view('tu.siswa.index');
    }
    
    public function siswaCreate()
    {
        return view('tu.siswa.create');
    }
    
    // Presensi Management
    public function presensiIndex()
    {
        return view('tu.presensi.index');
    }
    
    public function presensiVerify(Request $request)
    {
        // Implementation for verifying attendance
        return redirect()->route('tu.presensi.index')->with('success', 'Presensi berhasil diverifikasi');
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
    
    // Jadwal Management
    public function jadwalIndex()
    {
        return view('tu.jadwal.index');
    }
    
    public function jadwalCreate()
    {
        return view('tu.jadwal.create');
    }
    
    // Kalender Management
    public function kalenderIndex()
    {
        return view('tu.kalender.index');
    }
    
    // Arsip Management
    public function arsipIndex()
    {
        return view('tu.arsip.index');
    }
    
    public function arsipUpload(Request $request)
    {
        // Implementation for uploading documents
        return redirect()->route('tu.arsip.index')->with('success', 'Dokumen berhasil diarsipkan');
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
    
    // Laporan Management
    public function laporanIndex()
    {
        return view('tu.laporan.index');
    }
    
    public function laporanCreate()
    {
        return view('tu.laporan.create');
    }
    
    public function laporanSend(Request $request)
    {
        // Implementation for sending reports to kepala sekolah
        return redirect()->route('tu.laporan.index')->with('success', 'Laporan berhasil dikirim ke kepala sekolah');
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
}
