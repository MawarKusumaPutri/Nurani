<!-- Sidebar -->
<div class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            @php
                $user = Auth::user();
                $hasPhoto = false;
                $photoUrl = null;
                
                if ($user && $user->photo) {
                    $photoPath = 'photos/' . $user->photo;
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath)) {
                        $hasPhoto = true;
                        $photoUrl = asset('storage/' . $photoPath);
                    }
                }
            @endphp
            @if($hasPhoto && $photoUrl)
                <img src="{{ $photoUrl }}?v={{ time() }}" alt="Foto Profil" class="mb-2" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 2px solid rgba(255,255,255,0.3); display: block; margin: 0 auto;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder').style.display='flex';">
                <div id="profile-placeholder" class="profile-circle mb-2" style="display: none;">
                    <i class="fas fa-user-tie"></i>
                </div>
            @else
                <div class="profile-circle mb-2">
                    <i class="fas fa-user-tie"></i>
                </div>
            @endif
            <h6 class="text-white mt-2 mb-1">{{ $user->name ?? 'Tenaga Usaha' }}</h6>
            <small class="text-white-50">{{ $user && $user->role == 'tu' ? 'Administrasi' : ucfirst($user->role ?? 'Administrasi') }}</small>
            <a href="{{ route('tu.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.dashboard') ? 'active' : '' }}" href="{{ route('tu.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.guru.*') ? 'active' : '' }}" href="{{ route('tu.guru.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i> Data Guru
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.siswa.*') ? 'active' : '' }}" href="{{ route('tu.siswa.index') }}">
                    <i class="fas fa-users"></i> Data Siswa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.presensi.*') ? 'active' : '' }}" href="{{ route('tu.presensi.index') }}">
                    <i class="fas fa-calendar-check"></i> Presensi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.jadwal.*') ? 'active' : '' }}" href="{{ route('tu.jadwal.index') }}">
                    <i class="fas fa-calendar"></i> Jadwal
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.kalender.*') ? 'active' : '' }}" href="{{ route('tu.kalender.index') }}">
                    <i class="fas fa-calendar-alt"></i> Kalender
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.arsip.*') ? 'active' : '' }}" href="{{ route('tu.arsip.index') }}">
                    <i class="fas fa-archive"></i> Arsip
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.surat.*') ? 'active' : '' }}" href="{{ route('tu.surat.index') }}">
                    <i class="fas fa-envelope"></i> Surat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tu.pengumuman.*') ? 'active' : '' }}" href="{{ route('tu.pengumuman.index') }}">
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

