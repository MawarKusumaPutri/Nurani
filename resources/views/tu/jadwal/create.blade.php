@extends('layouts.tu')

@section('title', 'Tambah Jadwal - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Jadwal Pelajaran</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.jadwal.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Jadwal Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-plus"></i> Form Jadwal Pelajaran
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.jadwal.store') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                            <select class="form-select" id="mata_pelajaran" name="mata_pelajaran" required>
                                                <option value="">Pilih Mata Pelajaran</option>
                                                @foreach($mataPelajaranList as $mataPelajaran)
                                                    <option value="{{ $mataPelajaran }}">{{ $mataPelajaran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="guru" class="form-label">Guru Pengajar <span class="text-danger">*</span></label>
                                            <select class="form-select" id="guru" name="guru" required>
                                                <option value="">Pilih Guru</option>
                                                @foreach($gurus as $guru)
                                                    <option value="{{ $guru->id }}">{{ $guru->user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kelas" name="kelas" required>
                                                <option value="">Pilih Kelas</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Info Kelas</label>
                                            <div class="alert alert-info mb-0 py-2">
                                                <small>
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Pilih kelas yang sesuai dengan jadwal pelajaran
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                                            <select class="form-select" id="hari" name="hari" required>
                                                <option value="">Pilih Hari</option>
                                                <option value="senin">Senin</option>
                                                <option value="selasa">Selasa</option>
                                                <option value="rabu">Rabu</option>
                                                <option value="kamis">Kamis</option>
                                                <option value="jumat">Jumat</option>
                                                <option value="sabtu">Sabtu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jam_mulai" name="jam_mulai" required>
                                                <option value="">Pilih Jam Mulai</option>
                                                <option value="07:00">07:00</option>
                                                <option value="07:45">07:45</option>
                                                <option value="08:30">08:30</option>
                                                <option value="09:15">09:15</option>
                                                <option value="10:00">10:00</option>
                                                <option value="10:45">10:45</option>
                                                <option value="11:30">11:30</option>
                                                <option value="12:15">12:15</option>
                                                <option value="13:00">13:00</option>
                                                <option value="13:45">13:45</option>
                                                <option value="14:30">14:30</option>
                                                <option value="15:15">15:15</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jam_selesai" name="jam_selesai" required>
                                                <option value="">Pilih Jam Selesai</option>
                                                <option value="07:45">07:45</option>
                                                <option value="08:30">08:30</option>
                                                <option value="09:15">09:15</option>
                                                <option value="10:00">10:00</option>
                                                <option value="10:45">10:45</option>
                                                <option value="11:30">11:30</option>
                                                <option value="12:15">12:15</option>
                                                <option value="13:00">13:00</option>
                                                <option value="13:45">13:45</option>
                                                <option value="14:30">14:30</option>
                                                <option value="15:15">15:15</option>
                                                <option value="16:00">16:00</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                            <select class="form-select" id="semester" name="semester" required>
                                                <option value="">Pilih Semester</option>
                                                <option value="1">Semester 1</option>
                                                <option value="2">Semester 2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                                            <select class="form-select" id="tahun_ajaran" name="tahun_ajaran" required>
                                                <option value="">Pilih Tahun Ajaran</option>
                                                <option value="2024/2025" selected>2024/2025</option>
                                                <option value="2025/2026">2025/2026</option>
                                                <option value="2026/2027">2026/2027</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status Jadwal</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="aktif" selected>Aktif</option>
                                                <option value="nonaktif">Nonaktif</option>
                                                <option value="sementara">Sementara</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan khusus untuk jadwal ini"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_berulang" name="is_berulang">
                                                <label class="form-check-label" for="is_berulang">
                                                    Jadwal Berulang (Setiap Minggu)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_lab" name="is_lab">
                                                <label class="form-check-label" for="is_lab">
                                                    Menggunakan Laboratorium
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('tu.jadwal.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-calendar-plus"></i> Tambah Jadwal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Guidelines -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Panduan Jadwal
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6>Mata Pelajaran:</h6>
                            <ul class="list-unstyled small">
                                <li><i class="fas fa-calculator text-primary"></i> Matematika</li>
                                <li><i class="fas fa-book text-success"></i> Bahasa Indonesia</li>
                                <li><i class="fas fa-globe text-info"></i> Bahasa Inggris</li>
                                <li><i class="fas fa-flask text-warning"></i> IPA</li>
                                <li><i class="fas fa-chart-line text-danger"></i> IPS</li>
                                <li><i class="fas fa-mosque text-secondary"></i> Pendidikan Agama</li>
                            </ul>
                            
                            <h6 class="mt-3">Jam Pelajaran:</h6>
                            <ul class="small text-muted">
                                <li>1 jam = 45 menit</li>
                                <li>Istirahat: 10 menit</li>
                                <li>Jam masuk: 07:00</li>
                                <li>Jam pulang: 16:00</li>
                            </ul>
                            
                            <h6 class="mt-3">Tips Jadwal:</h6>
                            <ul class="small text-muted">
                                <li>Pastikan tidak ada konflik waktu</li>
                                <li>Gunakan lab untuk praktikum</li>
                                <li>Set jadwal berulang jika perlu</li>
                                <li>Pilih guru yang sesuai dengan mata pelajaran</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Jadwal Preview -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-eye"></i> Preview Jadwal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="jadwal-preview" class="p-3 border rounded bg-light">
                                <div class="text-center text-muted">
                                    <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                    <p class="mb-0">Preview jadwal akan muncul setelah Anda mengisi form</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Schedules -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history"></i> Jadwal Terbaru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Daftar jadwal terbaru akan muncul di sini.
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
    // Auto-generate jam selesai based on jam mulai
    const jamMulai = document.getElementById('jam_mulai');
    const jamSelesai = document.getElementById('jam_selesai');
    
    jamMulai.addEventListener('change', function() {
        if (this.value) {
            // Parse jam mulai and add 45 minutes
            const [hours, minutes] = this.value.split(':').map(Number);
            const startTime = new Date();
            startTime.setHours(hours, minutes, 0, 0);
            
            // Add 45 minutes
            const endTime = new Date(startTime.getTime() + 45 * 60000);
            
            // Format to HH:MM
            const endTimeString = endTime.toTimeString().slice(0, 5);
            
            // Set jam selesai
            jamSelesai.value = endTimeString;
            
            // Update preview
            updatePreview();
        }
    });
    
    // Update preview when form changes
    function updatePreview() {
        const mataPelajaran = document.getElementById('mata_pelajaran').value;
        const guru = document.getElementById('guru').options[document.getElementById('guru').selectedIndex].text;
        const kelas = document.getElementById('kelas').value;
        const hari = document.getElementById('hari').value;
        const jamMulai = document.getElementById('jam_mulai').value;
        const jamSelesai = document.getElementById('jam_selesai').value;
        
        if (mataPelajaran && guru && kelas && hari && jamMulai && jamSelesai) {
            const preview = document.getElementById('jadwal-preview');
            const hariNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const hariIndex = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'].indexOf(hari);
            const hariDisplay = hariIndex >= 0 ? hariNama[hariIndex] : hari.charAt(0).toUpperCase() + hari.slice(1);
            
            preview.innerHTML = `
                <div class="text-center">
                    <h6 class="mb-2">${mataPelajaran}</h6>
                    <p class="mb-1"><strong>Guru:</strong> ${guru}</p>
                    <p class="mb-1"><strong>Kelas:</strong> ${kelas}</p>
                    <p class="mb-1"><strong>Hari:</strong> ${hariDisplay}</p>
                    <p class="mb-0"><strong>Waktu:</strong> ${jamMulai} - ${jamSelesai}</p>
                </div>
            `;
        }
    }
    
    // Add event listeners for preview updates
    ['mata_pelajaran', 'guru', 'kelas', 'hari', 'jam_mulai', 'jam_selesai'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('change', updatePreview);
        }
    });
});
</script>
@endsection
