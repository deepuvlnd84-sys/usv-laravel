<!-- PWA Web App Manifest & Mobile Meta Tags -->
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#e60000">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="USV">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
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

<!-- Mobile App Architecture & Styling Layer (Active on Mobile Containers & WebViews, Desktop Web Isolated) -->
<style>
    @media (max-width: 768px), display-mode: standalone, (display-mode: standalone) {
        :root {
            -webkit-tap-highlight-color: transparent;
            --sat: env(safe-area-inset-top, 0px);
            --sab: env(safe-area-inset-bottom, 0px);
        }

        html, body {
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
        }

        body {
            font-size: 15px;
            line-height: 1.45;
            -webkit-font-smoothing: antialiased;
            padding-bottom: calc(65px + env(safe-area-inset-bottom, 0px)) !important;
        }

        /* Prevent text highlighting on interactive touch elements */
        button, .btn, .nav-link, .tab-item, .logo, .mobile-topbar-btn {
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        /* Tactile Touch Feedback States */
        button:active,
        .btn:active,
        .nav-link:active,
        .signin-btn:active,
        .btn-hero-about:active,
        .tab-item:active {
            transform: scale(0.96) !important;
            opacity: 0.9 !important;
        }

        /* Native Touch Target Sizes (Minimum 48x48px) */
        button, .btn, .nav-link, .signin-btn {
            min-height: 48px !important;
            box-sizing: border-box;
        }

        /* Mobile Inputs - Prevent iOS Auto-Zoom */
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
            box-sizing: border-box;
        }

        /* Hide Desktop-only Header when Native Mobile App Topbar is active */
        @if($isMobileApp ?? false)
            header.header {
                display: none !important;
            }
        @endif
    }
</style>

<!-- Include Native Mobile Components -->
@include('partials.mobile_top_bar')
@include('partials.mobile_bottom_nav')
@include('partials.mobile_bottom_sheet')

<!-- Pull-To-Refresh Native Touch Script for Mobile App -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth > 768) return;

        let pStart = { x: 0, y: 0 };
        let pCurrent = { x: 0, y: 0 };

        document.body.addEventListener('touchstart', function(e) {
            if (window.scrollY === 0) {
                pStart.x = e.touches[0].screenX;
                pStart.y = e.touches[0].screenY;
            }
        }, { passive: true });

        document.body.addEventListener('touchend', function(e) {
            if (window.scrollY === 0) {
                pCurrent.y = e.changedTouches[0].screenY;
                let changeY = pCurrent.y - pStart.y;
                if (changeY > 160) { // Swiped down from top -> Refresh
                    console.log('Mobile App Pull-to-Refresh triggered');
                    window.location.reload();
                }
            }
        }, { passive: true });
    });
</script>
