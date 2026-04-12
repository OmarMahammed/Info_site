<header x-data="premiumNavbar()"
        x-init="init()"
        @keydown.escape.window="closeMobileMenu()"
        @scroll.window.throttle.50ms="updateScrolledState()"
        class="sticky top-0 z-50 border-b transition-all duration-300 ease-in-out"
        :class="isScrolled
            ? 'border-gray-200/50 bg-white/95 shadow-lg dark:border-gray-700/50 dark:bg-gray-950/95'
            : 'border-transparent bg-transparent shadow-none'">
    <nav class="container-custom flex items-center gap-10 transition-all duration-300 ease-in-out"
         :class="isScrolled ? 'h-16' : 'h-20'">
        <a href="{{ url('/') }}" class="inline-flex shrink-0 items-center" aria-label="{{ config('app.name', 'Laravel') }}">
            <div class="px-2 py-1 rounded-lg bg-white/90 dark:bg-white/10 transition-all duration-300 dark:shadow-[0_0_15px_rgba(255,115,0,0.25)]">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="h-10 w-auto object-contain">
            </div>
        </a>

        <ul class="hidden flex-1 items-center justify-end gap-10 md:flex">
            <li>
                <a href="{{ url('/') }}"
                   @click="setActiveLink('home')"
                   class="nav-link inline-block text-sm font-medium text-gray-600 transition-all duration-300 hover:text-orange-500 dark:text-gray-400"
                   :class="activeLink === 'home' ? 'nav-link-active text-orange-500' : ''">
                    {{ __('Home') }}
                </a>
            </li>
            <li>
                <a href="#about"
                   @click="setActiveLink('about')"
                   class="nav-link inline-block text-sm font-medium text-gray-600 transition-all duration-300 hover:text-orange-500 dark:text-gray-400"
                   :class="activeLink === 'about' ? 'nav-link-active text-orange-500' : ''">
                    {{ __('About') }}
                </a>
            </li>
            <li>
                <a href="#services"
                   @click="setActiveLink('services')"
                   class="nav-link inline-block text-sm font-medium text-gray-600 transition-all duration-300 hover:text-orange-500 dark:text-gray-400"
                   :class="activeLink === 'services' ? 'nav-link-active text-orange-500' : ''">
                    {{ __('Services') }}
                </a>
            </li>
            <li>
                <a href="#contact"
                   @click="setActiveLink('contact')"
                   class="nav-link inline-block text-sm font-medium text-gray-600 transition-all duration-300 hover:text-orange-500 dark:text-gray-400"
                   :class="activeLink === 'contact' ? 'nav-link-active text-orange-500' : ''">
                    {{ __('Contact') }}
                </a>
            </li>
        </ul>

        <div class="ms-auto flex items-center gap-2">
            <button onclick="toggleDark()"
                    type="button"
                    class="relative w-11 h-11 flex items-center justify-center rounded-full bg-white/90 dark:bg-gray-800/90 border border-gray-200 dark:border-gray-700 transition-all duration-500 ease-in-out hover:scale-110 hover:shadow-[0_0_12px_rgba(255,115,0,0.25)]"
                    aria-label="Toggle dark mode">
                <svg class="absolute w-5 h-5 text-yellow-500 transition-all duration-500 opacity-100 scale-100 rotate-0 dark:opacity-0 dark:scale-0 dark:-rotate-90"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414M16.95 16.95l1.414 1.414M7.05 7.05 5.636 5.636"/>
                </svg>
                <svg class="absolute w-5 h-5 text-indigo-400 transition-all duration-500 opacity-0 scale-0 rotate-90 dark:opacity-100 dark:scale-100 dark:rotate-0"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>

            <button @click="toggleMobileMenu()"
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-200 p-2 text-gray-600 transition-all duration-300 ease-in-out hover:scale-105 dark:border-gray-700 dark:text-gray-300 md:hidden"
                    aria-label="Toggle navigation">
                <svg x-show="!isMobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="isMobileMenuOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </nav>

    <div x-show="isMobileMenuOpen"
         x-cloak
         @click="closeMobileMenu()"
         x-transition:enter="transition-all duration-300 ease-in-out"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-all duration-300 ease-in-out"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black/40 md:hidden"></div>

    <div x-show="isMobileMenuOpen"
         x-cloak
         @click.stop
         x-transition:enter="transition-all duration-300 ease-in-out"
         x-transition:enter-start="opacity-0 -translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition-all duration-300 ease-in-out"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-3"
         class="absolute inset-x-0 top-full z-50 px-4 pb-4 md:hidden">
        <div class="rounded-xl border border-gray-100 bg-white shadow-xl dark:border-gray-800 dark:bg-gray-900">
            <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                <li>
                    <a href="{{ url('/') }}"
                       @click="setActiveLink('home'); closeMobileMenu()"
                       class="block px-4 py-3 text-sm font-medium text-gray-600 transition-all duration-300 hover:bg-gray-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-gray-800/80"
                       :class="activeLink === 'home' ? 'bg-gray-50 text-orange-500 dark:bg-gray-800/60' : ''">
                        {{ __('Home') }}
                    </a>
                </li>
                <li>
                    <a href="#about"
                       @click="setActiveLink('about'); closeMobileMenu()"
                       class="block px-4 py-3 text-sm font-medium text-gray-600 transition-all duration-300 hover:bg-gray-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-gray-800/80"
                       :class="activeLink === 'about' ? 'bg-gray-50 text-orange-500 dark:bg-gray-800/60' : ''">
                        {{ __('About') }}
                    </a>
                </li>
                <li>
                    <a href="#services"
                       @click="setActiveLink('services'); closeMobileMenu()"
                       class="block px-4 py-3 text-sm font-medium text-gray-600 transition-all duration-300 hover:bg-gray-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-gray-800/80"
                       :class="activeLink === 'services' ? 'bg-gray-50 text-orange-500 dark:bg-gray-800/60' : ''">
                        {{ __('Services') }}
                    </a>
                </li>
                <li>
                    <a href="#contact"
                       @click="setActiveLink('contact'); closeMobileMenu()"
                       class="block px-4 py-3 text-sm font-medium text-gray-600 transition-all duration-300 hover:bg-gray-50 hover:text-orange-500 dark:text-gray-300 dark:hover:bg-gray-800/80"
                       :class="activeLink === 'contact' ? 'bg-gray-50 text-orange-500 dark:bg-gray-800/60' : ''">
                        {{ __('Contact') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
