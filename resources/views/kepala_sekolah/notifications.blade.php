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
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
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
        
        /* Modern Notification Card Styles */
        .notification-item {
            border-radius: 16px;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
        }
        
        .notification-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .notification-item:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        
        .notification-item:hover::before {
            width: 8px;
        }
        
        /* Login Notification - Green */
        .notification-login {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
        }
        .notification-login::before {
            background: linear-gradient(180deg, #4CAF50 0%, #2E7D32 100%);
        }
        .notification-login .notification-icon {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
        }
        
        /* Logout Notification - Orange/Red */
        .notification-logout {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            box-shadow: 0 4px 12px rgba(255, 152, 0, 0.2);
        }
        .notification-logout::before {
            background: linear-gradient(180deg, #ff9800 0%, #f57c00 100%);
        }
        .notification-logout .notification-icon {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            color: white;
        }
        
        /* Unread Notification */
        .notification-unread {
            border: 2px solid transparent;
            animation: pulse-border 2s infinite;
        }
        @keyframes pulse-border {
            0%, 100% { border-color: transparent; }
            50% { border-color: rgba(255, 107, 107, 0.5); }
        }
        
        .notification-unread .notification-icon {
            animation: bounce 1s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        /* Read Notification */
        .notification-read {
            opacity: 0.85;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        }
        .notification-read::before {
            background: #9e9e9e;
        }
        
        /* Notification Icon */
        .notification-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
        }
        
        /* Notification Content */
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .notification-message {
            font-size: 15px;
            color: #546e7a;
            line-height: 1.6;
            margin-bottom: 12px;
        }
        
        .notification-message strong {
            color: #2E7D32;
            font-weight: 600;
        }
        
        .notification-time {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #78909c;
            background: rgba(255, 255, 255, 0.6);
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
        }
        
        /* Badge Styles */
        .badge-new {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.4);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .badge-notification {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
        }
        
        /* Action Buttons */
        .notification-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-action:hover {
            transform: scale(1.1);
        }
        
        .btn-mark-read {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
        }
        
        /* Header Styles */
        .page-header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        
        .page-subtitle {
            color: #78909c;
            font-size: 16px;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .empty-state i {
            font-size: 80px;
            color: #cfd8dc;
            margin-bottom: 20px;
        }
        
        /* Pagination */
        .pagination-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }
        
        /* Checkbox Styles */
        .notification-checkbox {
            width: 22px;
            height: 22px;
            cursor: pointer;
            accent-color: #2E7D32;
            flex-shrink: 0;
        }
        
        .select-all-container {
            background: rgba(46, 125, 50, 0.1);
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .select-all-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .select-all-label {
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            cursor: pointer;
            user-select: none;
        }
        
        .bulk-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .btn-bulk {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-bulk:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn-bulk-mark {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
        }
        
        .btn-bulk-delete {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
        }
        
        .btn-bulk:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        
        .selected-count {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .notification-item-checkbox {
            margin-right: 15px;
        }
        
        /* Notification Status Badges */
        .notification-status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .notification-status-read {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
        }
        
        .notification-status-unread {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            color: white;
            animation: pulse 2s infinite;
        }
        
        .notification-status-badge i {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('partials.kepala-sekolah-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">
                                <i class="fas fa-bell me-2"></i>
                                Notifikasi
                            </h1>
                            <p class="page-subtitle mb-0">Kelola dan lihat semua notifikasi sistem</p>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex flex-column align-items-end">
                                <span class="badge badge-notification mb-2">
                                    <i class="fas fa-bell me-2"></i>
                                    {{ $totalNotifications }} Notifikasi
                                </span>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="notification-status-badge notification-status-read">
                                        <i class="fas fa-check-circle me-1"></i>
                                        <span>{{ $readNotifications }} Dibaca</span>
                                    </div>
                                    @if($unreadNotifications > 0)
                                    <div class="notification-status-badge notification-status-unread">
                                        <i class="fas fa-circle me-1"></i>
                                        <span>{{ $unreadNotifications }} Belum Dibaca</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Select All & Bulk Actions -->
                @if($notifications->count() > 0)
                <div class="select-all-container" id="bulkActionsContainer" style="display: none;">
                    <div class="select-all-left">
                        <input type="checkbox" id="selectAll" class="notification-checkbox">
                        <label for="selectAll" class="select-all-label">Pilih Semua</label>
                        <span class="selected-count" id="selectedCount">0 dipilih</span>
                    </div>
                    <div class="bulk-actions">
                        <button class="btn-bulk btn-bulk-mark" id="bulkMarkRead" disabled>
                            <i class="fas fa-check-double"></i>
                            Tandai Dibaca
                        </button>
                        <button class="btn-bulk btn-bulk-delete" id="bulkDelete" disabled>
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </div>
                </div>
                @endif

                <!-- Notifications List -->
                <div class="row">
                    <div class="col-12">
                        @if($notifications->count() > 0)
                            @foreach($notifications as $notification)
                                @php
                                    $isLogin = $notification->type === 'guru_login';
                                    $isLogout = $notification->type === 'guru_logout';
                                    $notificationClass = $isLogin ? 'notification-login' : ($isLogout ? 'notification-logout' : 'notification-read');
                                    $iconClass = $isLogin ? 'fa-sign-in-alt' : ($isLogout ? 'fa-sign-out-alt' : 'fa-info-circle');
                                @endphp
                                
                                <div class="card notification-item {{ $notificationClass }} {{ $notification->read_at ? 'notification-read' : 'notification-unread' }}" 
                                     data-notification-id="{{ $notification->id }}">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-start gap-4">
                                            <!-- Checkbox -->
                                            <div class="notification-item-checkbox">
                                                <input type="checkbox" 
                                                       class="notification-checkbox notification-item-checkbox-input" 
                                                       value="{{ $notification->id }}"
                                                       data-notification-id="{{ $notification->id }}">
                                            </div>
                                            
                                            <!-- Icon -->
                                            <div class="notification-icon">
                                                <i class="fas {{ $iconClass }}"></i>
                                            </div>
                                            
                                            <!-- Content -->
                                            <div class="notification-content">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <h5 class="notification-title mb-0">
                                                        {{ $notification->title }}
                                                        @if(!$notification->read_at)
                                                            <span class="badge-new">
                                                                <i class="fas fa-circle me-1" style="font-size: 6px;"></i>
                                                                Baru
                                                            </span>
                                                        @endif
                                                    </h5>
                                                </div>
                                                
                                                <p class="notification-message mb-3">
                                                    {!! $notification->message !!}
                                                </p>
                                                
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="notification-time">
                                                        <i class="fas fa-clock"></i>
                                                        <span>
                                                            <strong class="time-relative">{{ $notification->created_at->diffForHumans() }}</strong>
                                                            <span class="ms-2 time-absolute" 
                                                                  data-timestamp="{{ $notification->created_at->timestamp }}">
                                                                ({{ $notification->created_at->format('d M Y, H:i') }})
                                                            </span>
                                                            <span class="timezone-badge ms-1 badge bg-info"></span>
                                                        </span>
                                                    </div>
                                                    
                                                    <!-- Actions -->
                                                    <div class="notification-actions">
                                                        @if(!$notification->read_at)
                                                            <button class="btn-action btn-mark-read mark-as-read" 
                                                                    data-notification-id="{{ $notification->id }}"
                                                                    title="Tandai sebagai dibaca">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @endif
                                                        <button class="btn-action btn-delete" 
                                                                onclick="deleteNotification({{ $notification->id }})"
                                                                title="Hapus notifikasi">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Pagination -->
                            <div class="pagination-wrapper">
                                {{ $notifications->links() }}
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-bell-slash"></i>
                                <h4 class="mt-3 mb-2" style="color: #78909c;">Belum ada notifikasi</h4>
                                <p style="color: #90a4ae;">Notifikasi akan muncul di sini ketika ada aktivitas dari guru</p>
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
                        const badge = notificationItem.querySelector('.badge-new');
                        if (badge) {
                            badge.style.transition = 'opacity 0.3s';
                            badge.style.opacity = '0';
                            setTimeout(() => badge.remove(), 300);
                        }
                        
                        // Remove mark as read button
                        this.style.transition = 'opacity 0.3s';
                        this.style.opacity = '0';
                        setTimeout(() => this.remove(), 300);
                        
                        // Show success feedback
                        const icon = notificationItem.querySelector('.notification-icon');
                        icon.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            icon.style.transform = 'scale(1)';
                        }, 300);
                        
                        // Update counts
                        updateNotificationCounts();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menandai notifikasi sebagai dibaca');
                });
            });
        });

        // Select All functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const notificationCheckboxes = document.querySelectorAll('.notification-item-checkbox-input');
        const bulkActionsContainer = document.getElementById('bulkActionsContainer');
        const selectedCount = document.getElementById('selectedCount');
        const bulkMarkRead = document.getElementById('bulkMarkRead');
        const bulkDelete = document.getElementById('bulkDelete');
        
        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.notification-item-checkbox-input:checked');
            const count = checkedBoxes.length;
            
            if (count > 0) {
                bulkActionsContainer.style.display = 'flex';
                selectedCount.textContent = `${count} dipilih`;
                bulkMarkRead.disabled = false;
                bulkDelete.disabled = false;
            } else {
                bulkActionsContainer.style.display = 'none';
                bulkMarkRead.disabled = true;
                bulkDelete.disabled = true;
            }
            
            // Update select all checkbox
            if (selectAllCheckbox) {
                if (count === notificationCheckboxes.length) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else if (count > 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                }
            }
        }
        
        // Select All checkbox
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                notificationCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });
        }
        
        // Individual checkboxes
        notificationCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });
        
        // Bulk Mark as Read
        if (bulkMarkRead) {
            bulkMarkRead.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.notification-item-checkbox-input:checked');
                const notificationIds = Array.from(checkedBoxes).map(cb => cb.value);
                
                if (notificationIds.length === 0) {
                    alert('Pilih setidaknya satu notifikasi');
                    return;
                }
                
                if (confirm(`Tandai ${notificationIds.length} notifikasi sebagai dibaca?`)) {
                    // Mark all as read
                    Promise.all(notificationIds.map(id => {
                        return fetch(`/kepala-sekolah/notifications/${id}/mark-read`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                'Content-Type': 'application/json'
                            }
                        }).then(response => response.json());
                    }))
                    .then(results => {
                        // Update UI for all marked notifications
                        notificationIds.forEach(id => {
                            const notificationItem = document.querySelector(`[data-notification-id="${id}"]`);
                            if (notificationItem) {
                                notificationItem.classList.remove('notification-unread');
                                notificationItem.classList.add('notification-read');
                                
                                const badge = notificationItem.querySelector('.badge-new');
                                if (badge) {
                                    badge.style.transition = 'opacity 0.3s';
                                    badge.style.opacity = '0';
                                    setTimeout(() => badge.remove(), 300);
                                }
                                
                                const markReadBtn = notificationItem.querySelector('.mark-as-read');
                                if (markReadBtn) {
                                    markReadBtn.style.transition = 'opacity 0.3s';
                                    markReadBtn.style.opacity = '0';
                                    setTimeout(() => markReadBtn.remove(), 300);
                                }
                            }
                            
                            // Uncheck checkbox
                            const checkbox = document.querySelector(`.notification-item-checkbox-input[value="${id}"]`);
                            if (checkbox) {
                                checkbox.checked = false;
                            }
                        });
                        
                        updateBulkActions();
                        updateNotificationCounts();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menandai notifikasi sebagai dibaca');
                    });
                }
            });
        }
        
        // Update notification counts (read/unread)
        function updateNotificationCounts() {
            const readBadge = document.querySelector('.notification-status-read span');
            const unreadBadge = document.querySelector('.notification-status-unread span');
            
            if (readBadge) {
                const readCount = document.querySelectorAll('.notification-read').length;
                readBadge.textContent = `${readCount} Dibaca`;
            }
            
            if (unreadBadge) {
                const unreadCount = document.querySelectorAll('.notification-unread').length;
                if (unreadCount > 0) {
                    unreadBadge.textContent = `${unreadCount} Belum Dibaca`;
                    document.querySelector('.notification-status-unread').style.display = 'flex';
                } else {
                    document.querySelector('.notification-status-unread').style.display = 'none';
                }
            }
        }
        
        // Bulk Delete
        if (bulkDelete) {
            bulkDelete.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.notification-item-checkbox-input:checked');
                const notificationIds = Array.from(checkedBoxes).map(cb => cb.value);
                
                if (notificationIds.length === 0) {
                    alert('Pilih setidaknya satu notifikasi');
                    return;
                }
                
                if (confirm(`Hapus ${notificationIds.length} notifikasi?`)) {
                    // Delete all selected
                    Promise.all(notificationIds.map(id => {
                        return fetch(`/kepala-sekolah/notifications/${id}/delete`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                'Content-Type': 'application/json'
                            }
                        }).then(response => response.json());
                    }))
                    .then(results => {
                        // Remove all deleted notifications with animation
                        notificationIds.forEach((id, index) => {
                            setTimeout(() => {
                                const notificationItem = document.querySelector(`[data-notification-id="${id}"]`);
                                if (notificationItem) {
                                    notificationItem.style.transition = 'all 0.3s ease';
                                    notificationItem.style.opacity = '0';
                                    notificationItem.style.transform = 'translateX(-100px)';
                                    
                                    setTimeout(() => {
                                        notificationItem.remove();
                                        
                        // Update badge count
                        const badge = document.querySelector('.badge-notification');
                        if (badge) {
                            const currentText = badge.textContent.trim();
                            const match = currentText.match(/\d+/);
                            if (match) {
                                const currentCount = parseInt(match[0]);
                                badge.innerHTML = `<i class="fas fa-bell me-2"></i>${currentCount - 1} Notifikasi`;
                            }
                        }
                        
                        // Update read/unread counts
                        updateNotificationCounts();
                                        
                                        updateBulkActions();
                                    }, 300);
                                }
                            }, index * 50); // Stagger animations
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menghapus notifikasi');
                    });
                }
            });
        }

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
                        // Remove notification from UI with animation
                        const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        notificationItem.style.transition = 'all 0.3s ease';
                        notificationItem.style.opacity = '0';
                        notificationItem.style.transform = 'translateX(-100px)';
                        
                        setTimeout(() => {
                            notificationItem.remove();
                            
                            // Update badge count
                            const badge = document.querySelector('.badge-notification');
                            const currentText = badge.textContent.trim();
                            const currentCount = parseInt(currentText.match(/\d+/)[0]);
                            badge.innerHTML = `<i class="fas fa-bell me-2"></i>${currentCount - 1} Notifikasi`;
                        }, 300);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus notifikasi');
                });
            }
        }

        // Function to get timezone abbreviation
        function getTimezoneAbbreviation() {
            const now = new Date();
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            
            // Map common timezones to WIB, WIT, WITA
            if (timezone.includes('Jakarta') || timezone.includes('Asia/Jakarta')) {
                return 'WIB';
            } else if (timezone.includes('Makassar') || timezone.includes('Asia/Makassar') || timezone.includes('Ujung_Pandang')) {
                return 'WITA';
            } else if (timezone.includes('Jayapura') || timezone.includes('Asia/Jayapura')) {
                return 'WIT';
            }
            
            // Fallback: determine by UTC offset
            const offset = -now.getTimezoneOffset() / 60;
            if (offset === 7) return 'WIB';
            if (offset === 8) return 'WITA';
            if (offset === 9) return 'WIT';
            
            // Default to WIB if cannot determine
            return 'WIB';
        }

        // Function to format date in Indonesian format
        function formatIndonesianDate(timestamp) {
            const date = new Date(timestamp * 1000);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            
            const day = String(date.getDate()).padStart(2, '0');
            const month = months[date.getMonth()];
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            
            return `${day} ${month} ${year}, ${hours}:${minutes}`;
        }

        // Function to update relative time
        function updateRelativeTime(timestamp) {
            const now = new Date();
            const time = new Date(timestamp * 1000);
            const diff = Math.floor((now - time) / 1000);
            
            if (diff < 60) return 'Baru saja';
            if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
            if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
            if (diff < 604800) return Math.floor(diff / 86400) + ' hari yang lalu';
            if (diff < 2592000) return Math.floor(diff / 604800) + ' minggu yang lalu';
            if (diff < 31536000) return Math.floor(diff / 2592000) + ' bulan yang lalu';
            return Math.floor(diff / 31536000) + ' tahun yang lalu';
        }

        // Function to update all notification times
        function updateNotificationTimes() {
            const timezone = getTimezoneAbbreviation();
            const timeAbsoluteElements = document.querySelectorAll('.time-absolute');
            const timeRelativeElements = document.querySelectorAll('.time-relative');
            const timezoneBadges = document.querySelectorAll('.timezone-badge');
            
            // Update absolute time and timezone badge
            timeAbsoluteElements.forEach((el, index) => {
                const timestamp = el.getAttribute('data-timestamp');
                if (timestamp) {
                    const formattedTime = formatIndonesianDate(parseInt(timestamp));
                    el.textContent = `(${formattedTime})`;
                }
                
                // Update timezone badge
                if (timezoneBadges[index]) {
                    timezoneBadges[index].textContent = timezone;
                }
            });
            
            // Update relative time
            timeRelativeElements.forEach((el) => {
                const timeAbsolute = el.parentElement.querySelector('.time-absolute');
                if (timeAbsolute) {
                    const timestamp = timeAbsolute.getAttribute('data-timestamp');
                    if (timestamp) {
                        el.textContent = updateRelativeTime(parseInt(timestamp));
                    }
                }
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateNotificationTimes();
            
            // Update relative time every minute
            setInterval(updateNotificationTimes, 60000);
        });
    </script>
</body>
</html>
