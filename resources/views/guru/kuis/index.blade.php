@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kuis - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        body {
            overflow-x: hidden;
        }
        
        /* Layout - sama seperti presensi (biarkan Bootstrap yang mengatur) */
        /* Pastikan di desktop, konten di samping sidebar - ULTRA VISIBLE */
        @media (min-width: 768px) {
            .container-fluid > .row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }
            
            /* Pastikan sidebar menggunakan ukuran Bootstrap default - Medium screen - ULTRA VISIBLE */
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 25% !important;
                width: 25% !important; /* col-md-3 = 25% */
                max-width: 25% !important;
                min-width: 250px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 75% !important;
                width: 75% !important; /* col-md-9 = 75% */
            }
        }
        
        /* Large screen - sidebar lebih kecil - ULTRA VISIBLE */
        @media (min-width: 992px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 16.66666667% !important;
                width: 16.66666667% !important; /* col-lg-2 = 16.67% */
                max-width: 16.66666667% !important;
                min-width: 200px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                left: 0 !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 83.33333333% !important;
                width: 83.33333333% !important; /* col-lg-10 = 83.33% */
            }
        }
        
        /* Main content - di samping sidebar (kanan) */
        .col-md-9.col-lg-10 {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1 !important;
            min-height: 100vh !important;
            padding: 1rem 1.5rem !important;
            background-color: #ffffff !important;
            box-sizing: border-box !important;
        }
        
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
        
        /* Pastikan sidebar tidak memaksa konten ke bawah di desktop */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar {
                position: relative !important;
                float: none !important;
            }
        }
        
        /* Ensure sidebar content is scrollable - ULTRA VISIBLE */
        #guru-sidebar {
            display: flex !important;
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
        
        /* Pastikan konten tidak tersembunyi */
        .col-md-9.col-lg-10 > * {
            display: block !important;
            visibility: visible !important;
        }
        
        .col-md-9.col-lg-10 h2,
        .col-md-9.col-lg-10 .row,
        .col-md-9.col-lg-10 .card,
        .col-md-9.col-lg-10 .alert {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
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
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
        }
        
        /* Responsive Styles */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 9999;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            cursor: pointer;
            pointer-events: auto;
            touch-action: manipulation;
        }
        
        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
            transform: scale(1.05);
        }
        
        .sidebar-toggle:active {
            transform: scale(0.95);
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.05) !important;
            z-index: 1040;
            transition: background 0.3s ease;
        }
        
        .sidebar-overlay.show {
            background: rgba(0,0,0,0.05) !important;
            z-index: 1040 !important;
        }
        
        /* Pastikan sidebar lebih tinggi dari overlay dan hijau terang */
        .sidebar.show {
            z-index: 1061 !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        #sidebar.show {
            z-index: 1061 !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        /* Pastikan semua elemen di sidebar tidak hitam */
        .sidebar * {
            background-color: transparent !important;
        }
        
        .sidebar .p-4 {
            background: transparent !important;
        }
        
        .sidebar nav {
            background: transparent !important;
        }
        
        .sidebar .nav {
            background: transparent !important;
        }
        
        .sidebar .nav-link {
            background: transparent !important;
            background-color: transparent !important;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1) !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Make sure nav links are always clickable */
        .sidebar .nav-link {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            position: relative !important;
            display: block !important;
            touch-action: manipulation !important;
        }
        
        .sidebar .nav-link:hover {
            pointer-events: auto !important;
            background: rgba(255, 255, 255, 0.1) !important;
        }
        
        .sidebar .nav-link:active {
            pointer-events: auto !important;
        }
        
        /* Ensure sidebar is always above overlay */
        .sidebar.show {
            z-index: 1061 !important;
        }
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block !important;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1061 !important;
                transition: left 0.3s ease;
                width: 280px;
                max-width: 80%;
                height: 100vh;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                -webkit-overflow-scrolling: touch !important;
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
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            .sidebar-overlay.show {
                display: block;
                background: rgba(0,0,0,0.05) !important;
                z-index: 1040 !important;
            }
            
            /* Pastikan semua elemen di sidebar tidak hitam di mobile */
            .sidebar * {
                background-color: transparent !important;
            }
            
            .sidebar .p-4 {
                background: transparent !important;
            }
            
            .sidebar nav {
                background: transparent !important;
            }
            
            .sidebar .nav {
                background: transparent !important;
            }
            
            .sidebar .nav-link {
                background: transparent !important;
                background-color: transparent !important;
            }
            
            .sidebar .nav-link:hover, .sidebar .nav-link.active {
                background: rgba(255, 255, 255, 0.1) !important;
                background-color: rgba(255, 255, 255, 0.1) !important;
            }
            
            /* Ensure sidebar is always clickable when shown */
            .sidebar.show {
                pointer-events: auto !important;
            }
            
            .sidebar.show * {
                pointer-events: auto !important;
            }
            
            /* Di mobile, konten tetap di bawah sidebar */
            .col-md-9.col-lg-10 {
                width: 100% !important;
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            
            .col-md-3.col-lg-2.sidebar {
                width: 100% !important;
            }
        }
        
        /* OVERRIDE MOBILE CSS UNTUK DESKTOP - ULTRA AGGRESSIVE */
        @media (min-width: 768px) {
            .sidebar.col-md-3.col-lg-2,
            #guru-sidebar.col-md-3.col-lg-2,
            .col-md-3.col-lg-2#guru-sidebar,
            .col-md-3.col-lg-2.sidebar#guru-sidebar {
                position: relative !important;
                left: 0 !important;
                top: auto !important;
                transform: translateX(0) !important;
                transition: none !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Manajemen Kuis</h2>
                        <p class="text-muted mb-0">Kelola kuis dan latihan untuk siswa</p>
                        @if($selectedMataPelajaran)
                            <span class="badge bg-primary">{{ $selectedMataPelajaran }}</span>
                        @endif
                    </div>
                </div>

                <!-- Mata Pelajaran Switcher -->
                @if($mataPelajaranList->count() > 1)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-exchange-alt me-2 text-primary"></i>
                                Filter Berdasarkan Mata Pelajaran
                            </h6>
                            <div class="row">
                                @foreach($mataPelajaranList as $mp)
                                    <div class="col-md-4 col-lg-3 mb-2">
                                        <a href="{{ route('guru.kuis.index', ['mata_pelajaran' => $mp->mata_pelajaran]) }}" 
                                           class="btn w-100 {{ $selectedMataPelajaran == $mp->mata_pelajaran ? 'btn-primary' : 'btn-outline-primary' }}">
                                            <i class="fas fa-book me-2"></i>{{ $mp->mata_pelajaran }}
                                            @if($selectedMataPelajaran == $mp->mata_pelajaran)
                                                <i class="fas fa-check float-end"></i>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-flex justify-content-start gap-3 mb-4" style="flex-wrap: wrap;">
                    <a href="{{ route('guru.kuis.create') }}" class="btn btn-success" style="background-color: #28a745 !important; border-color: #28a745 !important; padding: 0.75rem 1.5rem; font-size: 1rem; font-weight: 500; border-radius: 0.5rem; color: white !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fas fa-plus me-2"></i>Tambah Kuis
                    </a>
                    <a href="https://www.youtube.com" target="_blank" class="btn btn-danger" style="background-color: #dc3545 !important; border-color: #dc3545 !important; padding: 0.75rem 1.5rem; font-size: 1rem; font-weight: 500; border-radius: 0.5rem; color: white !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fab fa-youtube me-2"></i>YouTube
                    </a>
                </div>

                <!-- Kuis List -->
                @if($kuis->count() > 0)
                    <div class="row">
                        @foreach($kuis as $item)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: none; border-radius: 0.5rem;">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-weight: 600; color: #333;">{{ $item->judul }}</h5>
                                        <p class="text-muted small mb-3">{{ Str::limit($item->deskripsi ?? 'Tidak ada deskripsi', 80) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge bg-primary">{{ $item->kelas }}</span>
                                            <span class="badge bg-info text-white">{{ $item->mata_pelajaran }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $item->durasi_menit ?? 0 }} menit
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $item->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                        @if($item->link_kuis || $item->external_quiz_url)
                                            <div class="mt-2">
                                                <a href="{{ $item->link_kuis ?? $item->external_quiz_url }}" target="_blank" rel="noopener noreferrer"
                                                   class="btn btn-sm btn-outline-primary w-100">
                                                    <i class="fas fa-external-link-alt me-1"></i>Buka Link Kuis
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-transparent" style="border-top: 1px solid #e9ecef;">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('guru.kuis.show', $item) }}" 
                                               class="btn btn-sm btn-outline-primary flex-grow-1">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </a>
                                            <a href="{{ route('guru.kuis.edit', $item) }}" 
                                               class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($item->external_quiz_url)
                                                <a href="{{ $item->external_quiz_url }}" target="_blank" rel="noopener"
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Buka link kuis eksternal">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($kuis->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $kuis->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-question-circle fa-4x text-muted mb-4" style="opacity: 0.5;"></i>
                            <h4 class="text-muted mb-3">Belum Ada Kuis</h4>
                            <p class="text-muted mb-4">Anda belum membuat kuis. Klik tombol "Tambah Kuis" di atas untuk membuat kuis baru.</p>
                            <a href="{{ route('guru.kuis.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>Tambah Kuis Pertama
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('guru-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const isOpen = sidebar.classList.contains('show');
            
            if (isOpen) {
                // Close sidebar
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (overlay) overlay.style.display = 'none';
                // Enable body scroll when sidebar is closed
                document.body.style.overflow = '';
                document.body.style.position = '';
                document.body.style.width = '';
                document.body.style.height = '';
                document.body.style.top = '';
                document.body.style.background = '#ffffff';
                document.body.style.backgroundColor = '#ffffff';
            } else {
                // Open sidebar
                sidebar.classList.add('show');
                overlay.classList.add('show');
                if (overlay) overlay.style.display = 'block';
                // Prevent body scroll when sidebar is open
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('guru-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (window.innerWidth <= 991) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                if (overlay) overlay.style.display = 'none';
            }
            // Always reset body styles regardless of screen size
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        }
        
        // Ensure body has white background on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        });
        
        // Close sidebar when clicking outside on mobile
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
            });
        }
        
        // Robust function to setup nav links
        function setupNavLinks() {
            const navLinks = document.querySelectorAll('.sidebar .nav-link, #guru-sidebar .nav-link');
            navLinks.forEach(function(link) {
                // Force styles dengan !important - PASTIKAN BISA DIKLIK
                link.style.setProperty('pointer-events', 'auto', 'important');
                link.style.setProperty('cursor', 'pointer', 'important');
                link.style.setProperty('z-index', '1001', 'important');
                link.style.setProperty('position', 'relative', 'important');
                link.style.setProperty('display', 'block', 'important');
                link.style.setProperty('touch-action', 'manipulation', 'important');
                link.style.setProperty('text-decoration', 'none', 'important');
                
                // Pastikan child elements tidak menghalangi
                const children = link.querySelectorAll('*');
                children.forEach(function(child) {
                    child.style.setProperty('pointer-events', 'none', 'important');
                });
                
                // JANGAN clone - biarkan href normal bekerja
                const href = link.getAttribute('href');
                if (href && href !== '#' && href !== 'javascript:void(0)') {
                    // Pastikan href tetap ada
                    if (!link.href || link.href === window.location.href) {
                        link.href = href;
                    }
                    
                    // Tambahkan click handler yang MEMASTIKAN navigasi
                    link.addEventListener('click', function(e) {
                        console.log('✓ Nav link clicked:', href);
                        // Biarkan browser navigate secara normal - JANGAN preventDefault
                        closeSidebar();
                    }, false);
                    
                    // Touch handler untuk mobile
                    link.addEventListener('touchend', function(e) {
                        console.log('✓ Nav link touched:', href);
                        closeSidebar();
                        window.location.href = href;
                        e.preventDefault();
                        return false;
                    }, false);
                }
            });
        }
        
        // Setup nav links saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            setupNavLinks();
            
            // Setup ulang setiap kali sidebar dibuka
            const sidebar = document.getElementById('guru-sidebar');
            if (sidebar) {
                const observer = new MutationObserver(function(mutations) {
                    if (sidebar.classList.contains('show')) {
                        setTimeout(setupNavLinks, 100);
                    }
                });
                observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
            }
        });
        
        // Pastikan setupNavLinks tersedia secara global
        window.setupNavLinks = setupNavLinks;
        
        // Also ensure sidebar itself is clickable
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.style.pointerEvents = 'auto';
            sidebar.style.zIndex = '1061';
        }
    </script>
</body>
</html>
