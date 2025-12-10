<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail RPP - {{ $rpp->judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #f8f9fa !important;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            font-weight: 600;
        }
        
        .info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #2E7D32;
            min-width: 200px;
        }
        
        .content-box {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid #2E7D32;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('partials.guru-sidebar')

            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">{{ $rpp->judul }}</h2>
                        <p class="text-muted mb-0">Detail Rencana Pelaksanaan Pembelajaran</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('guru.rpp.edit', $rpp) }}" class="btn btn-success">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('guru.rpp.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Informasi Dasar -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Mata Pelajaran:</span>
                                    <span>{{ $rpp->mata_pelajaran }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Kelas:</span>
                                    <span>{{ $rpp->kelas }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Semester:</span>
                                    <span>Semester {{ $rpp->semester }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Pertemuan ke-:</span>
                                    <span>{{ $rpp->pertemuan_ke }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Alokasi Waktu:</span>
                                    <span>{{ $rpp->alokasi_waktu }} menit</span>
                                </div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="d-flex">
                                    <span class="info-label">Dibuat:</span>
                                    <span>{{ $rpp->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 1. Identitas Pembelajaran -->
                @if($rpp->sekolah || $rpp->mata_pelajaran_detail || $rpp->tahun_pelajaran)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>1. Identitas Pembelajaran</h5>
                    </div>
                    <div class="card-body">
                        @if($rpp->sekolah)
                        <div class="info-item">
                            <div class="d-flex">
                                <span class="info-label">Sekolah:</span>
                                <span>{{ $rpp->sekolah }}</span>
                            </div>
                        </div>
                        @endif
                        @if($rpp->mata_pelajaran_detail)
                        <div class="info-item">
                            <div class="d-flex">
                                <span class="info-label">Mata Pelajaran (Detail):</span>
                                <span>{{ $rpp->mata_pelajaran_detail }}</span>
                            </div>
                        </div>
                        @endif
                        @if($rpp->kelas_detail)
                        <div class="info-item">
                            <div class="d-flex">
                                <span class="info-label">Kelas (Detail):</span>
                                <span>{{ $rpp->kelas_detail }}</span>
                            </div>
                        </div>
                        @endif
                        @if($rpp->semester_detail)
                        <div class="info-item">
                            <div class="d-flex">
                                <span class="info-label">Semester (Detail):</span>
                                <span>{{ $rpp->semester_detail }}</span>
                            </div>
                        </div>
                        @endif
                        @if($rpp->tahun_pelajaran)
                        <div class="info-item">
                            <div class="d-flex">
                                <span class="info-label">Tahun Pelajaran:</span>
                                <span>{{ $rpp->tahun_pelajaran }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- 2. Kompetensi Inti (KI) -->
                @if($rpp->ki_1 || $rpp->ki_2 || $rpp->ki_3 || $rpp->ki_4)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-list-check me-2"></i>2. Kompetensi Inti (KI)</h5>
                    </div>
                    <div class="card-body">
                        @if($rpp->ki_1)
                        <div class="mb-3">
                            <strong>KI-1 (Sikap Spiritual):</strong>
                            <div class="content-box mt-2">{{ $rpp->ki_1 }}</div>
                        </div>
                        @endif
                        @if($rpp->ki_2)
                        <div class="mb-3">
                            <strong>KI-2 (Sikap Sosial):</strong>
                            <div class="content-box mt-2">{{ $rpp->ki_2 }}</div>
                        </div>
                        @endif
                        @if($rpp->ki_3)
                        <div class="mb-3">
                            <strong>KI-3 (Pengetahuan):</strong>
                            <div class="content-box mt-2">{{ $rpp->ki_3 }}</div>
                        </div>
                        @endif
                        @if($rpp->ki_4)
                        <div class="mb-3">
                            <strong>KI-4 (Keterampilan):</strong>
                            <div class="content-box mt-2">{{ $rpp->ki_4 }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- 3. KD & Indikator -->
                @if($rpp->kd_pengetahuan || $rpp->kd_keterampilan || $rpp->indikator_pencapaian_kompetensi)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>3. KD & Indikator</h5>
                    </div>
                    <div class="card-body">
                        @if($rpp->kd_pengetahuan)
                        <div class="mb-3">
                            <strong>KD Pengetahuan:</strong>
                            <div class="content-box mt-2">{{ $rpp->kd_pengetahuan }}</div>
                        </div>
                        @endif
                        @if($rpp->kd_keterampilan)
                        <div class="mb-3">
                            <strong>KD Keterampilan:</strong>
                            <div class="content-box mt-2">{{ $rpp->kd_keterampilan }}</div>
                        </div>
                        @endif
                        @if($rpp->indikator_pencapaian_kompetensi)
                        <div class="mb-3">
                            <strong>Indikator Pencapaian Kompetensi:</strong>
                            <div class="content-box mt-2">{{ $rpp->indikator_pencapaian_kompetensi }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- 4. Tujuan Pembelajaran -->
                @if($rpp->tujuan_pembelajaran)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>4. Tujuan Pembelajaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="content-box">{{ $rpp->tujuan_pembelajaran }}</div>
                    </div>
                </div>
                @endif

                <!-- 5. Materi Pembelajaran -->
                @if($rpp->materi_pembelajaran || $rpp->materi_pembelajaran_reguler || $rpp->materi_pembelajaran_pengayaan || $rpp->materi_pembelajaran_remedial)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i>5. Materi Pembelajaran</h5>
                    </div>
                    <div class="card-body">
                        @if($rpp->materi_pembelajaran)
                        <div class="mb-3">
                            <strong>Materi Pembelajaran:</strong>
                            <div class="content-box mt-2">{{ $rpp->materi_pembelajaran }}</div>
                        </div>
                        @endif
                        @if($rpp->materi_pembelajaran_reguler)
                        <div class="mb-3">
                            <strong>Materi Pembelajaran Reguler:</strong>
                            <div class="content-box mt-2">{{ $rpp->materi_pembelajaran_reguler }}</div>
                        </div>
                        @endif
                        @if($rpp->materi_pembelajaran_pengayaan)
                        <div class="mb-3">
                            <strong>Materi Pembelajaran Pengayaan:</strong>
                            <div class="content-box mt-2">{{ $rpp->materi_pembelajaran_pengayaan }}</div>
                        </div>
                        @endif
                        @if($rpp->materi_pembelajaran_remedial)
                        <div class="mb-3">
                            <strong>Materi Pembelajaran Remedial:</strong>
                            <div class="content-box mt-2">{{ $rpp->materi_pembelajaran_remedial }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- 6. Metode Pembelajaran -->
                @if($rpp->metode_pembelajaran)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>6. Metode Pembelajaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="content-box">{{ $rpp->metode_pembelajaran }}</div>
                    </div>
                </div>
                @endif

                <!-- 7. Skenario Pembelajaran -->
                @if($rpp->kegiatan_pendahuluan || $rpp->kegiatan_inti || $rpp->kegiatan_penutup)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>7. Skenario Pembelajaran</h5>
                    </div>
                    <div class="card-body">
                        @if($rpp->kegiatan_pendahuluan)
                        <div class="mb-3">
                            <strong>Kegiatan Pendahuluan:</strong>
                            <div class="content-box mt-2">{{ $rpp->kegiatan_pendahuluan }}</div>
                        </div>
                        @endif
                        @if($rpp->kegiatan_inti)
                        <div class="mb-3">
                            <strong>Kegiatan Inti:</strong>
                            <div class="content-box mt-2">{{ $rpp->kegiatan_inti }}</div>
                        </div>
                        @endif
                        @if($rpp->kegiatan_penutup)
                        <div class="mb-3">
                            <strong>Kegiatan Penutup:</strong>
                            <div class="content-box mt-2">{{ $rpp->kegiatan_penutup }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- 8. Media & Sumber Ajar -->
                @if($rpp->media_pembelajaran || $rpp->sumber_belajar)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-tv me-2"></i>8. Media & Sumber Ajar</h5>
                    </div>
                    <div class="card-body">
                        @if($rpp->media_pembelajaran)
                        <div class="mb-3">
                            <strong>Media Pembelajaran:</strong>
                            <div class="content-box mt-2">{{ $rpp->media_pembelajaran }}</div>
                        </div>
                        @endif
                        @if($rpp->sumber_belajar)
                        <div class="mb-3">
                            <strong>Sumber Belajar:</strong>
                            <div class="content-box mt-2">{{ $rpp->sumber_belajar }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- 9. Instrumen Penilaian -->
                @if($rpp->teknik_penilaian || $rpp->bentuk_instrumen || $rpp->rubrik_penilaian || $rpp->kriteria_ketuntasan)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>9. Instrumen Penilaian</h5>
                    </div>
                    <div class="card-body">
                        @if($rpp->teknik_penilaian)
                        <div class="mb-3">
                            <strong>Teknik Penilaian:</strong>
                            <div class="content-box mt-2">{{ $rpp->teknik_penilaian }}</div>
                        </div>
                        @endif
                        @if($rpp->bentuk_instrumen)
                        <div class="mb-3">
                            <strong>Bentuk Instrumen:</strong>
                            <div class="content-box mt-2">{{ $rpp->bentuk_instrumen }}</div>
                        </div>
                        @endif
                        @if($rpp->rubrik_penilaian)
                        <div class="mb-3">
                            <strong>Rubrik Penilaian:</strong>
                            <div class="content-box mt-2">{{ $rpp->rubrik_penilaian }}</div>
                        </div>
                        @endif
                        @if($rpp->kriteria_ketuntasan)
                        <div class="mb-3">
                            <strong>Kriteria Ketuntasan:</strong>
                            <div class="content-box mt-2">{{ $rpp->kriteria_ketuntasan }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('guru.rpp.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                    <a href="{{ route('guru.rpp.edit', $rpp) }}" class="btn btn-success">
                        <i class="fas fa-edit me-2"></i>Edit RPP
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
