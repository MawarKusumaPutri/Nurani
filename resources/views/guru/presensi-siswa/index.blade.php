@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa - {{ $guru->user->name }}</title>
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
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-hadir { background: #28a745; color: white; }
        .badge-sakit { background: #ffc107; color: #000; }
        .badge-izin { background: #17a2b8; color: white; }
        .badge-alfa { background: #dc3545; color: white; }
        .table-responsive {
            border-radius: 10px;
        }
        .form-select:focus, .form-control:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
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
                        <small class="text-white-50">{{ $guru->mata_pelajaran ?? 'Mata Pelajaran' }}</small>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('guru.presensi.index') }}">
                            <i class="fas fa-calendar-check me-2"></i> Presensi Guru
                        </a>
                        <a class="nav-link active" href="{{ route('guru.presensi-siswa.index') }}">
                            <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
                        </a>
                        <a class="nav-link" href="{{ route('guru.materi.index') }}">
                            <i class="fas fa-book me-2"></i> Materi
                        </a>
                        <a class="nav-link" href="{{ route('guru.kuis.index') }}">
                            <i class="fas fa-question-circle me-2"></i> Kuis
                        </a>
                        <hr class="text-white">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-start w-100 border-0 bg-transparent">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-user-graduate me-2 text-primary"></i>
                            Presensi Siswa
                        </h2>
                        <p class="text-muted mb-0">Kelola presensi siswa untuk berbagai kelas dan tanggal</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('guru.presensi-siswa.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Pilih Kelas</label>
                                <select name="kelas" class="form-select" onchange="this.form.submit()">
                                    <option value="7" {{ $selectedKelas == '7' ? 'selected' : '' }}>Kelas 7</option>
                                    <option value="8" {{ $selectedKelas == '8' ? 'selected' : '' }}>Kelas 8</option>
                                    <option value="9" {{ $selectedKelas == '9' ? 'selected' : '' }}>Kelas 9</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pilih Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ $selectedTanggal }}" onchange="this.form.submit()">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-2"></i> Filter
                                    </button>
                                    <a href="{{ route('guru.presensi-siswa.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-redo me-2"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Presensi Form -->
                @if(isset($siswas) && $siswas->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Form Presensi Siswa - Kelas {{ $selectedKelas }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('guru.presensi-siswa.store') }}" id="presensiForm">
                            @csrf
                            <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
                            <input type="hidden" name="tanggal" value="{{ $selectedTanggal }}">

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">NIS</th>
                                            <th width="25%">Nama Siswa</th>
                                            <th width="20%">Status</th>
                                            <th width="35%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswas as $index => $siswa)
                                            @php
                                                $existingPresensi = $presensiHariIni->get($siswa->id);
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>
                                                    <strong>{{ $siswa->nama }}</strong>
                                                    @if($existingPresensi)
                                                        <br><small class="text-muted">
                                                            <i class="fas fa-check-circle text-success"></i> 
                                                            Sudah diisi: {{ $existingPresensi->status_label }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                                    <select name="status[]" class="form-select form-select-sm" required>
                                                        <option value="hadir" {{ $existingPresensi && $existingPresensi->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                        <option value="sakit" {{ $existingPresensi && $existingPresensi->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                        <option value="izin" {{ $existingPresensi && $existingPresensi->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                                        <option value="alfa" {{ $existingPresensi && $existingPresensi->status == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="keterangan[]" class="form-control form-control-sm" 
                                                           placeholder="Keterangan (opsional)" 
                                                           value="{{ $existingPresensi ? $existingPresensi->keterangan : '' }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i> Simpan Presensi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Pilih kelas terlebih dahulu untuk melihat daftar siswa.
                </div>
                @endif

                <!-- Presensi History -->
                @if(isset($presensiHistory) && $presensiHistory->count() > 0)
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>
                            Riwayat Presensi (30 Hari Terakhir) - Kelas {{ $selectedKelas }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensiHistory as $presensi)
                                        <tr>
                                            <td>{{ $presensi->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $presensi->siswa->nis }}</td>
                                            <td>{{ $presensi->siswa->nama }}</td>
                                            <td>
                                                <span class="status-badge badge-{{ $presensi->status }}">
                                                    {{ $presensi->status_label }}
                                                </span>
                                            </td>
                                            <td>{{ $presensi->keterangan ?? '-' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="editPresensi({{ $presensi->id }}, '{{ $presensi->status }}', '{{ $presensi->keterangan ?? '' }}')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('guru.presensi-siswa.destroy', $presensi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus presensi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Presensi Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" id="editStatus" required>
                                <option value="hadir">Hadir</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="alfa">Alfa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="editKeterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editPresensi(id, status, keterangan) {
            document.getElementById('editForm').action = '/guru/presensi-siswa/' + id;
            document.getElementById('editStatus').value = status;
            document.getElementById('editKeterangan').value = keterangan;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
</body>
</html>

