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
                <a href="{{ route('about') }}" class="hover:underline">About Us</a>
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
    <a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-orange-100 dark:hover:bg-gray-700">About Us</a>
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
<footer class="bg-[#1a1a1a] py-12 mt-0">
   <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 text-xs text-gray-400">
        {{-- Company Info --}}
        <div class="space-y-4">
            <div class="flex items-center space-x-2">
                <img src="images/logo.png" 
                     alt="Glorious Computer Logo" 
                     class="w-10 h-10 object-contain">
                <span class="text-xs font-semibold tracking-widest leading-tight text-white">
                    GLORIOUS <br> COMPUTER
                </span>
            </div>
            <p class="leading-relaxed">
                Solusi perangkat komputer, printer, dan aksesoris terbaik dengan harga terjangkau.
            </p>
            <div class="flex space-x-4 text-white">
                <a href="#" aria-label="Facebook" class="hover:text-gray-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" aria-label="Instagram" class="hover:text-gray-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" aria-label="WhatsApp" class="hover:text-gray-300">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>

        {{-- Navigation --}}
        <div>
            <h3 class="font-semibold mb-4 text-white">Navigasi</h3>
            <ul class="space-y-2">
                {{-- 🔽 Loop kategori dari database --}}
               
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('items.category', $category->id) }}" class="hover:text-white">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                    

                <li><a href="{{ route('main.services.index') }}" class="hover:text-white">Layanan</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-white">Kontak</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <h3 class="font-semibold mb-4 text-white">Hubungi Kami</h3>
            <ul class="space-y-3">
                <li class="flex items-center space-x-3">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Jl. Argandaru No.4, Bukateja, Purbalingga</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fab fa-whatsapp"></i>
                    <span>+62 821-3380-3940</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fas fa-envelope"></i>
                    <span>support@gloriouscomputer.com</span>
                </li>
            </ul>
        </div>
    </div>

    <p class="text-center text-gray-500 text-[10px] mt-12 select-none">
        © {{ date('Y') }} Glorious Computer | All Rights Reserved
    </p>
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
