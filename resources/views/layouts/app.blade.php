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
    <footer class="bg-gradient-to-r from-green-600 to-green-500 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">Service Desk MTs Nurul Aiman</h3>
                <div class="space-y-2 text-sm">
                    <p><i class="fas fa-phone mr-2"></i>0856-2452-5034 | <i class="fab fa-whatsapp mr-2"></i>Chat WA Only: 082263033855</p>
                    <p><i class="fas fa-envelope mr-2"></i>internal.nurulaimam@gmail.com</p>
                    <p><i class="fab fa-instagram mr-2"></i>Instagram: @mtssnuraiman | <i class="fab fa-tiktok mr-2"></i>TikTok: @mts.na.tjsari</p>
                    <p><i class="fas fa-map-marker-alt mr-2"></i>Jl. Simpang-Parakanmuncang Km 1.2, Cikondang, Gunungmanik, Kec. Tanjungsari Kabupaten Sumedang, Jawa Barat 45363</p>
                </div>
                <div class="mt-6 pt-4 border-t border-green-400">
                    <p class="text-sm">TEACHING MANAGEMENT SYSTEM NURANI (TMS NURANI) © MTs NURUL AIMAN</p>
                    <p class="text-xs text-green-200">Integrated Learning Management System for Modern Education</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
