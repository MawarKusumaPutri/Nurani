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
            
            /* Tambahkan margin untuk header agar tidak tertutup hamburger menu dan simetris */
            .header-laporan {
                margin-left: 60px !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-right: 0 !important;
            }
            
            .header-laporan h2 {
                font-size: 1.5rem;
                line-height: 1.3;
            }
            
            .header-laporan .text-muted {
                font-size: 0.95rem;
                margin-bottom: 0.25rem;
            }
            
            .header-laporan .text-muted.small {
                font-size: 0.85rem;
                color: #6c757d;
            }
            
            /* Card statistik simetris */
            .stats-row-laporan {
                margin-left: 60px !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            /* Card performa guru simetris */
            .performance-row-laporan {
                margin-left: 60px !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }
        
        @media (max-width: 768px) {
            .stat-number {
                font-size: 2rem;
            }
            
            .col-md-3 {
                margin-bottom: 15px;
            }
            
            .card-body {
                padding: 1rem;
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
            @include('partials.kepala-sekolah-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 header-laporan">
                    <div>
                        <h2 class="mb-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
                        <p class="text-muted">Laporan Sistem Kepala Sekolah MTs Nurul Aiman</p>
                        <p class="text-muted small">Statistik dan laporan lengkap sistem pembelajaran</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="badge bg-primary px-3 py-2">Kepala Sekolah</span>
                        </div>
                        <div>
                            <button class="btn btn-primary">
                                <i class="fas fa-download me-2"></i> Export PDF
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4 stats-row-laporan">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-chalkboard-teacher fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalGuru }}</div>
                                <p class="mb-0">Total Guru</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-book fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalMateri }}</div>
                                <p class="mb-0">Total Materi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-question-circle fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalKuis }}</div>
                                <p class="mb-0">Total Kuis</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-clipboard-list fa-2x mb-3"></i>
                                <div class="stat-number">{{ $totalRangkuman }}</div>
                                <p class="mb-0">Total Rangkuman</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guru Performance -->
                <div class="row performance-row-laporan">
                    <div class="col-12">
                        <div class="card content-card">
                            <div class="card-header">
                                <h5 class="mb-0">Performa Guru</h5>
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
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
            if (overlay) {
                overlay.classList.toggle('show');
            }
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (window.innerWidth <= 991) {
                if (sidebar && !sidebar.contains(event.target) && 
                    toggleBtn && !toggleBtn.contains(event.target) && 
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    if (overlay) overlay.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>
