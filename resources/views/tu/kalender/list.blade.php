@extends('layouts.tu')

@section('title', 'Daftar Event - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div class="d-flex align-items-center">
                    <a href="{{ route('tu.kalender.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h1 class="h2 mb-0">Daftar Event Kalender</h1>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.kalender.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Event
                        </a>
                        <a href="{{ route('tu.kalender.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-calendar"></i> Kalender
                        </a>
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

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Events Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-list"></i> Daftar Event Kalender Akademik
                                </h5>
                                @if($events->count() > 0)
                                <!-- Pagination at Top -->
                                <div class="d-flex gap-3 align-items-center">
                                    <span class="text-muted small">
                                        Menampilkan {{ $events->firstItem() }} sampai {{ $events->lastItem() }} dari {{ $events->total() }} hasil
                                    </span>
                                    @if($events->onFirstPage())
                                        <button class="btn btn-secondary pagination-btn" disabled style="min-width: 100px; font-weight: 500;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </button>
                                    @else
                                        <a href="{{ $events->appends(request()->query())->previousPageUrl() }}" class="btn pagination-btn pagination-btn-active" style="min-width: 100px; font-weight: 500;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </a>
                                    @endif
                                    
                                    <span class="text-muted px-3" style="font-weight: 500; font-size: 0.95rem;">
                                        Halaman {{ $events->currentPage() }} / {{ $events->lastPage() }}
                                    </span>
                                    
                                    @if($events->hasMorePages())
                                        <a href="{{ $events->appends(request()->query())->nextPageUrl() }}" class="btn pagination-btn pagination-btn-active" style="min-width: 100px; font-weight: 500;">
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
                                            <th>Judul Event</th>
                                            <th>Kategori</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Waktu</th>
                                            <th>Lokasi</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($events->count() > 0)
                                            @foreach($events as $index => $event)
                                                <tr>
                                                    <td>{{ $events->firstItem() + $index }}</td>
                                                    <td>
                                                        <strong>{{ $event->judul_event }}</strong>
                                                        @if($event->is_important)
                                                            <span class="badge bg-danger ms-1">
                                                                <i class="fas fa-star"></i> Penting
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kategoriColors = [
                                                                'akademik' => 'primary',
                                                                'ujian' => 'danger',
                                                                'libur' => 'warning',
                                                                'rapat' => 'info',
                                                                'pelatihan' => 'secondary',
                                                                'kegiatan' => 'success',
                                                                'pengumuman' => 'dark',
                                                                'lainnya' => 'secondary'
                                                            ];
                                                            $kategoriLabels = [
                                                                'akademik' => 'Akademik',
                                                                'ujian' => 'Ujian',
                                                                'libur' => 'Libur',
                                                                'rapat' => 'Rapat',
                                                                'pelatihan' => 'Pelatihan',
                                                                'kegiatan' => 'Kegiatan',
                                                                'pengumuman' => 'Pengumuman',
                                                                'lainnya' => 'Lainnya'
                                                            ];
                                                            $color = $kategoriColors[strtolower($event->kategori_event)] ?? 'secondary';
                                                            $label = $kategoriLabels[strtolower($event->kategori_event)] ?? ucfirst($event->kategori_event);
                                                        @endphp
                                                        <span class="badge bg-{{ $color }}">
                                                            {{ $label }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $event->tanggal_mulai->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                                            {{ $event->tanggal_selesai->format('d/m/Y') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($event->is_all_day)
                                                            <span class="badge bg-info">Sepanjang Hari</span>
                                                        @elseif($event->waktu_mulai)
                                                            {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}
                                                            @if($event->waktu_selesai)
                                                                - {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }}
                                                            @endif
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $event->lokasi ?? '-' }}
                                                    </td>
                                                    <td>
                                                        {{ $event->penanggung_jawab }}
                                                    </td>
                                                    <td>
                                                        @if($event->is_public)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-globe"></i> Publik
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-lock"></i> Privat
                                                            </span>
                                                        @endif
                                                        @if($event->is_recurring)
                                                            <span class="badge bg-info ms-1">
                                                                <i class="fas fa-redo"></i> Berulang
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tu.kalender.edit', $event->id) }}" class="btn btn-sm btn-primary me-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('tu.kalender.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
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
                                                <td colspan="10" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                                        <p class="mb-0">Belum ada event. Silakan tambah event baru.</p>
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

