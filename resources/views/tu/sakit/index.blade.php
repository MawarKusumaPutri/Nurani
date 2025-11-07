@extends('layouts.tu')

@section('title', 'Data Sakit - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data Sakit</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.sakit.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Data Sakit
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                        <!-- Sample Data -->
                                        <tr>
                                            <td>1</td>
                                            <td>Dr. Ahmad Suryadi, M.Pd</td>
                                            <td>2024-10-25</td>
                                            <td>2024-10-27</td>
                                            <td>3 hari</td>
                                            <td>Demam tinggi</td>
                                            <td><span class="badge bg-success">Disetujui</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary" disabled>
                                                    <i class="fas fa-check"></i> Sudah Diproses
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Siti Nurhaliza, S.Pd</td>
                                            <td>2024-10-28</td>
                                            <td>2024-10-30</td>
                                            <td>3 hari</td>
                                            <td>Flu dan batuk</td>
                                            <td><span class="badge bg-warning">Menunggu</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-success me-1">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Budi Santoso, M.Pd</td>
                                            <td>2024-10-20</td>
                                            <td>2024-10-22</td>
                                            <td>3 hari</td>
                                            <td>Migrain</td>
                                            <td><span class="badge bg-danger">Ditolak</span></td>
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
