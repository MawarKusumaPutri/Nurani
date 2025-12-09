@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Guru - {{ $guru->user->name }}</title>
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
        
        /* Layout - sama seperti dashboard (biarkan Bootstrap yang mengatur) */
        /* Pastikan di desktop, konten di samping sidebar */
        @media (min-width: 768px) {
            .container-fluid > .row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }
            
            /* Pastikan sidebar menggunakan ukuran Bootstrap default - Medium screen */
            .col-md-3.col-lg-2.sidebar {
                flex: 0 0 auto !important;
                width: 25% !important; /* col-md-3 = 25% */
                max-width: 25% !important;
            }
            
            .col-md-9.col-lg-10 {
                flex: 0 0 auto !important;
                width: 75% !important; /* col-md-9 = 75% */
            }
        }
        
        /* Large screen - sidebar lebih kecil */
        @media (min-width: 992px) {
            .col-md-3.col-lg-2.sidebar {
                width: 16.66666667% !important; /* col-lg-2 = 16.67% */
                max-width: 16.66666667% !important;
            }
            
            .col-md-9.col-lg-10 {
                width: 83.33333333% !important; /* col-lg-10 = 83.33% */
            }
        }
        
        /* Layout 2 Kolom untuk konten di dalam main content */
        .col-lg-5, .col-lg-7 {
            padding-left: 15px;
            padding-right: 15px;
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
        
        /* Reduce spacing to move content up */
        .mb-4 {
            margin-bottom: 1rem !important;
        }
        
        .mb-3 {
            margin-bottom: 0.75rem !important;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem !important;
        }
        
        /* Reduce spacing pada form sections */
        #jam-section,
        #keterangan-section,
        #surat-sakit-section,
        #tugas-section {
            margin-bottom: 1rem !important;
            transition: all 0.3s ease !important;
        }
        
        /* Styling untuk section tugas ketika muncul */
        #tugas-section[style*="display: block"] {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Highlight untuk section tugas */
        #tugas-section.highlight-sakit {
            border: 2px solid #dc3545 !important;
            border-radius: 8px !important;
            padding: 1rem !important;
            background-color: #fff5f5 !important;
        }
        
        #tugas-section.highlight-izin {
            border: 2px solid #ffc107 !important;
            border-radius: 8px !important;
            padding: 1rem !important;
            background-color: #fffbf0 !important;
        }
        
        /* Reduce padding pada card-body */
        .card-body {
            padding: 1rem !important;
        }
        
        /* Reduce spacing pada row dengan gap */
        .row.g-3 {
            margin-left: -10px !important;
            margin-right: -10px !important;
        }
        
        .row.g-3 > * {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        
        /* Pastikan row untuk tugas pengganti horizontal di desktop */
        #tugas-section > .row {
            display: flex !important;
            flex-wrap: nowrap !important;
            margin-left: -10px !important;
            margin-right: -10px !important;
            width: 100% !important;
        }
        
        #tugas-section > .row > .col-md-4 {
            flex: 0 0 33.333333% !important;
            width: 33.333333% !important;
            max-width: 33.333333% !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
            float: none !important;
            display: block !important;
            position: relative !important;
        }
        
        /* Pastikan card memiliki tinggi yang sama */
        #tugas-section .card {
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
        }
        
        #tugas-section .card-body {
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
        }
        
        #tugas-section .tugas-textarea {
            flex: 1 !important;
        }
        
        /* Di mobile, tetap vertikal */
        @media (max-width: 767px) {
            #tugas-section > .row {
                flex-wrap: wrap !important;
            }
            
            #tugas-section > .row > .col-md-4 {
                flex: 0 0 100% !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        
        /* Reduce spacing pada textarea */
        textarea {
            margin-bottom: 0.5rem !important;
        }
        
        /* Reduce spacing pada small text */
        small.text-muted {
            margin-top: 0.25rem !important;
            margin-bottom: 0.25rem !important;
        }
        
        /* Reduce header margin */
        .col-md-9.col-lg-10 > .d-flex.mb-2,
        .col-md-9.col-lg-10 > .d-flex.mb-3 {
            margin-bottom: 0.5rem !important;
        }
        
        /* Reduce alert margin */
        .alert.mb-2,
        .alert.mb-3 {
            margin-bottom: 0.5rem !important;
        }
        
        /* Ensure layout columns are side by side */
        @media (min-width: 992px) {
            .row > .col-lg-5:not(:has(.presensi-type-card)) {
                width: 41.666667% !important;
                float: left !important;
                display: block !important;
            }
            .row > .col-lg-7:not(:has(.presensi-type-card)) {
                width: 58.333333% !important;
                float: left !important;
                display: block !important;
            }
        }
        
        /* Ensure layout 2 kolom is visible */
        .row > .col-lg-5:not(:has(.presensi-type-card)),
        .row > .col-lg-7:not(:has(.presensi-type-card)),
        .row > .col-md-12 {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            float: none !important;
        }
        
        @media (min-width: 992px) {
            .row > .col-lg-5:not(:has(.presensi-type-card)) {
                width: 41.666667% !important;
                float: left !important;
                display: block !important;
            }
            .row > .col-lg-7:not(:has(.presensi-type-card)) {
                width: 58.333333% !important;
                float: left !important;
                display: block !important;
            }
        }
        
        /* Pastikan jenis presensi TIDAK menggunakan float */
        .row:has(.presensi-type-card) > .col-md-4,
        .mb-2 > .row:has(.presensi-type-card) > .col-md-4,
        .mb-3 > .row:has(.presensi-type-card) > .col-md-4 {
            float: none !important;
        }
        
        /* Force all content to be visible */
        #presensiFormCard,
        .card,
        .card-header,
        .card-body,
        .table-responsive,
        .table,
        .alert {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Ensure all cards are visible */
        .card {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            margin-bottom: 1rem !important;
        }
        
        /* Ensure all content sections are visible */
        .card-header,
        .card-body,
        .table-responsive,
        .alert,
        h2,
        h4,
        h5,
        p,
        .mb-4,
        .d-flex {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .d-flex {
            display: flex !important;
            visibility: visible !important;
        }
        
        /* Ensure buttons are visible */
        .btn,
        button {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Ensure table is visible */
        .table,
        .table-responsive,
        table {
            display: table !important;
            visibility: visible !important;
            opacity: 1 !important;
            width: 100% !important;
        }
        
        /* Ensure all text is visible */
        h2, h4, h5, p, small, span, div, label, th, td {
            color: inherit !important;
            visibility: visible !important;
        }
        
        /* Presensi Form Card - shown by default */
        #presensiFormCard {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            overflow: visible !important;
        }
        
        #presensiFormCard.hide {
            display: none !important;
        }
        
        /* Pastikan card-body tidak memotong konten */
        #presensiFormCard .card-body {
            overflow: visible !important;
        }
        
        /* Ensure form is always visible when not hidden */
        #presensiFormCard:not(.hide) {
            display: block !important;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Pastikan sidebar tidak memaksa konten ke bawah di desktop */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar {
                position: relative !important;
                float: none !important;
            }
        }
        
        /* Ensure sidebar content is scrollable */
        #guru-sidebar {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
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
        }
        
        #sidebar.show {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
            background-color: #2E7D32 !important;
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
        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 8px;
        }
        .presensi-type-card {
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease !important;
            border: 2px solid #e0e0e0 !important;
            height: 100% !important;
            position: relative !important;
            z-index: 1 !important;
            overflow: visible !important;
            min-height: 100px !important;
            max-height: 100px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            padding: 0 !important;
            flex: 0 0 auto !important;
            transform: none !important;
            scale: 1 !important;
        }
        
        /* Pastikan card jenis presensi tidak menggunakan float */
        .presensi-type-card,
        .col-md-4:has(.presensi-type-card) {
            float: none !important;
        }
        .presensi-type-card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
            z-index: 2 !important;
            border: 2px solid #e0e0e0 !important;
            width: 100% !important;
            height: 100% !important;
            min-height: 100px !important;
            max-height: 100px !important;
            box-sizing: border-box !important;
            scale: 1 !important;
        }
        .presensi-type-card.active {
            border: 2px solid #2E7D32 !important;
            background: #F0F4F0 !important;
            /* Pastikan ukuran tetap sama - TIDAK BERUBAH */
            width: 100% !important;
            height: 100% !important;
            min-height: 100px !important;
            max-height: 100px !important;
            box-sizing: border-box !important;
            transform: none !important;
            scale: 1 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Perkecil ukuran card jenis presensi */
        .presensi-type-card .card-body {
            padding: 0.5rem !important;
        }
        
        .presensi-type-card i.fa-3x,
        .presensi-type-card i[class*="fa-"] {
            font-size: 1.5rem !important;
        }
        
        .presensi-type-card h6 {
            font-size: 0.85rem !important;
            margin-bottom: 0 !important;
        }
        
        /* Perkecil ukuran col untuk jenis presensi - pastikan ukuran tetap sama */
        .jenis-presensi-col {
            flex: 0 0 25% !important;
            width: 25% !important;
            max-width: 25% !important;
            min-width: 25% !important;
            box-sizing: border-box !important;
            display: flex !important;
            align-items: stretch !important;
        }
        
        /* Pastikan card di dalam col memiliki ukuran yang sama */
        .jenis-presensi-col > .presensi-type-card {
            width: 100% !important;
            height: 100% !important;
            min-height: 100px !important;
            max-height: 100px !important;
        }
        
        /* Pastikan semua card jenis presensi memiliki ukuran yang sama - FIXED SIZE */
        #card-hadir,
        #card-sakit,
        #card-izin {
            width: 100% !important;
            height: 100% !important;
            min-height: 100px !important;
            max-height: 100px !important;
            box-sizing: border-box !important;
            border: 2px solid #e0e0e0 !important;
            margin: 0 !important;
            padding: 0 !important;
            flex: 0 0 auto !important;
            transform: none !important;
            scale: 1 !important;
        }
        
        #card-hadir.active,
        #card-sakit.active,
        #card-izin.active {
            border: 2px solid #2E7D32 !important;
            background: #F0F4F0 !important;
            /* Ukuran tetap sama - TIDAK BERUBAH SAMA SEKALI */
            width: 100% !important;
            height: 100% !important;
            min-height: 100px !important;
            max-height: 100px !important;
            box-sizing: border-box !important;
            transform: none !important;
            scale: 1 !important;
            margin: 0 !important;
            padding: 0 !important;
            flex: 0 0 auto !important;
        }
        
        /* Tambahkan gap kecil antar card */
        #jenis-presensi-row {
            gap: 10px !important;
        }
        
        /* Pastikan container untuk jenis presensi tidak memotong konten */
        .mb-3:has(.presensi-type-card),
        .mb-3 > .row:has(.presensi-type-card) {
            overflow: visible !important;
            width: 100% !important;
        }
        
        /* Pastikan semua card jenis presensi tidak tertutup */
        #card-hadir,
        #card-sakit,
        #card-izin {
            position: relative !important;
            z-index: 1 !important;
            overflow: visible !important;
        }
        
        /* Pastikan card-body tidak memotong konten */
        .presensi-type-card .card-body {
            overflow: visible !important;
            position: relative !important;
        }
        
        /* Pastikan container card tidak memotong */
        .card {
            overflow: visible !important;
        }
        
        /* Pastikan col-md-4 tidak memotong konten */
        .row > .col-md-4:has(.presensi-type-card) {
            overflow: visible !important;
        }
        
        /* Pastikan jenis presensi muncul horizontal - CSS yang sangat kuat */
        /* Menggunakan ID spesifik untuk memastikan tidak ada konflik */
        #jenis-presensi-row {
            display: flex !important;
            flex-wrap: nowrap !important;
            justify-content: center !important;
            align-items: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: auto !important;
            max-width: 90% !important;
            gap: 10px !important;
        }
        
        .jenis-presensi-col {
            flex: 0 0 25% !important;
            width: 25% !important;
            max-width: 25% !important;
            float: none !important;
            display: block !important;
        }
        
        /* CSS untuk jenis presensi - menggunakan ID dan class yang spesifik */
        #card-hadir,
        #card-sakit,
        #card-izin {
            float: none !important;
        }
        
        /* Override semua CSS yang mungkin mengganggu untuk desktop */
        @media (min-width: 768px) {
            #jenis-presensi-row {
                display: flex !important;
                flex-wrap: nowrap !important;
                justify-content: center !important;
                align-items: center !important;
                margin-left: auto !important;
                margin-right: auto !important;
                width: auto !important;
                max-width: 90% !important;
                gap: 10px !important;
            }
            
            .jenis-presensi-col {
                flex: 0 0 25% !important;
                width: 25% !important;
                max-width: 25% !important;
                float: none !important;
            }
        }
        
        /* Di mobile, jenis presensi tetap vertical */
        @media (max-width: 767px) {
            #jenis-presensi-row {
                flex-wrap: wrap !important;
            }
            
            .jenis-presensi-col {
                flex: 0 0 100% !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        
        /* Styling untuk sidebar presensi */
        #presensi-sidebar {
            transition: all 0.3s ease;
            animation: slideIn 0.3s ease;
            position: relative !important;
            z-index: 10 !important;
        }
        
        #presensi-sidebar[style*="display: block"] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        #presensi-sidebar .card {
            border-width: 2px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        }
        
        #presensi-sidebar .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
        
        /* Pastikan form main section responsive */
        #form-main-section {
            transition: all 0.3s ease;
        }
        
        /* Pastikan row container menggunakan flexbox dengan benar */
        .row:has(#form-main-section):has(#presensi-sidebar) {
            display: flex !important;
            flex-wrap: nowrap !important;
        }
        
        @media (min-width: 992px) {
            #presensi-sidebar.col-lg-5 {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                flex: 0 0 41.666667% !important;
                max-width: 41.666667% !important;
            }
            
            #form-main-section.col-lg-7 {
                flex: 0 0 58.333333% !important;
                max-width: 58.333333% !important;
            }
        }
        
        @media (max-width: 991px) {
            #presensi-sidebar {
                margin-top: 1rem;
            }
            
            #form-main-section.col-lg-7,
            #presensi-sidebar.col-lg-5 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
            }
        }
        .badge-hadir { background: #28a745; }
        .badge-sakit { background: #dc3545; }
        .badge-izin { background: #ffc107; color: #000; }
        .badge-pending { background: #6c757d; }
        .badge-approved { background: #28a745; }
        .badge-rejected { background: #dc3545; }
        
        /* Responsive Styles */
        .sidebar-toggle {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: -1;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            cursor: pointer;
            pointer-events: none;
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
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
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
                display: none !important;
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
                overscroll-behavior: contain !important;
                pointer-events: auto !important;
                background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%) !important;
                background-color: #2E7D32 !important;
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
            
            .col-md-9.col-lg-10 {
                width: 100% !important;
                margin-left: 0 !important;
            }
            
            .col-md-3.col-lg-2.sidebar {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                            <div>
                                <strong>Periksa kembali formulir presensi:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Header Manajemen Presensi -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="mb-1" style="font-size: 1.5rem; font-weight: 600;">Manajemen Presensi</h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">Kelola presensi Anda untuk berbagai tanggal</p>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="togglePresensiForm()" id="btnTutupForm" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                        <i class="fas fa-times me-2"></i>Tutup Form
                    </button>
                </div>

                <!-- Presensi Form -->
                <div class="card mb-4" id="presensiFormCard" style="display: block !important; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 0.5rem; overflow: visible;">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%) !important; padding: 1.25rem 1.5rem; border: none; overflow: visible;">
                        <div>
                            <h5 class="mb-0" style="font-size: 1.1rem; font-weight: 600;">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Presensi Baru
                                <small class="d-block mt-2" style="font-size: 0.85rem; opacity: 0.95; font-weight: 400;">
                                    <i class="fas fa-info-circle me-1"></i>Anda dapat melakukan presensi untuk berbagai tanggal dengan jenis berbeda (Hadir, Sakit, atau Izin)
                                </small>
                            </h5>
                        </div>
                        <button type="button" class="btn btn-light btn-sm" onclick="togglePresensiForm()" style="background-color: rgba(255,255,255,0.25); border: 1px solid rgba(255,255,255,0.4); color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body" style="padding: 1rem; background-color: #ffffff; overflow: visible;">
                        <form action="{{ route('guru.presensi.store') }}" method="POST" id="presensiForm" enctype="multipart/form-data">
                            @csrf
                            @php
                                $defaultJenis = old('jenis', 'hadir');
                            @endphp
                            
                            <!-- Layout 2 Kolom: Form di kiri, Sidebar di kanan -->
                            <div class="row" style="display: flex !important; flex-wrap: nowrap !important;">
                                <!-- Form Utama (Kiri) -->
                                <div class="col-lg-12" id="form-main-section" style="display: block !important;">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                            <input type="date" name="tanggal" class="form-control" 
                                                   value="{{ old('tanggal', date('Y-m-d')) }}" 
                                                   max="{{ date('Y-m-d') }}" 
                                                   id="tanggalPresensi"
                                                   required>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>Pilih tanggal presensi. Setiap tanggal hanya bisa diisi sekali.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label">Jenis Presensi <span class="text-danger">*</span></label>
                                        <small class="text-muted d-block mb-1" style="font-size: 0.875rem;">
                                            <i class="fas fa-info-circle me-1"></i>Pilih jenis presensi sesuai kondisi hari ini. Setiap hari bisa berbeda jenisnya.
                                        </small>
                                        <div class="row" id="jenis-presensi-row" style="display: flex !important; flex-wrap: nowrap !important; justify-content: center !important; align-items: center !important; margin-left: auto !important; margin-right: auto !important; overflow: visible !important; width: auto !important; max-width: 90% !important; gap: 10px;">
                                            <div class="col-md-4 jenis-presensi-col" style="flex: 0 0 25% !important; width: 25% !important; max-width: 25% !important; min-width: 25% !important; padding-left: 10px !important; padding-right: 10px !important; overflow: visible !important; float: none !important; display: flex !important; align-items: stretch !important; box-sizing: border-box !important;">
                                                <div class="card presensi-type-card mb-2" onclick="selectPresensiType('hadir')" id="card-hadir" style="height: 100% !important; width: 100% !important; min-height: 100px !important; max-height: 100px !important; position: relative !important; z-index: 1 !important; overflow: visible !important; box-sizing: border-box !important; margin: 0 !important; padding: 0 !important; border: 2px solid #e0e0e0 !important; transform: none !important; scale: 1 !important; flex: 0 0 auto !important;">
                                                    <div class="card-body text-center" style="padding: 0.5rem !important;">
                                                        <i class="fas fa-check-circle text-success mb-1" style="font-size: 1.5rem !important;"></i>
                                                        <h6 style="font-size: 0.85rem !important; margin-bottom: 0 !important;">Hadir</h6>
                                                        <input type="radio" name="jenis" value="hadir" id="jenis-hadir" class="d-none" {{ old('jenis', 'hadir') === 'hadir' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 jenis-presensi-col" style="flex: 0 0 25% !important; width: 25% !important; max-width: 25% !important; min-width: 25% !important; padding-left: 10px !important; padding-right: 10px !important; overflow: visible !important; float: none !important; display: flex !important; align-items: stretch !important; box-sizing: border-box !important;">
                                                <div class="card presensi-type-card mb-2" onclick="selectPresensiType('sakit')" id="card-sakit" style="height: 100% !important; width: 100% !important; min-height: 100px !important; max-height: 100px !important; position: relative !important; z-index: 1 !important; overflow: visible !important; box-sizing: border-box !important; margin: 0 !important; padding: 0 !important; border: 2px solid #e0e0e0 !important; transform: none !important; scale: 1 !important; flex: 0 0 auto !important;">
                                                    <div class="card-body text-center" style="padding: 0.5rem !important;">
                                                        <i class="fas fa-user-injured text-danger mb-1" style="font-size: 1.5rem !important;"></i>
                                                        <h6 style="font-size: 0.85rem !important; margin-bottom: 0 !important;">Sakit</h6>
                                                        <input type="radio" name="jenis" value="sakit" id="jenis-sakit" class="d-none" {{ old('jenis') === 'sakit' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 jenis-presensi-col" style="flex: 0 0 25% !important; width: 25% !important; max-width: 25% !important; min-width: 25% !important; padding-left: 10px !important; padding-right: 10px !important; overflow: visible !important; float: none !important; display: flex !important; align-items: stretch !important; box-sizing: border-box !important;">
                                                <div class="card presensi-type-card mb-2" onclick="selectPresensiType('izin')" id="card-izin" style="height: 100% !important; width: 100% !important; min-height: 100px !important; max-height: 100px !important; position: relative !important; z-index: 1 !important; overflow: visible !important; box-sizing: border-box !important; margin: 0 !important; padding: 0 !important; border: 2px solid #e0e0e0 !important; transform: none !important; scale: 1 !important; flex: 0 0 auto !important;">
                                                    <div class="card-body text-center" style="padding: 0.5rem !important;">
                                                        <i class="fas fa-file-alt text-warning mb-1" style="font-size: 1.5rem !important;"></i>
                                                        <h6 style="font-size: 0.85rem !important; margin-bottom: 0 !important;">Izin</h6>
                                                        <input type="radio" name="jenis" value="izin" id="jenis-izin" class="d-none" {{ old('jenis') === 'izin' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="jam-section" class="row mb-2">
                                <div class="col-md-6">
                                    <label class="form-label">Jam Masuk <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="time" name="jam_masuk" class="form-control" 
                                               id="jam_masuk" value="{{ old('jam_masuk') }}" required>
                                        <button type="button" class="btn btn-outline-success" onclick="setCurrentTime('jam_masuk')" title="Gunakan waktu saat ini">
                                            <i class="fas fa-clock"></i> Sekarang
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        <span id="jamMasukInfo">Klik tombol "Sekarang" untuk mengisi otomatis dengan waktu saat ini</span>
                                        <span id="jamMasukSakitInfo" style="display: none;">Jam masuk akan otomatis terisi untuk menunjukkan waktu mulai sakit</span>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jam Keluar</label>
                                    <div class="input-group">
                                        <input type="time" name="jam_keluar" class="form-control" 
                                               id="jam_keluar" value="{{ old('jam_keluar') }}">
                                        <button type="button" class="btn btn-outline-success" onclick="setCurrentTime('jam_keluar')" title="Gunakan waktu saat ini">
                                            <i class="fas fa-clock"></i> Sekarang
                                        </button>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> Klik tombol "Sekarang" untuk mengisi otomatis dengan waktu saat ini
                                    </small>
                                </div>
                            </div>

                                    </div>

                                    <div class="d-flex gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Kirim Presensi
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="togglePresensiForm()">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </button>
                                    </div>
                                </div>

                                <!-- Sidebar untuk Sakit dan Izin (Kanan) -->
                                <div class="col-lg-5" id="presensi-sidebar" style="display: none !important; visibility: hidden !important; opacity: 0 !important;">
                                    <div class="card border-primary" style="border-width: 2px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                                            </h6>
                                            <button type="button" class="btn btn-sm btn-light" onclick="closePresensiSidebar()" style="background-color: rgba(255,255,255,0.25); border: 1px solid rgba(255,255,255,0.4); color: white;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                                            <!-- Keterangan untuk Izin -->
                                            <div id="keterangan-section" class="mb-3" style="display: none;">
                                                <label class="form-label">
                                                    <i class="fas fa-file-alt text-warning me-2"></i>Keterangan <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4" 
                                                          placeholder="Masukkan alasan izin..." id="keterangan">{{ old('keterangan') }}</textarea>
                                                @error('keterangan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted d-block mt-1">
                                                    <i class="fas fa-info-circle me-1"></i>Wajib diisi untuk presensi izin
                                                </small>
                                            </div>

                                            <!-- Surat Sakit untuk Sakit -->
                                            <div id="surat-sakit-section" class="mb-3" style="display: none;">
                                                <label class="form-label">
                                                    <i class="fas fa-file-medical text-danger me-2"></i>Surat Dokter / Surat Sakit 
                                                    <span class="badge bg-info text-white ms-2">
                                                        <i class="fas fa-info-circle me-1"></i>Opsional
                                                    </span>
                                                </label>
                                                <input type="file" name="surat_sakit" id="surat_sakit" 
                                                       class="form-control @error('surat_sakit') is-invalid @enderror" 
                                                       accept=".pdf,.png,.jpg,.jpeg">
                                                <small class="text-muted d-block mt-1">
                                                    <i class="fas fa-file-alt me-1"></i>
                                                    Format yang didukung: PDF, PNG, JPG, JPEG (Maksimal 5MB)
                                                </small>
                                                @error('surat_sakit')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <div id="surat-sakit-preview" class="mt-2" style="display: none;">
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-file me-2"></i>
                                                        <span id="surat-sakit-filename"></span>
                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearSuratSakit()">
                                                            <i class="fas fa-times"></i> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tugas Pengganti untuk Sakit dan Izin -->
                                            <div id="tugas-section" class="mb-3" style="display: none; transition: all 0.3s ease;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <label class="form-label mb-1">
                                            Tugas Pengganti Untuk Siswa <span class="text-danger">*</span>
                                        </label>
                                        <p class="text-muted mb-1" style="font-size: 0.875rem;" id="tugas-hint">
                                            Ketika guru sakit atau izin, wajib memberikan instruksi tugas/LKS untuk kelas yang diajar (kelas 7, 8, dan/atau 9).
                                            Minimal isi salah satu kelas agar siswa tetap memiliki kegiatan belajar.
                                        </p>
                                    </div>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-book me-1"></i> Wajib saat sakit/izin
                                    </span>
                                </div>
                                <div class="row g-3" style="display: flex; flex-wrap: nowrap; margin-left: -10px; margin-right: -10px;">
                                    <div class="col-md-4" style="flex: 0 0 33.333333%; width: 33.333333%; max-width: 33.333333%; padding-left: 10px; padding-right: 10px; display: block;">
                                        <div class="card border-success shadow-sm h-100" style="height: 100%;">
                                            <div class="card-header bg-success text-white py-1" style="padding: 0.5rem 1rem;">
                                                <strong style="font-size: 0.9rem;">Kelas 7</strong>
                                            </div>
                                            <div class="card-body" style="padding: 0.75rem;">
                                                <textarea name="tugas_kelas_7" id="tugas_kelas_7" rows="3"
                                                          class="form-control tugas-textarea @error('tugas_kelas_7') is-invalid @enderror"
                                                          placeholder="Contoh: Kerjakan LKS hal. 15-20 dan rangkum materi bab 2." style="font-size: 0.875rem; resize: vertical;">{{ old('tugas_kelas_7') }}</textarea>
                                                @error('tugas_kelas_7')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="flex: 0 0 33.333333%; width: 33.333333%; max-width: 33.333333%; padding-left: 10px; padding-right: 10px; display: block;">
                                        <div class="card border-success shadow-sm h-100" style="height: 100%;">
                                            <div class="card-header bg-success text-white py-1" style="padding: 0.5rem 1rem;">
                                                <strong style="font-size: 0.9rem;">Kelas 8</strong>
                                            </div>
                                            <div class="card-body" style="padding: 0.75rem;">
                                                <textarea name="tugas_kelas_8" id="tugas_kelas_8" rows="3"
                                                          class="form-control tugas-textarea @error('tugas_kelas_8') is-invalid @enderror"
                                                          placeholder="Contoh: Buat catatan materi baru dan kerjakan latihan 3." style="font-size: 0.875rem; resize: vertical;">{{ old('tugas_kelas_8') }}</textarea>
                                                @error('tugas_kelas_8')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="flex: 0 0 33.333333%; width: 33.333333%; max-width: 33.333333%; padding-left: 10px; padding-right: 10px; display: block;">
                                        <div class="card border-success shadow-sm h-100" style="height: 100%;">
                                            <div class="card-header bg-success text-white py-1" style="padding: 0.5rem 1rem;">
                                                <strong style="font-size: 0.9rem;">Kelas 9</strong>
                                            </div>
                                            <div class="card-body" style="padding: 0.75rem;">
                                                <textarea name="tugas_kelas_9" id="tugas_kelas_9" rows="3"
                                                          class="form-control tugas-textarea @error('tugas_kelas_9') is-invalid @enderror"
                                                          placeholder="Contoh: Selesaikan paket ujian bab 4 dan kumpulkan besok." style="font-size: 0.875rem; resize: vertical;">{{ old('tugas_kelas_9') }}</textarea>
                                                @error('tugas_kelas_9')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-lightbulb me-1 text-warning"></i>
                                    Kosongkan kelas yang tidak membutuhkan tugas. Sistem akan otomatis menyimpan kelas yang diisi saja.
                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Status Presensi Hari Ini -->
                @if($todayPresensi)
                <div class="alert alert-{{ $todayPresensi->status_verifikasi === 'pending' ? 'warning' : ($todayPresensi->status_verifikasi === 'approved' ? 'success' : 'danger') }}">
                    <i class="fas fa-{{ $todayPresensi->status_verifikasi === 'pending' ? 'clock' : ($todayPresensi->status_verifikasi === 'approved' ? 'check-circle' : 'times-circle') }} me-2"></i>
                    Anda sudah melakukan presensi untuk <strong>hari ini ({{ $todayPresensi->tanggal->format('d/m/Y') }})</strong> sebagai <strong>{{ ucfirst($todayPresensi->jenis) }}</strong>.
                    <br><strong>Status:</strong> 
                    @if($todayPresensi->status_verifikasi === 'pending')
                        <span class="badge badge-pending">Menunggu Verifikasi</span>
                        <small class="d-block mt-2 text-muted">
                            <i class="fas fa-info-circle me-1"></i>Status akan otomatis terbarui setelah TU melakukan verifikasi.
                        </small>
                    @elseif($todayPresensi->status_verifikasi === 'approved')
                        <span class="badge badge-approved">Disetujui</span>
                        @if($todayPresensi->verified_at)
                            <small class="d-block mt-2 text-muted">
                                Diverifikasi pada: {{ $todayPresensi->verified_at->format('d/m/Y H:i') }}
                            </small>
                        @endif
                    @else
                        <span class="badge badge-rejected">Ditolak</span>
                        @if($todayPresensi->verified_at)
                            <small class="d-block mt-2 text-muted">
                                Ditolak pada: {{ $todayPresensi->verified_at->format('d/m/Y H:i') }}
                            </small>
                        @endif
                    @endif
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Anda masih bisa menambah presensi untuk tanggal lain menggunakan tombol "Tambah Presensi" di atas.
                        </small>
                    </div>
                    @if(in_array($todayPresensi->jenis, ['sakit', 'izin']) && ($todayPresensi->tugas_kelas_7 || $todayPresensi->tugas_kelas_8 || $todayPresensi->tugas_kelas_9))
                        <div class="mt-3">
                            <strong>Tugas Pengganti:</strong>
                            <ul class="mb-0">
                                @if($todayPresensi->tugas_kelas_7)
                                    <li>Kelas 7: {{ $todayPresensi->tugas_kelas_7 }}</li>
                                @endif
                                @if($todayPresensi->tugas_kelas_8)
                                    <li>Kelas 8: {{ $todayPresensi->tugas_kelas_8 }}</li>
                                @endif
                                @if($todayPresensi->tugas_kelas_9)
                                    <li>Kelas 9: {{ $todayPresensi->tugas_kelas_9 }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    @if($todayPresensi->surat_sakit)
                        <div class="mt-3">
                            <strong>Surat Sakit:</strong>
                            <a href="{{ Storage::url($todayPresensi->surat_sakit) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary ms-2">
                                <i class="fas fa-file-pdf me-1"></i>Lihat Surat
                            </a>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Presensi History -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Presensi (30 Hari Terakhir)
                        </h5>
                        <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">
                            <i class="fas fa-info-circle me-1"></i>Lihat semua presensi Anda dengan berbagai jenis (Hadir, Sakit, Izin)
                        </small>
                    </div>
                    <div class="card-body">
                        @if($presensiHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Keterangan</th>
                                        <th>Tugas Pengganti</th>
                                        <th>Surat Sakit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensiHistory as $p)
                                    <tr>
                                        <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                                        <td>
                                            @if($p->jenis === 'hadir')
                                                <span class="badge badge-hadir text-white">Hadir</span>
                                            @elseif($p->jenis === 'sakit')
                                                <span class="badge badge-sakit text-white">Sakit</span>
                                            @else
                                                <span class="badge badge-izin">Izin</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->jam_masuk)
                                                @if($p->jenis === 'sakit')
                                                    <span class="badge bg-danger text-white">{{ date('H:i', strtotime($p->jam_masuk)) }}</span>
                                                    <small class="text-muted d-block">Mulai sakit</small>
                                                @else
                                                    {{ date('H:i', strtotime($p->jam_masuk)) }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $p->jam_keluar ? date('H:i', strtotime($p->jam_keluar)) : '-' }}</td>
                                        <td>
                                            {{ $p->keterangan ?? '-' }}
                                            @php
                                                $tugasList = collect([
                                                    'Kelas 7' => $p->tugas_kelas7,
                                                    'Kelas 8' => $p->tugas_kelas8,
                                                    'Kelas 9' => $p->tugas_kelas9,
                                                ])->filter(fn($value) => !empty($value));
                                            @endphp
                                            @if($tugasList->count() > 0)
                                                <div class="mt-2">
                                                    <span class="badge bg-success text-white">
                                                        <i class="fas fa-book-reader me-1"></i> Tugas Pengganti
                                                    </span>
                                                    <ul class="mt-2 mb-0 ps-3 text-muted small">
                                                        @foreach($tugasList as $kelas => $tugas)
                                                            <li><strong>{{ $kelas }}:</strong> {{ $tugas }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->tugas_kelas_7 || $p->tugas_kelas_8 || $p->tugas_kelas_9)
                                                <ul class="mb-0 ps-3">
                                                    @if($p->tugas_kelas_7)
                                                        <li><strong>Kelas 7:</strong> {{ $p->tugas_kelas_7 }}</li>
                                                    @endif
                                                    @if($p->tugas_kelas_8)
                                                        <li><strong>Kelas 8:</strong> {{ $p->tugas_kelas_8 }}</li>
                                                    @endif
                                                    @if($p->tugas_kelas_9)
                                                        <li><strong>Kelas 9:</strong> {{ $p->tugas_kelas_9 }}</li>
                                                    @endif
                                                </ul>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->surat_sakit)
                                                <a href="{{ Storage::url($p->surat_sakit) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf me-1"></i>Lihat Surat
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->status_verifikasi === 'pending')
                                                <span class="badge badge-pending text-white">Menunggu</span>
                                            @elseif($p->status_verifikasi === 'approved')
                                                <span class="badge badge-approved text-white">Disetujui</span>
                                            @else
                                                <span class="badge badge-rejected text-white">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                            Belum ada riwayat presensi
                        </p>
                        @endif
                    </div>
                </div>
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
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(function(link) {
                // Force styles dengan !important
                link.style.setProperty('pointer-events', 'auto', 'important');
                link.style.setProperty('cursor', 'pointer', 'important');
                link.style.setProperty('z-index', '1001', 'important');
                link.style.setProperty('position', 'relative', 'important');
                link.style.setProperty('display', 'block', 'important');
                link.style.setProperty('touch-action', 'manipulation', 'important');
                
                // Remove existing listeners by cloning
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);
                
                // Add click event listener
                newLink.addEventListener('click', function(e) {
                    console.log('Nav link clicked:', newLink.href);
                    const href = newLink.getAttribute('href');
                    
                    if (href && href !== '#' && href !== 'javascript:void(0)') {
                        closeSidebar();
                        // Biarkan browser navigate secara normal
                    } else {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }, { capture: false });
                
                // Add touch event listener untuk mobile
                newLink.addEventListener('touchend', function(e) {
                    console.log('Nav link touched:', newLink.href);
                    const href = newLink.getAttribute('href');
                    
                    if (href && href !== '#' && href !== 'javascript:void(0)') {
                        closeSidebar();
                        window.location.href = href;
                        e.preventDefault();
                        return false;
                    }
                }, { capture: false });
            });
        }
        
        // Setup nav links saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
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
        
        // Existing presensi functions
        const defaultPresensiType = @json(old('jenis', 'hadir'));
        const formHasErrors = @json($errors->any());
        
        // Function to ensure all presensi cards have consistent size - AGGRESSIVE
        function ensureConsistentCardSize() {
            const allCards = document.querySelectorAll('.presensi-type-card');
            allCards.forEach(card => {
                card.style.setProperty('width', '100%', 'important');
                card.style.setProperty('height', '100%', 'important');
                card.style.setProperty('min-height', '100px', 'important');
                card.style.setProperty('max-height', '100px', 'important');
                card.style.setProperty('box-sizing', 'border-box', 'important');
                card.style.setProperty('transform', 'none', 'important');
                card.style.setProperty('scale', '1', 'important');
                card.style.setProperty('margin', '0', 'important');
                card.style.setProperty('padding', '0', 'important');
                card.style.setProperty('flex', '0 0 auto', 'important');
            });
        }

        function selectPresensiType(type) {
            // Remove active class from all cards dan pastikan ukuran tetap sama - AGGRESSIVE
            document.querySelectorAll('.presensi-type-card').forEach(card => {
                card.classList.remove('active');
                // Pastikan ukuran tetap sama untuk semua card - FORCE
                card.style.setProperty('width', '100%', 'important');
                card.style.setProperty('height', '100%', 'important');
                card.style.setProperty('min-height', '100px', 'important');
                card.style.setProperty('max-height', '100px', 'important');
                card.style.setProperty('box-sizing', 'border-box', 'important');
                card.style.setProperty('transform', 'none', 'important');
                card.style.setProperty('scale', '1', 'important');
                card.style.setProperty('margin', '0', 'important');
                card.style.setProperty('padding', '0', 'important');
                card.style.setProperty('flex', '0 0 auto', 'important');
            });
            
            // Uncheck all radios
            document.querySelectorAll('input[name="jenis"]').forEach(radio => {
                radio.checked = false;
            });
            
            // Activate selected card and radio - pastikan ukuran tetap sama - FORCE
            const selectedCard = document.getElementById('card-' + type);
            selectedCard.classList.add('active');
            document.getElementById('jenis-' + type).checked = true;
            
            // Pastikan ukuran card yang dipilih tetap sama - FORCE
            selectedCard.style.setProperty('width', '100%', 'important');
            selectedCard.style.setProperty('height', '100%', 'important');
            selectedCard.style.setProperty('min-height', '100px', 'important');
            selectedCard.style.setProperty('max-height', '100px', 'important');
            selectedCard.style.setProperty('box-sizing', 'border-box', 'important');
            selectedCard.style.setProperty('transform', 'none', 'important');
            selectedCard.style.setProperty('scale', '1', 'important');
            selectedCard.style.setProperty('margin', '0', 'important');
            selectedCard.style.setProperty('padding', '0', 'important');
            selectedCard.style.setProperty('flex', '0 0 auto', 'important');
            
            // Show/hide sections based on type
            const jamSection = document.getElementById('jam-section');
            const keteranganSection = document.getElementById('keterangan-section');
            const jamMasuk = document.getElementById('jam_masuk');
            const keterangan = document.getElementById('keterangan');
            const tugasSection = document.getElementById('tugas-section');
            const suratSakitSection = document.getElementById('surat-sakit-section');
            const presensiSidebar = document.getElementById('presensi-sidebar');
            const formMainSection = document.getElementById('form-main-section');
            const tugasTextareas = document.querySelectorAll('.tugas-textarea');
            const requiresTugas = (type === 'sakit' || type === 'izin');
            const requiresSuratSakit = (type === 'sakit'); // Hanya untuk sakit, bukan izin
            
            // Tampilkan/sembunyikan sidebar berdasarkan jenis presensi - FORCE DISPLAY
            if (presensiSidebar) {
                if (type === 'sakit' || type === 'izin') {
                    presensiSidebar.style.setProperty('display', 'block', 'important');
                    presensiSidebar.style.setProperty('visibility', 'visible', 'important');
                    presensiSidebar.style.setProperty('opacity', '1', 'important');
                    if (formMainSection) {
                        formMainSection.classList.remove('col-lg-12');
                        formMainSection.classList.add('col-lg-7');
                        formMainSection.style.setProperty('width', 'auto', 'important');
                        formMainSection.style.setProperty('flex', '0 0 58.333333%', 'important');
                    }
                } else {
                    presensiSidebar.style.setProperty('display', 'none', 'important');
                    presensiSidebar.style.setProperty('visibility', 'hidden', 'important');
                    presensiSidebar.style.setProperty('opacity', '0', 'important');
                    if (formMainSection) {
                        formMainSection.classList.remove('col-lg-7');
                        formMainSection.classList.add('col-lg-12');
                        formMainSection.style.setProperty('width', '100%', 'important');
                        formMainSection.style.setProperty('flex', '0 0 100%', 'important');
                    }
                }
            }
            
            // Pastikan section tugas muncul dengan jelas untuk sakit dan izin
            if (tugasSection) {
                if (requiresTugas) {
                    tugasSection.style.display = 'block';
                    tugasSection.style.visibility = 'visible';
                    tugasSection.style.opacity = '1';
                    // Scroll ke section tugas untuk memastikan user melihatnya
                    setTimeout(() => {
                        tugasSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 100);
                } else {
                    tugasSection.style.display = 'none';
                    tugasTextareas.forEach(textarea => textarea.value = '');
                }
            }
            
            // Show/hide surat sakit section
            if (suratSakitSection) {
                suratSakitSection.style.display = requiresSuratSakit ? 'block' : 'none';
                if (!requiresSuratSakit) {
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) {
                        suratSakitInput.value = '';
                    }
                    clearSuratSakit();
                }
            }
            
            if (type === 'hadir') {
                jamSection.style.display = 'block';
                keteranganSection.style.display = 'none';
                jamMasuk.required = true;
                keterangan.required = false;
                // Auto-fill jam masuk saat pilih hadir
                if (!jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
                if (tugasSection) {
                    tugasSection.style.display = 'none';
                }
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'none', 'important');
                    presensiSidebar.style.setProperty('visibility', 'hidden', 'important');
                }
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-7');
                    formMainSection.classList.add('col-lg-12');
                    formMainSection.style.setProperty('width', '100%', 'important');
                    formMainSection.style.setProperty('flex', '0 0 100%', 'important');
                }
            } else if (type === 'izin') {
                jamSection.style.display = 'none';
                keteranganSection.style.display = 'block';
                jamMasuk.required = false;
                keterangan.required = true;
                // Tampilkan sidebar untuk izin - FORCE
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'block', 'important');
                    presensiSidebar.style.setProperty('visibility', 'visible', 'important');
                    presensiSidebar.style.setProperty('opacity', '1', 'important');
                }
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-12');
                    formMainSection.classList.add('col-lg-7');
                    formMainSection.style.setProperty('width', 'auto', 'important');
                    formMainSection.style.setProperty('flex', '0 0 58.333333%', 'important');
                }
                // Pastikan section tugas muncul untuk izin
                if (tugasSection) {
                    tugasSection.style.display = 'block';
                    tugasSection.style.visibility = 'visible';
                    tugasSection.style.opacity = '1';
                    tugasSection.classList.add('highlight-izin');
                    tugasSection.classList.remove('highlight-sakit');
                }
                // Surat sakit tidak diperlukan untuk izin
                if (suratSakitSection) {
                    suratSakitSection.style.display = 'none';
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) {
                        suratSakitInput.value = '';
                    }
                    clearSuratSakit();
                }
            } else { // sakit
                jamSection.style.display = 'block';
                keteranganSection.style.display = 'none';
                jamMasuk.required = true;
                keterangan.required = false;
                // Auto-fill jam masuk saat pilih sakit agar TU tahu kapan mulai sakit
                if (!jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
                // Update info text
                document.getElementById('jamMasukInfo').style.display = 'none';
                document.getElementById('jamMasukSakitInfo').style.display = 'inline';
                // Tampilkan sidebar untuk sakit - FORCE
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'block', 'important');
                    presensiSidebar.style.setProperty('visibility', 'visible', 'important');
                    presensiSidebar.style.setProperty('opacity', '1', 'important');
                }
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-12');
                    formMainSection.classList.add('col-lg-7');
                    formMainSection.style.setProperty('width', 'auto', 'important');
                    formMainSection.style.setProperty('flex', '0 0 58.333333%', 'important');
                }
                // Pastikan section tugas muncul untuk sakit
                if (tugasSection) {
                    tugasSection.style.display = 'block';
                    tugasSection.style.visibility = 'visible';
                    tugasSection.style.opacity = '1';
                    tugasSection.classList.add('highlight-sakit');
                    tugasSection.classList.remove('highlight-izin');
                }
                if (suratSakitSection) {
                    suratSakitSection.style.display = 'block';
                }
            }
            
            // Reset info text for hadir
            if (type === 'hadir') {
                document.getElementById('jamMasukInfo').style.display = 'inline';
                document.getElementById('jamMasukSakitInfo').style.display = 'none';
            } else if (type === 'izin') {
                document.getElementById('jamMasukInfo').style.display = 'none';
                document.getElementById('jamMasukSakitInfo').style.display = 'none';
            }
            
            // Pastikan ukuran card tetap konsisten setelah perubahan - MULTIPLE CHECKS
            setTimeout(() => {
                ensureConsistentCardSize();
            }, 10);
            setTimeout(() => {
                ensureConsistentCardSize();
            }, 50);
            setTimeout(() => {
                ensureConsistentCardSize();
            }, 100);
            setTimeout(() => {
                ensureConsistentCardSize();
            }, 200);
            
            // Pastikan sidebar benar-benar muncul untuk sakit dan izin
            if ((type === 'sakit' || type === 'izin') && presensiSidebar) {
                setTimeout(() => {
                    presensiSidebar.style.setProperty('display', 'block', 'important');
                    presensiSidebar.style.setProperty('visibility', 'visible', 'important');
                    presensiSidebar.style.setProperty('opacity', '1', 'important');
                }, 50);
            }
        }
        
        // Function to close presensi sidebar
        function closePresensiSidebar() {
            const sidebar = document.getElementById('presensi-sidebar');
            const formMainSection = document.getElementById('form-main-section');
            if (sidebar) {
                sidebar.style.display = 'none';
            }
            if (formMainSection) {
                formMainSection.classList.remove('col-lg-7');
                formMainSection.classList.add('col-lg-12');
            }
        }

        // Function to get current time in HH:mm format
        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return hours + ':' + minutes;
        }

        // Function to set current time to input field
        function setCurrentTime(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                const currentTime = getCurrentTime();
                field.value = currentTime;
                
                // Visual feedback (green flash)
                field.style.backgroundColor = '#d4edda';
                field.style.transition = 'background-color 0.3s ease';
                setTimeout(() => {
                    field.style.backgroundColor = '';
                }, 500);
                
                // Show notification
                const notification = document.createElement('div');
                notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.zIndex = '9999';
                notification.style.minWidth = '250px';
                notification.innerHTML = '<i class="fas fa-check-circle me-2"></i>Waktu otomatis terisi: <strong>' + currentTime + '</strong><button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                document.body.appendChild(notification);
                
                // Auto dismiss notification after 3 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 3000);
            }
        }

        // Function to toggle presensi form
        function togglePresensiForm() {
            const formCard = document.getElementById('presensiFormCard');
            const btnTutup = document.getElementById('btnTutupForm');
            
            if (formCard.style.display === 'none' || formCard.classList.contains('hide')) {
                // Show form
                formCard.style.display = 'block';
                formCard.classList.remove('hide');
                if (btnTutup) {
                    btnTutup.innerHTML = '<i class="fas fa-times me-2"></i>Tutup Form';
                }
                
                // Reset form
                document.getElementById('presensiForm').reset();
                document.querySelectorAll('.tugas-textarea').forEach(textarea => textarea.value = '');
                
                // Set tanggal default to today
                document.getElementById('tanggalPresensi').value = '{{ date('Y-m-d') }}';
                
                // Set default jenis to hadir and auto-fill jam
                selectPresensiType('hadir');
                
                // Scroll to form
                formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                // Hide form
                formCard.style.display = 'none';
                formCard.classList.add('hide');
                if (btnTutup) {
                    btnTutup.innerHTML = '<i class="fas fa-plus-circle me-2"></i>Buka Form';
                }
            }
        }

        // Initialize - set hadir as default active and auto-fill jam masuk
        document.addEventListener('DOMContentLoaded', function() {
            const formCard = document.getElementById('presensiFormCard');
            const btnTutup = document.getElementById('btnTutupForm');
            const hasErrors = @json($errors->any());
            const defaultType = @json(old('jenis', 'hadir'));

            // Form is shown by default
            if (formCard) {
                // Check if form is visible (default state or has errors)
                if (formCard.style.display !== 'none' && !formCard.classList.contains('hide') || hasErrors) {
                    formCard.style.display = 'block';
                    formCard.classList.remove('hide');
                    if (btnTutup) {
                        btnTutup.innerHTML = '<i class="fas fa-times me-2"></i>Tutup Form';
                    }
                }
            }

            // Pastikan ukuran card konsisten sebelum memilih jenis presensi
            ensureConsistentCardSize();
            
            selectPresensiType(defaultType);
            
            // Pastikan ukuran card konsisten setelah memilih jenis presensi - MULTIPLE CHECKS
            setTimeout(() => {
                ensureConsistentCardSize();
            }, 50);
            setTimeout(() => {
                ensureConsistentCardSize();
            }, 100);
            setTimeout(() => {
                ensureConsistentCardSize();
            }, 200);
            
            // Monitor perubahan dan pastikan ukuran tetap sama
            const observer = new MutationObserver(function(mutations) {
                ensureConsistentCardSize();
            });
            
            const jenisPresensiRow = document.getElementById('jenis-presensi-row');
            if (jenisPresensiRow) {
                observer.observe(jenisPresensiRow, {
                    childList: true,
                    subtree: true,
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
            }

            if (defaultType === 'hadir' && formCard && (formCard.style.display === 'block' || hasErrors)) {
                const jamMasuk = document.getElementById('jam_masuk');
                if (jamMasuk && !jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
            }
        });

        // Function to handle surat sakit file preview
        function handleSuratSakitPreview() {
            const suratSakitInput = document.getElementById('surat_sakit');
            const previewDiv = document.getElementById('surat-sakit-preview');
            const filenameSpan = document.getElementById('surat-sakit-filename');
            
            if (suratSakitInput) {
                suratSakitInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const fileName = file.name;
                        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
                        
                        // Validate file type
                        const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg', 'image/jpg'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Format file tidak didukung. Silakan pilih file PDF, PNG, atau JPG.');
                            suratSakitInput.value = '';
                            if (previewDiv) previewDiv.style.display = 'none';
                            return;
                        }
                        
                        // Validate file size (5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Ukuran file terlalu besar. Maksimal 5MB.');
                            suratSakitInput.value = '';
                            if (previewDiv) previewDiv.style.display = 'none';
                            return;
                        }
                        
                        if (previewDiv && filenameSpan) {
                            filenameSpan.textContent = fileName + ' (' + fileSize + ' MB)';
                            previewDiv.style.display = 'block';
                        }
                    } else {
                        if (previewDiv) previewDiv.style.display = 'none';
                    }
                });
            }
        }
        
        // Function to clear surat sakit
        function clearSuratSakit() {
            const suratSakitInput = document.getElementById('surat_sakit');
            const previewDiv = document.getElementById('surat-sakit-preview');
            if (suratSakitInput) {
                suratSakitInput.value = '';
            }
            if (previewDiv) {
                previewDiv.style.display = 'none';
            }
        }
        
        // Initialize surat sakit preview handler
        document.addEventListener('DOMContentLoaded', function() {
            handleSuratSakitPreview();
        });

        // Auto-refresh status every 10 seconds if there's pending presensi
        @if($todayPresensi && $todayPresensi->status_verifikasi === 'pending')
        setInterval(function() {
            // Check if status has changed
            fetch('{{ route("guru.presensi.index") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Only reload if still on presensi page
                if (window.location.pathname.includes('/presensi')) {
                    location.reload();
                }
            })
            .catch(err => console.log('Auto-refresh error:', err));
        }, 10000); // Check every 10 seconds
        @endif
    </script>
</body>
</html>



