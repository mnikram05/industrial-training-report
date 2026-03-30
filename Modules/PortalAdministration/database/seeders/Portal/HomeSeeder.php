<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class HomeSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage( 'home', [
            ['type' => 'hero', 'id' => 'home_hero', 'data' => [
                'institution_ms' => 'POLITEKNIK SULTAN IDRIS SHAH - 2026',
                'institution_en' => 'POLITEKNIK SULTAN IDRIS SHAH - 2026',
                'title_ms'       => 'LAPORAN AKHIR LATIHAN INDUSTRI',
                'title_en'       => 'INDUSTRIAL TRAINING FINAL REPORT',
                'subtitle2_ms'   => 'DIPLOMA TEKNOLOGI MAKLUMAT (TEKNOLOGI DIGITAL)',
                'subtitle2_en'   => 'DIPLOMA IN INFORMATION TECHNOLOGY (DIGITAL TECHNOLOGY)',
                'session_ms'     => 'Sesi II 2025 / 2026  |  12 Januari 2026 – 29 Mei 2026',
                'session_en'     => 'Session II 2025 / 2026  |  12 January 2026 – 29 May 2026',
            ]],
            ['type' => 'cards', 'id' => 'home_cards', 'data' => [
                'layout' => 'centered',
                'items'  => [
                    ['display' => 'both', 'icon' => '👤', 'image' => 'media/2026/03/Hr2cdTUy89BSx10ARvj91jcFPKBtkgDtY8nybFFe.jpg', 'label_ms' => 'Nama', 'label_en' => 'Name', 'value_ms' => 'Muhammad Noor Ikram Bin Mazlan', 'value_en' => 'Muhammad Noor Ikram Bin Mazlan'],
                    ['display' => 'both', 'icon' => '🏢', 'image' => 'media/2026/03/QUMc6Oxeksi48tguONAl2giNSYvhM5YGgo8yLOlU.jpg', 'label_ms' => 'Syarikat', 'label_en' => 'Company', 'value_ms' => 'Opensoft Technologies Sdn Bhd', 'value_en' => 'Opensoft Technologies Sdn Bhd'],
                    ['display' => 'emoji', 'icon' => '📅', 'image' => '', 'label_ms' => 'Tempoh', 'label_en' => 'Duration', 'value_ms' => '12 Jan – 29 Mei 2026', 'value_en' => '12 Jan – 29 May 2026'],
                    ['display' => 'emoji', 'icon' => '🎓', 'image' => '', 'label_ms' => 'Program', 'label_en' => 'Programme', 'value_ms' => 'Diploma Teknologi Maklumat (Teknologi Digital)', 'value_en' => 'Diploma in Information Technology (Digital Technology)'],
                ],
            ]],
            ['type' => 'quick-nav', 'id' => 'home_nav', 'data' => [
                'heading_ms' => 'Navigasi Cepat', 'heading_en' => 'Quick Navigation',
                'items'      => [
                    ['icon' => '👤', 'title_ms' => 'Pengenalan Diri', 'title_en' => 'Self Introduction', 'subtitle_ms' => 'Maklumat pelatih', 'subtitle_en' => 'Trainee info', 'url' => '/portal/pengenalan-diri'],
                    ['icon' => '📅', 'title_ms' => 'Ringkasan Aktiviti', 'title_en' => 'Activity Summary', 'subtitle_ms' => 'Log Mingguan LI', 'subtitle_en' => 'Weekly LI Log', 'url' => '/portal/ringkasan-aktiviti'],
                    ['icon' => '📄', 'title_ms' => 'Laporan Teknikal', 'title_en' => 'Technical Report', 'subtitle_ms' => 'Tugasan & projek', 'subtitle_en' => 'Tasks & projects', 'url' => '/portal/laporan-teknikal'],
                ],
            ]],
        ] );
    }
}
