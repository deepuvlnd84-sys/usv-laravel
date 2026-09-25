<!-- Native Mobile Bottom-Sheet Drawer Engine & Polish Layer -->
<style>
    @media (max-width: 768px), display-mode: standalone, (display-mode: standalone) {
        /* Mobile Modal Bottom-Sheet Transformation */
        .modal-card {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            border-radius: 28px 28px 0 0 !important;
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            max-height: 88vh !important;
            transform: translateY(100%) !important;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
            padding: 1.5rem 1.25rem calc(1.5rem + env(safe-area-inset-bottom, 0px)) 1.25rem !important;
            box-shadow: 0 -15px 40px rgba(0, 0, 0, 0.8) !important;
            touch-action: pan-y !important;
        }

        .modal-overlay.active .modal-card {
            transform: translateY(0) !important;
        }

        /* Drag Handle Indicator Pill */
        .bottom-sheet-handle {
            width: 44px;
            height: 5px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 3px;
            margin: -0.5rem auto 1rem auto;
            display: block;
            cursor: grab;
        }

        /* Skeleton Shimmer Loaders */
        .skeleton-loader {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.05) 25%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.05) 75%);
            background-size: 200% 100%;
            animation: skeletonShimmer 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes skeletonShimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    }
</style>

<script>
    // Native Bottom-Sheet Touch Drag Handler for Mobile View
    document.addEventListener('DOMContentLoaded', function () {
        if (window.innerWidth > 768) return;

        document.querySelectorAll('.modal-card').forEach(function (card) {
            // Prepend drag handle pill if missing
            if (!card.querySelector('.bottom-sheet-handle')) {
                const handle = document.createElement('div');
                handle.className = 'bottom-sheet-handle';
                card.insertBefore(handle, card.firstChild);
            }

            let startY = 0;
            let currentY = 0;
            let isDragging = false;

            card.addEventListener('touchstart', function (e) {
                if (card.scrollTop > 0) return; // Allow internal scrolling first
                startY = e.touches[0].clientY;
                isDragging = true;
                card.style.transition = 'none';
            }, { passive: true });

            card.addEventListener('touchmove', function (e) {
                if (!isDragging) return;
                currentY = e.touches[0].clientY - startY;
                if (currentY > 0) {
                    card.style.transform = `translateY(${currentY}px)`;
                }
            }, { passive: true });

            card.addEventListener('touchend', function () {
                if (!isDragging) return;
                isDragging = false;
                card.style.transition = 'transform 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
                if (currentY > 110) { // Dragged past threshold -> Close modal
                    card.style.transform = 'translateY(100%)';
                    setTimeout(() => {
                        const overlay = card.closest('.modal-overlay');
                        if (overlay) overlay.classList.remove('active');
                        document.body.style.overflow = '';
                        card.style.transform = '';
                    }, 250);
                } else {
                    card.style.transform = 'translateY(0)';
                }
                currentY = 0;
            });
        });
    });
</script>
