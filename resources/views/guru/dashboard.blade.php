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
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
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
            
            .sidebar {
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
            <div class="col-md-3 col-lg-2 sidebar p-0" id="guru-sidebar">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Dashboard Guru
                    </h4>
                    <div class="text-center mb-4">
                        @php
                            // SELALU ambil data fresh dari database untuk memastikan foto terbaru
                            $freshGuru = \App\Models\Guru::find($guru->id);
                            $photoUrl = null;
                            $hasPhoto = false;
                            
                            if ($freshGuru && !empty($freshGuru->foto)) {
                                // Method 1: PhotoHelper dengan default path
                                $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                
                                // Method 2: PhotoHelper dengan path lain
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
                                }
                                
                                // Method 3: PhotoHelper dengan path guru/foto
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'guru/foto');
                                }
                                
                                // Method 4: Langsung cek di storage dengan path dari database
                                if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                }
                                
                                // Method 5: Cek dengan basename di folder profiles/guru
                                if (!$photoUrl) {
                                    $basename = basename($freshGuru->foto);
                                    $storagePath = 'profiles/guru/' . $basename;
                                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                                        $baseUrl = request()->getSchemeAndHttpHost();
                                        $photoUrl = $baseUrl . '/storage/' . $storagePath . '?v=' . time() . '&r=' . rand(1000, 9999);
                                    }
                                }
                                
                                // Method 6: Cek file secara langsung di disk dengan berbagai kemungkinan path
                                if (!$photoUrl) {
                                    $possiblePaths = [
                                        $freshGuru->foto,
                                        'profiles/guru/' . basename($freshGuru->foto),
                                        'guru/foto/' . basename($freshGuru->foto),
                                        'image/profiles/' . basename($freshGuru->foto)
                                    ];
                                    
                                    foreach ($possiblePaths as $possiblePath) {
                                        $fullPath = storage_path('app/public/' . $possiblePath);
                                        if (file_exists($fullPath)) {
                                            $baseUrl = request()->getSchemeAndHttpHost();
                                            $photoUrl = $baseUrl . '/storage/' . $possiblePath . '?v=' . time() . '&r=' . rand(1000, 9999);
                                            break;
                                        }
                                    }
                                }
                                
                                // Method 7: Jika PhotoHelper menghasilkan URL dengan localhost, ganti dengan base URL dari request
                                if ($photoUrl && (strpos($photoUrl, 'localhost') !== false || strpos($photoUrl, '127.0.0.1') !== false)) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = str_replace(['http://localhost', 'https://localhost', 'http://127.0.0.1', 'https://127.0.0.1'], $baseUrl, $photoUrl);
                                }
                                
                                // Method 8: Jika masih null, coba langsung construct URL dari path di database (fallback)
                                if (!$photoUrl && !empty($freshGuru->foto)) {
                                    $baseUrl = request()->getSchemeAndHttpHost();
                                    $photoUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                                }
                                
                                $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null' && $photoUrl !== '#';
                            }
                        @endphp
                        @if($hasPhoto && $photoUrl)
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <img src="{{ $photoUrl }}" alt="Foto Profil" id="profile-photo-img-guru" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;" onload="console.log('Dashboard photo loaded:', this.src); this.style.display='block'; document.getElementById('profile-placeholder-guru').style.display='none';" onerror="console.error('Dashboard photo error:', this.src); this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder-guru').style.display='flex';">
                                <div id="profile-placeholder-guru" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 100px; height: 100px; top: 0; left: 0; z-index: 1;">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
                        @elseif(!empty($freshGuru->foto))
                            {{-- Jika ada path di database tapi tidak bisa dimuat, coba tampilkan dengan URL langsung --}}
                            @php
                                $baseUrl = request()->getSchemeAndHttpHost();
                                $directUrl = $baseUrl . '/storage/' . $freshGuru->foto . '?v=' . time() . '&r=' . rand(1000, 9999);
                            @endphp
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <img src="{{ $directUrl }}" alt="Foto Profil" id="profile-photo-img-guru" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;" onload="console.log('Dashboard photo loaded (direct):', this.src); this.style.display='block'; document.getElementById('profile-placeholder-guru').style.display='none';" onerror="console.error('Dashboard photo error (direct):', this.src); this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder-guru').style.display='flex';">
                                <div id="profile-placeholder-guru" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 100px; height: 100px; top: 0; left: 0; z-index: 1;">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3 pb-4">
                    <a class="nav-link active" href="{{ route('guru.dashboard') }}">
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
                    <a class="nav-link" href="{{ route('guru.materi.index') }}">
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

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-book fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalMateri }}</div>
                                <div>Total Materi</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-check-circle fa-2x mb-3"></i>
                                <div class="stat-number">{{ $materiPublished }}</div>
                                <div>Materi Dipublikasi</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-question-circle fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalKuis }}</div>
                                <div>Total Kuis</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-day fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalJadwalHariIni ?? ($jadwalHariIni->count() ?? 0) }}</div>
                                <div>Jadwal Hari Ini</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Mengajar Hari Ini -->
                @if(isset($jadwalHariIni) && $jadwalHariIni->count() > 0)
                <div class="card mb-4 border-warning">
                    <div class="card-header bg-warning bg-opacity-10 border-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-clock me-2 text-warning"></i>
                                Jadwal Mengajar Hari Ini ({{ \Carbon\Carbon::today()->format('d F Y') }})
                            </h5>
                            <span class="badge bg-warning text-dark">{{ $jadwalHariIni->count() }} Jadwal</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($jadwalHariIni as $jadwal)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-primary h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0 text-primary">
                                                    <i class="fas fa-book me-2"></i>{{ $jadwal->mata_pelajaran_nama }}
                                                </h6>
                                                <span class="badge bg-primary">{{ $jadwal->kelas }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                </small>
                                            </div>
                                            <div class="d-flex gap-2 flex-wrap">
                                                @if($jadwal->is_lab)
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-flask me-1"></i>Laboratorium
                                                    </span>
                                                @endif
                                                @if($jadwal->is_lapangan)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-running me-1"></i>Lapangan
                                                    </span>
                                                @endif
                                                @if($jadwal->ruang)
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-door-open me-1"></i>{{ $jadwal->ruang }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($jadwal->keterangan)
                                                <p class="text-muted small mt-2 mb-0">
                                                    <i class="fas fa-info-circle me-1"></i>{{ Str::limit($jadwal->keterangan, 50) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="card mb-4 border-secondary">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Tidak ada jadwal mengajar hari ini</p>
                    </div>
                </div>
                @endif

                <!-- Jadwal Mengajar Minggu Ini -->
                <div class="card mb-4 border-info">
                    <div class="card-header bg-info bg-opacity-10 border-info">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-week me-2 text-info"></i>
                                Jadwal Mengajar Minggu Ini
                            </h5>
                            <a href="{{ route('guru.jadwal.index', ['filter' => 'minggu_ini']) }}" class="btn btn-sm btn-outline-info">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($jadwalMingguIni && $jadwalMingguIni->count() > 0)
                        <div class="row">
                            @foreach($jadwalMingguIni->take(6) as $jadwal)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border-info h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0 text-info">
                                                    <i class="fas fa-book me-2"></i>{{ $jadwal->mata_pelajaran_nama }}
                                                </h6>
                                                <span class="badge bg-info">{{ $jadwal->kelas }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    <strong>{{ ucfirst($jadwal->hari) }}</strong>
                                                    @if($jadwal->tanggal)
                                                        ({{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }})
                                                    @endif
                                                </small>
                                                <small class="text-muted d-block mt-1">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                </small>
                                            </div>
                                            <div class="d-flex gap-2 flex-wrap">
                                                @if($jadwal->is_lab)
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-flask me-1"></i>Laboratorium
                                                    </span>
                                                @endif
                                                @if($jadwal->is_lapangan)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-running me-1"></i>Lapangan
                                                    </span>
                                                @endif
                                                @if($jadwal->ruang)
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-door-open me-1"></i>{{ $jadwal->ruang }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada jadwal mengajar untuk minggu ini. Jadwal akan muncul setelah ditentukan oleh Tenaga Usaha.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Jadwal Mengajar Mendatang -->
                <div class="card mb-4 border-primary">
                    <div class="card-header bg-primary bg-opacity-10 border-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                Jadwal Mengajar Mendatang (7 Hari Ke Depan)
                            </h5>
                            <a href="{{ route('guru.jadwal.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($jadwalMendatang && $jadwalMendatang->count() > 0)
                        <div class="row">
                            @foreach($jadwalMendatang as $jadwal)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border-primary h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0 text-primary">
                                                    <i class="fas fa-book me-2"></i>{{ $jadwal->mata_pelajaran_nama }}
                                                </h6>
                                                <span class="badge bg-primary">{{ $jadwal->kelas }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    <strong>{{ ucfirst($jadwal->hari) }}</strong>
                                                    @if($jadwal->tanggal)
                                                        ({{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }})
                                                    @endif
                                                </small>
                                                <small class="text-muted d-block mt-1">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                </small>
                                            </div>
                                            <div class="d-flex gap-2 flex-wrap">
                                                @if($jadwal->is_lab)
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-flask me-1"></i>Laboratorium
                                                    </span>
                                                @endif
                                                @if($jadwal->is_lapangan)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-running me-1"></i>Lapangan
                                                    </span>
                                                @endif
                                                @if($jadwal->ruang)
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-door-open me-1"></i>{{ $jadwal->ruang }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada jadwal mengajar mendatang. Jadwal akan muncul setelah ditentukan oleh Tenaga Usaha.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <!-- Materi Terbaru -->
                    <div class="col-md-8 mb-4">
                        <div class="card content-card">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-book me-2 text-primary"></i>
                                        Materi Terbaru
                                    </h5>
                                    <a href="{{ route('guru.materi.index') }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Semua
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($materiTerbaru->count() > 0)
                                    @foreach($materiTerbaru as $materi)
                                        <div class="materi-item">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $materi->judul }}</h6>
                                                    <p class="text-muted mb-2 small">{{ Str::limit($materi->deskripsi, 100) }}</p>
                                                    <div class="d-flex gap-2">
                                                        <span class="badge bg-light text-dark">{{ $materi->kelas }}</span>
                                                        <span class="badge bg-light text-dark">{{ $materi->topik }}</span>
                                                        @if($materi->is_published)
                                                            <span class="status-badge status-published">Dipublikasi</span>
                                                        @else
                                                            <span class="status-badge status-draft">Draft</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <small class="text-muted">{{ $materi->created_at->format('d M Y') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Kuis Aktif -->
                    <div class="col-md-4 mb-4">
                        <div class="card content-card">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-question-circle me-2 text-primary"></i>
                                        Kuis Aktif
                                    </h5>
                                    <a href="{{ route('guru.kuis.index') }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Semua
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($kuisAktif->count() > 0)
                                    @foreach($kuisAktif as $kuis)
                                        <div class="mb-3 p-3 border rounded">
                                            <h6 class="mb-1">{{ $kuis->judul }}</h6>
                                            <p class="text-muted small mb-2">{{ $kuis->kelas }} - {{ $kuis->mata_pelajaran }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="kuis-badge">
                                                    {{ $kuis->status }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ $kuis->tanggal_mulai->format('d M') }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Hari Ini -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card content-card">
                            <div class="card-body text-center py-5">
                                @if($jadwalHariIni && $jadwalHariIni->count() > 0)
                                    <div class="row">
                                        @foreach($jadwalHariIni as $jadwal)
                                            <div class="col-md-6 mb-3">
                                                <div class="p-3 border rounded">
                                                    <h6 class="mb-2">{{ $jadwal->mata_pelajaran }}</h6>
                                                    <p class="mb-1 text-muted small">{{ $jadwal->kelas }}</p>
                                                    <p class="mb-0">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                                        @if($jadwal->ruang)
                                                            <span class="ms-2">
                                                                <i class="fas fa-door-open me-1"></i>{{ $jadwal->ruang }}
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <i class="fas fa-calendar-times fa-3x text-danger mb-3"></i>
                                    <h5 class="text-muted">Tidak ada jadwal mengajar hari ini</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Minggu Ini -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card content-card">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        Jadwal Mengajar Minggu Ini
                                    </h5>
                                    <a href="{{ route('guru.jadwal.index') }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Semua
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($jadwalMingguIni && $jadwalMingguIni->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Hari</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Kelas</th>
                                                    <th>Jam</th>
                                                    <th>Ruang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($jadwalMingguIni as $jadwal)
                                                    <tr>
                                                        <td><strong>{{ ucfirst($jadwal->hari) }}</strong></td>
                                                        <td>{{ $jadwal->mata_pelajaran }}</td>
                                                        <td>{{ $jadwal->kelas }}</td>
                                                        <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                                        <td>{{ $jadwal->ruang ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted text-center py-3">Tidak ada jadwal mengajar minggu ini</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="card content-card">
                            <div class="card-header bg-white border-0">
                                <h5 class="mb-0">
                                    <i class="fas fa-bolt me-2 text-primary"></i>
                                    Quick Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <a href="{{ route('guru.materi.create') }}" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-plus me-2"></i>
                                            Tambah Materi
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="{{ route('guru.kuis.create') }}" class="btn btn-outline-success w-100">
                                            <i class="fas fa-question-circle me-2"></i>
                                            Buat Kuis
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="{{ route('guru.profil') }}" class="btn btn-outline-warning w-100">
                                            <i class="fas fa-user me-2"></i>
                                            Edit Profil
                                        </a>
                                    </div>
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
        
        // Setup nav links saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
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