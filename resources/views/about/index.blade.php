<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About - {{ $about->title ?? 'UNITED SENIORS VELLANAD' }}</title>
    @include('pwa')
    <!-- Modern typography from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            --primary-hover: #15b300ff;
            --text-color: #e7f711ff;
            --border-color: rgba(255, 255, 255, 0.15);
            --card-bg: rgba(14, 14, 14, 0.88);
            --transition-speed: 0.3s;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #0f0f0f;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
            color: #ffffff;
        }

        /* Stadium background layer */
        .bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('stadium.jpg') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.4;
            filter: blur(3px);
            z-index: -1;
        }

        /* Header Navigation */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 3rem;
            position: relative;
            z-index: 10;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logo {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            gap: 2px;
        }

        .logo-img {
            width: 50px;
            height: auto;
            max-height: 48px;
            object-fit: contain;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.35));
            transition: transform var(--transition-speed) ease, filter var(--transition-speed) ease;
        }

        .logo:hover .logo-img {
            transform: translateY(-2px) scale(1.08);
            filter: drop-shadow(0 4px 10px rgba(230, 0, 0, 0.45));
        }

        .logo-text {
            font-size: 1.15rem;
            font-weight: 900;
            color: var(--primary-color);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            line-height: 1;
            transition: color var(--transition-speed) ease;
        }

        .logo:hover .logo-text {
            color: #ff3333;
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: color var(--transition-speed);
            position: relative;
            padding: 0.25rem 0;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: width var(--transition-speed);
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link.active::after,
        .nav-link:hover::after {
            width: 100%;
        }

        /* Nav Dropdown for Tournaments */
        .nav-dropdown-wrap {
            position: relative;
            display: inline-block;
        }

        .nav-dropdown-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            text-decoration: none;
            color: var(--text-color);
            font-weight: 600;
            font-size: 1.15rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            padding: 0.25rem 0;
            position: relative;
            transition: color var(--transition-speed);
        }

        .nav-dropdown-toggle::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: width var(--transition-speed);
        }

        .nav-dropdown-wrap:hover .nav-dropdown-toggle {
            color: var(--primary-color);
        }

        .nav-dropdown-wrap:hover .nav-dropdown-toggle::after {
            width: 100%;
        }

        .nav-dropdown-wrap:hover .nav-dropdown-menu,
        .nav-dropdown-wrap:focus-within .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: rgba(18, 18, 18, 0.98);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 0.6rem;
            min-width: 230px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
            z-index: 120;
        }

        .nav-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.65rem 0.9rem;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 600;
            border-radius: 8px;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .nav-dropdown-item:hover {
            background: rgba(230, 0, 0, 0.18);
            color: var(--text-color);
        }

        /* Auth Menu */
        .auth-menu {
            display: flex;
            align-items: center;
        }

        .signin-btn {
            text-decoration: none;
            color: #ffffff;
            background-color: var(--primary-color);
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-family: inherit;
        }

        .signin-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .user-role-badge {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
        }

        .admin-badge {
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff5555;
        }

        .player-badge {
            background: rgba(231, 247, 17, 0.15);
            border: 1px solid var(--text-color);
            color: var(--text-color);
        }

        /* Sign In Dropdown */
        .signin-dropdown-wrap {
            position: relative;
            display: inline-block;
        }

        .signin-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: rgba(18, 18, 18, 0.96);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 0.6rem;
            min-width: 250px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
            z-index: 100;
        }

        .signin-dropdown-wrap:hover .signin-dropdown-menu,
        .signin-dropdown-wrap:focus-within .signin-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.75rem 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.2s, transform 0.2s;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
        }

        .dropdown-item .item-icon {
            font-size: 1.3rem;
            line-height: 1;
        }

        .dropdown-item .item-text {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .dropdown-item .item-title {
            color: #ffffff;
            font-weight: 800;
            font-size: 0.88rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .dropdown-item .item-desc {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.72rem;
            margin-top: 0.15rem;
        }

        .dropdown-item:hover .item-title {
            color: var(--text-color);
        }

        .dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 0.35rem 0;
        }

        /* Main Container */
        .main-content {
            flex: 1;
            padding: 3rem 1.5rem 5rem;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
            z-index: 5;
        }

        /* Admin Quick Bar */
        .admin-action-banner {
            background: rgba(230, 0, 0, 0.15);
            border: 1px solid var(--primary-color);
            border-radius: 14px;
            padding: 0.9rem 1.4rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            box-shadow: 0 8px 20px rgba(230, 0, 0, 0.25);
        }

        .admin-banner-text {
            font-size: 0.9rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-banner-btn {
            background: var(--primary-color);
            color: #ffffff;
            text-decoration: none;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.82rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .admin-banner-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* Hero Banner Card */
        .about-hero-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3.5rem 2.5rem 2.5rem;
            text-align: center;
            margin-bottom: 2.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.65), 0 0 35px rgba(230, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .about-hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--text-color), var(--primary-color));
        }

        .club-emblem {
            width: clamp(100px, 14vw, 150px);
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.5));
            margin-bottom: 1.25rem;
            transition: transform 0.4s ease;
        }

        .club-emblem:hover {
            transform: scale(1.06) rotate(-2deg);
        }

        .about-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin: 0 0 0.5rem 0;
            line-height: 1.15;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.7);
        }

        .about-tagline {
            font-size: clamp(1rem, 2.5vw, 1.35rem);
            color: var(--text-color);
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin: 0 0 1.8rem 0;
            opacity: 0.95;
        }

        /* Highlights / Badges Bar */
        .highlights-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .highlight-chip {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: 0.03em;
        }

        .highlight-chip .chip-label {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .highlight-chip .chip-val {
            color: var(--text-color);
            font-weight: 800;
        }

        /* Description Content Card */
        .content-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2.8rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.55);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            margin-bottom: 1.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0.85rem;
        }

        .section-icon {
            font-size: 1.8rem;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
            margin: 0;
        }

        .section-title span {
            color: var(--primary-color);
        }

        .about-text-body {
            color: rgba(255, 255, 255, 0.92);
            font-size: 1.08rem;
            line-height: 1.85;
            letter-spacing: 0.01em;
            white-space: pre-line;
        }

        .about-text-body p {
            margin-top: 0;
            margin-bottom: 1.5rem;
        }

        .about-text-body p:last-child {
            margin-bottom: 0;
        }

        /* Mission & Vision Grid */
        .vision-mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .feature-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2.2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            transition: transform var(--transition-speed) ease, border-color var(--transition-speed) ease;
            display: flex;
            flex-direction: column;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary-color);
        }

        .feature-icon-wrap {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: rgba(230, 0, 0, 0.18);
            border: 1px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 1.25rem;
        }

        .feature-title {
            font-size: 1.35rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin: 0 0 0.85rem 0;
            color: #ffffff;
        }

        .feature-desc {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            line-height: 1.65;
            margin: 0;
            flex: 1;
        }

        /* Contact & Venue Card */
        .contact-venue-card {
            background: linear-gradient(135deg, rgba(20, 20, 20, 0.95), rgba(30, 10, 10, 0.95));
            border: 1px solid rgba(230, 0, 0, 0.35);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 3rem;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.8rem;
            margin-top: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .contact-icon {
            font-size: 1.4rem;
            background: rgba(255, 255, 255, 0.08);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .contact-meta {
            display: flex;
            flex-direction: column;
        }

        .contact-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 0.2rem;
            font-weight: 700;
        }

        .contact-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            word-break: break-word;
        }

        .contact-value a {
            color: var(--text-color);
            text-decoration: none;
            transition: color var(--transition-speed);
        }

        .contact-value a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        /* Bottom navigation CTA */
        .bottom-actions {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 2rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all var(--transition-speed) ease;
        }

        .btn-primary-action {
            background: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(230, 0, 0, 0.4);
        }

        .btn-primary-action:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(21, 179, 0, 0.5);
        }

        .btn-secondary-action {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .btn-secondary-action:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #ffffff;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }

            .nav-menu {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .about-hero-card {
                padding: 2.5rem 1.5rem;
            }

            .content-card {
                padding: 1.8rem;
            }

            .contact-venue-card {
                padding: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <!-- Background Layer -->
    <div class="bg-layer"></div>

    <!-- Header Navigation -->
    <header class="header">
        <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad - Return to Home">
            <img src="{{ asset('usv-logo.png') }}" alt="USV Logo" class="logo-img">
            <span class="logo-text">USV</span>
        </a>
        <nav class="nav-menu">
            <a href="{{ route('members') }}" class="nav-link">MEMBERS</a>
            <a href="{{ route('about') }}" class="nav-link active">ABOUT</a>
            
            <!-- Tournaments Dropdown Navigation -->
            <div class="nav-dropdown-wrap">
                <a href="{{ route('tournaments.index') }}" class="nav-dropdown-toggle">
                    TOURNAMENTS
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5z"/>
                    </svg>
                </a>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('tournaments.show', 1) }}" class="nav-dropdown-item">
                        <span>🏆</span> Premier League
                    </a>
                    <a href="{{ route('tournaments.show', 2) }}" class="nav-dropdown-item">
                        <span>🏆</span> Champions League
                    </a>
                    <a href="{{ route('tournaments.show', 3) }}" class="nav-dropdown-item">
                        <span>🏆</span> Discovery League
                    </a>
                    <div style="border-top: 1px solid rgba(255,255,255,0.08); margin: 0.35rem 0;"></div>
                    <a href="{{ route('tournaments.index') }}" class="nav-dropdown-item">
                        <span>📋</span> All Tournaments
                    </a>
                </div>
            </div>

            <a href="{{ route('gallery') }}" class="nav-link">GALLERY</a>
            <a href="{{ route('register.create') }}" class="nav-link">REGISTER</a>
            <a href="{{ route('contact') }}" class="nav-link">CONTACT</a>
            @if(Session::has('authenticated_user'))
                <a href="{{ route('dashboard') }}" class="nav-link">DASHBOARD</a>
            @endif
        </nav>
        <div class="auth-menu">
            @if(Session::has('authenticated_user'))
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    @if(Session::get('is_admin'))
                        <span class="user-role-badge admin-badge">🛡️ ADMIN</span>
                    @else
                        <span class="user-role-badge player-badge">🏏 PLAYER</span>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="signin-btn" style="border: none; cursor: pointer; font-family: inherit;">LOG OUT</button>
                    </form>
                </div>
            @else
                <div class="signin-dropdown-wrap">
                    <button type="button" class="signin-btn">
                        SIGN IN
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="margin-left: 4px;">
                            <path d="M7 10l5 5 5-5z"/>
                        </svg>
                    </button>
                    <div class="signin-dropdown-menu">
                        <a href="{{ route('login.admin') }}" class="dropdown-item">
                            <span class="item-icon">🛡️</span>
                            <div class="item-text">
                                <span class="item-title">Admin Log In</span>
                                <span class="item-desc">Control panel & permissions</span>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('login') }}" class="dropdown-item">
                            <span class="item-icon">🏏</span>
                            <div class="item-text">
                                <span class="item-title">Player Log In</span>
                                <span class="item-desc">Sign in with Email OTP</span>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="main-content">
        @if($isAdmin)
            <div class="admin-action-banner">
                <div class="admin-banner-text">
                    <span>🛡️</span>
                    <span><strong>Administrator Mode:</strong> You have permission to edit this club description and details.</span>
                </div>
                <a href="{{ route('about.edit') }}" class="admin-banner-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    <span>Edit Club Details</span>
                </a>
            </div>
        @endif

        <!-- Club Hero Showcase Card -->
        <div class="about-hero-card">
            <img src="{{ asset('usv-logo.png') }}" alt="{{ $about->title }}" class="club-emblem">
            <h1 class="about-title">{{ $about->title }}</h1>
            @if($about->tagline)
                <div class="about-tagline">{{ $about->tagline }}</div>
            @endif

            <div class="highlights-row">
                @if($about->established_year)
                    <div class="highlight-chip">
                        <span class="chip-label">Established:</span>
                        <span class="chip-val">{{ $about->established_year }}</span>
                    </div>
                @endif
                <div class="highlight-chip">
                    <span class="chip-label">Sport:</span>
                    <span class="chip-val">Cricket</span>
                </div>
                @if($about->home_ground)
                    <div class="highlight-chip">
                        <span class="chip-label">Base:</span>
                        <span class="chip-val">{{ $about->home_ground }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Club Description Section -->
        <div class="content-card">
            <div class="section-header">
                <span class="section-icon">📖</span>
                <h2 class="section-title">About <span>Our Club</span></h2>
            </div>
            <div class="about-text-body">{!! nl2br(e($about->description)) !!}</div>
        </div>

        <!-- Mission & Vision Cards (if set) -->
        @if($about->mission || $about->vision)
            <div class="vision-mission-grid">
                @if($about->mission)
                    <div class="feature-card">
                        <div class="feature-icon-wrap">🎯</div>
                        <h3 class="feature-title">Our Mission</h3>
                        <p class="feature-desc">{{ $about->mission }}</p>
                    </div>
                @endif
                @if($about->vision)
                    <div class="feature-card">
                        <div class="feature-icon-wrap">👁️</div>
                        <h3 class="feature-title">Our Vision</h3>
                        <p class="feature-desc">{{ $about->vision }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Contact & Headquarters Information -->
        <div class="contact-venue-card">
            <div class="section-header" style="border-color: rgba(255,255,255,0.12);">
                <span class="section-icon">📍</span>
                <h2 class="section-title">Club <span>Headquarters & Contact</span></h2>
            </div>
            <div class="contact-grid">
                @if($about->home_ground)
                    <div class="contact-item">
                        <div class="contact-icon">🏟️</div>
                        <div class="contact-meta">
                            <span class="contact-label">Home Ground</span>
                            <span class="contact-value">{{ $about->home_ground }}</span>
                        </div>
                    </div>
                @endif
                @if($about->contact_email)
                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div class="contact-meta">
                            <span class="contact-label">Official Email</span>
                            <span class="contact-value">
                                <a href="mailto:{{ $about->contact_email }}">{{ $about->contact_email }}</a>
                            </span>
                        </div>
                    </div>
                @endif
                @if($about->contact_phone)
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div class="contact-meta">
                            <span class="contact-label">Contact Phone</span>
                            <span class="contact-value">
                                <a href="tel:{{ $about->contact_phone }}">{{ $about->contact_phone }}</a>
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="bottom-actions">
            <a href="{{ url('/') }}" class="btn-action btn-secondary-action">
                <span>&larr; Back to Home</span>
            </a>
            <a href="{{ route('players.index') }}" class="btn-action btn-primary-action">
                <span>🏏 Meet Our Squad</span>
            </a>
            <a href="{{ route('tournaments.index') }}" class="btn-action btn-secondary-action">
                <span>🏆 View Tournaments</span>
            </a>
            @if($isAdmin)
                <a href="{{ route('about.edit') }}" class="btn-action btn-primary-action" style="background: #e60000;">
                    <span>⚙️ Edit About Content</span>
                </a>
            @endif
        </div>
    </main>
</body>

</html>
