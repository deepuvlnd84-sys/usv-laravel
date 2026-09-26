@php
    $settings = $settings ?? \App\Models\ContactSetting::first() ?? new \App\Models\ContactSetting([
        'facebook_url' => 'https://www.facebook.com/unitedseniorsvellanad',
        'instagram_url' => 'https://instagram.com/unitedseniorsvellanad',
        'youtube_url' => 'https://www.youtube.com/@UnitedSeniorsVellanad',
        'club_email' => 'unitedseniorsvellanadans@gmail.com',
        'club_phone' => '094478 89502',
        'ground_location' => 'H345+JF, Vellanad, Keralam 695543',
        'ground_map_url' => 'https://www.google.com/maps/place/Viswanathan+Memorial+Panchayath+Stadium,+Vellanad/@8.5565815,77.0396807,15z/data=!4m10!1m2!2m1!1sground+Vellanad!3m6!1s0x3b05b700298dfee1:0xce52ac8e1571f9d!8m2!3d8.5565815!4d77.0587351!15sCg9ncm91bmQgVmVsbGFuYWRaESIPZ3JvdW5kIHZlbGxhbmFkkgEKcGxheWdyb3VuZJoBRENpOURRVWxSUVVOdlpFTm9kSGxqUmpsdlQycGFRMU5FVmxwT2EyUklZbnBzTlZsWWFHWk5WR1F5V1c1T2JrNUlZeEFC4AEA-gEECAAQOw!16s%2Fg%2F11wqkkrh2d?entry=ttu&g_ep=EgoyMDI2MDkyMy4wIKXMDSoASAFQAw%3D%3D',
    ]);
@endphp

<style>
    /* Connect With United Seniors Vellanad Shared Component Styles */
    .social-section {
        background: linear-gradient(135deg, rgba(20, 20, 20, 0.96), rgba(35, 10, 10, 0.96));
        border: 1px solid rgba(230, 0, 0, 0.35);
        border-radius: 28px;
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.75), 0 0 35px rgba(230, 0, 0, 0.18);
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 1100px;
        margin: 3rem auto 2rem auto;
        box-sizing: border-box;
    }

    .social-title {
        font-size: clamp(1.5rem, 4vw, 2.2rem);
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #ffffff;
        margin: 0 0 0.5rem 0;
    }

    .social-title span {
        color: var(--primary-color, #e60000);
    }

    .social-desc {
        color: rgba(255, 255, 255, 0.75);
        font-size: 0.92rem;
        margin: 0 0 2.2rem 0;
    }

    .direct-contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
        margin: 0 auto 2.2rem auto;
        max-width: 1050px;
        text-align: left;
    }

    .contact-card-item {
        display: flex;
        align-items: center;
        gap: 1.1rem;
        padding: 1.1rem 1.3rem;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 18px;
        text-decoration: none;
        color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        backdrop-filter: blur(8px);
    }

    .contact-card-item:hover {
        background: rgba(230, 0, 0, 0.1);
        border-color: rgba(230, 0, 0, 0.5);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(230, 0, 0, 0.25);
    }

    .contact-card-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-card-icon-wrap.email {
        background: linear-gradient(135deg, rgba(234, 67, 53, 0.25), rgba(180, 40, 30, 0.35));
        color: #ff5252;
        border: 1px solid rgba(234, 67, 53, 0.4);
    }

    .contact-card-icon-wrap.phone {
        background: linear-gradient(135deg, rgba(52, 168, 83, 0.25), rgba(30, 130, 60, 0.35));
        color: #2ecc71;
        border: 1px solid rgba(52, 168, 83, 0.4);
    }

    .contact-card-icon-wrap.ground {
        background: linear-gradient(135deg, rgba(66, 133, 244, 0.25), rgba(30, 90, 200, 0.35));
        color: #4285f4;
        border: 1px solid rgba(66, 133, 244, 0.4);
    }

    .contact-card-details {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        overflow: hidden;
        flex-grow: 1;
    }

    .contact-card-type {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--text-color, #e7f711);
    }

    .contact-card-main-text {
        font-size: 0.92rem;
        font-weight: 700;
        color: #ffffff;
        word-break: break-word;
        line-height: 1.3;
    }

    .contact-card-action-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.7);
        flex-shrink: 0;
        transition: all 0.25s ease;
    }

    .contact-card-item:hover .contact-card-action-icon {
        background: var(--primary-color, #e60000);
        color: #ffffff;
        transform: scale(1.1);
    }

    .social-links-row {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .social-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        color: #ffffff;
        font-size: 0.9rem;
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
        width: 22px;
        height: 22px;
        fill: currentColor;
    }
</style>

<!-- Bottom Section: Connect With United Seniors Vellanad -->
<section class="social-section">
    <h2 class="social-title">Connect With <span>United Seniors Vellanad</span></h2>
    <p class="social-desc">Reach out directly via email, phone, visit our ground location, or follow our social channels</p>

    <!-- Direct Contact Info Grid -->
    <div class="direct-contact-grid">
        <!-- Email Address -->
        <a href="mailto:{{ $settings->club_email ?: 'unitedseniorsvellanadans@gmail.com' }}" class="contact-card-item" title="Send Email to United Seniors Vellanad">
            <div class="contact-card-icon-wrap email">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                </svg>
            </div>
            <div class="contact-card-details">
                <span class="contact-card-type">Email Address</span>
                <span class="contact-card-main-text">{{ $settings->club_email ?: 'unitedseniorsvellanadans@gmail.com' }}</span>
            </div>
            <div class="contact-card-action-icon" title="Send Email">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </div>
        </a>

        <!-- Phone Number -->
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->club_phone ?: '09447889502') }}" class="contact-card-item" title="Call United Seniors Vellanad">
            <div class="contact-card-icon-wrap phone">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                </svg>
            </div>
            <div class="contact-card-details">
                <span class="contact-card-type">Phone</span>
                <span class="contact-card-main-text">{{ $settings->club_phone ?: '094478 89502' }}</span>
            </div>
            <div class="contact-card-action-icon" title="Call Now">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                </svg>
            </div>
        </a>

        <!-- Ground Location with Google Maps Symbol -->
        <a href="{{ $settings->ground_map_url ?: 'https://www.google.com/maps/place/Viswanathan+Memorial+Panchayath+Stadium,+Vellanad/@8.5565815,77.0396807,15z/data=!4m10!1m2!2m1!1sground+Vellanad!3m6!1s0x3b05b700298dfee1:0xce52ac8e1571f9d!8m2!3d8.5565815!4d77.0587351!15sCg9ncm91bmQgVmVsbGFuYWRaESIPZ3JvdW5kIHZlbGxhbmFkkgEKcGxheWdyb3VuZJoBRENpOURRVWxSUVVOdlpFTm9kSGxqUmpsdlQycGFRMU5FVmxwT2EyUklZbnBzTlZsWWFHWk5WR1F5V1c1T2JrNUlZeEFC4AEA-gEECAAQOw!16s%2Fg%2F11wqkkrh2d?entry=ttu&g_ep=EgoyMDI2MDkyMy4wIKXMDSoASAFQAw%3D%3D' }}" target="_blank" rel="noopener" class="contact-card-item" title="Open Ground Location on Google Maps">
            <div class="contact-card-icon-wrap ground">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
            <div class="contact-card-details">
                <span class="contact-card-type">Ground Location</span>
                <span class="contact-card-main-text">{{ $settings->ground_location ?: 'H345+JF, Vellanad, Keralam 695543' }}</span>
            </div>
            <div class="contact-card-action-icon" title="View on Google Maps">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                </svg>
            </div>
        </a>
    </div>

    <div class="social-links-row">
        <!-- Facebook -->
        <a href="{{ $settings->facebook_url ?: 'https://www.facebook.com/unitedseniorsvellanad' }}" target="_blank" rel="noopener" class="social-btn facebook" title="Visit our Facebook page">
            <svg class="social-icon-img" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            <span>Facebook</span>
        </a>

        <!-- Instagram -->
        <a href="{{ $settings->instagram_url ?: 'https://instagram.com/unitedseniorsvellanad' }}" target="_blank" rel="noopener" class="social-btn instagram" title="Visit our Instagram profile">
            <svg class="social-icon-img" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
            <span>Instagram</span>
        </a>

        <!-- YouTube -->
        <a href="{{ $settings->youtube_url ?: 'https://www.youtube.com/@UnitedSeniorsVellanad' }}" target="_blank" rel="noopener" class="social-btn youtube" title="Watch our YouTube matches">
            <svg class="social-icon-img" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
            <span>YouTube</span>
        </a>
    </div>
</section>
