<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Kepala Sekolah Dashboard</title>
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
        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('partials.kepala-sekolah-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Data Siswa</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('kepala_sekolah.siswa.index') }}" id="filterFormKepalaSekolah">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Kelas</label>
                                            <select name="kelas" class="form-select" id="kelasFilter" onchange="document.getElementById('filterFormKepalaSekolah').submit();">
                                                <option value="">Semua Kelas</option>
                                                <option value="7" {{ $kelasFilter == '7' ? 'selected' : '' }}>Kelas 7</option>
                                                <option value="8" {{ $kelasFilter == '8' ? 'selected' : '' }}>Kelas 8</option>
                                                <option value="9" {{ $kelasFilter == '9' ? 'selected' : '' }}>Kelas 9</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" id="statusFilter" onchange="document.getElementById('filterFormKepalaSekolah').submit();">
                                                <option value="">Semua Status</option>
                                                <option value="aktif" {{ $statusFilter == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="tidak_aktif" {{ $statusFilter == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Cari Siswa</label>
                                            <input type="text" name="search" class="form-control" id="searchInput" placeholder="Nama atau NIS" value="{{ $search }}" onkeypress="if(event.key === 'Enter') { document.getElementById('filterFormKepalaSekolah').submit(); }">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary d-block w-100">
                                                <i class="fas fa-search"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                    @if($kelasFilter || $statusFilter || $search)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <a href="{{ route('kepala_sekolah.siswa.index') }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-times"></i> Reset Filter
                                            </a>
                                            @if($kelasFilter)
                                                <span class="badge bg-info ms-2">Kelas: {{ $kelasFilter }}</span>
                                            @endif
                                            @if($statusFilter)
                                                <span class="badge bg-info ms-2">Status: {{ ucfirst($statusFilter) }}</span>
                                            @endif
                                            @if($search)
                                                <span class="badge bg-info ms-2">Pencarian: {{ $search }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Siswa List by Class -->
                <div class="row">
                    <!-- Kelas 7 -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i> Kelas 7
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th style="width: 40px;">No</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>JK</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($siswaKelas7 as $index => $siswa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->nama }}</td>
                                                <td>{{ $siswa->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $siswa->status === 'aktif' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($siswa->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada data siswa</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    Total: <strong>{{ $siswaKelas7->count() }}</strong> siswa
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Kelas 8 -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i> Kelas 8
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th style="width: 40px;">No</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>JK</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($siswaKelas8 as $index => $siswa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->nama }}</td>
                                                <td>{{ $siswa->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $siswa->status === 'aktif' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($siswa->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada data siswa</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    Total: <strong>{{ $siswaKelas8->count() }}</strong> siswa
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Kelas 9 -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i> Kelas 9
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th style="width: 40px;">No</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>JK</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($siswaKelas9 as $index => $siswa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->nama }}</td>
                                                <td>{{ $siswa->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $siswa->status === 'aktif' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($siswa->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada data siswa</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    Total: <strong>{{ $siswaKelas9->count() }}</strong> siswa
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

