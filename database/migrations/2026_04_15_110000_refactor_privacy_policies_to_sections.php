<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('privacy_policies')) {
            return;
        }

        if (! Schema::hasColumn('privacy_policies', 'sections')) {
            Schema::table('privacy_policies', function (Blueprint $table) {
                $table->json('sections')->nullable()->after('title_en');
            });
        }

        if (Schema::hasColumn('privacy_policies', 'content_ar') && Schema::hasColumn('privacy_policies', 'content_en')) {
            $rows = DB::table('privacy_policies')
                ->select('id', 'content_ar', 'content_en')
                ->get();

            foreach ($rows as $row) {
                $sections = [
                    [
                        'title_ar' => 'حماية المعلومات',
                        'title_en' => 'Information Protection',
                        'desc_ar' => strip_tags((string) $row->content_ar),
                        'desc_en' => strip_tags((string) $row->content_en),
                    ],
                ];

                DB::table('privacy_policies')
                    ->where('id', $row->id)
                    ->update(['sections' => json_encode($sections, JSON_UNESCAPED_UNICODE)]);
            }

            Schema::table('privacy_policies', function (Blueprint $table) {
                $table->dropColumn(['content_ar', 'content_en']);
            });
        }

        DB::table('privacy_policies')
            ->whereNull('sections')
            ->orWhere('sections', '')
            ->update([
                'sections' => json_encode([
                    [
                        'title_ar' => 'حماية المعلومات',
                        'title_en' => 'Information Protection',
                        'desc_ar' => 'يمكنك تعديل أقسام سياسة الخصوصية من لوحة التحكم.',
                        'desc_en' => 'You can edit privacy policy sections from the admin dashboard.',
                    ],
                ], JSON_UNESCAPED_UNICODE),
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('privacy_policies')) {
            return;
        }

        if (! Schema::hasColumn('privacy_policies', 'content_ar')) {
            Schema::table('privacy_policies', function (Blueprint $table) {
                $table->longText('content_ar')->nullable()->after('title_en');
                $table->longText('content_en')->nullable()->after('content_ar');
            });
        }

        if (Schema::hasColumn('privacy_policies', 'sections')) {
            Schema::table('privacy_policies', function (Blueprint $table) {
                $table->dropColumn('sections');
            });
        }
    }
};
