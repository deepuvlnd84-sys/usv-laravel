<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <!-- Modern typography from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            --text-color: #e7f711ff;
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
            padding-bottom: 70px; /* Space for fixed bottom bar */
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

        /* Top Navigation Bar with Light Glassmorphism Matching Background */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
            max-height: 44px;
            object-fit: contain;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.2));
            transition: transform var(--transition-speed, 0.3s) ease, filter var(--transition-speed, 0.3s) ease;
        }

        .logo:hover .logo-img {
            transform: translateY(-2px) scale(1.08);
            filter: drop-shadow(0 4px 10px rgba(230, 0, 0, 0.45));
        }

        .logo-text {
            font-size: 1.1rem;
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
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .nav-link,
        .nav-dropdown-toggle {
            text-decoration: none;
            background: linear-gradient(135deg, #0b4d26 0%, #063c1e 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 0.6rem 1.25rem;
            border-radius: 50px;
            border: 1.5px solid rgba(34, 197, 94, 0.45);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15), inset 0 1px 1px rgba(255, 255, 255, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: all var(--transition-speed) ease;
            cursor: pointer;
            line-height: 1;
        }

        .nav-link:hover,
        .nav-dropdown-wrap:hover .nav-dropdown-toggle,
        .nav-dropdown-wrap:focus-within .nav-dropdown-toggle {
            background: linear-gradient(135deg, #15803d 0%, #0b532b 100%);
            border-color: #22c55e;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.35);
        }

        /* Nav Dropdown for Tournaments */
        .nav-dropdown-wrap {
            position: relative;
            display: inline-block;
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
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 14px;
            padding: 0.6rem;
            min-width: 230px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
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
            color: #1f2937;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 700;
            border-radius: 8px;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .nav-dropdown-item:hover {
            background: rgba(230, 0, 0, 0.1);
            color: var(--primary-color);
        }

        /* Sign In Button upper right */
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
            transition: background-color var(--transition-speed), transform var(--transition-speed);
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.3);
        }

        .signin-btn:hover {
            background-color: #15b300ff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(21, 179, 0, 0.4);
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
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            padding: 0.6rem;
            min-width: 250px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
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
            background: rgba(230, 0, 0, 0.08);
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
            color: #111827;
            font-weight: 800;
            font-size: 0.88rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .dropdown-item .item-desc {
            color: #6b7280;
            font-size: 0.72rem;
            margin-top: 0.15rem;
        }

        .dropdown-item:hover .item-title {
            color: var(--primary-color);
        }

        .dropdown-divider {
            height: 1px;
            background: rgba(0, 0, 0, 0.08);
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
            background: rgba(230, 0, 0, 0.15);
            border: 1px solid var(--primary-color);
            color: #dc2626;
        }

        .player-badge {
            background: rgba(22, 163, 74, 0.15);
            border: 1px solid #16a34a;
            color: #15803d;
        }

        /* Top Ticker Bar if active messages exist */
        .scrolling-ticker {
            background-color: var(--primary-color);
            color: #ffffff;
            overflow: hidden;
            white-space: nowrap;
            box-sizing: border-box;
            padding: 0.5rem 0;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            z-index: 101;
            position: relative;
            text-transform: uppercase;
        }

        .ticker-wrap {
            display: inline-block;
            padding-left: 100%;
            animation: ticker 30s linear infinite;
        }

        .ticker-wrap:hover {
            animation-play-state: paused;
        }

        @keyframes ticker {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }

        .ticker-item {
            display: inline-block;
            padding-right: 2rem;
            font-family: 'Outfit', sans-serif;
            color: #ffffff;
        }

        .ticker-separator {
            color: var(--text-color);
            margin: 0 1.5rem;
            font-size: 1.1rem;
        }

        /* ======================================================== */
        /* HOME PAGE 3-COLUMN HERO LAYOUT */
        /* ======================================================== */
        .home-sections-container {
            width: 100%;
            margin: 1.75rem 0 2.5rem 0;
            padding: 0; /* Fully flush to both edges */
            box-sizing: border-box;
            z-index: 10;
            position: relative;
        }

        /* Alert notifications */
        .home-alert {
            margin: 0 1.5rem 1.25rem 1.5rem;
            padding: 0.85rem 1.25rem;
            border-radius: 12px;
            font-size: 0.92rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .alert-success-custom {
            background: rgba(22, 101, 52, 0.92);
            border: 1px solid #22c55e;
            color: #ffffff;
        }

        .alert-danger-custom {
            background: rgba(153, 27, 27, 0.92);
            border: 1px solid #ef4444;
            color: #ffffff;
        }

        .hero-sections-3col {
            display: grid;
            grid-template-columns: minmax(320px, 400px) 1fr minmax(320px, 420px);
            gap: 1.25rem;
            align-items: flex-start;
        }

        /* LEFT SIDE COLUMN (Flushed against left edge) */
        .hero-col-left {
            margin-left: 0;
            padding-left: 0;
        }

        /* RIGHT SIDE COLUMN (Flushed against right edge) */
        .hero-col-right {
            margin-right: 0;
            padding-right: 0;
        }

        .hero-col-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 0.5rem;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .home-sections-container {
                padding: 0 1rem;
                margin-top: 1.25rem;
            }

            .hero-sections-3col {
                grid-template-columns: 1fr;
                gap: 1.75rem;
            }

            .hero-col-center {
                order: -1;
                padding: 0.5rem 0;
            }
        }

        /* ======================================================== */
        /* LIGHT COLOR STYLE FOR LEFT & RIGHT TABLES (MATCHING BACKGROUND) */
        /* ======================================================== */
        
        /* LEFT SIDE TABLE BOX */
        .section-card-box-light {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 0 22px 22px 0; /* Rounded on right, flat flush on left screen edge */
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12), inset 0 1px 1px rgba(255, 255, 255, 0.8);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .section-card-box-light:hover {
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
        }

        /* RIGHT SIDE TABLE BOX */
        .section-card-box-light-right {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 22px 0 0 22px; /* Flat flush on right screen edge, rounded on left */
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12), inset 0 1px 1px rgba(255, 255, 255, 0.8);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .section-card-box-light-right:hover {
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
        }

        /* Static Header (No Scrolling, Clean Title) */
        .static-header-container {
            background: linear-gradient(135deg, #e60000 0%, #b91c1c 100%);
            color: #ffffff;
            padding: 0.95rem 1.25rem;
            font-size: 1.15rem;
            font-weight: 900;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            box-shadow: 0 3px 10px rgba(230, 0, 0, 0.25);
        }

        .static-header-icon {
            font-size: 1.3rem;
            line-height: 1;
        }

        .section-top-bar-light {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.25rem;
            background: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .section-sub-title-light {
            color: #4b5563;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* Section List (No internal scrollbar) */
        .section-body-list-no-scroll {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        /* Light Cards for Important Messages & Fixtures */
        .msg-item-card-light {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            padding: 1.15rem;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
        }

        .msg-item-card-light:hover {
            background: #ffffff;
            border-color: rgba(230, 0, 0, 0.3);
            transform: translateX(4px);
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
        }

        .msg-item-top-light {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.6rem;
        }

        .msg-badge-light {
            font-size: 0.68rem;
            font-weight: 900;
            padding: 0.2rem 0.65rem;
            border-radius: 50px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .badge-URGENT {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
            border: 1px solid #ef4444;
        }

        .badge-NOTICE {
            background: rgba(59, 130, 246, 0.15);
            color: #2563eb;
            border: 1px solid #3b82f6;
        }

        .badge-UPDATE {
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
            border: 1px solid #f59e0b;
        }

        .badge-ANNOUNCEMENT {
            background: rgba(34, 197, 94, 0.15);
            color: #16a34a;
            border: 1px solid #22c55e;
        }

        .msg-date-light {
            color: #6b7280;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .msg-item-title-light {
            color: #111827;
            font-size: 1.05rem;
            font-weight: 800;
            margin: 0 0 0.45rem 0;
            line-height: 1.3;
        }

        .msg-item-body-light {
            color: #374151;
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0;
        }

        .item-admin-actions-light {
            display: flex;
            gap: 0.4rem;
            margin-top: 0.85rem;
            justify-content: flex-end;
            border-top: 1px dashed rgba(0, 0, 0, 0.08);
            padding-top: 0.6rem;
        }

        .admin-btn-light {
            background: #475569;
            color: #ffffff;
            border: none;
            font-weight: 800;
            font-size: 0.78rem;
            padding: 0.45rem 0.95rem;
            border-radius: 50px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .admin-btn-light:hover {
            background: var(--primary-color);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .admin-btn-light.btn-edit-sm {
            background: #0284c7;
        }

        .admin-btn-light.btn-edit-sm:hover {
            background: #0369a1;
        }

        .admin-btn-light.btn-delete-sm {
            background: #dc2626;
        }

        .admin-btn-light.btn-delete-sm:hover {
            background: #b91c1c;
        }

        .empty-placeholder-light {
            text-align: center;
            padding: 2.5rem 1.5rem;
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Light Fixture Cards - Poster Style */
        .fixture-card-light {
            background: rgba(255, 255, 255, 0.95);
            border: 1.5px solid rgba(230, 0, 0, 0.15);
            border-radius: 14px;
            padding: 0.75rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
        }

        .fixture-card-light:hover {
            background: #ffffff;
            border-color: rgba(230, 0, 0, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .day-date-badge {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 900;
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            box-shadow: 0 3px 8px rgba(22, 163, 74, 0.3);
        }

        .match-time-banner {
            background: rgba(230, 0, 0, 0.08);
            border: 1px solid rgba(230, 0, 0, 0.2);
            color: #dc2626;
            font-size: 0.82rem;
            font-weight: 900;
            padding: 0.45rem;
            border-radius: 8px;
            text-align: center;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .fixture-versus-row {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 0.6rem;
            text-align: center;
            padding: 0.2rem 0;
        }

        .team-box {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .team-title-light {
            color: #111827;
            font-weight: 900;
            font-size: 0.95rem;
            line-height: 1.2;
            letter-spacing: 0.02em;
        }

        .team-score-light {
            color: #15803d;
            font-size: 0.82rem;
            font-weight: 800;
            margin-top: 0.2rem;
            background: rgba(22, 163, 74, 0.1);
            padding: 0.15rem 0.5rem;
            border-radius: 6px;
        }

        .vs-badge-light {
            background: rgba(230, 0, 0, 0.12);
            border: 1px solid #dc2626;
            color: #dc2626;
            font-size: 0.75rem;
            font-weight: 900;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Bottom Bar inside Fixtures Box for Full Fixtures Button */
        .section-bottom-bar-light {
            padding: 0.85rem 1.25rem;
            background: rgba(0, 0, 0, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .full-fixtures-pdf-btn-light {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #e60000 0%, #b91c1c 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: 0.85rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 0.65rem 1.4rem;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(230, 0, 0, 0.35);
            border: none;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .full-fixtures-pdf-btn-light:hover {
            background: linear-gradient(135deg, #15b300 0%, #0d8000 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(21, 179, 0, 0.4);
            color: #ffffff;
        }

        /* CENTER HERO SECTION */
        .text-container {
            text-align: center;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero-emblem-wrap {
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-emblem-img {
            width: clamp(120px, 15vw, 180px);
            height: auto;
            max-width: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.4));
            transition: transform 0.4s ease, filter 0.4s ease;
        }

        .hero-emblem-img:hover {
            transform: scale(1.06) translateY(-4px);
            filter: drop-shadow(0 16px 32px rgba(230, 0, 0, 0.45));
        }

        .title {
            color: var(--primary-color);
            font-weight: 900;
            font-size: clamp(2rem, 6vw, 4.5rem);
            letter-spacing: -0.02em;
            text-transform: uppercase;
            margin: 0;
            line-height: 1.1;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .hero-actions {
            margin-top: 1.5rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-hero-about {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, #b80000 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            box-shadow: 0 8px 25px rgba(230, 0, 0, 0.45);
            border: 2px solid rgba(231, 247, 17, 0.4);
            transition: all var(--transition-speed) ease;
        }

        .btn-hero-about:hover {
            transform: translateY(-3px) scale(1.03);
            background: linear-gradient(135deg, #15b300 0%, #0e7d00 100%);
            border-color: #ffffff;
            color: #ffffff;
        }

        /* ======================================================== */
        /* BOTTOM BAR WITH MATCHING LIGHT COLOR GLASS & PWA BUTTON */
        /* ======================================================== */
        .bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 95;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
            padding: 0.6rem 1.5rem;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bottom-bar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1100px;
            gap: 1rem;
        }

        .app-icon-wrap {
            position: relative;
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: 12px;
            cursor: pointer;
        }

        .app-icon-img {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            display: block;
            border: 1.5px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .app-icon-wrap:hover .app-icon-img {
            transform: scale(1.08) rotate(3deg);
        }

        .app-pulse-ring {
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border: 2px solid var(--primary-color);
            border-radius: 14px;
            animation: pulseGlow 2.5s infinite;
            pointer-events: none;
            opacity: 0.7;
        }

        @keyframes pulseGlow {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }

        .app-info {
            flex: 1;
            min-width: 0;
            cursor: pointer;
        }

        .app-title-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.1rem;
        }

        .app-title-light {
            color: #111827;
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .app-tag-light {
            background: rgba(230, 0, 0, 0.1);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            font-size: 0.65rem;
            font-weight: 800;
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            letter-spacing: 0.05em;
        }

        .app-desc-light {
            color: #4b5563;
            font-size: 0.78rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-install-app {
            background: linear-gradient(135deg, var(--primary-color), #b80000);
            color: #ffffff;
            border: none;
            padding: 0.65rem 1.25rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.82rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(230, 0, 0, 0.3);
            font-family: inherit;
        }

        .btn-install-app:hover {
            background: linear-gradient(135deg, #15b300, #0f8a00);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(21, 179, 0, 0.4);
        }

        /* Generic Modals Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1100;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            padding: 1.5rem;
            box-sizing: border-box;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-card {
            background: rgba(18, 18, 18, 0.98);
            border: 1.5px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            max-width: 540px;
            width: 100%;
            padding: 2rem;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.9), 0 0 30px rgba(230, 0, 0, 0.2);
            position: relative;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            box-sizing: border-box;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.active .modal-card {
            transform: scale(1);
        }

        .modal-card-title {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 900;
            margin: 0 0 1.25rem 0;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0.75rem;
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.35rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 10px;
            padding: 0.65rem 0.9rem;
            color: #ffffff;
            font-size: 0.9rem;
            font-family: inherit;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.12);
        }

        .form-select option {
            background: #121212;
            color: #ffffff;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.85rem;
        }

        .form-submit-btn {
            width: 100%;
            padding: 0.85rem;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--primary-color), #b80000);
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
            margin-top: 0.5rem;
            box-shadow: 0 4px 15px rgba(230, 0, 0, 0.4);
            font-family: inherit;
        }

        .form-submit-btn:hover {
            background: linear-gradient(135deg, #15b300, #0e7d00);
            transform: translateY(-1px);
        }

        /* PWA Install Modal */
        .install-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.82);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            padding: 1.5rem;
            box-sizing: border-box;
        }

        .install-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .install-modal-card {
            background: rgba(18, 18, 18, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            max-width: 460px;
            width: 100%;
            padding: 2.2rem;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.85), 0 0 30px rgba(230, 0, 0, 0.2);
            text-align: center;
            position: relative;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            box-sizing: border-box;
        }

        .install-modal-overlay.active .install-modal-card {
            transform: scale(1);
        }

        .modal-close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: background 0.2s;
        }

        .modal-close-btn:hover {
            background: var(--primary-color);
        }

        .modal-app-badge {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(230, 0, 0, 0.4);
            margin: 0 auto 1.2rem auto;
            display: block;
            border: 2px solid rgba(231, 247, 17, 0.4);
        }

        .modal-title {
            color: #ffffff;
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0 0 0.4rem 0;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .modal-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin: 0 0 1.5rem 0;
            line-height: 1.4;
        }

        .guide-steps {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 1.2rem;
            text-align: left;
            margin-bottom: 1.5rem;
        }

        .guide-step {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.9rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.4;
        }

        .guide-step:last-child {
            margin-bottom: 0;
        }

        .step-icon {
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary-color);
            color: #ff5555;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .btn-modal-gotit {
            width: 100%;
            padding: 0.85rem;
            border: none;
            border-radius: 50px;
            background-color: var(--primary-color);
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-modal-gotit:hover {
            background-color: #15b300;
            transform: translateY(-1px);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .header {
                padding: 0.75rem 1rem;
                flex-direction: column;
                gap: 0.75rem;
            }

            .nav-menu {
                gap: 0.5rem;
                justify-content: center;
            }

            .nav-link,
            .nav-dropdown-toggle {
                font-size: 0.85rem;
                padding: 0.45rem 0.95rem;
            }

            .bottom-bar {
                padding: 0.5rem 1rem;
            }

            .app-title-light {
                font-size: 0.85rem;
            }

            .app-desc-light {
                font-size: 0.7rem;
            }

            .btn-install-app {
                padding: 0.5rem 0.9rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    @if(isset($activeMessages) && $activeMessages->count() > 0)
        <div class="scrolling-ticker">
            <div class="ticker-wrap">
                @foreach($activeMessages as $msg)
                    <span class="ticker-item">{{ $msg->message }}</span>
                    @if(!$loop->last)
                        <span class="ticker-separator">•</span>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <!-- Background Layer -->
    <div class="bg-layer"></div>

    <!-- NEW TOP BAR WITH MATCHING LIGHT GLASS STYLE HOUSING ALL TOP BUTTONS -->
    <header class="header">
        <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad - Home">
            <img src="{{ asset('usv-logo.png') }}" alt="USV Logo" class="logo-img">
            <span class="logo-text">USV</span>
        </a>
        <nav class="nav-menu">
            <a href="{{ route('members') }}" class="nav-link">MEMBERS</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>

            <!-- Tournaments Dropdown Navigation -->
            <div class="nav-dropdown-wrap">
                <a href="{{ route('tournaments.index') }}" class="nav-dropdown-toggle">
                    TOURNAMENTS
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5z" />
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
                    <div style="border-top: 1px solid rgba(0,0,0,0.08); margin: 0.35rem 0;"></div>
                    <a href="{{ route('tournaments.index') }}" class="nav-dropdown-item">
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
                        <button type="submit" class="signin-btn"
                            style="border: none; cursor: pointer; font-family: inherit;">LOG OUT</button>
                    </form>
                </div>
            @else
                <div class="signin-dropdown-wrap">
                    <button type="button" class="signin-btn dropdown-toggle">
                        SIGN IN
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"
                            style="margin-left: 4px; transition: transform 0.2s;">
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

    <!-- Main 3-Column Container -->
    <main class="home-sections-container">
        @if(session('success'))
            <div class="home-alert alert-success-custom">
                <span>✅ {{ session('success') }}</span>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="home-alert alert-danger-custom">
                <span>⚠️ {{ session('error') ?? $errors->first() }}</span>
            </div>
        @endif

        <div class="hero-sections-3col">

            <!-- LEFT SIDE: IMPORTANT MESSAGES (Flushed to left screen edge, Light Color Style, No Scrolling) -->
            <div class="hero-col hero-col-left">
                <div class="section-card-box-light">
                    <!-- Static Header Title (Only IMPORTANT MESSAGES, No Scrolling) -->
                    <div class="static-header-container">
                        <span class="static-header-icon">📢</span> IMPORTANT MESSAGES
                    </div>

                    <!-- Sub-bar with Admin controls -->
                    <div class="section-top-bar-light">
                        <span class="section-sub-title-light">
                            <span>📌</span> Latest Club Updates
                        </span>
                        @if($isAdmin)
                            <button type="button" class="admin-btn-light" onclick="openAddMsgModal()">
                                ➕ Add Message
                            </button>
                        @endif
                    </div>

                    <!-- Messages List (No internal scrollbar) -->
                    <div class="section-body-list-no-scroll">
                        @if(isset($importantMessages) && $importantMessages->count() > 0)
                            @foreach($importantMessages as $msg)
                                <div class="msg-item-card-light">
                                    <div class="msg-item-top-light">
                                        <span class="msg-badge-light badge-{{ $msg->badge }}">{{ $msg->badge }}</span>
                                        <span class="msg-date-light">{{ $msg->created_at->format('d M Y, h:i A') }}</span>
                                    </div>
                                    @if($msg->title)
                                        <h4 class="msg-item-title-light">{{ $msg->title }}</h4>
                                    @endif
                                    <p class="msg-item-body-light">{{ $msg->message }}</p>

                                    @if($isAdmin)
                                        <div class="item-admin-actions-light">
                                            <button type="button" class="admin-btn-light btn-edit-sm"
                                                onclick="openEditMsgModal({{ $msg->id }}, '{{ addslashes($msg->title) }}', '{{ addslashes($msg->message) }}', '{{ $msg->badge }}')">
                                                ✏️ Edit
                                            </button>
                                            <form action="{{ route('important-messages.destroy', $msg->id) }}" method="POST"
                                                style="margin:0;"
                                                onsubmit="return confirm('Are you sure you want to delete this important message?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn-light btn-delete-sm">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="empty-placeholder-light">
                                📢 No important messages published yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- CENTER: HERO TITLE & EMBLEM -->
            <div class="hero-col hero-col-center">
                <div class="text-container">
                    <div class="hero-emblem-wrap">
                        <img src="{{ asset('usv-logo.png') }}" alt="United Seniors Vellanad" class="hero-emblem-img">
                    </div>
                    <h1 class="title">UNITED SENIORS VELLANAD</h1>
                    <div class="hero-actions">
                        <a href="{{ route('about') }}" class="btn-hero-about">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                            </svg>
                            <span>ABOUT US</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: FIXTURES (Premier League S5 Day 4 Poster Match List) -->
            <div class="hero-col hero-col-right">
                <div class="section-card-box-light-right">
                    <!-- Static Header Title -->
                    <div class="static-header-container">
                        <span class="static-header-icon">🏏</span> PREMIER LEAGUE S5
                    </div>

                    <!-- Day & Date Sub-header Ribbon -->
                    <div class="section-top-bar-light" style="justify-content: center; flex-direction: column; gap: 0.3rem;">
                        <div style="font-weight: 900; color: #dc2626; font-size: 1.1rem; letter-spacing: 0.06em; text-transform: uppercase;">
                            ★ DAY 4 ★
                        </div>
                        <div class="day-date-badge">
                            <span>📅</span> 16-AUG-26
                        </div>

                        @if($isAdmin)
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 0.4rem;">
                                <button type="button" class="admin-btn-light" style="background: #16a34a;" onclick="openAddFixtureModal()">
                                    ➕ Add Match
                                </button>
                                <button type="button" class="admin-btn-light btn-edit-sm" onclick="openUploadPdfModal()">
                                    📄 Upload PDF
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Fixtures List (The 6 matches from the poster) -->
                    <div class="section-body-list-no-scroll" style="padding: 0.85rem; gap: 0.65rem;">
                        @if(isset($fixtures) && $fixtures->count() > 0)
                            @foreach($fixtures as $fix)
                                <div class="fixture-card-light">
                                    <div class="fixture-versus-row" style="padding: 0;">
                                        <div class="team-box">
                                            <span class="team-title-light" style="font-size: 0.92rem; font-weight: 900; color: #111827;">{{ $fix->team1 }}</span>
                                            @if($fix->team1_score)
                                                <span class="team-score-light">{{ $fix->team1_score }}</span>
                                            @endif
                                        </div>
                                        <div class="vs-badge-light" style="font-size: 0.75rem; font-weight: 900; width: 28px; height: 28px; background: rgba(230,0,0,0.12); color: #dc2626; border-color: #dc2626;">X</div>
                                        <div class="team-box">
                                            <span class="team-title-light" style="font-size: 0.92rem; font-weight: 900; color: #111827;">{{ $fix->team2 }}</span>
                                            @if($fix->team2_score)
                                                <span class="team-score-light">{{ $fix->team2_score }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($isAdmin)
                                        <div class="item-admin-actions-light" style="margin-top: 0.35rem; padding-top: 0.35rem;">
                                            <button type="button" class="admin-btn-light btn-edit-sm" style="font-size: 0.7rem; padding: 0.25rem 0.6rem;"
                                                onclick="openEditFixtureModal({{ $fix->id }}, '{{ addslashes($fix->match_no) }}', '{{ addslashes($fix->stage) }}', '{{ addslashes($fix->team1) }}', '{{ addslashes($fix->team1_short ?? '') }}', '{{ addslashes($fix->team1_score ?? '') }}', '{{ addslashes($fix->team2) }}', '{{ addslashes($fix->team2_short ?? '') }}', '{{ addslashes($fix->team2_score ?? '') }}', '{{ addslashes($fix->match_date) }}', '{{ addslashes($fix->match_time) }}', '{{ addslashes($fix->venue) }}', '{{ $fix->status }}', '{{ addslashes($fix->result ?? '') }}')">
                                                ✏️ Edit
                                            </button>
                                            <form action="{{ route('home-fixtures.destroy', $fix->id) }}" method="POST"
                                                style="margin:0;"
                                                onsubmit="return confirm('Are you sure you want to delete this match?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn-light btn-delete-sm" style="font-size: 0.7rem; padding: 0.25rem 0.6rem;">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="empty-placeholder-light">
                                🏏 No match fixtures added yet.
                            </div>
                        @endif

                        <!-- MATCH STARTS AT 7:00 AM NOTE -->
                        <div class="match-time-banner">
                            ★ MATCH STARTS AT 7:00 AM ★
                        </div>
                    </div>

                    <!-- FULL FIXTURES PDF LINK MOVED TO BOTTOM OF FIXTURES TABLE -->
                    <div class="section-bottom-bar-light">
                        @if(isset($fixtureSetting) && $fixtureSetting->pdf_filename)
                            <a href="{{ asset('uploads/fixtures/' . $fixtureSetting->pdf_filename) }}" target="_blank"
                                class="full-fixtures-pdf-btn-light" title="Download / View Full Fixtures PDF">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9.5 8.5c0 .83-.67 1.5-1.5 1.5H7v2H5.5V9H8c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V9H13c.83 0 1.5.67 1.5 1.5v3zm4-3H17v1h1.5V13H17v2h-1.5V9h3v1.5z" />
                                </svg>
                                <span>FULL FIXTURES</span>
                            </a>
                        @else
                            <a href="javascript:void(0)" onclick="handlePdfClick()" class="full-fixtures-pdf-btn-light"
                                title="View Full Fixtures PDF">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9.5 8.5c0 .83-.67 1.5-1.5 1.5H7v2H5.5V9H8c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V9H13c.83 0 1.5.67 1.5 1.5v3zm4-3H17v1h1.5V13H17v2h-1.5V9h3v1.5z" />
                                </svg>
                                <span>FULL FIXTURES</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- NEW BOTTOM BAR WITH MATCHING LIGHT COLOR GLASS HOUSING MOBILE APP BUTTON -->
    <footer class="bottom-bar">
        <div class="bottom-bar-content">
            <div class="app-icon-wrap" id="appIconTrigger" onclick="handleAppInstallClick()"
                title="Install USV Mobile App">
                <img src="{{ asset('icon-192.png') }}" alt="USV Mobile App" class="app-icon-img">
                <span class="app-pulse-ring"></span>
            </div>
            <div class="app-info" onclick="handleAppInstallClick()">
                <div class="app-title-row">
                    <span class="app-title-light">USV MOBILE APP</span>
                    <span class="app-tag-light">FREE PWA</span>
                </div>
                <div class="app-desc-light">Install on your phone for instant matches & updates</div>
            </div>
            <div class="app-actions">
                <button type="button" class="btn-install-app" id="installAppBtn" onclick="handleAppInstallClick()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM17 13l-5 5-5-5h3V9h4v4h3z" />
                    </svg>
                    <span>INSTALL APP</span>
                </button>
            </div>
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- ADMIN MODALS FOR MESSAGES & FIXTURES & PDF -->
    <!-- ========================================== -->

    <!-- Modal 1: Add Important Message -->
    <div class="modal-overlay" id="addMsgModal">
        <div class="modal-card">
            <button type="button" class="modal-close-btn" onclick="closeModal('addMsgModal')">&times;</button>
            <h3 class="modal-card-title">📢 Add Important Message</h3>
            <form action="{{ route('important-messages.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Message Title (Optional)</label>
                    <input type="text" name="title" class="form-input"
                        placeholder="e.g. USV League Registration Deadline">
                </div>
                <div class="form-group">
                    <label class="form-label">Badge Tag</label>
                    <select name="badge" class="form-select">
                        <option value="ANNOUNCEMENT">ANNOUNCEMENT</option>
                        <option value="URGENT">URGENT</option>
                        <option value="NOTICE">NOTICE</option>
                        <option value="UPDATE">UPDATE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Message Content *</label>
                    <textarea name="message" class="form-textarea" rows="4" required
                        placeholder="Enter complete message details..."></textarea>
                </div>
                <button type="submit" class="form-submit-btn">Save Message</button>
            </form>
        </div>
    </div>

    <!-- Modal 2: Edit Important Message -->
    <div class="modal-overlay" id="editMsgModal">
        <div class="modal-card">
            <button type="button" class="modal-close-btn" onclick="closeModal('editMsgModal')">&times;</button>
            <h3 class="modal-card-title">✏️ Edit Important Message</h3>
            <form id="editMsgForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Message Title</label>
                    <input type="text" name="title" id="edit_msg_title" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Badge Tag</label>
                    <select name="badge" id="edit_msg_badge" class="form-select">
                        <option value="ANNOUNCEMENT">ANNOUNCEMENT</option>
                        <option value="URGENT">URGENT</option>
                        <option value="NOTICE">NOTICE</option>
                        <option value="UPDATE">UPDATE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Message Content *</label>
                    <textarea name="message" id="edit_msg_content" class="form-textarea" rows="4" required></textarea>
                </div>
                <button type="submit" class="form-submit-btn">Update Message</button>
            </form>
        </div>
    </div>

    <!-- Modal 3: Add Home Fixture -->
    <div class="modal-overlay" id="addFixtureModal">
        <div class="modal-card">
            <button type="button" class="modal-close-btn" onclick="closeModal('addFixtureModal')">&times;</button>
            <h3 class="modal-card-title">🏏 Add Match Fixture</h3>
            <form action="{{ route('home-fixtures.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Match No *</label>
                        <input type="text" name="match_no" class="form-input" placeholder="Match 1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stage / Round *</label>
                        <input type="text" name="stage" class="form-input" placeholder="Group Stage" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Team 1 Name *</label>
                        <input type="text" name="team1" class="form-input" placeholder="Vellanad Strikers" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Team 1 Score (Optional)</label>
                        <input type="text" name="team1_score" class="form-input" placeholder="168/6 (20.0)">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Team 2 Name *</label>
                        <input type="text" name="team2" class="form-input" placeholder="USV Royals" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Team 2 Score (Optional)</label>
                        <input type="text" name="team2_score" class="form-input" placeholder="162/9 (20.0)">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Match Date *</label>
                        <input type="text" name="match_date" class="form-input" placeholder="15 Oct 2026" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Match Time *</label>
                        <input type="text" name="match_time" class="form-input" placeholder="09:00 AM IST" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Venue</label>
                        <input type="text" name="venue" class="form-input" placeholder="Vellanad Stadium">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Match Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="Upcoming">Upcoming</option>
                            <option value="Ongoing">Ongoing (Live)</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Result / Notes (Optional)</label>
                    <input type="text" name="result" class="form-input"
                        placeholder="e.g. Vellanad Strikers won by 6 runs">
                </div>
                <button type="submit" class="form-submit-btn">Save Fixture</button>
            </form>
        </div>
    </div>

    <!-- Modal 4: Edit Home Fixture -->
    <div class="modal-overlay" id="editFixtureModal">
        <div class="modal-card">
            <button type="button" class="modal-close-btn" onclick="closeModal('editFixtureModal')">&times;</button>
            <h3 class="modal-card-title">✏️ Edit Match Fixture</h3>
            <form id="editFixtureForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Match No *</label>
                        <input type="text" name="match_no" id="edit_fix_match_no" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stage / Round *</label>
                        <input type="text" name="stage" id="edit_fix_stage" class="form-input" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Team 1 Name *</label>
                        <input type="text" name="team1" id="edit_fix_team1" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Team 1 Score</label>
                        <input type="text" name="team1_score" id="edit_fix_team1_score" class="form-input">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Team 2 Name *</label>
                        <input type="text" name="team2" id="edit_fix_team2" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Team 2 Score</label>
                        <input type="text" name="team2_score" id="edit_fix_team2_score" class="form-input">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Match Date *</label>
                        <input type="text" name="match_date" id="edit_fix_match_date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Match Time *</label>
                        <input type="text" name="match_time" id="edit_fix_match_time" class="form-input" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Venue</label>
                        <input type="text" name="venue" id="edit_fix_venue" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Match Status *</label>
                        <select name="status" id="edit_fix_status" class="form-select" required>
                            <option value="Upcoming">Upcoming</option>
                            <option value="Ongoing">Ongoing (Live)</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Result / Notes</label>
                    <input type="text" name="result" id="edit_fix_result" class="form-input">
                </div>
                <button type="submit" class="form-submit-btn">Update Fixture</button>
            </form>
        </div>
    </div>

    <!-- Modal 5: Upload Full Fixtures PDF -->
    <div class="modal-overlay" id="uploadPdfModal">
        <div class="modal-card">
            <button type="button" class="modal-close-btn" onclick="closeModal('uploadPdfModal')">&times;</button>
            <h3 class="modal-card-title">📄 Upload Full Fixtures PDF</h3>
            <form action="{{ route('home-fixtures.pdf.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Select PDF Document *</label>
                    <input type="file" name="pdf_file" class="form-input" accept=".pdf" required>
                    <small
                        style="color: rgba(255,255,255,0.5); font-size: 0.75rem; margin-top: 0.35rem; display: block;">
                        Upload full tournament schedule PDF (Max 10MB). This file will open when visitors click "FULL
                        FIXTURES".
                    </small>
                </div>
                <button type="submit" class="form-submit-btn">Upload PDF Document</button>
            </form>
        </div>
    </div>

    <!-- PWA Installation Instructions Modal -->
    <div class="install-modal-overlay" id="installAppModal" onclick="handleBackdropClick(event)">
        <div class="install-modal-card">
            <button type="button" class="modal-close-btn" onclick="closeInstallModal()" title="Close">&times;</button>

            <img src="{{ asset('icon-192.png') }}" alt="USV Icon" class="modal-app-badge">
            <h3 class="modal-title">Get USV on Mobile</h3>
            <p class="modal-subtitle">Install United Seniors Vellanad app directly to your home screen for quick offline
                access, live tournament scores, and match notifications.</p>

            <div class="guide-steps">
                <div class="guide-step">
                    <span class="step-icon">🤖</span>
                    <div><strong>Android (Chrome):</strong> Tap the three dots (<strong>⋮</strong>) in the top-right
                        corner, then select <strong>"Install app"</strong> or <strong>"Add to Home screen"</strong>.
                    </div>
                </div>
                <div class="guide-step">
                    <span class="step-icon">🍎</span>
                    <div><strong>iPhone / iPad (Safari):</strong> Tap the <strong>Share</strong> icon
                        (<strong>⎋</strong>) in the bottom bar, scroll down and tap <strong>"Add to Home Screen"
                            ➕</strong>.</div>
                </div>
                <div class="guide-step">
                    <span class="step-icon">💻</span>
                    <div><strong>Desktop (Chrome/Edge):</strong> Click the <strong>Install</strong> icon
                        (<strong>⊕</strong>) in your browser's address bar.</div>
                </div>
            </div>

            <button type="button" class="btn-modal-gotit" onclick="closeInstallModal()">Got It, Thanks!</button>
        </div>
    </div>

    <script>
        let deferredPrompt = null;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            const btn = document.getElementById('installAppBtn');
            if (btn) {
                btn.classList.add('ready');
            }
        });

        function handleAppInstallClick() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the PWA install prompt');
                    }
                    deferredPrompt = null;
                });
            } else {
                openInstallModal();
            }
        }

        function openInstallModal() {
            document.getElementById('installAppModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeInstallModal() {
            document.getElementById('installAppModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function handleBackdropClick(event) {
            if (event.target === document.getElementById('installAppModal')) {
                closeInstallModal();
            }
        }

        // Generic Modal Handlers
        function openModal(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = '';
        }

        function openAddMsgModal() {
            openModal('addMsgModal');
        }

        function openEditMsgModal(id, title, message, badge) {
            document.getElementById('editMsgForm').action = '/important-messages/' + id;
            document.getElementById('edit_msg_title').value = title;
            document.getElementById('edit_msg_content').value = message;
            document.getElementById('edit_msg_badge').value = badge;
            openModal('editMsgModal');
        }

        function openAddFixtureModal() {
            openModal('addFixtureModal');
        }

        function openEditFixtureModal(id, match_no, stage, team1, team1_short, team1_score, team2, team2_short, team2_score, match_date, match_time, venue, status, result) {
            document.getElementById('editFixtureForm').action = '/home-fixtures/' + id;
            document.getElementById('edit_fix_match_no').value = match_no;
            document.getElementById('edit_fix_stage').value = stage;
            document.getElementById('edit_fix_team1').value = team1;
            document.getElementById('edit_fix_team1_score').value = team1_score;
            document.getElementById('edit_fix_team2').value = team2;
            document.getElementById('edit_fix_team2_score').value = team2_score;
            document.getElementById('edit_fix_match_date').value = match_date;
            document.getElementById('edit_fix_match_time').value = match_time;
            document.getElementById('edit_fix_venue').value = venue;
            document.getElementById('edit_fix_status').value = status;
            document.getElementById('edit_fix_result').value = result;
            openModal('editFixtureModal');
        }

        function openUploadPdfModal() {
            openModal('uploadPdfModal');
        }

        function handlePdfClick() {
            @if($isAdmin)
                openUploadPdfModal();
            @else
                alert('FULL FIXTURES PDF document is currently being updated by the administrator. Please check back shortly!');
            @endif
        }

        // Close modal when clicking overlay backdrop
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeInstallModal();
                document.querySelectorAll('.modal-overlay').forEach(modal => modal.classList.remove('active'));
                document.body.style.overflow = '';
            }
        });
    </script>
</body>

</html>