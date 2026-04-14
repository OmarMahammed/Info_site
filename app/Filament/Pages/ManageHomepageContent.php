<?php

namespace App\Filament\Pages;

use App\Models\HomepageContent;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

/**
 * @property-read Schema $form
 */
class ManageHomepageContent extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static ?string $navigationLabel = null;

    protected static ?string $title = null;

    protected ?string $heading = null;

    protected ?string $subheading = null;

    protected static ?string $slug = 'homepage-content';

    protected string $view = 'filament.pages.manage-homepage-content';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(HomepageContent::current()->toFormData());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Tabs::make(__('Homepage content tabs'))
                        ->tabs([
                            Tab::make(__('About'))
                                ->schema([
                                    Section::make(__('About visibility'))
                                        ->description(__('Turn this section on or off without deleting the content.'))
                                        ->schema([
                                            Toggle::make('about.is_enabled')
                                                ->label(__('Show About section'))
                                                ->inline(false)
                                                ->default(true)
                                                ->helperText(__('Disable this only if you want to hide the section from the homepage.')),
                                        ]),
                                    Section::make(__('About content'))
                                        ->description(__('Arabic is the primary language. If English is left empty, Arabic will be used as a fallback on the frontend.'))
                                        ->schema([
                                            Tabs::make(__('About language tabs'))
                                                ->tabs([
                                                    Tab::make(__('Arabic'))
                                                        ->schema([
                                                            TextInput::make('about.badge.ar')
                                                                ->label(__('Badge'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: شريك تقني موثوق'),
                                                            TextInput::make('about.title.ar')
                                                                ->label(__('Title'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder(__('مثال: من نحن')),
                                                            TextInput::make('about.subtitle.ar')
                                                                ->label(__('Subtitle'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder(__('مثال: نحن شريكك التقني لتطوير أعمالك في المملكة'))
                                                                ->columnSpanFull(),
                                                            Textarea::make('about.description.ar')
                                                                ->label(__('Description'))
                                                                ->required()
                                                                ->rows(4)
                                                                ->maxLength(320)
                                                                ->placeholder(__('اكتب وصفًا مختصرًا وواضحًا يشرح قيمة الشركة.'))
                                                                ->columnSpanFull(),
                                                            TextInput::make('about.cta_label.ar')
                                                                ->label(__('CTA label'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder(__('مثال: تواصل معنا')),
                                                            TextInput::make('about.image_alt.ar')
                                                                ->label(__('Image alt text'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('مثال: حلول تقنية متكاملة للأعمال')),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make(__('English'))
                                                        ->schema([
                                                            TextInput::make('about.badge.en')
                                                                ->label(__('Badge'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Trusted technology partner'))
                                                                ->helperText(__('Optional. Falls back to Arabic if empty.')),
                                                            TextInput::make('about.title.en')
                                                                ->label(__('Title'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: About us')),
                                                            TextInput::make('about.subtitle.en')
                                                                ->label(__('Subtitle'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: We are your technology partner for business growth in Saudi Arabia'))
                                                                ->columnSpanFull(),
                                                            Textarea::make('about.description.en')
                                                                ->label(__('Description'))
                                                                ->rows(4)
                                                                ->maxLength(320)
                                                                ->placeholder(__('Write a short, clear explanation of the company value.'))
                                                                ->columnSpanFull(),
                                                            TextInput::make('about.cta_label.en')
                                                                ->label(__('CTA label'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Contact us')),
                                                            TextInput::make('about.image_alt.en')
                                                                ->label(__('Image alt text'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Integrated technology solutions for businesses')),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                            FileUpload::make('about.image_path')
                                                ->label(__('Background image'))
                                                ->disk('public')
                                                ->directory('homepage/about')
                                                ->visibility('public')
                                                ->image()
                                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                                ->maxSize(3072)
                                                ->imagePreviewHeight('220')
                                                ->openable()
                                                ->downloadable()
                                                ->helperText(__('Recommended wide image. JPG, PNG, or WebP up to 3 MB.'))
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(1),
                                    Section::make(__('About trust points'))
                                        ->description(__('These short pills should stay concise and scannable.'))
                                        ->schema([
                                            Repeater::make('about.features')
                                                ->label(__('Trust points'))
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label(__('Arabic'))
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: جودة عالية'),
                                                    TextInput::make('label.en')
                                                        ->label(__('English'))
                                                        ->maxLength(255)
                                                        ->placeholder(__('Example: High quality'))
                                                        ->helperText(__('Optional. Arabic will be used if left empty.')),
                                                ])
                                                ->defaultItems(3)
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? __('Trust point'))
                                                ->addActionLabel(__('Add trust point'))
                                                ->columnSpanFull(),
                                        ]),
                                ]),
                            Tab::make(__('Services'))
                                ->schema([
                                    Section::make(__('Services visibility'))
                                        ->description(__('Use this if you want to temporarily hide the whole services section.'))
                                        ->schema([
                                            Toggle::make('services.is_enabled')
                                                ->label(__('Show Services section'))
                                                ->inline(false)
                                                ->default(true),
                                        ]),
                                    Section::make(__('Services header'))
                                        ->description(__('This content controls the left side of the spotlight section. English can be left empty and will fall back to Arabic.'))
                                        ->schema([
                                            Tabs::make(__('Services language tabs'))
                                                ->tabs([
                                                    Tab::make(__('Arabic'))
                                                        ->schema([
                                                            TextInput::make('services.badge.ar')
                                                                ->label(__('Badge'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: حلول تشغيلية مدروسة'),
                                                            TextInput::make('services.title.ar')
                                                                ->label(__('Title'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: خدماتنا'),
                                                            Textarea::make('services.description.ar')
                                                                ->label(__('Description'))
                                                                ->required()
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('اشرح بإيجاز كيف تقدمون الخدمة وما الذي يميزها.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('services.spotlight_label.ar')
                                                                ->label(__('Spotlight label'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: الخدمة تحت التركيز'),
                                                            TextInput::make('services.spotlight_cta_label.ar')
                                                                ->label(__('Spotlight CTA'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: ناقش احتياجك مع فريقنا'),
                                                            TextInput::make('services.detail_label.ar')
                                                                ->label(__('Detail label'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: عرض التفاصيل'),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make(__('English'))
                                                        ->schema([
                                                            TextInput::make('services.badge.en')
                                                                ->label(__('Badge'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Well-planned operational solutions')),
                                                            TextInput::make('services.title.en')
                                                                ->label(__('Title'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Our services')),
                                                            Textarea::make('services.description.en')
                                                                ->label(__('Description'))
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder(__('Briefly explain how your services help the client.'))
                                                                ->columnSpanFull(),
                                                            TextInput::make('services.spotlight_label.en')
                                                                ->label(__('Spotlight label'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Service in focus')),
                                                            TextInput::make('services.spotlight_cta_label.en')
                                                                ->label(__('Spotlight CTA'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Discuss your needs with our team')),
                                                            TextInput::make('services.detail_label.en')
                                                                ->label(__('Detail label'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: View details')),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(1),
                                    Section::make(__('Services supporting pills'))
                                        ->description(__('Keep these short so they remain readable on one line when possible.'))
                                        ->schema([
                                            Repeater::make('services.meta')
                                                ->label(__('Supporting pills'))
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label(__('Arabic'))
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: تشغيل أكثر استقرارًا'),
                                                    TextInput::make('label.en')
                                                        ->label(__('English'))
                                                        ->maxLength(255)
                                                        ->placeholder(__('Example: More stable operations')),
                                                ])
                                                ->defaultItems(3)
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? __('Supporting pill'))
                                                ->addActionLabel(__('Add pill'))
                                                ->columnSpanFull(),
                                        ]),
                                    Section::make(__('Service items'))
                                        ->description(__('These appear in the spotlight rail. You can hide an item without deleting it.'))
                                        ->schema([
                                            Repeater::make('services.items')
                                                ->label(__('Service items'))
                                                ->schema([
                                                    Toggle::make('is_visible')
                                                        ->label(__('Visible on homepage'))
                                                        ->default(true)
                                                        ->inline(false),
                                                    TextInput::make('title.ar')
                                                        ->label(__('Title (Arabic)'))
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: تجهيز أجهزة مكتبية'),
                                                    TextInput::make('title.en')
                                                        ->label(__('Title (English)'))
                                                        ->maxLength(255)
                                                        ->placeholder(__('Example: Desktop workstation setup')),
                                                    Select::make('icon')
                                                        ->required()
                                                        ->options([
                                                            'monitor' => __('Monitor'),
                                                            'network' => __('Network'),
                                                            'boxes' => __('Boxes'),
                                                            'wrench' => __('Wrench'),
                                                            'shield' => __('Shield'),
                                                            'bolt' => __('Bolt'),
                                                            'sliders' => __('Sliders'),
                                                            'headset' => __('Headset'),
                                                        ])
                                                        ->helperText(__('Choose from approved icons only to avoid broken UI.')),
                                                    Textarea::make('desc.ar')
                                                        ->label(__('Description (Arabic)'))
                                                        ->required()
                                                        ->maxLength(280)
                                                        ->rows(3)
                                                        ->placeholder('صف الخدمة بطريقة مباشرة ومختصرة.')
                                                        ->columnSpanFull(),
                                                    Textarea::make('desc.en')
                                                        ->label(__('Description (English)'))
                                                        ->maxLength(280)
                                                        ->rows(3)
                                                        ->placeholder(__('Describe the service in a direct and concise way.'))
                                                        ->columnSpanFull(),
                                                ])
                                                ->collapsible()
                                                ->collapsed()
                                                ->minItems(2)
                                                ->maxItems(6)
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => (($state['title']['ar'] ?? $state['title']['en'] ?? __('Service item'))) . (($state['is_visible'] ?? true) ? '' : __(' (Hidden)')))
                                                ->addActionLabel(__('Add service item'))
                                                ->columnSpanFull(),
                                        ]),
                                ]),
                            Tab::make(__('Trust'))
                                ->schema([
                                    Section::make(__('Trust visibility'))
                                        ->description(__('Turn the full trust section on or off if needed.'))
                                        ->schema([
                                            Toggle::make('trust.is_enabled')
                                                ->label(__('Show Trust section'))
                                                ->inline(false)
                                                ->default(true),
                                        ]),
                                    Section::make(__('Trust header'))
                                        ->description(__('This introduces the trust section before the proof elements. English fields are optional and fall back to Arabic.'))
                                        ->schema([
                                            Tabs::make(__('Trust language tabs'))
                                                ->tabs([
                                                    Tab::make(__('Arabic'))
                                                        ->schema([
                                                            TextInput::make('trust.kicker.ar')
                                                                ->label(__('Kicker'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: ثقة قبل القرار'),
                                                            TextInput::make('trust.story_tag.ar')
                                                                ->label(__('Story tag'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: عملاء وثقوا فينا'),
                                                            TextInput::make('trust.evidence_title.ar')
                                                                ->label(__('Evidence title'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: حلولنا مجربة ونتائجها واضحة'),
                                                            TextInput::make('trust.title.ar')
                                                                ->label(__('Title'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: ليش ناس كثير ترتاح تتواصل معنا من أول مرة؟')
                                                                ->columnSpanFull(),
                                                            Textarea::make('trust.description.ar')
                                                                ->label(__('Description'))
                                                                ->required()
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('اشرح السبب الذي يجعل العميل يثق بكم بسرعة.')
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make(__('English'))
                                                        ->schema([
                                                            TextInput::make('trust.kicker.en')
                                                                ->label(__('Kicker'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Confidence before the decision')),
                                                            TextInput::make('trust.story_tag.en')
                                                                ->label(__('Story tag'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Clients who trusted us')),
                                                            TextInput::make('trust.evidence_title.en')
                                                                ->label(__('Evidence title'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Our solutions are proven and the results are clear')),
                                                            TextInput::make('trust.title.en')
                                                                ->label(__('Title'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Why do so many clients feel comfortable reaching out to us from the first message?'))
                                                                ->columnSpanFull(),
                                                            Textarea::make('trust.description.en')
                                                                ->label(__('Description'))
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder(__('Explain why the client can trust you quickly.'))
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(1),
                                    Section::make(__('Proof ribbon'))
                                        ->description(__('Short labels representing the kinds of clients or businesses you serve.'))
                                        ->schema([
                                            Repeater::make('trust.logos')
                                                ->label(__('Proof ribbon labels'))
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label(__('Arabic'))
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: شركات تشغيل'),
                                                    TextInput::make('label.en')
                                                        ->label(__('English'))
                                                        ->maxLength(255)
                                                        ->placeholder(__('Example: Operations companies')),
                                                ])
                                                ->collapsible()
                                                ->collapsed()
                                                ->minItems(3)
                                                ->maxItems(8)
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Ribbon item')
                                                ->addActionLabel(__('Add ribbon item'))
                                                ->columnSpanFull(),
                                        ]),
                                    Section::make(__('Testimonials'))
                                        ->description(__('Use only the strongest testimonials. You can hide one without deleting it.'))
                                        ->schema([
                                            Repeater::make('trust.testimonials')
                                                ->label(__('Testimonials'))
                                                ->schema([
                                                    Toggle::make('is_visible')
                                                        ->label(__('Visible on homepage'))
                                                        ->default(true)
                                                        ->inline(false),
                                                    Textarea::make('quote.ar')
                                                        ->label(__('Quote (Arabic)'))
                                                        ->required()
                                                        ->maxLength(420)
                                                        ->rows(3)
                                                        ->placeholder('اكتب رأيًا قصيرًا وواضحًا يعكس الثقة أو سهولة التعامل.')
                                                        ->columnSpanFull(),
                                                    Textarea::make('quote.en')
                                                        ->label(__('Quote (English)'))
                                                        ->maxLength(420)
                                                        ->rows(3)
                                                        ->placeholder(__('Write a short testimonial that reflects trust or ease of dealing.'))
                                                        ->columnSpanFull(),
                                                    TextInput::make('author.ar')
                                                        ->label(__('Author (Arabic)'))
                                                        ->required()
                                                        ->maxLength(120)
                                                        ->placeholder('مثال: مدير تشغيل'),
                                                    TextInput::make('author.en')
                                                        ->label(__('Author (English)'))
                                                        ->maxLength(120)
                                                        ->placeholder(__('Example: Operations Manager')),
                                                    TextInput::make('company.ar')
                                                        ->label(__('Company (Arabic)'))
                                                        ->required()
                                                        ->maxLength(160)
                                                        ->placeholder('مثال: شركة خدمات لوجستية - الرياض'),
                                                    TextInput::make('company.en')
                                                        ->label(__('Company (English)'))
                                                        ->maxLength(160)
                                                        ->placeholder(__('Example: Logistics company - Riyadh')),
                                                ])
                                                ->collapsible()
                                                ->collapsed()
                                                ->minItems(1)
                                                ->maxItems(6)
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => (($state['author']['ar'] ?? $state['author']['en'] ?? 'Testimonial')) . (($state['is_visible'] ?? true) ? '' : ' (Hidden)'))
                                                ->addActionLabel(__('Add testimonial'))
                                                ->columnSpanFull(),
                                        ]),
                                    Section::make(__('Guarantees and stats'))
                                        ->description(__('These elements create reassurance and measurable proof.'))
                                        ->schema([
                                            Repeater::make('trust.guarantees')
                                                ->label(__('Guarantees'))
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label(__('Arabic'))
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: خلك على اطلاع من أول تواصل'),
                                                    TextInput::make('label.en')
                                                        ->label(__('English'))
                                                        ->maxLength(255)
                                                        ->placeholder(__('Example: Stay informed from the first contact')),
                                                ])
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Guarantee')
                                                ->addActionLabel(__('Add guarantee'))
                                                ->columnSpanFull(),
                                            Repeater::make('trust.stats')
                                                ->label(__('Stats'))
                                                ->schema([
                                                    TextInput::make('value')
                                                        ->required()
                                                        ->numeric()
                                                        ->minValue(1)
                                                        ->maxValue(999)
                                                        ->placeholder('مثال: 4'),
                                                    TextInput::make('suffix')
                                                        ->maxLength(20)
                                                        ->placeholder(__('Optional: % or +')),
                                                    TextInput::make('label.ar')
                                                        ->label(__('Label (Arabic)'))
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: خدمات تشغيلية أساسية')
                                                        ->columnSpanFull(),
                                                    TextInput::make('label.en')
                                                        ->label(__('Label (English)'))
                                                        ->maxLength(255)
                                                        ->placeholder(__('Example: Core operational services'))
                                                        ->columnSpanFull(),
                                                    Textarea::make('note.ar')
                                                        ->label(__('Note (Arabic)'))
                                                        ->required()
                                                        ->maxLength(220)
                                                        ->rows(2)
                                                        ->placeholder('اشرح الرقم بشكل مختصر ومفهوم.')
                                                        ->columnSpanFull(),
                                                    Textarea::make('note.en')
                                                        ->label(__('Note (English)'))
                                                        ->maxLength(220)
                                                        ->rows(2)
                                                        ->placeholder(__('Explain the number in a short and clear way.'))
                                                        ->columnSpanFull(),
                                                ])
                                                ->collapsible()
                                                ->collapsed()
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Stat')
                                                ->addActionLabel(__('Add stat'))
                                                ->columnSpanFull(),
                                        ]),
                                    Section::make(__('CTA area'))
                                        ->description(__('This is the final push before the contact form. Keep it clear and low-friction.'))
                                        ->schema([
                                            Tabs::make(__('Trust CTA language tabs'))
                                                ->tabs([
                                                    Tab::make(__('Arabic'))
                                                        ->schema([
                                                            TextInput::make('trust.cta_title.ar')
                                                                ->label(__('CTA title'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: إذا ودك تبدأ بخطوة واضحة، خلنا نرتبها معك')
                                                                ->columnSpanFull(),
                                                            Textarea::make('trust.cta_copy.ar')
                                                                ->label(__('CTA copy'))
                                                                ->required()
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('اشرح باختصار ماذا سيحصل بعد التواصل.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_urgency.ar')
                                                                ->label(__('Urgency line'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: جاهزين نخدمك اليوم وردنا عليك غالبًا خلال دقائق.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_primary_label.ar')
                                                                ->label(__('Primary CTA'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: خلنا نبدأ معك الآن'),
                                                            TextInput::make('trust.cta_secondary_label.ar')
                                                                ->label(__('Secondary CTA'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: كلمنا على واتساب'),
                                                            TextInput::make('trust.whatsapp_message.ar')
                                                                ->label(__('WhatsApp message'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: السلام عليكم، حاب أعرف وش الحل الأنسب لاحتياجي')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_microcopy.ar')
                                                                ->label(__('Microcopy'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: استشارة مجانية، بدون التزام، وبياناتك في أمان.')
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make(__('English'))
                                                        ->schema([
                                                            TextInput::make('trust.cta_title.en')
                                                                ->label(__('CTA title'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: If you want a clear next step, let us structure it with you'))
                                                                ->columnSpanFull(),
                                                            Textarea::make('trust.cta_copy.en')
                                                                ->label(__('CTA copy'))
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder(__('Explain briefly what happens after the user gets in touch.'))
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_urgency.en')
                                                                ->label(__('Urgency line'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: We are ready to help today, and we usually reply within minutes.'))
                                                                ->helperText(__('Optional. Arabic will be used if left empty.'))
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_primary_label.en')
                                                                ->label(__('Primary CTA'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Let us get started with you')),
                                                            TextInput::make('trust.cta_secondary_label.en')
                                                                ->label(__('Secondary CTA'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Chat with us on WhatsApp')),
                                                            TextInput::make('trust.whatsapp_message.en')
                                                                ->label(__('WhatsApp message'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Hello, I would like to know the best solution for my needs'))
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_microcopy.en')
                                                                ->label(__('Microcopy'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Free consultation, no obligation, and your information is safe.'))
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                            Repeater::make('trust.safety')
                                                ->label(__('Safety microcopy'))
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label(__('Arabic'))
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: خصوصية بياناتك محفوظة'),
                                                    TextInput::make('label.en')
                                                        ->label(__('English'))
                                                        ->maxLength(255)
                                                        ->placeholder(__('Example: Your data privacy is protected')),
                                                ])
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Safety note')
                                                ->addActionLabel(__('Add safety note'))
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(2),
                                ]),
                            Tab::make(__('Footer'))
                                ->schema([
                                    Section::make(__('Footer content'))
                                        ->description(__('Brand description and contact info shown in the footer. English falls back to Arabic if empty.'))
                                        ->schema([
                                            Tabs::make(__('Footer language tabs'))
                                                ->tabs([
                                                    Tab::make(__('Arabic'))
                                                        ->schema([
                                                            Textarea::make('footer.description.ar')
                                                                ->label(__('Brand description'))
                                                                ->required()
                                                                ->rows(3)
                                                                ->maxLength(300)
                                                                ->placeholder('وصف مختصر عن الشركة يظهر في الفوتر.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('footer.location.ar')
                                                                ->label(__('Location'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: الرياض، المملكة العربية السعودية'),
                                                            TextInput::make('footer.copyright.ar')
                                                                ->label(__('Copyright text'))
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: Al Kayan Technology. جميع الحقوق محفوظة.'),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make(__('English'))
                                                        ->schema([
                                                            Textarea::make('footer.description.en')
                                                                ->label(__('Brand description'))
                                                                ->rows(3)
                                                                ->maxLength(300)
                                                                ->placeholder(__('Short brand description shown in the footer.'))
                                                                ->helperText(__('Optional. Falls back to Arabic.'))
                                                                ->columnSpanFull(),
                                                            TextInput::make('footer.location.en')
                                                                ->label(__('Location'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Riyadh, Saudi Arabia')),
                                                            TextInput::make('footer.copyright.en')
                                                                ->label(__('Copyright text'))
                                                                ->maxLength(255)
                                                                ->placeholder(__('Example: Al Kayan Technology. All rights reserved.')),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                            TextInput::make('footer.email')
                                                ->label(__('Email'))
                                                ->email()
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder(__('info@alkayantech.sa')),
                                            TextInput::make('footer.phone')
                                                ->label(__('Phone'))
                                                ->required()
                                                ->maxLength(60)
                                                ->placeholder('+966 11 000 0000'),
                                        ])
                                        ->columns(2),
                                    Section::make(__('Social media'))
                                        ->description(__('Add your social links. Only enabled platforms with a URL will show on the website.'))
                                        ->schema([
                                            Repeater::make('footer.socials')
                                                ->label(__('Social platforms'))
                                                ->schema([
                                                    Select::make('platform')
                                                        ->required()
                                                        ->options([
                                                            'whatsapp' => __('WhatsApp'),
                                                            'instagram' => __('Instagram'),
                                                            'x' => __('X (Twitter)'),
                                                            'facebook' => __('Facebook'),
                                                            'youtube' => __('YouTube'),
                                                            'tiktok' => __('TikTok'),
                                                            'snapchat' => __('Snapchat'),
                                                        ]),
                                                    TextInput::make('url')
                                                        ->label(__('Profile URL'))
                                                        ->url()
                                                        ->maxLength(500)
                                                        ->placeholder(__('https://...'))
                                                        ->columnSpanFull(),
                                                    Toggle::make('is_enabled')
                                                        ->label(__('Show on website'))
                                                        ->default(false)
                                                        ->inline(false),
                                                ])
                                                ->defaultItems(7)
                                                ->minItems(1)
                                                ->maxItems(7)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn(array $state): ?string => match ($state['platform'] ?? '') {
                                                    'whatsapp' => __('WhatsApp'),
                                                    'instagram' => __('Instagram'),
                                                    'x' => __('X (Twitter)'),
                                                    'facebook' => __('Facebook'),
                                                    'youtube' => __('YouTube'),
                                                    'tiktok' => __('TikTok'),
                                                    'snapchat' => __('Snapchat'),
                                                    default => __('Social link'),
                                                } . (($state['is_enabled'] ?? false) ? '' : __(' (Disabled)')))
                                                ->addActionLabel(__('Add social platform'))
                                                ->columnSpanFull(),
                                        ]),
                                ]),
                        ])
                        ->columnSpanFull(),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label(__('Save homepage content'))
                                ->icon(Heroicon::OutlinedCheckCircle)
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->record($this->getRecord())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $record = HomepageContent::current();

        $record->fillContent($data);
        $record->save();

        if ($record->wasRecentlyCreated) {
            $this->form->record($record)->saveRelationships();
        }

        Notification::make()
            ->success()
            ->title(__('Homepage content saved'))
            ->body(__('Your homepage updates are ready and the content remains safely structured.'))
            ->send();
    }

    public function getRecord(): ?HomepageContent
    {
        return HomepageContent::current();
    }

    public static function getNavigationLabel(): string
    {
        return __('Homepage Content');
    }

    public function getTitle(): string
    {
        return __('Homepage Content');
    }

    public function getHeading(): string
    {
        return __('Homepage Content');
    }

    public function getSubheading(): ?string
    {
        return __('Edit the About, Services, Trust, and Footer sections from one place.');
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }
}
