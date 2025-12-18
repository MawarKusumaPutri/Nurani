@php
    $route = match($role) {
        'tu' => route('tu.kegiatan-kesiswaan.laporan.index'),
        'guru' => route('guru.kegiatan-kesiswaan.laporan.index'),
        'kepala_sekolah' => route('kepala_sekolah.kegiatan-kesiswaan.laporan.index'),
        default => route('login')
    };
@endphp
<script>window.location.href = '{{ $route }}';</script>
