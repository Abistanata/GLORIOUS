@extends('layouts.theme')

@section('title', 'Tentang Kami - Glorious Computer')

@push('styles')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        }

        :root {
            --primary: #FF6B00;
            --primary-dark: #E05D00;
            --primary-light: #FF8C42;
            --secondary: #2D3748;
            --dark: #121212;
            --darker: #0A0A0A;
            --light: #F5F5F5;
            --gray: #8A8A8A;
            --gray-light: #2A2A2A;
            --accent: #00D4FF;
            --card-dark: #171717;
            --card-light: #1E1E1E;
        }

        body {
            background-color: var(--darker);
            color: var(--light);
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Hero Section - Minimalist Version */
        .hero-minimalist {
            min-height: 80vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 80px;
            background: linear-gradient(135deg, #0A0A0A 0%, #141414 100%);
            overflow: hidden;
        }

        .hero-minimalist::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 107, 0, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 107, 0, 0.03) 0%, transparent 50%);
        }

        .hero-content-minimalist {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
            padding: 80px 0;
        }

        .hero-minimalist h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 24px;
            line-height: 1.1;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #FFFFFF 0%, #E0E0E0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-minimalist h1 span {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-minimalist p {
            font-size: 1.3rem;
            color: #B0B0B0;
            margin-bottom: 48px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.8;
            font-weight: 400;
            letter-spacing: 0.02em;
        }

        /* Section Styles */
        section {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 900;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
            background: linear-gradient(135deg, #FFFFFF 0%, #D0D0D0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 2px;
        }

        .section-subtitle {
            color: #B0B0B0;
            font-size: 1.15rem;
            max-width: 700px;
            margin: 24px auto 0;
            line-height: 1.7;
            font-weight: 400;
        }

        /* Story Section */
        #story {
            background: linear-gradient(135deg, #0A0A0A 0%, #161616 100%);
            position: relative;
        }

        #story::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 107, 0, 0.2) 50%, 
                transparent 100%);
        }

        .story-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .story-text h2 {
            font-size: 2.2rem;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #FFFFFF 0%, #CCCCCC 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: -0.01em;
        }

        .story-text p {
            margin-bottom: 24px;
            color: #C8C8C8;
            line-height: 1.8;
            font-size: 1.1rem;
            font-weight: 400;
        }

        .stats-minimalist {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        .stat-item-minimalist {
            background: linear-gradient(135deg, var(--card-dark) 0%, var(--card-light) 100%);
            padding: 30px 20px;
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .stat-item-minimalist:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 107, 0, 0.3);
            box-shadow: 0 15px 40px rgba(255, 107, 0, 0.15);
        }

        .stat-number-minimalist {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            margin-bottom: 8px;
            letter-spacing: -0.03em;
        }

        .stat-label-minimalist {
            color: #A0A0A0;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .story-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        .story-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .story-image:hover img {
            transform: scale(1.05);
        }

        /* Values Section */
        .values-section {
            background: linear-gradient(135deg, #121212 0%, #1C1C1C 100%);
            position: relative;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .value-card {
            background: linear-gradient(135deg, var(--card-dark) 0%, var(--card-light) 100%);
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 107, 0, 0.15), 
                transparent);
            transition: left 0.8s;
        }

        .value-card:hover::before {
            left: 100%;
        }

        .value-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 60px rgba(255, 107, 0, 0.2);
            border-color: rgba(255, 107, 0, 0.3);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, 
                rgba(255, 107, 0, 0.15) 0%, 
                rgba(255, 140, 66, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            border: 1px solid rgba(255, 107, 0, 0.2);
            transition: all 0.4s;
        }

        .value-card:hover .value-icon {
            background: linear-gradient(135deg, 
                rgba(255, 107, 0, 0.25) 0%, 
                rgba(255, 140, 66, 0.2) 100%);
            border-color: rgba(255, 107, 0, 0.4);
            transform: scale(1.1);
        }

        .value-icon i {
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .value-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #FFFFFF 0%, #E0E0E0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: -0.01em;
        }

        .value-description {
            color: #B8B8B8;
            line-height: 1.7;
            font-size: 1rem;
            font-weight: 400;
        }

        /* Philosophy Section */
        .philosophy-section {
            background: linear-gradient(135deg, #0A0A0A 0%, #141414 100%);
            position: relative;
        }

        .philosophy-content {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .philosophy-content p {
            font-size: 1.2rem;
            color: #C8C8C8;
            line-height: 1.8;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .philosophy-quote {
            margin-top: 50px;
            padding: 40px;
            background: linear-gradient(135deg, var(--card-dark) 0%, var(--card-light) 100%);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .philosophy-quote::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 4rem;
            color: var(--primary);
            opacity: 0.2;
            font-family: Georgia, serif;
        }

        .quote-text {
            font-size: 1.3rem;
            color: #E0E0E0;
            line-height: 1.8;
            font-style: italic;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .quote-author {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* CTA Section */
        .cta-section-minimalist {
            background: linear-gradient(135deg, #0A0A0A 0%, #121212 100%);
            text-align: center;
            padding: 100px 0;
            position: relative;
        }

        .cta-section-minimalist::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 107, 0, 0.3) 50%, 
                transparent 100%);
        }

        .cta-section-minimalist h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #FFFFFF 0%, #E0E0E0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: -0.01em;
        }

        .cta-section-minimalist p {
            font-size: 1.2rem;
            color: #B0B0B0;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
            font-weight: 400;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 16px 40px;
            border-radius: 30px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            border: none;
            box-shadow: 0 8px 30px rgba(255, 107, 0, 0.3);
            font-size: 1.1rem;
            letter-spacing: 0.02em;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #D95300 100%);
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(255, 107, 0, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            padding: 16px 40px;
            border-radius: 30px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 1.1rem;
            letter-spacing: 0.02em;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-minimalist h1 {
                font-size: 2.8rem;
            }
            
            .story-content {
                grid-template-columns: 1fr;
                gap: 50px;
            }
            
            .values-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }
            
            .section-title {
                font-size: 2.4rem;
            }
        }

        @media (max-width: 768px) {
            .hero-minimalist {
                min-height: 70vh;
            }
            
            .hero-minimalist h1 {
                font-size: 2.4rem;
            }
            
            .hero-minimalist p {
                font-size: 1.1rem;
            }
            
            .values-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-minimalist {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-primary, .btn-secondary {
                width: 250px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-minimalist h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .value-card {
                padding: 30px 20px;
            }
        }

        /* Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endpush

@section('content')
<div class="bg-darker text-light">
    <!-- Hero Section - Minimalist -->
    <section class="hero-minimalist">
        <div class="container">
            <div class="hero-content-minimalist fade-in">
                <h1>Mengenal <span>Glorious Computer</span></h1>
                <p>Sebagai mitra teknologi terpercaya di Purbalingga sejak 2005, kami menghadirkan solusi komprehensif untuk setiap kebutuhan digital Anda. Pengalaman dan dedikasi adalah inti dari setiap layanan yang kami berikan.</p>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section id="story">
        <div class="container">
            <div class="section-header fade-in">
                <h2 class="section-title">Perjalanan & Komitmen</h2>
                <p class="section-subtitle">Dari bengkel kecil menjadi pusat solusi teknologi terpercaya di Purbalingga</p>
            </div>
            
            <div class="story-content">
                <div class="story-text fade-in">
                    <h2>Visi yang Berkelanjutan</h2>
                    <p>Glorious Computer didirikan dengan visi tunggal: menjadi penyedia solusi teknologi yang paling dipercaya di wilayah Purbalingga. Berawal dari workshop sederhana di Jl. Argandaru, kami telah tumbuh melalui komitmen pada kualitas dan kepuasan pelanggan.</p>
                    <p>Setiap tahun, kami terus berinvestasi dalam pelatihan teknisi dan teknologi terbaru untuk memastikan solusi yang kami berikan selalu relevan dan efektif. Dedikasi ini telah membawa kami ke posisi terdepan dalam layanan komputer dan printer di wilayah ini.</p>
                    
                    <div class="stats-minimalist">
                        <div class="stat-item-minimalist fade-in">
                            <span class="stat-number-minimalist">10+</span>
                            <span class="stat-label-minimalist">Tahun Pengalaman</span>
                        </div>
                        <div class="stat-item-minimalist fade-in">
                            <span class="stat-number-minimalist">500+</span>
                            <span class="stat-label-minimalist">Klien Terlayani</span>
                        </div>
                        <div class="stat-item-minimalist fade-in">
                            <span class="stat-number-minimalist">24/7</span>
                            <span class="stat-label-minimalist">Support Teknis</span>
                        </div>
                        <div class="stat-item-minimalist fade-in">
                            <span class="stat-number-minimalist">100%</span>
                            <span class="stat-label-minimalist">Garansi Layanan</span>
                        </div>
                    </div>
                </div>
                
                <div class="story-image fade-in">
                    <img src="https://images.unsplash.com/photo-1565688534245-05d6b5be184a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Workshop Glorious Computer">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header fade-in">
                <h2 class="section-title">Pilar Utama Kami</h2>
                <p class="section-subtitle">Prinsip-prinsip yang membedakan layanan kami dalam industri teknologi</p>
            </div>
            
            <div class="values-grid">
                <div class="value-card fade-in">
                    <div class="value-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3 class="value-title">Kualitas Premium</h3>
                    <p class="value-description">Kami hanya menggunakan komponen original dan menerapkan standar perbaikan tertinggi. Setiap unit yang kami tangani mendapatkan perlakuan terbaik sesuai spesifikasi pabrikan.</p>
                </div>
                
                <div class="value-card fade-in">
                    <div class="value-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="value-title">Keamanan Data</h3>
                    <p class="value-description">Data pelanggan adalah prioritas utama. Kami menerapkan protokol keamanan ketat untuk melindungi setiap informasi selama proses perbaikan dan pemeliharaan.</p>
                </div>
                
                <div class="value-card fade-in">
                    <div class="value-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="value-title">Dukungan Komprehensif</h3>
                    <p class="value-description">Dari diagnosis awal hingga purna jual, tim kami siap memberikan bantuan penuh. Kami percaya layanan yang baik tidak berhenti di perbaikan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Philosophy Section -->
    <section class="philosophy-section">
        <div class="container">
            <div class="section-header fade-in">
                <h2 class="section-title">Filosofi Layanan</h2>
                <p class="section-subtitle">Pendekatan yang membuat kami berbeda dalam menangani setiap permasalahan teknologi</p>
            </div>
            
            <div class="philosophy-content fade-in">
                <p>Di Glorious Computer, kami melihat setiap perangkat sebagai investasi penting. Pendekatan kami tidak hanya memperbaiki masalah, tetapi juga mencegah kerusakan berulang dan memperpanjang usia perangkat.</p>
                
                <p>Kami percaya bahwa solusi teknologi terbaik datang dari pemahaman mendalam tentang kebutuhan spesifik setiap klien. Itulah mengapa kami selalu meluangkan waktu untuk mendengarkan dan menganalisis sebelum memberikan rekomendasi.</p>
                
                <div class="philosophy-quote fade-in">
                    <p class="quote-text">"Teknologi berkembang dengan cepat, tetapi prinsip pelayanan yang baik tetap sama: kejujuran, keahlian, dan komitmen untuk memberikan yang terbaik."</p>
                    <p class="quote-author">— Tim Glorious Computer</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section-minimalist">
        <div class="container">
            <div class="section-header fade-in">
                <h2>Siap Berkolaborasi?</h2>
                <p>Mari wujudkan solusi teknologi optimal untuk kebutuhan personal atau bisnis Anda.</p>
            </div>
            
            <div class="cta-buttons fade-in">
                <a href="{{ route('main.services.index') }}" class="btn-primary">
                    <i class="fas fa-tools mr-2"></i> Jelajahi Layanan
                </a>
                <!-- PERUBAHAN DI SINI: Menggunakan anchor link ke section contact di home page -->
                <a href="{{ url('/#contact') }}" class="btn-secondary">
                    <i class="fas fa-phone-alt mr-2"></i> Konsultasi Gratis
                </a>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
        // Fade in animation on scroll
        function fadeInOnScroll() {
            const elements = document.querySelectorAll('.fade-in');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.classList.add('visible');
                }
            });
        }
        
        // Initialize scroll listener
        window.addEventListener('scroll', fadeInOnScroll);
        window.addEventListener('load', fadeInOnScroll);
        
        // Initial check for elements in view
        setTimeout(fadeInOnScroll, 100);
    </script>
@endpush