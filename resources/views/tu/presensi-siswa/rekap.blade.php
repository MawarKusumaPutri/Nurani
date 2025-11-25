@extends('layouts.tu')

@section('title', 'Rekap Presensi Siswa - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-chart-bar me-2"></i>
                    Rekap Presensi Siswa
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.presensi-siswa.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <a href="{{ route('tu.presensi-siswa.export') }}?kelas={{ $selectedKelas }}&bulan={{ $selectedBulan }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download me-2"></i> Export
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i> Filter Rekap
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('tu.presensi-siswa.rekap') }}" id="filterRekapForm" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Kelas</label>
                            <select name="kelas" class="form-select" id="kelasFilter" onchange="document.getElementById('filterRekapForm').submit();">
                                <option value="">Semua Kelas</option>
                                <option value="7" {{ $selectedKelas == '7' || $selectedKelas === 7 ? 'selected' : '' }}>Kelas 7</option>
                                <option value="8" {{ $selectedKelas == '8' || $selectedKelas === 8 ? 'selected' : '' }}>Kelas 8</option>
                                <option value="9" {{ $selectedKelas == '9' || $selectedKelas === 9 ? 'selected' : '' }}>Kelas 9</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bulan</label>
                            <input type="month" name="bulan" class="form-control" value="{{ $selectedBulan }}" onchange="document.getElementById('filterRekapForm').submit();">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Siswa (Opsional)</label>
                            <select name="siswa_id" class="form-select" onchange="document.getElementById('filterRekapForm').submit();">
                                <option value="">Semua Siswa</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}" {{ $selectedSiswa == $siswa->id || $selectedSiswa === $siswa->id ? 'selected' : '' }}>
                                        {{ $siswa->nama }} ({{ $siswa->nis }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i> Tampilkan Rekap
                            </button>
                            <a href="{{ route('tu.presensi-siswa.rekap') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i> Reset
                            </a>
                            @if($selectedKelas || $selectedBulan || $selectedSiswa)
                            <div class="mt-2">
                                @if($selectedKelas)
                                    <span class="badge bg-info me-2">Kelas: {{ $selectedKelas }}</span>
                                @endif
                                @if($selectedBulan)
                                    <span class="badge bg-info me-2">Bulan: {{ Carbon\Carbon::parse($selectedBulan . '-01')->format('F Y') }}</span>
                                @endif
                                @if($selectedSiswa)
                                    @php
                                        $siswaSelected = $siswas->firstWhere('id', $selectedSiswa);
                                    @endphp
                                    @if($siswaSelected)
                                        <span class="badge bg-info me-2">Siswa: {{ $siswaSelected->nama }}</span>
                                    @endif
                                @endif
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Rekap Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Rekap Presensi - {{ $bulan->format('F Y') }}
                        @if($selectedKelas)
                            - Kelas {{ $selectedKelas }}
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if($rekapBySiswa->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th rowspan="2" class="align-middle">No</th>
                                        <th rowspan="2" class="align-middle">NIS</th>
                                        <th rowspan="2" class="align-middle">Nama Siswa</th>
                                        <th rowspan="2" class="align-middle">Kelas</th>
                                        <th colspan="4" class="text-center">Status Presensi</th>
                                        <th rowspan="2" class="align-middle">Total</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center bg-success text-white">Hadir</th>
                                        <th class="text-center bg-warning text-white">Sakit</th>
                                        <th class="text-center bg-info text-white">Izin</th>
                                        <th class="text-center bg-danger text-white">Alfa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekapBySiswa as $index => $rekap)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $rekap['siswa']->nis }}</td>
                                            <td><strong>{{ $rekap['siswa']->nama }}</strong></td>
                                            <td>Kelas {{ $rekap['siswa']->kelas }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ $rekap['hadir'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning">{{ $rekap['sakit'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $rekap['izin'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-danger">{{ $rekap['alfa'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <strong>{{ $rekap['total'] }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">Total:</th>
                                        <th class="text-center">{{ $rekapBySiswa->sum('hadir') }}</th>
                                        <th class="text-center">{{ $rekapBySiswa->sum('sakit') }}</th>
                                        <th class="text-center">{{ $rekapBySiswa->sum('izin') }}</th>
                                        <th class="text-center">{{ $rekapBySiswa->sum('alfa') }}</th>
                                        <th class="text-center">{{ $rekapBySiswa->sum('total') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada data presensi untuk periode yang dipilih.
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

