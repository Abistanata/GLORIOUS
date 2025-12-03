<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Glorious Computer - Solusi Teknologi')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#FF6B00',
                            dark: '#E05D00',
                            light: '#FF8C42',
                        },
                        secondary: '#00A8FF',
                        accent: '#9C27B0',
                        dark: {
                            DEFAULT: '#121212',
                            lighter: '#1E1E1E',
                            light: '#2D2D2D'
                        },
                        light: {
                            DEFAULT: '#F8FAFC',
                            dim: '#E2E8F0'
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'Segoe UI', 'Roboto', 'system-ui', '-apple-system', 'sans-serif'],
                        'heading': ['Poppins', 'Inter', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'pulse-slow': 'pulse 2s infinite',
                        'float': 'float 3s ease-in-out infinite',
                        'heartbeat': 'heartbeat 1.5s ease-in-out infinite'
                    },
                    boxShadow: {
                        'soft': '0 4px 20px rgba(0, 0, 0, 0.08)',
                        'glow': '0 0 20px rgba(255, 107, 0, 0.3)',
                        'glow-primary': '0 0 15px rgba(255, 107, 0, 0.5)'
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'gradient-primary': 'linear-gradient(135deg, #FF6B00 0%, #FF8C42 100%)'
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AlpineJS -->
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --primary: #FF6B00;
            --primary-dark: #E05D00;
            --primary-light: #FF8C42;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes heartbeat {
            0% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(1); }
            75% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #1E1E1E;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8C42 100%);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #E05D00 0%, #FF6B00 100%);
        }
        
        .hamburger-line {
            display: block;
            width: 24px;
            height: 2px;
            background-color: #F8FAFC;
            margin: 5px 0;
            transition: all 0.3s ease;
            transform-origin: center;
            border-radius: 2px;
        }
        
        .hamburger-active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
            background-color: var(--primary);
        }
        
        .hamburger-active .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger-active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
            background-color: var(--primary);
        }
        
        .glass {
            background: rgba(18, 18, 18, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .fab-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 40;
            animation: float 3s ease-in-out infinite;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8C42 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
        }
        
        .mobile-menu.open {
            max-height: 600px;
        }
        
        .products-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .products-submenu.open {
            max-height: 400px;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-dark text-light font-sans antialiased">

    <!-- Tombol WhatsApp -->
    <a href="https://wa.me/6282133803940" 
       target="_blank"
       class="fab-button w-16 h-16 bg-gradient-primary rounded-full flex items-center justify-center shadow-glow hover:shadow-glow-primary transition-all hover:scale-110 group"
       title="Chat via WhatsApp">
        <i class="fab fa-whatsapp text-2xl text-white group-hover:animate-pulse"></i>
        <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center animate-pulse">
            <span class="text-xs text-white">!</span>
        </div>
    </a>

    <!-- Navbar - Versi Sederhana -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-gray-800 shadow-soft">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <!-- Baris Utama Navbar -->
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gradient-primary rounded-2xl flex items-center justify-center group-hover:rotate-12 transition-transform duration-500 shadow-glow">
                                <span class="text-white font-bold text-lg lg:text-xl">GC</span>
                            </div>
                            <div class="absolute -inset-1 bg-gradient-primary rounded-2xl blur opacity-20 group-hover:opacity-30 transition-opacity"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white font-heading font-bold text-xl lg:text-2xl leading-6 tracking-tight">GLORIOUS</span>
                            <span class="gradient-text font-semibold text-xs lg:text-sm tracking-wider">SOLUSI TEKNOLOGI</span>
                        </div>
                    </a>
                </div>

                <!-- Menu Desktop Tengah -->
                <div class="hidden lg:flex items-center space-x-1">
                    <div class="flex items-center space-x-8">
                        <!-- Beranda -->
                        <a href="{{ url('/') }}" class="relative group px-4 py-2">
                            <div class="flex items-center">
                                <i class="fas fa-home mr-2 text-primary opacity-80 group-hover:opacity-100 transition-all"></i>
                                <span class="text-light font-medium group-hover:text-primary transition-colors">Beranda</span>
                            </div>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-primary group-hover:w-full transition-all duration-300 rounded-full"></div>
                        </a>

                        <!-- Tentang -->
                        <a href="{{ route('main.about.index') }}" class="relative group px-4 py-2">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle mr-2 text-primary opacity-80 group-hover:opacity-100 transition-all"></i>
                                <span class="text-light font-medium group-hover:text-primary transition-colors">Tentang</span>
                            </div>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-primary group-hover:w-full transition-all duration-300 rounded-full"></div>
                        </a>

                        <!-- Produk Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button type="button"
                                @mouseenter="open = true"
                                @mouseleave="open = false"
                                class="relative group px-4 py-2 flex items-center">
                                <i class="fas fa-boxes mr-2 text-primary opacity-80 group-hover:opacity-100 transition-all"></i>
                                <span class="text-light font-medium group-hover:text-primary transition-colors">Produk</span>
                                <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-300"
                                   :class="{ 'rotate-180': open }"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 @mouseenter="open = true"
                                 @mouseleave="open = false"
                                 class="absolute left-0 mt-2 w-64 bg-dark-lighter border border-gray-800 rounded-xl shadow-2xl py-3 z-50">
                                <div class="px-4 py-2 border-b border-gray-800">
                                    <h3 class="text-white font-semibold text-sm flex items-center">
                                        <i class="fas fa-layer-group mr-2 text-primary"></i>
                                        Kategori Produk
                                    </h3>
                                </div>
                                
                                <a href="{{ route('main.products.index') }}"
                                   class="flex items-center px-4 py-3 text-sm text-light hover:bg-primary hover:text-white transition-all mx-2 mt-1 rounded-lg">
                                    <i class="fas fa-th-large mr-3"></i>
                                    Semua Produk
                                </a>
                                
                                <div class="px-2 pt-2">
                                    <div class="px-3 py-2 text-xs font-semibold text-gray-400">
                                        Kategori
                                    </div>
                                    <div class="space-y-1 max-h-56 overflow-y-auto">
                                        @if(isset($categories) && $categories->count() > 0)
                                            @foreach($categories->take(6) as $category)
                                                <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}"
                                                   class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-dark-light transition-all rounded-lg">
                                                    <i class="fas fa-folder mr-3 text-primary text-xs"></i>
                                                    <span class="truncate">{{ $category->name }}</span>
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Layanan -->
                        <a href="{{ route('main.services.index') }}" class="relative group px-4 py-2">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2 text-primary opacity-80 group-hover:opacity-100 transition-all"></i>
                                <span class="text-light font-medium group-hover:text-primary transition-colors">Layanan</span>
                            </div>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-primary group-hover:w-full transition-all duration-300 rounded-full"></div>
                        </a>
                    </div>
                </div>

                <!-- Menu Kanan Desktop -->
                <div class="hidden lg:flex items-center space-x-4">
                    <!-- Kontak -->
                    <a href="https://wa.me/6282133803940"
                       target="_blank"
                       class="bg-gradient-primary hover:shadow-glow-primary text-white px-5 py-2.5 rounded-xl font-semibold transition-all hover:scale-105 shadow-lg flex items-center group">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Kontak
                    </a>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" class="relative group">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl hover:bg-dark-light transition-all">
                            <i class="fas fa-heart text-xl text-light group-hover:text-red-500 transition-colors"></i>
                            @if(isset($wishlistCount) && $wishlistCount > 0)
                                <span class="absolute -top-1 -right-1 bg-primary text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-glow">
                                    {{ $wishlistCount }}
                                </span>
                            @endif
                        </div>
                    </a>
                </div>

                <!-- Menu Mobile Toggle -->
                <div class="lg:hidden flex items-center space-x-3">
                    <!-- Wishlist Mobile -->
                    <a href="{{ route('wishlist.index') }}" class="relative">
                        <i class="fas fa-heart text-xl text-light hover:text-primary transition-colors"></i>
                        @if(isset($wishlistCount) && $wishlistCount > 0)
                            <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    </a>
                    
                    <!-- Hamburger Button -->
                    <button id="menu-toggle" 
                            class="flex flex-col justify-center items-center w-10 h-10 focus:outline-none">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div id="mobile-menu" class="lg:hidden mobile-menu bg-dark-lighter border-t border-gray-800">
                <div class="px-4 py-4 space-y-1">
                    <!-- Beranda Mobile -->
                    <a href="{{ url('/') }}" 
                       class="flex items-center px-4 py-3 text-light hover:bg-primary hover:text-white rounded-lg transition-all group">
                        <i class="fas fa-home mr-3 text-primary group-hover:text-white"></i>
                        <span class="font-medium">Beranda</span>
                    </a>
                    
                    <!-- Tentang Mobile -->
                    <a href="{{ route('main.about.index') }}" 
                       class="flex items-center px-4 py-3 text-light hover:bg-primary hover:text-white rounded-lg transition-all group">
                        <i class="fas fa-info-circle mr-3 text-primary group-hover:text-white"></i>
                        <span class="font-medium">Tentang Kami</span>
                    </a>

                    <!-- Produk Mobile -->
                    <div class="px-4 py-2">
                        <button id="mobile-products-toggle" 
                                class="flex items-center justify-between w-full text-light hover:text-primary transition-all p-2 focus:outline-none">
                            <div class="flex items-center">
                                <i class="fas fa-boxes mr-3 text-primary"></i>
                                <span class="font-medium">Produk</span>
                            </div>
                            <i class="fas fa-chevron-down transition-transform duration-300" id="products-arrow"></i>
                        </button>
                        
                        <div id="mobile-products-menu" class="products-submenu pl-8 space-y-1 mt-1">
                            <a href="{{ route('main.products.index') }}" 
                               class="flex items-center px-4 py-2 text-sm text-light hover:bg-primary hover:text-white rounded-lg transition-all">
                                <i class="fas fa-th-large mr-3 w-4 text-center"></i>
                                Semua Produk
                            </a>
                            
                            @isset($categories)
                                @foreach($categories->take(5) as $category)
                                    <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}" 
                                       class="flex items-center px-4 py-2 text-sm text-light hover:bg-primary hover:text-white rounded-lg transition-all">
                                        <i class="fas fa-folder mr-3 w-4 text-center"></i>
                                        <span>{{ $category->name }}</span>
                                    </a>
                                @endforeach
                            @endisset
                        </div>
                    </div>

                    <!-- Layanan Mobile -->
                    <a href="{{ route('main.services.index') }}" 
                       class="flex items-center px-4 py-3 text-light hover:bg-primary hover:text-white rounded-lg transition-all group">
                        <i class="fas fa-cogs mr-3 text-primary group-hover:text-white"></i>
                        <span class="font-medium">Layanan</span>
                    </a>
                    
                    <!-- Kontak Mobile -->
                    <a href="https://wa.me/6282133803940" 
                       target="_blank"
                       class="flex items-center justify-center bg-gradient-primary hover:shadow-glow-primary text-white px-4 py-3 rounded-xl font-semibold transition-all group mt-4">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="pt-24">
        <main>
            <!-- Overlay Loading -->
            <div id="loading-overlay" class="fixed inset-0 bg-dark/90 z-50 flex items-center justify-center hidden">
                <div class="text-center">
                    <div class="w-20 h-20 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto"></div>
                    <p class="mt-4 text-light text-lg font-medium">Memuat...</p>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <!-- Footer (Sederhana) -->
    <footer class="bg-dark-lighter border-t border-gray-800 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold">GC</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Glorious Computer</h3>
                        <p class="gradient-text text-sm">Solusi Teknologi</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Glorious Computer. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Menu Mobile
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('open');
                    menuToggle.classList.toggle('hamburger-active');
                });
            }

            // Toggle Menu Produk Mobile
            const mobileProductsToggle = document.getElementById('mobile-products-toggle');
            const mobileProductsMenu = document.getElementById('mobile-products-menu');
            const productsArrow = document.getElementById('products-arrow');
            
            if (mobileProductsToggle && mobileProductsMenu && productsArrow) {
                mobileProductsToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileProductsMenu.classList.toggle('open');
                    productsArrow.classList.toggle('rotate-180');
                });
            }

            // Tutup menu mobile ketika mengklik link
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.remove('open');
                    menuToggle.classList.remove('hamburger-active');
                    
                    if (mobileProductsMenu && mobileProductsMenu.classList.contains('open')) {
                        mobileProductsMenu.classList.remove('open');
                        productsArrow.classList.remove('rotate-180');
                    }
                });
            });

            // Efek scroll navbar
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('nav');
                if (window.scrollY > 20) {
                    nav.classList.add('shadow-lg', 'bg-dark/95');
                } else {
                    nav.classList.remove('shadow-lg', 'bg-dark/95');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>