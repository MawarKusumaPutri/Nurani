@extends('layouts.app')

@section('content')
<style>
    /* Custom styles untuk halaman tentang */
    .tentang-section h2 {
        color: #46923c !important;
        border-bottom-color: #46923c !important;
    }
    
    .tentang-section .text-green-700 {
        color: #46923c !important;
    }
    
    .tentang-section .border-green-300 {
        border-color: #46923c !important;
    }
    
    .tentang-section .from-green-600 {
        background: #46923c !important;
    }
    
    .tentang-section .to-green-500 {
        background: #5BA84F !important;
    }
    
    /* Force all green elements to use #46923c */
    .bg-green-600, .bg-green-500, .bg-green-700, .bg-green-800, .bg-green-400, .bg-green-300 {
        background-color: #46923c !important;
    }
    
    .text-green-600, .text-green-500, .text-green-700, .text-green-800, .text-green-400, .text-green-300 {
        color: #46923c !important;
    }
    
    .border-green-600, .border-green-500, .border-green-700, .border-green-800, .border-green-400, .border-green-300 {
        border-color: #46923c !important;
    }
    
    /* Override any element with green background */
    [style*="background"] {
        background: #46923c !important;
    }
    
    /* Force footer specifically */
    footer, .footer, [class*="footer"] {
        background: #46923c !important;
    }
    
    /* Force main content background */
    .tentang-section {
        background: #F1F8E9 !important;
    }
    
    /* Override any background on main content */
    .py-12 {
        background: #F1F8E9 !important;
    }
    
    /* Force specific section background */
    section.py-12.tentang-section {
        background: #F1F8E9 !important;
    }
    
    /* Override any Tailwind background classes */
    .bg-gray-50, .bg-white, .bg-green-50, .bg-green-100 {
        background: #F1F8E9 !important;
    }
    
</style>
<!-- HEADER FOTO -->
<section class="relative h-64 bg-cover bg-center" style="background-image: url('{{ asset('images/sekolah-header.jpg') }}');">
        <div class="absolute inset-0 flex items-center justify-center" style="background: #46923c;">
        <div class="text-center text-white">
            <h1 class="text-4xl font-bold">MTs Nurul Aiman Tanjungsari</h1>
            <p class="text-lg mt-2 italic">Beriman, Berilmu, Berkarakter</p>
        </div>
    </div>
</section>

<!-- KONTEN UTAMA -->
<section class="py-12 tentang-section" style="background: #F1F8E9 !important;">
    <div class="max-w-6xl mx-auto px-6 md:px-10">

        <!-- VISI -->
        <div class="mb-10">
                <h2 class="text-3xl font-semibold text-green-700 border-b-4 border-green-300 inline-block pb-2">Visi</h2>
            <p class="mt-4 text-gray-800 leading-relaxed">
                Terwujudnya generasi yang beriman, berilmu, dan berkarakter sebagai wujud Islam yang 
                <em>Rahmatan Lil Alamin.</em>
            </p>
        </div>

        <!-- MISI -->
        <div class="mb-10">
                <h2 class="text-3xl font-semibold text-green-700 border-b-4 border-green-300 inline-block pb-2">Misi</h2>
            <ul class="list-disc pl-6 mt-4 text-gray-800 space-y-2">
                <li>Meningkatkan penghayatan ajaran Islam berdasarkan Al-Qur'an dan Hadist sesuai dengan paham <em>Ahlus Sunnah Wal Jama'ah.</em></li>
                <li>Menanamkan nilai-nilai karakter Islami.</li>
                <li>Melaksanakan proses belajar mengajar yang efektif, inovatif, kreatif, dan menyenangkan.</li>
                <li>Menumbuhkan semangat kompetensi berprestasi.</li>
                <li>Mengembangkan manajemen yang terintegratif dengan aspirasi seluruh komponen warga sekolah.</li>
            </ul>
        </div>

        <!-- SEJARAH -->
        <div class="mb-10">
                <h2 class="text-3xl font-semibold text-green-700 border-b-4 border-green-300 inline-block pb-2">Sejarah</h2>
            <p class="mt-4 text-gray-800 leading-relaxed">
                MTs Nurul Aiman berdiri pada tahun <strong>1989</strong> dan mulai beroperasi pada tahun <strong>1990</strong>. 
                Merupakan Madrasah Tsanawiyah pertama di wilayah 
                <strong>Cikondang, Gunungmanik, Tanjungsari.</strong>
            </p>
        </div>

        <!-- KURIKULUM -->
        <div class="mb-10">
                <h2 class="text-3xl font-semibold text-green-700 border-b-4 border-green-300 inline-block pb-2">Kurikulum</h2>
            <ul class="list-disc pl-6 mt-4 text-gray-800 space-y-2">
                <li>Kurikulum Pemerintah (<em>Kurikulum 2013 / Kurikulum Merdeka</em>).</li>
                <li>Kurikulum modifikasi (perpaduan dari kurikulum pemerintah, yayasan, dan pesantren).</li>
            </ul>
        </div>

        <!-- SARANA DAN PRASARANA -->
        <div class="mb-10">
                <h2 class="text-3xl font-semibold text-green-700 border-b-4 border-green-300 inline-block pb-2">Sarana dan Prasarana</h2>
            <div class="grid md:grid-cols-2 gap-6 mt-4 text-gray-800">
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Luas tanah:</strong> 5.400 m²</li>
                    <li><strong>Luas bangunan:</strong> 700 m²</li>
                    <li><strong>Luas halaman:</strong> 2.300 m²</li>
                    <li><strong>Luas lapangan olahraga:</strong> 1.200 m²</li>
                    <li><strong>Luas yang belum digunakan:</strong> 1.200 m²</li>
                </ul>
                <ul class="list-disc pl-6 space-y-2">
                    <li>3 lokal ruang kelas</li>
                    <li>1 lokal ruang kepala madrasah</li>
                    <li>1 lokal ruang guru</li>
                    <li>1 lokal ruang Tata Usaha (TU)</li>
                    <li>2 lokal toilet</li>
                    <li>1 lokal perpustakaan</li>
                </ul>
            </div>
        </div>

        <!-- PROFIL SEKOLAH -->
        <div class="mb-10">
                <h2 class="text-3xl font-semibold text-green-700 border-b-4 border-green-300 inline-block pb-2">Profil Sekolah</h2>
            <div class="grid md:grid-cols-2 gap-6 mt-4 text-gray-800">
                <div class="space-y-2">
                    <p><strong>Nama Sekolah:</strong> MTs Nurul Aiman Tanjungsari</p>
                    <p><strong>NSM:</strong> 121232110005</p>
                    <p><strong>NPSN:</strong> 20279003</p>
                    <p><strong>Ijin Operasional:</strong> W.1/PP.00.5/502/1992</p>
                    <p><strong>Akreditasi:</strong> Terakreditasi B (SK No. 763/BAN-SM/SK/2019)</p>
                </div>
                <div class="space-y-2">
                    <p><strong>Nama Yayasan:</strong> YPI Nurul Aiman Tanjungsari</p>
                    <p><strong>SK Menkumham RI:</strong> AHU-0032567.AH.01.12 Tahun 2016</p>
                    <p><strong>NPWP:</strong> 00.548.107.2-424.000</p>
                    <p><strong>Alamat:</strong> Jl. Simpang–Parakanmuncang Km.12, Cikondang, Gunungmanik, Tanjungsari, Sumedang, Jawa Barat</p>
                    <p><strong>Status Tanah:</strong> Wakaf (Luas 5.400 m²)</p>
                </div>
            </div>
        </div>

        <!-- TENAGA PENGAJAR -->
        <div class="mb-10">
                <h2 class="text-3xl font-semibold text-green-700 border-b-4 border-green-300 inline-block pb-2">Tenaga Pengajar</h2>
            <div class="mt-4 text-gray-800">
                <ul class="list-disc pl-6 space-y-2">
                    <li>1 Kepala Madrasah</li>
                    <li>12 Orang Guru</li>
                    <li>1 Tenaga Tata Usaha</li>
                </ul>
                <p class="mt-3">Tenaga pengajar memiliki kualifikasi pendidikan <strong>S1 dan S2</strong>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
