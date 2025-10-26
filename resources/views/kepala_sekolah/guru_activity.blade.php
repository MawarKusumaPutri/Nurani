<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aktivitas {{ $guru->user->name }} - Kepala Sekolah</title>
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
        .activity-item {
            border-left: 4px solid #2E7D32;
            transition: all 0.3s ease;
        }
        .activity-item:hover {
            transform: translateX(5px);
        }
        .activity-login {
            border-left-color: #28a745;
        }
        .activity-logout {
            border-left-color: #dc3545;
        }
        .activity-materi {
            border-left-color: #007bff;
        }
        .activity-kuis {
            border-left-color: #ffc107;
        }
        .activity-rangkuman {
            border-left-color: #6f42c1;
        }
        .guru-profile {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                        Kepala Sekolah
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
                    <a class="nav-link" href="{{ route('kepala_sekolah.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('kepala_sekolah.notifications') }}">
                        <i class="fas fa-bell me-2"></i> Notifikasi
                    </a>
                    <a class="nav-link" href="{{ route('kepala_sekolah.guru') }}">
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
                            <i class="fas fa-chart-line me-2 text-primary"></i>
                            Aktivitas Guru
                        </h2>
                        <p class="text-muted mb-0">Pantau aktivitas pembelajaran {{ $guru->user->name }}</p>
                    </div>
                    <div>
                        <a href="{{ route('kepala_sekolah.guru') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Data Guru
                        </a>
                    </div>
                </div>

                <!-- Guru Profile -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card guru-profile">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fas fa-user fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <h4 class="mb-1">{{ $guru->user->name }}</h4>
                                        <p class="mb-1"><strong>NIP:</strong> {{ $guru->nip }}</p>
                                        <p class="mb-1"><strong>Mata Pelajaran:</strong> {{ $guru->mata_pelajaran }}</p>
                                        <p class="mb-0"><strong>Status:</strong> 
                                            <span class="badge bg-{{ $guru->status === 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($guru->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activities List -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-history me-2"></i>
                                    Riwayat Aktivitas
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($activities->count() > 0)
                                    @foreach($activities as $activity)
                                        <div class="card activity-item mb-3 activity-{{ $activity->activity_type }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-{{ $activity->activity_type === 'login' ? 'sign-in-alt' : ($activity->activity_type === 'logout' ? 'sign-out-alt' : ($activity->activity_type === 'create_materi' ? 'book' : ($activity->activity_type === 'create_kuis' ? 'question-circle' : 'clipboard-list'))) }} 
                                                               me-2 text-primary"></i>
                                                            <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</h6>
                                                            <span class="badge bg-{{ $activity->activity_type === 'login' ? 'success' : ($activity->activity_type === 'logout' ? 'danger' : 'primary') }} ms-2">
                                                                {{ $activity->activity_type === 'login' ? 'Login' : ($activity->activity_type === 'logout' ? 'Logout' : 'Aktivitas') }}
                                                            </span>
                                                        </div>
                                                        <p class="text-muted mb-2">{{ $activity->description }}</p>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-clock me-1"></i>
                                                                    {{ $activity->activity_time->format('d M Y, H:i') }}
                                                                </small>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-globe me-1"></i>
                                                                    {{ $activity->ip_address }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                        @if($activity->metadata)
                                                            <div class="mt-2">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-info-circle me-1"></i>
                                                                    Metadata: {{ json_encode($activity->metadata) }}
                                                                </small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $activities->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada aktivitas</h5>
                                        <p class="text-muted">Aktivitas guru akan muncul di sini setelah guru melakukan aktivitas</p>
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
