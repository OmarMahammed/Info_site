<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomepageContent extends Model
{
    protected const DEFAULT_LOCALE = 'ar';

    protected const SUPPORTED_LOCALES = ['ar', 'en'];

    protected const SERVICE_ICONS = [
        'monitor',
        'network',
        'boxes',
        'wrench',
        'shield',
        'bolt',
        'sliders',
        'headset',
    ];

    protected $fillable = [
        'about',
        'services',
        'trust',
    ];

    protected function casts(): array
    {
        return [
            'about' => 'array',
            'services' => 'array',
            'trust' => 'array',
        ];
    }

    public static function current(): self
    {
        return static::query()->first() ?? new static();
    }

    public static function resolvedContent(): array
    {
        $record = static::current();

        return [
            'about' => $record->getAbout(),
            'services' => $record->getServices(),
            'trust' => $record->getTrust(),
        ];
    }

    public static function defaults(): array
    {
        return [
            'about' => [
                'is_enabled' => true,
                'badge' => ['ar' => 'شريك تقني موثوق', 'en' => 'Trusted technology partner'],
                'title' => ['ar' => 'من نحن', 'en' => 'About us'],
                'subtitle' => ['ar' => 'نحن شريكك التقني لتطوير أعمالك في المملكة', 'en' => 'We are your technology partner for business growth in Saudi Arabia'],
                'description' => ['ar' => 'نقدم حلول تقنية متكاملة تشمل الأجهزة، الشبكات، وأنظمة المراقبة، مع التركيز على الجودة وسرعة التنفيذ.', 'en' => 'We provide integrated technology solutions covering devices, networks, and surveillance systems, with a strong focus on quality and fast execution.'],
                'features' => [
                    ['label' => ['ar' => 'جودة عالية', 'en' => 'High quality']],
                    ['label' => ['ar' => 'دعم سريع', 'en' => 'Fast support']],
                    ['label' => ['ar' => 'خبرة في السوق السعودي', 'en' => 'Experience in the Saudi market']],
                ],
                'cta_label' => ['ar' => 'تواصل معنا', 'en' => 'Contact us'],
                'image_path' => null,
                'image_alt' => ['ar' => 'حلول تقنية متكاملة للأعمال', 'en' => 'Integrated technology solutions for businesses'],
            ],
            'services' => [
                'is_enabled' => true,
                'badge' => ['ar' => 'حلول تشغيلية مدروسة', 'en' => 'Well-planned operational solutions'],
                'title' => ['ar' => 'خدماتنا', 'en' => 'Our services'],
                'description' => ['ar' => 'صممنا هذا القسم ليعكس طريقة عملنا: تركيز واضح، حلول مرتبة، وخدمة تتكيف مع احتياجك بدل ما تفرض عليك باقة جاهزة.', 'en' => 'We designed this section to reflect how we work: clear focus, organized solutions, and a service approach that adapts to your needs instead of forcing a fixed package.'],
                'meta' => [
                    ['label' => ['ar' => 'تشغيل أكثر استقرارًا', 'en' => 'More stable operations']],
                    ['label' => ['ar' => 'تنفيذ مرن حسب الاحتياج', 'en' => 'Flexible execution based on your needs']],
                    ['label' => ['ar' => 'تجهيز مؤسسي داخل المملكة', 'en' => 'Business setup within Saudi Arabia']],
                ],
                'spotlight_label' => ['ar' => 'الخدمة تحت التركيز', 'en' => 'Service in focus'],
                'spotlight_cta_label' => ['ar' => 'ناقش احتياجك مع فريقنا', 'en' => 'Discuss your needs with our team'],
                'detail_label' => ['ar' => 'عرض التفاصيل', 'en' => 'View details'],
                'items' => [
                    [
                        'is_visible' => true,
                        'title' => ['ar' => 'تجهيز أجهزة مكتبية', 'en' => 'Desktop workstation setup'],
                        'desc' => ['ar' => 'توريد وتجهيز محطات عمل مكتبية متوازنة للأداء اليومي والإنتاجية.', 'en' => 'Supply and setup of balanced desktop workstations built for daily performance and productivity.'],
                        'icon' => 'monitor',
                    ],
                    [
                        'is_visible' => true,
                        'title' => ['ar' => 'حلول شبكات', 'en' => 'Network solutions'],
                        'desc' => ['ar' => 'تصميم وربط الشبكات الداخلية بطريقة مستقرة تدعم توسع أعمالك.', 'en' => 'Design and deployment of stable internal networks that support business growth.'],
                        'icon' => 'network',
                    ],
                    [
                        'is_visible' => true,
                        'title' => ['ar' => 'توريد معدات تقنية', 'en' => 'Technology equipment supply'],
                        'desc' => ['ar' => 'نوفر أجهزة ومستلزمات تقنية مختارة بعناية من موردين موثوقين.', 'en' => 'We provide carefully selected devices and technology accessories from trusted suppliers.'],
                        'icon' => 'boxes',
                    ],
                    [
                        'is_visible' => true,
                        'title' => ['ar' => 'صيانة ودعم فني', 'en' => 'Maintenance and technical support'],
                        'desc' => ['ar' => 'صيانة استباقية ودعم تشغيلي يساعدك على تقليل التوقف ورفع الجاهزية.', 'en' => 'Proactive maintenance and operational support that help reduce downtime and improve readiness.'],
                        'icon' => 'wrench',
                    ],
                ],
            ],
            'trust' => [
                'is_enabled' => true,
                'kicker' => ['ar' => 'ثقة قبل القرار', 'en' => 'Confidence before the decision'],
                'title' => ['ar' => 'ليش ناس كثير ترتاح تتواصل معنا من أول مرة؟', 'en' => 'Why do so many clients feel comfortable reaching out to us from the first message?'],
                'description' => ['ar' => 'لأننا نتكلم معك بشكل واضح، نرتب لك الاحتياج بدون تعقيد، ونقترح حلول مجربة تساعدك تختار صح قبل ما تدفع أو تبدأ التنفيذ.', 'en' => 'Because we communicate clearly, organize your needs without unnecessary complexity, and suggest proven solutions that help you choose confidently before you pay or start implementation.'],
                'story_tag' => ['ar' => 'عملاء وثقوا فينا', 'en' => 'Clients who trusted us'],
                'evidence_title' => ['ar' => 'حلولنا مجربة ونتائجها واضحة', 'en' => 'Our solutions are proven and the results are clear'],
                'logos' => [
                    ['label' => ['ar' => 'شركات تشغيل', 'en' => 'Operations companies']],
                    ['label' => ['ar' => 'مكاتب إدارية', 'en' => 'Administrative offices']],
                    ['label' => ['ar' => 'معارض ومبيعات', 'en' => 'Retail and showroom businesses']],
                    ['label' => ['ar' => 'مستودعات', 'en' => 'Warehouses']],
                    ['label' => ['ar' => 'عيادات ومراكز', 'en' => 'Clinics and centers']],
                    ['label' => ['ar' => 'فرق عمل متنامية', 'en' => 'Growing teams']],
                ],
                'testimonials' => [
                    [
                        'is_visible' => true,
                        'quote' => ['ar' => 'التعامل كان مرتب من أول رسالة. فهموا احتياجنا بسرعة ورتبوا لنا الخيارات بشكل واضح بدون تعقيد.', 'en' => 'The experience was organized from the first message. They understood our needs quickly and presented the right options with real clarity and no complexity.'],
                        'author' => ['ar' => 'مدير تشغيل', 'en' => 'Operations Manager'],
                        'company' => ['ar' => 'شركة خدمات لوجستية - الرياض', 'en' => 'Logistics company - Riyadh'],
                    ],
                    [
                        'is_visible' => true,
                        'quote' => ['ar' => 'الشيء اللي فرق معنا إن التواصل كان سريع والاقتراحات كانت عملية فعلًا، مو مجرد كلام تسويقي.', 'en' => 'What really stood out was the speed of communication and how practical the recommendations were. It did not feel like empty marketing talk.'],
                        'author' => ['ar' => 'مسؤول مشتريات', 'en' => 'Procurement Officer'],
                        'company' => ['ar' => 'مؤسسة تجارية - جدة', 'en' => 'Commercial business - Jeddah'],
                    ],
                    [
                        'is_visible' => true,
                        'quote' => ['ar' => 'حسينا إن فيه أحد يفهم بيئة العمل عندنا ويقترح الأنسب للميزانية، وهذا خفف التردد من البداية.', 'en' => 'We felt that someone truly understood our operating environment and recommended what fit our budget, which removed hesitation from the start.'],
                        'author' => ['ar' => 'مدير إداري', 'en' => 'Administrative Manager'],
                        'company' => ['ar' => 'شركة ناشئة - الخبر', 'en' => 'Startup company - Khobar'],
                    ],
                ],
                'guarantees' => [
                    ['label' => ['ar' => 'خلك على اطلاع من أول تواصل', 'en' => 'Stay informed from the first contact']],
                    ['label' => ['ar' => 'حلول مناسبة للميزانية والواقع التشغيلي', 'en' => 'Solutions aligned with your budget and real operations']],
                    ['label' => ['ar' => 'نرتب لك القرار قبل الشراء', 'en' => 'We help you structure the decision before purchase']],
                ],
                'stats' => [
                    [
                        'value' => 4,
                        'suffix' => '',
                        'label' => ['ar' => 'خدمات تشغيلية أساسية', 'en' => 'Core operational services'],
                        'note' => ['ar' => 'نغطي أهم احتياجات التجهيز، الشبكات، التوريد، والدعم تحت مظلة واحدة.', 'en' => 'We cover key setup, networking, supply, and support needs under one roof.'],
                    ],
                    [
                        'value' => 6,
                        'suffix' => '',
                        'label' => ['ar' => 'فئات منتجات جاهزة للتوريد', 'en' => 'Product categories ready for supply'],
                        'note' => ['ar' => 'خيارات واضحة تساعدك تبني احتياجك بسرعة بدون تشتت بين موردين متعددين.', 'en' => 'Clear options that help you build your requirement faster without being scattered across multiple suppliers.'],
                    ],
                    [
                        'value' => 3,
                        'suffix' => '',
                        'label' => ['ar' => 'قنوات تواصل مباشرة', 'en' => 'Direct communication channels'],
                        'note' => ['ar' => 'واتساب، اتصال، أو نموذج سريع حسب الطريقة اللي تناسبك.', 'en' => 'WhatsApp, phone call, or a quick form depending on what suits you best.'],
                    ],
                ],
                'cta_title' => ['ar' => 'إذا ودك تبدأ بخطوة واضحة، خلنا نرتبها معك', 'en' => 'If you want a clear next step, let us structure it with you'],
                'cta_copy' => ['ar' => 'تواصل معنا الآن وخذ تصور سريع يناسب نشاطك. بدون تعقيد، بدون ضغط، وبطريقة تخليك تعرف وش الأنسب قبل أي قرار.', 'en' => 'Reach out now and get a quick direction that fits your business. No pressure, no complexity, just a clearer view before any decision is made.'],
                'cta_urgency' => ['ar' => 'جاهزين نخدمك اليوم وردنا عليك غالبًا خلال دقائق.', 'en' => 'We are ready to help today, and we usually reply within minutes.'],
                'cta_primary_label' => ['ar' => 'خلنا نبدأ معك الآن', 'en' => 'Let us get started with you'],
                'cta_secondary_label' => ['ar' => 'كلمنا على واتساب', 'en' => 'Chat with us on WhatsApp'],
                'cta_microcopy' => ['ar' => 'استشارة مجانية، بدون التزام، وبياناتك في أمان.', 'en' => 'Free consultation, no obligation, and your information is safe.'],
                'safety' => [
                    ['label' => ['ar' => 'استشارة أولية بدون التزام', 'en' => 'Initial consultation with no obligation']],
                    ['label' => ['ar' => 'خصوصية بياناتك محفوظة', 'en' => 'Your data privacy is protected']],
                    ['label' => ['ar' => 'تواصل مباشر مع فريقنا', 'en' => 'Direct contact with our team']],
                ],
                'whatsapp_message' => ['ar' => 'السلام عليكم، حاب أعرف وش الحل الأنسب لاحتياجي', 'en' => 'Hello, I would like to know the best solution for my needs'],
            ],
        ];
    }

    public function getAbout(?string $locale = null): array
    {
        $about = $this->normalizeAbout($this->about);
        $about['image_url'] = static::resolveAboutImageUrl($about['image_path']);

        return [
            'is_enabled' => $about['is_enabled'],
            'badge' => $this->translateValue($about['badge'], $locale),
            'title' => $this->translateValue($about['title'], $locale),
            'subtitle' => $this->translateValue($about['subtitle'], $locale),
            'description' => $this->translateValue($about['description'], $locale),
            'features' => collect($about['features'])->map(fn (array $item) => [
                'label' => $this->translateValue($item['label'], $locale),
            ])->all(),
            'cta_label' => $this->translateValue($about['cta_label'], $locale),
            'image_path' => $about['image_path'],
            'image_alt' => $this->translateValue($about['image_alt'], $locale),
            'image_url' => $about['image_url'],
        ];
    }

    public function getServices(?string $locale = null): array
    {
        $services = $this->normalizeServices($this->services);

        return [
            'is_enabled' => $services['is_enabled'],
            'badge' => $this->translateValue($services['badge'], $locale),
            'title' => $this->translateValue($services['title'], $locale),
            'description' => $this->translateValue($services['description'], $locale),
            'meta' => collect($services['meta'])->map(fn (array $item) => [
                'label' => $this->translateValue($item['label'], $locale),
            ])->all(),
            'spotlight_label' => $this->translateValue($services['spotlight_label'], $locale),
            'spotlight_cta_label' => $this->translateValue($services['spotlight_cta_label'], $locale),
            'detail_label' => $this->translateValue($services['detail_label'], $locale),
            'items' => collect($services['items'])->map(fn (array $item) => [
                'is_visible' => $item['is_visible'],
                'title' => $this->translateValue($item['title'], $locale),
                'desc' => $this->translateValue($item['desc'], $locale),
                'icon' => $item['icon'],
            ])->all(),
        ];
    }

    public function getTrust(?string $locale = null): array
    {
        $trust = $this->normalizeTrust($this->trust);

        return [
            'is_enabled' => $trust['is_enabled'],
            'kicker' => $this->translateValue($trust['kicker'], $locale),
            'title' => $this->translateValue($trust['title'], $locale),
            'description' => $this->translateValue($trust['description'], $locale),
            'story_tag' => $this->translateValue($trust['story_tag'], $locale),
            'evidence_title' => $this->translateValue($trust['evidence_title'], $locale),
            'logos' => collect($trust['logos'])->map(fn (array $item) => [
                'label' => $this->translateValue($item['label'], $locale),
            ])->all(),
            'testimonials' => collect($trust['testimonials'])->map(fn (array $item) => [
                'is_visible' => $item['is_visible'],
                'quote' => $this->translateValue($item['quote'], $locale),
                'author' => $this->translateValue($item['author'], $locale),
                'company' => $this->translateValue($item['company'], $locale),
            ])->all(),
            'guarantees' => collect($trust['guarantees'])->map(fn (array $item) => [
                'label' => $this->translateValue($item['label'], $locale),
            ])->all(),
            'stats' => collect($trust['stats'])->map(fn (array $item) => [
                'value' => $item['value'],
                'suffix' => $item['suffix'],
                'label' => $this->translateValue($item['label'], $locale),
                'note' => $this->translateValue($item['note'], $locale),
            ])->all(),
            'cta_title' => $this->translateValue($trust['cta_title'], $locale),
            'cta_copy' => $this->translateValue($trust['cta_copy'], $locale),
            'cta_urgency' => $this->translateValue($trust['cta_urgency'], $locale),
            'cta_primary_label' => $this->translateValue($trust['cta_primary_label'], $locale),
            'cta_secondary_label' => $this->translateValue($trust['cta_secondary_label'], $locale),
            'cta_microcopy' => $this->translateValue($trust['cta_microcopy'], $locale),
            'safety' => collect($trust['safety'])->map(fn (array $item) => [
                'label' => $this->translateValue($item['label'], $locale),
            ])->all(),
            'whatsapp_message' => $this->translateValue($trust['whatsapp_message'], $locale),
        ];
    }

    public function toFormData(): array
    {
        return [
            'about' => $this->normalizeAbout($this->about),
            'services' => $this->normalizeServices($this->services),
            'trust' => $this->normalizeTrust($this->trust),
        ];
    }

    public function fillContent(array $data): static
    {
        $this->fill([
            'about' => $this->normalizeAbout($data['about'] ?? []),
            'services' => $this->normalizeServices($data['services'] ?? []),
            'trust' => $this->normalizeTrust($data['trust'] ?? []),
        ]);

        return $this;
    }

    protected static function resolveAboutImageUrl(?string $path): string
    {
        if (filled($path) && Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        if (file_exists(public_path('images/about/about.jpg'))) {
            return asset('images/about/about.jpg');
        }

        return asset('images/hero/hero-2.jpeg');
    }

    protected function normalizeAbout(mixed $about): array
    {
        $defaults = static::defaults()['about'];
        $about = is_array($about) ? $about : [];

        return [
            'is_enabled' => $this->normalizeBoolean($about['is_enabled'] ?? null, true),
            'badge' => $this->normalizeTranslatedText($about['badge'] ?? null, $defaults['badge']),
            'title' => $this->normalizeTranslatedText($about['title'] ?? null, $defaults['title']),
            'subtitle' => $this->normalizeTranslatedText($about['subtitle'] ?? null, $defaults['subtitle']),
            'description' => $this->normalizeTranslatedText($about['description'] ?? null, $defaults['description']),
            'features' => $this->normalizeLabeledList($about['features'] ?? null, $defaults['features'], 2, 4),
            'cta_label' => $this->normalizeTranslatedText($about['cta_label'] ?? null, $defaults['cta_label']),
            'image_path' => $this->normalizeOptionalText($about['image_path'] ?? null),
            'image_alt' => $this->normalizeTranslatedText($about['image_alt'] ?? null, $defaults['image_alt']),
        ];
    }

    protected function normalizeServices(mixed $services): array
    {
        $defaults = static::defaults()['services'];
        $services = is_array($services) ? $services : [];

        return [
            'is_enabled' => $this->normalizeBoolean($services['is_enabled'] ?? null, true),
            'badge' => $this->normalizeTranslatedText($services['badge'] ?? null, $defaults['badge']),
            'title' => $this->normalizeTranslatedText($services['title'] ?? null, $defaults['title']),
            'description' => $this->normalizeTranslatedText($services['description'] ?? null, $defaults['description']),
            'meta' => $this->normalizeLabeledList($services['meta'] ?? null, $defaults['meta'], 2, 4),
            'spotlight_label' => $this->normalizeTranslatedText($services['spotlight_label'] ?? null, $defaults['spotlight_label']),
            'spotlight_cta_label' => $this->normalizeTranslatedText($services['spotlight_cta_label'] ?? null, $defaults['spotlight_cta_label']),
            'detail_label' => $this->normalizeTranslatedText($services['detail_label'] ?? null, $defaults['detail_label']),
            'items' => $this->normalizeServiceItems($services['items'] ?? null, $defaults['items']),
        ];
    }

    protected function normalizeTrust(mixed $trust): array
    {
        $defaults = static::defaults()['trust'];
        $trust = is_array($trust) ? $trust : [];

        return [
            'is_enabled' => $this->normalizeBoolean($trust['is_enabled'] ?? null, true),
            'kicker' => $this->normalizeTranslatedText($trust['kicker'] ?? null, $defaults['kicker']),
            'title' => $this->normalizeTranslatedText($trust['title'] ?? null, $defaults['title']),
            'description' => $this->normalizeTranslatedText($trust['description'] ?? null, $defaults['description']),
            'story_tag' => $this->normalizeTranslatedText($trust['story_tag'] ?? null, $defaults['story_tag']),
            'evidence_title' => $this->normalizeTranslatedText($trust['evidence_title'] ?? null, $defaults['evidence_title']),
            'logos' => $this->normalizeLabeledList($trust['logos'] ?? null, $defaults['logos'], 3, 8),
            'testimonials' => $this->normalizeTestimonials($trust['testimonials'] ?? null, $defaults['testimonials']),
            'guarantees' => $this->normalizeLabeledList($trust['guarantees'] ?? null, $defaults['guarantees'], 2, 4),
            'stats' => $this->normalizeStats($trust['stats'] ?? null, $defaults['stats']),
            'cta_title' => $this->normalizeTranslatedText($trust['cta_title'] ?? null, $defaults['cta_title']),
            'cta_copy' => $this->normalizeTranslatedText($trust['cta_copy'] ?? null, $defaults['cta_copy']),
            'cta_urgency' => $this->normalizeTranslatedText($trust['cta_urgency'] ?? null, $defaults['cta_urgency']),
            'cta_primary_label' => $this->normalizeTranslatedText($trust['cta_primary_label'] ?? null, $defaults['cta_primary_label']),
            'cta_secondary_label' => $this->normalizeTranslatedText($trust['cta_secondary_label'] ?? null, $defaults['cta_secondary_label']),
            'cta_microcopy' => $this->normalizeTranslatedText($trust['cta_microcopy'] ?? null, $defaults['cta_microcopy']),
            'safety' => $this->normalizeLabeledList($trust['safety'] ?? null, $defaults['safety'], 2, 4),
            'whatsapp_message' => $this->normalizeTranslatedText($trust['whatsapp_message'] ?? null, $defaults['whatsapp_message']),
        ];
    }

    protected function normalizeServiceItems(mixed $items, array $defaults): array
    {
        if (! is_array($items)) {
            return $defaults;
        }

        $normalized = collect($items)
            ->map(function ($item, int $index) use ($defaults) {
                if (! is_array($item)) {
                    return null;
                }

                $fallback = $defaults[$index] ?? $defaults[0];
                $icon = $this->normalizeText($item['icon'] ?? null, $fallback['icon']);

                return [
                    'is_visible' => $this->normalizeBoolean($item['is_visible'] ?? null, $fallback['is_visible'] ?? true),
                    'title' => $this->normalizeTranslatedText($item['title'] ?? null, $fallback['title']),
                    'desc' => $this->normalizeTranslatedText($item['desc'] ?? null, $fallback['desc']),
                    'icon' => in_array($icon, static::SERVICE_ICONS, true) ? $icon : $fallback['icon'],
                ];
            })
            ->filter(fn (?array $item) => filled($item['title'] ?? null))
            ->take(6)
            ->values()
            ->all();

        $normalized = count($normalized) >= 2 ? $normalized : $defaults;

        if (! collect($normalized)->contains(fn (array $item) => $item['is_visible'])) {
            $normalized[0]['is_visible'] = true;
        }

        return $normalized;
    }

    protected function normalizeTestimonials(mixed $items, array $defaults): array
    {
        if (! is_array($items)) {
            return $defaults;
        }

        $normalized = collect($items)
            ->map(function ($item, int $index) use ($defaults) {
                if (! is_array($item)) {
                    return null;
                }

                $fallback = $defaults[$index] ?? $defaults[0];

                return [
                    'is_visible' => $this->normalizeBoolean($item['is_visible'] ?? null, $fallback['is_visible'] ?? true),
                    'quote' => $this->normalizeTranslatedText($item['quote'] ?? null, $fallback['quote']),
                    'author' => $this->normalizeTranslatedText($item['author'] ?? null, $fallback['author']),
                    'company' => $this->normalizeTranslatedText($item['company'] ?? null, $fallback['company']),
                ];
            })
            ->filter(fn (?array $item) => filled($item['quote'] ?? null))
            ->take(6)
            ->values()
            ->all();

        $normalized = count($normalized) >= 1 ? $normalized : $defaults;

        if (! collect($normalized)->contains(fn (array $item) => $item['is_visible'])) {
            $normalized[0]['is_visible'] = true;
        }

        return $normalized;
    }

    protected function normalizeStats(mixed $items, array $defaults): array
    {
        if (! is_array($items)) {
            return $defaults;
        }

        $normalized = collect($items)
            ->map(function ($item, int $index) use ($defaults) {
                if (! is_array($item)) {
                    return null;
                }

                $fallback = $defaults[$index] ?? $defaults[0];
                $value = (int) ($item['value'] ?? $fallback['value']);

                return [
                    'value' => $value > 0 ? $value : $fallback['value'],
                    'suffix' => $this->normalizeOptionalText($item['suffix'] ?? null) ?? $fallback['suffix'],
                    'label' => $this->normalizeTranslatedText($item['label'] ?? null, $fallback['label']),
                    'note' => $this->normalizeTranslatedText($item['note'] ?? null, $fallback['note']),
                ];
            })
            ->filter(fn (?array $item) => filled($item['label'] ?? null))
            ->take(4)
            ->values()
            ->all();

        return count($normalized) >= 2 ? $normalized : $defaults;
    }

    protected function normalizeLabeledList(mixed $items, array $defaults, int $minItems, int $maxItems): array
    {
        if (! is_array($items)) {
            return $defaults;
        }

        $normalized = collect($items)
            ->map(function ($item, int $index) use ($defaults) {
                if (! is_array($item)) {
                    return null;
                }

                $fallback = $defaults[$index] ?? $defaults[0];
                $label = $this->normalizeTranslatedText($item['label'] ?? null, $fallback['label']);

                return filled($label) ? ['label' => $label] : null;
            })
            ->filter()
            ->take($maxItems)
            ->values()
            ->all();

        return count($normalized) >= $minItems ? $normalized : $defaults;
    }

    protected function normalizeText(mixed $value, string $default): string
    {
        $value = is_string($value) ? trim($value) : '';

        return $value !== '' ? $value : $default;
    }

    protected function normalizeTranslatedText(mixed $value, array $default): array
    {
        if (is_string($value)) {
            $legacy = trim($value);

            return [
                'ar' => $legacy !== '' ? $legacy : $default['ar'],
                'en' => $legacy !== '' ? $legacy : ($default['en'] ?? $default['ar']),
            ];
        }

        $value = is_array($value) ? $value : [];

        $arRaw = is_string($value['ar'] ?? null) ? trim($value['ar']) : '';
        $enRaw = is_string($value['en'] ?? null) ? trim($value['en']) : '';

        $ar = $arRaw !== '' ? $arRaw : $default['ar'];
        $en = $enRaw !== '' ? $enRaw : ($arRaw !== '' ? $arRaw : ($default['en'] ?? $ar));

        return [
            'ar' => $ar,
            'en' => $en,
        ];
    }

    protected function normalizeOptionalText(mixed $value): ?string
    {
        $value = is_string($value) ? trim($value) : '';

        return $value !== '' ? $value : null;
    }

    protected function normalizeBoolean(mixed $value, bool $default): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (bool) $value;
        }

        return $default;
    }

    protected function translateValue(array $value, ?string $locale = null): string
    {
        $locale = $this->normalizeLocale($locale);

        return $value[$locale] ?: ($value[self::DEFAULT_LOCALE] ?: reset($value) ?: '');
    }

    protected function normalizeLocale(?string $locale): string
    {
        $locale ??= app()->getLocale();

        return in_array($locale, self::SUPPORTED_LOCALES, true) ? $locale : self::DEFAULT_LOCALE;
    }
}
