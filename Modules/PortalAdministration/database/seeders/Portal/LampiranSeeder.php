<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

use Modules\PortalAdministration\Support\PortalPublicMediaPaths;

class LampiranSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('lampiran', [
            ['type' => 'hero', 'id' => 'lp_hero', 'data' => [
                'title_ms' => 'LAMPIRAN',
                'title_en' => 'APPENDICES',
            ]],
            ['type' => 'text', 'id' => 'lp_pengenalan', 'data' => [
                'icon'       => '📎',
                'heading_ms' => 'Pengenalan',
                'heading_en' => 'Introduction',
                'text_ms'    => 'Bahagian ini menyenaraikan dokumen sokongan latihan industri serta rujukan dalam talian yang digunakan semasa pembinaan sistem laporan digital kueh-pelita. Gambar lampiran merakam aktiviti dan persekitaran semasa latihan di Opensoft Technologies Sdn Bhd.',
                'text_en'    => 'This section lists industrial training supporting documents and online references used while building the kueh-pelita digital report system. Appendix photos document activities and the environment during training at Opensoft Technologies Sdn Bhd.',
            ]],
            ['type' => 'reference-links', 'id' => 'lp_rujukan', 'data' => [
                'icon'       => '🔗',
                'heading_ms' => 'RUJUKAN',
                'heading_en' => 'REFERENCES',
                'items'      => [
                    [
                        'label_ms' => 'Dokumentasi Laravel',
                        'label_en' => 'Laravel Documentation',
                        'url'      => 'https://laravel.com/docs',
                    ],
                    [
                        'label_ms' => 'Dokumentasi Tailwind CSS',
                        'label_en' => 'Tailwind CSS Documentation',
                        'url'      => 'https://tailwindcss.com/docs',
                    ],
                    [
                        'label_ms' => 'Politeknik Sultan Idris Shah (PSIS) — portal rasmi',
                        'label_en' => 'Politeknik Sultan Idris Shah (PSIS) — official portal',
                        'url'      => 'https://psis.mypolycc.edu.my/',
                    ],
                    [
                        'label_ms' => 'Git — dokumentasi kawalan versi',
                        'label_en' => 'Git — version control documentation',
                        'url'      => 'https://git-scm.com/doc',
                    ],
                ],
            ]],
            ['type' => 'text', 'id' => 'lp_galeri_intro', 'data' => [
                'icon'       => '📷',
                'heading_ms' => 'Gambar lampiran',
                'heading_en' => 'Photo appendices',
                'text_ms'    => 'Gambar-gambar berikut merupakan dokumentasi visual aktiviti harian, ruang kerja, dan persekitaran semasa latihan industri di Opensoft Technologies Sdn Bhd.',
                'text_en'    => 'The photographs below provide visual documentation of daily tasks, the workspace, and the environment during industrial training at Opensoft Technologies Sdn Bhd.',
            ]],
            ['type' => 'cards', 'id' => 'lp_galeri', 'data' => [
                'layout' => 'gallery',
                'items'  => [
                    [
                        'display'  => 'image',
                        'icon'     => '',
                        'image'    => PortalPublicMediaPaths::LAMPIRAN_MESYUARAT_SWCORP,
                        'label_ms' => 'Mesyuarat dengan pembangun Swcorp',
                        'label_en' => 'Meeting with Swcorp developers',
                        'value_ms' => 'Sesi penyelarasan projek secara bersemuka untuk membincangkan keperluan teknikal sistem dan aliran kerja bersama pihak pembangun pelanggan.',
                        'value_en' => 'In-person project coordination session to discuss system technical requirements and workflows with the client development team.',
                    ],
                ],
            ]],
        ]);
    }
}
