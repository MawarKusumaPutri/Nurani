@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Guru Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        body {
            overflow-x: hidden;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        /* Pastikan semua elemen di sidebar tidak hitam */
        .sidebar * {
            background-color: transparent !important;
        }
        
        .sidebar .p-4 {
            background: transparent !important;
        }
        
        .sidebar nav {
            background: transparent !important;
        }
        
        .sidebar .nav {
            background: transparent !important;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            position: relative !important;
            display: block !important;
            touch-action: manipulation !important;
            background: transparent !important;
            background-color: transparent !important;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.1) !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            transform: translateX(5px);
        }
        
        /* Pastikan nav-link tidak hitam */
        .sidebar .nav-link:not(:hover):not(.active) {
            background: transparent !important;
            background-color: transparent !important;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        /* Responsive Sidebar Styles */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 99999 !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            cursor: pointer !important;
            pointer-events: auto !important;
            touch-action: manipulation !important;
            min-width: 44px;
            min-height: 44px;
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.1) !important;
            z-index: 1040;
            transition: background 0.3s ease;
        }
        
        /* Pastikan overlay tidak terlalu gelap */
        .sidebar-overlay.show {
            background: rgba(0,0,0,0.1) !important;
        }
        
        /* Pastikan sidebar tidak tertutup overlay saat terbuka */
        .sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            z-index: 1061 !important;
        }
        
        /* Pastikan sidebar dengan ID juga hijau */
        #sidebar {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        #sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block !important;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1061 !important;
                transition: left 0.3s ease;
                width: 280px;
                max-width: 85%;
                height: 100vh;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
                overscroll-behavior: contain !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            .sidebar.show {
                left: 0;
                overflow-y: auto !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            /* Pastikan nav-link bisa diklik */
            .sidebar.show .nav-link {
                pointer-events: auto !important;
                cursor: pointer !important;
                z-index: 1001 !important;
                position: relative !important;
                display: block !important;
                touch-action: manipulation !important;
            }
            
            .sidebar-overlay.show {
                display: block;
                z-index: 1040 !important;
                background: rgba(0,0,0,0.1) !important;
            }
            
            /* Pastikan sidebar lebih tinggi dari overlay */
            .sidebar.show {
                z-index: 1061 !important;
            }
            
            /* Pastikan semua elemen di sidebar bisa diklik */
            .sidebar.show * {
                pointer-events: auto !important;
            }
            
            .sidebar.show .nav-link {
                pointer-events: auto !important;
                cursor: pointer !important;
                z-index: 1001 !important;
                position: relative !important;
                display: block !important;
                touch-action: manipulation !important;
                -webkit-tap-highlight-color: rgba(255, 255, 255, 0.1) !important;
            }
            
            /* Konten utama tetap di posisinya, tidak didorong ke bawah */
            .col-md-9.col-lg-10 {
                width: 100%;
                margin-left: 0;
                position: relative;
                z-index: 1;
            }
            
            /* Pastikan konten tidak bergeser saat sidebar terbuka */
            .container-fluid .row {
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0" id="sidebar" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important; background-color: #2E7D32 !important;">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Dashboard Guru
                    </h4>
                    <div class="text-center mb-4">
                        @php
                            $freshGuru = \App\Models\Guru::find($guru->id);
                            $photoUrl = null;
                            $hasPhoto = false;
                            
                            if ($freshGuru && !empty($freshGuru->foto)) {
                                $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
                                }
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'guru/foto');
                                }
                                if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time();
                                }
                                $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null' && $photoUrl !== '#';
                            }
                        @endphp
                        @if($hasPhoto && $photoUrl)
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <img src="{{ $photoUrl }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;" onerror="this.onerror=null; this.style.display='none';">
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
                    <a class="nav-link" href="{{ route('guru.dashboard') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('guru.jadwal.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Mengajar
                    </a>
                    <a class="nav-link" href="{{ route('guru.presensi.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-calendar-check me-2"></i> Presensi Guru
                    </a>
                    <a class="nav-link" href="{{ route('guru.presensi-siswa.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
                    </a>
                    <a class="nav-link" href="{{ route('guru.materi.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-book me-2"></i> Materi
                    </a>
                    <a class="nav-link" href="{{ route('guru.kuis.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-question-circle me-2"></i> Kuis
                    </a>
                    <hr class="text-white-50">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Profil</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('guru.profile.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-edit"></i> Form Edit Profil
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('guru.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto Profil</label>
                                        <div class="mb-2 position-relative d-inline-block">
                                            @php
                                                $freshGuru = \App\Models\Guru::find($guru->id);
                                                $photoUrl = null;
                                                $hasPhoto = false;
                                                
                                                if ($freshGuru && !empty($freshGuru->foto)) {
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
                                                        $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time();
                                                    }
                                                    
                                                    $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null' && $photoUrl !== '#';
                                                }
                                            @endphp
                                            <div class="position-relative d-inline-block" style="width: 150px; height: 150px; margin-bottom: 15px;">
                                                <!-- Preview Image -->
                                                <img id="photoPreview" 
                                                     src="{{ $hasPhoto && $photoUrl ? $photoUrl : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3C/svg%3E' }}" 
                                                     alt="Foto Profil" 
                                                     class="img-thumbnail" 
                                                     style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #2E7D32; {{ $hasPhoto && $photoUrl ? 'display: block;' : 'display: none;' }} position: relative; z-index: 2; background: #f8f9fa;"
                                                     onload="console.log('Photo loaded successfully:', this.src); document.getElementById('photoPlaceholder').style.display='none'; document.getElementById('photoCheckmark').style.display='flex';"
                                                     onerror="console.error('Error loading photo:', this.src); this.onerror=null; this.style.display='none'; document.getElementById('photoPlaceholder').style.display='flex'; document.getElementById('photoCheckmark').style.display='none';">
                                                
                                                <!-- Placeholder Icon -->
                                                <div id="photoPlaceholder" 
                                                     class="bg-light d-inline-flex align-items-center justify-content-center" 
                                                     style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #2E7D32; position: absolute; top: 0; left: 0; z-index: 1; {{ $hasPhoto && $photoUrl ? 'display: none;' : 'display: flex;' }} background: #f8f9fa;">
                                                    <i class="fas fa-user fa-3x text-muted"></i>
                                                </div>
                                                
                                                <!-- Checkmark indicator -->
                                                <div id="photoCheckmark" 
                                                     class="position-absolute d-flex align-items-center justify-content-center" 
                                                     style="bottom: 5px; right: 5px; background: rgba(40, 167, 69, 0.9); border-radius: 50%; width: 36px; height: 36px; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 3px solid white; {{ $hasPhoto && $photoUrl ? 'display: flex;' : 'display: none;' }}">
                                                    <i class="fas fa-check text-white" style="font-size: 16px; font-weight: bold;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewPhoto(this)">
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    </div>

                                    <hr class="my-4">

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $guru->user->name) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran" value="{{ old('mata_pelajaran', $guru->mata_pelajaran) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kontak" class="form-label">Kontak</label>
                                        <input type="text" class="form-control" id="kontak" name="kontak" value="{{ old('kontak', $guru->kontak ?? '') }}" placeholder="Nomor telepon atau WhatsApp">
                                    </div>

                                    <div class="mb-3">
                                        <label for="biodata" class="form-label">Biodata</label>
                                        <textarea class="form-control" id="biodata" name="biodata" rows="4" placeholder="Ceritakan tentang diri Anda, latar belakang pendidikan, dan pengalaman mengajar...">{{ old('biodata', $guru->biodata ?? '') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="keahlian" class="form-label">Keahlian</label>
                                        <textarea class="form-control" id="keahlian" name="keahlian" rows="3" placeholder="Tuliskan keahlian atau kompetensi khusus yang Anda miliki...">{{ old('keahlian', $guru->keahlian ?? '') }}</textarea>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="fas fa-save me-2"></i> <span id="submitText">Simpan Perubahan</span>
                                            <span id="submitSpinner" class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"></span>
                                        </button>
                                        <a href="{{ route('guru.profile.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle"></i> Informasi
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Pastikan semua informasi yang Anda masukkan sudah benar.
                                </p>
                                <p class="small text-muted">
                                    <i class="fas fa-image text-info me-2"></i>
                                    Foto profil akan ditampilkan di dashboard dan profil Anda.
                                </p>
                                <p class="small text-muted">
                                    <i class="fas fa-book text-primary me-2"></i>
                                    Mata pelajaran harus sesuai dengan mata pelajaran yang Anda ajarkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function previewPhoto(input) {
        console.log('previewPhoto called', input.files);
        
        if (input.files && input.files[0]) {
            // Validasi ukuran file (maksimal 2MB)
            const file = input.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB dalam bytes
            
            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                input.value = ''; // Reset input
                return;
            }
            
            // Validasi tipe file
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak valid! Hanya JPG, PNG, dan GIF yang diizinkan.');
                input.value = ''; // Reset input
                return;
            }
            
            const reader = new FileReader();
            const checkmark = document.getElementById('photoCheckmark');
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');
            
            // Validate file type
            const file = input.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak valid. Harap pilih file JPG, PNG, atau GIF.');
                input.value = '';
                return;
            }
            
            // Validate file size (2MB = 2097152 bytes)
            if (file.size > 2097152) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }
            
            reader.onload = function(e) {
                console.log('FileReader loaded', e.target.result);
                
                if (preview && placeholder) {
                    // Set preview image
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    preview.style.zIndex = '2';
                    
                    // Hide placeholder
                    placeholder.style.display = 'none';
                    
                    // Show checkmark with animation
                    if (checkmark) {
                        checkmark.style.display = 'flex';
                        checkmark.style.animation = 'fadeIn 0.3s ease-in';
                        checkmark.style.background = 'rgba(40, 167, 69, 0.9)';
                    }
                    
                    console.log('Preview updated successfully');
                } else {
                    console.error('Preview or placeholder element not found');
                }
            };
            
            reader.onerror = function(e) {
                console.error('FileReader error', e);
                alert('Gagal membaca file. Silakan coba lagi.');
            };
            
            reader.readAsDataURL(input.files[0]);
        } else {
            console.log('No file selected');
            // Hide checkmark if no file selected
            const checkmark = document.getElementById('photoCheckmark');
            if (checkmark) {
                checkmark.style.display = 'none';
            }
        }
    }
    
    // Show checkmark if photo already exists on page load
    document.addEventListener('DOMContentLoaded', function() {
        const preview = document.getElementById('photoPreview');
        const checkmark = document.getElementById('photoCheckmark');
        
        if (preview && checkmark) {
            // Check if preview is visible and has a valid image
            const hasValidImage = preview.src && 
                                 preview.src !== '' && 
                                 preview.src !== '#' && 
                                 preview.src !== window.location.href &&
                                 preview.style.display !== 'none' &&
                                 !preview.src.includes('data:image/svg+xml');
            
            if (hasValidImage) {
                checkmark.style.display = 'flex';
                console.log('Existing photo found, checkmark shown');
            } else {
                console.log('No existing photo');
                checkmark.style.display = 'none';
            }
        }
    });
    
    // Handle form submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action*="profile"]');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.disabled = true;
                if (submitText) submitText.textContent = 'Menyimpan...';
                if (submitSpinner) submitSpinner.classList.remove('d-none');
                
                // Re-enable after 10 seconds as fallback (in case of network issues)
                setTimeout(function() {
                    submitBtn.disabled = false;
                    if (submitText) submitText.textContent = 'Simpan Perubahan';
                    if (submitSpinner) submitSpinner.classList.add('d-none');
                }, 10000);
            });
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const isOpen = sidebar.classList.contains('show');
            
            if (isOpen) {
                // Close sidebar
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (overlay) overlay.style.display = 'none';
                // Enable body scroll when sidebar is closed
                document.body.style.overflow = '';
                document.body.style.position = '';
                document.body.style.width = '';
                document.body.style.height = '';
                document.body.style.top = '';
                document.body.style.background = '#ffffff';
                document.body.style.backgroundColor = '#ffffff';
            } else {
                // Open sidebar
                sidebar.classList.add('show');
                overlay.classList.add('show');
                if (overlay) overlay.style.display = 'block';
                // Prevent body scroll when sidebar is open
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
                
                // Setup nav links setelah sidebar terbuka
                setTimeout(function() {
                    setupNavLinks();
                }, 100);
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (window.innerWidth <= 991) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (overlay) overlay.style.display = 'none';
            }
            // Always reset body styles regardless of screen size
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        }
        
        // Ensure body has white background on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
            
            // Ensure toggle button is clickable
            const toggleBtn = document.querySelector('.sidebar-toggle');
            if (toggleBtn) {
                toggleBtn.style.setProperty('pointer-events', 'auto', 'important');
                toggleBtn.style.setProperty('z-index', '99999', 'important');
                toggleBtn.style.setProperty('cursor', 'pointer', 'important');
                
                // Add multiple event listeners to ensure it works
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                }, false);
                
                toggleBtn.addEventListener('touchstart', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                }, false);
                
                toggleBtn.addEventListener('touchend', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                }, false);
                
                toggleBtn.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                }, false);
            }
        });
        
        // Ensure nav links navigate properly - DIPANGGIL SETELAH SIDEBAR TERBUKA
        function setupNavLinks() {
            const navLinks = document.querySelectorAll('.sidebar .nav-link, #guru-sidebar .nav-link');
            navLinks.forEach(function(link) {
                // Force styles dengan !important - PASTIKAN BISA DIKLIK
                link.style.setProperty('pointer-events', 'auto', 'important');
                link.style.setProperty('cursor', 'pointer', 'important');
                link.style.setProperty('z-index', '1001', 'important');
                link.style.setProperty('position', 'relative', 'important');
                link.style.setProperty('display', 'block', 'important');
                link.style.setProperty('touch-action', 'manipulation', 'important');
                link.style.setProperty('text-decoration', 'none', 'important');
                link.style.setProperty('-webkit-tap-highlight-color', 'rgba(255, 255, 255, 0.1)', 'important');
                
                // Pastikan child elements tidak menghalangi
                const children = link.querySelectorAll('*');
                children.forEach(function(child) {
                    child.style.setProperty('pointer-events', 'none', 'important');
                });
                
                // JANGAN clone - biarkan href normal bekerja
                const href = link.getAttribute('href');
                if (href && href !== '#' && href !== 'javascript:void(0)') {
                    // Pastikan href tetap ada
                    if (!link.href || link.href === window.location.href) {
                        link.href = href;
                    }
                    
                    // Tambahkan click handler yang MEMASTIKAN navigasi
                    link.addEventListener('click', function(e) {
                        console.log('✓ Nav link clicked:', href);
                        // Biarkan browser navigate secara normal - JANGAN preventDefault
                        closeSidebar();
                    }, false);
                    
                    // Touch handler untuk mobile
                    link.addEventListener('touchend', function(e) {
                        console.log('✓ Nav link touched:', href);
                        closeSidebar();
                        window.location.href = href;
                        e.preventDefault();
                        return false;
                    }, false);
                }
            });
        }
                
                // Add touch event listener untuk mobile
                link.addEventListener('touchend', function(e) {
                    console.log('Nav link touched:', link.href);
                    const href = link.getAttribute('href');
                    
                    if (href && href !== '#' && href !== 'javascript:void(0)') {
                        closeSidebar();
                        // Navigate
                        window.location.href = href;
                        e.preventDefault();
                        return false;
                    }
                }, false);
            });
        }
        
        // Setup nav links saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            setupNavLinks();
            
            // Setup ulang setiap kali sidebar dibuka
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                const observer = new MutationObserver(function(mutations) {
                    if (sidebar.classList.contains('show')) {
                        setTimeout(setupNavLinks, 100);
                    }
                });
                observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
            }
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const overlay = document.querySelector('.sidebar-overlay');
            
            // Don't close if clicking on a nav link
            if (event.target.closest('.nav-link')) {
                return;
            }
            
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(event.target) && 
                    !toggleBtn.contains(event.target) && 
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    if (overlay) overlay.style.display = 'none';
                    // Enable body scroll when sidebar is closed
                    document.body.style.overflow = '';
                    document.body.style.position = '';
                    document.body.style.width = '';
                    document.body.style.height = '';
                    document.body.style.top = '';
                    document.body.style.background = '#ffffff';
                    document.body.style.backgroundColor = '#ffffff';
                }
            }
        });
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }
    </style>
</body>
</html>


