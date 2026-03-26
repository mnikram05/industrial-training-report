<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class ObjektifOrganisasiSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('objektif-organisasi', [
            ['type' => 'hero', 'id' => 'obj_hero', 'data' => ['subtitle_ms' => 'PENGENALAN', 'subtitle_en' => 'INTRODUCTION', 'title_ms' => 'OBJEKTIF ORGANISASI', 'title_en' => 'ORGANISATION OBJECTIVES']],
            ['type' => 'grid-cards', 'id' => 'obj_cards', 'data' => [
                'heading_ms' => 'Objektif Organisasi', 'heading_en' => 'Organisation Objectives',
                'items'      => [
                    ['icon' => '⭐', 'title_ms' => 'Objektif 1', 'title_en' => 'Objective 1', 'desc_ms' => 'Menyediakan penyelesaian perisian berkualiti tinggi kepada pelanggan.', 'desc_en' => 'Provide high-quality software solutions to customers.'],
                    ['icon' => '🏆', 'title_ms' => 'Objektif 2', 'title_en' => 'Objective 2', 'desc_ms' => 'Membangunkan produk teknologi yang inovatif dan berdaya saing.', 'desc_en' => 'Develop innovative and competitive technology products.'],
                    ['icon' => '📈', 'title_ms' => 'Objektif 3', 'title_en' => 'Objective 3', 'desc_ms' => 'Meningkatkan kepuasan pelanggan melalui perkhidmatan yang cemerlang.', 'desc_en' => 'Improve customer satisfaction through excellent service.'],
                ],
            ]],
        ]);
    }
}
