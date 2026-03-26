<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class VisiMisiSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('visi-misi', [
            ['type' => 'hero', 'id' => 'vm_hero', 'data' => ['subtitle_ms' => 'PENGENALAN', 'subtitle_en' => 'INTRODUCTION', 'title_ms' => 'VISI & MISI', 'title_en' => 'VISION & MISSION']],
            ['type' => 'two-column-cards', 'id' => 'vm_cards', 'data' => [
                'cards' => [
                    ['icon' => '👁️', 'title_ms' => 'Visi Kami', 'title_en' => 'Our Vision', 'items_ms' => ['Menjadi rakan penyelesaian perniagaan IT yang diutamakan.'], 'items_en' => ['To be the preferred IT business solution partner.']],
                    ['icon' => '🚀', 'title_ms' => 'Misi Kami', 'title_en' => 'Our Mission', 'items_ms' => ['Menyampaikan jangkaan pelanggan melalui penyelesaian IT yang cemerlang dan inovatif serta penglibatan pelanggan.'], 'items_en' => ['Deliver customer expectations through excellent and innovative IT solutions and customer engagement.']],
                ],
            ]],
        ]);
    }
}
