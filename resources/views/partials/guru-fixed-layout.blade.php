{{-- Fixed Sidebar Layout untuk Semua Halaman Guru --}}
{{-- Include file ini di semua halaman guru untuk layout yang konsisten --}}
<style>
    /* ========================================
       FIXED SIDEBAR LAYOUT - GLOBAL STYLES
       ======================================== */
    
    /* Reset & Base */
    html, body {
        background-color: #ffffff !important;
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    body {
        overflow-x: hidden;
    }
    
    /* Container & Row */
    .container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    .container-fluid > .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* ========================================
       MOBILE LAYOUT (< 768px)
       ======================================== */
    @media (max-width: 767px) {
        /* Sidebar Toggle Button */
        .sidebar-toggle {
            display: block !important;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 99999 !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            cursor: pointer !important;
            pointer-events: auto !important;
        }
        
        /* Sidebar - Hidden by default, slide from left */
        .col-md-3.col-lg-2.sidebar,
        #guru-sidebar {
            position: fixed !important;
            top: 0 !important;
            left: -100% !important;
            z-index: 1061 !important;
            transition: left 0.3s ease !important;
            width: 280px !important;
            max-width: 85% !important;
            height: 100vh !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
        }
        
        /* Sidebar when shown */
        .sidebar.show,
        #guru-sidebar.show {
            left: 0 !important;
        }
        
        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.1) !important;
            z-index: 1040 !important;
        }
        
        .sidebar-overlay.show {
            display: block !important;
        }
        
        /* Main Content - Full width on mobile */
        .col-md-9.col-lg-10,
        main.col-md-9,
        main.col-md-9.col-lg-10 {
            width: 100% !important;
            margin-left: 0 !important;
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }
    
    /* ========================================
       TABLET LAYOUT (768px - 991px)
       ======================================== */
    @media (min-width: 768px) {
        /* Hide mobile toggle */
        .sidebar-toggle {
            display: none !important;
        }
        
        .sidebar-overlay {
            display: none !important;
        }
        
        /* Container & Row - Flexbox side by side */
        .container-fluid > .row {
            display: flex !important;
            flex-wrap: nowrap !important;
        }
        
        /* SIDEBAR - FIXED di sisi kiri */
        .col-md-3.col-lg-2.sidebar,
        #guru-sidebar {
            /* Position */
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            height: 100vh !important;
            z-index: 1000 !important;
            
            /* Size */
            flex: 0 0 25% !important;
            width: 25% !important;
            max-width: 25% !important;
            min-width: 250px !important;
            
            /* Display */
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            
            /* Spacing */
            margin: 0 !important;
            padding: 0 !important;
            
            /* Transform */
            transform: translateX(0) !important;
            transition: none !important;
            
            /* Overflow */
            overflow-y: auto !important;
            overflow-x: hidden !important;
            -webkit-overflow-scrolling: touch !important;
            
            /* Background */
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
        }
        
        /* MAIN CONTENT - Offset by sidebar width */
        .col-md-9.col-lg-10,
        main.col-md-9,
        main.col-md-9.col-lg-10 {
            /* Size */
            flex: 0 0 75% !important;
            width: 75% !important;
            max-width: 75% !important;
            
            /* Position */
            position: relative !important;
            z-index: 1 !important;
            
            /* Offset & Padding */
            margin-left: 25% !important;
            padding-left: 2.5rem !important;
            padding-right: 2.5rem !important;
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
            
            /* Display */
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            
            /* Height */
            min-height: 100vh !important;
            
            /* Background */
            background-color: #ffffff !important;
            box-sizing: border-box !important;
        }
    }
    
    /* ========================================
       DESKTOP LAYOUT (≥ 992px)
       ======================================== */
    @media (min-width: 992px) {
        /* SIDEBAR - Narrower on desktop */
        .col-md-3.col-lg-2.sidebar,
        #guru-sidebar {
            flex: 0 0 16.66666667% !important;
            width: 16.66666667% !important;
            max-width: 16.66666667% !important;
            min-width: 200px !important;
        }
        
        /* MAIN CONTENT - Wider on desktop */
        .col-md-9.col-lg-10,
        main.col-md-9,
        main.col-md-9.col-lg-10 {
            flex: 0 0 83.33333333% !important;
            width: 83.33333333% !important;
            max-width: 83.33333333% !important;
            margin-left: 16.66666667% !important;
            padding-left: 3rem !important;
            padding-right: 3rem !important;
        }
    }
    
    /* ========================================
       SIDEBAR STYLING
       ======================================== */
    .sidebar {
        min-height: 100vh;
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
        background-color: #2E7D32 !important;
    }
    
    /* Ensure all sidebar elements are transparent */
    .sidebar * {
        background-color: transparent !important;
    }
    
    .sidebar .p-4,
    .sidebar nav,
    .sidebar .nav {
        background: transparent !important;
    }
    
    /* Sidebar Navigation Links */
    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        border-radius: 8px;
        margin: 4px 0;
        transition: all 0.3s ease;
        pointer-events: auto !important;
        cursor: pointer !important;
        z-index: 1001 !important;
        position: relative !important;
        display: block !important;
        background: transparent !important;
        background-color: transparent !important;
    }
    
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        color: white !important;
        background: rgba(255, 255, 255, 0.1) !important;
        background-color: rgba(255, 255, 255, 0.1) !important;
        transform: translateX(5px);
    }
    
    /* Ensure nav links are clickable */
    .sidebar .nav-link {
        pointer-events: auto !important;
        cursor: pointer !important;
        touch-action: manipulation !important;
    }
    
    /* ========================================
       CONTENT VISIBILITY
       ======================================== */
    /* Ensure all content is visible */
    .col-md-9.col-lg-10 > *,
    .col-md-9.col-lg-10 .card,
    .col-md-9.col-lg-10 .card-body,
    .col-md-9.col-lg-10 .table,
    .col-md-9.col-lg-10 .alert,
    .col-md-9.col-lg-10 form,
    .col-md-9.col-lg-10 h1,
    .col-md-9.col-lg-10 h2,
    .col-md-9.col-lg-10 h3,
    .col-md-9.col-lg-10 h4,
    .col-md-9.col-lg-10 h5,
    .col-md-9.col-lg-10 p {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    /* ========================================
       RESPONSIVE ADJUSTMENTS
       ======================================== */
    /* Ensure content doesn't shift when sidebar opens on mobile */
    @media (max-width: 767px) {
        .container-fluid .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Prevent body scroll when sidebar is open */
        body.sidebar-open {
            overflow: hidden !important;
        }
    }
    
    /* ========================================
       PRINT STYLES
       ======================================== */
    @media print {
        .sidebar,
        .sidebar-toggle {
            display: none !important;
        }
        
        .col-md-9.col-lg-10,
        main.col-md-9,
        main.col-md-9.col-lg-10 {
            width: 100% !important;
            margin-left: 0 !important;
            padding: 0 !important;
        }
    }
</style>

<script>
    // Toggle Sidebar Function (for mobile)
    function toggleSidebar() {
        const sidebar = document.getElementById('guru-sidebar') || document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const body = document.body;
        
        if (sidebar) {
            sidebar.classList.toggle('show');
        }
        if (overlay) {
            overlay.classList.toggle('show');
        }
        if (body) {
            body.classList.toggle('sidebar-open');
        }
    }
    
    // Close sidebar when clicking outside (mobile)
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }
        
        // Close sidebar when clicking nav link (mobile)
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    setTimeout(toggleSidebar, 200);
                }
            });
        });
    });
</script>
