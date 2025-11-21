<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            .login-card {
                margin: 20px;
                padding: 30px;
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
            
            <form method="POST" action="{{ route('login') }}">
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
                           placeholder="Masukkan email Anda"
                           value="{{ old('email') }}"
                           required>
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
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk ke TMS
                </button>
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
        
        // Pastikan icon tetap terlihat saat input field focus
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
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
        });
    </script>
</body>
</html>