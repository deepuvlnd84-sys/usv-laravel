<!-- PWA Web App Manifest & Mobile Meta Tags -->
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#e60000">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="USV">
<link rel="apple-touch-icon" href="{{ asset('icon-192.png') }}">
<link rel="apple-touch-icon" sizes="512x512" href="{{ asset('icon-512.png') }}">

<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register("{{ asset('sw.js') }}")
        .then(function(reg) {
          console.log('PWA Service Worker registered successfully:', reg.scope);
        })
        .catch(function(err) {
          console.log('PWA Service Worker registration failed:', err);
        });
    });
  }
</script>

<!-- Mobile App Compatible Styling Layer (Active on Mobile Screens, Web Desktop View Preserved) -->
<style>
    @media (max-width: 768px) {
        :root {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-size: 15px;
            line-height: 1.45;
            -webkit-font-smoothing: antialiased;
        }

        /* Mobile App Header & Sticky Navigation Bar */
        .header {
            padding: 0.85rem 1rem !important;
            gap: 0.75rem !important;
            flex-wrap: wrap !important;
            position: sticky !important;
            top: 0 !important;
            background: rgba(12, 12, 12, 0.94) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12) !important;
            z-index: 1000 !important;
        }

        .logo-img {
            width: 40px !important;
            height: 38px !important;
        }

        .logo-text {
            font-size: 0.95rem !important;
        }

        .nav-menu {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
            padding: 0.35rem 0.1rem 0.55rem 0.1rem !important;
            gap: 0.5rem !important;
            scrollbar-width: none !important;
        }

        .nav-menu::-webkit-scrollbar {
            display: none !important;
        }

        .nav-link, 
        .nav-dropdown-toggle {
            font-size: 0.82rem !important;
            padding: 0.55rem 1rem !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
            min-height: 42px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            touch-action: manipulation !important;
            border-radius: 25px !important;
        }

        /* Tactile Touch Button Animation for Mobile App feel */
        .nav-link:active,
        .nav-dropdown-toggle:active,
        .signin-btn:active,
        .btn-hero-about:active,
        .btn-add-member:active,
        .btn-profile:active,
        .btn-table-edit:active,
        .btn-table-del:active,
        .btn-save:active,
        .btn-cancel:active,
        .search-item-btn:active,
        .btn-reset-search:active,
        button:active,
        .btn:active {
            transform: scale(0.96) !important;
            opacity: 0.9 !important;
        }

        .auth-menu {
            margin-left: auto !important;
        }

        .signin-btn {
            font-size: 0.78rem !important;
            padding: 0.5rem 1rem !important;
            min-height: 38px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 25px !important;
        }

        /* Mobile Container Padding */
        .main-container,
        .main-content,
        .home-sections-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        /* Mobile App Typography Scaling */
        h1, .title {
            font-size: clamp(1.75rem, 7vw, 2.4rem) !important;
            line-height: 1.15 !important;
            letter-spacing: -0.01em !important;
        }

        h2, .section-title {
            font-size: 1.35rem !important;
        }

        h3 {
            font-size: 1.15rem !important;
        }

        /* Mobile Touch Inputs - Prevent iOS Auto-zoom */
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select,
        textarea {
            font-size: 16px !important;
            padding: 0.75rem 1rem !important;
            border-radius: 12px !important;
        }

        /* Mobile Table Touch Scroll */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            border-radius: 14px;
        }

        .usv-members-table th,
        .usv-members-table td {
            padding: 0.75rem 0.85rem !important;
            font-size: 0.85rem !important;
        }

        /* Mobile App Modals */
        .modal-card {
            padding: 1.25rem !important;
            border-radius: 18px !important;
            max-width: 94vw !important;
        }

        .modal-actions {
            flex-direction: column-reverse !important;
            gap: 0.5rem !important;
        }

        .modal-actions button,
        .modal-actions .btn {
            width: 100% !important;
            min-height: 46px !important;
        }
    }

    /* Global Navigation Back & Home Buttons for Sub-Pages */
    .header-nav-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .btn-nav-back, .btn-nav-home {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: linear-gradient(135deg, rgba(230, 0, 0, 0.25) 0%, rgba(150, 0, 0, 0.4) 100%);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.45rem 0.85rem;
        border-radius: 50px;
        border: 1.5px solid rgba(230, 0, 0, 0.5);
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        font-family: inherit;
        line-height: 1;
    }

    .btn-nav-home {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.25) 0%, rgba(22, 101, 52, 0.4) 100%);
        border-color: rgba(34, 197, 94, 0.5);
    }

    .btn-nav-back:hover {
        background: linear-gradient(135deg, #e60000 0%, #b80000 100%);
        border-color: #ff4d4d;
        color: #ffffff;
        transform: translateX(-2px);
        box-shadow: 0 6px 16px rgba(230, 0, 0, 0.5);
    }

    .btn-nav-home:hover {
        background: linear-gradient(135deg, #15803d 0%, #0b532b 100%);
        border-color: #22c55e;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(34, 197, 94, 0.5);
    }

    @media (max-width: 768px) {
        .header-nav-actions {
            margin-left: 0.25rem;
            gap: 0.35rem;
        }
        .btn-nav-back, .btn-nav-home {
            font-size: 0.72rem !important;
            padding: 0.35rem 0.65rem !important;
            min-height: 34px !important;
        }
    }
</style>

