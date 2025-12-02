@php
    $currentRoute = request()->route()->getName();
    $guru = auth()->user()->guru ?? null;
    if (!$guru) {
        $guru = \App\Models\Guru::where('user_id', auth()->id())->first();
    }
    
    if ($guru) {
        $freshGuru = \App\Models\Guru::find($guru->id);
        $photoUrl = null;
        
        if ($freshGuru && !empty($freshGuru->foto)) {
            $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'profiles/guru');
            if (!$photoUrl) {
                $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshGuru->foto, 'image/profiles');
            }
            if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshGuru->foto)) {
                $photoUrl = asset('storage/' . $freshGuru->foto) . '?v=' . time() . '&r=' . rand(1000, 9999);
            }
        }
        $hasPhoto = $photoUrl !== null && $photoUrl !== '';
    }
@endphp

<button class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<div class="col-md-3 col-lg-2 sidebar p-0" id="sidebar">
    <div class="p-4">
        <h4 class="text-white mb-4">
            <i class="fas fa-chalkboard-teacher me-2"></i>
            Dashboard Guru
        </h4>
        @if($guru)
        <div class="text-center mb-4">
            @if(isset($hasPhoto) && $hasPhoto && isset($photoUrl) && $photoUrl)
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 100px; height: 100px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    <img src="{{ $photoUrl }}" alt="Foto Profil" id="profile-photo-img-guru" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('profile-placeholder-guru').style.display='flex';">
                    <div id="profile-placeholder-guru" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: none; width: 100px; height: 100px; top: 0; left: 0; z-index: 1;">
                        <i class="fas fa-user fa-2x text-primary"></i>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    <i class="fas fa-user fa-2x text-primary"></i>
                </div>
            @endif
            <h6 class="text-white mt-2 mb-1">{{ $guru->user->name }}</h6>
            <small class="text-white-50">{{ $guru->mata_pelajaran }}</small>
            <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light mt-2" style="font-size: 0.75rem;">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
        @endif
    </div>
    
    <nav class="nav flex-column px-3">
        <a class="nav-link {{ $currentRoute == 'guru.dashboard' ? 'active' : '' }}" href="{{ route('guru.dashboard') }}" onclick="closeSidebar()">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.jadwal') ? 'active' : '' }}" href="{{ route('guru.jadwal.index') }}" onclick="closeSidebar()">
            <i class="fas fa-calendar-alt me-2"></i> Jadwal Mengajar
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.presensi') && !str_contains($currentRoute, 'presensi-siswa') ? 'active' : '' }}" href="{{ route('guru.presensi.index') }}" onclick="closeSidebar()">
            <i class="fas fa-calendar-check me-2"></i> Presensi Guru
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'presensi-siswa') ? 'active' : '' }}" href="{{ route('guru.presensi-siswa.index') }}" onclick="closeSidebar()">
            <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.materi') ? 'active' : '' }}" href="{{ route('guru.materi.index') }}" onclick="closeSidebar()">
            <i class="fas fa-book me-2"></i> Materi
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.kuis') ? 'active' : '' }}" href="{{ route('guru.kuis.index') }}" onclick="closeSidebar()">
            <i class="fas fa-question-circle me-2"></i> Kuis
        </a>
        <hr class="text-white-50">
        <a class="nav-link" href="{{ route('logout') }}" onclick="closeSidebar()">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </nav>
</div>

<style>
    .sidebar {
        min-height: 100vh;
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
    }
    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        border-radius: 8px;
        margin: 4px 0;
        transition: all 0.3s ease;
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
            max-width: 85%;
            height: 100vh;
            overflow-y: auto;
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
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        if (sidebar && overlay) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    }
    
    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        if (sidebar && overlay && window.innerWidth <= 991) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (window.innerWidth <= 991 && sidebar && toggleBtn && overlay) {
            if (!sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target) && 
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        }
    });
</script>

