<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tenaga Usaha - TMS NURANI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, #2d5a27 0%, #4a7c59 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 24px;
        }
        
        .nav-link {
            color: white !important;
        }
        
        .nav-link:hover {
            color: #e8f5e8 !important;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, #2d5a27 0%, #4a7c59 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #2d5a27 0%, #4a7c59 100%);
            color: white;
            border-radius: 15px;
        }
        
        .stat-icon {
            font-size: 3rem;
            opacity: 0.8;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2d5a27 0%, #4a7c59 100%);
            border: none;
            border-radius: 10px;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1e3d1a 0%, #3a5c47 100%);
        }
        
        .tu-badge {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-briefcase me-2"></i>TMS NURANI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Keuangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Inventaris</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Laporan</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-tie me-1"></i>{{ Auth::user()->name }}
                            <span class="tu-badge ms-2">TU</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Welcome Card -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-success">
                            <i class="fas fa-briefcase me-2"></i>Selamat Datang, {{ Auth::user()->name }}!
                        </h2>
                        <p class="card-text">Selamat datang di dashboard Tenaga Usaha TMS NURANI. Kelola administrasi sekolah dengan mudah dan efisien.</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="col-md-3 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-money-bill-wave stat-icon"></i>
                        <h3 class="mt-3">Rp 125M</h3>
                        <p class="mb-0">Anggaran Bulan Ini</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-boxes stat-icon"></i>
                        <h3 class="mt-3">450</h3>
                        <p class="mb-0">Item Inventaris</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-file-invoice stat-icon"></i>
                        <h3 class="mt-3">28</h3>
                        <p class="mb-0">Dokumen Pending</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line stat-icon"></i>
                        <h3 class="mt-3">95%</h3>
                        <p class="mb-0">Efisiensi Operasional</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-plus me-2"></i>Input Anggaran
                                </button>
                            </div>
                            <div class="col-6 mb-3">
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-box me-2"></i>Kelola Inventaris
                                </button>
                            </div>
                            <div class="col-6 mb-3">
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-file-alt me-2"></i>Buat Laporan
                                </button>
                            </div>
                            <div class="col-6 mb-3">
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-users me-2"></i>Kelola Staff
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Aktivitas Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Pembayaran SPP Bulan Ini</h6>
                                        <small class="text-muted">2 jam yang lalu</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-upload text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Update Inventaris Lab</h6>
                                        <small class="text-muted">4 jam yang lalu</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-alt text-warning me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Laporan Keuangan Bulanan</h6>
                                        <small class="text-muted">1 hari yang lalu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Overview -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Ringkasan Keuangan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <h4 class="text-success">Rp 45M</h4>
                                <p class="text-muted">Pendapatan</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <h4 class="text-danger">Rp 32M</h4>
                                <p class="text-muted">Pengeluaran</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <h4 class="text-primary">Rp 13M</h4>
                                <p class="text-muted">Saldo</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <h4 class="text-warning">85%</h4>
                                <p class="text-muted">Efisiensi</p>
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
