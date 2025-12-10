@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rubrik Penilaian - {{ $guru->user->name }}</title>
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
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            background-color: #ffffff !important;
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
                            <i class="fas fa-list-check me-2 text-primary"></i>
                            Detail Rubrik Penilaian
                        </h2>
                        <p class="text-muted mb-0">Lihat detail rubrik penilaian</p>
                    </div>
                    <a href="{{ route('guru.evaluasi.rubrik.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-header bg-white border-bottom">
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-file-alt me-2 text-primary"></i>
                                    {{ $rubrik->judul }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Informasi Umum</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <strong><i class="fas fa-book me-2 text-primary"></i>Mata Pelajaran:</strong><br>
                                            <span class="ms-4">{{ $rubrik->mata_pelajaran }}</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <strong><i class="fas fa-users me-2 text-primary"></i>Kelas:</strong><br>
                                            <span class="ms-4">{{ $rubrik->kelas }}</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <strong><i class="fas fa-calendar-alt me-2 text-primary"></i>Semester:</strong><br>
                                            <span class="ms-4">{{ $rubrik->semester }}</span>
                                        </div>
                                        @if($rubrik->tahun_pelajaran)
                                        <div class="col-md-6 mb-3">
                                            <strong><i class="fas fa-calendar me-2 text-primary"></i>Tahun Pelajaran:</strong><br>
                                            <span class="ms-4">{{ $rubrik->tahun_pelajaran }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if($rubrik->deskripsi)
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Deskripsi</h6>
                                    <div class="border-start border-primary border-3 ps-3">
                                        <p class="mb-0">{{ $rubrik->deskripsi }}</p>
                                    </div>
                                </div>
                                @endif

                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Kriteria Penilaian</h6>
                                    <div class="border p-3 rounded bg-light">
                                        <pre style="white-space: pre-wrap; font-family: inherit; margin: 0;">{{ $rubrik->kriteria_penilaian }}</pre>
                                    </div>
                                </div>

                                @if($rubrik->skala_nilai)
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Skala Nilai</h6>
                                    <div class="border-start border-success border-3 ps-3">
                                        <p class="mb-0">{{ $rubrik->skala_nilai }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($rubrik->indikator)
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Indikator</h6>
                                    <div class="border-start border-info border-3 ps-3">
                                        <p class="mb-0">{{ $rubrik->indikator }}</p>
                                    </div>
                                </div>
                                @endif

                                <div class="d-flex gap-2 mt-4">
                                    <a href="{{ route('guru.evaluasi.rubrik.edit', $rubrik->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                    <a href="{{ route('guru.evaluasi.rubrik.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                                    </a>
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
        
        function forceWhiteBackground() {
            const selectors = ['html', 'body', '.container-fluid', '.row', '.col-md-9', '.col-lg-10', '.p-4', '.col-md-10', '.col-lg-8'];
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
