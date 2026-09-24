<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Management - United Seniors Vellanad</title>
    @include('pwa')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e60000;
            --primary-dark: #b91c1c;
            --green: #22c55e;
            --green-dark: #15803d;
            --amber: #f59e0b;
            --dark-card: rgba(18, 24, 38, 0.94);
            --border-color: rgba(255, 255, 255, 0.12);
            --text-main: #f8fafc;
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
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        .bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('stadium.jpg') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.3;
            filter: blur(4px);
            z-index: -1;
        }

        /* Header Navigation */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 2.5rem;
            position: relative;
            z-index: 20;
            background: rgba(10, 15, 24, 0.85);
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
            width: 44px;
            height: auto;
            max-height: 42px;
            object-fit: contain;
        }

        .logo-text {
            font-size: 1.05rem;
            font-weight: 900;
            color: var(--primary);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            line-height: 1;
        }

        .admin-nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-badge {
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary);
            color: #ff5555;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .btn-dash {
            text-decoration: none;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-dash:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* Main Content Container */
        .admin-container {
            flex: 1;
            padding: 2rem 2.5rem 4rem;
            position: relative;
            z-index: 10;
            max-width: 1440px;
            margin: 0 auto;
            width: 100%;
        }

        /* Top Page Title bar */
        .page-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1.2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        .page-actions {
            display: flex;
            gap: 0.85rem;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Action Buttons */
        .btn-excel {
            background: linear-gradient(135deg, #0b4d26 0%, #15803d 100%);
            border: 1.5px solid #22c55e;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.92rem;
            padding: 0.65rem 1.4rem;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .btn-excel:hover {
            background: #22c55e;
            color: #0b0f17;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.5);
        }

        .btn-add {
            background: linear-gradient(135deg, #e60000 0%, #b91c1c 100%);
            border: 1.5px solid #ef4444;
            color: #ffffff;
            font-weight: 800;
            font-size: 0.92rem;
            padding: 0.65rem 1.4rem;
            border-radius: 50px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(230, 0, 0, 0.35);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            border: none;
            font-family: inherit;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(230, 0, 0, 0.5);
            background: #ff1a1a;
        }

        .btn-print {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 0.65rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: var(--transition);
        }

        .btn-print:hover {
            background: rgba(255, 255, 255, 0.16);
        }

        /* Stats Cards Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.2rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--dark-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.2rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.06);
        }

        .stat-card.total .stat-icon {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .stat-card.locked .stat-icon {
            background: rgba(230, 0, 0, 0.15);
            color: #ef4444;
            border: 1px solid rgba(230, 0, 0, 0.3);
        }

        .stat-card.unlocked .stat-icon {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 0.25rem;
        }

        /* Filter & Search Bar */
        .filter-bar {
            background: var(--dark-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 0.65rem 1.2rem 0.65rem 2.6rem;
            color: #fff;
            font-family: inherit;
            font-size: 0.92rem;
            outline: none;
            transition: var(--transition);
        }

        .search-input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            fill: #94a3b8;
            width: 16px;
            height: 16px;
            pointer-events: none;
        }

        .filter-select {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 0.65rem 2.2rem 0.65rem 1.2rem;
            color: #fff;
            font-family: inherit;
            font-size: 0.88rem;
            cursor: pointer;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2394a3b8'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 1.2rem;
        }

        .filter-select option {
            background: #0f172a;
            color: #fff;
        }

        .btn-filter-apply {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 0.65rem 1.3rem;
            border-radius: 50px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-filter-apply:hover {
            background: var(--green);
            color: #0b0f17;
            border-color: var(--green);
        }

        .btn-filter-reset {
            text-decoration: none;
            color: #94a3b8;
            font-size: 0.88rem;
            padding: 0.5rem 0.8rem;
            transition: var(--transition);
        }

        .btn-filter-reset:hover {
            color: #fff;
        }

        /* Registrations Table Container */
        .table-card {
            background: var(--dark-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.92rem;
        }

        .custom-table thead {
            background: rgba(11, 77, 38, 0.6);
            border-bottom: 2px solid rgba(34, 197, 94, 0.4);
        }

        .custom-table th {
            padding: 1rem 1.2rem;
            font-weight: 800;
            color: #fef08a;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 0.82rem;
            white-space: nowrap;
        }

        .custom-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            transition: background 0.2s ease;
        }

        .custom-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.04);
        }

        .custom-table td {
            padding: 1rem 1.2rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Player Cell */
        .player-info-cell {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .player-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(34, 197, 94, 0.4);
            background: rgba(255, 255, 255, 0.05);
            flex-shrink: 0;
        }

        .player-avatar-placeholder {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(230, 0, 0, 0.2);
            border: 2px solid rgba(230, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
            color: #fca5a5;
            font-weight: 800;
        }

        .player-name-wrap {
            display: flex;
            flex-direction: column;
        }

        .player-name {
            font-weight: 800;
            color: #fff;
            font-size: 0.98rem;
        }

        .player-mobile {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        /* Role Pills */
        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .role-pill.batsman {
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.4);
            color: #93c5fd;
        }

        .role-pill.bowler {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
        }

        .role-pill.allrounder {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #86efac;
        }

        .role-pill.wk {
            background: rgba(234, 179, 8, 0.15);
            border: 1px solid rgba(234, 179, 8, 0.4);
            color: #fde047;
        }

        /* Lock Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        .status-badge.locked {
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid var(--primary);
            color: #f87171;
        }

        .status-badge.unlocked {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid #22c55e;
            color: #4ade80;
        }

        /* Action Buttons */
        .table-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-action {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
            padding: 0.4rem 0.65rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-family: inherit;
        }

        .btn-action:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-action.btn-lock {
            border-color: rgba(245, 158, 11, 0.4);
            color: #fbbf24;
        }

        .btn-action.btn-lock:hover {
            background: rgba(245, 158, 11, 0.2);
        }

        .btn-action.btn-edit {
            border-color: rgba(59, 130, 246, 0.4);
            color: #60a5fa;
        }

        .btn-action.btn-edit:hover {
            background: rgba(59, 130, 246, 0.2);
        }

        .btn-action.btn-delete {
            border-color: rgba(239, 68, 68, 0.4);
            color: #f87171;
        }

        .btn-action.btn-delete:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .btn-action.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Empty state */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-state svg {
            width: 60px;
            height: 60px;
            fill: rgba(255, 255, 255, 0.2);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: #fff;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        /* Modals */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .modal-card {
            background: #111827;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            width: 100%;
            max-width: 780px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
            animation: modalFadeIn 0.25s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.96);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-header {
            padding: 1.25rem 1.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: #111827;
            z-index: 10;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .modal-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 1.5rem;
            cursor: pointer;
            line-height: 1;
            padding: 0.25rem;
            transition: var(--transition);
        }

        .modal-close:hover {
            color: #fff;
        }

        .modal-body {
            padding: 1.8rem;
        }

        .modal-footer {
            padding: 1.25rem 1.8rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: flex-end;
            gap: 0.85rem;
            background: rgba(15, 23, 42, 0.5);
        }

        /* Modal Form Elements */
        .modal-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.2rem;
        }

        .modal-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .modal-group.full {
            grid-column: 1 / -1;
        }

        .modal-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #e2e8f0;
        }

        .modal-input,
        .modal-select {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            color: #fff;
            font-family: inherit;
            font-size: 0.92rem;
            padding: 0.65rem 0.9rem;
            outline: none;
        }

        .modal-input:focus,
        .modal-select:focus {
            border-color: var(--green);
        }

        .modal-select option {
            background: #111827;
            color: #fff;
        }

        textarea.modal-input {
            resize: vertical;
            min-height: 70px;
        }

        /* Details Modal List */
        .details-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem 1.5rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding-bottom: 0.5rem;
        }

        .detail-item.full {
            grid-column: 1 / -1;
        }

        .detail-key {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .detail-val {
            font-size: 0.95rem;
            color: #fff;
            font-weight: 600;
        }

        /* Print media style */
        @media print {
            body {
                background: #fff !important;
                color: #000 !important;
            }
            .header, .page-actions, .filter-bar, .stats-grid, .table-actions, .modal-backdrop {
                display: none !important;
            }
            .admin-container {
                padding: 0 !important;
                max-width: 100% !important;
            }
            .table-card {
                box-shadow: none !important;
                border: 1px solid #000 !important;
                background: #fff !important;
            }
            .custom-table {
                color: #000 !important;
            }
            .custom-table th {
                background: #eee !important;
                color: #000 !important;
                border: 1px solid #000 !important;
            }
            .custom-table td {
                border: 1px solid #ccc !important;
                color: #000 !important;
            }
        }
    </style>
</head>

<body>
    <!-- Background layer -->
    <div class="bg-layer"></div>

    <!-- Admin Navigation Header -->
    <header class="header">
        <a href="{{ url('/') }}" class="logo" title="United Seniors Vellanad">
            <img src="{{ asset('usv-logo.png') }}" alt="USV Logo" class="logo-img">
            <span class="logo-text">USV ADMIN</span>
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

        <div class="admin-nav-actions">
            <span class="admin-badge">🛡️ Administrator</span>
            <a href="{{ route('dashboard') }}" class="btn-dash">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ url('/') }}" class="btn-dash">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                Home
            </a>
        </div>
    </header>

    <!-- Main Container -->
    <main class="admin-container">
        <!-- Success & Error Alerts -->
        @if(session('success'))
            <div style="background: rgba(34, 197, 94, 0.15); border: 1.5px solid #22c55e; color: #86efac; padding: 1rem 1.4rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <span style="font-size: 1.4rem;">✅</span>
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(230, 0, 0, 0.15); border: 1.5px solid #e60000; color: #fca5a5; padding: 1rem 1.4rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <strong>Notice:</strong>
                <ul style="margin-left: 1.2rem; margin-top: 0.3rem;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Title & Page Actions Row -->
        <div class="page-header-row">
            <div>
                <h1 class="page-title">
                    <span>📋 Registered Players</span>
                </h1>
                <p class="page-subtitle">Manage incoming registrations, export to Excel, edit details & secure records with Lock</p>
            </div>

            <div class="page-actions">
                <!-- PRINT IN EXCEL FORMAT (Requirement) -->
                <a href="{{ route('admin.register.export', request()->all()) }}" class="btn-excel" title="Download Excel Spreadsheet (.xls)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                    </svg>
                    <span>Print in Excel Format</span>
                </a>

                <!-- ADD OPTION (Requirement) -->
                <button type="button" class="btn-add" onclick="openAddModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    <span>Add New Player</span>
                </button>

                <!-- Print Browser View -->
                <button type="button" class="btn-print" onclick="window.print()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                    </svg>
                    <span>Print</span>
                </button>
            </div>
        </div>

        <!-- Summary Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-icon">👥</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $totalCount }}</span>
                    <span class="stat-label">Total Players</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🏏</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $batsmanCount }}</span>
                    <span class="stat-label">Batsmen</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⚡</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $bowlerCount }}</span>
                    <span class="stat-label">Bowlers</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🌟</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $allrounderCount }}</span>
                    <span class="stat-label">Allrounders</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🧤</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $wkCount }}</span>
                    <span class="stat-label">Wicket Keepers</span>
                </div>
            </div>

            <div class="stat-card locked">
                <div class="stat-icon">🔒</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $lockedCount }}</span>
                    <span class="stat-label">Locked Records</span>
                </div>
            </div>

            <div class="stat-card unlocked">
                <div class="stat-icon">🔓</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $unlockedCount }}</span>
                    <span class="stat-label">Unlocked</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Controls -->
        <form action="{{ route('admin.register.index') }}" method="GET" class="filter-bar">
            <div class="search-box">
                <svg class="search-icon" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <input type="text" name="search" class="search-input" placeholder="Search by name, mobile, job, jersey..." value="{{ request('search') }}">
            </div>

            <select name="role" class="filter-select">
                <option value="all">All Playing Roles</option>
                <option value="Batsman" {{ request('role') == 'Batsman' ? 'selected' : '' }}>Batsman</option>
                <option value="Bowler" {{ request('role') == 'Bowler' ? 'selected' : '' }}>Bowler</option>
                <option value="Allrounder" {{ request('role') == 'Allrounder' ? 'selected' : '' }}>Allrounder</option>
                <option value="Wicket Keeper Batsman" {{ request('role') == 'Wicket Keeper Batsman' ? 'selected' : '' }}>Wicket Keeper Batsman</option>
            </select>

            <select name="status" class="filter-select">
                <option value="">All Lock Status</option>
                <option value="locked" {{ request('status') == 'locked' ? 'selected' : '' }}>Locked Only 🔒</option>
                <option value="unlocked" {{ request('status') == 'unlocked' ? 'selected' : '' }}>Unlocked Only 🔓</option>
            </select>

            <button type="submit" class="btn-filter-apply">Filter</button>
            @if(request()->hasAny(['search', 'role', 'status']))
                <a href="{{ route('admin.register.index') }}" class="btn-filter-reset">Reset</a>
            @endif
        </form>

        <!-- Registrations Data Table -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Player</th>
                            <th>Role & Techniques</th>
                            <th>Age / DOB</th>
                            <th>Blood Group</th>
                            <th>Qualification & Job</th>
                            <th>Lock Status</th>
                            <th style="text-align: right;">Admin Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="player-info-cell">
                                        @if($item->photo_url)
                                            <img src="{{ $item->photo_url }}" alt="{{ $item->name }}" class="player-avatar" onclick="showImageModal('{{ $item->photo_url }}', '{{ htmlspecialchars($item->name) }}')" style="cursor: pointer;" title="Click to enlarge">
                                        @else
                                            <div class="player-avatar-placeholder">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="player-name-wrap">
                                            <span class="player-name">{{ $item->name }}</span>
                                            <span class="player-mobile">📞 {{ $item->mobile_no }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $roleClass = match($item->playing_role) {
                                            'Batsman' => 'batsman',
                                            'Bowler' => 'bowler',
                                            'Allrounder' => 'allrounder',
                                            default => 'wk',
                                        };
                                    @endphp
                                    <span class="role-pill {{ $roleClass }}">
                                        {{ $item->playing_role }}
                                    </span>
                                    <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 0.25rem;">
                                        @if($item->batting_style) <span>🏏 {{ $item->batting_style }}</span> @endif
                                        @if($item->bowling_arm) <span>&bull; {{ $item->bowling_arm }}</span> @endif
                                        @if($item->bowling_pace) <span>({{ $item->bowling_pace }})</span> @endif
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight: 700; color: #fff;">{{ $item->age ? $item->age . ' yrs' : '-' }}</span>
                                    <div style="font-size: 0.78rem; color: #94a3b8;">{{ $item->dob ? $item->dob->format('d M Y') : '-' }}</div>
                                </td>
                                <td>
                                    @if($item->blood_group)
                                        <span style="background: rgba(230, 0, 0, 0.15); border: 1px solid rgba(230, 0, 0, 0.3); color: #fca5a5; font-weight: 800; font-size: 0.78rem; padding: 0.2rem 0.5rem; border-radius: 6px;">
                                            {{ $item->blood_group }}
                                        </span>
                                    @else
                                        <span style="color: #64748b;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #e2e8f0;">{{ $item->education_qualification ?: '-' }}</div>
                                    <div style="font-size: 0.78rem; color: #94a3b8;">{{ $item->job ?: 'Not specified' }}</div>
                                </td>
                                <td>
                                    @if($item->is_locked)
                                        <span class="status-badge locked" title="Details are locked by admin">
                                            🔒 LOCKED
                                        </span>
                                    @else
                                        <span class="status-badge unlocked" title="Details are open for modification">
                                            🔓 UNLOCKED
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions" style="justify-content: flex-end;">
                                        <!-- View Full Details -->
                                        <button type="button" class="btn-action" data-player="{{ base64_encode(json_encode($item)) }}" onclick="openDetailsModalFromBtn(this)" title="View Complete Details">
                                            👁️ View
                                        </button>

                                        <!-- LOCK THE DETAILS OPTION (Requirement) -->
                                        <form action="{{ route('admin.register.lock', $item->id) }}" method="POST" style="margin: 0; display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-action btn-lock" title="{{ $item->is_locked ? 'Click to Unlock this player' : 'Click to Lock this player details' }}">
                                                @if($item->is_locked)
                                                    🔓 Unlock
                                                @else
                                                    🔒 Lock
                                                @endif
                                            </button>
                                        </form>

                                        <!-- EDIT OPTION (Requirement) -->
                                        <button type="button" class="btn-action btn-edit" data-player="{{ base64_encode(json_encode($item)) }}" onclick="openEditModalFromBtn(this)" title="Edit Details">
                                            ✏️ Edit
                                        </button>

                                        <!-- DELETE OPTION (Requirement) -->
                                        <form action="{{ route('admin.register.destroy', $item->id) }}" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('Are you sure you want to delete the registered player \'{{ addslashes($item->name) }}\'? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Delete Registration Record">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
                                        </svg>
                                        <h3>No Player Registrations Found</h3>
                                        <p>No players matched your search or filter criteria. Click "Add New Player" or clear filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- ============================================== -->
    <!-- MODAL 1: ADD NEW PLAYER (Admin Add Option)     -->
    <!-- ============================================== -->
    <div class="modal-backdrop" id="addPlayerModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">➕ Add New Player Registration</h3>
                <button type="button" class="modal-close" onclick="closeModal('addPlayerModal')">&times;</button>
            </div>
            <form action="{{ route('admin.register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="modal-grid">
                        <!-- Photo -->
                        <div class="modal-group full">
                            <label class="modal-label">Player Photo</label>
                            <input type="file" name="photo" class="modal-input" accept="image/*">
                        </div>

                        <!-- Name -->
                        <div class="modal-group">
                            <label class="modal-label">Full Name *</label>
                            <input type="text" name="name" class="modal-input" required placeholder="Player Name">
                        </div>

                        <!-- Mobile -->
                        <div class="modal-group">
                            <label class="modal-label">Mobile Number *</label>
                            <input type="tel" name="mobile_no" class="modal-input" required placeholder="Mobile Phone">
                        </div>

                        <!-- Age -->
                        <div class="modal-group">
                            <label class="modal-label">Age</label>
                            <input type="number" name="age" class="modal-input" min="5" max="100" placeholder="Age in years">
                        </div>

                        <!-- DOB -->
                        <div class="modal-group">
                            <label class="modal-label">Date of Birth</label>
                            <input type="date" name="dob" class="modal-input">
                        </div>

                        <!-- Blood Group -->
                        <div class="modal-group">
                            <label class="modal-label">Blood Group</label>
                            <select name="blood_group" class="modal-select">
                                <option value="">-- Blood Group --</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>

                        <!-- Qualification -->
                        <div class="modal-group">
                            <label class="modal-label">Education Qualification</label>
                            <input type="text" name="education_qualification" class="modal-input" placeholder="e.g. Degree, Plus Two">
                        </div>

                        <!-- Job -->
                        <div class="modal-group full">
                            <label class="modal-label">Job / Profession</label>
                            <input type="text" name="job" class="modal-input" placeholder="Occupation">
                        </div>

                        <!-- Address -->
                        <div class="modal-group full">
                            <label class="modal-label">Residential Address</label>
                            <textarea name="address" class="modal-input" placeholder="Address"></textarea>
                        </div>

                        <!-- Playing Role -->
                        <div class="modal-group">
                            <label class="modal-label">Playing Role *</label>
                            <select name="playing_role" class="modal-select" required onchange="toggleAdminRoleOptions(this.value, 'add')">
                                <option value="Batsman">Batsman</option>
                                <option value="Bowler">Bowler</option>
                                <option value="Allrounder">Allrounder</option>
                                <option value="Wicket Keeper Batsman">Wicket Keeper Batsman</option>
                            </select>
                        </div>

                        <!-- Batting Style -->
                        <div class="modal-group" id="add_batting_style_grp">
                            <label class="modal-label">Batting Style</label>
                            <select name="batting_style" class="modal-select">
                                <option value="">-- Batting Style --</option>
                                <option value="Right Hand">Right Hand</option>
                                <option value="Left Hand">Left Hand</option>
                            </select>
                        </div>

                        <!-- Bowling Arm -->
                        <div class="modal-group" id="add_bowling_arm_grp">
                            <label class="modal-label">Bowling Arm</label>
                            <select name="bowling_arm" class="modal-select">
                                <option value="">-- Bowling Arm --</option>
                                <option value="Right Arm">Right Arm</option>
                                <option value="Left Arm">Left Arm</option>
                            </select>
                        </div>

                        <!-- Bowling Pace -->
                        <div class="modal-group" id="add_bowling_pace_grp">
                            <label class="modal-label">Bowling Pace</label>
                            <select name="bowling_pace" class="modal-select">
                                <option value="">-- Bowling Pace --</option>
                                <option value="Pace">Pace</option>
                                <option value="Medium">Medium</option>
                                <option value="Slow">Slow</option>
                            </select>
                        </div>

                        <!-- Jersey Number -->
                        <div class="modal-group">
                            <label class="modal-label">Jersey Number</label>
                            <input type="text" name="jersey_number" class="modal-input" placeholder="Jersey #">
                        </div>

                        <!-- Batting Position -->
                        <div class="modal-group">
                            <label class="modal-label">Batting Position</label>
                            <select name="batting_position" class="modal-select">
                                <option value="">-- Select Order --</option>
                                <option value="Opening">Opening</option>
                                <option value="Top Order">Top Order</option>
                                <option value="Middle Order">Middle Order</option>
                                <option value="Finisher / Lower Order">Finisher / Lower Order</option>
                            </select>
                        </div>

                        <!-- Previous Clubs -->
                        <div class="modal-group full">
                            <label class="modal-label">Previous Clubs / Teams</label>
                            <input type="text" name="previous_clubs" class="modal-input" placeholder="Clubs played for">
                        </div>

                        <!-- Cricket Experience -->
                        <div class="modal-group full">
                            <label class="modal-label">Cricket Experience</label>
                            <input type="text" name="cricket_experience" class="modal-input" placeholder="Years of experience / tournaments">
                        </div>

                        <!-- Remarks -->
                        <div class="modal-group full">
                            <label class="modal-label">Remarks / About</label>
                            <textarea name="remarks" class="modal-input" placeholder="Remarks or notes"></textarea>
                        </div>

                        <!-- Lock status check -->
                        <div class="modal-group full" style="flex-direction: row; align-items: center; gap: 0.6rem; margin-top: 0.5rem;">
                            <input type="checkbox" name="is_locked" id="add_is_locked" value="1" style="width: 18px; height: 18px; cursor: pointer;">
                            <label for="add_is_locked" class="modal-label" style="cursor: pointer;">
                                🔒 Lock this player's details immediately upon saving
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-action" onclick="closeModal('addPlayerModal')">Cancel</button>
                    <button type="submit" class="btn-add">Save Player</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- MODAL 2: EDIT PLAYER (Admin Edit Option)       -->
    <!-- ============================================== -->
    <div class="modal-backdrop" id="editPlayerModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">✏️ Edit Player Details</h3>
                <button type="button" class="modal-close" onclick="closeModal('editPlayerModal')">&times;</button>
            </div>
            <form id="editPlayerForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Warning if locked -->
                    <div id="editLockedWarning" style="display: none; background: rgba(230, 0, 0, 0.2); border: 1px solid #e60000; color: #fca5a5; padding: 0.8rem 1rem; border-radius: 10px; margin-bottom: 1.2rem; font-size: 0.88rem;">
                        ⚠️ <strong>This record is currently LOCKED.</strong> Checking "Unlock to allow saving" will enable updates.
                    </div>

                    <div class="modal-grid">
                        <!-- Photo Replacement -->
                        <div class="modal-group full">
                            <label class="modal-label">Replace Photo (Optional)</label>
                            <input type="file" name="photo" class="modal-input" accept="image/*">
                        </div>

                        <!-- Name -->
                        <div class="modal-group">
                            <label class="modal-label">Full Name *</label>
                            <input type="text" name="name" id="edit_name" class="modal-input" required>
                        </div>

                        <!-- Mobile -->
                        <div class="modal-group">
                            <label class="modal-label">Mobile Number *</label>
                            <input type="tel" name="mobile_no" id="edit_mobile_no" class="modal-input" required>
                        </div>

                        <!-- Age -->
                        <div class="modal-group">
                            <label class="modal-label">Age</label>
                            <input type="number" name="age" id="edit_age" class="modal-input" min="5" max="100">
                        </div>

                        <!-- DOB -->
                        <div class="modal-group">
                            <label class="modal-label">Date of Birth</label>
                            <input type="date" name="dob" id="edit_dob" class="modal-input">
                        </div>

                        <!-- Blood Group -->
                        <div class="modal-group">
                            <label class="modal-label">Blood Group</label>
                            <select name="blood_group" id="edit_blood_group" class="modal-select">
                                <option value="">-- Blood Group --</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>

                        <!-- Qualification -->
                        <div class="modal-group">
                            <label class="modal-label">Education Qualification</label>
                            <input type="text" name="education_qualification" id="edit_education_qualification" class="modal-input">
                        </div>

                        <!-- Job -->
                        <div class="modal-group full">
                            <label class="modal-label">Job / Profession</label>
                            <input type="text" name="job" id="edit_job" class="modal-input">
                        </div>

                        <!-- Address -->
                        <div class="modal-group full">
                            <label class="modal-label">Residential Address</label>
                            <textarea name="address" id="edit_address" class="modal-input"></textarea>
                        </div>

                        <!-- Playing Role -->
                        <div class="modal-group">
                            <label class="modal-label">Playing Role *</label>
                            <select name="playing_role" id="edit_playing_role" class="modal-select" required>
                                <option value="Batsman">Batsman</option>
                                <option value="Bowler">Bowler</option>
                                <option value="Allrounder">Allrounder</option>
                                <option value="Wicket Keeper Batsman">Wicket Keeper Batsman</option>
                            </select>
                        </div>

                        <!-- Batting Style -->
                        <div class="modal-group">
                            <label class="modal-label">Batting Style</label>
                            <select name="batting_style" id="edit_batting_style" class="modal-select">
                                <option value="">-- None / N/A --</option>
                                <option value="Right Hand">Right Hand</option>
                                <option value="Left Hand">Left Hand</option>
                            </select>
                        </div>

                        <!-- Bowling Arm -->
                        <div class="modal-group">
                            <label class="modal-label">Bowling Arm</label>
                            <select name="bowling_arm" id="edit_bowling_arm" class="modal-select">
                                <option value="">-- None / N/A --</option>
                                <option value="Right Arm">Right Arm</option>
                                <option value="Left Arm">Left Arm</option>
                            </select>
                        </div>

                        <!-- Bowling Pace -->
                        <div class="modal-group">
                            <label class="modal-label">Bowling Pace</label>
                            <select name="bowling_pace" id="edit_bowling_pace" class="modal-select">
                                <option value="">-- None / N/A --</option>
                                <option value="Pace">Pace</option>
                                <option value="Medium">Medium</option>
                                <option value="Slow">Slow</option>
                            </select>
                        </div>

                        <!-- Jersey Number -->
                        <div class="modal-group">
                            <label class="modal-label">Jersey Number</label>
                            <input type="text" name="jersey_number" id="edit_jersey_number" class="modal-input">
                        </div>

                        <!-- Batting Position -->
                        <div class="modal-group">
                            <label class="modal-label">Batting Position</label>
                            <select name="batting_position" id="edit_batting_position" class="modal-select">
                                <option value="">-- Select Order --</option>
                                <option value="Opening">Opening</option>
                                <option value="Top Order">Top Order</option>
                                <option value="Middle Order">Middle Order</option>
                                <option value="Finisher / Lower Order">Finisher / Lower Order</option>
                            </select>
                        </div>

                        <!-- Previous Clubs -->
                        <div class="modal-group full">
                            <label class="modal-label">Previous Clubs / Teams</label>
                            <input type="text" name="previous_clubs" id="edit_previous_clubs" class="modal-input">
                        </div>

                        <!-- Cricket Experience -->
                        <div class="modal-group full">
                            <label class="modal-label">Cricket Experience</label>
                            <input type="text" name="cricket_experience" id="edit_cricket_experience" class="modal-input">
                        </div>

                        <!-- Remarks -->
                        <div class="modal-group full">
                            <label class="modal-label">Remarks / About</label>
                            <textarea name="remarks" id="edit_remarks" class="modal-input"></textarea>
                        </div>

                        <!-- Lock Option in Edit -->
                        <div class="modal-group full" style="flex-direction: row; align-items: center; gap: 0.6rem; margin-top: 0.5rem;">
                            <input type="checkbox" name="is_locked" id="edit_is_locked" value="1" style="width: 18px; height: 18px; cursor: pointer;">
                            <label for="edit_is_locked" class="modal-label" style="cursor: pointer;">
                                🔒 Lock this player's details
                            </label>
                            <input type="hidden" name="force_unlock" id="edit_force_unlock" value="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-action" onclick="closeModal('editPlayerModal')">Cancel</button>
                    <button type="submit" class="btn-add">Update Details</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- MODAL 3: VIEW COMPLETE DETAILS                -->
    <!-- ============================================== -->
    <div class="modal-backdrop" id="viewDetailsModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">🔍 Complete Player Profile</h3>
                <button type="button" class="modal-close" onclick="closeModal('viewDetailsModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.8rem; padding-bottom: 1.2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                    <div id="view_photo_wrap">
                        <img src="" alt="" id="view_photo_img" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #22c55e;">
                    </div>
                    <div>
                        <h2 id="view_name" style="font-size: 1.5rem; font-weight: 800; color: #fff;"></h2>
                        <div id="view_role_badge" style="margin-top: 0.35rem;"></div>
                    </div>
                </div>

                <div class="details-list">
                    <div class="detail-item">
                        <span class="detail-key">Mobile Number</span>
                        <span class="detail-val" id="view_mobile"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Age / Date of Birth</span>
                        <span class="detail-val" id="view_age_dob"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Blood Group</span>
                        <span class="detail-val" id="view_blood"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Education Qualification</span>
                        <span class="detail-val" id="view_education"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Job / Profession</span>
                        <span class="detail-val" id="view_job"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Jersey Number</span>
                        <span class="detail-val" id="view_jersey"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Batting Style</span>
                        <span class="detail-val" id="view_batting"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Bowling Style & Pace</span>
                        <span class="detail-val" id="view_bowling"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Batting Position</span>
                        <span class="detail-val" id="view_batting_pos"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-key">Lock Security Status</span>
                        <span class="detail-val" id="view_lock_status"></span>
                    </div>
                    <div class="detail-item full">
                        <span class="detail-key">Residential Address</span>
                        <span class="detail-val" id="view_address"></span>
                    </div>
                    <div class="detail-item full">
                        <span class="detail-key">Previous Clubs / Teams</span>
                        <span class="detail-val" id="view_clubs"></span>
                    </div>
                    <div class="detail-item full">
                        <span class="detail-key">Cricket Experience</span>
                        <span class="detail-val" id="view_experience"></span>
                    </div>
                    <div class="detail-item full">
                        <span class="detail-key">Remarks / About</span>
                        <span class="detail-val" id="view_remarks" style="white-space: pre-wrap;"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" onclick="closeModal('viewDetailsModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal-backdrop" id="imagePreviewModal" onclick="closeModal('imagePreviewModal')">
        <div style="text-align: center; max-width: 90%; max-height: 90%;">
            <img src="" id="largePreviewImg" style="max-width: 100%; max-height: 80vh; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.8); border: 2px solid rgba(255,255,255,0.2);">
            <div id="largePreviewName" style="color: #fff; font-size: 1.2rem; font-weight: 800; margin-top: 1rem;"></div>
        </div>
    </div>

    <!-- Scripts for Modals and Forms -->
    <script>
        function openAddModal() {
            document.getElementById('addPlayerModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modal when clicking outside of modal card
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-backdrop')) {
                event.target.style.display = 'none';
            }
        };

        // Decode base64 JSON from data-player attribute safely
        function getPlayerData(btn) {
            try {
                const raw = btn.getAttribute('data-player');
                return JSON.parse(decodeURIComponent(escape(atob(raw))));
            } catch (e) {
                console.error("Failed to parse player data", e);
                return {};
            }
        }

        function openDetailsModalFromBtn(btn) {
            const player = getPlayerData(btn);
            openDetailsModal(player);
        }

        function openEditModalFromBtn(btn) {
            const player = getPlayerData(btn);
            openEditModal(player);
        }

        // Open Edit Modal with Pre-populated data
        function openEditModal(player) {
            const form = document.getElementById('editPlayerForm');
            form.action = `/admin/registrations/${player.id}`;

            document.getElementById('edit_name').value = player.name || '';
            document.getElementById('edit_mobile_no').value = player.mobile_no || '';
            document.getElementById('edit_age').value = player.age || '';
            document.getElementById('edit_dob').value = player.dob ? player.dob.substring(0, 10) : '';
            document.getElementById('edit_blood_group').value = player.blood_group || '';
            document.getElementById('edit_education_qualification').value = player.education_qualification || '';
            document.getElementById('edit_job').value = player.job || '';
            document.getElementById('edit_address').value = player.address || '';
            document.getElementById('edit_playing_role').value = player.playing_role || 'Batsman';
            document.getElementById('edit_batting_style').value = player.batting_style || '';
            document.getElementById('edit_bowling_arm').value = player.bowling_arm || '';
            document.getElementById('edit_bowling_pace').value = player.bowling_pace || '';
            document.getElementById('edit_jersey_number').value = player.jersey_number || '';
            document.getElementById('edit_batting_position').value = player.batting_position || '';
            document.getElementById('edit_previous_clubs').value = player.previous_clubs || '';
            document.getElementById('edit_cricket_experience').value = player.cricket_experience || '';
            document.getElementById('edit_remarks').value = player.remarks || '';
            document.getElementById('edit_is_locked').checked = !!player.is_locked;

            const lockWarning = document.getElementById('editLockedWarning');
            if (player.is_locked) {
                lockWarning.style.display = 'block';
            } else {
                lockWarning.style.display = 'none';
            }

            document.getElementById('editPlayerModal').style.display = 'flex';
        }

        // Open View Details Modal
        function openDetailsModal(player) {
            document.getElementById('view_name').innerText = player.name;
            document.getElementById('view_mobile').innerText = player.mobile_no || '-';
            
            const dobStr = player.dob ? new Date(player.dob).toLocaleDateString() : '';
            document.getElementById('view_age_dob').innerText = (player.age ? player.age + ' years' : '-') + (dobStr ? ' (' + dobStr + ')' : '');
            
            document.getElementById('view_blood').innerText = player.blood_group || '-';
            document.getElementById('view_education').innerText = player.education_qualification || '-';
            document.getElementById('view_job').innerText = player.job || '-';
            document.getElementById('view_jersey').innerText = player.jersey_number || '-';
            document.getElementById('view_batting').innerText = player.batting_style || '-';
            document.getElementById('view_bowling').innerText = (player.bowling_arm || '-') + (player.bowling_pace ? ' (' + player.bowling_pace + ')' : '');
            document.getElementById('view_batting_pos').innerText = player.batting_position || '-';
            document.getElementById('view_address').innerText = player.address || '-';
            document.getElementById('view_clubs').innerText = player.previous_clubs || '-';
            document.getElementById('view_experience').innerText = player.cricket_experience || '-';
            document.getElementById('view_remarks').innerText = player.remarks || '-';
            
            document.getElementById('view_lock_status').innerHTML = player.is_locked 
                ? '<span style="color: #ef4444; font-weight: 800;">🔒 LOCKED (Protected)</span>' 
                : '<span style="color: #22c55e; font-weight: 800;">🔓 UNLOCKED (Editable)</span>';

            document.getElementById('view_role_badge').innerHTML = `<span class="role-pill batsman">${player.playing_role}</span>`;

            const img = document.getElementById('view_photo_img');
            if (player.photo) {
                img.src = `/uploads/registrations/${player.photo}`;
                img.style.display = 'block';
            } else {
                img.style.display = 'none';
            }

            document.getElementById('viewDetailsModal').style.display = 'flex';
        }

        function showImageModal(src, name) {
            document.getElementById('largePreviewImg').src = src;
            document.getElementById('largePreviewName').innerText = name;
            document.getElementById('imagePreviewModal').style.display = 'flex';
        }
    </script>
</body>

</html>
