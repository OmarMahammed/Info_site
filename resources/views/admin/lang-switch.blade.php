@php
    $locale = app()->getLocale() === 'ar' ? 'ar' : 'en';
@endphp

<div class="admin-lang-switch" role="group" aria-label="Admin language switcher">
    <a href="{{ route('admin.set-locale', 'en') }}"
        class="admin-lang-switch__item {{ $locale === 'en' ? 'is-active' : '' }}"
        aria-current="{{ $locale === 'en' ? 'true' : 'false' }}">
        EN
    </a>

    <a href="{{ route('admin.set-locale', 'ar') }}"
        class="admin-lang-switch__item {{ $locale === 'ar' ? 'is-active' : '' }}"
        aria-current="{{ $locale === 'ar' ? 'true' : 'false' }}">
        AR
    </a>
</div>
