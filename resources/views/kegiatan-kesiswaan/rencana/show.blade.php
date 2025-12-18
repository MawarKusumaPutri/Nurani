@php
    $layout = match($role) {
        'tu' => 'layouts.tu',
        'guru' => 'layouts.guru',
        default => null
    };
    $routePrefix = match($role) {
        'tu' => 'tu.kegiatan-kesiswaan.rencana',
        'guru' => 'guru.kegiatan-kesiswaan.rencana',
        default => 'login'
    };
@endphp

@if($layout)
    @extends($layout)
    @section('title', 'Detail Rencana Kegiatan - ' . ucfirst($role) . ' Dashboard')
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
                        <i class="fas fa-calendar-plus me-2"></i>Detail Rencana Kegiatan
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route($routePrefix . '.edit', $rencana->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle"></i> Informasi Rencana Kegiatan
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="200">Judul Kegiatan</th>
                                        <td><strong>{{ $rencana->judul_kegiatan }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $rencana->deskripsi ? nl2br(e($rencana->deskripsi)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Mulai</th>
                                        <td>{{ $rencana->tanggal_mulai->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Selesai</th>
                                        <td>{{ $rencana->tanggal_selesai ? $rencana->tanggal_selesai->format('d F Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Waktu</th>
                                        <td>
                                            @if($rencana->waktu_mulai)
                                                {{ $rencana->waktu_mulai }}
                                                @if($rencana->waktu_selesai)
                                                    - {{ $rencana->waktu_selesai }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td>{{ $rencana->lokasi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penanggung Jawab</th>
                                        <td>{{ $rencana->penanggung_jawab }}</td>
                                    </tr>
                                    <tr>
                                        <th>Anggaran</th>
                                        <td>{{ $rencana->anggaran ? 'Rp ' . number_format($rencana->anggaran, 0, ',', '.') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Peserta (Kelas)</th>
                                        <td>{{ $rencana->peserta ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge {{ $rencana->status_badge }}">
                                                {{ $rencana->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if($rencana->catatan)
                                    <tr>
                                        <th>Catatan</th>
                                        <td>{{ nl2br(e($rencana->catatan)) }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info"></i> Informasi Tambahan
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($rencana->dokumen_lampiran)
                                    <div class="mb-3">
                                        <strong>Dokumen Lampiran:</strong>
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $rencana->dokumen_lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <strong>Dibuat oleh:</strong>
                                    <p class="mb-0">{{ $rencana->creator->name ?? '-' }}</p>
                                </div>

                                <div class="mb-3">
                                    <strong>Dibuat pada:</strong>
                                    <p class="mb-0">{{ $rencana->created_at->format('d F Y H:i') }}</p>
                                </div>

                                <div class="mb-3">
                                    <strong>Terakhir diupdate:</strong>
                                    <p class="mb-0">{{ $rencana->updated_at->format('d F Y H:i') }}</p>
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
    @php
        // Redirect kepala sekolah ke dashboard karena fitur sudah dihapus
        header('Location: ' . route('kepala_sekolah.dashboard'));
        exit;
    @endphp
@endif

