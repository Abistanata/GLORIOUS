@extends('layouts.theme')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - Glorious Computer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
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

        /* Hero Section - Services Version */
        .hero-services {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 80px;
            background: linear-gradient(135deg, 
                #0A0A0A 0%, 
                #1A1A1A 50%, 
                #0A0A0A 100%);
            overflow: hidden;
        }

        .hero-services::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 107, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 107, 0, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 107, 0, 0.08) 0%, transparent 50%);
            animation: float 6s ease-in-out infinite;
        }

        .hero-services::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 107, 0, 0.3) 50%, 
                transparent 100%);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .hero-content-services {
            max-width: 800px;
            text-align: center;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .hero-services h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 25px;
            line-height: 1.1;
            background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .hero-services h1 span {
            background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .hero-services p {
            font-size: 1.3rem;
            color: #B0B0B0;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
            font-weight: 300;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 60px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-stat {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.8) 0%, rgba(38, 38, 38, 0.6) 100%);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .hero-stat:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 107, 0, 0.2);
            box-shadow: 0 10px 30px rgba(255, 107, 0, 0.1);
        }

        .hero-stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            margin-bottom: 8px;
        }

        .hero-stat-label {
            color: #A0A0A0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .cta-button-services {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 16px 40px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            border: none;
            box-shadow: 0 4px 20px rgba(255, 107, 0, 0.3);
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
        }

        .cta-button-services::before {
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

        .cta-button-services:hover::before {
            left: 100%;
        }

        .cta-button-services:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #CC5500 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255, 107, 0, 0.4);
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
            opacity: 0.1;
            animation: floatElement 8s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 80px;
            height: 80px;
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
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
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
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, #FF8C42 100%);
            border-radius: 2px;
        }

        .section-subtitle {
            color: #A0A0A0;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Services Section */
        #services {
            background: linear-gradient(135deg, #0A0A0A 0%, #1A1A1A 50%, #0A0A0A 100%);
            position: relative;
        }

        #services::before {
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

        .services-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }

        .service-card {
            background: linear-gradient(135deg, #1A1A1A 0%, #252525 100%);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            position: relative;
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
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 107, 0, 0.15);
            border-color: rgba(255, 107, 0, 0.3);
        }

        .service-image {
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .service-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(transparent, rgba(10, 10, 10, 0.9));
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .service-card:hover .service-image img {
            transform: scale(1.1);
        }

        .service-content {
            padding: 30px;
            position: relative;
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, 
                rgba(255, 107, 0, 0.15) 0%, 
                rgba(255, 140, 66, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 107, 0, 0.2);
        }

        .service-icon i {
            font-size: 1.5rem;
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
            margin-bottom: 20px;
        }

        .service-features {
            list-style: none;
            margin-bottom: 25px;
        }

        .service-features li {
            margin-bottom: 8px;
            color: #A0A0A0;
            position: relative;
            padding-left: 20px;
        }

        .service-features li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary);
            font-weight: bold;
        }

        .service-button {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            border: none;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }

        .service-button::before {
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

        .service-button:hover::before {
            left: 100%;
        }

        .service-button:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #CC5500 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.3);
        }

        /* Process Section */
        .process {
            background: linear-gradient(135deg, #121212 0%, #1E1E1E 50%, #121212 100%);
            position: relative;
        }

        .process::before {
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

        .process-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .process-step {
            text-align: center;
            position: relative;
        }

        .process-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 40px;
            right: -15px;
            width: 30px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary) 0%, #FF8C42 100%);
        }

        .step-number {
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
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .step-title {
            font-size: 1.3rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .step-description {
            color: #B0B0B0;
            line-height: 1.6;
        }

        /* Software Section */
        .software-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        .software-item {
            background: linear-gradient(135deg, #1A1A1A 0%, #252525 100%);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .software-item:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 107, 0, 0.2);
            box-shadow: 0 8px 30px rgba(255, 107, 0, 0.15);
        }

        .software-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .software-icon img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .software-name {
            font-size: 0.9rem;
            color: #E0E0E0;
            font-weight: 500;
        }

        /* Contact Section */
        .contact-section {
            background: linear-gradient(135deg, #0A0A0A 0%, #151515 50%, #0A0A0A 100%);
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .contact-form {
            background: linear-gradient(135deg, #1A1A1A 0%, #252525 100%);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #E0E0E0;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #E0E0E0;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(255, 107, 0, 0.2);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .contact-info {
            display: grid;
            gap: 30px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, 
                rgba(255, 107, 0, 0.15) 0%, 
                rgba(255, 140, 66, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 107, 0, 0.2);
        }

        .info-icon i {
            font-size: 1.2rem;
            background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .info-content h3 {
            font-size: 1.2rem;
            margin-bottom: 5px;
            background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .info-content p {
            color: #B0B0B0;
            line-height: 1.5;
        }

        .whatsapp-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #25D366;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .whatsapp-button:hover {
            background: #128C7E;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
        }

        .map-container {
            margin-top: 30px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, 
                var(--primary) 0%, 
                #FF8C42 50%, 
                var(--primary-dark) 100%);
            text-align: center;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center;
            background-size: cover;
            opacity: 0.1;
        }

        .cta-section h2 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            color: white;
            font-weight: 700;
            position: relative;
        }

        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.6;
            position: relative;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            position: relative;
        }

        .btn {
            padding: 16px 35px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FFFFFF 0%, #F0F0F0 100%);
            color: var(--primary-dark);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0A0A0A 0%, #1A1A1A 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
        }

        .btn-secondary:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-stats, .process-steps {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .software-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .contact-content {
                grid-template-columns: 1fr;
            }
            
            .hero-services h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            .hero-stats, .process-steps, .software-grid {
                grid-template-columns: 1fr;
            }
            
            .process-step:not(:last-child)::after {
                display: none;
            }
            
            .hero-services h1 {
                font-size: 2.5rem;
            }
            
            .hero-services p {
                font-size: 1.1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section - Services Version -->
    <section class="hero-services">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="container">
            <div class="hero-content-services animate">
                <h1>Layanan <span>Profesional</span> Kami</h1>
                <p>Solusi teknologi terpercaya untuk semua kebutuhan komputer, laptop, dan printer Anda dengan layanan berkualitas tinggi dan harga terjangkau.</p>
                <a href="#services" class="cta-button-services">Jelajahi Layanan</a>
                
                <div class="hero-stats">
                    <div class="hero-stat animate">
                        <span class="hero-stat-number">10+</span>
                        <span class="hero-stat-label">Tahun Pengalaman</span>
                    </div>
                    <div class="hero-stat animate">
                        <span class="hero-stat-number">500+</span>
                        <span class="hero-stat-label">Klien Puas</span>
                    </div>
                    <div class="hero-stat animate">
                        <span class="hero-stat-number">1000+</span>
                        <span class="hero-stat-label">Perangkat Diperbaiki</span>
                    </div>
                    <div class="hero-stat animate">
                        <span class="hero-stat-number">24/7</span>
                        <span class="hero-stat-label">Support Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
<section id="services">
    <div class="container">
        <div class="section-header animate">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Berbagai solusi teknologi terbaik untuk memenuhi kebutuhan perangkat komputer Anda</p>
        </div>
        <div class="services-grid">
            <!-- Service 1 -->
            <div class="service-card animate">
                <div class="service-image">
                    <img src="images/laptop.jpg" alt="Service Laptop & PC" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1593640408182-31c70c8268f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';">
                </div>
                <div class="service-content">
                    <div class="service-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="service-title">Service Laptop & PC</h3>
                    <p class="service-description">
                        Layanan perbaikan dan perawatan lengkap untuk laptop dan komputer semua merk. Termasuk troubleshooting hardware, penggantian komponen, dan optimasi performa.
                    </p>
                    <ul class="service-features">
                        <li class="service-feature">
                           
                            <span>Diagnosa dan perbaikan hardware</span>
                        </li>
                        <li class="service-feature">
                           
                            <span>Penggantian Sparepart</span>
                        </li>
                        <li class="service-feature">
                          
                            <span>Perbaikan engsel & speaker laptop</span>
                        </li>
                        <li class="service-feature">
                          
                            <span>Perbaikan Laptop mati & Motherboard</span>
                        </li>
                        <li class="service-feature">
           
                            <span>Upgrade agar performa laptop makin ngebut, NO LEMOT!</span>
                        </li>
                    </ul>
                    <a href="#kontak" class="service-button">Konsultasi Sekarang</a>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="service-card animate">
                <div class="service-image">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Install Software">
                </div>
                <div class="service-content">
                    <div class="service-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3 class="service-title">Install Software</h3>
                    <p class="service-description">
                        Layanan instalasi berbagai software sesuai kebutuhan Anda. Mulai dari sistem operasi, aplikasi office, desain grafis, hingga software khusus lainnya.
                    </p>
                    <ul class="service-features">
                        <li class="service-feature">
                          
                            <span>Instalasi sistem operasi (Windows, Linux)</span>
                        </li>
                        <li class="service-feature">
                           
                            <span>Software office dan produktivitas</span>
                        </li>
                        <li class="service-feature">
                            
                            <span>Aplikasi desain dan multimedia</span>
                        </li>
                        <li class="service-feature">
                         
                            <span>Software keamanan dan antivirus</span>
                        </li>
                        <li class="service-feature">
                       
                            <span>Driver dan aplikasi pendukung</span>
                        </li>
                    </ul>
                    <a href="#kontak" class="service-button">Konsultasi Sekarang</a>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="service-card animate">
                <div class="service-image">
                    <img src="images/printer.jpg" alt="Perbaikan Printer" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1555252333-9f8e92e65df9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';">
                </div>
                <div class="service-content">
                    <div class="service-icon">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3 class="service-title">Perbaikan Printer</h3>
                    <p class="service-description">
                        Servis lengkap printer inkjet, laserjet, dotmatrik. Mengkondisikan printer selalu siap digunakan dengan hasil yang optimal.
                    </p>
                    <ul class="service-features">
                        <li class="service-feature">
                            
                            <span>Perbaikan hasil cetak</span>
                        </li>
                        <li class="service-feature">
                            
                            <span>Reset Counter</span>
                        </li>
                        <li class="service-feature">
                           
                            <span>Paper jam & kertas tidak lancar</span>
                        </li>
                        <li class="service-feature">
                            
                            <span>Normalisasi kinerja printer</span>
                        </li>
                        <li class="service-feature">
                           
                            <span>Pembersihan head dan roller</span>
                        </li>
                    </ul>
                    <a href="#kontak" class="service-button">Konsultasi Sekarang</a>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="service-card animate">
                <div class="service-image">
                    <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Upgrade Hardware">
                </div>
                <div class="service-content">
                    <div class="service-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3 class="service-title">Upgrade Hardware</h3>
                    <p class="service-description">
                        Upgrade komponen hardware seperti RAM, SSD, VGA, dan lainnya untuk meningkatkan performa perangkat Anda sesuai kebutuhan.
                    </p>
                    <ul class="service-features">
                        <li class="service-feature">
                            
                            <span>Upgrade SSD</span>
                        </li>
                        <li class="service-feature">
                            
                            <span>Upgrade RAM</span>
                        </li>
                        <li class="service-feature">
                            
                            <span>Pemasangan kartu grafis (VGA)</span>
                        </li>
                        <li class="service-feature">
                            
                            <span>Optimasi performa gaming & desain</span>
                        </li>
                        <li class="service-feature">
                            
                            <span>Custom build sesuai kebutuhan</span>
                        </li>
                    </ul>
                    <a href="#kontak" class="service-button">Konsultasi Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Process Section -->
    <section class="process">
        <div class="container">
            <div class="section-header animate">
                <h2 class="section-title">Proses Layanan</h2>
                <p class="section-subtitle">Langkah-langkah mudah untuk mendapatkan layanan terbaik dari kami</p>
            </div>
            <div class="process-steps">
                <div class="process-step animate">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Konsultasi</h3>
                    <p class="step-description">Ceritakan masalah perangkat Anda dan dapatkan analisa awal dari teknisi kami.</p>
                </div>
                <div class="process-step animate">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Diagnosa</h3>
                    <p class="step-description">Kami melakukan pemeriksaan menyeluruh untuk mengidentifikasi masalah secara akurat.</p>
                </div>
                <div class="process-step animate">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Perbaikan</h3>
                    <p class="step-description">Proses perbaikan dilakukan dengan komponen berkualitas dan standar terbaik.</p>
                </div>
                <div class="process-step animate">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Testing & Garansi</h3>
                    <p class="step-description">Perangkat diuji secara menyeluruh dan dilengkapi dengan garansi layanan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Software Section -->
    <section>
        <div class="container">
            <div class="section-header animate">
                <h2 class="section-title">Software yang Kami Install</h2>
                <p class="section-subtitle">Berbagai software terpopuler dan terpercaya untuk kebutuhan produktivitas Anda</p>
            </div>
            <div class="software-grid">
                <div class="software-item animate">
                    <div class="software-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732221.png" alt="Microsoft Windows">
                    </div>
                    <div class="software-name">Microsoft Windows</div>
                </div>
                <div class="software-item animate">
                    <div class="software-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732220.png" alt="Microsoft Word">
                    </div>
                    <div class="software-name">Microsoft Word</div>
                </div>
                <div class="software-item animate">
                    <div class="software-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732224.png" alt="Microsoft PowerPoint">
                    </div>
                    <div class="software-name">Microsoft PowerPoint</div>
                </div>
                <div class="software-item animate">
                    <div class="software-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732225.png" alt="Microsoft Excel">
                    </div>
                    <div class="software-name">Microsoft Excel</div>
                </div>
                <div class="software-item animate">
                    <div class="software-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" alt="Google Chrome">
                    </div>
                    <div class="software-name">Google Chrome</div>
                </div>
                <div class="software-item animate">
                    <div class="software-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732205.png" alt="Microsoft Edge">
                    </div>
                    <div class="software-name">Microsoft Edge</div>
                </div>
                <div class="software-item animate">
                    <div class="software-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/5968/5968875.png" alt="Mozilla Firefox">
                    </div>
                    <div class="software-name">Mozilla Firefox</div>
                </div>
                <div class="software-item animate">
                    <div class="software-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/906/906324.png" alt="Antivirus">
                    </div>
                    <div class="software-name">Antivirus & Security</div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Contact Section -->
    <section id="kontak" class="contact-section">
        <div class="container">
            <div class="section-header animate">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-subtitle">Konsultasikan masalah perangkat Anda dan dapatkan solusi terbaik dari tim profesional kami</p>
            </div>
            <div class="contact-content">
                <div class="contact-form animate">
                    <h3 style="margin-bottom: 25px; background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Kirim Pesan</h3>
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" id="name" class="form-control" placeholder="Masukkan nama lengkap Anda">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="example@email.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phone">Nomor Telepon</label>
                            <input type="tel" id="phone" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="service">Jenis Layanan</label>
                            <select id="service" class="form-control">
                                <option value="">Pilih layanan yang dibutuhkan</option>
                                <option value="laptop">Service Laptop & PC</option>
                                <option value="software">Install Software</option>
                                <option value="printer">Perbaikan Printer</option>
                                <option value="upgrade">Upgrade Hardware</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="message">Pesan</label>
                            <textarea id="message" class="form-control" placeholder="Jelaskan masalah atau kebutuhan Anda secara detail"></textarea>
                        </div>
                        <button type="submit" class="service-button" style="width: 100%; text-align: center;">Kirim Pesan</button>
                    </form>
                </div>
                <div class="contact-info">
                    <div class="info-item animate">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <h3>Telepon</h3>
                            <p>0821-3380-3940</p>
                        </div>
                    </div>
                    <div class="info-item animate">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h3>Email</h3>
                            <p>gloriouscomputer@email.com</p>
                        </div>
                    </div>
                    <div class="info-item animate">
                        <div class="info-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="info-content">
                            <h3>WhatsApp</h3>
                            <p>Chat langsung dengan tim kami</p>
                            <a href="https://wa.me/6282133803940" target="_blank" class="whatsapp-button">
                                <i class="fab fa-whatsapp"></i> Chat Sekarang
                            </a>
                        </div>
                    </div>
                    <div class="info-item animate">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h3>Alamat</h3>
                            <p>Jl. Argandaru No.4, Bukateja, Purbalingga</p>
                        </div>
                    </div>
                    <div class="map-container animate">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.0596510563556!2d109.4235094749978!3d-7.006158792999033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e656ff33b6e6d8b%3A0x6fa8848c2db925cd!2sNo%204%2C%20Jl.%20Argandaru%2C%20Dusun%205%2C%20Bukateja%2C%20Kabupaten%20Purbalingga%2C%20Jawa%20Tengah%2053382!5e0!3m2!1sid!2sid!4v1693380000000!5m2!1sid!2sid" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="animate">Siap Membantu Kebutuhan Teknologi Anda</h2>
            <p class="animate">Tim profesional kami siap memberikan solusi terbaik untuk perangkat komputer, laptop, dan printer Anda dengan garansi dan layanan purna jual yang terjamin.</p>
            <div class="cta-buttons">
                <a href="https://wa.me/6282133803940" target="_blank" class="btn btn-primary animate">Hubungi via WhatsApp</a>
                <a href="tel:082133803940" class="btn btn-secondary animate">Telepon Sekarang</a>
            </div>
        </div>
    </section>

    <script>
        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate');
            
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
        document.querySelectorAll('.animate').forEach(element => {
            element.style.opacity = 0;
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        });
        
        // Listen for scroll events
        window.addEventListener('scroll', animateOnScroll);
        // Initial check on page load
        window.addEventListener('load', animateOnScroll);
    </script>

    <script>
// Emergency footer color fix
document.addEventListener('DOMContentLoaded', function() {
    const footer = document.querySelector('footer');
    if (footer) {
        footer.style.backgroundColor = '#0A0A0A';
        footer.style.color = '#F5F5F5';
    }
    
    // Also fix any footer classes
    const footers = document.querySelectorAll('.footer, .site-footer, [class*="footer"]');
    footers.forEach(footer => {
        footer.style.backgroundColor = '#0A0A0A';
        footer.style.color = '#F5F5F5';
    });
});
</script>
</body>
</html>
@endsection