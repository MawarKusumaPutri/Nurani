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
                                // SELALU ambil data fresh dari database untuk memastikan foto terbaru
                                $freshUser = \App\Models\User::find($user->id);
                                $photoPath = $freshUser->photo ?? null;
                                $photoUrl = null;
                                
                                if ($photoPath) {
                                    // OTOMATIS cari foto dengan default path yang benar
                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($photoPath, 'profiles/tu');
                                    
                                    // Jika masih null, coba dengan path lain
                                    if (!$photoUrl) {
                                        $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($photoPath, 'image/profiles');
                                    }
                                    
                                    // Jika masih null, coba langsung dengan asset() untuk URL lengkap
                                    if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath)) {
                                        $photoUrl = asset('storage/' . $photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                                    }
                                    
                                    // Jika masih null, coba dengan path absolut
                                    if (!$photoUrl) {
                                        $storagePath = storage_path('app/public/' . $photoPath);
                                        if (file_exists($storagePath)) {
                                            $photoUrl = asset('storage/' . $photoPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                                        }
                                    }
                                    
                                    // Jika masih null, coba cari berdasarkan nama file saja
                                    if (!$photoUrl) {
                                        $filename = basename($photoPath);
                                        if ($filename && $filename !== $photoPath) {
                                            $possiblePaths = [
                                                'profiles/tu/' . $filename,
                                                'profiles/guru/' . $filename,
                                                'profiles/kepala_sekolah/' . $filename,
                                                'photos/' . $filename,
                                                'guru/foto/' . $filename
                                            ];
                                            
                                            foreach ($possiblePaths as $possiblePath) {
                                                $fullPath = storage_path('app/public/' . $possiblePath);
                                                if (file_exists($fullPath)) {
                                                    $photoUrl = asset('storage/' . $possiblePath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                                $hasPhoto = $photoUrl !== null && $photoUrl !== '';
                            @endphp
                            @if($hasPhoto && $photoUrl)
                                <img src="{{ $photoUrl }}" alt="Foto Profil" class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid #2E7D32;" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex'; console.error('Error loading photo: {{ $photoUrl }}');">
                                <div class="profile-circle mb-3" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32; display: none;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            @else
                                <div class="profile-circle mb-3" style="width: 200px; height: 200px; margin: 0 auto; font-size: 72px; border: 3px solid #2E7D32;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <p class="text-muted">Foto profil belum diatur</p>
                                @if($photoPath)
                                    <small class="text-danger">Path: {{ $photoPath }}</small>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tu.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route('tu.profile.edit') }}" class="btn btn-primary">
                            Edit Profil<i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

