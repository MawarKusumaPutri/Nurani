@php
    $layout = match($role) {
        'tu' => 'layouts.tu',
        'guru' => 'layouts.guru',
        default => null
    };
@endphp

@if($layout)
    @extends($layout)
    @section('title', 'Kegiatan Kesiswaan - ' . ucfirst($role) . ' Dashboard')
    @section('content')
    <div class="container-fluid">
        <div class="row">
            @if($role === 'tu')
                @include('partials.tu-sidebar')
            @elseif($role === 'guru')
                @include('partials.guru-sidebar')
            @endif
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-users me-2"></i>Kegiatan Kesiswaan
                    </h1>
                </div>
                <p class="text-muted mb-4">Kelola rencana, monitoring, dan laporan kegiatan kesiswaan</p>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon bg-primary text-white rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <h4 class="card-title">Rencana Kegiatan</h4>
                                <p class="card-text text-muted">Buat dan kelola rencana kegiatan kesiswaan</p>
                                <a href="{{ $role === 'tu' ? route('tu.kegiatan-kesiswaan.rencana.index') : ($role === 'guru' ? route('guru.kegiatan-kesiswaan.rencana.index') : route('kepala_sekolah.kegiatan-kesiswaan.rencana.index')) }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-right me-2"></i>Masuk
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4 class="card-title">Monitoring Pelaksanaan</h4>
                                <p class="card-text text-muted">Pantau pelaksanaan kegiatan kesiswaan</p>
                                <a href="{{ $role === 'tu' ? route('tu.kegiatan-kesiswaan.monitoring.index') : ($role === 'guru' ? route('guru.kegiatan-kesiswaan.monitoring.index') : route('kepala_sekolah.kegiatan-kesiswaan.monitoring.index')) }}" class="btn btn-success">
                                    <i class="fas fa-arrow-right me-2"></i>Masuk
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon bg-info text-white rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h4 class="card-title">Laporan Kegiatan</h4>
                                <p class="card-text text-muted">Lihat dan kelola laporan hasil kegiatan</p>
                                <a href="{{ $role === 'tu' ? route('tu.kegiatan-kesiswaan.laporan.index') : ($role === 'guru' ? route('guru.kegiatan-kesiswaan.laporan.index') : route('kepala_sekolah.kegiatan-kesiswaan.laporan.index')) }}" class="btn btn-info">
                                    <i class="fas fa-arrow-right me-2"></i>Masuk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @endsection
@else
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kegiatan Kesiswaan - Kepala Sekolah Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
            .sidebar { min-height: 100vh; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); }
            .sidebar .nav-link { color: rgba(255, 255, 255, 0.8); padding: 12px 20px; border-radius: 8px; margin: 4px 0; transition: all 0.3s ease; }
            .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background: rgba(255, 255, 255, 0.1); transform: translateX(5px); }
            .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); transition: transform 0.3s ease; }
            .card:hover { transform: translateY(-5px); }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                @include('partials.kepala-sekolah-sidebar')
                <div class="col-md-9 col-lg-10 p-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <i class="fas fa-users me-2"></i>Kegiatan Kesiswaan
                        </h1>
                    </div>
                    <p class="text-muted mb-4">Kelola rencana, monitoring, dan laporan kegiatan kesiswaan</p>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <div class="feature-icon bg-primary text-white rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <h4 class="card-title">Rencana Kegiatan</h4>
                                    <p class="card-text text-muted">Buat dan kelola rencana kegiatan kesiswaan</p>
                                    <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.index') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-2"></i>Masuk
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h4 class="card-title">Monitoring Pelaksanaan</h4>
                                    <p class="card-text text-muted">Pantau pelaksanaan kegiatan kesiswaan</p>
                                    <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.monitoring.index') }}" class="btn btn-success">
                                        <i class="fas fa-arrow-right me-2"></i>Masuk
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <div class="feature-icon bg-info text-white rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <h4 class="card-title">Laporan Kegiatan</h4>
                                    <p class="card-text text-muted">Lihat dan kelola laporan hasil kegiatan</p>
                                    <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.laporan.index') }}" class="btn btn-info">
                                        <i class="fas fa-arrow-right me-2"></i>Masuk
                                    </a>
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
@endif
