@php
    $locale = session('admin_locale', 'en');
@endphp

<div class="ms-2 inline-flex items-center gap-1 rounded-md border border-gray-200 bg-white px-1 py-1 text-xs dark:border-gray-700 dark:bg-gray-900">
    <a
        href="{{ route('admin.set-locale', ['locale' => 'en']) }}"
        class="rounded px-2 py-1 {{ $locale === 'en' ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900' : 'text-gray-600 dark:text-gray-300' }}"
    >
        EN
    </a>
    <a
        href="{{ route('admin.set-locale', ['locale' => 'ar']) }}"
        class="rounded px-2 py-1 {{ $locale === 'ar' ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900' : 'text-gray-600 dark:text-gray-300' }}"
    >
        AR
    </a>
</div>
