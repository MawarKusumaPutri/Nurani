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
    @section('title', 'Detail Laporan Kegiatan - ' . ucfirst($role) . ' Dashboard')
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
                        <i class="fas fa-file-alt me-2"></i>Detail Laporan Kegiatan
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route($routePrefix . '.laporan.index') }}" class="btn btn-sm btn-outline-secondary">
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
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle"></i> Informasi Kegiatan
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="200">Judul Kegiatan</th>
                                        <td><strong>{{ $laporan->judul_kegiatan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $laporan->deskripsi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Mulai</th>
                                        <td>{{ $laporan->tanggal_mulai->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Selesai</th>
                                        <td>{{ $laporan->tanggal_selesai ? $laporan->tanggal_selesai->format('d F Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Waktu</th>
                                        <td>
                                            @if($laporan->waktu_mulai)
                                                {{ \Carbon\Carbon::parse($laporan->waktu_mulai)->format('H:i') }}
                                                @if($laporan->waktu_selesai)
                                                    - {{ \Carbon\Carbon::parse($laporan->waktu_selesai)->format('H:i') }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td>{{ $laporan->lokasi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penanggung Jawab</th>
                                        <td>{{ $laporan->penanggung_jawab }}</td>
                                    </tr>
                                    <tr>
                                        <th>Anggaran</th>
                                        <td>{{ $laporan->anggaran ? 'Rp ' . number_format($laporan->anggaran, 0, ',', '.') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Peserta</th>
                                        <td>{{ $laporan->peserta ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge {{ $laporan->status_badge }}">
                                                {{ $laporan->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-alt"></i> Hasil Kegiatan & Evaluasi
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route($routePrefix . '.laporan.update', $laporan->id) }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="hasil_kegiatan" class="form-label">Hasil Kegiatan</label>
                                        <textarea class="form-control" id="hasil_kegiatan" name="hasil_kegiatan" rows="6" 
                                                  placeholder="Jelaskan hasil yang dicapai dari kegiatan ini...">{{ old('hasil_kegiatan', $laporan->hasil_kegiatan) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="evaluasi" class="form-label">Evaluasi</label>
                                        <textarea class="form-control" id="evaluasi" name="evaluasi" rows="6" 
                                                  placeholder="Jelaskan evaluasi dan kesimpulan dari kegiatan ini...">{{ old('evaluasi', $laporan->evaluasi) }}</textarea>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Laporan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info"></i> Informasi Tambahan
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($laporan->catatan)
                                    <div class="mb-3">
                                        <strong>Catatan:</strong>
                                        <p class="mb-0">{{ $laporan->catatan }}</p>
                                    </div>
                                @endif

                                @if($laporan->dokumen_lampiran)
                                    <div class="mb-3">
                                        <strong>Dokumen Lampiran:</strong>
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($laporan->dokumen_lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <strong>Dibuat oleh:</strong>
                                    <p class="mb-0">{{ $laporan->creator->name ?? '-' }}</p>
                                </div>

                                <div class="mb-3">
                                    <strong>Dibuat pada:</strong>
                                    <p class="mb-0">{{ $laporan->created_at->format('d F Y H:i') }}</p>
                                </div>
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
        <title>Detail Laporan Kegiatan - Kepala Sekolah Dashboard</title>
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
                            <i class="fas fa-file-alt me-2"></i>Detail Laporan Kegiatan
                        </h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.laporan.index') }}" class="btn btn-sm btn-outline-secondary">
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
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Informasi Kegiatan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="200">Judul Kegiatan</th>
                                            <td><strong>{{ $laporan->judul_kegiatan }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <td>{{ $laporan->deskripsi ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <td>{{ $laporan->tanggal_mulai->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Selesai</th>
                                            <td>{{ $laporan->tanggal_selesai ? $laporan->tanggal_selesai->format('d F Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Waktu</th>
                                            <td>
                                                @if($laporan->waktu_mulai)
                                                    {{ $laporan->waktu_mulai }}
                                                    @if($laporan->waktu_selesai)
                                                        - {{ $laporan->waktu_selesai }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi</th>
                                            <td>{{ $laporan->lokasi ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penanggung Jawab</th>
                                            <td>{{ $laporan->penanggung_jawab }}</td>
                                        </tr>
                                        <tr>
                                            <th>Anggaran</th>
                                            <td>{{ $laporan->anggaran ? 'Rp ' . number_format($laporan->anggaran, 0, ',', '.') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Peserta</th>
                                            <td>{{ $laporan->peserta ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge {{ $laporan->status_badge }}">
                                                    {{ $laporan->status_label }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-file-alt"></i> Hasil Kegiatan & Evaluasi
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('kepala_sekolah.kegiatan-kesiswaan.laporan.update', $laporan->id) }}">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label for="hasil_kegiatan" class="form-label">Hasil Kegiatan</label>
                                            <textarea class="form-control" id="hasil_kegiatan" name="hasil_kegiatan" rows="6" 
                                                      placeholder="Jelaskan hasil yang dicapai dari kegiatan ini...">{{ old('hasil_kegiatan', $laporan->hasil_kegiatan) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="evaluasi" class="form-label">Evaluasi</label>
                                            <textarea class="form-control" id="evaluasi" name="evaluasi" rows="6" 
                                                      placeholder="Jelaskan evaluasi dan kesimpulan dari kegiatan ini...">{{ old('evaluasi', $laporan->evaluasi) }}</textarea>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan Laporan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info"></i> Informasi Tambahan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($laporan->catatan)
                                        <div class="mb-3">
                                            <strong>Catatan:</strong>
                                            <p class="mb-0">{{ $laporan->catatan }}</p>
                                        </div>
                                    @endif

                                    @if($laporan->dokumen_lampiran)
                                        <div class="mb-3">
                                            <strong>Dokumen Lampiran:</strong>
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $laporan->dokumen_lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Dibuat oleh:</strong>
                                        <p class="mb-0">{{ $laporan->creator->name ?? '-' }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Dibuat pada:</strong>
                                        <p class="mb-0">{{ $laporan->created_at->format('d F Y H:i') }}</p>
                                    </div>
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

