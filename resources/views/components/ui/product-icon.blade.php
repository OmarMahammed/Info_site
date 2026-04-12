@props(['name' => 'keyboard'])

@php
    $cls = 'h-5 w-5 shrink-0 text-orange-500 dark:text-orange-400';
@endphp

@switch($name)
    @case('keyboard')
        <svg {{ $attributes->merge(['class' => $cls]) }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 9a2 2 0 012-2h12a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 13h.01M12 13h.01M16 13h.01M8 17h8"/>
        </svg>
        @break
    @case('mouse')
        <svg {{ $attributes->merge(['class' => $cls]) }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-3 0-5 2.5-5 6v4a5 5 0 1010 0V9c0-3.5-2-6-5-6z"/>
            <path stroke-linecap="round" d="M12 9v3"/>
        </svg>
        @break
    @case('cpu')
        <svg {{ $attributes->merge(['class' => $cls]) }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M15.75 3v1.5M8.25 19.5v1.5M15.75 19.5v1.5M3 8.25h1.5M3 15.75h1.5M19.5 8.25H21M19.5 15.75H21M6.75 6.75h10.5v10.5H6.75V6.75z"/>
        </svg>
        @break
    @case('printer')
        <svg {{ $attributes->merge(['class' => $cls]) }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18V9a2 2 0 012-2h8a2 2 0 012 2v9M6 18H4a2 2 0 01-2-2v-3a2 2 0 012-2h16a2 2 0 012 2v3a2 2 0 01-2 2h-2M6 18h12"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
        </svg>
        @break
    @case('camera')
        <svg {{ $attributes->merge(['class' => $cls]) }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        @break
    @case('monitor')
        <svg {{ $attributes->merge(['class' => $cls]) }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5v10.5H3.75V5.25z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 18.75h6M12 15.75v3"/>
        </svg>
        @break
    @default
        <span class="h-5 w-5 shrink-0 rounded bg-orange-500/20" aria-hidden="true"></span>
@endswitch
