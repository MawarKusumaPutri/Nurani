<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Kepala Sekolah Dashboard</title>
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
            @include('partials.kepala-sekolah-sidebar')

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Profil Saya</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('kepala_sekolah.profile.edit') }}" class="btn btn-sm btn-primary">
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
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>NIP:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->nip ?? '-' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>No. Telepon:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->phone ?? '-' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Alamat:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $user->address ?? '-' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Role:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <span class="badge bg-success">
                                            Kepala Sekolah
                                        </span>
                                    </div>
                                </div>
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
                                    // Refresh user data dari database untuk memastikan data terbaru
                                    $freshUser = \App\Models\User::find($user->id);
                                    $photoUrl = null;
                                    $hasPhoto = false;
                                    
                                    if ($freshUser && !empty($freshUser->photo)) {
                                        // Method 1: PhotoHelper dengan default path
                                        $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshUser->photo, 'profiles/kepala_sekolah');
                                        
                                        // Method 2: PhotoHelper tanpa default path
                                        if (!$photoUrl) {
                                            $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshUser->photo);
                                        }
                                        
                                        // Method 3: Langsung cek di storage dengan path dari database
                                        if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshUser->photo)) {
                                            $baseUrl = request()->getSchemeAndHttpHost();
                                            $photoUrl = $baseUrl . '/storage/' . $freshUser->photo . '?v=' . time() . '&r=' . rand(1000, 9999);
                                        }
                                        
                                        // Method 4: Cek dengan basename di folder profiles/kepala_sekolah
                                        if (!$photoUrl) {
                                            $basename = basename($freshUser->photo);
                                            $storagePath = 'profiles/kepala_sekolah/' . $basename;
                                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                                                $baseUrl = request()->getSchemeAndHttpHost();
                                                $photoUrl = $baseUrl . '/storage/' . $storagePath . '?v=' . time() . '&r=' . rand(1000, 9999);
                                            }
                                        }
                                        
                                        // Method 5: Cek file secara langsung di disk
                                        if (!$photoUrl) {
                                            $fullPath = storage_path('app/public/' . $freshUser->photo);
                                            if (file_exists($fullPath)) {
                                                $baseUrl = request()->getSchemeAndHttpHost();
                                                $photoUrl = $baseUrl . '/storage/' . $freshUser->photo . '?v=' . time() . '&r=' . rand(1000, 9999);
                                            }
                                        }
                                        
                                        // Method 6: Jika PhotoHelper menghasilkan URL dengan localhost, ganti dengan base URL dari request
                                        if ($photoUrl && strpos($photoUrl, 'localhost') !== false) {
                                            $baseUrl = request()->getSchemeAndHttpHost();
                                            $photoUrl = str_replace('http://localhost', $baseUrl, $photoUrl);
                                        }
                                        
                                        $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null';
                                    }
                                @endphp
                                
                                @if($hasPhoto && $photoUrl)
                                    <div class="position-relative d-inline-block mb-3">
                                        <img src="{{ $photoUrl }}" alt="Foto Profil" 
                                             id="profile-photo-img"
                                             class="img-thumbnail" 
                                             style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid #2E7D32; display: block;"
                                             onload="console.log('Photo loaded successfully:', this.src);"
                                             onerror="console.error('Error loading photo:', this.src); this.onerror=null; this.style.display='none'; document.getElementById('profile-photo-placeholder').style.display='flex';">
                                        <div id="profile-photo-placeholder" class="profile-circle" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32; display: none; align-items: center; justify-content: center; border-radius: 50%; background: #f8f9fa;">
                                            <i class="fas fa-user-tie text-muted"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="profile-circle mb-3" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #f8f9fa;">
                                        <i class="fas fa-user-tie text-muted"></i>
                                    </div>
                                    <p class="text-muted">Foto profil belum diatur</p>
                                    @if(!empty($freshUser->photo))
                                        <small class="text-danger d-block mt-2">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            Foto ada di database ({{ $freshUser->photo }}) tapi tidak dapat dimuat. 
                                            Silakan coba upload ulang.
                                        </small>
                                    @endif
                                @endif
                                <a href="{{ route('kepala_sekolah.profile.edit') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="fas fa-edit"></i> {{ ($freshUser && !empty($freshUser->photo)) ? 'Ganti Foto' : 'Upload Foto' }}
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

