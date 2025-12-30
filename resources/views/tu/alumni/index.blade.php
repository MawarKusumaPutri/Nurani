@extends('layouts.tu')

@section('title', 'Data Alumni - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data Alumni</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.siswa.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Data Siswa
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('tu.alumni.index') }}" id="filterForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Tahun Lulus</label>
                                        <select name="tahun_lulus" class="form-select" id="tahunLulusFilter" onchange="document.getElementById('filterForm').submit();">
                                            <option value="">Semua Tahun</option>
                                            @for($year = date('Y'); $year >= 2000; $year--)
                                                <option value="{{ $year }}" {{ $tahunLulus == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Cari Alumni</label>
                                        <input type="text" name="search" class="form-control" id="searchInput" placeholder="Nama atau NIS" value="{{ $search }}" onkeypress="if(event.key === 'Enter') { document.getElementById('filterForm').submit(); }">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary d-block w-100">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                                @if($tahunLulus || $search)
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <a href="{{ route('tu.alumni.index') }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-times"></i> Reset Filter
                                        </a>
                                        @if($tahunLulus)
                                            <span class="badge bg-info ms-2">Tahun: {{ $tahunLulus }}</span>
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

            <!-- Alumni List -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-graduate me-2"></i> Daftar Alumni
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px;">No</th>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Kelas Terakhir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tahun Lulus</th>
                                            <th>Status</th>
                                            <th style="width: 100px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($alumni as $index => $alum)
                                        <tr>
                                            <td>{{ $alumni->firstItem() + $index }}</td>
                                            <td>{{ $alum->nis }}</td>
                                            <td>{{ $alum->nama }}</td>
                                            <td>Kelas {{ $alum->kelas }}</td>
                                            <td>{{ $alum->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                                            <td>{{ $alum->tahun_lulus ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $alum->status === 'lulus' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($alum->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-info me-1" title="Detail" data-bs-toggle="modal" data-bs-target="#detailModal{{ $alum->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Detail Modal -->
                                        <div class="modal fade" id="detailModal{{ $alum->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title">Detail Alumni</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <th width="40%">NIS</th>
                                                                <td>{{ $alum->nis }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nama</th>
                                                                <td>{{ $alum->nama }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kelas Terakhir</th>
                                                                <td>Kelas {{ $alum->kelas }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jenis Kelamin</th>
                                                                <td>{{ $alum->jenis_kelamin }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tempat, Tanggal Lahir</th>
                                                                <td>{{ $alum->tempat_lahir ?? '-' }}, {{ $alum->tanggal_lahir ? \Carbon\Carbon::parse($alum->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Alamat</th>
                                                                <td>{{ $alum->alamat ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>No. Telepon Orangtua</th>
                                                                <td>{{ $alum->no_telp ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Email</th>
                                                                <td>{{ $alum->email ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tahun Lulus</th>
                                                                <td>{{ $alum->tahun_lulus ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status</th>
                                                                <td>
                                                                    <span class="badge bg-{{ $alum->status === 'lulus' ? 'success' : 'secondary' }}">
                                                                        {{ ucfirst($alum->status) }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">Tidak ada data alumni</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-user-graduate me-1"></i>
                                    Total: <strong>{{ $alumni->total() }}</strong> alumni
                                </small>
                                {{ $alumni->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
