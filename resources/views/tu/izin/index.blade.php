@extends('layouts.tu')

@section('title', 'Manajemen Izin - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Izin</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
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
                                        <!-- Sample Data -->
                                        <tr>
                                            <td>1</td>
                                            <td>Dr. Ahmad Suryadi, M.Pd</td>
                                            <td>Cuti Tahunan</td>
                                            <td>2024-11-01</td>
                                            <td>2024-11-05</td>
                                            <td>5 hari</td>
                                            <td>Keperluan keluarga</td>
                                            <td>
                                                <span class="badge bg-warning">Menunggu</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success me-1" onclick="approveIzin(1)">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="rejectIzin(1)">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Siti Nurhaliza, S.Pd</td>
                                            <td>Izin Sakit</td>
                                            <td>2024-10-28</td>
                                            <td>2024-10-30</td>
                                            <td>3 hari</td>
                                            <td>Demam tinggi</td>
                                            <td>
                                                <span class="badge bg-success">Disetujui</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary" disabled>
                                                    <i class="fas fa-check"></i> Sudah Diproses
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Budi Santoso, M.Pd</td>
                                            <td>Izin Pribadi</td>
                                            <td>2024-10-25</td>
                                            <td>2024-10-25</td>
                                            <td>1 hari</td>
                                            <td>Urusan keluarga mendesak</td>
                                            <td>
                                                <span class="badge bg-danger">Ditolak</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary" disabled>
                                                    <i class="fas fa-times"></i> Sudah Diproses
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
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
function approveIzin(id) {
    if (confirm('Apakah Anda yakin ingin menyetujui izin ini?')) {
        // Implementation for approving izin
        window.location.href = '{{ route("tu.izin.approve", ":id") }}'.replace(':id', id);
    }
}

function rejectIzin(id) {
    if (confirm('Apakah Anda yakin ingin menolak izin ini?')) {
        // Implementation for rejecting izin
        window.location.href = '{{ route("tu.izin.reject", ":id") }}'.replace(':id', id);
    }
}
</script>
@endsection
