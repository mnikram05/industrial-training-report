<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

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
                'text_ms'    => 'Dokumentasi bergambar aktiviti dan persekitaran semasa latihan industri. Susun atur mengikut contoh laporan; tukar kepada foto anda melalui Pentadbiran Portal → Tetapan halaman lampiran atau Media.',
                'text_en'    => 'Photo documentation of activities and surroundings during industrial training. Layout follows a typical report; replace with your own photos via Portal Administration → Lampiran page settings or Media.',
            ]],
            ['type' => 'cards', 'id' => 'lp_galeri', 'data' => [
                'layout' => 'gallery',
                'items'  => [
                    [
                        'display'  => 'image',
                        'icon'     => '',
                        'image'    => 'media/2026/03/Hr2cdTUy89BSx10ARvj91jcFPKBtkgDtY8nybFFe.jpg',
                        'label_ms' => '',
                        'label_en' => '',
                        'value_ms' => '',
                        'value_en' => '',
                    ],
                    [
                        'display'  => 'image',
                        'icon'     => '',
                        'image'    => 'media/2026/03/QUMc6Oxeksi48tguONAl2giNSYvhM5YGgo8yLOlU.jpg',
                        'label_ms' => '',
                        'label_en' => '',
                        'value_ms' => '',
                        'value_en' => '',
                    ],
                    [
                        'display'  => 'image',
                        'icon'     => '',
                        'image'    => 'media/2026/03/uYiapMLscFgsa0nBpg6R9u8tqxx7RFqSfPbp3B68.png',
                        'label_ms' => '',
                        'label_en' => '',
                        'value_ms' => '',
                        'value_en' => '',
                    ],
                    [
                        'display'  => 'image',
                        'icon'     => '',
                        'image'    => 'media/2026/03/UPloP9UcRm0jMNp5JyVOmR8blR1gVZ45Nk2BFgoW.png',
                        'label_ms' => '',
                        'label_en' => '',
                        'value_ms' => '',
                        'value_en' => '',
                    ],
                ],
            ]],
        ]);
    }
}
