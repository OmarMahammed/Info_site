@extends('layouts.app')

@section('title', __('Home') . ' — ' . config('app.name'))

@push('styles')
    <link rel="preload" as="image" href="{{ asset('images/hero/hero-1.jpeg') }}">
@endpush

@section('content')
@php
    $whatsappNumber = config('services.whatsapp.number');
    $whatsappGreeting = rawurlencode('مرحبا، اريد الاستفسار عن خدماتكم');
    $heroSlides = [
        ['image' => 'images/hero/hero-1.jpg'],
        ['image' => 'images/hero/hero-2.jpg'],
    ];
    $whyUs = [
        [
            'title' => 'سرعة في التنفيذ',
            'desc' => 'نبدأ بسرعة ونجهز احتياجك بخطة واضحة وتسليم منظم يناسب وقت عملك.',
            'icon' => 'bolt',
        ],
        [
            'title' => 'جودة عالية',
            'desc' => 'نعتمد على خيارات تقنية مجربة تمنحك أداء ثابت واعتمادية على المدى الطويل.',
            'icon' => 'shield',
        ],
        [
            'title' => 'دعم فني مستمر',
            'desc' => 'فريقنا يتابع معك بعد التوريد لضمان تشغيل سلس ومعالجة أي ملاحظات بسرعة.',
            'icon' => 'headset',
        ],
        [
            'title' => 'حلول مخصصة لأعمالك',
            'desc' => 'نقترح تجهيزات وخدمات تناسب حجم نشاطك وطبيعة التشغيل داخل السوق السعودي.',
            'icon' => 'sliders',
        ],
    ];

    $services = [
        [
            'title' => 'تجهيز أجهزة مكتبية',
            'desc' => 'توريد وتجهيز محطات عمل مكتبية متوازنة للأداء اليومي والإنتاجية.',
            'icon' => 'monitor',
        ],
        [
            'title' => 'حلول شبكات',
            'desc' => 'تصميم وربط الشبكات الداخلية بطريقة مستقرة تدعم توسع أعمالك.',
            'icon' => 'network',
        ],
        [
            'title' => 'توريد معدات تقنية',
            'desc' => 'نوفر أجهزة ومستلزمات تقنية مختارة بعناية من موردين موثوقين.',
            'icon' => 'boxes',
        ],
        [
            'title' => 'صيانة ودعم فني',
            'desc' => 'صيانة استباقية ودعم تشغيلي يساعدك على تقليل التوقف ورفع الجاهزية.',
            'icon' => 'wrench',
        ],
    ];
@endphp

{{-- Hero: lightweight slider with fade transitions and centered conversion content --}}
<section
    id="home"
    x-data="heroSlider({{ count($heroSlides) }})"
    x-on:mouseenter="stopAutoplay()"
    x-on:mouseleave="startAutoplay()"
    class="relative isolate h-[70vh] overflow-hidden md:h-[90vh]"
>
    @foreach ($heroSlides as $index => $slide)
        <div
            x-bind:class="active === {{ $index }} ? 'opacity-100' : 'opacity-0'"
            class="absolute inset-0 z-0 transition-opacity duration-1000 ease-out"
            style="will-change: opacity;"
            x-bind:aria-hidden="active === {{ $index }} ? 'false' : 'true'"
        >
            <img
                src="{{ asset($slide['image']) }}"
                alt=""
                width="1920"
                height="1080"
                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                decoding="async"
                @if ($index === 0) fetchpriority="high" @endif
                class="absolute inset-0 h-full w-full object-cover object-center"
            >
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/55 to-black/40"></div>
        </div>
    @endforeach

    <div class="container-custom relative z-10 flex h-full items-center justify-center py-12 pt-24 md:py-20 md:pt-32">
        <div class="mx-auto max-w-4xl text-center text-white">
            @foreach ($heroSlides as $index => $slide)
                <div
                    x-show="active === {{ $index }}"
                    x-cloak
                    x-transition:enter="transition duration-700 ease-out"
                    x-transition:enter-start="translate-y-5 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition duration-500 ease-out"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="-translate-y-2 opacity-0"
                    class="mx-auto"
                    style="will-change: transform, opacity;"
                >
                    <div class="mb-5 flex flex-wrap items-center justify-center gap-2">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-medium text-white/90 shadow-sm backdrop-blur-none" title="المملكة العربية السعودية">
                            <span class="text-base leading-none" aria-hidden="true">🇸🇦</span>
                            <span>خدمة داخل المملكة</span>
                        </span>
                    </div>
                    <h1 class="text-balance text-4xl font-black leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl lg:text-7xl">
                        حلول تقنية متقدمة لأعمالك
                    </h1>
                    <p class="mx-auto mt-5 max-w-3xl text-pretty text-lg leading-relaxed text-white/85 md:text-xl">
                        نوفر أحدث الأجهزة والتقنيات لدعم نمو أعمالك في المملكة
                    </p>
                    <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row sm:gap-4">
                        <a href="#contact" class="btn-base btn-primary min-h-[52px] w-full sm:min-w-[11rem] sm:w-auto px-8">
                            اطلب عرض سعر
                        </a>
                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappGreeting }}" target="_blank" rel="noopener noreferrer" onclick="trackEvent('whatsapp_click', { location: 'hero' })" class="btn-base min-h-[52px] w-full sm:min-w-[11rem] sm:w-auto border border-white/20 bg-white/10 px-8 text-white transition-transform duration-300 hover:-translate-y-0.5 hover:bg-white/15">
                            تواصل معنا
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="mt-8 flex items-center justify-center gap-2">
                @foreach ($heroSlides as $index => $slide)
                    <button
                        type="button"
                        x-on:click="goToSlide({{ $index }})"
                        x-bind:class="active === {{ $index }} ? 'w-8 bg-white' : 'w-3 bg-white/45'"
                        class="h-3 rounded-full transition-all duration-300"
                        aria-label="الانتقال إلى الشريحة {{ $index + 1 }}"
                    ></button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 h-32 w-full pointer-events-none bg-gradient-to-b from-transparent to-white dark:bg-gradient-to-b dark:from-transparent dark:to-[#020617]"></div>
</section>

{{-- About: full-screen cinematic story with dedicated light/dark treatment --}}
@php
    $aboutImage = file_exists(public_path('images/about/about.jpg'))
        ? asset('images/about/about.jpg')
        : asset('images/hero/hero-2.jpeg');
@endphp
<section
    id="about"
    x-data="cinematicAbout()"
    class="relative z-20 mt-[-80px] flex h-[85vh] items-center justify-center overflow-hidden md:mt-[-120px]"
>
    <img
        src="{{ $aboutImage }}"
        alt="حلول تقنية متكاملة للأعمال"
        width="1800"
        height="1200"
        loading="lazy"
        decoding="async"
        x-bind:style="backgroundStyle"
        class="absolute inset-0 h-full w-full object-cover transform-gpu transition-transform duration-700 ease-out"
    >

    <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/60 to-white/80 dark:from-black/80 dark:via-black/70 dark:to-black/90"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(249,115,22,0.12),_transparent_34%),radial-gradient(circle_at_bottom,_rgba(15,23,42,0.08),_transparent_30%)] dark:bg-[radial-gradient(circle_at_top,_rgba(249,115,22,0.14),_transparent_34%),radial-gradient(circle_at_bottom,_rgba(59,130,246,0.12),_transparent_30%)]"></div>

    <div class="relative z-20 mx-auto w-full max-w-6xl px-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-10 shadow-[0_20px_80px_rgba(0,0,0,0.4)] backdrop-blur-xl dark:border-white/10 dark:bg-white/5 md:p-14">
            <div class="mx-auto max-w-3xl pt-6 text-center md:pt-10">
                <div data-animate class="hidden-anim transform-gpu">
                    <span class="inline-flex items-center rounded-full border border-gray-300 bg-black/5 px-3 py-1 text-xs font-semibold tracking-[0.14em] text-gray-800 backdrop-blur dark:border-white/20 dark:bg-white/10 dark:text-white">
                        شريك تقني موثوق
                    </span>
                    <h2 class="mt-6 text-4xl font-bold text-gray-900 md:text-5xl dark:text-white">
                        من نحن
                    </h2>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                        نحن شريكك التقني لتطوير أعمالك في المملكة
                    </p>
                    <p class="mt-6 leading-relaxed text-gray-700 dark:text-gray-400">
                        نقدم حلول تقنية متكاملة تشمل الأجهزة، الشبكات، وأنظمة المراقبة، مع التركيز على الجودة وسرعة التنفيذ.
                    </p>

                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <span class="rounded-full border border-gray-300 bg-black/5 px-4 py-2 text-sm text-gray-800 backdrop-blur dark:border-white/20 dark:bg-white/10 dark:text-white">
                            ✔ جودة عالية
                        </span>
                        <span class="rounded-full border border-gray-300 bg-black/5 px-4 py-2 text-sm text-gray-800 backdrop-blur dark:border-white/20 dark:bg-white/10 dark:text-white">
                            ✔ دعم سريع
                        </span>
                        <span class="rounded-full border border-gray-300 bg-black/5 px-4 py-2 text-sm text-gray-800 backdrop-blur dark:border-white/20 dark:bg-white/10 dark:text-white">
                            ✔ خبرة في السوق السعودي
                        </span>
                    </div>

                    <div class="mt-8 flex justify-center">
                        <a
                            href="#contact"
                            class="inline-flex min-h-[52px] min-w-[11rem] items-center justify-center rounded-xl bg-black px-8 text-sm font-semibold text-white transition duration-300 hover:bg-gray-800 dark:bg-orange-500 dark:hover:bg-orange-600"
                        >
                            تواصل معنا
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Services: business solutions with hover states and clear spacing --}}
<section id="services" class="section-shell section-divider bg-gray-50 dark:bg-gray-950">
    <div class="container-custom">
        <div data-animate class="hidden-anim transform-gpu mx-auto mb-14 max-w-2xl text-center md:mb-18">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white md:text-4xl">
                خدماتنا
            </h2>
            <p class="text-muted mt-4 text-base leading-relaxed md:text-lg">
                نقدم خدمات تقنية عملية تساعدك تبدأ بشكل صحيح وتحافظ على استمرارية العمل بثقة.
            </p>
        </div>
        <div data-stagger-root class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($services as $index => $service)
                <article data-stagger-index="{{ $index }}" class="stagger-card hidden-anim transform-gpu info-card info-card-hover">
                    <div class="info-icon-wrap">
                        <x-ui.feature-icon :name="$service['icon']" class="h-6 w-6" />
                    </div>
                    <h3 class="mt-5 text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $service['title'] }}
                    </h3>
                    <p class="text-muted mt-3 text-sm leading-7">
                        {{ $service['desc'] }}
                    </p>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Products: commercial cards with inquiry CTA and availability state --}}
<section id="products" class="section-shell bg-white dark:bg-gray-900">
    <div class="container-custom">
        <div data-animate class="hidden-anim transform-gpu mx-auto mb-14 max-w-2xl text-center md:mb-18">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white md:text-4xl">
                منتجاتنا
            </h2>
            <p class="text-muted mt-4 text-base leading-relaxed md:text-lg">
                استعرض حلولنا التقنية بأسلوب بصري حديث يبرز كل منتج بشكل أوضح ويمنحك تجربة أكثر تركيزًا واحترافية.
            </p>
        </div>
        @if ($products->isNotEmpty())
            <div
                x-data="productCinemaSlider({{ $products->count() }})"
                class="relative mx-auto h-[80vh] min-h-[34rem] max-h-[52rem] w-full max-w-[1380px] overflow-hidden rounded-[2rem] border border-gray-200/70 bg-[#070b12] shadow-[0_35px_100px_-45px_rgba(15,23,42,0.7)] dark:border-gray-800/70"
            >
                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(249,115,22,0.2),_transparent_35%),radial-gradient(circle_at_bottom,_rgba(59,130,246,0.15),_transparent_30%)]"></div>
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-white/5 via-transparent to-black/30"></div>

                @foreach ($products as $index => $product)
                    @php
                        $productImage = $product->image ? asset('images/products/' . basename($product->image)) : asset('images/placeholder.png');
                        $productInquiryMessage = rawurlencode('السلام عليكم، حاب أستفسر عن منتج ' . $product->name);
                    @endphp

                    <article
                        x-bind:style="getSlideStyle({{ $index }})"
                        x-bind:aria-hidden="active === {{ $index }} ? 'false' : 'true'"
                        class="absolute inset-0 p-3 transition-[transform,opacity,filter] duration-500 ease-in-out md:p-5"
                    >
                        <div class="grid h-full w-full grid-cols-1 overflow-hidden rounded-[1.75rem] border border-white/10 bg-slate-950/65 shadow-[inset_0_1px_0_rgba(255,255,255,0.06)] backdrop-blur-sm lg:grid-cols-[0.88fr_1.12fr]">
                            <div
                                x-bind:style="getMediaStyle({{ $index }})"
                                class="order-1 relative h-[42vh] min-h-[18rem] overflow-hidden transition-[transform,opacity] duration-500 ease-in-out lg:order-2 lg:h-full"
                            >
                                <img
                                    src="{{ $productImage }}"
                                    alt="{{ $product->name }}"
                                    width="960"
                                    height="1080"
                                    loading="lazy"
                                    decoding="async"
                                    class="h-full w-full object-cover object-center"
                                >
                                <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/10 to-black/50 lg:bg-gradient-to-r lg:from-transparent lg:via-black/10 lg:to-black/55"></div>
                            </div>

                            <div class="order-2 flex h-full items-center lg:order-1">
                                <div
                                    x-bind:style="getTextStyle({{ $index }})"
                                    class="w-full px-6 py-8 text-right text-white transition-[transform,opacity] duration-500 ease-in-out sm:px-8 md:px-10 lg:px-12"
                                >
                                    <span class="inline-flex items-center rounded-full border border-white/15 bg-white/6 px-3 py-1 text-xs font-medium tracking-[0.14em] text-orange-200">
                                        منتج تقني مميز
                                    </span>
                                    <h3 class="mt-5 max-w-xl text-3xl font-black leading-tight text-white md:text-4xl lg:text-5xl">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="mt-5 max-w-xl text-sm leading-8 text-gray-300 md:text-base">
                                        {{ $product->description ?: 'حل تقني مختار بعناية ليمنح أعمالك أداءً أفضل وتجربة تشغيل أكثر استقرارًا واحترافية.' }}
                                    </p>

                                    <div class="mt-8 flex flex-col items-stretch gap-4 sm:flex-row sm:items-center sm:justify-end">
                                        <a
                                            href="https://wa.me/{{ $whatsappNumber }}?text={{ $productInquiryMessage }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            onclick="trackEvent('product_inquiry', { name: @js($product->name), location: 'cinema_slider' })"
                                            class="btn-base btn-primary min-h-[52px] min-w-[11rem] justify-center px-8"
                                        >
                                            استفسر الآن
                                        </a>
                                        <span class="text-xs font-medium tracking-[0.12em] text-gray-400">
                                            متوفر للطلبات والتجهيز المؤسسي
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach

                @if ($products->count() > 1)
                    <div class="absolute inset-x-0 top-1/2 z-40 flex -translate-y-1/2 items-center justify-between px-3 sm:px-5">
                        <button
                            type="button"
                            x-on:click="prev()"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 bg-black/35 text-white backdrop-blur-sm transition duration-300 hover:bg-white hover:text-black"
                            aria-label="السابق"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 6l-6 6 6 6" />
                            </svg>
                        </button>

                        <button
                            type="button"
                            x-on:click="next()"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 bg-black/35 text-white backdrop-blur-sm transition duration-300 hover:bg-white hover:text-black"
                            aria-label="التالي"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 6l6 6-6 6" />
                            </svg>
                        </button>
                    </div>

                    <div class="absolute inset-x-0 bottom-5 z-40 flex items-center justify-center gap-2">
                        @foreach ($products as $index => $product)
                            <button
                                type="button"
                                x-on:click="goToSlide({{ $index }})"
                                x-bind:class="active === {{ $index }} ? 'w-10 bg-white' : 'w-3 bg-white/35'"
                                class="h-3 rounded-full transition-all duration-300"
                                aria-label="الانتقال إلى المنتج {{ $index + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800/40 dark:text-gray-400">
                لا توجد منتجات مفعلة حاليًا. أضف منتجات من قاعدة البيانات لعرضها هنا.
            </div>
        @endif
    </div>
</section>

{{-- Contact CTA: real lead capture with WhatsApp and form --}}
<section id="contact" x-data="contactForm()" class="section-shell bg-[#0f1720] text-white">
    <div class="container-custom">
        <div
            x-cloak
            x-show="toastVisible"
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="translate-y-2 scale-95 opacity-0"
            x-transition:enter-end="translate-y-0 scale-100 opacity-100"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="translate-y-0 scale-100 opacity-100"
            x-transition:leave-end="translate-y-2 scale-95 opacity-0"
            class="fixed right-5 top-5 z-[80] rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-2xl shadow-emerald-950/30"
        >
            <span x-text="toastMessage"></span>
        </div>

        <div data-animate class="hidden-anim transform-gpu cta-panel mx-auto max-w-5xl text-center">
            <span class="inline-flex items-center rounded-full border border-white/15 bg-white/8 px-3 py-1 text-xs font-semibold tracking-[0.12em] text-orange-200">
                تواصل مباشر
            </span>
            <h2 class="mt-6 text-3xl font-black tracking-tight text-white md:text-5xl">
                جاهز تطور أعمالك؟
            </h2>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-gray-300 md:text-lg">
                تواصل معنا اليوم وخلي فريقنا يساعدك تختار الحل المناسب لاحتياجك التشغيلي والميزانية المناسبة.
            </p>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappGreeting }}" target="_blank" rel="noopener noreferrer" onclick="trackEvent('whatsapp_click', { location: 'contact_section' })" class="btn-base btn-primary min-h-[52px] min-w-[11rem] px-8">
                    تواصل واتساب
                </a>
                <a href="tel:+201014061724" class="btn-base border border-white/15 bg-white/8 text-white min-h-[52px] min-w-[11rem] px-8 transition-transform duration-300 hover:-translate-y-0.5 hover:bg-white/12">
                    اتصل الآن
                </a>
            </div>

            <p class="mt-6 text-sm text-gray-400">
                أو اترك بياناتك وسنقوم بالتواصل معك مباشرة.
            </p>

            @if (session('success'))
                <div class="mx-auto mt-6 max-w-2xl rounded-2xl border border-emerald-400/25 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mx-auto mt-10 max-w-2xl text-center">
                <form
                    id="contactForm"
                    x-ref="form"
                    x-on:submit.prevent="submit"
                    action="{{ route('contact.store') }}"
                    method="POST"
                    class="space-y-4 rounded-3xl border border-white/10 bg-white/6 p-6 text-center shadow-[0_18px_50px_-32px_rgba(0,0,0,0.55)] backdrop-saturate-150 sm:p-8"
                >
                    @csrf

                    <div x-show="errorMessage" x-transition.opacity class="rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm font-medium text-red-200">
                        <span x-text="errorMessage"></span>
                    </div>

                    <div class="space-y-2 text-start">
                        <label for="name" class="block text-sm font-medium text-gray-200">الاسم</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            class="w-full rounded-lg border border-gray-700 bg-gray-800 px-4 py-3 text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none"
                            placeholder="اكتب اسمك الكامل"
                            required
                        >
                        <p x-show="errors.name" class="text-xs text-red-300" x-text="errors.name?.[0]"></p>
                        @error('name')
                            <p class="text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2 text-start">
                        <label for="phone" class="block text-sm font-medium text-gray-200">رقم الجوال</label>
                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            value="{{ old('phone') }}"
                            class="w-full rounded-lg border border-gray-700 bg-gray-800 px-4 py-3 text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none"
                            placeholder="05XXXXXXXX"
                            required
                        >
                        <p x-show="errors.phone" class="text-xs text-red-300" x-text="errors.phone?.[0]"></p>
                        @error('phone')
                            <p class="text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2 text-start">
                        <label for="message" class="block text-sm font-medium text-gray-200">رسالتك</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            class="w-full rounded-lg border border-gray-700 bg-gray-800 px-4 py-3 text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none"
                            placeholder="اكتب تفاصيل احتياجك أو الخدمة التي ترغب بالاستفسار عنها"
                            required
                        >{{ old('message') }}</textarea>
                        <p x-show="errors.message" class="text-xs text-red-300" x-text="errors.message?.[0]"></p>
                        @error('message')
                            <p class="text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        x-bind:disabled="loading"
                        class="btn-base btn-primary min-h-[54px] w-full justify-center disabled:cursor-not-allowed disabled:opacity-70"
                    >
                        <svg x-show="loading" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span x-text="loading ? 'جاري الإرسال...' : 'إرسال الطلب'"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
