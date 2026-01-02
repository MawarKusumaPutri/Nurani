<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TU Dashboard - TMS NURANI')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Ensure sidebar content is scrollable */
        #tu-sidebar {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        #tu-sidebar .p-4 {
            flex-shrink: 0;
        }
        
        #tu-sidebar nav {
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
        
        /* Prevent any wrapping or multi-column layout */
        @media (max-width: 991px) {
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
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        /* Dropdown submenu styling */
        .sidebar .nav-item.dropdown {
            width: 100%;
        }
        
        .sidebar .dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }
        
        .sidebar .dropdown-toggle::after {
            display: none; /* Hide default Bootstrap arrow */
        }
        
        .sidebar .dropdown-toggle .fa-chevron-down {
            transition: transform 0.3s ease;
        }
        
        .sidebar .dropdown-toggle[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }
        
        .sidebar .submenu-link {
            font-size: 0.9rem;
            padding: 10px 15px;
            padding-left: 45px;
            color: rgba(255, 255, 255, 0.7);
            background: rgba(0, 0, 0, 0.1);
        }
        
        .sidebar .submenu-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(3px);
        }
        
        .sidebar .submenu-link.active {
            color: #2E7D32 !important;
            background: rgba(255, 255, 255, 0.95) !important;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar #suratSubmenu {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            margin-top: 5px;
        }
        
        .profile-circle {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 40px;
            color: white;
            border: 3px solid rgba(255,255,255,0.3);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        .card-header {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
        }
        
        .badge {
            font-size: 0.8em;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
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
            
            #tu-sidebar {
                height: 100vh;
                overflow-y: auto;
                overflow-x: hidden;
                -webkit-overflow-scrolling: touch;
            }
            
            #tu-sidebar nav {
                max-height: calc(100vh - 250px);
                overflow-y: auto;
                overflow-x: hidden;
                -webkit-overflow-scrolling: touch;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .col-md-9, .col-lg-10 {
                width: 100%;
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 15px;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .btn {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
            
            .h2 {
                font-size: 1.5rem;
            }
            
            .fa-3x {
                font-size: 2rem !important;
            }
        }
        
        @media (max-width: 576px) {
            .col-md-3 {
                width: 100%;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn-toolbar {
                width: 100%;
            }
            
            .btn-group {
                width: 100%;
            }
            
            .btn-group .btn {
                width: 100%;
            }
            
            .px-md-4 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
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
            const sidebar = document.querySelector('.sidebar');
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
    @yield('scripts')
</body>
</html>
