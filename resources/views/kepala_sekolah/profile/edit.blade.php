<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Kepala Sekolah Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
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
        
        /* Responsive Styles */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1050;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        
        @media (max-width: 991px) {
            .sidebar-toggle {
                display: block;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                z-index: 1050;
                transition: left 0.3s ease;
                width: 280px;
                max-width: 80%;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .col-md-9.col-lg-10 {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <div class="container-fluid">
        <div class="row">
            @include('partials.kepala-sekolah-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Edit Profil</h2>
                        <p class="text-muted">Ubah informasi profil Anda</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('kepala_sekolah.profile.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-edit"></i> Form Edit Profil
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('kepala_sekolah.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="photo" class="form-label">Foto Profil</label>
                                        <div class="mb-2 position-relative d-inline-block">
                                            @php
                                                $freshUser = \App\Models\User::find($user->id);
                                                $photoUrl = null;
                                                $hasPhoto = false;
                                                
                                                if ($freshUser && !empty($freshUser->photo)) {
                                                    // Method 1: PhotoHelper dengan default path
                                                    $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshUser->photo, 'profiles/kepala_sekolah');
                                                    
                                                    // Method 2: PhotoHelper tanpa default path
                                                    if (!$photoUrl) {
                                                        $photoUrl = \App\Helpers\PhotoHelper::getPhotoUrl($freshUser->photo);
                                                    }
                                                    
                                                    // Method 3: Langsung cek di storage
                                                    if (!$photoUrl && \Illuminate\Support\Facades\Storage::disk('public')->exists($freshUser->photo)) {
                                                        $baseUrl = request()->getSchemeAndHttpHost();
                                                        $photoUrl = $baseUrl . '/storage/' . $freshUser->photo . '?v=' . time() . '&r=' . rand(1000, 9999);
                                                    }
                                                    
                                                    // Method 4: Jika PhotoHelper menghasilkan URL dengan localhost, ganti dengan base URL
                                                    if ($photoUrl && strpos($photoUrl, 'localhost') !== false) {
                                                        $baseUrl = request()->getSchemeAndHttpHost();
                                                        $photoUrl = str_replace('http://localhost', $baseUrl, $photoUrl);
                                                    }
                                                    
                                                    $hasPhoto = $photoUrl !== null && $photoUrl !== '' && $photoUrl !== 'null' && $photoUrl !== '#';
                                                }
                                            @endphp
                                            <div class="position-relative d-inline-block" style="width: 150px; height: 150px; margin-bottom: 15px;">
                                                <!-- Preview Image -->
                                                <img id="photoPreview" 
                                                     src="{{ $hasPhoto && $photoUrl ? $photoUrl : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22150%22 height=%22150%22%3E%3C/svg%3E' }}" 
                                                     alt="Foto Profil" 
                                                     class="img-thumbnail" 
                                                     style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 3px solid #2E7D32; {{ $hasPhoto && $photoUrl ? 'display: block;' : 'display: none;' }} position: relative; z-index: 2; background: #f8f9fa;"
                                                     onload="console.log('Photo loaded successfully:', this.src); document.getElementById('photoPlaceholder').style.display='none'; document.getElementById('photoCheckmark').style.display='flex';"
                                                     onerror="console.error('Error loading photo:', this.src); this.onerror=null; this.style.display='none'; document.getElementById('photoPlaceholder').style.display='flex'; document.getElementById('photoCheckmark').style.display='none';">
                                                
                                                <!-- Placeholder Icon -->
                                                <div id="photoPlaceholder" 
                                                     class="bg-light d-inline-flex align-items-center justify-content-center" 
                                                     style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #2E7D32; position: absolute; top: 0; left: 0; z-index: 1; {{ $hasPhoto && $photoUrl ? 'display: none;' : 'display: flex;' }} background: #f8f9fa;">
                                                    <i class="fas fa-user-tie fa-3x text-muted"></i>
                                                </div>
                                                
                                                <!-- Checkmark indicator -->
                                                <div id="photoCheckmark" 
                                                     class="position-absolute d-flex align-items-center justify-content-center" 
                                                     style="bottom: 5px; right: 5px; background: rgba(40, 167, 69, 0.9); border-radius: 50%; width: 36px; height: 36px; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 3px solid white; {{ $hasPhoto && $photoUrl ? 'display: flex;' : 'display: none;' }}">
                                                    <i class="fas fa-check text-white" style="font-size: 16px; font-weight: bold;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" class="form-control" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewPhoto(this)">
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    </div>

                                    <hr class="my-4">

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $user->nip) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                    </div>

                                    <hr class="my-4">
                                    <h6 class="mb-3">Ubah Password (Opsional)</h6>
                                    <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                                        </button>
                                        <a href="{{ route('kepala_sekolah.profile.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle"></i> Informasi
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Pastikan semua informasi yang Anda masukkan sudah benar.
                                </p>
                                <p class="small text-muted">
                                    <i class="fas fa-lock text-info me-2"></i>
                                    Password hanya akan diubah jika Anda mengisi kolom password baru.
                                </p>
                                <p class="small text-muted">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    Email harus unik dan tidak boleh sama dengan pengguna lain.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (sidebar && overlay) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    }
    
    function closeSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (sidebar && overlay) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }
    }
    
    // Close sidebar when clicking on nav links
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeSidebar();
            });
        });
    });
    
    </script>
    <script>
    function previewPhoto(input) {
        console.log('previewPhoto called', input.files);
        
        if (input.files && input.files[0]) {
            // Validasi ukuran file (maksimal 2MB)
            const file = input.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB dalam bytes
            
            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                input.value = ''; // Reset input
                return;
            }
            
            // Validasi tipe file
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak valid! Hanya JPG, PNG, dan GIF yang diizinkan.');
                input.value = ''; // Reset input
                return;
            }
            
            const reader = new FileReader();
            const checkmark = document.getElementById('photoCheckmark');
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');
            
            reader.onload = function(e) {
                console.log('FileReader loaded', e.target.result);
                
                if (preview && placeholder) {
                    // Set preview image
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    preview.style.zIndex = '2';
                    
                    // Hide placeholder
                    placeholder.style.display = 'none';
                    
                    // Show checkmark with animation
                    if (checkmark) {
                        checkmark.style.display = 'flex';
                        checkmark.style.animation = 'fadeIn 0.3s ease-in';
                        checkmark.style.background = 'rgba(40, 167, 69, 0.9)';
                    }
                    
                    console.log('Preview updated successfully');
                } else {
                    console.error('Preview or placeholder element not found');
                }
            };
            
            reader.onerror = function(e) {
                console.error('FileReader error', e);
                alert('Gagal membaca file. Silakan coba lagi.');
            };
            
            reader.readAsDataURL(file);
        } else {
            console.log('No file selected');
            // Hide checkmark if no file selected
            const checkmark = document.getElementById('photoCheckmark');
            if (checkmark) {
                checkmark.style.display = 'none';
            }
        }
    }
    
    // Show checkmark if photo already exists on page load
    document.addEventListener('DOMContentLoaded', function() {
        const preview = document.getElementById('photoPreview');
        const checkmark = document.getElementById('photoCheckmark');
        
        if (preview && checkmark) {
            // Check if preview is visible and has a valid image
            const hasValidImage = preview.src && 
                                 preview.src !== '' && 
                                 preview.src !== '#' && 
                                 preview.src !== window.location.href &&
                                 preview.src.indexOf('data:image/svg') === -1 &&
                                 preview.style.display !== 'none';
            
            if (hasValidImage) {
                checkmark.style.display = 'flex';
                console.log('Existing photo found, checkmark shown');
            } else {
                console.log('No existing photo');
            }
        }
    });
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</body>
</html>

