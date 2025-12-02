<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="referrer" content="no-referrer-when-downgrade">
    <title>Login Guru - TMS NURANI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
        
        .login-container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            padding: 50px;
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 32px rgba(46, 125, 50, 0.3);
        }
        
        .logo i {
            font-size: 40px;
            color: white;
        }
        
        .brand-name {
            font-size: 28px;
            font-weight: bold;
            color: #2E7D32;
            margin-bottom: 10px;
        }
        
        .brand-subtitle {
            color: #666;
            font-size: 16px;
            margin-bottom: 0;
        }
        
        .form-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .form-subtitle {
            color: #666;
            margin-bottom: 30px;
            text-align: center;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #F0F4F0;
        }
        
        .form-control:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
            background: white;
        }
        
        .input-group {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #2E7D32;
            cursor: pointer;
            padding: 5px 8px;
            z-index: 10;
            font-size: 18px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .password-toggle:hover {
            color: #1B5E20;
            transform: translateY(-50%) scale(1.1);
        }
        
        .password-toggle:active {
            transform: translateY(-50%) scale(0.95);
        }
        
        .password-toggle:focus {
            outline: none;
            color: #1B5E20;
        }
        
        .input-group .form-control {
            padding-right: 50px;
        }
        
        .input-group .form-control:focus {
            padding-right: 50px;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3);
        }
        
        .form-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .form-links a {
            color: #2E7D32;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            display: inline-block;
            padding: 10px 20px;
            background: rgba(46, 125, 50, 0.1);
            border: 2px solid rgba(46, 125, 50, 0.3);
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .form-links a::before {
            content: '🔑 ';
            margin-right: 5px;
        }
        
        .form-links a:hover {
            color: #1B5E20;
            background: rgba(46, 125, 50, 0.2);
            border-color: rgba(46, 125, 50, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
            text-decoration: none;
        }
        
        .form-links a:active {
            transform: translateY(0);
        }
        
        .register-link {
            margin-top: 15px;
        }
        
        .register-link .highlight {
            color: #2E7D32;
            font-weight: 600;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            padding: 10px 0;
        }
        
        .form-check-input {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: #2E7D32;
            border: 2px solid #e1e5e9;
            border-radius: 4px;
        }
        
        .form-check-input:checked {
            background-color: #2E7D32;
            border-color: #2E7D32;
        }
        
        .form-check-label {
            cursor: pointer;
            user-select: none;
            display: flex;
            align-items: center;
            color: #666;
            font-size: 14px;
        }
        
        .form-check-label i {
            margin-right: 5px;
            color: #2E7D32;
        }
        
        .form-check-label:hover {
            color: #2E7D32;
        }
        
        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .features {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e1e5e9;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #666;
            font-size: 14px;
        }
        
        .feature-item i {
            color: #2E7D32;
            margin-right: 10px;
            width: 20px;
        }
        
        @media (max-width: 768px) {
            body {
                overflow-y: auto;
                min-height: 100vh;
            }
            
            .login-container {
                padding: 15px;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding-top: 20px;
                padding-bottom: 20px;
            }
            
            .login-card {
                margin: 0 auto;
                padding: 35px 25px;
                max-width: 100%;
                width: 100%;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            }
            
            .logo-section {
                margin-bottom: 30px;
            }
            
            .logo {
                width: 70px;
                height: 70px;
                margin-bottom: 15px;
            }
            
            .logo i {
                font-size: 35px;
            }
            
            .brand-name {
                font-size: 26px;
                margin-bottom: 8px;
            }
            
            .brand-subtitle {
                font-size: 14px;
            }
            
            .form-title {
                font-size: 22px;
                margin-bottom: 8px;
            }
            
            .form-subtitle {
                font-size: 13px;
                margin-bottom: 25px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-label {
                font-size: 14px;
                margin-bottom: 6px;
            }
            
            .form-control {
                padding: 14px 18px;
                font-size: 16px;
                border-radius: 10px;
            }
            
            .btn-login {
                padding: 14px 25px;
                font-size: 16px;
                border-radius: 10px;
                margin-bottom: 15px;
            }
            
            .form-check {
                padding: 8px 0;
            }
            
            .form-check-label {
                font-size: 13px;
            }
            
            .form-links {
                margin-top: 15px;
            }
            
            .form-links a {
                font-size: 14px;
                padding: 10px 18px;
            }
            
            .features {
                margin-top: 25px;
                padding-top: 25px;
            }
            
            .feature-item {
                font-size: 13px;
                margin-bottom: 12px;
            }
            
            .alert {
                padding: 12px 15px;
                font-size: 13px;
            }
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 10px;
                padding-top: 15px;
                padding-bottom: 15px;
            }
            
            .login-card {
                padding: 30px 20px;
                border-radius: 15px;
            }
            
            .logo-section {
                margin-bottom: 25px;
            }
            
            .logo {
                width: 60px;
                height: 60px;
                margin-bottom: 12px;
            }
            
            .logo i {
                font-size: 30px;
            }
            
            .brand-name {
                font-size: 22px;
                margin-bottom: 6px;
            }
            
            .brand-subtitle {
                font-size: 13px;
            }
            
            .form-title {
                font-size: 20px;
                margin-bottom: 6px;
            }
            
            .form-subtitle {
                font-size: 12px;
                margin-bottom: 20px;
            }
            
            .form-group {
                margin-bottom: 18px;
            }
            
            .form-label {
                font-size: 13px;
                margin-bottom: 5px;
            }
            
            .form-control {
                padding: 13px 16px;
                font-size: 16px;
                border-radius: 8px;
            }
            
            .btn-login {
                padding: 13px 20px;
                font-size: 15px;
                border-radius: 8px;
                margin-bottom: 12px;
            }
            
            .form-check {
                padding: 6px 0;
            }
            
            .form-check-label {
                font-size: 12px;
            }
            
            .form-links {
                margin-top: 12px;
            }
            
            .form-links a {
                font-size: 13px;
                padding: 8px 15px;
            }
            
            .features {
                margin-top: 20px;
                padding-top: 20px;
            }
            
            .feature-item {
                font-size: 12px;
                margin-bottom: 10px;
            }
            
            .feature-item i {
                font-size: 14px;
                margin-right: 8px;
                width: 18px;
            }
            
            .alert {
                padding: 10px 12px;
                font-size: 12px;
            }
            
            #email-hint {
                font-size: 11px;
            }
        }
        
        @media (max-width: 360px) {
            .login-card {
                padding: 25px 15px;
            }
            
            .logo {
                width: 55px;
                height: 55px;
            }
            
            .logo i {
                font-size: 28px;
            }
            
            .brand-name {
                font-size: 20px;
            }
            
            .form-title {
                font-size: 18px;
            }
            
            .form-control {
                padding: 12px 14px;
                font-size: 15px;
            }
            
            .btn-login {
                padding: 12px 18px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="brand-name">NURANI</h1>
                <p class="brand-subtitle">Teaching Management System</p>
            </div>
            
            <h2 class="form-title">Masuk ke TMS NURANI</h2>
            <p class="form-subtitle">Silakan masukkan kredensial Anda untuk mengakses TMS</p>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select class="form-control" name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="kepala_sekolah" {{ old('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="tu" {{ old('role') == 'tu' ? 'selected' : '' }}>Tenaga Usaha</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" 
                           class="form-control" 
                           name="email" 
                           id="email"
                           placeholder="Masukkan email Anda"
                           value="{{ old('email') }}"
                           required>
                    <small class="text-muted" id="email-hint" style="display: none; font-size: 12px; margin-top: 5px;">
                        <i class="fas fa-info-circle"></i> Email otomatis terisi berdasarkan role yang dipilih
                    </small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control" 
                               name="password" 
                               id="password"
                               placeholder="Masukkan password Anda"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="remember" 
                               id="remember" 
                               value="1"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember" style="color: #666; font-size: 14px; cursor: pointer;">
                            <i class="fas fa-check-circle"></i> Ingat saya (Auto-login)
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login" id="loginButton">
                    <i class="fas fa-sign-in-alt me-2"></i><span id="loginButtonText">Masuk ke TMS</span>
                    <span id="loginButtonLoading" style="display: none;">
                        <i class="fas fa-spinner fa-spin me-2"></i>Memproses...
                    </span>
                </button>
                
                <div id="loginError" class="alert alert-danger" style="display: none; margin-top: 15px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="loginErrorText"></span>
                </div>
            </form>
            
            <div class="form-links">
                <a href="{{ route('password.request') }}" class="d-block mb-2">Lupa password?</a>
            </div>
            
            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Kelola RPP dan Materi Pembelajaran</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <span>Presensi Digital Real-time</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Evaluasi dan Laporan Pembelajaran</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (!passwordField || !toggleIcon) return;
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
            
            // Pastikan icon tetap terlihat
            toggleIcon.style.display = 'block';
            toggleIcon.style.visibility = 'visible';
            toggleIcon.style.opacity = '1';
        }
        
        // Auto-fill email berdasarkan role
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            const roleSelect = document.querySelector('select[name="role"]');
            const emailInput = document.getElementById('email');
            const emailHint = document.getElementById('email-hint');
            
            // Pastikan icon tetap terlihat saat input field focus
            if (passwordField && toggleIcon) {
                passwordField.addEventListener('focus', function() {
                    toggleIcon.style.display = 'block';
                    toggleIcon.style.visibility = 'visible';
                    toggleIcon.style.opacity = '1';
                });
                
                passwordField.addEventListener('blur', function() {
                    toggleIcon.style.display = 'block';
                    toggleIcon.style.visibility = 'visible';
                    toggleIcon.style.opacity = '1';
                });
            }
            
            // Auto-fill email saat role dipilih
            if (roleSelect && emailInput) {
                roleSelect.addEventListener('change', function() {
                    const role = this.value;
                    if (role) {
                        // Ambil email pertama dari role yang dipilih
                        fetch(`/api/users-by-role?role=${role}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success && data.users && data.users.length > 0) {
                                    // Auto-fill email pertama
                                    emailInput.value = data.users[0].email;
                                    emailHint.style.display = 'block';
                                    
                                    // Jika hanya ada 1 user, auto-fill password juga (opsional)
                                    if (data.users.length === 1 && data.users[0].default_password) {
                                        // Jangan auto-fill password untuk keamanan
                                        // Tapi bisa ditampilkan hint
                                    }
                                }
                            })
                            .catch(error => {
                                console.log('Auto-fill error:', error);
                                // Jika error, biarkan user input manual
                            });
                    } else {
                        emailInput.value = '';
                        emailHint.style.display = 'none';
                    }
                });
            }
            
            // Load saved credentials dari localStorage (remember me)
            const savedEmail = localStorage.getItem('remembered_email');
            const savedRole = localStorage.getItem('remembered_role');
            const rememberChecked = localStorage.getItem('remember_me') === 'true';
            
            if (rememberChecked && savedEmail && savedRole) {
                if (roleSelect) roleSelect.value = savedRole;
                if (emailInput) emailInput.value = savedEmail;
                const rememberCheckbox = document.getElementById('remember');
                if (rememberCheckbox) rememberCheckbox.checked = true;
            }
        });
        
        // Handle login - biarkan form submit normal untuk menghindari security warning
        // Hanya tambahkan loading state dan save credentials
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginButton = document.getElementById('loginButton');
            const loginButtonText = document.getElementById('loginButtonText');
            const loginButtonLoading = document.getElementById('loginButtonLoading');
            const loginError = document.getElementById('loginError');
            
            // Hide error
            if (loginError) {
                loginError.style.display = 'none';
            }
            
            // Show loading state
            if (loginButton) {
                loginButton.disabled = true;
            }
            if (loginButtonText) {
                loginButtonText.style.display = 'none';
            }
            if (loginButtonLoading) {
                loginButtonLoading.style.display = 'inline';
            }
            
            // Save credentials jika remember me checked
            const rememberCheckbox = document.getElementById('remember');
            const emailInput = document.getElementById('email');
            const roleSelect = document.querySelector('select[name="role"]');
            
            if (rememberCheckbox && rememberCheckbox.checked && emailInput && roleSelect) {
                localStorage.setItem('remembered_email', emailInput.value);
                localStorage.setItem('remembered_role', roleSelect.value);
                localStorage.setItem('remember_me', 'true');
            } else {
                localStorage.removeItem('remembered_email');
                localStorage.removeItem('remembered_role');
                localStorage.removeItem('remember_me');
            }
            
            // Biarkan form submit secara normal (tidak preventDefault)
            // Browser akan handle submission dan redirect otomatis
            // Jika muncul warning, user bisa klik "Tetap kirim" atau "Send anyway"
        });
    </script>
</body>
</html>