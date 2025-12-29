@php 
    use Illuminate\Support\Facades\Storage; 
    // Deteksi mode presensi: 'masuk' (default) atau 'keluar'
    $presensiType = request()->get('type', 'masuk');
    $isMasuk = $presensiType !== 'keluar';
    $isKeluar = $presensiType === 'keluar';
    
    // Deteksi mode view: 'form' (default) atau 'riwayat'
    $viewMode = request()->get('view', 'form');
    $isRiwayat = $viewMode === 'riwayat';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isMasuk ? 'Presensi Masuk' : 'Presensi Keluar' }} - {{ $guru->user->name }}</title>
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
        
        /* Layout - Sidebar Fixed di Kiri */
        /* Pastikan di desktop, konten di samping sidebar - ULTRA VISIBLE */
        @media (min-width: 768px) {
            .container-fluid > .row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }
            
            /* Sidebar FIXED di sisi kiri - Medium screen */
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                flex: 0 0 25% !important;
                width: 25% !important; /* col-md-3 = 25% */
                max-width: 25% !important;
                min-width: 250px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                height: 100vh !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            /* Konten utama dengan margin kiri dan padding yang seimbang */
            .col-md-9.col-lg-10 {
                flex: 0 0 75% !important;
                width: 75% !important; /* col-md-9 = 75% */
                margin-left: 25% !important;
                padding-left: 2.5rem !important;
                padding-right: 2.5rem !important;
            }
        }
        
            /* Large screen - sidebar lebih kecil - FIXED */
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
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                height: 100vh !important;
                transform: translateX(0) !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            /* Konten utama dengan margin kiri dan padding yang seimbang */
            .col-md-9.col-lg-10 {
                flex: 0 0 83.33333333% !important;
                width: 83.33333333% !important; /* col-lg-10 = 83.33% */
                margin-left: 16.66666667% !important;
                padding-left: 3rem !important;
                padding-right: 3rem !important;
            }
        }
        
        /* Layout 2 Kolom untuk konten di dalam main content */
        .col-lg-5, .col-lg-7 {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        /* Main content - di samping sidebar (kanan) dengan padding seimbang */
        .col-md-9.col-lg-10 {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 1 !important;
            min-height: 100vh !important;
            padding: 2rem 2.5rem !important;
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
        
        /* PASTIKAN CONTAINER DAN WRAPPER BISA DITAMPILKAN */
        #tugas-kelas-container {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
        
        #tugas-kelas-container[style*="display: block"],
        #tugas-kelas-container.show,
        #tugas-kelas-container[style*="display:block"] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            height: auto !important;
            overflow: visible !important;
        }
        
        .tugas-kelas-wrapper {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
        
        .tugas-kelas-wrapper[style*="display: block"],
        .tugas-kelas-wrapper[style*="display:block"],
        .tugas-kelas-wrapper.show {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            height: auto !important;
            overflow: visible !important;
            background-color: #f8f9fa !important;
        }
        
        /* Pastikan semua element di dalam wrapper visible */
        .tugas-kelas-wrapper[style*="display: block"] *,
        .tugas-kelas-wrapper[style*="display:block"] *,
        .tugas-kelas-wrapper.show * {
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Pastikan input dan textarea di dalam wrapper visible */
        .tugas-kelas-wrapper[style*="display: block"] input,
        .tugas-kelas-wrapper[style*="display: block"] textarea,
        .tugas-kelas-wrapper[style*="display: block"] label,
        .tugas-kelas-wrapper[style*="display: block"] button,
        .tugas-kelas-wrapper[style*="display:block"] input,
        .tugas-kelas-wrapper[style*="display:block"] textarea,
        .tugas-kelas-wrapper[style*="display:block"] label,
        .tugas-kelas-wrapper[style*="display:block"] button {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
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
            min-width: 200px !important; /* Tambahkan min-width agar tidak terlalu sempit */
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
            padding: 1rem !important; /* Perbesar padding dari 0.75rem */
        }
        
        #tugas-section .tugas-textarea {
            flex: 1 !important;
            font-size: 1rem !important; /* Perbesar font dari 0.875rem */
            line-height: 1.5 !important; /* Tambahkan line-height untuk readability */
            min-height: 120px !important; /* Tambahkan min-height agar lebih tinggi */
            padding: 0.75rem !important; /* Tambahkan padding untuk spacing */
            width: 100% !important; /* Pastikan lebar penuh */
            box-sizing: border-box !important; /* Pastikan padding tidak menambah lebar */
            word-wrap: break-word !important; /* Pastikan text wrap dengan baik */
            overflow-wrap: break-word !important; /* Pastikan text wrap dengan baik */
            white-space: pre-wrap !important; /* Preserve whitespace tapi wrap text */
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
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            width: auto !important;
            left: 0 !important;
            transform: translateX(0) !important;
        }
        
        /* Pastikan sidebar fixed di desktop */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar {
                position: fixed !important;
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
        
        /* PASTIKAN SIDEBAR FIXED DAN TIDAK TERSEMBUNYI - ULTRA AGGRESSIVE */
        @media (min-width: 768px) {
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                height: 100vh !important;
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
            cursor: pointer !important;
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease !important;
            border: 2px solid #e0e0e0 !important;
            height: 100px !important;
            min-height: 100px !important;
            max-height: 100px !important;
            width: 100% !important;
            max-width: 100% !important;
            position: relative !important;
            z-index: 10 !important;
            overflow: visible !important;
            box-sizing: border-box !important;
            pointer-events: auto !important;
            user-select: none !important;
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            margin: 0 !important;
            padding: 0 !important;
            flex: 0 0 auto !important;
            transform: none !important;
            scale: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
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
            height: 100px !important;
            min-height: 100px !important;
            max-height: 100px !important;
            width: 100% !important;
            box-sizing: border-box !important;
            scale: 1 !important;
        }
        .presensi-type-card.active {
            border: 2px solid #2E7D32 !important;
            background: #F0F4F0 !important;
            /* Pastikan ukuran tetap sama - TIDAK BERUBAH SAMA SEKALI - ULTRA FIXED */
            height: 100px !important;
            min-height: 100px !important;
            max-height: 100px !important;
            width: 100% !important;
            box-sizing: border-box !important;
            transform: none !important;
            scale: 1 !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        /* Override semua kemungkinan perubahan ukuran - ULTRA AGGRESSIVE */
        .presensi-type-card.active,
        .presensi-type-card:not(.active),
        .presensi-type-card:hover.active,
        .presensi-type-card:hover:not(.active),
        #card-hadir,
        #card-sakit,
        #card-izin,
        #card-hadir.active,
        #card-sakit.active,
        #card-izin.active,
        #card-hadir:not(.active),
        #card-sakit:not(.active),
        #card-izin:not(.active),
        #card-hadir:hover,
        #card-sakit:hover,
        #card-izin:hover {
            height: 100px !important;
            min-height: 100px !important;
            max-height: 100px !important;
            width: 100% !important;
            box-sizing: border-box !important;
            transform: none !important;
            scale: 1 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Pastikan card-body juga konsisten */
        #card-hadir .card-body,
        #card-sakit .card-body,
        #card-izin .card-body,
        #card-hadir.active .card-body,
        #card-sakit.active .card-body,
        #card-izin.active .card-body {
            padding: 0.5rem !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            box-sizing: border-box !important;
        }
        
        /* Perkecil ukuran card jenis presensi - konsisten untuk semua */
        .presensi-type-card .card-body {
            padding: 0.5rem !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            box-sizing: border-box !important;
        }
        
        /* Pastikan card-body di semua state memiliki ukuran yang sama */
        .presensi-type-card.active .card-body,
        .presensi-type-card:not(.active) .card-body {
            padding: 0.5rem !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            box-sizing: border-box !important;
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
        
        /* Pastikan card di dalam col memiliki ukuran yang sama - FIXED HEIGHT */
        .jenis-presensi-col > .presensi-type-card {
            width: 100% !important;
            height: 100px !important;
            min-height: 100px !important;
            max-height: 100px !important;
        }
        
        /* Pastikan semua card jenis presensi memiliki ukuran yang sama - FIXED SIZE ABSOLUTE - ULTRA AGGRESSIVE */
        #card-hadir,
        #card-sakit,
        #card-izin,
        #card-hadir.active,
        #card-sakit.active,
        #card-izin.active,
        #card-hadir:not(.active),
        #card-sakit:not(.active),
        #card-izin:not(.active) {
            width: 100% !important;
            height: 100px !important;
            min-height: 100px !important;
            max-height: 100px !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            padding: 0 !important;
            flex: 0 0 auto !important;
            transform: none !important;
            scale: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative !important;
        }
        
        /* Border untuk unselected */
        #card-hadir:not(.active),
        #card-sakit:not(.active),
        #card-izin:not(.active) {
            border: 2px solid #e0e0e0 !important;
        }
        
        /* Border dan background untuk selected */
        #card-hadir.active,
        #card-sakit.active,
        #card-izin.active {
            border: 2px solid #2E7D32 !important;
            background: #F0F4F0 !important;
            /* Ukuran tetap sama - TIDAK BERUBAH SAMA SEKALI - ABSOLUTE FIXED */
            width: 100% !important;
            height: 100px !important;
            min-height: 100px !important;
            max-height: 100px !important;
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
        
        /* Pastikan semua card jenis presensi tidak tertutup dan BISA DIKLIK - ULTRA AGGRESSIVE */
        #card-hadir,
        #card-sakit,
        #card-izin,
        .presensi-type-card,
        div#card-hadir,
        div#card-sakit,
        div#card-izin,
        div.presensi-type-card {
            position: relative !important;
            z-index: 999 !important;
            overflow: visible !important;
            pointer-events: auto !important;
            cursor: pointer !important;
            user-select: none !important;
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            touch-action: manipulation !important;
        }
        
        /* Pastikan card-body tidak memotong konten dan tidak memblokir klik */
        .presensi-type-card .card-body {
            overflow: visible !important;
            position: relative !important;
            pointer-events: none !important;
        }
        
        /* Pastikan card bisa diklik saat hover dan active - ULTRA AGGRESSIVE */
        #card-hadir:hover,
        #card-sakit:hover,
        #card-izin:hover,
        .presensi-type-card:hover,
        div#card-hadir:hover,
        div#card-sakit:hover,
        div#card-izin:hover {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 999 !important;
            transform: scale(1.02) !important;
            transition: transform 0.2s ease !important;
        }
        
        #card-hadir:active,
        #card-sakit:active,
        #card-izin:active,
        .presensi-type-card:active,
        div#card-hadir:active,
        div#card-sakit:active,
        div#card-izin:active {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 999 !important;
            transform: scale(0.98) !important;
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
        
        /* Sembunyikan section Riwayat Presensi dan Status Presensi Hari Ini secara default - ULTRA AGGRESSIVE */
        #riwayat-presensi-section,
        #status-presensi-hari-ini {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            position: absolute !important;
            left: -9999px !important;
            height: 0 !important;
            overflow: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Tampilkan section Riwayat Presensi setelah submit - ULTRA AGGRESSIVE */
        #riwayat-presensi-section.show,
        #riwayat-presensi-section[data-show="true"] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            left: auto !important;
            height: auto !important;
            overflow: visible !important;
            margin: 1rem 0 !important;
            padding: inherit !important;
        }
        
        /* Tampilkan Status Presensi Hari Ini setelah submit - ULTRA AGGRESSIVE */
        #status-presensi-hari-ini.show,
        #status-presensi-hari-ini[data-show="true"] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            left: auto !important;
            height: auto !important;
            overflow: visible !important;
            margin: 1rem 0 !important;
            padding: inherit !important;
        }
        
        /* Styling untuk tombol Kirim Presensi dan Batal */
        #presensiForm button[type="submit"],
        #presensiForm button.btn-primary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        #presensiForm button[type="submit"]:hover,
        #presensiForm button.btn-primary:hover {
            background: linear-gradient(135deg, #218838 0%, #1ea080 100%) !important;
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4) !important;
            transform: translateY(-2px) !important;
        }
        
        #presensiForm button.btn-secondary {
            background: #6c757d !important;
            border: none !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        #presensiForm button.btn-secondary:hover {
            background: #5a6268 !important;
            box-shadow: 0 6px 16px rgba(108, 117, 125, 0.4) !important;
            transform: translateY(-2px) !important;
        }
        
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
        }
        
        /* PASTIKAN DI DESKTOP SIDEBAR TIDAK TERSEMBUNYI - OVERRIDE MOBILE CSS */
        @media (min-width: 992px) {
            .sidebar,
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                position: relative !important;
                left: 0 !important;
                top: auto !important;
                width: 16.66666667% !important;
                max-width: 16.66666667% !important;
                min-width: 200px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                transform: translateX(0) !important;
                transition: none !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                flex: 0 0 16.66666667% !important;
            }
        }
        
        @media (min-width: 768px) and (max-width: 991px) {
            .sidebar,
            .col-md-3.col-lg-2.sidebar,
            #guru-sidebar {
                position: relative !important;
                left: 0 !important;
                top: auto !important;
                width: 25% !important;
                max-width: 25% !important;
                min-width: 250px !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                transform: translateX(0) !important;
                transition: none !important;
                z-index: 1000 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                flex: 0 0 25% !important;
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
        
        /* FIXED SIDEBAR & CENTERED CONTENT - FINAL OVERRIDE */
        @media (min-width: 768px) {
            .sidebar.col-md-3.col-lg-2,
            #guru-sidebar.col-md-3.col-lg-2,
            .col-md-3.col-lg-2#guru-sidebar,
            .col-md-3.col-lg-2.sidebar#guru-sidebar {
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                height: 100vh !important;
                transform: translateX(0) !important;
                transition: none !important;
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                z-index: 1000 !important;
                margin: 0 !important;
                padding: 0 !important;
                
                /* Width for tablet */
                width: 25% !important;
                min-width: 250px !important;
                max-width: 25% !important;
                flex: 0 0 25% !important;
            }
            
            /* Content for tablet */
            .col-md-9.col-lg-10 {
                width: 75% !important;
                flex: 0 0 75% !important;
                margin-left: 25% !important;
                padding-left: 2.5rem !important;
                padding-right: 2.5rem !important;
                display: block !important;
                float: none !important;
            }

            /* Desktop Specifics */
            @media (min-width: 992px) {
                .col-md-3.col-lg-2.sidebar,
                #guru-sidebar,
                div.col-md-3.col-lg-2.sidebar,
                div#guru-sidebar,
                .sidebar.col-md-3.col-lg-2,
                .sidebar#guru-sidebar {
                    width: 16.66666667% !important;
                    min-width: 200px !important;
                    max-width: 16.66666667% !important;
                    flex: 0 0 16.66666667% !important;
                }

                .col-md-9.col-lg-10 {
                    width: 83.33333333% !important;
                    flex: 0 0 83.33333333% !important;
                    margin-left: 16.66666667% !important;
                    padding-left: 3rem !important;
                    padding-right: 3rem !important;
                }
            }
        }
    </style>
    <!-- Final Fix for Presensi Sidebar & Layout: 2025-12-29 -->
    @include('partials.guru-dynamic-ui')
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
                        <h4 class="mb-1" style="font-size: 1.5rem; font-weight: 600;">
                            @if($isRiwayat)
                                <i class="fas fa-history me-2 text-info"></i>Riwayat Presensi
                            @elseif($isMasuk)
                                <i class="fas fa-sign-in-alt me-2 text-success"></i>Presensi Masuk
                            @else
                                <i class="fas fa-sign-out-alt me-2 text-primary"></i>Presensi Keluar
                            @endif
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                            @if($isRiwayat)
                                Lihat semua riwayat presensi Anda
                            @elseif($isMasuk)
                                Catat waktu kedatangan Anda hari ini
                            @else
                                Catat waktu kepulangan Anda hari ini
                            @endif
                        </p>
                    </div>
                    @if(!$isRiwayat)
                    <button type="button" class="btn btn-secondary btn-sm" onclick="togglePresensiForm()" id="btnTutupForm" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                        <i class="fas fa-times me-2"></i>Tutup Form
                    </button>
                    @endif
                </div>

                @if($isRiwayat)
                <!-- Card Status Presensi Hari Ini -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 0.5rem;">
                            <div class="card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 1rem 1.5rem;">
                                <h5 class="mb-0">
                                    <i class="fas fa-calendar-day me-2"></i>Presensi Hari Ini
                                </h5>
                                <small style="opacity: 0.9;">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</small>
                            </div>
                            <div class="card-body" style="padding: 1.5rem;">
                                @if($todayPresensi)
                                <div class="row">
                                    <!-- Presensi Masuk -->
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="d-flex align-items-center p-3" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 0.5rem; border-left: 4px solid #4CAF50;">
                                            <div class="me-3" style="font-size: 2.5rem; color: #4CAF50;">
                                                <i class="fas fa-sign-in-alt"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1" style="color: #2E7D32; font-weight: 600;">Presensi Masuk</h6>
                                                @if($todayPresensi->jam_masuk)
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-success me-2" style="font-size: 1.1rem; padding: 0.5rem 1rem;">
                                                            <i class="fas fa-clock me-1"></i>{{ date('H:i', strtotime($todayPresensi->jam_masuk)) }}
                                                        </span>
                                                        <small class="text-muted">WIB</small>
                                                    </div>
                                                    <small class="text-muted mt-1 d-block">
                                                        <i class="fas fa-check-circle me-1"></i>Sudah tercatat
                                                    </small>
                                                @else
                                                    <span class="badge bg-secondary">Belum tercatat</span>
                                                    <small class="text-muted mt-1 d-block">
                                                        <a href="{{ route('guru.presensi.index') }}" class="text-decoration-none">
                                                            <i class="fas fa-arrow-right me-1"></i>Isi presensi masuk
                                                        </a>
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Presensi Keluar -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 0.5rem; border-left: 4px solid #2196F3;">
                                            <div class="me-3" style="font-size: 2.5rem; color: #2196F3;">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1" style="color: #1976D2; font-weight: 600;">Presensi Keluar</h6>
                                                @if($todayPresensi->jam_keluar)
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-primary me-2" style="font-size: 1.1rem; padding: 0.5rem 1rem;">
                                                            <i class="fas fa-clock me-1"></i>{{ date('H:i', strtotime($todayPresensi->jam_keluar)) }}
                                                        </span>
                                                        <small class="text-muted">WIB</small>
                                                    </div>
                                                    <small class="text-muted mt-1 d-block">
                                                        <i class="fas fa-check-circle me-1"></i>Sudah tercatat
                                                    </small>
                                                @else
                                                    <span class="badge bg-secondary">Belum tercatat</span>
                                                    <small class="text-muted mt-1 d-block">
                                                        <a href="{{ route('guru.presensi.index', ['type' => 'keluar']) }}" class="text-decoration-none">
                                                            <i class="fas fa-arrow-right me-1"></i>Isi presensi keluar
                                                        </a>
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Info Tambahan -->
                                <div class="mt-3 p-3" style="background: #f8f9fa; border-radius: 0.5rem;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Jenis Presensi</small>
                                            <strong>
                                                @if($todayPresensi->jenis === 'hadir')
                                                    <span class="badge bg-success">Hadir</span>
                                                @elseif($todayPresensi->jenis === 'sakit')
                                                    <span class="badge bg-danger">Sakit</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Izin</span>
                                                @endif
                                            </strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Status Verifikasi</small>
                                            <strong>
                                                @if($todayPresensi->status_verifikasi === 'pending')
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif($todayPresensi->status_verifikasi === 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Durasi Kerja</small>
                                            <strong>
                                                @if($todayPresensi->jam_masuk && $todayPresensi->jam_keluar)
                                                    @php
                                                        $masuk = \Carbon\Carbon::parse($todayPresensi->jam_masuk);
                                                        $keluar = \Carbon\Carbon::parse($todayPresensi->jam_keluar);
                                                        $durasi = $masuk->diff($keluar);
                                                    @endphp
                                                    {{ $durasi->h }} jam {{ $durasi->i }} menit
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum Ada Presensi Hari Ini</h5>
                                    <p class="text-muted mb-3">Anda belum melakukan presensi untuk hari ini</p>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('guru.presensi.index') }}" class="btn btn-success">
                                            <i class="fas fa-sign-in-alt me-1"></i> Isi Presensi Masuk
                                        </a>
                                        <a href="{{ route('guru.presensi.index', ['type' => 'keluar']) }}" class="btn btn-primary">
                                            <i class="fas fa-sign-out-alt me-1"></i> Isi Presensi Keluar
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(!$isRiwayat)
                <!-- Presensi Form -->
                <div class="card mb-4" id="presensiFormCard" style="display: block !important; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 0.5rem; overflow: visible;">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, {{ $isMasuk ? '#4CAF50 0%, #2E7D32' : '#2196F3 0%, #1976D2' }} 100%) !important; padding: 1.25rem 1.5rem; border: none; overflow: visible;">
                        <div>
                            <h5 class="mb-0" style="font-size: 1.1rem; font-weight: 600;">
                                @if($isMasuk)
                                    <i class="fas fa-clock me-2"></i>Catat Jam Masuk
                                @else
                                    <i class="fas fa-clock me-2"></i>Catat Jam Keluar
                                @endif
                                <small class="d-block mt-2" style="font-size: 0.85rem; opacity: 0.95; font-weight: 400;">
                                    @if($isMasuk)
                                        <i class="fas fa-info-circle me-1"></i>Isi jam masuk saat Anda tiba di sekolah
                                    @else
                                        <i class="fas fa-info-circle me-1"></i>Isi jam keluar saat Anda pulang dari sekolah
                                    @endif
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

                                    @if($isMasuk)
                                    <div class="mb-2">
                                        <label class="form-label">Jenis Presensi <span class="text-danger">*</span></label>
                                        <small class="text-muted d-block mb-1" style="font-size: 0.875rem;">
                                            <i class="fas fa-info-circle me-1"></i>Pilih jenis presensi sesuai kondisi hari ini. Setiap hari bisa berbeda jenisnya.
                                        </small>
                                        <div class="row" id="jenis-presensi-row" style="display: flex !important; flex-wrap: nowrap !important; justify-content: center !important; align-items: center !important; margin-left: auto !important; margin-right: auto !important; overflow: visible !important; width: auto !important; max-width: 90% !important; gap: 10px;">
                                            <div class="col-md-4 jenis-presensi-col" style="flex: 0 0 25% !important; width: 25% !important; max-width: 25% !important; min-width: 25% !important; padding-left: 10px !important; padding-right: 10px !important; overflow: visible !important; float: none !important; display: flex !important; align-items: stretch !important; box-sizing: border-box !important;">
                                                <div class="card presensi-type-card mb-2" onclick="(function(){try{if(window.selectPresensiType){window.selectPresensiType('hadir');}else{console.error('selectPresensiType not found');}}catch(e){console.error('Error:',e);}})();return false;" id="card-hadir" style="height: 100px !important; width: 100% !important; min-height: 100px !important; max-height: 100px !important; position: relative !important; z-index: 9999 !important; overflow: visible !important; box-sizing: border-box !important; margin: 0 !important; padding: 0 !important; border: 2px solid #e0e0e0 !important; transform: none !important; scale: 1 !important; flex: 0 0 auto !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; pointer-events: auto !important; user-select: none !important; -webkit-user-select: none !important; -moz-user-select: none !important; -ms-user-select: none !important;">
                                                    <div class="card-body text-center" style="padding: 0.5rem !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; width: 100% !important; height: 100% !important; pointer-events: none !important;">
                                                        <i class="fas fa-check-circle text-success mb-1" style="font-size: 1.5rem !important;"></i>
                                                        <h6 style="font-size: 0.85rem !important; margin-bottom: 0 !important;">Hadir</h6>
                                                        <input type="radio" name="jenis" value="hadir" id="jenis-hadir" class="d-none" {{ old('jenis', 'hadir') === 'hadir' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 jenis-presensi-col" style="flex: 0 0 25% !important; width: 25% !important; max-width: 25% !important; min-width: 25% !important; padding-left: 10px !important; padding-right: 10px !important; overflow: visible !important; float: none !important; display: flex !important; align-items: stretch !important; box-sizing: border-box !important;">
                                                <div class="card presensi-type-card mb-2" onclick="(function(){try{if(window.selectPresensiType){window.selectPresensiType('sakit');}else{console.error('selectPresensiType not found');}}catch(e){console.error('Error:',e);}})();return false;" id="card-sakit" style="height: 100px !important; width: 100% !important; min-height: 100px !important; max-height: 100px !important; position: relative !important; z-index: 9999 !important; overflow: visible !important; box-sizing: border-box !important; margin: 0 !important; padding: 0 !important; border: 2px solid #e0e0e0 !important; transform: none !important; scale: 1 !important; flex: 0 0 auto !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; pointer-events: auto !important; user-select: none !important; -webkit-user-select: none !important; -moz-user-select: none !important; -ms-user-select: none !important;">
                                                    <div class="card-body text-center" style="padding: 0.5rem !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; width: 100% !important; height: 100% !important; pointer-events: none !important;">
                                                        <i class="fas fa-user-injured text-danger mb-1" style="font-size: 1.5rem !important;"></i>
                                                        <h6 style="font-size: 0.85rem !important; margin-bottom: 0 !important;">Sakit</h6>
                                                        <input type="radio" name="jenis" value="sakit" id="jenis-sakit" class="d-none" {{ old('jenis') === 'sakit' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 jenis-presensi-col" style="flex: 0 0 25% !important; width: 25% !important; max-width: 25% !important; min-width: 25% !important; padding-left: 10px !important; padding-right: 10px !important; overflow: visible !important; float: none !important; display: flex !important; align-items: stretch !important; box-sizing: border-box !important;">
                                                <div class="card presensi-type-card mb-2" onclick="(function(){try{if(window.selectPresensiType){window.selectPresensiType('izin');}else{console.error('selectPresensiType not found');}}catch(e){console.error('Error:',e);}})();return false;" id="card-izin" style="height: 100px !important; width: 100% !important; min-height: 100px !important; max-height: 100px !important; position: relative !important; z-index: 9999 !important; overflow: visible !important; box-sizing: border-box !important; margin: 0 !important; padding: 0 !important; border: 2px solid #e0e0e0 !important; transform: none !important; scale: 1 !important; flex: 0 0 auto !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; pointer-events: auto !important; user-select: none !important; -webkit-user-select: none !important; -moz-user-select: none !important; -ms-user-select: none !important;">
                                                    <div class="card-body text-center" style="padding: 0.5rem !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; width: 100% !important; height: 100% !important; pointer-events: none !important;">
                                                        <i class="fas fa-file-alt text-warning mb-1" style="font-size: 1.5rem !important;"></i>
                                                        <h6 style="font-size: 0.85rem !important; margin-bottom: 0 !important;">Izin</h6>
                                                        <input type="radio" name="jenis" value="izin" id="jenis-izin" class="d-none" {{ old('jenis') === 'izin' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <!-- Hidden input untuk jenis presensi di mode keluar -->
                                    <input type="hidden" name="jenis" value="hadir">
                                    @endif


                                    <div id="jam-section" class="row mb-3">
                                        @if($isMasuk)
                                        <!-- Mode Presensi Masuk -->
                                        <div class="col-md-12">
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
                                                Klik tombol "Sekarang" untuk mengisi otomatis dengan waktu saat ini
                                            </small>
                                        </div>
                                        @else
                                        <!-- Mode Presensi Keluar -->
                                        <div class="col-md-12">
                                            <label class="form-label">Jam Keluar <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="time" name="jam_keluar" class="form-control" 
                                                       id="jam_keluar" value="{{ old('jam_keluar') }}" required>
                                                <button type="button" class="btn btn-outline-primary" onclick="setCurrentTime('jam_keluar')" title="Gunakan waktu saat ini">
                                                    <i class="fas fa-clock"></i> Sekarang
                                                </button>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> Klik tombol "Sekarang" untuk mengisi otomatis dengan waktu saat ini
                                            </small>
                                        </div>
                                        <!-- Hidden input untuk jam masuk di mode keluar -->
                                        <input type="hidden" name="jam_masuk" value="00:00">
                                        @endif
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="d-flex gap-3 mt-4 mb-3" style="justify-content: flex-start; align-items: center; padding-top: 1rem; border-top: 1px solid #e0e0e0;">
                                        <button type="submit" class="btn {{ $isMasuk ? 'btn-success' : 'btn-primary' }} btn-lg" id="btnKirimPresensi" style="padding: 0.75rem 2rem; font-size: 1rem; font-weight: 600; min-width: 180px; display: block !important; visibility: visible !important; opacity: 1 !important;">
                                            @if($isMasuk)
                                                <i class="fas fa-sign-in-alt me-2"></i>Simpan Jam Masuk
                                            @else
                                                <i class="fas fa-sign-out-alt me-2"></i>Simpan Jam Keluar
                                            @endif
                                        </button>
                                        <a href="{{ route('guru.presensi.index', ['view' => 'riwayat']) }}" class="btn btn-secondary btn-lg" style="padding: 0.75rem 2rem; font-size: 1rem; font-weight: 600; min-width: 120px; text-decoration: none;">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
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
                                <div class="d-flex justify-content-between align-items-start mb-3">
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
                                
                                <!-- Dropdown untuk memilih kelas -->
                                <div class="mb-3">
                                    <label for="pilih-kelas-tugas" class="form-label">
                                        <i class="fas fa-graduation-cap me-2"></i>Pilih Kelas <span class="text-danger">*</span>
                                    </label>
                                    <select id="pilih-kelas-tugas" class="form-select form-select-lg" style="font-size: 1rem !important; padding: 0.75rem !important;" onchange="if(typeof tampilkanKolomTugas === 'function') { tampilkanKolomTugas(this.value); } else if(typeof window.tampilkanKolomTugas === 'function') { window.tampilkanKolomTugas(this.value); } else { console.error('tampilkanKolomTugas not found'); }">
                                        <option value="">-- Pilih Kelas --</option>
                                        <option value="7">Kelas 7</option>
                                        <option value="8">Kelas 8</option>
                                        <option value="9">Kelas 9</option>
                                    </select>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.875rem;">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Pilih kelas yang akan diberikan tugas, kemudian isi instruksi tugas di bawah.
                                    </small>
                                </div>
                                
                                <!-- Container untuk textarea dinamis berdasarkan kelas yang dipilih -->
                                <div id="tugas-kelas-container" style="display: none !important; visibility: hidden !important; opacity: 0 !important;">
                                    <!-- Kelas 7 -->
                                    <div id="tugas-kelas-7-wrapper" class="tugas-kelas-wrapper mb-4 p-3 border rounded" style="display: none !important; visibility: hidden !important; opacity: 0 !important; background-color: #f8f9fa;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">
                                                <i class="fas fa-book me-2 text-success"></i>Tugas untuk Kelas 7
                                            </h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(typeof hapusTugasKelas === 'function') { hapusTugasKelas(7); } else if(typeof window.hapusTugasKelas === 'function') { window.hapusTugasKelas(7); } else { console.error('hapusTugasKelas not found'); } return false;">
                                                <i class="fas fa-times me-1"></i>Hapus
                                            </button>
                                        </div>
                                        
                                        <!-- Detail Tugas - Kolom untuk informasi detail -->
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-2">
                                                <label for="detail_halaman_7" class="form-label">
                                                    <i class="fas fa-file-alt me-1"></i>Halaman <small class="text-muted">(Opsional)</small>
                                                </label>
                                                <input type="text" name="detail_halaman_7" id="detail_halaman_7" 
                                                       class="form-control" 
                                                       placeholder="Contoh: Hal. 15-20, Hal. 25, Hal. 30-35"
                                                       value="{{ old('detail_halaman_7') }}"
                                                       style="font-size: 1rem !important; padding: 0.75rem !important;">
                                                <small class="text-muted">Contoh: Hal. 15-20 atau Hal. 25</small>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="detail_bab_7" class="form-label">
                                                    <i class="fas fa-bookmark me-1"></i>Bab/Materi <small class="text-muted">(Opsional)</small>
                                                </label>
                                                <input type="text" name="detail_bab_7" id="detail_bab_7" 
                                                       class="form-control" 
                                                       placeholder="Contoh: Bab 2, Materi Persamaan Linear"
                                                       value="{{ old('detail_bab_7') }}"
                                                       style="font-size: 1rem !important; padding: 0.75rem !important;">
                                                <small class="text-muted">Contoh: Bab 2 atau Materi Persamaan Linear</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Instruksi Tugas -->
                                        <div class="mb-3">
                                            <label for="tugas_kelas_7" class="form-label">
                                                Instruksi Tugas <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="tugas_kelas_7" id="tugas_kelas_7" rows="5"
                                                      class="form-control tugas-textarea @error('tugas_kelas_7') is-invalid @enderror"
                                                      placeholder="Contoh: Kerjakan LKS hal. 15-20 dan rangkum materi bab 2. Kumpulkan tugas pada hari Senin." 
                                                      style="font-size: 1rem !important; resize: vertical; min-height: 120px !important; line-height: 1.5 !important; padding: 0.75rem !important; word-wrap: break-word !important; overflow-wrap: break-word !important; white-space: pre-wrap !important; width: 100% !important;">{{ old('tugas_kelas_7') }}</textarea>
                                            @error('tugas_kelas_7')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Kelas 8 -->
                                    <div id="tugas-kelas-8-wrapper" class="tugas-kelas-wrapper mb-4 p-3 border rounded" style="display: none !important; visibility: hidden !important; opacity: 0 !important; background-color: #f8f9fa;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">
                                                <i class="fas fa-book me-2 text-success"></i>Tugas untuk Kelas 8
                                            </h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(typeof hapusTugasKelas === 'function') { hapusTugasKelas(8); } else if(typeof window.hapusTugasKelas === 'function') { window.hapusTugasKelas(8); } else { console.error('hapusTugasKelas not found'); } return false;">
                                                <i class="fas fa-times me-1"></i>Hapus
                                            </button>
                                        </div>
                                        
                                        <!-- Detail Tugas - Kolom untuk informasi detail -->
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-2">
                                                <label for="detail_halaman_8" class="form-label">
                                                    <i class="fas fa-file-alt me-1"></i>Halaman <small class="text-muted">(Opsional)</small>
                                                </label>
                                                <input type="text" name="detail_halaman_8" id="detail_halaman_8" 
                                                       class="form-control" 
                                                       placeholder="Contoh: Hal. 15-20, Hal. 25, Hal. 30-35"
                                                       value="{{ old('detail_halaman_8') }}"
                                                       style="font-size: 1rem !important; padding: 0.75rem !important;">
                                                <small class="text-muted">Contoh: Hal. 15-20 atau Hal. 25</small>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="detail_bab_8" class="form-label">
                                                    <i class="fas fa-bookmark me-1"></i>Bab/Materi <small class="text-muted">(Opsional)</small>
                                                </label>
                                                <input type="text" name="detail_bab_8" id="detail_bab_8" 
                                                       class="form-control" 
                                                       placeholder="Contoh: Bab 2, Materi Persamaan Linear"
                                                       value="{{ old('detail_bab_8') }}"
                                                       style="font-size: 1rem !important; padding: 0.75rem !important;">
                                                <small class="text-muted">Contoh: Bab 2 atau Materi Persamaan Linear</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Instruksi Tugas -->
                                        <div class="mb-3">
                                            <label for="tugas_kelas_8" class="form-label">
                                                Instruksi Tugas <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="tugas_kelas_8" id="tugas_kelas_8" rows="5"
                                                      class="form-control tugas-textarea @error('tugas_kelas_8') is-invalid @enderror"
                                                      placeholder="Contoh: Buat catatan materi baru dan kerjakan latihan 3. Presentasikan hasil pada pertemuan berikutnya." 
                                                      style="font-size: 1rem !important; resize: vertical; min-height: 120px !important; line-height: 1.5 !important; padding: 0.75rem !important; word-wrap: break-word !important; overflow-wrap: break-word !important; white-space: pre-wrap !important; width: 100% !important;">{{ old('tugas_kelas_8') }}</textarea>
                                            @error('tugas_kelas_8')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Kelas 9 -->
                                    <div id="tugas-kelas-9-wrapper" class="tugas-kelas-wrapper mb-4 p-3 border rounded" style="display: none !important; visibility: hidden !important; opacity: 0 !important; background-color: #f8f9fa;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">
                                                <i class="fas fa-book me-2 text-success"></i>Tugas untuk Kelas 9
                                            </h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(typeof hapusTugasKelas === 'function') { hapusTugasKelas(9); } else if(typeof window.hapusTugasKelas === 'function') { window.hapusTugasKelas(9); } else { console.error('hapusTugasKelas not found'); } return false;">
                                                <i class="fas fa-times me-1"></i>Hapus
                                            </button>
                                        </div>
                                        
                                        <!-- Detail Tugas - Kolom untuk informasi detail -->
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-2">
                                                <label for="detail_halaman_9" class="form-label">
                                                    <i class="fas fa-file-alt me-1"></i>Halaman <small class="text-muted">(Opsional)</small>
                                                </label>
                                                <input type="text" name="detail_halaman_9" id="detail_halaman_9" 
                                                       class="form-control" 
                                                       placeholder="Contoh: Hal. 15-20, Hal. 25, Hal. 30-35"
                                                       value="{{ old('detail_halaman_9') }}"
                                                       style="font-size: 1rem !important; padding: 0.75rem !important;">
                                                <small class="text-muted">Contoh: Hal. 15-20 atau Hal. 25</small>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="detail_bab_9" class="form-label">
                                                    <i class="fas fa-bookmark me-1"></i>Bab/Materi <small class="text-muted">(Opsional)</small>
                                                </label>
                                                <input type="text" name="detail_bab_9" id="detail_bab_9" 
                                                       class="form-control" 
                                                       placeholder="Contoh: Bab 2, Materi Persamaan Linear"
                                                       value="{{ old('detail_bab_9') }}"
                                                       style="font-size: 1rem !important; padding: 0.75rem !important;">
                                                <small class="text-muted">Contoh: Bab 2 atau Materi Persamaan Linear</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Instruksi Tugas -->
                                        <div class="mb-3">
                                            <label for="tugas_kelas_9" class="form-label">
                                                Instruksi Tugas <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="tugas_kelas_9" id="tugas_kelas_9" rows="5"
                                                      class="form-control tugas-textarea @error('tugas_kelas_9') is-invalid @enderror"
                                                      placeholder="Contoh: Selesaikan paket ujian bab 4 dan kumpulkan besok. Pastikan semua soal dikerjakan dengan lengkap." 
                                                      style="font-size: 1rem !important; resize: vertical; min-height: 120px !important; line-height: 1.5 !important; padding: 0.75rem !important; word-wrap: break-word !important; overflow-wrap: break-word !important; white-space: pre-wrap !important; width: 100% !important;">{{ old('tugas_kelas_9') }}</textarea>
                                            @error('tugas_kelas_9')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <small class="text-muted d-block mt-2" style="font-size: 0.875rem;">
                                    <i class="fas fa-lightbulb me-1 text-warning"></i>
                                    Anda bisa memilih dan mengisi tugas untuk beberapa kelas. Minimal isi salah satu kelas.
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
                
                <!-- Status Presensi Hari Ini - Sembunyikan secara default, muncul setelah submit -->
                @if($todayPresensi)
                <div class="alert alert-{{ $todayPresensi->status_verifikasi === 'pending' ? 'warning' : ($todayPresensi->status_verifikasi === 'approved' ? 'success' : 'danger') }}" id="status-presensi-hari-ini" style="display: none !important; visibility: hidden !important; opacity: 0 !important; position: absolute !important; left: -9999px !important; height: 0 !important; overflow: hidden !important; margin: 0 !important; padding: 0 !important;">
                    <i class="fas fa-{{ $todayPresensi->status_verifikasi === 'pending' ? 'clock' : ($todayPresensi->status_verifikasi === 'approved' ? 'check-circle' : 'times-circle') }} me-2"></i>
                    Anda sudah melakukan presensi untuk <strong>hari ini ({{ $todayPresensi->tanggal->format('d/m/Y') }})</strong> sebagai <strong>{{ ucfirst($todayPresensi->jenis) }}</strong>.
                    
                    {{-- Informasi Waktu Absen --}}
                    @if($todayPresensi->jam_masuk || $todayPresensi->jam_keluar)
                        <div class="mt-3 p-3" style="background-color: rgba(255,255,255,0.3); border-radius: 8px; border-left: 4px solid {{ $todayPresensi->status_verifikasi === 'approved' ? '#28a745' : ($todayPresensi->status_verifikasi === 'pending' ? '#ffc107' : '#dc3545') }};">
                            <div class="row">
                                @if($todayPresensi->jam_masuk)
                                    <div class="col-md-6 mb-2">
                                        <strong><i class="fas fa-sign-in-alt me-2"></i>Absen Masuk:</strong>
                                        <div class="mt-1">
                                            <span class="badge bg-primary" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                                {{ date('H:i', strtotime($todayPresensi->jam_masuk)) }}
                                            </span>
                                            @if($todayPresensi->jenis === 'sakit')
                                                <small class="text-muted d-block mt-1">
                                                    <i class="fas fa-info-circle me-1"></i>Waktu mulai sakit
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if($todayPresensi->jam_keluar)
                                    <div class="col-md-6 mb-2">
                                        <strong><i class="fas fa-sign-out-alt me-2"></i>Absen Keluar:</strong>
                                        <div class="mt-1">
                                            <span class="badge bg-success" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                                {{ date('H:i', strtotime($todayPresensi->jam_keluar)) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    
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
                
                @endif
                
                <!-- Riwayat Presensi - Tampil ketika mode riwayat atau setelah submit -->
                <div class="card mt-4" id="riwayat-presensi-section" style="display: {{ $isRiwayat ? 'block' : 'none' }} !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">
                                    <i class="fas fa-history me-2"></i>Riwayat Presensi (30 Hari Terakhir)
                                </h5>
                                <small class="d-block mt-1" style="font-size: 0.85rem; opacity: 0.9;">
                                    <i class="fas fa-info-circle me-1"></i>Lihat semua presensi Anda dengan berbagai jenis (Hadir, Sakit, Izin)
                                </small>
                            </div>
                            @if($isRiwayat)
                            <div class="d-flex gap-2">
                                <a href="{{ route('guru.presensi.index') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-sign-in-alt me-1"></i> Presensi Masuk
                                </a>
                                <a href="{{ route('guru.presensi.index', ['type' => 'keluar']) }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i> Presensi Keluar
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 10%;">Tanggal</th>
                                        <th style="width: 8%;">Jenis</th>
                                        <th style="width: 12%;">Jam Masuk</th>
                                        <th style="width: 12%;">Jam Keluar</th>
                                        <th style="width: 20%;">Keterangan</th>
                                        <th style="width: 20%;">Tugas Pengganti</th>
                                        <th style="width: 10%;">Surat Sakit</th>
                                        <th style="width: 8%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($presensiHistory->count() > 0)
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
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-sign-in-alt me-2 text-primary"></i>
                                                        @if($p->jenis === 'sakit')
                                                            <span class="badge bg-danger text-white" style="font-size: 0.9rem;">{{ date('H:i', strtotime($p->jam_masuk)) }}</span>
                                                            <small class="text-muted d-block ms-4 mt-1">Mulai sakit</small>
                                                        @else
                                                            <span class="badge bg-primary text-white" style="font-size: 0.9rem;">{{ date('H:i', strtotime($p->jam_masuk)) }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($p->jam_keluar)
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-sign-out-alt me-2 text-success"></i>
                                                        <span class="badge bg-success text-white" style="font-size: 0.9rem;">{{ date('H:i', strtotime($p->jam_keluar)) }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $p->keterangan ?? '-' }}
                                            </td>
                                            <td>
                                                @if($p->tugas_kelas_7 || $p->tugas_kelas_8 || $p->tugas_kelas_9)
                                                    <ul class="mb-0 ps-3" style="font-size: 0.85rem;">
                                                        @if($p->tugas_kelas_7)
                                                            <li><strong>Kelas 7:</strong> {{ Str::limit($p->tugas_kelas_7, 50) }}</li>
                                                        @endif
                                                        @if($p->tugas_kelas_8)
                                                            <li><strong>Kelas 8:</strong> {{ Str::limit($p->tugas_kelas_8, 50) }}</li>
                                                        @endif
                                                        @if($p->tugas_kelas_9)
                                                            <li><strong>Kelas 9:</strong> {{ Str::limit($p->tugas_kelas_9, 50) }}</li>
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
                                                        <i class="fas fa-file-pdf me-1"></i>Lihat
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
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                                                <h5 class="text-muted">Belum Ada Riwayat Presensi</h5>
                                                <p class="text-muted mb-3">Anda belum melakukan presensi. Silakan isi presensi masuk terlebih dahulu.</p>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="{{ route('guru.presensi.index') }}" class="btn btn-success">
                                                        <i class="fas fa-sign-in-alt me-1"></i> Isi Presensi Masuk
                                                    </a>
                                                    <a href="{{ route('guru.presensi.index', ['type' => 'keluar']) }}" class="btn btn-primary">
                                                        <i class="fas fa-sign-out-alt me-1"></i> Isi Presensi Keluar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ============================================
        // FUNGSI UTAMA - DITETAPKAN SEBELUM SEMUA KODE LAINNYA
        // ============================================
        
        // Fungsi untuk menampilkan kolom tugas - SIMPLE & DIRECT
        // PASTIKAN FUNGSI INI DITETAPKAN PERTAMA KALI
        function tampilkanKolomTugas(kelas) {
            console.log('=== tampilkanKolomTugas CALLED ===', kelas);
            
            // Jika kelas kosong, sembunyikan semua wrapper
            if (!kelas || kelas === '') {
                console.log('Kelas kosong, sembunyikan semua wrapper');
                const semuaWrapper = document.querySelectorAll('.tugas-kelas-wrapper');
                semuaWrapper.forEach(w => {
                    w.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                    w.style.setProperty('display', 'none', 'important');
                    w.style.setProperty('visibility', 'hidden', 'important');
                    w.style.setProperty('opacity', '0', 'important');
                    w.classList.add('d-none');
                    w.setAttribute('hidden', 'true');
                });
                
                const container = document.getElementById('tugas-kelas-container');
                if (container) {
                    container.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                    container.classList.add('d-none');
                    container.setAttribute('hidden', 'true');
                }
                return;
            }
            
            // Pastikan tugas section tampil
            const tugasSection = document.getElementById('tugas-section');
            if (tugasSection) {
                tugasSection.style.setProperty('display', 'block', 'important');
                tugasSection.style.setProperty('visibility', 'visible', 'important');
                tugasSection.style.setProperty('opacity', '1', 'important');
            }
            
            // SEMBUNYIKAN SEMUA WRAPPER TERLEBIH DAHULU
            const semuaWrapper = document.querySelectorAll('.tugas-kelas-wrapper');
            console.log('Sembunyikan semua wrapper:', semuaWrapper.length);
            semuaWrapper.forEach(w => {
                const kelasWrapper = w.id.replace('tugas-kelas-', '').replace('-wrapper', '');
                if (kelasWrapper !== kelas) {
                    // Sembunyikan wrapper yang bukan kelas yang dipilih
                    w.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                    w.style.setProperty('display', 'none', 'important');
                    w.style.setProperty('visibility', 'hidden', 'important');
                    w.style.setProperty('opacity', '0', 'important');
                    w.classList.add('d-none');
                    w.setAttribute('hidden', 'true');
                    console.log('✓ Hidden wrapper:', w.id);
                }
            });
            
            // Tampilkan wrapper untuk kelas yang dipilih
            const wrapper = document.getElementById('tugas-kelas-' + kelas + '-wrapper');
            const container = document.getElementById('tugas-kelas-container');
            
            console.log('Wrapper ID:', 'tugas-kelas-' + kelas + '-wrapper');
            console.log('Wrapper found:', !!wrapper);
            console.log('Container found:', !!container);
            
            if (wrapper) {
                // Tampilkan wrapper - ULTRA AGGRESSIVE
                wrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; background-color: #f8f9fa !important;';
                wrapper.style.setProperty('display', 'block', 'important');
                wrapper.style.setProperty('visibility', 'visible', 'important');
                wrapper.style.setProperty('opacity', '1', 'important');
                wrapper.style.setProperty('position', 'relative', 'important');
                wrapper.style.setProperty('background-color', '#f8f9fa', 'important');
                wrapper.classList.remove('d-none');
                wrapper.removeAttribute('hidden');
                
                // Pastikan semua child element juga visible
                const allChildren = wrapper.querySelectorAll('*');
                allChildren.forEach(child => {
                    if (child.tagName !== 'SCRIPT' && child.tagName !== 'STYLE') {
                        child.style.setProperty('display', '', 'important');
                        child.style.setProperty('visibility', 'visible', 'important');
                        child.style.setProperty('opacity', '1', 'important');
                    }
                });
                
                console.log('✓ Wrapper displayed', wrapper.offsetHeight, wrapper.offsetWidth);
                console.log('Wrapper computed style:', window.getComputedStyle(wrapper).display);
            } else {
                console.error('✗ Wrapper not found:', 'tugas-kelas-' + kelas + '-wrapper');
                // Debug: cari semua element dengan id yang mengandung tugas-kelas
                const allElements = document.querySelectorAll('[id*="tugas-kelas"]');
                console.log('All tugas-kelas elements found:', allElements.length);
                allElements.forEach(el => {
                    console.log('  -', el.id, el.tagName, 'display:', window.getComputedStyle(el).display);
                });
            }
            
            if (container) {
                // Tampilkan container - ULTRA AGGRESSIVE
                container.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;';
                container.style.setProperty('display', 'block', 'important');
                container.style.setProperty('visibility', 'visible', 'important');
                container.style.setProperty('opacity', '1', 'important');
                container.style.setProperty('position', 'relative', 'important');
                container.classList.remove('d-none');
                container.removeAttribute('hidden');
                
                // Pastikan parent juga visible
                const parent = container.parentElement;
                if (parent) {
                    parent.style.setProperty('display', 'block', 'important');
                    parent.style.setProperty('visibility', 'visible', 'important');
                    parent.style.setProperty('opacity', '1', 'important');
                }
                
                console.log('✓ Container displayed', container.offsetHeight, container.offsetWidth);
                console.log('Container computed style:', window.getComputedStyle(container).display);
            } else {
                console.error('✗ Container not found');
            }
            
            // JANGAN RESET DROPDOWN - biarkan user melihat pilihan mereka
            // Scroll ke wrapper
            if (wrapper) {
                setTimeout(() => {
                    wrapper.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 200);
            }
        }
        
        // Fungsi untuk menghapus tugas kelas - SIMPLE & DIRECT
        function hapusTugasKelas(kelas) {
            console.log('=== hapusTugasKelas CALLED ===', kelas);
            
            if (!kelas) {
                console.log('Kelas kosong, return');
                return;
            }
            
            const wrapper = document.getElementById('tugas-kelas-' + kelas + '-wrapper');
            const textarea = document.getElementById('tugas_kelas_' + kelas);
            const halamanInput = document.getElementById('detail_halaman_' + kelas);
            const babInput = document.getElementById('detail_bab_' + kelas);
            
            console.log('Wrapper found:', !!wrapper);
            console.log('Textarea found:', !!textarea);
            console.log('Halaman input found:', !!halamanInput);
            console.log('Bab input found:', !!babInput);
            
            if (wrapper) {
                // Hapus isi textarea
                if (textarea) {
                    textarea.value = '';
                    console.log('✓ Textarea cleared');
                }
                
                // Hapus isi input halaman dan bab
                if (halamanInput) {
                    halamanInput.value = '';
                    console.log('✓ Halaman input cleared');
                }
                if (babInput) {
                    babInput.value = '';
                    console.log('✓ Bab input cleared');
                }
                
                // Sembunyikan wrapper - ULTRA AGGRESSIVE
                wrapper.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                wrapper.style.setProperty('display', 'none', 'important');
                wrapper.style.setProperty('visibility', 'hidden', 'important');
                wrapper.style.setProperty('opacity', '0', 'important');
                wrapper.classList.add('d-none');
                wrapper.setAttribute('hidden', 'true');
                
                console.log('✓ Wrapper hidden');
                
                // Reset dropdown jika semua kelas sudah dihapus
                const semuaWrapper = document.querySelectorAll('.tugas-kelas-wrapper');
                let semuaVisible = false;
                
                semuaWrapper.forEach(w => {
                    const display = window.getComputedStyle(w).display;
                    const visibility = window.getComputedStyle(w).visibility;
                    const opacity = window.getComputedStyle(w).opacity;
                    
                    if (display === 'block' && visibility === 'visible' && opacity !== '0') {
                        semuaVisible = true;
                    }
                });
                
                console.log('Semua wrapper visible?', semuaVisible);
                
                if (!semuaVisible) {
                    const container = document.getElementById('tugas-kelas-container');
                    if (container) {
                        container.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                        container.style.setProperty('display', 'none', 'important');
                        container.style.setProperty('visibility', 'hidden', 'important');
                        container.style.setProperty('opacity', '0', 'important');
                        container.classList.add('d-none');
                        container.setAttribute('hidden', 'true');
                        console.log('✓ Container hidden (all classes removed)');
                    }
                    const dropdown = document.getElementById('pilih-kelas-tugas');
                    if (dropdown) {
                        dropdown.value = '';
                        console.log('✓ Dropdown reset');
                    }
                }
            } else {
                console.error('✗ Wrapper not found:', 'tugas-kelas-' + kelas + '-wrapper');
            }
            
            console.log('=== hapusTugasKelas COMPLETED ===');
        }
        
        // Assign ke window untuk akses global
        window.tampilkanKolomTugas = tampilkanKolomTugas;
        window.hapusTugasKelas = hapusTugasKelas;
        
        // Pastikan fungsi bisa diakses dari inline onclick
        console.log('tampilkanKolomTugas function defined:', typeof window.tampilkanKolomTugas);
        console.log('hapusTugasKelas function defined:', typeof window.hapusTugasKelas);
        
        // PASTIKAN FUNGSI INI DITETAPKAN SEBELUM SEMUA KODE LAINNYA - PENTING!
        // Definisikan fungsi selectPresensiType sebagai GLOBAL FUNCTION yang bisa diakses dari mana saja
        window.selectPresensiType = function(type) {
            console.log('=== selectPresensiType CALLED ===', type);
            
            if (!type) {
                console.error('selectPresensiType: type is required');
                return;
            }
            
            // Pastikan card bisa diklik
            const cardIds = ['card-hadir', 'card-sakit', 'card-izin'];
            cardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.setProperty('pointer-events', 'auto', 'important');
                    card.style.setProperty('cursor', 'pointer', 'important');
                    card.style.setProperty('z-index', '9999', 'important');
                }
            });
            
            // Remove active class from all cards
            const allCards = ['card-hadir', 'card-sakit', 'card-izin'];
            allCards.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.classList.remove('active');
                    card.style.setProperty('width', '100%', 'important');
                    card.style.setProperty('height', '100px', 'important');
                    card.style.setProperty('min-height', '100px', 'important');
                    card.style.setProperty('max-height', '100px', 'important');
                }
            });
            
            // Uncheck all radios
            document.querySelectorAll('input[name="jenis"]').forEach(radio => {
                radio.checked = false;
            });
            
            // Activate selected card and radio
            const selectedCard = document.getElementById('card-' + type);
            if (selectedCard) {
                selectedCard.classList.add('active');
                const radio = document.getElementById('jenis-' + type);
                if (radio) {
                    radio.checked = true;
                }
                
                // Pastikan ukuran tetap sama
                selectedCard.style.setProperty('width', '100%', 'important');
                selectedCard.style.setProperty('height', '100px', 'important');
                selectedCard.style.setProperty('min-height', '100px', 'important');
                selectedCard.style.setProperty('max-height', '100px', 'important');
            }
            
            // Show/hide sections based on type
            const jamSection = document.getElementById('jam-section');
            const keteranganSection = document.getElementById('keterangan-section');
            const jamMasuk = document.getElementById('jam_masuk');
            const keterangan = document.getElementById('keterangan');
            const tugasSection = document.getElementById('tugas-section');
            const suratSakitSection = document.getElementById('surat-sakit-section');
            const presensiSidebar = document.getElementById('presensi-sidebar');
            const formMainSection = document.getElementById('form-main-section');
            
            if (type === 'hadir') {
                if (jamSection) jamSection.style.display = 'block';
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'none', 'important');
                    keteranganSection.style.setProperty('visibility', 'hidden', 'important');
                    keteranganSection.style.setProperty('opacity', '0', 'important');
                }
                if (jamMasuk) jamMasuk.required = true;
                if (keterangan) keterangan.required = false;
                if (jamMasuk && !jamMasuk.value) {
                    if (window.setCurrentTime) window.setCurrentTime('jam_masuk');
                }
                // SEMBUNYIKAN tugas section dan sidebar untuk HADIR
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'none', 'important');
                    tugasSection.style.setProperty('visibility', 'hidden', 'important');
                    tugasSection.style.setProperty('opacity', '0', 'important');
                }
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'none', 'important');
                    presensiSidebar.style.setProperty('visibility', 'hidden', 'important');
                    presensiSidebar.style.setProperty('opacity', '0', 'important');
                }
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'none', 'important');
                    suratSakitSection.style.setProperty('visibility', 'hidden', 'important');
                    suratSakitSection.style.setProperty('opacity', '0', 'important');
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) suratSakitInput.value = '';
                    if (window.clearSuratSakit) window.clearSuratSakit();
                }
                // Gunakan layout 1 kolom penuh untuk HADIR (karena tidak ada sidebar)
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-7');
                    formMainSection.classList.add('col-lg-12');
                }
            } else if (type === 'izin') {
                if (jamSection) jamSection.style.display = 'none';
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'block', 'important');
                    keteranganSection.style.setProperty('visibility', 'visible', 'important');
                    keteranganSection.style.setProperty('opacity', '1', 'important');
                }
                if (jamMasuk) jamMasuk.required = false;
                if (keterangan) keterangan.required = true;
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'block', 'important');
                    presensiSidebar.style.setProperty('visibility', 'visible', 'important');
                    presensiSidebar.style.setProperty('opacity', '1', 'important');
                }
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-12');
                    formMainSection.classList.add('col-lg-7');
                }
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'block', 'important');
                    tugasSection.style.setProperty('visibility', 'visible', 'important');
                    tugasSection.style.setProperty('opacity', '1', 'important');
                }
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'none', 'important');
                    suratSakitSection.style.setProperty('visibility', 'hidden', 'important');
                    suratSakitSection.style.setProperty('opacity', '0', 'important');
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) suratSakitInput.value = '';
                    if (window.clearSuratSakit) window.clearSuratSakit();
                }
            } else { // sakit
                if (jamSection) jamSection.style.display = 'block';
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'none', 'important');
                    keteranganSection.style.setProperty('visibility', 'hidden', 'important');
                    keteranganSection.style.setProperty('opacity', '0', 'important');
                }
                if (jamMasuk) jamMasuk.required = true;
                if (keterangan) keterangan.required = false;
                if (jamMasuk && !jamMasuk.value) {
                    if (window.setCurrentTime) window.setCurrentTime('jam_masuk');
                }
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'block', 'important');
                    presensiSidebar.style.setProperty('visibility', 'visible', 'important');
                    presensiSidebar.style.setProperty('opacity', '1', 'important');
                }
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-12');
                    formMainSection.classList.add('col-lg-7');
                }
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'block', 'important');
                    tugasSection.style.setProperty('visibility', 'visible', 'important');
                    tugasSection.style.setProperty('opacity', '1', 'important');
                }
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'block', 'important');
                    suratSakitSection.style.setProperty('visibility', 'visible', 'important');
                    suratSakitSection.style.setProperty('opacity', '1', 'important');
                }
            }
            
            // Pastikan ukuran card tetap konsisten
            if (window.ensureConsistentCardSize) {
                window.ensureConsistentCardSize();
            }
            
            // Pastikan semua card tetap bisa diklik
            cardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.setProperty('pointer-events', 'auto', 'important');
                    card.style.setProperty('cursor', 'pointer', 'important');
                    card.style.setProperty('z-index', '9999', 'important');
                }
            });
            
            console.log('=== selectPresensiType COMPLETED ===', type);
        };
        
        // Definisikan fungsi-fungsi pendukung juga
        window.setCurrentTime = function(fieldId) {
            try {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const currentTime = hours + ':' + minutes;
                
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = currentTime;
                    
                    // Visual feedback
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
            } catch (e) {
                console.error('Error in setCurrentTime:', e);
            }
        };
        
        window.clearSuratSakit = function() {
            const suratSakitInput = document.getElementById('surat_sakit');
            const previewDiv = document.getElementById('surat-sakit-preview');
            if (suratSakitInput) {
                suratSakitInput.value = '';
            }
            if (previewDiv) {
                previewDiv.style.display = 'none';
            }
        };
        
        window.ensureConsistentCardSize = function() {
            const cardIds = ['card-hadir', 'card-sakit', 'card-izin'];
            cardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.setProperty('width', '100%', 'important');
                    card.style.setProperty('height', '100px', 'important');
                    card.style.setProperty('min-height', '100px', 'important');
                    card.style.setProperty('max-height', '100px', 'important');
                    card.style.setProperty('box-sizing', 'border-box', 'important');
                    card.style.setProperty('transform', 'none', 'important');
                    card.style.setProperty('scale', '1', 'important');
                    card.style.setProperty('margin', '0', 'important');
                    card.style.setProperty('padding', '0', 'important');
                    card.style.setProperty('flex', '0 0 auto', 'important');
                    card.style.setProperty('display', 'flex', 'important');
                    card.style.setProperty('align-items', 'center', 'important');
                    card.style.setProperty('justify-content', 'center', 'important');
                    card.style.height = '100px';
                    card.style.minHeight = '100px';
                    card.style.maxHeight = '100px';
                }
            });
        };
        
        // Fungsi tampilkanKolomTugas sudah didefinisikan di script pertama di atas
        // Tidak perlu didefinisikan lagi di sini
        
        // Pastikan fungsi ini bisa diakses langsung juga (untuk kompatibilitas)
        function selectPresensiType(type) {
            if (window.selectPresensiType && typeof window.selectPresensiType === 'function') {
                window.selectPresensiType(type);
            } else {
                console.error('window.selectPresensiType is not available!');
            }
        }
        
        console.log('tampilkanKolomTugas function defined:', typeof window.tampilkanKolomTugas);
        console.log('selectPresensiType function defined:', typeof window.selectPresensiType);
        console.log('setCurrentTime function defined:', typeof window.setCurrentTime);
        console.log('clearSuratSakit function defined:', typeof window.clearSuratSakit);
        console.log('ensureConsistentCardSize function defined:', typeof window.ensureConsistentCardSize);
        
        // Fungsi untuk menampilkan textarea berdasarkan kelas yang dipilih - ULTRA AGGRESSIVE
        // PASTIKAN FUNGSI INI DITETAPKAN SEBELUM DOMContentLoaded
        window.tampilkanTugasKelas = function(kelas) {
            console.log('=== tampilkanTugasKelas CALLED ===', kelas);
            const wrapperId = 'tugas-kelas-' + kelas + '-wrapper';
            const wrapper = document.getElementById(wrapperId);
            const container = document.getElementById('tugas-kelas-container');
            
            console.log('wrapper ID:', wrapperId);
            console.log('wrapper found:', !!wrapper);
            console.log('container found:', !!container);
            
            if (wrapper) {
                // Tampilkan wrapper dengan style yang jelas - ULTRA AGGRESSIVE
                wrapper.style.setProperty('display', 'block', 'important');
                wrapper.style.setProperty('visibility', 'visible', 'important');
                wrapper.style.setProperty('opacity', '1', 'important');
                wrapper.style.setProperty('position', 'relative', 'important');
                wrapper.style.setProperty('z-index', '10', 'important');
                wrapper.style.removeProperty('height');
                wrapper.style.removeProperty('overflow');
                wrapper.style.removeProperty('left');
                wrapper.style.removeProperty('top');
                
                // Pastikan semua child element juga visible
                const allChildren = wrapper.querySelectorAll('*');
                allChildren.forEach(child => {
                    if (child.tagName !== 'SCRIPT' && child.tagName !== 'STYLE') {
                        child.style.setProperty('display', '', 'important');
                        child.style.setProperty('visibility', 'visible', 'important');
                        child.style.setProperty('opacity', '1', 'important');
                    }
                });
                
                // Pastikan input dan textarea juga visible
                const inputs = wrapper.querySelectorAll('input, textarea, label, button, select');
                inputs.forEach(input => {
                    input.style.setProperty('display', '', 'important');
                    input.style.setProperty('visibility', 'visible', 'important');
                    input.style.setProperty('opacity', '1', 'important');
                });
                
                console.log('Wrapper displayed successfully');
            } else {
                console.error('Wrapper not found! ID:', wrapperId);
                // Coba cari dengan cara lain
                const allWrappers = document.querySelectorAll('[id*="tugas-kelas"]');
                console.log('All tugas-kelas elements found:', allWrappers.length);
                allWrappers.forEach(w => console.log('Found:', w.id));
            }
            
            if (container) {
                // Tampilkan container - ULTRA AGGRESSIVE
                container.style.setProperty('display', 'block', 'important');
                container.style.setProperty('visibility', 'visible', 'important');
                container.style.setProperty('opacity', '1', 'important');
                container.style.setProperty('position', 'relative', 'important');
                container.style.removeProperty('height');
                container.style.removeProperty('overflow');
                container.style.removeProperty('left');
                container.style.removeProperty('top');
                
                // Pastikan container tidak tersembunyi oleh parent
                const containerParent = container.parentElement;
                if (containerParent) {
                    containerParent.style.setProperty('display', 'block', 'important');
                    containerParent.style.setProperty('visibility', 'visible', 'important');
                    containerParent.style.setProperty('opacity', '1', 'important');
                }
                
                console.log('Container displayed successfully');
            } else {
                console.error('Container not found!');
            }
            
            // Scroll ke textarea yang baru ditampilkan
            if (wrapper) {
                setTimeout(() => {
                    wrapper.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 200);
            }
            
            console.log('=== tampilkanTugasKelas COMPLETED ===');
        };
        
        // Fungsi untuk menghapus tugas kelas
        // Fungsi hapusTugasKelas sudah didefinisikan di script pertama di atas
        // Tidak perlu didefinisikan lagi di sini
        
    </script>
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
        
        // OPTIMIZED: Gabungkan semua DOMContentLoaded menjadi satu untuk performa lebih baik
        // DEFINE FUNGSI UTAMA SEBELUM DOMContentLoaded - PENTING UNTUK PERFORMANCE!
        // Pastikan semua fungsi bisa diakses dari onclick attribute
        
        // Function to set current time
        function setCurrentTime(fieldId) {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const currentTime = hours + ':' + minutes;
            
            const field = document.getElementById(fieldId);
            if (field) {
                field.value = currentTime;
                
                // Visual feedback
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
        
        // Function to ensure consistent card size
        function ensureConsistentCardSize() {
            const cardIds = ['card-hadir', 'card-sakit', 'card-izin'];
            cardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.setProperty('width', '100%', 'important');
                    card.style.setProperty('height', '100px', 'important');
                    card.style.setProperty('min-height', '100px', 'important');
                    card.style.setProperty('max-height', '100px', 'important');
                    card.style.setProperty('box-sizing', 'border-box', 'important');
                    card.style.setProperty('transform', 'none', 'important');
                    card.style.setProperty('scale', '1', 'important');
                    card.style.setProperty('margin', '0', 'important');
                    card.style.setProperty('padding', '0', 'important');
                    card.style.setProperty('flex', '0 0 auto', 'important');
                    card.style.setProperty('display', 'flex', 'important');
                    card.style.setProperty('align-items', 'center', 'important');
                    card.style.setProperty('justify-content', 'center', 'important');
                    card.style.height = '100px';
                    card.style.minHeight = '100px';
                    card.style.maxHeight = '100px';
                }
            });
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
        
        // FUNGSI selectPresensiType SUDAH DIDEFINISIKAN DI ATAS (di script pertama)
        // Gunakan window.selectPresensiType yang sudah didefinisikan di atas
        // Tidak perlu didefinisikan lagi di sini
            console.log('selectPresensiType called with:', type);
            if (!type) {
                console.error('selectPresensiType: type is required');
                return;
            }
            
            // Pastikan card bisa diklik sebelum memproses - ULTRA AGGRESSIVE
            const cardIds = ['card-hadir', 'card-sakit', 'card-izin'];
            cardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.setProperty('pointer-events', 'auto', 'important');
                    card.style.setProperty('cursor', 'pointer', 'important');
                    card.style.setProperty('z-index', '999', 'important');
                    card.style.setProperty('position', 'relative', 'important');
                }
            });
            
            // Remove active class from all cards dan pastikan ukuran tetap sama
            const allCards = ['card-hadir', 'card-sakit', 'card-izin'];
            allCards.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.classList.remove('active');
                    // Pastikan ukuran tetap sama untuk semua card
                    card.style.setProperty('width', '100%', 'important');
                    card.style.setProperty('height', '100px', 'important');
                    card.style.setProperty('min-height', '100px', 'important');
                    card.style.setProperty('max-height', '100px', 'important');
                    card.style.setProperty('box-sizing', 'border-box', 'important');
                    card.style.setProperty('transform', 'none', 'important');
                    card.style.setProperty('scale', '1', 'important');
                    card.style.setProperty('margin', '0', 'important');
                    card.style.setProperty('padding', '0', 'important');
                    card.style.setProperty('flex', '0 0 auto', 'important');
                    card.style.setProperty('display', 'flex', 'important');
                    card.style.setProperty('align-items', 'center', 'important');
                    card.style.setProperty('justify-content', 'center', 'important');
                    card.style.height = '100px';
                    card.style.minHeight = '100px';
                    card.style.maxHeight = '100px';
                }
            });
            
            // Uncheck all radios
            document.querySelectorAll('input[name="jenis"]').forEach(radio => {
                radio.checked = false;
            });
            
            // Activate selected card and radio
            const selectedCard = document.getElementById('card-' + type);
            if (selectedCard) {
                selectedCard.classList.add('active');
                const radio = document.getElementById('jenis-' + type);
                if (radio) {
                    radio.checked = true;
                }
                
                // Pastikan ukuran card yang dipilih tetap sama
                selectedCard.style.setProperty('width', '100%', 'important');
                selectedCard.style.setProperty('height', '100px', 'important');
                selectedCard.style.setProperty('min-height', '100px', 'important');
                selectedCard.style.setProperty('max-height', '100px', 'important');
                selectedCard.style.setProperty('box-sizing', 'border-box', 'important');
                selectedCard.style.setProperty('transform', 'none', 'important');
                selectedCard.style.setProperty('scale', '1', 'important');
                selectedCard.style.setProperty('margin', '0', 'important');
                selectedCard.style.setProperty('padding', '0', 'important');
                selectedCard.style.setProperty('flex', '0 0 auto', 'important');
                selectedCard.style.setProperty('display', 'flex', 'important');
                selectedCard.style.setProperty('align-items', 'center', 'important');
                selectedCard.style.setProperty('justify-content', 'center', 'important');
                selectedCard.style.height = '100px';
                selectedCard.style.minHeight = '100px';
                selectedCard.style.maxHeight = '100px';
            }
            
            // Show/hide sections based on type
            const jamSection = document.getElementById('jam-section');
            const keteranganSection = document.getElementById('keterangan-section');
            const jamMasuk = document.getElementById('jam_masuk');
            const keterangan = document.getElementById('keterangan');
            const tugasSection = document.getElementById('tugas-section');
            const suratSakitSection = document.getElementById('surat-sakit-section');
            const presensiSidebar = document.getElementById('presensi-sidebar');
            const formMainSection = document.getElementById('form-main-section');
            
            // LOGIKA UTAMA: Tampilkan/sembunyikan section berdasarkan jenis presensi
            if (type === 'hadir') {
                // HADIR: Tampilkan jam masuk, SEMBUNYIKAN tugas section dan sidebar
                if (jamSection) jamSection.style.display = 'block';
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'none', 'important');
                    keteranganSection.style.setProperty('visibility', 'hidden', 'important');
                    keteranganSection.style.setProperty('opacity', '0', 'important');
                }
                if (jamMasuk) jamMasuk.required = true;
                if (keterangan) keterangan.required = false;
                // Auto-fill jam masuk saat pilih hadir
                if (jamMasuk && !jamMasuk.value && typeof setCurrentTime === 'function') {
                    setCurrentTime('jam_masuk');
                }
                // SEMBUNYIKAN tugas section untuk HADIR (tidak perlu tugas pengganti)
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'none', 'important');
                    tugasSection.style.setProperty('visibility', 'hidden', 'important');
                    tugasSection.style.setProperty('opacity', '0', 'important');
                }
                // SEMBUNYIKAN sidebar untuk HADIR (tidak perlu informasi tambahan)
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'none', 'important');
                    presensiSidebar.style.setProperty('visibility', 'hidden', 'important');
                    presensiSidebar.style.setProperty('opacity', '0', 'important');
                }
                // SEMBUNYIKAN surat sakit section untuk HADIR
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'none', 'important');
                    suratSakitSection.style.setProperty('visibility', 'hidden', 'important');
                    suratSakitSection.style.setProperty('opacity', '0', 'important');
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) suratSakitInput.value = '';
                    if (typeof clearSuratSakit === 'function') clearSuratSakit();
                }
                // Gunakan layout 1 kolom penuh untuk HADIR (karena tidak ada sidebar)
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-7');
                    formMainSection.classList.add('col-lg-12');
                }
            } else if (type === 'izin') {
                // IZIN: Tampilkan keterangan, tugas, dan sidebar
                if (jamSection) jamSection.style.display = 'none';
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'block', 'important');
                    keteranganSection.style.setProperty('visibility', 'visible', 'important');
                    keteranganSection.style.setProperty('opacity', '1', 'important');
                }
                if (jamMasuk) jamMasuk.required = false;
                if (keterangan) keterangan.required = true;
                // Tampilkan sidebar untuk izin
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'block', 'important');
                    presensiSidebar.style.setProperty('visibility', 'visible', 'important');
                    presensiSidebar.style.setProperty('opacity', '1', 'important');
                }
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-12');
                    formMainSection.classList.add('col-lg-7');
                }
                // TAMPILKAN section tugas untuk izin
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'block', 'important');
                    tugasSection.style.setProperty('visibility', 'visible', 'important');
                    tugasSection.style.setProperty('opacity', '1', 'important');
                }
                // Surat sakit tidak diperlukan untuk izin
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'none', 'important');
                    suratSakitSection.style.setProperty('visibility', 'hidden', 'important');
                    suratSakitSection.style.setProperty('opacity', '0', 'important');
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) suratSakitInput.value = '';
                    if (typeof clearSuratSakit === 'function') clearSuratSakit();
                }
            } else { // sakit
                // SAKIT: Tampilkan jam masuk, tugas, surat sakit, dan sidebar
                if (jamSection) jamSection.style.display = 'block';
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'none', 'important');
                    keteranganSection.style.setProperty('visibility', 'hidden', 'important');
                    keteranganSection.style.setProperty('opacity', '0', 'important');
                }
                if (jamMasuk) jamMasuk.required = true;
                if (keterangan) keterangan.required = false;
                // Auto-fill jam masuk saat pilih sakit
                if (jamMasuk && !jamMasuk.value && typeof setCurrentTime === 'function') {
                    setCurrentTime('jam_masuk');
                }
                // Tampilkan sidebar untuk sakit
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'block', 'important');
                    presensiSidebar.style.setProperty('visibility', 'visible', 'important');
                    presensiSidebar.style.setProperty('opacity', '1', 'important');
                }
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-12');
                    formMainSection.classList.add('col-lg-7');
                }
                // TAMPILKAN section tugas untuk sakit
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'block', 'important');
                    tugasSection.style.setProperty('visibility', 'visible', 'important');
                    tugasSection.style.setProperty('opacity', '1', 'important');
                }
                // Tampilkan surat sakit section untuk sakit
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'block', 'important');
                    suratSakitSection.style.setProperty('visibility', 'visible', 'important');
                    suratSakitSection.style.setProperty('opacity', '1', 'important');
                }
            }
            
            // Pastikan ukuran card tetap konsisten setelah perubahan
            if (typeof ensureConsistentCardSize === 'function') {
                ensureConsistentCardSize();
            }
            
            // Pastikan semua card tetap bisa diklik setelah perubahan
            const allCardIds = ['card-hadir', 'card-sakit', 'card-izin'];
            allCardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.setProperty('pointer-events', 'auto', 'important');
                    card.style.setProperty('cursor', 'pointer', 'important');
                    card.style.setProperty('z-index', '999', 'important');
                    card.style.setProperty('position', 'relative', 'important');
                }
            });
        }
        
        // Pastikan fungsi-fungsi bisa diakses secara global
        window.setCurrentTime = setCurrentTime;
        window.clearSuratSakit = clearSuratSakit;
        window.ensureConsistentCardSize = ensureConsistentCardSize;
        
        // selectPresensiType sudah didefinisikan di script pertama, tidak perlu duplikasi
        
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure body has white background on page load
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.height = '';
            document.body.style.top = '';
            document.body.style.background = '#ffffff';
            document.body.style.backgroundColor = '#ffffff';
            
            // Setup dropdown untuk memilih kelas tugas - ULTRA AGGRESSIVE & DIRECT
            function setupDropdownTugas() {
                const pilihKelasDropdown = document.getElementById('pilih-kelas-tugas');
                if (pilihKelasDropdown) {
                    console.log('=== SETUP DROPDOWN TUGAS ===');
                    
                    // Hapus semua event listener lama
                    const newDropdown = pilihKelasDropdown.cloneNode(true);
                    pilihKelasDropdown.parentNode.replaceChild(newDropdown, pilihKelasDropdown);
                    
                    // Tambahkan event listener langsung - TIDAK PAKAI FUNGSI, LANGSUNG TAMPILKAN
                    newDropdown.addEventListener('change', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const kelasTerpilih = this.value;
                        console.log('=== DROPDOWN CHANGED ===', kelasTerpilih);
                        
                        if (kelasTerpilih) {
                            // Gunakan fungsi tampilkanKolomTugas yang sudah didefinisikan
                            if (typeof tampilkanKolomTugas === 'function') {
                                tampilkanKolomTugas(kelasTerpilih);
                            } else if (window.tampilkanKolomTugas && typeof window.tampilkanKolomTugas === 'function') {
                                window.tampilkanKolomTugas(kelasTerpilih);
                            } else {
                                // Fallback langsung
                                const tugasSection = document.getElementById('tugas-section');
                                if (tugasSection) {
                                    tugasSection.style.setProperty('display', 'block', 'important');
                                    tugasSection.style.setProperty('visibility', 'visible', 'important');
                                    tugasSection.style.setProperty('opacity', '1', 'important');
                                }
                                
                                const wrapper = document.getElementById('tugas-kelas-' + kelasTerpilih + '-wrapper');
                                const container = document.getElementById('tugas-kelas-container');
                                
                                if (wrapper) {
                                    wrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; background-color: #f8f9fa !important;';
                                }
                                
                                if (container) {
                                    container.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;';
                                }
                            }
                            
                            if (wrapper) {
                                // Tampilkan wrapper - ULTRA AGGRESSIVE
                                wrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; z-index: 10 !important; background-color: #f8f9fa !important;';
                                
                                // Hapus semua style yang menyembunyikan
                                wrapper.style.removeProperty('height');
                                wrapper.style.removeProperty('overflow');
                                wrapper.style.removeProperty('left');
                                wrapper.style.removeProperty('top');
                                wrapper.style.removeProperty('max-height');
                                wrapper.style.removeProperty('min-height');
                                
                                // Pastikan semua child visible - SEMUA ELEMENT
                                const allElements = wrapper.querySelectorAll('*');
                                allElements.forEach(el => {
                                    if (el.tagName !== 'SCRIPT' && el.tagName !== 'STYLE') {
                                        el.style.setProperty('display', '', 'important');
                                        el.style.setProperty('visibility', 'visible', 'important');
                                        el.style.setProperty('opacity', '1', 'important');
                                    }
                                });
                                
                                // Pastikan input, textarea, label, button, select visible
                                const allInputs = wrapper.querySelectorAll('input, textarea, label, button, select, div, h6, small');
                                allInputs.forEach(el => {
                                    el.style.setProperty('display', '', 'important');
                                    el.style.setProperty('visibility', 'visible', 'important');
                                    el.style.setProperty('opacity', '1', 'important');
                                });
                                
                                // Force remove d-none class jika ada
                                wrapper.classList.remove('d-none');
                                
                                console.log('Wrapper displayed!', wrapper.offsetHeight, wrapper.offsetWidth);
                            } else {
                                console.error('WRAPPER NOT FOUND!', wrapperId);
                                // Coba cari semua wrapper
                                const allWrappers = document.querySelectorAll('[id*="tugas-kelas"]');
                                console.log('All tugas-kelas elements:', allWrappers.length);
                                allWrappers.forEach(w => console.log('Found:', w.id, w.style.display, w.offsetHeight));
                            }
                            
                            if (container) {
                                // Tampilkan container - ULTRA AGGRESSIVE
                                container.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;';
                                
                                // Hapus semua style yang menyembunyikan
                                container.style.removeProperty('height');
                                container.style.removeProperty('overflow');
                                container.style.removeProperty('left');
                                container.style.removeProperty('top');
                                container.style.removeProperty('max-height');
                                container.style.removeProperty('min-height');
                                
                                // Force remove d-none class jika ada
                                container.classList.remove('d-none');
                                
                                console.log('Container displayed!', container.offsetHeight, container.offsetWidth);
                            }
                            
                            // Scroll ke wrapper
                            if (wrapper) {
                                setTimeout(() => {
                                    wrapper.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                                }, 200);
                            }
                            
                            // Reset dropdown setelah memilih (agar bisa pilih lagi)
                            setTimeout(() => {
                                this.value = '';
                            }, 100);
                        }
                    }, true); // Use capture phase
                    
                    // Juga tambahkan onclick sebagai backup - ULTRA AGGRESSIVE
                    newDropdown.onchange = function() {
                        const kelasTerpilih = this.value;
                        console.log('=== onchange backup called ===', kelasTerpilih);
                        if (kelasTerpilih) {
                            // PASTIKAN TUGAS SECTION TAMPIL
                            const tugasSection = document.getElementById('tugas-section');
                            if (tugasSection) {
                                tugasSection.style.setProperty('display', 'block', 'important');
                                tugasSection.style.setProperty('visibility', 'visible', 'important');
                                tugasSection.style.setProperty('opacity', '1', 'important');
                            }
                            
                            const wrapper = document.getElementById('tugas-kelas-' + kelasTerpilih + '-wrapper');
                            const container = document.getElementById('tugas-kelas-container');
                            
                            if (wrapper) {
                                wrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; background-color: #f8f9fa !important;';
                                wrapper.classList.remove('d-none');
                                wrapper.removeAttribute('hidden');
                                console.log('Wrapper displayed via onchange backup', wrapper.offsetHeight);
                            } else {
                                console.error('Wrapper not found in backup!', 'tugas-kelas-' + kelasTerpilih + '-wrapper');
                            }
                            
                            if (container) {
                                container.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;';
                                container.classList.remove('d-none');
                                container.removeAttribute('hidden');
                                console.log('Container displayed via onchange backup', container.offsetHeight);
                            } else {
                                console.error('Container not found in backup!');
                            }
                            
                            setTimeout(() => this.value = '', 100);
                        }
                    };
                    
                    // Juga tambahkan event listener dengan once:false untuk memastikan
                    newDropdown.addEventListener('change', function() {
                        console.log('Additional change listener triggered');
                    }, { once: false, capture: true });
                    
                    console.log('Dropdown setup completed');
                } else {
                    console.error('Dropdown pilih-kelas-tugas NOT FOUND!');
                }
            }
            
            // Setup dropdown saat DOM ready
            setupDropdownTugas();
            
            // Setup lagi setelah delay untuk memastikan - MULTIPLE TIMES
            setTimeout(setupDropdownTugas, 50);
            setTimeout(setupDropdownTugas, 100);
            setTimeout(setupDropdownTugas, 200);
            setTimeout(setupDropdownTugas, 500);
            setTimeout(setupDropdownTugas, 1000);
            
            // Test langsung: coba tampilkan wrapper jika ada old value
            setTimeout(function() {
                // Sembunyikan semua wrapper terlebih dahulu
                const semuaWrapper = document.querySelectorAll('.tugas-kelas-wrapper');
                semuaWrapper.forEach(w => {
                    w.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                    w.style.setProperty('display', 'none', 'important');
                    w.style.setProperty('visibility', 'hidden', 'important');
                    w.style.setProperty('opacity', '0', 'important');
                    w.classList.add('d-none');
                    w.setAttribute('hidden', 'true');
                });
                
                // Cek old values dan tampilkan hanya yang memiliki value
                const oldTugas7 = document.getElementById('tugas_kelas_7');
                const oldTugas8 = document.getElementById('tugas_kelas_8');
                const oldTugas9 = document.getElementById('tugas_kelas_9');
                
                const container = document.getElementById('tugas-kelas-container');
                let adaYangVisible = false;
                
                if (oldTugas7 && oldTugas7.value) {
                    console.log('Found old value for kelas 7, displaying wrapper');
                    const wrapper = document.getElementById('tugas-kelas-7-wrapper');
                    if (wrapper) {
                        wrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; background-color: #f8f9fa !important;';
                        wrapper.style.setProperty('display', 'block', 'important');
                        wrapper.style.setProperty('visibility', 'visible', 'important');
                        wrapper.style.setProperty('opacity', '1', 'important');
                        wrapper.classList.remove('d-none');
                        wrapper.removeAttribute('hidden');
                        adaYangVisible = true;
                    }
                }
                if (oldTugas8 && oldTugas8.value) {
                    console.log('Found old value for kelas 8, displaying wrapper');
                    const wrapper = document.getElementById('tugas-kelas-8-wrapper');
                    if (wrapper) {
                        wrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; background-color: #f8f9fa !important;';
                        wrapper.style.setProperty('display', 'block', 'important');
                        wrapper.style.setProperty('visibility', 'visible', 'important');
                        wrapper.style.setProperty('opacity', '1', 'important');
                        wrapper.classList.remove('d-none');
                        wrapper.removeAttribute('hidden');
                        adaYangVisible = true;
                    }
                }
                if (oldTugas9 && oldTugas9.value) {
                    console.log('Found old value for kelas 9, displaying wrapper');
                    const wrapper = document.getElementById('tugas-kelas-9-wrapper');
                    if (wrapper) {
                        wrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important; background-color: #f8f9fa !important;';
                        wrapper.style.setProperty('display', 'block', 'important');
                        wrapper.style.setProperty('visibility', 'visible', 'important');
                        wrapper.style.setProperty('opacity', '1', 'important');
                        wrapper.classList.remove('d-none');
                        wrapper.removeAttribute('hidden');
                        adaYangVisible = true;
                    }
                }
                
                // Tampilkan container hanya jika ada wrapper yang visible
                if (container) {
                    if (adaYangVisible) {
                        container.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;';
                        container.style.setProperty('display', 'block', 'important');
                        container.style.setProperty('visibility', 'visible', 'important');
                        container.style.setProperty('opacity', '1', 'important');
                        container.classList.remove('d-none');
                        container.removeAttribute('hidden');
                    } else {
                        container.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                        container.classList.add('d-none');
                        container.setAttribute('hidden', 'true');
                    }
                }
            }, 200);
            
            // Test manual: buat fungsi global untuk test dari console
            window.testTampilkanTugas = function(kelas) {
                console.log('=== TEST TAMPILKAN TUGAS ===', kelas);
                const wrapper = document.getElementById('tugas-kelas-' + kelas + '-wrapper');
                const container = document.getElementById('tugas-kelas-container');
                console.log('Wrapper:', wrapper);
                console.log('Container:', container);
                if (wrapper) {
                    wrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;';
                    console.log('Wrapper style applied');
                }
                if (container) {
                    container.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; position: relative !important;';
                    console.log('Container style applied');
                }
            };
            
            console.log('Test function created: window.testTampilkanTugas(kelas) - contoh: testTampilkanTugas("7")');
            
            // Jika ada old value, tampilkan textarea yang sudah terisi
            const oldTugas7 = document.getElementById('tugas_kelas_7');
            const oldTugas8 = document.getElementById('tugas_kelas_8');
            const oldTugas9 = document.getElementById('tugas_kelas_9');
            
            if (oldTugas7 && oldTugas7.value) {
                if (window.tampilkanTugasKelas) window.tampilkanTugasKelas('7');
            }
            if (oldTugas8 && oldTugas8.value) {
                if (window.tampilkanTugasKelas) window.tampilkanTugasKelas('8');
            }
            if (oldTugas9 && oldTugas9.value) {
                if (window.tampilkanTugasKelas) window.tampilkanTugasKelas('9');
            }
            
            // Close sidebar when clicking outside on mobile
            const overlay = document.querySelector('.sidebar-overlay');
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeSidebar();
                });
            }
            
            // Robust function to setup nav links - OPTIMIZED (hanya setup sekali, tidak perlu observer)
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
            
            // Setup nav links sekali saja (tidak perlu observer untuk performa)
            setupNavLinks();
            
            // PASTIKAN SIDEBAR TERLIHAT DI DESKTOP - ULTRA AGGRESSIVE
            function ensureSidebarVisible() {
                const sidebar = document.getElementById('guru-sidebar');
                if (sidebar) {
                    if (window.innerWidth >= 768) {
                        // Desktop: Pastikan sidebar terlihat penuh - OVERRIDE SEMUA
                        sidebar.style.setProperty('display', 'flex', 'important');
                        sidebar.style.setProperty('visibility', 'visible', 'important');
                        sidebar.style.setProperty('opacity', '1', 'important');
                        sidebar.style.setProperty('position', 'relative', 'important');
                        sidebar.style.setProperty('left', '0', 'important');
                        sidebar.style.setProperty('top', 'auto', 'important');
                        sidebar.style.setProperty('transform', 'translateX(0)', 'important');
                        sidebar.style.setProperty('transition', 'none', 'important');
                        
                        if (window.innerWidth >= 992) {
                            // Large screen
                            sidebar.style.setProperty('width', '16.66666667%', 'important');
                            sidebar.style.setProperty('max-width', '16.66666667%', 'important');
                            sidebar.style.setProperty('min-width', '200px', 'important');
                            sidebar.style.setProperty('flex', '0 0 16.66666667%', 'important');
                        } else {
                            // Medium screen
                            sidebar.style.setProperty('width', '25%', 'important');
                            sidebar.style.setProperty('max-width', '25%', 'important');
                            sidebar.style.setProperty('min-width', '250px', 'important');
                            sidebar.style.setProperty('flex', '0 0 25%', 'important');
                        }
                        
                        sidebar.style.setProperty('margin-left', '0', 'important');
                        sidebar.style.setProperty('margin-right', '0', 'important');
                        sidebar.style.setProperty('padding-left', '0', 'important');
                        sidebar.style.setProperty('padding-right', '0', 'important');
                        sidebar.style.setProperty('z-index', '1000', 'important');
                        sidebar.classList.remove('show'); // Remove show class yang mungkin menyembunyikan
                        
                        // Pastikan parent row juga menggunakan flex
                        const sidebarParent = sidebar.closest('.row');
                        if (sidebarParent) {
                            sidebarParent.style.setProperty('display', 'flex', 'important');
                            sidebarParent.style.setProperty('flex-wrap', 'nowrap', 'important');
                        }
                        
                        // Pastikan container-fluid juga menggunakan flex
                        const container = sidebar.closest('.container-fluid');
                        if (container) {
                            const row = container.querySelector('.row');
                            if (row) {
                                row.style.setProperty('display', 'flex', 'important');
                                row.style.setProperty('flex-wrap', 'nowrap', 'important');
                            }
                        }
                    } else {
                        // Mobile: Pastikan sidebar tersembunyi (kecuali dengan class show)
                        if (!sidebar.classList.contains('show')) {
                            sidebar.style.setProperty('left', '-100%', 'important');
                        }
                    }
                }
            }
            
            // Panggil fungsi saat page load - OPTIMIZED (hanya 2 kali)
            ensureSidebarVisible();
            setTimeout(ensureSidebarVisible, 100);
            
            // Pastikan sidebar terlihat saat window resize
            window.addEventListener('resize', function() {
                ensureSidebarVisible();
            });
            
            // Observer untuk memastikan sidebar tetap terlihat - OPTIMIZED (debounced)
            if (window.innerWidth >= 768) {
                let sidebarResizeTimeout;
                const debouncedEnsureSidebar = () => {
                    clearTimeout(sidebarResizeTimeout);
                    sidebarResizeTimeout = setTimeout(ensureSidebarVisible, 100);
                };
                
                const sidebarObserver = new MutationObserver(debouncedEnsureSidebar);
                
                const sidebar = document.getElementById('guru-sidebar');
                if (sidebar) {
                    sidebarObserver.observe(sidebar, {
                        attributes: true,
                        attributeFilter: ['style', 'class']
                    });
                }
            }
            
            // PASTIKAN CARD PRESENSI BISA DIKLIK - ULTRA AGGRESSIVE FIX
            function ensureCardsClickable() {
                const cardIds = ['card-hadir', 'card-sakit', 'card-izin'];
                cardIds.forEach(cardId => {
                    const card = document.getElementById(cardId);
                    if (card) {
                        // Pastikan card bisa diklik - ULTRA AGGRESSIVE
                        card.style.setProperty('pointer-events', 'auto', 'important');
                        card.style.setProperty('cursor', 'pointer', 'important');
                        card.style.setProperty('z-index', '999', 'important');
                        card.style.setProperty('position', 'relative', 'important');
                        card.style.setProperty('user-select', 'none', 'important');
                        card.style.setProperty('-webkit-user-select', 'none', 'important');
                        card.style.setProperty('-moz-user-select', 'none', 'important');
                        card.style.setProperty('-ms-user-select', 'none', 'important');
                        
                        // Pastikan onclick attribute ada - SEDERHANA DAN LANGSUNG
                        const type = cardId.replace('card-', '');
                        card.setAttribute('onclick', 'window.selectPresensiType("' + type + '"); return false;');
                        
                        // Tambahkan event listener sebagai backup - SEDERHANA DAN LANGSUNG
                        const clickHandler = function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            e.stopImmediatePropagation();
                            console.log('Card clicked via listener:', type);
                            
                            // Panggil fungsi langsung
                            if (window.selectPresensiType && typeof window.selectPresensiType === 'function') {
                                window.selectPresensiType(type);
                            } else {
                                console.error('window.selectPresensiType is not a function!', typeof window.selectPresensiType);
                                alert('Error: selectPresensiType function not found. Please refresh the page.');
                            }
                            return false;
                        };
                        
                        // Hapus semua listener lama dengan clone
                        const newCard = card.cloneNode(true);
                        card.parentNode.replaceChild(newCard, card);
                        
                        // Tambahkan listener baru ke card yang baru
                        newCard.addEventListener('click', clickHandler, true);
                        newCard.addEventListener('click', clickHandler, false);
                        newCard.addEventListener('mousedown', clickHandler, true);
                        newCard.addEventListener('touchstart', function(e) {
                            e.preventDefault();
                            clickHandler(e);
                        }, true);
                        
                        // Pastikan onclick juga bekerja
                        newCard.onclick = function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            if (window.selectPresensiType && typeof window.selectPresensiType === 'function') {
                                window.selectPresensiType(type);
                            }
                            return false;
                        };
                        
                        // Update onclick attribute juga
                        newCard.setAttribute('onclick', 'window.selectPresensiType("' + type + '"); return false;');
                    }
                });
            }
            
            // Panggil fungsi untuk memastikan card bisa diklik - MULTIPLE TIMES untuk memastikan
            ensureCardsClickable();
            setTimeout(ensureCardsClickable, 50);
            setTimeout(ensureCardsClickable, 100);
            setTimeout(ensureCardsClickable, 200);
            setTimeout(ensureCardsClickable, 500);
            setTimeout(ensureCardsClickable, 1000);
            
            // Pastikan fungsi selectPresensiType bisa diakses sebelum memanggil initializePresensiForm
            console.log('=== CHECKING selectPresensiType ===');
            console.log('window.selectPresensiType type:', typeof window.selectPresensiType);
            console.log('window.selectPresensiType value:', window.selectPresensiType);
            if (typeof window.selectPresensiType !== 'function') {
                console.error('CRITICAL: window.selectPresensiType is not a function!', typeof window.selectPresensiType);
                alert('Error: selectPresensiType function is not available. Please refresh the page.');
            } else {
                console.log('✓ window.selectPresensiType is accessible and is a function');
                // Test call
                try {
                    console.log('Testing selectPresensiType with "hadir"...');
                    // window.selectPresensiType('hadir'); // Jangan panggil otomatis, hanya test
                } catch (e) {
                    console.error('Error testing selectPresensiType:', e);
                }
            }
            
            // Initialize semua fungsi lainnya
            initializePresensiForm();
            handleSuratSakitPreview();
            
            // PASTIKAN section riwayat dan status tersembunyi saat pertama kali load - ULTRA AGGRESSIVE
            const riwayatSection = document.getElementById('riwayat-presensi-section');
            const statusSection = document.getElementById('status-presensi-hari-ini');
            
            function forceHideSections() {
                if (riwayatSection) {
                    riwayatSection.style.setProperty('display', 'none', 'important');
                    riwayatSection.style.setProperty('visibility', 'hidden', 'important');
                    riwayatSection.style.setProperty('opacity', '0', 'important');
                    riwayatSection.style.setProperty('position', 'absolute', 'important');
                    riwayatSection.style.setProperty('left', '-9999px', 'important');
                    riwayatSection.style.setProperty('height', '0', 'important');
                    riwayatSection.style.setProperty('overflow', 'hidden', 'important');
                    riwayatSection.style.setProperty('margin', '0', 'important');
                    riwayatSection.style.setProperty('padding', '0', 'important');
                    riwayatSection.removeAttribute('data-show');
                    riwayatSection.classList.remove('show');
                }
                
                if (statusSection) {
                    statusSection.style.setProperty('display', 'none', 'important');
                    statusSection.style.setProperty('visibility', 'hidden', 'important');
                    statusSection.style.setProperty('opacity', '0', 'important');
                    statusSection.style.setProperty('position', 'absolute', 'important');
                    statusSection.style.setProperty('left', '-9999px', 'important');
                    statusSection.style.setProperty('height', '0', 'important');
                    statusSection.style.setProperty('overflow', 'hidden', 'important');
                    statusSection.style.setProperty('margin', '0', 'important');
                    statusSection.style.setProperty('padding', '0', 'important');
                    statusSection.removeAttribute('data-show');
                    statusSection.classList.remove('show');
                }
            }
            
            // Paksa sembunyikan section saat page load
            forceHideSections();
            
            // Paksa sembunyikan lagi setelah delay untuk memastikan - OPTIMIZED (langsung)
            forceHideSections();
            
            // Initialize riwayat presensi (akan menampilkan jika ada session success)
            initializeRiwayatPresensi();
        });
        
        // FUNGSI selectPresensiType SUDAH DIDEFINISIKAN DI ATAS (sebelum DOMContentLoaded)
        // Tidak perlu didefinisikan lagi di sini
            console.log('selectPresensiType called with:', type);
            if (!type) {
                console.error('selectPresensiType: type is required');
                return;
            }
            
            // Pastikan card bisa diklik sebelum memproses
            const cardIds = ['card-hadir', 'card-sakit', 'card-izin'];
            cardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.setProperty('pointer-events', 'auto', 'important');
                    card.style.setProperty('cursor', 'pointer', 'important');
                }
            });
            
            // Remove active class from all cards dan pastikan ukuran tetap sama - ULTRA AGGRESSIVE FIXED HEIGHT
            const allCards = ['card-hadir', 'card-sakit', 'card-izin'];
            allCards.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.classList.remove('active');
                    // Pastikan ukuran tetap sama untuk semua card - FORCE FIXED HEIGHT
                    card.style.setProperty('width', '100%', 'important');
                    card.style.setProperty('height', '100px', 'important');
                    card.style.setProperty('min-height', '100px', 'important');
                    card.style.setProperty('max-height', '100px', 'important');
                    card.style.setProperty('box-sizing', 'border-box', 'important');
                    card.style.setProperty('transform', 'none', 'important');
                    card.style.setProperty('scale', '1', 'important');
                    card.style.setProperty('margin', '0', 'important');
                    card.style.setProperty('padding', '0', 'important');
                    card.style.setProperty('flex', '0 0 auto', 'important');
                    card.style.setProperty('display', 'flex', 'important');
                    card.style.setProperty('align-items', 'center', 'important');
                    card.style.setProperty('justify-content', 'center', 'important');
                    // Force computed style
                    card.style.height = '100px';
                    card.style.minHeight = '100px';
                    card.style.maxHeight = '100px';
                }
            });
            
            // Uncheck all radios
            document.querySelectorAll('input[name="jenis"]').forEach(radio => {
                radio.checked = false;
            });
            
            // Activate selected card and radio - pastikan ukuran tetap sama - FORCE FIXED HEIGHT
            const selectedCard = document.getElementById('card-' + type);
            if (selectedCard) {
                selectedCard.classList.add('active');
                const radio = document.getElementById('jenis-' + type);
                if (radio) {
                    radio.checked = true;
                }
                
                // Pastikan ukuran card yang dipilih tetap sama - FORCE FIXED HEIGHT
                selectedCard.style.setProperty('width', '100%', 'important');
                selectedCard.style.setProperty('height', '100px', 'important');
                selectedCard.style.setProperty('min-height', '100px', 'important');
                selectedCard.style.setProperty('max-height', '100px', 'important');
                selectedCard.style.setProperty('box-sizing', 'border-box', 'important');
                selectedCard.style.setProperty('transform', 'none', 'important');
                selectedCard.style.setProperty('scale', '1', 'important');
                selectedCard.style.setProperty('margin', '0', 'important');
                selectedCard.style.setProperty('padding', '0', 'important');
                selectedCard.style.setProperty('flex', '0 0 auto', 'important');
                selectedCard.style.setProperty('display', 'flex', 'important');
                selectedCard.style.setProperty('align-items', 'center', 'important');
                selectedCard.style.setProperty('justify-content', 'center', 'important');
                // Force computed style
                selectedCard.style.height = '100px';
                selectedCard.style.minHeight = '100px';
                selectedCard.style.maxHeight = '100px';
            }
            
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
            
            // LOGIKA UTAMA: Tampilkan/sembunyikan section berdasarkan jenis presensi
            // HAPUS logika sidebar di sini karena akan di-handle di masing-masing kondisi type
            if (type === 'hadir') {
                // HADIR: Tampilkan jam masuk dan TUGAS SECTION (seperti foto 1)
                if (jamSection) {
                    jamSection.style.display = 'block';
                }
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'none', 'important');
                    keteranganSection.style.setProperty('visibility', 'hidden', 'important');
                    keteranganSection.style.setProperty('opacity', '0', 'important');
                }
                if (jamMasuk) {
                    jamMasuk.required = true;
                }
                if (keterangan) {
                    keterangan.required = false;
                }
                // Auto-fill jam masuk saat pilih hadir
                if (jamMasuk && !jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
                // SEMBUNYIKAN tugas section untuk HADIR (tidak perlu tugas pengganti)
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'none', 'important');
                    tugasSection.style.setProperty('visibility', 'hidden', 'important');
                    tugasSection.style.setProperty('opacity', '0', 'important');
                    tugasSection.classList.remove('highlight-sakit');
                    tugasSection.classList.remove('highlight-izin');
                }
                // SEMBUNYIKAN sidebar untuk HADIR (tidak perlu informasi tambahan)
                if (presensiSidebar) {
                    presensiSidebar.style.setProperty('display', 'none', 'important');
                    presensiSidebar.style.setProperty('visibility', 'hidden', 'important');
                    presensiSidebar.style.setProperty('opacity', '0', 'important');
                }
                // SEMBUNYIKAN surat sakit section untuk HADIR
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'none', 'important');
                    suratSakitSection.style.setProperty('visibility', 'hidden', 'important');
                    suratSakitSection.style.setProperty('opacity', '0', 'important');
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) {
                        suratSakitInput.value = '';
                    }
                    clearSuratSakit();
                }
                // Gunakan layout 1 kolom penuh untuk HADIR (karena tidak ada sidebar)
                if (formMainSection) {
                    formMainSection.classList.remove('col-lg-7');
                    formMainSection.classList.add('col-lg-12');
                    formMainSection.style.setProperty('width', '100%', 'important');
                    formMainSection.style.setProperty('flex', '0 0 100%', 'important');
                }
            } else if (type === 'izin') {
                // IZIN: Tampilkan keterangan, tugas, dan sidebar
                if (jamSection) {
                    jamSection.style.display = 'none';
                }
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'block', 'important');
                    keteranganSection.style.setProperty('visibility', 'visible', 'important');
                    keteranganSection.style.setProperty('opacity', '1', 'important');
                }
                if (jamMasuk) {
                    jamMasuk.required = false;
                }
                if (keterangan) {
                    keterangan.required = true;
                }
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
                // TAMPILKAN section tugas untuk izin - FORCE
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'block', 'important');
                    tugasSection.style.setProperty('visibility', 'visible', 'important');
                    tugasSection.style.setProperty('opacity', '1', 'important');
                    tugasSection.classList.add('highlight-izin');
                    tugasSection.classList.remove('highlight-sakit');
                    // Scroll ke section tugas untuk memastikan user melihatnya
                    setTimeout(() => {
                        tugasSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 100);
                }
                // Surat sakit tidak diperlukan untuk izin
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'none', 'important');
                    suratSakitSection.style.setProperty('visibility', 'hidden', 'important');
                    suratSakitSection.style.setProperty('opacity', '0', 'important');
                    const suratSakitInput = document.getElementById('surat_sakit');
                    if (suratSakitInput) {
                        suratSakitInput.value = '';
                    }
                    clearSuratSakit();
                }
            } else { // sakit
                // SAKIT: Tampilkan jam masuk, tugas, surat sakit, dan sidebar (TIDAK tampilkan keterangan)
                if (jamSection) {
                    jamSection.style.display = 'block';
                }
                if (keteranganSection) {
                    keteranganSection.style.setProperty('display', 'none', 'important');
                    keteranganSection.style.setProperty('visibility', 'hidden', 'important');
                    keteranganSection.style.setProperty('opacity', '0', 'important');
                }
                if (jamMasuk) {
                    jamMasuk.required = true;
                }
                if (keterangan) {
                    keterangan.required = false;
                }
                // Auto-fill jam masuk saat pilih sakit agar TU tahu kapan mulai sakit
                if (jamMasuk && !jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
                // Update info text
                if (document.getElementById('jamMasukInfo')) {
                    document.getElementById('jamMasukInfo').style.display = 'none';
                }
                if (document.getElementById('jamMasukSakitInfo')) {
                    document.getElementById('jamMasukSakitInfo').style.display = 'inline';
                }
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
                // TAMPILKAN section tugas untuk sakit - FORCE
                if (tugasSection) {
                    tugasSection.style.setProperty('display', 'block', 'important');
                    tugasSection.style.setProperty('visibility', 'visible', 'important');
                    tugasSection.style.setProperty('opacity', '1', 'important');
                    tugasSection.classList.add('highlight-sakit');
                    tugasSection.classList.remove('highlight-izin');
                    // Scroll ke section tugas untuk memastikan user melihatnya
                    setTimeout(() => {
                        tugasSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 100);
                }
                // Tampilkan surat sakit section untuk sakit
                if (suratSakitSection) {
                    suratSakitSection.style.setProperty('display', 'block', 'important');
                    suratSakitSection.style.setProperty('visibility', 'visible', 'important');
                    suratSakitSection.style.setProperty('opacity', '1', 'important');
                }
            }
            
            // Reset info text for hadir
            if (type === 'hadir') {
                if (document.getElementById('jamMasukInfo')) {
                    document.getElementById('jamMasukInfo').style.display = 'inline';
                }
                if (document.getElementById('jamMasukSakitInfo')) {
                    document.getElementById('jamMasukSakitInfo').style.display = 'none';
                }
            } else if (type === 'izin') {
                if (document.getElementById('jamMasukInfo')) {
                    document.getElementById('jamMasukInfo').style.display = 'none';
                }
                if (document.getElementById('jamMasukSakitInfo')) {
                    document.getElementById('jamMasukSakitInfo').style.display = 'none';
                }
            }
            
            // Pastikan ukuran card tetap konsisten setelah perubahan - OPTIMIZED (langsung, tanpa setTimeout)
            if (typeof ensureConsistentCardSize === 'function') {
                ensureConsistentCardSize();
            }
            
            // Pastikan semua card tetap bisa diklik setelah perubahan
            const allCardIds = ['card-hadir', 'card-sakit', 'card-izin'];
            allCardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.setProperty('pointer-events', 'auto', 'important');
                    card.style.setProperty('cursor', 'pointer', 'important');
                    card.style.setProperty('z-index', '999', 'important');
                    card.style.setProperty('position', 'relative', 'important');
                }
            });
        }
        
        // FUNGSI selectPresensiType SUDAH DI-ASSIGN KE WINDOW DI ATAS (sebelum DOMContentLoaded)
        // Tidak perlu duplikasi di sini
        
        // Existing presensi functions
        const defaultPresensiType = @json(old('jenis', 'hadir'));
        const formHasErrors = @json($errors->any());
        
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

        // FUNGSI setCurrentTime SUDAH DIDEFINISIKAN DI ATAS (sebelum DOMContentLoaded)
        // Tidak perlu didefinisikan lagi di sini

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
                // Reset semua textarea tugas
                document.querySelectorAll('.tugas-textarea').forEach(textarea => textarea.value = '');
                
                // Reset semua input detail halaman dan bab
                document.querySelectorAll('[id^="detail_halaman_"]').forEach(input => input.value = '');
                document.querySelectorAll('[id^="detail_bab_"]').forEach(input => input.value = '');
                
                // Sembunyikan semua wrapper tugas kelas
                document.querySelectorAll('.tugas-kelas-wrapper').forEach(wrapper => {
                    wrapper.style.display = 'none';
                });
                
                // Sembunyikan container dan reset dropdown
                const container = document.getElementById('tugas-kelas-container');
                if (container) {
                    container.style.display = 'none';
                }
                const dropdown = document.getElementById('pilih-kelas-tugas');
                if (dropdown) {
                    dropdown.value = '';
                }
                
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
        
        // Make function globally accessible
        window.togglePresensiForm = togglePresensiForm;

        // Initialize - set hadir as default active and auto-fill jam masuk (OPTIMIZED: gabung dengan DOMContentLoaded utama)
        // Pindahkan ke DOMContentLoaded utama di atas untuk performa
        function initializePresensiForm() {
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
            
            // Pastikan ukuran card konsisten setelah memilih jenis presensi - OPTIMIZED (hanya 1x check)
            setTimeout(() => {
                ensureConsistentCardSize();
                document.querySelectorAll('#card-hadir, #card-sakit, #card-izin').forEach(card => {
                    card.style.setProperty('height', '100px', 'important');
                    card.style.setProperty('min-height', '100px', 'important');
                    card.style.setProperty('max-height', '100px', 'important');
                });
            }, 100);
            
            // Optimized: Monitor perubahan dengan debounce untuk performa lebih baik
            let resizeTimeout;
            const forceAllCardsSize = () => {
                ensureConsistentCardSize();
                const cardIds = ['card-hadir', 'card-sakit', 'card-izin'];
                cardIds.forEach(cardId => {
                    const card = document.getElementById(cardId);
                    if (card) {
                        card.style.setProperty('height', '100px', 'important');
                        card.style.setProperty('min-height', '100px', 'important');
                        card.style.setProperty('max-height', '100px', 'important');
                        card.style.height = '100px';
                        card.style.minHeight = '100px';
                        card.style.maxHeight = '100px';
                    }
                });
            };
            
            // Debounced observer untuk mengurangi overhead
            const debouncedForceSize = () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(forceAllCardsSize, 50);
            };
            
            const observer = new MutationObserver(debouncedForceSize);
            
            // MutationObserver untuk jenis-presensi-row - DISABLED untuk performa
            // Layout sudah di-set via CSS, tidak perlu monitor terus-menerus
            /*
            const jenisPresensiRow = document.getElementById('jenis-presensi-row');
            if (jenisPresensiRow) {
                observer.observe(jenisPresensiRow, {
                    childList: false, // Hanya monitor attributes, bukan childList
                    subtree: false, // Tidak perlu subtree untuk performa
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
            }
            */
            
            // Monitor setiap card secara individual - OPTIMIZED (hanya 1 observer per card) - DISABLED untuk performa
            // MutationObserver untuk card size di-disable untuk meningkatkan performa
            // Ukuran card sudah di-set via CSS dan inline style, tidak perlu monitor terus-menerus
            /*
            const cardIds = ['card-hadir', 'card-sakit', 'card-izin'];
            cardIds.forEach(cardId => {
                const card = document.getElementById(cardId);
                if (card) {
                    const cardObserver = new MutationObserver(function(mutations) {
                        // Debounce untuk mengurangi overhead
                        clearTimeout(resizeTimeout);
                        resizeTimeout = setTimeout(() => {
                            card.style.setProperty('height', '100px', 'important');
                            card.style.setProperty('min-height', '100px', 'important');
                            card.style.setProperty('max-height', '100px', 'important');
                            card.style.height = '100px';
                            card.style.minHeight = '100px';
                            card.style.maxHeight = '100px';
                        }, 50);
                    });
                    cardObserver.observe(card, {
                        attributes: true,
                        attributeFilter: ['style', 'class']
                    });
                }
            });
            */

            if (defaultType === 'hadir' && formCard && (formCard.style.display === 'block' || hasErrors)) {
                const jamMasuk = document.getElementById('jam_masuk');
                if (jamMasuk && !jamMasuk.value) {
                    setCurrentTime('jam_masuk');
                }
            }
        }
        
        // initializePresensiForm sudah dipanggil di DOMContentLoaded utama di atas
        
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
        
        // Initialize surat sakit preview handler (OPTIMIZED: sudah dipanggil di DOMContentLoaded utama)

        // Auto-refresh status - DISABLED untuk performa (user bisa refresh manual jika perlu)
        // setInterval disabled untuk meningkatkan performa loading
        // Jika perlu auto-refresh, user bisa refresh manual atau gunakan browser refresh
        /*
        @if($todayPresensi && $todayPresensi->status_verifikasi === 'pending')
        setInterval(function() {
            // Check if status has changed - hanya jika tab masih aktif
            if (document.hidden) return; // Skip jika tab tidak aktif
            
            fetch('{{ route("guru.presensi.index") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                cache: 'no-cache' // Pastikan tidak cache
            })
            .then(response => response.text())
            .then(html => {
                // Only reload if still on presensi page
                if (window.location.pathname.includes('/presensi')) {
                    location.reload();
                }
            })
            .catch(err => console.log('Auto-refresh error:', err));
        }, 30000); // Check every 30 seconds (diperlambat untuk performa)
        @endif
        */

        // Tampilkan section Riwayat Presensi dan Status Presensi Hari Ini setelah form submit berhasil
        function initializeRiwayatPresensi() {
            // Fungsi untuk menampilkan status presensi hari ini dan riwayat - ULTRA AGGRESSIVE
            function showPresensiSections() {
                // Tampilkan Status Presensi Hari Ini
                const statusSection = document.getElementById('status-presensi-hari-ini');
                if (statusSection) {
                    statusSection.style.setProperty('display', 'block', 'important');
                    statusSection.style.setProperty('visibility', 'visible', 'important');
                    statusSection.style.setProperty('opacity', '1', 'important');
                    statusSection.style.setProperty('position', 'relative', 'important');
                    statusSection.style.setProperty('left', 'auto', 'important');
                    statusSection.style.setProperty('height', 'auto', 'important');
                    statusSection.style.setProperty('overflow', 'visible', 'important');
                    statusSection.style.setProperty('margin', '1rem 0', 'important');
                    statusSection.style.setProperty('padding', 'inherit', 'important');
                    statusSection.setAttribute('data-show', 'true');
                    statusSection.classList.add('show');
                }
                
                // Tampilkan Riwayat Presensi
                const riwayatSection = document.getElementById('riwayat-presensi-section');
                if (riwayatSection) {
                    riwayatSection.style.setProperty('display', 'block', 'important');
                    riwayatSection.style.setProperty('visibility', 'visible', 'important');
                    riwayatSection.style.setProperty('opacity', '1', 'important');
                    riwayatSection.style.setProperty('position', 'relative', 'important');
                    riwayatSection.style.setProperty('left', 'auto', 'important');
                    riwayatSection.style.setProperty('height', 'auto', 'important');
                    riwayatSection.style.setProperty('overflow', 'visible', 'important');
                    riwayatSection.style.setProperty('margin', '1rem 0', 'important');
                    riwayatSection.style.setProperty('padding', 'inherit', 'important');
                    riwayatSection.setAttribute('data-show', 'true');
                    riwayatSection.classList.add('show');
                    
                    // Scroll ke section status dengan smooth - OPTIMIZED (langsung)
                    requestAnimationFrame(() => {
                        if (statusSection) {
                            statusSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                }
            }
            
            // Pastikan section tersembunyi saat page load - ULTRA AGGRESSIVE
            function hidePresensiSections() {
                const statusSection = document.getElementById('status-presensi-hari-ini');
                const riwayatSection = document.getElementById('riwayat-presensi-section');
                
                if (statusSection) {
                    statusSection.style.setProperty('display', 'none', 'important');
                    statusSection.style.setProperty('visibility', 'hidden', 'important');
                    statusSection.style.setProperty('opacity', '0', 'important');
                    statusSection.style.setProperty('position', 'absolute', 'important');
                    statusSection.style.setProperty('left', '-9999px', 'important');
                    statusSection.style.setProperty('height', '0', 'important');
                    statusSection.style.setProperty('overflow', 'hidden', 'important');
                    statusSection.removeAttribute('data-show');
                    statusSection.classList.remove('show');
                }
                
                if (riwayatSection) {
                    riwayatSection.style.setProperty('display', 'none', 'important');
                    riwayatSection.style.setProperty('visibility', 'hidden', 'important');
                    riwayatSection.style.setProperty('opacity', '0', 'important');
                    riwayatSection.style.setProperty('position', 'absolute', 'important');
                    riwayatSection.style.setProperty('left', '-9999px', 'important');
                    riwayatSection.style.setProperty('height', '0', 'important');
                    riwayatSection.style.setProperty('overflow', 'hidden', 'important');
                    riwayatSection.removeAttribute('data-show');
                    riwayatSection.classList.remove('show');
                }
            }
            
            // Pastikan section tersembunyi saat pertama kali load (kecuali ada session success)
            hidePresensiSections();
            
            // Cek apakah ada session success message (presensi berhasil dikirim)
            // Hanya tampilkan jika benar-benar ada session success DAN form baru saja di-submit
            @if(session('success'))
                // Tunggu sebentar untuk memastikan DOM sudah siap - OPTIMIZED (lebih cepat)
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        showPresensiSections();
                    }, 50);
                });
            @else
                // Jika tidak ada session success, PASTIKAN section tersembunyi - langsung
                hidePresensiSections();
            @endif

            // Handle form submit - tampilkan section setelah submit
            const presensiForm = document.getElementById('presensiForm');
            const btnKirimPresensi = document.getElementById('btnKirimPresensi');
            
            if (presensiForm && btnKirimPresensi) {
                btnKirimPresensi.addEventListener('click', function(e) {
                    // Simpan status submit ke sessionStorage
                    sessionStorage.setItem('presensiSubmitted', 'true');
                });
                
                presensiForm.addEventListener('submit', function(e) {
                    // Simpan status submit ke sessionStorage
                    sessionStorage.setItem('presensiSubmitted', 'true');
                });
            }

            // Cek sessionStorage untuk menampilkan section jika sudah submit sebelumnya
            // Tapi hanya jika benar-benar ada session success atau flag submit
            const hasPresensiSubmitted = sessionStorage.getItem('presensiSubmitted') === 'true';
            const hasSessionSuccess = @json(session('success') ? true : false);
            
            // PASTIKAN: Hanya tampilkan jika benar-benar ada session success (form baru di-submit)
            // JANGAN tampilkan hanya karena ada $todayPresensi (presensi lama)
            if (hasSessionSuccess && hasPresensiSubmitted) {
                // OPTIMIZED: langsung tampilkan tanpa delay yang lama
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        showPresensiSections();
                    }, 50);
                });
                
                // Hapus flag setelah ditampilkan
                sessionStorage.removeItem('presensiSubmitted');
            } else {
                // Jika tidak ada session success atau flag submit, PASTIKAN section tersembunyi - langsung
                hidePresensiSections();
            }
            
            // PASTIKAN section tersembunyi sekali lagi setelah semua check
            setTimeout(function() {
                if (!hasSessionSuccess) {
                    hidePresensiSections();
                }
            }, 300);
        }
        
        // initializeRiwayatPresensi sudah dipanggil di DOMContentLoaded utama di atas
    </script>
</body>
</html>



