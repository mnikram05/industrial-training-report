<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class FungsiBahagianSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('fungsi-bahagian', [
            ['type' => 'hero', 'id' => 'fb_hero', 'data' => ['subtitle_ms' => 'PENGENALAN', 'subtitle_en' => 'INTRODUCTION', 'title_ms' => 'FUNGSI BAHAGIAN', 'title_en' => 'DEPARTMENT FUNCTIONS']],
            ['type' => 'grid-cards', 'id' => 'fb_cards', 'data' => [
                'heading_ms' => 'Fungsi Bahagian', 'heading_en' => 'Department Functions',
                'items'      => [
                    ['icon' => '⚙️', 'title_ms' => 'Pembangunan Sistem & Laman Web', 'title_en' => 'System & Web Development', 'desc_ms' => 'Membangunkan dan mengintegrasikan sistem serta laman web untuk keperluan pelanggan.', 'desc_en' => 'Develop and integrate systems and websites for customer needs.', 'bullets_ms' => ['Membangunkan sistem pengurusan maklumat.', 'Membangunkan laman web korporat dan portal.', 'Menyelenggara dan mengemas kini sistem sedia ada.'], 'bullets_en' => ['Develop information management systems.', 'Build corporate websites and portals.', 'Maintain and update existing systems.']],
                    ['icon' => '⚙️', 'title_ms' => 'Integrasi Sistem', 'title_en' => 'System Integration', 'desc_ms' => 'Memastikan sistem-sistem yang berbeza dapat berfungsi secara bersepadu.', 'desc_en' => 'Ensure different systems can function in an integrated manner.', 'bullets_ms' => ['Mengintegrasikan sistem dalaman dengan platform pihak ketiga.', 'Membangunkan API untuk menghubungkan pelbagai sistem.', 'Menguji dan memastikan integrasi sistem berjalan lancar.'], 'bullets_en' => ['Integrate internal systems with third-party platforms.', 'Develop APIs to connect various systems.', 'Test and ensure system integration runs smoothly.']],
                    ['icon' => '📱', 'title_ms' => 'Aplikasi & Integrasi Mudah Alih', 'title_en' => 'Mobile Apps & Integration', 'desc_ms' => 'Membangunkan aplikasi mudah alih dan mengintegrasikannya dengan sistem sedia ada.', 'desc_en' => 'Develop mobile applications and integrate them with existing systems.', 'bullets_ms' => ['Membangunkan aplikasi mudah alih iOS dan Android.', 'Mengintegrasikan aplikasi mudah alih dengan sistem pelayan.', 'Menguji dan memastikan prestasi aplikasi mudah alih.'], 'bullets_en' => ['Develop iOS and Android mobile applications.', 'Integrate mobile apps with server systems.', 'Test and ensure mobile app performance.']],
                    ['icon' => '🖥️', 'title_ms' => 'Bekalan & Sokongan Perkakasan IT', 'title_en' => 'IT Hardware Supply & Support', 'desc_ms' => 'Menyediakan perkakasan IT dan sokongan teknikal kepada pelanggan.', 'desc_en' => 'Provide IT hardware and technical support to customers.', 'bullets_ms' => ['Membekalkan perkakasan IT kepada pelanggan.', 'Menyediakan sokongan teknikal dan penyelenggaraan.', 'Memastikan infrastruktur IT pelanggan berfungsi dengan baik.'], 'bullets_en' => ['Supply IT hardware to customers.', 'Provide technical support and maintenance.', 'Ensure customer IT infrastructure functions properly.']],
                    ['icon' => '📋', 'title_ms' => 'Sokongan Pengurusan Projek', 'title_en' => 'Project Management Support', 'desc_ms' => 'Memastikan projek dilaksanakan mengikut skop, masa dan bajet yang ditetapkan.', 'desc_en' => 'Ensure projects are executed within scope, time and budget.', 'bullets_ms' => ['Merancang dan memantau pelaksanaan projek.', 'Menguruskan komunikasi antara pasukan dan pelanggan.', 'Menyediakan laporan kemajuan projek secara berkala.'], 'bullets_en' => ['Plan and monitor project execution.', 'Manage communication between teams and customers.', 'Provide regular project progress reports.']],
                ],
            ]],
        ]);
    }
}
