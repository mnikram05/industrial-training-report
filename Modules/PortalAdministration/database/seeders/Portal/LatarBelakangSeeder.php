<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

use Modules\PortalAdministration\Support\PortalPublicMediaPaths;

class LatarBelakangSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('latar-belakang', [
            ['type' => 'hero', 'id' => 'lb_hero', 'data' => [
                'subtitle_ms' => 'LATAR BELAKANG ORGANISASI', 'subtitle_en' => 'ORGANISATION BACKGROUND',
                'title_ms'    => 'OPENSOFT TECHNOLOGIES SDN BHD', 'title_en' => 'OPENSOFT TECHNOLOGIES SDN BHD',
                'address'     => 'Nadi 15, 10A, Jln Diplomatik, Presint 15, 62050 Putrajaya, Wilayah Persekutuan Putrajaya.',
            ]],
            ['type' => 'cards', 'id' => 'lb_info', 'data' => [
                'layout' => 'horizontal',
                'items'  => [
                    ['display' => 'image', 'icon' => '', 'image' => PortalPublicMediaPaths::LOGO_OPENSOFT, 'label_ms' => 'Logo Syarikat', 'label_en' => 'Company Logo', 'value_ms' => 'Opensoft Technologies Sdn Bhd', 'value_en' => 'Opensoft Technologies Sdn Bhd'],
                    ['display' => 'image', 'icon' => '', 'image' => PortalPublicMediaPaths::LOKASI_OPENSOFT, 'label_ms' => 'Lokasi', 'label_en' => 'Location', 'value_ms' => 'Nadi 15, 10A, Jln Diplomatik, Presint 15, 62050 Putrajaya, Wilayah Persekutuan Putrajaya.', 'value_en' => 'Nadi 15, 10A, Jln Diplomatik, Presint 15, 62050 Putrajaya, Wilayah Persekutuan Putrajaya.'],
                    ['display' => 'emoji', 'icon' => '📅', 'image' => '', 'label_ms' => 'Ditubuhkan', 'label_en' => 'Established', 'value_ms' => '2010', 'value_en' => '2010'],
                    ['display' => 'emoji', 'icon' => '💼', 'image' => '', 'label_ms' => 'Industri', 'label_en' => 'Industry', 'value_ms' => 'Teknologi Maklumat & Komunikasi (ICT)', 'value_en' => 'Information & Communication Technology (ICT)'],
                ],
            ]],
            ['type' => 'text', 'id' => 'lb_bg', 'data' => [
                'icon'       => '🏢',
                'heading_ms' => 'Latar Belakang Syarikat', 'heading_en' => 'Company Background',
                'text_ms'    => 'Opensoft Technologies Sdn Bhd merupakan sebuah syarikat teknologi maklumat yang ditubuhkan pada tahun 2010. Syarikat ini berpusat di Kuala Lumpur dan menyediakan pelbagai perkhidmatan ICT termasuk pembangunan perisian, integrasi sistem, dan penyelesaian data raya. Dengan pengalaman lebih sedekad dalam industri, Opensoft Technologies telah berjaya menyampaikan penyelesaian teknologi kepada pelbagai agensi kerajaan dan swasta di seluruh Malaysia.',
                'text_en'    => 'Opensoft Technologies Sdn Bhd is an information technology company established in 2010. The company is headquartered in Kuala Lumpur and provides various ICT services including software development, system integration, and big data solutions. With over a decade of industry experience, Opensoft Technologies has successfully delivered technology solutions to various government and private agencies throughout Malaysia.',
            ]],
            ['type' => 'list', 'id' => 'lb_obj', 'data' => [
                'icon'       => '🚀',
                'heading_ms' => 'Objektif Strategik', 'heading_en' => 'Strategic Objectives',
                'items_ms'   => ['Menyediakan penyelesaian ICT yang inovatif dan berkualiti tinggi', 'Membangunkan sistem yang mesra pengguna dan berskala besar', 'Memastikan kepuasan pelanggan melalui perkhidmatan yang cemerlang', 'Melahirkan tenaga kerja ICT yang kompeten dan berdaya saing'],
                'items_en'   => ['Provide innovative and high-quality ICT solutions', 'Develop user-friendly and scalable systems', 'Ensure customer satisfaction through excellent service', 'Produce competent and competitive ICT workforce'],
            ]],
            ['type' => 'list', 'id' => 'lb_nilai', 'data' => ['icon' => '⭐', 'heading_ms' => 'Nilai Utama', 'heading_en' => 'Core Values', 'items_ms' => ['Integriti', 'Profesionalisme', 'Inovasi', 'Kerja Berpasukan'], 'items_en' => ['Integrity', 'Professionalism', 'Innovation', 'Teamwork']]],
            ['type' => 'list', 'id' => 'lb_komit', 'data' => ['icon' => '👤', 'heading_ms' => 'Komitmen Pelanggan', 'heading_en' => 'Customer Commitment', 'items_ms' => ['Penyampaian projek tepat masa', 'Kualiti perkhidmatan terjamin', 'Sokongan teknikal berterusan', 'Harga yang kompetitif'], 'items_en' => ['On-time project delivery', 'Guaranteed service quality', 'Continuous technical support', 'Competitive pricing']]],
            ['type' => 'list', 'id' => 'lb_warga', 'data' => ['icon' => '🖥️', 'heading_ms' => 'Warga Kerja', 'heading_en' => 'Workforce', 'items_ms' => ['Pembangun Perisian', 'Penganalisis Sistem', 'Pengurus Projek', 'Jurutera Data'], 'items_en' => ['Software Developers', 'System Analysts', 'Project Managers', 'Data Engineers']]],
            ['type' => 'table', 'id' => 'lb_jadual', 'data' => [
                'heading_ms' => 'Jadual Waktu Bekerja', 'heading_en' => 'Working Hours Schedule',
                'columns_ms' => ['Hari', 'Waktu Bekerja', 'Waktu Rehat'], 'columns_en' => ['Day', 'Working Hours', 'Break Time'],
                'rows_ms'    => [['col_0' => 'Isnin - Jumaat', 'col_1' => '8:30 AM - 5:30 PM', 'col_2' => '1:00 PM - 2:00 PM']],
                'rows_en'    => [['col_0' => 'Monday - Friday', 'col_1' => '8:30 AM - 5:30 PM', 'col_2' => '1:00 PM - 2:00 PM']],
            ]],
            ['type' => 'image', 'id' => 'lb_aktiviti', 'data' => [
                'image_path' => PortalPublicMediaPaths::PERNIAGAAN_TERAS,
                'caption_ms' => 'Aktiviti Utama Syarikat', 'caption_en' => 'Main Company Activities',
            ]],
            ['type' => 'cta', 'id' => 'lb_cta', 'data' => [
                'text_ms'        => 'Layari laman web rasmi Opensoft Technologies untuk maklumat lanjut.',
                'text_en'        => 'Visit the official Opensoft Technologies website for more information.',
                'button_text_ms' => 'Layari Laman Web', 'button_text_en' => 'Visit Website',
                'url'            => 'https://www.myopensoft.net/en',
            ]],
        ]);
    }
}
