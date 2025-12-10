@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        body {
            overflow-x: hidden;
        }
        
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
        
        #guru-sidebar .p-4 {
            flex-shrink: 0;
        }
        
        #guru-sidebar nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 20px;
        }
        
        #guru-sidebar .p-4 {
            flex-shrink: 0;
        }
        
        #guru-sidebar nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 20px;
        }
        
        /* Ensure nav items are in single column */
        .sidebar .nav {
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            width: 100%;
        }
        
        .sidebar .nav-link,
        .sidebar .nav form {
            width: 100%;
            flex-shrink: 0;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            position: relative !important;
            display: block !important;
            touch-action: manipulation !important;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1) !important;
            transform: translateX(5px);
            pointer-events: auto !important;
        }
        .sidebar .nav-link:active {
            pointer-events: auto !important;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
        }
        .stat-card .card-body {
            padding: 2rem;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .content-card {
            background: white;
            border-left: 4px solid #2E7D32;
        }
        .card-body::-webkit-scrollbar {
            width: 8px;
        }
        .card-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .card-body::-webkit-scrollbar-thumb {
            background: #2E7D32;
            border-radius: 10px;
        }
        .card-body::-webkit-scrollbar-thumb:hover {
            background: #4CAF50;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.4);
        }
        .navbar-brand {
            font-weight: bold;
            color: #2E7D32 !important;
        }
        .materi-item {
            border-left: 3px solid #2E7D32;
            padding: 15px;
            margin-bottom: 10px;
            background: #F0F4F0;
            border-radius: 8px;
        }
        .kuis-badge {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-published {
            background: #F0F4F0;
            color: #2E7D32;
        }
        .status-draft {
            background: #F0F4F0;
            color: #4CAF50;
        }
        
        /* Responsive Styles */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1050;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
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
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block;
            }
            
            .sidebar,
            #guru-sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1050;
                transition: left 0.3s ease;
                width: 280px;
                max-width: 80%;
                height: 100vh;
                overflow-y: auto;
                overflow-x: hidden;
                -webkit-overflow-scrolling: touch;
            }
            
            .sidebar.show,
            #guru-sidebar.show {
                left: 0;
            }
            
            .col-md-9.col-lg-10 {
                margin-left: 0 !important;
            }
            
            #guru-sidebar nav {
                max-height: calc(100vh - 250px);
                overflow-y: auto;
                overflow-x: hidden;
                -webkit-overflow-scrolling: touch;
            }
            
            /* Prevent any wrapping or multi-column layout */
            .sidebar .nav {
                display: flex !important;
                flex-direction: column !important;
                flex-wrap: nowrap !important;
                width: 100% !important;
            }
            
            .sidebar .nav-link,
            .sidebar .nav form {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 auto !important;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .col-md-9.col-lg-10 {
                width: 100%;
                margin-left: 0;
                padding: 15px !important;
            }
            
            /* Tambahkan margin untuk header agar tidak tertutup hamburger menu dan simetris */
            .header-dashboard {
                margin-left: 60px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                margin-right: 15px !important;
            }
            
            .header-title-section {
                margin-left: 0 !important;
                padding-left: 0 !important;
                flex: 1;
            }
            
            /* Pastikan content area simetris */
            .col-md-9.col-lg-10 {
                padding-left: 0 !important;
                padding-right: 15px !important;
            }
            
            /* Card statistik simetris */
            .row.mb-4 {
                margin-left: 60px !important;
                margin-right: 15px !important;
                padding-left: 15px !important;
                padding-right: 0 !important;
            }
            
            /* Mata pelajaran switcher simetris */
            .mata-pelajaran-switcher {
                margin-left: 60px !important;
                margin-right: 15px !important;
            }
            
            /* Semua card simetris */
            .card.mb-4 {
                margin-left: 60px !important;
                margin-right: 15px !important;
            }
        }
        
        @media (max-width: 768px) {
            .stat-number {
                font-size: 2rem;
            }
            
            .col-md-3 {
                margin-bottom: 15px;
            }
            
            .col-md-8, .col-md-4 {
                margin-bottom: 20px;
            }
            
            .materi-item {
                padding: 12px;
            }
            
            .btn {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .stat-number {
                font-size: 1.5rem;
            }
            
            .stat-card .card-body {
                padding: 1.5rem;
            }
            
            .col-md-3 {
                width: 100%;
            }
            
            .col-md-8, .col-md-4 {
                width: 100%;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 15px;
            }
            
            .dropdown {
                width: 100%;
            }
            
            .dropdown-toggle {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 header-dashboard">
                    <div class="header-title-section">
                        <h2 class="mb-1">Selamat Datang, {{ $guru->user->name }}!</h2>
                        <p class="text-muted mb-0">Kelola materi pembelajaran dan aktivitas mengajar Anda</p>
                    </div>
                    <div class="text-end">
                        @if($mataPelajaranList->count() > 1)
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" 
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-book me-2"></i>{{ $selectedMataPelajaran ?? 'Pilih Mata Pelajaran' }}
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($mataPelajaranList as $mp)
                                        <li>
                                            <a class="dropdown-item {{ $selectedMataPelajaran == $mp->mata_pelajaran ? 'active' : '' }}" 
                                               href="{{ route('guru.dashboard', ['mata_pelajaran' => $mp->mata_pelajaran]) }}">
                                                <i class="fas fa-book me-2"></i>{{ $mp->mata_pelajaran }}
                                                @if($selectedMataPelajaran == $mp->mata_pelajaran)
                                                    <i class="fas fa-check text-success float-end"></i>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <span class="badge bg-success fs-6">{{ $selectedMataPelajaran ?? $guru->mata_pelajaran }}</span>
                        @endif
                    </div>
                </div>

                <!-- Mata Pelajaran Switcher -->
                @if($mataPelajaranList->count() > 1)
                    <div class="card mb-4 mata-pelajaran-switcher">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-exchange-alt me-2 text-primary"></i>
                                Switch Mata Pelajaran
                            </h6>
                            <div class="row">
                                @foreach($mataPelajaranList as $mp)
                                    <div class="col-md-4 col-lg-3 mb-2">
                                        <a href="{{ route('guru.dashboard', ['mata_pelajaran' => $mp->mata_pelajaran]) }}" 
                                           class="btn w-100 {{ $selectedMataPelajaran == $mp->mata_pelajaran ? 'btn-primary' : 'btn-outline-primary' }}">
                                            <i class="fas fa-book me-2"></i>{{ $mp->mata_pelajaran }}
                                            @if($selectedMataPelajaran == $mp->mata_pelajaran)
                                                <i class="fas fa-check float-end"></i>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Materi Pembelajaran -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card content-card mb-4">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-book-open me-2 text-primary"></i>
                                        Materi Pembelajaran - {{ $selectedMataPelajaran ?? 'Mata Pelajaran' }}
                                    </h5>
                                    <a href="{{ route('guru.materi-pembelajaran.edit', ['mata_pelajaran' => $selectedMataPelajaran]) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit me-2"></i>Edit Materi
                                    </a>
                                </div>
                            </div>
                            <div class="card-body" style="max-height: 800px; overflow-y: auto; padding: 20px; background-color: #ffffff !important;">
                                <!-- A. IDENTITAS SEKOLAH DAN PROGRAM -->
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-school"></i>
                                        </div>
                                        <h5 class="mb-0 text-primary">A. IDENTITAS SEKOLAH DAN PROGRAM</h5>
                                    </div>
                                    @if($materiPembelajaran && $materiPembelajaran->identitas_sekolah_program)
                                        <div class="card-text">
                                            <div style="line-height: 2;">
                                                {!! nl2br(e($materiPembelajaran->identitas_sekolah_program)) !!}
                                            </div>
                                        </div>
                                    @else
                                        <p class="card-text text-muted">Belum ada data. Silakan edit untuk menambahkan identitas sekolah dan program.</p>
                                    @endif
                                </div>

                                <!-- B. KOMPETENSI INTI DAN CAPAIAN PEMBELAJARAN -->
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-certificate"></i>
                                        </div>
                                        <h5 class="mb-0 text-success">B. KOMPETENSI INTI DAN CAPAIAN PEMBELAJARAN</h5>
                                    </div>
                                    @if($materiPembelajaran && $materiPembelajaran->kompetensi_inti_capaian)
                                        <div class="card-text">
                                            {!! nl2br(e($materiPembelajaran->kompetensi_inti_capaian)) !!}
                                        </div>
                                    @else
                                        <p class="card-text text-muted">Belum ada data. Silakan edit untuk menambahkan kompetensi inti dan capaian pembelajaran.</p>
                                    @endif
                                </div>

                                <!-- C. UNIT-UNIT PEMBELAJARAN -->
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <h5 class="mb-0 text-info">C. UNIT-UNIT PEMBELAJARAN</h5>
                                    </div>
                                    @if($materiPembelajaran && $materiPembelajaran->unit_pembelajaran)
                                        <div class="card-text">
                                            {!! nl2br(e($materiPembelajaran->unit_pembelajaran)) !!}
                                        </div>
                                    @else
                                        <p class="card-text text-muted">Belum ada data. Silakan edit untuk menambahkan unit-unit pembelajaran.</p>
                                    @endif
                                </div>

                                <!-- D. PENDEKATAN PEMBELAJARAN HUMANIS -->
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h5 class="mb-0 text-warning">D. PENDEKATAN PEMBELAJARAN HUMANIS</h5>
                                    </div>
                                    @if($materiPembelajaran && $materiPembelajaran->pendekatan_pembelajaran)
                                        <div class="card-text">
                                            {!! nl2br(e($materiPembelajaran->pendekatan_pembelajaran)) !!}
                                        </div>
                                    @else
                                        <p class="card-text text-muted">Belum ada data. Silakan edit untuk menambahkan pendekatan pembelajaran humanis.</p>
                                    @endif
                                </div>

                                <!-- E. MODEL-MODEL PEMBELAJARAN YANG DIGUNAKAN -->
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        </div>
                                        <h5 class="mb-0 text-danger">E. MODEL-MODEL PEMBELAJARAN YANG DIGUNAKAN</h5>
                                    </div>
                                    @if($materiPembelajaran && $materiPembelajaran->model_pembelajaran)
                                        <div class="card-text">
                                            {!! nl2br(e($materiPembelajaran->model_pembelajaran)) !!}
                                        </div>
                                    @else
                                        <p class="card-text text-muted">Belum ada data. Silakan edit untuk menambahkan model-model pembelajaran.</p>
                                    @endif
                                </div>

                                <!-- F. KEGIATAN PEMBELAJARAN: STRUKTUR UMUM SETIAP PERTEMUAN -->
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <h5 class="mb-0 text-secondary">F. KEGIATAN PEMBELAJARAN: STRUKTUR UMUM SETIAP PERTEMUAN</h5>
                                    </div>
                                    @if($materiPembelajaran && $materiPembelajaran->kegiatan_pembelajaran)
                                        <div class="card-text">
                                            {!! nl2br(e($materiPembelajaran->kegiatan_pembelajaran)) !!}
                                        </div>
                                    @else
                                        <p class="card-text text-muted">Belum ada data. Silakan edit untuk menambahkan kegiatan pembelajaran.</p>
                                    @endif
                                </div>

                                <!-- G. PENILAIAN (ASSESSMENT) -->
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-clipboard-check"></i>
                                        </div>
                                        <h5 class="mb-0 text-dark">G. PENILAIAN (ASSESSMENT)</h5>
                                    </div>
                                    @if($materiPembelajaran && $materiPembelajaran->penilaian)
                                        <div class="card-text">
                                            {!! nl2br(e($materiPembelajaran->penilaian)) !!}
                                        </div>
                                    @else
                                        <p class="card-text text-muted">Belum ada data. Silakan edit untuk menambahkan penilaian.</p>
                                    @endif
                                </div>

                                <!-- H. SARANA DAN PRASARANA -->
                                <div class="mb-2">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                        <h5 class="mb-0 text-primary">H. SARANA DAN PRASARANA</h5>
                                    </div>
                                    @if($materiPembelajaran && $materiPembelajaran->sarana_prasarana)
                                        <div class="card-text">
                                            {!! nl2br(e($materiPembelajaran->sarana_prasarana)) !!}
                                        </div>
                                    @else
                                        <p class="card-text text-muted">Belum ada data. Silakan edit untuk menambahkan sarana dan prasarana.</p>
                                    @endif
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
        
        // Ensure body has white background on page load - OPTIMIZED (hanya sekali)
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                document.body.style.background = '#ffffff';
                document.body.style.backgroundColor = '#ffffff';
            });
        } else {
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        }
        
        // Robust function to setup nav links - TIDAK CLONE, biarkan href normal bekerja
        function setupNavLinks() {
            const navLinks = document.querySelectorAll('.sidebar .nav-link, #guru-sidebar .nav-link');
            navLinks.forEach(function(link) {
                // Force styles dengan !important - PASTIKAN BISA DIKLIK
                link.style.setProperty('pointer-events', 'auto', 'important');
                link.style.setProperty('cursor', 'pointer', 'important');
                link.style.setProperty('z-index', '1001', 'important');
                link.style.setProperty('position', 'relative', 'important');
                link.style.setProperty('display', 'block', 'important');
                link.style.setProperty('touch-action', 'manipulation', 'important');
                link.style.setProperty('text-decoration', 'none', 'important');
                
                // Pastikan child elements tidak menghalangi
                const children = link.querySelectorAll('*');
                children.forEach(function(child) {
                    child.style.setProperty('pointer-events', 'none', 'important');
                });
                
                // JANGAN clone - biarkan href normal bekerja
                const href = link.getAttribute('href');
                if (href && href !== '#' && href !== 'javascript:void(0)') {
                    // Pastikan href tetap ada
                    if (!link.href || link.href === window.location.href) {
                        link.href = href;
                    }
                    
                    // Tambahkan click handler yang MEMASTIKAN navigasi
                    link.addEventListener('click', function(e) {
                        console.log('✓ Nav link clicked:', href);
                        // Biarkan browser navigate secara normal - JANGAN preventDefault
                        closeSidebar();
                    }, false);
                    
                    // Touch handler untuk mobile
                    link.addEventListener('touchend', function(e) {
                        console.log('✓ Nav link touched:', href);
                        closeSidebar();
                        window.location.href = href;
                        e.preventDefault();
                        return false;
                    }, false);
                }
            });
        }
        
        // Setup nav links saat DOM ready - OPTIMIZED untuk performa
        let navLinksInitialized = false;
        function initNavLinksOnce() {
            if (navLinksInitialized) return;
            navLinksInitialized = true;
            setupNavLinks();
        }
        
        // Jalankan HANYA SEKALI saat DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initNavLinksOnce);
        } else {
            initNavLinksOnce();
        }
        
        // MutationObserver DISABLED untuk meningkatkan performa
        // Jika diperlukan, bisa diaktifkan kembali dengan debounce
        /*
        const sidebar = document.getElementById('guru-sidebar');
        if (sidebar) {
            let debounceTimer;
            const observer = new MutationObserver(function(mutations) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function() {
                    setupNavLinks();
                }, 500); // Debounce 500ms
            });
            observer.observe(sidebar, {
                childList: true,
                subtree: false // Hanya observe direct children, bukan semua subtree
            });
        }
        */
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('guru-sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const overlay = document.querySelector('.sidebar-overlay');
            
            // Don't close if clicking on a nav link
            if (event.target.closest('.nav-link')) {
                return;
            }
            
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(event.target) && 
                    !toggleBtn.contains(event.target) && 
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    if (overlay) overlay.style.display = 'none';
                    // Enable body scroll when sidebar is closed
                    document.body.style.overflow = '';
                    document.body.style.position = '';
                    document.body.style.width = '';
                    document.body.style.height = '';
                    document.body.style.top = '';
                    document.body.style.background = '#ffffff';
                    document.body.style.backgroundColor = '#ffffff';
                }
            }
        });
    </script>
</body>
</html>