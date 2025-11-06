@extends('layouts.tu')

@section('title', 'Tambah Event - TU Dashboard')

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
                        <a class="nav-link" href="{{ route('tu.guru.index') }}">
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
                        <a class="nav-link active" href="{{ route('tu.kalender.index') }}">
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
                        <a class="nav-link" href="{{ route('tu.pengumuman.index') }}">
                            <i class="fas fa-bullhorn"></i> Pengumuman
                        </a>
                    </li>
                </ul>
                
                <div class="mt-auto">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Event Kalender</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.kalender.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Event Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-plus"></i> Form Event Kalender Akademik
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.kalender.store') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="judul_event" class="form-label">Judul Event <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="judul_event" name="judul_event" placeholder="Masukkan judul event" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kategori_event" class="form-label">Kategori Event <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kategori_event" name="kategori_event" required>
                                                <option value="">Pilih Kategori</option>
                                                <option value="akademik">Akademik</option>
                                                <option value="ujian">Ujian</option>
                                                <option value="libur">Libur</option>
                                                <option value="rapat">Rapat</option>
                                                <option value="pelatihan">Pelatihan</option>
                                                <option value="kegiatan">Kegiatan</option>
                                                <option value="pengumuman">Pengumuman</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                            <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                            <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Event</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan detail event ini"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lokasi" class="form-label">Lokasi</label>
                                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Tempat pelaksanaan event">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
                                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioritas" class="form-label">Prioritas</label>
                                            <select class="form-select" id="prioritas" name="prioritas">
                                                <option value="rendah">Rendah</option>
                                                <option value="sedang" selected>Sedang</option>
                                                <option value="tinggi">Tinggi</option>
                                                <option value="sangat_tinggi">Sangat Tinggi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="warna" class="form-label">Warna Event</label>
                                            <select class="form-select" id="warna" name="warna">
                                                <option value="#007bff">Biru</option>
                                                <option value="#28a745">Hijau</option>
                                                <option value="#ffc107">Kuning</option>
                                                <option value="#dc3545">Merah</option>
                                                <option value="#6f42c1">Ungu</option>
                                                <option value="#17a2b8">Cyan</option>
                                                <option value="#fd7e14">Orange</option>
                                                <option value="#6c757d">Abu-abu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_all_day" name="is_all_day">
                                                <label class="form-check-label" for="is_all_day">
                                                    Event Sepanjang Hari
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_public" name="is_public" checked>
                                                <label class="form-check-label" for="is_public">
                                                    Event Publik (terlihat semua user)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_important" name="is_important">
                                                <label class="form-check-label" for="is_important">
                                                    Event Penting
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring">
                                                <label class="form-check-label" for="is_recurring">
                                                    Event Berulang
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('tu.kalender.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-calendar-plus"></i> Tambah Event
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Event Guidelines -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Panduan Event
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6>Kategori Event:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-graduation-cap text-primary"></i> Akademik</li>
                                <li><i class="fas fa-clipboard-check text-success"></i> Ujian</li>
                                <li><i class="fas fa-calendar-times text-warning"></i> Libur</li>
                                <li><i class="fas fa-users text-info"></i> Rapat</li>
                                <li><i class="fas fa-chalkboard-teacher text-secondary"></i> Pelatihan</li>
                                <li><i class="fas fa-star text-danger"></i> Kegiatan</li>
                                <li><i class="fas fa-bullhorn text-dark"></i> Pengumuman</li>
                            </ul>
                            
                            <h6 class="mt-3">Tips Event:</h6>
                            <ul class="small text-muted">
                                <li>Gunakan judul yang jelas dan singkat</li>
                                <li>Pilih kategori yang sesuai</li>
                                <li>Set waktu yang tepat</li>
                                <li>Tambahkan deskripsi detail</li>
                                <li>Pilih warna yang sesuai kategori</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Color Preview -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-palette"></i> Preview Warna
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="color-preview" class="p-3 rounded" style="background-color: #007bff; color: white; text-align: center;">
                                <strong>Sample Event</strong><br>
                                <small>Preview warna event</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Events -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history"></i> Event Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Daftar event terbaru akan muncul di sini.
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default tanggal mulai to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_mulai').value = today;
    
    // Auto-set tanggal selesai sama dengan tanggal mulai
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    
    tanggalMulai.addEventListener('change', function() {
        if (!tanggalSelesai.value) {
            tanggalSelesai.value = this.value;
        }
    });
    
    // Handle all day event
    const isAllDay = document.getElementById('is_all_day');
    const waktuMulai = document.getElementById('waktu_mulai');
    const waktuSelesai = document.getElementById('waktu_selesai');
    
    function toggleTimeFields() {
        if (isAllDay.checked) {
            waktuMulai.disabled = true;
            waktuSelesai.disabled = true;
            waktuMulai.value = '';
            waktuSelesai.value = '';
        } else {
            waktuMulai.disabled = false;
            waktuSelesai.disabled = false;
        }
    }
    
    isAllDay.addEventListener('change', toggleTimeFields);
    toggleTimeFields(); // Initial call
    
    // Color preview
    const warnaSelect = document.getElementById('warna');
    const colorPreview = document.getElementById('color-preview');
    
    warnaSelect.addEventListener('change', function() {
        colorPreview.style.backgroundColor = this.value;
    });
    
    // Auto-generate judul based on kategori
    const kategoriSelect = document.getElementById('kategori_event');
    const judulInput = document.getElementById('judul_event');
    
    kategoriSelect.addEventListener('change', function() {
        if (!judulInput.value) {
            const kategoriText = this.options[this.selectedIndex].text;
            judulInput.placeholder = `Masukkan judul ${kategoriText.toLowerCase()}`;
        }
    });
});
</script>
@endsection
