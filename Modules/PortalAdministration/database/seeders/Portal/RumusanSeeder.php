<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class RumusanSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage('rumusan', [
            ['type' => 'hero', 'id' => 'rm_hero', 'data' => [
                'title_ms' => 'RUMUSAN',
                'title_en' => 'CONCLUSION',
            ]],
            ['type' => 'text', 'id' => 'rm_rumusan', 'data' => [
                'icon'       => '📝',
                'heading_ms' => 'RUMUSAN KESELURUHAN',
                'heading_en' => 'OVERALL CONCLUSION',
                'text_ms'    => "Secara keseluruhannya, latihan industri selama 20 minggu di Opensoft Technologies Sdn Bhd telah memberikan saya pengalaman yang amat berharga dalam bidang pembangunan perisian. Sepanjang tempoh ini, saya telah didedahkan dengan persekitaran kerja sebenar yang jauh berbeza daripada suasana pembelajaran di politeknik.\n\nAntara kemahiran utama yang telah saya peroleh termasuk:\n\n• Kemahiran teknikal dalam pembangunan sistem menggunakan kerangka kerja Laravel, pengurusan pangkalan data MySQL, dan penggunaan sistem kawalan versi Git.\n\n• Kemahiran insaniah seperti komunikasi profesional, kerja berpasukan, pengurusan masa, dan keupayaan menyelesaikan masalah secara sistematik.\n\n• Pemahaman mendalam tentang kitaran hayat pembangunan perisian (SDLC) dari fasa perancangan hingga pelaksanaan dan penyelenggaraan.\n\n• Pendedahan kepada amalan terbaik industri seperti penulisan kod yang bersih, pengujian sistematik, dan dokumentasi yang teratur.\n\nLatihan industri ini juga telah membuka mata saya tentang kepentingan pembelajaran berterusan dalam bidang teknologi maklumat. Teknologi sentiasa berubah dan berkembang, justeru seorang profesional IT perlu sentiasa mengemas kini pengetahuan dan kemahiran mereka untuk kekal relevan dalam industri.\n\nSaya amat bersyukur kerana berpeluang menjalani latihan industri di Opensoft Technologies dan yakin bahawa pengalaman ini akan menjadi asas yang kukuh untuk kerjaya saya dalam bidang teknologi maklumat pada masa hadapan.",
                'text_en'    => "Overall, the 20-week industrial training at Opensoft Technologies Sdn Bhd has given me invaluable experience in the field of software development. Throughout this period, I was exposed to a real working environment that is vastly different from the learning atmosphere at the polytechnic.\n\nAmong the key skills I have acquired include:\n\n• Technical skills in system development using the Laravel framework, MySQL database management, and the use of Git version control systems.\n\n• Soft skills such as professional communication, teamwork, time management, and the ability to solve problems systematically.\n\n• In-depth understanding of the Software Development Life Cycle (SDLC) from the planning phase through implementation and maintenance.\n\n• Exposure to industry best practices such as clean code writing, systematic testing, and organised documentation.\n\nThis industrial training has also opened my eyes to the importance of continuous learning in the field of information technology. Technology is constantly changing and evolving, therefore an IT professional needs to continuously update their knowledge and skills to remain relevant in the industry.\n\nI am truly grateful for the opportunity to undergo industrial training at Opensoft Technologies and am confident that this experience will serve as a solid foundation for my career in information technology in the future.",
            ]],
            ['type' => 'grid-cards', 'id' => 'rm_pencapaian', 'data' => [
                'heading_ms' => 'Pencapaian Utama',
                'heading_en' => 'Key Achievements',
                'items'      => [
                    ['icon' => '💻', 'title_ms' => 'Kemahiran Teknikal', 'title_en' => 'Technical Skills', 'desc_ms' => 'Menguasai pembangunan sistem menggunakan Laravel, pengurusan pangkalan data, dan kawalan versi.', 'desc_en' => 'Mastered system development using Laravel, database management, and version control.'],
                    ['icon' => '🤝', 'title_ms' => 'Kemahiran Insaniah', 'title_en' => 'Soft Skills', 'desc_ms' => 'Meningkatkan kemahiran komunikasi, kerja berpasukan, dan pengurusan masa.', 'desc_en' => 'Enhanced communication, teamwork, and time management skills.'],
                    ['icon' => '📋', 'title_ms' => 'Dokumentasi', 'title_en' => 'Documentation', 'desc_ms' => 'Menyiapkan dokumentasi teknikal dan manual pengguna untuk sistem yang dibangunkan.', 'desc_en' => 'Completed technical documentation and user manuals for developed systems.'],
                    ['icon' => '🎯', 'title_ms' => 'Penyelesaian Masalah', 'title_en' => 'Problem Solving', 'desc_ms' => 'Berjaya menyelesaikan pelbagai cabaran teknikal sepanjang tempoh latihan industri.', 'desc_en' => 'Successfully resolved various technical challenges throughout the industrial training period.'],
                ],
            ]],
        ]);
    }
}
