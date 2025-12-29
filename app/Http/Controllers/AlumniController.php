<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    /**
     * Display a listing of alumni
     */
    public function index(Request $request)
    {
        $kelasFilter = $request->get('kelas', '');
        $tahunLulusFilter = $request->get('tahun_lulus', '');
        $search = $request->get('search', '');
        
        $query = Alumni::query();
        
        // Apply kelas filter
        if (!empty($kelasFilter)) {
            $query->where('kelas_terakhir', $kelasFilter);
        }
        
        // Apply tahun lulus filter
        if (!empty($tahunLulusFilter)) {
            $query->where('tahun_lulus', $tahunLulusFilter);
        }
        
        // Apply search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }
        
        $alumni = $query->orderBy('tahun_lulus', 'desc')
                       ->orderBy('nama')
                       ->get();
        
        return view('tu.alumni.index', compact('alumni'));
    }

    /**
     * Show the form for creating a new alumni
     */
    public function create()
    {
        return view('tu.alumni.create');
    }

    /**
     * Store a newly created alumni in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:alumnis,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'kelas_terakhir' => 'required|in:7,8,9',
            'tahun_lulus' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nama_orang_tua' => 'nullable|string|max:255',
            'pekerjaan_orang_tua' => 'nullable|string|max:255',
            'no_telepon_orang_tua' => 'nullable|string|max:20',
            'sekolah_lanjutan' => 'nullable|string|max:255',
            'prestasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos/alumni', $filename, 'public');
            $validated['foto'] = $path;
        }

        Alumni::create($validated);

        return redirect()->route('tu.alumni.index')
                        ->with('success', 'Data alumni berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified alumni
     */
    public function edit($id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('tu.alumni.edit', compact('alumni'));
    }

    /**
     * Update the specified alumni in storage
     */
    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|unique:alumnis,nis,' . $id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'kelas_terakhir' => 'required|in:7,8,9',
            'tahun_lulus' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nama_orang_tua' => 'nullable|string|max:255',
            'pekerjaan_orang_tua' => 'nullable|string|max:255',
            'no_telepon_orang_tua' => 'nullable|string|max:20',
            'sekolah_lanjutan' => 'nullable|string|max:255',
            'prestasi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($alumni->foto && Storage::disk('public')->exists($alumni->foto)) {
                Storage::disk('public')->delete($alumni->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos/alumni', $filename, 'public');
            $validated['foto'] = $path;
        }

        $alumni->update($validated);

        return redirect()->route('tu.alumni.index')
                        ->with('success', 'Data alumni berhasil diperbarui!');
    }

    /**
     * Remove the specified alumni from storage
     */
    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);

        // Delete photo if exists
        if ($alumni->foto && Storage::disk('public')->exists($alumni->foto)) {
            Storage::disk('public')->delete($alumni->foto);
        }

        $alumni->delete();

        return redirect()->route('tu.alumni.index')
                        ->with('success', 'Data alumni berhasil dihapus!');
    }

    /**
     * Export alumni data
     */
    public function export()
    {
        $alumni = Alumni::orderBy('tahun_lulus', 'desc')
                       ->orderBy('nama')
                       ->get();

        // Simple CSV export
        $filename = 'data_alumni_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($alumni) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'NIS', 'Nama', 'JK', 'Tempat Lahir', 'Tanggal Lahir',
                'Kelas Terakhir', 'Tahun Lulus', 'Alamat', 'No Telepon', 'Email',
                'Nama Orang Tua', 'Pekerjaan Orang Tua', 'No Telepon Orang Tua',
                'Sekolah Lanjutan', 'Prestasi', 'Catatan'
            ]);

            // Data
            foreach ($alumni as $item) {
                fputcsv($file, [
                    $item->nis,
                    $item->nama,
                    $item->jenis_kelamin,
                    $item->tempat_lahir,
                    $item->tanggal_lahir ? $item->tanggal_lahir->format('Y-m-d') : '',
                    $item->kelas_terakhir,
                    $item->tahun_lulus,
                    $item->alamat,
                    $item->no_telepon,
                    $item->email,
                    $item->nama_orang_tua,
                    $item->pekerjaan_orang_tua,
                    $item->no_telepon_orang_tua,
                    $item->sekolah_lanjutan,
                    $item->prestasi,
                    $item->catatan,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
