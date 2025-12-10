@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen RPP - {{ $guru->user->name }}</title>
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
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
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
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Manajemen RPP</h2>
                        <p class="text-muted mb-0">Rencana Pelaksanaan Pembelajaran</p>
                        @if(isset($selectedMataPelajaran) && $selectedMataPelajaran)
                            <span class="badge bg-primary">{{ $selectedMataPelajaran }}</span>
                        @endif
                    </div>
                </div>

                <!-- Mata Pelajaran Switcher -->
                @if(isset($mataPelajaranList) && $mataPelajaranList->count() > 1)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-exchange-alt me-2 text-primary"></i>
                                Filter Berdasarkan Mata Pelajaran
                            </h6>
                            <div class="row">
                                @foreach($mataPelajaranList as $mp)
                                    <div class="col-md-4 col-lg-3 mb-2">
                                        <a href="{{ route('guru.rpp.index', ['mata_pelajaran' => $mp->mata_pelajaran]) }}" 
                                           class="btn w-100 {{ $selectedMataPelajaran == $mp->mata_pelajaran ? 'btn-primary' : 'btn-outline-primary' }}">
                                            <i class="fas fa-book me-2"></i>{{ $mp->mata_pelajaran }}
                                            @if($selectedMataPelajaran == $mp->mata_pelajaran)
                                                <i class="fas fa-check float-end"></i>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(isset($errorMessage) && $errorMessage)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #dc3545;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading mb-2">Tabel RPP Belum Ada</h5>
                                <p class="mb-2">{{ $errorMessage }}</p>
                                <hr>
                                <p class="mb-3"><strong>Pilih salah satu cara untuk membuat tabel:</strong></p>
                                
                                <div class="mb-3">
                                    <h6 class="text-success">✅ Cara 1: Otomatis (Paling Mudah)</h6>
                                    <p class="mb-2">Klik tombol di bawah untuk membuat tabel secara otomatis:</p>
                                    <div class="d-flex gap-2 mb-3" style="flex-wrap: wrap;">
                                        <a href="http://localhost/nurani/public/BUAT_TABEL_RPP_OTOMATIS_LANGSUNG.php" target="_blank" class="btn btn-success btn-lg">
                                            <i class="fas fa-magic me-2"></i>🚀 Buat Tabel RPP Sekarang (RECOMMENDED)
                                        </a>
                                        <a href="http://localhost/nurani/public/BUAT_RPP_SIMPLE.php" target="_blank" class="btn btn-primary btn-lg">
                                            <i class="fas fa-bolt me-2"></i>⚡ Buat via Browser
                                        </a>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Atau double-click file: <code>KLIK_INI_BUAT_RPP.bat</code> (di folder project)
                                    </p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6 class="text-primary">📝 Cara 2: Manual via phpMyAdmin</h6>
                                    <ol class="mb-0 mt-2">
                                        <li>Buka phpMyAdmin: <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></li>
                                        <li>Pilih database <code>nurani</code></li>
                                        <li>Klik tab <strong>SQL</strong></li>
                                        <li>Buka file <code>SQL_RPP_LANGSUNG.txt</code> dari folder proyek</li>
                                        <li>Copy semua isinya dan paste ke textarea SQL</li>
                                        <li>Klik tombol <strong>Go</strong> atau <strong>Jalankan</strong></li>
                                        <li>Refresh halaman ini setelah tabel berhasil dibuat</li>
                                    </ol>
                                </div>
                                
                                <div class="mt-3">
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Untuk panduan lengkap, buka file: <code>CARA_BUAT_TABEL_RPP_MUDAH.txt</code>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Action Buttons -->
                @if(isset($tableExists) && $tableExists)
                <div class="d-flex justify-content-start gap-3 mb-4" style="flex-wrap: wrap;">
                    <a href="{{ route('guru.rpp.create') }}" class="btn btn-success" style="background-color: #28a745 !important; border-color: #28a745 !important; padding: 0.75rem 1.5rem; font-size: 1rem; font-weight: 500; border-radius: 0.5rem; color: white !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fas fa-plus me-2"></i>Tambah RPP
                    </a>
                </div>
                @endif

                <!-- RPP List -->
                @if(isset($tableExists) && $tableExists && isset($rpp) && $rpp->count() > 0)
                    <div class="row">
                        @foreach($rpp as $item)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-weight: 600; color: #333;">{{ $item->judul }}</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge bg-primary">{{ $item->kelas }}</span>
                                            <span class="badge bg-info text-white">{{ $item->mata_pelajaran }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                Semester {{ $item->semester }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="fas fa-clock me-1"></i>
                                                Pertemuan ke-{{ $item->pertemuan_ke }} ({{ $item->alokasi_waktu }} menit)
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $item->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent" style="border-top: 1px solid #e9ecef;">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('guru.rpp.show', $item) }}" 
                                               class="btn btn-sm btn-outline-primary flex-grow-1">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </a>
                                            <a href="{{ route('guru.rpp.edit', $item) }}" 
                                               class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('guru.rpp.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus RPP ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $rpp->links() }}
                    </div>
                @elseif(isset($tableExists) && $tableExists && isset($rpp))
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada RPP</h5>
                        <p class="text-muted">Mulai dengan membuat RPP baru</p>
                        <a href="{{ route('guru.rpp.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Tambah RPP
                        </a>
                    </div>
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
    </script>
</body>
</html>
