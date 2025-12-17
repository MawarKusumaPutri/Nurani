@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kuis - {{ $kuis->judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        }
        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
        }
        .quiz-type-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
        }
        .question-item {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f8f9fa;
        }
        .question-number {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }
    </style>
    @include('partials.guru-dynamic-ui')
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
                                 class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $kuis->guru->user->name }}</h6>
                        <small class="text-white-50">{{ $kuis->guru->mata_pelajaran }}</small>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('guru.jadwal.index') }}">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Mengajar
                    </a>
                    <a class="nav-link" href="{{ route('guru.presensi.index') }}">
                        <i class="fas fa-calendar-check me-2"></i> Presensi Guru
                    </a>
                    <a class="nav-link" href="{{ route('guru.presensi-siswa.index') }}">
                        <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
                    </a>
                    <a class="nav-link" href="{{ route('guru.materi.index') }}">
                        <i class="fas fa-book me-2"></i> Materi
                    </a>
                    <a class="nav-link active" href="{{ route('guru.kuis.index') }}">
                        <i class="fas fa-question-circle me-2"></i> Kuis
                    </a>
                    <hr class="text-white-50">
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
                            @if($kuis->tipe_kuis)
                                <span class="badge bg-success quiz-type-badge me-2">
                                    @if($kuis->tipe_kuis === 'esai')
                                        <i class="fas fa-edit me-1"></i>Esai
                                    @elseif($kuis->tipe_kuis === 'pilihan_ganda')
                                        <i class="fas fa-question-circle me-1"></i>Pilihan Ganda
                                    @elseif($kuis->tipe_kuis === 'video')
                                        <i class="fas fa-video me-1"></i>Video
                                    @endif
                                </span>
                            @elseif($kuis->external_quiz_url)
                                <span class="badge bg-success quiz-type-badge me-2">
                                    <i class="fas fa-external-link-alt me-1"></i>Link Eksternal
                                </span>
                            @endif
                            {{ $kuis->mata_pelajaran }} - Kelas {{ $kuis->kelas }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('guru.kuis.edit', $kuis->id) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-2"></i>Edit Kuis
                        </a>
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
                        @if($kuis->tipe_kuis === 'esai')
                            <!-- Essay Quiz -->
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Kuis Esai</h5>
                                </div>
                                <div class="card-body">
                                    @if($kuis->esai_soal)
                                        <div class="mb-4">
                                            <h6 class="mb-3">Pertanyaan Esai:</h6>
                                            <div class="bg-light p-4 rounded border-start border-success border-4">
                                                <p class="mb-0 fs-5">{{ $kuis->esai_soal }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($kuis->esai_petunjuk)
                                        <div class="mb-3">
                                            <h6 class="mb-2">Petunjuk Jawaban:</h6>
                                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                                <p class="mb-0">{{ $kuis->esai_petunjuk }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Petunjuk:</strong> Siswa akan menjawab pertanyaan esai ini dengan mengetik jawaban mereka secara detail dan terstruktur.
                                    </div>
                                </div>
                            </div>
                        @elseif($kuis->tipe_kuis === 'pilihan_ganda')
                            <!-- Multiple Choice Quiz -->
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>Soal Kuis</h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        // Pastikan soal ter-decode dengan benar
                                        $soalData = $kuis->soal;
                                        if (is_string($soalData)) {
                                            $soalData = json_decode($soalData, true);
                                        }
                                    @endphp
                                    
                                    @if($soalData && is_array($soalData) && count($soalData) > 0)
                                        @foreach($soalData as $index => $soal)
                                            <div class="question-item">
                                                <div class="d-flex align-items-start mb-3">
                                                    <div class="question-number">{{ $index + 1 }}</div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-3">{{ $soal['pertanyaan'] ?? 'Pertanyaan tidak tersedia' }}</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" disabled>
                                                                    <label class="form-check-label">
                                                                        A. {{ isset($soal['pilihan']['A']) ? $soal['pilihan']['A'] : (isset($soal['pilihan_a']) ? $soal['pilihan_a'] : '') }}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" disabled>
                                                                    <label class="form-check-label">
                                                                        B. {{ isset($soal['pilihan']['B']) ? $soal['pilihan']['B'] : (isset($soal['pilihan_b']) ? $soal['pilihan_b'] : '') }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" disabled>
                                                                    <label class="form-check-label">
                                                                        C. {{ isset($soal['pilihan']['C']) ? $soal['pilihan']['C'] : (isset($soal['pilihan_c']) ? $soal['pilihan_c'] : '') }}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio" disabled>
                                                                    <label class="form-check-label">
                                                                        D. {{ isset($soal['pilihan']['D']) ? $soal['pilihan']['D'] : (isset($soal['pilihan_d']) ? $soal['pilihan_d'] : '') }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check me-1"></i>Jawaban Benar: {{ $soal['jawaban_benar'] ?? 'Tidak tersedia' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Soal kuis belum dibuat atau tidak tersedia</p>
                                            @if(config('app.debug'))
                                                <small class="text-muted d-block mt-2">
                                                    Debug: soal data = {{ var_export($soalData, true) }}
                                                </small>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @elseif($kuis->external_quiz_url)
                            <!-- External Link Quiz -->
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-external-link-alt me-2"></i>Kuis Eksternal</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-link fa-4x text-success mb-3"></i>
                                        <h5>Kuis ini menggunakan link eksternal</h5>
                                        <p class="text-muted">Siswa akan diarahkan ke link kuis eksternal untuk mengerjakan kuis.</p>
                                    </div>
                                    <a href="{{ $kuis->external_quiz_url }}" target="_blank" rel="noopener noreferrer"
                                       class="btn btn-lg btn-success">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        Buka Link Kuis
                                    </a>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            {{ $kuis->external_quiz_url }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Default/Unknown Quiz Type -->
                            <div class="card">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>Informasi Kuis</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center py-4">
                                        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Informasi kuis tidak tersedia</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar Information -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Kuis</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6>Judul:</h6>
                                    <p class="mb-0">{{ $kuis->judul }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Mata Pelajaran:</h6>
                                    <p class="mb-0">{{ $kuis->mata_pelajaran }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Kelas:</h6>
                                    <p class="mb-0">{{ $kuis->kelas }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Durasi:</h6>
                                    <p class="mb-0">{{ $kuis->durasi_menit }} menit</p>
                                </div>

                                @if($kuis->external_quiz_url)
                                    <div class="mb-3">
                                        <h6>Link Kuis Eksternal:</h6>
                                        <a href="{{ $kuis->external_quiz_url }}" target="_blank" rel="noopener noreferrer"
                                           class="btn btn-outline-success w-100 mb-2">
                                            <i class="fas fa-external-link-alt me-2"></i>
                                            Buka Link Kuis
                                        </a>
                                        <small class="text-muted d-block">
                                            {{ \Illuminate\Support\Str::limit($kuis->external_quiz_url, 60) }}
                                        </small>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <h6>Status:</h6>
                                    <span class="badge bg-{{ $kuis->status === 'berlangsung' ? 'success' : ($kuis->status === 'selesai' ? 'danger' : 'warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $kuis->status)) }}
                                    </span>
                                </div>
                                
                                @if($kuis->deskripsi)
                                    <div class="mb-3">
                                        <h6>Deskripsi:</h6>
                                        <p class="mb-0">{{ $kuis->deskripsi }}</p>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <h6>Dibuat:</h6>
                                    <p class="mb-0">{{ $kuis->created_at->format('d F Y H:i') }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Berlaku Sampai:</h6>
                                    <p class="mb-0">{{ $kuis->tanggal_selesai->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('guru.kuis.edit', $kuis->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit me-2"></i>Edit Kuis
                                    </a>
                                    <form action="{{ route('guru.kuis.destroy', $kuis->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuis ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
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
