@extends('layouts.app')

@section('title', __('site.products.title') . ' — ' . config('app.name'))

@push('styles')
    @if($products->isNotEmpty() && $products->first()->image)
        <link rel="preload" as="image" href="{{ $products->first()->image_url }}">
    @endif
@endpush

@section('content')
    @php
        $whatsappNumber = config('services.whatsapp.number');
        $locale = app()->getLocale();
        $isRtl = $locale === 'ar';
        $productItems = $products->map(fn($p) => [
            'name' => $p->name,
            'desc' => $p->description ?: __('site.products.default_description'),
            'image' => $p->image_url,
            'inquiry' => 'https://wa.me/' . $whatsappNumber . '?text=' . rawurlencode(
                $isRtl
                ? 'السلام عليكم، حاب أستفسر عن منتج ' . $p->name
                : 'Hello, I would like to inquire about ' . $p->name
            ),
        ])->values();
    @endphp

    <div class="pdp" x-data="productShowcase({{ $productItems->toJson() }})" x-init="init()">
        {{-- Hero --}}
        <section class="pdp-hero">
            <div class="pdp-hero__inner container-custom">
                <span class="pdp-kicker" data-motion-item data-motion-order="0">{{ __('site.products.featured') }}</span>
                <h1 class="pdp-hero__title" data-motion-item data-motion-order="1">{{ __('site.products.title') }}</h1>
                <p class="pdp-hero__sub" data-motion-item data-motion-order="2">{{ __('site.products.subtitle') }}</p>
            </div>
        </section>

        @if($products->isNotEmpty())
            <section class="pdp-stage container-custom">
                {{-- LEFT: Sticky spotlight --}}
                <div class="pdp-spotlight" aria-live="polite">
                    <div class="pdp-spotlight__media">
                        <img x-bind:src="activeProduct().image" x-bind:alt="activeProduct().name" width="720" height="720"
                            loading="eager" decoding="async" class="pdp-spotlight__img">
                    </div>

                    <div class="pdp-spotlight__body">
                        <div class="pdp-spotlight__content" x-bind:data-phase="spotlightPhase">
                            <p class="pdp-spotlight__counter" x-text="counterLabel()"></p>
                            <h2 class="pdp-spotlight__title" x-text="displayedProduct().name"></h2>
                            <p class="pdp-spotlight__desc" x-text="displayedProduct().desc"></p>
                            <a x-bind:href="displayedProduct().inquiry" target="_blank" rel="noopener noreferrer"
                                class="btn-base btn-primary pdp-spotlight__cta">{{ __('site.products.inquiry') }}</a>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Vertical rail --}}
                <div class="pdp-rail" x-ref="rail">
                    @foreach($products as $index => $product)
                        @php $productImage = $product->image_url; @endphp
                        <article class="pdp-item" data-pdp-index="{{ $index }}"
                            x-bind:data-active="active === {{ $index }} ? 'true' : 'false'"
                            x-on:mouseenter="handleHover({{ $index }})" x-on:mouseleave="handleHoverLeave()"
                            x-on:focusin="setActive({{ $index }}, true)" x-on:click="setActive({{ $index }}, true)" tabindex="0"
                            role="button" aria-label="{{ $product->name }}">
                            <div class="pdp-item__media">
                                <img src="{{ $productImage }}" alt="{{ $product->name }}" width="280" height="280" loading="lazy"
                                    decoding="async" class="pdp-item__img">
                            </div>
                            <div class="pdp-item__body">
                                <span class="pdp-item__index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="pdp-item__title">{{ $product->name }}</h3>
                                <p class="pdp-item__desc">
                                    {{ Str::limit($product->description ?: __('site.products.default_description'), 120) }}
                                </p>
                            </div>
                            <span class="pdp-item__arrow" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 6l6 6-6 6" />
                                </svg>
                            </span>
                        </article>
                    @endforeach
                </div>
            </section>
        @else
            <div class="container-custom" style="padding-block: 6rem;">
                <div
                    class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800/40 dark:text-gray-400">
                    {{ __('site.products.empty') }}
                </div>
            </div>
        @endif
    </div>

    <div class="container-custom mt-8 mb-10 flex justify-center md:mt-12 md:mb-14">
        <a
            href="#"
            class="inline-flex max-w-fit items-center justify-center rounded-xl bg-[var(--color-primary)] px-6 py-3 text-sm font-medium text-white shadow-[0_10px_28px_-14px_rgba(200,110,54,0.55)] transition-all duration-200 ease-out hover:-translate-y-px hover:scale-[1.02] hover:opacity-95 hover:shadow-[0_14px_36px_-16px_rgba(200,110,54,0.5)] active:scale-[0.98] active:translate-y-0 dark:text-white dark:shadow-[0_10px_28px_-12px_rgba(0,0,0,0.45)] dark:hover:brightness-105 dark:hover:opacity-100 md:text-base"
        >
            {{ __('site.products.more') }}
        </a>
    </div>
@endsection