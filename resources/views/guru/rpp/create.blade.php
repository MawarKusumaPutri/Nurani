@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat RPP Pertemuan {{ $pertemuanKe }} - {{ $guru->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
        }
        .section-header {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
    @include('partials.guru-fixed-layout')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.guru-sidebar')

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-file-alt me-2 text-primary"></i>
                            Buat RPP Pertemuan {{ $pertemuanKe }}
                        </h2>
                        <p class="text-muted mb-0">Buat Rencana Pelaksanaan Pembelajaran untuk {{ $mataPelajaran }}</p>
                    </div>
                    <a href="{{ route('guru.dashboard', ['mata_pelajaran' => $mataPelajaran]) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('guru.rpp.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Identitas Pembelajaran -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Identitas Pembelajaran</h5>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="judul" class="form-label fw-bold">Judul RPP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                           id="judul" name="judul" 
                                           value="{{ old('judul', 'RPP ' . $mataPelajaran . ' Pertemuan ' . $pertemuanKe) }}" 
                                           required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="sekolah" class="form-label fw-bold">Nama Sekolah</label>
                                    <input type="text" class="form-control" id="sekolah" name="sekolah" 
                                           value="Mts Nurul Aiman" readonly style="background-color: #e9ecef;">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="nama_guru" class="form-label fw-bold">Nama Guru</label>
                                    <input type="text" class="form-control" id="nama_guru" name="nama_guru" 
                                           value="{{ $guru->user->name }}" readonly style="background-color: #e9ecef;">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="mata_pelajaran" class="form-label fw-bold">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran" 
                                           value="{{ $mataPelajaran }}" readonly style="background-color: #e9ecef;">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="kelas" class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                                    <select class="form-select @error('kelas') is-invalid @enderror" id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <option value="VII" {{ old('kelas') == 'VII' ? 'selected' : '' }}>Kelas 7</option>
                                        <option value="VIII" {{ old('kelas') == 'VIII' ? 'selected' : '' }}>Kelas 8</option>
                                        <option value="IX" {{ old('kelas', 'IX') == 'IX' ? 'selected' : '' }}>Kelas 9</option>
                                    </select>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="semester" class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                                    <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                        <option value="">Pilih Semester</option>
                                        <option value="Ganjil" {{ old('semester', 'Ganjil') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="pertemuan_ke" class="form-label fw-bold">Pertemuan Ke- <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('pertemuan_ke') is-invalid @enderror" 
                                           id="pertemuan_ke" name="pertemuan_ke" 
                                           value="{{ old('pertemuan_ke', $pertemuanKe) }}" 
                                           min="1" required>
                                    @error('pertemuan_ke')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="alokasi_waktu" class="form-label fw-bold">Alokasi Waktu (menit) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('alokasi_waktu') is-invalid @enderror" 
                                           id="alokasi_waktu" name="alokasi_waktu" 
                                           value="{{ old('alokasi_waktu', 80) }}" 
                                           min="1" required>
                                    @error('alokasi_waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="tahun_pelajaran" class="form-label fw-bold">Tahun Pelajaran</label>
                                    <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" 
                                           value="{{ old('tahun_pelajaran', '2025-2026') }}" 
                                           placeholder="Contoh: 2025-2026">
                                </div>
                            </div>

                            <!-- Kompetensi Inti -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-certificate me-2"></i>Kompetensi Inti (KI)</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label for="ki_1" class="form-label fw-bold">KI-1: Sikap Spiritual</label>
                                <textarea class="form-control" id="ki_1" name="ki_1" rows="2" 
                                          placeholder="Menghargai dan menghayati ajaran agama yang dianutnya">{{ old('ki_1') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="ki_2" class="form-label fw-bold">KI-2: Sikap Sosial</label>
                                <textarea class="form-control" id="ki_2" name="ki_2" rows="2" 
                                          placeholder="Menghargai dan menghayati perilaku jujur, disiplin, tanggung jawab...">{{ old('ki_2') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="ki_3" class="form-label fw-bold">KI-3: Pengetahuan</label>
                                <textarea class="form-control" id="ki_3" name="ki_3" rows="2" 
                                          placeholder="Memahami pengetahuan (faktual, konseptual, dan prosedural)...">{{ old('ki_3') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="ki_4" class="form-label fw-bold">KI-4: Keterampilan</label>
                                <textarea class="form-control" id="ki_4" name="ki_4" rows="2" 
                                          placeholder="Mencoba, mengolah, dan menyaji dalam ranah konkret dan ranah abstrak...">{{ old('ki_4') }}</textarea>
                            </div>

                            <!-- KD & Indikator -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Kompetensi Dasar & Indikator</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kd_pengetahuan" class="form-label fw-bold">KD Pengetahuan</label>
                                <textarea class="form-control" id="kd_pengetahuan" name="kd_pengetahuan" rows="3" 
                                          placeholder="Masukkan Kompetensi Dasar Pengetahuan...">{{ old('kd_pengetahuan') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kd_keterampilan" class="form-label fw-bold">KD Keterampilan</label>
                                <textarea class="form-control" id="kd_keterampilan" name="kd_keterampilan" rows="3" 
                                          placeholder="Masukkan Kompetensi Dasar Keterampilan...">{{ old('kd_keterampilan') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="indikator_pencapaian_kompetensi" class="form-label fw-bold">Indikator Pencapaian Kompetensi</label>
                                <textarea class="form-control" id="indikator_pencapaian_kompetensi" name="indikator_pencapaian_kompetensi" rows="4" 
                                          placeholder="Masukkan indikator pencapaian kompetensi...">{{ old('indikator_pencapaian_kompetensi') }}</textarea>
                            </div>

                            <!-- Tujuan Pembelajaran -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-flag-checkered me-2"></i>Tujuan Pembelajaran</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tujuan_pembelajaran" class="form-label fw-bold">Tujuan Pembelajaran</label>
                                <textarea class="form-control" id="tujuan_pembelajaran" name="tujuan_pembelajaran" rows="5" 
                                          placeholder="Masukkan tujuan pembelajaran yang ingin dicapai...">{{ old('tujuan_pembelajaran') }}</textarea>
                            </div>

                            <!-- Materi Pembelajaran -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-book me-2"></i>Materi Pembelajaran</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label for="materi_pembelajaran" class="form-label fw-bold">Materi Pembelajaran</label>
                                <textarea class="form-control" id="materi_pembelajaran" name="materi_pembelajaran" rows="5" 
                                          placeholder="Masukkan materi pembelajaran...">{{ old('materi_pembelajaran') }}</textarea>
                            </div>

                            <!-- Metode Pembelajaran -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Metode Pembelajaran</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label for="metode_pembelajaran" class="form-label fw-bold">Metode Pembelajaran</label>
                                <textarea class="form-control" id="metode_pembelajaran" name="metode_pembelajaran" rows="3" 
                                          placeholder="Contoh: Ceramah, Diskusi, Tanya Jawab, Penugasan...">{{ old('metode_pembelajaran') }}</textarea>
                            </div>

                            <!-- Kegiatan Pembelajaran -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Kegiatan Pembelajaran</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kegiatan_pendahuluan" class="form-label fw-bold">Kegiatan Pendahuluan</label>
                                <textarea class="form-control" id="kegiatan_pendahuluan" name="kegiatan_pendahuluan" rows="4" 
                                          placeholder="Masukkan kegiatan pendahuluan (pembukaan, apersepsi, motivasi)...">{{ old('kegiatan_pendahuluan') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kegiatan_inti" class="form-label fw-bold">Kegiatan Inti</label>
                                <textarea class="form-control" id="kegiatan_inti" name="kegiatan_inti" rows="6" 
                                          placeholder="Masukkan kegiatan inti pembelajaran (mengamati, menanya, mengumpulkan informasi, mengasosiasi, mengkomunikasikan)...">{{ old('kegiatan_inti') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kegiatan_penutup" class="form-label fw-bold">Kegiatan Penutup</label>
                                <textarea class="form-control" id="kegiatan_penutup" name="kegiatan_penutup" rows="4" 
                                          placeholder="Masukkan kegiatan penutup (kesimpulan, refleksi, evaluasi)...">{{ old('kegiatan_penutup') }}</textarea>
                            </div>

                            <!-- Media & Sumber Belajar -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-laptop me-2"></i>Media & Sumber Belajar</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label for="media_pembelajaran" class="form-label fw-bold">Media Pembelajaran</label>
                                <textarea class="form-control" id="media_pembelajaran" name="media_pembelajaran" rows="3" 
                                          placeholder="Contoh: Papan tulis, LCD Proyektor, Video, PPT...">{{ old('media_pembelajaran') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="sumber_belajar" class="form-label fw-bold">Sumber Belajar</label>
                                <textarea class="form-control" id="sumber_belajar" name="sumber_belajar" rows="3" 
                                          placeholder="Contoh: Buku paket, modul, internet, dll...">{{ old('sumber_belajar') }}</textarea>
                            </div>

                            <!-- Penilaian -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Penilaian</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label for="teknik_penilaian" class="form-label fw-bold">Teknik Penilaian</label>
                                <textarea class="form-control" id="teknik_penilaian" name="teknik_penilaian" rows="3" 
                                          placeholder="Contoh: Tes tertulis, observasi, penugasan...">{{ old('teknik_penilaian') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="bentuk_instrumen" class="form-label fw-bold">Bentuk Instrumen</label>
                                <textarea class="form-control" id="bentuk_instrumen" name="bentuk_instrumen" rows="3" 
                                          placeholder="Contoh: Pilihan ganda, uraian, lembar observasi...">{{ old('bentuk_instrumen') }}</textarea>
                            </div>

                            <!-- Dirjen Pendidikan Islam - Input Alamat Lokal -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-mosque me-2"></i>Dirjen Pendidikan Islam Setempat</h5>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Petunjuk:</strong> Isi alamat kantor Dirjen Pendidikan Islam yang terdekat dengan lokasi sekolah Anda.
                                <br><small class="text-muted">Contoh: Kantor Kementerian Agama Kabupaten Sumedang, Jl. Raya Sumedang No. 123</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dirjen_nama_kantor" class="form-label fw-bold">Nama Kantor</label>
                                    <input type="text" class="form-control" id="dirjen_nama_kantor" name="dirjen_nama_kantor" 
                                           value="{{ old('dirjen_nama_kantor', 'Kantor Kementerian Agama Kabupaten/Kota') }}" 
                                           placeholder="Contoh: Kantor Kementerian Agama Kabupaten Sumedang">
                                    <small class="text-muted">Nama kantor Kemenag setempat</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="dirjen_kota" class="form-label fw-bold">Kota/Kabupaten</label>
                                    <input type="text" class="form-control" id="dirjen_kota" name="dirjen_kota" 
                                           value="{{ old('dirjen_kota') }}" 
                                           placeholder="Contoh: Sumedang, Bandung, Jakarta">
                                    <small class="text-muted">Kota/Kabupaten lokasi kantor</small>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="dirjen_alamat" class="form-label fw-bold">Alamat Lengkap</label>
                                    <textarea class="form-control" id="dirjen_alamat" name="dirjen_alamat" rows="2" 
                                              placeholder="Contoh: Jl. Raya Sumedang No. 123, Sumedang, Jawa Barat">{{ old('dirjen_alamat') }}</textarea>
                                    <small class="text-muted">Alamat lengkap kantor Kemenag setempat</small>
                                </div>
                            </div>

                            <!-- Tanda Tangan Kepala Sekolah -->
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-signature me-2"></i>Pengesahan</h5>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Mengetahui,</label>
                                    <p class="mb-2 text-muted">Kepala Sekolah</p>
                                    
                                    <div class="mb-3">
                                        <label for="kepala_sekolah_nama" class="form-label">Nama Kepala Sekolah</label>
                                        <input type="text" class="form-control" id="kepala_sekolah_nama" name="kepala_sekolah_nama" 
                                               value="{{ old('kepala_sekolah_nama') }}" 
                                               placeholder="Nama Kepala Sekolah">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="kepala_sekolah_nip" class="form-label">NIP Kepala Sekolah</label>
                                        <input type="text" class="form-control" id="kepala_sekolah_nip" name="kepala_sekolah_nip" 
                                               value="{{ old('kepala_sekolah_nip') }}" 
                                               placeholder="NIP Kepala Sekolah">
                                    </div>
                                    
                                    <!-- Upload Tanda Tangan Kepala Sekolah -->
                                    <div class="mb-3">
                                        <label for="ttd_kepala_sekolah" class="form-label">Upload Tanda Tangan & Stempel</label>
                                        <input type="file" class="form-control" id="ttd_kepala_sekolah" name="ttd_kepala_sekolah" 
                                               accept="image/*" onchange="previewSignature(this, 'preview_ttd_kepsek')">
                                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                                    </div>
                                    
                                    <div class="border rounded p-3 text-center bg-light" id="preview_ttd_kepsek" style="min-height: 150px;">
                                        <i class="fas fa-image text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0 small">Preview Tanda Tangan & Stempel</p>
                                        <p class="text-muted mb-0 small">Akan muncul setelah upload</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Guru Mata Pelajaran,</label>
                                    <p class="mb-2 text-muted">{{ $mataPelajaran }}</p>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama Guru</label>
                                        <input type="text" class="form-control" value="{{ $guru->user->name }}" readonly style="background-color: #e9ecef;">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">NIP Guru</label>
                                        <input type="text" class="form-control" value="{{ $guru->nip ?? '-' }}" readonly style="background-color: #e9ecef;">
                                    </div>
                                    
                                    <!-- Upload Tanda Tangan Guru -->
                                    <div class="mb-3">
                                        <label for="ttd_guru" class="form-label">Upload Tanda Tangan</label>
                                        <input type="file" class="form-control" id="ttd_guru" name="ttd_guru" 
                                               accept="image/*" onchange="previewSignature(this, 'preview_ttd_guru')">
                                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                                    </div>
                                    
                                    <div class="border rounded p-3 text-center bg-light" id="preview_ttd_guru" style="min-height: 150px;">
                                        <i class="fas fa-image text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0 small">Preview Tanda Tangan</p>
                                        <p class="text-muted mb-0 small">Akan muncul setelah upload</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Catatan:</strong> Setelah RPP disimpan, cetak dokumen untuk ditandatangani oleh Kepala Sekolah dan Guru yang bersangkutan.
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan RPP
                                </button>
                                <a href="{{ route('guru.dashboard', ['mata_pelajaran' => $mataPelajaran]) }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Preview signature image
    function previewSignature(input, previewId) {
        const preview = document.getElementById(previewId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview Tanda Tangan" 
                         style="max-width: 100%; max-height: 150px; object-fit: contain;">
                    <p class="text-success mb-0 small mt-2">
                        <i class="fas fa-check-circle me-1"></i>
                        Gambar berhasil dipilih
                    </p>
                `;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

</body>
</html>
