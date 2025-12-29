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
        
        /* Layout CSS - DISABLED - Menggunakan CSS Global dari guru-fixed-layout.blade.php */
        /*
        /* Layout - sama seperti presensi (biarkan Bootstrap yang mengatur) */
        /* Pastikan di desktop, konten di samping sidebar - ULTRA VISIBLE */
        @media (min-width: 768px) {
            .container-fluid > .row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }
            
            /* Pastikan sidebar menggunakan ukuran Bootstrap default - Medium screen - ULTRA VISIBLE */
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 25% !important;
                width: 25% !important; /* col-md-3 = 25% */
                max-width: 25% !important;
                min-width: 250px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 75% !important;
                width: 75% !important; /* col-md-9 = 75% */
            }
        }
        
        /* Large screen - sidebar lebih kecil - ULTRA VISIBLE */
        @media (min-width: 992px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 16.66666667% !important;
                width: 16.66666667% !important; /* col-lg-2 = 16.67% */
                max-width: 16.66666667% !important;
                min-width: 200px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 83.33333333% !important;
                width: 83.33333333% !important; /* col-lg-10 = 83.33% */
            }
        }
        
        /* Main content - di samping sidebar (kanan) */
        .col-md-9.col-lg-10 {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1 !important;
            min-height: 100vh !important;
            padding: 1rem 1.5rem !important;
            background-color: #ffffff !important;
            box-sizing: border-box !important;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            width: auto !important;
            left: 0 !important;
            transform: translateX(0) !important;
        }
        
        /* Pastikan sidebar tidak memaksa konten ke bawah di desktop */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar {
                position: relative !important;
                float: none !important;
            }
        }
        
        /* Ensure sidebar content is scrollable - ULTRA VISIBLE */
        #guru-sidebar {
            display: flex !important;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            left: 0 !important;
            transform: translateX(0) !important;
            z-index: 1000 !important;
            width: 100% !important;
        }
        
        /* PASTIKAN SIDEBAR TIDAK TERSEMBUNYI - ULTRA AGGRESSIVE */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
        
        /* Pastikan konten tidak tersembunyi */
        .col-md-9.col-lg-10 > * {
            display: block !important;
            visibility: visible !important;
        }
        
        .col-md-9.col-lg-10 h2,
        .col-md-9.col-lg-10 .row,
        .col-md-9.col-lg-10 .card,
        .col-md-9.col-lg-10 .alert {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
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
            height: 100%;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .card.h-100 {
            display: flex;
            flex-direction: column;
        }
        
        .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .card-body .btn {
            margin-top: auto;
        }
        
        /* Pastikan card tampil horizontal dalam 1 baris di desktop - ULTRA AGGRESSIVE */
        .row.g-4 {
            display: flex !important;
            flex-wrap: wrap !important;
            margin-left: -0.75rem !important;
            margin-right: -0.75rem !important;
        }
        
        .row.g-4 > [class*="col-"] {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
            display: flex !important;
            flex-direction: column !important;
        }
        
        @media (min-width: 992px) {
            .row.g-4 {
                display: flex !important;
                flex-wrap: nowrap !important;
                flex-direction: row !important;
                margin-left: -0.75rem !important;
                margin-right: -0.75rem !important;
                width: 100% !important;
            }
            
            .row.g-4 > .col-lg-3,
            .row.g-4 > .col-md-6.col-lg-3 {
                flex: 0 0 25% !important;
                max-width: 25% !important;
                width: 25% !important;
                min-width: 0 !important;
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                display: flex !important;
                flex-direction: column !important;
            }
            
            /* Pastikan card tidak wrap dan mengisi penuh */
            .row.g-4 > .col-lg-3 .card,
            .row.g-4 > .col-md-6.col-lg-3 .card {
                width: 100% !important;
                max-width: 100% !important;
                flex: 1 1 auto !important;
            }
        }
        
        /* Di tablet, 2 kolom */
        @media (min-width: 768px) and (max-width: 991px) {
            .row.g-4 {
                display: flex !important;
                flex-wrap: wrap !important;
            }
            
            .row.g-4 > .col-md-6 {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                width: 50% !important;
            }
        }
        
        @media (max-width: 767px) {
            .row.g-4 > [class*="col-"] {
                flex: 0 0 100% !important;
                max-width: 100% !important;
                width: 100% !important;
            }
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
            
            .col-md-9.col-lg-10 {
                width: 100% !important;
                margin-left: 0 !important;
            }
            
            .col-md-3.col-lg-2.sidebar {
                width: 100% !important;
            }
        }
        
        */
        
        /* OVERRIDE MOBILE CSS UNTUK DESKTOP - DISABLED */
        /*
        /* OVERRIDE MOBILE CSS UNTUK DESKTOP - ULTRA AGGRESSIVE */
        @media (min-width: 768px) {
            .sidebar.col-md-3.col-lg-2,
            #guru-sidebar.col-md-3.col-lg-2,
            .col-md-3.col-lg-2#guru-sidebar,
            .col-md-3.col-lg-2.sidebar#guru-sidebar {
                position: relative !important;
                left: 0 !important;
                top: auto !important;
                transform: translateX(0) !important;
                transition: none !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                    }
        }
        */
    </style>
    @include('partials.guru-fixed-layout')
    @include('partials.guru-dynamic-ui')
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
                <div class="row g-4" style="display: flex !important; flex-wrap: nowrap !important; flex-direction: row !important;">
                    <!-- Rubrik Penilaian -->
                    <div class="col-md-6 col-lg-3 d-flex">
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
                    <div class="col-md-6 col-lg-3 d-flex">
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
                    <div class="col-md-6 col-lg-3 d-flex">
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
                    <div class="col-md-6 col-lg-3 d-flex">
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
