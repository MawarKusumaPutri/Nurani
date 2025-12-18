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
    @section('title', 'Monitoring Kegiatan Kesiswaan - ' . ucfirst($role) . ' Dashboard')
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
                        <i class="fas fa-chart-line me-2"></i>Monitoring Pelaksanaan Kegiatan
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
                                    <i class="fas fa-list"></i> Daftar Kegiatan yang Sedang Berlangsung
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($kegiatans->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Judul Kegiatan</th>
                                                    <th>Tanggal Mulai</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Penanggung Jawab</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($kegiatans as $index => $kegiatan)
                                                    <tr>
                                                        <td>{{ $kegiatans->firstItem() + $index }}</td>
                                                        <td><strong>{{ $kegiatan->judul_kegiatan }}</strong></td>
                                                        <td>{{ $kegiatan->tanggal_mulai->format('d/m/Y') }}</td>
                                                        <td>{{ $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ $kegiatan->penanggung_jawab }}</td>
                                                        <td>
                                                            <span class="badge {{ $kegiatan->status_badge }}">
                                                                {{ $kegiatan->status_label }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route($routePrefix . '.monitoring.update-status', $kegiatan->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <select name="status" class="form-select form-select-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                                                    <option value="rencana" {{ $kegiatan->status == 'rencana' ? 'selected' : '' }}>Rencana</option>
                                                                    <option value="sedang_berlangsung" {{ $kegiatan->status == 'sedang_berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                                                    <option value="selesai" {{ $kegiatan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                                    <option value="dibatalkan" {{ $kegiatan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                                </select>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted small">
                                            Menampilkan {{ $kegiatans->firstItem() }} sampai {{ $kegiatans->lastItem() }} dari {{ $kegiatans->total() }} kegiatan
                                        </div>
                                        <div>
                                            {{ $kegiatans->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada kegiatan yang sedang berlangsung atau dalam rencana.</p>
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
        <title>Monitoring Kegiatan Kesiswaan - Kepala Sekolah Dashboard</title>
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
                            <i class="fas fa-chart-line me-2"></i>Monitoring Pelaksanaan Kegiatan
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
                                        <i class="fas fa-list"></i> Daftar Kegiatan yang Sedang Berlangsung
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($kegiatans->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul Kegiatan</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Penanggung Jawab</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($kegiatans as $index => $kegiatan)
                                                        <tr>
                                                            <td>{{ $kegiatans->firstItem() + $index }}</td>
                                                            <td><strong>{{ $kegiatan->judul_kegiatan }}</strong></td>
                                                            <td>{{ $kegiatan->tanggal_mulai->format('d/m/Y') }}</td>
                                                            <td>{{ $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                                            <td>{{ $kegiatan->penanggung_jawab }}</td>
                                                            <td>
                                                                <span class="badge {{ $kegiatan->status_badge }}">
                                                                    {{ $kegiatan->status_label }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('kepala_sekolah.kegiatan-kesiswaan.monitoring.update-status', $kegiatan->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <select name="status" class="form-select form-select-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                                                        <option value="rencana" {{ $kegiatan->status == 'rencana' ? 'selected' : '' }}>Rencana</option>
                                                                        <option value="sedang_berlangsung" {{ $kegiatan->status == 'sedang_berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                                                        <option value="selesai" {{ $kegiatan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                                        <option value="dibatalkan" {{ $kegiatan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                                    </select>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted small">
                                                Menampilkan {{ $kegiatans->firstItem() }} sampai {{ $kegiatans->lastItem() }} dari {{ $kegiatans->total() }} kegiatan
                                            </div>
                                            <div>
                                                {{ $kegiatans->links() }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada kegiatan yang sedang berlangsung atau dalam rencana.</p>
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

