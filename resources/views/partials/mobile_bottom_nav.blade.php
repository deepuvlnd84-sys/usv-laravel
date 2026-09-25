<!-- Native Mobile Persistent Bottom Tab Bar (Scoped for Mobile App Containers) -->
<style>
    .mobile-bottom-tabbar {
        display: none;
    }

    @media (max-width: 768px), display-mode: standalone, (display-mode: standalone) {
        .mobile-bottom-tabbar {
            display: flex;
            align-items: center;
            justify-content: space-around;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 995;
            background: rgba(14, 14, 14, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            padding: 0.45rem 0.5rem calc(0.45rem + env(safe-area-inset-bottom, 0px)) 0.5rem;
            box-shadow: 0 -5px 25px rgba(0, 0, 0, 0.5);
            user-select: none;
            -webkit-user-select: none;
        }

        .tab-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            gap: 0.2rem;
            padding: 0.35rem 0.6rem;
            border-radius: 12px;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            -webkit-tap-highlight-color: transparent;
            min-width: 58px;
        }

        .tab-icon {
            font-size: 1.25rem;
            line-height: 1;
            transition: transform 0.25s ease, color 0.25s ease;
        }

        .tab-item.active {
            color: #ffffff;
            background: rgba(230, 0, 0, 0.2);
            border: 1px solid rgba(230, 0, 0, 0.4);
            box-shadow: 0 4px 12px rgba(230, 0, 0, 0.3);
        }

        .tab-item.active .tab-icon {
            transform: translateY(-2px) scale(1.15);
            color: var(--text-color, #e7f711);
        }

        .tab-item:active {
            transform: scale(0.92);
        }
    }
</style>

<div class="mobile-bottom-tabbar">
    <a href="{{ url('/') }}" class="tab-item {{ Request::is('/') ? 'active' : '' }}">
        <span class="tab-icon">🏠</span>
        <span>HOME</span>
    </a>

    <a href="{{ route('members') }}" class="tab-item {{ Request::is('members*') || Request::is('players*') ? 'active' : '' }}">
        <span class="tab-icon">👥</span>
        <span>MEMBERS</span>
    </a>

    <a href="{{ route('tournaments.index') }}" class="tab-item {{ Request::is('tournaments*') ? 'active' : '' }}">
        <span class="tab-icon">🏆</span>
        <span>MATCHES</span>
    </a>

    <a href="{{ route('gallery') }}" class="tab-item {{ Request::is('gallery*') ? 'active' : '' }}">
        <span class="tab-icon">🖼️</span>
        <span>GALLERY</span>
    </a>

    <a href="{{ route('contact') }}" class="tab-item {{ Request::is('contact*') ? 'active' : '' }}">
        <span class="tab-icon">📞</span>
        <span>CONTACT</span>
    </a>
</div>
