@extends('layouts.tu')

@section('title', 'Tambah Siswa - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-user-plus me-2"></i>
                    Tambah Siswa Baru
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('tu.siswa.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-graduate me-2"></i>
                                Form Data Siswa
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tu.siswa.store') }}" method="POST">
                                @csrf
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nis" class="form-label">
                                            NIS <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nis" name="nis" 
                                               placeholder="Masukkan NIS" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nama" name="nama" 
                                               placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="kelas" class="form-label">
                                            Kelas <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="kelas" name="kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">
                                            Jenis Kelamin <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir" class="form-label">
                                            Tanggal Lahir <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="tanggal_lahir" 
                                               name="tanggal_lahir" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">
                                            Status <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="aktif" selected>Aktif</option>
                                            <option value="tidak_aktif">Tidak Aktif</option>
                                            <option value="lulus">Lulus</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" 
                                                  rows="3" placeholder="Masukkan alamat"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="no_telp" class="form-label">No. Telepon Orangtua</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp" 
                                               placeholder="Masukkan nomor telepon orangtua">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Masukkan email">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('tu.siswa.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">
                                <strong>Catatan:</strong>
                            </p>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Field dengan tanda <span class="text-danger">*</span> wajib diisi
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    NIS harus unik dan tidak boleh duplikat
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Pastikan data yang diinput sudah benar
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

