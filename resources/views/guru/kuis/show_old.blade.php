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
        
        
        .suggested-searches .btn {
            margin: 2px;
            border-radius: 20px;
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
                                @if($kuis->tipe_kuis === 'esai')
                                    <i class="fas fa-edit me-1"></i>Esai
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

    <!-- YouTube Search Modal -->
    <div class="modal fade" id="youtubeSearchModal" tabindex="-1" aria-labelledby="youtubeSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="youtubeSearchModalLabel">
                        <i class="fab fa-youtube me-2"></i>Pencarian Video YouTube
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- YouTube-like Interface -->
                    <div class="youtube-search-container">
                        <!-- YouTube-like Header -->
                        <div class="youtube-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-bars me-3 text-muted"></i>
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-youtube text-danger me-2" style="font-size: 1.5rem;"></i>
                                        <span class="fw-bold">YouTube</span>
                                        <span class="badge bg-light text-dark ms-2">ID</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="youtube-search-box">
                                        <input type="text" class="form-control" id="youtube_search_modal" 
                                               placeholder="Cari video pembelajaran... (contoh: sistem pencernaan manusia)">
                                        <button class="btn btn-outline-secondary" type="button" id="clear_search_modal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button class="btn btn-danger" type="button" id="search_youtube_modal">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    <button class="btn btn-outline-secondary ms-2" type="button">
                                        <i class="fas fa-microphone"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Main Content Area -->
                        <div class="youtube-main-content">
                            <!-- Search Results Area -->
                            <div id="youtube_results_modal" class="youtube-results" style="display: none;">
                                <!-- Results will be populated by JavaScript -->
                            </div>
                            
                            <!-- Welcome Screen (when no search) -->
                            <div id="youtube_welcome_modal" class="youtube-welcome text-center py-5">
                                <div class="welcome-content">
                                    <i class="fab fa-youtube text-danger mb-3" style="font-size: 4rem;"></i>
                                    <h4 class="mb-3">Selamat Datang di YouTube Search</h4>
                                    <p class="text-muted mb-4">Cari video pembelajaran yang sesuai dengan materi Anda</p>
                                    <div class="suggested-searches">
                                        <h6 class="mb-3">Pencarian Populer:</h6>
                                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                                            <button class="btn btn-outline-primary btn-sm" onclick="searchSuggestedModal('matematika kelas 7')">Matematika Kelas 7</button>
                                            <button class="btn btn-outline-primary btn-sm" onclick="searchSuggestedModal('fisika hukum newton')">Fisika Hukum Newton</button>
                                            <button class="btn btn-outline-primary btn-sm" onclick="searchSuggestedModal('biologi sistem pencernaan')">Biologi Sistem Pencernaan</button>
                                            <button class="btn btn-outline-primary btn-sm" onclick="searchSuggestedModal('kimia asam basa')">Kimia Asam Basa</button>
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
        // YouTube Search Modal Functions
        function openYouTubeSearch() {
            const modal = new bootstrap.Modal(document.getElementById('youtubeSearchModal'));
            modal.show();
        }
        
        // Search functionality for modal
        document.getElementById('search_youtube_modal').addEventListener('click', function() {
            const searchTerm = document.getElementById('youtube_search_modal').value.trim();
            if (!searchTerm) {
                alert('Masukkan kata kunci pencarian!');
                return;
            }
            searchYouTubeVideosModal(searchTerm);
        });
        
        // Clear search button for modal
        document.getElementById('clear_search_modal').addEventListener('click', function() {
            document.getElementById('youtube_search_modal').value = '';
            document.getElementById('youtube_results_modal').style.display = 'none';
            document.getElementById('youtube_welcome_modal').style.display = 'block';
        });
        
        // Enter key search for modal
        document.getElementById('youtube_search_modal').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('search_youtube_modal').click();
            }
        });
        
        // Suggested search function for modal
        function searchSuggestedModal(term) {
            document.getElementById('youtube_search_modal').value = term;
            searchYouTubeVideosModal(term);
        }
        
        // Function to get relevant search results based on query
        function getRelevantSearchResults(query) {
            const lowerQuery = query.toLowerCase();
            
            // Database of educational videos organized by topics
            const videoDatabase = {
                // Sistem Pernapasan
                'pernapasan': [
                    {
                        id: 'resp1',
                        title: 'Sistem Pernapasan Manusia - Penjelasan Lengkap',
                        description: 'Video pembelajaran tentang sistem pernapasan manusia untuk siswa SMP',
                        thumbnail: 'https://img.youtube.com/vi/resp1/mqdefault.jpg',
                        duration: '18:30',
                        channel: 'Biology Channel',
                        views: '234K views',
                        published: '2 weeks ago'
                    },
                    {
                        id: 'resp2',
                        title: 'Organ Pernapasan: Paru-paru dan Alveoli',
                        description: 'Penjelasan detail tentang organ pernapasan manusia',
                        thumbnail: 'https://img.youtube.com/vi/resp2/mqdefault.jpg',
                        duration: '15:45',
                        channel: 'Science Academy',
                        views: '189K views',
                        published: '1 month ago'
                    },
                    {
                        id: 'resp3',
                        title: 'Proses Pernapasan: Inspirasi dan Ekspirasi',
                        description: 'Animasi 3D proses pernapasan manusia',
                        thumbnail: 'https://img.youtube.com/vi/resp3/mqdefault.jpg',
                        duration: '12:20',
                        channel: 'EduChannel Indonesia',
                        views: '156K views',
                        published: '3 weeks ago'
                    }
                ],
                
                // Sistem Pencernaan
                'pencernaan': [
                    {
                        id: 'dig1',
                        title: 'Sistem Pencernaan Manusia - Organ dan Fungsi',
                        description: 'Video pembelajaran sistem pencernaan manusia untuk siswa SMP',
                        thumbnail: 'https://img.youtube.com/vi/dig1/mqdefault.jpg',
                        duration: '20:15',
                        channel: 'Biology Channel',
                        views: '312K views',
                        published: '1 week ago'
                    },
                    {
                        id: 'dig2',
                        title: 'Proses Pencernaan: Mulut hingga Anus',
                        description: 'Penjelasan lengkap proses pencernaan makanan',
                        thumbnail: 'https://img.youtube.com/vi/dig2/mqdefault.jpg',
                        duration: '25:30',
                        channel: 'Science Academy',
                        views: '278K views',
                        published: '2 weeks ago'
                    }
                ],
                
                // Organ Tubuh
                'organ': [
                    {
                        id: 'org1',
                        title: 'Organ-organ Tubuh Manusia dan Fungsinya',
                        description: 'Pengenalan organ tubuh manusia untuk siswa SD/SMP',
                        thumbnail: 'https://img.youtube.com/vi/org1/mqdefault.jpg',
                        duration: '22:45',
                        channel: 'Biology Channel',
                        views: '445K views',
                        published: '1 month ago'
                    },
                    {
                        id: 'org2',
                        title: 'Anatomi Organ Dalam: Jantung, Paru-paru, Hati',
                        description: 'Penjelasan organ dalam tubuh manusia',
                        thumbnail: 'https://img.youtube.com/vi/org2/mqdefault.jpg',
                        duration: '18:20',
                        channel: 'Medical Channel',
                        views: '389K views',
                        published: '3 weeks ago'
                    }
                ],
                
                // Matematika
                'matematika': [
                    {
                        id: 'math1',
                        title: 'Matematika Dasar - Operasi Hitung',
                        description: 'Pembelajaran operasi hitung dasar untuk siswa SD',
                        thumbnail: 'https://img.youtube.com/vi/math1/mqdefault.jpg',
                        duration: '16:30',
                        channel: 'EduChannel Indonesia',
                        views: '567K views',
                        published: '2 weeks ago'
                    },
                    {
                        id: 'math2',
                        title: 'Aljabar: Persamaan Linear',
                        description: 'Pembelajaran aljabar untuk siswa SMP',
                        thumbnail: 'https://img.youtube.com/vi/math2/mqdefault.jpg',
                        duration: '19:45',
                        channel: 'Math Academy',
                        views: '423K views',
                        published: '1 week ago'
                    }
                ],
                
                // Fisika
                'fisika': [
                    {
                        id: 'phy1',
                        title: 'Hukum Newton - Penjelasan Lengkap',
                        description: 'Pembelajaran hukum Newton untuk siswa SMA',
                        thumbnail: 'https://img.youtube.com/vi/phy1/mqdefault.jpg',
                        duration: '24:15',
                        channel: 'Physics Channel',
                        views: '298K views',
                        published: '1 month ago'
                    },
                    {
                        id: 'phy2',
                        title: 'Gerak Lurus Beraturan (GLB)',
                        description: 'Konsep dasar gerak lurus beraturan',
                        thumbnail: 'https://img.youtube.com/vi/phy2/mqdefault.jpg',
                        duration: '17:30',
                        channel: 'Science Academy',
                        views: '234K views',
                        published: '2 weeks ago'
                    }
                ],
                
                // Kimia
                'kimia': [
                    {
                        id: 'chem1',
                        title: 'Asam dan Basa - Konsep Dasar',
                        description: 'Pembelajaran asam dan basa untuk siswa SMA',
                        thumbnail: 'https://img.youtube.com/vi/chem1/mqdefault.jpg',
                        duration: '21:20',
                        channel: 'Chemistry Lab',
                        views: '345K views',
                        published: '1 week ago'
                    },
                    {
                        id: 'chem2',
                        title: 'Tabel Periodik Unsur',
                        description: 'Penjelasan tabel periodik unsur kimia',
                        thumbnail: 'https://img.youtube.com/vi/chem2/mqdefault.jpg',
                        duration: '26:45',
                        channel: 'Chemistry Channel',
                        views: '412K views',
                        published: '3 weeks ago'
                    }
                ]
            };
            
            // Search for relevant topics
            let relevantResults = [];
            
            // Check for specific topics
            if (lowerQuery.includes('pernapasan') || lowerQuery.includes('respirasi')) {
                relevantResults = relevantResults.concat(videoDatabase['pernapasan']);
            }
            if (lowerQuery.includes('pencernaan') || lowerQuery.includes('digestif')) {
                relevantResults = relevantResults.concat(videoDatabase['pencernaan']);
            }
            if (lowerQuery.includes('organ') || lowerQuery.includes('anatomi')) {
                relevantResults = relevantResults.concat(videoDatabase['organ']);
            }
            if (lowerQuery.includes('matematika') || lowerQuery.includes('math')) {
                relevantResults = relevantResults.concat(videoDatabase['matematika']);
            }
            if (lowerQuery.includes('fisika') || lowerQuery.includes('physics')) {
                relevantResults = relevantResults.concat(videoDatabase['fisika']);
            }
            if (lowerQuery.includes('kimia') || lowerQuery.includes('chemistry')) {
                relevantResults = relevantResults.concat(videoDatabase['kimia']);
            }
            
            // If no specific topic found, return general educational videos
            if (relevantResults.length === 0) {
                relevantResults = [
                    {
                        id: 'gen1',
                        title: 'Pembelajaran Umum - Konsep Dasar',
                        description: 'Video pembelajaran umum untuk siswa',
                        thumbnail: 'https://img.youtube.com/vi/gen1/mqdefault.jpg',
                        duration: '15:30',
                        channel: 'EduChannel Indonesia',
                        views: '125K views',
                        published: '2 weeks ago'
                    },
                    {
                        id: 'gen2',
                        title: 'Materi Pembelajaran Interaktif',
                        description: 'Pembelajaran interaktif untuk berbagai mata pelajaran',
                        thumbnail: 'https://img.youtube.com/vi/gen2/mqdefault.jpg',
                        duration: '18:45',
                        channel: 'Education Hub',
                        views: '198K views',
                        published: '1 week ago'
                    }
                ];
            }
            
            // Limit results to 4 videos
            return relevantResults.slice(0, 4);
        }
        
        function searchYouTubeVideosModal(query) {
            // Show loading
            const resultsDiv = document.getElementById('youtube_results_modal');
            resultsDiv.innerHTML = '<div class="col-12 text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Mencari video...</p></div>';
            resultsDiv.style.display = 'grid';
            
            // Simulate YouTube API search
            setTimeout(() => {
                displayMockResultsModal(query);
            }, 1500);
        }
        
        function displayMockResultsModal(query) {
            const resultsDiv = document.getElementById('youtube_results_modal');
            const welcomeDiv = document.getElementById('youtube_welcome_modal');
            
            // Hide welcome screen
            welcomeDiv.style.display = 'none';
            
            // Get relevant results based on search query
            const mockResults = getRelevantSearchResults(query);
            
            let html = '';
            mockResults.forEach((video, index) => {
                html += `
                    <div class="youtube-video-card" onclick="selectVideoModal('${video.id}', '${video.title}', '${video.description}', '${video.thumbnail}', '${video.duration}', '${video.channel}')">
                        <div class="youtube-video-thumbnail">
                            <img src="${video.thumbnail}" alt="Video Thumbnail">
                            <button class="youtube-play-button">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                        <div class="youtube-video-info">
                            <div class="youtube-video-title">${video.title}</div>
                            <div class="youtube-video-channel">${video.channel}</div>
                            <div class="youtube-video-meta">
                                <span>${video.views}</span>
                                <span>•</span>
                                <span>${video.published}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            resultsDiv.innerHTML = html;
            resultsDiv.style.display = 'grid';
        }
        
        function selectVideoModal(videoId, title, description, thumbnail, duration, channel) {
            // Show confirmation
            if (confirm(`Apakah Anda yakin ingin mengganti video dengan:\n\n"${title}"\n\nChannel: ${channel}\nDurasi: ${duration}?`)) {
                // Here you would typically update the quiz with new video
                // For now, we'll just show an alert
                alert('Video berhasil dipilih! (Fitur update video akan segera tersedia)');
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('youtubeSearchModal'));
                modal.hide();
            }
        }
    </script>
</body>
</html>
