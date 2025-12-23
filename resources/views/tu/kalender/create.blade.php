@extends('layouts.tu')

@section('title', 'Tambah Event - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

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
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

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
                                                <option value="akademik" {{ (isset($kategori) && $kategori == 'akademik') ? 'selected' : '' }}>Akademik</option>
                                                <option value="ujian" {{ (isset($kategori) && $kategori == 'ujian') ? 'selected' : '' }}>Ujian</option>
                                                <option value="libur" {{ (isset($kategori) && $kategori == 'libur') ? 'selected' : '' }}>Libur</option>
                                                <option value="rapat" {{ (isset($kategori) && $kategori == 'rapat') ? 'selected' : '' }}>Rapat</option>
                                                <option value="pelatihan" {{ (isset($kategori) && $kategori == 'pelatihan') ? 'selected' : '' }}>Pelatihan</option>
                                                <option value="kegiatan" {{ (isset($kategori) && $kategori == 'kegiatan') ? 'selected' : '' }}>Kegiatan</option>
                                                <option value="pengumuman" {{ (isset($kategori) && $kategori == 'pengumuman') ? 'selected' : '' }}>Pengumuman</option>
                                                <option value="lainnya" {{ (isset($kategori) && $kategori == 'lainnya') ? 'selected' : '' }}>Lainnya</option>
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
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="penanggung_jawab" 
                                                name="penanggung_jawab" 
                                                list="penanggung_jawab_list"
                                                value="{{ Auth::user()->name }}"
                                                placeholder="Pilih atau ketik nama penanggung jawab"
                                            >
                                            <datalist id="penanggung_jawab_list">
                                                @foreach($users as $user)
                                                    <option value="{{ $user->name }}">
                                                        @if($user->role == 'guru')
                                                            (Guru)
                                                        @elseif($user->role == 'kepala_sekolah')
                                                            (Kepala Sekolah)
                                                        @elseif($user->role == 'tu')
                                                            (Tenaga Usaha)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </datalist>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle"></i> Pilih siapa yang bertanggung jawab atau ketik nama sendiri
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="warna" class="form-label">
                                                Warna Event 
                                                <span class="text-muted small">(Untuk membedakan kategori event di kalender)</span>
                                            </label>
                                            <input type="hidden" id="warna" name="warna" value="#6c757d">
                                            <div class="form-control" id="warna-display" style="background-color: #6c757d; color: white; text-align: center; padding: 8px; border-radius: 4px; cursor: not-allowed;">
                                                <i class="fas fa-palette"></i> Warna akan otomatis disesuaikan dengan kategori event
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle"></i> Warna event akan otomatis disesuaikan berdasarkan kategori yang Anda pilih untuk memudahkan identifikasi di kalender.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="hidden" name="is_all_day" value="0">
                                                <input class="form-check-input" type="checkbox" id="is_all_day" name="is_all_day" value="1">
                                                <label class="form-check-label" for="is_all_day">
                                                    Event Sepanjang Hari
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="hidden" name="is_public" value="0">
                                                <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" checked>
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
                                                <input type="hidden" name="is_important" value="0">
                                                <input class="form-check-input" type="checkbox" id="is_important" name="is_important" value="1">
                                                <label class="form-check-label" for="is_important">
                                                    Event Penting
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="hidden" name="is_recurring" value="0">
                                                <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring" value="1">
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
                                        <i class="fas fa-save"></i> Simpan
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
    
    // Color mapping berdasarkan kategori
    const colorMap = {
        'akademik': { color: '#007bff', name: 'Biru' },
        'ujian': { color: '#dc3545', name: 'Merah' },
        'libur': { color: '#ffc107', name: 'Kuning' },
        'rapat': { color: '#17a2b8', name: 'Cyan' },
        'pelatihan': { color: '#9c27b0', name: 'Ungu' },
        'kegiatan': { color: '#fd7e14', name: 'Orange' },
        'pengumuman': { color: '#D2B48C', name: 'Cokelat Muda' },
        'lainnya': { color: '#6c757d', name: 'Abu-abu' }
    };
    
    // Auto-set warna berdasarkan kategori
    const kategoriSelect = document.getElementById('kategori_event');
    const warnaInput = document.getElementById('warna');
    const warnaDisplay = document.getElementById('warna-display');
    const colorPreview = document.getElementById('color-preview');
    const judulInput = document.getElementById('judul_event');
    
    function updateWarnaByKategori() {
        const kategori = kategoriSelect.value;
        if (kategori && colorMap[kategori]) {
            const warnaData = colorMap[kategori];
            warnaInput.value = warnaData.color;
            warnaDisplay.style.backgroundColor = warnaData.color;
            warnaDisplay.innerHTML = `<i class="fas fa-palette"></i> ${warnaData.name} (${kategoriSelect.options[kategoriSelect.selectedIndex].text})`;
            colorPreview.style.backgroundColor = warnaData.color;
        } else {
            // Default jika belum pilih kategori
            warnaInput.value = '#6c757d';
            warnaDisplay.style.backgroundColor = '#6c757d';
            warnaDisplay.innerHTML = '<i class="fas fa-palette"></i> Pilih kategori event untuk melihat warna';
            colorPreview.style.backgroundColor = '#6c757d';
        }
    }
    
    kategoriSelect.addEventListener('change', function() {
        updateWarnaByKategori();
        
        // Auto-generate judul placeholder
        if (!judulInput.value) {
            const kategoriText = this.options[this.selectedIndex].text;
            judulInput.placeholder = `Masukkan judul ${kategoriText.toLowerCase()}`;
        }
    });
    
    // Initialize warna on page load
    updateWarnaByKategori();
    
    // Jika ada kategori dari parameter URL, trigger change event untuk update warna
    @if(isset($kategori) && $kategori)
        if (kategoriSelect.value === '{{ $kategori }}') {
            updateWarnaByKategori();
        }
    @endif
});
</script>
@endsection
