<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kuis->judul }} - Kuis</title>
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
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
        }
        .video-container {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            overflow: hidden;
            border-radius: 10px;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
        .quiz-type-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
        }
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
                        @if($kuis->guru->foto)
                            <img src="{{ Storage::url($kuis->guru->foto) }}" alt="Foto Profil" 
                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white;">
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $kuis->guru->user->name }}</h6>
                        <small class="text-white-50">{{ $kuis->guru->mata_pelajaran }}</small>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('guru.profil') }}">
                        <i class="fas fa-user me-2"></i> Profil
                    </a>
                    <a class="nav-link" href="{{ route('guru.materi.index') }}">
                        <i class="fas fa-book me-2"></i> Materi
                    </a>
                    <a class="nav-link active" href="{{ route('guru.kuis.index') }}">
                        <i class="fas fa-question-circle me-2"></i> Kuis
                    </a>
                    <a class="nav-link" href="{{ route('guru.rangkuman.index') }}">
                        <i class="fas fa-file-alt me-2"></i> Rangkuman
                    </a>
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">{{ $kuis->judul }}</h2>
                        <p class="text-muted mb-0">
                            <span class="badge bg-primary quiz-type-badge me-2">
                                @if($kuis->tipe_kuis === 'video')
                                    <i class="fas fa-video me-1"></i>Video YouTube
                                @else
                                    <i class="fas fa-question-circle me-1"></i>Pilihan Ganda
                                @endif
                            </span>
                            {{ $kuis->mata_pelajaran }} - Kelas {{ $kuis->kelas }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('guru.kuis.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Quiz Content -->
                <div class="row">
                    <div class="col-lg-8">
                        @if($kuis->tipe_kuis === 'video')
                            <!-- Video Quiz -->
                            <div class="card mb-4">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0"><i class="fas fa-video me-2"></i>Video YouTube</h5>
                                </div>
                                <div class="card-body">
                                    @if($kuis->video_url)
                                        <div class="video-container">
                                            <iframe src="{{ $kuis->getEmbedUrl() }}" 
                                                    frameborder="0" 
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                    allowfullscreen>
                                            </iframe>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-video fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Video tidak tersedia</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Video Questions -->
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>Pertanyaan Video</h5>
                                </div>
                                <div class="card-body">
                                    @if($kuis->video_soal)
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-info-circle me-2"></i>Instruksi:</h6>
                                            <p class="mb-0">{{ $kuis->video_soal }}</p>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Pertanyaan video belum dibuat</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- Multiple Choice Quiz -->
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>Soal Kuis</h5>
                                </div>
                                <div class="card-body">
                                    @if($kuis->soal && count(json_decode($kuis->soal, true)) > 0)
                                        @foreach(json_decode($kuis->soal, true) as $index => $soal)
                                            <div class="question-item mb-4 p-3 border rounded">
                                                <div class="d-flex align-items-start mb-3">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 30px; height: 30px; font-weight: bold;">
                                                        {{ $soal['nomor'] }}
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-3">{{ $soal['pertanyaan'] }}</h6>
                                                        <div class="row">
                                                            @foreach($soal['pilihan'] as $key => $pilihan)
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" 
                                                                               name="jawaban_{{ $soal['nomor'] }}" 
                                                                               id="jawaban_{{ $soal['nomor'] }}_{{ $key }}" 
                                                                               value="{{ $key }}" disabled>
                                                                        <label class="form-check-label" for="jawaban_{{ $soal['nomor'] }}_{{ $key }}">
                                                                            <strong>{{ $key }}.</strong> {{ $pilihan }}
                                                                            @if($key === $soal['jawaban_benar'])
                                                                                <span class="text-success ms-2"><i class="fas fa-check"></i> Benar</span>
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Soal kuis belum dibuat</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Quiz Info Sidebar -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Kuis</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul</label>
                                    <p class="mb-0">{{ $kuis->judul }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Mata Pelajaran</label>
                                    <p class="mb-0">{{ $kuis->mata_pelajaran }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Kelas</label>
                                    <p class="mb-0">{{ $kuis->kelas }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Durasi</label>
                                    <p class="mb-0">{{ $kuis->durasi_menit }} menit</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <p class="mb-0">
                                        <span class="badge bg-{{ $kuis->status === 'berlangsung' ? 'success' : ($kuis->status === 'selesai' ? 'danger' : 'warning') }}">
                                            {{ ucfirst(str_replace('_', ' ', $kuis->status)) }}
                                        </span>
                                    </p>
                                </div>
                                
                                @if($kuis->deskripsi)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Deskripsi</label>
                                        <p class="mb-0">{{ $kuis->deskripsi }}</p>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Dibuat</label>
                                    <p class="mb-0">{{ $kuis->created_at->format('d F Y H:i') }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Berlaku Sampai</label>
                                    <p class="mb-0">{{ $kuis->tanggal_selesai->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('guru.kuis.edit', $kuis) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit me-2"></i>Edit Kuis
                                    </a>
                                    <form action="{{ route('guru.kuis.destroy', $kuis) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuis ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="fas fa-trash me-2"></i>Hapus Kuis
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
