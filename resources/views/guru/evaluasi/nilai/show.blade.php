@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Nilai Harian - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        body {
            overflow-x: hidden;
        }
        
        .container-fluid {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        .row {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        .col-md-9, .col-lg-10 {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        /* Layout CSS - DISABLED - Menggunakan CSS Global dari guru-fixed-layout.blade.php */
        /*
        /* Layout - sama seperti presensi (biarkan Bootstrap yang mengatur) */
        @media (min-width: 768px) {
            .container-fluid > .row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }
            
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 25% !important;
                width: 25% !important;
                max-width: 25% !important;
                min-width: 250px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 75% !important;
                width: 75% !important;
            }
        }
        
        @media (min-width: 992px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 16.66666667% !important;
                width: 16.66666667% !important;
                max-width: 16.66666667% !important;
                min-width: 200px !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 83.33333333% !important;
                width: 83.33333333% !important;
            }
        }
        
        .col-md-9.col-lg-10 {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1 !important;
            min-height: 100vh !important;
            padding: 1rem 1.5rem !important;
            background-color: #ffffff !important;
            box-sizing: border-box !important;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            width: auto !important;
            left: 0 !important;
            transform: translateX(0) !important;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            background-color: #ffffff !important;
        }
        
        .card-header {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        
        .info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.25rem;
        }
        
        .info-value {
            color: #212529;
        }
        
        .badge-custom {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
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
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .col-md-9.col-lg-10 {
                width: 100% !important;
                margin-left: 0 !important;
                    }
        }
        */
    </style>
    @include('partials.guru-fixed-layout')
    @include('partials.guru-dynamic-ui')
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid" style="background-color: #ffffff !important; background: #ffffff !important;">
        <div class="row" style="background-color: #ffffff !important; background: #ffffff !important;">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4" style="background-color: #ffffff !important; background: #ffffff !important;">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="mb-2">
                        <i class="fas fa-eye me-2 text-info"></i>
                        Detail Nilai Harian
                    </h2>
                    <p class="text-muted mb-3">Lihat detail lengkap nilai harian, UTS, dan UAS siswa</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('guru.evaluasi.nilai.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route('guru.evaluasi.nilai.edit', $nilai->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 col-lg-8">
                        <!-- Informasi Siswa -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Siswa</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <div class="info-label">Nama Siswa</div>
                                    <div class="info-value">{{ $nilai->siswa->nama ?? 'N/A' }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Mata Pelajaran</div>
                                    <div class="info-value">{{ $nilai->mata_pelajaran }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Kelas</div>
                                    <div class="info-value">Kelas {{ $nilai->kelas }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Semester</div>
                                    <div class="info-value">{{ $nilai->semester }}</div>
                                </div>
                                @if($nilai->tahun_pelajaran)
                                <div class="info-item">
                                    <div class="info-label">Tahun Pelajaran</div>
                                    <div class="info-value">{{ $nilai->tahun_pelajaran }}</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Nilai Harian -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Nilai Harian</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="info-label">Nilai Harian 1</div>
                                        <div class="info-value">
                                            @if($nilai->formatif_1)
                                                <span class="badge bg-info badge-custom">{{ number_format($nilai->formatif_1, 2) }}</span>
                                                @if($nilai->tanggal_nilai_harian)
                                                    <small class="text-muted d-block mt-1">{{ \Carbon\Carbon::parse($nilai->tanggal_nilai_harian)->format('d/m/Y') }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-label">Nilai Harian 2</div>
                                        <div class="info-value">
                                            @if($nilai->formatif_2)
                                                <span class="badge bg-info badge-custom">{{ number_format($nilai->formatif_2, 2) }}</span>
                                                @if($nilai->tanggal_nilai_harian_2)
                                                    <small class="text-muted d-block mt-1">{{ \Carbon\Carbon::parse($nilai->tanggal_nilai_harian_2)->format('d/m/Y') }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-label">Nilai Harian 3</div>
                                        <div class="info-value">
                                            @if($nilai->formatif_3)
                                                <span class="badge bg-info badge-custom">{{ number_format($nilai->formatif_3, 2) }}</span>
                                                @if($nilai->tanggal_nilai_harian_3)
                                                    <small class="text-muted d-block mt-1">{{ \Carbon\Carbon::parse($nilai->tanggal_nilai_harian_3)->format('d/m/Y') }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-label">Nilai Harian 4</div>
                                        <div class="info-value">
                                            @if($nilai->formatif_4)
                                                <span class="badge bg-info badge-custom">{{ number_format($nilai->formatif_4, 2) }}</span>
                                                @if($nilai->tanggal_nilai_harian_4)
                                                    <small class="text-muted d-block mt-1">{{ \Carbon\Carbon::parse($nilai->tanggal_nilai_harian_4)->format('d/m/Y') }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($nilai->rata_formatif)
                                <div class="info-item mt-3 pt-3 border-top">
                                    <div class="info-label">Rata-rata Nilai Harian</div>
                                    <div class="info-value">
                                        <span class="badge bg-primary badge-custom">{{ number_format($nilai->rata_formatif, 2) }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Nilai UTS & UAS -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Nilai UTS & UAS</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="info-label">Nilai UTS</div>
                                        <div class="info-value">
                                            @if($nilai->sumatif_uts)
                                                <span class="badge bg-warning badge-custom">{{ number_format($nilai->sumatif_uts, 2) }}</span>
                                                @if($nilai->tanggal_uts)
                                                    <small class="text-muted d-block mt-1">{{ \Carbon\Carbon::parse($nilai->tanggal_uts)->format('d/m/Y') }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-label">Nilai UAS</div>
                                        <div class="info-value">
                                            @if($nilai->sumatif_uas)
                                                <span class="badge bg-warning badge-custom">{{ number_format($nilai->sumatif_uas, 2) }}</span>
                                                @if($nilai->tanggal_uas)
                                                    <small class="text-muted d-block mt-1">{{ \Carbon\Carbon::parse($nilai->tanggal_uas)->format('d/m/Y') }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($nilai->rata_sumatif)
                                <div class="info-item mt-3 pt-3 border-top">
                                    <div class="info-label">Rata-rata UTS/UAS</div>
                                    <div class="info-value">
                                        <span class="badge bg-warning badge-custom">{{ number_format($nilai->rata_sumatif, 2) }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Nilai Akhir -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Nilai Akhir & Predikat</h5>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <div class="info-label">Nilai Akhir</div>
                                    <div class="info-value">
                                        @if($nilai->nilai_akhir)
                                            <span class="badge bg-primary badge-custom" style="font-size: 1.2rem; padding: 0.75rem 1.5rem;">{{ number_format($nilai->nilai_akhir, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Predikat</div>
                                    <div class="info-value">
                                        @if($nilai->predikat)
                                            <span class="badge bg-success badge-custom" style="font-size: 1.2rem; padding: 0.75rem 1.5rem;">{{ $nilai->predikat }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </div>
                                @if($nilai->keterangan)
                                <div class="info-item">
                                    <div class="info-label">Keterangan</div>
                                    <div class="info-value">{{ $nilai->keterangan }}</div>
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
            const sidebar = document.getElementById('guru-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
            if (overlay) {
                overlay.classList.toggle('show');
            }
        }
    </script>
</body>
</html>
