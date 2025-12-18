<!-- Sidebar -->
<div class="col-md-3 col-lg-2 sidebar p-0" id="ks-sidebar">
    <div class="p-4">
        <h4 class="text-white mb-4">
            <i class="fas fa-user-tie me-2"></i>
            Dashboard Kepala Sekolah
        </h4>
        <div class="text-center mb-4">
            @php
                $user = Auth::user();
                $photoUrl = null;
                $hasPhoto = false;
                
                if ($user) {
                    // SELALU ambil data fresh dari database untuk memastikan foto terbaru
                    $freshUser = \App\Models\User::find($user->id);
                    if ($freshUser && !empty($freshUser->photo)) {
                        // Method 1: PhotoHelper dengan default path
                        $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshUser->photo, 'profiles/kepala_sekolah');
                        
                        // Method 2: PhotoHelper tanpa default path
                        if (!$photoUrl) {
                            $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshUser->photo);
                        }
                        
                        // Method 3: Langsung cek di storage dengan path dari database
                        if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshUser->photo)) {
                            $baseUrl = request()->getSchemeAndHttpHost();
                            $photoUrl = $baseUrl . '/storage/' . $freshUser->photo . '?v=' . time() . '&r=' . rand(1000, 9999);
                        }
                        
                        // Method 4: Cek dengan basename di folder profiles/kepala_sekolah
                        if (!$photoUrl) {
                            $basename = basename($freshUser->photo);
                            $storagePath = 'profiles/kepala_sekolah/' . $basename;
                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                                $baseUrl = request()->getSchemeAndHttpHost();
                                $photoUrl = $baseUrl . '/storage/' . $storagePath . '?v=' . time() . '&r=' . rand(1000, 9999);
                            }
                        }
                        
                        // Method 5: Cek file secara langsung di disk
                        if (!$photoUrl) {
                            $fullPath = storage_path('app/public/' . $freshUser->photo);
                            if (file_exists($fullPath)) {
                                $baseUrl = request()->getSchemeAndHttpHost();
                                $photoUrl = $baseUrl . '/storage/' . $freshUser->photo . '?v=' . time() . '&r=' . rand(1000, 9999);
                        }
                    }
                        
                        // Method 6: Jika PhotoHelper menghasilkan URL dengan localhost, ganti dengan base URL dari request
                        if ($photoUrl && strpos($photoUrl, 'localhost') !== false) {
                            $baseUrl = request()->getSchemeAndHttpHost();
                            $photoUrl = str_replace('http://localhost', $baseUrl, $photoUrl);
                        }
                        
                        $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null';
                    }
                }
            @endphp
            <div class="mb-2" style="display: flex; justify-content: center;">
                @if($hasPhoto && $photoUrl)
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        <img src="{{ $photoUrl }}" alt="Foto Profil" id="profile-photo-img-ks" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;" onload="console.log('Sidebar photo loaded:', this.src);" onerror="console.error('Sidebar photo error:', this.src); this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder-ks').style.display='flex';">
                        <div id="profile-placeholder-ks" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 100px; height: 100px; top: 0; left: 0; z-index: 1;">
                            <i class="fas fa-user-tie fa-2x text-primary"></i>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        <i class="fas fa-user-tie fa-2x text-primary"></i>
                    </div>
                @endif
            </div>
            <h6 class="text-white mt-2 mb-1">{{ $user->name ?? 'Kepala Sekolah' }}</h6>
            <small class="text-white-50">Kepala Sekolah</small>
            <a href="{{ route('kepala_sekolah.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>
    
    <nav class="nav flex-column px-3">
        <a href="{{ route('kepala_sekolah.dashboard') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home me-2"></i>Dashboard
        </a>
        <a href="{{ route('kepala_sekolah.laporan') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.laporan') ? 'active' : '' }}">
            <i class="fas fa-chart-bar me-2"></i>Laporan
        </a>
        <a href="{{ route('kepala_sekolah.guru') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.guru*') ? 'active' : '' }}">
            <i class="fas fa-users me-2"></i>Data Guru
        </a>
        <a href="{{ route('kepala_sekolah.siswa.index') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.siswa*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate me-2"></i>Data Siswa
        </a>
        <a href="{{ route('kepala_sekolah.guru_activity') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.guru_activity') ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher me-2"></i>Aktivitas Guru
        </a>
        <a href="{{ route('kepala_sekolah.notifications') }}" class="nav-link {{ request()->routeIs('kepala_sekolah.notifications') ? 'active' : '' }}">
            <i class="fas fa-bell me-2"></i>Notifikasi
        </a>
        <a href="{{ route('logout.get') }}" class="nav-link mt-3">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
    </nav>
</div>
