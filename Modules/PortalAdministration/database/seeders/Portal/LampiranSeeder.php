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
                'heading_ms' => 'Senarai Lampiran',
                'heading_en' => 'List of Appendices',
                'text_ms'    => 'Bahagian ini mengandungi dokumen sokongan dan rujukan tambahan yang berkaitan dengan latihan industri saya di Opensoft Technologies Sdn Bhd. Lampiran-lampiran ini merupakan bukti dan rekod rasmi bagi aktiviti yang telah dijalankan sepanjang tempoh latihan.',
                'text_en'    => 'This section contains supporting documents and additional references related to my industrial training at Opensoft Technologies Sdn Bhd. These appendices serve as evidence and official records of activities carried out throughout the training period.',
            ]],
            ['type' => 'table', 'id' => 'lp_senarai', 'data' => [
                'heading_ms' => 'Dokumen Lampiran',
                'heading_en' => 'Appendix Documents',
                'columns_ms' => ['Bil.', 'Perkara', 'Keterangan'],
                'columns_en' => ['No.', 'Item', 'Description'],
                'rows'       => [
                    ['col_0' => '1', 'col_1' => 'Surat Pengesahan Latihan Industri / Industrial Training Confirmation Letter', 'col_2' => 'Surat pengesahan penerimaan pelajar oleh syarikat / Student acceptance confirmation letter from company'],
                    ['col_0' => '2', 'col_1' => 'Borang Penilaian Penyelia / Supervisor Evaluation Form', 'col_2' => 'Borang penilaian prestasi pelajar oleh penyelia industri / Student performance evaluation form by industry supervisor'],
                    ['col_0' => '3', 'col_1' => 'Rekod Kehadiran / Attendance Record', 'col_2' => 'Rekod kehadiran harian sepanjang tempoh latihan / Daily attendance record throughout training period'],
                    ['col_0' => '4', 'col_1' => 'Sijil Latihan Industri / Industrial Training Certificate', 'col_2' => 'Sijil pengesahan tamat latihan industri / Certificate of completion for industrial training'],
                    ['col_0' => '5', 'col_1' => 'Gambar Aktiviti / Activity Photos', 'col_2' => 'Dokumentasi bergambar aktiviti sepanjang latihan / Photo documentation of activities during training'],
                ],
            ]],
            ['type' => 'grid-cards', 'id' => 'lp_rujukan', 'data' => [
                'heading_ms' => 'Rujukan Teknikal',
                'heading_en' => 'Technical References',
                'items'      => [
                    ['icon' => '📘', 'title_ms' => 'Dokumentasi Laravel', 'title_en' => 'Laravel Documentation', 'desc_ms' => 'Rujukan rasmi kerangka kerja Laravel untuk pembangunan sistem.', 'desc_en' => 'Official Laravel framework reference for system development.'],
                    ['icon' => '📗', 'title_ms' => 'Dokumentasi Tailwind CSS', 'title_en' => 'Tailwind CSS Documentation', 'desc_ms' => 'Rujukan rasmi Tailwind CSS untuk reka bentuk antara muka.', 'desc_en' => 'Official Tailwind CSS reference for interface design.'],
                    ['icon' => '📙', 'title_ms' => 'Dokumentasi MySQL', 'title_en' => 'MySQL Documentation', 'desc_ms' => 'Rujukan rasmi MySQL untuk pengurusan pangkalan data.', 'desc_en' => 'Official MySQL reference for database management.'],
                    ['icon' => '📕', 'title_ms' => 'Dokumentasi Git', 'title_en' => 'Git Documentation', 'desc_ms' => 'Rujukan rasmi Git untuk kawalan versi kod sumber.', 'desc_en' => 'Official Git reference for source code version control.'],
                ],
            ]],
        ]);
    }
}
