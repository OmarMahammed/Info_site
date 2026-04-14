@extends('layouts.app')

@section('title', __('site.meta.home_title') . ' — ' . config('app.name'))

@push('styles')
    <link rel="preload" as="image" href="{{ asset('images/hero/hero-1.jpeg') }}">
@endpush

@section('content')
@php
    $whatsappNumber = config('services.whatsapp.number');
    $whatsappGreeting = rawurlencode(__('site.whatsapp.greeting'));
    $heroSlides = [
        ['image' => 'images/hero/hero-1.jpg'],
        ['image' => 'images/hero/hero-2.jpg'],
    ];
    $productTextAlign = $isRtl ? 'text-right' : 'text-left';
    $productActionsAlign = $isRtl ? 'sm:justify-end' : 'sm:justify-start';
@endphp

{{-- Hero: lightweight slider with fade transitions and centered conversion content --}}
<section
    id="home"
    x-data="heroSlider({{ count($heroSlides) }})"
    x-on:mouseenter="stopAutoplay()"
    x-on:mouseleave="startAutoplay(); resetPointer()"
    x-on:mousemove="handlePointerMove($event)"
    class="hero-stage relative isolate h-[70vh] overflow-hidden md:h-[90vh]"
>
    @foreach ($heroSlides as $index => $slide)
        <div
            x-bind:class="active === {{ $index }} ? 'opacity-100' : 'opacity-0'"
            class="hero-slide absolute inset-0 z-0 transition-opacity duration-1000 ease-out"
            style="will-change: opacity;"
            x-bind:aria-hidden="active === {{ $index }} ? 'false' : 'true'"
        >
            <div class="hero-slide-bg" x-bind:style="getLayerStyle({{ $index }}, 'back')">
                <img
                    src="{{ asset($slide['image']) }}"
                    alt=""
                    width="1920"
                    height="1080"
                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    decoding="async"
                    @if ($index === 0) fetchpriority="high" @endif
                    class="hero-slide-image absolute inset-0 h-full w-full object-cover object-center"
                >
            </div>
            <div class="hero-slide-mid" x-bind:style="getLayerStyle({{ $index }}, 'mid')"></div>
            <div class="hero-slide-front" x-bind:style="getLayerStyle({{ $index }}, 'front')" aria-hidden="true">
                <span class="hero-float hero-float-1"></span>
                <span class="hero-float hero-float-2"></span>
                <span class="hero-float hero-float-3"></span>
            </div>
            <div class="hero-slide-overlay"></div>
        </div>
    @endforeach

    <div class="container-custom relative z-10 flex h-full items-center justify-center py-12 pt-24 md:py-20 md:pt-32">
        <div class="hero-copy mx-auto max-w-4xl text-center text-white" x-bind:style="getContentStyle()">
            @foreach ($heroSlides as $index => $slide)
                <div
                    x-show="active === {{ $index }}"
                    x-cloak
                    x-transition:enter="transition duration-700 ease-out"
                    x-transition:enter-start="translate-y-5 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition duration-500 ease-out"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="-translate-y-2 opacity-0"
                    class="mx-auto"
                    style="will-change: transform, opacity;"
                >
                    <div class="mb-5 flex flex-wrap items-center justify-center gap-2">
                        <span class="inline-flex min-h-8 items-center gap-2 rounded-full border border-white/18 bg-white/10 px-3.5 py-1 text-xs font-semibold tracking-[0.12em] text-white/90 shadow-[0_16px_38px_-28px_rgba(15,23,42,0.45)]" title="المملكة العربية السعودية">
                            <span class="text-base leading-none" aria-hidden="true">🇸🇦</span>
                            <span>{{ __('site.hero.badge') }}</span>
                        </span>
                    </div>
                    <h1 class="text-balance text-4xl font-black leading-[1.05] tracking-tight text-white sm:text-3xl md:text-4xl lg:text-5xl">
                        {{ __('site.hero.title') }}
                    </h1>
                    <p class="mx-auto mt-5 max-w-3xl text-pretty text-lg leading-[1.8] text-white/84 md:text-xl">
                        {{ __('site.hero.subtitle') }}
                    </p>
                    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row sm:gap-4">
                        <a href="#" class="btn-base btn-primary min-h-[52px] w-full sm:min-w-[11rem] sm:w-auto px-8">
                            {{ __('Visit our website') }}
                        </a>
                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappGreeting }}" target="_blank" rel="noopener noreferrer" onclick="trackEvent('whatsapp_click', { location: 'hero' })" class="btn-base min-h-[52px] w-full sm:min-w-[11rem] sm:w-auto border border-white/18 bg-white/10 px-8 text-white shadow-[0_14px_30px_-22px_rgba(15,23,42,0.6)] transition duration-300 hover:-translate-y-0.5 hover:border-white/28 hover:bg-white/14">
                            {{ __('site.hero.secondary_cta') }}
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="mt-8 flex items-center justify-center gap-2">
                @foreach ($heroSlides as $index => $slide)
                    <button
                        type="button"
                        x-on:click="goToSlide({{ $index }})"
                        x-bind:class="active === {{ $index }} ? 'w-8 bg-white' : 'w-3 bg-white/45'"
                        class="h-3 rounded-full transition-[width,background-color] duration-300"
                        aria-label="الانتقال إلى الشريحة {{ $index + 1 }}"
                    ></button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="hero-orbit" aria-hidden="true"></div>
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="absolute bottom-0 left-0 h-40 w-full bg-gradient-to-b from-transparent to-black/90"></div>
</section>

@if ($aboutContent['is_enabled'])
    <x-sections.about :content="$aboutContent" />
@endif

@if ($servicesContent['is_enabled'])
    <x-sections.services :content="$servicesContent" />
@endif

{{-- Products: commercial cards with inquiry CTA and availability state --}}
<section id="products" class="section-shell bg-white dark:bg-gray-900">
    <div class="container-custom">
        <div data-motion-group class="mx-auto mb-12 max-w-2xl text-center md:mb-16">
            <h2 data-motion-item data-motion-order="0" class="text-3xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-4xl">
                {{ __('site.products.title') }}
            </h2>
            <p data-motion-item data-motion-order="1" class="text-muted mt-4 text-base leading-8 md:text-lg">
                {{ __('site.products.subtitle') }}
            </p>
        </div>
        @if ($products->isNotEmpty())
            <div
                x-data="productCinemaSlider({{ $products->count() }})"
                class="product-slider relative mx-auto h-[80vh] min-h-[34rem] max-h-[52rem] w-full max-w-[1380px] overflow-hidden rounded-[1.75rem] border border-gray-200/70 bg-[#070b12] shadow-[0_35px_100px_-45px_rgba(15,23,42,0.7)] dark:border-gray-800/70"
            >
                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(249,115,22,0.2),_transparent_35%),radial-gradient(circle_at_bottom,_rgba(59,130,246,0.15),_transparent_30%)]"></div>
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-white/5 via-transparent to-black/30"></div>

                @foreach ($products as $index => $product)
                    @php
                        $productImage = $product->image_url;
                        $productInquiryMessage = rawurlencode('السلام عليكم، حاب أستفسر عن منتج ' . $product->name);
                    @endphp

                    <article
                        x-bind:style="getSlideStyle({{ $index }})"
                        x-bind:aria-hidden="active === {{ $index }} ? 'false' : 'true'"
                        class="product-card absolute inset-0 p-3 transition-[transform,opacity,filter] duration-500 ease-in-out md:p-4"
                    >
                        <div class="grid h-full w-full grid-cols-1 overflow-hidden rounded-[1.5rem] border border-white/10 bg-slate-950/65 shadow-[inset_0_1px_0_rgba(255,255,255,0.06)] backdrop-blur-sm lg:grid-cols-[0.88fr_1.12fr]">
                            <div
                                x-bind:style="getMediaStyle({{ $index }})"
                                class="product-card__media order-1 relative h-[42vh] min-h-[18rem] overflow-hidden transition-[transform,opacity] duration-500 ease-in-out lg:order-2 lg:h-full"
                            >
                                <img
                                    src="{{ $productImage }}"
                                    alt="{{ $product->name }}"
                                    width="960"
                                    height="1080"
                                    loading="lazy"
                                    decoding="async"
                                    class="h-full w-full object-cover object-center"
                                >
                                <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/10 to-black/50 lg:bg-gradient-to-r lg:from-transparent lg:via-black/10 lg:to-black/55"></div>
                            </div>

                            <div class="order-2 flex h-full items-center lg:order-1">
                                <div
                                    x-bind:style="getTextStyle({{ $index }})"
                                    class="product-card__text w-full px-6 py-8 {{ $productTextAlign }} text-white transition-[transform,opacity] duration-500 ease-in-out sm:px-8 md:px-10 lg:px-12"
                                >
                                    <span class="inline-flex min-h-8 items-center rounded-full border border-white/15 bg-white/6 px-3 py-1 text-xs font-semibold tracking-[0.12em] text-orange-200">
                                        {{ __('site.products.featured') }}
                                    </span>
                                    <h3 class="mt-5 max-w-xl text-3xl font-black leading-tight text-white md:text-4xl lg:text-5xl">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="mt-5 max-w-xl text-sm leading-8 text-gray-300 md:text-base">
                                        {{ $product->description ?: __('site.products.default_description') }}
                                    </p>

                                    <div class="mt-8 flex flex-col items-stretch gap-4 sm:flex-row sm:items-center {{ $productActionsAlign }}">
                                        <a
                                            href="https://wa.me/{{ $whatsappNumber }}?text={{ $productInquiryMessage }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            onclick="trackEvent('product_inquiry', { name: @js($product->name), location: 'cinema_slider' })"
                                            class="product-card__cta btn-base btn-primary min-h-[52px] min-w-[11rem] justify-center px-8"
                                        >
                                            {{ __('site.products.inquiry') }}
                                        </a>
                                        <span class="text-xs font-medium tracking-[0.12em] text-gray-400">
                                            {{ __('site.products.availability') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach

                @if ($products->count() > 1)
                    <div class="product-slider__nav absolute inset-x-0 top-1/2 z-40 flex -translate-y-1/2 items-center justify-between px-3 sm:px-5">
                        <button
                            type="button"
                            x-on:click="prev()"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 bg-black/35 text-white backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:border-white/30 hover:bg-white hover:text-black"
                            aria-label="{{ __('site.products.previous') }}"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 6l-6 6 6 6" />
                            </svg>
                        </button>

                        <button
                            type="button"
                            x-on:click="next()"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 bg-black/35 text-white backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:border-white/30 hover:bg-white hover:text-black"
                            aria-label="{{ __('site.products.next') }}"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 6l6 6-6 6" />
                            </svg>
                        </button>
                    </div>

                    <div class="product-slider__dots absolute inset-x-0 bottom-5 z-40 flex items-center justify-center gap-2">
                        @foreach ($products as $index => $product)
                            <button
                                type="button"
                                x-on:click="goToSlide({{ $index }})"
                                x-bind:class="active === {{ $index }} ? 'w-10 bg-white' : 'w-3 bg-white/35'"
                                class="h-3 rounded-full transition-[width,background-color] duration-300"
                                aria-label="{{ __('site.products.go_to', ['number' => $index + 1]) }}"
                            ></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800/40 dark:text-gray-400">
                {{ __('site.products.empty') }}
            </div>
        @endif
    </div>
</section>

@if ($trustContent['is_enabled'])
    <x-sections.trust-conversion
        :content="$trustContent"
        :whatsapp-number="$whatsappNumber"
    />
@endif

{{-- Contact CTA: real lead capture with WhatsApp and form --}}
<section
    id="contact"
    x-data="contactForm({
        validationError: @js(__('site.contact.form.validation_error')),
        genericError: @js(__('site.contact.form.generic_error')),
        networkError: @js(__('site.contact.form.network_error')),
        successMessage: @js(__('site.contact.success')),
        phoneInvalid: @js(__('site.contact.form.phone_invalid')),
    })"
    class="contact-section section-shell"
>
    <div class="container-custom">
        <div
            x-cloak
            x-show="toastVisible"
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="translate-y-2 scale-95 opacity-0"
            x-transition:enter-end="translate-y-0 scale-100 opacity-100"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="translate-y-0 scale-100 opacity-100"
            x-transition:leave-end="translate-y-2 scale-95 opacity-0"
            class="fixed right-5 top-5 z-[80] rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-2xl shadow-emerald-950/30"
        >
            <span x-text="toastMessage"></span>
        </div>

        <div data-animate class="hidden-anim transform-gpu contact-panel mx-auto max-w-5xl text-center" data-motion-group>
            <span data-motion-item data-motion-order="0" class="section-kicker contact-kicker">
                {{ __('site.contact.kicker') }}
            </span>
            <h2 data-motion-item data-motion-order="1" class="mt-6 text-3xl font-bold tracking-tight md:text-5xl">
                {{ __('site.contact.title') }}
            </h2>
            <p data-motion-item data-motion-order="2" class="mx-auto mt-5 max-w-2xl text-base leading-8 text-[var(--text-secondary)] md:text-lg">
                {{ __('site.contact.description') }}
            </p>

            <div data-motion-item data-motion-order="3" class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappGreeting }}" target="_blank" rel="noopener noreferrer" onclick="trackEvent('whatsapp_click', { location: 'contact_section' })" class="btn-base btn-primary min-h-[52px] min-w-[11rem] px-8">
                    {{ __('site.contact.whatsapp') }}
                </a>
                <a href="tel:+201014061724" class="btn-base btn-secondary min-h-[52px] min-w-[11rem] px-8">
                    {{ __('site.contact.call') }}
                </a>
            </div>

            <p data-motion-item data-motion-order="4" class="mt-6 text-sm text-[var(--text-muted)]">
                {{ __('site.contact.helper') }}
            </p>

            @if (session('success'))
                <div class="mx-auto mt-6 max-w-2xl rounded-2xl border border-emerald-400/25 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-700 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div data-motion-item data-motion-order="5" class="mx-auto mt-10 max-w-2xl text-center">
                <form
                    id="contactForm"
                    x-ref="form"
                    x-on:submit.prevent="submit"
                    action="{{ route('contact.store', ['locale' => $locale]) }}"
                    method="POST"
                    class="contact-form space-y-5 p-6 sm:p-8"
                >
                    @csrf

                    <div x-show="errorMessage" x-transition.opacity class="rounded-xl border border-red-300/30 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 dark:border-red-400/20 dark:bg-red-500/10 dark:text-red-200">
                        <span x-text="errorMessage"></span>
                    </div>

                    <div class="space-y-2 text-start">
                        <label for="name" class="contact-label">{{ __('site.contact.form.name') }}</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            class="contact-input"
                            placeholder="{{ __('site.contact.form.name_placeholder') }}"
                            required
                        >
                        <p x-show="errors.name" class="text-xs text-red-600 dark:text-red-300" x-text="errors.name?.[0]"></p>
                        @error('name')
                            <p class="text-xs text-red-600 dark:text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2 text-start">
                        <label for="phone" class="contact-label">{{ __('site.contact.form.phone') }}</label>
                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            inputmode="numeric"
                            autocomplete="tel"
                            maxlength="10"
                            pattern="05[0-9]{8}"
                            title="{{ __('site.contact.form.phone_invalid') }}"
                            value="{{ old('phone') }}"
                            class="contact-input"
                            placeholder="{{ __('site.contact.form.phone_placeholder') }}"
                            required
                        >
                        <p x-show="errors.phone" class="text-xs text-red-600 dark:text-red-300" x-text="errors.phone?.[0]"></p>
                        @error('phone')
                            <p class="text-xs text-red-600 dark:text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2 text-start">
                        <label for="message" class="contact-label">{{ __('site.contact.form.message') }}</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            class="contact-input"
                            placeholder="{{ __('site.contact.form.message_placeholder') }}"
                            required
                        >{{ old('message') }}</textarea>
                        <p x-show="errors.message" class="text-xs text-red-600 dark:text-red-300" x-text="errors.message?.[0]"></p>
                        @error('message')
                            <p class="text-xs text-red-600 dark:text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        x-bind:disabled="loading"
                        class="btn-base btn-primary min-h-[54px] w-full justify-center disabled:cursor-not-allowed disabled:opacity-70"
                    >
                        <svg x-show="loading" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span x-text="loading ? @js(__('site.contact.form.submitting')) : @js(__('site.contact.form.submit'))"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
