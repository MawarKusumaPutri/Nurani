@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rubrik Penilaian - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        body {
            overflow-x: hidden;
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
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Rubrik Penilaian</h2>
                        <p class="text-muted mb-0">Kelola rubrik penilaian untuk berbagai aspek pembelajaran</p>
                    </div>
                </div>

                @if(!$tableExists)
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i>Tabel Rubrik Penilaian Belum Ada</h5>
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <a href="{{ route('guru.evaluasi.rubrik.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Rubrik Penilaian
                            </a>
                            <a href="{{ route('guru.evaluasi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('guru.evaluasi.rubrik.index') }}" class="d-flex gap-2">
                                <select name="mata_pelajaran" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Mata Pelajaran</option>
                                    @foreach($mataPelajaranList as $mapel)
                                        <option value="{{ $mapel->mata_pelajaran }}" {{ $selectedMataPelajaran == $mapel->mata_pelajaran ? 'selected' : '' }}>
                                            {{ $mapel->mata_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>

                    @if($rubrik->count() > 0)
                        <div class="row">
                            @foreach($rubrik as $item)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->judul }}</h5>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-book me-1"></i>{{ $item->mata_pelajaran }}<br>
                                                    <i class="fas fa-users me-1"></i>Kelas {{ $item->kelas }}<br>
                                                    <i class="fas fa-calendar me-1"></i>Semester {{ $item->semester }}
                                                </small>
                                            </p>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('guru.evaluasi.rubrik.show', $item->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('guru.evaluasi.rubrik.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('guru.evaluasi.rubrik.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $rubrik->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Belum ada rubrik penilaian. <a href="{{ route('guru.evaluasi.rubrik.create') }}">Buat rubrik penilaian pertama</a>
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
