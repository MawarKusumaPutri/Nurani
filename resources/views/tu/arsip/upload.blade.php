@extends('layouts.tu')

@section('title', 'Upload Dokumen - TU Dashboard')

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
                        <a class="nav-link active" href="{{ route('tu.arsip.index') }}">
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
                <h1 class="h2">Upload Dokumen</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.arsip.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-upload"></i> Form Upload Dokumen
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.arsip.upload') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kategori" class="form-label">Kategori Dokumen <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kategori" name="kategori" required>
                                                <option value="">Pilih Kategori</option>
                                                <option value="akademik">Akademik</option>
                                                <option value="administrasi">Administrasi</option>
                                                <option value="keuangan">Keuangan</option>
                                                <option value="sdm">SDM</option>
                                                <option value="fasilitas">Fasilitas</option>
                                                <option value="keputusan">Keputusan</option>
                                                <option value="surat_masuk">Surat Masuk</option>
                                                <option value="surat_keluar">Surat Keluar</option>
                                                <option value="laporan">Laporan</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioritas" class="form-label">Prioritas</label>
                                            <select class="form-select" id="prioritas" name="prioritas">
                                                <option value="rendah">Rendah</option>
                                                <option value="sedang" selected>Sedang</option>
                                                <option value="tinggi">Tinggi</option>
                                                <option value="sangat_tinggi">Sangat Tinggi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="judul_dokumen" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judul_dokumen" name="judul_dokumen" placeholder="Masukkan judul dokumen" required>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Dokumen</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan isi atau tujuan dokumen ini"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_dokumen" class="form-label">Tanggal Dokumen</label>
                                            <input type="date" class="form-control" id="tanggal_dokumen" name="tanggal_dokumen">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pembuat" class="form-label">Pembuat Dokumen</label>
                                            <input type="text" class="form-control" id="pembuat" name="pembuat" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="file_dokumen" class="form-label">File Dokumen <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.txt">
                                    <div class="form-text">
                                        Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG, TXT (Max: 50MB)
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_public" name="is_public">
                                                <label class="form-check-label" for="is_public">
                                                    Dokumen Publik (dapat diakses semua user)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_important" name="is_important">
                                                <label class="form-check-label" for="is_important">
                                                    Dokumen Penting
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('tu.arsip.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload"></i> Upload Dokumen
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Upload Guidelines -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Panduan Upload
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6>Format File yang Didukung:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-file-pdf text-danger"></i> PDF</li>
                                <li><i class="fas fa-file-word text-primary"></i> DOC, DOCX</li>
                                <li><i class="fas fa-file-excel text-success"></i> XLS, XLSX</li>
                                <li><i class="fas fa-file-powerpoint text-warning"></i> PPT, PPTX</li>
                                <li><i class="fas fa-file-image text-info"></i> JPG, PNG</li>
                                <li><i class="fas fa-file-alt text-secondary"></i> TXT</li>
                            </ul>
                            
                            <h6 class="mt-3">Ukuran Maksimal:</h6>
                            <p class="text-muted">50 MB per file</p>
                            
                            <h6 class="mt-3">Tips Upload:</h6>
                            <ul class="small text-muted">
                                <li>Pastikan file tidak rusak</li>
                                <li>Gunakan nama file yang jelas</li>
                                <li>Pilih kategori yang sesuai</li>
                                <li>Tambahkan deskripsi jika perlu</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Uploads -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history"></i> Upload Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Daftar upload terbaru akan muncul di sini.
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
    // Set default tanggal dokumen to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_dokumen').value = today;
    
    // File size validation
    const fileInput = document.getElementById('file_dokumen');
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const maxSize = 50 * 1024 * 1024; // 50MB in bytes
            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar! Maksimal 50MB.');
                this.value = '';
                return;
            }
            
            // Show file info
            const fileInfo = document.createElement('div');
            fileInfo.className = 'mt-2 text-muted small';
            fileInfo.innerHTML = `
                <i class="fas fa-file"></i> 
                ${file.name} 
                (${(file.size / 1024 / 1024).toFixed(2)} MB)
            `;
            
            // Remove previous file info
            const existingInfo = document.querySelector('.file-info');
            if (existingInfo) {
                existingInfo.remove();
            }
            
            fileInfo.className += ' file-info';
            this.parentNode.appendChild(fileInfo);
        }
    });
    
    // Auto-generate judul based on file name
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file && !document.getElementById('judul_dokumen').value) {
            const fileName = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
            document.getElementById('judul_dokumen').value = fileName;
        }
    });
});
</script>
@endsection
