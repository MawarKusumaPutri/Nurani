@extends('layouts.tu')

@section('title', 'Arsip - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Arsip Dokumen</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.arsip.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-upload"></i> Upload Dokumen
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
                                    <label class="form-label">Kategori</label>
                                    <select class="form-select">
                                        <option value="">Semua Kategori</option>
                                        <option value="akademik">Akademik</option>
                                        <option value="administrasi">Administrasi</option>
                                        <option value="keuangan">Keuangan</option>
                                        <option value="sdm">SDM</option>
                                        <option value="fasilitas">Fasilitas</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Prioritas</label>
                                    <select class="form-select">
                                        <option value="">Semua Prioritas</option>
                                        <option value="rendah">Rendah</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="tinggi">Tinggi</option>
                                        <option value="sangat_tinggi">Sangat Tinggi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cari Dokumen</label>
                                    <input type="text" class="form-control" placeholder="Judul atau deskripsi dokumen">
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

            <!-- Arsip Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-archive"></i> Daftar Arsip Dokumen
                                </h5>
                                @if($arsips->count() > 0)
                                <!-- Pagination at Top -->
                                <div class="d-flex gap-3 align-items-center">
                                    <span class="text-muted small">
                                        Menampilkan {{ $arsips->firstItem() }} sampai {{ $arsips->lastItem() }} dari {{ $arsips->total() }} hasil
                                    </span>
                                    @if($arsips->onFirstPage())
                                        <button class="btn btn-secondary pagination-btn" disabled style="min-width: 100px; font-weight: 500;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </button>
                                    @else
                                        <a href="{{ $arsips->appends(request()->query())->previousPageUrl() }}" class="btn pagination-btn pagination-btn-active" style="min-width: 100px; font-weight: 500;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </a>
                                    @endif
                                    
                                    <span class="text-muted px-3" style="font-weight: 500; font-size: 0.95rem;">
                                        Halaman {{ $arsips->currentPage() }} / {{ $arsips->lastPage() }}
                                    </span>
                                    
                                    @if($arsips->hasMorePages())
                                        <a href="{{ $arsips->appends(request()->query())->nextPageUrl() }}" class="btn pagination-btn pagination-btn-active" style="min-width: 100px; font-weight: 500;">
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-secondary pagination-btn" disabled style="min-width: 100px; font-weight: 500;">
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </button>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Dokumen</th>
                                            <th>Kategori</th>
                                            <th>File</th>
                                            <th>Ukuran</th>
                                            <th>Prioritas</th>
                                            <th>Tanggal Upload</th>
                                            <th>Pembuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($arsips->count() > 0)
                                            @foreach($arsips as $index => $arsip)
                                                @php
                                                    // Mapping warna badge kategori
                                                    $kategoriBadge = [
                                                        'akademik' => 'bg-success',
                                                        'administrasi' => 'bg-warning',
                                                        'keuangan' => 'bg-info',
                                                        'sdm' => 'bg-secondary',
                                                        'fasilitas' => 'bg-primary',
                                                        'keputusan' => 'bg-danger',
                                                        'surat_masuk' => 'bg-primary',
                                                        'surat_keluar' => 'bg-info',
                                                        'lainnya' => 'bg-dark'
                                                    ];
                                                    
                                                    // Mapping warna badge prioritas
                                                    $prioritasBadge = [
                                                        'rendah' => 'bg-success',
                                                        'sedang' => 'bg-warning',
                                                        'tinggi' => 'bg-danger',
                                                        'sangat_tinggi' => 'bg-danger'
                                                    ];
                                                    
                                                    // Mapping icon file
                                                    $fileIcon = [
                                                        'pdf' => 'fa-file-pdf text-danger',
                                                        'doc' => 'fa-file-word text-primary',
                                                        'docx' => 'fa-file-word text-primary',
                                                        'xls' => 'fa-file-excel text-success',
                                                        'xlsx' => 'fa-file-excel text-success',
                                                        'ppt' => 'fa-file-powerpoint text-warning',
                                                        'pptx' => 'fa-file-powerpoint text-warning',
                                                        'jpg' => 'fa-file-image text-info',
                                                        'jpeg' => 'fa-file-image text-info',
                                                        'png' => 'fa-file-image text-info',
                                                        'txt' => 'fa-file-alt text-secondary'
                                                    ];
                                                    
                                                    $kategori = strtolower($arsip->kategori);
                                                    $prioritas = strtolower($arsip->prioritas ?? 'sedang');
                                                    $tipeFile = strtolower($arsip->tipe_file ?? '');
                                                    $badgeKategori = $kategoriBadge[$kategori] ?? 'bg-secondary';
                                                    $badgePrioritas = $prioritasBadge[$prioritas] ?? 'bg-warning';
                                                    $iconFile = $fileIcon[$tipeFile] ?? 'fa-file text-secondary';
                                                    
                                                    // Format ukuran file
                                                    $ukuranFile = $arsip->ukuran_file ?? 0;
                                                    if ($ukuranFile >= 1048576) {
                                                        $ukuranFormat = number_format($ukuranFile / 1048576, 2) . ' MB';
                                                    } else {
                                                        $ukuranFormat = number_format($ukuranFile / 1024, 2) . ' KB';
                                                    }
                                                    
                                                    // Format label kategori
                                                    $kategoriLabel = [
                                                        'akademik' => 'Akademik',
                                                        'administrasi' => 'Administrasi',
                                                        'keuangan' => 'Keuangan',
                                                        'sdm' => 'SDM',
                                                        'fasilitas' => 'Fasilitas',
                                                        'keputusan' => 'Keputusan',
                                                        'surat_masuk' => 'Surat Masuk',
                                                        'surat_keluar' => 'Surat Keluar',
                                                        'lainnya' => 'Lainnya'
                                                    ];
                                                    
                                                    $prioritasLabel = [
                                                        'rendah' => 'Rendah',
                                                        'sedang' => 'Sedang',
                                                        'tinggi' => 'Tinggi',
                                                        'sangat_tinggi' => 'Sangat Tinggi'
                                                    ];
                                                @endphp
                                                <tr>
                                                    <td>{{ $arsips->firstItem() + $index }}</td>
                                                    <td>
                                                        <strong>{{ $arsip->judul_dokumen }}</strong>
                                                        @if($arsip->is_important)
                                                            <span class="badge bg-danger ms-1">
                                                                <i class="fas fa-star"></i> Penting
                                                            </span>
                                                        @endif
                                            </td>
                                                    <td><span class="badge {{ $badgeKategori }}">{{ $kategoriLabel[$kategori] ?? ucfirst($kategori) }}</span></td>
                                                    <td>
                                                        <i class="fas {{ $iconFile }}"></i> 
                                                        {{ Str::limit($arsip->file_dokumen, 30) }}
                                            </td>
                                                    <td>{{ $ukuranFormat }}</td>
                                                    <td><span class="badge {{ $badgePrioritas }}">{{ $prioritasLabel[$prioritas] ?? ucfirst($prioritas) }}</span></td>
                                                    <td>{{ $arsip->created_at->format('d M Y') }}</td>
                                                    <td>{{ $arsip->pembuat }}</td>
                                                    <td>
                                                        @if($arsip->file_dokumen)
                                                            <a href="{{ route('tu.arsip.view', $arsip->id) }}" target="_blank" class="btn btn-sm btn-primary me-1" title="Lihat Dokumen">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                            <a href="{{ route('tu.arsip.download', $arsip->id) }}" class="btn btn-sm btn-outline-secondary me-1" title="Download Dokumen">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                        @else
                                                            <span class="text-muted">File tidak tersedia</span>
                                                        @endif
                                                        <a href="{{ route('tu.arsip.edit', $arsip->id) }}" class="btn btn-sm btn-warning me-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('tu.arsip.destroy', $arsip->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Hapus
                                                </button>
                                                        </form>
                                            </td>
                                        </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-archive fa-3x mb-3"></i>
                                                        <p class="mb-0">Belum ada dokumen yang diarsipkan. Silakan upload dokumen baru.</p>
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
