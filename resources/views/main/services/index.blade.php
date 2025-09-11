@extends('layouts.theme')

@section('content')
    {{-- Hero Section --}}
    <section class="relative w-full h-[80vh] flex items-center justify-center bg-black overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-gray-900 to-black"></div>

        <div class="relative z-10 container mx-auto px-6 lg:px-12 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight">
                Layanan <span class="text-orange-500">Profesional</span> Kami
            </h1>
            <p class="mt-6 text-lg md:text-xl text-gray-300 max-w-2xl mx-auto">
                Kami menyediakan berbagai layanan untuk komputer, laptop, dan kebutuhan teknologi Anda.  
                Ditangani oleh tim ahli dengan standar profesional.
            </p>
        </div>
    </section>

    {{-- Our Services Section --}}
    <section class="py-20 bg-gradient-to-b from-black via-gray-900 to-black">
        <div class="container mx-auto px-6 lg:px-12">
            <h2 class="text-4xl font-bold text-center text-white mb-4">Our Services</h2>
            <p class="text-center text-gray-400 mb-12 max-w-2xl mx-auto">
                Kami hadir untuk memberikan solusi terbaik untuk segala kebutuhan teknologi Anda.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Card --}}
                <div class="bg-gray-900 p-6 rounded-xl shadow-md hover:bg-gray-800 transition">
                    <img src="{{ asset('images/service1.jpg') }}" class="w-full h-40 object-cover rounded-md mb-4" alt="Service 1">
                    <h3 class="text-xl font-semibold mb-2 text-white">Service Laptop & PC</h3>
                    <p class="text-gray-400 mb-4">Perbaikan dan perawatan laptop & komputer semua merk.</p>
                    <a href="#" class="text-orange-500 font-semibold hover:underline">Lihat Layanan →</a>
                </div>

                <div class="bg-gray-900 p-6 rounded-xl shadow-md hover:bg-gray-800 transition">
                    <img src="{{ asset('images/service2.jpg') }}" class="w-full h-40 object-cover rounded-md mb-4" alt="Service 2">
                    <h3 class="text-xl font-semibold mb-2 text-white">Install Software</h3>
                    <p class="text-gray-400 mb-4">Instalasi software original, update sistem, dan konfigurasi.</p>
                    <a href="#" class="text-orange-500 font-semibold hover:underline">Lihat Layanan →</a>
                </div>

                <div class="bg-gray-900 p-6 rounded-xl shadow-md hover:bg-gray-800 transition">
                    <img src="{{ asset('images/service3.jpg') }}" class="w-full h-40 object-cover rounded-md mb-4" alt="Service 3">
                    <h3 class="text-xl font-semibold mb-2 text-white">Perbaikan Printer</h3>
                    <p class="text-gray-400 mb-4">Servis printer inkjet & laserjet, ganti sparepart, dan cleaning.</p>
                    <a href="#" class="text-orange-500 font-semibold hover:underline">Lihat Layanan →</a>
                </div>

                <div class="bg-gray-900 p-6 rounded-xl shadow-md hover:bg-gray-800 transition">
                    <img src="{{ asset('images/service4.jpg') }}" class="w-full h-40 object-cover rounded-md mb-4" alt="Service 4">
                    <h3 class="text-xl font-semibold mb-2 text-white">Networking</h3>
                    <p class="text-gray-400 mb-4">Pemasangan jaringan LAN & WiFi untuk rumah & kantor.</p>
                    <a href="#" class="text-orange-500 font-semibold hover:underline">Lihat Layanan →</a>
                </div>

                <div class="bg-gray-900 p-6 rounded-xl shadow-md hover:bg-gray-800 transition">
                    <img src="{{ asset('images/service5.jpg') }}" class="w-full h-40 object-cover rounded-md mb-4" alt="Service 5">
                    <h3 class="text-xl font-semibold mb-2 text-white">Upgrade Hardware</h3>
                    <p class="text-gray-400 mb-4">Upgrade RAM, SSD, VGA, dan komponen lainnya.</p>
                    <a href="#" class="text-orange-500 font-semibold hover:underline">Lihat Layanan →</a>
                </div>

                <div class="bg-gray-900 p-6 rounded-xl shadow-md hover:bg-gray-800 transition">
                    <img src="{{ asset('images/service6.jpg') }}" class="w-full h-40 object-cover rounded-md mb-4" alt="Service 6">
                    <h3 class="text-xl font-semibold mb-2 text-white">Konsultasi IT</h3>
                    <p class="text-gray-400 mb-4">Konsultasi solusi IT sesuai kebutuhan bisnis & personal.</p>
                    <a href="#" class="text-orange-500 font-semibold hover:underline">Lihat Layanan →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="py-20 bg-gradient-to-r from-black via-gray-900 to-black text-white text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ada masalah dengan perangkat Anda?</h2>
        <p class="mb-6 text-lg text-gray-300">Hubungi kami sekarang, tim kami siap membantu Anda dengan cepat & profesional.</p>
        <a href="#kontak" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 rounded-full font-semibold shadow-lg transition">📞 Hubungi Kami</a>
    </section>
@endsection
