@props([
    'content' => [],
])

@php
    $badge = $content['badge'];
    $title = $content['title'];
    $subtitle = $content['subtitle'];
    $description = $content['description'];
    $ctaLabel = $content['cta_label'];
    $imageUrl = $content['image_url'];
    $imageAlt = $content['image_alt'];
    $features = collect($content['features'])
        ->pluck('label')
        ->filter()
        ->values();
@endphp

<section id="about" class="about-section" data-cinematic-section data-section-depth="20">
    <div class="about-bg">
        <img
            src="{{ $imageUrl }}"
            alt="{{ $imageAlt }}"
            width="1800"
            height="1200"
            loading="lazy"
            decoding="async"
        >
    </div>

    <div class="about-overlay"></div>

    <div class="about-content" data-motion-group>
        <span class="about-badge" data-motion-item data-motion-order="0">{{ $badge }}</span>

        <h2 data-motion-item data-motion-order="1">{{ $title }}</h2>

        <p class="about-sub" data-motion-item data-motion-order="2">
            {{ $subtitle }}
        </p>

        <p class="about-desc" data-motion-item data-motion-order="3">
            {{ $description }}
        </p>

        <div class="about-features" data-motion-item data-motion-order="4">
            @foreach ($features as $feature)
                <span>✔ {{ $feature }}</span>
            @endforeach
        </div>

        <a href="#contact" class="about-btn" data-motion-item data-motion-order="5">{{ $ctaLabel }}</a>
    </div>
</section>
