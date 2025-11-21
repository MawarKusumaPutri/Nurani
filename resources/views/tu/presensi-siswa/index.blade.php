@extends('layouts.tu')

@section('title', 'Presensi Siswa - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-user-graduate me-2"></i>
                    Presensi Siswa
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.presensi-siswa.rekap') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-chart-bar me-2"></i> Rekap Presensi
                        </a>
                        <a href="{{ route('tu.presensi-siswa.export') }}?kelas={{ $selectedKelas }}&bulan={{ date('Y-m') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-2"></i> Export
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Total Presensi</h5>
                            <h2 class="mb-0">{{ $totalPresensi }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Hadir</h5>
                            <h2 class="mb-0">{{ $presensiHadir }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Sakit</h5>
                            <h2 class="mb-0">{{ $presensiSakit }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Izin</h5>
                            <h2 class="mb-0">{{ $presensiIzin }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i> Filter Presensi
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('tu.presensi-siswa.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas" class="form-select">
                                <option value="">Semua Kelas</option>
                                <option value="7" {{ $selectedKelas == '7' ? 'selected' : '' }}>Kelas 7</option>
                                <option value="8" {{ $selectedKelas == '8' ? 'selected' : '' }}>Kelas 8</option>
                                <option value="9" {{ $selectedKelas == '9' ? 'selected' : '' }}>Kelas 9</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $selectedTanggal }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="hadir" {{ $selectedStatus == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="sakit" {{ $selectedStatus == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="izin" {{ $selectedStatus == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="alfa" {{ $selectedStatus == 'alfa' ? 'selected' : '' }}>Alfa</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cari Nama/NIS</label>
                            <input type="text" name="search" class="form-control" placeholder="Nama atau NIS" value="{{ $searchNama }}">
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i> Filter
                            </button>
                            <a href="{{ route('tu.presensi-siswa.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Presensi List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i> Daftar Presensi Siswa
                    </h5>
                </div>
                <div class="card-body">
                    @if($presensiSiswa->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Guru</th>
                                        <th>Waktu Input</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensiSiswa as $index => $presensi)
                                        <tr>
                                            <td>{{ $presensiSiswa->firstItem() + $index }}</td>
                                            <td>{{ $presensi->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $presensi->siswa->nis }}</td>
                                            <td><strong>{{ $presensi->siswa->nama }}</strong></td>
                                            <td>Kelas {{ $presensi->siswa->kelas }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = match($presensi->status) {
                                                        'hadir' => 'success',
                                                        'sakit' => 'warning',
                                                        'izin' => 'info',
                                                        'alfa' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $badgeClass }}">
                                                    {{ $presensi->status_label }}
                                                </span>
                                            </td>
                                            <td>{{ $presensi->keterangan ?? '-' }}</td>
                                            <td>{{ $presensi->guru->user->name }}</td>
                                            <td>{{ $presensi->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted small">
                                @if($presensiSiswa->total() > 0)
                                    Menampilkan {{ $presensiSiswa->firstItem() }} sampai {{ $presensiSiswa->lastItem() }} dari {{ $presensiSiswa->total() }} hasil
                                @else
                                    Tidak ada hasil
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                @if($presensiSiswa->onFirstPage())
                                    <button class="btn btn-outline-secondary btn-sm" disabled>
                                        <i class="fas fa-chevron-left me-1"></i> Previous
                                    </button>
                                @else
                                    <a href="{{ $presensiSiswa->previousPageUrl() }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-chevron-left me-1"></i> Previous
                                    </a>
                                @endif
                                
                                <span class="text-muted small px-2 d-flex align-items-center">
                                    Halaman {{ $presensiSiswa->currentPage() }} / {{ $presensiSiswa->lastPage() }}
                                </span>
                                
                                @if($presensiSiswa->hasMorePages())
                                    <a href="{{ $presensiSiswa->nextPageUrl() }}" class="btn btn-outline-primary btn-sm">
                                        Next <i class="fas fa-chevron-right ms-1"></i>
                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary btn-sm" disabled>
                                        Next <i class="fas fa-chevron-right ms-1"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada data presensi siswa yang ditemukan.
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

