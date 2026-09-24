<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gallery - UNITED SENIORS VELLANAD</title>
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
            cursor: pointer;
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
            gap: 1.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-link,
        .nav-dropdown-toggle {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            position: relative;
            padding: 0.35rem 0;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: transparent;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: color var(--transition-speed);
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

        .nav-link:hover, .nav-link.active,
        .nav-dropdown-toggle:hover {
            color: var(--primary-color);
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }

        .nav-dropdown-wrap {
            position: relative;
            display: inline-block;
        }

        .nav-dropdown-wrap:hover .nav-dropdown-menu {
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
            min-width: 220px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
            z-index: 100;
        }

        .nav-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.65rem 0.9rem;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 700;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .nav-dropdown-item:hover {
            background: rgba(230, 0, 0, 0.2);
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

        /* Main Container */
        .main-container {
            flex: 1;
            padding: 2.5rem 3rem 4rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            z-index: 5;
        }

        .gallery-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .gallery-title-area h1 {
            font-size: 2.75rem;
            font-weight: 900;
            margin: 0 0 0.4rem 0;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #ffffff;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }

        .gallery-title-area h1 span {
            color: var(--primary-color);
        }

        .gallery-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            letter-spacing: 0.03em;
            margin: 0;
        }

        /* Filter Chips */
        .filter-strip {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            padding: 0.85rem 1.25rem;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            width: fit-content;
        }

        .filter-chip {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-color);
            color: rgba(255, 255, 255, 0.75);
            padding: 0.5rem 1.1rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: all var(--transition-speed);
            letter-spacing: 0.04em;
        }

        .filter-chip:hover, .filter-chip.active {
            background: var(--primary-color);
            color: #ffffff;
            border-color: var(--primary-color);
            transform: translateY(-1px);
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 2rem;
        }

        .gallery-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform var(--transition-speed), border-color var(--transition-speed), box-shadow var(--transition-speed);
            cursor: pointer;
            position: relative;
        }

        .gallery-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary-color);
            box-shadow: 0 16px 36px rgba(230, 0, 0, 0.25);
        }

        .gallery-media {
            position: relative;
            width: 100%;
            height: 230px;
            background: linear-gradient(135deg, rgba(30, 30, 30, 0.8) 0%, rgba(10, 10, 10, 0.95) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .gallery-placeholder-icon {
            font-size: 3.5rem;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.6));
            transition: transform 0.3s ease;
        }

        .gallery-card:hover .gallery-placeholder-icon {
            transform: scale(1.15) rotate(5deg);
        }

        .gallery-tag-pill {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--primary-color);
            color: #ffffff;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .gallery-body {
            padding: 1.4rem;
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: space-between;
        }

        .gallery-item-title {
            font-size: 1.2rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            color: #ffffff;
            letter-spacing: 0.02em;
        }

        .gallery-item-desc {
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.45;
            margin: 0;
        }

        .gallery-footer {
            margin-top: 1rem;
            padding-top: 0.85rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.45);
        }

        .gallery-view-hint {
            color: var(--text-color);
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Modal Lightbox */
        .lightbox-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.88);
            backdrop-filter: blur(14px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.25s ease;
            padding: 2rem;
        }

        .lightbox-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .lightbox-card {
            background: #181818;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            max-width: 600px;
            width: 100%;
            padding: 2.2rem;
            position: relative;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
            transform: scale(0.95);
            transition: transform 0.25s ease;
            text-align: center;
        }

        .lightbox-modal.active .lightbox-card {
            transform: scale(1);
        }

        .lightbox-close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #ffffff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .lightbox-close-btn:hover {
            background: var(--primary-color);
        }

        .lightbox-badge {
            font-size: 5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .lightbox-title {
            font-size: 1.6rem;
            font-weight: 900;
            margin: 0 0 0.75rem 0;
            color: #ffffff;
            text-transform: uppercase;
        }

        .lightbox-desc {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.5;
            margin: 0 0 1.5rem 0;
        }

        .lightbox-btn {
            background: var(--primary-color);
            color: #ffffff;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 800;
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: none;
            cursor: pointer;
        }

        .lightbox-btn:hover {
            background: var(--primary-hover);
        }

        @media (max-width: 992px) {
            .header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                gap: 1rem;
            }
            .nav-menu {
                justify-content: center;
            }
            .main-container {
                padding: 1.5rem 1.5rem 3rem;
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

            <a href="{{ route('gallery') }}" class="nav-link active">GALLERY</a>
            <a href="{{ route('register.create') }}" class="nav-link">REGISTER</a>
            <a href="{{ route('contact') }}" class="nav-link">CONTACT</a>
            @if(Session::has('authenticated_user'))
                <a href="{{ route('dashboard') }}" class="nav-link">DASHBOARD</a>
            @endif
        </nav>
        <div class="auth-menu">
            <a href="{{ route('login') }}" class="signin-btn">SIGN IN</a>
        </div>
    </header>

    <!-- Main Container -->
    <main class="main-container">
        <div class="gallery-header">
            <div class="gallery-title-area">
                <h1>CLUB & TOURNAMENT <span>GALLERY</span></h1>
                <p class="gallery-subtitle">Relive the proud moments, championships, and celebrations of United Seniors Vellanad</p>
            </div>
        </div>

        <!-- Filter Chips -->
        <div class="filter-strip">
            <button type="button" class="filter-chip active" onclick="filterCategory('ALL', this)">All</button>
            <button type="button" class="filter-chip" onclick="filterCategory('TOURNAMENTS', this)">Tournaments</button>
            <button type="button" class="filter-chip" onclick="filterCategory('MATCHES', this)">Matches</button>
            <button type="button" class="filter-chip" onclick="filterCategory('CELEBRATIONS', this)">Celebrations</button>
            <button type="button" class="filter-chip" onclick="filterCategory('AWARDS', this)">Awards</button>
            <button type="button" class="filter-chip" onclick="filterCategory('TRAINING', this)">Training</button>
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid" id="galleryGrid">
            @foreach($galleryItems as $item)
                <div class="gallery-card" 
                     data-category="{{ $item['category'] }}"
                     data-title="{{ $item['title'] }}"
                     data-desc="{{ $item['desc'] }}"
                     data-tag="{{ $item['tag'] }}"
                     onclick="handleGalleryCardClick(this)">
                    <div class="gallery-media">
                        @if($item['category'] === 'TOURNAMENTS')
                            <span class="gallery-placeholder-icon">🏆</span>
                        @elseif($item['category'] === 'MATCHES')
                            <span class="gallery-placeholder-icon">🏏</span>
                        @elseif($item['category'] === 'CELEBRATIONS')
                            <span class="gallery-placeholder-icon">🎉</span>
                        @elseif($item['category'] === 'AWARDS')
                            <span class="gallery-placeholder-icon">🥇</span>
                        @else
                            <span class="gallery-placeholder-icon">⚡</span>
                        @endif
                        <span class="gallery-tag-pill">{{ $item['tag'] }}</span>
                    </div>
                    <div class="gallery-body">
                        <div>
                            <h3 class="gallery-item-title">{{ $item['title'] }}</h3>
                            <p class="gallery-item-desc">{{ $item['desc'] }}</p>
                        </div>
                        <div class="gallery-footer">
                            <span>USV Vellanad • {{ $item['date'] }}</span>
                            <span class="gallery-view-hint">View Moment &rarr;</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <!-- Lightbox Modal -->
    <div class="lightbox-modal" id="lightboxModal" onclick="closeLightboxOnBackdrop(event)">
        <div class="lightbox-card">
            <button type="button" class="lightbox-close-btn" onclick="closeLightbox()">&times;</button>
            <span class="lightbox-badge" id="modalBadge">🏆</span>
            <div id="modalPill" style="display: inline-block; background: var(--primary-color); color: #fff; padding: 0.25rem 0.8rem; border-radius: 50px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.75rem;"></div>
            <h3 class="lightbox-title" id="modalTitle"></h3>
            <p class="lightbox-desc" id="modalDesc"></p>
            <button type="button" class="lightbox-btn" onclick="closeLightbox()">Close Preview</button>
        </div>
    </div>

    <script>
        function filterCategory(category, btn) {
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');

            const cards = document.querySelectorAll('.gallery-card');
            cards.forEach(card => {
                if (category === 'ALL' || card.getAttribute('data-category') === category) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function handleGalleryCardClick(card) {
            const title = card.getAttribute('data-title') || '';
            const desc = card.getAttribute('data-desc') || '';
            const tag = card.getAttribute('data-tag') || '';
            const category = card.getAttribute('data-category') || '';
            openLightbox(title, desc, tag, category);
        }

        function openLightbox(title, desc, tag, category) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalDesc').textContent = desc;
            document.getElementById('modalPill').textContent = tag;

            const iconMap = {
                'TOURNAMENTS': '🏆',
                'MATCHES': '🏏',
                'CELEBRATIONS': '🎉',
                'AWARDS': '🥇',
                'TRAINING': '⚡'
            };
            document.getElementById('modalBadge').textContent = iconMap[category] || '📸';

            document.getElementById('lightboxModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightboxModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function closeLightboxOnBackdrop(e) {
            if (e.target === document.getElementById('lightboxModal')) {
                closeLightbox();
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>
</body>
</html>
