<?php

declare(strict_types=1);

$appName = env( 'APP_NAME', 'Laravel' );

return [
    'article_post_limit' => (int) env( 'LANDING_ARTICLE_POST_LIMIT', 500 ),
    'default'            => [
        'hero' => [
            'title' => [
                'en' => 'Welcome to ' . $appName,
                'ms' => 'Selamat Datang ke ' . $appName,
            ],
            'subtitle' => [
                'en' => 'A modern Laravel application built with Blade templates.',
                'ms' => 'Aplikasi Laravel moden dibina dengan templat Blade.',
            ],
            'primary_button' => [
                'text' => [
                    'en' => 'Get Started',
                    'ms' => 'Mula Sekarang',
                ],
                'url' => '/login',
            ],
            'secondary_button' => [
                'text' => [
                    'en' => 'Documentation',
                    'ms' => 'Dokumentasi',
                ],
                'url' => 'https://laravel.com/docs',
            ],
        ],
        'banner' => [
            'title' => [
                'en' => 'Launch with a polished first impression',
                'ms' => 'Mulakan dengan tanggapan pertama yang kemas',
            ],
            'subtitle' => [
                'en' => 'Upload a banner image and highlight your most important message.',
                'ms' => 'Muat naik imej banner dan tonjolkan mesej paling penting anda.',
            ],
            'image' => null,
            'alt'   => [
                'en' => '',
                'ms' => '',
            ],
        ],
        'about' => [
            'title' => [
                'en' => 'About ' . $appName,
                'ms' => 'Tentang ' . $appName,
            ],
            'body' => [
                'en' => 'Share the story behind your product and what makes it special.',
                'ms' => 'Kongsi kisah di sebalik produk anda dan apa yang menjadikannya istimewa.',
            ],
            'image' => null,
            'alt'   => [
                'en' => '',
                'ms' => '',
            ],
        ],
        'security' => [
            'title' => [
                'en' => 'Security you can trust',
                'ms' => 'Keselamatan yang anda boleh percaya',
            ],
            'body' => [
                'en' => 'Explain how you protect customer data with privacy-first practices.',
                'ms' => 'Terangkan cara anda melindungi data pelanggan dengan amalan privasi yang utamakan pengguna.',
            ],
            'image' => null,
            'alt'   => [
                'en' => '',
                'ms' => '',
            ],
        ],
        'articles' => [
            [
                'title' => [
                    'en' => 'Product launch checklist',
                    'ms' => 'Senarai semak pelancaran produk',
                ],
                'excerpt' => [
                    'en' => 'A quick guide to help your team launch with confidence.',
                    'ms' => 'Panduan ringkas untuk membantu pasukan anda melancar dengan yakin.',
                ],
                'image' => null,
                'alt'   => [
                    'en' => '',
                    'ms' => '',
                ],
            ],
            [
                'title' => [
                    'en' => 'Designing for conversion',
                    'ms' => 'Reka bentuk untuk penukaran',
                ],
                'excerpt' => [
                    'en' => 'Learn how to shape your landing page for better engagement.',
                    'ms' => 'Pelajari cara membentuk halaman pendaratan anda untuk penglibatan yang lebih baik.',
                ],
                'image' => null,
                'alt'   => [
                    'en' => '',
                    'ms' => '',
                ],
            ],
            [
                'title' => [
                    'en' => 'Security basics for teams',
                    'ms' => 'Asas keselamatan untuk pasukan',
                ],
                'excerpt' => [
                    'en' => 'Practical steps to keep your application secure from day one.',
                    'ms' => 'Langkah praktikal untuk memastikan aplikasi anda selamat sejak hari pertama.',
                ],
                'image' => null,
                'alt'   => [
                    'en' => '',
                    'ms' => '',
                ],
            ],
        ],
        'features' => [
            [
                'icon'  => 'sparkles',
                'title' => [
                    'en' => 'Modular Architecture',
                    'ms' => 'Seni Bina Modular',
                ],
                'description' => [
                    'en' => 'Organized code structure with domain-driven modules for better maintainability.',
                    'ms' => 'Struktur kod tersusun dengan modul berasaskan domain untuk penyelenggaraan yang lebih baik.',
                ],
            ],
            [
                'icon'  => 'shield',
                'title' => [
                    'en' => 'Secure Authentication',
                    'ms' => 'Pengesahan Selamat',
                ],
                'description' => [
                    'en' => 'Built-in authentication.',
                    'ms' => 'Pengesahan terbina dalam.',
                ],
            ],
            [
                'icon'  => 'globe',
                'title' => [
                    'en' => 'Modern UI',
                    'ms' => 'UI Moden',
                ],
                'description' => [
                    'en' => 'Beautiful components and Tailwind CSS for a polished look.',
                    'ms' => 'Komponen menarik dan Tailwind CSS untuk paparan yang kemas.',
                ],
            ],
        ],
        'footer' => [
            'text' => [
                'en' => 'Built with Laravel.',
                'ms' => 'Dibina dengan Laravel.',
            ],
        ],
    ],
];
