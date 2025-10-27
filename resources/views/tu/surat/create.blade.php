@extends('layouts.tu')

@section('title', 'Buat Surat - TU Dashboard')

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
                        <a class="nav-link" href="{{ route('tu.izin.index') }}">
                            <i class="fas fa-file-alt"></i> Izin
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tu.sakit.index') }}">
                            <i class="fas fa-user-injured"></i> Sakit
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
                        <a class="nav-link active" href="{{ route('tu.surat.index') }}">
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
                <h1 class="h2">Buat Surat</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.surat.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Surat -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-envelope"></i> Form Surat Menyurat
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.surat.send') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jenis_surat" name="jenis_surat" required>
                                                <option value="">Pilih Jenis Surat</option>
                                                <option value="surat_keputusan">Surat Keputusan</option>
                                                <option value="surat_edaran">Surat Edaran</option>
                                                <option value="surat_undangan">Surat Undangan</option>
                                                <option value="surat_tugas">Surat Tugas</option>
                                                <option value="surat_izin">Surat Izin</option>
                                                <option value="surat_pengumuman">Surat Pengumuman</option>
                                                <option value="surat_permohonan">Surat Permohonan</option>
                                                <option value="surat_balasan">Surat Balasan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" placeholder="Contoh: 001/SK/MTs-NA/2024" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioritas" class="form-label">Prioritas</label>
                                            <select class="form-select" id="prioritas" name="prioritas">
                                                <option value="biasa">Biasa</option>
                                                <option value="penting">Penting</option>
                                                <option value="sangat_penting">Sangat Penting</option>
                                                <option value="segera">Segera</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="perihal" name="perihal" placeholder="Masukkan perihal surat" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="penerima" class="form-label">Kepada <span class="text-danger">*</span></label>
                                            <select class="form-select" id="penerima" name="penerima" required>
                                                <option value="">Pilih Penerima</option>
                                                <option value="kepala_sekolah">Kepala Sekolah</option>
                                                <option value="guru">Semua Guru</option>
                                                <option value="siswa">Semua Siswa</option>
                                                <option value="orang_tua">Orang Tua Siswa</option>
                                                <option value="yayasan">Yayasan</option>
                                                <option value="dinas_pendidikan">Dinas Pendidikan</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="penerima_lainnya" class="form-label">Penerima Lainnya</label>
                                            <input type="text" class="form-control" id="penerima_lainnya" name="penerima_lainnya" placeholder="Jika memilih 'Lainnya', isi di sini">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="isi_surat" class="form-label">Isi Surat <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="isi_surat" name="isi_surat" rows="8" placeholder="Tuliskan isi surat di sini..." required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pembuat_surat" class="form-label">Pembuat Surat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pembuat_surat" name="pembuat_surat" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jabatan_pembuat" class="form-label">Jabatan Pembuat</label>
                                            <input type="text" class="form-control" id="jabatan_pembuat" name="jabatan_pembuat" value="Tenaga Usaha" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
                                    <input type="file" class="form-control" id="lampiran" name="lampiran" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <div class="form-text">Format yang didukung: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="cc_email" name="cc_email">
                                                <label class="form-check-label" for="cc_email">
                                                    Kirim salinan ke email
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="arsipkan" name="arsipkan" checked>
                                                <label class="form-check-label" for="arsipkan">
                                                    Arsipkan surat
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('tu.surat.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Kirim Surat
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Surat -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-eye"></i> Preview Surat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Preview akan muncul setelah Anda mengisi form di atas.</strong>
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
    // Set default tanggal surat to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_surat').value = today;
    
    // Auto-generate nomor surat based on jenis surat
    const jenisSurat = document.getElementById('jenis_surat');
    const nomorSurat = document.getElementById('nomor_surat');
    const tanggalSurat = document.getElementById('tanggal_surat');
    
    function generateNomorSurat() {
        if (jenisSurat.value && tanggalSurat.value) {
            const tahun = new Date(tanggalSurat.value).getFullYear();
            const bulan = String(new Date(tanggalSurat.value).getMonth() + 1).padStart(2, '0');
            const jenis = jenisSurat.value.toUpperCase();
            const kodeJenis = {
                'surat_keputusan': 'SK',
                'surat_edaran': 'SE',
                'surat_undangan': 'SU',
                'surat_tugas': 'ST',
                'surat_izin': 'SI',
                'surat_pengumuman': 'SP',
                'surat_permohonan': 'SM',
                'surat_balasan': 'SB'
            };
            
            const kode = kodeJenis[jenis] || 'SR';
            const nomor = Math.floor(Math.random() * 999) + 1;
            nomorSurat.value = `${String(nomor).padStart(3, '0')}/${kode}/MTs-NA/${tahun}`;
        }
    }
    
    jenisSurat.addEventListener('change', generateNomorSurat);
    tanggalSurat.addEventListener('change', generateNomorSurat);
    
    // Show/hide penerima lainnya field
    const penerima = document.getElementById('penerima');
    const penerimaLainnya = document.getElementById('penerima_lainnya');
    const penerimaLainnyaGroup = penerimaLainnya.closest('.col-md-6');
    
    function togglePenerimaLainnya() {
        if (penerima.value === 'lainnya') {
            penerimaLainnyaGroup.style.display = 'block';
            penerimaLainnya.required = true;
        } else {
            penerimaLainnyaGroup.style.display = 'none';
            penerimaLainnya.required = false;
            penerimaLainnya.value = '';
        }
    }
    
    penerima.addEventListener('change', togglePenerimaLainnya);
    togglePenerimaLainnya(); // Initial call
});
</script>
@endsection
