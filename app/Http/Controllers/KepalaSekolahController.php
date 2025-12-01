<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;
use App\Models\Notification;
use App\Models\GuruActivity;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\Rangkuman;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\User;
use App\Helpers\PhotoHelper;
use App\Services\ActivityTracker;
use Carbon\Carbon;

class KepalaSekolahController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get all gurus
        $gurus = Guru::with(['user', 'recentActivities'])->get();
        
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
        
        // Get today's presensi (approved only)
        $todayPresensi = Presensi::with('guru.user')
            ->whereDate('tanggal', Carbon::today())
            ->where('status_verifikasi', 'approved')
            ->get();
        
        // Get presensi status for each guru and sort by presensi status (presensi first)
        $guruPresensiStatus = [];
        foreach ($gurus as $guru) {
            $todayPresensiGuru = $todayPresensi->where('guru_id', $guru->id)->first();
            $guruPresensiStatus[$guru->id] = $todayPresensiGuru ? [
                'jenis' => $todayPresensiGuru->jenis,
                'status' => ucfirst($todayPresensiGuru->jenis),
                'keterangan' => $todayPresensiGuru->keterangan,
            ] : null;
        }
        
        // Sort gurus: yang sudah presensi dulu (prioritas: sakit > izin > hadir), lalu yang belum presensi
        $gurus = $gurus->sortBy(function($guru) use ($guruPresensiStatus) {
            if (isset($guruPresensiStatus[$guru->id])) {
                $jenis = $guruPresensiStatus[$guru->id]['jenis'];
                // Prioritas: sakit = 1, izin = 2, hadir = 3
                if ($jenis === 'sakit') return 1;
                if ($jenis === 'izin') return 2;
                if ($jenis === 'hadir') return 3;
            }
            // Belum presensi = 4
            return 4;
        })->values();
        
        // Statistics
        $totalGurus = $gurus->count();
        $onlineCount = $onlineGurus->count();
        $offlineCount = $offlineGurus->count();
        $unreadNotifications = $notifications->where('is_read', false)->count();
        
        // Calculate presensi statistics for pie chart
        $presensiHadir = $todayPresensi->where('jenis', 'hadir')->count();
        $presensiSakit = $todayPresensi->where('jenis', 'sakit')->count();
        $presensiIzin = $todayPresensi->where('jenis', 'izin')->count();
        $belumPresensi = $totalGurus - ($presensiHadir + $presensiSakit + $presensiIzin);
        
        return view('kepala_sekolah.dashboard', compact(
            'user', 'gurus', 'onlineGurus', 'offlineGurus', 
            'notifications', 'recentActivities', 'totalGurus', 
            'onlineCount', 'offlineCount', 'unreadNotifications',
            'guruPresensiStatus', 'presensiHadir', 'presensiSakit', 
            'presensiIzin', 'belumPresensi'
        ));
    }
    
    public function notifications()
    {
        $user = Auth::user();
        
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Count read and unread notifications
        $totalNotifications = Notification::where('user_id', $user->id)->count();
        $readNotifications = Notification::where('user_id', $user->id)
            ->whereNotNull('read_at')
            ->count();
        $unreadNotifications = $totalNotifications - $readNotifications;
        
        return view('kepala_sekolah.notifications', compact('notifications', 'totalNotifications', 'readNotifications', 'unreadNotifications'));
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
    
    public function deleteNotification($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();
        
        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
    
    public function guru()
    {
        $gurus = Guru::with(['user', 'activities' => function($query) {
            $query->where('activity_type', 'login')
                  ->orderBy('activity_time', 'desc')
                  ->limit(1);
        }])->orderBy('created_at', 'desc')
            ->get();
        
        // Get today's presensi (approved only)
        $todayPresensi = Presensi::with('guru.user')
            ->whereDate('tanggal', Carbon::today())
            ->where('status_verifikasi', 'approved')
            ->get();
        
        // Determine online status for each guru
        $onlineGuruIds = ActivityTracker::getOnlineGurus()->pluck('id')->toArray();
        
        // Add login status and time to each guru, plus presensi status
        $gurus = $gurus->map(function($guru) use ($onlineGuruIds, $todayPresensi) {
            $isOnline = in_array($guru->id, $onlineGuruIds);
            $lastLogin = $guru->activities->first();
            
            $guru->is_online = $isOnline;
            $guru->last_login_time = $lastLogin ? $lastLogin->activity_time : null;
            $guru->last_login_metadata = $lastLogin ? $lastLogin->metadata : null;
            
            // Get today's presensi status
            $todayPresensiGuru = $todayPresensi->where('guru_id', $guru->id)->first();
            $guru->presensi_status = $todayPresensiGuru ? [
                'jenis' => $todayPresensiGuru->jenis,
                'keterangan' => $todayPresensiGuru->keterangan,
            ] : null;
            
            return $guru;
        });
        
        // Paginate manually
        $page = request()->get('page', 1);
        $perPage = 12;
        $total = $gurus->count();
        $items = $gurus->slice(($page - 1) * $perPage, $perPage)->values();
        
        $gurus = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('kepala_sekolah.guru', compact('gurus'));
    }
    
    public function laporan()
    {
        $gurus = Guru::with(['user', 'activities'])->get();
        $totalGuru = $gurus->count();
        $totalMateri = Materi::count();
        $totalKuis = Kuis::count();
        $totalRangkuman = Rangkuman::count();
        
        return view('kepala_sekolah.laporan', compact('gurus', 'totalGuru', 'totalMateri', 'totalKuis', 'totalRangkuman'));
    }
    
    public function guruActivity($guruId = null)
    {
        if ($guruId) {
            $guru = Guru::with(['user', 'activities'])->findOrFail($guruId);
            
            $activities = $guru->activities()
                ->orderBy('activity_time', 'desc')
                ->paginate(20);
            
            // Set pagination path to use route name
            $activities->setPath(route('kepala_sekolah.guru.activity', ['guru' => $guru->id]));
            
            // Get mata pelajaran list for this guru
            $mataPelajaranList = [];
            if ($guru->mata_pelajaran && $guru->mata_pelajaran !== 'Belum ditentukan') {
                $mataPelajaranList = array_map('trim', explode(', ', $guru->mata_pelajaran));
            }
            
            // Enhance activities with mata pelajaran info
            $activities->getCollection()->transform(function($activity) use ($guru, $mataPelajaranList) {
                // Get mata pelajaran from related materi/kuis/rangkuman if available
                if (in_array($activity->activity_type, ['create_materi', 'create_kuis', 'create_rangkuman'])) {
                    $mataPelajaran = null;
                    
                    // Try to get from metadata first
                    if ($activity->metadata && isset($activity->metadata['mata_pelajaran'])) {
                        $mataPelajaran = $activity->metadata['mata_pelajaran'];
                    } else {
                        // Try to get from related model based on activity time
                        $activityTime = $activity->activity_time;
                        $timeStart = $activityTime->copy()->subMinutes(5);
                        $timeEnd = $activityTime->copy()->addMinutes(5);
                        
                        if ($activity->activity_type === 'create_materi') {
                            $materi = Materi::where('guru_id', $guru->id)
                                ->whereBetween('created_at', [$timeStart, $timeEnd])
                                ->first();
                            if ($materi && isset($materi->mata_pelajaran) && $materi->mata_pelajaran) {
                                $mataPelajaran = $materi->mata_pelajaran;
                            }
                        } elseif ($activity->activity_type === 'create_kuis') {
                            $kuis = Kuis::where('guru_id', $guru->id)
                                ->whereBetween('created_at', [$timeStart, $timeEnd])
                                ->first();
                            if ($kuis && $kuis->mata_pelajaran) {
                                $mataPelajaran = $kuis->mata_pelajaran;
                            }
                        } elseif ($activity->activity_type === 'create_rangkuman') {
                            $rangkuman = Rangkuman::where('guru_id', $guru->id)
                                ->whereBetween('created_at', [$timeStart, $timeEnd])
                                ->first();
                            if ($rangkuman && $rangkuman->mata_pelajaran) {
                                $mataPelajaran = $rangkuman->mata_pelajaran;
                            }
                        }
                        
                        // If still not found, distribute across mata pelajaran based on time
                        if (!$mataPelajaran && !empty($mataPelajaranList)) {
                            $activityIndex = $guru->activities()
                                ->where('activity_time', '<=', $activity->activity_time)
                                ->whereIn('activity_type', ['create_materi', 'create_kuis', 'create_rangkuman'])
                                ->count();
                            $mataPelajaran = $mataPelajaranList[$activityIndex % count($mataPelajaranList)];
                        }
                    }
                    
                    $activity->mata_pelajaran_mengajar = $mataPelajaran;
                }
                
                return $activity;
            });
            
            return view('kepala_sekolah.guru_activity', compact('guru', 'activities', 'mataPelajaranList'));
        } else {
            // Show all guru activities grouped by day and guru
            $gurus = Guru::with(['user'])->get();
            
            // Get activities from Monday of this week to today (including today)
            $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY); // Monday
            $today = Carbon::now();
            
            // Always include today's activities, but limit to Friday if today is after Friday
            $endDate = min($today, $startOfWeek->copy()->addDays(4)); // Today or Friday, whichever comes first
            
            // Get all login and logout activities from Monday to today (or Friday)
            // Use whereDate to ensure we capture all activities for the day regardless of time
            $activities = GuruActivity::with(['guru.user'])
                ->whereIn('activity_type', ['login', 'logout'])
                ->whereDate('activity_time', '>=', $startOfWeek->format('Y-m-d'))
                ->whereDate('activity_time', '<=', $today->format('Y-m-d'))
                ->orderBy('activity_time', 'desc') // Latest activities first
                ->get();
            
            // Group activities by day and guru
            $activitiesByDay = [];
            $dayNames = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            $todayDayOfWeek = $today->dayOfWeek;
            
            // Process Monday to Friday
            for ($i = 0; $i < 5; $i++) {
                $dayDate = $startOfWeek->copy()->addDays($i);
                $dayName = $dayNames[$i];
                $dayStart = $dayDate->copy()->startOfDay();
                $dayEnd = $dayDate->copy()->endOfDay();
                
                $activitiesByDay[$dayName] = [];
                
                foreach ($gurus as $guru) {
                    $dayActivities = $activities->filter(function($activity) use ($guru, $dayDate) {
                        $activityTime = Carbon::parse($activity->activity_time);
                        return $activity->guru_id == $guru->id && 
                               $activityTime->format('Y-m-d') == $dayDate->format('Y-m-d');
                    });
                    
                    $loginCount = $dayActivities->where('activity_type', 'login')->count();
                    $logoutCount = $dayActivities->where('activity_type', 'logout')->count();
                    
                    if ($loginCount > 0 || $logoutCount > 0) {
                        $activitiesByDay[$dayName][$guru->id] = [
                            'guru' => $guru,
                            'login_count' => $loginCount,
                            'logout_count' => $logoutCount,
                            'date' => $dayDate->format('Y-m-d'),
                            'date_formatted' => $dayDate->format('d M Y')
                        ];
                    }
                }
            }
            
            // If today is Saturday or Sunday, also show today's activities
            if ($todayDayOfWeek >= Carbon::SATURDAY) {
                $todayName = $todayDayOfWeek == Carbon::SATURDAY ? 'Sabtu' : 'Minggu';
                $todayStart = $today->copy()->startOfDay();
                $todayEnd = $today->copy()->endOfDay();
                
                // Get today's activities (already included in $activities, but let's process them separately)
                $todayActivities = $activities->filter(function($activity) use ($today) {
                    $activityTime = Carbon::parse($activity->activity_time);
                    return $activityTime->format('Y-m-d') == $today->format('Y-m-d');
                });
                
                if ($todayActivities->count() > 0) {
                    $activitiesByDay[$todayName] = [];
                    
                    foreach ($gurus as $guru) {
                        $guruTodayActivities = $todayActivities->filter(function($activity) use ($guru) {
                            return $activity->guru_id == $guru->id;
                        });
                        
                        $loginCount = $guruTodayActivities->where('activity_type', 'login')->count();
                        $logoutCount = $guruTodayActivities->where('activity_type', 'logout')->count();
                        
                        if ($loginCount > 0 || $logoutCount > 0) {
                            $activitiesByDay[$todayName][$guru->id] = [
                                'guru' => $guru,
                                'login_count' => $loginCount,
                                'logout_count' => $logoutCount,
                                'date' => $today->format('Y-m-d'),
                                'date_formatted' => $today->format('d M Y')
                            ];
                        }
                    }
                    
                    // Add today to dayNames
                    $dayNames[] = $todayName;
                }
            }
            
            return view('kepala_sekolah.guru_activity', compact('gurus', 'activitiesByDay', 'dayNames'));
        }
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
    
    public function siswaIndex(Request $request)
    {
        // Get filter parameters
        $selectedKelas = $request->get('kelas', '');
        $selectedStatus = $request->get('status', '');
        $searchQuery = $request->get('search', '');
        
        // Base query untuk semua siswa
        $query = Siswa::query();
        
        // Apply filters
        if ($selectedKelas && $selectedKelas !== '') {
            $query->where('kelas', $selectedKelas);
        }
        
        if ($selectedStatus && $selectedStatus !== '') {
            $query->where('status', $selectedStatus);
        }
        
        if ($searchQuery && $searchQuery !== '') {
            $query->where(function($q) use ($searchQuery) {
                $q->where('nama', 'like', '%' . $searchQuery . '%')
                  ->orWhere('nis', 'like', '%' . $searchQuery . '%');
            });
        }
        
        // Get all students
        $allSiswa = $query->orderBy('kelas')->orderBy('nama')->get();
        
        // Group by class jika tidak ada filter kelas
        if (!$selectedKelas && !$searchQuery) {
            $siswaKelas7 = $allSiswa->where('kelas', '7');
            $siswaKelas8 = $allSiswa->where('kelas', '8');
            $siswaKelas9 = $allSiswa->where('kelas', '9');
        } else {
            // Jika ada filter, tampilkan semua di satu list
            $siswaKelas7 = collect();
            $siswaKelas8 = collect();
            $siswaKelas9 = collect();
            
            foreach ($allSiswa as $siswa) {
                if ($siswa->kelas == '7') {
                    $siswaKelas7->push($siswa);
                } elseif ($siswa->kelas == '8') {
                    $siswaKelas8->push($siswa);
                } elseif ($siswa->kelas == '9') {
                    $siswaKelas9->push($siswa);
                }
            }
        }
        
        return view('kepala_sekolah.siswa.index', compact(
            'siswaKelas7', 
            'siswaKelas8', 
            'siswaKelas9',
            'selectedKelas',
            'selectedStatus',
            'searchQuery'
        ));
    }
    
    // Profile Management
    public function profileIndex()
    {
        $user = Auth::user();
        return view('kepala_sekolah.profile.index', compact('user'));
    }
    
    public function profileEdit()
    {
        $user = Auth::user();
        return view('kepala_sekolah.profile.edit', compact('user'));
    }
    
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;
        $user->phone = $request->phone;
        $user->address = $request->address;
        
        // Handle photo upload - FLEKSIBEL: bisa simpan di mana saja
        if ($request->hasFile('photo')) {
            try {
                // Delete old photo if exists
                if ($user->photo) {
                    // Hapus foto lama dari berbagai kemungkinan lokasi
                    PhotoHelper::deletePhoto($user->photo);
                    // Coba hapus dengan berbagai format path lama
                    $oldFilename = basename($user->photo);
                    if ($oldFilename && $oldFilename !== $user->photo) {
                        PhotoHelper::deletePhoto('profiles/kepala_sekolah/' . $oldFilename);
                        PhotoHelper::deletePhoto('photos/' . $oldFilename);
                        PhotoHelper::deletePhoto('guru/foto/' . $oldFilename);
                    }
                }
                
                $file = $request->file('photo');
                
                // OTOMATIS SIMPAN dengan path yang benar
                // Prioritas 1: simpan di storage/app/public/profiles/kepala_sekolah/
                $photoPath = PhotoHelper::savePhoto($file, 'profiles/kepala_sekolah', true);
                
                if ($photoPath) {
                    // Path sudah benar: profiles/kepala_sekolah/[nama-file]
                    // Verifikasi file benar-benar tersimpan SEBELUM menyimpan ke database
                    $fileExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath);
                    $fullPath = storage_path('app/public/' . $photoPath);
                    $fileExistsOnDisk = file_exists($fullPath);
                    
                    \Log::info('Photo upload attempt for kepala sekolah', [
                        'user_id' => $user->id,
                        'photo_path' => $photoPath,
                        'file_exists_storage' => $fileExists,
                        'file_exists_disk' => $fileExistsOnDisk,
                        'full_path' => $fullPath,
                        'photo_url' => url('storage/' . $photoPath)
                    ]);
                    
                    // Hanya simpan ke database jika file benar-benar ada
                    if ($fileExists || $fileExistsOnDisk) {
                    $user->photo = $photoPath;
                        \Log::info('Photo path saved to database', [
                            'user_id' => $user->id,
                            'photo_path' => $photoPath
                        ]);
                    } else {
                        \Log::error('Photo file not found after upload', [
                            'user_id' => $user->id,
                            'photo_path' => $photoPath,
                            'full_path' => $fullPath,
                            'storage_disk_list' => \Illuminate\Support\Facades\Storage::disk('public')->files('profiles/kepala_sekolah')
                        ]);
                        return back()->withErrors(['photo' => 'Foto berhasil diupload tapi file tidak ditemukan. Silakan coba lagi.'])->withInput();
                    }
                } else {
                    // Fallback: simpan di public/image/profiles
                    $photoPath = PhotoHelper::savePhoto($file, 'image/profiles', false);
                    if ($photoPath) {
                        // Verifikasi file benar-benar tersimpan SEBELUM menyimpan ke database
                        $fileExists = file_exists(public_path($photoPath));
                        
                        \Log::info('Photo upload attempt to public for kepala sekolah', [
                            'user_id' => $user->id,
                            'photo_path' => $photoPath,
                            'file_exists' => $fileExists,
                            'full_path' => public_path($photoPath)
                        ]);
                        
                        // Hanya simpan ke database jika file benar-benar ada
                        if ($fileExists) {
                        $user->photo = $photoPath;
                            \Log::info('Photo path saved to database (public)', [
                                'user_id' => $user->id,
                                'photo_path' => $photoPath
                            ]);
                        } else {
                            \Log::error('Photo file not found after upload to public', [
                                'user_id' => $user->id,
                                'photo_path' => $photoPath,
                                'full_path' => public_path($photoPath)
                            ]);
                            return back()->withErrors(['photo' => 'Foto berhasil diupload tapi file tidak ditemukan. Silakan coba lagi.'])->withInput();
                        }
                    } else {
                        \Log::error('Failed to save photo for kepala sekolah', [
                            'user_id' => $user->id,
                            'original_name' => $file->getClientOriginalName()
                        ]);
                        return back()->withErrors(['photo' => 'Gagal menyimpan foto. Silakan coba lagi.'])->withInput();
                    }
                }
            } catch (\Exception $e) {
                return back()->withErrors(['photo' => 'Terjadi kesalahan saat mengupload foto: ' . $e->getMessage()])->withInput();
            }
        }
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Simpan semua perubahan ke database
        $user->save();
        
        // Verifikasi foto tersimpan dengan benar
        if ($request->hasFile('photo')) {
            $savedUser = User::find($user->id);
            \Log::info('Photo verification after save', [
                'user_id' => $savedUser->id,
                'photo_in_db' => $savedUser->photo,
                'photo_exists' => $savedUser->photo ? \Illuminate\Support\Facades\Storage::disk('public')->exists($savedUser->photo) : false
            ]);
        }
        
        // Get fresh user data from database to ensure photo is loaded
        $freshUser = User::find($user->id);
        
        // Refresh user data in session to update photo immediately
        Auth::login($freshUser);
        
        // Clear all caches to ensure fresh data
        try {
            \Artisan::call('view:clear');
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
        } catch (\Exception $e) {
            // Ignore cache errors
        }
        
        return redirect()->route('kepala_sekolah.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}