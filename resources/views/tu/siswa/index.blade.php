@extends('layouts.tu')

@section('title', 'Data Siswa - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data Siswa</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.siswa.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </a>
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-excel"></i> Import Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <a href="{{ route('tu.alumni.index') }}" class="btn btn-sm btn-info">
                            <i class="fas fa-user-graduate"></i> Data Alumni
                        </a>
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
                            <form method="GET" action="{{ route('tu.siswa.index') }}" id="filterForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Kelas</label>
                                        <select name="kelas" class="form-select" id="kelasFilter" onchange="document.getElementById('filterForm').submit();">
                                            <option value="">Semua Kelas</option>
                                            <option value="7" {{ $kelasFilter == '7' ? 'selected' : '' }}>Kelas 7</option>
                                            <option value="8" {{ $kelasFilter == '8' ? 'selected' : '' }}>Kelas 8</option>
                                            <option value="9" {{ $kelasFilter == '9' ? 'selected' : '' }}>Kelas 9</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" id="statusFilter" onchange="document.getElementById('filterForm').submit();">
                                            <option value="">Semua Status</option>
                                            <option value="aktif" {{ $statusFilter == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="tidak_aktif" {{ $statusFilter == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Cari Siswa</label>
                                        <input type="text" name="search" class="form-control" id="searchInput" placeholder="Nama atau NIS" value="{{ $search }}" onkeypress="if(event.key === 'Enter') { document.getElementById('filterForm').submit(); }">
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
                                        <a href="{{ route('tu.siswa.index') }}" class="btn btn-sm btn-outline-secondary">
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
                                            <th style="width: 100px;">Aksi</th>
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
                                            <td>
                                                <a href="{{ route('tu.siswa.edit', $siswa->id) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('tu.siswa.destroy', $siswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $siswa->nama }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Tidak ada data siswa</td>
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
                                            <th style="width: 100px;">Aksi</th>
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
                                            <td>
                                                <a href="{{ route('tu.siswa.edit', $siswa->id) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('tu.siswa.destroy', $siswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $siswa->nama }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Tidak ada data siswa</td>
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
                                            <th style="width: 100px;">Aksi</th>
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
                                            <td>
                                                <a href="{{ route('tu.siswa.edit', $siswa->id) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('tu.siswa.destroy', $siswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $siswa->nama }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Tidak ada data siswa</td>
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
        </main>
    </div>
</div>

{{-- Modal Import Excel --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-excel me-2"></i>
                    Import Data Siswa dari Excel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Tabs untuk pilihan import --}}
                <ul class="nav nav-tabs mb-3" id="importTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-panel" type="button" role="tab">
                            <i class="fas fa-upload me-2"></i>Upload File
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="paste-tab" data-bs-toggle="tab" data-bs-target="#paste-panel" type="button" role="tab">
                            <i class="fas fa-paste me-2"></i>Copy-Paste dari Excel
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="importTabContent">
                    {{-- Tab 1: Upload File --}}
                    <div class="tab-pane fade show active" id="upload-panel" role="tabpanel">
                        <form action="{{ route('tu.siswa.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- Download Template --}}
                            <div class="alert alert-info">
                                <h6 class="alert-heading">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Langkah-langkah Import:
                                </h6>
                                <ol class="mb-2">
                                    <li>Download template Excel di bawah ini</li>
                                    <li>Isi data siswa sesuai format template</li>
                                    <li>Upload file Excel yang sudah diisi</li>
                                    <li>Klik "Import Data"</li>
                                </ol>
                                <a href="{{ route('tu.siswa.template') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download me-2"></i>
                                    Download Template Excel
                                </a>
                            </div>

                    {{-- Format Template Info --}}
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong>Format Template Excel:</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-muted">
                                            <td>10120</td>
                                            <td>Ahmad Fauzi</td>
                                            <td>7</td>
                                            <td>Laki-laki</td>
                                            <td>Jakarta</td>
                                            <td>2010-05-15</td>
                                            <td>Jl. Merdeka No. 10</td>
                                            <td>aktif</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">
                                <strong>Catatan:</strong>
                                <ul class="mb-0">
                                    <li>Kelas: 7, 8, atau 9</li>
                                    <li>Jenis Kelamin: "Laki-laki" atau "Perempuan"</li>
                                    <li>Tanggal Lahir: Format YYYY-MM-DD (contoh: 2010-05-15)</li>
                                    <li>Status: "aktif" atau "tidak_aktif"</li>
                                </ul>
                            </small>
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">
                            <strong>Pilih File Excel:</strong>
                        </label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" 
                               accept=".xlsx,.xls" required>
                        <small class="text-muted">Format: .xlsx atau .xls (Max: 2MB)</small>
                    </div>

                    {{-- Preview Info --}}
                    <div id="fileInfo" class="alert alert-secondary d-none">
                        <i class="fas fa-file-excel me-2"></i>
                        <span id="fileName"></span>
                        <span id="fileSize" class="text-muted ms-2"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload me-2"></i>Import Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// File upload preview
document.getElementById('excel_file')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        
        fileName.textContent = file.name;
        fileSize.textContent = '(' + (file.size / 1024).toFixed(2) + ' KB)';
        fileInfo.classList.remove('d-none');
    }
});
</script>

@endsection
