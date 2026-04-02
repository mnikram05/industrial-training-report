<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

use Illuminate\Database\Seeder;
use Modules\PortalAdministration\Models\PortalSetting;

class CmsSettingSeeder extends Seeder
{
    public function run(): void
    {
        $page = 'cms';

        // Defaults aligned with App\Support\PortalTheme::DEFAULTS.
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
            PortalSetting::setValue($key, $value, $page);
        }
    }
}

