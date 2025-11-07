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
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Kelas</label>
                                    <select class="form-select">
                                        <option value="">Semua Kelas</option>
                                        <option value="7">Kelas 7</option>
                                        <option value="8">Kelas 8</option>
                                        <option value="9">Kelas 9</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak_aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cari Siswa</label>
                                    <input type="text" class="form-control" placeholder="Nama atau NIS">
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
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
                                Total: <strong>3</strong> siswa
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
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
@endsection
