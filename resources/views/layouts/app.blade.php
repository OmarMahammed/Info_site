<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ app()->getLocale() === 'fa' || app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">

<head>
    @php
        $gaMeasurementId = config('services.analytics.ga_measurement_id', 'G-XXXXXXXX');
        $hotjarSiteId = config('services.analytics.hotjar_site_id');
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Google Analytics -->
    @if(config('services.analytics.ga_measurement_id'))
        <script async
            src="https://www.googletagmanager.com/gtag/js?id={{ config('services.analytics.ga_measurement_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }

            gtag('js', new Date());
            gtag('config', '{{ config('services.analytics.ga_measurement_id') }}');
        </script>
    @endif

    <!-- Hotjar Tracking Code placeholder -->
    @if ($hotjarSiteId)
        <meta name="hotjar-site-id" content="{{ $hotjarSiteId }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="min-h-screen bg-white text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">

    @include('components.ui.navbar')

    <main>
        @yield('content')
    </main>

    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ rawurlencode('مرحبا، اريد الاستفسار عن خدماتكم') }}"
        target="_blank" rel="noopener noreferrer"
        onclick="trackEvent('whatsapp_click', { location: 'floating_button' })" aria-label="تواصل عبر واتساب"
        class="fixed bottom-6 right-6 z-[70] inline-flex h-14 w-14 items-center justify-center rounded-full bg-green-500 text-white shadow-lg shadow-green-900/25 transition duration-300 hover:scale-110 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-950">
        <span class="text-2xl leading-none" aria-hidden="true">💬</span>
    </a>

    @include('components.ui.footer')

    @stack('scripts')

    <script>
        function toggleDark() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        (function () {
            const saved = localStorage.getItem('theme');
            if (saved === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</body>

</html>