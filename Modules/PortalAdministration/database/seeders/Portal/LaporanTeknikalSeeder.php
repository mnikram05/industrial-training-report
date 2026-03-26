<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class LaporanTeknikalSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('laporan-teknikal', [
            ['type' => 'hero', 'id' => 'lt_hero', 'data' => [
                'subtitle_ms' => 'DOKUMENTASI',
                'subtitle_en' => 'DOCUMENTATION',
                'title_ms'    => 'LAPORAN TEKNIKAL',
                'title_en'    => 'TECHNICAL REPORT',
            ]],
            ['type' => 'text', 'id' => 'lt_pengenalan', 'data' => [
                'icon'       => '📄',
                'heading_ms' => 'Pengenalan Projek',
                'heading_en' => 'Project Introduction',
                'text_ms'    => "Sepanjang tempoh latihan industri di Opensoft Technologies Sdn Bhd, saya telah ditugaskan untuk membangunkan beberapa modul sistem menggunakan kerangka kerja Laravel. Laporan teknikal ini mendokumentasikan projek-projek utama yang telah saya siapkan, termasuk pendekatan teknikal, teknologi yang digunakan, serta cabaran yang dihadapi dan penyelesaiannya.\n\nProjek utama yang dipertanggungjawabkan kepada saya melibatkan pembangunan sistem pengurusan maklumat bersepadu yang merangkumi modul pentadbiran, pengurusan pengguna, dan sistem pelaporan. Sistem ini dibangunkan menggunakan seni bina MVC (Model-View-Controller) dengan Laravel sebagai kerangka kerja utama.",
                'text_en'    => "Throughout my industrial training period at Opensoft Technologies Sdn Bhd, I was assigned to develop several system modules using the Laravel framework. This technical report documents the main projects I completed, including the technical approach, technologies used, and challenges faced along with their solutions.\n\nThe main project assigned to me involved developing an integrated information management system comprising administration modules, user management, and a reporting system. The system was built using MVC (Model-View-Controller) architecture with Laravel as the main framework.",
            ]],
            ['type' => 'grid-cards', 'id' => 'lt_teknologi', 'data' => [
                'heading_ms' => 'Teknologi Yang Digunakan',
                'heading_en' => 'Technologies Used',
                'items'      => [
                    ['icon' => '🔧', 'title_ms' => 'Bahasa Pengaturcaraan', 'title_en' => 'Programming Languages', 'desc_ms' => 'Bahasa utama yang digunakan dalam pembangunan sistem.', 'desc_en' => 'Main languages used in system development.', 'bullets_ms' => ['PHP 8 — Bahasa pelayan utama', 'JavaScript — Interaksi bahagian hadapan', 'SQL — Pengurusan pangkalan data', 'HTML & CSS — Struktur dan gaya antara muka'], 'bullets_en' => ['PHP 8 — Main server-side language', 'JavaScript — Frontend interactions', 'SQL — Database management', 'HTML & CSS — Interface structure and styling']],
                    ['icon' => '⚙️', 'title_ms' => 'Kerangka Kerja & Alatan', 'title_en' => 'Frameworks & Tools', 'desc_ms' => 'Kerangka kerja dan alatan pembangunan yang digunakan.', 'desc_en' => 'Development frameworks and tools used.', 'bullets_ms' => ['Laravel 12 — Kerangka kerja PHP utama', 'Tailwind CSS — Kerangka kerja CSS utiliti', 'Alpine.js — Kerangka kerja JavaScript ringan', 'Git — Kawalan versi kod sumber'], 'bullets_en' => ['Laravel 12 — Main PHP framework', 'Tailwind CSS — Utility CSS framework', 'Alpine.js — Lightweight JavaScript framework', 'Git — Source code version control']],
                    ['icon' => '🖥️', 'title_ms' => 'Perisian Pembangunan', 'title_en' => 'Development Software', 'desc_ms' => 'Perisian yang digunakan sepanjang pembangunan.', 'desc_en' => 'Software used throughout development.', 'bullets_ms' => ['VS Code — Editor kod sumber', 'Laragon — Pelayan pembangunan tempatan', 'SQLyog — Pengurusan pangkalan data MySQL', 'Postman — Pengujian API'], 'bullets_en' => ['VS Code — Source code editor', 'Laragon — Local development server', 'SQLyog — MySQL database management', 'Postman — API testing']],
                ],
            ]],
            ['type' => 'text', 'id' => 'lt_skop', 'data' => [
                'heading_ms' => 'Skop Tugasan',
                'heading_en' => 'Scope of Work',
                'text_ms'    => "Skop tugasan yang diberikan merangkumi beberapa bidang utama:\n\n1. Pembangunan Modul Pentadbir (Admin Module) — Membangunkan antara muka pentadbiran untuk pengurusan data induk, tetapan sistem, dan kawalan akses pengguna.\n\n2. Pengurusan Pangkalan Data — Mereka bentuk dan mengoptimumkan struktur pangkalan data menggunakan migrasi Laravel dan Eloquent ORM.\n\n3. Kemas Kini Keselamatan — Mengenal pasti dan menangani kerentanan sistem termasuk pengesahan input, perlindungan CSRF, dan kawalan akses berasaskan peranan.\n\n4. Dokumentasi Teknikal — Menyediakan manual pengguna dan dokumentasi teknikal untuk sistem yang dibangunkan.\n\n5. Pengujian Sistem — Melaksanakan pengujian unit dan pengujian ciri untuk memastikan kualiti kod dan kefungsian sistem.",
                'text_en'    => "The scope of work assigned covers several key areas:\n\n1. Admin Module Development — Building administration interfaces for master data management, system settings, and user access control.\n\n2. Database Management — Designing and optimising database structures using Laravel migrations and Eloquent ORM.\n\n3. Security Updates — Identifying and addressing system vulnerabilities including input validation, CSRF protection, and role-based access control.\n\n4. Technical Documentation — Preparing user manuals and technical documentation for developed systems.\n\n5. System Testing — Performing unit and feature testing to ensure code quality and system functionality.",
            ]],
            ['type' => 'text', 'id' => 'lt_cabaran', 'data' => [
                'heading_ms' => 'Cabaran & Penyelesaian',
                'heading_en' => 'Challenges & Solutions',
                'text_ms'    => "Sepanjang tempoh latihan, beberapa cabaran teknikal telah dihadapi dan diselesaikan:\n\n• Masalah N+1 Query — Diselesaikan dengan menggunakan eager loading pada model Eloquent untuk mengoptimumkan pertanyaan pangkalan data.\n\n• Pengurusan Versi Kod — Belajar menggunakan Git branching strategy untuk menguruskan perubahan kod secara sistematik dan mengelakkan konflik.\n\n• Keserasian Versi — Menangani isu keserasian antara pakej Laravel yang berbeza versi dengan merujuk dokumentasi rasmi dan komuniti.\n\n• Prestasi Sistem — Mengoptimumkan masa muat halaman dengan melaksanakan caching, lazy loading imej, dan minifikasi aset.",
                'text_en'    => "Throughout the training period, several technical challenges were faced and resolved:\n\n• N+1 Query Problem — Resolved by using eager loading on Eloquent models to optimise database queries.\n\n• Code Version Management — Learned to use Git branching strategy to manage code changes systematically and avoid conflicts.\n\n• Version Compatibility — Addressed compatibility issues between different Laravel package versions by referring to official documentation and community resources.\n\n• System Performance — Optimised page load times by implementing caching, lazy loading images, and asset minification.",
            ]],
            ['type' => 'cta', 'id' => 'lt_cta', 'data' => [
                'text_ms'        => 'Rujuk ringkasan aktiviti untuk butiran tugasan mingguan sepanjang latihan industri.',
                'text_en'        => 'Refer to the activity summary for weekly task details throughout the industrial training.',
                'button_text_ms' => 'Lihat Ringkasan Aktiviti',
                'button_text_en' => 'View Activity Summary',
                'url'            => '/portal/ringkasan-aktiviti',
            ]],
        ]);
    }
}
