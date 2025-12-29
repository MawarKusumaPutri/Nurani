<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
        }
        
        body {
            position: relative;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        #sidebar {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        .sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            z-index: 1061 !important;
        }
        
        .sidebar * {
            background-color: transparent !important;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
            background-color: transparent !important;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1) !important;
            transform: translateX(5px);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        }
        
        .file-upload-area {
            border: 2px dashed #2E7D32;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .file-upload-area:hover {
            background: rgba(46, 125, 50, 0.05);
        }
        
        .file-upload-area.dragover {
            background: rgba(46, 125, 50, 0.1);
            border-color: #2E7D32;
        }
        
        /* Responsive Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 99999;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            cursor: pointer;
            pointer-events: auto;
            touch-action: manipulation;
            min-width: 48px;
            min-height: 48px;
            font-size: 18px;
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.05) !important;
            z-index: 1040;
            pointer-events: auto;
            transition: background 0.3s ease, opacity 0.3s ease;
            opacity: 0;
        }
        
        .sidebar-overlay.show {
            pointer-events: auto;
            display: block;
            opacity: 1;
            background: rgba(0,0,0,0.05) !important;
            z-index: 1040 !important;
        }
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
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
                overflow-x: hidden !important;
                -webkit-overflow-scrolling: touch !important;
                pointer-events: auto !important;
            }
            
            .sidebar.show {
                left: 0 !important;
                transform: translateX(0) !important;
                pointer-events: auto !important;
                z-index: 1061 !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            #sidebar.show {
                left: 0 !important;
                transform: translateX(0) !important;
                pointer-events: auto !important;
                z-index: 1061 !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            .col-md-9.col-lg-10 {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
    @include('partials.guru-dynamic-ui')
</head>
<body style="margin: 0; padding: 0; position: relative;">
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid" style="position: relative; z-index: 1;">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0" id="sidebar" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important; background-color: #2E7D32 !important;">
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
                    <a class="nav-link active" href="{{ route('guru.materi.index') }}" onclick="closeSidebar(); return true;">
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
                                            <option value="7" {{ old('kelas') == '7' ? 'selected' : '' }}>Kelas 7</option>
                                            <option value="8" {{ old('kelas') == '8' ? 'selected' : '' }}>Kelas 8</option>
                                            <option value="9" {{ old('kelas') == '9' ? 'selected' : '' }}>Kelas 9</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                        <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                            <option value="">Pilih Mata Pelajaran</option>
                                            @foreach($mataPelajaranList as $mp)
                                                <option value="{{ $mp->mata_pelajaran }}" {{ old('mata_pelajaran') == $mp->mata_pelajaran ? 'selected' : '' }}>
                                                    {{ $mp->mata_pelajaran }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="topik" class="form-label">Topik <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="topik" name="topik" 
                                               value="{{ old('topik') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="jumlah_pertemuan" class="form-label">
                                            Jumlah Pertemuan 
                                            <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" 
                                               title="Jumlah pertemuan untuk materi ini (dari RPP)"></i>
                                        </label>
                                        <input type="number" class="form-control" id="jumlah_pertemuan" name="jumlah_pertemuan" 
                                               value="{{ old('jumlah_pertemuan', 1) }}" min="1" max="50" required>
                                        <small class="text-muted">Anda bisa melacak progress pertemuan yang sudah diajarkan</small>
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
                                <div class="file-upload-area" id="fileUploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Klik untuk mengunggah file</h5>
                                    <p class="text-muted mb-0">atau drag & drop file di sini</p>
                                    <small class="text-muted">Format: PDF, DOC, PPT, JPG, PNG, MP4 (Maks. 10MB)</small>
                                </div>
                                <input type="file" class="form-control d-none" id="file" name="file" 
                                       accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov">
                                
                                <div id="file-info" class="mt-3" style="display: none;">
                                    <div class="alert alert-success d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-file me-2"></i>
                                            <span id="file-name"></span>
                                            <span id="file-size" class="text-muted ms-2"></span>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile()">
                                            <i class="fas fa-times"></i> Hapus
                                        </button>
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
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const isOpen = sidebar.classList.contains('show');
            
            if (isOpen) {
                // Close sidebar
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (overlay) overlay.style.display = 'none';
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
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
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
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        }
        
        // Single DOMContentLoaded event for all initialization
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - Initializing file upload...');
            
            // File upload handling
            const fileInput = document.getElementById('file');
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInfo = document.getElementById('file-info');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            
            // Check if elements exist
            if (!fileInput) {
                console.error('File input not found');
            }
            if (!fileUploadArea) {
                console.error('File upload area not found');
            }
            if (!fileInfo) {
                console.error('File info not found');
            }
            
            if (!fileInput || !fileUploadArea || !fileInfo || !fileName || !fileSize) {
                console.error('File upload elements not found - upload will not work');
                return;
            }
            
            console.log('All file upload elements found successfully');
            
            // Click handler for upload area
            fileUploadArea.addEventListener('click', function() {
                console.log('Upload area clicked');
                fileInput.click();
            });
            
            // File input change handler
            fileInput.addEventListener('change', function(e) {
                console.log('File input changed');
                const file = e.target.files[0];
                if (file) {
                    console.log('File selected:', file.name, file.size);
                    displayFileInfo(file);
                }
            });

            // Drag and drop handling
            fileUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileUploadArea.classList.add('dragover');
                console.log('Drag over');
            });
            
            fileUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileUploadArea.classList.remove('dragover');
                console.log('Drag leave');
            });
            
            fileUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileUploadArea.classList.remove('dragover');
                console.log('File dropped');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    console.log('Dropped file:', files[0].name, files[0].size);
                    // Create a new FileList and assign to input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0]);
                    fileInput.files = dataTransfer.files;
                    displayFileInfo(files[0]);
                }
            });
            
            function displayFileInfo(file) {
                console.log('Displaying file info:', file.name);
                fileName.textContent = file.name;
                fileSize.textContent = '(' + formatFileSize(file.size) + ')';
                fileInfo.style.display = 'block';
                
                // Update upload area to show file is selected
                fileUploadArea.style.borderColor = '#28a745';
                fileUploadArea.style.backgroundColor = 'rgba(40, 167, 69, 0.05)';
                console.log('File info displayed successfully');
            }
            
            window.removeFile = function() {
                console.log('Removing file');
                fileInput.value = '';
                fileInfo.style.display = 'none';
                fileName.textContent = '';
                fileSize.textContent = '';
                
                // Reset upload area style
                fileUploadArea.style.borderColor = '#2E7D32';
                fileUploadArea.style.backgroundColor = '';
            };

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            // Reset body styles
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
            
            console.log('File upload initialization complete');
        });
    </script>
</body>
</html>
