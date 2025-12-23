@extends('layouts.tu')

@section('title', 'Detail Event - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Detail Event Kalender</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.kalender.list') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('tu.kalender.edit', $event->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit Event
                        </a>
                    </div>
                </div>
            </div>

            <!-- Event Detail Card -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="background-color: {{ $event->warna }}; color: white;">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $event->judul_event }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Kategori & Status Badges -->
                            <div class="mb-4">
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
                                    $color = $kategoriColors[strtolower($event->kategori_event)] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} me-2">
                                    {{ ucfirst($event->kategori_event) }}
                                </span>
                                @if($event->is_important)
                                    <span class="badge bg-danger me-2">
                                        <i class="fas fa-star"></i> Penting
                                    </span>
                                @endif
                                @if($event->is_public)
                                    <span class="badge bg-success me-2">
                                        <i class="fas fa-globe"></i> Publik
                                    </span>
                                @else
                                    <span class="badge bg-secondary me-2">
                                        <i class="fas fa-lock"></i> Privat
                                    </span>
                                @endif
                                @if($event->is_recurring)
                                    <span class="badge bg-info">
                                        <i class="fas fa-redo"></i> Berulang
                                    </span>
                                @endif
                            </div>

                            <!-- Tanggal & Waktu -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-calendar text-primary"></i> Tanggal Mulai</h6>
                                    <p class="text-muted">{{ $event->tanggal_mulai->format('d F Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-calendar text-primary"></i> Tanggal Selesai</h6>
                                    <p class="text-muted">
                                        @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                            {{ $event->tanggal_selesai->format('d F Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Waktu -->
                            @if(!$event->is_all_day && $event->waktu_mulai)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-clock text-primary"></i> Waktu Mulai</h6>
                                        <p class="text-muted">{{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6><i class="fas fa-clock text-primary"></i> Waktu Selesai</h6>
                                        <p class="text-muted">
                                            @if($event->waktu_selesai)
                                                {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <h6><i class="fas fa-clock text-primary"></i> Waktu</h6>
                                    <p class="text-muted">
                                        <span class="badge bg-info">Sepanjang Hari</span>
                                    </p>
                                </div>
                            @endif

                            <!-- Lokasi -->
                            @if($event->lokasi)
                                <div class="mb-3">
                                    <h6><i class="fas fa-map-marker-alt text-danger"></i> Lokasi</h6>
                                    <p class="text-muted">{{ $event->lokasi }}</p>
                                </div>
                            @endif

                            <!-- Penanggung Jawab -->
                            <div class="mb-3">
                                <h6><i class="fas fa-user text-success"></i> Penanggung Jawab</h6>
                                <p class="text-muted">{{ $event->penanggung_jawab }}</p>
                            </div>

                            <!-- Deskripsi -->
                            @if($event->deskripsi)
                                <div class="mb-3">
                                    <h6><i class="fas fa-align-left text-info"></i> Deskripsi</h6>
                                    <p class="text-muted">{{ $event->deskripsi }}</p>
                                </div>
                            @endif

                            <!-- Foto Event -->
                            @if($event->foto)
                                <div class="mb-3">
                                    <h6><i class="fas fa-image text-warning"></i> Foto Event</h6>
                                    <img src="{{ asset('storage/' . $event->foto) }}" alt="Foto Event" class="img-fluid rounded shadow-sm mb-2" style="max-width: 100%; max-height: 400px;">
                                    <div>
                                        <a href="{{ route('tu.kalender.foto.download', $event->id) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i> Download Foto
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-muted">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                Dibuat pada: {{ $event->created_at->format('d F Y, H:i') }}
                                @if($event->updated_at != $event->created_at)
                                    | Terakhir diupdate: {{ $event->updated_at->format('d F Y, H:i') }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Informasi Event
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Kategori:</strong><br>
                                    <span class="badge bg-{{ $color }}">{{ ucfirst($event->kategori_event) }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Status:</strong><br>
                                    @if($event->is_public)
                                        <span class="badge bg-success">Publik</span>
                                    @else
                                        <span class="badge bg-secondary">Privat</span>
                                    @endif
                                </li>
                                @if($event->is_important)
                                    <li class="mb-2">
                                        <strong>Prioritas:</strong><br>
                                        <span class="badge bg-danger">Penting</span>
                                    </li>
                                @endif
                                @if($event->is_recurring)
                                    <li class="mb-2">
                                        <strong>Berulang:</strong><br>
                                        <span class="badge bg-info">Ya</span>
                                    </li>
                                @endif
                                <li class="mb-2">
                                    <strong>Warna:</strong><br>
                                    <div style="width: 50px; height: 30px; background-color: {{ $event->warna }}; border-radius: 4px; border: 1px solid #ddd;"></div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cog"></i> Aksi
                            </h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('tu.kalender.edit', $event->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                                <i class="fas fa-edit"></i> Edit Event
                            </a>
                            @if($event->foto)
                                <a href="{{ route('tu.kalender.foto.download', $event->id) }}" class="btn btn-success btn-sm w-100 mb-2">
                                    <i class="fas fa-download"></i> Download Foto
                                </a>
                            @endif
                            <form action="{{ route('tu.kalender.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-trash"></i> Hapus Event
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
