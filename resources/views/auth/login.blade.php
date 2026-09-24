<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - UNITED SENIORS VELLANAD</title>
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
            background-color: #15b300ff;
            transform: translateY(-1px);
        }

        /* Sign In Dropdown */
        .signin-dropdown-wrap {
            position: relative;
            display: inline-block;
        }

        .signin-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
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

        /* Form Container Area */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            z-index: 5;
        }

        .form-card {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
        }

        .form-title {
            color: #ffffff;
            font-weight: 800;
            font-size: 2rem;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: 0.05em;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
        }

        .form-input {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 1rem;
            font-family: inherit;
            box-sizing: border-box;
            transition: border-color var(--transition-speed), background-color var(--transition-speed);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.15);
        }

        /* Captcha group layout */
        .captcha-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            align-items: center;
        }

        .captcha-box {
            background: rgba(230, 0, 0, 0.15);
            border: 1px dashed var(--primary-color);
            border-radius: 10px;
            color: var(--text-color);
            font-size: 1.3rem;
            font-weight: 800;
            text-align: center;
            padding: 0.75rem;
            letter-spacing: 0.1em;
            user-select: none;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            background-color: var(--primary-color);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
            margin-top: 1rem;
        }

        .submit-btn:hover {
            background-color: #15b300ff;
            transform: translateY(-2px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Classy Register & Forgot Password links */
        .form-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-link {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: color var(--transition-speed);
        }

        .footer-link:hover {
            color: var(--primary-color);
        }

        /* Alert styling */
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .alert-danger {
            background-color: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff4d4d;
        }

        .error-list {
            margin: 0;
            padding-left: 1.2rem;
        }



        /* Responsive design */
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

            .form-card {
                padding: 2rem;
            }


        }
    </style>
</head>

<body>
    <!-- Background Layer -->
    <div class="bg-layer"></div>

    <!-- Header Navigation -->
    <header class="header">
        <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad">
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
            <a href="{{ url('/') }}" class="nav-link">HOME</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>
            <a href="https://cricheroes.com" class="nav-link">MATCHES</a>
            <a href="{{ route('players.index') }}" class="nav-link">PLAYERS</a>
            <a href="{{ route('tournaments.index') }}" class="nav-link">TOURNAMENTS</a>
            <a href="{{ route('contact') }}" class="nav-link">CONTACT</a>
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
        <div class="form-card">
            <h2 class="form-title">Player Sign In</h2>
            <p style="text-align: center; color: rgba(255, 255, 255, 0.7); font-size: 0.85rem; margin-top: -1.2rem; margin-bottom: 1.5rem;">Access player profile & stats via Email OTP</p>

            <div style="background: rgba(255, 255, 255, 0.05); border: 1px dashed rgba(255, 255, 255, 0.2); border-radius: 10px; padding: 0.6rem; text-align: center; margin-bottom: 1.5rem;">
                <span style="font-size: 0.82rem; color: rgba(255,255,255,0.7);">Are you a Club Administrator? </span>
                <a href="{{ route('login.admin') }}" style="color: var(--text-color); font-weight: 700; font-size: 0.82rem; text-decoration: none;">Admin Log In &rarr;</a>
            </div>

            <!-- Errors display -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.send-otp') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email ID</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter Email Address" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="captcha" class="form-label">Captcha Validation</label>
                    <div class="captcha-container">
                        <div class="captcha-box">{{ $captcha_question }}</div>
                        <input type="number" id="captcha" name="captcha" class="form-input" placeholder="Answer" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Generate OTP</button>
            </form>

            <div class="form-footer">
                <a href="#register" class="footer-link">New Register</a>
                <a href="#forgot" class="footer-link">Forgot Password?</a>
            </div>
        </div>
    </main>
</body>

</html>
