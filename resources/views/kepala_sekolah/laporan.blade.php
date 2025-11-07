<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan - Kepala Sekolah</title>
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-user-tie me-2"></i>
                        Dashboard Kepala Sekolah
                    </h4>
                    <div class="text-center mb-4">
                        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user-tie fa-2x text-primary"></i>
                        </div>
                        <h6 class="text-white mt-2 mb-1">Maman Suparman, A.KS</h6>
                        <small class="text-white-50">Kepala Sekolah</small>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a href="{{ route('kepala_sekolah.dashboard') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('kepala_sekolah.laporan') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.laporan') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar me-2"></i>Laporan
                    </a>
                    <a href="{{ route('kepala_sekolah.guru') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.guru*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i>Data Guru
                    </a>
                    <a href="{{ route('kepala_sekolah.siswa.index') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.siswa*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate me-2"></i>Data Siswa
                    </a>
                    <a href="{{ route('kepala_sekolah.guru_activity') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.guru_activity') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Aktivitas Guru
                    </a>
                    <a href="{{ route('kepala_sekolah.notifications') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.notifications') ? 'active' : '' }}">
                        <i class="fas fa-bell me-2"></i>Notifikasi
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>
                            Laporan Sistem
                        </h2>
                        <p class="text-muted mb-0">Statistik dan laporan lengkap sistem pembelajaran</p>
                    </div>
                    <div>
                        <button class="btn btn-primary">
                            <i class="fas fa-download me-2"></i> Export PDF
                        </button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-chalkboard-teacher fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalGuru }}</div>
                                <h6 class="mb-0">Total Guru</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-book fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalMateri }}</div>
                                <h6 class="mb-0">Total Materi</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-question-circle fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalKuis }}</div>
                                <h6 class="mb-0">Total Kuis</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-clipboard-list fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalRangkuman }}</div>
                                <h6 class="mb-0">Total Rangkuman</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guru Performance -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-line me-2"></i>
                                    Performa Guru
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($gurus->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nama Guru</th>
                                                    <th>NIP</th>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Status</th>
                                                    <th>Aktivitas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($gurus as $guru)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                                    <i class="fas fa-user text-white"></i>
                                                                </div>
                                                                {{ $guru->user->name }}
                                                            </div>
                                                        </td>
                                                        <td>{{ $guru->nip }}</td>
                                                        <td>{{ $guru->mata_pelajaran }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $guru->status === 'aktif' ? 'success' : 'secondary' }}">
                                                                {{ ucfirst($guru->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('kepala_sekolah.guru.activity', $guru->id) }}" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye me-1"></i> Lihat
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada data guru</h5>
                                        <p class="text-muted">Data performa guru akan muncul di sini</p>
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
</body>
</html>
