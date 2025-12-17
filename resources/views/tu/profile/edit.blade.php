@extends('layouts.tu')

@section('title', 'Edit Profil - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Profil</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('tu.profile.index') }}" class="btn btn-sm btn-secondary">
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
            
            @if($errors->has('photo'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-image me-2"></i>
                    <strong>Peringatan Upload Foto:</strong> {{ $errors->first('photo') }}
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

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit"></i> Form Edit Profil
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto Profil</label>
                                    <div class="mb-2">
                                        @php
                                            $freshUser = \App\Models\User::find($user->id);
                                            $photoUrl = $freshUser->photo ? \App\Helpers\PhotoHelper::getPhotoUrl($freshUser->photo, 'image/profiles') : '#';
                                            $hasPhoto = $photoUrl !== null && $photoUrl !== '#';
                                        @endphp
                                        <img id="photoPreview" src="{{ $photoUrl }}" alt="Foto Profil" class="img-thumbnail {{ !$hasPhoto ? 'd-none' : '' }}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('photoPlaceholder').style.display='flex';">
                                        <div id="photoPlaceholder" class="bg-light d-inline-flex align-items-center justify-content-center {{ $hasPhoto ? 'd-none' : '' }}" style="width: 150px; height: 150px; border-radius: 50%;">
                                            <i class="fas fa-user fa-3x text-muted"></i>
                                        </div>
                                    </div>
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewPhoto(this)">
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                </div>

                                <hr class="my-4">

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $user->nip) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                </div>

                                <hr class="my-4">
                                <h6 class="mb-3">Ubah Password (Opsional)</h6>
                                <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter">
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('tu.profile.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i> Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Informasi
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Pastikan semua informasi yang Anda masukkan sudah benar.
                            </p>
                            <p class="small text-muted">
                                <i class="fas fa-lock text-info me-2"></i>
                                Password hanya akan diubah jika Anda mengisi kolom password baru.
                            </p>
                            <p class="small text-muted">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                Email harus unik dan tidak boleh sama dengan pengguna lain.
                            </p>
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
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');
            
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

