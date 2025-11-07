<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Sekolah - {{ Auth::user()->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
        .chart-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.05);
            position: relative;
        }
        .chart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            border-radius: 15px;
            pointer-events: none;
        }
        #presensiPieChart {
            filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.1));
            animation: fadeInScale 0.8s ease-out;
            position: relative;
            z-index: 1;
        }
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('partials.kepala-sekolah-sidebar')

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
                    <div class="col-12 mb-4">
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
                                    // Prioritaskan guru yang sudah presensi (sakit, izin, hadir)
                                    // Urutkan: sakit dulu, lalu izin, lalu hadir, lalu belum presensi
                                    $gurusWithPresensi = $gurus->filter(function($guru) use ($guruPresensiStatus) {
                                        return isset($guruPresensiStatus[$guru->id]);
                                    })->sortBy(function($guru) use ($guruPresensiStatus) {
                                        $jenis = $guruPresensiStatus[$guru->id]['jenis'];
                                        if ($jenis === 'sakit') return 1;
                                        if ($jenis === 'izin') return 2;
                                        if ($jenis === 'hadir') return 3;
                                        return 4;
                                    });
                                    $gurusWithoutPresensi = $gurus->filter(function($guru) use ($guruPresensiStatus) {
                                        return !isset($guruPresensiStatus[$guru->id]);
                                    });
                                    // Gabungkan: yang sudah presensi dulu (semua), lalu yang belum presensi (5 pertama)
                                    $displayGurus = $gurusWithPresensi->merge($gurusWithoutPresensi->take(5));
                                @endphp
                                @foreach($displayGurus as $guru)
                                <tr>
                                                <td>{{ $guru->user->name }}</td>
                                                <td>{{ $guru->mata_pelajaran }}</td>
                                                <td>
                                        @if(isset($guruPresensiStatus[$guru->id]))
                                            @php
                                                $presensiStatus = $guruPresensiStatus[$guru->id];
                                            @endphp
                                            @if($presensiStatus['jenis'] === 'hadir')
                                                <span class="badge bg-success">Hadir</span>
                                            @elseif($presensiStatus['jenis'] === 'izin')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-file-alt me-1"></i>Izin
                                                    @if($presensiStatus['keterangan'])
                                                        <small>({{ Str::limit($presensiStatus['keterangan'], 20) }})</small>
                                                    @endif
                                                </span>
                                            @elseif($presensiStatus['jenis'] === 'sakit')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-user-injured me-1"></i>Sakit
                                                    @if($presensiStatus['keterangan'])
                                                        <small>({{ Str::limit($presensiStatus['keterangan'], 20) }})</small>
                                                    @endif
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum Presensi</span>
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
            
            <!-- Kehadiran Hari Ini -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Kehadiran Hari Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Pie Chart -->
                        <div class="col-md-6 mb-4">
                            <div class="chart-container" style="position: relative; height: 280px;">
                                <canvas id="presensiPieChart"></canvas>
                            </div>
                        </div>
                        
                        <!-- Statistics -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-users me-2 text-primary"></i>Total Guru</span>
                                    <span class="fw-bold">{{ $totalGurus }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-check-circle me-2 text-success"></i>Hadir</span>
                                    <span class="fw-bold text-success">{{ $presensiHadir }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-file-alt me-2 text-warning"></i>Izin</span>
                                    <span class="fw-bold text-warning">{{ $presensiIzin }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-user-injured me-2 text-danger"></i>Sakit</span>
                                    <span class="fw-bold text-danger">{{ $presensiSakit }}</span>
                                </div>
                                @if($belumPresensi > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-clock me-2 text-secondary"></i>Belum Presensi</span>
                                    <span class="fw-bold text-secondary">{{ $belumPresensi }}</span>
                                </div>
                                @endif
                            </div>
                            
                            @php
                                $totalPresensi = $presensiHadir + $presensiIzin + $presensiSakit;
                                $persentase = $totalGurus > 0 ? round(($totalPresensi / $totalGurus) * 100) : 0;
                            @endphp
                            <div class="progress mb-2" style="height: 10px; border-radius: 5px;">
                                <div class="progress-bar bg-success" style="width: {{ $persentase }}%" role="progressbar"></div>
                            </div>
                            <p class="text-center mb-0 text-muted">
                                <small>{{ $persentase }}% Guru Sudah Presensi</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
                    </div>
            </div>
        </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pie Chart untuk Presensi Guru
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('presensiPieChart');
            if (ctx) {
                const presensiData = {
                    hadir: {{ $presensiHadir }},
                    izin: {{ $presensiIzin }},
                    sakit: {{ $presensiSakit }},
                    belumPresensi: {{ $belumPresensi }}
                };

                // Create gradient colors
                const createGradient = (ctx, color1, color2) => {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, color1);
                    gradient.addColorStop(1, color2);
                    return gradient;
                };

                const chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            'Hadir',
                            'Izin',
                            'Sakit',
                            @if($belumPresensi > 0)
                            'Belum Presensi'
                            @endif
                        ],
                        datasets: [{
                            label: 'Presensi Guru',
                            data: [
                                presensiData.hadir,
                                presensiData.izin,
                                presensiData.sakit,
                                @if($belumPresensi > 0)
                                presensiData.belumPresensi
                                @endif
                            ],
                            backgroundColor: [
                                'rgba(40, 167, 69, 0.9)',   // Hijau untuk Hadir
                                'rgba(255, 193, 7, 0.9)',   // Kuning untuk Izin
                                'rgba(220, 53, 69, 0.9)',   // Merah untuk Sakit
                                @if($belumPresensi > 0)
                                'rgba(108, 117, 125, 0.9)'  // Abu-abu untuk Belum Presensi
                                @endif
                            ],
                            borderColor: [
                                '#28a745',
                                '#ffc107',
                                '#dc3545',
                                @if($belumPresensi > 0)
                                '#6c757d'
                                @endif
                            ],
                            borderWidth: 4,
                            hoverBorderWidth: 6,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 13,
                                        weight: '600',
                                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    generateLabels: function(chart) {
                                        const data = chart.data;
                                        if (data.labels.length && data.datasets.length) {
                                            const dataset = data.datasets[0];
                                            return data.labels.map((label, i) => {
                                                const value = dataset.data[i];
                                                const total = dataset.data.reduce((a, b) => a + b, 0);
                                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                                return {
                                                    text: `${label}: ${value} (${percentage}%)`,
                                                    fillStyle: dataset.backgroundColor[i],
                                                    strokeStyle: dataset.borderColor[i],
                                                    lineWidth: dataset.borderWidth,
                                                    hidden: isNaN(value) || value === 0,
                                                    index: i
                                                };
                                            });
                                        }
                                        return [];
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 15,
                                titleFont: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 14
                                },
                                borderColor: 'rgba(255, 255, 255, 0.1)',
                                borderWidth: 1,
                                cornerRadius: 10,
                                displayColors: true,
                                callbacks: {
                                    title: function(context) {
                                        return context[0].label;
                                    },
                                    label: function(context) {
                                        const total = {{ $totalGurus }};
                                        const value = context.parsed;
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return [
                                            `Jumlah: ${value} guru`,
                                            `Persentase: ${percentage}%`
                                        ];
                                    },
                                    afterLabel: function(context) {
                                        const total = {{ $totalGurus }};
                                        return `Total: ${total} guru`;
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        onHover: (event, activeElements) => {
                            ctx.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>