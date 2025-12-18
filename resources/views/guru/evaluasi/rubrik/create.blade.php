@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rubrik Penilaian - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        body {
            overflow-x: hidden;
        }
        
        .container-fluid {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        .row {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        .col-md-9, .col-lg-10 {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        /* Layout - sama seperti presensi (biarkan Bootstrap yang mengatur) */
        /* Pastikan di desktop, konten di samping sidebar - ULTRA VISIBLE */
        @media (min-width: 768px) {
            .container-fluid > .row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }
            
            /* Pastikan sidebar menggunakan ukuran Bootstrap default - Medium screen - ULTRA VISIBLE */
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 25% !important;
                width: 25% !important; /* col-md-3 = 25% */
                max-width: 25% !important;
                min-width: 250px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 75% !important;
                width: 75% !important; /* col-md-9 = 75% */
            }
        }
        
        /* Large screen - sidebar lebih kecil - ULTRA VISIBLE */
        @media (min-width: 992px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 16.66666667% !important;
                width: 16.66666667% !important; /* col-lg-2 = 16.67% */
                max-width: 16.66666667% !important;
                min-width: 200px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 83.33333333% !important;
                width: 83.33333333% !important; /* col-lg-10 = 83.33% */
            }
        }
        
        /* Main content - di samping sidebar (kanan) */
        .col-md-9.col-lg-10 {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1 !important;
            min-height: 100vh !important;
            padding: 1rem 1.5rem !important;
            background-color: #ffffff !important;
            box-sizing: border-box !important;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            width: auto !important;
            left: 0 !important;
            transform: translateX(0) !important;
        }
        
        /* Pastikan sidebar tidak memaksa konten ke bawah di desktop */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar {
                position: relative !important;
                float: none !important;
            }
        }
        
        /* Ensure sidebar content is scrollable - ULTRA VISIBLE */
        #guru-sidebar {
            display: flex !important;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            left: 0 !important;
            transform: translateX(0) !important;
            z-index: 1000 !important;
            width: 100% !important;
        }
        
        /* PASTIKAN SIDEBAR TIDAK TERSEMBUNYI - ULTRA AGGRESSIVE */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
        
        /* Pastikan konten tidak tersembunyi */
        .col-md-9.col-lg-10 > * {
            display: block !important;
            visibility: visible !important;
        }
        
        .col-md-9.col-lg-10 h2,
        .col-md-9.col-lg-10 .row,
        .col-md-9.col-lg-10 .card,
        .col-md-9.col-lg-10 .alert {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
            background-color: #ffffff !important;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 0.375rem;
        }
        
        .p-4 {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        /* Pastikan bagian penjelasan Kriteria Penilaian TETAP TERLIHAT */
        .kriteria-penjelasan,
        .kriteria-contoh {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1 !important;
            height: auto !important;
            overflow: visible !important;
        }
        
        .kriteria-penjelasan .alert,
        .kriteria-contoh .alert {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Pastikan tidak ada yang menyembunyikan */
        .kriteria-penjelasan *,
        .kriteria-contoh * {
            display: block !important;
            visibility: visible !important;
        }
        
        .kriteria-penjelasan ul,
        .kriteria-contoh code {
            display: block !important;
            visibility: visible !important;
        }
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1050;
                transition: left 0.3s ease;
                width: 280px;
                max-width: 80%;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .col-md-9.col-lg-10 {
                width: 100% !important;
                margin-left: 0 !important;
            }
            
            .col-md-3.col-lg-2.sidebar {
                width: 100% !important;
            }
        }
        
        /* OVERRIDE MOBILE CSS UNTUK DESKTOP - ULTRA AGGRESSIVE */
        @media (min-width: 768px) {
            .sidebar.col-md-3.col-lg-2,
            #guru-sidebar.col-md-3.col-lg-2,
            .col-md-3.col-lg-2#guru-sidebar,
            .col-md-3.col-lg-2.sidebar#guru-sidebar {
                position: relative !important;
                left: 0 !important;
                top: auto !important;
                transform: translateX(0) !important;
                transition: none !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        }
    </style>
    @include('partials.guru-dynamic-ui')
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid" style="background-color: #ffffff !important; background: #ffffff !important;">
        <div class="row" style="background-color: #ffffff !important; background: #ffffff !important;">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4" style="background-color: #ffffff !important; background: #ffffff !important;">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="mb-2">
                        <i class="fas fa-plus me-2 text-primary"></i>
                        Tambah Rubrik Penilaian
                    </h2>
                    <p class="text-muted mb-3">Buat rubrik penilaian baru untuk berbagai aspek pembelajaran</p>
                    <a href="{{ route('guru.evaluasi.rubrik.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('guru.evaluasi.rubrik.store') }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Rubrik <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul" name="judul" required placeholder="Contoh: Rubrik Penilaian Presentasi">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                            <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                                <option value="">Pilih Mata Pelajaran</option>
                                                @foreach($mataPelajaranList as $mapel)
                                                    <option value="{{ $mapel->mata_pelajaran }}">{{ $mapel->mata_pelajaran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kelas" name="kelas" required>
                                                <option value="">Pilih Kelas</option>
                                                <option value="7">Kelas 7</option>
                                                <option value="8">Kelas 8</option>
                                                <option value="9">Kelas 9</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                            <select class="form-select" id="semester" name="semester" required>
                                                <option value="">Pilih Semester</option>
                                                <option value="Ganjil">Ganjil</option>
                                                <option value="Genap">Genap</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                                            <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" placeholder="2024/2025">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi rubrik penilaian"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kriteria_penilaian" class="form-label">
                                            Kriteria Penilaian <span class="text-danger">*</span>
                                        </label>
                                        <!-- Penjelasan Kriteria Penilaian - TETAP TERLIHAT -->
                                        <div class="alert alert-warning mb-3 kriteria-penjelasan" style="font-size: 0.9rem; display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;">
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
                                        <textarea class="form-control" id="kriteria_penilaian" name="kriteria_penilaian" rows="8" required placeholder="Masukkan kriteria penilaian (lihat contoh di bawah)"></textarea>
                                        <!-- Contoh Cara Mengisi - TETAP TERLIHAT -->
                                        <div class="mt-2 kriteria-contoh" style="display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;">
                                            <div class="alert alert-info mb-0" style="font-size: 0.875rem;">
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
                                        <input type="text" class="form-control" id="skala_nilai" name="skala_nilai" placeholder="Contoh: 1-4, 1-5, 0-100">
                                    </div>

                                    <div class="mb-3">
                                        <label for="indikator" class="form-label">Indikator</label>
                                        <textarea class="form-control" id="indikator" name="indikator" rows="3" placeholder="Masukkan indikator penilaian"></textarea>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('guru-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (sidebar) {
                sidebar.classList.toggle('show');
            }
            if (overlay) {
                overlay.classList.toggle('show');
            }
        }
        
        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        
        // Force white background
        function forceWhiteBackground() {
            const selectors = [
                'html', 'body', '.container-fluid', '.row', 
                '.col-md-9', '.col-lg-10', '.p-4', '.content',
                '.col-md-10', '.col-lg-8'
            ];
            
            selectors.forEach(function(selector) {
                const elements = document.querySelectorAll(selector);
                elements.forEach(function(el) {
                    if (el && !el.classList.contains('sidebar')) {
                        el.style.setProperty('background-color', '#ffffff', 'important');
                        el.style.setProperty('background', '#ffffff', 'important');
                    }
                });
            });
        }
        
        forceWhiteBackground();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', forceWhiteBackground);
        }
        window.addEventListener('load', forceWhiteBackground);
        setInterval(forceWhiteBackground, 100);
        
        // Pastikan bagian penjelasan Kriteria Penilaian TETAP TERLIHAT
        function ensureKriteriaVisible() {
            const penjelasan = document.querySelector('.kriteria-penjelasan');
            const contoh = document.querySelector('.kriteria-contoh');
            
            if (penjelasan) {
                penjelasan.style.setProperty('display', 'block', 'important');
                penjelasan.style.setProperty('visibility', 'visible', 'important');
                penjelasan.style.setProperty('opacity', '1', 'important');
                penjelasan.style.setProperty('position', 'relative', 'important');
                penjelasan.style.setProperty('height', 'auto', 'important');
                penjelasan.style.setProperty('overflow', 'visible', 'important');
            }
            
            if (contoh) {
                contoh.style.setProperty('display', 'block', 'important');
                contoh.style.setProperty('visibility', 'visible', 'important');
                contoh.style.setProperty('opacity', '1', 'important');
                contoh.style.setProperty('position', 'relative', 'important');
                contoh.style.setProperty('height', 'auto', 'important');
                contoh.style.setProperty('overflow', 'visible', 'important');
            }
        }
        
        // Jalankan saat DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', ensureKriteriaVisible);
        } else {
            ensureKriteriaVisible();
        }
        
        // Jalankan setelah load
        window.addEventListener('load', ensureKriteriaVisible);
        
        // Monitor setiap detik untuk memastikan tetap terlihat
        setInterval(ensureKriteriaVisible, 1000);
        
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
            const penjelasan = document.querySelector('.kriteria-penjelasan');
            const contoh = document.querySelector('.kriteria-contoh');
            
            if (penjelasan) {
                observer.observe(penjelasan, { attributes: true, attributeFilter: ['style', 'class'] });
            }
            if (contoh) {
                observer.observe(contoh, { attributes: true, attributeFilter: ['style', 'class'] });
            }
        });
    </script>
</body>
</html>
