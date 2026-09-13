<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Hatta Aksara Project - Gerakan otonom dan ekosistem kepemimpinan nasional untuk menyiapkan pemuda berkarakter, berintegritas tinggi, dan berjiwa gotong royong.')">
    <title>@yield('title', 'Hatta Aksara Project') | Ekosistem Kepemimpinan Muda</title>

    <!-- Google Fonts: Poppins & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            /* Palette Figma Hattaaksara */
            --violet-primary: #7300FF;
            --violet-light: #9D4EDD;
            --violet-dark: #4D00B3;
            --violet-gradient: linear-gradient(135deg, #7300FF 0%, #5900cc 50%, #2563EB 100%);
            --violet-subtle: rgba(115, 0, 255, 0.08);
            --violet-border: rgba(115, 0, 255, 0.16);
            --violet-glow: rgba(115, 0, 255, 0.3);

            --slate-900: #0C0022;
            --slate-850: #120732;
            --slate-800: #170A38;
            --slate-700: #26164F;
            --slate-100: #F3EFFB;

            --bg-page: #F6F2FB;
            --bg-surface: #FFFFFF;

            --text-main: #180D33;
            --text-muted: #4A4363;
            --text-light: #7E7599;
            --border-subtle: #E8E1F5;

            --font-display: 'Montserrat', sans-serif;
            --font-sans: 'Poppins', sans-serif;

            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --radius-pill: 9999px;

            /* Compatibility Fallbacks */
            --maroon-primary: var(--violet-primary);
            --maroon-deep: #170536;
            --maroon-dark: #0C0022;
            --gold-primary: var(--violet-primary);
            --gold-light: var(--violet-light);
            --gold-dark: #4D00B3;


            --shadow-subtle: 0 4px 20px -2px rgba(115, 0, 255, 0.05);
            --shadow-elevated: 0 20px 40px -8px rgba(115, 0, 255, 0.08), 0 4px 12px rgba(0, 0, 0, 0.03);
            --shadow-violet: 0 10px 25px -3px rgba(115, 0, 255, 0.35);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--bg-page);
            color: var(--text-main);
            line-height: 1.65;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        /* Top Bar */
        .topbar {
            background: var(--slate-900);
            color: #C8BFDB;
            font-size: 0.8rem;
            padding: 8px 0;
            border-bottom: 1px solid rgba(115, 0, 255, 0.2);
        }
        .topbar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar-badges {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .topbar-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #E2D9F3;
            font-weight: 500;
        }
        .topbar-badge i {
            color: var(--violet-light);
        }

        /* Main Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border-subtle);
            box-shadow: 0 4px 20px rgba(115, 0, 255, 0.03);
            transition: all 0.3s ease;
        }
        .navbar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .brand-logo-emblem {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: var(--violet-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.15rem;
            font-family: var(--font-display);
            font-weight: 800;
            box-shadow: var(--shadow-violet);
            letter-spacing: -0.02em;
        }
        .brand-text h1 {
            font-size: 1.18rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text-main);
            line-height: 1.2;
            font-family: var(--font-display);
        }
        .brand-text span {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--violet-primary);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            display: block;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
        }
        .nav-item {
            position: relative;
        }
        .nav-link {
            font-weight: 500;
            font-size: 0.92rem;
            color: var(--text-muted);
            padding: 8px 4px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            color: var(--violet-primary);
        }
        .nav-link.active {
            color: var(--violet-primary);
            font-weight: 600;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2.5px;
            background: var(--violet-gradient);
            border-radius: 4px;
        }

        /* Dropdown */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 10px;
            min-width: 240px;
            box-shadow: 0 15px 35px rgba(115, 0, 255, 0.08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 105;
        }
        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .dropdown-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--text-muted);
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .dropdown-link:hover {
            background-color: var(--slate-100);
            color: var(--violet-primary);
            padding-left: 20px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 9px 22px;
            border-radius: var(--radius-pill);
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            font-family: var(--font-sans);
        }
        .btn-outline {
            border: 1.5px solid var(--violet-primary);
            color: var(--violet-primary);
            background: transparent;
        }
        .btn-outline:hover {
            background: var(--violet-primary);
            color: white;
            box-shadow: var(--shadow-violet);
        }
        .btn-primary {
            background: var(--violet-primary);
            color: white;
            box-shadow: var(--shadow-violet);
        }
        .btn-primary:hover {
            background: var(--violet-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -2px rgba(115, 0, 255, 0.45);
            color: white;
        }
        .btn-gradient {
            background: var(--violet-gradient);
            color: white;
            box-shadow: var(--shadow-violet);
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px -2px rgba(115, 0, 255, 0.5);
            color: white;
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.35rem;
            color: var(--text-main);
            cursor: pointer;
        }

        /* Flash Alerts */
        .flash-container {
            max-width: 1280px;
            margin: 16px auto 0;
            padding: 0 24px;
            width: 100%;
        }
        .alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 12px;
            font-size: 0.92rem;
            animation: slideDown 0.3s ease;
        }
        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }
        .alert-info {
            background: var(--slate-100);
            color: var(--violet-primary);
            border-left: 4px solid var(--violet-primary);
        }
        .alert-close {
            background: none;
            border: none;
            font-size: 1rem;
            color: inherit;
            cursor: pointer;
            opacity: 0.6;
        }
        .alert-close:hover {
            opacity: 1;
        }

        /* Content Container */
        .main-content {
            flex: 1;
        }

        /* Footer */
        .footer {
            background: var(--slate-900);
            color: #C8BFDB;
            padding-top: 80px;
            margin-top: 80px;
            border-top: 1px solid rgba(115, 0, 255, 0.25);
            position: relative;
        }
        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px 60px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.3fr;
            gap: 40px;
        }
        .footer-brand h2 {
            font-family: var(--font-display);
            color: #ffffff;
            font-size: 1.4rem;
            margin-bottom: 14px;
            font-weight: 800;
            letter-spacing: -0.01em;
        }
        .footer-brand p {
            font-size: 0.92rem;
            color: #A99FC0;
            line-height: 1.75;
            margin-bottom: 24px;
        }
        .footer-social-btn {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-pill);
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.25s ease;
        }
        .footer-social-btn:hover {
            background: var(--violet-primary);
            border-color: var(--violet-primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-violet);
        }
        .footer-title {
            color: #FFFFFF;
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 22px;
            font-family: var(--font-display);
            letter-spacing: 0.01em;
            position: relative;
            padding-bottom: 10px;
        }
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 32px;
            height: 2.5px;
            background: var(--violet-gradient);
            border-radius: 4px;
        }
        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .footer-links a {
            color: #A99FC0;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .footer-links a:hover {
            color: #FFFFFF;
            padding-left: 6px;
        }
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 0.9rem;
            color: #A99FC0;
        }
        .footer-contact-item i {
            color: var(--violet-light);
            margin-top: 4px;
        }
        .footer-bottom {
            background: #070014;
            padding: 24px 0;
            border-top: 1px solid rgba(255,255,255,0.06);
            font-size: 0.84rem;
            color: #7E7599;
        }
        .footer-bottom-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Utilities */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .section-header {
            text-align: center;
            max-width: 750px;
            margin: 0 auto 50px;
        }
        .section-tag {
            display: inline-block;
            background: var(--violet-subtle);
            color: var(--violet-primary);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 6px 16px;
            border-radius: var(--radius-pill);
            margin-bottom: 14px;
            border: 1px solid var(--violet-border);
        }
        .section-title {
            font-family: var(--font-display);
            font-size: 2.3rem;
            color: var(--text-main);
            line-height: 1.25;
            margin-bottom: 14px;
            font-weight: 700;
        }
        .section-desc {
            color: var(--text-muted);
            font-size: 1.02rem;
            line-height: 1.7;
        }

        /* Mobile Off-Canvas Drawer */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(12, 0, 34, 0.7);
            backdrop-filter: blur(6px);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .mobile-drawer {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 320px;
            max-width: 85vw;
            background: #ffffff;
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            box-shadow: -10px 0 30px rgba(115, 0, 255, 0.15);
            overflow-y: auto;
        }
        .mobile-drawer.active {
            transform: translateX(0);
        }
        .drawer-header {
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-subtle);
            background: var(--bg-page);
        }
        .drawer-close {
            background: none;
            border: none;
            font-size: 1.6rem;
            color: var(--text-muted);
            cursor: pointer;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .drawer-close:hover {
            background: var(--slate-100);
            color: var(--violet-primary);
        }
        .drawer-nav {
            list-style: none;
            padding: 16px 20px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .drawer-nav-item {
            border-bottom: 1px solid rgba(115, 0, 255, 0.05);
        }
        .drawer-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 6px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-main);
            cursor: pointer;
        }
        .drawer-nav-link:hover, .drawer-nav-link.active {
            color: var(--violet-primary);
        }
        .drawer-submenu {
            display: none;
            list-style: none;
            padding: 4px 0 10px 16px;
            border-left: 2px solid var(--violet-light);
            margin-left: 8px;
            margin-bottom: 8px;
        }
        .drawer-submenu.open {
            display: block;
        }
        .drawer-submenu a {
            display: block;
            padding: 8px 10px;
            font-size: 0.88rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .drawer-submenu a:hover {
            color: var(--violet-primary);
        }
        .drawer-footer {
            padding: 20px;
            margin-top: auto;
            border-top: 1px solid var(--border-subtle);
            background: var(--bg-page);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .footer-container {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 992px) {
            .nav-menu, .nav-actions {
                display: none !important;
            }
            .mobile-toggle {
                display: block !important;
            }
            .topbar-container {
                flex-direction: column;
                gap: 6px;
                text-align: center;
                padding: 8px 16px;
            }
            .topbar-badges {
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }
        }
        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            .footer-bottom-container {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            .section-title {
                font-size: 1.85rem;
            }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Universal Subpage Hero & Header Styling */
        .page-header,
        .artikel-header,
        .article-header,
        .about-hero,
        .islt-hero,
        .media-hero,
        .form-hero,
        .reg-hero {
            background: radial-gradient(circle at top right, #240C4C 0%, #0C0022 100%) !important;
            color: #ffffff !important;
            padding: 75px 0 60px !important;
            border-bottom: 1px solid rgba(115, 0, 255, 0.25) !important;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        .page-header::before,
        .artikel-header::before,
        .about-hero::before,
        .islt-hero::before,
        .media-hero::before {
            content: '';
            position: absolute;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(115,0,255,0.2) 0%, transparent 70%);
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
        }
        .page-header h1,
        .artikel-header h1,
        .article-header h1,
        .about-hero h1,
        .islt-hero h1,
        .media-hero h1,
        .form-hero h1,
        .reg-hero h1 {
            color: #ffffff !important;
            font-family: var(--font-display) !important;
            font-size: clamp(2rem, 4.5vw, 2.8rem) !important;
            font-weight: 800 !important;
            line-height: 1.25 !important;
            margin: 14px 0 !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6) !important;
        }
        .page-header p,
        .artikel-header p,
        .article-header p,
        .about-hero p,
        .islt-hero p,
        .media-hero p,
        .form-hero p,
        .reg-hero p {
            color: #D5CEE8 !important;
            font-size: 1.05rem !important;
            line-height: 1.7 !important;
            max-width: 720px !important;
            margin: 0 auto !important;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.6) !important;
        }
        .page-header .section-tag,
        .artikel-header .section-tag,
        .about-hero .section-tag,
        .islt-hero .section-tag,
        .media-hero .section-tag,
        .form-hero .section-tag,
        .reg-hero .section-tag {
            background: rgba(115, 0, 255, 0.4) !important;
            color: #ffffff !important;
            border: 1px solid var(--violet-light) !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
            padding: 5px 16px !important;
            border-radius: var(--radius-pill) !important;
            display: inline-block !important;
            box-shadow: 0 2px 10px rgba(115, 0, 255, 0.25) !important;
        }

        /* Modern Filter Tabs Styling */
        .filter-tabs {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border-subtle);
            padding-bottom: 15px;
        }
        .filter-tab {
            padding: 9px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.88rem;
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            color: var(--text-main);
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .filter-tab:hover {
            border-color: var(--violet-primary);
            color: var(--violet-primary);
            background: #FAF7FC;
        }
        .filter-tab.active {
            background: var(--violet-primary) !important;
            color: #ffffff !important;
            border-color: var(--violet-primary) !important;
            box-shadow: 0 4px 14px rgba(115, 0, 255, 0.3) !important;
        }
        .subcat-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 35px;
        }
        .subcat-pill {
            font-size: 0.82rem;
            padding: 6px 16px;
            border-radius: 20px;
            background: #FAF7FC;
            color: var(--text-muted);
            font-weight: 500;
            border: 1px solid var(--border-subtle);
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .subcat-pill:hover, .subcat-pill.active {
            background: rgba(115, 0, 255, 0.1) !important;
            color: var(--violet-primary) !important;
            border-color: var(--violet-primary) !important;
            font-weight: 700 !important;
        }

    </style>
    @stack('styles')
</head>
<body>

    <!-- Top Informational Bar -->
    <header class="topbar">
        <div class="topbar-container">
            <div class="topbar-badges">
                <span class="topbar-badge"><i class="fa-solid fa-compass"></i> Hatta Aksara Project • Gerakan Kepemimpinan Muda</span>
                <span style="opacity: 0.3">|</span>
                <span>Membina Masyarakat Kooperatif & Pemimpin Berkarakter</span>
            </div>
            <div class="topbar-badges">
                <span class="topbar-badge"><i class="fa-solid fa-graduation-cap"></i> ISLT 2026 Dibuka</span>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" style="color: var(--violet-light); font-weight:700;"><i class="fa-solid fa-shield-halved"></i> Panel Admin</a>
                    @elseif(auth()->user()->isHattaMuda())
                        <a href="{{ route('alumni.dashboard') }}" style="color: var(--violet-light); font-weight:700;"><i class="fa-solid fa-user-graduate"></i> Ruang Hatta Muda</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="brand">
                <div class="brand-logo-emblem">HA</div>
                <div class="brand-text">
                    <h1>Hatta Aksara</h1>
                    <span>Ekosistem Kepemimpinan Muda</span>
                </div>
            </a>

            <button class="mobile-toggle" onclick="openMobileDrawer()" aria-label="Buka Menu Navigasi">
                <i class="fa-solid fa-bars"></i>
            </button>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('berita.index') }}" class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}">
                        Berita <i class="fa-solid fa-angle-down" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('berita.index', ['type' => 'news']) }}" class="dropdown-link"><i class="fa-regular fa-newspaper" style="color:var(--violet-primary);"></i> News Resmi</a>
                        <a href="{{ route('berita.index', ['type' => 'aksi_hatta_muda']) }}" class="dropdown-link"><i class="fa-solid fa-hands-holding-circle" style="color:var(--violet-primary);"></i> Aksi Hatta Muda</a>
                        <a href="{{ route('berita.index', ['type' => 'kegiatan']) }}" class="dropdown-link"><i class="fa-solid fa-calendar-check" style="color:var(--violet-primary);"></i> Kegiatan & Forum</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('program.index') }}" class="nav-link {{ request()->routeIs('program.*') ? 'active' : '' }}">
                        Program <i class="fa-solid fa-angle-down" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('program.islt') }}" class="dropdown-link"><i class="fa-solid fa-award" style="color:var(--violet-primary);"></i> Pelatihan ISLT</a>
                        <a href="{{ route('program.islt.daftar') }}" class="dropdown-link" style="color: var(--violet-primary); font-weight:700;"><i class="fa-solid fa-pen-to-square"></i> Daftar Peserta ISLT</a>
                        <a href="{{ route('program.media-edukasi') }}" class="dropdown-link"><i class="fa-solid fa-book-open-reader" style="color:var(--violet-primary);"></i> Media Edukasi</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('artikel.index') }}" class="nav-link {{ request()->routeIs('artikel.*') ? 'active' : '' }}">Artikel Gagasan</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ejurnal.index') }}" class="nav-link {{ request()->routeIs('ejurnal.*') ? 'active' : '' }}">E-Jurnal</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang</a>
                </li>
            </ul>

            <div class="nav-actions">
                <a href="{{ route('program.islt.daftar') }}" class="btn btn-primary">
                    <i class="fa-solid fa-file-pen"></i> Daftar ISLT
                </a>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk
                    </a>
                @else
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-gradient">
                            <i class="fa-solid fa-shield-halved"></i> Admin
                        </a>
                    @else
                        <a href="{{ route('alumni.dashboard') }}" class="btn btn-gradient">
                            <i class="fa-solid fa-user-astronaut"></i> Hatta Muda
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline" style="padding: 8px 14px; color:#ef4444; border-color:#fca5a5;" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Mobile Drawer Overlay -->
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileDrawer()"></div>

    <!-- Mobile Drawer Off-Canvas -->
    <aside class="mobile-drawer" id="mobileDrawer">
        <div class="drawer-header">
            <div class="brand">
                <div class="brand-logo-emblem" style="width:36px; height:36px; font-size:0.95rem;">HA</div>
                <div class="brand-text">
                    <h1 style="font-size:1.05rem;">Hatta Aksara</h1>
                </div>
            </div>
            <button class="drawer-close" onclick="closeMobileDrawer()">&times;</button>
        </div>

        <ul class="drawer-nav">
            <li class="drawer-nav-item">
                <a href="{{ route('home') }}" class="drawer-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            </li>
            <li class="drawer-nav-item">
                <div class="drawer-nav-link" onclick="toggleDrawerSubmenu('submenu-berita')">
                    <span>Berita & Informasi</span>
                    <i class="fa-solid fa-angle-down" id="chevron-submenu-berita" style="font-size:0.75rem; transition:0.2s;"></i>
                </div>
                <ul class="drawer-submenu" id="submenu-berita">
                    <li><a href="{{ route('berita.index', ['type' => 'news']) }}">News Resmi</a></li>
                    <li><a href="{{ route('berita.index', ['type' => 'aksi_hatta_muda']) }}">Aksi Hatta Muda</a></li>
                    <li><a href="{{ route('berita.index', ['type' => 'kegiatan']) }}">Kegiatan & Forum</a></li>
                    <li><a href="{{ route('berita.index') }}">Semua Berita</a></li>
                </ul>
            </li>
            <li class="drawer-nav-item">
                <div class="drawer-nav-link" onclick="toggleDrawerSubmenu('submenu-program')">
                    <span>Program Unggulan</span>
                    <i class="fa-solid fa-angle-down" id="chevron-submenu-program" style="font-size:0.75rem; transition:0.2s;"></i>
                </div>
                <ul class="drawer-submenu" id="submenu-program">
                    <li><a href="{{ route('program.islt') }}">Pelatihan ISLT 2026</a></li>
                    <li><a href="{{ route('program.islt.daftar') }}" style="color:var(--violet-primary); font-weight:700;">Daftar Peserta ISLT</a></li>
                    <li><a href="{{ route('program.media-edukasi') }}">Media Edukasi & Literasi</a></li>
                    <li><a href="{{ route('program.index') }}">Ikhtisar Program</a></li>
                </ul>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('artikel.index') }}" class="drawer-nav-link {{ request()->routeIs('artikel.*') ? 'active' : '' }}">Artikel Gagasan</a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('ejurnal.index') }}" class="drawer-nav-link {{ request()->routeIs('ejurnal.*') ? 'active' : '' }}">E-Jurnal</a>
            </li>
            <li class="drawer-nav-item">
                <a href="{{ route('about') }}" class="drawer-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Hatta Aksara</a>
            </li>
        </ul>

        <div class="drawer-footer">
            <a href="{{ route('program.islt.daftar') }}" class="btn btn-primary" style="width: 100%;">
                <i class="fa-solid fa-file-pen"></i> Pendaftaran Peserta ISLT
            </a>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Akun
                </a>
                <a href="{{ route('register.hatta-muda') }}" style="font-size: 0.82rem; text-align: center; color: var(--violet-primary); font-weight: 600; margin-top: 4px;">
                    Registrasi Alumni ISLT &rarr;
                </a>
            @else
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-gradient" style="width: 100%;">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard Admin Redaksi
                    </a>
                @else
                    <a href="{{ route('alumni.dashboard') }}" class="btn btn-gradient" style="width: 100%;">
                        <i class="fa-solid fa-user-astronaut"></i> Ruang Hatta Muda
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 4px;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="width: 100%; color: #dc2626; border-color: #fca5a5;">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>
                </form>
            @endguest
        </div>
    </aside>

    <!-- Flash Notifications -->
    <div class="flash-container">
        @if(session('success'))
            <div class="alert alert-success">
                <span><i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span><i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i> {{ session('error') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                <span><i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i> {{ session('warning') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                <span><i class="fa-solid fa-circle-info" style="margin-right: 8px;"></i> {{ session('info') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
    </div>

    <!-- Main Content Injection -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <h2>HATTA AKSARA PROJECT</h2>
                <p>
                    Gerakan kepemimpinan pemuda mandiri dan ekosistem kaderisasi nasional untuk mencetak generasi berkarakter integritas tinggi, berakar pada falsafah kebangsaan (<em>weltanschauung</em>), serta penggerak ekonomi kerakyatan dan kebudayaan.
                </p>
                <div style="display: flex; gap: 12px;">
                    <a href="#" class="footer-social-btn"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@hattaaksaraproject" target="_blank" rel="noopener noreferrer" class="footer-social-btn" title="Kanal YouTube Resmi Hatta Aksara Project"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="footer-social-btn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            <div>
                <h3 class="footer-title">Kanal Berita</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('berita.index', ['type' => 'news']) }}">News Resmi Organisasi</a></li>
                    <li><a href="{{ route('berita.index', ['type' => 'aksi_hatta_muda']) }}">Aksi Nyata Hatta Muda</a></li>
                    <li><a href="{{ route('berita.index', ['type' => 'kegiatan']) }}">Kegiatan & Napak Tilas</a></li>
                    <li><a href="{{ route('artikel.index') }}">Artikel & Gagasan Pemuda</a></li>
                    <li><a href="{{ route('ejurnal.index') }}">E-Jurnal Perpustakaan Digital</a></li>
                </ul>
            </div>

            <div>
                <h3 class="footer-title">Program & Ekosistem</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('program.islt') }}">Indonesian Students Leadership Training</a></li>
                    <li><a href="{{ route('program.islt.daftar') }}" style="color:var(--violet-light); font-weight:600;">Daftar Peserta ISLT</a></li>
                    <li><a href="{{ route('program.media-edukasi') }}">Media Edukasi & Literasi</a></li>
                    <li><a href="{{ route('register.hatta-muda') }}">Registrasi Alumni Hatta Muda</a></li>
                    <li><a href="{{ route('about') }}">Profil & Filosofi Gerakan</a></li>
                </ul>
            </div>

            <div>
                <h3 class="footer-title">Sekretariat</h3>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Sekretariat Hatta Aksara Project<br>Jakarta & Bukittinggi, Indonesia</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span>sekretariat@hattaaksara.id</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <span>+62 812-8888-HATTA</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-container">
                <p>&copy; {{ date('Y') }} Hatta Aksara Project. Seluruh Hak Cipta Dilindungi Undang-Undang. Platform Otonom Kepemimpinan Pemuda Indonesia.</p>
                <div style="display:flex; gap: 20px;">
                    <a href="{{ route('about') }}" style="color:#A99FC0;">Filosofi Weltanschauung</a>
                    <a href="{{ route('ejurnal.index') }}" style="color:#A99FC0;">Arsip Kurikulum</a>
                    <a href="{{ route('login') }}" style="color:#A99FC0;">Portal Redaksi</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function openMobileDrawer() {
            document.getElementById('mobileDrawer').classList.add('active');
            document.getElementById('mobileOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileDrawer() {
            document.getElementById('mobileDrawer').classList.remove('active');
            document.getElementById('mobileOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function toggleDrawerSubmenu(id) {
            const submenu = document.getElementById(id);
            const chevron = document.getElementById('chevron-' + id);
            if (submenu) {
                submenu.classList.toggle('open');
                if (chevron) {
                    chevron.style.transform = submenu.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>