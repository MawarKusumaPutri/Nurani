@php
    $route = match($role) {
        'tu' => route('tu.kegiatan-kesiswaan.monitoring.index'),
        'guru' => route('guru.kegiatan-kesiswaan.monitoring.index'),
        'kepala_sekolah' => route('kepala_sekolah.kegiatan-kesiswaan.monitoring.index'),
        default => route('login')
    };
@endphp
<script>window.location.href = '{{ $route }}';</script>
