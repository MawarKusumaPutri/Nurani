@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah - TMS NURANI')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50">
    <!-- Header Dashboard -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Kepala Sekolah</h1>
                    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-500">NUPTK: {{ Auth::user()->nip }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        Kepala Sekolah
                    </span>
                    
                    <!-- Notification Bell in Gray Area -->
                    <div class="relative bg-gray-100 rounded-full p-3 hover:bg-gray-200 transition-colors cursor-pointer">
                        <div class="relative">
                            <i class="fas fa-bell text-red-500 text-xl"></i>
                            <!-- Badge yang selalu ada, tapi angka berubah -->
                            <span class="notification-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold shadow-lg" id="notificationCount">
                                {{ $unreadNotifications }}
                            </span>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Guru</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Guru::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                        <p class="text-2xl font-bold text-gray-900">180</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Kehadiran Rata-rata</p>
                        <p class="text-2xl font-bold text-gray-900">85%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-trophy text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Prestasi Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-900">3</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Data Guru dan Mata Pelajaran -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Data Guru dan Mata Pelajaran</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $gurus = \App\Models\Guru::with('user')->take(5)->get();
                                @endphp
                                @foreach($gurus as $guru)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $guru->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guru->mata_pelajaran }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($guru->status === 'aktif')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Aktif</span>
                                        @elseif($guru->status === 'izin')
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Izin</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Sakit</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button class="w-full mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-eye mr-2"></i>Lihat Semua Data
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="space-y-6">
                <!-- Kehadiran Hari Ini -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Kehadiran Hari Ini</h3>
                    </div>
                    <div class="p-6">
                    @php
                        $totalGuru = \App\Models\Guru::count();
                        $hadir = \App\Models\Guru::where('status', 'aktif')->count();
                        $izin = \App\Models\Guru::where('status', 'izin')->count();
                        $sakit = \App\Models\Guru::where('status', 'sakit')->count();
                        $persentase = $totalGuru > 0 ? round(($hadir / $totalGuru) * 100) : 0;
                    @endphp
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total Guru</span>
                            <span class="font-semibold">{{ $totalGuru }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Hadir</span>
                            <span class="font-semibold text-green-600">{{ $hadir }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Izin</span>
                            <span class="font-semibold text-yellow-600">{{ $izin }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Sakit</span>
                            <span class="font-semibold text-red-600">{{ $sakit }}</span>
                        </div>
                    </div>
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $persentase }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">{{ $persentase }}% Kehadiran</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Aksi Cepat</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <button class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg transition-colors text-left">
                            <i class="fas fa-chart-bar mr-2"></i>Laporan Kehadiran
                        </button>
                        <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors text-left">
                            <i class="fas fa-users mr-2"></i>Kelola Data Guru
                        </button>
                        <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-2 px-4 rounded-lg transition-colors text-left">
                            <i class="fas fa-file-alt mr-2"></i>Laporan Bulanan
                        </button>
                        <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg transition-colors text-left">
                            <i class="fas fa-cog mr-2"></i>Pengaturan Sistem
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="mt-8 bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4" id="recentActivitiesList">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-center space-x-3 activity-item" data-activity-time="{{ $activity->activity_time->toISOString() }}">
                            <div class="w-2 h-2 rounded-full activity-dot
                                @if($activity->activity_type == 'login') bg-green-500
                                @elseif($activity->activity_type == 'logout') bg-red-500
                                @elseif($activity->activity_type == 'create_materi') bg-blue-500
                                @elseif($activity->activity_type == 'create_kuis') bg-yellow-500
                                @elseif($activity->activity_type == 'create_rangkuman') bg-purple-500
                                @else bg-gray-500
                                @endif
                            "></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">{{ $activity->guru->user->name }}</span>
                                    {{ $activity->description }}
                                </p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <p class="text-xs text-gray-500 activity-relative-time">
                                        {{ $activity->activity_time->diffForHumans() }}
                                    </p>
                                    <span class="text-xs text-gray-400">•</span>
                                    <p class="text-xs text-gray-500 activity-absolute-time">
                                        @php
                                            $timezone = $activity->metadata['timezone'] ?? 'Asia/Jakarta';
                                            $timezoneAbbr = $activity->metadata['timezone_abbr'] ?? 'WIB';
                                            $formattedTime = $activity->activity_time->setTimezone($timezone)->format('d M Y, H:i') . ' ' . $timezoneAbbr;
                                        @endphp
                                        {{ $formattedTime }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-4xl mb-2">📊</div>
                            <p class="text-gray-500">Tidak ada aktivitas terbaru</p>
                            <p class="text-sm text-gray-400">Aktivitas guru akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
/* Activity Items Styling */
.activity-item {
    transition: all 0.3s ease;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid transparent;
}

.activity-item:hover {
    background-color: #f8fafc;
    border-color: #e2e8f0;
    transform: translateX(4px);
}

.activity-dot {
    transition: all 0.3s ease;
}

.activity-item:hover .activity-dot {
    transform: scale(1.2);
}

.activity-relative-time {
    font-weight: 500;
    color: #6b7280;
}

.activity-absolute-time {
    font-weight: 400;
    color: #9ca3af;
}

/* Notification Bell in Gray Area */
.bg-gray-100 {
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.bg-gray-100:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Notification Bell Styling */
.fa-bell {
    animation: bellRing 2s infinite;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    transition: all 0.3s ease;
}

@keyframes bellRing {
    0%, 50%, 100% {
        transform: rotate(0deg);
    }
    10%, 30% {
        transform: rotate(-10deg);
    }
    20%, 40% {
        transform: rotate(10deg);
    }
}

/* Notification Badge Styling - Always Visible */
.notification-badge {
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    border: 2px solid white;
    min-width: 24px;
    min-height: 24px;
    display: flex !important;
}

/* Animation only when there are notifications */
.notification-badge.animate-bounce {
    animation: bounce 1s infinite;
}

.notification-badge.animate-pulse {
    animation: pulse 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-3px);
    }
    60% {
        transform: translateY(-1px);
    }
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
    }
}

/* Hover effect for notification bell */
.relative:hover .fa-bell {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}

.relative:hover .notification-badge {
    transform: scale(1.2);
    transition: transform 0.2s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .activity-item {
        padding: 8px;
    }
    
    .activity-item .flex {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .notification-badge {
        height: 20px;
        width: 20px;
        font-size: 10px;
    }
}
</style>

<script>
// Auto-update relative time for activities
function updateActivityTimes() {
    const activityItems = document.querySelectorAll('.activity-item');
    
    activityItems.forEach(item => {
        const activityTime = new Date(item.dataset.activityTime);
        const relativeTimeElement = item.querySelector('.activity-relative-time');
        
        if (relativeTimeElement) {
            const now = new Date();
            const diffInSeconds = Math.floor((now - activityTime) / 1000);
            
            let relativeTime;
            if (diffInSeconds < 60) {
                relativeTime = `${diffInSeconds} detik yang lalu`;
            } else if (diffInSeconds < 3600) {
                const minutes = Math.floor(diffInSeconds / 60);
                relativeTime = `${minutes} menit yang lalu`;
            } else if (diffInSeconds < 86400) {
                const hours = Math.floor(diffInSeconds / 3600);
                relativeTime = `${hours} jam yang lalu`;
            } else {
                const days = Math.floor(diffInSeconds / 86400);
                relativeTime = `${days} hari yang lalu`;
            }
            
            relativeTimeElement.textContent = relativeTime;
        }
    });
}

// Update activity times every 30 seconds
setInterval(updateActivityTimes, 30000);

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateActivityTimes();
    updateNotificationBadge();
    
    // Add click functionality to notification bell
    const notificationBell = document.querySelector('.bg-gray-100');
    if (notificationBell) {
        notificationBell.addEventListener('click', function() {
            // Show notification panel or redirect to notifications
            window.location.href = '/kepala-sekolah/notifications';
        });
    }
});

// Update notification badge
function updateNotificationBadge() {
    fetch('/kepala-sekolah/api/notifications')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationCount');
            const bell = document.querySelector('.fa-bell');
            
            if (badge) {
                // Update badge number
                badge.textContent = data.length;
                
                if (data.length > 0) {
                    // Add animation when there are notifications
                    badge.classList.add('animate-bounce');
                    bell.classList.add('animate-pulse');
                } else {
                    // Remove animation when no notifications
                    badge.classList.remove('animate-bounce');
                    bell.classList.remove('animate-pulse');
                }
            }
        })
        .catch(error => {
            console.error('Error updating notification badge:', error);
        });
}

// Update notification badge every 30 seconds
setInterval(updateNotificationBadge, 30000);
</script>
