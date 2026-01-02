<!-- Sidebar -->
<div class="col-md-3 col-lg-2 sidebar p-0" id="tu-sidebar">
    <div class="p-4">
        <h4 class="text-white mb-4">
            <i class="fas fa-user-tie me-2"></i>
            Dashboard Tenaga Usaha
        </h4>
        <div class="text-center mb-4">
            @php
                $user = Auth::user();
                $photoUrl = null;
                $hasPhoto = false;
                
                // Gunakan data dari session Auth::user() untuk menghindari query database tambahan
                if ($user && !empty($user->photo)) {
                    $photoPath = $user->photo;
                    
                    try {
                        // Cek jika sudah URL lengkap
                        if (filter_var($photoPath, FILTER_VALIDATE_URL)) {
                            $photoUrl = $photoPath;
                        } else {
                            // Coba langsung dengan path yang ada
                            // Prioritas 1: Path langsung dari database
                            if (strpos($photoPath, 'storage/') === 0 || strpos($photoPath, '/storage/') === 0) {
                                $photoUrl = asset($photoPath) . '?v=' . time();
                            } 
                            // Prioritas 2: Path relative (profiles/tu/xxx.jpg)
                            elseif (strpos($photoPath, 'profiles/') === 0 || strpos($photoPath, 'photos/') === 0) {
                                $photoUrl = asset('storage/' . $photoPath) . '?v=' . time();
                            }
                            // Prioritas 3: Coba dengan basename di berbagai folder
                            else {
                                $filename = basename($photoPath);
                                $possiblePaths = [
                                    'profiles/tu/' . $filename,
                                    'photos/' . $filename,
                                    'image/profiles/' . $filename,
                                    $photoPath,
                                ];
                                
                                // Coba path pertama dulu (paling umum)
                                $photoUrl = asset('storage/' . $possiblePaths[0]) . '?v=' . time();
                            }
                        }
                    } catch (\Exception $e) {
                        // Jika ada error, gunakan placeholder
                        $photoUrl = null;
                    }
                }
                
                $hasPhoto = $photoUrl !== null && $photoUrl !== '';
            @endphp
            <div class="mb-2" style="display: flex; justify-content: center;">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 80px; height: 80px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    @if($hasPhoto && $photoUrl)
                        <img src="{{ $photoUrl }}" 
                             alt="Foto Profil" 
                             id="profile-photo-img-tu" 
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;"
                             onerror="this.onerror=null; this.style.display='none'; if(document.getElementById('profile-placeholder-tu')) document.getElementById('profile-placeholder-tu').style.display='flex';"
                             loading="lazy">
                    @endif
                    <div id="profile-placeholder-tu" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: {{ $hasPhoto ? 'none' : 'flex' }}; width: 80px; height: 80px; top: 0; left: 0; z-index: 1;">
                        <i class="fas fa-user-tie fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
            <h6 class="text-white mt-2 mb-1">{{ $user->name ?? 'Tenaga Usaha' }}</h6>
            <small class="text-white-50">Tenaga Usaha</small>
            <a href="{{ route('tu.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>
    
    <nav class="nav flex-column px-3 pb-4">
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
        <a href="{{ route('tu.presensi-siswa.index') }}" class="nav-link {{ request()->routeIs('tu.presensi-siswa.*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
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
        <!-- Riwayat Surat Dropdown Menu -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('tu.surat.*') ? 'active' : '' }}" 
               id="suratDropdown" 
               role="button" 
               data-bs-toggle="collapse" 
               data-bs-target="#suratSubmenu" 
               aria-expanded="{{ request()->routeIs('tu.surat.*') ? 'true' : 'false' }}">
                <i class="fas fa-history me-2"></i> Riwayat Surat
                <i class="fas fa-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
            </a>
            <div class="collapse {{ request()->routeIs('tu.surat.*') ? 'show' : '' }}" id="suratSubmenu">
                <div class="nav flex-column ps-4">
                    <a href="{{ route('tu.surat.index', ['jenis' => 'yayasan']) }}" 
                       class="nav-link submenu-link {{ request()->get('jenis') == 'yayasan' ? 'active' : '' }}">
                        <i class="fas fa-building me-2"></i> Surat dari Yayasan
                    </a>
                    <a href="{{ route('tu.surat.index', ['jenis' => 'sekolah']) }}" 
                       class="nav-link submenu-link {{ request()->get('jenis') == 'sekolah' || !request()->has('jenis') ? 'active' : '' }}">
                        <i class="fas fa-school me-2"></i> Surat dari Sekolah
                    </a>
                </div>
            </div>
        </div>
        <a href="{{ route('tu.pengumuman.index') }}" class="nav-link {{ request()->routeIs('tu.pengumuman.*') ? 'active' : '' }}">
            <i class="fas fa-bullhorn me-2"></i> Pengumuman
        </a>
        <a href="{{ route('tu.kegiatan-kesiswaan.index') }}" class="nav-link {{ request()->routeIs('tu.kegiatan-kesiswaan*') ? 'active' : '' }}">
            <i class="fas fa-users me-2"></i> Kegiatan Kesiswaan
        </a>
        <a href="{{ route('logout.get') }}" class="nav-link mt-3">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </nav>
</div>

