<!-- Sidebar -->
<div class="col-md-3 col-lg-2 sidebar p-0">
    <div class="p-4">
        <h4 class="text-white mb-4">
            <i class="fas fa-user-tie me-2"></i>
            Dashboard Tenaga Usaha
        </h4>
        <div class="text-center mb-4">
            @php
                $user = Auth::user();
                $hasPhoto = false;
                $photoUrl = null;
                
                if ($user) {
                    $freshUser = \App\Models\User::find($user->id);
                    
                    if ($freshUser && !empty($freshUser->photo)) {
                        $storage = \Illuminate\Support\Facades\Storage::disk('public');
                        $photoPath = 'photos/' . $freshUser->photo;
                        
                        if ($storage->exists($photoPath)) {
                            $hasPhoto = true;
                            $photoUrl = asset('storage/' . $photoPath) . '?v=' . time() . '&t=' . ($freshUser->updated_at ? $freshUser->updated_at->timestamp : time()) . '&r=' . rand(1000, 9999);
                        } else {
                            $directPath = $freshUser->photo;
                            if ($storage->exists($directPath)) {
                                $hasPhoto = true;
                                $photoUrl = asset('storage/' . $directPath) . '?v=' . time() . '&r=' . rand(1000, 9999);
                            }
                        }
                    }
                }
            @endphp
            <div class="mb-2" style="display: flex; justify-content: center;">
                @if($hasPhoto && $photoUrl)
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 80px; height: 80px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        <img src="{{ $photoUrl }}" alt="Foto Profil" id="profile-photo-img-tu" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder-tu').style.display='flex';">
                        <div id="profile-placeholder-tu" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 80px; height: 80px; top: 0; left: 0; z-index: 1;">
                            <i class="fas fa-user-tie fa-2x text-primary"></i>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        <i class="fas fa-user-tie fa-2x text-primary"></i>
                    </div>
                @endif
            </div>
            <h6 class="text-white mt-2 mb-1">{{ $user->name ?? 'Tenaga Usaha' }}</h6>
            <small class="text-white-50">Tenaga Usaha</small>
            <a href="{{ route('tu.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>
    
    <nav class="nav flex-column px-3">
        <a href="{{ route('tu.dashboard') }}" class="nav-link {{ request()->routeIs('tu.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a href="{{ route('tu.guru.index') }}" class="nav-link {{ request()->routeIs('tu.guru.*') ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher me-2"></i> Data Guru
        </a>
        <a href="{{ route('tu.siswa.index') }}" class="nav-link {{ request()->routeIs('tu.siswa.*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate me-2"></i> Data Siswa
        </a>
        <a href="{{ route('tu.presensi.index') }}" class="nav-link {{ request()->routeIs('tu.presensi.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check me-2"></i> Presensi Guru
        </a>
        <a href="{{ route('tu.jadwal.index') }}" class="nav-link {{ request()->routeIs('tu.jadwal.*') ? 'active' : '' }}">
            <i class="fas fa-calendar me-2"></i> Jadwal
        </a>
        <a href="{{ route('tu.kalender.index') }}" class="nav-link {{ request()->routeIs('tu.kalender.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt me-2"></i> Kalender
        </a>
        <a href="{{ route('tu.arsip.index') }}" class="nav-link {{ request()->routeIs('tu.arsip.*') ? 'active' : '' }}">
            <i class="fas fa-archive me-2"></i> Arsip
        </a>
        <a href="{{ route('tu.surat.index') }}" class="nav-link {{ request()->routeIs('tu.surat.*') ? 'active' : '' }}">
            <i class="fas fa-envelope me-2"></i> Surat
        </a>
        <a href="{{ route('tu.pengumuman.index') }}" class="nav-link {{ request()->routeIs('tu.pengumuman.*') ? 'active' : '' }}">
            <i class="fas fa-bullhorn me-2"></i> Pengumuman
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </nav>
</div>

