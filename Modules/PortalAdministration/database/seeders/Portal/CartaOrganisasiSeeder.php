<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class CartaOrganisasiSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('carta-organisasi', [
            ['type' => 'hero', 'id' => 'co_hero', 'data' => ['subtitle_ms' => 'PENGENALAN', 'subtitle_en' => 'INTRODUCTION', 'title_ms' => 'CARTA ORGANISASI', 'title_en' => 'ORGANIZATION CHART']],
            ['type' => 'image', 'id' => 'co_img', 'data' => [
                'image_path' => 'media/2026/03/jcFSrBNohgu3gNF4TgjVdtDXhFxktWTf6Z9SXw73.jpg',
                'caption_ms' => 'Rajah 1.4: Struktur Organisasi Opensoft Technologies Sdn Bhd',
                'caption_en' => 'Figure 1.4: Organization Structure of Opensoft Technologies Sdn Bhd',
            ]],
        ]);
    }
}
