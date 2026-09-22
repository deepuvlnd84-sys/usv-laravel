<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact & Leadership - UNITED SENIORS VELLANAD</title>
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
            --card-bg: rgba(14, 14, 14, 0.90);
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

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link.active::after,
        .nav-link:hover::after {
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
            color: var(--text-color);
            font-weight: 600;
            font-size: 1.15rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            padding: 0.25rem 0;
            position: relative;
            transition: color var(--transition-speed);
        }

        .nav-dropdown-toggle::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: width var(--transition-speed);
        }

        .nav-dropdown-wrap:hover .nav-dropdown-toggle {
            color: var(--primary-color);
        }

        .nav-dropdown-wrap:hover .nav-dropdown-toggle::after {
            width: 100%;
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

        .nav-dropdown-item:hover {
            background: rgba(230, 0, 0, 0.18);
            color: var(--text-color);
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
            background-color: var(--primary-hover);
            transform: translateY(-1px);
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

        /* Sign In Dropdown */
        .signin-dropdown-wrap {
            position: relative;
            display: inline-block;
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

        .dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 0.35rem 0;
        }

        /* Main Content Container */
        .main-content {
            flex: 1;
            padding: 3rem 1.5rem 5rem;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            z-index: 5;
        }

        /* Page Banner Header */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 900;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin: 0 0 0.5rem 0;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.8);
        }

        .page-subtitle {
            font-size: clamp(0.95rem, 2vw, 1.2rem);
            color: var(--text-color);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin: 0;
            opacity: 0.95;
        }

        /* Admin Action Banner */
        .admin-banner {
            background: rgba(230, 0, 0, 0.16);
            border: 1px solid var(--primary-color);
            border-radius: 16px;
            padding: 1rem 1.5rem;
            margin-bottom: 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            box-shadow: 0 8px 24px rgba(230, 0, 0, 0.25);
        }

        .admin-banner-text {
            font-size: 0.92rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .admin-banner-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-admin-action {
            background: var(--primary-color);
            color: #ffffff;
            text-decoration: none;
            padding: 0.55rem 1.25rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.82rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.4);
            font-family: inherit;
        }

        .btn-admin-action:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-admin-action.secondary {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: none;
        }

        .btn-admin-action.secondary:hover {
            background: rgba(255, 255, 255, 0.22);
            border-color: #ffffff;
        }

        /* Top Section: Leaders Showcase (President & Coordinator) */
        .leaders-section {
            margin-bottom: 4rem;
        }

        .section-headline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            padding-bottom: 0.85rem;
            flex-wrap: wrap;
        }

        .section-headline-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            font-size: 1.8rem;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
            margin: 0;
        }

        .section-title span {
            color: var(--primary-color);
        }

        .leaders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
            gap: 2.2rem;
        }

        .leader-card {
            background: linear-gradient(145deg, rgba(24, 24, 24, 0.95), rgba(16, 16, 16, 0.92));
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 24px;
            padding: 2.5rem;
            display: flex;
            gap: 2rem;
            align-items: center;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.65), 0 0 25px rgba(230, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            transition: transform var(--transition-speed) ease, border-color var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
        }

        .leader-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--text-color));
        }

        .leader-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary-color);
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.75), 0 0 35px rgba(230, 0, 0, 0.25);
        }

        .leader-photo-wrap {
            position: relative;
            width: 130px;
            height: 130px;
            flex-shrink: 0;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--text-color));
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.6);
        }

        .leader-photo-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            background: #1e1e1e;
        }

        .leader-avatar-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #242424;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #ffffff;
        }

        .leader-info {
            flex: 1;
            min-width: 0;
        }

        .leader-role-badge {
            display: inline-block;
            background: rgba(230, 0, 0, 0.22);
            border: 1px solid var(--primary-color);
            color: #ff5555;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            margin-bottom: 0.6rem;
        }

        .leader-name {
            font-size: 1.6rem;
            font-weight: 900;
            color: #ffffff;
            margin: 0 0 0.4rem 0;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            line-height: 1.15;
        }

        .leader-phone-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.2rem;
        }

        .leader-phone-link {
            color: var(--text-color);
            font-size: 1.15rem;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: 0.04em;
            transition: color var(--transition-speed);
        }

        .leader-phone-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .leader-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-call {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: linear-gradient(135deg, var(--primary-color), #b80000);
            color: #ffffff;
            text-decoration: none;
            padding: 0.55rem 1.2rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.82rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            box-shadow: 0 4px 14px rgba(230, 0, 0, 0.35);
            transition: all 0.2s ease;
        }

        .btn-call:hover {
            background: linear-gradient(135deg, #15b300, #0e7d00);
            box-shadow: 0 6px 18px rgba(21, 179, 0, 0.45);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .btn-whatsapp {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: #25D366;
            color: #ffffff;
            text-decoration: none;
            padding: 0.55rem 1.1rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.82rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.35);
            transition: all 0.2s ease;
        }

        .btn-whatsapp:hover {
            background: #1ebd5a;
            box-shadow: 0 6px 18px rgba(37, 211, 102, 0.5);
            transform: translateY(-2px);
            color: #ffffff;
        }

        /* Committee / 10 Persons Grid Section */
        .committee-section {
            margin-bottom: 4.5rem;
        }

        .persons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.8rem;
        }

        .person-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 1.8rem 1.25rem 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.5);
            position: relative;
            transition: transform var(--transition-speed) ease, border-color var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
        }

        .person-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            box-shadow: 0 20px 45px rgba(230, 0, 0, 0.25);
        }

        .person-photo-wrap {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            padding: 3px;
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.6), rgba(231, 247, 17, 0.4));
            margin-bottom: 1.1rem;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        .person-photo-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            background: #1e1e1e;
        }

        .person-avatar-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #252525;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: #ffffff;
        }

        .person-role-tag {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--text-color);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.2rem 0.65rem;
            border-radius: 50px;
            margin-bottom: 0.5rem;
            display: inline-block;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .person-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 0.5rem 0;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            line-height: 1.25;
            min-height: 2.5em;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .person-phone-wrap {
            margin-bottom: 1rem;
            margin-top: auto;
        }

        .person-phone-link {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.92rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: color var(--transition-speed);
        }

        .person-phone-link:hover {
            color: var(--text-color);
        }

        .btn-person-call {
            width: 100%;
            padding: 0.55rem;
            border-radius: 50px;
            background: rgba(230, 0, 0, 0.18);
            border: 1px solid var(--primary-color);
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            transition: all var(--transition-speed);
        }

        .btn-person-call:hover {
            background: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(230, 0, 0, 0.4);
            transform: translateY(-1px);
        }

        /* Bottom Section: Social Media Links */
        .social-section {
            background: linear-gradient(135deg, rgba(20, 20, 20, 0.96), rgba(35, 10, 10, 0.96));
            border: 1px solid rgba(230, 0, 0, 0.35);
            border-radius: 28px;
            padding: 3.5rem 2rem;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.75), 0 0 35px rgba(230, 0, 0, 0.18);
            position: relative;
            overflow: hidden;
        }

        .social-title {
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
            margin: 0 0 0.5rem 0;
        }

        .social-title span {
            color: var(--primary-color);
        }

        .social-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            margin: 0 0 2.5rem 0;
        }

        .social-links-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.8rem;
            flex-wrap: wrap;
        }

        .social-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.95rem 2.2rem;
            border-radius: 50px;
            text-decoration: none;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            transition: all 0.25s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        .social-btn.facebook {
            background: linear-gradient(135deg, #1877F2, #0d5bbd);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-btn.facebook:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 12px 28px rgba(24, 119, 242, 0.45);
        }

        .social-btn.instagram {
            background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-btn.instagram:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 12px 28px rgba(253, 29, 29, 0.45);
        }

        .social-btn.youtube {
            background: linear-gradient(135deg, #FF0000, #b30000);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-btn.youtube:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 12px 28px rgba(255, 0, 0, 0.45);
        }

        .social-icon-img {
            width: 24px;
            height: 24px;
            fill: currentColor;
        }

        /* Modal Styles for Adding Person */
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

        .form-group {
            margin-bottom: 1.3rem;
        }

        .form-label {
            display: block;
            color: var(--text-color);
            font-size: 0.82rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.4rem;
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
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .btn-submit {
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

        .btn-submit:hover {
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

            .leader-card {
                flex-direction: column;
                text-align: center;
                padding: 2rem 1.5rem;
            }

            .leader-phone-row {
                justify-content: center;
            }

            .leader-actions {
                justify-content: center;
            }

            .persons-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .social-section {
                padding: 2.5rem 1.5rem;
            }

            .social-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .persons-grid {
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
                    <a href="{{ route('tournaments.index') }}" class="nav-dropdown-item">
                        <span>📋</span> All Tournaments
                    </a>
                </div>
            </div>

            <a href="{{ route('gallery') }}" class="nav-link">GALLERY</a>
            <a href="{{ route('contact') }}" class="nav-link active">CONTACT</a>
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
                        <button type="submit" class="signin-btn" style="border: none; cursor: pointer; font-family: inherit;">LOG OUT</button>
                    </form>
                </div>
            @else
                <div class="signin-dropdown-wrap">
                    <button type="button" class="signin-btn">
                        SIGN IN
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="margin-left: 4px;">
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

    <!-- Main Content Area -->
    <main class="main-content">

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Contact & Leadership</h1>
            <p class="page-subtitle">United Seniors Vellanad &bull; Office Bearers &amp; Committee</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <span>✅</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($isAdmin)
            <div class="admin-banner">
                <div class="admin-banner-text">
                    <span>🛡️</span>
                    <span><strong>Administrator Controls:</strong> You can manage and edit leadership, committee members, and social links.</span>
                </div>
                <div class="admin-banner-actions">
                    <button type="button" class="btn-admin-action" onclick="openAddPersonModal()">
                        <span>➕ Add Member</span>
                    </button>
                    <a href="{{ route('contact.manage') }}" class="btn-admin-action secondary">
                        <span>⚙️ Manage All Contacts</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- Top Section: President & Coordinator -->
        <section class="leaders-section">
            <div class="section-headline">
                <div class="section-headline-left">
                    <span class="section-icon">👑</span>
                    <h2 class="section-title">Club <span>Leadership</span></h2>
                </div>
                @if($isAdmin)
                    <a href="{{ route('contact.manage') }}" class="btn-admin-action secondary" style="padding: 0.4rem 0.9rem; font-size: 0.78rem;">
                        <span>✏️ Edit Leaders</span>
                    </a>
                @endif
            </div>

            <div class="leaders-grid">
                <!-- President Card -->
                <div class="leader-card">
                    <div class="leader-photo-wrap">
                        @if($settings->president_photo && file_exists(public_path('uploads/contacts/' . $settings->president_photo)))
                            <img src="{{ asset('uploads/contacts/' . $settings->president_photo) }}" alt="{{ $settings->president_name }}" class="leader-photo-img">
                        @else
                            <div class="leader-avatar-placeholder">🏏</div>
                        @endif
                    </div>
                    <div class="leader-info">
                        <span class="leader-role-badge">{{ $settings->president_role ?? 'Club President' }}</span>
                        <h3 class="leader-name">{{ $settings->president_name }}</h3>
                        <div class="leader-phone-row">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="var(--text-color)">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            <a href="tel:{{ $settings->president_phone }}" class="leader-phone-link">{{ $settings->president_phone }}</a>
                        </div>
                        <div class="leader-actions">
                            <a href="tel:{{ $settings->president_phone }}" class="btn-call">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                                <span>Call Now</span>
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->president_phone) }}" target="_blank" rel="noopener" class="btn-whatsapp">
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Coordinator Card -->
                <div class="leader-card">
                    <div class="leader-photo-wrap">
                        @if($settings->coordinator_photo && file_exists(public_path('uploads/contacts/' . $settings->coordinator_photo)))
                            <img src="{{ asset('uploads/contacts/' . $settings->coordinator_photo) }}" alt="{{ $settings->coordinator_name }}" class="leader-photo-img">
                        @else
                            <div class="leader-avatar-placeholder">📋</div>
                        @endif
                    </div>
                    <div class="leader-info">
                        <span class="leader-role-badge" style="border-color: var(--text-color); color: var(--text-color); background: rgba(231, 247, 17, 0.12);">
                            {{ $settings->coordinator_role ?? 'General Coordinator' }}
                        </span>
                        <h3 class="leader-name">{{ $settings->coordinator_name }}</h3>
                        <div class="leader-phone-row">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="var(--text-color)">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            <a href="tel:{{ $settings->coordinator_phone }}" class="leader-phone-link">{{ $settings->coordinator_phone }}</a>
                        </div>
                        <div class="leader-actions">
                            <a href="tel:{{ $settings->coordinator_phone }}" class="btn-call">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                                <span>Call Now</span>
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->coordinator_phone) }}" target="_blank" rel="noopener" class="btn-whatsapp">
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Committee Members Grid (10+ Persons) -->
        <section class="committee-section">
            <div class="section-headline">
                <div class="section-headline-left">
                    <span class="section-icon">👥</span>
                    <h2 class="section-title">Committee <span>&amp; Key Contacts</span> ({{ $persons->count() }})</h2>
                </div>
                @if($isAdmin)
                    <button type="button" class="btn-admin-action" onclick="openAddPersonModal()">
                        <span>➕ Add Person</span>
                    </button>
                @endif
            </div>

            <div class="persons-grid">
                @forelse($persons as $person)
                    <div class="person-card">
                        <div class="person-photo-wrap">
                            @if($person->photo && file_exists(public_path('uploads/contacts/' . $person->photo)))
                                <img src="{{ asset('uploads/contacts/' . $person->photo) }}" alt="{{ $person->name }}" class="person-photo-img">
                            @else
                                <div class="person-avatar-placeholder">👤</div>
                            @endif
                        </div>
                        <span class="person-role-tag">{{ $person->designation }}</span>
                        <h4 class="person-name">{{ $person->name }}</h4>
                        <div class="person-phone-wrap">
                            <a href="tel:{{ $person->phone }}" class="person-phone-link">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                                <span>{{ $person->phone }}</span>
                            </a>
                        </div>
                        <a href="tel:{{ $person->phone }}" class="btn-person-call">
                            <span>📞 Call Member</span>
                        </a>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: rgba(255,255,255,0.6);">
                        No contact persons added yet.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Bottom Section: Social Media Links -->
        <section class="social-section">
            <h2 class="social-title">Connect With <span>United Seniors Vellanad</span></h2>
            <p class="social-desc">Follow our matches, announcements, match highlights, and club activities</p>

            <div class="social-links-row">
                <!-- Facebook -->
                <a href="{{ $settings->facebook_url ?: 'https://facebook.com' }}" target="_blank" rel="noopener" class="social-btn facebook" title="Visit our Facebook page">
                    <svg class="social-icon-img" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span>Facebook</span>
                </a>

                <!-- Instagram -->
                <a href="{{ $settings->instagram_url ?: 'https://instagram.com' }}" target="_blank" rel="noopener" class="social-btn instagram" title="Visit our Instagram profile">
                    <svg class="social-icon-img" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>Instagram</span>
                </a>

                <!-- YouTube -->
                <a href="{{ $settings->youtube_url ?: 'https://youtube.com' }}" target="_blank" rel="noopener" class="social-btn youtube" title="Watch our YouTube matches">
                    <svg class="social-icon-img" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                    <span>YouTube</span>
                </a>
            </div>
        </section>
    </main>

    @if($isAdmin)
        <!-- Modal: Add New Person (Admin Only) -->
        <div class="modal-overlay" id="addPersonModal" onclick="handleAddModalBackdrop(event)">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 class="modal-title">Add Committee Person</h3>
                    <button type="button" class="modal-close-btn" onclick="closeAddPersonModal()">&times;</button>
                </div>
                <form action="{{ route('contact.persons.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="person_name" class="form-label">Full Name *</label>
                        <input type="text" id="person_name" name="name" class="form-input" required placeholder="e.g. Arun Kumar">
                    </div>
                    <div class="form-group">
                        <label for="person_designation" class="form-label">Designation / Role *</label>
                        <input type="text" id="person_designation" name="designation" class="form-input" required placeholder="e.g. Joint Secretary, Team Captain, etc.">
                    </div>
                    <div class="form-group">
                        <label for="person_phone" class="form-label">Mobile Number *</label>
                        <input type="text" id="person_phone" name="phone" class="form-input" required placeholder="e.g. +91 98471 23456">
                    </div>
                    <div class="form-group">
                        <label for="person_photo" class="form-label">Photo (Optional)</label>
                        <input type="file" id="person_photo" name="photo" class="form-input" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="person_order" class="form-label">Display Order (Optional)</label>
                        <input type="number" id="person_order" name="order" class="form-input" placeholder="e.g. 11">
                    </div>
                    <button type="submit" class="btn-submit">Add to Contact Directory</button>
                </form>
            </div>
        </div>

        <script>
            function openAddPersonModal() {
                document.getElementById('addPersonModal').classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeAddPersonModal() {
                document.getElementById('addPersonModal').classList.remove('active');
                document.body.style.overflow = '';
            }

            function handleAddModalBackdrop(event) {
                if (event.target === document.getElementById('addPersonModal')) {
                    closeAddPersonModal();
                }
            }
        </script>
    @endif
</body>

</html>
