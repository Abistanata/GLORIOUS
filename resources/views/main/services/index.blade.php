@extends('layouts.theme')

@section('content')
<div class="min-h-screen bg-dark">
    <!-- Hero Section -->
    <section class="relative overflow-hidden py-32 px-4">
        <div class="absolute inset-0 bg-gradient-to-br from-dark via-dark-lighter to-dark opacity-90"></div>
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary/5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto max-w-6xl relative z-10">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-heading font-bold mb-6 leading-tight">
                    <span class="gradient-text">Layanan Unggulan</span>
                    <br>
                    <span class="text-light">Untuk Teknologi Anda</span>
                </h1>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto mb-10 leading-relaxed">
                    Solusi teknologi terpercaya dengan pengalaman lebih dari 20 tahun dalam perbaikan komputer, 
                    upgrade hardware, instalasi software, dan layanan IT komprehensif.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-5xl mx-auto mt-16">
                    <div class="bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 hover:border-primary/30 transition-all duration-300 hover:scale-105">
                        <div class="text-3xl font-bold gradient-text mb-2">10+</div>
                        <div class="text-gray-400 text-sm">Tahun Pengalaman</div>
                    </div>
                    <div class="bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 hover:border-primary/30 transition-all duration-300 hover:scale-105">
                        <div class="text-3xl font-bold gradient-text mb-2">500+</div>
                        <div class="text-gray-400 text-sm">Klien Puas</div>
                    </div>
                    <div class="bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 hover:border-primary/30 transition-all duration-300 hover:scale-105">
                        <div class="text-3xl font-bold gradient-text mb-2">1000+</div>
                        <div class="text-gray-400 text-sm">Perangkat Diperbaiki</div>
                    </div>
                    <div class="bg-dark-light/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 hover:border-primary/30 transition-all duration-300 hover:scale-105">
                        <div class="text-3xl font-bold gradient-text mb-2">24/7</div>
                        <div class="text-gray-400 text-sm">Support Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-20 px-4 bg-dark-lighter">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-heading font-bold mb-4 text-light">
                    Layanan <span class="gradient-text">Profesional</span> Kami
                </h2>
                <p class="text-lg text-gray-400 max-w-3xl mx-auto">
                    Setiap layanan kami didesain untuk memberikan solusi tepat sesuai kebutuhan teknologi Anda
                </p>
            </div>

            <!-- Service Cards -->
            <div class="space-y-12">
                <!-- Service 1: PC & Laptop -->
                <div id="service-pc-laptop" class="bg-dark rounded-3xl overflow-hidden border border-gray-800 hover:border-primary/30 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        <div class="p-10 lg:p-14 flex flex-col justify-center">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-glow">
                                    <i class="fas fa-laptop-code text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-light font-heading">Servis PC & Laptop</h3>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-primary font-semibold">›</span>
                                        <span class="text-gray-400">Solusi lengkap untuk semua merk</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-400 mb-8 text-lg leading-relaxed">
                                Layanan perbaikan dan perawatan menyeluruh untuk PC dan laptop dari semua merk. 
                                Tim teknisi berpengalaman siap mendiagnosis dan memperbaiki masalah hardware dan software.
                            </p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Diagnosa Hardware</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Penggantian Sparepart</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Perbaikan Motherboard</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Optimasi Performa</span>
                                </div>
                            </div>
                            
                            <a href="#kontak" class="inline-flex items-center gap-3 bg-gradient-primary hover:shadow-glow-primary text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 w-fit group">
                                <i class="fab fa-whatsapp text-xl"></i>
                                Konsultasi Sekarang
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                        
                        <div class="relative min-h-[400px] lg:min-h-[500px] bg-gradient-to-br from-dark to-dark-lighter flex items-center justify-center p-8">
                            <div class="relative z-10">
                               <img src="{{ asset('images/laptop.jpg') }}" 
     alt="Servis Printer"
     class="rounded-2xl shadow-2xl w-full h-full object-cover"
     onerror="this.onerror=null;this.src='https://images.pexels.com/photos/879109/pexels-photo-879109.jpeg?auto=compress&cs=tinysrgb&w=800'">
                            <div class="absolute inset-0 bg-gradient-to-r from-dark/0 via-dark/50 to-dark/80"></div>
                        </div>
                    </div>
                </div>

                <!-- Service 2: Upgrade Hardware -->
                <div id="service-upgrade-hardware" class="bg-dark rounded-3xl overflow-hidden border border-gray-800 hover:border-primary/30 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        <div class="relative min-h-[400px] lg:min-h-[500px] bg-gradient-to-br from-dark to-dark-lighter flex items-center justify-center p-8 order-2 lg:order-1">
                            <div class="relative z-10">
                                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                     alt="Upgrade Hardware"
                                     class="rounded-2xl shadow-2xl">
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-l from-dark/0 via-dark/50 to-dark/80"></div>
                        </div>
                        
                        <div class="p-10 lg:p-14 flex flex-col justify-center order-1 lg:order-2">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-glow">
                                    <i class="fas fa-microchip text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-light font-heading">Upgrade Hardware</h3>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-primary font-semibold">›</span>
                                        <span class="text-gray-400">Tingkatkan performa perangkat Anda</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-400 mb-8 text-lg leading-relaxed">
                                Upgrade komponen hardware untuk meningkatkan performa dan produktivitas. 
                                Dari upgrade RAM, SSD, hingga instalasi VGA terbaru untuk kebutuhan gaming dan desain.
                            </p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Upgrade SSD</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Tambah RAM</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Kartu Grafis (VGA)</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Custom Build PC</span>
                                </div>
                            </div>
                            
                            <a href="#kontak" class="inline-flex items-center gap-3 bg-gradient-primary hover:shadow-glow-primary text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 w-fit group">
                                <i class="fab fa-whatsapp text-xl"></i>
                                Konsultasi Sekarang
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Service 3: Servis Printer -->
                <div id="service-printer" class="bg-dark rounded-3xl overflow-hidden border border-gray-800 hover:border-primary/30 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        <div class="p-10 lg:p-14 flex flex-col justify-center">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-glow">
                                    <i class="fas fa-print text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-light font-heading">Servis Printer</h3>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-primary font-semibold">›</span>
                                        <span class="text-gray-400">Semua jenis printer - hasil maksimal</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-400 mb-8 text-lg leading-relaxed">
                                Servis lengkap untuk semua jenis printer: inkjet, laserjet, dot matrix. 
                                Kembalikan performa printer Anda dengan hasil cetak yang optimal dan konsisten.
                            </p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Perbaikan Hasil Cetak</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Reset Counter</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Paper Jam & Roller</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Pembersihan Head</span>
                                </div>
                            </div>
                            
                            <a href="#kontak" class="inline-flex items-center gap-3 bg-gradient-primary hover:shadow-glow-primary text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 w-fit group">
                                <i class="fab fa-whatsapp text-xl"></i>
                                Konsultasi Sekarang
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                        
                        <div class="relative min-h-[400px] lg:min-h-[500px] bg-gradient-to-br from-dark to-dark-lighter flex items-center justify-center p-8">
                            <div class="relative z-10">
                               <img src="{{ asset('images/printer-service.jpg') }}" 
     alt="Servis Printer"
     class="rounded-2xl shadow-2xl w-full h-full object-cover"
     onerror="this.onerror=null;this.src='https://images.pexels.com/photos/879109/pexels-photo-879109.jpeg?auto=compress&cs=tinysrgb&w=800'">
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-r from-dark/0 via-dark/50 to-dark/80"></div>
                        </div>
                    </div>
                </div>

                <!-- Service 4: Install Software -->
                <div id="service-software" class="bg-dark rounded-3xl overflow-hidden border border-gray-800 hover:border-primary/30 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        <div class="relative min-h-[400px] lg:min-h-[500px] bg-gradient-to-br from-dark to-dark-lighter flex items-center justify-center p-8 order-2 lg:order-1">
                            <div class="relative z-10">
                               <img src="{{ asset('images/software.jpg') }}" 
     alt="Servis Printer"
     class="rounded-2xl shadow-2xl w-full h-full object-cover"
     onerror="this.onerror=null;this.src='https://images.pexels.com/photos/879109/pexels-photo-879109.jpeg?auto=compress&cs=tinysrgb&w=800'">
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-l from-dark/0 via-dark/50 to-dark/80"></div>
                        </div>
                        
                        <div class="p-10 lg:p-14 flex flex-col justify-center order-1 lg:order-2">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-glow">
                                    <i class="fas fa-download text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-light font-heading">Install Software</h3>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-primary font-semibold">›</span>
                                        <span class="text-gray-400">Semua kebutuhan aplikasi</span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-400 mb-8 text-lg leading-relaxed">
                                Instalasi berbagai software sesuai kebutuhan, mulai dari sistem operasi, 
                                aplikasi produktivitas, hingga software khusus untuk desain dan multimedia.
                            </p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Sistem Operasi</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Office & Produktivitas</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Desain & Multimedia</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check text-primary text-sm"></i>
                                    </div>
                                    <span class="text-light">Keamanan & Antivirus</span>
                                </div>
                            </div>
                            
                            <a href="#kontak" class="inline-flex items-center gap-3 bg-gradient-primary hover:shadow-glow-primary text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 w-fit group">
                                <i class="fab fa-whatsapp text-xl"></i>
                                Konsultasi Sekarang
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="py-20 px-4 bg-dark">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-heading font-bold mb-4 text-light">
                    Proses Layanan <span class="gradient-text">Terstandar</span>
                </h2>
                <p class="text-lg text-gray-400 max-w-3xl mx-auto">
                    Kami mengikuti proses yang sistematis untuk memastikan kualitas terbaik
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-12 left-0 right-0 h-0.5 bg-gradient-to-r from-primary via-primary/50 to-primary/20 z-0"></div>
                
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-glow">
                        <i class="fas fa-comments text-3xl text-white"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-light mb-2">Konsultasi</div>
                        <p class="text-gray-400">Diskusikan kebutuhan dan masalah perangkat Anda</p>
                    </div>
                </div>
                
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-glow">
                        <i class="fas fa-search text-3xl text-white"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-light mb-2">Diagnosa</div>
                        <p class="text-gray-400">Analisa mendalam untuk identifikasi masalah</p>
                    </div>
                </div>
                
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-glow">
                        <i class="fas fa-tools text-3xl text-white"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-light mb-2">Perbaikan</div>
                        <p class="text-gray-400">Proses perbaikan dengan standar kualitas terbaik</p>
                    </div>
                </div>
                
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-glow">
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-light mb-2">Garansi</div>
                        <p class="text-gray-400">Testing menyeluruh dengan garansi layanan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-20 px-4 bg-dark-lighter">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-heading font-bold mb-4 text-light">
                    Konsultasi <span class="gradient-text">Gratis</span>
                </h2>
                <p class="text-lg text-gray-400 max-w-3xl mx-auto">
                    Tim ahli kami siap membantu Anda. Hubungi kami untuk konsultasi tanpa biaya
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div class="space-y-8">
                    <div class="bg-dark rounded-2xl p-8 border border-gray-800">
                        <h3 class="text-2xl font-bold text-light mb-6">Informasi Kontak</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone-alt text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-light mb-1">Telepon</h4>
                                    <a href="tel:082133803940" class="text-gray-400 hover:text-primary transition-colors text-lg">0821-3380-3940</a>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fab fa-whatsapp text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-light mb-1">WhatsApp</h4>
                                    <a href="https://wa.me/6282133803940" target="_blank" 
                                       class="inline-flex items-center gap-2 text-gray-400 hover:text-primary transition-colors text-lg group">
                                        Chat Sekarang
                                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-light mb-1">Lokasi</h4>
                                    <p class="text-gray-400">Jl. Argandaru No.4, Bukateja, Purbalingga</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-light mb-1">Jam Operasional</h4>
                                    <p class="text-gray-400">Senin - Sabtu: 08:00 - 17:00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="bg-dark rounded-2xl p-8 border border-gray-800">
                        <h3 class="text-2xl font-bold text-light mb-6">Layanan Cepat</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#service-pc-laptop" class="bg-dark-light hover:bg-primary/10 rounded-xl p-4 flex items-center gap-3 group transition-all">
                                <i class="fas fa-laptop-code text-primary group-hover:scale-110 transition-transform"></i>
                                <span class="text-light group-hover:text-primary">PC & Laptop</span>
                            </a>
                            <a href="#service-upgrade-hardware" class="bg-dark-light hover:bg-primary/10 rounded-xl p-4 flex items-center gap-3 group transition-all">
                                <i class="fas fa-microchip text-primary group-hover:scale-110 transition-transform"></i>
                                <span class="text-light group-hover:text-primary">Upgrade Hardware</span>
                            </a>
                            <a href="#service-printer" class="bg-dark-light hover:bg-primary/10 rounded-xl p-4 flex items-center gap-3 group transition-all">
                                <i class="fas fa-print text-primary group-hover:scale-110 transition-transform"></i>
                                <span class="text-light group-hover:text-primary">Printer</span>
                            </a>
                            <a href="#service-software" class="bg-dark-light hover:bg-primary/10 rounded-xl p-4 flex items-center gap-3 group transition-all">
                                <i class="fas fa-download text-primary group-hover:scale-110 transition-transform"></i>
                                <span class="text-light group-hover:text-primary">Software</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="bg-dark rounded-2xl p-8 border border-gray-800">
                    <h3 class="text-2xl font-bold text-light mb-6">Kirim Pesan</h3>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-400 mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full bg-dark-light border border-gray-800 rounded-xl px-4 py-3 text-light focus:outline-none focus:border-primary transition-colors" placeholder="Masukkan nama Anda">
                            </div>
                            <div>
                                <label class="block text-gray-400 mb-2">Nomor Telepon</label>
                                <input type="tel" class="w-full bg-dark-light border border-gray-800 rounded-xl px-4 py-3 text-light focus:outline-none focus:border-primary transition-colors" placeholder="0821-xxx-xxxx">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-400 mb-2">Email</label>
                            <input type="email" class="w-full bg-dark-light border border-gray-800 rounded-xl px-4 py-3 text-light focus:outline-none focus:border-primary transition-colors" placeholder="email@contoh.com">
                        </div>
                        
                        <div>
                            <label class="block text-gray-400 mb-2">Layanan yang Dibutuhkan</label>
                            <select class="w-full bg-dark-light border border-gray-800 rounded-xl px-4 py-3 text-light focus:outline-none focus:border-primary transition-colors">
                                <option value="">Pilih layanan</option>
                                <option value="pc-laptop">Servis PC & Laptop</option>
                                <option value="upgrade">Upgrade Hardware</option>
                                <option value="printer">Servis Printer</option>
                                <option value="software">Install Software</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-400 mb-2">Pesan</label>
                            <textarea rows="4" class="w-full bg-dark-light border border-gray-800 rounded-xl px-4 py-3 text-light focus:outline-none focus:border-primary transition-colors" placeholder="Jelaskan kebutuhan Anda secara detail"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-primary hover:shadow-glow-primary text-white py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 bg-gradient-to-r from-dark via-dark-lighter to-dark">
        <div class="container mx-auto max-w-4xl text-center">
            <div class="bg-dark/50 backdrop-blur-sm rounded-3xl p-12 border border-gray-800">
                <h2 class="text-4xl md:text-5xl font-heading font-bold mb-6 text-light">
                    Siap Membantu <span class="gradient-text">Teknologi Anda</span>
                </h2>
                <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Percayakan perangkat teknologi Anda pada ahlinya. 
                    Dapatkan solusi terbaik dengan garansi dan layanan purna jual terjamin.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/6282133803940" target="_blank" rel="noopener noreferrer"
                       class="bg-gradient-primary hover:shadow-glow-primary text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 flex items-center justify-center gap-3">
                        <i class="fab fa-whatsapp text-xl"></i>
                        Hubungi via WhatsApp
                    </a>
                    <a href="tel:082133803940" 
                       class="bg-dark-light hover:bg-primary/10 border border-gray-800 hover:border-primary/30 text-light px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:scale-105 flex items-center justify-center gap-3">
                        <i class="fas fa-phone-alt"></i>
                        Telepon Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    // Smooth scroll to sections
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

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe service cards
    document.querySelectorAll('.service-card').forEach(card => {
        observer.observe(card);
    });
</script>
@endpush
@endsection