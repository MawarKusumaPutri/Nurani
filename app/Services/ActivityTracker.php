<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\GuruActivity;
use App\Models\Notification;
use App\Models\User;
use App\Helpers\TimezoneHelper;
use Illuminate\Http\Request;

class ActivityTracker
{
    public static function trackLogin(Guru $guru, Request $request)
    {
        // Get timezone based on IP address
        $timezone = TimezoneHelper::getTimezoneFromIP($request->ip());
        $loginTime = now()->setTimezone($timezone);
        
        // Track activity
        GuruActivity::create([
            'guru_id' => $guru->id,
            'activity_type' => 'login',
            'description' => 'Guru login ke sistem',
            'metadata' => [
                'login_time' => $loginTime,
                'timezone' => $timezone,
                'timezone_abbr' => TimezoneHelper::getTimezoneAbbreviation($timezone),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'location' => TimezoneHelper::getLocationFromIP($request->ip())
            ],
            'activity_time' => $loginTime,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Send notification to kepala sekolah
        $kepalaSekolah = User::where('role', 'kepala_sekolah')->first();
        if ($kepalaSekolah) {
            $timezoneAbbr = TimezoneHelper::getTimezoneAbbreviation($timezone);
            $formattedTime = $loginTime->format('d M Y, H:i') . ' ' . $timezoneAbbr;
            
            Notification::create([
                'user_id' => $kepalaSekolah->id,
                'type' => 'guru_login',
                'title' => 'Guru Login',
                'message' => $guru->user->name . ' baru saja login ke sistem pada ' . $formattedTime,
                'data' => [
                    'guru_id' => $guru->id,
                    'guru_name' => $guru->user->name,
                    'login_time' => $loginTime,
                    'timezone' => $timezone,
                    'timezone_abbr' => $timezoneAbbr,
                    'formatted_time' => $formattedTime,
                    'mata_pelajaran' => $guru->mata_pelajaran
                ]
            ]);
        }
    }

    public static function trackLogout(Guru $guru, Request $request)
    {
        // Get timezone based on IP address
        $timezone = self::getTimezoneFromIP($request->ip());
        $logoutTime = now()->setTimezone($timezone);
        
        // Track activity
        GuruActivity::create([
            'guru_id' => $guru->id,
            'activity_type' => 'logout',
            'description' => 'Guru logout dari sistem',
            'metadata' => [
                'logout_time' => $logoutTime,
                'timezone' => $timezone,
                'timezone_abbr' => TimezoneHelper::getTimezoneAbbreviation($timezone),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'location' => TimezoneHelper::getLocationFromIP($request->ip())
            ],
            'activity_time' => $logoutTime,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Send notification to kepala sekolah
        $kepalaSekolah = User::where('role', 'kepala_sekolah')->first();
        if ($kepalaSekolah) {
            $timezoneAbbr = TimezoneHelper::getTimezoneAbbreviation($timezone);
            $formattedTime = $logoutTime->format('d M Y, H:i') . ' ' . $timezoneAbbr;
            
            Notification::create([
                'user_id' => $kepalaSekolah->id,
                'type' => 'guru_logout',
                'title' => 'Guru Logout',
                'message' => $guru->user->name . ' baru saja logout dari sistem pada ' . $formattedTime,
                'data' => [
                    'guru_id' => $guru->id,
                    'guru_name' => $guru->user->name,
                    'logout_time' => $logoutTime,
                    'timezone' => $timezone,
                    'timezone_abbr' => $timezoneAbbr,
                    'formatted_time' => $formattedTime,
                    'mata_pelajaran' => $guru->mata_pelajaran
                ]
            ]);
        }
    }

    public static function trackActivity(Guru $guru, string $activityType, string $description, array $metadata = [])
    {
        // Track activity
        GuruActivity::create([
            'guru_id' => $guru->id,
            'activity_type' => $activityType,
            'description' => $description,
            'metadata' => $metadata,
            'activity_time' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Send notification to kepala sekolah for important activities
        if (in_array($activityType, ['create_materi', 'create_kuis', 'create_rangkuman'])) {
            $kepalaSekolah = User::where('role', 'kepala_sekolah')->first();
            if ($kepalaSekolah) {
                $activityTitles = [
                    'create_materi' => 'Materi Baru',
                    'create_kuis' => 'Kuis Baru',
                    'create_rangkuman' => 'Rangkuman Baru'
                ];

                Notification::create([
                    'user_id' => $kepalaSekolah->id,
                    'type' => 'guru_' . $activityType,
                    'title' => $activityTitles[$activityType] ?? 'Aktivitas Guru',
                    'message' => $guru->user->name . ' ' . $description,
                    'data' => [
                        'guru_id' => $guru->id,
                        'guru_name' => $guru->user->name,
                        'activity_time' => now(),
                        'mata_pelajaran' => $guru->mata_pelajaran,
                        'metadata' => $metadata
                    ]
                ]);
            }
        }
    }

    public static function getOnlineGurus()
    {
        // Get gurus who logged in within last 30 minutes
        $onlineGurus = Guru::whereHas('activities', function($query) {
            $query->where('activity_type', 'login')
                  ->where('activity_time', '>=', now()->subMinutes(30));
        })->with(['user', 'activities' => function($query) {
            $query->where('activity_type', 'login')
                  ->orderBy('activity_time', 'desc')
                  ->limit(1);
        }])->get();

        return $onlineGurus;
    }

    public static function getOfflineGurus()
    {
        // Get gurus who haven't logged in within last 30 minutes
        $offlineGurus = Guru::whereDoesntHave('activities', function($query) {
            $query->where('activity_type', 'login')
                  ->where('activity_time', '>=', now()->subMinutes(30));
        })->with('user')->get();

        return $offlineGurus;
    }

}
