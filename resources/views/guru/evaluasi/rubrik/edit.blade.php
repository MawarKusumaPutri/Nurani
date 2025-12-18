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
                                </label>
                                <!-- Penjelasan Kriteria Penilaian - TETAP TERLIHAT -->
                                <!-- Penjelasan Kriteria Penilaian - TETAP TERLIHAT - BAGIAN KUNING -->
                                <div id="kriteria-penjelasan-kuning" class="alert alert-warning mb-3 kriteria-penjelasan" style="font-size: 0.9rem; display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; background-color: #fff3cd !important; border-color: #ffc107 !important; color: #856404 !important;">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Apa itu Kriteria Penilaian?</strong><br>
                                    Kriteria penilaian adalah <strong>aspek-aspek atau komponen</strong> yang akan dinilai dari siswa. 
                                    Ini membantu guru untuk menilai siswa secara lebih terstruktur dan objektif.
                                    <br><br>
                                    <strong>Contoh Kriteria Penilaian:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>Pemahaman Konsep:</strong> Seberapa baik siswa memahami materi pelajaran</li>
                                        <li><strong>Keterampilan Praktik:</strong> Kemampuan siswa menerapkan teori dalam praktik</li>
                                        <li><strong>Kreativitas:</strong> Kemampuan siswa berpikir kreatif dan inovatif</li>
                                        <li><strong>Kerjasama:</strong> Kemampuan siswa bekerja dalam tim</li>
                                        <li><strong>Presentasi:</strong> Kemampuan siswa menyampaikan hasil kerja</li>
                                    </ul>
                                </div>
                                <textarea class="form-control" id="kriteria_penilaian" name="kriteria_penilaian" rows="8" required>{{ old('kriteria_penilaian', is_array($rubrik->kriteria_penilaian) ? json_encode($rubrik->kriteria_penilaian, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $rubrik->kriteria_penilaian) }}</textarea>
                                <!-- Contoh Cara Mengisi - TETAP TERLIHAT -->
                                <!-- Contoh Cara Mengisi - TETAP TERLIHAT - BAGIAN BIRU -->
                                <div id="kriteria-contoh-biru" class="mt-2 kriteria-contoh" style="display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;">
                                    <div class="alert alert-info mb-0" style="font-size: 0.875rem; background-color: #d1ecf1 !important; border-color: #bee5eb !important; color: #0c5460 !important;">
                                        <strong><i class="fas fa-book me-1"></i>Cara Mengisi (Format Teks - Paling Mudah):</strong><br>
                                        <code style="display: block; padding: 0.75rem; margin-top: 0.5rem; background: #f8f9fa; border-radius: 4px; white-space: pre-wrap;">
1. Pemahaman Konsep: Siswa mampu memahami konsep dasar materi dengan baik dan dapat menjelaskannya kembali

2. Keterampilan Praktik: Siswa dapat menerapkan konsep yang dipelajari dalam situasi praktik atau kehidupan sehari-hari

3. Kreativitas: Siswa menunjukkan kreativitas dan inovasi dalam menyelesaikan masalah atau tugas

4. Kerjasama: Siswa aktif berpartisipasi dalam kerja kelompok dan dapat bekerja sama dengan baik

5. Presentasi: Siswa dapat menyampaikan hasil kerja dengan jelas dan menarik
                                        </code>
                                        <strong class="mt-3 d-block"><i class="fas fa-code me-1"></i>Atau Format JSON (Opsional):</strong><br>
                                        <code style="display: block; padding: 0.75rem; margin-top: 0.5rem; background: #f8f9fa; border-radius: 4px;">
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
    
    /* Pastikan bagian penjelasan Kriteria Penilaian TETAP TERLIHAT - ULTRA AGGRESSIVE */
    .kriteria-penjelasan,
    .kriteria-penjelasan.alert,
    .kriteria-penjelasan.alert-warning {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        z-index: 1 !important;
        height: auto !important;
        overflow: visible !important;
        max-height: none !important;
        min-height: auto !important;
    }
    
    .kriteria-contoh,
    .kriteria-contoh .alert,
    .kriteria-contoh .alert-info {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        z-index: 1 !important;
        height: auto !important;
        overflow: visible !important;
        max-height: none !important;
        min-height: auto !important;
    }
    
    /* Pastikan tidak ada yang menyembunyikan - FORCE VISIBLE */
    .kriteria-penjelasan *,
    .kriteria-contoh *,
    .kriteria-penjelasan ul,
    .kriteria-penjelasan li,
    .kriteria-contoh code,
    .kriteria-contoh strong {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    .kriteria-penjelasan ul {
        display: block !important;
        list-style-type: disc !important;
        padding-left: 1.5rem !important;
    }
    
    .kriteria-penjelasan li {
        display: list-item !important;
    }
    
    .kriteria-contoh code {
        display: block !important;
        white-space: pre-wrap !important;
    }
    
    /* Override semua kemungkinan hidden */
    .kriteria-penjelasan[style*="display: none"],
    .kriteria-contoh[style*="display: none"],
    .kriteria-penjelasan[style*="visibility: hidden"],
    .kriteria-contoh[style*="visibility: hidden"] {
        display: block !important;
        visibility: visible !important;
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
    
    // Pastikan bagian penjelasan Kriteria Penilaian TETAP TERLIHAT - ULTRA AGGRESSIVE
    function ensureKriteriaVisible() {
        // Cari semua elemen yang mungkin menyembunyikan - menggunakan ID dan class
        const penjelasan = document.getElementById('kriteria-penjelasan-kuning') || document.querySelector('.kriteria-penjelasan');
        const contoh = document.getElementById('kriteria-contoh-biru') || document.querySelector('.kriteria-contoh');
        const alertWarning = document.querySelector('#kriteria-penjelasan-kuning') || document.querySelector('.kriteria-penjelasan.alert-warning');
        const alertInfo = document.querySelector('#kriteria-contoh-biru .alert-info') || document.querySelector('.kriteria-contoh .alert-info');
        
        // Force visibility untuk bagian kuning (penjelasan)
        if (penjelasan) {
            penjelasan.style.setProperty('display', 'block', 'important');
            penjelasan.style.setProperty('visibility', 'visible', 'important');
            penjelasan.style.setProperty('opacity', '1', 'important');
            penjelasan.style.setProperty('position', 'relative', 'important');
            penjelasan.style.setProperty('height', 'auto', 'important');
            penjelasan.style.setProperty('overflow', 'visible', 'important');
            penjelasan.style.setProperty('max-height', 'none', 'important');
            penjelasan.style.setProperty('min-height', 'auto', 'important');
            penjelasan.classList.remove('d-none', 'hidden', 'collapse');
            penjelasan.classList.add('d-block');
        }
        
        if (alertWarning) {
            alertWarning.style.setProperty('display', 'block', 'important');
            alertWarning.style.setProperty('visibility', 'visible', 'important');
            alertWarning.style.setProperty('opacity', '1', 'important');
        }
        
        // Force visibility untuk bagian biru (contoh)
        if (contoh) {
            contoh.style.setProperty('display', 'block', 'important');
            contoh.style.setProperty('visibility', 'visible', 'important');
            contoh.style.setProperty('opacity', '1', 'important');
            contoh.style.setProperty('position', 'relative', 'important');
            contoh.style.setProperty('height', 'auto', 'important');
            contoh.style.setProperty('overflow', 'visible', 'important');
            contoh.style.setProperty('max-height', 'none', 'important');
            contoh.style.setProperty('min-height', 'auto', 'important');
            contoh.classList.remove('d-none', 'hidden', 'collapse');
            contoh.classList.add('d-block');
        }
        
        if (alertInfo) {
            alertInfo.style.setProperty('display', 'block', 'important');
            alertInfo.style.setProperty('visibility', 'visible', 'important');
            alertInfo.style.setProperty('opacity', '1', 'important');
        }
        
        // Pastikan semua child elements juga terlihat
        const allElements = document.querySelectorAll('.kriteria-penjelasan *, .kriteria-contoh *');
        allElements.forEach(function(el) {
            if (el.tagName !== 'SCRIPT' && el.tagName !== 'STYLE') {
                el.style.setProperty('display', '', 'important');
                el.style.setProperty('visibility', 'visible', 'important');
            }
        });
    }
    
    // Jalankan saat DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ensureKriteriaVisible);
    } else {
        ensureKriteriaVisible();
    }
    
    // Jalankan setelah load
    window.addEventListener('load', ensureKriteriaVisible);
    
    // Monitor setiap 100ms untuk memastikan tetap terlihat - SANGAT AGGRESIF
    setInterval(ensureKriteriaVisible, 100);
    
    // Observer untuk memastikan tidak ada yang mengubah display
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                ensureKriteriaVisible();
            }
        });
    });
    
    // Observe perubahan pada elemen penjelasan
    document.addEventListener('DOMContentLoaded', function() {
        const penjelasan = document.getElementById('kriteria-penjelasan-kuning') || document.querySelector('.kriteria-penjelasan');
        const contoh = document.getElementById('kriteria-contoh-biru') || document.querySelector('.kriteria-contoh');
        
        if (penjelasan) {
            observer.observe(penjelasan, { attributes: true, attributeFilter: ['style', 'class'] });
        }
        if (contoh) {
            observer.observe(contoh, { attributes: true, attributeFilter: ['style', 'class'] });
        }
    });
</script>
