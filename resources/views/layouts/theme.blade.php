<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Glorious Computer')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#FF6B00',
                        'primary-dark': '#E05D00',
                        'primary-light': '#FF8C42',
                        dark: '#121212',
                        darker: '#0A0A0A',
                        light: '#F5F5F5',
                        gray: {
                            400: '#8A8A8A',
                            700: '#2A2A2A',
                            800: '#1A1A1A',
                            900: '#0A0A0A'
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- AlpineJS -->
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Animasi Fade-in */
        body { 
            opacity: 0; 
            transition: opacity 0.8s ease-in; 
            background-color: #0A0A0A;
            color: #F5F5F5;
        }
        body.fade-in { opacity: 1; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1A1A1A;
        }
        ::-webkit-scrollbar-thumb {
            background: #FF6B00;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #E05D00;
        }
        
        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease-in-out;
        }
        
        /* Hamburger Menu Animation */
        .hamburger-line {
            display: block;
            width: 24px;
            height: 2px;
            background-color: #F5F5F5;
            margin: 3px 0;
            transition: all 0.3s ease;
            transform-origin: center;
            border-radius: 1px;
        }

        /* Animasi saat aktif */
        .hamburger-active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger-active .hamburger-line:nth-child(2) {
            opacity: 0;
            transform: translateX(-10px);
        }

        .hamburger-active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        /* Mobile Menu Animation */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .mobile-menu.open {
            max-height: 500px;
        }
        
        .products-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .products-submenu.open {
            max-height: 300px;
        }
    </style>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @stack('styles')
</head>
<body class="bg-darker text-light font-sans antialiased">

    {{-- 🔝 Navbar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-darker/95 backdrop-blur-md border-b border-gray-700 shadow-lg">
        <div class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            
            {{-- 🏷 Logo + Text --}}
            <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-lg">GC</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-white font-bold text-lg leading-5">GLORIOUS</span>
                    <span class="text-primary font-semibold text-sm">COMPUTER</span>
                </div>
            </a>

            {{-- 📌 Menu Desktop --}}
            <div class="hidden lg:flex items-center space-x-8">
                <a href="{{ url('/') }}" 
                   class="text-light hover:text-primary font-medium transition-colors relative group">
                    Home
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all"></span>
                </a>
                
                <a href="{{ route('main.about.index') }}" 
                   class="text-light hover:text-primary font-medium transition-colors relative group">
                    About Us
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all"></span>
                </a>

               {{-- Items Dropdown --}}
                <div class="relative group" x-data="{ open: false }">
                    <button type="button" @click="open = !open" 
                            class="flex items-center space-x-1 text-light hover:text-primary font-medium transition-colors">
                        <span>Products</span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="absolute top-full left-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-xl py-2 z-50">
                        
                        {{-- Semua Produk di atas --}}
                        <a href="{{ route('main.products.index') }}" 
                           class="block px-4 py-2 text-sm text-light hover:bg-primary hover:text-white transition-colors font-medium">
                            <i class="fas fa-th-large mr-2"></i>Semua Produk
                        </a>
                        
                        <div class="border-t border-gray-700 my-1"></div>
                        
                        {{-- Kategori --}}
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories as $category)
                                <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}" 
                                   class="block px-4 py-2 text-sm text-light hover:bg-primary hover:text-white transition-colors">
                                    <i class="fas fa-folder mr-2"></i>{{ $category->name }}
                                </a>
                            @endforeach
                        @else
                            <div class="px-4 py-2 text-sm text-gray-400">
                                <i class="fas fa-exclamation-circle mr-2"></i>No categories
                            </div>
                        @endif
                    </div>
                </div>

                <a href="{{ route('main.services.index') }}" 
                   class="text-light hover:text-primary font-medium transition-colors relative group">
                    Services
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all"></span>
                </a>
                
                {{-- 📞 Contact Button Desktop --}}
                <a href="https://wa.me/6282133803940" 
                   target="_blank"
                   class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-full font-medium transition-all hover:scale-105 shadow-lg">
                    <i class="fab fa-whatsapp mr-2"></i>Contact Us
                </a>
            </div>

            {{-- 📱 Mobile Menu Button dengan Hamburger --}}
            <button id="menu-toggle" 
                    class="lg:hidden flex flex-col justify-center items-center w-10 h-10 focus:outline-none">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>

        {{-- 📱 Mobile Menu --}}
        <div id="mobile-menu" 
             class="lg:hidden mobile-menu bg-gray-800 border-t border-gray-700 shadow-xl">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ url('/') }}" 
                   class="flex items-center px-3 py-3 text-light hover:bg-primary hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-home mr-3 w-5 text-center"></i>Home
                </a>
                
                <a href="{{ route('main.about.index') }}" 
                   class="flex items-center px-3 py-3 text-light hover:bg-primary hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-info-circle mr-3 w-5 text-center"></i>About Us
                </a>

                {{-- Mobile Products Submenu --}}
                <div class="px-3 py-2">
                    <button id="mobile-products-toggle" 
                            class="flex items-center justify-between w-full text-light hover:text-primary transition-colors p-1 focus:outline-none">
                        <div class="flex items-center">
                            <i class="fas fa-box mr-3 w-5 text-center"></i>
                            <span class="font-medium">Products</span>
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" id="products-arrow"></i>
                    </button>
                    
                    <div id="mobile-products-menu" class="products-submenu pl-6 space-y-1 border-l-2 border-gray-700 ml-3 mt-2">
                        @isset($categories)
                            @foreach($categories as $category)
                                <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}" 
                                   class="flex items-center px-3 py-2 text-sm text-light hover:bg-primary hover:text-white rounded-lg transition-colors">
                                    <i class="fas fa-folder mr-2 w-4 text-center"></i>{{ $category->name }}
                                </a>
                            @endforeach
                        @endisset
                        <a href="{{ route('main.products.index') }}" 
                           class="flex items-center px-3 py-2 text-sm text-light hover:bg-primary hover:text-white rounded-lg transition-colors">
                            <i class="fas fa-th-large mr-2 w-4 text-center"></i>Semua Produk
                        </a>
                    </div>
                </div>

                <a href="{{ route('main.services.index') }}" 
                   class="flex items-center px-3 py-3 text-light hover:bg-primary hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-cogs mr-3 w-5 text-center"></i>Services
                </a>
                
                <div class="border-t border-gray-700 pt-3 mt-3">
                    <a href="https://wa.me/6282133803940" 
                       target="_blank"
                       class="flex items-center justify-center bg-primary hover:bg-primary-dark text-white px-4 py-3 rounded-lg font-medium transition-all">
                        <i class="fab fa-whatsapp mr-2"></i>Contact via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- 📌 Main Content --}}
    <main class="pt-20 min-h-screen">
        @yield('content')
    </main>

    {{-- ⚡ Footer --}}
    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                {{-- Company Info --}}
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">GC</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Glorious Computer</h3>
                            <p class="text-primary font-semibold">TECHNOLOGY SOLUTIONS</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Solusi teknologi dan service terpercaya untuk komputer, laptop, dan perangkat elektronik. 
                        Dengan pengalaman lebih dari 10 tahun melayani masyarakat Purbalingga dan sekitarnya.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-full flex items-center justify-center transition-colors group">
                            <i class="fab fa-facebook-f text-gray-400 group-hover:text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-full flex items-center justify-center transition-colors group">
                            <i class="fab fa-instagram text-gray-400 group-hover:text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-full flex items-center justify-center transition-colors group">
                            <i class="fab fa-twitter text-gray-400 group-hover:text-white"></i>
                        </a>
                        <a href="https://wa.me/6282133803940" 
                           target="_blank"
                           class="w-10 h-10 bg-gray-800 hover:bg-green-600 rounded-full flex items-center justify-center transition-colors group">
                            <i class="fab fa-whatsapp text-gray-400 group-hover:text-white"></i>
                        </a>
                    </div>
                </div>
                
                {{-- Services --}}
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Layanan</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('main.services.index') }}" class="text-gray-400 hover:text-primary transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Service Hardware
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('main.services.index') }}" class="text-gray-400 hover:text-primary transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Software & Installasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('main.services.index') }}" class="text-gray-400 hover:text-primary transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Konsultasi IT
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('main.services.index') }}" class="text-gray-400 hover:text-primary transition-colors flex items-center group">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform"></i>
                                Perawatan Berkala
                            </a>
                        </li>
                    </ul>
                </div>
                
                {{-- Contact Info --}}
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">Kontak</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                            <span>Jl. Argandaru No.4,<br>Bukateja, Purbalingga</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-primary"></i>
                            <a href="tel:082133803940" class="hover:text-primary transition-colors">0821-3380-3940</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary"></i>
                            <a href="mailto:gloriouscomputer@email.com" class="hover:text-primary transition-colors">gloriouscomputer@email.com</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-primary"></i>
                            <span>Buka: 08.00 - 17.00</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- Copyright --}}
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-500">
                    &copy; {{ date('Y') }} Glorious Computer. All rights reserved. | 
                    <span class="text-primary">Technology Solutions</span>
                </p>
            </div>
        </div>
    </footer>

    {{-- 🔧 JavaScript --}}
    <script>
        // Mobile Menu Toggle dengan Animasi Hamburger
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            
            console.log('Menu Toggle:', menuToggle);
            console.log('Mobile Menu:', mobileMenu);
            
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function() {
                    console.log('Menu toggle clicked');
                    mobileMenu.classList.toggle('open');
                    menuToggle.classList.toggle('hamburger-active');
                    console.log('Mobile Menu open:', mobileMenu.classList.contains('open'));
                    console.log('Hamburger active:', menuToggle.classList.contains('hamburger-active'));
                });
            }

            // Mobile Products Menu Toggle
            const mobileProductsToggle = document.getElementById('mobile-products-toggle');
            const mobileProductsMenu = document.getElementById('mobile-products-menu');
            const productsArrow = document.getElementById('products-arrow');
            
            if (mobileProductsToggle && mobileProductsMenu && productsArrow) {
                mobileProductsToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileProductsMenu.classList.toggle('open');
                    productsArrow.classList.toggle('fa-chevron-down');
                    productsArrow.classList.toggle('fa-chevron-up');
                });
            }

            // Tutup menu mobile ketika link diklik
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.remove('open');
                    menuToggle.classList.remove('hamburger-active');
                    
                    // Tutup products submenu jika terbuka
                    if (mobileProductsMenu && mobileProductsMenu.classList.contains('open')) {
                        mobileProductsMenu.classList.remove('open');
                        productsArrow.classList.remove('fa-chevron-up');
                        productsArrow.classList.add('fa-chevron-down');
                    }
                });
            });

            // Tutup menu mobile ketika klik di luar
            document.addEventListener('click', function(e) {
                if (menuToggle && mobileMenu) {
                    const isClickInsideMenu = mobileMenu.contains(e.target) || menuToggle.contains(e.target);
                    
                    if (!isClickInsideMenu && mobileMenu.classList.contains('open')) {
                        mobileMenu.classList.remove('open');
                        menuToggle.classList.remove('hamburger-active');
                        
                        // Tutup products submenu jika terbuka
                        if (mobileProductsMenu && mobileProductsMenu.classList.contains('open')) {
                            mobileProductsMenu.classList.remove('open');
                            productsArrow.classList.remove('fa-chevron-up');
                            productsArrow.classList.add('fa-chevron-down');
                        }
                    }
                }
            });
        });

        // Fade-in Effect
        window.addEventListener('load', function() {
            document.body.classList.add('fade-in');
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('bg-darker', 'shadow-lg');
            } else {
                nav.classList.remove('bg-darker', 'shadow-lg');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>