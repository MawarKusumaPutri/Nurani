<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Guru;
use App\Imports\JadwalImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class JadwalImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120', // max 5MB
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => 'required|string',
        ], [
            'file.required' => 'File Excel harus diupload.',
            'file.mimes' => 'File harus berformat Excel (.xlsx atau .xls).',
            'file.max' => 'Ukuran file maksimal 5MB.',
            'semester.required' => 'Semester harus dipilih.',
            'tahun_ajaran.required' => 'Tahun ajaran harus diisi.',
        ]);

        try {
            $file = $request->file('file');
            
            Log::info('=== START IMPORT JADWAL ===');
            Log::info('File: ' . $file->getClientOriginalName());
            Log::info('Semester: ' . $request->semester);
            Log::info('Tahun Ajaran: ' . $request->tahun_ajaran);
            
            // Import using JadwalImport class
            $import = new JadwalImport(
                $request->semester,
                $request->tahun_ajaran,
                auth()->id()
            );
            
            Excel::import($import, $file);
            
            $successCount = $import->getSuccessCount();
            $errorCount = $import->getErrorCount();
            $errors = $import->getErrors();
            
            Log::info("Import completed: {$successCount} berhasil, {$errorCount} gagal");
            
            if ($errorCount > 0) {
                $errorMessage = "Import selesai dengan {$successCount} data berhasil dan {$errorCount} data gagal.<br><br>Detail error:<br>";
                $errorMessage .= implode('<br>', array_slice($errors, 0, 10)); // Tampilkan max 10 error
                
                if (count($errors) > 10) {
                    $errorMessage .= '<br>... dan ' . (count($errors) - 10) . ' error lainnya.';
                }
                
                return redirect()->route('tu.jadwal.index')
                    ->with('warning', $errorMessage);
            }
            
            return redirect()->route('tu.jadwal.index')
                ->with('success', "✅ Berhasil import {$successCount} jadwal pelajaran!");
                
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = "Validasi gagal:<br>";
            
            foreach ($failures as $failure) {
                $errorMessage .= "Baris {$failure->row()}: " . implode(', ', $failure->errors()) . "<br>";
            }
            
            Log::error('Validation error: ' . $errorMessage);
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
                
        } catch (\Exception $e) {
            Log::error('Error importing jadwal: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal import jadwal: ' . $e->getMessage());
        }
    }
    
    public function downloadTemplate()
    {
        $filename = 'template_import_jadwal.xlsx';
        $filepath = public_path('templates/' . $filename);
        
        if (file_exists($filepath)) {
            return response()->download($filepath);
        }
        
        return redirect()->back()->with('error', 'Template tidak ditemukan.');
    }
}
