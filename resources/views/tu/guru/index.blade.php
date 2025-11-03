@extends('layouts.tu')

@section('title', 'Data Guru - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <div class="profile-circle">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h6 class="text-white mt-2 mb-1">Tenaga Usaha</h6>
                    <small class="text-white-50">Administrasi</small>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tu.guru.index') }}">
                            <i class="fas fa-chalkboard-teacher"></i> Data Guru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.siswa.index') }}">
                            <i class="fas fa-users"></i> Data Siswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.presensi.index') }}">
                            <i class="fas fa-calendar-check"></i> Presensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.jadwal.index') }}">
                            <i class="fas fa-calendar"></i> Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.kalender.index') }}">
                            <i class="fas fa-calendar-alt"></i> Kalender
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.arsip.index') }}">
                            <i class="fas fa-archive"></i> Arsip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.surat.index') }}">
                            <i class="fas fa-envelope"></i> Surat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.laporan.index') }}">
                            <i class="fas fa-chart-bar"></i> Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.pengumuman.index') }}">
                            <i class="fas fa-bullhorn"></i> Pengumuman
                        </a>
                    </li>
                </ul>
                
                <div class="mt-auto">
                    <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm w-100">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data Guru</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Guru
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Mata Pelajaran</label>
                                    <select class="form-select">
                                        <option value="">Semua Mata Pelajaran</option>
                                        <option value="matematika">Matematika</option>
                                        <option value="bahasa_indonesia">Bahasa Indonesia</option>
                                        <option value="bahasa_inggris">Bahasa Inggris</option>
                                        <option value="ipa">IPA</option>
                                        <option value="ips">IPS</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak_aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cari Guru</label>
                                    <input type="text" class="form-control" placeholder="Nama atau NIP">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button class="btn btn-primary d-block w-100">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guru List -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chalkboard-teacher"></i> Daftar Guru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama Guru</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No. HP</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $guruList = [
                                                ['no' => 1, 'nip' => 'GRU002', 'nama' => 'Nurhadi, S.Pd', 'mata_pelajaran' => 'Matematika', 'jenis_kelamin' => 'Laki-laki', 'phone' => '081234567891', 'status' => 'aktif'],
                                                ['no' => 2, 'nip' => 'GRU003', 'nama' => 'Keysha', 'mata_pelajaran' => 'Bahasa Inggris', 'jenis_kelamin' => 'Perempuan', 'phone' => '081234567892', 'status' => 'aktif'],
                                                ['no' => 3, 'nip' => 'GRU004', 'nama' => 'Fadli', 'mata_pelajaran' => 'Bahasa Arab', 'jenis_kelamin' => 'Laki-laki', 'phone' => '081234567893', 'status' => 'aktif'],
                                                ['no' => 4, 'nip' => 'GRU005', 'nama' => 'Siti Mundari, S.Ag', 'mata_pelajaran' => 'IPA, Prakarya, Basa Sunda', 'jenis_kelamin' => 'Perempuan', 'phone' => '081234567894', 'status' => 'aktif'],
                                                ['no' => 5, 'nip' => 'GRU006', 'nama' => 'Lola Nurlaela, S.Pd.I.', 'mata_pelajaran' => 'SKI, Akidah Akhlak', 'jenis_kelamin' => 'Perempuan', 'phone' => '081234567895', 'status' => 'aktif'],
                                                ['no' => 6, 'nip' => 'GRU007', 'nama' => 'Desy Nurfalah', 'mata_pelajaran' => 'Bahasa Indonesia', 'jenis_kelamin' => 'Perempuan', 'phone' => '081234567896', 'status' => 'aktif'],
                                                ['no' => 7, 'nip' => 'GRU008', 'nama' => 'M. Rizmal Maulana', 'mata_pelajaran' => 'Fiqih, Al-Qur\'an Hadist', 'jenis_kelamin' => 'Laki-laki', 'phone' => '081234567897', 'status' => 'aktif'],
                                                ['no' => 8, 'nip' => 'GRU009', 'nama' => 'Hamzah Nazmudin', 'mata_pelajaran' => 'Penjaskes, IPS', 'jenis_kelamin' => 'Laki-laki', 'phone' => '081234567898', 'status' => 'aktif'],
                                                ['no' => 9, 'nip' => 'GRU010', 'nama' => 'Sopyan', 'mata_pelajaran' => 'PKN', 'jenis_kelamin' => 'Laki-laki', 'phone' => '081234567899', 'status' => 'aktif'],
                                                ['no' => 10, 'nip' => 'GRU011', 'nama' => 'Syifa Restu Rahayu', 'mata_pelajaran' => 'Seni Budaya', 'jenis_kelamin' => 'Perempuan', 'phone' => '081234567900', 'status' => 'aktif'],
                                                ['no' => 11, 'nip' => 'GRU012', 'nama' => 'Weny', 'mata_pelajaran' => 'Tahsin', 'jenis_kelamin' => 'Perempuan', 'phone' => '081234567901', 'status' => 'aktif'],
                                                ['no' => 12, 'nip' => 'GRU013', 'nama' => 'Tintin Martini', 'mata_pelajaran' => 'BTQ, Tahsin', 'jenis_kelamin' => 'Perempuan', 'phone' => '081234567902', 'status' => 'aktif'],
                                            ];
                                        @endphp
                                        @foreach($guruList as $guru)
                                        <tr>
                                            <td>{{ $guru['no'] }}</td>
                                            <td>{{ $guru['nip'] }}</td>
                                            <td>{{ $guru['nama'] }}</td>
                                            <td>{{ $guru['mata_pelajaran'] }}</td>
                                            <td>{{ $guru['jenis_kelamin'] }}</td>
                                            <td>{{ $guru['phone'] }}</td>
                                            <td>
                                                @if($guru['status'] === 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-warning">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary me-1" onclick="editGuru('{{ $guru['nip'] }}', '{{ $guru['nama'] }}')">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="hapusGuru('{{ $guru['nip'] }}', '{{ $guru['nama'] }}')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pagination-custom">
                                <div class="text-muted small">
                                    Menampilkan 1 sampai 12 dari 12 guru
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-outline-secondary btn-sm me-2" disabled>
                                        <i class="fas fa-chevron-left me-1"></i> Previous
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" disabled>
                                        Next <i class="fas fa-chevron-right ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@section('scripts')
<style>
.pagination-custom .btn {
    min-width: 100px;
}
</style>
<script>
function editGuru(nip, nama) {
    if (confirm('Edit data guru ' + nama + ' (NIP: ' + nip + ')?')) {
        // Implementation for editing guru
        alert('Fitur edit guru untuk ' + nama + ' akan dibuka');
    }
}

function hapusGuru(nip, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus data guru ' + nama + ' (NIP: ' + nip + ')?\n\nData yang dihapus tidak dapat dikembalikan!')) {
        // Implementation for deleting guru
        alert('Data guru ' + nama + ' berhasil dihapus');
        location.reload();
    }
}
</script>
@endsection
