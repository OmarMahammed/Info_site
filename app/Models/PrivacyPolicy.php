<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'sections',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sections' => 'array',
        ];
    }

    public function getTitle(): string
    {
        return app()->getLocale() === 'ar'
            ? (string) $this->title_ar
            : (string) $this->title_en;
    }

    public function getSectionsForLocale(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $isArabic = $locale === 'ar';

        return collect($this->sections ?? [])
            ->map(function ($section) use ($isArabic) {
                $title = $isArabic
                    ? ($section['title_ar'] ?? null)
                    : ($section['title_en'] ?? null);

                $description = $isArabic
                    ? ($section['desc_ar'] ?? null)
                    : ($section['desc_en'] ?? null);

                return [
                    'title' => (string) ($title ?: ($isArabic ? ($section['title_en'] ?? '') : ($section['title_ar'] ?? ''))),
                    'description' => (string) ($description ?: ($isArabic ? ($section['desc_en'] ?? '') : ($section['desc_ar'] ?? ''))),
                    'title_ar' => (string) ($section['title_ar'] ?? ''),
                ];
            })
            ->filter(fn (array $section) => filled($section['title']) || filled($section['description']))
            ->values()
            ->all();
    }

    /**
     * Ensure a single row exists for admin editing (migration normally seeds one).
     */
    public static function ensureExists(): self
    {
        $existing = static::query()->orderBy('id')->first();

        if ($existing) {
            return $existing;
        }

        return static::create([
            'title_ar' => 'سياسة الخصوصية',
            'title_en' => 'Privacy Policy',
            'sections' => [
                [
                    'title_ar' => 'حماية المعلومات',
                    'title_en' => 'Information Protection',
                    'desc_ar' => 'يمكنك تعديل أقسام سياسة الخصوصية من لوحة التحكم.',
                    'desc_en' => 'You can edit privacy policy sections from the admin dashboard.',
                ],
            ],
            'is_active' => true,
        ]);
    }
}
