<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rencana Kegiatan Wali Kelas - TMS NURANI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @include('partials.guru-dynamic-ui')
</head>
<body>
    @if($role === 'guru')
        @include('partials.guru-sidebar')
    @elseif($role === 'kepala_sekolah')
        @include('partials.kepala-sekolah-sidebar')
    @elseif($role === 'tu')
        @include('partials.tu-sidebar')
    @endif

    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-calendar-plus me-2 text-primary"></i>
                    Rencana Kegiatan Wali Kelas
                </h2>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Ruang untuk membuat rencana kegiatan wali kelas. Fitur ini akan dikembangkan lebih lanjut.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

