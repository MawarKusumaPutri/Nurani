<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi - {{ $guru->user->name }}</title>
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
        .file-upload-area {
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .file-upload-area:hover {
            background: rgba(102, 126, 234, 0.05);
        }
        .file-upload-area.dragover {
            background: rgba(102, 126, 234, 0.1);
            border-color: #667eea;
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
                        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('guru.profil') }}">
                        <i class="fas fa-user me-2"></i> Profil
                    </a>
                    <a class="nav-link active" href="{{ route('guru.materi.index') }}">
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
                        <h2 class="mb-1">Tambah Materi Baru</h2>
                        <p class="text-muted mb-0">Buat materi pembelajaran untuk siswa</p>
                    </div>
                    <a href="{{ route('guru.materi.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
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

                <!-- Form -->
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul" name="judul" 
                                               value="{{ old('judul') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                                                  required>{{ old('deskripsi') }}</textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="konten" class="form-label">Konten Materi</label>
                                        <textarea class="form-control" id="konten" name="konten" rows="6" 
                                                  placeholder="Tuliskan konten materi secara detail...">{{ old('konten') }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kelas" name="kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            <option value="1" {{ old('kelas') == '1' ? 'selected' : '' }}>Kelas 1</option>
                                            <option value="2" {{ old('kelas') == '2' ? 'selected' : '' }}>Kelas 2</option>
                                            <option value="3" {{ old('kelas') == '3' ? 'selected' : '' }}>Kelas 3</option>
                                            <option value="4" {{ old('kelas') == '4' ? 'selected' : '' }}>Kelas 4</option>
                                            <option value="5" {{ old('kelas') == '5' ? 'selected' : '' }}>Kelas 5</option>
                                            <option value="6" {{ old('kelas') == '6' ? 'selected' : '' }}>Kelas 6</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="topik" class="form-label">Topik <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="topik" name="topik" 
                                               value="{{ old('topik') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="link_video" class="form-label">Link Video</label>
                                        <input type="url" class="form-control" id="link_video" name="link_video" 
                                               value="{{ old('link_video') }}" 
                                               placeholder="https://youtube.com/watch?v=...">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                                   {{ old('is_published') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_published">
                                                Publikasikan langsung
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="mb-4">
                                <label class="form-label">File Lampiran</label>
                                <div class="file-upload-area" onclick="document.getElementById('file').click()">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Klik untuk mengunggah file</h5>
                                    <p class="text-muted mb-0">atau drag & drop file di sini</p>
                                    <small class="text-muted">Format: PDF, DOC, PPT, JPG, PNG, MP4 (Maks. 10MB)</small>
                                </div>
                                <input type="file" class="form-control d-none" id="file" name="file" 
                                       accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov">
                                
                                <div id="file-info" class="mt-3" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-file me-2"></i>
                                        <span id="file-name"></span>
                                        <span id="file-size" class="text-muted"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('guru.materi.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Materi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File upload handling
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('file-name').textContent = file.name;
                document.getElementById('file-size').textContent = '(' + formatFileSize(file.size) + ')';
                document.getElementById('file-info').style.display = 'block';
            }
        });

        // Drag and drop handling
        const uploadArea = document.querySelector('.file-upload-area');
        
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('file').files = files;
                const file = files[0];
                document.getElementById('file-name').textContent = file.name;
                document.getElementById('file-size').textContent = '(' + formatFileSize(file.size) + ')';
                document.getElementById('file-info').style.display = 'block';
            }
        });

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
</body>
</html>
