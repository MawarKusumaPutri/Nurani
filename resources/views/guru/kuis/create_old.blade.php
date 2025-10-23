<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kuis - {{ $guru->user->name }}</title>
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
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .question-item {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f8f9fa;
        }
        .video-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .video-card.border-primary {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        /* YouTube-like Interface Styles */
        .youtube-search-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e0e0e0;
        }
        
        .youtube-header {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .youtube-search-box {
            position: relative;
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 8px 15px;
            min-width: 400px;
        }
        
        .youtube-search-box input {
            border: none;
            outline: none;
            flex: 1;
            padding: 8px 12px;
            background: transparent;
        }
        
        .youtube-search-box .btn {
            border: none;
            background: transparent;
            padding: 5px 8px;
            margin: 0 2px;
        }
        
        .youtube-search-box .btn:hover {
            background: #f0f0f0;
            border-radius: 50%;
        }
        
        .youtube-main-content {
            background: white;
            border-radius: 8px;
            min-height: 400px;
            padding: 20px;
        }
        
        .youtube-welcome {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .youtube-results {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }
        
        .youtube-video-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .youtube-video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .youtube-video-thumbnail {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }
        
        .youtube-video-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .youtube-play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        
        .youtube-video-card:hover .youtube-play-button {
            background: #ff0000;
            transform: translate(-50%, -50%) scale(1.1);
        }
        
        .youtube-video-info {
            padding: 15px;
        }
        
        .youtube-video-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .youtube-video-channel {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .youtube-video-meta {
            color: #888;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .suggested-searches .btn {
            margin: 2px;
            border-radius: 20px;
        }
        .question-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                        @if($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="Foto Profil" 
                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white;">
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
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
                        <h2 class="mb-1">Buat Kuis Baru</h2>
                        <p class="text-muted mb-0">Buat kuis untuk mata pelajaran yang Anda ajarkan</p>
                    </div>
                </div>

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

                <form action="{{ route('guru.kuis.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Informasi Kuis</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Kuis <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                               id="judul" name="judul" value="{{ old('judul') }}" 
                                               placeholder="Masukkan judul kuis" required>
                                        @error('judul')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                        <select class="form-select @error('mata_pelajaran') is-invalid @enderror" 
                                                id="mata_pelajaran" name="mata_pelajaran" required>
                                            <option value="">Pilih Mata Pelajaran</option>
                                            @php
                                                $subjects = explode(', ', $guru->mata_pelajaran);
                                            @endphp
                                            @foreach($subjects as $subject)
                                                <option value="{{ trim($subject) }}" {{ old('mata_pelajaran') == trim($subject) ? 'selected' : '' }}>
                                                    {{ trim($subject) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('mata_pelajaran')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipe_kuis" class="form-label">Tipe Kuis <span class="text-danger">*</span></label>
                                        <select class="form-select @error('tipe_kuis') is-invalid @enderror" 
                                                id="tipe_kuis" name="tipe_kuis" required onchange="toggleQuizType()">
                                            <option value="">Pilih Tipe Kuis</option>
                                            <option value="pilihan_ganda" {{ old('tipe_kuis') == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                                            <option value="esai" {{ old('tipe_kuis') == 'esai' ? 'selected' : '' }}>Esai</option>
                                        </select>
                                        @error('tipe_kuis')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <select class="form-select @error('kelas') is-invalid @enderror" 
                                                id="kelas" name="kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            <option value="VII" {{ old('kelas') == 'VII' ? 'selected' : '' }}>VII</option>
                                            <option value="VIII" {{ old('kelas') == 'VIII' ? 'selected' : '' }}>VIII</option>
                                            <option value="IX" {{ old('kelas') == 'IX' ? 'selected' : '' }}>IX</option>
                                        </select>
                                        @error('kelas')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Esai Fields (Hidden by default) -->
                            <div id="esai-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="esai_soal" class="form-label">Pertanyaan Esai <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('esai_soal') is-invalid @enderror" 
                                              id="esai_soal" name="esai_soal" rows="4" 
                                              placeholder="Buat pertanyaan esai yang akan dijawab siswa...">{{ old('esai_soal') }}</textarea>
                                    <div class="form-text">Buat pertanyaan esai yang memerlukan jawaban panjang dan detail</div>
                                    @error('esai_soal')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="esai_petunjuk" class="form-label">Petunjuk Jawaban (Opsional)</label>
                                    <textarea class="form-control @error('esai_petunjuk') is-invalid @enderror" 
                                              id="esai_petunjuk" name="esai_petunjuk" rows="3" 
                                              placeholder="Berikan petunjuk atau panduan untuk menjawab pertanyaan...">{{ old('esai_petunjuk') }}</textarea>
                                    <div class="form-text">Petunjuk ini akan membantu siswa dalam menjawab pertanyaan</div>
                                    @error('esai_petunjuk')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Regular Quiz Fields -->
                            <div id="regular-fields">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="durasi" class="form-label">Durasi (menit) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('durasi') is-invalid @enderror" 
                                                   id="durasi" name="durasi" value="{{ old('durasi', 30) }}" 
                                                   min="5" max="180" required>
                                            @error('durasi')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Kuis</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" rows="3" 
                                          placeholder="Masukkan deskripsi kuis (opsional)">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Soal Kuis (Hanya untuk Pilihan Ganda) -->
                    <div class="card mt-4" id="soal-container">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-question-circle me-2"></i>Soal Kuis</h5>
                        </div>
                        <div class="card-body">
                            <div id="questions-container">
                                <!-- Soal akan ditambahkan secara dinamis -->
                            </div>
                            
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-outline-primary" id="add-question">
                                    <i class="fas fa-plus me-2"></i>Tambah Soal
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Kuis
                        </button>
                        <a href="{{ route('guru.kuis.index') }}" class="btn btn-secondary btn-lg ms-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let questionCount = 0;

        // Add question function
        document.getElementById('add-question').addEventListener('click', function() {
            questionCount++;
            addQuestion(questionCount);
        });

        function addQuestion(number) {
            const container = document.getElementById('questions-container');
            const questionDiv = document.createElement('div');
            questionDiv.className = 'question-item';
            questionDiv.innerHTML = `
                <div class="d-flex align-items-start mb-3">
                    <div class="question-number">${number}</div>
                    <div class="flex-grow-1">
                        <label class="form-label fw-bold">Soal ${number}</label>
                        <textarea class="form-control" name="soal[${number}][pertanyaan]" 
                                  placeholder="Masukkan pertanyaan..." rows="2" required></textarea>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm ms-2" onclick="removeQuestion(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Pilihan A</label>
                            <input type="text" class="form-control" name="soal[${number}][pilihan_a]" 
                                   placeholder="Pilihan A" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Pilihan B</label>
                            <input type="text" class="form-control" name="soal[${number}][pilihan_b]" 
                                   placeholder="Pilihan B" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Pilihan C</label>
                            <input type="text" class="form-control" name="soal[${number}][pilihan_c]" 
                                   placeholder="Pilihan C" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Pilihan D</label>
                            <input type="text" class="form-control" name="soal[${number}][pilihan_d]" 
                                   placeholder="Pilihan D" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jawaban Benar</label>
                    <select class="form-select" name="soal[${number}][jawaban_benar]" required>
                        <option value="">Pilih Jawaban Benar</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            `;
            
            container.appendChild(questionDiv);
        }

        function removeQuestion(button) {
            button.closest('.question-item').remove();
            updateQuestionNumbers();
        }

        function updateQuestionNumbers() {
            const questions = document.querySelectorAll('.question-item');
            questions.forEach((question, index) => {
                const numberElement = question.querySelector('.question-number');
                const labelElement = question.querySelector('.form-label.fw-bold');
                const number = index + 1;
                
                numberElement.textContent = number;
                labelElement.textContent = `Soal ${number}`;
                
                // Update input names
                const inputs = question.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/\[\d+\]/, `[${number}]`));
                    }
                });
            });
        }

        // Toggle quiz type function
        function toggleQuizType() {
            const tipeKuis = document.getElementById('tipe_kuis').value;
            const esaiFields = document.getElementById('esai-fields');
            const regularFields = document.getElementById('regular-fields');
            const soalContainer = document.getElementById('soal-container');
            
            if (tipeKuis === 'esai') {
                esaiFields.style.display = 'block';
                regularFields.style.display = 'none';
                soalContainer.style.display = 'none';
            } else if (tipeKuis === 'pilihan_ganda') {
                esaiFields.style.display = 'none';
                regularFields.style.display = 'block';
                soalContainer.style.display = 'block';
            } else {
                esaiFields.style.display = 'none';
                regularFields.style.display = 'none';
                soalContainer.style.display = 'none';
            }
        }


        // YouTube Search Integration
        document.getElementById('search_youtube').addEventListener('click', function() {
            const searchTerm = document.getElementById('youtube_search').value.trim();
            if (!searchTerm) {
                alert('Masukkan kata kunci pencarian!');
                return;
            }
            
            searchYouTubeVideos(searchTerm);
        });
        
        // Clear search button
        document.getElementById('clear_search').addEventListener('click', function() {
            document.getElementById('youtube_search').value = '';
            document.getElementById('youtube_results').style.display = 'none';
            document.getElementById('youtube_welcome').style.display = 'block';
        });
        
        // Enter key search
        document.getElementById('youtube_search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('search_youtube').click();
            }
        });
        
        // Suggested search function
        function searchSuggested(term) {
            document.getElementById('youtube_search').value = term;
            searchYouTubeVideos(term);
        }
        
        function searchYouTubeVideos(query) {
            // Show loading
            const resultsDiv = document.getElementById('youtube_results');
            resultsDiv.innerHTML = '<div class="col-12 text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Mencari video...</p></div>';
            resultsDiv.style.display = 'block';
            
            // Simulate YouTube API search (in real implementation, you would use YouTube Data API)
            // For demo purposes, we'll use mock data
            setTimeout(() => {
                displayMockResults(query);
            }, 1500);
        }
        
        function displayMockResults(query) {
            const resultsDiv = document.getElementById('youtube_results');
            const welcomeDiv = document.getElementById('youtube_welcome');
            
            // Hide welcome screen
            welcomeDiv.style.display = 'none';
            
            // Mock YouTube search results with more educational content
            const mockResults = [
                {
                    id: 'dQw4w9WgXcQ',
                    title: 'Pembelajaran Matematika Dasar - Kelas 7',
                    description: 'Video pembelajaran matematika untuk siswa kelas 7 SMP',
                    thumbnail: 'https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
                    duration: '15:30',
                    channel: 'EduChannel Indonesia',
                    views: '125K views',
                    published: '2 weeks ago'
                },
                {
                    id: 'jNQXAC9IVRw',
                    title: 'Fisika: Hukum Newton - Penjelasan Lengkap',
                    description: 'Penjelasan lengkap tentang hukum Newton dengan contoh praktis',
                    thumbnail: 'https://img.youtube.com/vi/jNQXAC9IVRw/mqdefault.jpg',
                    duration: '22:45',
                    channel: 'Science Academy',
                    views: '89K views',
                    published: '1 month ago'
                },
                {
                    id: 'M7lc1UVf-VE',
                    title: 'Biologi: Sistem Pencernaan Manusia',
                    description: 'Animasi 3D sistem pencernaan manusia untuk pembelajaran biologi',
                    thumbnail: 'https://img.youtube.com/vi/M7lc1UVf-VE/mqdefault.jpg',
                    duration: '18:20',
                    channel: 'Biology Channel',
                    views: '156K views',
                    published: '3 weeks ago'
                },
                {
                    id: 'abc123def456',
                    title: 'Kimia: Asam dan Basa - Konsep Dasar',
                    description: 'Penjelasan konsep asam dan basa dengan eksperimen sederhana',
                    thumbnail: 'https://img.youtube.com/vi/abc123def456/mqdefault.jpg',
                    duration: '12:15',
                    channel: 'Chemistry Lab',
                    views: '67K views',
                    published: '1 week ago'
                },
                {
                    id: 'xyz789ghi012',
                    title: 'Sejarah: Perang Dunia II - Ringkasan Lengkap',
                    description: 'Ringkasan lengkap Perang Dunia II untuk siswa SMA',
                    thumbnail: 'https://img.youtube.com/vi/xyz789ghi012/mqdefault.jpg',
                    duration: '25:30',
                    channel: 'History Channel',
                    views: '234K views',
                    published: '2 months ago'
                },
                {
                    id: 'def456ghi789',
                    title: 'Bahasa Indonesia: Puisi dan Prosa',
                    description: 'Pembelajaran puisi dan prosa untuk siswa kelas 8',
                    thumbnail: 'https://img.youtube.com/vi/def456ghi789/mqdefault.jpg',
                    duration: '20:10',
                    channel: 'Bahasa Indonesia Channel',
                    views: '98K views',
                    published: '5 days ago'
                }
            ];
            
            let html = '';
            mockResults.forEach((video, index) => {
                html += `
                    <div class="youtube-video-card" onclick="selectVideo('${video.id}', '${video.title}', '${video.description}', '${video.thumbnail}', '${video.duration}', '${video.channel}')">
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
        
        function selectVideo(videoId, title, description, thumbnail, duration, channel) {
            // Update hidden fields
            document.getElementById('video_url').value = `https://www.youtube.com/watch?v=${videoId}`;
            document.getElementById('video_title').value = title;
            document.getElementById('video_thumbnail').value = thumbnail;
            
            // Update selected video display
            document.getElementById('selected_thumbnail').src = thumbnail;
            document.getElementById('selected_title').textContent = title;
            document.getElementById('selected_description').textContent = description;
            document.getElementById('selected_duration').textContent = duration;
            
            // Show selected video
            document.getElementById('selected_video').style.display = 'block';
            
            // Scroll to selected video
            document.getElementById('selected_video').scrollIntoView({ behavior: 'smooth' });
            
            // Add visual feedback
            const videoCards = document.querySelectorAll('.video-card');
            videoCards.forEach(card => {
                card.classList.remove('border-primary');
            });
            event.currentTarget.classList.add('border-primary');
        }
        
        // Add first question automatically
        document.addEventListener('DOMContentLoaded', function() {
            addQuestion(1);
            toggleQuizType(); // Initialize based on old value
        });
    </script>
</body>
</html>
