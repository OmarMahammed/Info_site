@extends('layouts.app')

@section('title', ($policy ?? null) ? $policy->getTitle().' — '.config('app.name') : __('site.meta.privacy_title').' — '.config('app.name'))

@section('content')

@php
    $sections = [
        ['key' => 'intro', 'index' => '01'],
        ['key' => 'account', 'index' => '02'],
        ['key' => 'communication', 'index' => '03'],
        ['key' => 'reviews', 'index' => '04'],
    ];
    $useDynamicPolicy = $policy && $policy->is_active;
    $dynamicSections = $useDynamicPolicy ? $policy->getSectionsForLocale(app()->getLocale()) : [];
    $isRtl = app()->getLocale() === 'ar';
@endphp

<section class="privacy-section">
    <div class="container-custom">

        @if ($useDynamicPolicy)
            {{-- Managed from Filament --}}
            <div data-animate class="privacy-header hidden-anim transform-gpu" data-motion-group>
                <span class="privacy-kicker" data-motion-item data-motion-order="0">
                    {{ __('site.privacy.title') }}
                </span>

                <h1 class="privacy-title" data-motion-item data-motion-order="1">
                    {{ $policy->getTitle() }}
                </h1>

                <p class="privacy-subtitle" data-motion-item data-motion-order="2">
                    {{ __('site.privacy.subtitle') }}
                </p>

                <p class="privacy-date" data-motion-item data-motion-order="3">
                    {{ __('site.privacy.updated') }}
                    <span>{{ $policy->updated_at?->translatedFormat('d M Y') }}</span>
                </p>
            </div>

            <div class="privacy-blocks mt-8" data-stagger-root dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
                @forelse ($dynamicSections as $index => $section)
                    <article
                        data-stagger-index="{{ $index }}"
                        class="privacy-block stagger-card hidden-anim transform-gpu p-6 md:p-8 {{ $isRtl ? 'text-right' : 'text-left' }}"
                        data-motion-group
                    >
                        <div class="privacy-block-head mb-4" data-motion-item data-motion-order="0">
                            <span class="privacy-block-index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

                            <h2 class="privacy-block-title text-xl md:text-2xl">
                                {{ $section['title'] }}
                            </h2>
                        </div>

                        <p class="privacy-block-text text-sm md:text-base" data-motion-item data-motion-order="1">
                            {{ $section['description'] }}
                        </p>
                    </article>
                @empty
                    <article class="privacy-block hidden-anim transform-gpu p-6 md:p-8 text-center">
                        <p class="privacy-block-text">
                            {{ __('site.privacy.subtitle') }}
                        </p>
                    </article>
                @endforelse
            </div>

            <div data-animate class="privacy-commitment hidden-anim transform-gpu mt-12" data-motion-group>
                <p data-motion-item data-motion-order="0">
                    {{ __('site.privacy.commitment') }}
                </p>
            </div>
        @else
            {{-- Fallback: translation-based static sections --}}
            <div data-animate class="privacy-header hidden-anim transform-gpu" data-motion-group>
                <span class="privacy-kicker" data-motion-item data-motion-order="0">
                    {{ __('site.privacy.title') }}
                </span>

                <h1 class="privacy-title" data-motion-item data-motion-order="1">
                    {{ __('site.privacy.title') }}
                </h1>

                <p class="privacy-subtitle" data-motion-item data-motion-order="2">
                    {{ __('site.privacy.subtitle') }}
                </p>

                <p class="privacy-date" data-motion-item data-motion-order="3">
                    {{ __('site.privacy.updated') }} <span>{{ now()->format('d M Y') }}</span>
                </p>
            </div>

            <div class="privacy-blocks" data-stagger-root>
                @foreach ($sections as $i => $section)
                    <article
                        data-stagger-index="{{ $i }}"
                        class="privacy-block stagger-card hidden-anim transform-gpu"
                        data-motion-group
                    >
                        <div class="privacy-block-head" data-motion-item data-motion-order="0">
                            <span class="privacy-block-index">{{ $section['index'] }}</span>

                            <h2 class="privacy-block-title">
                                {{ __('site.privacy.'.$section['key'].'_title') }}
                            </h2>
                        </div>

                        <p class="privacy-block-text" data-motion-item data-motion-order="1">
                            {{ __('site.privacy.'.$section['key'].'_text') }}
                        </p>
                    </article>
                @endforeach
            </div>

            <div data-animate class="privacy-commitment hidden-anim transform-gpu" data-motion-group>
                <p data-motion-item data-motion-order="0">
                    {{ __('site.privacy.commitment') }}
                </p>
            </div>
        @endif

    </div>
</section>

@endsection
