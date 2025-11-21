@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Guru - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
        }
        .presensi-type-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .presensi-type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .presensi-type-card.active {
            border-color: #2E7D32;
            background: #F0F4F0;
        }
        .badge-hadir { background: #28a745; }
        .badge-sakit { background: #dc3545; }
        .badge-izin { background: #ffc107; color: #000; }
        .badge-pending { background: #6c757d; }
        .badge-approved { background: #28a745; }
        .badge-rejected { background: #dc3545; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Dashboard Guru
                    </h4>
                    <div class="text-center mb-4">
                        @if($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="Foto Profil" 
                                 class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        @else
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        @endif
                        <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
                        <small class="text-white-50">{{ $guru->mata_pelajaran ?? 'Mata Pelajaran' }}</small>
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                        <a class="nav-link" href="{{ route('guru.dashboard') }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                        <a class="nav-link active" href="{{ route('guru.presensi.index') }}">
                            <i class="fas fa-calendar-check me-2"></i> Presensi Guru
                        </a>
                        <a class="nav-link" href="{{ route('guru.presensi-siswa.index') }}">
                            <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
                        </a>
                        <a class="nav-link" href="{{ route('guru.materi.index') }}">
                            <i class="fas fa-book me-2"></i> Materi
                        </a>
                        <a class="nav-link" href="{{ route('guru.kuis.index') }}">
                            <i class="fas fa-question-circle me-2"></i> Kuis
                        </a>
                        <hr class="text-white">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-start w-100 border-0 bg-transparent">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <h2 class="mb-4">
                    <i class="fas fa-calendar-check text-success me-2"></i>
                    Presensi Guru
                </h2>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Button Tambah Presensi -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-0">Manajemen Presensi</h4>
                        <p class="text-muted mb-0">Kelola presensi Anda untuk berbagai tanggal</p>
                    </div>
                    <button type="button" class="btn btn-success" onclick="togglePresensiForm()" id="btnTambahPresensi">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Presensi
                    </button>
                </div>

                <!-- Presensi Form -->
                <div class="card mb-4" id="presensiFormCard" style="display: none;">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Presensi Baru
                                <small class="d-block mt-1" style="font-size: 0.85rem; opacity: 0.9;">
                                    <i class="fas fa-info-circle me-1"></i>Anda dapat melakukan presensi untuk berbagai tanggal dengan jenis berbeda (Hadir, Sakit, atau Izin)
                                </small>
                            </h5>
                        </div>
                        <button type="button" class="btn btn-light btn-sm" onclick="togglePresensiForm()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('guru.presensi.store') }}" method="POST" id="presensiForm">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" class="form-control" 
                                           value="{{ date('Y-m-d') }}" 
                                           max="{{ date('Y-m-d') }}" 
                                           id="tanggalPresensi"
                                           required>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>Pilih tanggal presensi. Setiap tanggal hanya bisa diisi sekali.
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Presensi <span class="text-danger">*</span></label>
                                <small class="text-muted d-block mb-2">
                                    <i class="fas fa-info-circle me-1"></i>Pilih jenis presensi sesuai kondisi hari ini. Setiap hari bisa berbeda jenisnya.
                                </small>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card presensi-type-card mb-2" onclick="selectPresensiType('hadir')" id="card-hadir">
                                            <div class="card-body text-center">
                                                <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                                                <h6>Hadir</h6>
                                                <input type="radio" name="jenis" value="hadir" id="jenis-hadir" class="d-none" checked>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card presensi-type-card mb-2" onclick="selectPresensiType('sakit')" id="card-sakit">
                                            <div class="card-body text-center">
                                                <i class="fas fa-user-injured fa-3x text-danger mb-2"></i>
                                                <h6>Sakit</h6>
                                                <input type="radio" name="jenis" value="sakit" id="jenis-sakit" class="d-none">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card presensi-type-card mb-2" onclick="selectPresensiType('izin')" id="card-izin">
                                            <div class="card-body text-center">
                                                <i class="fas fa-file-alt fa-3x text-warning mb-2"></i>
                                                <h6>Izin</h6>
                                                <input type="radio" name="jenis" value="izin" id="jenis-izin" class="d-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="jam-section" class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jam Masuk <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="time" name="jam_masuk" class="form-control" 
                                               id="jam_masuk" required>
                                        <button type="button" class="btn btn-outline-success" onclick="setCurrentTime('jam_masuk')" title="Gunakan waktu saat ini">
                                            <i class="fas fa-clock"></i> Sekarang
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        <span id="jamMasukInfo">Klik tombol "Sekarang" untuk mengisi otomatis dengan waktu saat ini</span>
                                        <span id="jamMasukSakitInfo" style="display: none;">Jam masuk akan otomatis terisi untuk menunjukkan waktu mulai sakit</span>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jam Keluar</label>
                                    <div class="input-group">
                                        <input type="time" name="jam_keluar" class="form-control" 
                                               id="jam_keluar">
                                        <button type="button" class="btn btn-outline-success" onclick="setCurrentTime('jam_keluar')" title="Gunakan waktu saat ini">
                                            <i class="fas fa-clock"></i> Sekarang
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> Klik tombol "Sekarang" untuk mengisi otomatis dengan waktu saat ini
                                    </small>
                                </div>
                            </div>

                            <div id="keterangan-section" class="mb-3" style="display: none;">
                                <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                                <textarea name="keterangan" class="form-control" rows="3" 
                                          placeholder="Masukkan alasan izin..." id="keterangan"></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Presensi
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="togglePresensiForm()">
                                    <i class="fas fa-times me-2"></i>Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Status Presensi Hari Ini -->
                @if($todayPresensi)
                <div class="alert alert-{{ $todayPresensi->status_verifikasi === 'pending' ? 'warning' : ($todayPresensi->status_verifikasi === 'approved' ? 'success' : 'danger') }}">
                    <i class="fas fa-{{ $todayPresensi->status_verifikasi === 'pending' ? 'clock' : ($todayPresensi->status_verifikasi === 'approved' ? 'check-circle' : 'times-circle') }} me-2"></i>
                    Anda sudah melakukan presensi untuk <strong>hari ini ({{ $todayPresensi->tanggal->format('d/m/Y') }})</strong> sebagai <strong>{{ ucfirst($todayPresensi->jenis) }}</strong>.
                    <br><strong>Status:</strong> 
                    @if($todayPresensi->status_verifikasi === 'pending')
                        <span class="badge badge-pending">Menunggu Verifikasi</span>
                        <small class="d-block mt-2 text-muted">
                            <i class="fas fa-info-circle me-1"></i>Status akan otomatis terbarui setelah TU melakukan verifikasi.
                        </small>
                    @elseif($todayPresensi->status_verifikasi === 'approved')
                        <span class="badge badge-approved">Disetujui</span>
                        @if($todayPresensi->verified_at)
                            <small class="d-block mt-2 text-muted">
                                Diverifikasi pada: {{ $todayPresensi->verified_at->format('d/m/Y H:i') }}
                            </small>
                        @endif
                    @else
                        <span class="badge badge-rejected">Ditolak</span>
                        @if($todayPresensi->verified_at)
                            <small class="d-block mt-2 text-muted">
                                Ditolak pada: {{ $todayPresensi->verified_at->format('d/m/Y H:i') }}
                            </small>
                        @endif
                    @endif
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Anda masih bisa menambah presensi untuk tanggal lain menggunakan tombol "Tambah Presensi" di atas.
                        </small>
                    </div>
                </div>
                @endif

                <!-- Presensi History -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Presensi (30 Hari Terakhir)
                            <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">
                                <i class="fas fa-info-circle me-1"></i>Lihat semua presensi Anda dengan berbagai jenis (Hadir, Sakit, Izin)
                            </small>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($presensiHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensiHistory as $p)
                                    <tr>
                                        <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                                        <td>
                                            @if($p->jenis === 'hadir')
                                                <span class="badge badge-hadir text-white">Hadir</span>
                                            @elseif($p->jenis === 'sakit')
                                                <span class="badge badge-sakit text-white">Sakit</span>
                                            @else
                                                <span class="badge badge-izin">Izin</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->jam_masuk)
                                                @if($p->jenis === 'sakit')
                                                    <span class="badge bg-danger text-white">{{ date('H:i', strtotime($p->jam_masuk)) }}</span>
                                                    <small class="text-muted d-block">Mulai sakit</small>
                                                @else
                                                    {{ date('H:i', strtotime($p->jam_masuk)) }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $p->jam_keluar ? date('H:i', strtotime($p->jam_keluar)) : '-' }}</td>
                                        <td>{{ $p->keterangan ?? '-' }}</td>
                                        <td>
                                            @if($p->status_verifikasi === 'pending')
                                                <span class="badge badge-pending text-white">Menunggu</span>
                                            @elseif($p->status_verifikasi === 'approved')
                                                <span class="badge badge-approved text-white">Disetujui</span>
                                            @else
                                                <span class="badge badge-rejected text-white">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center">Belum ada riwayat presensi</p>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectPresensiType(type) {
            // Remove active class from all cards
            document.querySelectorAll('.presensi-type-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Uncheck all radios
            document.querySelectorAll('input[name="jenis"]').forEach(radio => {
                radio.checked = false;
            });
            
            // Activate selected card and radio
            document.getElementById('card-' + type).classList.add('active');
            document.getElementById('jenis-' + type).checked = true;
            
            // Show/hide sections based on type
            const jamSection = document.getElementById('jam-section');
            const keteranganSection = document.getElementById('keterangan-section');
            const jamMasuk = document.getElementById('jam_masuk');
            const keterangan = document.getElementById('keterangan');
            
            if (type === 'hadir') {
                jamSection.style.display = 'block';
                keteranganSection.style.display = 'none';
                jamMasuk.required = true;
                keterangan.required = false;
                // Auto-fill jam masuk saat pilih hadir
                if (!jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
            } else if (type === 'izin') {
                jamSection.style.display = 'none';
                keteranganSection.style.display = 'block';
                jamMasuk.required = false;
                keterangan.required = true;
            } else { // sakit
                jamSection.style.display = 'block';
                keteranganSection.style.display = 'none';
                jamMasuk.required = true;
                keterangan.required = false;
                // Auto-fill jam masuk saat pilih sakit agar TU tahu kapan mulai sakit
                setCurrentTime('jam_masuk');
                // Update info text
                document.getElementById('jamMasukInfo').style.display = 'none';
                document.getElementById('jamMasukSakitInfo').style.display = 'inline';
            }
            
            // Reset info text for hadir
            if (type === 'hadir') {
                document.getElementById('jamMasukInfo').style.display = 'inline';
                document.getElementById('jamMasukSakitInfo').style.display = 'none';
            }
        }

        // Function to get current time in HH:mm format
        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return hours + ':' + minutes;
        }

        // Function to set current time to input field
        function setCurrentTime(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                const currentTime = getCurrentTime();
                field.value = currentTime;
                
                // Visual feedback (green flash)
                field.style.backgroundColor = '#d4edda';
                field.style.transition = 'background-color 0.3s ease';
                setTimeout(() => {
                    field.style.backgroundColor = '';
                }, 500);
                
                // Show notification
                const notification = document.createElement('div');
                notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.zIndex = '9999';
                notification.style.minWidth = '250px';
                notification.innerHTML = '<i class="fas fa-check-circle me-2"></i>Waktu otomatis terisi: <strong>' + currentTime + '</strong><button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                document.body.appendChild(notification);
                
                // Auto dismiss notification after 3 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 3000);
            }
        }

        // Function to toggle presensi form
        function togglePresensiForm() {
            const formCard = document.getElementById('presensiFormCard');
            const btnTambah = document.getElementById('btnTambahPresensi');
            
            if (formCard.style.display === 'none' || formCard.style.display === '') {
                formCard.style.display = 'block';
                btnTambah.innerHTML = '<i class="fas fa-times me-2"></i>Tutup Form';
                btnTambah.classList.remove('btn-success');
                btnTambah.classList.add('btn-secondary');
                
                // Reset form
                document.getElementById('presensiForm').reset();
                
                // Set tanggal default to today
                document.getElementById('tanggalPresensi').value = '{{ date('Y-m-d') }}';
                
                // Set default jenis to hadir and auto-fill jam
                selectPresensiType('hadir');
                
                // Scroll to form
                formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                formCard.style.display = 'none';
                btnTambah.innerHTML = '<i class="fas fa-plus-circle me-2"></i>Tambah Presensi';
                btnTambah.classList.remove('btn-secondary');
                btnTambah.classList.add('btn-success');
            }
        }

        // Initialize - set hadir as default active and auto-fill jam masuk
        document.addEventListener('DOMContentLoaded', function() {
            // Set hadir as default active (will auto-fill jam masuk)
            const jamMasuk = document.getElementById('jam_masuk');
            if (jamMasuk) {
                // Only auto-fill if form is visible
                const formCard = document.getElementById('presensiFormCard');
                if (formCard && (formCard.style.display === 'block' || !formCard.style.display)) {
                    setCurrentTime('jam_masuk');
                }
            }
            
            // Set hadir as default active
            selectPresensiType('hadir');
        });

        // Auto-refresh status every 10 seconds if there's pending presensi
        @if($todayPresensi && $todayPresensi->status_verifikasi === 'pending')
        setInterval(function() {
            // Check if status has changed
            fetch('{{ route("guru.presensi.index") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Only reload if still on presensi page
                if (window.location.pathname.includes('/presensi')) {
                    location.reload();
                }
            })
            .catch(err => console.log('Auto-refresh error:', err));
        }, 10000); // Check every 10 seconds
        @endif
    </script>
</body>
</html>

