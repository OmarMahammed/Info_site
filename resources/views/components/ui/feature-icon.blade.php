@props([
    'name',
])

@switch($name)
    @case('bolt')
        <svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 2L4 14h6l-1 8 9-12h-6l1-8z" />
        </svg>
        @break

    @case('shield')
        <svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.5 12.5l1.7 1.7 3.3-3.7" />
        </svg>
        @break

    @case('headset')
        <svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 13a8 8 0 1116 0" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13h2a2 2 0 012 2v3a2 2 0 01-2 2H5v-7zm12 2a2 2 0 012-2h2v7h-2a2 2 0 01-2-2v-3z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20h6" />
        </svg>
        @break

    @case('sliders')
        <svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
            <circle cx="9" cy="6" r="2" stroke-width="1.8" />
            <circle cx="15" cy="12" r="2" stroke-width="1.8" />
            <circle cx="11" cy="18" r="2" stroke-width="1.8" />
        </svg>
        @break

    @case('monitor')
        <svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <rect x="3" y="5" width="18" height="12" rx="2" stroke-width="1.8" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 21h8M12 17v4" />
        </svg>
        @break

    @case('network')
        <svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5a7 7 0 017 7M12 9a3 3 0 013 3M5 12a7 7 0 017-7" />
            <circle cx="12" cy="16" r="2" stroke-width="1.8" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 20h8" />
        </svg>
        @break

    @case('boxes')
        <svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l7 4-7 4-7-4 7-4z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 7v8l7 4 7-4V7" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 11v8" />
        </svg>
        @break

    @case('wrench')
        <svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.5 6.5a4 4 0 01-5 5L4 17l3 3 5.5-5.5a4 4 0 005-5l-3 1-1-4z" />
        </svg>
        @break
@endswitch
