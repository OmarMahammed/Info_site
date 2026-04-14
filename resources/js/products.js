/**
 * Product Showcase — Scroll-driven spotlight + rail interaction
 *
 * Active product is determined by:
 *  1. IntersectionObserver on rail items (highest visibility wins)
 *  2. Hover / focusin on desktop
 *  3. Click / tap on mobile
 *
 * The spotlight panel animates through a three-phase content swap:
 *  leave → enter-start → enter
 */

document.addEventListener('alpine:init', () => {
    Alpine.data('productShowcase', (items) => ({
        items,
        active: 0,
        displayed: 0,
        spotlightPhase: 'enter',
        swapTimer: null,

        init() {
            this.$nextTick(() => {
                this.setupScrollObserver();
            });
        },

        activeProduct() {
            return this.items[this.active] ?? this.items[0];
        },

        displayedProduct() {
            return this.items[this.displayed] ?? this.items[0];
        },

        counterLabel() {
            const total = this.items.length;
            const idx = this.active + 1;
            const pad = (n) => String(n).padStart(2, '0');
            return `${pad(idx)} / ${pad(total)}`;
        },

        setActive(index) {
            if (index === this.active || index < 0 || index >= this.items.length) return;

            this.active = index;
            this.animateSpotlightSwap(index);
        },

        animateSpotlightSwap(index) {
            clearTimeout(this.swapTimer);

            this.spotlightPhase = 'leave';

            this.swapTimer = setTimeout(() => {
                this.displayed = index;
                this.spotlightPhase = 'enter-start';

                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        this.spotlightPhase = 'enter';
                    });
                });
            }, 220);
        },

        setupScrollObserver() {
            const rail = this.$refs.rail;
            if (!rail) return;

            const items = rail.querySelectorAll('[data-pdp-index]');
            if (!items.length) return;

            const io = new IntersectionObserver(
                (entries) => {
                    let bestIndex = this.active;
                    let bestRatio = 0;

                    entries.forEach((entry) => {
                        if (entry.isIntersecting && entry.intersectionRatio > bestRatio) {
                            bestRatio = entry.intersectionRatio;
                            bestIndex = parseInt(entry.target.dataset.pdpIndex, 10);
                        }
                    });

                    if (bestRatio > 0.3 && bestIndex !== this.active) {
                        this.setActive(bestIndex);
                    }
                },
                {
                    root: null,
                    rootMargin: '-20% 0px -35% 0px',
                    threshold: [0, 0.3, 0.5, 0.7, 1],
                }
            );

            items.forEach((item) => io.observe(item));
        },
    }));
});
