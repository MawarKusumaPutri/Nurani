@extends('layouts.tu')

@section('title', 'Tambah Guru - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-user-plus me-2"></i>
                    Tambah Guru Baru
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('tu.guru.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Section -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chalkboard-teacher me-2"></i>
                                Form Data Guru
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tu.guru.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nip" class="form-label">
                                            NIP <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nip" name="nip" 
                                               placeholder="Masukkan NIP" value="{{ old('nip') }}" required>
                                        @error('nip')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">
                                            Nama Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nama" name="nama" 
                                               placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                                        @error('nama')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Masukkan email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">
                                            Password <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Masukkan password" required>
                                        @error('password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Minimal 6 karakter</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="mata_pelajaran" class="form-label">
                                            Mata Pelajaran <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran" 
                                               placeholder="Contoh: Matematika, IPA" value="{{ old('mata_pelajaran') }}" required>
                                        <small class="text-muted">Pisahkan dengan koma jika lebih dari satu</small>
                                        @error('mata_pelajaran')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">
                                            Jenis Kelamin <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="no_telp" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp" 
                                               placeholder="Masukkan nomor telepon" value="{{ old('no_telp') }}">
                                        @error('no_telp')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">
                                            Status <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="foto" class="form-label">Foto Profil</label>
                                        <input type="file" class="form-control" id="foto" name="foto" 
                                               accept="image/jpeg,image/png,image/jpg">
                                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                        @error('foto')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('tu.guru.index') }}" class="btn btn-secondary">
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
                                    NIP harus unik dan tidak boleh duplikat
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Email akan digunakan untuk login
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Mata pelajaran bisa lebih dari satu, pisahkan dengan koma
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

