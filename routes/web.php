<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\RangkumanController;
use App\Http\Controllers\GuruMataPelajaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-modal', [AuthController::class, 'login'])->name('login.modal');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Guru Routes
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
        Route::get('/profil', [GuruController::class, 'profil'])->name('profil');
        Route::put('/profil', [GuruController::class, 'updateProfil'])->name('profil.update');
        
        // Materi Routes
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/', [MateriController::class, 'index'])->name('index');
            Route::get('/create', [MateriController::class, 'create'])->name('create');
            Route::post('/', [MateriController::class, 'store'])->name('store');
            Route::post('/youtube', [GuruController::class, 'storeMateri'])->name('youtube.store');
            Route::get('/{materi}', [MateriController::class, 'show'])->name('show');
            Route::get('/{materi}/edit', [MateriController::class, 'edit'])->name('edit');
            Route::put('/{materi}', [MateriController::class, 'update'])->name('update');
            Route::delete('/{materi}', [MateriController::class, 'destroy'])->name('destroy');
            Route::get('/search', [MateriController::class, 'search'])->name('search');
        });
        
        // Kuis Routes
        Route::prefix('kuis')->name('kuis.')->group(function () {
            Route::get('/', [KuisController::class, 'index'])->name('index');
            Route::get('/create', [KuisController::class, 'create'])->name('create');
            Route::post('/', [KuisController::class, 'store'])->name('store');
            Route::get('/{kuis}', [KuisController::class, 'show'])->name('show');
            Route::get('/{kuis}/edit', [KuisController::class, 'edit'])->name('edit');
            Route::put('/{kuis}', [KuisController::class, 'update'])->name('update');
            Route::delete('/{kuis}', [KuisController::class, 'destroy'])->name('destroy');
        });
        
        // Rangkuman Routes
        Route::prefix('rangkuman')->name('rangkuman.')->group(function () {
            Route::get('/', [RangkumanController::class, 'index'])->name('index');
            Route::get('/create', [RangkumanController::class, 'create'])->name('create');
            Route::post('/', [RangkumanController::class, 'store'])->name('store');
            Route::get('/{rangkuman}', [RangkumanController::class, 'show'])->name('show');
            Route::get('/{rangkuman}/edit', [RangkumanController::class, 'edit'])->name('edit');
            Route::put('/{rangkuman}', [RangkumanController::class, 'update'])->name('update');
            Route::delete('/{rangkuman}', [RangkumanController::class, 'destroy'])->name('destroy');
        });
        
        // Mata Pelajaran Routes
        Route::prefix('mata-pelajaran')->name('mata_pelajaran.')->group(function () {
            Route::get('/available', [GuruMataPelajaranController::class, 'getAvailableSubjects'])->name('available');
            Route::post('/select', [GuruMataPelajaranController::class, 'setSelectedSubject'])->name('select');
            Route::get('/current', [GuruMataPelajaranController::class, 'getCurrentSubject'])->name('current');
        });
        
        // Presensi Routes
        Route::prefix('presensi')->name('presensi.')->group(function () {
            Route::get('/', [App\Http\Controllers\PresensiController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\PresensiController::class, 'store'])->name('store');
        });
    });
    
    
    // Kepala Sekolah Routes
    Route::prefix('kepala-sekolah')->name('kepala_sekolah.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\KepalaSekolahController::class, 'dashboard'])->name('dashboard');
        Route::get('/notifications', [App\Http\Controllers\KepalaSekolahController::class, 'notifications'])->name('notifications');
        Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\KepalaSekolahController::class, 'markNotificationAsRead'])->name('notifications.mark_read');
        Route::delete('/notifications/{id}/delete', [App\Http\Controllers\KepalaSekolahController::class, 'deleteNotification'])->name('notifications.delete');
        Route::post('/notifications/read-all', [App\Http\Controllers\KepalaSekolahController::class, 'markAllNotificationsAsRead'])->name('notifications.read_all');
        Route::get('/guru', [App\Http\Controllers\KepalaSekolahController::class, 'guru'])->name('guru');
        Route::get('/guru/{guru}/activity', [App\Http\Controllers\KepalaSekolahController::class, 'guruActivity'])->name('guru.activity');
        Route::get('/guru-activity', [App\Http\Controllers\KepalaSekolahController::class, 'guruActivity'])->name('guru_activity');
        Route::get('/laporan', [App\Http\Controllers\KepalaSekolahController::class, 'laporan'])->name('laporan');
            Route::get('/api/notifications', [App\Http\Controllers\KepalaSekolahController::class, 'getNotifications'])->name('api.notifications');
            Route::get('/api/online-status', [App\Http\Controllers\KepalaSekolahController::class, 'getOnlineStatus'])->name('online_status');
            Route::get('/api/today-stats', [App\Http\Controllers\KepalaSekolahController::class, 'getTodayStats'])->name('api.today_stats');
            Route::get('/api/weekly-activity', [App\Http\Controllers\KepalaSekolahController::class, 'getWeeklyActivity'])->name('api.weekly_activity');
            Route::get('/api/weekly-table', [App\Http\Controllers\KepalaSekolahController::class, 'getWeeklyTable'])->name('api.weekly_table');
            Route::get('/api/activity-distribution', [App\Http\Controllers\KepalaSekolahController::class, 'getActivityDistribution'])->name('api.activity_distribution');
            Route::get('/api/status-distribution', [App\Http\Controllers\KepalaSekolahController::class, 'getStatusDistribution'])->name('api.status_distribution');
    });

    // TU Routes
    Route::prefix('tu')->name('tu.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\TuController::class, 'dashboard'])->name('dashboard');
        
        // Data Guru Management
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'guruIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'guruCreate'])->name('create');
            Route::post('/', [App\Http\Controllers\TuController::class, 'guruStore'])->name('store');
            Route::get('/{id}/edit', [App\Http\Controllers\TuController::class, 'guruEdit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\TuController::class, 'guruUpdate'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\TuController::class, 'guruDestroy'])->name('destroy');
        });
        
        // Data Siswa Management
        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'siswaIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'siswaCreate'])->name('create');
        });
        
        // Presensi Management
        Route::prefix('presensi')->name('presensi.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'presensiIndex'])->name('index');
            Route::post('/{id}/verify', [App\Http\Controllers\TuController::class, 'presensiVerify'])->name('verify');
        });
        
        // Izin Management
        Route::prefix('izin')->name('izin.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'izinIndex'])->name('index');
            Route::post('/{id}/approve', [App\Http\Controllers\TuController::class, 'izinApprove'])->name('approve');
            Route::post('/{id}/reject', [App\Http\Controllers\TuController::class, 'izinReject'])->name('reject');
        });
        
        // Sakit Management
        Route::prefix('sakit')->name('sakit.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'sakitIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'sakitCreate'])->name('create');
            Route::post('/store', [App\Http\Controllers\TuController::class, 'sakitStore'])->name('store');
        });
        
        // Jadwal Management
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'jadwalIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'jadwalCreate'])->name('create');
            Route::post('/store', [App\Http\Controllers\TuController::class, 'jadwalStore'])->name('store');
        });
        
        // Kalender Management
        Route::prefix('kalender')->name('kalender.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'kalenderIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'kalenderCreate'])->name('create');
            Route::post('/store', [App\Http\Controllers\TuController::class, 'kalenderStore'])->name('store');
        });
        
        // Arsip Management
        Route::prefix('arsip')->name('arsip.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'arsipIndex'])->name('index');
            Route::post('/upload', [App\Http\Controllers\TuController::class, 'arsipUpload'])->name('upload');
        });
        
        // Surat Management
        Route::prefix('surat')->name('surat.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'suratIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'suratCreate'])->name('create');
            Route::post('/send', [App\Http\Controllers\TuController::class, 'suratSend'])->name('send');
        });
        
        // Laporan Management
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'laporanIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'laporanCreate'])->name('create');
            Route::post('/send', [App\Http\Controllers\TuController::class, 'laporanSend'])->name('send');
        });
        
        // Pengumuman Management
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'pengumumanIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'pengumumanCreate'])->name('create');
            Route::post('/send', [App\Http\Controllers\TuController::class, 'pengumumanSend'])->name('send');
        });
    });
});