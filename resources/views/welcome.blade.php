<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background: linear-gradient(135deg, #46923c 0%, #5BA84F 100%);
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
            background: linear-gradient(135deg, #46923c 0%, #5BA84F 100%);
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

        /* Login Overlay */
        .login-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .login-overlay.show {
            display: flex;
        }

        .login-modal {
            background: linear-gradient(135deg, #46923c 0%, #5BA84F 100%);
            border-radius: 20px;
            padding: 40px;
            width: 90%;
            max-width: 400px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-modal .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .login-modal .close-btn:hover {
            opacity: 1;
        }

        .login-modal h2 {
            color: white;
            text-align: center;
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: 700;
        }

        .login-modal .subtitle {
            color: rgba(255,255,255,0.8);
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .login-modal .form-group {
            margin-bottom: 20px;
        }

        .login-modal .form-label {
            color: white;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }

        .login-modal .form-control {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            background: rgba(255,255,255,0.9);
            transition: background 0.3s ease;
        }

        .login-modal .form-control:focus {
            outline: none;
            background: white;
        }

        .login-modal .btn-login {
            width: 100%;
            background: rgba(255,255,255,0.2);
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

        .login-modal .btn-login:hover {
            background: white;
            color: #46923c;
        }

        .login-modal .forgot-password {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            text-align: center;
            display: block;
        }

        .login-modal .forgot-password:hover {
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

        /* Modal Logo Styles */
        .modal-logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-logo {
            margin-bottom: 15px;
        }

        .logo-circle-mosque {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            position: relative;
            background: linear-gradient(135deg, #87CEEB, #4682B4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 3px solid #87CEEB;
        }

        .mosque-logo {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-school-name {
            font-size: 14px;
            font-weight: bold;
            color: white;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .modal-motto {
            font-size: 11px;
            color: #ffd700;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            min-height: calc(100vh - 160px);
            background: linear-gradient(135deg, rgba(241, 248, 233, 0.3) 0%, rgba(232, 245, 232, 0.3) 100%);
            display: flex;
            align-items: center;
            position: relative;
            padding: 60px 0;
        }

        .main-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 10% 20%, rgba(70, 146, 60, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(70, 146, 60, 0.03) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .content-overlay {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .content-left {
            flex: 1;
            color: #2d5a27;
        }

        .content-right {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .content-right::before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            border-radius: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            z-index: -1;
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.7; }
            50% { transform: scale(1.02); opacity: 1; }
        }

        .badges {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .badge-item {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .badge-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .badge-item:hover::before {
            left: 100%;
        }

        .badge-item:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.5);
        }

        .badge-item img {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .badge-text {
            font-size: 12px;
            font-weight: 500;
            color: #2d5a27;
        }

        .main-title {
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.2);
            background: linear-gradient(45deg, #46923c, #2d5a27, #46923c);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease-in-out infinite;
            letter-spacing: 2px;
            line-height: 1.2;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .subtitle {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.8;
            color: #2d5a27;
        }

        .tagline {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2d5a27;
        }

        .description {
            font-size: 16px;
            opacity: 0.8;
            position: relative;
            color: #2d5a27;
        }

        .description::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100px;
            height: 3px;
            background: #46923c;
        }

        .school-logo {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            backdrop-filter: blur(20px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 3px solid rgba(255,255,255,0.4);
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .school-logo::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .school-logo:hover {
            transform: scale(1.1);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .school-logo i {
            font-size: 80px;
            color: #46923c;
        }

        .school-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2d5a27;
        }

        .school-motto {
            font-size: 16px;
            opacity: 0.8;
            color: #2d5a27;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #46923c 0%, #5BA84F 100%);
            color: white;
            padding: 30px 0;
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

            .content-overlay {
                flex-direction: column;
                text-align: center;
            }

            .main-title {
                font-size: 32px;
            }

            .badges {
                justify-content: center;
            }

            .school-logo {
                width: 150px;
                height: 150px;
            }

            .school-logo i {
                font-size: 60px;
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
                <a href="#about">TENTANG</a>
                <a href="#programs">PROGRAM</a>
                <a href="#contact">KONTAK</a>
                
                <div class="login-dropdown">
                    <a href="#" class="login-btn" onclick="toggleDropdown()">
                        LOGIN <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="#" onclick="openLoginModal('guru')">GURU</a>
                        <a href="#" onclick="openLoginModal('tenaga_usaha')">TENAGA USAHA</a>
                    </div>
                </div>
                </nav>
        </div>
        </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-overlay">
            <div class="content-left">
                <div class="badges">
                    <div class="badge-item">
                        <i class="fas fa-graduation-cap" style="font-size: 40px; color: #46923c; margin-bottom: 10px;"></i>
                        <div class="badge-text">MTs Nurul Aiman</div>
                    </div>
                    <div class="badge-item">
                        <i class="fas fa-book-open" style="font-size: 40px; color: #46923c; margin-bottom: 10px;"></i>
                        <div class="badge-text">PENDIDIKAN BERKUALITAS</div>
                    </div>
                    <div class="badge-item">
                        <i class="fas fa-award" style="font-size: 40px; color: #46923c; margin-bottom: 10px;"></i>
                        <div class="badge-text">UNGGUL</div>
                    </div>
                </div>
                
                <p class="subtitle">Madrasah Tsanawiyah Unggulan</p>
                <h1 class="main-title">MENCIPTAKAN MASA DEPAN</h1>
                <p class="tagline">BERKONTRIBUSI UNTUK DUNIA</p>
                <p class="description">Membangun Generasi Berkarakter dan Berprestasi</p>
            </div>
            
            <div class="content-right">
                <div class="school-logo">
                    <i class="fas fa-mosque"></i>
                </div>
                <h2 class="school-name">MTs Nurul Aiman</h2>
                <p class="school-motto">Madrasah Unggulan dengan Teknologi Modern</p>
            </div>
                </div>
            </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="contact-info">
                <p><strong>Service Desk MTs Nurul Aiman</strong></p>
                <p>📞 0856-2452-5034 | 📱 Chat WA Only: 082263033855</p>
                <p>📧 internal.nurulaimam@gmail.com</p>
                <p>📷 Instagram: @mtssnuraiman | 🎵 TikTok: @mts.na.tjsari</p>
                <p>📍 Jln. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363</p>
            </div>
            <div class="copyright">
                <p>TEACHING MANAGEMENT SYSTEM NURANI (TMS NURANI) © MTs NURUL AIMAN</p>
                <p>Integrated Learning Management System for Modern Education</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="login-overlay" id="loginOverlay">
        <div class="login-modal">
            <button class="close-btn" onclick="closeLoginModal()">&times;</button>
            
            <!-- Logo Section -->
            <div class="modal-logo-section">
                <div class="modal-logo">
                    <div class="logo-circle-mosque">
                        <div class="mosque-logo">
                            <i class="fas fa-mosque" style="font-size: 40px; color: white;"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-school-name">MTS NURUL AIMAN TANJUNGSARI</div>
                <div class="modal-motto">BERIMAN • BERKARAKTER • BERILMU</div>
            </div>
            
            <h2 id="modalTitle">LOGIN GURU</h2>
            <p class="subtitle" id="modalSubtitle">Single Account, Single Sign On login</p>
            
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
                    <input type="text" class="form-control" name="email" placeholder="Masukkan username/email" value="{{ old('email') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-control" name="password" id="modalPassword" placeholder="Masukkan password" required>
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

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('show');
        }

        function openLoginModal(role) {
            const overlay = document.getElementById('loginOverlay');
            const modalTitle = document.getElementById('modalTitle');
            const modalSubtitle = document.getElementById('modalSubtitle');
            const userRole = document.getElementById('userRole');
            
            // Close dropdown
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.remove('show');
            
            // Set modal content based on role
            if (role === 'guru') {
                modalTitle.textContent = 'LOGIN GURU';
                modalSubtitle.textContent = 'Single Account, Single Sign On login';
                userRole.value = 'guru';
            } else if (role === 'tenaga_usaha') {
                modalTitle.textContent = 'LOGIN TENAGA USAHA';
                modalSubtitle.textContent = 'Single Account, Single Sign On login';
                userRole.value = 'tenaga_usaha';
            }
            
            // Show modal
            overlay.classList.add('show');
        }

        function closeLoginModal() {
            const overlay = document.getElementById('loginOverlay');
            overlay.classList.remove('show');
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

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const overlay = document.getElementById('loginOverlay');
            const modal = document.querySelector('.login-modal');
            
            if (event.target === overlay) {
                closeLoginModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLoginModal();
            }
        });

        // Handle form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const role = document.getElementById('userRole').value;
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            
            console.log('Login attempt:', { role, email, password });
            
            // Form will submit normally, no need to prevent default
        });

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
    </script>
    </body>
</html>