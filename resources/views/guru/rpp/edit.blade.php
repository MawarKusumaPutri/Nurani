<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit RPP - {{ $guru->user->name }}</title>
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
        
        .accordion-button {
            font-weight: 600;
            color: #2E7D32;
        }
        
        .accordion-button:not(.collapsed) {
            background-color: #e8f5e9;
            color: #2E7D32;
        }
        
        .form-label {
            font-weight: 500;
            color: #333;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
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
                        <h2 class="mb-1">Edit RPP</h2>
                        <p class="text-muted mb-0">{{ $rpp->judul }}</p>
                    </div>
                    <a href="{{ route('guru.rpp.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('guru.rpp.update', $rpp) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Informasi Dasar -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="judul" class="form-label">Judul RPP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $rpp->judul) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                        <option value="">-- Pilih Mata Pelajaran --</option>
                                        @foreach($mataPelajaranList as $mp)
                                            <option value="{{ $mp->mata_pelajaran }}" {{ old('mata_pelajaran', $rpp->mata_pelajaran) == $mp->mata_pelajaran ? 'selected' : '' }}>
                                                {{ $mp->mata_pelajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kelas" name="kelas" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <option value="7" {{ old('kelas', $rpp->kelas) == '7' ? 'selected' : '' }}>Kelas 7</option>
                                        <option value="8" {{ old('kelas', $rpp->kelas) == '8' ? 'selected' : '' }}>Kelas 8</option>
                                        <option value="9" {{ old('kelas', $rpp->kelas) == '9' ? 'selected' : '' }}>Kelas 9</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                    <select class="form-select" id="semester" name="semester" required>
                                        <option value="">-- Pilih Semester --</option>
                                        <option value="1" {{ old('semester', $rpp->semester) == '1' ? 'selected' : '' }}>Semester 1</option>
                                        <option value="2" {{ old('semester', $rpp->semester) == '2' ? 'selected' : '' }}>Semester 2</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="pertemuan_ke" class="form-label">Pertemuan ke- <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="pertemuan_ke" name="pertemuan_ke" value="{{ old('pertemuan_ke', $rpp->pertemuan_ke) }}" min="1" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="alokasi_waktu" class="form-label">Alokasi Waktu (menit) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="alokasi_waktu" name="alokasi_waktu" value="{{ old('alokasi_waktu', $rpp->alokasi_waktu) }}" min="1" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion untuk 9 Bagian RPP -->
                    <div class="accordion" id="rppAccordion">
                        <!-- 1. Identitas Pembelajaran -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    <i class="fas fa-id-card me-2"></i>1. Identitas Pembelajaran
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sekolah" class="form-label">Sekolah</label>
                                            <input type="text" class="form-control" id="sekolah" name="sekolah" value="{{ old('sekolah', $rpp->sekolah ?? 'MTs Nurul Aiman') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="mata_pelajaran_detail" class="form-label">Mata Pelajaran (Detail)</label>
                                            <input type="text" class="form-control" id="mata_pelajaran_detail" name="mata_pelajaran_detail" value="{{ old('mata_pelajaran_detail', $rpp->mata_pelajaran_detail) }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="kelas_detail" class="form-label">Kelas (Detail)</label>
                                            <input type="text" class="form-control" id="kelas_detail" name="kelas_detail" value="{{ old('kelas_detail', $rpp->kelas_detail) }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="semester_detail" class="form-label">Semester (Detail)</label>
                                            <input type="text" class="form-control" id="semester_detail" name="semester_detail" value="{{ old('semester_detail', $rpp->semester_detail) }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                                            <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" value="{{ old('tahun_pelajaran', $rpp->tahun_pelajaran ?? date('Y') . '/' . (date('Y') + 1)) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Kompetensi Inti (KI) -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    <i class="fas fa-list-check me-2"></i>2. Kompetensi Inti (KI)
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="ki_1" class="form-label">KI-1 (Sikap Spiritual)</label>
                                        <textarea class="form-control" id="ki_1" name="ki_1" rows="3">{{ old('ki_1', $rpp->ki_1) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ki_2" class="form-label">KI-2 (Sikap Sosial)</label>
                                        <textarea class="form-control" id="ki_2" name="ki_2" rows="3">{{ old('ki_2', $rpp->ki_2) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ki_3" class="form-label">KI-3 (Pengetahuan)</label>
                                        <textarea class="form-control" id="ki_3" name="ki_3" rows="3">{{ old('ki_3', $rpp->ki_3) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ki_4" class="form-label">KI-4 (Keterampilan)</label>
                                        <textarea class="form-control" id="ki_4" name="ki_4" rows="3">{{ old('ki_4', $rpp->ki_4) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. KD & Indikator -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    <i class="fas fa-bullseye me-2"></i>3. KD & Indikator
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="kd_pengetahuan" class="form-label">KD Pengetahuan</label>
                                        <textarea class="form-control" id="kd_pengetahuan" name="kd_pengetahuan" rows="3">{{ old('kd_pengetahuan', $rpp->kd_pengetahuan) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kd_keterampilan" class="form-label">KD Keterampilan</label>
                                        <textarea class="form-control" id="kd_keterampilan" name="kd_keterampilan" rows="3">{{ old('kd_keterampilan', $rpp->kd_keterampilan) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="indikator_pencapaian_kompetensi" class="form-label">Indikator Pencapaian Kompetensi</label>
                                        <textarea class="form-control" id="indikator_pencapaian_kompetensi" name="indikator_pencapaian_kompetensi" rows="4">{{ old('indikator_pencapaian_kompetensi', $rpp->indikator_pencapaian_kompetensi) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Tujuan Pembelajaran -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                    <i class="fas fa-bullseye me-2"></i>4. Tujuan Pembelajaran
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="tujuan_pembelajaran" class="form-label">Tujuan Pembelajaran</label>
                                        <textarea class="form-control" id="tujuan_pembelajaran" name="tujuan_pembelajaran" rows="5">{{ old('tujuan_pembelajaran', $rpp->tujuan_pembelajaran) }}</textarea>
                                        <small class="text-muted">Tuliskan tujuan pembelajaran yang ingin dicapai</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Materi Pembelajaran -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                    <i class="fas fa-book me-2"></i>5. Materi Pembelajaran
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="materi_pembelajaran" class="form-label">Materi Pembelajaran</label>
                                        <textarea class="form-control" id="materi_pembelajaran" name="materi_pembelajaran" rows="4">{{ old('materi_pembelajaran', $rpp->materi_pembelajaran) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="materi_pembelajaran_reguler" class="form-label">Materi Pembelajaran Reguler</label>
                                        <textarea class="form-control" id="materi_pembelajaran_reguler" name="materi_pembelajaran_reguler" rows="3">{{ old('materi_pembelajaran_reguler', $rpp->materi_pembelajaran_reguler) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="materi_pembelajaran_pengayaan" class="form-label">Materi Pembelajaran Pengayaan</label>
                                        <textarea class="form-control" id="materi_pembelajaran_pengayaan" name="materi_pembelajaran_pengayaan" rows="3">{{ old('materi_pembelajaran_pengayaan', $rpp->materi_pembelajaran_pengayaan) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="materi_pembelajaran_remedial" class="form-label">Materi Pembelajaran Remedial</label>
                                        <textarea class="form-control" id="materi_pembelajaran_remedial" name="materi_pembelajaran_remedial" rows="3">{{ old('materi_pembelajaran_remedial', $rpp->materi_pembelajaran_remedial) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Metode Pembelajaran -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>6. Metode Pembelajaran
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="metode_pembelajaran" class="form-label">Metode Pembelajaran</label>
                                        <textarea class="form-control" id="metode_pembelajaran" name="metode_pembelajaran" rows="4">{{ old('metode_pembelajaran', $rpp->metode_pembelajaran) }}</textarea>
                                        <small class="text-muted">Contoh: Ceramah, Diskusi, Tanya Jawab, Praktik, dll.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Skenario Pembelajaran -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">
                                    <i class="fas fa-tasks me-2"></i>7. Skenario Pembelajaran
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="kegiatan_pendahuluan" class="form-label">Kegiatan Pendahuluan</label>
                                        <textarea class="form-control" id="kegiatan_pendahuluan" name="kegiatan_pendahuluan" rows="4">{{ old('kegiatan_pendahuluan', $rpp->kegiatan_pendahuluan) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kegiatan_inti" class="form-label">Kegiatan Inti</label>
                                        <textarea class="form-control" id="kegiatan_inti" name="kegiatan_inti" rows="6">{{ old('kegiatan_inti', $rpp->kegiatan_inti) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kegiatan_penutup" class="form-label">Kegiatan Penutup</label>
                                        <textarea class="form-control" id="kegiatan_penutup" name="kegiatan_penutup" rows="4">{{ old('kegiatan_penutup', $rpp->kegiatan_penutup) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Media & Sumber Ajar -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8">
                                    <i class="fas fa-tv me-2"></i>8. Media & Sumber Ajar
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="media_pembelajaran" class="form-label">Media Pembelajaran</label>
                                        <textarea class="form-control" id="media_pembelajaran" name="media_pembelajaran" rows="4">{{ old('media_pembelajaran', $rpp->media_pembelajaran) }}</textarea>
                                        <small class="text-muted">Contoh: Papan tulis, Laptop, Proyektor, Video, dll.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sumber_belajar" class="form-label">Sumber Belajar</label>
                                        <textarea class="form-control" id="sumber_belajar" name="sumber_belajar" rows="4">{{ old('sumber_belajar', $rpp->sumber_belajar) }}</textarea>
                                        <small class="text-muted">Contoh: Buku paket, LKS, Internet, dll.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 9. Instrumen Penilaian -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9">
                                    <i class="fas fa-clipboard-check me-2"></i>9. Instrumen Penilaian
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse" data-bs-parent="#rppAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="teknik_penilaian" class="form-label">Teknik Penilaian</label>
                                        <textarea class="form-control" id="teknik_penilaian" name="teknik_penilaian" rows="3">{{ old('teknik_penilaian', $rpp->teknik_penilaian) }}</textarea>
                                        <small class="text-muted">Contoh: Tes tertulis, Observasi, Penugasan, dll.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bentuk_instrumen" class="form-label">Bentuk Instrumen</label>
                                        <textarea class="form-control" id="bentuk_instrumen" name="bentuk_instrumen" rows="3">{{ old('bentuk_instrumen', $rpp->bentuk_instrumen) }}</textarea>
                                        <small class="text-muted">Contoh: Soal pilihan ganda, Soal uraian, Lembar observasi, dll.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rubrik_penilaian" class="form-label">Rubrik Penilaian</label>
                                        <textarea class="form-control" id="rubrik_penilaian" name="rubrik_penilaian" rows="4">{{ old('rubrik_penilaian', $rpp->rubrik_penilaian) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kriteria_ketuntasan" class="form-label">Kriteria Ketuntasan</label>
                                        <textarea class="form-control" id="kriteria_ketuntasan" name="kriteria_ketuntasan" rows="3">{{ old('kriteria_ketuntasan', $rpp->kriteria_ketuntasan) }}</textarea>
                                        <small class="text-muted">Contoh: Siswa dinyatakan tuntas jika mencapai nilai ≥ 75</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('guru.rpp.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Update RPP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
