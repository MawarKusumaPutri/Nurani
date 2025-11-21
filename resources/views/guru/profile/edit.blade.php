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
                                                $hasPhoto = $guru->foto && Storage::disk('public')->exists($guru->foto);
                                                $photoUrl = $hasPhoto ? Storage::url($guru->foto) . '?v=' . time() : '#';
                                            @endphp
                                            <div class="position-relative d-inline-block" style="width: 150px; height: 150px;">
                                                <img id="photoPreview" src="{{ $photoUrl }}" alt="Foto Profil" class="img-thumbnail {{ !$hasPhoto ? 'd-none' : '' }}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; position: relative;">
                                                <div id="photoPlaceholder" class="bg-light d-inline-flex align-items-center justify-content-center {{ $hasPhoto ? 'd-none' : '' }}" style="width: 150px; height: 150px; border-radius: 50%; position: absolute; top: 0; left: 0;">
                                                    <i class="fas fa-user fa-3x text-muted"></i>
                                                </div>
                                                <!-- Checkmark indicator -->
                                                <div id="photoCheckmark" class="position-absolute {{ $hasPhoto ? 'd-flex' : 'd-none' }}" style="bottom: 5px; right: 5px; background: rgba(0,0,0,0.8); border-radius: 50%; width: 32px; height: 32px; align-items: center; justify-content: center; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 2px solid white;">
                                                    <i class="fas fa-check text-white" style="font-size: 18px; font-weight: bold;"></i>
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
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const checkmark = document.getElementById('photoCheckmark');
            
            reader.onload = function(e) {
                const preview = document.getElementById('photoPreview');
                const placeholder = document.getElementById('photoPlaceholder');
                
                if (preview && placeholder) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                    
                    // Show checkmark when photo is selected
                    if (checkmark) {
                        checkmark.classList.remove('d-none');
                        checkmark.classList.add('d-flex');
                        checkmark.style.display = 'flex';
                        // Add animation
                        checkmark.style.animation = 'fadeIn 0.3s ease-in';
                    }
                }
            };
            
            reader.readAsDataURL(input.files[0]);
        } else {
            // Hide checkmark if no file selected
            const checkmark = document.getElementById('photoCheckmark');
            if (checkmark) {
                checkmark.classList.add('d-none');
                checkmark.classList.remove('d-flex');
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
            if (!preview.classList.contains('d-none') && preview.src && preview.src !== '#' && preview.src !== window.location.href) {
                checkmark.classList.remove('d-none');
                checkmark.classList.add('d-flex');
                checkmark.style.display = 'flex';
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


