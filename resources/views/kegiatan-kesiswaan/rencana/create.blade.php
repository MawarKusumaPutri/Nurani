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
    @section('title', 'Buat Rencana Kegiatan - ' . ucfirst($role) . ' Dashboard')
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
                        <i class="fas fa-calendar-plus me-2"></i>Buat Rencana Kegiatan
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
                                    <i class="fas fa-calendar-plus"></i> Form Rencana Kegiatan Kesiswaan
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route($routePrefix . '.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" 
                                               value="{{ old('judul_kegiatan') }}" placeholder="Contoh: Kegiatan Pramuka Bulanan" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi Kegiatan</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                                                  placeholder="Jelaskan detail kegiatan yang akan dilaksanakan...">{{ old('deskripsi') }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                                       value="{{ old('tanggal_mulai') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                                       value="{{ old('tanggal_selesai') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" 
                                                       value="{{ old('waktu_mulai') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                                <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" 
                                                       value="{{ old('waktu_selesai') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="lokasi" class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi" 
                                                       value="{{ old('lokasi') }}" placeholder="Contoh: Lapangan Sekolah">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="penanggung_jawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" 
                                                       value="{{ old('penanggung_jawab', Auth::user()->name) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="anggaran" class="form-label">Anggaran (Rp)</label>
                                        <input type="number" class="form-control" id="anggaran" name="anggaran" 
                                               value="{{ old('anggaran') }}" placeholder="0" min="0" step="0.01">
                                        <div class="form-text">Masukkan anggaran yang diperlukan untuk kegiatan ini</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="peserta" class="form-label">Peserta</label>
                                        <textarea class="form-control" id="peserta" name="peserta" rows="3" 
                                                  placeholder="Contoh: Siswa kelas 7, 8, dan 9 atau nama-nama peserta...">{{ old('peserta') }}</textarea>
                                        <div class="form-text">Jelaskan siapa saja yang akan mengikuti kegiatan ini</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="catatan" class="form-label">Catatan</label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                                                  placeholder="Catatan tambahan atau informasi penting lainnya...">{{ old('catatan') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dokumen_lampiran" class="form-label">Dokumen Lampiran (Opsional)</label>
                                        <input type="file" class="form-control" id="dokumen_lampiran" name="dokumen_lampiran" 
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <div class="form-text">Format yang didukung: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route($routePrefix . '.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Rencana
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
        <title>Buat Rencana Kegiatan - Kepala Sekolah Dashboard</title>
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
                            <i class="fas fa-calendar-plus me-2"></i>Buat Rencana Kegiatan
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
                                        <i class="fas fa-calendar-plus"></i> Form Rencana Kegiatan Kesiswaan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" 
                                                   value="{{ old('judul_kegiatan') }}" placeholder="Contoh: Kegiatan Pramuka Bulanan" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi Kegiatan</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                                                      placeholder="Jelaskan detail kegiatan yang akan dilaksanakan...">{{ old('deskripsi') }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                                           value="{{ old('tanggal_mulai') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                                           value="{{ old('tanggal_selesai') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                                    <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" 
                                                           value="{{ old('waktu_mulai') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                                    <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" 
                                                           value="{{ old('waktu_selesai') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="lokasi" class="form-label">Lokasi</label>
                                                    <input type="text" class="form-control" id="lokasi" name="lokasi" 
                                                           value="{{ old('lokasi') }}" placeholder="Contoh: Lapangan Sekolah">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="penanggung_jawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" 
                                                           value="{{ old('penanggung_jawab', Auth::user()->name) }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="anggaran" class="form-label">Anggaran (Rp)</label>
                                            <input type="number" class="form-control" id="anggaran" name="anggaran" 
                                                   value="{{ old('anggaran') }}" placeholder="0" min="0" step="0.01">
                                            <div class="form-text">Masukkan anggaran yang diperlukan untuk kegiatan ini</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="peserta" class="form-label">Peserta</label>
                                            <textarea class="form-control" id="peserta" name="peserta" rows="3" 
                                                      placeholder="Contoh: Siswa kelas 7, 8, dan 9 atau nama-nama peserta...">{{ old('peserta') }}</textarea>
                                            <div class="form-text">Jelaskan siapa saja yang akan mengikuti kegiatan ini</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="catatan" class="form-label">Catatan</label>
                                            <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                                                      placeholder="Catatan tambahan atau informasi penting lainnya...">{{ old('catatan') }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="dokumen_lampiran" class="form-label">Dokumen Lampiran (Opsional)</label>
                                            <input type="file" class="form-control" id="dokumen_lampiran" name="dokumen_lampiran" 
                                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                            <div class="form-text">Format yang didukung: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('kepala_sekolah.kegiatan-kesiswaan.rencana.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Batal
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan Rencana
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

