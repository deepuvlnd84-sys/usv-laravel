<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Player - UNITED SENIORS VELLANAD</title>
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
            --card-bg: rgba(255, 255, 255, 0.08);
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
        }

        .signin-btn:hover {
            background-color: #15b300ff;
            transform: translateY(-1px);
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
            max-width: 480px;
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

        /* Alert styling */
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .alert-success {
            background-color: rgba(21, 179, 0, 0.2);
            border: 1px solid #15b300ff;
            color: #15b300ff;
            text-align: center;
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
        @include('partials.nav_controls')
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
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="signin-btn" style="border: none; cursor: pointer; font-family: inherit;">LOG OUT</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="signin-btn">SIGN IN</a>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="form-card">
            <h2 class="form-title">Add New Player</h2>

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

            <form action="{{ route('players.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Player Name</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Enter player name" required value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="jersey_number" class="form-label">Jersey Number</label>
                    <input type="number" id="jersey_number" name="jersey_number" class="form-input" placeholder="Enter jersey number" required value="{{ old('jersey_number') }}">
                </div>

                <div class="form-group">
                    <label for="position" class="form-label">Position / Role</label>
                    <input type="text" id="position" name="position" class="form-input" placeholder="e.g. Batsman, Bowler, All-rounder" required value="{{ old('position') }}">
                </div>

                <button type="submit" class="submit-btn">Add Player</button>
            </form>
        </div>
    </main>
</body>

</html>
