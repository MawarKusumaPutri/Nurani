@extends('layouts.tu')

@section('title', 'Edit Dokumen - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Dokumen</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.arsip.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Upload Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit"></i> Form Edit Dokumen
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.arsip.update', $arsip->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kategori" class="form-label">Kategori Dokumen <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kategori" name="kategori" required>
                                                <option value="">Pilih Kategori</option>
                                                <option value="akademik" {{ old('kategori', $arsip->kategori) == 'akademik' ? 'selected' : '' }}>Akademik</option>
                                                <option value="administrasi" {{ old('kategori', $arsip->kategori) == 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                                                <option value="keuangan" {{ old('kategori', $arsip->kategori) == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                                                <option value="sdm" {{ old('kategori', $arsip->kategori) == 'sdm' ? 'selected' : '' }}>SDM</option>
                                                <option value="fasilitas" {{ old('kategori', $arsip->kategori) == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                                                <option value="keputusan" {{ old('kategori', $arsip->kategori) == 'keputusan' ? 'selected' : '' }}>Keputusan</option>
                                                <option value="surat_masuk" {{ old('kategori', $arsip->kategori) == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                                <option value="surat_keluar" {{ old('kategori', $arsip->kategori) == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                                                <option value="lainnya" {{ old('kategori', $arsip->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioritas" class="form-label">Prioritas</label>
                                            <select class="form-select" id="prioritas" name="prioritas">
                                                <option value="rendah" {{ old('prioritas', $arsip->prioritas) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                                <option value="sedang" {{ old('prioritas', $arsip->prioritas) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                                <option value="tinggi" {{ old('prioritas', $arsip->prioritas) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                                <option value="sangat_tinggi" {{ old('prioritas', $arsip->prioritas) == 'sangat_tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="judul_dokumen" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judul_dokumen" name="judul_dokumen" placeholder="Masukkan judul dokumen" value="{{ old('judul_dokumen', $arsip->judul_dokumen) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Dokumen</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan isi atau tujuan dokumen ini">{{ old('deskripsi', $arsip->deskripsi) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_dokumen" class="form-label">Tanggal Dokumen</label>
                                            <input type="date" class="form-control" id="tanggal_dokumen" name="tanggal_dokumen" value="{{ old('tanggal_dokumen', $arsip->tanggal_dokumen ? $arsip->tanggal_dokumen->format('Y-m-d') : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pembuat" class="form-label">Pembuat Dokumen</label>
                                            <input type="text" class="form-control" id="pembuat" name="pembuat" value="{{ old('pembuat', $arsip->pembuat) }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="file_dokumen" class="form-label">File Dokumen</label>
                                    @if($arsip->file_dokumen)
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-file"></i> File saat ini: 
                                                <a href="{{ asset('storage/arsip/' . $arsip->file_dokumen) }}" target="_blank">
                                                    {{ $arsip->file_dokumen }}
                                                </a>
                                                @if($arsip->ukuran_file)
                                                    ({{ number_format($arsip->ukuran_file / 1024 / 1024, 2) }} MB)
                                                @endif
                                            </small>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.txt">
                                    <div class="form-text">
                                        Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG, TXT (Max: 50MB)
                                        @if($arsip->file_dokumen)
                                            <br><small class="text-info">Kosongkan jika tidak ingin mengganti file.</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="hidden" name="is_public" value="0">
                                                <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" {{ old('is_public', $arsip->is_public) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_public">
                                                    Dokumen Publik (dapat diakses semua user)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="hidden" name="is_important" value="0">
                                                <input class="form-check-input" type="checkbox" id="is_important" name="is_important" value="1" {{ old('is_important', $arsip->is_important) ? 'checked' : '' }}>
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
                                        <i class="fas fa-save"></i> Simpan
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
    // Tidak perlu set default tanggal untuk edit, gunakan nilai yang sudah ada
    
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
});
</script>
@endsection
