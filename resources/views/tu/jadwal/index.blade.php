@extends('layouts.tu')

@section('title', 'Jadwal - TU Dashboard')

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
                        <a class="nav-link" href="{{ route('tu.presensi.index') }}">
                            <i class="fas fa-calendar-check"></i> Presensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tu.jadwal.index') }}">
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
                <h1 class="h2">Jadwal Pelajaran</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.jadwal.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Jadwal
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
                                    <label class="form-label">Kelas</label>
                                    <select class="form-select">
                                        <option value="">Semua Kelas</option>
                                        <option value="7">Kelas 7</option>
                                        <option value="8">Kelas 8</option>
                                        <option value="9">Kelas 9</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Hari</label>
                                    <select class="form-select">
                                        <option value="">Semua Hari</option>
                                        <option value="senin">Senin</option>
                                        <option value="selasa">Selasa</option>
                                        <option value="rabu">Rabu</option>
                                        <option value="kamis">Kamis</option>
                                        <option value="jumat">Jumat</option>
                                        <option value="sabtu">Sabtu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cari Jadwal</label>
                                    <input type="text" class="form-control" placeholder="Mata pelajaran atau nama guru">
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

            <!-- Jadwal Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar"></i> Daftar Jadwal Pelajaran
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Kelas</th>
                                            <th>Hari</th>
                                            <th>Waktu</th>
                                            <th>Ruang</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Sample Data -->
                                        <tr>
                                            <td>1</td>
                                            <td><i class="fas fa-calculator text-primary"></i> Matematika</td>
                                            <td>Budi Santoso, S.Pd</td>
                                            <td><span class="badge bg-primary">7A</span></td>
                                            <td>Senin</td>
                                            <td>07:00 - 07:45</td>
                                            <td>Ruang 7A</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><i class="fas fa-book text-success"></i> Bahasa Indonesia</td>
                                            <td>Siti Aminah, S.Pd</td>
                                            <td><span class="badge bg-success">7B</span></td>
                                            <td>Senin</td>
                                            <td>07:45 - 08:30</td>
                                            <td>Ruang 7B</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><i class="fas fa-flask text-warning"></i> IPA</td>
                                            <td>Joko Susilo, M.Pd</td>
                                            <td><span class="badge bg-warning">8A</span></td>
                                            <td>Selasa</td>
                                            <td>08:30 - 09:15</td>
                                            <td>Lab IPA</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><i class="fas fa-globe text-info"></i> Bahasa Inggris</td>
                                            <td>Rina Wulandari, S.Pd</td>
                                            <td><span class="badge bg-info">9A</span></td>
                                            <td>Rabu</td>
                                            <td>09:15 - 10:00</td>
                                            <td>Ruang 9A</td>
                                            <td><span class="badge bg-warning">Sementara</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td><i class="fas fa-chart-line text-danger"></i> IPS</td>
                                            <td>Ahmad Fauzi, S.Pd</td>
                                            <td><span class="badge bg-danger">8B</span></td>
                                            <td>Kamis</td>
                                            <td>10:00 - 10:45</td>
                                            <td>Ruang 8B</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
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
