@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa - {{ $guru->user->name }}</title>
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
        
        .sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        #sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        .sidebar .nav-link,
        #guru-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 10 !important;
            position: relative !important;
            display: block !important;
            text-decoration: none !important;
        }
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active,
        #guru-sidebar .nav-link:hover,
        #guru-sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
            pointer-events: auto !important;
            cursor: pointer !important;
        }
        
        /* Pastikan child elements tidak menghalangi */
        .sidebar .nav-link *,
        #guru-sidebar .nav-link * {
            pointer-events: none !important;
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
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-hadir { background: #28a745; color: white; }
        .badge-sakit { background: #ffc107; color: #000; }
        .badge-izin { background: #17a2b8; color: white; }
        .badge-alfa { background: #dc3545; color: white; }
        .table-responsive {
            border-radius: 10px;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        /* Pastikan form presensi siswa full width - ULTRA WIDE */
        #presensiForm,
        #presensiForm .card,
        #presensiForm .card-body,
        #presensiForm .table-responsive,
        #presensiForm .table {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        /* Pastikan card form presensi siswa full width */
        .card:has(#presensiForm),
        .card:has(.table-responsive:has(.table)) {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Pastikan table menggunakan seluruh lebar yang tersedia */
        #presensiForm .table {
            width: 100% !important;
            max-width: 100% !important;
            table-layout: auto !important;
        }
        
        /* Pastikan kolom Keterangan menggunakan lebar maksimal */
        #presensiForm .table th:last-child,
        #presensiForm .table td:last-child {
            width: auto !important;
            min-width: 300px !important;
        }
        
        /* Pastikan input keterangan full width */
        #presensiForm .table td:last-child input[type="text"] {
            width: 100% !important;
            min-width: 250px !important;
        }
        
        /* Pastikan select status konsisten ukurannya */
        #presensiForm .table td select.form-select {
            width: 100% !important;
            min-width: 120px !important;
        }
        .form-select:focus, .form-control:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        }
        
        /* Responsive Styles */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 9999;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            cursor: pointer;
            pointer-events: auto;
            touch-action: manipulation;
        }
        
        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
            transform: scale(1.05);
        }
        
        .sidebar-toggle:active {
            transform: scale(0.95);
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
            transition: background 0.3s ease;
        }
        
        .sidebar-overlay.show {
            background: rgba(0,0,0,0.05) !important;
            z-index: 1040 !important;
        }
        
        /* Pastikan sidebar lebih tinggi dari overlay dan hijau terang */
        .sidebar.show {
            z-index: 1061 !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        #sidebar.show {
            z-index: 1061 !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        /* Pastikan semua elemen di sidebar tidak hitam */
        .sidebar * {
            background-color: transparent !important;
        }
        
        .sidebar .p-4 {
            background: transparent !important;
        }
        
        .sidebar nav {
            background: transparent !important;
        }
        
        .sidebar .nav {
            background: transparent !important;
        }
        
        .sidebar .nav-link {
            background: transparent !important;
            background-color: transparent !important;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1) !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Make sure nav links are always clickable */
        .sidebar .nav-link {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            position: relative !important;
            display: block !important;
            touch-action: manipulation !important;
        }
        
        .sidebar .nav-link:hover {
            pointer-events: auto !important;
            background: rgba(255, 255, 255, 0.1) !important;
        }
        
        .sidebar .nav-link:active {
            pointer-events: auto !important;
        }
        
        /* Ensure sidebar is always above overlay */
        .sidebar.show {
            z-index: 1061 !important;
        }
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block !important;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1061 !important;
                transition: left 0.3s ease;
                width: 280px;
                max-width: 80%;
                height: 100vh;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                -webkit-overflow-scrolling: touch !important;
            }
            
            #guru-sidebar {
                height: 100vh;
                overflow-y: auto;
                overflow-x: hidden;
                -webkit-overflow-scrolling: touch;
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
                overscroll-behavior: contain !important;
                pointer-events: auto !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            .sidebar.show {
                left: 0;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            .sidebar-overlay.show {
                display: block;
                background: rgba(0,0,0,0.05) !important;
                z-index: 1040 !important;
            }
            
            /* Pastikan semua elemen di sidebar tidak hitam di mobile */
            .sidebar * {
                background-color: transparent !important;
            }
            
            .sidebar .p-4 {
                background: transparent !important;
            }
            
            .sidebar nav {
                background: transparent !important;
            }
            
            .sidebar .nav {
                background: transparent !important;
            }
            
            .sidebar .nav-link {
                background: transparent !important;
                background-color: transparent !important;
            }
            
            .sidebar .nav-link:hover, .sidebar .nav-link.active {
                background: rgba(255, 255, 255, 0.1) !important;
                background-color: rgba(255, 255, 255, 0.1) !important;
            }
            
            /* Ensure sidebar is always clickable when shown */
            .sidebar.show {
                pointer-events: auto !important;
            }
            
            .sidebar.show * {
                pointer-events: auto !important;
            }
            
            .col-md-9.col-lg-10 {
                width: 100% !important;
                margin-left: 0 !important;
            }
            
            .col-md-3.col-lg-2.sidebar {
                width: 100% !important;
            }
        }
        
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
        
        /* Pastikan konten muncul di samping sidebar */
        .container-fluid > .row {
            display: flex !important;
            flex-wrap: nowrap !important;
        }
        
        @media (min-width: 768px) {
            .col-md-3.col-lg-2 {
                flex: 0 0 auto !important;
            }
            .col-md-9.col-lg-10 {
                flex: 0 0 auto !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                width: auto !important;
                max-width: none !important;
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }
        }
        
        /* Pastikan card form presensi siswa full width */
        .card:has(#presensiForm),
        .card:has(.table-responsive:has(.table)) {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Pastikan table full width */
        #presensiForm .table-responsive,
        #presensiForm .table {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
        }
        
        /* Pastikan semua kolom table menggunakan lebar yang sesuai */
        #presensiForm .table th,
        #presensiForm .table td {
            white-space: normal !important;
        }
        
        #presensiForm .table td:last-child input {
            width: 100% !important;
        }
        
        /* Pastikan card-body tidak memiliki padding yang membatasi */
        .card:has(#presensiForm) .card-body {
            padding: 1.5rem !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        
        /* Pastikan container-fluid dan row menggunakan lebar penuh */
        .container-fluid {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        
        .container-fluid > .row {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        
        /* Pastikan table menggunakan seluruh lebar */
        #presensiForm .table-responsive {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        
        /* Pastikan semua konten terlihat */
        .col-md-9.col-lg-10,
        .col-md-9.col-lg-10 > *,
        .col-md-9.col-lg-10 .card,
        .col-md-9.col-lg-10 .card-body,
        .col-md-9.col-lg-10 .table,
        .col-md-9.col-lg-10 .alert,
        .col-md-9.col-lg-10 form,
        .col-md-9.col-lg-10 h2,
        .col-md-9.col-lg-10 p {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .col-md-9.col-lg-10 .d-flex {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .col-md-9.col-lg-10 .row {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid" style="position: relative; z-index: 1;">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4" style="display: block !important; visibility: visible !important; opacity: 1 !important; width: auto !important; flex: 0 0 auto !important; padding-left: 1.5rem !important; padding-right: 1.5rem !important;">
                <div class="d-flex justify-content-between align-items-center mb-4" style="display: flex !important; visibility: visible !important; opacity: 1 !important;">
                    <div>
                        <h2 class="mb-1" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                            <i class="fas fa-user-graduate me-2 text-primary"></i>
                            Presensi Siswa
                        </h2>
                        <p class="text-muted mb-0" style="display: block !important; visibility: visible !important; opacity: 1 !important;">Kelola presensi siswa untuk berbagai kelas dan tanggal</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="card mb-4" style="display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; z-index: 1 !important;">
                    <div class="card-body" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                        <form method="GET" action="{{ route('guru.presensi-siswa.index') }}" class="row g-3" style="display: flex !important; visibility: visible !important; opacity: 1 !important;">
                            <div class="col-md-3" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                                <label class="form-label" style="display: block !important; visibility: visible !important; opacity: 1 !important;">Pilih Kelas</label>
                                <select name="kelas" class="form-select" onchange="this.form.submit()" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                                    <option value="7" {{ $selectedKelas == '7' ? 'selected' : '' }}>Kelas 7</option>
                                    <option value="8" {{ $selectedKelas == '8' ? 'selected' : '' }}>Kelas 8</option>
                                    <option value="9" {{ $selectedKelas == '9' ? 'selected' : '' }}>Kelas 9</option>
                                </select>
                            </div>
                            <div class="col-md-3" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                                <label class="form-label" style="display: block !important; visibility: visible !important; opacity: 1 !important;">Pilih Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ $selectedTanggal }}" onchange="this.form.submit()" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                            </div>
                            <div class="col-md-6" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                                <label class="form-label" style="display: block !important; visibility: visible !important; opacity: 1 !important;">&nbsp;</label>
                                <div style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                                    <button type="submit" class="btn btn-primary" style="display: inline-block !important; visibility: visible !important; opacity: 1 !important;">
                                        <i class="fas fa-filter me-2"></i> Filter
                                    </button>
                                    <a href="{{ route('guru.presensi-siswa.index') }}" class="btn btn-outline-secondary" style="display: inline-block !important; visibility: visible !important; opacity: 1 !important;">
                                        <i class="fas fa-redo me-2"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Presensi Form -->
                @if(isset($siswas) && $siswas->count() > 0)
                <div class="card mb-4" style="display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; z-index: 1 !important; width: 100% !important; max-width: 100% !important; margin-left: 0 !important; margin-right: 0 !important; box-sizing: border-box !important;">
                    <div class="card-header bg-primary text-white" style="display: block !important; visibility: visible !important; opacity: 1 !important; width: 100% !important; box-sizing: border-box !important;">
                        <h5 class="mb-0" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                            <i class="fas fa-edit me-2"></i>
                            Form Presensi Siswa - Kelas {{ $selectedKelas }}
                        </h5>
                    </div>
                    <div class="card-body" style="display: block !important; visibility: visible !important; opacity: 1 !important; width: 100% !important; max-width: 100% !important; padding: 1.5rem !important; box-sizing: border-box !important;">
                        <form method="POST" action="{{ route('guru.presensi-siswa.store') }}" id="presensiForm" style="width: 100% !important; max-width: 100% !important;">
                            @csrf
                            <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
                            <input type="hidden" name="tanggal" value="{{ $selectedTanggal }}">

                            <div class="table-responsive" style="display: block !important; visibility: visible !important; opacity: 1 !important; width: 100% !important; max-width: 100% !important; overflow-x: auto !important; margin-left: 0 !important; margin-right: 0 !important; box-sizing: border-box !important;">
                                <table class="table table-hover" style="display: table !important; visibility: visible !important; opacity: 1 !important; width: 100% !important; max-width: 100% !important; table-layout: auto !important; margin: 0 !important; box-sizing: border-box !important;">
                                    <thead style="display: table-header-group !important; visibility: visible !important; opacity: 1 !important; width: 100% !important;">
                                        <tr style="display: table-row !important; visibility: visible !important; opacity: 1 !important; width: 100% !important;">
                                            <th style="display: table-cell !important; visibility: visible !important; opacity: 1 !important; width: 5% !important; min-width: 50px !important; padding: 0.75rem !important;">No</th>
                                            <th style="display: table-cell !important; visibility: visible !important; opacity: 1 !important; width: 12% !important; min-width: 100px !important; padding: 0.75rem !important;">NIS</th>
                                            <th style="display: table-cell !important; visibility: visible !important; opacity: 1 !important; width: 25% !important; min-width: 200px !important; padding: 0.75rem !important;">Nama Siswa</th>
                                            <th style="display: table-cell !important; visibility: visible !important; opacity: 1 !important; width: 18% !important; min-width: 150px !important; padding: 0.75rem !important;">Status</th>
                                            <th style="display: table-cell !important; visibility: visible !important; opacity: 1 !important; width: 40% !important; min-width: 350px !important; padding: 0.75rem !important;">Aktivitas Siswa & Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody style="display: table-row-group !important; visibility: visible !important; opacity: 1 !important;">
                                        @foreach($siswas as $index => $siswa)
                                            @php
                                                $existingPresensi = $presensiHariIni->get($siswa->id);
                                            @endphp
                                            <tr style="width: 100% !important;">
                                                <td style="width: 5% !important; min-width: 50px !important; padding: 0.75rem !important;">{{ $index + 1 }}</td>
                                                <td style="width: 12% !important; min-width: 100px !important; padding: 0.75rem !important;">{{ $siswa->nis }}</td>
                                                <td style="width: 25% !important; min-width: 200px !important; padding: 0.75rem !important;">
                                                    <strong>{{ $siswa->nama }}</strong>
                                                    @if($existingPresensi)
                                                        <br><small class="text-muted">
                                                            <i class="fas fa-check-circle text-success"></i> 
                                                            Sudah diisi: {{ $existingPresensi->status_label }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td style="width: 18% !important; min-width: 150px !important; padding: 0.75rem !important;">
                                                    <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                                    <select name="status[]" class="form-select form-select-sm" required style="width: 100% !important; min-width: 120px !important; box-sizing: border-box !important;">
                                                        <option value="hadir" {{ $existingPresensi && $existingPresensi->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                        <option value="sakit" {{ $existingPresensi && $existingPresensi->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                        <option value="izin" {{ $existingPresensi && $existingPresensi->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                                        <option value="alfa" {{ $existingPresensi && $existingPresensi->status == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                                    </select>
                                                </td>
                                                <td style="width: 40% !important; min-width: 350px !important; padding: 0.75rem !important;">
                                                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                                        <select name="aktivitas[]" class="form-select form-select-sm" style="width: 100% !important; box-sizing: border-box !important;">
                                                            <option value="">Pilih Aktivitas</option>
                                                            <option value="aktif" {{ $existingPresensi && $existingPresensi->aktivitas == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="tidak aktif di kelas" {{ $existingPresensi && $existingPresensi->aktivitas == 'tidak aktif di kelas' ? 'selected' : '' }}>Tidak Aktif di Kelas</option>
                                                        </select>
                                                        <input type="text" name="keterangan[]" class="form-control form-control-sm" 
                                                               placeholder="Keterangan (opsional)" 
                                                               value="{{ $existingPresensi ? $existingPresensi->keterangan : '' }}"
                                                               style="width: 100% !important; box-sizing: border-box !important;">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-3" style="display: flex !important; visibility: visible !important; opacity: 1 !important;">
                                <button type="submit" class="btn btn-primary btn-lg" style="display: inline-block !important; visibility: visible !important; opacity: 1 !important;">
                                    <i class="fas fa-save me-2"></i> Simpan Presensi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-info" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                    <i class="fas fa-info-circle me-2"></i>
                    Pilih kelas terlebih dahulu untuk melihat daftar siswa.
                </div>
                @endif

                <!-- Presensi History -->
                @if(isset($presensiHistory) && $presensiHistory->count() > 0)
                <div class="card" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>
                            Riwayat Presensi (30 Hari Terakhir) - Kelas {{ $selectedKelas }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                        <th>Aktivitas</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensiHistory as $presensi)
                                        <tr>
                                            <td>{{ $presensi->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $presensi->siswa->nis }}</td>
                                            <td>{{ $presensi->siswa->nama }}</td>
                                            <td>
                                                <span class="status-badge badge-{{ $presensi->status }}">
                                                    {{ $presensi->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($presensi->aktivitas)
                                                    <span class="badge bg-{{ $presensi->aktivitas == 'aktif' ? 'success' : 'warning' }}">
                                                        {{ $presensi->aktivitas == 'aktif' ? 'Aktif' : 'Tidak Aktif di Kelas' }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $presensi->keterangan ?? '-' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="editPresensi({{ $presensi->id }}, '{{ $presensi->status }}', '{{ $presensi->aktivitas ?? '' }}', '{{ $presensi->keterangan ?? '' }}')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('guru.presensi-siswa.destroy', $presensi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus presensi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Presensi Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" id="editStatus" required>
                                <option value="hadir">Hadir</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="alfa">Alfa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Aktivitas Siswa</label>
                            <select name="aktivitas" class="form-select" id="editAktivitas">
                                <option value="">Pilih Aktivitas</option>
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif di kelas">Tidak Aktif di Kelas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="editKeterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editPresensi(id, status, aktivitas, keterangan) {
            document.getElementById('editForm').action = '/guru/presensi-siswa/' + id;
            document.getElementById('editStatus').value = status;
            document.getElementById('editAktivitas').value = aktivitas || '';
            document.getElementById('editKeterangan').value = keterangan || '';
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
        
        function toggleSidebar() {
            const sidebar = document.getElementById('guru-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const isOpen = sidebar.classList.contains('show');
            
            if (isOpen) {
                // Close sidebar
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
            } else {
                // Open sidebar
                sidebar.classList.add('show');
                overlay.classList.add('show');
                if (overlay) overlay.style.display = 'block';
                // Prevent body scroll when sidebar is open
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('guru-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (window.innerWidth <= 991) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (overlay) overlay.style.display = 'none';
            }
            // Always reset body styles regardless of screen size
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        }
        
        // Ensure body has white background on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        });
        
        // Close sidebar when clicking outside on mobile
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
            });
        }
        
        // Robust function to setup nav links
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
                // Hanya pastikan href valid dan bisa diklik
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
        
        // Setup nav links saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            setupNavLinks();
            
            // Pastikan semua konten muncul
            const mainContent = document.querySelector('.col-md-9.col-lg-10');
            if (mainContent) {
                mainContent.style.setProperty('display', 'block', 'important');
                mainContent.style.setProperty('visibility', 'visible', 'important');
                mainContent.style.setProperty('opacity', '1', 'important');
                
                // Pastikan semua child elements juga terlihat
                const allChildren = mainContent.querySelectorAll('*');
                allChildren.forEach(child => {
                    if (window.getComputedStyle(child).display === 'none') {
                        child.style.setProperty('display', 'block', 'important');
                    }
                    child.style.setProperty('visibility', 'visible', 'important');
                    child.style.setProperty('opacity', '1', 'important');
                });
            }
            
            // Setup ulang setelah sidebar dibuka
            const observer = new MutationObserver(function(mutations) {
                setupNavLinks();
                
                // Pastikan konten tetap terlihat
                if (mainContent) {
                    mainContent.style.setProperty('display', 'block', 'important');
                    mainContent.style.setProperty('visibility', 'visible', 'important');
                    mainContent.style.setProperty('opacity', '1', 'important');
                }
            });
            
            const sidebar = document.getElementById('guru-sidebar');
            if (sidebar) {
                observer.observe(sidebar, {
                    childList: true,
                    subtree: true
                });
            }
        });
        
        // Also ensure sidebar itself is clickable
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.style.pointerEvents = 'auto';
            sidebar.style.zIndex = '1061';
        }
    </script>
</body>
</html>

