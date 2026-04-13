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

    protected static ?string $navigationLabel = 'Homepage Content';

    protected static ?string $title = 'Homepage Content';

    protected ?string $heading = 'Homepage Content';

    protected ?string $subheading = 'Edit the About, Services, and Trust sections from one place.';

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
                    Tabs::make('Homepage content tabs')
                        ->tabs([
                            Tab::make('About')
                                ->schema([
                                    Section::make('About visibility')
                                        ->description('Turn this section on or off without deleting the content.')
                                        ->schema([
                                            Toggle::make('about.is_enabled')
                                                ->label('Show About section')
                                                ->inline(false)
                                                ->default(true)
                                                ->helperText('Disable this only if you want to hide the section from the homepage.'),
                                        ]),
                                    Section::make('About content')
                                        ->description('Arabic is the primary language. If English is left empty, Arabic will be used as a fallback on the frontend.')
                                        ->schema([
                                            Tabs::make('About language tabs')
                                                ->tabs([
                                                    Tab::make('Arabic')
                                                        ->schema([
                                                            TextInput::make('about.badge.ar')
                                                                ->label('Badge')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: شريك تقني موثوق'),
                                                            TextInput::make('about.title.ar')
                                                                ->label('Title')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: من نحن'),
                                                            TextInput::make('about.subtitle.ar')
                                                                ->label('Subtitle')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: نحن شريكك التقني لتطوير أعمالك في المملكة')
                                                                ->columnSpanFull(),
                                                            Textarea::make('about.description.ar')
                                                                ->label('Description')
                                                                ->required()
                                                                ->rows(4)
                                                                ->maxLength(320)
                                                                ->placeholder('اكتب وصفًا مختصرًا وواضحًا يشرح قيمة الشركة.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('about.cta_label.ar')
                                                                ->label('CTA label')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: تواصل معنا'),
                                                            TextInput::make('about.image_alt.ar')
                                                                ->label('Image alt text')
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: حلول تقنية متكاملة للأعمال'),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make('English')
                                                        ->schema([
                                                            TextInput::make('about.badge.en')
                                                                ->label('Badge')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Trusted technology partner')
                                                                ->helperText('Optional. Falls back to Arabic if empty.'),
                                                            TextInput::make('about.title.en')
                                                                ->label('Title')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: About us'),
                                                            TextInput::make('about.subtitle.en')
                                                                ->label('Subtitle')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: We are your technology partner for business growth in Saudi Arabia')
                                                                ->columnSpanFull(),
                                                            Textarea::make('about.description.en')
                                                                ->label('Description')
                                                                ->rows(4)
                                                                ->maxLength(320)
                                                                ->placeholder('Write a short, clear explanation of the company value.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('about.cta_label.en')
                                                                ->label('CTA label')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Contact us'),
                                                            TextInput::make('about.image_alt.en')
                                                                ->label('Image alt text')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Integrated technology solutions for businesses'),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                            FileUpload::make('about.image_path')
                                                ->label('Background image')
                                                ->disk('public')
                                                ->directory('homepage/about')
                                                ->visibility('public')
                                                ->image()
                                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                                ->maxSize(3072)
                                                ->imagePreviewHeight('220')
                                                ->openable()
                                                ->downloadable()
                                                ->helperText('Recommended wide image. JPG, PNG, or WebP up to 3 MB.')
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(1),
                                    Section::make('About trust points')
                                        ->description('These short pills should stay concise and scannable.')
                                        ->schema([
                                            Repeater::make('about.features')
                                                ->label('Trust points')
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label('Arabic')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: جودة عالية'),
                                                    TextInput::make('label.en')
                                                        ->label('English')
                                                        ->maxLength(255)
                                                        ->placeholder('Example: High quality')
                                                        ->helperText('Optional. Arabic will be used if left empty.'),
                                                ])
                                                ->defaultItems(3)
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn (array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Trust point')
                                                ->addActionLabel('Add trust point')
                                                ->columnSpanFull(),
                                        ]),
                                ]),
                            Tab::make('Services')
                                ->schema([
                                    Section::make('Services visibility')
                                        ->description('Use this if you want to temporarily hide the whole services section.')
                                        ->schema([
                                            Toggle::make('services.is_enabled')
                                                ->label('Show Services section')
                                                ->inline(false)
                                                ->default(true),
                                        ]),
                                    Section::make('Services header')
                                        ->description('This content controls the left side of the spotlight section. English can be left empty and will fall back to Arabic.')
                                        ->schema([
                                            Tabs::make('Services language tabs')
                                                ->tabs([
                                                    Tab::make('Arabic')
                                                        ->schema([
                                                            TextInput::make('services.badge.ar')
                                                                ->label('Badge')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: حلول تشغيلية مدروسة'),
                                                            TextInput::make('services.title.ar')
                                                                ->label('Title')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: خدماتنا'),
                                                            Textarea::make('services.description.ar')
                                                                ->label('Description')
                                                                ->required()
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('اشرح بإيجاز كيف تقدمون الخدمة وما الذي يميزها.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('services.spotlight_label.ar')
                                                                ->label('Spotlight label')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: الخدمة تحت التركيز'),
                                                            TextInput::make('services.spotlight_cta_label.ar')
                                                                ->label('Spotlight CTA')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: ناقش احتياجك مع فريقنا'),
                                                            TextInput::make('services.detail_label.ar')
                                                                ->label('Detail label')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: عرض التفاصيل'),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make('English')
                                                        ->schema([
                                                            TextInput::make('services.badge.en')
                                                                ->label('Badge')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Well-planned operational solutions'),
                                                            TextInput::make('services.title.en')
                                                                ->label('Title')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Our services'),
                                                            Textarea::make('services.description.en')
                                                                ->label('Description')
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('Briefly explain how your services help the client.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('services.spotlight_label.en')
                                                                ->label('Spotlight label')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Service in focus'),
                                                            TextInput::make('services.spotlight_cta_label.en')
                                                                ->label('Spotlight CTA')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Discuss your needs with our team'),
                                                            TextInput::make('services.detail_label.en')
                                                                ->label('Detail label')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: View details'),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(1),
                                    Section::make('Services supporting pills')
                                        ->description('Keep these short so they remain readable on one line when possible.')
                                        ->schema([
                                            Repeater::make('services.meta')
                                                ->label('Supporting pills')
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label('Arabic')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: تشغيل أكثر استقرارًا'),
                                                    TextInput::make('label.en')
                                                        ->label('English')
                                                        ->maxLength(255)
                                                        ->placeholder('Example: More stable operations'),
                                                ])
                                                ->defaultItems(3)
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn (array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Supporting pill')
                                                ->addActionLabel('Add pill')
                                                ->columnSpanFull(),
                                        ]),
                                    Section::make('Service items')
                                        ->description('These appear in the spotlight rail. You can hide an item without deleting it.')
                                        ->schema([
                                            Repeater::make('services.items')
                                                ->label('Service items')
                                                ->schema([
                                                    Toggle::make('is_visible')
                                                        ->label('Visible on homepage')
                                                        ->default(true)
                                                        ->inline(false),
                                                    TextInput::make('title.ar')
                                                        ->label('Title (Arabic)')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: تجهيز أجهزة مكتبية'),
                                                    TextInput::make('title.en')
                                                        ->label('Title (English)')
                                                        ->maxLength(255)
                                                        ->placeholder('Example: Desktop workstation setup'),
                                                    Select::make('icon')
                                                        ->required()
                                                        ->options([
                                                            'monitor' => 'Monitor',
                                                            'network' => 'Network',
                                                            'boxes' => 'Boxes',
                                                            'wrench' => 'Wrench',
                                                            'shield' => 'Shield',
                                                            'bolt' => 'Bolt',
                                                            'sliders' => 'Sliders',
                                                            'headset' => 'Headset',
                                                        ])
                                                        ->helperText('Choose from approved icons only to avoid broken UI.'),
                                                    Textarea::make('desc.ar')
                                                        ->label('Description (Arabic)')
                                                        ->required()
                                                        ->maxLength(280)
                                                        ->rows(3)
                                                        ->placeholder('صف الخدمة بطريقة مباشرة ومختصرة.')
                                                        ->columnSpanFull(),
                                                    Textarea::make('desc.en')
                                                        ->label('Description (English)')
                                                        ->maxLength(280)
                                                        ->rows(3)
                                                        ->placeholder('Describe the service in a direct and concise way.')
                                                        ->columnSpanFull(),
                                                ])
                                                ->collapsible()
                                                ->collapsed()
                                                ->minItems(2)
                                                ->maxItems(6)
                                                ->reorderable()
                                                ->itemLabel(fn (array $state): ?string => (($state['title']['ar'] ?? $state['title']['en'] ?? 'Service item')) . (($state['is_visible'] ?? true) ? '' : ' (Hidden)'))
                                                ->addActionLabel('Add service item')
                                                ->columnSpanFull(),
                                        ]),
                                ]),
                            Tab::make('Trust')
                                ->schema([
                                    Section::make('Trust visibility')
                                        ->description('Turn the full trust section on or off if needed.')
                                        ->schema([
                                            Toggle::make('trust.is_enabled')
                                                ->label('Show Trust section')
                                                ->inline(false)
                                                ->default(true),
                                        ]),
                                    Section::make('Trust header')
                                        ->description('This introduces the trust section before the proof elements. English fields are optional and fall back to Arabic.')
                                        ->schema([
                                            Tabs::make('Trust language tabs')
                                                ->tabs([
                                                    Tab::make('Arabic')
                                                        ->schema([
                                                            TextInput::make('trust.kicker.ar')
                                                                ->label('Kicker')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: ثقة قبل القرار'),
                                                            TextInput::make('trust.story_tag.ar')
                                                                ->label('Story tag')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: عملاء وثقوا فينا'),
                                                            TextInput::make('trust.evidence_title.ar')
                                                                ->label('Evidence title')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: حلولنا مجربة ونتائجها واضحة'),
                                                            TextInput::make('trust.title.ar')
                                                                ->label('Title')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: ليش ناس كثير ترتاح تتواصل معنا من أول مرة؟')
                                                                ->columnSpanFull(),
                                                            Textarea::make('trust.description.ar')
                                                                ->label('Description')
                                                                ->required()
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('اشرح السبب الذي يجعل العميل يثق بكم بسرعة.')
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make('English')
                                                        ->schema([
                                                            TextInput::make('trust.kicker.en')
                                                                ->label('Kicker')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Confidence before the decision'),
                                                            TextInput::make('trust.story_tag.en')
                                                                ->label('Story tag')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Clients who trusted us'),
                                                            TextInput::make('trust.evidence_title.en')
                                                                ->label('Evidence title')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Our solutions are proven and the results are clear'),
                                                            TextInput::make('trust.title.en')
                                                                ->label('Title')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Why do so many clients feel comfortable reaching out to us from the first message?')
                                                                ->columnSpanFull(),
                                                            Textarea::make('trust.description.en')
                                                                ->label('Description')
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('Explain why the client can trust you quickly.')
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(1),
                                    Section::make('Proof ribbon')
                                        ->description('Short labels representing the kinds of clients or businesses you serve.')
                                        ->schema([
                                            Repeater::make('trust.logos')
                                                ->label('Proof ribbon labels')
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label('Arabic')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: شركات تشغيل'),
                                                    TextInput::make('label.en')
                                                        ->label('English')
                                                        ->maxLength(255)
                                                        ->placeholder('Example: Operations companies'),
                                                ])
                                                ->collapsible()
                                                ->collapsed()
                                                ->minItems(3)
                                                ->maxItems(8)
                                                ->reorderable()
                                                ->itemLabel(fn (array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Ribbon item')
                                                ->addActionLabel('Add ribbon item')
                                                ->columnSpanFull(),
                                        ]),
                                    Section::make('Testimonials')
                                        ->description('Use only the strongest testimonials. You can hide one without deleting it.')
                                        ->schema([
                                            Repeater::make('trust.testimonials')
                                                ->label('Testimonials')
                                                ->schema([
                                                    Toggle::make('is_visible')
                                                        ->label('Visible on homepage')
                                                        ->default(true)
                                                        ->inline(false),
                                                    Textarea::make('quote.ar')
                                                        ->label('Quote (Arabic)')
                                                        ->required()
                                                        ->maxLength(420)
                                                        ->rows(3)
                                                        ->placeholder('اكتب رأيًا قصيرًا وواضحًا يعكس الثقة أو سهولة التعامل.')
                                                        ->columnSpanFull(),
                                                    Textarea::make('quote.en')
                                                        ->label('Quote (English)')
                                                        ->maxLength(420)
                                                        ->rows(3)
                                                        ->placeholder('Write a short testimonial that reflects trust or ease of dealing.')
                                                        ->columnSpanFull(),
                                                    TextInput::make('author.ar')
                                                        ->label('Author (Arabic)')
                                                        ->required()
                                                        ->maxLength(120)
                                                        ->placeholder('مثال: مدير تشغيل'),
                                                    TextInput::make('author.en')
                                                        ->label('Author (English)')
                                                        ->maxLength(120)
                                                        ->placeholder('Example: Operations Manager'),
                                                    TextInput::make('company.ar')
                                                        ->label('Company (Arabic)')
                                                        ->required()
                                                        ->maxLength(160)
                                                        ->placeholder('مثال: شركة خدمات لوجستية - الرياض'),
                                                    TextInput::make('company.en')
                                                        ->label('Company (English)')
                                                        ->maxLength(160)
                                                        ->placeholder('Example: Logistics company - Riyadh'),
                                                ])
                                                ->collapsible()
                                                ->collapsed()
                                                ->minItems(1)
                                                ->maxItems(6)
                                                ->reorderable()
                                                ->itemLabel(fn (array $state): ?string => (($state['author']['ar'] ?? $state['author']['en'] ?? 'Testimonial')) . (($state['is_visible'] ?? true) ? '' : ' (Hidden)'))
                                                ->addActionLabel('Add testimonial')
                                                ->columnSpanFull(),
                                        ]),
                                    Section::make('Guarantees and stats')
                                        ->description('These elements create reassurance and measurable proof.')
                                        ->schema([
                                            Repeater::make('trust.guarantees')
                                                ->label('Guarantees')
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label('Arabic')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: خلك على اطلاع من أول تواصل'),
                                                    TextInput::make('label.en')
                                                        ->label('English')
                                                        ->maxLength(255)
                                                        ->placeholder('Example: Stay informed from the first contact'),
                                                ])
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn (array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Guarantee')
                                                ->addActionLabel('Add guarantee')
                                                ->columnSpanFull(),
                                            Repeater::make('trust.stats')
                                                ->label('Stats')
                                                ->schema([
                                                    TextInput::make('value')
                                                        ->required()
                                                        ->numeric()
                                                        ->minValue(1)
                                                        ->maxValue(999)
                                                        ->placeholder('مثال: 4'),
                                                    TextInput::make('suffix')
                                                        ->maxLength(20)
                                                        ->placeholder('Optional: % or +'),
                                                    TextInput::make('label.ar')
                                                        ->label('Label (Arabic)')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: خدمات تشغيلية أساسية')
                                                        ->columnSpanFull(),
                                                    TextInput::make('label.en')
                                                        ->label('Label (English)')
                                                        ->maxLength(255)
                                                        ->placeholder('Example: Core operational services')
                                                        ->columnSpanFull(),
                                                    Textarea::make('note.ar')
                                                        ->label('Note (Arabic)')
                                                        ->required()
                                                        ->maxLength(220)
                                                        ->rows(2)
                                                        ->placeholder('اشرح الرقم بشكل مختصر ومفهوم.')
                                                        ->columnSpanFull(),
                                                    Textarea::make('note.en')
                                                        ->label('Note (English)')
                                                        ->maxLength(220)
                                                        ->rows(2)
                                                        ->placeholder('Explain the number in a short and clear way.')
                                                        ->columnSpanFull(),
                                                ])
                                                ->collapsible()
                                                ->collapsed()
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->reorderable()
                                                ->itemLabel(fn (array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Stat')
                                                ->addActionLabel('Add stat')
                                                ->columnSpanFull(),
                                        ]),
                                    Section::make('CTA area')
                                        ->description('This is the final push before the contact form. Keep it clear and low-friction.')
                                        ->schema([
                                            Tabs::make('Trust CTA language tabs')
                                                ->tabs([
                                                    Tab::make('Arabic')
                                                        ->schema([
                                                            TextInput::make('trust.cta_title.ar')
                                                                ->label('CTA title')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: إذا ودك تبدأ بخطوة واضحة، خلنا نرتبها معك')
                                                                ->columnSpanFull(),
                                                            Textarea::make('trust.cta_copy.ar')
                                                                ->label('CTA copy')
                                                                ->required()
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('اشرح باختصار ماذا سيحصل بعد التواصل.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_urgency.ar')
                                                                ->label('Urgency line')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: جاهزين نخدمك اليوم وردنا عليك غالبًا خلال دقائق.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_primary_label.ar')
                                                                ->label('Primary CTA')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: خلنا نبدأ معك الآن'),
                                                            TextInput::make('trust.cta_secondary_label.ar')
                                                                ->label('Secondary CTA')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: كلمنا على واتساب'),
                                                            TextInput::make('trust.whatsapp_message.ar')
                                                                ->label('WhatsApp message')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: السلام عليكم، حاب أعرف وش الحل الأنسب لاحتياجي')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_microcopy.ar')
                                                                ->label('Microcopy')
                                                                ->required()
                                                                ->maxLength(255)
                                                                ->placeholder('مثال: استشارة مجانية، بدون التزام، وبياناتك في أمان.')
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->columns(2),
                                                    Tab::make('English')
                                                        ->schema([
                                                            TextInput::make('trust.cta_title.en')
                                                                ->label('CTA title')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: If you want a clear next step, let us structure it with you')
                                                                ->columnSpanFull(),
                                                            Textarea::make('trust.cta_copy.en')
                                                                ->label('CTA copy')
                                                                ->rows(3)
                                                                ->maxLength(320)
                                                                ->placeholder('Explain briefly what happens after the user gets in touch.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_urgency.en')
                                                                ->label('Urgency line')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: We are ready to help today, and we usually reply within minutes.')
                                                                ->helperText('Optional. Arabic will be used if left empty.')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_primary_label.en')
                                                                ->label('Primary CTA')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Let us get started with you'),
                                                            TextInput::make('trust.cta_secondary_label.en')
                                                                ->label('Secondary CTA')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Chat with us on WhatsApp'),
                                                            TextInput::make('trust.whatsapp_message.en')
                                                                ->label('WhatsApp message')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Hello, I would like to know the best solution for my needs')
                                                                ->columnSpanFull(),
                                                            TextInput::make('trust.cta_microcopy.en')
                                                                ->label('Microcopy')
                                                                ->maxLength(255)
                                                                ->placeholder('Example: Free consultation, no obligation, and your information is safe.')
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->columnSpanFull(),
                                            Repeater::make('trust.safety')
                                                ->label('Safety microcopy')
                                                ->schema([
                                                    TextInput::make('label.ar')
                                                        ->label('Arabic')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('مثال: خصوصية بياناتك محفوظة'),
                                                    TextInput::make('label.en')
                                                        ->label('English')
                                                        ->maxLength(255)
                                                        ->placeholder('Example: Your data privacy is protected'),
                                                ])
                                                ->minItems(2)
                                                ->maxItems(4)
                                                ->collapsible()
                                                ->collapsed()
                                                ->reorderable()
                                                ->itemLabel(fn (array $state): ?string => $state['label']['ar'] ?? $state['label']['en'] ?? 'Safety note')
                                                ->addActionLabel('Add safety note')
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(2),
                                ]),
                        ])
                        ->columnSpanFull(),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save homepage content')
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
            ->title('Homepage content saved')
            ->body('Your homepage updates are ready and the content remains safely structured.')
            ->send();
    }

    public function getRecord(): ?HomepageContent
    {
        return HomepageContent::current();
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }
}
