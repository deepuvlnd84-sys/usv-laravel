<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $member->name }} - Member Profile | UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            --primary-hover: #15b300ff;
            --text-color: #e7f711ff;
            --border-color: rgba(255, 255, 255, 0.15);
            --card-bg: rgba(14, 14, 14, 0.85);
            --transition-speed: 0.25s;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #0d0d0d;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            color: #ffffff;
            overflow-x: hidden;
        }

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
            filter: blur(4px);
            z-index: -1;
        }

        /* Header Navigation */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 3rem;
            position: relative;
            z-index: 10;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(12px);
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
            width: 48px;
            height: auto;
            max-height: 46px;
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
            font-size: 1.1rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: color var(--transition-speed);
            position: relative;
            padding: 0.25rem 0;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #ffffff;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(230, 0, 0, 0.8);
        }

        .auth-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .signin-btn {
            background-color: var(--primary-color);
            color: #ffffff;
            border: 2px solid transparent;
            padding: 0.55rem 1.4rem;
            font-size: 0.9rem;
            font-weight: 800;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all var(--transition-speed);
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.3);
        }

        .signin-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(21, 179, 0, 0.4);
        }

        .user-role-badge {
            font-size: 0.8rem;
            font-weight: 800;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .admin-badge {
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff6b6b;
        }

        /* Main Container */
        .profile-container {
            max-width: 900px;
            margin: 2.5rem auto 4rem;
            padding: 0 1.5rem;
            width: 100%;
        }

        /* Breadcrumb Bar */
        .breadcrumb-bar {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .breadcrumb-bar a {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-bar a:hover {
            color: #ffffff;
        }

        .breadcrumb-separator {
            color: rgba(255, 255, 255, 0.3);
        }

        /* Profile Card */
        .profile-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border-color);
            border-radius: 26px;
            backdrop-filter: blur(20px);
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            position: relative;
        }

        /* Card Banner */
        .profile-banner {
            height: 160px;
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.85) 0%, rgba(90, 0, 0, 0.9) 100%);
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            padding: 1.25rem 2rem;
            border-bottom: 2px solid rgba(231, 247, 17, 0.3);
        }

        .banner-watermark {
            font-size: 3.5rem;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.08);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            user-select: none;
            position: absolute;
            left: 2rem;
            bottom: 0.5rem;
        }

        .banner-badge {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 800;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            z-index: 2;
        }

        /* Profile Content Area */
        .profile-content {
            padding: 0 2.5rem 2.5rem;
            position: relative;
        }

        /* Avatar Row */
        .avatar-wrap {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: -65px;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .profile-avatar {
            width: 125px;
            height: 125px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e60000 0%, #6b0000 100%);
            border: 5px solid #141414;
            box-shadow: 0 10px 25px rgba(230, 0, 0, 0.5), inset 0 0 15px rgba(231, 247, 17, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.2rem;
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            position: relative;
            flex-shrink: 0;
        }

        .avatar-online-dot {
            position: absolute;
            bottom: 6px;
            right: 6px;
            width: 22px;
            height: 22px;
            background: #15b300;
            border: 3.5px solid #141414;
            border-radius: 50%;
            box-shadow: 0 0 10px #15b300;
        }

        .profile-quick-badges {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.1rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .badge-sl {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.85);
        }

        .badge-id {
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.25), rgba(230, 0, 0, 0.45));
            border: 1.5px solid rgba(230, 0, 0, 0.7);
            color: #ff8585;
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.3);
        }

        /* Member Info */
        .member-headline {
            margin-bottom: 2rem;
        }

        .member-title {
            font-size: 2.35rem;
            font-weight: 900;
            margin: 0 0 0.5rem 0;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: #ffffff;
            text-shadow: 0 3px 10px rgba(0, 0, 0, 0.7);
        }

        .member-subtitle-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .callname-highlight {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(231, 247, 17, 0.12);
            border: 1.5px solid rgba(231, 247, 17, 0.5);
            color: var(--text-color);
            padding: 0.45rem 1rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .club-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* Detail Cards Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .detail-item {
            background: rgba(255, 255, 255, 0.035);
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 16px;
            padding: 1.25rem 1.4rem;
            transition: transform 0.2s, border-color 0.2s, background 0.2s;
        }

        .detail-item:hover {
            transform: translateY(-2px);
            border-color: rgba(230, 0, 0, 0.4);
            background: rgba(230, 0, 0, 0.06);
        }

        .detail-label {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.45);
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }

        .detail-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.03em;
        }

        .detail-value.accent {
            color: var(--text-color);
        }

        .detail-value.red {
            color: #ff6b6b;
        }

        /* Action Buttons Area */
        .profile-actions-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.75rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 0.7rem 1.6rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: #ffffff;
            transform: translateX(-3px);
        }

        .admin-controls-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-edit-member {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #e60000;
            border: none;
            color: #ffffff;
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.88rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(230, 0, 0, 0.4);
        }

        .btn-edit-member:hover {
            background: #ff2222;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(230, 0, 0, 0.6);
        }

        .btn-delete-member {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            border: 1.5px solid rgba(230, 0, 0, 0.6);
            color: #ff6b6b;
            padding: 0.68rem 1.4rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.88rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-delete-member:hover {
            background: rgba(230, 0, 0, 0.2);
            border-color: #e60000;
            color: #ffffff;
        }

        /* Alerts */
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

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 1rem;
        }

        .modal-card {
            background: #181818;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 22px;
            width: 100%;
            max-width: 520px;
            padding: 2rem;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.8);
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
        }

        .modal-title {
            font-size: 1.4rem;
            font-weight: 900;
            color: #ffffff;
            margin: 0;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .modal-close-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.6rem;
            cursor: pointer;
            line-height: 1;
            transition: color 0.2s;
        }

        .modal-close-btn:hover {
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.75);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.45rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1.1rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #ffffff;
            font-family: inherit;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.12);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.85rem;
            margin-top: 1.75rem;
        }

        .btn-cancel {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: none;
            padding: 0.7rem 1.4rem;
            border-radius: 50px;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-save {
            background: var(--primary-color);
            color: #ffffff;
            border: none;
            padding: 0.7rem 1.6rem;
            border-radius: 50px;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s;
        }

        .btn-save:hover {
            background: var(--primary-hover);
        }

        @media (max-width: 768px) {
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

            .profile-content {
                padding: 0 1.5rem 1.75rem;
            }

            .avatar-wrap {
                justify-content: center;
                text-align: center;
            }

            .member-headline {
                text-align: center;
            }

            .member-subtitle-row {
                justify-content: center;
            }

            .profile-actions-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .admin-controls-group {
                justify-content: center;
            }

            .btn-back {
                justify-content: center;
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
        <div class="header-nav-actions">
            <button type="button" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'" class="btn-nav-back" title="Go Back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back</span>
            </button>
            <a href="{{ url('/') }}" class="btn-nav-home" title="Go to Home Page">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                <span>Home</span>
            </a>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('members') }}" class="nav-link active">MEMBERS</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>
            <a href="{{ route('tournaments.index') }}" class="nav-link">TOURNAMENTS</a>
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
                        <button type="submit" class="signin-btn">LOG OUT</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login.admin') }}" class="signin-btn">ADMIN SIGN IN</a>
            @endif
        </div>
    </header>

    <!-- Main Container -->
    <main class="profile-container">
        <!-- Breadcrumb Navigation -->
        <div class="breadcrumb-bar">
            <a href="{{ url('/') }}">HOME</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('members') }}">MEMBERS</a>
            <span class="breadcrumb-separator">/</span>
            <span>{{ $member->name }}</span>
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

        <!-- Profile Card -->
        <article class="profile-card">
            <!-- Banner -->
            <div class="profile-banner">
                <div class="banner-watermark">USV VELLANAD</div>
                <div class="banner-badge">OFFICIAL CLUB ROSTER</div>
            </div>

            <!-- Content Area -->
            <div class="profile-content">
                <!-- Avatar & Badges Row -->
                <div class="avatar-wrap">
                    <div class="profile-avatar">
                        {{ substr($member->name, 0, 1) }}
                        <div class="avatar-online-dot" title="Registered & Active Member"></div>
                    </div>
                    <div class="profile-quick-badges">
                        <span class="badge-pill badge-sl">SL NO: #{{ $member->sl_no }}</span>
                        <span class="badge-pill badge-id">MEMBER ID: {{ $member->member_id }}</span>
                    </div>
                </div>

                <!-- Headline & Name -->
                <div class="member-headline">
                    <h1 class="member-title">{{ $member->name }}</h1>
                    <div class="member-subtitle-row">
                        @if(!empty(trim($member->call_name ?? '')))
                            <div class="callname-highlight">
                                <span>🗣️</span>
                                <span>CALL NAME: <strong>{{ $member->call_name }}</strong></span>
                            </div>
                        @endif
                        <span class="club-label">UNITED SENIORS VELLANAD</span>
                    </div>
                </div>

                <!-- Detailed Information Grid -->
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Serial Number</div>
                        <div class="detail-value">#{{ $member->sl_no }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Member ID Number</div>
                        <div class="detail-value red">{{ $member->member_id }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Full Name</div>
                        <div class="detail-value">{{ $member->name }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Call / Known Name</div>
                        <div class="detail-value accent">
                            {{ !empty(trim($member->call_name ?? '')) ? $member->call_name : '—' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Club Membership</div>
                        <div class="detail-value">Official Member</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Database Record</div>
                        <div class="detail-value">usv_members</div>
                    </div>
                </div>

                <!-- Bottom Navigation & Admin Controls -->
                <div class="profile-actions-bar">
                    <a href="{{ route('members') }}" class="btn-back">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Back to Members List
                    </a>

                    @if($isAdmin)
                        <div class="admin-controls-group">
                            <button type="button" class="btn-edit-member" onclick="openEditModal()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                </svg>
                                Edit Member
                            </button>

                            <form action="{{ route('members.destroy', $member->sl_no) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete member {{ addslashes($member->name) }} (ID: {{ $member->member_id }}) from usv_members?');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-member">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </article>
    </main>

    @if($isAdmin)
        <!-- Edit Member Modal -->
        <div id="editMemberModal" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Member Details</h3>
                    <button type="button" class="modal-close-btn" onclick="closeEditModal()">&times;</button>
                </div>
                <form action="{{ route('members.update', $member->sl_no) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Serial No (SL NO)</label>
                        <input type="text" class="form-control" value="#{{ $member->sl_no }}" readonly style="opacity: 0.6; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Member ID *</label>
                        <input type="number" name="member_id" class="form-control" value="{{ old('member_id', $member->member_id) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Member Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $member->name) }}" required maxlength="150">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Call / Known Name (Optional)</label>
                        <input type="text" name="call_name" class="form-control" value="{{ old('call_name', $member->call_name) }}" maxlength="100">
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openEditModal() {
                document.getElementById('editMemberModal').style.display = 'flex';
            }
            function closeEditModal() {
                document.getElementById('editMemberModal').style.display = 'none';
            }
            window.addEventListener('click', function(e) {
                const modal = document.getElementById('editMemberModal');
                if (e.target === modal) {
                    closeEditModal();
                }
            });
        </script>
    @endif
</body>
</html>
