@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rekap Hasil Belajar - {{ $guru->user->name }}</title>
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
                        <h2 class="mb-1">Detail Rekap Hasil Belajar</h2>
                        <p class="text-muted mb-0">Informasi lengkap rekap hasil belajar siswa</p>
                    </div>
                    <a href="{{ route('guru.evaluasi.rekap.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Siswa</dt>
                                    <dd class="col-sm-8">{{ $rekap->siswa->nama ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Kelas</dt>
                                    <dd class="col-sm-8">Kelas {{ $rekap->kelas }}</dd>

                                    <dt class="col-sm-4">Semester</dt>
                                    <dd class="col-sm-8">{{ $rekap->semester }}</dd>

                                    <dt class="col-sm-4">Mata Pelajaran</dt>
                                    <dd class="col-sm-8">{{ $rekap->mata_pelajaran }}</dd>

                                    <dt class="col-sm-4">Nilai Formatif</dt>
                                    <dd class="col-sm-8">
                                        @if($rekap->nilai_formatif)
                                            <span class="badge bg-info fs-6">{{ number_format($rekap->nilai_formatif, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Nilai Sumatif</dt>
                                    <dd class="col-sm-8">
                                        @if($rekap->nilai_sumatif)
                                            <span class="badge bg-warning fs-6">{{ number_format($rekap->nilai_sumatif, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Nilai Akhir</dt>
                                    <dd class="col-sm-8">
                                        @if($rekap->nilai_akhir)
                                            <span class="badge bg-primary fs-6">{{ number_format($rekap->nilai_akhir, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Predikat</dt>
                                    <dd class="col-sm-8">
                                        @if($rekap->predikat)
                                            <span class="badge bg-success fs-6">{{ $rekap->predikat }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Total Mata Pelajaran</dt>
                                    <dd class="col-sm-8">{{ $rekap->total_mata_pelajaran ?? 0 }}</dd>

                                    <dt class="col-sm-4">Rata-rata Semua Mapel</dt>
                                    <dd class="col-sm-8">
                                        @if($rekap->rata_rata_semua_mapel)
                                            <span class="badge bg-secondary fs-6">{{ number_format($rekap->rata_rata_semua_mapel, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Jumlah Mapel Tuntas</dt>
                                    <dd class="col-sm-8">{{ $rekap->jumlah_mapel_tuntas ?? 0 }}</dd>

                                    <dt class="col-sm-4">Jumlah Mapel Tidak Tuntas</dt>
                                    <dd class="col-sm-8">{{ $rekap->jumlah_mapel_tidak_tuntas ?? 0 }}</dd>

                                    @if($rekap->catatan)
                                    <dt class="col-sm-4">Catatan</dt>
                                    <dd class="col-sm-8">{{ $rekap->catatan }}</dd>
                                    @endif
                                </dl>
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
