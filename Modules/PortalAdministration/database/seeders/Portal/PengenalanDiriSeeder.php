<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class PengenalanDiriSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('pengenalan-diri', [
            ['type' => 'hero', 'id' => 'peng_hero', 'data' => [
                'title_ms' => 'PENGENALAN DIRI',
                'title_en' => 'ABOUT ME',
            ]],
            ['type' => 'profile-card', 'id' => 'peng_profile', 'data' => [
                'photo_path'   => 'media/2026/03/Hr2cdTUy89BSx10ARvj91jcFPKBtkgDtY8nybFFe.jpg',
                'nama'         => 'Muhammad Noor Ikram Bin Mazlan',
                'no_pelajar'   => '17DDT23F1119',
                'program'      => 'Diploma Teknologi Maklumat (Teknologi Digital)',
                'program_ms'   => 'Diploma Teknologi Maklumat (Teknologi Digital)',
                'program_en'   => 'Diploma in Information Technology (Digital Technology)',
                'sesi_latihan' => 'Sesi II 2025 / 2026',
                'tempoh_li'    => '12 Januari 2026 – 29 Mei 2026',
                'tarikh_lahir' => '10 Januari 2005',
                'telefon'      => '016-2005947',
                'email'        => 'mnikram2005@gmail.com',
                'alamat'       => 'No 28, Jalan Meranti 7, Saujana Utama 2, Sungai Buloh, Selangor',
            ]],
        ]);
    }
}
