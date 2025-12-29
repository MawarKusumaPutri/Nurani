@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rangkuman - {{ $guru->user->name }}</title>
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
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 12px 16px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        }
        .avatar-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        .avatar-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    @include('partials.guru-fixed-layout')
    @include('partials.guru-dynamic-ui')
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <div class="text-center mb-4">
                        @if($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="Foto Profil" 
                                 class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a href="{{ route('guru.dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('guru.jadwal.index') }}" class="nav-link">
                        <i class="fas fa-calendar-alt me-2"></i>Jadwal Mengajar
                    </a>
                    <a href="{{ route('guru.presensi.index') }}" class="nav-link">
                        <i class="fas fa-calendar-check me-2"></i>Presensi Guru
                    </a>
                    <a href="{{ route('guru.presensi-siswa.index') }}" class="nav-link">
                        <i class="fas fa-user-graduate me-2"></i>Presensi Siswa
                    </a>
                    <a href="{{ route('guru.materi.index') }}" class="nav-link">
                        <i class="fas fa-book me-2"></i>Materi
                    </a>
                    <a href="{{ route('guru.kuis.index') }}" class="nav-link">
                        <i class="fas fa-question-circle me-2"></i>Kuis
                    </a>
                    <a href="{{ route('guru.rangkuman.index') }}" class="nav-link active">
                        <i class="fas fa-clipboard-list me-2"></i>Rangkuman
                    </a>
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Edit Rangkuman</h2>
                        <p class="text-muted mb-0">Edit rangkuman materi yang telah diajarkan</p>
                    </div>
                    <a href="{{ route('guru.rangkuman.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Form -->
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('guru.rangkuman.update', $rangkuman) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mata_pelajaran" class="form-label">
                                        <i class="fas fa-book me-2 text-primary"></i>Mata Pelajaran
                                    </label>
                                    <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        @if($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan')
                                            @foreach(explode(', ', $guru->mata_pelajaran) as $mp)
                                                <option value="{{ trim($mp) }}" {{ $rangkuman->mata_pelajaran == trim($mp) ? 'selected' : '' }}>{{ trim($mp) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="kelas" class="form-label">
                                        <i class="fas fa-users me-2 text-primary"></i>Kelas
                                    </label>
                                    <select class="form-select" id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <option value="VII" {{ $rangkuman->kelas == 'VII' ? 'selected' : '' }}>VII</option>
                                        <option value="VIII" {{ $rangkuman->kelas == 'VIII' ? 'selected' : '' }}>VIII</option>
                                        <option value="IX" {{ $rangkuman->kelas == 'IX' ? 'selected' : '' }}>IX</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_pertemuan" class="form-label">
                                        <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Pertemuan
                                    </label>
                                    <input type="date" class="form-control" id="tanggal_pertemuan" name="tanggal_pertemuan" 
                                           value="{{ old('tanggal_pertemuan', $rangkuman->tanggal_pertemuan) }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="jam_mulai" class="form-label">
                                        <i class="fas fa-clock me-2 text-primary"></i>Jam Mulai
                                    </label>
                                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" 
                                           value="{{ old('jam_mulai', $rangkuman->jam_mulai) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jam_selesai" class="form-label">
                                        <i class="fas fa-clock me-2 text-primary"></i>Jam Selesai
                                    </label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" 
                                           value="{{ old('jam_selesai', $rangkuman->jam_selesai) }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="topik" class="form-label">
                                        <i class="fas fa-tag me-2 text-primary"></i>Topik Materi
                                    </label>
                                    <input type="text" class="form-control" id="topik" name="topik" 
                                           value="{{ old('topik', $rangkuman->topik) }}" placeholder="Contoh: Sistem Pernapasan Manusia" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="materi_yang_diajarkan" class="form-label">
                                    <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>Materi yang Diajarkan
                                </label>
                                <textarea class="form-control" id="materi_yang_diajarkan" name="materi_yang_diajarkan" 
                                          rows="4" placeholder="Jelaskan materi yang telah diajarkan..." required>{{ old('materi_yang_diajarkan', $rangkuman->materi_yang_diajarkan) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="aktivitas_siswa" class="form-label">
                                    <i class="fas fa-user-graduate me-2 text-primary"></i>Aktivitas Siswa
                                </label>
                                <textarea class="form-control" id="aktivitas_siswa" name="aktivitas_siswa" 
                                          rows="3" placeholder="Jelaskan aktivitas yang dilakukan siswa..." required>{{ old('aktivitas_siswa', $rangkuman->aktivitas_siswa) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="evaluasi" class="form-label">
                                    <i class="fas fa-chart-line me-2 text-primary"></i>Evaluasi Pembelajaran
                                </label>
                                <textarea class="form-control" id="evaluasi" name="evaluasi" 
                                          rows="3" placeholder="Jelaskan evaluasi atau penilaian yang dilakukan..." required>{{ old('evaluasi', $rangkuman->evaluasi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="tindak_lanjut" class="form-label">
                                    <i class="fas fa-forward me-2 text-primary"></i>Tindak Lanjut
                                </label>
                                <textarea class="form-control" id="tindak_lanjut" name="tindak_lanjut" 
                                          rows="3" placeholder="Jelaskan rencana tindak lanjut untuk pertemuan berikutnya...">{{ old('tindak_lanjut', $rangkuman->tindak_lanjut) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="catatan_khusus" class="form-label">
                                    <i class="fas fa-sticky-note me-2 text-primary"></i>Catatan Khusus
                                </label>
                                <textarea class="form-control" id="catatan_khusus" name="catatan_khusus" 
                                          rows="2" placeholder="Catatan khusus atau hal penting lainnya...">{{ old('catatan_khusus', $rangkuman->catatan_khusus) }}</textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Rangkuman
                                </button>
                                <a href="{{ route('guru.rangkuman.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
