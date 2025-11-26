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
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Dashboard Guru
                    </h4>
                    <div class="text-center mb-4">
                        @php
                            // SELALU ambil data fresh dari database untuk memastikan foto terbaru
                            $freshGuru = \App\Models\Guru::find($guru->id);
                            $photoPath = $freshGuru->foto ?? null;
                            $photoUrl = null;
                            $hasPhoto = false;
                            
                            if ($freshGuru && !empty($freshGuru->foto)) {
                                // Method 1: PhotoHelper dengan default path
                                $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                
                                // Method 2: PhotoHelper dengan path lain
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
                                }
                                
                                // Method 3: PhotoHelper dengan path guru/foto
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'guru/foto');
                                }
                                
                                // Method 4: Langsung cek di storage dengan path dari database
                                if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                }
                                
                                // Method 5: Cek dengan basename di folder profiles/guru
                                if (!$photoUrl) {
                                    $basename = basename($freshGuru->foto);
                                    $storagePath = 'profiles/guru/' . $basename;
                                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                                        $baseUrl = request()->getSchemeAndHttpHost();
                                        $photoUrl = $baseUrl . '/storage/' . $storagePath . '?v=' . time() . '&r=' . rand(1000, 9999);
                                    }
                                }
                                
                                // Method 6: Cek file secara langsung di disk
                                if (!$photoUrl) {
                                    $fullPath = storage_path('app/public/' . $freshGuru->foto);
                                    if (file_exists($fullPath)) {
                                        $baseUrl = request()->getSchemeAndHttpHost();
                                        $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                    }
                                }
                                
                                // Method 7: Jika PhotoHelper menghasilkan URL dengan localhost, ganti dengan base URL dari request
                                if ($photoUrl && strpos($photoUrl, 'localhost') !== false) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = str_replace('http://localhost', $baseUrl, $photoUrl);
                                }
                                
                                $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null';
                            }
                        @endphp
                        @if($hasPhoto && $photoUrl)
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <img src="{{ $photoUrl }}" alt="Foto Profil" id="profile-photo-img-guru-sidebar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;" onload="console.log('Sidebar photo loaded:', this.src);" onerror="console.error('Sidebar photo error:', this.src); this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder-guru-sidebar').style.display='flex';">
                                <div id="profile-placeholder-guru-sidebar" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 100px; height: 100px; top: 0; left: 0; z-index: 1;">
                                <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('guru.jadwal.index') }}">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Mengajar
                    </a>
                    <a class="nav-link" href="{{ route('guru.presensi.index') }}">
                        <i class="fas fa-calendar-check me-2"></i> Presensi Guru
                    </a>
                    <a class="nav-link" href="{{ route('guru.presensi-siswa.index') }}">
                        <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
                    </a>
                    <a class="nav-link" href="{{ route('guru.materi.index') }}">
                        <i class="fas fa-book me-2"></i> Materi
                    </a>
                    <a class="nav-link" href="{{ route('guru.kuis.index') }}">
                        <i class="fas fa-question-circle me-2"></i> Kuis
                    </a>
                    <hr class="text-white-50">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

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
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user-circle"></i> Foto Profil
                                </h5>
                            </div>
                            <div class="card-body text-center">
                                @php
                                    // SELALU ambil data fresh dari database untuk memastikan foto terbaru
                                    $freshGuru = \App\Models\Guru::find($guru->id);
<<<<<<< HEAD
                                    $photoPath = $freshGuru->foto ?? null;
                                    $photoUrl = null;
                                    $hasPhoto = false;
                                    
                                    if ($photoPath) {
                                        // OTOMATIS cari foto dengan default path yang benar
                                        $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($photoPath, 'profiles/guru');
                                        
                                        // Jika masih null, coba dengan path lain
                                        if (!$photoUrl) {
                                            $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($photoPath, 'image/profiles');
                                        }
                                        
                                        // Jika masih null, coba langsung dengan asset() untuk URL lengkap
                                        if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath)) {
                                            $photoUrl = asset('storage/' . $photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                                        }
                                        
                                        // Jika masih null, coba dengan path absolut
                                        if (!$photoUrl) {
                                            $storagePath = storage_path('app/public/' . $photoPath);
                                            if (file_exists($storagePath)) {
                                                $photoUrl = asset('storage/' . $photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                                            }
                                        }
                                        
                                        // Jika masih null, coba langsung dengan path dari database
                                        if (!$photoUrl) {
                                            // Coba berbagai kemungkinan path
                                            $possiblePaths = [
                                                'storage/' . $photoPath,
                                                'storage/profiles/guru/' . basename($photoPath),
                                                'storage/image/profiles/' . basename($photoPath),
                                                $photoPath
                                            ];
                                            
                                            foreach ($possiblePaths as $possiblePath) {
                                                $fullPath = public_path($possiblePath);
                                                if (file_exists($fullPath)) {
                                                    $photoUrl = asset($possiblePath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                                                    break;
                                                }
                                            }
                                        }
                                        
                                        $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null';
                                    }
                                @endphp
                                @if($hasPhoto && $photoUrl)
                                    <div class="position-relative d-inline-block mb-3">
                                        <img src="{{ $photoUrl }}" alt="Foto Profil" 
                                             id="profile-photo-img-main"
                                             class="img-thumbnail" 
                                             style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid #2E7D32; display: block;"
                                             onload="console.log('Photo loaded successfully:', this.src);"
                                             onerror="console.error('Error loading photo:', this.src); this.onerror=null; this.style.display='none'; document.getElementById('profile-photo-placeholder-main').style.display='flex';">
                                        <div id="profile-photo-placeholder-main" class="profile-circle mb-3 d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32; border-radius: 50%; background: #f0f0f0; display: none;">
                                            <i class="fas fa-user-tie text-secondary"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="profile-circle mb-3 d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32; border-radius: 50%; background: #f0f0f0;">
                                        <i class="fas fa-user-tie text-secondary"></i>
                                    </div>
                                    <p class="text-muted">Foto profil belum diatur</p>
                                    @if(!empty($freshGuru->foto))
                                        <small class="text-danger d-block mt-2">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            Foto ada di database ({{ $freshGuru->foto }}) tapi tidak dapat dimuat. 
                                            Silakan coba upload ulang.
                                        </small>
                                    @endif
                                @endif
                                <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="fas fa-edit"></i> {{ ($freshGuru && !empty($freshGuru->foto)) ? 'Ganti Foto' : 'Upload Foto' }}
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

