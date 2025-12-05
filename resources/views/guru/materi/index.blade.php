@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Materi - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
            margin: 0;
            padding: 0;
        }
        
        body {
            overflow-x: hidden;
            position: relative;
        }
        
        /* Pastikan tombol sidebar-toggle selalu di atas semua elemen */
        .sidebar-toggle {
            position: fixed !important;
            z-index: 99999 !important;
            pointer-events: auto !important;
        }
        
        /* Pastikan YouTube button tidak tertutup oleh sidebar toggle */
        .youtube-btn {
            position: relative !important;
            z-index: 1 !important;
        }
        
        @media (max-width: 991px) {
            /* Di mobile, pastikan YouTube button tidak tertutup */
            .d-flex.justify-content-between.align-items-center.mb-4 {
                padding-left: 60px !important; /* Beri ruang untuk hamburger menu */
            }
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Ensure sidebar content is scrollable */
        #guru-sidebar {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
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
            z-index: 1061 !important;
        }
        
        #sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            z-index: 1061 !important;
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
        
        /* Make sure nav links are always clickable */
        .sidebar .nav-link {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            position: relative !important;
            display: block !important;
            touch-action: manipulation !important;
            -webkit-tap-highlight-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Responsive Styles */
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
            line-height: 1;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            -webkit-user-select: none;
        }
        
        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
            transform: scale(1.05);
        }
        
        .sidebar-toggle:active {
            transform: scale(0.95);
            background: linear-gradient(135deg, #0D4A12 0%, #2E7D32 100%);
        }
        
        .sidebar-toggle:focus {
            outline: 2px solid rgba(255,255,255,0.5);
            outline-offset: 2px;
        }
        
        /* Pastikan tombol selalu terlihat di mobile (lebar layar < 992px) */
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                z-index: 99999 !important;
                pointer-events: auto !important;
                position: fixed !important;
                top: 15px !important;
                left: 15px !important;
            }
            
            /* Pastikan container tidak menutupi tombol */
            .container-fluid {
                margin-top: 0 !important;
                padding-top: 0 !important;
                z-index: 1 !important;
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
                -webkit-overflow-scrolling: touch;
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
                -webkit-overflow-scrolling: touch !important;
                pointer-events: auto !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            .sidebar.show {
                left: 0 !important;
                transform: translateX(0) !important;
                pointer-events: auto !important;
                z-index: 1061 !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            #sidebar.show {
                left: 0 !important;
                transform: translateX(0) !important;
                pointer-events: auto !important;
                z-index: 1061 !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            .sidebar-overlay.show {
                display: block !important;
                opacity: 1 !important;
                background: rgba(0,0,0,0.05) !important;
                z-index: 1040 !important;
            }
            
            .sidebar-overlay {
                z-index: 1040 !important;
            }
            
            /* Pastikan sidebar bisa di-scroll */
            .sidebar.show {
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }
        }
        
        /* Ensure sidebar is always above overlay */
        .sidebar.show {
            z-index: 1061 !important;
        }
        
        /* Header Section Styling */
        .header-section {
            position: relative;
            z-index: 1;
            width: 100%;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .header-title-section {
            flex: 1;
            min-width: 200px;
        }
        
        .header-title-section h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        
        .header-title-section p {
            font-size: 0.95rem;
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        /* YouTube Button Styling */
        .youtube-btn {
            background-color: #FF0000 !important;
            border-color: #FF0000 !important;
            color: white !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 10px 18px !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            white-space: nowrap !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(255, 0, 0, 0.3) !important;
            position: relative !important;
            z-index: 10 !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
        }
        
        .youtube-btn:hover {
            background-color: #CC0000 !important;
            border-color: #CC0000 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.4) !important;
        }
        
        .youtube-btn:active {
            transform: translateY(0);
        }
        
        .youtube-btn i {
            font-size: 18px !important;
        }
        
        .btn-success {
            padding: 10px 18px !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(46, 125, 50, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.4) !important;
        }
        
        /* Responsive Design */
        @media (max-width: 991px) {
            .header-content {
                margin-left: 60px;
            }
            
            .header-title-section h2 {
                font-size: 1.5rem;
            }
            
            .header-title-section p {
                font-size: 0.85rem;
            }
            
            .youtube-btn {
                padding: 8px 14px !important;
                font-size: 13px !important;
            }
            
            .youtube-btn i {
                font-size: 16px !important;
            }
            
            .youtube-btn span {
                display: none;
            }
            
            .btn-success {
                padding: 8px 14px !important;
                font-size: 13px !important;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                margin-left: 60px;
            }
            
            .header-title-section {
                width: 100%;
            }
            
            .header-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .youtube-btn,
            .btn-success {
                flex: 1;
                min-width: 120px;
                justify-content: center;
            }
        }
        
        @media (max-width: 576px) {
            .header-content {
                margin-left: 0;
                padding-top: 10px;
            }
            
            .header-title-section h2 {
                font-size: 1.25rem;
            }
            
            .header-actions {
                width: 100%;
                gap: 8px;
            }
            
            .youtube-btn {
                padding: 8px 12px !important;
                font-size: 12px !important;
            }
            
            .youtube-btn i {
                font-size: 14px !important;
                margin-right: 0 !important;
            }
            
            .btn-success {
                padding: 8px 12px !important;
                font-size: 12px !important;
            }
        }
        
        /* Search and Filter Form Styling */
        .search-filter-form .form-label {
            color: #495057;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .search-filter-form .form-control,
        .search-filter-form .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .search-filter-form .form-control:focus,
        .search-filter-form .form-select:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
            outline: none;
        }
        
        .search-filter-form .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(46, 125, 50, 0.3);
            transition: all 0.3s ease;
        }
        
        .search-filter-form .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.4);
        }
        
        @media (max-width: 768px) {
            .search-filter-form .row {
                margin: 0;
            }
            
            .search-filter-form .col-md-4,
            .search-filter-form .col-md-3,
            .search-filter-form .col-md-2 {
                padding: 0.5rem;
            }
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
            <div class="col-md-3 col-lg-2 sidebar p-0" id="guru-sidebar" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important; background-color: #2E7D32 !important;">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Dashboard Guru
                    </h4>
                    <div class="text-center mb-4">
                        @php
                            $freshGuru = \App\Models\Guru::find($guru->id);
                            $photoUrl = null;
                            $hasPhoto = false;
                            if ($freshGuru && !empty($freshGuru->foto)) {
                                $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                if (!$photoUrl) { $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles'); }
                                if (!$photoUrl) { $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'guru/foto'); }
                                if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                }
                                if (!$photoUrl) {
                                    $basename = basename($freshGuru->foto);
                                    $storagePath = 'profiles/guru/' . $basename;
                                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                                        $baseUrl = request()->getSchemeAndHttpHost();
                                        $photoUrl = $baseUrl . '/storage/' . $storagePath . '?v=' . time() . '&r=' . rand(1000, 9999);
                                    }
                                }
                                if ($photoUrl && (strpos($photoUrl, 'localhost') !== false || strpos($photoUrl, '127.0.0.1') !== false)) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = str_replace(['http://localhost', 'https://localhost', 'http://127.0.0.1', 'https://127.0.0.1'], $baseUrl, $photoUrl);
                                }
                                if (!$photoUrl && !empty($freshGuru->foto)) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                }
                                $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null' && $photoUrl !== '#';
                            }
                        @endphp
                        @if($hasPhoto && $photoUrl)
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <img src="{{ $photoUrl }}" alt="Foto Profil" id="profile-photo-img-guru" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder-guru').style.display='flex';">
                                <div id="profile-placeholder-guru" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 100px; height: 100px; top: 0; left: 0; z-index: 1;">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h5 class="text-white mt-3 mb-1">{{ $guru->user->name }}</h5>
                        <p class="text-white-50 small mb-2">{{ $guru->mata_pelajaran }}</p>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-edit me-1"></i> Edit Profil
                        </a>
                    </div>
                    <nav class="nav flex-column px-3 pb-4">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('guru.jadwal.index') }}">
                            <i class="fas fa-calendar-alt me-2"></i> Jadwal Mengajar
                        </a>
                        <a class="nav-link" href="{{ route('guru.presensi.index') }}">
                            <i class="fas fa-calendar-check me-2"></i> Presensi Guru
                        </a>
                        <a class="nav-link" href="{{ route('guru.presensi-siswa.index') }}">
                            <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
                        </a>
                        <a class="nav-link active" href="{{ route('guru.materi.index') }}">
                            <i class="fas fa-book me-2"></i> Materi
                        </a>
                        <a class="nav-link" href="{{ route('guru.kuis.index') }}">
                            <i class="fas fa-question-circle me-2"></i> Kuis
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="container-fluid py-4">
                    <div class="header-section mb-4">
                        <div class="header-content">
                            <div class="header-title-section">
                                <h2 class="mb-1">Manajemen Materi</h2>
                                <p class="text-muted mb-0">Kelola materi pembelajaran Anda</p>
                            </div>
                            <div class="header-actions">
                                <a href="https://www.youtube.com" target="_blank" class="youtube-btn">
                                    <i class="fab fa-youtube me-2"></i>
                                    <span>YouTube</span>
                                </a>
                                <a href="{{ route('guru.materi.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i> Tambah Materi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('guru.materi.index') }}" class="search-filter-form">
                                <div class="row g-3">
                                    <div class="col-md-4 col-sm-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-search me-1"></i>Cari Materi
                                        </label>
                                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari materi...">
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-users me-1"></i>Kelas
                                        </label>
                                        <select class="form-select" name="kelas">
                                            <option value="">Semua Kelas</option>
                                            <option value="7" {{ request('kelas') == '7' ? 'selected' : '' }}>Kelas 7</option>
                                            <option value="8" {{ request('kelas') == '8' ? 'selected' : '' }}>Kelas 8</option>
                                            <option value="9" {{ request('kelas') == '9' ? 'selected' : '' }}>Kelas 9</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-tag me-1"></i>Topik
                                        </label>
                                        <input type="text" class="form-control" name="topik" value="{{ request('topik') }}" placeholder="Topik...">
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <label class="form-label fw-semibold d-block">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search me-1"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Materi List -->
                    @if($materi->count() > 0)
                        <div class="row">
                            @foreach($materi as $item)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->judul }}</h5>
                                            <p class="card-text text-muted small">{{ Str::limit($item->deskripsi, 100) }}</p>
                                            
                                            @if($item->file_path)
                                                @php
                                                    $extension = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                                                    $iconClass = 'fas fa-file';
                                                    $iconBg = 'file-document';
                                                    if (in_array($extension, ['pdf'])) {
                                                        $iconClass = 'fas fa-file-pdf';
                                                        $iconBg = 'file-pdf';
                                                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                        $iconClass = 'fas fa-file-image';
                                                        $iconBg = 'file-image';
                                                    } elseif (in_array($extension, ['doc', 'docx'])) {
                                                        $iconClass = 'fas fa-file-word';
                                                        $iconBg = 'file-document';
                                                    }
                                                @endphp
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="file-icon {{ $iconBg }} me-2">
                                                        <i class="{{ $iconClass }}"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted d-block">{{ $item->file_type }}</small>
                                                        <small class="text-muted">{{ $item->file_size_formatted }}</small>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($item->link_video)
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="file-icon file-video me-2">
                                                            <i class="fas fa-video"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <small class="text-muted">Video Pembelajaran</small>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $videoUrl = $item->link_video;
                                                        // Convert to watch URL if it's an embed URL
                                                        if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                                            $videoUrl = 'https://www.youtube.com/watch?v=' . $matches[1];
                                                        } elseif (strpos($videoUrl, 'youtube.com/watch') === false && strpos($videoUrl, 'youtu.be') === false) {
                                                            // If it's not a standard YouTube URL, try to extract video ID
                                                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                                                $videoUrl = 'https://www.youtube.com/watch?v=' . $matches[1];
                                                            }
                                                        }
                                                        // Ensure it's a valid YouTube URL
                                                        if (strpos($videoUrl, 'youtube.com') === false && strpos($videoUrl, 'youtu.be') === false) {
                                                            $videoUrl = 'https://www.youtube.com';
                                                        }
                                                    @endphp
                                                    <a href="{{ $videoUrl }}" target="_blank" class="btn btn-danger btn-sm" style="background-color: #FF0000 !important; border-color: #FF0000 !important; color: white !important; display: inline-flex !important; align-items: center !important; padding: 6px 12px !important; text-decoration: none !important; font-weight: 500 !important;">
                                                        <span style="margin-right: 5px; font-size: 16px;">▶</span>
                                                        <i class="fab fa-youtube me-1" style="font-size: 16px !important;"></i>
                                                        <span>YouTube</span>
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="d-flex flex-wrap gap-1 mb-3">
                                                <span class="badge bg-light text-dark">{{ $item->kelas }}</span>
                                                <span class="badge bg-light text-dark">{{ $item->topik }}</span>
                                                @if($item->is_published)
                                                    <span class="status-badge status-published">Dipublikasi</span>
                                                @else
                                                    <span class="status-badge status-draft">Draft</span>
                                                @endif
                                            </div>

                                            <div class="d-flex gap-2">
                                                <a href="{{ route('guru.materi.show', $item) }}" 
                                                   class="btn btn-sm btn-outline-primary flex-grow-1">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                                <a href="{{ route('guru.materi.edit', $item) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $item->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $materi->links() }}
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada materi</h5>
                                <p class="text-muted">Mulai tambahkan materi pembelajaran untuk siswa Anda</p>
                                <a href="{{ route('guru.materi.create') }}" class="btn btn-success mt-3">
                                    <i class="fas fa-plus me-2"></i> Tambah Materi Pertama
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
        
        // Robust function to setup nav links
        function setupNavLinks() {
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(function(link) {
                // Force styles dengan !important
                link.style.setProperty('pointer-events', 'auto', 'important');
                link.style.setProperty('cursor', 'pointer', 'important');
                link.style.setProperty('z-index', '1001', 'important');
                link.style.setProperty('position', 'relative', 'important');
                link.style.setProperty('display', 'block', 'important');
                link.style.setProperty('touch-action', 'manipulation', 'important');
                
                // Remove existing listeners by cloning
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);
                
                // Add click event listener
                newLink.addEventListener('click', function(e) {
                    console.log('Nav link clicked:', newLink.href);
                    const href = newLink.getAttribute('href');
                    
                    if (href && href !== '#' && href !== 'javascript:void(0)') {
                        closeSidebar();
                        // Biarkan browser navigate secara normal
                    } else {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }, { capture: false });
                
                // Add touch event listener untuk mobile
                newLink.addEventListener('touchend', function(e) {
                    console.log('Nav link touched:', newLink.href);
                    const href = newLink.getAttribute('href');
                    
                    if (href && href !== '#' && href !== 'javascript:void(0)') {
                        closeSidebar();
                        window.location.href = href;
                        e.preventDefault();
                        return false;
                    }
                }, { capture: false });
            });
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
            
            // Setup nav links
            setupNavLinks();
            
            // Setup ulang setelah sidebar dibuka
            const observer = new MutationObserver(function(mutations) {
                setupNavLinks();
            });
            
            const sidebar = document.getElementById('guru-sidebar');
            if (sidebar) {
                observer.observe(sidebar, {
                    childList: true,
                    subtree: true
                });
            }
        });
    </script>
</body>
</html>