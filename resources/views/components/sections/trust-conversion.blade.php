@props([
    'content' => [],
    'whatsappNumber' => null,
])

@php
    $kicker = $content['kicker'];
    $title = $content['title'];
    $description = $content['description'];
    $storyTag = $content['story_tag'];
    $evidenceTitle = $content['evidence_title'];
    $ctaTitle = $content['cta_title'];
    $ctaCopy = $content['cta_copy'];
    $ctaUrgency = $content['cta_urgency'];
    $ctaPrimaryLabel = $content['cta_primary_label'];
    $ctaSecondaryLabel = $content['cta_secondary_label'];
    $ctaMicrocopy = $content['cta_microcopy'];
    $whatsappMessage = $content['whatsapp_message'];
    $stats = collect($content['stats'])->values()->all();
    $testimonials = collect($content['testimonials'])
        ->filter(fn ($item) => $item['is_visible'] ?? true)
        ->values()
        ->all();
    $logos = collect($content['logos'])->pluck('label')->filter()->values()->all();
    $guarantees = collect($content['guarantees'])->pluck('label')->filter()->values()->all();
    $safetyItems = collect($content['safety'])->pluck('label')->filter()->values()->all();
@endphp

<section
    id="trust"
    class="trust-section"
    data-cinematic-section
    data-section-depth="14"
    x-data="trustConversion({
        stats: @js(array_values($stats)),
        testimonials: @js(array_values($testimonials)),
    })"
>
    <div class="container-custom trust-shell">
        <div data-animate class="trust-header hidden-anim transform-gpu" data-motion-group>
            <span class="trust-kicker" data-motion-item data-motion-order="0">{{ $kicker }}</span>

            <h2 class="trust-title text-3xl md:text-3xl lg:text-4xl" data-motion-item data-motion-order="1">
                {{ $title }}
            </h2>

            <p class="trust-copy" data-motion-item data-motion-order="2">
                {{ $description }}
            </p>
        </div>

        <div class="trust-ribbon" data-stagger-root>
            @foreach ($logos as $index => $logo)
                <span data-stagger-index="{{ $index }}" class="trust-ribbon-item stagger-card hidden-anim transform-gpu">
                    {{ $logo }}
                </span>
            @endforeach
        </div>

        <div class="trust-stage">
            <article data-animate class="trust-story hidden-anim transform-gpu" data-motion-group>
                <div class="trust-story-head" data-motion-item data-motion-order="0">
                    <span class="trust-story-tag">{{ $storyTag }}</span>

                    <div class="trust-story-dots" aria-label="{{ __('site.trust.testimonials_label') }}">
                        <template x-for="(testimonial, index) in testimonials" :key="index">
                            <button
                                type="button"
                                x-bind:data-active="index === activeTestimonial ? 'true' : 'false'"
                                x-on:click="goToTestimonial(index)"
                                x-bind:aria-label="`${@js(__('site.trust.go_to_testimonial', ['number' => '__NUMBER__'])).replace('__NUMBER__', index + 1)}`"
                            ></button>
                        </template>
                    </div>
                </div>

                <div class="trust-quote-wrap" data-motion-item data-motion-order="1">
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <div
                            x-show="activeTestimonial === index"
                            x-transition:enter="transition duration-500 ease-out"
                            x-transition:enter-start="translate-y-4 opacity-0"
                            x-transition:enter-end="translate-y-0 opacity-100"
                            x-transition:leave="transition duration-300 ease-out"
                            x-transition:leave-start="translate-y-0 opacity-100"
                            x-transition:leave-end="-translate-y-3 opacity-0"
                            x-cloak
                            class="trust-quote"
                        >
                            <div>
                                <span class="trust-quote-mark" aria-hidden="true">"</span>
                                <p class="trust-quote-text" x-text="testimonial.quote"></p>
                            </div>

                            <div class="trust-quote-foot">
                                <span class="trust-quote-author" x-text="testimonial.author"></span>
                                <span class="trust-quote-company" x-text="testimonial.company"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="trust-guarantees" data-motion-item data-motion-order="2">
                    @foreach ($guarantees as $guarantee)
                        <span class="trust-guarantee">
                            <span aria-hidden="true">✔</span>
                            <span>{{ $guarantee }}</span>
                        </span>
                    @endforeach
                </div>
            </article>

            <aside data-animate class="trust-evidence hidden-anim transform-gpu" data-motion-group>
                <p class="trust-evidence-title" data-motion-item data-motion-order="0">{{ $evidenceTitle }}</p>

                <div class="trust-stat-list" data-motion-item data-motion-order="1">
                    @foreach ($stats as $index => $stat)
                        <div class="trust-stat">
                            <div class="trust-stat-value">
                                <span x-text="formattedStat({{ $index }})">0</span>
                                @if (!empty($stat['suffix']))
                                    <span class="trust-stat-suffix">{{ $stat['suffix'] }}</span>
                                @endif
                            </div>

                            <p class="trust-stat-label">{{ $stat['label'] }}</p>
                            <p class="trust-stat-note">{{ $stat['note'] }}</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>

        <div data-animate class="trust-cta-dock hidden-anim transform-gpu" data-motion-group>
            <div class="trust-cta-layout">
                <div>
                    <h3 class="trust-cta-title" data-motion-item data-motion-order="0">{{ $ctaTitle }}</h3>
                    <p class="trust-cta-copy" data-motion-item data-motion-order="1">
                        {{ $ctaCopy }}
                    </p>

                    <p class="trust-cta-urgency" data-motion-item data-motion-order="2">
                        {{ $ctaUrgency }}
                    </p>

                    <div class="trust-safety" data-motion-item data-motion-order="3">
                        @foreach ($safetyItems as $item)
                            <span>{{ $item }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="trust-cta-actions" data-motion-item data-motion-order="4">
                    <div class="trust-cta-primary-wrap">
                        <a
                            href="#contact"
                            onclick="trackEvent('cta_click', { location: 'trust_section', type: 'contact_form' })"
                            class="btn-base btn-primary trust-cta-primary"
                        >
                            <span class="trust-cta-primary-dot" aria-hidden="true"></span>
                            <span>{{ $ctaPrimaryLabel }}</span>
                            <svg class="trust-cta-primary-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h8m-4-4 4 4-4 4" />
                            </svg>
                        </a>

                        <p class="trust-cta-microcopy">
                            {{ $ctaMicrocopy }}
                        </p>
                    </div>

                    <a
                        href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode($whatsappMessage) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        onclick="trackEvent('whatsapp_click', { location: 'trust_section' })"
                        class="btn-base trust-cta-secondary"
                    >
                        {{ $ctaSecondaryLabel }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
