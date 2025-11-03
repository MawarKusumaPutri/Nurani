@extends('layouts.tu')

@section('title', 'Buat Laporan - TU Dashboard')

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
                        <a class="nav-link" href="{{ route('tu.presensi.index') }}">
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
                        <a class="nav-link active" href="{{ route('tu.laporan.index') }}">
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
                <h1 class="h2">Buat Laporan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.laporan.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Laporan -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-alt"></i> Form Laporan
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.laporan.send') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jenis_laporan" class="form-label">Jenis Laporan <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jenis_laporan" name="jenis_laporan" required>
                                                <option value="">Pilih Jenis Laporan</option>
                                                <option value="bulanan">Laporan Bulanan</option>
                                                <option value="semester">Laporan Semester</option>
                                                <option value="tahunan">Laporan Tahunan</option>
                                                <option value="khusus">Laporan Khusus</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="periode" class="form-label">Periode <span class="text-danger">*</span></label>
                                            <input type="month" class="form-control" id="periode" name="periode" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="judul_laporan" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="judul_laporan" name="judul_laporan" placeholder="Masukkan judul laporan" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioritas" class="form-label">Prioritas</label>
                                            <select class="form-select" id="prioritas" name="prioritas">
                                                <option value="rendah">Rendah</option>
                                                <option value="sedang" selected>Sedang</option>
                                                <option value="tinggi">Tinggi</option>
                                                <option value="urgent">Urgent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Laporan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan isi laporan secara detail" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kategori" class="form-label">Kategori</label>
                                            <select class="form-select" id="kategori" name="kategori">
                                                <option value="">Pilih Kategori</option>
                                                <option value="akademik">Akademik</option>
                                                <option value="administrasi">Administrasi</option>
                                                <option value="keuangan">Keuangan</option>
                                                <option value="sdm">SDM</option>
                                                <option value="fasilitas">Fasilitas</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="penerima" class="form-label">Dikirim ke <span class="text-danger">*</span></label>
                                            <select class="form-select" id="penerima" name="penerima" required>
                                                <option value="">Pilih Penerima</option>
                                                <option value="kepala_sekolah">Kepala Sekolah</option>
                                                <option value="yayasan">Yayasan</option>
                                                <option value="dinas_pendidikan">Dinas Pendidikan</option>
                                                <option value="internal">Internal Sekolah</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
                                    <input type="file" class="form-control" id="lampiran" name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                    <div class="form-text">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Max: 10MB)</div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cc_email" name="cc_email">
                                        <label class="form-check-label" for="cc_email">
                                            Kirim salinan ke email saya
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('tu.laporan.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Kirim Laporan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Laporan -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-eye"></i> Preview Laporan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Preview akan muncul setelah Anda mengisi form di atas.</strong>
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
    // Auto-generate judul laporan based on jenis and periode
    const jenisLaporan = document.getElementById('jenis_laporan');
    const periode = document.getElementById('periode');
    const judulLaporan = document.getElementById('judul_laporan');
    
    function updateJudul() {
        if (jenisLaporan.value && periode.value) {
            const jenis = jenisLaporan.options[jenisLaporan.selectedIndex].text;
            const bulan = new Date(periode.value + '-01').toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'long' 
            });
            judulLaporan.value = `${jenis} MTs Nurul Aiman - ${bulan}`;
        }
    }
    
    jenisLaporan.addEventListener('change', updateJudul);
    periode.addEventListener('change', updateJudul);
    
    // Set default periode to current month
    const now = new Date();
    const currentMonth = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0');
    periode.value = currentMonth;
});
</script>
@endsection
