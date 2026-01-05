<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak RPP - {{ $rpp->judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
                margin: 0;
            }
            .container {
                max-width: 100%;
            }
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            padding: 20px;
        }
        
        .header-section {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        
        .header-section h1 {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header-section h2 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .identitas-table {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .identitas-table td {
            padding: 5px;
            vertical-align: top;
        }
        
        .identitas-table td:first-child {
            width: 200px;
            font-weight: bold;
        }
        
        .identitas-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 14pt;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }
        
        .content-section {
            margin-bottom: 15px;
            text-align: justify;
        }
        
        .sub-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print print-button">
        <button onclick="window.print()" class="btn btn-success btn-lg">
            <i class="fas fa-print me-2"></i>Cetak RPP
        </button>
        <a href="{{ route('guru.dashboard', ['mata_pelajaran' => $rpp->mata_pelajaran]) }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header-section">
            <h1>RENCANA PELAKSANAAN PEMBELAJARAN</h1>
            <h2>(RPP)</h2>
            <p style="margin: 0;">{{ $rpp->sekolah ?? 'MTs Nurul Aiman' }}</p>
        </div>

        <!-- Identitas Pembelajaran -->
        <table class="identitas-table">
            <tr>
                <td>Nama Sekolah</td>
                <td>:</td>
                <td>{{ $rpp->sekolah ?? 'MTs Nurul Aiman' }}</td>
            </tr>
            <tr>
                <td>Nama Guru</td>
                <td>:</td>
                <td>{{ $guru->user->name }}</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>:</td>
                <td>{{ $rpp->mata_pelajaran }}</td>
            </tr>
            <tr>
                <td>Kelas/Semester</td>
                <td>:</td>
                <td>{{ $rpp->kelas }} / {{ $rpp->semester }}</td>
            </tr>
            <tr>
                <td>Pertemuan Ke</td>
                <td>:</td>
                <td>{{ $rpp->pertemuan_ke }}</td>
            </tr>
            <tr>
                <td>Alokasi Waktu</td>
                <td>:</td>
                <td>{{ $rpp->alokasi_waktu }} menit</td>
            </tr>
            <tr>
                <td>Tahun Pelajaran</td>
                <td>:</td>
                <td>{{ $rpp->tahun_pelajaran ?? '2025-2026' }}</td>
            </tr>
        </table>

        <!-- Kompetensi Inti -->
        @if($rpp->ki_1 || $rpp->ki_2 || $rpp->ki_3 || $rpp->ki_4)
        <div class="section-title">A. KOMPETENSI INTI</div>
        <div class="content-section">
            @if($rpp->ki_1)
            <div class="sub-title">KI-1: Sikap Spiritual</div>
            <p>{{ $rpp->ki_1 }}</p>
            @endif
            
            @if($rpp->ki_2)
            <div class="sub-title">KI-2: Sikap Sosial</div>
            <p>{{ $rpp->ki_2 }}</p>
            @endif
            
            @if($rpp->ki_3)
            <div class="sub-title">KI-3: Pengetahuan</div>
            <p>{{ $rpp->ki_3 }}</p>
            @endif
            
            @if($rpp->ki_4)
            <div class="sub-title">KI-4: Keterampilan</div>
            <p>{{ $rpp->ki_4 }}</p>
            @endif
        </div>
        @endif

        <!-- Kompetensi Dasar -->
        @if($rpp->kd_pengetahuan || $rpp->kd_keterampilan)
        <div class="section-title">B. KOMPETENSI DASAR</div>
        <div class="content-section">
            @if($rpp->kd_pengetahuan)
            <div class="sub-title">KD Pengetahuan</div>
            <p>{{ $rpp->kd_pengetahuan }}</p>
            @endif
            
            @if($rpp->kd_keterampilan)
            <div class="sub-title">KD Keterampilan</div>
            <p>{{ $rpp->kd_keterampilan }}</p>
            @endif
        </div>
        @endif

        <!-- Indikator Pencapaian Kompetensi -->
        @if($rpp->indikator_pencapaian_kompetensi)
        <div class="section-title">C. INDIKATOR PENCAPAIAN KOMPETENSI</div>
        <div class="content-section">
            <p>{{ $rpp->indikator_pencapaian_kompetensi }}</p>
        </div>
        @endif

        <!-- Tujuan Pembelajaran -->
        @if($rpp->tujuan_pembelajaran)
        <div class="section-title">D. TUJUAN PEMBELAJARAN</div>
        <div class="content-section">
            <p>{{ $rpp->tujuan_pembelajaran }}</p>
        </div>
        @endif

        <!-- Materi Pembelajaran -->
        @if($rpp->materi_pembelajaran)
        <div class="section-title">E. MATERI PEMBELAJARAN</div>
        <div class="content-section">
            <p style="white-space: pre-line;">{{ $rpp->materi_pembelajaran }}</p>
        </div>
        @endif

        <!-- Metode Pembelajaran -->
        @if($rpp->metode_pembelajaran)
        <div class="section-title">F. METODE PEMBELAJARAN</div>
        <div class="content-section">
            <p>{{ $rpp->metode_pembelajaran }}</p>
        </div>
        @endif

        <!-- Kegiatan Pembelajaran -->
        @if($rpp->kegiatan_pendahuluan || $rpp->kegiatan_inti || $rpp->kegiatan_penutup)
        <div class="section-title">G. KEGIATAN PEMBELAJARAN</div>
        <div class="content-section">
            @if($rpp->kegiatan_pendahuluan)
            <div class="sub-title">1. Kegiatan Pendahuluan</div>
            <p style="white-space: pre-line;">{{ $rpp->kegiatan_pendahuluan }}</p>
            @endif
            
            @if($rpp->kegiatan_inti)
            <div class="sub-title">2. Kegiatan Inti</div>
            <p style="white-space: pre-line;">{{ $rpp->kegiatan_inti }}</p>
            @endif
            
            @if($rpp->kegiatan_penutup)
            <div class="sub-title">3. Kegiatan Penutup</div>
            <p style="white-space: pre-line;">{{ $rpp->kegiatan_penutup }}</p>
            @endif
        </div>
        @endif

        <!-- Media dan Sumber Belajar -->
        @if($rpp->media_pembelajaran || $rpp->sumber_belajar)
        <div class="section-title">H. MEDIA DAN SUMBER BELAJAR</div>
        <div class="content-section">
            @if($rpp->media_pembelajaran)
            <div class="sub-title">Media Pembelajaran</div>
            <p>{{ $rpp->media_pembelajaran }}</p>
            @endif
            
            @if($rpp->sumber_belajar)
            <div class="sub-title">Sumber Belajar</div>
            <p>{{ $rpp->sumber_belajar }}</p>
            @endif
        </div>
        @endif

        <!-- Penilaian -->
        @if($rpp->teknik_penilaian || $rpp->bentuk_instrumen || $rpp->rubrik_penilaian)
        <div class="section-title">I. PENILAIAN</div>
        <div class="content-section">
            @if($rpp->teknik_penilaian)
            <div class="sub-title">Teknik Penilaian</div>
            <p>{{ $rpp->teknik_penilaian }}</p>
            @endif
            
            @if($rpp->bentuk_instrumen)
            <div class="sub-title">Bentuk Instrumen</div>
            <p>{{ $rpp->bentuk_instrumen }}</p>
            @endif
            
            @if($rpp->rubrik_penilaian)
            <div class="sub-title">Rubrik Penilaian</div>
            <p style="white-space: pre-line;">{{ $rpp->rubrik_penilaian }}</p>
            @endif
        </div>
        @endif

        <!-- Dirjen Pendidikan Islam Setempat -->
        @if($rpp->nama_kantor || $rpp->kota_kabupaten || $rpp->alamat_lengkap)
        <div class="section-title">DIRJEN PENDIDIKAN ISLAM SETEMPAT</div>
        <div class="content-section">
            @if($rpp->nama_kantor)
            <div class="sub-title">Nama Kantor</div>
            <p>{{ $rpp->nama_kantor }}</p>
            @endif
            
            @if($rpp->kota_kabupaten)
            <div class="sub-title">Kota/Kabupaten</div>
            <p>{{ $rpp->kota_kabupaten }}</p>
            @endif
            
            @if($rpp->alamat_lengkap)
            <div class="sub-title">Alamat Lengkap</div>
            <p>{{ $rpp->alamat_lengkap }}</p>
            @endif
        </div>
        @endif

        <!-- Tanda Tangan -->
        <div style="margin-top: 50px;">
            <table style="width: 100%;">
                <tr>
                    <!-- Kolom Kepala Sekolah -->
                    <td style="width: 50%; text-align: center; vertical-align: top;">
                        <p>Mengetahui,</p>
                        <p style="margin-bottom: 80px;">Kepala Sekolah,</p>
                        <p style="border-bottom: 1px solid #000; display: inline-block; min-width: 200px;">
                            {{ $rpp->nama_kepala_sekolah ?? '.......................................' }}
                        </p>
                        <p>NIP/NUPTK: {{ $rpp->nip_kepala_sekolah ?? '...........................' }}</p>
                    </td>
                    
                    <!-- Kolom Guru Mata Pelajaran -->
                    <td style="width: 50%; text-align: center; vertical-align: top;">
                        <p>{{ $rpp->sekolah ?? 'MTs Nurul Aiman' }}, {{ date('d F Y') }}</p>
                        <p style="margin-bottom: 80px;">Guru Mata Pelajaran,</p>
                        <p style="border-bottom: 1px solid #000; display: inline-block; min-width: 200px;">
                            {{ $guru->user->name }}
                        </p>
                        <p>NIP/NUPTK: {{ $guru->nip ?? '-' }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</body>
</html>
