@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('partials.tu-sidebar')

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-graduation-cap me-2 text-primary"></i>
                        Data Alumni
                    </h2>
                    <p class="text-muted mb-0">Kelola data siswa yang sudah lulus</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('tu.alumni.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Tambah Alumni
                    </a>
                    <a href="{{ route('tu.alumni.export') }}" class="btn btn-primary">
                        <i class="fas fa-file-export me-2"></i>Export
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filter Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('tu.alumni.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="kelas" class="form-label">Kelas Terakhir</label>
                            <select name="kelas" id="kelas" class="form-select">
                                <option value="">Semua Kelas</option>
                                <option value="7" {{ request('kelas') == '7' ? 'selected' : '' }}>Kelas 7</option>
                                <option value="8" {{ request('kelas') == '8' ? 'selected' : '' }}>Kelas 8</option>
                                <option value="9" {{ request('kelas') == '9' ? 'selected' : '' }}>Kelas 9</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                            <select name="tahun_lulus" id="tahun_lulus" class="form-select">
                                <option value="">Semua Tahun</option>
                                @for($year = date('Y'); $year >= 2015; $year--)
                                    <option value="{{ $year }}" {{ request('tahun_lulus') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Siswa</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                   placeholder="Nama atau NIS" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Alumni List -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>JK</th>
                                    <th>Kelas Terakhir</th>
                                    <th>Tahun Lulus</th>
                                    <th>Sekolah Lanjutan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alumni as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nis }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>Kelas {{ $item->kelas_terakhir }}</td>
                                        <td>{{ $item->tahun_lulus }}</td>
                                        <td>{{ $item->sekolah_lanjutan ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('tu.alumni.edit', $item->id) }}" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" 
                                                        onclick="deleteAlumni({{ $item->id }})" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                            Tidak ada data alumni
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($alumni->count() > 0)
                        <div class="mt-3">
                            <p class="text-muted mb-0">
                                <i class="fas fa-users me-2"></i>
                                Total: <strong>{{ $alumni->count() }}</strong> alumni
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteAlumni(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data alumni ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("tu/alumni") }}/' + id;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
