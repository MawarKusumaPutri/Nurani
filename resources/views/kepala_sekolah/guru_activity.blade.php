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
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            border-radius: 20px;
        }
        .timeline {
            position: relative;
        }
        .timeline-item {
            position: relative;
        }
        .timeline-icon-wrapper {
            position: relative;
            z-index: 1;
        }
        .timeline-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            position: relative;
        }
        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 24px;
            top: 50px;
            width: 2px;
            height: calc(100% + 1rem);
            background: linear-gradient(to bottom, #e9ecef 0%, transparent 100%);
            z-index: 0;
        }
        .activity-login {
            border-left: 4px solid #28a745;
        }
        .activity-logout {
            border-left: 4px solid #dc3545;
        }
        .activity-create_materi {
            border-left: 4px solid #007bff;
        }
        .activity-create_kuis {
            border-left: 4px solid #ffc107;
        }
        .activity-create_rangkuman {
            border-left: 4px solid #17a2b8;
        }
        .shadow-lg {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
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
                        <div class="card guru-profile shadow-lg">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center">
                                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow" style="width: 100px; height: 100px;">
                                            <i class="fas fa-user fa-3x text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3 class="mb-2 text-white">{{ $guru->user->name }}</h3>
                                                <div class="mb-2">
                                                    <i class="fas fa-id-card me-2"></i>
                                                    <span class="text-white-50">NIP:</span>
                                                    <span class="text-white fw-bold">{{ $guru->nip }}</span>
                                                </div>
                                                <div class="mb-2">
                                                    <i class="fas fa-book me-2"></i>
                                                    <span class="text-white-50">Mata Pelajaran:</span>
                                                    <span class="text-white fw-bold">{{ $guru->mata_pelajaran }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <div class="mb-3">
                                                    <span class="badge bg-white text-primary px-3 py-2 fs-6">
                                                        <i class="fas fa-circle text-success me-2"></i>Aktif
                                                    </span>
                                                </div>
                                                <div class="text-white-50">
                                                    <small>Total Aktivitas: <strong class="text-white">{{ $activities->total() }}</strong></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activities List -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-history me-2 text-primary"></i>
                                        Riwayat Aktivitas
                                    </h5>
                                    <span class="badge bg-primary">{{ $activities->total() }} Aktivitas</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                @if($activities->count() > 0)
                                    <div class="timeline">
                                        @foreach($activities as $activity)
                                            <div class="timeline-item mb-4">
                                                <div class="d-flex">
                                                    <!-- Timeline Icon -->
                                                    <div class="timeline-icon-wrapper me-3">
                                                        @if($activity->activity_type === 'login')
                                                            <div class="timeline-icon bg-success text-white">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                            </div>
                                                        @elseif($activity->activity_type === 'logout')
                                                            <div class="timeline-icon bg-danger text-white">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                            </div>
                                                        @elseif($activity->activity_type === 'create_materi')
                                                            <div class="timeline-icon bg-primary text-white">
                                                                <i class="fas fa-book"></i>
                                                            </div>
                                                        @elseif($activity->activity_type === 'create_kuis')
                                                            <div class="timeline-icon bg-warning text-white">
                                                                <i class="fas fa-question-circle"></i>
                                                            </div>
                                                        @elseif($activity->activity_type === 'create_rangkuman')
                                                            <div class="timeline-icon bg-info text-white">
                                                                <i class="fas fa-clipboard-list"></i>
                                                            </div>
                                                        @else
                                                            <div class="timeline-icon bg-secondary text-white">
                                                                <i class="fas fa-circle"></i>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Timeline Content -->
                                                    <div class="flex-grow-1">
                                                        <div class="card border-0 shadow-sm activity-{{ $activity->activity_type }}">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                    <div class="flex-grow-1">
                                                                        @if($activity->activity_type === 'logout')
                                                                            <h6 class="mb-1 fw-bold">Logout</h6>
                                                                            <p class="text-muted mb-0 small">
                                                                                <i class="fas fa-clock me-1 text-danger"></i>
                                                                                {{ $activity->activity_time->format('d M Y, H:i') }}
                                                                            </p>
                                                                        @elseif(in_array($activity->activity_type, ['create_materi', 'create_kuis', 'create_rangkuman']))
                                                                            @php
                                                                                $mataPelajaran = $activity->mata_pelajaran_mengajar ?? 
                                                                                    ((isset($mataPelajaranList) && !empty($mataPelajaranList)) ? $mataPelajaranList[0] : ($guru->mata_pelajaran ?? 'Mata Pelajaran'));
                                                                            @endphp
                                                                            <h6 class="mb-1 fw-bold">
                                                                                <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                                                                                Mengajar {{ $mataPelajaran }}
                                                                            </h6>
                                                                            <p class="mb-0 small">
                                                                                <strong>{{ $guru->user->name }}</strong> habis mengajar 
                                                                                <strong class="text-primary">{{ $mataPelajaran }}</strong> 
                                                                                pada jam <strong>{{ $activity->activity_time->format('H:i') }}</strong>
                                                                            </p>
                                                                            <p class="text-muted mb-0 small mt-1">
                                                                                <i class="fas fa-calendar me-1"></i>
                                                                                {{ $activity->activity_time->format('d M Y') }}
                                                                            </p>
                                                                        @else
                                                                            <h6 class="mb-1 fw-bold">
                                                                                {{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}
                                                                            </h6>
                                                                            <p class="text-muted mb-0 small">{{ $activity->description }}</p>
                                                                            <p class="text-muted mb-0 small mt-1">
                                                                                <i class="fas fa-clock me-1"></i>
                                                                                {{ $activity->activity_time->format('d M Y, H:i') }}
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        @if($activity->activity_type === 'logout')
                                                                            <span class="badge bg-danger rounded-pill">
                                                                                Logout
                                                                            </span>
                                                                        @elseif(in_array($activity->activity_type, ['create_materi', 'create_kuis', 'create_rangkuman']))
                                                                            <span class="badge bg-primary rounded-pill">
                                                                                <i class="fas fa-book me-1"></i>
                                                                                Mengajar
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-{{ $activity->activity_type === 'login' ? 'success' : 'primary' }} rounded-pill">
                                                                                {{ $activity->activity_type === 'login' ? 'Login' : ucfirst(str_replace('_', ' ', $activity->activity_type)) }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $activities->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-history fa-4x text-muted mb-3 opacity-50"></i>
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
