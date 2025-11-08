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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Dashboard Guru
                    </h4>
                    <div class="text-center mb-4">
                        @if($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="Foto Profil" 
                                 class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
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
                    <a class="nav-link" href="{{ route('guru.presensi.index') }}">
                        <i class="fas fa-calendar-check me-2"></i> Presensi Guru
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
</body>
</html>