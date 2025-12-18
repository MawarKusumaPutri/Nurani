@include('partials.guru-sidebar')

<div class="col-md-9 col-lg-10 content">
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-2">
                    <i class="fas fa-edit me-2 text-primary"></i>
                    Edit Rubrik Penilaian
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('guru.evaluasi.rubrik.update', $rubrik->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Rubrik <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $rubrik->judul) }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        @foreach($mataPelajaranList as $mapel)
                                            <option value="{{ $mapel->mata_pelajaran }}" {{ old('mata_pelajaran', $rubrik->mata_pelajaran) == $mapel->mata_pelajaran ? 'selected' : '' }}>
                                                {{ $mapel->mata_pelajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <option value="7" {{ old('kelas', $rubrik->kelas) == '7' ? 'selected' : '' }}>Kelas 7</option>
                                        <option value="8" {{ old('kelas', $rubrik->kelas) == '8' ? 'selected' : '' }}>Kelas 8</option>
                                        <option value="9" {{ old('kelas', $rubrik->kelas) == '9' ? 'selected' : '' }}>Kelas 9</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                    <select class="form-select" id="semester" name="semester" required>
                                        <option value="">Pilih Semester</option>
                                        <option value="Ganjil" {{ old('semester', $rubrik->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                        <option value="Genap" {{ old('semester', $rubrik->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                                    <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" value="{{ old('tahun_pelajaran', $rubrik->tahun_pelajaran) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $rubrik->deskripsi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="kriteria_penilaian" class="form-label">
                                    Kriteria Penilaian <span class="text-danger">*</span>
                                    <i class="fas fa-info-circle text-info ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Kriteria penilaian adalah aspek-aspek yang akan dinilai. Contoh: Pemahaman Konsep, Keterampilan Praktik, Kreativitas, dll."></i>
                                </label>
                                <textarea class="form-control" id="kriteria_penilaian" name="kriteria_penilaian" rows="6" required>{{ old('kriteria_penilaian', $rubrik->kriteria_penilaian) }}</textarea>
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-lightbulb text-warning me-1"></i>
                                        <strong>Penjelasan:</strong> Kriteria penilaian adalah aspek-aspek yang akan dinilai dari siswa. Anda dapat menuliskan dalam format teks biasa atau JSON.
                                    </small>
                                    <div class="alert alert-info mb-0" style="font-size: 0.875rem;">
                                        <strong><i class="fas fa-book me-1"></i>Contoh Format Teks:</strong><br>
                                        <code style="display: block; padding: 0.5rem; margin-top: 0.5rem; background: #f8f9fa; border-radius: 4px;">
                                            1. Pemahaman Konsep: Siswa mampu memahami konsep dasar materi dengan baik<br>
                                            2. Keterampilan Praktik: Siswa dapat menerapkan konsep dalam praktik<br>
                                            3. Kreativitas: Siswa menunjukkan kreativitas dalam menyelesaikan masalah<br>
                                            4. Kerjasama: Siswa aktif berpartisipasi dalam kerja kelompok
                                        </code>
                                        <strong class="mt-2 d-block"><i class="fas fa-code me-1"></i>Contoh Format JSON:</strong><br>
                                        <code style="display: block; padding: 0.5rem; margin-top: 0.5rem; background: #f8f9fa; border-radius: 4px;">
                                            {"Pemahaman Konsep": "Siswa mampu memahami konsep dasar", "Keterampilan Praktik": "Siswa dapat menerapkan konsep", "Kreativitas": "Siswa menunjukkan kreativitas"}
                                        </code>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="skala_nilai" class="form-label">Skala Nilai</label>
                                <input type="text" class="form-control" id="skala_nilai" name="skala_nilai" value="{{ old('skala_nilai', $rubrik->skala_nilai) }}">
                            </div>

                            <div class="mb-3">
                                <label for="indikator" class="form-label">Indikator</label>
                                <textarea class="form-control" id="indikator" name="indikator" rows="3">{{ old('indikator', $rubrik->indikator) }}</textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update
                                </button>
                                <a href="{{ route('guru.evaluasi.rubrik.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    html, body {
        background-color: #ffffff !important;
    }
    
    .content {
        min-height: 100vh;
        background-color: #f8f9fa;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
