@php
    $route = match($role) {
        'tu' => route('tu.kegiatan-kesiswaan.rencana.index'),
        'guru' => route('guru.kegiatan-kesiswaan.rencana.index'),
        'kepala_sekolah' => route('kepala_sekolah.kegiatan-kesiswaan.rencana.index'),
        default => route('login')
    };
@endphp
<script>window.location.href = '{{ $route }}';</script>
