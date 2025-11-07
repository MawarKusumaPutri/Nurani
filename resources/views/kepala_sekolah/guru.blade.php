<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Guru - Kepala Sekolah</title>
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
        .guru-card {
            border-left: 4px solid #2E7D32;
        }
        .status-online {
            color: #28a745;
        }
        .status-offline {
            color: #dc3545;
        }
        .pagination-custom .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            transition: all 0.3s ease;
        }
        .pagination-custom .btn-primary:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(46, 125, 50, 0.3);
        }
        .pagination-custom .btn-outline-secondary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
                            <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                            Data Guru
                        </h2>
                        <p class="text-muted mb-0">Kelola dan pantau data semua guru</p>
                    </div>
                    <div>
                        <span class="badge bg-primary fs-6">
                            {{ $gurus->total() }} Guru
                        </span>
                    </div>
                </div>

                <!-- Guru List -->
                <div class="row">
                    @if($gurus->count() > 0)
                        @foreach($gurus as $guru)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card guru-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $guru->user->name }}</h6>
                                                <small class="text-muted">{{ $guru->nip }}</small>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted">Mata Pelajaran:</small>
                                            <p class="mb-1">{{ $guru->mata_pelajaran }}</p>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Status Login:</small>
                                            <div class="d-flex align-items-center mt-1">
                                                @if($guru->is_online ?? false)
                                                    <span class="badge bg-success me-2">
                                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>Aktif
                                                    </span>
                                                    @if($guru->last_login_time)
                                                        <small class="text-muted status-time" data-time="{{ $guru->last_login_time }}">
                                                            Login: {{ \Carbon\Carbon::parse($guru->last_login_time)->format('H:i') }}
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary me-2">
                                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>Offline
                                                    </span>
                                                    @if($guru->last_login_time)
                                                        <small class="text-muted status-time" data-time="{{ $guru->last_login_time }}">
                                                            Terakhir: {{ \Carbon\Carbon::parse($guru->last_login_time)->diffForHumans() }}
                                                        </small>
                                                    @else
                                                        <small class="text-muted">Belum pernah login</small>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Status Presensi Hari Ini:</small>
                                            <div class="d-flex align-items-center mt-1">
                                                @if($guru->presensi_status)
                                                    @php
                                                        $presensiStatus = $guru->presensi_status;
                                                    @endphp
                                                    @if($presensiStatus['jenis'] === 'hadir')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle me-1"></i>Hadir
                                                        </span>
                                                    @elseif($presensiStatus['jenis'] === 'izin')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-file-alt me-1"></i>Izin
                                                            @if($presensiStatus['keterangan'])
                                                                <small class="d-block mt-1">{{ Str::limit($presensiStatus['keterangan'], 30) }}</small>
                                                            @endif
                                                        </span>
                                                    @elseif($presensiStatus['jenis'] === 'sakit')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-user-injured me-1"></i>Sakit
                                                            @if($presensiStatus['keterangan'])
                                                                <small class="d-block mt-1">{{ Str::limit($presensiStatus['keterangan'], 30) }}</small>
                                                            @endif
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-clock me-1"></i>Belum Presensi
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('kepala_sekolah.guru.activity', $guru->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i> Lihat Aktivitas
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mt-4 pagination-custom">
                                <div class="text-muted small">
                                    Menampilkan {{ $gurus->firstItem() ?? 0 }} sampai {{ $gurus->lastItem() ?? 0 }} dari {{ $gurus->total() }} guru
                                </div>
                                <div class="d-flex">
                                    @if($gurus->onFirstPage())
                                        <button class="btn btn-outline-secondary btn-sm me-2" disabled>
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </button>
                                    @else
                                        <a href="{{ $gurus->previousPageUrl() }}" class="btn btn-primary btn-sm me-2">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </a>
                                    @endif
                                    
                                    @if($gurus->hasMorePages())
                                        <a href="{{ $gurus->nextPageUrl() }}" class="btn btn-primary btn-sm">
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data guru</h5>
                                <p class="text-muted">Data guru akan muncul di sini setelah guru terdaftar</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update time display setiap menit tanpa reload
        setInterval(function() {
            document.querySelectorAll('.status-time').forEach(function(el) {
                if (el.dataset.time) {
                    const time = new Date(el.dataset.time);
                    const now = new Date();
                    const diffMs = now - time;
                    const diffMins = Math.floor(diffMs / 60000);
                    
                    if (diffMins < 30) {
                        // Masih online
                        const timeStr = time.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
                        el.textContent = 'Login: ' + timeStr;
                    } else {
                        // Sudah offline
                        el.textContent = 'Terakhir: ' + getTimeAgo(time);
                    }
                }
            });
        }, 60000); // Setiap 1 menit

        function getTimeAgo(date) {
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);

            if (diffMins < 1) return 'Baru saja';
            if (diffMins < 60) return diffMins + ' menit yang lalu';
            if (diffHours < 24) return diffHours + ' jam yang lalu';
            return diffDays + ' hari yang lalu';
        }

        // Auto-refresh status login setiap 60 detik (optional, bisa diaktifkan jika diperlukan)
        // setInterval(function() {
        //     location.reload();
        // }, 60000);
    </script>
</body>
</html>
