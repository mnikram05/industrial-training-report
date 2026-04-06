<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

use Modules\PortalAdministration\Models\PortalSetting;
use Modules\PortalAdministration\Support\PortalPublicMediaPaths;

class HeaderFooterSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $data = [
            'logo_path'      => PortalPublicMediaPaths::LOGO_SITE,
            'site_name_ms'   => 'POLITEKNIK SULTAN IDRIS SHAH',
            'site_name_en'   => 'POLITEKNIK SULTAN IDRIS SHAH',
            'footer_text_ms' => '© MUHAMMAD NOOR IKRAM BIN MAZLAN — 17DDT23F1119 — 2026 Laporan Latihan Industri — Diploma Teknologi Maklumat (Teknologi Digital)',
            'footer_text_en' => '© MUHAMMAD NOOR IKRAM BIN MAZLAN — 17DDT23F1119 — 2026 Industrial Training Report — Diploma in Information Technology (Digital Technology)',
            ...$this->defaultColors(),
        ];

        foreach ($data as $key => $value) {
            PortalSetting::setValue($key, $value, 'header-footer');
        }
    }
}
