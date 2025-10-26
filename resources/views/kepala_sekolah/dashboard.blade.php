<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Sekolah - {{ Auth::user()->name }}</title>
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
        .feature-btn {
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 4px 0;
        }
        .feature-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .feature-btn.laporan {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
        }
        .feature-btn.guru {
            background: linear-gradient(135deg, #1976D2 0%, #42A5F5 100%);
            color: white;
        }
        .feature-btn.bulanan {
            background: linear-gradient(135deg, #7B1FA2 0%, #BA68C8 100%);
            color: white;
        }
        .feature-btn.pengaturan {
            background: linear-gradient(135deg, #F57C00 0%, #FFB74D 100%);
            color: white;
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
                    <a href="{{ route('kepala_sekolah.dashboard') }}" class="nav-link active">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('kepala_sekolah.laporan') }}" class="nav-link">
                        <i class="fas fa-chart-bar me-2"></i>Laporan
                    </a>
                    <a href="{{ route('kepala_sekolah.guru') }}" class="nav-link">
                        <i class="fas fa-users me-2"></i>Data Guru
                    </a>
                    <a href="{{ route('kepala_sekolah.guru_activity') }}" class="nav-link">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Aktivitas Guru
                    </a>
                    <a href="{{ route('kepala_sekolah.notifications') }}" class="nav-link">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Selamat Datang, Maman Suparman, A.KS!</h2>
                        <p class="text-muted">Dashboard Kepala Sekolah MTs Nurul Aiman</p>
                        <p class="text-muted small">NUPTK: 9661750652200022</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="badge bg-primary px-3 py-2">Kepala Sekolah</span>
                        </div>
                        <div class="position-relative me-3">
                            <i class="fas fa-bell text-danger fs-4"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadNotifications }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-2x mb-3"></i>
                                <div class="stat-number">{{ \App\Models\Guru::count() }}</div>
                                <p class="mb-0">Total Guru</p>
            </div>
                    </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-graduation-cap fa-2x mb-3"></i>
                                <div class="stat-number">180</div>
                                <p class="mb-0">Total Siswa</p>
                </div>
            </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line fa-2x mb-3"></i>
                                <div class="stat-number">85%</div>
                                <p class="mb-0">Kehadiran Rata-rata</p>
                </div>
            </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-trophy fa-2x mb-3"></i>
                                <div class="stat-number">3</div>
                                <p class="mb-0">Prestasi Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>

                <!-- Main Content Row -->
                <div class="row">
            <!-- Data Guru dan Mata Pelajaran -->
                    <div class="col-lg-8 mb-4">
                        <div class="card content-card">
                            <div class="card-header">
                                <h5 class="mb-0">Data Guru dan Mata Pelajaran</h5>
                </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Guru</th>
                                                <th>Mata Pelajaran</th>
                                                <th>Status</th>
                                </tr>
                            </thead>
                                        <tbody>
                                @php
                                    $gurus = \App\Models\Guru::with('user')->take(5)->get();
                                @endphp
                                @foreach($gurus as $guru)
                                <tr>
                                                <td>{{ $guru->user->name }}</td>
                                                <td>{{ $guru->mata_pelajaran }}</td>
                                                <td>
                                        @if($guru->status === 'aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                        @elseif($guru->status === 'izin')
                                                        <span class="badge bg-warning">Izin</span>
                                        @else
                                                        <span class="badge bg-danger">Sakit</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                                <a href="{{ route('kepala_sekolah.guru') }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>Lihat Semua Data
                    </a>
                </div>
            </div>
                    </div>

                    <!-- Sidebar Content -->
                    <div class="col-lg-4">
                        <!-- Kehadiran Hari Ini -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Kehadiran Hari Ini</h5>
                            </div>
                            <div class="card-body">
                    @php
                        $totalGuru = \App\Models\Guru::count();
                        $hadir = \App\Models\Guru::where('status', 'aktif')->count();
                        $izin = \App\Models\Guru::where('status', 'izin')->count();
                        $sakit = \App\Models\Guru::where('status', 'sakit')->count();
                        $persentase = $totalGuru > 0 ? round(($hadir / $totalGuru) * 100) : 0;
                    @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Total Guru</span>
                                        <span class="fw-bold">{{ $totalGuru }}</span>
                        </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Hadir</span>
                                        <span class="fw-bold text-success">{{ $hadir }}</span>
                        </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Izin</span>
                                        <span class="fw-bold text-warning">{{ $izin }}</span>
                        </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Sakit</span>
                                        <span class="fw-bold text-danger">{{ $sakit }}</span>
                        </div>
                    </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ $persentase }}%"></div>
                            </div>
                                <p class="text-center mb-0">{{ $persentase }}% Kehadiran</p>
                    </div>
                </div>

                <!-- Fitur Utama -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Fitur Utama</h5>
                    </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('kepala_sekolah.laporan') }}" class="btn feature-btn laporan">
                                        <i class="fas fa-chart-bar me-2"></i>Laporan Kehadiran
                                    </a>
                                    <a href="{{ route('kepala_sekolah.guru') }}" class="btn feature-btn guru">
                                        <i class="fas fa-users me-2"></i>Kelola Data Guru
                                    </a>
                                    <a href="{{ route('kepala_sekolah.laporan') }}" class="btn feature-btn bulanan">
                                        <i class="fas fa-file-alt me-2"></i>Laporan Bulanan
                                    </a>
                                    <a href="{{ route('kepala_sekolah.notifications') }}" class="btn feature-btn pengaturan">
                                        <i class="fas fa-cog me-2"></i>Pengaturan Sistem
                                    </a>
                                </div>
                            </div>
                </div>
            </div>
        </div>

                <!-- Aktivitas Terbaru -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Aktivitas Terbaru</h5>
                            </div>
                            <div class="card-body">
                                @forelse($recentActivities as $activity)
                                <div class="d-flex align-items-center mb-3 p-3 border rounded">
                                    <div class="me-3">
                                        @if($activity->activity_type == 'login')
                                            <i class="fas fa-sign-in-alt text-success"></i>
                                        @elseif($activity->activity_type == 'logout')
                                            <i class="fas fa-sign-out-alt text-danger"></i>
                                        @elseif($activity->activity_type == 'create_materi')
                                            <i class="fas fa-file-alt text-primary"></i>
                                        @elseif($activity->activity_type == 'create_kuis')
                                            <i class="fas fa-question-circle text-warning"></i>
                                        @elseif($activity->activity_type == 'create_rangkuman')
                                            <i class="fas fa-clipboard text-info"></i>
                                        @else
                                            <i class="fas fa-circle text-secondary"></i>
                                        @endif
                        </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1">
                                            <strong>{{ $activity->guru->user->name }}</strong>
                                            {{ $activity->description }}
                                        </p>
                                        <small class="text-muted">{{ $activity->activity_time->diffForHumans() }}</small>
                        </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada aktivitas terbaru</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>