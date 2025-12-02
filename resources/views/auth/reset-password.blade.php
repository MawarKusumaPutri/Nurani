<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Reset Password - TMS NURANI</title>
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
        
        .logo-section i {
            font-size: 48px;
            color: #2E7D32;
            margin-bottom: 15px;
        }
        
        .logo-section h2 {
            color: #2E7D32;
            font-weight: 700;
            margin: 0;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.4);
        }
        
        .form-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .form-links a {
            color: #2E7D32;
            text-decoration: none;
            font-weight: 500;
        }
        
        .form-links a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
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
        
        .input-group {
            position: relative;
        }
        
        .input-group .form-control {
            padding-right: 50px;
        }
        
        .input-group .form-control:focus {
            padding-right: 50px;
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
            
            .logo-section i {
                font-size: 42px;
                margin-bottom: 12px;
            }
            
            .logo-section h2 {
                font-size: 24px;
            }
            
            .logo-section p {
                font-size: 13px;
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
            
            .input-group .form-control {
                padding-right: 45px;
            }
            
            .password-toggle {
                right: 12px;
                font-size: 16px;
            }
            
            .btn-login {
                padding: 14px 25px;
                font-size: 16px;
                border-radius: 10px;
            }
            
            .form-links {
                margin-top: 15px;
            }
            
            .form-links a {
                font-size: 14px;
            }
            
            .alert {
                padding: 12px 15px;
                font-size: 13px;
            }
            
            .text-muted {
                font-size: 12px;
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
            
            .logo-section i {
                font-size: 38px;
                margin-bottom: 10px;
            }
            
            .logo-section h2 {
                font-size: 22px;
            }
            
            .logo-section p {
                font-size: 12px;
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
            
            .input-group .form-control {
                padding-right: 40px;
            }
            
            .password-toggle {
                right: 10px;
                font-size: 15px;
            }
            
            .btn-login {
                padding: 13px 20px;
                font-size: 15px;
                border-radius: 8px;
            }
            
            .form-links {
                margin-top: 12px;
            }
            
            .form-links a {
                font-size: 13px;
            }
            
            .alert {
                padding: 10px 12px;
                font-size: 12px;
            }
            
            .text-muted {
                font-size: 11px;
            }
        }
        
        @media (max-width: 360px) {
            .login-card {
                padding: 25px 15px;
            }
            
            .logo-section i {
                font-size: 35px;
            }
            
            .logo-section h2 {
                font-size: 20px;
            }
            
            .form-control {
                padding: 12px 14px;
                font-size: 15px;
            }
            
            .input-group .form-control {
                padding-right: 38px;
            }
            
            .password-toggle {
                right: 8px;
                font-size: 14px;
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
                <i class="fas fa-lock"></i>
                <h2>Reset Password</h2>
                <p class="text-muted">Masukkan password baru Anda</p>
                <div class="alert alert-info" style="margin-top: 15px; padding: 10px; font-size: 12px; background-color: #e3f2fd; border: 1px solid #90caf9; color: #1565c0;">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Catatan:</strong> Jika muncul warning keamanan, klik "Send anyway" untuk melanjutkan (normal untuk Ngrok free tier).
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div class="form-group mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" 
                           class="form-control" 
                           value="{{ $email }}"
                           readonly
                           style="background-color: #f5f5f5;">
                    <small class="text-muted">Email ini akan digunakan untuk reset password</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control" 
                               name="password" 
                               id="password"
                               placeholder="Masukkan password baru (minimal 8 karakter)"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               placeholder="Ulangi password baru"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePasswordConfirmation()">
                            <i class="fas fa-eye" id="toggleIconConfirmation"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-key me-2"></i>Reset Password
                </button>
            </form>
            
            <div class="form-links">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
                </a>
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

        function togglePasswordConfirmation() {
            const passwordField = document.getElementById('password_confirmation');
            const toggleIcon = document.getElementById('toggleIconConfirmation');
            
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
        
        // Pastikan icon tetap terlihat saat input field focus
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const passwordConfirmationField = document.getElementById('password_confirmation');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleIconConfirmation = document.getElementById('toggleIconConfirmation');
            
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
            
            if (passwordConfirmationField && toggleIconConfirmation) {
                passwordConfirmationField.addEventListener('focus', function() {
                    toggleIconConfirmation.style.display = 'block';
                    toggleIconConfirmation.style.visibility = 'visible';
                    toggleIconConfirmation.style.opacity = '1';
                });
                
                passwordConfirmationField.addEventListener('blur', function() {
                    toggleIconConfirmation.style.display = 'block';
                    toggleIconConfirmation.style.visibility = 'visible';
                    toggleIconConfirmation.style.opacity = '1';
                });
            }
        });
    </script>
</body>
</html>

