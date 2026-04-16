@extends('layouts.app')

@section('title', __('site.footer.vision') . ' — ' . config('app.name'))

@push('styles')
    <style>
        .vision-page {
            --vision-glow: color-mix(in srgb, var(--color-primary) 28%, transparent);
            --vision-glow-soft: color-mix(in srgb, var(--color-primary) 12%, transparent);
        }

        .vision-mesh {
            background:
                radial-gradient(ellipse 80% 55% at 100% -10%, var(--vision-glow-soft), transparent 55%),
                radial-gradient(ellipse 60% 45% at 0% 100%, color-mix(in srgb, #60a5fa 14%, transparent), transparent 50%),
                radial-gradient(ellipse 50% 40% at 80% 60%, var(--vision-glow), transparent 60%);
        }

        .dark .vision-mesh {
            background:
                radial-gradient(ellipse 80% 55% at 100% -10%, color-mix(in srgb, var(--color-primary) 22%, transparent), transparent 58%),
                radial-gradient(ellipse 60% 45% at 0% 100%, rgba(96, 165, 250, 0.08), transparent 52%),
                radial-gradient(ellipse 50% 40% at 80% 60%, color-mix(in srgb, var(--color-primary) 18%, transparent), transparent 62%);
        }

        .vision-orb {
            position: absolute;
            border-radius: 999px;
            filter: blur(52px);
            opacity: 0.55;
            pointer-events: none;
            will-change: transform;
        }

        .vision-orb-a {
            width: min(42vw, 22rem);
            height: min(42vw, 22rem);
            top: -5%;
            inset-inline-end: -8%;
            background: color-mix(in srgb, var(--color-primary) 35%, transparent);
            animation: vision-orb-float 14s var(--motion-ease-soft) infinite;
        }

        .vision-orb-b {
            width: min(36vw, 18rem);
            height: min(36vw, 18rem);
            bottom: 8%;
            inset-inline-start: -6%;
            background: rgba(96, 165, 250, 0.14);
            animation: vision-orb-float 18s var(--motion-ease-soft) infinite reverse;
        }

        @keyframes vision-fade-up {
            from {
                opacity: 0;
                transform: translate3d(0, 1.25rem, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes vision-orb-float {

            0%,
            100% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            50% {
                transform: translate3d(-2%, 3%, 0) scale(1.06);
            }
        }

        .vision-anim-hero {
            animation: vision-fade-up 0.85s var(--motion-ease-standard) both;
        }

        .vision-anim-card {
            animation: vision-fade-up 0.78s var(--motion-ease-standard) both;
        }

        .vision-delay-1 {
            animation-delay: 0.1s;
        }

        .vision-delay-2 {
            animation-delay: 0.22s;
        }

        @media (prefers-reduced-motion: reduce) {

            .vision-orb-a,
            .vision-orb-b {
                animation: none;
            }

            .vision-anim-hero,
            .vision-anim-card {
                animation: none;
                opacity: 1;
                transform: none;
            }
        }
    </style>
@endpush

@section('content')
    <section class="vision-page relative isolate overflow-hidden bg-[var(--bg)] text-[var(--text-primary)]">
        <div class="vision-mesh pointer-events-none absolute inset-0 z-0" aria-hidden="true"></div>
        <div class="vision-orb vision-orb-a" aria-hidden="true"></div>
        <div class="vision-orb vision-orb-b" aria-hidden="true"></div>

        <div
            class="pointer-events-none absolute inset-0 z-[1] bg-[linear-gradient(to_bottom,color-mix(in_srgb,var(--bg)_0%,transparent),var(--bg)_85%)] dark:bg-[linear-gradient(to_bottom,transparent,var(--bg)_88%)]"
            aria-hidden="true"></div>

        <div class="container-custom relative z-10 mx-auto max-w-5xl px-4 sm:px-5">
            <header class="section-padding-hero pb-10 text-center sm:pb-14">
                <p
                    class="vision-anim-hero section-kicker mx-auto mb-5 inline-flex max-w-full text-[var(--text-secondary)] motion-reduce:opacity-100">
                    <span class="text-[var(--color-primary)]" aria-hidden="true">✦</span>
                    <span>{{ __('site.footer.vision') }}</span>
                </p>
                <h1
    class="vision-anim-hero vision-delay-1 text-[2.75rem] md:text-[3.5rem] lg:text-[4.1rem] 
           font-semibold tracking-[-0.02em] leading-[1.08] text-balance
           bg-gradient-to-br from-[var(--text-primary)] via-[var(--text-primary)] 
           to-[color-mix(in_srgb,var(--color-primary)_72%,var(--text-primary))] 
           bg-clip-text text-transparent 
           dark:to-[color-mix(in_srgb,var(--color-primary)_55%,var(--text-secondary))]">
    {{ __('Our Vision') }}
</h1>
                <div class="vision-anim-hero vision-delay-2 mx-auto mt-8 h-px w-20 rounded-full bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent opacity-90"
                    role="presentation"></div>
            </header>

            <div class="grid gap-5 pb-16 sm:gap-6 sm:pb-20 lg:grid-cols-2 lg:gap-8 lg:pb-24">
                <article
                    class="vision-anim-card vision-delay-1 group relative flex flex-col gap-5 rounded-[var(--radius-xl)] border border-[color-mix(in_srgb,var(--border)_80%,transparent)] bg-[color-mix(in_srgb,var(--surface)_92%,transparent)] p-6 shadow-[var(--shadow-soft)] backdrop-blur-md transition-[transform,box-shadow] duration-300 motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-[var(--shadow-panel)] sm:p-8 dark:border-[color-mix(in_srgb,var(--border)_65%,transparent)] dark:bg-[color-mix(in_srgb,var(--surface)_88%,transparent)]">
                    <div class="flex items-start gap-4 sm:gap-5">
                        <div
                            class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-[var(--radius-md)] bg-gradient-to-br from-[color-mix(in_srgb,var(--color-primary)_22%,transparent)] to-[color-mix(in_srgb,var(--color-primary)_8%,transparent)] text-[var(--color-primary)] ring-1 ring-[color-mix(in_srgb,var(--color-primary)_35%,transparent)] transition-transform duration-300 motion-safe:group-hover:scale-105 dark:from-[color-mix(in_srgb,var(--color-primary)_28%,transparent)] dark:to-[color-mix(in_srgb,var(--color-primary)_10%,transparent)]">
                            <span
                                class="absolute inset-0 rounded-[inherit] opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-40 motion-reduce:opacity-0"
                                style="background: radial-gradient(circle, var(--color-primary), transparent 70%);"
                                aria-hidden="true"></span>
                            <svg class="relative h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.847a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.847.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456Z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1 text-start">
                            <p class="text-sm font-bold tabular-nums tracking-wide text-[var(--color-primary)]">
                                01</p>
                            <p class="mt-0.5 text-xs font-medium uppercase tracking-[0.12em] text-[var(--text-muted)]">
                                {{ __('site.footer.vision') }}</p>
                        </div>
                    </div>
                    <p class="text-base leading-[1.85] text-[var(--text-secondary)] sm:text-[1.05rem]">
                        {{ __('To be a trusted and leading technology choice, we contribute to enabling our clients to leverage technology to develop their businesses and achieve the best results.') }}
                    </p>
                </article>

                <article
                    class="vision-anim-card vision-delay-2 group relative flex flex-col gap-5 rounded-[var(--radius-xl)] border border-[color-mix(in_srgb,var(--border)_80%,transparent)] bg-[color-mix(in_srgb,var(--surface)_92%,transparent)] p-6 shadow-[var(--shadow-soft)] backdrop-blur-md transition-[transform,box-shadow] duration-300 motion-safe:hover:-translate-y-1 motion-safe:hover:shadow-[var(--shadow-panel)] sm:p-8 dark:border-[color-mix(in_srgb,var(--border)_65%,transparent)] dark:bg-[color-mix(in_srgb,var(--surface)_88%,transparent)]">
                    <div class="flex items-start gap-4 sm:gap-5">
                        <div
                            class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-[var(--radius-md)] bg-gradient-to-br from-[color-mix(in_srgb,var(--color-primary)_22%,transparent)] to-[color-mix(in_srgb,var(--color-primary)_8%,transparent)] text-[var(--color-primary)] ring-1 ring-[color-mix(in_srgb,var(--color-primary)_35%,transparent)] transition-transform duration-300 motion-safe:group-hover:scale-105 dark:from-[color-mix(in_srgb,var(--color-primary)_28%,transparent)] dark:to-[color-mix(in_srgb,var(--color-primary)_10%,transparent)]">
                            <span
                                class="absolute inset-0 rounded-[inherit] opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-40 motion-reduce:opacity-0"
                                style="background: radial-gradient(circle, var(--color-primary), transparent 70%);"
                                aria-hidden="true"></span>
                            <svg class="relative h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.09 9.09 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 1 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1 text-start">
                            <p class="text-sm font-bold tabular-nums tracking-wide text-[var(--color-primary)]">
                                02</p>
                            <p class="mt-0.5 text-xs font-medium uppercase tracking-[0.12em] text-[var(--text-muted)]">
                                {{ __('site.footer.commitment') }}</p>
                        </div>
                    </div>
                    <p class="text-base leading-[1.85] text-[var(--text-secondary)] sm:text-[1.05rem]">
                        {{ __('Providing practical and effective technical solutions, backed by technical expertise and ongoing support, to achieve customer satisfaction and build long-term partnerships.') }}
                    </p>
                </article>
            </div>
        </div>
    </section>
@endsection
