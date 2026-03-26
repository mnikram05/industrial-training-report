<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class HalatujuOrganisasiSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('halatuju-organisasi', [
            ['type' => 'hero', 'id' => 'ht_hero', 'data' => ['subtitle_ms' => 'PENGENALAN', 'subtitle_en' => 'INTRODUCTION', 'title_ms' => 'HALATUJU ORGANISASI', 'title_en' => 'ORGANISATION DIRECTION']],
            ['type' => 'grid-cards', 'id' => 'ht_cards', 'data' => [
                'heading_ms' => 'Halatuju Organisasi', 'heading_en' => 'Organisation Direction',
                'items'      => [
                    ['icon' => '🚩', 'title_ms' => 'Inovasi Berterusan', 'title_en' => 'Continuous Innovation', 'desc_ms' => 'Fokus kepada inovasi dan penambahbaikan berterusan dalam setiap penyelesaian IT.', 'desc_en' => 'Focus on continuous innovation and improvement in every IT solution.'],
                    ['icon' => '⬆️', 'title_ms' => 'Penyelesaian Bernilai', 'title_en' => 'Valuable Solutions', 'desc_ms' => 'Menyediakan penyelesaian IT yang bernilai dan lestari kepada pelanggan.', 'desc_en' => 'Provide valuable and sustainable IT solutions to customers.'],
                    ['icon' => '💡', 'title_ms' => 'Penyelesaian Tersuai', 'title_en' => 'Customised Solutions', 'desc_ms' => 'Membangunkan penyelesaian IT yang disesuaikan mengikut keperluan spesifik pelanggan.', 'desc_en' => 'Develop IT solutions customised to specific customer needs.'],
                    ['icon' => '👥', 'title_ms' => 'Penglibatan Pelanggan', 'title_en' => 'Customer Engagement', 'desc_ms' => 'Memastikan penglibatan pelanggan yang aktif sepanjang tempoh pembangunan projek.', 'desc_en' => 'Ensure active customer engagement throughout the project development period.'],
                ],
            ]],
        ]);
    }
}
