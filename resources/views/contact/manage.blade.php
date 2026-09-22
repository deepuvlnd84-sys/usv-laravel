<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Contact Directory - UNITED SENIORS VELLANAD</title>
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
            background-color: #0d0d0d;
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
            opacity: 0.38;
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

        /* Main Content Container */
        .main-content {
            flex: 1;
            padding: 2.5rem 1.5rem 5rem;
            max-width: 1150px;
            width: 100%;
            margin: 0 auto;
            z-index: 5;
        }

        .manage-header-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.2rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
        }

        .header-title-wrap h1 {
            font-size: 1.8rem;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0 0 0.3rem 0;
            letter-spacing: 0.04em;
        }

        .header-title-wrap p {
            margin: 0;
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .quick-nav-btns {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-quick-nav {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            text-decoration: none;
            padding: 0.55rem 1.1rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: all 0.2s ease;
        }

        .btn-quick-nav:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: #ffffff;
            transform: translateY(-1px);
        }

        /* Section Cards */
        .section-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6);
        }

        .section-title-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-heading {
            font-size: 1.4rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: #ffffff;
        }

        .section-heading span {
            color: var(--primary-color);
        }

        /* Form Grid */
        .grid-2-col {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .leader-edit-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 1.8rem;
        }

        .leader-box-title {
            font-size: 1.15rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-color);
            margin: 0 0 1.4rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            color: #ffffff;
            font-size: 0.82rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.45rem;
        }

        .form-label .req {
            color: #ff4d4d;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            font-size: 0.95rem;
            font-family: inherit;
            transition: border-color var(--transition-speed);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.12);
        }

        .current-photo-preview {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.5rem;
            background: rgba(0, 0, 0, 0.4);
            padding: 0.5rem 0.8rem;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .preview-thumb {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .btn-save-leaders {
            background: linear-gradient(135deg, var(--primary-color), #b80000);
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
            margin-top: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-save-leaders:hover {
            background: linear-gradient(135deg, #15b300, #0e7d00);
            box-shadow: 0 10px 28px rgba(21, 179, 0, 0.5);
            transform: translateY(-2px);
        }

        /* Members Table */
        .members-table-wrap {
            overflow-x: auto;
        }

        .members-table {
            width: 100%;
            border-collapse: collapse;
            color: #ffffff;
        }

        .members-table th,
        .members-table td {
            padding: 1rem 0.85rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.92rem;
            vertical-align: middle;
        }

        .members-table th {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.06em;
            color: var(--text-color);
            background: rgba(255, 255, 255, 0.02);
        }

        .member-photo-cell {
            width: 50px;
        }

        .table-member-img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            background: #252525;
            display: block;
            border: 2px solid rgba(255, 255, 255, 0.15);
        }

        .table-avatar-placeholder {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #252525;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            border: 2px solid rgba(255, 255, 255, 0.15);
        }

        .action-cell {
            text-align: right;
            white-space: nowrap;
        }

        .btn-action-edit {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 0.4rem 0.85rem;
            border-radius: 6px;
            font-weight: 800;
            font-size: 0.78rem;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            margin-right: 0.35rem;
        }

        .btn-action-edit:hover {
            background: #ffffff;
            color: #000000;
        }

        .btn-action-delete {
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff4d4d;
            padding: 0.4rem 0.85rem;
            border-radius: 6px;
            font-weight: 800;
            font-size: 0.78rem;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action-delete:hover {
            background: var(--primary-color);
            color: #ffffff;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s, visibility 0.25s;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-card {
            background: #181818;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            width: 100%;
            max-width: 520px;
            padding: 2.5rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-title {
            font-size: 1.4rem;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0;
            color: #ffffff;
        }

        .modal-close-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-modal-submit {
            width: 100%;
            padding: 0.9rem;
            border: none;
            border-radius: 50px;
            background: var(--primary-color);
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            cursor: pointer;
            font-family: inherit;
            margin-top: 0.5rem;
            transition: background 0.2s;
        }

        .btn-modal-submit:hover {
            background: var(--primary-hover);
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

            .section-card {
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
        <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad">
            <img src="{{ asset('usv-logo.png') }}" alt="USV Logo" class="logo-img">
            <span class="logo-text">USV</span>
        </a>
        <nav class="nav-menu">
            <a href="{{ url('/') }}" class="nav-link">HOME</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>
            <a href="{{ route('dashboard') }}" class="nav-link">DASHBOARD</a>
            <a href="{{ route('players.index') }}" class="nav-link">PLAYERS</a>
            <a href="{{ route('tournaments.index') }}" class="nav-link">TOURNAMENTS</a>
            <a href="{{ route('contact') }}" class="nav-link active">CONTACT</a>
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

        <!-- Top Header Card -->
        <div class="manage-header-card">
            <div class="header-title-wrap">
                <h1>Manage Contact Directory</h1>
                <p>Edit President &amp; Coordinator details, manage committee roster (10+ members), and configure social media links.</p>
            </div>
            <div class="quick-nav-btns">
                <a href="{{ route('contact') }}" target="_blank" class="btn-quick-nav">
                    <span>👁️ View Public Page</span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 3h7v7h-2V6.41l-9.29 9.3-1.42-1.42 9.3-9.29H14V3zM5 5h6V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-6h-2v6H5V5z"/>
                    </svg>
                </a>
                <a href="{{ route('dashboard') }}" class="btn-quick-nav">
                    <span>&larr; Dashboard</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <span>✅</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <span>⚠️</span>
                <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Section 1: Leadership & Social Media Links Form -->
        <section class="section-card">
            <div class="section-title-bar">
                <h2 class="section-heading">👑 Club Leadership <span>&amp; Social Links</span></h2>
            </div>

            <form action="{{ route('contact.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid-2-col">
                    <!-- President Settings -->
                    <div class="leader-edit-box">
                        <h3 class="leader-box-title">President Details</h3>
                        <div class="form-group">
                            <label for="president_name" class="form-label">Full Name <span class="req">*</span></label>
                            <input type="text" id="president_name" name="president_name" class="form-input" value="{{ old('president_name', $settings->president_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="president_role" class="form-label">Role / Designation</label>
                            <input type="text" id="president_role" name="president_role" class="form-input" value="{{ old('president_role', $settings->president_role) }}" placeholder="e.g. Club President">
                        </div>
                        <div class="form-group">
                            <label for="president_phone" class="form-label">Mobile Number <span class="req">*</span></label>
                            <input type="text" id="president_phone" name="president_phone" class="form-input" value="{{ old('president_phone', $settings->president_phone) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="president_email" class="form-label">Email Address</label>
                            <input type="email" id="president_email" name="president_email" class="form-input" value="{{ old('president_email', $settings->president_email) }}">
                        </div>
                        <div class="form-group">
                            <label for="president_photo" class="form-label">Photo (Upload to change)</label>
                            <input type="file" id="president_photo" name="president_photo" class="form-input" accept="image/*">
                            @if($settings->president_photo && file_exists(public_path('uploads/contacts/' . $settings->president_photo)))
                                <div class="current-photo-preview">
                                    <img src="{{ asset('uploads/contacts/' . $settings->president_photo) }}" alt="President Photo" class="preview-thumb">
                                    <span style="font-size: 0.78rem; color: rgba(255,255,255,0.7);">Current President photo uploaded</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Coordinator Settings -->
                    <div class="leader-edit-box">
                        <h3 class="leader-box-title">Coordinator Details</h3>
                        <div class="form-group">
                            <label for="coordinator_name" class="form-label">Full Name <span class="req">*</span></label>
                            <input type="text" id="coordinator_name" name="coordinator_name" class="form-input" value="{{ old('coordinator_name', $settings->coordinator_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="coordinator_role" class="form-label">Role / Designation</label>
                            <input type="text" id="coordinator_role" name="coordinator_role" class="form-input" value="{{ old('coordinator_role', $settings->coordinator_role) }}" placeholder="e.g. General Coordinator">
                        </div>
                        <div class="form-group">
                            <label for="coordinator_phone" class="form-label">Mobile Number <span class="req">*</span></label>
                            <input type="text" id="coordinator_phone" name="coordinator_phone" class="form-input" value="{{ old('coordinator_phone', $settings->coordinator_phone) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="coordinator_email" class="form-label">Email Address</label>
                            <input type="email" id="coordinator_email" name="coordinator_email" class="form-input" value="{{ old('coordinator_email', $settings->coordinator_email) }}">
                        </div>
                        <div class="form-group">
                            <label for="coordinator_photo" class="form-label">Photo (Upload to change)</label>
                            <input type="file" id="coordinator_photo" name="coordinator_photo" class="form-input" accept="image/*">
                            @if($settings->coordinator_photo && file_exists(public_path('uploads/contacts/' . $settings->coordinator_photo)))
                                <div class="current-photo-preview">
                                    <img src="{{ asset('uploads/contacts/' . $settings->coordinator_photo) }}" alt="Coordinator Photo" class="preview-thumb">
                                    <span style="font-size: 0.78rem; color: rgba(255,255,255,0.7);">Current Coordinator photo uploaded</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem;">
                    <h3 class="leader-box-title" style="border: none; padding: 0; margin-bottom: 1rem;">🌐 Social Media Links</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label for="facebook_url" class="form-label">Facebook Page URL</label>
                            <input type="text" id="facebook_url" name="facebook_url" class="form-input" value="{{ old('facebook_url', $settings->facebook_url) }}" placeholder="https://facebook.com/yourclub">
                        </div>
                        <div class="form-group">
                            <label for="instagram_url" class="form-label">Instagram Profile URL</label>
                            <input type="text" id="instagram_url" name="instagram_url" class="form-input" value="{{ old('instagram_url', $settings->instagram_url) }}" placeholder="https://instagram.com/yourclub">
                        </div>
                        <div class="form-group">
                            <label for="youtube_url" class="form-label">YouTube Channel URL</label>
                            <input type="text" id="youtube_url" name="youtube_url" class="form-input" value="{{ old('youtube_url', $settings->youtube_url) }}" placeholder="https://youtube.com/@yourclub">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-save-leaders">
                    <span>💾 Save Leadership &amp; Social Links</span>
                </button>
            </form>
        </section>

        <!-- Section 2: Committee Members Grid Management -->
        <section class="section-card">
            <div class="section-title-bar">
                <h2 class="section-heading">👥 Committee Members <span>Directory</span> ({{ $persons->count() }})</h2>
                <button type="button" class="btn-quick-nav" style="background: var(--primary-color); border: none;" onclick="openAddMemberModal()">
                    <span>➕ Add New Member</span>
                </button>
            </div>

            <div class="members-table-wrap">
                <table class="members-table">
                    <thead>
                        <tr>
                            <th class="member-photo-cell">Photo</th>
                            <th>Name</th>
                            <th>Designation / Role</th>
                            <th>Mobile Number</th>
                            <th>Order</th>
                            <th class="action-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($persons as $person)
                            <tr>
                                <td class="member-photo-cell">
                                    @if($person->photo && file_exists(public_path('uploads/contacts/' . $person->photo)))
                                        <img src="{{ asset('uploads/contacts/' . $person->photo) }}" alt="{{ $person->name }}" class="table-member-img">
                                    @else
                                        <div class="table-avatar-placeholder">👤</div>
                                    @endif
                                </td>
                                <td style="font-weight: 800; font-size: 1rem;">{{ $person->name }}</td>
                                <td>
                                    <span style="color: var(--text-color); font-weight: 700;">{{ $person->designation }}</span>
                                </td>
                                <td>
                                    <a href="tel:{{ $person->phone }}" style="color: #ffffff; text-decoration: none;">{{ $person->phone }}</a>
                                </td>
                                <td>{{ $person->order }}</td>
                                <td class="action-cell">
                                    <button type="button" class="btn-action-edit"
                                        data-id="{{ $person->id }}"
                                        data-name="{{ $person->name }}"
                                        data-designation="{{ $person->designation }}"
                                        data-phone="{{ $person->phone }}"
                                        data-order="{{ $person->order }}"
                                        onclick="handleEditMemberClick(this)">
                                        Edit
                                    </button>
                                    <form action="{{ route('contact.persons.destroy', $person->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove {{ $person->name }} from contacts?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2.5rem; color: rgba(255,255,255,0.6);">
                                    No members found. Click "Add New Member" above to add one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal: Add New Member -->
    <div class="modal-overlay" id="addMemberModal" onclick="handleAddModalBackdrop(event)">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Add Committee Member</h3>
                <button type="button" class="modal-close-btn" onclick="closeAddMemberModal()">&times;</button>
            </div>
            <form action="{{ route('contact.persons.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="add_name" class="form-label">Full Name <span class="req">*</span></label>
                    <input type="text" id="add_name" name="name" class="form-input" required placeholder="e.g. Bipin Das">
                </div>
                <div class="form-group">
                    <label for="add_designation" class="form-label">Designation / Role <span class="req">*</span></label>
                    <input type="text" id="add_designation" name="designation" class="form-input" required placeholder="e.g. Treasurer, Vice Captain">
                </div>
                <div class="form-group">
                    <label for="add_phone" class="form-label">Mobile Number <span class="req">*</span></label>
                    <input type="text" id="add_phone" name="phone" class="form-input" required placeholder="e.g. +91 98471 23456">
                </div>
                <div class="form-group">
                    <label for="add_photo" class="form-label">Photo (Optional)</label>
                    <input type="file" id="add_photo" name="photo" class="form-input" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="add_order" class="form-label">Display Order</label>
                    <input type="number" id="add_order" name="order" class="form-input" placeholder="e.g. 11">
                </div>
                <button type="submit" class="btn-modal-submit">Add to Directory</button>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Existing Member -->
    <div class="modal-overlay" id="editMemberModal" onclick="handleEditModalBackdrop(event)">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Edit Committee Member</h3>
                <button type="button" class="modal-close-btn" onclick="closeEditMemberModal()">&times;</button>
            </div>
            <form id="editMemberForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_name" class="form-label">Full Name <span class="req">*</span></label>
                    <input type="text" id="edit_name" name="name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="edit_designation" class="form-label">Designation / Role <span class="req">*</span></label>
                    <input type="text" id="edit_designation" name="designation" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="edit_phone" class="form-label">Mobile Number <span class="req">*</span></label>
                    <input type="text" id="edit_phone" name="phone" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="edit_photo" class="form-label">Update Photo (Optional)</label>
                    <input type="file" id="edit_photo" name="photo" class="form-input" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="edit_order" class="form-label">Display Order</label>
                    <input type="number" id="edit_order" name="order" class="form-input">
                </div>
                <button type="submit" class="btn-modal-submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Add Modal
        function openAddMemberModal() {
            document.getElementById('addMemberModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeAddMemberModal() {
            document.getElementById('addMemberModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function handleAddModalBackdrop(event) {
            if (event.target === document.getElementById('addMemberModal')) {
                closeAddMemberModal();
            }
        }

        // Edit Modal
        function handleEditMemberClick(btn) {
            const person = {
                id: btn.getAttribute('data-id'),
                name: btn.getAttribute('data-name'),
                designation: btn.getAttribute('data-designation'),
                phone: btn.getAttribute('data-phone'),
                order: btn.getAttribute('data-order')
            };
            openEditMemberModal(person);
        }

        function openEditMemberModal(person) {
            const form = document.getElementById('editMemberForm');
            form.action = "{{ url('/contact/persons') }}/" + person.id;
            document.getElementById('edit_name').value = person.name;
            document.getElementById('edit_designation').value = person.designation;
            document.getElementById('edit_phone').value = person.phone;
            document.getElementById('edit_order').value = person.order || 0;

            document.getElementById('editMemberModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeEditMemberModal() {
            document.getElementById('editMemberModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function handleEditModalBackdrop(event) {
            if (event.target === document.getElementById('editMemberModal')) {
                closeEditMemberModal();
            }
        }
    </script>
</body>

</html>
