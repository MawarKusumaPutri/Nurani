<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - MTs Nurul Aiman Tanjungsari</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #F1F8E9;
            margin: 0;
            padding: 0;
        }
        
        .header-section {
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
            position: relative;
        }
        
        .header-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .header-section .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            font-style: italic;
        }
        
        .content-section {
            padding: 60px 0;
            background: #F1F8E9;
        }
        
        .section-title {
            color: #2E7D32;
            font-size: 2.5rem;
            font-weight: 600;
            border-bottom: 4px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 30px;
            display: inline-block;
        }
        
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #4CAF50;
        }
        
        .content-card h3 {
            color: #2E7D32;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .content-card p, .content-card li {
            color: #424242;
            line-height: 1.8;
            font-size: 1.1rem;
        }
        
        .content-card ul {
            padding-left: 20px;
        }
        
        .content-card li {
            margin-bottom: 10px;
        }
        
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #F0F4F0;
            color: #2E7D32;
            border: 2px solid #4CAF50;
            border-radius: 50px;
            padding: 12px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
            font-weight: 600;
        }
        
        .back-button:hover {
            background: #4CAF50;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-item {
            background: #E8F5E8;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #4CAF50;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2E7D32;
        }
        
        .stat-label {
            color: #424242;
            font-size: 1rem;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .content-card {
                padding: 20px;
            }
        }
</style>
</head>
<body>
    <!-- Back Button -->
    <button class="back-button" onclick="window.history.back()">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </button>

    <!-- Header Section -->
    <div class="header-section">
        <div class="container">
            <h1>MTs Nurul Aiman Tanjungsari</h1>
            <p class="subtitle">Beriman, Berilmu, Berkarakter</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-section">
        <div class="container">
            
            <!-- Visi -->
            <div class="content-card">
                <h3><i class="fas fa-eye me-2"></i>Visi</h3>
                <p>
                Terwujudnya generasi yang beriman, berilmu, dan berkarakter sebagai wujud Islam yang 
                <em>Rahmatan Lil Alamin.</em>
            </p>
        </div>

            <!-- Misi -->
            <div class="content-card">
                <h3><i class="fas fa-bullseye me-2"></i>Misi</h3>
                <ul>
                <li>Meningkatkan penghayatan ajaran Islam berdasarkan Al-Qur'an dan Hadist sesuai dengan paham <em>Ahlus Sunnah Wal Jama'ah.</em></li>
                <li>Menanamkan nilai-nilai karakter Islami.</li>
                <li>Melaksanakan proses belajar mengajar yang efektif, inovatif, kreatif, dan menyenangkan.</li>
                <li>Menumbuhkan semangat kompetensi berprestasi.</li>
                <li>Mengembangkan manajemen yang terintegratif dengan aspirasi seluruh komponen warga sekolah.</li>
            </ul>
        </div>

            <!-- Sejarah -->
            <div class="content-card">
                <h3><i class="fas fa-history me-2"></i>Sejarah</h3>
                <p>
                MTs Nurul Aiman berdiri pada tahun <strong>1989</strong> dan mulai beroperasi pada tahun <strong>1990</strong>. 
                Merupakan Madrasah Tsanawiyah pertama di wilayah 
                <strong>Cikondang, Gunungmanik, Tanjungsari.</strong>
            </p>
        </div>

            <!-- Kurikulum -->
            <div class="content-card">
                <h3><i class="fas fa-book me-2"></i>Kurikulum</h3>
                <ul>
                <li>Kurikulum Pemerintah (<em>Kurikulum 2013 / Kurikulum Merdeka</em>).</li>
                <li>Kurikulum modifikasi (perpaduan dari kurikulum pemerintah, yayasan, dan pesantren).</li>
            </ul>
        </div>

            <!-- Sarana dan Prasarana -->
            <div class="content-card">
                <h3><i class="fas fa-building me-2"></i>Sarana dan Prasarana</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">5.400 m²</div>
                        <div class="stat-label">Luas Tanah</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">700 m²</div>
                        <div class="stat-label">Luas Bangunan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">2.300 m²</div>
                        <div class="stat-label">Luas Halaman</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1.200 m²</div>
                        <div class="stat-label">Lapangan Olahraga</div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5>Fasilitas Ruangan:</h5>
                        <ul>
                    <li>3 lokal ruang kelas</li>
                    <li>1 lokal ruang kepala madrasah</li>
                    <li>1 lokal ruang guru</li>
                    <li>1 lokal ruang Tata Usaha (TU)</li>
                    <li>2 lokal toilet</li>
                    <li>1 lokal perpustakaan</li>
                </ul>
                    </div>
            </div>
        </div>

            <!-- Profil Sekolah -->
            <div class="content-card">
                <h3><i class="fas fa-info-circle me-2"></i>Profil Sekolah</h3>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Identitas Sekolah:</h5>
                    <p><strong>Nama Sekolah:</strong> MTs Nurul Aiman Tanjungsari</p>
                    <p><strong>NSM:</strong> 121232110005</p>
                    <p><strong>NPSN:</strong> 20279003</p>
                    <p><strong>Ijin Operasional:</strong> W.1/PP.00.5/502/1992</p>
                    <p><strong>Akreditasi:</strong> Terakreditasi B (SK No. 763/BAN-SM/SK/2019)</p>
                </div>
                    <div class="col-md-6">
                        <h5>Yayasan:</h5>
                    <p><strong>Nama Yayasan:</strong> YPI Nurul Aiman Tanjungsari</p>
                    <p><strong>SK Menkumham RI:</strong> AHU-0032567.AH.01.12 Tahun 2016</p>
                    <p><strong>NPWP:</strong> 00.548.107.2-424.000</p>
                    <p><strong>Alamat:</strong> Jl. Simpang–Parakanmuncang Km.12, Cikondang, Gunungmanik, Tanjungsari, Sumedang, Jawa Barat</p>
                    <p><strong>Status Tanah:</strong> Wakaf (Luas 5.400 m²)</p>
                </div>
            </div>
        </div>

            <!-- Tenaga Pengajar -->
            <div class="content-card">
                <h3><i class="fas fa-chalkboard-teacher me-2"></i>Tenaga Pengajar</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">1</div>
                        <div class="stat-label">Kepala Madrasah</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Guru</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1</div>
                        <div class="stat-label">Tenaga Tata Usaha</div>
                    </div>
                </div>
                <p class="mt-3">Tenaga pengajar memiliki kualifikasi pendidikan <strong>S1 dan S2</strong>.</p>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>