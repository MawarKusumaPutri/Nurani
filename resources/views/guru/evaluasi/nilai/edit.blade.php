@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai Harian - {{ $guru->user->name }}</title>
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
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            background-color: #ffffff !important;
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
                        <i class="fas fa-edit me-2 text-warning"></i>
                        Edit Nilai Harian
                    </h2>
                    <p class="text-muted mb-3">Ubah nilai harian, UTS, dan UAS siswa</p>
                    <a href="{{ route('guru.evaluasi.nilai.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-10 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('guru.evaluasi.nilai.update', $nilai->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                            <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                                <option value="">Pilih Mata Pelajaran</option>
                                                @foreach($mataPelajaranList as $mapel)
                                                    <option value="{{ $mapel->mata_pelajaran }}" {{ $nilai->mata_pelajaran == $mapel->mata_pelajaran ? 'selected' : '' }}>{{ $mapel->mata_pelajaran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kelas" name="kelas" required>
                                                <option value="">Pilih Kelas</option>
                                                <option value="7" {{ $nilai->kelas == '7' ? 'selected' : '' }}>Kelas 7</option>
                                                <option value="8" {{ $nilai->kelas == '8' ? 'selected' : '' }}>Kelas 8</option>
                                                <option value="9" {{ $nilai->kelas == '9' ? 'selected' : '' }}>Kelas 9</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="siswa_id" class="form-label">Siswa <span class="text-danger">*</span></label>
                                        <select class="form-select" id="siswa_id" name="siswa_id" required>
                                            <option value="">Memuat siswa...</option>
                                        </select>
                                        <small class="text-muted">Pilih kelas terlebih dahulu untuk menampilkan daftar siswa</small>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                            <select class="form-select" id="semester" name="semester" required>
                                                <option value="">Pilih Semester</option>
                                                <option value="Ganjil" {{ $nilai->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                                <option value="Genap" {{ $nilai->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                                            <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" value="{{ $nilai->tahun_pelajaran ?? date('Y') . '/' . (date('Y') + 1) }}" placeholder="2024/2025" pattern="\d{4}/\d{4}">
                                            <small class="text-muted">Format: YYYY/YYYY (contoh: 2024/2025 atau 2025/2026)</small>
                                        </div>
                                    </div>

                                    <hr>
                                    <h5 class="mb-3">Nilai Harian</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="formatif_1" class="form-label">Nilai Harian</label>
                                            <input type="number" step="0.01" min="0" max="100" class="form-control" id="formatif_1" name="formatif_1" value="{{ $nilai->formatif_1 }}" placeholder="0.00">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_nilai_harian" class="form-label">Tanggal Nilai Harian</label>
                                            <input type="date" class="form-control" id="tanggal_nilai_harian" name="tanggal_nilai_harian" value="{{ $nilai->tanggal_nilai_harian ? \Carbon\Carbon::parse($nilai->tanggal_nilai_harian)->format('Y-m-d') : date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="formatif_2" class="form-label">Nilai Harian 2 (Opsional)</label>
                                            <input type="number" step="0.01" min="0" max="100" class="form-control" id="formatif_2" name="formatif_2" value="{{ $nilai->formatif_2 }}" placeholder="0.00">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_nilai_harian_2" class="form-label">Tanggal Nilai Harian 2</label>
                                            <input type="date" class="form-control" id="tanggal_nilai_harian_2" name="tanggal_nilai_harian_2" value="{{ $nilai->tanggal_nilai_harian_2 ? \Carbon\Carbon::parse($nilai->tanggal_nilai_harian_2)->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="formatif_3" class="form-label">Nilai Harian 3 (Opsional)</label>
                                            <input type="number" step="0.01" min="0" max="100" class="form-control" id="formatif_3" name="formatif_3" value="{{ $nilai->formatif_3 }}" placeholder="0.00">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_nilai_harian_3" class="form-label">Tanggal Nilai Harian 3</label>
                                            <input type="date" class="form-control" id="tanggal_nilai_harian_3" name="tanggal_nilai_harian_3" value="{{ $nilai->tanggal_nilai_harian_3 ? \Carbon\Carbon::parse($nilai->tanggal_nilai_harian_3)->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="formatif_4" class="form-label">Nilai Harian 4 (Opsional)</label>
                                            <input type="number" step="0.01" min="0" max="100" class="form-control" id="formatif_4" name="formatif_4" value="{{ $nilai->formatif_4 }}" placeholder="0.00">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_nilai_harian_4" class="form-label">Tanggal Nilai Harian 4</label>
                                            <input type="date" class="form-control" id="tanggal_nilai_harian_4" name="tanggal_nilai_harian_4" value="{{ $nilai->tanggal_nilai_harian_4 ? \Carbon\Carbon::parse($nilai->tanggal_nilai_harian_4)->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>

                                    <hr>
                                    <h5 class="mb-3">Nilai Sumatif</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sumatif_uts" class="form-label">UTS</label>
                                            <input type="number" step="0.01" min="0" max="100" class="form-control" id="sumatif_uts" name="sumatif_uts" value="{{ $nilai->sumatif_uts }}" placeholder="0.00">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_uts" class="form-label">Tanggal UTS</label>
                                            <input type="date" class="form-control" id="tanggal_uts" name="tanggal_uts" value="{{ $nilai->tanggal_uts ? \Carbon\Carbon::parse($nilai->tanggal_uts)->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="sumatif_uas" class="form-label">UAS</label>
                                            <input type="number" step="0.01" min="0" max="100" class="form-control" id="sumatif_uas" name="sumatif_uas" value="{{ $nilai->sumatif_uas }}" placeholder="0.00">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_uas" class="form-label">Tanggal UAS</label>
                                            <input type="date" class="form-control" id="tanggal_uas" name="tanggal_uas" value="{{ $nilai->tanggal_uas ? \Carbon\Carbon::parse($nilai->tanggal_uas)->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan">{{ $nilai->keterangan }}</textarea>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                        <a href="{{ route('guru.evaluasi.nilai.index') }}" class="btn btn-secondary">
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
        
        function forceWhiteBackground() {
            const selectors = ['html', 'body', '.container-fluid', '.row', '.col-md-9', '.col-lg-10', '.p-4', '.col-md-10', '.col-lg-8'];
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

        // Filter siswa berdasarkan kelas
        const kelasSelect = document.getElementById('kelas');
        const siswaSelect = document.getElementById('siswa_id');
        const selectedSiswaId = {{ $nilai->siswa_id ?? 'null' }};
        
        function loadSiswaByKelas(kelas, selectedId = null) {
            if (!kelas) {
                siswaSelect.innerHTML = '<option value="">Pilih Kelas terlebih dahulu</option>';
                siswaSelect.disabled = false;
                return;
            }
            
            siswaSelect.innerHTML = '<option value="">Memuat siswa...</option>';
            siswaSelect.disabled = true;
            
            fetch(`{{ route('guru.evaluasi.get-siswa-by-kelas') }}?kelas=${kelas}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
                
                if (data.siswa && data.siswa.length > 0) {
                    data.siswa.forEach(function(siswa) {
                        const option = document.createElement('option');
                        option.value = siswa.id;
                        option.textContent = siswa.nama;
                        if (selectedId && siswa.id == selectedId) {
                            option.selected = true;
                        }
                        siswaSelect.appendChild(option);
                    });
                } else {
                    siswaSelect.innerHTML = '<option value="">Tidak ada siswa di kelas ini</option>';
                }
                
                siswaSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                siswaSelect.innerHTML = '<option value="">Error memuat siswa</option>';
                siswaSelect.disabled = false;
            });
        }
        
        if (kelasSelect && siswaSelect) {
            // Load siswa saat halaman dimuat
            const currentKelas = kelasSelect.value;
            if (currentKelas) {
                loadSiswaByKelas(currentKelas, selectedSiswaId);
            }
            
            // Load siswa saat kelas berubah
            kelasSelect.addEventListener('change', function() {
                loadSiswaByKelas(this.value);
            });
        }
    </script>
</body>
</html>
