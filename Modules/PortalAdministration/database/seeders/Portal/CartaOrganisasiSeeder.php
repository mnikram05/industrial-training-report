<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

use Modules\PortalAdministration\Support\PortalPublicMediaPaths;

class CartaOrganisasiSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('carta-organisasi', [
            ['type' => 'hero', 'id' => 'co_hero', 'data' => ['subtitle_ms' => 'PENGENALAN', 'subtitle_en' => 'INTRODUCTION', 'title_ms' => 'CARTA ORGANISASI', 'title_en' => 'ORGANIZATION CHART']],
            ['type' => 'image', 'id' => 'co_img', 'data' => [
                'image_path' => PortalPublicMediaPaths::CARTA_ORGANISASI,
                'caption_ms' => 'Rajah 1.4: Struktur Organisasi Opensoft Technologies Sdn Bhd',
                'caption_en' => 'Figure 1.4: Organization Structure of Opensoft Technologies Sdn Bhd',
            ]],
        ]);
    }
}
