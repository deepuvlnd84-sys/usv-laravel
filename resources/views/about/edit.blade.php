<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Club About Details - UNITED SENIORS VELLANAD</title>
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
            --card-bg: rgba(14, 14, 14, 0.92);
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

        /* Stadium background */
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
            transition: transform var(--transition-speed) ease;
        }

        .logo:hover .logo-img {
            transform: translateY(-2px) scale(1.08);
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

        .nav-link:hover {
            color: var(--primary-color);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .auth-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-role-badge {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff5555;
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
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* Form Container */
        .main-content {
            flex: 1;
            padding: 2.5rem 1.5rem 4rem;
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
            z-index: 5;
        }

        .edit-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7), 0 0 30px rgba(230, 0, 0, 0.15);
        }

        .card-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1.25rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .edit-title-wrap h2 {
            margin: 0 0 0.3rem 0;
            font-size: 1.8rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
        }

        .edit-title-wrap p {
            margin: 0;
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .quick-nav-links {
            display: flex;
            gap: 0.75rem;
        }

        .btn-ghost-nav {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: all 0.2s ease;
        }

        .btn-ghost-nav:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: #ffffff;
            transform: translateY(-1px);
        }

        /* Form Layout */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .form-label .required-mark {
            color: #ff4d4d;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.85rem 1.1rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            font-size: 0.95rem;
            font-family: inherit;
            transition: border-color var(--transition-speed), background-color var(--transition-speed);
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.13);
            box-shadow: 0 0 12px rgba(230, 0, 0, 0.35);
        }

        .form-textarea {
            resize: vertical;
            min-height: 160px;
            line-height: 1.6;
        }

        .form-help {
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 0.35rem;
        }

        .form-section-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 1.5rem 0 2rem 0;
        }

        .section-subheading {
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
            margin: 0 0 1.25rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Submit Button */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-color) 0%, #b80000 100%);
            color: #ffffff;
            border: none;
            padding: 0.9rem 2.5rem;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(230, 0, 0, 0.4);
            transition: all var(--transition-speed) ease;
            font-family: inherit;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #15b300 0%, #0e7d00 100%);
            box-shadow: 0 10px 28px rgba(21, 179, 0, 0.5);
            transform: translateY(-2px);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(21, 179, 0, 0.18);
            border: 1px solid #15b300ff;
            color: #2eff1b;
        }

        .alert-danger {
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff5555;
        }

        .error-list {
            margin: 0;
            padding-left: 1.2rem;
        }

        @media (max-width: 768px) {
            .header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }

            .edit-card {
                padding: 1.8rem;
            }

            .card-top-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-save {
                width: 100%;
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
            <a href="{{ route('dashboard') }}" class="nav-link">DASHBOARD</a>
            <a href="{{ route('players.index') }}" class="nav-link">PLAYERS</a>
            <a href="{{ route('tournaments.index') }}" class="nav-link">TOURNAMENTS</a>
            <a href="{{ route('contact') }}" class="nav-link">CONTACT</a>
        </nav>
        <div class="auth-menu">
            <span class="user-role-badge">🛡️ ADMIN</span>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">LOG OUT</button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="edit-card">
            <div class="card-top-bar">
                <div class="edit-title-wrap">
                    <h2>Edit Club Description &amp; Info</h2>
                    <p>Updates made here will immediately reflect on the public About page.</p>
                </div>
                <div class="quick-nav-links">
                    <a href="{{ route('about') }}" target="_blank" class="btn-ghost-nav" title="View Public Page">
                        <span>👁️ View Public Page</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14 3h7v7h-2V6.41l-9.29 9.3-1.42-1.42 9.3-9.29H14V3zM5 5h6V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-6h-2v6H5V5z"/>
                        </svg>
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn-ghost-nav">
                        <span>&larr; Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅</span>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <span>⚠️</span>
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('about.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Basic Identification -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Club Name / Title <span class="required-mark">*</span>
                        </label>
                        <input type="text" id="title" name="title" class="form-input" value="{{ old('title', $about->title) }}" required placeholder="e.g. UNITED SENIORS VELLANAD">
                        <span class="form-help">Displayed prominently at the top of the About page.</span>
                    </div>

                    <div class="form-group">
                        <label for="tagline" class="form-label">Club Tagline / Motto</label>
                        <input type="text" id="tagline" name="tagline" class="form-input" value="{{ old('tagline', $about->tagline) }}" placeholder="e.g. Passion, Brotherhood & Cricket Spirit">
                        <span class="form-help">Subtitle phrase beneath the club name.</span>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="established_year" class="form-label">Established Year</label>
                        <input type="text" id="established_year" name="established_year" class="form-input" value="{{ old('established_year', $about->established_year) }}" placeholder="e.g. 2018">
                    </div>

                    <div class="form-group">
                        <label for="home_ground" class="form-label">Home Ground / Location</label>
                        <input type="text" id="home_ground" name="home_ground" class="form-input" value="{{ old('home_ground', $about->home_ground) }}" placeholder="e.g. Vellanad Ground, Thiruvananthapuram">
                    </div>
                </div>

                <!-- Main Club Description -->
                <div class="form-group">
                    <label for="description" class="form-label">
                        Club Description / Story <span class="required-mark">*</span>
                    </label>
                    <textarea id="description" name="description" class="form-textarea" style="min-height: 220px;" required placeholder="Write a detailed description of the club, history, team spirit, and activities...">{{ old('description', $about->description) }}</textarea>
                    <span class="form-help">Paragraphs and line breaks entered here will be preserved on the public page.</span>
                </div>

                <div class="form-section-divider"></div>

                <!-- Mission & Vision -->
                <h3 class="section-subheading">🎯 Mission & Vision</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="mission" class="form-label">Our Mission</label>
                        <textarea id="mission" name="mission" class="form-textarea" style="min-height: 120px;" placeholder="Describe what the club aims to accomplish...">{{ old('mission', $about->mission) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="vision" class="form-label">Our Vision</label>
                        <textarea id="vision" name="vision" class="form-textarea" style="min-height: 120px;" placeholder="Describe the future aspiration of the club...">{{ old('vision', $about->vision) }}</textarea>
                    </div>
                </div>

                <div class="form-section-divider"></div>

                <!-- Contact & Inquiries -->
                <h3 class="section-subheading">📞 Contact & Inquiries</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" class="form-input" value="{{ old('contact_email', $about->contact_email) }}" placeholder="e.g. deepuvlnd84@gmail.com">
                    </div>

                    <div class="form-group">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="text" id="contact_phone" name="contact_phone" class="form-input" value="{{ old('contact_phone', $about->contact_phone) }}" placeholder="e.g. +91 94470 00000">
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="form-actions">
                    <a href="{{ route('about') }}" target="_blank" class="btn-ghost-nav" style="padding: 0.85rem 1.5rem; font-size: 0.9rem;">Preview Page</a>
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
