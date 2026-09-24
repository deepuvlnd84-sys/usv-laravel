<style>
    .nav-page-controls {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        z-index: 12;
    }

    .btn-nav-back, .btn-nav-home {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.95rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        font-family: 'Outfit', system-ui, -apple-system, sans-serif;
        line-height: 1;
        white-space: nowrap;
    }

    .btn-nav-back {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .btn-nav-back:hover {
        background: rgba(230, 0, 0, 0.88);
        border-color: #ff3333;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(230, 0, 0, 0.45);
    }

    .btn-nav-home {
        background: rgba(231, 247, 17, 0.15);
        border: 1px solid #e7f711;
        color: #e7f711;
    }

    .btn-nav-home:hover {
        background: #e7f711;
        color: #000000;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(231, 247, 17, 0.45);
    }

    @media (max-width: 600px) {
        .nav-page-controls {
            gap: 0.35rem;
        }
        .btn-nav-back, .btn-nav-home {
            padding: 0.35rem 0.65rem;
            font-size: 0.7rem;
        }
    }
</style>

<div class="nav-page-controls">
    <button type="button" class="btn-nav-back" onclick="if(document.referrer && document.referrer.indexOf(window.location.host) !== -1){ history.back(); } else { window.location.href = '{{ url('/') }}'; }" title="Go Back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
        </svg>
        <span>BACK</span>
    </button>
    <a href="{{ url('/') }}" class="btn-nav-home" title="Return to Home Page">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span>HOME</span>
    </a>
</div>
