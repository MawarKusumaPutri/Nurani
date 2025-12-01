@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kuis - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                        @if($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="Foto Profil" 
                                 class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
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
                        <h2 class="mb-1">Buat Kuis Baru</h2>
                        <p class="text-muted mb-0">Buat kuis untuk mata pelajaran {{ $guru->mata_pelajaran }}</p>
                    </div>
                    <a href="{{ route('guru.kuis.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <form action="{{ route('guru.kuis.store') }}" method="POST">
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
                                                    @foreach(explode(',', $guru->mata_pelajaran) as $mp)
                                                        <option value="{{ trim($mp) }}" {{ old('mata_pelajaran') == trim($mp) ? 'selected' : '' }}>
                                                            {{ trim($mp) }}
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
                                                <label for="tipe_kuis" class="form-label">Tipe Kuis</label>
                                                <select class="form-select @error('tipe_kuis') is-invalid @enderror" 
                                                        id="tipe_kuis" name="tipe_kuis" onchange="toggleQuizType()">
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
                                                    <option value="7" {{ old('kelas') == '7' ? 'selected' : '' }}>Kelas 7</option>
                                                    <option value="8" {{ old('kelas') == '8' ? 'selected' : '' }}>Kelas 8</option>
                                                    <option value="9" {{ old('kelas') == '9' ? 'selected' : '' }}>Kelas 9</option>
                                                </select>
                                                @error('kelas')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

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
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="external_quiz_url" class="form-label">
                                                    Link Kuis Eksternal (Quizizz, Kahoot, Google Form, dll)
                                                </label>
                                                <input type="url"
                                                       class="form-control @error('external_quiz_url') is-invalid @enderror"
                                                       id="external_quiz_url"
                                                       name="external_quiz_url"
                                                       value="{{ old('external_quiz_url') }}"
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

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tanggal_dibuat" class="form-label">Tanggal Dibuat <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('tanggal_dibuat') is-invalid @enderror" 
                                                       id="tanggal_dibuat" name="tanggal_dibuat" 
                                                       value="{{ old('tanggal_dibuat') }}" 
                                                       placeholder="Pilih Tanggal" required readonly>
                                                @error('tanggal_dibuat')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="hari_dibuat" class="form-label">Hari <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('hari_dibuat') is-invalid @enderror" 
                                                       id="hari_dibuat" name="hari_dibuat" 
                                                       value="{{ old('hari_dibuat') }}" required readonly>
                                                @error('hari_dibuat')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="waktu_dibuat" class="form-label">Waktu <span class="text-danger">*</span></label>
                                                <input type="time" class="form-control @error('waktu_dibuat') is-invalid @enderror" 
                                                       id="waktu_dibuat" name="waktu_dibuat" 
                                                       value="{{ old('waktu_dibuat') }}" required readonly>
                                                @error('waktu_dibuat')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="zona_waktu" class="form-label">Zona Waktu <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('zona_waktu') is-invalid @enderror" 
                                                       id="zona_waktu" name="zona_waktu" 
                                                       value="{{ old('zona_waktu') }}" required readonly>
                                                @error('zona_waktu')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
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

                            <!-- Esai Fields (Hidden by default) -->
                            <div id="esai-fields" style="display: none;">
                                <div class="card mt-4">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Pertanyaan Esai</h5>
                                    </div>
                                    <div class="card-body">
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
                                </div>
                            </div>

                            <!-- Regular Quiz Fields -->
                            <div id="regular-fields" style="display: none;">
                                <div class="card mt-4">
                                    <div class="card-header bg-info text-white">
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
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Buat Kuis
                                </button>
                                <a href="{{ route('guru.kuis.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
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
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Jawaban Benar</label>
                        <select class="form-select" name="soal[${number}][jawaban_benar]" required>
                            <option value="">Pilih Jawaban Benar</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
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
                const labelElement = question.querySelector('label');
                const number = index + 1;
                
                numberElement.textContent = number;
                labelElement.textContent = `Soal ${number}`;
                
                // Update input names
                const inputs = question.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/soal\[\d+\]/, `soal[${number}]`);
                    }
                });
            });
        }

        // Toggle quiz type function
        function toggleQuizType() {
            const tipeKuis = document.getElementById('tipe_kuis').value;
            const esaiFields = document.getElementById('esai-fields');
            const regularFields = document.getElementById('regular-fields');
            const soalContainer = document.getElementById('questions-container');
            
            if (tipeKuis === 'esai') {
                esaiFields.style.display = 'block';
                regularFields.style.display = 'none';
                soalContainer.style.display = 'none';
                // Remove required from hidden fields
                const hiddenFields = regularFields.querySelectorAll('input[required], select[required], textarea[required]');
                hiddenFields.forEach(field => {
                    field.removeAttribute('required');
                });
            } else if (tipeKuis === 'pilihan_ganda') {
                esaiFields.style.display = 'none';
                regularFields.style.display = 'block';
                soalContainer.style.display = 'block';
                // Remove required from hidden fields
                const hiddenFields = esaiFields.querySelectorAll('input[required], select[required], textarea[required]');
                hiddenFields.forEach(field => {
                    field.removeAttribute('required');
                });
            } else {
                // Tipe kuis tidak dipilih (hanya link eksternal)
                esaiFields.style.display = 'none';
                regularFields.style.display = 'none';
                soalContainer.style.display = 'none';
                // Remove required from all hidden fields
                const allHiddenFields = document.querySelectorAll('#esai-fields input[required], #esai-fields select[required], #esai-fields textarea[required], #regular-fields input[required], #regular-fields select[required], #regular-fields textarea[required]');
                allHiddenFields.forEach(field => {
                    field.removeAttribute('required');
                });
            }
        }

        // Function to get timezone abbreviation
        function getTimezoneAbbreviation() {
            const now = new Date();
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            
            // Map common timezones to WIB, WIT, WITA
            if (timezone.includes('Jakarta') || timezone.includes('Asia/Jakarta')) {
                return 'WIB';
            } else if (timezone.includes('Makassar') || timezone.includes('Asia/Makassar') || timezone.includes('Ujung_Pandang')) {
                return 'WITA';
            } else if (timezone.includes('Jayapura') || timezone.includes('Asia/Jayapura')) {
                return 'WIT';
            }
            
            // Fallback: determine by UTC offset
            const offset = -now.getTimezoneOffset() / 60;
            if (offset === 7) return 'WIB';
            if (offset === 8) return 'WITA';
            if (offset === 9) return 'WIT';
            
            // Default to WIB if cannot determine
            return 'WIB';
        }

        // Function to get day name in Indonesian
        function getDayName(date) {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            return days[date.getDay()];
        }

        // Initialize Flatpickr date picker
        let flatpickrInstance;
        
        function initializeDatePicker() {
            const tanggalInput = document.getElementById('tanggal_dibuat');
            const now = new Date();
            const defaultDate = now.toISOString().split('T')[0]; // Format: YYYY-MM-DD
            
            // Set default value
            tanggalInput.value = defaultDate;
            
            // Initialize Flatpickr with Indonesian locale
            flatpickrInstance = flatpickr(tanggalInput, {
                dateFormat: "Y-m-d",
                defaultDate: defaultDate,
                minDate: "today",
                maxDate: new Date().fp_incr(30), // 30 days from today
                locale: "id", // Use Indonesian locale
                firstDayOfWeek: 1, // Start week on Monday
                onChange: function(selectedDates, dateStr, instance) {
                    // Update hari dropdown when date changes
                    if (dateStr) {
                        const selectedDate = new Date(dateStr);
                        const hariNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        const hari = hariNama[selectedDate.getDay()];
                        document.getElementById('hari_dibuat').value = hari;
                    }
                }
            });
        }
        

        // Function to set initial day based on current date
        function setInitialDay() {
            const tanggalInput = document.getElementById('tanggal_dibuat');
            const hariInput = document.getElementById('hari_dibuat');
            
            if (tanggalInput.value) {
                const selectedDate = new Date(tanggalInput.value);
                const hariNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const hari = hariNama[selectedDate.getDay()];
                hariInput.value = hari;
            }
        }

        // Function to update date, day, time fields
        function updateDateTimeFields() {
            const now = new Date();
            const timezone = getTimezoneAbbreviation();
            
            // Get time in local timezone
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const timeString = `${hours}:${minutes}`;
            
            // Update time and timezone fields
            document.getElementById('waktu_dibuat').value = timeString;
            document.getElementById('zona_waktu').value = timezone;
        }

        // Form submit handler to remove required from hidden fields
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action*="kuis.store"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const tipeKuis = document.getElementById('tipe_kuis').value;
                    
                    // If tipe_kuis is not selected, remove required from all quiz type fields
                    if (!tipeKuis || tipeKuis === '') {
                        const allQuizFields = document.querySelectorAll('#esai-fields input[required], #esai-fields select[required], #esai-fields textarea[required], #regular-fields input[required], #regular-fields select[required], #regular-fields textarea[required]');
                        allQuizFields.forEach(field => {
                            field.removeAttribute('required');
                        });
                    }
                    
                    // If tipe_kuis is esai, remove required from regular fields
                    if (tipeKuis === 'esai') {
                        const regularFields = document.querySelectorAll('#regular-fields input[required], #regular-fields select[required], #regular-fields textarea[required]');
                        regularFields.forEach(field => {
                            field.removeAttribute('required');
                        });
                    }
                    
                    // If tipe_kuis is pilihan_ganda, remove required from esai fields
                    if (tipeKuis === 'pilihan_ganda') {
                        const esaiFields = document.querySelectorAll('#esai-fields input[required], #esai-fields select[required], #esai-fields textarea[required]');
                        esaiFields.forEach(field => {
                            field.removeAttribute('required');
                        });
                    }
                });
            }
        });

        // Add first question automatically and update date/time
        document.addEventListener('DOMContentLoaded', function() {
            addQuestion(1);
            toggleQuizType(); // Initialize based on old value
            initializeDatePicker(); // Initialize date picker with calendar
            setTimeout(function() {
                setInitialDay(); // Set initial day based on current date
            }, 200);
            updateDateTimeFields(); // Set initial time and timezone
            
            // Update time every second for real-time display
            setInterval(updateDateTimeFields, 1000);
        });
    </script>
</body>
</html>
