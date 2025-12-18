<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wali Kelas - TMS NURANI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @include('partials.guru-dynamic-ui')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .feature-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 12px;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
        }
    </style>
</head>
<body>
    @if($role === 'guru')
        @include('partials.guru-sidebar')
    @elseif($role === 'kepala_sekolah')
        @include('partials.kepala-sekolah-sidebar')
    @elseif($role === 'tu')
        @include('partials.tu-sidebar')
    @endif

    <div class="container-fluid p-4" style="margin-left: 0;">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                    Wali Kelas
                </h2>
                <p class="text-muted mb-4">Kelola rencana, monitoring, dan laporan kegiatan wali kelas</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-primary text-white">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <h4 class="card-title">Rencana Kegiatan</h4>
                        <p class="card-text text-muted">Buat dan kelola rencana kegiatan wali kelas</p>
                        <a href="{{ $role === 'guru' ? route('guru.wali-kelas.rencana') : ($role === 'kepala_sekolah' ? route('kepala_sekolah.wali-kelas.rencana') : route('tu.wali-kelas.rencana')) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-right me-2"></i>Masuk
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-success text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="card-title">Monitoring Pelaksanaan</h4>
                        <p class="card-text text-muted">Pantau pelaksanaan kegiatan wali kelas</p>
                        <a href="{{ $role === 'guru' ? route('guru.wali-kelas.monitoring') : ($role === 'kepala_sekolah' ? route('kepala_sekolah.wali-kelas.monitoring') : route('tu.wali-kelas.monitoring')) }}" class="btn btn-success">
                            <i class="fas fa-arrow-right me-2"></i>Masuk
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-info text-white">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h4 class="card-title">Laporan Kegiatan</h4>
                        <p class="card-text text-muted">Lihat dan kelola laporan hasil kegiatan</p>
                        <a href="{{ $role === 'guru' ? route('guru.wali-kelas.laporan') : ($role === 'kepala_sekolah' ? route('kepala_sekolah.wali-kelas.laporan') : route('tu.wali-kelas.laporan')) }}" class="btn btn-info">
                            <i class="fas fa-arrow-right me-2"></i>Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

