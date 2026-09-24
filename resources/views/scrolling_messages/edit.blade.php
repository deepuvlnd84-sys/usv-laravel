<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Ticker Messages - UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <!-- Modern typography from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            --text-color: #e7f711ff;
            --bg-dark: #121212;
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

        /* Container Area */
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
            max-width: 900px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .form-title {
            color: #ffffff;
            font-weight: 800;
            font-size: 2.2rem;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 2.5rem;
            letter-spacing: 0.05em;
        }

        /* Split layout container */
        .manage-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 3rem;
        }

        .form-section-title {
            color: var(--text-color);
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-top: 0;
            margin-bottom: 1.5rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
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

        .form-textarea {
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
            resize: vertical;
            min-height: 100px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.15);
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
        }

        .submit-btn:hover {
            background-color: #15b300ff;
            transform: translateY(-2px);
        }

        /* Existing messages table */
        .message-table {
            width: 100%;
            border-collapse: collapse;
            color: #ffffff;
        }

        .message-table th,
        .message-table td {
            padding: 0.85rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .message-table th {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            color: var(--text-color);
        }

        .message-text-cell {
            max-width: 280px;
            word-wrap: break-word;
            white-space: normal;
        }

        /* Buttons & Badges */
        .status-badge {
            padding: 0.25rem 0.6rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-block;
        }

        .status-badge.active {
            background-color: rgba(21, 179, 0, 0.2);
            border: 1px solid #15b300ff;
            color: #15b300ff;
        }

        .status-badge.inactive {
            background-color: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff4d4d;
        }

        .action-btn {
            border: none;
            padding: 0.4rem 0.75rem;
            border-radius: 5px;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
            letter-spacing: 0.05em;
        }

        .toggle-btn.activate {
            background-color: #15b300ff;
            color: #ffffff;
        }

        .toggle-btn.activate:hover {
            background-color: #129000ff;
        }

        .toggle-btn.deactivate {
            background-color: #ff9900;
            color: #ffffff;
        }

        .toggle-btn.deactivate:hover {
            background-color: #cc7a00;
        }

        .delete-btn {
            background-color: var(--primary-color);
            color: #ffffff;
            margin-left: 0.25rem;
        }

        .delete-btn:hover {
            background-color: #b30000;
        }

        /* Alert styling */
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            text-align: center;
        }

        .alert-success {
            background-color: rgba(21, 179, 0, 0.2);
            border: 1px solid #15b300ff;
            color: #15b300ff;
        }

        .alert-danger {
            background-color: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff4d4d;
        }

        .error-list {
            margin: 0;
            padding-left: 1.2rem;
            text-align: left;
        }

        .no-messages {
            text-align: center;
            opacity: 0.6;
            padding: 2rem 0;
            font-style: italic;
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
            @if(Session::has('authenticated_user'))
            <a href="{{ route('dashboard') }}" class="nav-link">DASHBOARD</a>
            @endif
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
                        <path d="M7 10l5 5 5-5z" />
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
            <h2 class="form-title">Ticker Settings</h2>

            <!-- Success Alert -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="manage-container">
                <!-- Add Message Form Section -->
                <div>
                    <h3 class="form-section-title">New Ticker Message</h3>
                    <form action="{{ route('scrolling-messages.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="message" class="form-label">Message Content</label>
                            <textarea id="message" name="message" class="form-textarea" placeholder="Enter scrolling message text here..." required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="submit-btn">Add Message</button>
                    </form>
                </div>

                <!-- Existing Messages List Section -->
                <div>
                    <h3 class="form-section-title">Current Messages</h3>
                    @if($messages->isEmpty())
                    <div class="no-messages">No ticker messages found. Add one on the left!</div>
                    @else
                    <div style="overflow-x: auto;">
                        <table class="message-table">
                            <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($messages as $msg)
                                <tr>
                                    <td class="message-text-cell">{{ $msg->message }}</td>
                                    <td>
                                        @if($msg->is_active)
                                        <span class="status-badge active">Active</span>
                                    </td>
                                    @else
                                    <span class="status-badge inactive">Inactive</span>
                                    </td>
                                    @endif
                                    <td style="text-align: right; white-space: nowrap;">
                                        <form action="{{ route('scrolling-messages.toggle', $msg->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn toggle-btn {{ $msg->is_active ? 'deactivate' : 'activate' }}">
                                                {{ $msg->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('scrolling-messages.destroy', $msg->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</body>

</html>