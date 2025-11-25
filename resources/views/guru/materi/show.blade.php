@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Materi - {{ $materi->judul }}</title>
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
        .file-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        .file-pdf { background: #dc3545; }
        .file-video { background: #6f42c1; }
        .file-image { background: #28a745; }
        .file-document { background: #007bff; }
        .content-area {
            line-height: 1.8;
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
                        @if($materi->guru->foto)
                            <img src="{{ Storage::url($materi->guru->foto) }}" alt="Foto Profil" 
                                 class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $materi->guru->user->name }}</h6>
                        <small class="text-white-50">{{ $materi->guru->mata_pelajaran }}</small>
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
                    <a class="nav-link active" href="{{ route('guru.materi.index') }}">
                        <i class="fas fa-book me-2"></i> Materi
                    </a>
                    <a class="nav-link" href="{{ route('guru.kuis.index') }}">
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
                        <h2 class="mb-1">{{ $materi->judul }}</h2>
                        <p class="text-muted mb-0">
                            <span class="badge bg-primary me-2">{{ $materi->mata_pelajaran }}</span>
                            <span class="badge bg-secondary me-2">Kelas {{ $materi->kelas }}</span>
                            @if($materi->is_published)
                                <span class="badge bg-success">Dipublikasi</span>
                            @else
                                <span class="badge bg-warning">Draft</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('guru.materi.edit', $materi->id) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-2"></i>Edit Materi
                        </a>
                        <a href="{{ route('guru.materi.index') }}" class="btn btn-outline-secondary">
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

                <!-- Materi Content -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Deskripsi</h5>
                                <p class="content-area">{{ $materi->deskripsi }}</p>
                            </div>
                        </div>

                        @if($materi->konten)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Konten Materi</h5>
                                    <div class="content-area">
                                        {!! nl2br(e($materi->konten)) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($materi->link_video)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Video Pembelajaran</h5>
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $materi->link_video }}" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($materi->file_path)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">File Lampiran</h5>
                                    <div class="d-flex align-items-center">
                                        @php
                                            $fileType = $materi->file_type;
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
                                        <div class="file-icon {{ $iconBg }} me-3">
                                            <i class="{{ $iconClass }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">File Lampiran</h6>
                                            <p class="text-muted mb-1 small">{{ $materi->file_type }}</p>
                                            @if($materi->file_size_formatted)
                                                <p class="text-muted mb-0 small">{{ $materi->file_size_formatted }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ Storage::url($materi->file_path) }}" 
                                           class="btn btn-primary" 
                                           target="_blank" 
                                           download>
                                            <i class="fas fa-download me-2"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Materi</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6>Judul:</h6>
                                    <p class="mb-0">{{ $materi->judul }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Mata Pelajaran:</h6>
                                    <p class="mb-0">{{ $materi->mata_pelajaran }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Kelas:</h6>
                                    <p class="mb-0">Kelas {{ $materi->kelas }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Topik:</h6>
                                    <p class="mb-0">{{ $materi->topik }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Status:</h6>
                                    @if($materi->is_published)
                                        <span class="badge bg-success">Dipublikasi</span>
                                        @if($materi->tanggal_publish)
                                            <p class="text-muted small mb-0 mt-1">
                                                Dipublikasi pada: {{ $materi->tanggal_publish->format('d M Y H:i') }}
                                            </p>
                                        @endif
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Dibuat:</h6>
                                    <p class="text-muted small mb-0" id="created-time" 
                                       data-timestamp="{{ $materi->created_at->timestamp }}">
                                        <span class="time-display">{{ $materi->created_at->format('d M Y H:i') }}</span>
                                        <span class="timezone-badge ms-2"></span>
                                    </p>
                                </div>
                                
                                @if($materi->updated_at != $materi->created_at)
                                    <div class="mb-3">
                                        <h6>Diperbarui:</h6>
                                        <p class="text-muted small mb-0" id="updated-time" 
                                           data-timestamp="{{ $materi->updated_at->timestamp }}">
                                            <span class="time-display">{{ $materi->updated_at->format('d M Y H:i') }}</span>
                                            <span class="timezone-badge ms-2"></span>
                                        </p>
                                    </div>
                                @endif
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
    <script>
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

        // Function to format date in Indonesian format
        function formatIndonesianDate(timestamp) {
            const date = new Date(timestamp * 1000);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            
            const day = String(date.getDate()).padStart(2, '0');
            const month = months[date.getMonth()];
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            
            return `${day} ${month} ${year} ${hours}:${minutes}`;
        }

        // Function to update time display
        function updateTimeDisplay() {
            const timezone = getTimezoneAbbreviation();
            
            // Update created time
            const createdTimeEl = document.getElementById('created-time');
            if (createdTimeEl) {
                const timestamp = createdTimeEl.getAttribute('data-timestamp');
                const timeDisplay = createdTimeEl.querySelector('.time-display');
                const timezoneBadge = createdTimeEl.querySelector('.timezone-badge');
                
                if (timestamp && timeDisplay) {
                    const formattedTime = formatIndonesianDate(parseInt(timestamp));
                    timeDisplay.textContent = formattedTime;
                    
                    if (timezoneBadge) {
                        timezoneBadge.textContent = timezone;
                        timezoneBadge.className = 'timezone-badge ms-2 badge bg-info';
                    }
                }
            }
            
            // Update updated time
            const updatedTimeEl = document.getElementById('updated-time');
            if (updatedTimeEl) {
                const timestamp = updatedTimeEl.getAttribute('data-timestamp');
                const timeDisplay = updatedTimeEl.querySelector('.time-display');
                const timezoneBadge = updatedTimeEl.querySelector('.timezone-badge');
                
                if (timestamp && timeDisplay) {
                    const formattedTime = formatIndonesianDate(parseInt(timestamp));
                    timeDisplay.textContent = formattedTime;
                    
                    if (timezoneBadge) {
                        timezoneBadge.textContent = timezone;
                        timezoneBadge.className = 'timezone-badge ms-2 badge bg-info';
                    }
                }
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTimeDisplay();
        });
    </script>
</body>
</html>

