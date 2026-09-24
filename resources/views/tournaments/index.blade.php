<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tournaments - UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <!-- Modern typography from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            --primary-hover: #15b300ff;
            --text-color: #e7f711ff;
            --border-color: rgba(255, 255, 255, 0.15);
            --card-bg: rgba(0, 0, 0, 0.78);
            --transition-speed: 0.3s;
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
            overflow-x: hidden;
            color: #ffffff;
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
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            padding: 0.25rem 0;
            position: relative;
        }

        .nav-dropdown-toggle::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-color);
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

        .nav-dropdown-item:hover, .nav-dropdown-item.active {
            background: rgba(230, 0, 0, 0.18);
            color: var(--text-color);
        }

        /* Quick League Access Bar */
        .quick-league-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
            padding: 1rem 1.4rem;
            background: rgba(20, 20, 20, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            backdrop-filter: blur(8px);
        }

        .quick-league-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .quick-league-label {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--text-color);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .quick-league-btn {
            text-decoration: none;
            padding: 0.55rem 1.2rem;
            border-radius: 50px;
            font-size: 0.88rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            color: #ffffff;
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.25) 0%, rgba(255, 255, 255, 0.05) 100%);
            border: 1px solid rgba(230, 0, 0, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.25s ease;
        }

        .quick-league-btn:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff3333 100%);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(230, 0, 0, 0.4);
            color: #ffffff;
        }

        .btn-view-details {
            width: 100%;
            text-decoration: none;
            background: linear-gradient(135deg, var(--primary-color) 0%, #b80000 100%);
            color: #ffffff;
            padding: 0.68rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            margin-top: 0.85rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.3);
        }

        .btn-view-details:hover {
            background: linear-gradient(135deg, #ff1a1a 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(230, 0, 0, 0.5);
            color: #ffffff;
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
            transition: background-color var(--transition-speed), transform var(--transition-speed);
            border: none;
            cursor: pointer;
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

        /* Tournaments Area */
        .main-content {
            flex: 1;
            padding: 3rem 2rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            z-index: 5;
        }

        .tournaments-container {
            width: 100%;
            max-width: 1200px;
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .tournaments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            gap: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1.5rem;
        }

        .section-heading {
            color: #ffffff;
            font-weight: 900;
            font-size: 2.2rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .section-heading span {
            color: var(--primary-color);
        }

        .add-tournament-btn {
            background: var(--primary-color);
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-speed);
            box-shadow: 0 6px 16px rgba(230, 0, 0, 0.35);
        }

        .add-tournament-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        /* Tournaments Grid */
        .tournaments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
        }

        .tournament-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .tournament-card:hover {
            transform: translateY(-8px);
            border-color: rgba(255, 215, 0, 0.5);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), 0 0 25px rgba(255, 215, 0, 0.15);
        }

        .trophy-circle {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            border: 3px solid rgba(255, 215, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4), 0 0 15px rgba(255, 215, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .tournament-card:hover .trophy-circle {
            transform: scale(1.08);
            border-color: #ffd700;
        }

        .trophy-svg {
            width: 55px;
            height: 55px;
        }

        .tournament-name {
            font-size: 1.35rem;
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            margin: 0 0 0.4rem 0;
            letter-spacing: 0.04em;
        }

        .tournament-edition {
            color: var(--text-color);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.85rem;
        }

        .tournament-desc {
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
            margin-bottom: 1.25rem;
            flex: 1;
        }

        .tournament-meta {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 1.25rem;
            width: 100%;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.75rem;
            background: rgba(255, 152, 0, 0.2);
            color: #ffb74d;
            border: 1px solid #ff9800;
        }

        .status-badge.Ongoing {
            background: rgba(21, 179, 0, 0.2);
            color: #15b300;
            border-color: #15b300;
        }

        .status-badge.Completed {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .admin-actions {
            display: flex;
            gap: 0.6rem;
            width: 100%;
            margin-top: 0.5rem;
        }

        .btn-edit-tourn {
            flex: 1;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-color);
            color: #ffffff;
            padding: 0.5rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-edit-tourn:hover {
            background: rgba(231, 247, 17, 0.15);
            border-color: var(--text-color);
            color: var(--text-color);
        }

        .btn-delete-tourn {
            flex: 1;
            background: rgba(230, 0, 0, 0.15);
            border: 1px solid rgba(230, 0, 0, 0.4);
            color: #ff6666;
            padding: 0.5rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-delete-tourn:hover {
            background: var(--primary-color);
            color: #ffffff;
        }

        /* Alerts */
        .alert {
            padding: 0.9rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            font-weight: 600;
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
            max-height: 90vh;
            overflow-y: auto;
            padding: 2.5rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0;
        }

        .modal-close-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #ffffff;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
            letter-spacing: 0.05em;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            font-family: inherit;
            font-size: 0.95rem;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .form-select option {
            background: #222;
        }

        .modal-submit-btn {
            width: 100%;
            padding: 0.9rem;
            border: none;
            border-radius: 12px;
            background: var(--primary-color);
            color: #ffffff;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.2s;
        }

        .modal-submit-btn:hover {
            background: var(--primary-hover);
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
            <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad - Return to Home">
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
                    <a href="{{ route('tournaments.index') }}" class="nav-dropdown-item active">
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="tournaments-container">
            <div class="tournaments-header">
                <div>
                    <h2 class="section-heading">USV <span>TOURNAMENTS</span></h2>
                    <div style="color: rgba(255,255,255,0.6); font-size: 0.9rem; margin-top: 0.35rem;">
                        Official championships & trophy series of United Seniors Vellanad
                    </div>
                </div>
                
                @if($isAdmin ?? false)
                    <button type="button" class="add-tournament-btn" onclick="openAddTournModal()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                        </svg>
                        Add Tournament Details
                    </button>
                @endif
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                        <div>&bull; {{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Quick League Access Buttons Bar -->
            <div class="quick-league-bar">
                <div class="quick-league-group">
                    <span class="quick-league-label">Enter League Details:</span>
                    <a href="{{ route('tournaments.show', 1) }}" class="quick-league-btn">
                        <span>👑</span> Premier League
                    </a>
                    <a href="{{ route('tournaments.show', 2) }}" class="quick-league-btn">
                        <span>🏆</span> Champions League
                    </a>
                    <a href="{{ route('tournaments.show', 3) }}" class="quick-league-btn">
                        <span>🌟</span> Discovery League
                    </a>
                </div>
                <span style="font-size: 0.82rem; color: #888888;">Select a tournament to view Teams, Fixtures, Points & More</span>
            </div>

            <!-- Tournaments List -->
            <div class="tournaments-grid">
                @forelse($tournaments as $tournament)
                    <div class="tournament-card">
                        <span class="status-badge {{ $tournament->status }}">{{ $tournament->status }}</span>
                        <div class="trophy-circle">
                            <svg class="trophy-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 5h-2V3H7v2H5C3.9 5 3 5.9 3 7v3c0 2.2 1.8 4 4 4h1.09c.72 1.96 2.43 3.44 4.54 3.86V21H9v2h6v-2h-3.63v-3.14c2.11-.42 3.82-1.9 4.54-3.86H17c2.2 0 4-1.8 4-4V7c0-1.1-.9-2-2-2zM5 10V7h2v3H5zm14 0h-2V7h2v3z" fill="url(#gold-grad-{{ $tournament->id }})"/>
                                <defs>
                                    <linearGradient id="gold-grad-{{ $tournament->id }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#ffe066" />
                                        <stop offset="50%" stop-color="#f5b041" />
                                        <stop offset="100%" stop-color="#b7950b" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>

                        <a href="{{ route('tournaments.show', $tournament->id) }}" style="text-decoration: none; color: inherit;">
                            <h3 class="tournament-name">{{ $tournament->name }}</h3>
                        </a>
                        <div class="tournament-edition">{{ $tournament->edition ?? 'Championship' }}</div>
                        <p class="tournament-desc">{{ $tournament->description ?? 'Official senior cricket tournament.' }}</p>

                        <div class="tournament-meta">
                            @if($tournament->venue)
                                <div>📍 Venue: <strong style="color: #fff;">{{ $tournament->venue }}</strong></div>
                            @endif
                            @if($tournament->start_date)
                                <div>📅 Start Date: <strong style="color: #fff;">{{ $tournament->start_date->format('d M, Y') }}</strong></div>
                            @endif
                        </div>

                        <!-- Enter Tournament Details Button -->
                        <a href="{{ route('tournaments.show', $tournament->id) }}" class="btn-view-details">
                            <span>Enter Tournament Details</span>
                            <span>&rarr;</span>
                        </a>

                        @if($isAdmin ?? false)
                            <div class="admin-actions">
                                <button type="button" class="btn-edit-tourn"
                                    data-id="{{ $tournament->id }}"
                                    data-name="{{ $tournament->name }}"
                                    data-edition="{{ $tournament->edition ?? '' }}"
                                    data-venue="{{ $tournament->venue ?? '' }}"
                                    data-date="{{ $tournament->start_date ? $tournament->start_date->format('Y-m-d') : '' }}"
                                    data-desc="{{ $tournament->description ?? '' }}"
                                    data-status="{{ $tournament->status }}"
                                    onclick="handleEditTournClick(this)">
                                    Edit
                                </button>
                                <form action="{{ route('tournaments.destroy', $tournament->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tournament?');" style="flex: 1; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-tourn" style="width: 100%;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: rgba(255,255,255,0.5);">
                        No tournaments added yet.
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    @if($isAdmin ?? false)
    <!-- ADD TOURNAMENT MODAL -->
    <div class="modal-overlay" id="addTournModal" onclick="closeOnBackdrop(event, this)">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Add Tournament Details</h3>
                <button type="button" class="modal-close-btn" onclick="closeAddTournModal()">&times;</button>
            </div>

            <form action="{{ route('tournaments.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tournament Name *</label>
                    <input type="text" name="name" class="form-input" placeholder="e.g. USV Premier Cup" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Edition / Season</label>
                    <input type="text" name="edition" class="form-input" placeholder="e.g. Season 2026">
                </div>

                <div class="form-group">
                    <label class="form-label">Venue</label>
                    <input type="text" name="venue" class="form-input" placeholder="e.g. Vellanad Central Ground">
                </div>

                <div class="form-group">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Upcoming" selected>Upcoming</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" rows="3" placeholder="Tournament summary, format, and match details..."></textarea>
                </div>

                <button type="submit" class="modal-submit-btn">Save Tournament</button>
            </form>
        </div>
    </div>

    <!-- EDIT TOURNAMENT MODAL -->
    <div class="modal-overlay" id="editTournModal" onclick="closeOnBackdrop(event, this)">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Edit Tournament Details</h3>
                <button type="button" class="modal-close-btn" onclick="closeEditTournModal()">&times;</button>
            </div>

            <form id="editTournForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Tournament Name *</label>
                    <input type="text" id="edit_t_name" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Edition / Season</label>
                    <input type="text" id="edit_t_edition" name="edition" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Venue</label>
                    <input type="text" id="edit_t_venue" name="venue" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Start Date</label>
                    <input type="date" id="edit_t_date" name="start_date" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="edit_t_status" name="status" class="form-select" required>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea id="edit_t_desc" name="description" class="form-textarea" rows="3"></textarea>
                </div>

                <button type="submit" class="modal-submit-btn">Update Tournament</button>
            </form>
        </div>
    </div>
    @endif

    <script>
        function openAddTournModal() {
            document.getElementById('addTournModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeAddTournModal() {
            document.getElementById('addTournModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function handleEditTournClick(btn) {
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            const edition = btn.getAttribute('data-edition');
            const venue = btn.getAttribute('data-venue');
            const date = btn.getAttribute('data-date');
            const desc = btn.getAttribute('data-desc');
            const status = btn.getAttribute('data-status');
            openEditTournModal(id, name, edition, venue, date, desc, status);
        }

        function openEditTournModal(id, name, edition, venue, date, desc, status) {
            document.getElementById('editTournForm').action = "{{ url('/tournaments') }}/" + id;
            document.getElementById('edit_t_name').value = name;
            document.getElementById('edit_t_edition').value = edition;
            document.getElementById('edit_t_venue').value = venue;
            document.getElementById('edit_t_date').value = date;
            document.getElementById('edit_t_desc').value = desc;
            document.getElementById('edit_t_status').value = status;

            document.getElementById('editTournModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeEditTournModal() {
            document.getElementById('editTournModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function closeOnBackdrop(event, modal) {
            if (event.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    </script>
</body>
</html>
