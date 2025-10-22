<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Glorious Computer')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Animasi Fade-in -->
    <style>
        body { opacity: 0; transition: opacity 0.8s ease-in; }
        body.fade-in { opacity: 1; }
    </style>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>
<body class="bg-white text-gray-900 font-sans antialiased transition-colors duration-300 dark:bg-gray-900 dark:text-gray-100">

   {{-- 🔝 Navbar --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-md shadow-sm">
    <div class="flex items-center justify-between px-6 py-4 max-w-[1200px] mx-auto">

        {{-- 🏷 Logo + Text --}}
        <a href="{{ route('main.dashboard') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" 
                 alt="Glorious Computer" 
                 class="w-10 h-10 object-contain">
            <span class="text-xs font-semibold tracking-widest text-white leading-tight">
                GLORIOUS <br> COMPUTER
            </span>
        </a>

        {{-- 📌 Menu Desktop --}}
        <ul class="hidden md:flex space-x-8 text-sm font-light text-white">
            <li>
                <a href="{{ route('main.dashboard') }}" class="hover:underline">Home</a>
            </li>
            <li>
                <a href="{{ route('main.about.index') }}" class="hover:underline">About Us</a>
            </li>
            <li class="relative group cursor-pointer">
                <span class="flex items-center gap-1">
                    Items
                    <i class="fas fa-chevron-down text-xs"></i>
                </span>
                {{-- Dropdown --}}
                <ul class="absolute top-full left-0 mt-1 bg-black border border-gray-700 rounded shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-opacity text-xs min-w-[150px]">
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('items.category', $category->id) }}" 
                               class="block px-3 py-1 hover:bg-gray-800 text-white">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li>
                <a href="{{ route('main.services.index') }}" class="hover:underline">Services</a>
            </li>
        </ul>

        {{-- 📞 Contact Button --}}
        <a href="#kontak" class="hidden md:inline-block border border-white rounded-full px-5 py-1 text-xs font-light text-white hover:bg-white hover:text-black transition">
            Contact Us
        </a>
    </div>
</nav>


                    
                </div>
            </div>
        </div>
    </div>
</nav>


            {{-- 📱 Mobile Button --}}
<button id="menu-toggle" class="md:hidden text-gray-800 dark:text-gray-200 focus:outline-none">
    ☰
</button>
</div>

{{-- 📱 Mobile Menu --}}
<div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-900 shadow-md">
    <a href="{{ route('main.dashboard') }}" class="block px-4 py-2 hover:bg-orange-100 dark:hover:bg-gray-700">Home</a>
    <a href="{{ route('main.about.index') }}" class="block px-4 py-2 hover:bg-orange-100 dark:hover:bg-gray-700">About Us</a>
    <a href="{{ route('main.services.index') }}" class="block px-4 py-2 hover:bg-orange-100 dark:hover:bg-gray-700">Services</a>

    <div class="border-t my-2 border-gray-300 dark:border-gray-700"></div>

    {{-- 🔽 Loop kategori dari database --}}
    @isset($categories)
        @foreach($categories as $category)
            <a href="{{ route('items.category', $category->id) }}"
               class="block px-4 py-2 hover:bg-orange-100 dark:hover:bg-gray-700">
                {{ $category->name }}
            </a>
        @endforeach

        {{-- Tambahan menu "Lainnya" --}}
        <a href="{{ route('items.lainnya') }}"
           class="block px-4 py-2 hover:bg-orange-100 dark:hover:bg-gray-700">
           Lainnya
        </a>
    @endisset
</div>
</nav>

{{-- 📌 Konten --}}
<main>
    @yield('content')
</main>


{{-- ⚡ Footer --}}
<!-- Footer -->
    <footer class="bg-darker py-12 border-t border-gray-700">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Glorious Computer</h3>
                    <p class="text-gray-400 mb-4">
                        Solusi teknologi dan service terpercaya untuk komputer, laptop, dan perangkat elektronik.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors text-xl">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors text-xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors text-xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors text-xl">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Service Hardware</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Software & Installasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Konsultasi IT</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Perawatan Berkala</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-gray-400 hover:text-primary transition-colors">Tentang Kami</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-primary transition-colors">Layanan</a></li>
                        <li><a href="#produk" class="text-gray-400 hover:text-primary transition-colors">Produk</a></li>
                        <li><a href="#testimoni" class="text-gray-400 hover:text-primary transition-colors">Testimoni</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-primary transition-colors">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                            <span>Jl. Argandaru No.4, Bukateja, Purbalingga</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-primary"></i>
                            <span>0821-3380-3940</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-primary"></i>
                            <span>gloriouscomputer@email.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-500">
                <p>&copy; 2023 Glorious Computer. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- 🔧 JS --}}
    <script>
        // Mobile Menu
        document.getElementById("menu-toggle").addEventListener("click", () => {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });

        // Fade-in Effect
        window.addEventListener("load", () => {
            document.body.classList.add("fade-in");
        });
    </script>
</body>
</html>
