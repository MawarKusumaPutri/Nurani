@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi Guru - {{ $guru->user->name }}</title>
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
            <div class="col-md-9 col-lg-10 p-4" style="background-color: #ffffff !important; background: #ffffff !important; min-height: 100vh;">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Evaluasi Guru</h2>
                        <p class="text-muted mb-0">Kelola rubrik penilaian, lembar penilaian, nilai formatif & sumatif, dan rekap hasil belajar</p>
                    </div>
                </div>

                <!-- Menu Cards -->
                <div class="row g-4">
                    <!-- Rubrik Penilaian -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="fas fa-list-check fa-3x text-primary"></i>
                                </div>
                                <h5 class="card-title">Rubrik Penilaian</h5>
                                <p class="card-text text-muted small">Buat dan kelola rubrik penilaian untuk berbagai aspek pembelajaran</p>
                                <a href="{{ route('guru.evaluasi.rubrik.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i> Buka
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Lembar Penilaian (LP) -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="fas fa-file-alt fa-3x text-success"></i>
                                </div>
                                <h5 class="card-title">Lembar Penilaian (LP)</h5>
                                <p class="card-text text-muted small">Isi dan kelola lembar penilaian untuk setiap siswa</p>
                                <a href="{{ route('guru.evaluasi.lembar.index') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i> Buka
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Nilai Formatif & Sumatif -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="fas fa-chart-line fa-3x text-warning"></i>
                                </div>
                                <h5 class="card-title">Nilai Formatif & Sumatif</h5>
                                <p class="card-text text-muted small">Input dan kelola nilai formatif dan sumatif siswa</p>
                                <a href="{{ route('guru.evaluasi.nilai.index') }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i> Buka
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Rekap Hasil Belajar -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="mb-3">
                                    <i class="fas fa-chart-bar fa-3x text-info"></i>
                                </div>
                                <h5 class="card-title">Rekap Hasil Belajar</h5>
                                <p class="card-text text-muted small">Lihat rekap hasil belajar siswa secara keseluruhan</p>
                                <a href="{{ route('guru.evaluasi.rekap.index') }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i> Buka
                                </a>
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
        
        // Force white background - AGGRESSIVE
        function forceWhiteBackground() {
            // Force on all possible elements
            const selectors = [
                'html', 'body', '.container-fluid', '.row', 
                '.col-md-9', '.col-lg-10', '.p-4', 
                '[class*="col-"]', 'main', '#main', '.content', '.main-content'
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
            
            // Also force on body and html directly
            if (document.body) {
                document.body.style.setProperty('background-color', '#ffffff', 'important');
                document.body.style.setProperty('background', '#ffffff', 'important');
            }
            if (document.documentElement) {
                document.documentElement.style.setProperty('background-color', '#ffffff', 'important');
                document.documentElement.style.setProperty('background', '#ffffff', 'important');
            }
        }
        
        // Run immediately
        forceWhiteBackground();
        
        // Run on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                forceWhiteBackground();
                setTimeout(forceWhiteBackground, 50);
                setTimeout(forceWhiteBackground, 200);
            });
        } else {
            forceWhiteBackground();
            setTimeout(forceWhiteBackground, 50);
            setTimeout(forceWhiteBackground, 200);
        }
        
        // Run on window load
        window.addEventListener('load', function() {
            forceWhiteBackground();
            setTimeout(forceWhiteBackground, 100);
            setTimeout(forceWhiteBackground, 500);
        });
        
        // Run multiple times to ensure it sticks
        let runCount = 0;
        const interval = setInterval(function() {
            forceWhiteBackground();
            runCount++;
            if (runCount >= 5) {
                clearInterval(interval);
            }
        }, 200);
    </script>
</body>
</html>
