@extends('layouts.tu')

@section('title', 'Arsip - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Arsip Dokumen</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.arsip.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-upload"></i> Upload Dokumen
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
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

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-select">
                                        <option value="">Semua Kategori</option>
                                        <option value="akademik">Akademik</option>
                                        <option value="administrasi">Administrasi</option>
                                        <option value="keuangan">Keuangan</option>
                                        <option value="sdm">SDM</option>
                                        <option value="fasilitas">Fasilitas</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Prioritas</label>
                                    <select class="form-select">
                                        <option value="">Semua Prioritas</option>
                                        <option value="rendah">Rendah</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="tinggi">Tinggi</option>
                                        <option value="sangat_tinggi">Sangat Tinggi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cari Dokumen</label>
                                    <input type="text" class="form-control" placeholder="Judul atau deskripsi dokumen">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button class="btn btn-primary d-block w-100">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Arsip Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-archive"></i> Daftar Arsip Dokumen
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Dokumen</th>
                                            <th>Kategori</th>
                                            <th>File</th>
                                            <th>Ukuran</th>
                                            <th>Prioritas</th>
                                            <th>Tanggal Upload</th>
                                            <th>Pembuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Sample Data -->
                                        <tr>
                                            <td>1</td>
                                            <td>Surat Keputusan No. 001/2024</td>
                                            <td><span class="badge bg-primary">Keputusan</span></td>
                                            <td><i class="fas fa-file-pdf text-danger"></i> sk_001_2024.pdf</td>
                                            <td>1.2 MB</td>
                                            <td><span class="badge bg-warning">Sedang</span></td>
                                            <td>25 Okt 2024</td>
                                            <td>Tenaga Usaha</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-download"></i> Download
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Surat Keputusan Kepala Sekolah</td>
                                            <td><span class="badge bg-info">Keputusan</span></td>
                                            <td><i class="fas fa-file-word text-primary"></i> sk_kepsek_2024.docx</td>
                                            <td>1.2 MB</td>
                                            <td><span class="badge bg-danger">Tinggi</span></td>
                                            <td>20 Okt 2024</td>
                                            <td>Tenaga Usaha</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-download"></i> Download
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Data Siswa Kelas 7A</td>
                                            <td><span class="badge bg-success">Akademik</span></td>
                                            <td><i class="fas fa-file-excel text-success"></i> data_siswa_7a.xlsx</td>
                                            <td>850 KB</td>
                                            <td><span class="badge bg-success">Rendah</span></td>
                                            <td>18 Okt 2024</td>
                                            <td>Tenaga Usaha</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-download"></i> Download
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Presentasi Rapat Koordinasi</td>
                                            <td><span class="badge bg-warning">Administrasi</span></td>
                                            <td><i class="fas fa-file-powerpoint text-warning"></i> rapat_koordinasi.pptx</td>
                                            <td>5.8 MB</td>
                                            <td><span class="badge bg-warning">Sedang</span></td>
                                            <td>15 Okt 2024</td>
                                            <td>Tenaga Usaha</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-download"></i> Download
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
