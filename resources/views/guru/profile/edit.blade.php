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
                        @if($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="Foto Profil" 
                                 class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
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
                    <h1 class="h2">Edit Profil</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('guru.profile.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

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
                                                
<<<<<<< HEAD
                                                if ($freshGuru && $freshGuru->foto) {
                                                    // OTOMATIS cari foto dengan default path yang benar
                                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
                                                    
                                                    // Jika masih null, coba dengan path lain
                                                    if (!$photoUrl) {
                                                        $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                                    }
                                                    
                                                    // Jika masih null, coba langsung dengan asset() untuk URL lengkap
                                                    if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                                                        $photoUrl = asset('storage/' . $freshGuru->foto) . '?v=' . time();
                                                    }
                                                    
                                                    // Jika masih null, coba dengan path absolut
                                                    if (!$photoUrl) {
                                                        $storagePath = storage_path('app/public/' . $freshGuru->foto);
                                                        if (file_exists($storagePath)) {
                                                            $photoUrl = asset('storage/' . $freshGuru->foto) . '?v=' . time();
                                                        }
                                                    }
                                                    
                                                    $hasPhoto = $photoUrl !== null && $photoUrl !== '';
                                                }
                                            @endphp
                                            <div class="position-relative d-inline-block" style="width: 150px; height: 150px;">
                                                <img id="photoPreview" src="{{ $hasPhoto ? $photoUrl : '' }}" alt="Foto Profil" class="img-thumbnail {{ !$hasPhoto ? 'd-none' : '' }}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; position: relative; z-index: 1;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('photoPlaceholder').style.display='flex';">
                                                <div id="photoPlaceholder" class="bg-light d-inline-flex align-items-center justify-content-center {{ $hasPhoto ? 'd-none' : '' }}" style="width: 150px; height: 150px; border-radius: 50%; position: absolute; top: 0; left: 0; z-index: 0;">
=======
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
>>>>>>> 5f41084b51ea9f60057a6b73d46e022c2cca4807
                                                    <i class="fas fa-user fa-3x text-muted"></i>
                                                </div>
                                                
                                                <!-- Checkmark indicator -->
<<<<<<< HEAD
                                                <div id="photoCheckmark" class="position-absolute d-none" style="bottom: 5px; right: 5px; background: rgba(0,0,0,0.8); border-radius: 50%; width: 32px; height: 32px; align-items: center; justify-content: center; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 2px solid white;">
                                                    <i class="fas fa-check text-white" style="font-size: 18px; font-weight: bold;"></i>
=======
                                                <div id="photoCheckmark" 
                                                     class="position-absolute d-flex align-items-center justify-content-center" 
                                                     style="bottom: 5px; right: 5px; background: rgba(40, 167, 69, 0.9); border-radius: 50%; width: 36px; height: 36px; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 3px solid white; {{ $hasPhoto && $photoUrl ? 'display: flex;' : 'display: none;' }}">
                                                    <i class="fas fa-check text-white" style="font-size: 16px; font-weight: bold;"></i>
>>>>>>> 5f41084b51ea9f60057a6b73d46e022c2cca4807
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
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i> Simpan Perubahan
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
<<<<<<< HEAD
            
            reader.onload = function(e) {
                if (preview && placeholder) {
                    // Set preview image
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    preview.style.display = 'block';
                    
                    // Hide placeholder
                    placeholder.classList.add('d-none');
                    placeholder.style.display = 'none';
=======
            
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
>>>>>>> 5f41084b51ea9f60057a6b73d46e022c2cca4807
                    
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
            
<<<<<<< HEAD
            reader.onerror = function() {
                alert('Error membaca file! Silakan coba lagi.');
                input.value = ''; // Reset input
            };
            
            reader.readAsDataURL(file);
=======
            reader.onerror = function(e) {
                console.error('FileReader error', e);
                alert('Gagal membaca file. Silakan coba lagi.');
            };
            
            reader.readAsDataURL(input.files[0]);
>>>>>>> 5f41084b51ea9f60057a6b73d46e022c2cca4807
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
<<<<<<< HEAD
            const hasValidImage = !preview.classList.contains('d-none') && 
                                 preview.src && 
                                 preview.src !== '' && 
                                 preview.src !== '#' && 
                                 preview.src !== window.location.href &&
                                 !preview.src.includes('data:image/svg+xml');
            
            if (hasValidImage) {
                // Wait for image to load
                preview.onload = function() {
                    checkmark.classList.remove('d-none');
                    checkmark.classList.add('d-flex');
                    checkmark.style.display = 'flex';
                };
                
                // If image fails to load, hide checkmark
                preview.onerror = function() {
                    checkmark.classList.add('d-none');
                    checkmark.classList.remove('d-flex');
                    checkmark.style.display = 'none';
                };
=======
            const hasValidImage = preview.src && 
                                 preview.src !== '' && 
                                 preview.src !== '#' && 
                                 preview.src !== window.location.href &&
                                 preview.style.display !== 'none';
            
            if (hasValidImage) {
                checkmark.style.display = 'flex';
                console.log('Existing photo found, checkmark shown');
            } else {
                console.log('No existing photo');
>>>>>>> 5f41084b51ea9f60057a6b73d46e022c2cca4807
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
    </style>
</body>
</html>


