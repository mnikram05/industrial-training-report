<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

use Illuminate\Database\Seeder;
use Modules\PortalAdministration\Models\PortalSetting;

abstract class PortalPageSeeder extends Seeder
{
    /**
     * @return array<string, string>
     */
    protected function defaultColors(): array
    {
        return [
            'color_header_bg'    => '#1a1a2e',
            'color_hero_bg_from' => '#0f0f1a',
            'color_hero_bg_to'   => '#1a1a2e',
            'color_accent'       => '#e94560',
            'color_footer_bg'    => '#1a1a2e',
            'color_body_bg'      => '#f5f6fa',
            'color_lang_active'  => '#e94560',
            'color_card_bg'      => '#ffffff',
            'color_nav_bg'       => '#e94560',
            'color_text'         => '#2d3436',
            'dark_header_bg'     => '#0a0a15',
            'dark_hero_bg_from'  => '#0a0a15',
            'dark_hero_bg_to'    => '#0f0f1a',
            'dark_body_bg'       => '#0f0f1a',
            'dark_card_bg'       => '#1a1a2e',
            'dark_nav_bg'        => '#e94560',
            'dark_text'          => '#f5f6fa',
            'dark_footer_bg'     => '#0a0a15',
            'dark_accent'        => '#e94560',
        ];
    }

    protected function seedBlockPage(string $page, array $blocks): void
    {
        PortalSetting::setBlocks($blocks, $page);

        foreach ($this->defaultColors() as $key => $value) {
            PortalSetting::setValue($key, $value, $page);
        }
    }
}
