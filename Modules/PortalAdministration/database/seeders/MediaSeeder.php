<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PortalAdministration\Models\Media;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        Media::query()->updateOrCreate(
            ['name' => 'logo'],
            [
                'file_name'  => 'logo.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/03/9QYSvTREqIhtB0vOS2sM48Xo0QiV7vx3zrt7mvgh.png',
                'disk'       => 'public',
                'size'       => 38976,
                'collection' => 'Logo',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'profile'],
            [
                'file_name'  => 'profile.jpeg',
                'mime_type'  => 'image/jpeg',
                'path'       => 'media/2026/03/Hr2cdTUy89BSx10ARvj91jcFPKBtkgDtY8nybFFe.jpg',
                'disk'       => 'public',
                'size'       => 91725,
                'collection' => 'Gambar Ikram',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'opensoft_logo'],
            [
                'file_name'  => 'opensoft_logo.jpg',
                'mime_type'  => 'image/jpeg',
                'path'       => 'media/2026/03/QUMc6Oxeksi48tguONAl2giNSYvhM5YGgo8yLOlU.jpg',
                'disk'       => 'public',
                'size'       => 6728,
                'collection' => 'OST',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'carta-organisasi-opensoft'],
            [
                'file_name'  => 'carta-organisasi-opensoft.jpg',
                'mime_type'  => 'image/jpeg',
                'path'       => 'media/2026/03/jcFSrBNohgu3gNF4TgjVdtDXhFxktWTf6Z9SXw73.jpg',
                'disk'       => 'public',
                'size'       => 8590313,
                'collection' => 'carta-organisasi',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'opensoft_location'],
            [
                'file_name'  => 'opensoft_location.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/03/uYiapMLscFgsa0nBpg6R9u8tqxx7RFqSfPbp3B68.png',
                'disk'       => 'public',
                'size'       => 146836,
                'collection' => '',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'core_business'],
            [
                'file_name'  => 'core_business.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/03/UPloP9UcRm0jMNp5JyVOmR8blR1gVZ45Nk2BFgoW.png',
                'disk'       => 'public',
                'size'       => 61765,
                'collection' => 'core-business',
            ],
        );

        // Laporan teknikal (screenshots; paths match Portal\LaporanTeknikalSeeder)
        Media::query()->updateOrCreate(
            ['name' => 'Screenshot 2026-03-26 100439'],
            [
                'file_name'  => 'Screenshot 2026-03-26 100439.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/03/dfUHXD0uvyad7BH8qXJRKSWI1R5niHnX3iaK6lWk.png',
                'disk'       => 'public',
                'size'       => 162803,
                'collection' => 'model',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'Screenshot 2026-03-26 100536'],
            [
                'file_name'  => 'Screenshot 2026-03-26 100536.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/03/7MYSJ98wgROtSOGqmqV3grn3KCbNhJCPjH6qXg8T.png',
                'disk'       => 'public',
                'size'       => 237614,
                'collection' => 'migration',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'Screenshot 2026-03-26 100613'],
            [
                'file_name'  => 'Screenshot 2026-03-26 100613.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/03/yO2EBXkWy5Nnf1bjWpwdE6R1GYKj85fYVRfxYtTD.png',
                'disk'       => 'public',
                'size'       => 185222,
                'collection' => 'seeder',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'Screenshot 2026-03-26 100721'],
            [
                'file_name'  => 'Screenshot 2026-03-26 100721.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/03/3xXVI5MHSDbj7dn6PQWvtE5sP3qxZUi2IvwQnTCW.png',
                'disk'       => 'public',
                'size'       => 208459,
                'collection' => 'controller',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'Screenshot 2026-03-26 100810'],
            [
                'file_name'  => 'Screenshot 2026-03-26 100810.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/03/QPvzPgHpHDfv1YkyKkFaAWfS8T1ojy7hxOPLKtgh.png',
                'disk'       => 'public',
                'size'       => 203937,
                'collection' => 'route',
            ],
        );

        Media::query()->updateOrCreate(
            ['name' => 'laporan-teknikal-hasil'],
            [
                'file_name'  => 'Screenshot 2026-04-01 124357.png',
                'mime_type'  => 'image/png',
                'path'       => 'media/2026/04/pC3qbUFfLeyp6x75Pp1PozfFwsxroKydg4MnIN89.png',
                'disk'       => 'public',
                'size'       => 405265,
                'collection' => 'hasil',
            ],
        );
    }
}
