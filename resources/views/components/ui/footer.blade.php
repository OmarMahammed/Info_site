@php
    $homeUrl = route('home', ['locale' => app()->getLocale()]);
@endphp

<footer data-animate class="hidden-anim transform-gpu border-t bg-[#0d1117] text-gray-300"
    style="border-color: rgba(255,255,255,0.12);">
    <div class="container-custom py-16">
        <div class="mb-10 flex flex-col items-center justify-center gap-4 border-b border-white/10 pb-8 text-center">
            <img src="{{ asset('images/Saudi logo.png') }}" alt="" width="72" height="72"
                class="h-16 w-auto object-contain opacity-95" loading="lazy" decoding="async">
            <p class="max-w-xl text-sm leading-relaxed text-gray-300">
                {{ __('site.footer.saudi_pride') }} <span class="select-none" aria-hidden="true">🇸🇦</span>
            </p>
            <p class="text-xs text-gray-400">
                {{ __('site.footer.saudi_regions') }} 🇸🇦
            </p>
            <span
                class="inline-flex items-center rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs text-gray-400">
                {{ __('site.footer.saudi_badge') }}
            </span>
        </div>

        <div class="mb-10 h-0.5 w-20 rounded-full"
            style="background: linear-gradient(90deg, var(--color-primary), rgba(200,110,54,0));"></div>

        <div class="grid gap-10 md:grid-cols-3">
            {{-- Brand --}}
            <div>
                <a href="{{ $homeUrl }}" class="mb-2 inline-flex items-center">
                    <div
                        class="px-2 py-1 rounded-lg bg-white/95 dark:bg-white/15 transition-all duration-300 dark:shadow-[0_0_15px_rgba(255,115,0,0.25)]">
                        <img src="{{ asset('images/logo.png') }}" alt="Al Kayan Technology"
                            class="h-14 w-auto object-contain" loading="lazy" decoding="async">
                    </div>
                </a>
                <h3 class="mt-5 text-lg font-semibold text-white">
                    Al Kayan Technology
                </h3>
                <p class="mt-3 max-w-sm text-sm leading-7 text-gray-400">
                    {{ __('site.footer.brand_description') }}
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-white">
                    {{ __('site.nav.quick_links') }}
                </h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('about', ['locale' => app()->getLocale()]) }}"
                            class="text-sm text-gray-400 transition-all duration-300 hover:text-[var(--color-primary)]">{{ __('site.nav.about') }}</a>
                    </li>
                    <li><a href="{{ route('services', ['locale' => app()->getLocale()]) }}"
                            class="text-sm text-gray-400 transition-all duration-300 hover:text-[var(--color-primary)]">{{ __('site.nav.services') }}</a>
                    </li>
                    <li><a href="{{ route('trust', ['locale' => app()->getLocale()]) }}"
                            class="text-sm text-gray-400 transition-all duration-300 hover:text-[var(--color-primary)]">{{ __('site.nav.trust-conversion') }}</a>
                    </li>
                    <li><a href="#products"
                            class="text-sm text-gray-400 transition-all duration-300 hover:text-[var(--color-primary)]">{{ __('site.nav.products') }}</a>
                    </li>
                    <li><a href="#contact"
                            class="text-sm text-gray-400 transition-all duration-300 hover:text-[var(--color-primary)]">{{ __('site.nav.contact') }}</a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-white">
                    {{ __('site.nav.contact') }}
                </h3>
                <ul class="mt-4 space-y-2">
                    <li class="text-sm text-gray-400">info@alkayantech.sa</li>
                    <li class="text-sm text-gray-400">+966 11 000 0000</li>
                    <li class="text-sm text-gray-400">{{ __('site.footer.location') }}</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t pt-8 text-center" style="border-color: rgba(255,255,255,0.12);">
            <p class="text-sm text-gray-500">
                &copy; {{ date('Y') }} Al Kayan Technology. {{ __('site.footer.rights') }}
            </p>
        </div>
    </div>
</footer>