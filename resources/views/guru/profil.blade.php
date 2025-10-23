@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Guru - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white;">
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link active" href="{{ route('guru.profil') }}">
                        <i class="fas fa-user me-2"></i> Profil
                    </a>
                    <a class="nav-link" href="{{ route('guru.materi.index') }}">
                        <i class="fas fa-book me-2"></i> Materi
                    </a>
                    <a class="nav-link" href="{{ route('guru.kuis.index') }}">
                        <i class="fas fa-question-circle me-2"></i> Kuis
                    </a>
                    <a class="nav-link" href="{{ route('guru.rangkuman.index') }}">
                        <i class="fas fa-clipboard-list me-2"></i> Rangkuman
                    </a>
                    <hr class="text-white-50">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Profil Guru</h2>
                        <p class="text-muted mb-0">Kelola informasi profil dan mata pelajaran Anda</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            @if($guru->foto)
                                <img src="{{ Storage::url($guru->foto) }}" alt="Foto Profil" class="profile-avatar">
                            @else
                                <div class="profile-avatar bg-white d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user fa-3x text-primary"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h3 class="mb-2">{{ $guru->user->name }}</h3>
                            <p class="mb-1"><i class="fas fa-id-card me-2"></i>NIP: {{ $guru->nip }}</p>
                            <p class="mb-1"><i class="fas fa-book me-2"></i>Mata Pelajaran: {{ $guru->mata_pelajaran }}</p>
                            <p class="mb-0"><i class="fas fa-envelope me-2"></i>Email: {{ $guru->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Edit Profile Form -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2 text-primary"></i>
                            Edit Profil
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('guru.profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                           value="{{ old('nama', $guru->user->name) }}" required>
                                    @error('nama')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" 
                                           value="{{ old('nip', $guru->nip) }}" required>
                                    @error('nip')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
                                    <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran" 
                                           value="{{ old('mata_pelajaran', $guru->mata_pelajaran) }}" required>
                                    @error('mata_pelajaran')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="kontak" class="form-label">Kontak</label>
                                    <input type="text" class="form-control" id="kontak" name="kontak" 
                                           value="{{ old('kontak', $guru->kontak ?? '') }}" 
                                           placeholder="Nomor telepon atau WhatsApp">
                                    @error('kontak')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto Profil</label>
                                <input type="file" class="form-control" id="foto" name="foto" 
                                       accept="image/*" onchange="previewImage(this)">
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                
                                <!-- Preview Container -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                                
                                @error('foto')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="biodata" class="form-label">Biodata</label>
                                <textarea class="form-control" id="biodata" name="biodata" rows="4" 
                                          placeholder="Ceritakan tentang diri Anda, latar belakang pendidikan, dan pengalaman mengajar...">{{ old('biodata', $guru->biodata ?? '') }}</textarea>
                                @error('biodata')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keahlian" class="form-label">Keahlian</label>
                                <textarea class="form-control" id="keahlian" name="keahlian" rows="3" 
                                          placeholder="Tuliskan keahlian atau kompetensi khusus yang Anda miliki...">{{ old('keahlian', $guru->keahlian ?? '') }}</textarea>
                                @error('keahlian')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="card mt-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Informasi Profil
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <p class="mb-0">{{ $guru->user->email }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <span class="badge bg-success">{{ ucfirst($guru->status) }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Bergabung Sejak</label>
                                    <p class="mb-0">{{ $guru->created_at->format('d F Y') }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Terakhir Diupdate</label>
                                    <p class="mb-0">{{ $guru->updated_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
        
        // Debug function to check foto path
        function debugFoto() {
            @if($guru->foto)
                console.log('Foto path:', '{{ $guru->foto }}');
                console.log('Storage URL:', '{{ Storage::url($guru->foto) }}');
            @endif
        }
        
        // Call debug function on page load
        document.addEventListener('DOMContentLoaded', function() {
            debugFoto();
        });
    </script>
</body>
</html>
