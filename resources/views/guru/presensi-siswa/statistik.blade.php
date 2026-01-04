<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Presensi Siswa - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            min-height: 100vh;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .chart-container {
            position: relative;
            height: 350px;
            margin: 1.5rem 0;
        }

        .kelas-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .kelas-7 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .kelas-8 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .kelas-9 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-label {
            font-weight: 500;
            color: #666;
        }

        .stat-value {
            font-weight: 700;
            font-size: 1.2rem;
            color: #2E7D32;
        }

        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
        }

        .page-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .page-header h2 {
            color: #2E7D32;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            margin-right: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .chart-container {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>
                                <i class="fas fa-chart-pie me-2"></i>
                                Statistik Presensi Siswa
                            </h2>
                            <p class="text-muted mb-0">Grafik aktivitas siswa per kelas berdasarkan presensi</p>
                        </div>
                        <a href="{{ route('guru.presensi-siswa.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Filter Card -->
                <div class="filter-card">
                    <form method="GET" action="{{ route('guru.presensi-siswa.statistik') }}">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Tanggal Mulai
                                </label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ $startDate }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Tanggal Akhir
                                </label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ $endDate }}" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i>
                                    Filter Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                    @foreach(['7', '8', '9'] as $kelas)
                    @php
                        $stats = $statistikPerKelas[$kelas];
                        $kelasClass = 'kelas-' . $kelas;
                    @endphp
                    <div class="col-lg-4 mb-4">
                        <div class="stats-card">
                            <div class="text-center">
                                <span class="kelas-badge {{ $kelasClass }}">
                                    <i class="fas fa-users me-2"></i>
                                    Kelas {{ $kelas }}
                                </span>
                            </div>

                            <!-- Pie Chart for Aktivitas -->
                            <h5 class="text-center mt-3 mb-3 fw-bold">Aktivitas Siswa di Kelas</h5>
                            <div class="chart-container">
                                <canvas id="chartKelas{{ $kelas }}"></canvas>
                            </div>

                            <!-- Legend -->
                            <div class="text-center mb-3">
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #4CAF50;"></div>
                                    <span>Aktif di Kelas</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #FF5252;"></div>
                                    <span>Tidak Aktif di Kelas</span>
                                </div>
                            </div>

                            <!-- Statistics Details -->
                            <div class="mt-4">
                                <div class="stat-item">
                                    <span class="stat-label">
                                        <i class="fas fa-user-graduate me-2"></i>
                                        Total Siswa
                                    </span>
                                    <span class="stat-value">{{ $stats['total_siswa'] }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">
                                        <i class="fas fa-clipboard-check me-2"></i>
                                        Total Presensi
                                    </span>
                                    <span class="stat-value">{{ $stats['total_presensi'] }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">
                                        <i class="fas fa-check-circle me-2 text-success"></i>
                                        Aktif di Kelas
                                    </span>
                                    <span class="stat-value text-success">{{ $stats['aktivitas']['aktif'] }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">
                                        <i class="fas fa-times-circle me-2 text-danger"></i>
                                        Tidak Aktif
                                    </span>
                                    <span class="stat-value text-danger">{{ $stats['aktivitas']['tidak_aktif'] }}</span>
                                </div>

                            </div>

                            <!-- Status Presensi Summary -->
                            <div class="mt-4 pt-3 border-top">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Ringkasan Status Presensi
                                </h6>
                                <div class="row text-center">
                                    <div class="col-6 mb-2">
                                        <div class="p-2 rounded" style="background: #E8F5E9;">
                                            <small class="text-muted d-block">Hadir</small>
                                            <strong class="text-success">{{ $stats['status']['hadir'] }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-2 rounded" style="background: #FFF3E0;">
                                            <small class="text-muted d-block">Sakit</small>
                                            <strong class="text-warning">{{ $stats['status']['sakit'] }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-2 rounded" style="background: #E3F2FD;">
                                            <small class="text-muted d-block">Izin</small>
                                            <strong class="text-info">{{ $stats['status']['izin'] }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-2 rounded" style="background: #FFEBEE;">
                                            <small class="text-muted d-block">Alfa</small>
                                            <strong class="text-danger">{{ $stats['status']['alfa'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart configuration
        const chartConfig = {
            type: 'doughnut',
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '65%',
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeInOutQuart'
                }
            }
        };

        // Create charts for each class
        @foreach(['7', '8', '9'] as $kelas)
        @php
            $stats = $statistikPerKelas[$kelas];
        @endphp
        new Chart(document.getElementById('chartKelas{{ $kelas }}'), {
            ...chartConfig,
            data: {
                labels: ['Aktif di Kelas', 'Tidak Aktif di Kelas'],
                datasets: [{
                    data: [
                        {{ $stats['aktivitas']['aktif'] }},
                        {{ $stats['aktivitas']['tidak_aktif'] }}
                    ],
                    backgroundColor: [
                        '#4CAF50',  // Green for active
                        '#FF5252'   // Red for inactive
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 15,
                    hoverBorderWidth: 4
                }]
            }
        });
        @endforeach
    </script>
</body>
</html>
