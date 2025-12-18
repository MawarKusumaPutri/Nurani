@php
    $layout = match($role) {
        'tu' => 'layouts.tu',
        'guru' => 'layouts.guru',
        default => null
    };
    $routePrefix = match($role) {
        'tu' => 'tu.kegiatan-kesiswaan',
        'guru' => 'guru.kegiatan-kesiswaan',
        'kepala_sekolah' => 'kepala_sekolah.kegiatan-kesiswaan',
        default => 'login'
    };
@endphp

@if($layout)
    @extends($layout)
    @section('title', 'Laporan Kegiatan Kesiswaan - ' . ucfirst($role) . ' Dashboard')
    @section('content')
    <div class="container-fluid">
        <div class="row">
            @if($role === 'tu')
                @include('partials.tu-sidebar')
            @elseif($role === 'guru')
                @include('partials.guru-sidebar')
            @endif
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-file-alt me-2"></i>Laporan Kegiatan Kesiswaan
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-list"></i> Daftar Laporan Kegiatan Selesai
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($laporans->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Judul Kegiatan</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Penanggung Jawab</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($laporans as $index => $laporan)
                                                    <tr>
                                                        <td>{{ $laporans->firstItem() + $index }}</td>
                                                        <td><strong>{{ $laporan->judul_kegiatan }}</strong></td>
                                                        <td>{{ $laporan->tanggal_selesai ? $laporan->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ $laporan->penanggung_jawab }}</td>
                                                        <td>
                                                            <a href="{{ route($routePrefix . '.laporan.show', $laporan->id) }}" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-eye"></i> Lihat Detail
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted small">
                                            Menampilkan {{ $laporans->firstItem() }} sampai {{ $laporans->lastItem() }} dari {{ $laporans->total() }} laporan
                                        </div>
                                        <div>
                                            {{ $laporans->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada laporan kegiatan. Kegiatan yang sudah selesai akan muncul di sini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @endsection
@else
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Kegiatan Kesiswaan - Kepala Sekolah Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
            .sidebar { min-height: 100vh; background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); }
            .sidebar .nav-link { color: rgba(255, 255, 255, 0.8); padding: 12px 20px; border-radius: 8px; margin: 4px 0; transition: all 0.3s ease; }
            .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background: rgba(255, 255, 255, 0.1); transform: translateX(5px); }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                @include('partials.kepala-sekolah-sidebar')
                <div class="col-md-9 col-lg-10 p-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">
                            <i class="fas fa-file-alt me-2"></i>Laporan Kegiatan Kesiswaan
                        </h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-list"></i> Daftar Laporan Kegiatan Selesai
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($laporans->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul Kegiatan</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Penanggung Jawab</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($laporans as $index => $laporan)
                                                        <tr>
                                                            <td>{{ $laporans->firstItem() + $index }}</td>
                                                            <td><strong>{{ $laporan->judul_kegiatan }}</strong></td>
                                                            <td>{{ $laporan->tanggal_selesai ? $laporan->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                                            <td>{{ $laporan->penanggung_jawab }}</td>
                                                            <td>
                                                                <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.laporan.show', $laporan->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-eye"></i> Lihat Detail
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted small">
                                                Menampilkan {{ $laporans->firstItem() }} sampai {{ $laporans->lastItem() }} dari {{ $laporans->total() }} laporan
                                            </div>
                                            <div>
                                                {{ $laporans->links() }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada laporan kegiatan. Kegiatan yang sudah selesai akan muncul di sini.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
@endif

