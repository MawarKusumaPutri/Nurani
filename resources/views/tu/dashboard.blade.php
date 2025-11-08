@extends('layouts.tu')

@section('title', 'Dashboard TU - TMS NURANI')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Tenaga Usaha</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="p-3 rounded-circle bg-primary text-white">
                                    <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                </div>
                            </div>
                            <h3 class="card-title text-primary">{{ \App\Models\Guru::count() }}</h3>
                            <p class="card-text text-muted">Total Guru</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="p-3 rounded-circle bg-success text-white">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                            <h3 class="card-title text-success">{{ $totalSiswa }}</h3>
                            <p class="card-text text-muted">Total Siswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="p-3 rounded-circle bg-warning text-white">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                            <h3 class="card-title text-warning">5</h3>
                            <p class="card-text text-muted">Izin Menunggu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="p-3 rounded-circle bg-info text-white">
                                    <i class="fas fa-file-alt fa-2x"></i>
                                </div>
                            </div>
                            <h3 class="card-title text-info">24</h3>
                            <p class="card-text text-muted">Dokumen Arsip</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tachometer-alt"></i> Menu Utama
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('tu.guru.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                        <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                                        <h6>Data Guru</h6>
                                        <small class="text-muted">Kelola data guru</small>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('tu.siswa.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h6>Data Siswa</h6>
                                        <small class="text-muted">Kelola data siswa</small>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('tu.presensi.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                        <i class="fas fa-calendar-check fa-3x mb-3"></i>
                                        <h6>Presensi</h6>
                                        <small class="text-muted">Presensi, Izin & Sakit</small>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('tu.jadwal.index') }}" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                        <i class="fas fa-calendar fa-3x mb-3"></i>
                                        <h6>Jadwal</h6>
                                        <small class="text-muted">Jadwal pelajaran</small>
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('tu.arsip.index') }}" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                        <i class="fas fa-archive fa-3x mb-3"></i>
                                        <h6>Arsip</h6>
                                        <small class="text-muted">Arsip dokumen</small>
                                    </a>
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