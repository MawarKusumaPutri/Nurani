@extends('layouts.tu')

@section('title', 'Surat - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Surat Menyurat</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.surat.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Buat Surat
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
                                    <label class="form-label">Jenis Surat</label>
                                    <select class="form-select">
                                        <option value="">Semua Jenis</option>
                                        <option value="surat_keputusan">Surat Keputusan</option>
                                        <option value="surat_edaran">Surat Edaran</option>
                                        <option value="surat_undangan">Surat Undangan</option>
                                        <option value="surat_tugas">Surat Tugas</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="draft">Draft</option>
                                        <option value="terkirim">Terkirim</option>
                                        <option value="diterima">Diterima</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cari Surat</label>
                                    <input type="text" class="form-control" placeholder="Nomor surat atau perihal">
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

            <!-- Surat Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-envelope"></i> Daftar Surat Menyurat
                            </h5>
                                @if($surats->count() > 0)
                                <!-- Pagination Controls - Moved to Top -->
                                <div class="d-flex gap-2 align-items-center">
                                    @if($surats->onFirstPage())
                                        <button class="btn btn-outline-secondary btn-sm" disabled style="min-width: 100px; opacity: 0.5;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </button>
                                    @else
                                        <a href="{{ $surats->previousPageUrl() }}" class="btn btn-sm" style="min-width: 100px; background-color: #0d6efd; color: white; border-color: #0d6efd; font-weight: 600;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </a>
                                    @endif
                                    
                                    <span class="text-dark small px-3 d-flex align-items-center fw-bold" style="font-size: 14px;">
                                        Halaman {{ $surats->currentPage() }} / {{ $surats->lastPage() }}
                                    </span>
                                    
                                    @if($surats->hasMorePages())
                                        <a href="{{ $surats->nextPageUrl() }}" class="btn btn-sm" style="min-width: 100px; background-color: #0d6efd; color: white; border-color: #0d6efd; font-weight: 600;">
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
                            @if($surats->count() > 0)
                            <!-- Pagination Info -->
                            <div class="mb-3">
                                <div class="text-muted small">
                                    Menampilkan {{ $surats->firstItem() }} sampai {{ $surats->lastItem() }} dari {{ $surats->total() }} surat
                                </div>
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Surat</th>
                                            <th>Jenis</th>
                                            <th>Perihal</th>
                                            <th>Kepada</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($surats->count() > 0)
                                            @foreach($surats as $index => $surat)
                                                @php
                                                    $jenisBadge = match($surat->jenis_surat) {
                                                        'surat_keputusan' => 'bg-primary',
                                                        'surat_edaran' => 'bg-info',
                                                        'surat_undangan' => 'bg-warning',
                                                        'surat_tugas' => 'bg-secondary',
                                                        'surat_izin' => 'bg-success',
                                                        'surat_pengumuman' => 'bg-primary',
                                                        'surat_permohonan' => 'bg-info',
                                                        'surat_balasan' => 'bg-secondary',
                                                        default => 'bg-secondary'
                                                    };
                                                    
                                                    $jenisLabel = match($surat->jenis_surat) {
                                                        'surat_keputusan' => 'Surat Keputusan',
                                                        'surat_edaran' => 'Surat Edaran',
                                                        'surat_undangan' => 'Surat Undangan',
                                                        'surat_tugas' => 'Surat Tugas',
                                                        'surat_izin' => 'Surat Izin',
                                                        'surat_pengumuman' => 'Surat Pengumuman',
                                                        'surat_permohonan' => 'Surat Permohonan',
                                                        'surat_balasan' => 'Surat Balasan',
                                                        default => 'Surat'
                                                    };
                                                    
                                                    $statusBadge = match($surat->status) {
                                                        'draft' => 'bg-warning',
                                                        'terkirim' => 'bg-success',
                                                        'diterima' => 'bg-info',
                                                        default => 'bg-secondary'
                                                    };
                                                    
                                                    $statusLabel = match($surat->status) {
                                                        'draft' => 'Draft',
                                                        'terkirim' => 'Terkirim',
                                                        'diterima' => 'Diterima',
                                                        default => ucfirst($surat->status)
                                                    };
                                                    
                                                    $penerimaText = match($surat->penerima) {
                                                        'kepala_sekolah' => 'Kepala Sekolah',
                                                        'guru' => 'Semua Guru',
                                                        'siswa' => 'Semua Siswa',
                                                        'orang_tua' => 'Orang Tua Siswa',
                                                        'yayasan' => 'Yayasan',
                                                        'dinas_pendidikan' => 'Dinas Pendidikan',
                                                        'lainnya' => $surat->penerima_lainnya ?? 'Lainnya',
                                                        default => 'Penerima'
                                                    };
                                                @endphp
                                                <tr>
                                                    <td>{{ $surats->firstItem() + $index }}</td>
                                                    <td>{{ $surat->nomor_surat }}</td>
                                                    <td><span class="badge {{ $jenisBadge }}">{{ $jenisLabel }}</span></td>
                                                    <td>{{ $surat->perihal }}</td>
                                                    <td>{{ $penerimaText }}</td>
                                                    <td>{{ $surat->tanggal_surat->format('d M Y') }}</td>
                                                    <td><span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span></td>
                                                    <td>
                                                        <a href="{{ route('tu.surat.show', $surat->id) }}" class="btn btn-sm btn-primary me-1" title="Lihat Detail Surat">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                        @if($surat->status == 'draft')
                                                            <a href="{{ route('tu.surat.edit', $surat->id) }}" class="btn btn-sm btn-warning me-1">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <button class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        @endif
                                                        @if($surat->lampiran)
                                                            <a href="{{ route('tu.surat.lampiran.download', $surat->id) }}" class="btn btn-sm btn-outline-secondary" title="Download Lampiran">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                                        <p class="mb-0">Belum ada surat yang tersimpan.</p>
                                                        <a href="{{ route('tu.surat.create') }}" class="btn btn-primary mt-3">
                                                            <i class="fas fa-plus"></i> Buat Surat Pertama
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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

@section('styles')
<style>
    /* Pagination Button Styles - Blue color, not green */
    .card-header .pagination-btn-active {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
        box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
        transition: all 0.3s ease;
    }
    
    .card-header .pagination-btn-active:hover {
        background-color: #0b5ed7 !important;
        border-color: #0a58ca !important;
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.4);
    }
    
    .card-header .pagination-btn-active:active,
    .card-header .pagination-btn-active:focus,
    .card-header .pagination-btn-active:visited {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
    }
    
    .card-header .pagination-btn-active:active {
        background-color: #0a58ca !important;
        border-color: #0a58ca !important;
        transform: translateY(0);
    }
    
    .card-header .btn-secondary.pagination-btn {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: white !important;
        opacity: 0.6;
    }
    
    .card-header .pagination-btn {
        padding: 8px 16px;
        font-size: 0.95rem;
        border-radius: 6px;
    }
    
    /* Override any green color that might be applied */
    .card-header .pagination-btn-active,
    .card-header .pagination-btn-active:hover,
    .card-header .pagination-btn-active:active,
    .card-header .pagination-btn-active:focus {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }
</style>
@endsection
