@extends('layouts.tu')

@section('title', 'Profil - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Profil Saya</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('tu.profile.edit') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user"></i> Informasi Profil
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Nama Lengkap:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>NIP:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $user->nip ?? '-' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>No. Telepon:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $user->phone ?? '-' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Alamat:</strong>
                                </div>
                                <div class="col-md-8">
                                    {{ $user->address ?? '-' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Role:</strong>
                                </div>
                                <div class="col-md-8">
                                    <span class="badge bg-success">
                                        {{ $user->role == 'tu' ? 'Tenaga Usaha' : ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-circle"></i> Foto Profil
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            @php
                                $photoPath = 'photos/' . $user->photo;
                                $hasPhoto = $user->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath);
                                $photoUrl = $hasPhoto ? asset('storage/' . $photoPath) : null;
                            @endphp
                            @if($hasPhoto && $photoUrl)
                                <img src="{{ $photoUrl }}?v={{ time() }}" alt="Foto Profil" class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid #2E7D32;">
                            @else
                                <div class="profile-circle mb-3" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <p class="text-muted">Foto profil belum diatur</p>
                            @endif
                            <a href="{{ route('tu.profile.edit') }}" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-edit"></i> {{ $user->photo ? 'Ganti Foto' : 'Upload Foto' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

