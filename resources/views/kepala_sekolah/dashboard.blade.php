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
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <div>
                            <p class="text-sm text-gray-900">Nurhadi, S.Pd melakukan presensi masuk</p>
                            <p class="text-xs text-gray-500">2 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <div>
                            <p class="text-sm text-gray-900">Keysha mengupload materi Bahasa Inggris</p>
                            <p class="text-xs text-gray-500">15 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <div>
                            <p class="text-sm text-gray-900">Siti Mundari mengajukan izin</p>
                            <p class="text-xs text-gray-500">1 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        <div>
                            <p class="text-sm text-gray-900">Laporan kehadiran bulan ini telah dibuat</p>
                            <p class="text-xs text-gray-500">2 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
