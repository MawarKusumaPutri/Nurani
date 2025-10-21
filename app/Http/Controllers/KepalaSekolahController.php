<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Notification;
use App\Models\GuruActivity;
use App\Services\ActivityTracker;

class KepalaSekolahController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get all gurus
        $gurus = Guru::with(['user', 'mataPelajaranAktif', 'recentActivities'])->get();
        
        // Get online/offline status
        $onlineGurus = ActivityTracker::getOnlineGurus();
        $offlineGurus = ActivityTracker::getOfflineGurus();
        
        // Get recent notifications
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get recent activities
        $recentActivities = GuruActivity::with(['guru.user'])
            ->orderBy('activity_time', 'desc')
            ->limit(20)
            ->get();
        
        // Statistics
        $totalGurus = $gurus->count();
        $onlineCount = $onlineGurus->count();
        $offlineCount = $offlineGurus->count();
        $unreadNotifications = $notifications->where('is_read', false)->count();
        
        return view('kepala_sekolah.dashboard', compact(
            'user', 'gurus', 'onlineGurus', 'offlineGurus', 
            'notifications', 'recentActivities', 'totalGurus', 
            'onlineCount', 'offlineCount', 'unreadNotifications'
        ));
    }
    
    public function notifications()
    {
        $user = Auth::user();
        
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('kepala_sekolah.notifications', compact('notifications'));
    }
    
    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
    
    public function markAllNotificationsAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        return response()->json(['success' => true]);
    }
    
    public function guruActivity($guruId)
    {
        $guru = Guru::with(['user', 'activities'])->findOrFail($guruId);
        
        $activities = $guru->activities()
            ->orderBy('activity_time', 'desc')
            ->paginate(20);
        
        return view('kepala_sekolah.guru_activity', compact('guru', 'activities'));
    }
    
    public function getNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return response()->json($notifications);
    }
    
    public function getOnlineStatus()
    {
        $onlineGurus = ActivityTracker::getOnlineGurus();
        $offlineGurus = ActivityTracker::getOfflineGurus();
        
        return response()->json([
            'online' => $onlineGurus->map(function($guru) {
                return [
                    'id' => $guru->id,
                    'name' => $guru->user->name,
                    'mata_pelajaran' => $guru->mata_pelajaran,
                    'last_activity' => $guru->activities->first()->activity_time ?? null
                ];
            }),
            'offline' => $offlineGurus->map(function($guru) {
                return [
                    'id' => $guru->id,
                    'name' => $guru->user->name,
                    'mata_pelajaran' => $guru->mata_pelajaran
                ];
            })
        ]);
    }

    public function getTodayStats()
    {
        $today = now()->startOfDay();
        
        // Today's logins
        $todayLogins = GuruActivity::where('activity_type', 'login')
            ->whereDate('activity_time', $today)
            ->count();
        
        // Currently active (logged in within last 30 minutes)
        $currentlyActive = GuruActivity::where('activity_type', 'login')
            ->where('activity_time', '>=', now()->subMinutes(30))
            ->distinct('guru_id')
            ->count();
        
        // Today's materials created
        $todayMaterials = GuruActivity::where('activity_type', 'create_materi')
            ->whereDate('activity_time', $today)
            ->count();
        
        // Today's quizzes created
        $todayQuizzes = GuruActivity::where('activity_type', 'create_kuis')
            ->whereDate('activity_time', $today)
            ->count();
        
        return response()->json([
            'today_logins' => $todayLogins,
            'currently_active' => $currentlyActive,
            'today_materials' => $todayMaterials,
            'today_quizzes' => $todayQuizzes
        ]);
    }

    public function getWeeklyActivity()
    {
        $weeklyData = [];
        $loginData = [];
        $materiData = [];
        $kuisData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $endDate = $date->copy()->endOfDay();
            
            $logins = GuruActivity::where('activity_type', 'login')
                ->whereBetween('activity_time', [$date, $endDate])
                ->count();
            
            $materi = GuruActivity::where('activity_type', 'create_materi')
                ->whereBetween('activity_time', [$date, $endDate])
                ->count();
            
            $kuis = GuruActivity::where('activity_type', 'create_kuis')
                ->whereBetween('activity_time', [$date, $endDate])
                ->count();
            
            $loginData[] = $logins;
            $materiData[] = $materi;
            $kuisData[] = $kuis;
        }
        
        return response()->json([
            'login_data' => $loginData,
            'materi_data' => $materiData,
            'kuis_data' => $kuisData
        ]);
    }

    public function getWeeklyTable()
    {
        $weeklyData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $startDate = $date->copy()->startOfDay();
            $endDate = $date->copy()->endOfDay();
            
            $logins = GuruActivity::where('activity_type', 'login')
                ->whereBetween('activity_time', [$startDate, $endDate])
                ->count();
            
            $materi = GuruActivity::where('activity_type', 'create_materi')
                ->whereBetween('activity_time', [$startDate, $endDate])
                ->count();
            
            $kuis = GuruActivity::where('activity_type', 'create_kuis')
                ->whereBetween('activity_time', [$startDate, $endDate])
                ->count();
            
            $rangkuman = GuruActivity::where('activity_type', 'create_rangkuman')
                ->whereBetween('activity_time', [$startDate, $endDate])
                ->count();
            
            $total = $logins + $materi + $kuis + $rangkuman;
            
            $weeklyData[] = [
                'day_name' => $date->locale('id')->dayName,
                'date' => $date->format('d M Y'),
                'logins' => $logins,
                'materi' => $materi,
                'kuis' => $kuis,
                'rangkuman' => $rangkuman,
                'total' => $total
            ];
        }
        
        return response()->json([
            'weekly_data' => $weeklyData
        ]);
    }

    public function getActivityDistribution()
    {
        $today = now()->startOfDay();
        
        $logins = GuruActivity::where('activity_type', 'login')
            ->whereDate('activity_time', $today)
            ->count();
        
        $materi = GuruActivity::where('activity_type', 'create_materi')
            ->whereDate('activity_time', $today)
            ->count();
        
        $kuis = GuruActivity::where('activity_type', 'create_kuis')
            ->whereDate('activity_time', $today)
            ->count();
        
        $rangkuman = GuruActivity::where('activity_type', 'create_rangkuman')
            ->whereDate('activity_time', $today)
            ->count();
        
        return response()->json([
            'labels' => ['Login', 'Materi', 'Kuis', 'Rangkuman'],
            'data' => [$logins, $materi, $kuis, $rangkuman]
        ]);
    }

    public function getStatusDistribution()
    {
        $onlineGurus = ActivityTracker::getOnlineGurus();
        $offlineGurus = ActivityTracker::getOfflineGurus();
        
        return response()->json([
            'labels' => ['Online', 'Offline'],
            'data' => [$onlineGurus->count(), $offlineGurus->count()]
        ]);
    }
}