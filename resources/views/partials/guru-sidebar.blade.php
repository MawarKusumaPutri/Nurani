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
        <div class="text-center mb-4" style="text-align: center;">
            <div class="mb-2" style="display: flex; justify-content: center; margin-bottom: 0.5rem;">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-relative" style="width: 80px; height: 80px; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.2); background-color: white !important; background: white !important;">
                    @if($hasPhoto && $photoUrl)
                        <img src="{{ $photoUrl }}" 
                             alt="Foto Profil" 
                             id="profile-photo-img-guru" 
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; position: relative; z-index: 2;"
                             onerror="this.onerror=null; this.style.display='none'; if(document.getElementById('profile-placeholder-guru')) document.getElementById('profile-placeholder-guru').style.display='flex';"
                             loading="lazy">
                    @endif
                    <div id="profile-placeholder-guru" class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center position-absolute" style="display: {{ $hasPhoto ? 'none' : 'flex' }}; width: 80px; height: 80px; top: 0; left: 0; z-index: 1; background-color: white !important; background: white !important;">
                        <i class="fas fa-user fa-2x" style="color: #0d6efd;"></i>
                    </div>
                </div>
            </div>
            <h6 class="text-white mt-2 mb-1" style="font-weight: 600; font-size: 1rem; margin-top: 0.5rem; margin-bottom: 0.25rem; color: white !important;">{{ $guru->user->name ?? 'Guru' }}</h6>
            <div class="d-flex align-items-center justify-content-center mt-1 mb-2" style="gap: 0.5rem; flex-wrap: wrap; margin-top: 0.25rem; margin-bottom: 0.5rem; display: flex !important; align-items: center !important; justify-content: center !important;">
                <small class="text-white-50" style="font-size: 0.875rem; line-height: 1.5; color: rgba(255,255,255,0.5) !important;">{{ $guru->mata_pelajaran ?? 'Guru' }}</small>
                <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-light" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; border: 1px solid rgba(0,0,0,0.2); white-space: nowrap; background-color: white !important; color: #000 !important; display: inline-flex !important; align-items: center !important; gap: 0.25rem; text-decoration: none;">
                    <i class="fas fa-edit" style="font-size: 0.7rem;"></i> Edit Profil
                </a>
            </div>
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
        <a class="nav-link {{ str_contains($currentRoute, 'guru.rpp') ? 'active' : '' }}" href="{{ route('guru.rpp.index') }}" id="rpp-nav-link" data-rpp-link="true" onclick="window.location.href='{{ route('guru.rpp.index') }}'; return true;">
            <i class="fas fa-file-alt me-2"></i> RPP
        </a>
        <a href="{{ route('logout.get') }}" class="nav-link mt-3">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
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
        padding: 10px 15px;
        border-radius: 8px;
        margin: 4px 0;
        transition: all 0.3s ease;
        width: 100%;
        display: block;
        font-size: 0.9rem;
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
    
    /* Pastikan semua child elements tidak menghalangi */
    .sidebar .nav-link *,
    #guru-sidebar .nav-link * {
        pointer-events: none !important;
    }
    
    /* Pastikan link RPP khususnya bisa diklik - ULTRA AGGRESSIVE */
    #rpp-nav-link,
    [data-rpp-link="true"],
    .sidebar .nav-link#rpp-nav-link,
    .sidebar .nav-link[data-rpp-link="true"],
    .sidebar .nav-link[href*="rpp"],
    .sidebar .nav-link[href*="RPP"],
    a#rpp-nav-link,
    a[data-rpp-link="true"] {
        pointer-events: auto !important;
        cursor: pointer !important;
        z-index: 99999 !important;
        position: relative !important;
        display: block !important;
        text-decoration: none !important;
        user-select: none !important;
        touch-action: manipulation !important;
        -webkit-tap-highlight-color: rgba(0,0,0,0.1) !important;
    }
    
    /* Pastikan tidak ada elemen yang menutupi nav-link */
    .sidebar .nav-link *,
    #rpp-nav-link *,
    [data-rpp-link="true"] * {
        pointer-events: none !important;
    }
    
    /* Pastikan icon di dalam link RPP tidak menghalangi */
    #rpp-nav-link i,
    [data-rpp-link="true"] i,
    .sidebar .nav-link#rpp-nav-link i {
        pointer-events: none !important;
    }
    
    /* Pastikan tidak ada overlay yang menutupi */
    .sidebar-overlay {
        z-index: 1 !important;
    }
    
    #guru-sidebar {
        z-index: 1000 !important;
    }
    
    #rpp-nav-link {
        z-index: 99999 !important;
    }
    
    .sidebar .nav-link.active {
        color: white !important;
        background: rgba(129, 199, 132, 0.4) !important;
        background-color: rgba(129, 199, 132, 0.4) !important;
        border-left: 3px solid rgba(255, 255, 255, 0.6) !important;
        font-weight: 600 !important;
        transform: translateX(0) !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
        border-radius: 8px !important;
    }
    
    .sidebar .nav-link.active i {
        color: white !important;
        opacity: 1 !important;
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
    
    // Pastikan link RPP bisa diklik - ULTRA AGGRESSIVE (MEMAKSA navigasi)
    function ensureRppLinkClickable() {
        const rppLink = document.querySelector('#rpp-nav-link, [data-rpp-link="true"], a[href*="rpp"], a[href*="RPP"]');
        if (rppLink) {
            console.log('✓✓✓ RPP link found:', rppLink.href);
            
            // Force semua style
            rppLink.style.cssText = 'pointer-events: auto !important; cursor: pointer !important; z-index: 99999 !important; position: relative !important; display: block !important; text-decoration: none !important;';
            
            // Pastikan child elements tidak menghalangi
            const children = rppLink.querySelectorAll('*');
            children.forEach(function(child) {
                child.style.setProperty('pointer-events', 'none', 'important');
            });
            
            // Pastikan href valid
            const hrefAttr = rppLink.getAttribute('href');
            let rppUrl = hrefAttr || rppLink.href;
            // Jika href relatif, buat absolute URL
            if (rppUrl && !rppUrl.startsWith('http') && !rppUrl.startsWith('/')) {
                rppUrl = '/' + rppUrl;
            }
            if (rppUrl && rppUrl !== '#' && rppUrl !== 'javascript:void(0)') {
                rppLink.href = rppUrl;
            } else {
                // Fallback ke route default
                rppUrl = '/guru/rpp';
                rppLink.href = rppUrl;
            }
            
            // HAPUS semua event listener lama dengan clone
            const newRppLink = rppLink.cloneNode(true);
            rppLink.parentNode.replaceChild(newRppLink, rppLink);
            
            // MEMAKSA navigasi dengan multiple methods
            const finalUrl = newRppLink.getAttribute('href') || rppUrl;
            
            // Method 1: Direct onclick (paling kuat)
            newRppLink.setAttribute('onclick', 'window.location.href=\'' + finalUrl + '\'; return true;');
            
            // Method 2: Click event (capture phase - paling awal)
            newRppLink.addEventListener('click', function(e) {
                console.log('✓✓✓ RPP CLICKED (capture)! Navigating to:', finalUrl);
                e.stopImmediatePropagation();
                window.location.href = finalUrl;
                return false;
            }, true);
            
            // Method 3: Click event (bubble phase)
            newRppLink.addEventListener('click', function(e) {
                console.log('✓✓✓ RPP CLICKED (bubble)! Navigating to:', finalUrl);
                e.stopImmediatePropagation();
                window.location.href = finalUrl;
                return false;
            }, false);
            
            // Method 4: Mousedown (sebelum click)
            newRppLink.addEventListener('mousedown', function(e) {
                console.log('✓✓✓ RPP MOUSEDOWN! Navigating to:', finalUrl);
                window.location.href = finalUrl;
                return false;
            }, true);
            
            // Method 5: Touch (untuk mobile)
            newRppLink.addEventListener('touchend', function(e) {
                console.log('✓✓✓ RPP TOUCHED! Navigating to:', finalUrl);
                e.preventDefault();
                window.location.href = finalUrl;
                return false;
            }, true);
        } else {
            console.warn('⚠⚠⚠ RPP link NOT FOUND!');
        }
    }
    
    // Jalankan MULTIPLE TIMES untuk memastikan
    function initRppLink() {
        ensureRppLinkClickable();
    }
    
    // Jalankan segera
    initRppLink();
    
    // Jalankan saat DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRppLink);
    }
    
    // Jalankan setelah page load
    window.addEventListener('load', function() {
        setTimeout(initRppLink, 50);
        setTimeout(initRppLink, 200);
        setTimeout(initRppLink, 500);
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

