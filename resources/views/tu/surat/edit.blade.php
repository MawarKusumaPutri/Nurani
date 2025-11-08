@extends('layouts.tu')

@section('title', 'Edit Surat - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Surat</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.surat.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
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

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
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

            <!-- Form Surat -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit"></i> Form Edit Surat Menyurat
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tu.surat.update', $surat->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jenis_surat" name="jenis_surat" required>
                                                <option value="">Pilih Jenis Surat</option>
                                                <option value="surat_keputusan" {{ old('jenis_surat', $surat->jenis_surat) == 'surat_keputusan' ? 'selected' : '' }}>Surat Keputusan</option>
                                                <option value="surat_edaran" {{ old('jenis_surat', $surat->jenis_surat) == 'surat_edaran' ? 'selected' : '' }}>Surat Edaran</option>
                                                <option value="surat_undangan" {{ old('jenis_surat', $surat->jenis_surat) == 'surat_undangan' ? 'selected' : '' }}>Surat Undangan</option>
                                                <option value="surat_tugas" {{ old('jenis_surat', $surat->jenis_surat) == 'surat_tugas' ? 'selected' : '' }}>Surat Tugas</option>
                                                <option value="surat_izin" {{ old('jenis_surat', $surat->jenis_surat) == 'surat_izin' ? 'selected' : '' }}>Surat Izin</option>
                                                <option value="surat_pengumuman" {{ old('jenis_surat', $surat->jenis_surat) == 'surat_pengumuman' ? 'selected' : '' }}>Surat Pengumuman</option>
                                                <option value="surat_permohonan" {{ old('jenis_surat', $surat->jenis_surat) == 'surat_permohonan' ? 'selected' : '' }}>Surat Permohonan</option>
                                                <option value="surat_balasan" {{ old('jenis_surat', $surat->jenis_surat) == 'surat_balasan' ? 'selected' : '' }}>Surat Balasan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" placeholder="Contoh: 001/SK/MTs-NA/2024" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat->format('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioritas" class="form-label">Prioritas</label>
                                            <select class="form-select" id="prioritas" name="prioritas">
                                                <option value="biasa" {{ old('prioritas', $surat->prioritas) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                                <option value="penting" {{ old('prioritas', $surat->prioritas) == 'penting' ? 'selected' : '' }}>Penting</option>
                                                <option value="sangat_penting" {{ old('prioritas', $surat->prioritas) == 'sangat_penting' ? 'selected' : '' }}>Sangat Penting</option>
                                                <option value="segera" {{ old('prioritas', $surat->prioritas) == 'segera' ? 'selected' : '' }}>Segera</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="perihal" class="form-label">Perihal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="perihal" name="perihal" placeholder="Masukkan perihal surat" value="{{ old('perihal', $surat->perihal) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="penerima" class="form-label">Kepada <span class="text-danger">*</span></label>
                                    <select class="form-select" id="penerima" name="penerima" required>
                                        <option value="">Pilih Penerima</option>
                                        <option value="kepala_sekolah" {{ old('penerima', $surat->penerima) == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                        <option value="guru" {{ old('penerima', $surat->penerima) == 'guru' ? 'selected' : '' }}>Semua Guru</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="isi_surat" class="form-label">Isi Surat <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="isi_surat" name="isi_surat" rows="8" placeholder="Tuliskan isi surat di sini..." required>{{ old('isi_surat', $surat->isi_surat) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pembuat_surat" class="form-label">Pembuat Surat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pembuat_surat" name="pembuat_surat" value="{{ old('pembuat_surat', $surat->pembuat_surat) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jabatan_pembuat" class="form-label">Jabatan Pembuat</label>
                                            <input type="text" class="form-control" id="jabatan_pembuat" name="jabatan_pembuat" value="{{ old('jabatan_pembuat', $surat->jabatan_pembuat) }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
                                    @if($surat->lampiran)
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-file"></i> File saat ini: 
                                                <a href="{{ asset('storage/surat/' . $surat->lampiran) }}" target="_blank">
                                                    {{ $surat->lampiran }}
                                                </a>
                                            </small>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" id="lampiran" name="lampiran" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <div class="form-text">Format yang didukung: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)
                                        @if($surat->lampiran)
                                            <br><small class="text-info">Kosongkan jika tidak ingin mengganti file.</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="hidden" name="arsipkan" value="0">
                                                <input class="form-check-input" type="checkbox" id="arsipkan" name="arsipkan" value="1" {{ old('arsipkan', $surat->arsipkan) ? 'checked' : '' }}>
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
                                        <i class="fas fa-save"></i> Simpan
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
