@extends('layouts.tu')

@section('title', 'Data Guru - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data Guru</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.guru.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Guru
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('tu.guru.index') }}" id="filterForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Mata Pelajaran</label>
                                        <select name="mata_pelajaran" class="form-select" id="mataPelajaranFilter" onchange="document.getElementById('filterForm').submit();">
                                            <option value="">Semua Mata Pelajaran</option>
                                            @foreach($mataPelajaranList as $mp)
                                                <option value="{{ $mp }}" {{ $mataPelajaran == $mp ? 'selected' : '' }}>
                                                    {{ $mp }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" id="statusFilter" onchange="document.getElementById('filterForm').submit();">
                                            <option value="">Semua Status</option>
                                            <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="tidak_aktif" {{ $status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Cari Guru</label>
                                        <input type="text" name="search" class="form-control" id="searchInput" placeholder="Nama atau NIP" value="{{ $search }}" onkeypress="if(event.key === 'Enter') { document.getElementById('filterForm').submit(); }">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary d-block w-100">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                                @if($mataPelajaran || $status || $search)
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <a href="{{ route('tu.guru.index') }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-times"></i> Reset Filter
                                        </a>
                                        @if($mataPelajaran)
                                            <span class="badge bg-info ms-2">Mata Pelajaran: {{ $mataPelajaran }}</span>
                                        @endif
                                        @if($status)
                                            <span class="badge bg-info ms-2">Status: {{ ucfirst($status) }}</span>
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

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Guru List -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chalkboard-teacher"></i> Daftar Guru
                                </h5>
                                @if($gurus->count() > 0)
                                <!-- Pagination Controls - Moved to Top -->
                                <div class="d-flex gap-2 align-items-center">
                                    @if($gurus->onFirstPage())
                                        <button class="btn btn-outline-secondary btn-sm" disabled style="min-width: 100px; opacity: 0.5;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </button>
                                    @else
                                        <a href="{{ $gurus->previousPageUrl() }}" class="btn btn-sm" style="min-width: 100px; background-color: #0d6efd; color: white; border-color: #0d6efd; font-weight: 600;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </a>
                                    @endif
                                    
                                    <span class="text-dark small px-3 d-flex align-items-center fw-bold" style="font-size: 14px;">
                                        Halaman {{ $gurus->currentPage() }} / {{ $gurus->lastPage() }}
                                    </span>
                                    
                                    @if($gurus->hasMorePages())
                                        <a href="{{ $gurus->nextPageUrl() }}" class="btn btn-sm" style="min-width: 100px; background-color: #0d6efd; color: white; border-color: #0d6efd; font-weight: 600;">
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled style="min-width: 100px; opacity: 0.5;">
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </button>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if($gurus->count() > 0)
                            <!-- Pagination Info -->
                            <div class="mb-3">
                                <div class="text-muted small">
                                    Menampilkan {{ $gurus->firstItem() }} sampai {{ $gurus->lastItem() }} dari {{ $gurus->total() }} guru
                                </div>
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama Guru</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No. HP</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($gurus as $index => $guru)
                                        <tr>
                                            <td>{{ $gurus->firstItem() + $index }}</td>
                                            <td>{{ $guru->nip }}</td>
                                            <td>{{ $guru->user->name }}</td>
                                            <td>{{ $guru->mata_pelajaran ?? 'Belum ditentukan' }}</td>
                                            <td>{{ $guru->user->jenis_kelamin ?? '-' }}</td>
                                            <td>{{ $guru->user->phone ?? '-' }}</td>
                                            <td>
                                                @if($guru->status === 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-warning">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('tu.guru.edit', $guru->id) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('tu.guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirmHapus('{{ $guru->user->name }}', '{{ $guru->nip }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Tidak ada data guru</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
<style>
.pagination-custom .btn {
    min-width: 100px;
}

.btn-sm {
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}
</style>
<script>
function confirmHapus(nama, nip) {
    return confirm('Apakah Anda yakin ingin menghapus data guru ' + nama + ' (NIP: ' + nip + ')?\n\nData yang dihapus tidak dapat dikembalikan!');
}

// Show success/error messages
@if(session('success'))
    alert('{{ session('success') }}');
@endif

@if(session('error'))
    alert('{{ session('error') }}');
@endif
</script>
@endsection
