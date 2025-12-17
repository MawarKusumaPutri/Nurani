@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lembar Penilaian - {{ $guru->user->name }}</title>
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
        
        dt {
            font-weight: 600;
            color: #495057;
        }
        
        dd {
            margin-bottom: 0.5rem;
        }
        
        /* CSS khusus untuk layout horizontal detail lembar penilaian - PASTIKAN BERSEBELAHAN */
        .detail-lembar-container {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 2rem !important;
            align-items: start !important;
        }
        
        /* Pastikan kolom tampil bersebelahan di layar >= 768px - TIDAK BOLEH VERTIKAL */
        @media (min-width: 768px) {
            .detail-lembar-container {
                grid-template-columns: 1fr 1fr !important;
                display: grid !important;
            }
        }
        
        /* Di layar kecil, kolom jadi vertikal */
        @media (max-width: 767px) {
            .detail-lembar-container {
                grid-template-columns: 1fr !important;
                display: block !important;
            }
            
            .detail-lembar-container > div {
                margin-bottom: 1.5rem;
            }
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
                        <h2 class="mb-1">Detail Lembar Penilaian</h2>
                        <p class="text-muted mb-0">Informasi lengkap lembar penilaian</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('guru.evaluasi.lembar.edit', $lembar->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('guru.evaluasi.lembar.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body detail-lembar-container">
                                <!-- Kolom Kiri -->
                                <div>
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Siswa</strong></div>
                                            <div class="col-7">{{ $lembar->siswa->nama ?? 'N/A' }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Mata Pelajaran</strong></div>
                                            <div class="col-7">{{ $lembar->mata_pelajaran }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Kelas</strong></div>
                                            <div class="col-7">Kelas {{ $lembar->kelas }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Semester</strong></div>
                                            <div class="col-7">{{ $lembar->semester }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Tanggal Penilaian</strong></div>
                                            <div class="col-7">{{ \Carbon\Carbon::parse($lembar->tanggal_penilaian)->format('d/m/Y') }}</div>
                                        </div>
                                        @if($lembar->rubrikPenilaian)
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Rubrik Penilaian</strong></div>
                                            <div class="col-7">{{ $lembar->rubrikPenilaian->judul }}</div>
                                        </div>
                                        @endif
                                    </div>

                                <!-- Kolom Kanan -->
                                <div>
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Nilai</strong></div>
                                            <div class="col-7">
                                                @if($lembar->nilai)
                                                    <span class="badge bg-primary fs-6">{{ number_format($lembar->nilai, 2) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($lembar->aspek_penilaian)
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Aspek Penilaian</strong></div>
                                            <div class="col-7">{{ $lembar->aspek_penilaian }}</div>
                                        </div>
                                        @endif
                                        @if($lembar->catatan)
                                        <div class="row mb-2">
                                            <div class="col-5"><strong>Catatan</strong></div>
                                            <div class="col-7">{{ $lembar->catatan }}</div>
                                        </div>
                                        @endif
                                    </div>
                            </div>

                            <!-- Field yang membutuhkan full width -->
                                @if($lembar->detail_nilai)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="row mb-2">
                                            <div class="col-12"><strong>Detail Nilai</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <pre class="bg-light p-3 rounded mb-0">{{ $lembar->detail_nilai }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
            const selectors = ['html', 'body', '.container-fluid', '.row', '.col-md-9', '.col-lg-10', '.p-4'];
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
    </script>
</body>
</html>
