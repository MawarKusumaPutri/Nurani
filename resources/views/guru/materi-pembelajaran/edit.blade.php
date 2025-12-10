@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi Pembelajaran - {{ $guru->user->name }}</title>
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
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            background-color: #ffffff !important;
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-edit me-2 text-primary"></i>
                            Edit Materi Pembelajaran
                        </h2>
                        <p class="text-muted mb-0">Edit konten materi pembelajaran untuk {{ $mataPelajaran }}</p>
                    </div>
                    <a href="{{ route('guru.dashboard', ['mata_pelajaran' => $mataPelajaran]) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('guru.materi-pembelajaran.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <input type="hidden" name="mata_pelajaran" value="{{ $mataPelajaran }}">
                                    
                                    <!-- A. IDENTITAS SEKOLAH DAN PROGRAM -->
                                    <div class="mb-4 pb-4 border-bottom">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-school"></i>
                                            </div>
                                            <h5 class="mb-0 text-primary">A. IDENTITAS SEKOLAH DAN PROGRAM</h5>
                                        </div>
                                        
                                        @php
                                            // Parse existing data if available
                                            $identitasData = ['1' => '', '2' => '', '3' => '', '4' => '', '5' => '', '6' => ''];
                                            // Selalu gunakan mata pelajaran dari guru yang login untuk field 2
                                            $identitasData['2'] = $mataPelajaran;
                                            
                                            if ($materiPembelajaran && $materiPembelajaran->identitas_sekolah_program) {
                                                $lines = explode("\n", $materiPembelajaran->identitas_sekolah_program);
                                                foreach ($lines as $line) {
                                                    $line = trim($line);
                                                    if (empty($line)) continue;
                                                    
                                                    // Match format: "1. Nama Sekolah : Value" or "1. Nama Sekolah: Value"
                                                    if (preg_match('/^(\d+)\.\s*(.+?)\s*:\s*(.+)$/', $line, $matches)) {
                                                        $fieldNum = $matches[1];
                                                        // Skip field 2 (Mata Pelajaran) karena sudah di-set dari $mataPelajaran
                                                        if ($fieldNum != '2') {
                                                            $identitasData[$fieldNum] = trim($matches[3]);
                                                        }
                                                    } 
                                                    // Match format: "Nama Sekolah : Value" (without number)
                                                    elseif (preg_match('/^(.+?)\s*:\s*(.+)$/', $line, $matches)) {
                                                        $key = strtolower(trim($matches[1]));
                                                        $value = trim($matches[2]);
                                                        
                                                        if (strpos($key, 'nama sekolah') !== false && empty($identitasData['1'])) {
                                                            $identitasData['1'] = $value;
                                                        } elseif (strpos($key, 'kelas') !== false && empty($identitasData['3'])) {
                                                            $identitasData['3'] = $value;
                                                        } elseif (strpos($key, 'alokasi waktu') !== false && empty($identitasData['4'])) {
                                                            $identitasData['4'] = $value;
                                                        } elseif (strpos($key, 'jumlah pertemuan') !== false && empty($identitasData['5'])) {
                                                            $identitasData['5'] = $value;
                                                        } elseif (strpos($key, 'tahun ajaran') !== false && empty($identitasData['6'])) {
                                                            $identitasData['6'] = $value;
                                                        }
                                                        // Skip mata pelajaran karena sudah di-set dari $mataPelajaran
                                                    }
                                                }
                                            }
                                        @endphp
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_sekolah" class="form-label fw-bold">1. Nama Sekolah</label>
                                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" 
                                                       value="{{ old('nama_sekolah', $identitasData['1'] ?? 'Mts Nurul Aiman') }}" 
                                                       placeholder="Masukkan nama sekolah">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="mata_pelajaran_identitas" class="form-label fw-bold">2. Mata Pelajaran</label>
                                                <input type="text" class="form-control" id="mata_pelajaran_identitas" name="mata_pelajaran_identitas" 
                                                       value="{{ $mataPelajaran }}" 
                                                       placeholder="Masukkan mata pelajaran" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                                                <small class="text-muted">Mata pelajaran otomatis sesuai dengan mata pelajaran yang Anda ajarkan</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kelas_identitas" class="form-label fw-bold">3. Kelas</label>
                                                <input type="text" class="form-control" id="kelas_identitas" name="kelas_identitas" 
                                                       value="{{ old('kelas_identitas', $identitasData['3'] ?? 'IX') }}" 
                                                       placeholder="Contoh: IX, VII, VIII">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="alokasi_waktu" class="form-label fw-bold">4. Alokasi Waktu</label>
                                                <input type="text" class="form-control" id="alokasi_waktu" name="alokasi_waktu" 
                                                       value="{{ old('alokasi_waktu', $identitasData['4'] ?? '12 x 40 menit per unit') }}" 
                                                       placeholder="Contoh: 12 x 40 menit per unit">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="jumlah_pertemuan" class="form-label fw-bold">5. Jumlah Pertemuan</label>
                                                <input type="text" class="form-control" id="jumlah_pertemuan" name="jumlah_pertemuan" 
                                                       value="{{ old('jumlah_pertemuan', $identitasData['5'] ?? '6 pertemuan per unit') }}" 
                                                       placeholder="Contoh: 6 pertemuan per unit">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="tahun_ajaran" class="form-label fw-bold">6. Tahun Ajaran</label>
                                                <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" 
                                                       value="{{ old('tahun_ajaran', $identitasData['6'] ?? '2025-2026') }}" 
                                                       placeholder="Contoh: 2025-2026">
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden field untuk menyimpan format gabungan -->
                                        <input type="hidden" id="identitas_sekolah_program" name="identitas_sekolah_program" value="">
                                    </div>

                                    <!-- B. KOMPETENSI INTI DAN CAPAIAN PEMBELAJARAN -->
                                    <div class="mb-4 pb-4 border-bottom">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-certificate"></i>
                                            </div>
                                            <h5 class="mb-0 text-success">B. KOMPETENSI INTI DAN CAPAIAN PEMBELAJARAN</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kompetensi_inti_capaian" class="form-label fw-bold">Kompetensi Inti dan Capaian Pembelajaran</label>
                                            <textarea class="form-control" id="kompetensi_inti_capaian" name="kompetensi_inti_capaian" rows="15" placeholder="Masukkan kompetensi inti dan capaian pembelajaran...">{{ old('kompetensi_inti_capaian', $materiPembelajaran->kompetensi_inti_capaian ?? '') }}</textarea>
                                            <small class="text-muted">Termasuk Profil Pelajar Pancasila dan Capaian Pembelajaran per Elemen</small>
                                        </div>
                                    </div>

                                    <!-- C. UNIT-UNIT PEMBELAJARAN -->
                                    <div class="mb-4 pb-4 border-bottom">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-book"></i>
                                            </div>
                                            <h5 class="mb-0 text-info">C. UNIT-UNIT PEMBELAJARAN</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="unit_pembelajaran" class="form-label fw-bold">Unit-Unit Pembelajaran</label>
                                            <textarea class="form-control" id="unit_pembelajaran" name="unit_pembelajaran" rows="20" placeholder="Masukkan unit-unit pembelajaran (BAB 1, BAB 2, dst)...">{{ old('unit_pembelajaran', $materiPembelajaran->unit_pembelajaran ?? '') }}</textarea>
                                            <small class="text-muted">Masukkan semua unit pembelajaran dengan topik sentral, tujuan pembelajaran, kompetensi yang dikembangkan, dan alokasi waktu</small>
                                        </div>
                                    </div>

                                    <!-- D. PENDEKATAN PEMBELAJARAN HUMANIS -->
                                    <div class="mb-4 pb-4 border-bottom">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <h5 class="mb-0 text-warning">D. PENDEKATAN PEMBELAJARAN HUMANIS</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pendekatan_pembelajaran" class="form-label fw-bold">Pendekatan Pembelajaran Humanis</label>
                                            <textarea class="form-control" id="pendekatan_pembelajaran" name="pendekatan_pembelajaran" rows="15" placeholder="Masukkan pendekatan pembelajaran humanis...">{{ old('pendekatan_pembelajaran', $materiPembelajaran->pendekatan_pembelajaran ?? '') }}</textarea>
                                            <small class="text-muted">Prinsip-prinsip pembelajaran di Sekolah Manusia</small>
                                        </div>
                                    </div>

                                    <!-- E. MODEL-MODEL PEMBELAJARAN YANG DIGUNAKAN -->
                                    <div class="mb-4 pb-4 border-bottom">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            </div>
                                            <h5 class="mb-0 text-danger">E. MODEL-MODEL PEMBELAJARAN YANG DIGUNAKAN</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="model_pembelajaran" class="form-label fw-bold">Model-Model Pembelajaran</label>
                                            <textarea class="form-control" id="model_pembelajaran" name="model_pembelajaran" rows="8" placeholder="Masukkan model-model pembelajaran...">{{ old('model_pembelajaran', $materiPembelajaran->model_pembelajaran ?? '') }}</textarea>
                                            <small class="text-muted">Contoh: Discovery Learning, Inquiry Learning, Cooperative Learning, dll</small>
                                        </div>
                                    </div>

                                    <!-- F. KEGIATAN PEMBELAJARAN: STRUKTUR UMUM SETIAP PERTEMUAN -->
                                    <div class="mb-4 pb-4 border-bottom">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <h5 class="mb-0 text-secondary">F. KEGIATAN PEMBELAJARAN: STRUKTUR UMUM SETIAP PERTEMUAN</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kegiatan_pembelajaran" class="form-label fw-bold">Kegiatan Pembelajaran</label>
                                            <textarea class="form-control" id="kegiatan_pembelajaran" name="kegiatan_pembelajaran" rows="20" placeholder="Masukkan struktur kegiatan pembelajaran...">{{ old('kegiatan_pembelajaran', $materiPembelajaran->kegiatan_pembelajaran ?? '') }}</textarea>
                                            <small class="text-muted">Termasuk Kegiatan Pendahuluan, Kegiatan Inti, dan Kegiatan Penutup</small>
                                        </div>
                                    </div>

                                    <!-- G. PENILAIAN (ASSESSMENT) -->
                                    <div class="mb-4 pb-4 border-bottom">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-clipboard-check"></i>
                                            </div>
                                            <h5 class="mb-0 text-dark">G. PENILAIAN (ASSESSMENT)</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="penilaian" class="form-label fw-bold">Penilaian</label>
                                            <textarea class="form-control" id="penilaian" name="penilaian" rows="12" placeholder="Masukkan jenis-jenis penilaian dan instrumen penilaian...">{{ old('penilaian', $materiPembelajaran->penilaian ?? '') }}</textarea>
                                            <small class="text-muted">Jenis-jenis penilaian dan instrumen penilaian yang digunakan</small>
                                        </div>
                                    </div>

                                    <!-- H. SARANA DAN PRASARANA -->
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-tools"></i>
                                            </div>
                                            <h5 class="mb-0 text-primary">H. SARANA DAN PRASARANA</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sarana_prasarana" class="form-label fw-bold">Sarana dan Prasarana</label>
                                            <textarea class="form-control" id="sarana_prasarana" name="sarana_prasarana" rows="8" placeholder="Masukkan sarana dan prasarana yang digunakan...">{{ old('sarana_prasarana', $materiPembelajaran->sarana_prasarana ?? '') }}</textarea>
                                            <small class="text-muted">Daftar sarana dan prasarana yang diperlukan untuk pembelajaran</small>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                        <a href="{{ route('guru.dashboard', ['mata_pelajaran' => $mataPelajaran]) }}" class="btn btn-secondary">
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
            const selectors = ['html', 'body', '.container-fluid', '.row', '.col-md-9', '.col-lg-10', '.p-4', '.col-md-12'];
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
        
        // Function to combine identitas fields into structured format
        function combineIdentitasFields() {
            const namaSekolah = document.getElementById('nama_sekolah').value.trim();
            const mataPelajaran = document.getElementById('mata_pelajaran_identitas').value.trim();
            const kelas = document.getElementById('kelas_identitas').value.trim();
            const alokasiWaktu = document.getElementById('alokasi_waktu').value.trim();
            const jumlahPertemuan = document.getElementById('jumlah_pertemuan').value.trim();
            const tahunAjaran = document.getElementById('tahun_ajaran').value.trim();
            
            // Build formatted string
            let formatted = '';
            if (namaSekolah) formatted += '1. Nama Sekolah : ' + namaSekolah + '\n';
            if (mataPelajaran) formatted += '2. Mata Pelajaran : ' + mataPelajaran + '\n';
            if (kelas) formatted += '3. Kelas : ' + kelas + '\n';
            if (alokasiWaktu) formatted += '4. Alokasi Waktu : ' + alokasiWaktu + '\n';
            if (jumlahPertemuan) formatted += '5. Jumlah Pertemuan : ' + jumlahPertemuan + '\n';
            if (tahunAjaran) formatted += '6. Tahun Ajaran : ' + tahunAjaran;
            
            document.getElementById('identitas_sekolah_program').value = formatted;
        }
        
        // Add event listener to form submit
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action*="materi-pembelajaran"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    combineIdentitasFields();
                });
            }
            
            // Also combine on input change for real-time preview (optional)
            const identitasFields = ['nama_sekolah', 'mata_pelajaran_identitas', 'kelas_identitas', 'alokasi_waktu', 'jumlah_pertemuan', 'tahun_ajaran'];
            identitasFields.forEach(function(fieldId) {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('blur', combineIdentitasFields);
                }
            });
        });
        
        forceWhiteBackground();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', forceWhiteBackground);
        }
        window.addEventListener('load', forceWhiteBackground);
        setInterval(forceWhiteBackground, 100);
    </script>
</body>
</html>
