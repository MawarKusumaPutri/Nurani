@extends('layouts.tu')

@section('title', 'Pengumuman - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Pengumuman</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.kalender.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-calendar"></i> Lihat Kalender
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

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Pengumuman Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-bullhorn"></i> Daftar Semua Event Kalender
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($pengumumanEvents->count() > 0)
                                <div class="row">
                                    @foreach($pengumumanEvents as $event)
                                        @php
                                            $kategori = strtolower($event->kategori_event);
                                            
                                            // Mapping warna border, icon, label, dan badge untuk semua kategori
                                            $kategoriConfig = [
                                                'pengumuman' => [
                                                    'borderColor' => '#D2B48C',
                                                    'iconClass' => 'fa-bullhorn text-warning',
                                                    'label' => 'Pengumuman',
                                                    'badge' => 'bg-secondary'
                                                ],
                                                'kegiatan' => [
                                                    'borderColor' => '#fd7e14',
                                                    'iconClass' => 'fa-star text-warning',
                                                    'label' => 'Kegiatan',
                                                    'badge' => 'bg-success'
                                                ],
                                                'ujian' => [
                                                    'borderColor' => '#dc3545',
                                                    'iconClass' => 'fa-clipboard-check text-danger',
                                                    'label' => 'Ujian',
                                                    'badge' => 'bg-danger'
                                                ],
                                                'libur' => [
                                                    'borderColor' => '#ffc107',
                                                    'iconClass' => 'fa-calendar-times text-warning',
                                                    'label' => 'Libur',
                                                    'badge' => 'bg-warning'
                                                ],
                                                'akademik' => [
                                                    'borderColor' => '#007bff',
                                                    'iconClass' => 'fa-graduation-cap text-primary',
                                                    'label' => 'Akademik',
                                                    'badge' => 'bg-primary'
                                                ],
                                                'rapat' => [
                                                    'borderColor' => '#17a2b8',
                                                    'iconClass' => 'fa-users text-info',
                                                    'label' => 'Rapat',
                                                    'badge' => 'bg-info'
                                                ],
                                                'pelatihan' => [
                                                    'borderColor' => '#9c27b0',
                                                    'iconClass' => 'fa-chalkboard-teacher text-secondary',
                                                    'label' => 'Pelatihan',
                                                    'badge' => 'bg-secondary'
                                                ],
                                                'lainnya' => [
                                                    'borderColor' => '#6c757d',
                                                    'iconClass' => 'fa-calendar text-muted',
                                                    'label' => 'Lainnya',
                                                    'badge' => 'bg-dark'
                                                ]
                                            ];
                                            
                                            $config = $kategoriConfig[$kategori] ?? $kategoriConfig['lainnya'];
                                            $borderColor = $config['borderColor'];
                                            $iconClass = $config['iconClass'];
                                            $kategoriLabel = $config['label'];
                                            $kategoriBadge = $config['badge'];
                                        @endphp
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100 border-start border-4" style="border-color: {{ $borderColor }} !important;">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h5 class="card-title mb-0">
                                                            <i class="fas {{ $iconClass }}"></i>
                                                            {{ $event->judul_event }}
                                                        </h5>
                                                        <div class="d-flex gap-1">
                                                            <span class="badge {{ $kategoriBadge }}">
                                                                {{ $kategoriLabel }}
                                                            </span>
                                                            @if($event->is_important)
                                                                <span class="badge bg-danger">
                                                                    <i class="fas fa-star"></i> Penting
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar-alt"></i>
                                                            {{ $event->tanggal_mulai->format('d F Y') }}
                                                            @if($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                                                                - {{ $event->tanggal_selesai->format('d F Y') }}
                                                            @endif
                                                        </small>
                                                    </div>

                                                    @if($event->waktu_mulai && !$event->is_all_day)
                                                        <div class="mb-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-clock"></i>
                                                                {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}
                                                                @if($event->waktu_selesai)
                                                                    - {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }}
                                                                @endif
                                                            </small>
                                                        </div>
                                                    @endif

                                                    @if($event->lokasi)
                                                        <div class="mb-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                {{ $event->lokasi }}
                                                            </small>
                                                        </div>
                                                    @endif

                                                    @if($event->deskripsi)
                                                        <p class="card-text mt-3">
                                                            {{ Str::limit($event->deskripsi, 150) }}
                                                        </p>
                                                    @endif

                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <small class="text-muted">
                                                            <i class="fas fa-user"></i>
                                                            {{ $event->penanggung_jawab }}
                                                        </small>
                                                        <div>
                                                            <a href="{{ route('tu.kalender.edit', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada event yang terdaftar di kalender. Silakan buat event baru melalui kalender.</p>
                                    <a href="{{ route('tu.kalender.index') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-calendar"></i> Lihat Kalender
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
