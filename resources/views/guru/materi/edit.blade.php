@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi - {{ $materi->judul }}</title>
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
        .existing-file {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
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

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Edit Materi</h2>
                        <p class="text-muted mb-0">Perbarui informasi materi pembelajaran</p>
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
                        <form id="editMateriForm" action="{{ route('guru.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul" name="judul" 
                                               value="{{ old('judul', $materi->judul) }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                                                  required>{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="konten" class="form-label">Konten Materi</label>
                                        <textarea class="form-control" id="konten" name="konten" rows="6" 
                                                  placeholder="Tuliskan konten materi secara detail...">{{ old('konten', $materi->konten) }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kelas" name="kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            <option value="7" {{ old('kelas', $materi->kelas) == '7' ? 'selected' : '' }}>Kelas 7</option>
                                            <option value="8" {{ old('kelas', $materi->kelas) == '8' ? 'selected' : '' }}>Kelas 8</option>
                                            <option value="9" {{ old('kelas', $materi->kelas) == '9' ? 'selected' : '' }}>Kelas 9</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="topik" class="form-label">Topik <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="topik" name="topik" 
                                               value="{{ old('topik', $materi->topik) }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                                   {{ old('is_published', $materi->is_published) ? 'checked' : '' }}>
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
                                
                                @if($materi->file_path)
                                    <div class="existing-file" id="existingFileContainer">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file fa-2x text-primary me-3"></i>
                                                <div>
                                                    <strong>File saat ini:</strong>
                                                    <p class="mb-0 text-muted small">{{ basename($materi->file_path) }}</p>
                                                    @if($materi->file_size_formatted)
                                                        <p class="mb-0 text-muted small">{{ $materi->file_size_formatted }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ Storage::url($materi->file_path) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   target="_blank">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteExistingFile()">
                                                    <i class="fas fa-trash me-1"></i>Hapus File
                                                </button>
                                            </div>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Upload file baru untuk mengganti, atau klik "Hapus File" untuk menghapus file ini
                                        </p>
                                    </div>
                                    
                                    <!-- Hidden input to mark file for deletion -->
                                    <input type="hidden" name="delete_file" id="deleteFileInput" value="0">
                                @endif
                                
                                <div class="file-upload-area" onclick="document.getElementById('file').click()" style="cursor: pointer; position: relative; z-index: 1;">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3" style="pointer-events: none;"></i>
                                    <h5 class="text-muted" style="pointer-events: none;">{{ $materi->file_path ? 'Klik untuk mengganti file' : 'Klik untuk mengunggah file' }}</h5>
                                    <p class="text-muted mb-0" style="pointer-events: none;">atau drag & drop file di sini</p>
                                    <small class="text-muted" style="pointer-events: none;">Format: PDF, DOC, PPT, JPG, PNG, MP4 (Maks. 10MB)</small>
                                </div>
                                <input type="file" class="form-control d-none" id="file" name="file" 
                                       accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov">
                                
                                <!-- Tombol alternatif untuk upload -->
                                <div class="text-center mt-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('file').click()">
                                        <i class="fas fa-folder-open me-2"></i>Pilih File
                                    </button>
                                </div>
                                
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
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
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
            console.log('File selected:', file);
            if (file) {
                console.log('File name:', file.name);
                console.log('File size:', file.size);
                console.log('File type:', file.type);
                
                document.getElementById('file-name').textContent = file.name;
                document.getElementById('file-size').textContent = '(' + formatFileSize(file.size) + ')';
                document.getElementById('file-info').style.display = 'block';
                
                // Show success toast
                alert('File "' + file.name + '" berhasil dipilih! Klik "Simpan Perubahan" untuk mengupload.');
            } else {
                console.log('No file selected');
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


        function validateForm() {
            const fileInput = document.getElementById('file');
            const file = fileInput.files[0];
            
            console.log('=== FORM SUBMIT ===');
            console.log('File input element:', fileInput);
            console.log('File selected:', file);
            
            if (file) {
                console.log('✓ File akan diupload:');
                console.log('  - Name:', file.name);
                console.log('  - Size:', file.size, 'bytes');
                console.log('  - Type:', file.type);
            } else {
                console.log('✗ Tidak ada file baru yang dipilih');
            }
            
            // Always return true to allow form submission
            return true;
        }

        function deleteExistingFile() {
            if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
                // Mark file for deletion
                document.getElementById('deleteFileInput').value = '1';
                
                // Completely hide the existing file container
                const container = document.getElementById('existingFileContainer');
                container.style.display = 'none';
                
                alert('File akan dihapus. Klik "Simpan Perubahan" untuk menyimpan.');
            }
        }

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

