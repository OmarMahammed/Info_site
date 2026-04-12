@props([
    'title',
    'subtitle' => null,
    'align' => 'center',
])

@php
    $alignmentClass = match ($align) {
        'left' => 'text-left',
        'right' => 'text-right',
        default => 'text-center',
    };
@endphp

<div {{ $attributes->merge(['class' => "{$alignmentClass} mx-auto max-w-3xl"]) }}>
    @if ($subtitle)
        <p class="mb-4 text-sm font-semibold uppercase tracking-[0.18em]" style="color: var(--color-primary);">
            {{ $subtitle }}
        </p>
    @endif

    <h2 class="heading-lg">
        {{ $title }}
    </h2>
</div>
