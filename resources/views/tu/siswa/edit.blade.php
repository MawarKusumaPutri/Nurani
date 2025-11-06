@extends('layouts.tu')

@section('title', 'Edit Siswa - TU Dashboard')

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
                        <a class="nav-link active" href="{{ route('tu.siswa.index') }}">
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
                        <a class="nav-link" href="{{ route('tu.pengumuman.index') }}">
                            <i class="fas fa-bullhorn"></i> Pengumuman
                        </a>
                    </li>
                </ul>
                
                <div class="mt-auto">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-user-edit me-2"></i>
                    Edit Data Siswa
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
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-graduate me-2"></i>
                                Form Edit Data Siswa
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="/tu/siswa/{{ $siswa->id }}" method="POST" id="editSiswaForm">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nis" class="form-label">
                                            NIS <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nis" name="nis" 
                                               placeholder="Masukkan NIS" value="{{ old('nis', $siswa->nis) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nama" name="nama" 
                                               placeholder="Masukkan nama lengkap" value="{{ old('nama', $siswa->nama) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="kelas" class="form-label">
                                            Kelas <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="kelas" name="kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            <option value="7" {{ old('kelas', $siswa->kelas) == '7' ? 'selected' : '' }}>7</option>
                                            <option value="8" {{ old('kelas', $siswa->kelas) == '8' ? 'selected' : '' }}>8</option>
                                            <option value="9" {{ old('kelas', $siswa->kelas) == '9' ? 'selected' : '' }}>9</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">
                                            Jenis Kelamin <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tanggal_lahir" class="form-label">
                                            Tanggal Lahir <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="tanggal_lahir" 
                                               name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">
                                            Status <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="tidak_aktif" {{ old('status', $siswa->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" 
                                                  rows="3" placeholder="Masukkan alamat">{{ old('alamat', $siswa->alamat) }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="no_telp" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp" 
                                               placeholder="Masukkan nomor telepon" value="{{ old('no_telp', $siswa->no_telp) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Masukkan email" value="{{ old('email', $siswa->email) }}">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('tu.siswa.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-2"></i> Update
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
                                    Pastikan data yang diubah sudah benar
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Klik "Update" untuk menyimpan perubahan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editSiswaForm');
    if (form) {
        // Force correct action URL
        const id = {{ $siswa->id }};
        const correctAction = '/tu/siswa/' + id;
        form.setAttribute('action', correctAction);
        
        form.addEventListener('submit', function(e) {
            // Double check action is correct before submit
            if (form.action !== correctAction) {
                form.action = correctAction;
            }
            console.log('Submitting to:', form.action);
            console.log('Method:', form.method);
        });
    }
});
</script>
@endsection

