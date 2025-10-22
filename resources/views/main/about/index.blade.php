@extends('layouts.theme')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Glorious Computer</title>
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
 /* Hero Section - About Us Version */
    .hero-about {
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

    .hero-about::before {
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

    .hero-about::after {
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

    .hero-content-about {
        max-width: 800px;
        text-align: center;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .hero-about h1 {
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

    .hero-about h1 span {
        background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
    }

    /* .hero-about h1 span::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 8px;
        background: linear-gradient(90deg, 
            rgba(255, 107, 0, 0.3) 0%, 
            rgba(255, 140, 66, 0.2) 100%);
        z-index: -1;
        border-radius: 4px;
    } */

    .hero-about p {
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

    .cta-button-about {
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

    .cta-button-about::before {
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

    .cta-button-about:hover::before {
        left: 100%;
    }

    .cta-button-about:hover {
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

    /* Responsive Design untuk Hero About */
    @media (max-width: 992px) {
        .hero-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .hero-about h1 {
            font-size: 3rem;
        }
    }

    @media (max-width: 768px) {
        .hero-stats {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .hero-about h1 {
            font-size: 2.5rem;
        }
        
        .hero-about p {
            font-size: 1.1rem;
        }
        
        .hero-stat {
            padding: 20px;
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

/* About Section */
#story {
    background: linear-gradient(135deg, #0A0A0A 0%, #1A1A1A 50%, #0A0A0A 100%);
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
        rgba(255, 107, 0, 0.3) 50%, 
        transparent 100%);
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
}

.stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 40px;
}

.stat-item {
    background: linear-gradient(135deg, #1A1A1A 0%, #252525 100%);
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.05);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.stat-item:hover {
    transform: translateY(-5px);
    border-color: rgba(255, 107, 0, 0.2);
    box-shadow: 0 8px 30px rgba(255, 107, 0, 0.15);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: block;
}

.stat-label {
    color: #A0A0A0;
    font-size: 0.9rem;
    font-weight: 500;
}

.about-image {
    position: relative;
}

.about-image img {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.image-overlay {
    position: absolute;
    bottom: -20px;
    right: -20px;
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
    border-radius: 12px;
    z-index: -1;
    opacity: 0.8;
}

/* Values Section */
.values {
    background: linear-gradient(135deg, #121212 0%, #1E1E1E 50%, #121212 100%);
    position: relative;
}

.values::before {
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

.values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.value-card {
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

.value-card::before {
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

.value-card:hover::before {
    left: 100%;
}

.value-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(255, 107, 0, 0.15);
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
}

.value-icon i {
    font-size: 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.value-title {
    font-size: 1.5rem;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.value-description {
    color: #B0B0B0;
    line-height: 1.6;
}

/* Timeline Section */
section:not(.hero):not(.values):not(.cta-section) {
    background: linear-gradient(135deg, #0A0A0A 0%, #151515 50%, #0A0A0A 100%);
}

.timeline {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 2px;
    background: linear-gradient(180deg, 
        transparent 0%, 
        rgba(255, 107, 0, 0.5) 50%, 
        transparent 100%);
    transform: translateX(-50%);
}

.timeline-item {
    margin-bottom: 60px;
    position: relative;
    width: 50%;
    padding-right: 40px;
}

.timeline-item:nth-child(even) {
    margin-left: 50%;
    padding-right: 0;
    padding-left: 40px;
}

.timeline-content {
    background: linear-gradient(135deg, #1A1A1A 0%, #252525 100%);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.08);
}

.timeline-content::after {
    content: '';
    position: absolute;
    top: 20px;
    right: -10px;
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 10px solid #252525;
}

.timeline-item:nth-child(even) .timeline-content::after {
    right: auto;
    left: -10px;
    border-left: none;
    border-right: 10px solid #252525;
}

.timeline-year {
    position: absolute;
    top: 20px;
    right: -80px;
    background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    z-index: 1;
    box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
}

.timeline-item:nth-child(even) .timeline-year {
    right: auto;
    left: -80px;
}

.timeline-title {
    font-size: 1.3rem;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.timeline-description {
    color: #B0B0B0;
    line-height: 1.6;
}

/* Team Section */
.team-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.team-member {
    background: linear-gradient(135deg, #1A1A1A 0%, #252525 100%);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}

.team-member:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(255, 107, 0, 0.15);
    border-color: rgba(255, 107, 0, 0.3);
}

.member-image {
    height: 300px;
    overflow: hidden;
    position: relative;
}

.member-image::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(transparent, rgba(10, 10, 10, 0.8));
}

.member-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.team-member:hover .member-image img {
    transform: scale(1.1);
}

.member-info {
    padding: 25px;
    text-align: center;
    position: relative;
}

.member-name {
    font-size: 1.3rem;
    margin-bottom: 5px;
    background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.member-role {
    background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 15px;
    font-weight: 600;
}

.member-bio {
    color: #B0B0B0;
    font-size: 0.9rem;
    line-height: 1.5;
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

/* Footer */
footer {
    background: linear-gradient(135deg, #0A0A0A 0%, #121212 100%);
    padding: 80px 0 30px;
    position: relative;
}

footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(255, 107, 0, 0.5) 50%, 
        transparent 100%);
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 40px;
    margin-bottom: 60px;
}

.footer-logo {
    font-size: 1.8rem;
    font-weight: 800;
    background: linear-gradient(135deg, #FFFFFF 0%, #E8E8E8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
}

.footer-logo span {
    background: linear-gradient(135deg, var(--primary) 0%, #FF8C42 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
        .footer-logo span {
            color: var(--primary);
        }

        .footer-about {
            color: var(--gray);
            margin-bottom: 25px;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: var(--gray-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .footer-heading {
            font-size: 1.2rem;
            color: white;
            margin-bottom: 25px;
            position: relative;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--primary);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer-contact li {
            display: flex;
            margin-bottom: 15px;
            color: var(--gray);
        }

        .footer-contact i {
            color: var(--primary);
            margin-right: 10px;
            width: 20px;
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--gray-light);
            color: var(--gray);
            font-size: 0.9rem;
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
            .about-content {
                grid-template-columns: 1fr;
            }
            
            .values-grid, .team-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
            
            .hero h1 {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            .values-grid, .team-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
            
            .timeline::before {
                left: 30px;
            }
            
            .timeline-item {
                width: 100%;
                padding-right: 0;
                padding-left: 70px;
            }
            
            .timeline-item:nth-child(even) {
                margin-left: 0;
                padding-left: 70px;
            }
            
            .timeline-year {
                left: 0;
                right: auto;
            }
            
            .timeline-item:nth-child(even) .timeline-year {
                left: 0;
            }
            
            .timeline-content::after {
                display: none;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
      <!-- Hero Section - About Us Version -->
    <section class="hero-about">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="container">
            <div class="hero-content-about animate">
                <h1>Tentang <span>Glorious Computer</span></h1>
                <p>Lebih dari 10 tahun menjadi partner terpercaya dalam solusi teknologi dan service komputer di Purbalingga dan sekitarnya.</p>
                <a href="#story" class="cta-button-about">Jelajahi Cerita Kami</a>
                
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

    <!-- About Story Section -->
    <section id="story">
        <div class="container">
            <div class="section-header animate">
                <h2 class="section-title">Cerita Kami</h2>
                <p class="section-subtitle">Perjalanan Glorious Computer dari awal hingga menjadi yang terpercaya seperti sekarang</p>
            </div>
            <div class="about-content">
                <div class="about-text animate">
                    <h2>Visi & Misi Perusahaan</h2>
                    <p>Glorious Computer didirikan pada tahun 2013 dengan visi untuk menjadi penyedia solusi teknologi terdepan di Purbalingga. Berawal dari sebuah bengkel kecil di Jl. Argandaru, kami telah berkembang menjadi perusahaan yang melayani ratusan klien dari berbagai sektor.</p>
                    <p>Dengan komitmen pada kualitas dan kepuasan pelanggan, kami terus berinovasi dalam memberikan layanan terbaik untuk komputer, laptop, dan printer. Setiap teknisi kami memiliki sertifikasi dan pengalaman yang memadai untuk menangani berbagai masalah teknologi.</p>
                    <div class="stats">
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
                            <span class="stat-label">Perangkat Diperbaiki</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Support Aktif</span>
                        </div>
                    </div>
                </div>
                <div class="about-image animate">
                    <img src="https://images.unsplash.com/photo-1565688534245-05d6b5be184a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Workshop Glorious Computer">
                    <div class="image-overlay"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values">
        <div class="container">
            <div class="section-header animate">
                <h2 class="section-title">Nilai-Nilai Kami</h2>
                <p class="section-subtitle">Prinsip-prinsip yang menjadi pedoman dalam setiap interaksi dan layanan kami</p>
            </div>
            <div class="values-grid">
                <div class="value-card animate">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3 class="value-title">Integritas</h3>
                    <p class="value-description">Kami selalu jujur dan transparan dalam setiap interaksi dengan pelanggan. Setiap diagnosis dan rekomendasi didasarkan pada kebutuhan nyata.</p>
                </div>
                <div class="value-card animate">
                    <div class="value-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="value-title">Kualitas</h3>
                    <p class="value-description">Kami hanya menggunakan komponen berkualitas tinggi dan menerapkan standar terbaik dalam setiap perbaikan. Kualitas adalah prioritas utama kami.</p>
                </div>
                <div class="value-card animate">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="value-title">Komitmen</h3>
                    <p class="value-description">Kami berkomitmen penuh untuk memberikan solusi terbaik bagi setiap masalah teknologi yang dihadapi pelanggan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    {{-- <section>
        <div class="container">
            <div class="section-header animate">
                <h2 class="section-title">Perjalanan Kami</h2>
                <p class="section-subtitle">Jejak langkah Glorious Computer dari awal berdiri hingga sekarang</p>
            </div>
            <div class="timeline">
                <div class="timeline-item animate">
                    <div class="timeline-year">2005</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Pendirian Glorious Computer</h3>
                        <p class="timeline-description">Glorious Computer didirikan dengan fokus pada perbaikan komputer dan laptop di Jl. Argandaru, Bukateja, Purbalingga.</p>
                    </div>
                </div>
                <div class="timeline-item animate">
                    <div class="timeline-year">2015</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Ekspansi Layanan Penjualan</h3>
                        <p class="timeline-description">Memperluas layanan ke penjualan komputer rakitan dan aksesori IT untuk memenuhi kebutuhan pelanggan yang semakin beragam.</p>
                    </div>
                </div>
                <div class="timeline-item animate">
                    <div class="timeline-year">2018</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Perluasan ke Service Printer</h3>
                        <p class="timeline-description">Menambah layanan perbaikan dan perawatan printer untuk melengkapi portofolio layanan teknologi yang komprehensif.</p>
                    </div>
                </div>
                <div class="timeline-item animate">
                    <div class="timeline-year">2020</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Pengembangan Layanan Konsultasi IT</h3>
                        <p class="timeline-description">Mengembangkan layanan konsultasi IT untuk bisnis kecil dan menengah, membantu mereka mengoptimalkan penggunaan teknologi.</p>
                    </div>
                </div>
                <div class="timeline-item animate">
                    <div class="timeline-year">2023</div>
                    <div class="timeline-content">
                        <h3 class="timeline-title">Pencapaian 500+ Klien</h3>
                        <p class="timeline-description">Mencapai tonggak sejarah dengan melayani lebih dari 500 klien dari berbagai latar belakang dan sektor industri.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Team Section -->
    {{-- <section class="values">
        <div class="container">
            <div class="section-header animate">
                <h2 class="section-title">Tim Kami</h2>
                <p class="section-subtitle">Para ahli di balik layanan profesional Glorious Computer</p>
            </div>
            <div class="team-grid">
                <div class="team-member animate">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Ahmad Fauzi">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">Ahmad Fauzi</h3>
                        <p class="member-role">Pendiri & Teknisi Senior</p>
                        <p class="member-bio">Lebih dari 12 tahun pengalaman di bidang teknologi dan perbaikan komputer. Spesialis hardware dan sistem.</p>
                    </div>
                </div>
                <div class="team-member animate">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Rina Wijaya">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">Rina Wijaya</h3>
                        <p class="member-role">Manajer Layanan</p>
                        <p class="member-bio">Mengelola operasional harian dan memastikan setiap pelanggan mendapatkan pengalaman layanan terbaik.</p>
                    </div>
                </div>
                <div class="team-member animate">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Budi Santoso">
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">Budi Santoso</h3>
                        <p class="member-role">Teknisi Printer</p>
                        <p class="member-bio">Spesialis perbaikan dan perawatan printer dengan sertifikasi dari berbagai merek printer ternama.</p>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="animate">Percayakan Teknologi Anda Pada Kami</h2>
            <p class="animate">Dengan pengalaman lebih dari 10 tahun, kami siap memberikan solusi terbaik untuk semua kebutuhan teknologi Anda.</p>
            <div class="cta-buttons">
                <a href="{{ route('main.services.index') }}" class="btn btn-primary animate">Lihat Layanan</a>
                <a href="#kontak" class="btn btn-secondary animate">Hubungi Kami</a>
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
</body>
</html>