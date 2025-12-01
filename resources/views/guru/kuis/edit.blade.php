<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kuis - {{ $kuis->judul }}</title>
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
            cursor: pointer;
            pointer-events: auto;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
            transform: translateY(-1px);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
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
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Edit Kuis</h2>
                        <p class="text-muted mb-0">Perbarui informasi kuis dan soal</p>
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

                <form action="{{ route('guru.kuis.update', $kuis) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Informasi Kuis</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Kuis <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                               id="judul" name="judul" value="{{ old('judul', $kuis->judul) }}" 
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
                                                $subjects = explode(', ', $kuis->guru->mata_pelajaran);
                                            @endphp
                                            @foreach($subjects as $subject)
                                                <option value="{{ trim($subject) }}" {{ old('mata_pelajaran', $kuis->mata_pelajaran) == trim($subject) ? 'selected' : '' }}>
                                                    {{ trim($subject) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('mata_pelajaran')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="link_kuis" class="form-label">Link Kuis (Quizizz, Kahoot, dll)</label>
                                                <input type="url" class="form-control @error('link_kuis') is-invalid @enderror"
                                                       id="link_kuis" name="link_kuis"
                                                       value="{{ old('link_kuis', $kuis->link_kuis) }}"
                                                       placeholder="https://quizizz.com/..., https://kahoot.it/..., dsb">
                                                <div class="form-text">
                                                    Opsional. Jika diisi, siswa akan diarahkan ke link ini saat mengerjakan kuis.
                                                </div>
                                                @error('link_kuis')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipe_kuis" class="form-label">Tipe Kuis</label>
                                        <select class="form-select @error('tipe_kuis') is-invalid @enderror" 
                                                id="tipe_kuis" name="tipe_kuis" onchange="toggleQuizType()">
                                            <option value="">Pilih Tipe Kuis</option>
                                            <option value="pilihan_ganda" {{ old('tipe_kuis', $kuis->tipe_kuis) == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                                            <option value="esai" {{ old('tipe_kuis', $kuis->tipe_kuis) == 'esai' ? 'selected' : '' }}>Esai</option>
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
                                            <option value="7" {{ old('kelas', $kuis->kelas) == '7' || old('kelas', $kuis->kelas) == 'VII' ? 'selected' : '' }}>Kelas 7</option>
                                            <option value="8" {{ old('kelas', $kuis->kelas) == '8' || old('kelas', $kuis->kelas) == 'VIII' ? 'selected' : '' }}>Kelas 8</option>
                                            <option value="9" {{ old('kelas', $kuis->kelas) == '9' || old('kelas', $kuis->kelas) == 'IX' ? 'selected' : '' }}>Kelas 9</option>
                                        </select>
                                        @error('kelas')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Video Fields -->
                            <div id="video-fields" style="display: {{ old('tipe_kuis', $kuis->tipe_kuis) == 'video' ? 'block' : 'none' }};">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="video_url" class="form-label">URL Video YouTube <span class="text-danger">*</span></label>
                                            <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                                   id="video_url" name="video_url" value="{{ old('video_url', $kuis->video_url) }}" 
                                                   placeholder="https://www.youtube.com/watch?v=...">
                                            <div class="form-text">Masukkan URL lengkap video YouTube</div>
                                            @error('video_url')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="external_quiz_url" class="form-label">
                                                    Link Kuis Eksternal (Quizizz, Kahoot, Google Form, dll)
                                                </label>
                                                <input type="url"
                                                       class="form-control @error('external_quiz_url') is-invalid @enderror"
                                                       id="external_quiz_url"
                                                       name="external_quiz_url"
                                                       value="{{ old('external_quiz_url', $kuis->external_quiz_url) }}"
                                                       placeholder="https://quizizz.com/..., https://kahoot.it/..., atau link kuis lainnya">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Opsional. Jika diisi, siswa dapat langsung diarahkan ke link kuis ini.
                                                </small>
                                                @error('external_quiz_url')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="durasi_video" class="form-label">Durasi (menit) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('durasi') is-invalid @enderror" 
                                                   id="durasi_video" name="durasi" value="{{ old('durasi', $kuis->durasi_menit) }}" 
                                                   min="5" max="180" required>
                                            @error('durasi')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="video_soal" class="form-label">Pertanyaan Video <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('video_soal') is-invalid @enderror" 
                                              id="video_soal" name="video_soal" rows="4" 
                                              placeholder="Buat pertanyaan berdasarkan video yang akan ditonton siswa...">{{ old('video_soal', $kuis->video_soal) }}</textarea>
                                    <div class="form-text">Buat pertanyaan yang berkaitan dengan isi video</div>
                                    @error('video_soal')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Regular Quiz Fields -->
                            <div id="regular-fields" style="display: {{ old('tipe_kuis', $kuis->tipe_kuis) == 'pilihan_ganda' ? 'block' : 'none' }};">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="durasi_regular" class="form-label">Durasi (menit) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('durasi') is-invalid @enderror" 
                                                   id="durasi_regular" name="durasi" value="{{ old('durasi', $kuis->durasi_menit) }}" 
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
                                          placeholder="Masukkan deskripsi kuis (opsional)">{{ old('deskripsi', $kuis->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Soal Kuis (Hanya untuk Pilihan Ganda) -->
                    <div class="card mt-4" id="soal-container" style="display: {{ old('tipe_kuis', $kuis->tipe_kuis) == 'pilihan_ganda' ? 'block' : 'none' }};">
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
                            <i class="fas fa-save me-2"></i>Update Kuis
                        </button>
                        <a href="{{ route('guru.kuis.show', $kuis) }}" class="btn btn-secondary btn-lg ms-2">
                            <i class="fas fa-eye me-2"></i>Lihat Kuis
                        </a>
                        <a href="{{ route('guru.kuis.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
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
            const videoFields = document.getElementById('video-fields');
            const regularFields = document.getElementById('regular-fields');
            const soalContainer = document.getElementById('soal-container');
            
            if (tipeKuis === 'video') {
                videoFields.style.display = 'block';
                regularFields.style.display = 'none';
                soalContainer.style.display = 'none';
                
                // Remove required from hidden fields
                const hiddenFields = soalContainer.querySelectorAll('input[required], select[required], textarea[required]');
                hiddenFields.forEach(field => {
                    field.removeAttribute('required');
                });
            } else if (tipeKuis === 'pilihan_ganda') {
                videoFields.style.display = 'none';
                regularFields.style.display = 'block';
                soalContainer.style.display = 'block';
                
                // Remove required from hidden fields
                const hiddenFields = videoFields.querySelectorAll('input[required], select[required], textarea[required]');
                hiddenFields.forEach(field => {
                    field.removeAttribute('required');
                });
            } else {
                videoFields.style.display = 'none';
                regularFields.style.display = 'none';
                soalContainer.style.display = 'none';
                
                // Remove required from all hidden fields
                const allHiddenFields = document.querySelectorAll('#video-fields input[required], #video-fields select[required], #video-fields textarea[required], #soal-container input[required], #soal-container select[required], #soal-container textarea[required]');
                allHiddenFields.forEach(field => {
                    field.removeAttribute('required');
                });
            }
        }

        // Load existing questions if it's a multiple choice quiz
        document.addEventListener('DOMContentLoaded', function() {
            @if($kuis->tipe_kuis === 'pilihan_ganda' && $kuis->soal)
                const existingQuestions = @json(json_decode($kuis->soal, true));
                if (existingQuestions && existingQuestions.length > 0) {
                    existingQuestions.forEach((soal, index) => {
                        questionCount++;
                        addQuestion(questionCount);
                        
                        // Fill in the form with existing data
                        const questionItem = document.querySelectorAll('.question-item')[index];
                        if (questionItem) {
                            questionItem.querySelector('textarea[name*="pertanyaan"]').value = soal.pertanyaan || '';
                            questionItem.querySelector('input[name*="pilihan_a"]').value = soal.pilihan?.A || '';
                            questionItem.querySelector('input[name*="pilihan_b"]').value = soal.pilihan?.B || '';
                            questionItem.querySelector('input[name*="pilihan_c"]').value = soal.pilihan?.C || '';
                            questionItem.querySelector('input[name*="pilihan_d"]').value = soal.pilihan?.D || '';
                            questionItem.querySelector('select[name*="jawaban_benar"]').value = soal.jawaban_benar || '';
                        }
                    });
                } else {
                    addQuestion(1);
                }
            @else
                addQuestion(1);
            @endif
            
            toggleQuizType(); // Initialize based on current value
        });

        // Ensure button is clickable and form can submit
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.querySelector('button[type="submit"]');
            const form = document.querySelector('form');
            
            console.log('Submit button found:', submitButton);
            console.log('Form found:', form);
            
            // Make sure button is clickable
            if (submitButton) {
                submitButton.style.pointerEvents = 'auto';
                submitButton.style.cursor = 'pointer';
                submitButton.disabled = false;
                
                // Add click event listener
                submitButton.addEventListener('click', function(e) {
                    console.log('Submit button clicked');
                    // Don't prevent default, let form submit normally
                });
            }
            
            // Ensure form can submit
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submitting...');
                    // Don't prevent default, let form submit normally
                });
            }
        });
    </script>
</body>
</html>
