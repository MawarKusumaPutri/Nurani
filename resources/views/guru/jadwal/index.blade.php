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
                            <img src="{{ $photoUrl }}" alt="Foto Profil" 
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div>
                        <h1 class="h2">Jadwal Mengajar</h1>
                        <p class="text-muted mb-0">Jadwal yang dibuat oleh Tenaga Usaha akan otomatis muncul di sini</p>
                    </div>
                </div>

                @if($jadwals && $jadwals->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Hari</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                            <th>Jam</th>
                                            <th>Ruang</th>
                                            <th>Semester</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jadwals as $jadwal)
                                            <tr>
                                                <td><strong>{{ ucfirst($jadwal->hari) }}</strong></td>
                                                <td>{{ $jadwal->mata_pelajaran }}</td>
                                                <td>{{ $jadwal->kelas }}</td>
                                                <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                                <td>
                                                    {{ $jadwal->ruang ?? '-' }}
                                                    @if($jadwal->is_lab)
                                                        <span class="badge bg-info ms-1">Lab</span>
                                                    @endif
                                                    @if($jadwal->is_lapangan ?? false)
                                                        <span class="badge bg-success ms-1">Lapangan</span>
                                                    @endif
                                                    @if($jadwal->is_berulang)
                                                        <span class="badge bg-warning ms-1">Berulang</span>
                                                    @endif
                                                </td>
                                                <td>{{ $jadwal->semester }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $jadwal->status == 'aktif' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($jadwal->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada jadwal mengajar</h5>
                            <p class="text-muted">Silakan hubungi admin untuk menambahkan jadwal mengajar Anda.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

