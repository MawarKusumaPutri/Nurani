<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <i class="fas fa-key"></i>
                <h2>Lupa Password</h2>
                <p class="text-muted">Masukkan email dan role Anda untuk reset password</p>
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
                
                <div class="form-group mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-control" name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="kepala_sekolah" {{ old('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="tu" {{ old('role') == 'tu' ? 'selected' : '' }}>Tenaga Usaha</option>
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" 
                           class="form-control" 
                           name="email" 
                           placeholder="Masukkan email Anda"
                           value="{{ old('email') }}"
                           required>
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
</body>
</html>

