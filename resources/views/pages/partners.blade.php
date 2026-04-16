@extends('layouts.app')

@section('title', __('site.footer.partners') . ' — ' . config('app.name'))

@push('styles')
    <style>
        .partners-page {
            --partners-glow: color-mix(in srgb, var(--color-primary) 28%, transparent);
            --partners-glow-soft: color-mix(in srgb, var(--color-primary) 12%, transparent);
        }

        .partners-mesh {
            background:
                radial-gradient(ellipse 80% 55% at 100% -10%, var(--partners-glow-soft), transparent 55%),
                radial-gradient(ellipse 60% 45% at 0% 100%, color-mix(in srgb, #60a5fa 14%, transparent), transparent 50%),
                radial-gradient(ellipse 50% 40% at 80% 60%, var(--partners-glow), transparent 60%);
        }

        .dark .partners-mesh {
            background:
                radial-gradient(ellipse 80% 55% at 100% -10%, color-mix(in srgb, var(--color-primary) 22%, transparent), transparent 58%),
                radial-gradient(ellipse 60% 45% at 0% 100%, rgba(96, 165, 250, 0.08), transparent 52%),
                radial-gradient(ellipse 50% 40% at 80% 60%, color-mix(in srgb, var(--color-primary) 18%, transparent), transparent 62%);
        }

        .partners-orb {
            position: absolute;
            border-radius: 999px;
            filter: blur(52px);
            opacity: 0.55;
            pointer-events: none;
            will-change: transform;
        }

        .partners-orb-a {
            width: min(42vw, 22rem);
            height: min(42vw, 22rem);
            top: -5%;
            inset-inline-end: -8%;
            background: color-mix(in srgb, var(--color-primary) 35%, transparent);
            animation: partners-orb-float 14s var(--motion-ease-soft) infinite;
        }

        .partners-orb-b {
            width: min(36vw, 18rem);
            height: min(36vw, 18rem);
            bottom: 8%;
            inset-inline-start: -6%;
            background: rgba(96, 165, 250, 0.14);
            animation: partners-orb-float 18s var(--motion-ease-soft) infinite reverse;
        }

        @keyframes partners-fade-up {
            from {
                opacity: 0;
                transform: translate3d(0, 1.25rem, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes partners-orb-float {

            0%,
            100% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            50% {
                transform: translate3d(-2%, 3%, 0) scale(1.06);
            }
        }

        .partners-anim-hero {
            animation: partners-fade-up 0.85s var(--motion-ease-standard) both;
        }

        .partners-delay-1 {
            animation-delay: 0.1s;
        }

        .partners-delay-2 {
            animation-delay: 0.22s;
        }

        .partners-delay-3 {
            animation-delay: 0.34s;
        }

        .partners-anim-item {
            animation: partners-fade-up 0.68s var(--motion-ease-standard) both;
            animation-delay: calc(min(var(--stagger, 0), 28) * 32ms);
        }

        @media (prefers-reduced-motion: reduce) {

            .partners-orb-a,
            .partners-orb-b {
                animation: none;
            }

            .partners-anim-hero,
            .partners-anim-item {
                animation: none;
                opacity: 1;
                transform: none;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $partners = [
            'acer.png',
            'apc.png',
            'asus.png',
            'benq.png',
            'brother.png',
            'canon.png',
            'cisco.png',
            'dell emc.png',
            'dell.png',
            'epson.png',
            'fortinet.png',
            'honeywell.png',
            'hp.jpg',
            'hpe.png',
            'images.jpeg',
            'lenovo.png',
            'lg.png',
            'linksys.jpg',
            'peoplelink.png',
            'ricoh.png',
            'samsung.png',
            'vertiv.png',
            'xerox.png',
            'zebra.png',
        ];
    @endphp

    <section class="partners-page relative isolate overflow-hidden bg-[var(--bg)] text-[var(--text-primary)]">
        <div class="partners-mesh pointer-events-none absolute inset-0 z-0" aria-hidden="true"></div>
        <div class="partners-orb partners-orb-a" aria-hidden="true"></div>
        <div class="partners-orb partners-orb-b" aria-hidden="true"></div>

        <div class="pointer-events-none absolute inset-0 z-[1] bg-[linear-gradient(to_bottom,color-mix(in_srgb,var(--bg)_0%,transparent),var(--bg)_85%)] dark:bg-[linear-gradient(to_bottom,transparent,var(--bg)_88%)]"
            aria-hidden="true"></div>

        <div class="container-custom relative z-10 mx-auto max-w-6xl px-4 sm:px-5">
            <header class="section-padding-hero pb-8 text-center sm:pb-12">
                <p
                    class="partners-anim-hero section-kicker mx-auto mb-5 inline-flex max-w-full text-[var(--text-secondary)] motion-reduce:opacity-100">
                    <span class="text-[var(--color-primary)]" aria-hidden="true">✦</span>
                    <span>{{ __('site.footer.partners') }}</span>
                </p>
                <h1
                    class="partners-anim-hero partners-delay-1 text-[2.75rem] font-semibold leading-[1.08] tracking-[-0.02em] text-balance md:text-[3.5rem] lg:text-[4.1rem] bg-gradient-to-br from-[var(--text-primary)] via-[var(--text-primary)] to-[color-mix(in_srgb,var(--color-primary)_72%,var(--text-primary))] bg-clip-text text-transparent dark:to-[color-mix(in_srgb,var(--color-primary)_55%,var(--text-secondary))]">
                    {{ __('site.footer.partners') }}
                </h1>
                <p
                    class="partners-anim-hero partners-delay-2 mx-auto mt-5 max-w-2xl text-pretty text-base leading-relaxed text-[var(--text-secondary)] sm:text-lg">
                    {{ __('site.partners_page.intro') }}
                </p>
                <div class="partners-anim-hero partners-delay-3 mx-auto mt-8 h-px w-20 rounded-full bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent opacity-90"
                    role="presentation"></div>
            </header>

            <div
                class="grid grid-cols-2 gap-3 pb-16 sm:grid-cols-3 sm:gap-4 md:grid-cols-4 md:gap-5 lg:grid-cols-5 lg:pb-24">
                @foreach ($partners as $index => $logo)
                    @php
                        $brand = str_replace(['_', '-'], ' ', pathinfo($logo, PATHINFO_FILENAME));
                    @endphp
                    <div class="partners-anim-item group flex aspect-[5/3] flex-col items-center justify-center rounded-[var(--radius-xl)] border border-[color-mix(in_srgb,var(--border)_80%,transparent)] bg-[color-mix(in_srgb,var(--surface)_92%,transparent)] p-4 shadow-[var(--shadow-soft)] backdrop-blur-md transition-[transform,box-shadow,border-color] duration-300 motion-safe:hover:-translate-y-1 motion-safe:hover:border-[color-mix(in_srgb,var(--color-primary)_45%,var(--border))] motion-safe:hover:shadow-[var(--shadow-panel)] sm:aspect-[4/3] sm:p-5 dark:border-[color-mix(in_srgb,var(--border)_65%,transparent)] dark:bg-[color-mix(in_srgb,var(--surface)_88%,transparent)]"
                        style="--stagger: {{ $index }}">
                        <img src="{{ asset('images/partners/' . $logo) }}" alt="{{ $brand }}" width="200" height="80"
                            loading="{{ $index < 8 ? 'eager' : 'lazy' }}" decoding="async" class="partner-logo max-h-10 w-full object-contain opacity-100 transition-all duration-300 
                    hover:scale-110 hover:brightness-110 
                    sm:max-h-12 md:max-h-14">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection