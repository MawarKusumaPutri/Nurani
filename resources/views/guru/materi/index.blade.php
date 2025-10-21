<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Materi - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }
        .materi-card {
            transition: transform 0.3s ease;
            border-left: 4px solid #667eea;
        }
        .materi-card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-published {
            background: #d4edda;
            color: #155724;
        }
        .status-draft {
            background: #fff3cd;
            color: #856404;
        }
        .file-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        .file-pdf { background: #dc3545; }
        .file-video { background: #6f42c1; }
        .file-image { background: #28a745; }
        .file-document { background: #007bff; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Dashboard Guru
                    </h4>
                    <div class="text-center mb-4">
                        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('guru.profil') }}">
                        <i class="fas fa-user me-2"></i> Profil
                    </a>
                    <a class="nav-link active" href="{{ route('guru.materi.index') }}">
                        <i class="fas fa-book me-2"></i> Materi
                    </a>
                    <a class="nav-link" href="{{ route('guru.kuis.index') }}">
                        <i class="fas fa-question-circle me-2"></i> Kuis
                    </a>
                    <a class="nav-link" href="{{ route('guru.rangkuman.index') }}">
                        <i class="fas fa-clipboard-list me-2"></i> Rangkuman
                    </a>
                    <hr class="text-white-50">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Manajemen Materi</h2>
                        <p class="text-muted mb-0">Kelola materi pembelajaran Anda</p>
                        @if($selectedMataPelajaran)
                            <span class="badge bg-primary">{{ $selectedMataPelajaran }}</span>
                        @endif
                    </div>
                    <a href="{{ route('guru.materi.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Materi
                    </a>
                </div>

                <!-- Mata Pelajaran Switcher -->
                @if($mataPelajaranList->count() > 1)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-exchange-alt me-2 text-primary"></i>
                                Filter Berdasarkan Mata Pelajaran
                            </h6>
                            <div class="row">
                                @foreach($mataPelajaranList as $mp)
                                    <div class="col-md-4 col-lg-3 mb-2">
                                        <a href="{{ route('guru.materi.index', ['mata_pelajaran' => $mp->mata_pelajaran]) }}" 
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

                <!-- Search and Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('guru.materi.search') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Cari materi..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="kelas">
                                    <option value="">Semua Kelas</option>
                                    <option value="1" {{ request('kelas') == '1' ? 'selected' : '' }}>Kelas 1</option>
                                    <option value="2" {{ request('kelas') == '2' ? 'selected' : '' }}>Kelas 2</option>
                                    <option value="3" {{ request('kelas') == '3' ? 'selected' : '' }}>Kelas 3</option>
                                    <option value="4" {{ request('kelas') == '4' ? 'selected' : '' }}>Kelas 4</option>
                                    <option value="5" {{ request('kelas') == '5' ? 'selected' : '' }}>Kelas 5</option>
                                    <option value="6" {{ request('kelas') == '6' ? 'selected' : '' }}>Kelas 6</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="topik" 
                                       placeholder="Topik..." value="{{ request('topik') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Materi List -->
                @if($materi->count() > 0)
                    <div class="row">
                        @foreach($materi as $item)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card materi-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-1">{{ $item->judul }}</h5>
                                                <p class="text-muted small mb-2">{{ Str::limit($item->deskripsi, 80) }}</p>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" 
                                                        data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('guru.materi.show', $item) }}">
                                                        <i class="fas fa-eye me-2"></i>Lihat
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('guru.materi.edit', $item) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('guru.materi.destroy', $item) }}" method="POST" 
                                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash me-2"></i>Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- File Info -->
                                        @if($item->file_path)
                                            <div class="d-flex align-items-center mb-3">
                                                @php
                                                    $fileType = $item->file_type;
                                                    $iconClass = 'fas fa-file';
                                                    $iconBg = 'file-document';
                                                    
                                                    if (str_contains($fileType, 'pdf')) {
                                                        $iconClass = 'fas fa-file-pdf';
                                                        $iconBg = 'file-pdf';
                                                    } elseif (str_contains($fileType, 'video')) {
                                                        $iconClass = 'fas fa-file-video';
                                                        $iconBg = 'file-video';
                                                    } elseif (str_contains($fileType, 'image')) {
                                                        $iconClass = 'fas fa-file-image';
                                                        $iconBg = 'file-image';
                                                    }
                                                @endphp
                                                <div class="file-icon {{ $iconBg }} me-2">
                                                    <i class="{{ $iconClass }}"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted d-block">{{ $item->file_type }}</small>
                                                    <small class="text-muted">{{ $item->file_size_formatted }}</small>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Video Link -->
                                        @if($item->link_video)
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="file-icon file-video me-2">
                                                    <i class="fas fa-video"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted">Video Pembelajaran</small>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Tags -->
                                        <div class="d-flex flex-wrap gap-1 mb-3">
                                            <span class="badge bg-light text-dark">{{ $item->kelas }}</span>
                                            <span class="badge bg-light text-dark">{{ $item->topik }}</span>
                                            @if($item->is_published)
                                                <span class="status-badge status-published">Dipublikasi</span>
                                            @else
                                                <span class="status-badge status-draft">Draft</span>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('guru.materi.show', $item) }}" 
                                               class="btn btn-sm btn-outline-primary flex-grow-1">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </a>
                                            <a href="{{ route('guru.materi.edit', $item) }}" 
                                               class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $materi->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">Belum Ada Materi</h4>
                        <p class="text-muted mb-4">Mulai buat materi pembelajaran pertama Anda</p>
                        <a href="{{ route('guru.materi.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Tambah Materi Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
