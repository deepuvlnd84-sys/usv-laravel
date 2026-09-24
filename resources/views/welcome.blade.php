<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <!-- Modern typography from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            /* User's chosen blue color */
            --text-color: #e7f711ff;
            --transition-speed: 0.3s;
        }

        body {
            background-color: #ffffff;
            /* Only white background base */
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* Blurred and low opacity background image */
        .bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('stadium.jpg') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.5;
            /* Added missing semicolon */
            filter: blur(1px);
            /* Blurred */
            z-index: -1;
        }

        /* Navigation Bar */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 3rem;
            position: relative;
            z-index: 10;
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
            transition: transform var(--transition-speed, 0.3s) ease, filter var(--transition-speed, 0.3s) ease;
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
            transition: color var(--transition-speed, 0.3s) ease;
        }

        .logo:hover .logo-text {
            color: #ff3333;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            flex-wrap: wrap;
        }

        .nav-link,
        .nav-dropdown-toggle {
            text-decoration: none;
            background: linear-gradient(135deg, #0b4d26 0%, #063c1e 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 0.65rem 1.35rem;
            border-radius: 50px;
            border: 1.5px solid rgba(34, 197, 94, 0.45);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4), inset 0 1px 1px rgba(255, 255, 255, 0.15);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: all var(--transition-speed) ease;
            cursor: pointer;
            line-height: 1;
        }

        .nav-link:hover,
        .nav-dropdown-wrap:hover .nav-dropdown-toggle,
        .nav-dropdown-wrap:focus-within .nav-dropdown-toggle {
            background: linear-gradient(135deg, #15803d 0%, #0b532b 100%);
            border-color: #22c55e;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.45), inset 0 1px 1px rgba(255, 255, 255, 0.25);
        }

        .nav-link:active,
        .nav-dropdown-toggle:active {
            transform: translateY(0);
        }

        /* Nav Dropdown for Tournaments */
        .nav-dropdown-wrap {
            position: relative;
            display: inline-block;
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

        /* Sign In Button upper right */
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
        }

        .signin-btn:hover {
            background-color: #15b300ff;
            transform: translateY(-1px);
        }

        /* Sign In Dropdown Styles */
        .signin-dropdown-wrap {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            cursor: pointer;
            border: none;
            font-family: inherit;
        }

        .signin-dropdown-wrap:hover .dropdown-toggle svg,
        .signin-dropdown-wrap:focus-within .dropdown-toggle svg {
            transform: rotate(180deg);
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

        /* Hero Content Area */
        .main-content {
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 2rem;
            padding-top: 6vh;
            z-index: 5;
        }

        .text-container {
            text-align: center;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Hero Emblem directly above UNITED SENIORS VELLANAD */
        .hero-emblem-wrap {
            margin-bottom: 1.25rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-emblem-img {
            width: clamp(140px, 18vw, 210px);
            height: auto;
            max-width: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.4));
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), filter 0.4s ease;
        }

        .hero-emblem-img:hover {
            transform: scale(1.06) translateY(-4px);
            filter: drop-shadow(0 16px 32px rgba(230, 0, 0, 0.45));
        }

        .title {
            color: var(--primary-color);
            font-weight: 800;
            font-size: clamp(2rem, 7vw, 5rem);
            letter-spacing: -0.02em;
            text-transform: uppercase;
            margin: 0;
            line-height: 1.1;
        }

        .hero-actions {
            margin-top: 2.2rem;
            display: flex;
            gap: 1.2rem;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-hero-about {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, #b80000 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 0.85rem 2.2rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            box-shadow: 0 8px 25px rgba(230, 0, 0, 0.45), inset 0 1px 1px rgba(255, 255, 255, 0.35);
            border: 2px solid rgba(231, 247, 17, 0.4);
            transition: all var(--transition-speed) ease;
        }

        .btn-hero-about:hover {
            transform: translateY(-3px) scale(1.03);
            background: linear-gradient(135deg, #15b300 0%, #0e7d00 100%);
            border-color: #ffffff;
            box-shadow: 0 12px 30px rgba(21, 179, 0, 0.5);
            color: #ffffff;
        }

        .btn-hero-about svg {
            transition: transform var(--transition-speed) ease;
        }

        .btn-hero-about:hover svg {
            transform: rotate(10deg) scale(1.15);
        }

        /* Scrolling Ticker Styles */
        .scrolling-ticker {
            background-color: var(--primary-color);
            color: #ffffff;
            overflow: hidden;
            white-space: nowrap;
            box-sizing: border-box;
            padding: 0.6rem 0;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            z-index: 100;
            position: relative;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            text-transform: uppercase;
        }

        .ticker-wrap {
            display: inline-block;
            padding-left: 100%;
            animation: ticker 30s linear infinite;
        }

        .ticker-wrap:hover {
            animation-play-state: paused;
        }

        @keyframes ticker {
            0% {
                transform: translate3d(0, 0, 0);
            }
            100% {
                transform: translate3d(-100%, 0, 0);
            }
        }

        .ticker-item {
            display: inline-block;
            padding-right: 2rem;
            font-family: 'Outfit', sans-serif;
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .ticker-separator {
            color: var(--text-color);
            margin: 0 1.5rem;
            font-size: 1.1rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }

            .nav-menu {
                gap: 0.65rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-link,
            .nav-dropdown-toggle {
                font-size: 0.95rem;
                padding: 0.55rem 1.1rem;
            }
        }

        /* Mobile App Bottom Bar / Floating Widget */
        .mobile-app-bottom-bar {
            position: fixed;
            bottom: 1.8rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 90;
            width: calc(100% - 3rem);
            max-width: 520px;
            animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .app-bar-content {
            background: rgba(14, 14, 14, 0.94);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 22px;
            padding: 0.85rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.65), 0 0 25px rgba(230, 0, 0, 0.18);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .app-bar-content:hover {
            transform: translateY(-3px);
            border-color: rgba(230, 0, 0, 0.5);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.75), 0 0 30px rgba(230, 0, 0, 0.3);
        }

        .app-icon-wrap {
            position: relative;
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border-radius: 14px;
            cursor: pointer;
        }

        .app-icon-img {
            width: 100%;
            height: 100%;
            border-radius: 14px;
            object-fit: cover;
            box-shadow: 0 6px 14px rgba(230, 0, 0, 0.4);
            display: block;
            border: 2px solid rgba(231, 247, 17, 0.4);
            transition: transform 0.3s ease;
        }

        .app-icon-wrap:hover .app-icon-img {
            transform: scale(1.08) rotate(3deg);
        }

        .app-pulse-ring {
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border: 2px solid var(--text-color);
            border-radius: 17px;
            animation: pulseGlow 2.5s infinite;
            pointer-events: none;
            opacity: 0.7;
        }

        @keyframes pulseGlow {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }

        @keyframes slideUpFade {
            from { opacity: 0; transform: translate(-50%, 25px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }

        .app-info {
            flex: 1;
            min-width: 0;
            cursor: pointer;
        }

        .app-title-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.15rem;
        }

        .app-title {
            color: #ffffff;
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .app-tag {
            background: rgba(231, 247, 17, 0.15);
            border: 1px solid var(--text-color);
            color: var(--text-color);
            font-size: 0.65rem;
            font-weight: 800;
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            letter-spacing: 0.05em;
        }

        .app-desc {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .app-actions {
            flex-shrink: 0;
        }

        .btn-install-app {
            background: linear-gradient(135deg, var(--primary-color), #b80000);
            color: #ffffff;
            border: none;
            padding: 0.65rem 1.1rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.82rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(230, 0, 0, 0.35);
            font-family: inherit;
        }

        .btn-install-app:hover {
            background: linear-gradient(135deg, #15b300, #0f8a00);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(21, 179, 0, 0.4);
        }

        /* Modal for PWA installation guide */
        .install-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.82);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            padding: 1.5rem;
            box-sizing: border-box;
        }

        .install-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .install-modal-card {
            background: rgba(18, 18, 18, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            max-width: 460px;
            width: 100%;
            padding: 2.2rem;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.85), 0 0 30px rgba(230, 0, 0, 0.2);
            text-align: center;
            position: relative;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            box-sizing: border-box;
        }

        .install-modal-overlay.active .install-modal-card {
            transform: scale(1);
        }

        .modal-close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: background 0.2s;
        }

        .modal-close-btn:hover {
            background: var(--primary-color);
        }

        .modal-app-badge {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(230, 0, 0, 0.4);
            margin: 0 auto 1.2rem auto;
            display: block;
            border: 2px solid rgba(231, 247, 17, 0.4);
        }

        .modal-title {
            color: #ffffff;
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0 0 0.4rem 0;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .modal-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin: 0 0 1.5rem 0;
            line-height: 1.4;
        }

        .guide-steps {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 1.2rem;
            text-align: left;
            margin-bottom: 1.5rem;
        }

        .guide-step {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.9rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.4;
        }

        .guide-step:last-child {
            margin-bottom: 0;
        }

        .step-icon {
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff5555;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .btn-modal-gotit {
            width: 100%;
            padding: 0.85rem;
            border: none;
            border-radius: 50px;
            background-color: var(--primary-color);
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-modal-gotit:hover {
            background-color: #15b300;
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            .mobile-app-bottom-bar {
                bottom: 1rem;
                width: calc(100% - 1.5rem);
            }
            .app-bar-content {
                padding: 0.65rem 0.9rem;
                gap: 0.75rem;
            }
            .app-icon-wrap {
                width: 44px;
                height: 44px;
            }
            .app-title {
                font-size: 0.85rem;
            }
            .app-desc {
                font-size: 0.7rem;
            }
            .btn-install-app {
                padding: 0.5rem 0.85rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    @if(isset($activeMessages) && $activeMessages->count() > 0)
        <div class="scrolling-ticker">
            <div class="ticker-wrap">
                @foreach($activeMessages as $msg)
                    <span class="ticker-item">{{ $msg->message }}</span>
                    @if(!$loop->last)
                        <span class="ticker-separator">•</span>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <!-- Background Layer -->
    <div class="bg-layer"></div>

    <!-- Header Navigation -->
    <header class="header">
        <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad - Home">
            <img src="{{ asset('usv-logo.png') }}" alt="USV Logo" class="logo-img">
            <span class="logo-text">USV</span>
        </a>
        <nav class="nav-menu">
            <a href="{{ route('members') }}" class="nav-link">MEMBERS</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>
            
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
                    <button type="button" class="signin-btn dropdown-toggle">
                        SIGN IN
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="margin-left: 4px; transition: transform 0.2s;">
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="text-container">
            <div class="hero-emblem-wrap">
                <img src="{{ asset('usv-logo.png') }}" alt="United Seniors Vellanad" class="hero-emblem-img">
            </div>
            <h1 class="title">UNITED SENIORS VELLANAD</h1>
            <div class="hero-actions">
                <a href="{{ route('about') }}" class="btn-hero-about">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    <span>ABOUT US</span>
                </a>
            </div>
        </div>
    </main>

    <!-- Mobile App Bottom Floating Bar / Widget -->
    <div class="mobile-app-bottom-bar" id="mobileAppBar">
        <div class="app-bar-content">
            <div class="app-icon-wrap" id="appIconTrigger" onclick="handleAppInstallClick()" title="Install USV Mobile App">
                <img src="{{ asset('icon-192.png') }}" alt="USV Mobile App" class="app-icon-img">
                <span class="app-pulse-ring"></span>
            </div>
            <div class="app-info" onclick="handleAppInstallClick()">
                <div class="app-title-row">
                    <span class="app-title">USV Mobile App</span>
                    <span class="app-tag">FREE PWA</span>
                </div>
                <div class="app-desc">Install on your phone for instant matches & updates</div>
            </div>
            <div class="app-actions">
                <button type="button" class="btn-install-app" id="installAppBtn" onclick="handleAppInstallClick()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM17 13l-5 5-5-5h3V9h4v4h3z"/>
                    </svg>
                    <span>Install App</span>
                </button>
            </div>
        </div>
    </div>

    <!-- PWA Installation Instructions Modal -->
    <div class="install-modal-overlay" id="installAppModal" onclick="handleBackdropClick(event)">
        <div class="install-modal-card">
            <button type="button" class="modal-close-btn" onclick="closeInstallModal()" title="Close">&times;</button>
            
            <img src="{{ asset('icon-192.png') }}" alt="USV Icon" class="modal-app-badge">
            <h3 class="modal-title">Get USV on Mobile</h3>
            <p class="modal-subtitle">Install United Seniors Vellanad app directly to your home screen for quick offline access, live tournament scores, and match notifications.</p>

            <div class="guide-steps">
                <div class="guide-step">
                    <span class="step-icon">🤖</span>
                    <div><strong>Android (Chrome):</strong> Tap the three dots (<strong>⋮</strong>) in the top-right corner, then select <strong>"Install app"</strong> or <strong>"Add to Home screen"</strong>.</div>
                </div>
                <div class="guide-step">
                    <span class="step-icon">🍎</span>
                    <div><strong>iPhone / iPad (Safari):</strong> Tap the <strong>Share</strong> icon (<strong>⎋</strong>) in the bottom bar, scroll down and tap <strong>"Add to Home Screen" ➕</strong>.</div>
                </div>
                <div class="guide-step">
                    <span class="step-icon">💻</span>
                    <div><strong>Desktop (Chrome/Edge):</strong> Click the <strong>Install</strong> icon (<strong>⊕</strong>) in your browser's address bar.</div>
                </div>
            </div>

            <button type="button" class="btn-modal-gotit" onclick="closeInstallModal()">Got It, Thanks!</button>
        </div>
    </div>

    <script>
        let deferredPrompt = null;

        // Capture PWA install prompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            const btn = document.getElementById('installAppBtn');
            if (btn) {
                btn.classList.add('ready');
            }
        });

        // Handle install button or icon click
        function handleAppInstallClick() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the PWA install prompt');
                    }
                    deferredPrompt = null;
                });
            } else {
                openInstallModal();
            }
        }

        function openInstallModal() {
            document.getElementById('installAppModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeInstallModal() {
            document.getElementById('installAppModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function handleBackdropClick(event) {
            if (event.target === document.getElementById('installAppModal')) {
                closeInstallModal();
            }
        }

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeInstallModal();
            }
        });
    </script>
</body>

</html>
