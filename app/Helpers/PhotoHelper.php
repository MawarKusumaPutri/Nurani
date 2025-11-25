<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class PhotoHelper
{
    /**
     * Get photo URL from various possible locations
     * Supports:
     * - Relative path from storage (guru/foto/xxx.jpg)
     * - Absolute path (D:\path\to\photo.jpg)
     * - URL (http://example.com/photo.jpg)
     * - Path from public directory (image/foto/xxx.jpg)
     */
    public static function getPhotoUrl($photoPath, $defaultPath = null)
    {
        if (empty($photoPath)) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($photoPath, FILTER_VALIDATE_URL)) {
            return $photoPath . '?v=' . time() . '&r=' . rand(1000, 9999);
        }

        // If it's an absolute path (Windows or Unix)
        if (preg_match('/^[A-Z]:\\\\|^\/|^\\\\/', $photoPath)) {
            // Convert absolute path to URL
            $publicPath = public_path();
            if (strpos($photoPath, $publicPath) === 0) {
                // Path is inside public directory
                $relativePath = str_replace($publicPath, '', $photoPath);
                $relativePath = str_replace('\\', '/', ltrim($relativePath, '/\\'));
                return url($relativePath) . '?v=' . time() . '&r=' . rand(1000, 9999);
            } else {
                // Path is outside public directory - create symlink or copy
                // For now, try to access via asset if possible
                // Or return the path as is if it's accessible
                return $photoPath;
            }
        }

        // Check if it's a storage path (profiles/guru/xxx.jpg, profiles/tu/xxx.jpg, etc)
        // PRIORITAS 1: Cek di storage dengan path lengkap
        if (Storage::disk('public')->exists($photoPath)) {
            // Gunakan url() untuk memastikan URL lengkap dengan base URL dari request
            // url() otomatis menggunakan base URL dari request saat ini
            $url = url('storage/' . $photoPath);
            // Verifikasi URL bisa diakses
            if ($url) {
                return $url . '?v=' . time() . '&r=' . rand(1000, 9999);
            }
        }

        // PRIORITAS 2: Cek dengan path absolut di storage
        $storageFullPath = storage_path('app/public/' . $photoPath);
        if (file_exists($storageFullPath)) {
            // Gunakan url() untuk memastikan URL lengkap dengan base URL dari request
            $url = url('storage/' . $photoPath);
            if ($url) {
                return $url . '?v=' . time() . '&r=' . rand(1000, 9999);
            }
        }

        // PRIORITAS 3: Try old format: guru/foto/xxx.jpg or photos/xxx.jpg
        if (strpos($photoPath, 'guru/foto/') === 0 || strpos($photoPath, 'photos/') === 0) {
            // Cek di storage
            if (Storage::disk('public')->exists($photoPath)) {
                return url('storage/' . $photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
            }
            // Cek dengan path absolut
            $oldPath = storage_path('app/public/' . $photoPath);
            if (file_exists($oldPath)) {
                return url('storage/' . $photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
            }
        }
        
        // PRIORITAS 3.5: Handle path hanya nama file (photos/xxx.jpg menjadi photos/xxx.jpg)
        if (strpos($photoPath, '/') === false && strpos($photoPath, '\\') === false) {
            // Path hanya nama file, coba cari di berbagai lokasi
            $possiblePaths = [
                'profiles/guru/' . $photoPath,
                'profiles/tu/' . $photoPath,
                'profiles/kepala_sekolah/' . $photoPath,
                'photos/' . $photoPath,
                'guru/foto/' . $photoPath
            ];
            
            foreach ($possiblePaths as $possiblePath) {
                $fullPath = storage_path('app/public/' . $possiblePath);
                if (file_exists($fullPath)) {
                    return asset('storage/' . $possiblePath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                }
            }
        }

        // PRIORITAS 4: Check if it's in public directory (image/profiles/xxx.jpg or image/foto/xxx.jpg)
        $publicPath = public_path($photoPath);
        if (file_exists($publicPath)) {
                return url($photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
        }

        // Try with default path if provided
        if ($defaultPath) {
            // Try with full path
            $defaultFullPath = public_path($defaultPath . '/' . basename($photoPath));
            if (file_exists($defaultFullPath)) {
                return url($defaultPath . '/' . basename($photoPath)) . '?v=' . time() . '&r=' . rand(1000, 9999);
            }
            
            // Try with path from photoPath
            $pathParts = explode('/', $photoPath);
            $filename = end($pathParts);
            $defaultFullPath2 = public_path($defaultPath . '/' . $filename);
            if (file_exists($defaultFullPath2)) {
                return url($defaultPath . '/' . $filename) . '?v=' . time() . '&r=' . rand(1000, 9999);
            }
        }

        // Last resort: try to construct URL from path
        // OTOMATIS CARI FILE - tidak peduli format path di database
        // Jika path mengandung 'profiles' atau 'photos' atau 'guru/foto', coba berbagai kemungkinan
        if (strpos($photoPath, 'profiles') !== false || strpos($photoPath, 'photos') !== false || strpos($photoPath, 'guru/foto') !== false || strpos($photoPath, '/') !== false || strpos($photoPath, '\\') !== false) {
            // Cek apakah file benar-benar ada di storage dengan path yang diberikan
            $storageFullPath = storage_path('app/public/' . $photoPath);
            if (file_exists($storageFullPath)) {
                // Gunakan asset() untuk memastikan URL lengkap dengan base URL
                return url('storage/' . $photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
            }
        }
        
        // OTOMATIS CARI FILE BERDASARKAN NAMA FILE SAJA
        // Ambil nama file dari path (bisa dari berbagai format)
        $filename = basename($photoPath);
        if (!empty($filename) && $filename !== $photoPath) {
            // Cari di semua kemungkinan lokasi
            $possiblePaths = [
                'profiles/guru/' . $filename,
                'profiles/tu/' . $filename,
                'profiles/kepala_sekolah/' . $filename,
                'guru/foto/' . $filename,
                'photos/' . $filename,
                'image/profiles/' . $filename,
                'image/foto/' . $filename
            ];
            
            foreach ($possiblePaths as $possiblePath) {
                // Cek di storage
                $fullPath = storage_path('app/public/' . $possiblePath);
                if (file_exists($fullPath)) {
                    return asset('storage/' . $possiblePath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                }
                
                // Cek di public
                $publicFullPath = public_path($possiblePath);
                if (file_exists($publicFullPath)) {
                    return url($possiblePath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                }
            }
        }
        
        // Jika path hanya nama file (tanpa folder), cari di semua lokasi
        if (strpos($photoPath, '/') === false && strpos($photoPath, '\\') === false && !empty($photoPath)) {
            $possiblePaths = [
                'profiles/guru/' . $photoPath,
                'profiles/tu/' . $photoPath,
                'profiles/kepala_sekolah/' . $photoPath,
                'guru/foto/' . $photoPath,
                'photos/' . $photoPath,
                'image/profiles/' . $photoPath,
                'image/foto/' . $photoPath
            ];
            
            foreach ($possiblePaths as $possiblePath) {
                // Cek di storage
                $fullPath = storage_path('app/public/' . $possiblePath);
                if (file_exists($fullPath)) {
                    return asset('storage/' . $possiblePath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                }
                
                // Cek di public
                $publicFullPath = public_path($possiblePath);
                if (file_exists($publicFullPath)) {
                    return url($possiblePath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                }
            }
        }
        
        // Coba langsung return URL meskipun file tidak ditemukan (untuk debugging)
        // Tapi hanya jika path terlihat valid
        if (strpos($photoPath, 'profiles') !== false || strpos($photoPath, 'photos') !== false || strpos($photoPath, 'guru/foto') !== false) {
            return asset('storage/' . $photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
        }

        return null;
    }

    /**
     * Save photo to flexible location
     * Can save to:
     * - Storage (default)
     * - Public directory
     * - Custom location
     */
    public static function savePhoto($file, $basePath = 'profiles', $useStorage = true)
    {
        try {
            $filename = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            
            if ($useStorage) {
                // OTOMATIS BUAT FOLDER - Pastikan semua folder parent ada
                $storagePath = storage_path('app/public/' . $basePath);
                
                // Buat folder secara rekursif jika belum ada
                if (!file_exists($storagePath)) {
                    if (!mkdir($storagePath, 0755, true)) {
                        \Log::error('Gagal membuat folder: ' . $storagePath);
                        // Coba lagi dengan path yang lebih spesifik
                        $parts = explode('/', $basePath);
                        $currentPath = storage_path('app/public');
                        foreach ($parts as $part) {
                            $currentPath .= '/' . $part;
                            if (!file_exists($currentPath)) {
                                if (!mkdir($currentPath, 0755, true)) {
                                    \Log::error('Gagal membuat folder: ' . $currentPath);
                                }
                            }
                        }
                    }
                }
                
                // Verifikasi folder sudah ada
                if (!file_exists($storagePath)) {
                    \Log::error('Folder tidak ada setelah dibuat: ' . $storagePath);
                    return null;
                }
                
                // Save to storage
                $path = $file->storeAs($basePath, $filename, 'public');
                if ($path && Storage::disk('public')->exists($path)) {
                    return $path; // Return relative path: basePath/filename
                } else {
                    \Log::error('File tidak tersimpan atau tidak ditemukan: ' . $path);
                }
            } else {
                // OTOMATIS BUAT FOLDER - Pastikan semua folder parent ada
                $publicPath = public_path($basePath);
                
                // Buat folder secara rekursif jika belum ada
                if (!file_exists($publicPath)) {
                    if (!mkdir($publicPath, 0755, true)) {
                        \Log::error('Gagal membuat folder: ' . $publicPath);
                        // Coba lagi dengan path yang lebih spesifik
                        $parts = explode('/', $basePath);
                        $currentPath = public_path();
                        foreach ($parts as $part) {
                            $currentPath .= '/' . $part;
                            if (!file_exists($currentPath)) {
                                if (!mkdir($currentPath, 0755, true)) {
                                    \Log::error('Gagal membuat folder: ' . $currentPath);
                                }
                            }
                        }
                    }
                }
                
                // Verifikasi folder sudah ada
                if (!file_exists($publicPath)) {
                    \Log::error('Folder tidak ada setelah dibuat: ' . $publicPath);
                    return null;
                }
                
                $fullPath = $publicPath . '/' . $filename;
                if ($file->move($publicPath, $filename)) {
                    return $basePath . '/' . $filename; // Return relative path from public
                } else {
                    \Log::error('File tidak bisa dipindahkan ke: ' . $publicPath);
                }
            }
            
            return null;
        } catch (\Exception $e) {
            \Log::error('Error saving photo: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }

    /**
     * Check if photo exists in various locations
     */
    public static function photoExists($photoPath)
    {
        if (empty($photoPath)) {
            return false;
        }

        // Check absolute path
        if (preg_match('/^[A-Z]:\\\\|^\/|^\\\\/', $photoPath)) {
            return file_exists($photoPath);
        }

        // Check storage
        if (Storage::disk('public')->exists($photoPath)) {
            return true;
        }

        // Check public directory
        $publicPath = public_path($photoPath);
        if (file_exists($publicPath)) {
            return true;
        }

        return false;
    }

    /**
     * Delete photo from various locations
     */
    public static function deletePhoto($photoPath)
    {
        if (empty($photoPath)) {
            return false;
        }

        try {
            // Try to delete from storage
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
                return true;
            }

            // Try to delete from public directory
            $publicPath = public_path($photoPath);
            if (file_exists($publicPath)) {
                unlink($publicPath);
                return true;
            }

            // Try absolute path
            if (preg_match('/^[A-Z]:\\\\|^\/|^\\\\/', $photoPath) && file_exists($photoPath)) {
                unlink($photoPath);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Error deleting photo: ' . $e->getMessage());
            return false;
        }
    }
}


