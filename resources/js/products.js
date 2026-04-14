/**
 * Product Showcase — Hover/focus-driven spotlight + rail interaction
 *
 * Active product changes ONLY via:
 *  1. Hover (mouseenter, debounced 60ms)
 *  2. Focus (keyboard)
 *  3. Click / tap
 *
 * Scrolling has no effect on active state.
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
        hoverTimer: null,

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

        handleHover(index) {
            clearTimeout(this.hoverTimer);
            this.hoverTimer = setTimeout(() => {
                this.setActive(index);
            }, 60);
        },

        handleHoverLeave() {
            clearTimeout(this.hoverTimer);
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
            }, 200);
        },
    }));
});
