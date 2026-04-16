@extends('layouts.app')

@section('title', __('site.footer.features') . ' — ' . config('app.name'))

@push('styles')
    <style>
        .features-page {
            --features-glow: color-mix(in srgb, var(--color-primary) 28%, transparent);
            --features-glow-soft: color-mix(in srgb, var(--color-primary) 12%, transparent);
        }

        .features-mesh {
            background:
                radial-gradient(ellipse 80% 55% at 100% -10%, var(--features-glow-soft), transparent 55%),
                radial-gradient(ellipse 60% 45% at 0% 100%, color-mix(in srgb, #60a5fa 14%, transparent), transparent 50%),
                radial-gradient(ellipse 50% 40% at 80% 60%, var(--features-glow), transparent 60%);
        }

        .dark .features-mesh {
            background:
                radial-gradient(ellipse 80% 55% at 100% -10%, color-mix(in srgb, var(--color-primary) 22%, transparent), transparent 58%),
                radial-gradient(ellipse 60% 45% at 0% 100%, rgba(96, 165, 250, 0.08), transparent 52%),
                radial-gradient(ellipse 50% 40% at 80% 60%, color-mix(in srgb, var(--color-primary) 18%, transparent), transparent 62%);
        }

        .features-orb {
            position: absolute;
            border-radius: 999px;
            filter: blur(52px);
            opacity: 0.55;
            pointer-events: none;
            will-change: transform;
        }

        .features-orb-a {
            width: min(42vw, 22rem);
            height: min(42vw, 22rem);
            top: -5%;
            inset-inline-end: -8%;
            background: color-mix(in srgb, var(--color-primary) 35%, transparent);
            animation: features-orb-float 14s var(--motion-ease-soft) infinite;
        }

        .features-orb-b {
            width: min(36vw, 18rem);
            height: min(36vw, 18rem);
            bottom: 8%;
            inset-inline-start: -6%;
            background: rgba(96, 165, 250, 0.14);
            animation: features-orb-float 18s var(--motion-ease-soft) infinite reverse;
        }

        @keyframes features-fade-up {
            from {
                opacity: 0;
                transform: translate3d(0, 1.25rem, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes features-orb-float {

            0%,
            100% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            50% {
                transform: translate3d(-2%, 3%, 0) scale(1.06);
            }
        }

        .features-anim-hero {
            animation: features-fade-up 0.85s var(--motion-ease-standard) both;
        }

        .features-anim-card {
            animation: features-fade-up 0.78s var(--motion-ease-standard) both;
        }

        .features-delay-1 {
            animation-delay: 0.1s;
        }

        .features-delay-2 {
            animation-delay: 0.22s;
        }

        .features-delay-3 {
            animation-delay: 0.34s;
        }

        .features-delay-4 {
            animation-delay: 0.46s;
        }

        @media (prefers-reduced-motion: reduce) {

            .features-orb-a,
            .features-orb-b {
                animation: none;
            }

            .features-anim-hero,
            .features-anim-card {
                animation: none;
                opacity: 1;
                transform: none;
            }
        }
    </style>
@endpush

@section('content')
    <section class="features-page relative isolate overflow-hidden bg-[var(--bg)] text-[var(--text-primary)]">
        <div class="features-mesh pointer-events-none absolute inset-0 z-0" aria-hidden="true"></div>
        <div class="features-orb features-orb-a" aria-hidden="true"></div>
        <div class="features-orb features-orb-b" aria-hidden="true"></div>

        <div
            class="pointer-events-none absolute inset-0 z-[1] bg-[linear-gradient(to_bottom,color-mix(in_srgb,var(--bg)_0%,transparent),var(--bg)_85%)] dark:bg-[linear-gradient(to_bottom,transparent,var(--bg)_88%)]"
            aria-hidden="true"></div>

        <div class="container-custom relative z-10 mx-auto max-w-5xl px-4 sm:px-5">
            <header class="section-padding-hero pb-10 text-center sm:pb-14">
                <p
                    class="features-anim-hero section-kicker mx-auto mb-5 inline-flex max-w-full text-[var(--text-secondary)] motion-reduce:opacity-100">
                    <span class="text-[var(--color-primary)]" aria-hidden="true">✦</span>
                    <span>{{ __('site.footer.features') }}</span>
                </p>
                <h1
                    class="features-anim-hero features-delay-1 text-[2.75rem] font-semibold leading-[1.08] tracking-[-0.02em] text-balance md:text-[3.5rem] lg:text-[4.1rem] bg-gradient-to-br from-[var(--text-primary)] via-[var(--text-primary)] to-[color-mix(in_srgb,var(--color-primary)_72%,var(--text-primary))] bg-clip-text text-transparent dark:to-[color-mix(in_srgb,var(--color-primary)_55%,var(--text-secondary))]">
                    {{ __('site.footer.features') }}
                </h1>
                <div class="features-anim-hero features-delay-2 mx-auto mt-8 h-px w-20 rounded-full bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent opacity-90"
                    role="presentation"></div>
            </header>

            <div class="grid gap-5 pb-16 sm:grid-cols-2 sm:gap-6 sm:pb-20 lg:gap-8 lg:pb-24">
                {{-- 01 Quality --}}
                <article
                    class="features-anim-card features-delay-1 group relative flex flex-col gap-4 rounded-[var(--radius-xl)] border border-[color-mix(in_srgb,var(--border)_80%,transparent)] bg-[color-mix(in_srgb,var(--surface)_92%,transparent)] p-6 shadow-[var(--shadow-soft)] backdrop-blur-md transition-[transform,box-shadow] duration-300 motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-[var(--shadow-panel)] sm:p-8 dark:border-[color-mix(in_srgb,var(--border)_65%,transparent)] dark:bg-[color-mix(in_srgb,var(--surface)_88%,transparent)]">
                    <div class="flex items-start gap-4">
                        <div
                            class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-[var(--radius-md)] bg-gradient-to-br from-[color-mix(in_srgb,var(--color-primary)_22%,transparent)] to-[color-mix(in_srgb,var(--color-primary)_8%,transparent)] text-[var(--color-primary)] ring-1 ring-[color-mix(in_srgb,var(--color-primary)_35%,transparent)] transition-transform duration-300 motion-safe:group-hover:scale-105 dark:from-[color-mix(in_srgb,var(--color-primary)_28%,transparent)] dark:to-[color-mix(in_srgb,var(--color-primary)_10%,transparent)]">
                            <span
                                class="absolute inset-0 rounded-[inherit] opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-40 motion-reduce:opacity-0"
                                style="background: radial-gradient(circle, var(--color-primary), transparent 70%);"
                                aria-hidden="true"></span>
                            <svg class="relative h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1 text-start">
                            <p class="text-sm font-bold tabular-nums tracking-wide text-[var(--color-primary)]">01</p>
                            <p class="mt-2 text-base leading-[1.85] text-[var(--text-secondary)] sm:text-[1.05rem]">
                                {{ __('site.features_page.quality') }}</p>
                        </div>
                    </div>
                </article>

                {{-- 02 Team --}}
                <article
                    class="features-anim-card features-delay-2 group relative flex flex-col gap-4 rounded-[var(--radius-xl)] border border-[color-mix(in_srgb,var(--border)_80%,transparent)] bg-[color-mix(in_srgb,var(--surface)_92%,transparent)] p-6 shadow-[var(--shadow-soft)] backdrop-blur-md transition-[transform,box-shadow] duration-300 motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-[var(--shadow-panel)] sm:p-8 dark:border-[color-mix(in_srgb,var(--border)_65%,transparent)] dark:bg-[color-mix(in_srgb,var(--surface)_88%,transparent)]">
                    <div class="flex items-start gap-4">
                        <div
                            class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-[var(--radius-md)] bg-gradient-to-br from-[color-mix(in_srgb,var(--color-primary)_22%,transparent)] to-[color-mix(in_srgb,var(--color-primary)_8%,transparent)] text-[var(--color-primary)] ring-1 ring-[color-mix(in_srgb,var(--color-primary)_35%,transparent)] transition-transform duration-300 motion-safe:group-hover:scale-105 dark:from-[color-mix(in_srgb,var(--color-primary)_28%,transparent)] dark:to-[color-mix(in_srgb,var(--color-primary)_10%,transparent)]">
                            <span
                                class="absolute inset-0 rounded-[inherit] opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-40 motion-reduce:opacity-0"
                                style="background: radial-gradient(circle, var(--color-primary), transparent 70%);"
                                aria-hidden="true"></span>
                            <svg class="relative h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1 text-start">
                            <p class="text-sm font-bold tabular-nums tracking-wide text-[var(--color-primary)]">02</p>
                            <p class="mt-2 text-base leading-[1.85] text-[var(--text-secondary)] sm:text-[1.05rem]">
                                {{ __('site.features_page.team') }}</p>
                        </div>
                    </div>
                </article>

                {{-- 03 Speed --}}
                <article
                    class="features-anim-card features-delay-3 group relative flex flex-col gap-4 rounded-[var(--radius-xl)] border border-[color-mix(in_srgb,var(--border)_80%,transparent)] bg-[color-mix(in_srgb,var(--surface)_92%,transparent)] p-6 shadow-[var(--shadow-soft)] backdrop-blur-md transition-[transform,box-shadow] duration-300 motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-[var(--shadow-panel)] sm:p-8 dark:border-[color-mix(in_srgb,var(--border)_65%,transparent)] dark:bg-[color-mix(in_srgb,var(--surface)_88%,transparent)]">
                    <div class="flex items-start gap-4">
                        <div
                            class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-[var(--radius-md)] bg-gradient-to-br from-[color-mix(in_srgb,var(--color-primary)_22%,transparent)] to-[color-mix(in_srgb,var(--color-primary)_8%,transparent)] text-[var(--color-primary)] ring-1 ring-[color-mix(in_srgb,var(--color-primary)_35%,transparent)] transition-transform duration-300 motion-safe:group-hover:scale-105 dark:from-[color-mix(in_srgb,var(--color-primary)_28%,transparent)] dark:to-[color-mix(in_srgb,var(--color-primary)_10%,transparent)]">
                            <span
                                class="absolute inset-0 rounded-[inherit] opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-40 motion-reduce:opacity-0"
                                style="background: radial-gradient(circle, var(--color-primary), transparent 70%);"
                                aria-hidden="true"></span>
                            <svg class="relative h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1 text-start">
                            <p class="text-sm font-bold tabular-nums tracking-wide text-[var(--color-primary)]">03</p>
                            <p class="mt-2 text-base leading-[1.85] text-[var(--text-secondary)] sm:text-[1.05rem]">
                                {{ __('site.features_page.speed') }}</p>
                        </div>
                    </div>
                </article>

                {{-- 04 Tailored --}}
                <article
                    class="features-anim-card features-delay-4 group relative flex flex-col gap-4 rounded-[var(--radius-xl)] border border-[color-mix(in_srgb,var(--border)_80%,transparent)] bg-[color-mix(in_srgb,var(--surface)_92%,transparent)] p-6 shadow-[var(--shadow-soft)] backdrop-blur-md transition-[transform,box-shadow] duration-300 motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-[var(--shadow-panel)] sm:p-8 dark:border-[color-mix(in_srgb,var(--border)_65%,transparent)] dark:bg-[color-mix(in_srgb,var(--surface)_88%,transparent)]">
                    <div class="flex items-start gap-4">
                        <div
                            class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-[var(--radius-md)] bg-gradient-to-br from-[color-mix(in_srgb,var(--color-primary)_22%,transparent)] to-[color-mix(in_srgb,var(--color-primary)_8%,transparent)] text-[var(--color-primary)] ring-1 ring-[color-mix(in_srgb,var(--color-primary)_35%,transparent)] transition-transform duration-300 motion-safe:group-hover:scale-105 dark:from-[color-mix(in_srgb,var(--color-primary)_28%,transparent)] dark:to-[color-mix(in_srgb,var(--color-primary)_10%,transparent)]">
                            <span
                                class="absolute inset-0 rounded-[inherit] opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-40 motion-reduce:opacity-0"
                                style="background: radial-gradient(circle, var(--color-primary), transparent 70%);"
                                aria-hidden="true"></span>
                            <svg class="relative h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1 text-start">
                            <p class="text-sm font-bold tabular-nums tracking-wide text-[var(--color-primary)]">04</p>
                            <p class="mt-2 text-base leading-[1.85] text-[var(--text-secondary)] sm:text-[1.05rem]">
                                {{ __('site.features_page.tailored') }}</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
