@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat RPP - {{ $rpp->judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
        }
        .section-header {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .info-content {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.375rem;
            border-left: 4px solid #4CAF50;
            margin-bottom: 1.5rem;
            white-space: pre-line;
        }
    </style>
    @include('partials.guru-fixed-layout')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-file-alt me-2 text-primary"></i>
                            {{ $rpp->judul }}
                        </h2>
                        <p class="text-muted mb-0">Detail Rencana Pelaksanaan Pembelajaran</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('guru.rpp.cetak', $rpp->id) }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-print me-2"></i>Cetak
                        </a>
                        <a href="{{ route('guru.rpp.edit', $rpp->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <form action="{{ route('guru.rpp.destroy', $rpp->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus RPP ini? Data yang dihapus tidak dapat dikembalikan.');"
                              class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                        </form>
                        <a href="{{ route('guru.dashboard', ['mata_pelajaran' => $rpp->mata_pelajaran]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <!-- Identitas Pembelajaran -->
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Identitas Pembelajaran</h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-label">Nama Sekolah</div>
                                <div class="info-content">{{ $rpp->sekolah ?? 'MTs Nurul Aiman' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Nama Guru</div>
                                <div class="info-content">{{ $guru->user->name }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Mata Pelajaran</div>
                                <div class="info-content">{{ $rpp->mata_pelajaran }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Kelas</div>
                                <div class="info-content">{{ $rpp->kelas }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Semester</div>
                                <div class="info-content">{{ $rpp->semester }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Pertemuan Ke-</div>
                                <div class="info-content">{{ $rpp->pertemuan_ke }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Alokasi Waktu</div>
                                <div class="info-content">{{ $rpp->alokasi_waktu }} menit</div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-label">Tahun Pelajaran</div>
                                <div class="info-content">{{ $rpp->tahun_pelajaran ?? '2025-2026' }}</div>
                            </div>
                        </div>

                        <!-- Kompetensi Inti -->
                        @if($rpp->ki_1 || $rpp->ki_2 || $rpp->ki_3 || $rpp->ki_4)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-certificate me-2"></i>Kompetensi Inti (KI)</h5>
                        </div>
                        
                        @if($rpp->ki_1)
                        <div class="info-label">KI-1: Sikap Spiritual</div>
                        <div class="info-content">{{ $rpp->ki_1 }}</div>
                        @endif
                        
                        @if($rpp->ki_2)
                        <div class="info-label">KI-2: Sikap Sosial</div>
                        <div class="info-content">{{ $rpp->ki_2 }}</div>
                        @endif
                        
                        @if($rpp->ki_3)
                        <div class="info-label">KI-3: Pengetahuan</div>
                        <div class="info-content">{{ $rpp->ki_3 }}</div>
                        @endif
                        
                        @if($rpp->ki_4)
                        <div class="info-label">KI-4: Keterampilan</div>
                        <div class="info-content">{{ $rpp->ki_4 }}</div>
                        @endif
                        @endif

                        <!-- Kompetensi Dasar -->
                        @if($rpp->kd_pengetahuan || $rpp->kd_keterampilan)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Kompetensi Dasar</h5>
                        </div>
                        
                        @if($rpp->kd_pengetahuan)
                        <div class="info-label">KD Pengetahuan</div>
                        <div class="info-content">{{ $rpp->kd_pengetahuan }}</div>
                        @endif
                        
                        @if($rpp->kd_keterampilan)
                        <div class="info-label">KD Keterampilan</div>
                        <div class="info-content">{{ $rpp->kd_keterampilan }}</div>
                        @endif
                        @endif

                        <!-- Indikator Pencapaian Kompetensi -->
                        @if($rpp->indikator_pencapaian_kompetensi)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Indikator Pencapaian Kompetensi</h5>
                        </div>
                        <div class="info-content">{{ $rpp->indikator_pencapaian_kompetensi }}</div>
                        @endif

                        <!-- Tujuan Pembelajaran -->
                        @if($rpp->tujuan_pembelajaran)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-flag-checkered me-2"></i>Tujuan Pembelajaran</h5>
                        </div>
                        <div class="info-content">{{ $rpp->tujuan_pembelajaran }}</div>
                        @endif

                        <!-- Materi Pembelajaran -->
                        @if($rpp->materi_pembelajaran)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-book me-2"></i>Materi Pembelajaran</h5>
                        </div>
                        <div class="info-content">{{ $rpp->materi_pembelajaran }}</div>
                        @endif

                        <!-- Metode Pembelajaran -->
                        @if($rpp->metode_pembelajaran)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Metode Pembelajaran</h5>
                        </div>
                        <div class="info-content">{{ $rpp->metode_pembelajaran }}</div>
                        @endif

                        <!-- Kegiatan Pembelajaran -->
                        @if($rpp->kegiatan_pendahuluan || $rpp->kegiatan_inti || $rpp->kegiatan_penutup)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Kegiatan Pembelajaran</h5>
                        </div>
                        
                        @if($rpp->kegiatan_pendahuluan)
                        <div class="info-label">Kegiatan Pendahuluan</div>
                        <div class="info-content">{{ $rpp->kegiatan_pendahuluan }}</div>
                        @endif
                        
                        @if($rpp->kegiatan_inti)
                        <div class="info-label">Kegiatan Inti</div>
                        <div class="info-content">{{ $rpp->kegiatan_inti }}</div>
                        @endif
                        
                        @if($rpp->kegiatan_penutup)
                        <div class="info-label">Kegiatan Penutup</div>
                        <div class="info-content">{{ $rpp->kegiatan_penutup }}</div>
                        @endif
                        @endif

                        <!-- Media dan Sumber Belajar -->
                        @if($rpp->media_pembelajaran || $rpp->sumber_belajar)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-laptop me-2"></i>Media dan Sumber Belajar</h5>
                        </div>
                        
                        @if($rpp->media_pembelajaran)
                        <div class="info-label">Media Pembelajaran</div>
                        <div class="info-content">{{ $rpp->media_pembelajaran }}</div>
                        @endif
                        
                        @if($rpp->sumber_belajar)
                        <div class="info-label">Sumber Belajar</div>
                        <div class="info-content">{{ $rpp->sumber_belajar }}</div>
                        @endif
                        @endif

                        <!-- Penilaian -->
                        @if($rpp->teknik_penilaian || $rpp->bentuk_instrumen || $rpp->rubrik_penilaian)
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Penilaian</h5>
                        </div>
                        
                        @if($rpp->teknik_penilaian)
                        <div class="info-label">Teknik Penilaian</div>
                        <div class="info-content">{{ $rpp->teknik_penilaian }}</div>
                        @endif
                        
                        @if($rpp->bentuk_instrumen)
                        <div class="info-label">Bentuk Instrumen</div>
                        <div class="info-content">{{ $rpp->bentuk_instrumen }}</div>
                        @endif
                        
                        @if($rpp->rubrik_penilaian)
                        <div class="info-label">Rubrik Penilaian</div>
                        <div class="info-content">{{ $rpp->rubrik_penilaian }}</div>
                        @endif
                        @endif

                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('guru.rpp.cetak', $rpp->id) }}" class="btn btn-success" target="_blank">
                                <i class="fas fa-print me-2"></i>Cetak RPP
                            </a>
                            <a href="{{ route('guru.rpp.edit', $rpp->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit RPP
                            </a>
                            <form action="{{ route('guru.rpp.destroy', $rpp->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus RPP ini? Data yang dihapus tidak dapat dikembalikan.');"
                                  class="mb-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Hapus RPP
                                </button>
                            </form>
                            <a href="{{ route('guru.dashboard', ['mata_pelajaran' => $rpp->mata_pelajaran]) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
