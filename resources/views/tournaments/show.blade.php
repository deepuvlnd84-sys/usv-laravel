<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tournament->name }} - Tournament Details - UNITED SENIORS VELLANAD</title>
    @include('pwa')
    <!-- Modern typography from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e60000ff;
            --primary-hover: #15b300ff;
            --text-color: #e7f711ff;
            --border-color: rgba(255, 255, 255, 0.15);
            --card-bg: rgba(14, 14, 14, 0.88);
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
            opacity: 0.35;
            filter: blur(3px);
            z-index: -1;
        }

        /* Header Navigation */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 3rem;
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(10, 10, 10, 0.85);
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
            transition: transform var(--transition-speed, 0.3s) ease;
        }

        .logo:hover .logo-img {
            transform: translateY(-2px) scale(1.06);
        }

        .logo-text {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--primary-color);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            line-height: 1;
        }

        .nav-menu {
            display: flex;
            gap: 1.8rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 600;
            font-size: 1.05rem;
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
            font-size: 1.05rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            padding: 0.25rem 0;
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

        .signin-btn {
            text-decoration: none;
            color: #ffffff;
            background-color: var(--primary-color);
            padding: 0.55rem 1.3rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .signin-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .user-role-badge {
            font-size: 0.8rem;
            font-weight: 800;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            letter-spacing: 0.05em;
        }

        .admin-badge {
            background: rgba(230, 0, 0, 0.25);
            border: 1px solid var(--primary-color);
            color: #ff6b6b;
        }

        /* Container */
        .main-container {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
            flex: 1;
        }

        /* Tournament Selector Pill Bar */
        .tournament-selector-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            background: rgba(20, 20, 20, 0.7);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 0.85rem 1.25rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(8px);
        }

        .selector-pills-group {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .selector-label {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: #aaaaaa;
            text-transform: uppercase;
            margin-right: 0.35rem;
        }

        .tourn-pill {
            text-decoration: none;
            padding: 0.5rem 1.1rem;
            border-radius: 50px;
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #dddddd;
            background: rgba(255, 255, 255, 0.04);
        }

        .tourn-pill:hover {
            border-color: var(--primary-color);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .tourn-pill.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff3333 100%);
            color: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(230, 0, 0, 0.4);
        }

        .back-tournaments-btn {
            text-decoration: none;
            color: var(--text-color);
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .back-tournaments-btn:hover {
            color: #ffffff;
            transform: translateX(-2px);
        }

        /* Hero Banner */
        .tournament-hero {
            background: linear-gradient(145deg, rgba(28, 28, 28, 0.95) 0%, rgba(16, 16, 16, 0.92) 100%);
            border: 1px solid rgba(230, 0, 0, 0.35);
            border-radius: 20px;
            padding: 2.2rem 2.5rem;
            margin-bottom: 2.2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
        }

        .tournament-hero::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(230, 0, 0, 0.18) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1.5rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .hero-left {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .trophy-badge {
            width: 75px;
            height: 75px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.3) 0%, rgba(231, 247, 17, 0.15) 100%);
            border: 2px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            box-shadow: 0 8px 20px rgba(230, 0, 0, 0.3);
            flex-shrink: 0;
        }

        .hero-title-group h1 {
            font-size: 2.4rem;
            font-weight: 900;
            color: #ffffff;
            margin: 0 0 0.4rem 0;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
        }

        .hero-edition {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-color);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .hero-right-actions {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            flex-wrap: wrap;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 1.1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .status-upcoming {
            background: rgba(231, 247, 17, 0.15);
            color: var(--text-color);
            border: 1px solid rgba(231, 247, 17, 0.4);
        }

        .status-ongoing {
            background: rgba(22, 163, 74, 0.2);
            color: #4ade80;
            border: 1px solid rgba(74, 222, 128, 0.4);
        }

        .status-completed {
            background: rgba(148, 163, 184, 0.2);
            color: #cbd5e1;
            border: 1px solid rgba(203, 213, 225, 0.4);
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: currentColor;
            display: inline-block;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.9); opacity: 0.7; }
            50% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.7; }
        }

        .admin-edit-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 0.45rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .admin-edit-btn:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .hero-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-top: 1.6rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.09);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .meta-icon {
            font-size: 1.3rem;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .meta-content {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 0.75rem;
            color: #888888;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .meta-val {
            font-size: 0.95rem;
            color: #f1f1f1;
            font-weight: 700;
        }

        /* ==========================================================================
           THE 6 INTERACTIVE TOURNAMENT SECTION BUTTONS
           TEAMS | FIXTURES | POINT TABLE | LEADERBOARD | TOURNAMENT COMMITTEE | GALLERY
           ========================================================================== */
        .section-buttons-wrapper {
            margin-bottom: 2.2rem;
        }

        .section-nav-tabs {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0.75rem;
            background: rgba(18, 18, 18, 0.8);
            padding: 0.6rem;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
        }

        .tab-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            color: #cccccc;
            padding: 1rem 0.5rem;
            font-family: inherit;
            font-size: 0.92rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            text-align: center;
            line-height: 1.2;
        }

        .tab-btn .btn-icon {
            font-size: 1.4rem;
            transition: transform 0.25s ease;
        }

        .tab-btn:hover {
            background: rgba(230, 0, 0, 0.15);
            border-color: rgba(230, 0, 0, 0.5);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .tab-btn:hover .btn-icon {
            transform: scale(1.18);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #b80000 100%);
            border-color: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(230, 0, 0, 0.5);
        }

        .tab-btn.active .btn-icon {
            transform: scale(1.15);
        }

        /* Tab Content Panels */
        .tab-panel {
            display: none;
            animation: fadeInTab 0.35s ease forwards;
        }

        .tab-panel.active {
            display: block;
        }

        @keyframes fadeInTab {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Section Headings */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid rgba(230, 0, 0, 0.4);
            padding-bottom: 0.75rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #ffffff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .section-badge {
            background: rgba(231, 247, 17, 0.15);
            color: var(--text-color);
            font-size: 0.8rem;
            font-weight: 800;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            border: 1px solid rgba(231, 247, 17, 0.3);
        }

        /* 1. TEAMS SECTION */
        .teams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .team-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            position: relative;
        }

        .team-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary-color);
            box-shadow: 0 12px 30px rgba(230, 0, 0, 0.25);
        }

        .team-card-header {
            padding: 1.25rem 1.25rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.04) 0%, transparent 100%);
        }

        .team-crest {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 900;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .crest-vs {
            background: linear-gradient(135deg, #e60000 0%, #ff5555 100%);
        }

        .crest-ur {
            background: linear-gradient(135deg, #1a56db 0%, #60a5fa 100%);
        }

        .crest-vw {
            background: linear-gradient(135deg, #16a34a 0%, #4ade80 100%);
        }

        .crest-ut {
            background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%);
        }

        .team-name-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
        }

        .team-ground-sub {
            margin: 0.2rem 0 0;
            font-size: 0.8rem;
            color: #999999;
        }

        .team-body {
            padding: 1.25rem;
        }

        .team-leadership {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            margin-bottom: 1.2rem;
            background: rgba(255, 255, 255, 0.03);
            padding: 0.85rem;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .leader-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.88rem;
        }

        .leader-tag {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--text-color);
            text-transform: uppercase;
        }

        .leader-name {
            font-weight: 700;
            color: #ffffff;
        }

        .toggle-squad-btn {
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #ffffff;
            padding: 0.6rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .toggle-squad-btn:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .squad-list {
            margin-top: 1rem;
            padding-top: 0.8rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: none;
        }

        .squad-list.show {
            display: block;
        }

        .squad-tags-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }

        .squad-player-pill {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e5e5;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
        }

        .squad-player-pill.is-c {
            border-color: var(--primary-color);
            background: rgba(230, 0, 0, 0.2);
            color: #ffffff;
        }

        .squad-player-pill.is-vc {
            border-color: var(--text-color);
            background: rgba(231, 247, 17, 0.15);
            color: var(--text-color);
        }

        /* 2. FIXTURES SECTION */
        .fixtures-list {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }

        .fixture-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .fixture-card:hover {
            border-color: rgba(230, 0, 0, 0.5);
            transform: translateX(4px);
        }

        .fixture-card.completed {
            border-left: 4px solid #16a34a;
        }

        .fixture-card.upcoming {
            border-left: 4px solid var(--text-color);
        }

        .fixture-left {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            min-width: 170px;
        }

        .fixture-stage {
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: var(--text-color);
            text-transform: uppercase;
        }

        .fixture-time {
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
        }

        .fixture-venue {
            font-size: 0.8rem;
            color: #999999;
        }

        .fixture-teams-matchup {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            min-width: 280px;
        }

        .matchup-team {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .matchup-team.team-right {
            flex-direction: row-reverse;
        }

        .matchup-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: #ffffff;
        }

        .matchup-score {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-color);
            background: rgba(255, 255, 255, 0.05);
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
        }

        .vs-badge {
            background: rgba(230, 0, 0, 0.2);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            font-weight: 900;
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fixture-result-info {
            text-align: right;
            min-width: 180px;
        }

        .match-status-tag {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 0.25rem 0.65rem;
            border-radius: 20px;
            margin-bottom: 0.3rem;
        }

        .match-result-summary {
            font-size: 0.8rem;
            color: #cccccc;
            max-width: 240px;
            line-height: 1.3;
        }

        /* 3. POINT TABLE SECTION */
        .table-responsive {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow-x: auto;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        }

        .point-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.95rem;
        }

        .point-table th {
            background: rgba(255, 255, 255, 0.04);
            padding: 1rem 1.1rem;
            font-weight: 800;
            color: var(--text-color);
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 0.06em;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .point-table td {
            padding: 1.1rem 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            color: #eeeeee;
        }

        .point-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .point-table tr.top-qualifier td:first-child {
            border-left: 4px solid #16a34a;
        }

        .team-td-name {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 800;
            color: #ffffff;
        }

        .pts-col {
            font-weight: 900;
            font-size: 1.1rem;
            color: var(--text-color);
        }

        .form-pill {
            display: inline-block;
            width: 22px;
            height: 22px;
            line-height: 22px;
            text-align: center;
            font-size: 0.72rem;
            font-weight: 800;
            border-radius: 4px;
            margin-right: 3px;
        }

        .form-w {
            background: #16a34a;
            color: #ffffff;
        }

        .form-l {
            background: #dc2626;
            color: #ffffff;
        }

        .nrr-val-pos {
            font-family: monospace;
            color: #4ade80;
        }

        .nrr-val-neg {
            font-family: monospace;
            color: #f87171;
        }

        .table-legend {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
            padding: 0.8rem 1.25rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            font-size: 0.82rem;
            color: #aaaaaa;
        }

        /* 4. LEADERBOARD SECTION */
        .leaderboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.8rem;
        }

        .leaderboard-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        }

        .leaderboard-card-header {
            padding: 1.1rem 1.4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .leaderboard-card-header.batting {
            background: linear-gradient(90deg, rgba(245, 158, 11, 0.2) 0%, transparent 100%);
            border-left: 4px solid #f59e0b;
        }

        .leaderboard-card-header.bowling {
            background: linear-gradient(90deg, rgba(147, 51, 234, 0.2) 0%, transparent 100%);
            border-left: 4px solid #a855f7;
        }

        .lead-title {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .lead-table {
            width: 100%;
            border-collapse: collapse;
        }

        .lead-table th {
            padding: 0.8rem 1rem;
            font-size: 0.78rem;
            font-weight: 800;
            color: #aaaaaa;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-align: left;
        }

        .lead-table td {
            padding: 0.85rem 1rem;
            font-size: 0.88rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: #eeeeee;
        }

        .lead-table tr.top-performer {
            background: rgba(231, 247, 17, 0.06);
        }

        .top-performer .player-name-cell {
            color: var(--text-color);
            font-weight: 800;
        }

        .stat-highlight {
            font-weight: 900;
            color: #ffffff;
            font-size: 1.05rem;
        }

        /* 5. TOURNAMENT COMMITTEE SECTION */
        .committee-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.4rem;
        }

        .committee-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.25s ease;
            position: relative;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        .committee-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary-color);
            box-shadow: 0 10px 25px rgba(230, 0, 0, 0.2);
        }

        .committee-role-badge {
            align-self: flex-start;
            background: rgba(230, 0, 0, 0.18);
            border: 1px solid rgba(230, 0, 0, 0.4);
            color: #ff6b6b;
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            margin-bottom: 0.9rem;
        }

        .committee-name {
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 0.4rem;
        }

        .committee-club {
            font-size: 0.85rem;
            color: #aaaaaa;
            margin: 0 0 1.2rem;
        }

        .committee-contact-btn {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .committee-contact-btn:hover {
            background: #16a34a;
            border-color: #16a34a;
            color: #ffffff;
        }

        /* 6. GALLERY SECTION */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .gallery-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        .gallery-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary-color);
            box-shadow: 0 12px 30px rgba(230, 0, 0, 0.3);
        }

        .gallery-img-container {
            height: 200px;
            background: linear-gradient(135deg, rgba(30, 30, 30, 0.95) 0%, rgba(10, 10, 10, 0.95) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .gallery-placeholder-icon {
            font-size: 3.5rem;
            opacity: 0.85;
            transition: transform 0.3s ease;
        }

        .gallery-card:hover .gallery-placeholder-icon {
            transform: scale(1.15);
        }

        .gallery-tag-pill {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.75);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            font-size: 0.72rem;
            font-weight: 800;
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .gallery-info {
            padding: 1.25rem;
        }

        .gallery-title {
            margin: 0 0 0.35rem 0;
            font-size: 1.15rem;
            font-weight: 800;
            color: #ffffff;
        }

        .gallery-desc {
            margin: 0;
            font-size: 0.85rem;
            color: #aaaaaa;
            line-height: 1.4;
        }

        /* Edit Modal (Admin) */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: #181818;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            max-width: 580px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #dddddd;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: #ffffff;
            font-family: inherit;
            font-size: 0.95rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.08);
        }

        /* Footer */
        .footer {
            margin-top: auto;
            background: rgba(10, 10, 10, 0.9);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1.8rem 2rem;
            text-align: center;
            font-size: 0.85rem;
            color: #777777;
        }

        .footer a {
            color: var(--text-color);
            text-decoration: none;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .section-nav-tabs {
                grid-template-columns: repeat(3, 1fr);
            }
            .leaderboard-grid {
                grid-template-columns: 1fr;
            }
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
            .section-nav-tabs {
                grid-template-columns: repeat(2, 1fr);
            }
            .tournament-hero {
                padding: 1.5rem;
            }
            .hero-title-group h1 {
                font-size: 1.8rem;
            }
            .fixture-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .fixture-teams-matchup {
                width: 100%;
                justify-content: space-between;
            }
            .fixture-result-info {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="bg-layer"></div>

    <!-- Header Navigation -->
    <header class="header">
        <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad - Return to Home">
            <img src="{{ asset('usv-logo.png') }}" alt="USV Logo" class="logo-img">
            <span class="logo-text">USV</span>
        </a>
        @include('partials.nav_controls')
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
                    <a href="{{ route('tournaments.show', 1) }}" class="nav-dropdown-item {{ $tournament->id == 1 ? 'active' : '' }}">
                        <span>🏆</span> Premier League
                    </a>
                    <a href="{{ route('tournaments.show', 2) }}" class="nav-dropdown-item {{ $tournament->id == 2 ? 'active' : '' }}">
                        <span>🏆</span> Champions League
                    </a>
                    <a href="{{ route('tournaments.show', 3) }}" class="nav-dropdown-item {{ $tournament->id == 3 ? 'active' : '' }}">
                        <span>🏆</span> Discovery League
                    </a>
                    <div style="border-top: 1px solid rgba(255,255,255,0.08); margin: 0.35rem 0;"></div>
                    <a href="{{ route('tournaments.index') }}" class="nav-dropdown-item">
                        <span>📋</span> All Tournaments
                    </a>
                </div>
            </div>

            <a href="{{ route('gallery') }}" class="nav-link">GALLERY</a>
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
                        <span class="user-role-badge" style="background: rgba(231, 247, 17, 0.2); color: var(--text-color); border: 1px solid var(--text-color);">🏏 PLAYER</span>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="signin-btn">LOG OUT</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="signin-btn">SIGN IN</a>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">

        <!-- Tournament Switcher Quick Bar -->
        <div class="tournament-selector-bar">
            <div class="selector-pills-group">
                <span class="selector-label">Tournaments:</span>
                <a href="{{ route('tournaments.show', 1) }}" class="tourn-pill {{ $tournament->id == 1 ? 'active' : '' }}">
                    🏆 Premier League
                </a>
                <a href="{{ route('tournaments.show', 2) }}" class="tourn-pill {{ $tournament->id == 2 ? 'active' : '' }}">
                    🏆 Champions League
                </a>
                <a href="{{ route('tournaments.show', 3) }}" class="tourn-pill {{ $tournament->id == 3 ? 'active' : '' }}">
                    🏆 Discovery League
                </a>
            </div>
            <a href="{{ route('tournaments.index') }}" class="back-tournaments-btn">
                ← Back to All Tournaments
            </a>
        </div>

        <!-- Tournament Hero Card -->
        <section class="tournament-hero">
            <div class="hero-top">
                <div class="hero-left">
                    <div class="trophy-badge">
                        @if($tournament->id == 1)
                            👑
                        @elseif($tournament->id == 2)
                            🏆
                        @else
                            🌟
                        @endif
                    </div>
                    <div class="hero-title-group">
                        <span class="hero-edition">{{ $tournament->edition ?? 'Tournament Edition' }}</span>
                        <h1>{{ $tournament->name }}</h1>
                    </div>
                </div>
                <div class="hero-right-actions">
                    @php
                        $statusClass = 'status-upcoming';
                        if (strtolower($tournament->status) === 'ongoing') {
                            $statusClass = 'status-ongoing';
                        } elseif (strtolower($tournament->status) === 'completed') {
                            $statusClass = 'status-completed';
                        }
                    @endphp
                    <span class="status-pill {{ $statusClass }}">
                        <span class="pulse-dot"></span>
                        {{ $tournament->status }}
                    </span>

                    @if($isAdmin)
                        <button type="button" class="admin-edit-btn" onclick="openEditModal()">
                            ⚙️ Edit Details
                        </button>
                    @endif
                </div>
            </div>

            @if($tournament->description)
                <p style="margin: 1rem 0 0; color: #cfcfcf; font-size: 0.98rem; line-height: 1.5; max-width: 850px;">
                    {{ $tournament->description }}
                </p>
            @endif

            <div class="hero-meta-grid">
                <div class="meta-item">
                    <div class="meta-icon">📍</div>
                    <div class="meta-content">
                        <span class="meta-label">Venue</span>
                        <span class="meta-val">{{ $tournament->venue ?? 'Vellanad Stadium' }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">📅</div>
                    <div class="meta-content">
                        <span class="meta-label">Start Date</span>
                        <span class="meta-val">
                            {{ $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') : 'Announced Soon' }}
                        </span>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">🛡️</div>
                    <div class="meta-content">
                        <span class="meta-label">Teams</span>
                        <span class="meta-val">{{ count($teams) }} Franchises</span>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">🏏</div>
                    <div class="meta-content">
                        <span class="meta-label">Format</span>
                        <span class="meta-val">T20 White Ball</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ====================================================================
             THE 6 MANDATORY INTERACTIVE SECTION BUTTONS:
             TEAMS | FIXTURES | POINT TABLE | LEADERBOARD | TOURNAMENT COMMITTEE | GALLERY
             ==================================================================== -->
        <div class="section-buttons-wrapper">
            <div class="section-nav-tabs" role="tablist">
                <button type="button" class="tab-btn active" data-tab="teams" onclick="switchSectionTab('teams')">
                    <span class="btn-icon">🛡️</span>
                    <span>TEAMS</span>
                </button>
                <button type="button" class="tab-btn" data-tab="fixtures" onclick="switchSectionTab('fixtures')">
                    <span class="btn-icon">📅</span>
                    <span>FIXTURES</span>
                </button>
                <button type="button" class="tab-btn" data-tab="points" onclick="switchSectionTab('points')">
                    <span class="btn-icon">📊</span>
                    <span>POINT TABLE</span>
                </button>
                <button type="button" class="tab-btn" data-tab="leaderboard" onclick="switchSectionTab('leaderboard')">
                    <span class="btn-icon">🏅</span>
                    <span>LEADERBOARD</span>
                </button>
                <button type="button" class="tab-btn" data-tab="committee" onclick="switchSectionTab('committee')">
                    <span class="btn-icon">👥</span>
                    <span>TOURNAMENT COMMITTEE</span>
                </button>
                <button type="button" class="tab-btn" data-tab="gallery" onclick="switchSectionTab('gallery')">
                    <span class="btn-icon">📸</span>
                    <span>GALLERY</span>
                </button>
            </div>
        </div>

        <!-- ====================================================================
             TAB 1: TEAMS
             ==================================================================== -->
        <section id="tab-teams" class="tab-panel active">
            <div class="section-header">
                <h2 class="section-title"><span>🛡️</span> Tournament Teams & Squads</h2>
                <span class="section-badge">{{ count($teams) }} Registered Teams</span>
            </div>

            <div class="teams-grid">
                @foreach($teams as $team)
                    <div class="team-card">
                        <div class="team-card-header">
                            <div class="team-crest crest-{{ strtolower($team['short_name']) }}">
                                {{ $team['short_name'] }}
                            </div>
                            <div>
                                <h3 class="team-name-title">{{ $team['name'] }}</h3>
                                <p class="team-ground-sub">🏟️ {{ $team['home_ground'] }}</p>
                            </div>
                        </div>

                        <div class="team-body">
                            <div class="team-leadership">
                                <div class="leader-row">
                                    <span class="leader-tag">Captain (C):</span>
                                    <span class="leader-name">{{ $team['captain'] }}</span>
                                </div>
                                <div class="leader-row">
                                    <span class="leader-tag">Vice-Captain (VC):</span>
                                    <span class="leader-name">{{ $team['vice_captain'] }}</span>
                                </div>
                                <div class="leader-row">
                                    <span class="leader-tag">Squad Count:</span>
                                    <span class="leader-name">{{ $team['squad_count'] }} Players</span>
                                </div>
                            </div>

                            <button type="button" class="toggle-squad-btn" data-team-id="{{ $team['id'] }}" onclick="handleToggleSquadClick(this)">
                                <span id="squad-btn-text-{{ $team['id'] }}">View 15-Member Squad</span>
                                <span id="squad-arrow-{{ $team['id'] }}">▼</span>
                            </button>

                            <div id="squad-list-{{ $team['id'] }}" class="squad-list">
                                <div class="squad-tags-wrap">
                                    @foreach($team['squad'] as $player)
                                        @php
                                            $isC = str_contains($player, '(C)');
                                            $isVc = str_contains($player, '(VC)');
                                        @endphp
                                        <span class="squad-player-pill {{ $isC ? 'is-c' : ($isVc ? 'is-vc' : '') }}">
                                            {{ $player }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- ====================================================================
             TAB 2: FIXTURES
             ==================================================================== -->
        <section id="tab-fixtures" class="tab-panel">
            <div class="section-header">
                <h2 class="section-title"><span>📅</span> Match Schedule & Fixtures</h2>
                <span class="section-badge">{{ count($fixtures) }} Scheduled Matches</span>
            </div>

            <div class="fixtures-list">
                @foreach($fixtures as $match)
                    @php
                        $isDone = ($match['status'] === 'Completed');
                    @endphp
                    <div class="fixture-card {{ $isDone ? 'completed' : 'upcoming' }}">
                        <div class="fixture-left">
                            <span class="fixture-stage">{!! $match['stage'] !!}</span>
                            <span class="fixture-time">{{ $match['date'] }} &bull; {{ $match['time'] }}</span>
                            <span class="fixture-venue">📍 {{ $match['venue'] }}</span>
                        </div>

                        <div class="fixture-teams-matchup">
                            <div class="matchup-team">
                                <span class="matchup-name">{{ $match['team1'] }}</span>
                                @if(!empty($match['team1_score']))
                                    <span class="matchup-score">{{ $match['team1_score'] }}</span>
                                @endif
                            </div>

                            <div class="vs-badge">VS</div>

                            <div class="matchup-team team-right">
                                <span class="matchup-name">{{ $match['team2'] }}</span>
                                @if(!empty($match['team2_score']))
                                    <span class="matchup-score">{{ $match['team2_score'] }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="fixture-result-info">
                            <span class="match-status-tag {{ $isDone ? 'status-completed' : 'status-upcoming' }}">
                                {{ $match['status'] }}
                            </span>
                            <div class="match-result-summary">
                                {!! $match['result'] !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- ====================================================================
             TAB 3: POINT TABLE
             ==================================================================== -->
        <section id="tab-points" class="tab-panel">
            <div class="section-header">
                <h2 class="section-title"><span>📊</span> Tournament Standings & Point Table</h2>
                <span class="section-badge">Top 2 Qualify for Grand Finale</span>
            </div>

            <div class="table-responsive">
                <table class="point-table">
                    <thead>
                        <tr>
                            <th>POS</th>
                            <th>TEAM</th>
                            <th>P</th>
                            <th>W</th>
                            <th>L</th>
                            <th>NR</th>
                            <th>NRR</th>
                            <th>PTS</th>
                            <th>RECENT FORM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($points as $row)
                            <tr class="{{ $row['pos'] <= 2 ? 'top-qualifier' : '' }}">
                                <td><strong>{{ $row['pos'] }}</strong></td>
                                <td>
                                    <div class="team-td-name">
                                        @if($row['pos'] == 1)
                                            <span style="color: #facc15;">🥇</span>
                                        @elseif($row['pos'] == 2)
                                            <span style="color: #cbd5e1;">🥈</span>
                                        @endif
                                        <span>{{ $row['team'] }}</span>
                                    </div>
                                </td>
                                <td>{{ $row['p'] }}</td>
                                <td>{{ $row['w'] }}</td>
                                <td>{{ $row['l'] }}</td>
                                <td>{{ $row['nr'] }}</td>
                                <td class="{{ floatval($row['nrr']) >= 0 ? 'nrr-val-pos' : 'nrr-val-neg' }}">
                                    {{ $row['nrr'] }}
                                </td>
                                <td class="pts-col">{{ $row['pts'] }}</td>
                                <td>
                                    @foreach($row['form'] as $f)
                                        <span class="form-pill {{ $f === 'W' ? 'form-w' : 'form-l' }}">
                                            {{ $f }}
                                        </span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-legend">
                <div>
                    <span style="display: inline-block; width: 10px; height: 10px; background: #16a34a; border-radius: 2px; margin-right: 6px;"></span>
                    <strong style="color: #ffffff;">Green Border:</strong> Top 2 Teams advance directly to Final
                </div>
                <div>
                    <strong>Points System:</strong> Win = 2 Pts &bull; Tie / No Result = 1 Pt &bull; Loss = 0 Pts
                </div>
            </div>
        </section>

        <!-- ====================================================================
             TAB 4: LEADERBOARD
             ==================================================================== -->
        <section id="tab-leaderboard" class="tab-panel">
            <div class="section-header">
                <h2 class="section-title"><span>🏅</span> Player Leaderboard & Statistics</h2>
                <span class="section-badge">Tournament Honors</span>
            </div>

            <div class="leaderboard-grid">
                <!-- Most Runs Leaderboard -->
                <div class="leaderboard-card">
                    <div class="leaderboard-card-header batting">
                        <h3 class="lead-title">🏏 Top Batsmen (Most Runs)</h3>
                        <span style="font-size: 0.8rem; font-weight: 800; color: #f59e0b;">ORANGE CAP</span>
                    </div>
                    <table class="lead-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Player</th>
                                <th>Team</th>
                                <th>Runs</th>
                                <th>HS</th>
                                <th>SR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaderboard['batsmen'] as $bat)
                                <tr class="{{ $bat['rank'] == 1 ? 'top-performer' : '' }}">
                                    <td>
                                        @if($bat['rank'] == 1)
                                            👑
                                        @else
                                            {{ $bat['rank'] }}
                                        @endif
                                    </td>
                                    <td class="player-name-cell">{{ $bat['name'] }}</td>
                                    <td style="color: #999999; font-size: 0.8rem;">{{ $bat['team'] }}</td>
                                    <td class="stat-highlight" style="color: #f59e0b;">{{ $bat['runs'] }}</td>
                                    <td>{{ $bat['hs'] }}</td>
                                    <td>{{ $bat['sr'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Most Wickets Leaderboard -->
                <div class="leaderboard-card">
                    <div class="leaderboard-card-header bowling">
                        <h3 class="lead-title">🎯 Top Bowlers (Most Wickets)</h3>
                        <span style="font-size: 0.8rem; font-weight: 800; color: #a855f7;">PURPLE CAP</span>
                    </div>
                    <table class="lead-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Player</th>
                                <th>Team</th>
                                <th>Wkts</th>
                                <th>Econ</th>
                                <th>Best</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaderboard['bowlers'] as $bowl)
                                <tr class="{{ $bowl['rank'] == 1 ? 'top-performer' : '' }}">
                                    <td>
                                        @if($bowl['rank'] == 1)
                                            👑
                                        @else
                                            {{ $bowl['rank'] }}
                                        @endif
                                    </td>
                                    <td class="player-name-cell">{{ $bowl['name'] }}</td>
                                    <td style="color: #999999; font-size: 0.8rem;">{{ $bowl['team'] }}</td>
                                    <td class="stat-highlight" style="color: #c084fc;">{{ $bowl['wickets'] }}</td>
                                    <td>{{ $bowl['econ'] }}</td>
                                    <td>{{ $bowl['best'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- ====================================================================
             TAB 5: TOURNAMENT COMMITTEE
             ==================================================================== -->
        <section id="tab-committee" class="tab-panel">
            <div class="section-header">
                <h2 class="section-title"><span>👥</span> Organizing Committee & Officials</h2>
                <span class="section-badge">{{ count($committee) }} Officials</span>
            </div>

            <div class="committee-grid">
                @foreach($committee as $member)
                    <div class="committee-card">
                        <div>
                            <span class="committee-role-badge">{{ $member['role'] }}</span>
                            <h3 class="committee-name">{{ $member['name'] }}</h3>
                            <p class="committee-club">United Seniors Vellanad (USV)</p>
                        </div>
                        <a href="tel:{{ str_replace(' ', '', $member['phone']) }}" class="committee-contact-btn">
                            <span>📞</span>
                            <span>{{ $member['phone'] }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- ====================================================================
             TAB 6: GALLERY
             ==================================================================== -->
        <section id="tab-gallery" class="tab-panel">
            <div class="section-header">
                <h2 class="section-title"><span>📸</span> Tournament Gallery & Moments</h2>
                <span class="section-badge">Exclusive Highlights</span>
            </div>

            <div class="gallery-grid">
                @foreach($gallery as $photo)
                    <div class="gallery-card">
                        <div class="gallery-img-container">
                            <span class="gallery-placeholder-icon">
                                @if(str_contains($photo['tag'], 'Ceremony'))
                                    🏆
                                @elseif(str_contains($photo['tag'], 'Opening'))
                                    🤝
                                @elseif(str_contains($photo['tag'], 'Match'))
                                    🏏
                                @elseif(str_contains($photo['tag'], 'Momentum'))
                                    🎉
                                @elseif(str_contains($photo['tag'], 'Awards'))
                                    🎖️
                                @else
                                    🏟️
                                @endif
                            </span>
                            <span class="gallery-tag-pill">{{ $photo['tag'] }}</span>
                        </div>
                        <div class="gallery-info">
                            <h4 class="gallery-title">{{ $photo['title'] }}</h4>
                            <p class="gallery-desc">{{ $photo['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </main>

    <!-- Admin Edit Modal -->
    @if($isAdmin)
        <div id="editModal" class="modal">
            <div class="modal-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="margin: 0; color: #ffffff; font-size: 1.3rem;">Edit Tournament Details</h3>
                    <button type="button" onclick="closeEditModal()" style="background: none; border: none; color: #999999; font-size: 1.5rem; cursor: pointer;">&times;</button>
                </div>
                <form action="{{ route('tournaments.update', $tournament->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Tournament Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $tournament->name }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Edition</label>
                        <input type="text" name="edition" class="form-control" value="{{ $tournament->edition }}" placeholder="e.g. Season 2026">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Venue</label>
                        <input type="text" name="venue" class="form-control" value="{{ $tournament->venue }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $tournament->start_date ? \Carbon\Carbon::parse($tournament->start_date)->format('Y-m-d') : '' }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="Upcoming" {{ $tournament->status === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="Ongoing" {{ $tournament->status === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ $tournament->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $tournament->description }}</textarea>
                    </div>
                    <div style="display: flex; gap: 0.8rem; justify-content: flex-end; margin-top: 1.5rem;">
                        <button type="button" onclick="closeEditModal()" class="admin-edit-btn" style="padding: 0.6rem 1.2rem;">Cancel</button>
                        <button type="submit" class="signin-btn" style="border-radius: 8px;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} United Seniors Vellanad (USV). All rights reserved. &bull; <a href="{{ route('tournaments.index') }}">Tournaments</a> &bull; <a href="{{ route('contact') }}">Contact Leadership</a></p>
    </footer>

    <!-- Interactive Tab Script -->
    <script>
        function switchSectionTab(tabKey) {
            // Remove active from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Remove active from all panels
            document.querySelectorAll('.tab-panel').forEach(panel => {
                panel.classList.remove('active');
            });

            // Set active button
            const activeBtn = document.querySelector(`.tab-btn[data-tab="${tabKey}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }

            // Set active panel
            const activePanel = document.getElementById(`tab-${tabKey}`);
            if (activePanel) {
                activePanel.classList.add('active');
            }

            // Update URL hash without scrolling
            if (history.pushState) {
                history.pushState(null, null, `#${tabKey}`);
            } else {
                location.hash = `#${tabKey}`;
            }
        }

        function handleToggleSquadClick(btn) {
            toggleSquadList(btn.getAttribute('data-team-id'));
        }

        function toggleSquadList(teamId) {
            const list = document.getElementById(`squad-list-${teamId}`);
            const text = document.getElementById(`squad-btn-text-${teamId}`);
            const arrow = document.getElementById(`squad-arrow-${teamId}`);

            if (list.classList.contains('show')) {
                list.classList.remove('show');
                text.innerText = 'View 15-Member Squad';
                arrow.innerText = '▼';
            } else {
                list.classList.add('show');
                text.innerText = 'Hide Squad List';
                arrow.innerText = '▲';
            }
        }

        function openEditModal() {
            const modal = document.getElementById('editModal');
            if (modal) modal.classList.add('active');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            if (modal) modal.classList.remove('active');
        }

        // On Page Load: Check URL hash for direct tab navigation e.g. #fixtures or #points
        window.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash.replace('#', '');
            const validTabs = ['teams', 'fixtures', 'points', 'leaderboard', 'committee', 'gallery'];
            if (hash && validTabs.includes(hash)) {
                switchSectionTab(hash);
            }
        });
    </script>
</body>

</html>
