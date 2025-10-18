<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MTs Nurul Aiman - TMS NURANI')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Footer Styles */
        .footer {
            background: #46923c !important;
            color: white;
            padding: 30px 0;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }
        
        .contact-info {
            margin-bottom: 20px;
        }
        
        .contact-info p {
            margin-bottom: 8px;
            color: white;
        }
        
        .copyright p {
            margin-bottom: 5px;
            color: white;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-300 to-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-mosque text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">TMS NURANI</h1>
                        <p class="text-sm text-green-100">MTs Nurul Aiman</p>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('welcome') }}" class="hover:text-green-200 transition-colors">BERANDA</a>
                    <a href="{{ route('tentang') }}" class="hover:text-green-200 transition-colors">TENTANG</a>
                    <a href="#programs" class="hover:text-green-200 transition-colors">PROGRAM</a>
                    <a href="#contact" class="hover:text-green-200 transition-colors">KONTAK</a>
                </nav>
                
                <!-- Login Button -->
                <div class="relative">
                    <button class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-full transition-all duration-300 flex items-center space-x-2">
                        <span>LOGIN</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer" style="background: #46923c !important;">
        <div class="footer-content">
            <div class="contact-info">
                <p><strong>Service Desk MTs Nurul Aiman</strong></p>
                <p>📞 0856-2452-5034 | 📱 Chat WA Only: 082263033855</p>
                <p>📧 internal.nurulaimam@gmail.com</p>
                <p>📷 Instagram: @mtssnuraiman | 🎵 TikTok: @mts.na.tjsari</p>
                <p>📍 Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363</p>
            </div>
            <div class="copyright">
                <p>TEACHING MANAGEMENT SYSTEM NURANI (TMS NURANI) © MTs NURUL AIMAN</p>
                <p>Integrated Learning Management System for Modern Education</p>
            </div>
        </div>
    </footer>
</body>
</html>
