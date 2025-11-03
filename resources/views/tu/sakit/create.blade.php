@extends('layouts.tu')

@section('title', 'Tambah Data Sakit - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <div class="profile-circle">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h6 class="text-white mt-2 mb-1">Tenaga Usaha</h6>
                    <small class="text-white-50">Administrasi</small>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.guru.index') }}">
                            <i class="fas fa-chalkboard-teacher"></i> Data Guru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.siswa.index') }}">
                            <i class="fas fa-users"></i> Data Siswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tu.presensi.index') }}">
                            <i class="fas fa-calendar-check"></i> Presensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.jadwal.index') }}">
                            <i class="fas fa-calendar"></i> Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.kalender.index') }}">
                            <i class="fas fa-calendar-alt"></i> Kalender
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.arsip.index') }}">
                            <i class="fas fa-archive"></i> Arsip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.surat.index') }}">
                            <i class="fas fa-envelope"></i> Surat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.laporan.index') }}">
                            <i class="fas fa-chart-bar"></i> Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.pengumuman.index') }}">
                            <i class="fas fa-bullhorn"></i> Pengumuman
                        </a>
                    </li>
                </ul>
                
                <div class="mt-auto">
                    <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm w-100">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Data Sakit</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.sakit.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Data Sakit Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-injured"></i> Form Data Sakit Guru
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.sakit.store') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="guru_id" class="form-label">Nama Guru <span class="text-danger">*</span></label>
                                            <select class="form-select" id="guru_id" name="guru_id" required>
                                                <option value="">Pilih Guru</option>
                                                <option value="1">Dr. Ahmad Suryadi, M.Pd</option>
                                                <option value="2">Siti Nurhaliza, S.Pd</option>
                                                <option value="3">Budi Santoso, M.Pd</option>
                                                <option value="4">Rina Wulandari, S.Pd</option>
                                                <option value="5">Joko Susilo, M.Pd</option>
                                                <option value="6">Dewi Kartika, S.Pd</option>
                                                <option value="7">Ahmad Fauzi, M.Pd</option>
                                                <option value="8">Sari Indah, S.Pd</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nip" class="form-label">NIP Guru</label>
                                            <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP akan terisi otomatis" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai Sakit <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai Sakit</label>
                                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="diagnosa" class="form-label">Diagnosa Penyakit <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="diagnosa" name="diagnosa" placeholder="Contoh: Demam tinggi, Flu, Migrain" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tingkat_keparahan" class="form-label">Tingkat Keparahan</label>
                                            <select class="form-select" id="tingkat_keparahan" name="tingkat_keparahan">
                                                <option value="ringan">Ringan</option>
                                                <option value="sedang" selected>Sedang</option>
                                                <option value="berat">Berat</option>
                                                <option value="kritis">Kritis</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dokter" class="form-label">Nama Dokter</label>
                                            <input type="text" class="form-control" id="dokter" name="dokter" placeholder="Nama dokter yang memeriksa">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="rumah_sakit" class="form-label">Rumah Sakit/Klinik</label>
                                            <input type="text" class="form-control" id="rumah_sakit" name="rumah_sakit" placeholder="Nama rumah sakit atau klinik">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan detail tentang kondisi sakit"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="surat_sakit" class="form-label">Surat Keterangan Sakit</label>
                                            <input type="file" class="form-control" id="surat_sakit" name="surat_sakit" accept=".pdf,.jpg,.jpeg,.png">
                                            <div class="form-text">Format: PDF, JPG, PNG (Max: 5MB)</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="menunggu" selected>Menunggu Persetujuan</option>
                                                <option value="disetujui">Disetujui</option>
                                                <option value="ditolak">Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_rawat_inap" name="is_rawat_inap">
                                                <label class="form-check-label" for="is_rawat_inap">
                                                    Rawat Inap
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_operasi" name="is_operasi">
                                                <label class="form-check-label" for="is_operasi">
                                                    Menjalani Operasi
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_urgent" name="is_urgent">
                                                <label class="form-check-label" for="is_urgent">
                                                    Kasus Darurat
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_komunikasi" name="is_komunikasi">
                                                <label class="form-check-label" for="is_komunikasi">
                                                    Dapat Dihubungi
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('tu.sakit.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-user-injured"></i> Tambah Data Sakit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Guidelines -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Panduan Data Sakit
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6>Tingkat Keparahan:</h6>
                            <ul class="list-unstyled small">
                                <li><i class="fas fa-circle text-success"></i> <strong>Ringan:</strong> Sakit ringan, bisa bekerja</li>
                                <li><i class="fas fa-circle text-warning"></i> <strong>Sedang:</strong> Sakit sedang, perlu istirahat</li>
                                <li><i class="fas fa-circle text-danger"></i> <strong>Berat:</strong> Sakit berat, perlu perawatan</li>
                                <li><i class="fas fa-circle text-dark"></i> <strong>Kritis:</strong> Sakit kritis, rawat inap</li>
                            </ul>
                            
                            <h6 class="mt-3">Status Data:</h6>
                            <ul class="small text-muted">
                                <li><span class="badge bg-warning">Menunggu</span> - Belum diproses</li>
                                <li><span class="badge bg-success">Disetujui</span> - Sudah disetujui</li>
                                <li><span class="badge bg-danger">Ditolak</span> - Ditolak</li>
                            </ul>
                            
                            <h6 class="mt-3">Tips Pengisian:</h6>
                            <ul class="small text-muted">
                                <li>Isi diagnosa dengan jelas</li>
                                <li>Lampirkan surat keterangan sakit</li>
                                <li>Berikan keterangan detail</li>
                                <li>Update status sesuai kondisi</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Data Preview -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-eye"></i> Preview Data
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="data-preview" class="p-3 border rounded bg-light">
                                <div class="text-center text-muted">
                                    <i class="fas fa-user-injured fa-2x mb-2"></i>
                                    <p class="mb-0">Preview data sakit akan muncul setelah Anda mengisi form</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history"></i> Data Sakit Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Daftar data sakit terbaru akan muncul di sini.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default tanggal mulai to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_mulai').value = today;
    
    // Auto-set tanggal selesai based on tanggal mulai
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    
    tanggalMulai.addEventListener('change', function() {
        if (this.value) {
            // Add 3 days to tanggal mulai as default
            const startDate = new Date(this.value);
            startDate.setDate(startDate.getDate() + 3);
            const endDateString = startDate.toISOString().split('T')[0];
            tanggalSelesai.value = endDateString;
            updatePreview();
        }
    });
    
    // Update preview when form changes
    function updatePreview() {
        const guruSelect = document.getElementById('guru_id');
        const guru = guruSelect.options[guruSelect.selectedIndex].text;
        const tanggalMulai = document.getElementById('tanggal_mulai').value;
        const tanggalSelesai = document.getElementById('tanggal_selesai').value;
        const diagnosa = document.getElementById('diagnosa').value;
        const tingkatKeparahan = document.getElementById('tingkat_keparahan').value;
        
        if (guru && tanggalMulai && diagnosa) {
            const preview = document.getElementById('data-preview');
            const durasi = tanggalSelesai ? 
                Math.ceil((new Date(tanggalSelesai) - new Date(tanggalMulai)) / (1000 * 60 * 60 * 24)) + 1 : 
                'Belum ditentukan';
            
            preview.innerHTML = `
                <div class="text-center">
                    <h6 class="mb-2">${guru}</h6>
                    <p class="mb-1"><strong>Tanggal:</strong> ${tanggalMulai} ${tanggalSelesai ? 's/d ' + tanggalSelesai : ''}</p>
                    <p class="mb-1"><strong>Durasi:</strong> ${durasi} hari</p>
                    <p class="mb-1"><strong>Diagnosa:</strong> ${diagnosa}</p>
                    <p class="mb-0"><strong>Keparahan:</strong> <span class="badge bg-${getKeparahanColor(tingkatKeparahan)}">${tingkatKeparahan}</span></p>
                </div>
            `;
        }
    }
    
    function getKeparahanColor(tingkat) {
        switch(tingkat) {
            case 'ringan': return 'success';
            case 'sedang': return 'warning';
            case 'berat': return 'danger';
            case 'kritis': return 'dark';
            default: return 'secondary';
        }
    }
    
    // Add event listeners for preview updates
    ['guru_id', 'tanggal_mulai', 'tanggal_selesai', 'diagnosa', 'tingkat_keparahan'].forEach(id => {
        document.getElementById(id).addEventListener('change', updatePreview);
    });
    
    // Auto-fill NIP based on guru selection
    const guruSelect = document.getElementById('guru_id');
    const nipInput = document.getElementById('nip');
    
    const guruData = {
        '1': '196512151990031001',
        '2': '197003201995122001',
        '3': '196808151990031002',
        '4': '197205101995122002',
        '5': '196912201990031003',
        '6': '197103151995122003',
        '7': '196704101990031004',
        '8': '197409251995122004'
    };
    
    guruSelect.addEventListener('change', function() {
        if (this.value && guruData[this.value]) {
            nipInput.value = guruData[this.value];
        } else {
            nipInput.value = '';
        }
        updatePreview();
    });
});
</script>
@endsection
