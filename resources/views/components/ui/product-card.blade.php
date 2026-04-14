@props([
    'product',
    'index' => 0,
])

@php
    $productInquiryMessage = rawurlencode('السلام عليكم، حاب أستفسر عن منتج ' . $product->name);
    $whatsappNumber = config('services.whatsapp.number');
@endphp

<article
    data-stagger-index="{{ $index }}"
    class="stagger-card group hidden-anim transform-gpu flex h-full flex-col overflow-hidden rounded-xl border border-gray-200/70 bg-white shadow-[0_16px_40px_-30px_rgba(15,23,42,0.45)] transition-[transform,box-shadow] duration-300 ease-out hover:-translate-y-[5px] hover:shadow-xl hover:shadow-orange-500/10 dark:border-gray-700/70 dark:bg-gray-800 dark:text-white">
    <div class="relative h-64 w-full shrink-0 overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700">
        <img
            src="{{ $product->image_url }}"
            alt="{{ $product->name }}"
            width="640"
            height="420"
            loading="lazy"
            decoding="async"
            class="block h-full w-full object-cover transition duration-300 ease-out group-hover:scale-105 group-hover:brightness-50"
        >

        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent transition-opacity duration-300 ease-out group-hover:opacity-90"></div>

        <div class="absolute bottom-0 z-10 w-full p-4">
            <div class="flex items-end justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <h3 class="truncate text-lg font-semibold text-white" style="text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                        {{ $product->name }}
                    </h3>
                    @if ($product->description)
                        <p class="mt-1 line-clamp-2 text-sm text-gray-300">
                            {{ $product->description }}
                        </p>
                    @endif
                </div>

                <a
                    href="https://wa.me/{{ $whatsappNumber }}?text={{ $productInquiryMessage }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    onclick="trackEvent('product_inquiry', { name: @js($product->name) })"
                    class="inline-flex shrink-0 items-center justify-center rounded-lg border border-white/20 bg-white/10 px-3 py-2 text-sm font-medium text-white backdrop-blur transition-[background-color,color] duration-300 ease-out hover:bg-white hover:text-black"
                >
                    استفسر الآن
                </a>
            </div>
        </div>
    </div>
</article>
