@props([
    'content' => [],
])

@php
    $badge = $content['badge'];
    $title = $content['title'];
    $description = $content['description'];
    $spotlightLabel = $content['spotlight_label'];
    $spotlightCtaLabel = $content['spotlight_cta_label'];
    $detailLabel = $content['detail_label'];
    $services = collect($content['items'])
        ->filter(fn ($item) => filled($item['title'] ?? null) && ($item['is_visible'] ?? true))
        ->values()
        ->all();
    $meta = collect($content['meta'])->pluck('label')->filter()->values();
@endphp

<section id="services" class="services-section" data-cinematic-section data-section-depth="16">
    <div class="container-custom">
        <div
            class="services-layout"
            x-data="servicesShowcase(@js(array_values($services)))"
        >
            <div data-animate class="services-intro hidden-anim transform-gpu" data-motion-group>
                <span class="services-badge" data-motion-item data-motion-order="0">{{ $badge }}</span>

                <h2 class="services-title" data-motion-item data-motion-order="1">
                    {{ $title }}
                </h2>

                <p class="services-copy" data-motion-item data-motion-order="2">
                    {{ $description }}
                </p>

                <div class="services-meta" aria-hidden="true" data-motion-item data-motion-order="3">
                    @foreach ($meta as $item)
                        <span>{{ $item }}</span>
                    @endforeach
                </div>

                <div
                    class="services-spotlight"
                    x-bind:data-transitioning="isTransitioning ? 'true' : 'false'"
                    x-bind:style="spotlightStyle()"
                    data-motion-item
                    data-motion-order="4"
                >
                    <div class="services-spotlight-label">
                        <span>{{ $spotlightLabel }}</span>
                        <span
                            class="services-spotlight-index"
                            x-bind:data-phase="spotlightPhase"
                            x-text="displayedIndexLabel()"
                        ></span>
                    </div>

                    <div class="services-spotlight-progress" aria-hidden="true">
                        <span class="services-spotlight-progress-bar"></span>
                    </div>

                    <div class="services-spotlight-body" x-bind:data-phase="spotlightPhase">
                        <h3 class="services-spotlight-title" x-text="displayedItem().title"></h3>

                        <p class="services-spotlight-copy" x-text="displayedItem().desc"></p>

                        <a href="#contact" class="btn-base btn-primary services-spotlight-link">
                            {{ $spotlightCtaLabel }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="services-rail" data-stagger-root>
                @foreach ($services as $index => $service)
                    <article
                        data-stagger-index="{{ $index }}"
                        tabindex="0"
                        role="button"
                        aria-label="{{ $service['title'] }}"
                        class="services-card stagger-card hidden-anim transform-gpu"
                        x-bind:data-active="isActive({{ $index }}) ? 'true' : 'false'"
                        x-bind:style="getItemStyle({{ $index }})"
                        x-on:mouseenter="setActive({{ $index }})"
                        x-on:focusin="setActive({{ $index }})"
                        x-on:click="setActive({{ $index }})"
                        x-on:keydown.enter.prevent="setActive({{ $index }})"
                        x-on:keydown.space.prevent="setActive({{ $index }})"
                    >
                        <div class="services-card-head">
                            <div>
                                <span class="services-card-index">0{{ $index + 1 }}</span>
                                <h3 class="services-card-title">
                                    {{ $service['title'] }}
                                </h3>
                            </div>

                            <span class="info-icon-wrap" aria-hidden="true">
                                <x-ui.feature-icon :name="$service['icon']" class="h-5 w-5" />
                            </span>
                        </div>

                        <p class="services-card-copy">
                            {{ $service['desc'] }}
                        </p>

                        <div class="services-card-tail">
                            <span>{{ $detailLabel }}</span>
                            <span class="services-card-arrow" aria-hidden="true">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M15 7l-6 5 6 5" />
                                </svg>
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
