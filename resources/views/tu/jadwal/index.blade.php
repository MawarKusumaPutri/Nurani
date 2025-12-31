@extends('layouts.tu')

@section('title', 'Jadwal - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Jadwal Pelajaran</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.jadwal.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah Jadwal
                        </a>
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-import"></i> Import Excel
                        </button>
                        <a href="{{ route('tu.jadwal.export') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </a>
                    </div>
                </div>
            </div>


            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Kelas</label>
                                    <select class="form-select">
                                        <option value="">Semua Kelas</option>
                                        <option value="7">Kelas 7</option>
                                        <option value="8">Kelas 8</option>
                                        <option value="9">Kelas 9</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Hari</label>
                                    <select class="form-select">
                                        <option value="">Semua Hari</option>
                                        <option value="senin">Senin</option>
                                        <option value="selasa">Selasa</option>
                                        <option value="rabu">Rabu</option>
                                        <option value="kamis">Kamis</option>
                                        <option value="jumat">Jumat</option>
                                        <option value="sabtu">Sabtu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cari Jadwal</label>
                                    <input type="text" class="form-control" placeholder="Mata pelajaran atau nama guru">
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

            <!-- Jadwal Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar"></i> Daftar Jadwal Pelajaran
                            </h5>
                                @if(isset($jadwals) && $jadwals->count() > 0)
                                <!-- Pagination Controls - Moved to Top -->
                                <div class="d-flex gap-2 align-items-center">
                                    @if($jadwals->onFirstPage())
                                        <button class="btn btn-outline-secondary btn-sm" disabled style="min-width: 100px; opacity: 0.5;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </button>
                                    @else
                                        <a href="{{ $jadwals->previousPageUrl() }}" class="btn btn-sm" style="min-width: 100px; background-color: #0d6efd; color: white; border-color: #0d6efd; font-weight: 600;">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </a>
                                    @endif
                                    
                                    <span class="text-dark small px-3 d-flex align-items-center fw-bold" style="font-size: 14px;">
                                        Halaman {{ $jadwals->currentPage() }} / {{ $jadwals->lastPage() }}
                                    </span>
                                    
                                    @if($jadwals->hasMorePages())
                                        <a href="{{ $jadwals->nextPageUrl() }}" class="btn btn-sm" style="min-width: 100px; background-color: #0d6efd; color: white; border-color: #0d6efd; font-weight: 600;">
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled style="min-width: 100px; opacity: 0.5;">
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </button>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($jadwals) && $jadwals->count() > 0)
                            <!-- Pagination Info -->
                            <div class="mb-3">
                                <div class="text-muted small">
                                    Menampilkan {{ $jadwals->firstItem() }} sampai {{ $jadwals->lastItem() }} dari {{ $jadwals->total() }} jadwal
                                </div>
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Kelas</th>
                                            <th>Hari</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($jadwals) && $jadwals->count() > 0)
                                            @php
                                                $iconMap = [
                                                    'matematika' => ['icon' => 'fa-calculator', 'color' => 'text-primary'],
                                                    'bahasa_indonesia' => ['icon' => 'fa-book', 'color' => 'text-success'],
                                                    'bahasa_inggris' => ['icon' => 'fa-globe', 'color' => 'text-info'],
                                                    'ipa' => ['icon' => 'fa-flask', 'color' => 'text-warning'],
                                                    'ips' => ['icon' => 'fa-chart-line', 'color' => 'text-danger'],
                                                    'pendidikan_agama' => ['icon' => 'fa-mosque', 'color' => 'text-secondary'],
                                                    'pendidikan_kewarganegaraan' => ['icon' => 'fa-flag', 'color' => 'text-primary'],
                                                    'pendidikan_jasmani' => ['icon' => 'fa-running', 'color' => 'text-success'],
                                                    'seni_budaya' => ['icon' => 'fa-palette', 'color' => 'text-warning'],
                                                    'teknologi_informasi' => ['icon' => 'fa-laptop', 'color' => 'text-info'],
                                                ];
                                                
                                                $kelasColorMap = [
                                                    '7' => 'bg-primary',
                                                    '8' => 'bg-warning',
                                                    '9' => 'bg-info',
                                                ];
                                                
                                                $statusColorMap = [
                                                    'aktif' => 'bg-success',
                                                    'nonaktif' => 'bg-danger',
                                                    'sementara' => 'bg-warning',
                                                ];
                                            @endphp
                                            @foreach($jadwals as $index => $jadwal)
                                                @php
                                                    $icon = $iconMap[$jadwal->mata_pelajaran]['icon'] ?? 'fa-book';
                                                    $iconColor = $iconMap[$jadwal->mata_pelajaran]['color'] ?? 'text-secondary';
                                                    $kelasColor = $kelasColorMap[substr($jadwal->kelas, 0, 1)] ?? 'bg-secondary';
                                                    $statusColor = $statusColorMap[$jadwal->status] ?? 'bg-secondary';
                                                @endphp
                                                <tr>
                                                    <td>{{ $jadwals->firstItem() + $index }}</td>
                                                    <td>
                                                        <i class="fas {{ $icon }} {{ $iconColor }}"></i> 
                                                        {{ $jadwal->mata_pelajaran_nama }}
                                                    </td>
                                                    <td>{{ $jadwal->guru->user->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge {{ $kelasColor }}">{{ $jadwal->kelas }}</span>
                                                    </td>
                                                    <td>{{ $jadwal->hari_nama }}</td>
                                                    <td>{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</td>
                                                    <td>
                                                        <span class="badge {{ $statusColor }}">{{ ucfirst($jadwal->status) }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('tu.jadwal.edit', $jadwal->id) }}" class="btn btn-sm btn-primary me-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('tu.jadwal.destroy', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                                        <p class="mb-0">Belum ada jadwal pelajaran. Silakan tambah jadwal baru.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-import me-2"></i>Import Jadwal dari Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tu.jadwal.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Panduan Import:</strong>
                        <ol class="mb-0 mt-2">
                            <li>Download template Excel terlebih dahulu</li>
                            <li>Isi data jadwal sesuai format template</li>
                            <li>Upload file Excel yang sudah diisi</li>
                        </ol>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Download Template</label>
                        <div>
                            <a href="{{ route('tu.jadwal.template') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download me-1"></i> Download Template Excel
                            </a>
                        </div>
                        <small class="text-muted">Template berisi contoh format data yang benar</small>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester">
                            <option value="all">Seluruhnya</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" 
                               value="2025/2026" placeholder="2025/2026">
                    </div>
                    
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Upload File Excel</label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" 
                               accept=".xlsx,.xls" required>
                        <small class="text-muted">Format: .xlsx atau .xls (Max: 2MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i> Import Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
