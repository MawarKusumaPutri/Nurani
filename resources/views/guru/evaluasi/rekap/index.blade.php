@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Hasil Belajar - {{ $guru->user->name }}</title>
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
        
        /* Layout - sama seperti presensi (biarkan Bootstrap yang mengatur) */
        /* Pastikan di desktop, konten di samping sidebar - ULTRA VISIBLE */
        @media (min-width: 768px) {
            .container-fluid > .row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }
            
            /* Pastikan sidebar menggunakan ukuran Bootstrap default - Medium screen - ULTRA VISIBLE */
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 25% !important;
                width: 25% !important; /* col-md-3 = 25% */
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
                width: 75% !important; /* col-md-9 = 75% */
            }
        }
        
        /* Large screen - sidebar lebih kecil - ULTRA VISIBLE */
        @media (min-width: 992px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 16.66666667% !important;
                width: 16.66666667% !important; /* col-lg-2 = 16.67% */
                max-width: 16.66666667% !important;
                min-width: 200px !important;
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
                flex: 0 0 83.33333333% !important;
                width: 83.33333333% !important; /* col-lg-10 = 83.33% */
            }
        }
        
        /* Main content - di samping sidebar (kanan) */
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
        
        /* Pastikan sidebar tidak memaksa konten ke bawah di desktop */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar {
                position: relative !important;
                float: none !important;
            }
        }
        
        /* Ensure sidebar content is scrollable - ULTRA VISIBLE */
        #guru-sidebar {
            display: flex !important;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            left: 0 !important;
            transform: translateX(0) !important;
            z-index: 1000 !important;
            width: 100% !important;
        }
        
        /* PASTIKAN SIDEBAR TIDAK TERSEMBUNYI - ULTRA AGGRESSIVE */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
        
        /* Pastikan konten tidak tersembunyi */
        .col-md-9.col-lg-10 > * {
            display: block !important;
            visibility: visible !important;
        }
        
        .col-md-9.col-lg-10 h2,
        .col-md-9.col-lg-10 .row,
        .col-md-9.col-lg-10 .card,
        .col-md-9.col-lg-10 .alert {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
            background-color: #ffffff !important;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 0.375rem;
        }
        
        .p-4 {
            background-color: #ffffff !important;
            background: #ffffff !important;
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
            
            .col-md-3.col-lg-2.sidebar {
                width: 100% !important;
            }
        }
        
        /* OVERRIDE MOBILE CSS UNTUK DESKTOP - ULTRA AGGRESSIVE */
        @media (min-width: 768px) {
            .sidebar.col-md-3.col-lg-2,
            #guru-sidebar.col-md-3.col-lg-2,
            .col-md-3.col-lg-2#guru-sidebar,
            .col-md-3.col-lg-2.sidebar#guru-sidebar {
                position: relative !important;
                left: 0 !important;
                top: auto !important;
                transform: translateX(0) !important;
                transition: none !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        }
    </style>
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
                    <h2 class="mb-2">Rekap Hasil Belajar</h2>
                    <p class="text-muted mb-3">Lihat rekap hasil belajar siswa secara keseluruhan</p>
                    <a href="{{ route('guru.evaluasi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                @if(!$tableExists)
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i>Tabel Rekap Hasil Belajar Belum Ada</h5>
                        <p class="mb-3">Klik tombol di bawah untuk membuat tabel secara otomatis:</p>
                        <div class="d-flex gap-2 flex-wrap mb-3">
                            <a href="http://localhost/nurani/public/BUAT_EVALUASI_NOW.php" class="btn btn-success btn-lg" onclick="this.innerHTML='<i class=\'fas fa-spinner fa-spin me-2\'></i>Membuat tabel...'; setTimeout(function(){ window.location.reload(); }, 2000);">
                                <i class="fas fa-magic me-2"></i>🚀 Buat Tabel Sekarang (OTOMATIS)
                            </a>
                            <a href="http://localhost/nurani/public/CREATE_EVALUASI_TABLES.php" target="_blank" class="btn btn-primary btn-lg">
                                <i class="fas fa-bolt me-2"></i>⚡ Buat via Browser (Detail)
                            </a>
                        </div>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Setelah klik tombol di atas, refresh halaman ini (Ctrl+F5)
                        </p>
                    </div>
                @else
                    <!-- Generate Rekap Form -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-calculator me-2"></i>Generate Rekap Hasil Belajar
                            </h5>
                            <form action="{{ route('guru.evaluasi.rekap.generate') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kelas" name="kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach($kelasList as $kelas)
                                                <option value="{{ $kelas }}">Kelas {{ $kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                        <select class="form-select" id="semester" name="semester" required>
                                            <option value="">Pilih Semester</option>
                                            <option value="Ganjil">Ganjil</option>
                                            <option value="Genap">Genap</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                                        <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" placeholder="2024/2025">
                                    </div>
                                    <div class="col-md-3 mb-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-sync me-2"></i>Generate
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <a href="{{ route('guru.evaluasi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('guru.evaluasi.rekap.index') }}" class="d-flex gap-2">
                                <select name="kelas" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelasList as $kelas)
                                        <option value="{{ $kelas }}" {{ $selectedKelas == $kelas ? 'selected' : '' }}>Kelas {{ $kelas }}</option>
                                    @endforeach
                                </select>
                                <select name="semester" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Semester</option>
                                    <option value="Ganjil" {{ $selectedSemester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ $selectedSemester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                <select name="siswa" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Siswa</option>
                                    @foreach($siswaList as $siswa)
                                        <option value="{{ $siswa->id }}" {{ $selectedSiswa == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>

                    @if($rekap->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Semester</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Nilai Formatif</th>
                                        <th>Nilai Sumatif</th>
                                        <th>Nilai Akhir</th>
                                        <th>Predikat</th>
                                        <th>Rata-rata Semua Mapel</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekap as $item)
                                        <tr>
                                            <td>{{ $item->siswa->nama ?? 'N/A' }}</td>
                                            <td>Kelas {{ $item->kelas }}</td>
                                            <td>{{ $item->semester }}</td>
                                            <td>{{ $item->mata_pelajaran }}</td>
                                            <td>
                                                @if($item->nilai_formatif)
                                                    <span class="badge bg-info">{{ number_format($item->nilai_formatif, 2) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->nilai_sumatif)
                                                    <span class="badge bg-warning">{{ number_format($item->nilai_sumatif, 2) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->nilai_akhir)
                                                    <span class="badge bg-primary">{{ number_format($item->nilai_akhir, 2) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->predikat)
                                                    <span class="badge bg-success">{{ $item->predikat }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->rata_rata_semua_mapel)
                                                    <span class="badge bg-secondary">{{ number_format($item->rata_rata_semua_mapel, 2) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('guru.evaluasi.rekap.show', $item->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $rekap->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Belum ada rekap hasil belajar. Gunakan form "Generate Rekap Hasil Belajar" di atas untuk membuat rekap dari nilai formatif & sumatif.
                        </div>
                    @endif
                @endif
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
        
        // Force white background
        function forceWhiteBackground() {
            const selectors = [
                'html', 'body', '.container-fluid', '.row', 
                '.col-md-9', '.col-lg-10', '.p-4'
            ];
            
            selectors.forEach(function(selector) {
                const elements = document.querySelectorAll(selector);
                elements.forEach(function(el) {
                    if (el && !el.classList.contains('sidebar')) {
                        el.style.setProperty('background-color', '#ffffff', 'important');
                        el.style.setProperty('background', '#ffffff', 'important');
                    }
                });
            });
        }
        
        forceWhiteBackground();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', forceWhiteBackground);
        }
        window.addEventListener('load', forceWhiteBackground);
    </script>
</body>
</html>
