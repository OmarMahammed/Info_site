@extends('layouts.app')

@section('title', __('site.meta.privacy_title') . ' — ' . config('app.name'))

@section('content')

@php
    $sections = [
        ['key' => 'intro',         'index' => '01'],
        ['key' => 'account',       'index' => '02'],
        ['key' => 'communication', 'index' => '03'],
        ['key' => 'reviews',       'index' => '04'],
    ];
@endphp

<section class="privacy-section">
    <div class="container-custom">

        {{-- Header --}}
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

        {{-- Content blocks --}}
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
                            {{ __('site.privacy.' . $section['key'] . '_title') }}
                        </h2>
                    </div>

                    <p class="privacy-block-text" data-motion-item data-motion-order="1">
                        {{ __('site.privacy.' . $section['key'] . '_text') }}
                    </p>
                </article>
            @endforeach
        </div>

        {{-- Commitment footer --}}
        <div data-animate class="privacy-commitment hidden-anim transform-gpu" data-motion-group>
            <p data-motion-item data-motion-order="0">
                {{ __('site.privacy.commitment') }}
            </p>
        </div>

    </div>
</section>

@endsection
