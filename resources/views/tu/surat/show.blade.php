@extends('layouts.tu')

@section('title', 'Detail Surat - TU Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.tu-sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Detail Surat</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('tu.surat.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if($surat->status == 'draft' && $surat->created_by == Auth::id())
                            <a href="{{ route('tu.surat.edit', $surat->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
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

            @php
                $jenisBadge = match($surat->jenis_surat) {
                    'surat_keputusan' => 'bg-primary',
                    'surat_edaran' => 'bg-info',
                    'surat_undangan' => 'bg-warning',
                    'surat_tugas' => 'bg-secondary',
                    'surat_izin' => 'bg-success',
                    'surat_pengumuman' => 'bg-primary',
                    'surat_permohonan' => 'bg-info',
                    'surat_balasan' => 'bg-secondary',
                    default => 'bg-secondary'
                };
                
                $jenisLabel = match($surat->jenis_surat) {
                    'surat_keputusan' => 'Surat Keputusan',
                    'surat_edaran' => 'Surat Edaran',
                    'surat_undangan' => 'Surat Undangan',
                    'surat_tugas' => 'Surat Tugas',
                    'surat_izin' => 'Surat Izin',
                    'surat_pengumuman' => 'Surat Pengumuman',
                    'surat_permohonan' => 'Surat Permohonan',
                    'surat_balasan' => 'Surat Balasan',
                    default => 'Surat'
                };
                
                $statusBadge = match($surat->status) {
                    'draft' => 'bg-warning',
                    'terkirim' => 'bg-success',
                    'diterima' => 'bg-info',
                    default => 'bg-secondary'
                };
                
                $statusLabel = match($surat->status) {
                    'draft' => 'Draft',
                    'terkirim' => 'Terkirim',
                    'diterima' => 'Diterima',
                    default => ucfirst($surat->status)
                };
                
                $penerimaText = match($surat->penerima) {
                    'kepala_sekolah' => 'Kepala Sekolah',
                    'guru' => 'Semua Guru',
                    'siswa' => 'Semua Siswa',
                    'orang_tua' => 'Orang Tua Siswa',
                    'yayasan' => 'Yayasan',
                    'dinas_pendidikan' => 'Dinas Pendidikan',
                    'lainnya' => $surat->penerima_lainnya ?? 'Lainnya',
                    default => 'Penerima'
                };
                
                $prioritasBadge = match($surat->prioritas) {
                    'biasa' => 'bg-secondary',
                    'penting' => 'bg-warning',
                    'sangat_penting' => 'bg-danger',
                    'segera' => 'bg-danger',
                    default => 'bg-secondary'
                };
                
                $prioritasLabel = match($surat->prioritas) {
                    'biasa' => 'Biasa',
                    'penting' => 'Penting',
                    'sangat_penting' => 'Sangat Penting',
                    'segera' => 'Segera',
                    default => ucfirst($surat->prioritas ?? 'Biasa')
                };
            @endphp

            <!-- Detail Surat -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-envelope"></i> Informasi Surat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Jenis Surat:</strong>
                                    <span class="badge {{ $jenisBadge }} ms-2">{{ $jenisLabel }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Status:</strong>
                                    <span class="badge {{ $statusBadge }} ms-2">{{ $statusLabel }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Nomor Surat:</strong>
                                    <p class="mb-0">{{ $surat->nomor_surat }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Tanggal Surat:</strong>
                                    <p class="mb-0">{{ $surat->tanggal_surat->format('d F Y') }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Prioritas:</strong>
                                    <span class="badge {{ $prioritasBadge }} ms-2">{{ $prioritasLabel }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Arsipkan:</strong>
                                    <span class="badge {{ $surat->arsipkan ? 'bg-success' : 'bg-secondary' }} ms-2">
                                        {{ $surat->arsipkan ? 'Ya' : 'Tidak' }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>Perihal:</strong>
                                <p class="mb-0">{{ $surat->perihal }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Kepada:</strong>
                                <p class="mb-0">{{ $penerimaText }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Isi Surat:</strong>
                                <div class="border rounded p-3 mt-2 bg-light">
                                    <p class="mb-0" style="white-space: pre-wrap;">{{ $surat->isi_surat }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Pembuat Surat:</strong>
                                    <p class="mb-0">{{ $surat->pembuat_surat }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Jabatan Pembuat:</strong>
                                    <p class="mb-0">{{ $surat->jabatan_pembuat ?? '-' }}</p>
                                </div>
                            </div>

                            @if($surat->lampiran)
                                <div class="mb-3">
                                    <strong>Lampiran:</strong>
                                    <div class="mt-2">
                                        <a href="{{ route('tu.surat.lampiran.view', $surat->id) }}" target="_blank" class="btn btn-sm btn-primary me-2" title="Lihat Lampiran">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('tu.surat.lampiran.download', $surat->id) }}" class="btn btn-sm btn-outline-secondary" title="Download Lampiran">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Dibuat pada:</strong>
                                    <p class="mb-0">{{ $surat->created_at->format('d F Y, H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Diperbarui pada:</strong>
                                    <p class="mb-0">{{ $surat->updated_at->format('d F Y, H:i') }}</p>
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

