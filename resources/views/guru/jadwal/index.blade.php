@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mengajar - {{ $guru->user->name }}</title>
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
        .jadwal-card {
            border-left: 4px solid #2E7D32;
            transition: transform 0.3s ease;
        }
        .jadwal-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        .jadwal-hari-ini {
            border-left-color: #ffc107;
            background: #fffbf0;
        }
        .badge-ruang {
            font-size: 0.85rem;
            padding: 6px 12px;
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
                        @php
                            $freshGuru = \App\Models\Guru::find($guru->id);
                            $photoUrl = null;
                            
                            if ($freshGuru && !empty($freshGuru->foto)) {
                                $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
                                if (!$photoUrl) {
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
                                }
                            }
                            $hasPhoto = $photoUrl !== null && $photoUrl !== '';
                        @endphp
                        @if($hasPhoto && $photoUrl)
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <img src="{{ $photoUrl }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 100px; height: 100px; top: 0; left: 0;">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
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
                    <a class="nav-link active" href="{{ route('guru.jadwal.index') }}">
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
                    <a class="nav-link" href="{{ route('guru.kuis.index') }}">
                        <i class="fas fa-question-circle me-2"></i> Kuis
                    </a>
                    <hr class="text-white-50">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                            Jadwal Mengajar
                        </h2>
                        <p class="text-muted mb-0">Lihat jadwal mengajar Anda yang telah ditentukan oleh Tenaga Usaha</p>
                    </div>
                </div>

                <!-- Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('guru.jadwal.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Filter Jadwal</label>
                                <select name="filter" class="form-select" onchange="this.form.submit()">
                                    <option value="semua" {{ ($filter ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua Jadwal</option>
                                    <option value="hari_ini" {{ ($filter ?? '') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="minggu_ini" {{ ($filter ?? '') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="bulan_ini" {{ ($filter ?? '') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Jadwal List -->
                @if($jadwals && $jadwals->count() > 0)
                    <div class="row">
                        @foreach($jadwals as $jadwal)
                            @php
                                $isHariIni = false;
                                $hariMap = [
                                    'Monday' => 'senin',
                                    'Tuesday' => 'selasa',
                                    'Wednesday' => 'rabu',
                                    'Thursday' => 'kamis',
                                    'Friday' => 'jumat',
                                    'Saturday' => 'sabtu',
                                    'Sunday' => 'minggu'
                                ];
                                $hariIni = $hariMap[\Carbon\Carbon::today()->format('l')] ?? 'senin';
                                if ($jadwal->hari == $hariIni || ($jadwal->tanggal && \Carbon\Carbon::parse($jadwal->tanggal)->isToday())) {
                                    $isHariIni = true;
                                }
                            @endphp
                            <div class="col-md-6 mb-3">
                                <div class="card jadwal-card {{ $isHariIni ? 'jadwal-hari-ini' : '' }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="mb-1">
                                                    <i class="fas fa-book me-2 text-primary"></i>
                                                    {{ $jadwal->mata_pelajaran_nama }}
                                                </h5>
                                                <p class="text-muted mb-0 small">
                                                    <i class="fas fa-user me-1"></i>
                                                    Kelas {{ $jadwal->kelas }}
                                                </p>
                                            </div>
                                            @if($isHariIni)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-exclamation-circle me-1"></i>Hari Ini
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar-day me-2 text-muted"></i>
                                                <strong>{{ $jadwal->hari_nama }}</strong>
                                                @if($jadwal->tanggal)
                                                    <span class="text-muted ms-2">
                                                        ({{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }})
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-clock me-2 text-muted"></i>
                                                <span>
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-door-open me-2 text-muted"></i>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    @if($jadwal->is_lab)
                                                        <span class="badge bg-info badge-ruang">
                                                            <i class="fas fa-flask me-1"></i>Laboratorium
                                                        </span>
                                                    @endif
                                                    @if($jadwal->is_lapangan)
                                                        <span class="badge bg-success badge-ruang">
                                                            <i class="fas fa-running me-1"></i>Lapangan
                                                        </span>
                                                    @endif
                                                    @if(!$jadwal->is_lab && !$jadwal->is_lapangan)
                                                        <span class="badge bg-secondary badge-ruang">
                                                            <i class="fas fa-door-open me-1"></i>{{ $jadwal->ruang ?? 'Ruang ' . $jadwal->kelas }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($jadwal->keterangan)
                                            <div class="alert alert-light mb-0">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <small>{{ $jadwal->keterangan }}</small>
                                            </div>
                                        @endif
                                        
                                        @if($jadwal->is_berulang)
                                            <div class="mt-2">
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-sync-alt me-1"></i>Berulang Setiap Minggu
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if(method_exists($jadwals, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $jadwals->appends(request()->query())->links() }}
                    </div>
                    @endif
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada jadwal mengajar</h5>
                            <p class="text-muted">Jadwal mengajar akan muncul di sini setelah ditentukan oleh Tenaga Usaha</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

