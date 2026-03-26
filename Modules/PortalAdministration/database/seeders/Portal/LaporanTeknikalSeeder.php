<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders\Portal;

class LaporanTeknikalSeeder extends PortalPageSeeder
{
    public function run(): void
    {
        $this->seedBlockPage( 'laporan-teknikal', [
            ['type' => 'hero', 'id' => 'lt_hero', 'data' => [
                'subtitle_ms' => 'DOKUMENTASI',
                'subtitle_en' => 'DOCUMENTATION',
                'title_ms'    => 'LAPORAN TEKNIKAL / TUGASAN',
                'title_en'    => 'TECHNICAL REPORT / TASKS',
            ]],

            // --- PENGENALAN ---
            ['type' => 'text', 'id' => 'lt_intro', 'data' => [
                'heading_ms' => 'PENGENALAN',
                'heading_en' => 'INTRODUCTION',
                'text_ms'    => "Laporan Teknikal menjurus kepada tugas-tugas atau kerja yang telah dilaksanakan semasa menjalani latihan industri di Opensoft Technologies Sdn Bhd. Setiap tugasan atau kerja yang diberikan perlulah mengikut proses dan prosedur yang telah ditetapkan dan ianya haruslah dijalankan secara berperingkat. Hal ini bagi memastikan segala pengurusan di organisasi dapat berjalan dengan lancar.\n\nDalam hal ini, pelajar diminta untuk menyatakan segala tugasan yang mereka lakukan semasa menjalani latihan industri di organisasi mereka. Segala tugasan dan kerja yang melibatkan aktiviti dan proses selama 20 minggu hendaklah dilakukan supaya pelajar dapat mengetahui dan mempelajari cara untuk mengendali kerja tersebut dengan baik.\n\nSalah satu tugasan utama yang diberikan kepada saya ialah mempelajari asas pembangunan web menggunakan kerangka kerja Laravel. Laporan teknikal ini mendokumentasikan proses pembelajaran saya secara berperingkat bermula dari konsep asas sehingga pembangunan sistem yang lengkap.",
                'text_en'    => "The Technical Report focuses on the tasks or work carried out during industrial training at Opensoft Technologies Sdn Bhd. Each task or work given must follow the established processes and procedures and should be carried out in stages. This is to ensure that all management in the organisation runs smoothly.\n\nIn this regard, students are required to state all the tasks they performed during their industrial training at their organisation. All tasks and work involving activities and processes over the 20 weeks should be documented so that students can learn how to handle the work properly.\n\nOne of the main tasks assigned to me was learning the basics of web development using the Laravel framework. This technical report documents my learning process progressively from basic concepts to complete system development.",
            ]],

            // --- LATAR BELAKANG ---
            ['type' => 'text', 'id' => 'lt_latarbelakang', 'data' => [
                'heading_ms' => 'LATAR BELAKANG TUGASAN',
                'heading_en' => 'TASK BACKGROUND',
                'text_ms'    => "Laravel merupakan sebuah kerangka kerja (framework) PHP sumber terbuka yang direka khas untuk pembangunan aplikasi web menggunakan seni bina MVC (Model-View-Controller). Ia menjadi pilihan utama di Opensoft Technologies kerana keupayaannya dalam mempercepatkan proses pembangunan, menyediakan struktur kod yang teratur, dan mempunyai ekosistem yang luas.\n\nSebagai pelatih yang baru mula mendalami pembangunan web sebenar, saya perlu memahami konsep asas Laravel termasuk:\n\n• Migration — Untuk mencipta dan mengurus struktur jadual pangkalan data.\n• Seeder — Untuk mengisi data awal (dummy data) ke dalam jadual.\n• Model — Untuk mewakili setiap jadual dan mendefinisikan hubungan antara data.\n• Controller — Untuk menguruskan logik aplikasi dan menghubungkan model dengan paparan.\n• Route — Untuk menentukan URL dan menghubungkannya dengan controller yang berkenaan.\n\nPembelajaran ini penting kerana ia menjadi asas kepada semua tugasan pembangunan sistem yang diberikan sepanjang tempoh latihan industri.",
                'text_en'    => "Laravel is an open-source PHP framework designed specifically for web application development using the MVC (Model-View-Controller) architecture. It is the primary choice at Opensoft Technologies due to its ability to accelerate the development process, provide organised code structure, and have a vast ecosystem.\n\nAs a trainee just starting to explore real web development, I needed to understand the basic concepts of Laravel including:\n\n• Migration — To create and manage database table structures.\n• Seeder — To populate initial (dummy) data into tables.\n• Model — To represent each table and define relationships between data.\n• Controller — To manage application logic and connect models with views.\n• Route — To define URLs and connect them with the relevant controllers.\n\nThis learning is important as it forms the foundation for all system development tasks assigned throughout the industrial training period.",
            ]],

            // --- KAEDAH / PROSEDUR ---
            ['type' => 'text', 'id' => 'lt_kaedah_intro', 'data' => [
                'heading_ms' => 'KAEDAH PELAKSANAAN',
                'heading_en' => 'METHOD OF IMPLEMENTATION',
                'text_ms'    => 'Proses pembelajaran pembangunan web menggunakan Laravel dilaksanakan secara berperingkat selama satu minggu (Minggu 4). Setiap langkah difokuskan kepada satu komponen utama dalam seni bina MVC. Alatan yang digunakan termasuk Laptop, Visual Studio Code sebagai editor kod, GitLab untuk kawalan versi, dan Laragon sebagai pelayan pembangunan tempatan.',
                'text_en'    => 'The process of learning web development using Laravel was carried out progressively over one week (Week 4). Each step was focused on one main component of the MVC architecture. Tools used included a Laptop, Visual Studio Code as the code editor, GitLab for version control, and Laragon as the local development server.',
            ]],

            // --- LANGKAH 1: MIGRATION ---
            ['type' => 'task-showcase', 'id' => 'lt_hari1', 'data' => [
                'heading_ms' => 'LANGKAH 1: MIGRATION',
                'heading_en' => 'STEP 1: MIGRATION',
                'items'      => [
                    [
                        'image'          => 'media/2026/03/7MYSJ98wgROtSOGqmqV3grn3KCbNhJCPjH6qXg8T.png',
                        'image_label_ms' => 'Rajah 1: Contoh fail migration untuk mencipta struktur jadual pangkalan data',
                        'image_label_en' => 'Figure 1: Example migration file for creating database table structure',
                        'title_ms'       => 'Membuat Migration',
                        'title_en'       => 'Creating Migrations',
                        'desc_ms'        => "Migration dalam Laravel berfungsi sebagai 'version control' untuk pangkalan data. Ia membolehkan struktur jadual dicipta, diubah suai, atau dipadam melalui kod PHP tanpa perlu menulis SQL secara manual.\n\nSaya mempelajari cara membuat fail migration menggunakan arahan artisan 'php artisan make:migration'. Setiap fail migration mengandungi dua method utama iaitu up() untuk mencipta jadual dan down() untuk memadamkannya.\n\nSelepas mencipta semua fail migration yang diperlukan, saya menjalankan arahan 'php artisan migrate' untuk mencipta semua jadual secara serentak ke dalam pangkalan data.",
                        'desc_en'        => "Migration in Laravel functions as 'version control' for the database. It allows table structures to be created, modified, or deleted through PHP code without having to write SQL manually.\n\nI learned how to create migration files using the artisan command 'php artisan make:migration'. Each migration file contains two main methods: up() to create the table and down() to delete it.\n\nAfter creating all required migration files, I ran the command 'php artisan migrate' to create all tables simultaneously in the database.",
                        'bullets_ms'     => [],
                        'bullets_en'     => [],
                    ],
                ],
            ]],

            // --- LANGKAH 2: SEEDER ---
            ['type' => 'task-showcase', 'id' => 'lt_hari2', 'data' => [
                'heading_ms' => 'LANGKAH 2: SEEDER',
                'heading_en' => 'STEP 2: SEEDER',
                'items'      => [
                    [
                        'image'          => 'media/2026/03/yO2EBXkWy5Nnf1bjWpwdE6R1GYKj85fYVRfxYtTD.png',
                        'image_label_ms' => 'Rajah 2: Contoh fail seeder untuk mengisi data awal ke dalam pangkalan data',
                        'image_label_en' => 'Figure 2: Example seeder file for populating initial data into database',
                        'title_ms'       => 'Membuat Seeder',
                        'title_en'       => 'Creating Seeders',
                        'desc_ms'        => "Seeder digunakan untuk mengisi data awal ke dalam jadual pangkalan data. Ia sangat berguna semasa pembangunan kerana pembangun tidak perlu memasukkan data secara manual setiap kali pangkalan data direset.\n\nSaya mempelajari cara membuat seeder menggunakan arahan 'php artisan make:seeder' dan cara menulis kod untuk memasukkan data ke dalam jadual. Selepas seeder siap, saya menjalankan arahan 'php artisan db:seed' untuk mengisi semua jadual dengan data awal.\n\nSaya juga mempelajari konsep Factory yang membolehkan data palsu (fake data) dijana secara automatik menggunakan library Faker.",
                        'desc_en'        => "Seeders are used to populate initial data into database tables. They are very useful during development as developers don't need to manually enter data every time the database is reset.\n\nI learned how to create seeders using the command 'php artisan make:seeder' and how to write code to insert data into tables. After the seeders were ready, I ran 'php artisan db:seed' to populate all tables with initial data.\n\nI also learned the Factory concept which allows fake data to be generated automatically using the Faker library.",
                        'bullets_ms'     => [],
                        'bullets_en'     => [],
                    ],
                ],
            ]],

            // --- LANGKAH 3: MODEL ---
            ['type' => 'task-showcase', 'id' => 'lt_hari3', 'data' => [
                'heading_ms' => 'LANGKAH 3: MODEL (ELOQUENT ORM)',
                'heading_en' => 'STEP 3: MODEL (ELOQUENT ORM)',
                'items'      => [
                    [
                        'image'          => 'media/2026/03/dfUHXD0uvyad7BH8qXJRKSWI1R5niHnX3iaK6lWk.png',
                        'image_label_ms' => 'Rajah 3: Contoh Eloquent Model dengan definisi relationship antara jadual',
                        'image_label_en' => 'Figure 3: Example Eloquent Model with relationship definitions between tables',
                        'title_ms'       => 'Membuat Eloquent Model',
                        'title_en'       => 'Creating Eloquent Models',
                        'desc_ms'        => "Model dalam Laravel menggunakan Eloquent ORM untuk mewakili setiap jadual dalam pangkalan data. Setiap model dihubungkan dengan satu jadual dan membolehkan operasi CRUD (Create, Read, Update, Delete) dilakukan tanpa menulis pertanyaan SQL secara manual.\n\nSaya membuat Eloquent model untuk setiap jadual pangkalan data menggunakan arahan 'php artisan make:model'. Saya juga mendefinisikan hubungan (relationship) antara model seperti hasMany(), belongsTo(), dan belongsToMany() untuk menyokong pertanyaan data merentasi jadual.\n\nContohnya, model User mempunyai hubungan hasMany() dengan model Article, bermakna satu pengguna boleh mempunyai banyak artikel.",
                        'desc_en'        => "Models in Laravel use Eloquent ORM to represent each table in the database. Each model is linked to one table and allows CRUD (Create, Read, Update, Delete) operations to be performed without writing SQL queries manually.\n\nI created Eloquent models for each database table using the command 'php artisan make:model'. I also defined relationships between models such as hasMany(), belongsTo(), and belongsToMany() to support cross-table data queries.\n\nFor example, the User model has a hasMany() relationship with the Article model, meaning one user can have many articles.",
                        'bullets_ms'     => [],
                        'bullets_en'     => [],
                    ],
                ],
            ]],

            // --- LANGKAH 4: CONTROLLER ---
            ['type' => 'task-showcase', 'id' => 'lt_hari4', 'data' => [
                'heading_ms' => 'LANGKAH 4: CONTROLLER',
                'heading_en' => 'STEP 4: CONTROLLER',
                'items'      => [
                    [
                        'image'          => 'media/2026/03/3xXVI5MHSDbj7dn6PQWvtE5sP3qxZUi2IvwQnTCW.png',
                        'image_label_ms' => 'Rajah 4: Contoh Controller dengan method CRUD untuk menguruskan logik aplikasi',
                        'image_label_en' => 'Figure 4: Example Controller with CRUD methods for managing application logic',
                        'title_ms'       => 'Membuat Controller',
                        'title_en'       => 'Creating Controllers',
                        'desc_ms'        => "Controller berfungsi sebagai pengantara antara Model dan View dalam seni bina MVC. Ia mengandungi logik aplikasi dan menentukan tindakan yang perlu dilakukan apabila pengguna mengakses URL tertentu.\n\nSaya membuat controller menggunakan arahan 'php artisan make:controller' dengan pilihan --resource untuk menjana method CRUD secara automatik iaitu index(), create(), store(), show(), edit(), update(), dan destroy().\n\nSetiap method dalam controller memanggil model yang berkenaan untuk mendapatkan atau memanipulasi data, kemudian mengembalikan paparan (view) dengan data tersebut kepada pengguna.",
                        'desc_en'        => "Controllers function as intermediaries between Models and Views in the MVC architecture. They contain application logic and determine the actions to be taken when users access specific URLs.\n\nI created controllers using the command 'php artisan make:controller' with the --resource option to automatically generate CRUD methods: index(), create(), store(), show(), edit(), update(), and destroy().\n\nEach method in the controller calls the relevant model to retrieve or manipulate data, then returns the view with that data to the user.",
                        'bullets_ms'     => [],
                        'bullets_en'     => [],
                    ],
                ],
            ]],

            // --- LANGKAH 5: ROUTE ---
            ['type' => 'task-showcase', 'id' => 'lt_hari5', 'data' => [
                'heading_ms' => 'LANGKAH 5: ROUTE',
                'heading_en' => 'STEP 5: ROUTE',
                'items'      => [
                    [
                        'image'          => 'media/2026/03/QPvzPgHpHDfv1YkyKkFaAWfS8T1ojy7hxOPLKtgh.png',
                        'image_label_ms' => 'Rajah 5: Contoh pendaftaran Route dalam fail routes/web.php',
                        'image_label_en' => 'Figure 5: Example Route registration in the routes/web.php file',
                        'title_ms'       => 'Membuat Route',
                        'title_en'       => 'Creating Routes',
                        'desc_ms'        => "Route dalam Laravel menentukan URL yang tersedia dalam aplikasi dan menghubungkannya dengan controller yang berkenaan. Fail route utama terletak di routes/web.php untuk aplikasi web dan routes/api.php untuk API.\n\nSaya mempelajari cara mendaftarkan route menggunakan kaedah seperti Route::get(), Route::post(), Route::put(), dan Route::delete(). Saya juga menggunakan Route::resource() untuk mendaftarkan semua route CRUD secara automatik bagi setiap controller.\n\nSelepas semua route didaftarkan, saya menguji setiap halaman melalui pelayar web untuk memastikan semua URL berfungsi dan menghala ke controller serta paparan yang betul.",
                        'desc_en'        => "Routes in Laravel define the URLs available in the application and connect them with the relevant controllers. The main route file is located at routes/web.php for web applications and routes/api.php for APIs.\n\nI learned how to register routes using methods such as Route::get(), Route::post(), Route::put(), and Route::delete(). I also used Route::resource() to automatically register all CRUD routes for each controller.\n\nAfter all routes were registered, I tested each page through the web browser to ensure all URLs worked and directed to the correct controllers and views.",
                        'bullets_ms'     => [],
                        'bullets_en'     => [],
                    ],
                ],
            ]],

            // --- HASIL ---
            ['type' => 'task-showcase', 'id' => 'lt_hasil', 'data' => [
                'heading_ms' => 'HASIL',
                'heading_en' => 'RESULTS',
                'items'      => [
                    [
                        'image'          => 'media/2026/03/eNG7vDZRlDt7fpK6tgr2gSiP5ZbAEQlRayiLo06D.png',
                        'image_label_ms' => 'Rajah 6: Paparan hasil akhir sistem yang telah dibangunkan',
                        'image_label_en' => 'Figure 6: Final view of the developed system',
                        'title_ms'       => 'Hasil Pembangunan Sistem',
                        'title_en'       => 'System Development Results',
                        'desc_ms'        => "Selepas satu minggu pembelajaran intensif, saya berjaya memahami dan mengaplikasikan konsep asas pembangunan web menggunakan Laravel. Antara hasil yang dicapai termasuk:\n\n• Berjaya mencipta struktur pangkalan data lengkap menggunakan migration dengan lebih daripada 10 jadual.\n• Berjaya mengisi data awal ke dalam semua jadual menggunakan seeder dan factory.\n• Berjaya membina model Eloquent dengan relationship yang betul untuk menyokong pertanyaan data yang kompleks.\n• Berjaya membuat controller dengan method CRUD yang lengkap untuk setiap modul.\n• Berjaya mendaftarkan semua route dan menghubungkannya dengan controller untuk mewujudkan aplikasi web yang berfungsi.\n\nKeseluruhan proses ini telah memberikan saya pemahaman yang kukuh tentang aliran kerja pembangunan aplikasi web menggunakan Laravel dan seni bina MVC.",
                        'desc_en'        => "After one week of intensive learning, I successfully understood and applied the basic concepts of web development using Laravel. Among the results achieved include:\n\n• Successfully created a complete database structure using migrations with more than 10 tables.\n• Successfully populated initial data into all tables using seeders and factories.\n• Successfully built Eloquent models with correct relationships to support complex data queries.\n• Successfully created controllers with complete CRUD methods for each module.\n• Successfully registered all routes and connected them with controllers to create a functioning web application.\n\nThe entire process has given me a solid understanding of the web application development workflow using Laravel and the MVC architecture.",
                        'bullets_ms'     => [],
                        'bullets_en'     => [],
                    ],
                ],
            ]],

            // --- KESIMPULAN ---
            ['type' => 'text', 'id' => 'lt_kesimpulan', 'data' => [
                'heading_ms' => 'KESIMPULAN',
                'heading_en' => 'CONCLUSION',
                'text_ms'    => "Pembelajaran pembangunan web menggunakan kerangka kerja Laravel ini telah memberikan impak yang besar kepada kemahiran teknikal saya. Melalui pendekatan berperingkat dari migration sehingga route, saya berjaya memahami bagaimana setiap komponen dalam seni bina MVC berfungsi dan saling berkait.\n\nPengalaman ini juga mengajar saya tentang kepentingan menulis kod yang terstruktur dan mengikut konvensyen yang ditetapkan. Laravel menyediakan pelbagai kemudahan seperti arahan artisan, Eloquent ORM, dan sistem routing yang mempercepatkan proses pembangunan.\n\nKemahiran yang diperoleh daripada pembelajaran ini menjadi asas yang kukuh untuk saya melaksanakan tugasan pembangunan sistem yang lebih kompleks pada minggu-minggu seterusnya sepanjang tempoh latihan industri.",
                'text_en'    => "Learning web development using the Laravel framework has had a significant impact on my technical skills. Through a progressive approach from migration to routing, I managed to understand how each component in the MVC architecture works and relates to each other.\n\nThis experience also taught me the importance of writing structured code following established conventions. Laravel provides various facilities such as artisan commands, Eloquent ORM, and a routing system that accelerates the development process.\n\nThe skills gained from this learning formed a solid foundation for me to carry out more complex system development tasks in the subsequent weeks throughout the industrial training period.",
            ]],
        ] );
    }
}
