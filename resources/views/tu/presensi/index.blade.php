@extends('layouts.tu')

@section('title', 'Presensi - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Presensi Guru</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
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
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="hadir-tab" data-bs-toggle="tab" data-bs-target="#hadir" type="button" role="tab">
                        <i class="fas fa-check-circle me-2"></i> Hadir
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
                    <!-- Presensi List -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-calendar-check"></i> Daftar Semua Presensi
                                            <small class="text-muted ms-2">(Hadir, Izin, dan Sakit)</small>
                                        </h5>
                                        @if($allPresensi->count() > 0)
                                        <!-- Pagination at Top -->
                                        <div class="d-flex gap-3 align-items-center">
                                            <span class="text-muted small">
                                                Menampilkan {{ $allPresensi->firstItem() }} sampai {{ $allPresensi->lastItem() }} dari {{ $allPresensi->total() }} hasil
                                            </span>
                                            @if($allPresensi->onFirstPage())
                                                <button class="btn btn-secondary pagination-btn" disabled style="min-width: 100px; font-weight: 500;">
                                                    <i class="fas fa-chevron-left me-1"></i> Previous
                                                </button>
                                            @else
                                                <a href="{{ $allPresensi->appends(request()->query())->previousPageUrl() }}" class="btn pagination-btn pagination-btn-active" style="min-width: 100px; font-weight: 500;">
                                                    <i class="fas fa-chevron-left me-1"></i> Previous
                                                </a>
                                            @endif
                                            
                                            <span class="text-muted px-3" style="font-weight: 500; font-size: 0.95rem;">
                                                Halaman {{ $allPresensi->currentPage() }} / {{ $allPresensi->lastPage() }}
                                            </span>
                                            
                                            @if($allPresensi->hasMorePages())
                                                <a href="{{ $allPresensi->appends(request()->query())->nextPageUrl() }}" class="btn pagination-btn pagination-btn-active" style="min-width: 100px; font-weight: 500;">
                                                    Next <i class="fas fa-chevron-right ms-1"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-secondary pagination-btn" disabled style="min-width: 100px; font-weight: 500;">
                                                    Next <i class="fas fa-chevron-right ms-1"></i>
                                                </button>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
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
                                                    <th>Tugas Pengganti</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($allPresensi->count() > 0)
                                                    @foreach($allPresensi as $index => $presensi)
                                                    <tr class="{{ $presensi->status_verifikasi === 'pending' ? 'table-warning' : '' }}">
                                                        <td>{{ $allPresensi->firstItem() + $index }}</td>
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
                                                        <td>
                                                            {{ $presensi->keterangan ?? '-' }}
                                                            @php
                                                                $tugasList = collect([
                                                                    'Kelas 7' => $presensi->tugas_kelas7,
                                                                    'Kelas 8' => $presensi->tugas_kelas8,
                                                                    'Kelas 9' => $presensi->tugas_kelas9,
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
                                                            @if($presensi->tugas_kelas_7 || $presensi->tugas_kelas_8 || $presensi->tugas_kelas_9)
                                                                <ul class="mb-0 ps-3">
                                                                    @if($presensi->tugas_kelas_7)
                                                                        <li><strong>Kelas 7:</strong> {{ $presensi->tugas_kelas_7 }}</li>
                                                                    @endif
                                                                    @if($presensi->tugas_kelas_8)
                                                                        <li><strong>Kelas 8:</strong> {{ $presensi->tugas_kelas_8 }}</li>
                                                                    @endif
                                                                    @if($presensi->tugas_kelas_9)
                                                                        <li><strong>Kelas 9:</strong> {{ $presensi->tugas_kelas_9 }}</li>
                                                                    @endif
                                                                </ul>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
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
                                                        <td colspan="10" class="text-center text-muted">Belum ada data presensi</td>
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

                <!-- Hadir Tab -->
                <div class="tab-pane fade" id="hadir" role="tabpanel">
                    @if($pendingHadir > 0)
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Perhatian!</strong> Ada <strong>{{ $pendingHadir }}</strong> presensi hadir yang menunggu verifikasi.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('tu.presensi.index') }}" id="filterHadirForm">
                                        <input type="hidden" name="tab" value="hadir">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" name="status_hadir" id="statusHadir">
                                                    <option value="">Semua Status</option>
                                                    <option value="pending" {{ request('status_hadir') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                                    <option value="approved" {{ request('status_hadir') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                                    <option value="rejected" {{ request('status_hadir') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Tanggal Mulai</label>
                                                <input type="date" class="form-control" name="tanggal_mulai_hadir" value="{{ request('tanggal_mulai_hadir') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" name="tanggal_selesai_hadir" value="{{ request('tanggal_selesai_hadir') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary d-block w-100">
                                                    <i class="fas fa-search"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hadir List -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-check-circle"></i> Daftar Presensi Hadir
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
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Status Verifikasi</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($presensiHadir->count() > 0)
                                                    @foreach($presensiHadir as $index => $hadir)
                                                    <tr class="{{ $hadir->status_verifikasi === 'pending' ? 'table-warning' : '' }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ $hadir->guru->user->name }}</strong>
                                                            @if($hadir->status_verifikasi === 'pending')
                                                                <span class="badge bg-danger ms-2">Baru</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $hadir->tanggal->format('d/m/Y') }}</td>
                                                        <td>
                                                            @if($hadir->jam_masuk)
                                                                <span class="badge bg-success text-white">
                                                                    <i class="fas fa-clock me-1"></i>{{ date('H:i', strtotime($hadir->jam_masuk)) }}
                                                                </span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($hadir->jam_keluar)
                                                                <span class="badge bg-info text-white">
                                                                    <i class="fas fa-clock me-1"></i>{{ date('H:i', strtotime($hadir->jam_keluar)) }}
                                                                </span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($hadir->status_verifikasi === 'pending')
                                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                                            @elseif($hadir->status_verifikasi === 'approved')
                                                                <span class="badge bg-success">Disetujui</span>
                                                            @else
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $hadir->keterangan ?? '-' }}
                                                            @php
                                                                $tugasList = collect([
                                                                    'Kelas 7' => $hadir->tugas_kelas7,
                                                                    'Kelas 8' => $hadir->tugas_kelas8,
                                                                    'Kelas 9' => $hadir->tugas_kelas9,
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
                                                            @if($hadir->status_verifikasi === 'pending')
                                                                <form action="{{ route('tu.presensi.verify', $hadir->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="approve">
                                                                    <button type="submit" class="btn btn-sm btn-success me-1" onclick="return confirm('Setujui presensi hadir ini?')">
                                                                        <i class="fas fa-check"></i> Setujui
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('tu.presensi.verify', $hadir->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="reject">
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak presensi hadir ini?')">
                                                                        <i class="fas fa-times"></i> Tolak
                                                                    </button>
                                                                </form>
                                                            @elseif($hadir->status_verifikasi === 'approved')
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
                                                        <td colspan="8" class="text-center text-muted">Belum ada data presensi hadir</td>
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
                                    <form method="GET" action="{{ route('tu.presensi.index') }}" id="filterIzinForm">
                                        <input type="hidden" name="tab" value="izin">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Status Izin</label>
                                                <select class="form-select" name="status_izin" id="statusIzin">
                                                    <option value="">Semua Status</option>
                                                    <option value="pending" {{ request('status_izin') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                                    <option value="approved" {{ request('status_izin') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                                    <option value="rejected" {{ request('status_izin') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Tanggal Mulai</label>
                                                <input type="date" class="form-control" name="tanggal_mulai_izin" value="{{ request('tanggal_mulai_izin') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" name="tanggal_selesai_izin" value="{{ request('tanggal_selesai_izin') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary d-block w-100">
                                                    <i class="fas fa-search"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
                                                    <th>Tugas Pengganti</th>
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
                                                        <td>
                                                            {{ $izin->keterangan ?? '-' }}
                                                            @php
                                                                $tugasList = collect([
                                                                    'Kelas 7' => $izin->tugas_kelas7,
                                                                    'Kelas 8' => $izin->tugas_kelas8,
                                                                    'Kelas 9' => $izin->tugas_kelas9,
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
                                                            @if($izin->tugas_kelas_7 || $izin->tugas_kelas_8 || $izin->tugas_kelas_9)
                                                                <ul class="mb-0 ps-3">
                                                                    @if($izin->tugas_kelas_7)
                                                                        <li><strong>Kelas 7:</strong> {{ $izin->tugas_kelas_7 }}</li>
                                                                    @endif
                                                                    @if($izin->tugas_kelas_8)
                                                                        <li><strong>Kelas 8:</strong> {{ $izin->tugas_kelas_8 }}</li>
                                                                    @endif
                                                                    @if($izin->tugas_kelas_9)
                                                                        <li><strong>Kelas 9:</strong> {{ $izin->tugas_kelas_9 }}</li>
                                                                    @endif
                                                                </ul>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
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
                                                        <td colspan="10" class="text-center text-muted">Belum ada data izin</td>
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
                                    <form method="GET" action="{{ route('tu.presensi.index') }}" id="filterSakitForm">
                                        <input type="hidden" name="tab" value="sakit">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" name="status_sakit" id="statusSakit">
                                                    <option value="">Semua Status</option>
                                                    <option value="pending" {{ request('status_sakit') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                                    <option value="approved" {{ request('status_sakit') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                                    <option value="rejected" {{ request('status_sakit') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Tanggal Mulai</label>
                                                <input type="date" class="form-control" name="tanggal_mulai_sakit" value="{{ request('tanggal_mulai_sakit') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" name="tanggal_selesai_sakit" value="{{ request('tanggal_selesai_sakit') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary d-block w-100">
                                                    <i class="fas fa-search"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
                                                    <th>Tugas Pengganti</th>
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
                                                        <td>
                                                            {{ $sakit->keterangan ?? '-' }}
                                                            @php
                                                                $tugasList = collect([
                                                                    'Kelas 7' => $sakit->tugas_kelas7,
                                                                    'Kelas 8' => $sakit->tugas_kelas8,
                                                                    'Kelas 9' => $sakit->tugas_kelas9,
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
                                                            @if($sakit->tugas_kelas_7 || $sakit->tugas_kelas_8 || $sakit->tugas_kelas_9)
                                                                <ul class="mb-0 ps-3">
                                                                    @if($sakit->tugas_kelas_7)
                                                                        <li><strong>Kelas 7:</strong> {{ $sakit->tugas_kelas_7 }}</li>
                                                                    @endif
                                                                    @if($sakit->tugas_kelas_8)
                                                                        <li><strong>Kelas 8:</strong> {{ $sakit->tugas_kelas_8 }}</li>
                                                                    @endif
                                                                    @if($sakit->tugas_kelas_9)
                                                                        <li><strong>Kelas 9:</strong> {{ $sakit->tugas_kelas_9 }}</li>
                                                                    @endif
                                                                </ul>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
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
                                                        <td colspan="9" class="text-center text-muted">Belum ada data sakit</td>
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

// Auto-submit filter saat dropdown Status berubah
document.addEventListener('DOMContentLoaded', function() {
    // Filter Hadir
    const statusHadir = document.getElementById('statusHadir');
    const filterHadirForm = document.getElementById('filterHadirForm');
    if (statusHadir && filterHadirForm) {
        statusHadir.addEventListener('change', function() {
            filterHadirForm.submit();
        });
    }
    
    // Filter Izin
    const statusIzin = document.getElementById('statusIzin');
    const filterIzinForm = document.getElementById('filterIzinForm');
    if (statusIzin && filterIzinForm) {
        statusIzin.addEventListener('change', function() {
            filterIzinForm.submit();
        });
    }
    
    // Filter Sakit
    const statusSakit = document.getElementById('statusSakit');
    const filterSakitForm = document.getElementById('filterSakitForm');
    if (statusSakit && filterSakitForm) {
        statusSakit.addEventListener('change', function() {
            filterSakitForm.submit();
        });
    }
    
    // Aktifkan tab sesuai parameter
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab) {
        const tabButton = document.querySelector(`[data-bs-target="#${tab}"]`);
        if (tabButton) {
            const tabTrigger = new bootstrap.Tab(tabButton);
            tabTrigger.show();
        }
    }
});
</script>
@endsection

@section('styles')
<style>
    /* Pagination Button Styles - Blue color, not green */
    .card-header .pagination-btn-active {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
        box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
        transition: all 0.3s ease;
    }
    
    .card-header .pagination-btn-active:hover {
        background-color: #0b5ed7 !important;
        border-color: #0a58ca !important;
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.4);
    }
    
    .card-header .pagination-btn-active:active,
    .card-header .pagination-btn-active:focus,
    .card-header .pagination-btn-active:visited {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
    }
    
    .card-header .pagination-btn-active:active {
        background-color: #0a58ca !important;
        border-color: #0a58ca !important;
        transform: translateY(0);
    }
    
    .card-header .btn-secondary.pagination-btn {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: white !important;
        opacity: 0.6;
    }
    
    .card-header .pagination-btn {
        padding: 8px 16px;
        font-size: 0.95rem;
        border-radius: 6px;
    }
    
    /* Override any green color that might be applied */
    .card-header .pagination-btn-active,
    .card-header .pagination-btn-active:hover,
    .card-header .pagination-btn-active:active,
    .card-header .pagination-btn-active:focus {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }
</style>
@endsection
