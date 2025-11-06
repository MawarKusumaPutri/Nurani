@extends('layouts.tu')

@section('title', 'Kalender - TU Dashboard')

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
                        <a class="nav-link" href="{{ route('tu.jadwal.index') }}">
                            <i class="fas fa-calendar"></i> Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tu.kalender.index') }}">
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
                        <a class="nav-link" href="{{ route('tu.pengumuman.index') }}">
                            <i class="fas fa-bullhorn"></i> Pengumuman
                        </a>
                    </li>
                </ul>
                
                <div class="mt-auto">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kalender Akademik</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.kalender.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Event
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
                                    <label class="form-label">Kategori Event</label>
                                    <select class="form-select">
                                        <option value="">Semua Kategori</option>
                                        <option value="akademik">Akademik</option>
                                        <option value="ujian">Ujian</option>
                                        <option value="libur">Libur</option>
                                        <option value="rapat">Rapat</option>
                                        <option value="pelatihan">Pelatihan</option>
                                        <option value="kegiatan">Kegiatan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Bulan</label>
                                    <select class="form-select">
                                        <option value="10">Oktober 2024</option>
                                        <option value="11">November 2024</option>
                                        <option value="12">Desember 2024</option>
                                        <option value="1">Januari 2025</option>
                                        <option value="2">Februari 2025</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cari Event</label>
                                    <input type="text" class="form-control" placeholder="Judul atau deskripsi event">
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

            <!-- Calendar View -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-alt"></i> Kalender Akademik - Oktober 2024
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Calendar Grid -->
                            <div class="table-responsive">
                                <table class="table table-bordered calendar-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Minggu</th>
                                            <th class="text-center">Senin</th>
                                            <th class="text-center">Selasa</th>
                                            <th class="text-center">Rabu</th>
                                            <th class="text-center">Kamis</th>
                                            <th class="text-center">Jumat</th>
                                            <th class="text-center">Sabtu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center text-muted">29</td>
                                            <td class="text-center text-muted">30</td>
                                            <td class="text-center">1</td>
                                            <td class="text-center">2</td>
                                            <td class="text-center">3</td>
                                            <td class="text-center">4</td>
                                            <td class="text-center">5</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">6</td>
                                            <td class="text-center">7</td>
                                            <td class="text-center">8</td>
                                            <td class="text-center">9</td>
                                            <td class="text-center">10</td>
                                            <td class="text-center">11</td>
                                            <td class="text-center">12</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">13</td>
                                            <td class="text-center">14</td>
                                            <td class="text-center">15</td>
                                            <td class="text-center">16</td>
                                            <td class="text-center">17</td>
                                            <td class="text-center">18</td>
                                            <td class="text-center">19</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">20</td>
                                            <td class="text-center">21</td>
                                            <td class="text-center">22</td>
                                            <td class="text-center">23</td>
                                            <td class="text-center">24</td>
                                            <td class="text-center">25</td>
                                            <td class="text-center">26</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">27</td>
                                            <td class="text-center">28</td>
                                            <td class="text-center">29</td>
                                            <td class="text-center">30</td>
                                            <td class="text-center">31</td>
                                            <td class="text-center text-muted">1</td>
                                            <td class="text-center text-muted">2</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events List -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list"></i> Daftar Event Bulan Ini
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="event-item mb-3 p-3 border rounded" style="border-left: 4px solid #007bff;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Ujian Tengah Semester</h6>
                                                <p class="text-muted mb-1">15-20 Oktober 2024</p>
                                                <small class="text-muted">Kategori: Ujian</small>
                                            </div>
                                            <span class="badge bg-primary">Akademik</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="event-item mb-3 p-3 border rounded" style="border-left: 4px solid #28a745;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Rapat Koordinasi Guru</h6>
                                                <p class="text-muted mb-1">25 Oktober 2024, 08:00</p>
                                                <small class="text-muted">Kategori: Rapat</small>
                                            </div>
                                            <span class="badge bg-success">Rapat</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="event-item mb-3 p-3 border rounded" style="border-left: 4px solid #ffc107;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Libur Hari Raya</h6>
                                                <p class="text-muted mb-1">1-3 November 2024</p>
                                                <small class="text-muted">Kategori: Libur</small>
                                            </div>
                                            <span class="badge bg-warning">Libur</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="event-item mb-3 p-3 border rounded" style="border-left: 4px solid #dc3545;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Pelatihan Guru</h6>
                                                <p class="text-muted mb-1">28 Oktober 2024, 09:00</p>
                                                <small class="text-muted">Kategori: Pelatihan</small>
                                            </div>
                                            <span class="badge bg-danger">Pelatihan</span>
                                        </div>
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
