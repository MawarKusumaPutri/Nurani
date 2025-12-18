@php
    $layout = match($role) {
        'tu' => 'layouts.tu',
        'guru' => 'layouts.guru',
        default => null
    };
    $routePrefix = match($role) {
        'tu' => 'tu.kegiatan-kesiswaan.rencana',
        'guru' => 'guru.kegiatan-kesiswaan.rencana',
        'kepala_sekolah' => 'kepala_sekolah.kegiatan-kesiswaan.rencana',
        default => 'login'
    };
@endphp

@if($layout)
    @extends($layout)
    @section('title', 'Edit Rencana Kegiatan - ' . ucfirst($role) . ' Dashboard')
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
                        <i class="fas fa-edit me-2"></i>Edit Rencana Kegiatan
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-edit"></i> Form Edit Rencana Kegiatan Kesiswaan
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route($routePrefix . '.update', $rencana->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" 
                                               value="{{ old('judul_kegiatan', $rencana->judul_kegiatan) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi Kegiatan</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $rencana->deskripsi) }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                                       value="{{ old('tanggal_mulai', $rencana->tanggal_mulai->format('Y-m-d')) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                                       value="{{ old('tanggal_selesai', $rencana->tanggal_selesai ? $rencana->tanggal_selesai->format('Y-m-d') : '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" 
                                                       value="{{ old('waktu_mulai', $rencana->waktu_mulai) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                                <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" 
                                                       value="{{ old('waktu_selesai', $rencana->waktu_selesai) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="lokasi" class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi" 
                                                       value="{{ old('lokasi', $rencana->lokasi) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="penanggung_jawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" 
                                                       value="{{ old('penanggung_jawab', $rencana->penanggung_jawab) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="anggaran" class="form-label">Anggaran (Rp)</label>
                                        <input type="number" class="form-control" id="anggaran" name="anggaran" 
                                               value="{{ old('anggaran', $rencana->anggaran) }}" min="0" step="0.01">
                                    </div>

                                    <div class="mb-3">
                                        <label for="peserta" class="form-label">Peserta</label>
                                        <textarea class="form-control" id="peserta" name="peserta" rows="3">{{ old('peserta', $rencana->peserta) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="catatan" class="form-label">Catatan</label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan', $rencana->catatan) }}</textarea>
                                    </div>

                                    @if($rencana->dokumen_lampiran)
                                        <div class="mb-3">
                                            <label class="form-label">Dokumen Lampiran Saat Ini</label>
                                            <div class="alert alert-info">
                                                <i class="fas fa-file"></i> 
                                                <a href="{{ asset('storage/' . $rencana->dokumen_lampiran) }}" target="_blank">
                                                    Lihat Dokumen
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="dokumen_lampiran" class="form-label">Ubah Dokumen Lampiran (Opsional)</label>
                                        <input type="file" class="form-control" id="dokumen_lampiran" name="dokumen_lampiran" 
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <div class="form-text">Kosongkan jika tidak ingin mengubah dokumen</div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route($routePrefix . '.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Rencana
                                        </button>
                                    </div>
                                </form>
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
        <title>Edit Rencana Kegiatan - Kepala Sekolah Dashboard</title>
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
                            <i class="fas fa-edit me-2"></i>Edit Rencana Kegiatan
                        </h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-edit"></i> Form Edit Rencana Kegiatan Kesiswaan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.update', $rencana->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" 
                                                   value="{{ old('judul_kegiatan', $rencana->judul_kegiatan) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi Kegiatan</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $rencana->deskripsi) }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                                           value="{{ old('tanggal_mulai', $rencana->tanggal_mulai->format('Y-m-d')) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                                           value="{{ old('tanggal_selesai', $rencana->tanggal_selesai ? $rencana->tanggal_selesai->format('Y-m-d') : '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                                    <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" 
                                                           value="{{ old('waktu_mulai', $rencana->waktu_mulai ? \Carbon\Carbon::parse($rencana->waktu_mulai)->format('H:i') : '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                                    <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" 
                                                           value="{{ old('waktu_selesai', $rencana->waktu_selesai ? \Carbon\Carbon::parse($rencana->waktu_selesai)->format('H:i') : '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="lokasi" class="form-label">Lokasi</label>
                                                    <input type="text" class="form-control" id="lokasi" name="lokasi" 
                                                           value="{{ old('lokasi', $rencana->lokasi) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="penanggung_jawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" 
                                                           value="{{ old('penanggung_jawab', $rencana->penanggung_jawab) }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="anggaran" class="form-label">Anggaran (Rp)</label>
                                            <input type="number" class="form-control" id="anggaran" name="anggaran" 
                                                   value="{{ old('anggaran', $rencana->anggaran) }}" min="0" step="0.01">
                                        </div>

                                        <div class="mb-3">
                                            <label for="peserta" class="form-label">Peserta</label>
                                            <textarea class="form-control" id="peserta" name="peserta" rows="3">{{ old('peserta', $rencana->peserta) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="catatan" class="form-label">Catatan</label>
                                            <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan', $rencana->catatan) }}</textarea>
                                        </div>

                                        @if($rencana->dokumen_lampiran)
                                            <div class="mb-3">
                                                <label class="form-label">Dokumen Lampiran Saat Ini</label>
                                                <div class="alert alert-info">
                                                    <i class="fas fa-file"></i> 
                                                    <a href="{{ Storage::url($rencana->dokumen_lampiran) }}" target="_blank">
                                                        Lihat Dokumen
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label for="dokumen_lampiran" class="form-label">Ubah Dokumen Lampiran (Opsional)</label>
                                            <input type="file" class="form-control" id="dokumen_lampiran" name="dokumen_lampiran" 
                                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            <div class="form-text">Kosongkan jika tidak ingin mengubah dokumen</div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Batal
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Update Rencana
                                            </button>
                                        </div>
                                    </form>
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

