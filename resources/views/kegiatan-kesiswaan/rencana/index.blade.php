@php
    $layout = match($role) {
        'tu' => 'layouts.tu',
        'guru' => 'layouts.guru',
        default => null
    };
@endphp

@if($layout)
    @extends($layout)
    @section('title', 'Rencana Kegiatan Kesiswaan - ' . ucfirst($role) . ' Dashboard')
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
                        <i class="fas fa-calendar-plus me-2"></i>Rencana Kegiatan Kesiswaan
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="{{ $role === 'tu' ? route('tu.kegiatan-kesiswaan.rencana.create') : ($role === 'guru' ? route('guru.kegiatan-kesiswaan.rencana.create') : route('kepala_sekolah.kegiatan-kesiswaan.rencana.create')) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Buat Rencana
                            </a>
                            <a href="{{ $role === 'tu' ? route('tu.kegiatan-kesiswaan.index') : ($role === 'guru' ? route('guru.kegiatan-kesiswaan.index') : route('kepala_sekolah.kegiatan-kesiswaan.index')) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-list"></i> Daftar Rencana Kegiatan
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($rencanas->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Judul Kegiatan</th>
                                                    <th>Tanggal Mulai</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Penanggung Jawab</th>
                                                    <th>Lokasi</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($rencanas as $index => $rencana)
                                                    <tr>
                                                        <td>{{ $rencanas->firstItem() + $index }}</td>
                                                        <td><strong>{{ $rencana->judul_kegiatan }}</strong></td>
                                                        <td>{{ $rencana->tanggal_mulai->format('d/m/Y') }}</td>
                                                        <td>{{ $rencana->tanggal_selesai ? $rencana->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                                        <td>{{ $rencana->penanggung_jawab }}</td>
                                                        <td>{{ $rencana->lokasi ?? '-' }}</td>
                                                        <td>
                                                            <span class="badge {{ $rencana->status_badge }}">
                                                                {{ $rencana->status_label }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ $role === 'tu' ? route('tu.kegiatan-kesiswaan.rencana.edit', $rencana->id) : ($role === 'guru' ? route('guru.kegiatan-kesiswaan.rencana.edit', $rencana->id) : route('kepala_sekolah.kegiatan-kesiswaan.rencana.edit', $rencana->id)) }}" class="btn btn-outline-primary" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ $role === 'tu' ? route('tu.kegiatan-kesiswaan.rencana.destroy', $rencana->id) : ($role === 'guru' ? route('guru.kegiatan-kesiswaan.rencana.destroy', $rencana->id) : route('kepala_sekolah.kegiatan-kesiswaan.rencana.destroy', $rencana->id)) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rencana ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted small">
                                            Menampilkan {{ $rencanas->firstItem() }} sampai {{ $rencanas->lastItem() }} dari {{ $rencanas->total() }} rencana
                                        </div>
                                        <div>
                                            {{ $rencanas->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada rencana kegiatan. Silakan buat rencana baru.</p>
                                        <a href="{{ $role === 'tu' ? route('tu.kegiatan-kesiswaan.rencana.create') : ($role === 'guru' ? route('guru.kegiatan-kesiswaan.rencana.create') : route('kepala_sekolah.kegiatan-kesiswaan.rencana.create')) }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Buat Rencana Baru
                                        </a>
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
        <title>Rencana Kegiatan Kesiswaan - Kepala Sekolah Dashboard</title>
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
                            <i class="fas fa-calendar-plus me-2"></i>Rencana Kegiatan Kesiswaan
                        </h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> Buat Rencana
                                </a>
                                <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
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
                                        <i class="fas fa-list"></i> Daftar Rencana Kegiatan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($rencanas->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul Kegiatan</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Penanggung Jawab</th>
                                                        <th>Lokasi</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rencanas as $index => $rencana)
                                                        <tr>
                                                            <td>{{ $rencanas->firstItem() + $index }}</td>
                                                            <td><strong>{{ $rencana->judul_kegiatan }}</strong></td>
                                                            <td>{{ $rencana->tanggal_mulai->format('d/m/Y') }}</td>
                                                            <td>{{ $rencana->tanggal_selesai ? $rencana->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                                                            <td>{{ $rencana->penanggung_jawab }}</td>
                                                            <td>{{ $rencana->lokasi ?? '-' }}</td>
                                                            <td>
                                                                <span class="badge {{ $rencana->status_badge }}">
                                                                    {{ $rencana->status_label }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.edit', $rencana->id) }}" class="btn btn-outline-primary" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.destroy', $rencana->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rencana ini?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted small">
                                                Menampilkan {{ $rencanas->firstItem() }} sampai {{ $rencanas->lastItem() }} dari {{ $rencanas->total() }} rencana
                                            </div>
                                            <div>
                                                {{ $rencanas->links() }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada rencana kegiatan. Silakan buat rencana baru.</p>
                                            <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Buat Rencana Baru
                                            </a>
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

