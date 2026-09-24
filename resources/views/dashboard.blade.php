<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <!-- Modern typography from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            --text-color: #e7f711ff;
            --border-color: rgba(255, 255, 255, 0.15);
            --transition-speed: 0.3s;
        }

        body {
            background-color: #ffffff;
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
            filter: blur(2px);
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
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 600;
            font-size: 1.9rem;
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

        .nav-link:hover {
            color: var(--primary-color);
        }

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

        .auth-menu {
            display: flex;
            align-items: center;
        }

        .logout-btn {
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
        }

        .logout-btn:hover {
            background-color: #15b300ff;
            transform: translateY(-1px);
        }

        /* Dashboard Container */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            z-index: 5;
        }

        .dashboard-card {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 3rem;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .dashboard-welcome {
            color: #ffffff;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 0.5rem;
            opacity: 0.7;
        }

        .dashboard-title {
            color: #ffffff;
            font-weight: 800;
            font-size: 2.2rem;
            text-transform: uppercase;
            text-align: center;
            margin-top: 0;
            margin-bottom: 3rem;
            letter-spacing: 0.05em;
        }

        /* Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 2rem;
            justify-content: center;
        }

        .menu-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem 1.5rem;
            text-decoration: none;
            transition: transform var(--transition-speed), border-color var(--transition-speed), background-color var(--transition-speed), box-shadow var(--transition-speed);
        }

        .menu-btn:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px rgba(230, 0, 0, 0.2);
        }

        .menu-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 1.2rem;
            transition: transform var(--transition-speed);
        }

        .menu-btn:hover .menu-icon {
            transform: scale(1.1);
        }

        .menu-text {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            text-align: center;
            transition: color var(--transition-speed);
        }

        .menu-btn:hover .menu-text {
            color: var(--text-color);
        }

        /* Success Alert */
        .alert-success {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            background-color: rgba(21, 179, 0, 0.2);
            border: 1px solid #15b300ff;
            color: #15b300ff;
            text-align: center;
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

            .dashboard-card {
        /* Subnav Back & Home buttons */
        .subnav-buttons-wrap {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .subpage-back-btn,
        .subpage-home-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.95rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.25s ease;
            font-family: inherit;
            line-height: 1;
        }

        .subpage-back-btn {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.22);
        }

        .subpage-back-btn:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: #ffffff;
            transform: translateX(-2px);
            color: #ffffff;
        }

        .subpage-home-btn {
            background: linear-gradient(135deg, #e60000 0%, #b80000 100%);
            color: #ffffff;
            border: 1px solid rgba(231, 247, 17, 0.35);
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.35);
        }

        .subpage-home-btn:hover {
            background: linear-gradient(135deg, #15b300 0%, #0e7d00 100%);
            border-color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(21, 179, 0, 0.45);
            color: #ffffff;
        }
    </style>
</head>

<body>
    <!-- Background Layer -->
    <div class="bg-layer"></div>

    <!-- Header Navigation -->
    <header class="header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad">
                <img src="{{ asset('usv-logo.png') }}" alt="USV Logo" class="logo-img">
                <span class="logo-text">USV</span>
            </a>
            <div class="subnav-buttons-wrap">
                <button type="button" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'" class="subpage-back-btn" title="Go Back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>Back</span>
                </button>
                <a href="{{ url('/') }}" class="subpage-home-btn" title="Return to Home Page">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    <span>Home</span>
                </a>
            </div>
        </div>
        <nav class="nav-menu">
            <a href="{{ url('/') }}" class="nav-link">HOME</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>
            <a href="https://cricheroes.com" class="nav-link">MATCHES</a>
            <a href="{{ route('players.index') }}" class="nav-link">PLAYERS</a>
            
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

            <a href="{{ route('register.create') }}" class="nav-link">REGISTER</a>
            <a href="{{ route('contact') }}" class="nav-link">CONTACT</a>
        </nav>
        <div class="auth-menu">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span class="user-role-badge {{ ($isAdmin ?? false) ? 'admin-badge' : 'player-badge' }}">
                    {{ ($isAdmin ?? false) ? '🛡️ ADMIN' : '🏏 PLAYER' }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">LOG OUT</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-card">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($isAdmin ?? false)
                <div class="dashboard-welcome">Administrator Portal &bull; Full Permissions</div>
                <h2 class="dashboard-title">Admin Control Center</h2>

                <div class="dashboard-grid">
                    <!-- Registered Players Management Button -->
                    <a href="{{ route('admin.register.index') }}" class="menu-btn" style="border-color: rgba(34, 197, 94, 0.5); background: rgba(34, 197, 94, 0.08);">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z" fill="#22c55e"/>
                        </svg>
                        <span class="menu-text" style="color: #22c55e;">Registered Players</span>
                    </a>

                    <!-- Manage Players Button -->
                    <a href="{{ route('players.index') }}" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Manage Players</span>
                    </a>

                    <!-- Manage Tournaments Button -->
                    <a href="{{ route('tournaments.index') }}" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 5h-2V3H7v2H5C3.9 5 3 5.9 3 7v3c0 2.2 1.8 4 4 4h1.09c.72 1.96 2.43 3.44 4.54 3.86V21H9v2h6v-2h-3.63v-3.14c2.11-.42 3.82-1.9 4.54-3.86H17c2.2 0 4-1.8 4-4V7c0-1.1-.9-2-2-2zM5 10V7h2v3H5zm14 0h-2V7h2v3z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Tournaments</span>
                    </a>

                    <!-- Ticker Message Button -->
                    <a href="{{ route('scrolling-messages.edit') }}" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Ticker Messages</span>
                    </a>

                    <!-- About Club Button -->
                    <a href="{{ route('about.edit') }}" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">About Club</span>
                    </a>

                    <!-- Manage Contacts Button -->
                    <a href="{{ route('contact.manage') }}" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.5c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 11H6v-.5c0-2 4-3.1 6-3.1s6 1.1 6 3.1v.5z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Manage Contacts</span>
                    </a>

                    <!-- Teams Button -->
                    <a href="#teams" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 8 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Teams</span>
                    </a>

                    <!-- Payment Button -->
                    <a href="#payment" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Payment</span>
                    </a>

                    <!-- My Profile Button -->
                    <a href="#profile" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Admin Profile</span>
                    </a>
                </div>
            @else
                <div class="dashboard-welcome">Signed in as {{ $email }}</div>
                <h2 class="dashboard-title">Player Dashboard</h2>

                <div class="dashboard-grid">
                    <!-- My Profile Button -->
                    <a href="#profile" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">My Profile</span>
                    </a>

                    <!-- Squad Roster Button -->
                    <a href="{{ route('players.index') }}" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Squad Roster</span>
                    </a>

                    <!-- Tournaments Button -->
                    <a href="{{ route('tournaments.index') }}" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 5h-2V3H7v2H5C3.9 5 3 5.9 3 7v3c0 2.2 1.8 4 4 4h1.09c.72 1.96 2.43 3.44 4.54 3.86V21H9v2h6v-2h-3.63v-3.14c2.11-.42 3.82-1.9 4.54-3.86H17c2.2 0 4-1.8 4-4V7c0-1.1-.9-2-2-2zM5 10V7h2v3H5zm14 0h-2V7h2v3z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Tournaments</span>
                    </a>

                    <!-- Awards Button -->
                    <a href="#awards" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Awards</span>
                    </a>

                    <!-- Teams Button -->
                    <a href="#teams" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 8 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Teams</span>
                    </a>

                    <!-- Payment Button -->
                    <a href="#payment" class="menu-btn">
                        <svg class="menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" fill="#e60000"/>
                        </svg>
                        <span class="menu-text">Payment</span>
                    </a>
                </div>
            @endif
            </div>
        </div>
    </main>
</body>

</html>
