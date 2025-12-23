@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Materi - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #ffffff !important;
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh !important;
        }
        
        html {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        body {
            overflow-x: hidden;
            position: relative;
            background-color: #ffffff !important;
            background: #ffffff !important;
            color: #000000 !important;
        }
        
        /* Pastikan semua container memiliki background putih */
        .container-fluid,
        .container,
        .row,
        .col-md-9,
        .col-lg-10 {
            background-color: #ffffff !important;
            background: #ffffff !important;
        }
        
        /* Pastikan tombol sidebar-toggle selalu di atas semua elemen */
        .sidebar-toggle {
            position: fixed !important;
            z-index: 99999 !important;
            pointer-events: auto !important;
        }
        
        /* Pastikan YouTube button tidak tertutup oleh sidebar toggle */
        .youtube-btn {
            position: relative !important;
            z-index: 1 !important;
        }
        
        @media (max-width: 991px) {
            /* Di mobile, pastikan YouTube button tidak tertutup */
            .d-flex.justify-content-between.align-items-center.mb-4 {
                padding-left: 60px !important; /* Beri ruang untuk hamburger menu */
            }
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
        
        .sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            z-index: 1061 !important;
        }
        
        #sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            z-index: 1061 !important;
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
            pointer-events: auto;
            transition: background 0.3s ease, opacity 0.3s ease;
            opacity: 0;
        }
        
        .sidebar-overlay.show {
            pointer-events: auto;
            display: block;
            opacity: 1;
            background: rgba(0,0,0,0.05) !important;
            z-index: 1040 !important;
        }
        
        /* Make sure nav links are always clickable */
        .sidebar .nav-link {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1001 !important;
            position: relative !important;
            display: block !important;
            touch-action: manipulation !important;
            -webkit-tap-highlight-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Responsive Styles */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 99999;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            cursor: pointer;
            pointer-events: auto;
            touch-action: manipulation;
            min-width: 48px;
            min-height: 48px;
            font-size: 18px;
            line-height: 1;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            -webkit-user-select: none;
        }
        
        .sidebar-toggle:hover {
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
            transform: scale(1.05);
        }
        
        .sidebar-toggle:active {
            transform: scale(0.95);
            background: linear-gradient(135deg, #0D4A12 0%, #2E7D32 100%);
        }
        
        .sidebar-toggle:focus {
            outline: 2px solid rgba(255,255,255,0.5);
            outline-offset: 2px;
        }
        
        /* Pastikan tombol selalu terlihat di mobile (lebar layar < 992px) */
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                z-index: 99999 !important;
                pointer-events: auto !important;
                position: fixed !important;
                top: 15px !important;
                left: 15px !important;
            }
            
            /* Pastikan container tidak menutupi tombol */
            .container-fluid {
                margin-top: 0 !important;
                padding-top: 0 !important;
                z-index: 1 !important;
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
            
            .sidebar {
                -webkit-overflow-scrolling: touch !important;
                pointer-events: auto !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
            }
            
            .sidebar.show {
                left: 0 !important;
                transform: translateX(0) !important;
                pointer-events: auto !important;
                z-index: 1061 !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            #sidebar.show {
                left: 0 !important;
                transform: translateX(0) !important;
                pointer-events: auto !important;
                z-index: 1061 !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            .sidebar-overlay.show {
                display: block !important;
                opacity: 1 !important;
                background: rgba(0,0,0,0.05) !important;
                z-index: 1040 !important;
            }
            
            .sidebar-overlay {
                z-index: 1040 !important;
            }
            
            /* Pastikan sidebar bisa di-scroll */
            .sidebar.show {
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }
            
            .col-md-9.col-lg-10 {
                width: 100% !important;
                margin-left: 0 !important;
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
        
        /* Ensure sidebar is always above overlay */
        .sidebar.show {
            z-index: 1061 !important;
        }
        
        /* Header Section Styling */
        .header-section {
            position: relative;
            z-index: 1;
            width: 100%;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .header-title-section {
            flex: 1;
            min-width: 200px;
        }
        
        .header-title-section h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        
        .header-title-section p {
            font-size: 0.95rem;
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        /* YouTube Button Styling */
        .youtube-btn {
            background-color: #FF0000 !important;
            border-color: #FF0000 !important;
            color: white !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 10px 18px !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            white-space: nowrap !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(255, 0, 0, 0.3) !important;
            position: relative !important;
            z-index: 10 !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
        }
        
        .youtube-btn:hover {
            background-color: #CC0000 !important;
            border-color: #CC0000 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.4) !important;
        }
        
        .youtube-btn:active {
            transform: translateY(0);
        }
        
        .youtube-btn i {
            font-size: 18px !important;
        }
        
        /* RPP Button Styling */
        .rpp-btn {
            background-color: #1976D2 !important;
            border-color: #1976D2 !important;
            color: white !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 10px 18px !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            white-space: nowrap !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(25, 118, 210, 0.3) !important;
            position: relative !important;
            z-index: 10 !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
        }
        
        .rpp-btn:hover {
            background-color: #1565C0 !important;
            border-color: #1565C0 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.4) !important;
        }
        
        .rpp-btn:active {
            transform: translateY(0);
        }
        
        .rpp-btn i {
            font-size: 18px !important;
        }
        
        .btn-success {
            padding: 10px 18px !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(46, 125, 50, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.4) !important;
        }

        /* RPP Dropdown Styling */
        .rpp-btn.dropdown-toggle {
            border: none;
        }

        .rpp-btn.dropdown-toggle::after {
            margin-left: 8px;
            vertical-align: middle;
        }

        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: 1px solid rgba(0,0,0,0.1);
            padding: 8px 0;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            padding-left: 25px;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 8px 0;
        }
        
        /* Responsive Design */
        @media (max-width: 991px) {
            .header-content {
                margin-left: 60px;
            }
            
            .header-title-section h2 {
                font-size: 1.5rem;
            }
            
            .header-title-section p {
                font-size: 0.85rem;
            }
            
            .youtube-btn {
                padding: 8px 14px !important;
                font-size: 13px !important;
            }
            
            .youtube-btn i {
                font-size: 16px !important;
            }
            
            .youtube-btn span {
                display: none;
            }
            
            .rpp-btn {
                padding: 8px 14px !important;
                font-size: 13px !important;
            }
            
            .rpp-btn i {
                font-size: 16px !important;
            }
            
            .rpp-btn span {
                display: none;
            }
            
            .btn-success {
                padding: 8px 14px !important;
                font-size: 13px !important;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                margin-left: 60px;
            }
            
            .header-title-section {
                width: 100%;
            }
            
            .header-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .youtube-btn,
            .rpp-btn,
            .btn-success {
                flex: 1;
                min-width: 120px;
                justify-content: center;
            }
        }
        
        @media (max-width: 576px) {
            .header-content {
                margin-left: 0;
                padding-top: 10px;
            }
            
            .header-title-section h2 {
                font-size: 1.25rem;
            }
            
            .header-actions {
                width: 100%;
                gap: 8px;
            }
            
            .youtube-btn {
                padding: 8px 12px !important;
                font-size: 12px !important;
            }
            
            .youtube-btn i {
                font-size: 14px !important;
                margin-right: 0 !important;
            }
            
            .rpp-btn {
                padding: 8px 12px !important;
                font-size: 12px !important;
            }
            
            .rpp-btn i {
                font-size: 14px !important;
                margin-right: 0 !important;
            }
            
            .btn-success {
                padding: 8px 12px !important;
                font-size: 12px !important;
            }
        }
        
        /* Search and Filter Form Styling */
        .search-filter-form .form-label {
            color: #495057;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .search-filter-form .form-control,
        .search-filter-form .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .search-filter-form .form-control:focus,
        .search-filter-form .form-select:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
            outline: none;
        }
        
        .search-filter-form .btn-primary,
        .search-filter-form .btn-success {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(46, 125, 50, 0.3);
            transition: all 0.3s ease;
            color: white;
        }
        
        .search-filter-form .btn-primary:hover,
        .search-filter-form .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.4);
            background: linear-gradient(135deg, #1B5E20 0%, #388E3C 100%);
        }
        
        /* Pastikan form elements sejajar horizontal */
        .search-filter-form .d-flex {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: flex-end !important;
        }
        
        .search-filter-form .gap-3 {
            gap: 1rem !important;
        }
        
        @media (max-width: 768px) {
            .search-filter-form .d-flex {
                flex-direction: column !important;
            }
            
            .search-filter-form .d-flex > div {
                width: 100% !important;
                min-width: 100% !important;
            }
        }

        /* ===== PERTEMUAN TRACKING STYLES ===== */
        .pertemuan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .pertemuan-btn {
            background: #fff;
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .pertemuan-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .pertemuan-btn.selesai {
            background: #d4edda;
            border-color: #28a745;
        }

        .pertemuan-number {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }

        .pertemuan-status {
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .pertemuan-btn:not(.selesai) .pertemuan-status {
            color: #dc3545;
        }

        .pertemuan-btn.selesai .pertemuan-status {
            color: #28a745;
        }

        .pertemuan-btn:not(.selesai) .pertemuan-status i {
            color: #dc3545;
        }

        .pertemuan-btn.selesai .pertemuan-status i {
            color: #28a745;
        }

        @media (max-width: 576px) {
            .pertemuan-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 10px;
            }

            .pertemuan-btn {
                padding: 12px;
            }

            .pertemuan-number {
                font-size: 12px;
            }

            .pertemuan-status {
                font-size: 11px;
            }
        }
    </style>
    @include('partials.guru-dynamic-ui')
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid" style="position: relative; z-index: 1;">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="container-fluid py-4">
                    <div class="header-section mb-4">
                        <div class="header-content">
                            <div class="header-title-section">
                                <h2 class="mb-1">Manajemen Materi</h2>
                                <p class="text-muted mb-0">Kelola materi pembelajaran Anda</p>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('guru.materi.index') }}" class="search-filter-form">
                                @if(request('mata_pelajaran'))
                                    <input type="hidden" name="mata_pelajaran" value="{{ request('mata_pelajaran') }}">
                                @endif
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="flex-grow-1" style="min-width: 200px;">
                                        <label class="form-label fw-semibold mb-1">
                                            <i class="fas fa-search me-1"></i>Q Cari Materi
                                        </label>
                                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari materi...">
                                    </div>
                                    <div style="min-width: 180px;">
                                        <label class="form-label fw-semibold mb-1">
                                            <i class="fas fa-users me-1"></i>Kelas
                                        </label>
                                        <select class="form-select" name="kelas" id="kelas-filter" onchange="this.form.submit()">
                                            <option value="">Semua Kelas</option>
                                            <option value="7" {{ request('kelas') == '7' ? 'selected' : '' }}>Kelas 7</option>
                                            <option value="8" {{ request('kelas') == '8' ? 'selected' : '' }}>Kelas 8</option>
                                            <option value="9" {{ request('kelas') == '9' ? 'selected' : '' }}>Kelas 9</option>
                                        </select>
                                    </div>
                                    <div style="min-width: 180px;">
                                        <label class="form-label fw-semibold mb-1">
                                            <i class="fas fa-tag me-1"></i>Topik
                                        </label>
                                        <input type="text" class="form-control" name="topik" value="{{ request('topik') }}" placeholder="Topik...">
                                    </div>
                                    <div style="min-width: 120px;">
                                        <label class="form-label fw-semibold mb-1 d-block">&nbsp;</label>
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-search me-1"></i> Q Cari
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2" style="min-width: 350px;">
                                        <label class="form-label fw-semibold mb-1 d-block w-100">&nbsp;</label>
                                        <div class="d-flex gap-2 w-100">
                                            {{-- RPP Dropdown --}}
                                            <div class="dropdown flex-grow-1">
                                                <button class="rpp-btn dropdown-toggle w-100 text-center" type="button" 
                                                        id="rppDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-file-alt me-2"></i>
                                                    <span>RPP</span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="rppDropdown">
                                                    <li>
                                                        <a class="dropdown-item" href="https://s.id/mtsnurulaiman" target="_blank">
                                                            <i class="fas fa-school me-2 text-primary"></i>
                                                            MTs Nurul Aiman
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="https://drive.google.com" target="_blank">
                                                            <i class="fab fa-google-drive me-2 text-success"></i>
                                                            Google Drive
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="https://www.kemdikbud.go.id" target="_blank">
                                                            <i class="fas fa-landmark me-2 text-danger"></i>
                                                            Kemdikbud
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="https://guruberbagi.kemdikbud.go.id" target="_blank">
                                                            <i class="fas fa-users me-2 text-warning"></i>
                                                            Guru Berbagi
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <a href="https://www.youtube.com" target="_blank" class="youtube-btn flex-grow-1 text-center">
                                                <i class="fab fa-youtube me-2"></i>
                                                <span>YouTube</span>
                                            </a>
                                            <a href="{{ route('guru.materi.create') }}" class="btn btn-success flex-grow-1">
                                                <i class="fas fa-plus me-2"></i> Tambah Materi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Materi List -->
                    @if($materi->count() > 0)
                        <div class="row">
                            @foreach($materi as $item)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->judul }}</h5>
                                            <p class="card-text text-muted small">{{ Str::limit($item->deskripsi, 100) }}</p>
                                            
                                            @if($item->file_path)
                                                @php
                                                    $extension = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                                                    $iconClass = 'fas fa-file';
                                                    $iconBg = 'file-document';
                                                    if (in_array($extension, ['pdf'])) {
                                                        $iconClass = 'fas fa-file-pdf';
                                                        $iconBg = 'file-pdf';
                                                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                        $iconClass = 'fas fa-file-image';
                                                        $iconBg = 'file-image';
                                                    } elseif (in_array($extension, ['doc', 'docx'])) {
                                                        $iconClass = 'fas fa-file-word';
                                                        $iconBg = 'file-document';
                                                    }
                                                @endphp
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="file-icon {{ $iconBg }} me-2">
                                                        <i class="{{ $iconClass }}"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted d-block">{{ $item->file_type }}</small>
                                                        <small class="text-muted">{{ $item->file_size_formatted }}</small>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($item->link_video)
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="file-icon file-video me-2">
                                                            <i class="fas fa-video"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <small class="text-muted">Video Pembelajaran</small>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $videoUrl = $item->link_video;
                                                        // Convert to watch URL if it's an embed URL
                                                        if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                                            $videoUrl = 'https://www.youtube.com/watch?v=' . $matches[1];
                                                        } elseif (strpos($videoUrl, 'youtube.com/watch') === false && strpos($videoUrl, 'youtu.be') === false) {
                                                            // If it's not a standard YouTube URL, try to extract video ID
                                                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                                                $videoUrl = 'https://www.youtube.com/watch?v=' . $matches[1];
                                                            }
                                                        }
                                                        // Ensure it's a valid YouTube URL
                                                        if (strpos($videoUrl, 'youtube.com') === false && strpos($videoUrl, 'youtu.be') === false) {
                                                            $videoUrl = 'https://www.youtube.com';
                                                        }
                                                    @endphp
                                                    <a href="{{ $videoUrl }}" target="_blank" class="btn btn-danger btn-sm" style="background-color: #FF0000 !important; border-color: #FF0000 !important; color: white !important; display: inline-flex !important; align-items: center !important; padding: 6px 12px !important; text-decoration: none !important; font-weight: 500 !important;">
                                                        <span style="margin-right: 5px; font-size: 16px;">▶</span>
                                                        <i class="fab fa-youtube me-1" style="font-size: 16px !important;"></i>
                                                        <span>YouTube</span>
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="d-flex flex-wrap gap-1 mb-3">
                                                <span class="badge bg-light text-dark">{{ $item->kelas }}</span>
                                                <span class="badge bg-light text-dark">{{ $item->topik }}</span>
                                                @if($item->is_published)
                                                    <span class="status-badge status-published">Dipublikasi</span>
                                                @else
                                                    <span class="status-badge status-draft">Draft</span>
                                                @endif
                                            </div>

                                            {{-- Progress Pertemuan --}}
                                            @if($item->jumlah_pertemuan > 0)
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <small class="text-muted fw-semibold">
                                                            <i class="fas fa-chalkboard-teacher me-1"></i>
                                                            Progress Pertemuan
                                                        </small>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                                onclick="openPertemuanModal({{ $item->id }}, '{{ $item->judul }}', {{ $item->jumlah_pertemuan }}, {{ json_encode($item->pertemuan_selesai ?? []) }})"
                                                                style="padding: 2px 8px; font-size: 11px;">
                                                            <i class="fas fa-edit me-1"></i>Update
                                                        </button>
                                                    </div>
                                                    
                                                    {{-- Progress Bar --}}
                                                    @php
                                                        $persentase = $item->persentase_selesai ?? 0;
                                                        $selesai = $item->jumlah_selesai ?? 0;
                                                        $belum = $item->jumlah_belum_selesai ?? $item->jumlah_pertemuan;
                                                    @endphp
                                                    
                                                    <div class="progress mb-2" style="height: 20px; border-radius: 10px;">
                                                        <div class="progress-bar bg-success" role="progressbar" 
                                                             style="width: {{ $persentase }}%;" 
                                                             aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100">
                                                            <small class="fw-semibold">{{ $persentase }}%</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex gap-2">
                                                            <span class="badge" style="background-color: #28a745; color: white;">
                                                                <i class="fas fa-check-circle me-1"></i>
                                                                {{ $selesai }} Selesai
                                                            </span>
                                                            <span class="badge" style="background-color: #dc3545; color: white;">
                                                                <i class="fas fa-times-circle me-1"></i>
                                                                {{ $belum }} Belum
                                                            </span>
                                                        </div>
                                                        <small class="text-muted">{{ $item->jumlah_pertemuan }} Total</small>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $item->created_at->format('d M Y') }}
                                            </small>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('guru.materi.show', $item) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                                <a href="{{ route('guru.materi.edit', $item) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $materi->links() }}
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada materi</h5>
                                <p class="text-muted">Mulai tambahkan materi pembelajaran untuk siswa Anda</p>
                                <a href="{{ route('guru.materi.create') }}" class="btn btn-success mt-3">
                                    <i class="fas fa-plus me-2"></i> Tambah Materi Pertama
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tracking Pertemuan --}}
    <div class="modal fade" id="pertemuanModal" tabindex="-1" aria-labelledby="pertemuanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="pertemuanModalLabel">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Tracking Pertemuan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3" id="modalMateriJudul"></h6>
                        
                        {{-- Progress Summary --}}
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center py-3">
                                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                                        <h3 class="mb-0" id="modalSelesai">0</h3>
                                        <small>Selesai</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center py-3">
                                        <i class="fas fa-times-circle fa-2x mb-2"></i>
                                        <h3 class="mb-0" id="modalBelum">0</h3>
                                        <small>Belum</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center py-3">
                                        <i class="fas fa-chart-pie fa-2x mb-2"></i>
                                        <h3 class="mb-0" id="modalPersentase">0%</h3>
                                        <small>Progress</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Progress Keseluruhan</label>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" role="progressbar" id="modalProgressBar" 
                                     style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    0%
                                </div>
                            </div>
                        </div>

                        {{-- Grid Pertemuan --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Klik untuk mengubah status pertemuan:</label>
                            <div id="pertemuanGrid" class="pertemuan-grid"></div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>
                                <strong>Petunjuk:</strong> Klik pada kotak pertemuan untuk menandai sebagai selesai (hijau) atau belum (merah).
                                Perubahan akan tersimpan otomatis.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                </div>
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
                // Prevent body scroll when sidebar is open - TAPI tetap putih
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
                document.body.style.background = '#ffffff';
                document.body.style.backgroundColor = '#ffffff';
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
            // Pastikan background tetap putih
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
            // Always reset body styles regardless of screen size
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
        }
        
        // Robust function to setup nav links - TIDAK CLONE, biarkan href normal bekerja
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
        
        // Ensure body has white background on page load - ULTRA AGGRESSIVE
        function forceWhiteBackground() {
            document.documentElement.style.setProperty('background-color', '#ffffff', 'important');
            document.documentElement.style.setProperty('background', '#ffffff', 'important');
            document.body.style.setProperty('background-color', '#ffffff', 'important');
            document.body.style.setProperty('background', '#ffffff', 'important');
            document.body.style.setProperty('color', '#000000', 'important');
            
            // Pastikan container juga putih
            const containers = document.querySelectorAll('.container-fluid, .container, .row, .col-md-9, .col-lg-10');
            containers.forEach(function(container) {
                container.style.setProperty('background-color', '#ffffff', 'important');
                container.style.setProperty('background', '#ffffff', 'important');
            });
        }
        
        // Jalankan segera
        forceWhiteBackground();
        
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            forceWhiteBackground();
            
            // Setup nav links
            setupNavLinks();
            
            // Setup ulang setelah sidebar dibuka
            const observer = new MutationObserver(function(mutations) {
                setupNavLinks();
            });
            
            const sidebar = document.getElementById('guru-sidebar');
            if (sidebar) {
                observer.observe(sidebar, {
                    childList: true,
                    subtree: true
                });
            }
        });
        
        // Jalankan lagi setelah page load
        window.addEventListener('load', function() {
            forceWhiteBackground();
            setTimeout(forceWhiteBackground, 100);
            setTimeout(forceWhiteBackground, 500);
        });
        
        // Jalankan setiap kali ada perubahan (untuk memastikan) - hanya 5 detik pertama
        let intervalCount = 0;
        const backgroundInterval = setInterval(function() {
            forceWhiteBackground();
            intervalCount++;
            if (intervalCount >= 5) {
                clearInterval(backgroundInterval);
            }
        }, 1000);

        // ===== TRACKING PERTEMUAN FUNCTIONS =====
        let currentMateriId = null;
        let currentPertemuanSelesai = [];

        function openPertemuanModal(materiId, judul, jumlahPertemuan, pertemuanSelesai) {
            currentMateriId = materiId;
            currentPertemuanSelesai = pertemuanSelesai || [];
            
            document.getElementById('modalMateriJudul').textContent = judul;
            
            // Generate grid pertemuan
            const grid = document.getElementById('pertemuanGrid');
            grid.innerHTML = '';
            
            for (let i = 1; i <= jumlahPertemuan; i++) {
                const isSelesai = currentPertemuanSelesai.includes(i);
                const btn = document.createElement('button');
                btn.className = 'pertemuan-btn';
                btn.dataset.pertemuan = i;
                btn.innerHTML = `
                    <div class="pertemuan-number">Pertemuan ${i}</div>
                    <div class="pertemuan-status">
                        <i class="fas ${isSelesai ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                        ${isSelesai ? 'Selesai' : 'Belum'}
                    </div>
                `;
                
                if (isSelesai) {
                    btn.classList.add('selesai');
                }
                
                btn.onclick = function() {
                    togglePertemuan(i);
                };
                
                grid.appendChild(btn);
            }
            
            updateModalStats();
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('pertemuanModal'));
            modal.show();
        }

        function togglePertemuan(nomorPertemuan) {
            // Toggle di array lokal
            const index = currentPertemuanSelesai.indexOf(nomorPertemuan);
            if (index > -1) {
                currentPertemuanSelesai.splice(index, 1);
            } else {
                currentPertemuanSelesai.push(nomorPertemuan);
            }
            
            // Update UI button
            const btn = document.querySelector(`[data-pertemuan="${nomorPertemuan}"]`);
            const isSelesai = currentPertemuanSelesai.includes(nomorPertemuan);
            
            if (isSelesai) {
                btn.classList.add('selesai');
                btn.querySelector('.pertemuan-status').innerHTML = `
                    <i class="fas fa-check-circle"></i>
                    Selesai
                `;
            } else {
                btn.classList.remove('selesai');
                btn.querySelector('.pertemuan-status').innerHTML = `
                    <i class="fas fa-times-circle"></i>
                    Belum
                `;
            }
            
            updateModalStats();
            
            // Send AJAX request to backend
            fetch(`/guru/materi/${currentMateriId}/toggle-pertemuan`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    nomor_pertemuan: nomorPertemuan
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Pertemuan updated successfully');
                    // Reload page setelah 500ms untuk update card
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data');
            });
        }

        function updateModalStats() {
            const selesai = currentPertemuanSelesai.length;
            const total = document.querySelectorAll('.pertemuan-btn').length;
            const belum = total - selesai;
            const persentase = total > 0 ? Math.round((selesai / total) * 100) : 0;
            
            document.getElementById('modalSelesai').textContent = selesai;
            document.getElementById('modalBelum').textContent = belum;
            document.getElementById('modalPersentase').textContent = persentase + '%';
            
            // Update progress bar
            const progressBar = document.getElementById('modalProgressBar');
            progressBar.style.width = persentase + '%';
            progressBar.textContent = persentase + '%';
        }
    </script>
</body>
</html>