<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('privacy_policies', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->json('sections');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();

        $sections = [
            [
                'title_ar' => 'حماية المعلومات',
                'title_en' => 'Information Protection',
                'desc_ar' => 'نحن نولي أهمية كبيرة لحماية معلوماتك الشخصية ونستخدم تقنيات أمان متقدمة لضمان سلامتها وعدم إساءة استخدامها.',
                'desc_en' => 'We take your privacy seriously and use advanced security technologies to protect your data.',
            ],
            [
                'title_ar' => 'الحساب الشخصي',
                'title_en' => 'User Account',
                'desc_ar' => 'يتطلب إنشاء حساب إدخال بيانات شخصية، وأنت مسؤول عن الحفاظ على سرية معلومات الدخول الخاصة بك.',
                'desc_en' => 'Creating an account requires personal data, and you are responsible for keeping your credentials secure.',
            ],
            [
                'title_ar' => 'التواصل الإلكتروني',
                'title_en' => 'Electronic Communication',
                'desc_ar' => 'باستخدامك الموقع، فإنك توافق على تلقي الإشعارات والرسائل المتعلقة بخدماتنا.',
                'desc_en' => 'By using our platform, you agree to receive communications related to our services.',
            ],
            [
                'title_ar' => 'التقييمات',
                'title_en' => 'Customer Reviews',
                'desc_ar' => 'يحق لنا استخدام التقييمات المقدمة من العملاء لأغراض تحسين الخدمة والتسويق.',
                'desc_en' => 'We may use customer reviews for marketing and service improvement purposes.',
            ],
        ];

        DB::table('privacy_policies')->insert([
            'title_ar' => 'سياسة الخصوصية',
            'title_en' => 'Privacy Policy',
            'sections' => json_encode($sections, JSON_UNESCAPED_UNICODE),
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('privacy_policies');
    }
};
