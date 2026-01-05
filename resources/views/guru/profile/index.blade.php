@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Guru Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
    </style>
    @include('partials.guru-fixed-layout')
    @include('partials.guru-dynamic-ui')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Profil Saya</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user"></i> Informasi Profil
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Nama Lengkap:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $guru->user->name }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $guru->user->email }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>NIP:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $guru->nip }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Mata Pelajaran:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $guru->mata_pelajaran }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Kontak:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $guru->kontak ?? $guru->user->phone ?? '-' }}
                                    </div>
                                </div>
                                @if($guru->biodata)
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Biodata:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $guru->biodata }}
                                    </div>
                                </div>
                                @endif
                                @if($guru->keahlian)
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Keahlian:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $guru->keahlian }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user-circle me-2"></i>Foto Profil
                                </h5>
                            </div>
                            <div class="card-body text-center p-4">
                                @php
                                    // SELALU ambil data fresh dari database untuk memastikan foto terbaru
                                    $freshGuru = \App\Models\Guru::find($guru->id);
                                    $photoPath = $freshGuru->foto ?? null;
                                    $photoUrl = null;
                                    $hasPhoto = false;
                                    
                                    if ($freshGuru && !empty($freshGuru->foto)) {
                                        // Debug: Log path foto dari database
                                        \Log::info('Trying to load photo for guru', [
                                            'guru_id' => $freshGuru->id,
                                            'foto_path_in_db' => $freshGuru->foto
                                        ]);
                                        
                                        // OTOMATIS cari foto dengan berbagai kemungkinan path
                                        $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                        
                                        // Jika masih null, coba dengan path lain
                                        if (!$photoUrl) {
                                            $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
                                        }
                                        
                                        // Jika masih null, coba dengan path lain lagi
                                        if (!$photoUrl) {
                                            $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'guru/foto');
                                        }
                                        
                                        // Jika masih null, coba langsung dengan base URL dari request
                                        if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                                            $baseUrl = request()->getSchemeAndHttpHost();
                                            $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                        }
                                        
                                        // Jika masih null, coba dengan basename di folder profiles/guru
                                        if (!$photoUrl) {
                                            $basename = basename($freshGuru->foto);
                                            $storagePath = 'profiles/guru/' . $basename;
                                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                                                $baseUrl = request()->getSchemeAndHttpHost();
                                                $photoUrl = $baseUrl . '/storage/' . $storagePath . '?v=' . time() . '&r=' . rand(1000, 9999);
                                            }
                                        }
                                        
                                        // Jika masih null, cek file secara langsung di disk dengan berbagai kemungkinan path
                                        if (!$photoUrl) {
                                            $possiblePaths = [
                                                $freshGuru->foto,
                                                'profiles/guru/' . basename($freshGuru->foto),
                                                'guru/foto/' . basename($freshGuru->foto),
                                                'image/profiles/' . basename($freshGuru->foto)
                                            ];
                                            
                                            foreach ($possiblePaths as $possiblePath) {
                                                $fullPath = storage_path('app/public/' . $possiblePath);
                                                if (file_exists($fullPath)) {
                                                    $baseUrl = request()->getSchemeAndHttpHost();
                                                    $photoUrl = $baseUrl . '/storage/' . $possiblePath . '?v=' . time() . '&r=' . rand(1000, 9999);
                                                    \Log::info('Photo found at path', ['path' => $possiblePath, 'url' => $photoUrl]);
                                                    break;
                                                }
                                            }
                                        }
                                        
                                        // Jika masih null, coba langsung construct URL dari path di database
                                        if (!$photoUrl && !empty($freshGuru->foto)) {
                                            $baseUrl = request()->getSchemeAndHttpHost();
                                            // Coba langsung dengan path dari database
                                            $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                            \Log::info('Trying direct URL construction', ['url' => $photoUrl]);
                                        }
                                        
                                        $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null' && $photoUrl !== '#';
                                        
                                        \Log::info('Photo URL result', [
                                            'has_photo' => $hasPhoto,
                                            'photo_url' => $photoUrl
                                        ]);
                                    }
                                @endphp
                                
                                <div class="mb-3">
                                    @if($hasPhoto && $photoUrl)
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ $photoUrl }}" alt="Foto Profil" 
                                                 id="profile-photo-img-main"
                                                 class="img-thumbnail" 
                                                 style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid #2E7D32; display: block; cursor: pointer;"
                                                 onload="console.log('Photo loaded successfully:', this.src); this.style.display='block'; document.getElementById('profile-photo-placeholder-main').style.display='none';"
                                                 onerror="console.error('Error loading photo:', this.src); this.onerror=null; this.style.display='none'; document.getElementById('profile-photo-placeholder-main').style.display='flex';"
                                                 onclick="if(this.src && this.src !== '') { window.open(this.src, '_blank'); }">
                                            <div id="profile-photo-placeholder-main" class="profile-circle d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32; border-radius: 50%; background: #f0f0f0; display: none;">
                                                <i class="fas fa-user-tie text-secondary"></i>
                                            </div>
                                        </div>
                                    @elseif(!empty($freshGuru->foto))
                                        {{-- Jika ada path di database tapi tidak bisa dimuat, coba tampilkan dengan URL langsung --}}
                                        @php
                                            $baseUrl = request()->getSchemeAndHttpHost();
                                            $directUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                        @endphp
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ $directUrl }}" alt="Foto Profil" 
                                                 id="profile-photo-img-main"
                                                 class="img-thumbnail" 
                                                 style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid #2E7D32; display: block; cursor: pointer;"
                                                 onload="console.log('Photo loaded successfully (direct):', this.src); this.style.display='block'; document.getElementById('profile-photo-placeholder-main').style.display='none';"
                                                 onerror="console.error('Error loading photo (direct):', this.src); this.onerror=null; this.style.display='none'; document.getElementById('profile-photo-placeholder-main').style.display='flex';"
                                                 onclick="if(this.src && this.src !== '') { window.open(this.src, '_blank'); }">
                                            <div id="profile-photo-placeholder-main" class="profile-circle d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32; border-radius: 50%; background: #f0f0f0; display: none;">
                                                <i class="fas fa-user-tie text-secondary"></i>
                                            </div>
                                        </div>
                                        <small class="text-info d-block mt-2">
                                            <i class="fas fa-info-circle"></i> 
                                            Path foto: {{ $freshGuru->foto }}
                                        </small>
                                    @else
                                        <div class="profile-circle d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px; font-size: 72px; border: 3px solid #2E7D32; border-radius: 50%; background: #f0f0f0;">
                                            <i class="fas fa-user-tie text-secondary"></i>
                                        </div>
                                        <p class="text-muted mt-3 mb-0">Foto profil belum diatur</p>
                                    @endif
                                </div>
                                
                                <a href="{{ route('guru.profile.edit') }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>{{ ($freshGuru && !empty($freshGuru->foto)) ? 'Ganti Foto' : 'Upload Foto' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

