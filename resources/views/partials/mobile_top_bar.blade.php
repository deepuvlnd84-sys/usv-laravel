<!-- Native Mobile Top App Bar (Scoped for Mobile App Clients, Isolated from Desktop) -->
<style>
    .mobile-app-topbar {
        display: none;
    }

    @media (max-width: 768px), display-mode: standalone, (display-mode: standalone) {
        .mobile-app-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            z-index: 990;
            background: rgba(14, 14, 14, 0.94);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            padding: calc(0.65rem + env(safe-area-inset-top, 0px)) 1rem 0.65rem 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            user-select: none;
            -webkit-user-select: none;
        }

        .mobile-topbar-left,
        .mobile-topbar-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 44px;
        }

        .mobile-topbar-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #ffffff;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            -webkit-tap-highlight-color: transparent;
        }

        .mobile-topbar-btn:active {
            transform: scale(0.92);
            background: rgba(230, 0, 0, 0.3);
            border-color: var(--primary-color, #e60000);
        }

        .mobile-topbar-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            text-align: center;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .mobile-topbar-title img {
            height: 24px;
            width: auto;
        }
    }
</style>

<nav class="mobile-app-topbar">
    <div class="mobile-topbar-left">
        @if(Request::is('/'))
            <a href="{{ url('/') }}" class="mobile-topbar-btn" title="USV Home">
                <img src="{{ asset('usv-logo.png') }}" alt="Logo" style="height: 22px; width: auto;">
            </a>
        @else
            <button type="button" class="mobile-topbar-btn" onclick="if(document.referrer && document.referrer.indexOf(window.location.host) !== -1){ history.back(); } else { window.location.href = '{{ url('/') }}'; }" title="Back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
            </button>
        @endif
    </div>

    <div class="mobile-topbar-title">
        @yield('page_title', 'UNITED SENIORS VELLANAD')
    </div>

    <div class="mobile-topbar-right">
        <a href="{{ route('members') }}" class="mobile-topbar-btn" title="Search Members">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
            </svg>
        </a>
    </div>
</nav>
