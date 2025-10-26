<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifikasi - Kepala Sekolah</title>
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
        .notification-item {
            border-left: 4px solid #2E7D32;
            transition: all 0.3s ease;
        }
        .notification-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .notification-unread {
            background-color: #f8f9ff;
            border-left-color: #ff6b6b;
        }
        .notification-read {
            background-color: #f8f9fa;
            opacity: 0.8;
        }
        .badge-notification {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-user-tie me-2"></i>
                        Kepala Sekolah
                    </h4>
                    <div class="text-center mb-4">
                        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user-tie fa-2x text-primary"></i>
                        </div>
                        <h6 class="text-white mt-2 mb-1">Maman Suparman, A.KS</h6>
                        <small class="text-white-50">Kepala Sekolah</small>
                    </div>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('kepala_sekolah.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a class="nav-link active" href="{{ route('kepala_sekolah.notifications') }}">
                        <i class="fas fa-bell me-2"></i> Notifikasi
                    </a>
                    <a class="nav-link" href="{{ route('kepala_sekolah.guru') }}">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Data Guru
                    </a>
                    <a class="nav-link" href="{{ route('kepala_sekolah.laporan') }}">
                        <i class="fas fa-chart-bar me-2"></i> Laporan
                    </a>
                    <hr class="text-white-50">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-bell me-2 text-primary"></i>
                            Notifikasi
                        </h2>
                        <p class="text-muted mb-0">Kelola dan lihat semua notifikasi sistem</p>
                    </div>
                    <div>
                        <span class="badge badge-notification fs-6">
                            {{ $notifications->total() }} Notifikasi
                        </span>
                    </div>
                </div>

                <!-- Notifications List -->
                <div class="row">
                    <div class="col-12">
                        @if($notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <div class="card notification-item mb-3 {{ $notification->read_at ? 'notification-read' : 'notification-unread' }}" 
                                     data-notification-id="{{ $notification->id }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-{{ $notification->type === 'guru_login' ? 'sign-in-alt' : ($notification->type === 'guru_logout' ? 'sign-out-alt' : 'info-circle') }} 
                                                       me-2 text-primary"></i>
                                                    <h6 class="mb-0">{{ $notification->title }}</h6>
                                                    @if(!$notification->read_at)
                                                        <span class="badge bg-danger ms-2">Baru</span>
                                                    @endif
                                                </div>
                                                <p class="text-muted mb-2">{{ $notification->message }}</p>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                    ({{ $notification->created_at->format('d M Y, H:i') }})
                                                </small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if(!$notification->read_at)
                                                        <li>
                                                            <a class="dropdown-item mark-as-read" href="#" 
                                                               data-notification-id="{{ $notification->id }}">
                                                                <i class="fas fa-check me-2"></i> Tandai Dibaca
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item" href="#" 
                                                           onclick="deleteNotification({{ $notification->id }})">
                                                            <i class="fas fa-trash me-2"></i> Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $notifications->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada notifikasi</h5>
                                <p class="text-muted">Notifikasi akan muncul di sini ketika ada aktivitas dari guru</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mark notification as read
        document.querySelectorAll('.mark-as-read').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const notificationId = this.dataset.notificationId;
                
                fetch(`/kepala-sekolah/notifications/${notificationId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI
                        const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        notificationItem.classList.remove('notification-unread');
                        notificationItem.classList.add('notification-read');
                        
                        // Remove "Baru" badge
                        const badge = notificationItem.querySelector('.badge.bg-danger');
                        if (badge) {
                            badge.remove();
                        }
                        
                        // Remove mark as read button
                        this.closest('.dropdown-item').remove();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menandai notifikasi sebagai dibaca');
                });
            });
        });

        // Delete notification
        function deleteNotification(notificationId) {
            if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                fetch(`/kepala-sekolah/notifications/${notificationId}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove notification from UI
                        const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        notificationItem.remove();
                        
                        // Update badge count
                        const badge = document.querySelector('.badge-notification');
                        const currentCount = parseInt(badge.textContent);
                        badge.textContent = `${currentCount - 1} Notifikasi`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus notifikasi');
                });
            }
        }
    </script>
</body>
</html>
