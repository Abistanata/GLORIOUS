{{-- resources/views/welcome.blade.php --}}
@extends('layouts.theme')

<main class="pt-16">
    @yield('content')
</main>
{{-- Hero Section --}}
<section class="relative w-full h-screen flex items-center justify-center bg-black overflow-hidden">
    <!-- Background Gradient -->
    <div class="absolute inset-0 bg-gradient-to-r from-black via-gray-900 to-black"></div>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-10">
        
        <!-- Text -->
        <div class="text-white max-w-xl animate-fadeIn flex flex-col gap-6">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-tight">
                Solusi <span class="text-orange-500">Teknologi</span> & <span class="text-orange-500">Service</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300">
                Partner terpercaya untuk kebutuhan komputer, laptop, dan service elektronik.  
                Kami hadir untuk mendukung bisnis & personal Anda dengan layanan profesional.
            </p>

            <!-- Tombol -->
            <div class="flex flex-wrap gap-4">
                {{-- Tombol ke halaman layanan --}}
                <a href="{{ route('main.services.index') }}" 
                   class="px-8 py-3 bg-orange-600 hover:bg-orange-700 rounded-full text-white font-semibold shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1">
                    🔧 Lihat Layanan
                </a>

                {{-- Tombol scroll ke kontak --}}
                <a href="#kontak" 
                   class="px-8 py-3 bg-white hover:bg-gray-200 rounded-full text-gray-900 font-semibold shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1">
                    📞 Hubungi Kami
                </a>
            </div>
        </div>

        <!-- Tech/Service Image -->
        <div class="relative w-full max-w-lg md:max-w-xl animate-slideUp">
            <img src="{{ asset('images/tech-service.png') }}" 
                 alt="Service Komputer & Laptop" 
                 class="w-full drop-shadow-2xl rounded-2xl transform hover:scale-105 transition duration-500">
        </div>
    </div>
</section>


<!-- Animations -->
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(60px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
    .animate-slideUp { animation: slideUp 1.2s ease-out forwards; }
</style>


  {{-- Tentang Kami --}}
<section id="about" class="py-20 bg-gray-900 text-center text-white">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl font-bold mb-6 animate-fadeIn">Tentang Kami</h2>
        <p class="text-gray-300 max-w-3xl mx-auto mb-12 animate-fadeIn delay-200">
            Glorious Computer berkomitmen memberikan solusi IT terpercaya untuk individu maupun bisnis.
        </p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ([['10+','Tahun Pengalaman'],['500+','Klien Puas'],['1000+','Produk Terjual'],['24/7','Support Aktif']] as $i => $stat)
            <div class="animate-fadeInUp delay-{{ $i * 200 }}">
                <h3 class="text-5xl font-extrabold text-orange-500">{{ $stat[0] }}</h3>
                <p class="text-gray-400">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Layanan --}}
<section id="services" class="py-20 bg-gray-800 text-center text-white">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl font-bold mb-12 animate-fadeIn">Layanan Kami</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach (['Service Hardware', 'Software & Installasi', 'Konsultasi IT'] as $i => $service)
            <div class="p-8 bg-gray-900 border border-gray-700 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 hover:bg-gray-700 animate-fadeInUp delay-{{ $i * 200 }}">
                <h3 class="text-2xl font-bold mb-4 text-orange-500">{{ $service }}</h3>
                <p class="text-gray-300">Kami memberikan layanan {{ strtolower($service) }} dengan kualitas terbaik.</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Produk --}}
<section id="produk" class="py-20 bg-gray-900">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl font-bold mb-12 text-center text-white animate-fadeIn">Produk Kami</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach (range(1,6) as $i)
            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-md hover:shadow-xl transition p-4 animate-fadeInUp delay-{{ $i * 150 }}">
                <div class="overflow-hidden rounded-lg mb-4">
                    <img src="{{ asset('images/produk'.$i.'.jpg') }}" 
                         class="w-full h-48 object-cover transform hover:scale-110 transition duration-500" 
                         alt="Produk {{ $i }}">
                </div>
                <h3 class="text-xl font-bold text-white">Produk {{ $i }}</h3>
                <p class="text-gray-400 mb-4">Deskripsi singkat produk {{ $i }}.</p>
                <div class="flex justify-between items-center">
                    <span class="text-orange-500 font-bold">Rp{{ number_format(100000 * $i,0,',','.') }}</span>
                    <a href="#" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">Beli</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimoni --}}
<section id="testimoni" class="py-20 bg-gray-800 text-center text-white">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl font-bold mb-12 animate-fadeIn">Apa Kata Mereka</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach (['Andi', 'Budi', 'Citra'] as $i => $customer)
            <div class="p-6 bg-gray-900 border border-gray-700 rounded-2xl shadow hover:shadow-xl transition transform hover:-translate-y-2 animate-fadeInUp delay-{{ $i * 200 }}">
                <p class="italic text-gray-300 mb-4">
                    "Pelayanan {{ $customer }} sangat memuaskan, produk berkualitas tinggi."
                </p>
                <h3 class="font-bold text-orange-500">— {{ $customer }}</h3>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Hero Section Kontak --}}
<section id="kontak" class="relative bg-black bg-opacity-90">
    <img src="https://storage.googleapis.com/a1aa/image/9756410f-18e9-4ecc-2f5c-d40ee294007f.jpg"
         alt="Background gelap dengan perangkat komputer"
         class="w-full h-48 md:h-72 object-cover object-center opacity-30 absolute inset-0 -z-10">
    <div class="max-w-[1200px] mx-auto px-6 py-16 md:py-24 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">Hubungi Kami</h1>
        <nav class="mt-3 text-xs font-light text-gray-300 flex justify-center space-x-2 select-none">
            <span>Home</span>
            <span>/</span>
            <span>Kontak</span>
        </nav>
    </div>
</section>

{{-- Section Kontak --}}
<section class="w-full bg-gradient-to-r from-gray-900 to-black py-16">
    <main class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 text-white">
        {{-- Form Kontak --}}
        <section class="bg-[#1f1f1f] p-8 rounded-md max-w-md mx-auto md:mx-0">
            <h2 class="text-gray-400 text-sm font-semibold mb-1">Kontak Kami</h2>
            <h3 class="text-3xl font-extrabold mb-6 leading-tight">Kirim Pesan</h3>
            <form action="#" method="POST" class="space-y-4">
                <input type="text" placeholder="Nama Anda..."
                       class="w-full bg-[#2a2a2a] border border-[#3a3a3a] rounded px-3 py-2 text-sm text-gray-300 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <input type="email" placeholder="example@email.com"
                       class="w-full bg-[#2a2a2a] border border-[#3a3a3a] rounded px-3 py-2 text-sm text-gray-300 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <textarea rows="5" placeholder="Tulis pesan anda..."
                          class="w-full bg-[#2a2a2a] border border-[#3a3a3a] rounded px-3 py-2 text-sm text-gray-300 placeholder:text-gray-500 resize-none focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                <button type="submit"
                        class="w-full border border-orange-500 rounded-full py-2 text-sm font-semibold hover:bg-orange-500 hover:text-black transition">
                    Kirim Sekarang
                </button>
            </form>
        </section>

        {{-- Info Kontak --}}
        <section class="space-y-6 max-w-md mx-auto md:mx-0">
            <p class="text-sm text-gray-300 leading-relaxed">
                Kami siap membantu kebutuhan IT, servis, maupun pembelian perangkat komputer Anda.
            </p>
            <div class="grid grid-cols-2 gap-6 text-sm">
                <div class="flex flex-col items-center text-center space-y-1">
                    <i class="fas fa-phone-alt text-lg"></i>
                    <span class="font-semibold">Telepon</span>
                    <span>0821-3380-3940</span>
                </div>
                <div class="flex flex-col items-center text-center space-y-1">
                    <i class="fas fa-envelope text-lg"></i>
                    <span class="font-semibold">Email</span>
                    <span>gloriouscomputer@email.com</span>
                </div>
                <div class="flex flex-col items-center text-center space-y-2">
    <i class="fab fa-whatsapp text-2xl text-green-500"></i>
    <span class="font-semibold">WhatsApp</span>
    <a href="https://wa.me/6282133803940" target="_blank"
       class="inline-block px-5 py-2 rounded-full bg-green-500 text-white font-semibold shadow-md hover:bg-green-600 hover:shadow-lg hover:scale-105 transition transform duration-200 ease-in-out">
        Chat Sekarang
    </a>
</div>

                <div class="flex flex-col items-center text-center space-y-1">
                    <i class="fas fa-map-marker-alt text-lg"></i>
                    <span class="font-semibold">Alamat</span>
                    <span>Jl. Argandaru No.4, Bukateja, Purbalingga</span>
                </div>
            </div>
            <div class="mt-4">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.0596510563556!2d109.4235094749978!3d-7.006158792999033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e656ff33b6e6d8b%3A0x6fa8848c2db925cd!2sNo%204%2C%20Jl.%20Argandaru%2C%20Dusun%205%2C%20Bukateja%2C%20Kabupaten%20Purbalingga%2C%20Jawa%20Tengah%2053382!5e0!3m2!1sid!2sid!4v1693380000000!5m2!1sid!2sid" 
                    class="w-full h-56 rounded-md border-0 shadow-md"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
        </section>
    </main>
</section>


{{-- CTA Section --}}
<section class="relative w-full h-48 md:h-56 lg:h-64 bg-transparent overflow-hidden">

    <!-- Background -->
    <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
     alt="Background laptop"
     class="absolute inset-0 w-full h-full object-cover object-center blur-sm -z-5">


    <!-- Overlay dengan blur -->
    <div class="absolute inset-0 bg-transparant/50 backdrop-blur-md -z-10"></div>

    <!-- Content -->
    <div class="relative flex flex-col items-center justify-center h-full text-center text-white px-6">
        <p class="text-xs text-gray-300 mb-1">Siap Melayani</p>
        <h2 class="text-xl md:text-2xl font-extrabold leading-tight mb-4">
            Glorious Computer Selalu Siap Membantu Anda
        </h2>
        <a href="https://wa.me/6282133803940" target="_blank"
           class="bg-orange-500 text-black rounded-full px-6 py-2 text-sm font-semibold hover:bg-orange-600 transition">
            Hubungi via WhatsApp
        </a>
    </div>
</section>
