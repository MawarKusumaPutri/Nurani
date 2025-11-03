@extends('layouts.tu')

@section('title', 'Presensi - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <div class="profile-circle">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h6 class="text-white mt-2 mb-1">Tenaga Usaha</h6>
                    <small class="text-white-50">Administrasi</small>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.guru.index') }}">
                            <i class="fas fa-chalkboard-teacher"></i> Data Guru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.siswa.index') }}">
                            <i class="fas fa-users"></i> Data Siswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tu.presensi.index') }}">
                            <i class="fas fa-calendar-check"></i> Presensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.jadwal.index') }}">
                            <i class="fas fa-calendar"></i> Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.kalender.index') }}">
                            <i class="fas fa-calendar-alt"></i> Kalender
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.arsip.index') }}">
                            <i class="fas fa-archive"></i> Arsip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.surat.index') }}">
                            <i class="fas fa-envelope"></i> Surat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.laporan.index') }}">
                            <i class="fas fa-chart-bar"></i> Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.pengumuman.index') }}">
                            <i class="fas fa-bullhorn"></i> Pengumuman
                        </a>
                    </li>
                </ul>
                
                <div class="mt-auto">
                    <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm w-100">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Presensi Guru</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Presensi
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
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

            @if($totalPending > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-bell me-2"></i>
                <strong>Ada {{ $totalPending }} presensi yang menunggu verifikasi!</strong>
                Silakan verifikasi presensi yang ditandai dengan baris kuning di bawah.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="presensiTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="presensi-tab" data-bs-toggle="tab" data-bs-target="#presensi" type="button" role="tab">
                        <i class="fas fa-calendar-check me-2"></i> Presensi
                        @if($pendingHadir > 0)
                            <span class="badge bg-danger ms-2">{{ $pendingHadir }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="izin-tab" data-bs-toggle="tab" data-bs-target="#izin" type="button" role="tab">
                        <i class="fas fa-file-alt me-2"></i> Izin
                        @if($pendingIzin > 0)
                            <span class="badge bg-danger ms-2">{{ $pendingIzin }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sakit-tab" data-bs-toggle="tab" data-bs-target="#sakit" type="button" role="tab">
                        <i class="fas fa-user-injured me-2"></i> Sakit
                        @if($pendingSakit > 0)
                            <span class="badge bg-danger ms-2">{{ $pendingSakit }}</span>
                        @endif
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="presensiTabsContent">
                <!-- Presensi Tab -->
                <div class="tab-pane fade show active" id="presensi" role="tabpanel">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select">
                                                <option value="">Semua Status</option>
                                                <option value="hadir">Hadir</option>
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="alpa">Alpa</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Cari Guru</label>
                                            <input type="text" class="form-control" placeholder="Nama guru">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">&nbsp;</label>
                                            <button class="btn btn-primary d-block w-100">
                                                <i class="fas fa-search"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Presensi List -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-calendar-check"></i> Daftar Semua Presensi
                                        <small class="text-muted ms-2">(Hadir, Izin, dan Sakit)</small>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Guru</th>
                                                    <th>Tanggal</th>
                                                    <th>Jenis</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Status Verifikasi</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($allPresensi->count() > 0)
                                                    @foreach($allPresensi as $index => $presensi)
                                                    <tr class="{{ $presensi->status_verifikasi === 'pending' ? 'table-warning' : '' }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ $presensi->guru->user->name }}</strong>
                                                            @if($presensi->status_verifikasi === 'pending')
                                                                <span class="badge bg-danger ms-2">Baru</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $presensi->tanggal->format('d/m/Y') }}</td>
                                                        <td>
                                                            @if($presensi->jenis === 'hadir')
                                                                <span class="badge bg-success">Hadir</span>
                                                            @elseif($presensi->jenis === 'izin')
                                                                <span class="badge bg-warning text-dark">Izin</span>
                                                            @elseif($presensi->jenis === 'sakit')
                                                                <span class="badge bg-danger">Sakit</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($presensi->jam_masuk)
                                                                @if($presensi->jenis === 'sakit')
                                                                    <span class="badge bg-danger text-white">
                                                                        <i class="fas fa-clock me-1"></i>{{ date('H:i', strtotime($presensi->jam_masuk)) }}
                                                                    </span>
                                                                    <small class="text-muted d-block">Mulai sakit</small>
                                                                @else
                                                                    {{ date('H:i', strtotime($presensi->jam_masuk)) }}
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>{{ $presensi->jam_keluar ? date('H:i', strtotime($presensi->jam_keluar)) : '-' }}</td>
                                                        <td>
                                                            @if($presensi->status_verifikasi === 'pending')
                                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                                            @elseif($presensi->status_verifikasi === 'approved')
                                                                <span class="badge bg-success">Disetujui</span>
                                                            @else
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $presensi->keterangan ?? '-' }}</td>
                                                        <td>
                                                            @if($presensi->status_verifikasi === 'pending')
                                                                <form action="{{ route('tu.presensi.verify', $presensi->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="approve">
                                                                    <button type="submit" class="btn btn-sm btn-success me-1" onclick="return confirm('Setujui presensi ini?')">
                                                                        <i class="fas fa-check"></i> Setujui
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('tu.presensi.verify', $presensi->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="reject">
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak presensi ini?')">
                                                                        <i class="fas fa-times"></i> Tolak
                                                                    </button>
                                                                </form>
                                                            @elseif($presensi->status_verifikasi === 'approved')
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check-circle"></i> Sudah Disetujui
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger">
                                                                    <i class="fas fa-times-circle"></i> Ditolak
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="9" class="text-center text-muted">Belum ada data presensi</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Izin Tab -->
                <div class="tab-pane fade" id="izin" role="tabpanel">
                    @if($pendingIzin > 0)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Ada <strong>{{ $pendingIzin }}</strong> permohonan izin yang menunggu verifikasi.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Status Izin</label>
                                            <select class="form-select">
                                                <option value="">Semua Status</option>
                                                <option value="pending">Menunggu Persetujuan</option>
                                                <option value="approved">Disetujui</option>
                                                <option value="rejected">Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">&nbsp;</label>
                                            <button class="btn btn-primary d-block w-100">
                                                <i class="fas fa-search"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Izin List -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-file-alt"></i> Daftar Permohonan Izin
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Guru</th>
                                                    <th>Jenis Izin</th>
                                                    <th>Tanggal Mulai</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Durasi</th>
                                                    <th>Alasan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($presensiIzin->count() > 0)
                                                    @foreach($presensiIzin as $index => $izin)
                                                    <tr class="{{ $izin->status_verifikasi === 'pending' ? 'table-warning' : '' }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ $izin->guru->user->name }}</strong>
                                                            @if($izin->status_verifikasi === 'pending')
                                                                <span class="badge bg-danger ms-2">Baru</span>
                                                            @endif
                                                        </td>
                                                        <td>Izin</td>
                                                        <td>{{ $izin->tanggal->format('d/m/Y') }}</td>
                                                        <td>{{ $izin->tanggal->format('d/m/Y') }}</td>
                                                        <td>1 hari</td>
                                                        <td>{{ $izin->keterangan ?? '-' }}</td>
                                                        <td>
                                                            @if($izin->status_verifikasi === 'pending')
                                                                <span class="badge bg-warning">Menunggu</span>
                                                            @elseif($izin->status_verifikasi === 'approved')
                                                                <span class="badge bg-success">Disetujui</span>
                                                            @else
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($izin->status_verifikasi === 'pending')
                                                                <form action="{{ route('tu.presensi.verify', $izin->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="approve">
                                                                    <button type="submit" class="btn btn-sm btn-success me-1" onclick="return confirm('Setujui izin ini?')">
                                                                        <i class="fas fa-check"></i> Setujui
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('tu.presensi.verify', $izin->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="reject">
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak izin ini?')">
                                                                        <i class="fas fa-times"></i> Tolak
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <button class="btn btn-sm btn-secondary" disabled>
                                                                    <i class="fas fa-check"></i> Sudah Diproses
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="9" class="text-center text-muted">Belum ada data izin</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sakit Tab -->
                <div class="tab-pane fade" id="sakit" role="tabpanel">
                    @if($pendingSakit > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Ada <strong>{{ $pendingSakit }}</strong> data sakit yang menunggu verifikasi.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select">
                                                <option value="">Semua Status</option>
                                                <option value="pending">Menunggu Persetujuan</option>
                                                <option value="approved">Disetujui</option>
                                                <option value="rejected">Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">&nbsp;</label>
                                            <button class="btn btn-primary d-block w-100">
                                                <i class="fas fa-search"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sakit List -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user-injured"></i> Daftar Data Sakit
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Guru</th>
                                                    <th>Tanggal Mulai</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Durasi</th>
                                                    <th>Diagnosa</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($presensiSakit->count() > 0)
                                                    @foreach($presensiSakit as $index => $sakit)
                                                    <tr class="{{ $sakit->status_verifikasi === 'pending' ? 'table-warning' : '' }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ $sakit->guru->user->name }}</strong>
                                                            @if($sakit->status_verifikasi === 'pending')
                                                                <span class="badge bg-danger ms-2">Baru</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $sakit->tanggal->format('d/m/Y') }}</td>
                                                        <td>{{ $sakit->tanggal->format('d/m/Y') }}</td>
                                                        <td>1 hari</td>
                                                        <td>{{ $sakit->keterangan ?? '-' }}</td>
                                                        <td>
                                                            @if($sakit->status_verifikasi === 'pending')
                                                                <span class="badge bg-warning">Menunggu</span>
                                                            @elseif($sakit->status_verifikasi === 'approved')
                                                                <span class="badge bg-success">Disetujui</span>
                                                            @else
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($sakit->status_verifikasi === 'pending')
                                                                <form action="{{ route('tu.presensi.verify', $sakit->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="approve">
                                                                    <button type="submit" class="btn btn-sm btn-success me-1" onclick="return confirm('Setujui data sakit ini?')">
                                                                        <i class="fas fa-check"></i> Setujui
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('tu.presensi.verify', $sakit->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="reject">
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak data sakit ini?')">
                                                                        <i class="fas fa-times"></i> Tolak
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <button class="btn btn-sm btn-secondary" disabled>
                                                                    <i class="fas fa-check"></i> Sudah Diproses
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted">Belum ada data sakit</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Fungsi untuk Edit Presensi
function editPresensi(id, namaGuru) {
    // Bisa dibuat modal atau redirect ke halaman edit
    if (confirm('Edit presensi untuk ' + namaGuru + '?')) {
        // Implementation for editing presensi
        // Untuk implementasi: buat route tu.presensi.edit dan uncomment baris di bawah
        // window.location.href = '/tu/presensi/' + id + '/edit';
        alert('Fitur edit presensi untuk ' + namaGuru + ' akan dibuka');
    }
}

// Fungsi untuk Verifikasi Presensi (sudah tidak digunakan, diganti dengan form)
function verifikasiPresensi(id, namaGuru, status) {
    // Function replaced by form submission
}

// Fungsi untuk Approve Izin (sudah diganti dengan form submission)
function approveIzin(id) {
    // Function replaced by form submission
}

// Fungsi untuk Reject Izin (sudah diganti dengan form submission)
function rejectIzin(id) {
    // Function replaced by form submission
}

// Fungsi untuk Approve Sakit (sudah diganti dengan form submission)
function approveSakit(id, namaGuru) {
    // Function replaced by form submission
}

// Fungsi untuk Reject Sakit (sudah diganti dengan form submission)
function rejectSakit(id, namaGuru) {
    // Function replaced by form submission
}
</script>
@endsection
