
<!DOCTYPE html>

@extends('layouts.theme')

@section('content')
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glorious Computer - Solusi Teknologi & Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF6B00',
                        'primary-dark': '#E05D00',
                        'primary-light': '#FF8C42',
                        secondary: '#2D3748',
                        dark: '#121212',
                        darker: '#0A0A0A',
                        light: '#F5F5F5',
                        gray: '#8A8A8A',
                        'gray-light': '#2A2A2A',
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out',
                        'fade-in-right': 'fadeInRight 0.8s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeInRight: {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    html {
        scroll-behavior: smooth;
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
    }

    body {
        background-color: var(--darker);
        color: var(--light);
        line-height: 1.6;
        overflow-x: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Modern Hero Section */
    .hero-modern {
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        background: linear-gradient(135deg, #0A0A0A 0%, #1A1A1A 50%, #0A0A0A 100%);
        overflow: hidden;
    }

    .hero-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(255, 107, 0, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 107, 0, 0.05) 0%, transparent 50%);
    }

    .hero-content-modern {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary);
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 107, 0, 0.2);
        backdrop-filter: blur(10px);
    }

    .hero-main-title-modern {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .hero-main-title-modern .gradient-text {
        background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle-modern {
        font-size: 1.5rem;
        font-weight: 500;
        color: #E8E8E8;
        margin-bottom: 15px;
        letter-spacing: 0.05em;
    }

    .hero-tagline-modern {
        font-size: 1.1rem;
        font-weight: 400;
        color: #B0B0B0;
        margin-bottom: 40px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }

    .hero-description-modern {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 25px;
        line-height: 1.3;
        background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-description-modern span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-buttons-modern {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-bottom: 60px;
        flex-wrap: wrap;
    }

    .cta-button-modern {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 16px 40px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        border: none;
        box-shadow: 0 8px 30px rgba(255, 107, 0, 0.3);
        font-size: 1.1rem;
        position: relative;
        overflow: hidden;
    }

    .cta-button-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.2), 
            transparent);
        transition: left 0.5s;
    }

    .cta-button-modern:hover::before {
        left: 100%;
    }

    .cta-button-modern:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #CC5500 100%);
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(255, 107, 0, 0.4);
    }

    .cta-button-secondary-modern {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        color: white;
        padding: 16px 40px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-size: 1.1rem;
    }

    .cta-button-secondary-modern:hover {
        background: rgba(255, 255, 255, 0.12);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
    }

    .hero-stats-modern {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-top: 60px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-stat-modern {
        text-align: center;
        padding: 25px 20px;
        background: linear-gradient(135deg, rgba(26, 26, 26, 0.8) 0%, rgba(38, 38, 38, 0.6) 100%);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .hero-stat-modern:hover {
        transform: translateY(-5px);
        border-color: rgba(255, 107, 0, 0.3);
        box-shadow: 0 15px 40px rgba(255, 107, 0, 0.15);
    }

    .hero-stat-number-modern {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
        margin-bottom: 8px;
    }

    .hero-stat-label-modern {
        color: #A0A0A0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Floating Elements */
    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .floating-element {
        position: absolute;
        background: linear-gradient(135deg, var(--primary) 0%, transparent 70%);
        border-radius: 50%;
        opacity: 0.05;
        animation: floatElement 8s ease-in-out infinite;
    }

    .floating-element:nth-child(1) {
        width: 120px;
        height: 120px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .floating-element:nth-child(2) {
        width: 80px;
        height: 80px;
        top: 60%;
        right: 10%;
        animation-delay: 2s;
    }

    .floating-element:nth-child(3) {
        width: 60px;
        height: 60px;
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }

    @keyframes floatElement {
        0%, 100% { 
            transform: translateY(0px) rotate(0deg); 
        }
        50% { 
            transform: translateY(-20px) rotate(180deg); 
        }
    }

    /* Section Styles */
    section {
        padding: 100px 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 70px;
    }

    .section-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
        background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary) 0%, #FF8C42 100%);
        border-radius: 2px;
    }

    .section-subtitle {
        color: #A0A0A0;
        font-size: 1.2rem;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* About Section */
    .about-section {
        background: linear-gradient(135deg, #0A0A0A 0%, #1A1A1A 50%, #0A0A0A 100%);
        position: relative;
    }

    .about-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-text h2 {
        font-size: 2.2rem;
        margin-bottom: 25px;
        background: linear-gradient(135deg, #FFFFFF 0%, #CCCCCC 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .about-text p {
        margin-bottom: 20px;
        color: #B8B8B8;
        line-height: 1.7;
        font-size: 1.05rem;
    }

    .about-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 30px;
    }

    .about-feature {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .about-feature i {
        color: var(--primary);
        font-size: 1rem;
        margin-top: 2px;
    }

    .about-feature span {
        color: #B8B8B8;
        line-height: 1.5;
    }

    .about-image {
        position: relative;
    }

    .about-image img {
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-top: 50px;
    }

    .stat-item {
        text-align: center;
        padding: 35px 25px;
        background: linear-gradient(135deg, #1A1A1A 0%, #252525 100%);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
        border-color: rgba(255, 107, 0, 0.2);
        box-shadow: 0 15px 40px rgba(255, 107, 0, 0.15);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
        margin-bottom: 8px;
    }

    .stat-label {
        color: #A0A0A0;
        font-size: 1rem;
        font-weight: 500;
    }

    /* Services Section */
    .services-section {
        background: linear-gradient(135deg, #121212 0%, #1E1E1E 50%, #121212 100%);
        position: relative;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .service-card {
        background: linear-gradient(135deg, #1A1A1A 0%, #252525 100%);
        padding: 40px 30px;
        border-radius: 16px;
        text-align: center;
        transition: all 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 107, 0, 0.1), 
            transparent);
        transition: left 0.6s;
    }

    .service-card:hover::before {
        left: 100%;
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(255, 107, 0, 0.15);
        border-color: rgba(255, 107, 0, 0.3);
    }

    .service-icon {
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
    }

    .service-icon i {
        font-size: 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .service-title {
        font-size: 1.5rem;
        margin-bottom: 15px;
        background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .service-description {
        color: #B0B0B0;
        line-height: 1.6;
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .service-features {
        list-style: none;
        text-align: left;
    }

    .service-features li {
        color: #B0B0B0;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }

    .service-features i {
        color: var(--primary);
        margin-right: 8px;
        font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .hero-main-title-modern {
            font-size: 3.5rem;
        }
        
        .services-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .hero-main-title-modern {
            font-size: 3rem;
        }
        
        .hero-buttons-modern {
            flex-direction: column;
            align-items: center;
        }
        
        .cta-button-modern,
        .cta-button-secondary-modern {
            width: 250px;
            justify-content: center;
        }
        
        .about-content {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        .section-title {
            font-size: 2.5rem;
        }
        
        .hero-stats-modern {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-main-title-modern {
            font-size: 2.5rem;
        }
        
        .hero-subtitle-modern {
            font-size: 1.3rem;
        }
        
        .hero-tagline-modern {
            font-size: 1rem;
        }
        
        .services-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .section-title {
            font-size: 2.2rem;
        }
        
        .hero-stats-modern {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .hero-main-title-modern {
            font-size: 2.2rem;
        }
        
        .cta-button-modern,
        .cta-button-secondary-modern {
            padding: 14px 30px;
            font-size: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>
<body class="font-inter bg-dark text-light">
    <!-- Modern Hero Section -->
    <section class="hero-modern">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        
        <div class="container">
            <div class="hero-content-modern">
                <div class="hero-badge">
                    <i class="fas fa-star mr-2"></i> Solusi Teknologi Terpercaya
                </div>
                
                <h1 class="hero-main-title-modern">
                    <span class="gradient-text">GLORIOUS COMPUTER</span>
                </h1>
                
                <p class="hero-subtitle-modern">PENJUALAN & SERVIS PROFESIONAL</p>
                <p class="hero-tagline-modern">LAPTOP • KOMPUTER • PRINTER</p>
                
                <h2 class="hero-description-modern">
                    Solusi <span>Teknologi</span> & <span>Service</span> Terbaik
                </h2>
                
                <p class="hero-tagline-modern">
                    Partner terpercaya untuk kebutuhan komputer, laptop, dan service elektronik. 
                    Kami hadir untuk mendukung bisnis & personal Anda dengan layanan profesional 
                    dan solusi teknologi terdepan.
                </p>
                
                <div class="hero-buttons-modern">
                    <a href="#services" class="cta-button-modern">
                        <i class="fas fa-tools mr-3"></i> Jelajahi Layanan
                    </a>
                    <a href="#contact" class="cta-button-secondary-modern">
                        <i class="fas fa-phone-alt mr-3"></i> Hubungi Kami
                    </a>
                </div>
                
                <div class="hero-stats-modern">
                    <div class="hero-stat-modern">
                        <span class="hero-stat-number-modern">10+</span>
                        <span class="hero-stat-label-modern">Tahun Pengalaman</span>
                    </div>
                    <div class="hero-stat-modern">
                        <span class="hero-stat-number-modern">500+</span>
                        <span class="hero-stat-label-modern">Klien Puas</span>
                    </div>
                    <div class="hero-stat-modern">
                        <span class="hero-stat-number-modern">1000+</span>
                        <span class="hero-stat-label-modern">Perangkat Diperbaiki</span>
                    </div>
                    <div class="hero-stat-modern">
                        <span class="hero-stat-number-modern">24/7</span>
                        <span class="hero-stat-label-modern">Support Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-darker">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 section-title">
                    Tentang Kami
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                    Glorious Computer berkomitmen memberikan solusi IT terpercaya untuk individu maupun bisnis dengan pengalaman lebih dari 10 tahun di industri teknologi.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h3 class="text-2xl font-bold mb-4">Mengapa Memilih Kami?</h3>
                    <p class="text-gray-300 mb-6">
                        Dengan tim teknisi yang berpengalaman dan bersertifikat, kami memberikan solusi terbaik untuk semua kebutuhan teknologi Anda. Kami memahami bahwa setiap masalah teknologi membutuhkan pendekatan yang tepat.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3 text-lg"></i>
                            <span class="text-gray-300">Teknisi berpengalaman dan bersertifikat</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3 text-lg"></i>
                            <span class="text-gray-300">Garansi untuk setiap perbaikan dan produk</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3 text-lg"></i>
                            <span class="text-gray-300">Layanan cepat dan harga transparan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-primary mt-1 mr-3 text-lg"></i>
                            <span class="text-gray-300">Support 24/7 untuk kebutuhan mendesak</span>
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="bg-gray-light rounded-2xl p-8 card-hover border border-gray-700">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Workshop Kami" class="rounded-xl shadow-lg w-full">
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-gray-light rounded-xl p-6 text-center card-hover border border-gray-700">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">10+</div>
                    <div class="text-gray-300">Tahun Pengalaman</div>
                </div>
                <div class="bg-gray-light rounded-xl p-6 text-center card-hover border border-gray-700">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">500+</div>
                    <div class="text-gray-300">Klien Puas</div>
                </div>
                <div class="bg-gray-light rounded-xl p-6 text-center card-hover border border-gray-700">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">1000+</div>
                    <div class="text-gray-300">Produk Terjual</div>
                </div>
                <div class="bg-gray-light rounded-xl p-6 text-center card-hover border border-gray-700">
                    <div class="text-3xl md:text-4xl font-bold text-primary mb-2">24/7</div>
                    <div class="text-gray-300">Support Aktif</div>
                </div>
            </div>
        </div>
    </section>

 <!-- Services Section -->
<section id="services" class="py-20 bg-dark">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 section-title">
                Layanan Kami
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                Berbagai solusi teknologi terbaik untuk memenuhi kebutuhan perangkat komputer Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Service 1 - Service Laptop & PC -->
            <div class="bg-darker rounded-2xl p-8 card-hover border border-gray-700 group hover:border-primary/50 transition-all duration-300">
                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-primary/30 transition-colors duration-300">
                    <i class="fas fa-laptop text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-center group-hover:text-primary transition-colors duration-300">Service Laptop & PC</h3>
                <p class="text-gray-400 mb-6 text-center">
                    Layanan perbaikan dan perawatan lengkap untuk laptop dan komputer semua merk. Termasuk troubleshooting hardware, penggantian komponen, dan optimasi performa.
                </p>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Diagnosa dan perbaikan hardware</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Penggantian komponen asli</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Optimasi sistem dan performa</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Cleaning dan perawatan rutin</span>
                    </li>
                </ul>
                <div class="mt-6 text-center">
                    <a href="#contact" class="inline-flex items-center text-primary hover:text-primary-light font-semibold text-sm transition-colors duration-300">
                        Konsultasi Sekarang
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            
            <!-- Service 2 - Install Software -->
            <div class="bg-darker rounded-2xl p-8 card-hover border border-gray-700 group hover:border-primary/50 transition-all duration-300">
                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-primary/30 transition-colors duration-300">
                    <i class="fas fa-download text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-center group-hover:text-primary transition-colors duration-300">Install Software</h3>
                <p class="text-gray-400 mb-6 text-center">
                    Instalasi software original, update sistem operasi, dan konfigurasi perangkat lunak sesuai kebutuhan Anda. Kami pastikan software berjalan lancar dan aman.
                </p>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Instalasi Windows & Update</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Microsoft Office & Productivity Tools</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Browser & Software Pendukung</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Software keamanan & antivirus</span>
                    </li>
                </ul>
                <div class="mt-6 text-center">
                    <a href="#contact" class="inline-flex items-center text-primary hover:text-primary-light font-semibold text-sm transition-colors duration-300">
                        Konsultasi Sekarang
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            
            <!-- Service 3 - Perbaikan Printer -->
            <div class="bg-darker rounded-2xl p-8 card-hover border border-gray-700 group hover:border-primary/50 transition-all duration-300">
                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-primary/30 transition-colors duration-300">
                    <i class="fas fa-print text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-center group-hover:text-primary transition-colors duration-300">Perbaikan Printer</h3>
                <p class="text-gray-400 mb-6 text-center">
                    Servis lengkap printer inkjet dan laserjet, termasuk penggantian sparepart, cleaning head, dan kalibrasi agar hasil cetak selalu optimal.
                </p>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Perbaikan hardware printer</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Penggantian sparepart asli</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Cleaning dan kalibrasi head</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Optimasi hasil cetak</span>
                    </li>
                </ul>
                <div class="mt-6 text-center">
                    <a href="#contact" class="inline-flex items-center text-primary hover:text-primary-light font-semibold text-sm transition-colors duration-300">
                        Konsultasi Sekarang
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            
            <!-- Service 4 - Upgrade Hardware -->
            <div class="bg-darker rounded-2xl p-8 card-hover border border-gray-700 group hover:border-primary/50 transition-all duration-300">
                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mb-6 mx-auto group-hover:bg-primary/30 transition-colors duration-300">
                    <i class="fas fa-microchip text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-center group-hover:text-primary transition-colors duration-300">Upgrade Hardware</h3>
                <p class="text-gray-400 mb-6 text-center">
                    Upgrade komponen hardware seperti RAM, SSD, VGA, dan lainnya untuk meningkatkan performa perangkat Anda sesuai kebutuhan.
                </p>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Upgrade RAM & Storage</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Pemasangan kartu grafis (VGA)</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Optimasi performa gaming & desain</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-primary mr-3 text-sm"></i>
                        <span>Custom build sesuai kebutuhan</span>
                    </li>
                </ul>
                <div class="mt-6 text-center">
                    <a href="#contact" class="inline-flex items-center text-primary hover:text-primary-light font-semibold text-sm transition-colors duration-300">
                        Konsultasi Sekarang
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-20 bg-darker">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 section-title">
                Proses Layanan
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                Langkah-langkah mudah untuk mendapatkan layanan terbaik dari kami
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center relative">
                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mb-6 mx-auto border-2 border-primary/30">
                    <span class="text-2xl font-bold text-primary">1</span>
                </div>
                <h3 class="text-xl font-bold mb-4 text-white">Konsultasi</h3>
                <p class="text-gray-400">
                    Ceritakan masalah perangkat Anda dan dapatkan analisa awal dari teknisi kami.
                </p>
                <div class="hidden lg:block absolute top-10 right-0 transform translate-x-1/2 w-8 h-0.5 bg-primary/30"></div>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center relative">
                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mb-6 mx-auto border-2 border-primary/30">
                    <span class="text-2xl font-bold text-primary">2</span>
                </div>
                <h3 class="text-xl font-bold mb-4 text-white">Diagnosa</h3>
                <p class="text-gray-400">
                    Kami melakukan pemeriksaan menyeluruh untuk mengidentifikasi masalah secara akurat.
                </p>
                <div class="hidden lg:block absolute top-10 right-0 transform translate-x-1/2 w-8 h-0.5 bg-primary/30"></div>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center relative">
                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mb-6 mx-auto border-2 border-primary/30">
                    <span class="text-2xl font-bold text-primary">3</span>
                </div>
                <h3 class="text-xl font-bold mb-4 text-white">Perbaikan</h3>
                <p class="text-gray-400">
                    Proses perbaikan dilakukan dengan komponen berkualitas dan standar terbaik.
                </p>
                <div class="hidden lg:block absolute top-10 right-0 transform translate-x-1/2 w-8 h-0.5 bg-primary/30"></div>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mb-6 mx-auto border-2 border-primary/30">
                    <span class="text-2xl font-bold text-primary">4</span>
                </div>
                <h3 class="text-xl font-bold mb-4 text-white">Testing & Garansi</h3>
                <p class="text-gray-400">
                    Perangkat diuji secara menyeluruh dan dilengkapi dengan garansi layanan.
                </p>
            </div>
        </div>
    </div>
</section>

    <!-- Products Section -->
    <section id="produk" class="py-20 bg-darker">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 section-title">
                    Produk Unggulan
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                    Temukan produk teknologi terbaik dengan kualitas terjamin dan harga kompetitif untuk kebutuhan Anda.
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach (range(1,6) as $i)
                <div class="bg-dark rounded-2xl overflow-hidden card-hover border border-gray-700">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/produk'.$i.'.jpg') }}" alt="Produk {{ $i }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Produk {{ $i }}</h3>
                        <p class="text-gray-400 mb-4 text-sm">
                            Deskripsi singkat produk {{ $i }} dengan spesifikasi dan keunggulan yang ditawarkan.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary font-bold text-lg">Rp{{ number_format(100000 * $i,0,',','.') }}</span>
                            <button class="bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-full transition-all duration-300 transform hover:scale-105">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center text-primary hover:text-primary-light font-semibold text-lg">
                    Lihat Semua Produk
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimoni" class="py-20 bg-dark">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 section-title">
                    Apa Kata Klien Kami
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                    Testimoni dari pelanggan yang telah menggunakan layanan dan produk kami.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-darker rounded-2xl p-6 card-hover border border-gray-700">
                    <div class="text-primary text-5xl mb-4">"</div>
                    <p class="text-gray-300 mb-6">
                        "Pelayanan sangat memuaskan, teknisi profesional dan harga terjangkau. Recommended banget!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <div class="font-bold">Andi Wijaya</div>
                            <div class="text-gray-400 text-sm">Pengusaha</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-darker rounded-2xl p-6 card-hover border border-gray-700">
                    <div class="text-primary text-5xl mb-4">"</div>
                    <p class="text-gray-300 mb-6">
                        "Laptop saya rusak parah, tapi bisa diperbaiki dengan baik dan cepat. Terima kasih Glorious Computer!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <div class="font-bold">Budi Santoso</div>
                            <div class="text-gray-400 text-sm">Mahasiswa</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-darker rounded-2xl p-6 card-hover border border-gray-700">
                    <div class="text-primary text-5xl mb-4">"</div>
                    <p class="text-gray-300 mb-6">
                        "Sudah langganan service di sini, selalu puas dengan hasilnya. Support 24 jam juga sangat membantu."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <div class="font-bold">Citra Dewi</div>
                            <div class="text-gray-400 text-sm">Freelancer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-darker">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 section-title">
                    Hubungi Kami
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                    Kami siap membantu kebutuhan teknologi Anda. Jangan ragu untuk menghubungi kami.
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="bg-dark rounded-2xl p-8 border border-gray-700">
                    <h3 class="text-2xl font-bold mb-2">Kirim Pesan</h3>
                    <p class="text-gray-400 mb-6">Isi form berikut dan kami akan segera merespons</p>
                    
                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-gray-300 mb-2">Nama Lengkap</label>
                            <input type="text" id="name" class="w-full bg-gray-light border border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div>
                            <label for="email" class="block text-gray-300 mb-2">Email</label>
                            <input type="email" id="email" class="w-full bg-gray-light border border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Masukkan alamat email" required>
                        </div>
                        <div>
                            <label for="message" class="block text-gray-300 mb-2">Pesan</label>
                            <textarea id="message" rows="5" class="w-full bg-gray-light border border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Tulis pesan Anda" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-1">
                            Kirim Sekarang
                        </button>
                    </form>
                </div>
                
                <div class="space-y-8">
                    <div class="bg-dark rounded-2xl p-6 border border-gray-700 card-hover">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-phone-alt text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Telepon</h3>
                                <p class="text-gray-300">0821-3380-3940</p>
                                <p class="text-gray-400 text-sm mt-1">Senin - Minggu, 08:00 - 22:00 WIB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark rounded-2xl p-6 border border-gray-700 card-hover">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Email</h3>
                                <p class="text-gray-300">gloriouscomputer@email.com</p>
                                <p class="text-gray-400 text-sm mt-1">Respon dalam 1x24 jam</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark rounded-2xl p-6 border border-gray-700 card-hover">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                                <i class="fab fa-whatsapp text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">WhatsApp</h3>
                                <a href="https://wa.me/6282133803940" target="_blank" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fab fa-whatsapp mr-2"></i> Chat Sekarang
                                </a>
                                <p class="text-gray-400 text-sm mt-2">Respon cepat via WhatsApp</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark rounded-2xl p-6 border border-gray-700 card-hover">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Alamat</h3>
                                <p class="text-gray-300">Jl. Argandaru No.4, Bukateja, Purbalingga</p>
                                <p class="text-gray-400 text-sm mt-1">Buka: Senin - Minggu, 08:00 - 22:00 WIB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark rounded-2xl overflow-hidden border border-gray-700">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.0596510563556!2d109.4235094749978!3d-7.006158792999033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e656ff33b6e6d8b%3A0x6fa8848c2db925cd!2sNo%204%2C%20Jl.%20Argandaru%2C%20Dusun%205%2C%20Bukateja%2C%20Kabupaten%20Purbalingga%2C%20Jawa%20Tengah%2053382!5e0!3m2!1sid!2sid!4v1693380000000!5m2!1sid!2sid" 
                            width="100%" 
                            height="250" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            class="w-full">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-primary-dark">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Membantu Kebutuhan Teknologi Anda</h2>
            <p class="text-white/90 max-w-2xl mx-auto mb-8 text-lg">
                Dapatkan solusi terbaik untuk komputer, laptop, dan perangkat elektronik Anda dengan layanan profesional dari tim ahli kami.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="https://wa.me/6282133803940" target="_blank" class="bg-white text-primary hover:bg-gray-100 font-semibold py-3 px-8 rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center text-lg">
                    <i class="fab fa-whatsapp mr-3"></i> Hubungi via WhatsApp
                </a>
                <a href="tel:082133803940" class="bg-transparent border-2 border-white text-white hover:bg-white/10 font-semibold py-3 px-8 rounded-full transition-all duration-300 transform hover:-translate-y-1 flex items-center text-lg">
                    <i class="fas fa-phone-alt mr-3"></i> Telepon Sekarang
                </a>
            </div>
        </div>
    </section>

    

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.card-hover');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = 1;
                    element.style.transform = 'translateY(0)';
                }
            });
        }
        
        // Initialize elements for animation
        document.querySelectorAll('.card-hover').forEach(element => {
            element.style.opacity = 0;
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        });
        
        // Listen for scroll events
        window.addEventListener('scroll', animateOnScroll);
        // Initial check on page load
        window.addEventListener('load', animateOnScroll);
    </script>
</body>
</html>