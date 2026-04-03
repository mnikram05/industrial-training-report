<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

use Illuminate\Database\Seeder;
use Modules\PortalAdministration\Models\PortalSetting;

/**
 * Tambah color_hero_glow / dark_hero_glow untuk pangkalan lama (sebelum kunci ini wujud).
 * Pasang baru: nilai sudah dalam {@see PortalPageSeeder::defaultColors()}.
 */
class HeroGlowSettingsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['header-footer', 'home'] as $page) {
            $this->seedGlowIfMissing($page);
        }
    }

    private function seedGlowIfMissing(string $page): void
    {
        $lightAccent = PortalSetting::getValue('color_accent', '#e94560', $page);
        $darkAccent = PortalSetting::getValue('dark_accent', '#e94560', $page);

        if (! $this->pageHasKey($page, 'color_hero_glow')) {
            PortalSetting::setValue('color_hero_glow', $lightAccent, $page);
        }

        if (! $this->pageHasKey($page, 'dark_hero_glow')) {
            PortalSetting::setValue('dark_hero_glow', $darkAccent, $page);
        }
    }

    private function pageHasKey(string $page, string $key): bool
    {
        return PortalSetting::query()
            ->where('page', $page)
            ->where('key', $key)
            ->exists();
    }
}
