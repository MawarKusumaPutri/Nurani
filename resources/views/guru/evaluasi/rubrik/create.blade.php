@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rubrik Penilaian - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        body {
            overflow-x: hidden;
        }
        
        .container-fluid {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        .row {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        .col-md-9, .col-lg-10 {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
            background-color: #ffffff !important;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .p-4 {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1050;
                transition: left 0.3s ease;
                width: 280px;
                max-width: 80%;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid" style="background-color: #ffffff !important; background: #ffffff !important;">
        <div class="row" style="background-color: #ffffff !important; background: #ffffff !important;">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4" style="background-color: #ffffff !important; background: #ffffff !important;">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-plus me-2 text-primary"></i>
                            Tambah Rubrik Penilaian
                        </h2>
                        <p class="text-muted mb-0">Buat rubrik penilaian baru untuk berbagai aspek pembelajaran</p>
                    </div>
                    <a href="{{ route('guru.evaluasi.rubrik.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('guru.evaluasi.rubrik.store') }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Rubrik <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul" name="judul" required placeholder="Contoh: Rubrik Penilaian Presentasi">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                            <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                                <option value="">Pilih Mata Pelajaran</option>
                                                @foreach($mataPelajaranList as $mapel)
                                                    <option value="{{ $mapel->mata_pelajaran }}">{{ $mapel->mata_pelajaran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kelas" name="kelas" required>
                                                <option value="">Pilih Kelas</option>
                                                <option value="7">Kelas 7</option>
                                                <option value="8">Kelas 8</option>
                                                <option value="9">Kelas 9</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                            <select class="form-select" id="semester" name="semester" required>
                                                <option value="">Pilih Semester</option>
                                                <option value="Ganjil">Ganjil</option>
                                                <option value="Genap">Genap</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                                            <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" placeholder="2024/2025">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi rubrik penilaian"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kriteria_penilaian" class="form-label">Kriteria Penilaian <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="kriteria_penilaian" name="kriteria_penilaian" rows="5" required placeholder="Masukkan kriteria penilaian (dapat berupa JSON atau teks)"></textarea>
                                        <small class="text-muted">Contoh: {"Aspek 1": "Deskripsi", "Aspek 2": "Deskripsi"}</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="skala_nilai" class="form-label">Skala Nilai</label>
                                        <input type="text" class="form-control" id="skala_nilai" name="skala_nilai" placeholder="Contoh: 1-4, 1-5, 0-100">
                                    </div>

                                    <div class="mb-3">
                                        <label for="indikator" class="form-label">Indikator</label>
                                        <textarea class="form-control" id="indikator" name="indikator" rows="3" placeholder="Masukkan indikator penilaian"></textarea>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan
                                        </button>
                                        <a href="{{ route('guru.evaluasi.rubrik.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('guru-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
            if (overlay) {
                overlay.classList.toggle('show');
            }
        }
        
        // Force white background
        function forceWhiteBackground() {
            const selectors = [
                'html', 'body', '.container-fluid', '.row', 
                '.col-md-9', '.col-lg-10', '.p-4', '.content',
                '.col-md-10', '.col-lg-8'
            ];
            
            selectors.forEach(function(selector) {
                const elements = document.querySelectorAll(selector);
                elements.forEach(function(el) {
                    if (el && !el.classList.contains('sidebar')) {
                        el.style.setProperty('background-color', '#ffffff', 'important');
                        el.style.setProperty('background', '#ffffff', 'important');
                    }
                });
            });
        }
        
        forceWhiteBackground();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', forceWhiteBackground);
        }
        window.addEventListener('load', forceWhiteBackground);
        setInterval(forceWhiteBackground, 100);
    </script>
</body>
</html>
