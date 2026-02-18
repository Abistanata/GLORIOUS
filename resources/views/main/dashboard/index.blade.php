@extends('layouts.theme')

@section('title', 'Home - Glorious Computer | Solusi Teknologi Premium')

@section('content')

{{-- HERO --}}
<section class="relative min-h-screen flex items-center overflow-hidden bg-dark-800 pt-20" id="hero">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-primary-500 opacity-10 blur-3xl rounded-full"></div>
        <div class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-primary-400 opacity-5 blur-3xl rounded-full"></div>
    </div>
    <div class="absolute inset-0 opacity-5 pointer-events-none"
         style="background-image: linear-gradient(rgba(255,107,0,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,107,0,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            {{-- LEFT --}}
            <div class="space-y-8"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 100)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-1 translate-y-0">

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                    </span>
                    <span class="text-sm font-medium text-primary-300">Service &amp; Jual Komputer Terpercaya</span>
                </div>

                <div class="space-y-4">
                    <h1 class="font-heading font-extrabold text-white leading-tight tracking-tight">
                        <span class="block text-5xl sm:text-6xl lg:text-7xl">Solusi Lengkap</span>
                        <span class="block text-5xl sm:text-6xl lg:text-7xl mt-2">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 via-primary-500 to-primary-600">
                                Komputer Anda
                            </span>
                        </span>
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl">
                        Service PC, laptop &amp; printer profesional. Jual laptop dan PC bekas berkualitas tinggi
                        dengan harga terbaik dan garansi terpercaya di Purbalingga.
                    </p>
                </div>

                <div class="flex flex-wrap gap-6 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg bg-primary-500/10 flex items-center justify-center">
                            <i class="fas fa-tools text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-white font-semibold">Expert</p>
                            <p class="text-gray-500 text-xs">Teknisi Berpengalaman</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg bg-primary-500/10 flex items-center justify-center">
                            <i class="fas fa-laptop text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-white font-semibold">500+</p>
                            <p class="text-gray-500 text-xs">Unit Terjual</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg bg-primary-500/10 flex items-center justify-center">
                            <i class="fas fa-shield-alt text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-white font-semibold">Garansi</p>
                            <p class="text-gray-500 text-xs">Setiap Pembelian</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('main.products.index') }}"
                       class="group relative inline-flex items-center justify-center px-8 py-4 font-semibold text-white overflow-hidden rounded-xl transition-all duration-300 ease-out hover:scale-105">
                        <span class="absolute inset-0 bg-gradient-to-r from-primary-600 via-primary-500 to-primary-600 bg-[length:200%_100%] transition-all duration-300 group-hover:bg-[length:100%_100%]"></span>
                        <span class="relative flex items-center gap-2">
                            <i class="fas fa-laptop"></i>
                            Lihat Produk
                            <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                    <a href="https://wa.me/6282133803940" target="_blank"
                       class="group inline-flex items-center justify-center px-8 py-4 font-semibold text-gray-300 bg-dark-700 border border-dark-500 rounded-xl hover:border-green-500/50 hover:bg-dark-600 transition-all duration-300">
                        <i class="fab fa-whatsapp mr-2 text-green-400 text-lg"></i>
                        Hubungi via WhatsApp
                        <i class="fas fa-external-link-alt ml-2 text-xs opacity-60"></i>
                    </a>
                </div>
            </div>

            {{-- RIGHT: service card visual --}}
            <div class="relative"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 300)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-700 delay-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-1 scale-100 translate-y-0">

                <div class="relative animate-float">
                    <div class="relative bg-gradient-to-br from-dark-700 to-dark-800 rounded-3xl p-6 border border-dark-500 shadow-2xl">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-primary-600 to-primary-400 rounded-3xl blur opacity-20 transition duration-500"></div>
                        <div class="relative space-y-4">

                            {{-- Store header --}}
                            <div class="flex items-center gap-3 pb-4 border-b border-dark-500">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center">
                                    <i class="fas fa-store text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-white font-bold text-sm">Glorious Computer</p>
                                    <p class="text-gray-500 text-xs">Bukateja, Purbalingga, Jawa Tengah</p>
                                </div>
                                <div class="ml-auto flex items-center gap-1">
                                    <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                                    <span class="text-green-400 text-xs font-medium">Buka</span>
                                </div>
                            </div>

                            {{-- Service PC & Laptop --}}
                            <div class="flex items-center gap-4 bg-dark-900/60 rounded-xl p-4 border border-dark-600 hover:border-primary-500/30 transition-colors">
                                <div class="w-12 h-12 rounded-xl bg-primary-500/15 border border-primary-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-laptop-medical text-primary-400 text-xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-semibold text-sm">Service PC &amp; Laptop</p>
                                    <p class="text-gray-500 text-xs truncate">Diagnosa, ganti part, install ulang Windows,Linux DLL</p>
                                </div>
                               
                            </div>

                            {{-- Service Printer --}}
                            <div class="flex items-center gap-4 bg-dark-900/60 rounded-xl p-4 border border-dark-600 hover:border-blue-500/30 transition-colors">
                                <div class="w-12 h-12 rounded-xl bg-blue-500/15 border border-blue-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-print text-blue-400 text-xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-semibold text-sm">Service Printer</p>
                                    <p class="text-gray-500 text-xs truncate">Servis &amp; isi ulang tinta / toner</p>
                                </div>
                                
                            </div>

                            {{-- Jual Beli --}}
                            <div class="flex items-center gap-4 bg-dark-900/60 rounded-xl p-4 border border-dark-600 hover:border-green-500/30 transition-colors">
                                <div class="w-12 h-12 rounded-xl bg-green-500/15 border border-green-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exchange-alt text-green-400 text-xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-semibold text-sm">Jual Laptop &amp; PC Bekas</p>
                                    <p class="text-gray-500 text-xs truncate">Berkualitas, bergaransi, harga fair</p>
                                </div>
                              
                            </div>

                            {{-- Hardware --}}
                            <div class="flex items-center gap-4 bg-dark-900/60 rounded-xl p-4 border border-dark-600 hover:border-yellow-500/30 transition-colors">
                                <div class="w-12 h-12 rounded-xl bg-yellow-500/15 border border-yellow-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-microchip text-yellow-400 text-xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-semibold text-sm">Jual Hardware &amp; Aksesoris</p>
                                    <p class="text-gray-500 text-xs truncate">RAM, SSD, keyboard, mouse, dll</p>
                                </div>
                               
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -right-4 animate-float" style="animation-delay:0.5s;">
                        <div class="bg-dark-700 border border-dark-500 rounded-xl p-3 shadow-xl backdrop-blur-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-yellow-500/20 flex items-center justify-center">
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-white text-xs font-bold">20 Tahun</p>
                                    <p class="text-gray-500 text-xs">Berpengalaman</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <a href="#stats" class="flex flex-col items-center gap-2 text-gray-500 hover:text-primary-400 transition-colors">
            <span class="text-xs font-medium">Scroll untuk lanjut</span>
            <i class="fas fa-chevron-down text-sm"></i>
        </a>
    </div>
</section>

{{-- STATISTICS --}}
<section class="py-24 bg-gradient-to-b from-dark-800 via-dark-700/30 to-dark-800 relative overflow-hidden" id="stats">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-primary-400/5 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-300 text-sm font-medium mb-4">
                <i class="fas fa-chart-line"></i> Dipercaya Ribuan Customer
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">Angka Bicara Lebih Keras</h2>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Kepercayaan pelanggan adalah bukti nyata komitmen kami dalam memberikan produk dan layanan terbaik
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

            <div class="group"
                 x-data="{ show:false, count:0 }"
                 x-intersect="show=true; let t=500,d=2000,s=0,i=t/(d/16),r=setInterval(()=>{s+=i;count=Math.floor(s);if(s>=t){count=t;clearInterval(r);}},16);"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-600 delay-100"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-1 scale-100 translate-y-0">
                <div class="relative p-10 bg-gradient-to-br from-dark-700/60 to-dark-800/80 backdrop-blur-lg border border-primary-500/10 rounded-2xl text-center transition-all duration-300 hover:border-primary-500/30 hover:-translate-y-3">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-primary-500/10 border border-primary-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-laptop text-4xl text-primary-400"></i>
                    </div>
                    <div class="text-5xl font-extrabold mb-3 gradient-text" x-text="count+'+'"></div>
                    <div class="text-lg font-semibold text-white mb-2">Unit Terjual</div>
                    <div class="text-sm text-gray-500">Laptop &amp; PC bekas berkualitas</div>
                    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-primary-500 to-transparent opacity-0 group-hover:opacity-50 transition-opacity"></div>
                </div>
            </div>

            <div class="group"
                 x-data="{ show:false, count:0 }"
                 x-intersect="show=true; let t=1000,d=2000,s=0,i=t/(d/16),r=setInterval(()=>{s+=i;count=Math.floor(s);if(s>=t){count=t;clearInterval(r);}},16);"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-600 delay-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-1 scale-100 translate-y-0">
                <div class="relative p-10 bg-gradient-to-br from-dark-700/60 to-dark-800/80 backdrop-blur-lg border border-green-500/10 rounded-2xl text-center transition-all duration-300 hover:border-green-500/30 hover:-translate-y-3">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-green-500/10 border border-green-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-4xl text-green-400"></i>
                    </div>
                    <div class="text-5xl font-extrabold mb-3 bg-gradient-to-r from-green-400 to-green-500 bg-clip-text text-transparent" x-text="count+'+'"></div>
                    <div class="text-lg font-semibold text-white mb-2">Customer Puas</div>
                    <div class="text-sm text-gray-500 flex items-center justify-center gap-1">
                        <i class="fas fa-star text-yellow-400 text-xs"></i> 5 star reviews
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-green-500 to-transparent opacity-0 group-hover:opacity-50 transition-opacity"></div>
                </div>
            </div>

            <div class="group"
                 x-data="{ show:false, count:0 }"
                 x-intersect="show=true; let t=5,d=2000,s=0,i=t/(d/16),r=setInterval(()=>{s+=i;count=Math.floor(s);if(s>=t){count=t;clearInterval(r);}},16);"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-600 delay-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-1 scale-100 translate-y-0">
                <div class="relative p-10 bg-gradient-to-br from-dark-700/60 to-dark-800/80 backdrop-blur-lg border border-blue-500/10 rounded-2xl text-center transition-all duration-300 hover:border-blue-500/30 hover:-translate-y-3">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-clock text-4xl text-blue-400"></i>
                    </div>
                    <div class="text-5xl font-extrabold mb-3 bg-gradient-to-r from-blue-400 to-blue-500 bg-clip-text text-transparent" x-text="count+'+'"></div>
                    <div class="text-lg font-semibold text-white mb-2">Tahun Pengalaman</div>
                    <div class="text-sm text-gray-500 flex items-center justify-center gap-1">
                        <i class="fas fa-calendar text-xs"></i> Since 2019
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-0 group-hover:opacity-50 transition-opacity"></div>
                </div>
            </div>

            <div class="group"
                 x-data="{ show:false, count:0 }"
                 x-intersect="show=true; let t=99,d=2000,s=0,i=t/(d/16),r=setInterval(()=>{s+=i;count=Math.floor(s);if(s>=t){count=t;clearInterval(r);}},16);"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-600 delay-400"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                 x-transition:enter-end="opacity-1 scale-100 translate-y-0">
                <div class="relative p-10 bg-gradient-to-br from-dark-700/60 to-dark-800/80 backdrop-blur-lg border border-yellow-500/10 rounded-2xl text-center transition-all duration-300 hover:border-yellow-500/30 hover:-translate-y-3">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-award text-4xl text-yellow-400"></i>
                    </div>
                    <div class="text-5xl font-extrabold mb-3 bg-gradient-to-r from-yellow-400 to-yellow-500 bg-clip-text text-transparent" x-text="count+'%'"></div>
                    <div class="text-lg font-semibold text-white mb-2">Satisfaction Rate</div>
                    <div class="text-sm text-gray-500 flex items-center justify-center gap-1">
                        <i class="fas fa-check-circle text-xs"></i> Verified ratings
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-yellow-500 to-transparent opacity-0 group-hover:opacity-50 transition-opacity"></div>
                </div>
            </div>
        </div>

        <div class="mt-16 pt-12 border-t border-gray-700/50">
            <div class="flex flex-wrap justify-center items-center gap-8 opacity-60 hover:opacity-100 transition-opacity duration-300">
                <div class="flex items-center gap-2 text-gray-400">
                    <i class="fas fa-shield-alt text-primary-400 text-xl"></i>
                    <span class="text-sm font-medium">Garansi Toko</span>
                </div>
                <div class="w-px h-6 bg-gray-700"></div>
                <div class="flex items-center gap-2 text-gray-400">
                    <i class="fas fa-tools text-green-400 text-xl"></i>
                    <span class="text-sm font-medium">Teknisi Berpengalaman</span>
                </div>
                <div class="w-px h-6 bg-gray-700"></div>
                <div class="flex items-center gap-2 text-gray-400">
                    <i class="fas fa-exchange-alt text-blue-400 text-xl"></i>
                    <span class="text-sm font-medium">Beli &amp; Jual Unit Bekas</span>
                </div>
                <div class="w-px h-6 bg-gray-700"></div>
                <div class="flex items-center gap-2 text-gray-400">
                    <i class="fas fa-tags text-purple-400 text-xl"></i>
                    <span class="text-sm font-medium">Harga Transparan</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SERVICES --}}
<section class="py-24 bg-dark-800" id="services">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-300 text-sm font-medium mb-4">
                Layanan Kami
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">Apa yang Kami Kerjakan</h2>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Spesialis service perangkat komputer dan jual laptop serta PC bekas berkualitas tinggi
            </p>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-8">

            <div class="group hover-lift bg-gradient-to-br from-dark-700 to-dark-800 rounded-2xl p-8 border border-dark-500 transition-all duration-300">
                <div class="w-16 h-16 rounded-xl bg-primary-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-laptop-medical text-3xl text-primary-400"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Service PC &amp; Laptop</h3>
                <p class="text-gray-400 mb-5 leading-relaxed text-sm">
                    Perbaikan hardware &amp; software, ganti komponen rusak, install ulang OS, upgrade RAM &amp; SSD, hingga pembersihan menyeluruh.
                </p>
                <a href="https://wa.me/6282133803940" target="_blank"
                   class="inline-flex items-center gap-2 text-primary-400 hover:text-primary-300 font-semibold group-hover:gap-3 transition-all text-sm">
                    Jadwalkan Service <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="group hover-lift bg-gradient-to-br from-dark-700 to-dark-800 rounded-2xl p-8 border border-dark-500 transition-all duration-300">
                <div class="w-16 h-16 rounded-xl bg-blue-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-print text-3xl text-blue-400"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Service Printer</h3>
                <p class="text-gray-400 mb-5 leading-relaxed text-sm">
                    Servis printer segala merek &amp; tipe, isi ulang tinta &amp; toner, perbaikan paper jam, head cleaning, penggantian spare part.
                </p>
                <a href="https://wa.me/6282133803940" target="_blank"
                   class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 font-semibold group-hover:gap-3 transition-all text-sm">
                    Hubungi Sekarang <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="group hover-lift bg-gradient-to-br from-dark-700 to-dark-800 rounded-2xl p-8 border border-dark-500 transition-all duration-300">
                <div class="w-16 h-16 rounded-xl bg-green-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-exchange-alt text-3xl text-green-400"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Jual  Laptop &amp; PC Bekas</h3>
                <p class="text-gray-400 mb-5 leading-relaxed text-sm">
                    Laptop dan PC bekas berkualitas yang sudah dicek menyeluruh dan bergaransi toko. Kami juga menerima pembelian unit bekas Anda.
                </p>
                <a href="{{ route('main.products.index') }}"
                   class="inline-flex items-center gap-2 text-green-400 hover:text-green-300 font-semibold group-hover:gap-3 transition-all text-sm">
                    Lihat Produk <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="group hover-lift bg-gradient-to-br from-dark-700 to-dark-800 rounded-2xl p-8 border border-dark-500 transition-all duration-300">
                <div class="w-16 h-16 rounded-xl bg-yellow-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-microchip text-3xl text-yellow-400"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Hardware &amp; Aksesoris</h3>
                <p class="text-gray-400 mb-5 leading-relaxed text-sm">
                    Tersedia berbagai komponen &amp; aksesoris: RAM, SSD, HDD, keyboard, mouse, kabel, dan perlengkapan komputer lainnya.
                </p>
                <a href="{{ route('main.products.index') }}"
                   class="inline-flex items-center gap-2 text-yellow-400 hover:text-yellow-300 font-semibold group-hover:gap-3 transition-all text-sm">
                    Lihat Produk <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="py-24 bg-gradient-to-b from-dark-800 to-dark-700" id="products">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-300 text-sm font-medium mb-4">
                Produk Unggulan
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">Koleksi Terbaru Kami</h2>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Laptop dan PC bekas pilihan, sudah melalui pengecekan menyeluruh dan bergaransi
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @php
                $featuredProducts = \App\Models\Product::with(['category', 'reviews'])
                    ->where('is_active', true)
                    ->where('current_stock', '>', 0)
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            @endphp

            @forelse($featuredProducts as $product)
            <div class="group hover-lift bg-dark-800 rounded-2xl overflow-hidden border border-dark-500 transition-all duration-300">
                <div class="relative h-56 bg-dark-900 overflow-hidden">
                    @if($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image))
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-laptop text-6xl text-gray-700"></i>
                        </div>
                    @endif
                    @if($product->has_discount)
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                -{{ $product->discount_percentage }}%
                            </span>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 {{ $product->current_stock > 0 ? 'bg-green-500' : 'bg-red-500' }} text-white text-xs font-semibold rounded-full">
                            {{ $product->current_stock > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-2">
                        <span class="text-xs text-primary-400 font-medium">{{ $product->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 line-clamp-2">{{ $product->name }}</h3>
                    
                    {{-- Rating Display --}}
                    @php
                        $avgRating = $product->average_rating ?? 0;
                        $reviewCount = $product->review_count ?? 0;
                        $fullStars = floor($avgRating);
                        $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                    @endphp
                    @if($reviewCount > 0)
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullStars)
                                        <i class="fas fa-star text-xs text-yellow-400"></i>
                                    @elseif($i == $fullStars + 1 && $hasHalfStar)
                                        <i class="fas fa-star-half-alt text-xs text-yellow-400"></i>
                                    @else
                                        <i class="far fa-star text-xs text-gray-600"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-400">
                                ({{ number_format($avgRating, 1) }} • {{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }})
                            </span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="far fa-star text-xs text-gray-600"></i>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500">Belum ada review</span>
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        @if($product->has_discount)
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-bold text-primary-500">Rp {{ number_format($product->final_price, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500 line-through">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <span class="text-2xl font-bold text-primary-500">Rp {{ number_format($product->final_price ?? $product->selling_price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    <a href="{{ route('main.products.show', $product->id) }}"
                       class="block w-full py-3 text-center bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white rounded-xl font-semibold transition-all duration-300 group-hover:shadow-lg group-hover:shadow-primary-500/30">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16">
                <i class="fas fa-box-open text-6xl text-gray-700 mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada produk tersedia</p>
            </div>
            @endforelse
        </div>

        <div class="text-center">
            <a href="{{ route('main.products.index') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-dark-700 hover:bg-dark-600 border border-dark-500 hover:border-primary-500/50 text-white rounded-xl font-semibold transition-all duration-300">
                Lihat Semua Produk <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- TENTANG KAMI — id="tentang" untuk link navbar --}}
<section class="py-24 bg-dark-800" id="tentang">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <div class="space-y-8">
                <div>
                    <span class="inline-block px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-300 text-sm font-medium mb-4">
                        Tentang Kami
                    </span>
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-5 leading-tight">
                        Kenapa Memilih
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-primary-600">Glorious Computer?</span>
                    </h2>
                    <p class="text-gray-400 leading-relaxed text-lg">
                        Kami adalah toko komputer yang berdiri sejak 2003 di Bukateja, Purbalingga, Jawa Tengah. Spesialisasi kami adalah service PC, laptop, dan printer serta jual beli laptop dan PC bekas berkualitas tinggi.
                    </p>
                    <p class="text-gray-400 leading-relaxed mt-4">
                        Setiap unit bekas yang kami jual telah melalui pengecekan menyeluruh oleh teknisi berpengalaman, sehingga Anda mendapatkan perangkat andal dengan harga yang sepadan.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-primary-500/10 border border-primary-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-user-check text-primary-400"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Teknisi Berpengalaman</h4>
                            <p class="text-gray-500 text-sm">Lebih dari 20 tahun menangani berbagai kerusakan PC, laptop, dan printer.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-green-500/10 border border-green-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-shield-alt text-green-400"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Semua Unit Bergaransi</h4>
                            <p class="text-gray-500 text-sm">Setiap produk bekas disertai garansi toko untuk ketenangan pikiran Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-search text-yellow-400"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Pengecekan Menyeluruh</h4>
                            <p class="text-gray-500 text-sm">Hardware, baterai, layar, dan performa setiap unit dicek sebelum dijual.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-hand-holding-usd text-blue-400"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Harga Jujur &amp; Transparan</h4>
                            <p class="text-gray-500 text-sm">Harga service dan jual beli selalu dikomunikasikan di awal tanpa biaya tersembunyi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div class="bg-gradient-to-br from-primary-500/10 to-primary-600/5 border border-primary-500/20 rounded-2xl p-7 flex flex-col items-center text-center">
                    <i class="fas fa-laptop-medical text-primary-400 text-4xl mb-4"></i>
                    <p class="text-4xl font-extrabold text-white mb-1">500+</p>
                    <p class="text-gray-400 text-sm">Perangkat Diservice</p>
                </div>
                <div class="bg-gradient-to-br from-green-500/10 to-green-600/5 border border-green-500/20 rounded-2xl p-7 flex flex-col items-center text-center">
                    <i class="fas fa-exchange-alt text-green-400 text-4xl mb-4"></i>
                    <p class="text-4xl font-extrabold text-white mb-1">500+</p>
                    <p class="text-gray-400 text-sm">Unit Terjual</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-2xl p-7 flex flex-col items-center text-center">
                    <i class="fas fa-print text-blue-400 text-4xl mb-4"></i>
                    <p class="text-4xl font-extrabold text-white mb-1">200+</p>
                    <p class="text-gray-400 text-sm">Printer Diservice</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-500/10 to-yellow-600/5 border border-yellow-500/20 rounded-2xl p-7 flex flex-col items-center text-center">
                    <i class="fas fa-users text-yellow-400 text-4xl mb-4"></i>
                    <p class="text-4xl font-extrabold text-white mb-1">1000+</p>
                    <p class="text-gray-400 text-sm">Customer Puas</p>
                </div>
                <div class="col-span-2 bg-dark-700 border border-dark-500 rounded-2xl p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-500/10 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-primary-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white font-semibold">Lokasi Kami</p>
                        <p class="text-gray-400 text-sm">No 4 (Depan BRI, Jl. Argandaru, Dusun 5, Bukateja, Kec. Bukateja, Kabupaten Purbalingga, Jawa Tengah 53382</p>
                    </div>
                    <a href="https://maps.app.goo.gl/ScH5X7Do9pVwroRV8" target="_blank"
  class="ml-auto flex-shrink-0 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-lg text-green-400 text-sm font-medium hover:bg-green-500/20 transition-colors">
  <i class="fas fa-map-marker-alt mr-1"></i> Buka Maps
</a>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- REVIEWS SECTION --}}
@if(isset($reviews) && $reviews->count() > 0)
<section class="py-24 bg-dark-800" id="reviews">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-300 text-sm font-medium mb-4">
                Testimoni Customer
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-5 leading-tight">
                Apa Kata
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-primary-600">Customer Kami?</span>
            </h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Ulasan jujur dari customer yang sudah menggunakan layanan dan produk kami
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($reviews as $review)
                <div class="bg-gray-900/60 rounded-2xl border border-gray-700/80 p-6 hover:border-primary-500/50 transition-all duration-300">
                    <div class="flex items-start gap-4 mb-4">
                        {{-- User Avatar --}}
                        <div class="flex-shrink-0">
                            @if($review->user && $review->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $review->user->profile_photo_path) }}" 
                                     alt="{{ $review->user->name }}"
                                     class="w-12 h-12 rounded-full object-cover border-2 border-primary-500/30">
                            @else
                                <div class="w-12 h-12 rounded-full bg-primary-500/20 flex items-center justify-center border-2 border-primary-500/30">
                                    <i class="fas fa-user text-primary-400 text-lg"></i>
                                </div>
                            @endif
                        </div>

                        {{-- User Info & Rating --}}
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-white font-semibold">
                                    {{ $review->user ? $review->user->name : 'Anonim' }}
                                </h4>
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($review->product)
                                <p class="text-xs text-gray-500 mb-2">
                                    <i class="fas fa-box text-primary-400"></i> {{ $review->product->name }}
                                </p>
                            @endif
                            <p class="text-xs text-gray-500">
                                {{ $review->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Review Comment --}}
                    @if($review->comment)
                        <p class="text-gray-300 leading-relaxed text-sm line-clamp-3">
                            "{{ Str::limit($review->comment, 150) }}"
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- View All Reviews Link --}}
        @if($reviews->count() > 0)
        <div class="text-center mt-10">
            <a href="{{ route('main.products.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500/10 hover:bg-primary-500/20 border border-primary-500/30 text-primary-300 rounded-xl font-semibold transition-all duration-300">
                Lihat Semua Review
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endif
    </div>
</section>
@endif

{{-- CTA BANNER --}}
<section class="py-20 bg-gradient-to-r from-primary-600 via-primary-500 to-primary-600 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">Ada yang Perlu Diservice atau Dibeli?</h2>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Hubungi kami sekarang untuk info ketersediaan produk dan jadwal service perangkat Anda
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('main.products.index') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white hover:bg-gray-100 text-primary-600 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-laptop"></i> Lihat Produk
            </a>
            <a href="https://wa.me/6282133803940" target="_blank"
               class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-transparent hover:bg-white/10 border-2 border-white text-white rounded-xl font-bold transition-all duration-300">
                <i class="fab fa-whatsapp"></i> Chat via WhatsApp
            </a>
        </div>
    </div>
</section>

{{-- CONTACT --}}
<section class="py-24 bg-dark-800" id="contact">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-300 text-sm font-medium mb-4">
                Hubungi Kami
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">Kontak &amp; Lokasi</h2>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Kunjungi toko kami atau hubungi via WhatsApp untuk info produk dan jadwal service
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-dark-700 rounded-2xl p-8 border border-dark-500">
                    <h3 class="text-xl font-bold text-white mb-6">Kirim Pesan</h3>
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-400 text-sm mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full px-4 py-3 rounded-lg bg-dark-800 border border-dark-500 text-white focus:border-primary-500 focus:outline-none transition-colors" placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-gray-400 text-sm mb-2">Nomor WhatsApp</label>
                                <input type="text" class="w-full px-4 py-3 rounded-lg bg-dark-800 border border-dark-500 text-white focus:border-primary-500 focus:outline-none transition-colors" placeholder="08xxx">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Keperluan</label>
                            <select class="w-full px-4 py-3 rounded-lg bg-dark-800 border border-dark-500 text-white focus:border-primary-500 focus:outline-none transition-colors">
                                <option value="">Pilih keperluan...</option>
                                <option>Service PC / Laptop</option>
                                <option>Service Printer</option>
                                <option>Beli Laptop / PC Bekas</option>
                                <option>Jual Laptop / PC Bekas Saya</option>
                                <option>Beli Hardware / Aksesoris</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Pesan</label>
                            <textarea rows="4" class="w-full px-4 py-3 rounded-lg bg-dark-800 border border-dark-500 text-white focus:border-primary-500 focus:outline-none transition-colors resize-none" placeholder="Deskripsikan kebutuhan atau kerusakan perangkat Anda..."></textarea>
                        </div>
                        <button type="submit"
                                class="w-full py-4 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-400 hover:to-red-400 text-white rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-orange-500/30 hover:-translate-y-0.5 active:translate-y-0">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-dark-700 rounded-2xl p-6 border border-dark-500">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-primary-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-primary-400 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-1">Alamat Toko</h4>
                            <p class="text-gray-400 text-sm">No 4 (Depan BRI, Jl. Argandaru, Dusun 5, Bukateja, Kec. Bukateja, Kabupaten Purbalingga, Jawa Tengah 53382</p>
                        </div>
                    </div>
                </div>
                <div class="bg-dark-700 rounded-2xl p-6 border border-dark-500">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-green-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-green-400 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-1">WhatsApp</h4>
                            <a href="https://wa.me/6282133803940" target="_blank" class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">+62 821-3380-3940</a>
                            <p class="text-gray-500 text-xs mt-1">Respon cepat via chat</p>
                        </div>
                    </div>
                </div>
                <div class="bg-dark-700 rounded-2xl p-6 border border-dark-500">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-blue-400 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-1">Email</h4>
                            <a href="mailto:glorious0326@gmail.com" class="text-blue-400 hover:text-blue-300 text-sm transition-colors">glorious0326@gmail.com</a>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-primary-500/10 to-primary-600/5 rounded-2xl p-6 border border-primary-500/20">
                    <h4 class="font-bold text-white mb-3">
                        <i class="fas fa-clock text-primary-400 mr-2"></i> Jam Operasional
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Senin – Jumat</span>
                            <span class="text-white font-medium">09:00 – 17:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Sabtu</span>
                            <span class="text-white font-medium">09:00 – 15:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Minggu</span>
                            <span class="text-red-400 font-medium">Tutup</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush