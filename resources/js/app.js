import './bootstrap';
import Alpine from 'alpinejs';

const reduceMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
const finePointerQuery = window.matchMedia('(hover: hover) and (pointer: fine)');

const clamp = (value, min, max) => Math.min(Math.max(value, min), max);
const lerp = (start, end, amount) => start + (end - start) * amount;

const prefersReducedMotion = () => reduceMotionQuery.matches;
const supportsFinePointer = () => finePointerQuery.matches && !prefersReducedMotion();

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
    scrollHandler: null,
    pointerTargetX: 0,
    pointerTargetY: 0,
    pointerCurrentX: 0,
    pointerCurrentY: 0,
    scrollProgress: 0,
    motionFrame: null,

    init() {
        this.startAutoplay();
        this.updateScrollProgress();

        this.visibilityHandler = () => {
            if (document.hidden) {
                this.stopAutoplay();
            } else {
                this.startAutoplay();
            }
        };

        this.scrollHandler = () => this.updateScrollProgress();

        document.addEventListener('visibilitychange', this.visibilityHandler);
        window.addEventListener('scroll', this.scrollHandler, { passive: true });
    },

    destroy() {
        this.stopAutoplay();

        if (this.visibilityHandler) {
            document.removeEventListener('visibilitychange', this.visibilityHandler);
        }

        if (this.scrollHandler) {
            window.removeEventListener('scroll', this.scrollHandler);
        }

        if (this.motionFrame) {
            window.cancelAnimationFrame(this.motionFrame);
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

    updateScrollProgress() {
        const heroHeight = this.$root?.offsetHeight || window.innerHeight;
        this.scrollProgress = clamp(window.scrollY / Math.max(heroHeight * 0.95, 1), 0, 1);
    },

    handlePointerMove(event) {
        if (!supportsFinePointer() || !this.$root) {
            return;
        }

        const bounds = this.$root.getBoundingClientRect();
        const normalizedX = ((event.clientX - bounds.left) / bounds.width) - 0.5;
        const normalizedY = ((event.clientY - bounds.top) / bounds.height) - 0.5;

        this.pointerTargetX = clamp(normalizedX, -0.5, 0.5);
        this.pointerTargetY = clamp(normalizedY, -0.5, 0.5);
        this.ensureMotionLoop();
    },

    resetPointer() {
        this.pointerTargetX = 0;
        this.pointerTargetY = 0;
        this.ensureMotionLoop();
    },

    ensureMotionLoop() {
        if (this.motionFrame || prefersReducedMotion()) {
            return;
        }

        const tick = () => {
            this.pointerCurrentX = lerp(this.pointerCurrentX, this.pointerTargetX, 0.08);
            this.pointerCurrentY = lerp(this.pointerCurrentY, this.pointerTargetY, 0.08);

            const settled =
                Math.abs(this.pointerTargetX - this.pointerCurrentX) < 0.001 &&
                Math.abs(this.pointerTargetY - this.pointerCurrentY) < 0.001;

            if (settled) {
                this.pointerCurrentX = this.pointerTargetX;
                this.pointerCurrentY = this.pointerTargetY;
                this.motionFrame = null;
                return;
            }

            this.motionFrame = window.requestAnimationFrame(tick);
        };

        this.motionFrame = window.requestAnimationFrame(tick);
    },

    getLayerStyle(index, layer) {
        const isActive = this.active === index;
        const pointerX = supportsFinePointer() ? this.pointerCurrentX : 0;
        const pointerY = supportsFinePointer() ? this.pointerCurrentY : 0;
        const mobileFactor = window.innerWidth < 768 ? 0.55 : 1;
        const scrollDrift = this.scrollProgress * mobileFactor;

        const layers = {
            back: {
                x: pointerX * 34 * mobileFactor,
                y: (pointerY * 18) + (scrollDrift * -40),
                scale: isActive ? 1.08 + (scrollDrift * 0.03) : 1.12,
                opacity: 1,
            },
            mid: {
                x: pointerX * 54 * mobileFactor,
                y: (pointerY * 24) + (scrollDrift * -22),
                scale: isActive ? 1.02 : 1.05,
                opacity: isActive ? 0.95 : 0.45,
            },
            front: {
                x: pointerX * -42 * mobileFactor,
                y: (pointerY * -20) + (scrollDrift * -12),
                scale: isActive ? 1 : 0.98,
                opacity: isActive ? 1 : 0.35,
            },
        };

        const config = layers[layer];

        if (!config) {
            return '';
        }

        return `transform: translate3d(${config.x}px, ${config.y}px, 0) scale(${config.scale}); opacity: ${config.opacity};`;
    },

    getContentStyle() {
        const pointerX = supportsFinePointer() ? this.pointerCurrentX : 0;
        const pointerY = supportsFinePointer() ? this.pointerCurrentY : 0;
        const mobileFactor = window.innerWidth < 768 ? 0.45 : 1;

        return `transform: translate3d(${pointerX * 20 * mobileFactor}px, ${(-this.scrollProgress * 28) + (pointerY * 14 * mobileFactor)}px, 0);`;
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

Alpine.data('contactForm', (config = {}) => ({
    loading: false,
    toastVisible: false,
    toastMessage: config.successMessage ?? 'تم إرسال رسالتك بنجاح ✔',
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
                    this.errorMessage = config.validationError ?? 'يرجى مراجعة الحقول المطلوبة ثم المحاولة مرة أخرى.';
                } else {
                    this.errorMessage = payload.message || config.genericError || 'حدث خطأ، حاول مرة أخرى.';
                }

                return;
            }

            form.reset();
            this.toastMessage = payload.message || config.successMessage || 'تم إرسال رسالتك بنجاح ✔';
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
            this.errorMessage = config.networkError || 'خطأ في الاتصال. حاول مرة أخرى بعد قليل.';
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

Alpine.data('servicesShowcase', (items = []) => ({
    items,
    active: 0,
    displayed: 0,
    isTransitioning: false,
    spotlightPhase: 'enter',
    swapTimer: null,
    settleTimer: null,

    init() {
        this.displayed = this.active;
    },

    setActive(index) {
        if (index < 0 || index >= this.items.length) {
            return;
        }

        if (index === this.active && index === this.displayed && !this.isTransitioning) {
            return;
        }

        this.active = index;

        window.clearTimeout(this.swapTimer);
        window.clearTimeout(this.settleTimer);

        this.isTransitioning = true;
        this.spotlightPhase = 'leave';

        this.swapTimer = window.setTimeout(() => {
            this.displayed = index;
            this.spotlightPhase = 'enter-start';

            window.requestAnimationFrame(() => {
                window.requestAnimationFrame(() => {
                    this.spotlightPhase = 'enter';
                });
            });

            this.settleTimer = window.setTimeout(() => {
                this.isTransitioning = false;
            }, 420);
        }, 190);
    },

    isActive(index) {
        return this.active === index;
    },

    displayedItem() {
        return this.items[this.displayed] ?? { title: '', desc: '' };
    },

    displayedIndexLabel() {
        return `${String(this.displayed + 1).padStart(2, '0')} / ${String(this.items.length).padStart(2, '0')}`;
    },

    spotlightStyle() {
        const total = Math.max(this.items.length, 1);
        const segmentWidth = 100 / total;
        const progressOffset = this.active * segmentWidth;
        const glowOffset = total > 1 ? ((this.active / (total - 1)) * 108) - 18 : 32;

        return `--services-progress-width: ${segmentWidth}%; --services-progress-offset: ${progressOffset}%; --services-glow-offset: ${glowOffset}px;`;
    },

    getItemStyle(index) {
        const distance = Math.abs(index - this.active);
        const active = index === this.active;
        const direction = document.documentElement.dir === 'rtl' ? 1 : -1;
        const translateX = active ? 0 : direction * (distance === 1 ? 14 : 22);
        const scale = active ? 1 : distance === 1 ? 0.985 : 0.97;
        const opacity = active ? 1 : distance === 1 ? 0.72 : 0.5;

        return `transform: translate3d(${translateX}px, 0, 0) scale(${scale}); opacity: ${opacity};`;
    },
}));

Alpine.data('trustConversion', (config = {}) => ({
    stats: [],
    testimonials: config.testimonials ?? [],
    activeTestimonial: 0,
    testimonialTimer: null,
    hasAnimatedStats: false,
    counterObserver: null,

    init() {
        this.stats = (config.stats ?? []).map((stat) => ({
            ...stat,
            current: 0,
        }));

        if (this.testimonials.length > 1) {
            this.startTestimonials();
        }

        this.counterObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting || this.hasAnimatedStats) {
                        return;
                    }

                    this.hasAnimatedStats = true;
                    this.animateStats();
                    this.counterObserver?.disconnect();
                });
            },
            { threshold: 0.3 }
        );

        this.counterObserver.observe(this.$root);
    },

    destroy() {
        window.clearInterval(this.testimonialTimer);
        this.counterObserver?.disconnect();
    },

    startTestimonials() {
        window.clearInterval(this.testimonialTimer);
        this.testimonialTimer = window.setInterval(() => {
            this.activeTestimonial = (this.activeTestimonial + 1) % this.testimonials.length;
        }, 5200);
    },

    goToTestimonial(index) {
        this.activeTestimonial = index;
        this.startTestimonials();
    },

    animateStats() {
        this.stats.forEach((stat, index) => {
            const target = Number(stat.value) || 0;
            const duration = 950 + (index * 160);
            const startTime = performance.now() + (index * 90);

            const tick = (now) => {
                if (now < startTime) {
                    window.requestAnimationFrame(tick);
                    return;
                }

                const progress = Math.min((now - startTime) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);

                stat.current = Math.round(target * eased);

                if (progress < 1) {
                    window.requestAnimationFrame(tick);
                } else {
                    stat.current = target;
                }
            };

            window.requestAnimationFrame(tick);
        });
    },

    formattedStat(index) {
        const stat = this.stats[index];

        if (!stat) {
            return '0';
        }

        return new Intl.NumberFormat('en').format(stat.current);
    },
}));

window.Alpine = Alpine;

Alpine.start();

document.documentElement.classList.add('js-ready');

function initScrollAnimations() {
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

    document.querySelectorAll('[data-animate]').forEach((element) => {
        scrollAnimateObserver.observe(element);
    });
}

function initStaggerAnimations() {
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
                            }, index * 110);
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
}

function initMotionGroups() {
    const groups = [...document.querySelectorAll('[data-motion-group]')];

    groups.forEach((group) => {
        const items = [...group.querySelectorAll('[data-motion-item]')];

        items.forEach((item, index) => {
            const order = Number(item.dataset.motionOrder ?? index);
            item.style.setProperty('--motion-item-delay', `${order * 90}ms`);
        });

        if (prefersReducedMotion()) {
            items.forEach((item) => item.classList.add('motion-in'));
            return;
        }

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    items.forEach((item) => {
                        item.classList.toggle('motion-in', entry.isIntersecting);
                    });
                });
            },
            { threshold: 0.18, rootMargin: '0px 0px -8% 0px' }
        );

        observer.observe(group);
    });
}

function initAboutReveal() {
    const aboutRevealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        },
        { threshold: 0.15 }
    );

    document.querySelectorAll('.about-section').forEach((element) => {
        aboutRevealObserver.observe(element);
    });
}

function initSectionDepth() {
    const sections = [...document.querySelectorAll('[data-cinematic-section]')];

    if (!sections.length) {
        return;
    }

    const activeSections = new Set();
    let rafId = null;

    const updateSections = () => {
        const viewportHeight = window.innerHeight || 1;

        activeSections.forEach((section) => {
            const rect = section.getBoundingClientRect();
            const depth = Number(section.dataset.sectionDepth || 14);
            const centerOffset = (rect.top + (rect.height / 2) - (viewportHeight / 2)) / (viewportHeight / 2);
            const progress = clamp(centerOffset, -1.2, 1.2);
            const scrollShift = -progress * depth;

            section.style.setProperty('--section-scroll-y', `${scrollShift.toFixed(2)}px`);
        });

        rafId = null;
    };

    const requestUpdate = () => {
        if (rafId !== null) {
            return;
        }

        rafId = window.requestAnimationFrame(updateSections);
    };

    const sectionObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    activeSections.add(entry.target);
                } else {
                    activeSections.delete(entry.target);
                    entry.target.style.setProperty('--section-scroll-y', '0px');
                    entry.target.style.setProperty('--section-pointer-x', '0px');
                    entry.target.style.setProperty('--section-pointer-y', '0px');
                }
            });

            requestUpdate();
        },
        { threshold: [0, 0.2, 0.5, 1] }
    );

    sections.forEach((section) => {
        sectionObserver.observe(section);

        if (supportsFinePointer()) {
            section.addEventListener('pointermove', (event) => {
                const bounds = section.getBoundingClientRect();
                const offsetX = (((event.clientX - bounds.left) / bounds.width) - 0.5) * 14;
                const offsetY = (((event.clientY - bounds.top) / bounds.height) - 0.5) * 12;

                section.style.setProperty('--section-pointer-x', `${offsetX.toFixed(2)}px`);
                section.style.setProperty('--section-pointer-y', `${offsetY.toFixed(2)}px`);
            });

            section.addEventListener('pointerleave', () => {
                section.style.setProperty('--section-pointer-x', '0px');
                section.style.setProperty('--section-pointer-y', '0px');
            });
        }
    });

    window.addEventListener('scroll', requestUpdate, { passive: true });
    window.addEventListener('resize', requestUpdate);
    requestUpdate();
}

initScrollAnimations();
initStaggerAnimations();
initMotionGroups();
initAboutReveal();
initSectionDepth();
