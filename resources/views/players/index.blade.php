<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Members - UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <!-- Modern typography from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            --primary-hover: #15b300ff;
            --text-color: #e7f711ff;
            --border-color: rgba(255, 255, 255, 0.15);
            --card-bg: rgba(0, 0, 0, 0.78);
            --transition-speed: 0.25s;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #111111;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            color: #ffffff;
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
            opacity: 0.45;
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
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
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
            font-size: 1.15rem;
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

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }

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
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
        }

        .signin-btn:hover {
            background-color: var(--primary-hover);
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

        /* Main Container */
        .main-container {
            flex: 1;
            padding: 2.5rem 3rem 4rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            z-index: 5;
        }

        /* Header Area */
        .roster-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .roster-title-area h1 {
            font-size: 2.75rem;
            font-weight: 900;
            margin: 0 0 0.4rem 0;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }

        .roster-title-area h1 span {
            color: var(--primary-color);
        }

        .roster-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            letter-spacing: 0.03em;
            margin: 0;
        }

        .members-count-badge {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-end;
            background: rgba(230, 0, 0, 0.12);
            border: 1.5px solid rgba(230, 0, 0, 0.4);
            padding: 0.65rem 1.4rem;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .count-number {
            font-size: 2rem;
            font-weight: 900;
            color: var(--text-color);
            line-height: 1;
        }

        .count-label {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.75);
            text-transform: uppercase;
            margin-top: 0.25rem;
        }

        /* Feedback Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alert-success {
            background-color: rgba(21, 179, 0, 0.2);
            border: 1px solid #15b300ff;
            color: #15b300ff;
        }

        .alert-danger {
            background-color: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff5555;
        }

        /* Filter & Search Bar */
        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 0.9rem 1.6rem;
            margin-bottom: 2rem;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 280px;
            max-width: 480px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid var(--border-color);
            border-radius: 50px;
            padding: 0.65rem 1.35rem;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-box:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 16px rgba(230, 0, 0, 0.35);
        }

        .search-box input {
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            font-size: 0.95rem;
            width: 100%;
            font-family: inherit;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.45);
        }

        .clear-search-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0 0.2rem;
            line-height: 1;
            transition: color 0.2s;
        }

        .clear-search-btn:hover {
            color: var(--primary-color);
        }

        .view-switch-controls {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .showing-text {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .view-toggle-btns {
            display: inline-flex;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50px;
            padding: 3px;
            border: 1px solid var(--border-color);
        }

        .view-btn {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 0.45rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .view-btn.active {
            background: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.4);
        }

        /* Members Table Container */
        .members-table-container {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            margin-bottom: 2.5rem;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .usv-members-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .usv-members-table th {
            background: rgba(255, 255, 255, 0.04);
            border-bottom: 2px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 1.1rem 1.5rem;
            white-space: nowrap;
        }

        .usv-members-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            vertical-align: middle;
            transition: background 0.15s ease;
        }

        .usv-members-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .usv-members-table tbody tr:hover {
            background: rgba(230, 0, 0, 0.12);
        }

        .usv-members-table tbody tr:last-child td {
            border-bottom: none;
        }

        .sl-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.08);
            padding: 0.25rem 0.65rem;
            border-radius: 8px;
            letter-spacing: 0.04em;
        }

        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.2), rgba(230, 0, 0, 0.35));
            border: 1px solid rgba(230, 0, 0, 0.5);
            color: #ff6b6b;
            font-weight: 800;
            font-size: 0.82rem;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            letter-spacing: 0.05em;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .member-name-wrap {
            display: flex;
            align-items: center;
            gap: 0.9rem;
        }

        .member-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e60000 0%, #7a0000 100%);
            color: #ffffff;
            font-weight: 900;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(230, 0, 0, 0.4);
            border: 1.5px solid rgba(231, 247, 17, 0.4);
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .member-avatar.large {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }

        .name-text {
            font-size: 1.05rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .call-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(231, 247, 17, 0.12);
            border: 1px solid rgba(231, 247, 17, 0.4);
            color: var(--text-color);
            font-weight: 800;
            font-size: 0.82rem;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .call-empty {
            color: rgba(255, 255, 255, 0.25);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Members Cards Grid */
        .members-grid-container {
            margin-bottom: 2.5rem;
        }

        .members-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 1.5rem;
        }

        .member-card-item {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 1.35rem 1.4rem;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .member-card-item:hover {
            transform: translateY(-4px);
            border-color: rgba(230, 0, 0, 0.55);
            box-shadow: 0 12px 28px rgba(230, 0, 0, 0.25);
        }

        .card-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-avatar-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-info {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            min-width: 0;
        }

        .card-info .name-text {
            font-size: 1.05rem;
            line-height: 1.3;
            word-break: break-word;
        }

        .club-tag {
            font-size: 0.68rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .card-footer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 0.85rem;
            margin-top: auto;
        }

        .footer-label {
            font-size: 0.72rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* No Results Box */
        .no-results-box {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 3.5rem 2rem;
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .no-results-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .no-results-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .no-results-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .btn-reset-search {
            background: var(--primary-color);
            color: #ffffff;
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all var(--transition-speed);
        }

        .btn-reset-search:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .empty-table-cell {
            text-align: center;
            padding: 3rem !important;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }

            .nav-menu {
                gap: 1.25rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .main-container {
                padding: 1.5rem 1.5rem 3rem;
            }

            .roster-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .members-count-badge {
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .roster-title-area h1 {
                font-size: 2.1rem;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-wrapper {
                max-width: 100%;
                min-width: 100%;
            }

            .view-switch-controls {
                justify-content: space-between;
                width: 100%;
            }

            .usv-members-table th, .usv-members-table td {
                padding: 0.85rem 1rem;
            }

            .members-cards-grid {
                grid-template-columns: 1fr;
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
            <a href="{{ route('members') }}" class="nav-link active">MEMBERS</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>
            <a href="{{ route('tournaments.index') }}" class="nav-link">TOURNAMENTS</a>
            <a href="{{ route('gallery') }}" class="nav-link">GALLERY</a>
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
                        <button type="submit" class="signin-btn">LOG OUT</button>
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

    <!-- Main Container -->
    <main class="main-container">
        <!-- Roster Top Bar -->
        <div class="roster-header">
            <div class="roster-title-area">
                <h1>CLUB <span>MEMBERS</span></h1>
                <p class="roster-subtitle">Official members list of United Seniors Vellanad (from USV database)</p>
            </div>
            <div class="members-count-badge">
                <span class="count-number" id="headerCountBadge">{{ $totalMembers ?? count($members) }}</span>
                <span class="count-label">Registered Members</span>
            </div>
        </div>

        <!-- Feedback Alerts -->
        @if(session('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
                <span style="cursor: pointer;" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger">
                <div>
                    @foreach($errors->all() as $error)
                        <div>&bull; {{ $error }}</div>
                    @endforeach
                </div>
                <span style="cursor: pointer;" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
        @endif

        <!-- Filter and Search Bar -->
        <div class="filter-bar">
            <div class="search-wrapper">
                <div class="search-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="rgba(255, 255, 255, 0.6)">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input type="text" id="memberSearch" placeholder="Search by name, ID or call name..." autocomplete="off" oninput="handleMemberSearch(this.value)">
                    <button type="button" id="clearSearchBtn" class="clear-search-btn" onclick="clearSearch()" style="display: none;" title="Clear Search">&times;</button>
                </div>
            </div>
            <div class="view-switch-controls">
                <span class="showing-text" id="showingCounter">Showing {{ $totalMembers ?? count($members) }} of {{ $totalMembers ?? count($members) }} members</span>
                <div class="view-toggle-btns">
                    <button type="button" class="view-btn active" id="btnViewTable" onclick="switchView('table')" title="Table View">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/>
                        </svg>
                        Table
                    </button>
                    <button type="button" class="view-btn" id="btnViewGrid" onclick="switchView('grid')" title="Cards View">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h4v4H4V4zm6 0h4v4h-4V4zm6 0h4v4h-4V4zM4 10h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4zM4 16h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4z"/>
                        </svg>
                        Cards
                    </button>
                </div>
            </div>
        </div>

        <!-- MEMBERS TABLE VIEW (Default) -->
        <div class="members-table-container" id="membersTableView">
            <div class="table-responsive">
                <table class="usv-members-table">
                    <thead>
                        <tr>
                            <th class="col-sl">SL NO</th>
                            <th class="col-id">MEMBER ID</th>
                            <th class="col-name">MEMBER NAME</th>
                            <th class="col-call">CALL NAME</th>
                        </tr>
                    </thead>
                    <tbody id="membersTableBody">
                        @forelse($members as $member)
                            <tr class="member-row" data-name="{{ strtolower($member->name) }}" data-id="{{ $member->member_id }}" data-call="{{ strtolower($member->call_name ?? '') }}" data-sl="{{ $member->sl_no }}">
                                <td class="col-sl">
                                    <span class="sl-badge">#{{ $member->sl_no }}</span>
                                </td>
                                <td class="col-id">
                                    <span class="id-badge">ID: {{ $member->member_id }}</span>
                                </td>
                                <td class="col-name">
                                    <div class="member-name-wrap">
                                        <div class="member-avatar">{{ substr($member->name, 0, 1) }}</div>
                                        <span class="name-text">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td class="col-call">
                                    @if(!empty(trim($member->call_name ?? '')))
                                        <span class="call-badge">{{ $member->call_name }}</span>
                                    @else
                                        <span class="call-empty">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-table-cell">No members found in usv_members database table.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MEMBERS GRID VIEW (Toggled) -->
        <div class="members-grid-container" id="membersGridView" style="display: none;">
            <div class="members-cards-grid" id="membersCardsGrid">
                @foreach($members as $member)
                    <div class="member-card-item" data-name="{{ strtolower($member->name) }}" data-id="{{ $member->member_id }}" data-call="{{ strtolower($member->call_name ?? '') }}" data-sl="{{ $member->sl_no }}">
                        <div class="card-header-bar">
                            <span class="sl-badge">#{{ $member->sl_no }}</span>
                            <span class="id-badge">ID: {{ $member->member_id }}</span>
                        </div>
                        <div class="card-avatar-row">
                            <div class="member-avatar large">{{ substr($member->name, 0, 1) }}</div>
                            <div class="card-info">
                                <h3 class="name-text">{{ $member->name }}</h3>
                                <div class="club-tag">UNITED SENIORS VELLANAD</div>
                            </div>
                        </div>
                        <div class="card-footer-bar">
                            <span class="footer-label">CALL NAME</span>
                            @if(!empty(trim($member->call_name ?? '')))
                                <span class="call-badge">{{ $member->call_name }}</span>
                            @else
                                <span class="call-empty">—</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- No Results Fallback -->
        <div id="noResultsState" class="no-results-box" style="display: none;">
            <div class="no-results-icon">🔍</div>
            <div class="no-results-title">No matching members found</div>
            <div class="no-results-desc">No registered club member matched your search query.</div>
            <button type="button" class="btn-reset-search" onclick="clearSearch()">View All Members</button>
        </div>
    </main>

    <!-- Interactive Client Scripts -->
    <script>
        const totalMemberCount = parseInt('{{ $totalMembers ?? count($members) }}', 10) || 0;
        let currentView = 'table';

        // Switch View between Table and Grid
        function switchView(view) {
            currentView = view;
            const tableView = document.getElementById('membersTableView');
            const gridView = document.getElementById('membersGridView');
            const btnTable = document.getElementById('btnViewTable');
            const btnGrid = document.getElementById('btnViewGrid');

            if (view === 'table') {
                tableView.style.display = 'block';
                gridView.style.display = 'none';
                btnTable.classList.add('active');
                btnGrid.classList.remove('active');
            } else {
                tableView.style.display = 'none';
                gridView.style.display = 'block';
                btnGrid.classList.add('active');
                btnTable.classList.remove('active');
            }
        }

        // Live Filter Functionality
        function handleMemberSearch(query) {
            const val = (query || '').toLowerCase().trim();
            const clearBtn = document.getElementById('clearSearchBtn');
            const counter = document.getElementById('showingCounter');
            const noResults = document.getElementById('noResultsState');
            const tableView = document.getElementById('membersTableView');
            const gridView = document.getElementById('membersGridView');

            if (clearBtn) {
                clearBtn.style.display = val.length > 0 ? 'inline-block' : 'none';
            }

            const rows = document.querySelectorAll('.member-row');
            const cards = document.querySelectorAll('.member-card-item');
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const id = row.getAttribute('data-id') || '';
                const call = row.getAttribute('data-call') || '';
                const sl = row.getAttribute('data-sl') || '';

                const matches = val === '' || name.includes(val) || id.includes(val) || call.includes(val) || sl.includes(val);

                if (matches) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const id = card.getAttribute('data-id') || '';
                const call = card.getAttribute('data-call') || '';
                const sl = card.getAttribute('data-sl') || '';

                const matches = val === '' || name.includes(val) || id.includes(val) || call.includes(val) || sl.includes(val);

                if (matches) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            if (counter) {
                counter.textContent = `Showing ${visibleCount} of ${totalMemberCount} members`;
            }

            if (visibleCount === 0) {
                noResults.style.display = 'block';
                if (tableView) tableView.style.display = 'none';
                if (gridView) gridView.style.display = 'none';
            } else {
                noResults.style.display = 'none';
                if (currentView === 'table') {
                    if (tableView) tableView.style.display = 'block';
                    if (gridView) gridView.style.display = 'none';
                } else {
                    if (tableView) tableView.style.display = 'none';
                    if (gridView) gridView.style.display = 'block';
                }
            }
        }

        // Clear Search
        function clearSearch() {
            const input = document.getElementById('memberSearch');
            if (input) {
                input.value = '';
                input.focus();
            }
            handleMemberSearch('');
        }
    </script>
</body>
</html>
