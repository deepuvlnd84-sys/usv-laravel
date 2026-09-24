<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Player Registration - UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000;
            --primary-hover: #c40000;
            --secondary-green: #22c55e;
            --secondary-green-dark: #15803d;
            --dark-card: rgba(18, 22, 28, 0.94);
            --border-color: rgba(255, 255, 255, 0.12);
            --border-focus: #22c55e;
            --text-color: #f1f5f9;
            --text-muted: #94a3b8;
            --transition: all 0.25s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #0b0f17;
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        /* Stadium Blurred Background Layer */
        .bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('stadium.jpg') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.35;
            filter: blur(4px);
            z-index: -1;
            transform: scale(1.05);
        }

        /* Navigation Bar */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 2.5rem;
            position: relative;
            z-index: 20;
            background: rgba(10, 15, 24, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logo {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            gap: 2px;
        }

        .logo-img {
            width: 46px;
            height: auto;
            max-height: 44px;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.4));
            transition: transform 0.3s ease;
        }

        .logo:hover .logo-img {
            transform: scale(1.08);
        }

        .logo-text {
            font-size: 1.05rem;
            font-weight: 900;
            color: var(--primary-color);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            line-height: 1;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .nav-link {
            text-decoration: none;
            background: linear-gradient(135deg, #0b4d26 0%, #063c1e 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 0.55rem 1.15rem;
            border-radius: 50px;
            border: 1.5px solid rgba(34, 197, 94, 0.45);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: var(--transition);
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, #15803d 0%, #0b532b 100%);
            border-color: #22c55e;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(34, 197, 94, 0.4);
        }

        .auth-actions {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .btn-home {
            text-decoration: none;
            color: #cbd5e1;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }

        .btn-home:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
        }

        /* Main Registration Container */
        .registration-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 2.5rem 1.5rem 4rem;
            position: relative;
            z-index: 10;
        }

        .form-card {
            background: var(--dark-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            width: 100%;
            max-width: 920px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 40px rgba(230, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Banner Header inside card */
        .card-header-banner {
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.9) 0%, rgba(11, 77, 38, 0.9) 100%);
            padding: 2.2rem 2.5rem 1.8rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            position: relative;
        }

        .card-header-banner::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #e60000, #22c55e, #e7f711);
        }

        .badge-club {
            display: inline-block;
            background: rgba(0, 0, 0, 0.35);
            color: #fef08a;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.35rem 0.9rem;
            border-radius: 50px;
            border: 1px solid rgba(254, 240, 138, 0.3);
            margin-bottom: 0.75rem;
        }

        .card-title {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
        }

        .card-subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.95rem;
            margin-top: 0.4rem;
            font-weight: 400;
        }

        .card-body {
            padding: 2.5rem;
        }

        /* Alerts */
        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1.5px solid #22c55e;
            color: #86efac;
            padding: 1.2rem 1.5rem;
            border-radius: 14px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.98rem;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.15);
        }

        .alert-success .check-icon {
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .alert-errors {
            background: rgba(230, 0, 0, 0.15);
            border: 1.5px solid #e60000;
            color: #fca5a5;
            padding: 1.2rem 1.5rem;
            border-radius: 14px;
            margin-bottom: 2rem;
            font-size: 0.92rem;
        }

        .alert-errors ul {
            margin-left: 1.2rem;
            margin-top: 0.4rem;
        }

        /* TOP PHOTO UPLOAD SECTION */
        .photo-upload-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.15);
        }

        .photo-preview-container {
            position: relative;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            border: 3px dashed rgba(34, 197, 94, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            transition: var(--transition);
        }

        .photo-preview-container:hover {
            border-color: #22c55e;
            transform: scale(1.03);
            box-shadow: 0 10px 30px rgba(34, 197, 94, 0.3);
        }

        .photo-preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .photo-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 0.78rem;
            text-align: center;
            padding: 0.5rem;
            pointer-events: none;
        }

        .photo-placeholder svg {
            width: 36px;
            height: 36px;
            fill: rgba(34, 197, 94, 0.7);
            margin-bottom: 0.35rem;
        }

        .photo-upload-btn-wrap {
            margin-top: 1rem;
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .btn-upload-label {
            background: linear-gradient(135deg, #0b4d26, #15803d);
            color: #fff;
            padding: 0.45rem 1.1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            cursor: pointer;
            border: 1px solid rgba(34, 197, 94, 0.5);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-upload-label:hover {
            background: #22c55e;
            color: #0b0f17;
            transform: translateY(-1px);
        }

        .btn-clear-photo {
            background: rgba(230, 0, 0, 0.15);
            color: #f87171;
            border: 1px solid rgba(230, 0, 0, 0.3);
            border-radius: 50px;
            padding: 0.45rem 0.9rem;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            display: none;
            transition: var(--transition);
        }

        .btn-clear-photo:hover {
            background: #e60000;
            color: #fff;
        }

        .photo-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.4rem;
        }

        /* SECTIONS STYLING */
        .form-section {
            margin-bottom: 2.5rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding-bottom: 0.8rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.08);
        }

        .section-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--primary-color);
            color: #fff;
            font-weight: 900;
            font-size: 0.95rem;
            box-shadow: 0 4px 10px rgba(230, 0, 0, 0.4);
        }

        .section-number.green {
            background: var(--secondary-green-dark);
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.4);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
        }

        .section-desc {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-left: auto;
            font-style: italic;
        }

        /* GRID & INPUT FIELDS */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.3rem 1.5rem;
        }

        .form-grid.single-column {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 0.88rem;
            font-weight: 700;
            color: #e2e8f0;
            letter-spacing: 0.02em;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .required-star {
            color: #ef4444;
            font-weight: 900;
        }

        .form-control,
        .form-select {
            background: rgba(15, 23, 42, 0.7);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: #ffffff;
            font-family: inherit;
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            outline: none;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #22c55e;
            background: rgba(15, 23, 42, 0.95);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
        }

        .form-control::placeholder {
            color: #64748b;
        }

        .form-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2394a3b8'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.3rem;
            padding-right: 2.5rem;
        }

        .form-select option {
            background: #0f172a;
            color: #ffffff;
            padding: 0.5rem;
        }

        textarea.form-control {
            min-height: 90px;
            resize: vertical;
            line-height: 1.5;
        }

        /* Dynamic Role Details Container */
        .role-conditional-card {
            background: rgba(34, 197, 94, 0.04);
            border: 1px dashed rgba(34, 197, 94, 0.35);
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 1rem;
            grid-column: 1 / -1;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .role-conditional-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #4ade80;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Bottom Submit Actions */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-submit {
            background: linear-gradient(135deg, #e60000 0%, #b91c1c 100%);
            color: #ffffff;
            font-family: inherit;
            font-weight: 800;
            font-size: 1.05rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.85rem 2.5rem;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(230, 0, 0, 0.45);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #15803d 0%, #0b532b 100%);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.5);
            transform: translateY(-2px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-secondary {
            text-decoration: none;
            color: #94a3b8;
            font-size: 0.92rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: var(--transition);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
        }

        .btn-secondary:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1.2rem;
            }

            .form-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .btn-submit {
                justify-content: center;
                width: 100%;
            }

            .btn-secondary {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Background layer -->
    <div class="bg-layer"></div>

    <!-- Navigation Header -->
    <header class="header">
        <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad">
            <img src="{{ asset('usv-logo.png') }}" alt="USV Logo" class="logo-img">
            <span class="logo-text">USV</span>
        </a>

        <nav class="nav-menu">
            <a href="{{ url('/') }}" class="nav-link">HOME</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>
            <a href="{{ route('players.index') }}" class="nav-link">PLAYERS</a>
            <a href="{{ route('tournaments.index') }}" class="nav-link">TOURNAMENTS</a>
            <a href="{{ route('gallery') }}" class="nav-link">GALLERY</a>
            <a href="{{ route('register.create') }}" class="nav-link active">REGISTER</a>
            <a href="{{ route('contact') }}" class="nav-link">CONTACT</a>
        </nav>

        <div class="auth-actions">
            <a href="{{ url('/') }}" class="btn-home">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                Back to Home
            </a>
        </div>
    </header>

    <!-- Main Registration Container -->
    <main class="registration-wrapper">
        <div class="form-card">
            <!-- Top Banner -->
            <div class="card-header-banner">
                <span class="badge-club">🏏 United Seniors Vellanad</span>
                <h1 class="card-title">Official Player Registration</h1>
                <p class="card-subtitle">Join the prestigious USV cricket fraternity &bull; Enter your basic & player details below</p>
            </div>

            <div class="card-body">
                <!-- Success Alert -->
                @if(session('success'))
                    <div class="alert-success">
                        <span class="check-icon">🎉</span>
                        <div>
                            <strong>{{ session('success') }}</strong>
                            <p style="margin-top: 0.35rem; font-size: 0.88rem; color: #bbf7d0;">
                                Your registration details have been securely recorded into the club roster. You will be contacted for upcoming tournament trials and practice sessions.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Validation Errors Alert -->
                @if($errors->any())
                    <div class="alert-errors">
                        <strong>Please correct the following errors before submitting:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Registration Form -->
                <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" id="playerRegisterForm">
                    @csrf

                    <!-- TOP PHOTO OPTION -->
                    <div class="photo-upload-section">
                        <label class="form-label" style="margin-bottom: 0.75rem; font-size: 0.95rem;">
                            <span>📷 Player Photo</span>
                            <span style="font-weight: 400; color: #94a3b8; font-size: 0.82rem;">(Recommended for club ID card & profile)</span>
                        </label>

                        <div class="photo-preview-container" id="photoPreviewContainer" onclick="document.getElementById('photoInput').click()">
                            <img src="" alt="Player Photo Preview" id="photoPreviewImg" class="photo-preview-img">
                            <div class="photo-placeholder" id="photoPlaceholder">
                                <svg viewBox="0 0 24 24">
                                    <path d="M4 4h3l2-2h6l2 2h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm8 3a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
                                </svg>
                                <span>Upload Photo</span>
                            </div>
                        </div>

                        <!-- Hidden File Input -->
                        <input type="file" name="photo" id="photoInput" accept="image/*" style="display: none;" onchange="handlePhotoSelect(this)">

                        <div class="photo-upload-btn-wrap">
                            <label for="photoInput" class="btn-upload-label">
                                <span>Choose Image</span>
                            </label>
                            <button type="button" class="btn-clear-photo" id="btnClearPhoto" onclick="clearSelectedPhoto()">Remove</button>
                        </div>
                        <p class="photo-hint">Max file size: 5MB &bull; JPG, PNG, WEBP formats supported</p>
                    </div>

                    <!-- ============================================== -->
                    <!-- SECTION 1: BASIC DETAILS                       -->
                    <!-- ============================================== -->
                    <div class="form-section">
                        <div class="section-header">
                            <span class="section-number">1</span>
                            <div>
                                <h2 class="section-title">Basic Details</h2>
                            </div>
                            <span class="section-desc">Personal & Contact Info</span>
                        </div>

                        <div class="form-grid">
                            <!-- Full Name -->
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Full Name <span class="required-star">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" value="{{ old('name') }}" required>
                            </div>

                            <!-- Mobile Number -->
                            <div class="form-group">
                                <label for="mobile_no" class="form-label">
                                    Mobile Number <span class="required-star">*</span>
                                </label>
                                <input type="tel" name="mobile_no" id="mobile_no" class="form-control" placeholder="e.g. +91 9876543210" value="{{ old('mobile_no') }}" required>
                            </div>

                            <!-- Date of Birth -->
                            <div class="form-group">
                                <label for="dob" class="form-label">
                                    Date of Birth
                                </label>
                                <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}" onchange="calculateAgeFromDob(this.value)">
                            </div>

                            <!-- Age -->
                            <div class="form-group">
                                <label for="age" class="form-label">
                                    Age (Years)
                                </label>
                                <input type="number" name="age" id="age" class="form-control" placeholder="Age in years" min="5" max="100" value="{{ old('age') }}">
                            </div>

                            <!-- Blood Group -->
                            <div class="form-group">
                                <label for="blood_group" class="form-label">
                                    Blood Group
                                </label>
                                <select name="blood_group" id="blood_group" class="form-select">
                                    <option value="">-- Select Blood Group --</option>
                                    @php
                                        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                                    @endphp
                                    @foreach($bloodGroups as $bg)
                                        <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Education Qualification -->
                            <div class="form-group">
                                <label for="education_qualification" class="form-label">
                                    Educational Qualification
                                </label>
                                <input type="text" name="education_qualification" id="education_qualification" class="form-control" placeholder="e.g. Plus Two, Degree, B.Tech, MBA" value="{{ old('education_qualification') }}">
                            </div>

                            <!-- Job / Profession -->
                            <div class="form-group">
                                <label for="job" class="form-label">
                                    Job / Occupation
                                </label>
                                <input type="text" name="job" id="job" class="form-control" placeholder="e.g. Software Engineer, Teacher, Business, Student" value="{{ old('job') }}">
                            </div>

                            <!-- Address -->
                            <div class="form-group full-width">
                                <label for="address" class="form-label">
                                    Address
                                </label>
                                <textarea name="address" id="address" class="form-control" rows="2" placeholder="Residential house name/no, street, place, pin code">{{ old('address') }}</textarea>
                            </div>

                            <!-- Remarks / Some Abouts -->
                            <div class="form-group full-width">
                                <label for="remarks" class="form-label">
                                    Remarks / About Yourself
                                </label>
                                <textarea name="remarks" id="remarks" class="form-control" rows="2" placeholder="Type some abouts, personal summary, hobbies, or additional notes...">{{ old('remarks') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- SECTION 2: PLAYER DETAILS                      -->
                    <!-- ============================================== -->
                    <div class="form-section">
                        <div class="section-header">
                            <span class="section-number green">2</span>
                            <div>
                                <h2 class="section-title">Player Details</h2>
                            </div>
                            <span class="section-desc">Cricket Role, Styles & Experience</span>
                        </div>

                        <div class="form-grid">
                            <!-- Playing Role Dropdown -->
                            <div class="form-group full-width">
                                <label for="playing_role" class="form-label">
                                    Playing Role <span class="required-star">*</span>
                                </label>
                                <select name="playing_role" id="playing_role" class="form-select" required onchange="handleRoleChange(this.value)">
                                    <option value="">-- Choose Playing Role --</option>
                                    <option value="Batsman" {{ old('playing_role') == 'Batsman' ? 'selected' : '' }}>🏏 Batsman</option>
                                    <option value="Bowler" {{ old('playing_role') == 'Bowler' ? 'selected' : '' }}>⚡ Bowler</option>
                                    <option value="Allrounder" {{ old('playing_role') == 'Allrounder' ? 'selected' : '' }}>🌟 Allrounder</option>
                                    <option value="Wicket Keeper Batsman" {{ old('playing_role') == 'Wicket Keeper Batsman' ? 'selected' : '' }}>🧤 Wicket Keeper Batsman</option>
                                </select>
                            </div>

                            <!-- Role Dependent Section: Dynamic Sub-options -->
                            <div class="role-conditional-card" id="roleConditionalCard">
                                <div class="role-conditional-title" id="roleConditionalTitle">
                                    <span>⚙️ Role Specific Techniques & Styles</span>
                                </div>

                                <div class="form-grid" id="roleConditionalFields">
                                    <!-- Batting Style Field (Batsman, Allrounder, WK Batsman) -->
                                    <div class="form-group" id="grp_batting_style">
                                        <label for="batting_style" class="form-label">Batting Style</label>
                                        <select name="batting_style" id="batting_style" class="form-select">
                                            <option value="">-- Select Batting Style --</option>
                                            <option value="Right Hand" {{ old('batting_style') == 'Right Hand' ? 'selected' : '' }}>Right Hand Batsman</option>
                                            <option value="Left Hand" {{ old('batting_style') == 'Left Hand' ? 'selected' : '' }}>Left Hand Batsman</option>
                                        </select>
                                    </div>

                                    <!-- Bowling Arm Field (Bowler, Allrounder) -->
                                    <div class="form-group" id="grp_bowling_arm">
                                        <label for="bowling_arm" class="form-label">Bowling Arm</label>
                                        <select name="bowling_arm" id="bowling_arm" class="form-select">
                                            <option value="">-- Select Bowling Arm --</option>
                                            <option value="Right Arm" {{ old('bowling_arm') == 'Right Arm' ? 'selected' : '' }}>Right Arm</option>
                                            <option value="Left Arm" {{ old('bowling_arm') == 'Left Arm' ? 'selected' : '' }}>Left Arm</option>
                                        </select>
                                    </div>

                                    <!-- Bowling Pace / Type Field (Bowler, Allrounder) -->
                                    <div class="form-group" id="grp_bowling_pace">
                                        <label for="bowling_pace" class="form-label">Bowling Pace / Type</label>
                                        <select name="bowling_pace" id="bowling_pace" class="form-select">
                                            <option value="">-- Select Bowling Pace --</option>
                                            <option value="Pace" {{ old('bowling_pace') == 'Pace' ? 'selected' : '' }}>Pace / Fast</option>
                                            <option value="Medium" {{ old('bowling_pace') == 'Medium' ? 'selected' : '' }}>Medium Pace</option>
                                            <option value="Slow" {{ old('bowling_pace') == 'Slow' ? 'selected' : '' }}>Slow / Spin</option>
                                        </select>
                                    </div>

                                    <!-- Wicket Keeping Field (WK Batsman) -->
                                    <div class="form-group" id="grp_wicket_keeping_style">
                                        <label for="wicket_keeping_style" class="form-label">Wicket Keeping Details</label>
                                        <select name="wicket_keeping_style" id="wicket_keeping_style" class="form-select">
                                            <option value="Primary Wicket Keeper" {{ old('wicket_keeping_style') == 'Primary Wicket Keeper' ? 'selected' : '' }}>Regular / Primary Wicket Keeper</option>
                                            <option value="Part-time Wicket Keeper" {{ old('wicket_keeping_style') == 'Part-time Wicket Keeper' ? 'selected' : '' }}>Part-time Wicket Keeper</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Basic Cricket Details -->
                            <div class="form-group">
                                <label for="batting_position" class="form-label">
                                    Preferred Batting Order
                                </label>
                                <select name="batting_position" id="batting_position" class="form-select">
                                    <option value="">-- Select Preferred Order --</option>
                                    <option value="Opening" {{ old('batting_position') == 'Opening' ? 'selected' : '' }}>Opening Batsman (1-2)</option>
                                    <option value="Top Order" {{ old('batting_position') == 'Top Order' ? 'selected' : '' }}>Top Order (3-4)</option>
                                    <option value="Middle Order" {{ old('batting_position') == 'Middle Order' ? 'selected' : '' }}>Middle Order (5-6)</option>
                                    <option value="Finisher / Lower Order" {{ old('batting_position') == 'Finisher / Lower Order' ? 'selected' : '' }}>Finisher / Lower Order (7-11)</option>
                                </select>
                            </div>

                            <!-- Preferred Jersey Number -->
                            <div class="form-group">
                                <label for="jersey_number" class="form-label">
                                    Preferred Jersey No.
                                </label>
                                <input type="text" name="jersey_number" id="jersey_number" class="form-control" placeholder="e.g. 7, 10, 18, 45" maxlength="5" value="{{ old('jersey_number') }}">
                            </div>

                            <!-- Previous Clubs / Teams -->
                            <div class="form-group">
                                <label for="previous_clubs" class="form-label">
                                    Previous Clubs / Teams Played For
                                </label>
                                <input type="text" name="previous_clubs" id="previous_clubs" class="form-control" placeholder="e.g. College Team, Local Cricket Club" value="{{ old('previous_clubs') }}">
                            </div>

                            <!-- Cricket Experience -->
                            <div class="form-group">
                                <label for="cricket_experience" class="form-label">
                                    Cricket Experience
                                </label>
                                <input type="text" name="cricket_experience" id="cricket_experience" class="form-control" placeholder="e.g. 5 Years, District Level, League Matches" value="{{ old('cricket_experience') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Form Action Buttons -->
                    <div class="form-actions">
                        <a href="{{ url('/') }}" class="btn-secondary">
                            &larr; Cancel & Return Home
                        </a>
                        <button type="submit" class="btn-submit">
                            <span>Register Player</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- JavaScript for Photo Preview, DOB age sync, and Role dynamic dropdowns -->
    <script>
        // Photo preview handler
        function handlePhotoSelect(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 5 * 1024 * 1024) {
                    alert("Photo size exceeds 5MB limit. Please upload a smaller image.");
                    input.value = "";
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('photoPreviewImg');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    document.getElementById('photoPlaceholder').style.display = 'none';
                    document.getElementById('btnClearPhoto').style.display = 'inline-block';
                }
                reader.readAsDataURL(file);
            }
        }

        function clearSelectedPhoto() {
            const input = document.getElementById('photoInput');
            input.value = '';
            const img = document.getElementById('photoPreviewImg');
            img.src = '';
            img.style.display = 'none';
            document.getElementById('photoPlaceholder').style.display = 'flex';
            document.getElementById('btnClearPhoto').style.display = 'none';
        }

        // Auto calculate age from Date of Birth
        function calculateAgeFromDob(dobString) {
            if (!dobString) return;
            const dob = new Date(dobString);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            if (age >= 0 && age <= 100) {
                document.getElementById('age').value = age;
            }
        }

        // Dynamic Role-dependent dropdown options
        function handleRoleChange(role) {
            const card = document.getElementById('roleConditionalCard');
            const grpBatting = document.getElementById('grp_batting_style');
            const grpBowlingArm = document.getElementById('grp_bowling_arm');
            const grpBowlingPace = document.getElementById('grp_bowling_pace');
            const grpWk = document.getElementById('grp_wicket_keeping_style');
            const title = document.getElementById('roleConditionalTitle');

            // Hide all by default
            grpBatting.style.display = 'none';
            grpBowlingArm.style.display = 'none';
            grpBowlingPace.style.display = 'none';
            grpWk.style.display = 'none';

            if (!role) {
                card.style.display = 'none';
                return;
            }

            card.style.display = 'block';

            if (role === 'Batsman') {
                title.innerHTML = '<span>🏏 Batsman Technique</span>';
                grpBatting.style.display = 'flex';
            } else if (role === 'Bowler') {
                title.innerHTML = '<span>⚡ Bowler Arsenal & Pace</span>';
                grpBowlingArm.style.display = 'flex';
                grpBowlingPace.style.display = 'flex';
            } else if (role === 'Allrounder') {
                title.innerHTML = '<span>🌟 Allrounder Skillset (Batting & Bowling)</span>';
                grpBatting.style.display = 'flex';
                grpBowlingArm.style.display = 'flex';
                grpBowlingPace.style.display = 'flex';
            } else if (role === 'Wicket Keeper Batsman') {
                title.innerHTML = '<span>🧤 Wicket Keeper Batsman Proficiency</span>';
                grpBatting.style.display = 'flex';
                grpWk.style.display = 'flex';
            }
        }

        // Initialize state on page load (e.g. if old inputs exist)
        document.addEventListener('DOMContentLoaded', function() {
            const currentRole = document.getElementById('playing_role').value;
            if (currentRole) {
                handleRoleChange(currentRole);
            }
        });
    </script>
</body>

</html>
