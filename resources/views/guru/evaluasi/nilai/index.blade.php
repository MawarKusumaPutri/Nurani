@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Formatif & Sumatif - {{ $guru->user->name }}</title>
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
            background-color: #ffffff !important;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
        }
    </style>
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
                        <h2 class="mb-1">Nilai Formatif & Sumatif</h2>
                        <p class="text-muted mb-0">Input dan kelola nilai formatif dan sumatif siswa</p>
                    </div>
                </div>

                @if(!$tableExists)
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i>Tabel Nilai Formatif & Sumatif Belum Ada</h5>
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
                            <a href="{{ route('guru.evaluasi.nilai.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Nilai
                            </a>
                            <a href="{{ route('guru.evaluasi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('guru.evaluasi.nilai.index') }}" class="d-flex gap-2">
                                <select name="mata_pelajaran" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Mata Pelajaran</option>
                                    @foreach($mataPelajaranList as $mapel)
                                        <option value="{{ $mapel->mata_pelajaran }}" {{ $selectedMataPelajaran == $mapel->mata_pelajaran ? 'selected' : '' }}>
                                            {{ $mapel->mata_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="kelas" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Kelas</option>
                                    <option value="7" {{ $selectedKelas == '7' ? 'selected' : '' }}>Kelas 7</option>
                                    <option value="8" {{ $selectedKelas == '8' ? 'selected' : '' }}>Kelas 8</option>
                                    <option value="9" {{ $selectedKelas == '9' ? 'selected' : '' }}>Kelas 9</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    @if($nilai->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Semester</th>
                                        <th>Rata Formatif</th>
                                        <th>Rata Sumatif</th>
                                        <th>Nilai Akhir</th>
                                        <th>Predikat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilai as $item)
                                        <tr>
                                            <td>{{ $item->siswa->nama ?? 'N/A' }}</td>
                                            <td>{{ $item->mata_pelajaran }}</td>
                                            <td>Kelas {{ $item->kelas }}</td>
                                            <td>{{ $item->semester }}</td>
                                            <td>
                                                @if($item->rata_formatif)
                                                    <span class="badge bg-info">{{ number_format($item->rata_formatif, 2) }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->rata_sumatif)
                                                    <span class="badge bg-warning">{{ number_format($item->rata_sumatif, 2) }}</span>
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
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('guru.evaluasi.nilai.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('guru.evaluasi.nilai.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $nilai->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Belum ada nilai formatif & sumatif. <a href="{{ route('guru.evaluasi.nilai.create') }}">Input nilai pertama</a>
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
