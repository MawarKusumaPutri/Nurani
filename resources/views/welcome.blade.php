<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MTs Nurul Aiman - TMS NURANI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #F1F8E9 0%, #E8F5E8 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(70, 146, 60, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(70, 146, 60, 0.08) 0%, transparent 50%);
            animation: backgroundShift 20s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes backgroundShift {
            0%, 100% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(-10px) translateY(-10px); }
            50% { transform: translateX(10px) translateY(-5px); }
            75% { transform: translateX(-5px) translateY(10px); }
        }

        /* Header */
        .header {
            background: #46923c;
            color: white;
            padding: 15px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
        }

        .header-logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-logo-circle {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #87CEEB, #4682B4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #87CEEB;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .header-text h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .header-text p {
            font-size: 14px;
            margin: 0;
            opacity: 0.9;
            color: #e0e0e0;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-menu a:hover {
            color: #e8f5e8;
        }

        .login-dropdown {
            position: relative;
        }

        .login-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: #46923c;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 10px 0;
            min-width: 200px;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .dropdown-menu a:hover {
            background: rgba(255,255,255,0.1);
        }

        /* Login Sidebar */
        .login-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: none;
        }

        .login-sidebar.show {
            display: block;
        }

        .sidebar-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease-out;
        }

        .sidebar-content {
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            height: 100%;
            background: linear-gradient(135deg, #46923c 0%, #2d5a2d 100%);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.3);
            animation: slideInRight 0.4s ease-out;
            display: flex;
            flex-direction: column;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .sidebar-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-close-btn:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar-logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }

        .sidebar-logo-circle {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #87CEEB, #4682B4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #87CEEB;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
        }

        .sidebar-school-info h3 {
            color: white;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }

        .sidebar-school-info p {
            color: #ffd700;
            font-size: 14px;
            font-weight: 600;
            margin: 2px 0;
            letter-spacing: 0.5px;
        }

        .sidebar-school-info small {
            color: rgba(255, 255, 255, 0.8);
            font-size: 11px;
            font-weight: 500;
        }

        .sidebar-body {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .login-form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-form-header h2 {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .login-form-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin: 0;
        }

        .sidebar-body .form-group {
            margin-bottom: 20px;
        }

        .sidebar-body .form-label {
            color: white;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .sidebar-body .form-control {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            transition: background 0.3s ease;
        }

        .sidebar-body .form-control:focus {
            outline: none;
            background: white;
        }

        .sidebar-body .btn-login {
            width: 100%;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .sidebar-body .btn-login:hover {
            background: white;
            color: #46923c;
        }

        .sidebar-body .forgot-password {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            text-align: center;
            display: block;
            transition: color 0.3s ease;
        }

        .sidebar-body .forgot-password:hover {
            color: white;
        }

        .password-toggle-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .password-toggle-btn:hover {
            color: #46923c;
        }

        /* Hero Section */
        .hero-section {
            margin-top: 80px;
            height: calc(100vh - 80px);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/image/foto_MTS/20251002_105433-fotor-20251022182659.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 1;
            animation: backgroundSlide 20s ease-in-out infinite;
            transform: scale(1.1);
            transition: transform 0.3s ease;
            opacity: 0;
            animation: backgroundSlide 20s ease-in-out infinite, fadeIn 2s ease-in-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .hero-section:hover .hero-background {
            transform: scale(1.05);
        }

        @keyframes backgroundSlide {
            0%, 50% {
                background-image: url('/image/foto_MTS/20251002_105433-fotor-20251022182659.png');
            }
            25%, 75% {
                background-image: url('/image/foto_MTS/20251002_111603-fotor-20251022164553.png');
            }
        }

        .hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            text-align: left;
            color: white;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            animation: fadeInUp 1s ease-out 0.5s both;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .hero-text-container {
            flex: 0 0 40%;
            max-width: 450px;
            padding: 30px;
            padding-right: 30px;
            animation: fadeInUp 1s ease-out 0.5s both;
            position: relative;
            z-index: 4;
        }

        .hero-image-container {
            flex: 0 0 60%;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeInUp 1s ease-out 1s both;
            position: relative;
            z-index: 3;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-badges {
            display: flex;
            justify-content: flex-start;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 3.5s both;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 12px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease-out calc(3.5s + var(--delay, 0s)) both;
            border: 2px solid rgba(255, 255, 255, 0.5);
            flex: 1;
            min-width: 0;
        }

        .hero-badge:nth-child(1) { --delay: 0s; }
        .hero-badge:nth-child(2) { --delay: 0.2s; }
        .hero-badge:nth-child(3) { --delay: 0.4s; }

        .hero-badge:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.95);
        }

        .hero-badge:hover i {
            color: #2d5a2d;
            transform: scale(1.1);
        }

        .hero-badge:hover span {
            color: #2d5a2d;
        }

        .hero-badge i {
            font-size: 18px;
            color: #46923c;
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
        }

        .hero-badge span {
            font-weight: 600;
            color: #46923c;
            font-size: 11px;
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .hero-subtitle {
            font-size: 24px;
            font-weight: 300;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9), 0 0 8px rgba(0, 0, 0, 0.7);
            letter-spacing: 1px;
            animation: fadeInUp 1s ease-out 1.5s both;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.9), 0 0 12px rgba(0, 0, 0, 0.8);
            color: #ffffff;
            line-height: 1.1;
            animation: fadeInUp 1s ease-out 2s both;
        }

        .hero-tagline {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9), 0 0 8px rgba(0, 0, 0, 0.7);
            color: #ffd700;
            animation: fadeInUp 1s ease-out 2.5s both;
        }

        .hero-description {
            font-size: 16px;
            font-weight: 400;
            opacity: 0.95;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9), 0 0 6px rgba(0, 0, 0, 0.8);
            max-width: 400px;
            margin: 0;
            animation: fadeInUp 1s ease-out 3s both;
        }

        .hero-description::after {
            content: '';
            display: block;
            width: 100px;
            height: 3px;
            background: #ffd700;
            margin: 20px 0;
            animation: fadeInUp 1s ease-out 3.5s both;
        }




        /* Footer */
        .footer {
            background: #46923c !important;
            color: white;
            padding: 30px 0;
        }
        
        /* Force all green elements to use #46923c */
        .bg-green-600, .bg-green-500, .bg-green-700, .bg-green-800, .bg-green-400, .bg-green-300 {
            background-color: #46923c !important;
        }
        
        .text-green-600, .text-green-500, .text-green-700, .text-green-800, .text-green-400, .text-green-300 {
            color: #46923c !important;
        }
        
        .border-green-600, .border-green-500, .border-green-700, .border-green-800, .border-green-400, .border-green-300 {
            border-color: #46923c !important;
        }
        
        /* Override any element with green background */
        [style*="background"] {
            background: #46923c !important;
        }
        
        /* Force footer specifically */
        footer, .footer, [class*="footer"] {
            background: #46923c !important;
        }
        

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }
        

        .contact-info {
            margin-bottom: 20px;
        }

        .contact-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .copyright {
            font-size: 12px;
            opacity: 0.8;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .nav-menu {
                gap: 20px;
            }

            .hero-section {
                height: calc(100vh - 80px);
            }

            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text-container {
                flex: 1;
                max-width: 100%;
                padding-right: 0;
                margin-bottom: 30px;
                background: rgba(0, 0, 0, 0.5);
                padding: 30px 20px;
                margin: 10px;
            }

            .hero-image-container {
                display: none;
            }

            .hero-badges {
                justify-content: center;
                gap: 10px;
                margin-top: 20px;
            }

            .hero-badge {
                padding: 8px 12px;
                font-size: 10px;
                flex: 1;
                min-width: 0;
            }

            .hero-badge i {
                font-size: 16px;
            }

            .hero-badge span {
                font-size: 10px;
            }

            .hero-subtitle {
                font-size: 18px;
                margin-bottom: 15px;
            }

            .hero-title {
                font-size: 42px;
                margin-bottom: 15px;
            }

            .hero-tagline {
                font-size: 20px;
                margin-bottom: 10px;
            }

            .hero-description {
                font-size: 16px;
                max-width: 100%;
            }

            .sidebar-content {
                width: 100%;
                max-width: 350px;
            }

            .sidebar-body {
                padding: 20px;
            }

            .sidebar-logo-section {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .sidebar-school-info h3 {
                font-size: 16px;
            }

            .sidebar-school-info p {
                font-size: 12px;
            }

            .sidebar-school-info small {
                font-size: 10px;
            }
        }

        @media (max-width: 1024px) and (min-width: 769px) {
            .hero-text-container {
                flex: 0 0 45%;
                max-width: 400px;
                padding-right: 20px;
                padding: 25px;
                margin: 15px;
            }

            .hero-image-container {
                flex: 0 0 55%;
            }

            .hero-badges {
                margin-top: 25px;
                gap: 10px;
            }

            .hero-badge {
                padding: 8px 12px;
                font-size: 10px;
            }

            .hero-badge i {
                font-size: 16px;
            }

            .hero-badge span {
                font-size: 10px;
            }

            .hero-title {
                font-size: 40px;
            }

            .hero-tagline {
                font-size: 18px;
            }

            .sidebar-content {
                width: 380px;
            }

            .sidebar-body {
                padding: 25px;
            }
        }

        @media (max-width: 480px) {
            .hero-text-container {
                flex: 1;
                padding: 20px 15px;
                margin: 5px;
            }

            .hero-badges {
                flex-direction: row;
                align-items: center;
                margin-top: 15px;
                gap: 6px;
            }

            .hero-badge {
                flex: 1;
                min-width: 0;
                justify-content: center;
                padding: 5px 8px;
            }

            .hero-badge i {
                font-size: 12px;
            }

            .hero-badge span {
                font-size: 8px;
            }

            .hero-title {
                font-size: 28px;
            }

            .hero-tagline {
                font-size: 16px;
            }

            .sidebar-content {
                width: 100%;
                max-width: 320px;
            }

            .sidebar-body {
                padding: 15px;
            }

            .sidebar-logo-circle {
                width: 50px;
                height: 50px;
            }

            .sidebar-school-info h3 {
                font-size: 14px;
            }

            .sidebar-school-info p {
                font-size: 11px;
            }

            .sidebar-school-info small {
                font-size: 9px;
            }

            .login-form-header h2 {
                font-size: 20px;
            }

            .login-form-header p {
                font-size: 12px;
            }
        }
            </style>
    </head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="header-logo-container">
                    <div class="header-logo-circle">
                        <i class="fas fa-mosque" style="font-size: 30px; color: white;"></i>
                    </div>
                    <div class="header-text">
                        <h1>TMS NURANI</h1>
                        <p>MTs Nurul Aiman</p>
                    </div>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="#home">BERANDA</a>
                <a href="{{ route('tentang') }}">TENTANG</a>
                
                <div class="login-dropdown">
                    <a href="#" class="login-btn" onclick="toggleDropdown()">
                        LOGIN <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="#" onclick="openLoginModal('guru')">GURU</a>
                        <a href="#" onclick="openLoginModal('tu')">TENAGA USAHA</a>
                        <a href="#" onclick="openLoginModal('kepala_sekolah')">KEPALA SEKOLAH</a>
                    </div>
                </div>
                </nav>
        </div>
        </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-content">
            <div class="hero-text-container">
                <p class="hero-subtitle">Madrasah Tsanawiyah Unggulan</p>
                <h1 class="hero-title">MENCIPTAKAN MASA DEPAN</h1>
                <p class="hero-tagline">BERKONTRIBUSI UNTUK DUNIA</p>
                <p class="hero-description">Membangun Generasi Berkarakter dan Berprestasi</p>
                
                <div class="hero-badges">
                    <div class="hero-badge">
                        <i class="fas fa-graduation-cap"></i>
                        <span>MTs Nurul Aiman</span>
                    </div>
                    <div class="hero-badge">
                        <i class="fas fa-book-open"></i>
                        <span>PENDIDIKAN BERKUALITAS</span>
                    </div>
                    <div class="hero-badge">
                        <i class="fas fa-award"></i>
                        <span>UNGGUL</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-image-container">
                <!-- Space for background image to show through -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" style="background: #46923c !important;">
        <div class="footer-content">
            <div class="contact-info">
                <p><strong>Service Desk MTs Nurul Aiman</strong></p>
                <p>📞 0856-2452-5034 | 📱 Chat WA Only: 082263033855</p>
                <p>📧 internal.nurulaimam@gmail.com</p>
                <p>📷 Instagram: @mtssnuraiman | 🎵 TikTok: @mts.na.tjsari</p>
                <p>📍 Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363</p>
            </div>
            <div class="copyright">
                <p>TEACHING MANAGEMENT SYSTEM NURANI (TMS NURANI) © MTs NURUL AIMAN</p>
                <p>Integrated Learning Management System for Modern Education</p>
            </div>
        </div>
    </footer>

    <!-- Login Sidebar -->
    <div class="login-sidebar" id="loginSidebar">
        <div class="sidebar-backdrop" onclick="closeLoginSidebar()"></div>
        <div class="sidebar-content">
            <div class="sidebar-header">
                <button class="sidebar-close-btn" onclick="closeLoginSidebar()">
                    <i class="fas fa-times"></i>
                </button>
                <div class="sidebar-logo-section">
                    <div class="sidebar-logo-circle">
                        <i class="fas fa-mosque" style="font-size: 30px; color: white;"></i>
                    </div>
                    <div class="sidebar-school-info">
                        <h3>MTS NURUL AIMAN</h3>
                        <p>TANJUNGSARI</p>
                        <small>BERIMAN • BERKARAKTER • BERILMU</small>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-body">
                <div class="login-form-header">
                    <h2 id="sidebarTitle">LOGIN GURU</h2>
                    <p id="sidebarSubtitle">Single Account, Single Sign On login</p>
                </div>
                
                @if ($errors->any())
                    <div class="alert alert-danger" style="background: rgba(255,0,0,0.1); color: white; padding: 10px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,0,0,0.3);">
                        <ul class="mb-0" style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form id="loginForm" method="POST" action="{{ route('login.modal') }}">
                    @csrf
                    <input type="hidden" name="role" id="userRole" value="guru">
                    
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="email" class="form-control" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div style="position: relative;">
                            <input type="password" class="form-control" name="password" id="modalPassword" placeholder="Masukkan password" required autocomplete="current-password">
                            <button type="button" class="password-toggle-btn" onclick="toggleModalPassword()">
                                <i class="fas fa-eye" id="modalToggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-login">Login</button>
                </form>
                
                <a href="#" class="forgot-password">Forgot password?</a>
                <div style="text-align: center; margin-top: 15px;">
                    <small style="color: rgba(255,255,255,0.7);">Akun sudah tersedia, silakan login dengan kredensial yang diberikan</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('show');
        }

        function openLoginModal(role) {
            const sidebar = document.getElementById('loginSidebar');
            const sidebarTitle = document.getElementById('sidebarTitle');
            const sidebarSubtitle = document.getElementById('sidebarSubtitle');
            const userRole = document.getElementById('userRole');
            
            // Close dropdown
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.remove('show');
            
            // Set sidebar content based on role
            if (role === 'guru') {
                sidebarTitle.textContent = 'LOGIN GURU';
                sidebarSubtitle.textContent = 'Single Account, Single Sign On login';
                userRole.value = 'guru';
            } else if (role === 'tu') {
                sidebarTitle.textContent = 'LOGIN TENAGA USAHA';
                sidebarSubtitle.textContent = 'Single Account, Single Sign On login';
                userRole.value = 'tu';
            } else if (role === 'kepala_sekolah') {
                sidebarTitle.textContent = 'LOGIN KEPALA SEKOLAH';
                sidebarSubtitle.textContent = 'Single Account, Single Sign On login';
                userRole.value = 'kepala_sekolah';
            }
            
            // Show sidebar
            sidebar.classList.add('show');
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeLoginSidebar() {
            const sidebar = document.getElementById('loginSidebar');
            sidebar.classList.remove('show');
            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        function toggleModalPassword() {
            const passwordField = document.getElementById('modalPassword');
            const toggleIcon = document.getElementById('modalToggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }


        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const loginBtn = document.querySelector('.login-btn');
            
            if (!loginBtn.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Close sidebar with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLoginSidebar();
            }
        });

        // Handle form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const role = document.getElementById('userRole').value;
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            
            console.log('=== LOGIN DEBUG ===');
            console.log('Role:', role);
            console.log('Email:', email);
            console.log('Password length:', password.length);
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            
            // Update debug info
            document.getElementById('debugRole').textContent = role;
            document.getElementById('debugEmail').textContent = email;
            document.getElementById('debugInfo').style.display = 'block';
            
            // Show loading state
            const submitBtn = document.querySelector('.btn-login');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Logging in...';
            submitBtn.disabled = true;
            
            // Add a small delay to show loading state
            setTimeout(() => {
                console.log('Submitting form...');
                // Form will submit normally
            }, 100);
        });

        // Handle logout with JavaScript as fallback
        function handleLogout() {
            // Try to logout via JavaScript
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/';
                } else {
                    // Fallback: redirect to home
                    window.location.href = '/';
                }
            })
            .catch(error => {
                console.log('Logout error:', error);
                // Fallback: redirect to home
                window.location.href = '/';
            });
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Parallax effect for hero background
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const heroBackground = document.querySelector('.hero-background');
            if (heroBackground) {
                heroBackground.style.transform = `scale(${1.1 + scrolled * 0.0005})`;
            }
        });
    </script>
    </body>
</html>
</html>