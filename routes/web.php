<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\RangkumanController;
use App\Http\Controllers\EvaluasiGuruController;
use App\Http\Controllers\GuruMataPelajaranController;
use App\Http\Controllers\MateriPembelajaranController;
use App\Http\Controllers\KegiatanKesiswaanController;

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

// Storage route untuk serve file (mengatasi masalah symlink di Windows)
Route::get('/storage/{path}', function ($path) {
    $path = urldecode($path);
    
    // Cek apakah file ada di storage
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        $filePath = storage_path('app/public/' . $path);
        
        if (file_exists($filePath)) {
            $file = \Illuminate\Support\Facades\Storage::disk('public')->get($path);
            $type = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($path);
            
            return response($file, 200, [
                'Content-Type' => $type,
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                'Cache-Control' => 'public, max-age=3600',
            ]);
        }
    }
    
    abort(404);
})->where('path', '.*');

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

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// API Routes for Auto-fill
Route::get('/api/users-by-role', [AuthController::class, 'getUsersByRole'])->name('api.users-by-role');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Guru Routes
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
        Route::get('/profil', [GuruController::class, 'profil'])->name('profil'); // Backward compatibility
        Route::get('/jadwal', [GuruController::class, 'jadwalIndex'])->name('jadwal.index');
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [GuruController::class, 'profileIndex'])->name('index');
            Route::get('/edit', [GuruController::class, 'profileEdit'])->name('edit');
            Route::put('/', [GuruController::class, 'updateProfil'])->name('update');
        });
        Route::put('/profil', [GuruController::class, 'updateProfil'])->name('profil.update'); // Backward compatibility
        
        // Jadwal Mengajar Routes
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [GuruController::class, 'jadwalIndex'])->name('index');
        });
        
        // Materi Routes
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/', [MateriController::class, 'index'])->name('index');
            Route::get('/create', [MateriController::class, 'create'])->name('create');
            Route::post('/', [MateriController::class, 'store'])->name('store');
            Route::post('/youtube', [GuruController::class, 'storeMateri'])->name('youtube.store');
            Route::post('/{materi}/toggle-pertemuan', [MateriController::class, 'togglePertemuan'])->name('toggle-pertemuan');
            Route::post('/{materi}/update-pertemuan', [MateriController::class, 'updatePertemuan'])->name('update-pertemuan');
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
        
        // Materi Pembelajaran Routes
        Route::prefix('materi-pembelajaran')->name('materi-pembelajaran.')->group(function () {
            Route::get('/edit', [MateriPembelajaranController::class, 'edit'])->name('edit');
            Route::put('/', [MateriPembelajaranController::class, 'update'])->name('update');
        });
        
        // RPP Routes
        Route::prefix('rpp')->name('rpp.')->group(function () {
            Route::get('/create', [App\Http\Controllers\RppController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\RppController::class, 'store'])->name('store');
            Route::get('/{id}', [App\Http\Controllers\RppController::class, 'show'])->name('show');
            Route::get('/{id}/cetak', [App\Http\Controllers\RppController::class, 'cetak'])->name('cetak');
            Route::get('/{id}/edit', [App\Http\Controllers\RppController::class, 'edit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\RppController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\RppController::class, 'destroy'])->name('destroy');
        });
        
        // Evaluasi Guru Routes
        Route::prefix('evaluasi')->name('evaluasi.')->group(function () {
            Route::get('/', [EvaluasiGuruController::class, 'index'])->name('index');
            
            // Rubrik Penilaian
            Route::prefix('rubrik')->name('rubrik.')->group(function () {
                Route::get('/', [EvaluasiGuruController::class, 'rubrikIndex'])->name('index');
                Route::get('/create', [EvaluasiGuruController::class, 'rubrikCreate'])->name('create');
                Route::post('/', [EvaluasiGuruController::class, 'rubrikStore'])->name('store');
                Route::get('/{id}', [EvaluasiGuruController::class, 'rubrikShow'])->name('show');
                Route::get('/{id}/edit', [EvaluasiGuruController::class, 'rubrikEdit'])->name('edit');
                Route::put('/{id}', [EvaluasiGuruController::class, 'rubrikUpdate'])->name('update');
                Route::delete('/{id}', [EvaluasiGuruController::class, 'rubrikDestroy'])->name('destroy');
            });
            
            // Lembar Penilaian
            Route::prefix('lembar')->name('lembar.')->group(function () {
                Route::get('/', [EvaluasiGuruController::class, 'lembarIndex'])->name('index');
                Route::get('/create', [EvaluasiGuruController::class, 'lembarCreate'])->name('create');
                Route::post('/', [EvaluasiGuruController::class, 'lembarStore'])->name('store');
                Route::get('/{id}', [EvaluasiGuruController::class, 'lembarShow'])->name('show');
                Route::get('/{id}/edit', [EvaluasiGuruController::class, 'lembarEdit'])->name('edit');
                Route::put('/{id}', [EvaluasiGuruController::class, 'lembarUpdate'])->name('update');
                Route::delete('/{id}', [EvaluasiGuruController::class, 'lembarDestroy'])->name('destroy');
            });
            
            // AJAX endpoint untuk mengambil siswa berdasarkan kelas
            Route::get('/get-siswa-by-kelas', [EvaluasiGuruController::class, 'getSiswaByKelas'])->name('get-siswa-by-kelas');
            
            // Nilai Formatif & Sumatif
            Route::prefix('nilai')->name('nilai.')->group(function () {
                Route::get('/', [EvaluasiGuruController::class, 'nilaiIndex'])->name('index');
                Route::get('/create', [EvaluasiGuruController::class, 'nilaiCreate'])->name('create');
                Route::post('/', [EvaluasiGuruController::class, 'nilaiStore'])->name('store');
                Route::get('/{id}', [EvaluasiGuruController::class, 'nilaiShow'])->name('show');
                Route::get('/{id}/edit', [EvaluasiGuruController::class, 'nilaiEdit'])->name('edit');
                Route::put('/{id}', [EvaluasiGuruController::class, 'nilaiUpdate'])->name('update');
                Route::delete('/{id}', [EvaluasiGuruController::class, 'nilaiDestroy'])->name('destroy');
            });
            
            // Rekap Hasil Belajar
            Route::prefix('rekap')->name('rekap.')->group(function () {
                Route::get('/', [EvaluasiGuruController::class, 'rekapIndex'])->name('index');
                Route::post('/generate', [EvaluasiGuruController::class, 'rekapGenerate'])->name('generate');
                Route::get('/{id}', [EvaluasiGuruController::class, 'rekapShow'])->name('show');
            });
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
        
        // Presensi Siswa Routes
        Route::prefix('presensi-siswa')->name('presensi-siswa.')->group(function () {
            Route::get('/', [App\Http\Controllers\Guru\PresensiSiswaController::class, 'index'])->name('index');
            Route::get('/statistik', [App\Http\Controllers\Guru\PresensiSiswaController::class, 'statistik'])->name('statistik');
            Route::post('/', [App\Http\Controllers\Guru\PresensiSiswaController::class, 'store'])->name('store');
            Route::put('/{id}', [App\Http\Controllers\Guru\PresensiSiswaController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Guru\PresensiSiswaController::class, 'destroy'])->name('destroy');
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
        Route::get('/siswa', [App\Http\Controllers\KepalaSekolahController::class, 'siswaIndex'])->name('siswa.index');
        Route::get('/laporan', [App\Http\Controllers\KepalaSekolahController::class, 'laporan'])->name('laporan');
        
        // Profile Routes
        Route::get('/profile', [App\Http\Controllers\KepalaSekolahController::class, 'profileIndex'])->name('profile.index');
        Route::get('/profile/edit', [App\Http\Controllers\KepalaSekolahController::class, 'profileEdit'])->name('profile.edit');
        Route::put('/profile/update', [App\Http\Controllers\KepalaSekolahController::class, 'profileUpdate'])->name('profile.update');
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
            Route::post('/', [App\Http\Controllers\TuController::class, 'siswaStore'])->name('store');
            Route::put('/{id}', [App\Http\Controllers\TuController::class, 'siswaUpdate'])->name('update');
            Route::patch('/{id}', [App\Http\Controllers\TuController::class, 'siswaUpdate']);
            Route::delete('/{id}', [App\Http\Controllers\TuController::class, 'siswaDestroy'])->name('destroy');
            Route::get('/{id}/edit', [App\Http\Controllers\TuController::class, 'siswaEdit'])->name('edit');
            Route::get('/template/download', [App\Http\Controllers\TuController::class, 'downloadTemplate'])->name('template');
            Route::post('/import', [App\Http\Controllers\TuController::class, 'importExcel'])->name('import');
            Route::post('/import-paste', [App\Http\Controllers\TuController::class, 'importPaste'])->name('import-paste');
        });
        
        // Data Alumni Management
        Route::prefix('alumni')->name('alumni.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'alumniIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'alumniCreate'])->name('create');
            Route::post('/', [App\Http\Controllers\TuController::class, 'alumniStore'])->name('store');
            Route::get('/{id}/edit', [App\Http\Controllers\TuController::class, 'alumniEdit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\TuController::class, 'alumniUpdate'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\TuController::class, 'alumniDestroy'])->name('destroy');
        });
        
        // Presensi Management
        Route::prefix('presensi')->name('presensi.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'presensiIndex'])->name('index');
            Route::post('/{id}/verify', [App\Http\Controllers\TuController::class, 'presensiVerify'])->name('verify');
        });
        
        // Presensi Siswa Management
        Route::prefix('presensi-siswa')->name('presensi-siswa.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'presensiSiswaIndex'])->name('index');
            Route::get('/rekap', [App\Http\Controllers\TuController::class, 'presensiSiswaRekap'])->name('rekap');
            Route::get('/export', [App\Http\Controllers\TuController::class, 'presensiSiswaExport'])->name('export');
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
            Route::get('/{id}/edit', [App\Http\Controllers\TuController::class, 'jadwalEdit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\TuController::class, 'jadwalUpdate'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\TuController::class, 'jadwalDestroy'])->name('destroy');
            Route::get('/api/mata-pelajaran/{guruId}', [App\Http\Controllers\TuController::class, 'getMataPelajaranByGuru'])->name('api.mata-pelajaran');
            
            // Import/Export routes
            Route::get('/template/download', [App\Http\Controllers\TuController::class, 'jadwalDownloadTemplate'])->name('template');
            Route::post('/import', [App\Http\Controllers\JadwalImportController::class, 'import'])->name('import');
            Route::get('/export', [App\Http\Controllers\TuController::class, 'jadwalExport'])->name('export');
        });
        
        // Kalender Management
        Route::prefix('kalender')->name('kalender.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'kalenderIndex'])->name('index');
            Route::get('/list', [App\Http\Controllers\TuController::class, 'kalenderList'])->name('list');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'kalenderCreate'])->name('create');
            Route::post('/store', [App\Http\Controllers\TuController::class, 'kalenderStore'])->name('store');
            // Route download foto HARUS sebelum route /{id} untuk menghindari konflik
            Route::get('/{id}/foto/download', [App\Http\Controllers\TuController::class, 'kalenderFotoDownload'])->name('foto.download');
            Route::get('/{id}/edit', [App\Http\Controllers\TuController::class, 'kalenderEdit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\TuController::class, 'kalenderUpdate'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\TuController::class, 'kalenderDestroy'])->name('destroy');
            Route::get('/{id}', [App\Http\Controllers\TuController::class, 'kalenderShow'])->name('show');
        });
        
        // Arsip Management
        Route::prefix('arsip')->name('arsip.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'arsipIndex'])->name('index');
            Route::get('/upload', [App\Http\Controllers\TuController::class, 'arsipCreate'])->name('create');
            Route::post('/upload', [App\Http\Controllers\TuController::class, 'arsipUpload'])->name('upload');
            Route::get('/{id}/view', [App\Http\Controllers\TuController::class, 'arsipView'])->name('view');
            Route::get('/{id}/download', [App\Http\Controllers\TuController::class, 'arsipDownload'])->name('download');
            Route::get('/{id}/edit', [App\Http\Controllers\TuController::class, 'arsipEdit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\TuController::class, 'arsipUpdate'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\TuController::class, 'arsipDestroy'])->name('destroy');
        });
        
        // Surat Management
        Route::prefix('surat')->name('surat.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'suratIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'suratCreate'])->name('create');
            Route::post('/send', [App\Http\Controllers\TuController::class, 'suratSend'])->name('send');
            Route::get('/{id}/show', [App\Http\Controllers\TuController::class, 'suratShow'])->name('show');
            Route::get('/{id}/lampiran/view', [App\Http\Controllers\TuController::class, 'suratViewLampiran'])->name('lampiran.view');
            Route::get('/{id}/lampiran/download', [App\Http\Controllers\TuController::class, 'suratDownloadLampiran'])->name('lampiran.download');
            Route::get('/{id}/edit', [App\Http\Controllers\TuController::class, 'suratEdit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\TuController::class, 'suratUpdate'])->name('update');
        });
        
        
        // Pengumuman Management
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'pengumumanIndex'])->name('index');
            Route::get('/create', [App\Http\Controllers\TuController::class, 'pengumumanCreate'])->name('create');
            Route::post('/send', [App\Http\Controllers\TuController::class, 'pengumumanSend'])->name('send');
        });
        
        // Profile Management
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [App\Http\Controllers\TuController::class, 'profileIndex'])->name('index');
            Route::get('/edit', [App\Http\Controllers\TuController::class, 'profileEdit'])->name('edit');
            Route::put('/update', [App\Http\Controllers\TuController::class, 'profileUpdate'])->name('update');
        });
        
        // Kegiatan Kesiswaan Routes
        Route::prefix('kegiatan-kesiswaan')->name('kegiatan-kesiswaan.')->group(function () {
            Route::get('/', [KegiatanKesiswaanController::class, 'index'])->name('index');
            
            // Rencana Routes
            Route::prefix('rencana')->name('rencana.')->group(function () {
                Route::get('/', [KegiatanKesiswaanController::class, 'rencana'])->name('index');
                Route::get('/create', [KegiatanKesiswaanController::class, 'rencanaCreate'])->name('create');
                Route::post('/', [KegiatanKesiswaanController::class, 'rencanaStore'])->name('store');
                Route::get('/{id}', [KegiatanKesiswaanController::class, 'rencanaShow'])->name('show');
                Route::get('/{id}/edit', [KegiatanKesiswaanController::class, 'rencanaEdit'])->name('edit');
                Route::put('/{id}', [KegiatanKesiswaanController::class, 'rencanaUpdate'])->name('update');
                Route::delete('/{id}', [KegiatanKesiswaanController::class, 'rencanaDestroy'])->name('destroy');
            });
            
            // Monitoring Routes
            Route::prefix('monitoring')->name('monitoring.')->group(function () {
                Route::get('/', [KegiatanKesiswaanController::class, 'monitoring'])->name('index');
                Route::put('/{id}/status', [KegiatanKesiswaanController::class, 'monitoringUpdateStatus'])->name('update-status');
            });
            
            // Laporan Routes
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [KegiatanKesiswaanController::class, 'laporan'])->name('index');
                Route::get('/{id}', [KegiatanKesiswaanController::class, 'laporanShow'])->name('show');
                Route::put('/{id}', [KegiatanKesiswaanController::class, 'laporanUpdate'])->name('update');
            });
        });
        
    });
});
