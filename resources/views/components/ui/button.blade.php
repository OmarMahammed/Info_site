@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
])

@php
    $baseClass = 'btn-base';
    $variantClass = match ($variant) {
        'secondary' => 'btn-secondary',
        'ghost' => 'btn-ghost',
        default => 'btn-primary',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseClass} {$variantClass}"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "{$baseClass} {$variantClass}"]) }}>
        {{ $slot }}
    </button>
@endif
