<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\GuruMataPelajaran;
use Illuminate\Support\Facades\Auth;

class GuruMataPelajaranController extends Controller
{
    /**
     * Get available subjects for the logged-in guru
     */
    public function getAvailableSubjects()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return response()->json(['error' => 'Guru not found'], 404);
        }

        // Parse mata pelajaran from guru record
        $mataPelajaranList = [];
        if ($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan') {
            $subjects = explode(', ', $guru->mata_pelajaran);
            foreach ($subjects as $subject) {
                $mataPelajaranList[] = [
                    'value' => trim($subject),
                    'label' => trim($subject)
                ];
            }
        }

        return response()->json([
            'subjects' => $mataPelajaranList,
            'current_subject' => session('selected_mata_pelajaran', $mataPelajaranList[0]['value'] ?? null)
        ]);
    }

    /**
     * Set selected subject for the session
     */
    public function setSelectedSubject(Request $request)
    {
        $request->validate([
            'mata_pelajaran' => 'required|string'
        ]);

        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return response()->json(['error' => 'Guru not found'], 404);
        }

        // Verify that the selected subject is available for this guru
        $availableSubjects = [];
        if ($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan') {
            $availableSubjects = explode(', ', $guru->mata_pelajaran);
            $availableSubjects = array_map('trim', $availableSubjects);
        }

        if (!in_array($request->mata_pelajaran, $availableSubjects)) {
            return response()->json(['error' => 'Mata pelajaran tidak tersedia untuk guru ini'], 400);
        }

        // Store selected subject in session
        session(['selected_mata_pelajaran' => $request->mata_pelajaran]);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil dipilih',
            'selected_subject' => $request->mata_pelajaran
        ]);
    }

    /**
     * Get current selected subject
     */
    public function getCurrentSubject()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        
        if (!$guru) {
            return response()->json(['error' => 'Guru not found'], 404);
        }

        $currentSubject = session('selected_mata_pelajaran');
        
        // If no subject is selected, get the first available subject
        if (!$currentSubject) {
            if ($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan') {
                $subjects = explode(', ', $guru->mata_pelajaran);
                $currentSubject = trim($subjects[0]);
                session(['selected_mata_pelajaran' => $currentSubject]);
            }
        }

        return response()->json([
            'current_subject' => $currentSubject,
            'all_subjects' => $guru->mata_pelajaran
        ]);
    }
}