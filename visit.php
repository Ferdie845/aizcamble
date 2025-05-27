<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/FavLogo.jpg" alt="brand-logo">
    <title>Visit Us - AIZCAmble | Find Us in Angat, Bulacan</title>
    
    <!-- Meta Tags -->
    <meta name="description" content="Visit AIZCAmble in Sta Cruz, Angat Bulacan. Find our location, contact information, hours, and connect with us on social media.">
    <meta name="keywords" content="AIZCAmble location, Angat Bulacan, contact us, visit us, ice scramble cart, mini donuts">
    <meta name="author" content="AIZCAmble Team">
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-pink: #EC4899;
            --primary-pink-dark: #DB2777;
            --primary-pink-light: #F472B6;
            --secondary-pink: #F9A8D4;
            --accent-purple: #8B5CF6;
            --accent-purple-light: #A78BFA;
            --accent-gold: #F59E0B;
            --accent-gold-light: #FCD34D;
            --background-gradient-start: #FDF2F8;
            --background-gradient-end: #FCE7F3;
            --background-deep-start: #831843;
            --background-deep-end: #BE185D;
            --surface-white: rgba(255, 255, 255, 0.95);
            --surface-glass: rgba(255, 255, 255, 0.1);
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --text-light: #9CA3AF;
            --success-color: #10B981;
            --error-color: #EF4444;
            --shadow-pink: rgba(236, 72, 153, 0.3);
            --shadow-strong: rgba(0, 0, 0, 0.25);
            --border-light: rgba(236, 72, 153, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--background-deep-start) 0%, var(--background-deep-end) 50%, var(--primary-pink-dark) 100%);
            color: var(--text-primary);
            overflow-x: hidden;
            position: relative;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--primary-pink) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: backgroundMove 20s linear infinite;
            opacity: 0.1;
            z-index: -2;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, var(--primary-pink) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, var(--accent-purple) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, var(--secondary-pink) 0%, transparent 50%);
            opacity: 0.15;
            animation: gradientShift 15s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes backgroundMove {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(50px, 50px) rotate(360deg); }
        }

        @keyframes gradientShift {
            0%, 100% { opacity: 0.15; }
            50% { opacity: 0.25; }
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: var(--surface-white);
            backdrop-filter: blur(25px);
            border-bottom: 1px solid var(--border-light);
            box-shadow: 0 8px 32px var(--shadow-pink);
            z-index: 1000;
            padding: 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 12px 48px var(--shadow-pink);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 32px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
            color: var(--text-primary);
        }

        .nav-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid var(--primary-pink);
            object-fit: cover;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-logo::before {
            content: '';
            position: absolute;
            top: -6px;
            left: -6px;
            right: -6px;
            bottom: -6px;
            background: linear-gradient(45deg, var(--primary-pink), var(--accent-purple), var(--secondary-pink));
            border-radius: 50%;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .nav-brand:hover .nav-logo::before {
            opacity: 1;
        }

        .nav-brand:hover .nav-logo {
            transform: scale(1.1) rotate(5deg);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        .brand-tagline {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(236, 72, 153, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            color: var(--primary-pink);
            background: rgba(236, 72, 153, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--primary-pink);
            background: rgba(236, 72, 153, 0.1);
        }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--primary-pink);
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            background: rgba(236, 72, 153, 0.1);
        }

        /* Hero Section */
        .hero-section {
            padding: 120px 32px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface-white);
            backdrop-filter: blur(20px);
            padding: 12px 20px;
            border-radius: 50px;
            border: 1px solid var(--border-light);
            box-shadow: 0 8px 32px var(--shadow-pink);
            margin-bottom: 32px;
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-pink);
            animation: slideInDown 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hero-badge i {
            animation: sparkle 2s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.2) rotate(180deg); }
        }

        .hero-title {
            font-size: 64px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 24px;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple), var(--secondary-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideInUp 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hero-subtitle {
            font-size: 24px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 48px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            animation: slideInUp 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.2s both;
        }

        @keyframes slideInDown {
            0% { opacity: 0; transform: translateY(-50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInUp {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Contact Section */
        .contact-section {
            padding: 80px 32px;
            background: var(--surface-white);
            backdrop-filter: blur(20px);
            position: relative;
        }

        .contact-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: start;
        }

        .contact-info {
            animation: slideInLeft 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .contact-title {
            font-size: 48px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 32px;
            line-height: 1.2;
        }

        .contact-cards {
            display: grid;
            gap: 24px;
            margin-bottom: 40px;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 8px 32px var(--shadow-pink);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-pink), var(--accent-purple));
            background-size: 200% 100%;
            animation: gradientFlow 3s ease-in-out infinite;
        }

        @keyframes gradientFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px var(--shadow-pink);
        }

        .contact-card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .contact-card-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .contact-details {
            color: var(--text-secondary);
            font-size: 16px;
            line-height: 1.6;
        }

        .contact-link {
            color: var(--primary-pink);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .contact-link:hover {
            color: var(--primary-pink-dark);
            text-decoration: underline;
        }

        /* Social Media Section */
        .social-section {
            margin-top: 40px;
        }

        .social-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 24px;
        }

        .social-links {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .social-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 24px;
            background: white;
            border-radius: 16px;
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 600;
            box-shadow: 0 4px 16px var(--shadow-pink);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .social-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(236, 72, 153, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .social-link:hover::before {
            left: 100%;
        }

        .social-link:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px var(--shadow-pink);
        }

        .social-icon {
            font-size: 24px;
        }

        .social-link.instagram .social-icon {
            background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .social-link.facebook .social-icon {
            color: #1877F2;
        }

        .social-link.email .social-icon {
            color: var(--primary-pink);
        }

        .social-link.phone .social-icon {
            color: var(--success-color);
        }

        /* Map Section */
        .map-section {
            animation: slideInRight 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .map-container {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 16px 48px var(--shadow-pink);
            border: 1px solid var(--border-light);
            position: relative;
        }

        .map-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-pink), var(--accent-purple), var(--secondary-pink));
            background-size: 200% 100%;
            animation: gradientFlow 3s ease-in-out infinite;
            z-index: 2;
        }

        .map-header {
            padding: 24px 32px;
            background: rgba(236, 72, 153, 0.05);
            border-bottom: 1px solid var(--border-light);
        }

        .map-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .map-address {
            color: var(--text-secondary);
            font-size: 16px;
        }

        .map-placeholder {
            height: 400px;
            background: linear-gradient(135deg, var(--background-gradient-start), var(--background-gradient-end));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 16px;
            color: var(--text-secondary);
        }

        .map-placeholder i {
            font-size: 48px;
            color: var(--primary-pink);
        }

        .map-placeholder-text {
            font-size: 18px;
            font-weight: 600;
        }

        .directions-btn {
            margin-top: 24px;
            padding: 16px 32px;
            background: linear-gradient(135deg, var(--primary-pink), var(--primary-pink-dark));
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .directions-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow-pink);
        }

        /* Hours Section */
        .hours-section {
            padding: 80px 32px;
            background: linear-gradient(135deg, var(--background-gradient-start) 0%, var(--background-gradient-end) 100%);
        }

        .hours-container {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }

        .hours-title {
            font-size: 48px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 48px;
        }

        .hours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
        }

        .hours-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 8px 32px var(--shadow-pink);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .hours-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-pink), var(--accent-purple));
            background-size: 200% 100%;
            animation: gradientFlow 3s ease-in-out infinite;
        }

        .hours-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px var(--shadow-pink);
        }

        .hours-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin: 0 auto 20px;
        }

        .hours-card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .hours-list {
            list-style: none;
            padding: 0;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(236, 72, 153, 0.1);
            font-size: 14px;
        }

        .hours-item:last-child {
            border-bottom: none;
        }

        .hours-day {
            font-weight: 600;
            color: var(--text-primary);
        }

        .hours-time {
            color: var(--text-secondary);
        }

        .hours-time.open {
            color: var(--success-color);
            font-weight: 600;
        }

        .hours-time.closed {
            color: var(--error-color);
            font-weight: 600;
        }

        /* Floating particles */
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-pink), var(--secondary-pink));
            animation: float 20s infinite linear;
            pointer-events: none;
            opacity: 0.6;
        }

        .floating-element.pink {
            background: linear-gradient(45deg, var(--secondary-pink), var(--primary-pink-light));
            animation: floatPink 25s infinite linear;
            opacity: 0.4;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
                transform: translateY(90vh) rotate(36deg) scale(1);
            }
            90% {
                opacity: 0.6;
                transform: translateY(-10vh) rotate(324deg) scale(1);
            }
            100% {
                transform: translateY(-100vh) rotate(360deg) scale(0);
                opacity: 0;
            }
        }

        @keyframes floatPink {
            0% {
                transform: translateY(100vh) rotate(0deg) scale(0);
                opacity: 0;
            }
            15% {
                opacity: 0.4;
                transform: translateY(85vh) rotate(54deg) scale(1);
            }
            85% {
                opacity: 0.4;
                transform: translateY(-15vh) rotate(306deg) scale(1);
            }
            100% {
                transform: translateY(-100vh) rotate(360deg) scale(0);
                opacity: 0;
            }
        }

        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .contact-container {
                gap: 60px;
            }
            
            .hero-title {
                font-size: 56px;
            }
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
            
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--surface-white);
                backdrop-filter: blur(25px);
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 8px 32px var(--shadow-pink);
                border-top: 1px solid var(--border-light);
            }
            
            .nav-links.open {
                display: flex;
            }
            
            .hero-title {
                font-size: 40px;
            }
            
            .contact-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .social-links {
                justify-content: center;
            }
            
            .hours-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                padding: 12px 20px;
            }
            
            .hero-section {
                padding: 100px 20px 60px;
            }
            
            .hero-title {
                font-size: 32px;
            }
            
            .contact-section,
            .hours-section {
                padding: 60px 20px;
            }
            
            .social-links {
                flex-direction: column;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(236, 72, 153, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-pink), var(--primary-pink-dark));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-pink-dark), var(--primary-pink));
        }
    </style>
</head>
<body>
    <!-- Floating Elements -->
    <div class="floating-element" style="left: 5%; width: 6px; height: 6px; animation-delay: 0s;"></div>
    <div class="floating-element pink" style="left: 15%; width: 4px; height: 4px; animation-delay: 3s;"></div>
    <div class="floating-element" style="left: 25%; width: 8px; height: 8px; animation-delay: 6s;"></div>
    <div class="floating-element pink" style="left: 35%; width: 5px; height: 5px; animation-delay: 9s;"></div>
    <div class="floating-element" style="left: 45%; width: 7px; height: 7px; animation-delay: 12s;"></div>
    <div class="floating-element pink" style="left: 55%; width: 4px; height: 4px; animation-delay: 15s;"></div>
    <div class="floating-element" style="left: 65%; width: 6px; height: 6px; animation-delay: 18s;"></div>
    <div class="floating-element pink" style="left: 75%; width: 5px; height: 5px; animation-delay: 21s;"></div>
    <div class="floating-element" style="left: 85%; width: 7px; height: 7px; animation-delay: 24s;"></div>
    <div class="floating-element pink" style="left: 95%; width: 4px; height: 4px; animation-delay: 27s;"></div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-brand">
                <img src="/assets/FavLogo.jpg" alt="AIZCAmble Logo" class="nav-logo">
                <div class="brand-text">
                    <div class="brand-name">AIZCAmble</div>
                    <div class="brand-tagline">Visit Us</div>
                </div>
            </a>
            
            <div class="nav-links" id="navLinks">
                <a href="index.php" class="nav-link">Home</a>
                <a href="Home.php" class="nav-link">Shop</a>
                <a href="About.php" class="nav-link">About Us</a>
                <a href="Visit.php" class="nav-link active">Visit Us</a>
            </div>
            
            <button class="mobile-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-badge">
                <i class="fas fa-map-marker-alt"></i>
                Find Us in Angat, Bulacan
            </div>
            
            <h1 class="hero-title">Visit Us</h1>
            <p class="hero-subtitle">
                Come experience AIZCAmble in person - we're waiting to serve you!
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-info">
                <h2 class="contact-title">Get in Touch</h2>
                
                <div class="contact-cards">
                    <div class="contact-card">
                        <div class="contact-card-header">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h3 class="contact-card-title">Location</h3>
                        </div>
                        <div class="contact-details">
                            <p><strong>Sta Cruz, Angat Bulacan</strong></p>
                            <p>Near Home City Angat</p>
                            <p>Look for our signature pink cart!</p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-card-header">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h3 class="contact-card-title">Phone</h3>
                        </div>
                        <div class="contact-details">
                            <p><a href="tel:+639673812437" class="contact-link">Globe - 0967 381 2437</a></p>
                            <p>Call us for orders, inquiries, or just to say hi!</p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-card-header">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h3 class="contact-card-title">Email</h3>
                        </div>
                        <div class="contact-details">
                            <p><a href="mailto:aizscramble20@gmail.com" class="contact-link">aizscramble20@gmail.com</a></p>
                            <p>Send us your feedback, suggestions, or business inquiries</p>
                        </div>
                    </div>
                </div>
                
                <div class="social-section">
                    <h3 class="social-title">Follow Us on Social Media</h3>
                    <div class="social-links">
                        <a href="https://www.instagram.com/aizscramblee?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="social-link instagram">
                            <i class="fab fa-instagram social-icon"></i>
                            <span>@aizscramblee</span>
                        </a>
                        
                        <a href="https://www.facebook.com/share/1D7oKe2C9q/" target="_blank" class="social-link facebook">
                            <i class="fab fa-facebook social-icon"></i>
                            <span>Aiz Scramble</span>
                        </a>
                        
                        <a href="mailto:aizscramble20@gmail.com" class="social-link email">
                            <i class="fas fa-envelope social-icon"></i>
                            <span>Email Us</span>
                        </a>
                        
                        <a href="tel:+639673812437" class="social-link phone">
                            <i class="fas fa-phone social-icon"></i>
                            <span>Call Now</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="map-section">
                <div class="map-container">
                    <div class="map-header">
                        <h3 class="map-title">Find Our Cart</h3>
                        <p class="map-address">Sta Cruz, Angat Bulacan - Near Home City Angat</p>
                    </div>
                    <div class="map-placeholder">
                        <i class="fas fa-map-marked-alt"></i>
                        <p class="map-placeholder-text">Interactive Map Coming Soon</p>
                        <p style="font-size: 14px; color: var(--text-light);">
                            We're located in Sta Cruz, Angat Bulacan, near Home City Angat.<br>
                            Look for our distinctive pink cart!
                        </p>
                        <a href="https://maps.google.com/?q=Sta+Cruz+Angat+Bulacan" target="_blank" class="directions-btn">
                            <i class="fas fa-directions"></i>
                            Get Directions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hours Section -->
    <section class="hours-section">
        <div class="hours-container">
            <h2 class="hours-title">When to Find Us</h2>
            
            <div class="hours-grid">
                <div class="hours-card">
                    <div class="hours-card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="hours-card-title">Operating Hours</h3>
                    <ul class="hours-list">
                        <li class="hours-item">
                            <span class="hours-day">Monday</span>
                            <span class="hours-time open">3:00 PM - 8:00 PM</span>
                        </li>
                        <li class="hours-item">
                            <span class="hours-day">Tuesday</span>
                            <span class="hours-time open">3:00 PM - 8:00 PM</span>
                        </li>
                        <li class="hours-item">
                            <span class="hours-day">Wednesday</span>
                            <span class="hours-time open">3:00 PM - 8:00 PM</span>
                        </li>
                        <li class="hours-item">
                            <span class="hours-day">Thursday</span>
                            <span class="hours-time open">3:00 PM - 8:00 PM</span>
                        </li>
                        <li class="hours-item">
                            <span class="hours-day">Friday</span>
                            <span class="hours-time open">3:00 PM - 9:00 PM</span>
                        </li>
                        <li class="hours-item">
                            <span class="hours-day">Saturday</span>
                            <span class="hours-time open">2:00 PM - 9:00 PM</span>
                        </li>
                        <li class="hours-item">
                            <span class="hours-day">Sunday</span>
                            <span class="hours-time open">2:00 PM - 8:00 PM</span>
                        </li>
                    </ul>
                </div>
                
                <div class="hours-card">
                    <div class="hours-card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3 class="hours-card-title">Important Notes</h3>
                    <div style="text-align: left; color: var(--text-secondary); line-height: 1.6;">
                        <p style="margin-bottom: 12px;">
                            <i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i>
                            Fresh products made daily
                        </p>
                        <p style="margin-bottom: 12px;">
                            <i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i>
                            Weather permitting operations
                        </p>
                        <p style="margin-bottom: 12px;">
                            <i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i>
                            Follow us on social media for updates
                        </p>
                        <p style="margin-bottom: 12px;">
                            <i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i>
                            Special hours during holidays
                        </p>
                        <p>
                            <i class="fas fa-phone" style="color: var(--primary-pink); margin-right: 8px;"></i>
                            Call ahead for large orders
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navLinks = document.getElementById('navLinks');

        mobileToggle.addEventListener('click', function() {
            navLinks.classList.toggle('open');
            const icon = this.querySelector('i');
            if (navLinks.classList.contains('open')) {
                icon.className = 'fas fa-times';
            } else {
                icon.className = 'fas fa-bars';
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!navLinks.contains(event.target) && !mobileToggle.contains(event.target)) {
                navLinks.classList.remove('open');
                mobileToggle.querySelector('i').className = 'fas fa-bars';
            }
        });

        // Parallax effect for floating elements
        document.addEventListener('mousemove', function(e) {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            // Move floating elements based on mouse position
            document.querySelectorAll('.floating-element').forEach((element, index) => {
                const speed = (index % 3 + 1) * 0.5;
                const x = (mouseX - 0.5) * speed * 20;
                const y = (mouseY - 0.5) * speed * 20;
                element.style.transform = `translate(${x}px, ${y}px)`;
            });
        });

        // Contact card hover effects
        document.querySelectorAll('.contact-card, .hours-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(-8px) scale(1)';
            });
        });

        // Social link interactions
        document.querySelectorAll('.social-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(236, 72, 153, 0.3);
                    transform: scale(0);
                    animation: rippleEffect 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes rippleEffect {
                0% {
                    transform: scale(0);
                    opacity: 1;
                }
                100% {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe contact cards and hours cards
        document.querySelectorAll('.contact-card, .hours-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = `all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) ${index * 0.1}s`;
            observer.observe(card);
        });

        // Enhanced brand interaction
        document.querySelector('.nav-brand').addEventListener('mouseenter', function() {
            this.querySelector('.brand-name').style.transform = 'scale(1.05)';
            this.querySelector('.brand-tagline').style.color = 'var(--primary-pink)';
        });

        document.querySelector('.nav-brand').addEventListener('mouseleave', function() {
            this.querySelector('.brand-name').style.transform = 'scale(1)';
            this.querySelector('.brand-tagline').style.color = 'var(--text-light)';
        });

        // Smooth scrolling for anchor links
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

        // Loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });

        // Dynamic background color shifts
        setInterval(() => {
            const hue = Math.random() * 30 + 320; // Pink to purple range
            document.documentElement.style.setProperty('--dynamic-bg', `hsl(${hue}, 70%, 15%)`);
        }, 5000);

        // Phone number click tracking
        document.querySelector('a[href^="tel:"]').addEventListener('click', function() {
            console.log('Phone number clicked - tracking customer engagement');
        });

        // Email click tracking
        document.querySelectorAll('a[href^="mailto:"]').forEach(link => {
            link.addEventListener('click', function() {
                console.log('Email link clicked - tracking customer engagement');
            });
        });
    </script>
</body>
</html>
