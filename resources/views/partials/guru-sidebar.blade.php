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
                    
                    // OPTIMIZED: Cek path yang paling mungkin dulu untuk performa lebih baik
                    $mostLikelyPath = 'profiles/guru/' . basename($photoPath);
                    try {
                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($mostLikelyPath)) {
                            $photoUrl = asset('storage/' . $mostLikelyPath) . '?v=' . time();
                        } else {
                            // Cek path lain hanya jika path utama tidak ditemukan
                            foreach ($possiblePaths as $path) {
                                if ($path === $mostLikelyPath) continue; // Skip yang sudah dicek
                                try {
                                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                                        $photoUrl = asset('storage/' . $path) . '?v=' . time();
                                        break;
                                    }
                                } catch (\Exception $e) {
                                    continue;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        // Fallback ke path lain jika error
                        foreach ($possiblePaths as $path) {
                            try {
                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                                    $photoUrl = asset('storage/' . $path) . '?v=' . time();
                                    break;
                                }
                            } catch (\Exception $e2) {
                                continue;
                            }
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
    <div class="p-3">
        <h4 class="text-white mb-3" style="font-size: 1.1rem;">
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
        <a class="nav-link {{ $currentRoute == 'guru.dashboard' || str_contains($currentRoute, 'guru.rangkuman') ? 'active' : '' }}" href="{{ route('guru.dashboard') }}">
            <i class="fas fa-home me-2"></i> RPP
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.jadwal') ? 'active' : '' }}" href="{{ route('guru.jadwal.index') }}">
            <i class="fas fa-calendar-alt me-2"></i> Jadwal Mengajar
        </a>
        
        <!-- Presensi Guru Dropdown Menu -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle {{ str_contains($currentRoute, 'guru.presensi') && !str_contains($currentRoute, 'presensi-siswa') ? 'active' : '' }}" 
               id="presensiGuruDropdown" 
               role="button" 
               data-bs-toggle="collapse" 
               data-bs-target="#presensiGuruSubmenu" 
               aria-expanded="{{ str_contains($currentRoute, 'guru.presensi') && !str_contains($currentRoute, 'presensi-siswa') ? 'true' : 'false' }}">
                <i class="fas fa-calendar-check me-2"></i> Presensi Guru
                <i class="fas fa-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
            </a>
            <div class="collapse {{ str_contains($currentRoute, 'guru.presensi') && !str_contains($currentRoute, 'presensi-siswa') ? 'show' : '' }}" id="presensiGuruSubmenu">
                <div class="nav flex-column ps-4">
                    <a href="{{ route('guru.presensi.index') }}" 
                       class="nav-link submenu-link {{ str_contains($currentRoute, 'guru.presensi.index') || (str_contains($currentRoute, 'guru.presensi') && !request()->has('type')) ? 'active' : '' }}">
                        <i class="fas fa-sign-in-alt me-2"></i> Presensi Masuk
                    </a>
                    <a href="{{ route('guru.presensi.index', ['type' => 'keluar']) }}" 
                       class="nav-link submenu-link {{ request()->get('type') == 'keluar' ? 'active' : '' }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Presensi Keluar
                    </a>
                </div>
            </div>
        </div>
        
        <a class="nav-link {{ str_contains($currentRoute, 'presensi-siswa') ? 'active' : '' }}" href="{{ route('guru.presensi-siswa.index') }}">
            <i class="fas fa-user-graduate me-2"></i> Presensi Siswa
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.materi') ? 'active' : '' }}" href="{{ route('guru.materi.index') }}">
            <i class="fas fa-book me-2"></i> Materi
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.kuis') ? 'active' : '' }}" href="{{ route('guru.kuis.index') }}">
            <i class="fas fa-question-circle me-2"></i> Kuis
        </a>
        <a class="nav-link {{ str_contains($currentRoute, 'guru.evaluasi') ? 'active' : '' }}" href="{{ route('guru.evaluasi.index') }}">
            <i class="fas fa-clipboard-check me-2"></i> Evaluasi Guru
        </a>
        <a href="{{ route('logout.get') }}" class="nav-link mt-3">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </nav>
</div>

<style>
    .sidebar {
        min-height: 100vh;
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
        background-color: #2E7D32 !important;
        overflow-y: auto;
        overflow-x: visible !important;
        -webkit-overflow-scrolling: touch;
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        left: 0 !important;
        transform: translateX(0) !important;
    }
    
    /* Pastikan sidebar memiliki lebar tetap di desktop - tidak full width */
    @media (min-width: 768px) {
        .sidebar.col-md-3,
        #guru-sidebar.col-md-3 {
            flex: 0 0 25% !important;
            max-width: 25% !important;
            width: 25% !important;
        }
    }
    
    @media (min-width: 992px) {
        .sidebar.col-lg-2,
        #guru-sidebar.col-lg-2 {
            flex: 0 0 16.66666667% !important;
            max-width: 16.66666667% !important;
            width: 16.66666667% !important;
        }
    }
    
    /* Styling scrollbar untuk sidebar umum */
    .sidebar::-webkit-scrollbar {
        width: 8px;
    }
    
    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    
    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
    
    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
    
    /* Firefox scrollbar */
    .sidebar {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) rgba(255, 255, 255, 0.1);
    }
    
    /* Ensure sidebar content is scrollable - Sama seperti TU */
    #guru-sidebar {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
        background-color: #2E7D32 !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        left: 0 !important;
        transform: translateX(0) !important;
        z-index: 1000 !important;
        width: 100% !important;
    }
    
    /* Styling scrollbar agar terlihat jelas seperti TU */
    #guru-sidebar::-webkit-scrollbar {
        width: 8px;
    }
    
    #guru-sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    
    #guru-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
    
    #guru-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
    
    /* Firefox scrollbar */
    #guru-sidebar {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) rgba(255, 255, 255, 0.1);
    }
    
    /* Pastikan sidebar memiliki lebar tetap - tidak full width */
    @media (min-width: 768px) {
        .col-md-3.col-lg-2.sidebar,
        #guru-sidebar {
            position: relative !important;
            float: none !important;
            flex: 0 0 25% !important;
            width: 25% !important;
            max-width: 25% !important;
            min-width: 250px !important;
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            left: 0 !important;
            transform: translateX(0) !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    }
    
    @media (min-width: 992px) {
        .col-md-3.col-lg-2.sidebar,
        #guru-sidebar {
            flex: 0 0 16.66666667% !important;
            width: 16.66666667% !important;
            max-width: 16.66666667% !important;
            min-width: 200px !important;
        }
    }
    
    #guru-sidebar .p-4 {
        flex-shrink: 0;
    }
    
    #guru-sidebar nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: visible !important;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 20px;
        position: relative;
    }
    
    /* Styling scrollbar untuk nav di dalam sidebar */
    #guru-sidebar nav::-webkit-scrollbar {
        width: 6px;
    }
    
    #guru-sidebar nav::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }
    
    #guru-sidebar nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    
    #guru-sidebar nav::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.4);
    }
    
    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        border-radius: 8px;
        margin: 4px 0;
        transition: all 0.3s ease;
        width: 100%;
        display: block;
        pointer-events: auto !important;
        cursor: pointer !important;
        z-index: 10 !important;
        position: relative !important;
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
    
    .sidebar .nav-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
        pointer-events: auto !important;
        cursor: pointer !important;
    }
    
    /* Dropdown Menu Styling */
    .sidebar .nav-item.dropdown {
        position: static !important;
    }
    
    .sidebar .nav-item.dropdown:hover .dropdown-menu,
    .sidebar .nav-item.dropdown .dropdown-toggle[aria-expanded="true"] ~ .dropdown-menu {
        display: block !important;
        opacity: 1;
        transform: translateX(0);
    }
    
    .sidebar .dropdown-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        position: relative;
    }
    
    .sidebar .dropdown-toggle::after {
        margin-left: auto;
        transition: transform 0.3s ease;
        border-top-color: rgba(255, 255, 255, 0.8);
        margin-left: 8px;
    }
    
    .sidebar .dropdown-toggle[aria-expanded="true"]::after {
        transform: rotate(180deg);
    }
    
    .sidebar .dropdown-menu {
        background: rgba(27, 94, 32, 0.98) !important;
        border: none;
        border-radius: 8px;
        margin-left: 8px !important;
        padding: 8px 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        min-width: 220px;
        position: absolute !important;
        left: 100% !important;
        right: auto !important;
        top: 0 !important;
        bottom: auto !important;
        margin-top: 0 !important;
        z-index: 1050 !important;
        display: none;
        opacity: 0;
        transform: translateX(-10px) !important;
        transition: opacity 0.3s ease, transform 0.3s ease;
        will-change: transform, opacity;
    }
    
    /* Force dropdown to appear on the right side */
    .sidebar .dropdown-menu.show,
    .sidebar .dropdown-menu[data-bs-popper],
    .sidebar .nav-item.dropdown.show .dropdown-menu {
        position: absolute !important;
        left: 100% !important;
        right: auto !important;
        top: 0 !important;
        bottom: auto !important;
        margin-left: 8px !important;
        margin-top: 0 !important;
        transform: translateX(0) !important;
    }
    
    /* Pastikan dropdown tidak terpotong oleh container */
    .sidebar .nav-item.dropdown {
        overflow: visible !important;
    }
    
    .sidebar .nav {
        overflow: visible !important;
    }
    
    /* Pastikan container tidak memotong dropdown */
    .container-fluid {
        overflow: visible !important;
    }
    
    .container-fluid .row {
        overflow: visible !important;
    }
    
    .col-md-3.col-lg-2.sidebar {
        overflow: visible !important;
    }
    
    /* Pastikan dropdown muncul di samping dengan benar */
    .sidebar .nav-item.dropdown {
        position: static !important;
    }
    
    /* Override Bootstrap Popper positioning - FORCE SIDEBAR POSITION */
    .sidebar .dropdown-menu[data-bs-popper],
    .sidebar .dropdown-menu.show,
    .sidebar .nav-item.dropdown.show .dropdown-menu,
    .sidebar .nav-item.dropdown .dropdown-toggle[aria-expanded="true"] ~ .dropdown-menu {
        position: absolute !important;
        left: 100% !important;
        right: auto !important;
        top: 0 !important;
        bottom: auto !important;
        margin-left: 8px !important;
        margin-top: 0 !important;
        transform: translateX(0) !important;
        inset: auto !important;
    }
    
    /* Prevent Bootstrap from changing position */
    .sidebar .dropdown-menu[style*="position"] {
        position: absolute !important;
    }
    
    .sidebar .dropdown-menu[style*="left"],
    .sidebar .dropdown-menu[style*="top"] {
        left: 100% !important;
        top: 0 !important;
    }
    
    .sidebar .dropdown-menu.show {
        display: block !important;
        opacity: 1;
        transform: translateX(0);
    }
    
    .sidebar .dropdown-item {
        color: rgba(255, 255, 255, 0.9) !important;
        padding: 10px 20px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        white-space: nowrap;
        display: block;
        text-decoration: none;
    }
    
    .sidebar .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
        transform: translateX(5px);
    }
    
    .sidebar .dropdown-item.active {
        background: rgba(255, 255, 255, 0.25) !important;
        color: white !important;
        font-weight: 600;
    }
    
    .sidebar .dropdown-item i {
        width: 20px;
        text-align: center;
    }
    
    /* Pastikan SEMUA nav-link bisa diklik, termasuk RPP - ULTRA AGGRESSIVE */
    .sidebar .nav-link,
    #guru-sidebar .nav-link,
    .nav-link {
        pointer-events: auto !important;
        cursor: pointer !important;
        z-index: 10 !important;
        position: relative !important;
        display: block !important;
        text-decoration: none !important;
        user-select: none !important;
        -webkit-tap-highlight-color: rgba(0,0,0,0.1) !important;
    }
    
    /* Pastikan semua child elements tidak menghalangi, kecuali dropdown toggle */
    .sidebar .nav-link:not(.dropdown-toggle) *,
    #guru-sidebar .nav-link:not(.dropdown-toggle) * {
        pointer-events: none !important;
    }
    
    .sidebar .dropdown-toggle,
    .sidebar .dropdown-toggle * {
        pointer-events: auto !important;
        cursor: pointer !important;
    }
    
    /* Pastikan tidak ada overlay yang menutupi */
    .sidebar-overlay {
        z-index: 1 !important;
    }
    
    #guru-sidebar {
        z-index: 1000 !important;
    }
    
    .sidebar .nav-link.active {
        color: white !important;
        background: rgba(255, 255, 255, 0.1) !important;
        font-weight: 600 !important;
    }
    
    /* Submenu Styling for Collapse */
    .sidebar .submenu-link {
        color: rgba(255, 255, 255, 0.7) !important;
        padding: 10px 20px !important;
        font-size: 0.9rem !important;
        transition: all 0.3s ease !important;
        border-radius: 6px !important;
        margin: 2px 0 !important;
    }
    
    .sidebar .submenu-link:hover {
        color: white !important;
        background: rgba(255, 255, 255, 0.15) !important;
        transform: translateX(5px) !important;
    }
    
    .sidebar .submenu-link.active {
        color: white !important;
        background: rgba(255, 255, 255, 0.2) !important;
        font-weight: 600 !important;
    }
    
    .sidebar .collapse {
        transition: height 0.3s ease !important;
    }
    
    .sidebar .dropdown-toggle .fa-chevron-down {
        transition: transform 0.3s ease !important;
    }
    
    .sidebar .dropdown-toggle[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg) !important;
    }
    
    /* Profile Section Styling - Ensure Consistency */
    #guru-sidebar .text-center {
        text-align: center !important;
    }
    
    #guru-sidebar .text-center h6 {
        color: white !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    #guru-sidebar .text-center small {
        color: rgba(255, 255, 255, 0.5) !important;
        font-size: 0.875rem !important;
        line-height: 1.5 !important;
    }
    
    #guru-sidebar .text-center .btn {
        font-size: 0.75rem !important;
        padding: 0.25rem 0.5rem !important;
        border: 1px solid rgba(0,0,0,0.2) !important;
        white-space: nowrap !important;
        background-color: white !important;
        color: #000 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.25rem !important;
        margin-top: 0 !important;
    }
    
    #guru-sidebar .text-center .d-flex {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 0.5rem !important;
        flex-wrap: wrap !important;
        margin-top: 0.25rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    /* Profile Circle - Ensure White Background */
    #guru-sidebar .text-center .rounded-circle,
    #guru-sidebar .text-center .bg-white,
    #guru-sidebar .text-center .position-relative,
    #guru-sidebar .text-center .position-absolute,
    #guru-sidebar .text-center div[class*="rounded-circle"],
    #guru-sidebar .text-center div[class*="bg-white"] {
        background-color: white !important;
        background: white !important;
    }
    
    /* Ensure profile circle container is white */
    #guru-sidebar .text-center > div > div {
        background-color: white !important;
        background: white !important;
    }
    
    /* Profile placeholder icon container */
    #profile-placeholder-guru {
        background-color: white !important;
        background: white !important;
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
        
        .sidebar,
        #guru-sidebar {
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
        
        .sidebar.show,
        #guru-sidebar.show {
            left: 0;
        }
        
        #guru-sidebar nav {
            max-height: calc(100vh - 250px);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Scrollbar styling untuk mobile */
        .sidebar::-webkit-scrollbar,
        #guru-sidebar::-webkit-scrollbar {
            width: 8px;
        }
        
        .sidebar::-webkit-scrollbar-track,
        #guru-sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .sidebar::-webkit-scrollbar-thumb,
        #guru-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover,
        #guru-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
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
    
    // Initialize Bootstrap dropdowns
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize dropdowns manually if Bootstrap is loaded
        if (typeof bootstrap !== 'undefined') {
            const dropdownElementList = document.querySelectorAll('.sidebar .dropdown-toggle');
            dropdownElementList.forEach(function(dropdownToggleEl) {
                const dropdown = new bootstrap.Dropdown(dropdownToggleEl, {
                    boundary: 'clippingParents',
                    placement: 'right-start',
                    popperConfig: {
                        modifiers: [
                            {
                                name: 'offset',
                                options: {
                                    offset: [8, 0]
                                }
                            },
                            {
                                name: 'preventOverflow',
                                enabled: false
                            },
                            {
                                name: 'flip',
                                enabled: false
                            }
                        ]
                    }
                });
                
                // Force position after show - AGGRESSIVE
                dropdownToggleEl.addEventListener('shown.bs.dropdown', function() {
                    const menu = this.nextElementSibling || this.closest('.dropdown').querySelector('.dropdown-menu');
                    if (menu && menu.classList.contains('dropdown-menu')) {
                        // Force positioning dengan !important via setProperty
                        menu.style.setProperty('position', 'absolute', 'important');
                        menu.style.setProperty('left', '100%', 'important');
                        menu.style.setProperty('right', 'auto', 'important');
                        menu.style.setProperty('top', '0', 'important');
                        menu.style.setProperty('bottom', 'auto', 'important');
                        menu.style.setProperty('margin-left', '8px', 'important');
                        menu.style.setProperty('margin-top', '0', 'important');
                        menu.style.setProperty('transform', 'translateX(0)', 'important');
                        menu.style.setProperty('inset', 'auto', 'important');
                        
                        // Calculate position relative to sidebar
                        const rect = this.getBoundingClientRect();
                        const sidebarRect = document.getElementById('guru-sidebar').getBoundingClientRect();
                        const relativeTop = rect.top - sidebarRect.top;
                        
                        // Force position: di samping kanan sidebar, bukan di bawah
                        menu.style.setProperty('left', '100%', 'important');
                        menu.style.setProperty('right', 'auto', 'important');
                        menu.style.setProperty('top', relativeTop + 'px', 'important');
                        menu.style.setProperty('bottom', 'auto', 'important');
                        menu.style.setProperty('margin-left', '8px', 'important');
                        menu.style.setProperty('margin-top', '0', 'important');
                        menu.style.setProperty('transform', 'translateX(0)', 'important');
                        
                        // Remove any Popper.js inline styles that might override
                        menu.removeAttribute('data-popper-placement');
                        menu.removeAttribute('data-popper-reference-hidden');
                        menu.removeAttribute('data-popper-escaped');
                    }
                });
                
                // Also force on click
                dropdownToggleEl.addEventListener('click', function(e) {
                    setTimeout(function() {
                        const menu = dropdownToggleEl.nextElementSibling || dropdownToggleEl.closest('.dropdown').querySelector('.dropdown-menu');
                        if (menu && menu.classList.contains('dropdown-menu')) {
                            menu.style.setProperty('position', 'absolute', 'important');
                            menu.style.setProperty('left', '100%', 'important');
                            menu.style.setProperty('top', '0', 'important');
                        }
                    }, 10);
                });
            });
        } else {
            // Fallback: Manual dropdown toggle if Bootstrap is not loaded
            const dropdownToggles = document.querySelectorAll('.sidebar .dropdown-toggle');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const dropdown = this.closest('.dropdown');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    
                    // Close all other dropdowns
                    document.querySelectorAll('.sidebar .dropdown-menu.show').forEach(function(openMenu) {
                        if (openMenu !== menu) {
                            openMenu.classList.remove('show');
                            openMenu.previousElementSibling.setAttribute('aria-expanded', 'false');
                        }
                    });
                    
                    // Toggle current dropdown
                    if (isExpanded) {
                        menu.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        menu.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                    }
                });
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.sidebar .dropdown')) {
                    document.querySelectorAll('.sidebar .dropdown-menu.show').forEach(function(menu) {
                        menu.classList.remove('show');
                        const toggle = menu.previousElementSibling;
                        if (toggle) {
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });
        }
    });
    
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

