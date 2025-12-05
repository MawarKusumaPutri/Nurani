@php
    $currentRoute = request()->route()->getName();
    $guru = auth()->user()->guru ?? null;
    if (!$guru) {
        try {
            $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
        } catch (\Exception $e) {
            $guru = null;
        }
    }
    
    $photoUrl = null;
    $hasPhoto = false;
    
    if ($guru) {
        try {
            // Gunakan data dari relasi untuk menghindari query database tambahan
            $photoPath = $guru->foto ?? null;
            
            if (!empty($photoPath)) {
                // Cek jika sudah URL lengkap
                if (filter_var($photoPath, FILTER_VALIDATE_URL)) {
                    $photoUrl = $photoPath;
                } else {
                    // Cek berbagai kemungkinan path
                    $possiblePaths = [
                        $photoPath,
                        'profiles/guru/' . basename($photoPath),
                        'photos/' . basename($photoPath),
                        'image/profiles/' . basename($photoPath),
                        'guru/foto/' . basename($photoPath),
                    ];
                    
                    foreach ($possiblePaths as $path) {
                        try {
                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                                $photoUrl = asset('storage/' . $path) . '?v=' . time();
                                break;
                            }
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                    
                    // Jika masih null, coba langsung dengan path yang ada
                    if (!$photoUrl) {
                        if (strpos($photoPath, 'storage/') === 0 || strpos($photoPath, '/storage/') === 0) {
                            $photoUrl = asset($photoPath) . '?v=' . time();
                        } elseif (strpos($photoPath, 'profiles/') === 0 || strpos($photoPath, 'photos/') === 0) {
                            $photoUrl = asset('storage/' . $photoPath) . '?v=' . time();
                        } else {
                            $filename = basename($photoPath);
                            $photoUrl = asset('storage/profiles/guru/' . $filename) . '?v=' . time();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika ada error, gunakan placeholder
            $photoUrl = null;
        }
        
        $hasPhoto = $photoUrl !== null && $photoUrl !== '';
    }
@endphp

<button class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<div class="col-md-3 col-lg-2 sidebar p-0" id="guru-sidebar">
    <div class="p-4">
        <h4 class="text-white mb-4">
            <i class="fas fa-chalkboard-teacher me-2"></i>
            Dashboard Guru
        </h4>
        @if($guru)
        <div class="text-center mb-4">
            <div class="mb-2" style="display: flex; justify-content: center;">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 80px; height: 80px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    @if($hasPhoto && $photoUrl)
                        <img src="{{ $photoUrl }}" 
                             alt="Foto Profil" 
                             id="profile-photo-img-guru" 
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;"
                             onerror="this.onerror=null; this.style.display='none'; if(document.getElementById('profile-placeholder-guru')) document.getElementById('profile-placeholder-guru').style.display='flex';"
                             loading="lazy">
                    @endif
                    <div id="profile-placeholder-guru" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: {{ $hasPhoto ? 'none' : 'flex' }}; width: 80px; height: 80px; top: 0; left: 0; z-index: 1;">
                        <i class="fas fa-user fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
            <h6 class="text-white mt-2 mb-1">{{ $guru->user->name ?? 'Guru' }}</h6>
            <small class="text-white-50">{{ $guru->mata_pelajaran ?? 'Guru' }}</small>
            <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
        @endif
    </div>
    
    <nav class="nav flex-column px-3 pb-4">
        <a class="nav-link {{ $currentRoute == 'guru.dashboard' ? 'active' : '' }}" href="{{ route('guru.dashboard') }}">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.jadwal') ? 'active' : '' }}" href="{{ route('guru.jadwal.index') }}">
            <i class="fas fa-calendar-alt me-2"></i> Jadwal Mengajar
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.presensi') && !str_contains($currentRoute, 'presensi-siswa') ? 'active' : '' }}" href="{{ route('guru.presensi.index') }}">
            <i class="fas fa-calendar-check me-2"></i> Presensi Guru
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'presensi-siswa') ? 'active' : '' }}" href="{{ route('guru.presensi-siswa.index') }}">
            <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.materi') ? 'active' : '' }}" href="{{ route('guru.materi.index') }}">
            <i class="fas fa-book me-2"></i> Materi
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.kuis') ? 'active' : '' }}" href="{{ route('guru.kuis.index') }}">
            <i class="fas fa-question-circle me-2"></i> Kuis
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </nav>
</div>

<style>
    .sidebar {
        min-height: 100vh;
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Ensure sidebar content is scrollable */
    #guru-sidebar {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }
    
    #guru-sidebar .p-4 {
        flex-shrink: 0;
    }
    
    #guru-sidebar nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 20px;
    }
    
    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        border-radius: 8px;
        margin: 4px 0;
        transition: all 0.3s ease;
        width: 100%;
        display: block;
    }
    
    /* Ensure nav items are in single column */
    .sidebar .nav {
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        width: 100%;
    }
    
    .sidebar .nav-link,
    .sidebar .nav form {
        width: 100%;
        flex-shrink: 0;
    }
    
    .sidebar .nav form button {
        width: 100%;
        text-align: left;
    }
    
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }
    
    /* Responsive Styles */
    .sidebar-toggle {
        display: none;
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1050;
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        border: none;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        cursor: pointer;
    }
    
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1040;
    }
    
    @media (max-width: 991px) {
        .sidebar-toggle {
            display: block;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            z-index: 1050;
            transition: left 0.3s ease;
            width: 280px;
            max-width: 80%;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        #guru-sidebar {
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        #guru-sidebar nav {
            max-height: calc(100vh - 250px);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Prevent any wrapping or multi-column layout */
        .sidebar .nav {
            display: flex !important;
            flex-direction: column !important;
            flex-wrap: nowrap !important;
            width: 100% !important;
        }
        
        .sidebar .nav-link,
        .sidebar .nav form {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 auto !important;
        }
        
        .sidebar.show {
            left: 0;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        .col-md-9.col-lg-10 {
            width: 100%;
            margin-left: 0;
        }
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('guru-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        if (sidebar) {
            sidebar.classList.toggle('show');
        }
        if (overlay) {
            overlay.classList.toggle('show');
        }
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('guru-sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (window.innerWidth <= 991) {
            if (sidebar && !sidebar.contains(event.target) && 
                toggleBtn && !toggleBtn.contains(event.target) && 
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
            }
        }
    });
</script>

