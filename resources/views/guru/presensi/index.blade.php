@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Guru - {{ $guru->user->name }}</title>
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
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        #sidebar {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        .sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        #sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
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
        .presensi-type-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .presensi-type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .presensi-type-card.active {
            border-color: #2E7D32;
            background: #F0F4F0;
        }
        .badge-hadir { background: #28a745; }
        .badge-sakit { background: #dc3545; }
        .badge-izin { background: #ffc107; color: #000; }
        .badge-pending { background: #6c757d; }
        .badge-approved { background: #28a745; }
        .badge-rejected { background: #dc3545; }
        
        /* Responsive Styles */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 9999;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            cursor: pointer;
            pointer-events: auto;
            touch-action: manipulation;
        }
        
        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
            transform: scale(1.05);
        }
        
        .sidebar-toggle:active {
            transform: scale(0.95);
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.05) !important;
            z-index: 1040;
            transition: background 0.3s ease;
        }
        
        .sidebar-overlay.show {
            background: rgba(0,0,0,0.05) !important;
            z-index: 1040 !important;
        }
        
        /* Pastikan sidebar lebih tinggi dari overlay dan hijau terang */
        .sidebar.show {
            z-index: 1061 !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        #sidebar.show {
            z-index: 1061 !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        /* Pastikan semua elemen di sidebar tidak hitam */
        .sidebar * {
            background-color: transparent !important;
        }
        
        .sidebar .p-4 {
            background: transparent !important;
        }
        
        .sidebar nav {
            background: transparent !important;
        }
        
        .sidebar .nav {
            background: transparent !important;
        }
        
        .sidebar .nav-link {
            background: transparent !important;
            background-color: transparent !important;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1) !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Make sure nav links are always clickable */
        .sidebar .nav-link {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            position: relative !important;
            display: block !important;
            touch-action: manipulation !important;
        }
        
        .sidebar .nav-link:hover {
            pointer-events: auto !important;
            background: rgba(255, 255, 255, 0.1) !important;
        }
        
        .sidebar .nav-link:active {
            pointer-events: auto !important;
        }
        
        /* Ensure sidebar is always above overlay */
        .sidebar.show {
            z-index: 1061 !important;
        }
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block !important;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1061 !important;
                transition: left 0.3s ease;
                width: 280px;
                max-width: 85%;
                height: 100vh;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
                overscroll-behavior: contain !important;
                pointer-events: auto !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            .sidebar.show {
                left: 0;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            .sidebar-overlay.show {
                display: block;
                background: rgba(0,0,0,0.05) !important;
                z-index: 1040 !important;
            }
            
            /* Pastikan semua elemen di sidebar tidak hitam di mobile */
            .sidebar * {
                background-color: transparent !important;
            }
            
            .sidebar .p-4 {
                background: transparent !important;
            }
            
            .sidebar nav {
                background: transparent !important;
            }
            
            .sidebar .nav {
                background: transparent !important;
            }
            
            .sidebar .nav-link {
                background: transparent !important;
                background-color: transparent !important;
            }
            
            .sidebar .nav-link:hover, .sidebar .nav-link.active {
                background: rgba(255, 255, 255, 0.1) !important;
                background-color: rgba(255, 255, 255, 0.1) !important;
            }
            
            /* Ensure sidebar is always clickable when shown */
            .sidebar.show {
                pointer-events: auto !important;
            }
            
            .sidebar.show * {
                pointer-events: auto !important;
            }
            
            .col-md-9.col-lg-10 {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid" style="position: relative; z-index: 1;">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0" id="sidebar" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important; background-color: #2E7D32 !important;">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Dashboard Guru
                    </h4>
                    <div class="text-center mb-4">
                        @php
                            // SELALU ambil data fresh dari database untuk memastikan foto terbaru
                            $freshGuru = \App\Models\Guru::find($guru->id);
                            $photoUrl = null;
                            
                            if ($freshGuru && !empty($freshGuru->foto)) {
                                // OTOMATIS cari foto dengan default path yang benar
                                $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                
                                // Jika masih null, coba dengan path lain
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
                                }
                                
                                // Jika masih null, coba langsung dengan asset() untuk URL lengkap
                                if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                                    $photoUrl = asset('storage/' . $freshGuru->foto) . '?v=' . time() . '&r=' . rand(1000, 9999);
                                }
                            }
                            $hasPhoto = $photoUrl !== null && $photoUrl !== '';
                        @endphp
                        @if($hasPhoto && $photoUrl)
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <img src="{{ $photoUrl }}" alt="Foto Profil" id="profile-photo-img-guru-presensi" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder-guru-presensi').style.display='flex';">
                                <div id="profile-placeholder-guru-presensi" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 100px; height: 100px; top: 0; left: 0; z-index: 1;">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran ?? 'Mata Pelajaran' }}</small>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('guru.dashboard') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('guru.jadwal.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Mengajar
                    </a>
                    <a class="nav-link active" href="{{ route('guru.presensi.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-calendar-check me-2"></i> Presensi Guru
                    </a>
                    <a class="nav-link" href="{{ route('guru.presensi-siswa.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
                    </a>
                    <a class="nav-link" href="{{ route('guru.materi.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-book me-2"></i> Materi
                    </a>
                    <a class="nav-link" href="{{ route('guru.kuis.index') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-question-circle me-2"></i> Kuis
                    </a>
                    <hr class="text-white-50">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="closeSidebar(); return true;">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4">
                    <i class="fas fa-calendar-check text-success me-2"></i>
                    Presensi Guru
                </h2>

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

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                            <div>
                                <strong>Periksa kembali formulir presensi:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-calendar-check me-2 text-primary"></i>
                            Presensi Guru
                        </h2>
                        <p class="text-muted mb-0">Kelola presensi Anda untuk berbagai tanggal</p>
                    </div>
                </div>

                <!-- Button Tambah Presensi -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-0">Manajemen Presensi</h4>
                        <p class="text-muted mb-0">Kelola presensi Anda untuk berbagai tanggal</p>
                    </div>
                    <button type="button" class="btn btn-success" onclick="togglePresensiForm()" id="btnTambahPresensi">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Presensi
                    </button>
                </div>

                <!-- Presensi Form -->
                <div class="card mb-4" id="presensiFormCard" style="display: none;">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Presensi Baru
                                <small class="d-block mt-1" style="font-size: 0.85rem; opacity: 0.9;">
                                    <i class="fas fa-info-circle me-1"></i>Anda dapat melakukan presensi untuk berbagai tanggal dengan jenis berbeda (Hadir, Sakit, atau Izin)
                                </small>
                            </h5>
                        </div>
                        <button type="button" class="btn btn-light btn-sm" onclick="togglePresensiForm()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('guru.presensi.store') }}" method="POST" id="presensiForm" enctype="multipart/form-data">
                            @csrf
                            @php
                                $defaultJenis = old('jenis', 'hadir');
                            @endphp
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" class="form-control" 
                                           value="{{ old('tanggal', date('Y-m-d')) }}" 
                                           max="{{ date('Y-m-d') }}" 
                                           id="tanggalPresensi"
                                           required>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>Pilih tanggal presensi. Setiap tanggal hanya bisa diisi sekali.
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Presensi <span class="text-danger">*</span></label>
                                <small class="text-muted d-block mb-2">
                                    <i class="fas fa-info-circle me-1"></i>Pilih jenis presensi sesuai kondisi hari ini. Setiap hari bisa berbeda jenisnya.
                                </small>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card presensi-type-card mb-2" onclick="selectPresensiType('hadir')" id="card-hadir">
                                            <div class="card-body text-center">
                                                <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                                                <h6>Hadir</h6>
                                                <input type="radio" name="jenis" value="hadir" id="jenis-hadir" class="d-none" {{ old('jenis', 'hadir') === 'hadir' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card presensi-type-card mb-2" onclick="selectPresensiType('sakit')" id="card-sakit">
                                            <div class="card-body text-center">
                                                <i class="fas fa-user-injured fa-3x text-danger mb-2"></i>
                                                <h6>Sakit</h6>
                                                <input type="radio" name="jenis" value="sakit" id="jenis-sakit" class="d-none" {{ old('jenis') === 'sakit' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card presensi-type-card mb-2" onclick="selectPresensiType('izin')" id="card-izin">
                                            <div class="card-body text-center">
                                                <i class="fas fa-file-alt fa-3x text-warning mb-2"></i>
                                                <h6>Izin</h6>
                                                <input type="radio" name="jenis" value="izin" id="jenis-izin" class="d-none" {{ old('jenis') === 'izin' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="jam-section" class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jam Masuk <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="time" name="jam_masuk" class="form-control" 
                                               id="jam_masuk" value="{{ old('jam_masuk') }}" required>
                                        <button type="button" class="btn btn-outline-success" onclick="setCurrentTime('jam_masuk')" title="Gunakan waktu saat ini">
                                            <i class="fas fa-clock"></i> Sekarang
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        <span id="jamMasukInfo">Klik tombol "Sekarang" untuk mengisi otomatis dengan waktu saat ini</span>
                                        <span id="jamMasukSakitInfo" style="display: none;">Jam masuk akan otomatis terisi untuk menunjukkan waktu mulai sakit</span>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jam Keluar</label>
                                    <div class="input-group">
                                        <input type="time" name="jam_keluar" class="form-control" 
                                               id="jam_keluar" value="{{ old('jam_keluar') }}">
                                        <button type="button" class="btn btn-outline-success" onclick="setCurrentTime('jam_keluar')" title="Gunakan waktu saat ini">
                                            <i class="fas fa-clock"></i> Sekarang
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> Klik tombol "Sekarang" untuk mengisi otomatis dengan waktu saat ini
                                    </small>
                                </div>
                            </div>

                            <div id="keterangan-section" class="mb-3" style="display: none;">
                                <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" 
                                          placeholder="Masukkan alasan izin..." id="keterangan">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="surat-sakit-section" class="mb-3" style="display: none;">
                                <label class="form-label">
                                    Surat Dokter / Surat Sakit 
                                    <span class="badge bg-info text-white ms-2">
                                        <i class="fas fa-info-circle me-1"></i>Opsional
                                    </span>
                                </label>
                                <input type="file" name="surat_sakit" id="surat_sakit" 
                                       class="form-control @error('surat_sakit') is-invalid @enderror" 
                                       accept=".pdf,.png,.jpg,.jpeg">
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Format yang didukung: PDF, PNG, JPG, JPEG (Maksimal 5MB)
                                </small>
                                @error('surat_sakit')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div id="surat-sakit-preview" class="mt-2" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-file me-2"></i>
                                        <span id="surat-sakit-filename"></span>
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearSuratSakit()">
                                            <i class="fas fa-times"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="tugas-section" class="mb-4" style="display: none;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <label class="form-label mb-1">
                                            Tugas Pengganti Untuk Siswa <span class="text-danger">*</span>
                                        </label>
                                        <p class="text-muted mb-2" id="tugas-hint">
                                            Ketika guru sakit atau izin, wajib memberikan instruksi tugas/LKS untuk kelas yang diajar (kelas 7, 8, dan/atau 9).
                                            Minimal isi salah satu kelas agar siswa tetap memiliki kegiatan belajar.
                                        </p>
                                    </div>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-book me-1"></i> Wajib saat sakit/izin
                                    </span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="card border-success shadow-sm h-100">
                                            <div class="card-header bg-success text-white py-2">
                                                <strong>Kelas 7</strong>
                                            </div>
                                            <div class="card-body">
                                                <textarea name="tugas_kelas_7" id="tugas_kelas_7" rows="3"
                                                          class="form-control tugas-textarea @error('tugas_kelas_7') is-invalid @enderror"
                                                          placeholder="Contoh: Kerjakan LKS hal. 15-20 dan rangkum materi bab 2.">{{ old('tugas_kelas_7') }}</textarea>
                                                @error('tugas_kelas_7')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-success shadow-sm h-100">
                                            <div class="card-header bg-success text-white py-2">
                                                <strong>Kelas 8</strong>
                                            </div>
                                            <div class="card-body">
                                                <textarea name="tugas_kelas_8" id="tugas_kelas_8" rows="3"
                                                          class="form-control tugas-textarea @error('tugas_kelas_8') is-invalid @enderror"
                                                          placeholder="Contoh: Buat catatan materi baru dan kerjakan latihan 3.">{{ old('tugas_kelas_8') }}</textarea>
                                                @error('tugas_kelas_8')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-success shadow-sm h-100">
                                            <div class="card-header bg-success text-white py-2">
                                                <strong>Kelas 9</strong>
                                            </div>
                                            <div class="card-body">
                                                <textarea name="tugas_kelas_9" id="tugas_kelas_9" rows="3"
                                                          class="form-control tugas-textarea @error('tugas_kelas_9') is-invalid @enderror"
                                                          placeholder="Contoh: Selesaikan paket ujian bab 4 dan kumpulkan besok.">{{ old('tugas_kelas_9') }}</textarea>
                                                @error('tugas_kelas_9')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-lightbulb me-1 text-warning"></i>
                                    Kosongkan kelas yang tidak membutuhkan tugas. Sistem akan otomatis menyimpan kelas yang diisi saja.
                                </small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Presensi
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="togglePresensiForm()">
                                    <i class="fas fa-times me-2"></i>Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Status Presensi Hari Ini -->
                @if($todayPresensi)
                <div class="alert alert-{{ $todayPresensi->status_verifikasi === 'pending' ? 'warning' : ($todayPresensi->status_verifikasi === 'approved' ? 'success' : 'danger') }}">
                    <i class="fas fa-{{ $todayPresensi->status_verifikasi === 'pending' ? 'clock' : ($todayPresensi->status_verifikasi === 'approved' ? 'check-circle' : 'times-circle') }} me-2"></i>
                    Anda sudah melakukan presensi untuk <strong>hari ini ({{ $todayPresensi->tanggal->format('d/m/Y') }})</strong> sebagai <strong>{{ ucfirst($todayPresensi->jenis) }}</strong>.
                    <br><strong>Status:</strong> 
                    @if($todayPresensi->status_verifikasi === 'pending')
                        <span class="badge badge-pending">Menunggu Verifikasi</span>
                        <small class="d-block mt-2 text-muted">
                            <i class="fas fa-info-circle me-1"></i>Status akan otomatis terbarui setelah TU melakukan verifikasi.
                        </small>
                    @elseif($todayPresensi->status_verifikasi === 'approved')
                        <span class="badge badge-approved">Disetujui</span>
                        @if($todayPresensi->verified_at)
                            <small class="d-block mt-2 text-muted">
                                Diverifikasi pada: {{ $todayPresensi->verified_at->format('d/m/Y H:i') }}
                            </small>
                        @endif
                    @else
                        <span class="badge badge-rejected">Ditolak</span>
                        @if($todayPresensi->verified_at)
                            <small class="d-block mt-2 text-muted">
                                Ditolak pada: {{ $todayPresensi->verified_at->format('d/m/Y H:i') }}
                            </small>
                        @endif
                    @endif
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Anda masih bisa menambah presensi untuk tanggal lain menggunakan tombol "Tambah Presensi" di atas.
                        </small>
                    </div>
                    @if(in_array($todayPresensi->jenis, ['sakit', 'izin']) && ($todayPresensi->tugas_kelas_7 || $todayPresensi->tugas_kelas_8 || $todayPresensi->tugas_kelas_9))
                        <div class="mt-3">
                            <strong>Tugas Pengganti:</strong>
                            <ul class="mb-0">
                                @if($todayPresensi->tugas_kelas_7)
                                    <li>Kelas 7: {{ $todayPresensi->tugas_kelas_7 }}</li>
                                @endif
                                @if($todayPresensi->tugas_kelas_8)
                                    <li>Kelas 8: {{ $todayPresensi->tugas_kelas_8 }}</li>
                                @endif
                                @if($todayPresensi->tugas_kelas_9)
                                    <li>Kelas 9: {{ $todayPresensi->tugas_kelas_9 }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    @if($todayPresensi->surat_sakit)
                        <div class="mt-3">
                            <strong>Surat Sakit:</strong>
                            <a href="{{ Storage::url($todayPresensi->surat_sakit) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary ms-2">
                                <i class="fas fa-file-pdf me-1"></i>Lihat Surat
                            </a>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Presensi History -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Presensi (30 Hari Terakhir)
                        </h5>
                        <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">
                            <i class="fas fa-info-circle me-1"></i>Lihat semua presensi Anda dengan berbagai jenis (Hadir, Sakit, Izin)
                        </small>
                    </div>
                    <div class="card-body">
                        @if($presensiHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Keterangan</th>
                                        <th>Tugas Pengganti</th>
                                        <th>Surat Sakit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensiHistory as $p)
                                    <tr>
                                        <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                                        <td>
                                            @if($p->jenis === 'hadir')
                                                <span class="badge badge-hadir text-white">Hadir</span>
                                            @elseif($p->jenis === 'sakit')
                                                <span class="badge badge-sakit text-white">Sakit</span>
                                            @else
                                                <span class="badge badge-izin">Izin</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->jam_masuk)
                                                @if($p->jenis === 'sakit')
                                                    <span class="badge bg-danger text-white">{{ date('H:i', strtotime($p->jam_masuk)) }}</span>
                                                    <small class="text-muted d-block">Mulai sakit</small>
                                                @else
                                                    {{ date('H:i', strtotime($p->jam_masuk)) }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $p->jam_keluar ? date('H:i', strtotime($p->jam_keluar)) : '-' }}</td>
                                        <td>
                                            {{ $p->keterangan ?? '-' }}
                                            @php
                                                $tugasList = collect([
                                                    'Kelas 7' => $p->tugas_kelas7,
                                                    'Kelas 8' => $p->tugas_kelas8,
                                                    'Kelas 9' => $p->tugas_kelas9,
                                                ])->filter(fn($value) => !empty($value));
                                            @endphp
                                            @if($tugasList->count() > 0)
                                                <div class="mt-2">
                                                    <span class="badge bg-success text-white">
                                                        <i class="fas fa-book-reader me-1"></i> Tugas Pengganti
                                                    </span>
                                                    <ul class="mt-2 mb-0 ps-3 text-muted small">
                                                        @foreach($tugasList as $kelas => $tugas)
                                                            <li><strong>{{ $kelas }}:</strong> {{ $tugas }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->tugas_kelas_7 || $p->tugas_kelas_8 || $p->tugas_kelas_9)
                                                <ul class="mb-0 ps-3">
                                                    @if($p->tugas_kelas_7)
                                                        <li><strong>Kelas 7:</strong> {{ $p->tugas_kelas_7 }}</li>
                                                    @endif
                                                    @if($p->tugas_kelas_8)
                                                        <li><strong>Kelas 8:</strong> {{ $p->tugas_kelas_8 }}</li>
                                                    @endif
                                                    @if($p->tugas_kelas_9)
                                                        <li><strong>Kelas 9:</strong> {{ $p->tugas_kelas_9 }}</li>
                                                    @endif
                                                </ul>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->surat_sakit)
                                                <a href="{{ Storage::url($p->surat_sakit) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf me-1"></i>Lihat Surat
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->status_verifikasi === 'pending')
                                                <span class="badge badge-pending text-white">Menunggu</span>
                                            @elseif($p->status_verifikasi === 'approved')
                                                <span class="badge badge-approved text-white">Disetujui</span>
                                            @else
                                                <span class="badge badge-rejected text-white">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                            Belum ada riwayat presensi
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const isOpen = sidebar.classList.contains('show');
            
            if (isOpen) {
                // Close sidebar
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (overlay) overlay.style.display = 'none';
                // Enable body scroll when sidebar is closed
                document.body.style.overflow = '';
                document.body.style.position = '';
                document.body.style.width = '';
                document.body.style.height = '';
                document.body.style.top = '';
                document.body.style.background = '#ffffff';
                document.body.style.backgroundColor = '#ffffff';
            } else {
                // Open sidebar
                sidebar.classList.add('show');
                overlay.classList.add('show');
                if (overlay) overlay.style.display = 'block';
                // Prevent body scroll when sidebar is open
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (window.innerWidth <= 991) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (overlay) overlay.style.display = 'none';
            }
            // Always reset body styles regardless of screen size
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        }
        
        // Ensure body has white background on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        });
        
        // Close sidebar when clicking outside on mobile
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
            });
        }
        
        // Robust function to setup nav links
        function setupNavLinks() {
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(function(link) {
                // Force styles dengan !important
                link.style.setProperty('pointer-events', 'auto', 'important');
                link.style.setProperty('cursor', 'pointer', 'important');
                link.style.setProperty('z-index', '1001', 'important');
                link.style.setProperty('position', 'relative', 'important');
                link.style.setProperty('display', 'block', 'important');
                link.style.setProperty('touch-action', 'manipulation', 'important');
                
                // Remove existing listeners by cloning
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);
                
                // Add click event listener
                newLink.addEventListener('click', function(e) {
                    console.log('Nav link clicked:', newLink.href);
                    const href = newLink.getAttribute('href');
                    
                    if (href && href !== '#' && href !== 'javascript:void(0)') {
                        closeSidebar();
                        // Biarkan browser navigate secara normal
                    } else {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }, { capture: false });
                
                // Add touch event listener untuk mobile
                newLink.addEventListener('touchend', function(e) {
                    console.log('Nav link touched:', newLink.href);
                    const href = newLink.getAttribute('href');
                    
                    if (href && href !== '#' && href !== 'javascript:void(0)') {
                        closeSidebar();
                        window.location.href = href;
                        e.preventDefault();
                        return false;
                    }
                }, { capture: false });
            });
        }
        
        // Setup nav links saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            setupNavLinks();
            
            // Setup ulang setelah sidebar dibuka
            const observer = new MutationObserver(function(mutations) {
                setupNavLinks();
            });
            
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                observer.observe(sidebar, {
                    childList: true,
                    subtree: true
                });
            }
        });
        
        // Existing presensi functions
        const defaultPresensiType = @json(old('jenis', 'hadir'));
        const formHasErrors = @json($errors->any());

        function selectPresensiType(type) {
            // Remove active class from all cards
            document.querySelectorAll('.presensi-type-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Uncheck all radios
            document.querySelectorAll('input[name="jenis"]').forEach(radio => {
                radio.checked = false;
            });
            
            // Activate selected card and radio
            document.getElementById('card-' + type).classList.add('active');
            document.getElementById('jenis-' + type).checked = true;
            
            // Show/hide sections based on type
            const jamSection = document.getElementById('jam-section');
            const keteranganSection = document.getElementById('keterangan-section');
            const jamMasuk = document.getElementById('jam_masuk');
            const keterangan = document.getElementById('keterangan');
            const tugasSection = document.getElementById('tugas-section');
            const suratSakitSection = document.getElementById('surat-sakit-section');
            const tugasTextareas = document.querySelectorAll('.tugas-textarea');
            const requiresTugas = (type === 'sakit' || type === 'izin');
            const requiresSuratSakit = (type === 'sakit'); // Hanya untuk sakit, bukan izin
            
            if (tugasSection) {
                tugasSection.style.display = requiresTugas ? 'block' : 'none';
                if (!requiresTugas) {
                    tugasTextareas.forEach(textarea => textarea.value = '');
                }
            }
            
            // Show/hide surat sakit section
            if (suratSakitSection) {
                suratSakitSection.style.display = requiresSuratSakit ? 'block' : 'none';
                if (!requiresSuratSakit) {
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) {
                        suratSakitInput.value = '';
                    }
                    clearSuratSakit();
                }
            }
            
            if (type === 'hadir') {
                jamSection.style.display = 'block';
                keteranganSection.style.display = 'none';
                jamMasuk.required = true;
                keterangan.required = false;
                // Auto-fill jam masuk saat pilih hadir
                if (!jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
                if (tugasSection) {
                    tugasSection.style.display = 'none';
                }
                if (tugasHint) {
                    tugasHint.classList.add('text-muted');
                }
            } else if (type === 'izin') {
                jamSection.style.display = 'none';
                keteranganSection.style.display = 'block';
                jamMasuk.required = false;
                keterangan.required = true;
                if (tugasSection) {
                    tugasSection.style.display = 'block';
                }
                // Surat sakit tidak diperlukan untuk izin
                if (suratSakitSection) {
                    suratSakitSection.style.display = 'none';
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) {
                        suratSakitInput.value = '';
                    }
                    clearSuratSakit();
                }
            } else { // sakit
                jamSection.style.display = 'block';
                keteranganSection.style.display = 'none';
                jamMasuk.required = true;
                keterangan.required = false;
                // Auto-fill jam masuk saat pilih sakit agar TU tahu kapan mulai sakit
                if (!jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
                // Update info text
                document.getElementById('jamMasukInfo').style.display = 'none';
                document.getElementById('jamMasukSakitInfo').style.display = 'inline';
                if (tugasSection) {
                    tugasSection.style.display = 'block';
                }
                if (suratSakitSection) {
                    suratSakitSection.style.display = 'block';
                }
            }
            
            // Reset info text for hadir
            if (type === 'hadir') {
                document.getElementById('jamMasukInfo').style.display = 'inline';
                document.getElementById('jamMasukSakitInfo').style.display = 'none';
            } else if (type === 'izin') {
                document.getElementById('jamMasukInfo').style.display = 'none';
                document.getElementById('jamMasukSakitInfo').style.display = 'none';
            }
        }

        // Function to get current time in HH:mm format
        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return hours + ':' + minutes;
        }

        // Function to set current time to input field
        function setCurrentTime(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                const currentTime = getCurrentTime();
                field.value = currentTime;
                
                // Visual feedback (green flash)
                field.style.backgroundColor = '#d4edda';
                field.style.transition = 'background-color 0.3s ease';
                setTimeout(() => {
                    field.style.backgroundColor = '';
                }, 500);
                
                // Show notification
                const notification = document.createElement('div');
                notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.zIndex = '9999';
                notification.style.minWidth = '250px';
                notification.innerHTML = '<i class="fas fa-check-circle me-2"></i>Waktu otomatis terisi: <strong>' + currentTime + '</strong><button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                document.body.appendChild(notification);
                
                // Auto dismiss notification after 3 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 3000);
            }
        }

        // Function to toggle presensi form
        function togglePresensiForm() {
            const formCard = document.getElementById('presensiFormCard');
            const btnTambah = document.getElementById('btnTambahPresensi');
            
            if (formCard.style.display === 'none' || formCard.style.display === '') {
                formCard.style.display = 'block';
                btnTambah.innerHTML = '<i class="fas fa-times me-2"></i>Tutup Form';
                btnTambah.classList.remove('btn-success');
                btnTambah.classList.add('btn-secondary');
                
                // Reset form
                document.getElementById('presensiForm').reset();
                document.querySelectorAll('.tugas-textarea').forEach(textarea => textarea.value = '');
                
                // Set tanggal default to today
                document.getElementById('tanggalPresensi').value = '{{ date('Y-m-d') }}';
                
                // Set default jenis to hadir and auto-fill jam
                selectPresensiType('hadir');
                
                // Scroll to form
                formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                formCard.style.display = 'none';
                btnTambah.innerHTML = '<i class="fas fa-plus-circle me-2"></i>Tambah Presensi';
                btnTambah.classList.remove('btn-secondary');
                btnTambah.classList.add('btn-success');
            }
        }

        // Initialize - set hadir as default active and auto-fill jam masuk
        document.addEventListener('DOMContentLoaded', function() {
            const formCard = document.getElementById('presensiFormCard');
            const btnTambah = document.getElementById('btnTambahPresensi');
            const hasErrors = @json($errors->any());
            const defaultType = @json(old('jenis', 'hadir'));

            if (hasErrors && formCard && btnTambah) {
                formCard.style.display = 'block';
                btnTambah.innerHTML = '<i class="fas fa-times me-2"></i>Tutup Form';
                btnTambah.classList.remove('btn-success');
                btnTambah.classList.add('btn-secondary');
            }

            selectPresensiType(defaultType);

            if (defaultType === 'hadir' && formCard && (formCard.style.display === 'block' || hasErrors)) {
                const jamMasuk = document.getElementById('jam_masuk');
                if (jamMasuk && !jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
            }
        });

        // Function to handle surat sakit file preview
        function handleSuratSakitPreview() {
            const suratSakitInput = document.getElementById('surat_sakit');
            const previewDiv = document.getElementById('surat-sakit-preview');
            const filenameSpan = document.getElementById('surat-sakit-filename');
            
            if (suratSakitInput) {
                suratSakitInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const fileName = file.name;
                        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
                        
                        // Validate file type
                        const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg', 'image/jpg'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Format file tidak didukung. Silakan pilih file PDF, PNG, atau JPG.');
                            suratSakitInput.value = '';
                            if (previewDiv) previewDiv.style.display = 'none';
                            return;
                        }
                        
                        // Validate file size (5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Ukuran file terlalu besar. Maksimal 5MB.');
                            suratSakitInput.value = '';
                            if (previewDiv) previewDiv.style.display = 'none';
                            return;
                        }
                        
                        if (previewDiv && filenameSpan) {
                            filenameSpan.textContent = fileName + ' (' + fileSize + ' MB)';
                            previewDiv.style.display = 'block';
                        }
                    } else {
                        if (previewDiv) previewDiv.style.display = 'none';
                    }
                });
            }
        }
        
        // Function to clear surat sakit
        function clearSuratSakit() {
            const suratSakitInput = document.getElementById('surat_sakit');
            const previewDiv = document.getElementById('surat-sakit-preview');
            if (suratSakitInput) {
                suratSakitInput.value = '';
            }
            if (previewDiv) {
                previewDiv.style.display = 'none';
            }
        }
        
        // Initialize surat sakit preview handler
        document.addEventListener('DOMContentLoaded', function() {
            handleSuratSakitPreview();
        });

        // Auto-refresh status every 10 seconds if there's pending presensi
        @if($todayPresensi && $todayPresensi->status_verifikasi === 'pending')
        setInterval(function() {
            // Check if status has changed
            fetch('{{ route("guru.presensi.index") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Only reload if still on presensi page
                if (window.location.pathname.includes('/presensi')) {
                    location.reload();
                }
            })
            .catch(err => console.log('Auto-refresh error:', err));
        }, 10000); // Check every 10 seconds
        @endif
    </script>
</body>
</html>



