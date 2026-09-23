<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Members - UNITED SENIORS VELLANAD</title>
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
            --card-bg: rgba(0, 0, 0, 0.78);
            --transition-speed: 0.25s;
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
            color: #ffffff;
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
            opacity: 0.45;
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
            border: none;
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
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

        /* Main Container */
        .main-container {
            flex: 1;
            padding: 2.5rem 3rem 4rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            z-index: 5;
        }

        /* Header Area */
        .roster-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .roster-title-area h1 {
            font-size: 2.75rem;
            font-weight: 900;
            margin: 0 0 0.4rem 0;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }

        .roster-title-area h1 span {
            color: var(--primary-color);
        }

        .roster-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            letter-spacing: 0.03em;
            margin: 0;
        }

        .members-count-badge {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-end;
            background: rgba(230, 0, 0, 0.12);
            border: 1.5px solid rgba(230, 0, 0, 0.4);
            padding: 0.65rem 1.4rem;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .count-number {
            font-size: 2rem;
            font-weight: 900;
            color: var(--text-color);
            line-height: 1;
        }

        .count-label {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.75);
            text-transform: uppercase;
            margin-top: 0.25rem;
        }

        .btn-add-member {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #e60000 0%, #b80000 100%);
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.88rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(230, 0, 0, 0.4);
            transition: all 0.25s ease;
        }

        .btn-add-member:hover {
            background: linear-gradient(135deg, #ff1a1a 0%, #d60000 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(230, 0, 0, 0.6);
        }

        /* Search Dropdown (Matching drop list) */
        .search-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: rgba(18, 18, 18, 0.98);
            border: 1.5px solid rgba(255, 255, 255, 0.18);
            border-radius: 18px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(20px);
            max-height: 380px;
            overflow-y: auto;
            z-index: 100;
            display: none;
            padding: 0.5rem;
        }

        .search-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .search-dropdown::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .search-dropdown-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            text-decoration: none;
            color: #ffffff;
            transition: background 0.15s, transform 0.15s;
            cursor: pointer;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .search-dropdown-item:last-child {
            border-bottom: none;
        }

        .search-dropdown-item:hover {
            background: rgba(230, 0, 0, 0.22);
            transform: translateX(3px);
        }

        .search-item-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
        }

        .search-item-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e60000, #800000);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 0.85rem;
            color: #fff;
            flex-shrink: 0;
        }

        .search-item-info {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            min-width: 0;
        }

        .search-item-name {
            font-weight: 800;
            font-size: 0.92rem;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-item-call {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-color);
        }

        .search-item-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .search-item-id {
            font-size: 0.72rem;
            font-weight: 800;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            padding: 0.25rem 0.55rem;
            border-radius: 50px;
        }

        .search-item-btn {
            font-size: 0.72rem;
            font-weight: 800;
            background: var(--primary-color);
            color: #ffffff;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: all 0.2s;
        }

        .search-item-btn:hover {
            background: var(--primary-hover);
        }

        /* Action Buttons: PROFILE, EDIT, DEL */
        .col-actions {
            text-align: right;
            white-space: nowrap;
        }

        .actions-cell {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-profile {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.9), rgba(160, 0, 0, 0.95));
            color: #ffffff;
            text-decoration: none;
            font-weight: 800;
            font-size: 0.78rem;
            letter-spacing: 0.06em;
            padding: 0.45rem 1.05rem;
            border-radius: 50px;
            text-transform: uppercase;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(230, 0, 0, 0.35);
        }

        .btn-profile:hover {
            background: #ff1a1a;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(230, 0, 0, 0.6);
            color: #ffffff;
        }

        .btn-table-edit {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 0.42rem 0.85rem;
            border-radius: 50px;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.2s;
        }

        .btn-table-edit:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: #ffffff;
        }

        .btn-table-del {
            display: inline-flex;
            align-items: center;
            background: transparent;
            border: 1px solid rgba(230, 0, 0, 0.5);
            color: #ff6b6b;
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 0.42rem 0.75rem;
            border-radius: 50px;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.2s;
        }

        .btn-table-del:hover {
            background: rgba(230, 0, 0, 0.25);
            color: #ffffff;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 1rem;
        }

        .modal-card {
            background: #181818;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 22px;
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.8);
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
        }

        .modal-title {
            font-size: 1.35rem;
            font-weight: 900;
            color: #ffffff;
            margin: 0;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .modal-close-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.6rem;
            cursor: pointer;
            line-height: 1;
            transition: color 0.2s;
        }

        .modal-close-btn:hover {
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.75);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.45rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1.1rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #ffffff;
            font-family: inherit;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.12);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.85rem;
            margin-top: 1.75rem;
        }

        .btn-cancel {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: none;
            padding: 0.7rem 1.4rem;
            border-radius: 50px;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-save {
            background: var(--primary-color);
            color: #ffffff;
            border: none;
            padding: 0.7rem 1.6rem;
            border-radius: 50px;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s;
        }

        .btn-save:hover {
            background: var(--primary-hover);
        }

        /* Feedback Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        /* Filter & Search Bar */
        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 0.9rem 1.6rem;
            margin-bottom: 2rem;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 280px;
            max-width: 480px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid var(--border-color);
            border-radius: 50px;
            padding: 0.65rem 1.35rem;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-box:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 16px rgba(230, 0, 0, 0.35);
        }

        .search-box input {
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            font-size: 0.95rem;
            width: 100%;
            font-family: inherit;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.45);
        }

        .clear-search-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0 0.2rem;
            line-height: 1;
            transition: color 0.2s;
        }

        .clear-search-btn:hover {
            color: var(--primary-color);
        }

        .view-switch-controls {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .showing-text {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .view-toggle-btns {
            display: inline-flex;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50px;
            padding: 3px;
            border: 1px solid var(--border-color);
        }

        .view-btn {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 0.45rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .view-btn.active {
            background: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.4);
        }

        /* Members Table Container */
        .members-table-container {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            margin-bottom: 2.5rem;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .usv-members-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .usv-members-table th {
            background: rgba(255, 255, 255, 0.04);
            border-bottom: 2px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 1.1rem 1.5rem;
            white-space: nowrap;
        }

        .usv-members-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            vertical-align: middle;
            transition: background 0.15s ease;
        }

        .usv-members-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .usv-members-table tbody tr:hover {
            background: rgba(230, 0, 0, 0.12);
        }

        .usv-members-table tbody tr:last-child td {
            border-bottom: none;
        }

        .sl-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.08);
            padding: 0.25rem 0.65rem;
            border-radius: 8px;
            letter-spacing: 0.04em;
        }

        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(230, 0, 0, 0.2), rgba(230, 0, 0, 0.35));
            border: 1px solid rgba(230, 0, 0, 0.5);
            color: #ff6b6b;
            font-weight: 800;
            font-size: 0.82rem;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            letter-spacing: 0.05em;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .member-name-wrap {
            display: flex;
            align-items: center;
            gap: 0.9rem;
        }

        .member-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e60000 0%, #7a0000 100%);
            color: #ffffff;
            font-weight: 900;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(230, 0, 0, 0.4);
            border: 1.5px solid rgba(231, 247, 17, 0.4);
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .member-avatar.large {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }

        .name-text {
            font-size: 1.05rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .call-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(231, 247, 17, 0.12);
            border: 1px solid rgba(231, 247, 17, 0.4);
            color: var(--text-color);
            font-weight: 800;
            font-size: 0.82rem;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .call-empty {
            color: rgba(255, 255, 255, 0.25);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Members Cards Grid */
        .members-grid-container {
            margin-bottom: 2.5rem;
        }

        .members-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 1.5rem;
        }

        .member-card-item {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 1.35rem 1.4rem;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .member-card-item:hover {
            transform: translateY(-4px);
            border-color: rgba(230, 0, 0, 0.55);
            box-shadow: 0 12px 28px rgba(230, 0, 0, 0.25);
        }

        .card-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-avatar-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-info {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            min-width: 0;
        }

        .card-info .name-text {
            font-size: 1.05rem;
            line-height: 1.3;
            word-break: break-word;
        }

        .club-tag {
            font-size: 0.68rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .card-footer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 0.85rem;
            margin-top: auto;
        }

        .footer-label {
            font-size: 0.72rem;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* No Results Box */
        .no-results-box {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 3.5rem 2rem;
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .no-results-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .no-results-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .no-results-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .btn-reset-search {
            background: var(--primary-color);
            color: #ffffff;
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all var(--transition-speed);
        }

        .btn-reset-search:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .empty-table-cell {
            text-align: center;
            padding: 3rem !important;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }

            .nav-menu {
                gap: 1.25rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .main-container {
                padding: 1.5rem 1.5rem 3rem;
            }

            .roster-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .members-count-badge {
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .roster-title-area h1 {
                font-size: 2.1rem;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-wrapper {
                max-width: 100%;
                min-width: 100%;
            }

            .view-switch-controls {
                justify-content: space-between;
                width: 100%;
            }

            .usv-members-table th, .usv-members-table td {
                padding: 0.85rem 1rem;
            }

            .members-cards-grid {
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
            <a href="{{ route('members') }}" class="nav-link active">MEMBERS</a>
            <a href="{{ route('about') }}" class="nav-link">ABOUT</a>
            <a href="{{ route('tournaments.index') }}" class="nav-link">TOURNAMENTS</a>
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

    <!-- Main Container -->
    <main class="main-container" data-total-members="{{ $totalMembers ?? count($members) }}">
        <!-- Roster Top Bar -->
        <div class="roster-header">
            <div class="roster-title-area">
                <h1>CLUB <span>MEMBERS</span></h1>
                <p class="roster-subtitle">Official members list of United Seniors Vellanad (from USV database)</p>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                @if($isAdmin)
                    <button type="button" class="btn-add-member" onclick="openAddModal()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                        </svg>
                        ADD MEMBER
                    </button>
                @endif
                <div class="members-count-badge">
                    <span class="count-number" id="headerCountBadge">{{ $totalMembers ?? count($members) }}</span>
                    <span class="count-label">Registered Members</span>
                </div>
            </div>
        </div>

        <!-- Feedback Alerts -->
        @if(session('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
                <span style="cursor: pointer;" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger">
                <div>
                    @foreach($errors->all() as $error)
                        <div>&bull; {{ $error }}</div>
                    @endforeach
                </div>
                <span style="cursor: pointer;" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
        @endif

        <!-- Filter and Search Bar -->
        <div class="filter-bar">
            <div class="search-wrapper">
                <div class="search-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="rgba(255, 255, 255, 0.6)">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input type="text" id="memberSearch" placeholder="Search by name, ID or call name..." autocomplete="off" oninput="handleMemberSearch(this.value)" onfocus="if(this.value.trim().length > 0) handleMemberSearch(this.value)">
                    <button type="button" id="clearSearchBtn" class="clear-search-btn" onclick="clearSearch()" style="display: none;" title="Clear Search">&times;</button>
                </div>
                <!-- Search Matching Dropdown -->
                <div id="searchDropdown" class="search-dropdown"></div>
            </div>
            <div class="view-switch-controls">
                <span class="showing-text" id="showingCounter">Showing {{ $totalMembers ?? count($members) }} of {{ $totalMembers ?? count($members) }} members</span>
                <div class="view-toggle-btns">
                    <button type="button" class="view-btn active" id="btnViewTable" onclick="switchView('table')" title="Table View">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/>
                        </svg>
                        Table
                    </button>
                    <button type="button" class="view-btn" id="btnViewGrid" onclick="switchView('grid')" title="Cards View">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h4v4H4V4zm6 0h4v4h-4V4zm6 0h4v4h-4V4zM4 10h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4zM4 16h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4z"/>
                        </svg>
                        Cards
                    </button>
                </div>
            </div>
        </div>

        <!-- MEMBERS TABLE VIEW (Default) -->
        <div class="members-table-container" id="membersTableView">
            <div class="table-responsive">
                <table class="usv-members-table">
                    <thead>
                        <tr>
                            <th class="col-sl">SL NO</th>
                            <th class="col-id">MEMBER ID</th>
                            <th class="col-name">MEMBER NAME</th>
                            <th class="col-call">CALL NAME</th>
                            <th class="col-actions">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="membersTableBody">
                        @forelse($members as $member)
                            <tr class="member-row" data-name="{{ strtolower($member->name) }}" data-id="{{ $member->member_id }}" data-call="{{ strtolower($member->call_name ?? '') }}" data-sl="{{ $member->sl_no }}" data-fullname="{{ $member->name }}" data-callname="{{ $member->call_name }}">
                                <td class="col-sl">
                                    <span class="sl-badge">#{{ $member->sl_no }}</span>
                                </td>
                                <td class="col-id">
                                    <span class="id-badge">ID: {{ $member->member_id }}</span>
                                </td>
                                <td class="col-name">
                                    <div class="member-name-wrap">
                                        <div class="member-avatar">{{ substr($member->name, 0, 1) }}</div>
                                        <span class="name-text">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td class="col-call">
                                    @if(!empty(trim($member->call_name ?? '')))
                                        <span class="call-badge">{{ $member->call_name }}</span>
                                    @else
                                        <span class="call-empty">—</span>
                                    @endif
                                </td>
                                <td class="col-actions">
                                    <div class="actions-cell">
                                        <a href="{{ route('members.profile', $member->sl_no) }}" class="btn-profile" title="View Member Profile">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                            PROFILE
                                        </a>
                                        @if($isAdmin)
                                            <button type="button" class="btn-table-edit" onclick="handleEditBtn(this)" title="Edit Member">
                                                EDIT
                                            </button>
                                            <form action="{{ route('members.destroy', $member->sl_no) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete member {{ addslashes($member->name) }} (ID: {{ $member->member_id }}) from usv_members?');" style="margin: 0; display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-table-del" title="Delete Member">DEL</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-table-cell">No members found in usv_members database table.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MEMBERS GRID VIEW (Toggled) -->
        <div class="members-grid-container" id="membersGridView" style="display: none;">
            <div class="members-cards-grid" id="membersCardsGrid">
                @foreach($members as $member)
                    <div class="member-card-item" data-name="{{ strtolower($member->name) }}" data-id="{{ $member->member_id }}" data-call="{{ strtolower($member->call_name ?? '') }}" data-sl="{{ $member->sl_no }}" data-fullname="{{ $member->name }}" data-callname="{{ $member->call_name }}">
                        <div class="card-header-bar">
                            <span class="sl-badge">#{{ $member->sl_no }}</span>
                            <span class="id-badge">ID: {{ $member->member_id }}</span>
                        </div>
                        <div class="card-avatar-row">
                            <div class="member-avatar large">{{ substr($member->name, 0, 1) }}</div>
                            <div class="card-info">
                                <h3 class="name-text">{{ $member->name }}</h3>
                                <div class="club-tag">UNITED SENIORS VELLANAD</div>
                            </div>
                        </div>
                        <div class="card-footer-bar">
                            <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                                <span class="footer-label">CALL NAME</span>
                                @if(!empty(trim($member->call_name ?? '')))
                                    <span class="call-badge">{{ $member->call_name }}</span>
                                @else
                                    <span class="call-empty">—</span>
                                @endif
                            </div>
                            <div class="actions-cell">
                                <a href="{{ route('members.profile', $member->sl_no) }}" class="btn-profile">PROFILE</a>
                                @if($isAdmin)
                                    <button type="button" class="btn-table-edit" onclick="handleEditBtn(this)" title="Edit Member">EDIT</button>
                                    <form action="{{ route('members.destroy', $member->sl_no) }}" method="POST" onsubmit="return confirm('Delete member {{ addslashes($member->name) }}?');" style="margin: 0; display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-table-del">DEL</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- No Results Fallback -->
        <div id="noResultsState" class="no-results-box" style="display: none;">
            <div class="no-results-icon">🔍</div>
            <div class="no-results-title">No matching members found</div>
            <div class="no-results-desc">No registered club member matched your search query.</div>
            <button type="button" class="btn-reset-search" onclick="clearSearch()">View All Members</button>
        </div>
    </main>

    @if($isAdmin)
        <!-- Add Member Modal -->
        <div id="addMemberModal" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 class="modal-title">Add New Member</h3>
                    <button type="button" class="modal-close-btn" onclick="closeAddModal()">&times;</button>
                </div>
                <form action="{{ route('members.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Member ID *</label>
                        <input type="number" name="member_id" class="form-control" placeholder="e.g. 1175" required value="{{ old('member_id') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Member Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="Full name of member" required maxlength="150" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Call / Known Name (Optional)</label>
                        <input type="text" name="call_name" class="form-control" placeholder="e.g. Deepu" maxlength="100" value="{{ old('call_name') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Serial Number (Optional)</label>
                        <input type="number" name="sl_no" class="form-control" placeholder="Auto-assigned if left blank" value="{{ old('sl_no') }}">
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeAddModal()">Cancel</button>
                        <button type="submit" class="btn-save">Save to usv_members</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Member Modal -->
        <div id="editMemberModal" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Member Details</h3>
                    <button type="button" class="modal-close-btn" onclick="closeEditModal()">&times;</button>
                </div>
                <form id="editMemberForm" action="{{ route('members.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Serial No (SL NO)</label>
                        <input type="text" id="edit_sl_no_display" class="form-control" readonly style="opacity: 0.6; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Member ID *</label>
                        <input type="number" id="edit_member_id" name="member_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Member Name *</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required maxlength="150">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Call / Known Name (Optional)</label>
                        <input type="text" id="edit_call_name" name="call_name" class="form-control" maxlength="100">
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-save">Update Member</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Embedded Search Dataset -->
    <script id="membersSearchData" type="application/json">{!! json_encode($searchMembers ?? []) !!}</script>

    <!-- Interactive Client Scripts -->
    <script>
        const mainContainerEl = document.querySelector('.main-container');
        const totalMemberCount = parseInt((mainContainerEl && mainContainerEl.getAttribute('data-total-members')) || '0', 10);
        let currentView = 'table';

        // Preload members for instantaneous dropdown search
        const membersDataEl = document.getElementById('membersSearchData');
        const memberList = membersDataEl ? JSON.parse(membersDataEl.textContent || '[]') : [];

        // Switch View between Table and Grid
        function switchView(view) {
            currentView = view;
            const tableView = document.getElementById('membersTableView');
            const gridView = document.getElementById('membersGridView');
            const btnTable = document.getElementById('btnViewTable');
            const btnGrid = document.getElementById('btnViewGrid');

            if (view === 'table') {
                tableView.style.display = 'block';
                gridView.style.display = 'none';
                btnTable.classList.add('active');
                btnGrid.classList.remove('active');
            } else {
                tableView.style.display = 'none';
                gridView.style.display = 'block';
                btnGrid.classList.add('active');
                btnTable.classList.remove('active');
            }
        }

        // Live Filter Functionality with Matching Dropdown
        function handleMemberSearch(query) {
            const val = (query || '').toLowerCase().trim();
            const clearBtn = document.getElementById('clearSearchBtn');
            const counter = document.getElementById('showingCounter');
            const noResults = document.getElementById('noResultsState');
            const tableView = document.getElementById('membersTableView');
            const gridView = document.getElementById('membersGridView');
            const dropdown = document.getElementById('searchDropdown');

            if (clearBtn) {
                clearBtn.style.display = val.length > 0 ? 'inline-block' : 'none';
            }

            // Populate Matching Dropdown
            if (dropdown) {
                if (val.length > 0) {
                    const matches = memberList.filter(m => {
                        const n = (m.name || '').toLowerCase();
                        const c = (m.call_name || '').toLowerCase();
                        const id = String(m.member_id || '');
                        const sl = String(m.sl_no || '');
                        return n.includes(val) || c.includes(val) || id.includes(val) || sl.includes(val);
                    }).slice(0, 10);

                    if (matches.length > 0) {
                        let html = '';
                        matches.forEach(m => {
                            const callBadge = m.call_name ? `<span class="search-item-call">(${escapeHtml(m.call_name)})</span>` : '';
                            html += `
                                <div class="search-dropdown-item" onclick="window.location.href='${m.profile_url}'">
                                    <div class="search-item-left">
                                        <div class="search-item-avatar">${(m.name || 'U').charAt(0).toUpperCase()}</div>
                                        <div class="search-item-info">
                                            <div class="search-item-name">${highlightMatch(m.name, val)} ${callBadge}</div>
                                        </div>
                                    </div>
                                    <div class="search-item-right">
                                        <span class="search-item-id">ID: ${m.member_id}</span>
                                        <a href="${m.profile_url}" class="search-item-btn" onclick="event.stopPropagation();">
                                            PROFILE
                                        </a>
                                    </div>
                                </div>
                            `;
                        });
                        dropdown.innerHTML = html;
                        dropdown.style.display = 'block';
                    } else {
                        dropdown.innerHTML = `<div style="padding: 1rem; text-align: center; color: rgba(255,255,255,0.5); font-size: 0.88rem;">No members matching "${escapeHtml(val)}"</div>`;
                        dropdown.style.display = 'block';
                    }
                } else {
                    dropdown.style.display = 'none';
                    dropdown.innerHTML = '';
                }
            }

            // Filter Table and Cards
            const rows = document.querySelectorAll('.member-row');
            const cards = document.querySelectorAll('.member-card-item');
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const id = row.getAttribute('data-id') || '';
                const call = row.getAttribute('data-call') || '';
                const sl = row.getAttribute('data-sl') || '';

                const matches = val === '' || name.includes(val) || id.includes(val) || call.includes(val) || sl.includes(val);

                if (matches) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const id = card.getAttribute('data-id') || '';
                const call = card.getAttribute('data-call') || '';
                const sl = card.getAttribute('data-sl') || '';

                const matches = val === '' || name.includes(val) || id.includes(val) || call.includes(val) || sl.includes(val);

                if (matches) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            if (counter) {
                counter.textContent = `Showing ${visibleCount} of ${totalMemberCount} members`;
            }

            if (visibleCount === 0) {
                noResults.style.display = 'block';
                if (tableView) tableView.style.display = 'none';
                if (gridView) gridView.style.display = 'none';
            } else {
                noResults.style.display = 'none';
                if (currentView === 'table') {
                    if (tableView) tableView.style.display = 'block';
                    if (gridView) gridView.style.display = 'none';
                } else {
                    if (tableView) tableView.style.display = 'none';
                    if (gridView) gridView.style.display = 'block';
                }
            }
        }

        function highlightMatch(text, query) {
            if (!query) return escapeHtml(text);
            const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            return escapeHtml(text).replace(regex, '<span style="color: var(--text-color); font-weight: 900; text-decoration: underline;">$1</span>');
        }

        function escapeHtml(str) {
            return String(str || '').replace(/[&<>"']/g, function (m) {
                return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'}[m];
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const searchWrapper = document.querySelector('.search-wrapper');
            const dropdown = document.getElementById('searchDropdown');
            if (dropdown && searchWrapper && !searchWrapper.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Clear Search
        function clearSearch() {
            const input = document.getElementById('memberSearch');
            if (input) {
                input.value = '';
                input.focus();
            }
            handleMemberSearch('');
        }

        // Modal Helpers
        function openAddModal() {
            const modal = document.getElementById('addMemberModal');
            if (modal) modal.style.display = 'flex';
        }
        function closeAddModal() {
            const modal = document.getElementById('addMemberModal');
            if (modal) modal.style.display = 'none';
        }
        function openEditModal(sl, id, name, call) {
            const modal = document.getElementById('editMemberModal');
            const form = document.getElementById('editMemberForm');
            if (modal && form) {
                form.action = `/members/${sl}`;
                document.getElementById('edit_sl_no_display').value = '#' + sl;
                document.getElementById('edit_member_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_call_name').value = call || '';
                modal.style.display = 'flex';
            }
        }
        function closeEditModal() {
            const modal = document.getElementById('editMemberModal');
            if (modal) modal.style.display = 'none';
        }
        function handleEditBtn(btn) {
            if (!btn) return;
            const item = btn.closest('.member-row') || btn.closest('.member-card-item');
            if (!item) return;
            const sl = item.getAttribute('data-sl');
            const id = item.getAttribute('data-id');
            const name = item.getAttribute('data-fullname') || '';
            const call = item.getAttribute('data-callname') || '';
            openEditModal(sl, id, name, call);
        }
        window.addEventListener('click', function(e) {
            const addModal = document.getElementById('addMemberModal');
            const editModal = document.getElementById('editMemberModal');
            if (e.target === addModal) closeAddModal();
            if (e.target === editModal) closeEditModal();
        });
    </script>
</body>
</html>
