<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Lupa Password - TMS NURANI</title>
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
            
            #email-hint {
                font-size: 11px;
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
            
            #email-hint {
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
                <i class="fas fa-key"></i>
                <h2>Lupa Password</h2>
                <p class="text-muted">Masukkan email dan role Anda untuk reset password</p>
                <div class="alert alert-info" style="margin-top: 15px; padding: 10px; font-size: 12px; background-color: #e3f2fd; border: 1px solid #90caf9; color: #1565c0;">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Catatan:</strong> Jika muncul warning keamanan, klik "Send anyway" untuk melanjutkan (normal untuk Ngrok free tier).
                </div>
            </div>


            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif
                
                <div class="form-group mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-control" name="role" id="role" required>
                        <option value="">Pilih Role</option>
                        <option value="guru" {{ (old('role') ?? ($role ?? '')) == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="kepala_sekolah" {{ (old('role') ?? ($role ?? '')) == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="tu" {{ (old('role') ?? ($role ?? '')) == 'tu' ? 'selected' : '' }}>Tenaga Usaha</option>
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" 
                           class="form-control" 
                           name="email" 
                           id="email"
                           placeholder="Masukkan email Anda"
                           value="{{ old('email') ?? ($email ?? '') }}"
                           required>
                    <small class="text-muted" id="email-hint" style="display: none; font-size: 12px; margin-top: 5px;">
                        <i class="fas fa-info-circle"></i> Email otomatis terisi berdasarkan role yang dipilih
                    </small>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Link Reset Password
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
        // Auto-fill email berdasarkan role
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const emailInput = document.getElementById('email');
            const emailHint = document.getElementById('email-hint');
            
            // Jika email dan role sudah ada dari query string, jangan auto-fill
            const urlParams = new URLSearchParams(window.location.search);
            const emailFromUrl = urlParams.get('email');
            const roleFromUrl = urlParams.get('role');
            
            if (emailFromUrl && roleFromUrl) {
                // Email dan role sudah diisi dari redirect, jangan ubah
                return;
            }
            
            // Auto-fill email saat role dipilih
            if (roleSelect && emailInput) {
                roleSelect.addEventListener('change', function() {
                    const role = this.value;
                    if (role && !emailInput.value) {
                        // Ambil email pertama dari role yang dipilih
                        fetch(`/api/users-by-role?role=${role}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success && data.users && data.users.length > 0) {
                                    // Auto-fill email pertama
                                    emailInput.value = data.users[0].email;
                                    emailHint.style.display = 'block';
                                }
                            })
                            .catch(error => {
                                console.log('Auto-fill error:', error);
                                // Jika error, biarkan user input manual
                            });
                    } else if (!role) {
                        emailInput.value = '';
                        emailHint.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>

