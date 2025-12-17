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
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
        width: auto !important;
        left: 0 !important;
        transform: translateX(0) !important;
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
    
    /* Pastikan sidebar tidak memaksa konten ke bawah di desktop */
    @media (min-width: 768px) {
        .col-md-3.col-lg-2.sidebar {
            position: relative !important;
            float: none !important;
        }
    }
    
    /* PASTIKAN SIDEBAR TIDAK TERSEMBUNYI - ULTRA AGGRESSIVE */
    @media (min-width: 768px) {
        .col-md-3.col-lg-2.sidebar,
        #guru-sidebar {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            left: 0 !important;
            transform: translateX(0) !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
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
        position: relative;
    }
    
    .sidebar .dropdown-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
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
        margin-top: 4px;
        padding: 8px 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        min-width: 100%;
        position: absolute !important;
        left: 0 !important;
        top: 100% !important;
        z-index: 1050 !important;
        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    .sidebar .dropdown-menu.show {
        display: block !important;
        opacity: 1;
        transform: translateY(0);
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
                new bootstrap.Dropdown(dropdownToggleEl, {
                    boundary: 'viewport',
                    popperConfig: {
                        modifiers: [
                            {
                                name: 'offset',
                                options: {
                                    offset: [0, 8]
                                }
                            }
                        ]
                    }
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

