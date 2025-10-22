@extends('layouts.app')

@section('title', 'Dashboard TU - TMS NURANI')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50">
    <!-- Header Dashboard -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Tenaga Usaha</h1>
                    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-500">NIP: {{ Auth::user()->nip }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        Tenaga Usaha
                    </span>
                    
                    <!-- Notification Bell -->
                    <div class="relative bg-gray-100 rounded-full p-3 hover:bg-gray-200 transition-colors cursor-pointer">
                        <div class="relative">
                            <i class="fas fa-bell text-red-500 text-xl"></i>
                            <span class="notification-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold shadow-lg">
                                3
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
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Izin Menunggu</p>
                        <p class="text-2xl font-bold text-gray-900">5</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-file-alt text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Dokumen Arsip</p>
                        <p class="text-2xl font-bold text-gray-900">24</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Data Management -->
            <div class="lg:col-span-3 bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Pengelolaan Data</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Data Guru -->
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-chalkboard-teacher text-blue-600 text-xl mr-3"></i>
                                <h4 class="text-lg font-semibold text-gray-900">Data Guru</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Kelola data guru, mata pelajaran, dan informasi personal</p>
                            <div class="space-y-2">
                                <a href="{{ route('tu.guru.index') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors text-center">
                                    <i class="fas fa-list mr-2"></i>Lihat Data Guru
                                </a>
                                <a href="{{ route('tu.guru.create') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors text-center">
                                    <i class="fas fa-plus mr-2"></i>Tambah Guru
                                </a>
                            </div>
                        </div>

                        <!-- Data Siswa -->
                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-graduate text-green-600 text-xl mr-3"></i>
                                <h4 class="text-lg font-semibold text-gray-900">Data Siswa</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Kelola data siswa, kelas, dan informasi akademik</p>
                            <div class="space-y-2">
                                <a href="{{ route('tu.siswa.index') }}" class="block w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg transition-colors text-center">
                                    <i class="fas fa-list mr-2"></i>Lihat Data Siswa
                                </a>
                                <a href="{{ route('tu.siswa.create') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors text-center">
                                    <i class="fas fa-plus mr-2"></i>Tambah Siswa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <!-- Presensi & Izin -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Presensi & Izin</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('tu.presensi.index') }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-check-circle mr-2"></i>Verifikasi Presensi
                        </a>
                        <a href="{{ route('tu.izin.index') }}" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-user-clock mr-2"></i>Kelola Izin
                        </a>
                        <a href="{{ route('tu.sakit.index') }}" class="w-full bg-red-500 hover:bg-red-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-heartbeat mr-2"></i>Data Sakit
                        </a>
                    </div>
                </div>

                <!-- Jadwal & Kalender -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Jadwal & Kalender</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('tu.jadwal.index') }}" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-calendar-alt mr-2"></i>Jadwal Pelajaran
                        </a>
                        <a href="{{ route('tu.kalender.index') }}" class="w-full bg-purple-500 hover:bg-purple-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-calendar mr-2"></i>Kalender Sekolah
                        </a>
                    </div>
                </div>

                <!-- Arsip & Dokumen -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Arsip & Dokumen</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('tu.arsip.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-archive mr-2"></i>Arsip Dokumen
                        </a>
                        <a href="{{ route('tu.surat.index') }}" class="w-full bg-teal-500 hover:bg-teal-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-file-signature mr-2"></i>Surat & SK
                        </a>
                    </div>
                </div>

                <!-- Laporan & Pengumuman -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Laporan & Pengumuman</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('tu.laporan.index') }}" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-chart-bar mr-2"></i>Buat Laporan
                        </a>
                        <a href="{{ route('tu.pengumuman.index') }}" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-3 px-4 rounded-lg transition-colors text-left inline-block">
                            <i class="fas fa-bullhorn mr-2"></i>Pengumuman
                        </a>
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
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Data guru baru ditambahkan</p>
                            <p class="text-sm text-gray-500">2 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Izin guru disetujui</p>
                            <p class="text-sm text-gray-500">1 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Laporan bulanan dikirim ke kepala sekolah</p>
                            <p class="text-sm text-gray-500">3 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection