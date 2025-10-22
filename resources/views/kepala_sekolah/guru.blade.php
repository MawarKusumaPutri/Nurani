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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            border-left: 4px solid #667eea;
        }
        .status-online {
            color: #28a745;
        }
        .status-offline {
            color: #dc3545;
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
                        Kepala Sekolah
                    </h4>
                    <div class="text-center mb-4">
                        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user-tie fa-2x text-primary"></i>
                        </div>
                        <h6 class="text-white mt-2 mb-1">{{ Auth::user()->name }}</h6>
                        <small class="text-white-50">Kepala Sekolah</small>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('kepala_sekolah.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('kepala_sekolah.notifications') }}">
                        <i class="fas fa-bell me-2"></i> Notifikasi
                    </a>
                    <a class="nav-link active" href="{{ route('kepala_sekolah.guru') }}">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Data Guru
                    </a>
                    <a class="nav-link" href="{{ route('kepala_sekolah.laporan') }}">
                        <i class="fas fa-chart-bar me-2"></i> Laporan
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
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted">Status:</small>
                                                <span class="badge bg-{{ $guru->status === 'aktif' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($guru->status) }}
                                                </span>
                                            </div>
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
                            <div class="d-flex justify-content-center mt-4">
                                {{ $gurus->links() }}
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
</body>
</html>
