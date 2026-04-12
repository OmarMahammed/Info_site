import './bootstrap';
import Alpine from 'alpinejs';

window.trackEvent = function trackEvent(name, data = {}) {
    console.log('Event:', name, data);

    if (typeof window.gtag === 'function') {
        window.gtag('event', name, data);
    }
};

Alpine.data('heroSlider', (slidesCount = 2) => ({
    active: 0,
    autoplayTimer: null,
    slidesCount,
    visibilityHandler: null,

    init() {
        this.startAutoplay();
        this.visibilityHandler = () => {
            if (document.hidden) {
                this.stopAutoplay();
            } else {
                this.startAutoplay();
            }
        };

        document.addEventListener('visibilitychange', this.visibilityHandler);
    },

    destroy() {
        this.stopAutoplay();

        if (this.visibilityHandler) {
            document.removeEventListener('visibilitychange', this.visibilityHandler);
        }
    },

    startAutoplay() {
        this.stopAutoplay();
        this.autoplayTimer = window.setInterval(() => this.next(), 5000);
    },

    stopAutoplay() {
        if (this.autoplayTimer !== null) {
            window.clearInterval(this.autoplayTimer);
            this.autoplayTimer = null;
        }
    },

    next() {
        this.active = (this.active + 1) % this.slidesCount;
    },

    goToSlide(index) {
        this.active = index;
        this.startAutoplay();
    },
}));

Alpine.data('productCinemaSlider', (slidesCount = 0) => ({
    active: 0,
    slidesCount,
    slideOffset: 58,
    resizeHandler: null,

    init() {
        this.updateLayout();
        this.resizeHandler = () => this.updateLayout();
        window.addEventListener('resize', this.resizeHandler);
    },

    destroy() {
        if (this.resizeHandler) {
            window.removeEventListener('resize', this.resizeHandler);
        }
    },

    updateLayout() {
        if (window.innerWidth >= 1280) {
            this.slideOffset = 56;
            return;
        }

        if (window.innerWidth >= 1024) {
            this.slideOffset = 60;
            return;
        }

        if (window.innerWidth >= 768) {
            this.slideOffset = 78;
            return;
        }

        this.slideOffset = 100;
    },

    getRelativePosition(index) {
        if (this.slidesCount <= 1) {
            return 0;
        }

        let diff = index - this.active;
        const half = Math.floor(this.slidesCount / 2);

        if (diff > half) {
            diff -= this.slidesCount;
        }

        if (diff < -half) {
            diff += this.slidesCount;
        }

        return diff;
    },

    getSlideStyle(index) {
        const relative = this.getRelativePosition(index);
        const abs = Math.abs(relative);

        if (abs > 1) {
            return `transform: translate3d(${relative > 0 ? 125 : -125}%, 0, 0) scale(0.8); opacity: 0; filter: blur(8px); z-index: 0; pointer-events: none;`;
        }

        const translate = relative * this.slideOffset;
        const scale = relative === 0 ? 1 : 0.85;
        const opacity = relative === 0 ? 1 : 0.4;
        const blur = relative === 0 ? 0 : 4;
        const zIndex = relative === 0 ? 30 : 20 - abs;
        const pointerEvents = relative === 0 ? 'auto' : 'none';

        return `transform: translate3d(${translate}%, 0, 0) scale(${scale}); opacity: ${opacity}; filter: blur(${blur}px); z-index: ${zIndex}; pointer-events: ${pointerEvents};`;
    },

    getMediaStyle(index) {
        const relative = this.getRelativePosition(index);
        const shift = relative === 0 ? 0 : relative < 0 ? -18 : 18;
        const opacity = relative === 0 ? 1 : 0.82;
        const scale = relative === 0 ? 1 : 0.96;

        return `transform: translate3d(${shift}px, 0, 0) scale(${scale}); opacity: ${opacity};`;
    },

    getTextStyle(index) {
        const relative = this.getRelativePosition(index);
        const opacity = relative === 0 ? 1 : 0;
        const shiftY = relative === 0 ? 0 : 22;

        return `transform: translate3d(0, ${shiftY}px, 0); opacity: ${opacity};`;
    },

    prev() {
        this.active = (this.active - 1 + this.slidesCount) % this.slidesCount;
    },

    next() {
        this.active = (this.active + 1) % this.slidesCount;
    },

    goToSlide(index) {
        this.active = index;
    },
}));

Alpine.data('cinematicAbout', () => ({
    backgroundStyle: 'transform: translate3d(0, 0, 0) scale(1.06);',
    scrollHandler: null,
    ticking: false,

    init() {
        this.updateBackgroundMotion();
        this.scrollHandler = () => {
            if (this.ticking) {
                return;
            }

            this.ticking = true;
            window.requestAnimationFrame(() => {
                this.updateBackgroundMotion();
                this.ticking = false;
            });
        };

        window.addEventListener('scroll', this.scrollHandler, { passive: true });
    },

    destroy() {
        if (this.scrollHandler) {
            window.removeEventListener('scroll', this.scrollHandler);
        }
    },

    updateBackgroundMotion() {
        const rect = this.$el.getBoundingClientRect();
        const viewportHeight = window.innerHeight || 1;
        const distanceFromCenter = rect.top + rect.height / 2 - viewportHeight / 2;
        const translateY = Math.max(-22, Math.min(22, distanceFromCenter * -0.035));
        const normalized = 1 - Math.min(1, Math.abs(distanceFromCenter) / viewportHeight);
        const scale = 1.06 + normalized * 0.025;

        this.backgroundStyle = `transform: translate3d(0, ${translateY}px, 0) scale(${scale});`;
    },
}));

Alpine.data('premiumNavbar', () => ({
    isScrolled: false,
    isMobileMenuOpen: false,
    activeLink: 'home',

    init() {
        this.updateScrolledState();
        this.setInitialActiveLink();
        window.addEventListener('hashchange', () => this.setInitialActiveLink());
    },

    updateScrolledState() {
        this.isScrolled = window.scrollY > 12;
    },

    setActiveLink(link) {
        this.activeLink = link;
    },

    toggleMobileMenu() {
        this.isMobileMenuOpen = !this.isMobileMenuOpen;
        document.body.classList.toggle('overflow-hidden', this.isMobileMenuOpen);
    },

    closeMobileMenu() {
        this.isMobileMenuOpen = false;
        document.body.classList.remove('overflow-hidden');
    },

    setInitialActiveLink() {
        const hash = window.location.hash?.replace('#', '');
        this.activeLink = hash || 'home';
    },

}));

Alpine.data('contactForm', () => ({
    loading: false,
    toastVisible: false,
    toastMessage: 'تم إرسال رسالتك بنجاح ✔',
    errorMessage: '',
    errors: {},
    toastTimer: null,

    async submit() {
        const form = this.$refs.form;
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        this.loading = true;
        this.errorMessage = '';
        this.errors = {};

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token ?? '',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new FormData(form),
            });

            const payload = await response.json().catch(() => ({}));

            if (!response.ok) {
                if (response.status === 422) {
                    this.errors = payload.errors ?? {};
                    this.errorMessage = 'يرجى مراجعة الحقول المطلوبة ثم المحاولة مرة أخرى.';
                } else {
                    this.errorMessage = payload.message || 'حدث خطأ، حاول مرة أخرى.';
                }

                return;
            }

            form.reset();
            this.toastMessage = payload.message || 'تم إرسال رسالتك بنجاح ✔';
            window.trackEvent('form_submit', {
                form_name: 'contact_form',
                method: 'ajax',
            });
            window.trackEvent('generate_lead', {
                event_category: 'conversion',
                event_label: 'contact_form',
                value: 1,
            });
            this.showSuccessToast();
        } catch (error) {
            this.errorMessage = 'خطأ في الاتصال. حاول مرة أخرى بعد قليل.';
        } finally {
            this.loading = false;
        }
    },

    showSuccessToast() {
        this.toastVisible = true;

        window.clearTimeout(this.toastTimer);
        this.toastTimer = window.setTimeout(() => {
            this.toastVisible = false;
        }, 3000);
    },
}));

window.Alpine = Alpine;

Alpine.start();

document.documentElement.classList.add('js-ready');

/* Toggle .show on viewport enter/leave (repeats on scroll; never unobserve) */
const scrollAnimateObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            } else {
                entry.target.classList.remove('show');
            }
        });
    },
    { threshold: 0.1, rootMargin: '0px 0px -5% 0px' }
);

document.querySelectorAll('[data-animate]').forEach((el) => {
    scrollAnimateObserver.observe(el);
});

/* Stagger groups: delay each card by index * 120ms and repeat on scroll */
document.querySelectorAll('[data-stagger-root]').forEach((root) => {
    root.querySelectorAll('.stagger-card').forEach((card) => {
        const index = Number(card.dataset.staggerIndex || 0);
        let showTimer = null;

        const staggerObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        if (showTimer !== null) {
                            return;
                        }

                        showTimer = window.setTimeout(() => {
                            card.classList.add('show');
                            showTimer = null;
                        }, index * 120);
                    } else {
                        if (showTimer !== null) {
                            window.clearTimeout(showTimer);
                            showTimer = null;
                        }

                        card.classList.remove('show');
                    }
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
        );

        staggerObserver.observe(card);
    });
});
