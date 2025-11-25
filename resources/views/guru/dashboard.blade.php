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
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
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
            <div class="col-md-3 col-lg-2 sidebar p-0" id="sidebar">
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
                            
                            if ($freshGuru && !empty($freshGuru->foto)) {
                                // OTOMATIS cari foto dengan default path yang benar
                                $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                
                                // Jika masih null, coba dengan path lain
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
                                }
                                
                                // Jika masih null, coba langsung dengan asset() untuk URL lengkap
                                if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                                    $photoUrl = asset('storage/' . $freshGuru->foto) . '?v=' . time() . '&r=' . rand(1000, 9999);
                                }
                            }
                            $hasPhoto = $photoUrl !== null && $photoUrl !== '';
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
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
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
                    <hr class="text-white-50">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
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
                    <div class="card mb-4">
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
                                <i class="fas fa-calendar-alt fa-2x mb-3"></i>
                                <div class="stat-number">{{ $jadwalHariIni->count() }}</div>
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
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(event.target) && 
                    !toggleBtn.contains(event.target) && 
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>