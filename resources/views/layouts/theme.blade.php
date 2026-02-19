<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Glorious Computer - Solusi Teknologi Premium')</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#FFF7ED',
                            100: '#FFEDD5',
                            200: '#FED7AA',
                            300: '#FDBA74',
                            400: '#FF8C42',
                            500: '#FF6B00',  // Main brand orange
                            600: '#E05D00',
                            700: '#C44D00',
                            800: '#9C3D00',
                            900: '#7C3100',
                        },
                        secondary: '#00A8FF',
                        accent: '#9C27B0',
                        dark: {
                            900: '#0A0A0A',
                            800: '#121212',
                            700: '#1A1A1A',
                            600: '#242424',
                            500: '#2D2D2D',
                        },
                        light: {
                            DEFAULT: '#F8FAFC',
                            dim: '#E2E8F0'
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        'heading': ['Plus Jakarta Sans', 'Inter', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'pulse-slow': 'pulse 2s infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'heartbeat': 'heartbeat 1.5s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite'
                    },
                    boxShadow: {
                        'soft': '0 4px 20px rgba(0, 0, 0, 0.08)',
                        'glow-sm': '0 0 10px rgba(255, 107, 0, 0.2)',
                        'glow-md': '0 0 20px rgba(255, 107, 0, 0.3)',
                        'glow-lg': '0 0 30px rgba(255, 107, 0, 0.4)',
                        'glow-xl': '0 0 40px rgba(255, 107, 0, 0.5)',
                        'elevated': '0 10px 30px rgba(0, 0, 0, 0.2), 0 0 20px rgba(255, 107, 0, 0.15)',
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'gradient-primary': 'linear-gradient(135deg, #FF6B00 0%, #FF8C42 100%)',
                        'gradient-primary-hover': 'linear-gradient(135deg, #E05D00 0%, #FF6B00 100%)',
                    },
                    borderRadius: {
                        '4xl': '2rem',
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts - Inter + Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AlpineJS -->
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ===========================
           CSS VARIABLES
           =========================== */
        :root {
            --primary: #FF6B00;
            --primary-dark: #E05D00;
            --primary-light: #FF8C42;
            --dark-900: #0A0A0A;
            --dark-800: #121212;
            --dark-700: #1A1A1A;
        }
        
        /* ===========================
           KEYFRAME ANIMATIONS
           =========================== */
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes heartbeat {
            0% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(1); }
            75% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 107, 0, 0.3); }
            50% { box-shadow: 0 0 40px rgba(255, 107, 0, 0.6); }
        }

        /* Chatbase bubble animations */
        @keyframes chatbasePulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
        }

        @keyframes chatbaseBounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes chatbaseGlow {
            0%, 100% {
                box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4),
                            0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            50% {
                box-shadow: 0 4px 25px rgba(59, 130, 246, 0.6),
                            0 0 0 8px rgba(59, 130, 246, 0);
            }
        }

        @keyframes chatbaseShake {
            0%, 100% { transform: rotate(0deg); }
            10%, 30%, 50%, 70%, 90% { transform: rotate(-5deg); }
            20%, 40%, 60%, 80% { transform: rotate(5deg); }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* ===========================
           SCROLLBAR STYLING
           =========================== */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark-700);
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8C42 100%);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #E05D00 0%, #FF6B00 100%);
        }
        
        /* ===========================
           NAVBAR SHRINK EFFECT
           =========================== */
        nav.navbar-shrink {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        nav.navbar-shrink .logo-container {
            transform: scale(0.9);
        }
        
        /* ===========================
           UTILITY CLASSES
           =========================== */
        
        .glass {
            background: rgba(26, 26, 26, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8C42 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .shimmer-text {
            background: linear-gradient(90deg, #FF6B00 0%, #FF8C42 25%, #FF6B00 50%, #FF8C42 75%, #FF6B00 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }
        
        /* Hover Lift Effect */
        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                        box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3),
                        0 0 30px rgba(255, 107, 0, 0.15);
        }
        
        /* Hover Scale */
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        /* Smooth Transitions */
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Optimized premium glow - lightweight but visible */
        .brand-logo-glow {
            display: block;
            transform: translateZ(0);
            /* Optimized: hanya 3 layer untuk performa lebih baik + brightness untuk text hitam */
            filter:
                drop-shadow(0 0 12px rgba(255, 107, 0, 0.35))
                drop-shadow(0 0 28px rgba(255, 107, 0, 0.25))
                drop-shadow(0 0 50px rgba(255, 107, 0, 0.18))
                brightness(1.1)
                contrast(1.05);
            transition: filter 200ms ease, transform 200ms ease;
        }

        .group:hover .brand-logo-glow,
        .group:focus-visible .brand-logo-glow {
            transform: translateZ(0) scale(1.02);
            filter:
                drop-shadow(0 0 15px rgba(255, 107, 0, 0.45))
                drop-shadow(0 0 35px rgba(255, 107, 0, 0.35))
                drop-shadow(0 0 60px rgba(255, 107, 0, 0.25))
                brightness(1.15)
                contrast(1.08);
        }

        /* ===========================
           CHATBASE BUBBLE ANIMATIONS
           =========================== */
        /* Animate Chatbase bubble button ONLY - not the chat window */
        #chatbase-bubble,
        #chatbase-bubble-button,
        [id*="chatbase-bubble"]:not([id*="widget"]):not([id*="container"]):not([id*="window"]),
        [class*="chatbase-bubble"]:not([class*="widget"]):not([class*="container"]):not([class*="window"]),
        button[aria-label*="chat"],
        button[aria-label*="Chat"] {
            animation: chatbaseBounce 2s ease-in-out infinite,
                       chatbaseGlow 2s ease-in-out infinite;
            transition: all 0.3s ease;
        }

        /* Hover effect untuk Chatbase bubble ONLY */
        #chatbase-bubble:hover,
        #chatbase-bubble-button:hover,
        [id*="chatbase-bubble"]:hover:not([id*="widget"]):not([id*="container"]):not([id*="window"]) {
            animation: chatbasePulse 0.6s ease-in-out infinite,
                       chatbaseBounce 2s ease-in-out infinite;
            transform: scale(1.1);
        }

        /* Disable animations untuk chat window/container yang terbuka */
        iframe[src*="chatbase.co"],
        [id*="chatbase-widget"],
        [id*="chatbase-container"],
        [id*="chatbase-window"],
        [class*="chatbase-widget"],
        [class*="chatbase-container"],
        [class*="chatbase-window"],
        div:has(iframe[src*="chatbase.co"]) {
            animation: none !important;
            transition: opacity 0.3s ease, transform 0.3s ease !important;
        }

        /* Pulse effect untuk menarik perhatian - hanya bubble */
        @media (prefers-reduced-motion: no-preference) {
            #chatbase-bubble,
            #chatbase-bubble-button,
            [id*="chatbase-bubble"]:not([id*="widget"]):not([id*="container"]):not([id*="window"]) {
                animation: chatbaseBounce 2.5s ease-in-out infinite,
                           chatbaseGlow 2s ease-in-out infinite;
            }
        }

        /* Shake animation saat pertama kali muncul (optional) - hanya bubble */
        @keyframes chatbaseEntrance {
            0% {
                opacity: 0;
                transform: scale(0) rotate(-180deg);
            }
            60% {
                transform: scale(1.2) rotate(10deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        /* Apply entrance animation on load - hanya bubble button */
        #chatbase-bubble,
        #chatbase-bubble-button {
            animation: chatbaseEntrance 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55),
                       chatbaseBounce 2.5s ease-in-out 0.8s infinite,
                       chatbaseGlow 2s ease-in-out 0.8s infinite;
        }
        
        /* ===========================
           MOBILE MENU
           =========================== */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
        }
        
        .mobile-menu.open {
            max-height: 600px;
        }
        
        .products-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .products-submenu.open {
            max-height: 400px;
        }
        
        .hamburger-line {
            display: block;
            width: 24px;
            height: 2px;
            background-color: #F8FAFC;
            margin: 5px 0;
            transition: all 0.3s ease;
            transform-origin: center;
            border-radius: 2px;
        }
        
        .hamburger-active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
            background-color: var(--primary);
        }
        
        .hamburger-active .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger-active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
            background-color: var(--primary);
        }
        
        /* ===========================
           CART SIDEBAR
           =========================== */
        .cart-sidebar {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .cart-sidebar.open {
            transform: translateX(0);
        }
        
        .cart-item {
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background: rgba(255, 107, 0, 0.05);
        }
        
        .close-button {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .close-button:hover {
            color: #FF6B00;
            transform: scale(1.1);
        }
        
        /* ===========================
           POPUP SYSTEM
           =========================== */
        .popup-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            padding: 20px;
        }
        
        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .popup-content {
            background: linear-gradient(145deg, #1E1E1E, #121212);
            border: 1px solid rgba(255, 107, 0, 0.2);
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px) scale(0.95);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        
        .popup-overlay.active .popup-content {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        
        .popup-content.large {
            max-width: 900px;
        }
        
        .popup-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .popup-content::-webkit-scrollbar-track {
            background: rgba(30, 30, 30, 0.5);
            border-radius: 3px;
        }
        
        .popup-content::-webkit-scrollbar-thumb {
            background: rgba(255, 107, 0, 0.5);
            border-radius: 3px;
        }
        
        .popup-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 107, 0, 0.8);
        }
        
        @media (max-width: 640px) {
            .popup-overlay {
                padding: 10px;
            }
            
            .popup-content {
                max-height: 95vh;
                margin: 10px;
            }
            
            .popup-content.large {
                max-width: 100%;
            }
        }
        
        body.popup-open {
            overflow: hidden;
        }
        
        /* ===========================
           FORM STYLING
           =========================== */
        .form-input {
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #1a1a1a, #222222);
            border: 1px solid #2d2d2d;
        }
        
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 0, 0.2), 0 0 0 2px rgba(255, 107, 0, 0.1);
            border-color: #FF6B00;
        }
        
        .form-input:hover {
            border-color: #FF8C42;
        }
        
        /* ===========================
           BUTTON ANIMATIONS
           =========================== */
        .btn-primary {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8C42 100%);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 107, 0, 0.3);
        }
        
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::after {
            left: 100%;
        }
        
        /* ===========================
           TOAST NOTIFICATIONS
           =========================== */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            animation: slideDown 0.3s ease-out;
        }
        
        /* ===========================
           LOADING SPINNER
           =========================== */
        .spinner {
            border: 3px solid rgba(255, 107, 0, 0.2);
            border-top-color: #FF6B00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* ===========================
           GRADIENT BACKGROUND
           =========================== */
        .gradient-bg {
            background: linear-gradient(-45deg, #0A0A0A, #121212, #1A1A1A, #0A0A0A);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }
        
        /* ===========================
           ALERT MESSAGES
           =========================== */
        .alert-success {
            background: linear-gradient(135deg, rgba(0, 200, 83, 0.1), rgba(0, 200, 83, 0.05));
            border: 1px solid rgba(0, 200, 83, 0.3);
        }
        
        .alert-error {
            background: linear-gradient(135deg, rgba(255, 71, 87, 0.1), rgba(255, 71, 87, 0.05));
            border: 1px solid rgba(255, 71, 87, 0.3);
        }
        
        /* ===========================
           FAB BUTTON (WhatsApp)
           =========================== */
        .fab-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 40;
            animation: float 6s ease-in-out infinite;
        }
        
        /* ===========================
           PASSWORD STRENGTH
           =========================== */
        .password-strength {
            height: 4px;
            background: #444;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 8px;
        }
        
        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .strength-weak { width: 25%; background: #ff4757; }
        .strength-medium { width: 50%; background: #ffa502; }
        .strength-strong { width: 75%; background: #2ed573; }
        .strength-very-strong { width: 100%; background: #00b894; }
        
        /* ===========================
           CHECKBOX STYLING
           =========================== */
        .form-checkbox {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #444;
            border-radius: 4px;
            background: #1a1a1a;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }
        
        .form-checkbox:checked {
            background: #FF6B00;
            border-color: #FF6B00;
        }
        
        .form-checkbox:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 12px;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        /* ===========================
           REGISTRATION CONTAINER
           =========================== */
        .registration-container {
            display: flex;
            flex-direction: column;
        }
        
        @media (min-width: 1024px) {
            .registration-container {
                flex-direction: row;
            }
        }
        
        /* ===========================
           ALPINE.JS X-CLOAK
           =========================== */
        [x-cloak] {
            display: none !important;
        }
        
        /* ===========================
           RESPONSIVE UTILITIES
           =========================== */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    @stack('styles')
    @yield('head')
</head>
<body class="bg-dark-800 text-light font-sans antialiased flex flex-col min-h-screen gradient-bg">

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[10000] space-y-3 max-w-sm"></div>

   <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="yJu5HxQP_CuxK5NWRvTLA";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
<script>
// Ensure Chatbase bubble gets animations after load - ONLY BUBBLE, NOT CHAT WINDOW
(function() {
    function isChatWindow(el) {
        // Check if element is chat window/container, not bubble button
        const id = (el.id || '').toLowerCase();
        const className = (el.className || '').toLowerCase();
        const tagName = (el.tagName || '').toLowerCase();
        
        return id.includes('widget') || 
               id.includes('container') || 
               id.includes('window') ||
               className.includes('widget') ||
               className.includes('container') ||
               className.includes('window') ||
               tagName === 'iframe' ||
               el.querySelector('iframe');
    }
    
    function applyChatbaseAnimations() {
        const selectors = [
            '#chatbase-bubble',
            '#chatbase-bubble-button',
            '[id*="chatbase-bubble"]',
            '[class*="chatbase-bubble"]',
            'button[aria-label*="chat"]',
            'button[aria-label*="Chat"]'
        ];
        
        selectors.forEach(selector => {
            try {
                const elements = document.querySelectorAll(selector);
                elements.forEach(el => {
                    // Skip chat window/container
                    if (isChatWindow(el)) {
                        el.style.animation = 'none';
                        return;
                    }
                    
                    // Add animation only to bubble button
                    el.style.animation = 'chatbaseBounce 2.5s ease-in-out infinite, chatbaseGlow 2s ease-in-out infinite';
                    el.style.transition = 'all 0.3s ease';
                    el.style.cursor = 'pointer';
                    
                    // Add hover effect
                    el.addEventListener('mouseenter', function() {
                        if (!isChatWindow(this)) {
                            this.style.animation = 'chatbasePulse 0.6s ease-in-out infinite, chatbaseBounce 2.5s ease-in-out infinite';
                            this.style.transform = 'scale(1.1)';
                        }
                    });
                    
                    el.addEventListener('mouseleave', function() {
                        if (!isChatWindow(this)) {
                            this.style.animation = 'chatbaseBounce 2.5s ease-in-out infinite, chatbaseGlow 2s ease-in-out infinite';
                            this.style.transform = 'scale(1)';
                        }
                    });
                });
            } catch(e) {}
        });
        
        // Explicitly disable animations on chat windows
        try {
            const chatWindows = document.querySelectorAll(
                'iframe[src*="chatbase.co"], ' +
                '[id*="chatbase-widget"], ' +
                '[id*="chatbase-container"], ' +
                '[id*="chatbase-window"], ' +
                '[class*="chatbase-widget"], ' +
                '[class*="chatbase-container"], ' +
                '[class*="chatbase-window"]'
            );
            chatWindows.forEach(el => {
                el.style.animation = 'none';
                el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            });
        } catch(e) {}
    }
    
    // Run after page load
    window.addEventListener('load', () => {
        setTimeout(applyChatbaseAnimations, 1000);
        setTimeout(applyChatbaseAnimations, 2000);
        setTimeout(applyChatbaseAnimations, 3000);
    });
    
    // Also watch for dynamically added elements
    const observer = new MutationObserver(() => {
        applyChatbaseAnimations();
    });
    observer.observe(document.body, { childList: true, subtree: true });
})();
</script>

    <!-- NAVBAR PREMIUM REDESIGNED -->
    <nav id="main-navbar" 
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 glass border-b border-gray-800"
         x-data="{ 
             scrolled: false, 
             mobileOpen: false,
             productDropdownOpen: false
         }"
         x-init="
             window.addEventListener('scroll', () => {
                 scrolled = window.pageYOffset > 50;
                 if (scrolled) {
                     $el.classList.add('navbar-shrink');
                 } else {
                     $el.classList.remove('navbar-shrink');
                 }
             });
         "
         :class="scrolled ? 'bg-dark-900/95 backdrop-blur-lg border-b border-gray-800 shadow-xl py-3' : 'bg-dark-900/85 backdrop-blur-md border-b border-gray-800/50 py-4'">
        
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                
                <!-- LOGO -->
                <div class="flex-shrink-0 logo-container transition-all duration-300">
                    <a href="{{ url('/') }}" class="flex items-center group">
                        <div class="relative">
                            <div class="rounded-xl flex items-center justify-center overflow-visible group-hover:scale-105 transition-all duration-300"
                                 :class="scrolled ? 'w-28 h-10' : 'w-32 h-12'">
                                <img src="{{ asset('images/Logo2.png') }}"
                                     alt="Glorious Computer Logo"
                                     class="w-full h-full object-contain brand-logo-glow">
                            </div>
                        </div>
                    </a>
                </div>

                <!-- DESKTOP MENU -->
                <div class="hidden lg:flex items-center space-x-1">
                    <!-- Beranda -->
                    <a href="{{ url('/') }}" 
                       class="group relative px-4 py-2 rounded-lg transition-all duration-200 hover:bg-dark-700/50">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-home text-sm text-primary-400 opacity-80 group-hover:opacity-100 transition-opacity"></i>
                            <span class="text-gray-300 font-medium group-hover:text-white transition-colors">Beranda</span>
                        </div>
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-primary-600 to-primary-500 group-hover:w-2/3 transition-all duration-300 rounded-full"></div>
                    </a>

                    <!-- Tentang -->
                    <a href="{{ url('/') }}#tentang" 
                       class="group relative px-4 py-2 rounded-lg transition-all duration-200 hover:bg-dark-700/50">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-info-circle text-sm text-primary-400 opacity-80 group-hover:opacity-100 transition-opacity"></i>
                            <span class="text-gray-300 font-medium group-hover:text-white transition-colors">Tentang</span>
                        </div>
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-primary-600 to-primary-500 group-hover:w-2/3 transition-all duration-300 rounded-full"></div>
                    </a>

                    <!-- Produk Dropdown -->
                    <div class="relative z-[60]" 
                         @mouseenter="productDropdownOpen = true"
                         @mouseleave="productDropdownOpen = false">
                        
                        <div class="flex items-center">
                            <a href="{{ route('main.products.index') }}" 
                               class="group relative px-4 py-2 rounded-lg transition-all duration-200 hover:bg-dark-700/50">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-boxes text-sm text-primary-400 opacity-80 group-hover:opacity-100 transition-opacity"></i>
                                    <span class="text-gray-300 font-medium group-hover:text-white transition-colors">Produk</span>
                                </div>
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-primary-600 to-primary-500 group-hover:w-2/3 transition-all duration-300 rounded-full"></div>
                            </a>
                            
                            <button type="button" 
                                    @click="productDropdownOpen = !productDropdownOpen"
                                    class="p-2 hover:bg-dark-700/50 rounded-lg transition-colors z-[61] relative"
                                    aria-label="Toggle produk dropdown">
                                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-300"
                                   :class="productDropdownOpen ? 'rotate-180 text-primary-400' : ''"></i>
                            </button>
                        </div>

                        <!-- Dropdown Menu -->
                        <div x-show="productDropdownOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-64 bg-dark-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden z-[60]"
                             style="display: none;"
                             x-cloak>
                            
                            <div class="px-4 py-3 border-b border-gray-700 bg-dark-700/30">
                                <h3 class="text-white font-semibold text-sm flex items-center gap-2">
                                    <i class="fas fa-layer-group text-primary-400"></i>
                                    Kategori Produk
                                </h3>
                            </div>
                            
                            <a href="{{ route('main.products.index') }}"
                               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:bg-primary-500/10 hover:text-white transition-all border-b border-gray-700/50 group">
                                <i class="fas fa-th-large text-primary-400 group-hover:scale-110 transition-transform"></i>
                                <span class="font-medium">Semua Produk</span>
                                <i class="fas fa-arrow-right text-xs ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
                            </a>
                            
                            <div class="px-2 py-2">
                                <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </div>
                                <div class="space-y-1 max-h-64 overflow-y-auto">
                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories->take(8) as $category)
                                            <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}"
                                               class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 hover:text-white hover:bg-dark-700 rounded-lg transition-all group">
                                                <i class="fas fa-folder text-primary-400 text-xs group-hover:scale-110 transition-transform"></i>
                                                <span class="truncate">{{ $category->name }}</span>
                                                <i class="fas fa-chevron-right text-xs ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="px-3 py-6 text-center text-gray-500 text-sm">
                                            <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                                            <p>Belum ada kategori</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan -->
                    <a href="#services" 
                       class="group relative px-4 py-2 rounded-lg transition-all duration-200 hover:bg-dark-700/50">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-cogs text-sm text-primary-400 opacity-80 group-hover:opacity-100 transition-opacity"></i>
                            <span class="text-gray-300 font-medium group-hover:text-white transition-colors">Layanan</span>
                        </div>
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-primary-600 to-primary-500 group-hover:w-2/3 transition-all duration-300 rounded-full"></div>
                    </a>
                </div>

                <!-- RIGHT SIDE ACTIONS -->
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->role === 'Customer')
                            <!-- Wishlist -->
                            <a href="{{ route('wishlist.index') }}" 
                               id="wishlist-button"
                               class="relative p-2.5 rounded-xl hover:bg-dark-700/50 transition-all group">
                                <i class="fas fa-heart text-lg text-gray-400 group-hover:text-red-400 transition-colors"></i>
                                @if(isset($wishlistCount) && $wishlistCount > 0)
                                    <span class="wishlist-count-badge absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-primary-600 to-primary-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg">
                                        {{ $wishlistCount }}
                                    </span>
                                @else
                                    <span class="wishlist-count-badge absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-primary-600 to-primary-500 text-white text-xs font-bold rounded-full items-center justify-center shadow-lg hidden"></span>
                                @endif
                            </a>

                            <!-- Cart -->
                            <button id="cart-button" type="button"
                                    class="relative p-2.5 rounded-xl hover:bg-dark-700/50 transition-all group">
                                <i class="fas fa-shopping-cart text-lg text-gray-400 group-hover:text-primary-400 transition-colors"></i>
                                @if(isset($cartCount) && $cartCount > 0)
                                    <span class="cart-count-badge absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-primary-600 to-primary-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg">
                                        {{ $cartCount }}
                                    </span>
                                @else
                                    <span class="cart-count-badge absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-primary-600 to-primary-500 text-white text-xs font-bold rounded-full items-center justify-center shadow-lg hidden"></span>
                                @endif
                            </button>
                        @endif
                    @endauth

                    <!-- WhatsApp CTA -->
                    <a href="https://wa.me/6282133803940" 
                       target="_blank"
                       class="group relative inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary-500/30 overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                        <i class="fab fa-whatsapp relative z-10"></i>
                        <span class="relative z-10">Hubungi</span>
                    </a>

                    <!-- Profile Button -->
                    <button type="button" 
                            id="profile-popup-button"
                            class="relative w-10 h-10 rounded-full overflow-hidden bg-dark-700 hover:ring-2 hover:ring-primary-500 transition-all group focus:outline-none">
                        @auth
                            @if(auth()->user()->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists(auth()->user()->profile_photo_path))
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                     alt="Profile" 
                                     class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-gray-400 group-hover:text-white transition-colors"></i>
                            @endif
                        @else
                            <i class="fas fa-user text-gray-400 group-hover:text-white transition-colors"></i>
                        @endauth
                    </button>
                </div>

                <!-- MOBILE MENU TOGGLE -->
                <div class="lg:hidden flex items-center gap-3">
                    @auth
                        @if(auth()->user()->role === 'Customer')
                            <a href="{{ route('wishlist.index') }}" id="wishlist-button-mobile" class="relative p-2">
                                <i class="fas fa-heart text-lg text-gray-400"></i>
                                @if(isset($wishlistCount) && $wishlistCount > 0)
                                    <span class="wishlist-count-badge absolute -top-1 -right-1 w-5 h-5 bg-primary-500 text-white text-xs rounded-full flex items-center justify-center">
                                        {{ $wishlistCount }}
                                    </span>
                                @endif
                            </a>

                            <button id="cart-button-mobile" type="button" class="relative p-2">
                                <i class="fas fa-shopping-cart text-lg text-gray-400"></i>
                                @if(isset($cartCount) && $cartCount > 0)
                                    <span class="cart-count-badge absolute -top-1 -right-1 w-5 h-5 bg-primary-500 text-white text-xs rounded-full flex items-center justify-center">
                                        {{ $cartCount }}
                                    </span>
                                @else
                                    <span class="cart-count-badge absolute -top-1 -right-1 w-5 h-5 bg-primary-500 text-white text-xs rounded-full items-center justify-center hidden"></span>
                                @endif
                            </button>
                        @endif
                    @endauth
                    
                    <button id="menu-toggle" 
                            class="flex flex-col justify-center items-center w-10 h-10 focus:outline-none">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>
            </div>

            <!-- MOBILE MENU -->
            <div id="mobile-menu" class="lg:hidden mobile-menu bg-dark-700/50 border-t border-gray-700 rounded-b-2xl">
                <div class="px-4 py-4 space-y-1">
                    <a href="{{ url('/') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                        <i class="fas fa-home text-primary group-hover:text-white"></i>
                        <span class="font-medium">Beranda</span>
                    </a>
                    
                    <a href="{{ url('/') }}#about" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                        <i class="fas fa-info-circle text-primary group-hover:text-white"></i>
                        <span class="font-medium">Tentang</span>
                    </a>
                    
                    <div class="px-4 py-2">
                        <button id="mobile-products-toggle" 
                                class="flex items-center justify-between w-full text-gray-300 hover:text-primary transition-all p-2 focus:outline-none">
                            <div class="flex items-center">
                                <i class="fas fa-boxes mr-3 text-primary"></i>
                                <span class="font-medium">Produk</span>
                            </div>
                            <i class="fas fa-chevron-down transition-transform duration-300" id="products-arrow"></i>
                        </button>
                        
                        <div id="mobile-products-menu" class="products-submenu pl-8 space-y-1 mt-1">
                            <a href="{{ route('main.products.index') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-primary hover:text-white rounded-lg transition-all">
                                <i class="fas fa-th-large mr-3 w-4 text-center"></i>
                                Semua Produk
                            </a>
                            
                            @isset($categories)
                                @foreach($categories->take(5) as $category)
                                    <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}" 
                                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-primary hover:text-white rounded-lg transition-all">
                                        <i class="fas fa-folder mr-3 w-4 text-center"></i>
                                        <span>{{ $category->name }}</span>
                                    </a>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                    
                    <a href="#services" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                        <i class="fas fa-cogs text-primary group-hover:text-white"></i>
                        <span class="font-medium">Layanan</span>
                    </a>
                    
                    <a href="#contact" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                        <i class="fas fa-envelope text-primary group-hover:text-white"></i>
                        <span class="font-medium">Kontak</span>
                    </a>

                    <div class="border-t border-gray-700 pt-3 mt-2">
                        @auth
                            @if(auth()->user()->role === 'Customer')
                                <a href="{{ route('customer.profile.edit') }}" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                                    <i class="fas fa-user-cog mr-3 text-primary group-hover:text-white"></i>
                                    <span class="font-medium">Profile</span>
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                                    <i class="fas fa-heart mr-3 text-primary group-hover:text-white"></i>
                                    <span class="font-medium">Wishlist</span>
                                </a>
                                <a href="{{ route('cart.index') }}" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                                    <i class="fas fa-shopping-cart mr-3 text-primary group-hover:text-white"></i>
                                    <span class="font-medium">Keranjang</span>
                                </a>
                                <button type="button" id="mobile-logout-button" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-red-600 hover:text-white rounded-lg transition-all group">
                                    <i class="fas fa-sign-out-alt mr-3 text-primary group-hover:text-white"></i>
                                    <span class="font-medium">Logout</span>
                                </button>
                            @else
                                @php
                                    $dashUrl = match(auth()->user()->role ?? '') {
                                        'Admin' => route('admin.dashboard'),
                                        'Manajer Gudang' => route('manajergudang.dashboard'),
                                        'Staff Gudang' => route('staff.dashboard'),
                                        default => url('/'),
                                    };
                                @endphp
                                <a href="{{ $dashUrl }}" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                                    <i class="fas fa-tachometer-alt mr-3 text-primary group-hover:text-white"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                <button type="button" id="mobile-logout-button" class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-red-600 hover:text-white rounded-lg transition-all group">
                                    <i class="fas fa-sign-out-alt mr-3 text-primary group-hover:text-white"></i>
                                    <span class="font-medium">Logout</span>
                                </button>
                            @endif
                        @else
                            <button id="mobile-login-button" 
                                    class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                                <i class="fas fa-sign-in-alt mr-3 text-primary group-hover:text-white"></i>
                                <span class="font-medium">Login Pelanggan</span>
                            </button>
                            <button id="mobile-register-button" 
                                    class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-primary hover:text-white rounded-lg transition-all group">
                                <i class="fas fa-user-plus mr-3 text-primary group-hover:text-white"></i>
                                <span class="font-medium">Daftar Pelanggan</span>
                            </button>
                        @endauth
                    </div>

                    <a href="https://wa.me/6282133803940" 
                       target="_blank"
                       class="flex items-center justify-center btn-primary text-white px-4 py-3 rounded-xl font-semibold transition-all group mt-4">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <!-- Debug: tampilkan AUTH status (sembunyikan di production) -->
    <div id="auth-debug" style="display:none;" aria-hidden="true">AUTH: {{ auth()->check() ? 'YES' : 'NO' }}</div>

    <!-- Cart Sidebar -->
    <div id="cart-sidebar" class="cart-sidebar fixed top-0 right-0 h-full w-full lg:w-96 bg-dark-800 z-[70] shadow-2xl border-l border-gray-700">
        <div class="flex flex-col h-full">
            <!-- Cart Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-700">
                <div class="flex items-center">
                    <i class="fas fa-shopping-cart text-primary text-xl mr-3"></i>
                    <h3 class="text-xl font-bold text-white font-heading">Keranjang Belanja</h3>
                </div>
                <button id="cart-close-button" class="close-button text-gray-400 hover:text-white text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4" id="cart-items-container">
                @if(isset($cartItemsSidebar) && $cartItemsSidebar->count() > 0)
                    @php $sidebarTotal = 0; @endphp
                    <div class="space-y-3">
                        @foreach($cartItemsSidebar as $cartItem)
                            @if($cartItem->product)
                                @php
                                    $price = $cartItem->product->final_price ?? $cartItem->product->selling_price ?? 0;
                                    $sub = $price * $cartItem->quantity;
                                    $sidebarTotal += $sub;
                                    $imgUrl = $cartItem->product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($cartItem->product->image)
                                        ? asset('storage/' . $cartItem->product->image) : null;
                                @endphp
                                <div class="cart-item flex gap-3 p-3 rounded-lg bg-dark-700/50 border border-gray-700">
                                    @if($imgUrl)
                                        <img src="{{ $imgUrl }}" alt="" class="w-14 h-14 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-14 h-14 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0"><i class="fas fa-laptop text-gray-600"></i></div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-white font-medium text-sm truncate">{{ $cartItem->product->name }}</p>
                                        <p class="text-gray-400 text-xs">Rp {{ number_format($price, 0, ',', '.') }} × {{ $cartItem->quantity }}</p>
                                        <p class="text-primary font-semibold text-sm">Rp {{ number_format($sub, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('cart.index') }}" class="self-center text-gray-400 hover:text-primary text-sm" title="Kelola">→</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <p class="text-right text-gray-400 text-sm mt-2">{{ $cartItemsSidebar->sum('quantity') }} item</p>
                @else
                    <div class="text-center py-10">
                        <i class="fas fa-shopping-cart text-4xl text-gray-600 mb-4"></i>
                        <p class="text-gray-500">Keranjang belanja kosong</p>
                        <p class="text-gray-600 text-sm mt-2">Tambahkan produk ke keranjang untuk mulai belanja</p>
                    </div>
                @endif
            </div>
            
            <!-- Cart Footer -->
            <div class="border-t border-gray-700 p-6">
                @if(isset($cartItemsSidebar) && $cartItemsSidebar->count() > 0)
                    @php
                        $sidebarTotal = 0;
                        foreach ($cartItemsSidebar as $ci) {
                            if ($ci->product) {
                                $p = $ci->product->final_price ?? $ci->product->selling_price ?? 0;
                                $sidebarTotal += $p * $ci->quantity;
                            }
                        }
                    @endphp
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-400">Total</span>
                        <span class="text-2xl font-bold text-white" id="cart-total">Rp {{ number_format($sidebarTotal, 0, ',', '.') }}</span>
                    </div>
                @else
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-400">Total</span>
                        <span class="text-2xl font-bold text-white" id="cart-total">Rp 0</span>
                    </div>
                @endif
                <div class="space-y-3">
                    <a href="{{ route('cart.index') }}" class="w-full btn-primary text-white py-3.5 rounded-xl font-semibold transition-all flex items-center justify-center">
                        Lanjut ke Checkout
                    </a>
                    <button id="cart-continue-button" class="w-full bg-dark-700 hover:bg-dark-600 text-white py-3 rounded-xl font-medium transition-all">
                        Lanjut Belanja
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Overlay -->
    <div id="cart-overlay" 
         class="popup-overlay fixed inset-0 bg-black/60 backdrop-blur-sm z-[65]">
    </div>

    <!-- Profile Popup -->
    <div id="profile-popup" class="popup-overlay fixed inset-0 z-[9999]">
        <div class="popup-content max-w-sm">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-primary rounded-t-lg"></div>
            
            <button id="close-profile-popup" 
                    class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors close-button z-50">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div class="p-6">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="relative w-16 h-16 mx-auto mb-4">
                        <div class="absolute inset-0 bg-gradient-primary rounded-full blur-xl opacity-50"></div>
                        <div class="relative w-full h-full bg-gradient-primary rounded-full flex items-center justify-center shadow-glow-primary">
                            <i class="fas fa-user-gear text-xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white font-heading mb-2">Glorious Computer</h3>
                    <p class="text-gray-400 text-sm">Solusi Teknologi Terpercaya</p>
                </div>
                
                <!-- User Status -->
                <div class="bg-dark-700/30 rounded-xl p-4 mb-4 text-center border border-gray-700">
                    <p class="text-gray-400 text-sm mb-2">Status Pengguna</p>
                    <div class="inline-flex items-center bg-dark-800 rounded-full px-4 py-2 border border-gray-700 mb-2">
                        <i class="fas fa-user-clock text-primary mr-2"></i>
                        <span class="text-white font-medium text-sm" id="user-status">Tamu</span>
                    </div>
                    <div id="user-info" class="mt-2 hidden">
                        <p class="text-white text-sm font-medium" id="user-name"></p>
                        <p class="text-gray-400 text-xs mt-1" id="user-username"></p>
                    </div>
                </div>
                
                <!-- Guest Buttons -->
                <div class="space-y-3" id="guest-buttons">
                    <button id="profile-login-button"
                            class="w-full btn-primary text-white py-3 rounded-lg font-semibold text-sm transition-all flex items-center justify-center group">
                        <i class="fas fa-sign-in-alt mr-3 group-hover:animate-pulse"></i>
                        Login Pelanggan
                    </button>
                    
                    <button id="profile-register-button"
                            class="w-full bg-dark-700/50 hover:bg-dark-700 border border-gray-700 hover:border-primary text-white py-3 rounded-lg font-semibold text-sm transition-all flex items-center justify-center group">
                        <i class="fas fa-user-plus mr-3 group-hover:animate-bounce"></i>
                        Daftar Pelanggan
                    </button>
                    
                    <a href="https://wa.me/6282133803940" 
                       target="_blank"
                       class="w-full bg-gradient-to-r from-green-600/20 to-green-700/20 hover:from-green-600/30 hover:to-green-700/30 border border-green-700/30 hover:border-green-500 text-white py-3 rounded-lg font-semibold transition-all flex items-center justify-center group shadow-lg">
                        <i class="fab fa-whatsapp mr-3 group-hover:animate-heartbeat"></i>
                        Konsultasi via WhatsApp
                    </a>
                </div>

                <!-- User Buttons -->
                <div class="space-y-3 hidden" id="user-buttons">
                    @auth
                        @if(auth()->user()->role === 'Customer')
                            <a href="{{ route('customer.profile.edit') }}"
                               class="w-full bg-dark-700/50 hover:bg-dark-700 border border-gray-700 hover:border-primary text-white py-3 rounded-lg font-semibold transition-all flex items-center justify-center group">
                                <i class="fas fa-user-cog mr-3"></i>
                                Profile / Pengaturan
                            </a>
                            <a href="{{ route('wishlist.index') }}"
                               class="w-full bg-dark-700/50 hover:bg-dark-700 border border-gray-700 hover:border-primary text-white py-3 rounded-lg font-semibold transition-all flex items-center justify-center group">
                                <i class="fas fa-heart mr-3"></i>
                                Wishlist Saya
                            </a>
                            <a href="{{ route('cart.index') }}"
                               class="w-full bg-dark-700/50 hover:bg-dark-700 border border-gray-700 hover:border-primary text-white py-3 rounded-lg font-semibold transition-all flex items-center justify-center group">
                                <i class="fas fa-shopping-cart mr-3"></i>
                                Keranjang
                            </a>
                            <a href="{{ route('customer.orders') }}" id="user-orders-button"
                               class="w-full bg-dark-700/50 hover:bg-dark-700 border border-gray-700 hover:border-primary text-white py-3 rounded-lg font-semibold transition-all flex items-center justify-center group">
                                <i class="fas fa-shopping-bag mr-3"></i>
                                Pesanan Saya
                            </a>
                        @else
                            @php
                                $dashboardUrl = match(auth()->user()->role ?? '') {
                                    'Admin' => route('admin.dashboard'),
                                    'Manajer Gudang' => route('manajergudang.dashboard'),
                                    'Staff Gudang' => route('staff.dashboard'),
                                    default => url('/'),
                                };
                            @endphp
                            <a href="{{ $dashboardUrl }}" id="user-dashboard-button"
                               class="w-full btn-primary text-white py-3 rounded-lg font-semibold transition-all flex items-center justify-center group">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard
                            </a>
                        @endif
                    @endauth
                    <button id="user-logout-button"
                            class="w-full bg-gradient-to-r from-red-600/20 to-red-700/20 hover:from-red-600/30 hover:to-red-700/30 border border-red-700/30 hover:border-red-500 text-white py-3 rounded-lg font-semibold transition-all flex items-center justify-center group">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </div>
                
                <!-- Footer Note -->
                <div class="mt-6 pt-4 border-t border-gray-700/50">
                    <p class="text-gray-500 text-xs text-center">
                        <i class="fas fa-shield-alt mr-2 text-primary"></i>
                        Data Anda aman bersama kami
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Login Form Popup -->
    <div id="customer-login-popup" class="popup-overlay">
        <div class="popup-content">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-primary rounded-t-lg"></div>
            
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="relative w-16 h-16 mx-auto mb-4">
                        <div class="absolute inset-0 bg-gradient-primary rounded-full blur-xl opacity-50"></div>
                        <div class="relative w-full h-full bg-gradient-primary rounded-full flex items-center justify-center shadow-glow-primary">
                            <i class="fas fa-user-lock text-xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white font-heading mb-2">Masuk Akun</h3>
                    <p class="text-gray-400 text-sm">Selamat datang kembali di Glorious Computer</p>
                </div>
                
                <!-- Login Form -->
                <form id="customer-login-form" class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-gray-300 font-medium text-sm">Username/Email/Phone</label>
                        <input type="text" 
                               id="login-identifier"
                               name="login"
                               placeholder="Masukkan username, email, atau nomor telepon"
                               class="w-full form-input px-4 py-3 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm"
                               required>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-gray-300 font-medium text-sm">Password</label>
                            <button type="button" id="forgot-password-button" class="text-primary hover:text-primary-light text-xs transition-colors">
                                Lupa password?
                            </button>
                        </div>
                        <div class="relative">
                            <input type="password" 
                                   id="login-password"
                                   name="password"
                                   placeholder="••••••••"
                                   class="w-full form-input px-4 py-3 pr-10 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm"
                                   required>
                            <button type="button" 
                                    class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white"
                                    data-target="login-password">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" 
                               id="remember-me" 
                               name="remember"
                               class="form-checkbox"
                               value="1">
                        <label for="remember-me" class="text-gray-400 text-sm cursor-pointer select-none">
                            Ingat saya
                        </label>
                    </div>
                    
                    <button type="submit"
                            class="w-full btn-primary text-white py-3 rounded-lg font-semibold text-sm transition-all flex items-center justify-center mt-4">
                        <span class="login-button-text">Masuk ke Akun</span>
                        <div class="spinner w-4 h-4 ml-2 hidden"></div>
                    </button>
                </form>
                
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-4 bg-gradient-to-br from-dark-800 to-dark-800 text-gray-500">atau masuk dengan</span>
                    </div>
                </div>

                <!-- Social Login Buttons -->
                <div class="space-y-3 mb-4">
                    <button id="google-login-button"
                            class="w-full bg-white hover:bg-gray-100 text-gray-900 py-3 rounded-lg font-medium transition-all flex items-center justify-center group border border-gray-300 text-sm">
                        <svg class="w-4 h-4 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Masuk dengan Google
                    </button>
                </div>

                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-4 bg-gradient-to-br from-dark-800 to-dark-800 text-gray-500">belum punya akun?</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <button id="switch-to-register-button"
                            class="w-full bg-dark-700/50 hover:bg-dark-700 border border-gray-700 hover:border-primary text-white py-3 rounded-lg font-medium transition-all flex items-center justify-center group text-sm">
                        <i class="fas fa-user-plus mr-3 text-xs"></i>
                        Buat Akun Baru
                    </button>

                    <button id="back-from-login-button"
                            class="w-full bg-transparent hover:bg-dark-700/30 border border-gray-700 hover:border-gray-600 text-gray-400 hover:text-white py-3 rounded-lg font-medium transition-all flex items-center justify-center group text-sm">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Registration Form Popup -->
    <div id="customer-registration-popup" class="popup-overlay">
        <div class="popup-content large">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-primary rounded-t-lg"></div>

            <div class="registration-container">
                <div class="lg:w-2/5 bg-gradient-to-br from-primary/10 to-primary-dark/10 p-6 lg:p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="relative">
                            <div class="rounded-xl flex items-center justify-center overflow-visible transition-all duration-300 w-32 h-12">
                                <img src="{{ asset('images/Logo2.png') }}"
                                     alt="Glorious Computer Logo"
                                     class="w-full h-full object-contain brand-logo-glow">
                            </div>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white font-heading">Glorious Computer</h2>
                            <p class="gradient-text font-semibold text-xs">Solusi Teknologi Terpercaya</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white font-heading mb-3">
                            Bergabung dengan <span class="gradient-text">Komunitas Kami</span>
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-primary mr-3 text-sm"></i>
                                <span class="text-gray-300 text-sm">Layanan Service Komputer & Laptop</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-primary mr-3 text-sm"></i>
                                <span class="text-gray-300 text-sm">Upgrade Hardware Terjangkau</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-primary mr-3 text-sm"></i>
                                <span class="text-gray-300 text-sm">Konsultasi Teknologi Gratis</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-3/5 p-6 lg:p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white font-heading mb-2">Daftar Akun Baru</h3>
                        <p class="text-gray-400 text-sm">Bergabung dengan komunitas Glorious Computer</p>
                    </div>
                    
                    <!-- Registration Form -->
                    <form id="customer-registration-form" class="space-y-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-gray-300 font-medium text-sm">Nama Lengkap</label>
                                <input type="text" 
                                       id="register-name"
                                       name="name"
                                       placeholder="Masukkan nama lengkap"
                                       class="w-full form-input px-4 py-3 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm"
                                       required>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-gray-300 font-medium text-sm">Username</label>
                                <input type="text" 
                                       id="register-username"
                                       name="username"
                                       placeholder="Pilih username unik"
                                       class="w-full form-input px-4 py-3 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm"
                                       required>
                                <p class="text-gray-500 text-xs mt-1">Huruf, angka, dan underscore, tanpa spasi</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-gray-300 font-medium text-sm">Email (Opsional)</label>
                                <input type="email" 
                                       id="register-email"
                                       name="email"
                                       placeholder="nama@email.com"
                                       class="w-full form-input px-4 py-3 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-gray-300 font-medium text-sm">Nomor WhatsApp</label>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                                        +62
                                    </div>
                                    <input type="tel" 
                                           id="register-phone"
                                           name="phone"
                                           placeholder="812-xxxx-xxxx"
                                           class="w-full form-input pl-12 px-4 py-3 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm"
                                           required>
                                </div>
                                <p class="text-gray-500 text-xs mt-1">Untuk komunikasi via WhatsApp</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-gray-300 font-medium text-sm">Password</label>
                                <div class="relative">
                                    <input type="password" 
                                           id="register-password"
                                           name="password"
                                           placeholder="Buat password yang kuat"
                                           class="w-full form-input px-4 py-3 pr-10 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm"
                                           required>
                                    <button type="button" 
                                            class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white"
                                            data-target="register-password">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                </div>
                                <div class="password-strength">
                                    <div id="password-strength-bar" class="password-strength-bar"></div>
                                </div>
                                <p class="text-gray-500 text-xs">Minimal 6 karakter</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-gray-300 font-medium text-sm">Konfirmasi Password</label>
                                <div class="relative">
                                    <input type="password" 
                                           id="register-password-confirm"
                                           name="password_confirmation"
                                           placeholder="Ketik ulang password"
                                           class="w-full form-input px-4 py-3 pr-10 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm"
                                           required>
                                    <button type="button" 
                                            class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white"
                                            data-target="register-password-confirm">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 bg-dark-700/30 p-3 rounded-lg border border-gray-700 mt-4">
                            <input type="checkbox" 
                                   id="register-terms"
                                   name="terms"
                                   class="form-checkbox mt-1"
                                   required
                                   value="1">
                            <label for="register-terms" class="text-gray-400 text-xs cursor-pointer select-none">
                                Saya setuju dengan 
                                <a href="#" class="text-primary hover:text-primary-light transition-colors">Syarat & Ketentuan</a>
                                dan 
                                <a href="#" class="text-primary hover:text-primary-light transition-colors">Kebijakan Privasi</a>
                            </label>
                        </div>
                        
                        <button type="submit"
                                class="w-full btn-primary text-white py-3 rounded-lg font-semibold text-sm transition-all mt-4 flex items-center justify-center">
                            <span class="register-button-text">Daftar Sekarang</span>
                            <div class="spinner w-4 h-4 ml-2 hidden"></div>
                        </button>
                    </form>
                    
                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-4 bg-gradient-to-br from-dark-800 to-dark-800 text-gray-500">sudah punya akun?</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                        <button id="switch-to-login-button"
                                class="w-full bg-dark-700/50 hover:bg-dark-700 border border-gray-700 hover:border-primary text-white py-3 rounded-lg font-medium transition-all flex items-center justify-center group text-sm">
                            <i class="fas fa-sign-in-alt mr-3 text-xs"></i>
                            Masuk ke Akun
                        </button>
                        
                        <button id="back-from-registration-button"
                                class="w-full bg-transparent hover:bg-dark-700/30 border border-gray-700 hover:border-gray-600 text-gray-400 hover:text-white py-3 rounded-lg font-medium transition-all flex items-center justify-center group text-sm">
                            <i class="fas fa-arrow-left mr-3"></i>
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Popup -->
    <div id="forgot-password-popup" class="popup-overlay">
        <div class="popup-content">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-primary rounded-t-lg"></div>
            
            <button id="close-forgot-password-popup" 
                    class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors close-button z-50">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="relative w-16 h-16 mx-auto mb-4">
                        <div class="absolute inset-0 bg-gradient-primary rounded-full blur-xl opacity-50"></div>
                        <div class="relative w-full h-full bg-gradient-primary rounded-full flex items-center justify-center shadow-glow-primary">
                            <i class="fas fa-key text-xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white font-heading mb-2">Lupa Password</h3>
                    <p class="text-gray-400 text-sm">Masukkan email atau nomor telepon untuk reset password</p>
                </div>
                    
                <form id="forgot-password-form" class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-gray-300 font-medium text-sm">Email atau Nomor Telepon</label>
                        <input type="text" 
                               id="forgot-password-identifier"
                               placeholder="Masukkan email atau nomor telepon terdaftar"
                               class="w-full form-input px-4 py-3 rounded-lg text-white placeholder-gray-500 focus:outline-none transition-all text-sm"
                               required>
                    </div>
                    
                    <button type="submit"
                            class="w-full btn-primary text-white py-3 rounded-lg font-semibold text-sm transition-all flex items-center justify-center">
                        <span class="forgot-password-button-text">Kirim Reset Link</span>
                        <div class="spinner w-4 h-4 ml-2 hidden"></div>
                    </button>
                </form>
                
                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-4 bg-dark-800 text-gray-500">atau</span>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <button id="back-to-login-button"
                            class="w-full bg-dark-700/50 hover:bg-dark-700 border border-gray-700 hover:border-primary text-white py-3 rounded-lg font-medium transition-all flex items-center justify-center group text-sm">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Kembali ke Login
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message Popup -->
    <div id="success-popup" class="popup-overlay">
        <div class="popup-content">
            <div class="absolute top-0 left-0 right-0 h-1 bg-green-500 rounded-t-lg"></div>
            
            <div class="p-6 text-center">
                <div class="relative w-20 h-20 mx-auto mb-4">
                    <div class="absolute inset-0 bg-green-500 rounded-full blur-xl opacity-20"></div>
                    <div class="relative w-full h-full bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-2xl text-white"></i>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-white font-heading mb-3" id="success-title">Sukses!</h3>
                <p class="text-gray-300 mb-6 text-sm" id="success-message"></p>
                
                <button id="close-success-popup"
                        class="w-full btn-primary text-white py-3 rounded-lg font-semibold text-sm transition-all">
                    <i class="fas fa-check-circle mr-2"></i>
                    Oke, Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- Error Message Popup -->
    <div id="error-popup" class="popup-overlay">
        <div class="popup-content">
            <div class="absolute top-0 left-0 right-0 h-1 bg-red-500 rounded-t-lg"></div>
            
            <button id="close-error-popup" 
                    class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors close-button z-50">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div class="p-6 text-center">
                <div class="relative w-20 h-20 mx-auto mb-4">
                    <div class="absolute inset-0 bg-red-500 rounded-full blur-xl opacity-20"></div>
                    <div class="relative w-full h-full bg-red-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-white font-heading mb-3" id="error-title">Terjadi Kesalahan</h3>
                <p class="text-gray-300 mb-6 text-sm" id="error-message"></p>
                
                <div class="space-y-3">
                    <button id="close-error-button"
                            class="w-full bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 hover:border-red-400 text-white py-3 rounded-lg font-semibold text-sm transition-all">
                        <i class="fas fa-times-circle mr-2"></i>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay Loading -->
    <div id="loading-overlay" class="popup-overlay">
        <div class="popup-content bg-transparent border-none shadow-none">
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 border-4 border-primary/20 rounded-full"></div>
                    <div class="absolute top-0 left-0 w-20 h-20 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="spinner w-12 h-12"></div>
                    </div>
                </div>
                <p class="mt-6 text-light text-lg font-medium animate-pulse">Memproses...</p>
                <p class="text-gray-400 text-xs mt-2">Harap tunggu sebentar</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- FOOTER PREMIUM -->
    <footer class="bg-dark-900 border-t border-dark-500 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Column 1: About -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="relative">
                            <div class="rounded-xl flex items-center justify-center overflow-visible transition-all duration-300 w-32 h-12">
                                <img src="{{ asset('images/Logo2.png') }}"
                                     alt="Glorious Computer Logo"
                                     class="w-full h-full object-contain brand-logo-glow">
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-white">GLORIOUS</div>
                            <div class="text-primary text-xs">COMPUTER</div>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">
                        Solusi teknologi terpercaya sejak 2019. Menyediakan produk dan layanan IT berkualitas tinggi.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-dark-700 hover:bg-primary rounded-lg flex items-center justify-center transition-all">
                            <i class="fab fa-facebook-f text-gray-400 hover:text-white text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-dark-700 hover:bg-pink-600 rounded-lg flex items-center justify-center transition-all">
                            <i class="fab fa-instagram text-gray-400 hover:text-white text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-dark-700 hover:bg-blue-500 rounded-lg flex items-center justify-center transition-all">
                            <i class="fab fa-twitter text-gray-400 hover:text-white text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Column 2: Quick Links -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/" class="text-gray-400 hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="/products" class="text-gray-400 hover:text-primary transition-colors">Produk</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-primary transition-colors">Layanan</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-primary transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <!-- Column 3: Services -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Layanan</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Service Laptop</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Custom PC Build</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Upgrade Hardware</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors">Konsultasi IT</a></li>
                    </ul>
                </div>
                
                <!-- Column 4: Contact -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Kontak</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                            <span>No 4 (Depan BRI, Jl. Argandaru, Dusun 5, Bukateja, Kec. Bukateja, Kabupaten Purbalingga, Jawa Tengah 53382</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-primary"></i>
                            <a href="tel:+6282133803940" class="hover:text-primary transition-colors">+62 821-3380-3940</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-primary"></i>
                            <a href="mailto:glorious0326@gmail.com" class="hover:text-primary transition-colors">glorious0326@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-dark-500 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} Glorious Computer. All rights reserved.
                </p>
                <div class="flex gap-6 text-sm">
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

<script>
    @php
        $__initialAuth = [
            'authenticated' => auth()->check(),
            'user' => auth()->check() ? [
                'id' => auth()->id(),
                'name' => auth()->user()->name,
                'email' => auth()->user()->email ?? null,
                'username' => auth()->user()->username ?? null,
                'phone' => auth()->user()->phone ?? null,
                'role' => auth()->user()->role ?? 'Customer',
            ] : null,
        ];
    @endphp
    // Auth ditentukan oleh Blade; JS hanya baca, tidak override
    window.__INITIAL_AUTH__ = @json($__initialAuth);
    window.isAuth = {{ auth()->check() ? 'true' : 'false' }};
    const PopupManager = {
        currentUser: null,
        activePopup: null,
        cartOpen: false,
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        
        init() {
            this.initializeUserState();
            if (this.currentUser && typeof localStorage !== 'undefined') {
                localStorage.setItem('glorious_user', JSON.stringify(this.currentUser));
            }
            this.setupEventListeners();
            this.setupPopupCloseHandlers();
            this.updateUserState();
            this.initializeCart();
            this.hideAllPopups();
            this.setupPasswordStrengthChecker();
        },
        
        setupPasswordStrengthChecker() {
            const passwordInput = document.getElementById('register-password');
            if (passwordInput) {
                passwordInput.addEventListener('input', (e) => {
                    this.checkPasswordStrength(e.target.value);
                });
            }
        },
        
        initializeUserState() {
            // Utamakan auth dari Blade; fallback ke localStorage hanya untuk tampilan
            if (typeof window.__INITIAL_AUTH__ !== 'undefined' && window.__INITIAL_AUTH__.authenticated && window.__INITIAL_AUTH__.user) {
                this.currentUser = window.__INITIAL_AUTH__.user;
                return;
            }
            const savedUser = localStorage.getItem('glorious_user');
            if (savedUser) {
                try {
                    this.currentUser = JSON.parse(savedUser);
                } catch (e) {
                    this.currentUser = null;
                }
            }
        },
        
        setupEventListeners() {
            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('open');
                    menuToggle.classList.toggle('hamburger-active');
                });
            }
            
            // Mobile products toggle
            const mobileProductsToggle = document.getElementById('mobile-products-toggle');
            const mobileProductsMenu = document.getElementById('mobile-products-menu');
            const productsArrow = document.getElementById('products-arrow');
            
            if (mobileProductsToggle && mobileProductsMenu && productsArrow) {
                mobileProductsToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    mobileProductsMenu.classList.toggle('open');
                    productsArrow.classList.toggle('rotate-180');
                });
            }
            
            // Close mobile menu when clicking links
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    if (mobileMenu) mobileMenu.classList.remove('open');
                    if (menuToggle) menuToggle.classList.remove('hamburger-active');
                    
                    if (mobileProductsMenu && mobileProductsMenu.classList.contains('open')) {
                        mobileProductsMenu.classList.remove('open');
                        if (productsArrow) productsArrow.classList.remove('rotate-180');
                    }
                });
            });
            
            // Profile popup button
            const profilePopupButton = document.getElementById('profile-popup-button');
            if (profilePopupButton) {
                profilePopupButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.showPopup('profile-popup');
                });
            }
            
            // Cart buttons
            const cartButton = document.getElementById('cart-button');
            const cartButtonMobile = document.getElementById('cart-button-mobile');

            if (cartButton) {
                cartButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    if (!window.isAuth && !this.currentUser) {
                        this.showPopup('customer-login-popup');
                    } else {
                        this.toggleCart();
                    }
                });
            }
            if (cartButtonMobile) {
                cartButtonMobile.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    if (!window.isAuth && !this.currentUser) {
                        this.showPopup('customer-login-popup');
                    } else {
                        this.toggleCart();
                    }
                });
            }

            // Wishlist buttons
            const wishlistButton = document.getElementById('wishlist-button');
            const wishlistButtonMobile = document.getElementById('wishlist-button-mobile');

            if (wishlistButton) {
                wishlistButton.addEventListener('click', (e) => {
                    if (!window.isAuth && !this.currentUser) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.showPopup('customer-login-popup');
                    }
                });
            }

            if (wishlistButtonMobile) {
                wishlistButtonMobile.addEventListener('click', (e) => {
                    if (!window.isAuth && !this.currentUser) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.showPopup('customer-login-popup');
                        this.hideMobileMenu();
                    }
                });
            }

            // Cart close buttons
            const cartCloseButton = document.getElementById('cart-close-button');
            const cartContinueButton = document.getElementById('cart-continue-button');
            
            if (cartCloseButton) {
                cartCloseButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.toggleCart();
                });
            }
            if (cartContinueButton) {
                cartContinueButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.toggleCart();
                });
            }
            
            // Cart overlay
            const cartOverlay = document.getElementById('cart-overlay');
            if (cartOverlay) {
                cartOverlay.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.toggleCart();
                });
            }
            
            // Profile popup buttons
            const profileLoginButton = document.getElementById('profile-login-button');
            const profileRegisterButton = document.getElementById('profile-register-button');
            const mobileLoginButton = document.getElementById('mobile-login-button');
            const mobileRegisterButton = document.getElementById('mobile-register-button');
            
            if (profileLoginButton) {
                profileLoginButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.showPopup('customer-login-popup');
                });
            }
            if (profileRegisterButton) {
                profileRegisterButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.showPopup('customer-registration-popup');
                });
            }
            if (mobileLoginButton) {
                mobileLoginButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.showPopup('customer-login-popup');
                    this.hideMobileMenu();
                });
            }
            if (mobileRegisterButton) {
                mobileRegisterButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.showPopup('customer-registration-popup');
                    this.hideMobileMenu();
                });
            }
            
            // User buttons
            const userLogoutButton = document.getElementById('user-logout-button');
            if (userLogoutButton) {
                userLogoutButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.handleLogout();
                });
            }
            const mobileLogoutButton = document.getElementById('mobile-logout-button');
            if (mobileLogoutButton) {
                mobileLogoutButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.handleLogout();
                    this.hideMobileMenu();
                });
            }
            
            // Switch between popups
            const switchToRegisterButton = document.getElementById('switch-to-register-button');
            const switchToLoginButton = document.getElementById('switch-to-login-button');
            
            if (switchToRegisterButton) {
                switchToRegisterButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('customer-login-popup');
                    setTimeout(() => this.showPopup('customer-registration-popup'), 300);
                });
            }
            if (switchToLoginButton) {
                switchToLoginButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('customer-registration-popup');
                    setTimeout(() => this.showPopup('customer-login-popup'), 300);
                });
            }
            
            // Back buttons
            const backFromLoginButton = document.getElementById('back-from-login-button');
            const backFromRegistrationButton = document.getElementById('back-from-registration-button');
            
            if (backFromLoginButton) {
                backFromLoginButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('customer-login-popup');
                    setTimeout(() => this.showPopup('profile-popup'), 300);
                });
            }
            if (backFromRegistrationButton) {
                backFromRegistrationButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('customer-registration-popup');
                    setTimeout(() => this.showPopup('profile-popup'), 300);
                });
            }
            
            // Forgot password
            const forgotPasswordButton = document.getElementById('forgot-password-button');
            const backToLoginButton = document.getElementById('back-to-login-button');
            
            if (forgotPasswordButton) {
                forgotPasswordButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('customer-login-popup');
                    setTimeout(() => this.showPopup('forgot-password-popup'), 300);
                });
            }
            if (backToLoginButton) {
                backToLoginButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('forgot-password-popup');
                    setTimeout(() => this.showPopup('customer-login-popup'), 300);
                });
            }
            
            // Password toggle buttons
            document.querySelectorAll('.password-toggle').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const targetId = button.getAttribute('data-target');
                    this.togglePasswordVisibility(targetId);
                });
            });
            
            // Form submissions
            const loginForm = document.getElementById('customer-login-form');
            const registrationForm = document.getElementById('customer-registration-form');
            const forgotPasswordForm = document.getElementById('forgot-password-form');
            
            if (loginForm) {
                loginForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.handleLogin();
                });
            }
            
            if (registrationForm) {
                registrationForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.handleRegistration();
                });
            }
            
            if (forgotPasswordForm) {
                forgotPasswordForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.handleForgotPassword();
                });
            }
            
            // Close success/error popups
            const closeSuccessPopupButton = document.getElementById('close-success-popup');
            const closeErrorButton = document.getElementById('close-error-button');
            const closeErrorPopupButton = document.getElementById('close-error-popup');
            
            if (closeSuccessPopupButton) {
                closeSuccessPopupButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('success-popup');
                });
            }
            if (closeErrorButton) {
                closeErrorButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('error-popup');
                });
            }
            if (closeErrorPopupButton) {
                closeErrorPopupButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hidePopup('error-popup');
                });
            }
            
            // Google login button
            const googleLoginButton = document.getElementById('google-login-button');
            if (googleLoginButton) {
                googleLoginButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = '/auth/google';
                });
            }

            // Close popup dengan Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.activePopup) {
                    this.hidePopup(this.activePopup);
                }
            });
            
            // Close popup ketika klik di luar content popup
            document.addEventListener('click', (e) => {
                if (this.activePopup && e.target.classList.contains('popup-overlay')) {
                    this.hidePopup(this.activePopup);
                }
            });
        },
        
        setupPopupCloseHandlers() {
            // Setup close handlers for all popups
            const popups = [
                'profile-popup',
                'customer-login-popup',
                'customer-registration-popup',
                'forgot-password-popup',
                'success-popup',
                'error-popup'
            ];
            
            popups.forEach(popupId => {
                const closeButton = document.getElementById(`close-${popupId}`);
                if (closeButton) {
                    closeButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        this.hidePopup(popupId);
                    });
                }
                
                // Juga handle close-error-popup khusus
                if (popupId === 'error-popup') {
                    const closeErrorPopup = document.getElementById('close-error-popup');
                    if (closeErrorPopup) {
                        closeErrorPopup.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.hidePopup('error-popup');
                        });
                    }
                }
            });
        },
        
        showPopup(popupId) {
            // Hide current popup if any
            if (this.activePopup && this.activePopup !== popupId) {
                this.hidePopup(this.activePopup);
            }
            
            const popup = document.getElementById(popupId);
            if (popup) {
                // Reset form if needed
                if (popupId === 'customer-login-popup') {
                    this.resetLoginForm();
                } else if (popupId === 'customer-registration-popup') {
                    this.resetRegistrationForm();
                } else if (popupId === 'forgot-password-popup') {
                    this.resetForgotPasswordForm();
                }
                
                popup.classList.add('active');
                document.body.classList.add('popup-open');
                this.activePopup = popupId;
                
                // Focus pada input pertama jika ada
                setTimeout(() => {
                    const firstInput = popup.querySelector('input');
                    if (firstInput) {
                        firstInput.focus();
                    }
                }, 100);
            }
        },
        
        hidePopup(popupId) {
            const popup = document.getElementById(popupId);
            if (popup) {
                popup.classList.remove('active');
                if (!this.activePopup || this.activePopup === popupId) {
                    document.body.classList.remove('popup-open');
                    this.activePopup = null;
                }
            }
        },
        
        hideAllPopups() {
            const popups = document.querySelectorAll('.popup-overlay');
            popups.forEach(popup => {
                popup.classList.remove('active');
            });
            document.body.classList.remove('popup-open');
            this.activePopup = null;
        },
        
        hideMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuToggle = document.getElementById('menu-toggle');
            const mobileProductsMenu = document.getElementById('mobile-products-menu');
            const productsArrow = document.getElementById('products-arrow');
            
            if (mobileMenu) mobileMenu.classList.remove('open');
            if (menuToggle) menuToggle.classList.remove('hamburger-active');
            if (mobileProductsMenu) mobileProductsMenu.classList.remove('open');
            if (productsArrow) productsArrow.classList.remove('rotate-180');
        },
        
        toggleCart() {
            const cartSidebar = document.getElementById('cart-sidebar');
            const cartOverlay = document.getElementById('cart-overlay');
            
            if (cartSidebar && cartOverlay) {
                if (this.cartOpen) {
                    cartSidebar.classList.remove('open');
                    cartOverlay.classList.remove('active');
                } else {
                    cartSidebar.classList.add('open');
                    cartOverlay.classList.add('active');
                }
                this.cartOpen = !this.cartOpen;
            }
        },
        
        initializeCart() {
            // Initialize cart functionality
            this.loadCart();
        },
        
        async loadCart() {
            try {
                // Load cart from API
                // This would be implemented with actual API calls
            } catch (error) {
                console.error('Error loading cart:', error);
            }
        },
        
        togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                
                // Update eye icon
                const button = input.parentElement.querySelector('.password-toggle i');
                if (button) {
                    button.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
                }
            }
        },
        
        checkPasswordStrength(password) {
            const strengthBar = document.getElementById('password-strength-bar');
            if (!strengthBar) return;
            
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.style.backgroundColor = '';
            } else if (strength <= 2) {
                strengthBar.className += ' strength-weak';
            } else if (strength === 3) {
                strengthBar.className += ' strength-medium';
            } else if (strength === 4) {
                strengthBar.className += ' strength-strong';
            } else {
                strengthBar.className += ' strength-very-strong';
            }
        },
        
        resetLoginForm() {
            const form = document.getElementById('customer-login-form');
            if (form) form.reset();
            
            const spinner = form.querySelector('.spinner');
            const buttonText = form.querySelector('.login-button-text');
            if (spinner) spinner.classList.add('hidden');
            if (buttonText) buttonText.textContent = 'Masuk ke Akun';
        },
        
        resetRegistrationForm() {
            const form = document.getElementById('customer-registration-form');
            if (form) form.reset();
            
            const strengthBar = document.getElementById('password-strength-bar');
            if (strengthBar) {
                strengthBar.style.width = '0%';
                strengthBar.style.backgroundColor = '';
            }
            
            const spinner = form.querySelector('.spinner');
            const buttonText = form.querySelector('.register-button-text');
            if (spinner) spinner.classList.add('hidden');
            if (buttonText) buttonText.textContent = 'Daftar Sekarang';
        },
        
        resetForgotPasswordForm() {
            const form = document.getElementById('forgot-password-form');
            if (form) form.reset();
            
            const spinner = form.querySelector('.spinner');
            const buttonText = form.querySelector('.forgot-password-button-text');
            if (spinner) spinner.classList.add('hidden');
            if (buttonText) buttonText.textContent = 'Kirim Reset Link';
        },
        
        showLoading(show = true) {
            const loadingOverlay = document.getElementById('loading-overlay');
            if (loadingOverlay) {
                if (show) {
                    loadingOverlay.classList.add('active');
                } else {
                    loadingOverlay.classList.remove('active');
                }
            }
        },
        
        showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            if (!toastContainer) return;
            
            const styles = {
                success: 'bg-green-900/30 border border-green-700/50',
                error: 'bg-red-900/30 border border-red-700/50',
                info: 'bg-blue-900/30 border border-blue-700/50'
            };
            const icons = {
                success: 'fa-check-circle text-green-400',
                error: 'fa-exclamation-circle text-red-400',
                info: 'fa-info-circle text-blue-400'
            };
            const s = styles[type] || styles.info;
            const i = icons[type] || icons.info;
            const toast = document.createElement('div');
            toast.className = `toast ${s} rounded-xl p-4 text-white shadow-lg backdrop-blur-sm`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${i} mr-3"></i>
                    <span>${message}</span>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Remove toast after 5 seconds
            setTimeout(() => {
                toast.remove();
            }, 5000);
        },
        
        showSuccess(title, message) {
            const successTitle = document.getElementById('success-title');
            const successMessage = document.getElementById('success-message');
            
            if (successTitle) successTitle.textContent = title;
            if (successMessage) successMessage.textContent = message;
            
            this.showPopup('success-popup');
        },
        
        showError(title, message) {
            const errorTitle = document.getElementById('error-title');
            const errorMessage = document.getElementById('error-message');
            
            if (errorTitle) errorTitle.textContent = title;
            if (errorMessage) errorMessage.textContent = message;
            
            this.showPopup('error-popup');
        },
        
        async handleLogin() {
            const identifier = document.getElementById('login-identifier')?.value;
            const password = document.getElementById('login-password')?.value;
            const rememberMe = document.getElementById('remember-me')?.checked;

            if (!identifier || !password) {
                this.showError('Login Gagal', 'Harap isi semua field yang diperlukan');
                return;
            }

            const loginButton = document.querySelector('#customer-login-form button[type="submit"]');
            const spinner = loginButton?.querySelector('.spinner');
            const buttonText = loginButton?.querySelector('.login-button-text');

            if (spinner) spinner.classList.remove('hidden');
            if (buttonText) buttonText.textContent = 'Memproses...';

            try {
                const response = await fetch('{{ url("/login") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        login: identifier,
                        password: password,
                        remember: rememberMe
                    })
                });

                const data = await response.json();

                if (spinner) spinner.classList.add('hidden');
                if (buttonText) buttonText.textContent = 'Masuk ke Akun';

                if (response.ok && data.success) {
                    this.currentUser = data.user;
                    localStorage.setItem('glorious_user', JSON.stringify(data.user));
                    this.hidePopup('customer-login-popup');
                    this.showSuccess('Login Berhasil', data.message || 'Selamat datang kembali!');
                    // Reload/redirect agar Blade re-render dengan auth & session sinkron
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                    return;
                } else {
                    this.showError('Login Gagal', data.message || 'Email atau password salah');
                }
            } catch (error) {
                if (spinner) spinner.classList.add('hidden');
                if (buttonText) buttonText.textContent = 'Masuk ke Akun';
                
                this.showError('Error Sistem', 'Terjadi kesalahan saat menghubungi server');
                console.error('Login error:', error);
            }
        },
        
        async handleRegistration() {
            const name = document.getElementById('register-name')?.value;
            const username = document.getElementById('register-username')?.value;
            const email = document.getElementById('register-email')?.value;
            const phone = document.getElementById('register-phone')?.value;
            const password = document.getElementById('register-password')?.value;
            const passwordConfirm = document.getElementById('register-password-confirm')?.value;
            const terms = document.getElementById('register-terms')?.checked;

            if (!name || !username || !phone || !password || !passwordConfirm) {
                this.showError('Pendaftaran Gagal', 'Harap isi semua field yang diperlukan');
                return;
            }

            if (password !== passwordConfirm) {
                this.showError('Pendaftaran Gagal', 'Password dan konfirmasi password tidak cocok');
                return;
            }

            if (!terms) {
                this.showError('Pendaftaran Gagal', 'Anda harus menyetujui syarat dan ketentuan');
                return;
            }

            const usernameRegex = /^[a-zA-Z0-9_]+$/;
            if (!usernameRegex.test(username)) {
                this.showError('Pendaftaran Gagal', 'Username hanya boleh mengandung huruf, angka, dan underscore');
                return;
            }

            const registerButton = document.querySelector('#customer-registration-form button[type="submit"]');
            const spinner = registerButton?.querySelector('.spinner');
            const buttonText = registerButton?.querySelector('.register-button-text');

            if (spinner) spinner.classList.remove('hidden');
            if (buttonText) buttonText.textContent = 'Mendaftarkan...';

            try {
                const response = await fetch('{{ url("/register") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        name: name,
                        username: username,
                        email: email || null,
                        phone: phone,
                        password: password,
                        password_confirmation: passwordConfirm,
                        terms: true
                    })
                });

                const data = await response.json();

                if (spinner) spinner.classList.add('hidden');
                if (buttonText) buttonText.textContent = 'Daftar Sekarang';

                if (response.ok && data.success) {
                    this.currentUser = data.user;
                    localStorage.setItem('glorious_user', JSON.stringify(data.user));
                    this.hidePopup('customer-registration-popup');
                    this.showSuccess('Pendaftaran Berhasil', data.message || 'Selamat! Akun Anda telah berhasil dibuat.');
                    // Reload/redirect agar Blade re-render dengan auth & session sinkron
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                    return;
                } else {
                    const errorMessage = data.errors 
                        ? Object.values(data.errors).join(', ')
                        : data.message || 'Terjadi kesalahan saat mendaftar';
                    this.showError('Pendaftaran Gagal', errorMessage);
                }
            } catch (error) {
                if (spinner) spinner.classList.add('hidden');
                if (buttonText) buttonText.textContent = 'Daftar Sekarang';
                
                this.showError('Error Sistem', 'Terjadi kesalahan saat menghubungi server');
                console.error('Registration error:', error);
            }
        },
        
        async handleForgotPassword() {
            const identifier = document.getElementById('forgot-password-identifier')?.value;
            
            if (!identifier) {
                this.showError('Reset Password', 'Harap masukkan email atau nomor telepon');
                return;
            }
            
            const forgotButton = document.querySelector('#forgot-password-form button[type="submit"]');
            const spinner = forgotButton?.querySelector('.spinner');
            const buttonText = forgotButton?.querySelector('.forgot-password-button-text');
            
            if (spinner) spinner.classList.remove('hidden');
            if (buttonText) buttonText.textContent = 'Mengirim...';
            
            try {
                const response = await fetch('/api/auth/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        identifier: identifier
                    })
                });
                
                const data = await response.json();
                
                if (spinner) spinner.classList.add('hidden');
                if (buttonText) buttonText.textContent = 'Kirim Reset Link';
                
                if (response.ok) {
                    this.hidePopup('forgot-password-popup');
                    this.showSuccess('Reset Password', 'Link reset password telah dikirim. Silakan cek email atau WhatsApp Anda.');
                } else {
                    this.showError('Reset Password Gagal', data.message || 'Terjadi kesalahan saat mengirim reset link');
                }
            } catch (error) {
                if (spinner) spinner.classList.add('hidden');
                if (buttonText) buttonText.textContent = 'Kirim Reset Link';
                
                this.showError('Error Sistem', 'Terjadi kesalahan saat menghubungi server');
                console.error('Forgot password error:', error);
            }
        },
        
        async handleLogout() {
            try {
                const response = await fetch('{{ url("/logout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({})
                });
                this.currentUser = null;
                localStorage.removeItem('glorious_user');
                this.updateUserState();
                this.hidePopup('profile-popup');
                this.showSuccess('Logout Berhasil', 'Anda telah berhasil logout.');
                if (response.ok) {
                    const data = await response.json().catch(() => ({}));
                    if (data.redirect) window.location.href = data.redirect;
                    else window.location.reload();
                } else {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Logout error:', error);
                this.currentUser = null;
                localStorage.removeItem('glorious_user');
                this.updateUserState();
                this.hidePopup('profile-popup');
                window.location.reload();
            }
        },
        
        updateUserState() {
            const userStatus = document.getElementById('user-status');
            const userInfo = document.getElementById('user-info');
            const userName = document.getElementById('user-name');
            const userUsername = document.getElementById('user-username');
            const guestButtons = document.getElementById('guest-buttons');
            const userButtons = document.getElementById('user-buttons');
            // Sinkron dengan Blade: window.isAuth = true/false
            const isLoggedIn = this.currentUser || window.isAuth === true || window.isAuth === 'true';

            if (isLoggedIn && this.currentUser) {
                // User is logged in
                if (userStatus) userStatus.textContent = this.currentUser.name || 'Pengguna';
                if (userName) userName.textContent = this.currentUser.name || 'Pengguna';
                if (userUsername) userUsername.textContent = `@@${this.currentUser.username}`;
                
                if (userInfo) userInfo.classList.remove('hidden');
                if (guestButtons) guestButtons.classList.add('hidden');
                if (userButtons) userButtons.classList.remove('hidden');
            } else {
                // User is guest
                if (userStatus) userStatus.textContent = 'Tamu';
                
                if (userInfo) userInfo.classList.add('hidden');
                if (guestButtons) guestButtons.classList.remove('hidden');
                if (userButtons) userButtons.classList.add('hidden');
            }
        }
    };

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        PopupManager.init();
    });

    // Global function for password strength check
    window.checkPasswordStrength = function(password) {
        PopupManager.checkPasswordStrength(password);
    };

    // Global function for password visibility toggle
    window.togglePasswordVisibility = function(inputId) {
        PopupManager.togglePasswordVisibility(inputId);
    };

    // Product card: add to cart (customer only, call from product-card component)
    window.addToCartFromCard = function(productId, finalPrice, currentStock) {
        if (currentStock < 1) return;
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch('{{ route("cart.store") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token || '', 'Accept': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                if (typeof PopupManager !== 'undefined') PopupManager.showToast(data.message || 'Ditambah ke keranjang', 'success');
                window.location.reload();
            } else {
                if (typeof PopupManager !== 'undefined') PopupManager.showToast(data.message || 'Gagal menambah ke keranjang', 'error');
            }
        })
        .catch(() => { if (typeof PopupManager !== 'undefined') PopupManager.showToast('Gagal menambah ke keranjang', 'error'); });
    };

    // Product card: toggle wishlist (customer only)
    window.toggleWishlistFromCard = function(productId) {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch(`{{ url('wishlist/toggle') }}/${productId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token || '', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            credentials: 'same-origin'
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                if (typeof PopupManager !== 'undefined') PopupManager.showToast(data.is_in_wishlist ? 'Ditambah ke wishlist' : 'Dihapus dari wishlist', 'success');
                if (typeof data.wishlist_count !== 'undefined') {
                    const badges = document.querySelectorAll('.wishlist-count-badge');
                    badges.forEach(function(b) {
                        if (data.wishlist_count > 0) {
                            b.textContent = data.wishlist_count;
                            b.classList.remove('hidden');
                            b.style.display = '';
                        } else {
                            b.classList.add('hidden');
                            b.style.display = 'none';
                        }
                    });
                }
                var inWishlist = !!data.is_in_wishlist;
                var btn = document.querySelector('button[data-product-id="' + productId + '"]');
                if (btn) {
                    var icon = btn.querySelector('i.fa-heart');
                    if (icon) {
                        icon.classList.toggle('fas', inWishlist);
                        icon.classList.toggle('far', !inWishlist);
                    }
                    btn.classList.toggle('!bg-red-600', inWishlist);
                    btn.classList.toggle('bg-gray-700', !inWishlist);
                    btn.title = inWishlist ? 'Hapus dari wishlist' : 'Tambah ke wishlist';
                } else {
                    window.location.reload();
                }
            }
        })
        .catch(function() {});
    };
</script>

    @stack('scripts')

  @include('components.product-quick-view')  
</body>
</html>