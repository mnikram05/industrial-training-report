<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('portal_settings')) {
            return;
        }

        $page = 'cms';
        $now = now();

        $defaults = [
            // Light
            'color_header_bg' => '#0f172a',
            'color_hero_bg_from' => '#0f172a',
            'color_hero_bg_to' => '#1e293b',
            'color_accent' => '#f43f5e',
            'color_footer_bg' => '#0f172a',
            'color_body_bg' => '#f8fafc',
            'color_lang_active' => '#f43f5e',
            'color_card_bg' => '#ffffff',
            'color_nav_bg' => '#f43f5e',
            'color_text' => '#1f2937',
            // Dark
            'dark_header_bg' => '#020617',
            'dark_hero_bg_from' => '#020617',
            'dark_hero_bg_to' => '#0f172a',
            'dark_accent' => '#fb7185',
            'dark_footer_bg' => '#020617',
            'dark_body_bg' => '#0f172a',
            'dark_card_bg' => '#1e293b',
            'dark_text' => '#e2e8f0',
            'dark_nav_bg' => '#fb7185',
            'dark_lang_active' => '#fb7185',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('portal_settings')->updateOrInsert(
                ['page' => $page, 'key' => $key],
                ['value' => $value, 'created_at' => $now, 'updated_at' => $now],
            );
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('portal_settings')) {
            return;
        }

        $keys = [
            'color_header_bg',
            'color_hero_bg_from',
            'color_hero_bg_to',
            'color_accent',
            'color_footer_bg',
            'color_body_bg',
            'color_lang_active',
            'color_card_bg',
            'color_nav_bg',
            'color_text',
            'dark_header_bg',
            'dark_hero_bg_from',
            'dark_hero_bg_to',
            'dark_accent',
            'dark_footer_bg',
            'dark_body_bg',
            'dark_card_bg',
            'dark_text',
            'dark_nav_bg',
            'dark_lang_active',
        ];

        DB::table('portal_settings')
            ->where('page', 'cms')
            ->whereIn('key', $keys)
            ->delete();
    }
};

