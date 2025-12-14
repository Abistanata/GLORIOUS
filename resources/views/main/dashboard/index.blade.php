<!DOCTYPE html>
@extends('layouts.theme')

@section('title', 'Home - Glorious Computer')

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
                        'card-dark': '#171717',
                        'card-light': '#1E1E1E',
                        'accent': '#FF8C00',
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out',
                        'fade-in-right': 'fadeInRight 0.8s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
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
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(255, 107, 0, 0.3)' },
                            '50%': { boxShadow: '0 0 30px rgba(255, 107, 0, 0.5)' },
                        }
                    },
                    typography: {
                        DEFAULT: {
                            css: {
                                color: '#f5f5f5',
                                h1: {
                                    fontWeight: '800',
                                },
                                h2: {
                                    fontWeight: '700',
                                },
                                h3: {
                                    fontWeight: '600',
                                },
                            },
                        },
                    },
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
        --card-dark: #171717;
        --card-light: #1E1E1E;
        --accent: #FF8C00;
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

    /* Modern Hero Section */
    .hero-modern {
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        background: linear-gradient(135deg, #0A0A0A 0%, #141414 50%, #0A0A0A 100%);
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
            radial-gradient(circle at 20% 80%, rgba(255, 107, 0, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 107, 0, 0.08) 0%, transparent 50%);
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
        background: linear-gradient(135deg, rgba(255, 107, 0, 0.15) 0%, rgba(255, 140, 66, 0.1) 100%);
        color: var(--primary);
        padding: 10px 24px;
        border-radius: 24px;
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 107, 0, 0.3);
        backdrop-filter: blur(10px);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .hero-main-title-modern {
        font-size: 4.5rem;
        font-weight: 900;
        margin-bottom: 24px;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .hero-main-title-modern .gradient-text {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 4px 30px rgba(255, 107, 0, 0.2);
    }

    .hero-subtitle-modern {
        font-size: 1.75rem;
        font-weight: 600;
        color: #E8E8E8;
        margin-bottom: 16px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .hero-tagline-modern {
        font-size: 1.25rem;
        font-weight: 500;
        color: #B0B0B0;
        margin-bottom: 48px;
        max-width: 680px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.8;
        letter-spacing: 0.02em;
    }

    .hero-description-modern {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 32px;
        line-height: 1.3;
        background: linear-gradient(135deg, #FFFFFF 0%, #E0E0E0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-description-modern span {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-buttons-modern {
        display: flex;
        gap: 24px;
        justify-content: center;
        margin-bottom: 80px;
        flex-wrap: wrap;
    }

    .cta-button-modern {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 18px 48px;
        border-radius: 32px;
        font-weight: 700;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        border: none;
        box-shadow: 0 12px 40px rgba(255, 107, 0, 0.4);
        font-size: 1.15rem;
        position: relative;
        overflow: hidden;
        letter-spacing: 0.03em;
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
            rgba(255, 255, 255, 0.25), 
            transparent);
        transition: left 0.7s;
    }

    .cta-button-modern:hover::before {
        left: 100%;
    }

    .cta-button-modern:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #D95300 100%);
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 16px 50px rgba(255, 107, 0, 0.5);
    }

    .cta-button-secondary-modern {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        color: white;
        padding: 18px 48px;
        border-radius: 32px;
        font-weight: 700;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        font-size: 1.15rem;
        letter-spacing: 0.03em;
    }

    .cta-button-secondary-modern:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .hero-stats-modern {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-top: 80px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-stat-modern {
        text-align: center;
        padding: 32px 24px;
        background: linear-gradient(135deg, rgba(30, 30, 30, 0.9) 0%, rgba(45, 45, 45, 0.7) 100%);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-stat-modern:hover {
        transform: translateY(-8px) scale(1.03);
        border-color: rgba(255, 107, 0, 0.4);
        box-shadow: 0 20px 50px rgba(255, 107, 0, 0.2);
    }

    .hero-stat-number-modern {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
        margin-bottom: 12px;
        letter-spacing: -0.02em;
    }

    .hero-stat-label-modern {
        color: #A0A0A0;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
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
        opacity: 0.08;
        animation: floatElement 10s ease-in-out infinite;
    }

    /* Section Styles */
    section {
        padding: 120px 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 80px;
    }

    .section-title {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 24px;
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
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 5px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
        border-radius: 3px;
        box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
    }

    .section-subtitle {
        color: #B0B0B0;
        font-size: 1.3rem;
        max-width: 700px;
        margin: 32px auto 0;
        line-height: 1.8;
        font-weight: 500;
        letter-spacing: 0.02em;
    }

    /* About Section */
    .about-section {
        background: linear-gradient(135deg, #0A0A0A 0%, #161616 50%, #0A0A0A 100%);
        position: relative;
    }

    .about-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    .about-text h2 {
        font-size: 2.8rem;
        margin-bottom: 32px;
        background: linear-gradient(135deg, #FFFFFF 0%, #CCCCCC 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .about-text p {
        margin-bottom: 24px;
        color: #C8C8C8;
        line-height: 1.8;
        font-size: 1.15rem;
        font-weight: 400;
    }

    .about-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 40px;
    }

    .about-feature {
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .about-feature i {
        color: var(--primary);
        font-size: 1.2rem;
        margin-top: 4px;
    }

    .about-feature span {
        color: #C8C8C8;
        line-height: 1.6;
        font-weight: 500;
    }

    .about-image {
        position: relative;
    }

    .about-image img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .about-image:hover img {
        transform: scale(1.02);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-top: 60px;
    }

    .stat-item {
        text-align: center;
        padding: 40px 30px;
        background: linear-gradient(135deg, #1E1E1E 0%, #2A2A2A 100%);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-item:hover {
        transform: translateY(-8px) scale(1.03);
        border-color: rgba(255, 107, 0, 0.3);
        box-shadow: 0 20px 60px rgba(255, 107, 0, 0.2);
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
        margin-bottom: 12px;
        letter-spacing: -0.03em;
    }

    .stat-label {
        color: #A0A0A0;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* Services Section */
    .services-section {
        background: linear-gradient(135deg, #121212 0%, #1C1C1C 50%, #121212 100%);
        position: relative;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 35px;
    }

    .service-card {
        background: linear-gradient(135deg, var(--card-dark) 0%, var(--card-light) 100%);
        padding: 48px 35px;
        border-radius: 20px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25);
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
            rgba(255, 107, 0, 0.15), 
            transparent);
        transition: left 0.8s;
    }

    .service-card:hover::before {
        left: 100%;
    }

    .service-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 60px rgba(255, 107, 0, 0.2);
        border-color: rgba(255, 107, 0, 0.4);
    }

    .service-icon {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, 
            rgba(255, 107, 0, 0.2) 0%, 
            rgba(255, 140, 66, 0.15) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 32px;
        border: 2px solid rgba(255, 107, 0, 0.3);
        transition: all 0.4s;
    }

    .service-card:hover .service-icon {
        background: linear-gradient(135deg, 
            rgba(255, 107, 0, 0.25) 0%, 
            rgba(255, 140, 66, 0.2) 100%);
        border-color: rgba(255, 107, 0, 0.5);
        transform: scale(1.1);
    }

    .service-icon i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .service-title {
        font-size: 1.75rem;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #FFFFFF 0%, #E0E0E0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .service-description {
        color: #B8B8B8;
        line-height: 1.8;
        font-size: 1.1rem;
        margin-bottom: 24px;
        font-weight: 400;
    }

    .service-features {
        list-style: none;
        text-align: left;
    }

    .service-features li {
        color: #B8B8B8;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        font-weight: 500;
        padding-left: 8px;
        transition: all 0.3s;
    }

    .service-features li:hover {
        color: #E0E0E0;
        transform: translateX(5px);
    }

    .service-features i {
        color: var(--primary);
        margin-right: 12px;
        font-size: 1rem;
        min-width: 20px;
    }

    /* Products Section Styling */
    .product-card {
        background: linear-gradient(135deg, var(--card-dark) 0%, var(--card-light) 100%);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(255, 107, 0, 0.4);
        box-shadow: 0 25px 60px rgba(255, 107, 0, 0.2);
    }

    .product-image-container {
        height: 240px;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, #2A2A2A 0%, #1E1E1E 100%);
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .badge-available {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .badge-low {
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .badge-out {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .product-content {
        padding: 28px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-category {
        color: var(--primary);
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 12px;
        display: inline-block;
    }

    .product-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 16px;
        line-height: 1.3;
        letter-spacing: -0.01em;
    }

    .product-specs {
        color: #B8B8B8;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 16px;
        flex: 1;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .product-stock {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin: 16px 0;
    }

    .stock-label {
        color: #A0A0A0;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .stock-value {
        color: white;
        font-size: 1.1rem;
        font-weight: 800;
    }

    .product-pricing {
        margin-top: auto;
    }

    .price-display {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .current-price {
        font-size: 1.75rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .original-price {
        font-size: 1.1rem;
        color: #8A8A8A;
        text-decoration: line-through;
        font-weight: 500;
    }

    .discount-badge {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 700;
        margin-left: auto;
    }

    .product-actions {
        display: flex;
        gap: 12px;
    }

    .btn-detail {
        flex: 1;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 14px 24px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s;
        text-align: center;
        text-decoration: none;
    }

    .btn-detail:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
    }

    .btn-buy {
        flex: 1;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        padding: 14px 24px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-buy:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #D95300 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 107, 0, 0.3);
    }

    .btn-disabled {
        background: linear-gradient(135deg, #4B5563 0%, #374151 100%);
        cursor: not-allowed;
        opacity: 0.7;
    }

    .btn-disabled:hover {
        transform: none;
        box-shadow: none;
    }

    /* Process Section */
    .process-step {
        position: relative;
        text-align: center;
    }

    .process-connector {
        position: absolute;
        top: 40px;
        right: -40px;
        width: 80px;
        height: 2px;
        background: linear-gradient(90deg, var(--primary) 0%, transparent 100%);
    }

    /* Testimonials Section */
    .testimonial-card {
        background: linear-gradient(135deg, var(--card-dark) 0%, var(--card-light) 100%);
        border-radius: 20px;
        padding: 40px 32px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .testimonial-card:hover {
        transform: translateY(-8px);
        border-color: rgba(255, 107, 0, 0.3);
        box-shadow: 0 20px 50px rgba(255, 107, 0, 0.15);
    }

    .testimonial-quote {
        font-size: 3.5rem;
        color: var(--primary);
        opacity: 0.3;
        position: absolute;
        top: 20px;
        left: 20px;
    }

    /* Contact Section */
    .contact-card {
        background: linear-gradient(135deg, var(--card-dark) 0%, var(--card-light) 100%);
        border-radius: 20px;
        padding: 32px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .contact-card:hover {
        transform: translateY(-5px);
        border-color: rgba(255, 107, 0, 0.3);
        box-shadow: 0 15px 40px rgba(255, 107, 0, 0.15);
    }

    /* New CSS for enhanced product cards */
    .discount-badge-large {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        color: white;
        padding: 6px 16px;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 800;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .condition-badge {
        background: rgba(255, 107, 0, 0.9);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .stock-progress {
        width: 100%;
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
        overflow: hidden;
    }

    .stock-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10B981 0%, #34D399 100%);
        transition: width 0.5s ease;
    }

    .info-chip {
        display: inline-flex;
        align-items: center;
        background: rgba(59, 130, 246, 0.1);
        color: #93C5FD;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .info-chip i {
        margin-right: 4px;
        font-size: 0.7rem;
    }

    .btn-whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 700;
    }

    .btn-whatsapp:hover {
        background: linear-gradient(135deg, #128C7E 0%, #0D6E5F 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .hero-main-title-modern {
            font-size: 3.75rem;
        }
        
        .services-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }

    @media (max-width: 992px) {
        .hero-main-title-modern {
            font-size: 3.25rem;
        }
        
        .hero-buttons-modern {
            flex-direction: column;
            align-items: center;
        }
        
        .cta-button-modern,
        .cta-button-secondary-modern {
            width: 280px;
            justify-content: center;
        }
        
        .about-content {
            grid-template-columns: 1fr;
            gap: 50px;
        }
        
        .section-title {
            font-size: 3rem;
        }
        
        .hero-stats-modern {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        
        .process-connector {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .hero-main-title-modern {
            font-size: 2.75rem;
        }
        
        .hero-subtitle-modern {
            font-size: 1.5rem;
        }
        
        .hero-tagline-modern {
            font-size: 1.1rem;
        }
        
        .services-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .section-title {
            font-size: 2.5rem;
        }
        
        .hero-stats-modern {
            grid-template-columns: 1fr;
            max-width: 400px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .about-features {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .hero-main-title-modern {
            font-size: 2.25rem;
        }
        
        .cta-button-modern,
        .cta-button-secondary-modern {
            padding: 16px 36px;
            font-size: 1.05rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .product-actions {
            flex-direction: column;
        }
    }
    </style>
</head>
<body class="font-inter bg-darker text-light">
    <!-- Modern Hero Section -->
    <section class="hero-modern">
        <div class="floating-elements">
            <div class="floating-element" style="width: 120px; height: 120px; top: 20%; left: 10%; animation-delay: 0s;"></div>
            <div class="floating-element" style="width: 80px; height: 80px; top: 60%; right: 10%; animation-delay: 2s;"></div>
            <div class="floating-element" style="width: 60px; height: 60px; bottom: 20%; left: 20%; animation-delay: 4s;"></div>
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
                    Partner terpercaya untuk kebutuhan komputer, laptop, printer dan servis. 
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
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    Tentang Kami
                </h2>
                <p class="section-subtitle">
                    Glorious Computer berkomitmen memberikan solusi IT terpercaya untuk individu maupun bisnis dengan pengalaman lebih dari 10 tahun di industri teknologi.
                </p>
            </div>
            
            <div class="about-content">
                <div class="about-text">
                    <h2>Mengapa Memilih Kami?</h2>
                    <p>
                        Dengan tim teknisi yang berpengalaman dan bersertifikat, kami memberikan solusi terbaik untuk semua kebutuhan teknologi Anda. Kami memahami bahwa setiap masalah teknologi membutuhkan pendekatan yang tepat.
                    </p>
                    <div class="about-features">
                        <div class="about-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Teknisi berpengalaman dan bersertifikat</span>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Garansi untuk setiap perbaikan dan produk</span>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Layanan cepat dan harga transparan</span>
                        </div>
                        <div class="about-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Support 24/7 untuk kebutuhan mendesak</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="images/background.jpg" alt="Workshop Kami">
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">10+</span>
                    <span class="stat-label">Tahun Pengalaman</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Klien Puas</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">1000+</span>
                    <span class="stat-label">Produk Terjual</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Support Aktif</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    Layanan Kami
                </h2>
                <p class="section-subtitle">
                    Berbagai solusi teknologi terbaik untuk memenuhi kebutuhan perangkat komputer Anda
                </p>
            </div>
            
            <div class="services-grid">
                <!-- Service 1 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="service-title">Service Laptop & PC</h3>
                    <p class="service-description">
                        Layanan perbaikan dan perawatan lengkap untuk laptop dan komputer semua merk.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i>Diagnosa dan perbaikan hardware</li>
                        <li><i class="fas fa-check"></i>Penggantian Sparepart</li>
                        <li><i class="fas fa-check"></i>Optimasi sistem dan performa</li>
                        <li><i class="fas fa-check"></i>Perbaikan engsel & speaker laptop</li>
                        <li><i class="fas fa-check"></i>Perbaikan Laptop mati & Motherboard</li>
                        <li><i class="fas fa-check"></i>Upgrade performa laptop</li>
                    </ul>
                </div>
                
                <!-- Service 2 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3 class="service-title">Install Software</h3>
                    <p class="service-description">
                        Instalasi software, update sistem operasi, dan konfigurasi perangkat lunak.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i>Instalasi Windows & Update</li>
                        <li><i class="fas fa-check"></i>Microsoft Office & Productivity Tools</li>
                        <li><i class="fas fa-check"></i>Browser & Software Pendukung</li>
                        <li><i class="fas fa-check"></i>Software keamanan & antivirus</li>
                    </ul>
                </div>
                
                <!-- Service 3 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3 class="service-title">Perbaikan Printer</h3>
                    <p class="service-description">
                        Servis lengkap printer inkjet, laserjet, dotmatrik untuk hasil optimal.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i>Perbaikan hasil cetak</li>
                        <li><i class="fas fa-check"></i>Reset Counter</li>
                        <li><i class="fas fa-check"></i>Paper jam & kertas tidak lancar</li>
                        <li><i class="fas fa-check"></i>Normalisasi kinerja printer</li>
                    </ul>
                </div>
                
                <!-- Service 4 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3 class="service-title">Upgrade Hardware</h3>
                    <p class="service-description">
                        Upgrade komponen hardware untuk meningkatkan performa perangkat Anda.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i>Upgrade SSD</li>
                        <li><i class="fas fa-check"></i>Upgrade RAM</li>
                        <li><i class="fas fa-check"></i>Pemasangan kartu grafis (VGA)</li>
                        <li><i class="fas fa-check"></i>Optimasi performa gaming & desain</li>
                        <li><i class="fas fa-check"></i>Custom build sesuai kebutuhan</li>
                    </ul>
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

    <!-- Products Section -->
    <section id="produk" class="py-20 bg-darker">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    Produk Unggulan
                </h2>
                <p class="section-subtitle">
                    Tersedia Unit Second Laptop, PC, dan Printer dengan kualitas terjamin dan harga kompetitif
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $product)
                        @php
                            $currentStock = $product->current_stock;
                            $imageExists = $product->image ? Storage::disk('public')->exists($product->image) : false;
                            $imageUrl = $product->image && $imageExists ? asset('storage/' . $product->image) : null;
                            
                            // Pricing logic from Product model
                            $hasDiscount = $product->has_discount;
                            $discountPercentage = $product->discount_percentage;
                            $finalPrice = $product->final_price;
                            $sellingPrice = $product->selling_price;
                            $discountAmount = $product->getDiscountAmount();
                            
                            // Additional info
                            $condition = $product->getConditionLabel();
                            $warranty = $product->getWarrantyLabel();
                            $shipping = $product->getShippingInfoLabel();
                            
                            // Stock status
                            $stockStatus = $product->stock_status;
                            $stockStatusLabel = $product->getStockStatusLabel();
                            $stockStatusColor = $product->getStockStatusColor();
                        @endphp
                        
                        <div class="product-card">
                            <!-- Product Image -->
                            <div class="product-image-container">
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $product->name }}"
                                         class="product-image">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-laptop text-5xl text-gray-500 mb-2"></i>
                                            <p class="text-gray-400 text-sm">No Image</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Discount Badge -->
                                @if($hasDiscount && $discountPercentage > 0)
                                    <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold z-10 shadow-lg">
                                        -{{ $discountPercentage }}%
                                    </div>
                                @endif
                                
                                <!-- Condition Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="bg-primary/90 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                        {{ $condition }}
                                    </span>
                                </div>
                                
                                <!-- Stock Badge -->
                                <div class="absolute bottom-4 right-4">
                                    <span class="product-badge {{ $stockStatus === 'out_of_stock' ? 'badge-out' : ($stockStatus === 'low_stock' ? 'badge-low' : 'badge-available') }}">
                                        @if($stockStatus === 'out_of_stock')
                                            <i class="fas fa-times mr-1"></i>Habis
                                        @elseif($stockStatus === 'low_stock')
                                            <i class="fas fa-exclamation mr-1"></i>Menipis
                                        @else
                                            <i class="fas fa-check mr-1"></i>Tersedia
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="product-content">
                                <!-- Category -->
                                <div class="flex justify-between items-center mb-3">
                                    <span class="product-category">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                    @if($warranty !== 'Tidak Ada Garansi')
                                        <span class="text-green-400 text-xs font-bold bg-green-900/30 px-2 py-1 rounded">
                                            <i class="fas fa-shield-alt mr-1"></i>{{ $warranty }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Product Name -->
                                <h3 class="product-title">{{ $product->name }}</h3>
                                
                                <!-- Stock Info Bar -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                                        <span>Stok: {{ $currentStock }} {{ $product->unit }}</span>
                                        @if($product->max_stock && $product->max_stock > 0)
                                            <span>Max: {{ $product->max_stock }}</span>
                                        @endif
                                    </div>
                                    @if($product->max_stock && $product->max_stock > 0)
                                        <div class="w-full bg-gray-700 rounded-full h-2">
                                            <div class="bg-primary rounded-full h-2 transition-all duration-500" 
                                                 style="width: {{ min(100, ($currentStock / $product->max_stock) * 100) }}%">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Specifications -->
                                <div class="mb-4">
                                    <h4 class="text-sm font-bold text-primary mb-2">Spesifikasi:</h4>
                                    <div class="product-specs">
                                        @if($product->specification && !empty(trim($product->specification)))
                                            {!! nl2br(e(Str::limit($product->specification, 120))) !!}
                                        @else
                                            <span class="text-gray-500 italic">
                                                <i class="fas fa-info-circle mr-1"></i>Spesifikasi tidak tersedia
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Additional Information -->
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-flex items-center text-xs bg-blue-900/30 text-blue-300 px-2 py-1 rounded">
                                            <i class="fas fa-truck mr-1"></i>{{ $shipping }}
                                        </span>
                                        @if($product->unit !== 'pcs')
                                            <span class="inline-flex items-center text-xs bg-purple-900/30 text-purple-300 px-2 py-1 rounded">
                                                <i class="fas fa-box mr-1"></i>{{ $product->unit }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Pricing -->
                                <div class="product-pricing">
                                    <div class="price-display">
                                        <div class="flex flex-col">
                                            @if($hasDiscount)
                                                <!-- Discount Price (Highlighted) -->
                                                <span class="current-price text-2xl">
                                                    Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                                </span>
                                                <!-- Original Price (Striked) -->
                                                <span class="original-price text-sm">
                                                    Rp {{ number_format($sellingPrice, 0, ',', '.') }}
                                                </span>
                                                <!-- Discount Amount -->
                                                <span class="text-red-400 text-xs font-bold mt-1">
                                                    Hemat Rp {{ number_format($discountAmount, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <!-- Normal Price -->
                                                <span class="current-price text-2xl">
                                                    Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Discount Badge (Large) -->
                                        @if($hasDiscount && $discountPercentage > 0)
                                            <div class="discount-badge-large">
                                                {{ $discountPercentage }}% OFF
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="product-actions mt-4">
                                        <a href="{{ route('main.products.show', $product->id) }}" 
                                           class="btn-detail">
                                            <i class="fas fa-eye mr-2"></i>Detail
                                        </a>
                                        <a href="https://wa.me/6282133803940?text=Halo,%20saya%20tertarik%20dengan%20produk:%0A%0A*{{ urlencode($product->name) }}*%0AHarga: Rp {{ number_format($finalPrice, 0, ',', '.') }}%0A%0ASpesifikasi:%20{{ urlencode(Str::limit($product->specification, 100)) }}%0AKondisi: {{ urlencode($condition) }}%0AGaransi: {{ urlencode($warranty) }}%0A%0AApakah%20masih%20tersedia?" 
                                           target="_blank"
                                           class="btn-buy btn-whatsapp {{ $currentStock == 0 ? 'btn-disabled' : '' }}"
                                           @if($currentStock == 0) onclick="return false;" @endif>
                                            @if($currentStock == 0)
                                                <i class="fas fa-times mr-2"></i>Habis
                                            @else
                                                <i class="fab fa-whatsapp mr-2"></i>Beli
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="col-span-full text-center py-16">
                        <div class="w-32 h-32 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-box-open text-4xl text-primary"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Tidak Ada Produk</h3>
                        <p class="text-gray-400 max-w-md mx-auto mb-8">
                            Belum ada produk yang tersedia saat ini. Silakan kembali lagi nanti.
                        </p>
                    </div>
                @endif
            </div>

            @if(isset($products) && $products->count() > 0)
                <div class="text-center mt-16">
                    <a href="{{ route('main.products.index') }}" 
                       class="inline-flex items-center justify-center bg-primary hover:bg-primary-dark text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                        Lihat Semua Produk
                        <i class="fas fa-arrow-right ml-3 text-lg"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimoni" class="py-20 bg-dark">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    Testimoni Klien
                </h2>
                <p class="section-subtitle">
                    Pendapat dari pelanggan yang telah menggunakan layanan dan produk kami
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="testimonial-card">
                    <div class="testimonial-quote">"</div>
                    <p class="text-gray-300 mb-8 text-lg">
                        "Pelayanan sangat memuaskan, teknisi profesional dan harga terjangkau. Recommended banget!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-xl text-primary"></i>
                        </div>
                        <div>
                            <div class="font-bold text-lg">Andi Wijaya</div>
                            <div class="text-gray-400">Pengusaha</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-quote">"</div>
                    <p class="text-gray-300 mb-8 text-lg">
                        "Laptop saya rusak parah, tapi bisa diperbaiki dengan baik dan cepat. Terima kasih Glorious Computer!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-xl text-primary"></i>
                        </div>
                        <div>
                            <div class="font-bold text-lg">Budi Santoso</div>
                            <div class="text-gray-400">Mahasiswa</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-quote">"</div>
                    <p class="text-gray-300 mb-8 text-lg">
                        "Sudah langganan service di sini, selalu puas dengan hasilnya. Support 24 jam juga sangat membantu."
                    </p>
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-primary/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-xl text-primary"></i>
                        </div>
                        <div>
                            <div class="font-bold text-lg">Citra Dewi</div>
                            <div class="text-gray-400">Freelancer</div>
                        </div>
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
    <section class="py-24 bg-gradient-to-r from-primary to-accent relative overflow-hidden">
        <div class="container relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-black mb-6 text-white">Siap Membantu Kebutuhan Teknologi Anda</h2>
                <p class="text-white/95 text-xl mb-12 leading-relaxed">
                    Dapatkan solusi terbaik untuk komputer, laptop, dan perangkat elektronik Anda dengan layanan profesional dari tim ahli kami.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="https://wa.me/6282133803940" target="_blank" class="bg-white text-primary hover:bg-gray-100 font-black py-4 px-10 rounded-full transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl flex items-center text-lg">
                        <i class="fab fa-whatsapp mr-4 text-xl"></i> Hubungi via WhatsApp
                    </a>
                    <a href="tel:082133803940" class="bg-transparent border-3 border-white text-white hover:bg-white/15 font-bold py-4 px-10 rounded-full transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl flex items-center text-lg">
                        <i class="fas fa-phone-alt mr-4 text-xl"></i> Telepon Sekarang
                    </a>
                </div>
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
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.service-card, .stat-item, .product-card, .testimonial-card, .contact-card');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.1;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = 1;
                    element.style.transform = 'translateY(0) scale(1)';
                }
            });
        }
        
        // Initialize elements for animation
        document.querySelectorAll('.service-card, .stat-item, .product-card, .testimonial-card, .contact-card').forEach(element => {
            element.style.opacity = 0;
            element.style.transform = 'translateY(30px) scale(0.95)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        });
        
        // Listen for scroll events
        window.addEventListener('scroll', animateOnScroll);
        // Initial check on page load
        window.addEventListener('load', () => {
            animateOnScroll();
            // Add animation class to hero elements
            document.querySelectorAll('.hero-badge, .hero-main-title-modern, .hero-subtitle-modern, .hero-tagline-modern, .hero-description-modern, .hero-buttons-modern, .hero-stats-modern').forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
                el.classList.add('animate-fade-in-up');
            });
        });

        // Parallax effect for floating elements
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.floating-element');
            
            parallaxElements.forEach((element, index) => {
                const speed = 0.2 + (index * 0.05);
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });
    </script>
</body>
</html>